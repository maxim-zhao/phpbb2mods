############################################################## 
## MOD Title: Simple_Spam_Links_Breaker 
## MOD Author: polkadotcat < N/A > (N/A) http://alwayskeela.awardspace.com/forum
## MOD Description: Very simple edits which will prevent spammer links
##                  from working on your forum. Used in conjunction 
##                  with your word censors to break:
##                   within posts:
##                    inappropriate links in posts
##                    inappropriate links in www buttons
##                    inappropriate links in signatures
##                   with user profile
##                    inappropriate links in website url
##                    inappropriate links in www buttons (if used)
##                   within memberlist:
##                    inappropriate links in www buttons.
## MOD Version: 1.0.0 
## 
## Installation Level: (Easy) 
## Installation Time: 3 Minutes 
## Files To Edit: memberlist.php
##                viewtopic.php
##                includes/usercp_viewprofile.php
## Included Files: (N/A) 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: This is a way to stop those spam links from working 
## while your admins are away and unable to delete the spam posts before 
## forum users see them. 
## 
## Usually when a spam post with a p0rn link gets posted sometimes your 
## admins may not get to it in time before a user clicks it. Whenever 
## links like this crop up on a forum admins delete the post and implement 
## a word censor to block the site link should it get posted again... 
## this obviously doesn't work though because although the post shows the 
## replacement words, the actual correct link is shown when the mouse is 
## hovered over it... so when it gets clicked, that 14 year old member 
## you have viewing your forum, has just whisked off to see the p0rn 
## site from the link. 
## eg: www.freepor.com would show as www.[spam link].com or whatever
## you have as the replacement word but would still take the user to 
## www.freepor.com 
## 
## The thing was... in topic review the censored spamlink will show 
## correctly as being broken... 
## eg: www.freepor.com became www.[spam link].com and the link itself 
## would be www.[spam link].com 
## 
## What this little mod will do is make the post link look and behave 
## like it does in topic_review, rendering the link totally useless and 
## unworkable to forum users!! And still allows mod/admin to see the 
## actual words used by the poster when edit button on the spam post is 
## clicked... Very helpful if your board is spammed with links a lot, 
## and you get worried about the minors visiting any innappropriate links. 
## This will also break the www button link in the spammers post as well
## as breaking the link in their profile, and in the memberlist.
## 
## Note: This is used in conjunction with your word censors. 
## Demo: http://alwayskeela.awardspace.com/forum/viewtopic.php?p=47#47
## Please note I did not write the actual code, I can't code php to 
## save myself.  All I did was use the existing vanilla phpbb code for
## the topic_review.php page and moved it to other pages to  break 
## links containing censored words.
##
## And YES there are 2 find commands on viewtopic.php before replace
## with... this was to make it easier to find the correct portion of
## code to edit, it is not a typo.
############################################################## 
## MOD History: 
## 
##   2006-11-26 - Version 1.0.0 
##      - this is the first and only version 
##        compatible with phpbb 2.0.21 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

memberlist.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
//
// End session management
//

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

# 
#-----[ FIND ]------------------------------------------ 
# 

		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

		if ( count($orig_word) )
		{
		$www_img = preg_replace($orig_word, $replacement_word, $www_img);
		}
 
#
#-----[ OPEN ]------------------------------------------ 
# 

viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 

	// Replace naughty words

# 
#-----[ FIND ]------------------------------------------ 
# 

		if ($user_sig != '')
		{
			$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $user_sig . '<'), 1, -1));
		}

		$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

		if ($user_sig != '')
		{
			$user_sig = preg_replace($orig_word, $replacement_word, $user_sig);
		}

		$www_img = preg_replace($orig_word, $replacement_word, $www_img);
		$message = preg_replace($orig_word, $replacement_word, $message);

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/usercp_viewprofile.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// Generate page
//
$page_title = $lang['Viewing_profile'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

		if ( count($orig_word) )
		{
		$www = preg_replace($orig_word, $replacement_word, $www);
		$www_img = preg_replace($orig_word, $replacement_word, $www_img);
		}
 
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM