##############################################################
## MOD Title: Better captcha
## MOD Author: paul999 < webmaster@paulscripts.nl > (paul sohier) http://www.paulscripts.nl
## MOD Description: This mod add a better captcha to phpbb.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: profile.php
## Included Files: root/includes/*.*
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2288.38406 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## Please note that this mod requires the GD extension loaded. If this isn't loaded, the normal captcha will be displayed.
## This mod has some .ttf files included. These are released under the GPL, and can be downloaded at internet. You can self add more fonts.
##############################################################
## MOD History:
##
## 2006-04-14 - Version 0.0.1
## -First beta.
##
## 2006-04-16 - Version 1.0.0
## -Submitted to moddb.
##
## 2006-11-18 - Version 1.0.1
## -Fix for php < 4.2.0
## -Small change for submitting
## -Added new fonts from phpBB3
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy root/includes/*.* to includes/*.*
#
#-----[ OPEN ]------------------------------------------
#
profile.php
#
#-----[ FIND ]------------------------------------------
#
		include($phpbb_root_path . 'includes/usercp_confirm.'.$phpEx);
#
#-----[ REPLACE WITH ]------------------------------------------
#
		include($phpbb_root_path . 'includes/usercp_captcha.'.$phpEx);
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
