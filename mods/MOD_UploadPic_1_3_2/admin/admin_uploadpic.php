<?php
	/*******************************************
	*           admin_uploadpic.php            *
	*           -------------------            *
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
		$module['UploadPic']['UploadPic'] = $filename;
		return;
	}


	// Include required files, get $phpEx and check permissions
	$phpbb_root_path = "./../";
	require($phpbb_root_path . 'extension.inc');
	require('./pagestart.' . $phpEx);
	require($phpbb_root_path . 'includes/uploadpic_functions.'.$phpEx);

	uploadpic_creatvars();


	// Start

	// delete picture?
	$str_delpic = basename($HTTP_GET_VARS['delpic']);
	if(!empty($str_delpic))
	{
		unlink($up_picpath.$str_delpic);
	}

	// censor picture?
	$str_censorpic = basename($HTTP_GET_VARS['censorpic']);
	if(!empty($str_censorpic))
	{
		uploadpic_censorpic($str_censorpic);
	}

	// delete all unused pictures?
	if(!empty($HTTP_GET_VARS['upprune']))
	{
		$int_delcount = 0;
		$directory = uploadpic_open_directory($up_picpath);

		while ($entry = $directory->read())
		{
			if ((!is_dir($entry)) && ($entry != "index.htm"))
			{
				if (uploadpic_checkfileinuse($str_httppath.$entry) == 0)
				{
					unlink($up_picpath.$entry);
					$int_delcount++;
				}
			}
		}
	}

	// delete old pictures from PMs?
	if(!empty($HTTP_GET_VARS['uppmprune']))
	{
		$int_delcount = 0;
		$int_deadline = (date("U")-($board_config['uploadpic_maxpmdays']*24*3600));

		$directory = uploadpic_open_directory($up_picpath);

		while ($entry = $directory->read())
		{
			if ((!is_dir($entry)) && ($entry != "index.htm"))
			{
				$str_filepath = $str_httppath.$entry;

				// used in PM?
				$sql = "SELECT privmsgs_text_id
						FROM ".PRIVMSGS_TEXT_TABLE."
						WHERE privmsgs_text LIKE '%".str_replace("\'", "''", $str_filepath)."%'";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
				}
				if ($db->sql_numrows($result) > 0)
				{
					$str_file = $up_picpath.$entry;
					if (filemtime($str_file) < $int_deadline)
					{
						unlink($str_file);
						$int_delcount++;
					}
				}
			}
		}
	}

	// view user details
	if (empty($HTTP_GET_VARS['uid']))
	{
	    $template->set_filenames(array('body' => 'admin/admin_uploadpic.tpl'));

		// get all users with files
		$directory = uploadpic_open_directory($up_picpath);

		$arr_user = array();
		$int_dirsize = 0;
		$int_count = 0;
		while ($entry = $directory->read())
		{
			if ((!is_dir($entry)) && ($entry != "index.htm"))
			{
				$int_userid = intval(substr($entry,0,strpos($entry,"_")));

				if(empty($arr_user[$int_userid]['name']))
				{
					$sql = "SELECT username
							FROM ".USERS_TABLE."
							WHERE user_id = ".$int_userid;
					if (!($result = $db->sql_query($sql)))
					{
						message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$arr_user[$int_userid]['name'] = strtolower($row['username']);
					$arr_user[$int_userid]['nameorig'] = $row['username'];
				}
				$int_filesize = filesize($up_picpath.$entry);
				$arr_user[$int_userid]['count']++;
				$arr_user[$int_userid]['fsize'] += $int_filesize;
				$int_count++;
				$int_dirsize += $int_filesize;
			}
		}

		asort($arr_user);
		foreach($arr_user as $key => $value)
		{
			$template->assign_block_vars('uploadpic_row', array(
				'ROW_USERNAME' => $value['nameorig'],
				'ROW_COUNT' => $value['count'],
				'ROW_FSIZE' => round($value['fsize']/1024)."k",
				'ROW_USERLINK' => append_sid('admin_uploadpic.'.$phpEx.'?uid='.$key)
			));
		}

		if ((!empty($HTTP_GET_VARS['upprune'])) || (!empty($HTTP_GET_VARS['uppmprune'])))
		{
			$template->assign_block_vars('switch_pixdeleted', array());
		}

		$template->assign_vars(array(
			'L_UPVERSION' => 'v1.3.2',
			'L_UPLOADPIC_EXPLAIN' => $lang['UP_Explain'],
			'L_DELMESSAGE' => sprintf($lang['UP_PixDeleted'], $int_delcount),
			'L_CONFIG' => $lang['Configuration'],
			'L_USERNAME' => $lang['Username'],
			'L_FILES' => $lang['UP_Files'],
			'L_NUMFILES' => $int_count,
			'L_SIZE' => $lang['UP_Size'],
			'L_DIRSIZE' => round($int_dirsize/1024)."k",
			'L_TOTAL' => $lang['UP_Total'],
			'URL_UPPRUNE' => '<a href="'.append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?upprune=true').'" onclick="return confirm(\''.$lang['UP_UPPrune'].'?\')">'.$lang['UP_UPPrune'].'</a>',
			'URL_UPPMPRUNE' => '<a href="'.append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?uppmprune=true').'" onclick="return confirm(\''.$lang['UP_UPPMPrune'].'?\')">'.$lang['UP_UPPMPrune'].'</a>'
		));
	}
	else
	{
		$sql = "SELECT username FROM ".USERS_TABLE." WHERE user_id = ".intval($HTTP_GET_VARS['uid']);
		if (!($result = $db->sql_query($sql)))
		{
				message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}
		$row_uname = $db->sql_fetchrow($result);

	    $template->set_filenames(array('body' => 'admin/admin_uploadpic_user.tpl'));

		// show userdetails
		$directory = uploadpic_open_directory($up_picpath);

		$int_dirsize = 0;
		$arr_files = array();
		while ($entry = $directory->read())
		{
			if ((!is_dir($entry)) && ($entry != "index.htm"))
			{
				$int_userid = intval(substr($entry,0,strpos($entry,"_")));
				if ($int_userid == $HTTP_GET_VARS['uid'])
				{
					$arr_files[$entry] = filemtime($up_picpath.$entry);
				}
			}
		}
		arsort($arr_files);

		foreach ($arr_files as $str_filename => $int_filetime)
		{
			$int_filesize = filesize($up_picpath.$str_filename);
			$int_dirsize += $int_filesize;

			$str_filestatus = uploadpic_getfilestatus($str_httppath.$str_filename);
			$int_size = getimagesize($up_picpath.$str_filename);

			$str_filepath = $str_httppath.$str_filename;
			$str_url = "<a href=\"".$str_filepath."\" onclick=\"window.open('".$str_filepath."', '_upicture', 'HEIGHT=".($int_size[1]+40).",resizable=yes,scrollbars=yes,WIDTH=".($int_size[0]+40)."');return false;\" target=\"_upicture\" class=\"nav\">".$str_filename."</a>";
			
			$template->assign_block_vars('uploadpic_row', array(
				'ROW_FILENAME' => $str_url,
				'ROW_FILESIZE' => round($int_filesize/1024)."k",
				'ROW_FILEDATE' => create_date($board_config['default_dateformat'], $int_filetime, $board_config['board_timezone']),
				'ROW_FILESTATUS' => (empty($str_filestatus)) ? $lang['No'] : $str_filestatus,
				'ROW_DELURL' => (empty($str_filestatus)) ? '<a href='.append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?uid='.$HTTP_GET_VARS['uid'].'&delpic='.$str_filename).">".$lang['Delete']."</a>" : '<a href='.append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?uid='.$HTTP_GET_VARS['uid'].'&censorpic='.$str_filename).' onclick="return confirm(\''.$lang['UP_CensorAsk'].'\')">'.$lang['UP_Censor'].'</a>'
			));
		}

		$template->assign_vars(array(
			'L_TITLE' => $lang['UploadPic_menu_users'],
			'L_UPLOADPIC_EXPLAIN' => sprintf($lang['UP_Userfiles'], $row_uname['username']),
			'L_USED' => $lang['UP_Used'],
			'L_ACTION' => $lang['Action'],
			'L_FILES' => $lang['UP_Files'],
			'L_NUMFILES' => count($arr_files),
			'L_SIZE' => $lang['UP_Size'],
			'L_DATE' => $lang['UP_Date'],
			'L_DIRSIZE' => round($int_dirsize/1024)."k",
			'L_BACK' => $lang['UP_Back2UL'],
			'URL_BACK' => append_sid('admin_uploadpic.'.$phpEx)
		));
	}

	// prepare page & output
	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
?>