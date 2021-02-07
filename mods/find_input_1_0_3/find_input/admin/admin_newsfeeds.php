<?php
/***************************************************************************
 *                             admin_newfeeds.php
 *                            -------------------
 *   Author  		: 	netclectic - Adrian Cockburn - adrian@netclectic.com
 *   Created 		: 	Monday, Sept 23, 2002
 *	 Last Updated	:	Monday, Mar 10, 2003
 *
 *	 Version		: 	FIND - 1.0.0
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['FIND']['Input Newsfeeds'] = $filename;

	return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// include the newsfeed lang_admin file
$use_lang = ( !file_exists($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin_find.'.$phpEx) ) ? 'english' : $board_config['default_lang'];
include($phpbb_root_path . 'language/lang_' . $use_lang . '/lang_admin_find.' . $phpEx);

// initialise the mode
$mode = ( (isset($HTTP_POST_VARS['add_newsfeed']) || isset($HTTP_GET_VARS['add_newsfeed']) ) ? 'add' : 
            ( (isset($HTTP_POST_VARS['edit_newsfeed']) || isset($HTTP_GET_VARS['edit_newsfeed']) ) ? 'save' : 
                ( (isset($HTTP_POST_VARS[POST_NEWSFEED_URL]) || isset($HTTP_GET_VARS[POST_NEWSFEED_URL]) ) ? 'edit' : 
                    ( (isset($HTTP_POST_VARS['delete_newsfeed']) || isset($HTTP_GET_VARS['delete_newsfeed']) ) ? 'delete' : 
                        ( (isset($HTTP_POST_VARS['execute_newsfeed']) || isset($HTTP_GET_VARS['execute_newsfeed']) ) ? 'execute' : '' )))));

// are we add a new newsfeed or saving the updates to an existing newsfeed?
if ( $mode == 'add' || $mode == 'save' )
{
    // initiailise the various variables
	$forum_id = ( (isset($HTTP_POST_VARS[POST_FORUM_URL]) ) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : 
                    ( (isset($HTTP_GET_VARS[POST_FORUM_URL]) ) ? intval($HTTP_GET_VARS[POST_FORUM_URL]) : 0 ));
                    
    $newsfeed_url = str_replace("\'", "''", trim((isset($HTTP_POST_VARS['NEWSFEED_URL'])) ? $HTTP_POST_VARS['NEWSFEED_URL'] : $HTTP_GET_VARS['NEWSFEED_URL']));
    
    $newsfeed_name = trim((isset($HTTP_POST_VARS['NEWSFEED_NAME'])) ? $HTTP_POST_VARS['NEWSFEED_NAME'] : $HTTP_GET_VARS['NEWSFEED_NAME']);
    
    $newsfeed_limit = ( (isset($HTTP_POST_VARS['NEWSFEED_LIMIT']) ) ? intval($HTTP_POST_VARS['NEWSFEED_LIMIT']) : 
                        ( (isset($HTTP_GET_VARS['NEWSFEED_LIMIT']) ) ? intval($HTTP_GET_VARS['NEWSFEED_LIMIT']) : 5 ));
                        
    $newsfeed_username = str_replace("\'", "''", trim((isset($HTTP_POST_VARS['NEWSFEED_USERNAME'])) ? $HTTP_POST_VARS['NEWSFEED_USERNAME'] : $HTTP_GET_VARS['NEWSFEED_USERNAME']));
    
    $newsfeed_inc_channel = ( (isset($HTTP_POST_VARS['NEWSFEED_INC_CHANNEL']) ) ? intval($HTTP_POST_VARS['NEWSFEED_INC_CHANNEL']) : 
                                ( (isset($HTTP_GET_VARS['NEWSFEED_INC_CHANNEL']) ) ? intval($HTTP_GET_VARS['NEWSFEED_INC_CHANNEL']) : 0 ));
                                
    $newsfeed_inc_image = ( (isset($HTTP_POST_VARS['NEWSFEED_INC_IMAGE']) ) ? intval($HTTP_POST_VARS['NEWSFEED_INC_IMAGE']) : 
                                ( (isset($HTTP_GET_VARS['NEWSFEED_INC_IMAGE']) ) ? intval($HTTP_GET_VARS['NEWSFEED_INC_IMAGE']) : 0 ));

                                
    // do we have a valid forum_id - this should always be ok as it uses a drop down list for selection
    if ( $forum_id <= 0 )
    {
		message_die(GENERAL_ERROR, "Can't create a newsfeed without an associated forum");
    }
    
    // have they entered a url for the newsfeed - it'd be pretty useless without one
    if( $newsfeed_url == "" )
    {
		message_die(GENERAL_ERROR, "Can't create a newsfeed without a URL");
    }

    // have they entered a username for the newsfeed - somebody has to gather the news, it wont gather itself
    if( $newsfeed_username == "" )
    {
		message_die(GENERAL_ERROR, "Can't create a newsfeed without a valid user");
    }
    
    // check to see if they've entered a valid username
    $sql = "SELECT user_id FROM " . USERS_TABLE . " WHERE username='$newsfeed_username'";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Could not obtain user info.", "", __LINE__, __FILE__, $sql);
	}
    if ( ($row = $db->sql_fetchrow($result)) )
    {
        $userid = $row['user_id'];
    }
    else
    {
		message_die(GENERAL_ERROR, "No users match that username.");
    }

    // if we are adding a new newsfeed
    if ( $mode == 'add' )
    {
        // check to see if the newsfeed url is already being used in the chosen forum
        $sql = "SELECT feed_id from " . NEWSFEEDS_TABLE . " WHERE forum_id=$forum_id AND news_url='$newsfeed_url'";
        if( !$result = $db->sql_query($sql) )
        {
            message_die(GENERAL_ERROR, "Could not obtain newsfeed info.", "", __LINE__, __FILE__, $sql);
        }
    
        // insert the new newsfeed details
        if ( !($row = $db->sql_fetchrow($result)) )
        {
            $sql = "INSERT INTO " . NEWSFEEDS_TABLE . " 
                    (forum_id, user_id, news_url, news_name, news_limit, include_channel, include_image) 
                VALUES 
                    ($forum_id, $userid, '$newsfeed_url', '$newsfeed_name', $newsfeed_limit, $newsfeed_inc_channel, $newsfeed_inc_image)";
    		if( !$result = $db->sql_query($sql) )
    		{
    			message_die(GENERAL_ERROR, "Could not insert row in newsfeeds table.", "", __LINE__, __FILE__, $sql);
    		}
        }
        else
        {
    		message_die(GENERAL_ERROR, "The URL entered already exists for this forum.");
        }
    }
    
    // we are saving the changes made to an existing newsfeed
    else
    {
        // initialise the feed id
    	$feed_id = ( (isset($HTTP_POST_VARS['save_feed_id']) ) ? intval($HTTP_POST_VARS['save_feed_id']) : 
                        ( (isset($HTTP_GET_VARS['save_feed_id']) ) ? intval($HTTP_GET_VARS['save_feed_id']) : 0 ));
        
        // if it's a valid newsfeed id, go ahead and do the update
        if ( $feed_id > 0 )
        {
            $sql = "UPDATE " . NEWSFEEDS_TABLE . "
                SET forum_id = $forum_id, 
                    user_id = $userid, 
                    news_url = '$newsfeed_url', 
                    news_name = '$newsfeed_name',  
                    news_limit = $newsfeed_limit, 
                    include_channel = $newsfeed_inc_channel, 
                    include_image = $newsfeed_inc_image 
                WHERE feed_id = $feed_id";
    		if( !$result = $db->sql_query($sql) )
    		{
                message_die(GENERAL_ERROR, "Could not update info in newsfeeds table.", "", __LINE__, __FILE__, $sql);
    		}
        }
    }
}

// are we deleting an existing newsfeed?
elseif ( $mode == 'delete' )
{
    // could be more than 1, get the list of feed ids to delete
	$feeds = ( isset($HTTP_POST_VARS['feed_id_list']) ) ?  $HTTP_POST_VARS['feed_id_list'] : array();
	$feed_id_sql = '';
    
    // if we've got some feed ids, then go ahead and delete them
    if ( count($feeds) > 0 )
    {
    	for($i = 0; $i < count($feeds); $i++)
    	{
    		$feed_id_sql .= ( ( $feed_id_sql != '' ) ? ', ' : 'IN (' ) . $feeds[$i];
    	}
        $feed_id_sql .= ( $feed_id_sql != '' ) ? ')' : '';
    
        $sql = "DELETE FROM " . NEWSFEEDS_TABLE . " WHERE feed_id $feed_id_sql";
        if( !$result = $db->sql_query($sql) )
        {
            message_die(GENERAL_ERROR, "Could not delete from newsfeeds table.", "", __LINE__, __FILE__, $sql);
        }
    }
    else
    {
        message_die(GENERAL_ERROR, "None selected.");
    }
}

// are manaually gatheing the news?
elseif ( $mode == 'execute' )
{
    // call the news gathering function in functions_news.php
    include_once($phpbb_root_path . 'mods/netclectic/find_input/includes/functions_news.php');

	$feeds = ( isset($HTTP_POST_VARS['feed_id_list']) ) ?  implode(',', $HTTP_POST_VARS['feed_id_list']) : '';
    $message = retrieve_rss_content($feeds, true);
    message_die(GENERAL_MESSAGE, $message);
}

// are we about to edit a newsfeed?
elseif ( $mode == 'edit' )
{
    // initialise the feed id
	$feed_id = ( (isset($HTTP_POST_VARS[POST_NEWSFEED_URL]) ) ? intval($HTTP_POST_VARS[POST_NEWSFEED_URL]) : 
                (isset($HTTP_GET_VARS[POST_NEWSFEED_URL]) ) ? intval($HTTP_GET_VARS[POST_NEWSFEED_URL]) : 0 );

    // if we have a valid feed id then get and output the feed details
    if ( $feed_id > 0 )
    {
        $sql = 'SELECT n.*, u.username 
            FROM ' . NEWSFEEDS_TABLE . ' n, ' . USERS_TABLE . ' u 
            WHERE u.user_id = n.user_id 
                AND feed_id = ' . $feed_id;
        if( !$result = $db->sql_query($sql) )
        {
            message_die(GENERAL_ERROR, "Could not retrieve info from newsfeeds table.", "", __LINE__, __FILE__, $sql);
        }
        if ( $row = $db->sql_fetchrow($result) )
        {
            $template->assign_vars(array(
            	'EDIT_NEWSFEED_ID' => $row['feed_id'],
            	'EDIT_NEWSFEED_FORUM_ID' => $row['forum_id'],
            	'EDIT_NEWSFEED_NAME' => $row['news_name'],
            	'EDIT_NEWSFEED_URL' => $row['news_url'],
                'EDIT_NEWS_USER' => $row['username'],
                'EDIT_NEWS_LIMIT' => $row['news_limit'],
                'EDIT_NEWS_INCLUDE_CHANNEL' => ($row['include_channel']) ? 'checked=checked' : '',
                'EDIT_NEWS_INCLUDE_IMAGE' => ($row['include_image']) ? 'checked=checked' : '',
                )
            );
        }    
    }
}

// start the page output
$template->set_filenames(array(
    'body' => 'admin/newsfeeds_body.tpl')
);

// get the list of forums and catgories
$sql = "SELECT f.* 
    FROM " . FORUMS_TABLE . " f, " . CATEGORIES_TABLE . " c
	WHERE c.cat_id = f.cat_id
	ORDER BY c.cat_order ASC, f.forum_order ASC";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Couldn't obtain forum list", "", __LINE__, __FILE__, $sql);
}

$forum_rows = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);

// build a drop down select list of forums
$select_list = '<select name="' . POST_FORUM_URL . '">';
for($i = 0; $i < count($forum_rows); $i++)
{
    $select_list .= '<option value="' . $forum_rows[$i]['forum_id'] . '"' . ( ( ($mode == 'edit') && ($forum_rows[$i]['forum_id'] == $row['forum_id']) ) ? ' Selected ' : '') . '>' . $forum_rows[$i]['forum_name'] . '</option>';
}
$select_list .= '</select>';

// assign some variables
$template->assign_vars(array(
    'L_FIND_EXPLAIN' => $lang['FIND_Explain'],
	'L_FORUM_NAME' => $lang['Forum_name'],
	'L_NEWSFEED_NAME' => $lang['News_Feed_Name'],
	'L_NEWSFEED_NAME_EXPLAIN' => $lang['News_Feed_Name_Explain'],
	'L_NEWSFEED_URL' => $lang['News_Feed_URL'],
    'L_NEWSFEED_URL_EXPLAIN' => $lang['News_URL_Explain'],
    'L_NEWSFEEDS_TITLE' => $lang['News_Feeds'],
    'L_NEWSFEEDS_EXPLAIN' => $lang['News_Feeds_Explain'],
    'L_ADD_EDIT_NEWSFEED' => ($mode != 'edit') ? $lang['Add_Feed'] : $lang['Edit_Feed'],
    'L_EDIT_NEWSFEED' => $lang['Edit_Feed'],
    'L_NEWS_FORUMS_EXPLAIN' => $lang['News_Forums_Explain'],
    'L_UPDATE_NEWS_CONFIG' => $lang['Update_News_Config'],
    'L_NEWS_CONFIG' => $lang['News_Config'],
    'L_NEWS_USER' => $lang['News_Username'],
    'L_NEWS_USERNAME_EXPLAIN' => $lang['News_Username_Explain'],
    'L_NEWS_LIMIT' => $lang['News_Limit'],
    'L_NEWS_LIMIT_EXPLAIN' => $lang['News_Limit_Explain'],
    'L_DELETE' => $lang['Delete'],
    'L_GET_NEWS_NOW' => $lang['Get_News_Now'],
    'L_NEWS_INC_CHANNEL' => $lang['News_Include_Channel'],
    'L_NEWS_INC_CHANNEL_EXPLAIN' => $lang['News_Include_Channel_Explain'],
    'L_NEWS_INC_IMAGE' => $lang['News_Include_Image'],
    'L_NEWS_INC_IMAGE_EXPLAIN' => $lang['News_Include_Image_Explain'],
    'L_CHECK_ALL' => $lang['Check_All'],
    'L_UNCHECK_ALL' => $lang['UnCheck_All'],
    'POST_NEWSFEED_URL' => POST_NEWSFEED_URL,
    
    'S_FORM_ACTION' => append_sid("admin_newsfeeds.$phpEx"),
    'S_FORUM_SELECT' => $select_list,
    'S_ADD_EDIT_NEWSFEED' => ($mode != 'edit') ? 'add_newsfeed' : 'edit_newsfeed',
    )
);

// get the list of newsfeeds and related info
$sql = 'SELECT f.forum_name, n.*, c.cat_id, c.cat_title, u.user_id, u.username 
	FROM ' . NEWSFEEDS_TABLE . ' n, ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c, ' . USERS_TABLE . ' u 
	WHERE f.forum_id = n.forum_id 
        AND c.cat_id = f.cat_id 
        AND u.user_id = n.user_id
    ORDER BY c.cat_order ASC, f.forum_order ASC, n.news_name ASC';
	
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Couldn't obtain newsfeeds list", "", __LINE__, __FILE__, $sql);
}

// loop through the newsfeeds 
$cat_id = -1;
$newsfeed_rows = $db->sql_fetchrowset($result);
for($i = 0; $i < count($newsfeed_rows); $i++)
{
    // is this the start of a new category
    if ( $newsfeed_rows[$i]['cat_id'] != $cat_id )
    {
    	$template->assign_block_vars('cat_row', array(
            'CAT_TITLE' => $newsfeed_rows[$i]['cat_title']
            )
        );
        $cat_id = $newsfeed_rows[$i]['cat_id'];
    }
    
    // assign the various newsfeed variables
    $newsfeed_url = ( $newsfeed_rows[$i]['news_name'] != "" ) ? '<a href="' . $newsfeed_rows[$i]['news_url'] . '" target="_blank">' . $newsfeed_rows[$i]['news_name'] . '</a>' : '<a href="' . $newsfeed_rows[$i]['news_url'] . '" target="_blank">' . $newsfeed_rows[$i]['news_url'] . '</a>';
	$template->assign_block_vars('cat_row.newsfeed_row', array(
		'NEWSFEED_ID' => $newsfeed_rows[$i]['feed_id'],
		'FORUM_ID' => $newsfeed_rows[$i]['forum_id'],	
		'USER_ID' => $newsfeed_rows[$i]['user_id'],	
		'S_FORUM_NAME' => $newsfeed_rows[$i]['forum_name'],
		'S_NEWSFEED_USERNAME' => $newsfeed_rows[$i]['username'],
		'S_NEWSFEED_URL' => $newsfeed_url,
        'S_NEWSFEED_LIMIT' => $newsfeed_rows[$i]['news_limit'],
        'S_NEWSFEED_INC_CHANNEL' => ($newsfeed_rows[$i]['include_channel']) ? $lang['Yes'] : $lang['No'],
        'S_NEWSFEED_INC_IMAGE' => ($newsfeed_rows[$i]['include_image']) ? $lang['Yes'] : $lang['No'],

        'U_NEWS_USER' => append_sid("admin_users.$phpEx" . '?mode=edit&' . POST_USERS_URL . '=' . $newsfeed_rows[$i]['user_id']),
        'U_EDITFEED' => append_sid("admin_newsfeeds.$phpEx" . '?mode=edit&amp;' . POST_NEWSFEED_URL . '=' . $newsfeed_rows[$i]['feed_id']), 
		)
	);
}
$db->sql_freeresult($result);


// now lets ouput the whole shebang
include('./page_header_admin.'.$phpEx);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);
?>
