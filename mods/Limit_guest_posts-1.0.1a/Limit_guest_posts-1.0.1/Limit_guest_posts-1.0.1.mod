##############################################################
## MOD Title: Limit guest posting
## MOD Author: clawed < N/A > (N/A) N/A
## MOD Description: Limits amount of posts guests may make before they must create an account
## MOD Version: 1.0.1
##
## Installation Level: (Easy)
## Installation Time: 10 Minutes
## Files To Edit: templates/subSilver/admin/board_config_body.tpl
##                admin/admin_board.php
##                language/lang_english/lang_main.php
##                posting.php
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
## Once installed, the posting limits for guest posters can be set using the
## admin control panel
##############################################################
## MOD History:
##
##	 2006-11-19
##		- Minor fixes for ModDB approval
##   2006-11-3 - Version 1.0.0
##      - Config for admin control panel added
##      - Limit for guest posts per topic added
##      - phpBB style for all the code
##   2006-10-23 - Version 0.5.1
##      - Bugfix
##   2006-10-23 - Version 0.5.0
##      - First release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#

INSERT INTO phpbb_config ( config_name, config_value ) VALUES ('guest_ip_limit', '2');
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ('guest_topic_limit', '2');

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr>
		<td class="row1">{L_ENABLE_PRUNE}</td>
		<td class="row2"><input type="radio" name="prune_enable" value="1" {PRUNE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="prune_enable" value="0" {PRUNE_NO} /> {L_NO}</td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	<tr>
		<td class="row1">{L_GUEST_IP_LIMIT}<br /><span class="gensmall">{L_GUEST_IP_LIMIT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="max_sentbox_privmsgs" value="{GUEST_IP_LIMIT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_GUEST_TOPIC_LIMIT}<br /><span class="gensmall">{L_GUEST_TOPIC_LIMIT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="4" name="max_sentbox_privmsgs" value="{GUEST_TOPIC_LIMIT}" /></td>
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#
	"L_SMTP_PASSWORD_EXPLAIN" => $lang['SMTP_password_explain'], 
#
#-----[ AFTER, ADD ]------------------------------------------
#
	"L_GUEST_IP_LIMIT" => $lang['Guest_IP_limit'], 
	"L_GUEST_IP_LIMIT_EXPLAIN" => $lang['Guest_IP_limit_explain'], 
	"L_GUEST_TOPIC_LIMIT" => $lang['Guest_topic_limit'], 
	"L_GUEST_TOPIC_LIMIT_EXPLAIN" => $lang['Guest_topic_limit_explain'], 
#
#-----[ FIND ]------------------------------------------
#
	"SMTP_PASSWORD" => $new['smtp_password'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	"GUEST_IP_LIMIT" => $new['guest_ip_limit'],
	"GUEST_TOPIC_LIMIT" => $new['guest_topic_limit'],

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

// Limit guest posts
$lang['Guest_IP_limit'] = 'Limit number of guest posts by IP address';
$lang['Guest_IP_limit_explain'] = 'The maximum number of posts per IP address before the user can no longer post as guest.';
$lang['Guest_topic_limit'] = 'Limit number of guest posts on a topic';
$lang['Guest_topic_limit_explain'] = 'The maximum amount of guest posts allowed on any single topic';


#
#-----[ OPEN ]------------------------------------------
#
posting.php

#
#-----[ FIND ]------------------------------------------
#
//
// The user is not authed, if they're not logged in then redirect
// them, else show them an error message
//
if ( !$is_auth[$is_auth_type] )

#
#-----[ REPLACE WITH ]------------------------------------------
#
/*******************
** MOD: Limit Guest Posts
*******************/
$allow_guest_to_post = true;
if( !$userdata['session_logged_in'] )
{
	//Find the number of posts made by this users IP address
	$sql = "SELECT COUNT(*) FROM " . POSTS_TABLE . " WHERE poster_ip = '" . $user_ip . "'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Failed to find guest count for IP Address ", "", __LINE__, __FILE__, $sql);
	} 
	else 
	{
		if ( $row = $db->sql_fetchrow($result) )
		{
			if ($row["COUNT(*)"] >= $board_config['guest_ip_limit'])
			{
				$allow_guest_to_post = false;
			}
		}
	}
	$db->sql_freeresult($result);

	if($mode != 'newtopic')
	{
		//Find number of posts by guest for the topic
		$sql = "SELECT COUNT(*) FROM " . POSTS_TABLE . " WHERE topic_id = " . $topic_id . " AND poster_id = " . ANONYMOUS;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Failed to find guest count for topic ", "", __LINE__, __FILE__, $sql);
		} 
		else 
		{
			if ( $row = $db->sql_fetchrow($result) )
			{
				if ($row["COUNT(*)"] >= $board_config['guest_topic_limit'])
				{
					$allow_guest_to_post = false;
				}
			}
		}
		$db->sql_freeresult($result);
	}
}


//
// The user is not authed, if they're not logged in then redirect
// them, else show them an error message
//
if ( !$is_auth[$is_auth_type] || $allow_guest_to_post == false)

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
