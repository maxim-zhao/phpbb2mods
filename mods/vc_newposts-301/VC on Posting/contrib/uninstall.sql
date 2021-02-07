#
# Visual Confirmation on New Posters
# MySQL query list for manual uninstall
# December 20, 2006
#
# It is your responsibility to backup your database before using these queries.
#

DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_max_posts';
DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_enable';
DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_type';
DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_webcheck';
DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_rand1';
DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_rand2';
DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_rand3';
DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_rand4';
DELETE FROM phpbb_config WHERE config_name = 'vcnewposts_rand5';