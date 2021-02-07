<?php
//-- mod : categories hierarchy ------------------------------------------------
/***************************************************************************
 *                                search.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: search.php,v 1.72.2.17 2005/09/14 18:14:30 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_search.'.$phpEx);

//-- mod : categories hierarchy ------------------------------------------------
//-- add
// read forums if not a searchuser
$searchuser = (_read('mode', TYPE_NO_HTML) == 'searchuser');
if ( !$searchuser )
{
	include($config->url('includes/class_forums'));
	$forums = new forums();
	$forums->read();
}
//-- fin mod : categories hierarchy --------------------------------------------

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_SEARCH);
init_userprefs($userdata);
//
// End session management
//

//-- mod : categories hierarchy ------------------------------------------------
//-- add
if ( !$searchuser )
{
	$user->get_cache(POST_FORUM_URL);
	$navigation = new navigation();
	$navigation->add('Search', '', 'search', array('mode' => _read('mode', TYPE_NO_HTML)), '');
	$navigation->display();
}

// topics class
include($config->url('includes/class_topics'));
class topics_search extends topics
{
	function topics_search($parms='', $extra_parms='')
	{
		parent::topics('search', $parms);
		$this->extra_parms = empty($extra_parms) ? array() : $extra_parms;
	}

	function read(&$search_results, $total_match_count)
	{
		global $db, $user;

		$this->forum_id = 0;
		$this->total_topics = $total_match_count;
		$start = $this->parms['start'];
		$ppage = $this->parms['ppage'];

		// read topics
		$sql = 'SELECT *
					FROM ' . TOPICS_TABLE . '
					WHERE topic_id IN(' . $search_results . ')
					ORDER BY topic_last_time DESC
					LIMIT ' . $start . ', ' . $ppage;

		// read results
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$this->pre_process();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$this->row_process($row);
			$this->data_ext[ $row['topic_id'] ] = $row;
		}
		$db->sql_freeresult($result);

		// get complementary data
		$this->post_process();
	}

	function bottom_line($empty=false)
	{
		global $template, $user;

		$template->set_switch('topicrow');
		$template->set_switch('topicrow.bottom');
		$template->set_switch('topicrow.bottom.no_topics', $empty);
		$template->set_filenames(array('bottom_row' => 'topics_bottom_search.tpl'));
		$template->assign_var_from_handle('BOTTOM_ROW', 'bottom_row');
	}
}
//-- fin mod : categories hierarchy --------------------------------------------

//
// Define initial vars
//
if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}
else
{
	$mode = '';
}

if ( isset($HTTP_POST_VARS['search_keywords']) || isset($HTTP_GET_VARS['search_keywords']) )
{
	$search_keywords = ( isset($HTTP_POST_VARS['search_keywords']) ) ? $HTTP_POST_VARS['search_keywords'] : $HTTP_GET_VARS['search_keywords'];
}
else
{
	$search_keywords = '';
}

if ( isset($HTTP_POST_VARS['search_author']) || isset($HTTP_GET_VARS['search_author']))
{
	$search_author = ( isset($HTTP_POST_VARS['search_author']) ) ? $HTTP_POST_VARS['search_author'] : $HTTP_GET_VARS['search_author'];
	$search_author = phpbb_clean_username($search_author);
}
else
{
	$search_author = '';
}

$search_id = ( isset($HTTP_GET_VARS['search_id']) ) ? $HTTP_GET_VARS['search_id'] : '';

$show_results = ( isset($HTTP_POST_VARS['show_results']) ) ? $HTTP_POST_VARS['show_results'] : 'posts';
$show_results = ($show_results == 'topics') ? 'topics' : 'posts';

if ( isset($HTTP_POST_VARS['search_terms']) )
{
	$search_terms = ( $HTTP_POST_VARS['search_terms'] == 'all' ) ? 1 : 0;
}
else
{
	$search_terms = 0;
}

if ( isset($HTTP_POST_VARS['search_fields']) )
{
	$search_fields = ( $HTTP_POST_VARS['search_fields'] == 'all' ) ? 1 : 0;
}
else
{
	$search_fields = 0;
}

$return_chars = ( isset($HTTP_POST_VARS['return_chars']) ) ? intval($HTTP_POST_VARS['return_chars']) : 200;

$search_cat = ( isset($HTTP_POST_VARS['search_cat']) ) ? intval($HTTP_POST_VARS['search_cat']) : -1;
$search_forum = ( isset($HTTP_POST_VARS['search_forum']) ) ? intval($HTTP_POST_VARS['search_forum']) : -1;

$sort_by = ( isset($HTTP_POST_VARS['sort_by']) ) ? intval($HTTP_POST_VARS['sort_by']) : 0;

if ( isset($HTTP_POST_VARS['sort_dir']) )
{
	$sort_dir = ( $HTTP_POST_VARS['sort_dir'] == 'DESC' ) ? 'DESC' : 'ASC';
}
else
{
	$sort_dir =  'DESC';
}

if ( !empty($HTTP_POST_VARS['search_time']) || !empty($HTTP_GET_VARS['search_time']))
{
	$search_time = time() - ( ( ( !empty($HTTP_POST_VARS['search_time']) ) ? intval($HTTP_POST_VARS['search_time']) : intval($HTTP_GET_VARS['search_time']) ) * 86400 );
	$topic_days = (!empty($HTTP_POST_VARS['search_time'])) ? intval($HTTP_POST_VARS['search_time']) : intval($HTTP_GET_VARS['search_time']);
}
else
{
	$search_time = 0;
	$topic_days = 0;
}

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

$sort_by_types = array($lang['Sort_Time'], $lang['Sort_Post_Subject'], $lang['Sort_Topic_Title'], $lang['Sort_Author'], $lang['Sort_Forum']);

//
// encoding match for workaround
//
$multibyte_charset = 'utf-8, big5, shift_jis, euc-kr, gb2312';

//
// Begin core code
//
//-- mod : Advanced Group Color Management -------------------------------------
//-- delete
//	if ( $mode == 'searchuser' )
//-- add
if ($mode == 'searchcolor')
{
	//
	// This handles the simple windowed user color
	//
	color_search();

	exit;
}
else if ($mode == 'searchuser')
//-- fin mod : Advanced Group Color Management ---------------------------------

{
	//
	// This handles the simple windowed user search functions called from various other scripts
	//
	if ( isset($HTTP_POST_VARS['search_username']) )
	{
		username_search($HTTP_POST_VARS['search_username']);
	}
	else
	{
		username_search('');
	}

	exit;
}
else if ( $search_keywords != '' || $search_author != '' || $search_id )
{
	$store_vars = array('search_results', 'total_match_count', 'split_search', 'sort_by', 'sort_dir', 'show_results', 'return_chars');
	$search_results = '';
//-- mod : categories hierarchy ------------------------------------------------
//-- add
	//
	// note : auth_sql will never be empty, so the forums table will always be joigned to the research
	//
	$auth_sql = '';
	$store_vars[] = 'no_subs';

	// read parms
	$search_forum = _read('search_forum', TYPE_INT);
	$no_subs = _button('no_subs');

	// check forum id
	if (!isset($forums->data[$search_forum]) || !$user->auth(POST_FORUM_URL, 'auth_read', $search_forum) )
	{
		message_die(GENERAL_MESSAGE, $user->lang('No_such_forum'));
	}

	// get min and max forum ids for the branch asked
	$min_id = intval($search_forum);
	$max_id = $no_subs ? $search_forum : $forums->data[$search_forum]['last_child_id'];

	// get excluded forums
	$tkeys = array_flip($forums->keys);
	$min_idx = $tkeys[$min_id];
	$max_idx = $tkeys[$max_id];
	unset($tkeys);
	$exclude_forums = array();
	$something = false;
	for ( $i = $min_idx; $i <= $max_idx; $i++ )
	{
		if ( !$user->auth(POST_FORUM_URL, 'auth_read', $forums->keys[$i]) )
		{
			$exclude_forums[] = $forums->keys[$i];
		}
		else
		{
			$something = true;
		}
	}

	// halt on no forum authed
	if ( !$something )
	{
		message_die(GENERAL_MESSAGE, $lang['No_searchable_forums']);
	}

	// set branch range
	$auth_sql = $no_subs ? 'f.forum_id = ' . $min_id : '(f.forum_order BETWEEN ' . intval($forums->data[$min_id]['forum_order']) . ' AND ' . intval($forums->data[$max_id]['forum_order']) . ')';

	// exclude unreadable forums
	if ( !empty($exclude_forums) )
	{
		$auth_sql .= count($exclude_forums) > 1 ? ' AND f.forum_id NOT IN(' . implode(', ', $exclude_forums) . ')' : ' AND f.forum_id <> ' . $exclude_forums[0];
		unset($exclude_forums);
	}
//-- fin mod : categories hierarchy --------------------------------------------

	//
	// Search ID Limiter, decrease this value if you experience further timeout problems with searching forums
	$limiter = 5000;

	//
	// Cycle through options ...
	//
	if ( $search_id == 'newposts' || $search_id == 'egosearch' || $search_id == 'unanswered' || $search_keywords != '' || $search_author != '' )
	{
		if ( $search_id == 'newposts' || $search_id == 'egosearch' || ( $search_author != '' && $search_keywords == '' )  )
		{
			if ( $search_id == 'newposts' )
			{
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
				if ( $userdata['session_logged_in'] )
				{
					$sql = "SELECT post_id 
						FROM " . POSTS_TABLE . " 
						WHERE post_time >= " . $userdata['user_lastvisit'];
				}
				else
				{
					redirect(append_sid("login.$phpEx?redirect=search.$phpEx&search_id=newposts", true));
				}
*/
//-- add
				$user->read_cookies();
				if ( empty($user->cookies['unreads']) )
				{
					message_return('No_search_match');
				}
				asort($user->cookies['unreads']);
				$floor = intval($user->cookies['unreads'][ _first_key($user->cookies['unreads']) ]);
				$sql = 'SELECT post_id, topic_id, post_time
							FROM ' . POSTS_TABLE . '
							WHERE topic_id IN(' . implode(', ', array_keys($user->cookies['unreads'])) . ')
								AND post_time > ' . $floor;
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				$search_ids = array();
				while ( $row = $db->sql_fetchrow($result) )
				{
					if ( $row['post_time'] >= $user->cookies['unreads'][ $row['topic_id'] ] )
					{
						$search_ids[] = $row['post_id'];
					}
				}
//-- fin mod : categories hierarchy --------------------------------------------

				$show_results = 'topics';
				$sort_by = 0;
				$sort_dir = 'DESC';
			}
			else if ( $search_id == 'egosearch' )
			{
				if ( $userdata['session_logged_in'] )
				{
					$sql = "SELECT post_id 
						FROM " . POSTS_TABLE . " 
						WHERE poster_id = " . $userdata['user_id'];
				}
				else
				{
					redirect(append_sid("login.$phpEx?redirect=search.$phpEx&search_id=egosearch", true));
				}

				$show_results = 'topics';
				$sort_by = 0;
				$sort_dir = 'DESC';
			}
			else
			{
				if (preg_match('#^[\*%]+$#', trim($search_author)) || preg_match('#^[^\*]{1,2}$#', str_replace(array('*', '%'), '', trim($search_author))))
				{
					$search_author = '';
				}

				$search_author = str_replace('*', '%', trim($search_author));
				
				$sql = "SELECT user_id
					FROM " . USERS_TABLE . "
					WHERE username LIKE '" . str_replace("\'", "''", $search_author) . "'";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Couldn't obtain list of matching users (searching for: $search_author)", "", __LINE__, __FILE__, $sql);
				}

				$matching_userids = '';
				if ( $row = $db->sql_fetchrow($result) )
				{
					do
					{
						$matching_userids .= ( ( $matching_userids != '' ) ? ', ' : '' ) . $row['user_id'];
					}
					while( $row = $db->sql_fetchrow($result) );
				}
				else
				{
					message_die(GENERAL_MESSAGE, $lang['No_search_match']);
				}

				$sql = "SELECT post_id 
					FROM " . POSTS_TABLE . " 
					WHERE poster_id IN ($matching_userids)";
				
				if ($search_time)
				{
					$sql .= " AND post_time >= " . $search_time;
				}
			}

//-- mod : categories hierarchy ------------------------------------------------
//-- add
			if ( $search_id != 'newposts' )
			{
//-- fin mod : categories hierarchy --------------------------------------------
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain matched posts list', '', __LINE__, __FILE__, $sql);
			}

			$search_ids = array();
			while( $row = $db->sql_fetchrow($result) )
			{
				$search_ids[] = $row['post_id'];
			}
			$db->sql_freeresult($result);
//-- mod : categories hierarchy ------------------------------------------------
//-- add
			}
//-- fin mod : categories hierarchy --------------------------------------------

			$total_match_count = count($search_ids);

		}
		else if ( $search_keywords != '' )
		{
			$stopword_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/search_stopwords.txt'); 
			$synonym_array = @file($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/search_synonyms.txt'); 

			$split_search = array();
			$stripped_keywords = stripslashes($search_keywords);
			$split_search = ( !strstr($multibyte_charset, $lang['ENCODING']) ) ?  split_words(clean_words('search', $stripped_keywords, $stopword_array, $synonym_array), 'search') : split(' ', $search_keywords);	
			unset($stripped_keywords);

			$search_msg_only = ( !$search_fields ) ? "AND m.title_match = 0" : ( ( strstr($multibyte_charset, $lang['ENCODING']) ) ? '' : '' );

			$word_count = 0;
			$current_match_type = 'or';

			$word_match = array();
			$result_list = array();

			for($i = 0; $i < count($split_search); $i++)
			{
				if (preg_match('#^[\*%]+$#', trim($split_search[$i])) || preg_match('#^[^\*]{1,2}$#', str_replace(array('*', '%'), '', trim($split_search[$i]))))
				{
					$split_search[$i] = '';
					continue;
				}

				switch ( $split_search[$i] )
				{
					case 'and':
						$current_match_type = 'and';
						break;

					case 'or':
						$current_match_type = 'or';
						break;

					case 'not':
						$current_match_type = 'not';
						break;

					default:
						if ( !empty($search_terms) )
						{
							$current_match_type = 'and';
						}

						if ( !strstr($multibyte_charset, $lang['ENCODING']) )
						{
							$match_word = str_replace('*', '%', $split_search[$i]);
							$sql = "SELECT m.post_id 
								FROM " . SEARCH_WORD_TABLE . " w, " . SEARCH_MATCH_TABLE . " m 
								WHERE w.word_text LIKE '$match_word' 
									AND m.word_id = w.word_id 
									AND w.word_common <> 1 
									$search_msg_only";
						}
						else
						{
							$match_word =  addslashes('%' . str_replace('*', '', $split_search[$i]) . '%');
							$search_msg_only = ( $search_fields ) ? "OR post_subject LIKE '$match_word'" : '';
							$sql = "SELECT post_id
								FROM " . POSTS_TEXT_TABLE . "
								WHERE post_text LIKE '$match_word'
								$search_msg_only";
						}
						if ( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not obtain matched posts list', '', __LINE__, __FILE__, $sql);
						}

						$row = array();
						while( $temp_row = $db->sql_fetchrow($result) )
						{
							$row[$temp_row['post_id']] = 1;

							if ( !$word_count )
							{
								$result_list[$temp_row['post_id']] = 1;
							}
							else if ( $current_match_type == 'or' )
							{
								$result_list[$temp_row['post_id']] = 1;
							}
							else if ( $current_match_type == 'not' )
							{
								$result_list[$temp_row['post_id']] = 0;
							}
						}

						if ( $current_match_type == 'and' && $word_count )
						{
							@reset($result_list);
							while( list($post_id, $match_count) = @each($result_list) )
							{
								if ( !$row[$post_id] )
								{
									$result_list[$post_id] = 0;
								}
							}
						}

						$word_count++;

						$db->sql_freeresult($result);
					}
			}

			@reset($result_list);

			$search_ids = array();
			while( list($post_id, $matches) = each($result_list) )
			{
				if ( $matches )
				{
					$search_ids[] = $post_id;
				}
			}	

			unset($result_list);
			$total_match_count = count($search_ids);
		}

		//
		// If user is logged in then we'll check to see which (if any) private
		// forums they are allowed to view and include them in the search.
		//
		// If not logged in we explicitly prevent searching of private forums
		//
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
		$auth_sql = '';
		if ( $search_forum != -1 )
		{
			$is_auth = auth(AUTH_READ, $search_forum, $userdata);

			if ( !$is_auth['auth_read'] )
			{
				message_die(GENERAL_MESSAGE, $lang['No_searchable_forums']);
			}

			$auth_sql = "f.forum_id = $search_forum";
		}
		else
		{
			$is_auth_ary = auth(AUTH_READ, AUTH_LIST_ALL, $userdata); 

			if ( $search_cat != -1 )
			{
				$auth_sql = "f.cat_id = $search_cat";
			}

			$ignore_forum_sql = '';
			while( list($key, $value) = each($is_auth_ary) )
			{
				if ( !$value['auth_read'] )
				{
					$ignore_forum_sql .= ( ( $ignore_forum_sql != '' ) ? ', ' : '' ) . $key;
				}
			}

			if ( $ignore_forum_sql != '' )
			{
				$auth_sql .= ( $auth_sql != '' ) ? " AND f.forum_id NOT IN ($ignore_forum_sql) " : "f.forum_id NOT IN ($ignore_forum_sql) ";
			}
		}
*/
//-- fin mod : categories hierarchy --------------------------------------------

		//
		// Author name search 
		//
		if ( $search_author != '' )
		{
			if (preg_match('#^[\*%]+$#', trim($search_author)) || preg_match('#^[^\*]{1,2}$#', str_replace(array('*', '%'), '', trim($search_author))))
			{
				$search_author = '';
			}

			$search_author = str_replace('*', '%', trim(str_replace("\'", "''", $search_author)));
		}

		if ( $total_match_count )
		{
			if ( $show_results == 'topics' )
			{
				//
				// This one is a beast, try to seperate it a bit (workaround for connection timeouts)
				//
				$search_id_chunks = array();
				$count = 0;
				$chunk = 0;

				if (count($search_ids) > $limiter)
				{
					for ($i = 0; $i < count($search_ids); $i++) 
					{
						if ($count == $limiter)
						{
							$chunk++;
							$count = 0;
						}

						$search_id_chunks[$chunk][$count] = $search_ids[$i];
						$count++;
					}
				}
				else
				{
					$search_id_chunks[0] = $search_ids;
				}

				$search_ids = array();

				for ($i = 0; $i < count($search_id_chunks); $i++)
				{
					$where_sql = '';

					if ( $search_time )
					{
						$where_sql .= ( $search_author == '' && $auth_sql == ''  ) ? " AND post_time >= $search_time " : " AND p.post_time >= $search_time ";
					}

					if ( $search_author == '' && $auth_sql == '' )
					{
						$sql = "SELECT topic_id 
							FROM " . POSTS_TABLE . "
							WHERE post_id IN (" . implode(", ", $search_id_chunks[$i]) . ") 
							$where_sql 
							GROUP BY topic_id";
					}
					else
					{
						$from_sql = POSTS_TABLE . " p"; 

						if ( $search_author != '' )
						{
							$from_sql .= ", " . USERS_TABLE . " u";
							$where_sql .= " AND u.user_id = p.poster_id AND u.username LIKE '$search_author' ";
						}

						if ( $auth_sql != '' )
						{
							$from_sql .= ", " . FORUMS_TABLE . " f";
							$where_sql .= " AND f.forum_id = p.forum_id AND $auth_sql";
						}

						$sql = "SELECT p.topic_id 
							FROM $from_sql 
							WHERE p.post_id IN (" . implode(", ", $search_id_chunks[$i]) . ") 
								$where_sql 
							GROUP BY p.topic_id";
					}

					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain topic ids', '', __LINE__, __FILE__, $sql);
					}

					while ($row = $db->sql_fetchrow($result))
					{
						$search_ids[] = $row['topic_id'];
					}
					$db->sql_freeresult($result);
				}

				$total_match_count = sizeof($search_ids);
		
			}
			else if ( $search_author != '' || $search_time || $auth_sql != '' )
			{
				$search_id_chunks = array();
				$count = 0;
				$chunk = 0;

				if (count($search_ids) > $limiter)
				{
					for ($i = 0; $i < count($search_ids); $i++) 
					{
						if ($count == $limiter)
						{
							$chunk++;
							$count = 0;
						}

						$search_id_chunks[$chunk][$count] = $search_ids[$i];
						$count++;
					}
				}
				else
				{
					$search_id_chunks[0] = $search_ids;
				}

				$search_ids = array();

				for ($i = 0; $i < count($search_id_chunks); $i++)
				{
					$where_sql = ( $search_author == '' && $auth_sql == '' ) ? 'post_id IN (' . implode(', ', $search_id_chunks[$i]) . ')' : 'p.post_id IN (' . implode(', ', $search_id_chunks[$i]) . ')';
					$select_sql = ( $search_author == '' && $auth_sql == '' ) ? 'post_id' : 'p.post_id';
					$from_sql = (  $search_author == '' && $auth_sql == '' ) ? POSTS_TABLE : POSTS_TABLE . ' p';

					if ( $search_time )
					{
						$where_sql .= ( $search_author == '' && $auth_sql == '' ) ? " AND post_time >= $search_time " : " AND p.post_time >= $search_time";
					}

					if ( $auth_sql != '' )
					{
						$from_sql .= ", " . FORUMS_TABLE . " f";
						$where_sql .= " AND f.forum_id = p.forum_id AND $auth_sql";
					}

					if ( $search_author != '' )
					{
						$from_sql .= ", " . USERS_TABLE . " u";
						$where_sql .= " AND u.user_id = p.poster_id AND u.username LIKE '$search_author'";
					}

					$sql = "SELECT " . $select_sql . " 
						FROM $from_sql 
						WHERE $where_sql";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain post ids', '', __LINE__, __FILE__, $sql);
					}

					while( $row = $db->sql_fetchrow($result) )
					{
						$search_ids[] = $row['post_id'];
					}
					$db->sql_freeresult($result);
				}

				$total_match_count = count($search_ids);
			}
		}
		else if ( $search_id == 'unanswered' )
		{
			if ( $auth_sql != '' )
			{
				$sql = "SELECT t.topic_id, f.forum_id
					FROM " . TOPICS_TABLE . "  t, " . FORUMS_TABLE . " f
					WHERE t.topic_replies = 0 
						AND t.forum_id = f.forum_id
						AND t.topic_moved_id = 0
						AND $auth_sql";
			}
			else
			{
				$sql = "SELECT topic_id 
					FROM " . TOPICS_TABLE . "  
					WHERE topic_replies = 0 
						AND topic_moved_id = 0";
			}

			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain post ids', '', __LINE__, __FILE__, $sql);
			}

			$search_ids = array();
			while( $row = $db->sql_fetchrow($result) )
			{
				$search_ids[] = $row['topic_id'];
			}
			$db->sql_freeresult($result);

			$total_match_count = count($search_ids);

			//
			// Basic requirements
			//
			$show_results = 'topics';
			$sort_by = 0;
			$sort_dir = 'DESC';
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['No_search_match']);
		}

		//
		// Finish building query (for all combinations)
		// and run it ...
		//
		$sql = "SELECT session_id 
			FROM " . SESSIONS_TABLE;
		if ( $result = $db->sql_query($sql) )
		{
			$delete_search_ids = array();
			while( $row = $db->sql_fetchrow($result) )
			{
				$delete_search_ids[] = "'" . $row['session_id'] . "'";
			}

			if ( count($delete_search_ids) )
			{
				$sql = "DELETE FROM " . SEARCH_TABLE . " 
					WHERE session_id NOT IN (" . implode(", ", $delete_search_ids) . ")";
				if ( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete old search id sessions', '', __LINE__, __FILE__, $sql);
				}
			}
		}

		//
		// Store new result data
		//
		$search_results = implode(', ', $search_ids);
		$per_page = ( $show_results == 'posts' ) ? $board_config['posts_per_page'] : $board_config['topics_per_page'];

		//
		// Combine both results and search data (apart from original query)
		// so we can serialize it and place it in the DB
		//
		$store_search_data = array();

		//
		// Limit the character length (and with this the results displayed at all following pages) to prevent
		// truncated result arrays. Normally, search results above 12000 are affected.
		// - to include or not to include
		/*
		$max_result_length = 60000;
		if (strlen($search_results) > $max_result_length)
		{
			$search_results = substr($search_results, 0, $max_result_length);
			$search_results = substr($search_results, 0, strrpos($search_results, ','));
			$total_match_count = count(explode(', ', $search_results));
		}
		*/

		for($i = 0; $i < count($store_vars); $i++)
		{
			$store_search_data[$store_vars[$i]] = $$store_vars[$i];
		}

		$result_array = serialize($store_search_data);
		unset($store_search_data);

		mt_srand ((double) microtime() * 1000000);
		$search_id = mt_rand();

		$sql = "UPDATE " . SEARCH_TABLE . " 
			SET search_id = $search_id, search_array = '" . str_replace("\'", "''", $result_array) . "'
			WHERE session_id = '" . $userdata['session_id'] . "'";
		if ( !($result = $db->sql_query($sql)) || !$db->sql_affectedrows() )
		{
			$sql = "INSERT INTO " . SEARCH_TABLE . " (search_id, session_id, search_array) 
				VALUES($search_id, '" . $userdata['session_id'] . "', '" . str_replace("\'", "''", $result_array) . "')";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert search results', '', __LINE__, __FILE__, $sql);
			}
		}
	}
	else
	{
		$search_id = intval($search_id);
		if ( $search_id )
		{
			$sql = "SELECT search_array 
				FROM " . SEARCH_TABLE . " 
				WHERE search_id = $search_id  
					AND session_id = '". $userdata['session_id'] . "'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$search_data = unserialize($row['search_array']);
				for($i = 0; $i < count($store_vars); $i++)
				{
					$$store_vars[$i] = $search_data[$store_vars[$i]];
				}
			}
		}
	}

	//
	// Look up data ...
	//
//-- mod : categories hierarchy ------------------------------------------------
//-- add
	// no result : bye :)
	if ( empty($search_results) )
	{
		message_die(GENERAL_MESSAGE, $lang['No_search_match']);
	}

	// get cookies for unreaded topics
	$user->read_cookies();

	// display results as topics
	if ( $show_results == 'topics' )
	{
		// get highlight parm
		$highlight_active = '';
		$highlight_match = array();
		for($j = 0; $j < count($split_search); $j++ )
		{
			$split_word = $split_search[$j];

			if ( $split_word != 'and' && $split_word != 'or' && $split_word != 'not' )
			{
				$highlight_match[] = '#\b(' . str_replace("*", "([\w]+)?", $split_word) . ')\b#is';
				$highlight_active .= " " . $split_word;

				for ($k = 0; $k < count($synonym_array); $k++)
				{ 
					list($replace_synonym, $match_synonym) = split(' ', trim(strtolower($synonym_array[$k]))); 

					if ( $replace_synonym == $split_word )
					{
						$highlight_match[] = '#\b(' . str_replace("*", "([\w]+)?", $replace_synonym) . ')\b#is';
						$highlight_active .= ' ' . $match_synonym;
					}
				} 
			}
		}
		$extra_parms = empty($highlight_active) ? '' : array('highlight' => urlencode(trim($highlight_active)));

		// filter page and order
		$start = max(0, _read('start', TYPE_INT));
		$ppage = _read('ppage', TYPE_INT);
		$ppage = ($ppage > 0) ? $ppage : (intval($user->data['user_topics_ppage']) ? intval($user->data['user_topics_ppage']) : (intval($config->data['topics_per_page']) ? intval($config->data['topics_per_page']) : 50));
		$parms = array(
			'sort' => '',
			'order' => '',
			'topicdays' => 0,
			'start' => $start,
			'ppage' => $ppage,
			'search_id' => intval($search_id),
		);

		$topics = new topics_search($parms, $extra_parms);
		$topics->read($search_results, $total_match_count);

		// start the page
		$page_title = $user->lang('Search');
		include($config->url('includes/page_header'));

		// jumpbox
		make_jumpbox('index');

		// constants
		$l_search_matches = ( $total_match_count == 1 ) ? sprintf($user->lang('Found_search_match'), $total_match_count) : sprintf($user->lang('Found_search_matches'), $total_match_count);
		$template->assign_vars(array(
			'L_SEARCH_MATCHES' => $l_search_matches,
		));

		// upper box (so with forum nav sentence for each topic), force display empty, force the title
		$topics->display(true, true);

		// display
		$template->set_filenames(array('body' => 'search_results_topics.tpl'));
		$template->pparse('body');
		include($config->url('includes/page_tail'));
		exit;
	}
//-- fin mod : categories hierarchy --------------------------------------------
	if ( $search_results != '' )
	{
		if ( $show_results == 'posts' )
		{
			$sql = "SELECT pt.post_text, pt.bbcode_uid, pt.post_subject, p.*, f.forum_id, f.forum_name, t.*, u.username, u.user_id, u.user_sig, u.user_sig_bbcode_uid  
				FROM " . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt 
				WHERE p.post_id IN ($search_results)
					AND pt.post_id = p.post_id
					AND f.forum_id = p.forum_id
					AND p.topic_id = t.topic_id
					AND p.poster_id = u.user_id";
//-- mod : categories hierarchy ------------------------------------------------
//-- add
			$sql = str_replace('SELECT ', 'SELECT pt.post_sub_title, ', $sql);
//-- fin mod : categories hierarchy --------------------------------------------
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$sql = str_replace('SELECT ', 'SELECT u.user_group_id, u.user_session_time, ', $sql);
//-- fin mod : Advanced Group Color Management ---------------------------------

		}
		else
		{
			$sql = "SELECT t.*, f.forum_id, f.forum_name, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.post_username, p2.post_username AS post_username2, p2.post_time 
				FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2, " . USERS_TABLE . " u2
				WHERE t.topic_id IN ($search_results) 
					AND t.topic_poster = u.user_id
					AND f.forum_id = t.forum_id 
					AND p.post_id = t.topic_first_post_id
					AND p2.post_id = t.topic_last_post_id
					AND u2.user_id = p2.poster_id";
//-- mod : Advanced Group Color Management -------------------------------------
//-- add
			$sql = str_replace('SELECT ', 'SELECT u.user_group_id as user_group_id_1, u2.user_group_id as user_group_id_2, u.user_session_time as user_session_time_1, u2.user_session_time as user_session_time_2, ', $sql);
//-- fin mod : Advanced Group Color Management ---------------------------------

		}

		$per_page = ( $show_results == 'posts' ) ? $board_config['posts_per_page'] : $board_config['topics_per_page'];

		$sql .= " ORDER BY ";
		switch ( $sort_by )
		{
			case 1:
				$sql .= ( $show_results == 'posts' ) ? 'pt.post_subject' : 't.topic_title';
				break;
			case 2:
				$sql .= 't.topic_title';
				break;
			case 3:
				$sql .= 'u.username';
				break;
			case 4:
				$sql .= 'f.forum_id';
				break;
			default:
				$sql .= ( $show_results == 'posts' ) ? 'p.post_time' : 'p2.post_time';
				break;
		}
		$sql .= " $sort_dir LIMIT $start, " . $per_page;

		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain search results', '', __LINE__, __FILE__, $sql);
		}

		$searchset = array();
		while( $row = $db->sql_fetchrow($result) )
		{
			$searchset[] = $row;
		}
		
		$db->sql_freeresult($result);		
		
		//
		// Define censored word matches
		//
		$orig_word = array();
		$replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);

		//
		// Output header
		//
		$page_title = $lang['Search'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);	

		if ( $show_results == 'posts' )
		{
			$template->set_filenames(array(
				'body' => 'search_results_posts.tpl')
			);
		}
		else
		{
			$template->set_filenames(array(
				'body' => 'search_results_topics.tpl')
			);
		}
		make_jumpbox('viewforum.'.$phpEx);

		$l_search_matches = ( $total_match_count == 1 ) ? sprintf($lang['Found_search_match'], $total_match_count) : sprintf($lang['Found_search_matches'], $total_match_count);

		$template->assign_vars(array(
			'L_SEARCH_MATCHES' => $l_search_matches, 
			'L_TOPIC' => $lang['Topic'])
		);

		$highlight_active = '';
		$highlight_match = array();
		for($j = 0; $j < count($split_search); $j++ )
		{
			$split_word = $split_search[$j];

			if ( $split_word != 'and' && $split_word != 'or' && $split_word != 'not' )
			{
				$highlight_match[] = '#\b(' . str_replace("*", "([\w]+)?", $split_word) . ')\b#is';
				$highlight_active .= " " . $split_word;

				for ($k = 0; $k < count($synonym_array); $k++)
				{ 
					list($replace_synonym, $match_synonym) = split(' ', trim(strtolower($synonym_array[$k]))); 

					if ( $replace_synonym == $split_word )
					{
						$highlight_match[] = '#\b(' . str_replace("*", "([\w]+)?", $replace_synonym) . ')\b#is';
						$highlight_active .= ' ' . $match_synonym;
					}
				} 
			}
		}

		$highlight_active = urlencode(trim($highlight_active));

//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
		$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : array();
		$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) : array();
*/
//-- add
		// prepare title enhancement
		$front_title = new front_title();
//-- fin mod : categories hierarchy --------------------------------------------

		for($i = 0; $i < count($searchset); $i++)
		{
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
			$forum_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . '=' . $searchset[$i]['forum_id']);
*/
//-- add
			$forum_url = $config->url('index', array(POST_FORUM_URL => $searchset[$i]['forum_id']), true);
//-- fin mod : categories hierarchy --------------------------------------------
			$topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $searchset[$i]['topic_id'] . "&amp;highlight=$highlight_active");
			$post_url = append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $searchset[$i]['post_id'] . "&amp;highlight=$highlight_active") . '#' . $searchset[$i]['post_id'];

			$post_date = create_date($board_config['default_dateformat'], $searchset[$i]['post_time'], $board_config['board_timezone']);

			$message = $searchset[$i]['post_text'];
			$topic_title = $searchset[$i]['topic_title'];

			$forum_id = $searchset[$i]['forum_id'];
			$topic_id = $searchset[$i]['topic_id'];

			if ( $show_results == 'posts' )
			{
				if ( isset($return_chars) )
				{
					$bbcode_uid = $searchset[$i]['bbcode_uid'];

					//
					// If the board has HTML off but the post has HTML
					// on then we process it, else leave it alone
					//
					if ( $return_chars != -1 )
					{
						$message = strip_tags($message);
						$message = preg_replace("/\[.*?:$bbcode_uid:?.*?\]/si", '', $message);
						$message = preg_replace('/\[url\]|\[\/url\]/si', '', $message);
						$message = ( strlen($message) > $return_chars ) ? substr($message, 0, $return_chars) . ' ...' : $message;
					}
					else
					{
						if ( !$board_config['allow_html'] )
						{
							if ( $postrow[$i]['enable_html'] )
							{
								$message = preg_replace('#(<)([\/]?.*?)(>)#is', '&lt;\\2&gt;', $message);
							}
						}

						if ( $bbcode_uid != '' )
						{
							$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
						}

						$message = make_clickable($message);

						if ( $highlight_active )
						{
							if ( preg_match('/<.*>/', $message) )
							{
								$message = preg_replace($highlight_match, '<!-- #sh -->\1<!-- #eh -->', $message);

								$end_html = 0;
								$start_html = 1;
								$temp_message = '';
								$message = ' ' . $message . ' ';

								while( $start_html = strpos($message, '<', $start_html) )
								{
									$grab_length = $start_html - $end_html - 1;
									$temp_message .= substr($message, $end_html + 1, $grab_length);

									if ( $end_html = strpos($message, '>', $start_html) )
									{
										$length = $end_html - $start_html + 1;
										$hold_string = substr($message, $start_html, $length);

										if ( strrpos(' ' . $hold_string, '<') != 1 )
										{
											$end_html = $start_html + 1;
											$end_counter = 1;

											while ( $end_counter && $end_html < strlen($message) )
											{
												if ( substr($message, $end_html, 1) == '>' )
												{
													$end_counter--;
												}
												else if ( substr($message, $end_html, 1) == '<' )
												{
													$end_counter++;
												}

												$end_html++;
											}

											$length = $end_html - $start_html + 1;
											$hold_string = substr($message, $start_html, $length);
											$hold_string = str_replace('<!-- #sh -->', '', $hold_string);
											$hold_string = str_replace('<!-- #eh -->', '', $hold_string);
										}
										else if ( $hold_string == '<!-- #sh -->' )
										{
											$hold_string = str_replace('<!-- #sh -->', '<span style="color:#' . $theme['fontcolor3'] . '"><b>', $hold_string);
										}
										else if ( $hold_string == '<!-- #eh -->' )
										{
											$hold_string = str_replace('<!-- #eh -->', '</b></span>', $hold_string);
										}

										$temp_message .= $hold_string;

										$start_html += $length;
									}
									else
									{
										$start_html = strlen($message);
									}
								}

								$grab_length = strlen($message) - $end_html - 1;
								$temp_message .= substr($message, $end_html + 1, $grab_length);

								$message = trim($temp_message);
							}
							else
							{
								$message = preg_replace($highlight_match, '<span style="color:#' . $theme['fontcolor3'] . '"><b>\1</b></span>', $message);
							}
						}
					}

					if ( count($orig_word) )
					{
						$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
						$post_subject = ( $searchset[$i]['post_subject'] != "" ) ? preg_replace($orig_word, $replacement_word, $searchset[$i]['post_subject']) : $topic_title;

						$message = preg_replace($orig_word, $replacement_word, $message);
					}
					else
					{
						$post_subject = ( $searchset[$i]['post_subject'] != '' ) ? $searchset[$i]['post_subject'] : $topic_title;
					}

					if ($board_config['allow_smilies'] && $searchset[$i]['enable_smilies'])
					{
						$message = smilies_pass($message);
					}

					$message = str_replace("\n", '<br />', $message);

				}

				$poster = ( $searchset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $searchset[$i]['user_id']) . '">' : '';
//-- mod : Advanced Group Color Management -------------------------------------
//-- delete
//	$poster .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? $searchset[$i]['username'] : ( ( $searchset[$i]['post_username'] != "" ) ? $searchset[$i]['post_username'] : $lang['Guest'] );
//-- add
				$poster .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? $colors->get_user_color($searchset[$i]['user_group_id'], $searchset[$i]['user_session_time'], $searchset[$i]['username']) : ((!empty($searchset[$i]['post_username'])) ? $colors->get_user_color($searchset[$i]['user_group_id'], '0', $searchset[$i]['post_username']) : $colors->get_user_color($searchset[$i]['user_group_id'], '0', $lang['Guest']));
//-- fin mod : Advanced Group Color Management ---------------------------------

				$poster .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';

//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
				if ( $userdata['session_logged_in'] && $searchset[$i]['post_time'] > $userdata['user_lastvisit'] )
				{
					if ( !empty($tracking_topics[$topic_id]) && !empty($tracking_forums[$forum_id]) )
					{
						$topic_last_read = ( $tracking_topics[$topic_id] > $tracking_forums[$forum_id] ) ? $tracking_topics[$topic_id] : $tracking_forums[$forum_id];
					}
					else if ( !empty($tracking_topics[$topic_id]) || !empty($tracking_forums[$forum_id]) )
					{
						$topic_last_read = ( !empty($tracking_topics[$topic_id]) ) ? $tracking_topics[$topic_id] : $tracking_forums[$forum_id];
					}

					if ( $searchset[$i]['post_time'] > $topic_last_read )
					{
						$mini_post_img = $images['icon_minipost_new'];
						$mini_post_alt = $lang['New_post'];
					}
					else
					{
						$mini_post_img = $images['icon_minipost'];
						$mini_post_alt = $lang['Post'];
					}
				}
				else
				{
					$mini_post_img = $images['icon_minipost'];
					$mini_post_alt = $lang['Post'];
				}
*/
//-- add
				$topic_last_read = intval($user->cookies['unreads'][ $search_set[$i]['topic_id'] ]);
				if ( !empty($topic_last_read) && ($searchset[$i]['post_time'] > $topic_last_read) )
				{
					$mini_post_img = $images['icon_minipost_new'];
					$mini_post_alt = $lang['New_post'];
				}
				else
				{
					$mini_post_img = $images['icon_minipost'];
					$mini_post_alt = $lang['Post'];
				}
//-- fin mod : categories hierarchy --------------------------------------------

				$template->assign_block_vars("searchresults", array( 
					'TOPIC_TITLE' => $topic_title,
					'FORUM_NAME' => $searchset[$i]['forum_name'],
					'POST_SUBJECT' => $post_subject,
					'POST_DATE' => $post_date,
					'POSTER_NAME' => $poster,
					'TOPIC_REPLIES' => $searchset[$i]['topic_replies'],
					'TOPIC_VIEWS' => $searchset[$i]['topic_views'],
					'MESSAGE' => $message,
					'MINI_POST_IMG' => $mini_post_img, 

					'L_MINI_POST_ALT' => $mini_post_alt, 

					'U_POST' => $post_url,
					'U_TOPIC' => $topic_url,
					'U_FORUM' => $forum_url)
				);
//-- mod : categories hierarchy ------------------------------------------------
//-- add
				// enhance the topic title
				$front_title->set('searchresults', $searchset[$i], $searchset[$i]['topic_first_post_id'] == $searchset[$i]['post_id'], $highlight_active);

				// navigation
				$forums->display_nav($searchset[$i]['forum_id'], 'searchresults.nav', true);
//-- fin mod : categories hierarchy --------------------------------------------
			}
//-- mod : categories hierarchy ------------------------------------------------
//
// all of this is now just after "// Look up data ..."
//-- delete
/*
			else
			{
				$message = '';

				if ( count($orig_word) )
				{
					$topic_title = preg_replace($orig_word, $replacement_word, $searchset[$i]['topic_title']);
				}

				$topic_type = $searchset[$i]['topic_type'];

				if ($topic_type == POST_ANNOUNCE)
				{
					$topic_type = $lang['Topic_Announcement'] . ' ';
				}
				else if ($topic_type == POST_STICKY)
				{
					$topic_type = $lang['Topic_Sticky'] . ' ';
				}
				else
				{
					$topic_type = '';
				}

				if ( $searchset[$i]['topic_vote'] )
				{
					$topic_type .= $lang['Topic_Poll'] . ' ';
				}

				$views = $searchset[$i]['topic_views'];
				$replies = $searchset[$i]['topic_replies'];

				if ( ( $replies + 1 ) > $board_config['posts_per_page'] )
				{
					$total_pages = ceil( ( $replies + 1 ) / $board_config['posts_per_page'] );
					$goto_page = ' [ <img src="' . $images['icon_gotopost'] . '" alt="' . $lang['Goto_page'] . '" title="' . $lang['Goto_page'] . '" />' . $lang['Goto_page'] . ': ';

					$times = 1;
					for($j = 0; $j < $replies + 1; $j += $board_config['posts_per_page'])
					{
						$goto_page .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $topic_id . "&amp;start=$j") . '">' . $times . '</a>';
						if ( $times == 1 && $total_pages > 4 )
						{
							$goto_page .= ' ... ';
							$times = $total_pages - 3;
							$j += ( $total_pages - 4 ) * $board_config['posts_per_page'];
						}
						else if ( $times < $total_pages )
						{
							$goto_page .= ', ';
						}
						$times++;
					}
					$goto_page .= ' ] ';
				}
				else
				{
					$goto_page = '';
				}

				if ( $searchset[$i]['topic_status'] == TOPIC_MOVED )
				{
					$topic_type = $lang['Topic_Moved'] . ' ';
					$topic_id = $searchset[$i]['topic_moved_id'];

					$folder_image = '<img src="' . $images['folder'] . '" alt="' . $lang['No_new_posts'] . '" />';
					$newest_post_img = '';
				}
				else
				{
					if ( $searchset[$i]['topic_status'] == TOPIC_LOCKED )
					{
						$folder = $images['folder_locked'];
						$folder_new = $images['folder_locked_new'];
					}
					else if ( $searchset[$i]['topic_type'] == POST_ANNOUNCE )
					{
						$folder = $images['folder_announce'];
						$folder_new = $images['folder_announce_new'];
					}
					else if ( $searchset[$i]['topic_type'] == POST_STICKY )
					{
						$folder = $images['folder_sticky'];
						$folder_new = $images['folder_sticky_new'];
					}
					else
					{
						if ( $replies >= $board_config['hot_threshold'] )
						{
							$folder = $images['folder_hot'];
							$folder_new = $images['folder_hot_new'];
						}
						else
						{
							$folder = $images['folder'];
							$folder_new = $images['folder_new'];
						}
					}

					if ( $userdata['session_logged_in'] )
					{
						if ( $searchset[$i]['post_time'] > $userdata['user_lastvisit'] ) 
						{
							if ( !empty($tracking_topics) || !empty($tracking_forums) || isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) )
							{

								$unread_topics = true;

								if ( !empty($tracking_topics[$topic_id]) )
								{
									if ( $tracking_topics[$topic_id] > $searchset[$i]['post_time'] )
									{
										$unread_topics = false;
									}
								}

								if ( !empty($tracking_forums[$forum_id]) )
								{
									if ( $tracking_forums[$forum_id] > $searchset[$i]['post_time'] )
									{
										$unread_topics = false;
									}
								}

								if ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all']) )
								{
									if ( $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f_all'] > $searchset[$i]['post_time'] )
									{
										$unread_topics = false;
									}
								}

								if ( $unread_topics )
								{
									$folder_image = $folder_new;
									$folder_alt = $lang['New_posts'];

									$newest_post_img = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
								}
								else
								{
									$folder_alt = ( $searchset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];

									$folder_image = $folder;
									$folder_alt = $folder_alt;
									$newest_post_img = '';
								}

							}
							else if ( $searchset[$i]['post_time'] > $userdata['user_lastvisit'] ) 
							{
								$folder_image = $folder_new;
								$folder_alt = $lang['New_posts'];

								$newest_post_img = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
							}
							else 
							{
								$folder_image = $folder;
								$folder_alt = ( $searchset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];
								$newest_post_img = '';
							}
						}
						else
						{
							$folder_image = $folder;
							$folder_alt = ( $searchset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];
							$newest_post_img = '';
						}
					}
					else
					{
						$folder_image = $folder;
						$folder_alt = ( $searchset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];
						$newest_post_img = '';
					}
				}


				$topic_author = ( $searchset[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '=' . $searchset[$i]['user_id']) . '">' : '';
				$topic_author .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? $searchset[$i]['username'] : ( ( $searchset[$i]['post_username'] != '' ) ? $searchset[$i]['post_username'] : $lang['Guest'] );

				$topic_author .= ( $searchset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';

				$first_post_time = create_date($board_config['default_dateformat'], $searchset[$i]['topic_time'], $board_config['board_timezone']);

				$last_post_time = create_date($board_config['default_dateformat'], $searchset[$i]['post_time'], $board_config['board_timezone']);

				$last_post_author = ( $searchset[$i]['id2'] == ANONYMOUS ) ? ( ($searchset[$i]['post_username2'] != '' ) ? $searchset[$i]['post_username2'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $searchset[$i]['id2']) . '">' . $searchset[$i]['user2'] . '</a>';

				$last_post_url = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $searchset[$i]['topic_last_post_id']) . '#' . $searchset[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" /></a>';

				$template->assign_block_vars('searchresults', array( 
					'FORUM_NAME' => $searchset[$i]['forum_name'],
					'FORUM_ID' => $forum_id,
					'TOPIC_ID' => $topic_id,
					'FOLDER' => $folder_image,
					'NEWEST_POST_IMG' => $newest_post_img, 
					'TOPIC_FOLDER_IMG' => $folder_image, 
					'GOTO_PAGE' => $goto_page,
					'REPLIES' => $replies,
					'TOPIC_TITLE' => $topic_title,
					'TOPIC_TYPE' => $topic_type,
					'VIEWS' => $views,
					'TOPIC_AUTHOR' => $topic_author, 
					'FIRST_POST_TIME' => $first_post_time, 
					'LAST_POST_TIME' => $last_post_time,
					'LAST_POST_AUTHOR' => $last_post_author,
					'LAST_POST_IMG' => $last_post_url,

					'L_TOPIC_FOLDER_ALT' => $folder_alt, 

					'U_VIEW_FORUM' => $forum_url, 
					'U_VIEW_TOPIC' => $topic_url)
				);
			}
*/
//-- fin mod : categories hierarchy --------------------------------------------
		}

		$base_url = "search.$phpEx?search_id=$search_id";

//-- mod : categories hierarchy ------------------------------------------------
//-- add
		// pagination
		$parms = array('search_id' => $search_id);
		$requester = 'search';
		$pagination = new pagination($requester, $parms, 'start');
		$pagination->display('pagination', $total_match_count, $per_page, $start, true, 'Posts_count');
		$template->assign_vars(array(
			'I_TOPIC' => $user->img('folder'),
		));
//-- fin mod : categories hierarchy --------------------------------------------

		$template->assign_vars(array(
			'PAGINATION' => generate_pagination($base_url, $total_match_count, $per_page, $start),
			'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $per_page ) + 1 ), ceil( $total_match_count / $per_page )), 

			'L_AUTHOR' => $lang['Author'],
			'L_MESSAGE' => $lang['Message'],
			'L_FORUM' => $lang['Forum'],
			'L_TOPICS' => $lang['Topics'],
			'L_REPLIES' => $lang['Replies'],
			'L_VIEWS' => $lang['Views'],
			'L_POSTS' => $lang['Posts'],
			'L_LASTPOST' => $lang['Last_Post'], 
			'L_POSTED' => $lang['Posted'], 
			'L_SUBJECT' => $lang['Subject'],

			'L_GOTO_PAGE' => $lang['Goto_page'])
		);

		$template->pparse('body');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['No_search_match']);
	}
}

//
// Search forum
//
//-- mod : categories hierarchy ------------------------------------------------
//-- delete
/*
$sql = "SELECT c.cat_title, c.cat_id, f.forum_name, f.forum_id  
	FROM " . CATEGORIES_TABLE . " c, " . FORUMS_TABLE . " f
	WHERE f.cat_id = c.cat_id 
	ORDER BY c.cat_order, f.forum_order";
$result = $db->sql_query($sql);
if ( !$result )
{
	message_die(GENERAL_ERROR, 'Could not obtain forum_name/forum_id', '', __LINE__, __FILE__, $sql);
}

$is_auth_ary = auth(AUTH_READ, AUTH_LIST_ALL, $userdata);

$s_forums = '';
while( $row = $db->sql_fetchrow($result) )
{
	if ( $is_auth_ary[$row['forum_id']]['auth_read'] )
	{
		$s_forums .= '<option value="' . $row['forum_id'] . '">' . $row['forum_name'] . '</option>';
		if ( empty($list_cat[$row['cat_id']]) )
		{
			$list_cat[$row['cat_id']] = $row['cat_title'];
		}
	}
}

if ( $s_forums != '' )
{
	$s_forums = '<option value="-1">' . $lang['All_available'] . '</option>' . $s_forums;

	//
	// Category to search
	//
	$s_categories = '<option value="-1">' . $lang['All_available'] . '</option>';
	while( list($cat_id, $cat_title) = @each($list_cat))
	{
		$s_categories .= '<option value="' . $cat_id . '">' . $cat_title . '</option>';
	}
}
else
{
	message_die(GENERAL_MESSAGE, $lang['No_searchable_forums']);
}
*/
//-- add
$front_pic = $forums->get_front_pic();
$s_forums = '';
if ( !empty($front_pic) )
{
	foreach ( $front_pic as $cur_id => $front )
	{
		$selected = ($search_forum == $cur_id) ? ' selected="selected"' : '';
		$s_forums .= '<option value="' . (($cur_id >= 0) ? $cur_id : -1) . '"' . $selected . '>';
		$count_front = strlen($front);
		for ( $i = 0; $i < $count_front; $i++ )
		{
			$s_forums .= $user->lang('tree_pic_' . $front[$i]);
		}
		if ( $cur_id >= 0 )
		{
			$s_forums .= $user->lang($forums->data[$cur_id]['forum_name']);
		}
		$s_forums .= '</option>';
	}
}
else
{
	message_die(GENERAL_MESSAGE, $lang['No_searchable_forums']);
}
$template->assign_vars(array(
	'L_SEARCH_FORUM' => $user->lang('Search_in_forum'),
	'L_NO_SUBS' => $user->lang('Search_no_subs'),
	'S_NO_SUBS' => _button('no_subs') ? 'checked="checked"' : '',
	'I_SEARCH_BUTTON' => $user->img('cmd_search'),
));
//-- fin mod : categories hierarchy --------------------------------------------

//
// Number of chars returned
//
$s_characters = '<option value="-1">' . $lang['All_available'] . '</option>';
$s_characters .= '<option value="0">0</option>';
$s_characters .= '<option value="25">25</option>';
$s_characters .= '<option value="50">50</option>';

for($i = 100; $i < 1100 ; $i += 100)
{
	$selected = ( $i == 200 ) ? ' selected="selected"' : '';
	$s_characters .= '<option value="' . $i . '"' . $selected . '>' . $i . '</option>';
}

//
// Sorting
//
$s_sort_by = "";
for($i = 0; $i < count($sort_by_types); $i++)
{
	$s_sort_by .= '<option value="' . $i . '">' . $sort_by_types[$i] . '</option>';
}

//
// Search time
//
$previous_days = array(0, 1, 7, 14, 30, 90, 180, 364);
$previous_days_text = array($lang['All_Posts'], $lang['1_Day'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

$s_time = '';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ( $topic_days == $previous_days[$i] ) ? ' selected="selected"' : '';
	$s_time .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}

//
// Output the basic page
//
$page_title = $lang['Search'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'search_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'L_SEARCH_QUERY' => $lang['Search_query'], 
	'L_SEARCH_OPTIONS' => $lang['Search_options'], 
	'L_SEARCH_KEYWORDS' => $lang['Search_keywords'], 
	'L_SEARCH_KEYWORDS_EXPLAIN' => $lang['Search_keywords_explain'], 
	'L_SEARCH_AUTHOR' => $lang['Search_author'],
	'L_SEARCH_AUTHOR_EXPLAIN' => $lang['Search_author_explain'], 
	'L_SEARCH_ANY_TERMS' => $lang['Search_for_any'],
	'L_SEARCH_ALL_TERMS' => $lang['Search_for_all'], 
	'L_SEARCH_MESSAGE_ONLY' => $lang['Search_msg_only'], 
	'L_SEARCH_MESSAGE_TITLE' => $lang['Search_title_msg'], 
	'L_CATEGORY' => $lang['Category'], 
	'L_RETURN_FIRST' => $lang['Return_first'],
	'L_CHARACTERS' => $lang['characters_posts'], 
	'L_SORT_BY' => $lang['Sort_by'],
	'L_SORT_ASCENDING' => $lang['Sort_Ascending'],
	'L_SORT_DESCENDING' => $lang['Sort_Descending'],
	'L_SEARCH_PREVIOUS' => $lang['Search_previous'], 
	'L_DISPLAY_RESULTS' => $lang['Display_results'], 
	'L_FORUM' => $lang['Forum'],
	'L_TOPICS' => $lang['Topics'],
	'L_POSTS' => $lang['Posts'],

	'S_SEARCH_ACTION' => append_sid("search.$phpEx?mode=results"),
	'S_CHARACTER_OPTIONS' => $s_characters,
	'S_FORUM_OPTIONS' => $s_forums, 
	'S_CATEGORY_OPTIONS' => $s_categories, 
	'S_TIME_OPTIONS' => $s_time, 
	'S_SORT_OPTIONS' => $s_sort_by,
	'S_HIDDEN_FIELDS' => '')
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>