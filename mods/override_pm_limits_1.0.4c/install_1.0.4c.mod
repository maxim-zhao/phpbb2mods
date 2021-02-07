##############################################################
## MOD Title: Override PM Limits 
## MOD Author: dvandersluis < daniel@codexed.com > (Daniel Vandersluis) http://www.codexed.com
## MOD Description: Allows Admins, via the ACP, to override the limit of private messages
##		allowed, per user.
## MOD Version: 1.0.4c
##
## Installation Level: Easy
## Installation Time: 15 Minutes
## Files To Edit: 7 
##		privmsg.php
##		admin/admin_users.php
##		language/lang_english/lang_admin.php
##		language/lang_english/lang_main.php
##		templates/subSilver/privmsgs_body.tpl
##		templates/subSilver/privmsgs_read_body.tpl
##		templates/subSilver/admin/user_edit_body.tpl
## Included Files: N/A
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
##		NOTE: Currently only supports DBMSes that support
##		subqueries!! For MySQL, that's 4.1+.
##		This mod allows the admin to specify overridden limits
##		for private messages in each of the inbox, savebox and
##		sentbox folders. 	
##		The 'progress bars' on each folder is updated to show
##		the correct limit, and a status message '[x of y]' is
##		added into the progress bar box.
##		As well, each folder now shows how many messages are
##		in it, on every page.
##############################################################
## MOD History:
##
##	 2007-01-10
##		Version 1.0.4c
##		- Fixed bug where a box with 0 messages would display
##		  as being 100% full rather than 0%.
##
##		Version 1.0.4b
##		- Removed constants from quoted strings.
##
##	 2006-06-05
##		Version 1.0.4
##		- Re-added quotes around NULL as appropriate (for
##		  the SQL string).
##		- Fixed an invalid multiline IN-LINE AFTER, ADD.
##		- Replaced instances of ($x == 0 || $x == '')
##		  with empty($x)
##		- Replaced 'magic numbers' with their constants
##		  (constants were already defined, but not used in
##		  one case).
##		- Temporarily marking MOD as MySQL 4.1+ only (as
##		  it uses subqueries).
##		  Will be updated in a future version!
##
##	 2006-05-08
##		Version 1.0.3
##		- Replaced references to "sendbox" (which doesn't
##		  exist) to the correct "sentbox" -- which means that
##		  overriding the sentbox limit will now always work.
##
##		Version 1.0.2
##		- Readded numeric status information that seems to
##		  have disappeared from the MOD.
##
##		Version 1.0.1
##		- Fixed XHTML compliance issue
##		- Fixed an issue that was breaking the table layout
##		  on user_edit_body.tpl
##		- Removed extraneous quotes around 'NULL'
##
##   2006-04-18
##		Version 1.0.0
##      - First version
##		- submitted to MODs database at phpBB.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_users` ADD `user_override_inbox_limit` INT DEFAULT NULL ;
ALTER TABLE `phpbb_users` ADD `user_override_savebox_limit` INT DEFAULT NULL ;
ALTER TABLE `phpbb_users` ADD `user_override_sentbox_limit` INT DEFAULT NULL ;

#
#-----[ OPEN ]-----------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]-----------------------------------------
#
$lang['User_allowavatar'] = 'Can display avatar';

#
#-----[ AFTER, ADD ]-----------------------------------
// +Override PM Limits
$lang['User_override_inbox_limit'] = 'Override limit of Private Messages in Inbox';
$lang['User_override_inbox_explain'] = 'Set an overridden limit for this user\'s PM Inbox';
$lang['User_override_savebox_limit'] = 'Override limit of Private Messages in Savebox';
$lang['User_override_savebox_explain'] = 'Set an overridden limit for this user\'s PM Savebox';
$lang['User_override_sentbox_limit'] = 'Override limit of Private Messages in Sentbox';
$lang['User_override_sentbox_explain'] = 'Set an overridden limit for this user\'s PM Sentbox';
// -Override PM Limits

#
#-----[ OPEN ]-----------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]-----------------------------------------
#
//
// That's all, Folks!

#
#-----[ BEFORE, ADD ]----------------------------------
#
// +Override PM Limits
$lang['PM_numeric_count'] = '[ %d of %d ]'; // Replaces with: 12 of 30 fo example
// -Override PM Limits

#
#-----[ OPEN ]-----------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]-----------------------------------------
#
        $user_allowpm = ( !empty($HTTP_POST_VARS['user_allowpm']) ) ? intval( $HTTP_POST_VARS['user_allowpm'] ) : 0;

#
#-----[ AFTER, ADD ]-----------------------------------
#
        // +Override PM Limits
        $user_override_inbox = empty($HTTP_POST_VARS['user_allow_override_inbox'])
                ? 'NULL' : intval($HTTP_POST_VARS['user_override_inbox']);

        $user_override_savebox = empty($HTTP_POST_VARS['user_allow_override_savebox'])
                ? 'NULL' : intval($HTTP_POST_VARS['user_override_savebox']);

        $user_override_sentbox = empty($HTTP_POST_VARS['user_allow_override_sentbox'])
                ? 'NULL' : intval($HTTP_POST_VARS['user_override_sentbox']);
        // -Override PM Limits

#
#-----[ FIND ]-----------------------------------------
#
# This is a partial line find
$sql = "UPDATE " . USERS_TABLE . "
	SET " . $username_sql

#
#-----[ IN-LINE FIND ]----------------------------------
#
$avatar_sql . "

#
# -----[ IN-LINE AFTER, ADD ]---------------------------
#
, user_override_inbox_limit = $user_override_inbox, user_override_sentbox_limit = $user_override_sentbox, user_override_savebox_limit = $user_override_savebox

#
#-----[ FIND ]-----------------------------------------
#
        $user_allowpm = $this_userdata['user_allow_pm'];

#
#-----[ AFTER, ADD ]-----------------------------------
#
		// +Override PM Limits
		$user_override_inbox_limit =
			(!empty($this_userdata['user_override_inbox_limit']) ? $this_userdata['user_override_inbox_limit'] : NULL);
		$user_override_savebox_limit =
			(!empty($this_userdata['user_override_savebox_limit']) ? $this_userdata['user_override_savebox_limit'] : NULL);
		$user_override_sentbox_limit =
			(!empty($this_userdata['user_override_sentbox_limit']) ? $this_userdata['user_override_sentbox_limit'] : NULL);
		// -Override PM Limits

#
#-----[ FIND ]-----------------------------------------
#
            'ALLOW_PM_NO' => (!$user_allowpm) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]-----------------------------------
#
            // +Override PM Limits
            'OVERRIDE_INBOX_YES' => ($user_override_inbox_limit != NULL) ? 'checked="checked"' : '',
            'OVERRIDE_INBOX_NO' => (!isset($user_override_inbox_limit)) ? 'checked="checked"' : '',
            'OVERRIDE_INBOX' => ($user_override_inbox_limit != NULL) ? $user_override_inbox_limit : '',
            'OVERRIDE_INBOX_STYLE' => (!isset($user_override_inbox_limit)) ? 'style="display: none;"' : '',

            'OVERRIDE_SAVEBOX_YES' => ($user_override_savebox_limit != NULL) ? 'checked="checked"' : '',
            'OVERRIDE_SAVEBOX_NO' => (!isset($user_override_savebox_limit)) ? 'checked="checked"' : '',
            'OVERRIDE_SAVEBOX' => ($user_override_savebox_limit != NULL) ? $user_override_savebox_limit : '',
            'OVERRIDE_SAVEBOX_STYLE' => (!isset($user_override_savebox_limit)) ? 'style="display: none;"' : '',

            'OVERRIDE_SENTBOX_YES' => ($user_override_sentbox_limit != NULL) ? 'checked="checked"' : '',
            'OVERRIDE_SENTBOX_NO' => (!isset($user_override_sentbox_limit)) ? 'checked="checked"' : '',
            'OVERRIDE_SENTBOX' => ($user_override_sentbox_limit != NULL) ? $user_override_sentbox_limit : '',
            'OVERRIDE_SENTBOX_STYLE' => (!isset($user_override_sentbox_limit)) ? 'style="display: none;"' : '',
            // -Override PM Limits

#
#-----[ FIND ]-----------------------------------------
#
            'L_ALLOW_PM' => $lang['User_allowpm'],

#
#-----[ AFTER, ADD ]-----------------------------------
#
            // +Override PM Limits
            'L_OVERRIDE_INBOX_LIMIT' => $lang['User_override_inbox_limit'],
            'L_OVERRIDE_INBOX_EXPLAIN' => $lang['User_override_inbox_explain'],
            'L_OVERRIDE_SAVEBOX_LIMIT' => $lang['User_override_savebox_limit'],
            'L_OVERRIDE_SAVEBOX_EXPLAIN' => $lang['User_override_savebox_explain'],
            'L_OVERRIDE_SENTBOX_LIMIT' => $lang['User_override_sentbox_limit'],
            'L_OVERRIDE_SENTBOX_EXPLAIN' => $lang['User_override_sentbox_explain'],
            // -Override PM Limits

#
#-----[ OPEN ]-----------------------------------------
#
privmsg.php

#
#-----[ FIND ]-----------------------------------------
#
// ----------
// Start main
//

#
#-----[ BEFORE, ADD ]-----------------------------------
#
// +Override PM Limits
$folder_count_sql = "SELECT * FROM
(
    SELECT COUNT(pm.privmsgs_id) as inbox_count
    FROM " . PRIVMSGS_TABLE . " AS pm
    WHERE pm.privmsgs_to_userid = {$userdata['user_id']}
        AND (
            pm.privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
            OR pm.privmsgs_type = " . PRIVMSGS_READ_MAIL . "
            OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . "
        )
) AS inbox,
(
    SELECT COUNT(pm.privmsgs_id) as outbox_count
    FROM " . PRIVMSGS_TABLE . " AS pm
    WHERE pm.privmsgs_from_userid = {$userdata['user_id']}
        AND ( pm.privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
            OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )
) AS outbox,
(
    SELECT COUNT(pm.privmsgs_id) as sentbox_count
    FROM " . PRIVMSGS_TABLE . " AS pm
    WHERE pm.privmsgs_from_userid = {$userdata['user_id']}
        AND ( pm.privmsgs_type = " . PRIVMSGS_SENT_MAIL . " )
) AS sentbox,
(
    SELECT COUNT(pm.privmsgs_id) as savebox_count
    FROM " . PRIVMSGS_TABLE . " AS pm
    WHERE (
        pm.privmsgs_from_userid = {$userdata['user_id']}
        AND pm.privmsgs_type = " . PRIVMSGS_SAVED_OUT_MAIL . "
    ) OR (
        pm.privmsgs_to_userid = {$userdata['user_id']}
        AND pm.privmsgs_type = " . PRIVMSGS_SAVED_IN_MAIL . "
    )
) AS savebox";

if ( !($result = $db->sql_query($folder_count_sql)) )
{
    message_die(GENERAL_ERROR, 'Could not query private message information', '', __LINE__, __FILE__, $folder_count_sql);
}

$folder_counts = $db->sql_fetchrow($result);

$template->assign_vars(array(
    'INBOX_TOTAL' => $folder_counts['inbox_count'],
    'SAVEBOX_TOTAL' => $folder_counts['savebox_count'],
    'SENTBOX_TOTAL' => $folder_counts['sentbox_count'],
    'OUTBOX_TOTAL' => $folder_counts['outbox_count'])
);
// -Override PM Limits

#
#-----[ FIND ]------------------------------------------
#
# This is a partial line find
$sql = "SELECT u.username AS username_1, u.user_id AS user_id_1, u2.username AS username_2

#
#-----[ IN-LINE FIND ]-----------------------------------
#
u.user_avatar,

#
#-----[ IN-LINE AFTER, ADD ]-----------------------------
#
COALESCE(u.user_override_sentbox_limit, {$board_config['max_sentbox_privmsgs']}) AS user_sentbox_limit,

#
#-----[ FIND ]------------------------------------------
#
    //
    // Is this a new message in the inbox? If it is then save
    // a copy in the posters sent box
    //

#
#-----[ BEFORE, ADD ]-----------------------------------
#
	// +Override PM Limits
    $user_sentbox_limit = $privmsg['user_sentbox_limit'];
    // -Override PM Limits

#
#-----[ FIND ]------------------------------------------
#
			if ($board_config['max_sentbox_privmsgs'] && $sent_info['sent_items'] >= $board_config['max_sentbox_privmsgs'])

#
#-----[ REPLACE WITH ]----------------------------------
#
            // +Override PM Limits
            // -deleted
            // if ($board_config['max_sentbox_privmsgs'] && $sent_info['sent_items'] >= $board_config['max_sentbox_privmsgs'])
            // -added
            if ($user_sentbox_limit && $sent_info['sent_items'] >= $user_sentbox_limit)
            // -Override PM Limits

