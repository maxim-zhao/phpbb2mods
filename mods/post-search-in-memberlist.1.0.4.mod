############################################################## 
## MOD Title: Post search in memberlist
## MOD Author: Cherokee Red < cherokeered@blueyonder.co.uk > (Kenny Cameron) http://mrikasu.com/cherokeered
## MOD Description: Makes the members postcount in the memberlist, a link to a search of all the posts they have made.
## MOD Version: 1.0.4
## 
## Installation Level: Easy 
## Installation Time: ~1 Minute
## Files To Edit: memberlist.php
## 		  templates/subSilver/memberlist_body.tpl
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
## 
## These are the kind of things I do when i'm bored and home from college ;)
## I basically grabbed this code from usercp_viewprofile, as there's a search link in there. it shouldn't conflict with anything :)
## 
############################################################## 
## MOD History: 
## 
##   2004-09-07 - Version 1.0.0 
##      - mod created
##
##   2004-09-13 - Version 1.0.1
##      - mod updated to comply with validation/coding standards. 
##
##   2004-09-22 - Version 1.0.2
##      - mod updated <again ;)> to comply with validation/coding standards. 
##
##   2004-09-24 - Version 1.0.3
##      - mod updated useless code removed :) - tested with EasyMod v 0.1.13 and it seems to be compatible =)
##
##   2004-09-24 - Version 1.0.4
##      - mod updated - removed constant underline on the link - i.e. the link only becomes underlined when you hover your mouse over it. Thanks to battye for noticing this :)
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

			'YIM' => $yim,
#
#-----[ AFTER, ADD ]------------------------------------------ 
#

			'U_SEARCH_USER_POSTS' => append_sid("search.$phpEx?search_author=" . urlencode($username) . "&amp;showresults=posts"),
#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/memberlist_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 

     <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.POSTS} 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
{memberrow.POSTS} 
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
<a href="{memberrow.U_SEARCH_USER_POSTS}" class="gen">{memberrow.POSTS}</a>

#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM