<?php
############################################################## 
## MOD Title: phpBBToGo 
## MOD Author: timconstan <tim@togoslo.com> (Tim Constantine) http://www.togosolo.com
## MOD Description: 
## 	phpBBToGo is a phpBB mod that lets phpBB web sites display phpBB forums, 
## 		in a mobile web-site friendly format.
## 	It's a turnkey solution for transforming phpBB into a highly customizable, 
## 		mobile web portal.
## 	phpBBToGo will allow your phpBB community members to view your phpBB 
## 		content anytime/anywhere - even without a mobile internet connection!
##
## MOD Version: 1.2.1
## 
## Installation Level: easy 
## Installation Time: 5 Minutes 
## Files To Edit: phpbbtogo.php
## Included Files: phpbbtogo.php, forums.php, topics.php, 
##		thread.php, install.txt
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/downloads/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/downloads/ 
############################################################## 
## Author Notes: 
##
## FEATURES
## 	To name some of the features:
## 
## 	- displays topic title, post text and much more
## 	- select which forum(s) to display
## 	- uses phpBB smilies, bbcode and censored words
## 	- display a post on single page, or can span pages
## 	- optionally fetches posts between two dates
## 	- optionally trims postings after a given character 
## 		combination or a specific post length
## 	- can show, or hide, certain types of posts (like Normal, 
## 		Sticky, Announcements, Locked, & Moved)
## 	- show, or hide, poll results
## 	- customize page headers and footers 
## 	- optionally shows a built-in navigation bar
## 	- optionally shows user names and/or ranks
## 	- optionally shows post dates and/or times
## 	- displays topics sorted by date or subject
## 	- optionally fetches replies
## 	- optionally uses span pages
## 	- full control over all options
## 
## REQUIREMENTS
## 	This mod requires phpBB version 2.0.0 or above.
## 
## INSTALLATION
## 	See install.txt
## 
## OPTIONS
## 	MANY more options are documented in phpbbtogo.php.
## 
## SUPPORT
## 	Please visit the support and development forums at
## 
## 		http://phpBBToGo.ToGoSolo.com
## 
## FILE DESCRIPTIONS
##  install.txt
##		installation information
##
## 	phpbbtogo.php
## 		the core file
## 
## 	forums.php
## 		display list of forums
## 
## 	topics.php
## 		display list of topics
## 
## 	thread.php
## 		display topic thread
## 
## CREDITS
## 	phpBBToGo is based, in part, on phpbb_fetch_posts 
## 	by Ca5ey <ca5ey@clanunity.net> Volker Rattel
## 	http://clanunity.net
############################################################## 
## MOD History: 
## 1.0.0
## 		- Initial relase.  
##		- Not an official mod.
## 
## 1.1.0 (not released)
## 		- Uses this standard header
##		- Uses language file for internationalization
##		- Includes phpBB copyright meta tag
##
## 1.1.5
##		- ReadMe.txt file incorporated into this header area
##		- Fully utilizes phpBB DBAL for cross-database capability
##		- Fixes a display bug in forums.php when using bullets
##		- Fixes a display bug in topics.php when using bullets
##
## 1.1.6
##		- Created install.txt (no programming changes)
##
## 1.1.8
##		- Fixed a bug that was preventing mobilizing only 1
## 		  with a forum id other than "1"
##		- Added option to sort by date of last post
##		  Note: $CFG['sort_topics_alpha'] is now $CFG['sort_topics']
##
## 1.2.0
##      - Added default footer text
##		- Changed default $CFG['number_of_posts'] = 15; (was 10)
##		- Fixed a bug that was making the system ignore these settings:
##			- $CFG['show_author_on_topics'] = 0;
##			- $CFG['show_date_on_topics'] = 0;
##			- $CFG['show_time_on_topics'] = 0;
##
## 1.2.1
##      - Fixed a bug that was preventing posts from showing, under
##			certain conditions.
##
## 1.2.2
##      - Fixed a bug that was preventing smilies from showing, under
##			certain conditions.
##		- Standardized on $HTTP_GET_VARS[]; rather than _GET[];
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

//
// Configuration
// --------------------------------------------------------------
// Be sure to edit these options.
//

//
// The array of furums to show
//

$CFG['mobile_forums'] = array(1,2);

//
// This path points to the directory where phpBB is installed. Do
// not enter an URL here. The path must end with a trailing
// slash.
//
// Examples:
// forum in /aaa/bbb/ccc/ and script in /aaa/bbb/ccc/
// --> $phpbb_root_path = './';
// forum in /aaa/bbb/ccc/ and script in /aaa/bbb/
// --> $phpbb_root_path = './ccc/';
// forum in /aaa/bbb/ccc/ and script in /aaa/bbb/ddd/
// --> $phpbb_root_path = '../ccc/';
//

$phpbb_root_path = '../phpBB2/';

//
// This setting is needed to make the smilies work properly.
// Enter the URL to your smilie directory without a trailing
// slash. If your smilies are in
// 'http://www.foobar.com/phpBB2/images/smiles' the correct path
// should be '/phpBB2/images/smiles'.
//

$CFG['smilie_url'] = '/phpBB2/images/smiles';

//
// The title of the mobile forums pages
//

$CFG['mobile_title'] = 'phpBBToGo';

//
// Use this option to show additional text at the top of the
// first Mobile Forums page.
//

$CFG['first_page_header'] = '';

//
// Use this option to show additional text at the bottom of the
// first Mobile Forums page.  Although not required, please consider
// leaving this text as-is, or simply adding to it.
//

$CFG['first_page_footer'] = 'Create your own mobile web site at www.togosolo.com!';

//
// Use this option to show additional text at the top of the
// each additional Mobile Forums page.
//

$CFG['next_page_header'] = '';

//
// Use this option to show additional text at the bottom of the
// each additional Mobile Forums page.  Although not required, please consider
// leaving this text as-is, or simply adding to it.
//

$CFG['next_page_footer'] = 'Create your own mobile web site at www.togosolo.com!';

//
// Show the date & time the user last updated 
// the forums on the mobile device.
// Useful if the user "syncs" to get content.
// 0 = disabled
//

$CFG['date_time_on_forum'] = 1;

//
// This lets you specify the date format in the output.
// See http://www.php.net/date for a reference.
//

$CFG['date_format'] = 'm/d';

//
// This lets you specify the time format in the output.
// See http://www.php.net/date for a reference.
//

$CFG['time_format'] = 'h:i A';

//
// Display normal postings?
//

$CFG['show_normal'] = 1;

//
// Display sticky topics?
// 0 = no, 1 = yes
//

$CFG['show_sticky'] = 0;

//
// Display announcement topics?
// 0 = no, 1 = yes
//

$CFG['show_announcement'] = 1;

//
// Display locked topics?
// 0 = no, 1 = yes
//

$CFG['show_locked'] = 1;

//
// Display moved topics (moved with shadow)?
// 0 = no, 1 = yes
//

$CFG['show_moved'] = 1;

//
// Display polls?
// 0 = no, 1 = yes
// 

$CFG['show_poll'] = 1;
$CFG['poll_footer'] = '';

//
// Show category names on list of forums
// 0 = disabled
//

$CFG['category_names'] = 1;

//
// Bullet list of forums
// 0 = disabled
//

$CFG['bullet_forums_list'] = 1;

//
// Bullet list of topics
// 0 = disabled
//

$CFG['bullet_topics'] = 1;

//
// If set, this will show the user name of the author
// on your mobile pages.
// 0 = Don't show
//

$CFG['show_author_on_topics'] = 0;
$CFG['show_author_on_thread'] = 1;

//
// If set, this will show the date posted
// on your mobile pages.
// 0 = Don't show
//

$CFG['show_date_on_topics'] = 0;
$CFG['show_date_on_thread'] = 1;

//
// If set, this will show the time posted
// on your mobile pages.
// 0 = Don't show
//

$CFG['show_time_on_topics'] = 0;
$CFG['show_time_on_thread'] = 1;

//
// If set, this will show the number of comments 
// on the list of topics page.
// 0 = Don't show
//

$CFG['show_comments'] = 1;

//
// Fetch user rank title
//
// IMPORTANT:
//
// THIS WILL ONLY WORK IF EVERY USER FROM THE FETCHED POSTINGS
// HAS A VALID RANK. OTHERWISE THE POSTING WILL NOT BEEN FETCHED.
//
// 0 = no, 1 = yes
//

$CFG['show_ranks'] = 0;

//
// The next several options relate to a "Navigation Bar" that
// can be shown on all pages.
//

//
// If set, this will show the "Navigation Bar"
// on your mobile pages.
// 0 = Don't show
// 1 = Show
//

$CFG['show_nav_bar'] = 0;

//
// This will set the page alignment for the "Navigation Bar"
// on your mobile pages.
// 'left' = align left
// 'center' = align center
// 'right' = align right
//

$CFG['nav_bar_alignment'] = 'right';

//
// These settings can optionally provide a link back to
// your mobile version "Home Page" on the Navigation Bar.
// '' = No link back to a home page
//

$CFG['mobile_home_page_path'] = '';
$CFG['mobile_home_page_title'] = '';

//
// If the list of forums IS your mobile "Home Page"
// indicate that here, and rename forums.php to index.php.
// 0 = the list of forums is NOT your mobile "Home Page"
// 1 = the list of forums IS your mobile "Home Page"
//

$CFG['forums_is_index'] = 1;

//
// If there is only 1 forum, and the list of 
// topics for that forum IS your mobile "Home Page"
// indicate that here, and rename topics.php to index.php.
// 0 = the list of topics is NOT your mobile "Home Page"
// 1 = the list of topics IS your mobile "Home Page"
//

$CFG['topics_is_index'] = 0;

//
// Specify the amount of posts which will be fetched.
// Setting this to 0 will fetch all postings from a forum.
// If you are using span pages this value will determine the
// number of posts per page.
//

$CFG['number_of_posts'] = 15;

//
// If you are using "span_pages_thread" this value will determine the
// number of replies to display per page.
// Use in conjunction with "span_pages_thread".
//

$CFG['number_of_posts_thread'] = 10;

//
// Turn this on if you want to use the span pages feature
// in the list of topics within a forum.
// 0 = off, 1 = on
//

$CFG['span_pages'] = 1;

//
// Turn this on if you want to use the span pages feature
// in the list of replies within a topic.
// 0 = off, 1 = on
//

$CFG['span_pages_thread'] = 1;

//
// If set, this will cut off a posting text after the given
// character combination. Setting this to '<br />' will trim all
// postings after a linebreak. Trimming a posting can result in
// messing up the output if it cuts in the middle of a HTML tag.
// '' = disabled
//

$CFG['trim_character'] = '';

//
// If set, this will cut off the posting text shown
// on the list of topics page after the given
// character combination. Setting this to '<br />' will trim 
// posting after a linebreak. Trimming a posting can result in
// messing up the output if it cuts in the middle of a HTML tag.
// Use in conjunction with 'show_text_on_topics'.
// '' = disabled
//

$CFG['trim_for_topics_character'] = '';

//
// If set, this will cut off a posting text after the given
// number of characters. Setting this to '150' will therefor cut
// off the text after '150' characters. Trimming a posting can
// result in messing up your output if it cuts in the middle of
// a HTML tag. It is recommended for plain text postings only.
// Note: 'trim_number' comes after 'trim_character'. This means
// that the script will first trim for a character combination
// and then for the character amount. You should only use one of
// these methods at time.
// 0 = disabled
//

$CFG['trim_number'] = 0;

//
// If set, this will cut off a topic title after the given
// number of characters.
// 0 = disabled
//

$CFG['topic_trim_number'] = 0;

//
// If set this value determines the time a postings must have to
// be fetched. Setting this to
// $CFG['date_offset_start'] = time() - (14 * 24 * 60 * 60);
// all postings from the last 14 days will be fetched. You can
// combine this with the next CFG option to define a period. The
// start value has to be smaller than the end value:
// PAST (start) --> NOW (end)
//

$CFG['date_offset_start'] = '';

//
// If set this value determines the end period. Setting this to
// $CFG['date_offset_end'] = time() - (7 * 24 * 60 * 60);
// only postings older than seven days will be fetched.
// The default value for this option is
// $CFG['date_offset_end'] = time();
// to prevent (corrupt) postings with a future date from being
// fetched.
//

$CFG['date_offset_end'] = time();

//
// You can specify arbitrary search patterns like
// $CFG['search_string'] = 'pt.post_text LIKE \'%foobar%\'';
// which would only fetch posts which post text contains the word
// foobar. Be sure to escape single colons!
//
// SECURITY NOTE:
//
// CHOOSING WRONG STATEMENTS CAN TAKE DOWN YOUR DATABASE SERVER.
// IF YOU ARE USING THIS FEATURE BE 100% SURE WHAT YOU ARE DOING.
//

$CFG['search_string'] = '';

//
// If set, this will show text from the
// first post on the list of topics page.
// 0 = Don't show
//

