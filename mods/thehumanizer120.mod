############################################################## 
## MOD Title: The humanizer
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/?language=english
## MOD Description: Changes the register form to prevent spam bots by a simple individual question
## MOD Version: 1.2.0
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		includes/usercp_register.php
##		templates/subSilver/profile_add_body.tpl
##		language/lang_english/lang_main.php
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
## Do not use the example question within this MOD. Only your own individual question will be save!
## 
## This modification was built for use with the phpBB template "subSilver"
##
## Screenshot: http://www.underhill.de/downloads/phpbb2mods/thehumanizer.png
## Download: http://www.underhill.de/downloads/phpbb2mods/thehumanizer.txt
############################################################## 
## MOD History: 
##
##   2007-07-14 - Version 1.2.0
##		- Changed to individual question
##
##   2006-12-31 - Version 1.1.1
##		- Removed HTML comment
##		- Successfully tested with phpBB 2.0.22
##		- Changed Author Notes
##
##   2006-08-26 - Version 1.1.0
##		- Added dynamic attribute to confuse spam bots
##		- Changed access value to prevent spam bot guessing
##
##   2006-07-17 - Version 1.0.5
##		- Added notes for a frequent install problem
##		- Added forgotten history entry for version 1.0.4
##		- Fixed more little spelling errors
##
##   2006-06-11 - Version 1.0.4
##		- Successfully tested with phpBB 2.0.21
##		- Fixed little spelling errors
##
##   2006-04-29 - Version 1.0.3 
##		- MOD Syntax changes for the phpBB MOD Database
##
##   2006-04-19 - Version 1.0.2 
##		- Fixed bug with mode=editprofile (Markus Wandel and fanrpg)
##		- Fixed some little problems with spelling and usability
##
##   2006-04-18 - Version 1.0.1 
##		- MOD Syntax changes for the phpBB.de MOD Database
## 
##   2006-04-17 - Version 1.0.0
##		- Final-Version
##		- Successfully tested with EasyMOD beta (0.3.0)
## 
##   2006-04-14 - Version 0.0.1
##		- BETA-Version
##		- Built and successfully tested with phpBB 2.0.20
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------------------
#

Do not use the example question within this MOD. Only your own individual question will be save!

#
#-----[ OPEN ]------------------------------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------------------------------
#
# NOTE - This is a partial match, the whole line on a fresh phpBB installation looks like this:
#
#	validate_optional_fields($icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature);
#

	validate_optional_fields(

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#
# NOTE - Not "INLINE AFTER, ADD"! - Add this after the whole line like:
#	validate_optional_fields($icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature);
#

	// The humanizer MOD
	$humanizer_attribute = md5(($board_config['board_startdate'] + $board_config['board_timezone']) * $board_config['avatar_filesize']);
	$ruhuman = isset($HTTP_POST_VARS[$humanizer_attribute]) ? $HTTP_POST_VARS[$humanizer_attribute] : '';
	$ruhuman = trim(htmlspecialchars($ruhuman));

#
#-----[ FIND ]------------------------------------------------------------------
#

	if ($board_config['enable_confirm'] && $mode == 'register')

#
#-----[ BEFORE, ADD ]-----------------------------------------------------------
#

	// The humanizer MOD
	$humanizer_answers = $lang['humanizer_answers'];
	if (!in_array(strtolower($ruhuman), $humanizer_answers) && $mode == 'register')
	{
		$error = TRUE;
		$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Are_u_human_wrong'];
	}

#
#-----[ FIND ]------------------------------------------------------------------
#

	if ( ($mode == 'register') || ($board_config['allow_namechange']) )

#
#-----[ BEFORE, ADD ]-----------------------------------------------------------
#

	// The humanizer MOD
	if ( $mode == 'register' )
	{
		$template->assign_block_vars('switch_register', array());
	}

#
#-----[ FIND ]------------------------------------------------------------------
#

		'SIGNATURE' => str_replace('<br />', "\n", $signature),

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		// The humanizer MOD
		'HUMANIZER' => stripslashes($ruhuman),

#
#-----[ FIND ]------------------------------------------------------------------
#

		'L_EMAIL_ADDRESS' => $lang['Email_address'],

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		// The humanizer MOD
		'L_ARE_U_HUMAN' => $lang['Are_u_human'],
		'L_ARE_U_HUMAN_EXPLAIN' => $lang['Are_u_human_explain'],

#
#-----[ FIND ]------------------------------------------------------------------
#

		'S_ALLOW_AVATAR_UPLOAD' => $board_config['allow_avatar_upload'],

#
#-----[ BEFORE, ADD ]-----------------------------------------------------------
#

		// The humanizer MOD
		'S_HUMANIZER_ATTRIBUTE' => $humanizer_attribute,

#
#-----[ OPEN ]------------------------------------------------------------------
#

templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------------------------------
#

	<!-- END switch_confirm -->

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

	<!-- BEGIN switch_register -->
	<tr> 
	  <td class="row1"><span class="gen">{L_ARE_U_HUMAN} *</span><br /><span class="gensmall">{L_ARE_U_HUMAN_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="text" name="{S_HUMANIZER_ATTRIBUTE}" class="post" style="width: 100px" size="10" maxlength="15" value="{HUMANIZER}" />
	  </td>
	</tr>
	<!-- END switch_register -->

#
#-----[ OPEN ]------------------------------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]-----------------------------------------------------------
#

// The humanizer MOD
$lang['Are_u_human'] = 'Are you human?';
$lang['Are_u_human_explain'] = 'Sorry, but this stupid question shall keep away the bots from this forum. Please type your answer in the following text field.';
$lang['Are_u_human_wrong'] = 'Sorry, but the &quot;humanizer&quot; question must be answered correctly.';
// possible humanizer answers - only use this syntax:
$lang['humanizer_answers'] = array('yes', 'jes', 'yo');

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
# EoM
