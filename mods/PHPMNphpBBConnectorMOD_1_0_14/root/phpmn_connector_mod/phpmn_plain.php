<?php 
/***************************************************************************
 *                               phpmn_plain.php
 *                            -------------------
 *   begin                : Tuesday, Jul 23, 2006
 *   copyright            : (C) 2005 Martin Truckenbrodt
 *   email                : webmaster@martin-truckenbrodt.com
 *
 *   $Id: phpmn_plain.php,v 1.0.4 $
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
$phpbb_root_path = '../'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 

include($phpbb_root_path . 'includes/phpmn_constants.'.$phpEx); 

$userdata = session_pagestart($user_ip, PAGE_NEWSLETTER); 
init_userprefs($userdata); 

if ( isset($HTTP_GET_VARS[PHPMN_NEWSID]) || isset($HTTP_POST_VARS[PHPMN_NEWSID]) )
{
	$newsid = ( isset($HTTP_GET_VARS[PHPMN_NEWSID]) ) ? intval($HTTP_GET_VARS[PHPMN_NEWSID]) : intval($HTTP_POST_VARS[PHPMN_NEWSID]);
}
else
{
	$newsid = "";
}

$sql = "SELECT * FROM ". PHPMN_ARCHIVE_TABLE ." WHERE archive_id = '$newsid' LIMIT 0,1";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER NEWSLETTER list', '', __LINE__, __FILE__, $sql);
}

if ( !($row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER NEWSLETTER', '', __LINE__, __FILE__, $result);
}

extract($row);

$sql = "SELECT * FROM ". PHPMN_NEWSLETTER_TABLE ." WHERE newsletter_id = '$archive_newsid'";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER ARCHIVE list', '', __LINE__, __FILE__, $sql);
}
if ( !($row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_ERROR, 'Could not query PHPMN NEWSLETTER NEWSLETTER', '', __LINE__, __FILE__, $result);
}

extract($row);

if (isset($userdata['username']))
{
	$body = ereg_replace('MEMBERNAMEHERE', stripslashes(htmlspecialchars($userdata['username'])), nl2br(stripslashes($newsletter_plainemail)));
}
if (isset($archive_body))
{
	$body = ereg_replace('NEWSLETTERBODY', nl2br(stripslashes($archive_body)), stripslashes($body));
}
if (isset($newsletter_title))
{
	$body = ereg_replace('NEWSLETTERTITLEHERE', stripslashes(htmlspecialchars($newsletter_title)), stripslashes($body));
}
if (isset($newsletter_description))
{
	$body = ereg_replace('NEWSLETTERDESCRIPTIONHERE', stripslashes(htmlspecialchars($newsletter_description)), stripslashes($body));
}
if (isset($members_email))
{
	$body = ereg_replace('MEMBEREMAILHERE', stripslashes(htmlspecialchars($members_email)), stripslashes($body));
}
if (isset($members_ip))
{
	$body = ereg_replace('MEMBERIP', stripslashes(htmlspecialchars($members_ip)), stripslashes($body));
}
if (isset($date))
{
	$body = ereg_replace('MEMBERDATE', stripslashes(htmlspecialchars($date)), stripslashes($body));
}
if (isset($sitename))
{
	$body = ereg_replace('SITENAMEHERE', stripslashes(htmlspecialchars($sitename)), stripslashes($body));
}
if (isset($siteurl))
{
	$body = ereg_replace('SITEURLHERE', stripslashes(htmlspecialchars($siteurl)), stripslashes($body));
}
if (isset($final_tip))
{
	$body = ereg_replace('TRACKINGURL', nl2br(stripslashes(htmlspecialchars($final_tip))), stripslashes($body));
}

$body = "<title>" . $archive_subject . "</title>" . $body;

echo $body;


?>
