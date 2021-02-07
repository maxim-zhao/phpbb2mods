############################################################## 
## MOD Title: Latest Topics
## MOD Author: Noobarmy < noobarmy@phpbbmodders.net > (Anthony Chu) http://phpbbmodders.net
## MOD Description: Shows the latest topics a user created
## MOD Version: 1.0.2
## 
## Installation Level: Easy
## Installation Time: 5 Minutes 
## Files To Edit: 
##		viewtopic.php
##		templates/subSilver/viewtopic_body.tpl
##
## Included Files:
##		root/includes/get_topics.php
##
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
## 		There are a few things you can change. These will be 
##		built into an ACP page when i can find time to do so
##
##		Find:
##			get_topics($poster_id, 'topics', -1, 5, 'postrow.topics');
##
##		'topics' can be replace with 'posts' if you wish to display
##		posts rather then topics.
##
##		-1 can be changed into an array or a single no, to be forum
##		specefic.
##		i.e array(1,2,7,9) or simply 9
##
##		5 can be changed to any number greater then 0. It is how
##		many topics are shown.
##
##
##		Support for this mod can only be found at phpbb.com and at
##		phpbbmodders.net, please don't im, pm or email me for support
##		thanks :-)
##
############################################################## 
## MOD History: 
## 
## 	2007-02-13 - Version 1.0.2
##		-	Queries reduced. 
##		-	Posts query fixed
##		-	user_id mess up fixed
##
## 	2006-10-26 - Version 1.0.0
##		-	First submitted
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy root/includes/get_topics.php to includes/get_topics.php

# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
#
$sql = "UPDATE " . TOPICS_TABLE . "
	SET topic_views = topic_views + 1
	WHERE topic_id = $topic_id";
if ( !$db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not update topic views.", '', __LINE__, __FILE__, $sql);
}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	/**
	 * BEGIN latest_topics
	 */
	include($phpbb_root_path . 'includes/get_topics.' . $phpEx);
	$poster_latest = array();
	/**
	 * END latest_topics
	 */

# 
#-----[ FIND ]------------------------------------------ 
# 
}

$template->pparse('body');

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	/**
	 * BEGIN latest_topics
	 */
	$poster_latest[$poster_id] = ( isset($poster_latest[$poster_id]) ) ? $poster_latest[$poster_id] : get_topics($poster_id, 'topics', -1, 5);
	assign_topics($poster_latest[$poster_id], "postrow.topics");
	/**
	 * END latest_topics
	 */

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
$lang['users_topics'] = 'Topics: ';
$lang['no_topics'] = 'Not Posted';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/viewtopic_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span><br /><span class="postdetails">{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}<br /><br />{postrow.POSTER_JOINED}<br />{postrow.POSTER_POSTS}<br />{postrow.POSTER_FROM}</span><br /></td>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
<td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span><br /><span class="postdetails">{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}<br /><br />{postrow.POSTER_JOINED}<br />{postrow.POSTER_POSTS}<br />{postrow.POSTER_FROM}
<br /><br />
<!-- BEGIN topics -->
<a href="{postrow.topics.LINK}">{postrow.topics.TITLE}</a><br />
<!-- END topics -->
</span><br /></td>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM