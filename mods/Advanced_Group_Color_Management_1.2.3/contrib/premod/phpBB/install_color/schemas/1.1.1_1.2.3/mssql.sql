BEGIN TRANSACTION
GO

#
#--[ Themes Table ]-------------------------------------
#
ALTER TABLE [phpbb_themes] ADD [g] [VARCHAR] (6) NOT NULL DEFAULT '';
GO

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE [phpbb_users] ALTER COLUMN [user_group_id] MEDIUMINT(8) NULL;
GO

UPDATE phpbb_users SET user_group_id = NULL WHERE user_group_id = '0';
GO

UPDATE phpbb_users SET user_group_id = '0' WHERE user_id = '-1';
GO

COMMIT
GO