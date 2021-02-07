<?php
/***************************************************************************
 *                            regmod_viewtopic.php
 *                            -------------------
 *   begin                : Monday, Nov 14, 2005
 *   copyright            : (C) 2005 NetizenKane
 *   email                : info@fragthe.net
 *
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

if ( !empty($forum_topic_data['topic_reg']) && true === check_reg_active($topic_id))
{
	$sql = "SELECT u.username, u.user_id, r.registration_time, r.registration_confirm_time, r.registration_status
		FROM " . REGISTRATION_TABLE . " r, " . USERS_TABLE . " u
		WHERE r.topic_id = $topic_id
		AND r.registration_user_id = u.user_id
		ORDER BY registration_status, registration_time";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain user registration data for this topic", '', __LINE__, __FILE__, $sql);
	}

	$reg_info = $db->sql_fetchrowset($result);

	$db->sql_freeresult($result);
	$numregs = count($reg_info);
	$option1_count = 0;
	$option2_count = 0;
	$option3_count = 0;
	$option1_list = array();
	$option2_list = array();
	$option3_list = array();
	$s_hidden_fields = '';
	$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $topic_id . '" /><input type="hidden" name="mode" value="vote" />';
	$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

	$template->set_filenames(array(
		'regbox' => 'viewtopic_registration.tpl')
		);

	$sql = "SELECT topic_id, reg_option1, reg_option2, reg_option3, reg_max_option1, reg_max_option2, reg_max_option3, reg_start, reg_length
			FROM " . REGISTRATION_DESC_TABLE . "
			WHERE topic_id = $topic_id";

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain button data for this registration topic', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	$reg_topic_option1 = $row['reg_option1'];
	$reg_topic_option2 = $row['reg_option2'];
	$reg_topic_option3 = $row['reg_option3'];
	$reg_start = $row['reg_start'];
	$reg_length = $row['reg_length'];

	$reg_max_option1 = $row['topic_reg_max_option1'];
	$reg_max_option2 = $row['topic_reg_max_option2'];
	$reg_max_option3 = $row['topic_reg_max_option3'];

	$self_registered = 0;

	for( $u = 0; $u < $numregs; $u ++ )
	{
		if ( $reg_info[$u]['user_id'] == $userdata['user_id'] )
		{
			$self_registered = $reg_info[$u]['registration_status'];
		}
		if ( $reg_info[$u]['registration_status'] == REG_OPTION1 )
		{
			$option1_count ++;

			if ( $reg_info[$u]['registration_confirm_time'] == '' )
			{
				$regconfirmation_time = $reg_info[$u]['registration_confirm_time'];
			}
			else
			{
				$regconfirmation_time = create_date($board_config['default_dateformat'],
				$reg_info[$u]['registration_confirm_time'],$board_config['board_timezone']);
			}

			if ( !empty($reg_info[$u]['registration_time']) )
			{
				$regconfirmation1 = $lang['Reg_Own_Confirmation'];
			}

			$temp_reg_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=".$reg_info[$u]['user_id']);
			$reg_option1_data .= '<tr><td valign="top"><a href="' . $temp_reg_url . '" target="_self"><span class="genoption1">' . $reg_info[$u]['username'] . '</span></a></td><td class="gensmall">'.create_date($board_config['default_dateformat'], $reg_info[$u]['registration_time'],$board_config['board_timezone']).'</td><td class="gensmall">'.$regconfirmation_time.'</td></tr>';
		}
		else if( $reg_info[$u]['registration_status'] == REG_OPTION2 )
		{
			$option2_count ++;

			if ( $reg_info[$u]['registration_confirm_time'] == '' )
			{
				$regconfirmation_time = $reg_info[$u]['registration_confirm_time'];
			}
			else
			{
				$regconfirmation_time = create_date($board_config['default_dateformat'],
				$reg_info[$u]['registration_confirm_time'],$board_config['board_timezone']);
			}

			if ( !empty($reg_info[$u]['registration_time']) )
			{
				$regconfirmation2 = $lang['Reg_Own_Confirmation'];
			}

			$temp_reg_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=".$reg_info[$u]['user_id']);
			$reg_option2_data .= '<tr><td valign="top"><a href="' . $temp_reg_url . '" target="_self"><span class="genoption2">' . $reg_info[$u]['username'] . '</span></a></td><td class="gensmall">'.create_date($board_config['default_dateformat'], $reg_info[$u]['registration_time'],$board_config['board_timezone']).'</td><td class="gensmall">'.$regconfirmation_time.'</td></tr>';
		}
		else if( $reg_info[$u]['registration_status'] == REG_OPTION3 )
		{
			$option3_count ++;

			if ( $reg_info[$u]['registration_confirm_time'] == '' )
			{
				$regconfirmation_time = $reg_info[$u]['registration_confirm_time'];
			}
			else
			{
				$regconfirmation_time = create_date($board_config['default_dateformat'],
				$reg_info[$u]['registration_confirm_time'],$board_config['board_timezone']);
			}

			if ( !empty($reg_info[$u]['registration_time']) )
			{
				$regconfirmation3 = $lang['Reg_Own_Confirmation'];
			}

			$temp_reg_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=".$reg_info[$u]['user_id']);
			$reg_option3_data .= '<tr><td valign="top"><a href="' . $temp_reg_url . '" target="_self"><span class="genoption3">' . $reg_info[$u]['username'] . '</span></a></td><td class="gensmall">'.create_date($board_config['default_dateformat'], $reg_info[$u]['registration_time'],$board_config['board_timezone']).'</td><td class="gensmall">'.$regconfirmation_time.'</td></tr>';
		}
	}

if (!empty($row['reg_option1']) && (REG_OPTION1 != $self_registered))
{
	$reg_option1_option = $row['reg_option1'];
}
else if (!empty($row['reg_option1']) && (REG_OPTION1 == $self_registered))
{
	$reg_option1_option = $row['reg_option1'].' ('.$regconfirmation1.')';
}

if (!empty($row['reg_option2']) && (REG_OPTION2 != $self_registered))
{
	$reg_option2_option = $row['reg_option2'];
}
else if (!empty($row['reg_option2']) && (REG_OPTION2 == $self_registered))
{
	$reg_option2_option = $row['reg_option2'].' ('.$regconfirmation2.')';
}

if (!empty($row['reg_option3']) && (REG_OPTION3 != $self_registered))
{
	$reg_option3_option = $row['reg_option3'];
}
else if (!empty($row['reg_option3']) && (REG_OPTION3 == $self_registered))
{
	$reg_option3_option = $row['reg_option3'].' ('.$regconfirmation3.')';
}

if (!empty($reg_topic_option1) )
{
	$template->assign_block_vars("reg_option1", array(
	'REG_OPTION1_DATA' => $reg_option1_data )
	);
}

if (!empty($reg_topic_option2))
{
	$template->assign_block_vars("reg_option2", array(
	'REG_OPTION2_DATA' => $reg_option2_data )
	);
}

if (!empty($reg_topic_option3))
{
	$template->assign_block_vars("reg_option3", array(
	'REG_OPTION3_DATA' => $reg_option3_data )
	);
}

if (0 != $self_registered)
{
		$template->assign_block_vars("reg_unregister", array(
			'REG_SELF_NAME' => $lang['Reg_Self_Unregister'],
			'REG_SELF_URL' => append_sid("posting.$phpEx?mode=register&amp;register=" . REG_UNREGISTER . "&amp;" . POST_TOPIC_URL . "=$topic_id"))
		);
}


	$reg_expired = ($reg_length) ? ((($reg_start+$reg_length)<time()) ? 1 : 0 ) : 0;
	if ($forum_topic_data['topic_status'] == TOPIC_LOCKED) {
		$reg_expired = 0;
	}

	$readonly_option1 = ''; $readonly_option2 = ''; $readonly_option3 = '';
	if (1 === $reg_expired || (false === check_max_registration($topic_id,1) && false === check_user_registered($topic_id,$userdata['user_id'],1)))
	{
		$readonly_option1 = 'disabled="disabled"';
	}
	if (1 === $reg_expired || (false === check_max_registration($topic_id,2) && false === check_user_registered($topic_id,$userdata['user_id'],2)))
	{
		$readonly_option2 = 'disabled="disabled"';
	}
	if (1 === $reg_expired || (false === check_max_registration($topic_id,3) && false === check_user_registered($topic_id,$userdata['user_id'],3)))
	{
		$readonly_option3 = 'disabled="disabled"';
	}

	$slots_left_option1 = check_slots_left($topic_id, 1);
	$slots_left_option2 = check_slots_left($topic_id, 2);
	$slots_left_option3 = check_slots_left($topic_id, 3);

	switch ($slots_left_option1)
	{
		case 0:     $slots_left_option1_msg = $lang['Reg_No_Slots_Left']; break;
		case 1:     $slots_left_option1_msg = $lang['Reg_One_Slot_Left']; break;
		default:    $slots_left_option1_msg = $lang['Reg_Slots_Left']; break;
	}

	switch ($slots_left_option2)
	{
		case 0:     $slots_left_option2_msg = $lang['Reg_No_Slots_Left']; break;
		case 1:     $slots_left_option2_msg = $lang['Reg_One_Slot_Left']; break;
		default:    $slots_left_option2_msg = $lang['Reg_Slots_Left']; break;
	}

	switch ($slots_left_option3)
	{
		case 0:     $slots_left_option3_msg = $lang['Reg_No_Slots_Left']; break;
		case 1:     $slots_left_option3_msg = $lang['Reg_One_Slot_Left']; break;
		default:    $slots_left_option3_msg = $lang['Reg_Slots_Left']; break;
	}
	$slots_left_option1 = ($slots_left_option1 > -1) ? sprintf($slots_left_option1_msg, $slots_left_option1) : '';
	$slots_left_option2 = ($slots_left_option2 > -1) ? sprintf($slots_left_option2_msg, $slots_left_option2) : '';
	$slots_left_option3 = ($slots_left_option3 > -1) ? sprintf($slots_left_option3_msg, $slots_left_option3) : '';

	$template->assign_vars(array(
	'REG_TITLE' => $lang['Reg_Title'],
	'REG_HEAD_USERNAME' => $lang['Reg_Head_Username'],
	'REG_HEAD_TIME' => $lang['Reg_Head_Time'],
	'REG_HEAD_CONFIRM_TIME' => $lang['Reg_Head_Confirm'],
	'REG_OPTION1_NAME' => $reg_option1_option,
	'REG_OPTION1_COUNT' => $option1_count,
	'REG_OPTION1_URL' => append_sid("posting.$phpEx?mode=register&amp;register=" . REG_OPTION1 . "&amp;" . POST_TOPIC_URL . "=$topic_id"),
	'REG_OPTION2_NAME' => $reg_option2_option,
	'REG_OPTION2_COUNT' => $option2_count,
	'REG_OPTION2_URL' => append_sid("posting.$phpEx?mode=register&amp;register=" . REG_OPTION2 . "&amp;" . POST_TOPIC_URL . "=$topic_id"),
	'REG_OPTION3_NAME' => $reg_option3_option,
	'REG_OPTION3_COUNT' => $option3_count,
	'REG_OPTION3_URL' => append_sid("posting.$phpEx?mode=register&amp;register=" . REG_OPTION3 . "&amp;" . POST_TOPIC_URL . "=$topic_id"),

	'REG_OPTION1_READONLY' => $readonly_option1,
	'REG_OPTION2_READONLY' => $readonly_option2,
	'REG_OPTION3_READONLY' => $readonly_option3,
	'REG_OPTION1_SLOTS' => $slots_left_option1,
	'REG_OPTION2_SLOTS' => $slots_left_option2,
	'REG_OPTION3_SLOTS' => $slots_left_option3)
	);

	$template->assign_var_from_handle('REG_DISPLAY', 'regbox');
}

?>