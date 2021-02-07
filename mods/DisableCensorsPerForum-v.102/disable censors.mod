############################################################## 
## MOD Title: Disable Censors Per Forum
## MOD Author: Alex Aberle < alex@sara-and-david.com > (Alex Aberle) http://www.sara-and-david.com 
## MOD Description: Allows Administrators to disable Word Censors on a forum-by-forum basis.
## MOD Version: 1.0.2
## 
## Installation Level: Intermediate
## Installation Time: ~15 Minutes 
## Files To Edit: (4) viewtopic.php, posting.php, includes/topic_review.php, language/lang_english/lang_admin.php
## Included Files: (2) admin/admin_forum_censors.php, templates/subSilver/admin/forum_censors.tpl
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##
############################################################## 
## MOD History:
##     2004-05-12 - Version 1.0.2
##	    - Fixed some MOD syntax errors
##	    - Now filters Topic Titles
##     2003-12-10 - Version 1.0.1
##	    - Added script to Preview and Topic Review pages. (Which I forgot to do...)
##     2003-12-03 - Version 1.0.0
##          - First release.
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
#
copy admin/admin_forum_censors.php to admin/admin_forum_censors.php
copy templates/subSilver/admin/forum_censors.tpl to templates/subSilver/admin/forum_censors.tpl

#
#-----[ SQL ]------------------------------------------
# replace phpbb_ by the prefix of your tables
ALTER TABLE phpbb_forums ADD forum_disablecensors tinyint(1) DEFAULT '0' AFTER auth_attachments;

# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$order_sql = ( empty($post_id) ) ? '' : "GROUP BY p.post_id

# 
#-----[ IN-LINE FIND ]------------------------------------
# 

 f.auth_attachments

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, f.forum_disablecensors

#
#-----[ FIND ]------------------------------------------ 
#
$sql = "SELECT t.topic_id, t.topic_title, t.topic_status, t.topic_replies,

# 
#-----[ IN-LINE FIND ]------------------------------------
# 
 f.auth_attachments

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, f.forum_disablecensors

#
#-----[ FIND ]------------------------------------------ 
#
//
// Define censored word matches
//

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
$forum_disablecensors = $forum_topic_data['forum_disablecensors'];

if ($forum_disablecensors==0){

#
#-----[ FIND ]------------------------------------------ 
#
//
// Censor topic title
//
if ( count($orig_word) )
{
	$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
}

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
}

# 
#-----[ OPEN ]------------------------------------------ 
# 
posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $post_info);


#
#-----[ AFTER, ADD ]------------------------------------------ 
#
	$forum_disablecensors = $post_info['forum_disablecensors'];

#
#-----[ FIND ]------------------------------------------ 
#
	if( $preview )
	{

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
	if ($forum_disablecensors==0){

#
#-----[ FIND ]------------------------------------------ 
#
		$orig_word = array();
		$replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
	}

# 
#-----[ OPEN ]------------------------------------------ 
# 
viewforum.php

#
#-----[ FIND ]------------------------------------------ 
#
//
// Define censored word matches
//

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
$forum_disablecensors = $forum_row['forum_disablecensors'];

if ($forum_disablecensors==0){

#
#-----[ FIND ]------------------------------------------ 
#
obtain_word_list($orig_word, $replacement_word);

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
}

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/topic_review.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$sql = "SELECT t.topic_title, f.forum_id, f.auth_view,

# 
#-----[ IN-LINE FIND ]------------------------------------
# 
 f.auth_attachments

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, f.forum_disablecensors

#
#-----[ FIND ]------------------------------------------ 
#
	//
	// Define censored word matches
	//

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
$forum_disablecensors = $forum_row['forum_disablecensors'];

	if ($forum_disablecensors==0){

#
#-----[ FIND ]------------------------------------------ 
#
		obtain_word_list($orig_word, $replacement_word);
	}

#
#-----[ AFTER, ADD ]------------------------------------------ 
#
	}

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
//
// That's all Folks!
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//Forum Censors
$lang['forumcensors_title'] = 'Forum Censor Control';
$lang['forumcensors_decription'] = 'This function allows you to disable or enable the word censors on a per-forum basis. This function will not work if there are no Word Censor filters, or the filters have been disabled.';
$lang['forumcensors_filter_status'] = 'Filter Status';
$lang['forumcensors_change_status'] = 'Change Status';
$lang['forumcensors_status_enabled'] = 'Enabled';
$lang['forumcensors_status_disabled'] = 'Disabled';
$lang['forumcensors_change_enable'] = 'Enable';
$lang['forumcensors_change_disable'] = 'Disable';

# 
#-----[ SAVE/CLOSE ALL FILES ]-------------------------- 
# 
# EoM