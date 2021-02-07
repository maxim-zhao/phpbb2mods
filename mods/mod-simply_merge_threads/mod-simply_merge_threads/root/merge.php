<?php
//
//	file: merge.php
//	author: ptirhiik
//	begin: 12/07/2003
//	version: 1.0.0 - 31/08/2008
//	license: http://opensource.org/licenses/gpl-3.0.html GNU General Public License version 3 (GPLv3)
//
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
include_once($phpbb_root_path . 'includes/functions_topics_list.' . $phpEx);

// function block
function get_topic_id($topic)
{
	global $db;

	// remove any anchor
	if ( $topic && ($anchor = strrchr($topic, '#')) )
	{
		$topic = substr($topic, 0, - strlen($anchor));
	}

	// topic was just an anchor or is empty
	if ( !$topic )
	{
		return false;
	}

	// is this a direct value ?
	if ( ($val = intval($topic)) )
	{
		return $val;
	}

	// is it an url with topic id or post id ?
	$name = explode('?', $topic);
	$parms = isset($name[1]) ? $name[1] : $name[0];
	parse_str($parms, $parm);
	while ( (list($key, $val) = each($parm)) )
	{
		$val = intval($vals[0]);
		switch($key)
		{
			case POST_POST_URL:
				if ( $val )
				{
					$sql = 'SELECT topic_id
								FROM ' . POSTS_TABLE . '
								WHERE post_id = ' . intval($val);
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not get post informations', '', __LINE__, __FILE__, $sql);
					}
					$val = ($row = $db->sql_fetchrow($result)) ? intval($row['topic_id']) : false;
					$db->sql_freeresult($result);
				}
				return $val ? $val : false;

			case POST_TOPIC_URL:
				return $val ? $val : false;
		}
	}
	return false;
}

function sql_update($fields)
{
	return implode(', ', array_map(create_function('$field, $value', 'return $field . \' = \' . $value;'), array_keys($fields), array_values($fields)));
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

// check if user is a moderator or an admin
if ( !in_array($userdata['user_level'], array(MOD, ADMIN)) )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}

// from topic
$from_topic = isset($HTTP_POST_VARS['from_topic']) ? strtolower(trim(htmlspecialchars($HTTP_POST_VARS['from_topic']))) : '';
if ( empty($from_topic) && (isset($HTTP_GET_VARS[POST_TOPIC_URL]) || isset($HTTP_GET_VARS[POST_POST_URL])) )
{
	$from_topic = isset($HTTP_GET_VARS[POST_TOPIC_URL]) ? intval($HTTP_GET_VARS[POST_TOPIC_URL]) : POST_POST_URL . '=' . intval($HTTP_GET_VARS[POST_POST_URL]);
}
$from_topic_id = get_topic_id($from_topic);

// to topic
$to_topic = isset($HTTP_POST_VARS['to_topic']) ? strtolower(trim(htmlspecialchars($HTTP_POST_VARS['to_topic']))) : '';
$to_topic_id =  get_topic_id($to_topic);

// topic title
$topic_title = isset($HTTP_POST_VARS['topic_title']) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['topic_title']))) : '';

// start
$start = isset($HTTP_POST_VARS['start']) ? intval($start) : 0;

// buttons
$cancel = isset($HTTP_POST_VARS['cancel']);
$submit = $cancel ? false : isset($HTTP_POST_VARS['submit']);
$confirm = isset($HTTP_POST_VARS['confirm']);

$shadow = isset($HTTP_POST_VARS['shadow']);
$select_from = isset($HTTP_POST_VARS['select_from']);
$select_to = isset($HTTP_POST_VARS['select_to']);
$page_prec = isset($HTTP_POST_VARS['page_prec']);
$page_next = isset($HTTP_POST_VARS['page_next']);

// check if a selection has been made
$topic_selected = isset($HTTP_POST_VARS['topic_selected']) ? intval(substr($HTTP_POST_VARS['topic_selected'], 1)) : 0;

if ( $submit && !empty($topic_selected) )
{
	$submit = false;
	if ( $select_from )
	{
		$from_topic = $topic_selected;
		$from_topic_id = $topic_selected;
	}
	if ( $select_to )
	{
		$to_topic = $topic_selected;
		$to_topic_id = $topic_selected;
	}
	$select_from = false;
	$select_to = false;
}

// session id
$sid = '';
if ( !empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']) )
{
	$sid = !empty($HTTP_POST_VARS['sid']) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
if ( !preg_match('#^[0-9a-z]+$#', $sid) )
{
	$sid = '';
}

// titles
$from_title = $to_title = '';
$from_forum_id = $to_forum_id = 0;
$topic_ids = array_merge($from_topic_id ? array($from_topic_id) : array(), $to_topic_id ? array($to_topic_id) : array());
if ( $topic_ids )
{
	$sql = 'SELECT topic_id, forum_id, topic_title
				FROM ' . TOPICS_TABLE . '
				WHERE topic_id' . (count($topic_ids) > 1 ? ' IN(' . implode(', ', array_map('intval', $topic_ids)) . ')' : ' = ' . intval($topic_ids[0]));
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get from-topic informations', '', __LINE__, __FILE__, $sql);
	}
	while ( ($row = $db->sql_fetchrow($result)) )
	{
		if ( $from_topic_id && ($row['topic_id'] == $from_topic_id) )
		{
			$from_title = $row['topic_title'];
			$from_forum_id = intval($row['forum_id']);
		}
		if ( $to_topic_id && ($row['topic_id'] == $to_topic_id) )
		{
			$to_title = $row['topic_title'];
			$to_forum_id = intval($row['forum_id']);
		}
	}
	$db->sql_freeresult($result);
}
if ( !empty($to_title) && empty($topic_title) )
{
	$topic_title = $to_title;
}
if ( $to_forum_id && !$from_forum_id )
{
	$from_forum_id = $to_forum_id;
}

// forum_id
$forum_id = isset($HTTP_POST_VARS[POST_FORUM_URL]) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : (isset($HTTP_GET_VARS[POST_FORUM_URL]) ? intval($HTTP_GET_VARS[POST_FORUM_URL]) : 0);
if ( isset($HTTP_POST_VARS['fid']) || isset($HTTP_GET_VARS['fid']) )
{
	$fid = isset($HTTP_POST_VARS['fid']) ? $HTTP_POST_VARS['fid'] : $HTTP_GET_VARS['fid'];
	if ( substr($fid, 0, 1) == POST_FORUM_URL )
	{
		$forum_id = intval(substr($fid, 1));
	}
}

// selection
if ( ($select_from || $select_to) && !$cancel )
{
	if ( !$forum_id && $from_forum_id )
	{
		$forum_id = $from_forum_id;
	}
	// get the list of forums
	$list_forums = function_exists('selectbox') ? selectbox('fid', false, POST_FORUM_URL . $forum_id) : make_forum_select(POST_FORUM_URL, false, $forum_id);
	if ( !$forum_id )
	{
		$matches = array();
		$_id = preg_match('#value="([0-9]+)"#is', $list_forums, $matches);
		if ( $matches && isset($matches[1]) && intval($matches[1]) )
		{
			$forum_id = intval($matches[1]);
		}
	}

	// how many record in the forum
	$nbpages = 0;
	$per_page = intval($board_config['topics_per_page']);
	$sql_merge = 'SELECT t.*, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.post_username, p2.post_username AS post_username2, p2.post_time 
					FROM ' . TOPICS_TABLE . ' t, ' . USERS_TABLE . ' u, ' . POSTS_TABLE . ' p, ' . POSTS_TABLE . ' p2, ' . USERS_TABLE . ' u2
					WHERE t.forum_id = ' . intval($forum_id) . '
						AND t.topic_poster = u.user_id
						AND p.post_id = t.topic_first_post_id
						AND p2.post_id = t.topic_last_post_id
						AND u2.user_id = p2.poster_id 
						AND topic_status <> ' . intval(TOPIC_MOVED);

	if ( !empty($forum_id) )
	{
		$sql = $sql_merge;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get topics informations', '', __LINE__, __FILE__, $sql);
		}
		$nbitems = $db->sql_numrows($result);
		$nbpages = floor( ($nbitems-1) / $per_page ) + 1;
	}

	// change current page
	if ( $page_prec && ($start > 0) )
	{
		$start--;
	}
	if ( $page_next && ($start < ($nbpages-1)) )
	{
		$start++;
	}

	$pagination = array();
	if ( $nbpages > 1 )
	{
		if ( $start > 0 )
		{
			$pagination[] = '<input type="submit" name="page_prec" value="&laquo;" class="liteoption" />';
		}
		$pagination[] = sprintf($lang['Page_of'], $start + 1, $nbpages);
		if ( $start < ($nbpages-1) )
		{
			$pagination[] = '<input type="submit" name="page_next" value="&raquo;" class="liteoption" />';
		}
	}
	$pagination = $pagination ? implode('&nbsp;', $pagination) : '';

	// read the forum
	$start_topic = $start * $per_page;
	$topic_rowset = array();
	if ( !empty($forum_id) )
	{
		$sql = $sql_merge . '
					ORDER BY t.topic_type DESC, t.topic_last_post_id DESC
					LIMIT ' . intval($start_topic) . ', ' . intval($per_page);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get topics informations', '', __LINE__, __FILE__, $sql);
		}
		while ( ($row = $db->sql_fetchrow($result)) )
		{
			$row['topic_id'] = POST_TOPIC_URL . $row['topic_id'];
			$topic_rowset[] = $row;
		}
		$db->sql_freeresult($result);
	}

	// topics list parameters
	$box = 'MERGE_BOX';
	$tpl = '';
	$list_title = ($select_from) ? $lang['Merge_topic_from'] : $lang['Merge_topic_to'];
	$split_type = true;
	$display_nav_tree = false;
	$footer = '<input type="submit" name="submit" value="' . $lang['Select'] . '" class="mainoption" />';
	$footer .= '&nbsp;<input type="submit" name="cancel" value="' . $lang['Cancel'] . '" class="liteoption" />';
	$inbox = false;
	$select_field = 'topic_selected';
	$select_type = 2;
	$select_formname = 'post';
	topic_list($box, $tpl, $topic_rowset, $list_title, $split_type, $display_nav_tree, $footer, $inbox, $select_field, $select_type, $select_formname );

	// system
	$s_hidden_fields  = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
	$s_hidden_fields .= '<input type="hidden" name="topic_title" value="' . addslashes($topic_title) . '" />';
	$s_hidden_fields .= '<input type="hidden" name="from_topic" value="' . $from_topic . '" />';
	$s_hidden_fields .= '<input type="hidden" name="to_topic" value="' . $to_topic . '" />';
	$s_hidden_fields .= '<input type="hidden" name="submit" value="1" />';
	if ($shadow) $s_hidden_fields .= '<input type="hidden" name="shadow" value="1" />';
	if ($select_from) $s_hidden_fields .= '<input type="hidden" name="select_from" value="1" />';
	if ($select_to) $s_hidden_fields .= '<input type="hidden" name="select_to" value="1" />';
	$s_hidden_fields .= '<input type="hidden" name="start" value="' . $start . '" />';

	// display
	$page_title = $lang['Merge_topics'];
	$template->assign_vars(array(
		'L_GO' => $lang['Go'],
		'S_LIST_FORUMS' => $list_forums,
		'PAGINATION' => $pagination,

		'S_ACTION' => append_sid("./merge.$phpEx"),
		'S_HIDDEN_FIELDS' => $s_hidden_fields,
	));
	include ($phpbb_root_path . 'includes/page_header.'.$phpEx);
	$template->set_filenames(array('body' => 'merge_select_body.tpl'));
	$template->pparse('body');
	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	exit;
}

// submission
if ( $submit )
{
	// check session id
	if ( !$sid || ($sid != $userdata['session_id']) )
	{
		message_die(GENERAL_ERROR, 'Invalid_session');
	}

	// init
	$error = false;
	$error_msg = '';
	$message = '';

	// check if the from topic exists and get the forum_id
	$found = false;
	$from_forum_id = 0;
	$from_poll = false;
	if ( $from_topic_id )
	{
		$sql = 'SELECT forum_id, topic_vote
					FROM ' . TOPICS_TABLE . '
					WHERE topic_id = ' . intval($from_topic_id);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get topic informations', '', __LINE__, __FILE__, $sql);
		}
		if ($row = $db->sql_fetchrow($result))
		{
			$from_forum_id = intval($row['forum_id']);
			$from_poll = $row['topic_vote'];
			$found = true;
		}
		$db->sql_freeresult($result);
	}
	if ( !$found )
	{
		$error = true;
		$error_msg .= (($error_msg != '') ? '<br />' : '') . $lang['Merge_from_not_found'];
	}

	// check if the from topic exists and get the forum_id
	$found = false;
	$to_forum_id = 0;
	$to_poll = false;
	if ( $to_topic_id )
	{
		$sql = 'SELECT forum_id, topic_vote
					FROM ' . TOPICS_TABLE . '
					WHERE topic_id = ' . intval($to_topic_id);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get topic informations', '', __LINE__, __FILE__, $sql);
		}
		if ( ($row = $db->sql_fetchrow($result)) )
		{
			$to_forum_id = $row['forum_id'];
			$to_poll = $row['topic_vote'];
			$found = true;
		}
		$db->sql_freeresult($result);
	}
	if ( !$found )
	{
		$error = true;
		$error_msg .= (($error_msg != '') ? '<br />' : '') . $lang['Merge_to_not_found'];
	}

	// verify the topics are not the same
	if ( !$error && ($from_topic_id || $to_topic_id) && ($from_topic_id == $to_topic_id) )
	{
		$error = true;
		$error_msg .= (($error_msg != '') ? '<br />' : '') . $lang['Merge_topics_equals'];
	}

	// check authorizations
	if ( $from_forum_id )
	{
		$is_auth = auth(AUTH_ALL, $from_forum_id, $userdata);
		if ( !$is_auth['auth_mod'] )
		{
			$error = true;
			$error_msg .= (($error_msg != '') ? '<br />' : '') . $lang['Merge_from_not_authorized'];
		}
	}
	if ( $to_forum_id )
	{
		$is_auth = auth(AUTH_ALL, $to_forum_id, $userdata);
		if ( !$is_auth['auth_mod'] )
		{
			$error = true;
			$error_msg .= (($error_msg != '') ? '<br />' : '') . $lang['Merge_to_not_authorized'];
		}
	}

	//
	// warnings
	//
	// add here warnings regarding ie mycalendar

	// does from topic has a poll ?
	if ( $from_poll )
	{
		if ( $to_poll )
		{
			$message .= (($message != '') ? '<br />' : '') . $lang['Merge_poll_from_and_to'];
		}
		else
		{
			$message .= (($message != '') ? '<br />' : '') . $lang['Merge_poll_from'];
		}
	}

	// error found
	if ( $error )
	{
		message_die(GENERAL_ERROR, $error_msg);
	}

	// ask for confirmation or process
	if ( $confirm )
	{
		// process poll
		if ( $from_poll )
		{
			if ( $to_poll )
			{
				// delete the votes
				$vote_id = 0;
				$sql = 'SELECT vote_id 
							FROM ' . VOTE_DESC_TABLE . '
							WHERE topic_id = ' . intval($from_topic_id);
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not read vote description', '', __LINE__, __FILE__, $sql);
				}
				$vote_id = ($row = $db->sql_fetchrow($result)) ? intval($row['vote_id']) : false;
				$db->sql_freeresult($result);

				if ( $vote_id )
				{
					// delete voters
					$sql = 'DELETE FROM ' . VOTE_USERS_TABLE . '
								WHERE vote_id= ' . intval($vote_id);
					$db->sql_query($sql);

					// delete results
					$sql = 'DELETE FROM ' . VOTE_RESULTS_TABLE . '
								WHERE vote_id = ' . intval($vote_id);
					$db->sql_query($sql);

					// delete description
					$sql = 'DELETE FROM ' . VOTE_DESC_TABLE . '
								WHERE vote_id = ' . intval($vote_id);
					$db->sql_query($sql);
				}
			}
			else
			{
				// attach the poll to the new topic
				$sql = 'UPDATE ' . VOTE_DESC_TABLE . '
							SET topic_id = ' . intval($to_topic_id) . '
							WHERE topic_id = ' . intval($from_topic_id);
				$db->sql_query($sql);
			}
		}

		// here you can add the process of ie mycalendar dates

		// check if the destination is already watched
		$sql = 'SELECT *
					FROM ' . TOPICS_WATCH_TABLE . '
					WHERE topic_id = ' . intval($to_topic_id);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not read topics watch informations', '', __LINE__, __FILE__, $sql);
		}
		$user_ids = array();
		while ( ($row = $db->sql_fetchrow($result)) )
		{
			$user_ids[] = intval($row['user_id']);
		}
		$db->sql_freeresult($result);

		$sql_users = $user_ids ? implode(', ', $user_ids) : '';

		// grab the topics watch to the new topic
		$sql = 'UPDATE ' . TOPICS_WATCH_TABLE . '
					SET topic_id = ' . intval($to_topic_id) . '
					WHERE topic_id = ' . intval($from_topic_id) .  (!$sql_users ? '' : '
						AND user_id NOT IN(' . $sql_users . ')');
		$db->sql_query($sql);

		// clean up the old topics watch
		$sql = 'DELETE FROM ' . TOPICS_WATCH_TABLE . '
					WHERE topic_id = ' . intval($from_topic_id);
		$db->sql_query($sql);

		// process the posts
		$sql = 'UPDATE ' . POSTS_TABLE . '
					SET forum_id = ' . intval($to_forum_id) . ', topic_id = ' . intval($to_topic_id) . '
					WHERE topic_id = ' . intval($from_topic_id);
		$db->sql_query($sql);

		// get the old topic data for a shadow
		$sql = 'SELECT *
					FROM ' . TOPICS_TABLE . '
					WHERE topic_id = ' . intval($from_topic_id);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not read from-topic informations', '', __LINE__, __FILE__, $sql);
		}
		$topic_data = ($row = $db->sql_fetchrow($result)) ? $row : false;
		$db->sql_freeresult($result);

		if ( $shadow )
		{
			// transform the merged topic into a shadow one
			$sql = 'UPDATE ' . TOPICS_TABLE . '
						SET topic_status = ' . intval(TOPIC_MOVED) . ', topic_type = ' . intval(POST_NORMAL) . ', topic_moved_id = ' . intval($to_topic_id) . '
						WHERE topic_id = ' . intval($from_topic_id);
			$db->sql_query($sql);
		}
		else
		{
			// delete the old topic
			$sql = 'DELETE FROM ' . TOPICS_TABLE . '
						WHERE topic_id = ' . intval($from_topic_id);
			$db->sql_query($sql);
		}

		// build the update request
		$fields = array();
		if ( !empty($topic_title) )
		{
			$fields += array(
				'topic_title' => '\'' . str_replace('\\\'', '\'\'', addslashes($topic_title)) . '\'',
			);
		}

		// update the poll status
		if ( $from_poll && !$to_poll )
		{
			$fields += array(
				'topic_vote' => 1,
			);
		}

		// final update
		if ( $fields )
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . '
						SET ' . sql_update($fields) . '
						WHERE topic_id = ' . intval($to_topic_id);
			$db->sql_query($sql);
		}

		// synchronise the destination topic, and the both forums
		sync('topic', $to_topic_id);

		if ( $from_forum_id != $to_forum_id )
		{
			sync('forum', $from_forum_id);
		}
		sync('forum', $to_forum_id);
		
		// send end message
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="5;url=' . append_sid('./viewtopic.' . $phpEx . '?' . POST_TOPIC_URL . '=' . intval($to_topic_id)) . '">',
		));
		message_die(GENERAL_MESSAGE, $lang['Merge_topic_done'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid('./viewtopic.' . $phpEx . '?' . POST_TOPIC_URL . '=' . intval($to_topic_id)) . '" class="gen">', '</a>')  . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid('./index.' . $phpEx) . '" class="gen">', '</a>'));
		exit;
	}
	else
	{
		// ask for confirmation
		$message .= ($message != '' ? '<br />' : '') . sprintf($lang['Merge_confirm_process'], $from_title, $topic_title);

		$s_hidden_fields  = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
		$s_hidden_fields .= '<input type="hidden" name="topic_title" value="' . addslashes($topic_title) . '" />';
		$s_hidden_fields .= '<input type="hidden" name="from_topic" value="' . $from_topic . '" />';
		$s_hidden_fields .= '<input type="hidden" name="to_topic" value="' . $to_topic . '" />';
		$s_hidden_fields .= '<input type="hidden" name="submit" value="1" />';
		$s_hidden_fields .= $shadow ? '<input type="hidden" name="shadow" value="1" />' : '';

		// display
		$page_title = $lang['Merge_topics'];
		$template->assign_vars(array(
			'MESSAGE_TITLE' => $page_title,
			'MESSAGE_TEXT' => $message,
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'S_CONFIRM_ACTION' => append_sid('./merge.' . $phpEx),
			'S_HIDDEN_FIELDS' => $s_hidden_fields,
		));
		include ($phpbb_root_path . 'includes/page_header.'.$phpEx);
		$template->set_filenames(array('body' => 'confirm_body.tpl'));
		$template->pparse('body');
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		exit;
	}
}


// main screen
$s_hidden_fields  = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

// display
$page_title = $lang['Merge_topics'];
$template->assign_vars(array(
	'L_TITLE' => $page_title,
	'L_TOPIC_TITLE' => $lang['Merge_title'],
	'L_TOPIC_TITLE_EXPLAIN' => $lang['Merge_title_explain'],
	'L_FROM_TOPIC' => $lang['Merge_topic_from'],
	'L_FROM_TOPIC_EXPLAIN' => $lang['Merge_topic_from_explain'],
	'L_TO_TOPIC' => $lang['Merge_topic_to'],
	'L_TO_TOPIC_EXPLAIN' => $lang['Merge_topic_to_explain'],
	'L_SHADOW' => $lang['Leave_shadow_topic'],
	'L_SUBMIT' => $lang['Submit'],
	'L_CANCEL' => $lang['Cancel'],
	'L_REFRESH' => $lang['Refresh'],
	'L_SEARCH' => $lang['Select'],

	'TOPIC_TITLE' => $topic_title,
	'FROM_TOPIC' => $from_topic,
	'TO_TOPIC' => $to_topic,
	'SHADOW' => $shadow ? ' checked="checked"' : '',

	'S_ACTION' => append_sid('./merge.' . $phpEx),
	'S_HIDDEN_FIELDS' => $s_hidden_fields,
));
include ($phpbb_root_path . 'includes/page_header.'.$phpEx);
$template->set_filenames(array('body' => 'merge_body.tpl'));
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>