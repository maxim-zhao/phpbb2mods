BEGIN TRANSACTION
GO

#
#--[ Config Table ]-------------------------------------
#
DELETE FROM phpbb_config WHERE config_name = 'stat_last_user_session_time';
GO

#
#--[ Forums Table ]-------------------------------------
#
ALTER TABLE [phpbb_forums] DROP [forum_last_user_group_id];
GO

ALTER TABLE [phpbb_forums] DROP [forum_last_user_session_time];
GO

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE [phpbb_users] ALTER COLUMN [user_group_id] MEDIUMINT(8) NOT NULL DEFAULT '5';
GO

COMMIT
GO