##############################################################
## MOD Title: Show Active Category Name
## MOD Author: Prince of phpbb < adeel_e@hotmail.com > (Adeel Ejaz Butt) http://www.apnaaadi.com/dev
## MOD Description: This MOD adds "-> Category Title" in Navigation Link
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: 2
##		index.php
## 		templates/subSilver/index_body.tpl
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
##	
##############################################################
## MOD History:
## 
## 2006-07-25 - Version 1.0.0
## -Inital Release
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
	//
	// Okay, let's build the index
	//
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Active Cat MOD - Start	
	$arrow = '';
	$active_cat = '';
	$active_cat_link = '';
// Active Cat MOD - End
#
#-----[ FIND ]------------------------------------------
#
			$template->assign_block_vars('catrow', array(
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Active Cat MOD - Start
			if ( $viewcat != -1 )
			{
				$arrow = '->';
				$active_cat = $category_rows[$i]['cat_title'];
				$active_cat_link = append_sid("index.$phpEx?" . POST_CAT_URL . "=$cat_id");
			}

			$template->assign_vars(array(
				'ARROW' => $arrow,
				'ACTIVE_CAT' => $active_cat,
				'ACTIVE_CAT_LINK' => $active_cat_link)
			);
// Active Cat MOD - End
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	{CURRENT_TIME}<br /></span><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
#
#-----[ IN-LINE FIND ]------------------------------------------
#
{L_INDEX}</a>
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 {ARROW} <a href="{ACTIVE_CAT_LINK}" class="nav">{ACTIVE_CAT}</a>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
