# -*- coding: utf-8 -*-
from telegram import (ReplyKeyboardMarkup, ReplyKeyboardRemove, InlineKeyboardMarkup, InlineKeyboardButton, Bot)
from telegram.ext import Updater, CommandHandler, MessageHandler, Filters, ConversationHandler, RegexHandler, CallbackQueryHandler
from Commons import restricted, log_it
from datetime import datetime
from dateutil.parser import parse
import DB_Handler as db

CON_KEY = [[InlineKeyboardButton("⏪", callback_data='PREVIOUS'),
			InlineKeyboardButton("💪", callback_data='TRAIN'),
			InlineKeyboardButton("⏩", callback_data='NEXT')],
			[InlineKeyboardButton("CLOSE", callback_data='CLOSE')]]

CON_KEY_2 = [[InlineKeyboardButton("⏪", callback_data='PREVIOUS'),
			InlineKeyboardButton("💪", callback_data='TRAIN'),
			InlineKeyboardButton("⏩", callback_data='NEXT')],
			[InlineKeyboardButton("CLOSE", callback_data='CLOSE'),
			InlineKeyboardButton("CANCEL ❌", callback_data='CANCELLED ❌')]]

CON_KEY_FULL = [[InlineKeyboardButton("⏪", callback_data='PREVIOUS'), 
				InlineKeyboardButton("📤", callback_data='BCAST'),
				InlineKeyboardButton("🔄", callback_data='RELOAD'),
				InlineKeyboardButton("💪", callback_data='TRAIN'),
				InlineKeyboardButton("⏩", callback_data='NEXT')],
				[InlineKeyboardButton("CONFIRM ✅", callback_data='CONFIRMED ✅'),
				InlineKeyboardButton("CANCEL ❌", callback_data='CANCELLED ❌')],
				[InlineKeyboardButton("CLOSE", callback_data='CLOSE')]]

CON_ALI_VOID = [[InlineKeyboardButton("TIMONEL 🆓", callback_data='TIMONEL')],
				[InlineKeyboardButton("1E 🆓", callback_data='1E'),
				InlineKeyboardButton("1B 🆓", callback_data='1B')],
				[InlineKeyboardButton("2E 🆓", callback_data='2E'),
				InlineKeyboardButton("2B 🆓", callback_data='2B')],
				[InlineKeyboardButton("3E 🆓", callback_data='3E'),
				InlineKeyboardButton("3B 🆓", callback_data='3B')],
				[InlineKeyboardButton("4E 🆓", callback_data='4E'),
				InlineKeyboardButton("4B 🆓", callback_data='4B')],
				[InlineKeyboardButton("BACK ↩️", callback_data='BACK'),
				InlineKeyboardButton("CONFIRM ✅", callback_data='CONFIRMED ✅')]]

ALI_MATRIX =[[''],
			['',''],
			['',''],
			['',''],
			['','']]

ALI_DICT = {'T':0, 'E':0, 'B':1}

FREE = " 🆓"
OK = " 🆗"

def print_alignment(matrix, suplentes):
	alignment = '\n ALIGNMENT:\nT: ' + str(matrix[0][0]) + '\n' 
	alignment = alignment + '1: ' + str(matrix[1][0]) + ' - ' + str(matrix[1][1]) + '\n'
	alignment = alignment + '2: ' + str(matrix[2][0]) + ' - ' + str(matrix[2][1]) + '\n'
	alignment = alignment + '3: ' + str(matrix[3][0]) + ' - ' + str(matrix[3][1]) + '\n'
	alignment = alignment + '4: ' + str(matrix[4][0]) + ' - ' + str(matrix[4][1]) + '\n'
	if(suplentes):
		alignment = alignment + '\n Suplentes:\n'
		for i in suplentes:
			alignment = alignment + str(i) + '\n'
	return alignment

