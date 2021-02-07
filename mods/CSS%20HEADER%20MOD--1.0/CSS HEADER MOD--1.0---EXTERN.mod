##############################################################
## MOD Title: bloody_nOOb`s CSS HeaderMenu 0.1 extern *.css
## MOD Author: bloody_nOOb < bloodhaunter@flashmail.fm > (bloody_nOOb) http://bloodhaunter.funpic.de/
## MOD Description: This MOD changes the look of the Forum Navigation
##                  (Adds CSS Textstyled Menu and removes the used Icons).
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 4 minutes
## Files To Edit: templates/subSilver/overall_header.tpl
##                templates/subSilver/subSilver.css
## Included Files: 
## Generator: MOD Studio 3.0 Beta 1 [mod functions 0.4.1788.30363]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
## Use this Version ONLY if you use a extern *.css file.
## If you want to use this MOD in other Styles then subSilver just repeat the Install-Steps for 
## every installed Style where you like to use this MOD.
##############################################################
## MOD History:
## 
##   2004-11-28 - Version 1.0.0
## 
##      - First Stable release. Version 1.0.0 of a MOD is always it's first stable release.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
 <td align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><br /><span class="gen">{SITE_DESCRIPTION}<br />&nbsp; </span> 
 <table cellspacing="0" cellpadding="2" border="0">
					<tr> 
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a></span><span class="mainmenu">&nbsp; &nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH}</a>&nbsp; &nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_members.gif" width="12" height="13" border="0" alt="{L_MEMBERLIST}" hspace="3" />{L_MEMBERLIST}</a>&nbsp; &nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_USERGROUPS}" hspace="3" />{L_USERGROUPS}</a>&nbsp; 
						<!-- BEGIN switch_user_logged_out -->
						&nbsp;<a href="{U_REGISTER}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_register.gif" width="12" height="13" border="0" alt="{L_REGISTER}" hspace="3" />{L_REGISTER}</a></span>&nbsp;
						<!-- END switch_user_logged_out -->
						</td>
					</tr>
					<tr>
						<td height="25" align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>&nbsp; &nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;</span></td>
					</tr>
				</table></td>
			</tr>
		</table>

		<br />

#
#-----[ REPLACE WITH ]------------------------------------------
#
<td align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><br /><span class="gen">{SITE_DESCRIPTION}<br />&nbsp; </span> 
<table cellspacing="0" cellpadding="2" border="0">
</table></td>
  
<br>
<!-- bloody_nOOb`s CSS HeaderMenu 0.1 -->
<table hspace="3" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
<td height="28" align="left" nowrap class="men" valign="center"> 
<!-- ENABLE NEXT ITEM IF YOU GOT A PORTAL SYSTEM INSTALLED!!!! -->
<!-- <a href="{U_PORTAL}" class="men" >PORTAL</a> -->
    <a href="{U_INDEX}" class="men" >{L_INDEX}</a>
  <!-- BEGIN switch_user_logged_out -->
	  <a href="{U_REGISTER}" class="men" >{L_REGISTER}</a>
  <!-- END switch_user_logged_out -->
    <a href="{U_PRIVATEMSGS}" class="men">{PRIVATE_MESSAGE_INFO}</a> 
    <a href="{U_LOGIN_LOGOUT}" class="men" >{L_LOGIN_LOGOUT}</a>
	  <a href="{U_FAQ}" class="men" >{L_FAQ}</a>
	  <a href="{U_SEARCH}" class="men" >{L_SEARCH}</a>
  <!-- BEGIN switch_user_logged_in -->
	  <a href="{U_MEMBERLIST}" class="men" >{L_MEMBERLIST}</a>
 	<!-- END switch_user_logged_out -->
  <!-- BEGIN switch_user_logged_in -->
    <a href="{U_GROUP_CP}" class="men" >{L_USERGROUPS}</a>
  <!-- END switch_user_logged_out -->
  <!-- BEGIN switch_user_logged_in --> 
    <a href="{U_PROFILE}" class="men" >{L_PROFILE}</a>
  <!-- END switch_user_logged_out -->
</td>
 </tr>
</table>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.css
#
#-----[ FIND ]------------------------------------------
#
 /* General page style. The scroll bar colours only visible in IE5.5+ */
#
#-----[ BEFORE, ADD ]------------------------------------------
#
/*bloody_nOOb`s CSS HeaderMenu 0.1 */
a:link.men {
	background-color : darkblue;
	font : menu;
	color : white;
	text-transform : none;
	margin-right : 2px;
	padding-top : 2px;
	padding-bottom : 2px;
	padding-left : 4px;
	padding-right : 4px;
	border-top : 1px solid silver;
	border-left : 1px solid silver;
	border-right : 1px solid silver;
	border-bottom : 1px solid : silver;
	text-decoration: none;
		}

a:visited.men {
	background-color : darkblue;
	font : menu;
	color : white;
	text-transform : none;
	margin-right : 2px;
	padding-top : 2px;
	padding-bottom : 2px;
	padding-left : 4px;
	padding-right : 4px;
	border-top : 1px solid silver;
	border-left : 1px solid silver;
	border-right : 1px solid silver;
	border-bottom : 1px solid : silver;
	text-decoration: none;
		}


a:hover.men {
	color: blue;
  background-color : #F3F3F3;
	font : menu;
	padding-top : 2px;
	padding-bottom : 2px;
	padding-left : 4px;
	padding-right : 4px;
	border-top : 1px solid silver;
	border-left : 1px solid silver;
	border-right : 1px solid silver;
	border-bottom : 1px solid : silver;
		}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM




