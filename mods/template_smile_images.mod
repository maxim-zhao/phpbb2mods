############################################################## 
## MOD Title: Template Smile Images
## MOD Author: netclectic < adrian@netclectic.com > (Adrian Cockburn) http://www.netclectic.com 
## MOD Description: Allows you to have a different set of smilies per template. 
## MOD Version: 1.0.0
## 
## Installation Level: easy
## Installation Time: 5 Minutes 
## Files To Edit: (4) subSilver.cfg, bbcode.php, functions_post.php, lang_admin.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##
##      REMEMBER TO -
##          Upload smilie image files to the images directory for ALL your templates.
##              e.g. templates/subSilver/images/smiles
##          Change the 'Smilies Storage Path' to be relative to your templates images directory, 
##              e.g. 'smiles'
## 
############################################################## 
## MOD History:
##
##     2003-11-07  - Version 1.0.0
##          - initial release
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/subSilver.cfg

# 
#-----[ FIND ]------------------------------------------ 
# 
$current_template_images = $current_template_path . "/images";

# 
#-----[ AFTER, ADD ]------------------------------------
# 
$images['smiles'] = $current_template_images . '/' . $board_config['smilies_path'];


# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php

# 
#-----[ FIND ]------------------------------------------ 
# 
global $db, $board_config;

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#  
$board_config

# 
#-----[ IN-LINE REPLACE WITH ]----------------------------------
# 
$images


# 
#-----[ FIND ]------------------------------------------ 
# 
$repl[] = '<img src="'. $board_config['smilies_path']

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#  
$board_config['smilies_path']

# 
#-----[ IN-LINE REPLACE WITH ]----------------------------------
# 
$images['smiles']


# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_post.php

# 
#-----[ FIND ]------------------------------------------ 
# 
'SMILEY_IMG' => $board_config['smilies_path']

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#  
$board_config['smilies_path']

# 
#-----[ IN-LINE REPLACE WITH ]----------------------------------
# 
$images['smiles']


# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Smilies_path_explain']

# 
#-----[ REPLACE WITH ]----------------------------------
# 
$lang['Smilies_path_explain'] = 'Path relative to your template images directory, e.g. smiles';


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 