############################################################## 
## MOD Title: 50 characters in message
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/
## MOD Description: Forces a blank character in a string with 50 characters in a message.
##		Against extremely long words that forces horizontal scrolling thus detroying the design
## MOD Version: 1.4.4
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		includes/functions_post.php
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
## Author Notes: 
## 
## Attention: All BBCode formated text will not be replaced
## Attention: All links without BBCode (Magic Links) will be deleted!
##
## Tip: Use PHP to make you own replacements
## Tips-Download: http://www.underhill.de/downloads/phpbb2mods/50charsinmessagetips.txt
##
## Download: http://www.underhill.de/downloads/phpbb2mods/50charsinmessage.txt
############################################################## 
## MOD History: 
## 
##   2006-04-08 - Version 1.4.4 
##		- Successfully tested with phpBB 2.0.20
##		- Successfully tested with EasyMOD beta (0.3.0)
## 
##   2005-12-31 - Version 1.4.3 
##		- Successfully tested with phpBB 2.0.19
## 
##   2005-12-11 - Version 1.4.2 
##		- MOD Syntax changes for the phpBB MOD Database
##		- Successfully tested with phpBB 2.0.18
## 
##   2005-10-03 - Version 1.4.1 
##		- MOD Syntax changes for the phpBB MOD Database
## 
##   2005-10-01 - Version 1.4.0 
##		- Format changed to the phpBB MOD Template
##		- Successfully tested with phpBB 2.0.17
## 
##   2003-11-20 - Version 1.0.0 
##		- Built and successfully tested with phpBB 2.0.6
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------------------------------
#

includes/functions_post.php

#
#-----[ FIND ]------------------------------------------------------------------
#

	$message = trim($message);

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

	//
	// 50 characters in message
	//
	if (preg_match("/([^[:blank:]]{50})/", $message))
	{
		$message_array = preg_split("/\n/", $message);
		for ($x = 0; $x < count($message_array); $x++)
		{
			if (!preg_match("/\[.*\//", $message_array[$x])) // Ignore BBCode...
			{
				$message_array[$x] = preg_replace("/([^[:blank:]]{50})/", "\\1 ", $message_array[$x]);
			}
			$message = implode("\n", $message_array);
		}
	}

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
#
# EoM