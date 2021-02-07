<?php
/***************************************************************************
 *                             admin_acpuser.php
 *                            -------------------
 *   begin                : December 7, 2005
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

/* Prerequisities */
//
// Let the ACP know this file exists
//
define('IN_PHPBB', 1); 

if( !empty($setmodules) ) 
{ 
    $file = basename(__FILE__); 
    $module['Users']['Register_User'] = $file;
    return; 
}
// 
// Load the default header 
// 
$no_page_header = FALSE; 
$phpbb_root_path = './../'; 
require($phpbb_root_path . 'extension.inc'); 
require($phpbb_root_path . 'admin/pagestart.'.$phpEx);
include($phpbb_root_path . 'includes/functions_mod_user.'.$phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
include_once($phpbb_root_path . 'includes/functions_validate.'.$phpEx);
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
// 
// User must be logged in and be an admin
// 
if( !$userdata['session_logged_in'] ) 
{ 
    redirect(append_sid("login.$phpEx?redirect=admin/admin_tag.$phpEx", true)); 
}
if( $userdata['user_level'] != ADMIN )
{
    message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}

//
// Determine our mode and action
//
if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
    $mode = isset($HTTP_POST_VARS['mode']) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
}
else
{
    // If none is specified, the user is viewing this page for the first time, so we'll throw our simple mode at them
    $mode = 'simple';
}
if ( isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']) )
{
    $action = isset($HTTP_POST_VARS['action']) ? htmlspecialchars($HTTP_POST_VARS['action']) : htmlspecialchars($HTTP_GET_VARS['action']);
}
else
{
    $action = '';
}

/* Initialize each variable for the form, also a little bit of parsing if the form was submitted */
// Initialize these variables in case we need them later
$error = FALSE;
$error_msg = '';

switch ($mode)
{
    case 'simple':
        $strip_var_list['email'] = 'email';
        break;
    case 'advanced':
        $strip_var_list = array('email' => 'email', 'icq' => 'icq', 'aim' => 'aim', 'msn' => 'msn', 'yim' => 'yim', 'website' => 'website', 'location' => 'location', 'occupation' => 'occupation', 'interests' => 'interests');
        break;
    // If there's no mode, something is REALLY wrong
    default:
        message_die(CRITICAL_ERROR, 'No registration mode was specified!', '', _LINE__, __FILE__);
        break;
}

// Strip all tags from data ... may p**s some people off, bah, strip_tags is
// doing the job but can still break HTML output ... have no choice, have
// to use htmlspecialchars ... be prepared to be moaned at.
while( list($var, $param) = @each($strip_var_list) )
{
    if ( !empty($HTTP_POST_VARS[$param]) )
    {
        $$var = trim(htmlspecialchars($HTTP_POST_VARS[$param]));
    }
}

$username = ( !empty($HTTP_POST_VARS['username']) ) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';

$trim_var_list = array('new_password' => 'new_password', 'password_confirm' => 'password_confirm');
if ( $mode == 'advanced' )
{
    $trim_var_list['signature'] = 'signature';
}

while( list($var, $param) = @each($trim_var_list) )
{
    if ( !empty($HTTP_POST_VARS[$param]) )
    {
        $$var = trim($HTTP_POST_VARS[$param]);
    }
}

if ( $mode == 'advanced' )
{
    $signature = str_replace('<br />', "\n", $signature);

    // Run some validation on the optional fields. These are pass-by-ref, so they'll be changed to
    // empty strings if they fail.
    validate_optional_fields($icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature);

    $viewemail = ( isset($HTTP_POST_VARS['viewemail']) ) ? ( ($HTTP_POST_VARS['viewemail']) ? TRUE : 0 ) : 0;
    $allowviewonline = ( isset($HTTP_POST_VARS['hideonline']) ) ? ( ($HTTP_POST_VARS['hideonline']) ? 0 : TRUE ) : TRUE;
    $notifyreply = ( isset($HTTP_POST_VARS['notifyreply']) ) ? ( ($HTTP_POST_VARS['notifyreply']) ? TRUE : 0 ) : 0;
    $notifypm = ( isset($HTTP_POST_VARS['notifypm']) ) ? ( ($HTTP_POST_VARS['notifypm']) ? TRUE : 0 ) : TRUE;
    $popup_pm = ( isset($HTTP_POST_VARS['popup_pm']) ) ? ( ($HTTP_POST_VARS['popup_pm']) ? TRUE : 0 ) : TRUE;
    $attachsig = ( isset($HTTP_POST_VARS['attachsig']) ) ? ( ($HTTP_POST_VARS['attachsig']) ? TRUE : 0 ) : $board_config['allow_sig'];
    $allowhtml = ( isset($HTTP_POST_VARS['allowhtml']) ) ? ( ($HTTP_POST_VARS['allowhtml']) ? TRUE : 0 ) : $board_config['allow_html'];
    $allowbbcode = ( isset($HTTP_POST_VARS['allowbbcode']) ) ? ( ($HTTP_POST_VARS['allowbbcode']) ? TRUE : 0 ) : $board_config['allow_bbcode'];
    $allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $board_config['allow_smilies'];
    $user_style = ( isset($HTTP_POST_VARS['style']) ) ? intval($HTTP_POST_VARS['style']) : $board_config['default_style'];
    if ( !empty($HTTP_POST_VARS['language']) )
    {
        if ( preg_match('/^[a-z_]+$/i', $HTTP_POST_VARS['language']) )
        {
            $user_lang = htmlspecialchars($HTTP_POST_VARS['language']);
        }
        else
        {
            $error = true;
            $error_msg = ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Fields_empty'];
        }
    }
    else
    {
        $user_lang = $board_config['default_lang'];
    }
    $user_timezone = ( isset($HTTP_POST_VARS['timezone']) ) ? doubleval($HTTP_POST_VARS['timezone']) : $board_config['board_timezone'];

    $sql = "SELECT config_value
            FROM " . CONFIG_TABLE . "
            WHERE config_name = 'default_dateformat'";
    if ( !($result = $db->sql_query($sql)) )
    {
        message_die(GENERAL_ERROR, 'Could not select default dateformat', '', __LINE__, __FILE__, $sql);
    }
    $row = $db->sql_fetchrow($result);
    $board_config['default_dateformat'] = $row['config_value'];
    $user_dateformat = ( !empty($HTTP_POST_VARS['dateformat']) ) ? trim(htmlspecialchars($HTTP_POST_VARS['dateformat'])) : $board_config['default_dateformat'];
}

/* Do error-checking on returned information */
if ( $action == 'submit' )
{
    //
    // Make up a list of excuses to give an error message
    //
    // Make sure that some required fields were filled out
    if ( empty($username) || empty($new_password) || empty($password_confirm) || empty($email) )
    {
        $error = TRUE;
        $error_msg = $lang['Fields_empty'];
    }
    // Make sure that the passwords pass
    if ( !empty($new_password) && !empty($password_confirm) )
    {
        if ( $new_password != $password_confirm )
        {
            $error = TRUE;
            $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
        }
        elseif ( strlen($new_password) > 32 )
        {
            $error = TRUE;
            $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_long'];
        }
        else
        {
            if ( !$error )
            {
                $new_password = md5($new_password);
            }
        }
    }
    elseif ( ( empty($new_password) && !empty($password_confirm) ) || ( !empty($new_password) && empty($password_confirm) ) )
    {
        $error = TRUE;
        $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
    }

    if ( $mode == 'advanced' )
    {
        if ( $signature != '' )
        {
            if ( strlen($signature) > $board_config['max_sig_chars'] )
            {
                $error = TRUE;
                $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Signature_too_long'];
            }

            if ( !isset($signature_bbcode_uid) || $signature_bbcode_uid == '' )
            {
                $signature_bbcode_uid = ( $allowbbcode ) ? make_bbcode_uid() : '';
            }
            $signature = prepare_message($signature, $allowhtml, $allowbbcode, $allowsmilies, $signature_bbcode_uid);
        }
        if ( $website != '' )
        {
            rawurlencode($website);
        }
    }

    /* Insert the user */
    if ( !$error )
    {
        $user = new user($username, $new_password, $email);

        //
        // With the info we have, run validation checks on this user to make
        // sure we aren't going over problems with bans, etc.
        //
        if ( !$validate_result = $user->validate_user() )
        {
            message_die(GENERAL_ERROR, $lang['User_validation_error']);
        }
    
        //
        // Now send everything else over to our $user class if advaned mode
        // The class uses defaults if anything isn't sent
        //
        if ( $mode == 'advanced' )
        {
            // All user's fields
            $user->set_field('user_from', $location);
            $user->set_field('user_occ', $occupation);
            $user->set_field('user_interests', $interests);
            $user->set_field('user_website', $website);
            $user->set_field('user_icq', $icq);
            $user->set_field('user_aim', $aim);
            $user->set_field('user_yim', $yim);
            $user->set_field('user_msnm', $msn);
            $user->set_field('user_sig', $signature);
            $user->set_field('user_viewemail', $viewemail);
            $user->set_field('user_attachsig', $attachsig);
            $user->set_field('user_allowsmile', $allowsmilies);
            $user->set_field('user_allowhtml', $allowhtml);
            $user->set_field('user_allowbbcode', $allowbbcode);
            $user->set_field('user_allow_viewonline', $allowviewonline);
            $user->set_field('user_notify', $notifyreply);
            $user->set_field('user_notify_pm', $notifypm);
            $user->set_field('user_popup_pm', $popup_pm);
            $user->set_field('user_timezone', $user_timezone);
            $user->set_field('user_dateformat', $user_dateformat);
            $user->set_field('user_lang', $user_lang);
            $user->set_field('user_style', $user_style);
            
            // Now we'll go through our groups -- we do this by getting the groups that exist first
            $sql = "SELECT group_id
                    FROM " . GROUPS_TABLE . "
                    WHERE group_single_user <> " . TRUE . "
                    ORDER BY group_name";
            if ( !$result = $db->sql_query($sql) )
            {
                message_die(GENERAL_ERROR, $lang['No_group_list'], '', __LINE__, __FILE__, $sql);
            }
            // Now loop through each group and see if that group was checked -- if it was, send that to the class
            while ( $row = $db->sql_fetchrow($result) )
            {
                $group_id = $row['group_id'];
                if ( $HTTP_POST_VARS['group'][$group_id] )
                {
                    $user->add_to_group($group_id);
                }
            }
            $db->sql_freeresult($result);
        }
        // Go ahead and insert the user
        if ( !$insert_user_result = $user->insert_user() )
        {
            message_die(GENERAL_ERROR, $lang['No_user_in_db'], '', __LINE__, __FILE__, $sql);
        }
        // Success!
        else
        {
            //
            // Tell the user that he/she has been created, if we're supposed to
            //
            if ( $HTTP_POST_VARS['registration_send_email'] )
            {
                // Define the class, if necessary
                if ( !class_exists('emailer') )
                {
                    include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
                    $emailer = new emailer($board_config['smtp_delivery']);
                }
                // Start our e-mail
                $emailer->from($board_config['board_email']);
                $emailer->replyto($board_config['board_email']);
                $emailer->use_template('user_welcome', ( isset($user_lang) ) ? $user_lang : $board_config['default_lang']);
                $emailer->email_address($email);
                // Assign our vars
                $emailer->assign_vars(array(
                    'SITENAME' => $board_config['sitename'],
                    'WELCOME_MSG' => sprintf($lang['ACP_new_user_email'], $board_config['sitename'], $userdata['username']),
                    'USERNAME' => $username,
                    'PASSWORD' => $password_confirm,
                    'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '')
                );
                $emailer->send();
                $emailer->reset();
            }
            
            //
            // Tell the admin to celebrate
            //
            $message = sprintf($lang['ACP_new_user_added'], '<a href="' . $phpbb_root_path . 'profile.'.$phpEx . '?mode=viewprofile&u=' . $user->get_user_id() . '" target="_blank">', '</a>') . '<br /><br />' . sprintf($lang['Add_another_user'], '<a href="' . append_sid('admin_acpuser.'.$phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.'.$phpEx . '?pane=right') . '">', '</a>');
            message_die(GENERAL_MESSAGE, $message);
        }
    }
    
    //
    // We incurred an error, therefore, we need to stripslashes on returned data
    //
    else
    {
        $username = stripslashes($username);
        $email = stripslashes($email);
        $new_password = '';
        $password_confirm = '';
        $icq = stripslashes($icq);
        $aim = str_replace('+', ' ', stripslashes($aim));
        $msn = stripslashes($msn);
        $yim = stripslashes($yim);
        $website = stripslashes($website);
        $location = stripslashes($location);
        $occupation = stripslashes($occupation);
        $interests = stripslashes($interests);
        $signature = stripslashes($signature);
        $signature = ($signature_bbcode_uid != '') ? preg_replace("/:(([a-z0-9]+:)?)$signature_bbcode_uid(=|\])/si", '\\3', $signature) : $signature;
        $user_lang = stripslashes($user_lang);
        $user_dateformat = stripslashes($user_dateformat);
    }
}

/* Display the page */

//
// Let's just make sure now that we know where the .tpl is...
//
$template->set_filenames(array(
    "body" => "admin/acpuser_body.tpl")
);

//
// Was there an error? If so, set up that var
//
if ( $error )
{
    $template->set_filenames(array(
        'reg_header' => 'error_body.tpl')
    );
    $template->assign_vars(array(
        'ERROR_MESSAGE' => $error_msg)
    );
    $template->assign_var_from_handle('ERROR_BOX', 'reg_header');
}

//
// Set up our advanced mode switch
//
if ( $mode == 'advanced' )
{
    $template->assign_block_vars('switch_advanced_mode', array());

    //
    // Set up our list of groups
    // Note that this isn't super important to registering the user (at this
    // point) so if it doesn't work, we won't spit an error
    //
    $sql = "SELECT group_id, group_name
            FROM " . GROUPS_TABLE . "
            WHERE group_single_user <> " . TRUE . "
            ORDER BY group_name";
    if ( $result = $db->sql_query($sql) )
    {
        // Only do this if there's some groups
        if ( $db->sql_numrows($result) > 0 )
        {
            $template->assign_block_vars('switch_list_groups', array(
                'L_ADD_TO_GROUPS' => $lang['Add_to_groups'],
                'L_ADD_TO_GROUPS_EXPLAIN' => $lang['Add_to_groups_explain'])
            );
            // Loop through each group
            while ( $row = $db->sql_fetchrow($result) )
            {
                $template->assign_block_vars('switch_list_groups.groups_list', array(
                    'S_GROUP_ID' => $row['group_id'],
                    'S_GROUP_NAME' => $row['group_name'])
                );
            }
        }
    }
    $db->sql_freeresult($result);
}

//
// Specify our hidden fields
//
$s_hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="action" value="submit" />';

//
// Assign our vars to display the page
//
$template->assign_vars(array(
    'L_ACPUSER_HEADER' => $lang['Register_new_user'],
    'L_ACPUSER_EXPLAIN' => $lang['ACP_User_explain'],
    'ACPUSER_MODE_SWITCH' => ($mode == 'simple') ? sprintf($lang['ACP_User_Simple'], '<b>', '</b>') . ' | ' . sprintf($lang['ACP_User_Advanced'] , '<a href="' . append_sid("{$phpbb_root_path}admin/admin_acpuser.$phpEx?mode=advanced") . '">', '</a>') : sprintf($lang['ACP_User_Simple'], '<a href="' . append_sid("{$phpbb_root_path}admin/admin_acpuser.$phpEx?mode=simple") . '">', '</a>') . ' | ' . sprintf($lang['ACP_User_Advanced'], '<b>', '</b>'),

    'USERNAME' => $username,
    'NEW_PASSWORD' => $new_password,
    'PASSWORD_CONFIRM' => $password_confirm,
    'EMAIL' => $email,
    'YIM' => $yim,
	'ICQ' => $icq,
    'MSN' => $msn,
	'AIM' => $aim,
    'OCCUPATION' => $occupation,
	'INTERESTS' => $interests,
    'LOCATION' => $location,
	'WEBSITE' => $website,
    'SIGNATURE' => str_replace('<br />', "\n", $signature),
    'VIEW_EMAIL_YES' => ( $viewemail ) ? 'checked="checked"' : '',
	'VIEW_EMAIL_NO' => ( !$viewemail ) ? 'checked="checked"' : '',
    'HIDE_USER_YES' => ( !$allowviewonline ) ? 'checked="checked"' : '',
	'HIDE_USER_NO' => ( $allowviewonline ) ? 'checked="checked"' : '',
    'NOTIFY_PM_YES' => ( $notifypm ) ? 'checked="checked"' : '',
	'NOTIFY_PM_NO' => ( !$notifypm ) ? 'checked="checked"' : '',
    'POPUP_PM_YES' => ( $popup_pm ) ? 'checked="checked"' : '',
	'POPUP_PM_NO' => ( !$popup_pm ) ? 'checked="checked"' : '',
    'ALWAYS_ADD_SIGNATURE_YES' => ( $attachsig ) ? 'checked="checked"' : '',
	'ALWAYS_ADD_SIGNATURE_NO' => ( !$attachsig ) ? 'checked="checked"' : '',
    'NOTIFY_REPLY_YES' => ( $notifyreply ) ? 'checked="checked"' : '',
	'NOTIFY_REPLY_NO' => ( !$notifyreply ) ? 'checked="checked"' : '',
    'ALWAYS_ALLOW_BBCODE_YES' => ( $allowbbcode ) ? 'checked="checked"' : '',
	'ALWAYS_ALLOW_BBCODE_NO' => ( !$allowbbcode ) ? 'checked="checked"' : '',
    'ALWAYS_ALLOW_HTML_YES' => ( $allowhtml ) ? 'checked="checked"' : '',
	'ALWAYS_ALLOW_HTML_NO' => ( !$allowhtml ) ? 'checked="checked"' : '',
    'ALWAYS_ALLOW_SMILIES_YES' => ( $allowsmilies ) ? 'checked="checked"' : '',
	'ALWAYS_ALLOW_SMILIES_NO' => ( !$allowsmilies ) ? 'checked="checked"' : '',
    'LANGUAGE_SELECT' => language_select($user_lang, 'language'),
	'STYLE_SELECT' => style_select($user_style, 'style'),
    'TIMEZONE_SELECT' => tz_select($user_timezone, 'timezone'),
	'DATE_FORMAT' => $user_dateformat,
    'HTML_STATUS' => $html_status,
	'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . append_sid("{$phpbb_root_path}faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
    'SMILIES_STATUS' => $smilies_status,

    'L_USERNAME' => $lang['Username'],
    'L_NEW_PASSWORD' => $lang['Password'],
	'L_CONFIRM_PASSWORD' => $lang['Confirm_password'],
	'L_SUBMIT' => $lang['Submit'],
    'L_RESET' => $lang['Reset'],
	'L_ICQ_NUMBER' => $lang['ICQ'],
    'L_MESSENGER' => $lang['MSNM'],
	'L_YAHOO' => $lang['YIM'],
    'L_WEBSITE' => $lang['Website'],
	'L_AIM' => $lang['AIM'],
    'L_LOCATION' => $lang['Location'],
    'L_OCCUPATION' => $lang['Occupation'],
	'L_BOARD_LANGUAGE' => $lang['Board_lang'],
    'L_BOARD_STYLE' => $lang['Board_style'],
	'L_TIMEZONE' => $lang['Timezone'],
    'L_DATE_FORMAT' => $lang['Date_format'],
	'L_DATE_FORMAT_EXPLAIN' => $lang['Date_format_explain'],
	'L_YES' => $lang['Yes'],
    'L_NO' => $lang['No'],
    'L_INTERESTS' => $lang['Interests'],
	'L_ALWAYS_ALLOW_SMILIES' => $lang['Always_smile'],
    'L_ALWAYS_ALLOW_BBCODE' => $lang['Always_bbcode'],
	'L_ALWAYS_ALLOW_HTML' => $lang['Always_html'],
    'L_HIDE_USER' => $lang['Hide_user'],
	'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],

    'L_SIGNATURE' => $lang['Signature'],
	'L_SIGNATURE_EXPLAIN' => sprintf($lang['Signature_explain'], $board_config['max_sig_chars']),
    'L_NOTIFY_ON_REPLY' => $lang['Always_notify'],
	'L_NOTIFY_ON_REPLY_EXPLAIN' => $lang['Always_notify_explain'],
    'L_NOTIFY_ON_PRIVMSG' => $lang['Notify_on_privmsg'],
	'L_POPUP_ON_PRIVMSG' => $lang['Popup_on_privmsg'],
    'L_POPUP_ON_PRIVMSG_EXPLAIN' => $lang['Popup_on_privmsg_explain'],
	'L_PREFERENCES' => $lang['Preferences'],
    'L_PUBLIC_VIEW_EMAIL' => $lang['Public_view_email'],
	'L_ITEMS_REQUIRED' => $lang['Items_required'],
    'L_REGISTRATION_INFO' => $lang['Registration_info'],
	'L_PROFILE_INFO' => $lang['Profile_info'],
    'L_PROFILE_INFO_NOTICE' => $lang['Profile_info_warn'],
	'L_EMAIL_ADDRESS' => $lang['Email_address'],
	
	'L_REGISTRATION_OPTIONS' => $lang['Registration_options'],
	'L_REGISTRATION_OPTIONS_EXPLAIN' => $lang['Registration_options_explain'],
	'L_REG_SEND_EMAIL' => $lang['Registration_send_email'],

    'S_HIDDEN_FIELDS' => $s_hidden_fields,
	'S_PROFILE_ACTION' => append_sid("{$phpbb_root_path}admin/admin_acpuser.$phpEx"))
	);

//
// Now let's just close the document properly.
//
$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>