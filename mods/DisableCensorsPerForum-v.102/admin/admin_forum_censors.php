<?php
// admin_forum_censors.php
// Part of the Forum Censor MOD for phpBB
// version 1.0.0

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Forums']['Forum_Censor_Control'] = $file;
	return;
}

//
// Load default header
//

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Mode setting
//
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}
else
{
	$mode = "";
}

//Functions

function get_info($mode, $id)
{
	global $db;

	switch($mode)
	{
		case 'category':
			$table = CATEGORIES_TABLE;
			$idfield = 'cat_id';
			$namefield = 'cat_title';
			break;

		case 'forum':
			$table = FORUMS_TABLE;
			$idfield = 'forum_id';
			$namefield = 'forum_name';
			$censorstatus = 'forum_disablecensors';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}
	$sql = "SELECT count(*) as total
		FROM $table";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get Forum/Category information", "", __LINE__, __FILE__, $sql);
	}
	$count = $db->sql_fetchrow($result);
	$count = $count['total'];

	$sql = "SELECT *
		FROM $table
		WHERE $idfield = $id"; 

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get Forum/Category information", "", __LINE__, __FILE__, $sql);
	}

	if( $db->sql_numrows($result) != 1 )
	{
		message_die(GENERAL_ERROR, "Forum/Category doesn't exist or multiple forums/categories with ID $id", "", __LINE__, __FILE__);
	}

	$return = $db->sql_fetchrow($result);
	$return['number'] = $count;
	return $return;
}

if( !empty($mode) ) 
{
	switch($mode)
	{
		case 'censorenable':
			$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);
			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_disablecensors = 0
				WHERE forum_id = $forum_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't change category order", "", __LINE__, __FILE__, $sql);
			}
			$show_index = TRUE;
		break;

		case 'censordisable':
			$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);
			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_disablecensors = 1
				WHERE forum_id = $forum_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't change category order", "", __LINE__, __FILE__, $sql);
			}
			$show_index = TRUE;
		break;
	}
	if ($show_index != TRUE)
	{
		include('./page_footer_admin.'.$phpEx);
		exit;
	}
}


//
// Generate page
//

$template->set_filenames(array(
	'body' => 'admin/forum_censors.tpl')
);

$template->assign_vars(array(
	'L_TITLE' => $lang['forumcensors_title'],
	'L_DESCRIPTION' => $lang['forumcensors_decription'],
	'L_FILTER_STATUS' => $lang['forumcensors_filter_status'],
	'L_CHANGE' => $lang['forumcensors_change_status'],
	'L_ENABLE' => $lang['forumcensors_change_enable'],
	'L_DISABLE' => $lang['forumcensors_change_disable']

) );


$sql = "SELECT cat_id, cat_title, cat_order
	FROM " . CATEGORIES_TABLE . "
	ORDER BY cat_order";
if( !$q_categories = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not query categories list", "", __LINE__, __FILE__, $sql);
}

if( $total_categories = $db->sql_numrows($q_categories) )
{
	$category_rows = $db->sql_fetchrowset($q_categories);

	$sql = "SELECT *
		FROM " . FORUMS_TABLE . "
		ORDER BY cat_id, forum_order";
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
		$cat_id = $category_rows[$i]['cat_id'];

		$template->assign_block_vars("catrow", array( 
			'S_ADD_FORUM_SUBMIT' => "addforum[$cat_id]", 
			'S_ADD_FORUM_NAME' => "forumname[$cat_id]", 

			'CAT_ID' => $cat_id,
			'CAT_DESC' => $category_rows[$i]['cat_title'],

			'U_VIEWCAT' => append_sid($phpbb_root_path."index.$phpEx?" . POST_CAT_URL . "=$cat_id"))
		);

		for($j = 0; $j < $total_forums; $j++)
		{
			$forum_id = $forum_rows[$j]['forum_id'];
			
			if ($forum_rows[$j]['cat_id'] == $cat_id)
			{

				if ($forum_rows[$j]['forum_disablecensors']==0){
					$status = $lang['forumcensors_status_enabled'];
				}else{
					$status = $lang['forumcensors_status_disabled'];
				}
				$template->assign_block_vars("catrow.forumrow",	array(
					'FORUM_NAME' => $forum_rows[$j]['forum_name'],
					'FORUM_DESC' => $forum_rows[$j]['forum_desc'],
					'ROW_COLOR' => $row_color,
					'I_STATUS' => $status,

					'U_VIEWFORUM' => append_sid($phpbb_root_path."viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"),
					'U_ENABLE' => append_sid("admin_forum_censors.$phpEx?mode=censorenable&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_DISABLE' => append_sid("admin_forum_censors.$phpEx?mode=censordisable&amp;" . POST_FORUM_URL . "=$forum_id"))
				);

			}// if ... forumid == catid
			
		} // for ... forums

	} // for ... categories

}// if ... total_categories

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
