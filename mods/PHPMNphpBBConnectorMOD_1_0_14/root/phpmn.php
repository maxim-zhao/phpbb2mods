<?php 
/***************************************************************************
 *                               phpmn.php
 *                            -------------------
 *   begin                : Tuesday, Jul 23, 2006
 *   copyright            : (C) 2005 Martin Truckenbrodt
 *   email                : webmaster@martin-truckenbrodt.com
 *
 *   $Id: phpmn.php,v 1.0.9 $
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

$userip = 'phpbb';
$userts = time();

$page_title = $lang['PHPMN'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'phpmn' => 'phpmn.tpl')
);

if ($userdata['user_email'] != "")
{
	$now = "";
}
else
{
	$now = sprintf($lang['L_PHPMN_PLEASELOGIN'],"login.$phpEx") ;
}

if ( isset($HTTP_GET_VARS[PHPMN_EDIT]) || isset($HTTP_POST_VARS[PHPMN_EDIT]) )
{
	$edit = ( isset($HTTP_GET_VARS[PHPMN_EDIT]) ) ? $HTTP_GET_VARS[PHPMN_EDIT] : $HTTP_POST_VARS[PHPMN_EDIT];
}
else
{
	$edit = "";
}

if ( isset($HTTP_GET_VARS[PHPMN_DO]) || isset($HTTP_POST_VARS[PHPMN_DO]) )
{
	$do = ( isset($HTTP_GET_VARS[PHPMN_DO]) ) ? $HTTP_GET_VARS[PHPMN_DO] : $HTTP_POST_VARS[PHPMN_DO];
}
else
{
	$do = "";
}

if ( isset($HTTP_GET_VARS[PHPMN_TOPICAL]) || isset($HTTP_POST_VARS[PHPMN_TOPICAL]) )
{
	$topical = ( isset($HTTP_GET_VARS[PHPMN_TOPICAL]) ) ? $HTTP_GET_VARS[PHPMN_TOPICAL] : $HTTP_POST_VARS[PHPMN_TOPICAL];
}
else
{
	$topical = "";
}

if ( isset($HTTP_GET_VARS[PHPMN_ID]) || isset($HTTP_POST_VARS[PHPMN_ID]) )
{
	$id = ( isset($HTTP_GET_VARS[PHPMN_ID]) ) ? intval($HTTP_GET_VARS[PHPMN_ID]) : intval($HTTP_POST_VARS[PHPMN_ID]);
}
else
{
	$id = "";
}

if(($edit == "1") AND ($userdata['user_email'] != ""))
{
	$sql = "SELECT newsletter_id, newsletter_title, newsletter_description FROM ". PHPMN_NEWSLETTER_TABLE ." WHERE newsletter_id = $id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER information', '', __LINE__, __FILE__, $sql);
	}
	$entry = array();
	if ( !($entry = $db->sql_fetchrow($result)) )
	{
		message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER information extraction', '', __LINE__, __FILE__, $result);
	}
	if ($topical == "3")
	{
		$topicalview = $lang['L_PHPMN_NOTSUBSCRIBED'] ;
	}
	elseif ($topical == "1")
	{
		$topicalview = $lang['L_PHPMN_HTML'] ;
	}
	elseif ($topical == "2")
	{
		$topicalview = $lang['L_PHPMN_PLAIN'] ;
	}
	$template->assign_block_vars('action', array(
		'ID' => $id,
		'NAME' => $entry['newsletter_title'],
		'DESCRIPTION' => $entry['newsletter_description'],
		'TOPICAL' => $topical,
		'TOPICALVIEW' => $topicalview,
		'USERNAME' => $userdata['username'],
		'USEREMAIL' => $userdata['user_email']
		));
}
elseif(($edit == "2") and (($do == "1") or ($do == "2")) and ($topical != "3"))
{
	if($do == "1")
	{
		$newstatus = "html";
	}
	elseif($do == "2")
	{
		$newstatus = "plain";
	}
	$sql = "UPDATE ". PHPMN_MEMBER_TABLE ." SET members_name = '" . str_replace("\'","''",addslashes($userdata['username'])) . "', members_email = '" . str_replace("\'","''",addslashes($userdata['user_email'])) . "', members_newsid = $id , members_mailpref = '" . str_replace("'", "''", $newstatus) ."' , members_ip = '" . str_replace("'", "''", $userip) ."', members_timestamp = '" . str_replace("'", "''", $userts) ."', members_status = '1' WHERE members_email = '" . str_replace("\'","''",addslashes($userdata['user_email'])) . "' AND members_newsid = $id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER update', '', __LINE__, __FILE__, $sql);
	}
	$now = $lang['L_PHPMN_UPDATE'] ;
	$template->assign_block_vars('done', array('DONE' => "<p align='center'><b>" . $now . "</b></p>"));
}
elseif(($edit == "2") and (($do == "1") or ($do == "2")) and ($topical == "3"))
{
	if($do == "1")
	{
		$newstatus = "html";
	}
	elseif($do == "2")
	{
		$newstatus = "plain";
	}
	$sql = "INSERT INTO ". PHPMN_MEMBER_TABLE ." (members_name, members_email, members_newsid, members_mailpref, members_ip, members_timestamp, members_status) VALUES ('" . str_replace("\'","''",addslashes($userdata['username'])) . "', '" . str_replace("\'","''",addslashes($userdata['user_email'])) . "', $id, '" . str_replace("'", "''", $newstatus) ."', '" . str_replace("'", "''", $userip) ."', '" . str_replace("'", "''", $userts) ."', '1')";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER insert', '', __LINE__, __FILE__, $sql);
	}
	$now = $lang['L_PHPMN_INSERT'] ;
	$template->assign_block_vars('done', array('DONE' => "<p align='center'><b>" . $now . "</b></p>"));
}
elseif(($edit == "2") and ($do == "3"))
{
	$sql = "DELETE FROM ". PHPMN_MEMBER_TABLE ." WHERE members_email = '" . str_replace("\'","''",addslashes($userdata['user_email']))  . "' AND members_newsid = $id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER delete', '', __LINE__, __FILE__, $sql);
	}
	$now = $lang['L_PHPMN_DELETE'] ;
	$template->assign_block_vars('done', array('DONE' => "<p align='center'><b>" . $now . "</b></p>"));

}

$sql = "SELECT * FROM ". PHPMN_MEMBER_TABLE ." WHERE members_email = '" . str_replace("\'","''",addslashes($userdata['user_email'])) . "'";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER status', '', __LINE__, __FILE__, $sql);
}

$subscribe = array();
$status = array();
while ($subscribe = $db->sql_fetchrow($result))
{
	extract($subscribe);
	$status[$members_newsid] = $members_mailpref;
};
$db->sql_freeresult($result);

$sql = "SELECT newsletter_id, newsletter_title, newsletter_description FROM ". PHPMN_NEWSLETTER_TABLE ;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER list', '', __LINE__, __FILE__, $sql);
}

$newsletter = array();
$statusview = array();
while ($newsletter = $db->sql_fetchrow($result))
{
	extract($newsletter);
	$newsid = $newsletter_id;
	if ( !isset($status[$newsid]) || $status[$newsid] == "")
	{
		$status[$newsid] = '3'; 
		$statusview[$newsid] = $lang['L_PHPMN_NOTSUBSCRIBED'] ;
	}
	elseif (isset($status[$newsid]) && $status[$newsid] == "html")
	{
		$status[$newsid] = '1'; 
		$statusview[$newsid] = $lang['L_PHPMN_HTML'] ;
	}
	elseif (isset($status[$newsid]) && $status[$newsid] == "plain")
	{
		$status[$newsid] = '2'; 
		$statusview[$newsid] = $lang['L_PHPMN_PLAIN'] ;
	}
	if ($userdata['user_email'] == "")
	{
		$statusview[$newsid] = sprintf($lang['L_PHPMN_PLEASELOGIN'],"login.$phpEx") ;
	}
	$link = append_sid("phpmn.$phpEx?edit=1&amp;id=" . $newsid . "&amp;topical=" . $status[$newsid]);
	$archive = append_sid("phpmn_archive.$phpEx?id=" . $newsid);
	$template->assign_block_vars('newsletterlist', array(
		'ID' => $newsid,
		'NAME' => $newsletter_title,
		'DESCRIPTION' => $newsletter_description,
		'TOPICAL' => $status[$newsid],
		'TOPICALVIEW' => $statusview[$newsid],
		'LINK' => $link,
		'ARCHIVE' => $archive
		));
};
$db->sql_freeresult($result);

$template->assign_vars(array(
	'L_PHPMN_NAME' => $lang['L_PHPMN_NAME'],
	'L_PHPMN_DESCRIPTION' => $lang['L_PHPMN_DESCRIPTION'],
	'L_PHPMN_STATUS' => $lang['L_PHPMN_STATUS'],
	'L_PHPMN_EDIT' => $lang['L_PHPMN_EDIT'],
	'L_PHPMN_NOTSUBSCRIBED' => $lang['L_PHPMN_NOTSUBSCRIBED'],
	'L_PHPMN_UPDATE' => $lang['L_PHPMN_UPDATE'],
	'L_PHPMN_INSERT' => $lang['L_PHPMN_INSERT'],
	'L_PHPMN_DELETE' => $lang['L_PHPMN_DELETE'],
	'L_PHPMN_ACTION' => $lang['L_PHPMN_ACTION'],
	'L_PHPMN_EMAIL' => $lang['L_PHPMN_EMAIL'],
	'L_PHPMN_TOPICAL' => $lang['L_PHPMN_TOPICAL'],
	'L_PHPMN_HTML' => $lang['L_PHPMN_HTML'],
	'L_PHPMN_PLAIN' => $lang['L_PHPMN_PLAIN'],
	'L_PHPMN_UNSUBSCRIBE' => $lang['L_PHPMN_UNSUBSCRIBE'],
	'L_PHPMN_SEND' => $lang['L_PHPMN_SEND'],
	'L_PHPMN_RESET' => $lang['L_PHPMN_RESET'],
	'EDIT_IMG' => $images['icon_edit'],
	'ARCHIVE_IMG' => $images['icon_archive'],
	'L_EDIT_IMG' => $lang['L_PHPMN_EDIT'],
	'L_ARCHIVE_IMG' => $lang['L_PHPMN_ARCHIVE']
	));

$template->pparse('phpmn');

include($phpbb_root_path . 'includes/phpmn_footer.'.$phpEx); 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 
?>
