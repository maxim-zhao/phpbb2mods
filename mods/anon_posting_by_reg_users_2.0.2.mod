##############################################################
## MOD Title: Anonymous Posting by Registered Users
## MOD Author: wGEric < N/A > (Eric Faerber) http://mods.best-dev.com
## MOD Author: welldressedmatt < scottm@warner.edu > (Matthew T. Scott) N/A
## MOD Description: Allows registered users to choose whether they
## want their post to be anonymous or not. Admins can still see
## who made the post.
## MOD Version: 2.0.2
##
## Installation Level: Easy
## Installation Time:  30 Minutes
## Files To Edit: index.php
##                posting.php
##                language/lang-english/lang_main.php
##                viewforum.php
##                viewtopic.php
##                includes/functions_post.php
##			includes/topic_review.php
##                templates/subSilver/posting_body.tpl
##                search.php
## Included Files: N/A
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
##   2006-05-05 - Version x2.0.2
##    - Fixed Topic Review bug
##
##   2006-04-13 - Version x2.0.1a
##    - Official release
##
##   2006-03-24 - Version x2.0.1
##    - Fixed various syntax issues
##
##   2006-03-14 - Version x2.0.0
##	- second release (by welldressedmatt)
##      - ADDED FEATURES:
##      - Hides the "Post as Anonymous" checkbox when being editted by a moderator
##      - Removes anonymous user's IP address button from moderator's view
##      - Changes "Edited by [USER'S NAME]..." to "Edited by Anonymous..."
##      - Hides anonymous user's info from Admin EXCEPT for user's profile button
##      - Hides signature in message preview mode
##	- Masks Author's & Last Poster's names if anonymous in Search results
##	- Excludes anonymous posts from Search by Author results
##	- Changes "[quote="[USER'S NAME]"] to [quote="Anonymous"]
##
##   2004-02-06 - Version x1.0.0 
##      - first release (by wGEric)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 
#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE phpbb_posts ADD anon TINYINT( 1 ) DEFAULT '0' NOT NULL ;

#
#-----[ OPEN ]------------------------------------------
#
index.php

#
#-----[ FIND ]------------------------------------------
#
								$last_post .= ( $forum_data[$j]['user_id'] == ANONYMOUS ) ? ( ($forum_data[$j]['post_username'] != '' ) ? $forum_data[$j]['post_username'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $forum_data[$j]['user_id']) . '">' . $forum_data[$j]['username'] . '</a> ';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
                        $anon_sql = "SELECT anon FROM " . POSTS_TABLE . " WHERE post_id = " . $forum_data[$j]['forum_last_post_id'];
                        if ( !($anon_result = $db->sql_query($anon_sql)) )
                        {
                            message_die(GENERAL_ERROR, 'Could not obtain Anonymous status', '', __LINE__, __FILE__, $anon_sql);
                        }
                        $anon_row = $db->sql_fetchrow($anon_result);

                        if ( $anon_row['anon'] == true )
                        {
                           $last_post .= $lang['Anonymous'];
                        }
                        else
                        {

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
		$select_sql = (!$submit)

#
#-----[ IN-LINE FIND ]------------------------------------------
#
p.post_username,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 p.anon,
 
#
#-----[ FIND ]------------------------------------------
#
		$post_data['poster_id'] = $post_info['poster_id'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$post_data['anon'] = ( !empty($post_info['anon']) ) ? true : false;

#
#-----[ FIND ]------------------------------------------
#
$attach_sig = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['attach_sig']) ) ? TRUE : 0 ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? 0 : $userdata['user_attachsig'] );

#
#-----[ AFTER, ADD ]------------------------------------------
#
$anon = ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['anon']) ) ? TRUE : 0 ) : $post_info['anon'];

#
#-----[ FIND ]------------------------------------------
#
				submit_post($mode, $post_data,

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$poll_length

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $anon

#
#-----[ FIND ]------------------------------------------
#
		if( $attach_sig && $user_sig != '' )

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$user_sig != ''

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 && !$anon

#
#-----[ FIND ]------------------------------------------
#
			$message = '[quote="' . $quote_username . '"]' . $message . '[/quote]';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
			if ( $post_info['anon'] )
			{
				$message = '[quote="' . $lang['Anonymous'] . '"]' . $message . '[/quote]';
				$anon = '';
			}
			else
			{

#
#-----[ AFTER, ADD ]------------------------------------------
#
			}

#
#-----[ FIND ]------------------------------------------
#
	'L_STYLES_TIP' => $lang['Styles_tip'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_ANONYMOUS' => $lang['Anonymous'],
	'L_POST_ANONYMOUS' => $lang['Post_Anonymous'],
	'S_ANON' => ( $anon ) ? 'checked="checked"' : '',
	'S_ANON_HIDDEN' => ( $post_data['anon'] ) ? 'value="1"' : '',

#
#-----[ FIND ]------------------------------------------
#

	$template->assign_block_vars('switch_inline_mode', array());
	$template->assign_var_from_handle('TOPIC_REVIEW_BOX', 'reviewbody');
}

#
#-----[ AFTER, ADD ]------------------------------------------
#
if( empty($post_info['poster_id']) || $post_info['poster_id'] == $userdata['user_id'] || $userdata['user_level'] == ADMIN )
{
	$template->assign_block_vars('switch_poster_logged_in',array() );
}
else
{
	$template->assign_block_vars('switch_poster_logged_out',array() );
}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Styles_tip'] = 'Tip: Styles can be applied quickly to selected text.';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Post_Anonymous'] = 'Post as Anonymous';
$lang['Anonymous'] = 'Anonymous';

#
#-----[ OPEN ]------------------------------------------
#
viewforum.php

#
#-----[ FIND ]------------------------------------------
#
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$anon_sql = "SELECT anon FROM " . POSTS_TABLE . " WHERE post_id = " . $topic_rowset[$i]['topic_first_post_id'];
		if ( !($anon_result = $db->sql_query($anon_sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain anonymous status', '', __LINE__, __FILE__, $anon_sql);
		}
		$anon_row = $db->sql_fetchrow($anon_result);
		if ( $anon_row['anon'] == true )
		{
			$topic_author = $lang['Anonymous'];
		}
		$anon_sql = "SELECT anon FROM " . POSTS_TABLE . " WHERE post_id = " . $topic_rowset[$i]['topic_last_post_id'];
		if ( !($anon_result = $db->sql_query($anon_sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain Anonymous status', '', __LINE__, __FILE__, $anon_sql);
		}
		$anon_row = $db->sql_fetchrow($anon__result);
		if ( $anon_row['anon'] == true )
		{
			$last_post_author = $lang['Anonymous'];
		}

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
	if ( $is_auth['auth_mod'] )
	{
		$temp_url = "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'];
		$ip_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_ip'] . '" alt="' . $lang['View_IP'] . '" title="' . $lang['View_IP'] . '" border="0" /></a>';
		$ip = '<a href="' . $temp_url . '">' . $lang['View_IP'] . '</a>';

#
#-----[ AFTER, ADD ]------------------------------------------
#

		if ( $postrow[$i]['anon'] == true && $userdata['user_level'] != ADMIN )
		{
			$ip_img = '';
			$ip = '';
		}

#
#-----[ FIND ]------------------------------------------
#
	$message = str_replace("\n", "\n<br />\n", $message);

#
#-----[ AFTER, ADD ]------------------------------------------
#
	if ( $postrow[$i]['anon'] == true )
	{
		// make the varibles blank
		$poster = $lang['Anonymous'];
		$poster_rank = '';
		$rank_image = '';
		$poster_joined = '';
		$poster_posts = '';
		$poster_from = '';
		$poster_avatar = '';
		$user_sig = '';

		$search_img = '';
		$search = '';
		$pm_img = '';
		$pm = '';
		$email_img = '';
		$email = '';
		$www_img = '';
		$www = '';
		$icq_status_img = '';
		$icq_img = '';
		$icq = '';
		$aim_img = '';
		$aim = '';
		$msn_img = '';
		$msn = '';
		$yim_img = '';
		$yim = '';
	}

	if ( $postrow[$i]['anon'] == true && $userdata['user_level'] != ADMIN )
	{
		$profile_img = '';
		$profile = '';
	}

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
&$poll_length

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $anon

#
#-----[ FIND ]------------------------------------------
#
	$sql = ($mode != "editpost") ? "INSERT INTO " . POSTS_TABLE

#
#-----[ IN-LINE FIND ]------------------------------------------
#
enable_sig

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, anon

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$attach_sig

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $anon

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$attach_sig" . $edited_sql . "

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, anon = $anon

#
#-----[ OPEN ]------------------------------------------
#
includes/topic_review.php

#
#-----[ FIND ]------------------------------------------
#
			$poster = $row['username'];

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$poster = 

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
(!$row['anon']) ? 

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$row['username']

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
: $lang['Anonymous']

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		  <!-- BEGIN switch_type_toggle -->

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		  <!-- BEGIN switch_poster_logged_in -->
		  <tr>
			<td>
			  <input type="checkbox" name="anon" {S_ANON} />
			</td>
			<td><span class="gen">{L_POST_ANONYMOUS}</span></td>
		  </tr>
		  <!-- END switch_poster_logged_in -->

#
#-----[ FIND ]------------------------------------------
#
	  <td class="catBottom" colspan="2" align="center" height="28"> {S_HIDDEN_FORM_FIELDS}

#
#-----[ AFTER, ADD ]------------------------------------------
#
	  <!-- BEGIN switch_poster_logged_out -->
	  <input type="hidden" name="anon" {S_ANON_HIDDEN} />
	  <!-- END switch_poster_logged_out -->

#
#-----[ OPEN ]------------------------------------------
#
search.php

#
#-----[ FIND ]------------------------------------------
#
$sql = "SELECT pt.post_text

#
#-----[ IN-LINE FIND ]------------------------------------------
#
u.user_sig_bbcode_uid

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, p.anon

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
, p.anon, p2.anon as anon2

#
#-----[ FIND ]------------------------------------------
#
$l_search_matches = ( $total_match_count == 1 ) ? sprintf($lang['Found_search_match'], $total_match_count) : sprintf($lang['Found_search_matches'], $total_match_count);

		$template->assign_vars(array(
			'L_SEARCH_MATCHES' => $l_search_matches, 
			'L_TOPIC' => $lang['Topic'])
		);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
/*

#
#-----[ AFTER, ADD ]------------------------------------------
#
*/

#
#-----[ FIND ]------------------------------------------
#
				$poster = ( $searchset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $searchset[$i]['user_id']) . '">' : '';
				$poster .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? $searchset[$i]['username'] : ( ( $searchset[$i]['post_username'] != "" ) ? $searchset[$i]['post_username'] : $lang['Guest'] );
				$poster .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				if ( !$searchset[$i]['anon'] )
				{

#
#-----[ AFTER, ADD ]------------------------------------------
#
				}
				else
				{
					$poster = $lang['Anonymous'];
				}

#
#-----[ FIND ]------------------------------------------
#
				$template->assign_block_vars("searchresults", array(
					'TOPIC_TITLE' => $topic_title,
 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				if ( !$search_author || !$searchset[$i]['anon'] )
				{

#
#-----[ FIND ]------------------------------------------
#
					'U_FORUM' => $forum_url)
				);

#
#-----[ AFTER, ADD ]------------------------------------------
#
				}
				else
				{
					$total_match_count = $total_match_count - 1;
				}

#
#-----[ FIND ]------------------------------------------
#
				$topic_author = ( $searchset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $searchset[$i]['user_id']) . '">' : '';
				$topic_author .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? $searchset[$i]['username'] : ( ( $searchset[$i]['post_username'] != '' ) ? $searchset[$i]['post_username'] : $lang['Guest'] );
				$topic_author .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				if ( !$searchset[$i]['anon'] )
				{

#
#-----[ AFTER, ADD ]------------------------------------------
#
				}
				else
				{
					$topic_author = $lang['Anonymous'];
				}

#
#-----[ FIND ]------------------------------------------
#
				$last_post_author = ( $searchset[$i]['id2'] == ANONYMOUS ) ? ( ($searchset[$i]['post_username2'] != '' ) ? $searchset[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $searchset[$i]['id2']) . '">' . $searchset[$i]['user2'] . '</a>';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				if ( !$searchset[$i]['anon2'] )

#
#-----[ AFTER, ADD ]------------------------------------------
#
				else
				{
					$last_post_author = $lang['Anonymous'];
				}

#
#-----[ FIND ]------------------------------------------
#
				$template->assign_block_vars('searchresults', array( 
					'FORUM_NAME' => $searchset[$i]['forum_name'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				if ( !$search_author || !$searchset[$i]['anon'] )
				{

#
#-----[ FIND ]------------------------------------------
#
					'U_VIEW_TOPIC' => $topic_url)
				);

#
#-----[ AFTER, ADD ]------------------------------------------
#
				}
				else
				{
					$total_match_count = $total_match_count - 1;
				}

#
#-----[ FIND ]------------------------------------------
#
		$base_url = "search.$phpEx?search_id=$search_id";

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		if ( $total_match_count )
		{
		$l_search_matches = ( $total_match_count == 1 ) ? sprintf($lang['Found_search_match'], $total_match_count) : sprintf($lang['Found_search_matches'], $total_match_count);
		$template->assign_vars(array(
			'L_SEARCH_MATCHES' => $l_search_matches, 
			'L_TOPIC' => $lang['Topic'])
		);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['No_search_match']);
		}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM