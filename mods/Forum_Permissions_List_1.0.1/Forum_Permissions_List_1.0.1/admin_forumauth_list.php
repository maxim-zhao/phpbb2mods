<?php
/***************************************************************************
 * Filename:          admin_forumauth_list.php
 * Description:       Summary listing of the advanced permissions of all forums
 *                    with integrated editing
 * Author:            Graham Eames (phpbb@grahameames.co.uk)
 * Last Modified:     26-Mar-2004
 * File Version:      1.2
 *
 * Acknowlegments:    This file uses some features adapted from those
 *                    provided in admin_forumauth.php from the base distribution.
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Forums']['Permissions_List'] = $filename;

	return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Start program - define vars
//
//                View      Read      Post      Reply     Edit     Delete    Sticky   Announce    Vote      Poll
$simple_auth_ary = array(
	0  => array(AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	1  => array(AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	2  => array(AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	3  => array(AUTH_ALL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ACL, AUTH_ACL),
	4  => array(AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ACL, AUTH_ACL),
	5  => array(AUTH_ALL, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
	6  => array(AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
);

$simple_auth_types = array($lang['Public'], $lang['Registered'], $lang['Registered'] . ' [' . $lang['Hidden'] . ']', $lang['Private'], $lang['Private'] . ' [' . $lang['Hidden'] . ']', $lang['Moderators'], $lang['Moderators'] . ' [' . $lang['Hidden'] . ']');

$forum_auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_delete', 'auth_sticky', 'auth_announce', 'auth_vote', 'auth_pollcreate');

$field_names = array(
	'auth_view' => $lang['View'],
	'auth_read' => $lang['Read'],
	'auth_post' => $lang['Post'],
	'auth_reply' => $lang['Reply'],
	'auth_edit' => $lang['Edit'],
	'auth_delete' => $lang['Delete'],
	'auth_sticky' => $lang['Sticky'],
	'auth_announce' => $lang['Announce'], 
	'auth_vote' => $lang['Vote'], 
	'auth_pollcreate' => $lang['Pollcreate']);

$forum_auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN');
$forum_auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN);

if(isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]))
{
	$forum_id = (isset($HTTP_POST_VARS[POST_FORUM_URL])) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : intval($HTTP_GET_VARS[POST_FORUM_URL]);
	$forum_sql = "AND forum_id = $forum_id";
}
else
{
	unset($forum_id);
	$forum_sql = '';
}

if(isset($HTTP_GET_VARS[POST_CAT_URL]) || isset($HTTP_POST_VARS[POST_CAT_URL]))
{
	$cat_id = (isset($HTTP_POST_VARS[POST_CAT_URL])) ? intval($HTTP_POST_VARS[POST_CAT_URL]) : intval($HTTP_GET_VARS[POST_CAT_URL]);
	$cat_sql = "AND c.cat_id = $cat_id";
}
else
{
	unset($cat_id);
	$cat_sql = '';
}

if( isset($HTTP_GET_VARS['adv']) )
{
	$adv = intval($HTTP_GET_VARS['adv']);
}
else
{
	unset($adv);
}

//
// Start program proper
//
if( isset($HTTP_POST_VARS['submit']) )
{
	$sql = '';

	if(!empty($forum_id))
	{
		if(isset($HTTP_POST_VARS['simpleauth']))
		{
			$simple_ary = $simple_auth_ary[intval($HTTP_POST_VARS['simpleauth'])];

			for($i = 0; $i < count($simple_ary); $i++)
			{
				$sql .= ( ( $sql != '' ) ? ', ' : '' ) . $forum_auth_fields[$i] . ' = ' . $simple_ary[$i];
			}

			if (is_array($simple_ary))
			{
				$sql = "UPDATE " . FORUMS_TABLE . " SET $sql WHERE forum_id = $forum_id";
			}
		}
		else
		{
			for($i = 0; $i < count($forum_auth_fields); $i++)
			{
				$value = intval($HTTP_POST_VARS[$forum_auth_fields[$i]]);

				if ( $forum_auth_fields[$i] == 'auth_vote' )
				{
					if ( $HTTP_POST_VARS['auth_vote'] == AUTH_ALL )
					{
						$value = AUTH_REG;
					}
				}

				$sql .= ( ( $sql != '' ) ? ', ' : '' ) .$forum_auth_fields[$i] . ' = ' . $value;
			}

			$sql = "UPDATE " . FORUMS_TABLE . " SET $sql WHERE forum_id = $forum_id";
		}

		if ( $sql != '' )
		{
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update auth table', '', __LINE__, __FILE__, $sql);
			}
		}

		$forum_sql = '';
		$adv = 0;
	}
	elseif (!empty($cat_id))
	{
		for($i = 0; $i < count($forum_auth_fields); $i++)
		{
			$value = intval($HTTP_POST_VARS[$forum_auth_fields[$i]]);

			if ( $forum_auth_fields[$i] == 'auth_vote' )
			{
				if ( $HTTP_POST_VARS['auth_vote'] == AUTH_ALL )
				{
					$value = AUTH_REG;
				}
			}

			$sql .= ( ( $sql != '' ) ? ', ' : '' ) .$forum_auth_fields[$i] . ' = ' . $value;
		}

		$sql = "UPDATE " . FORUMS_TABLE . " SET $sql WHERE cat_id = $cat_id";

		if ( $sql != '' )
		{
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update auth table', '', __LINE__, __FILE__, $sql);
			}
		}

		$cat_sql = '';
	}

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("admin_forumauth_list.$phpEx") . '">')
	);
	$message = $lang['Forum_auth_updated'] . '<br /><br />' . sprintf($lang['Click_return_forumauth'],  '<a href="' . append_sid("admin_forumauth_list.$phpEx") . '">', "</a>");
	message_die(GENERAL_MESSAGE, $message);

} // End of submit

//
// Get required information, either all forums if
// no id was specified or just the requsted forum
// or category if it was
//
$sql = "SELECT f.*
	FROM " . FORUMS_TABLE . " f, " . CATEGORIES_TABLE . " c
	WHERE c.cat_id = f.cat_id
	$forum_sql $cat_sql
	ORDER BY c.cat_order ASC, f.forum_order ASC";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Couldn't obtain forum list", "", __LINE__, __FILE__, $sql);
}

$forum_rows = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);

if( empty($forum_id) && empty($cat_id) )
{
	//
	// Output the summary list if no forum id was
	// specified
	//
	$template->set_filenames(array(
		'body' => 'admin/auth_forum_list_body.tpl')
	);

	$template->assign_vars(array(
		'L_AUTH_TITLE' => $lang['Permissions_List'],
		'L_AUTH_EXPLAIN' => $lang['Forum_auth_list_explain'],
		'L_FORUM_NAME' => $lang['Forum_name'],
		'S_COLUMN_SPAN' => count($forum_auth_fields)+1)
	);

	for ($i=0; $i<count($forum_auth_fields); $i++)
	{
		$template->assign_block_vars('forum_auth_titles', array(
			'CELL_TITLE' => $field_names[$forum_auth_fields[$i]])
		);
	}

	// Obtain the category list
	$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
		FROM " . CATEGORIES_TABLE . " c 
		ORDER BY c.cat_order";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query categories list', '', __LINE__, __FILE__, $sql);
	}

	$category_rows = $db->sql_fetchrowset($result);
	$cat_count = count($category_rows);

	for ($i=0; $i<$cat_count; $i++)
	{
		$cat_id = $category_rows[$i]['cat_id'];

		$template->assign_block_vars('cat_row', array(
			'CAT_NAME' => $category_rows[$i]['cat_title'],
			'CAT_URL' => append_sid('admin_forumauth_list.'.$phpEx.'?'.POST_CAT_URL.'='.$category_rows[$i]['cat_id']))
		);

		for ($j=0; $j<count($forum_rows); $j++)
		{
			if ( $cat_id == $forum_rows[$j]['cat_id'] )
			{
				$template->assign_block_vars('cat_row.forum_row', array(
					'ROW_CLASS' => ( !($j % 2) ) ? 'row1' : 'row2',
					'FORUM_NAME' => '<a href="'.append_sid('admin_forumauth_list.'.$phpEx.'?'.POST_FORUM_URL.'='.$forum_rows[$j]['forum_id']).'">'.$forum_rows[$j]['forum_name'].'</a>')
				);

				for ($k=0; $k<count($forum_auth_fields); $k++)
				{
					$item_auth_value = $forum_rows[$j][$forum_auth_fields[$k]];
					for ($l=0; $l<count($forum_auth_const); $l++)
					{
						if ($item_auth_value == $forum_auth_const[$l])
						{
							$item_auth_level = $forum_auth_levels[$l];
							break;
						}
					}
					$template->assign_block_vars('cat_row.forum_row.forum_auth_data', array(
						'CELL_VALUE' => $lang['Forum_' . $item_auth_level],
						'AUTH_EXPLAIN' => sprintf($lang['Forum_auth_list_explain_' . $forum_auth_fields[$k]], $lang['Forum_auth_list_explain_' . $item_auth_level]))
					);
				}
			}
		}
	}
}
elseif ( !empty($forum_id) )
{
	//
	// Output the authorisation details if an forum id was
	// specified
	//
	$template->set_filenames(array(
		'body' => 'admin/auth_forum_body.tpl')
	);

	$forum_name = $forum_rows[0]['forum_name'];

	@reset($simple_auth_ary);
	while( list($key, $auth_levels) = each($simple_auth_ary))
	{
		$matched = 1;
		for($k = 0; $k < count($auth_levels); $k++)
		{
			$matched_type = $key;

			if ( $forum_rows[0][$forum_auth_fields[$k]] != $auth_levels[$k] )
			{
				$matched = 0;
			}
		}

		if ( $matched )
		{
			break;
		}
	}

	//
	// If we didn't get a match above then we
	// automatically switch into 'advanced' mode
	//
	if ( !isset($adv) && !$matched )
	{
		$adv = 1;
	}

	$s_column_span == 0;

	if ( empty($adv) )
	{
		$simple_auth = '<select name="simpleauth">';

		for($j = 0; $j < count($simple_auth_types); $j++)
		{
			$selected = ( $matched_type == $j ) ? ' selected="selected"' : '';
			$simple_auth .= '<option value="' . $j . '"' . $selected . '>' . $simple_auth_types[$j] . '</option>';
		}

		$simple_auth .= '</select>';

		$template->assign_block_vars('forum_auth_titles', array(
			'CELL_TITLE' => $lang['Simple_mode'])
		);
		$template->assign_block_vars('forum_auth_data', array(
			'S_AUTH_LEVELS_SELECT' => $simple_auth)
		);

		$s_column_span++;
	}
	else
	{
		//
		// Output values of individual
		// fields
		//
		for($j = 0; $j < count($forum_auth_fields); $j++)
		{
			$custom_auth[$j] = '&nbsp;<select name="' . $forum_auth_fields[$j] . '">';

			for($k = 0; $k < count($forum_auth_levels); $k++)
			{
				$selected = ( $forum_rows[0][$forum_auth_fields[$j]] == $forum_auth_const[$k] ) ? ' selected="selected"' : '';
				$custom_auth[$j] .= '<option value="' . $forum_auth_const[$k] . '"' . $selected . '>' . $lang['Forum_' . $forum_auth_levels[$k]] . '</option>';
			}
			$custom_auth[$j] .= '</select>&nbsp;';

			$cell_title = $field_names[$forum_auth_fields[$j]];

			$template->assign_block_vars('forum_auth_titles', array(
				'CELL_TITLE' => $cell_title)
			);
			$template->assign_block_vars('forum_auth_data', array(
				'S_AUTH_LEVELS_SELECT' => $custom_auth[$j])
			);

			$s_column_span++;
		}
	}

	$adv_mode = ( empty($adv) ) ? '1' : '0';
	$switch_mode = append_sid("admin_forumauth_list.$phpEx?" . POST_FORUM_URL . "=" . $forum_id . "&adv=". $adv_mode);
	$switch_mode_text = ( empty($adv) ) ? $lang['Advanced_mode'] : $lang['Simple_mode'];
	$u_switch_mode = '<a href="' . $switch_mode . '">' . $switch_mode_text . '</a>';

	$s_hidden_fields = '<input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '">';

	$template->assign_vars(array(
		'FORUM_NAME' => $forum_name,

		'L_FORUM' => $lang['Forum'], 
		'L_AUTH_TITLE' => $lang['Auth_Control_Forum'],
		'L_AUTH_EXPLAIN' => $lang['Forum_auth_explain'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],

		'U_SWITCH_MODE' => $u_switch_mode,

		'S_FORUMAUTH_ACTION' => append_sid("admin_forumauth_list.$phpEx"),
		'S_COLUMN_SPAN' => $s_column_span,
		'S_HIDDEN_FIELDS' => $s_hidden_fields)
	);

}
else
{
	//
	// Output the authorisation details if an category id was
	// specified
	//
	$template->set_filenames(array(
		'body' => 'admin/auth_cat_body.tpl')
	);

	//
	// First display the current details for all forums
	// in the category
	//
	for ($i=0; $i<count($forum_auth_fields); $i++)
	{
		$template->assign_block_vars('forum_auth_titles', array(
			'CELL_TITLE' => $field_names[$forum_auth_fields[$i]])
		);
	}

	// Obtain the category list
	$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
		FROM " . CATEGORIES_TABLE . " c 
		WHERE c.cat_id = $cat_id
		ORDER BY c.cat_order";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query categories list', '', __LINE__, __FILE__, $sql);
	}

	$category_rows = $db->sql_fetchrowset($result);

	$cat_id = $category_rows[0]['cat_id'];
	$cat_name = $category_rows[0]['cat_title'];

	$template->assign_block_vars('cat_row', array(
		'CAT_NAME' => $cat_name,
		'CAT_URL' => append_sid('admin_forumauth_list.'.$phpEx.'?'.POST_CAT_URL.'='.$cat_id))
	);

	for ($j=0; $j<count($forum_rows); $j++)
	{
		if ( $cat_id == $forum_rows[$j]['cat_id'] )
		{
			$template->assign_block_vars('cat_row.forum_row', array(
				'ROW_CLASS' => ( !($j % 2) ) ? 'row1' : 'row2',
				'FORUM_NAME' => '<a href="'.append_sid('admin_forumauth_list.'.$phpEx.'?'.POST_FORUM_URL.'='.$forum_rows[$j]['forum_id']).'">'.$forum_rows[$j]['forum_name'].'</a>')
			);

			for ($k=0; $k<count($forum_auth_fields); $k++)
			{
				$item_auth_value = $forum_rows[$j][$forum_auth_fields[$k]];
				for ($l=0; $l<count($forum_auth_const); $l++)
				{
					if ($item_auth_value == $forum_auth_const[$l])
					{
						$item_auth_level = $forum_auth_levels[$l];
						break;
					}
				}
				$template->assign_block_vars('cat_row.forum_row.forum_auth_data', array(
					'CELL_VALUE' => $lang['Forum_' . $item_auth_level],
					'AUTH_EXPLAIN' => sprintf($lang['Forum_auth_list_explain_' . $forum_auth_fields[$k]], $lang['Forum_auth_list_explain_' . $item_auth_level]))
				);
			}
		}
	}

	//
	// Next generate the information to allow the permissions to be changed
	// Note: We always read from the first forum in the category
	//
	for($j = 0; $j < count($forum_auth_fields); $j++)
	{
		$custom_auth[$j] = '&nbsp;<select name="' . $forum_auth_fields[$j] . '">';

		for($k = 0; $k < count($forum_auth_levels); $k++)
		{
			$selected = ( $forum_rows[0][$forum_auth_fields[$j]] == $forum_auth_const[$k] ) ? ' selected="selected"' : '';
			$custom_auth[$j] .= '<option value="' . $forum_auth_const[$k] . '"' . $selected . '>' . $lang['Forum_' . $forum_auth_levels[$k]] . '</option>';
		}
		$custom_auth[$j] .= '</select>&nbsp;';

		$template->assign_block_vars('forum_auth_data', array(
			'S_AUTH_LEVELS_SELECT' => $custom_auth[$j])
		);
	}
	
	//
	// Finally pass any remaining items to the template
	//
	$s_hidden_fields = '<input type="hidden" name="' . POST_CAT_URL . '" value="' . $cat_id . '">';

	$template->assign_vars(array(
		'CAT_NAME' => $cat_name,

		'L_AUTH_TITLE' => $lang['Auth_Control_Category'],
		'L_AUTH_EXPLAIN' => $lang['Cat_auth_list_explain'],
		'L_CATEGORY' => $lang['Category'],
		'L_FORUM_NAME' => $lang['Forum_name'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],

		'S_FORUMAUTH_ACTION' => append_sid("admin_forumauth_list.$phpEx"),
		'S_COLUMN_SPAN' => count($forum_auth_fields)+1,
		'S_HIDDEN_FIELDS' => $s_hidden_fields)
	);


}

include('./page_header_admin.'.$phpEx);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>