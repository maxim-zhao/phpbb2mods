############################################################## 
## MOD Title: Restrict topic creation by post count
## MOD Author: lightdarkness < lightdarkness@gmail.com > (Jay MacLean) http://www.lightdarkness42.com/phpBB2/ 
## MOD Description: This mod allows you to set a post count, that a user must have before being allowed to create a topic
## MOD Version: 1.0.1
## 
## Installation Level: (Easy) 
## Installation Time: 5 Minutes
## Files To Edit: - admin/admin_board.php
##		  - includes/functions_post.php
##		  - language/lang_english/lang_admin.php
##		  - language/lang_english/lang_main.php
##		  - templates/subSilver/admin/board_config_body.tpl
## Included Files: none 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: Pop in easymod and your all set, tested with 2.0.10
##		 Special thanks to Soccr743 for testing
## 
############################################################## 
## MOD History: 
##
## 6/16/04 - 1.0.1
##          - Checked for 2.0.10 compatibility
##
## 6/16/04 - 1.0.0
##          - Initial release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ SQL ]-------------------------------------------
#
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('create_topic_post_limit', '100');

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#
if ($mode == 'newtopic')
		{

#
#-----[ AFTER, ADD ]------------------------------------------
#
			//start Restrict topic creation by postcount mod

			if ($userdata['user_posts'] < $board_config['create_topic_post_limit']) {
				message_die(GENERAL_MESSAGE, sprintf($lang['Not_enough_posts_to_create']));
			}
			//end mod


# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 
         "L_ABILITIES_SETTINGS" => $lang['Abilities_settings'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
         "L_CREATE_TOPIC_POST_LIMIT" => $lang['create_topic_post_limit'],

#
#-----[ FIND ]------------------------------------------ 
#
	"BOARD_EMAIL_FORM_DISABLE" => $board_email_form_no, 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	"CREATE_TOPIC_POST_LIMIT" => $new['create_topic_post_limit'],

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Abilities_settings'] = 'User and Forum Basic Settings';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['create_topic_post_limit'] = 'Number of posts a user must have to create a topic';

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Confirm_delete_poll'] = 'Are you sure you want to delete this poll?';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['Not_enough_posts_to_create'] = 'You do not have enough posts to create a topic.';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	<tr>
	  
		<th class="thHead" colspan="2">{L_ABILITIES_SETTINGS}</th>
	
	</tr>


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	<tr> 
      		<td class="row1">{L_CREATE_TOPIC_POST_LIMIT}</td> 
      		<td class="row2"><input class="post" type="text" name="create_topic_post_limit" size="5" maxlength="5" value="{CREATE_TOPIC_POST_LIMIT}" /></td> 
   	</tr>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 