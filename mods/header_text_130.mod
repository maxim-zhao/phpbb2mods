############################################################## 
## MOD Title: Header Text 
## MOD Author: Afterlife_69 < afterlife_69[at]hotmail[dot]com > (Dean Newman) http://www.phpbbworld.com 
## MOD Description: This MOD will add a field in admin where you can specify some text to go on your header using HTML 
## MOD Version: 1.3.0 
## 
## Installation Level: Easy 
## Installation Time: 10 minutes 
## Files To Edit: admin/admin_board.php 
##                includes/page_header.php 
##                language/lang_english/lang_admin.php 
##                templates/subSilver/overall_header.tpl 
##                templates/subSilver/admin/board_config_body.tpl 
## Included Files: N/A 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: This MOD will add some custom text defined in the acp to the header of every page.
############################################################## 
## MOD History: 
## 
##   2005-06-28 - Version 1.1.0 
## - Released the first version :P 
##
##   2005-??-?? - Version 1.2.0 
## - Fixed a FIND error
##
##   2005-07-13 - Version 1.3.0 
## - Removed strip_tags() from $new['header_text']
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 
INSERT INTO phpbb_config (config_name, config_value) VALUES('header_text', ''); 

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_board.php 

# 
#-----[ FIND ]------------------------------------------ 
# 
$new['sitename'] = str_replace('"', '&quot;', strip_tags($new['sitename'])); 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$new['header_text'] = str_replace('"', '&quot;', $new['header_text']); 

# 
#-----[ FIND ]------------------------------------------ 
# 
"L_SITE_DESCRIPTION" => $lang['Site_desc'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
"L_HEADER_TEXT" => $lang['Header_text'], 
"L_HEADER_TEXT_DESC" => $lang['Header_text_desc'], 

# 
#-----[ FIND ]------------------------------------------ 
# 
"SITE_DESCRIPTION" => $new['site_desc'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
"HEADER_TEXT" => $new['header_text'], 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/page_header.php 

# 
#-----[ FIND ]------------------------------------------ 
# 
'T_SPAN_CLASS3' => $theme['span_class3'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
   'TOP_BAR_CONTENT' => $board_config['header_text'], 

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php 

# 
#-----[ FIND ]------------------------------------------ 
# 
?> 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
$lang['Header_text'] = 'Page header code'; 
$lang['Header_text_desc'] = 'This is the html to put on top of each page.'; 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/overall_header.tpl 

# 
#-----[ FIND ]------------------------------------------ 
# 
<a name="top"></a>

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
<table height="20" width="100%" cellspacing="0" cellpadding="1" border="0" align="center"> 
   <tr> 
      <td height="20" class="bodyline"><span class="gensmall"> 
      &nbsp;{TOP_BAR_CONTENT} 
      </span></td> 
   </tr> 
</table> 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/board_config_body.tpl 

# 
#-----[ FIND ]------------------------------------------ 
# 
   <tr> 
      <td class="row1">{L_SITE_DESCRIPTION}</td> 
      <td class="row2"><input class="post" type="text" size="40" maxlength="255" name="site_desc" value="{SITE_DESCRIPTION}" /></td> 
   </tr> 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
   <tr> 
      <td class="row1">{L_HEADER_TEXT}<br /><span class="gensmall">{L_HEADER_TEXT_DESC}</span></td> 
      <td class="row2"><textarea name="header_text" rows="5" cols="30">{HEADER_TEXT}</textarea></td> 
   </tr> 

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM