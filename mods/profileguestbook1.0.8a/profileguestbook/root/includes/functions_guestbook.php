<?php
/**
 *
 * @version $Id: functions_guestbook.php,v 1.29 2006/12/28 11:19:15 paulsohier Exp $
 */
if (!defined('IN_PHPBB'))
{
	die("Hacking attempt");
}

class guestbook{
	var $userdata;
	var $uid;
	var $url;
	var $url_intern;
	function guestbook(&$uid,$mode = false, $url = false)
	{
		global $phpEx;
		if(is_array($uid))
		{
			$this->userdata = $uid;
		}
		else
		{
			$this->userdata = get_userdata($uid);
		}
		$this->uid = $this->userdata['user_id'];
		$this->version = '1.0.8';

		/**
		 * Main url used at the guestbook.
		 * If you want to add your guestbook to another place, change this url,
		 * or give a url with parameter 3 when creating the class.
		 * It must be a page on the server, and you must not include
		 * http://site.url.ext/forum/, only profile.php.
		 * There must be also a ? in the url.
		 * At the end a &amp; isn't needed
		 * VB: viewtopic.php?t=1.
		 **/

		if($url !== false)
		{
			$tmp = explode("?", $url);
			if(!count($tmp))
			{
				//No valid url, missing ?.
				$url = false;
			}
			else
			{
				if(!file_exists($tmp[0]))
				{
					//File doesn't exists
					$url = false;
				}
			}
		}

		if($url === false )
		{
			$this->url_intern = "profile." . $phpEx . "?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $this->uid;
		}
		else
		{
			$this->url_intern = $url;
		}

		if(!$mode)
		{
			return true;
		}
		else
		{
			return $this->mode($mode);
		}
	}
	function mode($mode)
	{
		global $userdata,$board_config,$lang;
		global $HTTP_GET_VARS, $template, $HTTP_POST_VARS, $phpbb_root_path, $phpEx, $db;
		if(!$this->userdata['user_can_gb'] || !$userdata['user_can_gb'] || (!$board_config['allow_guests_gb'] && !$userdata['session_logged_in']))
		{
			return false;
		}
		else
		{
			if ( isset($HTTP_POST_VARS['cancel']) )
			{
				$redirect = "profile.php?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $this->uid;
				redirect(append_sid($redirect, true));
			}
			$confirm = ( $HTTP_POST_VARS['confirm'] ) ? TRUE : 0;
			if(($mode == 'delete' || $mode == 'deleteall') && !$confirm)
			{
				$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="gb_id" value="' . intval($HTTP_GET_VARS['gb_id']) . '" />';
				

				//
				// Set template files
				//
				$template->set_filenames(array(
					'confirm' => 'confirm_body.tpl')
				);

				$template->assign_vars(array(
					'MESSAGE_TITLE' => $lang['Confirm'],
					'MESSAGE_TEXT' => $lang['Confirm_delete_gbpost'],

					'L_YES' => $lang['Yes'],
					'L_NO' => $lang['No'],

					'S_CONFIRM_ACTION' => $this->append_sid("gb=" . $mode),
					'S_HIDDEN_FIELDS' => $hidden_fields)
				);

				$template->pparse('confirm');

				include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
			}
			switch($mode){
				case "view":
					$this->view();
				break;
				case "quote":
				case "post":
				case "edit":
						$this->post($mode);
				break;
				case "delete":
					if($userdata['user_level'] == ADMIN || $userdata['user_id'] == $this->uid)
					{
						$this->delete();
					}
					else
					{
						message_die(GENERAL_MESSAGE,sprintf($lang['gb_no_per'],$lang['delete_pro']));
					}
				break;
				case "deleteall":
					if($userdata['user_level'] == ADMIN || $userdata['user_id'] == $this->uid)
					{
						$this->deleteall();
					}
					else
					{
						message_die(GENERAL_MESSAGE,sprintf($lang['gb_no_per'],$lang['delete_all_pro']));
					}
				break;
				default:
					return false;
			}
		}
		return true;
	}
	function view()
	{
		global $db,$HTTP_GET_VARS;
		$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
		$start = ($start < 0) ? 0 : $start; 
		$sql = "SELECT * FROM ".PROFILE_GUESTBOOK_TABLE." g, ".USERS_TABLE." u WHERE
				g.user_id = ".$this->uid." AND g.poster_id = u.user_id
				ORDER BY g.gb_time DESC
				LIMIT $start, 10";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR,"Could not query guestbook","",__LINE__,__FILE__,$sql);
		}
		if( !$db->sql_numrows($result) )
		{
			if($start == 0)
			{
				$this->maak_view($result,'nores',0);
			}
			else
			{
				$this->maak_view($result,'nopag',0);
			}
		}
		else
		{
			$this->maak_view($result,'',0);
		}
	}
	function maak_view($result,$fout = '',$tot)
	{
		global $phpbb_root_path,$phpEx,$template,$lang,$profiledata,$userdata,$images,$board_config;
		global $db,$theme,$HTTP_GET_VARS;
		include_once($phpbb_root_path."/includes/bbcode.".$phpEx);
		$template->set_filenames(array(
			'gb_body' => 'gb_view.tpl')
		);
		$txt = sprintf($lang['gb_text'],$profiledata['username']);
		if($userdata['user_level'] == ADMIN)
		{
			$txt .= sprintf($lang['gb_text2'],$this->append_sid("gb=deleteall"));
			$txt .= "<br />".$this->version_check();
		}
		elseif($userdata['user_id'] == $this->uid || $userdata['user_level'] == MOD)
		{
			$txt .= sprintf($lang['gb_text2'],$this->append_sid("gb=deleteall"));
		}
		$template->assign_vars(array(
			"L_GUESTBOOK" => $lang['gb_txt'],
			"L_TXT" => $txt,
			"L_DIS" => $lang['dis'],
			"L_EN" => $lang['en'],
			"L_BACK_TO_TOP" => $lang['Back_to_top'],
			"L_NUMBER_URL" => $lang['number_url'],
			"MINI_POST_IMG" => $images['icon_minipost'],
			"UID" => $this->uid,
			"U" => POST_USERS_URL,
			"URL" => $board_config['server_name'],
			"PAD" => $board_config['script_path'],
			"SECURE" => ($board_config['cookie_secure']) ? "s" : '',
			"PHPEX" => $phpEx,
		));
		if($fout != '')
		{
			$reply_img = $images['reply_new'];
			$reply_alt = $lang['gb_reply'];
			$reply_topic_url = $this->append_sid('gb=post');
			$template->assign_vars(array(
				'REPLY_IMG' => $reply_img,
				'U_POST_REPLY_TOPIC' => $reply_topic_url)
			);
			switch($fout)
			{
				case "nores":
					$template->assign_block_vars("error",array(
						"L_GUESTBOOK_ERROR" => $lang['gb_error2'],
						"ERROR" => $lang['gb_nores']
					));
				break;
				case "nopag":
					$template->assign_block_vars("error",array(
						"L_GUESTBOOK_ERROR" => $lang['gb_error'],
						"ERROR" => $lang['gb_nopag']
					));
				break;
			}
		}
		else
		{
			$postrow = array();
			$postrow = $db->sql_fetchrowset($result);
			$total_posts = count($postrow);
			//Why global the var from usercp_viewprofile, thats is one query less :P

			global $ranksrow;

			//
			// Define censored word matches
			//
			$orig_word = array();
			$replacement_word = array();
			obtain_word_list($orig_word, $replacement_word);
			$reply_img = $images['reply_new'];
			$reply_alt = $lang['gb_reply'];
			$reply_topic_url = $this->append_sid('gb=post');
			$sql2 = "SELECT * FROM " . PROFILE_GUESTBOOK_TABLE . " WHERE user_id = " . $this->uid;
			$result2 = $db->sql_query($sql2);
			if(!$result2)
			{
				message_die(GENERAL_ERROR,"Could not get total of guestbook posts!","",__LINE__,__FILE__,$sql2);
			}
			$total_replies = $db->sql_numrows($result2);
			$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
			$pagination = generate_pagination('profile.'.$phpEx.'?mode=viewprofile&gb=view&'.POST_USERS_URL.'='.$this->uid, $total_replies, 10, $start);
			$template->assign_block_vars('main',array(
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / intval(10) ) + 1 ), ceil( $total_replies / intval(10) )),

				'REPLY_IMG' => $reply_img,

				'L_AUTHOR' => $lang['Author'],
				'L_MESSAGE' => $lang['Message'],
				'L_POSTED' => $lang['Posted'],
				'L_POST_SUBJECT' => $lang['gb_title'],
				'L_POST_REPLY_TOPIC' => $reply_alt,
				'L_GOTO_PAGE' => $lang['Goto_page'],

				'U_POST_REPLY_TOPIC' => $reply_topic_url)
			);
			$template->assign_vars(array(
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / intval(10) ) + 1 ), ceil( $total_replies / intval(10) )),
				'REPLY_IMG' => $reply_img,

				'U_POST_REPLY_TOPIC' => $reply_topic_url)
			);


			$post_nr = 0;
			if($start != 0)	{
				$post_nr += (int)$start;
			}
			for($i = 0; $i < $total_posts; $i++)
			{
				$post_nr++;

				$poster_id = $postrow[$i]['poster_id'];
				$poster = ( $poster_id == ANONYMOUS ) ? (!empty($postrow[$i]['user_guest_name'])) ? $postrow[$i]['user_guest_name']."(".$lang['Guest'].")": $lang['Guest'] : $postrow[$i]['username'];

				$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['gb_time'], $board_config['board_timezone']);

				$poster_posts = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $postrow[$i]['user_posts'] : '';

				$poster_from = ( $postrow[$i]['user_from'] && $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Location'] . ': ' . $postrow[$i]['user_from'] : '';

				$poster_joined = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Joined'] . ': ' . create_date($lang['DATE_FORMAT'], $postrow[$i]['user_regdate'], $board_config['board_timezone']) : '';

				$poster_avatar = '';
				if ( $postrow[$i]['user_avatar_type'] && $poster_id != ANONYMOUS && $postrow[$i]['user_allowavatar'] )
				{
					switch( $postrow[$i]['user_avatar_type'] )
					{
						case USER_AVATAR_UPLOAD:
							$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
							break;
						case USER_AVATAR_REMOTE:
							$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
							break;
						case USER_AVATAR_GALLERY:
							$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
							break;
					}
				}

				//
				// Generate ranks, set them to empty string initially.
				//
				$poster_rank = '';
				$rank_image = '';
				if ( $postrow[$i]['user_id'] == ANONYMOUS )
				{
				}
				else if ( $postrow[$i]['user_rank'] )
				{
					for($j = 0; $j < count($ranksrow); $j++)
					{
						if ( $postrow[$i]['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
						{
							$poster_rank = $ranksrow[$j]['rank_title'];
							$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
						}
					}
				}
				else
				{
					for($j = 0; $j < count($ranksrow); $j++)
					{
						if ( $postrow[$i]['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
						{
							$poster_rank = $ranksrow[$j]['rank_title'];
							$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
						}
					}
				}

				//
				// Handle anon users posting with usernames
				//
				if ( $poster_id == ANONYMOUS && $postrow[$i]['post_username'] != '' )
				{
					$poster = $postrow[$i]['post_username'];
					$poster_rank = $lang['Guest'];
				}

				$temp_url = '';

				if ( $poster_id != ANONYMOUS )
				{
					$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
					$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
					$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

					$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
					$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
					$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

					if ( !empty($postrow[$i]['user_viewemail']) || $userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD )
					{
						$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $postrow[$i]['user_email'];

						$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
						$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
					}
					else
					{
						$email_img = '';
						$email = '';
					}

					$www_img = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
					$www = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

					if ( !empty($postrow[$i]['user_icq']) )
					{
						$icq_status_img = '<a href="http://wwp.icq.com/' . $postrow[$i]['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $postrow[$i]['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
						$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
						$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '">' . $lang['ICQ'] . '</a>';
					}
					else
					{
						$icq_status_img = '';
						$icq_img = '';
						$icq = '';
					}

					$aim_img = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $postrow[$i]['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
					$aim = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $postrow[$i]['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';

					$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
					$msn_img = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
					$msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

					$yim_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
					$yim = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
				}
				else
				{
					$profile_img = '';
					$profile = '';
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

				$temp_url = $this->append_sid("gb=quote&amp;gb_id=" . $postrow[$i]['gb_id']);
				$quote_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_quote'] . '" alt="' . $lang['Reply_with_quote'] . '" title="' . $lang['Reply_with_quote'] . '" border="0" /></a>';
				$quote = '<a href="' . $temp_url . '">' . $lang['Reply_with_quote'] . '</a>';

				$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($postrow[$i]['username']) . "&amp;showresults=posts");
				$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . $lang['Search_user_posts'] . '" title="' . $lang['Search_user_posts'] . '" border="0" /></a>';
				$search = '<a href="' . $temp_url . '">' . $lang['Search_user_posts'] . '</a>';

				if (($poster_id != ANONYMOUS && $userdata['user_id'] == $poster_id) || $userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD || $userdata['user_id'] == $this->uid)
		            {
		               $temp_url = $this->append_sid("gb=edit&amp;gb_id=".$postrow[$i]['gb_id']);
		               $edit_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_edit'] . '" alt="' . $lang['Edit_delete_post'] . '" title="' . $lang['Edit_delete_post'] . '" border="0" /></a>';
		               $edit = '<a href="' . $temp_url . '">' . $lang['Edit_delete_post'] . '</a>';
		            }
		            else
		            {
		               $edit_img = '';
		               $edit = '';
		            }

		            if ( $userdata['user_id'] == $postrow['poster_id'] || $userdata['user_level'] == ADMIN || $userdata['user_level'] == MOD || $userdata['user_id'] == $this->uid)
		            {
		               $temp_url = $this->append_sid("gb=delete&amp;gb_id=" . $postrow[$i]['gb_id']);
		               $delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
		               $delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
		            }
		            else
		            {
		               $delpost_img = '';
		               $delpost = '';
		            }

				$post_title = ( $postrow[$i]['title'] != '' ) ? $postrow[$i]['title'] : '';

				$message = stripslashes($postrow[$i]['message']);
				$bbcode_uid = $postrow[$i]['bbcode'];

				$user_sig = ( $postrow[$i]['enable_sig'] && $postrow[$i]['user_sig'] != '' && $board_config['allow_sig'] ) ? $postrow[$i]['user_sig'] : '';
				$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];

				//
				// Note! The order used for parsing the message _is_ important, moving things around could break any
				// output
				//


				//
				// Parse message and/or sig for BBCode if reqd
				//
				if ( $user_sig != '' && $user_sig_bbcode_uid != '' )
				{
					$user_sig = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $user_sig);
				}

				if ( $bbcode_uid != '' )
				{
					$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
					$post_title = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($post_title, $bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $post_title);
				}

				if ( $user_sig != '' )
				{
					$user_sig = make_clickable($user_sig);
				}
				$message = make_clickable($message);

				//
				// Parse smilies
				//
				if ( $postrow[$i]['user_allowsmile'] && $user_sig != '' )
				{
					$user_sig = smilies_pass($user_sig);
				}
				$message = smilies_pass($message);
				$post_title = smilies_pass($post_title);


				//
				// Replace naughty words
				//
				if (count($orig_word))
				{
					$post_title = preg_replace($orig_word, $replacement_word, $post_title);

					if ($user_sig != '')
					{
						$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $user_sig . '<'), 1, -1));
					}

					$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));
				}

				//
				// Replace newlines (we use this rather than nl2br because
				// till recently it wasn't XHTML compliant)
				//
				if ( $user_sig != '' )
				{
					$user_sig = '<br />_________________<br />' . str_replace("\n", "\n<br />\n", $user_sig);
				}

				$message = str_replace("\n", "\n<br />\n", $message);


				//
				// Again this will be handled by the templating
				// code at some point
				//
				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
				$template->assign_block_vars('main.postrow', array(
					'U_POST_ID' => $postrow[$i]['gb_id'],
					'ROW_COLOR' => '#' . $row_color,
					'ROW_CLASS' => $row_class,
					'POSTER_NAME' => $poster,
					'POSTER_RANK' => $poster_rank,
					'RANK_IMAGE' => $rank_image,
					'POSTER_JOINED' => $poster_joined,
					'POSTER_POSTS' => $poster_posts,
					'POSTER_FROM' => $poster_from,
					'POSTER_AVATAR' => $poster_avatar,
					'POST_DATE' => $post_date,
					'POST_SUBJECT' => $post_title,
					'MESSAGE' => $message,
					'SIGNATURE' => $user_sig,

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
					'DELETE_IMG' => $delpost_img,
					'DELETE' => $delpost,
					'NUMBER' => $post_nr
				));
			}
		}
		include_once($phpbb_root_path."/includes/functions_post.".$phpEx);
		//Check if quick reply is enabled.

		$quick_valid = true;

		if($board_config['gb_posts'] > 0 && $userdata['user_posts'] <= $board_config['gb_posts'])
		{
			$quick_valid = false;
		}

		if($board_config['gb_quick'] && $quick_valid)
		{
			$template->assign_block_vars('quick',array());

			$inline_columns = 15;
			$inline_rows = 1;

			$sql = "SELECT emoticon, code, smile_url
				FROM " . SMILIES_TABLE . "
				ORDER BY smilies_id";
			if ($result = $db->sql_query($sql))
			{
				$num_smilies = 0;
				$rowset = array();
				while ($row = $db->sql_fetchrow($result))
				{
					if (empty($rowset[$row['smile_url']]))
					{
						$rowset[$row['smile_url']]['code'] = str_replace("'", "\\'", str_replace('\\', '\\\\', $row['code']));
						$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
						$num_smilies++;
					}
				}

				if ($num_smilies)
				{
					$smilies_split_row = $inline_columns - 1;

					$s_colspan = 0;
					$row = 0;
					$col = 0;

					while (list($smile_url, $data) = @each($rowset))
					{
						if (!$col)
						{
							$template->assign_block_vars('quick.smilies_row', array());
						}

						$template->assign_block_vars('quick.smilies_row.smilies_col', array(
							'SMILEY_CODE' => $data['code'],
							'SMILEY_IMG' => $board_config['smilies_path'] . '/' . $smile_url,
							'SMILEY_DESC' => $data['emoticon'])
						);

						$s_colspan = max($s_colspan, $col + 1);

						if ($col == $smilies_split_row)
						{
							if ($row == $inline_rows - 1)
							{
								break;
							}
							$col = 0;
							$row++;
						}
						else
						{
							$col++;
						}
					}

					if ($num_smilies > $inline_rows * $inline_columns)
					{
						$template->assign_block_vars('quick.switch_smilies_extra', array());

						$template->assign_vars(array(
							'L_MORE_SMILIES' => $lang['More_emoticons'],
							'U_MORE_SMILIES' => append_sid("posting.$phpEx?mode=smilies"))
						);
					}

					$template->assign_vars(array(
						'L_EMOTICONS' => $lang['Emoticons'],
						'L_CLOSE_WINDOW' => $lang['Close_window'],
						'S_SMILIES_COLSPAN' => $s_colspan)
					);
				}
			}
		}

		if(!$userdata['session_logged_in'])
		{
			$template->assign_block_vars('quick.username',array());
		}
		$action = $this->append_sid("gb=post");
		$template->assign_vars(array(
			'L_POST_QUICK' => $lang['gb_quick_reply'],
			'L_GB_POST' => $lang['gb_post2'],
			'L_TITLE' => $lang['gb_title'],
			'L_MESSAGE_BODY' => $lang['Message_body'],
			'L_SUBMIT' => $lang['Submit'],
			'L_USERNAME' => $lang['Username'],

			'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
			'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
			'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
			'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
			'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
			'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
			'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
			'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
			'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
			'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
			'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
			'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
			'L_EMPTY_MESSAGE' => $lang['Empty_message'],

			'L_FONT_COLOR' => $lang['Font_color'],
			'L_COLOR_DEFAULT' => $lang['color_default'],
			'L_COLOR_DARK_RED' => $lang['color_dark_red'],
			'L_COLOR_RED' => $lang['color_red'],
			'L_COLOR_ORANGE' => $lang['color_orange'],
			'L_COLOR_BROWN' => $lang['color_brown'],
			'L_COLOR_YELLOW' => $lang['color_yellow'],
			'L_COLOR_GREEN' => $lang['color_green'],
			'L_COLOR_OLIVE' => $lang['color_olive'],
			'L_COLOR_CYAN' => $lang['color_cyan'],
			'L_COLOR_BLUE' => $lang['color_blue'],
			'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
			'L_COLOR_INDIGO' => $lang['color_indigo'],
			'L_COLOR_VIOLET' => $lang['color_violet'],
			'L_COLOR_WHITE' => $lang['color_white'],
			'L_COLOR_BLACK' => $lang['color_black'],

			'L_FONT_SIZE' => $lang['Font_size'],
			'L_FONT_TINY' => $lang['font_tiny'],
			'L_FONT_SMALL' => $lang['font_small'],
			'L_FONT_NORMAL' => $lang['font_normal'],
			'L_FONT_LARGE' => $lang['font_large'],
			'L_FONT_HUGE' => $lang['font_huge'],

			'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
			'L_STYLES_TIP' => $lang['Styles_tip'],

			'U_PROFILE' => append_sid('profile.'.$phpEx.'?mode=viewprofile&amp;'.POST_USERS_URL.'='.$this->uid),

			'S_POST_ACTION' => $action
			)
		);
		$template->assign_var_from_handle('GUESTBOOK', 'gb_body');
	}
	function post($mode)
	{
		global $board_config,$userdata,$lang,$HTTP_POST_VARS,$phpbb_root_path,$phpEx,$db,$HTTP_GET_VARS,$unhtml_specialchars_replace,$unhtml_specialchars_match,$html_entities_match,$html_entities_replace;
		if($board_config['allow_guests_gb'] == 0 && !$userdata['session_logged_in'])
		{
			message_die(GENERAL_MESSAGE,sprintf($lang['gb_no_per'],$lang['post_pro']));
		}
		elseif($board_config['gb_posts'] > 0 && $userdata['user_posts'] <= $board_config['gb_posts'])
		{
			message_die(GENERAL_MESSAGE,sprintf($lang['gb_posts_not'],$board_config['gb_posts']));
		}
		if(isset($HTTP_POST_VARS['message']))
		{
			$me = $HTTP_POST_VARS['message'];
			$ti = $HTTP_POST_VARS['subject'];
			//This code stands always after the error trigger.
			include_once($phpbb_root_path."/includes/bbcode.".$phpEx);
			include_once($phpbb_root_path."/includes/functions_post.".$phpEx);

			$bbcode = make_bbcode_uid();
			$me = prepare_message($me,$board_config['allow_html'],true,true,$bbcode);
			$ti = prepare_message($ti,false,true,true,$bbcode);//No HTML in titles. BBcode and smilies are allowed.
			$err = false;
			$errmsg = array();
			if(empty($me))
			{
				$errmsg[] = $lang['gb_no_me'];
				$err = true;
			}
			//In version 0.0.3 title can be empty!


			//Guest username, added in version 0.0.4
			if(!$userdata['session_logged_in'])
			{
				if(!empty($HTTP_POST_VARS['username']))
				{
					$username = phpbb_clean_username($HTTP_POST_VARS['username']);
				}
				else
				{
					$username = '';
				}
			}
			else
			{
				$username = '';
			}
			if($err)
			{
				$id = intval($HTTP_GET_VARS['gb_id']);

				$action = $this->append_sid("gb=$mode&amp;id=$id");
				$this->post_table($me,$ti,$action,$username,$errmsg);
				return;
			}

			$pid = $userdata['user_id'];
			if($mode != 'edit')
			{

				//In version 0.0.4, one new field!
				$sql = "INSERT INTO ".PROFILE_GUESTBOOK_TABLE." (user_id,poster_id,bbcode,title,message,gb_time,user_guest_name) VALUES
				(".$this->uid.",$pid,'$bbcode','$ti','$me','".time()."','$username');";
			}
			else
			{
				$id = intval($HTTP_GET_VARS['gb_id']);
				if(empty($id))
				{
					message_die(GENERAL_ERROR,$lang['gb_no_id'],"",__LINE__,__FILE__);
				}
				$sql = "UPDATE ".PROFILE_GUESTBOOK_TABLE." SET
				bbcode = '$bbcode', title = '$ti', message = '$me' WHERE gb_id = $id";
			}
			$result = $db->sql_query($sql);
			if(!$result)
			{
				message_die(GENERAL_ERROR,"Could not insert or update user guestbook!","",__LINE__,__FILE__,$sql);
			}

			$id = $db->sql_nextid();
			$msg = '<br /><a href="' . $this->append_sid("gb=view") . '#' . $id . '">'.$lang['back_pro'] . '</a>';
			if($mode == 'edit')
			{
				message_die(GENERAL_MESSAGE,$lang['gb_edit'].$msg);
			}
			else
			{
				$this->email($id);
				message_die(GENERAL_MESSAGE,$lang['gb_post'].$msg);
			}
		}
		else
		{
			if($mode == 'edit')
			{
				$id = intval($HTTP_GET_VARS['gb_id']);
				if(empty($id))
				{
					message_die(GENERAL_ERROR,$lang['gb_no_id'],"",__LINE__,__FILE__);
				}
				$action = $this->append_sid("gb=edit&amp;gb_id=" . $id);
				$sql = "SELECT * FROM ".PROFILE_GUESTBOOK_TABLE." WHERE gb_id = $id";
				$r = $db->sql_query($sql);
				if(!$r)
				{
					message_die(GENERAL_ERROR,"Could not select edit information!",__LINE__,__FILE__,$sql);
				}
				$row = $db->sql_fetchrow($r);
				if($userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD && $userdata['user_id'] != $this->uid && $row['poster_id'] != $userdata['user_id'])
				{
					message_die(GENERAL_MESSAGE,sprintf($lang['gb_no_per'],$lang['edit_pro']));
				}
				$me = str_replace(':'.$row['bbcode'],'',$row['message']);
				$ti = str_replace(':'.$row['bbcode'],'',$row['title']);

			}
			elseif($mode == 'quote')
			{
				$action = $this->append_sid("gb=post");
				$id = intval($HTTP_GET_VARS['gb_id']);
				if(empty($id)){
					message_die(GENERAL_ERROR,$lang['gb_no_id'],"",__LINE__,__FILE__);
				}
				$sql = "SELECT * FROM ".PROFILE_GUESTBOOK_TABLE." g, ".USERS_TABLE." u WHERE g.gb_id = $id AND u.user_id = g.poster_id";
				$result = $db->sql_query($sql);
				if(!$result)
				{
					message_die(GENERAL_ERROR,"Could not select edit information!",__LINE__,__FILE__,$sql);
				}
				$row = $db->sql_fetchrow($result);
				$me = str_replace(':'.$row['bbcode'],'',$row['message']);
				$ti = str_replace(':'.$row['bbcode'],'',$row['title']);
				if($row['user_id'] != ANONYMOUS)
				{
					$me = '[quote="' . $row['username'] . '"]' . $me . '[/quote]';
				}
				else
				{
					if(!empty($row['user_guest_name']))
					{
						$me = '[quote="' . $row['user_guest_name'] . '"]' . $me . '[/quote]';
					}
					else
					{
						$me = '[quote]' . $me . '[/quote]';
					}
				}
				$ti = $lang['re'] . ":".$ti;
			}
			else
			{
				$action = $this->append_sid("gb=post");
				$me = '';
				$ti = '';
			}
			$this->post_table($me,$ti,$action);
			return;
		}
	}
	function email($post_id)
	{
		global $db,$board_config,$phpbb_root_path,$phpEx,$lang;

		if($this->userdata['user_email_new_gb'] == 0)
		{
			return;
		}
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
		$script_name = ( $script_name != '' ) ? $script_name . '/profile.'.$phpEx : 'profile.'.$phpEx;
		$server_name = trim($board_config['server_name']);
		$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
		include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
		$emailer = new emailer($board_config['smtp_delivery']);

		$emailer->from($board_config['board_email']);
		$emailer->replyto($board_config['board_email']);

		$emailer->use_template('guestbook', $this->userdata['user_lang']);
		$emailer->email_address($this->userdata['user_email']);
		$emailer->set_subject($lang['gb_email']);

		$emailer->assign_vars(array(
			"U_ACT" => $server_protocol . $server_name . $server_port . $script_name."?mode=viewprofile&".POST_USERS_URL."=".$this->userdata['user_id'] . "#" . $post_id,
			"USERNAME" => $this->userdata['username'],
			'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),
		));
		$emailer->send();
		$emailer->reset();
		return;
	}
	function post_table($me,$ti,$action,$username = '',$errmsg = array())
	{
		global $phpbb_root_path,$phpEx,$template,$mode,$userdata,$lang,$db,$unhtml_specialchars_replace,$unhtml_specialchars_match,$html_entities_match,$html_entities_replace;


		include_once($phpbb_root_path."/includes/bbcode.".$phpEx);
		include_once($phpbb_root_path."/includes/functions_post.".$phpEx);
		$template->set_filenames(array(
			'body' => 'gb_post.tpl')
		);
		generate_smilies('inline', PAGE_INDEX);
		if(count($errmsg) > 0)
		{
			$template->set_filenames(array(
				'reg_header' => 'error_body.tpl')
			);
			$error_msg = $lang['gb_error'];
			for($i = 0;$i<count($errmsg);$i++)
			{
				$error_msg .= '<br />'.$errmsg[$i];
			}
			$template->assign_vars(array(
				'ERROR_MESSAGE' => $error_msg)
			);
			$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
		}
		if(!$userdata['session_logged_in'] && $mode != 'edit')
		{
			$template->assign_block_vars('username',array(
				'USERNAME' => $username
			));
		}
		$me = unprepare_message($me);
		$ti = unprepare_message($ti);
		$template->assign_vars(array(
			'TITLE' => stripslashes($ti),
			'MESSAGE' => stripslashes($me),

			'L_GB_POST' => $lang['gb_post2'],
			'L_TITLE' => $lang['gb_title'],
			'L_MESSAGE_BODY' => $lang['Message_body'],
			'L_SUBMIT' => $lang['Submit'],
			'L_USERNAME' => $lang['Username'],

			'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
			'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
			'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
			'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
			'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
			'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
			'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
			'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
			'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
			'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
			'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
			'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
			'L_EMPTY_MESSAGE' => $lang['Empty_message'],

			'L_FONT_COLOR' => $lang['Font_color'],
			'L_COLOR_DEFAULT' => $lang['color_default'],
			'L_COLOR_DARK_RED' => $lang['color_dark_red'],
			'L_COLOR_RED' => $lang['color_red'],
			'L_COLOR_ORANGE' => $lang['color_orange'],
			'L_COLOR_BROWN' => $lang['color_brown'],
			'L_COLOR_YELLOW' => $lang['color_yellow'],
			'L_COLOR_GREEN' => $lang['color_green'],
			'L_COLOR_OLIVE' => $lang['color_olive'],
			'L_COLOR_CYAN' => $lang['color_cyan'],
			'L_COLOR_BLUE' => $lang['color_blue'],
			'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
			'L_COLOR_INDIGO' => $lang['color_indigo'],
			'L_COLOR_VIOLET' => $lang['color_violet'],
			'L_COLOR_WHITE' => $lang['color_white'],
			'L_COLOR_BLACK' => $lang['color_black'],

			'L_FONT_SIZE' => $lang['Font_size'],
			'L_FONT_TINY' => $lang['font_tiny'],
			'L_FONT_SMALL' => $lang['font_small'],
			'L_FONT_NORMAL' => $lang['font_normal'],
			'L_FONT_LARGE' => $lang['font_large'],
			'L_FONT_HUGE' => $lang['font_huge'],

			'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
			'L_STYLES_TIP' => $lang['Styles_tip'],

			'U_PROFILE' => append_sid('profile.'.$phpEx.'?mode=viewprofile&amp;'.POST_USERS_URL.'='.$this->uid),

			'S_POST_ACTION' => $action)
		);
		$template->pparse('body');
		include_once($phpbb_root_path."/includes/page_tail.".$phpEx);
	}
	function deleteall()
	{
		global $db,$lang,$phpEx;
		$sql = "DELETE FROM ".PROFILE_GUESTBOOK_TABLE." WHERE user_id = ".$this->uid."";
		if(!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR,"Could not delete guestbook posts!","",__LINE__,__FILE__,$sql);
		}
		$msg = '<br /><a href="' . $this->append_sid("gb=view") . '">'.$lang['back_pro'].'</a>';
		message_die(GENERAL_MESSAGE,$lang['gb_all_del'] . $msg);
	}
	function delete()
	{
		global $lang,$HTTP_POST_VARS,$db,$phpEx;
		$id = intval($HTTP_POST_VARS['gb_id']);
		if(empty($id))
		{
			message_die(GENERAL_ERROR,$lang['gb_no_id'],"",__LINE__,__FILE__);
		}
		$sql = "DELETE FROM ".PROFILE_GUESTBOOK_TABLE." WHERE user_id = ".$this->uid." AND gb_id = $id";
		if(!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR,"Could not delete guestbook posts!","",__LINE__,__FILE__,$sql);
		}
		$msg = '<br /><a href="' . $this->append_sid("gb=view") . '">'.$lang['back_pro'].'</a>';
		message_die(GENERAL_MESSAGE,$lang['gb_del'] . $msg);
	}
	function append_sid($url)
	{

		$url = $this->url_intern . '&amp;' . $url;
		$url = append_sid($url);
		return $url;
	}
	function version_check()
	{
		global $phpbb_root_path,$lang,$board_config,$phpEx;
		$text = "";
		if(is_writable($phpbb_root_path."/cache/"))
		{
			if(file_exists($phpbb_root_path."/cache/profilemod.".$phpEx))
			{
				include($phpbb_root_path."/cache/profilemod.".$phpEx);
				define('VERSION_CHECK_DELAY', 86400);
				$now = time();
				$version_check_delay = intval($last_check);
				$check = empty($version_check_delay) || (($now - $version_check_delay) > VERSION_CHECK_DELAY);
				if(!$check){
				 	$this->url = $url;
				}
			}
			else
			{
				$check = true;
			}
		}
		else
		{
			$check = true;
			$text .= "<strong>".$lang['cacho_not_write']."</strong><br />";
		}
		if($check)
		{
			$current_version = explode('.', $this->version);
			$minor_revision = intval( $current_version[2]);

			$errno = 0;
			$errstr = $version_info = '';

			if ($fsock = @fsockopen('www.paulscripts.nl', 80, $errno, $errstr))
			{
				@fputs($fsock, "GET /profile.txt HTTP/1.1\r\n");
				@fputs($fsock, "HOST: www.paulscripts.nl\r\n");
				@fputs($fsock, "Connection: close\r\n\r\n");

				$get_info = false;
				while (!@feof($fsock))
				{
					if ($get_info)
					{
						$version_info .= @fread($fsock, 1024);
					}
					else
					{
						if (@fgets($fsock, 1024) == "\r\n")
						{
							$get_info = true;
						}
					}
				}
				@fclose($fsock);

				$version_info = explode("\n", $version_info);
				$latest_head_revision = intval( $version_info[0]);
				$latest_minor_revision = intval($version_info[2]);
				$latest_version = intval($version_info[0]) . '.' . intval($version_info[1]) . '.' . intval($version_info[2]);
				$this->url = $version_info[3];

				if ($current_version[0] == intval($version_info[0]) && $current_version[1] == intval($version_info[1]) && $current_version[2] >= intval($version_info[2]))
				{
					$version_info = sprintf($lang['ok_check'],$this->version,$this->url,$this->url);
				}
				else
				{
					$version_info = sprintf($lang['not_ok_check'],$this->version,$latest_version,$this->url,$this->url);
				}
			}
			else
			{
				if ($errstr)
				{
					$version_info = sprintf($lang['gb_error_check'], $errstr);
				}
				else
				{
					$version_info = $lang['Socket_functions_disabled'];
				}
			}
			$text .= $version_info;
			if(is_writable($phpbb_root_path."/cache/")){
				@unlink($phpbb_root_path."/cache/profilemod.".$phpEx);
				$o = fopen($phpbb_root_path."/cache/profilemod.".$phpEx,"w");
				if(!$o)
				{
					message_die(GENERAL_ERROR,"Could not open $phpbb_root_path/cache/profilemod.".$phpEx."!","",__LINE__,__FILE__);
				}
				fwrite($o,"<"."?php\n\$last_check = ".time().";\n\$url = '".$this->url."';\n?".">");
				fclose($o);
			}
		}
		else
		{
			$text .= sprintf($lang['not_check'],$this->version,$this->url,$this->url);
		}
		return $text;
	}
}
?>
