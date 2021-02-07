#TITLE=phpBB Common
#INFO
Functions and other things commonly used in phpBB files.
#SORT=y

#T=Open
<?php
/***************************************************************************
 *                              ^!.php
 *                            -------------------
 *   begin                : (insert date here. format: Saturday, Feb 13, 2001)
 *   copyright            : (C) (insert year here) (insert your name here)
 *   email                : (insert your email here)
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
#T=Close

?>
#T=SQL Query
$db->sql_query(^!);
#T=SQL Num Rows
$db->sql_numrows(^!));
#T=SQL Num Fields
$db->sql_numfields(^!);
#T=SQL Field Name
$db->sql_fieldname(^!);
#T=SQL Field Type
$db->sql_field_type(^!);
#T=SQL Fetch Row
$db->sql_fetchrow(^!);
#T=SQL Fetch Rowset
$db->sql_fetchrowset(^!);
#T=SQL Fetch Field
$db->sql_fetchfield(^!);
#T=SQL Row Seek
$db->sql_rowseek(^!);
#T=SQL Next ID
$db->sql_nextid();
#T=SQL Affected Rows
$db->sql_affectedrows();
#T=SQL Free Results
$db->sql_freeresult(^!);
#T=TPL Set File Names
$template->set_filenames(array(
  'body' => '^!')
);
#T=TPL Parse
$template->pparse(^!);
#T=TPL Assign Var From Handle
$template->assign_var_from_handle('^!', '');
#T=TPL Assign Block Vars
$template->assign_block_vars('^!', array(
  'VARIBLE' => $value,
  'VARIBLE' => $value)
);
#T=TPL Switch
$template->assign_block_vars('^!', array());
#T=TPL Assign Vars
$template->assign_vars(array(
  '^!' => $value,
  'VARIBLE' => $value)
);
#T=TPL Assign Var
$template->assign_var('^!', $value);
#T=Function
function ^!()
{
  //function goes here
  
}
#T=if
if ( ^! )
{
  //do this if true
  
}
#T=if...else
if ( ^! )
{
  //do this if true

}
else
{
  //do this if isn't true
  
}
#T=if...elseif
if ( ^! )
{
  //do this if true

}
else if ( )
{
  //do this if 1st isn't true and second is true

}
#T=if...elseif...else
if ( ^! )
{
  //do this if true

}
else if ( )
{
  //do this if 1st isn't true and second is true

}
else
{
  //do this if none are true
  
}
#T=Include
include($phpbb_root_path . '^!.'.$phpEx);
#T=Include Once
include_once($phpbb_root_path . '^!.'.$phpEx);
#T=Require
require($phpbb_root_path . '^!.'.$phpEx);
#T=Define
define('^!', $value);
#T=Defined
defined(^!);
#T=sprintf()
sprintf(^!);
#T=message_die()
message_die(^!, $message);
#T=message_die( __LINE__, __FILE__, $sql)
message_die(GENERAL_ERROR, "!^", "", __LINE__, __FILE__, $sql);
#T=append_sid()
append_sid(^!);
#T=$HTTP_POST_VARS
$HTTP_POST_VARS['^!'];
#T=$HTTP_GET_VARS
$HTTP_GET_VARS['^!'];
#T=htmlspecialchars()
htmlspecialchars(^!);
#T=trim()
trim(^!);
#T=addslashes()
addslashes(^!);
#T=stripslahses()
stripslashes(^!);
#T=switch()
switch( ^! )
{
  case 'case1':
    //case 1
  
    break;
    
  default:
    //default
    
    break;
}
#T=isset()
isset(^!);
#T=while()
while ( ^! )
{
  //loop through this while the while is true
  
}
#T=GENERAL_MESSAGE
GENERAL_MESSAGE
#T=GENERAL_ERROR
GENERAL_ERROR
#T=CRITICAL_MESSAGE
CRITICAL_MESSAGE
#T=CRITICAL_ERROR
CRITICAL_ERROR
#T=$phpEx
$phpEx
#T=$phpbb_root_path
$phpbb_root_path
#T=$lang[]
$lang['!^']
#T=Session
//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_STORE);
init_userprefs($userdata);
//
// End session management
//
#T=DELETED
DELETED
#T=ANONYMOUS
ANONYMOUS
#T=USER
USER
#T=MOD
MOD
#T=ADMIN
ADMIN
#T=POST_TOPIC_URL
POST_TOPIC_URL
#T=POST_CAT_URL
POST_CAT_URL
#T=POST_FORUM_URL
POST_FORUM_URL
#T=POST_USERS_URL
POST_USERS_URL
#T=POST_POST_URL
POST_POST_URL
#T=POST_GROUPS_URL
POST_GROUPS_URL
#T=AUTH_LIST_ALL
AUTH_LIST_ALL
#T=AUTH_ALL
AUTH_ALL
#T=AUTH_REG
AUTH_REG
#T=AUTH_ACL
AUTH_ACL
#T=AUTH_MOD
AUTH_MOD
#T=AUTH_ADMIN
AUTH_ADMIN
#T=AUTH_VIEW
AUTH_VIEW
#T=AUTH_READ
AUTH_READ
#T=AUTH_POST
AUTH_POST
#T=AUTH_REPLY
AUTH_REPLY
#T=AUTH_EDIT
AUTH_EDIT
#T=AUTH_DELETE
AUTH_DELETE
#T=AUTH_ANNOUNCE
AUTH_ANNOUNCE
#T=AUTH_STICKY
AUTH_STICKY
#T=AUTH_POLLCREATE
AUTH_POLLCREATE
#T=AUTH_VOTE
AUTH_VOTE
#T=AUTH_ATTACH
AUTH_ATTACH
#T=AUTH_ACCESS_TABLE
AUTH_ACCESS_TABLE
#T=BANLIST_TABLE
BANLIST_TABLE
#T=CATEGORIES_TABLE
CATEGORIES_TABLE
#T=CONFIG_TABLE
CONFIG_TABLE
#T=DISALLOW_TABLE
DISALLOW_TABLE
#T=FORUMS_TABLE
FORUMS_TABLE
#T=GROUPS_TABLE
GROUPS_TABLE
#T=POSTS_TABLE
POSTS_TABLE
#T=POSTS_TEXT_TABLE
POSTS_TEXT_TABLE
#T=PRIVMSGS_TABLE
PRIVMSGS_TABLE
#T=PRIVMSGS_TEXT_TABLE
PRIVMSGS_TEXT_TABLE
#T=PRIVMSGS_IGNORE_TABLE
PRIVMSGS_IGNORE_TABLE
#T=PRUNE_TABLE
PRUNE_TABLE
#T=RANKS_TABLE
RANKS_TABLE
#T=SEARCH_TABLE
SEARCH_TABLE
#T=SEARCH_WORD_TABLE
SEARCH_WORD_TABLE
#T=SEARCH_MATCH_TABLE
SEARCH_MATCH_TABLE
#T=SESSIONS_TABLE
SESSIONS_TABLE
#T=SMILIES_TABLE
SMILIES_TABLE
#T=THEMES_TABLE
THEMES_TABLE
#T=THEMES_NAME_TABLE
THEMES_NAME_TABLE
#T=TOPICS_TABLE
TOPICS_TABLE
#T=TOPICS_WATCH_TABLE
TOPICS_WATCH_TABLE
#T=USER_GROUP_TABLE
USER_GROUP_TABLE
#T=USERS_TABLE
USERS_TABLE
#T=WORDS_TABLE
WORDS_TABLE
#T=VOTE_DESC_TABLE
VOTE_DESC_TABLE
#T=VOTE_RESULTS_TABLE
VOTE_RESULTS_TABLE
#T=VOTE_USERS_TABLE
VOTE_USERS_TABLE
#T=Include Page Header
$page_title = $lang['^!'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
#T=Include Page Footer
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
#T=&amp;
&amp;
#T=&nbsp;
&nbsp;

#
