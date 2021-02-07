############################################################## 
## MOD Title: Remove Users Signature & Editing Privileges
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/ 
## MOD Description: Will allow ADMIN to remove signature & post editing priviliges to specific users
## MOD Version: 1.0.2
## 
## Installation Level: Easy 
## Installation Time: 3 Minutes (less than one with the great EasyMOD! :-) 
## Files To Edit:	admin/admin_users.php
##			includes/usercp_register.php
##			language/lang_english/lang_admin.php
##			language/lang_english/lang_main.php
##			posting.php
##			viewtopic.php
##			viewforum.php
##			templates/subSilver/admin/user_edit_body.tpl
##			templates/subSilver/profile_add_body.tpl
## Included Files:	n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	This MOD will add two options in ACP/Users management so you can remove signature/post editing
##	priviliges for specific users. Removing signature will make them unable to edit their signature in
##	their profile, and their signature won't show up in any new posts they have or will make.
##	Removing post editing privileges will make them unable to edit their posts.
############################################################## 
## MOD History: 
## 
##   2004-10-29 - Version 1.0.2
##	- Fixed: when users used the preview option when posting, it removed the signature from the post
##
##   2004-09-01 - Version 1.0.1
##	- Some minor changes to the MOD
##
##   2004-08-24 - Version 1.0.0
##	- Submitted to phpBB's MODDB 
##
##   2004-07-14 - Version 0.0.1 [BETA]
##	- First version, should work just fine ;) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


# 
#-----[ SQL ]----- 
# 
ALTER TABLE `phpbb_users` ADD `user_allowsig` TINYINT( 1 ) DEFAULT '1' NOT NULL
# 
#-----[ SQL ]----- 
# 
ALTER TABLE `phpbb_users` ADD `user_allowedit` TINYINT( 1 ) DEFAULT '1' NOT NULL
# 
#-----[ OPEN ]----- 
# 
admin/admin_users.php
# 
#-----[ FIND ]----- 
# 
		$user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;
# 
#-----[ AFTER, ADD ]----- 
# 
		//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
		$user_allowsig = ( !empty($HTTP_POST_VARS['user_allowsig']) ) ? intval( $HTTP_POST_VARS['user_allowsig'] ) : 0;
		$user_allowedit = ( !empty($HTTP_POST_VARS['user_allowedit']) ) ? intval( $HTTP_POST_VARS['user_allowedit'] ) : 0;
		//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ FIND ]----- 
#
			$sql = "UPDATE " . USERS_TABLE . "
# 
#-----[ BEFORE, ADD ]----- 
# 
		//MOD-REPLACE: Remove Users Signature & Editing Privileges --------------------------------------
		//added: , user_allowsig = $user_allowsig, user_allowedit = $user_allowedit
# 
#-----[ FIND ]----- 
#
#Note: full line longer
				SET " . $username_sql . $passwd_sql . "user_email
# 
#-----[ IN-LINE FIND ]----- 
# 
. $avatar_sql . "
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
, user_allowsig = $user_allowsig, user_allowedit = $user_allowedit
# 
#-----[ FIND ]----- 
# 
		$user_allowpm = $this_userdata['user_allow_pm'];
# 
#-----[ AFTER, ADD ]----- 
# 
		//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
		$user_allowsig = $this_userdata['user_allowsig'];
		$user_allowedit = $this_userdata['user_allowedit'];
		//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ FIND ]----- 
# 
			'RANK_SELECT_BOX' => $rank_select_box,
# 
#-----[ AFTER, ADD ]----- 
# 
			//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
			'ALLOW_SIG_YES' => ($user_allowsig) ? 'checked="checked"' : '',
			'ALLOW_SIG_NO' => (!$user_allowsig) ? 'checked="checked"' : '',
			'ALLOW_EDIT_YES' => ($user_allowedit) ? 'checked="checked"' : '',
			'ALLOW_EDIT_NO' => (!$user_allowedit) ? 'checked="checked"' : '',
			//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ FIND ]----- 
# 
			'L_ALLOW_AVATAR' => $lang['User_allowavatar'],
# 
#-----[ AFTER, ADD ]----- 
# 
			//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
			'L_ALLOW_SIG' => $lang['User_allowsig'],
			'L_ALLOW_EDIT' => $lang['User_allowedit'],
			//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ OPEN ]----- 
# 
includes/usercp_register.php
# 
#-----[ FIND ]----- 
# 
		$s_hidden_fields .= '<input type="hidden" name="current_email" value="' . $userdata['user_email'] . '" />';
# 
#-----[ AFTER, ADD ]----- 
# 
		//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
		if (!$userdata['user_allowsig'])
		{
			$s_hidden_fields .= '<input type="hidden" name="signature" value="' . $userdata['user_sig'] . '" />';
			$s_hidden_fields .= '<input type="hidden" name="attachsig" value="' . $userdata['user_attachsig'] . '" />';
		}
		//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ FIND ]----- 
# 
	//
	// This is another cheat using the block_var capability
	// of the templates to 'fake' an IF...ELSE...ENDIF solution
	// it works well :)
	//
# 
#-----[ BEFORE, ADD ]----- 
# 
	//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
	if ($userdata['user_allowsig'])
	{
		$template->assign_block_vars('switch_signature', array());
	}
	//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------


# 
#-----[ OPEN ]----- 
# 
language/lang_english/lang_admin.php
# 
#-----[ FIND ]----- 
# 
$lang['User_allowavatar'] = 'Can display avatar';
# 
#-----[ AFTER, ADD ]----- 
# 
//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
$lang['User_allowsig'] = 'Can display signature';
$lang['User_allowedit'] = 'Can edit their posts';
//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ OPEN ]----- 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]----- 
# 
//
// That's all, Folks!
# 
#-----[ BEFORE, ADD ]----- 
# 
//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
$lang['Lost_postediting'] = 'Sorry but you have lost your post editing priviliges.';
//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------


# 
#-----[ OPEN ]----- 
# 
posting.php
# 
#-----[ FIND ]----- 
# 
#Note: full line longer
		$select_sql = ( !$submit ) ? ", t.topic_title, p.enable_bbcode
# 
#-----[ BEFORE, ADD ]----- 
# 
		//MOD-REPLACE: Remove Users Signature & Editing Privileges --------------------------------------
		//added: , u.user_allowsig
# 
#-----[ IN-LINE FIND ]----- 
# 
u.user_sig
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
, u.user_allowsig
# 
#-----[ FIND ]----- 
# 
	redirect(append_sid("login.$phpEx?redirect=posting.$phpEx&" . $redirect, true));
}
# 
#-----[ AFTER, ADD ]----- 
# 
//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
if ( ($mode=='editpost') && !($userdata['user_allowedit']) && ($userdata['user_level'] != ADMIN) )
{
	message_die(GENERAL_MESSAGE, $lang['Lost_postediting']);
}
//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------

