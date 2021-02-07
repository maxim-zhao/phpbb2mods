<?php
	/*******************************************
	*         uploadpic_functions.php          *
	*         -----------------------          *
	*                                          *
	*   date       : 08/2005 - 04/2006         *
    *   version    : 1.3.2                     *
	*   (C)/author : B.Funke                   *
	*   URL        : http://forum.beehave.de   *
	*                                          *
	********************************************/

/* UploadPic can be freely copied and used, as long as all provided files remain unchanged. */
/* For all further terms, the GNU GENERAL PUBLIC LICENSE applies to this MOD. */


	// checks the picture-datatype (prevent XSS-exploit)
	function uploadpic_check_datatype($str_datatype, $int_type)
	{
		switch ($int_type)
		{
			case 1:		$datatypeok = ($str_datatype == "gif");
						break;
			case 2:
			case 9:
			case 10:
			case 11:
			case 12:	$datatypeok = ($str_datatype == "jpg");
						break;
			case 3:		$datatypeok = ($str_datatype == "png");
						break;
			default:	$datatypeok = false;
		}

		return $datatypeok;
	}

	// adds a watermark to a picture
	function uploadpic_add_watermark($str_picture, $int_picx, $int_picy)
	{
		global $phpbb_root_path, $board_config;

		if (($int_picx >= $board_config['uploadpic_wmpicx']) && ($int_picy >= $board_config['uploadpic_wmpicy']))
		{
			$int_wmsize = getimagesize($board_config['uploadpic_wmpicture']);

			$int_wmxpos = 0;
			$int_wmypos = 0;

			switch($board_config['uploadpic_wmposition'])
			{
				case 2:	$int_wmxpos = round(($int_picx-$int_wmsize[0])/2);
						break;
				case 3:	$int_wmxpos = ($int_picx-$int_wmsize[0]);
						break;
				case 4:	$int_wmypos = ($int_picy-$int_wmsize[1]);
						break;
				case 5:	$int_wmxpos = round(($int_picx-$int_wmsize[0])/2);
						$int_wmypos = ($int_picy-$int_wmsize[1]);
						break;
				case 6:	$int_wmxpos = ($int_picx-$int_wmsize[0]);
						$int_wmypos = ($int_picy-$int_wmsize[1]);
						break;
			}

			// place watermark in picture
			$str_wmdatatype = uploadpic_translate_datatype($int_wmsize['mime']);
			$str_watermark = uploadpic_get_image($str_wmdatatype, $phpbb_root_path.$board_config['uploadpic_wmpicture']);
			imagecopy($str_picture, $str_watermark, $int_wmxpos, $int_wmypos, 0, 0, $int_wmsize[0], $int_wmsize[1]);
		}

		return $str_picture;
	}

	// loads an image
	function uploadpic_get_image($str_datatype, $str_tmpname)
	{
		global $lang, $board_config;

		if ($str_datatype == "jpg")
		{
			$str_image = @imagecreatefromjpeg($str_tmpname);
		}
		else if ($str_datatype == "png")
		{
			$str_image = @imagecreatefrompng($str_tmpname);
		}
		else if ($str_datatype == "gif")
		{
			if (function_exists('imagecreatefromgif'))
			{
				$str_image = @imagecreatefromgif($str_tmpname);
			}
			else
			{
				message_die(GENERAL_ERROR, sprintf($lang['UP_ErrCreateGIF'], $board_config['uploadpic_maxpicx'], $board_config['uploadpic_maxpicy']));
			}
		}

		if (!$str_image)
		{
			message_die(GENERAL_ERROR, $lang['UP_ErrCreatePic']);
		}

		return $str_image;
	}

	// checks datatype of uploaded image
	function uploadpic_translate_datatype($str_datatype)
	{
		preg_match('#image\/[x\-]*([a-z]+)#', $str_datatype, $str_datatype);
		$str_datatype = $str_datatype[1];

		$str_type = "";
		switch($str_datatype)
		{
			case 'jpeg':
			case 'pjpeg':
			case 'jpg':
				$str_type = "jpg";
				break;
			case 'gif':
				$str_type = "gif";
				break;
			case 'png':
				$str_type = "png";
				break;
		}

		return $str_type;
	}

	// strips everything but allowed characters
	function uploadpic_strip_characters($str_text)
	{
		$str_out = "";
		$allowed = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_";

		for($i=0;$i<strlen($str_text);$i++)
		{
			if (strpos($allowed,$str_text[$i])!==false) { $str_out .= $str_text[$i]; }
		}		

		return $str_out;
	}

	// prepares the filename
	function uploadpic_prepare_filename($str_name, $userid, $str_datatype)
	{
		global $board_config, $up_picpath;

		$str_ext = substr($str_name,strrpos($str_name,"."));
		$str_name = substr(str_replace(" ", "_", $str_name),0,strlen($str_name)-strlen($str_ext));

		$str_out = uploadpic_strip_characters($str_name);

		if ($board_config['uploadpic_uniqfn'])
		{
			$int_fnr = 1;
			while(file_exists($up_picpath.$userid."_".$str_out."_".$int_fnr.".".$str_datatype))
			{
				$int_fnr++;
			}
			$str_out .= "_".$int_fnr;
		}

		return $str_out.".".$str_datatype;
	}

	// opens the upload-directory
	function uploadpic_open_directory($dirname)
	{
		global $lang;

		$directory = @dir($dirname);
		if (!$directory)
		{
			message_die(GENERAL_ERROR, $lang['UP_ErrImgDir']." (".$dirname.")");
		}

		return $directory;
	}

	// checks if a file is in use
	function uploadpic_checkfileinuse($str_filepath)
	{
		global $phpbb_root_path, $phpEx, $db, $table_prefix;

		$fileinuse = 0;

		// used in post?
		$sql = "SELECT post_id
				FROM ".POSTS_TEXT_TABLE."
				WHERE post_text LIKE '%".str_replace("\'", "''", $str_filepath)."%'";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}
		if ($db->sql_numrows($result) == 0)
		{
			// used as avatar?
			$sql = "SELECT user_id
					FROM ".USERS_TABLE."
					WHERE user_avatar = '".$str_filepath."'";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
			}
			if ($db->sql_numrows($result) == 0)
			{
				// used in PM?
				$sql = "SELECT privmsgs_text_id
						FROM ".PRIVMSGS_TEXT_TABLE."
						WHERE privmsgs_text LIKE '%".str_replace("\'", "''", $str_filepath)."%'";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
				}
				if ($db->sql_numrows($result) == 0)
				{
					// used in signature?
					$sql = "SELECT user_id
							FROM ".USERS_TABLE."
							WHERE user_sig LIKE '%".str_replace("\'", "''", $str_filepath)."%'";
					if (!($result = $db->sql_query($sql)))
					{
						message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
					}
					if ($db->sql_numrows($result) == 0)
					{
						// check for presence of the "Knowledge Base"
						if (file_exists($phpbb_root_path.'kb.'.$phpEx))
						{
							// used in "Knowledge Base"?
							$sql = "SELECT article_id
									FROM ".$table_prefix."kb_articles
									WHERE article_body LIKE '%".str_replace("\'", "''", $str_filepath)."%'";
							if (!($result = $db->sql_query($sql)))
							{
								message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
							}
							if ($db->sql_numrows($result) != 0)
							{
								$fileinuse = 4;
							}
						}

						if ($fileinuse == 0)
						{
							// check for presence of "easyCMS"
							if (file_exists($phpbb_root_path.'cms_articles.'.$phpEx))
							{
								// used in "easyCMS"?
								$sql = "SELECT article_id
										FROM ".$table_prefix."cms_articles_text
										WHERE article_text LIKE '%".str_replace("\'", "''", $str_filepath)."%'";
								if (!($result = $db->sql_query($sql)))
								{
									message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
								}
								if ($db->sql_numrows($result) != 0)
								{
									$fileinuse = 5;
								}
							}
						}
					}
					else
					{
						$fileinuse = 6;
					}
				}
				else
				{
					$fileinuse = 3;
				}
			}
			else
			{
				$fileinuse = 2;
			}
		}
		else
		{
			$fileinuse = 1;
		}

		return $fileinuse;
	}

	// updates the configuration
	function uploadpic_update_config($str_name, $str_value)
	{
		global $board_config, $db;
	
		$sql = "SELECT config_value FROM ".CONFIG_TABLE." WHERE config_name = '".$str_name."'";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}
	
		if ($db->sql_numrows($result) == 0)
		{
			$sql = "INSERT INTO ".CONFIG_TABLE." (config_name, config_value)
					VALUES ('".$str_name."', '".str_replace("\'", "''", $str_value)."')";
		}
		else
		{
			$sql = "UPDATE ".CONFIG_TABLE."
					SET config_value = '".str_replace("\'", "''", $str_value)."'
					WHERE config_name = '".$str_name."'";
		}
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, '', '', __LINE__, __FILE__, $sql);
		}
	
		$board_config[$str_name] = $str_value;
	}

	// creates path-variables
	function uploadpic_creatvars()
	{
		global $board_config, $phpbb_root_path;
		global $up_picpath, $str_httppath;

		if (empty($board_config['uploadpic_picdir']))
		{
			message_die(GENERAL_ERROR, $lang['UP_ErrConfig']);
		}

		$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = ( $board_config['server_port'] <> 80 ) ? ':'.trim($board_config['server_port']) : '';

		// convert the picture-path for support with virtual directories while maintaining downward-compatibility
		$script_path = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
		$script_path = ($script_path != '') ? '/'.$script_path.'/' : '/';
		$up_picdir = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['uploadpic_picdir']));
		$up_picdir = ($up_picdir != '') ? '/'.$up_picdir.'/' : '/';

		if (substr($up_picdir,0,strlen($script_path)) == $script_path)
		{
			$up_path = substr($up_picdir,strlen($script_path));
		}
		else
		{
			$up_path = str_repeat("../", max(0,substr_count($script_path,"/")-1)).$up_picdir;
		}
		$up_picpath = str_replace("//", "/", $phpbb_root_path.$up_path);

		$str_httppath = (empty($board_config['uploadpic_forcepath'])) ? $server_protocol.trim($board_config['server_name']).$server_port.$up_picdir : $board_config['uploadpic_forcepath'];
	}

	// converts the filestatus
	function uploadpic_getfilestatus($str_file)
	{
		global $lang;

		$str_return = "";

		switch (uploadpic_checkfileinuse($str_file))
		{
			case 1:		# used in post
					$str_return = "<strong>".$lang['UP_Yes']."</strong>";
					break;
			case 2: 	# used as avatar
					$str_return = "<strong>".$lang['UP_Yes']."</strong> (".$lang['Avatar'].")";
					break;
			case 3:		# used in PM
					$str_return = "<strong>".$lang['UP_Yes']."</strong> (".$lang['UP_PMShort'].")";
					break;
			case 4:		# used in "Knowledge Base"
					$str_return = "<strong>".$lang['UP_Yes']."</strong> (".$lang['UP_KBShort'].")";
					break;
			case 5:		# used in "easyCMS"
					$str_return = "<strong>".$lang['UP_Yes']."</strong> (".$lang['UP_CMSShort'].")";
					break;
			case 6:		# used in signature
					$str_return = "<strong>".$lang['UP_Yes']."</strong> (".$lang['UP_SigShort'].")";
					break;
		}

		return $str_return;
	}

	// replaces (or deletes) a picture
	function uploadpic_censorpic($str_file)
	{
		global $images, $up_picpath, $phpbb_root_path, $lang;

		$str_rplimage = "";
		$str_suffix = substr(strrchr($str_file,"."),1);
		switch($str_suffix)
		{
			case 'jpeg':
			case 'pjpeg':
			case 'jpg':
				$str_rplimage = $images['uploadpic_censorjpg'];
				break;
			case 'gif':
				$str_rplimage = $images['uploadpic_censorgif'];
				break;
			case 'png':
				$str_rplimage = $images['uploadpic_censorpng'];
				break;
		}

		if (!empty($str_rplimage))
		{
			unlink($up_picpath.$str_file);
			if (file_exists($phpbb_root_path.$str_rplimage))
			{
				copy($phpbb_root_path.$str_rplimage, $up_picpath.$str_file);
				@chmod($up_picpath.$str_file, 0777);
			}
		}
		else
		{
			message_die(GENERAL_ERROR, sprintf($lang['UP_ErrDatatype'],$str_suffix), '', __LINE__, __FILE__);
		}
	}
?>