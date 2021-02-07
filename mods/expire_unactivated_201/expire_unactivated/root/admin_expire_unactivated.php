<?php
/***************************************************************************
 *                              admin_expire_unactivated.php
 *                            -------------------
 *   begin                : Thursday, Sept 24, 2006
 *   copyright            : (C) 2006 Harknell www.onezumi.com
 *   email                : harknell@onezumi.com
 *   file version		  : 2.0.1
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Users']['Expire'] = $file;
	return;
}

//
// Get the defaults for Admin area
//

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
//Get user input.
//

$timewindow = 0;
$expiretimeframe = $HTTP_POST_VARS['timeframe'];
$expiretimeframe = intval($expiretimeframe);


//
//Determine how far back to expire accounts.
//

if ($expiretimeframe > 0){
$rightnow = time();
$timewindow = ($rightnow - $expiretimeframe);
}

//
// If form is manually submitted, delete unactivated users using timeframe designated. If an incorrect input is set for $expiretimeframe (such as a non number) nothing will be deleted
// since user_regdate can't possibly be less than "" or 0. If an admin wants to purposely set a different number amount than the default timeframes then that's their decision :)
//
		if( isset($HTTP_POST_VARS['manualsubmit']) )
		{
//
// Find all users who have unactivated accounts within the timeframe submitted
//

			$sql = "SELECT user_id FROM " . USERS_TABLE . "
				WHERE (user_active = 0) and (user_id <>" . ANONYMOUS . ") and (user_lastvisit = 0) and (user_regdate < \"$timewindow\")";
			if ( !($result = $db->sql_query($sql)) )
			{
			message_die(GENERAL_ERROR, "Failed to Expire Accounts, could not get user data of unactivated accounts", "", __LINE__, __FILE__, $sql);
			}
//
// Loop to delete each users account from all necessary tables
//

			while ($row = $db->sql_fetchrow($result)) {
				$user_id = $row['user_id'];

				$sql = "SELECT g.group_id
				FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g
				WHERE ug.user_id = $user_id
				AND g.group_id = ug.group_id
				AND g.group_single_user = 1";
					if( !($thisuseridresult = $db->sql_query($sql)) )
					{
					message_die(GENERAL_ERROR, 'Could not obtain group information for this user', '', __LINE__, __FILE__, $sql);
					}

				$thisuseridrow = $db->sql_fetchrow($thisuseridresult);
				$sql = "DELETE FROM " . USERS_TABLE . "
								WHERE user_id = $user_id";
							if( !$db->sql_query($sql) )
							{
								message_die(GENERAL_ERROR, 'Could not delete user', '', __LINE__, __FILE__, $sql);
							}

							$sql = "DELETE FROM " . USER_GROUP_TABLE . "
								WHERE user_id = $user_id";
							if( !$db->sql_query($sql) )
							{
								message_die(GENERAL_ERROR, 'Could not delete user from user_group table', '', __LINE__, __FILE__, $sql);
							}

							$sql = "DELETE FROM " . GROUPS_TABLE . "
								WHERE group_id = " . $thisuseridrow['group_id'];
							if( !$db->sql_query($sql) )
							{
								message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
							}
				$db->sql_freeresult($thisuseridresult);

			}

		}
//
// If form submitted is to turn on Automation feature for module, update general config area and module specific tables in DB.
//

		if( isset($HTTP_POST_VARS['activate']) )
		{
			if( isset($HTTP_POST_VARS['timeframe']) && ($HTTP_POST_VARS['timeframe'] > 0))
			{
				$sql = "UPDATE " . CONFIG_TABLE . " SET  config_value = '1' WHERE config_name = 'expire_automation_enable'";
					if ( !($result = $db->sql_query($sql)) )
								{
								message_die(GENERAL_ERROR, "Could not write automation enable setting in the general config table", "", __LINE__, __FILE__, $sql);
					}
				$sql = "UPDATE " . EXPIRE_UNACTIVATED_AUTOMATION_TABLE . " SET automation_timeframe = '$expiretimeframe'";
					if ( !($result = $db->sql_query($sql)) )
													{
								message_die(GENERAL_ERROR, "Could not update automation timeframe in expire automation table", "", __LINE__, __FILE__, $sql);
					}
			}
		}

		if( isset($HTTP_POST_VARS['deactivate']) )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET  config_value = '0' WHERE config_name = 'expire_automation_enable'";
					if ( !($result = $db->sql_query($sql)) )
					{
							message_die(GENERAL_ERROR, "Could not write automation disable setting in the general config table", "", __LINE__, __FILE__, $sql);
					}

		}



//
// After processing give user a result statement, or let them know they didn't select a timeframe and give them option to return to form
//

	if( isset($HTTP_POST_VARS['manualsubmit']) )
	{
		if ($expiretimeframe)
		{
			$message = $lang['accounts_expired'] . "<br /><br />"  . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		}
		else
		{
			$message = $lang['noexpired_accounts'] . "<br /><br />"  . sprintf($lang['return_expired_accounts'], "<a href=\"" . append_sid("admin_expire_unactivated.$phpEx?pane=right") . "\">", "</a>");
		}
		message_die(GENERAL_MESSAGE, $message);
	}

	if( isset($HTTP_POST_VARS['activate']) )
		{
			if ($expiretimeframe)
			{
				$message = $lang['expire_account_automation_nowon'] . "<br /><br />"  . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			}
			else
			{
				$message = $lang['expire_account_automation_notimeframe'] . "<br /><br />"  . sprintf($lang['return_expired_accounts'], "<a href=\"" . append_sid("admin_expire_unactivated.$phpEx?pane=right") . "\">", "</a>");
			}
			message_die(GENERAL_MESSAGE, $message);
		}
	if( isset($HTTP_POST_VARS['deactivate']) )
		{
			$message = $lang['expire_account_automation_nowoff'] . "<br /><br />"  . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}

	if(	$board_config['expire_automation_enable'])
		{
			$sql = "SELECT automation_timeframe, last_autoexpire_time FROM " . EXPIRE_UNACTIVATED_AUTOMATION_TABLE . "";
			if ( !($result = $db->sql_query($sql)) )
						{
						message_die(GENERAL_ERROR, "Failed to read current Automation Timeframe from DB", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$current_automation_state = $lang['expire_account_automation_on'];
			$current_automation_state .= $lang['expire_account_automation_timeframe'];
			$secondstotimeframe= $row['automation_timeframe'];
			if ($secondstotimeframe == 3600){
				$current_automation_state .= $lang['expire_one_hour'];
			}
			elseif ($secondstotimeframe == 86400){
				$current_automation_state .= $lang['expire_one_day'];
			}
			elseif ($secondstotimeframe == 604800){
				$current_automation_state .= $lang['expire_one_week'];
			}
			elseif ($secondstotimeframe == 2419200){
				$current_automation_state .= $lang['expire_one_month'];
			}
			elseif ($secondstotimeframe == 7257600){
				$current_automation_state .= $lang['expire_three_months'];
			}
			elseif ($secondstotimeframe == 14515200 ){
				$current_automation_state .= $lang['expire_six_months'];
			}
			elseif ($secondstotimeframe == 29030400 ){
				$current_automation_state .= $lang['expire_one_year'];
			}
			else {
				$current_automation_state .= $secondstotimeframe;
			}
		$current_automation_state .= $lang['expire_account_automation_lastrun'] . $row['last_autoexpire_time'];
		}
	else
		{

			$current_automation_state = $lang['expire_account_automation_off'];
		}
//
// Set up template page and define variables for language files
//

$template->set_filenames(array(
	"body" => "admin/board_expire_accounts.tpl"));



$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_expire_unactivated.$phpEx"),
	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_EXPIRE_ACCOUNT_TITLE" => $lang['expire_account_title'],
	"L_EXPIRE_EXPLAIN" => $lang['expire_explain'],
	"L_EXPIRE_AUTOMATION_EXPLAIN" => $lang['expire_account_automation_explain'],
	"L_EXPIRE_CHOOSE" => $lang['expire_choose'],
	"L_SELECT_TIMEFRAME_VALUE" => $lang['expire_select_value'],
	"L_EXPIRE_HOUR" => $lang['expire_one_hour'],
	"L_EXPIRE_DAY" => $lang['expire_one_day'],
	"L_EXPIRE_WEEK" => $lang['expire_one_week'],
	"L_EXPIRE_MONTH" => $lang['expire_one_month'],
	"L_EXPIRE_3MONTHS" => $lang['expire_three_months'],
	"L_EXPIRE_6MONTHS" => $lang['expire_six_months'],
	"L_EXPIRE_YEAR" => $lang['expire_one_year'],
	"L_ACCOUNT_EXPIRE" => $lang['accounts_expired'],
	"L_NOACCOUNT_EXPIRED" => $lang['noexpired_accounts'],
	"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset'],
	"L_AUTOMATION_ACTIVATE" => $lang['expire_account_automation_turnon'],
	"L_AUTOMATION_DEACTIVATE" => $lang['expire_account_automation_turnoff'],
	"L_AUTOMATION_CURRENTLY_ACTIVE" => $lang['expire_account_automation_on'],
	"L_AUTOMATION_CURRENTLY_INACTIVE" => $lang['expire_account_automation_off'],
	"L_AUTOMATION_CURRENT_TIMEFRAME" => $lang['expire_account_automation_timeframe'],
	"L_AUTOMATION_TURNED_ON" => $lang['expire_account_automation_nowon'],
	"L_AUTOMATION_TURNED_ON_NOTIMEFRAME" => $lang['expire_account_automation_notimeframe'],
	"L_CURRENT_AUTOMATION_STATE" => $current_automation_state,
	"L_AUTOMATION_LAST_RUN" => $lang['expire_account_automation_lastrun'],
	"L_AUTOMATION_TURNED_OFF" => $lang['expire_account_automation_nowoff'])
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>