<?php
/***************************************************************************
 *                                hashcalc.php
 *                            -------------------
 *   copyright	: Y. C. LIN
 *   email		: ycl6@users.sourceforge.net
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

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_HASHCALC);
init_userprefs($userdata);
//
// End session management
//

if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = '';
}

if ( isset($HTTP_POST_VARS['search_filename']) || isset($HTTP_GET_VARS['search_filename']) )
{
	$search_filename = ( isset($HTTP_POST_VARS['search_filename']) ) ? $HTTP_POST_VARS['search_filename'] : $HTTP_GET_VARS['search_filename'];
	$search_filename = htmlspecialchars($search_filename);
}
else
{
	$search_filename = '';
}

$page_title = $lang['Hashcalc'];

if ( $mode == "search_hash" )
{
	if ( !empty($search_filename) )
	{
		// Get directory and filename
		$dir = @opendir($phpbb_root_path . $board_config['hashculc_file_path']);
		while (false !== ($filename = readdir($dir)))
		{
			if ($filename != "." && $filename != "..")
			{
				if( $search_filename == $filename)
				{
					$file = $filename;
				}
			}
		}
		@closedir($dir);

		if (empty($file))
		{
			message_die(GENERAL_MESSAGE, $lang['No_hash_match']);
		}

		include($phpbb_root_path . 'includes/page_header.'.$phpEx);
			
		$template->set_filenames(array(
			'hashcalc' => 'hashcalc_results_body.tpl')
		);

		make_jumpbox('viewforum.'.$phpEx);

		$filepath = $phpbb_root_path . $board_config['hashculc_file_path'].'/'.$file;
		$md5sum = md5_file($filepath);
		$sha1_file = sha1_file($filepath);
		$sfv_checksum = strtoupper(dechex(crc32(file_get_contents($filepath))));

		$template->assign_vars(array(
			"L_FILE" => $lang['File'],
			"L_FILE_HASH" => $lang['File_hash'],
			"L_HASH_MD5" => $lang['Hash_MD5'],
			"L_HASH_SHA1" => $lang['Hash_SHA1'],
			"L_HASH_SFV" => $lang['Hash_SFV'])
		);

		$template->assign_block_vars('file_hash', array(
			"FILENAME" => $file,
			"MD5" => $md5sum,
			"SHA1" => $sha1_file,
			"SFV" => $sfv_checksum)
		);

		$template->pparse('hashcalc');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['No_hash_match']);
	}
}

// Default page
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
$template->set_filenames(array(
	'body' => 'hashcalc_body.tpl')
);

make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'L_SEARCH_QUERY' => $lang['Search_query'],
	'L_SEARCH_FILE_HASH' => $lang['Search_file_hash'],
	'L_SEARCH_FILE_HASH_EXPLAINED' => $lang['Search_file_hash_explained'],

	'S_SEARCH_ACTION' => append_sid("hashcalc.$phpEx?mode=search_hash"),
	'S_HIDDEN_FIELDS' => '')
);

// Generate the page
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
