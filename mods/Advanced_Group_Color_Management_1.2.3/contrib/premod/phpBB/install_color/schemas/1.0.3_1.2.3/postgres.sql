#
#--[ Config Table ]-------------------------------------
#
INSERT INTO phpbb_config (config_name , config_value) VALUES ('agcm_check', '1');
INSERT INTO phpbb_config (config_name , config_value) VALUES ('agcm_time', '900');

#
#--[ Themes Table ]-------------------------------------
#
ALTER TABLE phpbb_themes ADD COLUMN session_time VARCHAR(6);
ALTER TABLE phpbb_themes ALTER COLUMN session_time SET DEFAULT '';
ALTER TABLE phpbb_themes ALTER COLUMN session_time SET NOT NULL;

ALTER TABLE phpbb_themes ADD COLUMN g0 VARCHAR(6);
ALTER TABLE phpbb_themes ALTER COLUMN g0 SET DEFAULT '';
ALTER TABLE phpbb_themes ALTER COLUMN g0 SET NOT NULL;

ALTER TABLE phpbb_themes ADD COLUMN g VARCHAR(6);
ALTER TABLE phpbb_themes ALTER COLUMN g SET DEFAULT '';
ALTER TABLE phpbb_themes ALTER COLUMN g SET NOT NULL;

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE phpbb_users CHANGE user_group_id user_group_id MEDIUMINT(8);
ALTER TABLE phpbb_users ALTER COLUMN user_group_id SET NULL;

UPDATE phpbb_users SET user_group_id = NULL WHERE user_group_id = '0';
UPDATE phpbb_users SET user_group_id = '0' WHERE user_id = '-1';