def print_convocation(con):
	keyboard = CON_KEY
	accepted = ''
	for acc in con[5][0]:
		accepted = accepted + str(acc) + ' \n '

	denyed = ''
	for acc in con[5][1]:
		denyed = denyed + str(acc) + ' \n '
	res = ''
	if(con[4][2]):
		res = res + 'Training Type: ' + str(db.get_training_types_name(con[4][2])) + '\n'
	if(accepted != ''):
		res = res + '\nACCEPTED: '+ str(len(con[5][0]))+'\n'+accepted
	if(denyed != ''):
		res = res + '\nDENIED: '+ str(len(con[5][1]))+'\n' + denyed
	if(con[4][0]):
		if(con[6]):
			res = res + '\n' + print_alignment(con[6], con[7])
		res = res +'\n'+con[4][0]
		if(con[4][0] in ('CONFIRMED')):
			keyboard = CON_KEY_2
		elif(con[4][1]):
			res = res + ' - ' + str(db.get_cancel_types_name(con[4][1]))
		if(con[2][2]):
			res = res + '\nElapsed Time: '+str(con[2][2]-con[2][1])
	else:
		keyboard = CON_KEY_FULL
	msg = 'Conv: '+str(con[0])+' - ' + con[2][1].strftime('%d/%m/%Y')+ ' - ' + db.get_team_name(con[3])+'\n\n' + str(con[1])+'\n' + res
	return msg, keyboard

