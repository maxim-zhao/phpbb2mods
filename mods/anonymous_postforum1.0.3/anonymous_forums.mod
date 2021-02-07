##############################################################
## MOD Title: Anonymous Forums
## MOD Author: cYbercOsmOnauT < mods@cybercosmonaut.de > (Tekin B.) http://www.cybercosmonaut.de
## MOD Description: This mod lets you define forums where users can
##                  post anonymously. The postings appear to be posted by
##                  user that you set through your acp. You can also
##                  cloak the posters ip.
## MOD Version: 1.0.3
## Installation Level: Easy
## Installation Time: 17 Minutes
## Files To Edit: admin/admin_board.php
##                includes/functions_post.php
##                language/lang_english/lang_admin.php
##                templates/subSilver/admin/board_config_body.tpl
## Included Files: db_update.php
## Generator: MOD eclipse
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2 
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
## If you do this mod manually,
## you can use db_update.php for the sql-stuff.
##############################################################
## MOD History: 
## 
##   2005-07-24 - Version 1.0.0
##      - Initial Release
## 
##   2005-07-25 - Version 1.0.1
##      - Changed some small parts of the description for
##        phpBB.com ;-)
## 
##   2005-07-26 - Version 1.0.2
##      - Fixed an error in db_update.php
## 
##   2005-07-26 - Version 1.0.3
##      - Fixed a step I forgot to write down in my mod.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anon_forums','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anon_userid','-1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anon_ip','0');

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
$prune_no = ( !$new['prune_enable'] ) ? "checked=\"checked\"" : "";

#
#-----[ AFTER, ADD ]------------------------------------------
#
$anonip_yes = ( $new['anon_ip'] ) ? "checked=\"checked\"" : "";
$anonip_no = ( !$new['anon_ip'] ) ? "checked=\"checked\"" : "";

#
#-----[ FIND ]------------------------------------------
#
	"L_ENABLE_PRUNE" => $lang['Enable_prune'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	"L_ANONFORUMS_SETTINGS" => $lang['Anonforums_Settings'],
	"L_ANONFORUMS_SETTINGS_EXPLAIN" => $lang['Anonforums_Settings_Explain'],
	"L_ANON_FORUMS" => $lang['Anon_Forums'],
	"L_ANON_FORUMS_EXPLAIN" => $lang['Anon_Forums_Explain'],
	"L_ANON_USERID" => $lang['Anon_Userid'],
	"L_ANON_USERID_EXPLAIN" => $lang['Anon_Userid_Explain'],
	"L_ANON_IP" => $lang['Anon_IP'],

#
#-----[ FIND ]------------------------------------------
#
	"NAMECHANGE_NO" => $namechange_no,

#
#-----[ AFTER, ADD ]------------------------------------------
#
	"ANON_FORUMS" => $new['anon_forums'],
	"ANON_USERID" => $new['anon_userid'],
	"ANONIP_YES" => $anonip_yes,
	"ANONIP_NO" => $anonip_no,

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#
	if ($mode == 'newtopic' || $mode == 'reply' || $mode == 'editpost') 
	{
		//

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Check for anonymous forums
		//
		if ( in_array($forum_id, explode(" ", $board_config['anon_forums'])) )
		{
			$anon_id = $board_config['anon_userid']; // hide the posters nick
			$anon_ip = $board_config['anon_ip'] ? "0.0.0.0" : $user_ip; // hide the ip too?
		}
		else
		{
			$anon_id = $userdata['user_id'];
			$anon_ip = $user_ip;
		}		
		//

#
#-----[ FIND ]------------------------------------------
#
		$sql  = ($mode != "editpost") ? "INSERT INTO " . TOPICS_TABLE . " (topic_title,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$userdata['user_id']

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$anon_id

#
#-----[ FIND ]------------------------------------------
#
	$sql = ($mode != "editpost") ? "INSERT INTO " . POSTS_TABLE . " (topic_id,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$userdata['user_id']

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$anon_id

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$user_ip

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$anon_ip

#
#-----[ FIND ]------------------------------------------
#
	global $db;

#
#-----[ REPLACE WITH ]------------------------------------------
#
	global $db, $board_config;

#
#-----[ FIND ]------------------------------------------
#
	$topic_update_sql = '';

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$anon_id = in_array($forum_id, explode(" ", $board_config['anon_forums'])) ? $board_config['anon_userid'] : $user_id;

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Allow_name_change'] = 'Allow Username changes';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Anonforums_Settings'] = 'Anonymous Forums Settings';
$lang['Anonforums_Settings_Explain'] = 'These details define forums where users can post anonymously';
$lang['Anon_Forums'] = 'Anonymous Forums';
$lang['Anon_Forums_Explain'] = 'Forumids of the anonymous forums. Seperate them with spaces.';
$lang['Anon_Userid'] = 'Cloaking User';
$lang['Anon_Userid_Explain'] = 'Userid of the user who should appear as the poster from the anonymous postings.';
$lang['Anon_IP'] = 'Cloak IP';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		<td class="row1">{L_ENABLE_PRUNE}</td>
		<td class="row2"><input type="radio" name="prune_enable" value="1" {PRUNE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="prune_enable" value="0" {PRUNE_NO} /> {L_NO}</td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<th class="thHead" colspan="2">{L_ANONFORUMS_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_ANONFORUMS_SETTINGS_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_ANON_FORUMS}<br /><span class="gensmall">{L_ANON_FORUMS_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" name="anon_forums" value="{ANON_FORUMS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ANON_USERID}<br /><span class="gensmall">{L_ANON_USERID_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="16" name="anon_userid" value="{ANON_USERID}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_ANON_IP}</td>
		<td class="row2"><input type="radio" name="anon_ip" value="1" {ANONIP_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="anon_ip" value="0" {ANONIP_NO} /> {L_NO}</td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

