############################################################## 
## MOD Title: Highlight Topics User Posted In - PART4
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/
## Images Creator: Ptirhiik < admin@rpgnet-fr.com > (Pierre) http://rpgnet.clanmckeen.com 
## MOD Description: Will highlight topics in which the user has posted (PART4:change color)
## MOD Version: 1.0.1
## 
## Installation Level: Esay
## Installation Time: 1 Minute (less with the great EasyMOD! :-) 
## Files To Edit:	viewforum.php
##			search.php
##			admin/admin_styles.php
##			templates/subSilver/admin/styles_edit_body.tpl
##			language/lang_english/lang_admin.php
## Included Files: 	n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	YOU NEED TO INTALL PART1 BEFORE!!
##
##	PART4 : This one will change color of the topic title (color defined in ACP/Styles/Edit)
##		>> This one needs SQL CHANGES !! (and you'll have to define the color to use! ;-)
##
############################################################## 
## MOD History: 
## 
##   2004-07-02 - Version 1.0.1 
##	- PART2: Fix: missed a  =  in subSilver.cfg !!
##	- Add PART# in MOD Title to work with EasyMOD 
##
##   2004-06-30 - Version 1.0.0 
##	- PART4: Replace <font> by <span> (MOD Validator)
##	- Submitted to the MOD-DB
##
##   2004-06-26 - Version 0.2.1 
##	- Highlight is also done in search results (is displayed as topics)
##	- New picture for PART3, better with dark background (Thx beggers ;)
##
##   2004-06-25 - Version 0.2.0 
##	- Made 4 parts, and 3 different versions, so you can choose what you like the most
##	  (different topic's pictures, a new picture before the title, or a different title's color)
##
##   2004-06-24 - Version 0.1.0 
##	- Use new images made by Ptirhiik for his MOD: Last Topics From
##	- Fixed a bug, didn't work with Announcements
##
##   2004-06-23 - Version 0.0.1 
##	- First version, should work just fine ;) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


# 
#-----[ SQL ]----- 
# 
ALTER TABLE `phpbb_themes` ADD `highlight_topic_color` VARCHAR( 6 ) ;
ALTER TABLE `phpbb_themes_name` ADD `highlight_topic_color_name` CHAR( 50 ) 
# 
#-----[ OPEN ]----- 
# 
viewforum.php
# 
#-----[ FIND ]----- 
# 
			'TOPIC_TITLE' => $topic_title,
# 
#-----[ REPLACE WITH ]----- 
# 
			'TOPIC_TITLE' => ( ($topic_rowset[$i]['my_reply_id']) ? '<span style="color:#' . $theme['highlight_topic_color'] . '">' . $topic_title . '</span>' : $topic_title ),
# 
#-----[ OPEN ]----- 
# 
search.php
# 
#-----[ FIND ]----- 
# 
					'TOPIC_TITLE' => $topic_title,
# 
#-----[ FIND ]----- 
# 
#Note: we need the SECOND one, for results as topics!!
					'TOPIC_TITLE' => $topic_title,
# 
#-----[ REPLACE WITH ]----- 
# 
					'TOPIC_TITLE' => ( ($searchset[$i]['my_reply_id']) ? '<span style="color:#' . $theme['highlight_topic_color'] . '">' . $topic_title . '</span>' : $topic_title ),
# 
#-----[ OPEN ]----- 
# 
admin/admin_styles.php
# 
#-----[ FIND ]----- 
# 
			$style_id = intval($HTTP_POST_VARS['style_id']);
# 
#-----[ BEFORE, ADD ]----- 
# 
			$updated['highlight_topic_color'] = $HTTP_POST_VARS['highlight_topic_color'];
			$updated_name['highlight_topic_color_name'] = $HTTP_POST_VARS['highlight_topic_color_name'];
# 
#-----[ FIND ]----- 
# 
				"L_SAVE_SETTINGS" => $lang['Save_Settings'], 
# 
#-----[ BEFORE, ADD ]----- 
# 
				"L_HIGHLIGHT_TOPIC_COLOR" => $lang['highlight_topic_color'],
# 
#-----[ FIND ]----- 
# 

				"TR_COLOR1_NAME" => $selected['tr_color1_name'],
# 
#-----[ BEFORE, ADD ]----- 
# 
				"HIGHLIGHT_TOPIC_COLOR" => $selected['highlight_topic_color'],
# 
#-----[ FIND ]----- 
# 
				
				"S_THEME_ACTION" => append_sid("admin_styles.$phpEx"),
# 
#-----[ BEFORE, ADD ]----- 
# 
				"HIGHLIGHT_TOPIC_COLOR_NAME" => $selected['highlight_topic_color_name'],
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/admin/styles_edit_body.tpl
# 
#-----[ FIND ]----- 
# 


	<tr>
		<td class="catBottom" colspan="3" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SAVE_SETTINGS}" class="mainoption" />
		</td>
	</tr>

# 
#-----[ BEFORE, ADD ]----- 
# 
	<tr>
		<td class="row1">{L_HIGHLIGHT_TOPIC_COLOR}:</td>
		<td class="row2"><input class="post" type="text" size="6" maxlength="6" name="highlight_topic_color" value="{HIGHLIGHT_TOPIC_COLOR}"></td>
		<td class="row2"><input class="post" type="text" size="25" maxlength="100" name="highlight_topic_color_name" value="{HIGHLIGHT_TOPIC_COLOR_NAME}">
	</tr>
# 
#-----[ OPEN ]----- 
# 
language/lang_english/lang_admin.php
# 
#-----[ FIND ]----- 
# 


//
// Install Process
//
# 
#-----[ BEFORE, ADD ]----- 
# 
$lang['highlight_topic_color'] = 'Topic title color when user has posted';
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 