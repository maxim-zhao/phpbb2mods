############################################################## 
## MOD Title: Memberlist Hidden User MOD
## MOD Author: N3cr0shark <hammerhead@columbus.rr.com> (N/A) N/A 
## MOD Description: Adds the ability to hide users in the Memberslist via ACP 'Manage User'
## MOD Version:  1.0.0
## 
## Installation Level: Intermediate
## Installation Time: 5 Minutes 
## Files To Edit: (4)
##          memberlist.php 
##          language/lang_english/lang_admin.php
##	    admin/admin_users.php 
##	    templates/Solaris/admin/user_edit_body.tpl
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## It has been tested successfully on PHPBB Version 2.0.6.
## Feel free to edit and use.
############################################################## 
## MOD History:
##
##     2004-01-07 - version 1.0.0   
##        - First release.
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]-------------------------------------------------
#
ALTER TABLE phpbb_users ADD show_in_memberlist TINYINT(1) NULL Default(1);

#
#-----[ OPEN ]-----------------------------------------
#
memberlist.php

#
#-----[ FIND ]-----------------------------------------
#
$sql = "SELECT username, user_id, user_viewemail, user_posts, user_regdate, user_from, user_website, user_email, user_icq, user_aim, user_yim, user_msnm, user_avatar, user_avatar_type, user_allowavatar
        FROM " . USERS_TABLE . " 
        WHERE user_id <> " . ANONYMOUS . "
#
#-----[ AFTER, ADD ]-----------------------------------------
#
          and show_in_memberlist <> 0
// Memberlist Hidden User MOD

#
#-----[ FIND ]-----------------------------------------
#
        $sql = "SELECT count(*) AS total
                FROM " . USERS_TABLE . "
                WHERE user_id <> " . ANONYMOUS;

#
#-----[ AFTER, ADD ]-----------------------------------------

                  and show_in_memberlist <> 0";
// Memberlist Hidden User MOD

#
#-----[ OPEN ]-----------------------------------------
#

language/lang_english/lang_admin.php

#
#-----[ FIND ]-----------------------------------------
#
//
// User Management
//

#
#-----[ AFTER, ADD ]-----------------------------------------
#
// Memberlist Hidden User MOD BEGIN
$lang['User_hide_memberlist'] = 'User is viewable in Memberslist';
// Memberlist Hidden User MOD END

#
#-----[ OPEN ]-----------------------------------------
#

admin/admin_users.php 

#
#-----[ FIND ]-----------------------------------------
#
                $user_status = ( !empty($HTTP_POST_VARS['user_status']) ) ? intval( $HTTP_POST_VARS['user_status'] ) : 0;

#
#-----[ AFTER, ADD ]-----------------------------------------
#
// Memberlist Hidden User MOD BEGIN
                $user_hide_memberlist = ( !empty($HTTP_POST_VARS['user_hide_memberlist']) ) ? intval( $HTTP_POST_VARS['user_hide_memberlist'] ) : 0;
// Memberlist Hidden User MOD END

#
#-----[ FIND ]-----------------------------------------
#
                                SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", $aim) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_sig_bbcode_uid = '$signature_bbcode_uid', user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowavatar = $user_allowavatar, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_allow_pm = $user_allowpm, user_notify_pm = $notifypm, user_popup_pm = $popuppm, user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_timezone = $user_timezone, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_active = $user_status, user_rank = $user_rank" . $avatar_sql . "

#
#-----[ IN-LINE FIND ]-----------------------------------------
#
user_active = $user_status,

#
#-----[ IN-LINE AFTER, ADD ]-----------------------------------------
#
 show_in_memberlist = $user_hide_memberlist,

#
#-----[ FIND ]-----------------------------------------
#
                $user_status = $this_userdata['user_active'];

#
#-----[ AFTER, ADD ]-----------------------------------------
#
// Memberlist Hidden User MOD BEGIN
                $user_hide_memberlist = $this_userdata['show_in_memberlist'];
// Memberlist Hidden User MOD END

#
#-----[ FIND ]-----------------------------------------
#
                        $s_hidden_fields .= '<input type="hidden" name="user_status" value="' . $user_status . '" />';

#
#-----[ AFTER, ADD ]-----------------------------------------
#
// Memberlist Hidden User MOD BEGIN
                        $s_hidden_fields .= '<input type="hidden" name="user_hide_memberlist" value="' . $user_hide_memberlist . '" />';
// Memberlist Hidden User MOD END

#
#-----[ FIND ]-----------------------------------------
#
                        'USER_ACTIVE_NO' => (!$user_status) ? 'checked="checked"' : '', 

#
#-----[ AFTER, ADD ]-----------------------------------------
#
// Memberlist Hidden User MOD BEGIN
                        'USER_HIDE_MEMBERLIST_YES' => ($user_hide_memberlist) ? 'checked="checked"' : '',
                        'USER_HIDE_MEMBERLIST_NO' => (!$user_hide_memberlist) ? 'checked="checked"' : '', 
// Memberlist Hidden User MOD END

#
#-----[ FIND ]-----------------------------------------
#
                        'L_USER_ACTIVE' => $lang['User_status'],

#
#-----[ AFTER, ADD ]-----------------------------------------
#
// Memberlist Hidden User MOD BEGIN
                        'L_USER_HIDE_MEMBERLIST' => $lang['User_hide_memberlist'],
// Memberlist Hidden User MOD END

#
#-----[ OPEN ]-----------------------------------------
#

templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_USER_ACTIVE}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_status" value="1" {USER_ACTIVE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_status" value="0" {USER_ACTIVE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ AFTER, ADD ]-----------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_USER_HIDE_MEMBERLIST}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_hide_memberlist" value="1" {USER_HIDE_MEMBERLIST_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_hide_memberlist" value="0" {USER_HIDE_MEMBERLIST_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
# 
# EoM
