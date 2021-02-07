##############################################################
## MOD Title: Topic on Top
## MOD Author: A.I. BOT < aibotca@yahoo.ca > (Tyler N. King) http://www.gotbase.org
## MOD Description: This adds a section showing the first post by the topic author above other posts when there is more than one page.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit:	viewtopic.php
##					templates/subSilver/viewtopic_body.tpl
##
## Included Files:	N/A
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
##	- The point of the MOD is so you can easily see what the topic is about, on any page.
############################################################## 
## MOD History:
##
##   2006-08-30 - Version 0.1.0
##      - BETA released
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
$template->pparse('body');

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$sql	= 'SELECT u.username, u.user_id, u.user_posts, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate, u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_sig_bbcode_uid, u.user_avatar, u.user_avatar_type, u.user_allowavatar, u.user_allowsmile, p.*,  pt.post_text, pt.post_subject, pt.bbcode_uid FROM ' . POSTS_TABLE . ' p, ' . USERS_TABLE . ' u, ' . POSTS_TEXT_TABLE . ' pt WHERE p.topic_id = ' . $topic_id . $limit_posts_time . ' AND pt.post_id = p.post_id AND u.user_id = p.poster_id ORDER BY p.post_time ' . $post_time_order . ' LIMIT 1';
$result	= $db->sql_query ( $sql );
$row	= $db->sql_fetchrow ( $result );

$sql_2		= 'SELECT * FROM ' . RANKS_TABLE . ' WHERE rank_id = ' . $row[ 'user_rank' ];
$result_2	= $db->sql_query ( $sql_2 );
$row_2		= $db->sql_fetchrow ( $result_2 );

if ( $row[ 'poster_id' ] == ANONYMOUS && $row[ 'post_username' ] != '' )
{
	$poster			= $row_2[ 'post_username' ];
	$poster_rank	= $lang[ 'Guest' ];
}
else
{
	$poster_rank	= $row_2[ 'rank_title' ];
	$rank_image		= ( $row_2[ 'rank_image' ] ) ? '<img src="' . $row_2[ 'rank_image' ] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
}

$post_date		= create_date ( $board_config[ 'default_dateformat' ], $row[ 'post_time' ], $board_config[ 'board_timezone' ] );
$poster_posts	= ( $row[ 'user_id' ] != ANONYMOUS ) ? $lang[ 'Posts' ] . ': ' . $row[ 'user_posts' ] : '';
$poster_from	= ( $row[ 'user_from' ] && $row[ 'user_id' ] != ANONYMOUS ) ? $lang[ 'Location' ] . ': ' . $row[ 'user_from' ] : '';
$poster_joined	= ( $row[ 'user_id' ] != ANONYMOUS ) ? $lang[ 'Joined' ] . ': ' . create_date ( $lang[ 'DATE_FORMAT' ], $row[ 'user_regdate' ], $board_config[ 'board_timezone' ] ) : '';
$poster_avatar	= '';

if ( $row[ 'user_avatar_type' ] && $row[ 'poster_id' ] != ANONYMOUS && $row[ 'user_allowavatar' ] )
{
	switch ( $row[ 'user_avatar_type' ] )
	{
		case USER_AVATAR_UPLOAD :
			$poster_avatar	= ( $board_config[ 'allow_avatar_upload' ] ) ? '<img src="' . $board_config[ 'avatar_path' ] . '/' . $row[ 'user_avatar' ] . '" alt="" border="0" />' : '';
		break;
		case USER_AVATAR_REMOTE :
			$poster_avatar	= ( $board_config[ 'allow_avatar_remote' ] ) ? '<img src="' . $row[ 'user_avatar' ] . '" alt="" border="0" />' : '';
		break;
		case USER_AVATAR_GALLERY :
			$poster_avatar	= ( $board_config[ 'allow_avatar_local' ] ) ? '<img src="' . $board_config[ 'avatar_gallery_path' ] . '/' . $row[ 'user_avatar' ] . '" alt="" border="0" />' : '';
		break;
	}
}

$post_subject			= ( $row[ 'post_subject' ] != '' ) ? $row[ 'post_subject' ] : '';
$message				= $row[ 'post_text' ];
$bbcode_uid				= $row[ 'bbcode_uid' ];
$user_sig				= ( $row[ 'enable_sig' ] && $row[ 'user_sig' ] != '' && $board_config[ 'allow_sig' ] ) ? $row[ 'user_sig' ] : '';
$user_sig_bbcode_uid	= $row[ 'user_sig_bbcode_uid' ];

if ( !$board_config[ 'allow_html' ] || !$userdata[ 'user_allowhtml' ] )
{
	if ( $user_sig != '' )
	{
		$user_sig	= preg_replace ( '#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig );
	}

	if ( !empty ( $row[ 'enable_html' ] ) )
	{
		$message	= preg_replace ( '#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message );
	}
}

if ( $user_sig != '' && $user_sig_bbcode_uid != '' )
{
	$user_sig	= ( !empty ( $board_config[ 'allow_bbcode' ] ) ) ? bbencode_second_pass ( $user_sig, $user_sig_bbcode_uid ) : preg_replace ( "/\:$user_sig_bbcode_uid/si", '', $user_sig );
}

if ( $bbcode_uid != '' )
{
	$message	= ( !empty ( $board_config[ 'allow_bbcode' ] ) ) ? bbencode_second_pass ( $message, $bbcode_uid ) : preg_replace ( "/\:$bbcode_uid/si", '', $message );
}

if ( $user_sig != '' )
{
	$user_sig	= make_clickable ( $user_sig );
}

$message = make_clickable ( $message );
if ( !empty ( $board_config[ 'allow_smilies' ] ) )
{
	if ( !empty ( $row[ 'user_allowsmile' ] ) && $user_sig != '' )
	{
		$user_sig	= smilies_pass ( $user_sig );
	}

	if ( !empty ( $row[ 'enable_smilies' ] ) )
	{
		$message	= smilies_pass ( $message );
	}
}

if ( !empty ( $row[ 'post_edit_count' ] ) )
{
	$l_edit_time_total	= ( $row[ 'post_edit_count' ] == 1 ) ? $lang[ 'Edited_time_total' ] : $lang[ 'Edited_times_total' ];
	$l_edited_by		= '<br /><br />' . sprintf ( $l_edit_time_total, $poster, create_date ( $board_config[ 'default_dateformat' ], $row[ 'post_edit_time' ], $board_config[ 'board_timezone' ] ), $row[ 'post_edit_count' ] );
}
else
{
	$l_edited_by	= '';
}

$temp_url	= '';
if ( $row[ 'poster_id' ] != ANONYMOUS )
{
	$temp_url		= append_sid ( "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row[ 'poster_id' ] );
	$profile_img	= '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_profile' ] . '" alt="' . $lang[ 'Read_profile' ] . '" title="' . $lang[ 'Read_profile' ] . '" border="0" /></a>';
	$profile		= '<a href="' . $temp_url . '">' . $lang[ 'Read_profile' ] . '</a>';

	$temp_url	= append_sid ( "privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $row[ 'poster_id' ] );
	$pm_img		= '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_pm' ] . '" alt="' . $lang[ 'Send_private_message' ] . '" title="' . $lang[ 'Send_private_message' ] . '" border="0" /></a>';
	$pm		= '<a href="' . $temp_url . '">' . $lang[ 'Send_private_message' ] . '</a>';

	if ( !empty ( $row[ 'user_viewemail' ] ) || $is_auth[ 'auth_mod' ] )
	{
		$email_uri	= ( !empty ( $board_config[ 'board_email_form' ] ) ) ? append_sid ( "profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $row[ 'poster_id' ] ) : 'mailto:' . $row[ 'user_email' ];
		$email_img	= '<a href="' . $email_uri . '"><img src="' . $images[ 'icon_email' ] . '" alt="' . $lang[ 'Send_email' ] . '" title="' . $lang[ 'Send_email' ] . '" border="0" /></a>';
		$email		= '<a href="' . $email_uri . '">' . $lang[ 'Send_email' ] . '</a>';
	}
	else
	{
		$email_img	= '';
		$email		= '';
	}

	$www_img	= ( !empty ( $row[ 'user_website' ] ) ) ? '<a href="' . $row[ 'user_website' ] . '" target="_userwww"><img src="' . $images[ 'icon_www' ] . '" alt="' . $lang[ 'Visit_website' ] . '" title="' . $lang[ 'Visit_website' ] . '" border="0" /></a>' : '';
	$www		= ( !empty ( $row[ 'user_website' ] ) ) ? '<a href="' . $row[ 'user_website' ] . '" target="_userwww">' . $lang[ 'Visit_website' ] . '</a>' : '';

	if ( !empty ( $row[ 'user_icq' ] ) )
	{
		$icq_status_img	= '<a href="http://wwp.icq.com/' . $row[ 'user_icq' ] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $row[ 'user_icq' ] . '&img=5" width="18" height="18" border="0" /></a>';
		$icq_img		= '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row[ 'user_icq' ] . '"><img src="' . $images[ 'icon_icq' ] . '" alt="' . $lang[ 'ICQ' ] . '" title="' . $lang[ 'ICQ' ] . '" border="0" /></a>';
		$icq			=  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row[ 'user_icq' ] . '">' . $lang[ 'ICQ' ] . '</a>';
	}
	else
	{
		$icq_status_img	= '';
		$icq_img		= '';
		$icq			= '';
	}

	$aim_img	= ( !empty ( $row[ 'user_aim' ] ) ) ? '<a href="aim:goim?screenname=' . $row[ 'user_aim' ] . '&amp;message=Hello+Are+you+there?"><img src="' . $images[ 'icon_aim' ] . '" alt="' . $lang[ 'AIM' ] . '" title="' . $lang[ 'AIM' ] . '" border="0" /></a>' : '';
	$aim		= ( !empty ( $row[ 'user_aim' ] ) ) ? '<a href="aim:goim?screenname=' . $row[ 'user_aim' ] . '&amp;message=Hello+Are+you+there?">' . $lang[ 'AIM' ] . '</a>' : '';

	$temp_url	= append_sid ( "profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row[ 'poster_id' ] );
	$msn_img	= ( !empty ( $row[ 'user_msnm' ] ) ) ? '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_msnm' ] . '" alt="' . $lang[ 'MSNM' ] . '" title="' . $lang[ 'MSNM' ] . '" border="0" /></a>' : '';
	$msn		= ( !empty ( $row[ 'user_msnm' ] ) ) ? '<a href="' . $temp_url . '">' . $lang[ 'MSNM' ] . '</a>' : '';
	$yim_img	= ( !empty ( $row[ 'user_yim' ] ) ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row[ 'user_yim' ] . '&amp;.src=pg"><img src="' . $images[ 'icon_yim' ] . '" alt="' . $lang[ 'YIM' ] . '" title="' . $lang[ 'YIM' ] . '" border="0" /></a>' : '';
	$yim		= ( !empty ( $row[ 'user_yim' ] ) ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row[ 'user_yim' ] . '&amp;.src=pg">' . $lang[ 'YIM' ] . '</a>' : '';
}
else
{
	$profile_img	= '';
	$profile		= '';
	$pm_img			= '';
	$pm				= '';
	$email_img		= '';
	$email			= '';
	$www_img		= '';
	$www			= '';
	$icq_status_img	= '';
	$icq_img		= '';
	$icq			= '';
	$aim_img		= '';
	$aim			= '';
	$msn_img		= '';
	$msn			= '';
	$yim_img		= '';
	$yim			= '';
}

$temp_url	= append_sid ( "posting.$phpEx?mode=quote&amp;" . POST_POST_URL . "=" . $row[ 'post_id' ] );
$quote_img	= '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_quote' ] . '" alt="' . $lang[ 'Reply_with_quote' ] . '" title="' . $lang['Reply_with_quote'] . '" border="0" /></a>';
$quote		= '<a href="' . $temp_url . '">' . $lang[ 'Reply_with_quote' ] . '</a>';

$temp_url	= append_sid ( "search.$phpEx?search_author=" . urlencode ( $row[ 'username' ] ) . "&amp;showresults=posts" );
$search_img	= '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_search' ] . '" alt="' . sprintf ( $lang[ 'Search_user_posts' ], $row[ 'username' ] ) . '" title="' . sprintf ( $lang[ 'Search_user_posts' ], $row[ 'username' ] ) . '" border="0" /></a>';
$search		= '<a href="' . $temp_url . '">' . sprintf ( $lang[ 'Search_user_posts' ], $row[ 'username' ] ) . '</a>';

if ( ( $userdata['user_id'] == $row[ 'poster_id' ] && $is_auth[ 'auth_edit' ] ) || $is_auth[ 'auth_mod' ] )
{
	$temp_url	= append_sid ( "posting.$phpEx?mode=editpost&amp;" . POST_POST_URL . "=" . $row[ 'post_id' ] );
	$edit_img	= '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_edit' ] . '" alt="' . $lang[ 'Edit_delete_post' ] . '" title="' . $lang[ 'Edit_delete_post' ] . '" border="0" /></a>';
	$edit		= '<a href="' . $temp_url . '">' . $lang[ 'Edit_delete_post' ] . '</a>';
}
else
{
	$edit_img	= '';
	$edit		= '';
}

if ( $is_auth[ 'auth_mod' ] )
{
	$temp_url	= "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $row[ 'post_id' ] . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata[ 'session_id' ];
	$ip_img		= '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_ip' ] . '" alt="' . $lang[ 'View_IP' ] . '" title="' . $lang[ 'View_IP' ] . '" border="0" /></a>';
	$ip			= '<a href="' . $temp_url . '">' . $lang[ 'View_IP' ] . '</a>';

	$temp_url		= "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $row[ 'post_id' ] . "&amp;sid=" . $userdata[ 'session_id' ];
	$delpost_img	= '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_delpost' ] . '" alt="' . $lang[ 'Delete_post' ] . '" title="' . $lang[ 'Delete_post' ] . '" border="0" /></a>';
	$delpost		= '<a href="' . $temp_url . '">' . $lang[ 'Delete_post' ] . '</a>';
}
else
{
	$ip_img	= '';
	$ip		= '';

	if ( $userdata[ 'user_id' ] == $row[ 'poster_id' ] && $is_auth[ 'auth_delete' ] && $forum_topic_data[ 'topic_last_post_id' ] == $row[ 'post_id' ] )
	{
		$temp_url		= "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $row[ 'post_id' ] . "&amp;sid=" . $userdata[ 'session_id' ];
		$delpost_img	= '<a href="' . $temp_url . '"><img src="' . $images[ 'icon_delpost' ] . '" alt="' . $lang[ 'Delete_post' ] . '" title="' . $lang[ 'Delete_post' ] . '" border="0" /></a>';
		$delpost		= '<a href="' . $temp_url . '">' . $lang[ 'Delete_post' ] . '</a>';
	}
	else
	{
		$delpost_img	= '';
		$delpost		= '';
	}
}

if ( $userdata[ 'session_logged_in' ] && $row[ 'post_time' ] > $userdata[ 'user_lastvisit' ] && $row[ 'post_time' ] > $topic_last_read )
{
	$mini_post_img	= $images[ 'icon_minipost_new' ];
	$mini_post_alt	= $lang[ 'New_post' ];
}
else
{
	$mini_post_img	= $images[ 'icon_minipost' ];
	$mini_post_alt	= $lang[ 'Post' ];
}

$mini_post_url	= append_sid ( "viewtopic.$phpEx?" . POST_POST_URL . '=' . $row[ 'post_id' ] ) . '#' . $row[ 'post_id' ];

if ( $start != 0 )
{
	$template->assign_block_vars ( 'block_tot', array (
		'ROW_COLOR' => '#' . $theme[ 'td_color1' ],
		'ROW_CLASS' => $theme[ 'td_class1' ],
		'POSTER_NAME' => $row[ 'username' ],
		'POSTER_RANK' => $poster_rank,
		'RANK_IMAGE' => $rank_image,
		'POSTER_JOINED' => $poster_joined,
		'POSTER_POSTS' => $poster_posts,
		'POSTER_FROM' => $poster_from,
		'POSTER_AVATAR' => $poster_avatar,
		'POST_DATE' => $post_date,
		'POST_SUBJECT' => $post_subject,
		'MESSAGE' => $message,
		'SIGNATURE' => $user_sig,
		'EDITED_MESSAGE' => $l_edited_by,

		'MINI_POST_IMG' => $mini_post_img,
		'PROFILE_IMG' => $profile_img,
		'PROFILE' => $profile,
		'SEARCH_IMG' => $search_img,
		'SEARCH' => $search,
		'PM_IMG' => $pm_img,
		'PM' => $pm,
		'EMAIL_IMG' => $email_img,
		'EMAIL' => $email,
		'WWW_IMG' => $www_img,
		'WWW' => $www,
		'ICQ_STATUS_IMG' => $icq_status_img,
		'ICQ_IMG' => $icq_img,
		'ICQ' => $icq,
		'AIM_IMG' => $aim_img,
		'AIM' => $aim,
		'MSN_IMG' => $msn_img,
		'MSN' => $msn,
		'YIM_IMG' => $yim_img,
		'YIM' => $yim,
		'EDIT_IMG' => $edit_img,
		'EDIT' => $edit,
		'QUOTE_IMG' => $quote_img,
		'QUOTE' => $quote,
		'IP_IMG' => $ip_img,
		'IP' => $ip,
		'DELETE_IMG' => $delpost_img,
		'DELETE' => $delpost,

		'L_MINI_POST_ALT' => $mini_post_alt,
		'U_MINI_POST' => $mini_post_url,
		'U_POST_ID' => $row[ 'post_id' ] )
	);
}

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]------------------------------------------
#
{POLL_DISPLAY}

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<!-- BEGIN block_tot -->
	<tr> 
		<td width="150" align="left" valign="top" class="{block_tot.ROW_CLASS}"><span class="name"><a name="{block_tot.U_POST_ID}"></a><b>{block_tot.POSTER_NAME}</b></span><br /><span class="postdetails">{block_tot.POSTER_RANK}<br />{block_tot.RANK_IMAGE}{block_tot.POSTER_AVATAR}<br /><br />{block_tot.POSTER_JOINED}<br />{block_tot.POSTER_POSTS}<br />{block_tot.POSTER_FROM}</span><br /></td>
		<td class="{block_tot.ROW_CLASS}" width="100%" height="28" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%"><a href="{block_tot.U_MINI_POST}"><img src="{block_tot.MINI_POST_IMG}" width="12" height="9" alt="{block_tot.L_MINI_POST_ALT}" title="{block_tot.L_MINI_POST_ALT}" border="0" /></a><span class="postdetails">{L_POSTED}: {block_tot.POST_DATE}<span class="gen">&nbsp;</span>&nbsp; &nbsp;{L_POST_SUBJECT}: {block_tot.POST_SUBJECT}</span></td>
				<td valign="top" nowrap="nowrap">{block_tot.QUOTE_IMG} {block_tot.EDIT_IMG} {block_tot.DELETE_IMG} {block_tot.IP_IMG}</td>
			</tr>
			<tr> 
				<td colspan="2"><hr /></td>
			</tr>
			<tr>
				<td colspan="2"><span class="postbody">{block_tot.MESSAGE}{block_tot.SIGNATURE}</span><span class="gensmall">{block_tot.EDITED_MESSAGE}</span></td>
			</tr>
		</table></td>
	</tr>
	<tr> 
		<td class="{block_tot.ROW_CLASS}" width="150" align="left" valign="middle"><span class="nav"><a href="#top" class="nav">{L_BACK_TO_TOP}</a></span></td>
		<td class="{block_tot.ROW_CLASS}" width="100%" height="28" valign="bottom" nowrap="nowrap"><table cellspacing="0" cellpadding="0" border="0" height="18" width="18">
			<tr> 
				<td valign="middle" nowrap="nowrap">{block_tot.PROFILE_IMG} {block_tot.PM_IMG} {block_tot.EMAIL_IMG} {block_tot.WWW_IMG} {block_tot.AIM_IMG} {block_tot.YIM_IMG} {block_tot.MSN_IMG}<script language="JavaScript" type="text/javascript"><!-- 

	if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
		document.write(' {block_tot.ICQ_IMG}');
	else
		document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{block_tot.ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{block_tot.ICQ_STATUS_IMG}</div></div>');
				
				//--></script><noscript>{block_tot.ICQ_IMG}</noscript></td>
			</tr>
		</table></td>
	</tr>
	<tr> 
		<td class="spaceRow" colspan="2" height="1">&nbsp;</td>
	</tr>
	<!-- END block_tot -->

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
# 
# EoM