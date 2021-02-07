########################################################
## MOD Title:  Table BBCode
## MOD Author:  SlapShot434 < slapshot434@gmail.com > (Matt Halpin) http://slapshot.termee.com 
## MOD Description:  This hack enables users to easily create tables in their posts without requiring you to allow the table, tr and td HTML tags. 
## MOD Version: 1.3.1 
## 
## Installation Level:  Intermediate
## Installation Time:   10-15 Minutes
## Files To Edit:	includes/bbcode.php,
## 		  	templates/subSilver/bbcode.tpl
##			posting.php
##			templates/subSilver/posting_body.tpl
##			language/lang_english/lang_main.php
##			language/lang_english/lang_bbcode.php
## Included Files:	None
########################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##		This MOD may interfere with your forum if you have already
##		   installed another BBCode MOD.
##
##		You can delete the includes/tablehelp.html if you would like, as it is no longer necessary.
## 
############################################################## 
## MOD History:
##    07/15/2005 - v. 1.3.1  (Special thanks to seleleth for providing fixes to certain problems)
##		 Changed the [mrow] tag greatly
##			- Now sets up a row for the new [mcol] tag
##			- Supports fontsize and color attributes
##		 Created a new tag - [mcol] (Please read the updated BBCode FAQ for changes)
##			- Automatically centers and bolds text for new headers
##			- Supports fontsize and color attributes
##		 Created a new attribute - fontsize (Please read the updated BBCode FAQ for changes)
##			- Sets font text size to user-selected px size
##			- Can be used with any tag
##			- Can be used in conjunction with other attributes
##			- Set default table font size to the FONTSIZE3 setting in the current template
##		 Converted "color=" to an attribute used with any tag
##		 Changed cellspacing to 0 (from 2) so table borders aren't so huge
##		 Updated BBCode FAQ to show new features
##
##    11/6/2004 - v. 1.2.4
##		 Updated to work with the newest version (v1.4.0) of the Multi BBCode MOD
##			- No longer includes a link to the BBCode FAQ
##
##    08/21/2004 - v. 1.2.3
##		 Fixed an error with the upgrade files
##
##    08/19/2004 - v. 1.2.2
##		 Fixed a hard-link error
##
##    08/18/2004 - v. 1.2.1
##		 Changed the hotkey to Alt+G (as requested by wgEric)
##		 Replaced tablehelp.html with a bbcode faq entry and link
##
##    08/13/2004 - v. 1.2.0
##		 Added the ability to define backround color for columns
##		 Created a new install file for Multi Quick BBCode Mod users
##
##    07/25/2004 - v. 1.1.0
##		 Added the ability to define backround color for rows
##
##    07/21/2004 - v. 1.0.2
##		 Fixed a few more things to make it EasyMOD compatable.
##
##    07/21/2004 - v. 1.0.1
##		 Fixed a few minor link errors and changes the syntax to better support other BBCode MODs.
##
##    07/18/2004 - v. 1.0.0
##		 This is the original version
##		 
########################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
# 
#-----[ OPEN ]------------------------------------------ 
#
includes/bbcode.php
# 
#-----[ FIND ]------------------------------------------ 
#
	$bbcode_tpl['table_row_color'] = str_replace('{TABCOLOR}', '\\1', $bbcode_tpl['table_row_color']);
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

	$bbcode_tpl['table_mainrow_color'] = str_replace('{TABMRCOLOR}', '\\1', $bbcode_tpl['table_mainrow_color']);
	$bbcode_tpl['table_mainrow_size'] = str_replace('{TABMRSIZE}', '\\1', $bbcode_tpl['table_mainrow_size']);
	$bbcode_tpl['table_mainrow_cs1'] = str_replace('{TABMRCSCOLOR}', '\\1', $bbcode_tpl['table_mainrow_cs']);
	$bbcode_tpl['table_mainrow_cs1'] = str_replace('{TABMRCSSIZE}', '\\2', $bbcode_tpl['table_mainrow_cs1']);
	$bbcode_tpl['table_maincol_color'] = str_replace('{TABMCCOLOR}', '\\1', $bbcode_tpl['table_maincol_color']);
	$bbcode_tpl['table_maincol_size'] = str_replace('{TABMCSIZE}', '\\1', $bbcode_tpl['table_maincol_size']);
	$bbcode_tpl['table_maincol_cs1'] = str_replace('{TABMCCSCOLOR}', '\\1', $bbcode_tpl['table_maincol_cs']);
	$bbcode_tpl['table_maincol_cs1'] = str_replace('{TABMCCSSIZE}', '\\2', $bbcode_tpl['table_maincol_cs1']);
	$bbcode_tpl['table_row_color'] = str_replace('{TABRCOLOR}', '\\1', $bbcode_tpl['table_row_color']);
	$bbcode_tpl['table_row_size'] = str_replace('{TABRSIZE}', '\\1', $bbcode_tpl['table_row_size']);
	$bbcode_tpl['table_row_cs1'] = str_replace('{TABRCSCOLOR}', '\\1', $bbcode_tpl['table_row_cs']);
	$bbcode_tpl['table_row_cs1'] = str_replace('{TABRCSSIZE}', '\\2', $bbcode_tpl['table_row_cs1']);
	$bbcode_tpl['table_col_color'] = str_replace('{TABCCOLOR}', '\\1', $bbcode_tpl['table_col_color']);
	$bbcode_tpl['table_col_size'] = str_replace('{TABCSIZE}', '\\1', $bbcode_tpl['table_col_size']);
	$bbcode_tpl['table_col_cs1'] = str_replace('{TABCCSCOLOR}', '\\1', $bbcode_tpl['table_col_cs']);
	$bbcode_tpl['table_col_cs1'] = str_replace('{TABCCSSIZE}', '\\2', $bbcode_tpl['table_col_cs1']);
	$bbcode_tpl['table_size'] = str_replace('{TABSIZE}', '\\1', $bbcode_tpl['table_size']);
	$bbcode_tpl['table_color'] = str_replace('{TABCOLOR}', '\\1', $bbcode_tpl['table_color']);
	$bbcode_tpl['table_cs1'] = str_replace('{TABCSCOLOR}', '\\1', $bbcode_tpl['table_cs']);
	$bbcode_tpl['table_cs1'] = str_replace('{TABCSSIZE}', '\\2', $bbcode_tpl['table_cs1']);
# 
#-----[ FIND ]------------------------------------------ 
# 
	// [table] and [/table] for making tables.
	// beginning code [table]
	$text = str_replace("[table:$uid]", $bbcode_tpl['table_open'], $text);
	// mainrow tag [mrow]
	$text = str_replace("[mrow:$uid]", $bbcode_tpl['table_mainrow'], $text);
	// row tag [row]
	$text = str_replace("[row:$uid]", $bbcode_tpl['table_row'], $text);
	// row tag with color [row color=]
	$text = preg_replace("/\[row color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['table_row_color'], $text);
	// column tag [col]
	$text = str_replace("[col:$uid]", $bbcode_tpl['table_newcol'], $text);
	// ending tags [/table]
	$text = str_replace("[/table:$uid]", $bbcode_tpl['table_close'], $text);
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	// [table] and [/table] for making tables.
	// beginning code [table], along with attributes
	$text = str_replace("[table:$uid]", $bbcode_tpl['table_open'], $text);
	$text = preg_replace("/\[table color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['table_color'], $text);
	$text = preg_replace("/\[table fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_size'], $text);
	$text = preg_replace("/\[table color=(\#[0-9A-F]{6}|[a-z]+) fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_cs1'], $text);
	// mainrow tag [mrow], along with attributes
	$text = str_replace("[mrow:$uid]", $bbcode_tpl['table_mainrow'], $text);
	$text = preg_replace("/\[mrow color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['table_mainrow_color'], $text);
	$text = preg_replace("/\[mrow fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_mainrow_size'], $text);
	$text = preg_replace("/\[mrow color=(\#[0-9A-F]{6}|[a-z]+) fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_mainrow_cs1'], $text);
	// maincol tag [mcol], along with attributes
	$text = str_replace("[mcol:$uid]", $bbcode_tpl['table_maincol'], $text);
	$text = preg_replace("/\[mcol color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['table_maincol_color'], $text);
	$text = preg_replace("/\[mcol fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_maincol_size'], $text);
	$text = preg_replace("/\[mcol color=(\#[0-9A-F]{6}|[a-z]+) fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_maincol_cs1'], $text);
	// row tag [row], along with attributes
	$text = str_replace("[row:$uid]", $bbcode_tpl['table_row'], $text);
	$text = preg_replace("/\[row color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['table_row_color'], $text);
	$text = preg_replace("/\[row fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_row_size'], $text);
	$text = preg_replace("/\[row color=(\#[0-9A-F]{6}|[a-z]+) fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_row_cs1'], $text);
	// column tag [col], along with attributes
	$text = str_replace("[col:$uid]", $bbcode_tpl['table_col'], $text);
	$text = preg_replace("/\[col color=(\#[0-9A-F]{6}|[a-z]+):$uid\]/si", $bbcode_tpl['table_col_color'], $text);
	$text = preg_replace("/\[col fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_col_size'], $text);
	$text = preg_replace("/\[col color=(\#[0-9A-F]{6}|[a-z]+) fontsize=([1-2]?[0-9]):$uid\]/si", $bbcode_tpl['table_col_cs1'], $text);
	// ending tag [/table]
	$text = str_replace("[/table:$uid]", $bbcode_tpl['table_close'], $text);
# 
#-----[ FIND ]------------------------------------------ 
# 
	// [table] and [/table] for making tables.
	$text = preg_replace("#\[table\](.*?)\[/table\]#si", "[table:$uid]\\1[/table:$uid]", $text);
	// [mrow] for making tables.
	$text = preg_replace("#\[mrow\](.*?)#si", "[mrow:$uid]\\1", $text);
	// [row] for making tables.
	$text = preg_replace("#\[row\](.*?)#si", "[row:$uid]\\1", $text);
	// [row color=] for making tables.
	$text = preg_replace("#\[row color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[row color=\\1:$uid]\\2", $text);
	// [col] for making tables.
	$text = preg_replace("#\[col\](.*?)#si", "[col:$uid]\\1", $text);
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	// [table] and [/table] for making tables.
	// beginning code [table], along with attributes
	$text = preg_replace("#\[table\](.*?)\[/table\]#si", "[table:$uid]\\1[/table:$uid]", $text);
	$text = preg_replace("#\[table color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/table\]#si", "[table color=\\1:$uid]\\2[/table:$uid]", $text);
	$text = preg_replace("#\[table fontsize=([1-2]?[0-9])\](.*?)\[/table\]#si", "[table fontsize=\\1:$uid]\\2[/table:$uid]", $text);
	$text = preg_replace("#\[table color=(\#[0-9A-F]{6}|[a-z\-]+) fontsize=([1-2]?[0-9])\](.*?)\[/table\]#si", "[table color=\\1 fontsize=\\2:$uid]\\3[/table:$uid]", $text);
	$text = preg_replace("#\[table fontsize=([1-2]?[0-9]) color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/table\]#si", "[table color=\\2 fontsize=\\1:$uid]\\3[/table:$uid]", $text);
	// mainrow tag [mrow], along with attributes
	$text = preg_replace("#\[mrow\](.*?)#si", "[mrow:$uid]\\1", $text);
	$text = preg_replace("#\[mrow color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[mrow color=\\1:$uid]\\2", $text);
	$text = preg_replace("#\[mrow fontsize=([1-2]?[0-9])\](.*?)#si", "[mrow fontsize=\\1:$uid]\\2", $text);
	$text = preg_replace("#\[mrow color=(\#[0-9A-F]{6}|[a-z\-]+) fontsize=([1-2]?[0-9])\](.*?)#si", "[mrow color=\\1 fontsize=\\2:$uid]\\3", $text);
	$text = preg_replace("#\[mrow fontsize=([1-2]?[0-9]) color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[mrow color=\\2 fontsize=\\1:$uid]\\3", $text);
	// maincol tag [mcol], along with attributes
	$text = preg_replace("#\[mcol\](.*?)#si", "[mcol:$uid]\\1", $text);
	$text = preg_replace("#\[mcol color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[mcol color=\\1:$uid]\\2", $text);
	$text = preg_replace("#\[mcol fontsize=([1-2]?[0-9])\](.*?)#si", "[mcol fontsize=\\1:$uid]\\2", $text);
	$text = preg_replace("#\[mcol color=(\#[0-9A-F]{6}|[a-z\-]+) fontsize=([1-2]?[0-9])\](.*?)#si", "[mcol color=\\1 fontsize=\\2:$uid]\\3", $text);
	$text = preg_replace("#\[mcol fontsize=([1-2]?[0-9]) color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[mcol color=\\2 fontsize=\\1:$uid]\\3", $text);
	// row tag [row], along with attributes
	$text = preg_replace("#\[row\](.*?)#si", "[row:$uid]\\1", $text);
	$text = preg_replace("#\[row color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[row color=\\1:$uid]\\2", $text);
	$text = preg_replace("#\[row fontsize=([1-2]?[0-9])\](.*?)#si", "[row fontsize=\\1:$uid]\\2", $text);
	$text = preg_replace("#\[row color=(\#[0-9A-F]{6}|[a-z\-]+) fontsize=([1-2]?[0-9])\](.*?)#si", "[row color=\\1 fontsize=\\2:$uid]\\3", $text);
	$text = preg_replace("#\[row fontsize=([1-2]?[0-9]) color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[row color=\\2 fontsize=\\1:$uid]\\3", $text);
	// column tag [col], along with attributes
	$text = preg_replace("#\[col\](.*?)#si", "[col:$uid]\\1", $text);
	$text = preg_replace("#\[col color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[col color=\\1:$uid]\\2", $text);
	$text = preg_replace("#\[col fontsize=([1-2]?[0-9])\](.*?)#si", "[col fontsize=\\1:$uid]\\2", $text);
	$text = preg_replace("#\[col color=(\#[0-9A-F]{6}|[a-z\-]+) fontsize=([1-2]?[0-9])\](.*?)#si", "[col color=\\1 fontsize=\\2:$uid]\\3", $text);
	$text = preg_replace("#\[col fontsize=([1-2]?[0-9]) color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)#si", "[col color=\\2 fontsize=\\1:$uid]\\3", $text);
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN table_open --><table align="top" cellpadding="2" cellspacing="2" border="1" bgcolor="#FFFFFF"><!-- END table_open -->
<!-- BEGIN table_close --></td></tr></table><!-- END table_close -->
<!-- BEGIN table_mainrow --><tr bgcolor="#FFFF00" align="center"><td><!-- END table_mainrow -->
<!-- BEGIN table_row --></td></tr><tr><td><!-- END table_row -->
<!-- BEGIN table_row_color --></td></tr><tr bgcolor="{TABCOLOR}"><td><!-- END table_row_color -->
<!-- BEGIN table_newcol --></td><td><!-- END table_newcol -->
#
#-----[ REPLACE WITH ]------------------------------------------
#
<!-- BEGIN table_open --><table align="top" cellpadding="2" cellspacing="0" class="postbody" border="1" bgcolor="#FFFFFF"><!-- END table_open -->
<!-- BEGIN table_close --></td></tr></table><!-- END table_close -->
<!-- BEGIN table_color --><table align="top" cellpadding="2" cellspacing="0" class="postbody" bgcolor="{TABCOLOR}" border="1"><!-- END table_color -->
<!-- BEGIN table_size --><table align="top" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" style="font-size: {TABSIZE}px" border="1"><!-- END table_size -->
<!-- BEGIN table_cs --><table align="top" cellpadding="2" cellspacing="0" bgcolor="{TABCSCOLOR}" style="font-size: {TABCSSIZE}px" border="1"><!-- END table_cs -->
<!-- BEGIN table_mainrow --></td></tr><tr><td style="font-weight: bold; text-align: center;"><!-- END table_mainrow -->
<!-- BEGIN table_mainrow_color --></td></tr><tr bgcolor="{TABMRCOLOR}"><td style="font-weight: bold; text-align: center;"><!-- END table_mainrow_color -->
<!-- BEGIN table_mainrow_size --></td></tr><tr style="font-size: {TABMRSIZE}px;"><td style="font-weight: bold; text-align: center;"><!-- END table_mainrow_size -->
<!-- BEGIN table_mainrow_cs --></td></tr><tr bgcolor="{TABMRCSCOLOR}" style="font-size: {TABMRCSSIZE}px"><td style="font-weight: bold; text-align: center;"><!-- END table_mainrow_cs -->
<!-- BEGIN table_maincol --></td><td style="font-weight: bold; text-align: center;"><!-- END table_maincol -->
<!-- BEGIN table_maincol_color --></td><td bgcolor="{TABMCCOLOR}" style="font-weight: bold; text-align: center;"><!-- END table_maincol_color -->
<!-- BEGIN table_maincol_size --></td><td style="font-size: {TABMCSIZE}px; font-weight: bold; text-align: center;"><!-- END table_maincol_size -->
<!-- BEGIN table_maincol_cs --></td><td bgcolor="{TABMCCSCOLOR}" style="font-size: {TABMCCSSIZE}px; font-weight: bold; text-align: center;"><!-- END table_maincol_cs -->
<!-- BEGIN table_row --></td></tr><tr><td><!-- END table_row -->
<!-- BEGIN table_row_color --></td></tr><tr bgcolor="{TABRCOLOR}"><td><!-- END table_row_color -->
<!-- BEGIN table_row_size --></td></tr><tr style="font-size: {TABRSIZE}px"><td><!-- END table_row_size -->
<!-- BEGIN table_row_cs --></td></tr><tr bgcolor="{TABRCSCOLOR}" style="font-size: {TABRCSSIZE}px"><td><!-- END table_row_cs -->
<!-- BEGIN table_col --></td><td><!-- END table_col -->
<!-- BEGIN table_col_color --></td><td bgcolor="{TABCCOLOR}"><!-- END table_col_color -->
<!-- BEGIN table_col_size --></td><td style="font-size: {TABCSIZE}px"><!-- END table_col_size -->
<!-- BEGIN table_col_cs --></td><td bgcolor="{TABCCSCOLOR}" style="font-size: {TABCCSSIZE}px"><!-- END table_col_cs -->
# 
#-----[ OPEN ]------------------------------------------
# 
posting.php
# 
#-----[ FIND ]------------------------------------------
# 
# NOTE: the full line to look for is: 
#	'L_BBCODE_T_HELP' => $lang['bbcode_t_help'], 
# 
	'L_BBCODE_T_HELP' => 
# 
#-----[ REPLACE WITH ]------------------------------------------
# 
	'L_BBCODE_G_HELP' => $lang['bbcode_g_help'],
# 
#-----[ FIND ]------------------------------------------
# 
# NOTE: the full line to look for is: 
#	'U_REVIEW_TOPIC' => ( $mode == 'reply' ) ? append_sid("posting.$phpEx?mode=topicreview&amp;" . POST_TOPIC_URL . "=$topic_id") : '', 
# 
	'U_REVIEW_TOPIC' =>
# 
#-----[ AFTER, ADD ]------------------------------------------
# 
	'U_BBCODE_G_FAQ' => append_sid($phpbb_root_path . 'faq.'.$phpEx.'?mode=bbcode#tables'),
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/posting_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
#
t_help = "{L_BBCODE_T_HELP}";
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
g_help = "{L_BBCODE_G_HELP}";
# 
#-----[ FIND ]------------------------------------------ 
# 
# NOTE: the full line to look for is: 
#			  <input type="button" class="button" accesskey="t" name="addbbcode18" value="Table" style="width: 40px" onClick="bbstyle(18)" onMouseOver="helpline('t')" />
# 
			  <input type="button" class="button" accesskey="t" name="addbbcode18" value="Table"
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
accesskey="t"
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
accesskey="g"
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
onMouseOver="helpline('t')"
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
onMouseOver="helpline('g')"
# 
#-----[ FIND ]------------------------------------------ 
# 
# NOTE: the full line is much longer
# 
			  <a align="top" href='javascript:void window.open("includes/tablehelp.html
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
			  <a href="{U_BBCODE_G_FAQ}" target="_blank"><img align="top" src="templates/subSilver/images/icon_tablebbcode.gif" border=0 /></a></td>
# 
#-----[ OPEN ]------------------------------------------
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------
# 
# NOTE: the full line to look for is: 
#$lang['bbcode_t_help'] = 'Tables:   Click the question mark for more info..  (alt+t)';
# 
$lang['bbcode_t_help'] = 
# 
#-----[ IN-LINE FIND ]------------------------------------------
# 
['bbcode_t_help']
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
# 
['bbcode_g_help']
# 
#-----[ IN-LINE FIND ]------------------------------------------
# 
(alt+t)
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
# 
(alt+g)
# 
#-----[ OPEN ]------------------------------------------
# 
language/lang_english/lang_bbcode.php
# 
#-----[ FIND ]------------------------------------------
# 
$faq[] = array("--", "Other matters");
# 
#-----[ BEFORE, ADD ]------------------------------------------
# 
$faq[] = array("--", "<a name=\"tables\"></a>Making Tables");
$faq[] = array("What do the [table] and [/table] tags do?", "You use [table] and [/table] to start and end the table<br />Use <b>[table]</b> at the very beginning of the table, <br />and <b>[/table]</b> at the very end.");
$faq[] = array("What does the [mrow] tag do?", "You use [mrow] for a new row that starts with a header column (Centered, Bold text).<br />Note: [/mrow] is NOT required<br /><br /><b><u>For example:</u></b><br /><br />[table]<b>[mrow]</b>Main Row[/table]<br /><br />Will show up as<br /><br /><table align=\"top\" cellpadding=\"2\" cellspacing=\"0\" style=\"font-size: 12px\" border=\"1\" bgcolor=\"#FFFFFF\"><tr><td style=\"font-weight: bold; text-align: center;\">Main Row</td></tr></table>");
$faq[] = array("What does the [mcol] tag do?", "You use [mcol] for each new header column (Centered, Bold text).<br />Note: [/mcol] is NOT required<br /><br /><b><u>For example:</u></b><br /><br />[table][mrow]Main Row Column 1<b>[mcol]</b>Main Row Column 2[col]Main Row Regular Column[/table]<br /><br />Will show up as<br /><br /><table align=\"top\" cellpadding=\"2\" cellspacing=\"0\" style=\"font-size: 12px\" border=\"1\" bgcolor=\"#FFFFFF\"><tr><td style=\"font-weight: bold; text-align: center;\">Main Row Column 1</td><td style=\"font-weight: bold; text-align: center;\">Main Row Column 2</td><td>Main Row Regular Column</td></tr></table>");
$faq[] = array("What does the [row] tag do?", "You use [row] for each new row (plain, uncentered)<br />Note: [/row] is NOT required<br /><br /><b><u>For example:</u></b><br /><br />[table][mrow]Main Row<b>[row]</b>Regular Row[/table]<br /><br />Will show up as...<br /><br /><table align=\"top\" cellpadding=\"2\" cellspacing=\"0\" style=\"font-size: 12px\" border=\"1\" bgcolor=\"#FFFFFF\"><tr><td style=\"font-weight: bold; text-align: center;\">Main Row</td></tr><tr><td>Regular Row</td></tr></table>");
$faq[] = array("What does the [col] tag do?", "Use [col] to create a new column (plain, uncentered)<br />Note: [/col] is NOT required<br /><br /><b><u>For example:</u></b><br /><br />[table][mrow]Main Row Column 1[mcol]Main Row Column 2[row]Regular Row Column 1<b>[col]</b>Regular Row Column 2[/table]<br /><br />Will show up as<br /><br /><table align=\"top\" cellpadding=\"2\" cellspacing=\"0\" style=\"font-size: 12px\" border=\"1\" bgcolor=\"#FFFFFF\"><tr><td style=\"font-weight: bold; text-align: center;\">Main Row Column 1</td><td style=\"font-weight: bold; text-align: center;\">Main Row Column 2</td></tr><tr><td>Regular Row Column 1</td><td>Regular Row Column 2</td></tr></table>");
$faq[] = array("Do I need to add closing tags for the [mrow], [mcol], [row], or [col] tags?", "No, the Table BBCode is set up to eliminate the need for any closing tags other than the [/table] tag, which is required.");
$faq[] = array("What are the different attributes?", "You can use <a href=\"#color\">\"color=\"</a> and <a href=\"#fontsize\">\"fontsize=\"</a> with any tag. You use them the same way you would an html attribute by seperating each tag with a single space. The order in which you use them does not matter.<br /><br /><a name=\"color\"><br /></a><span style=\"font-size: 16px\"><b><u>Color</u></b></span><br /><br />The \"color=\" attribute allows you to change the background color.<br />You can specify either a recognised colour name (eg. red, blue, yellow, etc.) or the hexadecimal triplet alternative, eg. #FFFFFF, #000000.<br /><br /><b><u>Example:</u></b><br />[table color=blue][mrow color=green]Main Row Column 1[mcol color=red]Main Row Column 2[row color=#00FF00]Regular Row 1 Column 1[col color=#FF0000]Regular Row 1 Column 2[row]Regular Row 2 Column 1[col]Regular Row 2 Column 2[/table]<br />&nbsp;&nbsp;&nbsp;Will show up as<br /><table align=\"top\" cellpadding=\"2\" cellspacing=\"0\" style=\"font-size: 12px\" border=\"1\" bgcolor=\"#0000FF\"><tr bgcolor=\"#00FF00\"><td style=\"font-weight: bold; text-align: center;\">Main Row Column 1</td><td bgcolor=\"#FF0000\" style=\"font-weight: bold; text-align: center;\">Main Row Column 2</td></tr><tr bgcolor=\"#FF0000\"><td>Regular Row 1 Column 1</td><td bgcolor=\"#00FF00\">Regular Row 1 Column 2</td></tr><tr><td>Regular Row 2 Column 1</td><td>Regular Row 2 Column 2</table><br /><hr><br /><a name=\"fontsize\"></a><br /><span style=\"font-size: 16px\"><b><u>Fontsize</u></b></span><br /><br />The \"fontsize=\" attribute allows you to change the text size.<br />The default font size is set to the FONTSIZE3 setting in the current template, however this can be changed by using the attribute in the [table] tag.<br /><br /><b><u>Example:</u></b><br />[table fontsize=18][mrow fontsize=10]Main Row Column 1[mcol fontsize=14]Main Row Column 2[row fontsize=5]Regular Row 1 Column 1[col fontsize=28]Regular Row 1 Column 2[row]Regular Row 2 Column 1[col]Regular Row 2 Column 2[/table]<br />&nbsp;&nbsp;&nbsp;Will show up as<br /><table align=\"top\" cellpadding=\"2\" cellspacing=\"0\" style=\"font-size: 18px\" border=\"1\" bgcolor=\"#FFFFFF\"><tr style=\"font-size: 10px\"><td style=\"font-weight: bold; text-align: center;\">Main Row Column 1</td><td  style=\"font-weight: bold; text-align: center; font-size: 14px\">Main Row Column 2</td></tr><tr style=\"font-size: 5px\"><td>Regular Row 1 Column 1</td><td style=\"font-size: 28px\">Regular Row 1 Column 2</td></tr><tr><td>Regular Row 2 Column 1</td><td>Regular Row 2 Column 2</table>");

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 