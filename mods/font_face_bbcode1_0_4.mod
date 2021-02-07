##############################################################
## MOD Title: Font Face BBCode
## MOD Author: Herbalite < hrpeters@gmx.net > (Herbert Peters) N/A
## MOD Description: This Mod adds the ability to change font faces for your messages. Syntax is [font=arial]text[/font]
## MOD Version: 1.0.4
##
## Installation Level: (easy)
## Installation Time: ~10 Minutes
## Files To Edit: posting.php, privmsg.php, includes/bbcode.php, templates/subSilver/bbcode.tpl, templates/subSilver/posting_body.tpl, language/lang_english/lang_main.php, language/lang_english/lang_bbcode.php
## Included Files: (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
## Non-Western Font face names should work fine too (Tested with Chinese Traditional fonts)
## You can provide different font faces for different languages
## Just change or add your choices in $lang['font]['my_font_description'] = 'My font';
## You can also define alternate fonts. Comma seperated as you do with CSS. e.g. $lang['font]['arial'] = 'arial,sans-serif';
##
##############################################################
## MOD History:
##
##   2003-08-14 - Version 1.0.4
##      - Validated to run with phpBB 2.0.6, and 2 cosmetic changes
##
## ##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

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

	'L_BBCODE_N_HELP' => $lang['bbcode_n_help'],

#
#-----[ FIND ]------------------------------------------
#
'L_FONT_COLOR' => $lang['Font_color'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#

	'L_FONT_STYLE' => $lang['Font_style'],

#
#-----[ FIND ]------------------------------------------
#
//
// Poll entry switch/output
//

#
#-----[ BEFORE, ADD ]------------------------------------------
#

while( list($key, $font) = each($lang['font']) )
{
	$template->assign_block_vars ('font_styles', array(
		'L_FONTNAME' => $font
	));
}

#
#-----[ OPEN ]------------------------------------------
#
privmsg.php

#
#-----[ FIND ]------------------------------------------
#
'L_EMPTY_MESSAGE' => $lang['Empty_message'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#

	'L_BBCODE_N_HELP' => $lang['bbcode_n_help'],

#
#-----[ FIND ]------------------------------------------
#
'L_FONT_COLOR' => $lang['Font_color'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#

	'L_FONT_STYLE' => $lang['Font_style'],

#
#-----[ FIND ]------------------------------------------
#
'U_VIEW_FORUM' => append_sid("privmsg.$phpEx"))
	);

#
#-----[ AFTER, ADD ]------------------------------------------
# Note: Notice the  ); in the find above and add the following after it

while( list($key, $font) = each($lang['font']) )
{
	$template->assign_block_vars ('font_styles', array(
		'L_FONTNAME' => $font
	));
}

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

	$bbcode_tpl['font_open'] = str_replace('{FONT}', '\\1', $bbcode_tpl['font_open']);

#
#-----[ FIND ]------------------------------------------
#
$text = str_replace("[/size:$uid]", $bbcode_tpl['size_close'], $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	// font (note: The font=(.*?) is needed for Non-Western font names)
	$text = preg_replace("/\[font=(.*?):$uid\]/si", $bbcode_tpl['font_open'], $text);
	$text = str_replace("[/font:$uid]", $bbcode_tpl['font_close'], $text);

#
#-----[ FIND ]------------------------------------------
#
$text = preg_replace("#\[size=([1-2]?[0-9])\](.*?)\[/size\]#si", "[size=\\1:$uid]\\2[/size:$uid]", $text);

#
#-----[ AFTER, ADD ]------------------------------------------
#

	// [font] and [/font] for setting font style (note: The font=(.*?) is needed for Non-Western font names)
	$text = preg_replace("#\[font=(.*?)\](.*?)\[/font\]#si", "[font=\\1:$uid]\\2[/font:$uid]", $text);

#
#-----[ OPEN ]------------------------------------------
# You need to do this for all of your installed template styles
templates/subSilver/bbcode.tpl

#
#-----[ FIND ]------------------------------------------
# You need to do this for all of your installed template styles
<!-- BEGIN size_close --></span><!-- END size_close -->

#
#-----[ AFTER, ADD ]------------------------------------------
# You need to do this for all of your installed template styles

<!-- BEGIN font_open --><span style="font-family: {FONT}"><!-- END font_open -->
<!-- BEGIN font_close --></span><!-- END font_close -->

#
#-----[ OPEN ]------------------------------------------
# You need to do this for all of your installed template styles
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
f_help = "{L_BBCODE_F_HELP}";

#
#-----[ AFTER, ADD ]------------------------------------------
#

n_help = "{L_BBCODE_N_HELP}";

#
#-----[ FIND ]------------------------------------------
#
					  <option  value="24" class="genmed">{L_FONT_HUGE}</option>
					</select>

#
#-----[ AFTER, ADD ]------------------------------------------
#

					&nbsp;<select name="addbbcodefontface" onchange="bbfontstyle('[font=' + this.form.addbbcodefontface.options[this.form.addbbcodefontface.selectedIndex].value + ']', '[/font]');this.selectedIndex=0;" onmouseover="helpline('n')" accesskey="n">
						<option value="0" class="genmed" selected="selected">{L_FONT_STYLE}</option>
						<!-- BEGIN font_styles -->
					  	<option value="{font_styles.L_FONTNAME}" class="genmed" style="font-family:{font_styles.L_FONTNAME};">{font_styles.L_FONTNAME}</option>
						<!-- END font_styles -->
					</select>

#
#-----[ OPEN ]------------------------------------------
# You need to do this for all installed languages
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
# You need to do this for all installed languages
# Full line in English is: $lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';

$lang['bbcode_f_help'] =

#
#-----[ AFTER, ADD ]------------------------------------------
# You need to do this for all installed languages

$lang['bbcode_n_help'] = 'Font face:[font=arial]text[/font] Tip: Using other font faces: [font=your_font_list]';
#
#-----[ FIND ]------------------------------------------
# You need to do this for all installed languages
# Full line in English is: $lang['font_huge'] = 'Huge';
$lang['font_huge'] =

#
#-----[ AFTER, ADD  ]------------------------------------------
# You need to do this for all installed languages

$lang['Font_style'] = 'Font Face';
// Add/remove your font-faces for this language here into the array
$lang['font']['arial'] = 'Arial, sans-serif';
$lang['font']['courier'] = 'Courier, monospace';
$lang['font']['times'] = 'Times New Roman, serif';

#
#-----[ OPEN ]------------------------------------------
# You need to do this for all installed languages
language/lang_english/lang_bbcode.php

#-----[ FIND ]------------------------------------------
# You need to do this for all installed languages
# Full line in English is too long too be included here

$faq[] = array("How to change the text colour or size", "

#
#-----[ AFTER, ADD  ]------------------------------------------
# You need to do this for all installed languages

// Font face start
$faq[] = array("How to change the font face used","To alter the font face of your text, the following tag can be used. Keep in mind that how the output appears will depend on the viewers browser, system and that the font in question is installed: <ul><li>Changing the font face of text is achieved by wrapping it in <b>[font=][/font]</b>. You need to specifiy a recognized font face. (Safe font face descriptions are the generic font face names provided with CSS (Cascading Style Sheets). E.g. sans-serif, serif, monospace, cursive, fantasy). You can use comma seperated lists of font faces too. E.g. arial,geneva,helvetica,sans-serif. For example to create text with monospace font face you could use:<br /><br /><b>[font=monospace]Monospaced Text[/font]</b>.<br /><br />This will output <span style='font-family:monospace'>Monospaced text</span></li></ul>");

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
