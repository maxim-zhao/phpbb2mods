##############################################################
## MOD Title: Restrict Account To IP
## MOD Author: geocator < geocator@gmail.com > (Brian) http://www.geocator.us
## MOD Description: Allows you to restrict login on an account to a specific IP address or range
## MOD Version: 1.0.1
## 
## Installation Level: Moderate
## Installation Time: 16 minutes
## Files To Edit: login.php
##                language/lang_english/lang_main.php
##                admin/admin_users.php
##                language/lang_english/lang_admin.php
##                templates/subSilver/admin/user_edit_body.tpl
## Included Files: 
## Generator: MOD Studio 3.0 Alpha 1 [mod functions 0.2.1677.25348]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: Todo - user facing, in line finds
##############################################################
## MOD History:
##  
##   2005-07-28 - Version 1.0.1
## 
##      - Various MOD Template related changes
##  
##   2005-07-22 - Version 1.0.0
## 
##      - Full Release
##      - Removed php 3 compatibility code, no longer required
##      - Changed admin panel html for looks
##      - Modified MOD template with in-line finds
##
##   2004-10-02 - Version 0.0.2
## 
##      - Added ranges
##
##   2004-09-11 - Version 0.0.1
## 
##      - Initial Release
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_iprange` VARCHAR( 255 ) , ADD `user_restrictip` TINYINT( 1 ) DEFAULT '0' NOT NULL ;
#
#-----[ OPEN ]------------------------------------------
#

login.php
#
#-----[ FIND ]------------------------------------------
#
			$sql = "SELECT user_id, username, user_password, user_active, user_level
#
#-----[ IN-LINE FIND ]------------------------------------------
#
user_active, user_level
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_iprange, user_restrictip
#
#-----[ FIND ]------------------------------------------
#
			if( $row['user_level'] != ADMIN && $board_config['board_disable'] )
#
#-----[ BEFORE, ADD ]------------------------------------------
#
			if( $row['user_restrictip'] )
			{
				$my_ip = decode_ip($user_ip);
				$my_ip_explode = explode('.', $my_ip);
				$valid_ip = FALSE;
				
				$ip_sets = explode(',', $row['user_iprange']);

				for($i = 0; $i < count($ip_sets); $i++)
				{
					
					$ip_type = count(explode('.', $ip_sets[$i]));
					if ($ip_type == 4)
					{
						
						if($my_ip == $ip_sets[$i])
						{
							$valid_ip = TRUE;
							
						}
					}
					else if ($ip_type == 3)
					{
					
						$ip_set_explode = explode('.', $ip_sets[$i]);
						if (($my_ip_explode[0] == $ip_set_explode[0]) && ($my_ip_explode[1] == $ip_set_explode[1]) && ($my_ip_explode[2] == $ip_set_explode[2]))
						{
							$valid_ip = TRUE;
							
						}
					}
					else if (ereg("-",$ip_sets[$i]))
					{
					
						$ar = explode("-",$ip_sets[$i]);
						$your_long_ip = ip2long(decode_ip($user_ip));
						if ( ($your_long_ip >= ip2long(trim($ar[0]))) && ($your_long_ip <= ip2long(trim($ar[1]))) ) 
						{
							$valid_ip = TRUE;
							
						} 
					}


				}
				
				if($valid_ip == FALSE)
				{
					message_die(GENERAL_MESSAGE, $lang['restrict_ip']);
				}
			}
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
$lang['restrict_ip'] = 'You can not log into this account from this IP address/range.';

#
#-----[ OPEN ]------------------------------------------
#

admin/admin_users.php
#
#-----[ FIND ]------------------------------------------
#
		$user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$user_restrictip = ( !empty($HTTP_POST_VARS['user_restrictip']) ) ? intval( $HTTP_POST_VARS['user_restrictip']) : 0;
		$user_iprange = ( !empty($HTTP_POST_VARS['user_iprange']) ) ? trim(strip_tags(htmlspecialchars($HTTP_POST_VARS['user_iprange']))) : '';

#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email = 
#
#-----[ IN-LINE FIND ]------------------------------------------
#
user_rank = $user_rank
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_restrictip = $user_restrictip, user_iprange = '" . str_replace("\'", "''", $user_iprange) . "'
#
#-----[ FIND ]------------------------------------------
#
		$user_status = $this_userdata['user_active'];
		$user_allowavatar = $this_userdata['user_allowavatar'];
		$user_allowpm = $this_userdata['user_allow_pm'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
		$user_restrictip = $this_userdata['user_restrictip'];
		$user_iprange = $this_userdata['user_iprange'];

#
#-----[ FIND ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="user_rank" value="' . $user_rank . '" />';

#
#-----[ AFTER, ADD ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="user_restrictip" value="' . $user_restrictip . '" />';
			$s_hidden_fields .= '<input type="hidden" name="user_iprange" value="' . $user_iprange . '" />';

#
#-----[ FIND ]------------------------------------------
#
			'RANK_SELECT_BOX' => $rank_select_box,
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'USER_RESTRICTIP_YES' => ($user_restrictip) ? 'checked="checked"' : '',
			'USER_RESTRICTIP_NO' => (!$user_restrictip) ? 'checked="checked"' : '', 
			'USER_IPRANGE' => $user_iprange,
#
#-----[ FIND ]------------------------------------------
#
			'L_EMAIL_ADDRESS' => $lang['Email_address'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'L_USER_RESTRICTIP' => $lang['restrictip'],
			'L_USER_IPRANGE' => $lang['iprange'],
			'L_ABOUTRESTRICTIP' => $lang['about_restrictip'],
			'L_ABOUT_IPRANGE' => $lang['about_range'],
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
$lang['iprange'] = 'IP Range';
$lang['restrictip'] = 'Restrict to IP';
$lang['about_restrictip'] = 'Restrict Account To IP';
$lang['about_range'] = 'Enter the following formats seperated by a comma:<ul><li>Single IP</li><li>Subnet: 192.168.1</li><li>Range: 192.167.0.0-192.168.8.1</li></ul>';

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<!-- END avatar_local_gallery -->

	<tr> 
	  <td class="catSides" colspan="2">&nbsp;</td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
	  <th class="thSides" colspan="2">{L_ABOUTRESTRICTIP}</th>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_USER_RESTRICTIP}</span></td>  
	  <td class="row2">
		<input type="radio" name="user_restrictip" value="1" {USER_RESTRICTIP_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_restrictip" value="0" {USER_RESTRICTIP_NO} />
		<span class="gen">{L_NO}</span><br /><br /></td>
	</tr>
	<tr>
	  <td class="row1">	
		{L_USER_IPRANGE}<br />
		{L_ABOUT_IPRANGE}
	  </td>	
	  <td class="row2">	
	    <textarea name="user_iprange" maxlength="255" rows=5 cols=25>{USER_IPRANGE}</textarea>
	  </td>
	</tr>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

