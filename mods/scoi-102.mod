############################################################## 
## MOD Title: Split Categories On Index
## MOD Author: DanielT < scoi.mods@danielt.com > (Daniel Taylor) http://www.danielt.com 
## MOD Description: Splits up the category areas on your index page
## MOD Version: 1.0.2
## 
## Installation Level: easy
## Installation Time: ~1 Minutes 
## Files To Edit: index_body.tpl
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: n/a
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline"> 
  <tr> 
   <th colspan="2" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th> 
   <th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th> 
   <th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th> 
   <th class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th> 
  </tr> 
  <!-- BEGIN catrow --> 
  <tr> 
   <td class="catLeft" colspan="2" height="28"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td> 
   <td class="rowpic" colspan="3" align="right">&nbsp;</td> 
  </tr> 
  <!-- BEGIN forumrow --> 
  <tr> 
   <td class="row1" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="46" height="25" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td> 
   <td class="row1" width="100%" height="50"><span class="forumlink"> <a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a><br /> 
     </span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br /> 
     </span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td> 
   <td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td> 
   <td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td> 
   <td class="row2" align="center" valign="middle" height="50" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td> 
  </tr> 
  <!-- END forumrow --> 
  <!-- END catrow --> 
</table>
#
#-----[ REPLACE WITH ]------------------------------------
#
<!-- BEGIN catrow --> 
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline"> 
  <tr> 
   <th colspan="2" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th> 
   <th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th> 
   <th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th> 
   <th class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th> 
  </tr> 
  <tr> 
   <td class="catLeft" colspan="2" height="28"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td> 
   <td class="rowpic" colspan="3" align="right">&nbsp;</td> 
  </tr> 
  <!-- BEGIN forumrow --> 
  <tr> 
   <td class="row1" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" width="46" height="25" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td> 
   <td class="row1" width="100%" height="50"><span class="forumlink"> <a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a><br /> 
     </span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br /> 
     </span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td> 
   <td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td> 
   <td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.POSTS}</span></td> 
   <td class="row2" align="center" valign="middle" height="50" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td> 
  </tr> 
  <!-- END forumrow -->
  </table>
  <br /> 
  <!-- END catrow -->
#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------
# EoM

