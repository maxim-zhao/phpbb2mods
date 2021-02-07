<?php
/***************************************************************************
 *                               db_update.php
 *                            -------------------
 *
 *   copyright            : ©2003 Freakin' Booty ;-P & Antony Bailey
 *   project              : http://sourceforge.net/projects/dbgenerator
 *   Website              : http://freakingbooty.no-ip.com/ & http://www.rapiddr3am.net
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
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//


if( !$userdata['session_logged_in'] )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . append_sid("login.$phpEx?redirect=db_update.$phpEx", true));
	exit;
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, 'You are not authorised to access this page');
}


$page_title = 'Updating the database';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

echo '<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">';
echo '<tr><th>Updating the database</th></tr><tr><td><span class="genmed"><ul type="circle">';


$sql = "CREATE TABLE " . $table_prefix . "user_board_links (
user_id MEDIUMINT( 8 ) NOT NULL ,
board_link MEDIUMINT( 8 ) NOT NULL ,
board_sort MEDIUMINT( 8 ) NOT NULL
)";
if( !$result = $db->sql_query ($sql) )
{
	$error = $db->sql_error();

	echo '<li>' . $sql . ' +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
}
else
{
	echo '<li>' . $sql . ' +++ <font color="#00AA00"><b>Successfull</b></font></li><br />';
}

$sql = "SELECT user_id, board_links FROM " . $table_prefix . "users
	WHERE board_links <> ''
	ORDER BY user_id";
if( !$result = $db->sql_query ($sql) )
{
	$error = $db->sql_error();

	echo '<li>' . $sql . ' +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
}
else
{
	while ($row = $db->sql_fetchrow($result) )
	{
		$board_links = $row['board_links'];
		$user = $row['user_id'];
		$user_board_links = explode(',', $board_links);

		$j = 0;
		for ( $i = 0; $i < count($user_board_links); $i++)
		{
			if ( $user_board_links[$i] != '' )
			{
				$sql2 = "SELECT board_link FROM " . $table_prefix . "user_board_links
					 WHERE user_id = $user
					 AND board_link = ".$user_board_links[$i];
				if( !$result2 = $db->sql_query ($sql2) )
				{
					$error = $db->sql_error();

					echo '<li>' . $sql2 . ' +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
				}
				else
				{
					$j += 10;
					$existing_link_check = $db->sql_numrows($result2);
					$db->sql_freeresult($result2);
					if ( $existing_link_check == 0 )
					{
						$sql3 = "INSERT INTO " . $table_prefix . "user_board_links
							 (user_id, board_link, board_sort) 
							 VALUES ($user, ".$user_board_links[$i].", $j)";
						if( !$result3 = $db->sql_query ($sql3) )
						{
							$error = $db->sql_error();

							echo '<li>' . $sql3 . ' +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
						}
					}
				}
			}
		}
		echo '<li>Converting Links for user id ' . $user . ' +++ <font color="#00AA00"><b>Finished</b></font></li><br />';

		$sql4 = "SELECT board_link FROM " . $table_prefix . "user_board_links
			 WHERE user_id = $user
			 ORDER BY board_sort";
		if( !$result4 = $db->sql_query ($sql4) )
		{
			$error = $db->sql_error();

			echo '<li>' . $sql4 . ' +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
		}
		else
		{
			$j = 0;
			while ( $row4 = $db->sql_fetchrow($result4) )
			{
				$board_correct_sort = $row4['board_link'];
				$j += 10;
				$sql5 = "UPDATE " . $table_prefix . "user_board_links
					 SET board_sort = $j
					 WHERE user_id = $user
					 AND board_link = $board_correct_sort";
				if( !$result5 = $db->sql_query ($sql5) )
				{
					$error = $db->sql_error();

					echo '<li>' . $sql5 . ' +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
				}
			}
			echo '<li>Resorting Links for user id' . $user . ' +++ <font color="#00AA00"><b>Finished</b></font></li><br />';
		}
	}
}

$sql = array();
$sql[] = "ALTER TABLE " . $table_prefix . "users DROP board_links";
$sql[] = "ALTER TABLE " . $table_prefix . "users DROP board_sort";

for( $i = 0; $i < count($sql); $i++ )
{
	if( !$result = $db->sql_query ($sql[$i]) )
	{
		$error = $db->sql_error();

		echo '<li>' . $sql[$i] . ' +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
	}
	else
	{
		echo '<li>' . $sql[$i] . ' +++ <font color="#00AA00"><b>Successfull</b></font></li><br />';
	}
}

echo '</ul></span></td></tr><tr><td class="catBottom" height="28">&nbsp;</td></tr>';

echo '<tr><th>End</th></tr><tr><td><span class="genmed">Update is now finished. Please be sure to delete this file now.<br />If you have run into any errors, please visit the <a href="http://www.phpbbsupport.co.uk" target="_phpbbsupport">phpBBSupport.co.uk</a> and ask someone for help.</span></td></tr>';
echo '<tr><td class="catBottom" height="28" align="center"><span class="genmed"><a href="' . append_sid("index.$phpEx") . '">Have a nice day</a></span></td></table>';

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>