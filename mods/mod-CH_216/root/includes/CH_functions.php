<?php
//
//	file: includes/CH_functions.php
//	author: ptirhiik
//	begin: 10/02/2006
//	version: 1.6.10 - 07/10/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// set this to true to allow &#999; chars to be accepted through _read() as valid chars (eg not processed by htmlspecialchars())
define('UTF8', false);

// high level functions
function get_quota_box($title, $count, $max)
{
	global $config, $user, $template;

	$count = max(0, $count);
	$max = max(0, $max);
	$pct = ($count <= $max) && intval($max) ? min(100, round((100 * $count) / $max)) : 100;
	$length = $pct * $config->data['privmsg_graphic_length'];

	$template->assign_block_vars('quota_box', array(
		'L_BOX' => sprintf($user->lang($title), $pct),
		'PCT' => $pct,
		'I_LENGTH' => round($pct * $config->data['privmsg_graphic_length'] / 100),
	));
	$template->set_switch('quota_box.some', $count);
	return $template->include_file('quota_box.tpl', 'quota_box');
}

function size_get_units($value, &$units)
{
	$units = array(1048576 => 'MB', 1024 => 'KB', 1 => 'Bytes');
	$unit = 1;
	foreach ( $units as $div => $dummy )
	{
		if ( $value >= $div )
		{
			$unit = $div;
			break;
		}
	}
	ksort($units);
	return $unit;
}

function format_size($value)
{
	$units = array();
	$unit = size_get_units($value, $units);
	return array('value' => round($value / $unit, 2), 'unit' => $units[$unit]);
}

//
// functions rewrite by CH
//
function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', intval($ip_sep[0]), intval($ip_sep[1]), intval($ip_sep[2]), intval($ip_sep[3]));
}

function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

function phpbb_realpath($path)
{
	static $done, $realpath_exists;
	if ( !$done )
	{
		$done = true;
		$checkpath = function_exists('realpath') ? @realpath('.') : false;
		$realpath_exists = $checkpath && ($checkpath != '.');
	}
	return $realpath_exists ? @realpath($path) : $path;
}

function dss_rand()
{
	global $db, $config;
	static $done;

	$val = $config->data['rand_seed'] . microtime();
	$val = md5($val);
	$config->data['rand_seed'] = md5($config->data['rand_seed'] . $val . 'a');
	$config->dynamic['rand_seed'] = true;
	if ( !$done )
	{
		$config->set('rand_seed', $config->data['rand_seed']);
		$done = true;
	}
	return substr($val, mt_rand(0, strlen($val) - 17), 16);
}

function gen_rand_string($hash)
{
	$code = dss_rand();
	return $hash ? md5($code) : substr($code, mt_rand(0, strlen($code) - 9), 8);
}

function make_jumpbox($requester='', $match_forum_id = 0, $force=false)
{
	global $config, $user, $template, $forums;

	if ( !$match_forum_id && !$force )
	{
		return;
	}
	$requester = substr($requester, 0, 5);
	if ( ($requester != 'modcp') && ($requester != INDEX) )
	{
		$requester = INDEX;
	}
	if ( $forums === false )
	{
		if ( !class_exists('forums') )
		{
			include($config->url('includes/class_forums'));
		}
		$forums = new forums();
		$forums->read();
	}

	// header
	$template->assign_block_vars('jumpbox', array(
		'L_GO' => $template->lang('Go'),
		'I_GO' => $template->img('cmd_mini_submit'),
		'L_JUMP_TO' => $template->lang('Jump_to'),

		'S_ACTION' => $config->url($requester, '', true),
		'S_NAME' => POST_FORUM_URL,
		'SID' => $user->data['session_id'],
	));

	$front_pic = $forums->get_cached_front_pic();
	if ( empty($front_pic) )
	{
		$template->assign_block_vars('jumpbox.option', array(
			'VALUE' => -1,
			'TEXT' => $template->lang('None'),
		));
	}
	else
	{
		$template->assign_block_vars('jumpbox.option', array(
			'VALUE' => -2,
			'TEXT' => $template->lang('Select_forum'),
		));
		$template->set_switch('jumpbox.option.selected');
		$template->assign_block_vars('jumpbox.option', array(
			'VALUE' => -1,
			'TEXT' => '-------------------',
		));
		$template->set_switch('jumpbox.option.disabled');
		foreach ( $front_pic as $cur_id => $front )
		{
			$template->assign_block_vars('jumpbox.option', array(
				'VALUE' => $cur_id,
				'TEXT' => $cur_id >= 0 ? $template->lang($forums->data[$cur_id]['forum_name']) : '',
			));
			$template->set_switch('jumpbox.option.front', ($count_front = strlen($front)));
			for ( $i = 0; $i < $count_front; $i++ )
			{
				$template->assign_block_vars('jumpbox.option.front.inc', array(
					'L_INC' => $template->lang('tree_pic_' . $front[$i]),
				));
			}
		}
	}
	// send this to main template
	$template->assign_vars(array(
		'JUMPBOX' => $template->include_file('jumpbox.tpl', 'jumpbox'),
	));
}

function init_userprefs($userdata)
{
	// var to make them available in .cfg & .ini
	global $db, $config, $template, $user, $censored_words, $icons, $navigation, $themes, $smilies, $requester;
	global $board_config, $theme, $images, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header;
	global $user_ip, $session_length;
	global $starttime;

	if ( $user === false )
	{
		$user = new user();
		$user->read(ANONYMOUS);
	}
	$user->set($requester);
}

function setup_style($force_style)
{
	// var to make them available in .cfg & .ini
	global $db, $config, $template, $user, $censored_words, $icons, $navigation, $themes, $smilies, $requester;
	global $board_config, $theme, $images, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header;
	global $user_ip, $session_length;
	global $starttime;

	$style = new style();
	$row = $style->read($force_style);
	unset($style);

	return $row;
}

function create_date($format, $gmepoch, $tz)
{
	global $user;
	return $user->date($gmepoch, $format);
}

function obtain_word_list(&$orig_word, &$replacement_word)
{
	global $censored_words;

	// read if not done
	$data = $censored_words->read();
	$orig_word = array_keys($data);
	$replacement_word = array_values($data);
}

function redirect($url, $call_back='')
{
	global $db, $config;
	global $SID;

	if ( !empty($db) )
	{
		$db->sql_close();
	}
	if ( strstr(urldecode($url), "\n") || strstr(urldecode($url), "\r") || strstr(urldecode($url), ';url') || ($call_back && (strstr(urldecode($call_back), "\n") || strstr(urldecode($call_back), "\r")) || strstr(urldecode($call_back), ';url')) )
	{
		message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
	}
	if ( $call_back )
	{
		$url = explode('?', $url);
		$call_back = preg_replace('#(&amp;sid=[0-9a-z]{' . max(0, intval(strlen($SID) - strlen('sid='))) . '})#si', '', $call_back);
		$url = $url[0] . '?redirect=' . str_replace('?', '&amp;', preg_replace('#^\.\/(.*)#', '\1', $call_back)) . ($url[1] ? '&amp;' . $url[1] : '');
	}

	$url = preg_replace('#^\/?(.*?)\/?$#', '\1', trim(preg_replace('#^(\.\/)(.*)$#', '\2', $url)));
	if ( !preg_match('#^(ht|f)tp(s?)\:\/\/#i', $url) )
	{
		$script_path = $config->root;
		if ( !preg_match('#(\?|&amp;|&)sid=#i', $url) )
		{
			$sid = substr($SID, strlen('sid='));
			if ( $sid )
			{
				$url .= (strpos(' ' . $url, '?') ? '&amp;' : '?') . 'sid=' . $sid;
			}
		}
	}
	$url_ampersand = $script_path . $url;
	$url = $script_path . str_replace('&amp;', '&', $url);

	// Redirect via an HTML form for PITA webservers
	if ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) )
	{
		$title = 'redirect';
		$meta = '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $url . '">';
		header('Refresh: 0; URL=' . $url);
		exception_header($title, $meta);
		echo 'If your browser does not support meta redirection please click <a href="' . $url_ampersand . '">HERE</a> to be redirected';
		exception_footer();
		exit;
	}

	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . $url);
	exit;
}

function message_die($msg_code, $msg_text='', $msg_title='', $err_line='', $err_file='', $sql='')
{
	global $config, $user, $censored_words, $icons, $navigation, $themes, $smilies, $requester;
	global $db, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images;
	global $userdata, $user_ip, $session_length;
	global $starttime;
	global $gen_simple_header;

	if ( ($user === false) || ($config === false) )
	{
		$msg_code = CRITICAL_ERROR;
	}

	trap_multiple_die($msg_code, $msg_text, $msg_title, $err_line, $err_file, $sql);
	define('HAS_DIED', 1);

	// trap sql error
	$debug_text = '';
	if ( DEBUG && (($msg_code == GENERAL_ERROR) || ($msg_code == CRITICAL_ERROR)) && is_object($db) )
	{
		$sql_error = $db->sql_error();
		$debug_text = ($sql_error['message'] ? '<br /><br />SQL Error: ' . $sql_error['code'] . ' ' . $sql_error['message'] : '') . ($sql ? '<br /><br />SQL Request: ' . $sql : '') . ($err_line && $err_file ? '</br /><br />Line : ' . $err_line . '<br />File : ' . basename($err_file) : '');
	}
	if ( $debug_text )
	{
		$debug_text = '<br /><br /><b><u>DEBUG MODE</u></b>' . $debug_text;
	}

	// fix default parms
	switch($msg_code)
	{
		case GENERAL_MESSAGE:
			$msg_title = empty($msg_title) ? 'Information' : $msg_title;
			break;

		case CRITICAL_MESSAGE:
			$msg_title = empty($msg_title) ? 'Critical_Information' : $msg_title;
			break;

		case GENERAL_ERROR:
			$msg_title = empty($msg_title) ? 'General_Error' : $msg_title;
			$msg_text = empty($msg_text) ? 'An_error_occured' : $msg_text;
			break;

		case CRITICAL_ERROR:
			$msg_title = empty($msg_title) ? 'Critical_Error' : $msg_title;
			$msg_text = empty($msg_text) ? 'A_critical_error' : $msg_text;
			break;
	}

	//
	// ok, send all to display
	//

	// init user if not done
	if ( (($msg_code == GENERAL_MESSAGE) || ($msg_code == GENERAL_ERROR)) && !$user->data )
	{
		$userdata = session_pagestart($user_ip, PAGE_INDEX);
		$user->set($requester);
	}

	// solve texts
	if ( empty($lang) )
	{
		if ( ($filename = $phpbb_root_path . (($msg_code == CRITICAL_ERROR) || empty($config->data['default_lang']) ? 'language/lang_english/lang_main' : 'language/lang_' . $config->data['default_lang'] . '/lang_main') . '.' . $phpEx) && @file_exists(phpbb_realpath($filename)) )
		{
			include($filename);
		}
	}
	$msg_title = isset($lang[$msg_title]) ? $lang[$msg_title] : $msg_title;
	$msg_text = (empty($msg_text) || !isset($lang[$msg_text]) ? $msg_text : $lang[$msg_text]) . $debug_text;

	// deal with critical errors
	if ( $msg_code == CRITICAL_ERROR )
	{
		trap_critical_error();
		exception_header($msg_title);
		echo '<br /><br />' . $msg_text . $debug_text;
		exception_footer();
		exit;
	}

	// deal with other type of errors; through the template parser
	if ( empty($template) )
	{
		$template = new template_class($config->root . 'templates/' . $config->data['board_template']);
	}
	if ( empty($theme) )
	{
		$style = new style();
		$theme = $style->read($board_config['default_style']);
		unset($style);
	}
	trap_generic_error($msg_code, $msg_text, $msg_title, $err_line, $err_file, $sql);
	$template->assign_vars(array(
		'MESSAGE_TITLE' => $msg_title,
		'MESSAGE_TEXT' => '<br />' . $msg_text . '<br /><br />',
	));
	$template->set_filenames(array('message_body' => defined('IN_ADMIN') ? 'admin/admin_message_body.tpl' : 'message_body.tpl'));
	if ( !defined('HEADER_INC') )
	{
		$page_title = $msg_title;
		include($config->url(defined('IN_ADMIN') ? 'admin/page_header_admin' : 'includes/page_header'));
	}
	$template->pparse('message_body');
	include($config->url(defined('IN_ADMIN') ? 'admin/page_footer_admin' : 'includes/page_tail'));
	exit;
}

//
// functions added by CH
//

// note : this one is Markus Petrux's "Fix message_die for multiple errors" mod
function trap_multiple_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	global $config, $lang, $phpbb_root_path, $phpEx;
	static $msg_history;

	if ( empty($msg_history) )
	{
		$msg_history = array();
	}
	$msg_history[] = array(
		'msg_code' => $msg_code,
		'msg_text' => $msg_text,
		'msg_title' => $msg_title,
		'err_line' => $err_line,
		'err_file' => $err_file,
		'sql' => $sql,
	);
	if ( !defined('HAS_DIED') )
	{
		return;
	}
	$no_config = ($config === false) || !isset($config->data['board_email']) || !$config->data['board_email'];
	if ( empty($lang) )
	{
		if ( ($filename = $phpbb_root_path . 'language/lang_english/lang_extend_cat_hierarchy.'.$phpEx) && @file_exists(phpbb_realpath($filename)) )
		{
			include($filename);
		}
	}
	if ( !isset($lang['Contact_webmaster']) )
	{
		$lang = array(
			'Contact_webmaster' => 'Please, contact the %swebmaster%s. Thank you.',
		);
	}

	// send message
	exception_header('Critical Error');
?><br />message_die() was called multiple times.<br />&nbsp;<hr />
<?php for($i = count($msg_history) - 1; $i >= 0; $i--) { ?>
<b>Error #<?php echo ($i+1); ?></b><br />
<?php if( !empty($msg_history[$i]['msg_title']) ) { ?><b><?php echo $msg_history[$i]['msg_title']; ?></b><br /><?php } ?>
<?php echo $msg_history[$i]['msg_text']; ?><br /><br />
<?php if( !empty($msg_history[$i]['err_line']) ) { ?><b>Line :</b> <?php echo $msg_history[$i]['err_line']; ?><br />
<b>File :</b> <?php echo $msg_history[$i]['err_file']; ?></b><br /><?php } ?>
<?php if ( !empty($msg_history[$i]['sql']) ) { ?><b>SQL :</b> <?php echo $msg_history[$i]['sql']; ?><br /><?php } ?>
&nbsp;<hr /><br /><?php } ?>
&nbsp;<br /><hr />
<?php echo sprintf($lang['Contact_webmaster'], $no_config ? '' : '<a href="mailto:' . $config->data['board_email'] . '">', $no_config ? '' : '</a>'); ?>
<hr /><?php
	exception_footer();
	exit;
}

function trap_critical_error()
{
	global $phpbb_root_path, $phpEx;

	if ( defined('IN_ADMIN') || DEBUG )
	{
		return;
	}
	if ( ($filename = $phpbb_root_path . 'language/lang_english/lang_extend_cat_hierarchy.'.$phpEx) && @file_exists(phpbb_realpath($filename)) )
	{
		include($filename);
	}
	if ( !isset($lang['Under_maintenance_title']) )
	{
		$lang = array(
			'Under_maintenance_title' => 'Under maintenance',
			'Under_maintenance' => 'The board is currently under maintenance.<br />Sorry for the inconvenience, please retry later.<br />',
		);
	}

	// send message
	exception_header($lang['Under_maintenance_title']);
	echo '<h1>' . $lang['Under_maintenance'] . '</h1>';
	exception_footer();
	exit;
}

function trap_generic_error($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	global $template, $config, $user, $lang, $navigation;
	global $gen_simple_header;

	if ( defined('DEBUG_MESSAGES') && !defined('IN_MESSAGE_RETURN') && is_object($user) && ($user->data['user_level'] == ADMIN) )
	{
		if ( empty($lang) )
		{
			$lang = array(
				'dbg_backtrace' => 'Back trace',
				'dbg_requester' => 'Requester',
			);
		}
		$msg_text .= '<br /><br /></span></td></tr><tr><td class="cat" align="center"><span class="cattitle">' . $lang['dbg_backtrace'] . '</span></td></tr><tr><td class="row1"><span class="gen">';
		if ( function_exists('debug_backtrace') )
		{
			$dbg = debug_backtrace();
			$count_dbg = count($dbg);
			for ( $i = 0; $i < $count_dbg; $i++ )
			{
				$msg_text .= '<br /><b>' . $lang['dbg_requester'] . ':</b> ' . basename($dbg[$i]['file']) . '[ ' . $dbg[$i]['line'] . ' ].' . $dbg[$i]['function'] . '(' . (empty($dbg[$i]['args']) ? '' : stripslashes(_format($dbg[$i]['args']))) . ')';
			}
		}
		$template->assign_vars(array('META' => ''));
	}
	if ( !defined('IN_ADMIN') && !empty($config->data) && !$gen_simple_header )
	{
		global $navigation;

		if ( $navigation === false )
		{
			$navigation = new navigation();
		}
		if ( !$navigation->displayed )
		{
			$navigation->display();
		}
	}
	else
	{
		$template->assign_vars(array(
			'NAVIGATION_BOX' => $gen_simple_header ? '' : '<a href="' . append_sid(INDEX . '.' . $phpEx) . '" class="nav">' . sprintf($lang['Forum_Index'], $board_config['sitename']) . '</a>',
		));
	}
}

function exception_header($title='', $meta='')
{
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<?php echo $meta; ?>
	<title><?php echo $title; ?></title>
	<style type="text/css">
	<!--
	body {
		background-color: #E5E5E5;
	}
	.bodyline { 
		background-color: #FFFFFF;
		border: 1px #98AAB1 solid;
	}
	h1 {
		font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
		font-size: 32px;
		font-weight: bold;
		text-decoration: none;
		color : #000000;
	}
	-->
	</style>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center" height="100%"><tr><td class="bodyline" height="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%"><tr><td height="100%" valign="top"><h1><?php echo $title ?></h1><?php
}

function exception_footer()
{
?></td></tr></table></td></tr></table><br clear="all" /></body></html><?php
	exit;
}

// var_dump() reviewed for output
function _dump($message, $line='', $file='')
{
	global $lang;

	if ( empty($lang) || !isset($lang['dbg_line']) )
	{
		if ( empty($lang) )
		{
			$lang = array();
		}
		$lang += array(
			'dbg_line' => 'Line: %s',
			'dbg_file' => 'File: %s',
			'dbg_empty' => 'Empty',
		);
	}

	if ( empty($file) && function_exists('debug_backtrace') )
	{
		$dbg = debug_backtrace();
		$file = $dbg[0]['file'];
		$line = $dbg[0]['line'];
		unset($dbg);
	}
	$title = array();
	if ( !empty($line) )
	{
		$title[] = sprintf($lang['dbg_line'], $line);
	}
	if ( !empty($file) )
	{
		$title[] = sprintf($lang['dbg_file'], $file);
	}

	echo '<pre style="background-color: #ffffff; color: #000000; border: 1px; border-style: outset; padding: 5px;"><strong>' . (empty($title) ? '' : implode(' - ', $title) . '</strong><br />');
	if ( is_bool($message) )
	{
		echo $message ? 'TRUE' : 'FALSE';
	}
	else if ( empty($message) )
	{
		echo is_numeric($message) ? $message : 'Empty';
	}
	else if ( is_array($message) || is_object($message) )
	{
		ob_start();
		print_r($message);
		$content = ob_get_contents();
		ob_end_clean();
		echo htmlspecialchars($content);
	}
	else
	{
		echo str_replace("\t", '&nbsp; &nbsp;', htmlspecialchars($message));
	}
	echo '</pre>';
}

function convert_microtime($time)
{
	list($usec, $sec) = explode(' ', $time);
	return ( (float)$usec + (float)$sec );
}

// various sys func
function _htmlencode($str)
{
	$cleaned_chars = array("\r\n" => "\n", "\r" => "\n", "\xFF" => ' ');
	$utf8_equivalency = array('&#39;' => '\'');
	$str = trim(htmlspecialchars(str_replace(array_keys($cleaned_chars), array_values($cleaned_chars), $str)));
	if ( defined('UTF8') && UTF8 && strpos(' ' . $str, '&amp;#') )
	{
		$str = str_replace(array_keys($utf8_equivalency), array_values($utf8_equivalency), preg_replace('#&amp;(\#[0-9]+;)#', '&\1', $str));
	}
	return $str;
}

function _htmldecode($str)
{
	return _un_htmlspecialchars($str);
}

function _first_key($ary)
{
	if ( empty($ary) || !is_array($ary) )
	{
		return false;
	}
	@reset($ary);
	list($res, ) = @each($ary);
	return $res;
}

function _type_cast($val, $type, $list=array(), $escape_html=true)
{
	switch ( $type )
	{
		case TYPE_INT: // integer
			$val = intval($val);
			break;
		case TYPE_FLOAT: // numeric
			$val = doubleval($val);
			break;
		case TYPE_NO_HTML: // no slashes nor html
			if ( $escape_html )
			{
				$val = _htmlencode($val);
				break;
			}
		default:
			if ( !$escape_html )
			{
				$val = _htmldecode($val);
			}
			break;
	}
	if ( !empty($list) )
	{
		$str_val = _htmlencode((string) $val);
		$int_val = sprintf('%s', intval($val));
		$float_val = sprintf('%01.2f', doubleval($val));
		if ( isset($list[$str_val]) )
		{
			$val = $str_val;
		}
		else if ( isset($list[$int_val]) )
		{
			$val = $int_val;
		}
		else if ( isset($list[$float_val]) )
		{
			$val = $float_val;
		}
		else
		{
			$val = '';
		}
		if ( !isset($list[$val]) )
		{
			$val = _first_key($list);
		}
		$int_val = sprintf('%s', intval($val));
		$float_val = sprintf('%01.2f', doubleval($val));
		if ( $val == $int_val )
		{
			$val = intval($val);
		}
		else if ( $val == $float_val )
		{
			$val = doubleval($val);
		}
	}
	return $val;
}