$CFG['show_text_on_topics'] = 0;

//
// If set, this will cut off the posting text shown
// on the list of topics page after the given
// number of characters. Setting this to '150' will therefor cut
// off the text after '150' characters. Trimming a posting can
// result in messing up your output if it cuts in the middle of
// a HTML tag. It is recommended for plain text postings only.
// Note: 'trim_for_topics_number' comes after 'trim_for_topics_character'. This means
// that the script will first trim for a character combination
// and then for the character amount. You should only use one of
// these methods at time.
// Use in conjunction with 'show_text_on_topics'.
// 0 = disabled
//

$CFG['trim_for_topics_number'] = 0;

//
// Use this option if you do not wish to show
// replies to a topic on your mobile web site.
// Use in conjunction with 'show_text_on_topics'.
// 0 = disabled
//

$CFG['no_thread'] = 0;

//
// Sort topics alphabetically, rather than by date posted
// 0 = by date of first post
// 1 = alphabetically
// 2 = by date of post or latest reply (phpBB style)
//

$CFG['sort_topics'] = 0;

//
// Sort thread alphabetically, rather than by date posted
// 0 = disabled
//

$CFG['sort_thread_alpha'] = 0;

//
// Turn this on to close the DB connection after the posts have
// been fetched. If you are using the phpBB templates then phpBB
// will close the connection by itself.
// 0 = do not close DB connection, 1 = close DB connection
//

$CFG['close_db'] = 1;

//
// If turned on the script will check if a user has the
// permissions to view the fetched topics. This could result in
// an empty query result so be sure to check if the result
// contains values before you output everything.
// 0 = off, 1 = on
//

$CFG['use_auth'] = 0;

//
// NO CHANGES ARE NEEDED BELOW
//

//
// Internal field used for reference and debugging.
// DO NOT MODIFY
//

$CFG['sql'] = '';

//
// Internal field for storing the offset for span pages.
// DO NOT MODIFY
//

$CFG['offset'] = 0;
$CFG['offset_thread'] = 0;

//
// Internal field for storing the amount of postings for span
// pages.
// DO NOT MODIFY
//

$CFG['total'] = '';
$CFG['total_thread'] = '';

//
// Internal field for determining which function has been called.
// DO NOT MODIFY
//

$CFG['proc'] = '';

//
// Prevent invalid phpbb_root_path setting.
//

if (!file_exists($phpbb_root_path . 'extension.inc')) 
{
    die('<b>phpBB Fetch Posts Error:</b>
The $phpbb_root_path setting is wrong and DOES NOT point to your forum.');
}

//
// Include phpBB functions.
//

include_once ($phpbb_root_path . 'extension.inc');
include_once ($phpbb_root_path . 'common.'.$phpEx);
include_once ($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start session management.
//

if (!$userdata) 
{
    if ($CFG['phpbb_templates'] or $CFG['use_auth']) 
	{
        $userdata = session_pagestart($user_ip, PAGE_INDEX, $session_length);
    }
    init_userprefs($userdata);
}
		
//
// End session management.
//

//
// phpbb_fetch_forums - fetches information for one or more
// forums.
// --------------------------------------------------------------
// @param    mixed   the forum id could be a string (a single
//                   forum id) or an array (list of forum id's)
// @access   public
// @return   array   array of
//                         array of fetched forum ids
//                         & array of fetched names
//

function phpbb_fetch_forums($forum_id = '')
{

    global $CFG, $db;

    //
    // Set function identifier.
    //

    $CFG['proc'] = 'forums';

    //
    // Sanity check to prevent invalid parameters.
    //

    if (!$forum_id) 
	{
        die('<b>phpBB Fetch Forums Error:</b> Forum ID has not been specified.');
    }

    //
    // Create the list of forums.
    //

    if (!is_array($forum_id)) 
	{
    
         //
         // Check auth settings if required.
         //

        if ($CFG['use_auth']) 
		{
                $is_auth = auth(AUTH_READ, $forum_id, $userdata);
        } 
		else 
		{
                $is_auth['auth_read'] = 1;
        }

         if ($is_auth['auth_read']) 
		 {
             // Build SQL statement.

             $sql = 'SELECT
               f.forum_name,
               c.cat_title
             FROM
               ' . FORUMS_TABLE     . ' AS f,
               ' . CATEGORIES_TABLE     . ' AS c
             WHERE f.forum_id = '
              . $forum_id . ' AND c.cat_id = f.cat_id';

             $CFG['sql'] = $sql;

             if(!($result = $db->sql_query($sql))) 
			 {
                 die('<b>phpBB Fetch Forums Error:</b> Database query failed.');
             }
             
             if ($row = $db->sql_fetchrow($query)) 
			 {
                $forum_ids[] = $forum_id;
                $forum_names[] = $row['forum_name'];
                $cat_title[] = $row['cat_title'];
             }

           } // if ($is_auth['auth_read'])
        
    } 
	else 
	{
        for ($i = 0; $i < count($forum_id); $i++)
        {
		
         // Check auth settings if required.

         if ($CFG['use_auth']) 
		 {
                $is_auth = auth(AUTH_READ, $forum_id[$i], $userdata);
         } 
		 else 
		 {
                $is_auth['auth_read'] = 1;
         }

         if ($is_auth['auth_read']) 
		 {

             // Build SQL statement.

             $sql = 'SELECT
               f.forum_name,
               c.cat_title
             FROM
               ' . FORUMS_TABLE     . ' AS f,
               ' . CATEGORIES_TABLE     . ' AS c
             WHERE f.forum_id = '
              . $forum_id[$i] . ' AND c.cat_id = f.cat_id';

             $CFG['sql'] = $sql;

             if(!($result = $db->sql_query($sql))) 
			 {
                 die('<b>phpBB Fetch Forums Error:</b> Database query failed.');
             }

             if ($row = $db->sql_fetchrow($query)) 
			 {
                $forum_ids[] = $forum_id[$i];
                $forum_names[] = $row['forum_name'];
                $cat_title[] = $row['cat_title'];
             }

           } // if ($is_auth['auth_read'])
            
        }
    }

    //
    // Close DB connection
    //

    if ($CFG['close_db'] and !$CFG['phpbb_templates'] and !$CFG['proc'] == 'poll') 
	{
        $db->sql_close();
    }

    $forums = array(0=>$forum_ids,
               1=>$forum_names,
               2=>$cat_title);
               
    return $forums;

} // phpbb_fetch_forums

			
//
// phpbb_fetch_thread - fetches array of post_ids for a given topic.
// --------------------------------------------------------------
// @param    mixed   a single topic_id
// @access   public
// @return   array   array of fetched post ids
//

function phpbb_fetch_thread($topic_id = '')
{

    global $CFG, $db;

    //
    // Set function identifier.
    //

    $CFG['proc'] = 'thread';

    //
    // Sanity check to prevent invalid parameters.
    //

    if (!$topic_id) 
	{
        die('<b>phpBB Fetch Thread Error:</b> Topic ID has not been specified.');
    }

    //
    // Create the list of posts.
    //
    
   	$sql = "SELECT post_id FROM " . POSTS_TABLE;
    $sql = $sql . " WHERE topic_id = " . $topic_id;

    $CFG['sql'] = $sql;

    if(!($result = $db->sql_query($sql))) 
	{
       die('<b>phpBB Fetch Thread Error:</b> Database query failed.');
    }
    
    $posts_list = '';
    // Put results into a list
	while ($row = $db->sql_fetchrow($result))
	{
       $posts_list .= $row[post_id] . ',';
    }
    $posts_list = substr($posts_list, 0, strlen($posts_list) -1);

    //
    // Create the sql statement (WHERE clause).
    //
    
   $sql = ' t.topic_id = ' . $topic_id . ' AND
             p.post_id IN (' . $posts_list . ') AND
             p.poster_id = u.user_id AND
             p.post_id = pt.post_id AND ';
    
    if ($CFG['date_offset_start']) 
	{
        $sql .= ' p.post_time >= ' . $CFG['date_offset_start'] . ' AND';
    }
    if ($CFG['date_offset_end']) 
	{
        $sql .= ' p.post_time <= ' . $CFG['date_offset_end'] . ' AND';
    }
    if (!$CFG['show_normal']) 
	{
        $sql .= ' t.topic_type <> 0 AND';
    }
    if (!$CFG['show_sticky']) 
	{
        $sql .= ' t.topic_type <> 1 AND';
    }
    if (!$CFG['show_announcement']) 
	{
        $sql .= ' t.topic_type <> 2 AND';
    }
    if (!$CFG['show_locked']) 
	{
        $sql .= ' t.topic_status <> 1 AND';
    }
    if (!$CFG['show_moved']) 
	{
        $sql .= ' t.topic_status <> 2 AND';
    }
    if (!$CFG['show_poll']) 
	{
        $sql .= ' t.topic_vote <> 1 AND';
    }
    if ($CFG['search_string']) 
	{
        $sql .= ' (' . $CFG['search_string'] . ') AND';
    }
    $sql .= ' t.forum_id = f.forum_id';

    // Fetch topics/postings.
	
    $posts = _fetch($sql);

    // Close DB connection

    if ($CFG['close_db'] and !$CFG['phpbb_templates'] and !$CFG['proc'] == 'poll') 
	{
       $db->sql_close();
    }

    // Return the result.

    return $posts;
    
} // phpbb_fetch_thread


//
// phpbb_fetch_topic_poll - fetches the poll for a topic
// --------------------------------------------------------------
// @param    string  topic id from which will be fetched
// @access   public
// @return   array   array of fetched topic/poll
//

function phpbb_fetch_topic_poll($topic_id = '')
{

    global $CFG, $db;

    // Set function identifier.

    $CFG['proc'] = 'poll';

    // Sanity check to prevent invalid parameters.

    if (!$topic_id) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Topic ID has not been specified.');
    }
	
    // Create the sql statement (WHERE clause).

    $sql = ' t.topic_id = (' . $topic_id . ') AND
             t.topic_poster = u.user_id AND
             t.topic_first_post_id = pt.post_id AND
             t.topic_first_post_id = p.post_id AND
             t.topic_status <> 1 AND
             t.topic_status <> 2 AND
             t.topic_vote = 1 AND
             t.topic_id = vd.topic_id';

    // Save and override number of posts.

    $number_of_posts = $CFG['number_of_posts'];
    $CFG['number_of_posts'] = 1;

    // Fetch poll.

    $poll = _fetch($sql);
	
    // Restore number of posts.

    $CFG['number_of_posts'] = $number_of_posts;

    if ($poll) 
	{

        //
        // Create second SQL statement for poll results.
        //

        $sql = 'SELECT
                  *
                FROM
                  ' . VOTE_RESULTS_TABLE . '
                WHERE
                  vote_id = ' . $poll[0]['vote_id'] . '
                ORDER BY
                  vote_option_id';

        if (!($query = $db->sql_query($sql))) {
            die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
        }

        //
        // Fetch the results.
        //

        if ($row = $db->sql_fetchrow($query)) 
		{
            $i = 0;
            do 
			{
                $poll[0]['options'][$i]['vote_option_id']   = $row['vote_option_id'];
                $poll[0]['options'][$i]['vote_option_text'] = $row['vote_option_text'];
                $poll[0]['options'][$i]['vote_result']      = $row['vote_result'];
                $i++;
            }
            while ($row = $db->sql_fetchrow($query));
        }

    }

    //
    // Close DB connection
    //

    if ($CFG['close_db'] and !$CFG['phpbb_templates']) 
	{
        $db->sql_close();
    }

    //
    // Return the result.
    //

    return $poll;

} // phpbb_fetch_topic_poll

//
// phpbb_fetch_posts - fetches topics/postings from one or more
// forums.
// --------------------------------------------------------------
// @param    mixed   the forum id could be a string (a single
//                   forum id) or an array (list of forum id's)
// @access   public
// @return   array   array of fetched topics/postings
//

function phpbb_fetch_posts($forum_id = '')
{

    global $CFG;

    //
    // Set function identifier.
    //

    $CFG['proc'] = 'posts';

    //
    // Sanity check to prevent invalid parameters.
    //

    if (!$forum_id) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Forum ID has not been specified.');
    }

    if (!$CFG['show_normal'] and !$CFG['show_sticky'] and !$CFG['show_announcement']) 
	{
        die('<b>phpBB Fetch Posts Error:</b>
You must at least enable one of the following CFG options:<br>
- \'show_normal\'<br>- \'show_sticky\'<br>
- \'show_announcement\'<br>
Otherwise you will not get any output.');
    }

    if ($CFG['date_offset_start'] >= $CFG['date_offset_end']) 
	{
        die('<b>phpBB Fetch Posts Error:</b>
\'date_offset_start\' has to be smaller than \'date_offset_end\'.');
    }

    //
    // Create the list of forums.
    //

    $forums_id = '';

    if (!is_array($forum_id)) 
	{
        $forums_id = $forum_id;
    } 
	else 
	{
        for ($i = 0; $i < count($forum_id); $i++) 
		{
            $forums_id .= $forum_id[$i] . ',';
        }
        $forums_id = substr($forums_id, 0, strlen($forums_id) -1);
    }

    //
    // Create the sql statement (WHERE clause).
    //

    $sql = ' t.forum_id IN (' . $forums_id . ') AND
             t.topic_poster = u.user_id AND
             t.topic_first_post_id = pt.post_id AND
             t.topic_first_post_id = p.post_id AND';
    if ($CFG['date_offset_start']) 
	{
        $sql .= ' p.post_time >= ' . $CFG['date_offset_start'] . ' AND';
    }
    if ($CFG['date_offset_end']) 
	{
        $sql .= ' p.post_time <= ' . $CFG['date_offset_end'] . ' AND';
    }
    if (!$CFG['show_normal']) 
	{
        $sql .= ' t.topic_type <> 0 AND';
    }
    if (!$CFG['show_sticky']) 
	{
        $sql .= ' t.topic_type <> 1 AND';
    }
    if (!$CFG['show_announcement']) 
	{
        $sql .= ' t.topic_type <> 2 AND';
    }
    if (!$CFG['show_locked']) 
	{
        $sql .= ' t.topic_status <> 1 AND';
    }
    if (!$CFG['show_moved']) 
	{
        $sql .= ' t.topic_status <> 2 AND';
    }
    if (!$CFG['show_poll']) 
	{
        $sql .= ' t.topic_vote <> 1 AND';
    }
    if ($CFG['search_string']) 
	{
        $sql .= ' (' . $CFG['search_string'] . ') AND';
    }
    $sql .= ' t.forum_id = f.forum_id';

    //
    // Fetch topics/postings.
    //

    $posts = _fetch($sql);

    //
    // Return the result.
    //

    return $posts;

} // phpbb_fetch_posts

//
// phpbb_fetch_recent - fetches recent topics/postings.
// --------------------------------------------------------------
// @param    mixed   the forum id could be a string (a single
//                   forum id) or an array (list of forum id's)
// @access   public
// @return   array   array of fetched postings
//

function phpbb_fetch_recent($forum_id = '')
{

    global $CFG;

    //
    // Set function identifier.
    //

    $CFG['proc'] = 'recent';

    //
    // Sanity check to prevent invalid parameters.
    //

    if (!$forum_id) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Forum ID has not been specified.');
    }

    if (!$CFG['show_normal'] and !$CFG['show_sticky'] and !$CFG['show_announcement']) 
	{
        die('<b>phpBB Fetch Posts Error:</b>
You must at least enable one of the following CFG options:<br>
- \'show_normal\'<br>
- \'show_sticky\'<br>
- \'show_announcement\'<br>
Otherwise you will not get any output.');
    }

    if ($CFG['date_offset_start'] >= $CFG['date_offset_end']) 
	{
        die('<b>phpBB Fetch Posts Error:</b>
\'date_offset_start\' has to be smaller than \'date_offset_end\'.');
    }

    //
    // Create the list of forums.
    //

    $forums_id = '';

    if (!is_array($forum_id)) 
	{
        $forums_id = $forum_id;
    } 
	else 
	{
        for ($i = 0; $i < count($forum_id); $i++) 
		{
            $forums_id .= $forum_id[$i] . ',';
        }
        $forums_id = substr($forums_id, 0, strlen($forums_id) -1);
    }

    //
    // Create the sql statement (WHERE clause).
    //

    $sql = ' t.forum_id IN (' . $forums_id . ') AND
             p.poster_id = u.user_id AND
             t.topic_last_post_id = pt.post_id AND
             t.topic_last_post_id = p.post_id AND';
    if ($CFG['date_offset_start']) 
	{
        $sql .= ' p.post_time >= ' . $CFG['date_offset_start'] . ' AND';
    }
    if ($CFG['date_offset_end']) 
	{
        $sql .= ' p.post_time <= ' . $CFG['date_offset_end'] . ' AND';
    }
    if (!$CFG['show_normal']) 
	{
        $sql .= ' t.topic_type <> 0 AND';
    }
    if (!$CFG['show_sticky']) 
	{
        $sql .= ' t.topic_type <> 1 AND';
    }
    if (!$CFG['show_announcement']) 
	{
        $sql .= ' t.topic_type <> 2 AND';
    }
    if (!$CFG['show_locked']) 
	{
        $sql .= ' t.topic_status <> 1 AND';
    }
    if (!$CFG['show_moved']) 
	{
        $sql .= ' t.topic_status <> 2 AND';
    }
    if (!$CFG['show_poll']) 
	{
        $sql .= ' t.topic_vote <> 1 AND';
    }
    if ($CFG['search_string']) 
	{
        $sql .= ' (' . $CFG['search_string'] . ') AND';
    }
    $sql .= ' t.forum_id = f.forum_id';

    //
    // Fetch topics/postings.
    //

    $posts = _fetch($sql);

    //
    // Return the result.
    //

    return $posts;

} // phpbb_fetch_recent

//
// phpbb_fetch_topics - fetches topics/postings by topic id.
// --------------------------------------------------------------
// @param    mixed   the topic id could be a string (a single
//                   topic id) or an array (list of topic id's)
// @access   public
// @return   array   array of fetched topics/postings
//

function phpbb_fetch_topics($topic_id = '')
{

    global $CFG;

    //
    // Set function identifier.
    //

    $CFG['proc'] = 'topics';

    //
    // Sanity check to prevent invalid parameters.
    //

    if (!$topic_id) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Topic ID has not been specified.');
    }

    //
    // Create the list of topics.
    //

    $topics_id = '';

    if (!is_array($topic_id)) 
	{
        $topics_id = $topic_id;
    } 
	else 
	{
        for ($i = 0; $i < count($topic_id); $i++) 
		{
            $topics_id .= $topic_id[$i] . ',';
        }
        $topics_id = substr($topics_id, 0, strlen($topics_id) -1);
    }

    //
    // Create the sql statement (WHERE clause).
    //

    $sql = ' t.topic_id IN (' . $topics_id . ') AND
             t.topic_poster = u.user_id AND
             t.topic_first_post_id = pt.post_id AND
             t.topic_first_post_id = p.post_id AND
             t.forum_id = f.forum_id';

    //
    // Fetch topics/postings.
    //

    $posts = _fetch($sql);

    //
    // Sort the result.
    //

    if (is_array($topic_id)) 
	{
        $result = array();
        for ($i = 0; $i < count($topic_id); $i++) 
		{        
            for ($j = 0; $j < count($posts); $j++) 
			{
                if ($topic_id[$i] == $posts[$j]['topic_id']) 
				{
                    $result[] = $posts[$j];
                }
            }        
        }
        $posts = $result;
    }

    //
    // Return the result.
    //
    

    return $posts;

} // phpbb_fetch_topics

//
// phpbb_fetch_poll - fetches the latest poll from a forum
// --------------------------------------------------------------
// @param    string  forum id from which will be fetched
// @access   public
// @return   array   array of fetched topic/poll
//

function phpbb_fetch_poll($forum_id = '')
{

    global $CFG, $db;

    //
    // Set function identifier.
    //

    $CFG['proc'] = 'poll';

    //
    // Sanity check to prevent invalid parameters.
    //

    if (!$forum_id) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Forum ID has not been specified.');
    }

    //
    // Create the list of forums.
    //

    $forums_id = $forum_id;

    //
    // Create the sql statement (WHERE clause).
    //

    $sql = ' t.forum_id IN (' . $forums_id . ') AND
             t.topic_poster = u.user_id AND
             t.topic_first_post_id = pt.post_id AND
             t.topic_first_post_id = p.post_id AND
             t.topic_status <> 1 AND
             t.topic_status <> 2 AND
             t.topic_vote = 1 AND
             t.forum_id = f.forum_id AND
             t.topic_id = vd.topic_id';

    //
    // Save and override number of posts.
    //

    $number_of_posts = $CFG['number_of_posts'];
    $CFG['number_of_posts'] = 1;

    //
    // Fetch poll.
    //

    $poll = _fetch($sql);

    //
    // Restore number of posts.
    //

    $CFG['number_of_posts'] = $number_of_posts;

    if ($poll) 
	{

        //
        // Create second SQL statement for poll results.
        //

        $sql = 'SELECT
                  *
                FROM
                  ' . VOTE_RESULTS_TABLE . '
                WHERE
                  vote_id = ' . $poll[0]['vote_id'] . '
                ORDER BY
                  vote_option_id';

        if (!($query = $db->sql_query($sql))) 
		{
            die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
        }

        //
        // Fetch the results.
        //

        if ($row = $db->sql_fetchrow($query)) 
		{
            $i = 0;
            do 
			{
                $poll[0]['options'][$i]['vote_option_id']   = $row['vote_option_id'];
                $poll[0]['options'][$i]['vote_option_text'] = $row['vote_option_text'];
                $poll[0]['options'][$i]['vote_result']      = $row['vote_result'];
                $i++;
            }
            while ($row = $db->sql_fetchrow($query));
        }

    }

    //
    // Close DB connection
    //

    if ($CFG['close_db'] and !$CFG['phpbb_templates']) 
	{
        $db->sql_close();
    }

    //
    // Return the result.
    //

    return $poll;

} // phpbb_fetch_poll

//
// fetch_group - fetches users of a specific group
// --------------------------------------------------------------
// @access   public
// @param    int      group id
// @return   array    array of fetched member
//

function phpbb_fetch_group($group_id = '')
{

    global $CFG, $db;

    //
    // Set function identifier.
    //

    $CFG['proc'] = 'group';

    //
    // Sanity check.
    //

    if (!$group_id) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Group ID has not been specified.');
    }

    //
    // Create SQL statement.
    //

    $sql = 'SELECT
              u.username,
              u.user_aim,
              u.user_avatar,
              u.user_avatar_type,
              u.user_email,
              u.user_from,
              u.user_icq,
              u.user_id,
              u.user_interests,
              u.user_msnm,
              u.user_occ,
              u.user_posts,
              u.user_regdate,
              u.user_rank,
              u.user_website,
              u.user_yim
            FROM
              ' . USERS_TABLE      . ' AS u,
              ' . USER_GROUP_TABLE . ' AS g
            WHERE
              u.user_id = g.user_id AND
              u.user_active = 1 AND
              g.group_id = ' . $group_id . ' AND
              g.user_pending = 0
            ORDER BY
              u.username';

    //
    // Query the database.
    //

    $CFG['sql'] = $sql;

    if(!($result = $db->sql_query($sql))) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
    }

    //
    // Fetch all user.
    //

    $user = array();

    if ($row = $db->sql_fetchrow($result)) 
	{
        $i = 0;
        do 
		{
            $row['user_regdate'] = date($CFG['date_format'], $row['user_regdate']);

            //
            // Transfer row into result array.
            // FIXME:
            // $row contains a double key set which is bypassed with
            // is_numeric() - not nice but it works
            //

            while (list($k, $v) = each($row)) 
			{
                if (!is_numeric($k)) 
				{
                    $user[$i][$k] = $v;
                }
            }

            $i++;
        }
        while ($row = $db->sql_fetchrow($result));
    } // if ($row = $db->sql_fetchrow($result))

    //
    // Close DB connection
    //

    if ($CFG['close_db'] and !$CFG['phpbb_templates']) 
	{
        $db->sql_close();
    }

    //
    // Return the result.
    //

    return $user;

} // phpbb_fetch_group

//
// fetch_info - fetches forum informations
// --------------------------------------------------------------
// @access   public
// @return   array    array of fetched infos
//

function phpbb_fetch_info()
{

    global $CFG, $db;

    //
    // Set function identifier.
    //

    $CFG['proc'] = 'info';

    //
    // Fetch info.
    //

    $info = array();

    $info['total_posts']     = get_db_stat('postcount');
    $info['total_users']     = get_db_stat('usercount');
    $newest_user             = get_db_stat('newestuser');
    $info['newest_userid']   = $newest_user[0];
    $info['newest_username'] = $newest_user[1];
    
    $sql = 'SELECT
              COUNT(session_id)
            FROM
              ' . SESSIONS_TABLE . '
            WHERE
              session_time >= ' . (time() - 300);

    //
    // Query the database.
    //

    $CFG['sql'] = $sql;

    if (!($result = $db->sql_query($sql))) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
    }

    $user_online = $db->sql_fetchrow($result);
    $info['user_online'] = $user_online[0];

    //
    // Close DB connection
    //

    if ($CFG['close_db'] and !$CFG['phpbb_templates']) 
	{
        $db->sql_close();
    }

    //
    // Return the result.
    //

    return $info;

} // phpbb_fetch_info

//
// _fetch - performs the actual DB query.
// --------------------------------------------------------------
// @param    string   SQL query (WHERE clause)    
// @access   private
// @return   array    array of fetched topics/postings
//

