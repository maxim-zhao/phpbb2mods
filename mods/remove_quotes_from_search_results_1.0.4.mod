##############################################################
## MOD Title: Remove quotes from Search Results
## MOD Author: RoscoHead < ross.crawford@gmail.com > (Ross Crawford) N/A
## MOD Description: Search by post results include a the first few characters of each
##                  post by default. However in may cases that consists of a significant
##                  amount of quoted text, so you don't get to preview the actual post
##                  text. This MOD removes any quoted text from the search results,
##                  giving you a better post preview.
## MOD Version: 1.0.4
##
## Installation Level: Easy
## Installation Time: ~ 1 Minute
## Files To Edit: search.php
##                language/lang_english/lang_main.php
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
## This MOD removes all quoted text from the post preview when viewing
## search results by post.
##
##############################################################
## MOD History:
##
##   2005-12-25 - Version 1.0.4
##      - No longer loses author text between multiple quotes
##
##   2005-10-23 - Version 1.0.3
##      - Corrected bad FIND command in MOD instructions
##
##   2005-10-16 - Version 1.0.2
##      - Display $lang['Empty_Post'] if there is no non-quoted post text
##
##   2005-09-25 - Version 1.0.1
##      - Changed title to "Remove quotes from Search Results"
##
##   2005-09-07 - Version 1.0.0
##      - Initial release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
search.php

#
#-----[ FIND ]------------------------------------------
#
						$message = preg_replace("/\[.*?:$bbcode_uid:?.*?\]/si", '', $message);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
						$message = preg_replace("/\[quote:$bbcode_uid.*?\].*?\[\/quote:$bbcode_uid\]\s*/si", '', $message);

#
#-----[ FIND ]------------------------------------------
#
						$message = ( strlen($message) > $return_chars ) ? substr($message, 0, $return_chars) . ' ...' : $message;
#
#-----[ AFTER, ADD ]------------------------------------------
#
						if ( trim($message) == '' )
						{
							$message = $lang['Empty_Post'];
						}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------
#
$lang['Empty_Post'] = '(Empty post)';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#

# EoM