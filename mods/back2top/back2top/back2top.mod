############################################################## 
## MOD Title: Back To Top
## MOD Author: Rambo4104 < Admin@thesaltinez.com > (Ryan Smith) http://www.thesaltinez.com/
## MOD Description:  Adds a link on the index footer that directs
##		     to the top of the page without reloading.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 3 Minutes
##
## Files To Edit: 4
##			index.php
##			includes/page_header.php
##			language/lang_english/lang_main.php
##			templates/subSilver/index_body.tpl
##
##
## Included Files: (N/A)
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
##		Some templates come with something like this,
##		but for those who don't, here you go.
##
##############################################################
## MOD History: 
##
##   2007-03-06 - Version 1.0.1
##      - Initial Release
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

		'L_ONLINE_EXPLAIN' => $lang['Online_explain'], 

#
#-----[ AFTER, ADD ]------------------------------------
#

		'L_BACK_TO_TOP' => $lang['Back_to_top'],

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

$lang['Back_to_top'] = 'Back to top';

#
#-----[ OPEN ]------------------------------------------
#

includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#

	'U_INDEX' => append_sid('index.'.$phpEx),

#
#-----[ AFTER, ADD ]------------------------------------
#

	'U_INDEX_TOP' => append_sid('index.'.$phpEx. '#'),

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<td class="catHead" colspan="2" height="28"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle">{L_WHO_IS_ONLINE}</a></span></td>

#
#-----[ IN-LINE FIND ]----------------------------------
#

{L_WHO_IS_ONLINE}

#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#

 - <a href="{U_INDEX_TOP}">{L_BACK_TO_TOP}

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM