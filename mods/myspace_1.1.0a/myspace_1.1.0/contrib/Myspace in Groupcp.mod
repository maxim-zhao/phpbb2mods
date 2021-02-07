##############################################################
## MOD Title: Groupcp Add-On
## MOD Author: houndoftheb < bbolman@gmail.com > (Brad Bolman) n/a
## MOD Description: This adds the myspace buttons to your groupcp
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 11 minutes
## Files To Edit: groupcp.php
##	templates/subSilver/groupcp_info_body.tpl
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: Phpbb.ModTeam.Tools
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
##	This requires the Myspace Profile Button Mod to function.
##############################################################
## MOD History:
## 
## 2006-11-25 - Version 1.0.0
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
groupcp.php
#
#-----[ FIND ]------------------------------------------
#
function generate_user_info(&$row, $date_format, $group_mod,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
&$www,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
&$myspace_img, &$myspace,
#
#-----[ FIND ]------------------------------------------
#
	$www = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$myspace_img = ( $row['user_myspace'] ) ? '<a href="http://www.myspace.com/' . $row['user_myspace'] . '" target="_usermyspace"><img src="' . $images['icon_myspace'] . '" alt="' . $lang['Myspace'] . '" title="' . $lang['Myspace'] . '" border="0" /></a>' : '';
        $myspace = ( $row['user_myspace'] ) ? '<a href="http://www.myspace.com/' . $row['user_myspace'] . '" target="_usermyspace">' . $lang['Myspace'] . '</a>' : '';
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT username,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
user_email,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
user_myspace,
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT u.username,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
u.user_email,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
u.user_myspace,
#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT u.username,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
u.user_email,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
u.user_myspace,
#
#-----[ FIND ]------------------------------------------
#
generate_user_info($group_moderator,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$www,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 $myspace_img, $myspace,
#
#-----[ FIND ]------------------------------------------
#
		'L_WEBSITE' => $lang['Website'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_MYSPACE' => $lang['Myspace'],
#
#-----[ FIND ]------------------------------------------
#
		'MOD_WWW' => $www,
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'MOD_MYSPACE_IMG' => $myspace_img,
		'MOD_MYSPACE' => $myspace,

#
#-----[ FIND ]------------------------------------------
#
		generate_user_info($group_members[$i],
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$www,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 $myspace_img, $myspace,
#
#-----[ FIND ]------------------------------------------
#
			'WWW' => $www,
#
#-----[ AFTER, ADD ]------------------------------------------
#
				'MYSPACE_IMG' => $myspace_img,
				'MYSPACE' => $myspace,
#
#-----[ FIND ]------------------------------------------
#
			generate_user_info($modgroup_pending_list[$i],
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$www,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 $myspace_img, $myspace,
#
#-----[ FIND ]------------------------------------------
#
					'WWW' => $www,
#
#-----[ AFTER, ADD ]------------------------------------------
#
					'MYSPACE_IMG' => $myspace_img,
					'MYSPACE' => $myspace,
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/groupcp_info_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	  <th class="thTop">{L_WEBSITE}</th>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	  <th class="thTop">{L_MYSPACE}</th>
#
#-----[ FIND ]------------------------------------------
#
	  <td class="row1" align="center">{MOD_WWW_IMG}</td>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	  <td class="row1" align="center">{MOD_MYSPACE_IMG}</td>
#
#-----[ FIND ]------------------------------------------
#
	  <td class="{member_row.ROW_CLASS}" align="center"> {member_row.WWW_IMG}</td>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	  <td class="{member_row.ROW_CLASS}" align="center"> {member_row.MYSPACE_IMG}</td>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
