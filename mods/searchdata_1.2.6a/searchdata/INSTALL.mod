##############################################################
## MOD Title: Search Data
## MOD Author: Joe Belmaati < belmaati@gmail.com > (Joe Belmaati) N/A
## MOD Description: With this MOD you can track what your users are
## searching your board for. Includes neat admin panel for monitoring
## the action. There's also a statistics page, and a page that breaks
## the search phrases into single words.
## MOD Version: 1.2.6
##
## Installation Level: Intermediate
## Installation Time: 5 Minutes
## Files To Edit: (4)
##				search.php,
##				includes/constants.php,
##				includes/functions_search.php,
##				language/lang_english/lang_admin.php
##
## Included Files: (6)
##				admin/admin_search_phrases.php,
##				language/lang_english/lang_searchdata.php,
##				templates/subSilver/admin/search_phrases.tpl
##				templates/subSilver/admin/search_phrases_config.tpl
##				templates/subSilver/admin/search_phrases_stats.tpl
##				templates/subSilver/admin/search_phrases_words.tpl
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Should install with EasyMOD.
##
##############################################################
## MOD History:
##
##   2006-04-13 - 1.2.6
##			- Making MOD installable on phpBB 2.0.20
##
##   2006-04-03 - 1.2.5
##			- Making MOD xhtml compliant
##
##   2006-03-30 - 1.2.4
##			- Small fixes
##
##   2006-03-21 - 1.2.3
##			- Fix for bug in php 4.4.2
##
##   2006-03-14 - 1.2.2
##			- Small fix
##
##   2006-03-14 - 1.2.1
##			- Small fixes related to backup procedure and urldecode()
##
##   2006-02-26 - 1.2.0
##			- Fixes: Lots of small fixes: Slicker selective delete
##			  handling. Pagination bug in phrases page when
##			  displaying selective results fixed. Percentage
##			  miscalculation in words page fixed. Much improved
##            search and sort in phrases page.
##          - New: Searching for specific entries shows query result
##          - New: Show statistics for specific periods
##          - New: Backup your search data table
##          - New: Strip bogus characters and unwanted space
##          - New: Version checker
##          - New: Utilities neatly organized in config page
##          - New: View stopwords
##          - New: View synonyms
##
##   2006-01-26 - 1.1.1
##			- Egads! Small bug in admin_search_phrases corrected
##
##   2006-01-26 - 1.1.0
##			- new configuration and delete options
##			- small code change in a delete query suggested by Porutchik
##
##   2006-01-16 - 1.0.2
##			- fixed remote avatar bug reported by Kulinar
##			- fixed header problem that occurs on some systems
##
##   2006-01-04 - 1.0.1
##			- semantic anomalies in install file corrected
##			- code indentation in admin_search_phrases changed
##
##   2006-01-03 - 1.0.0
##			- MOD submitted to MODS database at phpBB.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
CREATE TABLE `phpbb_search_phrases` (
  `search_id` mediumint(6) NOT NULL auto_increment,
  `search_user_id` smallint(4) NOT NULL default '0',
  `search_user_ip` varchar(8) NOT NULL default '0',
  `search_time` int(11) NOT NULL default '0',
  `search_phrase` varchar(255) NOT NULL default '',
  `search_author` varchar(25) NOT NULL default '',
  `search_referer` varchar(255) NOT NULL default '',
  `search_failed` tinyint(1) NOT NULL default '0',
  `search_terms` tinyint(1) NOT NULL default '0',
  `search_fields` tinyint(1) NOT NULL default '0',
  `search_return_chars` smallint(4) NOT NULL default '0',
  `search_cat` smallint(3) NOT NULL default '0',
  `search_forum` smallint(3) NOT NULL default '0',
  `search_sort_by` tinyint(1) NOT NULL default '0',
  `search_sort_dir` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`search_id`)
);

INSERT INTO `phpbb_config` ( `config_name` , `config_value` )
VALUES ('search_data', '');
#
#-----[ COPY ]------------------------------------------
#
copy admin/admin_search_phrases.php to admin/admin_search_phrases.php
copy language/lang_english/lang_searchdata.php to language/lang_english/lang_searchdata.php
copy templates/subSilver/admin/search_phrases.tpl to templates/subSilver/admin/search_phrases.tpl
copy templates/subSilver/admin/search_phrases_config.tpl to templates/subSilver/admin/search_phrases_config.tpl
copy templates/subSilver/admin/search_phrases_stats.tpl to templates/subSilver/admin/search_phrases_stats.tpl
copy templates/subSilver/admin/search_phrases_words.tpl to templates/subSilver/admin/search_phrases_words.tpl
#
#-----[ OPEN ]------------------------------------------
#
search.php
#
#-----[ FIND ]------------------------------------------
#
			message_die(GENERAL_MESSAGE, $lang['No_search_match']);
		}

		//
		// Delete old data from the search result table
#
#-----[ BEFORE, ADD ]------------------------------------------
#
			track_search($userdata['user_id'], $user_ip, time(), $search_keywords, $search_author, $HTTP_SERVER_VARS['HTTP_REFERER'], '1', $search_terms, $search_fields, $return_chars, $search_cat, $search_forum, $sort_by, $sort_dir);
#
#-----[ FIND ]------------------------------------------
#
	//
	// Look up data ...
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	//
	// Insert into search phrase table
	//
	track_search($userdata['user_id'], $user_ip, time(), $search_keywords, $search_author, $HTTP_SERVER_VARS['HTTP_REFERER'], '0', $search_terms, $search_fields, $return_chars, $search_cat, $search_forum, $sort_by, $sort_dir);
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
define('SEARCH_MATCH_TABLE', $table_prefix.'search_wordmatch');
#
#-----[ AFTER, ADD ]------------------------------------------
#
define('SEARCH_PHRASES_TABLE', $table_prefix.'search_phrases');
#
#-----[ OPEN ]------------------------------------------
#
includes/functions_search.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Track search data
//
function track_search(&$user_id, &$user_ip, &$search_time, &$search_keywords, &$search_author, &$search_referer, $search_failed, $search_terms, $search_fields, &$search_return_chars, &$search_cat, &$search_forum, &$search_sort_by, &$search_sort_dir)
{
	global $db, $board_config, $userdata;

	$search_config = unserialize($board_config['search_data']);

	if($search_config['status'] || ($search_config['admin'] && $userdata['user_level'] == ADMIN) || ($search_config['mod'] && $userdata['user_level'] == MOD))
	{
		return;
	}

	$search_keywords = (empty($search_keywords)) ? $search_author : $search_keywords;

	if (!empty($search_keywords))
	{
		$search_author = str_replace("\'", "''", trim($search_author));
		$search_keywords = str_replace("\'", "''", trim($search_keywords));
		$search_referer = (strpos($search_referer, $board_config['sitename']) === FALSE) ? $search_referer : '';

		$sql = "INSERT INTO " . SEARCH_PHRASES_TABLE . " (search_user_id, search_user_ip, search_time, search_phrase, search_author, search_referer, search_failed, search_terms, search_fields, search_return_chars, search_cat, search_forum, search_sort_by, search_sort_dir)
		VALUES ($user_id, '$user_ip', $search_time, '$search_keywords', '$search_author', '$search_referer', $search_failed, '$search_terms', '$search_fields', '$search_return_chars', '$search_cat', '$search_forum', '$search_sort_by', '$search_sort_dir')";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could insert search information', '', __LINE__, __FILE__, $sql);
		}
	}
}
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Search Phrases
//
$lang['Search_phrases'] = 'Search Phrases';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
