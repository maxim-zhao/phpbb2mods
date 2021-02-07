##############################################################
## MOD Title: Disable PM links
## MOD Author: DeadMeatGF < stephen.giller@derby-college.ac.uk > (Steve Giller) n/a
## MOD Description: This disables the PM links when PM is switched off in the Admin CP.
## This prevents the "Page cannot be displayed" error on boards affected by this issue.
## The updateds version also removes the links to the PM pages from the page header.
##
## MOD Version: 1.1.2
##
## Installation Level: easy
## Installation Time: ~5 Minutes
## Files To Edit: groupcp.php; memberlist.php; privmsg.php; viewtopic.php; includes/usercp_viewprofile.php; templates/subSilver/subSilver.cfg; /templates/subSilver/overall_header.tpl
## Included Files: /templates/subSilver/images/lang_english/icon_pm_disabled.gif
## Generator: MOD Studio.net [Beta 3c 1.2.1306.29431]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: You'll need to generate an icon_pm_disabled.gif for any themes you use other than subSilver
## To use the supplied icon_pm_disabled.gif copy it into /templates/subSilver/images/lang_english/
##############################################################
## MOD History:
##
##   2004-11-11 - Version 1.1.2
##      - Updated to comply with MOD template. Removed hard-coded text and replaced with new variable as advised by the MOD validation team.
##      - Added new code to remove PM links from overall_header.
##      - Added code to copy the greyed out PM image.
##      - Please report any bugs or suggestions via the phpBB forums.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]---------------------------
#

copy icon_pm_disabled.gif to templates/subSilver/images/lang_english/icon_pm_disabled.gif

#
#-----[ OPEN ]------------------------------------------
#
groupcp.php

#
#-----[ FIND ]------------------------------------------
#
$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
// Begin Disable_PM_Link mod
if ( empty($board_config['privmsg_disable']) )
{

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
else
{
	$pm_img = '<img src="' . $images['icon_pm_disabled'] . '" alt="' . $lang['Send_private_message_disabled'] . '" title="' . $lang['Send_private_message_disabled'] . '" border="0" />';
	$pm = '';
}
// End Disable_PM_Link_Mod

#
#-----[ OPEN ]------------------------------------------
#
memberlist.php

#
#-----[ FIND ]------------------------------------------
#
$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
// Begin Disable_PM_Link mod
if ( empty($board_config['privmsg_disable']) )
{

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
else
{
	$pm_img = '<img src="' . $images['icon_pm_disabled'] . '" alt="' . $lang['Send_private_message_disabled'] . '" title="' . $lang['Send_private_message_disabled'] . '" border="0" />';
	$pm = '';
}
// End Disable_PM_Link_Mod

#
#-----[ OPEN ]------------------------------------------
#
privmsg.php

#
#-----[ FIND ]------------------------------------------
#
$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
// Begin Disable_PM_Link mod
if ( empty($board_config['privmsg_disable']) )
{

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
else
{
	$pm_img = '<img src="' . $images['icon_pm_disabled'] . '" alt="' . $lang['Send_private_message_disabled'] . '" title="' . $lang['Send_private_message_disabled'] . '" border="0" />';
	$pm = '';
}
// End Disable_PM_Link_Mod

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#

$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
// Begin Disable_PM_Link mod
if ( empty($board_config['privmsg_disable']) )
{

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
else
{
	$pm_img = '<img src="' . $images['icon_pm_disabled'] . '" alt="' . $lang['Send_private_message_disabled'] . '" title="' . $lang['Send_private_message_disabled'] . '" border="0" />';
	$pm = '';
}
// End Disable_PM_Link_Mod

#
#-----[ OPEN ]------------------------------------------
#

includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#

{
	$template->assign_block_vars('switch_user_logged_in', array());

	if ( !empty($userdata['user_popup_pm']) )
	{
		$template->assign_block_vars('switch_enable_pm_popup', array());
	}
}

#
#-----[ AFTER, ADD ]---------------------------------------
#

// Added by Disabled_PM_Links mod
if ( !empty($board_config['privmsg_disable']) )
{
        $template->assign_block_vars('switch_pm_disabled', array());
}
else
{
        $template->assign_block_vars('switch_pm_enabled', array());
}
// End Disabled_PM_Links Mod

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#
$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
// Begin Disable_PM_Link mod
if ( empty($board_config['privmsg_disable']) )
{

#
#-----[ AFTER, ADD ]------------------------------------------
#
}
else
{
	$pm_img = '<img src="' . $images['icon_pm_disabled'] . '" alt="' . $lang['Send_private_message_disabled'] . '" title="' . $lang['Send_private_message_disabled'] . '" border="0" />';
	$pm = '';
}
// End Disable_PM_Link_Mod

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Send_private_message'] = 'Send private message';

#
#-----[ AFTER, ADD ]------------------------------------------
#

// Added by Disable_PM_Links mod
$lang['Send_private_message_disabled'] = 'Private messages are disabled';
// End Disable_PM_Links mod

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/overall_header.tpl

#
#-----[ FIND ]------------------------------------------
#

<td height="25" align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>&nbsp; &nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;</span></td>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- Removed by Disable_PM_Links Mod <td height="25" align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>&nbsp; &nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;</span></td> -->
<td height="25" align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;
<!-- BEGIN switch_pm_enabled -->
<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>&nbsp; &nbsp;
<!-- END switch_pm_enabled -->
<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;</span></td>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.cfg

#
#-----[ FIND ]------------------------------------------
#
$images['icon_pm'] = "$current_template_images/{LANG}/icon_pm.gif";

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Begin Disable_PM_Link mod
$images['icon_pm_disabled'] = "$current_template_images/{LANG}/icon_pm_disabled.gif";
// End Disable_PM_Link_Mod

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
