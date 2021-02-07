<?php
/***************************************************
 * Project:		Search Data
 * File Name:	admin_search_phrases.php
 * File Path:	admin/
 * Start Date:	22-11-2006 21:38:22
 * Written By:	Joe Belmaati
 * Version #:	1.2.6
 * Last MOD:	13-04-2006 14:40:19
 ***************************************************/

/***************************************************
 * Notes:
 *
 ***************************************************/

define('IN_PHPBB', 1);

/**
 * File specific definitions
 */
define('RESULT_DESCENDING', 1);
define('RESULT_ASCENDING', 2);
define('WORD_DESCENDING', 3);
define('WORD_ASCENDING', 4);
define('SORT_TIME', 0);
define('SORT_POST_SUBJECT', 1);
define('SORT_TOPIC_TITLE', 2);
define('SORT_AUTHOR', 3);
define('SORT_FORUM', 4);
define('SEARCH_FOR_ANY', 0);
define('SEARCH_FOR_ALL', 1);
define('SEARCH_TITLE_MSG', 0);
define('SEARCH_MSG', 1);
define('SEARCH_TITLE', 2);
define('STATUS_OK', 0);
define('STATUS_FAILED', 1);
define('SD_VERSION', '1.2.6');
define('DOWNLOAD_TOPIC', 'http://www.phpbb.com/phpBB/viewtopic.php?t=354124');

/**
 * Load headers
 */
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['General']['Search_phrases'] = $file;
	return;
}

if (!empty($cancel))
{
	$no_page_header = TRUE;
}
elseif (!empty($HTTP_POST_VARS['display_results']))
{
	$no_page_header = TRUE;
}
elseif (!empty($HTTP_POST_VARS['display_words']))
{
	$no_page_header = TRUE;
}
elseif (!empty($HTTP_POST_VARS['sort_reults']))
{
	$no_page_header = TRUE;
}
elseif (!empty($HTTP_POST_VARS['filter']))
{
	$no_page_header = TRUE;
}
elseif (isset($HTTP_GET_VARS['page']))
{
	if ($HTTP_GET_VARS['page'] == 'backup')
	{
		$no_page_header = TRUE;
	}
}
else
{
	$no_page_header = FALSE;
}

require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_searchdata.' . $phpEx);

class searchdata
{
	/**
	 * This class does not need a constructor as all separate
	 * functions process data that is independent of each other.
	 * Therefore we declare and empty constructor.
	 */
	function searchdata() { $this->searchdata = ''; }

	/**
	 * Below follows an explanation of each function. Hopefully
	 * the explanations are clear - if not please do not hesitate
	 * to contact me at belmaati at gmail dot com.
	*/

	/**
	 * This function takes an array and a limiter as it's arguments.
	 * It then strips out empty array values, counts their frequency,
	 * natsort() them, then reverses the results to get max value first,
	 * then reduces the size of the array determined by the limiter
	 * which is settable via the POST variable
	 */
	function search_stats(&$input, $entries, $start = 0)
	{
		$this->input = &$input;
		$this->entries = $entries;
		$this->start = $start;
		$this->input = array_filter($this->input);
		$this->input = array_count_values($this->input);
		natsort($this->input);
		$this->input = array_reverse($this->input);
		$this->input = array_slice($this->input, $this->start, $this->entries);
		return $this->input;
	}

	/**
	 * This function is identical to search_stats(); except it does
	 * not reduce the size of the array, as results will be wrong when
	 * reverse sorting.
	 */
	function search_word_stats(&$input)
	{
		$this->input = &$input;
		$this->input = array_filter($this->input);
		$this->input = array_count_values($this->input);
		natsort($this->input);
		$this->input = array_reverse($this->input);
		return $this->input;
	}

	/**
	 * This function is identical to search_stats_max(); except it limits
	 * the array size to a single element for max stats purposes. That should
	 * save server memory.
	 */
	function search_word_stats_max(&$input)
	{
		$this->input = &$input;
		$this->input = array_filter($this->input);
		$this->input = array_count_values($this->input);
		natsort($this->input);
		$this->input = array_reverse($this->input);
		$this->input = array_slice($this->input, 0, 1);
		return $this->input;
	}

	/**
	 * This function takes an array, an array size limiter, a start
	 * variable, and a sort variable. It helps generate "fake" pagination
	 * and sort options for the Words page.
	 */
	function search_options(&$input, $entries, $start = 0, $sort_options)
	{
		$this->input = &$input;
		$this->entries = $entries;
		$this->start = $start;
		$this->sort_options = $sort_options;
		$this->sort_options;
		$input = array_slice($this->input, $this->start, $this->entries);
		return $this->input;
	}

	/**
	 * This function takes an array, a limiter, and an array element
	 * to be inserted into the array as it's arguments.
	 * It then strips out empty array values, inserts the additional
	 * element into the array, counts array value frequency,
	 * natsort() them, then reverses the results to get max value first,
	 * then reduces the size of the array determined by the limiter
	 * which is settable via the POST variable
	 */
	function search_stats_forum(&$input, $entries, $addentry)
	{
		$this->input = &$input;
		$this->entries = $entries;
		$this->addentry = $addentry;
		$this->input = array_filter($this->input);
		$this->input = array_count_values($this->input);
		$this->input = $this->input + $this->addentry;
		natsort($this->input);
		$this->input = array_reverse($this->input);
		$this->input = array_slice($this->input, 0, $this->entries);
		return $this->input;
	}

	/**
	 * A very simple function to assign lang variables to database
	 * values
	 */
	function search_terms($input)
	{
		global $lang;
		$this->input = $input;
		$this->output = $output;
		$this->output = ($this->input == SEARCH_FOR_ALL) ? $lang['Search_for_all'] : $lang['Search_for_any'];
		return $this->output;
	}

	/**
	 * Another very simple function to assign lang variables to database
	 * values
	 */
	function search_fields($input)
	{
		global $lang;
		$this->input = $input;
		$this->output = $output;

		switch($this->input)
		{
			case SEARCH_TITLE_MSG:
				$this->output = $lang['Search_title_msg'];
				break;

			case SEARCH_MSG:
				$this->output = $lang['Search_msg_only'];
				break;

			case SEARCH_TITLE:
				$this->output = $lang['Search_title_only'];
				break;
		}
		return $this->output;
	}

	/**
	 * Yet another very simple function to assign lang variables to database
	 * values
	 */
	function sort_by($input)
	{
		global $lang;
		$this->input = $input;
		$this->output = $output;

		switch($this->input)
		{
			case SORT_TIME:
				$this->output = $lang['Sort_Time'];
				break;

			case SORT_POST_SUBJECT:
				$this->output = $lang['Sort_Post_Subject'];
				break;

			case SORT_TOPIC_TITLE:
				$this->output = $lang['Sort_Topic_Title'];
				break;

			case SORT_AUTHOR:
				$this->output = $lang['Sort_Author'];
				break;

			case SORT_FORUM:
				$this->output = $lang['Sort_Forum'];
				break;

			default:
				$this->output = $lang['Sort_Time'];
				break;
		}
		return $this->output;
	}

	/**
	 * Just a small function that calculates average frequency
	 */
	function percentage($value, $count_rows)
	{
		$this->value = $value;
		$this->count_rows = $count_rows;
		$this->percentage = round(100 * $this->value / $this->count_rows, 3);
		return $this->percentage;
	}
}

/**
 * Instantiate the class. Pass by ref.
 */
$searchdata = &new searchdata();

/**
 * The program begins here
 */
$page = (isset($HTTP_GET_VARS['page'])) ? htmlspecialchars($HTTP_GET_VARS['page']) : 'phrases';
$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
$confirm = (isset($HTTP_POST_VARS['confirm'])) ? TRUE : FALSE;
$cancel = (isset($HTTP_POST_VARS['cancel'])) ? TRUE : FALSE;
$delete = (isset($HTTP_POST_VARS['delete'])) ? TRUE : FALSE;
$purge = (isset($HTTP_POST_VARS['purge'])) ? TRUE : FALSE;
$find = (isset($HTTP_POST_VARS['find'])) ? trim($HTTP_POST_VARS['find']) : '';
$cookie = $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sd'];

/**
 * Statistics
 */
if ($page == 'stats')
{
	$template->set_filenames(array( 'body' => 'admin/search_phrases_stats.tpl' ));

	$cookie = unserialize(stripslashes($cookie));
	$config_array = unserialize($board_config['search_data']);

	$check_config = array
	(
		$config_array['p'],
		$config_array['u'],
		$config_array['r'],
		$config_array['i'],
		$config_array['f'],
		$config_array['c'],
		$config_array['a'],
		$config_array['t'],
		$config_array['flds'],
		$config_array['sb'],
		$config_array['sd']
	);

	if (array_sum($check_config) == 0)
	{
		$template->assign_block_vars('switch_no_config', array());
	}

	if (isset($HTTP_POST_VARS['display_results']))
	{
		$display_results = $HTTP_POST_VARS['display_results'];

		$cookiedata = array
		(
			'display_results' => $display_results,
			'display_words' => $cookie['display_words'],
			'filter' => $cookie['filter'],
			'sort_results' => $cookie['sort_results'],
			'finddata' => $cookie['finddata']
		);

		setcookie($board_config['cookie_name'] . '_sd', serialize($cookiedata), time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
		redirect('admin/' . append_sid("admin_search_phrases.$phpEx?page=stats", true));
	}
	elseif (!empty($cookie['display_results']))
	{
		$display_results = $cookie['display_results'];
	}
	else
	{
		$display_results = 10;
	}

	$timespan = '';

	if (isset($HTTP_POST_VARS['beginspan']) && isset($HTTP_POST_VARS['endspan']))
	{
		$beginspan = strtotime($HTTP_POST_VARS['beginspan']);
		$endspan = strtotime($HTTP_POST_VARS['endspan']);
		$timespan = "AND search_time BETWEEN $beginspan AND $endspan";
		$template->assign_block_vars('switch_date_specific_stats', array());
	}

	if ($endspan < $beginspan)
	{
		$message = $lang['Invalid_datespan'] . "<br /><br />" . sprintf($lang['Click_return_search_stats'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=stats") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
		message_die(GENERAL_ERROR, $message);
	}

	$sql = "SELECT s.*, username
	FROM " . SEARCH_PHRASES_TABLE . " s, " . USERS_TABLE . " u
	WHERE s.search_user_id = u.user_id
	$timespan";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain search data');
	}

	$count_rows = $db->sql_numrows($result);

	if ($count_rows == 0)
	{
		$message = $lang['No_search_phrases'] . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}

	/**
	 * This is where we create all the arrays for the statistics.
	 * This procedure is likely memory heavy, but I created this
	 * in a way that minumum strain would be put on the search
	 * process itself. Therefore we do all the number crunching
	 * here instead. We're freeing up memory at the end of this
	 * page.
	 */

	$phrases = array();

	$searchers = array();

	$referers = array();

	$searchtime = array();

	$searchstatus = array();

	$ips = array();

	$terms = array();

	$fields = array();

	$sortby = array();

	$sortdir = array();

	$authors = array();

	while ($row = $db->sql_fetchrow($result))
	{
		$searchtime[] = $row['search_time'];
		$searchstatus[] = $row['search_failed'];
		/**
		 * Insert a dot in order to force the array key to be read
		 * as a string before we pass the array through array_reverse();
		 * Leaving a numeric array key will cause that key to be renumbered
		 * when passing the array through array_reverse(); Neither settype($var, "string"),
		 * nor strval($var) will work here.
		 */
		$phrases[] = ($config_array['p']) ? '.' . trim($row['search_phrase']) : '';
		$searchers[] = ($config_array['u']) ? $row['username'] : '';
		$referers[] = ($config_array['r']) ? $row['search_referer'] : '';
		$ips[] = ($config_array['i']) ? $row['search_user_ip'] : '';
		$terms[] = ($config_array['t']) ? $searchdata->search_terms($row['search_terms']) : '';
		$fields[] = ($config_array['flds']) ? $searchdata->search_fields($row['search_fields']) : '';
		$sortby[] = ($config_array['sb']) ? $searchdata->sort_by($row['search_sort_by']) : '';
		$sortdir[] = ($config_array['sd']) ? $row['search_sort_dir'] : '';
		$authors[] = ($config_array['a']) ? $row['search_author'] : '';
	}

	/**
	 * Display drop down box
	 */
	$result_values = array
	(
		5,
		10,
		25,
		50,
		75,
		100,
		$count_rows
	);

	$result_values_lang = array
	(
		5,
		10,
		25,
		50,
		75,
		100,
		$lang['All']
	);

	$select_results = '<select name="display_results">';

	for ($i = 0; $i < count($result_values); $i++)
	{
		$selected = ($display_results == $result_values[$i]) ? ' selected="selected"' : '';
		$select_results .= '<option value="' . $result_values[$i] . '"' . $selected . '>' . $result_values_lang[$i] . '</option>';
	}

	$select_results .= '</select>';

	/**
	 * Run all the arrays through our stats function
	 */
	$num_phrases = (!empty($phrases)) ? $searchdata->search_stats($phrases, $display_results) : '';
	$num_searchers = (!empty($searchers)) ? $searchdata->search_stats($searchers, $display_results) : '';
	$num_referers = (!empty($referers)) ? $searchdata->search_stats($referers, $display_results) : '';
	$num_ips = (!empty($ips)) ? $searchdata->search_stats($ips, $display_results) : '';
	$num_authors = (!empty($authors)) ? $searchdata->search_stats($authors, $display_results) : '';
	$num_terms = (!empty($terms)) ? $searchdata->search_stats($terms, $display_results) : '';
	$num_fields = (!empty($fields)) ? $searchdata->search_stats($fields, $display_results) : '';
	$num_sortby = (!empty($sortby)) ? $searchdata->search_stats($sortby, $display_results) : '';
	$num_sortdir = (!empty($sortdir)) ? $searchdata->search_stats($sortdir, $display_results) : '';

	/**
	 * The searchtime array is used to calculate general stats. If the array keys get
	 * ruffled - for example if purging, then restoring at a later date when new entries
	 * have been inserted into the database $searchtime[0] will likely return the wrong
	 * result. Therefore we sort() the array - AND - the array keys will be re-ordered
	 * which is exactly what we want :-)
	 */
	sort($searchtime);

	$first_search = create_date($board_config['default_dateformat'], $searchtime[0], $board_config['board_timezone']);
	$last_search = create_date($board_config['default_dateformat'], end($searchtime), $board_config['board_timezone']);
	$days_active = floor((end($searchtime) - $searchtime[0]) / 86400);
	$days_active = ($days_active == 0) ? 1 : $days_active;
	$searches_per_day = round($count_rows / $days_active, 1);

	/**
	 * Now that we don't need these arrays anymore we
	 * delete them in order to save server memory.
	 */
	unset($phrases);
	unset($searchers);
	unset($referers);
	unset($ips);
	unset($terms);
	unset($fields);
	unset($sortby);
	unset($sortdir);
	unset($authors);
	unset($searchtime);

	/**
	 * Here we count successful searches
	 */
	$succesful_searches = 0;

	while (list(, $value) = each($searchstatus))
	{
		if ($value == STATUS_OK)
		{
			$succesful_searches += 1;
		}
	}

	/**
	 * ...and delete that last array that we no longer need.
	 */
	unset($searchstatus);

	$template->assign_vars(array
	(
		'L_FIRST_SEARCH' => $lang['First_search'],
		'L_LAST_SEARCH' => $lang['Last_search'],
		'L_DAYS_ACTIVE' => $lang['Days_active'],
		'L_SEARCHES_PER_DAY' => $lang['Searches_per_day'],
		'L_TOTAL_SEARCHES' => $lang['Total_searches'],
		'L_SUCCESFUL_SEARCHES' => $lang['Succesful_searches'],
		'L_FAILED_SEARCHES' => $lang['Failed_searches'],
		'L_SUCCES_RATE' => $lang['Succes_rate'],
		'L_IP' => $lang['User_IP'],
		'L_RESULT' => $lang['Result'],
		'L_STATS' => $lang['Stats'],
		'L_STATS_EXPLAIN' => $lang['Stats_explain'],
		'L_WORDS' => $lang['Words'],
		'L_CONFIG' => $lang['Config'],
		'L_PHRASES' => $lang['Phrases'],
		'L_SEARCH_PHRASE' => $lang['Search_phrase'],
		'L_NUM_RESULTS' => $lang['Num_results'],
		'L_USER' => $lang['Auth_User'],
		'L_REFERER' => $lang['Referer'],
		'L_FORUM' => $lang['Forum'],
		'L_CATEGORY' => $lang['Category'],
		'L_AUTHOR' => $lang['Author'],
		'L_SEARCH_TERMS' => $lang['Search_terms'],
		'L_SEARCH_FIELDS' => $lang['Search_fields'],
		'L_SORT_BY' => ucwords($lang['Sort_by']),
		'L_SORT_DIR' => $lang['Sort_dir'],
		'L_PERCENTAGE' => $lang['Percentage'],
		'L_SPECIFIC_DATA' => $lang['Specific_data'],
		'L_SUBMIT' => $lang['Submit'],
		'L_STATISTIC' => $lang['Statistic'],
		'L_VALUE' => $lang['Value'],
		'L_NO_CONFIG' => $lang['No_config'],
		'L_DATE_SPECIFIC_STATS' => $lang['Date_specific_stats'],
		'L_DATE_SPECIFIC_STATS_EXPLAIN' => $lang['Date_specific_stats_explain'],
		'L_BEGIN_DATESPAN' => $lang['Begin_datespan'],
		'L_END_DATESPAN' => $lang['End_datespan'],
		'L_DEFINE_DATESPAN' => $lang['Define_datespan'],
		'L_DATESPAN_RESULT' => sprintf($lang['Datespan_result'], create_date($board_config['default_dateformat'], $beginspan, $board_config['board_timezone']), create_date($board_config['default_dateformat'], $endspan, $board_config['board_timezone'])),
		'L_MOD_VERSION' => sprintf($lang['Mod_version'], SD_VERSION),
		'FIRST_SEARCH' => $first_search,
		'LAST_SEARCH' => $last_search,
		'DAYS_ACTIVE' => $days_active,
		'SEARCHES_PER_DAY' => $searches_per_day,
		'TOTAL_SEARCHES' => $count_rows,
		'SUCCESFUL_SEARCHES' => $succesful_searches,
		'FAILED_SEARCHES' => $count_rows - $succesful_searches,
		'SUCCES_RATE' => round(100 * $succesful_searches / $count_rows, 3),
		'U_PHRASES' => append_sid("admin_search_phrases.$phpEx?page=phrases"),
		'U_WORDS' => append_sid("admin_search_phrases.$phpEx?page=words"),
		'U_CONFIG' => append_sid("admin_search_phrases.$phpEx?page=config"),
		'S_NUM_RESULTS' => $select_results,
		'S_DISPLAY_RESULTS_ACTION' => append_sid("admin_search_phrases.$phpEx?page=stats")
	));

	/**
	 * Phrases. $i is just a counter used for the alternating row colors.
	 */
	$i = 0;

	if ($config_array['p'])
	{
		$template->assign_block_vars('switch_phrases', array());
		while (list($key, $value) = each($num_phrases))
		{
			$percentage = $searchdata->percentage($value, $count_rows);
			$i++;
			/**
			 * Strip out the leading dot we inserted to force numeric array keys
			 * to be preserved through array_reverse();
			 */
			$phrases = substr(str_replace('%', '*', $key), 1);
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_phrases.phraserow', array
			(
				'SEARCH_PHRASE' => $phrases,
				'SEARCH_PHRASE_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Users
	 */
	if ($config_array['u'])
	{
		$template->assign_block_vars('switch_users', array());
		while (list($key, $value) = each($num_searchers))
		{
			$i++;
			$users = ($key == 'Anonymous') ? $lang['Guests'] : $key;
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_users.searcherrow', array
			(
				'SEARCHER' => $users,
				'SEARCHER_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Referers
	 * Changing search action to GET enables linking from remote sites
	 * to searches. Hence this feature.
	 */
	if ($config_array['r'])
	{
		$template->assign_block_vars('switch_referer', array());
		while (list($key, $value) = each($num_referers))
		{
			$i++;
			$referers = '<a href="' . $key . '">' . substr($key, 7) . '</a>';
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_referer.refererrow', array
			(
				'REFERER' => $referers,
				'REFERER_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * IPs
	 */
	if ($config_array['i'])
	{
		$template->assign_block_vars('switch_ips', array());
		while (list($key, $value) = each($num_ips))
		{
			$i++;
			$stat = $value;
			$key = decode_ip($key);
			$key = ($key == '0.0.0.0') ? $lang['Connect_proxy'] : '<a href="http://www.dnsstuff.com/tools/whois.ch?ip=' . $key . '">' . $key . '</a>';
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_ips.ipsrow', array
			(
				'IPS' => $key,
				'IPS_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Forums
	 */
	if ($config_array['f'])
	{
		$template->assign_block_vars('switch_forums', array());

		$sql = "SELECT s.search_forum, f.forum_name
		FROM " . SEARCH_PHRASES_TABLE . " s, " . FORUMS_TABLE . " f
		WHERE s.search_forum = f.forum_id
		$timespan";

		if (!$result2 = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not obtain forums data');
		}

		$count_forum_rows = $db->sql_numrows($result2);

		$forums = array();

		while ($row = $db->sql_fetchrow($result2))
		{
			$forum_name = ($row['search_forum'] == '-1') ? $lang['All'] : $row['forum_name'];
			$forums[] = $forum_name;
		}

		$forum_all_count = $count_rows - $count_forum_rows;

		$forum_all_array = array( $lang['All'] => $forum_all_count );

		$num_forums = $searchdata->search_stats_forum($forums, $display_results, $forum_all_array);
		while (list($key, $value) = each($num_forums))
		{
			$i++;
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_forums.forumrow', array
			(
				'FORUM' => $key,
				'FORUM_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Categories
	 */
	if ($config_array['c'])
	{
		$template->assign_block_vars('switch_cats', array());

		$sql = "SELECT s.search_cat, c.cat_title
		FROM " . SEARCH_PHRASES_TABLE . " s, " . CATEGORIES_TABLE . " c
		WHERE s.search_cat = c.cat_id
		$timespan";

		if (!$result2 = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not obtain categories data');
		}

		$count_cat_rows = $db->sql_numrows($result2);

		$cats = array();

		while ($row = $db->sql_fetchrow($result2))
		{
			$cat_name = ($row['search_cat'] == '-1') ? $lang['All'] : $row['cat_title'];
			$cats[] = $cat_name;
		}

		$cat_all_count = $count_rows - $count_cat_rows;

		$cat_all_array = array( $lang['All'] => $cat_all_count );

		$num_cats = $searchdata->search_stats_forum($cats, $display_results, $cat_all_array);
		while (list($key, $value) = each($num_cats))
		{
			$i++;
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_cats.catrow', array
			(
				'CATEGORIES' => $key,
				'CATEGORIES_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Authors
	 */
	if ($config_array['a'])
	{
		$template->assign_block_vars('switch_authors', array());
		while (list($key, $value) = each($num_authors))
		{
			$i++;
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_authors.authorrow', array
			(
				'AUTHORS' => str_replace('%', '*', $key),
				'AUTHORS_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Search Terms
	 */
	if ($config_array['t'])
	{
		$template->assign_block_vars('switch_terms', array());
		while (list($key, $value) = each($num_terms))
		{
			$i++;
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_terms.termsrow', array
			(
				'TERMS' => $key,
				'TERMS_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Search Fields
	 */
	if ($config_array['flds'])
	{
		$template->assign_block_vars('switch_fields', array());
		while (list($key, $value) = each($num_fields))
		{
			$i++;
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_fields.fieldsrow', array
			(
				'FIELDS' => $key,
				'FIELDS_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Sort By
	 */
	if ($config_array['sb'])
	{
		$template->assign_block_vars('switch_sort_by', array());
		while (list($key, $value) = each($num_sortby))
		{
			$i++;
			$stat = $value;
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_sort_by.sortbyrow', array
			(
				'SORTBY' => $key,
				'SORTBY_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}

	/**
	 * Sort Dir
	 */
	if ($config_array['sd'])
	{
		$template->assign_block_vars('switch_sort_dir', array());
		while (list($key, $value) = each($num_sortdir))
		{
			$i++;
			$stat = $value;
			$key = ($key == 'ASC') ? $lang['Sort_Ascending'] : $lang['Sort_Descending'];
			$percentage = $searchdata->percentage($value, $count_rows);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_sort_dir.sortdirrow', array
			(
				'SORTDIR' => $key,
				'SORTDIR_NUM' => $stat,
				'PERCENTAGE' => $percentage,
				'ROW_NUMBER' => $i + ($start + 1),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class
			));
		}
	}
	$db->sql_freeresult($result);
}

/**
 * Words
 */
elseif ($page == 'words')
{
	$cookie = unserialize(stripslashes($cookie));

	/**
	 * Set a cookie that stores viewer preferences. This also
	 * makes pagination without a query possible. Additionally
	 * the display will have identical view options as the last
	 * time that the module was viewed.
	 */
	if (isset($HTTP_POST_VARS['display_words']) || isset($HTTP_POST_VARS['sort_results']) || isset($HTTP_POST_VARS['filter']))
	{
		$display_words = intval($HTTP_POST_VARS['display_words']);
		$sort_results = intval($HTTP_POST_VARS['sort_results']);
		$filter = $HTTP_POST_VARS['filter'];

		$cookiedata = array
		(
			'display_results' => $cookie['display_results'],
			'display_words' => $display_words,
			'filter' => $filter,
			'sort_results' => $sort_results,
			'finddata' => $cookie['finddata']
		);

		setcookie($board_config['cookie_name'] . '_sd', serialize($cookiedata), time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
		redirect('admin/' . append_sid("admin_search_phrases.$phpEx?page=words", true));
	}
	elseif (!empty($cookie['display_words']) || !empty($cookie['sort_results']) || !empty($cookie['filter']))
	{
		$display_words = $cookie['display_words'];
		$sort_results = $cookie['sort_results'];
		$filter = $cookie['filter'];
	}
	else
	{
		$display_words = 10;
		$sort_results = RESULT_DESCENDING;
		$filter = '';
	}

	$template->set_filenames(array( 'body' => 'admin/search_phrases_words.tpl' ));

	$sql = "SELECT s.search_phrase, username
	FROM " . SEARCH_PHRASES_TABLE . " s, " . USERS_TABLE . " u
	WHERE s.search_user_id = u.user_id";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_MESSAGE, 'Could not obtain search data');
	}

	if ($db->sql_numrows($result) == 0)
	{
		$message = $lang['No_search_phrases'] . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}

	/**
	 * Read stopwords file
	 */
	$stopword = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_stopwords.txt");

	/**
	 * Well, unfortunately this excercise is necessary, as trailing space etc
	 * in the stopwords text-file will cause a word mismatch.
	 */
	$stopword_array = array();

	for ($i = 0; $i < count($stopword); $i++)
	{
		$stopword_array[] = trim(strtolower($stopword[$i]));
	}

	/**
	 * We could probably add many more characters to this array. We're
	 * stripping out bogus characters.
	 */
	$strip_chars = array
	(
		'*',
		'?',
		'"',
		'%',
		'.',
		'`',
		'´',
		'”',
		'“'
	);

	/**
	 * Split the original phrase into a new array and loop it.
	 */
	while ($row = $db->sql_fetchrow($result))
	{
		$words = explode(' ', $row['search_phrase']);
		$count_words = count($words);
		for ($i = 0; $i < $count_words; $i++)
		{
			$one_word = trim(strtolower($words[$i]));
			$one_word = str_replace($strip_chars, '', $one_word);
			$one_word = (in_array($one_word, $stopword_array) && !empty($filter)) ? '' : $one_word;
			$one_word = (is_numeric($one_word)) ? '' : $one_word;
			$one_word = (strlen($one_word) > 2) ? $one_word : '';
			$word[] = $one_word;
		}
	}

	/**
	 * Copy the array into a new array for statistics purposes.
	 * Then delete stats array to save server memory.
	 */
	$stat_words = array();

	$stat_words = $word;
	$stat_words = $searchdata->search_word_stats_max($stat_words);
	$max_word = key($stat_words);
	$max_word_occ = current($stat_words);
	unset($stat_words);

	/**
	 * Filter out recurring matches.
	 */
	$count_unique_rows = count(array_unique($word));

	$count_rows = count($word);
	$checked = (!empty($filter)) ? 'checked="checked"' : '';
	$filter_stop_words = '<input type="checkbox" name="filter" ' . $checked . ' />';

	$sort_options = array
	(
		RESULT_DESCENDING,
		RESULT_ASCENDING,
		WORD_DESCENDING,
		WORD_ASCENDING
	);

	$sort_options_lang = array
	(
		$lang['Result_descending'],
		$lang['Result_ascending'],
		$lang['Word_descending'],
		$lang['Word_ascending']
	);

	$display_sort_results = '<select name="sort_results">';

	for ($i = 0; $i < count($sort_options); $i++)
	{
		$sort_selected = ($sort_results == $sort_options[$i]) ? ' selected="selected"' : '';
		$display_sort_results .= '<option value="' . $sort_options[$i] . '"' . $sort_selected . '>' . $sort_options_lang[$i] . '</option>';
	}

	$display_sort_results .= '</select>';

	$result_values = array
	(
		5,
		10,
		25,
		50,
		75,
		100,
		$count_rows
	);

	$result_values_lang = array
	(
		5,
		10,
		25,
		50,
		75,
		100,
		$lang['All']
	);

	$select_results = '<select name="display_words">';

	for ($i = 0; $i < count($result_values); $i++)
	{
		$selected = ($display_words == $result_values[$i]) ? ' selected="selected"' : '';
		$select_results .= '<option value="' . $result_values[$i] . '"' . $selected . '>' . $result_values_lang[$i] . '</option>';
	}

	$select_results .= '</select>';

	$num_words = $searchdata->search_word_stats($word);
	unset($word);

	/**
	 * This one is funky. Since we're doing stats here we need to
	 * fetch all rows. Instead of doing the sort options with
	 * SQL we're sorting and reversing arrays. Seems to work OK.
	 */
	switch($sort_results)
	{
		case RESULT_DESCENDING:
			$num_words = $num_words;
			break;

		case RESULT_ASCENDING:
			$num_words = array_reverse($num_words);
			break;

		case WORD_DESCENDING:
			krsort($num_words);
			break;

		case WORD_ASCENDING:
			ksort($num_words);
			break;
	}

	$searchdata->search_options($num_words, $display_words, $start, $sort_results);
	$percentage_max = round(100 * $max_word_occ / $count_unique_rows, 3);

	$template->assign_vars(array
	(
		'L_WORDS' => $lang['Words'],
		'L_WORDS_EXPLAIN' => $lang['Words_explain'],
		'L_WORD' => $lang['Word'],
		'L_RESULT' => $lang['Result'],
		'L_PHRASE' => $lang['Phrase'],
		'L_PERCENTAGE' => $lang['Percentage'],
		'L_FILTER_STOP_WORDS' => $lang['Filter_stop_words'],
		'L_STATS' => $lang['Stats'],
		'L_CONFIG' => $lang['Config'],
		'L_NUM_RESULTS' => $lang['Num_results'],
		'L_SORT_OPTIONS' => $lang['Sort_options'],
		'L_MAX_WORD' => $lang['Max_word'],
		'L_MAX_WORDS' => $lang['Max_words'],
		'L_MAX_WORD_OCC' => $lang['Max_word_occ'],
		'L_PERCENTAGE' => $lang['Percentage'],
		'L_PHRASES' => $lang['Phrases'],
		'L_SUBMIT' => $lang['Submit'],
		'L_STATISTIC' => $lang['Statistic'],
		'L_VALUE' => $lang['Value'],
		'L_MOD_VERSION' => sprintf($lang['Mod_version'], SD_VERSION),
		'MAX_WORD' => $max_word,
		'MAX_WORDS' => $count_unique_rows,
		'MAX_WORD_OCC' => ($max_word_occ == 1) ? $lang['Once'] : $max_word_occ . ' ' . $lang['Times'],
		'PERCENTAGE_MAX' => $percentage_max,
		'U_PHRASES' => append_sid("admin_search_phrases.$phpEx?page=phrases"),
		'U_STATS' => append_sid("admin_search_phrases.$phpEx?page=stats"),
		'U_CONFIG' => append_sid("admin_search_phrases.$phpEx?page=config"),
		'S_SORT_RESULTS' => $display_sort_results,
		'S_FILTER_STOP_WORDS' => $filter_stop_words,
		'S_NUM_RESULTS' => $select_results,
		'S_DISPLAY_RESULTS_ACTION' => append_sid("admin_search_phrases.$phpEx?page=words")
	));

	$i = 0;

	foreach ($num_words as $key => $value)
	{
		$i++;
		$percentage = round(100 * $value / $count_unique_rows, 3);

		$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
		$template->assign_block_vars('wordrow', array
		(
			'NUM_WORD' => $value,
			'WORD' => $key,
			'PERCENTAGE' => $percentage,
			'ROW_NUMBER' => $i + ($start + 1),
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class
		));
	}

	$pagination = generate_pagination("admin_search_phrases.$phpEx?page=words", $count_unique_rows, $display_words, $start);

	$template->assign_vars(array
	(
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], (floor($start / $display_words) + 1), ceil($count_unique_rows / $display_words)),
		'L_GOTO_PAGE' => $lang['Goto_page']
	));
	$db->sql_freeresult($result);
}

/**
 * Phrases
 */
elseif ($page == 'phrases')
{
	/**
	 * Early versions of this MOD did not have a row
	 * in the config table. This small piece of code will
	 * auto update the config table in case the user forgot
	 * to run the SQL with the upgrade procedure
	 */
	if (is_null($board_config['search_data']))
	{
		$sql = "INSERT INTO " . CONFIG_TABLE . " (config_name, config_value) VALUES ('search_data', '')";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not insert search field', '', __LINE__, __FILE__, $sql);
		}

		$message = sprintf($lang['Update_complete'], SD_VERSION) . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}

	$delete_single = (isset($HTTP_POST_VARS['delete_single'])) ? TRUE : FALSE;

	$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;

	if (isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']))
	{
		$mode = (isset($HTTP_POST_VARS['mode'])) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
	}
	else
	{
		$mode = 'search_time';
	}

	if (isset($HTTP_POST_VARS['order']))
	{
		$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else if (isset($HTTP_GET_VARS['order']))
	{
		$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else
	{
		$sort_order = 'DESC';
	}

	if (isset($HTTP_POST_VARS['find']))
	{
		$find = $HTTP_POST_VARS['find'];
	}
	else if (isset($HTTP_GET_VARS['find']))
	{
		$find = ($mode == 'search_user_ip') ? decode_ip($HTTP_GET_VARS['find']) : $HTTP_GET_VARS['find'];
	}
	else
	{
		$find = '';
	}

	/**
	 * Sort method
	 */
	$mode_types_text = array
	(
		$lang['Auth_User'],
		$lang['Search_phrase'],
		$lang['Search_time'],
		$lang['User_IP'],
		$lang['Referer'],
		$lang['Status'],
		$lang['Author'],
		$lang['Forum_id'],
		$lang['Category_id']
	);

	$mode_types = array
	(
		'username',
		'search_phrase',
		'search_time',
		'search_user_ip',
		'search_referer',
		'search_failed',
		'search_author',
		'search_forum',
		'search_cat'
	);

	$select_sort_mode = '<input type="text" name="find" value="' . stripslashes($find) . '" onfocus="this.value =\'\';" />&nbsp;&nbsp;' . $lang['Parameter'] . '&nbsp;';
	$select_sort_mode .= '<select name="mode">';

	for ($i = 0; $i < count($mode_types_text); $i++)
	{
		$selected = ($mode == $mode_types[$i]) ? ' selected="selected"' : '';
		$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
	}

	$select_sort_mode .= '</select>';

	/**
	 * Sort order
	 */
	$select_sort_order = '<select name="order">';

	if ($sort_order == 'ASC')
	{
		$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
	}
	else
	{
		$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
	}

	$select_sort_order .= '</select>';

	$template->set_filenames(array( 'body' => 'admin/search_phrases.tpl' ));

	$template->assign_vars(array
	(
		'L_SELECT_SORT_METHOD' => $lang['Search_and_sort'],
		'L_ORDER' => $lang['Order'],
		'L_SORT' => $lang['Sort'],
		'L_SUBMIT' => $lang['Submit'],
		'L_DELETE' => $lang['Delete'],
		'L_GO' => $lang['Go'],
		'L_STATS' => $lang['Stats'],
		'L_WORDS' => $lang['Words'],
		'L_CONFIG' => $lang['Config'],
		'L_USER' => $lang['Auth_User'],
		'L_MOD_VERSION' => sprintf($lang['Mod_version'], SD_VERSION),
		'L_SEARCH_PHRASES_EXPLAIN' => $lang['Search_phrases_explain'],
		'L_SEARCH_PHRASES' => $lang['Search_phrases'],
		'U_STATS' => append_sid("admin_search_phrases.$phpEx?page=stats"),
		'U_WORDS' => append_sid("admin_search_phrases.$phpEx?page=words"),
		'U_CONFIG' => append_sid("admin_search_phrases.$phpEx?page=config"),
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		'S_MODE_ACTION' => append_sid("admin_search_phrases.$phpEx")
	));

	/**
	 * Lot's of cool stuff here. We can search for searches, and sort by many
	 * parameters. We're using strtotime(); to look for time specific searches.
	 * Works extremely well when using time spans separated by a hyphen,
	 * e.g 11/20/2005 - 11/22/2005.
	 *
	 * If the find parameter is set we either grab the variable from the POST
	 * variable in the form, or we dig it out of the url for pagination purposes
	 */

	switch($mode)
	{
		case 'username':
			$search = "AND username LIKE '%$find%'";
			$order_by = (!empty($find)) ? "search_time $sort_order, username $sort_order LIMIT $start, " . $board_config['posts_per_page'] : "username $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		case 'search_phrase':
			$search = "AND search_phrase LIKE '%$find%'";
			$order_by = (!empty($find)) ? "search_time $sort_order, search_phrase $sort_order LIMIT $start, " . $board_config['posts_per_page'] : "search_phrase $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		case 'search_time':
			$timesplit = explode('-', $find);
			$now = (!empty($timesplit[1])) ? strtotime(trim($timesplit[1])) : time();
			$then = (!empty($timesplit[0])) ? strtotime(trim($timesplit[0])) : time();
			$search = (!empty($find)) ? "AND search_time BETWEEN '$then' AND '$now'" : '';
			$order_by = "search_time $sort_order, search_time $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		case 'search_user_ip':
			$find = (!empty($find)) ? encode_ip($find) : '';
			$search = "AND search_user_ip LIKE '%$find%'";
			$order_by = (!empty($find)) ? "search_time $sort_order, search_user_ip $sort_order LIMIT $start, " . $board_config['posts_per_page'] : "search_user_ip $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		case 'search_referer':
			$search = "AND search_referer != '' AND search_referer LIKE '%$find%'";
			$order_by = (!empty($find)) ? "search_time $sort_order, search_referer $sort_order LIMIT $start, " . $board_config['posts_per_page'] : "search_referer $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		case 'search_failed':
			$find = (strtoupper($find) == strip_tags($lang['OK'])) ? 0 : ((ucwords($find) == strip_tags(str_replace('!', '', $lang['Failed']))) ? 1 : $find);
			$search = "AND search_failed = '$find'";
			$order_by = "search_time $sort_order, search_failed $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		case 'search_author':
			$search = "AND search_author != '' AND search_author LIKE '%$find%'";
			$order_by = (!empty($find)) ? "search_time $sort_order, search_author $sort_order LIMIT $start, " . $board_config['posts_per_page'] : "search_author $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		case 'search_forum':
			$find = (ucwords($find) == $lang['All']) ? -1 : $find;
			$search = "AND search_forum = '$find'";
			$order_by = (!empty($find)) ? "search_time $sort_order, search_forum $sort_order LIMIT $start, " . $board_config['posts_per_page'] : "search_forum $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		case 'search_cat':
			$find = (ucwords($find) == $lang['All']) ? -1 : $find;
			$search = "AND search_cat = '$find'";
			$order_by = "search_time $sort_order, search_cat $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;

		default:
			$search = '';
			$order_by = "search_time $sort_order LIMIT $start, " . $board_config['posts_per_page'];
			break;
	}

	$sql = "SELECT s.*, u.username, u.user_avatar, u.user_avatar_type, u.user_allowavatar
	FROM " . SEARCH_PHRASES_TABLE . " s, " . USERS_TABLE . " u
	WHERE s.search_user_id = u.user_id
	$search
	ORDER BY $order_by";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query search information', '', __LINE__, __FILE__, $sql);
	}

	$search_count = $db->sql_numrows($result);

	$search_row = array();

	while ($row = $db->sql_fetchrow($result))
	{
		$search_row[] = $row;
	}

	/**
	 * Sorry about this - one more query needed. Normally I would get these in the main
	 * query but most searches will have search forum or cat set to "All" which will
	 * return -1 instead of a forum_id. What I am doing here is putting the forum_id
	 * into the array value and the forum name into the key. I can then identify the
	 * forum name using array_search().
	 */
	$sql = "SELECT f.forum_id, f.forum_name, c.cat_id, c.cat_title
	FROM " . FORUMS_TABLE . " f, " . CATEGORIES_TABLE . " c
	WHERE f.cat_id = c.cat_id";

	if (!$result2 = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query forums/cats information', '', __LINE__, __FILE__, $sql);
	}

	$forums = array();

	$cats = array();

	while ($forum_row = $db->sql_fetchrow($result2))
	{
		$forums[$forum_row['forum_name']] = $forum_row['forum_id'];
		$cats[$forum_row['cat_title']] = $forum_row['cat_id'];
	}

	$succes = 0;

	for ($i = 0; $i < $search_count; $i++)
	{
		$forum = $search_row[$i]['search_forum'];
		$forum_name = array_search($forum, $forums);
		$forum_name = ($forum == -1) ? $lang['All'] : $forum_name;

		$cat = $search_row[$i]['search_cat'];
		$cat_name = array_search($cat, $cats);
		$cat_name = ($cat == -1) ? $lang['All'] : $cat_name;

		$search_user_id = $search_row[$i]['search_user_id'];
		$search_author = str_replace('%', '*', $search_row[$i]['search_author']);
		$user = ($search_user_id == ANONYMOUS) ? $lang['Guest'] : $search_row[$i]['username'];
		$user_avatar = '';

		if ($search_row[$i]['user_avatar_type'] && $search_user_id != ANONYMOUS && $search_row[$i]['user_allowavatar'])
		{
			switch($search_row[$i]['user_avatar_type'])
			{
				case USER_AVATAR_UPLOAD:
					$user_avatar = ($board_config['allow_avatar_upload']) ? '<img src="' . $phpbb_root_path . $board_config['avatar_path'] . '/' . $search_row[$i]['user_avatar'] . '" alt="" border="0" />' : '';
					break;

				case USER_AVATAR_REMOTE:
					$user_avatar = ($board_config['allow_avatar_remote']) ? '<img src="' . $search_row[$i]['user_avatar'] . '" alt="" border="0" />' : '';
					break;

				case USER_AVATAR_GALLERY:
					$user_avatar = ($board_config['allow_avatar_local']) ? '<img src="' . $phpbb_root_path . $board_config['avatar_gallery_path'] . '/' . $search_row[$i]['user_avatar'] . '" alt="" border="0" />' : '';
					break;
			}
		}

		/**
		 * If you want a default avatar for people with no avatars, then put something here.
		 * Example: $user_avatar = '<img src="http://www.yoursite.com/images/avatars/gallery/Letter%20avatars/A.jpg" alt="" border="0" />';
		 */
		if (empty($user_avatar))
		{
			$user_avatar = '';
		}

		if (isset($HTTP_GET_VARS['delete_single']))
		{
			$sql = "DELETE FROM " . SEARCH_PHRASES_TABLE . "
			WHERE search_id = " . intval($HTTP_GET_VARS['delete_single']);

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete entry');
			}

			$message = $lang['Entry_deleted'] . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}

		$search_fields = $searchdata->search_fields($search_row[$i]['search_fields']);
		$search_terms = ($search_row[$i]['search_terms'] == SEARCH_FOR_ANY) ? $lang['Search_for_any'] : $lang['Search_for_all'];
		$sort_dir = ($search_row[$i]['search_sort_dir'] == 'ASC') ? $lang['Sort_Ascending'] : $lang['Sort_Descending'];

		$sort_by = $searchdata->sort_by($search_row[$i]['search_sort_by']);

		$avatar = ($search_user_id == ANONYMOUS) ? $user_avatar : '<a href="' . $phpbb_root_path . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$search_user_id") . '">' . $user_avatar . '</a>';
		$search_id = $search_row[$i]['search_id'];
		$delete_entry_text = $lang['Delete_entry'];

		$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
		$template->assign_block_vars('searchrow', array
		(
			'L_SEARCH_TIME' => $lang['Search_time'],
			'L_USER_IP' => $lang['User_IP'],
			'L_STATUS' => $lang['Status'],
			'L_FORUM' => $lang['Forum'],
			'L_CATEGORY' => $lang['Category'],
			'L_SEARCH_FIELDS' => $lang['Search_fields'],
			'L_SEARCH_TERMS' => $lang['Search_terms'],
			'L_SORT_BY' => ucwords($lang['Sort_by']),
			'L_SORT_DIR' => $lang['Sort_dir'],
			'L_AUTHOR' => $lang['Author'],
			'REFERER' => (!empty($search_row[$i]['search_referer'])) ? '<b>' . $lang['Referer'] . ':</b> <a href="' . $search_row[$i]['search_referer'] . '">' . $search_row[$i]['search_referer'] . '</a>' : '',
			'STATUS' => ($search_row[$i]['search_failed'] == STATUS_OK) ? $lang['OK'] : $lang['Failed'],
			'SEARCH_PHRASE' => str_replace('%', '*', $search_row[$i]['search_phrase']),
			'FORUM_NAME' => $forum_name,
			'CAT_NAME' => $cat_name,
			'SEARCH_FIELDS' => $search_fields,
			'SEARCH_TERMS' => $search_terms,
			'SORT_BY' => $sort_by,
			'SORT_DIR' => $sort_dir,
			'POSTER' => $user,
			'FORUM' => $search_row[$i]['forum_name'],
			'USER_AVATAR' => $avatar,
			'AUTHOR' => (!empty($search_author)) ? '<span style ="color: blue"><b>' . $lang['Author'] . ':</b></span> ' . $search_author : '',
			'USER_IP' => '<a href="http://www.dnsstuff.com/tools/whois.ch?ip=' . decode_ip($search_row[$i]['search_user_ip']) . '">' . decode_ip($search_row[$i]['search_user_ip']) . '</a>',
			'SEARCH_TIME' => create_date($board_config['default_dateformat'], $search_row[$i]['search_time'], $board_config['board_timezone']),
			'DELETE_SINGLE' => "<a href=\"" . append_sid("admin_search_phrases.$phpEx?delete_single=$search_id") . "\">$delete_entry_text</a>",
			'ROW_NUMBER' => $i + ($start + 1),
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class
		));
	}

	/**
	 * No returned rows. Show a nice message.
	 */
	$count_search_row = count($search_row);

	if ($count_search_row == 0)
	{
		$template->assign_block_vars('no_search_data', array( 'L_NO_SEARCH_PHRASES' => $lang['No_search_phrases'] ));
	}

	$sql = "SELECT COUNT(*) AS total
	FROM " . SEARCH_PHRASES_TABLE . " s, " . USERS_TABLE . " u
	WHERE s.search_user_id = u.user_id
	$search";

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Error getting total search entries', '', __LINE__, __FILE__, $sql);
	}

	$find = urlencode($find);

	if ($total = $db->sql_fetchrow($result))
	{
		$total_search_entries = $total['total'];
		$pagination = generate_pagination("admin_search_phrases.$phpEx?mode=$mode&amp;order=$sort_order&amp;find=$find", $total_search_entries, $board_config['posts_per_page'], $start) . '&nbsp;';
	}


	/**
	 * Show some simple statistics
	 */
	$textmode = str_replace($mode_types, $mode_types_text, $mode);

	if (!empty($find))
	{
		$template->assign_block_vars('switch_specific_data', array());
	}
	$template->assign_vars(array
	(
		'L_QUERY' => $lang['Query'],
		'L_RECORDS' => ($count_search_row == 1) ? $lang['Record'] : $lang['Records'],
		'MODE' => $textmode,
		'FIND' => ($textmode == 'IP') ? decode_ip($find) : stripslashes(urldecode($find)),
		'RESULT' => $total_search_entries,
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], (floor($start / $board_config['posts_per_page']) + 1), ceil($total_search_entries / $board_config['posts_per_page'])),
		'L_GOTO_PAGE' => $lang['Goto_page']
	));
}

/**
 * Config
 */
elseif ($page == 'config')
{
	$template->set_filenames(array( 'body' => 'admin/search_phrases_config.tpl' ));

	$config_array = unserialize($board_config['search_data']);

	/**
	 * Setup checked status for checkboxes.
	 */
	$checked_status = ($config_array['s']) ? 'checked="checked"' : '';
	$checked_phrases = ($config_array['p']) ? 'checked="checked"' : '';
	$checked_users = ($config_array['u']) ? 'checked="checked"' : '';
	$checked_referer = ($config_array['r']) ? 'checked="checked"' : '';
	$checked_ips = ($config_array['i']) ? 'checked="checked"' : '';
	$checked_forums = ($config_array['f']) ? 'checked="checked"' : '';
	$checked_cats = ($config_array['c']) ? 'checked="checked"' : '';
	$checked_author = ($config_array['a']) ? 'checked="checked"' : '';
	$checked_terms = ($config_array['t']) ? 'checked="checked"' : '';
	$checked_fields = ($config_array['flds']) ? 'checked="checked"' : '';
	$checked_sort_by = ($config_array['sb']) ? 'checked="checked"' : '';
	$checked_sort_dir = ($config_array['sd']) ? 'checked="checked"' : '';
	$checked_not_admin = ($config_array['na']) ? 'checked="checked"' : '';
	$checked_not_mod = ($config_array['nm']) ? 'checked="checked"' : '';

	if (isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']))
	{
		$mode = (isset($HTTP_POST_VARS['mode'])) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
	}
	else
	{
		$mode = 'search_phrase';
	}

	/**
	 * Setup select box for selective deleting
	 */
	$mode_types_text = array
	(
		$lang['User_id'],
		$lang['Search_phrase'],
		$lang['Search_time'],
		$lang['User_IP'],
		$lang['Referer'],
		$lang['Status'],
		$lang['Author'],
		$lang['Search_fields'],
		$lang['Search_terms'],
		$lang['Category_id'],
		$lang['Forum_id']
	);

	$mode_types = array
	(
		'search_user_id',
		'search_phrase',
		'search_time',
		'search_user_ip',
		'search_referer',
		'search_failed',
		'search_author',
		'search_fields',
		'search_terms',
		'search_cat',
		'search_forum'
	);

	$select_mode = '<input type="text" name="find" size="40" />&nbsp;&nbsp;' . $lang['Parameter'] . '&nbsp;';
	$select_mode .= '<select name="mode">';

	for ($i = 0; $i < count($mode_types_text); $i++)
	{
		$selected = ($mode == $mode_types[$i]) ? ' selected="selected"' : '';
		$select_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
	}

	$select_mode .= '</select>';

	$template->assign_vars(array
	(
		'L_CONFIG' => $lang['Config'],
		'L_CONFIG_EXPLAIN' => $lang['Config_explain'],
		'L_DISABLE_MOD' => $lang['Disable_mod'],
		'L_DISABLE_MOD_ADMIN' => $lang['Disable_mod_admin'],
		'L_DISABLE_MOD_MODERATOR' => $lang['Disable_mod_moderator'],
		'L_OPTION' => $lang['Option'],
		'L_VALUE' => $lang['Value'],
		'L_STATS_PAGE_SETTINGS' => $lang['Stats_page_settings'],
		'L_ENABLE' => $lang['Enable'],
		'L_PHRASES' => $lang['Phrases'],
		'L_USER' => $lang['Auth_User'],
		'L_REFERER' => $lang['Referer'],
		'L_IP' => $lang['User_IP'],
		'L_FORUM' => $lang['Forum'],
		'L_CATS' => $lang['Category'],
		'L_AUTHOR' => $lang['Author'],
		'L_TERMS' => $lang['Search_terms'],
		'L_FIELDS' => $lang['Search_fields'],
		'L_SORT_BY' => ucwords($lang['Sort_by']),
		'L_SORT_DIR' => $lang['Sort_dir'],
		'L_SUBMIT' => $lang['Submit'],
		'L_DELETE_SELECTIVE' => $lang['Selective_delete'],
		'L_DELETE_SELECTIVE_EXPLAIN' => $lang['Selective_delete_explain'],
		'L_PARAMETER' => $lang['Parameter'],
		'L_CHECKBOXES' => $lang['Checkboxes'],
		'L_STATS' => $lang['Stats'],
		'L_WORDS' => $lang['Words'],
		'L_DELETE' => $lang['Delete'],
		'L_BACKUP' => $lang['Backup'],
		'L_BACKUP_EXPLAIN' => $lang['Backup_explain_sd'],
		'L_BACKUP_DATA' => $lang['Backup_data'],
		'L_BACKUP_DATA_STRUCTURE' => $lang['Backup_data_structure'],
		'L_TABLE_STRUCTURE' => $lang['Table_structure'],
		'L_PURGE_SEARCH_PHRASES' => $lang['Purge_search_phrases'],
		'L_PURGE_SEARCH_PHRASES_EXPLAIN' => $lang['Purge_search_phrases_explain'],
		'L_PURGE_SEARCH_PHRASES_WARN' => $lang['Purge_search_phrases_warn'],
		'L_SEARCH_PHRASES' => $lang['Search_phrases'],
		'L_MOD_VERSION' => sprintf($lang['Mod_version'], SD_VERSION),
		'L_TIDY' => $lang['Tidy'],
		'L_TIDY_EXPLAIN' => $lang['Tidy_explain'],
		'CHECKED_STATUS' => $checked_status,
		'CHECKED_PHRASES' => $checked_phrases,
		'CHECKED_USERS' => $checked_users,
		'CHECKED_REFERER' => $checked_referer,
		'CHECKED_IPS' => $checked_ips,
		'CHECKED_FORUM' => $checked_forums,
		'CHECKED_CATS' => $checked_cats,
		'CHECKED_AUTHOR' => $checked_author,
		'CHECKED_TERMS' => $checked_terms,
		'CHECKED_FIELDS' => $checked_fields,
		'CHECKED_SORT_BY' => $checked_sort_by,
		'CHECKED_SORT_DIR' => $checked_sort_dir,
		'CHECKED_NOT_ADMIN' => $checked_not_admin,
		'CHECKED_NOT_MOD' => $checked_not_mod,
		'U_PHRASES' => append_sid("admin_search_phrases.$phpEx?page=phrases"),
		'U_STATS' => append_sid("admin_search_phrases.$phpEx?page=stats"),
		'U_WORDS' => append_sid("admin_search_phrases.$phpEx?page=words"),
		'U_BACKUP_DATA' => append_sid("admin_search_phrases.$phpEx?page=backup&amp;structure=0"),
		'U_BACKUP_DATA_STRUCTURE' => append_sid("admin_search_phrases.$phpEx?page=backup&amp;structure=1"),
		'S_CONFIG_ACTION' => append_sid("admin_search_phrases.$phpEx?page=config"),
		'S_MODE_SELECT' => $select_mode
	));

	/**
	 * Associate on/off values in checkboxes with integers
	 */
	$status = (isset($HTTP_POST_VARS['status'])) ? 1 : 0;
	$phrases = (isset($HTTP_POST_VARS['phrases'])) ? 1 : 0;
	$users = (isset($HTTP_POST_VARS['users'])) ? 1 : 0;
	$referer = (isset($HTTP_POST_VARS['referer'])) ? 1 : 0;
	$ips = (isset($HTTP_POST_VARS['ips'])) ? 1 : 0;
	$forums = (isset($HTTP_POST_VARS['forums'])) ? 1 : 0;
	$cats = (isset($HTTP_POST_VARS['cats'])) ? 1 : 0;
	$authors = (isset($HTTP_POST_VARS['authors'])) ? 1 : 0;
	$terms = (isset($HTTP_POST_VARS['terms'])) ? 1 : 0;
	$fields = (isset($HTTP_POST_VARS['fields'])) ? 1 : 0;
	$sort_by = (isset($HTTP_POST_VARS['sort_by'])) ? 1 : 0;
	$sort_dir = (isset($HTTP_POST_VARS['sort_dir'])) ? 1 : 0;
	$not_admin = (isset($HTTP_POST_VARS['admin'])) ? 1 : 0;
	$not_mod = (isset($HTTP_POST_VARS['mod'])) ? 1 : 0;

	/**
	 * We will serialize this array and store it in the config table
	 */
	$store_array = array
	(
		's' => $status,
		'p' => $phrases,
		'u' => $users,
		'r' => $referer,
		'i' => $ips,
		'f' => $forums,
		'c' => $cats,
		'a' => $authors,
		't' => $terms,
		'flds' => $fields,
		'sb' => $sort_by,
		'sd' => $sort_dir,
		'na' => $not_admin,
		'nm' => $not_mod,
		'v' => $config_array['v']
	);

	/**
	 * Update the config table
	 */
	if (isset($HTTP_POST_VARS['submit']))
	{
		$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = '" . serialize($store_array) . "'
		WHERE config_name = 'search_data'";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Failed to update general configuration for search_data', '', __LINE__, __FILE__, $sql);
		}

		$message = $lang['Search_config_updated'] . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}

	/**
	 * Delete everything. Moved to here from the phrases page
	 * Makes sense to put all the utility stuff in the same page
	 */
	if ($purge)
	{
		if (!$confirm)
		{
			$hidden_fields = '<input type="hidden" name="purge" value="delete" /><input type="hidden" name="cancel" value="cancel" />';

			$template->set_filenames(array( 'confirm' => 'confirm_body.tpl' ));

			$template->assign_vars(array
			(
				'MESSAGE_TITLE' => $lang['Confirm'],
				'MESSAGE_TEXT' => $lang['Confirm_delete_search_phrases'],
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'S_CONFIRM_ACTION' => append_sid("admin_search_phrases.$phpEx?page=config"),
				'S_HIDDEN_FIELDS' => $hidden_fields
			));

			if ($cancel)
			{
				redirect('admin/' . append_sid("admin_search_phrases.$phpEx?page=config", true));
			}
			$template->pparse('confirm');
		}
		else
		{
			$sql = "DELETE FROM " . SEARCH_PHRASES_TABLE;

			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete search data', '', __LINE__, __FILE__, $sql);
			}

			$message = $lang['Search_phrases_purged'] . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
		exit;
	}

	/**
	 * Delete selected values
	 */
	$find = ($mode == 'search_user_ip') ? encode_ip($find) : $find;

	if ($delete && !empty($find))
	{
		$sql = "DELETE FROM " . SEARCH_PHRASES_TABLE . "
		WHERE $mode = '$find'";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not delete search data', '', __LINE__, __FILE__, $sql);
		}

		$affected_rows = $db->sql_affectedrows($sql);

		if ($affected_rows == 0)
		{
			$message = sprintf($lang['No_matches'], $mode, $find) . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
		}
		else
		{
			$message = sprintf($lang['Selective_deleted'], $affected_rows) . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
		}
		message_die(GENERAL_MESSAGE, $message);
	}

	/**
	 * Tidy up user input. It's amazing what finds
	 * its way into the database from user input.
	 */
	$bogus_chars = array
	(
		'`',
		'´',
		'[',
		']',
		'{',
		'}',
		'~',
		'¨',
		'”',
		'“'
	);

	if (isset($HTTP_POST_VARS['tidy']))
	{
		$sql = "SELECT search_phrase, search_id
		FROM " . SEARCH_PHRASES_TABLE;

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not query search data', '', __LINE__, __FILE__, $sql);
		}

		$affected_rows = 0;

		/**
		 * Make our bogus charaters array readable by preg_match()
		 */
		$check_bogus_chars = '(' . implode('|', $bogus_chars) . ')';

		while ($row = $db->sql_fetchrow($result))
		{
			$phrase = $row['search_phrase'];
			$phrase_id = $row['search_id'];
			if (preg_match('#(^\s|\s$|\s{2,})#', $phrase) || preg_match("#$check_bogus_chars#", $phrase))
			{
				/**
				 * Add a notice to entries that have
				 * been stripped of bogus characters
				 */
				$phrase = (isset($HTTP_POST_VARS['bogus']) && preg_match("#$check_bogus_chars#", $phrase)) ? str_replace($bogus_chars, '', $phrase . '<br /><br />' . $lang['Bogus_cleaned']) : $phrase;
				$phrase = trim(preg_replace('#\s+#', ' ', str_replace("'", "''", $phrase)));

				/**
				 * Yes, I know. A query inside a loop. Not good.
				 * I am not sure there's a way around this, though.
				 */
				$sql = "UPDATE " . SEARCH_PHRASES_TABLE . "
				SET search_phrase = '$phrase'
				WHERE search_id = $phrase_id";
				if (!$result2 = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not tidy up search data', '', __LINE__, __FILE__, $sql);
				}
				else
				{
					$affected_rows += 1;
				}
			}
		}

		if ($affected_rows == 0)
		{
			$message = $lang['No_tidy_matches'] . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}

		$message = sprintf($lang['Tidy_ok'], $affected_rows) . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}

	$show_bogus_chars = implode(' ', $bogus_chars);

	/**
	 * Version check
	 */
	if (isset($HTTP_POST_VARS['version']))
	{
		/**
		 * First check to see whether the last version check
		 * happened within the past 24 hours.
		 */
		if (time() - 86400 < $config_array['v'])
		{
			$message = sprintf($lang['Version_check_deny'], create_date($board_config['default_dateformat'], $config_array['v'], $board_config['board_timezone'])) . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}

		/**
		 * Connect to the release topic at phpBB and dig out the latest version
		 * from the html on the page. First check to see whether CURL is compiled.
		 */
		if (extension_loaded('curl'))
		{
			$ch = curl_init(DOWNLOAD_TOPIC);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$content = curl_exec($ch);
			curl_close($ch);
		}
		else
		{
			if (phpversion() == '4.4.2')
			{
				$message = sprintf($lang['PHP_Version_disclaimer'], phpversion()) . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
				message_die(GENERAL_MESSAGE, $message);
			}

			$download_topic = fopen(DOWNLOAD_TOPIC, 'r');
			$content = '';

			while (!feof($download_topic))
			{
				$content .= fread($download_topic, 4096);
			}
			fclose($download_topic);
		}

		$begin = strpos($content, 'MOD Version</span>: ') + 20;
		$end = strpos($content, '(<span style="font-style: italic">Updated');
		$length = $end - $begin;
		$version = substr($content, $begin, $length);
		$version = trim($version);

		/**
		 * Create a direct link to the downloadable file
		 */
		$begindl = strpos($content, 'Download File</span>: <a href="') + 31;
		$enddl = strpos($content, ' target="_blank" class="postlink">searchdata') - 1;
		$lengthdl = $enddl - $begindl;
		$dl = substr($content, $begindl, $lengthdl);
		$dl = trim($dl);

		/**
		 * Log the version check time.
		 */
		$config_array['v'] = time();

		$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = '" . serialize($config_array) . "'
		WHERE config_name = 'search_data'";

		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Failed to update general configuration for search_data', '', __LINE__, __FILE__, $sql);
		}
		if ($version > SD_VERSION)
		{
			$message = sprintf($lang['Version_check_not_latest'], SD_VERSION, $version) . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Download_latest'], "<a href=\"" . $dl . "\">", "</a>", $version);
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$message = $lang['Version_check_latest'] . "<br /><br />" . sprintf($lang['Click_return_search_config'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=config") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_search_phrases'], "<a href=\"" . append_sid("admin_search_phrases.$phpEx?page=phrases") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
	}

	/**
	 * Maybe this is a bit extravagant. I'm using one query just to set up
	 * a switch...!
	 */
	$sql = "SELECT search_id FROM " . SEARCH_PHRASES_TABLE . " LIMIT 1";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not check search data', '', __LINE__, __FILE__, $sql);
	}

	/**
	 * And voilà - the famous switch
	 */
	if ($db->sql_numrows($result) > 0)
	{
		$template->assign_block_vars('switch_options', array());

		/**
		 * Read the stopwords file so that we can show the
		 * stopwords in the config page
		 */
		$stopwords = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_stopwords.txt");
		$count_stopwords = count($stopwords);

		for ($i = 0; $i < $count_stopwords; $i++)
		{
			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_options.stopwords_row', array
			(
				'ROW_CLASS' => $row_class,
				'STOPWORD' => trim($stopwords[$i])
			));
		}

		/**
		 * Read the synonums file
		 */
		$synonyms = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . "/search_synonyms.txt");
		$count_synonyms = count($synonyms);
		for ($i = 0; $i < $count_synonyms; $i++)
		{
			$synonym = explode(' ', $synonyms[$i]);

			$row_class = (!($i % 2)) ? $theme['td_class1'] : $theme['td_class2'];
			$template->assign_block_vars('switch_options.synonyms_row', array
			(
				'ROW_CLASS' => $row_class,
				'ORIG' => trim($synonym[0]),
				'SYNONYM' => trim($synonym[1])
			));
		}
	}

	$template->assign_vars(array
	(
		'L_BOGUS_CHARS' => $lang['Bogus_chars'],
		'BOGUS_CHARS' => $show_bogus_chars,
		'L_VERSION_CHECK' => $lang['Version_check'],
		'L_VERSION_CHECK_EXPLAIN' => sprintf($lang['Version_check_explain'], SD_VERSION),
		'L_CHECK_NOW' => $lang['Check_now'],
		'L_STOPWORDS' => $lang['Stopwords'],
		'L_SYNONYMS' => $lang['Synonyms'],
		'L_REBUILD_SEARCH' => $lang['Rebuild_search'],
		'COUNT_STOPWORDS' => $count_stopwords,
		'COUNT_SYNONYMS' => $count_synonyms,
		'U_REBUILD_SEARCH' => append_sid("admin_rebuild_search.$phpEx")
	));

	/**
	 * Rebuild search is a great MOD, and if it is
	 * installed we may as well link to it.
	 */
	if (file_exists("admin_rebuild_search.$phpEx"))
	{
		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_rebuild_search.' . $phpEx);
		$template->assign_block_vars('switch_rebuild_search', array());
	}
}
/**
 * Backup
 */
elseif ($page == 'backup')
{
	@set_time_limit(0);

	/**
	 * Get all the data
	 */
	$sql = "SELECT * FROM " . SEARCH_PHRASES_TABLE;

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error fetching search data', '', __LINE__, __FILE__, $sql);
	}

	/**
	 * Construct the insert queries. I was considering skipping
	 * the search_id field since it is auto increment. That would
	 * have enabled us to merge data, but the backup file will be
	 * more than twice the size (because the fields would have to
	 * be defined), so I decided to just dump everything.
	 * Of course, people can just use the purge function which
	 * deletes instead of truncates, so the new search_id's will
	 * start where the old ones left off.
	 */
	$backupdata = '';

	while ($row = $db->sql_fetchrow($result))
	{
		/**
		 * We're running a few procedures here in order to avoid
		 * mis-constructed INSERT queries.
		 */
		$searchphrase = addslashes(str_replace("'", "''", $row['search_phrase']));
		$searchphrase = preg_replace('#\n#', ' ', $searchphrase);
		$searchphrase = preg_replace('#\s+#', ' ', $searchphrase);

		$searchauthor = addslashes(str_replace("'", "''", $row['search_author']));
		$searchauthor = preg_replace('#\n#', ' ', $searchauthor);
		$searchauthor = preg_replace('#\s+#', ' ', $searchauthor);

		$searchreferer = addslashes(str_replace("'", "''", $row['search_referer']));
		$searchreferer = preg_replace('#\n#', ' ', $searchreferer);
		$searchreferer = preg_replace('#\s+#', ' ', $searchreferer);

		$backupdata .= 'INSERT INTO `' . SEARCH_PHRASES_TABLE . '` VALUES (' . $row['search_id'] . ', ' . $row['search_user_id'] . ', \'' . $row['search_user_ip'] . '\', ' . $row['search_time'] . ', \'' . $searchphrase . '\', \'' . $searchauthor . '\', \'' . $searchreferer . '\', ' . $row['search_failed'] . ', ' . $row['search_terms'] . ', ' . $row['search_fields'] . ', ' . $row['search_return_chars'] . ', ' . $row['search_cat'] . ', ' . $row['search_forum'] . ', ' . $row['search_sort_by'] . ', \'' . str_replace("'", "''", $row['search_sort_dir']) . '\');' . "\r\n";
	}

	/**
	 * Set basic parameters for creating backup file
	 * Much of this is adapted from phpMyAdmin
	 */
	$mime_type = (strpos(strtolower($HTTP_SERVER_VARS['HTTP_USER_AGENT']), 'safari') !== false) ? 'application/octet-stream' : 'text/x-sql';

	$bu_file = 'phpbb_searchdata';
	$bu_date = date('dmy', time());
	$bu_extension = '.sql';

	/**
	 * Let's generate some header information. Hey - it almost
	 * looks like a file created in phpMyAdmin...Does this count
	 * as hard coded English? Do we really need lang variables for
	 * this..?
	 */
	$header = '-- phpBB Search Data SQL Dump';
	$header .= "\r\n" . '-- Generation Time: ' . date('r', time());
	$header .= "\r\n" . '--';
	$header .= "\r\n" . '-- Host: ' . $HTTP_SERVER_VARS['SERVER_SIGNATURE'];
	$header .= "\r\n" . '-- PHP Version: ' . phpversion();
	$header .= "\r\n" . '-- Database Type: ' . SQL_LAYER;
	$header .= "\r\n" . '--';
	$header .= "\r\n" . '-- Dumping data for table: ' . SEARCH_PHRASES_TABLE;
	$header .= "\r\n" . '--' . "\r\n\r\n";

	/**
	 * User can opt to include the table structure in the backup file.
	 */
	$table_structure = '';

	if ($HTTP_GET_VARS['structure'])
	{
		$table_structure = 'CREATE TABLE `phpbb_search_phrases` (';
		$table_structure .= "\r\n\t" . '`search_id` mediumint(6) NOT NULL auto_increment,';
		$table_structure .= "\r\n\t" . '`search_user_id` smallint(4) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_user_ip` varchar(8) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_time` int(11) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_phrase` varchar(255) NOT NULL default \'\'';
		$table_structure .= "\r\n\t" . '`search_author` varchar(25) NOT NULL default \'\'';
		$table_structure .= "\r\n\t" . '`search_referer` varchar(255) NOT NULL default \'\'';
		$table_structure .= "\r\n\t" . '`search_failed` tinyint(1) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_terms` tinyint(1) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_fields` tinyint(1) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_return_chars` smallint(4) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_cat` smallint(3) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_forum` smallint(3) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_sort_by` tinyint(1) NOT NULL default \'0\'';
		$table_structure .= "\r\n\t" . '`search_sort_dir` varchar(4) NOT NULL default \'\'';
		$table_structure .= "\r\n\t" . 'PRIMARY KEY (`search_id`)';
		$table_structure .= "\r\n" . ');';
		$table_structure .= "\r\n\r\n";
	}

	/**
	 * Some browsers need the file size.
	 */
	$filesize = strlen($header) + strlen($table_structure) + strlen($backupdata);

	header('Content-Length: ' . $filesize);
	header('Content-Type: ' . $mime_type);
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

	if (strpos($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE') !== false || strpos($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Windows') !== false)
	{
		header('Content-Disposition: inline; filename="' . $bu_file . $bu_date . $bu_extension . '"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	}
	else
	{
		header('Content-Disposition: attachment; filename="' . $bu_file . $bu_date . $bu_extension . '"');
		header('Pragma: no-cache');
	}

	/**
	 * Send the file to the browser
	 */
	echo $header . $table_structure . $backupdata;
	exit;
}

$template->pparse('body');

include('./page_footer_admin.' . $phpEx);
?>

