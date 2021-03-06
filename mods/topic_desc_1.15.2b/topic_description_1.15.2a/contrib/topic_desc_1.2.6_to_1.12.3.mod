############################################################## 
## MOD Title: topic description 
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: Adds new features to the already installed description mod v1.2.6, check history.txt and readme.txt for detailed information. There are no guaranties that this will actually work and/or have all the functionality. Sorry but the changes are just really complex.
## MOD Version: 1.12.3
## 
## Installation Level: Intermediate
## Installation Time: ~45 Minutes 
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
##		  admin/admin_board.php
##		  admin/admin_users.php
##		  admin/admin_forumauth.php
##		  admin/admin_ug_auth.php
##		  templates/subSilver/search_results_posts.tpl
##		  templates/subSilver/search_results_topics.tpl
##		  templates/subSilver/posting_body.tpl
##		  templates/subSilver/viewforum_body.tpl
##		  templates/subSilver/viewtopic_body.tpl
##		  templates/subSilver/overall_footer.tpl
##		  templates/subSilver/profile_add_body.tpl
##		  templates/subSilver/admin/board_config_body.tpl
##		  templates/subSilver/admin/user_edit_body.tpl
##		  language/lang_english/lang_admin.php
##		  language/lang_english/lang_main.php
## Included Files: includes/functions_desc.php
##		   admin/admin_desc.php
##		   templates/wz_tooltip.js
##		   templates/subSilver/admin/board_config_body.tpl
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
#-----[ DIY INSTRUCTIONS ]------------------------------------------ 
# 

EasyMOD might return an error when doing the SQL alterations. If you run them through phpMyAdmin or something similar by hand they seem to work well enough.

//

I am sorry for the inconvenience but if after this update is done you keep getting two description boxes when you make a topic or whatever please go to posting.php and remove everything that looks like:
// mod topic description add
 if ( $candesc ) {
 	$template -> assign_block_vars ( 'switch_description', array () );
 }
 if ( $canmoddesc ) {
 	$template -> assign_block_vars ( 'switch_description.switch_moddescription', array () );
 }
// mod topic description end

LEAVE just the one that is like so:
// mod topic description add
 if ( $candesc ) {
 	$template -> assign_block_vars ( 'switch_description', array () );
 }
 if ( $canmoddesc ) {
 	$template -> assign_block_vars ( 'switch_description.switch_moddescription', array () );
 }
// mod topic description end

if( $refresh || isset($HTTP_POST_VARS['del_poll_option']) || $error_msg != '' )

Again sorry for this, but it would be quite a task to fix up this .mod file to do this on it's own, sorry again.

# 
#-----[ SQL ]------------------------------------------ 
# 

ALTER TABLE `phpbb_search_wordmatch` ADD `desc_match` TINYINT( 1 ) NOT NULL ;
ALTER TABLE `phpbb_users` ADD `user_allowdesc` TINYINT( 1 ) DEFAULT '1' NOT NULL ,
ADD `user_allowmoddesc` TINYINT( 1 ) DEFAULT '1' NOT NULL ;
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
ALTER TABLE `phpbb_forums` ADD `auth_desc` TINYINT( 2 ) NOT NULL ,
ADD `auth_moddesc` TINYINT( 2 ) NOT NULL ,
ADD `auth_tooltip` TINYINT( 2 ) NOT NULL ;
ALTER TABLE `phpbb_auth_access` ADD `auth_desc` TINYINT( 2 ) NOT NULL ,
ADD `auth_moddesc` TINYINT( 2 ) NOT NULL ,
ADD `auth_tooltip` TINYINT( 2 ) NOT NULL ;
ALTER TABLE `phpbb_users` ADD `user_showdescriptions` TINYINT( 1 ) DEFAULT '1' NOT NULL ,
ADD `user_showtooltips` TINYINT( 1 ) DEFAULT '1' NOT NULL ,
ADD `user_tooltips_parse` TINYINT( 1 ) DEFAULT '1' NOT NULL ,
ADD `user_tooltips_static` TINYINT( 1 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `phpbb_users` ADD `user_toolimg_width` INT( 5 ) DEFAULT '250' NOT NULL ,
ADD `user_toolimg_height` INT( 5 ) DEFAULT '250' NOT NULL;

# 
#-----[ COPY ]------------------------------------------ 
# 

copy includes/functions_desc.php to includes/functions_desc.php
copy admin/admin_desc.php to admin/admin_desc.php
copy templates/wz_tooltip.js to templates/wz_tooltip.js
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

# 
#-----[ OPEN ]------------------------------------------ 
# 

posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $mode == 'editpost' || $mode == 'delete' || $mode == 'poll_delete' )

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
$candesc = check_descperm ( );
if ( $candesc == AUTH_NODESC ) {
	$candesc = FALSE;
	$canmoddesc = FALSE;
}elseif ( $candesc == AUTH_DESC ) {
	$candesc = TRUE;
	$candescmod = FALSE;
}elseif ( $candesc == AUTH_MODDESC ) {
	$candesc = TRUE;
	$canmoddesc = TRUE;
}
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

$post_desc4mod = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['desc4mod']) ) ? TRUE : FALSE ) : FALSE;

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

!empty($HTTP_POST_VARS['desc4mod'])

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 && $canmoddesc

# 
#-----[ FIND ]------------------------------------------ 
# 

$post_description = ( !empty($HTTP_POST_VARS['description']) ) ? trim($HTTP_POST_VARS['description']) : '';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

!empty($HTTP_POST_VARS['description'])

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 && $candesc
 
# 
#-----[ FIND ]------------------------------------------ 
# 

prepare_post(

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

);

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

, $post_description

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description: add argument

# 
#-----[ FIND ]------------------------------------------ 
# 

$post_description = ( !empty($HTTP_POST_VARS['description']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['description']))) : '';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

!empty($HTTP_POST_VARS['description'])

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 && $candesc

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $board_config ']allow_descriptions'] && ( !$board_config ']only_mods_desc'] || ( $board_config ']only_mods_desc'] && $is_auth['auth_mod'] ) ) )  

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

if ( $candesc ) 

# 
#-----[ FIND ]------------------------------------------ 
# 

$template -> assign_block_vars ( 'switch_description', array () );

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

if ( $canmoddesc ) {
	$template -> assign_block_vars ( 'switch_description.switch_moddescription', array () );
}
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_DESC' => $preview_description,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

'S_DESC_LENGTH' => $board_config']desc_length'],
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $board_config ']allow_descriptions'] && ( !$board_config ']only_mods_desc'] || ( $board_config ']only_mods_desc'] && $is_auth['auth_mod'] ) ) ) 

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

if ( $candesc ) 

# 
#-----[ FIND ]------------------------------------------ 
# 

$template -> assign_block_vars ( 'switch_description', array ( ) );

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

if ( $canmoddesc ) {
	$template -> assign_block_vars ( 'switch_description.switch_moddescription', array () );
}
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

$post_description = ( $post_data['first_post'] && ( !$board_config ']only_mods_desc'] || ( $board_config ']only_mods_desc'] && $is_auth['auth_mod'] ) ) ) ? $post_info['topic_description'] : '';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$post_data['first_post'] && ( !$board_config ']only_mods_desc'] || ( $board_config ']only_mods_desc'] && $is_auth['auth_mod'] ) )

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

$candesc

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $post_data['first_post'] && $board_config ']allow_descriptions']  && ( !$board_config ']only_mods_desc'] || ( $board_config ']only_mods_desc'] && $is_auth['auth_mod'] ) ) )

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

if ( $candesc )

# 
#-----[ FIND ]------------------------------------------ 
# 

$template -> assign_block_vars ( 'switch_description', array () );

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

if ( $canmoddesc ) {
	$template -> assign_block_vars ( 'switch_description.switch_moddescription', array () );
}
// mod topic description end

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

'DESCRIPTION' => $post_description,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

'S_DESC_LENGTH' => $board_config']desc_length'],
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

'S_DESC4MOD_CHECKED' => ( $post_desc4mod ) ? 'checked="checked"' : '', 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$post_desc4mod

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 

$post_info']topic_descmod']

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

$topic_title = $searchset[$i]['topic_title'];

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

$post_desc4mod = $topic_rowset[$i]']topic_descmod'];
if ( $topic_desc != '' && $board_config']allow_descriptions'] ) {
	if ( !$post_desc4mod ) {
		$s = TRUE;
	}elseif ( ( $topic_rowset[$i]['user_id'] == $userdata']user_id'] ) || $is_auth']auth_mod'] ) {
		$s = TRUE;
	}else $s = FALSE;
}else $s = FALSE;
$topic_desc = ( $s ) ? '<br />' . $topic_desc : '';

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

$post_desc4mod = $topic_rowset[$i]['topic_descmod'];
$topic_desc = fetch_desc ( $topic_desc, $bbcode_uid, TRUE );
$topic_tool = ( show_tooltip ( $forum_id, $topic_id ) ) ? topic_tooltip ( $topic_id ) : '';
// mod topic description end

# 
#-----[ FIND ]------------------------------------------ 
# 

'TOPIC_DESC' => $topic_desc,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

'TOPIC_TOOLTIP' => $topic_tool,

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

 t.topic_description,

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

add_search_words('single', $post_id, stripslashes($post_message), stripslashes($post_subject));

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
$showtooltips = ( isset($HTTP_POST_VARS['showtooltips']) ) ? ( ($HTTP_POST_VARS['showtooltips']) ? TRUE : 0 ) : $buserdata['user_show_tooltips'];
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
'L_TOOLIMG_SIZE' => $lang']toolimg_size'],
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

admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 

// mod topic description add
$post_description_yes = ( $new['allow_descriptions'] ) ? "checked=\"checked\"" : "";
$post_description_no = ( !$new['allow_descriptions'] ) ? "checked=\"checked\"" : "";
$descmods_yes = ( $new['only_mods_desc'] ) ? "checked=\"checked\"" : "";
$descmods_no = ( !$new['only_mods_desc'] ) ? "checked=\"checked\"" : "";

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

// topic description mod code removed for update

# 
#-----[ FIND ]------------------------------------------ 
# 

// mod topic description: add
"L_ALLOW_DESC" => $lang']allow_desc'],
"L_MODS_DESC" => $lang']mods_desc'],
"L_DESCRIPTION_SETTINGS" => $lang ']desc_settings'],

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

// topic description mod code removed for update

# 
#-----[ FIND ]------------------------------------------ 
# 

// mod topic description: add
"DESCRIPTION_YES" => $post_description_yes,
"DESCRIPTION_NO" => $post_description_no,
"DESCMODS_YES" => $descmods_yes,
"DESCMODS_NO" => $descmods_no,
// mod topic description end

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

// topic description mod code removed for update

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
$showtooltips = ( isset($HTTP_POST_VARS['showtooltips']) ) ? ( ($HTTP_POST_VARS['showtooltips']) ? TRUE : 0 ) : $buserdata['user_show_tooltips'];
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

user_allowdesc = $user_allowdesc, user_allowmoddesc = $user_allowmoddesc, user_showdescriptions = $showdescriptions, user_showtooltips = $showtooltips, user_tooltips_parse = $tooltips_parse, user_tooltips_static = $tooltips_static, user_toolimg_width = $toolimg_width, user_toolimg_height = $toolimg_height, 

# 
#-----[ FIND ]------------------------------------------ 
# 

$user_allowpm = $this_userdata['user_allow_pm'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
$user_allowdesc = $this_userdata']user_allowdesc'];
$user_allowmoddesc = $this_userdata']user_allowmoddesc'];
$user_showdescriptions = $this_userdata']user_showdescriptions'];
$user_showtooltips = $this_userdata']user_showtooltips'];
$user_tooltips_parse = $this_userdata']user_tooltips_parse'];
$user_tooltips_static = $this_userdata']user_tooltips_static'];
$user_toolimg_width = $this_userdata']user_toolimg_width'];
$user_toolimg_height = $this_userdata']user_toolimg_height'];
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

'ALLOW_AVATAR_NO' => (!$user_allowavatar) ? 'checked="checked"' : '',

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
// mod topic description mod add

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_ALLOW_AVATAR' => $lang['User_allowavatar'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod topic description mod add
'L_ALLOW_DESC' => $lang']user_allowdesc'],
'L_ALLOW_MODDESC' => $lang']user_allowmoddesc'],
'L_SHOW_DESCRIPTIONS' => $lang['show_descriptions'],
'L_SHOW_TOOLTIPS' => $lang['show_tooltips'],
'L_TOOLTIPS_EXP' => $lang['tooltips_explain'],
'L_TOOLTIPS_PARSE' => $lang['tooltips_parse'],
'L_TOOLTIPS_PARSE_EXP' => $lang['tooltips_parse_explain'],
'L_TOOLTIPS_STATIC' => $lang['tooltips_static'],
'L_TOOLTIPS_STATIC_EXP' => $lang['tooltips_static_explain'],
// mod topic description mod end

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
'auth_desc' => $lang']desc'],
'auth_moddesc' => $lang']moddesc'],
'auth_tooltip' => $lang']tooltip']);
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
'auth_desc' => $lang']desc'],
'auth_moddesc' => $lang']moddesc'],
'auth_tooltip' => $lang']tooltip']);
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

templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
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
#-----[ REPLACE WITH ]------------------------------------------ 
# 

<!-- topic description mod code removed for update -->

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<input type="text" name="description" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{DESCRIPTION}" />&nbsp;<input type="checkbox" name="desc4mod" {S_DESC4MOD_CHECKED} />&nbsp;{L_DESC4MOD}

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

<input type="text" name="description" size="45" maxlength="{S_DESC_LENGTH}" style="width:450px" tabindex="2" class="post" value="{DESCRIPTION}" />&nbsp; 
<!-- BEGIN switch_moddescription -->
<input type="checkbox" name="desc4mod" {S_DESC4MOD_CHECKED} />&nbsp;{L_DESC4MOD}
<!-- END switch_moddescription -->

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

<span class="genbig">{TOPIC_DESC}</span><br />

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
	  <td class="row1"><span class="gen">{L_TOOLTIPS_STATIC}:</span><br /><span class="gensmall">{L_TOOLTIPS_PARSE_EXP}</span></td>
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

$lang']desc_settings'] = 'Description settings';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang']Descriptions'] = 'Descriptions';
$lang']Click_return_descconfig'] = 'Click %sHere%s to return to Descriptions configuration';
$lang']user_allowdesc'] = 'Can post topic descriptions';
$lang']user_allowmoddesc'] = 'Can post topic descriptions for mods';
$lang']desc_settings_explain'] = 'Edit the options about topic descriptions';
$lang']permissions'] = 'Permissions';
$lang']guestdesc'] = 'Guests can add descriptions';
$lang']guestmoddesc'] = 'Guests can add mod only descriptions';
$lang']disallowed_seedesc'] = 'Users who are not allowed to use descriptions can see them';
$lang']tooltips'] = 'Tooltips';
$lang']tooltips_show'] = 'Enable topic tooltips';
$lang']tooltips_static'] = 'Tooltips are static';
$lang']tooltips_parse'] = 'Parse tooltips as normal posts';
$lang']desc'] = 'Description';
$lang']moddesc'] = 'ModDescription';
$lang']tooltip'] = 'Tooltip';
$lang']desc_length'] = 'Description max. length';
$lang['desc_tolink'] = 'All descriptions show as a link to the starters profile. This obbeys permissions.';
$lang']desc_linkforce'] = 'All descriptions are turned into a link. This overrides permissions.';
$lang']desc_linkempty'] = 'All empty descriptions are turned into links.';
$lang']toolimg_size'] = 'Maximum size of images in tooltips';
$lang']desc_prev'] = 'All descriptions show as the first %d chars of first post. This overrides permissions.';
$lang['desc_parse'] = 'Description parsing';
$lang['desc_html'] = 'Allow HTML parsing within descriptions';
$lang['desc_bbcode'] = 'Allow BBCode parsing within descriptions';
$lang['desc_smile'] = 'Allow smiley parsing withing descriptions';

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

title

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

, topic description

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['desc4mod'] = 'Description only for moderators';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang['show_descriptions'] = 'Show topic descriptions';
$lang['show_tooltips'] = 'Show topic tooltips';
$lang['show_tooltips_explain'] = 'Tooltips show additional information about the topic';
$lang['tooltips_parse'] = 'Parse tooltips';
$lang['tooltips_parse_explain'] = 'Shows images and links';
$lang['tooltips_static'] = 'Tooltips are static';
$lang['tooltips_static_explain'] = 'Tooltips don\'t move with the mouse and can be clicked on';
$lang']toolimg_size'] = 'Maximum size of images in tooltips';
$lang']first_post'] = 'First post';
$lang']last_post'] = 'Last post';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM