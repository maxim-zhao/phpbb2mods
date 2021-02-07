<?php
/***************************************************************************
 *                            functions_attach.php
 *                            ---------------------
 *	Version:	9.0.0
 *	Begin:		Tuesday, Dec 06, 2006
 *   	Copyright:	(C) 2006-07, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		18:52 03/07/2007
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

if(!defined('IN_PHPBB'))
{
	die('Hacking Attempt');
}

//
// Filename Hash option
//
if($contact_config['contact_hash'] == 0)
{
	//
	// Normal Filenames
	//
	$attachment = !empty($attachment) ? strtolower(urlencode(basename($HTTP_POST_FILES['attachment']['name']))) : '';
	$attach = $server_url . $script_path . "/" . trim($contact_config['contact_file_root']) . "/" . decode_ip($user_ip) . "/" . $attachment;
}
else
{
	//
	// MD5 Filenames
	//
	$upload = strtolower(urlencode(basename($HTTP_POST_FILES['attachment']['name'])));

	// Get the file extension first
	$extn = substr(strrchr($upload, "."), 1);

	// Generate a random Filename
	$attachment = !empty($attachment) ? strtolower(md5(mt_rand() * time())  . "." . $extn) : '';
	$attach = $server_url . $script_path . "/" . trim($contact_config['contact_file_root']) . "/" . decode_ip($user_ip) . "/" . $attachment;
}

$delete_link = sprintf("\n" . $lang['Remove_file'], $server_url . $script_name . "?delete=" . decode_ip($user_ip) . "/" . $attachment . "\n");

//
// Was there an attachment? Yes? Then lets process it.
//
if(empty($attachment))
{
	$attach = $lang['Empty'];
	$delete_link = '';
}
else
{
	$filename = basename($HTTP_POST_FILES['attachment']['name']);
	$ext = strrchr(strtolower($filename), '.');

	//
	// Banned extentions
	//
	$blacklist = array(	'adp', 'as', 'asmx', 'asp', 'aspx', 'avi',
				'bat', 'bin',
				'cfg', 'cgi', 'com', 'cmd', 'css',
				'dhtm', 'dhtml', 'dll', 'doc',
				'exe',
				'fla',
				'gvi',
				'hta', 'htaccess', 'htm', 'html', 'htt',
				'inc', 'ini',
				'jar', 'js', 'jse', 'jsp', 'jspx',
				'lnk',
				'mdb', 'moov', 'mov', 'movie', 'mp3', 'mp4', 'mpa', 'mpe', 'mpeg', 'mpg',
				'obs',
				'pdf', 'php', 'php3', 'php4', 'php5', 'php6', 'phtm', 'phtml', 'pif', 'pl', 'ppt', 'prg',
				'ra', 'ram', 'raw', 'reg', 'rgs', 'rhtml', 'rm', 'rtf',
				'scr', 'sct', 'shb', 'shs', 'sht', 'shtm', 'shtml', 'sql', 'sys',
				'tlb', 'tpl', 'txt',
				'vb', 'vbe', 'vbs', 'vbscript', 'vdo',
				'wav', 'ws', 'wsf',
				'xls', 'xml'
			);
	//
	// Permitted extensions
	//
	$whitelist = array(	'bmp', 'gif', 'gz', 'gzip', 'jpeg', 'jpg', 'png', 'psd', 'rar', 'swf', 'tiff', 'zip' );

	if(in_array(trim($ext, '.'), $blacklist))
	{
		$CF_illegal_ext = $_br . sprintf($lang['Illegal_ext'], $ext) . "<br />" . $lang['zip_advise'];
		$CF_general_message = 1;
	}
	elseif(!in_array(trim($ext, '.'), $whitelist))
	{
		$CF_unknown_ext = $_br . sprintf($lang['Unknown_ext'], $ext) . "<br />" . $lang['zip_advise'];
		$CF_general_message = 1;
	}
	// Stage 2
	error_check();

	//
	// Extension safe - proceed with upload
	//
	if(($HTTP_POST_FILES['attachment']['size'] > intval($contact_config['contact_max_file_size'] * 1024)) || ($HTTP_POST_FILES['attachment']['error'] == 1))
	{
		$CF_attach_file_big = $_br . sprintf($lang['Attach-Too_big'], $contact_config['contact_max_file_size']) . "<br />" . $lang['zip_advise'];
		$CF_general_message = 1;
	}
	elseif(($HTTP_POST_FILES['attachment']['error'] == 3) || ($HTTP_POST_FILES['attachment']['error'] == 6))
	{
		$CF_attach_POST_error = $_br . $lang['POST_ERROR'];
		$CF_general_message = 1;
	}
	elseif(($HTTP_POST_FILES['attachment']['size'] == 0) || ($HTTP_POST_FILES['attachment']['error'] == 4))
	{
		$CF_attach_file_dud = $_br . $lang['Attach_dud'];
		$CF_general_message = 1;
	}
	elseif(file_exists(@phpbb_realpath($phpbb_root_path . $contact_config['contact_file_root'] . "/" . decode_ip($user_ip) . "/" . $attachment)))
	{
		$CF_attach_file_exists = $_br . $lang['Attach-File_exists'];
		$CF_general_message = 1;
	}
	// Stage 3
	error_check();

	//
	// Image Types
	//
	$imfilename = basename($HTTP_POST_FILES['attachment']['name']);

	$image_types = array( 'bmp', 'gif', 'jpg', 'jpeg', 'png', 'tiff', 'swf', 'psd' );
	$imext = strrchr(strtolower($imfilename), ".");

	if(in_array(trim($imext, '.'), $image_types))
	{
		list($width, $height, $type) = @getimagesize($HTTP_POST_FILES['attachment']['tmp_name']);

		if(intval($width) > 0 && intval($height) > 0)
		{
			switch ($type)
			{
				// GIF
				case 1:
					if($imext != '.gif')
					{
						$CF_image_error = $_br . $lang['Image_error'];
						$CF_general_message = 1;
					}
					break;

				// JPG, JPC, JP2, JPX, JB2
				case 2:
				case 9:
				case 10:
				case 11:
				case 12:
					if($imext != '.jpg' && $imext != '.jpeg')
					{
						$CF_image_error = $_br . $lang['Image_error'];
						$CF_general_message = 1;
					}
					break;

				// PNG
				case 3:
					if($imext != '.png')
					{
						$CF_image_error = $_br . $lang['Image_error'];
						$CF_general_message = 1;
					}
					break;

				// SWF
				case 4:
					if($imext != '.swf')
					{
						$CF_image_error = $_br . $lang['Image_error'];
						$CF_general_message = 1;
					}
					elseif($imext == '.swf')
					{
						$CF_image_zip = $_br . $lang['Image_zip'];
						$CF_general_message = 1;
					}
					break;

				// PSD
				case 5:
					if($imext != '.psd')
					{
						$CF_image_error = $_br . $lang['Image_error'];
						$CF_general_message = 1;
					}
					elseif($imext == '.psd')
					{
						$CF_image_zip = $_br . $lang['Image_zip'];
						$CF_general_message = 1;
					}
					break;

				// BMP
				case 6:
					if($imext != '.bmp')
					{
						$CF_image_error = $_br . $lang['Image_error'];
						$CF_general_message = 1;
					}
					elseif($imext == '.bmp')
					{
						$CF_image_zip = $_br . $lang['Image_zip'];
						$CF_general_message = 1;
					}
					break;

				// TIFF's
				case 7:
				case 8:
					if($imext != '.tiff')
					{
						$CF_image_error = $_br . $lang['Image_error'];
						$CF_general_message = 1;
					}
					elseif($imext == '.tiff')
					{
						$CF_image_zip = $_br . $lang['Image_zip'];
						$CF_general_message = 1;
					}
					break;

				default:
						$CF_image_error = $_br . $lang['Image_error'];
						$CF_general_message = 1;
			}
		}
		else
		{
			// XSS?
			$CF_image_error = $_br . $lang['Image_error'];
			$CF_general_message = 1;
		}
	}
			// Stage 4
	error_check();

	if(!file_exists(@phpbb_realpath($phpbb_root_path . $contact_config['contact_file_root'] . "/" . decode_ip($user_ip))))
	{
		if(!file_exists(@phpbb_realpath($phpbb_root_path . $contact_config['contact_file_root'] . "/")))
		{
			@mkdir($contact_config['contact_file_root'] . "/", 0755);

			$fd =	@fopen($contact_config['contact_file_root'] . "/index.html", 'a');
				@fclose($fd);
		}
		@mkdir($contact_config['contact_file_root'] . "/" . decode_ip($user_ip), 0755);
	}

	if(@is_uploaded_file($HTTP_POST_FILES['attachment']['tmp_name']))
	{
		@move_uploaded_file($HTTP_POST_FILES['attachment']['tmp_name'],  $contact_config['contact_file_root'] . "/" . decode_ip($user_ip) . "/" . $attachment);

		$fa =	@fopen($contact_config['contact_file_root'] . "/" . decode_ip($user_ip) . "/index.html", 'a');
			@fclose($fa);

		$CF_attach_success = $_br . $lang['Attach-Uploaded'];
	}
	else
	{
		@unlink($attach);
		$CF_attach_POST_error = $_br . $lang['POST_ERROR'];
		$CF_general_message = 1;
	}
}

?>