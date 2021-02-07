##############################################################
## MOD Title: Confirm Mark Read
## MOD Author: Karlprof! < karlprof@gmail.com > (Karl) http://karlprof.ecwhost.com/currentproject
## MOD Description: Adds a confirmation page to the process of marking all forums or all topics read.
## MOD Version: 1.0.1b
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: index.php,
##      viewtopic.php,
##      lang_main.php
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2
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
##      This MOD should install perfectly with EasyMOD.
##
##############################################################
## MOD History:
##
##   2005-08-03 - Version 1.0.1b
##      - Typo meant it threw an error on index.php
##
##   2005-08-03 - Version 1.0.1a
##      - Corrected small lang_main.php glitch
##      - I missed a few words of hardcoded English
##
##   2005-08-03 - Version 1.0.1
##      - "Confirm Mark Read" submitted for revalidation:
##      - ... Removed hardcoded English in favour of $lang
##      - ... Used $HTTP_GET_VARS in favour of $_GET
##      - ... Tabulation is as good as I can get it without over-complicating things
##
##   2005-08-02 - Version 1.0.0
##      - "Confirm Mark Read" released to the public
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
index.php

#
#-----[ FIND ]------------------------------------------
#
if( $userdata['session_logged_in'] )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
            if ( $HTTP_GET_VARS['confirm_mark'] != 'true' )
            {
	    	    $message = $lang['Confirm_mark_all_forums'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ') . '<br /><a href="' . append_sid("index.$phpEx?mark=forums&confirm_mark=true") . '">' . $lang['Mark_all_forums'] . '</a>';
	    	    message_die(GENERAL_MESSAGE, $message);
	    }
	    else
	    {     

#
#-----[ FIND ]------------------------------------------
#
message_die(GENERAL_MESSAGE, $message);

#
#-----[ AFTER, ADD ]------------------------------------------
#
	    }

#
#-----[ OPEN ]------------------------------------------
#
viewforum.php

#
#-----[ FIND ]------------------------------------------
#
if ( $userdata['session_logged_in'] )

#
#-----[ BEFORE, ADD ]------------------------------------------
#

	if ( $HTTP_GET_VARS['confirm_mark'] != 'true' )
	{
		$message = $lang['Confirm_mark_all_topics'] . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a> ') . '<br /><a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&mark=topics&confirm_mark=true") . '">' . $lang['Mark_all_topics'] . '</a>';
		message_die(GENERAL_MESSAGE, $message);
	}
	else
	{

#
#-----[ FIND ]------------------------------------------
#
$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : '';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Mark_all_forums'] = 'Mark all forums read';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Confirm_mark_all_forums'] = 'Are you sure you want to mark all forums read?';

#
#-----[ FIND ]------------------------------------------
#
$lang['Mark_all_topics'] = 'Mark all topics read';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Confirm_mark_all_topics'] = 'Are you sure you want to mark all topics in this forum read?';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM