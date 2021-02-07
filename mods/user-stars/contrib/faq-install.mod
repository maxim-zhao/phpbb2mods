############################################################## 
## MOD Title: User Stars FAQ add-on
## MOD Author: cherokee red < mods@cherokeered.co.uk> (Kenny Cameron) http://www.cherokeered.co.uk/f/
## MOD Description: Add-on for the 'Users Stars' MOD - adds a blurb in the FAQ relating to user stars
## MOD Version: 1.0.1
## 
## Installation Level: Easy 
## Installation Time: ~1 Minute
## Files To Edit: language/lang_english/lang_faq.php,
##      
## Included Files: n/a
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
##
## This is *NOT* a reputation MOD and never will be.
## This MOD does *NOT* giver users extra permissions if they have a star.
## It's just a simple way of pointing out donators/helpers without mucking up ranks and custom titles 
##
############################################################## 
## MOD History: 
## 
##   2006-12-19 - Version 1.0.1
##      - First release 
## 
##   2006-12-19 - Version 1.0.1
##      - Fixed a typo
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_faq.php
# 
#-----[ FIND ]------------------------------------------ 
# Note that this line is longer
#
$faq[] = array("How do I become a Usergroup Moderator?",
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// User Stars  ::  cherokee red
$faq[] = array("What is a starred user and how do I become one?", "A starred user is someone who has done something special for the site/forums. This can include giving a donation, sorting a problem, hosting files or generally being a good poster. Stars are given at the discretion of the forum Administrators and are not based on ranks, postcounts or donations.");
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
