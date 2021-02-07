<?php
	/*******************************************
	*        admin_uploadpic_users.php         *
	*        -------------------------         *
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
		$module['UploadPic']['UploadPic_menu_users'] = $filename;
		return;
	}


	// Include required files, get $phpEx and check permissions
	$phpbb_root_path = "./../";
	require($phpbb_root_path . 'extension.inc');
	require('./pagestart.' . $phpEx);


	// Start
    $template->set_filenames(array('body' => 'admin/admin_uploadpic_users.tpl'));

	// bulk-change permissions
	if(!empty($HTTP_POST_VARS['GO']))
	{
		// remove ALL permissions
		$sql= "UPDATE ".USERS_TABLE."
				SET user_allow_uploadpic = 0";
		$result = $db->sql_query($sql);

		if (count($HTTP_POST_VARS['arr_user']))
		{
			foreach($HTTP_POST_VARS['arr_user'] as $key => $value)
			{
				$HTTP_POST_VARS['arr_user'][$key] = intval($value);
			}

			// set permissons
			$sql= "UPDATE ".USERS_TABLE."
					SET user_allow_uploadpic = 1
					WHERE user_id IN (".implode(",",$HTTP_POST_VARS['arr_user']).")";
			$result = $db->sql_query($sql);
		}
	}


	// get users
	$sql= "SELECT user_id, username, user_allow_uploadpic
			FROM ".USERS_TABLE."
			WHERE user_id > 0
			ORDER BY LEFT(username,1), user_allow_uploadpic DESC, username";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
	}


	$str_unstartalt = "";
	$str_navigation = "";
	$int_count = $db->sql_numrows($result);
	$int_selected = 0;

	while ( $row = $db->sql_fetchrow($result) )
	{
		$str_first = strtoupper(substr($row['username'],0,1));

		$template->assign_block_vars('users_row', array(
			'ROW_USERID' => $row['user_id'],
			'ROW_USERNAME' => $row['username'],
			'ROW_CHECKED' => ($row['user_allow_uploadpic'] == 1) ? 'checked="checked"' : '',
			'ROW_FIRST' => $str_first
		));

		if ($str_first != $str_unstartalt)
		{
			$str_navigation .= '<a href="#'.$str_first.'"><strong>'.$str_first.'</strong></a> ';
			$template->assign_block_vars('users_row.switch_newline', array());
		}

		$int_selected = ($row['user_allow_uploadpic'] == 1) ? $int_selected+1 : $int_selected;
		$str_unstartalt = strtoupper(substr($row['username'],0,1));
	}

	$template->assign_vars(array(
		'L_TITLE' => $lang['UploadPic_menu_users'],
		'L_PERMISSIONS' => $lang['UP_Permissions'],
		'L_ALLNONE' => $lang['UP_AllNone'],
		'V_ALLNONE_CHECKED' => ($int_count == $int_selected) ? 'checked="checked"' : '',
		'URL_NAVIGATION' => $str_navigation,
		'L_SAVE' => $lang['UP_Save'],
		'URL_SELF' => append_sid($HTTP_SERVER_VARS['PHP_SELF'])
	));


	// prepare page & output
	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
?>