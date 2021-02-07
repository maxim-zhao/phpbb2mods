<?php
/***************************************************************************
 *   Page Permissions 1.2.1 Main Code Module (copyright www.phpBBDoctor.com)
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************
 *	Page Permissions Main Code Module (1.1.0)
 *	This file is included at the end of the session handler.
 *	By doing that, it processes every page request that comes
 *	through your phpBB system. It checks that page against
 *	a database table. If the page is matched, then it checks
 *	the "auth" level required to view that page. The "auth"
 *	levels include Public (Guest), Registered, Private,
 *	MOD, and ADMIN. Note that MOD has a loophole; anyone that
 *	has ever been a moderator on your board may have a user_level of
 *	2, even if they are no longer a moderator of anything.
 *	Private requires membership in a group; the page <-> group
 *	matrix is defined in the admin panel.
 *
 *	Now includes a custom disable message for any page (optional).
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

global $db, $phpbb_root_path, $board_config;
global $HTTP_SERVER_VARS;

// Set a function to install all default
// values since it's done several places in the code
function set_default_page_permissions(&$auth_level, &$disable_page, &$group_list, &$min_post_count, &$max_post_count)
{
	$auth_level = PAGE_AUTH_GUEST;
	$disable_page = FALSE;
	$group_list = '0';
	$min_post_count = 0;
	$max_post_count = 0;

	return;
}

// get the pieces we need to work with, including
// the current page name and it's query string
$current_page_parts = pathinfo($HTTP_SERVER_VARS['SCRIPT_NAME']);
$current_page = $current_page_parts['basename'];
$current_query_string = $HTTP_SERVER_VARS['QUERY_STRING'];

// This code was copied from the redirect() function in includes/functions.php
// It seems that passing in the query string without checking for this first
// causes problems, even though the redirect function makes the same exact check.
// Go figure.
if (strstr(urldecode($current_query_string), "\n") || strstr(urldecode($current_query_string), "\r"))
{
	message_die(GENERAL_ERROR, $lang['Page_permissions_insecure_url']);
}

if ( defined('IN_ADMIN') )
{
	$current_page = 'admin/' . $current_page;
}

// BEGIN Cache check code block
// Check for the cache file, if the array isn't
// populated then run a query to get the info
// from the database.
$page_permissions = array();
$board_page_permissions_file = $phpbb_root_path . "cache/cache_page_permissions.$phpEx";
if ( file_exists($board_page_permissions_file) && is_readable($board_page_permissions_file) )
{
	include($board_page_permissions_file);
}

if (count($page_permissions, 1) == 0)
{
	$row_structure = array(
		'page_id' => 'page_id'
	,       'page_name' => 'page_name'
	,       'disable_page' => 'disable_page'
	,       'page_parm_name' => 'page_parm_name'
	,       'page_parm_value' => 'page_parm_value'
	,       'auth_level' => 'auth_level'
	,       'min_post_count' => 'min_post_count'
	,       'max_post_count' => 'max_post_count'
	,       'group_list' => 'group_list'
	,       'disabled_message' => 'disabled_message'
	);

	phpbbdoctor_populate_cache (PAGES_TABLE, $page_permissions, $row_structure, 'page_key');
}
// END cache check code block

// Default to page with no URL
$current_page_key = $current_page;

// cycle through the page permissions array
// getting all page_key values that match the current page name
$page_names = array();
foreach($page_permissions as $key => $value)
{
	if ($page_permissions[$key]['page_name'] == $current_page)
	{
		$page_names[$key] = $page_permissions[$key]['page_name'];
	}
}

// Okay, we have an array of values that match
// the page name, which could be an array of one.
// All we're doing here is validating that the
// current page is even in the array or not.
if (in_array($current_page, $page_names))
{
	foreach ($page_names as $key => $value)
	{
		// This code drops out on the first URL match
		// So be sure to use unique URL parameters if
		// you are going to use this feature. If no
		// URL match then there might be a permissions
		// setting on just the page, if not, use default

		$check_query_string = $page_permissions[$key]['page_parm_name'] . '=' . $page_permissions[$key]['page_parm_value'];

		if ($check_query_string == '=')
		{
			$current_page_key = $current_page;
		}
		elseif (!strpos(' ' . $current_query_string, $check_query_string) === FALSE)
		{
			// we have a winner!
			$current_page_key = $key;
			break;
		}
	}

	// when we get here, we either have a page key that has
	// the format page.php?parm=value or simply page.php, which
	// was set a few lines before this block. This will handle
	// both pages with and without URL's. By default, a check
	// with a URL is assumed to be more strict that a check
	// without one.
	if (array_key_exists($current_page_key, $page_permissions))
	{
		$auth_level = $page_permissions[$current_page_key]['auth_level'];
		$disable_page = $page_permissions[$current_page_key]['disable_page'];
		$disabled_message = $page_permissions[$current_page_key]['disabled_message'];
		if ( $disabled_message == '' )
		{
			$disabled_message = $lang['Page_permissions_page_disabled'];
		}
		$group_list = $page_permissions[$current_page_key]['group_list'];
		$min_post_count = $page_permissions[$current_page_key]['min_post_count'];
		$max_post_count = $page_permissions[$current_page_key]['max_post_count'];
	}
	else
	{
		set_default_page_permissions($auth_level, $disable_page, $group_list, $min_post_count, $max_post_count);
	}
}
else
{
	set_default_page_permissions($auth_level, $disable_page, $group_list, $min_post_count, $max_post_count);
}

// set up default group ID in case none was specified
// this prevents the sql code from failing further on
if ($group_list == '')
{
	$group_list = '0';
}

// Do a little bit of validation, basically what this does is translate
// the group list (which could have come from the cache) into an array,
// apply the intval() function to each value, then return it back to a
// comma separated string.
$group_list = implode(',', array_map('intval', explode(',', $group_list)));

// Short circuit all of the checks if the
// current logged-in user is an ADMIN user
if ($userdata['user_level'] <> ADMIN)
{
	if ( $disable_page )
	{
		message_die (GENERAL_MESSAGE, $disabled_message);
	}

	// Process based on autorization level
	// required by page
	switch ( $auth_level )
	{
		case PAGE_AUTH_GUEST:	// No auth required, skip rest of code
			break;
		case PAGE_AUTH_REG:	// registered users only
			if ( !$userdata['session_logged_in'] )
			{
				redirect(append_sid("login.$phpEx?redirect=" . $current_page .'&'. $current_query_string, true));
			}
			break;
		case PAGE_AUTH_PRIVATE:	// private users only
			if ( !$userdata['session_logged_in'] )
			{
				redirect(append_sid("login.$phpEx?redirect=" . $current_page .'&'. $current_query_string, true));
			}

			// Note: the following SQL will always return exactly one row
			// no matter how many groups (from zero to infinity) a user
			// is a member of. The sign() function returns only a limited
			// set of values, which in this case will always be zero or one.
			$sql = 'SELECT	sign(count(user_id)) AS group_flag
				FROM	' . USER_GROUP_TABLE . '
				WHERE	user_id = ' . $userdata['user_id'] . '
				AND	user_pending = 0
				AND	group_id in (' . $group_list . ')';
			if (!($result = $db->sql_query($sql)) )
			{
				message_die (GENERAL_ERROR, 'DEBUG: Unable to check group membership', '', __LINE__, __FILE__, $sql);
			}

			$row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			if (!($row['group_flag'] == 1))
			{
				message_die (GENERAL_MESSAGE, $lang['Page_permissions_insufficient_privileges']);
			}
			break;
		case PAGE_AUTH_ADMIN:	// Admin required
			if (!($userdata['session_logged_in']))
			{
				redirect(append_sid("login.$phpEx?redirect=" . $current_page . '&' . $current_query_string, true));
			}
			if ($userdata['user_level'] <> ADMIN)
			{
				message_die (GENERAL_MESSAGE, $lang['Page_permissions_insufficient_privileges']);
			}
			break;
		case PAGE_AUTH_MOD:	// Moderator required
			if (!($userdata['session_logged_in']))
			{
				redirect(append_sid("login.$phpEx?redirect=" . $current_page . '&' . $current_query_string, true));
			}
			if ($userdata['user_level'] <> MOD)
			{
				message_die (GENERAL_MESSAGE, $lang['Page_permissions_insufficient_privileges']);
			}
			break;
		default:
			message_die (GENERAL_ERROR, 'DEBUG: Invalid or unknown page permission encountered');
	}

	// We have made it this far, now check for post count
	// values. Note that these could be mutually exclusive,
	// meaning the min requirements could be greater than
	// the max allowed, resulting in a page that nobody can
	// view.
	if (($min_post_count <> 0) && ($userdata['user_posts'] < $min_post_count))
	{
		message_die(GENERAL_MESSAGE, $lang['Page_permissions_post_count_too_low']);
	}
	if (($max_post_count <> 0) && ($userdata['user_posts'] > $max_post_count))
	{
		message_die(GENERAL_MESSAGE, $lang['Page_permissions_pPost_count_too_high']);
	}
}

// If we get here, then the user is auth'd to view
// the page. Check to see if we're incrementing
// page counter and increment is needed.
if (isset($board_config['phpbbdoctor_count_views']))
{
	$count_views = intval($board_config['phpbbdoctor_count_views']);
}
else
{
	$count_views = 1;
}

if ($count_views)
{
	if ($userdata['session_logged_in'])
	{
		$update_col = 'member_views';
	}
	else
	{
		$update_col = 'guest_views';
	}

	$sql = 'UPDATE ' . PAGES_TABLE . '
		SET	' . $update_col . ' = ' . $update_col . ' + 1
		WHERE	page_key = "' . $current_page_key . '"';

	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'DEBUG: Unable to update page view counter');
	}
}

?>
