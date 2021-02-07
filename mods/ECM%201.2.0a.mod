##############################################################
## MOD Title: Extended Censoring Mod
## MOD Author: Wiccaan < wiccaan@comcast.net > (Chuck K.) http://www.google.com
## MOD Description: This MOD will examine more then the usuall strings
## for censored words to correctly format them. Included area's:
##  - BBC Code
##  - Profile (Location, Website, Occupation, Intrests)
##  - AIM, MSN, YIM are Replaced with blanks if censored word is found.
##
## MOD Version: 1.2.0 
##
## Installation Level: Easy (Anyone)
## Installation Time: ~10 Minute(s)
##
## Files To Edit: 6
## includes/bbcode.php
## includes/usercp_viewprofile.php
## groupcp.php
## memberlist.php
## privmsg.php
## viewtopic.php
##
## Included Files: 0
##
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
## Never really wrote a mod. Made this one for a friend that posted about it :P
## Was pretty easy to make, and I didnt see it submitted already. So here it is..
## Use at your own risk, and always back-up before editing files!
##
## This should install with EasyMod also!
##
## All changes made do not edit the database at all. Things are only blocked
## from showing up. They are compared to the list of censored words you set
## in your admin panel. General Admin -> Word Censors
##
## Email blocking has been added as well. If you do not want to block them
## simply add a comment character ('#') infront of the lines that block it.
##
## --------------------------------------------------------------
##
## preg_replace() Will replace a censored word if it is found
## in the original text string. If the replacement text is valid
## the text will be altered to the arrayed text, or the string
## inputed by the user.
##
## $orig_word = Censored Word List
## $replacement_word = Replacment Word List
##
##############################################################
## MOD History:
##       2006-07-10 - Revamped Edit Methods (Look at old files.)
##                  - Added GroupCP.php modifications
##                  - Added Memberlist.php modifications
##                  - Added Privmsg.php modifications
##                  - Added ViewTopic.php modifications
##                  - Added Level_List.php modifications(See forums.)
##                  - Added Email Censor (Only blocks it from showing up.)
##
##       2006-06-16 - Mod Created!
##       2006-06-16 - Changed Mod Name
##                  - Added More Features
##                  - Included Censoring Profile Strings
##                  - Added Instant Messanger Censoring
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

	// Only load the templates ONCE..
	if (!defined("BBCODE_TPL_READY"))
	{
		// load templates from file into array.
		$bbcode_tpl = load_bbcode_template();

		// prepare array for use in regexps.
		$bbcode_tpl = prepare_bbcode_template($bbcode_tpl);
	}

#
#-----[ AFTER, ADD ]------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
	// Define censored word matches
	$orig_word = array();
	$replacement_word = array();
	obtain_word_list($orig_word, $replacement_word);
	$text = preg_replace($orig_word, $replacement_word, $text);
//--[ Extended Censoring Mod End ]-------------------------------------------------------


#
#----[ OPEN ]----------------------------------
#
includes/usercp_viewprofile.php
#
#----[ FIND ]----------------------------------
#

//
// Output page header and profile_view template
//

#
#-----[ BEFORE, ADD ]--------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
// Define censored word matches
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);
//--[ Extended Censoring Mod End ]-------------------------------------------------------


#
#-----[ FIND ]--------------------------------------------------
#

$www_img = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '&nbsp;';

#
#-----[ BEFORE, ADD ]-------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
$profiledata['user_email'] = preg_replace($orig_word, '', $profiledata['user_email']);
$profiledata['user_website'] = preg_replace($orig_word, $replacement_word, $profiledata['user_website']);
$profiledata['user_aim'] = preg_replace($orig_word, '',  $profiledata['user_aim']);
$profiledata['user_msnm'] = preg_replace($orig_word, '',  $profiledata['user_msnm']);
$profiledata['user_yim'] = preg_replace($orig_word, '',  $profiledata['user_yim']);
$profiledata['user_from'] = preg_replace($orig_word, '', $profiledata['user_from']);
$profiledata['user_occ'] = preg_replace($orig_word, '', $profiledata['user_occ']);
$profiledata['user_interests'] = preg_replace($orig_word, '', $profiledata['user_interests']);
//--[ Extended Censoring Mod End ]-------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
groupcp.php
#
#-----[ FIND ]------------------------------------------
#

