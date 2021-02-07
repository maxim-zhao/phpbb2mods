##############################################################
## MOD Title:          PHP Syntax Highlighter BBCode
## MOD Author:         Fubonis < php_fubonis@yahoo.com > (JW Frazier) http://www.fubonis.com
## MOD Description:    Highlights PHP specific code when used.
## MOD Version:        3.0.3
##
## Installation Level: Easy
## Installation Time:  15 Minutes
## Files To Edit:      includes/bbcode.php
##                     templates/subSilver/bbcode.tpl
##                     templates/subSilver/posting_body.tpl
##                     language/lang_english/lang_bbcode.php
##                     language/lang_english/lang_main.php
##                     posting.php
##                     privmsg.php
## Included Files:     N/A
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## You MUST install the following MOD for my MOD work:
##      http://www.phpbb.com/phpBB/viewtopic.php?t=74705
##      It was made for phpBB 2.0.4, but it works with phpBB 2.0.5/6 great!
##      Also, code from this MOD was incorporated into my MOD, so that extra
##           BBCode buttons could be used in Private Messages.  See the
##           privmsg.php editing section for the code.
## Large pieces of code used within this BBCode can slow down the page viewing.
## This MOD will ONLY work for PHP 4.
## I tested this MOD with EasyMOD 0.0.9c and it installed perfectly.
##############################################################
## MOD History:
##
##   2003-08-06 - Version 3.0.3
##      - I started developing this first version of this mod way back in the
##        day.  Since then, the way highlight_string() has been updated.  If
##        you have PHP 4.2.0 or greater, you might have a speed improvement,
##        because as of PHP 4.2.0, highlight_string() has a second boolean
##        arguement that will return the highlighted string, rather than
##        output it directly.  It is faster, because before we would have to
##        use output buffering to catch the string, which is slow.
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
	$bbcode_tpl['code_open'] = str_replace('{L_CODE}', $lang['Code'], $bbcode_tpl['code_open']);


#
#-----[ AFTER, ADD ]------------------------------------------
#
	$bbcode_tpl['php_open'] = str_replace('{L_PHP}', $lang['PHPCode'], $bbcode_tpl['php_open']); // PHP MOD


#
#-----[ FIND ]------------------------------------------
#
	$text = bbencode_second_pass_code($text, $uid, $bbcode_tpl);


# 
#-----[ AFTER, ADD ]------------------------------------------
#
	// PHP MOD
	// [PHP] and [/PHP] for posting PHP code in your posts.
	$text = bbencode_second_pass_php($text, $uid, $bbcode_tpl);


# 
#-----[ FIND ]------------------------------------------
#
	$text = bbencode_first_pass_pda($text, $uid, '[code]', '[/code]', '', true, '');


# 
#-----[ AFTER, ADD ]------------------------------------------
#
	// PHP MOD
	// [PHP] and [/PHP] for posting PHP code in your posts.
	$text = bbencode_first_pass_pda($text, $uid, '[php]', '[/php]', '', true, '');


#
#-----[ FIND ]------------------------------------------
#
							if ($open_tag[0] == '[code]')
							{
								$text = $before_start_tag . '&#91;code&#93;';
								$text .= $between_tags . '&#91;/code&#93;';
							}


# 
#-----[ AFTER, ADD ]------------------------------------------
#
							else if ($open_tag[0] == '[php]') // PHP MOD
							{
								$text = $before_start_tag . '/*php ';
								$text .= $between_tags . ' /php*/';
							}


# 
#-----[ FIND ]------------------------------------------
#
} // bbencode_second_pass_code()


# 
#-----[ AFTER, ADD ]------------------------------------------
#
/**
 * PHP MOD
 * Original code/function by phpBB Group
 * Modified by JW Frazier / Fubonis < php_fubonis@yahoo.com >
 */
function bbencode_second_pass_php($text, $uid, $bbcode_tpl)
{
	$code_start_html = $bbcode_tpl['php_open'];
	$code_end_html =  $bbcode_tpl['php_close'];
	$matches = array();
	$match_count = preg_match_all("#\[php:1:$uid\](.*?)\[/php:1:$uid\]#si", $text, $matches);

	for ($i = 0; $i < $match_count; $i++)
	{
		$before_replace = $matches[1][$i];
		$after_replace = trim($matches[1][$i]);
		$str_to_match = "[php:1:$uid]" . $before_replace . "[/php:1:$uid]";
		$replacement = $code_start_html;
		$after_replace = str_replace('&lt;', '<', $after_replace);
		$after_replace = str_replace('&gt;', '>', $after_replace);
		$after_replace = str_replace('&amp;', '&', $after_replace);
		$added = FALSE;
		if (preg_match('/^<\?.*?\?>$/si', $after_replace) <= 0)
		{
			$after_replace = "<?php $after_replace ?>";
			$added = TRUE;
		}
		if(strcmp('4.2.0', phpversion()) > 0)
		{
			ob_start();
			highlight_string($after_replace);
			$after_replace = ob_get_contents();
			ob_end_clean();
		}
		else
		{
			$after_replace = highlight_string($after_replace, TRUE);
		}
		if ($added == TRUE)
		{
			$after_replace = str_replace('<font color="#0000BB">&lt;?php ', '<font color="#0000BB">', $after_replace);
			$after_replace = str_replace('<font color="#0000BB">?&gt;</font>', '', $after_replace);
		}
		$after_replace = preg_replace('/<font color="(.*?)">/si', '<span style="color: \\1;">', $after_replace);
		$after_replace = str_replace('</font>', '</span>', $after_replace);
		$after_replace = str_replace("\n", '', $after_replace);
		$replacement .= $after_replace;
		$replacement .= $code_end_html;

		$text = str_replace($str_to_match, $replacement, $text);
	}

	$text = str_replace("[php:$uid]", $code_start_html, $text);
	$text = str_replace("[/php:$uid]", $code_end_html, $text);

	return $text;
}


#
#-----[ OPEN ]------------------------------------------
#
posting.php


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
,'x'


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
,$lang['PHPCode']


#
#-----[ FIND ]------------------------------------------
#
	'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],


#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_BBCODE_X_HELP' => $lang['bbcode_x_help'], // PHP MOD

# 
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl


# 
#-----[ FIND ]------------------------------------------
#
<!-- END email -->


# 
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- BEGIN php_open -->
</span>
<table border="0" align="center" width="90%" cellpadding="3" cellspacing="1">
<tr> 
	  <td><span class="genmed"><b>{L_PHP}:</b></span></td>
	</tr>
	<tr>
	  <td class="code">
		<!-- END php_open -->
		<!-- BEGIN php_close -->
		</td>
	</tr>
</table>
<span class="postbody">
<!-- END php_close -->


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
x_help = "{L_BBCODE_X_HELP}";


#
#-----[ FIND ]------------------------------------------
#
bbtags = new Array(


# 
#-----[ IN-LINE FIND ]---------------------------------
# 
'[url]','[/url]'


#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
# 
,'[php]','[/php]'


#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php


#
#-----[ FIND ]------------------------------------------
#
$lang['Code'] = 'Code'; // comes before bbcode code output.


#
#-----[ AFTER, ADD]------------------------------------------
#
$lang['PHPCode'] = 'PHP'; // PHP MOD


#
#-----[ FIND ]------------------------------------------
#
$lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';


#
#-----[ AFTER, ADD]------------------------------------------
#
$lang['bbcode_x_help'] = 'PHP syntax highlighter. [php]<?php code ?>[/php] (alt+x)'; // PHP MOD


#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_bbcode.php


#
#-----[ FIND ]------------------------------------------
#
//
// This ends the BBCode guide entries
//


#
#-----[ BEFORE, ADD]------------------------------------------
#
$faq[] = array('What\'s all this PHP nonsense!?', 'The PHP BBCode is similar to the Code BBCode, except that it should only be used for PHP code.  Why?  Because it highlights certain sections of the PHP code, making it easier to read.');



# 
#-----[ OPEN ]------------------------------------------
#
privmsg.php


#
#-----[ FIND ]------------------------------------------
#
	// Load templates
	//
	$template->set_filenames(array(
		'body' => 'posting_body.tpl')
	);
	make_jumpbox('viewforum.'.$phpEx);


#
#-----[ AFTER, ADD ]------------------------------------------
#
	// EASYMOD-begin
	//NOTE: the first element of each array must be ''   Add new elements AFTER the ''
	$EMBB_keys = array('', 'x');
	$EMBB_widths = array('', '40');
	$EMBB_values = array('', $lang['PHPCode']);

	for ($i = 1; $i < count($EMBB_values); $i++)
	{
		// EasyMod BBcode mods
		$val = ($i * 2) + 16;
		$template->assign_block_vars('EasyModBB', array(
			'KEY' => $EMBB_keys[$i],
			'NAME' => "addbbcode$val",
			'WIDTH' => $EMBB_widths[$i],
			'VALUE' => $EMBB_values[$i],
			'STYLE' => "bbstyle($val)")
		);
	}
	// EASYMOD-end


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM