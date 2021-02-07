##############################################################
## MOD Title: Easy Banned Ordering
## MOD Author: Mittineague < N/A > (N/A) http://www.mittineague.com
## MOD Description: 	Orders Banned usernames, IPs, and email addresses
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~ 1 Minute
##
## Files To Edit:	admin/admin_user_ban.php
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
##		Orders Banned user names case insensitive a-z
##		Orders Banned IPs sequentially by subsequent quads
##		e.g.	(random numbers, for example only)
##			123.123.123.123
##			125.12.123.*
##			145.43.76.42
##			145.44.64.134
##			145.44.76.21
##			145.44.76.233
##			203.75.145.251
##		Orders Banned email addresses by domain then name
##		e.g	(random email addresses, for example only)
##			donald@2duck.net
##			daffy@duck.net
##			micky@mouse.com
##			mighty@mouse.com
##			*@petro.com
##
##############################################################
## MOD History:
##
##   2006-12-20 - Version 1.0.0
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_user_ban.php

# 
#-----[ FIND ]------------------------------------------ 
#
	for($i = 0; $i < count($user_list); $i++)
	{
		$select_userlist .= '<option value="' . $user_list[$i]['ban_id'] . '">' . $user_list[$i]['username'] . '</option>';
		$userban_count++;
	}

# 
#-----[ REPLACE WITH ]------------------------------------
#
	$temp_ban_name_arr = array();

	for($i = 0; $i < count($user_list); $i++)
	{
		if( ( !empty($user_list[$i]['ban_id']) ) && ( !empty($user_list[$i]['username']) ) )
		{
			$user_ban_id = $user_list[$i]['ban_id'];
			$user_ban_name = $user_list[$i]['username'];
			$temp_ban_name_arr[$i][0] = $user_ban_id;
			$temp_ban_name_arr[$i][1] = $user_ban_name;
		}
	}

	foreach ($temp_ban_name_arr as $name_key => $name_row)
	{
		$name_id[$name_key]  = $name_row[0];
		$name_name[$name_key] = $name_row[1];
	}

	if ( !empty($temp_ban_name_arr) )
	{
		$name_name_lowercase = array_map('strtolower', $name_name);
		array_multisort($name_name_lowercase, SORT_ASC, SORT_STRING, $temp_ban_name_arr);
		for($h = 0; $h < count($temp_ban_name_arr); $h++)
		{
			$select_userlist .= '<option value="' . $temp_ban_name_arr[$h][0] . '">' . $temp_ban_name_arr[$h][1] . '</option>';
			$userban_count++;
		}
	}

# 
#-----[ FIND ]------------------------------------------ 
# 
	for($i = 0; $i < count($banlist); $i++)
	{
		$ban_id = $banlist[$i]['ban_id'];

		if ( !empty($banlist[$i]['ban_ip']) )
		{
			$ban_ip = str_replace('255', '*', decode_ip($banlist[$i]['ban_ip']));
			$select_iplist .= '<option value="' . $ban_id . '">' . $ban_ip . '</option>';
			$ipban_count++;
		}
		else if ( !empty($banlist[$i]['ban_email']) )
		{
			$ban_email = $banlist[$i]['ban_email'];
			$select_emaillist .= '<option value="' . $ban_id . '">' . $ban_email . '</option>';
			$emailban_count++;
		}
	}


# 
#-----[ REPLACE WITH ]------------------------------------
#
	$temp_ban_ip_arr = array();
	$temp_ban_email_arr = array();

	for($i = 0; $i < count($banlist); $i++)
	{
		$ban_id = $banlist[$i]['ban_id'];

		if ( !empty($banlist[$i]['ban_ip']) )
		{
			$ban_ip = str_replace('255', '*', decode_ip($banlist[$i]['ban_ip']));
			$ip_segs = explode(".", $ban_ip);
			$temp_ban_ip_arr[$i][0] = $ban_id;
			$temp_ban_ip_arr[$i][1] = $ip_segs[0];
			$temp_ban_ip_arr[$i][2] = $ip_segs[1];
			$temp_ban_ip_arr[$i][3] = $ip_segs[2];
			$temp_ban_ip_arr[$i][4] = $ip_segs[3];
		}

		if ( !empty($banlist[$i]['ban_email']) )
		{
			$ban_email = $banlist[$i]['ban_email'];
			$email_segs = explode('@', $ban_email);
			$temp_ban_email_arr[$i][0] = $ban_id;
			$temp_ban_email_arr[$i][1] = $email_segs[0];
			$temp_ban_email_arr[$i][2] = $email_segs[1];
		}
	}

	foreach ($temp_ban_ip_arr as $ip_key => $ip_row)
	{
		$ip_id[$ip_key]  = $ip_row[0];
		$ip_seg_one[$ip_key] = $ip_row[1];
		$ip_seg_two[$ip_key] = $ip_row[2];
		$ip_seg_tri[$ip_key] = $ip_row[3];
		$ip_seg_qua[$ip_key] = $ip_row[4];
	}

	foreach ($temp_ban_email_arr as $email_key => $email_row)
	{
		$email_id[$email_key]  = $email_row[0];
		$email_seg_one[$email_key] = $email_row[1];
		$email_seg_two[$email_key] = $email_row[2];
	}

	if ( !empty($temp_ban_ip_arr) )
	{
		array_multisort($ip_seg_one, SORT_ASC, $ip_seg_two, SORT_ASC, $ip_seg_tri, SORT_ASC, $ip_seg_qua, SORT_ASC, $temp_ban_ip_arr);
		for($j = 0; $j < count($temp_ban_ip_arr); $j++)
		{
			$select_iplist .= '<option value="' . $temp_ban_ip_arr[$j][0] . '">' . $temp_ban_ip_arr[$j][1] . '.' . $temp_ban_ip_arr[$j][2] . '.' . $temp_ban_ip_arr[$j][3] . '.' . $temp_ban_ip_arr[$j][4] .  '</option>';
			$ipban_count++;
		}
	}

	if ( !empty($temp_ban_email_arr) )
	{
		array_multisort($email_seg_two, SORT_ASC, $email_seg_one, SORT_ASC, $temp_ban_email_arr);
		for($k = 0; $k < count($temp_ban_email_arr); $k++)
		{
			$select_emaillist .= '<option value="' . $temp_ban_email_arr[$k][0] . '">' . $temp_ban_email_arr[$k][1] . '@' . $temp_ban_email_arr[$k][2] . '</option>';
			$emailban_count++;
		}
	}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 