<?php
//
//	file: includes/class_message.php
//	author: ptirhiik
//	begin: 20/01/2006
//	version: 1.6.4 - 05/10/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class ranks
{
	var $data_time;
	var $from_cache;

	function read($force=false)
	{
		global $config;

		$db_cached = new cache('dta_ranks', $config->data['cache_path'], $config->data['cache_disabled_ranks']);
		$sql = 'SELECT *
					FROM ' . RANKS_TABLE . '
					ORDER BY rank_special, rank_min';
		$data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force);
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;

		return $data;
	}
}

class smilies_cache extends cache
{
	var $codes;

	function pre_process(&$rows)
	{
		parent::pre_process($rows);
		$this->codes = array();
	}

	function row_process(&$rows, $row_id)
	{
		parent::row_process($rows, $row_id);
		$this->codes[] = array('code' => $rows[$row_id]['code'], 'id' => $row_id);
	}

	function post_process(&$rows)
	{
		if ( !empty($rows) )
		{
			usort($this->codes, array(&$this, 'sort'));
			$rows[-1] = $this->codes;
			$this->codes = array();
		}
	}

	// sort by code length
	function sort($a, $b)
	{
		return strlen($a['code']) > strlen($b['code']) ? -1 : 1;
	}
}

class smilies
{
	var $data;
	var $data_time;
	var $from_cache;
	var $data_flag;
	var $match;
	var $parse_sort;

	function smilies()
	{
		$this->data = false;
		$this->data_time = false;
		$this->from_cache = false;
		$this->data_flag = false;
		$this->match = false;
		$this->parse_sort = false;
	}

	function read($force=false)
	{
		global $config;

		if ( !$force && $this->data_flag )
		{
			return $this->data;
		}
		$db_cached = new smilies_cache('dta_smilies', $config->data['cache_path'], $config->data['cache_disabled_smilies']);
		$sql = 'SELECT * 
					FROM ' . SMILIES_TABLE . '
					ORDER BY smilies_id';
		$this->data = $db_cached->sql_query($sql, __LINE__, __FILE__, $force);
		$this->data_flag = true;
		$this->data_time = $db_cached->data_time;
		$this->from_cache = $db_cached->from_cache;
		if ( $this->data && isset($this->data[-1]) )
		{
			$this->parse_sort = $this->data[-1];
			unset($this->data[-1]);
		}

		return $this->data;
	}

	function parse(&$message)
	{
		global $config, $template;

		$this->read();
		if ( $this->data && ($this->match === false) )
		{
			$this->match = array();
			$count_parse_sort = count($this->parse_sort);
			for ( $i = 0; $i < $count_parse_sort; $i++ )
			{
				$this->match[0][] = '/(?<=.\W|\W.|^\W|[\n ])' . preg_quote($this->parse_sort[$i]['code'], '/') . '(?=.\W|\W.|\W|[\n ]$)/';
				$this->match[1][] = '<img src="' . $template->img_styled_get($config->data['smilies_path'] . '/' . $this->data[ $this->parse_sort[$i]['id'] ]['smile_url']) . '" border="0" alt="' . $this->data[ $this->parse_sort[$i]['id'] ]['emoticon'] . '" />';
			}
		}
		return $this->data && $this->match ? substr(preg_replace($this->match[0], $this->match[1], ' ' . $message . ' '), 1, -1) : $message;
	}
}

class message
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

	function parse(&$message, $bbcode_uid='', $switches='', $highlight='', $max_chars=0)
	{
		global $config, $user, $smilies;

		if ( empty($message) )
		{
			return;
		}

		$options = $this->get_options();
		foreach ( $options as $key => $dft )
		{
			$options[$key] = $dft && (empty($switches) || !isset($switches[$key]) || $switches[$key]);
		}

		// get apis
		if ( !function_exists('prepare_message') )
		{
			include($config->url('includes/functions_post'));
		}
		if ( !function_exists('make_bbcode_uid') )
		{
			include($config->url('includes/bbcode'));
		}

		// process
		if ( intval($max_chars) > 0 )
		{
			// remove html escape
			$message = _html_entities_decode($message);

			// remove bbcode uid
			if ( !empty($bbcode_uid) )
			{
				$message = bbencode_decode($message, $bbcode_uid);

				// replace img with url
				$message = str_replace(array('[img]', '[/img]'), array('[url]', '[/url]'), $message);
			}

			// short the message
			if ( strlen($message) + 3 > $max_chars )
			{
				$message = substr($message, 0, $max_chars) . '...';
			}

			// re-add bbCode
			$message = stripslashes(prepare_message(addslashes($message), $switches['html'], $switches['bbcode'], $switches['smilies'], $bbcode_uid));
		}

		// If the board has HTML off but the post has HTML on then we process it, else leave it alone
		if ( $options['html'] && !$user->data['user_allowhtml'] )
		{
			$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		}

		// Parse message for BBCode if reqd
		if ( $options['bbcode'] && $bbcode_uid && (!isset($user->data['user_allowbbcode']) || $user->data['user_allowbbcode']) )
		{
			$message = bbencode_second_pass($message, $bbcode_uid, $options['magic_url'] && (!isset($user->data['user_allowmagicurl']) || $user->data['user_allowmagicurl']));
		}
		else if ( $bbcode_uid )
		{
			$message = bbencode_decode($message, $bbcode_uid);
		}

		// Parse smilies
		if ( $options['smilies'] && (!isset($user->data['user_allowsmile']) || $user->data['user_allowsmile']) )
		{
			if ( $smilies === false )
			{
				$smilies = new smilies();
			}
			$message = $smilies->parse($message);
		}

		// highlight/censor
		$do_censor = $options['censor'] && (!isset($user->data['user_allowcensor']) || $user->data['user_allowcensor']);
		if ( $highlight || $do_censor )
		{
			$html_mask = '';
			$seed_mask = '';
			_html_mask($message, $html_mask, $seed_mask);
			if ( $do_censor )
			{
				$message = _censor($message);
			}
			if ( $highlight )
			{
				$message = _highlight($message, $highlight);
			}
			_html_unmask($message, $html_mask, $seed_mask);
		}

		// Replace newlines for flat display
		$message = str_replace("\n", "\n<br />\n", $message);
	}
}

?>