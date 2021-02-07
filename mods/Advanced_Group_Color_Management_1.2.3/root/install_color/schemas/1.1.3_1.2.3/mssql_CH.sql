BEGIN TRANSACTION
GO

#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE [phpbb_users] ALTER COLUMN [user_group_id] MEDIUMINT(8) NOT NULL DEFAULT '5';
GO

COMMIT
GO