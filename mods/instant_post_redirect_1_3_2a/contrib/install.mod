##############################################################
## MOD Title: Instant Post Redirect
## MOD Author: eviL3 < evil@phpbbmodders.net > (Igor Wiedler) http://phpbbmodders.net
## MOD Author: Afterlife(69) < afterlife_69@hotmail.com > (Dean Newman) http://www.ugboards.com/
## MOD Description: Removes the redirect after posting a message, Private message or voting.
## MOD Version: 1.3.2a
##
## Installation Level: Easy
## Installation Time: 2 Minutes
##
## Files To Edit: posting.php,
##                privmsg.php
##
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
## 
## Faster :)
##
##############################################################
## MOD History:
##
##	2006-04-23 - Version 1.0.0
##		- Released modification.
##
##	2006-05-14 - Version 1.1.0
##		- Fixed template and resubmitted.
##
##	2006-08-17 - Version 1.2.0
##		- MOD overtaken by eviL3
##      - Fixed, so it actually works...
##
##	2006-08-17 - Version 1.2.1
##      - Fixed, deleting posts/topics. Thanks kber.
##
##	2006-08-30 - Version 1.2.2
##      - Added redirect() for Editing posts.
##
##	2006-10-10 - Version 1.3.0
##      - Added redirect for PMs on a request by sakkiotto
##
##	2006-11-16 - Version 1.3.1
##      - Added attach MOD ie fix
##      - Cleaned / commented a little
##
##  2006-11-20 - Version 1.3.2
##      - Little stuff
##      - I like MODX
##
##  2006-12-27 - Version 1.3.2a
##      - Added license.txt
##      - Added authors notes to update files
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 

#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
	if ( !empty($HTTP_POST_VARS['vote_id']) )
#
#-----[ FIND ]------------------------------------------
#
		$template->assign_vars(array(
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$template
#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
/*
#
#-----[ FIND ]------------------------------------------
#
		message_die(GENERAL_MESSAGE, $message);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$message);
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
*/
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Instant Post Redirect ------------------------------------------------------------
//-- add
		redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));
//-- fin mod : Instant Post Redirect --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
		if ( $mode != 'editpost' )
#
#-----[ FIND ]------------------------------------------
#
			setcookie($board_config['cookie_name']
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Instant Post Redirect ------------------------------------------------------------
//-- add
			redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id", true) . '#' . $post_id);
//-- fin mod : Instant Post Redirect --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
		}
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Instant Post Redirect ------------------------------------------------------------
//-- add
		elseif ( $mode == 'editpost' )
		{
		  redirect(append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=$post_id", true) . '#' . $post_id);
		}
//-- fin mod : Instant Post Redirect --------------------------------------------------------
#
#-----[ OPEN ]------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------
#
				$emailer->reset();
#
#-----[ FIND ]------------------------------------------
#
		$template->assign_vars(array(
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$template
#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
/*
#
#-----[ FIND ]------------------------------------------
#
		message_die(GENERAL_MESSAGE, $msg);
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$msg);
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
*/
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Instant Post Redirect ------------------------------------------------------------
//-- add
		redirect(append_sid("privmsg.$phpEx?folder=inbox"));
//-- fin mod : Instant Post Redirect --------------------------------------------------------
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
