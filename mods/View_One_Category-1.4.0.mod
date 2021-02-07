############################################################## 
## MOD Title: View One Category
## MOD Author: eternalsword < N/A > (Micah Bucy) http://cs.wheaton.edu/~mbucy/
## MOD Description: Displays only one category when it's id 
## 					is in the url.  And makes sure the id is
##					a valid id. Displays a different message 
##					if the category id is one that used to 
##					exist but has since been removed.
##
##                  
## 
## MOD Version: 1.4.0
## 
## Installation Level: Easy 
## Installation Time: ~1 Minute 
## Files To Edit: index.php,
## 		language/lang_english/lang_main.php
##
## Included Files: N/A
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
##
##  I'm new to phpBB and this is more for keeping the users in
##	mind.  When they click on a forum, it takes them to a forum
##	page with only that forum.  I figured it should be the same
##	with categories as well.  Users can then bookmark their
##	favorite category and not get the full list (that's what
##	the index is for).  This also detects whether or not the 
##	category id exists.  If it doesn't, a General Error message 
##	appears 
##	+ install time is seriously about ten seconds manually 
##	+ only tested on 2.0.19, should work on other versions
##	but if there are problems on other versions, let my know
##	by pm'ing me at the phpBB.com forums
##
############################################################## 
## MOD History:
## 
## 	2006-03-23 - Version 1.0.1
##		- No longer has a temp value so a performance enhancement
## 	2006-04-13 - Version 1.2.0
##		- Added language support on error message
##		- Updated for phpBB 2.0.20
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
index.php
# 
#-----[ FIND ]------------------------------------------ 
#
while ($row = $db->sql_fetchrow($result))
{
	$category_rows[] = $row;
}
#
#-----[ REPLACE WITH ]------------------------------------------
#
$category_max_id = 0;
while ($row = $db->sql_fetchrow($result))
{
	if ( $row['cat_id'] > $category_max_id )
	{
		$category_max_id = $row['cat_id'];
	}
	$category_rows[] = $row;
}
#
#-----[ FIND ]------------------------------------------ 
# 
	$display_categories = array();
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	// BEGIN MOD View One Category - eternalsword
	//
	for ( $i = 0; $i <= $category_max_id; $i++ )
	{
		$category_exists = ctype_digit($viewcat) && $viewcat == $category_rows[$i]['cat_id'];
		if ( $category_exists )
		{
			break;
		}
	}
	//
	// END MOD View One Category - eternalsword
	//
#
#-----[ FIND ]------------------------------------------ 
# 
			$display_categories[$forum_data[$i]['cat_id']] = true;
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
			//
			// BEGIN MOD View One Category - eternalsword
			//
			if ( $viewcat!=-1 ) 
			{
				if ( !ctype_digit($viewcat) || $category_max_id < $viewcat || 0 > $viewcat )
				{
					message_die(GENERAL_ERROR, sprintf($lang['Category_not_exist'], $viewcat));
				}
				if ( !$category_exists )
				{
					message_die(GENERAL_ERROR, $lang['Category_removed']);
				}
				$display_categories[$forum_data[$i]['cat_id']] = $forum_data[$i]['cat_id'] == $viewcat;
				
			}
			else
			{
				$display_categories[$forum_data[$i]['cat_id']] = true;
			}
			//
			// END MOD View One Category - eternalsword
			//
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
#
//
// Viewforum
//
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

//
// Viewcategory
//
$lang['Category_not_exist'] = '"%s" is not a valid category id.';
$lang['Category_removed'] = 'This category has been removed.';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM 