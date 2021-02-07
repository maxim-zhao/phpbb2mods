##############################################################
## MOD Title: Disable Board Message
## MOD Author: Sko22 < webmaste@quellicheilpc.com > (Gianluca Scerni) http://www.quellicheilpc.com/
## MOD Description: Customize disable board message 
## MOD Version: 1.0.0
##
## Installation Level: (Easy)
## Installation Time: 1 Minute
## Files To Edit: common.php
## admin/admin_board.php
## templates/subSilver/admin/board_config_body.tpl
## language/lang_english/lang_admin.php
## Included Files: (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: Tested on phpBB 2.0.6 only :( . Support http://www.quellicheilpc.com
## Tanks to Paky
##############################################################
## MOD History:
##
##   2004-02-07 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ SQL ]------------------------------------------ 
# 
#   If you have a different table prefix then change this command accordingly. 
#   I have used the default table prefix! 
# 

INSERT INTO phpbb_config VALUES ('board_disable_msg', 'Rebuild Search in progress...');

#
#-----[ OPEN ]------------------------------------------
#
common.php

#
#-----[ FIND ]------------------------------------------
#

if( $board_config['board_disable'] && !defined("IN_ADMIN") && !defined("IN_LOGIN") )
{
	message_die(GENERAL_MESSAGE, 'Board_disable', 'Information');
}

#
#-----[ REPLACE WITH ]------------------------------------------
#

if( $board_config['board_disable'] && !defined("IN_ADMIN") && !defined("IN_LOGIN") )
{
	if ( $board_config['board_disable_msg'] != "" )
	{
		message_die(GENERAL_MESSAGE, $board_config['board_disable_msg'], 'Information');
	}
	else
	{
		message_die(GENERAL_MESSAGE, 'Board_disable', 'Information');
	}
}

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#

	"L_DISABLE_BOARD_EXPLAIN" => $lang['Board_disable_explain'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

	"L_DISABLE_BOARD_MSG" => $lang['Board_disable_msg'], 
	"L_DISABLE_BOARD_MSG_EXPLAIN" => $lang['Board_disable_msg_explain'],

#
#-----[ FIND ]------------------------------------------
#

	"S_DISABLE_BOARD_NO" => $disable_board_no,

#
#-----[ AFTER, ADD ]------------------------------------------
#

	"DISABLE_BOARD_MSG" => $new['board_disable_msg'],

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#

	<tr>
		<td class="row1">{L_DISABLE_BOARD}<br /><span class="gensmall">{L_DISABLE_BOARD_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="board_disable" value="1" {S_DISABLE_BOARD_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="board_disable" value="0" {S_DISABLE_BOARD_NO} /> {L_NO}</td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr>
		<td class="row1">{L_DISABLE_BOARD_MSG}<br /><span class="gensmall">{L_DISABLE_BOARD_MSG_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="40" name="board_disable_msg" value="{DISABLE_BOARD_MSG}" /></td></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#

$lang['Board_disable_explain'] = 'This will make the board unavailable to users. Administrators are able to access the Administration Panel while the board is disabled.';

#
#-----[ AFTER, ADD ]------------------------------------------
#

$lang['Board_disable_msg'] = 'Disable board message';
$lang['Board_disable_msg_explain'] = 'This text will be showed if "Disable board" is on "Yes".';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 