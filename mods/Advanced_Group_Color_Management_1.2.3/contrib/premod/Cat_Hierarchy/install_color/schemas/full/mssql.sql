BEGIN TRANSACTION
GO

#
#--[ Config Table ]-------------------------------------
#
INSERT INTO phpbb_config (config_name , config_value) VALUES ('agcm_check', '1');
GO

INSERT INTO phpbb_config (config_name , config_value) VALUES ('agcm_time', '900');
GO

#
#--[ Groups Table ]-------------------------------------
#
ALTER TABLE [phpbb_groups] ADD [group_weight] [MEDIUMINT] (3) NOT NULL DEFAULT '';
GO

ALTER TABLE [phpbb_groups] ADD [group_legend] [SMALLINT] (1) NOT NULL DEFAULT '';
GO

ALTER TABLE [phpbb_groups] ADD [group_color] [SMALLINT] (1) NOT NULL DEFAULT '';
GO

#
#--[ Themes Table ]-------------------------------------
#
ALTER TABLE [phpbb_themes] ADD [session_time] [VARCHAR] (6) NOT NULL DEFAULT '';
GO

ALTER TABLE [phpbb_themes] ADD [g0] [VARCHAR] (6) NOT NULL DEFAULT '';
GO

ALTER TABLE [phpbb_themes] ADD [g] [VARCHAR] (6) NOT NULL DEFAULT '';
GO

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE [phpbb_users] ADD [user_group_id] [MEDIUMINT] (8) NULL;
GO

UPDATE phpbb_users SET user_group_id = NULL;
GO

UPDATE phpbb_users SET user_group_id = '0' WHERE user_id = '-1';
GO

COMMIT
GO