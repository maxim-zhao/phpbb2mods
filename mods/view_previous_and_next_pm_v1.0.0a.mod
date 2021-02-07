##############################################################
## MOD Title: View Previous and Next PM
## MOD Author: alexi02 < N/A > (Alejandro Iannuzzi) http://www.uzzisoft.com
## MOD Description: Shows "View Previous PM" and "View Next PM" in Private Messaging
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: privmsg.php
##                language/lang_english/lang_main.php
##                templates/subSilver/privmsgs_read_body.tpl
## Included Files: N/A
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##      "View Previous PM" and "View Next PM" exactly like it's done in when viewing a topic.
##      If the previous or next privmsg_id doesn't exist it just links to the current PM.
##
##############################################################
## MOD History:
##
##  2006-09-14 - Version 1.0.0
##      - Initial Release (for phpBB 2.0.21)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

privmsg.php

#
#-----[ FIND ]------------------------------------------
#

$privmsg_id = $privmsg['privmsgs_id'];

#
#-----[ AFTER, ADD ]------------------------------------------
#


        //
        // Start View Previous and Next PM Mod
        //

        $sql_id_search = "SELECT pm.privmsgs_type, pm.privmsgs_id, pm.privmsgs_date, pm.privmsgs_subject, u.user_id, u.username
                FROM " . PRIVMSGS_TABLE . " pm, " . USERS_TABLE . " u ";

        switch( $folder )
        {
                case 'inbox':
                        $sql_id_search .= "WHERE pm.privmsgs_to_userid = " . $userdata['user_id'] . "
                                AND u.user_id = pm.privmsgs_from_userid
                                AND ( pm.privmsgs_type =  " . PRIVMSGS_NEW_MAIL . "
                                        OR pm.privmsgs_type = " . PRIVMSGS_READ_MAIL . "
                                        OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )";
                        break;

                case 'outbox':
                        $sql_id_search .= "WHERE pm.privmsgs_from_userid = " . $userdata['user_id'] . "
                                AND u.user_id = pm.privmsgs_to_userid
                                AND ( pm.privmsgs_type =  " . PRIVMSGS_NEW_MAIL . "
                                        OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )";
                        break;

                case 'sentbox':
                        $sql_id_search .= "WHERE pm.privmsgs_from_userid = " . $userdata['user_id'] . "
                                AND u.user_id = pm.privmsgs_to_userid
                                AND pm.privmsgs_type =  " . PRIVMSGS_SENT_MAIL;
                        break;

                case 'savebox':
                        $sql_id_search .= "WHERE u.user_id = pm.privmsgs_from_userid
                                AND ( ( pm.privmsgs_to_userid = " . $userdata['user_id'] . "
                                        AND pm.privmsgs_type = " . PRIVMSGS_SAVED_IN_MAIL . " )
                                OR ( pm.privmsgs_from_userid = " . $userdata['user_id'] . "
                                        AND pm.privmsgs_type = " . PRIVMSGS_SAVED_OUT_MAIL . " ) )";
                        break;

                default:
                        message_die(GENERAL_MESSAGE, $lang['No_such_folder']);
                        break;
        }

        if ( !($result = $db->sql_query($sql_id_search)) )
        {
                message_die(GENERAL_ERROR, 'Could not query private messages', '', __LINE__, __FILE__, $sql);
        }

        $rows = $db->sql_fetchrowset($result);
        $db->sql_freeresult($result);
        $rows_count = count($rows);

        for ($x = 0; $x < $rows_count; $x++) {
           $privmsg_id_search = $rows[$x]['privmsgs_id'];

           // If the private msg id was found then we know the previous and next id
           if ($privmsg_id_search == $privmsg_id) {
              $privmsgs_id_previous = $rows[($x-1)]['privmsgs_id'];
              $privmsgs_id_next = $rows[($x+1)]['privmsgs_id'];

              // If there is a previous id
              if ($privmsgs_id_previous) {
                 $privmsgs_id_previous_link = append_sid("privmsg.$phpEx?folder=$folder&mode=$mode&" . POST_POST_URL . "=$privmsgs_id_previous");
              }
              else {
                 $privmsgs_id_previous_link = append_sid("privmsg.$phpEx?folder=$folder&mode=$mode&" . POST_POST_URL . "=$privmsg_id_search");
              }

              // If there is a next id
              if ($privmsgs_id_next) {
                 $privmsgs_id_next_link = append_sid("privmsg.$phpEx?folder=$folder&mode=$mode&" . POST_POST_URL . "=$privmsgs_id_next");
              }
              else {
                 $privmsgs_id_next_link = append_sid("privmsg.$phpEx?folder=$folder&mode=$mode&" . POST_POST_URL . "=$privmsg_id_search");
              }
           }
        }

        //
        // End View Previous and Next PM Mod
        //

#
#-----[ FIND ]------------------------------------------
#

'INBOX' => $inbox_url,

#
#-----[ AFTER, ADD ]------------------------------------------
#


                'L_VIEW_PREVIOUS_PM' => $lang['PM_previous'],
                'L_VIEW_NEXT_PM' => $lang['PM_next'],
                'U_VIEW_OLDER_PM' => $privmsgs_id_previous_link,
                'U_VIEW_NEWER_PM' => $privmsgs_id_next_link,

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#

//
// Start View Previous and Next PM Mod
//

$lang['PM_previous'] = 'View previous PM';
$lang['PM_next'] = 'View next PM';

//
// End View Previous and Next PM Mod
//

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/privmsgs_read_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">

#
#-----[ AFTER, ADD ]------------------------------------------
#

        <tr align="right">
                <td class="catHead" colspan="3" height="28"><span class="nav"><a href="{U_VIEW_OLDER_PM}" class="nav">{L_VIEW_PREVIOUS_PM}</a> :: <a href="{U_VIEW_NEWER_PM}" class="nav">{L_VIEW_NEXT_PM}</a> &nbsp;</span></td>
        </tr>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM