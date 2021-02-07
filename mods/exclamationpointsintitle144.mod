############################################################## 
## MOD Title: Exclamation points in title
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/
## MOD Description: Deletes any uneeded exclamation points from the subject title.
##		"Question!!!!!!" will be changed to "Question!" or "Who can help??????" will be changed to "Who can help?"
## MOD Version: 1.4.4
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		posting.php
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
## Tip: Use PHP to make you own replacements
## Tips-Download: http://www.underhill.de/downloads/phpbb2mods/exclamationpointsintitletips.txt
##
## Download: http://www.underhill.de/downloads/phpbb2mods/exclamationpointsintitle.txt
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

posting.php

#
#-----[ FIND ]------------------------------------------------------------------
#

		$preview_subject = $subject;
		$preview_username = $username;

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		//
		// Exclamation points in title
		//
		$preview_subject = preg_replace("/([\!])+/", "\\1", $preview_subject);
		$preview_subject = preg_replace("/([\?])+/", "\\1", $preview_subject); 

#
#-----[ OPEN ]------------------------------------------------------------------
#

includes/functions_post.php

#
#-----[ FIND ]------------------------------------------------------------------
#

	if ($mode == 'newtopic' || $mode == 'reply' || $mode == 'editpost') 
	{

#
#-----[ BEFORE, ADD ]-----------------------------------------------------------
#

	//
	// Exclamation points in title
	//
	$post_subject = preg_replace("/([\!])+/", "\\1", $post_subject);
	$post_subject = preg_replace("/([\?])+/", "\\1", $post_subject); 

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
#
# EoM
