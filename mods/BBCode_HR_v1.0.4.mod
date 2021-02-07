##############################################################
## MOD Title: BBcode [hr]
## MOD Author: Cr@ter$ < n/a > (n/a) http://www.craterz.com/
## MOD Description: A BBcode, allowing you to add a horizontal rule into a post.
## MOD Version: 1.0.4
##
## Installation Level: (Easy)
## Installation Time: 2 Minutes
## Files To Edit: includes/bbcode.php,
##      language/lang_english/lang_bbcode.php,
##      language/lang_english/lang_main.php,
##      templates/subSilver/bbcode.tpl,
##      templates/subSilver/posting_body.tpl
##
## Included Files: (N/A)
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
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
## IMPORTANT: Requires Multi BBCode 1.4.0c or later (http://www.phpbb.com/)
##
##############################################################
## MOD History:
##
##   2006-02-05 - Version 1.0.4
##      - Corrected a few typos.
##
##   2006-01-16 - Version 1.0.2
##      - Changed a couple FINDs to reflect other BBCodes installed.
##
##   2006-01-15 - Version 1.0.0
##      - Released
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
/***************************************************************************
 *                              bbcode.php
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//-- mod : BBCode - HR ---------------------------------------------------------
# 
#-----[ FIND ]------------------------------------------ 
#
#	//NOTE: the first element of each array must be ''   Add new elements AFTER the ''
#		Full line may be longer than shown.
	$EMBB_widths = array(''
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
) ;
# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
#
, '30'
# 
#-----[ FIND ]------------------------------------------ 
#
# NOTE --- This is a Partial search
#
	$EMBB_values = array(''
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
) ;
# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
#
, 'hr'
# 
#-----[ FIND ]------------------------------------------ 
#
	// [i] and [/i] for italicizing text.
	$text = str_replace("[i:$uid]", $bbcode_tpl['i_open'], $text);
	$text = str_replace("[/i:$uid]", $bbcode_tpl['i_close'], $text);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

//-- mod : BBCode - HR ---------------------------------------------------------
//-- add
	// [hr] for inserting a horizontal rule. 
	$text = str_replace("[hr:$uid]", $bbcode_tpl['hr'], $text);
//-- fin mod : BBCode - HR -----------------------------------------------------
# 
#-----[ FIND ]------------------------------------------ 
#
	// [i] and [/i] for italicizing text.
	$text = preg_replace("#\[i\](.*?)\[/i\]#si", "[i:$uid]\\1[/i:$uid]", $text);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

//-- mod : BBCode - HR ---------------------------------------------------------
//-- add
	// [hr] for inserting a horizontal rule.
	$text = preg_replace("#\[hr\]#si", "[hr:$uid]", $text);
//-- fin mod : BBCode - HR -----------------------------------------------------
# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_bbcode.php
# 
#-----[ FIND ]------------------------------------------ 
#
/***************************************************************************
 *                         lang_bbcode.php [english]
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//-- mod : BBCode - HR ---------------------------------------------------------
# 
#-----[ FIND ]------------------------------------------ 
#
$faq[] = array("--", "Creating Links");
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//-- mod : BBCode - HR ---------------------------------------------------------
//-- add
$faq[] = array("--", "Adding a HR (Horizontal Rule) to your post");
$faq[] = array("How to add a horizontal rule in your post", "To add a horizontal rule to your post, just use the <b>[hr]</b> tag. Keep in mind that how the horizontal rule appears will vary depending on the viewers browser and system, as well as any cascading style sheet (css) set attributes for the (x)html tag. An example of the horizontal rule is this:<hr width=\"95%\" />The above line is a horizontal rule, or otherwise known as a hr tag.");
//-- fin mod : BBCode - HR -----------------------------------------------------

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
#
/***************************************************************************
 *                            lang_main.php [English]
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//-- mod : BBCode - HR ---------------------------------------------------------
# 
#-----[ FIND ]------------------------------------------ 
#
$lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
//-- mod : BBCode - HR ---------------------------------------------------------
//-- add
$lang['bbcode_help']['hr'] = 'Adds a horizontal rule: [hr]. (alt+%s)';
//-- fin mod : BBCode - HR -----------------------------------------------------
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/bbcode.tpl
# 
#-----[ FIND ]------------------------------------------ 
#
<!-- BEGIN i_open --><span style="font-style: italic"><!-- END i_open -->
<!-- BEGIN i_close --></span><!-- END i_close -->
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
#	NOTE: If you would like the width of the rule to be wider (or narrower)
#			change "90%" to a desired value, preferably as a percentage, such
#			as "100%" (or "75%").

<!-- BEGIN hr --></span><hr width="90%" /><span class="postbody"><!-- END hr -->
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/posting_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
#
# NOTE --- This is a Partial search
#
bbtags = new Array('[b]','[/b]','[i]','[/i]',
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
);
# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
#
# NOTE: It has to be the same order like the buttons are placed.
#
,'[hr]',''
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM