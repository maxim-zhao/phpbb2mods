<?php
/***************************************************************************
                             add_topic_view.php
                             -------------------
    begin                : Wednesday Mar. 07, 2007
    copyright            : (C) 2007 Wicher
    email                : ---

    $Id: add_topic_view.php,v 1.1.0 2007/03/07 19:11:04 Wicher Exp $

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


if ( isset($HTTP_POST_VARS['site']) || isset($HTTP_GET_VARS['site']))
{
	$site = ( isset($HTTP_POST_VARS['site']) ) ? urlencode($HTTP_POST_VARS['site']) : urlencode($HTTP_GET_VARS['site']);
	$topic_id = ( isset($HTTP_POST_VARS[POST_TOPIC_URL]) ) ? intval($HTTP_POST_VARS[POST_TOPIC_URL]) : intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
if (($site == '') || ($topic_id == ''))
{
	redirect(append_sid("index.$phpEx", true));
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

//
// Update the topic view counter
//
$sql = "UPDATE " . TOPICS_TABLE . "
	SET topic_views = topic_views + 1
	WHERE topic_id = ".$topic_id;
if ( !$db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not update topic views.", '', __LINE__, __FILE__, $sql);
}

$url = htmlspecialchars(urldecode($site));
redirect_out($url, true);


?>