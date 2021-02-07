##############################################################
## MOD Title: Multiple BBCode
## MOD Author: wGEric < N/A > (Eric Faerber) http://mods.best-dev.com/
## MOD Author:   Nuttzy99 < N/A > (N/A) N/A
## MOD Description: Allows you to install BBCode MODs that
##    add quick BBCode buttons in post edits.  Without this
##    MOD, there is no standard way of installing BBCode MODs.
## MOD Version: 1.6.0
##
## Installation Level: Easy
## Installation Time: 15 Minutes
## Files To Edit: posting.php
##				  privmsg.php
##				  includes/bbcode.php
##                templates/subSilver/posting_body.tpl
##				  language/lang_english/lang_main.php
## Included Files: N/A
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
##############################################################
## MOD History:
##
##	  2007-10-03 - Version 1.6.0
##		- Combined Multiple BBCode and BBCode Buttons
##
##    2004-09-26 - Version 1.4.0
##	  	- Sets hot key automatically
##	  	- Adds it to Private Messages (version b)
##	  	- Fixes a help line bug (version c)
##
##    2003-09-25 - Version 1.2.1
##    	- improved MOD Template compliance
##
##    2003-08-15 - Version 1.2.0
##    	- updated for 2.0.6
##    	- allows additional hotkeys - Xore did most of the work ;-)
##
##    2003-02-03 - Version 1.0.1
##    	- updated for 2.0.4
##    	- no code changes required, just updated the header info
##
##    2002-08-31 - Version 1.0.0
##    	- initial release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ OPEN ]---------------------------------
# 
posting.php


# 
#-----[ FIND ]---------------------------------
#
#  NOTE - the full line to look for is:
# make_jumpbox('viewforum.'.$phpEx);
#
make_jumpbox(


# 
#-----[ AFTER, ADD ]---------------------------------
#
Multi_BBCode();

# 
#-----[ OPEN ]---------------------------------
# 
privmsg.php


# 
#-----[ FIND ]---------------------------------
#
	generate_smilies('inline', PAGE_PRIVMSGS);


# 
#-----[ AFTER, ADD ]---------------------------------
#
	Multi_BBCode();

# 
#-----[ OPEN ]---------------------------------
#
includes/bbcode.php
# 
#-----[ FIND ]---------------------------------
#
$bbcode_tpl = null;
# 
#-----[ AFTER, ADD ]---------------------------------
#

// MULTI BBCODE-begin
function Multi_BBCode()
{
	global $template, $lang;

	// DO NOT CHANGE THIS ARRAY
	$hotkeys = array('', 'd', 'e', 'g', 'h', 'j', 'k', 'm', 'n', 'r', 't', 'v', 'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

	// NOTE: the first element of each array must be ''   Add new elements AFTER the ''
	$EMBB_widths = array('') ;
	$EMBB_values = array('') ;
	
	$max_rows = ((count($EMBB_values)-1)/9) ;
	$max_rows = ($max_rows*9 == count($EMBB_values)) ? $max_rows : $max_rows+1 ;
	$code_count = 1 ;
	for($i = 1; $i <= $max_rows; $i++)
	{
		$template->assign_block_vars('BBCODE_ROW', array(
			'ROW_ID' => $i,
		));
		
		for($element = 0; $element < 9; $element++)
		{
			$val = ($code_count*2)+16;
			
			if ( $code_count < count($EMBB_values))
			{			
				$help_lang = ( !empty($lang['bbcode_help'][(strtolower($EMBB_values[$code_count]))]) ) ? $lang['bbcode_help'][(strtolower($EMBB_values[$code_count]))] : $lang['bbcode_help'][$EMBB_values[$code_count]];
				
				$template->assign_block_vars('BBCODE_ROW.BBCODE', array(
					'KEY'	=> $hotkeys[$code_count],
					'NAME'	=> "addbbcode$val",
					'HELP'	=> sprintf($help_lang, $hotkeys[$code_count]), 
					'WIDTH'	=> $EMBB_widths[$code_count],
					'VALUE'	=> $EMBB_values[$code_count],
					'STYLE'	=> "bbstyle($val)",
				));
			}
			
			$code_count++ ;
		}
	}
}
// MULTI BBCODE-end

# 
#-----[ OPEN ]---------------------------------
# 
templates/subSilver/posting_body.tpl


#
#-----[ FIND ]---------------------------------
#
f_help = "{L_BBCODE_F_HELP}";

# 
#-----[ AFTER, ADD ]---------------------------------
#
<!-- BEGIN BBCODE_ROW -->
<!-- BEGIN BBCODE -->
{BBCODE_ROW.BBCODE.VALUE}_help = "{BBCODE_ROW.BBCODE.HELP}";
<!-- END BBCODE -->
<!-- END BBCODE_ROW --> 

#
#-----[ FIND ]---------------------------------
#
#  NOTE - the full line to look for is:
#			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
#			  </span></td>
#
	name="addbbcode16"
	</td>

# 
#-----[ AFTER, ADD ]---------------------------------
#			
			<!-- BEGIN BBCODE_ROW -->
			<tr align="center" valign="middle"> 
				<!-- BEGIN BBCODE -->
				<td><span class="genmed">
					<input type="button" class="button" accesskey="{BBCODE_ROW.BBCODE.KEY}" name="{BBCODE_ROW.BBCODE.NAME}" value="{BBCODE_ROW.BBCODE.VALUE}" style="width: {BBCODE_ROW.BBCODE.WIDTH}px" onClick="{BBCODE_ROW.BBCODE.STYLE}" onMouseOver="helpline('{BBCODE_ROW.BBCODE.VALUE}')" />
				</span></td>
				<!-- END BBCODE -->
			</tr>
			<!-- END BBCODE_ROW -->
# 
#-----[ FIND ]---------------------------------
#
#  NOTE - the full line to look for is:
#					<select name="addbbcodefontcolor" onChange="bbfontstyle('[color=' + this.form.addbbcodefontcolor.options[this.form.addbbcodefontcolor.selectedIndex].value + ']', '[/color]')" onMouseOver="helpline('s')">
#
	name="addbbcode18"


# 
#-----[ IN-LINE FIND ]---------------------------------
#
name="addbbcode18"


# 
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
name="addbbcodefontcolor"


# 
#-----[ IN-LINE FIND ]---------------------------------
#
this.form.addbbcode18.options


# 
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
this.form.addbbcodefontcolor.options


# 
#-----[ IN-LINE FIND ]---------------------------------
#
this.form.addbbcode18.selectedIndex


# 
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
this.form.addbbcodefontcolor.selectedIndex


# 
#-----[ FIND ]---------------------------------
#
#  NOTE - the full line to look for is:
#					</select> &nbsp;{L_FONT_SIZE}:<select name="addbbcodefontsize" onChange="bbfontstyle('[size=' + this.form.addbbcodefontsize.options[this.form.addbbcodefontsize.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
#
	name="addbbcode20"

# 
#-----[ IN-LINE FIND ]---------------------------------
#
name="addbbcode20"


# 
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
name="addbbcodefontsize"


# 
#-----[ IN-LINE FIND ]---------------------------------
#
this.form.addbbcode20.options


# 
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
this.form.addbbcodefontsize.options


# 
#-----[ IN-LINE FIND ]---------------------------------
#
this.form.addbbcode20.selectedIndex


# 
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
this.form.addbbcodefontsize.selectedIndex

# 
#-----[ OPEN ]---------------------------------
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]---------------------------------
#
#  NOTE - the full line to look for is:
#	$lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';
#
$lang['bbcode_f_help']

# 
#-----[ AFTER, ADD ]---------------------------------
#

//
// bbcode help format goes like this
// $lang['bbcode_help']['value'] = 'BBCode Name: Info (Alt+%s)';
//
// value is what you put in $EMBB_values in posting.php
// %s gets replaced with the automatic hotkey that the bbcode gets assigned
//
$lang['bbcode_help']['value'] = 'BBCode Name: Info (Alt+%s)';

#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM
