############################################################## 
## MOD Title: Guest No HTML/BBCode or Smilies
## MOD Author: defender-uk < defenders_realm@yahoo.com > (Andy Smith) http://www.phpbb-arcade.com
## MOD Description: Guest can not post HTML/BBCode or use Smilies
## MOD Version: 1.0.0 
##
## Installation Level: (Easy) 
## Installation Time: 2 Minutes 
## Files To Edit: 
##			posting.php
##
## Included Files: (N/A)
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
##
############################################################## 
##
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/ 
##
############################################################## 
##
## Author Notes: 
## 
## This mod was made due to people using my phpBB forum as a link for google to index thiers.
##
## v1.0.0 No matter what settings you have in the ACP, guests can NOT post HTML etc.
##
## In v1.1.0 I hope to strip out ALL bbcode.
##
############################################################## 
## MOD History: 
## 
##   2006-06-06 - Version 1.0.0 
##      - Guest HTML/BBCode and Smilies blocker 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------ 
# 
posting.php

#
#-----[ FIND ]------------------------------------------ 
# 
//
// Set toggles for various options
//
if ( !$board_config['allow_html'] )

#
#-----[ REPLACE WITH ]------------------------------------------ 
# 
//
// Set toggles for various options
//
if ( !$board_config['allow_html'] || $userdata['user_id'] == ANONYMOUS)

#
#-----[ FIND ]------------------------------------------ 
# 
if ( !$board_config['allow_bbcode'] )

#
#-----[ REPLACE WITH ]------------------------------------------ 
# 
if ( !$board_config['allow_bbcode'] || $userdata['user_id'] == ANONYMOUS)

#
#-----[ FIND ]------------------------------------------ 
# 
if ( !$board_config['allow_smilies'] )

#
#-----[ REPLACE WITH ]------------------------------------------ 
# 
if ( !$board_config['allow_smilies'] || $userdata['user_id'] == ANONYMOUS)

#
#-----[ FIND ]------------------------------------------ 
# 
//
// HTML toggle selection
//
if ( $board_config['allow_html'] )

#
#-----[ REPLACE WITH ]------------------------------------------ 
# 
//
// HTML toggle selection
//
if ( $board_config['allow_html'] && $userdata['user_id'] != ANONYMOUS )

#
#-----[ FIND ]------------------------------------------ 
# 
if ( $board_config['allow_bbcode'] )

#
#-----[ REPLACE WITH ]------------------------------------------ 
# 
if ( $board_config['allow_bbcode'] && $userdata['user_id'] != ANONYMOUS )

#
#-----[ FIND ]------------------------------------------ 
# 
if ( $board_config['allow_smilies'] )

#
#-----[ REPLACE WITH ]------------------------------------------ 
# 
if ( $board_config['allow_smilies'] && $userdata['user_id'] != ANONYMOUS )

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 

# EoM 
