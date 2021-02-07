##############################################################
## MOD Title:          Avatars Secret Gallery
## MOD Author:         3Di < 3d@you3d.za.net > (Marco) http://phpbb2italia.za.net/phpbb2/index.php
## MOD Author:         Merlin Sythove < Merlin@silvercircle.org > (N/A) http://www.silvercircle.org/forum
## MOD Description:    Lets ADMIN and MODerators have an Avatars Secret Gallery that doesn't appear to 
##                                Registered Users
## MOD Version:        1.0.3
##
## Installation Level: (Easy) 
## Installation Time:  2 Minutes
## Files To Edit:
##      includes/usercp_avatar.php
##      
## Included Files:
##      images/avatars/gallery/1SecretGallery/*.* (39 avatars based on Advanced Dungeons and Dragons)
##      pre-modded/includes/usercp_avatar.php (pre-modded file for phpBB 2.0.17 fresh installs)
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
##
##	Original Author is: Merlin Sythove http://www.phpbb.com/phpBB/viewtopic.php?p=1738035 (thanks Merlin)
##
##	Please note that once an avatar is in use, and if you allow linking to URLS, 
##	any user can simply copy the url to your hidden avatar and use it if they like.
##	In this case i suggest you to customize your avatars as you like.
##	The change only affects the normal user profile page that the user sees / edits himself. 
##	There is no change in the admin section so as an admin you COULD give a user a secret avatar if you 
##	wanted, by editing the user profile via the ACP.
##
##	tested on a fresh phpBB 2.0.17
##
##	the folder 1SecretGallery can be renamed with one of your choise, remember to rename it also into the script.
##	remember it is CaseSensitive
##
##	I don't remember where i got the Avatars included in this package.
##
##	The mod includes allowing you to set a default folder with avatars, rather than the first one that comes up. 
##	This feature was necessary to prevent showing the hidden gallery if that happened to be the first folder
##	that was opened.
##
##############################################################
## MOD History:
##
##	2005-09-06 Version 1.0.3
##	- again another typo fixed
##	- resubmitted
##
##	2005-09-06 Version 1.0.2
##	- fixed minor errors on the script, nothing major
##	- submitted again
##	
##	2005-08-27 Version 1.0.1
##	- bug fixed (read Author Nothes), thanks Merlin Sythove
##	- included the pre-modded file for phpBB 2.0.17 (fresh installs only)
##	- MOD script rewritten ;-)
##	- packaged as 1.0.1 and submitted
##	- The MOD passed the MOD pre-validation process
##
##	2005-08-26 Version 1.0.0
##	- MOD script rewritten ;-)
##	- packaged as 1.0.0 and submitted
##	- The MOD passed the MOD pre-validation process
##
##	2005-08-26 - Version 0.1.1 BETA
##	- little typo fixed (nothing major on the code) 
##	- script amended, error fixed
##
##	2005-08-25 - Version 0.1.0 BETA
##
##	- first release as BETA (mod inherited from Merlin Sythove)
##	- a complete gallery of avatars has been included
##	- made that script
##	- packaged
##	- The MOD passed the MOD pre-validation process
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ COPY ]------------------------------------------
#
copy images/*.* to images/*:*
#
#-----[ DIY INSTRUCTIONS ]------------------------------------
#
if you have a fresh phpBB 2.0.17 the you can overwrite the file with the premodded one.

#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_avatar.php
#
#-----[ FIND ]------------------------------------------
#	the line is longer..
#
function display_avatar_gallery(
#
#-----[ FIND ]------------------------------------------
#
	global $phpbb_root_path, $phpEx;
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$phpEx
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------
#
, $userdata
#
#-----[ FIND ]------------------------------------------
#
		list($category, ) = each($avatar_images);
#
#-----[ AFTER, ADD ]------------------------------------------
#
//MOD Avatars Secret Gallery - Set the default category
		$category='NonSecretCategory';
#
#-----[ FIND ]------------------------------------------
#
	$s_categories = '<select name="avatarcategory">';
	while( list($key) = each($avatar_images) )
	{
#
#-----[ AFTER, ADD ]------------------------------------------
#
//----------- Unless MOD or ADMIN, hide the folder '1SecretGallery' ---------
		if ($userdata['user_level'] != USER || $key != '1SecretGallery' ) 
		{
#
#-----[ FIND ]------------------------------------------
#
		{
			$s_categories .= '<option value="' . $key . '"' . $selected . '>' . ucfirst($key) . '</option>';
		}
	}
#
#-----[ REPLACE WITH ]------------------------------------------
#
			{
				$s_categories .= '<option value="' . $key . '"' . $selected . '>' . ucfirst($key) . '</option>';
			}
		}
	}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
