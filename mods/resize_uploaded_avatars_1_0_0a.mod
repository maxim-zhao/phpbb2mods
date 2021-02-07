##############################################################
## MOD Title: Resize Uploaded Avatars
## MOD Author: black001 < black@salamandersoftware.ca > (Brian Lack) http://www.salamandersoftware.ca
## MOD Description: Resizes uploaded avatars to the maximum dimensions.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 10 Minutes
## Files To Edit: usercp_avatar.php,
##      lang_main.php
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
## Author Notes:
## This MOD will automatically resize the uploaded avatar to the
## Maximum Avatar Dimensions set in General Configuration. For example,
## if you upload a 400 x 300 avatar and the admin set avatar size to
## 100 x 100, this MOD will resize the avatar proportionally to 100 x 75. 
## This MOD handles GIF, PNG and JPEG images. This MOD requires the
## GD Library version 2.0.28 or higher. I deleted some instructions
## on the profile page, so if you have a multilingual board you must
## apply the change to lang_main.php of each language. After applying
## this MOD, Maximum Avatar File Size in General Configuration will
## apply to the original avatar before it is resized, so you might
## as well set it to something high like 2048000 (2000 KB).
##
##############################################################
## MOD History:
##
##   2006-01-08 - Version 0.0.0
##      - initial version
##   2006-04-19 - Version 1.0.0
##      - code standards compliance
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
	if ( $width > 0 && $height > 0 && $width <= $board_config['avatar_max_width'] && $height <= $board_config['avatar_max_height'] )

#
#-----[ REPLACE WITH ]------------------------------------------
#
	if ( $width > 0 && $height > 0 )

#
#-----[ FIND ]------------------------------------------
#
		@chmod('./' . $board_config['avatar_path'] . "/$new_filename", 0777);

#
#-----[ AFTER, ADD ]------------------------------------------
#
		if ($width > $board_config['avatar_max_width'] || $height > $board_config['avatar_max_height'])
		{
			$width_old = $width;
			$height_old = $height;
			if ($width > $board_config['avatar_max_width'])
			{
				$height = ($board_config['avatar_max_width'] / $width) * $height;
				$width = $board_config['avatar_max_width'];
			}
			if ($height > $board_config['avatar_max_height'])
			{
				$width = ($board_config['avatar_max_height'] / $height) * $width;
				$height = $board_config['avatar_max_height'];
			}
			$width = round ($width);   // to avoid float->integer conversion problems
			$height = round ($height); // to avoid float->integer conversion problems
			switch ($imgtype)
			{
				case '.jpg':
					$imagecreatefrom_function = 'imagecreatefromjpeg';
					$image_function = 'imagejpeg';
					break;
				case '.gif':
					$imagecreatefrom_function = 'imagecreatefromgif';
					$image_function = 'imagegif';
					break;
				case '.png':
					$imagecreatefrom_function = 'imagecreatefrompng';
					$image_function = 'imagepng';
					break;
			}
			$img_old = $imagecreatefrom_function ('./' . $board_config['avatar_path'] . "/$new_filename");
			$img_new = imagecreatetruecolor ($width, $height);
			imagecopyresampled ($img_new, $img_old, 0, 0, 0, 0, $width, $height, $width_old, $height_old);
			$image_function ($img_new, './' . $board_config['avatar_path'] . "/$new_filename");
			imagedestroy ($img_new);
		}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Avatar_explain']

#
#-----[ IN-LINE FIND ]------------------------------------------
#
'Displays a small graphic image below your details in posts. Only one image can be displayed at a time, its width can be no greater than %d pixels, the height no greater than %d pixels, and the file size no more than %d KB.'

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
'Displays a small graphic image below your details in posts. Only one image can be displayed at a time.'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM