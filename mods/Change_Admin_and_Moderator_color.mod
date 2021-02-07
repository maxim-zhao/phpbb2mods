############################################################## 
## MOD Title: Change Admin and Moderator color
## MOD Author: zyrexiaix < admin@xiaix.com > (David) http://www.xiaix.com 
## MOD Description: This MOD will enable you to change the font color of Administrators and Moderators through your ACP, without effecting any other colors that "fontcolor2" and "fontcolor3" are assigned to. 
## MOD Version: 1.0.1 
## 
## Installation Level: Intermediate 
## Installation Time: ~15 Minutes 
## Files To Edit: viewonline.php, admin/admin_styles.php, admin/page_header_admin.php, includes/page_header.php, language/lang_english/lang_admin.php, admin/styles_edit_body.tpl 
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: I've seen many posts asking how to change the Amdinistrator and Moderator font colors withougt effecting any other colors on their forums.  Well, this is it.  This has been tested and used on PHPBB version 2.0.16 only.
## 
############################################################## 
## MOD History: 
## 
##   2005-07-17 - Version 1.0.1 
##      - Fixed SQL entries 
##
##   2005-07-10 - Version 1.0.0 
##      - Initial release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 

ALTER TABLE `phpbb_themes` ADD `administrator_color` VARCHAR(6)  AFTER `fontcolor3`

# 
#-----[ SQL ]------------------------------------------ 
# 

ALTER TABLE `phpbb_themes` ADD `moderator_color` VARCHAR(6)  AFTER `administrator_color`

# 
#-----[ SQL ]------------------------------------------ 
# 

ALTER TABLE `phpbb_themes_name` ADD `administrator_color_name` CHAR(50)  AFTER `fontcolor3_name`

# 
#-----[ SQL ]------------------------------------------ 
# 

ALTER TABLE `phpbb_themes_name` ADD `moderator_color_name` CHAR(50)  AFTER `administrator_color_name`

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewonline.php

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $row['user_level'] == ADMIN )
               {
                    $username = '<b style="color:#' . $theme['fontcolor3'] . '">' . $username . '</b>';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

fontcolor3

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

administrator_color

# 
#-----[ FIND ]------------------------------------------ 
# 

else if ( $row['user_level'] == MOD )
               {
                    $username = '<b style="color:#' . $theme['fontcolor2'] . '">' . $username . '</b>';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

fontcolor2

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

moderator_color

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_styles.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$updated_name['fontcolor3_name'] = $HTTP_POST_VARS['fontcolor3_name'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$updated['administrator_color'] = $HTTP_POST_VARS['administrator_color'];
$updated_name['administrator_color_name'] = $HTTP_POST_VARS['administrator_color_name'];
$updated['moderator_color'] = $HTTP_POST_VARS['moderator_color'];
$updated_name['moderator_color_name'] = $HTTP_POST_VARS['moderator_color_name'];

# 
#-----[ FIND ]------------------------------------------ 
# 

"L_FONTCOLOR_3" => $lang['fontcolor3'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

"L_administrator_color" => $lang['administrator_color'],
"L_moderator_color" => $lang['moderator_color'],

# 
#-----[ FIND ]------------------------------------------ 
# 

"FONTCOLOR3" => $selected['fontcolor3'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

"administrator_color" => $selected['administrator_color'],
"moderator_color" => $selected['moderator_color'],

# 
#-----[ FIND ]------------------------------------------ 
# 

"FONTCOLOR3_NAME" => $selected['fontcolor3_name'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

"administrator_color_NAME" => $selected['administrator_color_name'],
"moderator_color_NAME" => $selected['moderator_color_name'],

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/page_header_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

'T_FONTCOLOR3' => '#'.$theme['fontcolor3'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

'T_administrator_color' => '#'.$theme['administrator_color'],
'T_moderator_color' => '#'.$theme['moderator_color'],

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/page_header.php

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $row['user_level'] == ADMIN )
                    {
                         $row['username'] = '<b>' . $row['username'] . '</b>';
                         $style_color = 'style="color:#' . $theme['fontcolor3'] . '"';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

fontcolor3

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

administrator_color

# 
#-----[ FIND ]------------------------------------------ 
# 

else if ( $row['user_level'] == MOD )
                    {
                         $row['username'] = '<b>' . $row['username'] . '</b>';
                         $style_color = 'style="color:#' . $theme['fontcolor2'] . '"';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

fontcolor2

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

moderator_color

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>'),

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

fontcolor3

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

administrator_color

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>'),

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

fontcolor2

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

moderator_color

# 
#-----[ FIND ]------------------------------------------ 
# 

'T_FONTCOLOR3' => '#'.$theme['fontcolor3'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

'T_administrator_color' => '#'.$theme['administrator_color'],
'T_moderator_color' => '#'.$theme['moderator_color'],

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['fontcolor3'] = 'Font Colour 3';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang['administrator_color'] = 'Administrator Font Color';
$lang['moderator_color'] = 'Moderator Font Color';

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/styles_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr>
          <td class="row1">{L_FONTCOLOR_3}:</td>
          <td class="row2"><input class="post" type="text" size="6" maxlength="6" name="fontcolor3" value="{FONTCOLOR3}"></td>
          <td class="row2"><input class="post" type="text" size="25" maxlength="100" name="fontcolor3_name" value="{FONTCOLOR3_NAME}">
</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<tr>
          <td class="row1">{L_administrator_color}:</td>
          <td class="row2"><input class="post" type="text" size="6" maxlength="6" name="administrator_color" value="{administrator_color}"></td>
          <td class="row2"><input class="post" type="text" size="25" maxlength="100" name="administrator_color_name" value="{administrator_color_NAME}">
</tr>
     
<tr>
          <td class="row1">{L_moderator_color}:</td>
          <td class="row2"><input class="post" type="text" size="6" maxlength="6" name="moderator_color" value="{moderator_color}"></td>
          <td class="row2"><input class="post" type="text" size="25" maxlength="100" name="moderator_color_name" value="{moderator_color_NAME}">
</tr>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
