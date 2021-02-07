CREATE SEQUENCE phpbb_newsfeeds_id_seq start 1 increment 1 maxvalue 2147483647 minvalue 1 cache 1;
CREATE TABLE phpbb_newsfeeds (
      feed_id int4 DEFAULT nextval('phpbb_newsfeeds_id_seq'::text) NOT NULL,
      forum_id int4 default '0' NOT NULL,
      user_id int4 default '0' NOT NULL,
      news_url varchar(255) default '' NOT NULL,
      news_name varchar(60),
      news_limit int4 default '0' NOT NULL,
      news_active int2 default '1' NOT NULL,
      include_channel int2 default '1' NOT NULL,
      include_image int2 default '1' NOT NULL,
      CONSTRAINT phpbb_newsfeeds_pkey PRIMARY KEY (feed_id)
    );
CREATE  INDEX forum_id_phpbb_newsfeeds_index ON phpbb_newsfeeds (forum_id);
