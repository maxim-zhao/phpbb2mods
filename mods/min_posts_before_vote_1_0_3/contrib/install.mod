##############################################################
## MOD Title: Minimum posts before voting
## MOD Author: eviL3 < evil@phpbbmodders.net > (Igor Wiedler) http://phpbbmodders.net
## MOD Description: Users need to have enough posts before they can
##                  Vote in a poll. This is useful if you don't want
##                  people registering accounts just for this.
##
## MOD Version: 1.0.3
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: posting.php,
##                admin/admin_board.php,
##                language/lang_english/lang_admin.php,
##                language/lang_english/lang_main.php,
##                templates/subSilver/admin/board_config_body.tpl
##
## Included Files: n/a
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
## This MOD was requested by kber at phpBBModders.net
##
## It will allow the admin to specify a minimal post count
## before users may vote in forums. This is to stop accounts
## being registered just for this purpose.
##
##############################################################
## MOD History:
##
##   2006-07-23 - Version 0.1.0
##      - First Release
##
##   2006-07-24 - Version 0.1.1
##      - Actually works now
##      - Updated $lang usage
##
##   2006-07-24 - Version 0.1.2
##      - Fixed the lang entry in the wrong file (thanks kber)
##
##   2006-09-06 - Version 0.1.3
##      - Fixed SQL not being inserted
##
##   2006-09-08 - Version 0.1.3a
##      - Viewtopic code removed and submitted
##
##   2006-09-08 - Version 1.0.0
##      - Stop the version chaos!
##
##   2006-11-10 - Version 1.0.1
##      - Cleaned up a little and commented some more
##      - Fixed an other little suggestion of the MOD team
##
##   2006-11-10 - Version 1.0.2
##      - Fixed a little bug (logics, logics...)
##
##   2006-12-27 - Version 1.0.3
##      - Removed backticks from SQL
##      - Changed the first FIND action
##      - Reduced value of the <input>'s maxlength attribute
##      - All changes suggested by the MOD team, thanks
##      - How about MODx?
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]-------------------------------------------
#

INSERT INTO phpbb_config ( config_name , config_value ) VALUES ('vote_min_posts', '10');

#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
	//
	// Vote in a poll
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//-- mod : Minimum posts before Vote ------------------------------------------------------------
//-- add
// Check if user has enough posts
	$vote_posts = $board_config['vote_min_posts'];
	if ( $userdata['user_posts'] < $vote_posts && $userdata['user_level'] == USER )
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['Vote_min_posts_needed'], $vote_posts));
	}
//-- fin mod : Minimum posts before Vote --------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#
	"L_SYSTEM_TIMEZONE" => $lang['System_timezone'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Minimum posts before Vote ------------------------------------------------------------
//-- add
	'L_VOTE_MIN_POSTS' => $lang['Vote_min_posts'],
//-- fin mod : Minimum posts before Vote --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
	"TIMEZONE_SELECT" => $timezone_select,
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Minimum posts before Vote ------------------------------------------------------------
//-- add
	'VOTE_MIN_POSTS' => $new['vote_min_posts'],
//-- fin mod : Minimum posts before Vote --------------------------------------------------------
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#

//-- mod : Minimum posts before Vote ------------------------------------------------------------
//-- add
$lang['Vote_min_posts'] = 'Minimum posts to Vote';
//-- fin mod : Minimum posts before Vote --------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#

//-- mod : Minimum posts before Vote ------------------------------------------------------------
//-- add
$lang['Vote_min_posts_needed'] = 'You need %s posts to vote.';
//-- fin mod : Minimum posts before Vote --------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr>
		<td class="row1">{L_SYSTEM_TIMEZONE}</td>
		<td class="row2">{TIMEZONE_SELECT}</td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- mod : Minimum posts before Vote -->
	<tr>
		<td class="row1">{L_VOTE_MIN_POSTS}</td>
		<td class="row2"><input class="post" type="text" maxlength="10" size="3" name="vote_min_posts" value="{VOTE_MIN_POSTS}" /></td>
	</tr>
<!-- fin mod : Minimum posts before Vote -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
