##############################################################
## MOD Title: Show categories
## MOD Author: Nux < egil -at- wp.pl > (Maciej Jaros) N/A
## MOD Description:
##		Shows categories in forums and topics with links to them.
##		See section 'Author Notes' for more details and manual MOD installtion info.
##		This MOD was tested with EasyMOD 0.2.1a beta (works also for download mode).
##
## MOD Version:   1.0.3b
##
## Installation Level: Easy
## Installation Time: 5 Minutes
##
## Files To Edit: 
##		viewforum.php
##		templates/subSilver/viewforum_body.tpl
##		viewtopic.php
##		templates/subSilver/viewtopic_body.tpl
##
## Included Files:
##		N/A
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
##	
##	+ I was runnig it for over a year now so I guess it's stable :).
##
##	+ The changes in 'viewtopic.php' and viewforum.php are done to 
##	  get the {CATEGORY_NAME} and the link {U_VIEW_CATEGORY}.
##	
##	+ In 'templates/subSilver/viewtopic_body.tpl' and 'templates/subSilver/viewforum_body.tpl'
##	  the only thing added is the {CATEGORY_NAME} with its link {U_VIEW_CATEGORY} 
##	  (modify this as you wish)
## 
##	+ This MOD was tested with EasyMOD 0.2.1a beta (works also for download mode).
##
##	+ For support please use this MOD's topic on http://www.phpbb.com/phpBB/
##	  if you won't be able to contact me through the page you might want to 
##	  mail me at: <egil (at) wp.pl>, but please rather use this MOD's topic.
##
##	Manual MOD installtion info:
##	 + When you find a 'AFTER, ADD'-Statement, the Code have to be added after the last
##	   line quoted in the 'FIND'-Statement.
##	 + When you find a 'BEFORE, ADD'-Statement, the Code have to be added before the
##	   first line quoted in the 'FIND'-Statement.
##	 + When you find a 'REPLACE WITH'-Statement, the Code quoted in the
##	   'FIND'-Statement have to be replaced _completely_ with the quoted Code in the
##	   'REPLACE WITH'-Statement.
##
##	For further details on installing MODs see this Knowledge Base articles:
##	 + How to Install MODs  ->  http://www.phpbb.com/kb/article.php?article_id=150
##	 + Installing a MOD in a safe way  ->  http://www.phpbb.com/kb/article.php?article_id=175
## 
############################################################## 
## MOD History: 
## 
##   2005-08-24 - Version 1.0.3
##      - another RC1 - EMC polishing + testing
##			- Version 1.0.3a - Doesn't work for download mode in EasyMOD 0.2.1a, but should work for 0.2.2 and above.
##			- Version 1.0.3b - Works also for download mode, but doesn't use nicer IN-LINE statements.
##   2005-08-16 - Version 1.0.2
##      - another RC1 - syntax polishing continued + testing
##			- Version 1.0.2a Doesn't work for download mode in EasyMOD!
##			- Version 1.0.2b Works also for download mode, but doesn't use nicer IN-LINE statements.
##   2005-06-30 - Version 1.0.1
##      - another RC1 - some minor mistakes in syntax + extra info + testing, testing, testing...
##			- Version 1.0.1a Doesn't work for download mode in EasyMOD!
##			- Version 1.0.1b Works also for download mode, but doesn't use nicer IN-LINE statements.
##   2005-05-26 - Version 1.0.0
##      - RC1
##   2005-05-10 - Version 0.0.2
##      - the same thing but properly given
##   2004-05-26 - Version 0.0.1
##      - second beta (no changes in lang files required)
##   2004-05-25 - Version 0.0.0
##      - first beta
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]---------------------------------------------
#
viewforum.php

#
#-----[ FIND ]---------------------------------------------
#
# NOTE: You can search just for "// Start session management" to be sure you'll find it.
#
# about line 85
//
// Start session management
//

#
#-----[ BEFORE, ADD ]---------------------------------------------
#
//---------------------------------------------------------------------
// MOD: Show categories :BEGIN
$sql = "SELECT *
	FROM " . CATEGORIES_TABLE . "
	WHERE cat_id = " . $forum_row['cat_id'];
if ( !($result = $db->sql_query($sql)) ) {
	message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
}

//
// If the query doesn't return any rows this isn't a valid forum. Inform
// the user.
//
if ( !($category_row = $db->sql_fetchrow($result)) ) {
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}
// MOD: Show categories :END
//----------------------------------------------------------------------

#
#-----[ FIND ]---------------------------------------------
# about line 399
'FORUM_NAME' => $forum_row['forum_name'],

#
#-----[ AFTER, ADD ]---------------------------------------------
#
//---------------------------------------------------------------------
// MOD: Show categories
'CATEGORY_NAME' => $category_row['cat_title'],

#
#-----[ FIND ]---------------------------------------------
# about line 436
'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL ."=$forum_id"),

#
#-----[ AFTER, ADD ]---------------------------------------------
#
//---------------------------------------------------------------------
// MOD: Show categories
	'U_VIEW_CATEGORY' => append_sid("index.$phpEx?" . POST_CAT_URL ."=". $forum_row['cat_id']),

#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/viewforum_body.tpl

#
#-----[ FIND ]---------------------------------------------
#
# The upper part of links.
#
	  <td align="left" valign="middle" class="nav" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>

#
#-----[ REPLACE WITH ]---------------------------------------------
#
	  <td align="left" valign="middle" class="nav" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> <br />&nbsp;&nbsp;&nbsp;<a class="nav" href="{U_VIEW_CATEGORY}">{CATEGORY_NAME}</a> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>

#
#-----[ FIND ]---------------------------------------------
#
# The lower part of links.
#
	  <td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>

#
#-----[ REPLACE WITH ]---------------------------------------------
#
	  <td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> <br />&nbsp;&nbsp;&nbsp;<a class="nav" href="{U_VIEW_CATEGORY}">{CATEGORY_NAME}</a> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>

#
#-----[ OPEN ]---------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]---------------------------------------------
# about line 148
#
# Note: the whole line should be something like:
# $sql = "SELECT t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments" . $count_sql . "
#
$sql = "SELECT t.topic_id,

#
#-----[ IN-LINE FIND ]---------------------------------------------
#
" . $count_sql . "

#
#-----[ IN-LINE BEFORE, ADD ]---------------------------------------------
#
# Notice the ',' at the beginning
#
, f.cat_id

#
#-----[ FIND ]---------------------------------------------
#
# NOTE: You can search just for "// Start session management" to be sure you'll find it.
#
# about line 164
#
//
// Start session management
//

#
#-----[ BEFORE, ADD ]---------------------------------------------
#
//---------------------------------------------------------------------
// MOD: Show categories :BEGIN
$sql = "SELECT *
   FROM " . CATEGORIES_TABLE . "
   WHERE cat_id = " . $forum_topic_data['cat_id'];
if ( !($result = $db->sql_query($sql)) ) {
   message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
}

//
// If the query doesn't return any rows this isn't a valid forum. Inform
// the user.
//
if ( !($category_row = $db->sql_fetchrow($result)) ) {
   message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}
// MOD: Show categories :END
//----------------------------------------------------------------------

#
#-----[ FIND ]---------------------------------------------
#
# about line 631
#
'FORUM_NAME' => $forum_name,

#
#-----[ AFTER, ADD ]---------------------------------------------
#
//---------------------------------------------------------------------
// MOD: Show categories
	'CATEGORY_NAME' => $category_row['cat_title'],

#
#-----[ FIND ]---------------------------------------------
#
# about line 667
#
'U_VIEW_FORUM' => $view_forum_url,

#
#-----[ AFTER, ADD ]---------------------------------------------
#
//---------------------------------------------------------------------
// MOD: Show categories
	'U_VIEW_CATEGORY' => append_sid("index.$phpEx?" . POST_CAT_URL ."=". $forum_topic_data['cat_id']),

#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/viewtopic_body.tpl


#
#-----[ FIND ]---------------------------------------------
#
# The upper part of links.
#
	  -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
  </tr>

#
#-----[ REPLACE WITH ]---------------------------------------------
#
	  <br />&nbsp;&nbsp;&nbsp;<a class="nav" href="{U_VIEW_CATEGORY}">{CATEGORY_NAME}</a> -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
  </tr>

#
#-----[ FIND ]---------------------------------------------
#
# The lower part of links.
#
	  -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span> 

#
#-----[ REPLACE WITH ]---------------------------------------------
#
	  <br />&nbsp;&nbsp;&nbsp;<a class="nav" href="{U_VIEW_CATEGORY}">{CATEGORY_NAME}</a> -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span> 

#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------------------
#
# EoM