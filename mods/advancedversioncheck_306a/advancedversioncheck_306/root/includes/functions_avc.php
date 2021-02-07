<?php
/***************************************************************************
 *                            functions_avc.php
 *                            -------------------
 *   begin                : May 8, 2005
 *   author               : Fountain of Apples < webmacster87@gmail.com >
 *   copyright            : (C) 2005-2006 Douglas Bell
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

/* This file contains all the version check functions used by AVC. */

//
// Page has to be accessed through phpBB. If not, complain.
//
if (!defined('IN_PHPBB'))
{
    die('Hacking attempt');
}

// function avc_display_index() -- This will run all the necessary code to display the Admin Index Summary & phpBB Check Data
function avc_display_index()
{
    global $db, $lang, $phpbb_root_path, $phpEx, $template, $version_config;
	/* phpBB Version Check Information */
    // Set our tpl
    $template->set_filenames(array(
        'phpbbversion' => 'admin/avc_phpbbversion_body.tpl')
    );
	//
	// Get phpBB's Info from the Version Check table
	//
	$sql = "SELECT mod_current_version, mod_new_version FROM " . VERSION_CHECK_TABLE . " WHERE mod_id=1";
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, $lang['No_Version_Data'], '', __LINE__, __FILE__, $sql);
	}
	$phpbb_info = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	// Split up our versions for comparison
	$new_version = explode('.', $phpbb_info['mod_new_version']);
	$current_version = explode('.', $phpbb_info['mod_current_version']);
	// Is a new version available?
	$new_vers_available = ( $new_version[0] > $current_version[0] || ($new_version[1] > $current_version[1] && $new_version[0] == $current_version[0]) || ($new_version[2] > $current_version[2] && $new_version[1] == $current_version[1] && $new_version[0] == $current_version[0] ) ) ? 1 : 0;
	// Assign our vars
	$template->assign_vars(array(
		'L_PHPBB_VERSION' => $lang['phpBB_version'],
		'PHPBB_VERSION' => $phpbb_info['mod_current_version'],
		'F_COLOR' => ($new_vers_available) ? 'color:red' : 'color:green',
		'PHPBB_UPTODATE' => ($new_vers_available) ? $lang['Version_not_up_to_date_short'] : $lang['Version_up_to_date_short'],
		'L_DOWNLOAD_PHPBB' => $lang['Download_phpBB'])
	);
	// Assign the var
	$template->assign_var_from_handle('AVC_PHPBBVERSION', 'phpbbversion');


	/* Admin Index Summary */
	//
	// Let's just grab all the SQL we need and get everything ready
	//
	if ( $version_config['show_admin_index'] )
	{
        // Set our tpl
        $template->set_filenames(array(
            'summary' => 'admin/avc_index_summary.tpl')
        );
		$sql = "SELECT mod_id, mod_name, mod_status, mod_topic_loc , mod_download_loc, mod_current_version,mod_new_version, mod_time_stamp, mod_file_name, mod_domain_loc, mod_file_loc
			FROM " . VERSION_CHECK_TABLE . " WHERE mod_status = 1 AND mod_current_version < mod_new_version
			ORDER BY mod_id";	
		if( !$q_mod = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, $lang['No_Version_Data'], "", __LINE__, __FILE__, $sql);
		}
		$total_mods = $db->sql_numrows($q_mod);
		$mod_rows = $db->sql_fetchrowset($q_mod);
		$db->sql_freeresult($q_mod);

		//
		// If there's no MODs here, then none of them are updated
		//
		if (empty($mod_rows))
		{
			$template->assign_block_vars('switch_version_check_none', array(
				'L_MOD_NONE_HEADER' => $lang['Version_check'],
				'L_NO_UPDATES' => $lang['MODs_uptodate'])
			);
		}
		//
		// There ARE some MODs with updates, get ready
		//
		else
		{
			$template->assign_block_vars('switch_version_check_on', array(
				'L_MOD_NAME_HEADER' => $lang['MOD_Name'],
				'L_LATEST_VERSION_HEADER' => $lang['Latest_version'],
				'L_CURRENT_VERSION_HEADER' => $lang['Current_version'],
				'L_DOWNLOAD_MOD_HEADER' => $lang['Download'],
				'L_VERSION_CHECK_HEADER' => $lang['Version_check'],
				'L_INDEX_SUMMARY_EXPLAIN' => sprintf($lang['Index_summary_explain'], '<a href="' . append_sid("admin_version.$phpEx") . '">', '</a>'))
			);
			//
			// Loop through each updated MOD
			//
			for($i = 0;$i < $total_mods;$i++)
			{
				$fcolor =  ($mod_rows[$i]['mod_new_version'] > $mod_rows[$i]['mod_current_version'] ) ? 'color:red' : 'color:green';
				$template->assign_block_vars('switch_version_check_on.switch_version_check_loop', array(
					'L_MOD_NAME' => $mod_rows[$i]['mod_name'],
					'U_TOPIC_LOC' => $mod_rows[$i]['mod_topic_loc'],
					'L_LATEST_VERSION' => $mod_rows[$i]['mod_new_version'],
					'L_CURRENT_VERSION' => $mod_rows[$i]['mod_current_version'],
					'L_DOWNLOAD_MOD' => $lang['Download'],
					'U_DOWNLOAD_MOD' => $mod_rows[$i]['mod_download_loc'],
					'F_COLOR' => $fcolor,
					'L_RECHECK_V' => $lang['Run_check'])
				);
			}
		}
        // Assign our var
        $template->assign_var_from_handle('AVC_INDEX_SUMMARY', 'summary');
    }
}

//
// Minor Detail Functions
//

// function htmlspecialchars_decode() -- This is a PHP 5.1.0 RC-1 (and later) function, we've got a wrapper here
// Thanks to geoffers@gmail.com on PHP.net for this :)
if ( !function_exists('htmlspecialchars_decode') )
{
    function htmlspecialchars_decode($str, $quote_style = ENT_COMPAT)
    {
        $return = strtr($str, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
        return $return;
    }
}

// function avc_select() -- This is used for formatting the time that is displayed on the Version Check page
function avc_select($default, $select_name = 'check_time')
{
	global $sys_timezone, $lang;

	if ( !isset($default) )
	{
		$default == $sys_timezone;
	}
	$avc_select = '<select name="' . $select_name . '">';

	while( list($offset, $zone) = @each($lang['avc_check_int']) )
	{
		$selected = ( $offset == $default ) ? ' selected="selected"' : '';
		$avc_select .= '<option value="' . $offset . '"' . $selected . '>' . $zone . '</option>';
	}
	$avc_select .= '</select>';

	return $avc_select;
}

// function avc_mod_error() -- If an error occurs in the Version Check, this will set the MOD's error message in the database
function avc_mod_error($mod_id, $error_msg)
{
    global $db, $lang;
    $sql = "UPDATE " . VERSION_CHECK_TABLE . "
            SET mod_error = '$error_msg'
            WHERE mod_id = '$mod_id'";
    if ( !$db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, sprintf($lang['No_error_msg'], $error_msg) . '<br />' . sprintf($lang['No_error_msg_MODID'], $mod_id), '', __LINE__, __FILE__, $sql);
    }
}

