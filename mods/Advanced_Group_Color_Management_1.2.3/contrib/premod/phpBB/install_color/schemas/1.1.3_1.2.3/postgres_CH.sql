#
#--[ Users Table ]--------------------------------------
#
ALTER TABLE phpbb_users CHANGE user_group_id user_group_id MEDIUMINT(8);
ALTER TABLE phpbb_users ALTER COLUMN user_group_id SET DEFAULT '5';
ALTER TABLE phpbb_users ALTER COLUMN user_group_id SET NOT NULL;