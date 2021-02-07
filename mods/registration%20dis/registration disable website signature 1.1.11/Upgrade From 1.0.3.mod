##############################################################
## MOD Title: No Website Signature during registration
## MOD Author: EXreaction < exreaction@gotechzilla.com > (Nathan Guse) http://www.gotechzilla.com
## MOD Description: When a user registers, the website and signature sections are removed, and they are not
##        allowed to register if they enter in anything
## MOD Version: 1.1.11(upgrade from 1.0.3)
##
## Installation Level: (Easy)
## Installation Time: ~2 Minutes
## Files To Edit: includes/usercp_register.php
## Included Files: none
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## This is my first mod for phpbb! :D
## Works perfect for me with easymod on a clean phpBB2 install.
##############################################################
## MOD History:
## 
##   2006-02-22 - Version 1.0.0
##      - (no version notes)
##   2006-03-12 - Version 1.0.1
##      - Re-wrote the MOD...I learned a much easier and better way to do it since 1.0.0
##   2006-03-17 - Version 1.0.2
##      - Fixed it so bots can't fill it in even though it is hidden
##            (basically it is version 1.0.0 plus version 1.0.1)
##   2006-03-27 - Version 1.0.3
##      - Fixed a few things...
##   2006-04-23 - Version 1.1.0
##      - Made it so that instead of just setting the website sig to nothing, if someone enters anything in
##            they are not allowed to register(only stops bots(that enter something in there)...
##            people won't see it anyways, so they won't enter anything in)
##   2006-05-13 - Version 1.1.1
##      - Added session_end() so that when the bot is banned, they can't keep trying to register...
##		  ...and fixed a few other problems. :p
##   2006-05-14 - Version 1.1.11
##      - Minor mistake fixed :p
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

$unhtml_specialchars_replace = array('>', '<', '"', '&');

# 
#-----[ AFTER, ADD ]------------------------------------------
#

// Start Website Signature removal mod

// Change "$ban_ip = false;" to "$ban_ip = true;" to ban the of the user if it tries to enter in something in the website or signature sections
$ban_ip = false;

// End Website Signature removal mod

#
#-----[ FIND ]------------------------------------------
# 

	if ($mode == 'register')
	{
		$signature = '';
	}
	else 
	{

#
#-----[ REPLACE WITH ]------------------------------------------
# (delete it)



#
#-----[ FIND ]------------------------------------------
# 

		$signature = prepare_message($signature, $allowhtml, $allowbbcode, $allowsmilies, $signature_bbcode_uid);
	}
	}

#
#-----[ REPLACE WITH ]------------------------------------------
# (delete the last } )

		$signature = prepare_message($signature, $allowhtml, $allowbbcode, $allowsmilies, $signature_bbcode_uid);
	}

#
#-----[ FIND ]------------------------------------------
# 

	if ($mode == 'register')
	{
		$website = '';
	}
	else 
	{

#
#-----[ REPLACE WITH ]------------------------------------------
# (delete it)



#
#-----[ FIND ]------------------------------------------
# 

		rawurlencode($website);
	}
	}

# 
#-----[ REPLACE WITH ]------------------------------------------
#

		rawurlencode($website);
	}

// Start Website Signature removal mod
	if ( ($mode == 'register') && (($signature != '')||($website != '')) )
	{
		if ($ban_ip == true)
		{
			$sql = "INSERT INTO ".BANLIST_TABLE." (`ban_ip`) VALUES ('".$userdata['session_ip']."')";
			if ( !$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't insert ban_ip info into database", "", __LINE__, __FILE__, $sql);
			}
		}
		session_end($userdata['session_id'], $userdata['user_id']);
		message_die(GENERAL_ERROR, 'Die robot!');
	}
// End Website Signature removal mod

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
# 

If you want to ban the bot's IP address when they are denied, 
  make sure you change the $ban_ip = false; to $ban_ip = true;
  If you don't know how to do that, 
  open:
  includes/usercp_register.php

  find:
  $ban_ip = false;

  replace with:
  $ban_ip = true;


  This is not necessary, as the bot won't be allowed to register anyways,
  but if you want it to auto-ban that IP, go ahead...

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

