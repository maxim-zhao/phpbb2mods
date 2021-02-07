
BEGIN TRANSACTION
GO


ALTER TABLE [phpbb_forums] ADD [auth_cal] [smallint]
GO

UPDATE [phpbb_forums] SET auth_cal = auth_sticky WHERE auth_cal IS NULL
GO

ALTER TABLE [phpbb_forums] WITH NOCHECK ADD
	CONSTRAINT [DF_phpbb_forums_auth_cal] NOT NULL DEFAULT (0) FOR [auth_cal]
GO


ALTER TABLE [phpbb_auth_access] ADD [auth_cal] [smallint]
GO

UPDATE [phpbb_auth_access] SET auth_cal = auth_sticky WHERE auth_cal IS NULL
GO

ALTER TABLE [phpbb_auth_access] WITH NOCHECK ADD
	CONSTRAINT [DF_phpbb_auth_access_auth_cal] NOT NULL DEFAULT (0) FOR [auth_cal]
GO


ALTER TABLE [phpbb_topics] ADD [topic_calendar_time] [int]
GO

ALTER TABLE [phpbb_topics] ADD [topic_calendar_duration] [int]
GO

UPDATE [phpbb_topics] SET topic_calendar_time = 0 WHERE topic_calendar_time IS NULL
GO

UPDATE [phpbb_topics] SET topic_calendar_duration = 0 WHERE topic_calendar_duration IS NULL
GO

ALTER TABLE [phpbb_topics] WITH NOCHECK ADD
	CONSTRAINT [DF_phpbb_topics_topic_calendar_time] NOT NULL DEFAULT (0) FOR [topic_calendar_time],
	CONSTRAINT [DF_phpbb_topics_topic_calendar_duration] NOT NULL DEFAULT (0) FOR [topic_calendar_duration]
GO



ALTER TABLE [phpbb_users] ADD [user_calendar_javascript] [smallint]
GO

ALTER TABLE [phpbb_users] ADD [user_calendar_overview] [smallint]
GO

ALTER TABLE [phpbb_users] ADD [user_calendar_display_open] [smallint]
GO

ALTER TABLE [phpbb_users] ADD [user_calendar_week_start] [smallint]
GO

ALTER TABLE [phpbb_users] ADD [user_calendar_title_length] [int]
GO

ALTER TABLE [phpbb_users] ADD [user_calendar_text_length] [int]
GO

ALTER TABLE [phpbb_users] ADD [user_calendar_header_cells] [smallint]
GO

ALTER TABLE [phpbb_users] ADD [user_calendar_nb_row] [int]
GO

UPDATE [phpbb_users] SET user_calendar_javascript = 0 WHERE user_calendar_javascript IS NULL
GO

UPDATE [phpbb_users] SET user_calendar_overview = 0 WHERE user_calendar_overview IS NULL
GO

UPDATE [phpbb_users] SET user_calendar_display_open = 0 WHERE user_calendar_display_open IS NULL
GO

UPDATE [phpbb_users] SET user_calendar_week_start = 0 WHERE user_calendar_week_start IS NULL
GO

UPDATE [phpbb_users] SET user_calendar_title_length = 0 WHERE user_calendar_title_length IS NULL
GO

UPDATE [phpbb_users] SET user_calendar_text_length = 0 WHERE user_calendar_text_length IS NULL
GO

UPDATE [phpbb_users] SET user_calendar_header_cells = 0 WHERE user_calendar_header_cells IS NULL
GO

UPDATE [phpbb_users] SET user_calendar_nb_row = 0 WHERE user_calendar_nb_row IS NULL
GO

ALTER TABLE [phpbb_users] WITH NOCHECK ADD
	CONSTRAINT [DF_phpbb_users_calendar_javascript] NOT NULL DEFAULT (0) FOR [user_calendar_javascript],
	CONSTRAINT [DF_phpbb_users_calendar_overview] NOT NULL DEFAULT (0) FOR [user_calendar_overview],
	CONSTRAINT [DF_phpbb_users_calendar_display_open] NOT NULL DEFAULT (0) FOR [user_calendar_display_open],
	CONSTRAINT [DF_phpbb_users_calendar_week_start] NOT NULL DEFAULT (0) FOR [user_calendar_week_start],
	CONSTRAINT [DF_phpbb_users_calendar_title_length] NOT NULL DEFAULT (0) FOR [user_calendar_title_length],
	CONSTRAINT [DF_phpbb_users_calendar_text_length] NOT NULL DEFAULT (0) FOR [user_calendar_text_length],
	CONSTRAINT [DF_phpbb_users_calendar_header_cells] NOT NULL DEFAULT (0) FOR [user_calendar_header_cells],
	CONSTRAINT [DF_phpbb_users_calendar_nb_row] NOT NULL DEFAULT (0) FOR [user_calendar_nb_row]
GO

DROP INDEX phpbb_topics.IX_phpbb_topics_TC_1
GO

CREATE INDEX [IX_phpbb_topics_TC_1] ON [phpbb_topics]([topic_calendar_time]) ON [PRIMARY]
GO

COMMIT
GO
