##############################################################
## MOD Title: Show Only Active Category
## MOD Author: Prince of phpbb < adeel_e@hotmail.com > (Adeel Ejaz Butt) http://www.apnaaadi.com/dev
## MOD Author: ex-kali-bur < modder@ex-kali-bur.de > (N/A) N/A
## MOD Description: This mod hides all categories except the active one in Category-View (index.php?c=X)
## MOD Version: 1.1.2
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: index.php
## Included Files: N/A
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
##	Thanks alot to the MOD Team for the help in submitting this MOD to the MOD DB
##############################################################
## MOD History:
## 
## 2004-10-08 - Version 1.0.0
## -First Release
## 
## 2006-06-24 - Version 1.1.0
## -MOD taken over by Prince of phpbb
## -MOD re-written for phpBB 2.0.21
## 
## 2006-06-25 - Version 1.1.0a
## -Added contrib directory
## -RC1 Released
## 
## 2006-07-27 - Version 1.1.1
## -Updated header part of MOD file
## -Updated FIND and IN-LINE FIND (thanks to MOD Team)
## -RC2 Released
## 
## 2006-07-28 - Version 1.1.2
## -Updated add-on to comply with MOD Template
## -RC3 Released
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
index.php
#
#-----[ FIND ]------------------------------------------
#
      if (isset($display_categories[$cat_id]) && $display_categories[$cat_id])
#
#-----[ IN-LINE FIND ]------------------------------------------
#
&& $display_categories[$cat_id]
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 && ( $viewcat == $cat_id || $viewcat == -1 ) 
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
