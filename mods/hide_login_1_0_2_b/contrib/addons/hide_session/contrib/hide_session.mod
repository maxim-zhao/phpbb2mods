##############################################################
## MOD Title: Hidden Session addon for Hidden Login
## MOD Author: eviL3 < evil@phpbbmodders.net > (Igor Wiedler) http://phpbbmodders.net
## MOD Description: Allows users to only login hidden for one session.
## MOD Version: 1.0.0
##
## Installation Level: easy
## Installation Time: 3 Minutes
##
## Files To Edit: login.php,
##                viewonline.php,
##                includes/page_header.php,
##                includes/sessions.php,
##                language/lang_english/lang_main.php
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
## This addon extends the MOD to what olympus does.
## It will not override the users setting in the database.
##
##############################################################
## MOD History:
##
##   2006-12-06 - Version 1.0.0
##      - Initial addon release :)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#

ALTER TABLE phpbb_sessions ADD session_hide TINYINT(2) NOT NULL DEFAULT 0;

#
#-----[ OPEN ]------------------------------------------
#
login.php
#
#-----[ FIND ]------------------------------------------
#
					$hidelogin = ( isset($HTTP_POST_VARS['hidelogin']) ) ? 0 : 1;
#
#-----[ REPLACE WITH ]------------------------------------------
#
					$hidelogin = ( isset($HTTP_POST_VARS['hidelogin']) ) ? 1 : 0;
#
#-----[ FIND ]------------------------------------------
#
					$session_id = session_begin
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$admin
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $hidelogin
#
#-----[ FIND ]------------------------------------------
#
					// Reset login tries
					$db->sql_query
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_allow_viewonline = ' . $hidelogin . '
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#

#
#-----[ OPEN ]------------------------------------------
#
viewonline.php
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT u.user_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, s.session_ip
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, s.session_hide
#
#-----[ FIND ]------------------------------------------
#
			if ( !$row['user_allow_viewonline'] )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
!$row['user_allow_viewonline']
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 || $row['session_hide']
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
	$sql = "SELECT u.username,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, s.session_ip
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, s.session_hide
#
#-----[ FIND ]------------------------------------------
#
				if ( $row['user_allow_viewonline'] )
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$row['user_allow_viewonline']
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 && !$row['session_hide']
#
#-----[ OPEN ]------------------------------------------
#
includes/sessions.php
#
#-----[ FIND ]------------------------------------------
#
function session_begin
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $admin = 0
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $hide = 0
#
#-----[ FIND ]------------------------------------------
#
		SET session_user_id = $user_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, session_admin = $admin
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, session_hide = $hide
#
#-----[ FIND ]------------------------------------------
#
			(session_id, session_user_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, session_admin
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, session_hide
#
#-----[ FIND ]------------------------------------------
#
			VALUES ('$session_id'
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $admin
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $hide
#
#-----[ FIND ]------------------------------------------
#
	$userdata['session_admin'] = $admin;
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Hidden Session (Hidden Login) ------------------------------------------------------------
//-- add
	$userdata['session_hide'] = $hide;
//-- fin mod : Hidden Session (Hidden Login) --------------------------------------------------------
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Hidden_login']		= 'Hide';
$lang['Hidden_login_long']	= 'Log me in as hidden';
#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Hidden_login']		= 'Hide (this session)';
$lang['Hidden_login_long']	= 'Log me in as hidden (for this session)';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
