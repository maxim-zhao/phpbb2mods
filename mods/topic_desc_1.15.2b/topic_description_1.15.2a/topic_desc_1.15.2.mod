############################################################## 
## MOD Title: topic description 
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: Fresh installation of topic description v1.15.2. Check history.txt and readme.txt for more information.
## MOD Version: 1.15.2
## 
## Installation Level: Intermediate
## Installation Time: ~50 Minutes 
## Files To Edit: 
##		  common.php
##		  posting.php
##		  search.php
##		  viewforum.php
##		  viewtopic.php
##		  includes/constants.php
##		  includes/functions_post.php
##		  includes/functions_search.php
##		  includes/usercp_register.php
##		  includes/usercp_avatar.php
##		  includes/page_header.php
##		  admin/admin_users.php
##		  admin/admin_forumauth.php
##		  admin/admin_ug_auth.php
##		  templates/subSilver/search_results_posts.tpl
##		  templates/subSilver/search_results_topics.tpl
##		  templates/subSilver/posting_body.tpl
##		  templates/subSilver/posting_preview.tpl
##		  templates/subSilver/viewforum_body.tpl
##		  templates/subSilver/viewtopic_body.tpl
##		  templates/subSilver/overall_header.tpl
##		  templates/subSilver/overall_footer.tpl
##		  templates/subSilver/profile_add_body.tpl
##		  templates/subSilver/admin/user_edit_body.tpl
##		  language/lang_english/lang_admin.php
##		  language/lang_english/lang_main.php
## Included Files: includes/functions_desc.php
##		   includes/Sajax.php
##		   admin/admin_desc.php
##		   templates/wz_tooltip.js
##		   templates/subSilver/preview_tooltip_params.cfg
##		   templates/subSilver/admin/desc_config_body.tpl
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
## I got the tooltip script from http://www.walterzorn.com/tooltip/tooltip_e.htm
## This thingo is also LGPL and the MODs think this should be mentioned so it is :) (that's for the JS script)
## demo board: http://www.swizec.com/forum
##
## READ THE README
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

ALTER TABLE `phpbb_topics` ADD `topic_description` VARCHAR( 255 ) NOT NULL ; 
ALTER TABLE `phpbb_topics` ADD `topic_descmod` TINYINT( 1 ) NOT NULL ; 
ALTER TABLE `phpbb_search_wordmatch` ADD `desc_match` TINYINT( 1 ) NOT NULL ; 
ALTER TABLE `phpbb_users` ADD `user_allowdesc` TINYINT( 1 ) DEFAULT '1' NOT NULL ; 
ALTER TABLE `phpbb_users` ADD `user_allowmoddesc` TINYINT( 1 ) DEFAULT '1' NOT NULL ; 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'allow_descriptions', '1' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'only_mods_desc', '0' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'guests_desc', '1' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'guests_moddesc', '1' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'disallowed_seedesc', '1' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'show_tooltips', '1' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'tooltips_parse', '1' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'tooltips_static', '0' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_length', '255' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_tolink', '0' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_linkforce', '0' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_linkempty', '0' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'toolimg_width', '250' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'toolimg_height', '250' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_prev', '0' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_html', '0' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_bbcode', '1' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_smile', '1' ); 
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_bbcode_hatelist', 'img quote code' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_bbcode_remove', '1' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'tooltips_post_maxsize', '300' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_postparsing', '1' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ('desc_postparsing_tool', '1');
ALTER TABLE `phpbb_forums` ADD `auth_desc` TINYINT( 2 ) NOT NULL ; 
ALTER TABLE `phpbb_forums` ADD `auth_moddesc` TINYINT( 2 ) NOT NULL ; 
ALTER TABLE `phpbb_forums` ADD `auth_tooltip` TINYINT( 2 ) NOT NULL ; 
ALTER TABLE `phpbb_auth_access` ADD `auth_desc` TINYINT( 2 ) NOT NULL ; 
ALTER TABLE `phpbb_auth_access` ADD `auth_moddesc` TINYINT( 2 ) NOT NULL ; 
ALTER TABLE `phpbb_auth_access` ADD `auth_tooltip` TINYINT( 2 ) NOT NULL ; 
ALTER TABLE `phpbb_users` ADD `user_showdescriptions` TINYINT( 1 ) DEFAULT '1' NOT NULL ; 
ALTER TABLE `phpbb_users` ADD `user_showtooltips` TINYINT( 1 ) DEFAULT '1' NOT NULL ; 
ALTER TABLE `phpbb_users` ADD `user_tooltips_parse` TINYINT( 1 ) DEFAULT '1' NOT NULL ; 
ALTER TABLE `phpbb_users` ADD `user_tooltips_static` TINYINT( 1 ) DEFAULT '0' NOT NULL ; 
ALTER TABLE `phpbb_users` ADD `user_toolimg_width` INT( 5 ) DEFAULT '250' NOT NULL ; 
ALTER TABLE `phpbb_users` ADD `user_toolimg_height` INT( 5 ) DEFAULT '250' NOT NULL;

# 
#-----[ COPY ]------------------------------------------ 
#  the wz_tooltip.js is where it is because it's universal for all templates yet is not for the includes
#  as it has to do solely with templates

copy includes/functions_desc.php to includes/functions_desc.php
copy includes/Sajax.php to includes/Sajax.php
copy admin/admin_desc.php to admin/admin_desc.php
copy templates/wz_tooltip.js to templates/wz_tooltip.js
copy templates/subSilver/preview_tooltip_params.cfg to templates/subSilver/preview_tooltip_params.cfg
copy templates/subSilver/admin/desc_config_body.tpl to templates/subSilver/admin/desc_config_body.tpl

# 
#-----[ OPEN ]------------------------------------------ 
# 

common.php

# 
#-----[ FIND ]------------------------------------------ 
# 

include($phpbb_root_path . 'includes/db.'.$phpEx);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
include($phpbb_root_path . 'includes/functions_desc.'.$phpEx);
include($phpbb_root_path . 'includes/Sajax.'.$phpEx);
$Sajax = new Sajax( FALSE, 'GET' );
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
// do it here because it's better than to do it on each parse
$board_config['desc_bbcode_hatelist'] = str_replace( ' ', '|', $board_config['desc_bbcode_hatelist'] );

# 
#-----[ OPEN ]------------------------------------------ 
# 

posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$select_sql = (!$submit) ? ', t.topic_title,

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

if ( $mode == 'editpost' || $mode == 'delete' || $mode == 'poll_delete' )

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
$candesc = check_descperm ( );
if ( $candesc == AUTH_NODESC )
{
	$candesc = FALSE;
	$canmoddesc = FALSE;
}
elseif ( $candesc == AUTH_DESC ) 
{
	$candesc = TRUE;
	$candescmod = FALSE;
}
elseif ( $candesc == AUTH_MODDESC ) 
{
	$candesc = TRUE;
	$canmoddesc = TRUE;
}
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

$post_data['poster_id'] = $post_info['poster_id'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
$post_desc4mod = $post_info['topic_descmod'];

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
$post_desc4mod = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['desc4mod']) && $canmoddesc ) ? TRUE : FALSE ) : FALSE;

# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = ( !empty($HTTP_POST_VARS['subject']) ) ? trim($HTTP_POST_VARS['subject']) : '';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$post_description = ( !empty($HTTP_POST_VARS['description']) && $candesc ) ? trim($HTTP_POST_VARS['description']) : '';

# 
#-----[ FIND ]------------------------------------------ 
# 

prepare_post(

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add argument

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, $post_description

# 
#-----[ FIND ]------------------------------------------ 
# 

submit_post(

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

str_replace("\'", "''", $post_description), $post_desc4mod, 

# 
#-----[ FIND ]------------------------------------------ 
# 

if( $refresh || isset($HTTP_POST_VARS['del_poll_option']) || $error_msg != '' )

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
if ( $mode != 'reply' && $mode != 'quote' )
{
	if ( $candesc ) 
	{
		$template -> assign_block_vars ( 'switch_description', array () );
	}
	if ( $canmoddesc ) 
	{
		$template -> assign_block_vars ( 'switch_description.switch_moddescription', array () );
	}
}
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = ( !empty($HTTP_POST_VARS['subject']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['subject']))) : '';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$post_description = ( !empty($HTTP_POST_VARS['description']) && $candesc ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['description']))) : '';

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_TITLE' => $preview_subject,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
'TOPIC_DESC' => $preview_description,
'S_DESC_LENGTH' => $board_config['desc_length'],
// mod topic description end

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
'L_DESC_LEFT1' => $lang['Desc_charleft1'],
'L_DESC_LEFT2' => $lang['Desc_charleft2'],
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = '';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
$post_description = '';

# 
#-----[ FIND ]------------------------------------------ 
# 

