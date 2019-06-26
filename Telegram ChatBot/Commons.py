from functools import wraps
from datetime import datetime
import DB_Handler as db
## TB FUNCTIONS
def log_it(id, message, func):
	st = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
	print(st+"; ID: "+str(id)+"; Message: "+message+"; Entra a /"+func)
	f = open("TEL_BOT.txt", "a")
	f.write(st+"; ID: "+str(id)+"; Message: "+message+"; Entra a /"+func+'\n')
	f.close()

def restricted(func):
	@wraps(func)
	def wrapped(bot, update, *args, **kwargs):
		user_id = update.effective_user.id
		if user_id not in db.USER_ROLE:
			print("Unauthorized access denied for {}.".format(user_id))
			update.message.reply_text("ACCESS DENIED")
			return
		return func(bot, update, *args, **kwargs)
	return wrapped

def top_restricted(func):
	@wraps(func)
	def wrapped(bot, update, *args, **kwargs):
		user_id = update.effective_user.id
		if(user_id not in db.USER_ROLE) or (db.USER_ROLE[user_id] == 3):
			print("Unauthorized access denied for {}.".format(user_id))
			update.message.reply_text("ACCESS DENIED")
			return
		return func(bot, update, *args, **kwargs)
	return wrapped