## Convocation Conversation
C_DECIDE, C_CREATE, C_TEXT, C_CANCEL, C_CONFIRM, C_SEND, C_SHOW, C_ALIGNMENT = range(8)
@restricted
def convocations(bot, update):
	log_it(update.message.chat_id, update.message.text, "convocations")
	reply_keyboard = [['CREATE'], ['VIEW']]
	update.message.reply_text('Do you wish to create or view a convocation?',
							reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
	return C_DECIDE

@restricted
def show_results(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "show_results")
	user_data['res'] = db.get_conv_results(update.message.chat_id)
	if(user_data['res']):
		user_data['len'] = len(user_data['res']) - 1
		user_data['ind'] = user_data['len']
		con = user_data['res'][user_data['ind']]
		msg, keyboard = print_convocation(con)
		update.message.reply_text(msg, reply_markup=InlineKeyboardMarkup(keyboard))
		return C_SHOW
	else:
		update.message.reply_text('There are no convocations to show. Maybe some error happened.', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END
	

@restricted
def con_select(bot, update):
	log_it(update.message.chat_id, update.message.text, "con_select")
	temp = []
	if(db.USER_ROLE[update.message.chat_id] == 3):
		res = db.get_team_from_cap(update.message.chat_id)
		for i in res:
			temp.append([i])
	elif(db.USER_ROLE[update.message.chat_id] in (1,4)):
		for name in db.TEAMS.keys():
			temp.append([name])
	if(temp):
		update.message.reply_text('Select the team you want to send the convocation to.',
								reply_markup=ReplyKeyboardMarkup(temp, one_time_keyboard=True))
		return C_TEXT
	else:
		update.message.reply_text('You have no team assigned.', reply_markup=ReplyKeyboardRemove())
		return ConversationHandler.END

@restricted
def con_create2(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "con_create")
	user_data['team'] = update.message.text
	update.message.reply_text('Send me the date for the convocation with the following format: DD/MM/YY HH:MM\n For example: 22/09/19 15:00', reply_markup=ReplyKeyboardRemove())
	return 99

@restricted
def con_create(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "con_create")
	try:
		user_data['datetime'] = parse(update.message.text)
	except:
		st = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
		print(st+"; ID: "+str(update.message.chat_id)+"; WARNING: introduced the following date and failed; "+ update.message.text)
		user_data['datetime'] = datetime.now()

	update.message.reply_text('Send me the text you wish to send to '+user_data['team']+'!', reply_markup=ReplyKeyboardRemove())
	return C_CONFIRM

@restricted
def con_confirm(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "con_confirm")
	reply_keyboard = [['YES'], ['NO']]
	user_data['team']
	user_data['msg'] = update.message.text
	update.message.reply_text('Are you sure you want to send the following text?\n\n'
								+ user_data['msg'],
								reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
	return C_SEND

@restricted
def con_send(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "con_send")
	keyboard = [[InlineKeyboardButton("ACCEPT ✅", callback_data='ACCEPTED ✅_'+str(update.message.message_id)),
                 InlineKeyboardButton("DENY ❌", callback_data='DENIED ❌_'+str(update.message.message_id))]]
	reply_markup = InlineKeyboardMarkup(keyboard)
	user_data['team']
	user_data['msg']
	users_ids = db.get_tm(db.TEAMS[user_data['team']])
	if(not users_ids):
		update.message.reply_text('No users linked to that team.', reply_markup=ReplyKeyboardRemove())
	else:
		for i in users_ids:
			bot.sendMessage(chat_id=i, text=user_data['msg'], reply_markup=reply_markup)
		db.insert_conv(update.message.message_id, user_data['msg'], update.message.chat_id, db.TEAMS[user_data['team']], user_data['datetime'])
		update.message.reply_text('Convocation Send', reply_markup=ReplyKeyboardRemove())
	return ConversationHandler.END

def con_button(bot, update, user_data):
	query = update.callback_query
	log_it(query.from_user.id, query.data, "con_button")
	if(query.data in ('PREVIOUS','NEXT')):
		if(query.data in ('PREVIOUS')):
			if(user_data['ind'] == 0):
				user_data['ind'] = user_data['len']
			else:
				user_data['ind'] = user_data['ind'] - 1
		else:
			if(user_data['ind'] == user_data['len']):
				user_data['ind'] = 0
			else:
				user_data['ind'] = user_data['ind'] + 1

		con = user_data['res'][user_data['ind']]
		msg, keyboard = print_convocation(con)
		reply_markup = InlineKeyboardMarkup(keyboard)

		query.answer()
		try:
			query.edit_message_text(text=msg, reply_markup=reply_markup)
		except:
			log_it(query.from_user.id, query.data, "reload failed")
		return C_SHOW
	elif(query.data in ('BCAST')):
		con = user_data['res'][user_data['ind']]
		users_ids = db.get_tm(con[3])
		msg, keyboard = print_convocation(con)
		
		for u in users_ids:
			bot.sendMessage(chat_id=u, text=msg, reply_markup=ReplyKeyboardRemove())

		query.answer()
		return C_SHOW
	elif(query.data in ('RELOAD')):
		user_data['res'] = db.get_conv_results(query.from_user.id)
		user_data['len'] = len(user_data['res']) - 1
		con = user_data['res'][user_data['ind']]
		
		msg, keyboard = print_convocation(con)
		reply_markup = InlineKeyboardMarkup(keyboard)

		query.answer()
		try:
			query.edit_message_text(text=msg, reply_markup=reply_markup)
		except:
			log_it(query.from_user.id, query.data, "reload failed")
		return C_SHOW
	elif(query.data.split(' ')[0] in ('CONFIRMED')):
		user_data['con_id'] = user_data['res'][user_data['ind']][0]
		user_data['accepted'] = user_data['res'][user_data['ind']][5][0]
		user_data['matrix'] = [[''],['',''],['',''],['',''],['','']]
		user_data['keyboard'] = [[InlineKeyboardButton("TIMONEL 🆓", callback_data='TIMONEL')],
				[InlineKeyboardButton("1E 🆓", callback_data='1E'),
				InlineKeyboardButton("1B 🆓", callback_data='1B')],
				[InlineKeyboardButton("2E 🆓", callback_data='2E'),
				InlineKeyboardButton("2B 🆓", callback_data='2B')],
				[InlineKeyboardButton("3E 🆓", callback_data='3E'),
				InlineKeyboardButton("3B 🆓", callback_data='3B')],
				[InlineKeyboardButton("4E 🆓", callback_data='4E'),
				InlineKeyboardButton("4B 🆓", callback_data='4B')],
				[InlineKeyboardButton("BACK ↩️", callback_data='BACK'),
				InlineKeyboardButton("CONFIRM ✅", callback_data='CONFIRMED ✅')]]
		user_data['count'] = 0
		reply_markup = InlineKeyboardMarkup(user_data['keyboard'])
		query.answer()
		query.edit_message_text("Let's configure the alignment. Select the position you would like to fill.", reply_markup=reply_markup)
		return C_ALIGNMENT
	elif(query.data.split(' ')[0] in ('CANCELLED')):
		temp = db.get_cancel_types()
		user_data['text'] = query.data
		keyboard = []
		if(temp):
			for i in temp:
				keyboard.append([InlineKeyboardButton(str(i[1]), callback_data=i[0])])
		keyboard.append([InlineKeyboardButton('BACK ↩️', callback_data='BACK'), InlineKeyboardButton('ADD NEW TYPE', callback_data='ADD')])
		query.answer()
		query.edit_message_text("Select why you are cancelling the convocation.", reply_markup=InlineKeyboardMarkup(keyboard))
		return C_CANCEL
	elif(query.data.split(' ')[0] in ('TRAIN')):
		temp = db.get_training_types()
		keyboard = []
		if(temp):
			for i in temp:
				keyboard.append([InlineKeyboardButton(str(i[1]), callback_data=i[0])])
		keyboard.append([InlineKeyboardButton('BACK ↩️', callback_data='BACK'), InlineKeyboardButton('ADD NEW TYPE', callback_data='ADD')])
		query.answer()
		query.edit_message_text("Select the training type for this convocation.", reply_markup=InlineKeyboardMarkup(keyboard))
		return 90
	else:
		query.answer()
		query.edit_message_text(query.message.text+'\n\n As of: '+datetime.now().strftime('%Y-%m-%d %H:%M:%S'))
		return ConversationHandler.END

def con_res_button(bot, update):
	query = update.callback_query
	log_it(query.from_user.id, query.data, "con_res_button")
	if(query.data.split(' ')[0] in ('ACCEPTED', 'DENIED')):
		convo = db.get_conv_id(int(query.data.split('_')[1]))
		if(convo[0][3]):
			query.answer()
			query.edit_message_text(text=query.message.text+"\n\nError the convocation has already been closed.")
		else:
			db.insert_conr(int(query.data.split('_')[1]), query.from_user.id, query.data.split(' ')[0])
			query.answer()
			query.edit_message_text(text=query.message.text+"\n\nSelected option: {}".format(query.data.split('_')[0]))
			count = db.get_conr_count(int(query.data.split('_')[1]))
			if(count == 7):
				bot.sendMessage(chat_id=int(db.get_conv_sender(int(query.data.split('_')[1]))), text='There are already '+str(count)+' accepted responses for convocation: '+str(query.data.split('_')[1]))

	else:
		query.answer()
		query.edit_message_text(text='Oops, this conversation timed out, try opening it again.')

def alignment_show(bot, update, user_data):
	query = update.callback_query
	log_it(query.from_user.id, query.data, "alignment_show")
	query.answer()
	if(query.data[0] in ('1', '2', '3', '4')) or (query.data in ('TIMONEL')):
		user_data['current'] = query.data.split(' ')[0]
		full = False
		if(query.data in ('TIMONEL')):
			if(user_data['matrix'][0][0] not in ('')):
				full = True
		else:
			if(user_data['matrix'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]] not in ('')):
				full = True

		if(user_data['accepted']) or full:
			user_data['current'] = query.data.split(' ')[0]
			keyboard = []
			for i in user_data['accepted']:
				keyboard.append([InlineKeyboardButton(str(i), callback_data=str(i))])
			if(query.data in ('TIMONEL')):
				if(user_data['matrix'][0][0] not in ('')):
					keyboard.append([InlineKeyboardButton('Remove User', callback_data='REMOVE')])
			else:
				if(user_data['matrix'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]] not in ('')):
					keyboard.append([InlineKeyboardButton('Remove User', callback_data='REMOVE')])
			query.edit_message_text(text='Select the user you wish to fill the position {} with.'.format(query.data), reply_markup= InlineKeyboardMarkup(keyboard))
		else:
			reply_markup = InlineKeyboardMarkup(user_data['keyboard'])
			try:
				query.edit_message_text("There are no users left to assign.", reply_markup=reply_markup)
			except:
				log_it(query.from_user.id, query.data, "reload failed")
		return C_ALIGNMENT
	elif(query.data.split(' ')[0] in ('CONFIRMED')):
		if(False):
		#if(user_data['count'] < 9) and (user_data['accepted']):
			reply_markup = InlineKeyboardMarkup(user_data['keyboard'])
			try:
				query.edit_message_text("There are still users left to assign.", reply_markup=reply_markup)
			except:
				log_it(query.from_user.id, query.data, "reload failed")
		else:
			users = db.update_conv(user_data['res'][user_data['ind']][0], query.data.split(' ')[0])
			db.insert_alignment(user_data['con_id'], user_data['matrix'], user_data['accepted'])
			alignment = print_alignment(user_data['matrix'], user_data['accepted'])
			if(user_data['res'][user_data['ind']][4][2]):
				temp = '\nTraining Type: ' + str(db.get_training_types_name(user_data['res'][user_data['ind']][4][2]))
			else:
				temp = ''
			msg = str(user_data['res'][user_data['ind']][1]) + temp +'\n\n' + alignment +'\n\nHas been: '+str(query.data)
			for i in users:
				bot.sendMessage(chat_id=i[0], text=msg)
			user_data['res'] = db.get_conv_results(query.from_user.id)
			user_data['len'] = len(user_data['res']) - 1
			con = user_data['res'][user_data['ind']]
			user_data.clear()
			query.answer()
			return ConversationHandler.END
	elif(query.data.split(' ')[0] in ('BACK')):
		user_data.clear()
		user_data['res'] = db.get_conv_results(query.from_user.id)
		if(user_data['res']):
			user_data['len'] = len(user_data['res']) - 1
			user_data['ind'] = user_data['len']
			con = user_data['res'][user_data['ind']]
			
			msg, keyboard = print_convocation(con)
			query.answer()
			query.edit_message_text(text=msg, reply_markup=InlineKeyboardMarkup(keyboard))
			return C_SHOW
		else:
			query.message.delete()
			update.message.reply_text('There are no convocations to show. Maybe some error happened.', reply_markup=ReplyKeyboardRemove())
			return ConversationHandler.END
	else:
		if(query.data in ('REMOVE')):
			user_data['count'] = user_data['count'] - 1
			if(user_data['current'] == 'TIMONEL'):
				user_data['accepted'].append(user_data['matrix'][0][0])
				user_data['matrix'][0] = ['']
				user_data['keyboard'][0] = [InlineKeyboardButton(user_data['current']+FREE, callback_data=user_data['current'])]
			else:
				user_data['accepted'].append(user_data['matrix'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]])
				user_data['matrix'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]] = ''
				user_data['keyboard'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]] = InlineKeyboardButton(user_data['current']+FREE, callback_data=user_data['current'])
		else:
			user_data['count'] = user_data['count'] + 1
			user_data['accepted'].remove(query.data)
			if(user_data['current'] == 'TIMONEL'):
				if(user_data['matrix'][0] != ['']):
					user_data['accepted'].append(user_data['matrix'][0][0])
				user_data['matrix'][0] = [query.data]
				user_data['keyboard'][0] = [InlineKeyboardButton(user_data['current']+': '+query.data, callback_data=user_data['current'])]
			else:
				if(user_data['matrix'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]] != ''):
					user_data['accepted'].append(user_data['matrix'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]])
				user_data['matrix'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]] = query.data
				user_data['keyboard'][int(user_data['current'][0])][ALI_DICT[user_data['current'][1]]] = InlineKeyboardButton(user_data['current']+': '+query.data, callback_data=user_data['current'])
		reply_markup = InlineKeyboardMarkup(user_data['keyboard'])
		query.edit_message_text("Let's configure the alignment. Select the position you would like to fill.", reply_markup=reply_markup)
		return C_ALIGNMENT

