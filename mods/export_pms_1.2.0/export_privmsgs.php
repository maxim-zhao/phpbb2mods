<?php
/***************************************************************************
                             export_privmsgs.php
                             -------------------
    begin                : Fri March 25 2005
    copyright            : (C) 2005 OlivierW
    email                : N/A

    $Id: $

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
$userdata = session_pagestart($user_ip, PAGE_PRIVMSGS);
init_userprefs($userdata);
//
// End session management
//

if ( !$userdata['session_logged_in'] )
{
	redirect(append_sid("login.$phpEx?redirect=privmsg.$phpEx&folder=inbox", true));
}

//
// We are searching for all the PMs sent or received by the logged user
// Excluded PMs :
//		- the guy who sent the PM isn't the logged user and the status of the PM is "sent" (means the PM is in the sender's Outbox)
//		- the guy who sent the PM is the logged user and the status of the PM is "read" (means the PM is in the addressee's Inbox)
//
$sql = "SELECT u.username AS username_1, u.user_id AS user_id_1, u2.username AS username_2, u2.user_id AS user_id_2, pm.privmsgs_subject, pmt.privmsgs_text, pm.privmsgs_type, pm.privmsgs_from_userid, pm.privmsgs_to_userid, pm.privmsgs_date
	FROM " . PRIVMSGS_TABLE . " pm, " . PRIVMSGS_TEXT_TABLE . " pmt, " . USERS_TABLE . " u, " . USERS_TABLE . " u2
	WHERE pmt.privmsgs_text_id = pm.privmsgs_id
		AND (u.user_id = " . $userdata['user_id'] . " OR u2.user_id = " . $userdata['user_id'] . ")
		AND u.user_id = pm.privmsgs_from_userid
		AND u2.user_id = pm.privmsgs_to_userid
		AND NOT(pm.privmsgs_from_userid <> " . $userdata['user_id'] . " AND pm.privmsgs_type = " . PRIVMSGS_SENT_MAIL . ")
		AND NOT(pm.privmsgs_from_userid = " . $userdata['user_id'] . " AND pm.privmsgs_type = " . PRIVMSGS_READ_MAIL . ")
	ORDER BY pm.privmsgs_type, pm.privmsgs_date DESC";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query private message post information', '', __LINE__, __FILE__, $sql);
}


// headers so the file won't stay in the cache
header("Expires: Mon, 1 Jan 1996 01:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// download the file
header('Content-Type: text/xml');

// file name to download
header("Content-Disposition: attachment; filename=\"privatemessages-" . $userdata['username'] . "-" . date("Y-m-d") . ".xml\"");

// we're writing the header of the XML file
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
if ($config['cookie_secure']) {
	echo "<!-- " . $board_config['site_desc'] . "; https://" . $board_config['server_name'] . " -->\n";
}
else {
	echo "<!-- " . $board_config['site_desc'] . "; http://" . $board_config['server_name'] . " -->\n";
}
echo "<!-- Private Message Dump for User " . $userdata['username'] . "; " . date("Y-m-d H:i") . " -->\n";
echo "<privatemessages>\n";

$current_folder = null;
$b_start_loop = true;

// is there any PMs ?
if ( $db->sql_numrows($result) > 0 )
{
	// we're travelling through the results and we're writing each PM
	while( $row = $db->sql_fetchrow($result) )
	{
		// if it's a new folder, we close the previous one and we open a new one
		if ( $current_folder != $row['privmsgs_type'] )
		{
			$current_folder = $row['privmsgs_type'];
			// if it's the first time we're in the loop, we don't close the previous folder because it doesn't exist
			if ( $b_start_loop == false )
			{
				echo "</folder>\n";
			}
			else
			{
				$b_start_loop = false;
			}
			echo "<folder name=\"". $row['privmsgs_type'] . "\">\n";
		}

		echo "	<privatemessage>\n";
		echo "		<datestamp>" . date("Y-m-d H:i", $row['privmsgs_date']) . "</datestamp>\n";
		echo "		<title><![CDATA[" . $row['privmsgs_subject'] . "]]></title>\n";
		echo "		<fromuser>" . $row['username_1'] . "</fromuser>\n";
		echo "		<touser>" . $row['username_2'] . "</touser>\n";
		echo "		<message><![CDATA[";
		echo $row['privmsgs_text'];
		echo "]]>\n";
		echo "		</message>\n";
		echo "	</privatemessage>\n";
	}
	echo "</folder>\n";
}
echo "</privatemessages>\n";

?>
