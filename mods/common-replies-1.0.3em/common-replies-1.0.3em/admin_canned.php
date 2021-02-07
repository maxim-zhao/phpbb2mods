<?php
/***************************************************************************
 *                              admin_canned.php
 *                            -------------------
 *   begin                : Saturday, Oct 09, 2004
 *   copyright            : (C) 2004 Sune Trudslev, Tanis
 *   email                : sune.trudslev@tanis.dk
 *
 *   $Id$
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Groups']['Canned_Messages'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ( isset($HTTP_POST_VARS[POST_GROUPS_URL]) || isset($HTTP_GET_VARS[POST_GROUPS_URL]) )
{
	$group_id = ( isset($HTTP_POST_VARS[POST_GROUPS_URL]) ) ? intval($HTTP_POST_VARS[POST_GROUPS_URL]) : intval($HTTP_GET_VARS[POST_GROUPS_URL]);
}
else
{
	$group_id = 0;
}

if ( isset($HTTP_POST_VARS['canned_id']) || isset($HTTP_GET_VARS['canned_id']) )
{
	$canned_id = ( isset($HTTP_POST_VARS['canned_id']) ) ? intval($HTTP_POST_VARS['canned_id']) : intval($HTTP_GET_VARS['canned_id']);
}
else
{
	$canned_id = 0;
}

if ( isset($HTTP_POST_VARS['canned_title']) || isset($HTTP_GET_VARS['canned_title']) )
{
	$canned_title = ( isset($HTTP_POST_VARS['canned_title']) ) ? $HTTP_POST_VARS['canned_title'] : $HTTP_GET_VARS['canned_title'];
}
else
{
	$canned_title = '';
}

if ( isset($HTTP_POST_VARS['canned_message']) || isset($HTTP_GET_VARS['canned_message']) )
{
	$canned_message = ( isset($HTTP_POST_VARS['canned_message']) ) ? $HTTP_POST_VARS['canned_message'] : $HTTP_GET_VARS['canned_message'];
}
else
{
	$canned_message = '';
}

if ( isset($HTTP_POST_VARS['canned_disable_bbcode']) || isset($HTTP_GET_VARS['canned_disable_bbcode']) )
{
	$canned_disable_bbcode = ( isset($HTTP_POST_VARS['canned_disable_bbcode']) ) ? intval($HTTP_POST_VARS['canned_disable_bbcode']) : intval($HTTP_GET_VARS['canned_disable_bbcode']);
}
else
{
	$canned_disable_bbcode = 0;
}

if ( isset($HTTP_POST_VARS['action_after_post']) || isset($HTTP_GET_VARS['action_after_post']) )
{
	$action_after_post = ( isset($HTTP_POST_VARS['action_after_post']) ) ? intval($HTTP_POST_VARS['action_after_post']) : intval($HTTP_GET_VARS['action_after_post']);
}
else
{
	$action_after_post = 0;
}

if ( isset($HTTP_POST_VARS['canned_update']) || isset($HTTP_GET_VARS['canned_update']) )
{
	$canned_update = true;
}
else
{
	$canned_update = false;
}

switch($action_after_post)
{
	case 0:
		$canned_move_after_post = 0;
		$canned_lock_after_post = 0;
		break;
	case 1:
		$canned_move_after_post = 1;
		$canned_lock_after_post = 0;
		break;
	case 2:
		$canned_move_after_post = 0;
		$canned_lock_after_post = 1;
		break;
}

if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = '';
}

function resort_canned($group_id)
{
	global $db;

	$sql = "SELECT canned_id
		FROM " . CANNED_TABLE . "
		WHERE group_id = " . $group_id;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain group id', '', __LINE__, __FILE__, $sql);
	}
	$ids = array();
	while($row = $db->sql_fetchrow($result)) 
	{
		$ids[] = $row['canned_id'];
	}
	$db->sql_freeresult($result);

	$sortorder = 1;
	foreach($ids as $id)
	{
		$sql = "UPDATE " . CANNED_TABLE . "
			SET sortorder = " . $sortorder . "
			WHERE canned_id = " . $id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update sortorder', '', __LINE__, __FILE__, $sql);
		}
		$sortorder++;
	}
}

switch( $mode ) 
{
	case "up":
	case "down":
		$sql = "SELECT group_id,sortorder
			FROM " . CANNED_TABLE . "
			WHERE canned_id = " . $canned_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain group id', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$group_id = $row['group_id'];
		$sortorder = $row['sortorder'];
		if($mode == "up")
			$new_sortorder = $sortorder - 1;
		else
			$new_sortorder = $sortorder + 1;
		$db->sql_freeresult($result);

		$sql = "SELECT canned_id
			FROM " . CANNED_TABLE . "
			WHERE sortorder = " . $new_sortorder . " AND group_id = " . $group_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain canned id', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$other_canned_id = $row['canned_id'];
		$db->sql_freeresult($result);

		$sql = "UPDATE " . CANNED_TABLE . "
			SET sortorder = " . $new_sortorder . "
			WHERE canned_id = " . $canned_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update sortorder', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . CANNED_TABLE . "
			SET sortorder = " . $sortorder . "
			WHERE canned_id = " . $other_canned_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update sortorder', '', __LINE__, __FILE__, $sql);
		}
		break;
	case "new":
	case "edit":
		if($canned_id <> 0)
		{
			$sql = "SELECT canned_title, canned_message, canned_enable_bbcode, canned_move_after_post, canned_lock_after_post
				FROM " . CANNED_TABLE . "
				WHERE canned_id = " . $canned_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain canned message list', '', __LINE__, __FILE__, $sql);
			}
			$canned_message = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
		}
		else
			$canned_message = array(
				'canned_title' => "",
				'canned_message' => "",
				'canned_enable_bbcode' => 1,
				'canned_move_after_post' => 0,
				'canned_lock_after_post' => 0);

		$template->set_filenames(array(
			'body' => 'admin/canned_edit.tpl')
		);

		$bbcode = "";
		if($canned_message['canned_enable_bbcode'] == 0)
			$bbcode = " CHECKED";

		$move = "";
		if($canned_message['canned_move_after_post'] == 1)
			$move = " CHECKED";

		$lock = "";
		if($canned_message['canned_lock_after_post'] == 1)
			$lock = " CHECKED";

		$none = "";
		if($move == "" && $lock == "")
			$none = " CHECKED";

		$template->assign_vars(array(
			'L_CANNED_TITLE' => $lang['Canned_Messages_Administration'],
			'L_CANNED_MESSAGE' => $lang['Canned_Message'],
			'L_TITLE' => $lang['Title'],
			'L_MESSAGE' => $lang['Message'],
			'L_DISABLE_BBCODE' => $lang['Disable_BBCode'],
			'L_SUBMIT' => $lang['Submit'],
			'L_RESET' => $lang['Reset'],
			'L_NONE_AFTER_POST' => $lang['None_After_Post'],
			'L_MOVE_AFTER_POST' => $lang['Move_After_Post'],
			'L_LOCK_AFTER_POST' => $lang['Lock_After_Post'],

			'S_CANNED_ACTION' => append_sid("admin_canned.$phpEx"),
				
			'GROUP_ID' => $group_id,
			'CANNED_ID' => $canned_id,
			'TITLE' => $canned_message['canned_title'],
			'MESSAGE' => $canned_message['canned_message'],
			'BBCODE_CHECKED' => $bbcode,
			'NONE_CHECKED' => $none,
			'MOVE_CHECKED' => $move,
			'LOCK_CHECKED' => $lock)
		);

		$template->pparse('body');

		exit;
		break;
	case "delete":
		$sql = "DELETE 
			FROM " . CANNED_TABLE . "
			WHERE canned_id = " . $canned_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete canned message', '', __LINE__, __FILE__, $sql);
		}
		resort_canned($group_id);
}

if($canned_update)
{
	if($canned_id == 0)
	{
		$sql = "SELECT MAX(sortorder)+1 AS sortorder
			FROM " . CANNED_TABLE . "
			WHERE group_id = " . $group_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain sortorder', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$sortorder = $row['sortorder'];
		if(!isset($sortorder))
			$sortorder = 1;
		$db->sql_freeresult($result);

		$sql = "INSERT INTO " . CANNED_TABLE . "
			(group_id,canned_title,canned_message,canned_enable_bbcode,canned_move_after_post,canned_lock_after_post,sortorder)
			VALUES(" . $group_id . ",'" . str_replace("\'", "''", $canned_title) . "','" . str_replace("\'", "''", $canned_message) . "'," . (1 - $canned_disable_bbcode) . "," . $canned_move_after_post . "," . $canned_lock_after_post . "," . $sortorder . ")";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not insert canned message', '', __LINE__, __FILE__, $sql);
		}
	}
	else
	{
		$sql = "UPDATE " . CANNED_TABLE . "
			SET group_id = " . $group_id . ", canned_title = '" . str_replace("\'", "''", $canned_title) . "', canned_message = '" . str_replace("\'", "''", $canned_message) . "', canned_enable_bbcode = " . (1 - $canned_disable_bbcode) . ", canned_move_after_post = " . $canned_move_after_post . ", canned_lock_after_post = " . $canned_lock_after_post . "
			WHERE canned_id = " . $canned_id;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update canned message', '', __LINE__, __FILE__, $sql);
		}	}
}
if($group_id <> 0)
{
	$sql = "SELECT group_name
		FROM " . GROUPS_TABLE . "
		WHERE group_id = " . $group_id;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain group name', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$group_name = $row['group_name'];
	$db->sql_freeresult($result);

	$sql = "SELECT canned_id, canned_title, canned_message
		FROM " . CANNED_TABLE . "
		WHERE group_id = " . $group_id . "
		ORDER BY sortorder";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain canned message list', '', __LINE__, __FILE__, $sql);
	}

	$canned_messages = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$canned_messages[] = $row;
	}
	$db->sql_freeresult($result);

	$template->set_filenames(array(
		'body' => 'admin/canned_list_body.tpl')
	);

	$template->assign_vars(array(
		'L_CANNED_TITLE' => $lang['Canned_Messages_Administration_For'] . " " . $group_name,
		'L_TITLE' => $lang['Title'],
		'L_EDIT' => $lang['Edit'],
		'L_DELETE' => $lang['Delete'],
		'L_UP' => $lang['Up'],
		'L_DOWN' => $lang['Down'],
		'L_CREATE_NEW_CANNED_MESSAGE' => $lang['Create_New_Canned_Message'],
		
		'S_CANNED_ACTION' => append_sid("admin_canned.$phpEx?mode=new&amp;g=" . $group_id))
	);

	$i = 0;
	$canned_count = count($canned_messages);
	foreach($canned_messages as $canned_message) {
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$up = $lang['Up'];
		if($i == 0)
			$up = "";
		$down = $lang['Down'];
		if($i == count($canned_messages)-1)
			$down = "";
		$template->assign_block_vars('canned', array(
			'ROW_CLASS' => $row_class,
			'CANNED_TITLE' => $canned_message['canned_title'],

			'U_CANNED_EDIT' => append_sid("admin_canned.$phpEx?mode=edit&amp;canned_id=" . $canned_message['canned_id'] . "&amp;g=" . $group_id),
			'U_CANNED_DELETE' => append_sid("admin_canned.$phpEx?mode=delete&amp;canned_id=" . $canned_message['canned_id'] . "&amp;g=" . $group_id),
			'U_CANNED_UP' => append_sid("admin_canned.$phpEx?mode=up&amp;canned_id=" . $canned_message['canned_id'] . "&amp;g=" . $group_id),
			'U_CANNED_DOWN' => append_sid("admin_canned.$phpEx?mode=down&amp;canned_id=" . $canned_message['canned_id'] . "&amp;g=" . $group_id),

			'L_UP' => $up,
			'L_DOWN' => $down)
		);

		$i++;
	}

	$template->pparse('body');
}
else
{
	$sql = "SELECT group_id, group_name
		FROM " . GROUPS_TABLE . "
		WHERE group_single_user <> " . TRUE . "
		ORDER BY group_name";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain group list', '', __LINE__, __FILE__, $sql);
	}

	$select_list = '';
	if ( $row = $db->sql_fetchrow($result) )
	{
		$select_list .= '<select name="' . POST_GROUPS_URL . '">';
		do
		{
			$select_list .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
		}
		while ( $row = $db->sql_fetchrow($result) );
		$select_list .= '</select>';
	}
	$db->sql_freeresult($result);

	$template->set_filenames(array(
		'body' => 'admin/canned_group_select_body.tpl')
	);

	$template->assign_vars(array(
		'L_GROUP_TITLE' => $lang['Canned_Messages_Administration'],
		'L_GROUP_EXPLAIN' => $lang['Canned_Messages_Administration_Explain'],
		'L_GROUP_SELECT' => $lang['Select_group'],
		'L_LOOK_UP' => $lang['Look_up_group'],

		'S_GROUP_ACTION' => append_sid("admin_canned.$phpEx"),
		'S_GROUP_SELECT' => $select_list)
	);

	if ( $select_list != '' )
	{
		$template->assign_block_vars('select_box', array());
	}

	$template->pparse('body');
}

include('./page_footer_admin.'.$phpEx);

?>