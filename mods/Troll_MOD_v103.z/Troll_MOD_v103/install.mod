################################################################################
## MOD Title: MOD Troll
## MOD Author: Merlin Sythove < Merlin@silvercircle.org > (N/A) N/A 
## MOD Author: Kalipo < N/A > (N/A) N/A
## MOD Description: This MOD will prevent users designated as Trolls from posting,
##                  Private Messaging, Emailing, and generally make their life on
##                  the board miserable.
## MOD Version: 1.0.3
##
## Installation Level: (Easy)
## Installation Time: 10 Minutes
## Files To Edit:
##      login.php,
##      privmsg.php,
##      admin/admin_users.php,
##      admin/index.php,
##      includes/functions_post.php,
##      includes/page_header.php,
##      includes/sessions.php,
##      includes/usercp_email.php,
##      language/lang_english/lang_admin.php,
##      language/lang_english/lang_main.php,
##      templates/subSilver/admin/index_body.tpl,
##      templates/subSilver/admin/user_edit_body.tpl
## Included Files:
##      includes/miserable_user.php
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
################################################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
################################################################################
## Author Notes:
##
## RESTRICTIONS
## This MOD is not PHP 4.1.0 compatible.  You MUST have at least version PHP 4.2.0
##
## MOD DESCRIPTION
## This is a combination of Miserable User Mod and extra features plus a
## cookie system, basically to make life miserable for trolls.
##
## What happens (adaptation of the Miserable User Mod):
##   In all cases everything is really slowed down. I've chosen between 5 and 30
##   seconds but that is already infuriating. You can easily change that time.
##
##   50% of the time the forum software "messes up", by sending them mysteriously
##    to the index page, giving a blank screen, "hanging" the computer or
##    giving strange error messages.
##
##   The other 50% of the time they can do what they want (still delayed of course)
##
## The Troll Mod adds extra trouble within the 50% of pages that do work:
##   Login: This only succeeds half the time, the other half of the time error
##   messages are shown (i.e. only 1 in 4 logins succeed)
##   Posting, PM and Email: This gives error messages half the time, the other
##   times it only appears to succeed but in fact nothing is posted or sent.
##   (i.e. only 25% of the attempts seem to work)
##
## Cookie system
##   A troll who logs in will get a cookie.
##   If there is a cookie, that person is a troll, whether that person is logged
##   in or not.
##   If the cookie no longer matches the database (i.e. the admin has re-set the
##   troll flag) the cookie is removed.
##
##   * A troll who is just browsing as guest, is still treated as a troll
##   * A troll who comes to your house and uses your computer to log in, will set
##     the cookie, so the next time it will look like he messed up your computer
##   * A troll who has made a new account will still be seen as troll based on
##     the cookie of the old account
##   * The ADMIN can un-set the troll flag to remove cookies when the ex-troll
##     (or misfortunate friend) visits the board. They do not need to log in
##     for the cookie to be removed, a visit is enough.
##
## The only way to get round the system, is to remove cookies, and make a new account
##   and behave (to prevent the ADMIN from setting the new account to troll).
##
## Usage
##   Users can be marked as Trolls via the User Management in the ACP.  Further,
##   Trolls are identified on the ACP Index (names and total number) below the Users
##   Online table.
##
## Credits
##   * Dr. Doom & TERMINATRIX - original Miserable User script. 
##   * Paddic - Ban Control page Add-on.
##   * Civphp - borrowed code for the ACP display.
##   * JKeats - borrowed code for the ACP controls.
##
##############################################################
## MOD History:
##
##   2006-05-06 - Version 1.0.3
##      - Fixed a possible security issue
##      - Resubmitted
##   2006-04-19 - Version 1.0.2
##      - Removed browser crash code from miserable_user.php (since it generated
##        virus warnings)
##      - Removed the browser crash reference in the install file
##      - Resubmitted
##   2006-04-17 - Version 1.0.1
##      - Fixed an in-line error in the install file
##      - Replaced function
##      - Resubmitted
##   2006-04-09 - Version 1.0.0
##      - Addition of ACP controls/visibility
##      - Added Ban Control page Add-on in /contrib/
##      - Cleaned up Install file
##      - Initial submission
##   2005-11-06 - Version 0.9.2
##      - Further changes, addition of Miserable User Mod, cookies
##   2005-11-05 - Version 0.9.0
##      - BETA release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]------------------------------------------
#
# -- Add a user field in the database

ALTER TABLE `phpbb_users` ADD `user_troll` TINYINT;

#
#-----[ COPY ]----------------------------------------------------------
#

copy includes/miserable_user.php to includes/miserable_user.php

#
#-----[ OPEN ]------------------------------------------
#

login.php

#
#-----[ FIND ]------------------------------------------
#

      $sql = "SELECT user_id, username, user_password, user_active, user_level, user_login_tries, user_last_login_try
   
#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_last_login_try

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

, user_troll


#
#-----[ FIND ]------------------------------------------
#

                                if( md5($password) == $row['user_password'] && $row['user_active'] )
                                {

#
#-----[ AFTER, ADD ]------------------------------------------
#

                                        //START MOD troll
                                        if ($row['user_troll'])
                                        {
                                                switch (rand (1,2)) //case 3 is done by miserable_user.php
                                                {
                                                case 1: //Give obfuscating message
                                                        message_die(GENERAL_MESSAGE, $lang['Troll_error_login_' . rand (1,3) ]);
                                                        break;
                                                case 2: //Allow login
                                                        break;
                                                case 3: //Abort further processing, computer "hangs"
                                                        exit;
                                                        break;
                                                }
                                        }
                                        //END MOD troll

#
#-----[ OPEN ]------------------------------------------
#

privmsg.php

#
#-----[ FIND ]------------------------------------------
#

                        {
                                message_die(GENERAL_MESSAGE, $lang['Flood_Error']);
                        }
                }

#
#-----[ AFTER, ADD ]------------------------------------------
#

                //START MOD troll
                if ($userdata['user_troll'])
                {
                        switch (rand (1,2)) //case 3 is done by miserable_user.php
                        {
                        case 1: //Give obfuscating message
                                message_die(GENERAL_MESSAGE, $lang['Troll_error_privmsg_' . rand (1,3) ]);
                                break;
                        case 2: //Pretend it worked
                                $template->assign_vars(array(
                                '        META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("privmsg.$phpEx?folder=inbox") . '">')
                                );
                        $msg = $lang['Message_sent'] . '<br /><br />' . sprintf($lang['Click_return_inbox'], '<a href="' . append_sid("privmsg.$phpEx?folder=inbox") . '">', '</a> ') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
                                message_die(GENERAL_MESSAGE, $msg);
                                break;
                        case 3: //Abort further processing, computer "hangs"
                                exit;
                                break;
                        }
                }
                //END MOD troll   

#
#-----[ OPEN ]------------------------------------------
#

admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#

                $user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;

#
#-----[ AFTER, ADD ]------------------------------------------
#

                //START MOD troll
                $user_troll = ( !empty($HTTP_POST_VARS['user_troll']) ) ? intval( $HTTP_POST_VARS['user_troll'] ) : 0;
                //END MOD troll

#
#-----[ FIND ]------------------------------------------
#

                        $sql = "UPDATE " . USERS_TABLE . "
                                SET " . $username_sql . $passwd_sql . "user_email =

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_allowavatar = $user_allowavatar

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

, user_troll = $user_troll

#
#-----[ FIND ]------------------------------------------
#

                $user_allowavatar = $this_userdata['user_allowavatar'];

#
#-----[ AFTER, ADD ]------------------------------------------
#

                //START MOD troll
                $user_troll = $this_userdata['user_troll'];
                //END MOD troll

#
#-----[ FIND ]------------------------------------------
#

                        $s_hidden_fields .= '<input type="hidden" name="user_allowavatar" value="' . $user_allowavatar . '" />';
#
#-----[ AFTER, ADD ]------------------------------------------
#

                        //START MOD troll
                        $s_hidden_fields .= '<input type="hidden" name="user_troll" value="' . $user_troll . '" />';
                        //END MOD troll

#
#-----[ FIND ]------------------------------------------
#

                        'ALLOW_AVATAR_YES' => ($user_allowavatar) ? 'checked="checked"' : '',
                        'ALLOW_AVATAR_NO' => (!$user_allowavatar) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]------------------------------------------
#

                        //START MOD troll
                        'TROLL_YES' => ($user_troll) ? 'checked="checked"' : '',
                        'TROLL_NO' => (!$user_troll) ? 'checked="checked"' : '',
                        //END MOD troll

#
#-----[ FIND ]------------------------------------------
#

                        'L_ALLOW_AVATAR' => $lang['User_allowavatar'],

#
#-----[ AFTER, ADD ]------------------------------------------
#

                        //START MOD troll
                        'L_TROLL' => $lang['User_troll'],
                        //END MOD troll

#
#-----[ OPEN ]------------------------------------------
#

admin/index.php

#
#-----[ FIND ]------------------------------------------
#

                "L_GZIP_COMPRESSION" => $lang['Gzip_compression'])

#
#-----[ BEFORE, ADD ]------------------------------------------
#

                //START MOD troll
                "L_TROLL_INFO" => $lang['Troll_info'],
                "L_NUMBER_TROLLS" => $lang['Numberof_Trolls'],
                "L_NAME_TROLLS" => $lang['Troll_users'],
                //END MOD troll

#
#-----[ FIND ]------------------------------------------
#

        $total_topics = get_db_stat('topiccount');

#
#-----[ AFTER, ADD ]------------------------------------------
#

        //START MOD troll
        $total_trolls = 0;
        $troll_names = '';
        $sql = "SELECT username
                FROM " . USERS_TABLE . "
                WHERE user_troll = 1
                        AND user_id <> " . ANONYMOUS . "
                ORDER BY username";
        if ( !($result = $db->sql_query($sql)) )
        {
                message_die(GENERAL_ERROR, "Couldn't get statistic data.", "", __LINE__, __FILE__, $sql);
        }
                while ( $row = $db->sql_fetchrow($result) )
        {
                $troll_names .= (($troll_names == '') ? '' : ', ') . $row['username'];
                $total_trolls++;
        }
        //END MOD troll

#
#-----[ FIND ]------------------------------------------
#

                "GZIP_COMPRESSION" => ( $board_config['gzip_compress'] ) ? $lang['ON'] : $lang['OFF'])

#
#-----[ BEFORE, ADD ]------------------------------------------
#

                //START MOD troll
                "NUMBER_OF_TROLLS" => $total_trolls,
                "NAMES_OF_TROLLS" => htmlspecialchars($troll_names),
                //END MOD troll



#
#-----[ OPEN ]------------------------------------------
#

includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#

        if ($mode == 'newtopic' || $mode == 'reply' || $mode == 'editpost') 
        {
   

#
#-----[ AFTER, ADD ]------------------------------------------
#

        //START MOD troll
        if ($userdata['user_troll'])
        {
                switch (rand (1,2)) //case 3 is done by miserable_user.php
                {
                case 1: //Give obfuscating message
                        message_die(GENERAL_MESSAGE, $lang['Troll_error_posting_' . rand (1,3) ]);
                        break;
                case 2: //Pretend it worked
                        $meta = '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">';
                //MOD Moderate_user
                        $message = $lang['Stored'];
                        if ($post_moderated) $message .= '<br />' .  $lang['moderate_user_notify'];
                                $message .= '<br /><br />' . sprintf($lang['Click_view_message'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_POST_URL . "=" . $post_id) . '#' . $post_id . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');
                                message_die(GENERAL_MESSAGE, $message);
                        break;
                case 3: //Abort further processing, computer "hangs"
                        exit;
                        break;

                }
        }
        //END MOD troll   


#
#-----[ OPEN ]------------------------------------------
#

includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#

$template->pparse('overall_header');

#
#-----[ BEFORE, ADD ]------------------------------------------
#

if( $userdata['user_troll'] )
{
        include_once($phpbb_root_path . 'includes/miserable_user.' . $phpEx);
}

#
#-----[ OPEN ]------------------------------------------
#

includes/sessions.php

#
#-----[ FIND ]------------------------------------------
#

        // Initial ban check against user id, IP and email address
        //
        preg_match('/(..)(..)(..)(..)/', $user_ip, $user_ip_parts);

#
#-----[ AFTER, ADD ]------------------------------------
#
 
        //START MOD Troll
        //Get troll cookie settings.
        $troll_cookie = '';
        $troll_id = isset($HTTP_COOKIE_VARS[$board_config['cookie_name'].'_tr_id']) ? intval($HTTP_COOKIE_VARS[$board_config['cookie_name'].'_tr_id']) : '';

        //Yes, troll cookie present. See if it matches the database. If not, delete cookie.
        if ($troll_id)
        {
        //  Note: If another person uses the troll's computer, they are seen as troll too.
        //  If a troll makes a new account, they are still listed as troll via this cookie
        //  If the troll doesn't log in, they are still seen as troll.
        //  Once a troll has visited your house and used your computer and logged in,
        //  you too are seen as a troll. USER SOLUTION: Remove the cookies from your computer.
        //  If a troll removes cookies, everything will be fine until they log in again,
        //  bingo, he will have a new cookie and be troll again.
        //
        //  EX-TROLLS: The ex-troll does NOT have to log in to remove the troll cookie, visiting is enough.
        //  So you could un-set the troll flag and wait until the troll or another user has
        //  visited to remove possible troll cookies on their computer, and then set the troll flag again.

        $sql = "SELECT user_id
        FROM " . USERS_TABLE . "
                WHERE user_id = $troll_id";
                if ( !($result = $db->sql_query($sql)) )
                {
                        message_die(CRITICAL_ERROR, 'Could not obtain user information', '', __LINE__, __FILE__, $sql);
                }
                if ( $troll_info = $db->sql_fetchrow($result) )
                {
                        $troll_cookie =  ( $troll_info['user_id']);
                }
                //There was a cookie but no match in the database:
                //delete the cookie by setting the expiry time 1 hour ago
                if (! $troll_cookie)
                {
                        setcookie($board_config['cookie_name'].'_tr_id',$troll_id, time()-3600);
                }
        }
        //Have $troll_cookie, if not empty, the user is a troll.
        //If empty, then there was no cookie, or there was no LONGER a database match so the cookie was deleted

        //Check if user (if logged in) is troll. Fill in the troll_id if there is no id known yet.
        $troll_database = '';
        if ( $user_id != ANONYMOUS )
        {
                $troll_database = ( $userdata['user_troll'] );
                if (! $troll_id ) $troll_id = $user_id;
        }

        //User is a troll in some way?
        if ($troll_cookie || $troll_database)
        {
        //Set the troll cookie, time it for 1 year. The time restarts every time the user comes here
                setcookie($board_config['cookie_name'].'_tr_id',$troll_id, time()+365*24*3600);
        //Set the user variable too (so a troll-as-guest is treated as a troll)
                $userdata['user_troll'] = true;
        }
        //END MOD Troll

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_email.php

#
#-----[ FIND ]------------------------------------------
#

                                $sql = "UPDATE " . USERS_TABLE . " 
                                        SET user_emailtime = " . time() . " 
                                        WHERE user_id = " . $userdata['user_id'];

#
#-----[ BEFORE, ADD ]------------------------------------------
#

                                //START MOD troll
                                if ($userdata['user_troll'])
                                {
                                        switch (rand (1,2)) //case 3 is done by miserable_user.php
                                        {
                                        case 1: //Give obfuscating message
                                                message_die(GENERAL_MESSAGE, $lang['Troll_error_email_' . rand (1,3) ]);
                                                break;
                                        case 2: //Pretend it worked
                                                $template->assign_vars(array(
                                                        'META' => '<meta http-equiv="refresh" content="5;url=' . append_sid("index.$phpEx") . '">')
                                                );
                                                        $message = $lang['Email_sent'] . '<br /><br />' . sprintf($lang['Click_return_index'],  '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
                                                        message_die(GENERAL_MESSAGE, $message);
                                                break;
                                        case 3: //Abort further processing, computer "hangs"
                                                exit;
                                                break;
                                        }
                                }
                                //END MOD troll   

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#

//
// That's all Folks!

#
#-----[ BEFORE, ADD ]------------------------------------------
#

// Troll MOD
$lang['User_troll'] = 'Make user a Troll';

$lang['Troll_info'] = 'Troll Information';
$lang['Numberof_Trolls'] = 'Number of Trolls';
$lang['Troll_users'] = 'Names of Trolls';


#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

//
// That's all, Folks!

#
#-----[ BEFORE, ADD ]------------------------------------------
#

//MOD Troll
$lang['Troll_error_login_1'] = 'You have used a wrong or inactive username or a wrong password.';
$lang['Troll_error_login_2'] = 'Sorry, there are too many members logged in. Please try again later.';
$lang['Troll_error_login_3'] = 'Your password was wrong. Check that the CAPS LOCK key is off. ';

$lang['Troll_error_posting_1'] = 'You cannot post a message so soon after your last message. Please try again laters.';
$lang['Troll_error_posting_2'] = 'Only a limited amount of posts can be made in a certain time. Please try again later.';
$lang['Troll_error_posting_3'] = 'Sorry, your message has been refused by the language filter. Please rewrite your message.';

$lang['Troll_error_privmsg_1'] = 'Sorry, the recipient is unknown. Please make sure you choose an existing forum member.';
$lang['Troll_error_privmsg_2'] = 'Sorry, the recipient\'s mailbox is full, please try again later.';
$lang['Troll_error_privmsg_3'] = 'Sorry, your message has been refused by the language filter. Please rewrite your message.';

$lang['Troll_error_email_1'] = 'Sorry, the recipient is unknown. Please make sure you choose an existing forum member.';
$lang['Troll_error_email_2'] = 'Sorry, the recipient\'s mailbox is full, please try again later.';
$lang['Troll_error_email_3'] = 'Sorry, your message has been refused by the language filter. Please rewrite your message.';

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#

  </tr>
  <!-- END guest_user_row -->
</table>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<h1>{L_TROLL_INFO}</h1>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <tr>
        <th width="20%" class="thCornerL" height="25">{L_NUMBER_TROLLS}</th>
        <th width="80%" class="thCornerR">{L_NAME_TROLLS}</th>
  </tr>
  <tr>
        <td class="row1" align="center">{NUMBER_OF_TROLLS}</td>
        <td class="row2">{NAMES_OF_TROLLS}</td>
  </tr>
</table>

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#

                <input type="radio" name="user_allowavatar" value="0" {ALLOW_AVATAR_NO} />
                <span class="gen">{L_NO}</span></td>
        </tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#

        <tr>
          <td class="row1"><span class="gen">{L_TROLL}</span></td>
          <td class="row2">
                <input type="radio" name="user_troll" value="1" {TROLL_YES} />
                <span class="gen">{L_YES}</span>&nbsp;&nbsp;
                <input type="radio" name="user_troll" value="0" {TROLL_NO} />
                <span class="gen">{L_NO}</span></td>
        </tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
