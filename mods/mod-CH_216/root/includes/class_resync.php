<?php
//
//	file: includes/class_resync.php
//	author: ptirhiik
//	begin: 02/02/2007
//	version: 1.6.5 - 30/05/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class resync extends plug_ins
{
	function forums($forum_id=false, $with_childs=false)
	{
		global $db, $config, $forums;

		$all_forums = false;
		$forum_ids = false;
		if ( !$forum_id )
		{
			$all_forums = $with_childs;
		}
		else if ( is_array($forum_id) )
		{
			$count_forum_id = count($forum_id);
			$forum_ids = array();
			for ( $i = 0; $i < $count_forum_id; $i++ )
			{
				if ( isset($forums->data[ $forum_id[$i] ]) )
				{
					$forum_ids[] = $forum_id[$i];
				}
			}
			if ( empty($forum_ids) )
			{
				return false;
			}
			if ( count($forum_ids) == 1 )
			{
				$forum_ids = $forum_ids[0];
			}
		}
		else
		{
			if ( !isset($forums->data[$forum_id]) )
			{
				return false;
			}
			if ( !$with_childs || ($forums->data[$forum_id]['last_child_id'] == $forum_id) )
			{
				$forum_ids = $forum_id;
			}
			else
			{
				// get min and max index
				$tkeys = array_flip($forums->keys);
				$max = $tkeys[ $forums->data[$forum_id]['last_child_id'] ];
				$min = $tkeys[$forum_id];
				unset($tkeys);

				for ( $i = $min; $i <= $max; $i++ )
				{
					$forum_ids[] = $forums->keys[$i];
				}
				if ( empty($forum_ids) )
				{
					return false;
				}
				if ( count($forum_ids) == 1 )
				{
					$forum_ids = $forum_ids[0];
				}
			}
		}

		// ok, something to process
		if ( $all_forums || $forum_ids )
		{
			// get counts
			$last_posts = array();
			$one_forum = !$all_forums && !is_array($forum_ids);
			$l_forums = $one_forum ? array($forum_ids => 0) : ($all_forums ? array_flip($forums->keys) : array_flip($forum_ids));

			// count topics
			$sql = 'SELECT ' . ($one_forum ? '' : 'forum_id, ') . 'COUNT(topic_id) AS count_topic_id
						FROM ' . TOPICS_TABLE . ($all_forums ? '' : '
						WHERE ' . ($one_forum ? 'forum_id = ' . intval($forum_ids) : 'forum_id IN(' . implode(', ', $forum_ids) . ')')) . ($one_forum ? '' : '
						GROUP BY forum_id');
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$id = $one_forum ? intval($forum_ids) : intval($row['forum_id']);
				if ( !isset($l_forums[$id]) || !is_array($l_forums[$id]) )
				{
					$l_forums[$id] = array();
				}
				$l_forums[$id]['forum_topics'] = intval($row['count_topic_id']);
			}
			$db->sql_freeresult($result);

			// count posts
			$sql = 'SELECT ' . ($one_forum ? '' : 'forum_id, ') . 'COUNT(post_id) AS count_post_id, MAX(post_id) AS max_post_id
						FROM ' . POSTS_TABLE . ($all_forums ? '' : '
						WHERE ' . ($one_forum ? 'forum_id = ' . intval($forum_ids) : 'forum_id IN(' . implode(', ', $forum_ids) . ')')) . ($one_forum ? '' : '
						GROUP BY forum_id');
			if ( !$one_forum )
			{
				unset($forum_ids);
			}
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$id = $one_forum ? intval($forum_ids) : intval($row['forum_id']);
				if ( !isset($l_forums[$id]) || !is_array($l_forums[$id]) )
				{
					$l_forums[$id] = array();
				}
				$l_forums[$id]['forum_posts'] = intval($row['count_post_id']);
				$last_posts[] = intval($row['max_post_id']);
			}
			$db->sql_freeresult($result);

			// read last posts
			if ( $last_posts )
			{
				$sql = 'SELECT t.forum_id, t.topic_last_post_id, t.topic_title, t.topic_last_poster, t.topic_last_username, t.topic_last_time, u.username
							FROM ' . TOPICS_TABLE . ' t
								LEFT JOIN ' . USERS_TABLE . ' u
									ON u.user_id = t.topic_last_poster
							WHERE t.topic_moved_id = 0
								AND t.topic_last_post_id IN(' . implode(', ', $last_posts) . ')';
				unset($last_posts);
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$id = intval($row['forum_id']);
					if ( !isset($l_forums[$id]) || !is_array($l_forums[$id]) )
					{
						$l_forums[$id] = array();
					}
					$l_forums[$id]['forum_last_post_id'] = intval($row['topic_last_post_id']);
					$l_forums[$id]['forum_last_title'] = $row['topic_title'];
					$l_forums[$id]['forum_last_poster'] = intval($row['topic_last_poster']);
					$l_forums[$id]['forum_last_username'] = ($row['topic_last_poster'] != ANONYMOUS) && !empty($row['username']) ? $row['username'] : $row['topic_last_username'];
					$l_forums[$id]['forum_last_time'] = intval($row['topic_last_time']);
				}
				$db->sql_freeresult($result);
			}

			// time to update
			if ( $l_forums && ($forum_ids = array_keys($l_forums)) && ($count_forum_ids = count($forum_ids)) )
			{
				$dft_fields = array(
					'forum_topics' => 0,
					'forum_posts' => 0,
					'forum_last_post_id' => 0,
					'forum_last_title' => '',
					'forum_last_poster' => 0,
					'forum_last_username' => '',
					'forum_last_time' => 0,
				);
				for ( $i = 0; $i < $count_forum_ids; $i++ )
				{
					$fields = !is_array($l_forums[ $forum_ids[$i] ]) ? $dft_fields : array_merge($dft_fields, $l_forums[ $forum_ids[$i] ]);
					$sql = 'UPDATE ' . FORUMS_TABLE . '
								SET ' . $db->sql_fields('update', $fields) . '
								WHERE forum_id = ' . intval($forum_ids[$i]);
					$db->sql_query($sql, false, __LINE__, __FILE__);
					unset($l_forums[ $forum_ids[$i] ]);
				}
				unset($forum_ids);

				// we will so recompute the total stats
				$all_forums = false;
				$forum_id = false;
			}
			unset($l_forums);
		}

		// total stats
		if ( !$all_forums && !$forum_id )
		{
			// count topics
			$sql = 'SELECT COUNT(topic_id) AS count_topic_id
						FROM ' . TOPICS_TABLE;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$total_topics = ($row = $db->sql_fetchrow($result)) ? intval($row['count_topic_id']) : 0;
			$db->sql_freeresult($result);

			// count posts
			$sql = 'SELECT COUNT(post_id) AS count_post_id
						FROM ' . POSTS_TABLE;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$total_posts = ($row = $db->sql_fetchrow($result)) ? intval($row['count_post_id']) : 0;
			$db->sql_freeresult($result);

			$config->begin_transaction();
			$config->set('stat_total_topics', $total_topics);
			$config->set('stat_total_posts', $total_posts);
			$config->end_transaction();
		}
	}

	function topics($topic_id)
	{
		global $config, $db;

		// plugs
		$this->load('class_resync.resync');
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( method_exists($this->plug_ins[$plug], 'sync') )
				{
					$this->plug_ins[$plug]->sync($topic_id);
				}
			}
		}

		// prepare return : we don't touch first post data unless a first post exists because of shadow topics
		$topic_ids = array();
		$post_ids = array();
		$sql = 'SELECT ' . (!is_array($topic_id) ? '' : 'topic_id, ') . 'MAX(post_id) AS topic_last_post_id, MIN(post_id) AS topic_first_post_id, COUNT(post_id) AS topic_replies
					FROM ' . POSTS_TABLE . '
					WHERE ' . (!is_array($topic_id) ? 'topic_id = ' . intval($topic_id) : 'topic_id IN(' . implode(', ', $topic_id) . ')
					GROUP BY topic_id');
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$id = !is_array($topic_id) ? $topic_id : intval($row['topic_id']);
			if ( intval($row['topic_replies']) )
			{
				$row['topic_replies']--;
				if ( isset($row['topic_id']) )
				{
					unset($row['topic_id']);
				}
				$topic_ids[$id] = $row;
				if ( intval($row['topic_first_post_id']) )
				{
					$post_ids[] = intval($row['topic_first_post_id']);
				}
				if ( intval($row['topic_last_post_id']) )
				{
					$post_ids[] = intval($row['topic_last_post_id']);
				}
			}
		}
		$db->sql_freeresult($result);
		if ( $topic_ids )
		{
			// get first & last posts info
			if ( $post_ids )
			{
				$sql = 'SELECT topic_id, post_id, poster_id, post_username, post_time
							FROM ' . POSTS_TABLE . '
							WHERE post_id IN(' . implode(', ', $post_ids) . ')';
				unset($post_ids);
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$id = intval($row['topic_id']);
					$post_id = intval($row['post_id']);
					if ( $post_id == intval($topic_ids[$id]['topic_first_post_id']) )
					{
						$topic_ids[$id]['topic_poster'] = intval($row['poster_id']);
						$topic_ids[$id]['topic_first_username'] = $row['post_username'];
						$topic_ids[$id]['topic_time'] = intval($row['post_time']);
					}
					if ( $post_id == intval($topic_ids[$id]['topic_last_post_id']) )
					{
						$topic_ids[$id]['topic_last_poster'] = intval($row['poster_id']);
						$topic_ids[$id]['topic_last_username'] = $row['post_username'];
						$topic_ids[$id]['topic_last_time'] = intval($row['post_time']);
					}
				}
				$db->sql_freeresult($result);
			}

			// and finaly update the topic
			$dft_fields = array(
				'topic_replies' => 0,
				'topic_first_post_id' => 0,
				'topic_last_post_id' => 0,
				'topic_last_poster' => 0,
				'topic_last_username' => '',
				'topic_last_time' => 0,
			);
			$ids = array_keys($topic_ids);
			$count_ids = count($ids);
			for ( $i = 0; $i < $count_ids; $i++ )
			{
				$fields = array_merge($dft_fields, $topic_ids[ $ids[$i] ]);
				$sql = 'UPDATE ' . TOPICS_TABLE . '
							SET ' . $db->sql_fields('update', $fields) . '
							WHERE topic_id = ' . intval($ids[$i]);
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($topic_ids[$i]);
			}
			unset($ids);
		}

		// all topics asked should have now a last_post_id, so delete the others
		$sql = 'DELETE FROM ' . TOPICS_TABLE . '
					WHERE topic_moved_id = 0
						AND topic_last_post_id = 0
						AND ' . (!is_array($topic_id) ? 'topic_id = ' . intval($topic_id) : 'topic_id IN(' . implode(', ', $topic_id) . ')');
		$db->sql_query($sql, false, __LINE__, __FILE__);
		return true;
	}
}

