############################################################## 
## MOD Title: User gag
## MOD Author: Swizec < swizec@randy-comic.com > (N/A) http://www.randy-comic.com
## MOD Description: By choosing a particular user you make that user see all posts in binary code.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: ~5 Minutes 
## Files To Edit: 
##		viewtopic.php
##		includes/functions.php
##		admin/admin_users.php
##		templates/subSilver/admin/user_edit_body.tpl
##		language/lang_english/lang_admin.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## 
############################################################## 
## MOD History: 
## 
## 
##   2005-03-02 - Version 0.0.1
##	- first try
##
##   2005-05-31 - Version 1.0.1
##	- submitted, resubmitted and submitted again :)
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 

ALTER TABLE `phpbb_users` ADD `user_binary` TINYINT( 1 ) DEFAULT '0' NOT NULL ;

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 

'MESSAGE' => $message,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod txt2binary changed line a bit

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$message

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

( !$userdata['user_binary'] ) ? $message : txt2bin( $message )

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions.php

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod txt2binary add
// mod txt2binary add
function txt2bin( $str ) {
	
	$text_array = explode("\r\n", chunk_split($str, 1));
	for ($n = 0; $n < count($text_array) - 1; $n++) {
		$newstring .= substr("0000".base_convert(ord($text_array[$n]), 10, 2), -8) . ' ';
		if ( ( $n / 12 ) == round( $n / 12 ) ) $newstring .= '<br />';
	}
	
	return $newstring;
}

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$user_status = ( !empty($HTTP_POST_VARS['user_status'])

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod txt2binary add
$user_binary = ( !empty( $HTTP_POST_VARS['user_binary'] ) ) ? intval(  $HTTP_POST_VARS['user_binary'] ) : 0;

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "UPDATE " . USERS_TABLE . "

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod txt2binary change sql

# 
#-----[ FIND ]------------------------------------------ 
# 

user_allowavatar = $user_allowavatar,

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$user_allowavatar, 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

user_binary = $user_binary, 

# 
#-----[ FIND ]------------------------------------------ 
# 

$user_status = $this_userdata['user_active'];

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod txt2binary add
$user_binary = $this_userdata['user_binary'];

# 
#-----[ FIND ]------------------------------------------ 
# 

$s_hidden_fields .= '<input type="hidden" name="user_rank" value="' . $user_rank . '" />';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod txt2binary add
$s_hidden_fields .= '<input type="hidden" name="user_binary" value="' . $user_binary . '" />';

# 
#-----[ FIND ]------------------------------------------ 
# 

'ALLOW_AVATAR_NO' => (!$user_allowavatar) ? 'checked="checked"' : '',

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod txt2binary add
'BINARY_YES' => ( $user_binary ) ? 'checked="checked"' : '',
'BINARY_NO' => ( !$user_binary ) ? 'checked="checked"' : '',
// mod txt2binary end

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_ALLOW_AVATAR' => $lang['User_allowavatar'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod txt2binary add
'L_BINARY' => $lang['User_binary'],

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/user_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

		<input type="radio" name="user_allowavatar" value="0" {ALLOW_AVATAR_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	<tr> 
	  <td class="row1"><span class="gen">{L_BINARY}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_binary" value="1" {BINARY_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_binary" value="0" {BINARY_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

# 
#-----[ OPEN ]------------------------------------------ 
# 
	
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['User_allowavatar'] =

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod txt2binary add
$lang['User_binary'] = 'Sees all posts in binary code';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 