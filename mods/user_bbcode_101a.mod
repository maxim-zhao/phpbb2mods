############################################################## 
## MOD Title: User BBcode
## MOD Author: kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
## MOD Description:	Adds [user] BBCode button for linking users into posts ex. [user]kkroo[/user]
##
## MOD Version: 1.0.1
## 
## Installation Level:	Easy
## Installation Time:	5 Minutes 
##
## Files To Edit:	includes/bbcode.php	
##			language/lang_english/lang_main.php
##			language/lang_english/lang_bbcode.php
##			templates/subSilver/bbcode.tpl
##			templates/subSilver/posting_body.tpl
##
## Included Files:	none
##
## License:		http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
## 
##		 IMPORTANT NOTE: you must have multiple bbcode mod version 1.4.0c installed before you install this mod...
##		 you can find that mod here: www.phpbb.com/phpBB/viewtopic.php?t=145513
##
############################################################## 
## MOD History:
##
##  2006-09-28  - Version 1.0.1
##		  fixed XSS vulnerability pointed out by mod team
##
##  2006-09-09  - Version 1.0.0
##		  initial version for use with multi bbcode
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php 

# 
#-----[ FIND ]---------------------------------
#
	$EMBB_widths = array('') ;
	$EMBB_values = array('') ;

# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_widths = array(''

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'40'

# 
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_values = array(''

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'User'


# 
#-----[ FIND ]--------------------------------- 
#
function prepare_bbcode_template($bbcode_tpl)
{
	global $lang;
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
function prepare_bbcode_template($bbcode_tpl)
{
	global $lang, $phpbb_root_path, $phpEx;
# 
#-----[ FIND ]--------------------------------- 
#
	$bbcode_tpl['quote_username_open'] = str_replace('{USERNAME}', '\\1', $bbcode_tpl['quote_username_open']);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	// start mod [user] bbcode by kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
	$bbcode_tpl['user_open'] = str_replace('{PROFILE}', '\'.  append_sid(\'' . $phpbb_root_path  . 'profile.' . $phpEx . '?mode=viewprofile&\' . POST_USERS_URL .  \'=\' . urlencode(\'\\1\') ) . \'', $bbcode_tpl['user_open']);
	
# 
#-----[ FIND ]--------------------------------- 
#
	$text = str_replace("[/b:$uid]", $bbcode_tpl['b_close'], $text);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	
	// start mod [user] bbcode by kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
	$text = preg_replace("#\[user:$uid\](.*?)\[/user:$uid\]#sie", "'${bbcode_tpl['user_open']}' . '\\1' . '${bbcode_tpl['user_close']}'", $text);


# 
#-----[ FIND ]--------------------------------- 
# 
	$text = preg_replace("#\[b\](.*?)\[/b\]#si", "[b:$uid]\\1[/b:$uid]", $text);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	//
	// start mod [user] bbcode by kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
	//
	$text = preg_replace("#\[user\](.*?)\[/user\]#si", "[user:$uid]\\1[/user:$uid]", $text);


#
#-----[ OPEN ]---------------------------------
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]---------------------------------
# 
$lang['bbcode_help']['value'] = 'BBCode Name: Info (Alt+%s)';

# 
#-----[ AFTER, ADD ]---------------------------------
# 

// start mod [user] bbcode by kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
$lang['bbcode_help']['user'] = 'Insert username: [user]username[/user]  (alt+%s)';


# 
#-----[ OPEN ]---------------------------------
# 
language/lang_english/lang_bbcode.php

#
#-----[ FIND ]---------------------------------
# 
$faq[] = array("Can I combine formatting tags?", "Yes, of course you can; for example to get someones attention you may write:<br /><br /><b>[size=18][color=red][b]</b>LOOK AT ME!<b>[/b][/color][/size]</b><br /><br />this would output <span style=\"color:red;font-size:18px\"><b>LOOK AT ME!</b></span><br /><br />We don't recommend you output lots of text that looks like this, though! Remember that it is up to you, the poster, to ensure that tags are closed correctly. For example, the following is incorrect:<br /><br /><b>[b][u]</b>This is wrong<b>[/b][/u]</b>");

# 
#-----[ BEFORE, ADD ]---------------------------------
# 
// start mod [user] bbcode by kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
$faq[] = array("What does User BBCode do?", "The [user] tag will link the profile page of the username you typed so that you can let people know who you are talking about.");

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/bbcode.tpl

# 
#-----[ FIND ]--------------------------------- 
# 
<!-- BEGIN b_close --></span><!-- END b_close --> 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<!-- BEGIN user_open --><a href="{PROFILE}"><!-- END user_open -->
<!-- BEGIN user_close --></a><!-- END user_close -->

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]---------------------------------
#
# NOTE: the actual line to find is longer, since it contains all the other bbcode tags
#
bbtags = new Array(

# 
#-----[ IN-LINE FIND ]---------------------------------
# 
'[url]','[/url]'

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
# 
,'[user]','[/user]'

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
