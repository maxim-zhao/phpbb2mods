############################################################## 
## MOD Title: Rank Image in Rank Admin List
## MOD Author: Grebog < grebog@grebog.net > (Mark Garman) http://www.grebog.net/phpBB
## MOD Description: Shows the rank image in the rank admin list in the ACP.
## MOD Version: 1.0.6
## 
## Installation Level: Easy 
## Installation Time: ~5 Minutes 
##
## Files To Edit: language/lang_english/lang_admin.php, admin/admin_ranks.php, 
##                templates/subSilver/admin/ranks_list_body.tpl 
## Included Files: hl/Rank_Image_in_Rank_Admin_List.hl
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
## Made this because I wanted to see the images I had setup in the Rank Admin Listing.
## I also am including the HL file for those who have the Hack List mod installed.
##
## I think this will be my first and last mod to get released, since I can't seem to get any
## of it right. I even triple checked it and still had 2 things messed up. So, obviously I 
## shouldn't be doing this, since this is my 6th version and only because I can't get it perfect.
##
## Compatibility: phpBB 2.0.22 (previous releases: known working from 2.0.10 on) But, I see no reason
## that this would not work on previous versions.
############################################################## 
## MOD History:
##    10-25-2007 1.0.6 Put files into folder inside zip file and tested to verify that this will work with 
##               EasyMod beta 0.3.0 and phpBB 2.0.22. And test has succeeded, 
##
##    11-20-2004 1.0.5 Finding that I may not be someone who should do mods period and stick to just
##               modifying my own board and not trying to get them release. Found out I should have
##               not followed the code as an example and used $php_root_path variable where a ../ is.
##               That is changed and also I guess I flipped a search from being add before to something
##               should be add after. 
##
##	11-16-2004 1.0.4 Realized I had from somewhere put in variables and such that I really didn't
##               and forgot a section in the mod file to add. I am finding that being really tired
##		     is very detrimental to my mod writing.
## 
##    11-09-2004 1.0.3 Changed the Find in the admin_ranks.php to something smaller, but keeping
##               it obvious where to place new code.
##
##    10-31-2004 1.0.2 Fixed the minor things that I overlooked like having my website link on
##               the line as the name and email line. Moved the Mod compatibility to the Authors
##               notes. Added more to the find in admin_ranks so you are sure on where in the file
##               you are adding this in.
##
##    10-25-2004 1.0.1 Fixed minor things in the mod file.
##   
##    10-24-2004 1.0.0 Created the mod file.  
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ COPY ]------------------------------------------
# Note: only do this if you have the hack list mod installed
#
copy Rank_Image_in_Rank_Admin_List.hl to hl/Rank_Image_in_Rank_Admin_List.hl
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
// begin Rank Image in Rank Admin List mod
$lang['Rank_image_short'] = 'Rank Image';
// end mod
# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_ranks.php
# 
#-----[ FIND ]------------------------------------------ 
# 
		"L_RANK_MINIMUM" => $lang['Rank_minimum'],
		"L_SPECIAL_RANK" => $lang['Rank_special'],
		"L_EDIT" => $lang['Edit'],
		"L_DELETE" => $lang['Delete'],
		"L_ADD_RANK" => $lang['Add_new_rank'],
		"L_ACTION" => $lang['Action'],
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// begin Rank Image in Rank Admin List
		"L_RANK_IMAGE_SHORT" => $lang['Rank_image_short'],
// end Rank Image in Rank Admin List
# 
#-----[ FIND ]------------------------------------------ 
# 
		$template->assign_block_vars("ranks", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"RANK" => $rank,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// begin Rank Image in Rank Admin List
			"IMAGE_DISPLAY" => ( $rank_rows[$i]['rank_image'] != "" ) ? '<img src="'. $phpbb_root_path . $rank_rows[$i]['rank_image'] . '" />' : "",
// end Rank Image in Rank Admin List
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/ranks_list_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
		<th class="thCornerL">{L_RANK}</th>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
		<th class="thTop">{L_RANK_IMAGE_SHORT}</th>
# 
#-----[ FIND ]------------------------------------------ 
# 
		<td class="{ranks.ROW_CLASS}" align="center">{ranks.RANK}</td>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
        <td class="{ranks.ROW_CLASS}" align="center">{ranks.IMAGE_DISPLAY}</td>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 