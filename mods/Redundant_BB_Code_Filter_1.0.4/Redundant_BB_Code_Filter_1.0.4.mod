############################################################## 
## MOD Title: Remove redundant BB style codes
## MOD Author: jeff.stevens < je88.stevens@gmail.com > (Jeff Stevens) N/A
## MOD Description: Some words are censored and filtered from a post. It is
##                  possible to circumvent the word filter, by placing certain
##                  BB style codes in the word, e,g, stu[b][/b]ffed. If the
##                  word "stuffed" was in the censored list, this placement
##                  of the style code would beat the filter. There is nothing
##                  for the style code to turn bold, but at the same time, the
##                  word "stuffed" is now "stu[b][/b]ffed"; thereby avoiding
##                  the filter, but displaying the word "stuffed" in the post.
##                  This modification looks for specified redundant BB codes
##                  and reomves them before the message is posted.
## MOD Version: 1.0.4
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit: includes/functions_post.php
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
## Tip: Use PHP to make you own replacements
##
############################################################## 
## MOD History: 
## 
##   2005-11-18 - Version 1.0.0 
##		- Built and tested successfully with php 2.0.18
## 
##   2005-11-25 - Version 1.0.1 
##		- Amended in line with MOD Database Manager reequests
##
##   2005-11-25 - Version 1.0.2 
##		- Amended to show correct Mod version number
##
##   2005-12-05 - Version 1.0.3 
##		- Amended in line with MOD Database Manager requests
##
##   2005-12-14 - Version 1.0.4 
##		- Revised the replacement code from several lines to one single line
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#----[ OPEN ]------------------------------------------------------------------
#

includes/functions_post.php

#
#----[ FIND ]------------------------------------------------------------------
#

$message = trim($message);

#
#----[ AFTER, ADD ]------------------------------------------------------------
#

	// ##### BEGIN MODIFICATION #####

	// List of BB style codes to filter out where they appear to be redundant
	$words = Array();
	$words[0] = "[u][/u]";
	$words[1] = "[b][/b]";
	$words[2] = "[i][/i]";
	$words[3] = "[url][/url]";
	$words[4] = "[quote][/quote]";
	$words[5] = "[img][/img]";
	$words[6] = "[list][/list]";
	$words[7] = "[size=7][/size]";
	$words[8] = "[size=9][/size]";
	$words[9] = "[size=12][/size]";
	$words[10] = "[size=18][/size]";
	$words[11] = "[size=24][/size]";
	$words[12] = "[color=darkred][/color]";
	$words[13] = "[color=red][/color]";
	$words[14] = "[color=orange][/color]";
	$words[15] = "[color=brown][/color]";
	$words[16] = "[color=yellow][/color]";
	$words[17] = "[color=green][/color]";
	$words[18] = "[color=olive][/color]";
	$words[19] = "[color=cyan][/color]";
	$words[20] = "[color=blue][/color]";
	$words[21] = "[color=darkblue][/color]";
	$words[22] = "[color=indigo][/color]";
	$words[23] = "[color=violet][/color]";
	$words[24] = "[color=white][/color]";
	$words[25] = "[color=black][/color]";
	$words[26] = "[list=][/list]";
	$words[27] = "[code][/code]";

        // Remove any redundant BB codes
        $message = str_replace($words, "", $message);

	// ##### END MODIFICATION #####

#
#-----[ SAVE/CLOSE ALL FILES ]-----------------------------------------------
#
# EoM