// function avc_log_add() -- Adds an action to the AVC log
function avc_log_add($mod_name, $log_action)
{
    global $db, $lang;
    $current_time = time();
    $sql = "INSERT INTO " . VERSION_LOG_TABLE . " (log_timestamp, mod_name, log_action)
            VALUES ('$current_time', '$mod_name', '$log_action')";
    if ( !$db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, $lang['No_Update_log'], '', __LINE__, __FILE__, $sql);
    }
    return;
}

// Our wonderful, beautiful, almost-godly XML class! This IS the magic of the XML Retrievable file!
// Thanks much to NeoThermic of phpBB.com for pointing me to this! (I have edited the code a bit to suit AVC's purposes)
// The class is Copyright (C) 2005 The phpBB Support Team, released under the GPL, either version 2 or any later version
class avc_xml
{
 	var $file;
	var $file_content;
	
	function avc_xmlxml()
	{
		// Don't do anything
	}
	
    function set_filename($file)
    {
        $this->file = $file;
		 
        $file_handle = @fopen($file, 'r');
        if ( !$file_handle )
        {
            return false;
        }

        $this->file_content = @fread($file_handle, 320000); //320000 is used to hopefully grab all that is needed.

        @fclose($file_handle);
    }
	
	function read_node($node)
	{
		if ( empty($this->file_content) )
		{
			return false;
		}
		
		$xml_content = $this->file_content;
		
		// We only like arrays..
		if ( !is_array($node) )
		{
			$node = array($node);
		}

		reset($node);
		
		// Now loop through the list of nodes and get the data after the <nodename> tag
		$read_pos = 0;
		foreach ( $node as $read_node )
		{
			$node_start_pos = strpos($xml_content, '<' . $read_node . '>');
			if ( !$node_start_pos )
			{
				 return false;
			}
			
			$xml_content = substr($xml_content, ($node_start_pos + strlen($read_node) + 2));
		}
		
		$xml_content = trim(substr($xml_content, 0, strpos($xml_content, '</' . $read_node . '>')));
		
		return $xml_content;
	}
}

// function avc_pm() -- Sends a private message to a user and does all the little technical things needed to send the PM
// This function is written by and belongs to wGEric of phpBB.com; I've edited it a bit to fix some bugs in the code (hey, it needs to work!)
function avc_pm(
    $to_id, 
    $message,
    $subject,
    $from_id,
    $attach_sig = 0,
    $html_on = 0,
    $bbcode_on = 1,
    $smilies_on = 1)
{
    global $board_config, $db, $emailer, $html_entities_match, $html_entities_replace, $lang, $phpbb_root_path, $phpEx, $unhtml_specialchars_match, $unhtml_specialchars_replace, $user_ip, $userdata;
    include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
    include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);

    if ( !$from_id )
    {
        $from_id = $userdata['user_id'];
    }

    //get varibles ready
    $to_id = intval($to_id);
    $from_id = intval($from_id);
    $msg_time = time();
    $attach_sig = ($attach_sig == 0) ? 0 : $userdata['user_attachsig'];
   
    //get to users info
    $sql = "SELECT user_id, user_notify_pm, user_email, user_lang, user_active
            FROM " . USERS_TABLE . "
            WHERE user_id = '$to_id'
            AND user_id <> " . ANONYMOUS;
    if ( !($result = $db->sql_query($sql)) )
    {
        $error = TRUE;
        $error_msg = $lang['No_such_user'];
    }

    $to_userdata = $db->sql_fetchrow($result);

    $privmsg_subject = trim(strip_tags($subject));
    if ( empty($privmsg_subject) )
    {
        $error = TRUE;
        $error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Empty_subject'];
    }

    if ( !empty($message) )
    {
        if ( !$error )
        {
            if ( $bbcode_on )
            {
                $bbcode_uid = make_bbcode_uid();
            }

            $privmsg_message = prepare_message($message, $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
            $privmsg_message = str_replace('\\\n', '\n', $privmsg_message);

        }
    }
    else
    {
        $error = TRUE;
        $error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['Empty_message'];
    }

    //
    // See if recipient is at their inbox limit
    //
    $sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time
            FROM " . PRIVMSGS_TABLE . "
            WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
                    OR privmsgs_type = " . PRIVMSGS_READ_MAIL . " 
                    OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )
                AND privmsgs_to_userid = " . $to_userdata['user_id'];
    if ( !($result = $db->sql_query($sql)) )
    {
        message_die(GENERAL_MESSAGE, $lang['No_such_user']);
    }

    $sql_priority = ( SQL_LAYER == 'mysql' ) ? 'LOW_PRIORITY' : '';

    if ( $inbox_info = $db->sql_fetchrow($result) )
    {
        if ( $inbox_info['inbox_items'] >= $board_config['max_inbox_privmsgs'] )
        {
            $sql = "SELECT privmsgs_id FROM " . PRIVMSGS_TABLE . "
                    WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
                            OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "
                            OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . "  )
                        AND privmsgs_date = " . $inbox_info['oldest_post_time'] . "
                        AND privmsgs_to_userid = " . $to_userdata['user_id'];
            if ( !$result = $db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, $lang['No_find_oldest_privmsgs'], '', __LINE__, __FILE__, $sql);
            }
            $old_privmsgs_id = $db->sql_fetchrow($result);
            $old_privmsgs_id = $old_privmsgs_id['privmsgs_id'];

            $sql = "DELETE $sql_priority FROM " . PRIVMSGS_TABLE . "
                    WHERE privmsgs_id = $old_privmsgs_id";
            if ( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, $lang['No_delete_oldest_privmsgs'].$sql, '', __LINE__, __FILE__, $sql);
            }

            $sql = "DELETE $sql_priority FROM " . PRIVMSGS_TEXT_TABLE . "
                    WHERE privmsgs_text_id = $old_privmsgs_id";
            if ( !$db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, $lang['No_delete_oldest_privmsgs_text'], '', __LINE__, __FILE__, $sql);
            }
        }
    }

    $sql_info = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_ip, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig)
                VALUES (" . PRIVMSGS_NEW_MAIL . ", '" . str_replace("\'", "''", $privmsg_subject) . "', " . $from_id . ", " . $to_userdata['user_id'] . ", $msg_time, '$user_ip', $html_on, $bbcode_on, $smilies_on, $attach_sig)";

    if ( !($result = $db->sql_query($sql_info, BEGIN_TRANSACTION)) )
    {
        message_die(GENERAL_ERROR, $lang['No_PM_sent_info'], "", __LINE__, __FILE__, $sql_info);
    }

    $privmsg_sent_id = $db->sql_nextid();

    $sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_bbcode_uid, privmsgs_text)
            VALUES ($privmsg_sent_id, '" . $bbcode_uid . "', '" . str_replace("\'", "''", $privmsg_message) . "')";

    if ( !$db->sql_query($sql, END_TRANSACTION) )
    {
        message_die(GENERAL_ERROR, $lang['No_PM_sent_text'], "", __LINE__, __FILE__, $sql);
    }

    //
    // Add to the users new pm counter
    //
    $sql = "UPDATE " . USERS_TABLE . "
            SET user_new_privmsg = user_new_privmsg + 1, user_last_privmsg = " . time() . " 
            WHERE user_id = " . $to_userdata['user_id'];
    if ( !$status = $db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, $lang['No_PM_read_status'], '', __LINE__, __FILE__, $sql);
    }

    if ( $to_userdata['user_notify_pm'] && !empty($to_userdata['user_email']) && $to_userdata['user_active'] )
    {
        $script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
        $script_name = ( $script_name != '' ) ? $script_name . '/privmsg.'.$phpEx : 'privmsg.'.$phpEx;
        $server_name = trim($board_config['server_name']);
        $server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
        $server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

        if ( !class_exists('emailer') )
        {
            include($phpbb_root_path . 'includes/emailer.'.$phpEx);
            $emailer = new emailer($board_config['smtp_delivery']);
        }

        $emailer->from($board_config['board_email']);
        $emailer->replyto($board_config['board_email']);

        $emailer->use_template('privmsg_notify', $to_userdata['user_lang']);
        $emailer->email_address($to_userdata['user_email']);
        $emailer->set_subject($lang['Notification_subject']);

        $emailer->assign_vars(array(
            'USERNAME' => $to_username,
            'SITENAME' => $board_config['sitename'],
            'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',

            'U_INBOX' => $server_protocol . $server_name . $server_port . $script_name . '?folder=inbox')
        );

        $emailer->send();
        $emailer->reset();
    }

    return;

    $msg = $lang['Message_sent'] . '<br /><br />' . sprintf($lang['Click_return_inbox'], '<a href="' . append_sid("privmsg.$phpEx?folder=inbox") . '">', '</a> ') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

    message_die(GENERAL_MESSAGE, $msg);

}

// function avc_post() -- Adds a new post to a specified forum by a specified user, and does all that junk. ;)
// This function is written by and belongs to netclectic of phpBB.com; I've edited it a bit to fix some bugs in the code (hey, it needs to work!)
// Also because of some changes to the function (to please the MOD team), this function now requires phpBB 2.0.11, unlike the original function, which was compatible with all phpBB releases
function avc_post( 
    $message, 
    $subject, 
    $forum_id, 
    $user_id, 
    $user_name, 
    $user_attach_sig, 
    $topic_id = NULL, 
    $topic_type = POST_NORMAL, 
    $do_notification = false, 
    $notify_user = false, 
    $current_time = 0, 
    $error_die_function = '', 
    $html_on = 0, 
    $bbcode_on = 1, 
    $smilies_on = 1 )
{
    global $db, $board_config, $html_entities_match, $html_entities_replace, $lang, $phpbb_root_path, $phpEx, $unhtml_specialchars_match, $unhtml_specialchars_replace, $user_ip;
    include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
    include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
    include_once($phpbb_root_path . 'includes/functions_search.'.$phpEx);

    // initialise some variables
    $topic_vote = 0; 
    $poll_title = '';
    $poll_options = '';
    $poll_length = '';
    $mode = 'reply'; 

    $bbcode_uid = ($bbcode_on) ? make_bbcode_uid() : ''; 
    $error_die_function = ($error_die_function == '') ? "message_die" : $error_die_function;
    $current_time = ($current_time == 0) ? time() : $current_time;
    
    // parse the message and the subject (belt & braces :)
    $message = addslashes(unprepare_message($message));
    $message = prepare_message(trim($message), $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
    $subject = addslashes(unprepare_message(trim(str_replace("\'", "''", $subject))));
    $username = phpbb_clean_username($user_name);    
    
    // if this is a new topic then insert the topic details
    if ( empty($topic_id) )
    {
        $mode = 'newtopic'; 
        $sql = "INSERT INTO " . TOPICS_TABLE . " (topic_title, topic_poster, topic_time, forum_id, topic_status, topic_type, topic_vote) VALUES ('$subject', " . $user_id . ", $current_time, $forum_id, " . TOPIC_UNLOCKED . ", $topic_type, $topic_vote)";
        if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
        {
            $error_die_function(GENERAL_ERROR, $lang['No_AVC_post'], '', __LINE__, __FILE__, $sql);
        }
        $topic_id = $db->sql_nextid();
    }

    // insert the post details using the topic id
    $sql = "INSERT INTO " . POSTS_TABLE . " (topic_id, forum_id, poster_id, post_username, post_time, poster_ip, enable_bbcode, enable_html, enable_smilies, enable_sig) VALUES ($topic_id, $forum_id, " . $user_id . ", '$username', $current_time, '$user_ip', $bbcode_on, $html_on, $smilies_on, $user_attach_sig)";
    if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
    {
        $error_die_function(GENERAL_ERROR, $lang['No_AVC_post'], '', __LINE__, __FILE__, $sql);
    }
    $post_id = $db->sql_nextid();
    
    // insert the actual post text for our new post
    $sql = "INSERT INTO " . POSTS_TEXT_TABLE . " (post_id, post_subject, bbcode_uid, post_text) VALUES ($post_id, '$subject', '$bbcode_uid', '$message')";
    if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
    {
        $error_die_function(GENERAL_ERROR, $lang['No_AVC_post'], '', __LINE__, __FILE__, $sql);
    }
    
    // update the post counts etc.
    $newpostsql = ($mode == 'newtopic') ? ',forum_topics = forum_topics + 1' : '';
    $sql = "UPDATE " . FORUMS_TABLE . " SET 
                forum_posts = forum_posts + 1,
                forum_last_post_id = $post_id
                $newpostsql 	
            WHERE forum_id = $forum_id";
    if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
    {
        $error_die_function(GENERAL_ERROR, $lang['No_AVC_post'], '', __LINE__, __FILE__, $sql);
    }
    
    // update the first / last post ids for the topic
    $first_post_sql = ( $mode == 'newtopic' ) ? ", topic_first_post_id = $post_id  " : ' , topic_replies=topic_replies+1'; 
    $sql = "UPDATE " . TOPICS_TABLE . " SET 
                topic_last_post_id = $post_id 
                $first_post_sql
            WHERE topic_id = $topic_id";
    if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
    {
        $error_die_function(GENERAL_ERROR, $lang['No_AVC_post'], '', __LINE__, __FILE__, $sql);
    }
    
    // update the user's post count and commit the transaction
    $sql = "UPDATE " . USERS_TABLE . " SET 
                user_posts = user_posts + 1
            WHERE user_id = $user_id";
    if ( !$db->sql_query($sql, END_TRANSACTION) )
    {
        $error_die_function(GENERAL_ERROR, $lang['No_AVC_post'], '', __LINE__, __FILE__, $sql);
    }
    
    // add the search words for our new post
    add_search_words('', $post_id, stripslashes($message), stripslashes($subject));
    
    // do we need to do user notification
    if ( ($mode == 'reply') && $do_notification )
    {
        $post_data = array();
        user_notification($mode, $post_data, $subject, $forum_id, $topic_id, $post_id, $notify_user);
    }
    
    // if all is well then return the id of our new post
    return array('post_id'=>$post_id, 'topic_id'=>$topic_id);
}

/* Version Checking functions
The order of using these functions goes in this order:
Either avc_version_check() or avc_one_version_check() is called; these will eventually call xml_version_check(), avc2_version_check(), or ch_version_check(). If the Notification System is on, then one of the Notification Functions (avc_notify_post(), avc_notify_pm(), avc_notify_email()) will be executed. These are displayed here in reverse order for compatibility.
*/

//
// Version Check Notification System
//

// function avc_notify_email() -- Sends a VCNS e-mail to the address specified in the ACP
function avc_notify_email($mod_rows, $latest_version, $mod_link, $download_link, $author_notes)
{
    // Get everything we need
    global $board_config, $emailer, $lang, $phpbb_root_path, $phpEx, $version_config;
    if ( !class_exists('emailer') )
    {
        include($phpbb_root_path . 'includes/emailer.'.$phpEx);
        $emailer = new emailer($board_config['smtp_delivery']);
    }
    // Only sending to one address
    if ( $version_config['update_email'] == UPDATE_EMAIL_ONE )
    {
        // Start our e-mail
        $emailer->from($board_config['board_email']);
        $emailer->replyto($board_config['board_email']);
        $emailer->use_template('avc_notify', $board_config['default_lang']);
        $emailer->email_address($version_config['email_address']);
        // Assign our vars
        $emailer->assign_vars(array(
            'MOD_NAME' => $mod_rows['mod_name'],
            'SITENAME' => $board_config['sitename'],
            'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',

            'LATEST_VERSION' => $latest_version,
            'CURRENT_VERSION' => $mod_rows['mod_current_version'],
            'MOD_LINK' => htmlspecialchars_decode($mod_link),
            'DOWNLOAD_LINK' => htmlspecialchars_decode($download_link),
            'AUTHOR_NOTES' => ($author_notes != '') ? $lang['Notes_from_author'] . ' ' . htmlspecialchars_decode($author_notes) : '')
        );
        // Send the e-mail
        $emailer->send();
        $emailer->reset();
    }
    // Sending to all admins
    elseif ( $version_config['update_email'] == UPDATE_EMAIL_ALL )
    {
        // Get the e-mail addresses of all the admins
        $sql = "SELECT user_email FROM " . USERS_TABLE . " WHERE user_level = " . ADMIN;
        if ( !$result = $db->sql_query($sql) )
        {
            message_die(GENERAL_ERROR, $lang['No_admin_addresses'], '', __LINE__, __FILE__, $sql);
        }
        // Loop through each admin
        while ( $row = $db->sql_fetchrow($result) )
        {
            // Start our e-mail
            $emailer->from($board_config['board_email']);
            $emailer->replyto($board_config['board_email']);
            $emailer->use_template('avc_notify', $board_config['default_lang']);
            $emailer->email_address($row['user_email']);
            // Assign our vars
            $emailer->assign_vars(array(
                'MOD_NAME' => $mod_rows['mod_name'],
                'SITENAME' => $board_config['sitename'],
                'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',

                'LATEST_VERSION' => $latest_version,
                'CURRENT_VERSION' => $mod_rows['mod_current_version'],
                'MOD_LINK' => htmlspecialchars_decode($mod_link),
                'DOWNLOAD_LINK' => htmlspecialchars_decode($download_link),
                'AUTHOR_NOTES' => $lang['Notes_from_author'] . ' ' . htmlspecialchars_decode($author_notes))
            );
            // Send the e-mail
            $emailer->send();
            $emailer->reset();
        }
    }
}

// function avc_notify_pm() -- Sends a VCNS e-mail to the user specified in the ACP
function avc_notify_pm($mod_rows, $latest_version, $mod_link, $download_link, $author_notes)
{
    // Get everything we need
    global $board_config, $db, $lang, $phpbb_root_path, $phpEx, $version_config;
    // Replace the variables in our post with our actual equivalents
    $pm_msg = str_replace('&%n', $mod_rows['mod_name'], $lang['Update_post_contents_default']); // Replace &%n with MOD Name
    $pm_msg = str_replace('&%v', $latest_version, $pm_msg); // Replace &%v with New MOD Version
    $pm_msg = str_replace('&%c', $mod_rows['mod_current_version'], $pm_msg); // Replace &%c with Current Version
    $pm_msg = str_replace('&%u', htmlspecialchars_decode($mod_link), $pm_msg); // Replace &%u with MOD Website
    $pm_msg = str_replace('&%d', htmlspecialchars_decode($download_link), $pm_msg); // Replace &%d with Download link
    $pm_msg = str_replace('&%a', $lang['Notes_from_author'] . ' ' . htmlspecialchars_decode($author_notes), $pm_msg); // Replace &%a with Author Notes
    // Only sending to one user
    if ( $version_config['update_pm'] == UPDATE_PM_ONE )
    {
        // Okay, we have the username, but we need the user ID
        $sql = "SELECT user_id FROM " . USERS_TABLE . " WHERE username = '" . $version_config['pm_id'] . "'";
        if ( !$result = $db->sql_query($sql) )
        {
            message_die(GENERAL_ERROR, $lang['No_PM_info'], '', __LINE__, __FILE__, $sql);
        }
        $row = $db->sql_fetchrow($result);
        // Send the PM
        avc_pm($row['user_id'], $pm_msg, sprintf($lang['VCNS_post_subject'], $mod_rows['mod_name']), BOARD_MAIN_ADMIN_ID);
    }
    // Sending to all the administrators
    elseif ( $version_config['update_pm'] == UPDATE_PM_ALL )
    {
        // Get the user ID of all the administrators
        $sql = "SELECT user_id FROM " . USERS_TABLE . " WHERE user_level = " . ADMIN;
        if ( !$result = $db->sql_query($sql) )
        {
            message_die(GENERAL_ERROR, $lang['No_PM_info'], '', __LINE__, __FILE__, $sql);
        }
        // Loop through each admin
        while ( $row = $db->sql_fetchrow($result) )
        {
            // Send the PM
            avc_pm($row['user_id'], $pm_msg, sprintf($lang['VCNS_post_subject'], $mod_rows['mod_name']), BOARD_MAIN_ADMIN_ID);
        }
    }
}

// function avc_notify_post() -- Makes a VCNS post in the forum specified in the ACP
function avc_notify_post($mod_rows, $latest_version, $mod_link, $download_link, $author_notes)
{
    // Get everything we need
    global $db, $lang, $phpbb_root_path, $phpEx, $version_config;
    // Get the username of the main administrator, we'll need this for our function
    $sql = "SELECT username FROM " . USERS_TABLE . " WHERE user_id = 2";
    if ( !$result = $db->sql_query($sql))
    {
        message_die(GENERAL_ERROR, $lang['No_post_info'], '', __LINE__, __FILE__, $sql);
    }
    $row = $db->sql_fetchrow($result);
    $username = $row['username'];
    // Replace the variables in our post with our actual equivalents
    $post_contents = str_replace('&%n', $mod_rows['mod_name'], $version_config['post_contents']); // Replace &%n with MOD Name
    $post_contents = str_replace('&%v', $latest_version, $post_contents); // Replace &%v with New MOD Version
    $post_contents = str_replace('&%c', $mod_rows['mod_current_version'], $post_contents); // Replace &%c with Current Version
    $post_contents = str_replace('&%u', htmlspecialchars_decode($mod_link), $post_contents); // Replace &%u with MOD Website
    $post_contents = str_replace('&%d', htmlspecialchars_decode($download_link), $post_contents); // Replace &%d with Download link
    $post_contents = str_replace('&%a', $lang['Notes_from_author'] . ' ' . htmlspecialchars_decode($author_notes), $post_contents); // Replace &%a with Author Notes
    // Insert the post
    avc_post($post_contents, sprintf($lang['VCNS_post_subject'], $mod_rows['mod_name']), $version_config['post_forum'], BOARD_MAIN_ADMIN_ID, $username, 0, '', POST_NORMAL, '', true); // The rest of the vars are unimportant -- if it doesn't work, the function message_dies on its own
}

//
// Version Checking Methods
//

// function xml_version_check() -- Runs the Version Check processes for the AVC 3 XML Version Checker
function xml_version_check($mod_rows)
{
    //
    // Some prefaces to do before we can begin
    //
    global $db, $lang, $version_config, $phpbb_root_path, $phpEx;
    $avc_xml = new avc_xml();
    $version = explode(".", $mod_rows['mod_current_version']);
    $head_revision = (int) $version[0];
    $minor_revision = (int) $version[2];
    
    //
    // Try to make sure we can open it first
    //
    $test_fopen = @fopen($mod_rows['mod_domain_loc'] . '/' . $mod_rows['mod_file_loc'] . '/' . $mod_rows['mod_file_name'] , 'r');
    if ( !$test_fopen )
    {
        avc_mod_error($mod_rows['mod_id'], $lang['No_retrievable']);
        return;
    }

    // Connect to our XML file
    $avc_xml->set_filename($mod_rows['mod_domain_loc'] . '/' . $mod_rows['mod_file_loc'] . '/' . $mod_rows['mod_file_name']);

    //
    // Read all our data from the file and get it together in a nice,
    // organized array
    //
    $version_check['version_info_stable'] = $avc_xml->read_node(array('avc_retrievable', 'stable', 'version'));
    $version_check['version_info_dev'] = $avc_xml->read_node(array('avc_retrievable', 'development', 'version'));
    $version_check['mod_link_stable'] = $avc_xml->read_node(array('avc_retrievable', 'stable', 'mod_link'));
    $version_check['mod_link_dev'] = $avc_xml->read_node(array('avc_retrievable', 'development', 'mod_link'));
    $version_check['download_link_stable'] = $avc_xml->read_node(array('avc_retrievable', 'stable', 'download_link'));
    $version_check['download_link_dev'] = $avc_xml->read_node(array('avc_retrievable', 'development', 'download_link'));
    $version_check['author_notes_stable'] = $avc_xml->read_node(array('avc_retrievable', 'stable', 'author_notes'));
    $version_check['author_notes_dev'] = $avc_xml->read_node(array('avc_retrievable', 'dev', 'author_notes'));
    // One of our two version infos has to have contents, otherwise we'll complain
    if ( !$version_check['version_info_stable'] && !$version_check['version_info_dev'] )
    {
        avc_mod_error($mod_rows['mod_id'], $lang['No_Version']);
    }

    //
    // Determine which links we are using -- the methods are:
    // If the status is stable: if there is no stable information, use
    // the development link, otherwise use the stable link. If the status
    // is development: if there is no development info, use the stable link,
    // otherwise use the development link. Same applies for the Author's Notes.
    //
    $mod_link = ( $mod_rows['mod_dev_status'] == 'stable' ) ? ( !$version_check['version_info_stable'] ? $version_check['mod_link_dev'] : $version_check['mod_link_stable'] ) : ( !$version_check['version_info_dev'] ? $version_check['mod_link_stable'] : $version_check['mod_link_dev'] );
    $download_link = ( $mod_rows['mod_dev_status'] == 'stable' ) ? ( !$version_check['version_info_stable'] ? $version_check['download_link_dev'] : $version_check['download_link_stable'] ) : ( !$version_check['version_info_dev'] ? $version_check['download_link_stable'] : $version_check['download_link_dev'] );
    $authors_notes = ( $mod_rows['mod_dev_status'] == 'stable' ) ? ( !$version_check['version_info_stable'] ? $version_check['author_notes_dev'] : $version_check['author_notes_stable'] ) : ( !$version_check['version_info_dev'] ? $version_check['author_notes_stable'] : $version_check['author_notes_dev'] );

    //
    // This is the fun part--which here is our primary version info and
    // which is our secondary?
    //
    $version_info = ( $mod_rows['mod_dev_status'] == 'stable' ) ? ( !$version_check['version_info_stable'] ? $version_check['version_info_dev'] : $version_check['version_info_stable'] ) : ( !$version_check['version_info_dev'] ? $version_check['version_info_stable'] : $version_check['version_info_dev'] );
    $secondary_version_info = ( $mod_rows['mod_dev_status'] == 'stable' ) ? ( !$version_check['version_info_dev'] ? '' : $version_check['version_info_dev'] ) : ( !$version_check['version_info_stable'] ? '' : $version_check['version_info_stable'] );
    
    //
    // Split up our Version Infos and do comparisons
    // The usage of (int) here verifies that we are comparing numbers;
    // anything extra the author has included is unimportant here
    //
    $current_version_info = explode('.', $mod_rows['mod_current_version']);
    $current_head_revision = (int) $current_version_info[0];
    $current_middle_revision = (int) $current_version_info[1];
    $current_minor_revision = (int) $current_version_info[2];
    $version_info = explode('.', $version_info);
    $latest_head_revision = (int) $version_info[0];
    $latest_middle_revision = (int) $version_info[1];
    $latest_minor_revision = (int) $version_info[2];
    $latest_version = $version_info[0] . '.' . $version_info[1] . '.' . $version_info[2];
    $secondary_version_info = explode('.', $secondary_version_info);
    $secondary_head_revision = (int) $secondary_version_info[0];
    $secondary_middle_revision = (int) $secondary_version_info[1];
    $secondary_minor_revision = (int) $secondary_version_info[2];
    // See if our secondary Version Info can live up to the challenge of the primary one ;)
    $secondary_version = ( $secondary_head_revision > $latest_head_revision || ($secondary_middle_revision > $latest_middle_revision && $secondary_head_revision == $latest_head_revision) || ($secondary_minor_revision > $latest_minor_revision && $secondary_middle_revision == $latest_middle_revision && $secondary_head_revision == $latest_head_revision) ) ? $secondary_version_info[0] . '.' . $secondary_version_info[1] . '.' . $secondary_version_info[2] : '';
    $current_time = time();
    
    //
    // Do we need to send a notification of a new version?
    //
    if ( ( $latest_head_revision > $current_head_revision || ($latest_middle_revision > $current_middle_revision && $latest_head_revision == $current_head_revision) || ($latest_minor_revision > $current_minor_revision && $latest_middle_revision == $current_middle_revision && $latest_head_revision == $current_head_revision) ) && $mod_rows['mod_new_version'] != $latest_version ) // If the new version is newer than the current version and is different from what is the currently stored new version
    {
        // Send an e-mail
        if ($version_config['update_email'] != UPDATE_EMAIL_NO)
        {
            avc_notify_email($mod_rows, $latest_version, $mod_link, $download_link, $author_notes);
        }
        // Send a PM
        if ($version_config['update_pm'] != UPDATE_PM_NO)
        {
            avc_notify_pm($mod_rows, $latest_version, $mod_link, $download_link, $author_notes);
        }
        // Insert a post
        if ($version_config['update_post'])
        {
            avc_notify_post($mod_rows, $latest_version, $mod_link, $download_link, $author_notes);
        }
        // Add it to the log
        avc_log_add($mod_rows['mod_name'], sprintf($lang['Log_MOD_updated'], $latest_version));
    }
    
    //
    // Update the database
    // Note here that we also set mod_error to none because if we've gotten
    // far, we haven't had an error :)
    //
    $sql = "UPDATE " . VERSION_CHECK_TABLE . "
            SET mod_time_stamp = '$current_time', mod_new_version = '" . str_replace("\'", "''", $latest_version) . "', mod_secondary_version = '" . str_replace("\'", "''", $secondary_version) . "', mod_download_loc = '" . str_replace("\'", "''", $download_link) . "', mod_topic_loc = '" . str_replace("\'", "''", $mod_link) . "', mod_author_notes = '" . str_replace("\'", "''", $author_notes) . "', mod_error = ''
            WHERE mod_id = " . $mod_rows['mod_id'];
    if ( !$db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, sprintf($lang['No_update_version_table'], $mod_rows['mod_name']), '', __LINE__, __FILE__, $sql);
    }
    return;
}

// function avc2_version_check() -- Runs the Version Check processes for phpBB and the AVC 2 Version Checker
function avc2_version_check($mod_rows)
{
    //
    // Some prefaces to do before we can begin
    //
    global $db, $lang;
	$current_version = $mod_rows['mod_current_version'];
	$version = explode(".", $current_version);
	$head_revision = (int) $version[0];
	$minor_revision = (int) $version[2];
	$mod_domain_loc = $mod_rows['mod_domain_loc'];
	$mod_file_loc = $mod_rows['mod_file_loc'];
	$mod_file_name = $mod_rows['mod_file_name'];
    $errno = 0;
    $errstr = '';
    $version_info = '';

    //
    // Connect to the retrievable file and get everything we need
    //
    if ($fsock = @fsockopen($mod_domain_loc, 80, $errno, $errstr))
    {
        @fputs($fsock, "GET /$mod_file_loc/$mod_file_name HTTP/1.1\r\n");
        @fputs($fsock, "HOST: $mod_domain_loc\r\n");
        @fputs($fsock, "Connection: close\r\n\r\n");
        $get_info = false;
        while (!@feof($fsock))
        {
            if ($get_info)
            {
                $version_info .= @fread($fsock, 1024);
            }
            else
            {
                if (@fgets($fsock, 1024) == "\r\n")
                {
                    $get_info = true;
                }
            }
        }
        @fclose($fsock);
        //
        // Figure out what it all means
        // The (int) ensures that we aren't noticing any extra characters
        // the author may have included
        //
        $version_info = explode("\n", $version_info);
        $latest_head_revision = (int) $version_info[0];
        $latest_middle_revision = (int) $version_info[1];
        $latest_minor_revision = (int) $version_info[2];
        $latest_version = $version_info[0] . '.' . $version_info[1] . '.' . $version_info[2];
        $current_time = time();
        
        //
        // Do we need to send a notification?
        //
        $current_version_info = explode('.', $mod_rows['mod_current_version']);
        $current_head_revision = (int) $current_version_info[0];
        $current_middle_revision = (int) $current_version_info[1];
        $current_minor_revision = (int) $current_version_info[2];
        if ( ( $latest_head_revision > $current_head_revision || ($latest_middle_revision > $current_middle_revision && $latest_head_revision == $current_head_revision) || ($latest_minor_revision > $current_minor_revision && $latest_middle_revision == $current_middle_revision && $latest_head_revision == $current_head_revision) ) && $mod_rows['mod_new_version'] != $latest_version ) // If the new version is newer than the current version and is different from what is the currently stored new version
        {
            // Send an e-mail
            if ($version_config['update_email'] != UPDATE_EMAIL_NONE)
            {
                avc_notify_email($mod_rows, $latest_version, $mod_link, $download_link, '');
            }
            // Send a PM
            if ($version_config['update_pm'] != UPDATE_PM_NONE)
            {
                avc_notify_pm($mod_rows, $latest_version, $mod_link, $download_link, '');
            }
            // Insert a post
            if ($version_config['update_post'])
            {
                avc_notify_post($mod_rows, $latest_version, $mod_link, $download_link, '');
            }
            // Add it to the log
            avc_log_add($mod_rows['mod_name'], sprintf($lang['Log_MOD_updated'], $latest_version));
        }
        
        //
        // Update the database with the latest info
        //
        if ($latest_head_revision == $head_revision && $minor_revision == $latest_minor_revision)
        {
            $newsql = "UPDATE " . VERSION_CHECK_TABLE . "
                    SET mod_time_stamp = '$current_time', mod_new_version = '" . str_replace("\'", "''", $current_version) . "', mod_error = ''
                    WHERE mod_id = " . $mod_rows['mod_id'] . "";

            if ( !$db->sql_query($newsql) )
            {
                message_die(GENERAL_ERROR, sprintf($lang['No_update_version_table'], $mod_rows['mod_name']), '', __LINE__, __FILE__, $sql);
            }
        }
        else
        {
            $newsql = "UPDATE " . VERSION_CHECK_TABLE . "
                    SET mod_time_stamp = '$current_time', mod_new_version = '" . str_replace("\'", "''", $latest_version) . "', mod_error = ''
                    WHERE mod_id = " . $mod_rows['mod_id'] . "";
            if ( !$db->sql_query($newsql) )
            {
                message_die(GENERAL_ERROR, sprintf($lang['No_update_version_table'], $mod_rows['mod_name']), '', __LINE__, __FILE__, $sql);
            }
        }
    }
    	
    //
    // Can't connect to the file for whatever reason, so complain
    //
    else
    {
        if ($errstr)
        {
            avc_mod_error($mod_rows['mod_id'], $lang['No_retrievable']);
        }
        else
        {
            avc_mod_error($mod_rows['mod_id'], $lang['No_retrievable_socket']);
        }
    }
}

// function ch_version_check() -- Runs the version check processes for Categories Hierarchy and its goodies
function ch_version_check($mod_rows)
{
    //
    // Some prefaces to do before we can begin
    //
    global $db, $lang;
	$current_version = $mod_rows['mod_current_version'];
	$version = explode(".", $current_version);
	$head_revision = (int) $version[0];
	$minor_revision = (int) $version[2];
	$mod_domain_loc = $mod_rows['mod_domain_loc'];
	$mod_file_loc = $mod_rows['mod_file_loc'];
	$mod_file_name = $mod_rows['mod_file_name'];

    //
    // Connect to the retrievable file and get everything we need
    //
    if ($fsock = @fsockopen($mod_domain_loc, 80, $errno, $errstr))
    {
        @fputs($fsock, "GET /$mod_file_loc/$mod_file_name HTTP/1.1\r\n");
        @fputs($fsock, "HOST: $mod_domain_loc\r\n");
        @fputs($fsock, "Connection: close\r\n\r\n");

        $get_info = false;
        $version_info = '';
        while (!@feof($fsock))
        {
            if ($get_info)
            {
                $version_info .= @fread($fsock, 1024);
            }
            else
            {
                if (@fgets($fsock, 1024) == "\r\n")
                {
                    $get_info = true;
                }
            }
        }
        @fclose($fsock);
        //
        // Figure out what it all means
        //
        $version_info = explode("\n", $version_info);
        $count_available = count($version_info);
        if($mod_rows['mod_name'] == 'mod_cat_hierarchy')
        {
            $str = trim(str_replace(array("\r", "\n"), array('', ''), $version_info[0]));
        }
        elseif($mod_rows['mod_name'] == 'mod_topic_calendar_CH')
        {
            $str = trim(str_replace(array("\r", "\n"), array('', ''), $version_info[1]));
        }
        elseif($mod_rows['mod_name'] == 'mod_extended_tpl_CH')
        {
            $str = trim(str_replace(array("\r", "\n"), array('', ''), $version_info[2]));
        }
        $line = explode(':', $str);
        $mod_name = trim($line[0]);
        $mod_version = trim($line[1]);
        $version_info = explode(".", $mod_version);
        $latest_head_revision = (int) $version_info[0];
        $latest_middle_revision = (int) $version_info[1];
        $latest_minor_revision = (int) $version_info[2];
        $latest_version = $version_info[0] . '.' . $version_info[1] . '.' . $version_info[2];
        
        //
        // Do we need to send a notification?
        //
        $current_version_info = explode('.', $mod_rows['mod_current_version']);
        $current_head_revision = (int) $current_version_info[0];
        $current_middle_revision = (int) $current_version_info[1];
        $current_minor_revision = (int) $current_version_info[2];
        if ( ( $latest_head_revision > $current_head_revision || ($latest_middle_revision > $current_middle_revision && $latest_head_revision == $current_head_revision) || ($latest_minor_revision > $current_minor_revision && $latest_middle_revision == $current_middle_revision && $latest_head_revision == $current_head_revision) ) && $mod_rows['mod_new_version'] != $latest_version ) // If the new version is newer than the current version and is different from what is the currently stored new version
        {
            // Send an e-mail
            if ($version_config['update_email'] != UPDATE_EMAIL_NONE)
            {
                avc_notify_email($mod_rows, $latest_version, $mod_link, $download_link, '');
            }
            // Send a PM
            if ($version_config['update_pm'] != UPDATE_PM_NONE)
            {
                avc_notify_pm($mod_rows, $latest_version, $mod_link, $download_link, '');
            }
            // Insert a post
            if ($version_config['update_post'])
            {
                avc_notify_post($mod_rows, $latest_version, $mod_link, $download_link, '');
            }
            // Add it to the log
            avc_log_add($mod_rows['mod_name'], sprintf($lang['Log_MOD_updated'], $latest_version));
        }

        //
        // Update the database with the latest info
        //
        if ($latest_head_revision == $head_revision && $minor_revision == $latest_minor_revision)
        {
            $newsql = "UPDATE " . VERSION_CHECK_TABLE . "
                    SET mod_time_stamp = '$current_time', mod_new_version = '" . str_replace("\'", "''", $current_version) . "', mod_error = ''
                    WHERE mod_id = " . $mod_rows['mod_id'] . "";

            if ( !$db->sql_query($newsql) )
            {
                message_die(GENERAL_ERROR, sprintf($lang['No_update_version_table'], $mod_rows['mod_name']), '', __LINE__, __FILE__, $sql);
            }
        }
        else
        {
            $newsql = "UPDATE " . VERSION_CHECK_TABLE . "
                    SET mod_time_stamp = '$current_time', mod_new_version = '" . str_replace("\'", "'''", $latest_version) . "', mod_error = ''
                    WHERE mod_id = " . $mod_rows['mod_id'] . "";
            if ( !$db->sql_query($newsql) )
            {
                message_die(GENERAL_ERROR, sprintf($lang['No_update_version_table'], $mod_rows['mod_name']), '', __LINE__, __FILE__, $sql);
            }
        }
    }
    	
    //
    // Can't connect to the file for whatever reason, so complain
    //
    else
    {
        if ($errstr)
        {
            avc_mod_error($mod_rows['mod_id'], $lang['No_retrievable']);
        }
        else
        {
            avc_mod_error($mod_rows['mod_id'], $lang['No_retrievable_socket']);
        }
    }
}

//
// Version Check Calling Functions
//

// function avc_version_check() -- Runs through the preliminary stuff to get the Version Check going, and then runs the correct Version Check function for each file MOD
function avc_version_check($time_restrict = 1)
{
    global $version_config, $db, $lang;
    //
    // Select everything we need from the Version Check table
    //
    $sql = "SELECT mod_id, mod_name, mod_status, mod_current_version, mod_new_version, mod_time_stamp, mod_file_name, mod_domain_loc, mod_file_loc, mod_dev_status, mod_error
            FROM " . VERSION_CHECK_TABLE . " WHERE mod_status = 1
            ORDER BY mod_id";
    if ( !$q_mod = $db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, $lang['No_Version_Data'], '', __LINE__, __FILE__, $sql);
    }
    $total_mods = $db->sql_numrows($q_mod);
    $mod_rows = $db->sql_fetchrowset($q_mod);
    $db->sql_freeresult($q_mod);

    //
    // Loop through each MOD
    //
    for ($i = 0; $i < $total_mods; $i++)
    {
        // Split the retrievable filename to determine its type
        $retreive_filetype = explode('.', $mod_rows[$i]['mod_file_name'], 2);
        $filetype_whitelist = array('dta', 'txt', 'xml');
        // Make sure we aren't loading a potentially dangerous file
        if ( !in_array($retreive_filetype[1], $filetype_whitelist) )
        {
            avc_mod_error($mod_rows[$i]['mod_id'], $lang['Invalid_retrievable']);
            continue;
        }
        // We've checked this recently and are not overriding our timer
        if ( $time_restrict == 1 && (time() - $mod_rows[$i]['mod_time_stamp']) < $version_config['check_time'] )
        {
            continue;
        }

        //
        // Load the correct function for the correct MOD
        //
        // MOD is phpBB
        if ( $mod_rows[$i]['mod_name'] == 'phpBB' )
        {
            avc2_version_check($mod_rows[$i]);
        }
        // MOD is Categories Hieararchy or a goodie
        elseif ( $mod_rows[$i]['mod_name'] == 'mod_cat_hierarchy' || $mod_rows[$i]['mod_name'] == 'mod_topic_calendar_CH' || $mod_rows[$i]['mod_name'] == 'mod_extended_tpl_CH' )
        {
            ch_version_check($mod_rows[$i]);
        }
        // MOD is an AVC 2 checker
        elseif ( $retreive_filetype[1] != 'xml' )
        {
            avc2_version_check($mod_rows[$i]);
        }
        // MOD is an AVC 3 checker
        else
        {
            xml_version_check($mod_rows[$i]);
        }
    }
}

// function avc_one_version_check() -- Runs through the preliminary stuff to get the Version Check going, and then runs the correct Version Check function for a specific MOD
function avc_one_version_check($mod_id)
{
    global $db, $lang;
    if ( $mod_id == '' )
    {
        message_die(CRITICAL_ERROR, $lang['No_checker_ID']);
    }
    //
    // Select everything we need from the Version Check table
    //
    $sql = "SELECT mod_id, mod_name, mod_status, mod_current_version, mod_new_version, mod_time_stamp, mod_file_name, mod_domain_loc, mod_file_loc, mod_dev_status, mod_error
            FROM " . VERSION_CHECK_TABLE . " WHERE mod_id = $mod_id
            ORDER BY mod_id";
    if ( !$q_mod = $db->sql_query($sql) )
    {
        message_die(GENERAL_ERROR, $lang['No_Version_Data'], '', __LINE__, __FILE__, $sql);
    }
    $total_mods = $db->sql_numrows($q_mod);
    $mod_rows = $db->sql_fetchrow($q_mod);
    $db->sql_freeresult($q_mod);

    // Split the retrievable filename to determine its type
    $retreive_filetype = explode('.', $mod_rows['mod_file_name'], 2);
    $filetype_whitelist = array('dta', 'txt', 'xml');
    // Make sure we aren't loading a potentially dangerous file
    if ( !in_array($retreive_filetype[1], $filetype_whitelist) )
    {
        avc_mod_error($mod_rows['mod_id'], $lang['Invalid_retrievable']);
        return;
    }

    //
    // Load the correct function for the correct MOD
    //

    // MOD is phpBB
    if ( $mod_rows['mod_name'] == 'phpBB' )
    {
        avc2_version_check($mod_rows);
    }
    // MOD is Categories Hierarchy or a goodie
    elseif ( $mod_rows['mod_name'] == 'mod_cat_hierarchy' || $mod_rows['mod_name'] == 'mod_topic_calendar_CH' || $mod_rows['mod_name'] == 'mod_extended_tpl_CH' )
    {
        ch_version_check($mod_rows);
    }
    // MOD is an AVC 2 checker
    elseif ( $retreive_filetype[1] != 'xml' )
    {
        avc2_version_check($mod_rows);
    }
    // MOD is an AVC 3 checker
    else
    {
        xml_version_check($mod_rows);
    }
}
?>