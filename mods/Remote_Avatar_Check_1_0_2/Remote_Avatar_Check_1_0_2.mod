##############################################################
## MOD Title: Remote Avatar Check
## MOD Author: darklordsatan < N/A > (N/A) N/A
## MOD Description: This mod basically performs three checks over a remote avatar.
##                  1. Checks if the image exists
##                  2. Checks if the image filesize isn't bigger than the one configured at the ACP.
##                  3. Checks if the image dimensions aren't bigger than the ones configured at the ACP.
##                  Aditionally, it returns an error message in case of failure for any of the aforementioned
##                  scenarios.
## MOD Version: 1.0.2
##
## Installation Level: (Easy)
## Installation Time: 2 Minutes
## Files To Edit: includes/usercp_avatar.php
##                language/lang_english/lang_main.php
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: The mod is designed with a fresh phpBB installation in mind.
##               If you already have your board running, likely you'll find this mod useless. The reason
##               is simple: It doesnt try to check already configured avatars, but new ones to be set by
##               the members in their profile panel.
##               However, if you still want to use this mod, I'd recommend to make a global announcement
##               informing your users, their avatars will be removed to ensure compliance with the rules
##               (this is a potential reason to upset members who already comply with them), then
##               proceed to manually remove all the avatars, by means of a simple SQL query
##               UPDATE `phpbb_users` SET user_avatar = '' WHERE 1;
##
##############################################################
## MOD History:
##
##   2005-10-14 - Version 1.0.0
##      - Release of the first version
##
##   2005-10-22 - Version 1.0.1
##      - Minor code fixes/additions in order to resubmit the mod at the phpBB MOD database
##
##   2006-02-17 - Version 1.0.2
##      - The mod is compliant with the latest phpBB release (2.0.19)
##      - Fixed a nasty bug where a huge remote image could potentially arise a script execution timeout error
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php

#
#-----[ FIND ]------------------------------------------
#
return ( $mode == 'editprofile' ) ? ", user_avatar = '" . str_replace("\'", "''", $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_REMOTE : '';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// Start Remote Avatar Check Mod
	global $board_config;
	
	$remote_file = @fopen ($avatar_filename, "rb");
	
	if(!$remote_file)
	{
		$error = true;
		$error_msg = sprintf($lang['Remote_avatar_no_image'], $avatar_filename);
		return;
	}
	
	$user_avatar_size = 0;
	do
	{
		if (strlen(@fread($remote_file, 1)) == 0 || $user_avatar_size > $board_config['avatar_filesize'])
		{
			break;
		}
		$user_avatar_size ++;
	}
	while(true);
	@fclose($remote_file);
  
	if($user_avatar_size > $board_config['avatar_filesize'])
	{
		$error = true;
		$error_msg = sprintf($lang['Remote_avatar_error_filesize'], $board_config['avatar_filesize']);
		return;
	}
  
	list($user_avatar_width, $user_avatar_height) = @getimagesize($avatar_filename);
	
	if($user_avatar_width > $board_config['avatar_max_width'] || $user_avatar_height > $board_config['avatar_max_height'])
	{
		$error = true;
		$error_msg = sprintf($lang['Remote_avatar_error_dimension'], $board_config['avatar_max_width'], $board_config['avatar_max_height']);
		return;
	}
	// End Remote Avatar Check Mod

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Start Remote Avatar Check Mod
$lang['Remote_avatar_no_image'] = 'The image %s doesnt exist';
$lang['Remote_avatar_error_filesize'] = 'The image is over the size limit for avatars (%d Bytes)';
$lang['Remote_avatar_error_dimension'] = 'The image is over the dimension limit for avatars (%d x %d)';
// End Remote Avatar Check Mod

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM