############################################################## 
## MOD Title: Next/Previous topic link below post 
## MOD Author: Cherokee Red < cherokeered@blueyonder.co.uk > (Kenny Cameron) 
## http://mrikasu.com/cherokeered 
## MOD Description: Adds the "view previous topic :: view next topic" links at the bottom of the page, below the posts 
## MOD Version: 0.0.3
## 
## Installation Level: Easy 
## Installation Time: 1 Minute
## Files To Edit: templates/subSilver/viewtopic_body.tpl
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: I wanted to make a mod of my own, so I checked in requests, found this topic - "http://www.phpbb.com/phpBB/viewtopic.php?t=220129" and made the mod :)
## 
############################################################## 
## MOD History: 
## 
##   2004-08-25 - Version 0.0.1 
##      - First mod i've made, so woo \o/. if i can code it right, next version will place it next to the search posts box at the bottom.
##
##   2004-08-25 - Version 0.0.2 
##      - Made a mistake in the alignment - was set to right and not left
##
##   2004-08-25 - Version 0.0.3 
##      - created a table for the links to sit in. Now they will align properly to the right, although not where I want them to be yet ;)
##
##   2004-08-25 - Version 1.0.0 
##      - Mod updated to version 1.0.0 and submitted to mods db. no changes to the code were made.
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
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
<table align="right">
	<tr>
		<td><span class="nav"><a href="{U_VIEW_OLDER_TOPIC}" class="nav">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEWER_TOPIC}" class="nav">{L_VIEW_NEXT_TOPIC}</a></span></td>
		</tr>
</table>
<br />
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
