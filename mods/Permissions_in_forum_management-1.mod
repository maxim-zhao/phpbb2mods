############################################################## 
## MOD Title: permissions_in_forum_management 
## MOD Author: Wicher < N/A > (Wicher) http://www.detecties.com/phpbb2018 
## MOD Description: Creates a link "Permissions" in ACP/Forum Admin/Management after each forum. 
## MOD Version: 1.0.0 
## 
## Installation Level: (Easy) 
## Installation Time: 10 Minutes 
## Files To Edit: admin/admin_forums.php, 
##      templates/subSilver/admin/forum_admin_body.tpl, 
## Included Files: (N/A) 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: (N/A)
## 
############################################################## 
## MOD History: 
## 
##   2006-08-17 - Version 1.0.0 
##      - One time release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_forums.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
	'L_RESYNC' => $lang['Resync'])
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	'L_FORUMPERMISSION' => $lang['Permissions'],
# 
#-----[ FIND ]------------------------------------------ 
# 
					'U_FORUM_RESYNC' => append_sid("admin_forums.$phpEx?mode=forum_sync&amp;" . POST_FORUM_URL . "=$forum_id"))
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
					'U_FORUMPERMISSION' => append_sid("admin_forumauth.$phpEx?" .POST_FORUM_URL .  "=$forum_id"),
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/forum_admin_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
		<th class="thHead" colspan="{%:1}">{L_FORUM_TITLE}</th>
# 
#-----[ INCREMENT ]------------------------------------------ 
# 
%:1
# 
#-----[ FIND ]------------------------------------------ 
# 
		<td class="catRight" align="center" valign="middle"><span class="gen">&nbsp;</span></td>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
		<td class="cat" align="center" valign="middle"><span class="gen">&nbsp;</span></td>
# 
#-----[ FIND ]------------------------------------------ 
# 
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{catrow.forumrow.U_FORUM_RESYNC}">{L_RESYNC}</a></span></td>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{catrow.forumrow.U_FORUMPERMISSION}">{L_FORUMPERMISSION}</a></span></td>
# 
#-----[ FIND ]------------------------------------------ 
# 
		<td colspan="{%:1}" class="row2"><input class="post" type="text" name="{catrow.S_ADD_FORUM_NAME}" /> <input type="submit" class="liteoption"  name="{catrow.S_ADD_FORUM_SUBMIT}" value="{L_CREATE_FORUM}" /></td>
# 
#-----[ INCREMENT ]------------------------------------------ 
# 
%:1

# 
#-----[ FIND ]------------------------------------------ 
# 
		<td colspan="{%:1}" height="1" class="spaceRow"><img src="../templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
# 
#-----[ INCREMENT ]------------------------------------------ 
# 
%:1
# 
#-----[ FIND ]------------------------------------------ 
# 
		<td colspan="{%:1}" class="catBottom"><input class="post" type="text" name="categoryname" /> <input type="submit" class="liteoption"  name="addcategory" value="{L_CREATE_CATEGORY}" /></td>
# 
#-----[ INCREMENT ]------------------------------------------ 
# 
%:1
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