function _read($var, $type='', $dft='', $list=array(), $post_only=0)
{
	global $HTTP_POST_VARS, $HTTP_GET_VARS;

	// adjust with dft
	$res = _type_cast($dft, $type, $list, false);
	if ( empty($var) )
	{
		return $res;
	}
	$post_only = intval($post_only);

	// read $_* value
	if ( (($post_only < 2) && isset($HTTP_POST_VARS[$var])) || (($post_only != 1) && isset($HTTP_GET_VARS[$var])) )
	{
		$res = (intval($post_only) != 3) && isset($HTTP_POST_VARS[$var]) ? $HTTP_POST_VARS[$var] : rawurldecode($HTTP_GET_VARS[$var]);
		if ( (intval($post_only) != 3) && isset($HTTP_POST_VARS[$var]) && is_array($res) )
		{
			// we have received an array, so do a basic clean
			if ( !empty($res) )
			{
				$tres = array();
				foreach ( $res as $key => $val )
				{
					$key = trim(stripslashes(str_replace(array("\r\n", "\r", "\xFF"), array("\n", "\n", ' '), $key)));
					$val = trim(stripslashes(str_replace(array("\r\n", "\r", "\xFF"), array("\n", "\n", ' '), $val)));
					$tres[$key] = $val;
				}
				$res = $tres;
				unset($tres);
			}
		}
		else if ( !is_array($res) )
		{
			$res = stripslashes($res);
		}
		else
		{
			$res = '';
		}
	}
	$res = _type_cast($res, $type, $list);
	return $res;
}

function _read_form($var, $type='', $dft='', $list=array())
{
	return _read($var, $type, $dft, $list, 1);
}

function _read_url($var, $type='', $dft='', $list=array())
{
	return _read($var, $type, $dft, $list, 2);
}

function _on_form($var)
{
	global $HTTP_POST_VARS;
	return isset($HTTP_POST_VARS[$var]);
}

function _force_url($var, $value)
{
	global $HTTP_GET_VARS;
	$HTTP_GET_VAR[$var] = $value;
}

function _button($var)
{
	global $HTTP_POST_VARS;

	// image buttons return an _x and _y value in the $_POST array
	if ( isset($HTTP_POST_VARS[$var . '_x']) && isset($HTTP_POST_VARS[$var . '_y']) )
	{
		$HTTP_POST_VARS[$var] = true;
	}
	return (isset($HTTP_POST_VARS[$var]) && !empty($HTTP_POST_VARS[$var]));
}

function _cvt_pic_buttons()
{
	global $HTTP_POST_VARS;
	if ( !empty($HTTP_POST_VARS) )
	{
		$added = array();
		foreach ( $HTTP_POST_VARS as $key => $val )
		{
			$var = substr($key, 0, strlen($key)-2);
			if ( ($key == $var . '_x') && isset($HTTP_POST_VARS[$var . '_y']) )
			{
				$added[$var] = true;
			}
		}
		$HTTP_POST_VARS += $added;
	}
}

function _hide($key, $value='', $force_empty=false)
{
	global $s_hidden_fields;
	if ( !empty($key) && is_array($key) )
	{
		foreach ( $key as $sub_key => $value )
		{
			_hide($sub_key, $value);
		}
	}
	else if ( (!empty($key) && !empty($value)) || $force_empty )
	{
		$s_hidden_fields .= '<input type="hidden" name="' . addslashes(stripslashes($key)) . '" value="' . addslashes(stripslashes($value)) . '" />';
	}
}

function _hide_set($tpl_varname='')
{
	global $s_hidden_fields, $template;
	$template->assign_vars(array((empty($tpl_varname) ? 'S_HIDDEN_FIELDS' : $tpl_varname) => $s_hidden_fields));
}

// remove html tags
function _clean_html($str)
{
	return _htmlencode(preg_replace('#<[\/\!]*?[^<>]*?>#si', '', _htmldecode($str)));
}

