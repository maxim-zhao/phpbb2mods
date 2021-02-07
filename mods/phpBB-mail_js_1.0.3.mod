##############################################################
## MOD Title: Posted email js
## MOD Author: lcn <lars@snart.com> (Lars Nygard) http://www.snart.com/
## MOD Description: Fight spam by modifying all e-mail addresses in posts to javascripts.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 1 Minutes
## Files To Edit: includes/bbcode.php
## Included Files: N/A
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
## Don't you hate when other people post your spam free e-mail address on public boards???
## There should be no linebreaks in the line "$ret = ..." that you insert. Linebreaks will be replaced with
## a <br /> by phpBB and break the javascript.
##############################################################
## MOD History:
##
##   2004-10-24 - Version 0.0.1
##      - Initial release.
##   2004-10-25 - Version 1.0.1
##      - Updated version to stable (Hey, I'm just human.... :-)
##      - Removed a line that crept in from a cut'n'paste
##      - Changed the filename to include version number
##      - Reminded the user in the Autor notes to avoid linebreaks in the code.
##   2004-11-09 - Version 1.0.2
##      - Fixed missing padding in preg_replace
##   2005-01-05 - version 1.0.3
##      - Fixed email showing in quote....
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]-----------------------------------------------------------------
#

includes/bbcode.php

#
#-----[ FIND ]-----------------------------------------------------------------
#  Right after: 
#// matches an email@domain type address at the start of a line, or after a space.
#// Note: Only the followed chars are valid; alphanums, "-", "_" and or ".".

$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);

#
#-----[ REPLACE WITH ]-----------------------------------------------------
#

$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i","\\1<script language=\"javascript\" type=\"text/javascript\"><!--  \rdocument.write('');document.write('<a href=\"mailto:');document.write('\\2');document.write('&#64;');document.write('\\3\">');document.write('\\2');document.write('&#64;');document.write('\\3');document.write('</a>');//--></script>",$ret);

#
#-----[ OPEN ]-----------------------------------------------------------------
#

posting.php

#
#-----[ FIND ]-----------------------------------------------------------------
#  
		
$message = preg_replace('/\:(([a-z0-9]:)?)' . $post_info['bbcode_uid'] . '/s', '', $message);
 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

$message = preg_replace('/([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+)/i', '\\1 (at) \\2\\3',$message);
				 
#
#-----[ SAVE/CLOSE ALL FILES ]-------------------------------------------------
#
# EoM 