#
#-----[ FIND ]------------------------------------------
#
		$sql = "SELECT COUNT(privmsgs_id) AS savebox_items, MIN(privmsgs_date) AS oldest_post_time
            FROM " . PRIVMSGS_TABLE . "
            WHERE ( ( privmsgs_to_userid = " . $userdata['user_id'] . "
                    AND privmsgs_type = " . PRIVMSGS_SAVED_IN_MAIL . " )
                OR ( privmsgs_from_userid = " . $userdata['user_id'] . "
                    AND privmsgs_type = " . PRIVMSGS_SAVED_OUT_MAIL . ") )";

#
#-----[ REPLACE WITH ]----------------------------------
#
        // +Override PM Limits
        // -delete
        /*
        $sql = "SELECT COUNT(privmsgs_id) AS savebox_items, MIN(privmsgs_date) AS oldest_post_time
            FROM " . PRIVMSGS_TABLE . "
            WHERE ( ( privmsgs_to_userid = " . $userdata['user_id'] . "
                    AND privmsgs_type = " . PRIVMSGS_SAVED_IN_MAIL . " )
                OR ( privmsgs_from_userid = " . $userdata['user_id'] . "
                    AND privmsgs_type = " . PRIVMSGS_SAVED_OUT_MAIL . ") )";
        */
        // -add
        $sql = "SELECT *
            FROM
            (
                SELECT COUNT(pm.privmsgs_id) AS savebox_items,
                    MIN(pm.privmsgs_date) AS oldest_post_time
                FROM " . PRIVMSGS_TABLE . " AS pm
                WHERE ( ( privmsgs_to_userid = {$userdata['user_id']} AND privmsgs_type = " . PRIVMSGS_SAVED_IN_MAIL . ")
                    OR ( privmsgs_from_userid = {$userdata['user_id']} AND privmsgs_type = " . PRIVMSGS_SAVED_OUT_MAIL . ") )
            ) AS post_info,
            (
                SELECT COALESCE(u.user_override_savebox_limit, {$board_config['max_savebox_privmsgs']}) AS savebox_limit
                FROM " . USERS_TABLE . " AS u
                WHERE user_id = {$userdata['user_id']}
            ) AS limit_info";
        // -Override PM Limits

#
#-----[ FIND ]------------------------------------------
#
			if ($board_config['max_savebox_privmsgs'] && $saved_info['savebox_items'] >= $board_config['max_savebox_privmsgs'] )

#
#-----[ REPLACE WITH ]----------------------------------
#
			// +Override PM Limits
            // -deleted
            // if ($board_config['max_savebox_privmsgs'] && $saved_info['savebox_items'] >= $board_config['max_savebox_privmsgs'] )
            // -added
            $user_savebox_limit = $saved_info['savebox_limit'];

            if ($user_savebox_limit && $saved_info['savebox_items'] >= $user_savebox_limit)
            // -Override PM Limits

#
#-----[ FIND ]------------------------------------------
#
            $sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time
                FROM " . PRIVMSGS_TABLE . "
                WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
                        OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "
                        OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )
                    AND privmsgs_to_userid = " . $to_userdata['user_id'];

#
#-----[ REPLACE WITH ]----------------------------------
#
            // +Override PM Limits
            // -delete
            /*
            $sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time
                FROM " . PRIVMSGS_TABLE . "
                WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
                        OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "
                        OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )
                    AND privmsgs_to_userid = " . $to_userdata['user_id'];
            */
            // -add
            $sql = "SELECT *
                FROM
                (
                    SELECT COUNT(pm.privmsgs_id) AS inbox_items,
                        MIN(pm.privmsgs_date) AS oldest_post_time
                    FROM " . PRIVMSGS_TABLE . " AS pm
                    WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
                        OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "
                        OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )
                    AND privmsgs_to_userid = " . $to_userdata['user_id'] . "
                ) AS post_info,
                (
                    SELECT COALESCE(u.user_override_inbox_limit, {$board_config['max_inbox_privmsgs']}) AS inbox_limit
                    FROM " . USERS_TABLE . " AS u
                    WHERE user_id = {$to_userdata['user_id']}
                ) AS limit_info";
            // -Override PM Limits

#
#-----[ FIND ]------------------------------------------
#
           		if ($board_config['max_inbox_privmsgs'] && $inbox_info['inbox_items'] >= $board_config['max_inbox_privmsgs']) 

#
#-----[ REPLACE WITH ]----------------------------------
#
                // +Override PM Limits
                // -delete
                // if ($board_config['max_inbox_privmsgs'] && $inbox_info['inbox_items'] >= $board_config['max_inbox_privmsgs'])
                // -add
                $user_inbox_limit = $inbox_info['inbox_limit'];

                if ($user_inbox_limit && $inbox_info['inbox_items'] >= $user_inbox_limit)
                // -Override PM Limits

#
#-----[ FIND ]------------------------------------------
#
    $inbox_limit_pct = ( $board_config['max_' . $folder . '_privmsgs'] > 0 ) ? round(( $pm_all_total / $board_config['max_' . $folder . '_privmsgs'] ) * 100) : 100;
    $inbox_limit_img_length = ( $board_config['max_' . $folder . '_privmsgs'] > 0 ) ? round(( $pm_all_total / $board_config['max_' . $folder . '_privmsgs'] ) * $board_config['privmsg_graphic_length']) : $board_config['privmsg_graphic_length'];
    $inbox_limit_remain = ( $board_config['max_' . $folder . '_privmsgs'] > 0 ) ? $board_config['max_' . $folder . '_privmsgs'] - $pm_all_total : 0;

#
#-----[ REPLACE WITH ]----------------------------------
#
    // +Override PM Limits
    // -delete
    /*
    $inbox_limit_pct = ( $board_config['max_' . $folder . '_privmsgs'] > 0 ) ? round(( $pm_all_total / $board_config['max_' . $folder . '_privmsgs'] ) * 100) : 100;
    $inbox_limit_img_length = ( $board_config['max_' . $folder . '_privmsgs'] > 0 ) ? round(( $pm_all_total / $board_config['max_' . $folder . '_privmsgs'] ) * $board_config['privmsg_graphic_length']) : $board_config['privmsg_graphic_length'];
    $inbox_limit_remain = ( $board_config['max_' . $folder . '_privmsgs'] > 0 ) ? $board_config['max_' . $folder . '_privmsgs'] - $pm_all_total : 0;
    */
    // -add
    $get_limit_sql = "SELECT COALESCE(u.user_override_{$folder}_limit, {$board_config['max_' . $folder . '_privmsgs']})
            AS pm_limit
        FROM " . USERS_TABLE . " AS u
        WHERE u.user_id = '{$userdata['user_id']}'";

    if ( !($result = $db->sql_query($get_limit_sql)) )
    {
        message_die(GENERAL_ERROR, 'Could not query private message information', '', __LINE__, __FILE__, $get_limit_sql);
    }

    if ( !($row = $db->sql_fetchrow($result)) )
    {
        message_die(GENERAL_ERROR, 'Could not get result set from database', '', __LINE__, __FILE__, $get_limit_sql);
    }

    $pm_limit = $row['pm_limit'];

    $inbox_limit_pct = ( $pm_total >= 0 )
        ? round(( $pm_all_total / $pm_limit ) * 100) : 100;
    $inbox_limit_img_length = ( $pm_limit > 0 )
        ? round(( $pm_all_total / $pm_limit ) * $board_config['privmsg_graphic_length'])
        : $board_config['privmsg_graphic_length'];
    $inbox_limit_remain = ( $pm_limit > 0 ) ? $pm_limit - $pm_all_total : 0;
    // -Override PM Limits

#
#-----[ FIND ]-----------------------------------------
#
	'BOX_SIZE_STATUS' => $l_box_size_status, 

#
#-----[ AFTER, ADD ]-----------------------------------
#
	// +Override PM Limits
	'BOX_SIZE_NUMERIC' => sprintf($lang['PM_numeric_count'], $pm_all_total, $pm_limit),
	// -Override PM Limits

#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
<h1>{L_USER_TITLE}</h1>

#
#-----[ BEFORE, ADD ]----------------------------------
#
<script type="text/javascript">
	function toggle(id, state)
	{
		var element = document.getElementById(id);
		if (element)
		{
			if (state === true) element.style.cssText = '';
			else if (state === false) element.style.cssText = 'display: none;';
			else if (element.style.display) element.style.cssText = '';
			else element.style.cssText = 'display: none;';
		}
	}
</script>

#
#-----[ FIND ]-----------------------------------------
#
    <tr>
      <td class="row1"><span class="gen">{L_ALLOW_PM}</span></td>
      <td class="row2">
        <input type="radio" name="user_allowpm" value="1" {ALLOW_PM_YES} />
        <span class="gen">{L_YES}</span>&nbsp;&nbsp;
        <input type="radio" name="user_allowpm" value="0" {ALLOW_PM_NO} />
        <span class="gen">{L_NO}</span></td>
    </tr>

#
#-----[ AFTER, ADD ]-----------------------------------
#
    <!-- +Override PM Limits -->
    <tr>
		<td class="row1">
			<span class="gen">{L_OVERRIDE_INBOX_LIMIT}</span>
		</td>
		<td class="row2">
			<input type="radio" onclick="toggle('override_inbox', true);"
				name="user_allow_override_inbox" value="1" {OVERRIDE_INBOX_YES} />
			<span class="gen">{L_YES}</span>&nbsp;&nbsp;
			<input type="radio" onclick="toggle('override_inbox', false);"
				name="user_allow_override_inbox" value="0" {OVERRIDE_INBOX_NO} />
			<span class="gen">{L_NO}</span>
		</td>
    </tr>
    <tr id="override_inbox" {OVERRIDE_INBOX_STYLE}>
		<td class="row1">
			<span class="gen">{L_OVERRIDE_INBOX_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="text" name="user_override_inbox" size="3" value="{OVERRIDE_INBOX}" />
		</td>
    </tr>
    <tr>
      <td class="row1">
		<span class="gen">{L_OVERRIDE_SAVEBOX_LIMIT}</span>
	</td>
		<td class="row2">
			<input type="radio" onclick="toggle('override_savebox', true);"
				name="user_allow_override_savebox" value="1" {OVERRIDE_SAVEBOX_YES} />
			<span class="gen">{L_YES}</span>&nbsp;&nbsp;
			<input type="radio" onclick="toggle('override_savebox', false);"
				name="user_allow_override_savebox" value="0" {OVERRIDE_SAVEBOX_NO} />
			<span class="gen">{L_NO}</span>
		</td>
    </tr>
    <tr id="override_savebox" {OVERRIDE_SAVEBOX_STYLE}>
		<td class="row1">
			<span class="gen">{L_OVERRIDE_SAVEBOX_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="text" name="user_override_savebox" size="3" value="{OVERRIDE_SAVEBOX}" />
		</td>
    </tr>
    <tr>
		<td class="row1">
			<span class="gen">{L_OVERRIDE_SENTBOX_LIMIT}</span>
		</td>
		<td class="row2">
			<input type="radio" onclick="toggle('override_sentbox', true);"
				name="user_allow_override_sentbox" value="1" {OVERRIDE_SENTBOX_YES} />
			<span class="gen">{L_YES}</span>&nbsp;&nbsp;
			<input type="radio" onclick="toggle('override_sentbox', false);"
				name="user_allow_override_sentbox" value="0" {OVERRIDE_SENTBOX_NO} />
			<span class="gen">{L_NO}</span>
		</td>
    </tr>
    <tr id="override_sentbox" {OVERRIDE_SENTBOX_STYLE}>
		<td class="row1">
			<span class="gen">{L_OVERRIDE_SENTBOX_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="text" name="user_override_sentbox" size="3" value="{OVERRIDE_SENTBOX}" />
		</td>
    </tr>
    <!-- -Override PM Limits -->

#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/privmsgs_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
		  <td>{INBOX_IMG}</td>
          <td><span class="cattitle">{INBOX} &nbsp;</span></td>
          <td>{SENTBOX_IMG}</td>
          <td><span class="cattitle">{SENTBOX} &nbsp;</span></td>
          <td>{OUTBOX_IMG}</td>
          <td><span class="cattitle">{OUTBOX} &nbsp;</span></td>
          <td>{SAVEBOX_IMG}</td>
          <td><span class="cattitle">{SAVEBOX} &nbsp;</span></td>

#
#-----[ REPLACE WITH ]---------------------------------
#
          <!-- +Override PM Limits -->
          <!--
          -deleted
          <td>{INBOX_IMG}</td>
          <td><span class="cattitle">{INBOX} &nbsp;</span></td>
          <td>{SENTBOX_IMG}</td>
          <td><span class="cattitle">{SENTBOX} &nbsp;</span></td>
          <td>{OUTBOX_IMG}</td>
          <td><span class="cattitle">{OUTBOX} &nbsp;</span></td>
          <td>{SAVEBOX_IMG}</td>
          <td><span class="cattitle">{SAVEBOX} &nbsp;</span></td>
          -added
          -->
          <td>{INBOX_IMG}</td>
          <td>
            <span class="cattitle">{INBOX}&nbsp;[{INBOX_TOTAL}]&nbsp;</span>
          </td>
          <td>{SENTBOX_IMG}</td>
          <td>
            <span class="cattitle">{SENTBOX}&nbsp;[{SENTBOX_TOTAL}]&nbsp;</span>
          </td>
          <td>{OUTBOX_IMG}</td>
          <td>
            <span class="cattitle">{OUTBOX}&nbsp;[{OUTBOX_TOTAL}]&nbsp;</span>
          </td>
          <td>{SAVEBOX_IMG}</td>
          <td>
            <span class="cattitle">{SAVEBOX}&nbsp;[{SAVEBOX_TOTAL}]&nbsp;</span>
          </td>
          <!-- -Override PM Limits -->

#
#-----[ FIND ]-----------------------------------------
#
          <td colspan="3" width="175" class="row1" nowrap="nowrap"><span class="gensmall">{BOX_SIZE_STATUS}</span></td>
#
#-----[ REPLACE WITH ]---------------------------------
#
          <!-- +Override PM Limits -->
          <!--
          -deleted
          <td colspan="3" width="175" class="row1" nowrap="nowrap"><span class="gensmall">{BOX_SIZE_STATUS}</span></td>
          -added
          -->
          <td colspan="3" width="175" class="row1" nowrap="nowrap">
            <span class="gensmall">
                {BOX_SIZE_STATUS}<br />
                {BOX_SIZE_NUMERIC}
            </span>
          </td>
          <!-- -Override PM Limits -->

#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/privmsgs_read_body.tpl
	
#
#-----[ FIND ]-----------------------------------------
#
	<td valign="middle">{INBOX_IMG}</td>
    <td valign="middle"><span class="cattitle">{INBOX} &nbsp;</span></td>
    <td valign="middle">{SENTBOX_IMG}</td>
    <td valign="middle"><span class="cattitle">{SENTBOX} &nbsp;</span></td>
    <td valign="middle">{OUTBOX_IMG}</td>
    <td valign="middle"><span class="cattitle">{OUTBOX} &nbsp;</span></td>
    <td valign="middle">{SAVEBOX_IMG}</td>
    <td valign="middle"><span class="cattitle">{SAVEBOX}</span></td>

#
#-----[ REPLACE WITH ]---------------------------------
#
    <!-- +Override PM Limits -->
    <!--
    -deleted
    <td valign="middle">{INBOX_IMG}</td>
    <td valign="middle"><span class="cattitle">{INBOX} &nbsp;</span></td>
    <td valign="middle">{SENTBOX_IMG}</td>
    <td valign="middle"><span class="cattitle">{SENTBOX} &nbsp;</span></td>
    <td valign="middle">{OUTBOX_IMG}</td>
    <td valign="middle"><span class="cattitle">{OUTBOX} &nbsp;</span></td>
    <td valign="middle">{SAVEBOX_IMG}</td>
    <td valign="middle"><span class="cattitle">{SAVEBOX}</span></td>
    -added
    -->
    <td valign="middle">{INBOX_IMG}</td>
    <td valign="middle">
        <span class="cattitle">{INBOX}&nbsp;[{INBOX_TOTAL}]&nbsp;</span>
    </td>
    <td valign="middle">{SENTBOX_IMG}</td>
    <td valign="middle">
        <span class="cattitle">{SENTBOX}&nbsp;[{SENTBOX_TOTAL}]&nbsp;</span>
    </td>
    <td valign="middle">{OUTBOX_IMG}</td>
    <td valign="middle">
        <span class="cattitle">{OUTBOX}&nbsp;[{OUTBOX_TOTAL}]&nbsp;</span>
    </td>
    <td valign="middle">{SAVEBOX_IMG}</td>
    <td valign="middle">
        <span class="cattitle">{SAVEBOX}&nbsp;[{SAVEBOX_TOTAL}]&nbsp;</span>
    </td>
    <!-- -Override PM Limits -->

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
