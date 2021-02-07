###############################################
## MOD Title:   Minimum Posts Before PM and Email Allowed
## MOD Author: Merlin Sythove  < N/A > (Merlin Sythove) n/a
## MOD Author: azw < N/A > (Art Zoller Wagner) http://www.DigitalDesign.us
## MOD Description: Sets a minimum of posts required before
##				  users can send PM or emails to other members.
##                Admins and mods are excluded; they can send PM and emails immediately.
##                Also replying to a PM is allowed even if user has not yet posted.
##				  Settings can be changed in Admin Control Panel
## MOD Version:		1.0.2
##
## Installation Level: Intermediate
## Installation Time: 15 minutes
## Files To Edit:
##      language/lang_english/lang_main.php (and any other language files you have)
##      includes/usercp_email.php
##      privmsg.php
##		language/lang_english/lang_admin.php (and any other language files you have)
##		admin/admin_board.php
##		templates/subSilver/admin/board_config_body.tpl
##
## Included Files: N/A
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##
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
## 1. New files that must be edited in latest version
##		language/lang_english/lang_admin.php (and any other language files you have)
##		admin/admin_board.php
##		templates/subSilver/admin/board_config_body.tpl
##
## 2. Many of the variable names have changed since 1.0.1
##
## 3. Compatibility / EasyMOD
##      This MOD is compatible with phpBB 2.0.20
##      Untested for EasyMOD compatiiblity
##
###############################################
## MOD History:
##
## 2006/06/06 - Version 1.0.2 ( Art Zoller Wagner )
##	- Added feature to allow admin to enable/disable mod in the Admin Control Panel
##  - Added feature to allow admin to set minimum number of posts in ACP
##
## 2005/01/?? - Version 1.0.1 ( Merlin Sythove )
##	- Initial development with fixed minimum number of posts hard-coded
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]-------------------------------------------
#
# Remember to change the table prefix used on your database
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('limit_privmsg_enable', '1');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('limit_privmsg_number', '25');

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

// azw mod minimum posts before pm email
$lang['Limit_privmsg_title'] = 'Restrict New Members Use of Email & PM';
$lang['Limit_privmsg_enable_label'] = 'Enable restriction on email & PM';
$lang['Limit_privmsg_enable_explain'] = 'Enable restriction on new members, requiring a minimum number of posts before initiating email or PM contact with other members.';
$lang['Limit_privmsg_number_label'] = 'Minimum number of posts';
$lang['Limit_privmsg_number_explain'] = 'Enter the number of forum messages a new member must post before being allowed to contact other members by email or PM';
// end mod minimum posts before pm email

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
# (add a new line after the above partial line)

// azw mod minimum posts before pm email
$lang['Limit_privmsg'] = 'You must have written a minimum of %d posts<br />before you can initiate contact with other members<br />by email or private message (PM). Sorry!';

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_email.php

#
#-----[ FIND ]------------------------------------------
# about line 160

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

#
#-----[ BEFORE, ADD ]------------------------------------------
#

		// azw mod minimum posts before pm email
		if ( $board_config['limit_privmsg_enable'] )
		{
			if ( ( $userdata['user_posts'] < $board_config['limit_privmsg_number'] ) && ( $userdata['user_level'] <= USER ) )
			{
				message_die( GENERAL_MESSAGE, sprintf( $lang['Limit_privmsg'], $board_config['limit_privmsg_number'] ) );
			}
		}
		// end mod minimum posts before pm email
   
#
#-----[ OPEN ]------------------------------------------
#
privmsg.php

#
#-----[ FIND ]------------------------------------------
# around line 1580

   if ( !$userdata['user_allow_pm'] && $mode != 'edit' )
   {
      $message = $lang['Cannot_send_privmsg'];
      message_die(GENERAL_MESSAGE, $message);
   }

#
#-----[ AFTER, ADD ]------------------------------------------
#

	// azw mod minimum posts before pm email
	if ( $mode == 'post' ) //allow reply regardless
	{
		if ( $board_config['limit_privmsg_enable'] )
		{
			if ( ( $userdata['user_posts'] < $board_config['limit_privmsg_number'] ) && ( $userdata['user_level'] <= USER ) )
			{
				message_die( GENERAL_MESSAGE, sprintf( $lang['Limit_privmsg'], $board_config['limit_privmsg_number'] ) );
			}
		}
	}
  // end mod minimum posts before pm email

  
#
#-----[ OPEN ]------------------------------------------
#

admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
#
$smtp_no = ( !$new['smtp_delivery'] ) ? "checked=\"checked\"" : "";

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
// azw mod minimum posts before pm email
$limit_privmsg_enable_yes = ( $new['limit_privmsg_enable'] ) ? "checked=\"checked\"" : "";
$limit_privmsg_enable_no = ( !$new['limit_privmsg_enable'] ) ? "checked=\"checked\"" : "";

# 
#-----[ FIND ]------------------------------------------ 
#
	"SMTP_NO" => $smtp_no,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

	// azw mod minimum posts before pm email
	"L_LIMIT_PRIVMSG_TITLE" => $lang['Limit_privmsg_title'],
	"L_LIMIT_PRIVMSG_ENABLE_LABEL" => $lang['Limit_privmsg_enable_label'],
	"L_LIMIT_PRIVMSG_ENABLE_EXPLAIN" => $lang['Limit_privmsg_enable_explain'],
	"L_LIMIT_PRIVMSG_NUMBER_LABEL" => $lang['Limit_privmsg_number_label'],
	"L_LIMIT_PRIVMSG_NUMBER_EXPLAIN" => $lang['Limit_privmsg_number_explain'],
	"LIMIT_PRIVMSG_ENABLE_YES" => $limit_privmsg_enable_yes,
	"LIMIT_PRIVMSG_ENABLE_NO" => $limit_privmsg_enable_no,
	"LIMIT_PRIVMSG_NUMBER" => $new['limit_privmsg_number'],

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
	<tr>
		<th class="thHead" colspan="2">{L_COOKIE_SETTINGS}</th>
	</tr>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	<tr>
		<th class="thHead" colspan="2">{L_LIMIT_PRIVMSG_TITLE}</th>
	</tr>
	<tr>
		<td class="row1">{L_LIMIT_PRIVMSG_ENABLE_LABEL}<br /><span class="gensmall">{L_LIMIT_PRIVMSG_ENABLE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="limit_privmsg_enable" value="1" {LIMIT_PRIVMSG_ENABLE_YES} /> {L_YES}  <input type="radio" name="limit_privmsg_enable" value="0" {LIMIT_PRIVMSG_ENABLE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_LIMIT_PRIVMSG_NUMBER_LABEL}<br /><span class="gensmall">{L_LIMIT_PRIVMSG_NUMBER_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" name="limit_privmsg_number" value="{LIMIT_PRIVMSG_NUMBER}" /></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM