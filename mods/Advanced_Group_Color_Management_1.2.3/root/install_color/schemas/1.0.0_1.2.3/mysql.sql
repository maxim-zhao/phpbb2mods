#
#--[ Config Table ]-------------------------------------
#
INSERT INTO phpbb_config (config_name , config_value) VALUES ('agcm_check', '1');
INSERT INTO phpbb_config (config_name , config_value) VALUES ('agcm_time', '900');

#
#--[ Themes Table ]-------------------------------------
#
ALTER TABLE phpbb_themes ADD session_time VARCHAR(6) NOT NULL DEFAULT '';
ALTER TABLE phpbb_themes ADD g0 VARCHAR(6) NOT NULL DEFAULT '';
ALTER TABLE phpbb_themes ADD g VARCHAR(6) NOT NULL DEFAULT '';

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE phpbb_users CHANGE user_group_id user_group_id MEDIUMINT(8) NULL;

UPDATE phpbb_users SET user_group_id = NULL WHERE user_group_id = '0';
UPDATE phpbb_users SET user_group_id = '0' WHERE user_id = '-1';