def cancel_show(bot, update, user_data):
	query = update.callback_query
	log_it(query.from_user.id, query.data, "cancel_show")
	query.answer()
	if(query.data in ('ADD')):
		query.edit_message_text(text='Send me the new Cancel Type Name.')
		return C_CANCEL
	elif(query.data in ('BACK')):
		con = user_data['res'][user_data['ind']]
		msg, keyboard = print_convocation(con)
		reply_markup = InlineKeyboardMarkup(keyboard)
		query.edit_message_text(text=msg, reply_markup=reply_markup)
		return C_SHOW
	else:
		users = db.update_conv_ct(user_data['res'][user_data['ind']][0], user_data['text'].split(' ')[0], query.data)
		for i in users:
			bot.sendMessage(chat_id=i[0], text=str(user_data['res'][user_data['ind']][1])+'\n\nHas been: '+str(user_data['text']) + '\n' + str(db.get_cancel_types_name(query.data)))
		user_data['res'] = db.get_conv_results(query.from_user.id)
		user_data['len'] = len(user_data['res']) - 1
		query.edit_message_text(text='Convocation ' + user_data['text'])
		return ConversationHandler.END

def cancel_show2(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "cancel_show2")
	ct_id = db.insert_cancel_type(update.message.text)
	users = db.update_conv_ct(user_data['res'][user_data['ind']][0], user_data['text'].split(' ')[0], ct_id)
	for i in users:
		bot.sendMessage(chat_id=i[0], text=str(user_data['res'][user_data['ind']][1])+'\n\nHas been: '+str(user_data['text']) + '\n' + str(db.get_cancel_types_name(ct_id)))
	update.message.reply_text('Convocation ' + user_data['text'], reply_markup=ReplyKeyboardRemove())
	return ConversationHandler.END