// borrowed from function_search : quickly remove BBcode.
function _clean_bbcode($str)
{
	$str = preg_replace('/\[img:[a-z0-9]{10,}\].*?\[\/img:[a-z0-9]{10,}\]/', ' ', $str);
	$str = preg_replace('/\[\/?url(=.*?)?\]/', ' ', $str);
	$str = preg_replace('/\[\/?[a-z\*=\+\-]+(\:?[0-9a-z]+)?:[a-z0-9]{10,}(\:[a-z0-9]+)?=?.*?\]/', ' ', $str);
	return $str;
}

function _censor($str)
{
	global $censored_words;

	// read data if not already done
	$censored_words->read();
	if ( count($censored_words->data) )
	{
		$str = preg_replace(array_keys($censored_words->data), array_values($censored_words->data), $str);
	}
	return $str;
}

function _format_highlight_word($word)
{
	return str_replace('\*', '\w*', preg_quote(phpbb_rtrim(trim($word), '\\'), '#'));
}

function _format_highlight($highlight='')
{
	$highlight = empty($highlight) ? '' : trim(preg_replace('#(\s+)?[\+\|-](\s+)?#', ' ', $highlight));
	return empty($highlight) ? '' : preg_replace('#[\|]+#', '|', implode('|', array_map('_format_highlight_word', array_keys(array_flip(preg_split('#\s+#', $highlight))))));
}

function _highlight($text, $highlight)
{
	global $theme;
	return empty($highlight) ? $text : preg_replace('#(?!<.*)(?<!\w)(' . $highlight . ')(?!\w|[^<>]*>)#i', '<b style="color:#' . $theme['fontcolor3'] . '">\1</b>', $text);
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
		if ( isset($blocks[1][$i]) && ($blocks[1][$i] == $seed) )
		{
			$html_block = '';
			list(, $html_blocks) = @each($html);
			$text .= $html_blocks;
		}
	}
	$html = '';
	$seed = '';
}

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

function _html_entities_encode($str, $escape_entities=true)
{
	$html_entities = ($escape_entities ? array('&amp;' => '#&(?!(\#[0-9]+;))#', '&quot;' => '#"#') : array()) + array('&lt;' => '#<#', '&gt;' => '#>#');
	return empty($str) ? '' : preg_replace(array_values($html_entities), array_keys($html_entities), $str);
}

function _html_entities_decode($str)
{
	$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
	$unhtml_specialchars_replace = array('>', '<', '"', '&');
	return empty($str) ? '' : preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $str);
}

function _format($var, $root=true, $html=false)
{
	return is_array($var) ? _format_array($var, $root, $html) : (is_integer($var) || is_bool($var) ? intval($var) : '\'' . str_replace('\'', '\\\'', str_replace('\\', '\\\\', preg_replace('/[\n\r]+/', '<br />', ($html ? (string) $var : htmlspecialchars((string) $var))))) . '\'');
}

function _format_array($var, $root=false, $html=false)
{
	$res = '';
	if ( !empty($var) )
	{
		foreach ( $var as $key => $val )
		{
			$res .= (empty($res) ? '' : ', ') . (is_string($key) || !$root ? _format($key, false, $html) . ' => ' : '' ) . _format($val, false, $html);
		}
	}
	return $root ? $res : 'array(' . $res . ')';
}

function _error($key)
{
	global $user;
	global $error, $error_msg;

	if ( !$error )
	{
		$error_msg = '';
	}

	$error = true;
	$error_msg .= (empty($error_msg) ? '' : '<br /><br />') . $user->lang($key);
}

function _warning($key)
{
	global $user;
	global $warning, $warning_msg;

	if ( !$warning )
	{
		$warning_msg = '';
	}

	$warning = true;
	$warning_msg .= (empty($warning_msg) ? '' : '<br /><br />') . $user->lang($key);
}

function message_return($message, $return_txt='', $return_url='', $delay=5, $forum_id=false)
{
	global $template, $config, $user;
	global $gen_simple_header;

	define('IN_MESSAGE_RETURN', true);

	if ( !empty($return_url) && (!isset($user->global_lang[$return_txt]) || !strpos(' ' . $user->global_lang[$return_txt], '%s')) )
	{
		$return_txt = '%s' . $return_txt . '%s';
	}

	if ( empty($return_url) || strstr(urldecode($return_url), "\n") || strstr(urldecode($return_url), "\r") || strstr(urldecode($return_url), ';url') )
	{
		$return_url = $config->url(INDEX, '', true);
	}
	$message = empty($message) ? '' : (defined('IN_ADMIN') ? '<br />' : '') . $user->lang($message) . '<br /><br />';
	$message .= empty($return_txt) ? '' : sprintf($user->lang($return_txt), '<a href="' . $return_url . '">', '</a>') . '<br /><br />';
	if ( !$gen_simple_header )
	{
		$message .= sprintf($user->lang(defined('IN_ADMIN') || !$forum_id ? 'Click_return_index' : 'Click_return_forum'), '<a href="' . (defined('IN_ADMIN') ? $config->url('admin/index', array('pane' => 'right'), true) : $config->url(INDEX, array(POST_FORUM_URL => $forum_id), true)) . '">', '</a>');
	}
	if ( defined('DEBUG_MESSAGES') && ($user->data['user_level'] == ADMIN) )
	{
		$message .= '<br /><br /></span></td></tr><tr><td class="cat" align="center"><span class="cattitle">' . $user->lang('dbg_backtrace') . '</span></td></tr><tr><td class="row1"><span class="gen">';
		if ( function_exists('debug_backtrace') )
		{
			$dbg = debug_backtrace();
			$count_dbg = count($dbg);
			for ( $i = 0; $i < $count_dbg; $i++ )
			{
				$message .= '<br /><b>' . $user->lang('dbg_requester') . ':</b> ' . basename($dbg[$i]['file']) . '[ ' . $dbg[$i]['line'] . ' ].' . $dbg[$i]['function'] . '(' . (empty($dbg[$i]['args']) ? '' : stripslashes(_format($dbg[$i]['args']))) . ')';
			}
		}
	}
	else
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="' . intval($delay) . ';url=' . $return_url . '">',
		));
	}
	message_die(GENERAL_MESSAGE, $message);
}

function display_buttons($buttons, $tpl_switch='')
{
	global $config, $user, $template;

	if ( !empty($buttons) )
	{
		$tpl_switch .= (empty($tpl_switch) ? '' : '.') . 'buttons';
		foreach ( $buttons as $name => $data )
		{
			$tpl_fields = array(
				'U_BUTTON' => empty($data['url']) ? '' : $config->url($data['url'], $data['parms'], true),
				'L_BUTTON' => $user->lang($data['txt']),
				'I_BUTTON' => $user->img($data['img']),
				'S_BUTTON' => empty($data['key']) ? '' : $user->lang($data['key']),
				'BUTTON' => $name,
			);
			$template->assign_block_vars($tpl_switch, $tpl_fields);
			$template->set_switch($tpl_switch . '.accesskey', !empty($data['key']));
		}
		$template->set_switch($tpl_switch . '.last');
	}
}

function _date_order($date_fmt, $with_hour=true)
{
	$replaced = array('n' => 'm', 'f' => 'm', 'j' => 'd', 'l' => 'd', 'w' => 'd', 'z' => 'd', 'r' => 'dmy');
	$date_fmt = ' ' . str_replace(array_keys($replaced), array_values($replaced), strtolower($date_fmt));
	$order['y'] = strpos($date_fmt, 'y');
	$order['m'] = strpos($date_fmt, 'm');
	$order['d'] = strpos($date_fmt, 'd');
	asort($order);
	if ( $with_hour )
	{
		$order += array('h' => '', 'i' => '');
	}
	return array_flip(array_keys($order));
}

function _date_h_fmt($date_fmt)
{
	if ( $pos = strpos(' ' . strtolower($date_fmt), 'a') )
	{
		return 'h ' . $date_fmt[$pos - 1];
	}
	return 'H';
}

//
// older php compliancy
//
// php 4.0.6
if ( !function_exists('array_map') )
{
	function array_map()
	{
		$args = func_get_args();
		if ( isset($args[2]) )
		{
			$args[1] = array_values($args[1]);
			$args[2] = array_values($args[2]);
		}
		$res = array();
		if ( !empty($args[1]) )
		{
			$i = 0;
			foreach ( $args[1] as $key => $value )
			{
				if ( is_array($callback) )
				{
					$args[1][$key] = isset($args[2]) ? $args[0][0]->$args[0][1]($value, $args[2][$i]) : $args[0][1]->$args[0][2]($value);
				}
				else
				{
					$args[1][$key] = isset($args[2]) ? $args[0]($value, $args[2][$i]) : $args[0]($value);
				}
				$i++;
			}
		}
		return $args[1];
	}
}

// php 4.3.0
if ( !function_exists('html_entity_decode') )
{
	function html_entity_decode($given_html, $quote_style = ENT_QUOTES)
	{
		$trans_table = array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style));
		$trans_table['&#39;'] = '\'';
		return (strtr($given_html, $trans_table));
	}
}

?>