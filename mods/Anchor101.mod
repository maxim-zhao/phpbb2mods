############################################################## 
## MOD Title: Anchor BBCode 
## MOD Author: Xore < mods@xore.ca > (Robert Hetzler) http://www.xore.ca 
## MOD Description: Anchors for hyperlinking within posts 
## MOD Version: 1.0.1 
## 
## Installation Level: (Easy) 
## Installation Time: 3 Minutes 
## Files To Edit: posting.php,
##                privmsg.php,
##                includes/bbcode.php,
##                templates/subSilver/bbcode.tpl,
##                templates/subSilver/posting_body.tpl,
##                language/lang_english/lang_main.php,
##                language/lang_english/lang_bbcode.php
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: hyperlink within posts! FAQs! YAY!
############################################################## 
## MOD History: 
## 
##   2003-10-27 - Version 1.0.1 
##      - Updated to reflect the *actual* location of the multiple bbcode mod
## 
##   2003-09-26 - Version 1.0.0 
##      - Inspired by a need for coherent faqs, and enhanced by ideas
##        on the original thread devoted to this type of BBCode.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
# IMPORTANT: you MUST first install the latest version of the Multi Quick BBCode Mod (1.2.1+).
# This can be found here: http://www.phpbb.com/phpBB/viewtopic.php?t=145513
# 


#
#-----[ OPEN ]------------------------------------------
#
posting.php

#
#-----[ FIND ]------------------------------------------
#
'L_EMPTY_MESSAGE' => $lang['Empty_message'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#

	'L_BBCODE_2_HELP' => $lang['bbcode_2_help'],
	'L_BBCODE_3_HELP' => $lang['bbcode_3_help'],
	'L_BBCODE_4_HELP' => $lang['bbcode_4_help'],

# 
#-----[ FIND ]--------------------------------- 
# 
$EMBB_keys = array('' 
$EMBB_widths = array('' 
$EMBB_values = array('' 


# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
$EMBB_keys = array('' 


# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
,'2','3','4' 


# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
$EMBB_widths = array('' 


# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
,'60','40','80' 


# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
$EMBB_values = array('' 


# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
,'Anchor','Goto','Gotopost'

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php

#
#-----[ FIND ]------------------------------------------
#
$bbcode_tpl['code_open'] = str_replace('{L_CODE}', $lang['Code'], $bbcode_tpl['code_open']);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	$bbcode_tpl['anchor'] = str_replace('{URL}', '#%s_\\1', $bbcode_tpl['anchor']); 

	$bbcode_tpl['goto_open_1'] = str_replace('{URL}', '#\\1', $bbcode_tpl['goto_open']); 
	$bbcode_tpl['goto_open_2'] = str_replace('{URL}', '#%s_\\1', $bbcode_tpl['goto_open']); 
	$bbcode_tpl['goto_open_3'] = str_replace('{URL}', '#\\1_\\2', $bbcode_tpl['goto_open']); 

	global $phpEx;
	$bbcode_tpl['gotopost_open_1'] = str_replace('{URL}', append_sid("viewtopic.$phpEx?p=" . '\\1') . '#\\1', $bbcode_tpl['gotopost_open']); 
	$bbcode_tpl['gotopost_open_2'] = str_replace('{URL}', append_sid("viewtopic.$phpEx?p=" . '\\1') . '#\\1_\\2', $bbcode_tpl['gotopost_open']);

#
#-----[ FIND ]------------------------------------------
#
$text = str_replace("[/size:$uid]", $bbcode_tpl['size_close'], $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	$post_id = ( isset($GLOBALS['postrow'][$GLOBALS['i']]['post_id']) ) ? $GLOBALS['postrow'][$GLOBALS['i']]['post_id'] : ( ( isset($GLOBALS['post_id']) ) ? $GLOBALS['post_id'] : 0 ); 

	// anchor 
	$text = preg_replace("/\[anchor:$uid\]([a-zA-Z]\w*?)\[\/anchor:$uid\]/si", sprintf($bbcode_tpl['anchor'],$post_id), $text); 

	// goto 
	$text = preg_replace("/\[goto=([\d]+?):$uid\]/si", $bbcode_tpl['goto_open_1'], $text); 
	$text = preg_replace("/\[goto=([a-zA-Z]\w*?):$uid\]/si", sprintf($bbcode_tpl['goto_open_2'],$post_id), $text); 
	$text = preg_replace("/\[goto=([\d]+?),([a-zA-Z]\w*?):$uid\]/si", $bbcode_tpl['goto_open_3'], $text); 
	$text = str_replace("[/goto:$uid]", $bbcode_tpl['goto_close'], $text); 

	// goto post 
	$text = preg_replace("/\[gotopost=([\d]+?):$uid\]/si", $bbcode_tpl['gotopost_open_1'], $text); 
	$text = preg_replace("/\[gotopost=([\d]+?),([a-zA-Z]\w*?):$uid\]/si", $bbcode_tpl['gotopost_open_2'], $text); 
	$text = str_replace("[/gotopost:$uid]", $bbcode_tpl['gotopost_close'], $text);

#
#-----[ FIND ]------------------------------------------
#
$text = preg_replace("#\[size=([1-2]?[0-9])\](.*?)\[/size\]#si", "[size=\\1:$uid]\\2[/size:$uid]", $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	// [goto] and [gotopost] and [anchor] 
	$text = preg_replace("#\[anchor\]([a-zA-Z]\w*?)\[/anchor\]#si", "[anchor:$uid]\\1[/anchor:$uid]", $text); 

	$text = preg_replace("#\[goto=([\d]+?)\](.*?)\[/goto\]#si", "[goto=\\1:$uid]\\2[/goto:$uid]", $text); 
	$text = preg_replace("#\[goto=([a-zA-Z]\w*?)\](.*?)\[/goto\]#si", "[goto=\\1:$uid]\\2[/goto:$uid]", $text); 
	$text = preg_replace("#\[goto=([\d]+?),([a-zA-Z]\w*?)\](.*?)\[/goto\]#si", "[goto=\\1,\\2:$uid]\\3[/goto:$uid]", $text); 

	$text = preg_replace("#\[gotopost=([\d]+?)\](.*?)\[/gotopost\]#si", "[gotopost=\\1:$uid]\\2[/gotopost:$uid]", $text); 
	$text = preg_replace("#\[gotopost=([\d]+?),([a-zA-Z]\w*?)\](.*?)\[/gotopost\]#si", "[gotopost=\\1,\\2:$uid]\\3[/gotopost:$uid]", $text); 

#
#-----[ OPEN ]------------------------------------------
# You need to do this for all of your installed template styles
#
templates/subSilver/bbcode.tpl

#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN size_close --></span><!-- END size_close -->

#
#-----[ AFTER, ADD ]------------------------------------------
#

<!-- BEGIN anchor --><a name="{URL}"></a><!-- END anchor --> 

<!-- BEGIN goto_open --><a href="{URL}"><!-- END goto_open --> 
<!-- BEGIN goto_close --></a><!-- END goto_close --> 

<!-- BEGIN gotopost_open --><a href="{URL}"><!-- END gotopost_open --> 
<!-- BEGIN gotopost_close --></a><!-- END gotopost_close -->

#
#-----[ OPEN ]------------------------------------------
# You need to do this for all of your installed template styles
# 
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
f_help = "{L_BBCODE_F_HELP}";

#
#-----[ AFTER, ADD ]------------------------------------------
#

n2_help = "{L_BBCODE_2_HELP}";
n3_help = "{L_BBCODE_3_HELP}";
n4_help = "{L_BBCODE_4_HELP}";

#
#-----[ FIND ]---------------------------------
#
# NOTE: the actual line to find is MUCH longer, containing all the bbcode tags
#
bbtags = new Array(

#
#-----[ IN-LINE FIND ]---------------------------------
#
'[url]','[/url]'

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'[anchor]','[/anchor]','[goto=]','[/goto]','[gotopost=]','[/gotopost]'


#
#-----[ OPEN ]------------------------------------------
# You need to do this for all installed languages
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
# Full line in English is: $lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';
# 
$lang['bbcode_f_help'] =

#
#-----[ AFTER, ADD ]------------------------------------------
# You need to do this for all installed languages
#
$lang['bbcode_2_help'] = 'Anchor: [anchor]name[/anchor]';
$lang['bbcode_3_help'] = 'Goto: [goto=name]text[/goto] [goto=post]text[/goto] [goto=post,name]text[/goto]';
$lang['bbcode_4_help'] = 'Gotopost: [gotopost=post]text[/goto] [gotopost=post,name]text[/goto]';

#
#-----[ OPEN ]------------------------------------------
# You need to do this for all installed languages
# 
language/lang_english/lang_bbcode.php

#-----[ FIND ]------------------------------------------
# Full line in English is too long too be included here
#
$faq[] = array("How to change the text colour or size", "

#
#-----[ AFTER, ADD  ]------------------------------------------
# 
// Anchor start
$faq[] = array("How to make anchors and link inside posts","This board has anchoring and linking within posts enabled.<ul><li>To make anchors within your posts, just specify <b>[anchor]</b><i>anchorname</i><b>[/anchor]</b>.</li><li>To link to that anchor:<ol type=\"1\"><li>From within that post, use <b>[goto=<i>anchorname</i>]</b>text<b>[/goto]</b>.</li><li>From another post on the same page, use <b>[goto=<i>postnum</i>,<i>anchorname</i>]</b>text<b>[/goto]</b>.</li><li>From another post on a different page, use <b>[gotopost=<i>postnum</i>,<i>anchorname</i>]</b>text<b>[/gotopost]</b>.</li></ol></li><li>You can also use goto and gotopost to link to the top of any post:<ol type=\"1\"><li> <b>[goto=<i>postnum</i>]</b>text<b>[/goto]</b> if the other post is on the same page,</li><li>Otherwise use <b>[gotopost=<i>postnum</i>]</b>text<b>[/gotopost]</b></li></ol>.</li></ul>");

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
