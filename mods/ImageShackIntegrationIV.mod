##############################################################
## MOD Title: phpBB2 Image Shack Integration
## MOD Author: 3Di < 3d@you3d.za.net > (Marco) http://phpbb2italia.za.net/phpbb2/index.php
## MOD Description: Embed ImageShack Free Image Hosting Iframe into your phpBB2
##                             posting body (Posts and PMs), index, view profile - Only for logged in Users.
## MOD Version: 1.3.2
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
##	
##	Image Shack it is available all over your phpBB2 for logged in users
##############################################################
## MOD History:
##
## 2005-10-13 - Version 1.3.2
## - code rewritten
## - only for logged in Users
## - The MOD passed the MOD pre-validation process
## - re submitted
##
## 2005-09-30 - Version 1.3.1
## - hardcoded text removed
## - submitted
##
## 2005-09-15 - Version 1.3.0
## - Code re written, Iframe assigned to a common variable so it can be used at any point in a template
## - Iframe assigned also in view profile
## - Iframe assigned also in overall footer
## 
## 2005-08-30 - Version 1.0.0
## released
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
// begin phpBB2 Image Shack Integration
$image_shack = '<iframe src="http://www.imageshack.us/iframe.php?txtcolor=111111&type=blank&size=30" scrolling="no" allowtransparency="true" frameborder="0" width="280" height="85"></iframe>';
// end phpBB2 Image Shack Integration
#
#-----[ FIND ]------------------------------------------
#
	'PRIVMSG_IMG' => $icon_pm,
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// begin phpBB2 Image Shack Integration
	'IMAGE_SHACK' => $image_shack,
// end phpBB2 Image Shack Integration
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
<div align="center">{IMAGE_SHACK}</div>
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
	  {IMAGE_SHACK}
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
		  <td>{IMAGE_SHACK}</td>
		</tr>
<!-- END switch_user_logged_in -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM