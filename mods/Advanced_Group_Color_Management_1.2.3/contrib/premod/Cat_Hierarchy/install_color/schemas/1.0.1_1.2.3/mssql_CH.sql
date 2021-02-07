BEGIN TRANSACTION
GO

#
#--[ Config Table ]-------------------------------------
#
INSERT INTO phpbb_config (config_name , config_value , config_static) VALUES ('agcm_check', '1', '1');
GO

INSERT INTO phpbb_config (config_name , config_value , config_static) VALUES ('agcm_time', '900', '1');
GO

#
#--[ Forums Table ]-------------------------------------
#
ALTER TABLE [phpbb_forums] DROP [forum_last_user_group_id];
GO

#
#--[ Themes Table ]-------------------------------------
#
ALTER TABLE [phpbb_themes] ADD [session_time] [VARCHAR] (6) NOT NULL DEFAULT '';
GO

ALTER TABLE [phpbb_themes] ADD [g0] [VARCHAR] (6) NOT NULL DEFAULT '';
GO

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE [phpbb_users] ALTER COLUMN [user_group_id] MEDIUMINT(8) NOT NULL DEFAULT '5';
GO

UPDATE phpbb_users SET user_group_id = '0' WHERE user_id = '-1';
GO

COMMIT
GO