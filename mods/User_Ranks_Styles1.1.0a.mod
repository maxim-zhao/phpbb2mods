############################################################## 
## MOD Title: Rank styles in memberlist 
## MOD Author: DavidIQ < david@davidiq.com > (David Colon) http://www.davidiq.com 
## MOD Description: This mod will display the color style for mods and admins in the memberlist. 
## MOD Version: 1.1.0 
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
## File To Edit: memberlist.php
## 
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
## Author Notes: If you don't want to have an extra row in your memberlist page 
## then this is the mod for you 
## 
############################################################## 
## MOD History: 
##
##   2005-11-02 - Version 1.0 
##      - Mod creation 
## 
##   2005-11-21 - Version 1.0.2 
##      - Final changes made for validation 
##
##   2006-10-27 - Version 1.1
##     - Integrated template edit into php file edit reducing edited files to 1
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
memberlist.php 

# 
#-----[ FIND ]------------------------------------------ 
# 
$sql = "SELECT username, user_id, user_viewemail, user_posts, user_regdate, user_from, user_website, user_email, user_icq, user_aim, user_yim, user_msnm, user_avatar, user_avatar_type, user_allowavatar 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
user_id, 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
 user_level, 

# 
#-----[ FIND ]------------------------------------------ 
# 
      $user_id = $row['user_id']; 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
      switch ($row['user_level']) 
      { 
         case ADMIN : 
            $username_text_decoration = '#' . $theme['fontcolor3']; 
            break; 
         case MOD : 
            $username_text_decoration = '#' . $theme['fontcolor2']; 
            break; 
         default : $username_text_decoration = ''; 
      } 

# 
#-----[ FIND ]------------------------------------------ 
# 
         'USERNAME' => $username, 
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
                   'USERNAME' => '<span style="color: ' . $username_text_decoration . '">' . $username . '</span>',

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM