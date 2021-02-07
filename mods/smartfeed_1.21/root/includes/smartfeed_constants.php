<?php 
/***************************************************************************
                           smartfeed_constants.php
                           -----------------------
    begin                : Fri, Nov 2, 2007
    copyright            : (c) Mark D. Hamill

    $Id: $

 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// smartfeed_constants.php
// Written by Mark D. Hamill, mhamill@computer.org
// This software is designed to work with phpBB Version 2.0.22

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

//
// *** Important: you MUST change this value to match the URL to your forums. Make sure there is a trailing / at the end ***
//

// Based on code in profile.php. Do not modify.
$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
$server_name = trim($board_config['server_name']);
$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
$server_url = $server_protocol . $server_name . $server_port . $script_name;
$server_url = (strrpos($server_url, '/') == (strlen($server_url)-1)) ? $server_url : $server_url . '/';
// Based on code in profile.php. Do not modify.

define('SMARTFEED_SITE_URL', $server_url);

define('SMARTFEED_VERSION','1.21'); // Do not change this
define('SMARTFEED_PAGE_URL', 'http://phpbb.potomactavern.org/smartfeed'); // Do not change this

// Override the Feed Creator Generator information to include info on this modification
define('TIME_ZONE',str_replace('.',':',sprintf("%+'06.2f",$board_config['board_timezone'])));
// Override the Feed Creator timezone to reflect the board timezone
define('FEEDCREATOR_VERSION', "SmartFeed phpBB Modification " . SMARTFEED_VERSION . " (mhamill@computer.org)");

// Caution do not change the next four values or you may get unexpected results from the feedcreator class, which expects these literals
define('SMARTFEED_ATOM_10_VALUE', 'ATOM1.0');
define('SMARTFEED_RSS_20_VALUE', 'RSS2.0');
define('SMARTFEED_RSS_10_VALUE', 'RSS1.0');
define('SMARTFEED_RSS_091_VALUE', 'RSS0.91');

// You may need to change the following defaults 
define('SMARTFEED_TTL','60'); // How many minutes to cache before refreshing the feed? Throttle the number up if your board is getting overwhelmed, but newsreaders may ignore your advice. Only works with RSS 2.0. 
define('SMARTFEED_MAX_ITEMS',0); // Set some upper bound on the number of items in a newsfeed. If 0, no limit. For heavily trafficked boards you may find you have to set a limit to keep the board from getting bogged down. Make sure this is a whole number.
define('SMARTFEED_DEFAULT_FETCH_TIME_LIMIT', time() - (24 * 60 * 60));  // If the fetch is being done by someone who is not registered, and no cookie is set, this will set a point in time beyond which no posts will be retrieved. Otherwise it could take minutes or hours to try to assemble a newsfeed for every message in every public forum in your database. The default is to go back one day.
define('SMARTFEED_RFC1766_LANG', 'en-US'); // Language of feed content. Use only values at http://www.w3.org/TR/REC-html40/struct/dirlang.html#langcodes
define('SMARTFEED_FAKE_EMAIL', 'noreply@' . trim($board_config['server_name'])); // Used when an email address is required for a RSS 0.91 feed, but phpBB profile for user says not to show it
define('SMARTFEED_FEED_IMAGE_PATH', 'templates/subSilver/images/logo_phpBB.gif'); // The phpBB icon (or the image you substituted for it) is used by default for the newsfeed's image.
define('SMARTFEED_REQUIRE_IP_AUTHENTICATION', false); // Set to true to ensure that feed only works for a given IP domain, ex: 123.45.67.*
define('SMARTFEED_SHOW_USERNAME_IN_REPLIES', true); // If you set this to false, user names will not appear in replies. This could be dangerous because the newsreader may choose not to show the authors of individual items in the feed, so you would be disabling this for ALL readers.
define('SMARTFEED_PRIVACY_MODE', true); // If true, email addresses are not shown in the feed for public users and a fake email address is substituted if necessary to validate the feed. Signature blocks are not shown to public users. This is set to true by default. The idea is to keep spammers from having yet another way to harvest email addresses.
define('SMARTFEED_SUPPRESS_FORUM_NAMES', false); // By default the forum name appears in the item title. To suppress it, set this value to true.
define('SMARTFEED_ADVERTISING_INFO_PATH', 'cache/smartfeed_advertising.txt'); // where ad configuration information is stored. The data is serialized in this file and the directory needs full public write permissions. Serialization avoids the overhead of a database.
define('SMARTFEED_HIDE_ADVERTISING_INTERFACE', false); // Set this to true if your board will never display ads. That way you will not see the interface and no ads will ever appear in newsfeeds.
define('SMARTFEED_SHOW_USERNAME_IN_FIRST_TOPIC_POST', true); // If you set this to false, user names will not appear in first topic posts. This could be dangerous because the newsreader may choose not to show the authors of individual items in the feed, so you would be disabling this for ALL readers.

// End copied code

?>