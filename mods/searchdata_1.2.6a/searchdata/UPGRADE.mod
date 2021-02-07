##############################################################
## MOD Title: Search Data - Upgrade to 1.1.0
## MOD Author: Joe Belmaati < belmaati@gmail.com > (Joe Belmaati) N/A
## MOD Description: This file will upgrade previous installations
## of Search Data to version 1.1.1
## MOD Version: 1.1.1
##
## Installation Level: Intermediate
## Installation Time: 2 Minutes
## Files To Edit: (1)
##				includes/functions_search.php,
##
## Included Files: (5)
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
## Author Notes: Should install with EasyMOD. This upgrade
## will work to update all earlier versions of this MOD
##############################################################
#
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
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
#-----[ OPEN ]------------------------------------------
#
includes/functions_search.php
#
#-----[ FIND ]------------------------------------------
#
function track_search(&$user_id, &$user_ip, &$search_time, &$search_keywords, &$search_author, &$search_referer, $search_failed, $search_terms, $search_fields, &$search_return_chars, &$search_cat, &$search_forum, &$search_sort_by, &$search_sort_dir)
{
	global $db, $board_config;

	$search_keywords = (empty($search_keywords)) ? $search_author : $search_keywords;

	if (!empty($search_keywords))
	{
		$search_author = str_replace("\'", "''", $search_author);
		$search_keywords = str_replace("\'", "''", $search_keywords);
		$search_referer = (strpos($search_referer, $board_config['sitename']) === FALSE) ? $search_referer : '';

		$sql = "INSERT INTO " . SEARCH_PHRASES_TABLE . " (search_user_id, search_user_ip, search_time, search_phrase, search_author, search_referer, search_failed, search_terms, search_fields, search_return_chars, search_cat, search_forum, search_sort_by, search_sort_dir)
		VALUES ($user_id, '$user_ip', $search_time, '$search_keywords', '$search_author', '$search_referer', $search_failed, '$search_terms', '$search_fields', '$search_return_chars', '$search_cat', '$search_forum', '$search_sort_by', '$search_sort_dir')";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could insert search information', '', __LINE__, __FILE__, $sql);
		}
	}
}
#
#-----[ REPLACE WITH ]------------------------------------------
#
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
		$search_author = str_replace("\'", "''", $search_author);
		$search_keywords = str_replace("\'", "''", $search_keywords);
		$search_referer = (strpos($search_referer, $board_config['sitename']) === FALSE) ? $search_referer : '';

		$sql = "INSERT INTO " . SEARCH_PHRASES_TABLE . " (search_user_id, search_user_ip, search_time, search_phrase, search_author, search_referer, search_failed, search_terms, search_fields, search_return_chars, search_cat, search_forum, search_sort_by, search_sort_dir)
		VALUES ($user_id, '$user_ip', $search_time, '$search_keywords', '$search_author', '$search_referer', $search_failed, '$search_terms', '$search_fields', '$search_return_chars', '$search_cat', '$search_forum', '$search_sort_by', '$search_sort_dir')";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could insert search information', '', __LINE__, __FILE__, $sql);
		}
	}
}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
