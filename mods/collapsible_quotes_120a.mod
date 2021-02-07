##############################################################
## MOD Title: Collapsible Quotes
## MOD Author: Lady Serena < pagan_lady_serena@yahoo.com > (Jessica) http://www.varusonline.com
## MOD Description: This MOD offers a way of collapsing quotes to make page navigation easier
##                  for the members.  Quotes can be either shown or hidden based on profile
##                  settings.
## MOD Version: 1.2.0a
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: templates/subSilver/bbcode.tpl
##                viewtopic.php
##                language/lang_english/lang_main.tpl
##                includes/bbcode.php
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
##    This MOD was designed, implemented, and tested on a
##    forum using the Profile Contol Panel.
##############################################################
## MOD History:
##
##   2005-08-21 - Version 1.0.0
##      - First version
##
##   2005-08-30 - Version 1.2.0a
##      - Fixed language usage
##      - Added 'Auto' for profile page authors
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/bbcode.tpl

#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN quote_username_open --></span>
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr> 
	  <td><span class="genmed"><b>{USERNAME} {L_WROTE}:</b></span></td>
	</tr>
	<tr>
	  <td class="quote"><!-- END quote_username_open -->
<!-- BEGIN quote_open --></span>
<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr> 
	  <td><span class="genmed"><b>{L_QUOTE}:</b></span></td>
	</tr>
	<tr>
	  <td class="quote"><!-- END quote_open -->
<!-- BEGIN quote_close --></td>
	</tr>
</table>
<!-- END quote_close -->

#
#-----[ REPLACE WITH ]------------------------------------------
#
<!-- BEGIN quote_username_open --></span>
<table width="90%" cellspacing="0" cellpadding="3" border="0" align="center">
<tr>
	<td>
<span style="font-size: 11px;">
<div style="margin:2px; margin-top:5px">
<div class="genmed" style="margin-bottom:2px">
<b>{USERNAME} {L_WROTE}:</b> <input type="button" value="{Q_BUTTON}" style="width:45px;font-size:10px;margin:0px;padding:0px;" onClick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = '{B_HIDE}'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = '{B_SHOW}'; }">
</div>
<div class="quote" style="margin: 0px; padding: 6px; border: 1px inset; background-color: #FAFAFF; border: #000000; border-style: solid; border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px">
<div style="display: {Q_STATUS};"><!-- END quote_username_open -->
<!-- BEGIN quote_open --></span>
<table width="90%" cellspacing="0" cellpadding="3" border="0" align="center">
<tr>
	<td>
<span style="font-size: 11px;">
<div style="margin:2px; margin-top:5px">
<div class="genmed" style="margin-bottom:2px">
<b>{L_QUOTE}:</b> <input type="button" value="{Q_BUTTON}" style="width:45px;font-size:10px;margin:0px;padding:0px;" onClick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; this.innerText = ''; this.value = '{B_HIDE}'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.innerText = ''; this.value = '{B_SHOW}'; }">
</div>
<div class="quote" style="margin: 0px; padding: 6px; border: 1px inset; background-color: #FAFAFF; border: #000000; border-style: solid; border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px">
<div style="display: {Q_STATUS};"><!-- END quote_open -->
<!-- BEGIN quote_close --></div></div></div></span></td></tr></table>
<!-- END quote_close -->

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
//
// Generate a 'Show posts in previous x days' select box. If the postdays var is POSTed
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
//

#
#-----[ BEFORE, ADD ]------------------------------------------
#
if ( $userdata['user_hide_quotes'] != 0 )
{
    $bbcode_quote_stat = ($userdata['user_hide_quotes']==1)?'Show':'none';
    $bbcode_quote_butt = ($userdata['user_hide_quotes']==1)?$lang['button_hide']:$lang['button_show'];
}

#
#-----[ FIND ]------------------------------------------
#
	$template->assign_block_vars('postrow', array(

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	if ( $userdata['user_hide_quotes'] == 0 )
	{
        $bbcode_quote_butt = ($mini_post_img==$images['icon_minipost_new'])?$lang['button_hide']:$lang['button_show'];
        $bbcode_quote_stat = ($bbcode_quote_butt==$lang['button_hide'])?'Show':'none';
	}

	$message = str_replace('{Q_BUTTON}', $bbcode_quote_butt, $message);
	$message = str_replace('{Q_STATUS}', $bbcode_quote_stat, $message);
	
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
$lang['hide_quotes'] = 'Quote Hiding';
$lang['hide_quotes_ex'] = 'Allows you to select how you want quotes to be shown, or hidden.';

$lang['button_show'] = 'Show';
$lang['button_hide'] = 'Hide';
$lang['button_auto'] = 'Auto';

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['quote_username_open'] = str_replace('{L_QUOTE}', $lang['Quote'], $bbcode_tpl['quote_username_open']);
	$bbcode_tpl['quote_username_open'] = str_replace('{L_WROTE}', $lang['wrote'], $bbcode_tpl['quote_username_open']);
	$bbcode_tpl['quote_username_open'] = str_replace('{USERNAME}', '\\1', $bbcode_tpl['quote_username_open']);


#
#-----[ AFTER, ADD ]------------------------------------------
#
	$bbcode_tpl['quote_username_open'] = str_replace('{B_SHOW}', $lang['button_show'], $bbcode_tpl['quote_username_open']);
	$bbcode_tpl['quote_username_open'] = str_replace('{B_HIDE}', $lang['button_hide'], $bbcode_tpl['quote_username_open']);
	
	$bbcode_tpl['quote_open'] = str_replace('{B_SHOW}', $lang['button_show'], $bbcode_tpl['quote_open']);
	$bbcode_tpl['quote_open'] = str_replace('{B_HIDE}', $lang['button_hide'], $bbcode_tpl['quote_open']);

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_hide_quotes` TINYINT( 4 ) DEFAULT '0' NOT NULL ;

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
Add this to your profile settings page (differs based on PCP vs. Standard).
The field name in the users table is "user_hide_quotes"

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
