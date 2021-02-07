##############################################################
## MOD Title: phpBB2 ImageKafe Integration
## MOD Author: 3Di < 3d@you3d.za.net > (Marco) http://phpbb2italia.za.net/phpbb2/index.php
## MOD Description: Embed ImageKafe Free Image Hosting Iframe into your phpBB2
##                             posting body (Posts and PMs), index, view profile - Only for logged in Users.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: 
##                     includes/page_header.php
##                     templates/subSilver/index_body.tpl
##                     templates/subSilver/posting_body.tpl
##                     templates/subSilver/profile_view_body.tpl
## Included Files: 
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
##	Get EIGHT different linking codes with features like no size limit, no bandwith limit, no signup required, 10 uploads at a time, and 99% uptime
##	Image Kafe it is available all over your phpBB2 for logged in users
##############################################################
## MOD History:
##
## 2005-10-21 - Version 1.0.0
## - made the script
## - only for logged in Users
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
define('HEADER_INC', TRUE);
#
#-----[ AFTER, ADD ]------------------------------------------
#
// begin phpBB2 ImageKafe Integration
$image_kafe = '<iframe src="http://www.imagekafe.com/iframe.php?&type=blank&size=30" scrolling="no" allowtransparency="true" frameborder="0" width="280" height="83"></iframe>';
// end phpBB2 ImageKafe Integration
#
#-----[ FIND ]------------------------------------------
#
	'PRIVMSG_IMG' => $icon_pm,
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// begin phpBB2 ImageKafe Integration
	'IMAGE_KAFE' => $image_kafe,
// end phpBB2 ImageKafe Integration
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<br clear="all" />
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_user_logged_in -->
<div align="center">{IMAGE_KAFE}</div>
<!-- END switch_user_logged_in -->
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	  <td class="row2"><span class="gen"> </span> 
#
#-----[ REPLACE WITH ]----------------------------------------
#
	  <td class="row2">
<!-- BEGIN switch_user_logged_in -->
	  {IMAGE_KAFE}
<!-- END switch_user_logged_in -->
	  <span class="gen"> </span> 
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		  <td> <b><span class="gen">{INTERESTS}</span></b></td>
		</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- BEGIN switch_user_logged_in -->
		<tr> 
		  <td valign="top" align="right"></td>
		  <td>{IMAGE_KAFE}</td>
		</tr>
<!-- END switch_user_logged_in -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM