<?php
ini_set("max_execution_time", 0);
/***************************************************************************
 *                               resync.php
 *                            -------------------
 *   Version              : 0.0.2
 *   began                : Wednesday, November 19th, 2003
 *   last updated         : Wednesday, May 26th, 2004
 *   email                : Support@FFTrealm.com
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   copyright (C) 2003-2004  NoahK (with help from Zarath)
 *
 *   This program is free software; you can redistribute it and/or
 *   modify it under the terms of the GNU General Public License
 *   as published by the Free Software Foundation; either version 2
 *   of the License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   http://www.gnu.org/copyleft/gpl.html
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);


//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

if ( !$userdata['session_logged_in'] )
{
	$redirect = "resync.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

function count_words($str) { 
	return substr_count($str, ' ') + 1; 
}

function Remove($string, $sep1, $sep2)
{
  $string = strrev(substr($string, 0, strpos($string, $sep2)));
  $string = strrev(substr($string,0,strpos($string, strrev($sep1))));
  return $string;
}

$name = $userdata['username'];
if ($_REQUEST['action'] == "sync") {
	$user = $userdata['user_id'];
	$sql2 = "SELECT user_id, username FROM " . USERS_TABLE . " WHERE user_id='$user'";
	if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, 'Fatal Error getting user_id from the user table.'); }
    $j = 0; 
    while ( $words3 = $db->sql_fetchrow($result2) ) 
    { 
        $j++; 
		$auser_id = $words3['user_id'];
		// Joins phpbb_posts_text and phpbb_posts together to grab the users id and all the post text.
		$sql = "SELECT a.post_text,b.post_id,b.poster_id FROM " . POSTS_TEXT_TABLE . " a, " . POSTS_TABLE . " b WHERE b.post_id=a.post_id and b.poster_id=$auser_id";
	    if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, 'Fatal Error joining posts and post_text tables.'); }
    $x = 0; 
    while ( $words = $db->sql_fetchrow($result) ) 
    { 
         $x++; 
			$word_post = $words['post_text'];
			
			// Removes [QUOTE] and [/QUOTE] from being counted
			$text = Remove($word_post,"[quote:","[/quote:");
			$word_post = str_replace($text, "", $word_post);
			
			$total_words = $total_words . $word_post; // $total_words contains all the text a user has posted
		}
	
		$total_update = count_words($total_words); // Concerts $total_words from text into a number (word count)
		$sql3 = "UPDATE " . USERS_TABLE . " SET user_wordcount='$total_update' WHERE user_id='$auser_id'";
		$result3 = $db->sql_query($sql3);	
		$total_words = 0;
		$total_update = 0;
    }
	message_die(GENERAL_MESSAGE, 'Finished updating '.$name.'\'s word count.');
} else {
	message_die(GENERAL_MESSAGE, 'This will re-sync the databse with your proper word count.<br>This will take approx. 15 seconds if you have about least 2000 posts.<br>More than 2000 posts may take upwards of a 30 seconds to a full minute.<br> Please be patient.<br><br><b><center><a href=resync.php?action=sync>CLICK TO RESYNC WORD COUNT</a></center></b>');
}
	message_die(GENERAL_MESSAGE, 'Finished updating '.$name.'\'s word count.');
?>