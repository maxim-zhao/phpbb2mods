#
#--[ Config Table ]-------------------------------------
#
DELETE FROM phpbb_config WHERE config_name = 'stat_last_user_session_time';

#
#--[ Forums Table ]-------------------------------------
#
ALTER TABLE phpbb_forums DROP forum_last_user_group_id;
ALTER TABLE phpbb_forums DROP forum_last_user_session_time;

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE phpbb_users CHANGE user_group_id user_group_id MEDIUMINT(8) NOT NULL DEFAULT '5';