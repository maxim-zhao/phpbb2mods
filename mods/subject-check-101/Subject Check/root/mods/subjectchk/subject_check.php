<?php
/*-----------------------------------------------------------------------------
    Subject Check - A phpBB Add-On
  ----------------------------------------------------------------------------
    subject_check.php
       Main Class File
    File Version: 1.0.1
    Begun: November 3, 2006                 Last Modified: July 27, 2007
  ----------------------------------------------------------------------------
    Copyright 2006 by Jeremy Rogers.  Please read the license.txt included
    with the phpBB Add-On listed above for full license and copyright details.
  ----------------------------------------------------------------------------
    Class and Function Quick Reference
             Names                                 Search Labels
         SubjectCheck................................[sccls]
            SubjectCheck.............................[sccon]
            look_for_posts...........................[lfp]
            add_bypass...............................[abp]
-----------------------------------------------------------------------------*/

if( !defined('IN_PHPBB') )
{
	die('You got no mojo.');
}

require_once($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_subchk.' . $phpEx);
$subject_check = new SubjectCheck();

/*	SubjectCheck                                            [sccls]
       _Insert_Descripton_Here_
                                                                             */
class SubjectCheck 
{
	var $allow_bypass	= FALSE;
	var $bypass_value	= FALSE;
	var $cfg			= array();
	var $error;
	var $error_list;

/*	SubjectCheck                                            [sccon]
       Construction function, gets modification configuration settings.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function SubjectCheck()
	{
		global $board_config;
		$this->cfg['min_chars']		= $board_config['search_min_chars'];
		$this->cfg['lang']			= $board_config['default_lang'];
		$this->cfg['enable']		= $board_config['subchk_enable'];
		$this->cfg['enable_bypass']	= $board_config['subchk_bypass'];
		$this->cfg['enable_strict']	= $board_config['subchk_strict'];
		$this->cfg['check_locked']	= $board_config['subchk_locked'];
		$this->cfg['admin']			= $board_config['subchk_admin'];
		$this->cfg['mod']			= $board_config['subchk_mod'];
		$this->cfg['limit']			= intval($board_config['subchk_limit']);
		$this->cfg['postcount']		= intval($board_config['subchk_postcount']);

		$this->error = $this->error_list = '';
	}

/*	look_for_posts                                          [lfp]
       Checks for posts with a subject similar to those already
	   existing in the forum.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function look_for_posts()
	{
		global $db, $forum_id, $post_info, $HTTP_POST_VARS, $userdata;
		global $phpbb_root_path, $phpEx, $lang, $error_msg, $mode, $subject;

		$bypass = ( isset($HTTP_POST_VARS['bypass']) ) ? htmlspecialchars(stripslashes(trim($HTTP_POST_VARS['bypass']))) : FALSE;

		// Check all the different things that could mean a check for
		// existing threads isn't necessary.
		if( !$this->cfg['enable'] ||
			!$post_info['forum_subject_check'] ||
			$mode != 'newtopic' ||
			empty($subject) ||
			($this->cfg['admin'] && $userdata['user_level'] == ADMIN) ||
			($this->cfg['mod'] && $userdata['user_level'] == MOD) ||
			(!empty($this->cfg['postcount']) && $userdata['user_posts'] > $this->cfg['postcount']) ||
			($bypass == stripslashes($subject) && $this->cfg['enable_bypass'])
		)
		{
			return;
		}

		include_once($phpbb_root_path . 'includes/functions_search.' . $phpEx);
		// Get searchable words from the post subject
		$stopword_array = @file($phpbb_root_path . 'language/lang_' . $this->cfg['lang'] . '/search_stopwords.txt'); 
		$synonym_array = @file($phpbb_root_path . 'language/lang_' . $this->cfg['lang'] . '/search_synonyms.txt'); 
		$stripped_keywords = stripslashes($subject);
		$split_search = split_words(clean_words('search', $stripped_keywords, $stopword_array, $synonym_array), 'search');	
		unset($stripped_keywords, $stopword_array, $synonym_array);

		// Now search for existing topics with subjects containing those words
		$topics = $result_list = array();
		$split_count = count($split_search);
		for($i = 0; $i < $split_count; $i++)
		{
			$split_search[$i] = trim($split_search[$i]);
			if ( strlen($split_search[$i]) < $this->cfg['min_chars'] )
			{
				$split_search[$i] = '';
				continue;
			}
			$sql = "SELECT DISTINCT(t.topic_id)
				FROM " . SEARCH_WORD_TABLE . " w, " . SEARCH_MATCH_TABLE . " m, " . TOPICS_TABLE . " t
				WHERE w.word_text = '" . str_replace("'", "''", $split_search[$i]) . "'
					AND m.word_id = w.word_id
					AND w.word_common <> 1
					AND m.title_match = 1
					AND m.post_id = t.topic_first_post_id
					AND t.forum_id = $forum_id";
			if( $this->cfg['check_locked'] )
			{
				$sql .= ' AND t.topic_status <> ' . TOPIC_LOCKED;
			}

			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not retrieve word matches', '', __LINE__, __FILE__, $sql);
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				$result_list[] = intval($row['topic_id']);
			}
			$db->sql_freeresult();
		}

		if( !empty($result_list) )
		{
			// Found some matches, now display message
			$sql = 'SELECT topic_id, topic_title FROM ' . TOPICS_TABLE . ' WHERE topic_id IN (' . implode(', ', $result_list) . ')';
			if( $this->cfg['limit'] )
			{
				$sql .= ' LIMIT 0,' . $this->cfg['limit'];
			}
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not retrieve topic matches', '', __LINE__, __FILE__, $sql);
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				$topics[$row['topic_id']] = $row['topic_title'];
			}
			$db->sql_freeresult();
			if( !empty($topics) )
			{
				$this->allow_bypass = TRUE;
				$this->bypass_value = $subject;
				$this->error = $lang['SUBCHK_UNSTRICT'];
				foreach($topics as $k=>$v)
				{
					// If strict mode is on, don't allow the post to be made
					if( $v == $subject && $this->cfg['enable_strict'] )
					{
						$this->error = $lang['SUBCHK_STRICT'];
						$this->allow_bypass = FALSE;
					}
					$this->error_list .= '<a href="' . append_sid('viewtopic.' . $phpEx . '?' . POST_TOPIC_URL . '=' . $k) . '">' . $v . '</a><br />';
				}
			}
		}
		if( !empty($this->error) )
		{
			$error_msg .= ( !empty($error_msg) ) ? '<br /><br />' : '';
			$error_msg .= $this->error . '<br />' . $this->error_list;
		}
	}

/*	add_bypass                                              [abp]
       Adds a bypass flag to the posting form, to allow users to
	   post their message after being given a list of existing posts.

    Arguments:
       None.

    Return:
       None.
                                                                             */
	function add_bypass()
	{
		if( $this->allow_bypass && $this->cfg['enable_bypass'] && !empty($this->bypass_value))
		{
			global $hidden_form_fields;
			$hidden_form_fields .= '<input type="hidden" name="bypass" value="' . $this->bypass_value . '" />';
		}
	}
}

?>