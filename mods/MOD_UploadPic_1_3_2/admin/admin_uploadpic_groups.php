<?php
	/*******************************************
	*        admin_uploadpic_groups.php        *
	*        --------------------------        *
	*                                          *
	*   date       : 08/2005 - 04/2006         *
    *   version    : 1.3.2                     *
	*   (C)/author : B.Funke                   *
	*   URL        : http://forum.beehave.de   *
	*                                          *
	********************************************/

/* UploadPic can be freely copied and used, as long as all provided files remain unchanged. */
/* For all further terms, the GNU GENERAL PUBLIC LICENSE applies to this MOD. */


	// Start
	define('IN_PHPBB', 1);

	if( !empty($setmodules) )
	{
		$filename = basename(__FILE__);
		$module['UploadPic']['UploadPic_menu_groups'] = $filename;
		return;
	}


	// Include required files, get $phpEx and check permissions
	$phpbb_root_path = "./../";
	require($phpbb_root_path . 'extension.inc');
	require('./pagestart.' . $phpEx);


	// bulk-change permissions
	if(!empty($HTTP_POST_VARS['GO']))
	{
		$sql = "SELECT user_id
				FROM ".USER_GROUP_TABLE."
				WHERE group_id =".intval($HTTP_POST_VARS['grpid']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}

		// set permissons
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql_update = "UPDATE ".USERS_TABLE."
							SET user_allow_uploadpic = ".($HTTP_POST_VARS['arr_user'][$row['user_id']] == 1)."
							WHERE user_id=".$row['user_id'];
			$result_update = $db->sql_query($sql_update);
		}
	}


	if (empty($HTTP_POST_VARS['sel_grpid']))
	{
		// create groups-dropdown
		$sql = "SELECT group_id, group_name
				FROM ".GROUPS_TABLE."
				WHERE group_single_user <> ".TRUE."
				ORDER BY group_name";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}

		$select_list = '';
		if ( $row = $db->sql_fetchrow($result) )
		{
			$select_list .= '<select name="sel_grpid">';
			do
			{
				$select_list .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
			}
			while ( $row = $db->sql_fetchrow($result) );
			$select_list .= '</select>';
		}

		$template->set_filenames(array('body' => 'admin/admin_uploadpic_groups.tpl'));

		$template->assign_vars(array(
			'L_TITLE' => $lang['UploadPic_menu_groups'],
			'L_GROUP_SELECT' => $lang['Select_group'],
			'L_LOOK_UP' => $lang['Look_up_group'],
			'S_GROUP_SELECT' => $select_list,
			'URL_SELF' => append_sid($HTTP_SERVER_VARS['PHP_SELF'])
		));

		if ( $select_list != '' )
		{
			$template->assign_block_vars('select_box', array());
		}
	}
	else
	{
	    $template->set_filenames(array('body' => 'admin/admin_uploadpic_group.tpl'));

		$sql= "SELECT group_name
				FROM ".GROUPS_TABLE."
				WHERE group_id = ".intval($HTTP_POST_VARS['sel_grpid']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		$str_grpname = $row['group_name'];

		// show group-users
		$sql= "SELECT u.user_id AS user_id, u.username AS username, u.user_allow_uploadpic AS user_allow_uploadpic, g.user_pending AS user_pending
				FROM ".USERS_TABLE." u, ".USER_GROUP_TABLE." g
				WHERE u.user_id > 0 AND
						u.user_id = g.user_id AND
						g.group_id = ".intval($HTTP_POST_VARS['sel_grpid'])."
				ORDER BY u.username";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}

		$int_count = $db->sql_numrows($result);
		$int_selected = 0;

		while ( $row = $db->sql_fetchrow($result) )
		{
			$template->assign_block_vars('users_row', array(
				'ROW_USERID' => $row['user_id'],
				'ROW_USERNAME' => $row['username'],
				'ROW_CHECKED' => ($row['user_allow_uploadpic'] == 1) ? 'checked="checked"' : '',
				'ROW_PENDING' => ($row['user_pending']) ? ' <span style="color:Red;">('.$lang['UP_Pending'].')</span>' : '',
			));

			$int_selected = ($row['user_allow_uploadpic'] == 1) ? $int_selected+1 : $int_selected;
		}

		$s_hidden_fields = '<input type="hidden" name="grpid" value="'.intval($HTTP_POST_VARS['sel_grpid']).'" />';

		$template->assign_vars(array(
			'L_TITLE' => $lang['UploadPic_menu_groups'],
			'L_PERMISSIONS' => $lang['UP_Permissions'],
			'L_GRPEXPLAIN' => $lang['UP_GrpExplain'],
			'L_SAVE' => $lang['UP_Save'],
			'L_4GROUP' => $lang['UP_4group'],
			'L_GROUPNAME' => $str_grpname,
			'L_ALLNONE' => $lang['UP_AllNone'],
			'V_ALLNONE_CHECKED' => ($int_count == $int_selected) ? 'checked="checked"' : '',
			'L_BACK' => $lang['UP_Back2GL'],
			'URL_SELF' => append_sid($HTTP_SERVER_VARS['PHP_SELF']),
			'S_HIDDEN_FIELDS' => $s_hidden_fields
		));
	}

// prepare page & output
	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
?>