## EasyMod Compliant
########################################################
## MOD Title:    BBCode Buttons Organizer
## MOD Author:   Nuttzy < nospam@blizzhackers.com > (n/a) http://www.spellingcow.com
## MOD Author, Secondary: wGEric < eric@best-dev.com > (Eric Faerber) http://mods.best-dev.com
## MOD Description:  Allows for neater display of additional quick BBCode buttons.
## MOD Version:  1.4.0a
## 
## Installation Level:  EASY
## Installation Time:   2 minutes
## Files To Edit:       includes/bbcode.php
##                      templates/subSilver/posting_body.tpl
## Included Files:      n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
########################################################
## Author Notes:
##     + requires Multi BBCode MOD 1.4.0 or later
##		http://www.phpbb.com/phpBB/viewtopic.php?t=145513
##     + Works with phpBB 2.0.2 thru 2.0.10
##
########################################################
## MOD History:
##    2005-02-24
##	  + Fixed a bug with the helpline
##
##    2004-10-16
##	  + Updated to work with Multi BBCode 1.4.0
##
##    2003-09-25 - Version 1.2.1
##         + improved MOD Template compliance
##
##    2003-08-15 - Version 1.2.0
##         + updated to work with Multi BBCode 1.2.0
##
##    2003-02-04 - Version 1.0.1
##         + updated for 2.0.4
##         + no code changes required, just updated the header info
##
##    2002-08-31 - Version 1.0.0
##         + initial release
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


#
# IMPORTANT: you MUST first install the Multi BBCode Mod v1.4.0 available 
#            at http://www.phpbb.com/mods/
#


# 
#-----[ OPEN ]---------------------------------
# 
includes/bbcode.php


# 
#-----[ FIND ]---------------------------------
#
for ($i=1; $i<count($EMBB_values); $i++)


# 
#-----[ BEFORE, ADD ]---------------------------------
#

/* ///// removed for BBCode Buttons Mod /////
# 
#-----[ FIND ]---------------------------------
#
#

}
// MULTI BBCODE-end


# 
#-----[ BEFORE, ADD ]---------------------------------
#
*/


$max_rows = ((count($EMBB_values)-1)/9) ;
$max_rows = ($max_rows*9 == count($EMBB_values)) ? $max_rows : $max_rows+1 ;
$code_count = 1 ;
for ($i=1; $i<=$max_rows; $i++)
{
	$template->assign_block_vars('XBBcode', array(
		'ROW_ID' => $i)
	);
	
	for ($element=0; $element<9; $element++)
	{
		$val = ($code_count*2)+16 ;
		if ( $code_count < count($EMBB_values))
		{
			$help_lang = ( !empty($lang['bbcode_help'][(strtolower($EMBB_values[$code_count]))]) ) ? $lang['bbcode_help'][(strtolower($EMBB_values[$code_count]))] : $lang['bbcode_help'][$EMBB_values[$code_count]];
			$template->assign_block_vars('XBBcode.BB', array(
				'KEY' => $hotkeys[$code_count],
				'NAME' => "addbbcode$val",
				'HELP' => sprintf($help_lang, $hotkeys[$code_count]), 
				'WIDTH' => $EMBB_widths[$code_count],
				'VALUE' => $EMBB_values[$code_count],
				'STYLE' => "bbstyle($val)")
			);
		}
		$code_count++ ;
	}
}


# 
#-----[ OPEN ]---------------------------------
# 
templates/subSilver/posting_body.tpl


#
#-----[ FIND ]---------------------------------
#
<!-- BEGIN MultiBB -->
{MultiBB.VALUE}_help = "{MultiBB.HELP}";
<!-- END MultiBB -->

#
#-----[ REPLACE WITH ]---------------------------------
#
<!-- BEGIN XBBcode -->
<!-- BEGIN BB -->
{XBBcode.BB.VALUE}_help = "{XBBcode.BB.HELP}";
<!-- END BB -->
<!-- END XBBcode --> 

# 
#-----[ FIND ]---------------------------------
#
			<!-- END MultiBB -->

		  </tr>

# 
#-----[ AFTER, ADD ]---------------------------------
#

		  <!-- BEGIN XBBcode -->
		  <tr align="center" valign="middle"> 
			<!-- BEGIN BB -->
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="{XBBcode.BB.KEY}" name="{XBBcode.BB.NAME}" value="{XBBcode.BB.VALUE}" style="width: {XBBcode.BB.WIDTH}px" onClick="{XBBcode.BB.STYLE}" onMouseOver="helpline('{XBBcode.BB.VALUE}')" />
			  </span></td>
			<!-- END BB -->
		  </tr>
		  <!-- END XBBcode -->

#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM