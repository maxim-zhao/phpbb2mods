<?php
/***************************************************************************
 *                                spell-gw.php
 *                            -------------------
 *   begin                : Friday, May 21, 2004
 *   copyright            : (C) 2004-2005 Craig Nuttall, spellingCow.com
 *   version              : 1.6.0 - March 12th, 2005
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


// register a spellingcow.com account and put the account name here
define('ADMIN_USERNAME', 'insert-admin-username') ;	// EXAMPLE:     define('ADMIN_USERNAME', 'nuttzy99') ;

define('SHUTDOWN_AUTOCHECK', false) ;		// 'true' will disable the autochecking option for ALL users regardless of
								//   their profile settings; use this switch if you don't have an ACP option

define('DEFAULT_SPELL_LANG', 'EN_US') ;		// en_us=American; en_gb=British; en_ca=Canadian; full list at ?????
define('OVERRIDE_LANG', false) ;			// override the GET data from the button;  not sure why anyone would do this

// at this point you could get creative.  say you have different forums for different languages.  At this point you could
//	send and get the forumid and set a different language for each forum!  Pretty cool MOD for someone to write ;-)


/*
	Hello!  If you are viewing this file then you are probably wondering what it is doing.  This proggie serves as a
	gateway between your site and spellingCow.com.  The spell checking engine resides on spellingCow.com and processes
	all the spell checking transactions.  However, because of javascript security measures, spellingCow.com does not have
	access to directly update the textbox being spellchecked.  Therefore this program simply passes the request along to
	spellingCow.com for the engine to process.  Then this program acts like a web scraper and displays the screen
	properly.  The key thing is that now when the spell checking is complete, the request to update the textbox with the
	newly spell checked text comes from the this site, not spellingCow.com.  Therefore no javascript access violation ;-)

	I hope that helps!
	-Nuttzy
*/




define('UNREACHABLE', 'Sorry! The host [%s] could not be reached.  Please try again later.') ;
define('VERSION', '1.6.0') ;
define('EXE_HOST', 'www.spellingcow.com') ;
define('EXE_PATH', '/phpBB2') ;
define('COOKIENAME', 'spellingcow_prefs') ;
define('COOKIEPATH', '/') ;



// this fundtion is taken from http://ch.php.net/strip-tags: THANK YOU tREXX [www.trexx.ch] AND Tony Freeman
function removeEvilAttributes($tagSource)
{
	// Disallow these attributes/prefix within a tag
	$stripAttrib = 'javascript:|onclick|ondblclick|onmousedown|onmouseup|onmouseover|' . 
		'onmousemove|onmouseout|onkeypress|onkeydown|onkeyup|src|href|background=';
	$tagSource = stripslashes($tagSource);
	$tagSource = preg_replace("/$stripAttrib/", '', $tagSource);
	return $tagSource;
}


// this fundtion is taken from http://ch.php.net/strip-tags: THANK YOU tREXX [www.trexx.ch] AND Tony Freeman
function removeEvilTags($source)
{
	//Allow these tags
	$allowedTags='<br><b><h1><h2><h3><h4><i><a><li><ol><p><strong><table><tr><td><th><u><ul>' . 
		'<pre><hr><blockquote><style><title><div>';
	$source = strip_tags($source, $allowedTags);
	return preg_replace('/<(.*?)>/ie', "'<'.removeEvilAttributes('\\1').'>'", $source);
}


// remove the javascript; doesn't cause a problem, just makes our output look ugly
function remove_script( $source)
{
	$newsource = '' ;
	$lower_source = strtolower( $source) ;
	$start_pos = 0 ;
	$start_script = strpos( $lower_source, '<script') ;
	$next_script = strpos( $lower_source, '<script', $start_script+1) ;
	$end_script = strpos( $lower_source, '/script>') ;
	$end_pos = ($end_script) ? $end_script+8 : 0 ;

// NOTE: a script within a script will break things :(  not too big a deal, just looks ugly - should be recursive
//  going to need one more revisions to fix this
	while (($end_script > $start_script) && ($end_script < $next_script))
	{
		$newsource .= substr($source, $start_pos, $start_script) ;
		$source = substr($source, $end_pos) ;
		$lower_source = strtolower( $source) ;

		$start_script = strpos( $lower_source, '<script') ;
		$next_script = strpos( $lower_source, '<script', $start_script+1) ;
		$end_script = strpos( $lower_source, '/script>') ;
		$end_pos = ($end_script) ? $end_script+8 : $end_pos ;
	}
	$newsource .= substr($source, $end_pos) ;
	return $newsource ;
}


function scrape_page( $host, $path, $display, $vars)
{
	// set vars
	$port = 80 ;

	// set the boundry tag; I learned how to do the formatting for the POST data from
	// 	http://us3.php.net/manual/en/function.fsockopen.php; sir_reality2001 at yahoo dot com;  THANK YOU!
	srand((double)microtime()*1000000);
	$boundary = "---------------------------".substr(md5(rand(0,32000)),0,10);

	// assemble the POST data
	$data = '' ;
	while(list($key, $value) = each( $vars)) 
	{
		$data .= "content-disposition: form-data; name=\"$key\"\r\n\r\n" . stripslashes($value) . "\r\n--$boundary\r\n";
	}
	$data = ($data != '') ? ("--$boundary\r\n" . $data) : '' ;

	// get the UA and referer so we pass along accurate info (well... accurate as possible ;-))
	$user_agent = (isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) ? $HTTP_SERVER_VARS['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT') ;
	$referer = (isset($HTTP_SERVER_VARS['HTTP_REFERER'])) ? $HTTP_SERVER_VARS['HTTP_REFERER'] : getenv('HTTP_REFERER') ;


	// connect to spellingCow and pass along the POST data; I learned how to do make the simple web page scraper from
	// 	http://us3.php.net/manual/en/function.fsockopen.php; markus dot welsch at suk dot de;  THANK YOU!
	$errno = 0 ;
	$errstr = '' ;
	$fp= fsockopen( $host, $port, $errno, $errstr, 10) ;

	// make sure we connected!  If not, then get us out of here!
	if (!$fp)
	{
		// display error message
		echo '<br><br><br><center><h2>' . sprintf( UNREACHABLE, $host) . "</h2></center>\n" ;

		// yikes!  if you have auto check on and can't reach our server, then we need to make sure your site
		//   can submit posts!
		global $HTTP_GET_VARS ;
		$auto = ( !empty($HTTP_GET_VARS['auto'])) ? htmlspecialchars($HTTP_GET_VARS['auto']) : '' ;

		// if auto check then add the javascript that will submit NOW!
		if ($auto == 'check')
		{
			$form = ( !empty($HTTP_GET_VARS['form'])) ? htmlspecialchars($HTTP_GET_VARS['form']) : '' ;
			$button = ( !empty($HTTP_GET_VARS['button'])) ? htmlspecialchars($HTTP_GET_VARS['button']) : '' ;

			$js_code = "
				<script language=\"javascript\" type=\"text/javascript\">
				<!--
					window.close();
					opener.document.forms['$form'].auto_spell_check.value = 0 ;
					opener.document.forms['$form'].$button.click() ;
				//-->
				</script>" ;
			echo "$js_code\n" ;
		}

		exit ;
	}

	$method = ( count($vars)==0) ? 'GET' : 'POST' ;
	// send the header
	fputs( $fp, "$method $path HTTP/1.0\r\n") ;
	fputs( $fp, "Host: $host\r\n") ;
	fputs( $fp, "User-Agent: $user_agent\r\n") ;
	fputs( $fp, "Referer: $referer\r\n") ;
	if ($data == '')
	{
		fputs( $fp, "\r\n\r\n") ;
	}
	else
	{
		fputs( $fp, "Content-Type: multipart/form-data; boundary=$boundary\r\n") ;
		fputs( $fp, "Content-length: " . strlen($data) . "\r\n") ;
		fputs( $fp, "\r\n$data\r\n") ;
	}

	// grab the headers, but we don't need them (not very interesting anyway ;-)  )
	$tmp_headers = '' ;
	while ($str = trim(fgets( $fp, 4096)))
	{
		$tmp_headers .= "$str\r\n" ;
	}

	// scrape the web page data
	$tmp_body = '' ;
	while (!feof($fp))
	{
		$tmp_body .= fgets( $fp, 4096) ;
	}

	// clean up
	fclose( $fp) ;


	if ( $display == 'noevil')
	{
		if ($tmp_body == '')
		{
			scrape_page( 'www.spellingcow.com', '/index.php', 'noevil', array()) ;
		}
		else
		{
			$tmp_body = remove_script( $tmp_body) ;
			echo removeEvilTags( $tmp_body) . "\n" ;
		}
	}
	else if ($display == 'control')
	{
		return $tmp_body ;
	}
	else if ($display == 'verbatim')
	{
		echo "$tmp_body\n" ;
	}
	else
	{
		echo "<h2>Why are you messing around?</h2>\n" ;
		echo "display=[$display]<br>\n" ;
		exit ;
	}

	return '' ;
}


// this function gets the SPELLINGCOW userdata only and doesn't touch anything else of your site's cookies
function cookie_monster()
{
	global $HTTP_COOKIE_VARS ;

	$sessiondata = isset( $HTTP_COOKIE_VARS[COOKIENAME] ) ? unserialize(stripslashes($HTTP_COOKIE_VARS[COOKIENAME])) : array('autologinid' => '', 'user_id' => -1);
	return $sessiondata ;
}


// we successfully logged in, so update cookie data
function mark_login()
{
	global $HTTP_POST_VARS ;

	$user_id = ( !empty($HTTP_POST_VARS['user_id'])) ? intval($HTTP_POST_VARS['user_id']) : 0 ;
	$autologinid = ( !empty($HTTP_POST_VARS['autologinid'])) ? $HTTP_POST_VARS['autologinid'] : '' ;

	$sessiondata = array('autologinid' => $autologinid, 'user_id' => $user_id);
	$current_time = time();

	setcookie( COOKIENAME, serialize($sessiondata), $current_time + 31536000, COOKIEPATH);
/*
	$serialized = serialize($sessiondata) ; 
echo "moo!" ;
	if (!setcookie( COOKIENAME, $serialized, $current_time + 31536000, COOKIEPATH)) 
	{ 
       echo "setcookie failed!  serialized=[$serialized]" ; 
       exit ; 
    }
echo "moo!2" ;
exit ;
*/
	return array('autologinid' => $autologinid, 'user_id' => $user_id) ;
}


// they clicked loggout, so delete the cookie
function logout()
{
	$sessiondata = array('autologinid' => '', 'user_id' => 0);
	$current_time = time();

	setcookie( COOKIENAME, serialize($sessiondata), $current_time - 31536000, COOKIEPATH);
}


// easily spoofed, yada, yada, yada... i know ;-)
// This is the phpBB code to get IP. The vBulliten code isn't any more reliable since there's no way to prevent spoofing.
//	If you are certain you know a way, be sure to let me know, but you are probably wrong ;-)
function getip()
{
	global $HTTP_SERVER_VARS ;

	if( getenv('HTTP_X_FORWARDED_FOR') != '' )
	{
		$client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : $REMOTE_ADDR );

		$entries = explode(',', getenv('HTTP_X_FORWARDED_FOR'));
		reset($entries);
		while (list(, $entry) = each($entries)) 
		{
			$entry = trim($entry);
			if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
			{
				$private_ip = array('/^0\./', '/^127\.0\.0\.1/', '/^192\.168\..*/', '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/', '/^10\..*/', '/^224\..*/', '/^240\..*/');
				$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);	

				if ($client_ip != $found_ip)	
				{
					$client_ip = $found_ip;
					break;
				}
			}
		}
	}
	else
	{
		$client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : $REMOTE_ADDR );
	}
	return $client_ip ;
}







//////////////////////////                           ///////////////////////////////
////////////////////////// - start program propper - ///////////////////////////////
//////////////////////////                           ///////////////////////////////


// get the mode; mostly we are checking to see if it is getdata otherwise we don't care
$mode = ( !empty($HTTP_GET_VARS['mode'])) ? htmlspecialchars($HTTP_GET_VARS['mode']) : '' ;
$page = ( !empty($HTTP_GET_VARS['page'])) ? intval($HTTP_GET_VARS['page']) : 0 ;
$page = ($page > 10) ? 0 : $page ;

// we'll do further data validation on these server side, so don't get any ideas ;-)
$form = ( !empty($HTTP_GET_VARS['form'])) ? htmlspecialchars($HTTP_GET_VARS['form']) : (( !empty($HTTP_POST_VARS['form'])) ? htmlspecialchars($HTTP_POST_VARS['form']) : '' ) ;
$source = ( !empty($HTTP_GET_VARS['source'])) ? htmlspecialchars($HTTP_GET_VARS['source']) : (( !empty($HTTP_POST_VARS['source'])) ? htmlspecialchars($HTTP_POST_VARS['source']) : '' ) ;
$button = ( !empty($HTTP_GET_VARS['button'])) ? htmlspecialchars($HTTP_GET_VARS['button']) : (( !empty($HTTP_POST_VARS['button'])) ? htmlspecialchars($HTTP_POST_VARS['button']) : '' ) ;
$type = ( !empty($HTTP_GET_VARS['type'])) ? htmlspecialchars($HTTP_GET_VARS['type']) : (( !empty($HTTP_POST_VARS['type'])) ? htmlspecialchars($HTTP_POST_VARS['type']) : '' ) ;
$auto = ( !empty($HTTP_GET_VARS['auto'])) ? htmlspecialchars($HTTP_GET_VARS['auto']) : (( !empty($HTTP_POST_VARS['auto'])) ? htmlspecialchars($HTTP_POST_VARS['auto']) : '' ) ;
$HTTP_POST_VARS['rsz'] = ( isset($HTTP_GET_VARS['rsz'])) ? intval($HTTP_GET_VARS['rsz']) : 0 ;
$HTTP_POST_VARS['form'] = $form ;
$HTTP_POST_VARS['source'] = $source ;
$HTTP_POST_VARS['button'] = $button ;
$HTTP_POST_VARS['type'] = $type ;
$HTTP_POST_VARS['auto'] = $auto ;
$HTTP_POST_VARS['sc_version'] = VERSION ;
$HTTP_POST_VARS['site_admin'] = ADMIN_USERNAME ;
$HTTP_POST_VARS['install_server'] = getenv('SERVER_NAME') ;
$HTTP_POST_VARS['install_script'] = getenv('SCRIPT_NAME') ;
$HTTP_POST_VARS['install_port'] = getenv('SERVER_PORT') ;
$HTTP_POST_VARS['user_ip'] = getip() ;
$user_data = array() ;


// first of all, if we are autochecking and autocheck is shutdown, then bailout!
if (($auto == 'check') && (SHUTDOWN_AUTOCHECK))
{
	echo "<center><h3>Auto checking disabled.  Submitting post unchecked.</h3></center>" ;
	$js_code = "
		<script language=\"javascript\" type=\"text/javascript\">
		<!--
			setTimeout('window.close()', 2000) ;
			opener.document.forms['$form'].auto_spell_check.value = 0 ;
			opener.document.forms['$form'].$button.click() ;
		//-->
		</script>" ;
	echo "$js_code\n" ;
	exit ;
}


// if we successfully logged in, then do update
$login = ( !empty($HTTP_POST_VARS['login'])) ? intval($HTTP_POST_VARS['login']) : 0 ;
if ($login == 1)
{
	$user_data = mark_login() ;
}



//
// now for the meat of the proggie
//

if ($mode == 'load')
{
	$spell_lang = (isset($HTTP_GET_VARS['spell_lang'])) ? htmlspecialchars($HTTP_GET_VARS['spell_lang']) : DEFAULT_SPELL_LANG ;
	$spell_lang = ( OVERRIDE_LANG ) ? DEFAULT_SPELL_LANG : $spell_lang ;
	$params = 'form=' . $form . '&source=' . $source . '&button=' . $button . '&type=' . $type . '&spell_lang=' . $spell_lang . '&auto=' . $auto ;
	scrape_page( EXE_HOST, EXE_PATH . '/spell-body.php?' . $params, 'verbatim', $HTTP_POST_VARS) ;
}
else if ($mode == 'getdata')
{
	if (!$login)
	{
		$user_data = cookie_monster() ;
	}

	if (count($user_data) != 0)
	{
		$HTTP_POST_VARS['user_id'] = $user_data['user_id'] ;
		$HTTP_POST_VARS['autologinid'] = $user_data['autologinid'] ;
	}

	$HTTP_POST_VARS['spell_lang'] = htmlspecialchars($HTTP_GET_VARS['spell_lang']) ;
	scrape_page( EXE_HOST, EXE_PATH . '/spell.php?mode=getdata', 'verbatim', $HTTP_POST_VARS) ;
}
else if (($mode == 'nav') || ($mode == ''))
{
	$frame = ($mode == '') ? '/spell-frame.php' : '/spell-nav.php' ;
	$content_host = ($page == 0) ? getenv('SERVER_NAME') : EXE_HOST ;
	$content_page = ($page == 0) ? '/' : EXE_PATH . '/spell-page' . $page . '.php' ;
	scrape_page( EXE_HOST, EXE_PATH . $frame, 'verbatim', $HTTP_POST_VARS) ;
	scrape_page( $content_host, $content_page, 'noevil', array()) ;
	echo "</body></html>" ;
}
else if ($mode == 'test')
{
	echo "spell-gw is present<br>\n" ;
	exit ;
}
else if ($mode == 'auth')
{
	echo md5( ADMIN_USERNAME) ;
	exit ;
}
else if ($mode == 'login')
{
	$username = ( !empty($HTTP_POST_VARS['username'])) ? $HTTP_POST_VARS['username'] : '' ;
	$autologinid = ( !empty($HTTP_POST_VARS['autologinid'])) ? $HTTP_POST_VARS['autologinid'] : '' ;
	if ( isset($HTTP_POST_VARS['login']))
	{
		$HTTP_POST_VARS['username'] = $username ;
		$HTTP_POST_VARS['autologinid'] = md5( $autologinid) ;
		scrape_page( EXE_HOST, EXE_PATH . '/spell.php?mode=login', 'verbatim', $HTTP_POST_VARS) ;
	}
	else if ( isset($HTTP_POST_VARS['register']))
	{
		scrape_page( EXE_HOST, EXE_PATH . '/spell.php?mode=register', 'verbatim', $HTTP_POST_VARS) ;
	}
	else
	{
		echo "blah<br>\n" ;
	}
}
else if ($mode == 'logout')
{
	if (!$login)
	{
		$user_data = cookie_monster() ;
	}

	if (count($user_data) != 0)
	{
		$HTTP_POST_VARS['user_id'] = $user_data['user_id'] ;
		$HTTP_POST_VARS['autologinid'] = $user_data['autologinid'] ;
	}
	logout() ;
	scrape_page( EXE_HOST, EXE_PATH . '/spell.php?mode=logout', 'verbatim', $HTTP_POST_VARS) ;
}
else if ($mode == 'register')
{
	scrape_page( EXE_HOST, EXE_PATH . '/spell.php?mode=register', 'verbatim', $HTTP_POST_VARS) ;
}
else
{
	if ( $mode == 'display_get')
	{
		$HTTP_POST_VARS['message'] = $HTTP_GET_VARS['message'] ;
		$HTTP_POST_VARS['spell_lang'] = (isset($HTTP_GET_VARS['spell_lang'])) ? htmlspecialchars($HTTP_GET_VARS['spell_lang']) : DEFAULT_SPELL_LANG ;
	}

	$HTTP_POST_VARS['auto_check'] = ( !empty($HTTP_POST_VARS['auto'])) ? htmlspecialchars($HTTP_POST_VARS['auto']) : '' ;
	if (($mode == 'sendpass') || ($mode == 'passthru'))
	{
		$spell_id = ( !empty($HTTP_GET_VARS['spell_id'])) ? intval($HTTP_GET_VARS['spell_id']) : -1 ;
		$session_id = ( !empty($HTTP_GET_VARS['session_id'])) ? htmlspecialchars($HTTP_GET_VARS['session_id']) : '' ;
		$HTTP_POST_VARS['spell_id'] = $spell_id ;
		$HTTP_POST_VARS['session_id'] = $session_id ;
		$HTTP_POST_VARS['mode'] = ($mode == 'passthru') ? 'passthru' : 'logout' ;
	}

	if (!$login)
	{
		$user_data = cookie_monster() ;
	}

	if (count($user_data) != 0)
	{
		$HTTP_POST_VARS['user_id'] = $user_data['user_id'] ;
		$HTTP_POST_VARS['autologinid'] = $user_data['autologinid'] ;
	}
	scrape_page( EXE_HOST, EXE_PATH . '/spell.php', 'verbatim', $HTTP_POST_VARS) ;
}


exit ;
?>