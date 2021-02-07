############################################################## 
## MOD Title: Moderate Own Topics Update from 1.0.1 to 1.0.2
## MOD Author: Kinfule < kinfule@lycos.es > (Javier B) http://kinfule.tk 
## MOD Description: This are the instructions to update from 1.0.1 to 1.0.2
## MOD Version: 1.0.0 
## 
## Installation Level:  Easy
## Installation Time:  5 Minutes 
## Files To Edit: 2 
##						- viewtopic.php
##						- modcp.php
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
############################################################## 
## MOD History: 
## 
##   2006-05-10 - Version 1.0.0 
##      - First release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
# 
#-----[ OPEN ]------------------------------------------ 
#
viewtopic.php
# 
#-----[ FIND ]------------------------------------------ 
#
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;start=" . $start . "&amp;sid=" . $userdata['session_id'] . '">', '</a>');

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	if ( $is_auth['auth_mod'])
	{

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	}

# 
#-----[ OPEN ]------------------------------------------ 
#
modcp.php

# 
#-----[ FIND ]------------------------------------------ 
#
if ( !$is_auth['auth_mod'] && ( !$is_auth['auth_tmod'] && $topic_row['topic_poster'] != $userdata['user_id'] ) )

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
if( !$is_auth['auth_mod'] )

#-----[ FIND ]------------------------------------------ 
#
message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	if ( !($is_auth['auth_tmod'] && $topic_id != '' && $topic_row['topic_poster'] == $userdata['user_id']) )
	{

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	}

# 
#-----[ FIND ]------------------------------------------ 
#
if (!$is_auth['auth_delete'] && ( !$is_auth['auth_tmod'] && $topic_row['topic_poster'] != $userdata['user_id'] ))	

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
if (!$is_auth['auth_delete'])

# 
#-----[ FIND ]------------------------------------------ 
#
			message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_auth_delete'], $is_auth['auth_delete_type']));

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
			if ( !($is_auth['auth_tmod'] && $topic_id != '' && $topic_row['topic_poster'] == $userdata['user_id']) )
			{

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
			}

# 
#-----[ FIND ]------------------------------------------ 
#
	default:

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		if ( !$is_auth['auth_mod'])
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
		}

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 