##############################################################
## MOD Title: View Next/Previous at Bottom of Topic
## MOD Author: StaticXD00d < staticxd00d@gmail.com > (N/A) N/A
## MOD Description: Adds View Next/Previous links at bottom of page of posts.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: ~1 minute
## Files To Edit: templates/subSilver/viewtopic_body.tpl
##				  
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2108.38030 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: This mod will add View Next/Previous links at 
## bottom of page of posts. It scoots the "Display posts from previous:" 
## dialogue to the far left of the footer, and places the 
## "View previous topic :: View next topic" links at the far right of the
## footer. 
##############################################################
## MOD History:
## 
## 2006-08-27 - Version 1.0.0
## Initial code
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
	<tr align="center"> 
#
#-----[ BEFORE, ADD ]---------------------------------------- 
#
	<!-- START MOD View Next/Previous at Bottom -->
	<!--
#
#-----[ FIND ]------------------------------------------------
#
			</form></tr>
		</table></td>
	</tr>
#
#-----[ AFTER, ADD ]---------------------------------------- 
#
	//-->
	<tr align="center"> 
		<td class="catBottom" colspan="2" height="28"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
			<tr><form method="post" action="{S_POST_DAYS_ACTION}">
				<td width="40%" align="left" valign="middle" nowrap="nowrap"><span class="gensmall">{L_DISPLAY_POSTS}: {S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" /></span></td>
				<td align="right" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_VIEW_OLDER_TOPIC}" class="nav">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEWER_TOPIC}" class="nav">{L_VIEW_NEXT_TOPIC}</a> &nbsp;</span></td>
			</form></tr>
		</table></td>
	</tr>
	<!-- FINISH MOD View Next/Previous at Bottom -->
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM