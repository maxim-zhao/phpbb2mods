CREATE TABLE [phpbb_newsfeeds] (
      [feed_id] [int] IDENTITY (1, 1) NOT NULL,
      [forum_id] [int] NOT NULL default 0,
      [user_id] [int] NOT NULL default 0,
      [news_url] varchar(255) NOT NULL ,
      [news_name] varchar(60) default NULL,
      [news_limit] [int] NOT NULL default 0,
      [news_active] [smallint] NOT NULL default 1,
      [include_channel] [smallint] NOT NULL default 1,
      [include_image] [smallint] NOT NULL default 1
    ) ON [PRIMARY]
GO

ALTER TABLE [phpbb_newsfeeds] WITH NOCHECK ADD 
	CONSTRAINT [PK_phpbb_newsfeeds] PRIMARY KEY  CLUSTERED 
	(
		[feed_id]
    ) ON [PRIMARY]
GO

CREATE  INDEX [IX_phpbb_newsfeeds] ON [phpbb_newsfeeds]([forum_id]) ON [PRIMARY] 
GO
