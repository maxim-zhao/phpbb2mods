##############################################################
## MOD Title: Show Ranks images in ACP Rank list
## MOD Author: alexx860 < alexx860@gmail.com > (Alexandre) N/A
## MOD Description: It shows the rank pictures in the ACP Rank list
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: admin/admin_ranks.php,
##      language/lang_english/lang_admin.php,
##      templates/subSilver/admin/ranks_list_body.tpl
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
##############################################################
## MOD History:
##
##   2006-04-17 - Version 1.0.2
##      - Updated for phpBB 2.0.20
##		- If there is no image for a rank, it will not show a broken image anymore
##
##   2006-04-15 - Version 1.0.1
##      - Fixed some errors (not published)
##
##   2006-03-29 - Version 1.0.0
##      - First release of this little mod (not published)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_ranks.php
#
#-----[ FIND ]------------------------------------------
#
	"L_SPECIAL_RANK" => $lang['Rank_special'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	"L_RANK_IMAGE_LIST" => $lang['Rank_image_list'], // Ranks images in ACP Rank List
#
#-----[ FIND ]------------------------------------------
#
	$rank_min = $rank_rows[$i]['rank_min'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	$rank_image = $rank_rows[$i]['rank_image']; // Ranks images in ACP Rank List
#
#-----[ FIND ]------------------------------------------
#
	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	
	if ( empty($rank_image) ) // Ranks images in ACP Rank List
	{
		$rank_image = "-";
	}
	else
	{
		$rank_image = '<img src="../' . $rank_image . '" />';
	}

#
#-----[ FIND ]------------------------------------------
#
		"RANK_MIN" => $rank_min,
#
#-----[ AFTER, ADD ]------------------------------------------
#
		"RANK_IMAGE" => $rank_image, // Ranks images in ACP Rank List			
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Rank_image'] = 'Rank Image (Relative to phpBB2 root path)';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Rank_image_list'] = 'Image'; // Ranks images in ACP Rank List
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/ranks_list_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<th class="thTop">{L_SPECIAL_RANK}</th>
#
#-----[ AFTER, ADD ]------------------------------------------
#
		<th class="thTop">{L_RANK_IMAGE_LIST}</th>
#
#-----[ FIND ]------------------------------------------
#
		<td class="{ranks.ROW_CLASS}" align="center">{ranks.SPECIAL_RANK}</td>
#
#-----[ AFTER, ADD ]------------------------------------------
#
		<td class="{ranks.ROW_CLASS}" align="center">{ranks.RANK_IMAGE}</td>
#
#-----[ FIND ]------------------------------------------
#
		<td class="catBottom" align="center" colspan="{%:1}"><input type="submit" class="mainoption" name="add" value="{L_ADD_RANK}" /></td>
#
#-----[ INCREMENT ]------------------------------------------
#
%:1 +1
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM