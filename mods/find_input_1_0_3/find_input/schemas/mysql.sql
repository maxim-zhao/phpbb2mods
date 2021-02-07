CREATE TABLE phpbb_newsfeeds (
      feed_id smallint(5) unsigned NOT NULL auto_increment,
      forum_id smallint(5) unsigned NOT NULL default '0',
      user_id mediumint(8) NOT NULL default '0',
      news_url varchar(255) NOT NULL default '',
      news_name varchar(60) default NULL,
      news_limit smallint(5) unsigned NOT NULL default '0',
      news_active tinyint(1) unsigned NOT NULL default '1',
      include_channel tinyint(1) unsigned NOT NULL default '1',
      include_image tinyint(1) unsigned NOT NULL default '1',
      PRIMARY KEY  (feed_id),
      KEY forum_id (forum_id)
    );