def trianing_show(bot, update, user_data):
	query = update.callback_query
	log_it(query.from_user.id, query.data, "trianing_show")
	query.answer()
	if(query.data in ('ADD')):
		query.edit_message_text(text='Send me the new Training Type Name.')
		return 90
	elif(query.data in ('BACK')):
		con = user_data['res'][user_data['ind']]
		msg, keyboard = print_convocation(con)
		reply_markup = InlineKeyboardMarkup(keyboard)
		query.edit_message_text(text=msg, reply_markup=reply_markup)
		return C_SHOW
	else:
		db.update_conv_tt(user_data['res'][user_data['ind']][0], query.data)
		user_data['res'] = db.get_conv_results(query.from_user.id)
		con = user_data['res'][user_data['ind']]
		
		msg, keyboard = print_convocation(con)
		reply_markup = InlineKeyboardMarkup(keyboard)
		query.edit_message_text(text=msg, reply_markup=reply_markup)
		return C_SHOW

def trianing_show2(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "trianing_show2")
	ct_id = db.insert_training_type(update.message.text)
	db.update_conv_tt(user_data['res'][user_data['ind']][0], ct_id)
	user_data['res'] = db.get_conv_results(update.message.chat_id)
	user_data['len'] = len(user_data['res']) - 1
	con = user_data['res'][user_data['ind']]
	msg, keyboard = print_convocation(con)
	reply_markup = InlineKeyboardMarkup(keyboard)
	update.message.reply_text(msg, reply_markup=reply_markup)
	return C_SHOW

