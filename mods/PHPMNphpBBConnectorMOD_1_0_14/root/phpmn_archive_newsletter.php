<?php 
/***************************************************************************
 *                               phpmn_archive_newsletter.php
 *                            -------------------
 *   begin                : Tuesday, Jul 22, 2006
 *   copyright            : (C) 2005 Martin Truckenbrodt
 *   email                : webmaster@martin-truckenbrodt.com
 *
 *   $Id: phpmn_archive_newsletter.php,v 1.0.5 $
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

$page_title = $lang['PHPMN_ARCHIVE_NEWSLETTER'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array('phpmn_archive_newsletter' => 'phpmn_archive_newsletter.tpl'));

if ( isset($HTTP_GET_VARS[PHPMN_NEWSID]) || isset($HTTP_POST_VARS[PHPMN_NEWSID]) )
{
	$newsid = ( isset($HTTP_GET_VARS[PHPMN_NEWSID]) ) ? intval($HTTP_GET_VARS[PHPMN_NEWSID]) : intval($HTTP_POST_VARS[PHPMN_NEWSID]);
}
else
{
	$newsid = "";
}

$sql = "SELECT archive_id, archive_newsid, archive_subject, archive_body, archive_timestamp FROM ". PHPMN_ARCHIVE_TABLE ." WHERE archive_id = $newsid LIMIT 0,1";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER NEWSLETTER list', '', __LINE__, __FILE__, $sql);
}

if ( !($row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER NEWSLETTER', '', __LINE__, __FILE__, $result);
}

extract($row);
$template->assign_vars(array(
	'VOLUME' => $archive_id,
	'DATE' => create_date($board_config['default_dateformat'], $archive_timestamp, $board_config['board_timezone']),
	'SUBJECT' => stripslashes($archive_subject),
	'BODY' => stripslashes(nl2br($archive_body)),
	'ID' => $archive_newsid,
	'HTML' => append_sid("phpmn_connector_mod/phpmn_html.$phpEx?newsid=" . $archive_id) . "&amp;id=" . $archive_newsid,
	'PLAIN' => append_sid("phpmn_connector_mod/phpmn_plain.$phpEx?newsid=" . $archive_id) . "&amp;id=" . $archive_newsid
));

$sql = "SELECT newsletter_title FROM ". PHPMN_NEWSLETTER_TABLE ." WHERE newsletter_id = $archive_newsid";
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
extract($row);

$template->assign_vars(array(
	'L_PHPMN_VOLUME' => $lang['L_PHPMN_VOLUME'],
	'L_PHPMN_DATE' => $lang['L_PHPMN_DATE'],
	'L_PHPMN_SUBJECT' => $lang['L_PHPMN_SUBJECT'],
	'L_PHPMN_SELECT' => $lang['L_PHPMN_SELECT'],
	'L_PHPMN_BODY' => $lang['L_PHPMN_BODY'],
	'L_PHPMN_NOARCHIVE' => $lang['L_PHPMN_NOARCHIVE'],
	'L_PHPMN_VIEW_HTML' => $lang['L_PHPMN_VIEW_HTML'],
	'L_PHPMN_VIEW_PLAIN' => $lang['L_PHPMN_VIEW_PLAIN'],
	'NEWSLETTER_TITLE' => $newsletter_title,
	'NEWSLETTER_LINK' => append_sid("{$phpbb_root_path}phpmn_archive.$phpEx?id=$archive_newsid"),
	'NEWS_SUBJECT' => stripslashes($archive_subject),
	'NEWS_LINK' => append_sid("{$phpbb_root_path}phpmn_archive_newsletter.$phpEx?newsid=$newsid")
));

$template->pparse('phpmn_archive_newsletter');

include($phpbb_root_path . 'includes/phpmn_footer.'.$phpEx); 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 
?>