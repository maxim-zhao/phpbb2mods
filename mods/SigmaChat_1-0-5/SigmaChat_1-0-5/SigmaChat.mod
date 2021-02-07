############################################################## 
## MOD Title:		   Embed SigmaChat Chat Module into phpBB
## MOD Author:		   JAS4Yeshua < jsanborn@digitalstylus.com > (Jason Sanborn) N/A
## MOD Description:    This MOD will allow you to embed the SigmaChat
##                     client into your phpBB Message Board. You must
##                     have a SigmaChat account for this MOD to work.
##                     http://www.sigmachat.com/
##
## MOD Version:		   1.0.5
## 
## Installation Level: Easy
## Installation Time:  10 Minutes
##	
## Files To Edit:
##                     faq.php
##                     admin/index.php
##                     includes/constants.php
##                     includes/page_header.php
##                     language/lang_english/lang_main.php
##                     templates/subSilver/overall_header.tpl
##                     templates/subSilver/chat.tpl
##                       Note: This file is included, but the SigmaChat code has to be added
##
## Included Files:
##                     chat.php
##                     chat.tpl
##                     lang_chat.php
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##
## This MOD requires that you have an account with SigmaChat in order for it to work.
## You can sign up for a free account at http://www.sigmachat.com/
##
## Important Note: You will need to add the code that you are given from the SigmaChat
## administration site to the chat.tpl file in order for the chat to work.
## Look for: <!-- Add Your SigmaChat Code Here --> and add your code after that line.
##
############################################################## 
## MOD History: 
## 
##   2005-07-02 - Version 1.0.5
##   - Fixed redirect to login page in chat.php
##   2005-06-14 - Version 1.0.4
##   - Fixed constants
##   2005-06-14 - Version 1.0.3
##   - Used correct constants for chat.php
##   2005-04-19 - Version 1.0.2
##   - Fixed an error I forgot to remove for Easy MOD installation to work.
##   2005-04-11 - Version 1.0.1
##   - Fixed an error for Easy MOD
##   - Fixed bug that was causing the Chat FAQ not to load
##   2005-03-26 - Version 1.0.0
##	 - Initial Release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ COPY ]------------------------------------------------
#
copy chat.php to chat.php
copy chat.tpl to templates/subSilver/chat.tpl
copy lang_chat.php to language/lang_english/lang_chat.php
#
#-----[ OPEN ]------------------------------------------------
#
faq.php
#
#-----[ FIND ]------------------------------------------------
#
	switch( $HTTP_GET_VARS['mode'] )
	{
		case 'bbcode':
			$lang_file = 'lang_bbcode';
			$l_title = $lang['BBCode_guide'];
			break;
#
#-----[ AFTER, ADD ]------------------------------------------
#

// -- SigmaChat: Begin -----------------------------------------------------
// Add ---------------------------------------------------------------------
		case 'chat':
			$lang_file = 'lang_chat';
			$l_title = $lang['Chat_FAQ'];
			break;
// -- SigmaChat: End -------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------------
#
admin/index.php
#
#-----[ FIND ]------------------------------------------------
#
						case PAGE_FAQ:
							$location = $lang['Viewing_FAQ'];
							$location_url = "index.$phpEx?pane=right";
							break;
#
#-----[ AFTER, ADD ]------------------------------------------
#

// -- Embed SigmaChat: Begin -----------------------------------------------
// Add ---------------------------------------------------------------------
						case PAGE_CHAT:
							$location = $lang['Chat'];
							$location_url = "chat.$phpEx?pane=right";
							break;
// -- Embed SigmaChat: End -------------------------------------------------

#
#-----[ FIND ]------------------------------------------------
#
					case PAGE_FAQ:
						$location = $lang['Viewing_FAQ'];
						$location_url = "index.$phpEx?pane=right";
						break;
#
#-----[ AFTER, ADD ]------------------------------------------
#

// -- Embed SigmaChat: Begin -----------------------------------------------
// Add ---------------------------------------------------------------------
					case PAGE_CHAT:
						$location = $lang['Chat'];
						$location_url = "chat.$phpEx?pane=right";
						break;
// -- Embed SigmaChat: End -------------------------------------------------

#
#-----[ OPEN ]------------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------------
#
define('PAGE_GROUPCP', -11);
#
#-----[ AFTER, ADD ]------------------------------------------
#

// -- Embed SigmaChat: Begin -----------------------------------------------
// Add ---------------------------------------------------------------------
define('PAGE_CHAT', -1185);
// -- Embed SigmaChat: End -------------------------------------------------

#
#-----[ OPEN ]------------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------------
#
	'L_USERGROUPS' => $lang['Usergroups'],
#
#-----[ AFTER, ADD ]------------------------------------------
#

// -- Embed SigmaChat: Begin -----------------------------------------------
// Add ---------------------------------------------------------------------
	'L_CHAT' => $lang['Chat'],
// -- Embed SigmaChat: End -------------------------------------------------

#
#-----[ FIND ]------------------------------------------------
#
	'U_GROUP_CP' => append_sid('groupcp.'.$phpEx),
#
#-----[ AFTER, ADD ]------------------------------------------
#

// -- Embed SigmaChat: Begin -----------------------------------------------
// Add ---------------------------------------------------------------------
	'U_CHAT' => append_sid('chat.'.$phpEx),
// -- Embed SigmaChat: End -------------------------------------------------

#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------------
#
$lang['BBCode_guide'] = 'BBCode Guide';
#
#-----[ AFTER, ADD ]------------------------------------------
#

// -- Embed SigmaChat: Begin -----------------------------------------------
// Add ---------------------------------------------------------------------
$lang['Chat'] = 'Chat';
$lang['Chat_FAQ'] = 'Chat FAQ';
// -- Embed SigmaChat: End -------------------------------------------------

#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------------
#
# Note: This is a partial match. The actual line is much longer.
#
				<table cellspacing="0" cellpadding="2" border="0">
					<tr> 
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a></span>
#
#-----[ IN-LINE FIND ]---------------------------------------- 
#
{L_USERGROUPS}</a>&nbsp;
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------- 
#
 &nbsp;<a href="{U_CHAT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_CHAT}" hspace="3" />{L_CHAT}</a>&nbsp;
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
