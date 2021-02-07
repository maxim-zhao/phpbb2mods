<?php
	/*******************************************
	*        admin_uploadpic_latest.php        *
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
		$module['UploadPic']['UploadPic_menu_latest'] = $filename;
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


    $template->set_filenames(array('body' => 'admin/admin_uploadpic_latest.tpl'));

	// get all files
	$directory = uploadpic_open_directory($up_picpath);

	$arr_files = array();
	while ($entry = $directory->read())
	{
		if ((!is_dir($entry)) && ($entry != "index.htm"))
		{
			$arr_files[$entry] = filemtime($up_picpath.$entry);
		}
	}
	arsort($arr_files);

	$arr_user = array();
	$int_count = 0;
	foreach ($arr_files as $str_filename => $int_filetime)
	{
		$int_userid = intval(substr($str_filename,0,strpos($str_filename,"_")));

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
			$arr_user[$int_userid]['name'] = $row['username'];
		}

		$str_filestatus = uploadpic_getfilestatus($str_httppath.$str_filename);
		$str_delurl = (empty($str_filestatus)) ? '<a href='.append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?delpic='.$str_filename).'>'.$lang['Delete'].'</a>' : '<a href='.append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?censorpic='.$str_filename).' onclick="return confirm(\''.$lang['UP_CensorAsk'].'\')">'.$lang['UP_Censor'].'</a>';

		$int_size = getimagesize($up_picpath.$str_filename);

		$template->assign_block_vars('latestfiles_row', array(
			'ROW_FILEPATH' => $str_httppath.$str_filename,
			'ROW_FILENAME' => $str_filename,
			'ROW_FILEDATE' => create_date($board_config['default_dateformat'], $int_filetime, $board_config['board_timezone']),
			'ROW_USED' => (empty($str_filestatus)) ? $lang['No'] : $str_filestatus,
			'ROW_USERNAME' => $arr_user[$int_userid]['name'],
			'ROW_FILESIZE' => round(filesize($up_picpath.$str_filename)/1024)."k (".$int_size[0]."x".$int_size[1].")",
			'ROW_ACTION' => $str_delurl
		));

		$int_count++;
		if (min(count($arr_files), $board_config['uploadpic_numlatest']) == $int_count)
		{
			break;
		}
	}

	$template->assign_vars(array(
		'L_TITLE' => $lang['UploadPic_menu_latest'],
		'L_LATEST' => sprintf($lang['UP_LatestUploads'], $board_config['uploadpic_numlatest']),
		'L_INFORMATION' => $lang['UP_Information'],
		'L_FILES' => $lang['UP_Files'],
		'L_USED' => $lang['UP_Used'],
		'L_FILENAME' => $lang['UP_Filename'],
		'L_SIZE' => $lang['UP_Size'],
		'L_USERNAME' => $lang['Username'],
		'L_DATE' => $lang['Date'],
		'L_ACTION' => $lang['Action'],
		'URL_SELF' => append_sid($HTTP_SERVER_VARS['PHP_SELF'])
	));


	// prepare page & output
	$template->pparse("body");

	include('./page_footer_admin.'.$phpEx);
?>