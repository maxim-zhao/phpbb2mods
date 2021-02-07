<?php

define('IN_PHPBB', 1);

// entries to be displayed in the ACP index
if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['FAQ_Admin']['FAQ Admin'] = "$file";
	$module['FAQ_Admin']['BBCode Admin'] = "$file?type=bbcode";
	return;
}
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

//
// Load the appropriate sql-statement
//
if( isset($HTTP_GET_VARS['type']) || isset($HTTP_POST_VARS['type']) )
{
	$type = ( isset($HTTP_GET_VARS['type']) ) ? $HTTP_GET_VARS['type'] : $HTTP_POST_VARS['type'];
	switch( $type )
	{
		case 'bbcode':
			$lang_sql = '1';
			$l_title = $lang['bbcode_admin'];
			$cat_table = BBCODE_TABLE;
			$text_table = BBCODE_TEXT_TABLE;
			$faq_type = 'bbcode';
			break;
		default:
			$lang_sql = '0';
			$l_title = $lang['Faq_admin'];
			$cat_table = FAQ_TABLE;
			$text_table = FAQ_TEXT_TABLE;
			$faq_type = 'faq';
			break;
	}
}
else
{
	$lang_sql = '0';
	$l_title = $lang['Faq_admin'];
	$cat_table = FAQ_TABLE;
	$text_table = FAQ_TEXT_TABLE;
}
if ( isset($HTTP_POST_VARS['l']) || isset($HTTP_GET_VARS['l']) )
{
	$faq_lang = ( isset($HTTP_POST_VARS['l']) ) ? $HTTP_POST_VARS['l'] : $HTTP_GET_VARS['l'];
}
else
{
	$faq_lang = $userdata['user_lang'];
}
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}
else
{
	$mode = "";
}

// ------------------
// Begin function block
//
function get_info($mode, $id)
{
	global $db, $faq_lang, $cat_table, $text_table;

	switch($mode)
	{
		case 'cat':
			$table = $cat_table;
			$idfield = 'faq_id';
			$namefield = 'faq_title';
			break;

		case 'faq':
			$table = $text_table;
			$idfield = 'q_id';
			$namefield = 'q';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}
	$sql = "SELECT count(*) as total
		FROM " . $table . " WHERE lang_id = '" . $faq_lang . "'";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get Faq/Category information", "", __LINE__, __FILE__, $sql);
	}
	$count = $db->sql_fetchrow($result);
	$count = $count['total'];

	$sql = "SELECT *
		FROM " . $table . "
		WHERE " . $idfield . " = " . $id . " AND lang_id = '" . $faq_lang . "'"; 

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get Faq/Category information", "", __LINE__, __FILE__, $sql);
	}

	if( $db->sql_numrows($result) != 1 )
	{
		message_die(GENERAL_ERROR, "Faq/Category doesn't exist or multiple faq/categories with ID $id and " . $sql, "", __LINE__, __FILE__);
	}

	$return = $db->sql_fetchrow($result);
	$return['number'] = $count;
	return $return;
}

function get_list($mode, $id, $select)
{
	global $db, $faq_lang, $cat_table, $text_table;

	switch($mode)
	{
		case 'cat':
			$table = $cat_table;
			$idfield = 'faq_id';
			$namefield = 'faq_title';
			break;

		case 'faq':
			$table = $text_table;
			$idfield = 'q_id';
			$namefield = 'q';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}

	$sql = "SELECT *
		FROM " . $table . " WHERE lang_id = '" . $faq_lang . "'";
	if( $select == 0 )
	{
		$sql .= " AND " . $idfield . " <> " . $id . "";
	}

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Categories/Faq", "", __LINE__, __FILE__, $sql);
	}

	$cat_list = "";

	while( $row = $db->sql_fetchrow($result) )
	{
		$s = "";
		if ($row[$idfield] == $id)
		{
			$s = " selected=\"selected\"";
		}
		$catlist .= "<option value=\"$row[$idfield]\"$s>" . $row[$namefield] . "</option>\n";
	}

	return($catlist);
}


function get_lang_list($id)
{
	global $db, $cat_table;

	$sql = "SELECT lang_id, count(faq_id) AS faq_count FROM " . $cat_table . " GROUP BY lang_id";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Languages", "", __LINE__, __FILE__, $sql);
	}
	$cat_list = "";
	while( $row = $db->sql_fetchrow($result) )
	{
		$s = "";
		if ($row['lang_id'] == $id)
		{
			$s = " selected=\"selected\"";
		}
		$catlist .= "<option value=\"" . $row['lang_id'] . "\"$s>" . $row['lang_id'] . "</option>\n";
	}

	return($catlist);
}

