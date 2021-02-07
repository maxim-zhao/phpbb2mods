<?php 
/***************************************************************************
 *                               phpmn_archive.php
 *                            -------------------
 *   begin                : Tuesday, Jul 22, 2006
 *   copyright            : (C) 2005 Martin Truckenbrodt
 *   email                : webmaster@martin-truckenbrodt.com
 *
 *   $Id: phpmn_archive.php,v 1.0.6 $
 *
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

include($phpbb_root_path . 'includes/phpmn_constants.'.$phpEx); 

$userdata = session_pagestart($user_ip, PAGE_NEWSLETTER); 
init_userprefs($userdata); 

$language = $userdata['user_lang'];

if ( !file_exists($phpbb_root_path . 'language/lang_' . $language . '/lang_main_phpmn.'.$phpEx) )
{
	$language = $board_config['default_lang'];
}

include($phpbb_root_path . 'language/lang_' . $language . '/lang_main_phpmn.' . $phpEx);

$page_title = $lang['PHPMN_ARCHIVE'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array('phpmn_archive' => 'phpmn_archive.tpl'));

if ( isset($HTTP_GET_VARS[PHPMN_ID]) || isset($HTTP_POST_VARS[PHPMN_ID]) )
{
	$id = ( isset($HTTP_GET_VARS[PHPMN_ID]) ) ? intval($HTTP_GET_VARS[PHPMN_ID]) : intval($HTTP_POST_VARS[PHPMN_ID]);
}
else
{
	$id = "";
}

$sql = "SELECT newsletter_title FROM ". PHPMN_NEWSLETTER_TABLE ." WHERE newsletter_id = $id";
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
extract($row);

$template->assign_vars(array(
	'ID' => $id,
	'TITLE' => $newsletter_title
));

$sql = "SELECT archive_id, archive_subject, archive_body, archive_timestamp FROM ". PHPMN_ARCHIVE_TABLE ." WHERE archive_newsid = $id ORDER BY archive_timestamp DESC";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER ARCHIVE list', '', __LINE__, __FILE__, $sql);
}

if ($db->sql_numrows($result) > 0)
{
	while ($row = $db->sql_fetchrow($result))
	{
		extract($row);
		$template->assign_block_vars('list', array(
			'VOLUME' => $archive_id,
			'DATE' => create_date($board_config['default_dateformat'], $archive_timestamp, $board_config['board_timezone']),
			'SUBJECT' => stripslashes($archive_subject),
			'ID' => $id,
			'SELECT' => append_sid("phpmn_archive_newsletter.$phpEx?newsid=" . $archive_id)
		));
	}
}
else
{
	$template->assign_block_vars('noarchive', array('NOARCHIVE' => $lang['L_PHPPMN_NOARCHIVE']));
}

$template->assign_vars(array(
	'L_PHPMN_VOLUME' => $lang['L_PHPMN_VOLUME'],
	'L_PHPMN_DATE' => $lang['L_PHPMN_DATE'],
	'L_PHPMN_SUBJECT' => $lang['L_PHPMN_SUBJECT'],
	'L_PHPMN_SELECT' => $lang['L_PHPMN_SELECT'],
	'L_PHPMN_BODY' => $lang['L_PHPMN_BODY'],
	'L_PHPMN_NOARCHIVE' => $lang['L_PHPMN_NOARCHIVE'],
	'SELECT_IMG' => $images['icon_select'],
	'L_SELECT_IMG' => $lang['L_PHPMN_SELECT'],
	'NEWSLETTER_TITLE' => $newsletter_title,
	'NEWSLETTER_LINK' => append_sid("{$phpbb_root_path}phpmn_archive.$phpEx?id=$id")
));

$template->pparse('phpmn_archive');

include($phpbb_root_path . 'includes/phpmn_footer.'.$phpEx); 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 
?>