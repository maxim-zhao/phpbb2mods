##############################################################
## MOD Title: Random Style for Guests
## MOD Author: DavidIQ < david@davidiq.com > (David Colon) http://www.davidiq.com
## MOD Description: This mod will set a random style for guests.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: includes/functions.php,
##
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Random style will be selected every 15 minutes for guest.
##
##############################################################
## MOD History:
##
##   2006-3-25 - Version 1.0.0
##      - Mod creation
##
##   2006-4-19 - Version 1.0.1
##	  - Changed $_COOKIE to $HTTP_COOKIE_VARS
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#
	$theme = setup_style($board_config['default_style']);

#
#-----[ REPLACE WITH ]------------------------------------------
#
	//BEGIN Random Styles for Guests MOD
	if (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'].'_rand_style']))
	{
		$rand_style = $HTTP_COOKIE_VARS[$board_config['cookie_name'].'_rand_style'];
		$theme = setup_style($rand_style);
	}
	else
	{
		global $db;
		$sql = "SELECT *
			FROM " . THEMES_TABLE . "
			ORDER BY RAND() LIMIT 1";
		
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not query database for theme info');
		}
		
		if ( !($row = $db->sql_fetchrow($result)) )
		{
			message_die(CRITICAL_ERROR, "Could not get theme data for themes_id [$style]");
		}
		$rand_style = $row['themes_id'];
		$theme = setup_style($rand_style);
		setcookie($board_config['cookie_name'].'_rand_style', $rand_style, (time()+900), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']); 
	}
	//END Random Styles for Guests MOD

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM