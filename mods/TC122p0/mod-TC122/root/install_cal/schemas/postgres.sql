
ALTER TABLE phpbb_forums ADD COLUMN auth_cal int2;
UPDATE phpbb_forums SET auth_cal = auth_sticky WHERE auth_cal IS NULL;
ALTER TABLE phpbb_forums ALTER COLUMN auth_cal SET DEFAULT 0;
ALTER TABLE phpbb_forums ALTER COLUMN auth_cal SET NOT NULL;

ALTER TABLE phpbb_auth_access ADD auth_cal int2;
UPDATE phpbb_auth_access SET auth_cal = auth_sticky WHERE auth_cal IS NULL;
ALTER TABLE phpbb_auth_access ALTER COLUMN auth_cal SET DEFAULT 0;
ALTER TABLE phpbb_auth_access ALTER COLUMN auth_cal SET NOT NULL;


ALTER TABLE phpbb_topics ADD COLUMN topic_calendar_time int4;
ALTER TABLE phpbb_topics ADD COLUMN topic_calendar_duration int4;

UPDATE phpbb_topics SET topic_calendar_time = 0 WHERE topic_calendar_time IS NULL;
UPDATE phpbb_topics SET topic_calendar_duration = 0 WHERE topic_calendar_duration IS NULL;

ALTER TABLE phpbb_topics ALTER COLUMN topic_calendar_time SET DEFAULT 0;
ALTER TABLE phpbb_topics ALTER COLUMN topic_calendar_duration SET DEFAULT 0;

ALTER TABLE phpbb_topics ALTER COLUMN topic_calendar_time SET NOT NULL;
ALTER TABLE phpbb_topics ALTER COLUMN topic_calendar_duration SET NOT NULL;


ALTER TABLE phpbb_users ADD COLUMN user_calendar_javascript int2;
ALTER TABLE phpbb_users ADD COLUMN user_calendar_overview int2;
ALTER TABLE phpbb_users ADD COLUMN user_calendar_display_open int2;
ALTER TABLE phpbb_users ADD COLUMN user_calendar_week_start int2;
ALTER TABLE phpbb_users ADD COLUMN user_calendar_title_length int4;
ALTER TABLE phpbb_users ADD COLUMN user_calendar_text_length int4;
ALTER TABLE phpbb_users ADD COLUMN user_calendar_header_cells int2;
ALTER TABLE phpbb_users ADD COLUMN user_calendar_nb_row int4;

UPDATE phpbb_users SET user_calendar_javascript = 0 WHERE user_calendar_javascript IS NULL;
UPDATE phpbb_users SET user_calendar_overview = 0 WHERE user_calendar_overview IS NULL;
UPDATE phpbb_users SET user_calendar_display_open = 0 WHERE user_calendar_display_open IS NULL;
UPDATE phpbb_users SET user_calendar_week_start = 0 WHERE user_calendar_week_start IS NULL;
UPDATE phpbb_users SET user_calendar_title_length = 0 WHERE user_calendar_title_length IS NULL;
UPDATE phpbb_users SET user_calendar_text_length = 0 WHERE user_calendar_text_length IS NULL;
UPDATE phpbb_users SET user_calendar_header_cells = 0 WHERE user_calendar_header_cells IS NULL;
UPDATE phpbb_users SET user_calendar_nb_row = 0 WHERE user_calendar_nb_row IS NULL;

ALTER TABLE phpbb_users ALTER COLUMN user_calendar_javascript SET NOT NULL;
ALTER TABLE phpbb_users ALTER COLUMN user_calendar_overview SET NOT NULL;
ALTER TABLE phpbb_users ALTER COLUMN user_calendar_display_open SET NOT NULL;
ALTER TABLE phpbb_users ALTER COLUMN user_calendar_week_start SET NOT NULL;
ALTER TABLE phpbb_users ALTER COLUMN user_calendar_title_length SET NOT NULL;
ALTER TABLE phpbb_users ALTER COLUMN user_calendar_text_length SET NOT NULL;
ALTER TABLE phpbb_users ALTER COLUMN user_calendar_header_cells SET NOT NULL;
ALTER TABLE phpbb_users ALTER COLUMN user_calendar_nb_row SET NOT NULL;

DROP INDEX topic_calendar_time_phpbb_topics_index;
CREATE INDEX topic_calendar_time_phpbb_topics_index ON phpbb_topics (topic_calendar_time);
