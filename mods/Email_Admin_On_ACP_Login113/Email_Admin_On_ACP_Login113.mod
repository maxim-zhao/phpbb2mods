##############################################################
## MOD Title:   Email Admin on ACP Login
## MOD Author:  The Defpom < N/A > (Scott Gausden) http://www.radiomods.co.nz
## MOD Description:  Adds a feature so that if the ACP is accessed it emails the admin.
## MOD Version: 1.1.3
##
## Installation Level: Easy
## Installation Time:  1 Minutes
## Files To Edit:	2
##			admin/index.php
##          language/lang_english/lang_main.php
##
## Included Files: 1
##          language/lang_english/email/admin_acp_login.tpl
##
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: Works with Easymod !!
## 
## This mod will add a a feature so that if the ACP is accessed by someone other than the main admin it emails the admin to let them know !
## It includes the persons user name, user ID, IP Address and time accessed.
##
## NOTE: it is neccesary to set the required ADMIN user ID in the code below (x2), the default ID is "2", so if the main admin has a different user id
## change the code to the same ID, the file to edit after the mod has been installed is admin/index.php
##
##
## This MOD can be seen in action on my forum: http://www.radiomods.co.nz/forum/
## 
############################################################## 
## MOD History: 
##
## 2005-08-14 - 1.1.3
##	    - Updated to the new security statement and licence information.
## 2005-08-12 - 1.1.2
##	    - Fixed another little code error in SQL statement.
## 2005-08-06 - 1.1.1
##	    - Added missing semi colons in new code.
## 2005-06-09 - 1.1.0
##	    - Code improvements and alteration to the way the date and time is called, thanks to "AbelaJohnB" and "Kalipo" for helping tweak the code to what it is now
## 2005-04-29 - 1.0.2
##	    - Minor code changes (added missing bracket, added sitename to email, fixed multiple emails)
## 2005-04-13 - 1.0.1
##	    - Minor code fix
## 2005-04-02 - 1.0.0
##	    - Submitted for release
## 2005-03-23 - 0.1.1
##	    - First Version
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
# 
#---[ COPY ]------------------------------------------------ 
# 
copy language/lang_english/email/admin_acp_login.tpl to language/lang_english/email/admin_acp_login.tpl


# 
#---[ OPEN ]------------------------------------------------ 
# 
admin/index.php

# 
#---[ FIND ]------------------------------------------------- 
# 
if( isset($HTTP_GET_VARS['pane']) && $HTTP_GET_VARS['pane'] == 'left' )
{

# 
#---[ AFTER, ADD ]--------------------------------------- 
# 


	// 
	//send e-mail to admin on ACP access
	//
	// The lines below set the admin account user id, if the ACP is accessed by a different ID it will activate the email feature.
	// The default is ID 2 (main ADMIN), if the main admin has a different ID number enter it instead of 2 ie for ID 3 use $checkforid = "3" and $adminemailid = "3"
	// if you want to be emailed for all ACP accesses change code to read: $checkforid = "0"
	
	$checkforid = "2"; // sets the ID of the authorised admin/user, anything other than this ID will trigger the mod
	$adminemailid = "2"; // sets the user ID of the person to email if mod is triggered
	
	if( $userdata['user_id'] != $checkforid ) //User ID of Admin, checks if the user ID is NOT admin user id, if true it runs the statement.
		 {
		 include($phpbb_root_path . 'includes/emailer.'.$phpEx);
		 $emailer = new emailer($board_config['smtp_delivery']);
		  $sql = 'SELECT user_email, user_timezone, user_dateformat FROM ' . USERS_TABLE . ' WHERE user_id =' . $adminemailid;
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not select Administrators', '', __LINE__, __FILE__, $sql);
					}
	
					while ($row = $db->sql_fetchrow($result))
					{
	
						$emailer->from($board_config['board_email']);
						$emailer->replyto($board_config['board_email']);
						$emailer->email_address(trim($row['user_email']));
						$emailer->use_template('admin_acp_login');
						$emailer->set_subject($lang['ACP_Login']);
						$emailer->assign_vars(array(
							'USERNAME' => $userdata['username'],
							'USERID' => $userdata['user_id'],
							'USERIP' => decode_ip($user_ip),
							'SITENAME' => $board_config['sitename'],
						   'TIME' => sprintf($lang['Current_time'], create_date($row['user_dateformat'], time(), $row['user_timezone'])))
						);
					}
			$db->sql_freeresult($result);
		$emailer->send();
		$emailer->reset();
		}
		
	//
	//end send e-mail to admin
	//


# 
#---[ OPEN ]------------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#---[ FIND ]------------------------------------------------- 
# 
//
// That's all, Folks!
// -------------------------------------------------

# 
#---[ BEFORE, ADD ]--------------------------------------- 
# 

// Email Admin on ACP Login
$lang['ACP_Login'] = 'Someone just accessed the admin control panel !!';


 
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM