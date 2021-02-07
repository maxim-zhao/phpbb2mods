##############################################################
## MOD Title: Remote Avatar Resize
## MOD Author: tomlevens < tom@tomlevens.co.uk > (Tom Levens) N/A
## MOD Description: This MOD automatically scales down a user's remotely hosted avatar if it is larger than the maximum size set in the admin panel. 
## MOD Version: 2.0.2
## 
## Installation Level: Intermediate
## Installation Time: 25 Minutes 
## Files To Edit: groupcp.php
##                memberlist.php
##                viewtopic.php 
##                admin/admin_board.php
##                admin/admin_users.php
##                includes/functions.php
##                includes/usercp_avatar.php
##                includes/usercp_register.php
##                includes/usercp_viewprofile.php
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
#############################################################
## Author Notes: 
##
##  This MOD automatically scales down a user's remotely hosted avatar if it is 
##  larger than the maximum size set in the admin panel. It does so by storing 
##  the dimensions of the image in the database when the user's profile is
##  updated. When the avatar is displayed, the width and height attributes of 
##  the HTML <img> tag are set to scale the image down. Gallery avatars and 
##  uploaded avatars are not resized.
##
##  If you change the maximum width/height set in the admin panel, the sizes 
##  will be automatically re-calculated next time each user's avatar is viewed. 
##  This may result in a temporary slow-down for the first person to view each 
##  avatar, but shouldn't be too drastic. Once each avatar has been viewed once
##  the board should run at a normal speed.
##############################################################
## MOD History: 
## 
##  2004-01-26 - Version 1.0.0
##   - Initial Release.
## 
##  2004-01-26 - Version 1.0.1
##   - Fixed a small bug that caused PHP to report an error if the URI was 
##     unreachable.
##
##  2004-08-10 - Version 1.2.0
##   - Complete rewrite, now uses a function to resize the image.
##
##  2004-08-10 - Version 1.2.1
##   - Fixed an error in the .mod file syntax.
##
##  2004-09-02 - Version 1.2.2
##   - Fixed a small bug that prevented display in memberlist.php.
##
##  2004-09-09 - Version 1.2.2a
##   - Re-submitted to MOD database (no change from 1.2.2).
##
##  2004-09-15 - Version 1.2.3
##   - Added the resize to the edit profile page.
##
##  2004-09-20 - Version 1.2.3a
##   - Re-submitted to MOD database (no change from 1.2.3).
##
##  2006-12-27 - Version 2.0.0
##   - Another complete rewrite, this time to drastically improve performance.
##
##  2007-03-04 - Version 2.0.1
##   - Fixed a small bug in the error handling.
##
##  2007-03-27 - Version 2.0.2
##   - Enabled use of URIs longer than 100 characters in avatar filenames.
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
# 
ALTER TABLE phpbb_users ADD user_avatar_dimensions VARCHAR(255) NULL;
ALTER TABLE phpbb_users CHANGE user_avatar user_avatar VARCHAR(255) DEFAULT NULL;

#
#-----[ OPEN ]------------------------------------------
#
groupcp.php

#
#-----[ FIND ]------------------------------------------
#
			case USER_AVATAR_REMOTE:
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
				break;

#
#-----[ REPLACE WITH ]------------------------------------------
#
			// MOD: Remote Avatar Resize - by tomlevens
			// (3 lines replaced - original lines follow)
			//
			// case USER_AVATAR_REMOTE:
			// 		$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
			// 		break;
			//
			case USER_AVATAR_REMOTE:
				list($user_avatar_width, $user_avatar_height) = explode('x', check_avatar_dimensions($row['user_avatar_dimensions'], $row['user_avatar'], $row['user_id']));
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" width="' . $user_avatar_width . '" height="' . $user_avatar_height . '" alt="" border="0" />' : '';
				break;
			//
			// END MOD

#
#-----[ FIND ]------------------------------------------
#
	//
	// Get moderator details for this group
	//
	$sql = "SELECT username,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_msnm

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_avatar, user_avatar_type, user_avatar_dimensions, user_allowavatar

#
#-----[ FIND ]------------------------------------------
#
	//
	// Get user information for this group
	//
	$sql = "SELECT u.username

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, ug.user_pending

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, u.user_avatar, u.user_avatar_type, u.user_avatar_dimensions, u.user_allowavatar

#
#-----[ FIND ]------------------------------------------
#
	$db->sql_freeresult($result);

	$sql = "SELECT u.username,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, u.user_msnm

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, u.user_avatar, u.user_avatar_type, u.user_avatar_dimensions, u.user_allowavatar

#
#-----[ OPEN ]------------------------------------------
#
memberlist.php

#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT username,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_avatar_type

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_avatar_dimensions

#
#-----[ FIND ]------------------------------------------
#
				case USER_AVATAR_REMOTE:
					$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
					break;

#
#-----[ REPLACE WITH ]------------------------------------------
#
				// MOD: Remote Avatar Resize - by tomlevens
				// (3 lines replaced - original lines follow)
				//
				// case USER_AVATAR_REMOTE:
				// 		$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
				// 		break;
				//
				case USER_AVATAR_REMOTE:
					list($user_avatar_width, $user_avatar_height) = explode('x', check_avatar_dimensions($row['user_avatar_dimensions'], $row['user_avatar'], $user_id));
					$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" width="' . $user_avatar_width . '" height="' . $user_avatar_height . '" alt="" border="0" />' : '';
					break;
				//
				// END MOD

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT u.username

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, u.user_avatar_type

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, u.user_avatar_dimensions

#
#-----[ FIND ]------------------------------------------
#
			case USER_AVATAR_REMOTE:
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				break;

#
#-----[ REPLACE WITH ]------------------------------------------
#
			// MOD: Remote Avatar Resize - by tomlevens
			// (3 lines replaced - original lines follow)
			//
			//	case USER_AVATAR_REMOTE:
			//		$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
			//		break;
			//
			case USER_AVATAR_REMOTE:
				list($user_avatar_width, $user_avatar_height) = explode('x', check_avatar_dimensions($postrow[$i]['user_avatar_dimensions'], $postrow[$i]['user_avatar'], $postrow[$i]['user_id']));
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" width="' . $user_avatar_width . '" height="' . $user_avatar_height . '" alt="" border="0" />' : '';
				break;
			//
			// END MOD

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
		if ($config_name == 'cookie_name')
		{

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		// MOD: Remote Avatar Resize - by tomlevens
		// (13 lines added)
		//	
		if (($config_name == 'avatar_max_width' || $config_name == 'avatar_max_height') && isset($HTTP_POST_VARS['submit']))
		{
			if (($config_name == 'avatar_max_width' && $config_value != $new['avatar_max_width']) || ($config_name == 'avatar_max_height' && $config_value != $new['avatar_max_height']))
			{
				$sql = "UPDATE " . USERS_TABLE . "
					SET user_avatar_dimensions = NULL";

				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Failed to set NULL values for all avatar dimensions in users table (MOD: Remote Avatar Resize - by tomlevens)', '', __LINE__, __FILE__, $sql);
				}
			}
		}
		//
		// END MOD

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#
		$user_avatar_type = ( empty($user_avatar_loc) ) ? $this_userdata['user_avatar_type'] : '';	

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// MOD: Remote Avatar Resize - by tomlevens
		// (1 line added)
		//	
		$user_avatar_dimensions = ( empty($user_avatar_loc) ) ? $this_userdata['user_avatar_dimensions'] : '';
		//
		// END MOD

#
#-----[ FIND ]------------------------------------------
#
			$avatar_sql = ", user_avatar = '', user_avatar_type = " . USER_AVATAR_NONE;
#
#-----[ REPLACE WITH ]------------------------------------------
#
			// MOD: Remote Avatar Resize - by tomlevens
			// (1 line replaced - original line follows)
			//
			//	$avatar_sql = ", user_avatar = '', user_avatar_type = " . USER_AVATAR_NONE;
			$avatar_sql = ", user_avatar = '', user_avatar_type = " . USER_AVATAR_NONE . ", user_avatar_dimensions = NULL";
			//
			// END MOD

#
#-----[ FIND ]------------------------------------------
#
								$avatar_sql = ", user_avatar = '$avatar_filename', user_avatar_type = " . USER_AVATAR_UPLOAD;

#
#-----[ REPLACE WITH ]------------------------------------------
#
								// MOD: Remote Avatar Resize - by tomlevens
								// (1 line replaced - original line follows)
								//
								//	$avatar_sql = ", user_avatar = '$avatar_filename', user_avatar_type = " . USER_AVATAR_UPLOAD;
								//
								$avatar_sql = ", user_avatar = '$avatar_filename', user_avatar_type = " . USER_AVATAR_UPLOAD . ", user_avatar_dimensions = NULL";
								//
								// END MOD

#
#-----[ FIND ]------------------------------------------
#
										$avatar_sql = ", user_avatar = '$avatar_filename', user_avatar_type = " . USER_AVATAR_UPLOAD;

#
#-----[ REPLACE WITH ]------------------------------------------
#
										// MOD: Remote Avatar Resize - by tomlevens
										// (1 line replaced - original line follows)
										//
										//	$avatar_sql = ", user_avatar = '$avatar_filename', user_avatar_type = " . USER_AVATAR_UPLOAD;
										//
										$avatar_sql = ", user_avatar = '$avatar_filename', user_avatar_type = " . USER_AVATAR_UPLOAD . ", user_avatar_dimensions = NULL";
										//
										// END MOD

#
#-----[ FIND ]------------------------------------------
#
				$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", $user_avatar_remoteurl) . "', user_avatar_type = " . USER_AVATAR_REMOTE;

#
#-----[ REPLACE WITH ]------------------------------------------
#
				// MOD: Remote Avatar Resize - by tomlevens
				// (1 line replaced - original line follows)
				//
				//	$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", $user_avatar_remoteurl) . "', user_avatar_type = " . USER_AVATAR_REMOTE;
				//
				$avatar_sizes = @getimagesize($user_avatar_remoteurl);
				list($avatar_width, $avatar_height) = $avatar_sizes;

				if($avatar_sizes == FALSE || $avatar_width == '0' || $avatar_height == '0')
				{
					$error = true;
					$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Wrong_remote_avatar_format'] : $lang['Wrong_remote_avatar_format'];
					return;
				}
				else
				{
					if($avatar_width > $board_config['avatar_max_width'] && $avatar_height <= $board_config['avatar_max_height'])
					{
						$cons_width = $board_config['avatar_max_width'];
						$cons_height = round((($board_config['avatar_max_width'] * $avatar_height) / $avatar_width), 0);
					}
					elseif($avatar_width <= $board_config['avatar_max_width'] && $avatar_height > $board_config['avatar_max_height'])
					{
						$cons_width = round((($board_config['avatar_max_height'] * $avatar_width) / $avatar_height), 0);
						$cons_height = $board_config['avatar_max_height'];
					}
					elseif($avatar_width > $board_config['avatar_max_width'] && $avatar_height > $board_config['avatar_max_height'])
					{
						if($avatar_width >= $avatar_height)
						{
							$cons_width = $board_config['avatar_max_width'];
							$cons_height = round((($board_config['avatar_max_width'] * $avatar_height) / $avatar_width), 0);
						}
						elseif($avatar_width < $avatar_height)
						{
							$cons_width = round((($board_config['avatar_max_height'] * $avatar_width) / $avatar_height), 0);
							$cons_height = $board_config['avatar_max_height'];
						}
					}
					else
					{
						$cons_width = $avatar_width;
						$cons_height = $avatar_height;
					}
				
					$avatar_dimensions = $cons_width . 'x' . $cons_height;
				}

				$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", $user_avatar_remoteurl) . "', user_avatar_type = " . USER_AVATAR_REMOTE . ", user_avatar_dimensions = '" . $avatar_dimensions . "'";
				//
				// END MOD

#
#-----[ FIND ]------------------------------------------
#
			$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", phpbb_ltrim(basename($user_avatar_category), "'") . '/' . phpbb_ltrim(basename($user_avatar_local), "'")) . "', user_avatar_type = " . USER_AVATAR_GALLERY;

#
#-----[ REPLACE WITH ]------------------------------------------
#
			// MOD: Remote Avatar Resize - by tomlevens
			// (1 line replaced - original line follows)
			//
			//	$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", phpbb_ltrim(basename($user_avatar_category), "'") . '/' . phpbb_ltrim(basename($user_avatar_local), "'")) . "', user_avatar_type = " . USER_AVATAR_GALLERY;
			//
			$avatar_sql = ", user_avatar = '" . str_replace("\'", "''", phpbb_ltrim(basename($user_avatar_category), "'") . '/' . phpbb_ltrim(basename($user_avatar_local), "'")) . "', user_avatar_type = " . USER_AVATAR_GALLERY . ", user_avatar_dimensions = NULL";
			//
			// END MOD

#
#-----[ FIND ]------------------------------------------
#
		$user_avatar_type = $this_userdata['user_avatar_type'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// MOD: Remote Avatar Resize - by tomlevens
		// (1 line added)
		//
		$user_avatar_dimensions = $this_userdata['user_avatar_dimensions'];
		//
		// END MOD

#
#-----[ FIND ]------------------------------------------
#
				case USER_AVATAR_REMOTE:
					$avatar = '<img src="' . $user_avatar . '" alt="" />';
					break;

#
#-----[ REPLACE WITH ]------------------------------------------
#
				// MOD: Remote Avatar Resize - by tomlevens
				// (3 lines replaced - original lines follow)
				//
				// case USER_AVATAR_REMOTE:
				//	$avatar = '<img src="' . $user_avatar . '" alt="" />';
				//	break;
				//
				case USER_AVATAR_REMOTE:
					list($user_avatar_width, $user_avatar_height) = explode('x', check_avatar_dimensions($user_avatar_dimensions, $user_avatar, $this_userdata['user_id']));
					$avatar = '<img src="' . $user_avatar . '" width="' . $user_avatar_width . '" height="' . $user_avatar_height . '" alt="" border="0" />';
					break;
				//
				// END MOD

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
// MOD: Remote Avatar Resize - by tomlevens
// (64 lines added)
//	
function check_avatar_dimensions($avatar_dimensions, $avatar_filename, $user_id)
{
	global $db, $board_config;

	if ($avatar_dimensions == NULL)
	{
		$avatar_sizes = @getimagesize($avatar_filename);
		list($avatar_width, $avatar_height) = $avatar_sizes;

		if($avatar_sizes == FALSE || $avatar_width == '0' || $avatar_height == '0')
		{
			$checked_dimensions = $board_config['avatar_max_width'] . 'x' . $board_config['avatar_max_height'];
		}
		else
		{
			if($avatar_width > $board_config['avatar_max_width'] && $avatar_height <= $board_config['avatar_max_height'])
			{
				$cons_width = $board_config['avatar_max_width'];
				$cons_height = round((($board_config['avatar_max_width'] * $avatar_height) / $avatar_width), 0);
			}
			elseif($avatar_width <= $board_config['avatar_max_width'] && $avatar_height > $board_config['avatar_max_height'])
			{
				$cons_width = round((($board_config['avatar_max_height'] * $avatar_width) / $avatar_height), 0);
				$cons_height = $board_config['avatar_max_height'];
			}
			elseif($avatar_width > $board_config['avatar_max_width'] && $avatar_height > $board_config['avatar_max_height'])
			{
				if($avatar_width >= $avatar_height)
				{
					$cons_width = $board_config['avatar_max_width'];
					$cons_height = round((($board_config['avatar_max_width'] * $avatar_height) / $avatar_width), 0);
				}
				elseif($avatar_width < $avatar_height)
				{
					$cons_width = round((($board_config['avatar_max_height'] * $avatar_width) / $avatar_height), 0);
					$cons_height = $board_config['avatar_max_height'];
				}
			}
			else
			{
				$cons_width = $avatar_width;
				$cons_height = $avatar_height;
			}
		
			$checked_dimensions = $cons_width . 'x' . $cons_height;

			$sql = "UPDATE " . USERS_TABLE . "
				SET user_avatar_dimensions = '" . $checked_dimensions . "'
				WHERE user_id = " . $user_id;
	
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error updating avatar dimensions (MOD: Remote Avatar Resize - by tomlevens)', '', __LINE__, __FILE__, $sql);
			}
		}
	}
	else
	{
		$checked_dimensions = $avatar_dimensions;
	}

	return $checked_dimensions;
}
// END MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php

#
#-----[ FIND ]------------------------------------------
#
	return ", user_avatar = '', user_avatar_type = " . USER_AVATAR_NONE;

#
#-----[ REPLACE WITH ]------------------------------------------
#
	// MOD: Remote Avatar Resize - by tomlevens
	// (1 line replaced - original line follows)
	//
	//	return ", user_avatar = '', user_avatar_type = " . USER_AVATAR_NONE;
	//
	return ", user_avatar = '', user_avatar_type = " . USER_AVATAR_NONE . ", user_avatar_dimensions = NULL";
	//
	// END MOD

#
#-----[ FIND ]------------------------------------------
#
		$return = ", user_avatar = '" . str_replace("\'", "''", $avatar_category . '/' . $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_GALLERY;

#
#-----[ REPLACE WITH ]------------------------------------------
#
		// MOD: Remote Avatar Resize - by tomlevens
		// (1 line replaced - original line follows)
		//
		//	$return = ", user_avatar = '" . str_replace("\'", "''", $avatar_category . '/' . $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_GALLERY;
		//
		$return = ", user_avatar = '" . str_replace("\'", "''", $avatar_category . '/' . $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_GALLERY . ", user_avatar_dimensions = NULL";
		//
		// END MOD

#
#-----[ FIND ]------------------------------------------
#
function user_avatar_url($mode, &$error, &$error_msg, $avatar_filename)
{
	global $lang;

#
#-----[ REPLACE WITH ]------------------------------------------
#
function user_avatar_url($mode, &$error, &$error_msg, $avatar_filename)
{
	// MOD: Remote Avatar Resize - by tomlevens
	// (1 line replaced - original line follows)
	//
	//	global $lang;
	//
	global $lang, $board_config;
	//
	// END MOD

#
#-----[ FIND ]------------------------------------------
#
	$avatar_filename = substr($avatar_filename, 0, 100);

#
#-----[ REPLACE WITH ]------------------------------------------
#
	// MOD: Remote Avatar Resize - by tomlevens
	// (1 line replaced - original line follows)
	//
	//	$avatar_filename = substr($avatar_filename, 0, 100);
	//
	$avatar_filename = substr($avatar_filename, 0, 255);
	//
	// END MOD

#
#-----[ FIND ]------------------------------------------
#
	return ( $mode == 'editprofile' ) ? ", user_avatar = '" . str_replace("\'", "''", $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_REMOTE : '';

#
#-----[ REPLACE WITH ]------------------------------------------
#
	// MOD: Remote Avatar Resize - by tomlevens
	// (1 line replaced - original line follows)
	//
	//	return ( $mode == 'editprofile' ) ? ", user_avatar = '" . str_replace("\'", "''", $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_REMOTE : '';
	//
	$avatar_sizes = @getimagesize($avatar_filename);
	list($avatar_width, $avatar_height) = $avatar_sizes;

	if($avatar_sizes == FALSE || $avatar_width == '0' || $avatar_height == '0')
	{
		$error = true;
		$error_msg = (!empty($error_msg)) ? $error_msg . '<br />' . $lang['Wrong_remote_avatar_format'] : $lang['Wrong_remote_avatar_format'];
		return;
	}
	else
	{
		if($avatar_width > $board_config['avatar_max_width'] && $avatar_height <= $board_config['avatar_max_height'])
		{
			$cons_width = $board_config['avatar_max_width'];
			$cons_height = round((($board_config['avatar_max_width'] * $avatar_height) / $avatar_width), 0);
		}
		elseif($avatar_width <= $board_config['avatar_max_width'] && $avatar_height > $board_config['avatar_max_height'])
		{
			$cons_width = round((($board_config['avatar_max_height'] * $avatar_width) / $avatar_height), 0);
			$cons_height = $board_config['avatar_max_height'];
		}
		elseif($avatar_width > $board_config['avatar_max_width'] && $avatar_height > $board_config['avatar_max_height'])
		{
			if($avatar_width >= $avatar_height)
			{
				$cons_width = $board_config['avatar_max_width'];
				$cons_height = round((($board_config['avatar_max_width'] * $avatar_height) / $avatar_width), 0);
			}
			elseif($avatar_width < $avatar_height)
			{
				$cons_width = round((($board_config['avatar_max_height'] * $avatar_width) / $avatar_height), 0);
				$cons_height = $board_config['avatar_max_height'];
			}
		}
		else
		{
			$cons_width = $avatar_width;
			$cons_height = $avatar_height;
		}
	
		$avatar_dimensions = $cons_width . 'x' . $cons_height;
	}

	return ( $mode == 'editprofile' ) ? ", user_avatar = '" . str_replace("\'", "''", $avatar_filename) . "', user_avatar_type = " . USER_AVATAR_REMOTE . ", user_avatar_dimensions = '" . $avatar_dimensions . "'" : '';
	//
	// END MOD

#
#-----[ FIND ]------------------------------------------
#
		$avatar_sql = ( $mode == 'editprofile' ) ? ", user_avatar = '$new_filename', user_avatar_type = " . USER_AVATAR_UPLOAD : "'$new_filename', " . USER_AVATAR_UPLOAD;

#
#-----[ REPLACE WITH ]------------------------------------------
#
		// MOD: Remote Avatar Resize - by tomlevens
		// (1 line replaced - original line follows)
		//
		//	$avatar_sql = ( $mode == 'editprofile' ) ? ", user_avatar = '$new_filename', user_avatar_type = " . USER_AVATAR_UPLOAD : "'$new_filename', " . USER_AVATAR_UPLOAD;
		//
		$avatar_sql = ( $mode == 'editprofile' ) ? ", user_avatar = '$new_filename', user_avatar_type = " . USER_AVATAR_UPLOAD . ", user_avatar_dimensions = NULL" : "'$new_filename', " . USER_AVATAR_UPLOAD . ", user_avatar_dimensions = NULL";
		//
		// END MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
	$user_avatar_type = ( empty($user_avatar_local) && $mode == 'editprofile' ) ? $userdata['user_avatar_type'] : '';

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// MOD: Remote Avatar Resize - by tomlevens
	// (1 line added)
	//
	$user_avatar_dimensions = ( empty($user_avatar_local) && $mode == 'editprofile' ) ? $userdata['user_avatar_dimensions'] : '';
	//
	// END MOD

#
#-----[ FIND ]------------------------------------------
#
	$user_avatar_type = ( $userdata['user_allowavatar'] ) ? $userdata['user_avatar_type'] : USER_AVATAR_NONE;

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// MOD: Remote Avatar Resize - by tomlevens
	// (1 line added)
	//
	$user_avatar_dimensions = ( $userdata['user_allowavatar'] ) ? $userdata['user_avatar_dimensions'] : '';
	//
	// END MOD

#
#-----[ FIND ]------------------------------------------
#
			case USER_AVATAR_REMOTE:
				$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" />' : '';
				break;

#
#-----[ REPLACE WITH ]------------------------------------------
#
			// MOD: Remote Avatar Resize - by tomlevens
			// (3 lines replaced - original lines follow)
			//
			// case USER_AVATAR_REMOTE:
			// 	$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" />' : '';
			// 	break;
			//
			case USER_AVATAR_REMOTE:
				list($user_avatar_width, $user_avatar_height) = explode('x', check_avatar_dimensions($user_avatar_dimensions, $user_avatar, $userdata['user_id']));
				$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" width="' . $user_avatar_width . '" height="' . $user_avatar_height . '" alt="" border="0" />' : '';
				break;
			//
			// END MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php 

#
#-----[ FIND ]------------------------------------------
#
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;

#
#-----[ REPLACE WITH ]------------------------------------------
#
		// MOD: Remote Avatar Resize - by tomlevens
		// (3 lines replaced - original lines follow)
		//
		// case USER_AVATAR_REMOTE:
		// 	$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
		// 	break;
		//
		case USER_AVATAR_REMOTE:
			list($user_avatar_width, $user_avatar_height) = explode('x', check_avatar_dimensions($profiledata['user_avatar_dimensions'], $profiledata['user_avatar'], $profiledata['user_id']));
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" width="' . $user_avatar_width . '" height="' . $user_avatar_height . '" alt="" border="0" />' : '';
			break;
		//
		// END MOD

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php 

#
#-----[ FIND ]------------------------------------------
#
# FULL LINE: $lang['Avatar_explain'] = 'Displays a small graphic image below your details in posts. Only one image can be displayed at a time, its width can be no greater than %d pixels, the height no greater than %d pixels, and the file size no more than %d KB.';
#
$lang['Avatar_explain'] = 

#
#-----[ REPLACE WITH ]------------------------------------------
#
// MOD: Remote Avatar Resize - by tomlevens
// (1 line replaced - original line follows)
//
// $lang['Avatar_explain'] = 'Displays a small graphic image below your details in posts. Only one image can be displayed at a time, its width can be no greater than %d pixels, the height no greater than %d pixels, and the file size no more than %d KB.';
//
$lang['Avatar_explain'] = 'Displays a small graphic image below your details in posts. Only one image can be displayed at a time. The dimensions of the image are restricted to a maximum width of %d pixels, and height of %d pixels. Uploaded avatars have a file size limit of %d KB, and must be less than or equal to the maximum dimensions. Remotely hosted avatars will be automatically scaled to fit these dimensions.';
//
// END MOD

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 