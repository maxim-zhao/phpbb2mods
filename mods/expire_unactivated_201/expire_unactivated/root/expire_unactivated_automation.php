<?php
/***************************************************************************
 *                              expire_unactivated_automation.php
 *                            -------------------
 *   begin                : Thursday, Sept 24, 2006
 *   copyright            : (C) 2006 Harknell www.onezumi.com
 *   email                : harknell@onezumi.com
 *   file version		  : 2.0.1
 *
 ***************************************************************************/
//*** Automated component for Expire Unactivated Accounts by Timeframe Mod //

if ( !defined('IN_PHPBB') )
{
   die("Hacking attempt");
}

//
// Function auto_expire_unactivated_accounts(), this function will read the configuration data from
// the expire_unactivated_automation table and call the delete function with the necessary info.
//
function auto_expire_unactivated_accounts()
{
	global $db, $lang;

	$sql = "SELECT *
		FROM " . EXPIRE_UNACTIVATED_AUTOMATION_TABLE . "";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not read expire_unactivated_automation table', '', __LINE__, __FILE__, $sql);
	}

	 		$row = $db->sql_fetchrow($result);
			$timewindow = 0;
			$expiretimeframe = $row['automation_timeframe'];
			$expiretimeframe = intval($expiretimeframe);


			//
			//Determine how far back to expire accounts.
			//

			if ($expiretimeframe > 0){
			$rightnow = time();
			$timewindow = ($rightnow - $expiretimeframe);
			}


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
			$lastupdatetime = date("F j, Y, g:i a");
			$sql = "UPDATE " . EXPIRE_UNACTIVATED_AUTOMATION_TABLE . " SET last_autoexpire_time = '$lastupdatetime'";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update the time for the latest expire unactivated account automation run.', '', __LINE__, __FILE__, $sql);
				}

	}

	return;


?>