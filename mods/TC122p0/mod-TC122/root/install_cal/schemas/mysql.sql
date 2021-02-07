
ALTER TABLE phpbb_forums ADD auth_cal TINYINT(2) DEFAULT '0' NOT NULL;
UPDATE phpbb_forums SET auth_cal = auth_sticky;

ALTER TABLE phpbb_auth_access ADD auth_cal TINYINT(1) DEFAULT '0' NOT NULL;
UPDATE phpbb_auth_access SET auth_cal = auth_sticky;

ALTER TABLE phpbb_topics ADD topic_calendar_time INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_topics ADD topic_calendar_duration INT( 11 ) NOT NULL DEFAULT '0';

ALTER TABLE phpbb_users ADD user_calendar_javascript TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_calendar_overview TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_calendar_display_open TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_calendar_week_start TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_calendar_title_length SMALLINT( 5 ) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_calendar_text_length SMALLINT( 5 ) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_calendar_header_cells TINYINT( 2 ) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_users ADD user_calendar_nb_row SMALLINT( 5 ) NOT NULL DEFAULT '0';


ALTER TABLE phpbb_topics DROP INDEX topic_calendar_time;
ALTER TABLE phpbb_topics ADD INDEX ( topic_calendar_time );
