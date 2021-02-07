##############################################################
## MOD Title: Align BBcode MOD
## MOD Author: smithy_dll < n/a > (David Smith) http://david.smigit.com
## MOD Description: Adds a text align BBcode tag to your forum.
##                  Supports the following alignments: Left, Right, Centered, and Justified.
## MOD Version: 2.0.6
## 
## Installation Level: Easy
## Installation Time: 9 minutes
## Files To Edit: includes/bbcode.php
##                templates/subSilver/bbcode.tpl
##                templates/subSilver/posting_body.tpl
##                language/lang_english/lang_main.php
##                posting.php
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2232.38226 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
## This mod is copyright 2002-2006 David Smith, All Rights Reserved
## Be sure to edit all templates you have loaded
## 
## The syntax is [align=(left|right|center|justify)]text[/align].
## 
## $Id: align_mod.mod,v 1.2 2006/02/23 15:05:55 david Exp $
## 
##############################################################
## MOD History:
## 
## 2005-08-28 - Version 2.0.5
## -Updated to work with phpBB2.0.17
## 
## 2006-02-24 - Version 2.0.6
## -Updated to work with phpBB2.0.19
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
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	//Begin align Mod Copyright David Smith 2002
	$bbcode_tpl['align_open'] = str_replace('{ALIGN}', '\\1', $bbcode_tpl['align_open']);
#
#-----[ FIND ]------------------------------------------
#
$text = str_replace("[/size:$uid]", $bbcode_tpl['size_close'], $text);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	// align
	$text = preg_replace("/\[align=(left|right|center|justify):$uid\]/si", $bbcode_tpl['align_open'], $text);
	$text = str_replace("[/align:$uid]", $bbcode_tpl['align_close'], $text);
#
#-----[ FIND ]------------------------------------------
#
$text = preg_replace("#\[size=([1-2]?[0-9])\](.*?)\[/size\]#si", "[size=\\1:$uid]\\2[/size:$uid]", $text);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	// [align] and [/align] for setting text align
	$text = preg_replace("#\[align=(left|right|center|justify)\](.*?)\[/align\]#si", "[align=\\1:$uid]\\2[/align:$uid]", $text);

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN size_close --></span><!-- END size_close -->
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- BEGIN align_open --><div style="text-align: {ALIGN};"><!-- END size_open -->
<!-- BEGIN align_close --></div><!-- END align_close -->
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------
#
f_help = "{L_BBCODE_F_HELP}";
#
#-----[ AFTER, ADD ]------------------------------------------
#
al_help = "{L_BBCODE_AL_HELP}";
#
#-----[ FIND ]------------------------------------------
#
					  <option  value="24" class="genmed">{L_FONT_HUGE}</option>
					</select>
#
#-----[ IN-LINE FIND ]------------------------------------------
#
</select>
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
&nbsp;{L_ALIGN_ALIGNMENT}:<select name="addbbcodefontalign" onChange="bbfontstyle('[align=' + this.form.addbbcodefontalign.options[this.form.addbbcodefontalign.selectedIndex].value + ']', '[/align]')" onMouseOver="helpline('al')">
#
#-----[ AFTER, ADD ]------------------------------------------
#
					  <option value="left" selected="selected" class="genmed">{L_ALIGN_LEFT}</option>
					  <option value="center" class="genmed">{L_ALIGN_CENTER}</option>
					  <option value="right" class="genmed">{L_ALIGN_RIGHT}</option>
					  <option value="justify" class="genmed">{L_ALIGN_JUSTIFY}</option>
					</select>
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#

//
// That's all, Folks!
// -------------------------------------------------
#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['bbcode_al_help'] = "Alignment: [align=left]text[/align] Tip: you can use center, left, right, justify";
$lang['align_left'] = 'Left';
$lang['align_right'] = 'Right';
$lang['align_center'] = 'Center';
$lang['align_justify'] = 'Justify';
$lang['align_alignment'] = 'Alignment';
#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_BBCODE_AL_HELP' => $lang['bbcode_al_help'], 
#
#-----[ FIND ]------------------------------------------
#
'L_FONT_HUGE' => $lang['font_huge'],
#
#-----[ AFTER, ADD ]------------------------------------------
#

	'L_ALIGN_LEFT' => $lang['align_left'], 
	'L_ALIGN_RIGHT' => $lang['align_right'], 
	'L_ALIGN_CENTER' => $lang['align_center'], 
	'L_ALIGN_JUSTIFY' => $lang['align_justify'], 
	'L_ALIGN_ALIGNMENT' => $lang['align_alignment'], 
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
