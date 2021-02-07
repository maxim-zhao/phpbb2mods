#
# Visual Confirmation on New Posters
# MySQL query list for manual upgrade
# December 20, 2006
#
# It is your responsibility to backup your database before using these queries.
#

INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_max_posts', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_enable', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_type', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_webcheck', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_rand1', '100');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_rand2', '400');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_rand3', '450');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_rand4', '16000');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('vcnewposts_rand5', '67984');
