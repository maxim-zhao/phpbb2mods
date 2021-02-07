<?php     
// MOD START disable search at busy peaks
// Version 1.0.4
// Support and upgrades : See topic at www.phpbb.com
// Author: Ramon Fincken PhpBBinstallers.com

if ( !defined('IN_PHPBB') )
{
   die("Hacking attempt");
}

/////// START  SETTINGS

// Enter the maximum amount of users for ...

// The newposts option..
$disable_newposts_max = 100;

// The search own posts option..
$disable_egosearch_max = 100;   

// The unanswered posts option..
$disable_unanswered_max = 100;

// The find all posts of this author option..
$disable_search_author_max = 100;

// The search.php page ( the page where you enter the search keywords ) ..
$disable_normal_max = 100;

/////// END SETTINGS


/*****  DO NOT EDIT BELOW THIS LINE!!!   **********/




// This is the number of users online right now, including guests and hidden users
// START get total users online count

$user_forum_sql = ( !empty($forum_id) ) ? "AND s.session_page = " . intval($forum_id) : '';
$sql = "SELECT u.username, u.user_id, u.user_allow_viewonline, u.user_level, s.session_logged_in, s.session_ip
	FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
	WHERE u.user_id = s.session_user_id
		AND s.session_time >= ".( time() - 300 ) . "
		$user_forum_sql
	ORDER BY u.username ASC, s.session_ip ASC";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain user/online information', '', __LINE__, __FILE__, $sql);
}

$userlist_ary = array();
$userlist_visible = array();

$prev_user_id = 0;
$disable_users_online_count = 0;

while( $row = $db->sql_fetchrow($result) )
{
	// Skip multiple sessions for one user
	if ( $row['user_id'] != $prev_user_id )
	{
		$disable_users_online_count++;
	}
	$prev_user_id = $row['user_id'];
}
$db->sql_freeresult($result);



// END get total users online count


// Do a check if search_id or search_author GET vars
$disable_count_check = $HTTP_GET_VARS['search_id'].$HTTP_GET_VARS['search_author'];
$disable_count = strlen($disable_count_check);

if($disable_count > 0)
{
	// showtime !
	// search_id or search_author called
	
	if(strlen($HTTP_GET_VARS['search_id']) > 0)
	{
		// $HTTP_GET_VARS['search_id'] called, now handle the individual modes..
		
		if($HTTP_GET_VARS['search_id'] == 'newposts' && $disable_users_online_count > intval($disable_newposts_max)) 
		{
			message_die(GENERAL_MESSAGE, $lang['Currently_disabled']);
		}	
		
		if($HTTP_GET_VARS['search_id'] == 'egosearch' && $disable_users_online_count > intval($disable_egosearch_max)) 
		{
			message_die(GENERAL_MESSAGE, $lang['Currently_disabled']);
		}    
		
		if($HTTP_GET_VARS['search_id'] == 'unanswered' && $disable_users_online_count > intval($disable_unanswered_max))
		{
			message_die(GENERAL_MESSAGE, $lang['Currently_disabled']);
		}
	}
	else
	{
		// $HTTP_GET_VARS['search_author'] called, now handle this ..
		if(strlen($HTTP_GET_VARS['search_author']) > 0 && $disable_users_online_count > intval($disable_search_author_max)) 
		{
			message_die(GENERAL_MESSAGE, $lang['Currently_disabled']);
		}
	}
}
else
{       
	// search.php called, handle basic option so user cannot enter a search query or get a results page..	
	if($disable_users_online_count > intval($disable_normal_max)) 
	{
		message_die(GENERAL_MESSAGE,  $lang['Currently_disabled']);
	}
}






// MOD END disable search at busy peaks
// Version 1.0.4
// Support and upgrades : See topic at www.phpbb.com
// Author: Ramon Fincken PhpBBinstallers.com
?>