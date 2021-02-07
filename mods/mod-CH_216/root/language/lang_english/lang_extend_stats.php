<?php
//
//	file: language/lang_english/lang_extend_stats.php
//	author: ptirhiik
//	begin: 07/02/2006
//	version: 1.6.1 - 23/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}
if ( $is['admin'] )
{
	$lang = (empty($lang) ? array() : $lang) + array(

		// lang file desc
		'Lang_extend_stats' => 'Statistics',
		'Statistics' => 'Statistics',

		// generic
		'Stats_historic' => 'Historic',
		'Stats_year' => 'Last 12 months',
		'Stats_month' => '%s',
		'Stats_day' => '%s',
		'Stats_hour' => '%s',
		'Stats_total' => 'Total',
		'Stats_percent' => '(%.1d%%)',
		'Stats_month_short' => '%s',
		'Stats_day_short' => 'Day %s',
		'Stats_hour_short' => 'Hour %s',
		'Stats_back' => 'Back',

		// stats summary
		'Stats_summary' => 'Summary',
		'Stats_summary_explain' => 'Here you can have a quick overview of your board statistics.',

		// stats registration
		'Stats_register' => 'Registrations',
		'Stats_register_explain' => 'Here you can follow the registrations to the board during the last twelve months.',

		'Stats_not_active' => 'Not active',
		'Stats_active' => 'Active',

		'Stats_no_registration' => 'No registrations',
		'Stats_view_registration' => 'View registrations',
		'Stats_is_active' => 'A',
		'Stats_is_not_active' => 'N',

		// stats visit
		'Stats_visit' => 'Visits to the board',
		'Stats_visit_explain' => 'Here you can analyse the visits to the board the last twelve months.',

		'Stats_guests' => 'Guests',
		'Stats_registered' => 'Registered',
		'Stats_user' => 'User',

		'Stats_userlist' => 'Who was connected ?',
		'Stats_no_connected' => 'No registered users were connected.',
		'Stats_user_deleted' => '*deleted since',
		'Stats_profile_visit' => 'View user\'s visits',

		// stats posting
		'Stats_posting' => 'Posting evolution',
		'Stats_posting_explain' => 'Here you can analize the posting evolution during the last twelve months.',

		'Stats_posts' => 'Replies',
		'Stats_topics' => 'Topics',
		'Stats_user_posts' => 'User replies',
		'Stats_user_topics' => 'User topics',
		'Stats_no_posters' => 'No posters',
		'Stats_view_posters' => 'View posters',
	);
}

?>