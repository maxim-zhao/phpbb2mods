############################################################## 
## MOD Title: View complete Avatar Directory Size
## MOD Author: lowjoel < webmaster@joelsplace.sg > (Joel Low) http://joelsplace.sg/
## MOD Description: Shows the complete Avatar directory size,
##                  inclusive of your avatar gallery.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit:  admin/index.php
##
## Included Files: N/A
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## MOD History:
##     2005-03-22  - Version 1.0.1
##          - Removed debug purpose-echos (Sorry!) I left it
##			  out while removing my debugging my script
##
##     2005-03-22  - Version 1.0.0
##          - Original release
##
############################################################## 
## Author Notes: 
## This MOD might require you to update your filesystem
## permissions. If it does not read your directory properly,
## and you are using a UNIX-based system (Linux etc), try
## CHMODing all image directories to 777 (World-readable,
## executable and writable). Technically this is not needed,
## but is a last resort. My server lets me read the folder
## perfectly with 755, I just wanted to let you all know - PHP
## is notorious for having filesystem problems which all stem
## from the directory having the wrong filesystem permissions.
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
#
admin/index.php

# 
#-----[ FIND ]------------------------------------------ 
#
function inarray($needle, $haystack)
{ 
	for($i = 0; $i < sizeof($haystack); $i++ )
	{ 
		if( $haystack[$i] == $needle )
		{ 
			return true; 
		} 
	} 
	return false; 
}
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

//-------------------------- MOD: View complete Avatar Directory Size MOD --------------------------
$folders;
function traverse($dir)
{
	global $folders;
	$dh=opendir($dir);
	while ($file=readdir($dh))
	{
	   if($file!=="." && $file!="..")
	   {
		   $fullpath=$dir."/".$file;
		   $avatar_dir_size += @filesize($dir."/".$file);
		   if(is_dir($fullpath))
		   {
				$current_entry = (empty($folders[0])) ? 0 : count($folders);
				$folders[$current_entry] = $fullpath;
				traverse($fullpath);
		   }
	   } else continue;
	}
	closedir($dh);
}
//-------------------------- End MOD: View complete Avatar Directory Size MOD --------------------------
# 
#-----[ FIND ]------------------------------------------ 
#
	if ($avatar_dir = @opendir($phpbb_root_path . $board_config['avatar_path']))
	{
		while( $file = @readdir($avatar_dir) )
		{
			if( $file != "." && $file != ".." )
			{
				$avatar_dir_size += @filesize($phpbb_root_path . $board_config['avatar_path'] . "/" . $file);
			}
		}
		@closedir($avatar_dir);

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	//-------------------------- MOD: View complete Avatar Directory Size MOD --------------------------
	//delete
	//	if ($avatar_dir = @opendir($phpbb_root_path . $board_config['avatar_path']))
	//	{
	//		while( $file = @readdir($avatar_dir) )
	//		{
	//			if( $file != "." && $file != ".." )
	//			{
	//				$avatar_dir_size += @filesize($phpbb_root_path . $board_config['avatar_path'] . "/" . $file);
	//			}
	//		}
	//		@closedir($avatar_dir);
	//add
	traverse($phpbb_root_path . "images/avatars");
	for($i = 0; $i < count($folders); $i++)
	{
		$dir = opendir($folders[$i]);
		while( $file = readdir($dir) )
		{
			if( $file != "." && $file != ".." )
			{
				$avatar_dir_size += filesize($folders[$i] . "/" . $file);
			}
		}
	}
	//-------------------------- End MOD: View complete Avatar Directory Size MOD --------------------------
# 
#-----[ FIND ]------------------------------------------ 
#
	}
	else
	{
		// Couldn't open Avatar dir.
		$avatar_dir_size = $lang['Not_available'];
	}
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	//-------------------------- MOD: View complete Avatar Directory Size MOD --------------------------
	//delete
	//}
	//else
	//{
		//// Couldn't open Avatar dir.
		//$avatar_dir_size = $lang['Not_available'];
	//}
	//-------------------------- End MOD: View complete Avatar Directory Size MOD -------------------------- 
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM