<?php
/***************************************************************************
 *                            class_calendar_topics_parse.php
 *                            -------------------------------
 *	begin			: 04/05/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 1.0.1 - 03/06/2006
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('LOWER_ID', -100);

include_once($config->url('includes/bbcode'));
include_once($config->url('includes/functions_post'));

// reverse what htmlspecialchars does, plus replace <br /> with \n
function _un_htmlspecialchars($str)
{
	static $rev_html_translation_table;

	if ( empty($rev_html_translation_table) )
	{
		$rev_html_translation_table = function_exists('get_html_translation_table') ? array_flip(get_html_translation_table(HTML_ENTITIES)) : array('&amp;' => '&', '&#039;' => '\'', '&quot;' => '"', '&lt;' => '<', '&gt;' => '>');
	}
	return strtr(str_replace('<br />', "\n", $str), $rev_html_translation_table);
}

function _html_mask(&$text, &$html, &$seed)
{
	// remove html & comments from the text
	$mask = '#(<[^>!]*>)|(<!--[\s\r\n\t]?.*[\s\n\r\t]?-->)#s';
	preg_match_all($mask, $text, $matches);
	$html = $matches[0];
	$seed = '';

	// replace them with a mark
	if ( !empty($html) )
	{
		$seed = '{' . substr(md5(mt_rand()), 0, HTML_UID_LEN) . '}';
		$text = preg_replace($mask, $seed, $text);
	}
}

function _html_unmask(&$text, &$html, &$seed)
{
	if ( empty($html) || empty($seed) )
	{
		return;
	}
	@reset($html);
	$mask = '#(' . preg_quote($seed) . ')#s';
	preg_match_all($mask, $text, $blocks);
	$text_blocks = preg_split($mask, $text);
	$count_text_blocks = count($text_blocks);
	$text = '';
	for ( $i = 0; $i < $count_text_blocks; $i++ )
	{
		$text .= $text_blocks[$i];
		if ( $blocks[1][$i] == $seed )
		{
			$html_block = '';
			list(, $html_blocks) = @each($html);
			$text .= $html_blocks;
		}
	}
	$html = '';
	$seed = '';
}

function _censor($str)
{
	static $orig_word, $replacement_word, $done;
	if ( !$done )
	{
		$orig_word = $replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);
	}
	return count($orig_word) ? preg_replace($orig_word, $replacement_word, $str) : $str;
}

// borrowed from function_search : quickly remove BBcode.
function _clean_bbcode($str)
{
	$str = preg_replace('/\[img:[a-z0-9]{10,}\].*?\[\/img:[a-z0-9]{10,}\]/', ' ', $str);
	$str = preg_replace('/\[\/?url(=.*?)?\]/', ' ', $str);
	$str = preg_replace('/\[\/?[a-z\*=\+\-]+(\:?[0-9a-z]+)?:[a-z0-9]{10,}(\:[a-z0-9]+)?=?.*?\]/', ' ', $str);
	return $str;
}

function _clean_html($str)
{
	return htmlspecialchars(_un_htmlspecialchars(ereg_replace('<[^>]+>', '', str_replace('<br />', "\n", $str))));
}

class calendar_message
{
	function get_options()
	{
		global $config;

		return array(
			'html' => $config->data['allow_html'],
			'bbcode' => $config->data['allow_bbcode'],
			'smilies' => $config->data['allow_smilies'],
			'magic_url' => !isset($config->data['allow_magic_url']) || $config->data['allow_magicurl'],
			'censor' => !isset($config->data['allow_censor']) || $config->data['allow_censor'],
		);
	}

	function mparse(&$message, $bbcode_uid='', $switches='')
	{
		global $config, $user;

		// phpbb vars
		global $board_config, $html_entities_match, $html_entities_replace; // prepare_message()
		global $unhtml_specialchars_match, $unhtml_specialchars_replace; // unprepare_message()
		global $template; // load_bbcode_template()
		global $lang; // prepare_bbcode_template(), bbencode_second_pass_code()
		global $bbcode_tpl; // bbencode_second_pass()

		if ( empty($message) )
		{
			return;
		}

		$options = $this->get_options();
		foreach ( $options as $var => $dft )
		{
			$$var = $dft && (empty($switches) || !isset($switches[$var]) || $switches[$var]);
		}
		unset($options);

		// If the board has HTML off but the post has HTML on then we process it, else leave it alone
		if ( $html && !$user->data['user_allowhtml'] )
		{
			$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		}

		// Parse message for BBCode if reqd
		if ( $bbcode && $bbcode_uid && (!isset($user->data['user_allowbbcode']) || $user->data['user_allowbbcode']) )
		{
			$message = bbencode_second_pass($message, $bbcode_uid);
		}
		else if ( $bbcode_uid )
		{
			$message = preg_replace('/\:' . $bbcode_uid . '/si', '', $message);
		}

		// magic-url
		if ( $magic_url && (!isset($user->data['user_allowmagicurl']) || $user->data['user_allowmagicurl']) )
		{
			$message = make_clickable($message);
		}

		// Parse smilies
		if ( $smilies && (!isset($user->data['user_allowsmile']) || $user->data['user_allowsmile']) )
		{
			$message = smilies_pass($message);
		}

		// censor
		$do_censor = $censor && (!isset($user->data['user_allowcensor']) || $user->data['user_allowcensor']);
		if ( $do_censor )
		{
			$html_mask = '';
			$seed_mask = '';
			_html_mask($message, $html_mask, $seed_mask);
			$message = _censor($message);
			_html_unmask($message, $html_mask, $seed_mask);
		}

		// Replace newlines
		$message = str_replace("\n", "\n<br />\n", $message);
	}

	function shorten_message($message, &$bbcode_uid, &$switches, $max_chars)
	{
		// phpbb vars
		global $board_config, $html_entities_match, $html_entities_replace; // prepare_message()
		global $unhtml_specialchars_match, $unhtml_specialchars_replace; // unprepare_message()
		global $template; // load_bbcode_template()
		global $lang; // prepare_bbcode_template(), bbencode_second_pass_code()
		global $bbcode_tpl; // bbencode_second_pass()

		if ( $max_chars <= 0 )
		{
			return $message;
		}

		// remove html escape
		$message = unprepare_message($message);
		$message = str_replace('<br />', "\n", $message);

		// remove bbcode uid
		if ( !empty($bbcode_uid) )
		{
			$message = preg_replace('/\:(([a-z0-9]:)?)' . $bbcode_uid . '/s', '', $message);

			// replace img with url
			$message = str_replace(array('[img]', '[/img]'), array('[url]', '[/url]'), $message);
		}

		// short the message
		if ( strlen($message) + 3 > $max_chars )
		{
			$message = substr($message, 0, $max_chars) . '...';
		}

		// re-add bbCode
		return stripslashes(prepare_message(addslashes($message), $switches['html'], $switches['bbcode'], $switches['smilies'], $bbcode_uid));
	}

	function parse($row, $max_chars=0, $javascript=true)
	{
		$message = $row['post_text'];
		if ( $javascript )
		{
			$switches = array(
				'html' => $row['enable_html'],
				'bbcode' => $row['enable_bbcode'],
				'smilies' => $row['enable_smilies'],
				'magic_url' => isset($row['magic_url']) ? $row['magic_url'] : true,
				'censor' => isset($row['censor']) ? $row['censor'] : true,
			);
			$message = $this->shorten_message($message, $row['bbcode_uid'], $switches, $max_chars);
			$this->mparse($message, $row['bbcode_uid'], $switches);
		}
		else
		{
			$message = _clean_bbcode(_clean_html($message));
			if ( $max_chars && (strlen($message) > $max_chars + 3) )
			{
				$message = substr($row['post_text'], 0, $max_chars) . '...';
			}
			$message = _censor($message);

			// change \n into <br />
			$message = preg_replace("/[\n\r]{1,2}/", '<br />', $message);
		}
		return $message;
	}
}

class calendar_forums
{
	var $data;
	var $auth;

	function calendar_forums()
	{
		$this->data = array();
		$this->auth = array();
		$this->read();
	}

	function read()
	{
		global $db, $user;

		$sql = 'SELECT f.*, c.cat_title
					FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
					WHERE c.cat_id = f.cat_id
					ORDER BY cat_order, forum_order';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain forum informations', '', __LINE__, __FILE__, $sql);
		}
		$forum_data = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$forum_data[] = $row;
		}
		$db->sql_freeresult($result);

		// get auths
		$is_auth_ary = array();
		if ( $count_forum_data = count($forum_data) )
		{
			$is_auth_ary = auth(AUTH_ALL, AUTH_LIST_ALL, $user->data, $forum_data);
		}

		// get the final tree
		$this->data[POST_CAT_URL . 0] = array(
			'forum_type' => POST_CAT_URL,
			'forum_id' => 0,
			'forum_name' => 'Index',
			'forum_main' => '',
			'last_child_id' => '',
		);
		$this->auth[POST_CAT_URL . 0] = array(
			'auth_view' => true,
			'auth_read' => false,
			'auth_mod' => false,
		);
		if ( count($is_auth_ary) )
		{
			for ( $i = 0; $i < $count_forum_data; $i++ )
			{
				$forum_id = intval($forum_data[$i]['forum_id']);
				$cat_id = intval($forum_data[$i]['cat_id']);
				if ( $is_auth_ary[$forum_id]['auth_read'] || $is_auth_ary[$forum_id]['auth_mod'] )
				{
					if ( !isset($this->data[POST_CAT_URL . $cat_id]) )
					{
						$this->data[POST_CAT_URL . $cat_id] = array(
							'forum_type' => POST_CAT_URL,
							'forum_id' => $cat_id,
							'forum_name' => $forum_data[$i]['cat_title'],
							'forum_main' => POST_CAT_URL . 0,
							'last_child_id' => '',
						);
						$this->auth[POST_CAT_URL . $cat_id] = array(
							'auth_view' => false,
							'auth_read' => false,
							'auth_mod' => false,
						);
					}
					$this->data[POST_FORUM_URL . $forum_id] = array(
						'forum_type' => POST_FORUM_URL,
						'forum_id' => $forum_id,
						'forum_name' => $forum_data[$i]['forum_name'],
						'forum_main' => POST_CAT_URL . $cat_id,
						'last_child_id' => '',
					);
					$this->auth[POST_FORUM_URL . $forum_id] = array(
						'auth_view' => $is_auth_ary[$forum_id]['auth_view'] || $is_auth_ary[$forum_id]['auth_mod'],
						'auth_read' => $is_auth_ary[$forum_id]['auth_read'] || $is_auth_ary[$forum_id]['auth_mod'],
						'auth_mod' => $is_auth_ary[$forum_id]['auth_mod'],
					);
				}
			}
		}
		unset($is_auth_ary);
		unset($forum_data);

		$keys = array_keys($this->data);
		for ( $i = count($keys) - 1; $i >= 0; $i-- )
		{
			$forum_id = $keys[$i];
			if ( empty($this->data[$forum_id]['last_child_id']) )
			{
				$this->data[$forum_id]['last_child_id'] = $forum_id;
			}
			if ( !empty($this->data[$forum_id]['forum_main']) )
			{
				$main_id = $this->data[$forum_id]['forum_main'];
				if ( empty($this->data[$main_id]['last_child_id']) )
				{
					$this->data[$main_id]['last_child_id'] = $this->data[$forum_id]['last_child_id'];
				}
				$this->auth[$main_id]['auth_view'] |= $this->auth[$forum_id]['auth_view'] || $this->auth[$forum_id]['auth_mod'];
			}
		}
		unset($keys);
	}

	function retrieve_ids($forum_id='')
	{
		global $user;

		if ( empty($forum_id) )
		{
			$forum_id = POST_CAT_URL . '0';
		}
		if ( !isset($this->data[$forum_id]) )
		{
			return false;
		}

		$keys = array_keys($this->data);
		$tkeys = array_flip($keys);
		$from = $tkeys[$forum_id];
		$to = $tkeys[ $this->data[$forum_id]['last_child_id'] ];
		unset($tkeys);
		$forum_ids = array();
		for ( $i = $from; $i <= $to; $i++ )
		{
			if ( ($this->data[ $keys[$i] ]['forum_type'] == POST_FORUM_URL) && ($this->auth[ $keys[$i] ]['auth_read'] || $this->auth[ $keys[$i] ]['auth_mod']) )
			{
				$forum_ids[] = $this->data[ $keys[$i] ]['forum_id'];
			}
		}
		return empty($forum_ids) ? false : $forum_ids;
	}

	function display_nav($row, $tpl_switch)
	{
		global $template, $config, $user;

		$locs = array();
		$cur = intval($row['forum_id']) ? POST_FORUM_URL . intval($row['forum_id']) : POST_CAT_URL . '0';
		while ( $cur != POST_CAT_URL . '0' )
		{
			if ( !isset($this->data[$cur]) )
			{
				break;
			}
			if ( $this->auth[$cur]['auth_view'] || $this->auth[$cur]['auth_mod'] )
			{
				$locs[] = array(
					'txt' => $this->data[$cur]['forum_name'],
					'url' => $this->data[$cur]['forum_type'] == POST_CAT_URL ? 'index' : 'viewforum',
					'parms' => array($this->data[$cur]['forum_type'] => $this->data[$cur]['forum_id']),
				);
			}
			$cur = $this->data[$cur]['forum_main'];
		}

		for ( $i = count($locs) - 1; $i >= 0; $i-- )
		{
			$template->assign_block_vars($tpl_switch, array(
				'U_NAV' => $config->url($locs[$i]['url'], $locs[$i]['parms'], true),
				'NAV' => $locs[$i]['txt'],
			));
			$template->set_switch($tpl_switch . '.sep', $i > 0);
		}
	}

	function build_select($varname, &$options, &$value)
	{
		global $user;
		global $HTTP_GET_VARS, $HTTP_POST_VARS;

		$original_value = $value;
		$value = POST_CAT_URL . '0';

		// get option list
		$options = array();
		if ( !($front_pic = $this->get_front_pic()) )
		{
			return false;
		}
		foreach ( $front_pic as $cur_id => $front )
		{
			$option = '';
			$count_front = strlen($front);
			for ( $i = 0; $i < $count_front; $i++ )
			{
				$option .= $user->lang('tree_pic_' . $front[$i]);
			}
			if ( isset($this->data[$cur_id]) )
			{
				$option .= !intval($this->data[$cur_id]['forum_id']) ? $user->lang($this->data[$cur_id]['forum_name']) : $this->data[$cur_id]['forum_name'];
			}
			$options[$cur_id] = $option;
		}

		// current value
		$value = isset($HTTP_POST_VARS[$varname]) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS[$varname]))) : (isset($HTTP_GET_VARS[$varname]) ? htmlspecialchars(trim(stripslashes($HTTP_GET_VARS[$varname]))) : $original_value);
		if ( !isset($options[$value]) || !isset($this->data[$value]) )
		{
			$value = POST_CAT_URL . '0';
		}
		if ( $value == POST_CAT_URL . '0' )
		{
			$value = '';
		}
		return true;
	}

	function get_front_pic()
	{
		global $user;

		$keys = array_keys($this->data);
		$count_keys = count($keys);

		// last ids per branch & level
		$last_id = array();
		$main_ids = array();
		$level = array();
		for ( $i = 0; $i < $count_keys; $i++ )
		{
			$cur_id = $keys[$i];
			if ( $this->auth[$cur_id]['auth_view'] || $this->auth[$cur_id]['auth_mod'] )
			{
				$last_id[$cur_id] = $cur_id;
				$main_ids[$cur_id] = 0;
				$level[$cur_id] = 0;
				if ( $i > 0 )
				{
					$main_id = $this->data[$cur_id]['forum_main'];
					while ( !empty($main_id) && ($main_id != POST_CAT_URL . '0') && !isset($last_id[$main_id]) )
					{
						$main_id = $this->data[$main_id]['forum_main'];
					}
					$last_id[$main_id] = $cur_id;
					$main_ids[$cur_id] = $main_id;
					$level[$cur_id] = $level[$main_id] + 1;
				}
			}
		}

		// prepare return
		$front_pic = array();

		$close = array();
		$previous_level = 0;
		if ( !empty($last_id) )
		{
			foreach ( $last_id as $_id => $last_child_id )
			{
				$close[ $level[$_id] ] = ($_id == POST_CAT_URL . '0') || ($last_id[ $main_ids[$_id] ] == $_id);

				$linefeed = '';
				$option = '';
				for ( $i = 1; $i <= $level[$_id]; $i++ )
				{
					if ( $i == $level[$_id] )
					{
						$linefeed .= TREE_VSPACE;
						$option .= $close[$i] ? TREE_CLOSE : TREE_CROSS;
					}
					else
					{
						$linefeed .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
						$option .= $close[$i] ? TREE_HSPACE : TREE_VSPACE;
					}
				}
				if ( $previous_level > $level[$_id] )
				{
					$front_pic[ (LOWER_ID - count($front_pic)) ] = $linefeed;
				}
				$front_pic[$_id] = $option;
				$previous_level = $level[$_id];
			}
		}
		return $front_pic;
	}
}

?>