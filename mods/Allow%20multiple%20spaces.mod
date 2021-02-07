############################################################## 
## MOD Title: Allow multiple spaces in posts 
## MOD Author: chris_blessing < webguy@330i.net > (Chris Blessing) http://forums.330i.net 
## MOD Description: As the title states, it simply allows users to use multiple spaces 
##				    in their posts by inserting the &nbsp; entity as necessary. 
## MOD Version: 1.0.0 
## 
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: includes/functions_post.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## This is a global add-on, no ACP control provided (yet).
############################################################## 
## MOD History: 
## 
##   2004-04-17 - Version 1.0.0
##      - first edition, no ACP yet 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions_post.php

# 
#-----[ FIND ]------------------------------------------ 
# 

		$message = bbencode_first_pass($message, $bbcode_uid);
	}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	// MOD allow multiple spaces BEGIN
	$message = replace_double_spaces($message);
	// MOD allow multiple spaces END
	
# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

	// MOD allow multiple spaces BEGIN
	function replace_double_spaces($message)
	{
		// setup find/replace vars
		$nbsp_match = '/  /';
		$nbsp_replace = ' &nbsp;';
		
		// replace all instances of double-spaces with a single space + &nbsp;
		$message = preg_replace($nbsp_match, $nbsp_replace, $message);
	
		return $message;
	}
	// MOD allow multiple spaces END

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 

