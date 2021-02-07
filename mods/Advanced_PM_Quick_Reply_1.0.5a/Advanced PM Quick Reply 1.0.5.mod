##############################################################
## MOD Title: Advanced PM Quick Reply
## MOD Author: swatquest < N/A > (N/A) http://www.phpbbrasil.com.br
## MOD Description: Advanced of quick reply in Private Messaging
## MOD Version: 1.0.5
## 
##
## Installation Level: Intermediate
## Installation Time: 15 Minute
## Files To Edit: 10
##        privmsgs.php
##        includes/usercp_register.php
##        admin/admin_board.php
##        admin/admin_users.php
##        language/lang_english/lang_main.php
##        language/lang_english/lang_admin.php
##        templates/subSilver/privmsgs_read_body.tpl
##        templates/subSilver/profile_add_body.tpl
##        templates/subSilver/admin/board_config_body.tpl
##        templates/subSilver/admin/user_edit_body.tpl
##
## Included Files: 3
##        includes/pm_quickreply.php
##        templates/subSilver/pm_quickreply.tpl
##        templates/pm_quick_reply.js
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2       
#############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##  
##  This MOD will install using EasyMOD (Extract the zip file to easymod folder)
##
##  Members Profile:
##      - Show/Hide PM Quick Reply 
##      - Show/Hide Buttons 
##      - Show/Hide Smilies
## 
##  Admin:
##      - Enable/Disable PM Quick Reply
##      - Enable/Disable Smilies
##  	Default for members profile :
##     	    - Show/Hide PM Quick Reply in members profile 
##          - Show/Hide Buttons in members profile 
##          - Show/Hide Smilies in members profile 
##  
## 
##############################################################
## MOD History:
##
##   2006-05-30 Version 1.0.0
##      - initial release
##
##   2006-06-11  Version 1.0.1
##      - Fix languages files (Enghish and Brazilian Portuguese)
##
##   2006-06-13 Version 1.0.2
##      - Fix templates pm_quickreply.tpl
##
##   2006-06-14 Version 1.0.3
##      - Fix to the if register
##
##   2006-06-16 Version 1.0.4
##      - Fix security
##      - Compatibility with Easymod 0.3.0
##      - Install Additional_Languages with Easymod 0.3.0
##      - Update languages (Enghish and Brazilian Portuguese) 
## 
##   2006-08-7 Version 1.0.5
##      - Fix security
##      - Fix templates
##      - Fix conflict with notify reply
##      - Update languages (Enghish and Brazilian Portuguese) 
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 
#
#---------[ SQL ]----------------------------------------
#
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('pm_quickreply', '1');
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('pm_showquickreply', '1');
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('pm_quickreply_bbcode', '1');
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('pm_quickreply_smilies', '20');
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('pm_quickreply_smilies_ed', '1');

ALTER TABLE `phpbb_users` ADD `user_pm_showquickreply` TINYINT(1)  DEFAULT "1" NOT NULL;
ALTER TABLE `phpbb_users` ADD `user_pm_quickreply_bbcode` TINYINT(1)  DEFAULT "1" NOT NULL;
ALTER TABLE `phpbb_users` ADD `user_pm_quickreply_smilies_ed` TINYINT(1)  DEFAULT "1" NOT NULL;
#
#---------[ COPY ]------------------------------------------
#
 copy root/includes/pm_quickreply.php  to  includes/pm_quickreply.php
 copy root/templates/subSilver/pm_quickreply.tpl  to  templates/subSilver/pm_quickreply.tpl
 copy root/templates/pm_quick_reply.js  to  templates/pm_quick_reply.js
#
#---------[ OPEN ]------------------------------------------
#
privmsg.php

#
#---------[ FIND ]----------------------------------------------
#
		'YIM' => $yim)
	);

#	
#-------[ AFTER, ADD ]------------------------------------------
#

 if ( $board_config['pm_quickreply'])
	{
	if ($userdata['user_pm_showquickreply'])
	  {
			include($phpbb_root_path . 'includes/pm_quickreply.'.$phpEx);
		}
	}
#	
#-------[ OPEN ]---------------------------------------------
#
includes/usercp_register.php

#
#-------[ FIND ]-------------------------------------------------
#
		$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $board_config['allow_smilies'];
#
#-------[ AFTER, ADD ]---------------------------------------------
#
		$pm_showquickreply = ( isset($HTTP_POST_VARS['pm_showquickreply']) ) ? ( ($HTTP_POST_VARS['pm_showquickreply']) ? TRUE : 0 ) : $board_config['pm_showquickreply'];
		$pm_quickreply_bbcode = ( isset($HTTP_POST_VARS['pm_quickreply_bbcode']) ) ? ( ($HTTP_POST_VARS['pm_quickreply_bbcode']) ? TRUE : 0 ) : $board_config['pm_quickreply_bbcode'];
		$pm_quickreply_smilies_ed = ( isset($HTTP_POST_VARS['pm_quickreply_smilies_ed']) ) ? ( ($HTTP_POST_VARS['pm_quickreply_smilies_ed']) ? TRUE : 0 ) : $board_config['pm_quickreply_smilies_ed'];

#
#-------[ FIND ]-------------------------------------------------
#
		$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $userdata['user_allowsmile'];
#
#-------[ AFTER, ADD ]---------------------------------------------
#
		$pm_showquickreply = ( isset($HTTP_POST_VARS['pm_showquickreply']) ) ? ( ($HTTP_POST_VARS['pm_showquickreply']) ? TRUE : 0 ) : $userdata['user_pm_showquickreply'];
		$pm_quickreply_bbcode = ( isset($HTTP_POST_VARS['pm_quickreply_bbcode']) ) ? ( ($HTTP_POST_VARS['pm_quickreply_bbcode']) ? TRUE : 0 ) : $userdata['user_pm_quickreply_bbcode'];
		$pm_quickreply_smilies_ed = ( isset($HTTP_POST_VARS['pm_quickreply_smilies_ed']) ) ? ( ($HTTP_POST_VARS['pm_quickreply_smilies_ed']) ? TRUE : 0 ) : $userdata['user_pm_quickreply_smilies_ed'];

#
#-------[ FIND ]---------------------------------------------------
#
$sql = "UPDATE " . USERS_TABLE . "
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."'
#				
#-------[ IN-LINE FIND ]-------------------------------------------
#
user_popup_pm = $popup_pm,
#
#-------[ IN-LINE AFTER, ADD ]-------------------------------------
#
 user_pm_showquickreply = $pm_showquickreply, user_pm_quickreply_bbcode = $pm_quickreply_bbcode, user_pm_quickreply_smilies_ed = $pm_quickreply_smilies_ed,
#
#-------[ FIND ]---------------------------------------------------
#
			//
			// Get current date
			//
			$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password,
				VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ",
#				
#-------[ IN-LINE FIND ]-------------------------------------------
#
user_popup_pm,
#
#-------[ IN-LINE AFTER, ADD ]-------------------------------------
#
 user_pm_showquickreply, user_pm_quickreply_bbcode, user_pm_quickreply_smilies_ed, 
 
#				
#-------[ IN-LINE FIND ]-------------------------------------------
#
$popup_pm,
#
#-------[ IN-LINE AFTER, ADD ]-------------------------------------
#
 $pm_showquickreply, $pm_quickreply_bbcode, $pm_quickreply_smilies_ed, 
#
#-------[ FIND ]---------------------------------------------------
#
	$popup_pm = $userdata['user_popup_pm'];
#	
#-------[ AFTER, ADD ]---------------------------------------------
#
	$pm_showquickreply = $userdata['user_pm_showquickreply'];
	$pm_quickreply_bbcode = $userdata['user_pm_quickreply_bbcode'];
	$pm_quickreply_smilies_ed = $userdata['user_pm_quickreply_smilies_ed'];
#
#-------[ FIND ]---------------------------------------------------
#
		'POPUP_PM_YES' => ( $popup_pm ) ? 'checked="checked"' : '',
		'POPUP_PM_NO' => ( !$popup_pm ) ? 'checked="checked"' : '',
#
#-------[ AFTER, ADD ]---------------------------------------------
#
		'PM_SHOWQUICKREPLY_YES' => ( $pm_showquickreply ) ? 'checked="checked"' : '',
		'PM_SHOWQUICKREPLY_NO' => ( !$pm_showquickreply ) ? 'checked="checked"' : '',
		'PM_QUICKREPLY_BBCODE_YES' => ( $pm_quickreply_bbcode ) ? 'checked="checked"' : '',
		'PM_QUICKREPLY_BBCODE_NO' => ( !$pm_quickreply_bbcode ) ? 'checked="checked"' : '',
		'PM_QUICKREPLY_SMILIES_ED_YES' => ( $pm_quickreply_smilies_ed ) ? 'checked="checked"' : '',
		'PM_QUICKREPLY_SMILIES_ED_NO' => ( !$pm_quickreply_smilies_ed ) ? 'checked="checked"' : '',
#		
#-------[ FIND ]---------------------------------------------------
#
		'L_POPUP_ON_PRIVMSG' => $lang['Popup_on_privmsg'],
		'L_POPUP_ON_PRIVMSG_EXPLAIN' => $lang['Popup_on_privmsg_explain'],
#		
#-------[ AFTER, ADD ]---------------------------------------------
#
		'L_PM_QUICKREPLY_IN' => $lang['Pm_quickreply_in'],
		'L_PM_SHOWQUICKREPLY' => $lang['Pm_showquickreply'],
		'L_PM_QUICKREPLY_BBCODE' => $lang['Pm_quickreply_bbcode'],
		'L_PM_QUICKREPLY_SMILIES_ED' => $lang['Pm_quickreply_smilies_ed'],
#		
#-------[ FIND ]---------------------------------------------------
#
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
#
#-------[ BEFORE, ADD ]--------------------------------------------
#

			if ( $board_config['pm_quickreply'] )
			{
				if ( !empty($board_config['pm_quickreply_smilies']) ){
			
					$template->assign_block_vars('switch_pm_quickreply_smilies', array());
				}
				
				$template->assign_block_vars('switch_pm_quickreply', array());
			}
#
#-------[ OPEN ]-----------------------------------------------
#
admin/admin_board.php
	
#  
#-------[ FIND ]---------------------------------------------------
#
$privmsg_on = ( !$new['privmsg_disable'] ) ? "checked=\"checked\"" : "";
$privmsg_off = ( $new['privmsg_disable'] ) ? "checked=\"checked\"" : "";
#
#-------[ AFTER, ADD ]---------------------------------------------
#
$pm_quickreply_yes = ( $new['pm_quickreply'] ) ? "checked=\"checked\"" : "";
$pm_quickreply_no = ( !$new['pm_quickreply'] ) ? "checked=\"checked\"" : "";
$pm_showquickreply_yes = ( $new['pm_showquickreply'] ) ? "checked=\"checked\"" : "";
$pm_showquickreply_no = ( !$new['pm_showquickreply'] ) ? "checked=\"checked\"" : "";
$pm_quickreply_bbcode_yes = ( $new['pm_quickreply_bbcode'] ) ? "checked=\"checked\"" : "";
$pm_quickreply_bbcode_no = ( !$new['pm_quickreply_bbcode'] ) ? "checked=\"checked\"" : "";
$pm_quickreply_smilies_ed_yes = ( $new['pm_quickreply_smilies_ed'] ) ? "checked=\"checked\"" : "";
$pm_quickreply_smilies_ed_no = ( !$new['pm_quickreply_smilies_ed'] ) ? "checked=\"checked\"" : "";
#
#-------[ FIND ]---------------------------------------------------
#
	"L_ABILITIES_SETTINGS" => $lang['Abilities_settings'],
#	
#-------[ BEFORE, ADD ]--------------------------------------------
#
	"L_ENABLE_PM_QUICKREPLY" => $lang['enable_pm_quickreply'],
	"L_PMSHOWQUICKREPLY" => $lang['pm_showquickreply'],
	"L_PM_QUICKREPLY" => $lang['pm_quickreply'],
	"L_PM_QUICKREPLY_BBCODE" => $lang['pm_quickreply_bbcode'],
	"L_PM_QUICKREPLY_SMILIES_ED" => $lang['pm_quickreply_smilies_ed'], 	
	"L_PM_QUICKREPLY_SMILIES" => $lang['pm_quickreply_smilies'], 
	"L_PM_QUICKREPLY_SMILIES_INFO" => $lang['pm_quickreply_smilies_info'], 
#
#-------[ FIND ]---------------------------------------------------
#
	"S_PRIVMSG_DISABLED" => $privmsg_off, 
#	
#-------[ AFTER, ADD ]---------------------------------------------
#
	"PM_QUICKREPLY_YES" => $pm_quickreply_yes,
	"PM_QUICKREPLY_NO" => $pm_quickreply_no,
	"PM_SHOWQUICKREPLY_YES" => $pm_showquickreply_yes,
	"PM_SHOWQUICKREPLY_NO" => $pm_showquickreply_no,
	"PM_QUICKREPLY_BBCODE_YES" => $pm_quickreply_bbcode_yes,
	"PM_QUICKREPLY_BBCODE_NO" => $pm_quickreply_bbcode_no,
	"PM_QUICKREPLY_SMILIES_ED_YES" => $pm_quickreply_smilies_ed_yes,
	"PM_QUICKREPLY_SMILIES_ED_NO" => $pm_quickreply_smilies_ed_no,
	"PM_QUICKREPLY_SMILIES" => $new['pm_quickreply_smilies'],
#	
#-------[ OPEN ]-----------------------------------------------
#
admin/admin_users.php

#  
#-------[ FIND ]---------------------------------------------------
#
		$popuppm = ( isset( $HTTP_POST_VARS['popup_pm']) ) ? ( ( $HTTP_POST_VARS['popup_pm'] ) ? TRUE : 0 ) : TRUE;
#		
#-------[ BEFORE, ADD ]--------------------------------------------
#

		$pm_showquickreply = ( isset($HTTP_POST_VARS['pm_showquickreply']) ) ? intval($HTTP_POST_VARS['pm_showquickreply']) : $board_config['pm_showquickreply'];
		$pm_quickreply_bbcode = ( isset($HTTP_POST_VARS['pm_quickreply_bbcode']) ) ? intval($HTTP_POST_VARS['pm_quickreply_bbcode']) : $board_config['pm_quickreply_bbcode'];
		$pm_quickreply_smilies_ed = ( isset($HTTP_POST_VARS['pm_quickreply_smilies_ed']) ) ? intval($HTTP_POST_VARS['pm_quickreply_smilies_ed']) : $board_config['pm_quickreply_smilies_ed'];
		
#		
#-------[ FIND ]---------------------------------------------------
#
      if( !$error )
      {
         $sql = "UPDATE " . USERS_TABLE . "
            SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email)
#			
#-------[ IN-LINE FIND ]-------------------------------------------
#
user_popup_pm = $popuppm,
#
#-------[ IN-LINE AFTER, ADD ]-------------------------------------
#
 user_pm_showquickreply = $pm_showquickreply,user_pm_quickreply_bbcode = $pm_quickreply_bbcode, user_pm_quickreply_smilies_ed = $pm_quickreply_smilies_ed,
#
#-------[ FIND ]---------------------------------------------------
#
		$popuppm = $this_userdata['user_popup_pm'];
#		
#-------[ AFTER, ADD ]---------------------------------------------
#
		$pm_showquickreply = $this_userdata['user_pm_showquickreply'];
		$pm_quickreply_bbcode = $this_userdata['user_pm_quickreply_bbcode'];
		$pm_quickreply_smilies_ed = $this_userdata['user_pm_quickreply_smilies_ed'];
#		
#-------[ FIND ]---------------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="popup_pm" value="' . $popuppm . '" />';
#			
#-------[ AFTER, ADD ]---------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="pm_showquickreply" value="' . $pm_showquickreply . '" />';
			$s_hidden_fields .= '<input type="hidden" name="pm_quickreply_bbcode" value="' . $pm_quickreply_bbcode . '" />';
			$s_hidden_fields .= '<input type="hidden" name="pm_quickreply_smilies_ed" value="' . $pm_quickreply_smilies_ed . '" />';
#			
#-------[ FIND ]---------------------------------------------------
#
			'POPUP_PM_YES' => ($popuppm) ? 'checked="checked"' : '',
			'POPUP_PM_NO' => (!$popuppm) ? 'checked="checked"' : '',
#			
#-------[ AFTER, ADD ]---------------------------------------------
#
			'PM_SHOWQUICKREPLY_YES' => ( $pm_showquickreply ) ? 'checked="checked"' : '',
			'PM_SHOWQUICKREPLY_NO' => ( !$pm_showquickreply ) ? 'checked="checked"' : '',
			'PM_QUICKREPLY_BBCODE_YES' => ( $pm_quickreply_bbcode ) ? 'checked="checked"' : '',
			'PM_QUICKREPLY_BBCODE_NO' => ( !$pm_quickreply_bbcode ) ? 'checked="checked"' : '',
			'PM_QUICKREPLY_SMILIES_ED_YES' => ( $pm_quickreply_smilies_ed ) ? 'checked="checked"' : '',
			'PM_QUICKREPLY_SMILIES_ED_NO' => ( !$pm_quickreply_smilies_ed ) ? 'checked="checked"' : '',
#
#-------[ FIND ]---------------------------------------------------
#
			'L_POPUP_ON_PRIVMSG' => $lang['Popup_on_privmsg'],
#
#-----[ AFTER, ADD ]----------------------------------------------
# 
		    'L_PM_QUICKREPLY_IN' => $lang['Pm_quickreply_in'],
			'L_PM_SHOWQUICKREPLY' => $lang['Pm_showquickreply'],
			'L_PM_QUICKREPLY_BBCODE' => $lang['Pm_quickreply_bbcode'],
			'L_PM_QUICKREPLY_SMILIES_ED' => $lang['Pm_quickreply_smilies_ed'],
#		
#-------[ FIND ]---------------------------------------------------
#
			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_PROFILE_ACTION' => append_sid("admin_users.$phpEx"))
		);
#
#-----[ AFTER, ADD ]----------------------------------------------
# 

			if ( $board_config['pm_quickreply'] )
			{
				if ( !empty($board_config['pm_quickreply_smilies']) ){
			
					$template->assign_block_vars('switch_pm_quickreply_smilies', array());
				}
				
				$template->assign_block_vars('switch_pm_quickreply', array());
			}

#			
#-------[ OPEN ]-----------------------------------------------
#
language/lang_english/lang_main.php

#
#-------[ FIND ]---------------------------------------------------
#
?>

#
#-------[ BEFORE, ADD ]--------------------------------------------
#
//Advanced pm quick reply
$lang['Pm_quickreply_in'] = 'Quick Reply in Private Message';
$lang['Pm_showquickreply'] = 'Show Quick Reply in Private Message';
$lang['Pm_quickreply_bbcode'] = 'Show Buttons BBcodes in the Quick Reply';
$lang['Pm_quickreply_smilies_ed'] = 'Show Smilies in the Quick Reply';
$lang['Pm_Quick_Reply'] = 'Quick Reply';
$lang['Pm_QuoteSelelected'] = 'Quote selected';
$lang['Pm_QuoteSelelectedEmpty'] = 'Select a text anywhere on a page and try again';
$lang['Pm_smilies'] = 'All';
$lang['Pm_Disable_HTML_post'] = 'Disable HTML';
$lang['Pm_Disable_BBCode_post'] = 'Disable BBCode';
$lang['Pm_Disable_Smilies_post'] = 'Disable Smilies';
$lang['Pm_Attach_signature'] = 'Attach signature';
$lang['Pm_Options'] = 'Additional Options';

#
#-------[ OPEN ]-----------------------------------------------
#
language/lang_english/lang_admin.php

#
#-------[ FIND ]---------------------------------------------------
#
?>

#
#-------[ BEFORE, ADD ]--------------------------------------------
#
//Advandec pm quick reply
$lang['pm_quickreply'] = 'Quick Reply in Private Message';
$lang['enable_pm_quickreply'] = 'Enable/Disable Quick Reply';
$lang['pm_showquickreply'] = 'Show Quick Reply in Private Message (Default)';
$lang['pm_quickreply_bbcode'] = 'Show Buttons BBcodes in the Quick Reply (Default)';
$lang['pm_quickreply_smilies_ed'] = 'Show Smilies in the Quick Reply (Default)';
$lang['pm_quickreply_smilies'] = 'Number of smilies';
$lang['pm_quickreply_smilies_info'] = 'If you insert 0 will disable smilies for the members';

#
#-------[ OPEN ]-----------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-------[ FIND ]---------------------------------------------------
#
	<tr> 
	  <th class="thSides" colspan="2" height="25" valign="middle">{L_PREFERENCES}</th>
	</tr>
#
#-----[ AFTER, ADD ]----------------------------------------------
# 
<!-- BEGIN switch_pm_quickreply -->
	<tr> 
	  <td class="catSides" colspan="2" height="28"><span class="nav">{L_PM_QUICKREPLY_IN}</span></td>
	</tr>
	<tr>
     <td class="row1"><span class="gen">{L_PM_SHOWQUICKREPLY}:</span></td>
     <td class="row2">
      <input type="radio" name="pm_showquickreply" value="1" {PM_SHOWQUICKREPLY_YES} />
      <span class="gen">{L_YES}</span>&nbsp;&nbsp;
      <input type="radio" name="pm_showquickreply" value="0" {PM_SHOWQUICKREPLY_NO} />
      <span class="gen">{L_NO}</span>&nbsp;&nbsp;
     </td>
    </tr>
   	<tr>
      <td class="row1"><span class="gen">{L_PM_QUICKREPLY_BBCODE}:</span></td>
      <td class="row2">
       <input type="radio" name="pm_quickreply_bbcode" value="1" {PM_QUICKREPLY_BBCODE_YES} />
       <span class="gen">{L_YES}</span>&nbsp;&nbsp;
       <input type="radio" name="pm_quickreply_bbcode" value="0" {PM_QUICKREPLY_BBCODE_NO} />
       <span class="gen">{L_NO}</span>&nbsp;&nbsp;
     </td>
   </tr>
<!-- END switch_pm_quickreply -->
<!-- BEGIN switch_pm_quickreply_smilies -->
   	<tr>
      <td class="row1"><span class="gen">{L_PM_QUICKREPLY_SMILIES_ED}:</span></td>
      <td class="row2">
       <input type="radio" name="pm_quickreply_smilies_ed" value="1" {PM_QUICKREPLY_SMILIES_ED_YES} />
       <span class="gen">{L_YES}</span>&nbsp;&nbsp;
       <input type="radio" name="pm_quickreply_smilies_ed" value="0" {PM_QUICKREPLY_SMILIES_ED_NO} />
       <span class="gen">{L_NO}</span>&nbsp;&nbsp;
     </td>
   </tr>
<!-- END switch_pm_quickreply_smilies -->
<!-- BEGIN switch_pm_quickreply -->
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
<!-- END switch_pm_quickreply -->

#
#-------[ OPEN ]-----------------------------------------------
#
templates/subSilver/privmsgs_read_body.tpl

#
#-------[ FIND ]---------------------------------------------------
#
	  <td>{REPLY_PM_IMG}</td>
	  
#
#-----[ AFTER, ADD ]----------------------------------------------
# 
    </tr>
	<tr> 
		<td>{PM_QUICKREPLY_OUTPUT}</td>
	</tr>
	<tr>
#
#-------[ OPEN ]-----------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-------[ FIND ]---------------------------------------------------
#
	<tr>
		<td class="row1">{L_SENTBOX_LIMIT}</td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="max_sentbox_privmsgs" value="{SENTBOX_LIMIT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_SAVEBOX_LIMIT}</td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="max_savebox_privmsgs" value="{SAVEBOX_LIMIT}" /></td>
	</tr>
#
#-----[ AFTER, ADD ]----------------------------------------------
# 
	<tr>
		<td class="catSides" colspan="2"><span class="nav">{L_PM_QUICKREPLY}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ENABLE_PM_QUICKREPLY}</td>
		<td class="row2"><input type="radio" name="pm_quickreply" value="1" {PM_QUICKREPLY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="pm_quickreply" value="0" {PM_QUICKREPLY_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_PMSHOWQUICKREPLY}</td>
		<td class="row2"><input type="radio" name="pm_showquickreply" value="1" {PM_SHOWQUICKREPLY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="pm_showquickreply" value="0" {PM_SHOWQUICKREPLY_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_PM_QUICKREPLY_BBCODE}</td>
		<td class="row2"><input type="radio" name="pm_quickreply_bbcode" value="1" {PM_QUICKREPLY_BBCODE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="pm_quickreply_bbcode" value="0" {PM_QUICKREPLY_BBCODE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_PM_QUICKREPLY_SMILIES_ED}</td>
		<td class="row2"><input type="radio" name="pm_quickreply_smilies_ed" value="1" {PM_QUICKREPLY_SMILIES_ED_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="pm_quickreply_smilies_ed" value="0" {PM_QUICKREPLY_SMILIES_ED_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_PM_QUICKREPLY_SMILIES}<br /><span class="gensmall">{L_PM_QUICKREPLY_SMILIES_INFO}</span></td>
		<td class="row2"><input class="post" type="text" name="pm_quickreply_smilies" size="4" maxlength="4" value="{PM_QUICKREPLY_SMILIES}" /></td></tr>
	<tr>	
#
#-------[ OPEN ]-----------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-------[ FIND ]---------------------------------------------------
#
	<tr> 
	  <th class="thSides" colspan="2">{L_PREFERENCES}</th>
	</tr>	
#
#-----[ AFTER, ADD ]----------------------------------------------
# 
<!-- BEGIN switch_pm_quickreply -->
	<tr> 
	  <td class="catSides" colspan="2" height="28"><span class="nav">{L_PM_QUICKREPLY_IN}</span></td>
	</tr>
	<tr>
     <td class="row1"><span class="gen">{L_PM_SHOWQUICKREPLY}:</span></td>
     <td class="row2">
      <input type="radio" name="pm_showquickreply" value="1" {PM_SHOWQUICKREPLY_YES} />
      <span class="gen">{L_YES}</span>&nbsp;&nbsp;
      <input type="radio" name="pm_showquickreply" value="0" {PM_SHOWQUICKREPLY_NO} />
      <span class="gen">{L_NO}</span>&nbsp;&nbsp;
     </td>
   </tr>
   	<tr>
     <td class="row1"><span class="gen">{L_PM_QUICKREPLY_BBCODE}:</span></td>
     <td class="row2">
      <input type="radio" name="pm_quickreply_bbcode" value="1" {PM_QUICKREPLY_BBCODE_YES} />
      <span class="gen">{L_YES}</span>&nbsp;&nbsp;
      <input type="radio" name="pm_quickreply_bbcode" value="0" {PM_QUICKREPLY_BBCODE_NO} />
      <span class="gen">{L_NO}</span>&nbsp;&nbsp;
     </td>
   </tr>
 <!-- END switch_pm_quickreply -->
<!-- BEGIN switch_pm_quickreply_smilies -->
   	<tr>
     <td class="row1"><span class="gen">{L_PM_QUICKREPLY_SMILIES_ED}:</span></td>
     <td class="row2">
      <input type="radio" name="pm_quickreply_smilies_ed" value="1" {PM_QUICKREPLY_SMILIES_ED_YES} />
      <span class="gen">{L_YES}</span>&nbsp;&nbsp;
      <input type="radio" name="pm_quickreply_smilies_ed" value="0" {PM_QUICKREPLY_SMILIES_ED_NO} />
      <span class="gen">{L_NO}</span>&nbsp;&nbsp;
     </td>
   </tr>
<!-- END switch_pm_quickreply_smilies -->
<!-- BEGIN switch_pm_quickreply -->
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
<!-- END switch_pm_quickreply -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 