#
#--[ Config Table ]-------------------------------------
#
INSERT INTO phpbb_config (config_name , config_value , config_static) VALUES ('agcm_check', '1', '1');
INSERT INTO phpbb_config (config_name , config_value , config_static) VALUES ('agcm_time', '900', '1');

#
#--[ Groups Table ]-------------------------------------
#
ALTER TABLE phpbb_groups ADD group_weight MEDIUMINT(3) NOT NULL DEFAULT '';
ALTER TABLE phpbb_groups ADD group_legend SMALLINT(1) NOT NULL DEFAULT '';
ALTER TABLE phpbb_groups ADD group_color SMALLINT(1) NOT NULL DEFAULT '';

#
#--[ Themes Table ]-------------------------------------
#
ALTER TABLE phpbb_themes ADD session_time VARCHAR(6) NOT NULL DEFAULT '';
ALTER TABLE phpbb_themes ADD g0 VARCHAR(6) NOT NULL DEFAULT '';

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE phpbb_users ADD user_group_id MEDIUMINT(8) NOT NULL DEFAULT '5';

UPDATE phpbb_users SET user_group_id = '5';
UPDATE phpbb_users SET user_group_id = '0' WHERE user_id = '-1';