############################################################## 
## MOD Title: Previous/Next topic links on bottom of page
## MOD Author: Dennis Robinson < president@beachassaultstudios.com > (Lieutenant Clone) http://beachassaultstudios.com
## MOD Description: Adds "View previous topic :: Topic Title Here :: View next topic" links at the bottom of each page of
##                  posts, and replaces the prev/next links at the top with the page number.
## 
## MOD Version: 1.0.1
## 
## Installation Level: Easy 
## Installation Time: 1 Minute
## 
## Files To Edit (1) :	templates/subSilver/viewtopic_body.tpl
## 
## Included Files :	n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes:
## 
## Should work fine with any template.
## Should be Easymod compatible, although I haven't tested it yet.
## 
##############################################################
## MOD History: 
## 
## 1.0.1 ( 27/05/05 ) : Minor Fixes
## 
## 1.0.0 ( 27/05/05 ) : Mod released
## 
## 0.1.0 ( 18/04/05 ) : First beta
##
## 0.0.0 ( 17/04/05 ) : Mod started
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr align="right">
		<td class="catHead" colspan="2" height="28"><span class="nav"><a href="{U_VIEW_OLDER_TOPIC}" class="nav">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEWER_TOPIC}" class="nav">{L_VIEW_NEXT_TOPIC}</a> &nbsp;</span></td>
	</tr>
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<a href="{U_VIEW_OLDER_TOPIC}" class="nav">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEWER_TOPIC}" class="nav">{L_VIEW_NEXT_TOPIC}</a>
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
{PAGE_NUMBER}
#
#-----[ FIND ]------------------------------------------
#
  <tr>
	<td align="left" colspan="3"><span class="nav">{PAGE_NUMBER}</span></td>
  </tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
  <tr>
	<td align="center" colspan="3"><span class="nav"><a href="{U_VIEW_OLDER_TOPIC}" class="nav">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_TOPIC}" class="nav">{TOPIC_TITLE}</a> :: <a href="{U_VIEW_NEWER_TOPIC}" class="nav">{L_VIEW_NEXT_TOPIC}</a></span></td>
  </tr>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 