##############################################################
## MOD Title: HostMySignature.com Mod
## MOD Author: Knuckles10 < admin@hostmysignature.com > ( N/A ) http://www.hostmysignature.com
## MOD Description: Allows users to uploaded their forum signatures from within the profile page (next to the signature field)
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: ~1 Minutes
## Files To Edit: profile_add_body.tpl
## Included Files: (N/A)
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
################################################################
## 
## Author Notes: "txtcolor=" determines what color the text for the mod on your PHPBB board.
##                Change the "txtcolor=383B3F" as needed. 383B3F is a very dark grey color.
## 		  If you have a dark themed board, change it to something like "txtcolor=FFFFFF" (white)
##                Support can be found at http://www.hostmysignature.com/forums/
##
##############################################################
## MOD History:
##
##   2005-12-07 - Version 1.0.1
##      - Small formatting tweaks to comply to PHPBB.com mod database standards
##	- 
##
##   2005-11-16 - Version 1.0.0
##      - First tested & stable mod version.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------
#     
	  <td class="row2"> 
		<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post">{SIGNATURE}</textarea>

#
#-----[ AFTER, ADD ]------------------------------------------
#
		  <!-- Begin HostMySignature.com Mod -->
<br /><iframe src="http://www.hostmysignature.com/iframe.php?txtcolor=383B3F" scrolling="no" allowtransparency="true" frameborder="0" width="350" height="70">Update your browser for HostMySignature.com</iframe>
		  <!-- End HostMySignature.com Mod -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 