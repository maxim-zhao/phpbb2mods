##############################################################
## MOD Title: Remove Sid For Guests (Search Engine Optimization)
## MOD Author: _underscore_ < thekingofzzt@gmail.com > (N/A) N/A
## MOD Description: Removes all sid=xyz in the urls for either all guests, guests that have a bot user-agent,
##                  or simply no one. It's admin configurable, so you can chance the settings or disable any 
##                  time you want. Makes it so that bots don't think you're
##                  spamming them with duplicate content and they don't
##                  chomp up your bandwidth.
##
## MOD Version: 1.0.3
##
## Installation Level: Easy
## Installation Time: ~5 Minutes
## Files To Edit: includes/sessions.php,
##      includes/constants.php
##      language/lang_english/lang_admin.php
##      admin/admin_board.php
##      templates/subSilver/admin/board_config_body.tpl	
##
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
## *** Massive thanks to espicom for letting me use his code
## *** as a base for this mod.
##
## We use an adaption of espicom's code for the ACP interface (he got it from somewhere else anyways)
## and for the checking if it's a bot; his bot code got me started on this mod. Don't worry, alot of the code
## is mine. ;)
##
## You can change settings for this mod in the ACP under "General -> Configuration", just after account
## activation. (Removing SIDs in URL for none disables this mod)
##
## This mod DOES NOT disable cookies, so it might still try to set them.
## Shouldn't matter anyways.
##
## Notice about the history: I THINK the months are correct, but I have
## bad memory and I didn't write them down right
##
##############################################################
## MOD History:
##
##   2006-10-11 - Version 1.0.3
##	- Fixed a bug in the ACP displaying code [This is somewhat important]
##	- Fixed two comments
##	- Changed description a bit
##
##   2006-6-30 - Version 1.0.2
##	- Fixed a bug in constants.php.
##	  Fixed afew varible names and
##	  template stuffs.
##	- Resubmitting to moddb
##
##   2006-6-20 - Version 1.0.1
##	- Fixing stuff as of the mod team's responce,
##	  Fixing dates, too.
##	  Added some more comments to the code
##
##   2006-6-15 - Version 1.0.0a
##	- Managed to mispell "espicom" - sorry!
##
##   2006-4-06 - Version 1.0.0
##      - Bumping version up to 1 as mod appears to work properly
##        Mod db submit attempt 1.
##
##   2006-4-06 - Version 0.2.0
##      - Fixed mod template, the mod should work now.
##
##   2006-4-06 - Version 0.1.3
##      - Fixed a bunch of bugs, final (I hope!) bugtesting.
##        I'm doing alot in one day, aren't I?
##
##   2006-4-06 - Version 0.1.2
##      - Using espicom's Logo-In-ACP acp interface.
##        Almost ready to release as stable.
##
##   2006-3-16 - Version 0.1.1
##      - Added mod template, got espicom's approval to release, and started adding ACP
##
##   2006-3-15 - Version 0.1.0
##      - Typed most of my code up.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 
#
#-----[ SQL ]--------------------------------------------
#
INSERT INTO phpbb_config (config_name,config_value) VALUES ('session_strip_sid','102');
#
#-----[ OPEN ]--------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]--------------------------------------------
#
$lang['Acct_activation'] = 'Enable account activation';
$lang['Acc_None'] = 'None'; // These three entries are the type of activation
$lang['Acc_User'] = 'User';
$lang['Acc_Admin'] = 'Admin';
#
#-----[ AFTER, ADD ]--------------------------------------------
#
//Added by remove sid for guests mod
$lang['Remove_sid'] = 'Remove sid for';
//These are the options
$lang['Remove_sid_all_guests'] = 'Remove sid in the url for all guests.';
$lang['Remove_sid_none'] = 'Do not remove the sid in the url for anyone.';
$lang['Remove_sid_bots'] = 'Remove sid for guests who appear to be bots only.';
//End addition
#
#-----[ OPEN ]--------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]--------------------------------------------
#Line 3 of this is partial, real line is larger!
        <tr>
                <td class="row1">{L_ACCT_ACTIVATION}</td>
                <td class="row2"><input type="radio" name="require_activation" value="{ACTIVATION_NONE}"
        </tr>
#
#-----[ AFTER, ADD ]--------------------------------------------
#
        <tr>
                <td class="row1">{L_REMOVE_SID}</td>
		<td class="row2">
			<input type="radio" name="session_strip_sid" value="{SESSION_STRIP_SID_ALL_GUESTS}"{SESSION_STRIP_SID_ALL_GUESTS_CHECKED} />{L_REMOVE_SID_ALL_GUESTS}<br />
			<input type="radio" name="session_strip_sid" value="{SESSION_STRIP_SID_NONE}"{SESSION_STRIP_SID_NONE_CHECKED} />{L_REMOVE_SID_NONE}<br />
			<input type="radio" name="session_strip_sid" value="{SESSION_STRIP_SID_BOTS_ONLY}"{SESSION_STRIP_SID_BOTS_ONLY_CHECKED} />{L_REMOVE_SID_BOTS}
		</td>
        </tr>

#
#-----[ OPEN ]--------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]--------------------------------------------
#
        "L_ACCT_ACTIVATION" => $lang['Acct_activation'],
        "L_NONE" => $lang['Acc_None'],
        "L_USER" => $lang['Acc_User'],
        "L_ADMIN" => $lang['Acc_Admin'],
#
#-----[ AFTER, ADD ]--------------------------------------------
#

	//Added by remove_sid_for_guests
	//Language entries
	"L_REMOVE_SID" => $lang['Remove_sid'],
	"L_REMOVE_SID_ALL_GUESTS" => $lang['Remove_sid_all_guests'],
	"L_REMOVE_SID_NONE" => $lang['Remove_sid_none'],
	"L_REMOVE_SID_BOTS" => $lang['Remove_sid_bots'],

	//These are defined in constants.php, and can be changed there
	"SESSION_STRIP_SID_ALL_GUESTS" => SESSIONS_STRIP_SID_ALL_GUESTS,
	"SESSION_STRIP_SID_NONE" => SESSIONS_STRIP_SID_NONE,
	"SESSION_STRIP_SID_BOTS_ONLY" => SESSIONS_STRIP_SID_BOTS_ONLY,

	//Now for the is-checked stuff
	"SESSION_STRIP_SID_ALL_GUESTS_CHECKED" => ($new['session_strip_sid'] == SESSIONS_STRIP_SID_ALL_GUESTS)?" checked=\"checked\"":"",
	"SESSION_STRIP_SID_NONE_CHECKED" => ($new['session_strip_sid'] == SESSIONS_STRIP_SID_NONE)?" checked=\"checked\"":"",
	"SESSION_STRIP_SID_BOTS_ONLY_CHECKED" => ($new['session_strip_sid'] == SESSIONS_STRIP_SID_BOTS_ONLY)?" checked=\"checked\"":"",
	//end addition
#
#-----[ OPEN ]--------------------------------------------
#
includes/sessions.php
#
#-----[ FIND ]--------------------------------------------
#Should be near the end of the file
        if ( !empty($SID) && !preg_match('#sid=#', $url) )
        {
                $url .= ( ( strpos($url, '?') !== false ) ?  ( ( $non_html_amp ) ? '&' : '&amp;' ) : '?' ) . $SID;
        }
#
#-----[ BEFORE, ADD ]--------------------------------------------
#
	//Start edits by remove_sid_for_guests.mod
	global $board_config, $HTTP_SERVER_VARS, $userdata;
	if ($board_config['session_strip_sid'] == SESSIONS_STRIP_SID_BOTS_ONLY)
	{
		//Let's use espicom's code then

		//You can add more bot agents here if you want
		//They should all be lowsercase, too!
		$agents = array('excite', 'googlebot', 'yahoo', 'msnbot');
		//$HTTP_SERVER_VARS or $_SERVER, that is the question
		$ref = strtolower($HTTP_SERVER_VARS['HTTP_USER_AGENT']);
		foreach ( $agents as $agent )
		{
			if ( strpos($ref, $agent) !== false )
			{
				//If it's just some guy using a
				//firefox extension to mimic a bot,
				//don't strip the SID. :P
				if ($userdata['user_id'] == ANONYMOUS)
				{
					return $url;
				}
			}//<- this } was missing before. Sorry!
		}
	}//If we're to remove for all guests
        else if ($board_config['session_strip_sid'] == SESSIONS_STRIP_SID_ALL_GUESTS)
        {
                //Meh, written by me, _underscore_, pretty simple
                if ($userdata['user_id'] == ANONYMOUS)
                {
                        //No SID for you!
                        return $url;
                }
        }
	//End edits by remove_sid_for_guests.mod
#
#-----[ OPEN ]--------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]--------------------------------------------
#
define('SESSION_METHOD_COOKIE', 100);
define('SESSION_METHOD_GET', 101);
#
#-----[ BEFORE, ADD ]--------------------------------------------
#
//Added by remove_sid_for_guests.mod
//Had to make up numbers.
//It goes in order with the above ones. ;)
define('SESSIONS_STRIP_SID_ALL_GUESTS', 102);
define('SESSIONS_STRIP_SID_BOTS_ONLY', 103);
define('SESSIONS_STRIP_SID_NONE', 104);
//End additions.
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