function _fetch($sql_where = '')
{

    global $CFG, $db, $userdata;

    //
    // Sanity check.
    //

    if (!$sql_where) 
	{
        die('<b>phpBB Fetch Posts Error:</b> SQL statement has not been specified.');
    }

    //
    // Build SQL statement.
    //

    $sql = 'SELECT
			f.forum_name,
	        p.post_id,
			p.enable_smilies,
            p.post_time,
            p.poster_id,
            pt.bbcode_uid,
            pt.post_id,
            pt.post_text,
			pt.post_subject,
            t.forum_id,
            t.topic_first_post_id,
            t.topic_last_post_id,
            t.topic_id,
              t.topic_poster,
              t.topic_replies,
              t.topic_status,
              t.topic_title,
              t.topic_type,
              t.topic_vote,
				t.topic_moved_id,
              u.username,
              u.user_aim,
              u.user_avatar,
              u.user_avatar_type,
              u.user_email,
              u.user_from,
              u.user_icq,
              u.user_id,
              u.user_interests,
              u.user_msnm,
              u.user_occ,
              u.user_rank,
              u.user_website,
              u.user_yim';

    //
    // Ranks need some more queries.
    //

    if ($CFG['show_ranks'])
	{
        $sql .= ',
              r.rank_id,
              r.rank_title,
              r.rank_image';
    }

    //
    // Look for a poll?
    //

    if ($CFG['proc'] == 'poll') 
	{
        $sql .= ',
              vd.vote_id,
              vd.topic_id,
              vd.vote_text,
              vd.vote_start,
              vd.vote_length';
    }

    $sql .= '
            FROM
              ' . TOPICS_TABLE     . ' AS t,
              ' . USERS_TABLE      . ' AS u,
              ' . POSTS_TEXT_TABLE . ' AS pt,
              ' . POSTS_TABLE      . ' AS p,
              ' . FORUMS_TABLE     . ' AS f';

    //
    // Again something for ranks.
    //

    if ($CFG['show_ranks']) 
	{
        $sql .= ',
              ' . RANKS_TABLE . ' AS r';
    }

    //
    // And something for the poll.
    //

    if ($CFG['proc'] == 'poll') 
	{
        $sql .= ',
              ' . VOTE_DESC_TABLE . ' AS vd';
    }

    $sql .= '
            WHERE';

    //
    // Append the WHERE clause from the calling function.
    //

    $sql .= $sql_where;
    
    //
    // Ranks...
    //

    if ($CFG['show_ranks']) 
	{
        $sql .= '
            AND r.rank_id = u.user_rank';
    }

    //
    // Setup the ordering.
    //

    if ($CFG['proc'] == 'posts' or $CFG['proc'] == 'recent' or $CFG['proc'] == 'poll') 
	{
        if ($CFG['sort_topics'] == 0)
        {
           $sql .= '
                ORDER BY t.topic_type DESC, p.post_time DESC';
        }
        if ($CFG['sort_topics'] == 1)
        {
           $sql .= '
                ORDER BY t.topic_type DESC, t.topic_title';
        }
		if ($CFG['sort_topics'] == 2)
        {
           $sql .= '
                ORDER BY t.topic_type DESC, t.topic_last_post_id DESC';
        }
    }
    
    if ($CFG['proc'] == 'thread') 
	{
        if ($CFG['sort_thread_alpha'] != 1)
        {
           $sql .= '
                ORDER BY p.post_time';
        }
        else
        {
           $sql .= '
                ORDER BY pt.post_subject';
        }
    }

    //
    // Span pages require an additional query.
    //

    if ($CFG['span_pages'] and $CFG['proc'] != 'topics' and $CFG['proc'] != 'thread') 
	{        
		if(!($result = $db->sql_query($sql))) 
		{
            die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
        }
        $CFG['total'] = $db->sql_numrows($result);
        if ($CFG['start'] > $CFG['total']) 
		{
            $CFG['start'] = $CFG['total'] - 1;
        }
    }
    

    //
    // Limit the result?
    //

    if ($CFG['number_of_posts'] != 0 and $CFG['proc'] != 'topics' and $CFG['proc'] != 'thread') 
	{
        $sql .= '
            LIMIT ' . $CFG['offset'] . ',' . $CFG['number_of_posts'];
    }
    
    
    //
    // Query the database.
    //

    $CFG['sql'] = $sql;

    if(!($result = $db->sql_query($sql)))
	{
        die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
    }

    //
    // Fetch all postings.
    //

    $posts = array();

    if ($row = $db->sql_fetchrow($result)) 
	{
        $i = 0;
        do 
		{
            //
            // Check auth settings if required.
            //

            if ($CFG['use_auth']) 
			{
                $is_auth = auth(AUTH_READ, $row['forum_id'], $userdata);
            } 
			else 
			{
                $is_auth['auth_read'] = 1;
            }

            if ($is_auth['auth_read']) 
			{

                //
                // Transfer row into result array.
                // FIXME:
                // $row contains a double key set which is bypassed with
                // is_numeric() - not nice but it works
                //

                while (list($k, $v) = each($row)) 
				{
                    if (!is_numeric($k)) 
					{
                        $posts[$i][$k] = $v;
                    }
                }

                //
                // Split topic time for readability.
                //

                $posts[$i]['date'] = date($CFG['date_format'], $row['post_time']);
                $posts[$i]['time'] = date($CFG['time_format'], $row['post_time']);

                //
                // Status indicating if a post and/or title has been trimmed.
                //

                $posts[$i]['trimmed']       = 0;
                $posts[$i]['topic_trimmed'] = 0;

                //
                // Do a little magic and process the posting.
                //

                stripslashes($post[$i]['post_text']);
                $posts[$i]['post_text'] = bbencode_second_pass($posts[$i]['post_text'],
                                                               $posts[$i]['bbcode_uid']);
                if ($posts[$i]['enable_smilies'] == 1) 
				{
                    $posts[$i]['post_text'] = smilies_pass($posts[$i]['post_text']);
                    $posts[$i]['post_text'] = preg_replace("/images\/smiles/",
                                                           $CFG['smilie_url'], $posts[$i]['post_text']);
                }
                $posts[$i]['post_text'] = make_clickable($posts[$i]['post_text']);

                //
                // Define censored word matches.
                //

                $orig_word = array();
                $replacement_word = array();
                obtain_word_list($orig_word, $replacement_word);

                //
                // Censor text and title.
                //

                if (count($orig_word)) 
				{
                    $posts[$i]['topic_title'] = preg_replace($orig_word,
                                                             $replacement_word,
                                                             $posts[$i]['topic_title']);
                    $posts[$i]['post_text'] = preg_replace($orig_word,
                                                           $replacement_word,
                                                           $posts[$i]['post_text']);
                }
                $posts[$i]['post_text'] = nl2br($posts[$i]['post_text']);

                //
                // Trim text if requested.
                //

                if ($CFG['trim_character'] != '' and eregi($CFG['trim_character'],
                                                           $posts[$i]['post_text'])) 
				{
                    $trimmed = '';
                    $trimmed = explode($CFG['trim_character'], $posts[$i]['post_text']);
                    $posts[$i]['post_text'] = $trimmed[0];
                    $posts[$i]['trimmed']   = 1;
                }

                if ($CFG['trim_number'] != 0 and strlen($posts[$i]['post_text']) > $CFG['trim_number']) 
				{
                    $posts[$i]['post_text'] = substr($posts[$i]['post_text'], 0, $CFG['trim_number']);
                    $posts[$i]['trimmed']   = 1;
                }
				
                // May also trim text for display
                // on Topics Page only
                //
                 if ($CFG['trim_for_topics_character'] != '' and eregi($CFG['trim_for_topics_character'],
                                                           $posts[$i]['post_text']))
				{
                    $trimmed = '';
                    $trimmed = explode($CFG['trim_for_topics_character'], $posts[$i]['post_text']);
                    $posts[$i]['post_text_for_topics'] = $trimmed[0];
                    $posts[$i]['post_text_for_topics_trimmed'] = 1;
                }

                if ($CFG['trim_for_topics_number'] != 0 and strlen($posts[$i]['post_text']) > $CFG['trim_for_topics_number']) 
				{
                    $posts[$i]['post_text_for_topics'] = substr($posts[$i]['post_text'], 0, $CFG['trim_for_topics_number']);
                    $posts[$i]['post_text_for_topics_trimmed'] = 1;
                }
                
                //
                // Trim topic title if requested.
                //

                if ($CFG['topic_trim_number'] != 0 and
                    strlen($posts[$i]['topic_title']) > $CFG['topic_trim_number']) 
				{
                    $posts[$i]['topic_title']   = substr($posts[$i]['topic_title'], 0,
                                                         $CFG['topic_trim_number']);
                    $posts[$i]['topic_trimmed'] = 1;
                }

                //
                // Increase the number of rows.
                //
                $i++;

            } // if ($is_auth['auth_read'])

        }
        while ($row = $db->sql_fetchrow($result));

    } // if ($row = $db->sql_fetchrow($result))

    //
    // Close DB connection
    //

    if ($CFG['close_db'] and !$CFG['phpbb_templates'] and !$CFG['proc'] == 'poll') 
	{
        $db->sql_close();
    }

    //
    // Return the result.
    //

    return $posts;

} // _fetch

//
// phpbb_fetch_random_user - fetches a random user.
// --------------------------------------------------------------
// @access   public
// @return   array    array of fetched user information
//

function phpbb_fetch_random_user()
{

    global $CFG, $db;

    $CFG['proc'] = 'random_user';

    //
    // Get the list of all users.
    //

    $sql = 'SELECT
              user_id
            FROM
              ' . USERS_TABLE . '
            WHERE user_id <> -1';

    $CFG['sql'] = $sql;

    if(!($result = $db->sql_query($sql))) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
    }

    $user_id = array();

    if ($row = $db->sql_fetchrow($result)) 
	{
        do 
		{
            $user_id[] = $row['user_id'];
        }
        while ($row = $db->sql_fetchrow($result));
    } // if ($row = $db->sql_fetchrow($result))

    if (!$user_id) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Error while fetching users.');
    }

    //
    // Initialize random generator.
    //

    srand((double)microtime()*1000000);

    //
    // Determine the choosen one. :-)
    //

    $the_one = rand(0, count($user_id) - 1);

    $sql = 'SELECT
              username,
              user_aim,
              user_avatar,
              user_avatar_type,
              user_email,
              user_from,
              user_icq,
              user_id,
              user_interests,
              user_msnm,
              user_occ,
              user_posts,
              user_regdate,
              user_rank,
              user_website,
              user_yim
            FROM
              ' . USERS_TABLE . '
            WHERE
              user_id = ' . $user_id[$the_one];

    if(!($result = $db->sql_query($sql))) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
    }

    $user = array();

    if ($row = $db->sql_fetchrow($result)) 
	{
        //
        // Transfer row into result array.
        // FIXME:
        // $row contains a double key set which is bypassed with
        // is_numeric() - not nice but it works
        //

        while (list($k, $v) = each($row)) 
		{
            if (!is_numeric($k)) 
			{
                $user[$k] = $v;
            }
        }
    } 
	else 
	{
        die('<b>phpBB Fetch Posts Error:</b> Error while fetching user.');
    }

    //
    // Close DB connection
    //

    if ($CFG['close_db'] and !$CFG['phpbb_templates']) 
	{
        $db->sql_close();
    }

    //
    // Return the result.
    //

    return $user;

} // phpbb_fetch_random_user

//
// phpbb_fetch_top_poster - fetches the user with most postings.
// --------------------------------------------------------------
// @access   public
// @return   array    array of fetched user information
//

function phpbb_fetch_top_poster()
{

    global $CFG, $db;

    $CFG['proc'] = 'top_poster';

    //
    // Determine the choosen one. :-)
    //

    $sql = 'SELECT
              username,
              user_aim,
              user_avatar,
              user_avatar_type,
              user_email,
              user_from,
              user_icq,
              user_id,
              user_interests,
              user_msnm,
              user_occ,
              user_posts,
              user_regdate,
              user_rank,
              user_website,
              user_yim
            FROM
              ' . USERS_TABLE . '
            ORDER BY
              user_posts DESC
            LIMIT 0,1';

    if(!($result = $db->sql_query($sql))) 
	{
        die('<b>phpBB Fetch Posts Error:</b> Database query failed.');
    }

    $user = array();

    if ($row = $db->sql_fetchrow($result)) 
	{
        //
        // Transfer row into result array.
        // FIXME:
        // $row contains a double key set which is bypassed with
        // is_numeric() - not nice but it works
        //

        while (list($k, $v) = each($row)) 
		{
            if (!is_numeric($k)) 
			{
                $user[$k] = $v;
            }
        }
    } 
	else 
	{
        die('<b>phpBB Fetch Posts Error:</b> Error while fetching user.');
    }

    //
    // Close DB connection
    //

    if ($CFG['close_db'] and !$CFG['phpbb_templates']) 
	{
        $db->sql_close();
    }

    //
    // Return the result.
    //

    return $user;

} // phpbb_fetch_top_poster

?>
