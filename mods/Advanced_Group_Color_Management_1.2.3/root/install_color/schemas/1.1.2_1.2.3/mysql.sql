#
#--[ Themes Table ]-------------------------------------
#
ALTER TABLE phpbb_themes ADD g VARCHAR(6) NOT NULL DEFAULT '';

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE phpbb_users CHANGE user_group_id user_group_id MEDIUMINT(8) NULL;

UPDATE phpbb_users SET user_group_id = NULL WHERE user_group_id = '0';

UPDATE phpbb_users SET user_group_id = '0' WHERE user_id = '-1';