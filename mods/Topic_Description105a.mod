##############################################################
## MOD Title: Topic Description
## MOD Author: Morpheus2matrix < morpheus2matrix@caramail.com > (Lebrun Thomas) http://morpheus.2037.biz
## MOD Description: This MOD allow you to add a little description of the topic that you have posted
## MOD Version: 1.0.5
## Installation Level: Easy
## Installation Time: 10 min
## Files to Edit: posting.php,
##                functions_post.php,
##                viewforum.php,
##                lang_main.php,
##                posting_body.tpl,
##                viewforum_body.tpl
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## Author Notes:
##
##		A big thanks to FX :p
##
##############################################################
## MOD History: 
##
##   0.9.0. - Initial BETA release
##   0.9.1. - Now the Topic Desciption field appear only for a new topic
##   0.9.5. - Rewriting with a correct MOD Template
##   1.0.0. - Set status to FINAL
##   1.0.1. - Topic description only appear if the fiels topic_desc is not empty : thanks to DevFool
##   1.0.2. - Fix a bug when preview your subject : thanks to GilGraf
##   1.0.3. - Fix bugs in the How-To
##   1.0.4. - Fix other bugs
##          - Use include_once instead of include in viewforum.php to prevent conflict with other MOD's (Ptirhiik)
##   1.0.5. - Fix MOD-Template bugs
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
# remplace phpbb_ by the prefix of your tables
ALTER TABLE phpbb_topics ADD topic_desc varchar(255) DEFAULT '' AFTER topic_title;
#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
$select_sql = ( !$submit ) ? ", t.topic_title, p.enable_bbcode,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
t.topic_title,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
t.topic_desc,
#
#-----[ FIND ]------------------------------------------
#
$subject = ( !empty($HTTP_POST_VARS['subject']) ) ? trim($HTTP_POST_VARS['subject']) : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$topic_desc = ( !empty($HTTP_POST_VARS['topic_desc']) ) ? trim($HTTP_POST_VARS['topic_desc']) : '';
#
#-----[ FIND ]------------------------------------------
#
prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$poll_length
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $topic_desc
#
#-----[ FIND ]------------------------------------------
#
submit_post($mode, $post_data, $return_message, $return_meta, $forum_id,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$poll_length
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, str_replace("\'", "''", $topic_desc)
#
#-----[ FIND ]------------------------------------------------
#
   $message = ( !empty($HTTP_POST_VARS['message']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['message']))) : '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
   $topic_desc = ( !empty($HTTP_POST_VARS['topic_desc']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['topic_desc']))) : '';

#
#-----[ FIND ]------------------------------------------
#
else if ( $mode == 'quote' || $mode == 'editpost' )
   {
      $subject = ( $post_data['first_post'] ) ? $post_info['topic_title'] : $post_info['post_subject'];
      $message = $post_info['post_text'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
$topic_desc = $post_info['topic_desc'];
#
#-----[ FIND ]------------------------------------------
#
$template->assign_block_vars('switch_not_privmsg', array());
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Enable the Topic Description MOD only if this is a new post
// or if you edit the fist post of a topic
//
if ( $mode == 'newtopic' || ( $mode == 'editpost' && $post_data['first_post'] ) )
{
   $template->assign_block_vars('topic_description', array());
}
#
#-----[ FIND ]------------------------------------------
#
'L_STYLES_TIP' => $lang['Styles_tip'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_TOPIC_DESCRIPTION' => $lang['Topic_description'],
#
#-----[ FIND ]------------------------------------------
#
'U_REVIEW_TOPIC' => ( $mode == 'reply' ) ? append_sid("posting.$phpEx?mode=topicreview&amp;" . POST_TOPIC_URL . "=$topic_id") : '',
#
#-----[ AFTER, ADD ]------------------------------------------
#
'TOPIC_DESCRIPTION' => $topic_desc,
#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php
#
#-----[ FIND ]------------------------------------------
#
function prepare_post(&$mode, &$post_data, &$bbcode_on, &$html_on,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
&$poll_length
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, &$topic_desc
#
#-----[ FIND ]------------------------------------------
#
	$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['Empty_subject'] : $lang['Empty_subject'];
}
#
#-----[ AFTER, ADD ]------------------------------------------
#
// Check Topic Desciption
if ( !empty($topic_desc) )
   {
      $topic_desc = htmlspecialchars(trim($topic_desc));
   }
#
#-----[ FIND ]------------------------------------------
#
function submit_post($mode, &$post_data, &$message, &$meta, &$forum_id,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
&$poll_length
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, &$topic_desc
#
#-----[ FIND ]------------------------------------------
#
$sql  = ($mode != "editpost") ? "INSERT INTO " . TOPICS_TABLE . " (topic_title,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
"INSERT INTO " . TOPICS_TABLE . " (topic_title,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
topic_desc,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
VALUES ('$post_subject',
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
'$topic_desc',
#
#-----[ IN-LINE FIND ]------------------------------------------
#
"UPDATE " . TOPICS_TABLE . " SET topic_title = '$post_subject',
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
topic_desc = '$topic_desc',
#
#-----[ OPEN ]------------------------------------------
#
viewforum.php
#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'common.'.$phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
#
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
#
#-----[ FIND ]------------------------------------------
#
'L_AUTHOR' => $lang['Author'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
'L_DESCRIPTION' => $lang['Description'],
#
#-----[ FIND ]------------------------------------------
#
'U_VIEW_TOPIC' => $view_topic_url)
                );
#
#-----[ AFTER, ADD ]------------------------------------------
#
                if ( !empty($topic_rowset[$i]['topic_desc']))
                {
                    $topic_desc = $topic_rowset[$i]['topic_desc'];
                    $template->assign_block_vars('topicrow.switch_topic_desc', array(
                               'TOPIC_DESCRIPTION' => smilies_pass($topic_desc))
                    );
                }
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['A_critical_error']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Topic_description'] = 'Description of your topic';
$lang['Description'] = 'Topic Description';

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
<!-- BEGIN topic_description -->
   <tr>
     <td class="row1" width="22%"><span class="gen"><b>{L_TOPIC_DESCRIPTION}</b></span></td>
     <td class="row2" width="78%"> <span class="gen">
      <input type="text" name="topic_desc" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{TOPIC_DESCRIPTION}" />
      </span> </td>
   </tr>
   <!-- END topic_description -->
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewforum_body.tpl
#
#-----[ FIND ]------------------------------------------
#
{topicrow.TOPIC_TITLE}</a></span><span class="gensmall">
#
#-----[ AFTER, ADD ]------------------------------------------
#
              <!-- BEGIN switch_topic_desc -->
              {L_DESCRIPTION} : {topicrow.switch_topic_desc.TOPIC_DESCRIPTION}<br />
              <!-- END switch_topic_desc -->
#
#-----[ SAVE/CLOSE ALL FILES ]----------------------------------------
#
# EoM 