##############################################################
## MOD Title: Fast Resize Remote Avatar Mod
## MOD Author: etncrew < spambots@hotmail.com > (Oker) http://www.etncrew.com/forum
## MOD Description: Sets all avatars' widths to the maximum width set in the ACP, without checking
## for the actual image width, which makes this mod faster then others. To maintain the
## aspect ratio, the image height will automaticly  be decreased (or increased!) with the same
## percentage as the width.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: viewtopic.php, groupcp.php, memberlist.php, includes/usercp_viewprofile.php,
## includes/usercp_register.php
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: Thanks to tomlevens for inspiration! Gotta give credits ;)
##               Thanks to mosymuis (phpBB.nl) for a part of the idea and code!
##
## EasyMod compliant!
##
##############################################################
## MOD History:
##
##   2004-10-20 - Version 1.0.1
##      - Added avatar resize for admin page
##
##   2004-10-20 - Version 1.0.0
##      - Initial mod
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################


#
#-----[ OPEN ]------------------------------------------
#

viewtopic.php

#
#-----[ FIND ]------------------------------------------
#

         case USER_AVATAR_REMOTE:
            $poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';

#
#-----[ REPLACE WITH ]------------------------------------------
#

         
         case USER_AVATAR_REMOTE:
            //Start - Fast Resize Remote Avatar Mod
            //ADD
            global $board_config;
            $max_width = $board_config['avatar_max_width'];
            
            //REMOVE
            //$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
               
            //ADD         
            $poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img width="' . $max_width . '" src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
            //End - Fast Resize Remote Avatar Mod

#
#-----[ OPEN ]------------------------------------------
#

groupcp.php

#
#-----[ FIND ]------------------------------------------
#

         case USER_AVATAR_REMOTE:
            $poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';

#
#-----[ REPLACE WITH ]------------------------------------------
#

         case USER_AVATAR_REMOTE:
            //Start - Fast Resize Remote Avatar Mod
            //ADD
            global $board_config;
            $max_width = $board_config['avatar_max_width'];

            //REMOVE
            //$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';

            //ADD
            $poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img width="' . $max_width . '" src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
            //End - Fast Resize Remote Avatar Mod
                     
#
#-----[ OPEN ]------------------------------------------
#

memberlist.php

#
#-----[ FIND ]------------------------------------------
#

            case USER_AVATAR_REMOTE:
               $poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';

#
#-----[ REPLACE WITH ]------------------------------------------
#

            case USER_AVATAR_REMOTE:
               //Start - Fast Resize Remote Avatar Mod
               //ADD
               global $board_config;
               $max_width = $board_config['avatar_max_width'];
               
               //REMOVE
               //$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
               
               //ADD      
               $poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img width="' . $max_width . '" src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
               //End - Fast Resize Remote Avatar Mod

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#

      case USER_AVATAR_REMOTE:
         $avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';

#
#-----[ REPLACE WITH ]------------------------------------------
#

      case USER_AVATAR_REMOTE:
         //Start - Fast Resize Remote Avatar Mod
         //ADD
         global $board_config;
         $max_width = $board_config['avatar_max_width'];
         
	   //REMOVE
         //$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';

         //ADD      
         $avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img width="' . $max_width . '" src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
         //End - Fast Resize Remote Avatar Mod
                     
#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#

         case USER_AVATAR_REMOTE:
            $avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" />' : '';

#
#-----[ REPLACE WITH ]------------------------------------------
#

         case USER_AVATAR_REMOTE:
            //Start - Fast Resize Remote Avatar Mod
            //ADD
            global $board_config;
            $max_width = $board_config['avatar_max_width'];
            
		//REMOVE
            //$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" />' : '';

            //ADD      
            $avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img width="' . $max_width . '" src="' . $user_avatar . '" alt="" />' : '';
            //End - Fast Resize Remote Avatar Mod
                     
#
#-----[ OPEN ]------------------------------------------
#

admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#

				case USER_AVATAR_REMOTE:
					$avatar = '<img src="' . $user_avatar . '" alt="" />';

#
#-----[ REPLACE WITH ]------------------------------------------
#

				case USER_AVATAR_REMOTE:
			            //Start - Fast Resize Remote Avatar Mod
			            //ADD
			            global $board_config;
			            $max_width = $board_config['avatar_max_width'];
					//REMOVE
					//$avatar = '<img src="' . $user_avatar . '" alt="" />';
			
			            //ADD      
					$avatar = '<img width="' . $max_width . '" src="' . $user_avatar . '" alt="" />';
			            //End - Fast Resize Remote Avatar Mod

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM