# -*- coding: utf-8 -*-
from telegram import (ReplyKeyboardMarkup, ReplyKeyboardRemove, InlineKeyboardMarkup, InlineKeyboardButton, Bot, ParseMode)
from telegram.ext import Updater, CommandHandler, MessageHandler, Filters, ConversationHandler, RegexHandler, CallbackQueryHandler
from Commons import restricted, log_it, top_restricted
import DB_Handler as db

TEAM_INFO = """<strong>Team:</strong> <i>{}</i>
<strong>Team description:</strong> <i>{}</i>
<strong>Team Captain:</strong> <i>{}</i>
<strong>Team members: ({})</strong>"""

DESC, CAPT, CREATE = range(3)
@top_restricted
def t_create(bot, update):
	log_it(update.message.chat_id, update.message.text, "t_create")
	update.message.reply_text('Send me a name for the new Team.')
	return DESC

@top_restricted
def tc_desc_d(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "tc_desc_d")
	if(update.message.text.lower() not in map(str.lower, db.TEAMS.keys())):
		user_data['tname'] = update.message.text
		reply_keyboard = [['YES'],['NO']]
		update.message.reply_text('Do you want to add a description to: '+user_data['tname']+'?', reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
		return DESC
	else:
		update.message.reply_text('The name already exists, try with another one.', reply_markup=ReplyKeyboardRemove())
		return DESC

@top_restricted
def tc_desc(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "tc_desc")
	user_data['tname']
	update.message.reply_text('Send me the description you whish to add to: '+user_data['tname'])
	return CAPT

@top_restricted
def tc_cap_d(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "tc_cap_d")
	user_data['tname']
	if(update.message.text not in ('NO')):
		user_data['tdesc'] = update.message.text
	else:
		user_data['tdesc'] = ''
	reply_keyboard = [['YES'],['NO']]
	update.message.reply_text('Do you want to add a captain to: '+user_data['tname']+'?', reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
	return CAPT

@top_restricted
def tc_cap(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "tc_cap")
	user_data['tname']
	user_data['tdesc']
	temp=[]
	for i in db.USERS.values():
		temp.append([i])
	update.message.reply_text('Select the new captain for: '+user_data['tname'], reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
	return CREATE

@top_restricted
def tc_create(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "tc_cap")
	user_data['tname']
	user_data['tdesc']
	db.insert_team(user_data['tname'], user_data['tdesc'])
	if(update.message.text not in ('NO')):
		cap_id=db.get_user_from_name(update.message.text)
		db.update_team(user_data['tname'], cap_id)
		db.update_user(cap_id, 1)
		db.insert_tm(db.TEAMS[user_data['tname']], cap_id)
		bot.sendMessage(chat_id=cap_id, text='Hy '+update.message.text+', you are now the captain of '+user_data['tname'])
	update.message.reply_text('Team '+ user_data['tname'] + ' created!')
	return ConversationHandler.END

def team_check(bot, update):
	log_it(update.message.chat_id, update.message.text, "team_check")
	temp = []
	if(update.message.chat_id in db.USER_ROLE):
		if(db.USER_ROLE[update.message.chat_id] in (1,4)):
			for name in db.TEAMS.keys():
				temp.append([name])
		else:
			res = db.get_team_from_tm(update.message.chat_id)
			for i in res:
				temp.append([db.get_team_name(i)])
	else:
		res = db.get_team_from_tm(update.message.chat_id)
		for i in res:
			temp.append([db.get_team_name(i)])
	if(temp):
		update.message.reply_text('Select the team where you want to check the members from.',
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
		return 1
	else:
		update.message.reply_text('You have no team assigned.', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END

def team_check_return(bot, update):
	log_it(update.message.chat_id, update.message.text, "team_check_return")
	tm_id = db.TEAMS[update.message.text]
	tm_name, tm_desc, tm_cap = db.get_team_info(tm_id)
	if(tm_name == ''):
		update.message.reply_text('Some error happened', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END
	temp = db.get_tm(tm_id)
	tm_size = len(temp)
	tm_members = ''
	for i in temp:
		tm_members = tm_members + db.USERS[i] + '\n'
	msg = TEAM_INFO.format(db.get_team_name(tm_id), tm_desc, db.USERS[tm_cap], str(tm_size))
	update.message.reply_text(msg +'<i>\n' + tm_members +'</i>', reply_markup=ReplyKeyboardRemove(), parse_mode=ParseMode.HTML)
	return ConversationHandler.END

@top_restricted
def t_del_member(bot, update):
	log_it(update.message.chat_id, update.message.text, "t_del_member")
	temp = []
	if(db.USER_ROLE[update.message.chat_id] in (1,4)):
		for name in db.TEAMS.keys():
			temp.append([name])
	else:
		res = db.get_team_from_tm(update.message.chat_id)
		for i in res:
			temp.append([db.get_team_name(i)])
	if(temp):
		update.message.reply_text('Select the team where you want to delete a member from.',
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
		return 1
	else:
		update.message.reply_text('You have no team assigned.', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END

@top_restricted
def t_del_member_2(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "t_del_member_2")
	user_data['team'] = update.message.text
	tm = db.get_tm(db.TEAMS[user_data['team']])
	temp = []
	for i in tm:
		temp.append([db.USERS[i]])
	if(temp):
		update.message.reply_text('Select the user you want to kick from {}.'.format(user_data['team']),
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
		return 2
	else:
		update.message.reply_text('There are no users left in this team.', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END

@top_restricted
def t_del_member_3(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "t_del_member_3")
	if(update.message.text not in ('NO')):
		temp=[['YES'],['NO']]
		db.del_tm(db.TEAMS[user_data['team']], db.get_user_from_name(update.message.text))
		update.message.reply_text('{} kicked from {}.\n Would you like to kick another one?'.format(update.message.text, user_data['team']),
									reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
		return 2
	else:
		update.message.reply_text('Bye.', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END

@top_restricted
def t_mod(bot, update):
	log_it(update.message.chat_id, update.message.text, "t_mod")
	temp = []
	for name in db.TEAMS.keys():
		temp.append([name])
	if(temp):
		update.message.reply_text('Select the team you want to modify.',
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
		return 1
	else:
		update.message.reply_text('There are no teams.', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END

@top_restricted
def t_mod_2(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "t_mod_2")
	user_data['team'] = update.message.text
	tm_id = db.TEAMS[update.message.text]
	tm_name, tm_desc, tm_cap = db.get_team_info(tm_id)
	if(tm_name == ''):
		update.message.reply_text('Some error happened', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END
	temp = db.get_tm(tm_id)
	tm_size = len(temp)
	user_data['tm_desc'] = tm_desc
	user_data['tm_size'] = str(tm_size)
	user_data['tm_cap']  = db.USERS[tm_cap]
	msg = TEAM_INFO.format(user_data['team'], user_data['tm_desc'], user_data['tm_cap'], user_data['tm_size'])
	update.message.reply_text('This is the current team information:\n\n'+ msg+
								'\n Would you like to modify the description?',
								reply_markup=ReplyKeyboardMarkup([['YES'],['NO']], one_time_keyboard=True),
								parse_mode=ParseMode.HTML)
	return 2

@top_restricted
def t_mod_3(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "t_mod_3")
	update.message.reply_text('Send me the new description for {}.'.format(user_data['team']), reply_markup=ReplyKeyboardRemove())
	return 2

@top_restricted
def t_mod_4(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "t_mod_4")
	if(update.message.text not in ('NO')):
		user_data['tm_desc'] = update.message.text
	msg = TEAM_INFO.format(user_data['team'], user_data['tm_desc'], user_data['tm_cap'], user_data['tm_size'])
	update.message.reply_text('This is the current team information:\n\n'+ msg+
								'\n Would you like to modify the captain?',
								reply_markup=ReplyKeyboardMarkup([['YES'],['NO']], one_time_keyboard=True),
								parse_mode=ParseMode.HTML)
	return 3

@top_restricted
def t_mod_5(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "t_mod_5")
	tm = db.get_tm(db.TEAMS[user_data['team']])
	temp = []
	for i in tm:
		temp.append([db.USERS[i]])
	if(temp):
		update.message.reply_text('Select the new captain for {}.'.format(user_data['team']),
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
		return 3
	else:
		update.message.reply_text('There are no users left in this team.', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END

@top_restricted
def t_mod_6(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "t_mod_6")
	if(update.message.text not in ('NO')):
		user_data['tm_cap'] = update.message.text
	db.update_team2(user_data['team'], user_data['tm_desc'], db.get_user_from_name(user_data['tm_cap']))
	msg = TEAM_INFO.format(user_data['team'], user_data['tm_desc'], user_data['tm_cap'], user_data['tm_size'])
	update.message.reply_text('Team updated.\n\n'+msg, reply_markup=ReplyKeyboardRemove() ,parse_mode=ParseMode.HTML)
	return ConversationHandler.END

@top_restricted
def team_delete(bot, update):
	log_it(update.message.chat_id, update.message.text, "team_delete")
	temp = []
	for i in db.TEAMS.keys():
		temp.append([i])
	update.message.reply_text('Wich Team do you wish to delete?',
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
	return 1

@top_restricted
def team_delete2(bot, update):
	log_it(update.message.chat_id, update.message.text, "team_delete2")
	db.delete_team(db.TEAMS[update.message.text])
	update.message.reply_text('{} Deleted.'.format(update.message.text), reply_markup=ReplyKeyboardRemove())

def cancel(bot, update):
	log_it(update.message.chat_id, update.message.text, "cancel")
	update.message.reply_text('Bye! I hope we can talk again some day.',reply_markup=ReplyKeyboardRemove())
	return ConversationHandler.END


T_HANDLER = ConversationHandler(entry_points=[CommandHandler('t_create', t_create)],
												states={
												DESC: [RegexHandler('^(YES)$', tc_desc, pass_user_data=True),
														RegexHandler('^(NO)$', tc_cap_d, pass_user_data=True),
														MessageHandler(Filters.text, tc_desc_d, pass_user_data=True)],
												CAPT: [RegexHandler('^(YES)$', tc_cap, pass_user_data=True),
														RegexHandler('^(NO)$', tc_create, pass_user_data=True),
														MessageHandler(Filters.text, tc_cap_d, pass_user_data=True)],
												CREATE: [MessageHandler(Filters.text, tc_create, pass_user_data=True)]},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)	
T_2_HANDLER = ConversationHandler(entry_points=[CommandHandler('team_check', team_check)],
												states={
												1: [MessageHandler(Filters.text, team_check_return)]},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)
T_3_HANDLER = ConversationHandler(entry_points=[CommandHandler('t_del_member', t_del_member)],
												states={
												1: [MessageHandler(Filters.text, t_del_member_2, pass_user_data=True)],
												2: [RegexHandler('^(YES)$', t_del_member),
													MessageHandler(Filters.text, t_del_member_3, pass_user_data=True)]},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)
T_4_HANDLER = ConversationHandler(entry_points=[CommandHandler('t_mod', t_mod)],
												states={
												1: [MessageHandler(Filters.text, t_mod_2, pass_user_data=True)],
												2: [RegexHandler('^(YES)$', t_mod_3, pass_user_data=True),
													MessageHandler(Filters.text, t_mod_4, pass_user_data=True)],
												3: [RegexHandler('^(YES)$', t_mod_5, pass_user_data=True),
													MessageHandler(Filters.text, t_mod_6, pass_user_data=True)],
												},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)
T_5_HANDLER = ConversationHandler(entry_points=[CommandHandler('team_delete', team_delete)],
												states={
												1: [MessageHandler(Filters.text, team_delete2)]},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)
