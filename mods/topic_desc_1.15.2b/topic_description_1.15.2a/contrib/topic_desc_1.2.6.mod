############################################################## 
## MOD Title: topic description 
## MOD Author: Swizec < iareswizec@hotmail.com > (N/A) http://www.randy-comic.com
## MOD Description: This mod adds a description to the topics on the forum, Like on vBullettin systems and some others.
## MOD Version: 1.2.6
## 
## Installation Level: Intermediate
## Installation Time: ~35 Minutes 
## Files To Edit: viewforum.php
##		  posting.php
##		  includes/functions_post.php
##		  admin/admin_board.php
##		  templates/subSilver/posting_body.tpl
##		  templates/subSilver/posting_preview.tpl
##		  templates/subSilver/viewforum_body.tpl
##		  templates/subSilver/admin/board_config_body.tpl
##		  language/lang_english/lang_admin.php
##		  language/lang_english/lang_main.php
## Included Files: n/a
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
############################################################## 
## MOD History: 
##
## history.txt
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 

ALTER TABLE `phpbb_topics` ADD `topic_description` VARCHAR( 255 ) NOT NULL AFTER `topic_title` ;
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'allow_description', '1' );
INSERT INTO phpbb_config SET ( config_name, config_value ) VALUES ( 'only_mods_desc', '0' );
ALTER TABLE `phpbb_topics` ADD `topic_descmod` TINYINT NOT NULL AFTER `topic_description` ;

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewforum.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$topic_desc = ( count ( $orig_word ) ) ? preg_replace ( $orig_word, $replacement_word, $topic_rowset[$i]['topic_description']) : $topic_rowset[$i]['topic_description'];

# 
#-----[ FIND ]------------------------------------------ 
# 

$template->assign_block_vars('topicrow', array(

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add
$desc4mod = $topic_rowset[$i]['topic_descmod'];
if ( $topic_desc != '' && $board_config['allow_descriptions'] ) {
	if ( !$desc4mod ) 
		$s = TRUE;
	elseif ( ( $topic_rowset[$i]['user_id'] == $userdata['user_id'] ) || $is_auth['auth_mod'] )
		$s = TRUE;
	else $s = FALSE;
}else $s = FALSE;
$topic_desc = ( $s ) ? '<br />' . $topic_desc : '';

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_TITLE' => $topic_title,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
'TOPIC_DESC' => $topic_desc,

# 
#-----[ OPEN ]------------------------------------------ 
# 

posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$select_sql = ( !$submit ) ? ", t.topic_title,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#

t.topic_title,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

t.topic_description, t.topic_descmod, 

# 
#-----[ FIND ]------------------------------------------ 
# 

$post_data['poster_id'] = $post_info['poster_id'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
$desc4mod = $post_info['topic_descmod'];

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// Set toggles for various options
//

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
$desc4mod = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['desc4mod']) ) ? TRUE : FALSE ) : FALSE;

# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = ( !empty($HTTP_POST_VARS['subject']) ) ? trim($HTTP_POST_VARS['subject']) : '';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$description = ( !empty($HTTP_POST_VARS['description']) ) ? trim($HTTP_POST_VARS['description']) : '';

# 
#-----[ FIND ]------------------------------------------ 
# 

submit_post($mode, $post_data, $return_message, $return_meta, $forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on, $html_on, $smilies_on, $attach_sig, $bbcode_uid, str_replace("\'", "''", $username), str_replace("\'", "''", $subject), str_replace("\'", "''", $message), str_replace("\'", "''", $poll_title), $poll_options, $poll_length);

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add argument

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

str_replace("\'", "''", $subject),

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

str_replace("\'", "''", $description), $desc4mod, 

# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = ( !empty($HTTP_POST_VARS['subject']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['subject']))) : '';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$description = ( !empty($HTTP_POST_VARS['description']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['description']))) : '';

# 
#-----[ FIND ]------------------------------------------ 
# 

$preview_subject = $subject;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
$preview_description = $description;
if ( $board_config ['allow_descriptions'] && ( !$board_config ['only_mods_desc'] || ( $board_config ['only_mods_desc'] && $is_auth['auth_mod'] ) ) ) 
			$template -> assign_block_vars ( 'switch_description', array ( ) );

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_TITLE' => $preview_subject,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
'TOPIC_DESC' => $preview_description,

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_POST_SUBJECT' => $lang['Post_subject'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
'L_DESCRIPTION' => $lang ['Description'],
'L_DESC4MOD' => $lang ['desc4mod'],


# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = '';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
$description = '';
if ( $board_config ['allow_descriptions'] && ( !$board_config ['only_mods_desc'] || ( $board_config ['only_mods_desc'] && $is_auth['auth_mod'] ) ) ) 
			$template -> assign_block_vars ( 'switch_description', array ( ) );

# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = '';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
$description = '';

# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = ( $post_data['first_post'] ) ? $post_info['topic_title'] : $post_info['post_subject'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$description = ( $post_data['first_post'] && ( !$board_config ['only_mods_desc'] || ( $board_config ['only_mods_desc'] && $is_auth['auth_mod'] ) ) ) ? $post_info['topic_description'] : '';

# 
#-----[ FIND ]------------------------------------------ 
# 

$smilies_on = ( $post_info['enable_smilies'] ) ? true : false;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
if ( $post_data['first_post'] && $board_config ['allow_descriptions']  && ( !$board_config ['only_mods_desc'] || ( $board_config ['only_mods_desc'] && $is_auth['auth_mod'] ) ) )
			$template -> assign_block_vars ( 'switch_description', array ( ) );

# 
#-----[ FIND ]------------------------------------------ 
# 

'SUBJECT' => $subject,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
'DESCRIPTION' => $description,

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_SUBJECT' => $lang['Subject'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
'L_DESCRIPTION' => $lang['Description'],
'L_DESC4MOD' => $lang['desc4mod'],

# 
#-----[ FIND ]------------------------------------------ 
# 

'S_HTML_CHECKED' => ( !$html_on ) ? 'checked="checked"' : '', 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
'S_DESC4MOD_CHECKED' => ( $desc4mod ) ? 'checked="checked"' : '', 

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions_post.php

# 
#-----[ FIND ]------------------------------------------ 
# 

function submit_post(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#

&$post_subject, 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

&$post_description,  &$desc4mod, 

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql  = ($mode != "editpost") ? "INSERT INTO " . TOPICS_TABLE . " (topic_title,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add to sql query

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#

topic_title,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

topic_description, topic_descmod,

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#

VALUES ('$post_subject',

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

'$post_description', '$desc4mod', 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#

"UPDATE " . TOPICS_TABLE . " SET topic_title = '$post_subject', 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

topic_description='$post_description', topic_descmod='$desc4mod', 

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$avatars_local_yes = ( $new['allow_avatar_local'] ) ? "checked=\"checked\"" : "";

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
$description_yes = ( $new['allow_descriptions'] ) ? "checked=\"checked\"" : "";
$description_no = ( !$new['allow_descriptions'] ) ? "checked=\"checked\"" : "";
$descmods_yes = ( $new['only_mods_desc'] ) ? "checked=\"checked\"" : "";
$descmods_no = ( !$new['only_mods_desc'] ) ? "checked=\"checked\"" : "";

# 
#-----[ FIND ]------------------------------------------ 
# 

"L_RESET" => $lang['Reset'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
"L_ALLOW_DESC" => $lang['allow_desc'],
"L_MODS_DESC" => $lang['mods_desc'],
"L_DESCRIPTION_SETTINGS" => $lang ['desc_settings'],

# 
#-----[ FIND ]------------------------------------------ 
# 

"AVATARS_LOCAL_YES" => $avatars_local_yes,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add
"DESCRIPTION_YES" => $description_yes,
"DESCRIPTION_NO" => $description_no,
"DESCMODS_YES" => $descmods_yes,
"DESCMODS_NO" => $descmods_no,
// mod topic description end

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span></td>
	  <td class="row2" width="78%"> <span class="gen"> 
		<input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" />
		</span> </td>
	</tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<!-- BEGIN switch_description -->
<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{L_DESCRIPTION}</b></span></td>
	  <td class="row2" width="78%"> <span class="gen"> 
		<input type="text" name="description" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{DESCRIPTION}" />&nbsp; <input type="checkbox" name="desc4mod" {S_DESC4MOD_CHECKED} />&nbsp; {L_DESC4MOD}
		</span> </td>
	</tr>
<!-- END switch_description -->

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/posting_preview.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

{POST_SUBJECT}

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

_SUBJECT}

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 &nbsp;&nbsp; {TOPIC_DESC}
	
# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/viewforum_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />
		{topicrow.GOTO_PAGE}</span></td>
		
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#

{topicrow.TOPIC_TITLE}</a></span>

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

<span class="genmed">{topicrow.TOPIC_DESC}</span>

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr>
  <th class="thHead" colspan="2">{L_AVATAR_SETTINGS}</th>
</tr>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

<tr>
	  <th class="thHead" colspan="2">{L_DESCRIPTION_SETTINGS}</th>
	</tr>
<tr>
		<td class="row1">{L_ALLOW_DESC}</td>
		<td class="row2"><input type="radio" name="allow_descriptions" value="1" {DESCRIPTION_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_descriptions" value="0" {DESCRIPTION_NO} /> {L_NO}</td>
	</tr>
<tr>
		<td class="row1">{L_MODS_DESC}</td>
		<td class="row2"><input type="radio" name="only_mods_desc" value="1" {DESCMODS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="only_mods_desc" value="0" {DESCMODS_NO} /> {L_NO}</td>
	</tr>

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

// mod topic description add
$lang['allow_desc'] = 'Allow descriptions';
$lang['mods_desc'] = 'Only mods add descriptions';
$lang['desc_settings'] = 'Description settings';

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

// mod topic description: add
$lang['Description'] = 'Description: ';
$lang['desc4mod'] = 'Description only for moderators';
	
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM