############################################################## 
## MOD Title:          Display Total Attachments MOD
## MOD Author:         morpheus2matrix < morpheus@2037.biz > (Morpheus) http://morpheus.2037.biz
## MOD Description:    This MOD will allow you to display the total number of attachments which are in a topic and 
##		       in the forums
##                     
## MOD Version:        1.0.4
## Compatibility:      2.0.6
##
## Installation Level: Easy
## Installation Time:  3 Minutes
## Files To Edit:      5
##      viewforum.php
##	index.php
##      language/lang_english/lang_main_attach.php
##	templates/subSilver/viewforum_body.tpl
##	templates/subSilver/index_body.tpl
##
## Included Files:     N/A
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##		This is an add-on for the Attachment MOD of Acyd Burn
##		Don't use it if you have not the Attachment MOD installed first
##
############################################################## 
## MOD History:
##
##  2004-05-23 - Version 1.0.4
##	- Fixed error when 0 attachments in forums
##
##  2003-12-30 - Version 1.0.3
##	- Fixed errors in How-To (i hope the last ones)
##
##   2003-12-25 - Version 1.0.2
##	- Correction of an error in the how to
##
##   2003-12-24 - Version 1.0.1
##	- Correction added to the MOD
##	- Total Attachments are now shown on index page
##
##   2003-12-22 - Version 1.0.0
##	- first beta release
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]------------------------------------------------
#
viewforum.php

#
#-----[ FIND ]------------------------------------------------
#
'L_REPLIES' => $lang['Replies'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

// Display Total Attachments MOD Start
'L_ATTACHMENT_NUMBER' => $lang['Number_Attachments'],
// Display Total Attachments MOD End

#
#-----[ FIND ]------------------------------------------------
#

$views = $topic_rowset[$i]['topic_views'];

#
#-----[ AFTER, ADD ]------------------------------------------
#

// Display Total Attachments MOD Start
$sql = "SELECT post_id
	FROM " . POSTS_TABLE . "
	WHERE topic_id = $topic_id
	GROUP BY post_id";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query post information', '', __LINE__, __FILE__, $sql);
}

$post_ids = '';
while ( $row = $db->sql_fetchrow($result) )
{
	$post_ids .= ($post_ids == '') ? $row['post_id'] : ', ' . $row['post_id'];
}

if ( $post_ids != '' )
{
	$sql = "SELECT attach_id as total_attachment
		FROM " . ATTACHMENTS_TABLE . "
		WHERE post_id IN (" . $post_ids . ")";

	if ( !($result2 = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query attachment information', '', __LINE__, __FILE__, $sql);
	}

	$attach_num = $db->sql_numrows($result2);
}
else
{
	$attach_num = 0;
}
// Display Total Attachments MOD End

#
#-----[ FIND ]------------------------------------------------
#

'GOTO_PAGE' => $goto_page,

#
#-----[ AFTER, ADD ]------------------------------------------
#

// Display Total Attachments MOD Start
'NB_ATTACHMENTS' => $attach_num,
// Display Total Attachments MOD End

#
#-----[ OPEN ]------------------------------------------------
#
index.php

#
#-----[ FIND ]------------------------------------------------
#
'L_ONLINE_EXPLAIN' => $lang['Online_explain'], 

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Display Total Attachments MOD Start
'L_ATTACHMENT_NUMBER' => $lang['Number_Attachments'],
// Display Total Attachments MOD End

#
#-----[ FIND ]------------------------------------------------
#
$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Display Total Attacments MOD Start
$sql = "SELECT post_id
	FROM " . POSTS_TABLE . "
	WHERE forum_id = $forum_id
	GROUP BY post_id";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query post information', '', __LINE__, __FILE__, $sql);
}

$post_ids = '';
while ( $row = $db->sql_fetchrow($result) )
{
	$post_ids .= ($post_ids == '') ? $row['post_id'] : ', ' . $row['post_id'];
}

if ( $post_ids != '' )
{
	$sql = "SELECT attach_id as total_attachment
		FROM " . ATTACHMENTS_TABLE . "
		WHERE post_id IN (" . $post_ids . ")";

	if ( !($result2 = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query attachment information', '', __LINE__, __FILE__, $sql);
	}

	$attach_num = $db->sql_numrows($result2);
}
else
{
	$attach_num = 0;
}
// Display Total Attacments MOD End

#
#-----[ FIND ]------------------------------------------------
#
'MODERATORS' => $moderator_list,

#
#-----[ AFTER, ADD ]------------------------------------------
#
// Display Total Attachments MOD Start
'NB_ATTACHMENTS' => $attach_num,
// Display Total Attachments MOD End

#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------------
#
<th colspan="2" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>

#
#-----[ AFTER, ADD ]------------------------------------------
#
<th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_ATTACHMENT_NUMBER}&nbsp;</th>

#
#-----[ FIND ]------------------------------------------------
#
<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{catrow.forumrow.NB_ATTACHMENTS}</span></td>

#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/viewforum_body.tpl

#
#-----[ FIND ]------------------------------------------------
#
<th colspan="2" align="center" height="25" class="thCornerL" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<th width="50" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_ATTACHMENT_NUMBER}&nbsp;</th>

#
#-----[ FIND ]------------------------------------------------
#

{topicrow.GOTO_PAGE}</span></td>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<td class="row3" align="center" valign="middle"><span class="postdetails">{topicrow.NB_ATTACHMENTS}</span></td>

#
#-----[ FIND ]------------------------------------------------
#

<td class="catBottom" align="center" valign="middle" colspan="6" height="28">

#
#-----[ IN-LINE FIND ]------------------------------------------------
#
colspan="6"

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------------
#
colspan="7"

#
#-----[ OPEN ]-------------------------------------------------
#
language/lang_english/lang_main_attach.php

#
#-----[ FIND ]-------------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

// Display Total Attachments MOD Start
$lang['Number_Attachments'] = 'Attachments';
// Display Total Attachments MOD End

#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM
