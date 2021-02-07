##############################################################
## MOD Title: No Flood Control For Mods And Admins
## MOD Author: Cyberwizzard < phpbb@cyberwizzard.tmfweb.nl > (Berend Dekens) N/A
## MOD Description: All your users are vigilantes that must be retained or else
##                  all hell will break loose on your forum. And thus, the flood
##                  control kicks in and does this job for you.
##                  But surely the moderators and admins are trusted folks? This
##                  mod disables the flood control for them so they can reign without
##                  being restrained by this nifty feature.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~2 Minutes
## Files To Edit: functions_post.php
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: This mod was designed for the PC-Active forum.
## I tested it with phpBB 2.0.6 (which is the current version) but
## presuming the internals of the board don't change drastically over
## versions, it can be adapted for other versions quite easy (2.x).
##
##############################################################
## MOD History:
##
##   2003-08-23 - Version 1.0.0
##      - Last test completed succesfully.
##      - Code cleaned up and inserted some usefull comments
##      - Adapted mod templete to this file
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#

//
// Post a new topic/reply/poll or edit existing post/poll
//
function submit_post($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id, &$topic_type, &$bbcode_on, &$html_on, &$smilies_on, &$attach_sig, &$bbcode_uid, &$post_username, &$post_subject, &$post_message, &$poll_title, &$poll_options, &$poll_length)
{
	global $board_config, $lang, $db, $phpbb_root_path, $phpEx;
	global $userdata, $user_ip;

	include($phpbb_root_path . 'includes/functions_search.'.$phpEx);

	$current_time = time();

#
#-----[ AFTER, ADD ]------------------------------------------
#

	//
	// MOD: No Flood Control For Mods And Admins by Berend Dekens
	// Retreive authentication info to determine if this user has moderator status
	//
	$is_auth = auth(AUTH_ALL, $forum_id, $userdata);
	$is_mod = $is_auth['auth_mod'];
	

#
#-----[ FIND ]------------------------------------------
#
	
	if ($mode == 'newtopic' || $mode == 'reply' || $mode == 'editpost')
	{
	
#
#-----[ REPLACE WITH ]------------------------------------------
#

	if (($mode == 'newtopic' || $mode == 'reply' || $mode == 'editpost') && !$is_mod)
	{

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 