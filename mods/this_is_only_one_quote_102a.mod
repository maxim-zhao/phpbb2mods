##############################################################
## MOD Title:		This is Only One Quote
## MOD Author:	3Di < threed3di@users.sourceforge.net > (Marco) http://threed.5gbfree.com/ipcf/index.php
## MOD Description:	No more nested quotes.
##			Only the last message quoted it is shown in Topics and PMs.
##			BBcode it is always ON to prevent broken layouts if users might want to disallow it.
##			Quoted images are converted to URLs.
##			If no content is quoted then the MOD puts a standard (customizable) message into that quote.
##			SQL added to set the BBcode ON for all Users in one shot.
##
## MOD Version: 1.0.2a
## 
## Installation Level: Easy
## Installation Time: 5 minutes
## Files To Edit: 
##
## posting.php
## privmsg.php
## language/lang_english/lang_main.php
## templates/subSilver/profile_add_body.tpl
##
## Included Files: N/A
##
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
## DISABLE your board before to MOD it!
##
##############################################################
## MOD History:
##
## 2007-05-13 - Version 1.0.2a
## - small change to a FIND and a fake FIND added, for phpBB 2.0.22's compatibility
## - the code is still the same, so no changes
## - MOD submitted
##
## 2005-11-05 - Version 1.0.2
## - cosmetic changes to template
## - fixed an erroneous FIND
## - tested on 2.0.18
## - The MOD passed the MOD pre-validation process
## - MOD submitted
##
## 2005-10-23 - Version 1.0.1
## - added returns 'Last quote does not exists!' if the last post is empty
## - (tip learnt from the 'Remove quotes from Search Results' MOD)
## - added the whole thing also to PMs
## - tested on localhost 2.0.17 phpBB
## - The MOD passed the MOD pre-validation process
## - MOD submitted
##
## 2005-10-21 - Version 1.0.0
## - changed version number to submitt
## - The MOD passed the MOD pre-validation process
## - MOD submitted
##
## 2005-10-15 - Version 0.5.0 BETA
## - script reviewed
## - added image quoted converted as URL (thanks poyntesm)
## - added the whole thing also to PMs
## - tested on localhost 2.0.17 phpBB
## - 
## 2005-10-12 - Version 0.1.0 BETA
## - code re written
## - added SQL 
##
## 2005-08-24 - Version 0.0.1
## - first release
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ DIY INSTRUCTIONS ]------------------------------------
#
If you're MODding your Forum manually please follow this:

1 - DISABLE YOUR BOARD FIRST!

2 - RUN THE QUERY VIA PHPMYADMIN OR SIMILAR TOOL

3 - MOD THE FILES AND UPLOAD THE STUFF

#
#-----[ SQL ]-------------------------------------------------
#
UPDATE phpbb_users SET user_allowbbcode = 1;

#
#-----[ OPEN ]------------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------------
#
# The line to search is longer.. 
#
			// Use trim to get rid of spaces placed there by MS-SQL 2000
			$quote_username = 
#
#-----[ AFTER, ADD ]------------------------------------------
#
// + This is Only One Quote MOD
			{  
				$message = preg_replace('/(\[quote=(.*?)\]((.|\n)*)\[\/quote\])/si',"", $message); 
				$message = ( !empty($message) ) ? preg_replace('[/img]', '/url', $message) : '';
				$message = ( !empty($message) ) ? preg_replace('/\[img]/', $lang['Image_url'], $message) : '';
			}
			if ( trim($message) == '' )
			{
				$message = $lang['No_quote_inside'];
			}
// - This is Only One Quote MOD
#
#-----[ OPEN ]------------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------------
#
			if ( $mode == 'quote' )
#
# no further action here, just go to the next FIND ;)
#
#-----[ FIND ]------------------------------------------
#
				$privmsg_message = str_replace('<br />', "\n", $privmsg_message);
#
#-----[ AFTER, ADD ]------------------------------------------
#
// + This is Only One Quote MOD
				{  
					$privmsg_message = preg_replace('/(\[quote=(.*?)\]((.|\n)*)\[\/quote\])/si',"", $privmsg_message); 
					$privmsg_message = ( !empty($privmsg_message) ) ? preg_replace('[/img]', '/url', $privmsg_message) : '';
					$privmsg_message = ( !empty($privmsg_message) ) ? preg_replace('/\[img]/', $lang['Image_url'], $privmsg_message) : '';
				}
				if ( trim($privmsg_message) == '' )
				{
					$privmsg_message = $lang['No_quote_inside'];
				}
// - This is Only One Quote MOD
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Reply_with_quote'] = 'Reply with quote';
#
#-----[ AFTER, ADD ]------------------------------------------
#
// + This is Only One Quote MOD
$lang['Image_url'] = '[b][i]Image Replaced With URL For Only One Quote MOD:[/i][/b] [url]';
$lang['No_quote_inside'] = '[b][i]Last quote does not exists![/i][/b]';
// - This is Only One Quote MOD
#
#-----[ OPEN ]------------------------------------------------
#
#	we do also this stuff.. ;)
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------------
# the line is longer..
#
		<input type="radio" name="allowbbcode" value="0"
#
#-----[ IN-LINE FIND ]------------------------------------------
#
value="0"
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
value="1"
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM