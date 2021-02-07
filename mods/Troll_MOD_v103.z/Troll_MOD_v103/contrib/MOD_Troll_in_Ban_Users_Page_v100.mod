################################################################################
## MOD Title: MOD Troll in Ban Users Page
## MOD Author: Paddic < Addic@hamppu.net > (N/A) N/A
## MOD Description: An addon to the Troll MOD that adds the functionality
##                  of the Troll MOD to the Ban Control page
## MOD Version: 1.0.0
##
## Installation Level: (Easy)
## Installation Time: 1 Minute
## Files To Edit:
##      admin/admin_user_ban.php,
##      language/lang_english/lang_admin.php,
##      templates/subSilver/admin/user_ban_body.tpl
## Included Files:
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
## This adds the Troll MOD functionality to the Ban Control page where User's
## names can be looked up and added to the list.  It also adds the
## capability to "untroll" multiple Users at the same time.
##
##############################################################
## MOD History:
##
##   2006-04-09 - Version 1.0.0
##      - Added to the Troll MOD package.
##      - Initial submission
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#

admin/admin_user_ban.php

#
#-----[ FIND ]------------------------------------------
#

        if ( !empty($HTTP_POST_VARS['username']) )

#
#-----[ REPLACE WITH ]------------------------------------------
#

        if ( !empty($HTTP_POST_VARS['usernamez']) )



#
#-----[ FIND ]------------------------------------------
#

                $this_userdata = get_userdata($HTTP_POST_VARS['username'], true);

#
#-----[ REPLACE WITH ]------------------------------------------
#

                $this_userdata = get_userdata($HTTP_POST_VARS['usernamez'], true);

#
#-----[ FIND ]------------------------------------------
#

        $where_sql = '';


#
#-----[ AFTER, ADD ]------------------------------------------
#

        //START Mod Troll
        if ( !empty($HTTP_POST_VARS['trollname']) )
        {
                $this_userdata = get_userdata($HTTP_POST_VARS['trollname'], true);
                if( !$this_userdata )
                {
                        message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
                }
                $sql = "UPDATE " . USERS_TABLE . " SET user_troll = 1 WHERE user_id = ".$this_userdata['user_id'];
                if ( !$db->sql_query($sql) )
                {
                        message_die(GENERAL_ERROR, "Couldn't delete ban info from database", "", __LINE__, __FILE__, $sql);
                }
        }
        if ( isset($HTTP_POST_VARS['untroll_user']) )
        {
                $user_list = $HTTP_POST_VARS['untroll_user'];

                for($i = 0; $i < count($user_list); $i++)
                {
                        if ( $user_list[$i] != -1 )
                        {
                                $where_sql .= ( ( $where_sql != '' ) ? ', ' : '' ) . intval($user_list[$i]);
                        }
                }
                if($where_sql != '')
                {
                        $sql = "UPDATE " . USERS_TABLE . " SET user_troll = 0 WHERE user_id IN ($where_sql)";
                        $where_sql = '';
                        if ( !$db->sql_query($sql) )
                        {
                                message_die(GENERAL_ERROR, "Couldn't delete troll info from database", "", __LINE__, __FILE__, $sql);
                        }
                }
        }
        //END Mod Troll


#
#-----[ FIND ]------------------------------------------
#

                'L_EMAIL_ADDRESS' => $lang['Email_address'],


#
#-----[ AFTER, ADD ]------------------------------------------
#

                //START Mod Troll
                'L_TROLL' => $lang['User_troll'], // troll+banlist
                'L_TROLL_EXPLAIN' => $lang['User_troll_explain'],
                'L_UNTROLL' => $lang['User_untroll'], // troll+banlist
                'L_UNTROLL_EXPLAIN' => $lang['User_untroll_explain'],
                //END Mod Troll

#
#-----[ FIND ]------------------------------------------
#

        $userban_count = 0;
        $ipban_count = 0;
        $emailban_count = 0;


#
#-----[ AFTER, ADD ]------------------------------------------
#

        //START Mod Troll
        $sql = "SELECT username, user_id FROM " . USERS_TABLE . " WHERE user_troll > 0 ORDER BY user_id ASC";
        if ( !($result = $db->sql_query($sql)) )
        {
                message_die(GENERAL_ERROR, 'Could not select current troll list', '', __LINE__, __FILE__, $sql);
        }

        $user_list = $db->sql_fetchrowset($result);
        $db->sql_freeresult($result);

        $select_trolllist = '';
        for($i = 0; $i < count($user_list); $i++)
        {
                $select_trolllist .= '<option value="' . $user_list[$i]['user_id'] . '">' . $user_list[$i]['username'] . '</option>';
        }

        if( $select_trolllist == '' )
        {
                $select_trolllist = '<option value="-1">' . $lang['No_trolls'] . '</option>';
        }

        $select_trolllist = '<select name="untroll_user[]" multiple="multiple" size="5">' . $select_trolllist . '</select>';
        //END Mod Troll

#
#-----[ FIND ]------------------------------------------
#

                'S_UNBAN_USERLIST_SELECT' => $select_userlist,

#
#-----[ AFTER, ADD ]------------------------------------------
#

                //START Mod Troll
                'S_UNTROLL_USERLIST_SELECT' =>$select_trolllist,
                //END Mod Troll

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#

$lang['Troll_users'] = 'Names of Trolls';

#
#-----[ AFTER, ADD ]------------------------------------------
#

$lang['User_troll_explain'] = 'Troll user will have very miserable time using the board.';
$lang['User_untroll'] = 'Remove troll status from user';
$lang['User_untroll_explain'] = 'You can "untroll" multiple users in one go using the appropriate combination of mouse and keyboard for your computer and browser';
$lang['No_trolls'] = 'No troll users';

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/user_ban_body.tpl

#
#-----[ FIND ]------------------------------------------
#

          <td class="row2"><input class="post" type="text" class="post" name="username" maxlength="50" size="20" /> <input type="hidden" name="mode" value="edit" />{S_HIDDEN_FIELDS} <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></td>

#
#-----[ REPLACE WITH ]------------------------------------------
#

          <td class="row2"><input type="text" class="post" name="usernamez" id="uz" maxlength="50" size="20" /> <input type="hidden" name="mode" value="edit" />{S_HIDDEN_FIELDS} <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="document.forms['post'].trollname.id = 'ut';document.forms['post'].usernamez.id = 'username';var w=window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');w.focus();return false;" /></td>

#
#-----[ FIND ]------------------------------------------
#

          <td class="row2">{S_UNBAN_EMAILLIST_SELECT}</td>
        </tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#

        <tr>
          <th class="thHead" colspan="2">{L_TROLL}</th>
        </tr>
        <tr>
          <td class="row1">{L_USERNAME}: <br /><span class="gensmall">{L_TROLL_EXPLAIN}</span></td>
          <td class="row2"><input type="text" class="post" name="trollname" id="ut" maxlength="50" size="20" /> <input type="hidden" name="mode" value="edit" />{S_HIDDEN_FIELDS} <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="document.forms['post'].usernamez.id = 'uz';document.forms['post'].trollname.id = 'username';var w=window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');w.focus();return false;" /></td>
        </tr>
        <tr>
          <th class="thHead" colspan="2">{L_UNTROLL}</th>
        </tr>
        <tr>
          <td class="row1">{L_USERNAME}: <br /><span class="gensmall">{L_UNTROLL_EXPLAIN}</span></td>
          <td class="row2">{S_UNTROLL_USERLIST_SELECT}</td>
        </tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
