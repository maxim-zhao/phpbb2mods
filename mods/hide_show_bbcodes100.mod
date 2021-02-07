############################################################## 
## MOD Title: Hide/Show BBcode menu when posting a topic 
## MOD Author: danb00 < extreme[at]extremephpbb[dot]com > (Daniel) N/A 
## MOD Description: Lets users choose to see BBcode menu when posting a topic 
## MOD Version: 1.0.0 
## 
## Installation Level: (Intermediate) 
## Installation Time: ~15-20 Minutes 
## Files To Edit: 
##               includes/ucercp_register.php 
##               language/lang_english/lang_main.php 
##               admin/admin_users.php
##               templates/subSilver/admin/user_edit_body.tpl
##               templates/subSilver/profile_add_body.tpl
##               templates/subSilver/viewtopic_body.tpl
## Included Files: (N/A) 
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: N/A
## 
##############################################################
## MOD History: 
## 
##   2005-06-20 - Version 0.1.0 
##      - Initial Release (.MOD Re-Written by Afterlife_69)
##   2005-06-29 - Version 1.0.0 
##      - Final Release Added to MODDB
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ SQL ]------------------------------------------ 
#
ALTER TABLE `phpbb_users` ADD `user_showbbcode` TINYINT( 1 ) DEFAULT '1' NOT NULL 


# 
#-----[ OPEN ]------------------------------------------ 
#
includes/usercp_register.php

# 
#-----[ FIND ]------------------------------------------ 
#
$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $board_config['allow_smilies'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$showbbcode = ( isset($HTTP_POST_VARS['showbbcode']) ) ? ( ($HTTP_POST_VARS['showbbcode']) ? TRUE : 0 ) : TRUE; 

# 
#-----[ FIND ]------------------------------------------ 
#
$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $userdata['user_allowsmile'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$showbbcode = ( isset($HTTP_POST_VARS['showbbcode']) ) ? ( ($HTTP_POST_VARS['showbbcode']) ? TRUE : 0 ) : $userdata['user_showbbcode'];

# 
#-----[ FIND ]------------------------------------------ 
#
$sql = "UPDATE " . USERS_TABLE . "
	SET

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
user_allowsmile = $allowsmilies,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 user_showbbcode = $showbbcode,

# 
#-----[ FIND ]------------------------------------------ 
#
// Get current date
//
$sql = "INSERT INTO "

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
user_allowsmile,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 user_showbbcode,

# 
#-----[ FIND ]------------------------------------------ 
#
VALUES ($user_id,

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
$allowsmilies,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 $showbbcode,

# 
#-----[ FIND ]------------------------------------------ 
#
$allowsmilies = $userdata['user_allowsmile'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$showbbcode = $userdata['user_showbbcode'];

# 
#-----[ FIND ]------------------------------------------ 
#
'ALWAYS_ALLOW_SMILIES_NO' => ( !$allowsmilies ) ? 'checked="checked"' : '',

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
'SHOW_BBCODE_YES' => ( $showbbcode ) ? 'checked="checked"' : '',
'SHOW_BBCODE_NO' => ( !$showbbcode ) ? 'checked="checked"' : '',

# 
#-----[ FIND ]------------------------------------------ 
#
'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
'L_SHOW_BBCODE' => $lang['SHOW_BBCODE'],

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
#
//
// That's all, Folks!
//

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
$lang['SHOW_BBCODE'] = 'Show BBcode in posting mode';

# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_users.php

# 
#-----[ FIND ]------------------------------------------ 
#
$allowsmilies = ( isset( $HTTP_POST_VARS['allowsmilies']) ) ? intval( $HTTP_POST_VARS['allowsmilies'] ) : $board_config['allow_smilies'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$showbbcode = ( isset( $HTTP_POST_VARS['showbbcode']) ) ? intval( $HTTP_POST_VARS['showbbcode'] ) : $board_config['showbbcode'];

# 
#-----[ FIND ]------------------------------------------ 
#
$sql = "UPDATE " . USERS_TABLE . "
	SET

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
user_allowsmile = $allowsmilies,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
 user_showbbcode = $showbbcode,

# 
#-----[ FIND ]------------------------------------------ 
#
$allowsmilies = $this_userdata['user_allowsmile'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$showbbcode = $this_userdata['user_showbbcode'];

# 
#-----[ FIND ]------------------------------------------ 
#
$s_hidden_fields .= '<input type="hidden" name="allowsmilies" value="' . $allowsmilies . '" />';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$s_hidden_fields .= '<input type="hidden" name="showbbcode" value="' . $showbbcode . '" />';

# 
#-----[ FIND ]------------------------------------------ 
#
'ALWAYS_ALLOW_SMILIES_NO' => (!$allowsmilies) ? 'checked="checked"' : '',

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
'SHOW_BBCODE_YES' => ($showbbcode) ? 'checked="checked"' : '',
'SHOW_BBCODE_NO' => (!$showbbcode) ? 'checked="checked"' : '',

# 
#-----[ FIND ]------------------------------------------ 
#
'L_ALWAYS_ALLOW_SMILIES' => $lang['Always_smile'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
'L_SHOW_BBCODE' => $lang['SHOW_BBCODE'],

# 
#-----[ OPEN ]------------------------------------------ 
#
posting.php

# 
#-----[ FIND ]------------------------------------------ 
#
//
// End session management
//

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
if ( $userdata['user_showbbcode'] )
{
	$template->assign_block_vars('switch_showbbcode', array());
}

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/admin/user_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<tr>
		<td class="row1"><span class="gen">{L_SHOW_BBCODE}:</span></td>
		<td class="row2">
			<input type="radio" name="showbbcode" value="1" {SHOW_BBCODE_YES} />
			<span class="gen">{L_YES}</span>
			<input type="radio" name="showbbcode" value="0" {SHOW_BBCODE_NO} />
			<span class="gen">{L_NO}</span></td>
	</tr>

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
   <tr>
      <td class="row1"><span class="gen">{L_SHOW_BBCODE}:</span></td>
      <td class="row2">
         <input type="radio" name="showbbcode" value="1" {SHOW_BBCODE_YES} />
         <span class="gen">{L_YES}</span>&nbsp;&nbsp; 
         <input type="radio" name="showbbcode" value="0" {SHOW_BBCODE_NO} />
         <span class="gen">{L_NO}</span></td>
   </tr>


# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="b"

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
<!-- BEGIN switch_showbbcode -->

# 
#-----[ FIND ]------------------------------------------ 
#
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="{L_STYLES_TIP}" />
			  </span></td>
		  </tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
<!-- END switch_showbbcode -->

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM