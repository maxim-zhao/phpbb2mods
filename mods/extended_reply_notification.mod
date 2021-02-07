##############################################################
## MOD Title: Disply Sender Username in E-mail Notification
## MOD Author: AJP < adamjonpeterson@gmail.com > (Adam) http://www.ajpsreef.com
## MOD Description: Allow's user who enables e-mail notification upon replies to have sender's username 
##		    included in the e-mail.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~1 Minutes
## Files To Edit: includes/functions_post.php
##	          language/lang_english/email/topic_notify.tpl
## Included Files: n/a
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
## This is a mod I made to give me a small preview of who posted.
################################################################
## MOD History:
##
##   2005-10-01 - Version 1.0.0
##      - First tested & stable mod version.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php
#
#-----[ FIND ]------------------------------------------
#     
                  'TOPIC_TITLE' => $topic_title,

#
#-----[ AFTER, ADD ]------------------------------------------
#
		  'POSTER_USERNAME' => $userdata['username'],

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/email/topic_notify.tpl
#
#-----[ FIND ]------------------------------------------
#     
You are receiving this email because you are watching the topic, "{TOPIC_TITLE}" at {SITENAME}. This topic has received a reply since your last visit. You can use the following link to view the replies made, no more notifications will be sent until you visit the topic.

{U_TOPIC}

#
#-----[ REPLACE WITH ]------------------------------------------
#
{POSTER_USERNAME} has just replied to a thread you have subscribed to entitled - "{TOPIC_TITLE}" at {SITENAME}.

This thread is located at:
{U_TOPIC}

There may be other replies also, but you will not receive any more notifications until you visit the board again. 		

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 