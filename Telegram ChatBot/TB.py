# -*- coding: utf-8 -*-
import logging
import DB_Handler as db
import Convocations as con
import Users as us
import Teams as t
from Commons import log_it
from telegram import (ReplyKeyboardMarkup, ReplyKeyboardRemove, InlineKeyboardMarkup, InlineKeyboardButton, Bot, ParseMode)
from telegram.ext import Updater, CommandHandler, MessageHandler, Filters, ConversationHandler, RegexHandler, CallbackQueryHandler
import CON_PROP as prop

logging.basicConfig(format='%(asctime)s - %(name)s - %(levelname)s - %(message)s', level=logging.INFO, handlers=[
        logging.FileHandler("TEL_BOT.log"),
        logging.StreamHandler()])

tb = Bot(token=prop.bot_code)
tb_up = Updater(tb.token)

db.update_VARS()

def listner(bot, update):
	log_it(update.message.chat_id, update.message.text, "listner")
	update.message.reply_text("I'm not sure what this means, maybe the conversation timed out.")

def start(bot, update):
	log_it(update.message.chat_id, update.message.text, "start")
	if(update.message.chat_id not in db.USERS.keys()):
		update.message.reply_text("Hola,\n veo que aun no estas registrado, puedes mandarme tu nombre y apellido en un mismo mensaje?")
		return 1
	elif(update.message.chat_id in db.PENDING_USERS):
		update.message.reply_text("Hola,\n aun no te han aceptado. No te preocupes, seguro que no tardaran mucho.")
	else:
		update.message.reply_text("Hola de nuevo!")
		print(str(update.message.chat))
	return ConversationHandler.END

def create_user(bot, update):
	log_it(update.message.chat_id, update.message.text, "create_user")
	if(db.check_user_name(update.message.text)):
		update.message.reply_text("Lo siento, "+update.message.text+", este nombre ya esta en uso, puedes enviarnos otro?")
		return 1
	else:
		update.message.reply_text("Genial, "+update.message.text+" te avisare cuando te hayan aceptado!")
		db.insert_user(update.message.chat_id, update.message.text)
		return ConversationHandler.END

def help(bot, update):
	log_it(update.message.chat_id, update.message.text, "help")
	COMMON = """Hello,
Here you have a list with a short descripton of all the commands you are able to use:

<strong>COMMONS:</strong>
/help - Shows the help message.
/menu - Shows the menu.
/cancel - Use it to cancel a conversation.
/user_check - Shows your user information.
/team_check - Shows the Team information and members.

<strong>CONVOCATIONS:</strong>
[ACCEPT ✅] - Use this button to accept the convocation.
[DENY ❌] - Use this button to deny the convocation.
"""

	CAPTAIN="""/convocations - Use this command to start the convocation conversation.
[⏪ or ⏩] - Use this button to move between the last ten convocations.
[📤]- Use this button to share the current convocation status with all the team members.
[🔄] - Use this button to refresh the information.
[💪] - Use this button to link a training type to the current convocation.
[CONFIRM ✅] - Use this button to confirm the convocation.
[CANCEL ❌] - Use this button to cancel the convocation.
[CLOSE] - Use this button to end the conversation end close the buttons.

"""
	ADMIN="""<strong>USER ADMINISTRATION:</strong>
/u_accept - Use this command to accept new registered users.
/u_add - Use this command to add a user to a team.
/user_check_others - Use this command to view information about other users.
/user_delete - Use this command to delete users

<strong>TEAM ADMINISTRATION:</strong>
/t_create - Use this command to create new teams.
/t_del_member - Use this command to delete a team member.
/t_mod - Use this command to modify a team description/captain.
/team_delete - Use this command to delete teams.

"""
	END='\n Thanks for using the bot.\n Feel free to contact @LorenzoHG for futher information.'

	message = COMMON
	if(update.message.chat_id in db.USER_ROLE):
		message = message + CAPTAIN
		if(db.USER_ROLE[update.message.chat_id] != 3):
			message = message + ADMIN
	message = message + END
	
	update.message.reply_text(message, parse_mode=ParseMode.HTML)

START_MENU_ALL = [[InlineKeyboardButton("CHECK USER INFO", callback_data='/user_check'),
			InlineKeyboardButton("CHECK TEAM INFO", callback_data='/team_check')]]
START_MENU_CAP = [[InlineKeyboardButton("CHECK USER INFO", callback_data='/user_check'),
			InlineKeyboardButton("CHECK TEAM INFO", callback_data='/team_check')],
			[InlineKeyboardButton("MANAGE CONVOCATIONS", callback_data='/convocations')]]
START_MENU_FULL = [[InlineKeyboardButton("CHECK USER INFO", callback_data='/user_check'),
			InlineKeyboardButton("CHECK TEAM INFO", callback_data='/team_check')],
			[InlineKeyboardButton("MANAGE CONVOCATIONS", callback_data='/convocations')],
			[InlineKeyboardButton("ACCEPT USERS", callback_data='/u_accept'),
			InlineKeyboardButton("DELETE USERS", callback_data='/user_delete')],
			[InlineKeyboardButton("CHECK USERS", callback_data='/user_check_others')],
			[InlineKeyboardButton("ADD USER TO TEAM", callback_data='/u_add'),
			InlineKeyboardButton("KICK USER FROM TEAM", callback_data='/t_del_member')],
			[InlineKeyboardButton("CREATE TEAM", callback_data='/t_create'),
			InlineKeyboardButton("MODIFY TEAM", callback_data='/t_mod')],
			[InlineKeyboardButton("DELETE TEAM", callback_data='/team_delete')]]
START = [[InlineKeyboardButton("COMMONS", callback_data='/user_check')],
		[InlineKeyboardButton("CONVOCATIONS", callback_data='/user_check')],
		[InlineKeyboardButton("USER ADMINISTRATION", callback_data='/user_check')],
		[InlineKeyboardButton("TEAM ADMINISTRATION", callback_data='/user_check')]]

def menu(bot, update):
	log_it(update.message.chat_id, update.message.text, "menu")
	keyboard = START_MENU_ALL
	if(update.message.chat_id in db.USER_ROLE):
		if(db.USER_ROLE[update.message.chat_id] != 1):
			keyboard= START_MENU_FULL
		else:
			keyboard= START_MENU_CAP
	update.message.reply_text('What would you like to do?',
							reply_markup=InlineKeyboardMarkup(keyboard))
	return 1

def menu_handler(bot, update):
	query = update.callback_query
	log_it(query.from_user.id, query.data, "menu_handler")
	query.answer()
	reply_keyboard = [[str(query.data)]]
	query.message.delete()
	bot.sendMessage(chat_id=query.from_user.id, text='Click the following button:', reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
	return ConversationHandler.END


tb_up.dispatcher.add_handler(con.CONV_HANDLER)
tb_up.dispatcher.add_handler(ConversationHandler(entry_points=[CommandHandler('start', start)],
												states={
												1: [MessageHandler(Filters.text, create_user)]},
												fallbacks=[CommandHandler('cancel', con.cancel)],
												conversation_timeout=300))
tb_up.dispatcher.add_handler(ConversationHandler(entry_points=[CommandHandler('menu', menu)],
												states={
												1: [CallbackQueryHandler(menu_handler)]},
												fallbacks=[CommandHandler('cancel', con.cancel)],
												conversation_timeout=300))
tb_up.dispatcher.add_handler(CommandHandler('help', help))
tb_up.dispatcher.add_handler(con.CONV_B_HANDLER)
tb_up.dispatcher.add_handler(us.U_HANDLER)
tb_up.dispatcher.add_handler(us.U_2_HANDLER)
tb_up.dispatcher.add_handler(us.U_3_HANDLER)
tb_up.dispatcher.add_handler(us.U_4_HANDLER)
tb_up.dispatcher.add_handler(us.U_5_HANDLER)
tb_up.dispatcher.add_handler(t.T_HANDLER)
tb_up.dispatcher.add_handler(t.T_2_HANDLER)
tb_up.dispatcher.add_handler(t.T_3_HANDLER)
tb_up.dispatcher.add_handler(t.T_4_HANDLER)
tb_up.dispatcher.add_handler(t.T_5_HANDLER)
tb_up.dispatcher.add_handler(MessageHandler(Filters.text, listner))

tb_up.start_polling()
tb_up.idle()
