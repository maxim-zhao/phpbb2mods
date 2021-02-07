<?php
//
//	file: includes/ucp/ucp_fields.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.4 - 26/07/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hack attempt');
}

//-----------
// functions
//-----------

// avatar panel
function get_view_user_avatar()
{
	global $config;
	global $view_user;

	$avatar_img = '';
	if ( !empty($view_user) && !empty($view_user->data) && ($view_user->data['user_id'] != ANONYMOUS) && !empty($view_user->data['user_avatar']) )
	{
		switch ( $view_user->data['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$avatar_img = ( $config->data['allow_avatar_upload'] ) ? $config->root . $config->data['avatar_path'] . '/' . $view_user->data['user_avatar'] : '';
				$avatar_img = @file_exists(phpbb_realpath($avatar_img)) ? $avatar_img : '';
				break;
			case USER_AVATAR_GALLERY:
				$avatar_img = ( $config->data['allow_avatar_local'] ) ? $config->root . $config->data['avatar_gallery_path'] . '/' . $view_user->data['user_avatar'] : '';
				$avatar_img = @file_exists(phpbb_realpath($avatar_img)) ? $avatar_img : '';
				break;
			case USER_AVATAR_REMOTE:
				$avatar_img = ( $config->data['allow_avatar_remote'] ) ? $view_user->data['user_avatar'] : '';
				break;
		}
	}
	return $avatar_img;
}

// email validation
function check_email($email)
{
	return empty($email) ? true : preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $email);
}

function birthday_parse($birthday)
{
	if ( empty($birthday) )
	{
		return false;
	}
	$fmt = defined('BIRTHDAY_FMT') ?  BIRTHDAY_FMT : 'ymd';
	$parsed = false;
	switch ( $fmt )
	{
		case 'ymd':
			$parsed['d'] = $birthday % 100;
			$birthday = intval($birthday / 100);
			$parsed['m'] = $birthday % 100;
			$parsed['m'] = intval($birthday / 100);
			break;
		case 'mdy':
			$parsed['m'] = intval($birthday / 1000000);
			$birthday = $birthday % 1000000;
			$parsed['d'] = intval($birthday / 10000);
			$parsed['y'] = $birthday % 10000;
			break;
		case 'dmy_sep':
			$tmp = explode('-', $birthday);
			$parsed = array(
				'd' => intval($tmp[0]),
				'm' => intval($tmp[1]),
				'y' => intval($tmp[2]),
			);
			break;
		default:
			break;
	}
	return $parsed;
}

//-------------
// field types
//-------------

class field_signature extends field_bbcode
{
	function init()
	{
		global $config;

		parent::init();
		$this->data['length_maxi'] = $config->data['max_sig_chars'];
	}

	function display_preview()
	{
		global $template, $config, $user;

		$template->assign_block_vars('previewsig', array(
			'L_TITLE' => $user->lang('Preview'),
			'SIGNATURE' => $this->parse($this->value),
		));
		$template->assign_block_vars('cp_content', array('BOX' => $template->include_file('ucp/ucp_previewsig_box.tpl', array('preview_box'))));
	}
}

class field_sig_comment extends field_comment
{
	function init()
	{
		global $config, $user;

		parent::init();
		$this->type = 'comment';
		$this->data['legend'] = sprintf($user->lang($this->data['legend']), intval($config->data['max_sig_chars']));
	}
}

// contact
class field_messenger extends field
{
	function init()
	{
		parent::init();
		$this->type = isset($this->data['output']) && $this->data['output'] ? 'image' : 'varchar';
	}
}

class field_msnm extends field_messenger
{
	function init()
	{
		parent::init();
		if ( isset($this->data['output']) && $this->data['output'] && !empty($this->value) )
		{
			$this->data['link'] = 'http://members.msn.com/' . $this->value;
			$this->data['title'] = $this->value;
		}
	}

	function check()
	{
		global $error, $error_msg;
		global $user;

		if ( isset($this->data['output']) && $this->data['output'] || empty($this->value) )
		{
			return;
		}
		parent::check();
		if ( !$error && !check_email($this->value) )
		{
			_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('Email_invalid'));
		}
	}
}

class field_aim extends field_messenger
{
	function init()
	{
		parent::init();
		if ( isset($this->data['output']) && $this->data['output'] && !empty($this->value) )
		{
			$this->data['link'] = 'aim:goim?screenname=' . $this->value . '&amp;message=Hello+Are+you+there?';
			$this->data['title'] = $this->value;
		}
	}
}

class field_yim extends field_messenger
{
	function init()
	{
		parent::init();
		if ( isset($this->data['output']) && $this->data['output'] && !empty($this->value) )
		{
			$this->data['link'] = 'http://edit.yahoo.com/config/send_webmesg?.target=' . $this->value . '&amp;.src=pg';
			$this->data['title'] = $this->value;
		}
	}
}

class field_icq extends field_messenger
{
	function init()
	{
		parent::init();
		$this->data['image.status'] = '';
		if ( isset($this->data['output']) && $this->data['output'] && !empty($this->value) )
		{
			$this->data['image.status'] = 'http://web.icq.com/whitepages/online?web=' . $this->value . '&img=5';
			$this->type = 'messenger_status';
			$this->data['title'] = $this->value;
			if ( empty($this->data['image.offset.x']) )
			{
				$this->data['image.offset.x'] = 3;
				$this->data['image.offset.y'] = -1;
			}
			if ( empty($this->data['link']) )
			{
				$this->data['link'] = 'http://wwp.icq.com/scripts/search.dll?to=' . $this->value;
			}
			if ( empty($this->data['image.link']) )
			{
				$this->data['image.link'] = 'http://wwp.icq.com/' . $this->value . '#pager';
			}
		}
	}

	function field_values()
	{
		return parent::field_values() + array(
			'U_IMAGE_LINK' => isset($this->data['image.link']) ? $this->data['image.link'] : '',
			'IMAGE_OFFSET_X' => isset($this->data['image.offset.x']) ? intval($this->data['image.offset.x']) : 0,
			'IMAGE_OFFSET_Y' => isset($this->data['image.offset.y']) ? intval($this->data['image.offset.y']) : 0,
			'IMAGE_STATUS' => isset($this->data['image.status']) ? $this->data['image.status'] : '',
		);
	}

	function check()
	{
		global $error, $error_msg;
		global $user;

		if ( (isset($this->data['output']) && $this->data['output']) || empty($this->value) )
		{
			return;
		}

		parent::check();

		// only numerics
		if ( !preg_match('/^[0-9]+$/', $this->value) )
		{
			_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('Only_numeric_allowed'));
		}
	}
}

class field_www extends field_url
{
	function init()
	{
		parent::init();

		if ( !empty($this->value) && !preg_match('#^(ht|f)tp[s]?:\/\/#i', $this->value) )
		{
			$this->value = 'http://' . $this->value;
		}

		if ( isset($this->data['output']) && $this->data['output'] )
		{
			$this->data['link'] = $this->value;
			if ( !empty($this->data['image']) )
			{
				$this->type = 'image';
				$this->data['title'] = $this->value;
			}
		}
	}

	function check()
	{
		global $error, $error_msg;

		if ( !(isset($this->data['output']) && $this->data['output']) && !empty($this->value) && !preg_match('#^(ht|f)tp[s]?:\/\/#i', $this->value) )
		{
			$this->value = 'http://' . $this->value;
		}

		parent::check();
	}
}

// registration
class field_username extends field_varchar
{
	function decode($value)
	{
		return _htmldecode($value);
	}

	function encode($value)
	{
		return stripslashes(phpbb_clean_username(addslashes(trim(preg_replace('#\s+#', ' ', $value)))));
	}

	function get_value($value)
	{
		// accept html (escaped with encode())
		return $this->encode(_read($this->name, TYPE_HTML, $this->decode($value), '', isset($this->data['form_only']) ? intval($this->data['form_only']) : 0));
	}

	function check()
	{
		global $error, $error_msg;
		global $db, $user;

		if ( isset($this->data['output']) && $this->data['output'] )
		{
			return;
		}

		parent::check();
		if ( $error )
		{
			return;
		}

		// check empty
		if ( empty($this->value) )
		{
			if ( !$this->data['empty_allowed'] )
			{
				_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('empty_error'));
			}
			return;
		}
		// no changes : return
		if ( $this->value == $this->data['value'] )
		{
			return;
		}

		// remove html escape for some checks
		$username = _un_htmlspecialchars($this->value);

		// Don't allow " and ALT-255 in username.
		if ( strstr($username, '"') || strstr($username, '&quot;') || strstr($username, chr(160)) )
		{
			_error('Username_invalid');
			return;
		}

		// check size
		if ( intval($this->data['length_mini']) && (strlen($username) < intval($this->data['length_mini'])) )
		{
			_error($user->lang(empty($this->data['legend']) ? $this->name : $this->data['legend']) . ': ' . $user->lang('length_mini_error'));
			return;
		}

		// are we editing ?
		$user_id = isset($this->data['sub_values']) ? intval($this->data['sub_values']['user_id']) : 0;

		// check the username against existing user names
		$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE LOWER(username) = \'' . $db->sql_escape_string(strtolower($this->value)) . '\'' . (empty($user_id) ? '' : '
						AND user_id <> ' . intval($user_id)) . '
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$found = ($row = $db->sql_fetchrow($result));
		$db->sql_freeresult($result);

		// check the username against group names
		if ( !$found )
		{
			$sql = 'SELECT group_id
						FROM ' . GROUPS_TABLE . '
						WHERE LOWER(group_name) = \'' . $db->sql_escape_string(strtolower($this->value)) . '\'
							AND group_single_user <> 1
						LIMIT 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			$found = ($row = $db->sql_fetchrow($result));
			$db->sql_freeresult($result);
		}
		if ( $found )
		{
			_error('Username_taken');
			return;
		}

		// check the username against disallowed names
		$sql = 'SELECT disallow_username
					FROM ' . DISALLOW_TABLE;
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$found = false;
		while ( ($row = $db->sql_fetchrow($result)) && !$found )
		{
			$found = preg_match('#\b(' . str_replace('\*', '.*?', preg_quote($row['disallow_username'], '#')) . ')\b#i', $this->value);
		}
		$db->sql_freeresult($result);
		if ( $found || (_censor($this->value) != $this->value) )
		{
			_error('Username_disallowed');
			return;
		}
	}
}

class field_email extends field_varchar
{
	function check()
	{
		global $error, $error_msg;
		global $db, $user;

		parent::check();
		if ( $error || (isset($this->data['output']) && $this->data['output']) )
		{
			return;
		}

		// check empty
		if ( empty($this->value) )
		{
			if ( !$this->data['empty_allowed'] )
			{
				_error('empty_error');
			}
			return;
		}

		// no changes : return
		if ( $this->value == $this->data['value'] )
		{
			return;
		}

		// check wording
		if ( !check_email($this->value) )
		{
			_error('Email_invalid');
			return;
		}

		// are we editing ?
		$user_id = isset($this->data['sub_values']) ? intval($this->data['sub_values']['user_id']) : 0;

		// check against existing emails
		$sql = 'SELECT user_id
					FROM ' . USERS_TABLE . '
					WHERE LOWER(user_email) = \'' . $db->sql_escape_string(strtolower($this->value)) . '\'' . (empty($user_id) ? '' : '
						AND user_id <> ' . intval($user_id)) . '
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$found = ($row = $db->sql_fetchrow($result));
		$db->sql_freeresult($result);
		if ( $found )
		{
			_error('Email_taken');
		}

		// check against banned
		$sql = 'SELECT ban_email
					FROM ' . BANLIST_TABLE . '
					WHERE ban_email IS NOT NULL
						AND ban_email <> \'\'';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$found = false;
		while ( ($row = $db->sql_fetchrow($result)) && !$found )
		{
			$found = preg_match('#^' . str_replace('\*', '.*?', preg_quote($row['ban_email'], '#')) . '$#is', $this->value);
		}
		$db->sql_freeresult($result);

		// check if there are censored words in the email address. Ignore the last "@".
		if ( !$found )
		{
			$domain = strrchr($this->value, '@');
			$value = substr($this->value, 0, - strlen($domain)) . "\n" . substr($domain, 1);
			$found = _censor($value) != $value;
		}
		if ( $found )
		{
			_error('Email_banned');
			return;
		}
	}
}

class field_special_rank extends field_list
{
	function init()
	{
		global $config;

		if ( !class_exists('ranks') )
		{
			include($config->url('includes/class_message'));
		}
		$ranks = new ranks();
		$ranks_data = $ranks->read();
		$this->data['options'] = array(0 => 'No_assigned_rank');
		if ( $count_ranks = count($ranks_data) )
		{
			for ( $i = 0; $i < $count_ranks; $i++ )
			{
				if ( $ranks_data[$i]['rank_special'] )
				{
					$this->data['options'][ intval($ranks_data[$i]['rank_id']) ] = $ranks_data[$i]['rank_title'];
				}
			}
		}
		unset($ranks_data);
		unset($ranks);
		parent::init();
		$this->type = 'list';
	}
}

?>