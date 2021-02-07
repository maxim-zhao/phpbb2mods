##############################################################
## MOD Title: ImageShack Mod
## MOD Author: thirstyg < n/a > (Mike) http://www.h2press.net
## MOD Description: Allows users to upload images to imageshack while replying or creating a topic.
## MOD Version: 1.3.3
##
## Installation Level: Easy
## Installation Time: ~1 Minutes
## Files To Edit: posting_body.tpl
## Included Files: n/a
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
## This mod is based on the syndication feature at Imageshack.us, the main thing I
## did was put it into proper mod format and correct a few errors.
##
## Limited support via email - mike [at] h2press.net
################################################################
## MOD History:
##
##   2005-06-21 - Version 1.0.0
##      - First tested & stable mod version.
##
##   2005-06-28 - Version 1.2.0
##      - Removed code that requires lang system
##
##   2005-09-04 - Version 1.3.0
##      - Upgraded to be compliant with new mod template
##
##   2005-09-20 - Version 1.3.2
##      - Minor template issues fixed
##
##   2006-07-17 - Version 1.3.3
##      - Increased width of upload box to help prevent wrapping, validated for current 
##	  version of phpbb
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------
#     
     <td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span><br /><span class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
     <td class="row2"><span class="gen"> </span>
      <table cellspacing="0" cellpadding="1" border="0">

#
#-----[ AFTER, ADD ]------------------------------------------
#
        <!-- begin imageshack mod -->
        <iframe src="http://www.imageshack.us/iframe.php?txtcolor=111111&type=blank&size=30" scrolling="no" allowtransparency="true" frameborder="0" width="300" height="70"></iframe>
        <!-- end imageshack mod -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM