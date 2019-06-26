# -*- coding: utf-8 -*-
from telegram import (ReplyKeyboardMarkup, ReplyKeyboardRemove, InlineKeyboardMarkup, InlineKeyboardButton, Bot, ParseMode)
from telegram.ext import Updater, CommandHandler, MessageHandler, Filters, ConversationHandler, RegexHandler, CallbackQueryHandler
from Commons import restricted, log_it, top_restricted
import DB_Handler as db

#User Handling
C_SELECT, C_TEAM, C_DECIDE = range(3)

@top_restricted
def u_accept(bot, update):
	log_it(update.message.chat_id, update.message.text, "u_accept")
	if(not db.PENDING_USERS):
		update.message.reply_text('There are no users left to accept.')
		return ConversationHandler.END
	temp=[]
	for i in db.PENDING_USERS:
		temp.append([db.USERS[i]])
	update.message.reply_text('Select the user you want to accept.',
							reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
	return C_SELECT

@top_restricted
def u_add(bot, update):
	log_it(update.message.chat_id, update.message.text, "u_accept")
	temp=[]
	for i in db.get_active_USERS():
		temp.append([i[1]])
	update.message.reply_text('Select the user you want to accept.',
							reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
	return C_SELECT

@top_restricted
def u_team(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "u_team")
	user_data['user'] = update.message.text
	temp=[]
	for i in db.TEAMS.keys():
		temp.append([i])
	update.message.reply_text('Select the team you want '+ user_data['user'] +' to be linked to.',
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
	return C_TEAM

@top_restricted
def u_insert(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "u_team")
	user_data['user']
	temp=dict()
	for i in db.PENDING_USERS:
		temp[db.USERS[i]]=i
	db.update_user(temp[user_data['user']], 0)
	db.insert_tm(db.TEAMS[update.message.text], temp[user_data['user']])
	bot.sendMessage(chat_id=temp[user_data['user']], text='Welcome '+ user_data['user'] + ' you have been added to '+update.message.text)
	if(not db.PENDING_USERS):
		update.message.reply_text(user_data['user'] +' added to '+ update.message.text+'\nThere are no more users left to accept.')
		return ConversationHandler.END
	reply_keyboard = [['YES'],['NO']]
	update.message.reply_text(user_data['user'] +' added to '+ update.message.text+'!\n Do you wish to accept another one?',
								reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
	return C_DECIDE

@top_restricted
def u_insert2(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "u_team")
	user_data['user']
	temp=dict()
	for i in db.USERS:
		temp[db.USERS[i]]=i
	if(temp[user_data['user']] in db.get_tm(db.TEAMS[update.message.text])):
		update.message.reply_text(user_data['user'] +' already forms part of '+ update.message.text+'!')
	else:
		db.insert_tm(db.TEAMS[update.message.text], temp[user_data['user']])
		update.message.reply_text(user_data['user'] +' added to '+ update.message.text+'!')
		bot.sendMessage(chat_id=temp[user_data['user']], text='Welcome '+ user_data['user'] + ' you have been added to '+update.message.text)
	reply_keyboard = [['YES'],['NO']]
	update.message.reply_text('Do you wish to add another one?',
								reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
	return C_DECIDE

def user_check(bot, update):
	log_it(update.message.chat_id, update.message.text, "user_check")
	temp = db.get_user_info(update.message.chat_id)
	if(temp == 0):
		update.message.reply_text('Something went wrong, try again later.')
	else:
		if(temp[3] == 3):
			role = 'Team Captain'
		elif(temp[3] == 4):
			role = 'Section Manager'
		elif(temp[3] == 1):
			role = 'Administrator'
		else:
			role = 'User'
		update.message.reply_text('<strong>Stored User information:</strong>\n\n'+
									'<strong>User Chat ID:</strong> <i>'+str(temp[1])+'</i>\n'+
									'<strong>User Name:</strong> <i>'+str(temp[2])+'</i>\n'+
									'<strong>User Role:</strong> <i>'+str(role)+'</i>', parse_mode=ParseMode.HTML, reply_markup=ReplyKeyboardRemove())

@top_restricted
def user_check_others(bot, update):
	log_it(update.message.chat_id, update.message.text, "user_check_others")
	temp = []
	for i in db.get_active_USERS():
		temp.append([i[1]])
	update.message.reply_text('Wich user do you wish to view?',
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
	return 1

@top_restricted
def user_check_others2(bot, update):
	log_it(update.message.chat_id, update.message.text, "user_check_others2")
	temp = db.get_user_info(db.get_user_from_name(update.message.text))
	if(temp == 0):
		update.message.reply_text('Something went wrong, try again later.')
	else:
		if(temp[3] == 3):
			role = 'Team Captain'
		elif(temp[3] == 4):
			role = 'Section Manager'
		elif(temp[3] == 1):
			role = 'Administrator'
		else:
			role = 'User'
		update.message.reply_text('<strong>Stored User information:</strong>\n\n'+
									'<strong>User Chat ID:</strong> <i>'+str(temp[1])+'</i>\n'+
									'<strong>User Name:</strong> <i>'+str(temp[2])+'</i>\n'+
									'<strong>User Role:</strong> <i>'+str(role)+'</i>', parse_mode=ParseMode.HTML, reply_markup=ReplyKeyboardRemove())
	return ConversationHandler.END

@top_restricted
def user_delete(bot, update):
	log_it(update.message.chat_id, update.message.text, "user_delete")
	temp = []
	for i in db.get_active_USERS():
		temp.append([i[1]])
	update.message.reply_text('Wich user do you wish to delete?',
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
	return 1

@top_restricted
def user_delete2(bot, update):
	log_it(update.message.chat_id, update.message.text, "user_delete2")
	uid = db.get_user_from_name(update.message.text)
	res = db.get_team_from_cap(uid)
	if(res):
		update.message.reply_text('Unable to delete {} because he is a team captain. Try modifying the team first.'.format(update.message.text), reply_markup=ReplyKeyboardRemove())
	else:
		db.del_user(uid)
		update.message.reply_text('{} Deleted.'.format(update.message.text), reply_markup=ReplyKeyboardRemove())


def cancel(bot, update):
	log_it(update.message.chat_id, update.message.text, "cancel")
	update.message.reply_text('Bye! I hope we can talk again some day.',reply_markup=ReplyKeyboardRemove())
	return ConversationHandler.END

U_HANDLER = ConversationHandler(entry_points=[CommandHandler('u_accept', u_accept)],
												states={
												C_SELECT: [MessageHandler(Filters.text, u_team, pass_user_data=True)],
												C_TEAM: [MessageHandler(Filters.text, u_insert, pass_user_data=True)],
												C_DECIDE: [RegexHandler('^(YES)$', u_accept),
														 RegexHandler('^(NO)$', cancel)]},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)
U_2_HANDLER = ConversationHandler(entry_points=[CommandHandler('u_add', u_add)],
												states={
												C_SELECT: [MessageHandler(Filters.text, u_team, pass_user_data=True)],
												C_TEAM: [MessageHandler(Filters.text, u_insert2, pass_user_data=True)],
												C_DECIDE: [RegexHandler('^(YES)$', u_add),
														 RegexHandler('^(NO)$', cancel)]},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)
U_3_HANDLER = CommandHandler('user_check', user_check)
U_4_HANDLER = ConversationHandler(entry_points=[CommandHandler('user_check_others', user_check_others)],
												states={
												1: [MessageHandler(Filters.text, user_check_others2)]},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)
U_5_HANDLER = ConversationHandler(entry_points=[CommandHandler('user_delete', user_delete)],
												states={
												1: [MessageHandler(Filters.text, user_delete2)]},
												fallbacks=[CommandHandler('cancel', cancel)],
												conversation_timeout=300)