class prune extends plug_ins
{
	function forums_auto($forum_id)
	{
		global $db, $forums;

		if ( !$forum_id || !isset($forums->data[$forum_id]) )
		{
			return false;
		}
		$now = time();
		$sql = 'SELECT *
					FROM ' . PRUNE_TABLE . '
					WHERE forum_id = ' . intval($forum_id);
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		if ( !$row || !isset($row['prune_freq']) || !intval($row['prune_freq']) || !isset($row['prune_days']) || !intval($row['prune_days']) )
		{
			return false;
		}

		$this->forums($forum_id, $now - ($row['prune_days'] * 86400));
		$resync = new resync();
		$resync->forums($forum_id);
		unset($resync);

		$fields = array(
			'prune_next' => $now + ($row['prune_freq'] * 86400),
		);
		$sql = 'UPDATE ' . FORUMS_TABLE . '
					SET ' . $db->sql_fields('update', $fields) . '
					WHERE forum_id = ' . intval($forum_id);
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	function forums($forum_id, $prune_date=false)
	{
		global $db, $config;

		if ( !$forum_id )
		{
			return false;
		}

		// chunck in $rows_a_turn number of words to spare our memory
		// this won't prevent a timeout on large prune, but should avoid memory overflow
		$rows_a_turn = 300;

		// check for inconsistant topics
		$more = true;
		$resync = false;
		while ( $more )
		{
			$topic_ids = array();
			$sql = 'SELECT topic_id
						FROM ' . TOPICS_TABLE . '
						WHERE topic_moved_id = 0
							AND topic_last_post_id = 0' . (!is_array($forum_id) ? '
							AND forum_id = ' . intval($forum_id) : '
							AND forum_id IN(' . implode(', ', $forum_id) . ')') . '
						LIMIT ' . ($rows_a_turn + 1);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$topic_ids[] = intval($row['topic_id']);
			}
			$db->sql_freeresult($result);
			if ( ($more = count($topic_ids) > $rows_a_turn) )
			{
				unset($topic_ids[$rows_a_turn]);
			}
			if ( $topic_ids )
			{
				if ( $resync === false )
				{
					$resync = new resync();
				}
				$resync->topics($topic_ids);
			}
			unset($topic_ids);
		}
		if ( $resync !== false )
		{
			unset($resync);
		}

		// now process the prune
		$first = true;
		$more = true;
		$pruned_topics = 0;
		$pruned_posts = 0;
		while ( $more )
		{
			// get impacted topic ids
			$topic_ids = array();
			$sql = 'SELECT topic_id
						FROM ' . TOPICS_TABLE . '
						WHERE ' . (!is_array($forum_id) ? 'forum_id = ' . intval($forum_id) : 'forum_id IN(' . implode(', ', $forum_id) . ')') . (!$prune_date ? '' : '
							AND topic_vote = 0
							AND topic_type NOT IN(' . POST_ANNOUNCE . ', ' . POST_GLOBAL_ANNOUNCE . ')
							AND topic_last_time < ' . intval($prune_date) . '
							AND topic_time < ' . intval($prune_date)) . '
							LIMIT ' . ($rows_a_turn + 1);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$topic_ids[] = intval($row['topic_id']);
			}
			$db->sql_freeresult($result);
			if ( ($more = count($topic_ids) > $rows_a_turn) )
			{
				unset($topic_ids[$rows_a_turn]);
			}
			if ( $topic_ids )
			{
				// plug-ins
				if ( $first && !($first = false) )
				{
					$this->load('class_resync.prune');
				}
				if ( $this->plug_ins )
				{
					foreach ( $this->plug_ins as $plug => $dummy )
					{
						if ( method_exists($this->plug_ins[$plug], 'remove_topics') )
						{
							$this->plug_ins[$plug]->remove_topics($topic_ids);
						}
					}
				}

				// process the deletes
				if ( !$config->data['fulltext_search'] )
				{
					$this->words_topics($topic_ids);
				}

				$sql = 'DELETE FROM ' . POSTS_TEXT_TABLE . '
							WHERE post_id IN (' . $db->sql_subquery('post_id', '
								SELECT DISTINCT post_id
									FROM ' . POSTS_TABLE . '
									WHERE topic_id IN (' . implode(', ', $topic_ids) . ')
								', __LINE__, __FILE__) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);

				$sql = 'DELETE FROM ' . POSTS_TABLE . '
							WHERE topic_id IN (' . implode(', ', $topic_ids) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
				$pruned_posts += $db->sql_affectedrows();

				$sql = 'DELETE FROM ' . TOPICS_TABLE . '
							WHERE topic_id IN (' . implode(', ', $topic_ids) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
				$pruned_topics += $db->sql_affectedrows();

				$sql = 'DELETE FROM ' . TOPICS_TABLE . '
							WHERE topic_moved_id IN (' . implode(', ', $topic_ids) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
				$pruned_topics += $db->sql_affectedrows();

				$sql = 'DELETE FROM ' . TOPICS_WATCH_TABLE . '
							WHERE topic_id IN (' . implode(', ', $topic_ids) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);

				$sql = 'DELETE FROM ' . VOTE_USERS_TABLE . '
							WHERE vote_id IN (' . $db->sql_subquery('vote_id', '
								SELECT vote_id
									FROM ' . VOTE_DESC_TABLE . '
									WHERE topic_id IN (' . implode(', ', $topic_ids) . ')
							', __LINE__, __FILE__) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);

				$sql = 'DELETE FROM ' . VOTE_RESULTS_TABLE . '
							WHERE vote_id IN (' . $db->sql_subquery('vote_id', '
								SELECT vote_id
									FROM ' . VOTE_DESC_TABLE . '
									WHERE topic_id IN (' . implode(', ', $topic_ids) . ')
							', __LINE__, __FILE__) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);

				$sql = 'DELETE FROM ' . VOTE_DESC_TABLE . '
							WHERE topic_id IN (' . implode(', ', $topic_ids) . ')';
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
			}
		}
		return array('topics' => $pruned_topics, 'posts' => $pruned_posts);
	}

	function words_topics(&$ids)
	{
		global $db;

		if ( !$ids )
		{
			return 0;
		}

		$words_removed = 0;

		// chunck in $rows_a_turn number of words to spare our memory
		// this won't prevent a timeout on large prune, but should avoid memory overflow
		$rows_a_turn = 300;
		$more = true;
		while ( $more )
		{
			// get word ids matching
			$word_ids = array();
			$sql = 'SELECT w.word_id
						FROM ' . SEARCH_MATCH_TABLE . ' w, ' . POSTS_TABLE . ' p
						WHERE ' . (!is_array($ids) ? 'p.topic_id = ' . intval($ids) : 'p.topic_id IN(' . implode(', ', $ids) . ')') . '
							AND w.post_id = p.post_id
						GROUP BY word_id
						LIMIT ' . ($rows_a_turn + 1);
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$word_ids[] = intval($row['word_id']);
			}
			$db->sql_freeresult($result);
			if ( ($more = count($word_ids) > $rows_a_turn) )
			{
				unset($word_ids[ $rows_a_turn ]);
			}
			if ( $word_ids )
			{
				// delete matches
				$sql = 'DELETE FROM ' . SEARCH_MATCH_TABLE . '
							WHERE post_id IN (' . $db->sql_subquery('post_id', '
								SELECT post_id
									FROM ' . POSTS_TABLE . '
									WHERE topic_id IN(' . implode(', ', $ids) . ')
							', __LINE__, __FILE__) . ')' . (!$more ? '' : '
							AND word_id IN(' . implode(', ', $word_ids) . ')');
				$db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);

				// get & delete unlinked words
				$sql = 'SELECT w.word_id
							FROM ' . SEARCH_WORD_TABLE . ' w
								LEFT JOIN ' . SEARCH_MATCH_TABLE . ' m
									ON m.word_id = w.word_id
							WHERE m.word_id IS NULL
								AND w.word_id IN(' . implode(', ', $word_ids) . ')';
				$word_ids = array();
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				unset($sql);
				while ( $row = $db->sql_fetchrow($result) )
				{
					$word_ids[] = intval($row['word_id']);
				}
				$db->sql_freeresult($result);
				if ( $word_ids )
				{
					$sql = 'DELETE FROM ' . SEARCH_WORD_TABLE . '
								WHERE word_id IN(' . implode(', ', $word_ids) . ')';
					unset($word_ids);
					$db->sql_query($sql, false, __LINE__, __FILE__);
					unset($sql);
					$words_removed += $db->sql_affectedrows();
				}
			}
		}
		return $words_removed;
	}

	function words_posts(&$ids, $in_transaction=false)
	{
		global $db;

		if ( !$ids )
		{
			return 0;
		}

		$words_removed = 0;

		// chunck in $rows_a_turn number of words to spare our memory
		// this won't prevent a timeout on large prune, but should avoid memory overflow
		$rows_a_turn = 300;
		$more = true;
		while ( $more )
		{
			// get word ids matching
			$word_ids = array();
			$sql = 'SELECT word_id
						FROM ' . SEARCH_MATCH_TABLE . '
						WHERE ' . (!is_array($ids) ? 'post_id = ' . intval($ids) : 'post_id IN(' . implode(', ', $ids) . ')') . '
						GROUP BY word_id' . ($in_transaction ? '' : '
						LIMIT ' . ($rows_a_turn + 1));
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			unset($sql);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$word_ids[] = intval($row['word_id']);
			}
			$db->sql_freeresult($result);
			if ( ($more = !$in_transaction && (count($word_ids) > $rows_a_turn)) )
			{
				unset($word_ids[$rows_a_turn]);
			}
			if ( $word_ids )
			{
				if ( $in_transaction )
				{
					// delete words belonging only to these posts
					$sql = 'DELETE FROM ' . SEARCH_WORD_TABLE . '
								WHERE word_id IN(' . implode(', ', $word_ids) . ')
									AND word_id NOT IN(' . $db->sql_subquery('word_id', '
										SELECT DISTINCT word_id
											FROM ' . SEARCH_MATCH_TABLE . '
											WHERE ' . (!is_array($ids) ? 'post_id <> ' . intval($ids) : 'post_id NOT IN(' . implode(', ', $ids) . ')') . '
												AND word_id IN(' . implode(', ', $word_ids) . ')
										', __LINE__, __FILE__) . ')';
					$result = $db->sql_query($sql, false, __LINE__, __FILE__);
					unset($sql);
					$words_removed += $db->sql_affectedrows();

					// delete matches
					$sql = 'DELETE FROM ' . SEARCH_MATCH_TABLE . '
								WHERE ' . (!is_array($ids) ? 'post_id = ' . intval($ids) : 'post_id IN(' . implode(', ', $ids) . ')') . (!$more ? '' : '
								AND word_id IN(' . implode(', ', $word_ids) . ')');
					unset($word_ids);
					$db->sql_query($sql, false, __LINE__, __FILE__);
					unset($sql);
				}
				else
				{
					// delete matches
					$sql = 'DELETE FROM ' . SEARCH_MATCH_TABLE . '
								WHERE ' . (!is_array($ids) ? 'post_id = ' . intval($ids) : 'post_id IN(' . implode(', ', $ids) . ')') . (!$more ? '' : '
								AND word_id IN(' . implode(', ', $word_ids) . ')');
					$db->sql_query($sql, false, __LINE__, __FILE__);
					unset($sql);

					// delete words belonging only to these posts
					$sql = 'DELETE FROM ' . SEARCH_WORD_TABLE . '
								WHERE word_id IN(' . implode(', ', $word_ids) . ')
									AND word_id NOT IN(' . $db->sql_subquery('word_id', '
										SELECT DISTINCT word_id
											FROM ' . SEARCH_MATCH_TABLE . '
											WHERE word_id IN(' . implode(', ', $word_ids) . ')
										', __LINE__, __FILE__) . ')';
					unset($word_ids);
					$db->sql_query($sql, false, __LINE__, __FILE__);
					unset($sql);
					$words_removed += $db->sql_affectedrows();
				}
			}
		}
		return $words_removed;
	}
}

?>