##############################################################
## MOD Title: Online/Offline Status Images
## MOD Author: EXreaction < exreaction@lithiumstudios.org > (Nathan Guse) http://www.lithiumstudios.org
##
## MOD Description: Shows an image by the user showing if he/she is online or offline
##
## MOD Version: 1.0.0
##
## Installation Level:	Easy
## Installation Time:	~10 min (less than 1 min with EasyMOD)
##
## Files To Edit:	includes/usercp_viewprofile.php
##					includes/page_header.php
##					languagle/lang_english/lang_main.php
##					templates/subSilver/groupcp_info_body.tpl
##					templates/subSilver/profile_view_body.tpl
##					templates/subSilver/memberlist_body.tpl
##					templates/subSilver/viewtopic_body.tpl
##					groupcp.php
##					memberlist.php
##					viewtopic.php
##
## Included Files:	includes/online_offline.php
##					templates/subSilver/images/lang_english/icon_online.gif
##					templates/subSilver/images/lang_english/icon_offline.gif
##
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
##	+ My official thread for this mod is here: http://www.lithiumstudios.org/phpBB3/viewtopic.php?f=10&t=110
##		- More online/offline images and sets are available for download in that topic as well.
##	+ If you would like to support my work, you can do so by donating.  It can take a lot of time to code and support your modifications.
##		- You can donate with PayPal here: http://tinyurl.com/ymtctj
##	+ I HIGHLY reccomend you use EasyMod to install this mod(make sure you are using the latest version of EasyMod when you do)
##		- The biggest reason for errors after installing this mod is user installation error.  If EasyMod detects an error
##			+ it will let you know before it does any changes.
##############################################################
## MOD History:
##	(yyyy-mm-dd)
##	2007-01-14
##		+ 1.0.0
##			- Initial Release
##			- No changes since 0.9.0(RC1)
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]---------------------------------------------
#

copy root/includes/online_offline.php								to includes/online_offline.php
copy root/templates/subSilver/images/lang_english/icon_online.gif	to templates/subSilver/images/lang_english/icon_online.gif
copy root/templates/subSilver/images/lang_english/icon_offline.gif	to templates/subSilver/images/lang_english/icon_offline.gif

#
#-----[ OPEN ]---------------------------------------------
#

includes/page_header.php

#
#-----[ FIND ]---------------------------------------------
#

define('HEADER_INC', TRUE);

#
#-----[ AFTER, ADD ]---------------------------------------
#

// Start Online/Offline Status Images MOD
include($phpbb_root_path . 'includes/online_offline.'.$phpEx);
$online_array = get_online_users();
// End Online/Offline Status Images MOD

#
#-----[ OPEN ]---------------------------------------------
#

includes/usercp_viewprofile.php

#
#-----[ FIND ]---------------------------------------------
#

$template->assign_vars(array(

#
#-----[ AFTER, ADD ]---------------------------------------
#

// Start Online/Offline Status Images MOD
	'STATUS_IMG' => display_online_offline($profiledata['user_id'], $online_array),
	'L_ONLINE_OFFLINE' => $lang['Online_Offline'],
// End Online/Offline Status Images MOD

#
#-----[ OPEN ]---------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]---------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]--------------------------------------
#

// Start Online/Offline Status Images MOD
$lang['Online_Offline'] = 'Online/Offline';
// End Online/Offline Status Images MOD

#
#-----[ OPEN ]---------------------------------------------
#

templates/subSilver/groupcp_info_body.tpl

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line

{L_USERNAME}

#
#-----[ AFTER, ADD ]---------------------------------------
#

	  <th class="thTop">{L_ONLINE_OFFLINE}</th>

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line

{MOD_USERNAME}

#
#-----[ AFTER, ADD ]---------------------------------------
#

	  <td class="row1" align="center">{MOD_STATUS_IMG}</td>

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line

{member_row.USERNAME}

#
#-----[ AFTER, ADD ]---------------------------------------
#

	  <td class="{member_row.ROW_CLASS}" align="center">{member_row.STATUS_IMG}</td>

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line
# Should be colspan="7"

colspan="{%:1}"

#
#-----[ INCREMENT ]-------------------------------------
# If you don't know how to use the increment, find colspan="7", replace it with colspan="8"

%:1 +1

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line
# Should be colspan="7"

colspan="{%:1}"

#
#-----[ INCREMENT ]-------------------------------------
# If you don't know how to use the increment, find colspan="7", replace it with colspan="8"

%:1 +1

#
#-----[ OPEN ]---------------------------------------------
#

templates/subSilver/memberlist_body.tpl

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line

{L_USERNAME}

#
#-----[ AFTER, ADD ]---------------------------------------
#

	  <th class="thTop" nowrap="nowrap">&nbsp;</th>

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line

{memberrow.EMAIL_IMG}

#
#-----[ BEFORE, ADD ]--------------------------------------
#

	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle">&nbsp;{memberrow.STATUS_IMG}&nbsp;</td>

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line
# Should be colspan="8"

colspan="{%:1}"

#
#-----[ INCREMENT ]-------------------------------------
# If you don't know how to use the increment, find colspan="8", replace it with colspan="9"

%:1 +1

#
#-----[ OPEN ]---------------------------------------------
#

templates/subSilver/profile_view_body.tpl

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line

<tr>
{L_EMAIL_ADDRESS}

#
#-----[ BEFORE, ADD ]--------------------------------------
#

		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_ONLINE_OFFLINE}:</span></td>
		  <td class="row1" valign="middle" width="100%"><b><span class="gen">{STATUS_IMG}</span></b></td>
		</tr>
		
#
#-----[ OPEN ]---------------------------------------------
#

templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]---------------------------------------------
# Note: This is not the full line

{postrow.PROFILE_IMG}

#
#-----[ IN-LINE FIND ]-------------------------------------
#

{postrow.PROFILE_IMG}

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------
#

{postrow.STATUS_IMG}

#
#-----[ OPEN ]---------------------------------------------
#

groupcp.php

#
#-----[ FIND ]---------------------------------------------
#

	$s_hidden_fields .= '';

	$template->assign_vars(array(

#
#-----[ AFTER, ADD ]---------------------------------------
#

// Start Online/Offline Status Images MOD
		'L_ONLINE_OFFLINE' => $lang['Online_Offline'],
		'MOD_STATUS_IMG' => display_online_offline($user_id, $online_array),
// End Online/Offline Status Images MOD

#
#-----[ FIND ]---------------------------------------------
#

			$template->assign_block_vars('member_row', array(

#
#-----[ AFTER, ADD ]---------------------------------------
#

// Start Online/Offline Status Images MOD
				'STATUS_IMG' => display_online_offline($user_id, $online_array),
// End Online/Offline Status Images MOD

#
#-----[ OPEN ]---------------------------------------------
#

memberlist.php

#
#-----[ FIND ]---------------------------------------------
#

$template->assign_vars(array(

#
#-----[ AFTER, ADD ]---------------------------------------
#

// Start Online/Offline Status Images MOD
	'L_ONLINE_OFFLINE' => $lang['Online_Offline'],
// End Online/Offline Status Images MOD

#
#-----[ FIND ]---------------------------------------------
#

		$template->assign_block_vars('memberrow', array(

#
#-----[ AFTER, ADD ]---------------------------------------
#

// Start Online/Offline Status Images MOD
			'STATUS_IMG' => display_online_offline($user_id, $online_array),
// End Online/Offline Status Images MOD

#
#-----[ OPEN ]---------------------------------------------
#

viewtopic.php

#
#-----[ FIND ]---------------------------------------------
#

	$template->assign_block_vars('postrow', array(

#
#-----[ AFTER, ADD ]---------------------------------------
#

// Start Online/Offline Status Images MOD
		'STATUS_IMG' => display_online_offline($poster_id, $online_array),
// End Online/Offline Status Images MOD

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM