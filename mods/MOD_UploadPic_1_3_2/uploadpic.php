<?php
	/*******************************************
	*              uploadpic.php               *
	*              -------------               *
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
	define('IN_PHPBB', true);

	$phpbb_root_path = './';
	include($phpbb_root_path . 'extension.inc');
	include($phpbb_root_path . 'common.'.$phpEx);
	require($phpbb_root_path . 'includes/uploadpic_functions.'.$phpEx);
	$gen_simple_header = TRUE;

	uploadpic_creatvars();

	// Start session management
	$userdata = session_pagestart($user_ip, PAGE_UPLOADPIC);
	init_userprefs($userdata);


	// catch general errors

	// picture-directory here and writable?
	if (file_exists($up_picpath))
	{
		if (!is_writable($up_picpath))
		{
			message_die(GENERAL_ERROR, $lang['UP_ErrWritable']);
		}
	}
	else
	{
		message_die(GENERAL_ERROR, $lang['UP_ErrImgDir']);
	}

	// GD installed?
	if (!@extension_loaded('gd'))
	{
		message_die(GENERAL_ERROR, $lang['UP_ErrGDLib']);
	}
	else if (function_exists('imagecopyresampled') && function_exists('imagecreatetruecolor'))
	{
		$int_gdv = 2;
	}
	else
	{
		$int_gdv = 1;
	}

	// logged in?
	if ($userdata['user_id'] < 1)
	{
		message_die(GENERAL_ERROR, $lang['UP_ErrLogin']);
	}

	// allowed to upload?
	if ($userdata['user_allow_uploadpic'] != 1)
	{
		message_die(GENERAL_ERROR, $lang['UP_ErrPermission']);
	}

	// minimum number of posts reached?
	if ($userdata['user_posts'] < intval($board_config['uploadpic_minposts']))
	{
		message_die(GENERAL_ERROR, sprintf($lang['UP_ErrMinposts'], $board_config['uploadpic_minposts']));
	}


	// delete pic? (user pressed "back" or "cancel" after upload)
	$str_delpic = basename($HTTP_GET_VARS['old']);
	if ((!empty($str_delpic)) && ($board_config['uploadpic_delete']))
	{
		// may only delete own files that are not in use (prevent hacking-attempt)
		$int_userid = intval(substr($str_delpic, 0, strpos($str_delpic,"_")));
		if ($int_userid == $userdata['user_id'])
		{
			$sql = "SELECT post_id
					FROM ".POSTS_TEXT_TABLE."
					WHERE post_text LIKE '%".str_replace("\'", "''", $str_delpic)."%'
					LIMIT 0,1";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
			}
			if ($db->sql_numrows($result) == 0)
			{
				if (file_exists($up_picpath.$str_delpic))
				{
					unlink($up_picpath.$str_delpic);
				}
			}
		}
	}


	// pic uploaded ?
	if (!empty($HTTP_POST_FILES['uploadpic_file']['tmp_name']))
	{
		if (strpos($board_config['uploadpic_allowed'], $HTTP_POST_FILES['uploadpic_file']['type']) !== false)
		{
			$str_datatype = uploadpic_translate_datatype($HTTP_POST_FILES['uploadpic_file']['type']);

			// move (or copy) uploaded file, depending on PHP-version - this is to prevent "open_basedir"-errors
			srand((double)microtime()*1000000);
			do
			{
				$str_tmpname = md5(uniqid(rand())).".".$str_datatype;
			}
			while(file_exists($up_picpath.$str_tmpname));

			$function_movefile = (function_exists('move_uploaded_file')) ? 'move_uploaded_file' : 'copy';
			$function_movefile($HTTP_POST_FILES['uploadpic_file']['tmp_name'], $up_picpath.$str_tmpname);
			@chmod($up_picpath.$str_tmpname, 0777);

			$int_size = getimagesize($up_picpath.$str_tmpname);

			if (!uploadpic_check_datatype($str_datatype, $int_size[2]))
			{
				@unlink($up_picpath.$str_tmpname);
				message_die(GENERAL_ERROR, $lang['UP_ErrUpload'], '', __LINE__, __FILE__);
			}

			// custom size?
			if(!empty($HTTP_POST_VARS['uploadpic_size']))
			{
				$board_config['uploadpic_maxpicx'] = max(min(intval($HTTP_POST_VARS['uploadpic_size']),$board_config['uploadpic_maxpicx']),$board_config['uploadpic_minimum']);
				$board_config['uploadpic_maxpicy'] = max(min(intval($HTTP_POST_VARS['uploadpic_size']),$board_config['uploadpic_maxpicy']),$board_config['uploadpic_minimum']);
			}

			// rotate?
			$int_angle = max(0,min(360,intval($HTTP_POST_VARS['uploadpic_rotate'])));
			if ($int_angle > 0)
			{
				$str_temp = uploadpic_get_image($str_datatype, $up_picpath.$str_tmpname);

				$str_image = imagerotate($str_temp, (360-$int_angle), 0);
				$int_size[0] = imagesx($str_image);
				$int_size[1] = imagesy($str_image);
				imagedestroy($str_temp);
			}
			else
			{
				$int_size = getimagesize($up_picpath.$str_tmpname);
			}

			// image too big?
			if (($int_size[0] > $board_config['uploadpic_maxpicx']) || ($int_size[1] > $board_config['uploadpic_maxpicy']))
			{
				$up_picname = $userdata['user_id']."_".uploadpic_prepare_filename($HTTP_POST_FILES['uploadpic_file']['name'], $userdata['user_id'], "jpg");

				// calculate new size
				$int_factor = min(($board_config['uploadpic_maxpicx']/$int_size[0]),($board_config['uploadpic_maxpicy']/$int_size[1]));
				$int_newx = round($int_size[0]*$int_factor);
				$int_newy = round($int_size[1]*$int_factor);

				// load image (if not already loaded by rotation
				if (empty($str_image))
				{
					$str_image = uploadpic_get_image($str_datatype, $up_picpath.$str_tmpname);
				}

				// resize image (according to GD-version)
				if ($int_gdv == 2)
				{
					$str_newimage = imagecreatetruecolor($int_newx, $int_newy);
					if (!$str_newimage)
					{
						message_die(GENERAL_ERROR, $lang['UP_ErrCreatePic']);
					}
					imagecopyresampled($str_newimage, $str_image, 0, 0, 0, 0, $int_newx, $int_newy, $int_size[0], $int_size[1]);
				}
				else
				{
					$str_newimage = imagecreate($int_newx, $int_newy);    
					if (!$str_newimage)
					{
						message_die(GENERAL_ERROR, $lang['UP_ErrCreatePic']);
					}
					imagecopyresized($str_newimage, $str_image, 0, 0, 0, 0, $int_newx, $int_newy, $int_size[0], $int_size[1]);    
				}

				if (($board_config['uploadpic_watermark'] == 1) && (file_exists($board_config['uploadpic_wmpicture'])))
				{
					$str_newimage = uploadpic_add_watermark($str_newimage, $int_newx, $int_newy);
				}

				touch($up_picpath.$up_picname);
				imagejpeg($str_newimage, $up_picpath.$up_picname, $board_config['uploadpic_jpgqual']);
				imagedestroy($str_image);
				imagedestroy($str_newimage);
			}
			else
			{
				// image-dimensions ok, check if image has been rotated
				if (!empty($str_image))
				{
					$up_picname = $userdata['user_id']."_".uploadpic_prepare_filename($HTTP_POST_FILES['uploadpic_file']['name'], $userdata['user_id'], "jpg");

					if (($board_config['uploadpic_watermark'] == 1) && (file_exists($board_config['uploadpic_wmpicture'])))
					{
						$str_image = uploadpic_add_watermark($str_image, $int_size[0], $int_size[1]);
					}

					touch($up_picpath.$up_picname);
					imagejpeg($str_image, $up_picpath.$up_picname, $board_config['uploadpic_jpgqual']);
					imagedestroy($str_image);
				}
				else
				{
					// no resize, no rotation
					if (($board_config['uploadpic_watermark'] == 1) && (file_exists($board_config['uploadpic_wmpicture'])))
					{
						$up_picname = $userdata['user_id']."_".uploadpic_prepare_filename($HTTP_POST_FILES['uploadpic_file']['name'], $userdata['user_id'], "jpg");

						$str_image = uploadpic_get_image($str_datatype, $up_picpath.$str_tmpname);
						$str_image = uploadpic_add_watermark($str_image, $int_size[0], $int_size[1]);

						touch($up_picpath.$up_picname);
						imagejpeg($str_image, $up_picpath.$up_picname, $board_config['uploadpic_jpgqual']);
						imagedestroy($str_image);
					}
					else
					{
						// uploaded picture will stay unchanged
						$up_picname = $userdata['user_id']."_".uploadpic_prepare_filename($HTTP_POST_FILES['uploadpic_file']['name'], $userdata['user_id'], $str_datatype);

						rename($up_picpath.$str_tmpname, $up_picpath.$up_picname);
					}
				}
	
				$int_newx = $int_size[0];
				$int_newy = $int_size[1];
			}
			@chmod($up_picpath.$up_picname, 0777);

			// file too big? (after rotation/conversion)
			if (filesize($up_picpath.$up_picname) > ($board_config['uploadpic_maxsize']*1024))
			{
				unlink($up_picpath.$up_picname);
				$str_message = $lang['UP_ErrFilesize'];
			}
	
			if (file_exists($up_picpath.$str_tmpname))
			{
				unlink($up_picpath.$str_tmpname);
			}
		}
		else
		{
			$str_message = sprintf($lang['UP_ErrDatatype'], $HTTP_POST_FILES['uploadpic_file']['type']);
		}
	}


	// Generate the page
	$page_title = $lang['UploadPic'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$str_inputname = "message";
	if (!empty($HTTP_GET_VARS['inputname']))
	{
		$str_inputname = uploadpic_strip_characters($HTTP_GET_VARS['inputname']);
	}
	else if (!empty($HTTP_POST_VARS['inputname']))
	{
		$str_inputname = uploadpic_strip_characters($HTTP_POST_VARS['inputname']);
	}

	$str_formname = "post";
	if (!empty($HTTP_GET_VARS['formname']))
	{
		$str_formname = uploadpic_strip_characters($HTTP_GET_VARS['formname']);
	}
	else if (!empty($HTTP_POST_VARS['formname']))
	{
		$str_formname = uploadpic_strip_characters($HTTP_POST_VARS['formname']);
	}

	// successful upload?
	if ((!empty($HTTP_POST_FILES['uploadpic_file']['tmp_name'])) && ($str_message == ""))
	{
		$template->set_filenames(array(
			'body' => 'uploadpic_posted.tpl')
		);
	
		$str_picurl = $str_httppath.$up_picname;

		if ($board_config['uploadpic_showlink'] != 1)
		{
			$str_copyimg = '<u>'.$lang['UP_CopyText'].':</u>&nbsp;&nbsp;<a href="javascript:copycode(\'[img]'.$str_picurl.'[/img]\', \'\')">'.$lang['UP_CopyCode'].'</a>';
			if ($board_config['uploadpic_lrmod'])
			{
				$str_copyimg .= ' | <a href="'.'javascript:copycode(\'[img=right]'.$str_picurl.'[/img]\', \'\')'.'">'.$lang['UP_CopyCodeRight'].'</a> | <a href="'.'javascript:copycode(\'[img=left]'.$str_picurl.'[/img]\', \'\')'.'">'.$lang['UP_CopyCodeLeft'].'</a>';
			}
			$str_copyimg .= '<br /><br />';
		}
		if ($board_config['uploadpic_showlink'] > 0)
		{
			$str_copyurl = '<a href="javascript:copycode(\'[url='.$str_picurl.']'.$lang['UP_PFile'].'[/url]\', \'\')">'.$lang['UP_CopyURL'].'</a><br />';
		}

		if ( $board_config['uploadpic_multiple'] == 1 )
		{
			 $template->assign_block_vars('switch_multiple', array());
		}

		$template->assign_vars(array(
			'L_TITLE' => $lang['UP_Title'],
			'INPUTNAME' => $str_inputname,
			'FORMNAME' => $str_formname,
			'L_CLOSEWIN' => $lang['UP_CloseWindow'],
			'L_COPYCODERIGHT' => $lang['UP_CopyCodeRight'],
			'L_NEWX' => $int_newx,
			'L_NEWY' => $int_newy,
			'L_PICNAME' => $up_picname,
			'L_BBCODE' => ($board_config['uploadpic_vbbcode']) ? '<hr /><u>'.$lang['UP_BBCode'].'</u>: <input name="clipboard" type="text" id="clipboard" onfocus="this.select();" onclick="this.select();" value="[img]'.$str_picurl.'[/img]" size="40" />' : '',
			'L_BACK' => $lang['Previous'],
			'URL_COPYIMG' => $str_copyimg,
			'URL_COPYURL' => $str_copyurl,
			'URL_BACK' => append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?old='.$up_picname.'&inputname='.$str_inputname.'&formname='.$str_formname),
			'URL_BACKDEL' => append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?old='.$up_picname.'&clwin=1'),
			'URL_MULTIPLE' => '<a href="javascript:copycode(\'[img]'.$str_picurl.'[/img]\\n\', \''.append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?inputname='.$str_inputname.'&formname='.$str_formname).'\')">'.$lang['UP_Multiple'].'</a>',
			'IMG_PICTURE' => $str_picurl
			)
		);
	}
	else if (!empty($HTTP_GET_VARS['vgallery']))
	{
		if ($board_config['uploadpic_gallery'])
		{
			// show user-gallery
			$template->set_filenames(array(
				'body' => 'uploadpic_gallery.tpl')
			);

			$directory = uploadpic_open_directory($up_picpath);
	
			$int_totalsize = 0;
			$arr_files = array();
			while ($entry = $directory->read())
			{
				if ((!is_dir($entry)) && ($entry != "index.htm"))
				{
					$int_userid = intval(substr($entry,0,strpos($entry,"_")));
					if ($int_userid == $userdata['user_id'])
					{
						$arr_files[$entry] = filemtime($up_picpath.$entry);
					}
				}
			}
			arsort($arr_files);

			foreach ($arr_files as $str_filename => $int_filetime)
			{
				$int_size = getimagesize($up_picpath.$str_filename);
				$int_filesize = filesize($up_picpath.$str_filename);
				$int_totalsize += $int_filesize;

				$str_picurl = $str_httppath.$str_filename;

				if ($board_config['uploadpic_showlink'] != 1)
				{
					$str_copyimg = '<u>'.$lang['UP_CopyText'].':</u>&nbsp;&nbsp;<a href="javascript:copycode(\'[img]'.$str_picurl.'[/img]\')">'.$lang['UP_CopyCode'].'</a>';
					if ($board_config['uploadpic_lrmod'])
					{
						$str_copyimg .= ' | <a href="'.'javascript:copycode(\'[img=right]'.$str_picurl.'[/img]\')'.'">'.$lang['UP_CopyCodeRight'].'</a> | <a href="'.'javascript:copycode(\'[img=left]'.$str_picurl.'[/img]\')'.'">'.$lang['UP_CopyCodeLeft'].'</a>';
					}

					if ($board_config['uploadpic_showlink'] > 0)
					{
						$str_copyimg .= ' | ';
					}
				}
				if ($board_config['uploadpic_showlink'] > 0)
				{
					$str_copyurl = '<a href="javascript:copycode(\'[url='.$str_picurl.']'.$lang['UP_PFile'].'[/url]\')">'.$lang['UP_CopyURL'].'</a><br />';
				}

				$class = ($int_count%2) ? $theme['td_class2'] : $theme['td_class1'];

				$int_sizedisplay = $int_size;
				$str_resized = "";
				if (max($int_size[0], $int_size[1]) > $board_config['uploadpic_gallerysize'])
				{
					$int_factor = ($board_config['uploadpic_gallerysize']/max($int_size[0], $int_size[1]));
					$int_sizedisplay[0] = round($int_size[0]*$int_factor);
					$int_sizedisplay[1] = round($int_size[1]*$int_factor);
					$str_resized = " (".$lang['UP_Resized'].")";
				}

				$template->assign_block_vars('uppictures_row', array(
					'ROW_FILEPATH' => $str_httppath.$str_filename,
					'ROW_FILENAME' => $str_filename,
					'ROW_FILESIZE' => round($int_filesize/1024)."k",
					'ROW_FILEDATE' => create_date($board_config['default_dateformat'], $int_filetime, $board_config['board_timezone']),
					'ROW_PICWIDTH' => $int_size[0],
					'ROW_PICHEIGHT' => $int_size[1],
					'ROW_PICWIDTHDISPLAY' => $int_sizedisplay[0],
					'ROW_PICHEIGHTDISPLAY' => $int_sizedisplay[1],
					'ROW_RESIZED' => $str_resized,
					'ROW_STYLE' => $class,
					'ROW_URL_COPYIMG' => $str_copyimg,
					'ROW_URL_COPYURL' => $str_copyurl
				));
			}

			$template->assign_vars(array(
				'L_YOURPICS' => $lang['UP_YourPics'],
				'INPUTNAME' => $str_inputname,
				'FORMNAME' => $str_formname,
				'L_NUMBER' => count($arr_files),
				'L_FILES' => $lang['UP_Files'],
				'L_TOTALSIZE' => round($int_totalsize/1024)."k",
				'L_BACK' => $lang['UP_Back'],
				'URL_BACK' => append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?inputname='.$str_inputname.'&formname='.$str_formname)
			));
		}
		else
		{
			message_die(GENERAL_ERROR, $lang['UP_ErrNoGallery']);
		}
	}
	else
	{
		// show upload-form
		$template->set_filenames(array(
			'body' => 'uploadpic_body.tpl')
		);
	
		// some PHP/GD-Versions don't have the function "imagerotate", so we'll create a switch to hide the option
		if ( function_exists('imagerotate') )
		{
			 $template->assign_block_vars('switch_imagerotate_ok', array());
		}

		if ( $board_config['uploadpic_gallery'] == 1 )
		{
			 $template->assign_block_vars('switch_gallery', array());
		}

		if ( !empty($lang['UP_Information']) )
		{
			 $template->assign_block_vars('switch_information', array());
		}

		if (!empty($HTTP_GET_VARS['clwin']))
		{
			// close window (user pressed "cancel")
			 $template->assign_block_vars('switch_closewindow', array());
		}

		$template->assign_vars(array(
			'L_TITLE' => $lang['UP_Title'],
			'INPUTNAME' => $str_inputname,
			'FORMNAME' => $str_formname,
			'L_CLOSEWIN' => $lang['UP_CloseWindow'],
			'L_PICTURE' => $lang['UP_PFile'],
			'L_SEND' => $lang['UP_send'],
			'L_DATATYPES' => $lang['UP_Datatypes'],
			'L_MESSAGE' => $str_message,
			'L_MAXX' => $board_config['uploadpic_maxpicx'],
			'L_MAXY' => $board_config['uploadpic_maxpicy'],
			'L_ALLOW' => str_replace("|", ", ",str_replace("image/","",$board_config['uploadpic_allowed'])),
			'L_DIMENSIONS' => $lang['UP_Dimensions'],
			'L_CONVERTED' => $lang['UP_Converted'],
			'L_MAXIMUM' => $lang['UP_Maximum'],
			'L_PIXEL' => $lang['UP_Pixel'],
			'L_CUSTOM' => $lang['UP_Custom'],
			'L_ROTATE' => $lang['UP_Rotate'],
			'L_ROTATE0' => $lang['UP_Rotate0'],
			'L_ROTATE90' => $lang['UP_Rotate90'],
			'L_ROTATE180' => $lang['UP_Rotate180'],
			'L_ROTATE270' => $lang['UP_Rotate270'],
			'L_GALLERY' => $lang['UP_Gallery'],
			'L_NOTE' => $lang['UP_Note'],
			'L_INFORMATION' => $lang['UP_Information'],
			'URL_GALLERY' => append_sid($HTTP_SERVER_VARS['PHP_SELF'].'?vgallery=true&inputname='.$str_inputname.'&formname='.$str_formname),
			'URL_SELF' => append_sid($HTTP_SERVER_VARS['PHP_SELF'])
			)
		);
	}

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>