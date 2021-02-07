#################################################
## UPGRADE FROM 1.7.0.a ***TO*** 1.7.1
#################################################
#
#
#################################################
##  Changed Files: 3	
##                      Posting.php,
##                      privmsg.php,
##                      templates/subSilver/posting_body.tpl.
##
##  New Added files: 0
##
##################################################	
#
#
##################################################
##  Author Notes:
##                     This update file is EMC! Just copy it and paste it into this MOD root directory (where
##                     the original MOD file is located) and run it from your EM Control Panel as if it were
##                     the original MOD file.
##################################################
#
#
############################################################## 
## Before Updating This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------------
#
copy root/*.* to *.*
# 
#-----[ OPEN ]------------------------------------------ 
# 
posting.php 
# 
#-----[ FIND ]------------------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.0a -----------------------------------
# 
#-----[ REPLACE WITH ]------------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.1 -----------------------------------
# 
#-----[ FIND ]------------------------------------------
#
	'WYSIWYG_EDITOR_ITALIC' => $images['icon_underline'],
# 
#-----[ REPLACE WITH ]------------------------------------
#
	'WYSIWYG_EDITOR_ITALIC' => $images['icon_italic'],
# 
#-----[ FIND ]------------------------------------------
#
	'WYSIWYG_EDITOR_UNDERLINE' => $images['icon_italic'],
# 
#-----[ REPLACE WITH ]------------------------------------
#
	'WYSIWYG_EDITOR_UNDERLINE' => $images['icon_underline'],
# 
#-----[ OPEN ]------------------------------------------ 
# 
privmsg.php 
# 
#-----[ FIND ]------------------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.0a -----------------------------------
# 
#-----[ REPLACE WITH ]------------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.1 -----------------------------------
# 
#-----[ FIND ]------------------------------------------
#
	'WYSIWYG_EDITOR_ITALIC' => $images['icon_underline'],
# 
#-----[ REPLACE WITH ]------------------------------------
#
	'WYSIWYG_EDITOR_ITALIC' => $images['icon_italic'],
# 
#-----[ FIND ]------------------------------------------
#
	'WYSIWYG_EDITOR_UNDERLINE' => $images['icon_italic'],
# 
#-----[ REPLACE WITH ]------------------------------------
#
	'WYSIWYG_EDITOR_UNDERLINE' => $images['icon_underline'],
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php 
# 
#-----[ FIND ]------------------------------------------
#	
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.0a -----------------------------------
# 
#-----[ REPLACE WITH ]------------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.1 -----------------------------------
# 
#-----[ FIND ]------------------------------------------
# 
#  NOTE - This is a partial search, the full line to look for is:
#   // [img=left] and [/img] For wrapping text around images.
#   $patterns[] = "#\[img=left:$uid\](.*?)\[/img:$uid\]#si";
#   $replacements[] = $bbcode_tpl['left'];
#
   $patterns[] = "#\[img=left:$uid\](.*?)\[/img:$uid\]#si";
# 
#-----[ REPLACE WITH ]------------------------------------
#
   // [img=left] and [/img] For wrapping text around images.
   $patterns[] = "#\[img=left:$uid\]([^?](?:[^\[]+|\[(?!url))*?)\[/img:$uid\]#i";
   $replacements[] = $bbcode_tpl['left'];
# 
#-----[ FIND ]------------------------------------------
# 
#  NOTE - This is a partial search, the full line to look for is:
#   // [img=right] and [/img] For wrapping text around images.
#   $patterns[] = "#\[img=right:$uid\](.*?)\[/img:$uid\]#si";
#   $replacements[] = $bbcode_tpl['right'];   
#
   $patterns[] = "#\[img=right:$uid\](.*?)\[/img:$uid\]#si";
# 
#-----[ REPLACE WITH ]------------------------------------
#
   // [img=right] and [/img] For wrapping text around images.
   $patterns[] = "#\[img=right:$uid\]([^?](?:[^\[]+|\[(?!url))*?)\[/img:$uid\]#i";
   $replacements[] = $bbcode_tpl['right'];   
# 
#-----[ FIND ]------------------------------------------
# 
#  NOTE - This is a partial search, the full line to look for is:
#   // [img=left] and [/img] For wrapping text around images.
#   $text = preg_replace("#\[img=left\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie", 	
#   "'[img=left:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
#
   $text = preg_replace("#\[img=left\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie",
# 
#-----[ REPLACE WITH ]------------------------------------
#
   // [img=left] and [/img] For wrapping text around images.
	$text = preg_replace("#\[img=left\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img=left:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);
# 
#-----[ FIND ]------------------------------------------
# 
#  NOTE - This is a partial search, the full line to look for is:
#   // [img=right] and [/img] For wrapping text around images	
#   $text = preg_replace("#\[img=right\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie",
#   "'[img=right:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);	
#
   $text = preg_replace("#\[img=right\]((ht|f)tp://)([^\r\n\t<\"]*?)\[/img\]#sie",
# 
#-----[ REPLACE WITH ]------------------------------------
#
   // [img=right] and [/img] For wrapping text around images	
	$text = preg_replace("#\[img=right\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img=right:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);   
# 
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------- 
# 
# EoM 	