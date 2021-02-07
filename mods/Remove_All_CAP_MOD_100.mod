############################################################## 
## MOD Title:          Disable All CAPS MOD
## MOD Author:         morpheus2matrix < morpheus@2037.biz > (Morpheus) http://morpheus.2037.biz
## MOD Description:    This MOD will allow you to disable all the CAPS in a message 
## MOD Version:        1.0.0
## Compatibility:      2.0.6
##
## Installation Level: Easy
## Installation Time:  1 Minutes
## Files To Edit:      1
##	includes/functions_post.php
##
## Included Files:     N/A
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##
##	A good addition should be to check if we are after a dot
##	Maybe in a next version ;-)
##
############################################################## 
## MOD History:
##
##   2003-11-22 - Version 1.0.0
##	- Initial Release
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]------------------------------------------------
#
//
// Clean up the message
//
$message = trim($message);

#
#-----[ AFTER, ADD ]------------------------------------------
#

$message = strtolower($message);

$first_space = '';
$first_word = '';
$first_space = strpos($message, ' ');

$first_word = substr($message, 0, $first_space - 1);

$message = str_replace($first_word, ucfirst($first_word), $message);

#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM