##############################################################
## MOD Title: Avatar Check
## MOD Author: Kieran007 < kieran@kieranoshea.com > ( Kieran O'Shea ) http://www.kieranoshea.com
## MOD Description: Checks to see if an avatar is loadable, and if not loads a local default one instead
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
##
## Files To Edit: viewtopic.php,
##	  		includes/functions.php,
##			includes/usercp_viewprofile.php,
##	  		tenplates/subSilver/subSilver.cfg
## Included Files: templates/subSilver/images/no_avatar.gif
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
##      This MOD checks the URL of users external avatars to see
##	  if it can be loaded. If their server is down or the image
##	  doesn't exist, then a "default" avatar is loaded in its
##	  place. This prevents slow loading of forum pages when 
##	  user(s) avatar(s) don't load.
##
##############################################################
## MOD History:
##
##   2006-04-16 - Version 1.0.0
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy templates/subSilver/images/default_offsite_avatar.gif to templates/subSilver/images/default_offsite_avatar.gif
# 
#-----[ OPEN ]--------------------------------------------- 
# 
includes/functions.php
#
#-----[ FIND ]---------------------------------------------
# Line 47
	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . $server_protocol . $server_name . $server_port . $script_name . $url);
	exit;
}
#
#-----[ AFTER, ADD ]---------------------------------------------
#
//
// Function to check the existance of a remote avatar
//

function check_avatar($addr) 
	{
		$to = 0.3;
		preg_match('/^http:\/\/([^\/]*)(.*)$/i', trim($addr), $m);
		$host = $m[1];
		$target = $m[2];
		if (trim($target) == '') 
		{
			$target = '/';
		}
   
		$fp = @fsockopen ($host, 80, $errno, $errstr, $to);
   
		$res = '';
		if (!$fp) 
		{
			return (FALSE);
		} 
		else 
		{
			@fclose ($fp);
			if (@fclose(@fopen("$addr", "r"))) 
			{
				return (TRUE);
		 	}
		 	else 
			{
		 		return (FALSE);
			}
    		}
	}
# 
#-----[ OPEN ]--------------------------------------------- 
# 
includes/usercp_viewprofile.php
#
#-----[ FIND ]---------------------------------------------
# Line 196
	switch( $profiledata['user_avatar_type'] )
	{
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_REMOTE: 
#
#-----[ AFTER, ADD ]---------------------------------------------
#
			//
			// Now check the specific avatar to make sure it exists off-site
			//

			$avatar_url = $profiledata['user_avatar'];

			$avatar_status = check_avatar($avatar_url);
			if ($avatar_status === FALSE)
			{
     				$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $phpbb_root_path . $images['default_offsite_avatar'] . '" alt="" border="0" />' : '';
			}
			else if ($avatar_status === TRUE)
			{ 
#
#-----[ FIND ]---------------------------------------------
# Line 196
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
#
#-----[ REPLACE WITH ]---------------------------------------------
#
				$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $avatar_url . '" alt="" border="0" />' : '';
			}
# 
#-----[ OPEN ]--------------------------------------------- 
# 
viewtopic.php
#
#-----[ FIND ]---------------------------------------------
# Line 196
		switch( $postrow[$i]['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE: 
#
#-----[ AFTER, ADD ]---------------------------------------------
#
				//
				// Now check the specific avatar to make sure it exists off-site
				//

				$avatar_url = $postrow[$i]['user_avatar'];

				$avatar_status = check_avatar($avatar_url);
				if ($avatar_status === FALSE)
				{
     					$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $phpbb_root_path . $images['default_offsite_avatar'] . '" alt="" border="0" />' : '';
				}
				else if ($avatar_status === TRUE)
				{ 
#
#-----[ FIND ]---------------------------------------------
# Line 196
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
#
#-----[ REPLACE WITH ]---------------------------------------------
#
					$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $avatar_url . '" alt="" border="0" />' : '';
				}
# 
#-----[ OPEN ]--------------------------------------------- 
# 
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]---------------------------------------------
# Line 196
//
// Vote graphic length defines the maximum length of a vote result
// graphic, ie. 100% = this length
//
$board_config['vote_graphic_length'] = 205;
$board_config['privmsg_graphic_length'] = 175; 
#
#-----[ AFTER, ADD ]---------------------------------------------
#
// Default avatar for users who's off-site one doesn't load or times out
$images['default_offsite_avatar']	= "$current_template_images/default_offsite_avatar.gif";
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM