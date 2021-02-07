##############################################################
## MOD Title:    Random Avatars Mod
## MOD Author:   Mosheen < james@medinaline.net > (James Moats) http://medinaline.net
## MOD Description:	This MOD will allow your users to have multiple avatars. A random 
##				avatar from the poster's profile is chosen for each post. Supports all
##				avatar types (upload, link, gallery). Admin controls exist for individual 
##				users, avatars, and forum-wide enable / disable.
## MOD Version:  		1.1.7
##
## Installation Level: Intermediate
## Installation Time: 30 Minutes
## Files To Edit:       viewtopic.php
##				admin/admin_board.php
##				admin/admin_users.php
##				includes/constants.php
##				includes/usercp_avatar.php
##				includes/usercp_register.php
##				includes/usercp_viewprofile.php
##				language/lang_english/lang_main.php
##				templates/subSilver/profile_add_body.tpl
##				templates/subSilver/profile_view_body.tpl
##				templates/subSilver/admin/board_config_body.tpl
##				templates/subSilver/admin/user_edit_body.tpl
## Included Files:      N/A
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
##	 + USERS UPGRADING TO 1.0.11 OR HIGHER FROM 1.0.3 OR LOWER VERSION WILL EXPERIENCE PROBLEMS
##	 +	WITH SITE GALLERY AVATARS RETURNING BROKEN LINKS - MUST DELETE THESE ENTRIES FROM
##	 +	THE AVATARS DATABASE TABLE.
##	 + The change listed above is because of a problem with how the file path to the site gallery
##	 +	avatar path was not originally stored using $board_config(avatar_gallery_path)
##	 + This mod does not change the core functionality of the avatar upload / display process.
##	 + Should work with any mod that does not change that core functionality.
##	 + Should work with any version of phpBB.
##	 + Pivotal coding assistance by ChunkStyle (Dan Taylor) 
##	 + Thanks to Kalipo for some coding examples as well!
##############################################################
## MOD History:
##
##	2007-08-10  -  Minor release 1.1.7
##			+ Initial user avatars were not being copied to phpbb_avatars table,
##				added sql insert into .. select
##	2007-08-08  -  Minor release 1.1.5
##			+ Incorrect SQL statement caused ACP setting to not save
##	2007-08-03  -  Minor release 1.1.3
##			+ Mod validation - syntax changes
##			+ Added condition for FTP instead of just HTTP
##			+ Added missing error handling on most db actions
##	2007-07-01  -  Minor release 1.1.0
##			+ Added forum-wide Enable / Disable control
##			+ Rearranged the edit profile (user/admin) random avatar gallery which 
##				makes it more non-subsilver style friendly
##			+ Fixed ignoring admin disable avatars for user bug
##			+ Fixed admin disable avatars for user with random avatars 
##				makes stuff look weird bug.
##			+ Mod validation: Fixed security risk / SQL injection on user / admin 
##				delete avatar process (major rewrite)
##    2007-01-24  -  Minor release 1.0.19
##			+ Changed template pages to allow compatibility 
##				with more skins.
##	2006-04-17  -  Minor release 1.0.17
##			+ Changed two lines for 2.0.20 compatability
##	2005-07-23	-  Minor release 1.0.15
##			+ Fixed show avatar window on registration bug
##	2005-07-17	-  Minor release 1.0.13
##			+ Mod validation - syntax changes
##	2005-07-13	-  Minor release 1.0.11
##			+ Mod validation - syntax changes
##			+ Fixed the remaining hard coded text (template) issue
##			+ Fixed site gallery avatar handling, now uses board config for av gal path
##	2005-07-07	-  Minor release 1.0.9
##			+ Fixed the Internet Explorer / Random Av Gallery not wrapping issue
##	2005-06-24	-  Minor release 1.0.7
##			+ Fixed the ACP upload / remote / gallery add to random pool issue
##	2005-06-22	-  Minor release 1.0.5
##			+ Mod validation - syntax changes
##			+ Complete mod document re-write
##			+ Focus on EasyMod compliance syntax - Not verified though
##			+ Perfected ACP control of per-user random av privileges
##			+ Perfected ACP ability to delete selected avatars
##			+ Perfected conditional text to TPL pages
##			+ Fixed the bug that allowed user_avatar field to be blank after deleting most
##				recent avatar addition.
##			+ Added random avatars text to ACP user management
##	2005-06-17	-  Minor release 1.0.3
##			+ Added admin / per-user random avatars control
##			+ Added site gallery avatars to random avatar compatability
##			+ Added random avatar gallery to ACP user management w/ delete avatar ability
##			+ Added more conditional entries to the template files
##	2005-06-16  -  Minor release 1.0.1
##			+ Mod validation - syntax changes
##			+ All template text is now passed through language files
##			+ Added conditional entries to the template files
##	2005-06-03	-  Major release 1.0.0
##			+ Mod validation - syntax changes
##	2005-05-23  -  Minor release 0.1.5
##			+ View profile screen now has random avatar gallery 
##			+ Remote URL avatars now displaying properly
##	2005-05-22  -  Minor release 0.1.3
##			+ All types of avatars now supported (local upload, url upload, remote url)
##	2005-05-21  -  BETA quality release 0.1.1
##			+ Delete current avatar when uploading issue resolved
##			+ Random Avatar Gallery ORDER BY added
##			+ Optional lines of mod documented
##	2005-05-19  -  Initial testing release 0.1.0
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]---------------------------------
#
CREATE TABLE `phpbb_avatars` ( `av_id` INT( 11 ) NOT NULL AUTO_INCREMENT , `user_id` MEDIUMINT( 8 ) NOT NULL , `user_avatar` VARCHAR( 100 ) NOT NULL ,
PRIMARY KEY ( `av_id` ) );
ALTER TABLE `phpbb_users` ADD `user_randomavatars` TINYINT( 1 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_users` ADD `admin_randomavatars` TINYINT( 1 ) DEFAULT '1' NOT NULL ;
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ( 'allow_random_avatars', '1' );
INSERT INTO `phpbb_avatars` ( `user_id` , `user_avatar` ) SELECT `user_id` , `user_avatar` FROM `phpbb_users` WHERE `user_avatar` <> "";


#
#-----[ OPEN ]---------------------------------
#
viewtopic.php


#
#-----[ FIND ]---------------------------------
#
$sql = "SELECT u.username, 
	FROM " . POSTS_TABLE 
	WHERE p.topic_id = $topic_id


#
#-----[ IN-LINE FIND ]---------------------------------
#
u.user_avatar_type, 


#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
u.user_randomavatars, u.admin_randomavatars, 


#
#-----[ FIND ]---------------------------------
#
	$poster_avatar = '';


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
	if ( $postrow[$i]['user_randomavatars'] == 1 && $postrow[$i]['admin_randomavatars'] == 1 && $postrow[$i]['user_allowavatar'] == 1 && $board_config['allow_random_avatars'] == 1 )
	{ 
		$sql = "SELECT user_avatar FROM " . AVATARS_TABLE . " WHERE user_id = '$poster_id' ORDER BY RAND() LIMIT 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain user avatar status', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$image_name = $row['user_avatar'];

		$cnt_chrs = strlen( $board_config['avatar_gallery_path'] );

		if ( substr($image_name, 0, 4) == "http" || substr($image_name, 0, 3) == "ftp" )
		{
			$poster_avatar = "<img src=\"" . $image_name . "\" border=0 />";
		}
		else if ( substr($image_name, 0, $cnt_chrs) == $board_config['avatar_gallery_path'] )
		{
			$poster_avatar = "<img src=\"" . $image_name . "\" border=0 />";
		}
		else
		{
			$poster_avatar = "<img src=\"" . $board_config['avatar_path'] . "/" . $image_name . "\" border=0 />";
		}
	}
//---------END---------//
//
// Note: the following 'else if' was formerly 'if' > Modified By Random Avatars Mod
//


#
#-----[ FIND ]---------------------------------
#
	if ( $postrow[$i]['user_avatar_type'] && 


#
#-----[ IN-LINE FIND ]---------------------------------
#
if


#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------
#
else 


#
#-----[ OPEN ]---------------------------------
#
admin/admin_board.php


#
#-----[ FIND ]---------------------------------
#
$avatars_upload_no = ( !$new['allow_avatar_upload'] ) ? "checked=\"checked\"" : "";


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
$board_random_avatars_yes = ( $new['allow_random_avatars'] ) ? "checked=\"checked\"" : "";
$board_random_avatars_no = ( !$new['allow_random_avatars'] ) ? "checked=\"checked\"" : "";
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
	"L_AVATAR_SETTINGS" => $lang['Avatar_settings'],


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
	"L_RANDOM_AVATARS" => $lang['Random_avatars_mod'],
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
	"NAMECHANGE_NO" => $namechange_no,


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
	"RANDOM_AVATARS_YES" => $board_random_avatars_yes,
	"RANDOM_AVATARS_NO" => $board_random_avatars_no,
//--------END---------//


#
#-----[ OPEN ]---------------------------------
#
admin/admin_users.php


#
#-----[ FIND ]---------------------------------
#
				message_die(GENERAL_ERROR, 'Could not delete user', '', __LINE__, __FILE__, $sql);
			}


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
			$sql = "DELETE FROM " . AVATARS_TABLE . "
				WHERE user_id = $user_id";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete user from avatars table', '', __LINE__, __FILE__, $sql);
			}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		$user_avatar_type = ( empty($user_avatar_loc) ) ? $this_userdata['user_avatar_type'] : '';		


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
		$random_avatars = ( isset($HTTP_POST_VARS['random_avatars']) ) ? ( ($HTTP_POST_VARS['random_avatars']) ? TRUE : 0 ) : $this_userdata['user_randomavatars'];
		$admin_random_avatars = ( isset($HTTP_POST_VARS['admin_random_avatars']) ) ? ( ($HTTP_POST_VARS['admin_random_avatars']) ? TRUE : 0 ) : $this_userdata['admin_randomavatars'];
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		$avatar_sql = "";


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( is_array($HTTP_POST_VARS['rand_av_del']) )
{
	$av_array = $HTTP_POST_VARS['rand_av_del'];

	foreach($av_array as $av_to_delete)
	{
		$av_to_delete = intval($av_to_delete);
		$user_id = $this_userdata['user_id'];

		$sql = "SELECT av_id, user_avatar FROM " . AVATARS_TABLE . " WHERE user_id = '$user_id' AND av_id = '$av_to_delete'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain avatar to delete', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$avatar_name = $row['user_avatar'];

		$sql = "DELETE FROM " . AVATARS_TABLE . " WHERE av_id = '$av_to_delete' AND user_id = '$user_id'";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete avatar', '', __LINE__, __FILE__, $sql);
		}

		if ( $avatar_name == $this_userdata['user_avatar'] || $avatar_name == $board_config['avatar_gallery_path'] . $this_userdata['user_avatar'] )
		{
			$sql = "SELECT av_id, user_avatar FROM " . AVATARS_TABLE . " WHERE user_id = '$user_id' ORDER BY av_id DESC LIMIT 0,1 ";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not refresh newest avatar', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$last_avatar = $row['user_avatar'];
				
			$cnt_chrs = strlen( $board_config['avatar_gallery_path'] );

			if ( substr($last_avatar, 0, 4) == "http" )
			{
				$last_av_type = 2;
			}
			else if ( substr($last_avatar, 0, $cnt_chrs) == $board_config['avatar_gallery_path'] )									{
				$last_av_type = 3;
			}			
			else
			{
				$last_av_type = 1;
			}
			$sql = "UPDATE " . USERS_TABLE . " SET user_avatar = '$last_avatar', user_avatar_type = '$last_av_type' WHERE user_id = '$user_id'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update newest avatar', '', __LINE__, __FILE__, $sql);
			}
		}
		if ( substr($av_to_delete, 0, $cnt_chrs) != $board_config['avatar_gallery_path'] )
		{
			@unlink(@phpbb_realpath('./' . $board_config['avatar_path'] . '/' . $avatar_name));
		}
	}
}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
								$avatar_filename = $user_id . $imgtype;


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $this_userdata['user_randomavatars'] == 1 && $this_userdata['admin_randomavatars'] == 1 && $board_config['allow_random_avatars'] == 1 )
{
	$avatar_filename = uniqid(rand()) . $imgtype;
	$sql = "INSERT INTO " . AVATARS_TABLE . " (user_id, user_avatar) VALUES ('$user_id', '$avatar_filename')";
	if ( !($result = $db->sql_query($sql)) ) 
	{
		message_die(GENERAL_ERROR, 'Could not update the avatars table', '', __LINE__, __FILE__, $sql);
	}
}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
								if( $this_userdata['user_avatar_type'] == USER_AVATAR_UPLOAD && $this_userdata['user_avatar'] != "" )
								{


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $this_userdata['user_randomavatars'] != 1 && $this_userdata['admin_randomavatars'] != 1 )
{
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
								}
								@copy($user_avatar_loc, "./../" . $board_config['avatar_path'] . "/$avatar_filename");


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
										$avatar_filename = $user_id . $imgtype;


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $this_userdata['user_randomavatars'] == 1 && $this_userdata['admin_randomavatars'] == 1 )
{
	$avatar_filename = uniqid(rand()) . $imgtype;
	$sql = "INSERT INTO " . AVATARS_TABLE . " (user_id, user_avatar) VALUES ('$user_id', '$avatar_filename')";
	if ( !($result = $db->sql_query($sql)) ) 
	{
		message_die(GENERAL_ERROR, 'Could not update the avatars table', '', __LINE__, __FILE__, $sql);
	}
}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
											if( file_exists(@phpbb_realpath("./../" . $board_config['avatar_path'] . "/" . $this_userdata['user_avatar'])) )
											{


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
if ($this_userdata['user_randomavatars'] != 1)
{
//---------END---------// 


#
#-----[ FIND ]---------------------------------
#
										}
										@copy($tmp_filename, "./../" . $board_config['avatar_path'] . "/$avatar_filename");


#
#-----[ BEFORE, ADD ]------------------------------------
#
// Random Avatars Mod //
}
//---------END---------//


#
#-----[ FIND ]---------------------------------
#
			$sql = "UPDATE " . USERS_TABLE . "
				SET " . $username_sql . $passwd_sql . 
				WHERE user_id = $user_id";


#
#-----[ IN-LINE FIND ]---------------------------------
#
" . $avatar_sql . "


#
#-----[ IN-LINE BEFORE, ADD ]---------------------------------
#
, user_randomavatars=$random_avatars, admin_randomavatars=$admin_random_avatars

#
#-----[ FIND ]---------------------------------
#
				message_die(GENERAL_ERROR, 'Admin_user_fail', '', __LINE__, __FILE__, $sql);
			}


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $this_userdata['user_randomavatars'] == 1 && $this_userdata['admin_randomavatars'] == 1 && $board_config['allow_random_avatars'] == 1 ) 
{
	if ( $user_avatar_remoteurl != "" || $user_avatar_local != "" )
	{
		if ( $user_avatar_local != "" )
		{
			$new_avatar = $board_config['avatar_gallery_path'] . "/" . $user_avatar_local;
		}
		if ( $user_avatar_remoteurl != "" )
		{
			$new_avatar = $user_avatar_remoteurl;
		}
		$sql = "INSERT INTO " . AVATARS_TABLE . " (user_id, user_avatar) VALUES ('$user_id', '$new_avatar')";
		if ( !($result = $db->sql_query($sql)) ) 
		{
			message_die(GENERAL_ERROR, 'Could not update the avatars table', '', __LINE__, __FILE__, $sql);
		}
	}
}				
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		$user_avatar_type = $this_userdata['user_avatar_type'];


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
		$random_avatars = $this_userdata['user_randomavatars'];
		$admin_random_avatars = $this_userdata['admin_randomavatars'];
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		$smilies_status = ($this_userdata['user_allowsmile'] ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $this_userdata['user_randomavatars'] == 1 && $this_userdata['admin_randomavatars'] == 1 && $this_userdata['user_allowavatar'] == 1 && $board_config['allow_random_avatars'] == 1 )
{
	$user_id = $this_userdata['user_id'];
	$avatar_path = $board_config['avatar_path'];
	$sql = "SELECT user_avatar, av_id FROM " . AVATARS_TABLE . " WHERE user_id = '$user_id' ORDER BY av_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain list of avatars', '', __LINE__, __FILE__, $sql);
	}
	$num = 0;

	$cnt_chrs = strlen( $board_config['avatar_gallery_path'] );

	WHILE ($row = $db->sql_fetchrow($result))
	{
		$num++;
		$avatar_row = $row['user_avatar'];
		$avatar_id = $row['av_id'];

		if ( substr($avatar_row, 0, 4) == "http" )
		{
			$image_path = "<img src=\"" . $avatar_row . "\" border=0 />";
		}
		else if ( substr($avatar_row, 0, $cnt_chrs) == $board_config['avatar_gallery_path'] )
		{
			$image_path = "<img src=\"../" . $avatar_row . "\" border=0 />";
		}
		else
		{
			$image_path = "<img src=\"../" . $avatar_path . "/" . $avatar_row . "\" border=0 />";
		}	
		if ( $num == 3 )
		{
			$break = "<br />";
			$num = 0;
		}
		else
		{
			$break = "";
		}
		$avatar_name = $image_path . "<input type=\"checkbox\" name=\"rand_av_del[]\" value='$avatar_id' />" . $lang["Delete"] . "&nbsp;" . $break;
		$random_avatar_gallery = $random_avatar_gallery . $avatar_name;
	}
	$db->sql_freeresult($result);
}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
			'AVATAR' => $avatar,


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
			'RANDOM_AVATARS_YES' => ( $random_avatars ) ? 'checked="checked"' : '',
			'RANDOM_AVATARS_NO' => ( !$random_avatars ) ? 'checked="checked"' : '',
			'ADMIN_RANDOM_AVATARS_YES' => ( $admin_random_avatars ) ? 'checked="checked"' : '',
			'ADMIN_RANDOM_AVATARS_NO' => ( !$admin_random_avatars ) ? 'checked="checked"' : '',
			'RANDOM_AVATAR_GALLERY' => $random_avatar_gallery,
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
			'L_ALLOW_AVATAR' => $lang['User_allowavatar'],


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
			'L_RANDOM_AVATARS' => $lang['Use_random_avatars'],
			'L_RANDOM_AVATAR_GALLERY' => $lang['Random_avatar_gallery'],
			'L_ALL_AVATAR_TYPES' => $lang['All_avatar_types'],
			'L_ADMIN_RANDOM_AVATARS' => $lang['Random_avatars_override'],
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		if( file_exists(@phpbb_realpath('./../' . $board_config['avatar_path'])) && ($board_config['allow_avatar_upload'] == TRUE) )
		{


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $this_userdata['user_randomavatars'] == 1 && $this_userdata['admin_randomavatars'] == 1 && $this_userdata['user_allowavatar'] == 1 && $board_config['allow_random_avatars'] == 1 )
{
	$template->assign_block_vars('random_avatars', array() );
}
//---------END---------//


#
#-----[ OPEN ]---------------------------------
#
includes/constants.php


#
#-----[ FIND ]---------------------------------
#
define('BANLIST_TABLE', $table_prefix.'banlist');


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
define('AVATARS_TABLE', $table_prefix.'avatars');
//--------END---------//


#
#-----[ OPEN ]---------------------------------
#
includes/usercp_avatar.php


#
#-----[ FIND ]---------------------------------
#
		if ( @file_exists(@phpbb_realpath('./' 


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
		if ( $userdata['user_randomavatars'] != 1 ) 
		{
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
			@unlink('./' . $board_config['avatar_path'] . '/' . $avatar_file);
		}


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
		}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
# Note: The end product should look like this: $lang, $userdata;
#
	global $board_config, $db, $lang;


#
#-----[ IN-LINE FIND ]---------------------------------
#
$lang


#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
, $userdata


#
#-----[ FIND ]---------------------------------
#
		if ( $mode == 'editprofile' && $current_type == USER_AVATAR_UPLOAD
		{


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
		if ( $userdata['user_randomavatars'] != 1 ) 
		{
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
			user_avatar_delete($current_type, $current_avatar);


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
		}
//--------END---------//


#
#-----[ OPEN ]---------------------------------
#
includes/usercp_register.php


#
#-----[ FIND ]---------------------------------
#
$unhtml_specialchars_replace


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $userdata['user_randomavatars'] == 1 && $userdata['admin_randomavatars'] == 1 && $userdata['user_allowavatar'] == 1 && $board_config['allow_random_avatars'] == 1 )
{
	$user_id = $userdata['user_id'];
	$avatar_path = $board_config['avatar_path'];
	$sql = "SELECT user_avatar, av_id FROM " . AVATARS_TABLE . " WHERE user_id = '$user_id' ORDER BY av_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain list of avatars', '', __LINE__, __FILE__, $sql);
	}
	$num = 0;

	$cnt_chrs = strlen( $board_config['avatar_gallery_path'] );

	WHILE ($row = $db->sql_fetchrow($result))
	{
		$num++;
		$avatar_row = $row['user_avatar'];
		$avatar_id = $row['av_id'];

		if ( substr($avatar_row, 0, 4) == "http" )
		{
			$image_path = "<img src=\"" . $avatar_row . "\" border=0 />";
		}
		else if ( substr($avatar_row, 0, $cnt_chrs) == $board_config['avatar_gallery_path'] )
		{
			$image_path = "<img src=\"" . $avatar_row . "\" border=0 />";
		}
		else 
		{
			$image_path = "<img src=\"" . $avatar_path . "/" . $avatar_row . "\" border=0 />";
		}	
		if ( $num == 3 )
		{
			$break = "<br />";
			$num = 0;
		}
		else
		{
			$break = "";
		}
		$avatar_name = $image_path . "<input type=\"checkbox\" name=\"rand_av_del[]\" value='$avatar_id' />" . $lang["Delete"] . "&nbsp;" . $break;
		$random_avatar_gallery = $random_avatar_gallery . $avatar_name;
	}
	$db->sql_freeresult($result);
}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies'])


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
		$random_avatars = ( isset($HTTP_POST_VARS['random_avatars']) ) ? ( ($HTTP_POST_VARS['random_avatars']) ? TRUE : 0 ) : $userdata['user_randomavatars'];
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies'])


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
		$random_avatars = ( isset($HTTP_POST_VARS['random_avatars']) ) ? ( ($HTTP_POST_VARS['random_avatars']) ? TRUE : 0 ) : $userdata['user_randomavatars'];
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
	if ( isset($HTTP_POST_VARS['avatardel']) && $mode == 'editprofile' )


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
	if ( is_array($HTTP_POST_VARS['rand_av_del']) && $mode == 'editprofile' )
	{
		$av_array = $HTTP_POST_VARS['rand_av_del'];

		foreach($av_array as $av_to_delete)
		{
			$av_to_delete = intval($av_to_delete);
			$user_id = $userdata['user_id'];

			$sql = "SELECT av_id, user_avatar FROM " . AVATARS_TABLE . " WHERE user_id = '$user_id' AND av_id = '$av_to_delete'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain avatar to delete', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$avatar_name = $row['user_avatar'];

			$sql = "DELETE FROM " . AVATARS_TABLE . " WHERE av_id = '$av_to_delete' AND user_id = '$user_id'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not delete the avatar(s)', '', __LINE__, __FILE__, $sql);
			}
			if ( $avatar_name == $userdata['user_avatar'] || $avatar_name == $board_config['avatar_gallery_path'] . "/" . $userdata['user_avatar'] )
			{
				$sql = "SELECT av_id, user_avatar FROM " . AVATARS_TABLE . " WHERE user_id = '$user_id' ORDER BY av_id DESC LIMIT 0,1 ";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain newest avatar', '', __LINE__, __FILE__, $sql);
				}
				$row = $db->sql_fetchrow($result);
				$last_avatar = $row['user_avatar'];
				if ( substr($last_avatar, 0, 4) == "http" )
				{
					$last_av_type = 2;
				}
				else
				{
					$last_av_type = 1;
				}

				$sql = "UPDATE " . USERS_TABLE . " SET user_avatar = '" . $last_avatar . "', user_avatar_type = '$last_av_type' WHERE user_id = '$user_id'";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not insert newest avatar', '', __LINE__, __FILE__, $sql);
				}
			}

			$cnt_chrs = strlen( $board_config['avatar_gallery_path'] );

			if ( substr($avatar_name, 0, $cnt_chrs) != $board_config['avatar_gallery_path'] )
			{
				@unlink(@phpbb_realpath('./' . $board_config['avatar_path'] . '/' . $avatar_name));
			}
		}
	}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
	else if ( $user_avatar_remoteurl != '' && $board_config['allow_avatar_remote'] )
	{


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
	if ( $random_avatars != 1 ) 
	{
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		$avatar_sql = user_avatar_url($mode, 


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
	}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
	else if ( $user_avatar_local != '' && 
	{


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
	if ( $random_avatars != 1 ) 
	{
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		$avatar_sql = user_avatar_gallery($mode, 


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
	}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
			$sql = "UPDATE " . USERS_TABLE . "
				SET " . $username_sql . $passwd_sql . "
				WHERE user_id = $user_id";


#
#-----[ IN-LINE FIND ]---------------------------------
#
" . $avatar_sql . "


#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------
#
, user_randomavatars = $random_avatars


#
#-----[ FIND ]---------------------------------
#
			if ( !$user_active )


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $userdata['user_randomavatars'] == 1 && $userdata['admin_randomavatars'] == 1 ) 
{
	if ( $user_avatar_upload != "" || $user_avatar_remoteurl != "" || $user_avatar_local != "" )
	{
		$sql = "SELECT user_avatar, user_avatar_type FROM " . USERS_TABLE . " WHERE user_id = '$user_id'";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain avatar information', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$new_avatar = $row['user_avatar'];
		$av_type = $row['user_avatar_type'];
	
		if ( $av_type == 3 )
		{
			$new_avatar = $board_config['avatar_gallery_path'] . "/" . $new_avatar;
		}

		$sql = "INSERT INTO " . AVATARS_TABLE . " (user_id, user_avatar) VALUES ('$user_id', '$new_avatar')";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update the avatars table', '', __LINE__, __FILE__, $sql);
		}
	}
}				
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
	$user_avatar_type = ( $userdata['user_allowavatar'] ) ? $userdata['user_avatar_type'] : USER_AVATAR_NONE;


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
	$random_avatars = $userdata['user_randomavatars'];
	$admin_random_avatars = $userdata['admin_randomavatars'];
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		'ALLOW_AVATAR' => $board_config['allow_avatar_upload'],


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
		'RANDOM_AVATARS_YES' => ( $random_avatars ) ? 'checked="checked"' : '',
		'RANDOM_AVATARS_NO' => ( !$random_avatars ) ? 'checked="checked"' : '',
		'RANDOM_AVATAR_GALLERY' => $random_avatar_gallery,
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
		'L_AVATAR_PANEL' => $lang['Avatar_panel'],


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
		'L_RANDOM_AVATARS' => $lang['Use_random_avatars'],
		'L_RANDOM_AVATAR_GALLERY' => $lang['Random_avatar_gallery'],
		'L_ALL_AVATAR_TYPES' => $lang['All_avatar_types'],
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
$template->pparse('body');


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $mode != 'register' && $userdata['admin_randomavatars'] == 1 && $userdata['user_allowavatar'] == 1 && $board_config['allow_random_avatars'] == 1 )
{
	$template->assign_block_vars('switch_avatar_block.switch_admin_random_avatars', array() );
}
if ( $mode != 'register' && $userdata['user_randomavatars'] == 1 && $userdata['admin_randomavatars'] == 1 && $userdata['user_allowavatar'] == 1 && $board_config['allow_random_avatars'] == 1 )
{
	$template->assign_block_vars('switch_avatar_block.switch_random_avatars', array() );
}
//---------END---------//


#
#-----[ OPEN ]---------------------------------
#
includes/usercp_viewprofile.php


#
#-----[ FIND ]---------------------------------
#
$sql = "SELECT *
	FROM " . RANKS_TABLE . "


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $profiledata['user_randomavatars'] == 1 && $profiledata['admin_randomavatars'] == 1 && $profiledata['user_allowavatar'] == 1 )
{
	$user_id = $profiledata['user_id'];
	$sql = "SELECT * FROM " . AVATARS_TABLE . " WHERE user_id = '$user_id' ORDER BY av_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain avatar information', '', __LINE__, __FILE__, $sql);
	}
	$i = 0;
	WHILE ( $row = $db->sql_fetchrow($result) )
	{
		$i++;
		if ( $i == 8 )
		{
			$break = "<br />";
			$i = 0;
		}
		else
		{
			$break = "";
		}
		$next_avatar = $row['user_avatar'];

		$cnt_chrs = strlen( $board_config['avatar_gallery_path'] );

		if ( substr($next_avatar, 0, 4) == "http" )
		{
			$show_avatars = $show_avatars . "<img src=\"" . $next_avatar . "\" border=0 />&nbsp;" . $break;
		}
		else if ( substr($next_avatar, 0, $cnt_chrs) == $board_config['avatar_gallery_path'] )
		{
			$show_avatars = $show_avatars . "<img src=\"" . $next_avatar . "\" border=0 />&nbsp;" . $break;
		}
		else
		{
			$show_avatars = $show_avatars . "<img src=\"" . $board_config['avatar_path'] . "/" . $next_avatar . "\" border=0 />&nbsp;" . $break;
		}
	}
	$display_gallery = $show_avatars;
}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
	switch( $profiledata['user_avatar_type'] )


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $profiledata['user_randomavatars'] != 1 || $profiledata['admin_randomavatars'] != 1 )
{
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
$avatar_img = ( $board_config['allow_avatar_local'] ) 
			break;
	}


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
}
else
{
	$user_id = $profiledata['user_id'];
	$sql = "SELECT user_avatar FROM " . AVATARS_TABLE . " WHERE user_id = '$user_id' ORDER BY RAND() LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain avatar information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$image_path = $row['user_avatar'];

	$cnt_chrs = strlen( $board_config['avatar_gallery_path'] );

	if ( substr($image_path, 0, 4) == "http" )
	{
		$avatar_img = "<img src=\"" . $image_path . "\" border=\"0\" />";
	}
	else if ( substr($image_path, 0, $cnt_chrs) == $board_config['avatar_gallery_path'] )
	{
		$avatar_img = "<img src=\"" . $image_path . "\" border=\"0\" />";
	}
	else
	{
		$avatar_img = "<img src=\"" . $board_config['avatar_path'] . "/" . $image_path . "\" border=\"0\" />";
	}
}
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
	'AVATAR_IMG' => $avatar_img,


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
	'DISPLAY_GALLERY' => $display_gallery,
	'L_RANDOM_AVATAR_GALLERY' => $lang['Random_avatar_gallery'],
//--------END---------//


#
#-----[ FIND ]---------------------------------
#
$template->pparse('body');


#
#-----[ BEFORE, ADD ]---------------------------------
#
// Random Avatars Mod //
if ( $display_gallery != "" )
{
     $template->assign_block_vars('switch_random_avatars',array() );
}
//--------END---------//


#
#-----[ OPEN ]---------------------------------
#
language/lang_english/lang_main.php


#
#-----[ FIND ]---------------------------------
#
$lang['Avatar'] = 'Avatar';


#
#-----[ AFTER, ADD ]---------------------------------
#
// Random Avatars Mod //
$lang['Random_avatars_mod'] = 'Random Avatars Mod';
$lang['Use_random_avatars'] = 'Use random avatars';
$lang['All_avatar_types'] = 'For use with all types of avatars';
$lang['Random_avatar_gallery'] = 'Random Avatar Gallery';
$lang['Random_avatars_override'] = '(Admin) Random Avatars Enabled';
//--------END---------//


#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/profile_add_body.tpl


#
#-----[ FIND ]---------------------------------
#
	<!-- END switch_avatar_local_gallery -->


#
#-----[ AFTER, ADD ]---------------------------------
#
<!-- Random Avatars Mod -->
<!-- BEGIN switch_admin_random_avatars -->
<tr>
	<td class="row1"><span class="gen">{L_RANDOM_AVATARS}:</span></td>
	<td class="row2"><span class="gen">
	<input type="radio" name="random_avatars" value="1" {RANDOM_AVATARS_YES} />{L_YES}
	<input type="radio" name="random_avatars" value="0" {RANDOM_AVATARS_NO} />{L_NO}</span>
	<span class="gensmall"> ({L_ALL_AVATAR_TYPES})</span></td>
</tr>
<!-- END switch_admin_random_avatars -->
<!-- BEGIN switch_random_avatars -->
<tr>
	<td colspan="2" class="row2" width="100%" align="center" valign="middle"><span class="gen">{L_RANDOM_AVATAR_GALLERY}</span></td>
</tr>
<tr>
	<td colspan="2" class="row1" width="100%" align="center"><span class="gensmall">{RANDOM_AVATAR_GALLERY}</span></td>
</tr>
<!-- END switch_random_avatars -->


#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/profile_view_body.tpl


#
#-----[ FIND ]---------------------------------
#
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">


#
#-----[ BEFORE, ADD ]---------------------------------
#
<!-- Random Avatars Mod -->
<!-- BEGIN switch_random_avatars -->
<table class="forumline" width="100%" border="0">
	<tr>
		<th class="thhead" height="25">{L_RANDOM_AVATAR_GALLERY}</th>
	</tr>
	<tr>
		<td align="center">{DISPLAY_GALLERY}</td>
	</tr>
</table>
<!-- END switch_random_avatars -->


#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/admin/board_config_body.tpl


#
#-----[ FIND ]---------------------------------
#
	  <th class="thHead" colspan="2">{L_AVATAR_SETTINGS}</th>
	</tr>


#
#-----[ AFTER, ADD ]---------------------------------
#
<!-- Random Avatars Mod -->
	<tr>
		<td class="row1">{L_RANDOM_AVATARS}</td>
		<td class="row2"><input type="radio" name="allow_random_avatars" value="1" {RANDOM_AVATARS_YES} /> {L_ENABLED}&nbsp;&nbsp;<input type="radio" name="allow_random_avatars" value="0" {RANDOM_AVATARS_NO} /> {L_DISABLED}</td>
	</tr>


#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/admin/user_edit_body.tpl


#
#-----[ FIND ]---------------------------------
#
	<!-- END avatar_local_gallery -->


#
#-----[ AFTER, ADD ]---------------------------------
#
<!-- Random Avatars Mod -->
<!-- BEGIN random_avatars -->
	<tr>
		<td class="row1"><span class="gen">{L_RANDOM_AVATARS}:</span></td>
		<td class="row2">	<input type="radio" name="random_avatars" value="1" {RANDOM_AVATARS_YES} />
					<span class="gen">{L_YES}</span>
					<input type="radio" name="random_avatars" value="0" {RANDOM_AVATARS_NO} />
					<span class="gen">{L_NO}</span><span class="gensmall"> ({L_ALL_AVATAR_TYPES})</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_ADMIN_RANDOM_AVATARS}:</span></td>
		<td class="row2"> <input type="radio" name="admin_random_avatars" value="1" {ADMIN_RANDOM_AVATARS_YES} />
					<span class="gen">{L_YES}</span>
					<input type="radio" name="admin_random_avatars" value="0" {ADMIN_RANDOM_AVATARS_NO} />
					<span class="gen">{L_NO}</span></td>
	</tr>
	<tr>
		<td class="row2" colspan="2" width="100%" align="center" valign="middle"><span class="gen">{L_RANDOM_AVATAR_GALLERY}</span></td>
	</tr>
	<tr>
		<td class="row1" colspan="2" width="100%" align="center"><span class="gensmall">{RANDOM_AVATAR_GALLERY}</span></td>
	</tr>
<!-- END random_avatars -->


#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM