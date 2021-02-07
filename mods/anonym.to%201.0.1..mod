##############################################################
## MOD Title: anonym.to MOD
## MOD Author: Krank < krank98@gmail.com > (N/A)
## MOD Description: This MOD will disable direct linking by adding anonym.to at the beginning of each hotlink on your board (only in topics, posts and signatures)
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 1 minutes
## Files To Edit: includes/bbcode.php
##                
## Included Files: 
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
##############################################################
## MOD History:
##
## 2007-02-17
## -Fixed the MOD Template.
## -Fixed the anonym.to when added to www URLs with no xxxx//: prefix.
## -Submited to phpBB.com
##
## 2007-01-11
## -Submitted to phpBB 
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

	// We do URLs in several different ways..
	$bbcode_tpl['url1'] = str_replace('{URL}', '\\1', $bbcode_tpl['url']);
	$bbcode_tpl['url1'] = str_replace('{DESCRIPTION}', '\\1', $bbcode_tpl['url1']);

	$bbcode_tpl['url2'] = str_replace('{URL}', 'http://\\1', $bbcode_tpl['url']);
	$bbcode_tpl['url2'] = str_replace('{DESCRIPTION}', '\\1', $bbcode_tpl['url2']);

	$bbcode_tpl['url3'] = str_replace('{URL}', '\\1', $bbcode_tpl['url']);
	$bbcode_tpl['url3'] = str_replace('{DESCRIPTION}', '\\2', $bbcode_tpl['url3']);

	$bbcode_tpl['url4'] = str_replace('{URL}', 'http://\\1', $bbcode_tpl['url']);
	$bbcode_tpl['url4'] = str_replace('{DESCRIPTION}', '\\3', $bbcode_tpl['url4']);

# 
#-----[ REPLACE WITH ]------------------------------------------
# 

	// We do URLs in several different ways..
	 $bbcode_tpl['url1'] = str_replace('{URL}', 'http://www.anonym.to/?\\1', $bbcode_tpl['url']);
	 $bbcode_tpl['url1'] = str_replace('{DESCRIPTION}', '\\1', $bbcode_tpl['url1']);

	 $bbcode_tpl['url2'] = str_replace('{URL}', 'http://www.anonym.to/?http://\\1', $bbcode_tpl['url']);
	 $bbcode_tpl['url2'] = str_replace('{DESCRIPTION}', '\\1', $bbcode_tpl['url2']);

	 $bbcode_tpl['url3'] = str_replace('{URL}', 'http://www.anonym.to/?\\1', $bbcode_tpl['url']);
	 $bbcode_tpl['url3'] = str_replace('{DESCRIPTION}', '\\2', $bbcode_tpl['url3']);

	 $bbcode_tpl['url4'] = str_replace('{URL}', 'http://www.anonym.to/?http://\\1', $bbcode_tpl['url']);
	 $bbcode_tpl['url4'] = str_replace('{DESCRIPTION}', '\\3', $bbcode_tpl['url4']);

# 
#-----[ FIND ]------------------------------------------ 
#

	// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
	// xxxx can only be alpha characters.
	// yyyy is anything up to the first space, newline, comma, double quote or <
	$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);

	// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
	// Must contain at least 2 dots. xxxx contains either alphanum, or "-"
	// zzzz is optional.. will contain everything up to the first space, newline, 
	// comma, double quote or <.
	$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);

# 
#-----[ REPLACE WITH ]------------------------------------------
#

	// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
	// xxxx can only be alpha characters.
	// yyyy is anything up to the first space, newline, comma, double quote or <
	$ret = preg_replace("#(^|[\n ])([\w]+?://[^ \"\n\r\t<]*)#is", "\\1<a href=\"http://www.anonym.to/?\\2\" target=\"_blank\">\\2</a>", $ret);
	
	// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
	// Must contain at least 2 dots. xxxx contains either alphanum, or "-"
	// zzzz is optional.. will contain everything up to the first space, newline, 
	// comma, double quote or <.
	$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#is", "\\1<a href=\"http://www.anonym.to/?http://\\2\" target=\"_blank\">\\2</a>", $ret);
	
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
# 
# EoM