##############################################################
## MOD Title: Defualt Post Sort Order
## MOD Author: geocator < geocator@gmail.com > (Brian) http://www.geocator.us
## MOD Description: Allows admin to specify post sort order by forum
## MOD Version: 1.1.1c
## 
## Installation Level: Easy
## Installation Time: 11 minutes
## Files To Edit: viewtopic.php
##                admin/admin_forums.php
##                language/lang_english/lang_admin.php
##                templates/subSilver/admin/forum_edit_body.tpl
## Included Files: avc_post_sort_order.php
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2108.38030 ]
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
##############################################################
## MOD History:
## 
## 2005-12-10 - Version 1.1.1b
##      - Various template realted changes
##	  - Fixed viewtopic bug introduced by one of these template changes
##
## 2005-12-10 - Version 1.1.1b
##      - Various template realted changes
##
## 2005-11-10 - Version 1.1.1.a
##      - Simple MOD template change, affects nothing
##
## 2005-11-10 - Version 1.1.1
##      - Fixed a MOD template issue, cuasing EM to do funny things
##      
## 2005-10-30 - Version 1.1.0
##      - Various 2.0.18 Updates
##      - Added code start and end statements
##      - Added version check
##      - Update to new MOD Template
## 
## 2004-09-24 - Version 1.0.3
##      - Missing sql statement added
## 
## 2004-09-24 - Version 1.0.2
##      - MOD Template syntax change
## 
## 2004-09-22 - Version 1.0.1
##      - Yeah, umm, intval does not work well on strings
## 
## 2004-09-11 - Version 1.0.0
##      - Regular Release
## 
## 2004-09-06 - Version 0.0.3
##      - Assignment Fix
## 
## 2004-08-22 - Version 0.0.2
##      - Pagination Fix
## 
## 2004-08-21 - Version 0.0.1
##      - Initial Release
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE phpbb_forums ADD default_order VARCHAR( 4 ) DEFAULT 'asc' NOT NULL ;

#
#-----[ DIY ]------------------------------------------
#
This file only needs uploading if you use Advanced Version Check (http://www.phpbb.com/phpBB/viewtopic.php?t=277654)
copy admin/avc_mods/avc_post_sort_order.php to admin/avc_mods/avc_post_sort_order.php
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
	$start = floor(($forum_topic_data['prev_posts'] - 1) / intval($board_config['posts_per_page'])) * intval($board_config['posts_per_page']); 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	//START Post Sort Order
	$sql = "SELECT default_order
			FROM " . FORUMS_TABLE . "
			WHERE forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forum default order', '', __LINE__, __FILE__, $sql);
	}
	
	if ( !($row = $db->sql_fetchrow($result)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forum default order', '', __LINE__, __FILE__, $sql);
	}
	
	$post_order = $row['default_order'];
	

	if ($post_order == 'desc')
	{
		$sql = "SELECT COUNT(post_id) AS total_posts FROM  " . POSTS_TABLE . " WHERE forum_id = $forum_id AND topic_id = $topic_id";
		if ( !($result = $db->sql_query($sql)) )
		{
		message_die(GENERAL_ERROR, "Could not obtain number of posts in topic", '', __LINE__, __FILE__, $sql);
		}
		$total_posts = ( $row = $db->sql_fetchrow($result) ) ? intval($row['total_posts']) : 0;
		$start = floor(($total_posts - $forum_topic_data['prev_posts'] )/ intval($board_config['posts_per_page'])) * intval($board_config['posts_per_page']);
	}
	else
	{
	//END Post Sort Order
#
#-----[ AFTER, ADD ]------------------------------------------
#
	//START Post Sort Order
	} 
	//END Post Sort Order

#
#-----[ FIND ]------------------------------------------
#
else
{
	$post_order = 'asc';
	$post_time_order = 'ASC';
} 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//START Post Sort Order
else
{
	if ( $post_order == 'desc')
	{
		$post_time_order = 'DESC';
	}
//END Post Sort Order
#
#-----[ AFTER, ADD ]------------------------------------------
#
//START Post Sort Order
}
//END Post Sort Order
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_forums.php

#
#-----[ FIND ]------------------------------------------
#
				$forumstatus = $row['forum_status'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
				//START Post Sort Order
				$forumorder = $row['default_order'];
				//END Post Sort Order

#
#-----[ FIND ]------------------------------------------
#
				$forum_id = ''; 
				$prune_enabled = '';

#
#-----[ AFTER, ADD ]------------------------------------------
#
				//START Post Sort Order
				$forumorder = 'asc';
				//END Post Sort Order

#
#-----[ FIND ]------------------------------------------
#
			$statuslist .= "<option value=\"" . FORUM_LOCKED . "\" $forumlocked>" . $lang['Status_locked'] . "</option>\n";

#
#-----[ AFTER, ADD ]------------------------------------------
#
			//START Post Sort Order
			$orderasc = '';
			$orderdesc = '';
			if( $forumorder == 'asc' )
			{
				$orderasc = 'selected="selected"';
			}
			else
			{
				$orderdesc = 'selected="selected"';
			}
			
			$orderlist = '<option value="asc" ' . $orderasc . '>' . $lang['Order_Ascending'] . '</option>\n';
			$orderlist .= '<option value="desc" ' . $orderdesc . '>' . $lang['Order_Descending'] . '</option>\n'; 
			//END Post Sort Order

#
#-----[ FIND ]------------------------------------------
#
				'S_PRUNE_ENABLED' => $prune_enabled,

#
#-----[ AFTER, ADD ]------------------------------------------
#
				//START Post Sort Order
				'S_ORDER_LIST' => $orderlist,
				'L_ORDER' => $lang['Order'],
				//END Post Sort Order

#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . FORUMS_TABLE
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//INLINE Post Sort Order
#
#-----[ IN-LINE FIND ]------------------------------------------
#
forum_status, prune_enable

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, default_order

#
#-----[ FIND ]------------------------------------------
#
			VALUES ('" . $next_id . "',
#
#-----[ IN-LINE FIND ]------------------------------------------
#
intval($HTTP_POST_VARS['prune_enable']) .

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 ", '" . str_replace("\'", "''", $HTTP_POST_VARS['forumorder']) ."'" .

#
#-----[ FIND ]------------------------------------------
#
				$sql = "UPDATE " . FORUMS_TABLE . "
					SET forum_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", forum_desc = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', forum_status = " . intval($HTTP_POST_VARS['forumstatus']) . ", prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//INLINE Post Sort Order
#
#-----[ IN-LINE FIND ]------------------------------------------
#
intval($HTTP_POST_VARS['prune_enable']) . "

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, default_order = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumorder']) . "'

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
//START Post Sort Order
$lang['Order_Ascending']  = 'Oldest First';
$lang['Order_Descending']  = 'Newest First';
$lang['Order']  = 'Post Display Order';
//END Post Sort Order

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/forum_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1">{L_FORUM_STATUS}</td>
	  <td class="row2"><select name="forumstatus">{S_STATUS_LIST}</select></td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<!-- START Post Sort Order -->
	<tr> 
	  <td class="row1">{L_ORDER}</td>
	  <td class="row2"><select name="forumorder">{S_ORDER_LIST}</select></td>
	</tr>
	<!-- ENDD Post Sort Order -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
