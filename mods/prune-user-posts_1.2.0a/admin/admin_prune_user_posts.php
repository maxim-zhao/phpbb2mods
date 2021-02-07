<?php

/*******************************************************************

 Name		: Prune User Posts [Admin module]
 Copyright	: 2003, Adam Alkins
 Website	: http://www.rasadam.com
 email		: phpbb at rasadam dot com

 $Id: admin_prune_user_posts.php,v 1.4 2003/10/05 01:10:18 rasadam Exp $: 

*******************************************************************/

/*******************************************************************

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the 
Free Software Foundation Inc., 59 Temple Place, Suite 330,
Boston, MA  02111-1307  USA

*******************************************************************/

/************* Planned things *************
	[Who to prune?] (Radio check one of the following)
		[Select user to Prune]
		[Select all users]
		[Select banned users]
		[Select group of users to Prune]
		[Select IP (Specific, Wildcard or Range) to prune]
		[Select banned IPs]
		[Select all guest postings]	
	
	[Where to prune from?]
		[Select individual forums] (Or check all)

	[Prune by date] (Radio check one of the three)
		[Before/After a certain amount of time?] field with drop down box of Seconds, Minutes, Hours, Days, Weeks, Months, Years
		[Before/After a certain date?] dd/mm/yy
		[From a specific date to another?] dd/mm/yy to dd/mm/yy
		[All posts]

	[Options]
		[Remove entire topic if started by user?]
		[Exempt Stickies?]
		[Exempt Announcements?]
		[Exempt Open Topics?]
		[Adjust post counts?]
		[Update search tables?]
*/

define('IN_PHPBB', 1);
if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Users']['Prune_Posts'] = $filename;
	return;
}

// Load default header
$phpbb_root_path = "../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// Langauge File
include($phpbb_root_path.'language/lang_' . $board_config['default_lang'] . '/lang_prune_user_posts.'.$phpEx);

// Search functions
include($phpbb_root_path . 'includes/functions_search.'.$phpEx);

$page_title = $lang['Prune_user_posts'];

// Incase we end up with a large forum
@set_time_limit(300);

// did they press the big red button?
if( !isset($HTTP_POST_VARS['submit']) )
{
	// Set template name
	$template->set_filenames(array(
		"body" => "admin/admin_prune_user_posts.tpl")
	);
	
	// Select all non user groups
	$sql = "SELECT group_id, group_name
				FROM ".GROUPS_TABLE."
					WHERE group_single_user = 0
						ORDER BY group_name";
	
	$result = $db->sql_query($sql);
			
	if ( !$result )
	{
		message_die(CRITICAL_ERROR, 'Could not obtain group information', '', __LINE__, __FILE__, $sql);
	}
	
	// If none exist
	if( $db->sql_numrows($result) == 0 )
	{
		$group_list = '<i>'.$lang['No_groups_exist'].'</i>';
	}
	else
	{
		// Activate block
		$template->assign_block_vars('switch_groups', array());
		
		$group_list = '<select name="prune_group">';
		
		// Loop through groups
		while( $row = $db->sql_fetchrow($result) )
		{
			$group_list .= '<option value="'.$row['group_id'].'">'.$row['group_name'].'</option>';
		}
		
		$group_list .= '</select>';
	}
	
	// See if there are any banned users
	$sql = "SELECT COUNT(ban_id) as numrows
				FROM ".BANLIST_TABLE."
					WHERE ban_userid <> 0";
	
	$result = $db->sql_query($sql);
			
	if ( !$result )
	{
		message_die(CRITICAL_ERROR, 'Could not obtain banned users information', '', __LINE__, __FILE__, $sql);
	}
	
	$banned_users_count = $db->sql_fetchrow($result);
	
	if($banned_users_count['numrows'] != 0)
	{
		$template->assign_block_vars('switch_banned_users', array());
	}
	
	// See if there are any banned ips
	$sql = "SELECT COUNT(ban_id) as numrows
				FROM ".BANLIST_TABLE."
					WHERE ban_userid = 0";
	
	$result = $db->sql_query($sql);
			
	if ( !$result )
	{
		message_die(CRITICAL_ERROR, 'Could not obtain banned IPs information', '', __LINE__, __FILE__, $sql);
	}
	
	$banned_ips_count = $db->sql_fetchrow($result);
	
	if($banned_ips_count['numrows'] != 0)
	{
		$template->assign_block_vars('switch_banned_ips', array());
	}		
		
	$template->assign_vars(array(
		'L_PRUNE_USER_POSTS' => $lang['Prune_user_posts'],
		'L_PRUNE_EXPLAIN' => $lang['Prune_explain'],
		'L_PRUNE_FORUMS' => $lang['Forums_to_prune'],
		'L_PRUNE_FORUMS_EXPLAIN' => $lang['Forums_to_prune_explain'],
		'L_MARK_ALL' => $lang['Mark_all'],
		'L_UNMARK_ALL' => $lang['Unmark_all'],
		'L_PRUNE_USERS' => $lang['Users_to_prune'],
		'L_USERNAME' => $lang['Username'],
		'L_FIND_A_USERNAME' => $lang['Find_username'],
		'L_USERNAME_EXPLAIN' => $lang['Username_explain'],
		'L_ALL_USERS' => $lang['All_users'],
		'L_ALL_USERS_EXPLAIN' => $lang['All_users_explain'],
		'L_BANNED_USERS' => $lang['Banned_users'],
		'L_BANNED_USERS_EXPLAIN' => $lang['Banned_users_explain'],
		'L_GROUP' => $lang['Group'],
		'L_GROUP_EXPLAIN' => $lang['Group_explain'],
		'L_IP_ADDRESS' => $lang['IP_Address'],
		'L_IP_EXPLAIN' => $lang['IP_explain'],
		'L_BANNED_IPS' => $lang['Banned_IPs'],
		'L_BANNED_IPS_EXPLAIN' => $lang['Banned_IPs_explain'],
		'L_GUESTS' => $lang['Guest_posters'],
		'L_GUESTS_EXPLAIN' => $lang['Guest_posters_explain'],
		'L_DATE_CRITERIA' => $lang['Date_criteria'],
		'L_BEFORE' => $lang['Before'],
		'L_ON' => $lang['On'],
		'L_AFTER' => $lang['After'],
		'L_THE_LAST' => $lang['the_last'],
		'L_SECONDS' => $lang['Seconds'],
		'L_MINUTES' => $lang['Minutes'],
		'L_HOURS' => $lang['Hours'],
		'L_DAYS' => $lang['Days'],
		'L_BY_TIME_EXPLAIN' => $lang['By_time_explain'],
		'L_DATE' => $lang['Date'],
		'L_DDMMYYYY' => $lang['ddmmyyyy'],
		'L_DATE_EXPLAIN' => $lang['Date_explain'],
		'L_FROM' => $lang['From'],
		'L_TO' => $lang['to'],
		'L_RANGE_EXPLAIN' => $lang['Range_explain'],
		'L_ALL_POSTS' => $lang['All_Posts'],
		'L_ALL_POSTS_EXPLAIN' => $lang['All_posts_explain'],
		'L_PRUNING_OPTIONS' => $lang['Pruning_options'],
		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],
		'L_REMOVE_TOPICS' => $lang['Prune_remove_topics'],
		'L_REMOVE_TOPICS_EXPLAIN' => $lang['Prune_remove_topics_explain'],
		'L_EXEMPT_STICKIES' => $lang['Exempt_stickies'],
		'L_EXEMPT_STICKIES_EXPLAIN' => $lang['Exempt_stickies_explain'],
		'L_EXEMPT_ANNOUNCEMENTS' => $lang['Exempt_announcements'],
		'L_EXEMPT_ANNOUNCEMENTS_EXPLAIN' => $lang['Exempt_announcements_explain'],
		'L_EXEMPT_OPEN' => $lang['Exempt_open'],
		'L_EXEMPT_OPEN_EXPLAIN' => $lang['Exempt_open_explain'],
		'L_EXEMPT_POLLS' => $lang['Exempt_polls'],
		'L_EXEMPT_POLLS_EXPLAIN' => $lang['Exempt_polls_explain'],
		'L_ADJUST_COUNTS' => $lang['Adjust_post_counts'],
		'L_ADJUST_COUNTS_EXPLAIN' => $lang['Adjust_post_counts_explain'],
		'L_UPDATE_SEARCH' => $lang['Update_search'],
		'L_UPDATE_SEARCH_EXPLAIN' => $lang['Update_search_explain'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		
		'GROUP_LIST' => $group_list,
		
		'S_SEARCH_ACTION' => append_sid($phpbb_root_path.'search.php?mode=searchuser'),		
		'S_PRUNE_ACTION' => append_sid("admin_prune_user_posts.php"))
	);
	
	// Will hold var with all the forums (total)
	unset($forums);
	
	// Select all categories
	$sql = "SELECT cat_id, cat_title
				FROM ".CATEGORIES_TABLE."
					ORDER BY cat_order ASC";

	$result = $db->sql_query($sql);
			
	if ( !$result )
	{
		message_die(CRITICAL_ERROR, 'Could not obtain category information', '', __LINE__, __FILE__, $sql);
	}
	
	$cat_rows = $db->sql_numrows($result);
	
	// If no categories exist
	if($cat_rows == 0)
	{
		message_die(GENERAL_MESSAGE, $lang['No_forums']);
	}

	$cat_data = $db->sql_fetchrowset($result);

	// Loop through categories
	for( $i = 0; $i < $cat_rows; $i++ )
	{
		// Select forums in this category
		$sql = "SELECT forum_id, forum_name
					FROM ".FORUMS_TABLE."
						WHERE cat_id = ".$cat_data[$i]['cat_id']."
							ORDER BY forum_order ASC";
		
		$result = $db->sql_query($sql);
				
		if ( !$result )
		{
			message_die(CRITICAL_ERROR, 'Could not obtain forum information', '', __LINE__, __FILE__, $sql);
		}
		
		$forum_rows = $db->sql_numrows($result);
		
		$forums += $forum_rows;
		
		// If no categories exist
		if($forum_rows != 0)
		{
			// Start category block
			$template->assign_block_vars('catrow', array(
				'CATEGORY_NAME' =>  $cat_data[$i]['cat_title'])
			);
			
			$class = 2;
			
			while( $forum_data = $db->sql_fetchrow($result) )
			{
				// For alternating row classes
				$class = ( $class == 2 ) ? 1 : 2;
				
				$template->assign_block_vars('catrow.forumrow', array(
					'ROW_CLASS' => $class,
					'FORUM_ID' => $forum_data['forum_id'], 
					'FORUM_NAME' => $forum_data['forum_name'])
				);
			}			
		}
	}
	
	// If there were no forums
	if($forums == 0)
	{
		message_die(GENERAL_MESSAGE, $lang['No_forums']);
	}
}
else
{
	unset($users);
	$users = Array();
	// Okay here's the progress of deletion. We will be dealing with one user at a time
	// Step 1: Let's sort out the users we are pruning
	// Step 2: Let's sort out which forums we are pruning
	// 
	// Step 3: Get posts
	// Step 4: Determine if the said user is the topic post and whether we need to delete the topic or not

	// Figure out what users (criteria) are we pruning
	switch($HTTP_POST_VARS['prune_type'])
	{
		case 'user':
			// If we are pruning a specific user.

			// Find the username
			$sql = "SELECT user_id
						FROM ".USERS_TABLE."
							WHERE username = '".addslashes(trim($HTTP_POST_VARS['username']))."'";
			
			$result = $db->sql_query($sql);
			
			if ( !$result )
			{
				message_die(CRITICAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
			}
			
			// If the user doesn't exist
			if($db->sql_numrows($result)==0)
			{
				message_die(GENERAL_MESSAGE, $lang['No_such_user']);
			}
				
			$row = $db->sql_fetchrow($result);
			
			// Set the query to get the posts for this user
			$users[]['user_id'] = $row['user_id'];
			
			break;
		case 'all_users':
			// Pruning all users
		
			$sql = "SELECT user_id
						FROM ".USERS_TABLE;
			
			$result = $db->sql_query($sql);
			
			if ( !$result )
			{
				message_die(CRITICAL_ERROR, 'Could not select all users', '', __LINE__, __FILE__, $sql);
			}
			
			// Lets loop through all the users and set the ids in the main array
			while( $row = $db->sql_fetchrow($result) )
			{
				$users[]['user_id'] = $row['user_id'];	
			}
			
			break;
		case 'banned_users':
			// Pruning [posts for all users in the ban list (Only the users themselves)
			$sql = "SELECT ban_userid
						FROM ".BANLIST_TABLE."
							WHERE ban_userid <> 0";
			
			$result = $db->sql_query($sql);
			
			if ( !$result )
			{
				message_die(CRITICAL_ERROR, 'Could not query ban lists table', '', __LINE__, __FILE__, $sql);
			}
			
			// If the user doesn't exist
			if($db->sql_numrows($result)==0)
			{
				message_die(GENERAL_MESSAGE, $lang['No_banned_users']);
			}
			
			// Lets loop through all the users and set the ids in the main array
			while( $row = $db->sql_fetchrow($result) )
			{
				$users[]['user_id'] = $row['ban_userid'];	
			}
			
			break;
		case 'group':
			// Prune users in a specific group
			
			$group_id = intval($HTTP_POST_VARS['prune_group']);
			
			// Let's make sure the group exists
			$sql = "SELECT COUNT(group_id) as numrows
						FROM ".GROUPS_TABLE."
							WHERE group_id = ".$group_id." AND group_single_user = 0";
			
			$result = $db->sql_query($sql);
			
			if ( !$result )
			{
				message_die(CRITICAL_ERROR, 'Could not query groups table', '', __LINE__, __FILE__, $sql);
			}
			
			$row = $db->sql_fetchrow($result);
			
			if($row['numrows']==0)
			{
				message_die(GENERAL_MESSAGE, $lang['Group_not_exist']);
			}
			
			// Now let's get the users from this group
			$sql = "SELECT user_id
						FROM ".USER_GROUP_TABLE."
							WHERE group_id = $group_id AND user_pending = 0";
			
			$result = $db->sql_query($sql);
			
			if ( !$result )
			{
				message_die(CRITICAL_ERROR, 'Could not query user groups table', '', __LINE__, __FILE__, $sql);
			}
			
			// If the user doesn't exist
			if($db->sql_numrows($result)==0)
			{
				message_die(GENERAL_MESSAGE, $lang['No_group_members']);
			}
			
			// Lets loop through all the users and set the ids in the main array
			while( $row = $db->sql_fetchrow($result) )
			{
				$users[]['user_id'] = $row['user_id'];	
			}
			
			break;
		case 'ip':
			// Prune IP address (Specific, Wildcards or Ranges)
			
			// Remove any whitespace
			$HTTP_POST_VARS['prune_ip'] = trim($HTTP_POST_VARS['prune_ip']);
			
			// Let's see if they entered a full valid IPv4 address
			if( preg_match('/^([0-9]{1,2}|[0-2][0-9]{0,2})(\.([0-9]{1,2}|[0-2][0-9]{0,2})){3}$/', $HTTP_POST_VARS['prune_ip']) )
			{
				// Encode the ip into hexademicals
				$ip = encode_ip($HTTP_POST_VARS['prune_ip']);
				
				// Because we will be deleting based on IP's, we will store the encoded IP alone
				$users[]['user_ip'] = $ip;
			}
			// We will also support wildcards, is this an xxx.xxx.* address?
			else if( preg_match('/^([0-9]{1,2}|[0-2][0-9]{0,2})(\.([0-9]{1,2}|[0-2][0-9]{0,2})){0,2}\.\*/', $HTTP_POST_VARS['prune_ip']) )
			{
				// Alright, now we do the ugly part, converting them to encoded ips
				// We need to deal with the three ways it can be done
				// xxx.*
				// xxx.xxx.*
				// xxx.xxx.xxx.*
				
				// First we will split the IP into its quads
				$ip_split = explode('.', $HTTP_POST_VARS['prune_ip']);
				
				// Now we'll work with which type of wildcard we have
				switch( count($ip_split) )
				{
					// xxx.xxx.xxx.*
					case 4:
						// We will encode the ip into hexademical quads
						$users[]['user_ip'] = encode_ip($ip_split[0].".".$ip_split[1].".".$ip_split[2].".255");
						break;
					// xxx.xxx.*
					case 3:
						// We will encode the ip into hexademical quads again..
						$users[]['user_ip'] = encode_ip($ip_split[0].".".$ip_split[1].".255.255");
						break;
					// xxx.*
					case 2:
						// We will encode the ip into hexademical quads again again....
						$users[]['user_ip'] = encode_ip($ip_split[0].".255.255.255");
						break;
				}			
			}
			// Lastly, let's see if they have a range in the last quad, like xxx.xxx.xxx.xxx - xxx.xxx.xxx.yyy
			else if( preg_match('/^([0-9]{1,2}|[0-2][0-9]{0,2})(\.([0-9]{1,2}|[0-2][0-9]{0,2})){3}(\s)*-(\s)*([0-9]{1,2}|[0-2][0-9]{0,2})(\.([0-9]{1,2}|[0-2][0-9]{0,2})){3}$/', $HTTP_POST_VARS['prune_ip']) )
			{
				// We will split the two ranges
				$range = preg_split('/[-\s]+/', $HTTP_POST_VARS['prune_ip']);
				
				// This is where break the start and end ips into quads
				$start_range = explode('.', $range[0]);
				$end_range = explode('.', $range[1]);
				
				// Confirm if we are in the same subnet or the last quad in the beginning range is greater than the last in the ending range
				if( ($start_range[0].$start_range[1].$start_range[2] != $end_range[0].$end_range[1].$end_range[2]) || ($start_range[3] > $end_range[3]) )
				{
					message_die(GENERAL_MESSAGE, $lang['Prune_invalid_range']);
				}
				
				// Ok, we need to store each IP in the range..
				for( $i = $start_range[3]; $i <= $end_range[3]; $i++ )
				{
					// let's put it in the big array..
					$users[]['user_ip'] = encode_ip($start_range[0].".".$start_range[1].".".$start_range[2].".".$i);
				}
			}
			// This is not a valid IP based on what we want..
			else
			{
				message_die(GENERAL_MESSAGE, $lang['Prune_invalid_IP']);
			}
			break;
		case 'banned_ips':
			// We'll be taking all the banned IPs			
			$sql = "SELECT ban_ip
						FROM ".BANLIST_TABLE;
			
			$result = $db->sql_query($sql);
			
			if ( !$result )
			{
				message_die(CRITICAL_ERROR, 'Could not query ban lists table', '', __LINE__, __FILE__, $sql);
			}
			
			// If there are no IPs
			if($db->sql_numrows($result)==0)
			{
				message_die(GENERAL_MESSAGE, $lang['No_banned_IPs']);
			}
			
			// Looping through all the IPs to add them to the big array
			while( $row = $db->sql_fetchrow($result) )
			{
				$users[]['user_ip'] = $row['ban_ip'];	
			}
			
			break;
		case 'guest_users':
			$users[]['user_id'] = -1;
			break;
		default:
			message_die(GENERAL_MESSAGE, $lang['Prune_invalid_mode']);
	}
			
	// Step 2
	
	// Let's get the forums and see which we are pruning for
	$sql = "SELECT forum_id
				FROM ".FORUMS_TABLE;
	
	$result = $db->sql_query($sql);
			
	if ( !$result )
	{
		message_die(CRITICAL_ERROR, 'Could not query forums table', '', __LINE__, __FILE__, $sql);
	}
	
	// Var that will hold the where part of our query that will select posts we are pruning
	$where_sql = '';
	
	$forums_to_update = Array();
	
	// Loop through forums that exists
	while( $row = $db->sql_fetchrow($result) )
	{
		// If we have to prune this forum
		if( $HTTP_POST_VARS['prune_forumid_'.$row['forum_id']] == 'true' )
		{
			$forums_to_update[$row['forum_id']] = true;
			
			// If we haven't started the where SQL yet
			if( empty($where_sql) )
			{
				$where_sql .= 'WHERE t.topic_id = p.topic_id AND ( t.forum_id = '.$row['forum_id'];
			}
			else
			{
				$where_sql .= ' OR t.forum_id = '.$row['forum_id'];
			}
		}				
	}
	
	// If we matched no forums, we can't prune anything
	if( empty($where_sql) )
	{
		message_die(GENERAL_MESSAGE, $lang['No_forums_selected']);
	}
	
	// Close of bracket we started
	$where_sql .= ' )';
	
	// (Exempts)
	// Are we going to prune stickies? 
	if( $HTTP_POST_VARS['prune_stickies'] == 'true' )
	{
		$where_sql .= ' AND t.topic_type <> '.POST_STICKY;
	}
	
	// Are we going to prune announcements?
	if( $HTTP_POST_VARS['prune_announcements'] == 'true' )
	{
		$where_sql .= ' AND t.topic_type <> '.POST_ANNOUNCE;
	}
	
	// How about open topics?
	if( $HTTP_POST_VARS['prune_open'] == 'true' )
	{
		$where_sql .= ' AND t.topic_status <> '.TOPIC_UNLOCKED;
	}

	// How about polls?
	if( $HTTP_POST_VARS['prune_polls'] == 'true' )
	{
		$where_sql .= ' AND t.topic_vote <> 0';
	}

	// Let's sort out dates now
	switch( $HTTP_POST_VARS['prune_date_type'] )
	{
		// We are pruning before are certain amount of time
		case 'time':
			$time_value = intval($HTTP_POST_VARS['prune_time_value']);
			
			switch($HTTP_POST_VARS['prune_time_type'])
			{
				case 'seconds':
					$unix_time = ( time() - $time_value );
					break;
				case 'minutes':
					$unix_time = ( time() - ( $time_value * 60 ) );
					break;
				case 'hours':
					$unix_time = ( time() - ( $time_value * 3600 ) );
					break;
				case 'days':
					$unix_time = ( time() - ( $time_value * 86400 ) );
					break;
				default:
					message_die(GENERAL_MESSAGE, $lang['Prune_invalid_mode']);
			}

			// Are we pruning before or after this time?
			if( $HTTP_POST_VARS['prune_time_order'] == 'before' )
			{
				$operator = '<';
			}
			else
			{
				$operator = '>';
			}
			
			$where_sql .= ' AND p.post_time '.$operator.' '.$unix_time;
			break;
		case 'by_date':
			$date = trim($HTTP_POST_VARS['prune_dateby_value']);
			
			// Is this a valid dd/mm/yyyy (note year is limited from 1970 - 2038 (Current 4 bit unix timestamp limits) 	
			if( preg_match('/^(0?[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})\/(0?[1-9]{1}|1[0-2]{1})\/(19[7-9]{1}[0-9]{1}|20([0-2]{1}[0-9]{1}|3[0-8]{1}))$/', $date) )
			{
				$date_split = explode('/', $date);
				
				// Let's make the time for this date
				$unix_time = mktime(0,0,0,$date_split[1],$date_split[0],$date_split[2]);
				
				// If this date is invalid
				if($unix_time == 0)
				{
					message_die(GENERAL_MESSAGE, $lang['Prune_invalid_date']);
				}
			}
			else
			{
				message_die(GENERAL_MESSAGE, $lang['Prune_invalid_date']);
			}
			
			unset($operator);
			
			// Are we pruning before or after this date?
			if( $HTTP_POST_VARS['prune_dateby_type'] == 'before' )
			{
				$operator = '<';
			}
			else if( $HTTP_POST_VARS['prune_dateby_type'] == 'after' )
			{
				$operator = '>';
				$unix_time += 86400;
			}
			
			if( isset($operator) )
			{
				$where_sql .= ' AND p.post_time '.$operator.' '.$unix_time;
			}
			else
			{
				$where_sql .= ' AND p.post_time > '.$unix_time.' AND p.post_time < ('.$unix_time.' + 86399)';
			}
			
			break;
		case 'range':
			// from dd/mm/yyyy to dd/mm/yyyy
			$start_range = trim($HTTP_POST_VARS['prune_daterange_start']);
			$end_range = trim($HTTP_POST_VARS['prune_daterange_stop']);
			
			// Is this a valid dd/mm/yyyy (note year is limited from 1970 - 2038 (Current 4 bit unix timestamp limits) 	
			if( preg_match('/^(0?[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})\/(0?[1-9]{1}|1[0-2]{1})\/(19[7-9]{1}[0-9]{1}|20([0-2]{1}[0-9]{1}|3[0-8]{1}))$/', $start_range) )
			{	
				$start_range_split = explode('/', $start_range);
			}
			else
			{
				message_die(GENERAL_MESSAGE, $lang['Prune_invalid_date']);
			}

			// Is this a valid dd/mm/yyyy (note year is limited from 1970 - 2038 (Current 4 bit unix timestamp limits) 	
			if( preg_match('/^(0?[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})\/(0?[1-9]{1}|1[0-2]{1})\/(19[7-9]{1}[0-9]{1}|20([0-2]{1}[0-9]{1}|3[0-8]{1}))$/', $end_range) )
			{	
				$end_range_split = explode('/', $end_range);
			}
			else
			{
				message_die(GENERAL_MESSAGE, $lang['Prune_invalid_date']);
			}
			
			// Get unix timestamp for start range
			$start_range_time = mktime(0,0,0,$start_range_split[1],$start_range_split[0],$start_range_split[2]);
			
			// If the time was invalid
			if($start_range_time == 0)
			{
				message_die(GENERAL_MESSAGE, $lang['Prune_invalid_date']);
			}
			
			// If the start & end are the same, we will prune posts for that day
			if($start_range == $end_range)
			{
				$start_unix = $start_range_time;
				$end_unix = $start_range_time + 86399;
			}
			else
			{
				$end_range_time = mktime(0,0,0,$end_range_split[1],$end_range_split[0],$end_range_split[2]);
				
				// If the start range is greater than the end, we will just reverse..
				if($start_range_time > $end_range_time)
				{
					$start_unix = $end_range_time;
					$end_unix = $start_range_time + 86399;
				}
				else
				{
					$start_unix = $start_range_time;
					$end_unix = $end_range_time + 86399;
				}
			}
			
			$where_sql .= ' AND p.post_time > '.$start_unix.' AND p.post_time < '.$end_unix;
			break;
	}
	
	unset($sql_array);
	
	$sql_array = Array();
	
	for( $i = 0; $i < count($users); $i++ )
	{
		// Are we pruning based on user IDs?
		if( isset($users[$i]['user_id']) )
		{
			$sql_array[] = "SELECT p.post_id, p.topic_id, p.poster_id, p.forum_id, t.topic_poster, t.topic_vote, t.topic_first_post_id, t.topic_last_post_id
							FROM ".POSTS_TABLE." as p, ".TOPICS_TABLE." as t
								".$where_sql." AND p.poster_id = ".$users[$i]['user_id'];
		}
		// Or on IPs
		else
		{
			// Start IP part of where clause
			$ip_sql = ' AND p.poster_ip ';
				
			// Is this IP a range?
			if( preg_match('/(ff){1,3}$/i', $users[$i]['user_ip']) )
			{
				// num.xxx.xxx.xxx
				if( preg_match('/[0-9a-f]{2}ffffff/i', $users[$i]['user_ip']) )
				{
					$ip_start = substr($users[$i]['user_ip'], 0, 2);
				}
				// num.num.xxx.xxx
				else if( preg_match('/[0-9a-f]{4}ffff/i', $users[$i]['user_ip']) )
				{
					$ip_start = substr($users[$i]['user_ip'], 0, 4);
		
				}
				// num.num.num.xxx
				else if( preg_match('/[0-9a-f]{6}ff/i', $users[$i]['user_ip']) )
				{
					$ip_start = substr($users[$i]['user_ip'], 0, 6);		
				}
				
				$ip_sql .= "LIKE '".$ip_start."%'";
			}
			else
			{
				$ip_sql .= "= '".$users[$i]['user_ip']."'";
			}
			
			$sql_array[] = "SELECT p.post_id, p.topic_id, p.poster_id, p.forum_id, t.topic_poster, t.topic_vote, t.topic_first_post_id, t.topic_last_post_id
						FROM ".POSTS_TABLE." as p, ".TOPICS_TABLE." as t
							".$where_sql.$ip_sql;
		}
	}
	
	unset($posts);
	
	// This var will hold all the post ids we will be deleting
	$posts = Array();
	
	// We loop through and get all posts we are doing
	for( $i = 0; $i < count($sql_array); $i++ )
	{
		$result = $db->sql_query($sql_array[$i]);
			
		if ( !$result )
		{
			message_die(CRITICAL_ERROR, 'Could not get posts table data', '', __LINE__, __FILE__, $sql);
		}
		
		if( $db->sql_numrows($result) != 0 )
		{
			while($row = $db->sql_fetchrow($result))
			{
				$posts[] = $row;
			}
		}
	}

	// If there were no posts..
	if( count($posts) == 0 )
	{
		message_die(GENERAL_MESSAGE, $lang['Prune_no_posts']);
	}
	
	// Vars that will hold things we will need to do later
	$posts_to_delete = Array();
	$topics_to_update = Array();
	$topics_to_delete = Array();
	$forums_to_update = Array();
	$users_post_counts = Array();
	
	
	// Let's loop through the posts, essentially, we are going to delete any
	// topics we need to here, including removing topic watches, deleting
	// poll data if neccessary. deleting topic moves.
	// Other considerations - If we are just deleting a post out of a topic,
	// yet a moved topic has this post as its last or first post, we need
	// do delete the move 
	for($i = 0; $i < count($posts); $i++)
	{
		unset($delete_this_topic);
		
		$posts_to_delete[$posts[$i]['post_id']] = $posts[$i]['poster_id'];
		$forums_to_update[$posts[$i]['forum_id']] = 'true';
		
		// If we haven't had this topic to delete yet
		if( !isset($topics_to_delete[$posts[$i]['topic_id']]) )
		{		
			// Okay, this guy posted the topic
			if($posts[$i]['topic_first_post_id'] == $posts[$i]['post_id'])
			{
				// This is the sole post of the topic, so we are deleting for sure
				if($posts[$i]['topic_first_post_id'] == $posts[$i]['topic_last_post_id'])
				{
					$delete_this_topic = true;
				}
				
				// If we are to delete topics by this guy/gal/it
				if($HTTP_POST_VARS['prune_topic_started'] == 'true')
				{
					$delete_this_topic = true;
				}			
			}
		}
		
		// Do stuff that's going to mark this topic as to be deleted (and its posts)
		if($delete_this_topic == true)
		{		
			// Mark posts in topic for deletion (if there are other posts in this thread)
			if($posts[$i]['topic_last_post_id'] != $posts[$i]['topic_last_post_id'])
			{
				$sql = "SELECT post_id, poster_id
							FROM ".POSTS_TABLE."
								WHERE topic_id = ".$posts[$i]['topic_id'];
				
			
				$result = $db->sql_query($sql);
				
				if ( !$result )
				{
					message_die(CRITICAL_ERROR, 'Could not query topics table', '', __LINE__, __FILE__, $sql);
				}

				while( $row = $db->sql_fetchrow($result) )	
				{
					$posts_to_delete[$row['post_id']] = $row['poster_id'];
				}
			}
			
			// Mark topic for deletion
			$topics_to_delete[$posts[$i]['topic_id']] = $posts[$i]['topic_vote'];
		}
		else if( !isset($topics_to_delete[$posts[$i]['topic_id']]) )
		{		
			// Mark topic for updating
			$topics_to_update[$posts[$i]['topic_id']] = $posts[$i]['topic_vote'];
		}
	}
	
	// Var that will hold post ids for the IN clause
	$post_ids_sql = '';
	
	// Record post ids, record post count
	foreach($posts_to_delete as $post_id => $user_id)
	{		
		if($post_ids_sql == '')
		{
			$post_ids_sql .= $post_id;
		}
		else
		{
			$post_ids_sql .= ', '.$post_id;
		}
		
		// Decrement post count for this user
		if( !isset($users_post_counts[$user_id]) )
		{
			$users_post_counts[$user_id] = 1;
		}
		else
		{
			$users_post_counts[$user_id]++;
		}
	}
	
	// Query to delete post table data
	$sql = "DELETE FROM ".POSTS_TABLE."
				WHERE post_id IN (".$post_ids_sql.")";

	if(	!$db->sql_query($sql) )
	{
		message_die(CRITICAL_ERROR, 'Could not delete posts table data', '', __LINE__, __FILE__, $sql);
	}
		
	// Query to delete posts text table data
	$sql = "DELETE FROM ".POSTS_TEXT_TABLE."
				WHERE post_id IN (".$post_ids_sql.")";
		
	if(	!$db->sql_query($sql) )
	{
		message_die(CRITICAL_ERROR, 'Could not delete posts text table data', '', __LINE__, __FILE__, $sql);
	}
	
	// If we're going to update the search tables
	if( $HTTP_POST_VARS['prune_update_search'] == 'true' )
	{
		remove_search_post($post_ids_sql);
	}
	
	// Update topic replies, first and last post id
	foreach( $topics_to_update as $topic_id => $topic_vote )
	{
		// Check to see if any posts exist for this topic anymore
		$sql = "SELECT COUNT(post_id) as numrows
					FROM ".POSTS_TABLE."
						WHERE topic_id = ".$topic_id;
		
		$result = $db->sql_query($sql);
				
		if ( !$result )
		{
			message_die(CRITICAL_ERROR, 'Could not count posts data', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);
		
		// If no posts exist for this topic, we will delete it later
		if($row['numrows'] == 0)
		{
			$topics_to_delete[$topic_id] = $topic_vote;
		}
		else
		{
			// If there's one post in this topic
			if($row['numrows'] == 1)
			{
				$sql = "SELECT post_id, poster_id, post_time
							FROM ".POSTS_TABLE."
								WHERE topic_id = ".$topic_id;
				
				$result = $db->sql_query($sql);
				
				if ( !$result )
				{
					message_die(CRITICAL_ERROR, 'Could not select post data', '', __LINE__, __FILE__, $sql);
				}
		
				$post_data = $db->sql_fetchrow($result);
				
				$update_sql = "topic_poster = ".$post_data['poster_id'].", topic_time = ".$post_data['post_time'].", topic_replies = 0, topic_first_post_id = ".$post_data['post_id'].", topic_last_post_id = ".$post_data['post_id'];
			}
			else
			{
				// Selecting first post
				$sql = "SELECT post_id, poster_id, post_time
							FROM ".POSTS_TABLE."
								WHERE topic_id = ".$topic_id."
									ORDER BY post_time ASC
										LIMIT 0,1";
				
				$result = $db->sql_query($sql);

				if ( !$result )
				{
					message_die(CRITICAL_ERROR, 'Could not select first post data', '', __LINE__, __FILE__, $sql);
				}
		
				$first_post_data = $db->sql_fetchrow($result);
				
				// Selecting last post
				$sql = "SELECT post_id
							FROM ".POSTS_TABLE."
								WHERE topic_id = ".$topic_id."
									ORDER BY post_time DESC
										LIMIT 0,1";
				
				$result = $db->sql_query($sql);
				
				if ( !$result )
				{
					message_die(CRITICAL_ERROR, 'Could not select last post data', '', __LINE__, __FILE__, $sql);
				}
		
				$last_post_data = $db->sql_fetchrow($result);
				
				$update_sql = "topic_poster = ".$first_post_data['poster_id'].", topic_time = ".$first_post_data['post_time'].", topic_replies = ".$row['numrows'].", topic_first_post_id = ".$first_post_data['post_id'].", topic_last_post_id = ".$last_post_data['post_id'];							
			}
			
			// Update the topic and it's shadows
			$sql = "UPDATE ".TOPICS_TABLE."
						SET ".$update_sql."
							WHERE topic_id = ".$topic_id." OR topic_moved_id = ".$topic_id;
			
			if ( !$db->sql_query($sql) )
			{
				message_die(CRITICAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
			}	
		}
	}	
	
	// We will be deleting poll data in aggregate
	$vote_ids_sql = '';
	// Same for the actual topics
	$topic_ids_sql = '';
	
	// Delete topics
	foreach( $topics_to_delete as $topic_id => $topic_vote )
	{
		if($topic_ids_sql == '')
		{
			$topic_ids_sql .= $topic_id;
		}
		else
		{
			$topic_ids_sql .= ', '.$topic_id;
		}
		
		// Checking and removing polls, if this is a poll
		if($topic_vote == 1)
		{
			// We need to get the poll id first
			$sql = "SELECT vote_id
							FROM ".VOTE_DESC_TABLE."
								WHERE topic_id = ".$topic_id;
				
			$result = $db->sql_query($sql);
			
			if ( !$result )
			{
				message_die(CRITICAL_ERROR, 'Could not poll descriptions table', '', __LINE__, __FILE__, $sql);
			}
				
			$poll_data = $db->sql_fetchrow($result);
			
			if($vote_ids_sql == '')
			{
				$vote_ids_sql .= $poll_data['vote_id'];
			}
			else
			{
				$vote_ids_sql .= ', '.$poll_data['vote_id'];
			}
		}
		
		// Select all topic shadows on this topic
		$sql = "SELECT forum_id
					FROM ".TOPICS_TABLE."
						WHERE topic_moved_id = ".$topic_id;
			
		if ( !$result )
		{
			message_die(CRITICAL_ERROR, 'Could not query topics table', '', __LINE__, __FILE__, $sql);
		}
				
		// Mark forum for resyncing
		while( $row = $db->sql_fetchrow($result) )
		{
			$forums_to_update[$row['forum_id']] = 'true';
		}
									
	}
	
	// Actually delete poll data
	if( $vote_ids_sql != '' )
	{
		// Poll descriptions table
		$sql = "DELETE FROM ".VOTE_DESC_TABLE."
					WHERE vote_id IN (".$vote_ids_sql.")";
		
		if( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Could not remove poll descriptions data', '', __LINE__, __FILE__, $sql);
		}		 

		// Poll Results table
		$sql = "DELETE FROM ".VOTE_RESULTS_TABLE."
					WHERE vote_id IN (".$vote_ids_sql.")";
		
		if( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Could not remove poll results data', '', __LINE__, __FILE__, $sql);
		}
		
		// Poll votes table
		$sql = "DELETE FROM ".VOTE_USERS_TABLE."
					WHERE vote_id IN (".$vote_ids_sql.")";
		
		if( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Could not remove poll voters data', '', __LINE__, __FILE__, $sql);
		}
	}
	
	// Actually deleting topic data, shadows & watches
	if( $topic_ids_sql != '' )
	{
		// Watches
		$sql = "DELETE FROM ".TOPICS_WATCH_TABLE."
					WHERE topic_id IN (".$topic_ids_sql.")";		

		if( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Could not remove topic watch data', '', __LINE__, __FILE__, $sql);
		}
		
		// Topics and shadows
		$sql = "DELETE FROM ".TOPICS_TABLE."
					WHERE topic_id IN (".$topic_ids_sql.") OR topic_moved_id IN (".$topic_ids_sql.")";		

		if( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Could not remove topic data', '', __LINE__, __FILE__, $sql);
		}
	}
	
	// Update forum topic counts, post counts, last poster
	foreach( $forums_to_update as $forum_id => $value )
	{	
		// Get forum posts count
		$sql = "SELECT COUNT(post_id) as numrows
					FROM ".POSTS_TABLE."
						WHERE forum_id = ".$forum_id;

		$result = $db->sql_query($sql);
				
		if ( !$result )
		{
			message_die(CRITICAL_ERROR, 'Could not select posts count forum total', '', __LINE__, __FILE__, $sql);
		}
		
		$posts_count = $db->sql_fetchrow($result);
				
		// Get forum topics count
		$sql = "SELECT COUNT(topic_id) as numrows
					FROM ".TOPICS_TABLE."
						WHERE forum_id = ".$forum_id;

		$result = $db->sql_query($sql);
				
		if ( !$result )
		{
			message_die(CRITICAL_ERROR, 'Could not select topics count forum total', '', __LINE__, __FILE__, $sql);
		}
		
		$topics_count = $db->sql_fetchrow($result);
		
		// Select last post in the forum
		$sql = "SELECT post_id
					FROM ".POSTS_TABLE."
						WHERE forum_id = ".$forum_id."
							ORDER BY post_time DESC
								LIMIT 0,1";

		$result = $db->sql_query($sql);
				
		if ( !$result )
		{
			message_die(CRITICAL_ERROR, 'Could not select last post in forum', '', __LINE__, __FILE__, $sql);
		}
		
		if( $db->sql_numrows($result) == 0 )
		{
			$last_post['post_id'] = 0;
		}
		else
		{
			$last_post = $db->sql_fetchrow($result);
		}
		
		// Now update forum data
		$sql = "UPDATE ".FORUMS_TABLE."
					SET forum_posts = ".$posts_count['numrows'].", forum_topics = ".$topics_count['numrows'].", forum_last_post_id = ".$last_post['post_id']."
						WHERE forum_id = ".$forum_id;
				
		if ( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Could not update forum data', '', __LINE__, __FILE__, $sql);
		}
	}
	
	// Update user post counts if we need to
	if( $HTTP_POST_VARS['prune_update_post_counts'] == 'true' )
	{
		foreach( $users_post_counts as $user_id => $post_count )
		{
			$sql = "UPDATE ".USERS_TABLE."
						SET user_posts = user_posts - ".$post_count."
							WHERE user_id = ".$user_id;
				
			if ( !$db->sql_query($sql) )
			{
				message_die(CRITICAL_ERROR, 'Could not update user post count', '', __LINE__, __FILE__, $sql);
			}
	
		}		
	}
	
	$bye_message = sprintf($lang['Prune_finished'],append_sid("admin_prune_user_posts.".$phpEx), append_sid("index.".$phpEx."?pane=right"));
	
	// Say bye bye
	message_die(GENERAL_MESSAGE, $bye_message);
}

// Spit out the page.
$template->pparse("body");

include('page_footer_admin.'.$phpEx);

?>