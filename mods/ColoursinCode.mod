############################################################## 
## MOD Title: BBcode Colours in Code 
## MOD Author: BrotherTank < brothertank@sympatico.ca > (Greg)
## MOD Description: Allows one to use the [color] and [/color] 
##   					  commands inside of a [code] section. This allows
##                  greater flexibility when posting code segments
##                  WITHOUT loosing the formatting!
##                  
## 
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: ~10 Minutes 
## Files To Edit: bbcode.php
##
## Included Files: N/A
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## MOD History:
## 
## Mar 17, 2004 - Version 1.0.0
##  - Initial Release - only one needed!
##   
############################################################## 
## Author Notes: 
##  
##  Thanks to those that didn't want to help out.  I have no real php programming knowledge
##  and I achieved this mod with only 4 lines of code!  I hope everyone finds this
##  modification usefull as the members do in my forums!
##  
##  All 4 additions go inside the "function bbencode_first_pass_pda($text, $uid, $open_tag, $close_tag, $close_tag_new, $mark_lowest_level, $func, $open_regexp_replace = false)"
##  
##  
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php

# 
#-----[ FIND ]------------------------------------------ 
# 
						if ($mark_lowest_level && ($curr_nesting_depth == 1))
						{
							if ($open_tag[0] == '[code]')
							{
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
								// colours between [code] start
								$between_tags = preg_replace("#\[color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/color\]#si", "!color=\\1~$uid!\\2!/color~$uid!", $between_tags);
								// colours between [code] end
# 
#-----[ FIND ]------------------------------------------ 
# 
						else
						{
							if ($open_tag[0] == '[code]')
							{
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
								// colours between [code] start								
								$between_tags = preg_replace("#\[color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/color\]#si", "!color=\\1~$uid!\\2!/color~$uid!", $between_tags);
								// colours between [code] end
# 
#-----[ FIND ]------------------------------------------ 
# 
	return $text;

} // bbencode_first_pass_pda()
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	// colours between [code] start								
	$text = preg_replace("/\!color=(\#[0-9A-F]{6}|[a-z]+)~$uid\!/si","[color=\\1:$uid]" , $text);
	$text = str_replace("!/color~$uid!", "[/color:$uid]", $text);
	// colours between [code] end        
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 