//
// End function block
// ------------------
if( isset($HTTP_POST_VARS['addfaq']) || isset($HTTP_POST_VARS['addcategory']) )
{
	$mode = ( isset($HTTP_POST_VARS['addfaq']) ) ? "addfaq" : "addcat";

	if( $mode == "addfaq" )
	{
		list($faq_id) = each($HTTP_POST_VARS['addfaq']);
		// 
		// stripslashes needs to be run on this because slashes are added when the forum name is posted
		//
		$faqname = stripslashes($HTTP_POST_VARS['faqname'][$faq_id]);
	}
}

if( !empty($mode) ) 
{
	switch($mode)
	{
		case 'addfaq':
		case 'editfaq':
			//
			// Show form to create/modify a forum
			//
			if ($mode == 'editfaq')
			{
				// $newmode determines if we are going to INSERT or UPDATE after posting?

				$l_title = $lang['Edit_faq'];
				$newmode = 'modfaq';
				$buttonvalue = $lang['Update'];

				$faq_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

				$row = get_info('faq', $faq_id);

				$faq_id = $row['q_id'];
				$faq_name = $row['q'];
				$faq_desc = $row['a'];
				$cat_id = $row['faq_id'];
			}
			else
			{
				$l_title = $lang['Create_faq'];
				$newmode = 'createfaq';
				$buttonvalue = $lang['Create_faq'];

				$faq_name = $faqname;
				$faq_desc = '';
				$foo = array_keys($HTTP_POST_VARS['addfaq']);
				$cat_id = $foo[0];
			}

			$catlist = get_list('cat', $cat_id, TRUE);

			$template->set_filenames(array(
				"body" => "admin/faq_edit_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode .'" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $faq_id . '" /><input type="hidden" name="' . POST_FAQ_LANG . '" value="' . $faq_lang . '" /><input type="hidden" name="' . POST_FAQ_TYPE . '" value="' . $faq_type . '" />';

			$template->assign_vars(array(
				'S_FAQ_ACTION' => append_sid("admin_faq.$phpEx"),
				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_SUBMIT_VALUE' => $buttonvalue, 
				'S_CAT_LIST' => $catlist,
				'S_STATUS_LIST' => $statuslist,

				'L_FAQ_TITLE' => $l_title, 
				'L_FAQ_EXPLAIN' => $lang['Faq_edit_delete_explain'], 
				'L_FAQ_SETTINGS' => $lang['Faq_settings'], 
				'L_FAQ_NAME' => $lang['Faq_name'], 
				'L_CATEGORY' => $lang['Category'], 
				'L_FAQ_DESCRIPTION' => $lang['Faq_desc'],

				'FAQ_NAME' => $faq_name,
				'DESCRIPTION' => $faq_desc)
			);
			$template->pparse("body");
			break;

		case 'createfaq':
			//
			// Create a faq in the DB
			//
			if( trim($HTTP_POST_VARS['faqname']) == "" )
			{
				message_die(GENERAL_ERROR, "Can't create a faq without a name");
			}
			$sql = "SELECT q_id FROM " . $text_table . " WHERE lang_id = '" . $faq_lang . "' ORDER BY q_id DESC";
			if( !$q_questions = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not query faq list", "", __LINE__, __FILE__, $sql);
			}
			$questions_rows = $db->sql_fetchrowset($q_questions);
			$q_id = $questions_rows[0]['q_id']+1;
			// There is no problem having duplicate faq names so we won't check for it.
			$sql = "INSERT INTO " . $text_table . " (lang_id, q_id, faq_id, q, a)
				VALUES ('" . $faq_lang . "', '$q_id', " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ",'" . str_replace("\'", "''", $HTTP_POST_VARS['faqname']) . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['faqdesc']) . "')";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in faq table", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Faqs_updated'] . "<br /><br />" . sprintf($lang['Click_return_faqadmin'], "<a href=\"" . append_sid("admin_faq.$phpEx") . "&l=" . $faq_lang . "&type=" . $faq_type . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;

		case 'modfaq':
			// Modify a faq in the DB
			$sql = "UPDATE " . $text_table . "
				SET faq_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", q = '" . str_replace("\'", "''", $HTTP_POST_VARS['faqname']) . "', a = '" . str_replace("\'", "''", $HTTP_POST_VARS['faqdesc']) . "'
				WHERE q_id = " . intval($HTTP_POST_VARS[POST_FORUM_URL]) . " AND lang_id = '". $faq_lang . "'";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update faq information", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Faqs_updated'] . "<br /><br />" . sprintf($lang['Click_return_faqadmin'], "<a href=\"" . append_sid("admin_faq.$phpEx") . "&l=" . $faq_lang . "&type=" . $faq_type . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);

			break;
			
		case 'addcat':
			// Create a category in the DB
			if( trim($HTTP_POST_VARS['categoryname']) == '')
			{
				message_die(GENERAL_ERROR, "Can't create a category without a name");
			}
			$sql = "SELECT faq_id FROM " . $cat_table . " WHERE lang_id = '" . $faq_lang . "' ORDER BY faq_id DESC";
			if( !$q_categories = $db->sql_query($sql) )
			{
			        message_die(GENERAL_ERROR, "Could not query categories list", "", __LINE__, __FILE__, $sql);
			}
			$category_rows = $db->sql_fetchrowset($q_categories);
			$cat_id = $category_rows[0]['faq_id']+1;
			//
			// There is no problem having duplicate faq names so we won't check for it.
			//
			$sql = "INSERT INTO " . $cat_table . " (lang_id,faq_id,faq_title)
				VALUES ('" . $faq_lang . "','$cat_id', '" . str_replace("\'", "''", $HTTP_POST_VARS['categoryname']) . "')";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in categories table", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Faqs_updated'] . "<br /><br />" . sprintf($lang['Click_return_faqadmin'], "<a href=\"" . append_sid("admin_faq.$phpEx") . "&l=" . $faq_lang . "&type=" . $faq_type . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;
			
		case 'editcat':
			//
			// Show form to edit a category
			//
			$newmode = 'modcat';
			$buttonvalue = $lang['Update'];

			$faq_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$row = get_info('cat', $faq_id);
			$faq_title = $row['faq_title'];

			$template->set_filenames(array(
				"body" => "admin/category_edit_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="' . POST_CAT_URL . '" value="' . $faq_id . '" /><input type="hidden" name="' . POST_FAQ_LANG . '" value="' . $faq_lang . '" /><input type="hidden" name="' . POST_FAQ_TYPE . '" value="' . $faq_type . '" />';

			$template->assign_vars(array(
				'CAT_TITLE' => $faq_title,

				'L_EDIT_CATEGORY' => $lang['Edit_Category'], 
				'L_EDIT_CATEGORY_EXPLAIN' => $lang['Edit_Category_explain'], 
				'L_CATEGORY' => $lang['Category'], 

				'S_HIDDEN_FIELDS' => $s_hidden_fields, 
				'S_SUBMIT_VALUE' => $buttonvalue, 
				'S_FORUM_ACTION' => append_sid("admin_faq.$phpEx"))
			);

			$template->pparse("body");
			break;

		case 'modcat':
			// Modify a category in the DB
			$sql = "UPDATE " . $cat_table . "
				SET faq_title = '" . str_replace("\'", "''", $HTTP_POST_VARS['cat_title']) . "'
				WHERE faq_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]) . " AND lang_id = '". $faq_lang . "'";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update forum information", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Faqs_updated'] . "<br /><br />" . sprintf($lang['Click_return_faqadmin'], "<a href=\"" . append_sid("admin_faq.$phpEx") . "&l=" . $faq_lang . "&type=" . $faq_type . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;
			
		case 'deletefaq':
			// Show form to delete a faq
			$faq_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

			$buttonvalue = $lang['Delete'];

			$newmode = 'movedelfaq';

			$faqinfo = get_info('faq', $faq_id);
			$name = $faqinfo['q'];

			$template->set_filenames(array(
				"body" => "admin/forum_delete_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="from_id" value="' . $faq_id . '" /><input type="hidden" name="' . POST_FAQ_LANG . '" value="' . $faq_lang . '" /><input type="hidden" name="' . POST_FAQ_TYPE . '" value="' . $faq_type . '" />';

			$template->assign_vars(array(
				'NAME' => $name, 

				'L_FORUM_DELETE' => $lang['Faq_delete'], 
				'L_FORUM_DELETE_EXPLAIN' => $lang['Faq_delete_explain'], 
				'L_FORUM_NAME' => $lang['Faq_name'], 

				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin_faq.$phpEx"), 
				'S_SUBMIT_VALUE' => $buttonvalue)
			);

			$template->pparse("body");
			break;

		case 'movedelfaq':
			//
			// Delete a faq in the DB
			//
			$from_id = intval($HTTP_POST_VARS['from_id']);

			// Delete faq

			$sql = "DELETE FROM " . $text_table . "
				WHERE q_id = $from_id AND lang_id = '" . $faq_lang . "'";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete faq", "", __LINE__, __FILE__, $sql);
			}
			$message = $lang['Faqs_updated'] . "<br /><br />" . sprintf($lang['Click_return_faqadmin'], "<a href=\"" . append_sid("admin_faq.$phpEx") . "&l=" . $faq_lang . "&type=" . $faq_type . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;
			
		case 'deletecat':
			//
			// Show form to delete a category
			//
			$faq_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$buttonvalue = $lang['Move_and_Delete'];
			$newmode = 'movedelcat';
			$faqinfo = get_info('cat', $faq_id);
			$name = $faqinfo['faq_title'];

			if ($catinfo['number'] == 1)
			{
				$sql = "SELECT count(*) as total
					FROM ". $text_table;
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't get Faq count", "", __LINE__, __FILE__, $sql);
				}
				$count = $db->sql_fetchrow($result);
				$count = $count['total'];

				if ($count > 0)
				{
					message_die(GENERAL_ERROR, $lang['Must_delete_faqs']);
				}
				else
				{
					$select_to = $lang['Nowhere_to_move'];
				}
			}
			else
			{
				$select_to = '<select name="to_id">';
				$select_to .= get_list('cat', $faq_id, 0);
				$select_to .= '</select>';
			}

			$template->set_filenames(array(
				"body" => "admin/forum_delete_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="from_id" value="' . $faq_id . '" /><input type="hidden" name="' . POST_FAQ_LANG . '" value="' . $faq_lang . '" /><input type="hidden" name="' . POST_FAQ_TYPE . '" value="' . $faq_type . '" />';

			$template->assign_vars(array(
				'NAME' => $name, 

				'L_FORUM_DELETE' => $lang['Faq_delete'], 
				'L_FORUM_DELETE_EXPLAIN' => $lang['Faq_delete_explain'], 
				'L_MOVE_CONTENTS' => $lang['Move_contents'], 
				'L_FORUM_NAME' => $lang['Faq_name'], 
				
				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin_faq.$phpEx"), 
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_VALUE' => $buttonvalue)
			);

			$template->pparse("body");
			break;

		case 'movedelcat':
			//
			// Move or delete a category in the DB
			//
			$from_id = intval($HTTP_POST_VARS['from_id']);
			$to_id = intval($HTTP_POST_VARS['to_id']);

			if (!empty($to_id))
			{
				$sql = "SELECT *
					FROM " . $cat_table . "
					WHERE faq_id IN ($from_id, $to_id) AND lang_id = '" . $faq_lang . "'";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't verify existence of categories", "", __LINE__, __FILE__, $sql);
				}
				if($db->sql_numrows($result) != 2)
				{
					message_die(GENERAL_ERROR, "Ambiguous category ID's", "", __LINE__, __FILE__);
				}

				$sql = "UPDATE " . $text_table . "
					SET faq_id = $to_id
					WHERE faq_id = $from_id AND lang_id = '" . $faq_lang . "'";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move faqs to other category", "", __LINE__, __FILE__, $sql);
				}
			}

			$sql = "DELETE FROM " . $cat_table ."
				WHERE faq_id = $from_id AND lang_id = '" . $faq_lang . "'";
				
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete category", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Faqs_updated'] . "<br /><br />" . sprintf($lang['Click_return_faqadmin'], "<a href=\"" . append_sid("admin_faq.$phpEx") . "&l=" . $faq_lang . "&type=" . $faq_type . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		default:
			message_die(GENERAL_MESSAGE, $lang['No_mode'].' '.$mode);
			break;
	}

	if ($show_index != TRUE)
	{
		include('./page_footer_admin.'.$phpEx);
		exit;
	}
}

// 
// Start output of page 
// 
$page_title = $lang['Index'];
include($phpbb_root_path . 'admin/page_header_admin.'.$phpEx);

$template->set_filenames(array(
	"body" => "admin/admin_faq.tpl")
);

$catlist = get_lang_list($faq_lang);
if ( $faq_type == 'bbcode' )
{
	$typelist = "<option value=\"bbcode\">" . $lang['bbcode'] . "</option>\n<option value=\"faq\">" . $lang['FAQ'] . "</option>\n";
}
else
{
	$typelist = "<option value=\"bbcode\">" . $lang['bbcode'] . "</option>\n<option value=\"faq\" selected=\"selected\">" . $lang['FAQ'] . "</option>\n";
}
if ( isset($HTTP_GET_VARS['type']) )
{
	$s_hidden_fields = '<input type="hidden" name="' . POST_FAQ_TYPE . '" value="' . $faq_type . '" />';
}

$template->assign_vars(array( 
	'S_FAQ_ACTION' => append_sid("admin_faq.$phpEx"), 
	'S_LANG_LIST' => $catlist, 
	'S_TYPE_LIST' => $typelist, 
	'S_HIDDEN_FIELDS' => $s_hidden_fields, 
	'L_LANGUAGE' => $lang['Language'], 
	'L_TYPE' => $lang['Type'], 
	'L_FAQ_TITLE' => $l_title, 
	'L_FAQ_EXPLAIN' => $lang['Faq_admin_explain'], 
	'L_CREATE_FAQ' => $lang['Create_faq'], 
	'L_CREATE_CATEGORY' => $lang['Create_category'], 
	'L_EDIT' => $lang['Edit'], 
	'SPACER' => './../' . $images['spacer'], 
	'L_DELETE' => $lang['Delete'])
);


//
// lolzor from admin_forums.php
//
$sql = "SELECT faq_id, faq_title FROM " . $cat_table . " WHERE lang_id = '" . $faq_lang . "' ORDER BY faq_id";
if( !$q_categories = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not query categories list", "", __LINE__, __FILE__, $sql);
}

if( $total_categories = $db->sql_numrows($q_categories) )
{
	$category_rows = $db->sql_fetchrowset($q_categories);

	$sql = "SELECT * FROM " . $text_table . " WHERE lang_id = '" . $faq_lang . "' ORDER BY faq_id,q_id";
	if(!$q_forums = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query forums information", "", __LINE__, __FILE__, $sql);
	}

	if( $total_forums = $db->sql_numrows($q_forums) )
	{
		$forum_rows = $db->sql_fetchrowset($q_forums);
	}

	//
	// Okay, let's build the index
	//
	$gen_cat = array();

	for($i = 0; $i < $total_categories; $i++)
	{
		$faq_id = $category_rows[$i]['faq_id'];

		$template->assign_block_vars("catrow", array( 
			'S_ADD_FAQ_SUBMIT' => "addfaq[$faq_id]", 
			'S_ADD_FAQ_NAME' => "faqname[$faq_id]", 

			'CAT_ID' => $faq_id,
			'CAT_DESC' => $category_rows[$i]['faq_title'],

			'U_CAT_EDIT' => append_sid("admin_faq.$phpEx?mode=editcat&amp;" . POST_CAT_URL . "=$faq_id&type=" . $faq_type . "&l=" . $faq_lang . ""),
			'U_CAT_DELETE' => append_sid("admin_faq.$phpEx?mode=deletecat&amp;" . POST_CAT_URL . "=$faq_id&type=" . $faq_type . "&l=" . $faq_lang . ""),
			'U_VIEWCAT' => append_sid($phpbb_root_path."faq.$phpEx?" . POST_CAT_URL . "=$faq_id"))
		);

		for($j = 0; $j < $total_forums; $j++)
		{
			$q_id = $forum_rows[$j]['q_id'];
			
			if ($forum_rows[$j]['faq_id'] == $faq_id && $forum_rows[$j]['lang_id'] = $userdata['user_lang'])
			{

				$template->assign_block_vars("catrow.faqrow", array(
					'FAQ_NAME' => $forum_rows[$j]['q'],
					'FAQ_DESC' => substr($forum_rows[$j]['a'], 0, 150),
					'ROW_COLOR' => $row_color,

					'U_VIEWFAQ' => append_sid($phpbb_root_path."faq.$phpEx").'#'.$q_id,
					'U_FAQ_EDIT' => append_sid("admin_faq.$phpEx?mode=editfaq&amp;" . POST_FORUM_URL . "=$q_id&type=" . $faq_type . "&l=" . $faq_lang . ""),
					'U_FAQ_DELETE' => append_sid("admin_faq.$phpEx?mode=deletefaq&amp;" . POST_FORUM_URL . "=$q_id&type=" . $faq_type . "&l=" . $faq_lang . ""))
				);

			}// if ... forumid == catid
			
		} // for ... forums

	} // for ... categories

}// if ... total_categories

// 
// Generate the page 
// 
$template->pparse('body');

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx); 
?>