def cancel(bot, update, user_data):
	log_it(update.message.chat_id, update.message.text, "cancel")
	user_data.clear()
	update.message.reply_text('Bye! I hope we can talk again some day.',reply_markup=ReplyKeyboardRemove())
	return ConversationHandler.END

CONV_HANDLER = ConversationHandler(entry_points=[CommandHandler('convocations', convocations)],
												states={
												C_DECIDE: [RegexHandler('^(CREATE)$', con_select),
														 RegexHandler('^(VIEW)$', show_results, pass_user_data=True)],
												C_TEXT: [MessageHandler(Filters.text, con_create2, pass_user_data=True)],
												99: [MessageHandler(Filters.text, con_create, pass_user_data=True)],
												C_SEND: [RegexHandler('^(YES)$', con_send, pass_user_data=True),
														 RegexHandler('^(NO)$', con_create, pass_user_data=True)],
												C_CONFIRM: [MessageHandler(Filters.text, con_confirm, pass_user_data=True)],
												C_SHOW: [CallbackQueryHandler(con_button, pass_user_data=True)],
												C_ALIGNMENT: [CallbackQueryHandler(alignment_show, pass_user_data=True)],
												C_CANCEL: [CallbackQueryHandler(cancel_show, pass_user_data=True),
															MessageHandler(Filters.text, cancel_show2, pass_user_data=True)],
												90: [CallbackQueryHandler(trianing_show, pass_user_data=True),
															MessageHandler(Filters.text, trianing_show2, pass_user_data=True)]},
												fallbacks=[CommandHandler('cancel', cancel, pass_user_data=True)],
												conversation_timeout=300)
CONV_B_HANDLER = CallbackQueryHandler(con_res_button)