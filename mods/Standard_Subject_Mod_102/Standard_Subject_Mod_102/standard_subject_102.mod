##############################################################
## MOD Title: Standard Subject MOD
## MOD Author: battye < cricketmx@hotmail.com > (N/A) http://www.online-scrabble.com
## MOD Description: If you wish to make a link for a user to start a new topic, you can automatically fill the subject field with text of your choice upon the loading of the page.
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: posting.php
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
## Author Notes: For example, suppose you run a site where users post their review on a product you sell. The user posts their review on your forum, and names it "Review on Product X". The post is then syndicated to another page on your site. On this page, you include a link where users can reply to another users reviews in the forum (such as posting.php?mode=reply&t=1). With this MOD, you can make it so the subject box is automatically filled with the subject name of your choice (it can always be changed by the user). So rather, than linking to posting.php?mode=reply&t=1, you can now link to posting.php?mode=reply&t=7&subject=Re: Review on Product X and the subject field for the reply would automatically have Re: Review on Product X in it. It can also be done for new topics, by adding the &subject= on to the end.
## To see it in action, visit http://www.lyricsmx.com/lyrics.php?mode=song&song=4354 and click Suggest A Correction.
##############################################################
## MOD History:
##
##   2005-10-22 - Version 0.0.1
##      - Initial release
##
##   2005-11-06 - Version 1.0.0
##      - Fixed the slashes issue. (1.0.0 is a renamed 0.0.2)
##
##   2005-11-20 - Version 1.0.1
##      - Added tutorial, fixed code
##
##   2005-12-02 - Version 1.0.2
##      - Added tutorial and example. Fixed DIY bit.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

posting.php

#
#-----[ FIND ]------------------------------------------
# Line 742

		$subject = '';
		
#
#-----[ REPLACE WITH ]------------------------------------------
#

		$subject = htmlspecialchars(trim(stripslashes($HTTP_GET_VARS['subject'])));

#
#-----[ FIND ]------------------------------------------
# Line 750

		$subject = '';
		
#
#-----[ REPLACE WITH ]------------------------------------------
#

		$subject = htmlspecialchars(trim(stripslashes($HTTP_GET_VARS['subject'])));
		
#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#

Please read this tutorial to further understand how to use this MOD:	http://www.cmxmods.net/standard_subject_mod.php?mode=tutorial
For code examples of how this MOD can be used, please view the file "examples.txt" included with this package.

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM