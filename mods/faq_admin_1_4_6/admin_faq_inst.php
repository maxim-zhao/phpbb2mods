<?php

define('IN_PHPBB', 1);

// entries to be displayed in the ACP index
if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['FAQ_Admin']['FAQ lang installer'] = "$file";
	return;
}
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

// ------------------
// Begin function block
//
function language_select($dirname="language")
{
	global $phpEx, $phpbb_root_path;

	$dir = opendir($phpbb_root_path . $dirname);

	$lang = array();
	while ( $file = readdir($dir) )
	{
		if (preg_match('#^lang_#i', $file) && !is_file($phpbb_root_path . $dirname . '/' . $file) && !is_link($phpbb_root_path . $dirname . '/' . $file))
		{
			$filename = trim(str_replace("lang_", "", $file));
			$displayname = preg_replace("/^(.*?)_(.*)$/", "\\1 [ \\2 ]", $filename);
			$displayname = preg_replace("/\[(.*?)_(.*)\]/", "[ \\1 - \\2 ]", $displayname);
			$lang[$displayname] = $filename;
		}
	}

	closedir($dir);

	@asort($lang);
	@reset($lang);
	$lang_list_new = array();
	while ( list($displayname, $filename) = @each($lang) )
	{
		$lang_list_new[] = $filename;
	}

	return $lang_list_new;
}
function get_lang_list()
{
	global $db;

	$sql = "SELECT lang_id, count(faq_id) AS faq_count FROM " . FAQ_TABLE . " GROUP BY lang_id";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Languages", "", __LINE__, __FILE__, $sql);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$lang_list_exs[] = $row['lang_id'];
	}

	return $lang_list_exs;
}
function removeduplicates (&$array1,&$array2)
{
	$retval = array();
	foreach ($array2 as $key => $value)
	{
		if ( @!in_array($value, $array1) )
		{
			$retval[] = $value;
		}
	}
	return $retval;
}
function insert_faq($faq, $cat_table, $text_table, $slang)
{
	global $db;

	$inserts = array(0,0);

	$sql = "SELECT q_id FROM " . $text_table . " WHERE lang_id = '" . $slang . "' ORDER BY q_id DESC LIMIT 1";
	if( !$q_questions = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Could not query faq list", "", __LINE__, __FILE__, $sql);
	}
	$questions_rows = $db->sql_fetchrowset($q_questions);
	$q_id = $questions_rows[0]['q_id'];

	foreach($faq as $k => $v)
	{
		if ($faq[$k][0] == '--')
		{
			$sql = "SELECT faq_id FROM " . $cat_table . " WHERE lang_id = '" . $slang . "' ORDER BY faq_id DESC LIMIT 1";
			if( !$q_categories = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not query categories list", "", __LINE__, __FILE__, $sql);
			}
			$category_rows = $db->sql_fetchrowset($q_categories);
			$cat_id = $category_rows[0]['faq_id']+1;
			$sql = "INSERT INTO " . $cat_table . " (lang_id, faq_id, faq_title) VALUES ('" . $slang . "', '" . $cat_id . "','" . addslashes($faq[$k][1]) . "')";
			$inserts[0]++;
			if( !$q_categories = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in categories table", "", __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$sql = "SELECT q_id FROM " . $text_table . " WHERE lang_id = '" . $slang . "' ORDER BY q_id DESC LIMIT 1";
			if( !$q_questions = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not query faq list", "", __LINE__, __FILE__, $sql);
			}
			$questions_rows = $db->sql_fetchrowset($q_questions);
			$q_id++;
			$sql = "INSERT INTO " . $text_table . " (lang_id, q_id, faq_id, q, a) VALUES ('" . $slang . "','" . $q_id . "','" . $cat_id . "','" . addslashes($faq[$k][0]) . "', '" . addslashes($faq[$k][1]) . "')";
			$inserts[1]++;
			if( !$q_questions = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in faq table", "", __LINE__, __FILE__, $sql);
			}
		}
	}
	return $inserts;
}
//
// End function block
// ------------------

if ( isset($HTTP_POST_VARS['slang']) )
{
	if ( isset($HTTP_POST_VARS['add']) )
	{
		include($phpbb_root_path . 'language/lang_' . $HTTP_POST_VARS['slang'] . '/lang_faq.' .$phpEx);
		$inserts_faq = insert_faq($faq, FAQ_TABLE, FAQ_TEXT_TABLE, $HTTP_POST_VARS['slang']);
		unset($faq);
		include($phpbb_root_path . 'language/lang_' . $HTTP_POST_VARS['slang'] . '/lang_bbcode.' .$phpEx);
		$inserts_bbcode = insert_faq($faq, BBCODE_TABLE, BBCODE_TEXT_TABLE, $HTTP_POST_VARS['slang']);
		unset($faq);
	}
	else
	{
		$inserts_faq = array(0,0);
		$sql = "DELETE FROM " . FAQ_TABLE . " WHERE lang_id = '" . $HTTP_POST_VARS['slang'] . "'";
		if( !$q_questions = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't delete category", "", __LINE__, __FILE__, $sql);
		}
		$inserts_faq[0] = $db->sql_affectedrows();
		$sql = "DELETE FROM " . FAQ_TEXT_TABLE . " WHERE lang_id = '" . $HTTP_POST_VARS['slang'] . "'";
		if( !$q_questions = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't delete faq", "", __LINE__, __FILE__, $sql);
		}
		$inserts_faq[1] = $db->sql_affectedrows();
		$inserts_bbcode = array(0,0);
		$sql = "DELETE FROM " . BBCODE_TABLE . " WHERE lang_id = '" . $HTTP_POST_VARS['slang'] . "'";
		if( !$q_questions = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't delete category", "", __LINE__, __FILE__, $sql);
		}
		$inserts_bbcode[0] = $db->sql_affectedrows();
		$sql = "DELETE FROM " . BBCODE_TEXT_TABLE . " WHERE lang_id = '" . $HTTP_POST_VARS['slang'] . "'";
		if( !$q_questions = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't delete faq", "", __LINE__, __FILE__, $sql);
		}
		$inserts_bbcode[1] = $db->sql_affectedrows();
	}
	$template->assign_vars(array(
		'L_FAQ_TITLE' => $lang['Faq_admin'], 
		'L_FAQ_EXPLAIN' => $lang['faq_admin_ad_explain'], 
		'L_AFFECTED_ROWS_FAQ' => $lang['Aff_rows_faq'], 
		'L_AFFECTED_ROWS_BBCODE' => $lang['Aff_rows_bbcode'], 
		'L_AFFECTED_ROWS_CAT' => $lang['Aff_rows_cat_t'], 
		'L_AFFECTED_ROWS_Q' => $lang['Aff_rows_q_t'], 
		'L_FAQ_CAT' => $inserts_faq[0], 
		'L_FAQ_Q' => $inserts_faq[1], 
		'L_BBCODE_CAT' => $inserts_bbcode[0], 
		'L_BBCODE_Q'=> $inserts_bbcode[1])
	);
	$template->set_filenames(array(
		'body' => 'admin/admin_faq_inst_aff.tpl')
	);
}
else
{
	$dblang = get_lang_list();
	$hdlang = language_select();
	if ( is_array($hdlang) )
	{
		$nodblang = removeduplicates($dblang, $hdlang);
	}
	if ( is_array($nodblang) && isset($nodblang[0]) )
	{
		foreach ($nodblang as $v)
		{
			$add_select .= "<option value=\"$v\">$v</option>";
		}
	}
	else
	{
		$add_select .= "<option value=\"\">" . $lang['no_language_on_hd'] . "</option>";
	}
	if ( is_array($dblang) )
	{
		foreach ($dblang as $v)
		{
			$del_select .= "<option value=\"$v\">$v</option>";
		}
	}
	else
	{
		$del_select .= "<option value=\"\">" . $lang['no_language_in_db'] ."</option>";
	}
	$template->assign_vars(array(
		'L_FAQ_TITLE' => $lang['Faq_admin'], 
		'L_FAQ_EXPLAIN' => $lang['faq_admin_ad_explain'], 
		'L_ADD' => $lang['Add_new'], 
		'L_DEL' => $lang['Delete'], 
		'S_ACTION' => $file, 
		'S_LANG_LIST_ADD' => $add_select, 
		'S_LANG_LIST_DEL' => $del_select)
	);
	$template->set_filenames(array(
		'body' => 'admin/admin_faq_inst.tpl')
	);
}

//
// Start output of page
//
$page_title = $lang['Index'];

$template->pparse('body');

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>