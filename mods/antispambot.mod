##############################################################
## MOD Title: Anti spam-bots
## MOD Author: Weird Alexis < alexisbietti@gmail.com > (Alexis BIETTI) http://www.artefact.zik.mu/
## MOD Description: This mod hides e-mail addresses of members to spam-bots and anonymous users.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: /groupcp.php, /memberlist.php, /viewtopic.php, /includes/usercp_viewprofile.php
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: This mod was tested on phpBB version 2.0.4 *only*.
## 
##############################################################
## MOD History:
##
##   2004-10-24 - Version 1.0.0
##      - Initial version. Hides e-mail in topics, member list, profiles and groups.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
 /groupcp.php
 
#
#-----[ FIND ]------------------------------------------
#
	if ( !empty($row['user_viewemail']) || $group_mod )
 
#
#-----[ REPLACE WITH ]------------------------------------------
#
	if ( empty($userdata['user_id']) || ($userdata['user_id'] == ANONYMOUS) )
	{
		if ( !empty($row['user_viewemail']) )
		{
			$email_img = '<img src="' . $images['icon_email'] . '" alt="' . $lang['Hidden_email'] . '" title="' . $lang['Hidden_email'] . '" border="0" />';
		}
		else
		{
			$email_img = '&nbsp;';
		}
		$email = '&nbsp;';
	}
	else if ( !empty($row['user_viewemail']) || $group_mod )

#
#-----[ OPEN ]------------------------------------------
#
/memberlist.php

#
#-----[ FIND ]------------------------------------------
#
		if ( !empty($row['user_viewemail']) || $userdata['user_level'] == ADMIN )
 
#
#-----[ REPLACE WITH ]------------------------------------------
#
		if ( empty($userdata['user_id']) || ($userdata['user_id'] == ANONYMOUS) )
		{
			if ( !empty($row['user_viewemail']) )
			{
				$email_img = '<img src="' . $images['icon_email'] . '" alt="' . $lang['Hidden_email'] . '" title="' . $lang['Hidden_email'] . '" border="0" />';
			}
			else
			{
				$email_img = '&nbsp;';
			}
			$email = '&nbsp;';
		}
		else if ( !empty($row['user_viewemail']) || $userdata['user_level'] == ADMIN )

#
#-----[ OPEN ]------------------------------------------
#
/viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
		if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )

#
#-----[ REPLACE WITH ]------------------------------------------
#
		if ( empty($userdata['user_id']) || ($userdata['user_id'] == ANONYMOUS) )
		{
			if ( !empty($postrow[$i]['user_viewemail']) )
			{
				$email_img = '<img src="' . $images['icon_email'] . '" alt="' . $lang['Hidden_email'] . '" title="' . $lang['Hidden_email'] . '" border="0" />';
			}
			else
			{
				$email_img = '&nbsp;';
			}
			$email = '&nbsp;';
		}
		else if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )

#
#-----[ OPEN ]------------------------------------------
#
/includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#
if ( !empty($profiledata['user_viewemail']) || $userdata['user_level'] == ADMIN )

#
#-----[ REPLACE WITH ]------------------------------------------
#
if ( empty($userdata['user_id']) || ($userdata['user_id'] == ANONYMOUS) )
{
	if ( !empty($profiledata['user_viewemail']) )
	{
		$email_img = '<img src="' . $images['icon_email'] . '" alt="' . $lang['Hidden_email'] . '" title="' . $lang['Hidden_email'] . '" border="0" />';
	}
	else
	{
		$email_img = '&nbsp;';
	}
	$email = '&nbsp;';
}
else if ( !empty($profiledata['user_viewemail']) || $userdata['user_level'] == ADMIN )

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
# 
# EoM 