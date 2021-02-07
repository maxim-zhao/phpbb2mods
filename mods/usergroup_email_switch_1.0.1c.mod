############################################################## 
## MOD Title: UserGroup E-MAil Switch
## MOD Author: Dman8568 <N/A> (David Gersting) N/A
## MOD Description: This MOD will add a switch to turn the E-Mail that is sent to a user when they are admitted into a Usergroup ON and OFF.
## This is done from the "group managment" panel in the ACP.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 5-10 Minutes 
## Files To Edit: admin/admin_groups.php
##		  language/lang_english/lang_admin.php
##		  templates/subSilver/admin/group_edit_body.tpl
##		  groupcp.php
##
## Included Files: N/A
## License: http://www.gnu.org/licenses/gpl.html GNU General Public License v.2
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
##  PHPBB Version: 2.0.19
##  
##
############################################################## 
## MOD History: 
## 
##   2005-11-18 - Version 1.0.0
##      - [Rejected for errors in MOD Template]
##
##   2008-12-5 - Version 1.0.1a
##      - Original Release. Basic functionality. (Plan to add more if public shows interest) 
##
##   2008-12-6 - Version 1.0.1b
##      - Repackaged Install File slightly. [edited: "Author Notes"]
##
##   2008-12-6 - Version 1.0.1c
##      - Repackaged to support 2.0.19 [no code changed]
##
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 
ALTER TABLE `phpbb_groups` ADD `group_email` TINYINT( 1 ) DEFAULT '1' NOT NULL ;

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_groups.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$group_hidden = ( $group_info['group_type'] == GROUP_HIDDEN ) ? ' checked="checked"' : '';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// UserGroup E-Mail Switch MOD
$email_yes = ( $group_info['group_email'] == 1 ) ? ' checked="checked"' : '';
$email_no = ( $group_info['group_email'] == 0 ) ? ' checked="checked"' : '';
//

# 
#-----[ FIND ]------------------------------------------ 
# 
'L_DELETE_MODERATOR_EXPLAIN' => $lang['delete_moderator_explain'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// UserGroup E-Mail Switch MOD
'L_YES' => $lang['Yes'],
'L_NO' => $lang['No'],
'L_GROUP_EMAIL' => $lang['group_email'],
//

# 
#-----[ FIND ]------------------------------------------ 
# 
'S_GROUP_HIDDEN_CHECKED' => $group_hidden,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// UserGroup E-Mail Switch MOD
'S_GROUP_EMAIL_YES_CHECKED' => $email_yes,
'S_GROUP_EMAIL_NO_CHECKED' => $email_no,
//

# 
#-----[ FIND ]------------------------------------------ 
# 
$delete_old_moderator = isset($HTTP_POST_VARS['delete_old_moderator']) ? true : false;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// UserGroup E-Mail Switch MOD
$group_email = isset($HTTP_POST_VARS['group_email']) ? intval($HTTP_POST_VARS['group_email']) : "";
//

# 
#-----[ FIND ]------------------------------------------ 
# 
$sql = "UPDATE " . GROUPS_TABLE . "
SET group_type = $group_type, group_name = '" . str_replace("\'", "''", $group_name) . "', group_description = '" . str_replace("\'", "''", $group_description) . "', group_moderator = $group_moderator 
WHERE group_id = $group_id";

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
group_moderator = $group_moderator

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, group_email = $group_email

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Look_up_group'] = 'Look up group';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// UserGroup E-Mail Switch MOD
$lang['group_email'] = 'Send Notify E-Mail on User\'s Admission';
//

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/group_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<!-- BEGIN group_edit -->

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
<!-- Group E-Mail DOD START -->
<tr>
 <td class="row1"><span class="gen">{L_GROUP_EMAIL}:</span></td>
 <td class="row2">
  <input type="radio" name="group_email" value="1" {S_GROUP_EMAIL_YES_CHECKED} />{L_YES}    
  <input type="radio" name="group_email" value="0" {S_GROUP_EMAIL_NO_CHECKED} />{L_NO}
 </td>
</tr>
<!-- Group E-Mail DOD END -->

# 
#-----[ OPEN ]------------------------------------------ 
# 
groupcp.php

# 
#-----[ FIND ]------------------------------------------ 
#
					$emailer->set_subject($lang['Group_added']);

# 
#-----[ FIND ]------------------------------------------ 
# Around Line 570 
					$emailer->send();

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
					// UserGroup E-Mail Switch MOD
					$sql = "SELECT group_email FROM " . GROUPS_TABLE . "
					WHERE group_id = $group_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain group_email status', '', __LINE__, __FILE__, $sql);
					}

					if ( $send_email = $db->sql_fetchrow($result) )
					{
						if ($send_email['group_email'])
						{
							$emailer->send();
						}
					}
					//

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM
