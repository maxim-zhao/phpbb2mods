##############################################################
## MOD Title: Seperate PM limits for admin and mods
## MOD Author: ZombieSlayer < zombieslayer@thunder65.com > (N/A) http://www.thunder65.com
## MOD Description: A mod that allows you to set different private message limits for administrators and moderators through the ACP.
## 
## The current max allowed for admins is 500 per box (in/sent/save) and 250 for moderators.  You can change this prior to installing the MOD by simply changing those values in the SQL queries.
## MOD Version: 1.0.4
## 
## Installation Level: Easy
## Installation Time: 9 minutes
## Files To Edit: privmsg.php
##                admin/admin_board.php
##                language/lang_english/lang_admin.php
##                language/lang_english/lang_main.php
##                templates/subSilver/admin/board_config_body.tpl
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2108.38030 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: A very big thank you goes to poyntesm for confirming that my code was correct and answering a 
## bunch of questions.  
## 
## Another big thank you to Manipe for cleaning up my very sloppy SQL.
## 
## Installation time should be around 5-10 minutes.
## 
## 
## The current max allowed for admins is 500 per box (in/sent/save) and 250 for moderators.  You can change this prior to installing the MOD by simply changing those values in the SQL queries.
##############################################################
## MOD History:
## 
## 2006-01-16 - Version 0.1.2
## Final tweaking to the SQL query.
## 
## 2006-02-04 - Version 1.0.0
## A bit of tweaking in my author notes and version number
## 
## 2006-02-13 - Version 1.0.1
## Changed an if statement to an elseif statement.  Also removed some unnecessary lang in admin/admin_board.php
## 
## 2006-02-13 - Version 1.0.2
## Enclosed the config_values in single quotes
## 
## 2006-03-06 - Version 1.0.3
## Changed the language in lang_admin.php from "Max posts in Inbox" etc to "Max posts in Users Inbox" etc.  This will lower any confusion level about which limits are being changed while in the admin control panel.
## 
## 2006-03-07 - Version 1.0.4
## Corrected an error in the location of the finds in language/lang_english/lang_admin.php.  Also changed the language from Users to Members.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
INSERT INTO phpbb_config(config_name, config_value) VALUES ('administrator_max_inbox_privmsgs', '500');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('administrator_max_sentbox_privmsgs', '500');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('administrator_max_savebox_privmsgs', '500');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('moderator_max_inbox_privmsgs', '250');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('moderator_max_sentbox_privmsgs', '250');
INSERT INTO phpbb_config(config_name, config_value) VALUES ('moderator_max_savebox_privmsgs', '250');
#
#-----[ OPEN ]------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------
#
init_userprefs($userdata);
#
#-----[ AFTER, ADD ]------------------------------------------
#
if ($userdata['user_level'] == ADMIN) //ADMIN only;
{
    $board_config['max_inbox_privmsgs'] = $board_config['administrator_max_inbox_privmsgs'];
    $board_config['max_savebox_privmsgs'] = $board_config['administrator_max_savebox_privmsgs'];
    $board_config['max_sentbox_privmsgs'] = $board_config['administrator_max_sentbox_privmsgs'];
}
elseif ($userdata['user_level'] == MOD) //MOD only; 
{ 
   $board_config['max_inbox_privmsgs'] = $board_config['moderator_max_inbox_privmsgs']; 
   $board_config['max_savebox_privmsgs'] = $board_config['moderator_max_savebox_privmsgs']; 
   $board_config['max_sentbox_privmsgs'] = $board_config['moderator_max_sentbox_privmsgs']; 
} 
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#
"L_PRIVATE_MESSAGING" => $lang['Private_Messaging'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
      "L_ADMINISTRATOR_INBOX_LIMIT" => $lang['Administrator_Inbox_limits'], 
      "L_ADMINISTRATOR_SENTBOX_LIMIT" => $lang['Administrator_Sentbox_limits'],
      "L_ADMINISTRATOR_SAVEBOX_LIMIT" => $lang['Administrator_Savebox_limits'],
      "L_MODERATOR_INBOX_LIMIT" => $lang['Moderator_Inbox_limits'],
      "L_MODERATOR_SENTBOX_LIMIT" => $lang['Moderator_Sentbox_limits'], 
      "L_MODERATOR_SAVEBOX_LIMIT" => $lang['Moderator_Savebox_limits'], 
      
#
#-----[ FIND ]------------------------------------------
#
"S_PRIVMSG_DISABLED" => $privmsg_off,
#
#-----[ AFTER, ADD ]------------------------------------------
#
	"ADMINISTRATOR_INBOX_LIMIT"=>$new['administrator_max_inbox_privmsgs'],
	"ADMINISTRATOR_SENTBOX_LIMIT"=>$new['administrator_max_sentbox_privmsgs'],
	"ADMINISTRATOR_SAVEBOX_LIMIT"=>$new['administrator_max_savebox_privmsgs'],
	"MODERATOR_INBOX_LIMIT"=>$new['moderator_max_inbox_privmsgs'],
	"MODERATOR_SENTBOX_LIMIT"=>$new['moderator_max_sentbox_privmsgs'],
	"MODERATOR_SAVEBOX_LIMIT"=>$new['moderator_max_savebox_privmsgs'],
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
 $lang['Disable_privmsg'] = 'Private Messaging';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Administrator_Inbox_limits'] = 'Max posts in Administrator Inbox';
$lang['Administrator_Inbox_limits_explain'] = 'Max posts in Administrator Inbox';
$lang['Administrator_Sentbox_limits'] = 'Max posts in Administrator SentBox';
$lang['Administrator_Sentbox_limits_explain'] = 'Max posts in Administrator Sentbox';
$lang['Administrator_Savebox_limits'] = 'Max posts in Administrator Savebox';
$lang['Administrator_Savebox_limits_explain'] = 'Max posts in Administrator Savebox';
$lang['Moderator_Inbox_limits'] = 'Max posts in Moderator Inbox';
$lang['Moderator_Inbox_limits_explain'] = 'Max posts in Moderator Inbox';
$lang['Moderator_Sentbox_limits'] = 'Max posts in Moderator Sentbox';
$lang['Moderator_Sentbox_limits_explain'] = 'Max posts in Moderator Sentbox';
$lang['Moderator_Savebox_limits'] = 'Max posts in Moderator Savebox';
$lang['Moderator_Savebox_limits_explain'] = 'Max posts in Moderator Savebox';
#
#-----[ FIND ]------------------------------------------
#
$lang['Inbox_limits'] = 'Max posts in Inbox';
#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Inbox_limits'] = 'Max posts in Members Inbox';
#
#-----[ FIND ]------------------------------------------
#
$lang['Sentbox_limits'] = 'Max posts in Sentbox';
#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Sentbox_limits'] = 'Max posts in Members Sentbox';
#
#-----[ FIND ]------------------------------------------
#
$lang['Savebox_limits'] = 'Max posts in Savebox';
#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Savebox_limits'] = 'Max posts in Members Savebox';
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
 $lang['Edit_pm'] = 'Edit message';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Administrator_Inbox'] = 'Administrator Inbox';
$lang['Administrator_Outbox'] = 'Administrator Outbox';
$lang['Administrator_Savebox'] = 'Administrator Savebox';
$lang['Administrator_Sentbox'] = 'Administrator Sentbox';
$lang['Moderator_Inbox'] = 'Moderator Inbox';
$lang['Moderator_Outbox'] = 'Moderator Outbox';
$lang['Moderator_Savebox'] = 'Moderator Savebox';
$lang['Moderator_Sentbox'] = 'Moderator Sentbox'; 

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<tr>
<td class="row1">{L_INBOX_LIMIT}</td>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<tr>
		<td class="row1">{L_ADMINISTRATOR_INBOX_LIMIT}</td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="administrator_max_inbox_privmsgs" value="{ADMINISTRATOR_INBOX_LIMIT}" /></td>
	</tr>
      <tr>
		<td class="row1">{L_ADMINISTRATOR_SENTBOX_LIMIT}</td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="administrator_max_sentbox_privmsgs" value="{ADMINISTRATOR_SENTBOX_LIMIT}" /></td>
	</tr>
      <tr>
		<td class="row1">{L_ADMINISTRATOR_SAVEBOX_LIMIT}</td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="administrator_max_savebox_privmsgs" value="{ADMINISTRATOR_SAVEBOX_LIMIT}" /></td>
	</tr>
      <tr>
		<td class="row1">{L_MODERATOR_INBOX_LIMIT}</td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="moderator_max_inbox_privmsgs" value="{MODERATOR_INBOX_LIMIT}" /></td>
	</tr>
      <tr>
		<td class="row1">{L_MODERATOR_SENTBOX_LIMIT}</td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="moderator_max_sentbox_privmsgs" value="{MODERATOR_SENTBOX_LIMIT}" /></td>
      </tr>
      <tr>
		<td class="row1">{L_MODERATOR_SAVEBOX_LIMIT}</td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="moderator_max_savebox_privmsgs" value="{MODERATOR_SAVEBOX_LIMIT}" /></td>
      </tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
