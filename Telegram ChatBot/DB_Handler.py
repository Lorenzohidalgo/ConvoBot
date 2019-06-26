# -*- coding: utf-8 -*-
from datetime import datetime
import mysql.connector
import re
import ast
import CON_PROP as prop

db = mysql.connector.connect(**prop.db_config)
cur = db.cursor()

USERS, USER_ROLE, TEAMS, TEAM_CAPTAINS = (dict({0:''}), dict(), dict(), dict())
PENDING_USERS = []

## DB FUNCTIONS
def insert_user(chat_id, name):
	global db, cur
	try:
		query = """INSERT INTO bot__users 
					(id, user_chat_id, name, user_role_id, active) VALUES
					(NULL, %s, %s, 2, 0);"""
		var = (chat_id, str(name))
		cur.execute(query, var)
		db.commit()
		global USERS
		global PENDING_USERS
		USERS[chat_id] = name
		PENDING_USERS.append(chat_id)
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		insert_user(chat_id, name)

def get_user_info(u_id):
	global db, cur
	try:
		query = """SELECT * FROM bot__users WHERE user_chat_id = {};""".format(u_id)
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			return res[0]
		else:
			return 0		
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_user_info(u_id)

def check_user_name(name):
	global db, cur
	try:
		query = """SELECT * FROM bot__users WHERE name = '{}';""".format(name)
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			return 1
		else:
			return 0		
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		check_user_name(name)

def update_user(chat_id, user_role):
	global db, cur
	try:
		query = """UPDATE bot__users SET
					user_role_id = %s, active = 1 WHERE
					user_chat_id = %s;"""
		var = (user_role, chat_id)
		cur.execute(query,var)
		db.commit()
		global PENDING_USERS
		if(chat_id in PENDING_USERS):
			PENDING_USERS.remove(chat_id)
		if(user_role != 0):
			USER_ROLE[chat_id] = user_role
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		update_user(chat_id, user_role)

def del_user(user_id):
	global db, cur, USER_ROLE
	try:
		query="""DELETE FROM team_members WHERE tm_user_id = {};""".format(user_id)
		cur.execute(query)
		query = """UPDATE bot__users SET user_role_id = 2, active = 2 WHERE user_chat_id = {};""".format(user_id)
		if(user_id in USER_ROLE):
			del USER_ROLE[user_id]
		cur.execute(query)
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		del_user(user_id)


def insert_team(team_name, team_des):
	global db, cur
	try:
		query = """INSERT INTO teams
					(id, team_name, team_desc, team_capt_id) VALUES
					(NULL, %s, %s, NULL);"""
		var = (str(team_name), str(team_des))
		cur.execute(query, var)
		db.commit()
		global TEAMS
		TEAMS[team_name] = int(cur.lastrowid)
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		insert_team(team_name, team_des)

def get_team_info(team_id):
	global db, cur
	try:
		query = """SELECT * FROM teams WHERE id = {};""".format(team_id)
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			return res[0][1], res[0][2], res[0][3]
		else:
			return '', '', ''
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_team_info(team_id)

def update_team(team_name, cap_id):
	global db, cur
	try:
		query = """SELECT id FROM bot__users WHERE user_chat_id = {};""".format(cap_id)
		cur.execute(query)
		res = cur.fetchall()
		query = """UPDATE teams SET
					team_capt_id = %s WHERE
					id = %s;"""
		var = (res[0][0], TEAMS[team_name])
		cur.execute(query, var)
		db.commit()
		global TEAM_CAPTAINS
		TEAM_CAPTAINS[team_name] = cap_id
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		update_team(team_name, cap_id)

def update_team2(team_name, team_desc, cap_id):
	global db, cur
	try:
		query = """SELECT id FROM bot__users WHERE user_chat_id = {};""".format(cap_id)
		cur.execute(query)
		res = cur.fetchall()
		query = """UPDATE teams SET
					team_capt_id = %s,  team_desc = %s WHERE
					id = %s;"""
		var = (res[0][0], team_desc, TEAMS[team_name])
		cur.execute(query, var)
		db.commit()
		global TEAM_CAPTAINS
		TEAM_CAPTAINS[team_name] = cap_id
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		update_team2(team_name, team_desc, cap_id)

def delete_team(team_id):
	global db, cur, TEAMS
	try:
		query="""DELETE FROM team_members WHERE tm_team_id = {};""".format(team_id)
		cur.execute(query)
		query="""DELETE FROM teams WHERE id = {};""".format(team_id)
		cur.execute(query)
		del TEAMS[get_team_name(team_id)]
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		delete_team(team_id)


def insert_tm(team_id, user_id):
	global db, cur
	try:
		query = """SELECT id FROM bot__users WHERE user_chat_id = {};""".format(user_id)
		cur.execute(query)
		res = cur.fetchall()
		query = """INSERT INTO team_members
					(id, tm_team_id, tm_user_id) VALUES
					(NULL, %s, %s);"""
		var = (team_id, res[0][0])
		cur.execute(query, var)
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		insert_tm(team_id, user_id)

def del_tm(team_id, user_id):
	global db, cur
	try:
		query = """SELECT id FROM bot__users WHERE user_chat_id = {};""".format(user_id)
		cur.execute(query)
		res = cur.fetchall()
		query = """DELETE FROM team_members WHERE tm_team_id = %s AND tm_user_id = %s;"""
		var = (team_id, res[0][0])
		cur.execute(query, var)
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		del_tm(team_id, user_id)

def get_tm(team_id):
	global db, cur
	try:
		query="""SELECT tm_user_id FROM team_members WHERE tm_team_id = {};""".format(team_id)
		cur.execute(query)
		temp = []
		for i in cur.fetchall():
			query = """SELECT user_chat_id FROM bot__users WHERE id = {};""".format(i[0])
			cur.execute(query)
			res = cur.fetchall()
			temp.append(res[0][0])
		return temp
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_tm(team_id)

def get_team_from_tm(user_id):
	global db, cur
	try:
		query = """SELECT id FROM bot__users WHERE user_chat_id = {};""".format(user_id)
		cur.execute(query)
		res = cur.fetchall()
		query="""SELECT tm_team_id FROM team_members WHERE tm_user_id = {};""".format(res[0][0])
		cur.execute(query)
		temp = []
		for i in cur.fetchall():
			temp.append(i[0])
		return temp
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_team_from_tm(user_id)

def insert_conv(con_id, con_text, con_user, con_team, date):
	global db, cur
	try:
		query = """INSERT INTO convocations
					(CON_ID, CON_TEXT, CON_DATE, CON_START_DATE, CON_END_DATE, CON_USER_ID, CON_TEAM_ID, CON_MIN, CON_MAX, CON_STATUS) VALUES
					(%s, %s, %s, %s, NULL, %s, %s, NULL, NULL, NULL);"""
		var = (con_id, str(con_text), date.strftime('%Y-%m-%d %H:%M:%S'), datetime.now().strftime('%Y-%m-%d %H:%M:%S'), con_user, con_team)
		cur.execute(query, var)
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		insert_conv(con_id, con_text, con_user, con_team, date)

def update_conv(con_id, con_status):
	global db, cur
	try:
		query = """UPDATE convocations SET
					CON_STATUS = %s, CON_END_DATE = %s WHERE
					CON_ID = %s;"""
		var = (str(con_status), datetime.now().strftime('%Y-%m-%d %H:%M:%S'), con_id)
		cur.execute(query, var)
		db.commit()
		return get_conr(con_id)
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		update_conv(con_id, con_status)

def update_conv_ct(con_id, con_status, ct_id):
	global db, cur
	try:
		query = """UPDATE convocations SET
					CON_STATUS = %s, CON_END_DATE = %s, CON_CT = %s WHERE
					CON_ID = %s;"""
		var = (str(con_status), datetime.now().strftime('%Y-%m-%d %H:%M:%S'), ct_id, con_id)
		cur.execute(query, var)
		db.commit()
		return get_conr(con_id)
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		update_conv(con_id, con_status)

def update_conv_tt(con_id, tt_id):
	global db, cur
	try:
		query = """UPDATE convocations SET
					CON_TT = %s WHERE
					CON_ID = %s;"""
		var = (tt_id, con_id)
		cur.execute(query, var)
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		update_conv(con_id, tt_id)

def get_my_conv(con_user):
	global db, cur
	try:
		query = """SELECT CON_ID, CON_TEXT, CON_DATE, CON_START_DATE, CON_END_DATE, CON_TEAM_ID, CON_STATUS, CON_CT, CON_TT FROM convocations WHERE CON_USER_ID = {};""".format(con_user)
		cur.execute(query)
		ret = []
		for con_id, con_text, con_date, con_start_date, con_end, con_team, status, ct, tt in cur.fetchall():
			ret.append([con_id, con_text, [con_date, con_start_date, con_end], con_team, [status, ct, tt]])
		return ret
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_my_conv(con_user)

def get_conv():
	global db, cur
	try:
		query = """SELECT CON_ID, CON_TEXT, CON_DATE, CON_START_DATE, CON_END_DATE, CON_TEAM_ID, CON_STATUS, CON_CT, CON_TT FROM convocations;"""
		cur.execute(query)
		ret = []
		for con_id, con_text, con_date, con_start_date, con_end, con_team, status, ct, tt in cur.fetchall():
			ret.append([con_id, con_text, [con_date, con_start_date, con_end], con_team, [status, ct, tt]])
		return ret
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_conv()

def get_conv_id(con_id):
	global db, cur
	try:
		query = """SELECT CON_TEXT, CON_DATE, CON_TEAM_ID, CON_STATUS FROM convocations WHERE CON_ID = {}""".format(con_id)
		cur.execute(query)
		ret = []
		for con_text, con_date, con_team, status in cur.fetchall():
			ret.append([con_text, con_date, con_team, status])
		return ret
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_conv_id(con_id)

def get_conv_sender(con_id):
	global db, cur
	try:
		query = """SELECT CON_USER_ID FROM convocations WHERE CON_ID = {}""".format(con_id)
		cur.execute(query)
		ret = cur.fetchall()
		return ret[0][0]
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_conv_sender(con_id) 

def get_conv_team(con_user, con_team):
	global db, cur
	try:
		query = """SELECT CON_ID, CON_TEXT, CON_DATE, CON_TEAM_ID, CON_STATUS FROM convocations WHERE CON_USER_ID = %s AND CON_TEAM_ID = %s;"""
		var = (con_user, con_team)
		cur.execute(query, var)
		ret = []
		for con_id, con_text, con_date, con_team in cur.fetchall():
			ret.append([con_id, con_text, con_date, con_team, status])
		return ret
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_conv_team(con_user, con_team)

def insert_conr(con_id, user_id, msg):
	global db, cur
	try:
		query = """INSERT INTO con__responses
					(CR_ID, CR_CON_ID, CR_USER_ID, CR_DATE, CR_MSG) VALUES
					(NULL, %s, %s, %s, %s);"""
		var = (con_id, user_id, datetime.now().strftime('%Y-%m-%d %H:%M:%S'), str(msg))
		cur.execute(query, var)
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		insert_conr(con_id, user_id, msg)

def get_conr(con_id):
	global db, cur
	try:
		query = """SELECT CR_USER_ID, CR_MSG FROM con__responses WHERE CR_CON_ID = {};""".format(con_id)
		cur.execute(query)
		ret = []
		for cr_user, cr_msg in cur.fetchall():
			ret.append([cr_user, cr_msg])
		return ret
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_conr(con_id)

def get_conr_count(con_id):
	global db, cur
	try:
		query = """SELECT COUNT(*) FROM con__responses WHERE CR_CON_ID = {} AND CR_MSG = 'ACCEPTED';""".format(con_id)
		cur.execute(query)
		return cur.fetchall()[0][0]
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_conr_count(con_id)

def update_conr(con_id, user_id, msg):
	global db, cur
	try:
		query = """UPDATE con__responses SET
					CR_DATE = %s, CR_MSG = %s WHERE
					CR_CON_ID = %s AND CR_USER_ID = %s;"""
		var = (str(datetime.now().strftime('%Y-%m-%d %H:%M:%S')), str(msg), con_id, user_id)
		cur.execute(query, var)
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		update_conr(con_id, user_id, msg)

def insert_alignment(con_id, matrix, left):
	global db, cur
	try:
		query = """INSERT INTO alignments
					(AL_ID, AL_CON_ID, AL_TIM, AL_1E, AL_1B, AL_2E, AL_2B, AL_3E, AL_3B, AL_4E, AL_4B, AL_LEFT) VALUES
					(NULL, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s);"""
		var = (con_id, get_user_from_name(matrix[0][0]), get_user_from_name(matrix[1][0]), get_user_from_name(matrix[1][1]), get_user_from_name(matrix[2][0]), get_user_from_name(matrix[2][1]), get_user_from_name(matrix[3][0]), get_user_from_name(matrix[3][1]), get_user_from_name(matrix[4][0]), get_user_from_name(matrix[4][1]), str(left))
		cur.execute(query, var)
		db.commit()
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		insert_alignment(con_id, matrix, left)

def get_alignment(con_id):
	global db, cur
	try:
		query = """SELECT * FROM alignments WHERE AL_CON_ID = {};""".format(con_id)
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			res = res[0]
			matrix = [[''], ['',''], ['',''], ['',''], ['','']]
			matrix[0][0] = USERS[res[2]]
			matrix[1][0] = USERS[res[3]]
			matrix[1][1] = USERS[res[4]]
			matrix[2][0] = USERS[res[5]]
			matrix[2][1] = USERS[res[6]]
			matrix[3][0] = USERS[res[7]]
			matrix[3][1] = USERS[res[8]]
			matrix[4][0] = USERS[res[9]]
			matrix[4][1] = USERS[res[10]]
			suplentes = []
			if(ast.literal_eval(res[11])):
				for i in ast.literal_eval(res[11]):
					suplentes.append(USERS[i])
			return matrix, suplentes
		else:
			return [], []
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_alignment(con_id)

def get_cancel_types():
	global db, cur
	try:
		query = """SELECT * FROM cancel__types;"""
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			temp = []
			for i in res:
				temp.append([i[0],i[1]])
			return temp
		else:
			return []
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_cancel_types()

def get_cancel_types_id(ct_name):
	global db, cur
	try:
		query = """SELECT CT_ID FROM cancel__types WHERE CT_NAME = '{}';""".format(ct_name)
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			return res[0][0]
		else:
			return -1
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_cancel_types_id(ct_name)

def get_cancel_types_name(ct_id):
	global db, cur
	try:
		query = """SELECT CT_NAME FROM cancel__types WHERE CT_ID = {};""".format(ct_id)
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			return res[0][0]
		else:
			return ''
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_cancel_types_name(ct_id)

def insert_cancel_type(ct_name):
	global db, cur
	try:
		query = """INSERT INTO cancel__types
					(CT_ID, CT_NAME) VALUES
					(NULL, '{}');""".format(ct_name)
		cur.execute(query)
		db.commit()
		return int(cur.lastrowid)
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		insert_cancel_type(ct_name)

def get_training_types():
	global db, cur
	try:
		query = """SELECT * FROM training__types;"""
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			temp = []
			for i in res:
				temp.append([i[0], i[1]])
			return temp
		else:
			return []
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_training_types()

def get_training_types_id(tt_name):
	global db, cur
	try:
		query = """SELECT TT_ID FROM training__types WHERE TT_NAME = '{}';""".format(tt_name)
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			return res[0][0]
		else:
			return -1
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_training_types_id(tt_name)

def get_training_types_name(tt_id):
	global db, cur
	try:
		query = """SELECT TT_NAME FROM training__types WHERE TT_ID = {};""".format(tt_id)
		cur.execute(query)
		res = cur.fetchall()
		if(res):
			return res[0][0]
		else:
			return ''
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_training_types_name(tt_id)

def insert_training_type(tt_name):
	global db, cur
	try:
		query = """INSERT INTO training__types
					(TT_ID, TT_NAME) VALUES
					(NULL, '{}');""".format(tt_name)
		cur.execute(query)
		db.commit()
		return int(cur.lastrowid)
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		insert_training_type(tt_name)


def get_conv_results(con_user):
	if(USER_ROLE[con_user] == 1):
		conv = get_my_conv(con_user)
	else:
		conv = get_conv()
	ret = []
	if(conv):
		for con in conv:
			res = get_conr(con[0])
			acc = []
			den = []
			for us in res:
				if(us[1] == 'ACCEPTED'):
					acc.append(USERS[us[0]])
				else:
					den.append(USERS[us[0]])
			con.append([acc,den])
			matrix, suplentes = get_alignment(con[0])
			con.append(matrix)
			con.append(suplentes)
			ret.append(con)
	return ret[-10:]



### DICTS HANDLERS
def get_TEAMS():
	global db, cur
	try:
		query = """SELECT id, team_name FROM teams;"""
		cur.execute(query)
		global TEAMS
		TEAMS = dict()
		for val in cur.fetchall():
			TEAMS[val[1]] = val[0]
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_TEAMS()
	

def get_ROLES():
	global db, cur
	try:
		query = """SELECT user_chat_id, user_role_id FROM bot__users WHERE user_role_id != 2;"""
		cur.execute(query)
		global USER_ROLE
		USER_ROLE = dict()
		for val in cur.fetchall():
			USER_ROLE[val[0]] = val[1]
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_ROLES()
	

def get_PENDING():
	global db, cur
	try:
		query = """SELECT user_chat_id FROM bot__users WHERE active = 0;"""
		cur.execute(query)
		global PENDING_USERS
		PENDING_USERS = []
		for i in cur.fetchall():
			PENDING_USERS.append(int(i[0]))
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_PENDING()

def get_active_USERS():
	global db, cur
	try:
		query = """SELECT user_chat_id, name FROM bot__users WHERE active = 1;"""
		cur.execute(query)
		temp = []
		for i in cur.fetchall():
			temp.append([i[0],i[1]])
		return temp
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_active_USERS()


def get_USERS():
	global db, cur
	try:
		query = """SELECT user_chat_id, name FROM bot__users;"""
		cur.execute(query)
		global USERS
		USERS = dict({0:''})
		for i in cur.fetchall():
			USERS[i[0]] = i[1]
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_USERS()

def get_CAPT():
	global db, cur
	try:
		query = """SELECT id, team_capt_id FROM teams;"""
		cur.execute(query)
		global TEAM_CAPTAINS
		TEAM_CAPTAINS = dict()
		for i in cur.fetchall():
			query = """SELECT user_chat_id FROM bot__users WHERE id = {};""".format(i[1])
			cur.execute(query)
			res = cur.fetchall()
			TEAM_CAPTAINS[res[0][0]] = i[0]
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_CAPT()

def get_team_name(tm_id):
	na = ''
	for name, iden in TEAMS.items():
		if(iden == tm_id):
			na = name
	return na

def get_team_from_cap(c_id):
	global db, cur
	try:
		query = """SELECT id FROM bot__users WHERE user_chat_id = {};""".format(c_id)
		cur.execute(query)
		res = cur.fetchall()
		query = """SELECT team_name FROM teams WHERE team_capt_id = {};""".format(res[0][0])
		cur.execute(query)
		temp = []
		for i in cur.fetchall():
			temp.append(i[0])
		return temp
	except:
		db = mysql.connector.connect(**prop.db_config)
		cur = db.cursor()
		get_team_from_cap(c_id)

def get_user_from_name(u_name):
	res = 0
	for u_id, name in USERS.items():
		if name == u_name:
			res = u_id
	return res



def update_VARS():
	get_TEAMS()
	print('Init TEAMS:'+str(TEAMS))
	get_ROLES()
	print('Init USER_ROLE:'+str(USER_ROLE))
	get_PENDING()
	print('Init PENDING_USERS:'+str(PENDING_USERS))
	get_USERS()
	print('Init USERS:'+str(USERS))
	get_CAPT()
	print('Init TEAM_CAPTAINS:'+str(TEAM_CAPTAINS))