CREATE TABLE [phpbb_newsfeeds] (
      [feed_id] Counter NOT NULL CONSTRAINT PK_phpbb_newsfeeds PRIMARY KEY,
      [forum_id] integer NOT NULL,
      [user_id] integer NOT NULL,
      [news_url] varchar(255) NOT NULL ,
      [news_name] varchar(60),
      [news_limit] integer NOT NULL,
      [news_active] bit NOT NULL,
      [include_channel] bit NOT NULL,
      [include_image] bit NOT NULL
    );
CREATE INDEX IX_phpbb_newsfeeds ON phpbb_newsfeeds(forum_id);
