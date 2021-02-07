############################################################## 
## MOD Title: Topic Permissions
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: Gives the admin the ability to lock his editing from the moderators. Gives the ability to 
##		protect topics with a password and enables you to ban a user from a particular topic.
## MOD Version: 1.3.5
## 
## Installation Level: Intermediate
## Installation Time: ~40 Minutes
## Files To Edit: modcp.php
##		  viewtopic.php
##		  posting.php
##		  viewforum.php
##		  includes/functions_post.php
##		  includes/sessions.php
##		  includes/constants.php
##		  includes/functions.php
##		  admin/admin_users.php
##		  admin/admin_forumauth.php
##		  admin/admin_ug_auth.php
##		  templates/subSilver/viewforum_body.tpl
##		  templates/subSilver/viewtopic_body.tpl
##		  templates/subSilver/admin/user_edit_body.tpl
##		  templates/subSilver/posting_body.tpl
##		  templates/subSilver/modcp_body.tpl
##		  templates/subSilver/subSilver.cfg
##		  language/lang_english/lang_main.php 
##		  language/lang_english/lang_admin.php 
## Included Files: admin/admin_topic.php
##		   admin/admin_topic_ban.php
##		   templates/subSilver/topic_login.tpl
##		   templates/subSilver/modcp_tban_body.tpl
##		   templates/subSilver/admin/topic_perm_body.tpl
##		   templates/subSilver/admin/topic_ban_body.tpl
##		   templates/subSilver/modcp_tban_body.tpl
##		   templates/subSilver/images/icon_topicban.gif
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
## the "topic ban user button" was made by the lovely Adrienne
##
## Note that this is NOT compatible with the categories hierarchy mod
##
############################################################## 
## MOD History: 
## 
##   2005-03-02 - Version 0.0.0 
##      - start of mod production 
## 
##   2005-03-02 - Version 0.1.0 
##      - admin gets to disallow certain topics from being changed when he changes them in the modcp
##	  mods can still change via the menu in the topic
## 
##   2005-03-02 - Version 0.2.0 
##      - mods no longer get the topic editing links in the topic if it's locked
##	- security issue if someone knows the direct urls
## 
##   2005-03-02 - Version 0.3.0 
##      - admin can lock topic editing when editing first post or creating new topic
## 
##   2005-03-02 - Version 0.3.1 
##      - topic edit lock checkbox not showing when it should
## 
##   2005-03-02 - Version 0.4.0 
##      - individual posts can be edit locked
## 
##   2005-03-02 - Version 0.5.0 
##      - mods can edit lock
## 
##   2005-03-02 - Version 0.6.0 
##      - threads can be passworded, fixed a bug
## 
##   2005-03-03 - Version 0.6.1
##      - fixed up the mod syntax
## 
##   2005-03-03 - Version 0.6.5
##      - topic logs don't need refreshing untill you leave the board
## 
##   2005-03-03 - Version 0.6.6this is starting to get irritating, but it's good that mods find these errors :)
##      - fixed a bug
## 
##   2005-03-03 - Version 0.7.0
##      - mod now configurable through the acp
## 
##   2005-03-03 - Version 0.7.1
##      - fixed a security issue
## 
##   2005-03-03 - Version 0.7.2
##      - fixed a bug
## 
##   2005-03-03 - Version 0.7.3
##      - fixed a possible security issue
## 
##   2005-03-03 - Version 0.8.0
##      - able to disable a user from logging in to topics or make passwords
## 
##   2005-03-04 - Version 0.9.0
##      - topic banning now available
## 
##   2005-03-04 - Version 0.9.2
##      - fixed a bug with the topic ban button and banning not happening if there was a ' in the description
## 
##   2005-03-05 - Version 0.10.0
##	- admin can turn off ban descriptions or the information about who banned you
## 
##   2005-03-05 - Version 0.11.0
##	- particular users can be prevented from topic banning
## 
##   2005-03-05 - Version 0.11.1
##	- fixed DBAL compatibility issue
## 
##   2005-03-05 - Version 0.11.2
##	- multiline topic ban descriptions now show like they should
## 
##   2005-03-05 - Version 0.12.0
##	- acp administration of topic bans
## 
##   2005-03-05 - Version 0.12.1
##	- some mod syntax fixed
## 
##   2005-03-05 - Version 0.13.0
##	- guests can be prevented from participating in specific topics
## 
##   2005-03-05 - Version 0.13.1
##	- small cosmetic fix
## 
##   2005-03-06 - Version 0.14.0
##	- topic banning, passwording and no-guesting obbeys forum permissions
## 
##   2005-03-06 - Version 0.15.0
##	- topic banning, passwording and no-guesting obbeys group permissions
## 
##   2005-03-06 - Version 0.15.1
##	- small typo fix
## 
##   2005-03-06 - Version 0.16.0
##	- rules for passwording etc. show with the other rules (bottom right)
## 
##   2005-03-06 - Version 0.16.1
##	- "replace with" fix in .mod file
## 
##   2005-03-10 - Version 1.0.0
##	- fixed some bugs in the .mod file and submitted
## 
##   2005-03-17 - Version 1.0.1
##	- fixed submission problems
## 
##   2005-03-30 - Version 1.0.3
##	- fixed submission problems ( nothing really big )
## 
##   2005-04-13 - Version 1.0.5
##	- 1000000 bugs in the code, 1000000 bugs, fix one, 1000001 bugs in the code...
## 
##   2005-04-19 - Version 1.0.7
##	- submission problems, STILL, damn making big mods when you're not really used to it yet
##	- fixed a bug with deleting topic bans, it happened wrongly
## 
##   2005-04-26 - Version 1.0.8
##	- this is starting to get irritating, but it's good that mods find these errors :)
## 
##   2005-05-15 - Version 1.0.9
##	- fixed some bugs
##	- made it more compatible with other mods
## 
##   2005-05-18 - Version 1.0.10
##	- fixed some bugs
## 
##   2005-05-22 - Version 1.0.11
##	- missing semicoln :)
## 
##   2005-05-29 - Version 1.1.0
##	- by recomendation of the mods added two small yet useful features
## 
##   2005-11-05 - Version 1.1.2
##	- updated for 2.0.18
## 
##   2005-11-11 - Version 1.1.3
##	- fixed the license and security warning, stupidly forgot before :)
##	- fixed missing spaces in mod actions
## 
##   2005-12-02 - Version 1.1.4
##	- fixed A LOT of stuff that did not go with coding standards (these weren't as strickt back when this mod was first made)
##	- SQL queries were not compatible with EM... oops :)
## 
##   2005-12-03 - Version 1.2.0
##	- added redirect to login on "Guests are not allowed in this topic"
##	- bots may be let through guest restrictions
##	- decided to make a v2.0.0 of this MOD asap because this code is seriously below my standards
## 
##   2005-12-03 - Version 1.3.0
##	- stupidly left a damn parsing error in there somewhere
##	- global guest disallowing added
## 
##   2005-12-03 - Version 1.3.0
##	- fixed some minor typos :)
## 
##   2005-01-07 - Version 1.3.2
##	- array error thingy
##	- coding standards, coz I'd just be told to fix it 'till I would...
## 
##   2005-01-08 - Version 1.3.3
##	- a typo and an oversight
## 
##   2005-02-15 - Version 1.3.4
##	- lang entry for forumauth missing
##
##   2005-04-17 - Version 1.3.5
##	- finally got around to fixing the bug with all guest topics being passworded (or rather just the notice being shown)
##	- and made the install smoother with other mods
##	- in code comments made better
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 

ALTER TABLE `phpbb_topics` ADD `topic_adminedit` TINYINT DEFAULT '0' NOT NULL;
ALTER TABLE `phpbb_posts` ADD `post_adminedit` TINYINT DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_posts` ADD `post_modedit` TINYINT DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_topics` ADD `topic_password` VARCHAR( 32 ) NOT NULL ;
ALTER TABLE `phpbb_topics` ADD `topic_pass_level` TINYINT NOT NULL ;
ALTER TABLE `phpbb_sessions` ADD `session_logged_topics` TEXT NOT NULL ;
ALTER TABLE `phpbb_users` ADD `user_allow_pass` TINYINT DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_users` ADD `user_allow_tlogin` TINYINT DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_users` ADD `user_allow_tban` TINYINT DEFAULT '1' NOT NULL ;
ALTER TABLE `phpbb_topics` ADD `topic_noguest` TINYINT DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_topics` ADD `topic_noguest_level` TINYINT NOT NULL ;
ALTER TABLE `phpbb_forums` ADD `auth_tpass` TINYINT( 2 ) NOT NULL ;
ALTER TABLE `phpbb_forums` ADD `auth_tban` TINYINT( 2 ) NOT NULL ;
ALTER TABLE `phpbb_forums` ADD `auth_tnoguest` TINYINT( 2 ) NOT NULL ;
ALTER TABLE `phpbb_auth_access` ADD `auth_tpass` TINYINT( 2 ) NOT NULL ;
ALTER TABLE `phpbb_auth_access` ADD `auth_tban` TINYINT( 2 ) NOT NULL ;
ALTER TABLE `phpbb_auth_access` ADD `auth_tnoguest` TINYINT( 2 ) NOT NULL;
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'allow_modlock', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'enable_topicpass', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'allow_guestpass', '0' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'allow_guesttlogin', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'enable_topicban', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'allow_topicban_mod', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'allow_topicban_starter', '0' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'guest_seepass', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'banned_seetopic', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'show_tban_who', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'show_tban_why', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'allow_tnologguest', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'allow_tnologguest_mod', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'allow_tnologguest_starter', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'redirectnoguest', '0' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'botnotguest', '1' );
INSERT INTO phpbb_config ( config_name, config_value) VALUES ( 'globalnoguestt', '0' );
CREATE TABLE `phpbb_topic_bans` (
`id` INT NOT NULL AUTO_INCREMENT ,
`topic_id` INT NOT NULL ,
`baner_id` INT NOT NULL ,
`user_id` INT NOT NULL ,
`ban_desc` TEXT NOT NULL ,
KEY ( `id` ) 
);

# 
#-----[ COPY ]------------------------------------------ 
# 

copy admin/admin_topic.php to admin/admin_topic.php
copy admin/admin_topic_ban.php to admin/admin_topic_ban.php
copy templates/subSilver/topic_login.tpl to templates/subSilver/topic_login.tpl
copy templates/subSilver/admin/topic_perm_body.tpl to templates/subSilver/admin/topic_perm_body.tpl
copy templates/subSilver/admin/topic_ban_body.tpl to templates/subSilver/admin/topic_ban_body.tpl
copy templates/subSilver/modcp_tban_body.tpl to templates/subSilver/modcp_tban_body.tpl
copy templates/subSilver/images/icon_topicban.gif to templates/subSilver/images/icon_topicban.gif

# 
#-----[ OPEN ]------------------------------------------ 
# 

modcp.php

# 
#-----[ FIND ]------------------------------------------ 
# 

message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
if ( $mode == 'tban' && !check_can_tban ( $topic_id ) ) 
{

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

}

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// Do major work ...
//

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
if ( $userdata['user_level'] == ADMIN ) 
{
	$template -> assign_block_vars ( 'switch_admin', array ( ) );
	$template -> assign_vars ( array (
		'L_MAKE_ADMIN' => $lang['admin_edit']
	) );
	$make_admin = ( !empty ( $HTTP_POST_VARS['make_admin'] ) ) ? 1 : 0;
	$hidden_fields = '<input type="hidden" name="make_admin" value="' . $make_admin . '" />';
}
else
{
	$hidden_fields = '';
	$make_admin = 0;
}
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

case 'delete':

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

	// mod topic permissions mod add
	case 'tban':
		if ( !check_can_tban ( $topic_id ) ) 
		{
			message_die ( GENERAL_MESSAGE, $lang['cant_tban'] );
		}
		
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);
		
		if ( $confirm ) 
		{
			$uid = $userdata['user_id'];
			$bid = intval ( $HTTP_POST_VARS['user'] );
			$desc = ( !empty ( $HTTP_POST_VARS['tban_desc'] ) ) ? htmlspecialchars ( trim ( $HTTP_POST_VARS['tban_desc'] ) ) : '';
			$desc = str_replace("\'", "''", $desc );
			
			if ( $bid == ANONYMOUS ) 
			{
				message_die ( GENERAL_MESSAGE, $lang['cant_tban_guests'] );
			}
			$sql = "INSERT INTO " . TOPIC_BANS_TABLE . " ( topic_id, baner_id, user_id, ban_desc ) VALUES ( '$topic_id', '$uid', '$bid', '$desc' )";
			if ( !$result = $db -> sql_query ( $sql ) ) 
			{
				message_die(GENERAL_ERROR, 'Could not topic ban the user', '', __LINE__, __FILE__, $sql);
			}
			else
			{
				$redirect_page = append_sid("viewtopic.$phpEx?".POST_TOPIC_URL."=$topic_id");
				$message = $lang['user_tbanned'] . '<br />' . sprintf ( $lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>' );
				message_die ( GENERAL_MESSAGE, $message );
			}
		}
		else
		{
			$bid = intval ( $HTTP_GET_VARS[POST_USERS_URL] );
			if ( empty ( $bid ) ) 
			{
				message_die ( GENERAL_MESSAGE, $lang['cant_tban_nouser'] );
			}
			$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" /><input type="hidden" name="user" value="' . $bid . '" />';
			
			$template -> set_filenames ( array (
				'tban' => 'modcp_tban_body.tpl')
			);

			$template -> assign_vars ( array (
				'MESSAGE_TITLE' => $lang['Confirm'],
				'MESSAGE_TEXT' => $lang['confirm_topic_ban'],

				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'L_DESCRIPTION' => $lang['tban_why'],

				'S_MODCP_ACTION' => append_sid("modcp.$phpEx"),
				'S_HIDDEN_FIELDS' => $hidden_fields)
			);

			$template -> pparse ( 'tban' );

			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
	// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT topic_id
	
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod change sql query

# 
#-----[ FIND ]------------------------------------------ 
# 

AND forum_id = $forum_id"

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
" . (( $userdata['user_level'] == ADMIN ) ?  " AND topic_adminedit = '0' " : " ") . "

# 
#-----[ FIND ]------------------------------------------ 
# 

$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod change

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# // this is the first '=' in the line and EM seems to find it just right, but alas, I'll do what I'm asked :)

= '<

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

.

# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_id = $row[$i]['topic_id'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
if ( $row[$i]['topic_adminedit'] && $userdata['user_level']!= ADMIN )
	continue;
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "INSERT INTO " . TOPICS_TABLE . " 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add to sql query

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

topic_status, 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

topic_adminedit,

# 
#-----[ FIND ]------------------------------------------ 
# 

" . TOPIC_MOVED . ",

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

",

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

$make_admin, 

# 
#-----[ FIND ]------------------------------------------ 
# 

SET forum_id = $new_forum_id

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$new_forum_id

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, topic_adminedit = $make_admin

# 
#-----[ FIND ]------------------------------------------ 
# 

$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod change

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

=

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

.

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "UPDATE " . TOPICS_TABLE . " 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod sql query change

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

"UPDATE " . TOPICS_TABLE . " 

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

( $userdata['user_level'] == ADMIN ) ? 

# 
#-----[ FIND ]------------------------------------------ 
# 

AND topic_moved_id = 0";

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

";

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

"

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	: "UPDATE " . TOPICS_TABLE . " 
	SET topic_status = " . TOPIC_LOCKED . " 
	WHERE topic_id IN ($topic_id_sql) 
		AND topic_adminedit = '0'
		AND forum_id = $forum_id
		AND topic_moved_id = 0";	

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "UPDATE " . TOPICS_TABLE . " 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod sql query change

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

"UPDATE " . TOPICS_TABLE . " 

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

( $userdata['user_level'] == ADMIN ) ? 

# 
#-----[ FIND ]------------------------------------------ 
# 

AND topic_moved_id = 0";

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

";

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

"

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	: "UPDATE " . TOPICS_TABLE . " 
	SET topic_status = " . TOPIC_LOCKED . " 
	WHERE topic_id IN ($topic_id_sql) 
		AND topic_adminedit = '0'
		AND forum_id = $forum_id
		AND topic_moved_id = 0";	

# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_status = $row['topic_status'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$topic_admin = ( $row['topic_adminedit'] ) ? $lang['admin_only_edit']: '';
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_ID' => $topic_id,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
'L_ADMIN_ONLY' => $topic_admin,

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT t.topic_id, t.topic_title,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add to sql query

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

t.topic_status,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

t.topic_noguest, t.topic_adminedit, t.topic_password, t.topic_pass_level, 

# 
#-----[ FIND ]------------------------------------------ 
# 

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
if ( ( ( $board_config['allow_tnologguest'] && $forum_topic_data['topic_noguest'] ) || $board_config['globalnoguestt'] ) && $userdata['user_id'] == ANONYMOUS ) 
{
	// if this is a bot we let it through... people wanted this *shrugs*
	if ( !user_is_bot( ) )
	{
		if ( $board_config['redirectnoguest'] )
		{
			redirect("login.$phpEx");
		}
		else
		{
			message_die ( GENERAL_MESSAGE, $lang['topic_noguest'] );
		}
	}
}
check_topicban ( $topic_id, TRUE );

$password = $forum_topic_data['topic_password'];
$pass_lvl = $forum_topic_data['topic_pass_level'];
$topic_logged = ( is_array( $userdata['log_topics'] ) ) ? array_search ( $forum_topic_data['topic_id'], $userdata['log_topics'] ) : FALSE;
$mod = FALSE;
if ( $pass_lvl == $userdata['user_level'] ) 
{
	$mod = FALSE;
}
elseif ( $pass_lvl == USER && $userdata['user_level'] > USER )
{
	$mod = TRUE;
}
if ( $userdata['user_level'] == ADMIN || !$board_config['enable_topicpass'] || ( $postrow[0]['user_id'] == ANONYMOUS && !$board_config['allow_guestpass'] ) ) 
{
	$mod = TRUE;
}

if ( $topic_logged === FALSE && $password != '' && !$mod ) 
{
	if ( !$board_config['allow_guesttlogin'] && $userdata['user_id'] == ANONYMOUS )
	{
		if ( $board_config['redirectnoguest'] )
		{
			redirect("login.$phpEx");
		}
		else
		{
			message_die ( GENERAL_MESSAGE, $lang['guest_nologin'] );
		}
	}
	elseif ( !$userdata['user_allow_tlogin'] ) 
	{
		message_die ( GENERAL_MESSAGE, $lang['user_nologin'] );
	}
	elseif ( !isset($HTTP_POST_VARS['topic_login'] )) 
	{
		$template -> assign_vars ( array (
			'L_LOGIN' => $lang['Login'],
			'L_PASSWORD' => $lang['Password'],
	
			'MESSAGE_TITLE' => $lang['Login'],
			'MESSAGE_TEXT' => $lang['topic_login'],

			'S_LOGIN_ACTION' => append_sid ( "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id" )
		) );

		$template -> set_filenames ( array (
			'login' => 'topic_login.tpl'
		) );
	
		$template->pparse('login');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	
		break;
	}
	else
	{
		$pass = md5 ( $HTTP_POST_VARS['topic_pass'] );
		if ( $pass == $password ) 
		{
			$log_topics = $userdata['log_topics'];
			$log_topics[count ( $log_topics ) + 1] = $topic_id;
			//add this to session table
			$sid = $userdata['session_id'];
			$log_topics = implode ( ',', $log_topics );
			$sql = "UPDATE " . SESSIONS_TABLE . " SET " .
				"session_logged_topics='$log_topics' " .
				"WHERE session_id='$sid' LIMIT 1";
			$db -> sql_query ( $sql );
		}
		else
		{
			message_die ( GENERAL_ERROR, $lang['wrong_tpass'] );
		}
	}
}
elseif ( $topic_logged === FALSE && ( $mod || $password == '' ) )
{
	$log_topics = $userdata['log_topics'];
	$log_topics[count ( $log_topics ) + 1] = $topic_id;
	//add this to session table
	$sid = $userdata['session_id'];
	$log_topics = implode ( ',', $log_topics );
	$sql = "UPDATE " . SESSIONS_TABLE . " SET " .
		"session_logged_topics='$log_topics' " .
		"WHERE session_id='$sid' LIMIT 1";
	$db -> sql_query ( $sql );
}
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$pass = ( check_tauth ( $forum_row['auth_tpass'], 'auth_tpass', $forum_id ) && $userdata['user_allow_pass'] ) ? $lang['Rules_tpass_can']: $lang['Rules_tpass_cannot'];
$ban = ( check_tauth ( $forum_row['auth_tban'], 'auth_tban', $forum_id ) && $userdata['user_allow_tban'] ) ? $lang['Rules_tban_can']: $lang['Rules_tban_cannot'];
$noguest = ( check_tauth ( $forum_row['auth_tnoguest'], 'auth_tnoguest', $forum_id ) ) ? $lang['Rules_tnoguest_can']: $lang['Rules_tnoguest_cannot'];
$log = ( $userdata['user_allow_tlogin'] || ( $board_config['allow_guestlogin'] && $userdata['user_id'] == ANONYMOUS ) ) ? $lang['Rules_tlog_can']: $lang['Rules_tlog_cannot'];
$s_auth_can .= ( $board_config['enable_topicpass'] ) ? $pass . '<br />' : '';
$s_auth_can .= ( $board_config['enable_topicpass'] ) ? $log . '<br />' : '';
$s_auth_can .= ( $board_config['enable_topicban'] ) ? $ban . '<br />' : '';
$s_auth_can .= ( $board_config['allow_tnologguest'] ) ? $noguest . '<br />' : '';
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $is_auth['auth_mod'] )

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod change arguments

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

 )

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 
&& ( !$forum_topic_data['topic_adminedit'] || $userdata['user_level'] == ADMIN )

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $is_auth['auth_mod'] )
	{
		$temp_url = "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;" . POST_TOPIC_URL .

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
if ( check_can_tban ( $topic_id ) ) 
{
	$url = "modcp.$phpEx?mode=tban&amp;" . POST_USERS_URL . "=" . $postrow[$i]['poster_id'] . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'];
	$tban_img = '<a href="' . $url . '"><img src="' . $images['icon_topicban'] . '" alt="' . $lang['topic_ban'] . '" title="' . $lang['topic_ban'] . '" border="0" /></a>';
	$tban = $lang['topic_ban'];
}
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'DELETE' => $delpost,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
'TBAN_IMG' => $tban_img,
'TBAN' => $tban,
// mod topic permissions mod end

# 
#-----[ OPEN ]------------------------------------------ 
# 

posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$select_sql = (!$submit) ? ',

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod: add

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

t.topic_title, 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

t.topic_noguest, t.topic_noguest_level, t.topic_adminedit, t.topic_password, t.topic_pass_level, 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

p.enable_bbcode,

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

p.post_adminedit, p.post_modedit, 

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $result = $db->sql_query($sql) )

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
check_topicban ( $topic_id, TRUE );

if ( is_array( $userdata['log_topics'] ) )
{
	if ( array_search ( $topic_id, $userdata['log_topics'] ) === FALSE ) 
	{
		message_die ( GENERAL_ERROR, $lang['not_topiclogged'] );
	}
}
else
{
	message_die ( GENERAL_ERROR, $lang['not_topiclogged'] );
}
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

$post_data['poster_post'] = ( $post_info['poster_id'] == $userdata['user_id'] ) ? true : false;

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
if ( ( $post_info['post_adminedit'] && $userdata['user_level']!= ADMIN ) || ( $post_info['post_modedit'] && $userdata['user_level'] < ADMIN ) )
	message_die ( GENERAL_MESSAGE, $lang['post_admin_edit'] ); 

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $post_data['first_post'] && $post_data['has_poll'] )

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$adminedit[1] = $post_info['topic_adminedit'];
$adminedit[2] = $post_info['post_adminedit'];
$adminedit[3] = $post_info['post_modedit'];
$password[1] = $post_info['topic_password'];
$password[2] = $post_info['topic_pass_level'];
$noguest[1] = $post_info['topic_noguest'];
$noguest[2] = $post_info['topic_noguest_level'];
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( !$board_config['allow_html'] )

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$can_admin = FALSE;
$can_mod = FALSE;
$can_pass = FALSE;
$can_noguest = FALSE;
if ( $userdata['user_level'] == ADMIN ) 
{
	$l_adminedit[1] = $lang['edit_lock'];
	$l_adminedit[2] = $lang['edit_post_lock'];
	if ( $mode == 'newtopic' || ( $mode == 'editpost' && $post_data['first_post'] ) )
	{
		$template -> assign_block_vars ( 'switch_adminedit1', array ( ) );
	}
	if ( $mode == 'editpost' )
	{
		$template -> assign_block_vars ( 'switch_adminedit2', array ( ) );
	}
	$post_edit_lock = 'admin_post_edit';
	$s_edit_lock = ( $adminedit[2] ) ? 'checked="checked"' : '';
	$can_admin = TRUE;
}
if ( $userdata['user_level'] == MOD && $board_config['allow_modlock'] ) 
{
	$l_adminedit[2] = $lang['edit_post_lock'];
	if ( $mode == 'editpost' )
	{
		$template -> assign_block_vars ( 'switch_adminedit2', array ( ) );
	}
	$post_edit_lock = 'mod_post_edit';
	$s_edit_lock = ( $adminedit[3] ) ? 'checked="checked"' : '';
	$can_mod = TRUE;
}
if ( $board_config['enable_topicpass'] && ( $mode == 'newtopic' || ( $mode == 'editpost' && $post_data['first_post'] ) ) ) 
{
	$a = check_tauth ( $post_info['auth_tpass'], 'auth_tpass', $forum_id );
	if ( $a && ( ( $userdata['user_id'] == ANONYMOUS && $board_config['allow_guestpass'] ) || ( $userdata['user_allow_pass'] ) ) ) 
	{
		$lvl = $userdata['user_level'];
		$pass_lvl = $password[2];
		$p = TRUE;
		if ( $mode == 'editpost' ) 
		{
			if ( $pass_lvl == $lvl ) 
			{
				$p = TRUE;
			}
			elseif ( $pass_lvl == USER && ( $lvl == ADMIN || $lvl == MOD ) ) 
			{
				$p = TRUE;
			}
			elseif ( $pass_lvl == MOD && ( $lvl == ADMIN ) ) 
			{
				$p = TRUE;
			}
			else
			{
				$p = FALSE;
			}
		}
		if ( $p ) 
		{
			$template -> assign_block_vars ( 'switch_topic_pass', array ( ) );
		}
		$l_pass_desc = ( $mode == 'newtopic' || $password[1] == '' ) ? $lang['pass_desc_new']: $lang['pass_desc_change'];
		$can_pass = TRUE;
	}
}
if ( $board_config['allow_tnologguest'] && ( $mode == 'newtopic' || ( $mode == 'editpost' && $post_data['first_post'] ) ) ) 
{
	$a = check_tauth ( $post_info['auth_noguest'], 'auth_noguest', $forum_id );
	if ( $a ) 
	{
		$ng = FALSE;
		if ( ( $userdata['user_level'] == USER && $board_config['allow_tnologguest_starter'] ) && $noguest[2] == 0 ) 
		{
			$ng = TRUE;
		}
		if ( ( $userdata['user_level'] == MOD && $board_config['allow_tnologguest_mod'] ) && ( $noguest[2] == 0 || $noguest[2] == 2 ) ) 
		{
			$ng = TRUE;
		}
		if ( $userdata['user_level'] == ADMIN || $ng ) 
		{
			$template -> assign_block_vars ( 'switch_topic_noguest', array ( ) );
			$can_noguest = TRUE;
		}
	}
}
$adminedit[1] = ( $submit || $refresh && $can_admin ) ? ( ( !empty($HTTP_POST_VARS['admin_topic_edit'] ) ) ? TRUE : 0 ) : $adminedit[1];
$adminedit[2] = ( $submit || $refresh && $can_admin ) ? ( ( !empty($HTTP_POST_VARS['admin_post_edit'] ) ) ? TRUE : 0 ) : $adminedit[2];
$adminedit[3] = ( $submit || $refresh && $can_mod ) ? ( ( !empty($HTTP_POST_VARS['mod_post_edit'] ) ) ? TRUE : 0 ) : $adminedit[3];
$del_pass = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['del_pass'] ) ) ? TRUE : FALSE ) : FALSE;
if ( $HTTP_POST_VARS['topic_pass'] != $HTTP_POST_VARS['topic_passconf'] )
{
	message_die(GENERAL_MESSAGE, $lang['Password_mismatch']);	
}
$password[1] = ( $submit || $refresh && $can_pass ) ? ( ( !empty($HTTP_POST_VARS['topic_pass'] ) ) ? md5 ( $HTTP_POST_VARS['topic_pass'] ) : '' ) : $password[1];
$password[1] = ( $del_pass && $can_pass ) ? '' : $password[1];
$password[2] = ( $submit || $refresh && $can_pass ) ? $userdata['user_level']: $password[2];
$noguest[1] = ( $submit || $refresh && $can_noguest ) ? ( ( !empty ( $HTTP_POST_VARS['noguest'] ) ) ? TRUE : FALSE ) : FALSE;
$noguest[2] = ( $submit || $refresh && $can_noguest ) ? $userdata['user_level']: $noguest[2];
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

submit_post(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$bbcode_on,

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

$noguest, $adminedit, $password, 

# 
#-----[ FIND ]------------------------------------------ 
# 

$html_on = ( $post_info['enable_html'] ) ? true : false;

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$adminedit[1] = ( $post_info['topic_adminedit'] ) ? true : false;
$adminedit[2] = ( $post_info['post_adminedit'] ) ? true : false;
$adminedit[3] = ( $post_info['post_modedit'] ) ? true : false;
$noguest[1] = ( $post_info['topic_noguest'] ) ? true : false;
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_DELETE_POST' => $lang['Delete_post'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
'L_EDIT_TOPIC_LOCK' => $l_adminedit[1],
'L_EDIT_POST_LOCK' => $l_adminedit[2],
'L_PASSWORD' => $lang['Password'],
'L_PASSWORDCONF' => $lang['Confirm_password'],
'L_PASS_DESC' => $l_pass_desc,
'L_NOGUEST' => $lang['noguest'],
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'S_HTML_CHECKED' => ( !$html_on ) ? 'checked="checked"' : '', 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
'S_EDIT_TOPIC_LOCK' => ( $adminedit[1] ) ? 'checked="checked"' : '', 
'S_EDIT_POST_LOCK' => $s_edit_lock,
'S_POST_LOCK' => $post_edit_lock,
'DEL_PASS_BOX' => ( $password[1]!= '' ) ? '<input type="checkbox" name="del_pass" />&nbsp; ' . $lang['del_pass']: '',
// mod topic permissions mod end

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewforum.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$pass = ( check_tauth ( $forum_row['auth_tpass'], 'auth_tpass', $forum_id ) && $userdata['user_allow_pass'] ) ? $lang['Rules_tpass_can']: $lang['Rules_tpass_cannot'];
$ban = ( check_tauth ( $forum_row['auth_tban'], 'auth_tban', $forum_id ) && $userdata['user_allow_tban'] ) ? $lang['Rules_tban_can']: $lang['Rules_tban_cannot'];
$noguest = ( check_tauth ( $forum_row['auth_tnoguest'], 'auth_tnoguest', $forum_id ) ) ? $lang['Rules_tnoguest_can']: $lang['Rules_tnoguest_cannot'];
$log = ( $userdata['user_allow_tlogin'] || ( $board_config['allow_guestlogin'] && $userdata['user_id'] == ANONYMOUS ) ) ? $lang['Rules_tlog_can']: $lang['Rules_tlog_cannot'];
$s_auth_can .= ( $board_config['enable_topicpass'] ) ? $pass . '<br />' : '';
$s_auth_can .= ( $board_config['enable_topicpass'] ) ? $log . '<br />' : '';
$s_auth_can .= ( $board_config['enable_topicban'] ) ? $ban . '<br />' : '';
$s_auth_can .= ( $board_config['allow_tnologguest'] ) ? $noguest . '<br />' : '';
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_id = $topic_rowset[$i]['topic_id'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$tban = check_topicban ( $topic_id );
$tsee = TRUE;
$anon = ( $userdata['user_id'] == ANONYMOUS ) ? TRUE : FALSE;
$ispass = ( $board_config['enable_topicpass'] && !empty( $topic_rowset[$i]['topic_password'] ) ) ? TRUE : FALSE;
$ispass = ( $topic_rowset[$i]['topic_poster'] == ANONYMOUS && !$board_config['allow_guestpass'] ) ? FALSE : $ispass;
if ( $ispass && ( $anon && !$board_config['guest_seepass'] ) ) 
{
	$tsee = FALSE;
}
if ( $tban && !$board_config['banned_seetopic'] ) 
{
	$tsee = FALSE;
}
if ( !$tsee ) 
{
	continue;
}
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_TITLE' => $topic_title,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod
'PASSWORDED' => ( $ispass ) ? '<br />' . $lang['passworded'] : '',

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions_post.php

# 
#-----[ FIND ]------------------------------------------ 
# 

submit_post(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

&$bbcode_on,

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

&$noguest, &$adminedit, &$password, 

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql  = ($mode != "editpost") ? "INSERT INTO " . TOPICS_TABLE . " (

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

//mod topic permissions mod add
$lockedit = $adminedit[1];
$pass = $password[1];
$pass_lvl = $password[2];
$noguest_lvl = $noguest[2];
$noguest = $noguest[1];
// mod topic permissions mod: add to sql query

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

topic_title, 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

topic_noguest, topic_noguest_level, topic_password, topic_pass_level, 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

topic_status, 

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

topic_adminedit, 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

'$post_subject',

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

'$noguest', '$noguest_lvl', '$pass', '$pass_lvl', 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

" . TOPIC_UNLOCKED . ",

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

$lockedit, 

#
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

topic_title = '$post_subject',

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

topic_noguest = '$noguest', topic_noguest_level = '$noguest_lvl', topic_password='$pass', topic_pass_level='$pass_lvl',

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

topic_type = $topic_type " .

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

topic_adminedit = '$lockedit', 

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = ($mode != "editpost") ? "INSERT INTO " . POSTS_TABLE . " (

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$adminlock = $adminedit[2];
$modlock = $adminedit[3];
// mod topic permissions mod: add to sql query

#
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

enable_bbcode,

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

post_adminedit, post_modedit, 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$bbcode_on,

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

$adminlock, $modlock, 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

enable_bbcode = $bbcode_on,

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

post_adminedit = '$adminlock', post_modedit = '$modlock', 

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/sessions.php

# 
#-----[ FIND ]------------------------------------------ 
# 

function session_pagestart($user_ip, $thispage_id)

# 
#-----[ FIND ]------------------------------------------ 
# 

return $userdata;

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$userdata['log_topics'] = explode ( ',', $userdata['session_logged_topics'] );
unset ( $userdata['session_logged_topics'] );

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/constants.php

# 
#-----[ FIND ]------------------------------------------ 
# 

define('VOTE_USERS_TABLE', $table_prefix.'vote_voters');

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
define('TOPIC_BANS_TABLE', $table_prefix.'topic_bans');

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions.php

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
function check_topicban ( &$topic_id, $error = FALSE ) 
{
	global $board_config, $lang, $userdata, $db, $phpEx;

	$tbans = FALSE;
	if ( $board_config['enable_topicban'] ) $tbans = TRUE;
	if ( $userdata['user_id'] == ADMIN ) $tbans = FALSE;
	if ( $tbans ) 
	{
		$uid = $userdata['user_id'];
		$sql = "SELECT b.topic_id, b.baner_id, b.user_id, b.ban_desc, u.username, u.user_allow_tban " .
			"FROM " . TOPIC_BANS_TABLE . " b LEFT JOIN " . USERS_TABLE . " u ON b.baner_id = u.user_id " .
			"WHERE b.topic_id = '$topic_id' " .
				"AND b.user_id = '$uid' " .
			"LIMIT 1";
		if ( !$result = $db -> sql_query ( $sql ) ) 
		{
			message_die(GENERAL_ERROR, "Could not obtain ban data for this topic", '', __LINE__, __FILE__, $sql);
		}
		elseif ( $db -> sql_numrows ( $result ) > 0 ) 
		{
			if ( !$error ) return TRUE;
			$ban_data  = $db -> sql_fetchrow ( $result );
			if ( !$ban_data['user_allow_tban'] ) 
			{
				return FALSE;
			}
			elseif ( !$error ) 
			{
				return TRUE;
			}
			$message = $lang['topic_banned'];
			$pm = append_sid ( "privmsg.$phpEx?mode=post&" . POST_USERS_URL . "=" .$ban_data['baner_id'] );
			$message .=  ( $board_config['show_tban_who'] ) ? '<br />' . $lang['contact_baner'] . '<a href="' . $pm . '" >' . $ban_data['username'] . '</a>' : '';
			$message .= ( $ban_data['ban_desc']!= '' && $board_config['show_tban_why'] ) ? '<br /><br />' . $lang['reason_supplied'] . '<br />' . ereg_replace ( 13, '<br />', $ban_data ['ban_desc'] ) : '';
			message_die ( GENERAL_MESSAGE, $message );
		}
		elseif ( !$error ) 
		{
			return FALSE;
		}
	}
}

function check_can_tban ( &$topic_id ) 
{
	global $board_config, $userdata, $db;

	$sql = "SELECT t.topic_poster, f.auth_tban " .
		"FROM " . TOPICS_TABLE . " t LEFT JOIN " . FORUMS_TABLE . " f ON t.forum_id = f.forum_id" .
		" WHERE t.topic_id = '$topic_id' LIMIT 1 ";
	$row = $db -> sql_fetchrow ( $db -> sql_query ( $sql ) );
	
	$uid = $userdata['user_id'];
	$ul = $userdata['user_level'];
	
	$auth = $row['auth_tban'];
	
	$can = FALSE;
	if ( $board_config['allow_topicban_mod'] && $ul == MOD && $auth == AUTH_MOD ) 
	{
		$can = TRUE;
	}
	if ( $board_config['allow_topicban_starter'] == ADMIN && $uid == $row['topic_poster'] && $auth == AUTH_REG ) 
	{
		$can = TRUE;
	}
	if ( $ul == ADMIN ) 
	{
		$can = TRUE;
	}
	if ( !$board_config['enable_topicban'] || $ul == ANONYMOUS ) 
	{
		$can = FALSE;
	}
	if ( !$userdata['user_allow_tban'] ) 
	{
		$can = FALSE;
	}
	
	return $can;
}

function check_tauth ( $auth, $auth_name, $forum_id ) 
{
	global $userdata, $db;
	
	$a = FALSE;
	if ( $auth == AUTH_ALL ) $a = TRUE;
	if ( $userdata['user_level'] == USER && $auth <= AUTH_REG ) 
	{
		$a = TRUE;
	}
	if ( $userdata['user_level'] == MOD && $auth <= AUTH_MOD ) 
	{
		$a = TRUE;
	}
	if ( $auth == AUTH_ACL ) 
	{
		$uid = $userdata['user_id'];
		$sql = "SELECT g.$auth_name " .
			"FROM " . USER_GROUP_TABLE . " ug LEFT JOIN " . AUTH_ACCESS_TABLE . " g ON ug.group_id = g.group_id " .
			"WHERE ug.user_id = '$uid' AND g.forum_id = $forum_id " .
			"LIMIT 1";
		if ( !$result = $db -> sql_query ( $sql ) ) 
		{
			message_die(GENERAL_ERROR, 'Could not obtain auth information', '', __LINE__, __FILE__, $sql);
		}
		$row = $db -> sql_fetchrow ( $result );
		if ( $row[$auth_name] ) $a = TRUE;
	}
	if ( $userdata['user_level'] == ADMIN && $auth <= AUTH_ADMIN ) 
	{
		$a = TRUE;
	}
	
	return $a;
}

// from php.net
function reverse_strrchr($haystack, $needle)
{
	return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) +1 ) : false;
}

function user_is_bot ( )
{
	global $userdata;
	
	// taken this list from some bot logigging MOD, can't remember which
	
	$bots[ 'Google' ] = '216.239.46.|64.68.8|64.68.9|164.71.1.|192.51.44.|66.249.71.|66.249.66.|66.249.65.|66.249.64.';
	$bots[ 'Alexa' ] = '66.28.250.|209.237.238.';
	$bots[ 'Inktomi' ] = '216.35.116.|66.196.|66.94.230.|202.212.5.';
	$bots[ 'Infoseek' ] = '204.162.9|205.226.203|206.3.30.|210.236.233.';
	$bots[ 'Alta Vista' ] = '194.221.84.|204.123.28.|208.221.35|212.187.226.|66.17.148.';
	$bots[ 'Lycos' ] = '208.146.27.|209.202.19|209.67.22|202.232.118.';
	$bots[ 'FAST' ] = '146.101.142.2|216.35.112.|64.41.254.2|213.188.8.';
	$bots[ 'WiseNut' ] = '64.241.243.|209.249.67.1|216.34.42.|66.35.208.';
	$bots[ 'MSN' ] = '131.107.3.|204.95.98.|131.107.1|65.54.164.95|207.46.98.';
	$bots[ 'Looksmart' ] = '64.241.242.|207.138.42.212';
	$bots[ 'Ask Jeeves' ] = '216.200.130.|216.34.121.|63.236.92.1|64.55.148.|65.192.195.|65.214.36.';
	
	$ip = reverse_strrchr(decode_ip( $userdata['session_ip'] ), '.');
	
	foreach( $bots as $bot )
	{
		$ips = explode( '|', $bot );
		foreach ( $ips as $b )
		{
			if ( $ip == $b )
			{
				return TRUE;
			}
		}
	}
	
	return FALSE;
}
// mod topic permissions mod end

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$user_allowpm = ( !empty($HTTP_POST_VARS['user_allowpm']) ) ? intval( $HTTP_POST_VARS['user_allowpm'] ) : 0;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$user_allow_pass = ( !empty($HTTP_POST_VARS['user_allow_pass'] ) ) ? intval( $HTTP_POST_VARS['user_allow_pass'] ) : 0;
$user_allow_tlogin = ( !empty($HTTP_POST_VARS['user_allow_tlogin'] ) ) ? intval( $HTTP_POST_VARS['user_allow_tlogin'] ) : 0;
$user_allow_tban = ( !empty($HTTP_POST_VARS['user_allow_tban'] ) ) ? intval( $HTTP_POST_VARS['user_allow_tban'] ) : 0;
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "UPDATE " . USERS_TABLE . "
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''",

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add to sql query

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

user_allow_pm = $user_allowpm,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

user_allow_tban = $user_allow_tban, user_allow_pass = $user_allow_pass, user_allow_tlogin = $user_allow_tlogin, 

# 
#-----[ FIND ]------------------------------------------ 
# 

$user_allowpm = $this_userdata['user_allow_pm'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod
$user_allow_pass = $this_userdata['user_allow_pass'];
$user_allow_tlogin = $this_userdata['user_allow_tlogin'];
$user_allow_tban = $this_userdata['user_allow_tban'];
// mod topic permissions mod

# 
#-----[ FIND ]------------------------------------------ 
# 

$s_hidden_fields .= '<input type="hidden" name="user_allowpm" value="' . $user_allowpm . '" />';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$s_hidden_fields .= '<input type="hidden" name="user_allow_pass" value="' . $user_allow_pass . '" />';
$s_hidden_fields .= '<input type="hidden" name="user_allow_tlogin" value="' . $user_allow_tlogin . '" />';
$s_hidden_fields .= '<input type="hidden" name="user_allow_tban" value="' . $user_allow_tban . '" />';
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'ALLOW_PM_NO' => (!$user_allowpm) ? 'checked="checked"' : '',

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
'ALLOW_PASS_YES' => ( $user_allow_pass ) ? 'checked="checked"' : '',
'ALLOW_PASS_NO' => ( !$user_allow_pass ) ? 'checked="checked"' : '',
'ALLOW_TLOGIN_YES' => ( $user_allow_tlogin ) ? 'checked="checked"' : '',
'ALLOW_TLOGIN_NO' => ( !$user_allow_tlogin ) ? 'checked="checked"' : '',
'ALLOW_TBAN_YES' => ( $user_allow_tban ) ? 'checked="checked"' : '',
'ALLOW_TBAN_NO' => ( !$user_allow_tban ) ? 'checked="checked"' : '',
// mod topic permissions mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_ALLOW_AVATAR' => $lang['User_allowavatar'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
'L_ALLOW_PASS' => $lang['user_allow_pass'],
'L_ALLOW_TLOGIN' => $lang['user_allow_tlogin'],
'L_ALLOW_TBAN' => $lang['user_allow_tban'],
// mod topic permissions mod end

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_forumauth.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// Start program - define vars

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod change

# 
#-----[ FIND ]------------------------------------------ 
# 

0  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_ALL, AUTH_ALL, AUTH_ALL

# 
#-----[ FIND ]------------------------------------------ 
# 

1  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_REG, AUTH_REG, AUTH_REG

# 
#-----[ FIND ]------------------------------------------ 
# 

2  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_REG, AUTH_REG, AUTH_REG

# 
#-----[ FIND ]------------------------------------------ 
# 

3  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_ACL, AUTH_ACL, AUTH_ACL

# 
#-----[ FIND ]------------------------------------------ 
# 

4  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_ACL, AUTH_ACL, AUTH_ACL

# 
#-----[ FIND ]------------------------------------------ 
# 

5  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_MOD, AUTH_MOD, AUTH_MOD

# 
#-----[ FIND ]------------------------------------------ 
# 

6  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_MOD, AUTH_MOD, AUTH_MOD

# 
#-----[ FIND ]------------------------------------------ 
# 

$forum_auth_fields

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add to array

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, 'auth_tpass', 'auth_tban', 'auth_tnoguest'

# 
#-----[ FIND ]------------------------------------------ 
# 

$field_names = array(

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add to array     

# 
#-----[ FIND ]------------------------------------------ 
# 

); 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
); 
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
, 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
'auth_pollcreate' => $lang['Pollcreate'], 
'auth_tpass' => $lang['tpass'], 
'auth_tban' => $lang['tban'], 
'auth_tnoguest' => $lang['tnoguest'] );

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_ug_auth.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$forum_auth_fields

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add to array

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, 'auth_tpass', 'auth_tban', 'auth_tnoguest'

# 
#-----[ FIND ]------------------------------------------ 
# 

$field_names = array(

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add to array

# 
#-----[ FIND ]------------------------------------------ 
# 

); 
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
); 
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
, 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
'auth_tpass' => $lang['tpass'], 
'auth_tban' => $lang['tban'], 
'auth_tnoguest' => $lang['tnoguest'] );

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/viewforum_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

{topicrow.TOPIC_TITLE}</a></span>

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

TOPIC_TITLE}</a></span>

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

<span class="gensmall"><i>{topicrow.PASSWORDED}</i></span>

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/viewtopic_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

{postrow.DELETE_IMG}

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

DELETE_IMG}

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 {postrow.TBAN_IMG}

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/user_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_AVATAR}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allowavatar" value="1" {ALLOW_AVATAR_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allowavatar" value="0" {ALLOW_AVATAR_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_PASS}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allow_pass" value="1" {ALLOW_PASS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allow_pass" value="0" {ALLOW_PASS_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_TLOGIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allow_tlogin" value="1" {ALLOW_TLOGIN_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allow_tlogin" value="0" {ALLOW_TLOGIN_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_TBAN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allow_tban" value="1" {ALLOW_TBAN_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allow_tban" value="0" {ALLOW_TBAN_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
 
<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span></td>
	  <td class="row2" width="78%"> <span class="gen"> 
		<input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" />
		</span> </td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	<!-- BEGIN switch_topic_pass -->
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{L_PASSWORD}<br />{L_PASSWORDCONF}</b></span></td>
	  <td class="row2" width="78%">
		<input type="password" name="topic_pass" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" />&nbsp;<br /><input type="password" name="topic_passconf" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" />&nbsp; <span class="gen">{DEL_PASS_BOX}
		<br />{L_PASS_DESC}</span> </td>
	</tr>
	<!-- END switch_topic_pass -->

# 
#-----[ FIND ]------------------------------------------ 
# 

<!-- BEGIN switch_html_checkbox -->

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

<!-- BEGIN switch_adminedit1 -->
  <tr> 
	<td> 
	  <input type="checkbox" name="admin_topic_edit" {S_EDIT_TOPIC_LOCK} />
	</td>
	<td><span class="gen">{L_EDIT_TOPIC_LOCK}</span></td>
  </tr>
  <!-- END switch_adminedit1 -->
  <!-- BEGIN switch_adminedit2 -->
  <tr> 
	<td> 
	  <input type="checkbox" name="{S_POST_LOCK}" {S_EDIT_POST_LOCK} />
	</td>
	<td><span class="gen">{L_EDIT_POST_LOCK}</span></td>
  </tr>
  <!-- END switch_adminedit2 -->
  <!-- BEGIN switch_topic_noguest -->
  <tr> 
	<td> 
	  <input type="checkbox" name="noguest" {S_NOGUEST} />
	</td>
	<td><span class="gen">{L_NOGUEST}</span></td>
  </tr>
  <!-- END switch_topic_noguest -->
  
# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/modcp_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<td class="row1">&nbsp;<span class="topictitle">{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span></td>

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

{topicrow.TOPIC_TITLE}</a></span>

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

<span class="gen">{topicrow.ADMIN_ONLY}</span>

# 
#-----[ FIND ]------------------------------------------ 
# 

<td class="catBottom" colspan="5" height="29"> {S_HIDDEN_FIELDS} 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<!-- BEGIN switch_admin -->
<span class="gen">{L_MAKE_ADMIN}&nbsp;<input type="checkbox" name="make_admin" {S_MAKE_ADMIN_CHECK}></span>
<!-- END switch_admin -->

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/subSilver.cfg

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$images['icon_topicban'] = "$current_template_images/icon_topicban.gif";

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
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic permissions mod add
$lang['admin_edit'] = 'Moderators cannot change this';
$lang['admin_only_edit'] = 'Only admin can change this';
$lang['admin_only_change'] = 'All of the topics you chose to change are admin only changeable';
$lang['edit_lock'] = 'Lock this topic from being moved, locked etc.';
$lang['edit_post_lock'] = 'Lock this post from being edited';
$lang['post_admin_edit'] = 'The admin has locked this post from being edited';
$lang['pass_desc_new'] = 'Enter password if you wish to password protect this topic';
$lang['pass_desc_change'] = 'Enter password if you wish to change it';
$lang['del_pass'] = 'Remove topic password';
$lang['topic_login'] = 'This topic requires you to login';
$lang['wrong_tpass'] = 'Wrong topic password';
$lang['guest_nologin'] = 'Unregistered users are not allowed to login to topics';
$lang['not_topiclogged'] = 'You are not logged in to this topic';
$lang['user_nologin'] = 'You are not allowed to login to passworded topics';
$lang['topic_banned'] = 'You are not welcome in this topic';
$lang['contact_baner'] = 'If you feel this was unjust complain to ';
$lang['reason_supplied'] = 'The reason supplied was: ';
$lang['topic_ban'] = 'Topic ban user';
$lang['cant_tban'] = 'You cannot topic ban in this topic';
$lang['cant_tban_guests'] = 'You cannot topic ban guests';
$lang['confirm_topic_ban'] = 'Are you sure you want to topic ban this user?';
$lang['cant_tban_nouser'] = 'No user specified';
$lang['user_tbanned'] = 'Successfully topic banned the user';
$lang['tban_why'] = 'Why are you topic banning this user?';
$lang['topic_noguest'] = 'Guests are not allowed in this topic';
$lang['noguest'] = 'Don\'t allow guests in this topic';
$lang['passworded'] = 'This topic is protected with a password';
$lang['Rules_tpass_can'] = 'You <b>can</b> password protect topics in this forum';
$lang['Rules_tpass_cannot'] = 'You <b>cannot</b> password protect topics in this forum';
$lang['Rules_tpass_can'] = 'You <b>can</b> password protect topics in this forum';
$lang['Rules_tpass_cannot'] = 'You <b>cannot</b> password protect topics in this forum';
$lang['Rules_tban_can'] = 'You <b>can</b> topic ban in this forum';
$lang['Rules_tban_cannot'] = 'You <b>cannot</b> topic ban in this forum';
$lang['Rules_tnoguest_can'] = 'You <b>can</b> prevent guests in topics in this forum';
$lang['Rules_tnoguest_cannot'] = 'You <b>cannot</b> prevent guests in topics in this forum';

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

$lang['topic_permissions'] = 'Topic Permissions';
$lang['topic_config_title'] = 'Configure Topic Permissions';
$lang['topic_config_explain'] = 'The form bellow allows you to set some options concerning the passwording and edit locking of topics';
$lang['edit_locks'] = 'Edit Locks';
$lang['mod_lock'] = 'Mods edit lock';
$lang['mod_lock_explain'] = 'Enable mods to lock a post from being edited by the user';
$lang['TConfig_updated'] = 'Successfully changed Topic PErmissions Configuration';
$lang['Click_return_tconfig'] = 'Click %sHere%s to return to Topic Configuration';
$lang['conf_passwords'] = 'Topic Password Configuration';
$lang['topicpass'] = 'Enable topic password';
$lang['guestpass'] = 'Guest topic password';
$lang['guestpass_explain'] = 'Enable guests to password protect their topics';
$lang['guestlogin'] = 'Guest topic login';
$lang['guestlogin_explain'] = 'Allow guests to login to topics';
$lang['guestsee'] = 'Guest can see passworded topics';
$lang['guestsee_explain'] = 'Note, you should disable the guest login and guest password if you disable this';
$lang['user_allow_pass'] = 'Can password protect topics';
$lang['user_allow_tlogin'] = 'Can login to topics';
$lang['topic_ban'] = 'Enable topic bans';
$lang['topic_bans'] = 'Topic bans';
$lang['topic_ban_mod'] = 'Moderators can topic ban';
$lang['topic_ban_starter'] = 'Topic starters can topic ban';
$lang['bansee'] = 'Topic banned users see the topic';
$lang['whosee'] = 'Show who banned in topic ban notice';
$lang['whysee'] = 'Show ban description in topic ban notice';
$lang['user_allow_tban'] = 'Can topic ban';
$lang['tban_config'] = 'Topic Ban Configuration';
$lang['tban_config_explain'] = 'Here you can edit or delete all of the topic bans as you see fit';
$lang['baner'] = 'Baner';
$lang['banned'] = 'Banned';
$lang['tban_desc'] = 'Description';
$lang['ban_updated'] = 'Topic bans updated successfully';
$lang['Click_return_tban'] = 'Click %sHere%s to return to Topic bans administration';
$lang['nobans'] = 'Currently there are no topic bans';
$lang['aguestlog'] = 'Allow preventing guest logging to specific topics';
$lang['aguestlog_mod'] = 'Allow moderators to prevent guest logging to specific topics';
$lang['aguestlog_starter'] = 'Allow topic starters preventing guest logging to specific topics';
$lang['general_perm'] = 'General Permissions';
$lang['tpass'] = 'Topic Password';
$lang['tban'] = 'Topic Ban';
$lang['tnoguest' ] = 'Topic No Guests';
$lang['globalnoguest'] = 'Topic No Guests';
$lang['redirectnoguest'] = 'Redirect to login instead of showing "No Guests" notice';
$lang['botnotguest'] = 'Let bots through guest protection (Google and the likes)';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 