# 
#-----[ FIND ]----- 
# 
#Note: full line longer
		$user_sig = ( $userdata['user_sig'] != ''
# 
#-----[ BEFORE, ADD ]----- 
# 
		//MOD-REPLACE: Remove Users Signature & Editing Privileges --------------------------------------
		//added: && $userdata['user_allowsig']
# 
#-----[ IN-LINE FIND ]----- 
# 
$board_config['allow_sig']
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
&& $userdata['user_allowsig']
# 
#-----[ FIND ]----- 
# 
#Note: full line longer
		$user_sig = ( $post_info['user_sig'] != ''
# 
#-----[ BEFORE, ADD ]----- 
# 
		//MOD-REPLACE: Remove Users Signature & Editing Privileges --------------------------------------
		//added: && $userdata['user_allowsig']
# 
#-----[ IN-LINE FIND ]----- 
# 
$board_config['allow_sig']
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
&& $userdata['user_allowsig']
# 
#-----[ FIND ]----- 
# 
		$user_sig = ( $userdata['user_sig'] != '' ) ? $userdata['user_sig'] : '';
# 
#-----[ AFTER, ADD ]----- 
# 
		//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
		$user_allowsig = $userdata['user_allowsig'];
		//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ FIND ]----- 
# 
		$user_sig = ( $userdata['user_sig'] != '' ) ? $userdata['user_sig'] : '';
# 
#-----[ AFTER, ADD ]----- 
# 
		//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
		$user_allowsig = $userdata['user_allowsig'];
		//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ FIND ]----- 
# 
			$user_sig = $post_info['user_sig'];

# 
#-----[ AFTER, ADD ]----- 
# 
			//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
			$user_allowsig = $post_info['user_allowsig'];
			//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ FIND ]----- 
# 
			$user_sig = $userdata['user_sig'];
# 
#-----[ AFTER, ADD ]----- 
# 
			//MOD-BEGIN: Remove Users Signature & Editing Privileges ----------------------------------------
			$user_allowsig = $userdata['user_allowsig'];
			//MOD-END: Remove Users Signature & Editing Privileges ------------------------------------------
# 
#-----[ FIND ]----- 
# 
// Signature toggle selection
//
if( $user_sig != '' )
# 
#-----[ REPLACE WITH ]----- 
# 
// Signature toggle selection
//
//MOD-REPLACE: Remove Users Signature & Editing Privileges ----------------------------------------
//added: && $user_allowsig
if( $user_sig != '' && $userdata['user_allowsig'] )
# 
#-----[ OPEN ]----- 
# 
viewtopic.php
# 
#-----[ FIND ]----- 
# 
#Note: full line longer
$sql = "SELECT u.username, u.user_id, u.user_posts,
# 
#-----[ BEFORE, ADD ]----- 
# 
//MOD-REPLACE: Remove Users Signature & Editing Privileges ----------------------------------------
//added: , u.user_allowsig
# 
#-----[ IN-LINE FIND ]----- 
# 
u.user_allowsmile
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
, u.user_allowsig
# 
#-----[ FIND ]----- 
# 
$s_auth_can .= ( ( $is_auth['auth_edit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
# 
#-----[ REPLACE WITH ]----- 
# 
//MOD-REPLACE: Remove Users Signature & Editing Privileges ----------------------------------------
//added: && $userdata['user_allowedit']
$s_auth_can .= ( ( $is_auth['auth_edit'] && $userdata['user_allowedit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
# 
#-----[ FIND ]----- 
# 
	if ( ( $userdata['user_id'] == $poster_id && $is_auth['auth_edit'] ) || $is_auth['auth_mod'] )
# 
#-----[ REPLACE WITH ]----- 
# 
	//MOD-REPLACE: Remove Users Signature & Editing Privileges ----------------------------------------
	//added: $userdata['user_allowedit'] && (  .... )
	if ( $userdata['user_allowedit'] && (( $userdata['user_id'] == $poster_id && $is_auth['auth_edit'] ) || $is_auth['auth_mod']) )
# 
#-----[ FIND ]----- 
# 
#Note: full line longer
	$user_sig = ( $postrow[$i]['enable_sig'] && $postrow[$i]['user_sig'] != ''
# 
#-----[ BEFORE, ADD ]----- 
# 
	//MOD-REPLACE: Remove Users Signature & Editing Privileges ----------------------------------------
	//added: && $postrow[$i]['user_allowsig']
# 
#-----[ IN-LINE FIND ]----- 
# 
$board_config['allow_sig']
# 
#-----[ IN-LINE AFTER, ADD ]----- 
# 
 && $postrow[$i]['user_allowsig']
# 
#-----[ OPEN ]----- 
# 
viewforum.php
# 
#-----[ FIND ]----- 
# 
$s_auth_can .= ( ( $is_auth['auth_edit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
# 
#-----[ REPLACE WITH ]----- 
# 
//MOD-REPLACE: Remove Users Signature & Editing Privileges ----------------------------------------
//added: && $userdata['user_allowedit']
$s_auth_can .= ( ( $is_auth['auth_edit'] && $userdata['user_allowedit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/admin/user_edit_body.tpl
# 
#-----[ FIND ]----- 
# 
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_AVATAR}</span>
# 
#-----[ FIND ]----- 
# 
	</tr>
# 
#-----[ AFTER, ADD ]----- 
# 
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_SIG}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allowsig" value="1" {ALLOW_SIG_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allowsig" value="0" {ALLOW_SIG_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_EDIT}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allowedit" value="1" {ALLOW_EDIT_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allowedit" value="0" {ALLOW_EDIT_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/profile_add_body.tpl
# 
#-----[ FIND ]----- 
# 
	<tr> 
	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span>
# 
#-----[ BEFORE, ADD ]----- 
# 
	<!-- BEGIN switch_signature -->
# 
#-----[ FIND ]----- 
# 
	</tr>
# 
#-----[ AFTER, ADD ]----- 
# 
	<!-- END switch_signature -->
# 
#-----[ FIND ]----- 
# 
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ADD_SIGNATURE}:</span>
# 
#-----[ BEFORE, ADD ]----- 
# 
	<!-- BEGIN switch_signature -->
# 
#-----[ FIND ]----- 
# 
	</tr>
# 
#-----[ AFTER, ADD ]----- 
# 
	<!-- END switch_signature -->
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 