############################################################## 
## MOD Title: Template Rank Images
## MOD Author: netclectic < adrian@netclectic.com > (Adrian Cockburn) www.netclectic.com 
## MOD Description: Enable templates to use different rank images. Also allows for different
##     rank images per language. Adds rank image to users profile.
## MOD Version: 1.0.3
## 
## Installation Level: Easy
## Installation Time: 5 Minutes 
## Files To Edit: (6)  subSilver.cfg, admin_ranks.php, usercp_viewprofile.php, viewtopic.php, 
##                     profile_view_body.tpl, lang_admin.php
##
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: upload your rank image files into you template images lang directory 
##         eg. templates/subSilver/images/lang_english
##
############################################################## 
## MOD History: 
## 
##   2003-11-07 - Version 1.0.3
##      - updated for 2.0.6
## 
##   xxxx-xx-xx - Version 1.0.2    
##      - Confirmed with 2.0.4. Updated to be EasyMod compliant.
## 
##   xxxx-xx-xx - Version 1.0.1
##      - Fix problem with script. Update to new mod template.
##      - Incorporate adding of rank image to users profile.
## 
##   xxxx-xx-xx - Version 1.0.0
##      - Original Release
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
?>

# 
#-----[ BEFORE, ADD ]----------------------------------- 
# 
$images['rank'] = "$current_template_images/{LANG}/";


# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_ranks.php

# 
#-----[ FIND ]------------------------------------------ 
# 
"IMAGE_DISPLAY" => ( $rank_info['rank_image'] != "" ) ? '<img src="../' . $rank_info['rank_image'] . '" />' : "",

# 
#-----[ IN-LINE FIND ]----------------------------------
# 
'<img src="../'

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------- 
# 
 . $images['rank']
 
 
# 
#-----[ OPEN ]------------------------------------------ 
#
#
includes/usercp_viewprofile.php
 
# 
#-----[ FIND ]------------------------------------------ 
# 
# the first instance of
#
$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';

# 
#-----[ IN-LINE FIND ]----------------------------------
# 
'<img src="' 

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------- 
# 
. $images['rank']

# 
#-----[ FIND ]------------------------------------------ 
# 
# the second instance of
#
$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';

# 
#-----[ IN-LINE FIND ]----------------------------------
# 
'<img src="'

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------- 
# 
 . $images['rank']


# 
#-----[ OPEN ]------------------------------------------ 
#
viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 
# the first instance of
#
$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';

# 
#-----[ IN-LINE FIND ]----------------------------------
# 
'<img src="'

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------- 
# 
 . $images['rank']
 
# 
#-----[ FIND ]------------------------------------------ 
#
# the second instance of
# 
$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';

# 
#-----[ IN-LINE FIND ]----------------------------------
# 
'<img src="'

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------- 
# 
 . $images['rank']

 
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/profile_view_body.tpl  

# 
#-----[ FIND ]------------------------------------------ 
# 
<td class="row1" height="6" valign="top" align="center">{AVATAR_IMG}<br /><span class="postdetails">{POSTER_RANK}</span></td>

# 
#-----[ IN-LINE FIND ]----------------------------------
# 
{AVATAR_IMG}<br />

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------
# 
<br />{RANK_IMAGE}


# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Rank_image']

# 
#-----[ REPLACE WITH ]----------------------------------
# 
$lang['Rank_image'] = 'Rank Image';


# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Rank_image_explain']

# 
#-----[ REPLACE WITH ]----------------------------------
# 
$lang['Rank_image_explain'] = 'Use this to define a small image associated with the rank.<br>Remember to upload rank image to each template images/lang_xxx directory.';

# 
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
# 
# EoM 
