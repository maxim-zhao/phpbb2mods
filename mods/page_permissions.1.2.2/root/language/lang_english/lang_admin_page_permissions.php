<?php

/***************************************************************************
 *	Page Permissions 1.2.2 Language Module
 *      Original author: Dave Rathbun (copyright www.phpBBDoctor.com)
 *
 *	This is the admin language file for the Page Permissions MOD from
 * 	the phpBBDoctor.com. The external language file was added in version
 *	1.0.2 to dramatically cut down on the number of actual file edits
 *	required to install / upgrade this MOD. By externalizing the language
 *	file it will make it very easy to provide translations.
 *
 *	If you are a translator and would like to translate this file I will
 *	happily host it at www.phpBBDoctor.com. Send me a PM at www.phpbb.com
 *	with your information and I will give you instructions on how and 
 *	where to send me the file(s).
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 ***************************************************************************/

// You know, this isn't really necessary, since there's nothing
// going on here except for a bunch of assignment statements, 
// but why not, it doesn't hurt anything...
if (!defined('IN_PHPBB'))
{
        die('Hacking attempt');
}

// Admin Menu Strings
$lang['phpBBDoctor'] = 'phpBBDoctor';	// Please do NOT translate this line
$lang['Page_permissions'] = 'Page Permissions';

// Basic admin strings
$lang['Click_return_page_admin'] = 'Click %sHere%s to return to Page Permissions Admin';
$lang['Add_new_page'] = 'Add new page';
$lang['No_page_selected'] = 'No page selected';
$lang['No_page_group'] = 'None';
$lang['Unknown_group_type'] = 'Unknown';
$lang['Page_permissions_admin_title'] = 'Page Permissions';
$lang['Page_permissions_element'] = 'Page';

// Database column labels and explanations
$lang['Page_ID'] = 'Page ID (System assigned)';
$lang['Page_name'] = 'Page Name';
$lang['Page_function'] = 'Page Function';
$lang['Guest_views'] = 'Guest Views';
$lang['Guest_views_pct'] = 'Pct';
$lang['Guest_views_explain'] = 'This counter shows how many page views were done by guest viewers. This value may be adjusted in case you want to start over at a certain point.';
$lang['Member_views'] = 'Member Views';
$lang['Member_views_pct'] = 'Pct';
$lang['Member_views_explain'] = 'This counter shows how many page views were done by viewers that were logged on to your board. This value may be adjusted in case you want to start over at a certain point.';
$lang['Page_views'] = 'Page Views';
$lang['Page_views_pct'] = 'Pct';
$lang['Total_page_views'] = 'Total Page Views';
$lang['Page_permissions_explain'] = 'This table lists all site pages that have been added to your page permissions list. The ID is assigned by the system. The page view count is updated each time a page is viewed or refreshed. You can use this page to disable individual pages, set guest view permissions, or require admin access.';
$lang['Disable_page'] = 'Disable?';
$lang['Disable_page_explain'] = 'This option allows you to disable a page without disabling your entire board. Admin-level users will still be able to view / interact with this page but everyone else will receive a message saying that the page is offline. To change this message edit the entry in the main language file instead of the admin version.';
$lang['Auth_level'] = 'Access Level';
$lang['Page_parm_name'] = 'Parameter';
$lang['Page_parm_name_explain'] = 'Some pages have parameters based by GET or POST. If you want to check for a specific value, enter the parameter name to check here. An example might be "mode" for the profile page. You might want to set different permissions for "register" than you would for "viewprofile" or other values. Note that you do <b>not</b> have to define all possible parameter values, only those that you want to track or assign permissions to.';
$lang['Page_parm_value'] = 'Value (Required if Parameter is provided)';
$lang['Min_post_count'] = 'Min Posts';
$lang['Min_post_count_explain'] = 'A non-zero value here means that a user must have a minimum post count in order to view a page. As an example, this would allow you to set a minimum number of posts to view the memberlist or even a specific forum.';
$lang['Max_post_count'] = 'Max Posts';
$lang['Max_post_count_explain'] = 'A non-zero value here means that a user must have less than a set number of posts in order to view the page. Be careful that your max post count is higher than your min post count or you will have created a page that nobody can view. An administrator can always view the page.';
$lang['Page_group'] = 'Group Access Allowed';
$lang['Page_group_explain'] = 'Select one or more groups allowed to access this page. Note that this information is only used for access level <b>Private</b>';

// Permission Levels
$lang['Permission_public'] = 'Public';
$lang['Permission_registered'] = 'Registered';
$lang['Permission_private'] = 'Private';
$lang['Permission_moderator'] = 'Moderator';
$lang['Permission_administrator'] = 'Administrator';

// Standard actions
$lang['Updated'] = ' Updated ';
$lang['Inserted'] = ' Inserted ';
$lang['Deleted'] = ' Deleted ';
$lang['Click_return_list'] = 'Click %sHere%s to return to %s list';
$lang['Rebuild_cache'] = 'Rebuild cache';
$lang['Cache_updated'] = ' cache updated';

// Added when we included ability to turn page view counts on or off
// via board_config entry
$lang['Page_view_count_is'] = 'Page view count is ';
$lang['Count_views'] = 'Increment page view counters: ';
$lang['Save_count_views'] = ' Save ';

// Added when we included ability to enable / disable pages on main list
$lang['Update_selected_pages'] = 'Update Selected Pages';
$lang['1_page_enabled'] = 'There was 1 page enabled';
$lang['1_page_disabled'] = 'There was 1 page disabled';
$lang['X_pages_enabled'] = 'There were %d pages enabled';
$lang['X_pages_disabled'] = 'There were %d pages disabled';

// Added to provide custom disable message for individual pages
$lang['Page_disabled_message'] = 'Disabled Message';
$lang['Page_disabled_message_explain'] = 'Enter a string that will be displayed if this page is disabled. If left empty, a default message will be provided instead. Note that this string will always be displayed in the language you enter, it does not currently provide for translated values.';
// END Page Permissions (www.phpBBDoctor.com)

?>
