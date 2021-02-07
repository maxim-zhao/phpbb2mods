##############################################################
## MOD Title: Hide empty fields in user profile
## MOD Author: laisvai < admin@laisvai.com > (Zydrunas Anzulevicius) http://www.laisvai.com
## MOD Description: This mod hides empty profile fields in user profile.
## MOD Version: 1.1.0
##
## Installation Level: (Easy)
## Installation Time: 5 Minutes
## Files To Edit: 2
##		includes/usercp_viewprofile.php,
##      	templates/subSilver/profile_view_body.tpl
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
## Author Notes: Cosmetic fix for your phpbb. This mod hides empty fields in user profile.
##	         
##
##############################################################
## MOD History:
##
##   2006-11-30 - Version 1.1.0
##      - Added hide e-mail for not admin users, corrected table layout
##   2006-11-29 - Version 1.0.0
##      - Initial release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------
#
	'S_PROFILE_ACTION' => append_sid("profile.$phpEx"))
);
#
#-----[ AFTER, ADD ]------------------------------------------
#
if (( $profiledata['user_viewemail'] != 0) || ($userdata['user_level'] == ADMIN ))
{	
	$template->assign_block_vars('switch_showemail',array());
}
if ($profiledata['user_msnm'] != '')
{	
	$template->assign_block_vars('switch_showmsnm',array());
}
if ($profiledata['user_yim'] != '')
{	
	$template->assign_block_vars('switch_showyahoo',array());
}
if ($profiledata['user_aim'] != '')
{	
	$template->assign_block_vars('switch_showaim',array());
}
if ($profiledata['user_icq'] != '')
{	
	$template->assign_block_vars('switch_showicq',array());
}
if ($profiledata['user_from'] != '')
{	
	$template->assign_block_vars('switch_showuserfrom',array());
}
if ($profiledata['user_website'] != '')
{	
	$template->assign_block_vars('switch_showwebsite',array());
}
if ($profiledata['user_occ'] != '')
{	
	$template->assign_block_vars('switch_showocupation',array());
}
if ($profiledata['user_interests'] != '')
{	
	$template->assign_block_vars('switch_showinterests',array());
}
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_LOCATION}:&nbsp;</span></td>
		  <td><b><span class="gen">{LOCATION}</span></b></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showuserfrom -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showuserfrom -->
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_WEBSITE}:&nbsp;</span></td>
		  <td><span class="gen"><b>{WWW}</b></span></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showuserwebsite -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showuserwebsite -->
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_OCCUPATION}:&nbsp;</span></td>
		  <td><b><span class="gen">{OCCUPATION}</span></b></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showocupation -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showocupation -->
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_INTERESTS}:</span></td>
		  <td> <b><span class="gen">{INTERESTS}</span></b></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showinterests -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showinterests -->
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_EMAIL_ADDRESS}:</span></td>
		  <td class="row1" valign="middle" width="100%"><b><span class="gen">{EMAIL_IMG}</span></b></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showemail -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showemail -->
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_PM}:</span></td>
		  <td class="row1" valign="middle"><b><span class="gen">{PM_IMG}</span></b></td>
		</tr>
#
#-----[ REPLACE WITH ]------------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_PM}:</span></td>
		  <td class="row1" valign="middle" width="100%"><b><span class="gen">{PM_IMG}</span></b></td>
		</tr>
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_MESSENGER}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{MSN}</span></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showmsnm -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showmsnm -->
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_YAHOO}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{YIM_IMG}</span></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showyahoo -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showyahoo -->
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_AIM}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{AIM_IMG}</span></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showaim -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showaim -->
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_ICQ_NUMBER}:</span></td>
		  <td class="row1"><script language="JavaScript" type="text/javascript"><!-- 

		if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
			document.write(' {ICQ_IMG}');
		else
			document.write('<table cellspacing="0" cellpadding="0" border="0"><tr><td nowrap="nowrap"><div style="position:relative;height:18px"><div style="position:absolute">{ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{ICQ_STATUS_IMG}</div></div></td></tr></table>');
		  
		  //--></script><noscript>{ICQ_IMG}</noscript></td>
		</tr>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_showicq -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_showicq -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM