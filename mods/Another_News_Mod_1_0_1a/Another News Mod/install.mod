##############################################################
## MOD Title: Another News Mod
## MOD Author: Janmarques < gigjan@gmail.com > (Jan Marques) http://www.janmarques.be.tt/
## MOD Description: These add-on files allow you to add last announces in a frame on your main website.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 4 minutes
## Files To Edit: language/lang_english/lang_main.php
## Included Files: announcements.php
##                 fetchposts.php
##                 news_body.tpl
##                 news_header.php
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2288.38406 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
##############################################################
## MOD History:
## 
## 2006-06-27 - Version 0.0.0
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy root/announcements.php to announcements.php
copy root/fetchposts.php to fetchposts.php
copy root/news_body.tpl to templates/subSilver/news_body.tpl
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Message'] = 'Message';
#
#-----[ AFTER, ADD ]------------------------------------------
#
//Start Another News Mod

$lang['Comments'] = 'Comments';
$lang['View_Comments'] = 'View Comments';
$lang['Post_Comments'] = 'Post Comments';
$lang['Home'] = 'News Site';
$lang['Read_Full'] = 'Read Full';
//End Another News Mod
#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
Now you can add http://linktoforum/announcements.php into a frame on you website.
Use for this <iframe src="http://linktoforum/announcements.php" width="70%" height="100%"></iframe>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