$subject = ( $post_data['first_post'] ) ? $post_info['topic_title'] : $post_info['post_subject'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$post_description = ( $candesc ) ? $post_info['topic_description'] : '';

# 
#-----[ FIND ]------------------------------------------ 
# 

$message = preg_replace('/\:(([a-z0-9]:)?)' . $post_info['bbcode_uid'] . '/s', '', $message);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$post_description = preg_replace('/\:(([a-z0-9]:)?)' . $post_info['bbcode_uid'] . '/s', '', $post_description);

# 
#-----[ FIND ]------------------------------------------ 
# 

'SUBJECT' => $subject,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
'DESCRIPTION' => $post_description,
'S_DESC_LENGTH' => $board_config['desc_length'],
// mod topic description end

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
'L_DESC_LEFT1' => $lang['Desc_charleft1'],
'L_DESC_LEFT2' => $lang['Desc_charleft2'],
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

'S_HTML_CHECKED' => ( !$html_on ) ? 'checked="checked"' : '', 

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
'S_DESC4MOD_CHECKED' => ( $post_info['topic_descmod'] ) ? 'checked="checked"' : '', 

# 
#-----[ OPEN ]------------------------------------------ 
# 

search.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT t.*

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

p2.post_time

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, pt.bbcode_uid 

# 
#-----[ FIND ]------------------------------------------ 
# 

. USERS_TABLE . " u2

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

u2

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, " . POSTS_TEXT_TABLE . " pt

# 
#-----[ FIND ]------------------------------------------ 
# 

AND p2.post_id = t.topic_last_post_id

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

AND t.topic_first_post_id = pt.post_id

# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_id = $searchset[$i]['topic_id'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
$showdesc = check_descperm ( TRUE );
$topic_desc = ( $showdesc ) ? fetch_desc( $searchset[$i]['topic_description'], $searchset[$i]['bbcode_uid'] ) : '';
$topic_tool = ( show_tooltip ( $searchset[$i]['forum_id'], $searchset[$i]['topic_id'] ) ) ? topic_tooltip ( $searchset[$i]['topic_id'] ) : '';
// mod topic description mod end

#
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_TITLE' => $topic_title,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic mod add
'TOPIC_DESC' => $topic_desc,
'TOPIC_TOOLTIP' => $topic_tool,
// mod topic mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_TITLE' => $topic_title,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
'TOPIC_DESC' => ( $topic_desc != '' ) ? '<br />' . $topic_desc : '',
'TOPIC_TOOLTIP' => $topic_tool,
// mod topic mod end

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewforum.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT t.*

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

p.post_username

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, pt.bbcode_uid

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add to query

# 
#-----[ FIND ]------------------------------------------ 
# 

. USERS_TABLE . " u2

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

u2

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, " . POSTS_TEXT_TABLE . " pt

# 
#-----[ FIND ]------------------------------------------ 
# 

AND t.topic_type = " . POST_ANNOUNCE . " 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

AND t.topic_first_post_id = pt.post_id

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT t.*

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

, p2.post_time

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, pt.bbcode_uid

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add to query

# 
#-----[ FIND ]------------------------------------------ 
# 

. USERS_TABLE . " u2

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

u2

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, " . POSTS_TEXT_TABLE . " pt

# 
#-----[ FIND ]------------------------------------------ 
# 

AND t.topic_type <> " . POST_ANNOUNCE . " 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

AND t.topic_first_post_id = pt.post_id

# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
$topic_desc = ( count ( $orig_word ) ) ? preg_replace ( $orig_word, $replacement_word, $topic_rowset[$i]['topic_description']) : $topic_rowset[$i]['topic_description'];
$bbcode_uid = $topic_rowset[$i]['bbcode_uid'];
// mod topic description: end

# 
#-----[ FIND ]------------------------------------------ 
# 

$template->assign_block_vars('topicrow', array(

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add
$topic_desc4mod = $topic_rowset[$i]['topic_descmod'];
if ( empty( $desc_perm ) || !isset( $desc_perm ) )
{
	get_descperm( $desc_perm );
	get_tooltipperm( $tool_perm, $forum_id );
}
if ( empty( $tooltips_full ) || !isset( $tooltips_full ) )
{
	get_tooltips( $tooltips_full, $topic_rowset );
}
$tooltip_options = implode( '', file( $phpbb_root_path . 'templates/' . $theme['template_name'] . '/preview_tooltip_params.cfg' ) );
$topic_desc = fetch_desc ( $topic_desc, $bbcode_uid, TRUE );
$topic_tool = ( show_tooltip ( $forum_id, $topic_id ) ) ? topic_tooltip ( $topic_id ) : '';
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_TITLE' => $topic_title,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
'TOPIC_DESC' => $topic_desc,
'TOPIC_TOOLTIP' => $topic_tool,
// mod topic description end

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT t.topic_id, t.topic_title,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

//mod topic description add to sql query

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

$bbcode_uid = $postrow[$i]['bbcode_uid'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
if ( $i == 0 )
{
	$topic_desc = fetch_desc( $forum_topic_data['topic_description'], $bbcode_uid );
	$topic_desc = preg_replace($orig_word, $replacement_word, $topic_desc);
	$template->assign_var( 'TOPIC_DESC', $topic_desc );
}
// mod topic description: end

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/constants.php

# 
#-----[ FIND ]------------------------------------------ 
# 

define('AUTH_ATTACH', 11);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
define('AUTH_NODESC', 0);
define('AUTH_DESC', 1);
define('AUTH_MODDESC', 2);
// mod topic description end

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions_post.php

# 
#-----[ FIND ]------------------------------------------ 
# 

function prepare_post(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

)

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, &$post_description

# 
#-----[ FIND ]------------------------------------------ 
# 

	$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['Empty_message'] : $lang['Empty_message'];
}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description: add
if ( !empty( $post_description ) )
{
	$post_description = prepare_message(trim($post_description), TRUE, TRUE, TRUE, $bbcode_uid);
}
// mod topic description: end

# 
#-----[ FIND ]------------------------------------------ 
# 

function submit_post(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#

$post_subject, 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

$post_description, $post_desc4mod, 

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

'$post_description', '$post_desc4mod', 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#

"UPDATE " . TOPICS_TABLE . " SET topic_title = '$post_subject', 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#

topic_description='$post_description', topic_descmod='$post_desc4mod', 

# 
#-----[ FIND ]------------------------------------------ 
# 

add_search_words(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, stripslashes( $post_description)

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions_search.php

# 
#-----[ FIND ]------------------------------------------ 
# 

function add_search_words($mode, $post_id, $post_text, $post_title = '')

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

)

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, $post_desc = ''

# 
#-----[ FIND ]------------------------------------------ 
# 

$search_raw_words['title'] = split_words(clean_words('post', $post_title, $stopword_array, $synonym_array));

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
$search_raw_words['desc'] = split_words(clean_words('post', $post_desc, $stopword_array, $synonym_array));

# 
#-----[ FIND ]------------------------------------------ 
# 

$title_match = ( $word_in == 'title' ) ? 1 : 0;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
$desc_match = ( $word_in == 'desc' ) ? 1 : 0;

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "INSERT INTO " . SEARCH_MATCH_TABLE . " (post_id, word_id, title_match) 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

title_match

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, desc_match

# 
#-----[ FIND ]------------------------------------------ 
# 

SELECT $post_id, word_id, $title_match  

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$title_match

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, $desc_match

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/usercp_register.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $board_config['allow_smilies'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic desription add
$showdescriptions = ( isset($HTTP_POST_VARS['showdescriptions']) ) ? ( ($HTTP_POST_VARS['showdescriptions']) ? TRUE : 0 ) : $board_config['allow_descriptions'];
$showtooltips = ( isset($HTTP_POST_VARS['showtooltips']) ) ? ( ($HTTP_POST_VARS['showtooltips']) ? TRUE : 0 ) : $board_config['show_tooltips'];
$tooltips_static = ( isset($HTTP_POST_VARS['tooltips_static']) ) ? ( ($HTTP_POST_VARS['tooltips_static']) ? TRUE : 0 ) : $board_config['tooltips_static'];
$tooltips_parse = ( isset($HTTP_POST_VARS['tooltips_parse']) ) ? ( ($HTTP_POST_VARS['tooltips_parse']) ? TRUE : 0 ) : $board_config['tooltips_parse'];
$toolimg_width = ( isset( $HTTP_POST_VARS['toolimg_width'] ) ) ? intval( $HTTP_POST_VARS['toolimg_width'] ) : $board_config['toolimg_width'];
$toolimg_height = ( isset( $HTTP_POST_VARS['toolimg_height'] ) ) ? intval( $HTTP_POST_VARS['toolimg_height'] ) : $board_config['toolimg_height'];
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $userdata['user_allowsmile'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic desription add
$showdescriptions = ( isset($HTTP_POST_VARS['showdescriptions']) ) ? ( ($HTTP_POST_VARS['showdescriptions']) ? TRUE : 0 ) : $userdata['user_show_descriptions'];
$showtooltips = ( isset($HTTP_POST_VARS['showtooltips']) ) ? ( ($HTTP_POST_VARS['showtooltips']) ? TRUE : 0 ) : $userdata['user_show_tooltips'];
$tooltips_static = ( isset($HTTP_POST_VARS['tooltips_static']) ) ? ( ($HTTP_POST_VARS['tooltips_static']) ? TRUE : 0 ) : $userdata['user_tooltips_static'];
$tooltips_parse = ( isset($HTTP_POST_VARS['tooltips_parse']) ) ? ( ($HTTP_POST_VARS['tooltips_parse']) ? TRUE : 0 ) : $userdata['user_tooltips_parse'];
$toolimg_width = intval ( ( isset( $HTTP_POST_VARS['toolimg_width'] ) ) ? $HTTP_POST_VARS['toolimg_width'] : $userdata['user_toolimg_width'] );
$toolimg_height = intval ( ( isset( $HTTP_POST_VARS['toolimg_height'] ) ) ? $HTTP_POST_VARS['toolimg_height'] : $userdata['user_toolimg_height'] );
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "UPDATE " . USERS_TABLE . "

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add to sql query

# 
#-----[ FIND ]------------------------------------------ 
# 

SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'",

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

user_allowbbcode = $allowbbcode,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 user_showdescriptions = $showdescriptions, user_showtooltips = $showtooltips, user_tooltips_parse = $tooltips_parse, user_tooltips_static = $tooltips_static, user_toolimg_width = $toolimg_width, user_toolimg_height = $toolimg_height,

# 
#-----[ FIND ]------------------------------------------ 
# 
 
sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add to sql query

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

user_allowbbcode,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 user_showdescriptions, user_showtooltips, user_tooltips_parse, user_tooltips_static, user_toolimg_width, user_toolimg_height,
 
# 
#-----[ FIND ]------------------------------------------ 
# 

VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() .

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$allowbbcode,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 $showdescriptions, $showtooltips, $tooltips_parse, $tooltips_static, $toolimg_width, $toolimg_height,
 
# 
#-----[ FIND ]------------------------------------------ 
# 

$allowviewonline = $userdata['user_allow_viewonline'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
$showdescriptions = $userdata['user_showdescriptions'];
$showtooltips = $userdata['user_showtooltips'];
$tooltips_parse = $userdata['user_tooltips_parse'];
$tooltips_static = $userdata['user_tooltips_static'];
$toolimg_width = $userdata['user_toolimg_width'];
$toolimg_height = $userdata['user_toolimg_height'];
// mod topic description add

# 
#-----[ FIND ]------------------------------------------ 
# 

display_avatar_gallery(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$allowbbcode,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 $showdescriptions, $showtooltips, $tooltips_parse, $tooltips_static, $toolimg_width, $toolimg_height,

# 
#-----[ FIND ]------------------------------------------ 
# 
  
'ALWAYS_ALLOW_BBCODE_NO' => ( !$allowbbcode ) ? 'checked="checked"' : '',

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
'SHOW_DESCRIPTIONS_YES' => ( $showdescriptions ) ? 'checked="checked"' : '',
'SHOW_DESCRIPTIONS_NO' => ( !$showdescriptions ) ? 'checked="checked"' : '',
'SHOW_TOOLTIPS_YES' => ( $showtooltips ) ? 'checked="checked"' : '',
'SHOW_TOOLTIPS_NO' => ( !$showtooltips ) ? 'checked="checked"' : '',
'TOOLTIPS_PARSE_YES' => ( $tooltips_parse ) ? 'checked="checked"' : '',
'TOOLTIPS_PARSE_NO' => ( !$tooltips_parse ) ? 'checked="checked"' : '',
'TOOLTIPS_STATIC_YES' => ( $tooltips_static ) ? 'checked="checked"' : '',
'TOOLTIPS_STATIC_NO' => ( !$tooltips_static ) ? 'checked="checked"' : '',
'TOOLIMG_WIDTH' => $toolimg_width,
'TOOLIMG_HEIGHT' => $toolimg_height,
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_ALWAYS_ALLOW_BBCODE' => $lang['Always_bbcode'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
'L_SHOW_DESCRIPTIONS' => $lang['show_descriptions'],
'L_SHOW_TOOLTIPS' => $lang['show_tooltips'],
'L_TOOLTIPS_EXP' => $lang['tooltips_explain'],
'L_TOOLTIPS_PARSE' => $lang['tooltips_parse'],
'L_TOOLTIPS_PARSE_EXP' => $lang['tooltips_parse_explain'],
'L_TOOLTIPS_STATIC' => $lang['tooltips_static'],
'L_TOOLTIPS_STATIC_EXP' => $lang['tooltips_static_explain'],
'L_TOOLIMG_SIZE' => $lang['toolimg_size'],
// mod topic description end

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/usercp_avatar.php

# 
#-----[ FIND ]------------------------------------------ 
# 

function display_avatar_gallery(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

&$allowbbcode,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 &$showdescriptions, &$showtooltips, &$tooltips_parse, &$tooltips_static, &$toolimg_width, &$toolimg_height,

# 
#-----[ FIND ]------------------------------------------ 
# 
 
$params = array('coppa',

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

'allowbbcode',

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 'showdescriptions', 'showtooltips', 'tooltips_parse', 'tooltips_static', 'toolimg_width', 'toolimg_height',
 
# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/page_header.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$template->pparse('overall_header');

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
if ( $board_config['desc_postparsing'] || $board_config['desc_postparsing_tool'] )
{
	if ( is_object( $Sajax ) )
	{
		$Sajax->add2export( 'description_parse', '$desc, $id' );
		$Sajax->add2export( 'tooltip_postparse', '$topic_id' );
		$Sajax->sajax_remote_uri = $Sajax->sajax_get_my_uri();
		$Sajax->sajax_init();
		$Sajax->sajax_export();
		$Sajax->sajax_handle_client_request();
		$template->assign_var( 'SAJAX_JAVASCRIPT', $Sajax->sajax_get_javascript() );
	}
}
// mod topic description end

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
$user_allowdesc = ( !empty($HTTP_POST_VARS['user_allowdesc']) ) ? intval( $HTTP_POST_VARS['user_allowdesc'] ) : 0;
$user_allowmoddesc = ( !empty($HTTP_POST_VARS['user_allowmoddesc']) ) ? intval( $HTTP_POST_VARS['user_allowmoddesc'] ) : 0;
$showtooltips = ( isset($HTTP_POST_VARS['showtooltips']) ) ? ( ($HTTP_POST_VARS['showtooltips']) ? TRUE : 0 ) : $userdata['user_show_tooltips'];
$tooltips_static = ( isset($HTTP_POST_VARS['tooltips_static']) ) ? ( ($HTTP_POST_VARS['tooltips_static']) ? TRUE : 0 ) : $userdata['user_tooltips_static'];
$tooltips_parse = ( isset($HTTP_POST_VARS['tooltips_parse']) ) ? ( ($HTTP_POST_VARS['tooltips_parse']) ? TRUE : 0 ) : $userdata['user_tooltips_parse'];
$toolimg_width = ( isset($HTTP_POST_VARS['toolimg_width']) ) ? ( ($HTTP_POST_VARS['toolimg_width']) ? TRUE : 0 ) : $userdata['user_toolimg_width'];
$toolimg_height = ( isset($HTTP_POST_VARS['toolimg_height']) ) ? ( ($HTTP_POST_VARS['toolimg_height']) ? TRUE : 0 ) : $userdata['user_toolimg_height'];
// mod topic description mod end?

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "UPDATE " . USERS_TABLE . "

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description mod add to query

# 
#-----[ FIND ]------------------------------------------ 
# 

SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email)

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

user_allowavatar = $user_allowavatar, 

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

user_allowdesc = '$user_allowdesc', user_allowmoddesc = '$user_allowmoddesc', user_showdescriptions = '$showdescriptions', user_showtooltips = '$showtooltips', user_tooltips_parse = '$tooltips_parse', user_tooltips_static = '$tooltips_static', user_toolimg_width = '$toolimg_width', user_toolimg_height = '$toolimg_height', 

# 
#-----[ FIND ]------------------------------------------ 
# 

$user_allowpm = $this_userdata['user_allow_pm'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
$user_allowdesc = $this_userdata['user_allowdesc'];
$user_allowmoddesc = $this_userdata['user_allowmoddesc'];
$user_showdescriptions = $this_userdata['user_showdescriptions'];
$user_showtooltips = $this_userdata['user_showtooltips'];
$user_tooltips_parse = $this_userdata['user_tooltips_parse'];
$user_tooltips_static = $this_userdata['user_tooltips_static'];
$user_toolimg_width = $this_userdata['user_toolimg_width'];
$user_toolimg_height = $this_userdata['user_toolimg_height'];
// mod topic description mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

$s_hidden_fields .= '<input type="hidden" name="user_rank" value="' . $user_rank . '" />';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
$s_hidden_fields .= '<input type="hidden" name="user_allowdesc" value="' . $user_allowdesc . '" />';
$s_hidden_fields .= '<input type="hidden" name="user_allowmoddesc" value="' . $user_allowmoddesc . '" />';
$s_hidden_fields .= '<input type="hidden" name="user_showdescriptions" value="' . $user_showdescriptions . '" />';
$s_hidden_fields .= '<input type="hidden" name="user_showtooltips" value="' . $user_showtooltips . '" />';
$s_hidden_fields .= '<input type="hidden" name="user_tooltips_parse" value="' . $user_tooltips_parse . '" />';
$s_hidden_fields .= '<input type="hidden" name="user_tooltips_parse" value="' . $user_tooltips_static . '" />';
// mod topic description mod end

# 
#-----[ FIND ]------------------------------------------ 
# 

'RANK_SELECT_BOX' => $rank_select_box,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
'ALLOW_DESC_YES' => ($user_allowdesc) ? 'checked="checked"' : '',
'ALLOW_DESC_NO' => (!$user_allowdesc) ? 'checked="checked"' : '',
'ALLOW_MODDESC_YES' => ($user_allowmoddesc) ? 'checked="checked"' : '',
'ALLOW_MODDESC_NO' => (!$user_allowmoddesc) ? 'checked="checked"' : '',
'SHOW_DESCRIPTIONS_YES' => ( $user_showdescriptions ) ? 'checked="checked"' : '',
'SHOW_DESCRIPTIONS_NO' => ( !$user_showdescriptions ) ? 'checked="checked"' : '',
'SHOW_TOOLTIPS_YES' => ( $user_showtooltips ) ? 'checked="checked"' : '',
'SHOW_TOOLTIPS_NO' => ( !$user_showtooltips ) ? 'checked="checked"' : '',
'TOOLTIPS_PARSE_YES' => ( $user_tooltips_parse ) ? 'checked="checked"' : '',
'TOOLTIPS_PARSE_NO' => ( !$user_tooltips_parse ) ? 'checked="checked"' : '',
'TOOLTIPS_STATIC_YES' => ( $user_tooltips_static ) ? 'checked="checked"' : '',
'TOOLTIPS_STATIC_NO' => ( !$user_tooltips_static ) ? 'checked="checked"' : '',
'TOOLIMG_WIDTH' => $user_toolimg_width,
'TOOLIMG_HEIGHT' => $user_toolimg_height,
'L_ALLOW_DESC' => $lang['user_allowdesc'],
'L_ALLOW_MODDESC' => $lang['user_allowmoddesc'],
'L_SHOW_DESCRIPTIONS' => $lang['show_descriptions'],
'L_SHOW_TOOLTIPS' => $lang['show_tooltips'],
'L_TOOLTIPS_EXP' => $lang['tooltips_explain'],
'L_TOOLTIPS_PARSE' => $lang['tooltips_parse'],
'L_TOOLTIPS_PARSE_EXP' => $lang['tooltips_parse_explain'],
'L_TOOLTIPS_STATIC' => $lang['tooltips_static'],
'L_TOOLTIPS_STATIC_EXP' => $lang['tooltips_static_explain'],
'L_TOOLIMG_SIZE' => $lang['toolimg_size'],
// mod topic description mod add

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_forumauth.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//                View      Read      Post      Reply     Edit     Delete    Sticky   Announce    Vote      Poll

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

Poll

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

      Desc      ModDesc      Tooltip
// mod topic description mod add to array
      
# 
#-----[ FIND ]------------------------------------------ 
# 

0  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_ALL, AUTH_ALL, AUTH_ALL

# 
#-----[ FIND ]------------------------------------------ 
# 

1  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_REG, AUTH_REG, AUTH_ALL

# 
#-----[ FIND ]------------------------------------------ 
# 

2  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_REG, AUTH_REG, AUTH_REG

# 
#-----[ FIND ]------------------------------------------ 
# 

3  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_ACL, AUTH_ACL, AUTH_ALL

# 
#-----[ FIND ]------------------------------------------ 
# 

4  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_ACL, AUTH_ACL, AUTH_ACL

# 
#-----[ FIND ]------------------------------------------ 
# 

5  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_MOD, AUTH_MOD, AUTH_ALL

# 
#-----[ FIND ]------------------------------------------ 
# 

6  => array(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

),

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, AUTH_MOD, AUTH_MOD, AUTH_MOD

# 
#-----[ FIND ]------------------------------------------ 
# 

$forum_auth_fields

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description mod add to array

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, 'auth_desc', 'auth_moddesc', 'auth_tooltip'

# 
#-----[ FIND ]------------------------------------------ 
# 

$field_names

# 
#-----[ FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
'auth_desc' => $lang['desc'],
'auth_moddesc' => $lang['moddesc'],
'auth_tooltip' => $lang['tooltip']);
// mod topic description mod end

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_ug_auth.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$forum_auth_fields

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add to array

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, 'auth_desc', 'auth_moddesc', 'auth_tooltip'

# 
#-----[ FIND ]------------------------------------------ 
# 

$auth_field_match

# 
#-----[ FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description add
'auth_desc' => AUTH_DESC,
'auth_moddesc' => AUTH_MODDESC,
'auth_tooltip' => AUTH_TOOLTIP);
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

$field_names

# 
#-----[ FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);


# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
'auth_desc' => $lang['desc'],
'auth_moddesc' => $lang['moddesc'],
'auth_tooltip' => $lang['tooltip']);
// mod topic description mod end

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/search_results_posts.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

class="topictitle">{searchresults.TOPIC_TITLE}

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

class="topictitle"

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 {searchresults.TOPIC_TOOLTIP}

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

{searchresults.TOPIC_TITLE}</a></span>

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

<span class="gen">&nbsp;&nbsp;{searchresults.TOPIC_DESC}</span>

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/search_results_topics.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<td class="row2"><span class="topictitle">{searchresults.NEWEST_POST_IMG}{searchresults.TOPIC_TYPE}<a href="{searchresults.U_VIEW_TOPIC}" class="topictitle">{searchresults.TOPIC_TITLE}</a></span><br /><span class="gensmall">{searchresults.GOTO_PAGE}</span></td>

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

class="topictitle"

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 {searchresults.TOPIC_TOOLTIP}

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

{searchresults.TOPIC_TITLE}</a></span>

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

<span class="gen">{searchresults.TOPIC_DESC}</span>


# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

//-->
</script>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description function
function desc_charleft( object, maxlength )
{
	left = maxlength - object.value.length;
	document.getElementById( "desc_charleftrep" ).innerHTML = '{L_DESC_LEFT1}' + left + '{L_DESC_LEFT2}';
}
// mod topic description end

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
		<input type="text" id="description" name="description" size="45" maxlength="{S_DESC_LENGTH}" style="width:450px" tabindex="2" class="post" value="{DESCRIPTION}" onkeydown="desc_charleft( this, {S_DESC_LENGTH} );" />&nbsp; 
		<!-- BEGIN switch_moddescription -->
		<input type="checkbox" name="desc4mod" {S_DESC4MOD_CHECKED} />&nbsp; {L_DESC4MOD}
		<!-- END switch_moddescription -->
		</span> 
		<br /><span class="gensmall" id="desc_charleftrep"></span>
	  </td>
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

{POST_SUBJECT}

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

<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a>

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

href="{topicrow.U_VIEW_TOPIC}"

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 {topicrow.TOPIC_TOOLTIP}
	
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

templates/subSilver/viewtopic_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<td align="left" valign="bottom" colspan="2"><a class="maintitle" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a><br />

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

<br />

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

<span class="gen">{TOPIC_DESC}</span><br />

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/overall_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

</head>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

<script language="Javascript" type="text/javascript">
<!--
{SAJAX_JAVASCRIPT}

function description_postparse( desc, id )
{
	x_description_parse( desc, id, description_backparse );
}

function description_backparse( get )
{
	document.getElementById( get[ 0 ] ).innerHTML = get[ 1 ];
}

function tool_postparse( id )
{
	x_tooltip_postparse( id, tool_backparse );
}

function tool_backparse( get )
{
	document.getElementById( get[ 0 ] ).innerHTML = get[ 1 ];
}
//-->
</script>

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/overall_footer.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

</body>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

<script language="JavaScript" type="text/javascript" src="templates/wz_tooltip.js"></script>

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<tr> 
	  <td class="row1"><span class="gen">{L_SHOW_DESCRIPTIONS}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="showdescriptions" value="1" {SHOW_DESCRIPTIONS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="showdescriptions" value="0" {SHOW_DESCRIPTIONS_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_SHOW_TOOLTIPS}:</span><br /><span class="gensmall">{L_SHOW_TOOLTIPS_EXP}</span></td>
	  <td class="row2"> 
		<input type="radio" name="showtooltips" value="1" {SHOW_TOOLTIPS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="showtooltips" value="0" {SHOW_TOOLTIPS_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TOOLTIPS_PARSE}:</span><br /><span class="gensmall">{L_TOOLTIPS_PARSE_EXP}</span></td>
	  <td class="row2"> 
		<input type="radio" name="tooltips_parse" value="1" {TOOLTIPS_PARSE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="tooltips_parse" value="0" {TOOLTIPS_PARSE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TOOLTIPS_STATIC}:</span><br /><span class="gensmall">{L_TOOLTIPS_PARSE_EXP}</span></td>
	  <td class="row2"> 
		<input type="radio" name="tooltips_static" value="1" {TOOLTIPS_STATIC_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="tooltips_static" value="0" {TOOLTIPS_STATIC_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_TOOLIMG_SIZE}</span></td>
		<td class="row2"><span class="gen"><input type="text" size="5" maxlength="5" name="toolimg_width" value="{TOOLIMG_WIDTH}" /> X <input type="text" size="5" maxlength="5" name="toolimg_height" value="{TOOLIMG_HEIGHT}" /></span></td>
	</tr>

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/user_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<tr> 
	  <td class="row1"><span class="gen">{L_SHOW_DESCRIPTIONS}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="showdescriptions" value="1" {SHOW_DESCRIPTIONS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="showdescriptions" value="0" {SHOW_DESCRIPTIONS_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_SHOW_TOOLTIPS}:</span><br /><span class="gensmall">{L_SHOW_TOOLTIPS_EXP}</span></td>
	  <td class="row2"> 
		<input type="radio" name="showtooltips" value="1" {SHOW_TOOLTIPS_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="showtooltips" value="0" {SHOW_TOOLTIPS_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TOOLTIPS_PARSE}:</span><br /><span class="gensmall">{L_TOOLTIPS_PARSE_EXP}</span></td>
	  <td class="row2"> 
		<input type="radio" name="tooltips_parse" value="1" {TOOLTIPS_PARSE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="tooltips_parse" value="0" {TOOLTIPS_PARSE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TOOLTIPS_STATIC}:</span><br /><span class="gensmall">{L_TOOLTIPS_STATIC_EXP}</span></td>
	  <td class="row2"> 
		<input type="radio" name="tooltips_static" value="1" {TOOLTIPS_STATIC_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="tooltips_static" value="0" {TOOLTIPS_STATIC_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_TOOLIMG_SIZE}</td>
		<td class="row2"><input type="text" size="5" maxlength="5" name="toolimg_width" value="{TOOLIMG_WIDTH}" /> X <input type="text" size="5" maxlength="5" name="toolimg_height" value="{TOOLIMG_HEIGHT}" /></td>
	</tr>

# 
#-----[ FIND ]------------------------------------------ 
# 

<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_AVATAR}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allowavatar" value="1" {ALLOW_AVATAR_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allowavatar" value="0" {ALLOW_AVATAR_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<tr> 
  <td class="row1"><span class="gen">{L_ALLOW_DESC}</span></td>
  <td class="row2"> 
	<input type="radio" name="user_allowdesc" value="1" {ALLOW_DESC_YES} />
	<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
	<input type="radio" name="user_allowdesc" value="0" {ALLOW_DESC_NO} />
	<span class="gen">{L_NO}</span></td>
</tr>
<tr> 
  <td class="row1"><span class="gen">{L_ALLOW_MODDESC}</span></td>
  <td class="row2"> 
	<input type="radio" name="user_allowmoddesc" value="1" {ALLOW_MODDESC_YES} />
	<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
	<input type="radio" name="user_allowmoddesc" value="0" {ALLOW_MODDESC_NO} />
	<span class="gen">{L_NO}</span></td>
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
$lang['Descriptions'] = 'Descriptions';
$lang['Click_return_descconfig'] = 'Click %sHere%s to return to Descriptions configuration';
$lang['user_allowdesc'] = 'Can post topic descriptions';
$lang['user_allowmoddesc'] = 'Can post topic descriptions for mods';
$lang['desc_settings_explain'] = 'Edit the options about topic descriptions';
$lang['permissions'] = 'Permissions';
$lang['guestdesc'] = 'Guests can add descriptions';
$lang['guestmoddesc'] = 'Guests can add mod only descriptions';
$lang['disallowed_seedesc'] = 'Users who are not allowed to use descriptions can see them';
$lang['tooltips'] = 'Tooltips';
$lang['tooltips_show'] = 'Enable topic tooltips';
$lang['tooltips_static'] = 'Tooltips are static';
$lang['tooltips_parse'] = 'Parse tooltips as normal posts';
$lang['desc'] = 'Description';
$lang['moddesc'] = 'ModDescription';
$lang['tooltip'] = 'Tooltip';
$lang['desc_length'] = 'Description max. length';
$lang['desc_tolink'] = 'All descriptions show as a link to the starter\'s profile. This obbeys permissions.'; 
$lang['desc_linkforce'] = 'All descriptions show as a link to the starter\'s profile. This overrides permissions.';
$lang['desc_linkempty'] = 'All empty descriptions are turned into links to the starter\'s profile.';
$lang['toolimg_size'] = 'Maximum size of images in tooltips. <b>Note: </b>For now images have been disabled';
$lang['desc_prev'] = 'All descriptions show as the first %d chars of first post. This overrides permissions.';
$lang['desc_parse'] = 'Description parsing';
$lang['desc_html'] = 'Allow HTML parsing within descriptions';
$lang['desc_bbcode'] = 'Allow BBCode parsing within descriptions';
$lang['desc_smile'] = 'Allow smiley parsing withing descriptions';
$lang['desc_bbcode_hatelist'] = 'Input BBCode tags that you do not wish to be parsed in descriptions and tooltips, separated by a space';
$lang['desc_bbcode_remove'] = 'Completely remove BBCode that is in the hatelist';
$lang['desc_tooltips_maxpostize'] = 'Maximum length of post preview in tooltips';
$lang['desc_tooltips_modify'] = 'To modify the way tooltips with previews look and behave you should edit the file template/<your template>/preview_tooltip_params.cfg.<br />There you can set many options from the color scheme to placement. For a list of options you should go <a href="http://www.walterzorn.com/tooltip/tooltip_e.htm" target="_blank">here</a><br />Please do not meddle with the T_STICKY option, it might give unexpected results as it is already set through the ACP / UCP.';
$lang['desc_postparsing'] = 'Enable description postparsing (move BBCode parsing of descriptions to ajax to lighten load)';
$lang['desc_postparsingt'] = 'Enable tooltip postparsing (move BBCode parsing of tooltips to ajax to lighten load)'; 
$lang['desc_bbcodeparsing'] = 'BBCode parsing options';

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['Search_title_msg'] = 'Search topic title and message text';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

topic title

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, topic description

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
$lang['show_descriptions'] = 'Show topic descriptions';
$lang['show_tooltips'] = 'Show topic tooltips';
$lang['show_tooltips_explain'] = 'Tooltips show additional information about the topic';
$lang['tooltips_parse'] = 'Parse tooltips';
$lang['tooltips_parse_explain'] = 'Shows images and links';
$lang['tooltips_static'] = 'Tooltips are static';
$lang['tooltips_static_explain'] = 'Tooltips don\'t move with the mouse and can be clicked';
$lang['toolimg_size'] = 'Maximum size of images in tooltips';
$lang['first_post'] = 'First post';
$lang['last_post'] = 'Last post';
$lang['Desc_charleft1'] = 'You have ';
$lang['Desc_charleft2'] = ' characters left.';
$lang['Desc_only4mod'] = 'Description for mods: ';
$lang['Desc_parsetool'] = '<b>Postparse tooltip</b>';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM