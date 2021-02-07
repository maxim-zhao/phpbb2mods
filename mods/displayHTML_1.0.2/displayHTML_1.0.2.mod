################################################################# 
## MOD Title: Classic display of HTML in posts and PMs.
## MOD Author: Acyd Burn < N/A > (Meik Sievertsen) http://www.opentools.de 
## MOD Author, Secondary: Nux < egil -at- wp.pl > (Maciej Jaros) N/A
## MOD Description: 
##		Just reverses some of the changes done to privmsg.php and viewtopic.php in version 2.0.14. It's a MOD for those that want to use HTML in the similar rules as they always did before 2.0.14.
##		See section 'Author Notes' for more details and manual MOD instaltion info.
##		This MOD was tested with EasyMOD 0.2.1a beta and worked like a charm :).
##
## MOD Version: 1.0.2
## 
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: 
##		privmsg.php
##		viewtopic.php
## Included Files:
##		N/A
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	I (Nux) am not really the author of this MOD, I just reversed a _part_ of the Acyd Burn's 
##	MOD for upgrading from 2.0.13 to 2.0.14. So what this MOD does is give you 
##	the original code that was used in phpBB 2.0.13 (and most of the previous versions).
##	This means you've probably kinda already tested this MOD ;).
##
##	This MOD was tested with EasyMOD 0.2.1a beta and worked like a charm :).
##
##	Full description:
##	 In old phpBB instalations when user selects 'Always allow HTML',
##	 then (similar to 'Always allow BBCode') this will mean that he wants to 
##	 select by default option 'Disable HTML in this post/message' when _writting_ 
##	 post/message.
##	 
##	 In new phpBB instalations when user selects 'Always allow HTML',
##	 then this will mean that he wants to select by default option 
##	 'Disable HTML in this post/message' when _writting_ post/message
##	 AND when _reading_ (!) post/message.
##	 
##	 Some people (users) might see it as a bug (because they will see HTML tags in text)
##	 that's why it is up to admins to enable HTML tags that are safe (mostly that is 
##	 tags that give only text formating possibilities - like <B>,<CENTER>,...), 
##	 and you can safely install this MOD.
## 
##	For support please use this MOD's topic on http://www.phpbb.com/phpBB/
##	if you won't be able to contact me through the page you might want to 
##	mail me at: <egil (at) wp.pl>, but please rather use this MOD's topic.
##
##	Manual MOD instaltion info:
##	 + When you find a 'AFTER, ADD'-Statement, the Code have to be added after the last
##	   line quoted in the 'FIND'-Statement.
##	 + When you find a 'BEFORE, ADD'-Statement, the Code have to be added before the
##	   first line quoted in the 'FIND'-Statement.
##	 + When you find a 'REPLACE WITH'-Statement, the Code quoted in the
##	   'FIND'-Statement have to be replaced _completely_ with the quoted Code in the
##	   'REPLACE WITH'-Statement.
##
##	For further details on instaling MODs see this Knowledge Base articles:
##	 + How to Install MODs  ->  http://www.phpbb.com/kb/article.php?article_id=150
##	 + Installing a MOD in a safe way  ->  http://www.phpbb.com/kb/article.php?article_id=175
##
############################################################## 
## MOD History: 
## 
##   2005-06-30 - Version 1.0.1
##      - RC1 (added some extra info in MOD Description & Author Notes)
##   2005-05-26 - Version 1.0.0
##      - RC1
##   2005-05-10 - Version 0.0.1
##      - the same thing but properly given
##   2005-04-29 - Version 0.0.0
##      - first beta
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################


# 
#-----[ OPEN ]--------------------------------------------- 
# 
privmsg.php

#
#-----[ FIND ]---------------------------------------------
# Line 566
	if ( !$board_config['allow_html'] || !$userdata['user_allowhtml'])
	{
		if ( $user_sig != '')

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
	if ( !$board_config['allow_html'] )
 	{
		if ( $user_sig != '' && $privmsg['privmsgs_enable_sig'] && $userdata['user_allowhtml'] )

#
#-----[ FIND ]---------------------------------------------
# Line 1531
		if ( !$html_on || !$board_config['allow_html'] || !$userdata['user_allowhtml'] )
		{
			if ( $user_sig != '' )

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		if ( !$html_on )
		{
			if ( $user_sig != '' || !$userdata['user_allowhtml'] )


# 
#-----[ OPEN ]--------------------------------------------- 
# 
viewtopic.php

#
#-----[ FIND ]---------------------------------------------
# Line 1052
	if ( !$board_config['allow_html'] || !$userdata['user_allowhtml'])
	{
		if ( $user_sig != '' )


#
#-----[ REPLACE WITH ]---------------------------------------------
# 
	if ( !$board_config['allow_html'] )
	{
		if ( $user_sig != '' && $userdata['user_allowhtml'] )

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM