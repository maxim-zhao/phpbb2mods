##############################################################
## MOD Title: Easy BotStopper
## MOD Author: battye < N/A > (N/A) http://www.online-scrabble.com
## MOD Description: This is a simple program to stop spam bot registrations.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: usercp_register.php, profile_add_body.tpl
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
## Author Notes: This is the easiest way to stop spam bot registrations.
##############################################################
## MOD History:
##
##   2006-03-18 - Version 1.0.0
##      - Die bots. Die. :)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');
								
#
#-----[ AFTER, ADD ]------------------------------------------
#

	if ( $mode == 'editprofile' )
	{
		$template->assign_block_vars('only_show_notbot', array());
	}

#
#-----[ FIND ]------------------------------------------
#
			if ( !($row = $db->sql_fetchrow($result)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain next user_id information', '', __LINE__, __FILE__, $sql);
			}
			$user_id = $row['total'] + 1;
								
#
#-----[ AFTER, ADD ]------------------------------------------
#
			if( $website != '' )
			{
			die();
			}

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_WEBSITE}:</span></td>
								
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	<!-- BEGIN only_show_notbot -->

#
#-----[ FIND ]------------------------------------------
#
		<input type="text" class="post" style="width: 200px"  name="website" size="25" maxlength="255" value="{WEBSITE}" />
	  </td>
	</tr>
								
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<!-- END only_show_notbot -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM