#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE phpbb_users CHANGE user_group_id user_group_id MEDIUMINT(8) NOT NULL DEFAULT '5';