##############################################################
## MOD Title: Redirect anonymous users to login
## MOD Author: StefanKausL < stefan@kuhlins.de > (Stefan Kuhlins) http://kuhlins.de/
## MOD Description: This very simple MOD redirects anonymous
## users to the login page instead of showing member, groups,
## or profile pages. That way anonymous users can't see
## registered user's data.
## MOD Version: 1.0.8
##
## Installation Level:	Easy
## Installation Time:	1 Minute
## Files To Edit: groupcp.php, memberlist.php, profile.php, viewonline.php
##
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
## To make this MOD work, the forums must be set to registered users only.
## Go to the "Forum Permissions Control" section and
## set "View", "Read", "Post", etc. to "REG".
## This stops guests from viewing, reading, and posting.
##
## Search engines did not see posts that are for registered users only,
## but you can set some forums open to all users including search engines.
## Go to "Forum Permissions Control" in the admin section and
## set "View" and "Read" to "ALL".
##
## Intentionally I didn't put the redirect on my index and search page,
## because I want some visible forums and topics,
## especially for the rules everybody should read before registering.
## But the code will work in the files index.php and search.php as well.
## Just insert the redirect code the same way as for memberlist.php and
## viewonline.php.
##
## CAUTION:
## Do not put the redirect code after init_userprefs($userdata); in
## profile.php, because that way nobody can register!
##
##############################################################
## MOD History:
##
##   2005-05-21 - Version 1.0.8
##	  - Security risk fixed: use values instead of QUERY_STRING for redirect.
##	    Thanks to pip and Shanana for pointing out this security risk.
##	  - Bug fix: & instead of &amp; for session id in URLs.
##
##   2005-04-10 - Version 1.0.7
##	  - After log on redirect to the desired page instead of the index.
##
##   2005-04-02 - Version 1.0.6
##	  - Stopped access to groups with group id.
##
##   2005-04-02 - Version 1.0.5
##	  - Now, the anonymous redirect is included later on in group_cp.php.
##	    Thanks to blackpeter for this improvement.
##
##   2005-03-25 - Version 1.0.4
##	  - Reload because the old MOD link did not work.
##
##   2004-08-18 - Version 1.0.3
##	  - Updated for phpBB 2.0.10 (only the number of tabs was changed)
##	  - Added notes
##
##   2004-07-28 - Version 1.0.2
##	  - Now it follows phpBB's coding standards.
##
##   2004-07-12 - Version 1.0.1
##	  - Bug fix: Anonymous users could not register.
##	  - Improvement: Anonymous users should not see who's online.
##
##   2004-07-09 - Version 1.0.0
##	  - Initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]---------------------------------------------
#
groupcp.php

#
#-----[ FIND ]---------------------------------------------
#
	if ( isset($HTTP_GET_VARS['validate']) )
	{
		if ( !$userdata['session_logged_in'] )
		{
			redirect(append_sid("login.$phpEx?redirect=groupcp.$phpEx&" . POST_GROUPS_URL . "=$group_id", true));
		}
	}
#
#-----[ REPLACE WITH ]------------------------------------------
#
	if ( !$userdata['session_logged_in'] )
	{
		redirect(append_sid("login.$phpEx?redirect=groupcp.$phpEx&" . POST_GROUPS_URL . "=$group_id", true));
	}

#
#-----[ FIND ]---------------------------------------------
#
			$s_member_groups = '<select name="' . POST_GROUPS_URL . '">' . $s_member_groups_opt . "</select>";
		}
	}

#
#-----[ AFTER, ADD ]---------------------------------------------
#
	else
	{
		redirect(append_sid("login.$phpEx?redirect=groupcp.$phpEx", true));
	}

#
#-----[ OPEN ]---------------------------------------------
#
memberlist.php

#
#-----[ FIND ]---------------------------------------------
#
init_userprefs($userdata);

#
#-----[ AFTER, ADD ]---------------------------------------------
#
if ($userdata['user_id'] == ANONYMOUS)
{
	redirect(append_sid("login.$phpEx?redirect=memberlist.$phpEx", true));
}

#
#-----[ OPEN ]---------------------------------------------
#
profile.php

#
#-----[ FIND ]---------------------------------------------
#
	if ( $mode == 'viewprofile' )
	{

#
#-----[ AFTER, ADD ]---------------------------------------------
#
		if ($userdata['user_id'] == ANONYMOUS)
		{
			redirect(append_sid("login.$phpEx?redirect=profile.$phpEx&mode=viewprofile&" . POST_USERS_URL . '=' . intval($HTTP_GET_VARS[POST_USERS_URL]), true));
		}

#
#-----[ OPEN ]---------------------------------------------
#
viewonline.php

#
#-----[ FIND ]---------------------------------------------
#
init_userprefs($userdata);

#
#-----[ AFTER, ADD ]---------------------------------------------
#
if ($userdata['user_id'] == ANONYMOUS)
{
	redirect(append_sid("login.$phpEx?redirect=viewonline.$phpEx", true));
}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
