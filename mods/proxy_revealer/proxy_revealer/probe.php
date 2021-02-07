<?php
/***************************************************************************
 *                                probe.php
 *                            -------------------
 *   begin                : Thursday, Aug 17, 2006
 *   copyright            : (C) MMVI TerraFrost
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

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

if ( !isset($HTTP_GET_VARS['extra']) || !preg_match('/^[A-Za-z0-9,]*$/',trim($HTTP_GET_VARS['extra'])) )
{
	// since we're not user-facing, we don't care about debug messages
	die();
}

list($sid,$key) = explode(',',trim($HTTP_GET_VARS['extra']));

$board_config['server_port'] = trim($board_config['server_port']);

$server_name = trim($board_config['server_name']);
$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
$server_port = ($board_config['server_port'] != 80) ? ':' .$board_config['server_port'] : '';
$path_name = '/' . preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
$path_name.= ($path_name != '') ? '/' : '';

$server_url = $server_protocol . $server_name . $server_port . $path_name;

// according to <http://www.cl.cam.ac.uk/~mgk25/unicode.html>, "the [Universal Character Set] characters U+0000 to U+007F are identical to those in 
// US-ASCII (ISO 646 IRV) and the range U+0000 to U+00FF is identical to ISO 8859-1 (Latin-1)", where "ISO-8859-1 is (according to the standards at least)
// the default encoding of documents delivered via HTTP with a MIME type beginning with "text/"" <ref: http://en.wikipedia.org/wiki/ISO_8859-1#ISO-8859-1>
// (ie. the charset with which chr(0x80 - 0xFF) are most likely to be interpreted with).  since <http://tools.ietf.org/html/rfc2781#section-2> defines each character
// whose Universal Character Set value is equal to and lower than U+FFFF to be a "single 16-bit integer with a value equal to that of the character number",
// adding a chr(0x00) before each character should be sufficient to convert any string to UTF-16 (assuming the byte order mark is U+FEFF).
function iso_8859_1_to_utf16($str)
{
	// the first two characters represent the byte order mark
	return chr(0xFE).chr(0xFF).chr(0).chunk_split($str, 1, chr(0));
}

// according to <http://en.wikipedia.org/wiki/Base64#UTF-7>, "[UTF-7] is used to encode UTF-16 as ASCII characters for use in 7-bit transports such as SMTP".
// <http://betterexplained.com/articles/unicode/> provides more information.  in a departure from the method described there, everything, regardless of whether or
// not it's within the allowed U+0000 - U+007F range is encoded to base64.
function iso_8859_1_to_utf7($str)
{
	return '+'.preg_replace('#=+$#','',base64_encode(substr(iso_8859_1_to_utf16($str),2))).'-';
}

// $ip_address, in the following function, corresponds to the "real IP address".  $info corresponds to the "fake IP address".
// in admin_speculative.php, the first column shows the "fake IP address" and the third column shows the "real IP address".
// the reason we do it in this way is because when you're looking at the IP address of a post, you're going to see the 
// "fake IP address".
function insert_ip($ip_address,$mode,$info,$secondary_info = '')
{
	// sessions.php only checks the first 24-bits of an IP address and so to shall we.
	// do a search for vHiker, in sessions.php, to see the specific code it uses.
	// per this, if you're looking through some log files trying to see what a particular use did, do a search for the first three
	// parts of an IP address (eg. if 128.128.128.4 did something, search for 128.128.128. to see what other things they
	// might have done since they could technically still be logged in with 128.128.128.4 and 128.128.128.199)
	if ((ip2long($info) & 0xFFFFFF00) == (ip2long($ip_address) & 0xFFFFFF00))
	{
		return;
	}

	global $db, $client_ip, $sid, $key, $board_config;

	$ip_address = encode_ip($ip_address);

	// in java, atleast, there's a possibility that the main IP we're recording and the "masked" IP address are the same.
	// the reason this function would be called, in those cases, is to log $_GET['local'].   $_GET['local'], however,
	// isn't reliable enough to block people over (assuming any blocking is taking place).  As such, although we log it,
	// we don't update phpbb_sessions.
	if ( $mode != JAVA_INTERNAL )
	{
		// session_speculative_test will eventually be used to determine whether or not this session ought to be
		// banned.  this check is performed by performing a bitwise and against $board_config['ip_block'].  if
		// the bits that represent the varrious modes 'and' with any of the bits in the bitwise representation of
		// session_speculative_test, a block is done.  to guarantee that each bit is unique to a specific mode,
		// powers of two are used to represent the modes (see constants.php).
		$sql = "UPDATE ".SESSIONS_TABLE." 
			SET session_speculative_test = session_speculative_test | $mode 
			WHERE session_id = '$sid'
				AND session_speculative_key = '$key'";
		if ( !($result = $db->sql_query($sql)) )
		{
			die();
		}

		// if neither the session_id or the session_speculative_key are valid (as would be revealed by $db->sql_numrows being 0),
		// we assume the information is not trustworthy and quit.
		if ( !$db->sql_affectedrows($result) )
		{
			die();
		}

		// ban, if appropriate
		if ( $board_config['ip_ban'] && ($mode & $board_config['ip_block']) )
		{
			$sql = "SELECT * FROM " . BANLIST_TABLE . " 
				WHERE ban_ip = '$ip_address'";
			if ( !($db->sql_query($sql)) )
			{
				die();
			}

			if ( !$db->sql_numrows() )
			{
				$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_ip) 
					VALUES ('$ip_address')";
				if ( !$db->sql_query($sql) )
				{
					die();
				}
				$sql = "DELETE FROM " . SESSIONS_TABLE . " 
					WHERE session_ip = '$ip_address'";
				if ( !$db->sql_query($sql) )
				{
					die();
				}
			}
		}
	}

	$sql = "SELECT * FROM ".SPECULATIVE_TABLE." 
		WHERE ip_address = '$ip_address' 
			AND method = $mode  
			AND real_ip = '$info'";
	if ( !($result = $db->sql_query($sql)) )
	{
		die();
	}

	if ( !$db->sql_numrows($result) )
	{
		$secondary_info = ( !empty($secondary_info) ) ? "'$secondary_info'" : 'NULL';

		$sql = "INSERT INTO ".SPECULATIVE_TABLE." (ip_address, method, discovered, real_ip, info) 
			VALUES ('$ip_address', $mode, ".time().", '$info', $secondary_info)";
		if ( !$db->sql_query($sql) )
		{
			die();
		}
	}
}

// this pass concerns itself with x_forwarded_for, which may be able to identify transparent http proxies.
// $client_ip represents our current "spoofed" address and $_SERVER['HTTP_X_FORWARDED_FOR'] represents our possibly "real"
// address
if ( !empty($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR']) && $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'] != $client_ip )
{
	$x_forwarded_for = str_replace("\'","''",htmlspecialchars(addslashes($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])));

	insert_ip($client_ip,X_FORWARDED_FOR,$x_forwarded_for);
}

$mode = isset($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : '';

switch ($mode):
	case 'java':
		$info = htmlspecialchars($HTTP_GET_VARS['user_agent']).'<>'.htmlspecialchars($HTTP_GET_VARS['vendor']).'<>'.htmlspecialchars($HTTP_GET_VARS['version']);

		// here, we're not trying to get the "real" IP address - we're trying to get the internal LAN
		// IP address.  it might make more sense if we logged $client_ip instead of $_GET['ip'], but whatever.
		if ( !empty($HTTP_GET_VARS['local']) && $HTTP_GET_VARS['local'] != $client_ip )
		{
			insert_ip($HTTP_GET_VARS['ip'],JAVA_INTERNAL,str_replace("\'","''",htmlspecialchars($HTTP_GET_VARS['local'])),$info);
		}

		// $_GET['ip'] represents our old "spoofed" address and $client_ip represents our current "real" address.
		// if they're different, we've probably managed to break out of the HTTP proxy, so we log it.
		if ( $HTTP_GET_VARS['ip'] != $client_ip )
		{
			insert_ip($HTTP_GET_VARS['ip'],JAVA,$client_ip,$info);
		}

		exit;
	case 'xss':
		header('Content-Type: text/html; charset=ISO-8859-1');

		$schemes = array('http','https'); // we don't want to save stuff like javascript:alert('test')

		$xss_info = $xss_glue = '';
		// we capture the url in the hopes that it'll reveal the location of the cgi proxy.  having the
		// location gives us proof that we can give to anyone (ie. it shows you how to make a post
		// from that very same ip address)
		if ( !empty($HTTP_SERVER_VARS['HTTP_REFERER']) )
		{
			$parsed = parse_url($HTTP_SERVER_VARS['HTTP_REFERER']);
			// if one of the referers IP addresses are equal to the server, we assume they're the same.
			if ( !in_array($HTTP_SERVER_VARS['SERVER_ADDR'],gethostbynamel($parsed['host'])) && in_array($parsed['scheme'], $schemes) )
			{
				$xss_info = str_replace("\'","''",htmlspecialchars(addslashes($HTTP_SERVER_VARS['HTTP_REFERER'])));
				$xss_glue = '<>';
			}
		}

		if ( !empty($HTTP_GET_VARS['url']) )
		{
			$parsed = parse_url($HTTP_GET_VARS['url']);
			// if one of the referers IP addresses are equal to the server, we assume they're the same.
			if ( !in_array($HTTP_SERVER_VARS['SERVER_ADDR'],gethostbynamel($parsed['host'])) && in_array($parsed['scheme'], $schemes) )
			{
				$xss_info2 = str_replace("\'","''",htmlspecialchars($HTTP_GET_VARS['url']));
				$xss_info = ( $xss_info != $xss_info2 ) ? "{$xss_info}{$xss_glue}{$xss_info2}" : $xss_info;
			}
		}

		// $_GET['ip'] represents our old "spoofed" address and $client_ip represents our current "real" address.
		// if they're different, we've probably managed to break out of the CGI proxy, so we log it.
		if ( $HTTP_GET_VARS['ip'] != $client_ip )
		{
			insert_ip($HTTP_GET_VARS['ip'],XSS,$client_ip,$xss_info);
		}

		$java_url = $path_name . "probe.$phpEx?mode=java&amp;ip=$client_ip&amp;extra=$sid,$key";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title></title>
</head>

<body>
<applet width="0" height="0" code="HttpRequestor.class" codebase=".">
  <param name="domain" value="<?php echo $server_name; ?>">
  <param name="port" value="<?php echo $board_config['server_port']; ?>">
  <param name="path" value="<?php echo $java_url; ?>">
  <param name="user_agent" value="<?php echo htmlspecialchars($HTTP_SERVER_VARS['HTTP_USER_AGENT']); ?>">
</applet>
</body>
</html>
<?php
		exit;
	case 'utf16':
		header('Content-Type: text/html; charset=UTF-16');

		$javascript_url = $server_url . "probe.$phpEx?mode=xss&ip=$client_ip&extra=$sid,$key";
		$iframe_url = htmlspecialchars($javascript_url);

		$str = <<<DEFAULT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title></title>
</head>

<body>
<iframe src="$iframe_url" width="1" height="1" frameborder="0"></iframe>
<script>
  document.getElementsByTagName("iframe")[0].src = "$javascript_url&url="+escape(location.href);
</script>
</body>

</html>
DEFAULT;
		echo iso_8859_1_to_utf16($str);
		exit;
	case 'utf7':
		header('Content-Type: text/html; charset=UTF-7' . $$mode);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-7">
  <title></title>
</head>
<?php
		$javascript_url = $server_url . "probe.$phpEx?mode=xss&ip=$client_ip&extra=$sid,$key";
		$iframe_url = htmlspecialchars($javascript_url);

		$str = <<<DEFAULT

<body>
<iframe src="$iframe_url" width="1" height="1" frameborder="0"></iframe>
<script>
  document.getElementsByTagName("iframe")[0].src = "$javascript_url&url="+escape(location.href);
</script>
</body>
</html>
DEFAULT;
		echo iso_8859_1_to_utf7($str);
		exit;
endswitch;

$base_url = $server_url . "probe.$phpEx?extra=$sid,$key&mode=";
$utf7_url = htmlspecialchars($base_url . 'utf7');
$utf16_url = htmlspecialchars($base_url . 'utf16');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title></title>
</head>

<body>
<iframe src="<?php echo $utf7_url; ?>" width="1" height="1" frameborder="0"></iframe>
<iframe src="<?php echo $utf16_url; ?>" width="1" height="1" frameborder="0"></iframe>
</body>
</html>