function generate_user_info(&$row, $date_format, $group_mod, &$from, &$posts, &$joined, &$poster_avatar, &$profile_img, &$profile, &$search_img, &$search, &$pm_img, &$pm, &$email_img, &$email, &$www_img, &$www, &$icq_status_img, &$icq_img, &$icq, &$aim_img, &$aim, &$msn_img, &$msn, &$yim_img, &$yim)
{
	global $lang, $images, $board_config, $phpEx;

#
#-----[ AFTER, ADD ]------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
	// Define censored word matches
	$orig_word = array();
	$replacement_word = array();
	obtain_word_list($orig_word, $replacement_word);
	
	$row['user_from'] = preg_replace($orig_word, '', $row['user_from']);
	$row['user_email'] = preg_replace($orig_word, '', $row['user_email']);
	$row['user_website'] = preg_replace($orig_word, $replacement_word, $row['user_website']);
	$row['user_aim'] = preg_replace($orig_word, '',  $row['user_aim']);
	$row['user_msnm'] = preg_replace($orig_word, '',  $row['user_msnm']);
	$row['user_yim'] = preg_replace($orig_word, '',  $row['user_yim']);
//--[ Extended Censoring Mod End ]-------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
memberlist.php
#
#-----[ FIND ]------------------------------------------
#

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
// Define censored word matches
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);
//--[ Extended Censoring Mod End ]-------------------------------------------------------

#
#-----[ FIND ]------------------------------------------
#

if ( $row = $db->sql_fetchrow($result) )
{
	$i = 0;
	do
	{
		$username = $row['username'];
		$user_id = $row['user_id'];

#
#-----[ AFTER, ADD ]------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
		$row['user_from'] = preg_replace($orig_word, '', $row['user_from']);
		$row['user_email'] = preg_replace($orig_word, '', $row['user_email']);
		$row['user_website'] = preg_replace($orig_word, $replacement_word, $row['user_website']);
		$row['user_aim'] = preg_replace($orig_word, '',  $row['user_aim']);
		$row['user_msnm'] = preg_replace($orig_word, '',  $row['user_msnm']);
		$row['user_yim'] = preg_replace($orig_word, '',  $row['user_yim']);
//--[ Extended Censoring Mod End ]-------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------
#

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
// Define censored word matches
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);
//--[ Extended Censoring Mod End ]-------------------------------------------------------

#
#-----[ FIND ]------------------------------------------
#

	$username_from = $privmsg['username_1'];
	$user_id_from = $privmsg['user_id_1'];
	$username_to = $privmsg['username_2'];
	$user_id_to = $privmsg['user_id_2'];
#
#-----[ AFTER, ADD ]------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
	$privmsg['user_email'] = preg_replace($orig_word, '', $privmsg['user_email']);
	$privmsg['user_website'] = preg_replace($orig_word, $replacement_word, $privmsg['user_website']);
	$privmsg['user_aim'] = preg_replace($orig_word, '', $privmsg['user_aim']);
	$privmsg['user_msnm'] = preg_replace($orig_word, '', $privmsg['user_msnm']);
	$privmsg['user_yim'] = preg_replace($orig_word, '', $privmsg['user_yim']);
//--[ Extended Censoring Mod End ]-------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
// Define censored word matches
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);
//--[ Extended Censoring Mod End ]-------------------------------------------------------

#
#-----[ FIND ]------------------------------------------
#

	$poster_from = ( $postrow[$i]['user_from'] && $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Location'] . ': ' . $postrow[$i]['user_from'] : '';

#
#-----[ BEFORE, ADD ]------------------------------------------
#

//--[ Extended Censoring Mod Start ]-----------------------------------------------------
	$postrow[$i]['user_from'] = preg_replace($orig_word, '', $postrow[$i]['user_from']);
	$postrow[$i]['user_email'] = preg_replace($orig_word, '', $postrow[$i]['user_email']);
	$postrow[$i]['user_website'] = preg_replace($orig_word, $replacement_word, $postrow[$i]['user_website']);
	$postrow[$i]['user_aim'] = preg_replace($orig_word, '',  $postrow[$i]['user_aim']);
	$postrow[$i]['user_msnm'] = preg_replace($orig_word, '',  $postrow[$i]['user_msnm']);
	$postrow[$i]['user_yim'] = preg_replace($orig_word, '',  $postrow[$i]['user_yim']);
//--[ Extended Censoring Mod End ]-------------------------------------------------------

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

