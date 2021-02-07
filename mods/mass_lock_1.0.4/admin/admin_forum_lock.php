<?php
/***************************************************************************
*                             admin_forum_lock.php
*                              -------------------
*     begin                : Thu Mar 27, 2003
*     copyright            : 2003, Siavash Rahnama
*     email                : siavash79_99@yahoo.com
*
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);

if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Forums']['Mlock'] = $filename;

	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/lock.'.$phpEx);
require($phpbb_root_path . 'includes/functions_admin.'.$phpEx); 

//
// Get the forum ID for locking
//
if( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = ( isset($HTTP_POST_VARS[POST_FORUM_URL]) ) ? $HTTP_POST_VARS[POST_FORUM_URL] : $HTTP_GET_VARS[POST_FORUM_URL];

	if( $forum_id == -1 )
	{
		$forum_sql = '';
	}
	else
	{
		$forum_id = intval($forum_id);
		$forum_sql = "AND forum_id = $forum_id";
	}
}
else
{
	$forum_id = '';
	$forum_sql = '';
}
//
// Get a list of forum's or the data for the forum that we are locking.
//
$sql = "SELECT f.*
	FROM " . FORUMS_TABLE . " f, " . CATEGORIES_TABLE . " c
	WHERE c.cat_id = f.cat_id
	$forum_sql
	ORDER BY c.cat_order ASC, f.forum_order ASC";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain list of forums for locking', '', __LINE__, __FILE__, $sql);
}

$forum_rows = array();
while( $row = $db->sql_fetchrow($result) )
{
	$forum_rows[] = $row;
}

//
// Check for submit to be equal to lock. If so then proceed with the locking.
//
if( isset($HTTP_POST_VARS['dolock']) )
{
	$lockdays = ( isset($HTTP_POST_VARS['lockdays']) ) ? intval($HTTP_POST_VARS['lockdays']) : 0;

	// Convert days to seconds for timestamp functions...
	$lockdate = time() - ( $lockdays * 86400 );

	$template->set_filenames(array(
		'body' => 'admin/forum_lock_result_body.tpl')
	);

	for($i = 0; $i < count($forum_rows); $i++)
	{
		$l_result = lock($forum_rows[$i]['forum_id'], $lockdate);
	
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	
		$template->assign_block_vars('lock_results', array(
			'ROW_COLOR' => '#' . $row_color, 
			'ROW_CLASS' => $row_class, 
			'FORUM_NAME' => $forum_rows[$i]['forum_name'],
			'FORUM_TOPICS' => $l_result)
		);
	}

	$template->assign_vars(array(
		'L_FORUM_LOCK' => $lang['Forum_Mass_Lock'],
		'L_FORUM' => $lang['Forum'],
		'L_TOPICS_LOCKED' => $lang['Topics_Mlocked'],
		'L_LOCK_RESULT' => $lang['MLock_success'])
	);
}
else
{
	//
	// If they haven't selected a forum for locking yet then
	// display a select box to use for locking.
	//
	if( empty($HTTP_POST_VARS[POST_FORUM_URL]) )
	{
		//
		// Output a selection table if no forum id has been specified.
		//
		$template->set_filenames(array(
			'body' => 'admin/forum_lock_select_body.tpl')
		);

		$select_list = '<select name="' . POST_FORUM_URL . '">';
		$select_list .= '<option value="-1">' . $lang['All_Forums'] . '</option>';

		for($i = 0; $i < count($forum_rows); $i++)
		{
			$select_list .= '<option value="' . $forum_rows[$i]['forum_id'] . '">' . $forum_rows[$i]['forum_name'] . '</option>';
		}
		$select_list .= '</select>';

		//
		// Assign the template variables.
		//
		$template->assign_vars(array(
			'L_FORUM_LOCK' => $lang['Forum_Mass_Lock'],
			'L_SELECT_FORUM' => $lang['Select_a_Forum'], 
			'L_LOOK_UP' => $lang['Look_up_Forum'],

			'S_FORUMLOCK_ACTION' => append_sid("admin_forum_lock.$phpEx"),
			'S_FORUMS_SELECT' => $select_list)
		);
	}
	else
	{
		$forum_id = intval($HTTP_POST_VARS[POST_FORUM_URL]);
		
		//
		// Output the form to retrieve Lock information.
		//
		$template->set_filenames(array(
			'body' => 'admin/forum_lock_body.tpl')
		);

		$forum_name = ( $forum_id == -1 ) ? $lang['All_Forums'] : $forum_rows[0]['forum_name'];

		$lock_data = $lang['MLock_topics_not_posted'] . " "; 
		$lock_data .= '<input class="post" type="text" name="lockdays" size="4"> ' . $lang['Days'];

		$hidden_input = '<input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

		//
		// Assign the template variables.
		//
		$template->assign_vars(array(
			'FORUM_NAME' => $forum_name,

			'L_FORUM' => $lang['Forum'], 
			'L_FORUM_LOCK' => $lang['Forum_Mass_Lock'], 
			'L_FORUM_LOCK_EXPLAIN' => $lang['Forum_Mass_Lock_explain'], 
			'L_DO_LOCK' => $lang['Do_MLock'],

			'S_FORUMLOCK_ACTION' => append_sid("admin_forum_lock.$phpEx"),
			'S_LOCK_DATA' => $lock_data,
			'S_HIDDEN_VARS' => $hidden_input)
		);
	}
}
//
// Actually output the page here.
//
$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>