<?

function getCannedMenu()
{
	global $db,$userdata;

	$sql = "SELECT  g.group_id,g.group_name
		FROM  " . USER_GROUP_TABLE . " ug," . GROUPS_TABLE . " g
		WHERE ug.user_id = " . $userdata['user_id'] . " AND g.group_id = ug.group_id AND g.group_single_user = 0";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not select canned_custom_count', '', __LINE__, __FILE__, $sql);
	}

	$groups = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$groups[] = $row;
	}
	$db->sql_freeresult($result);

	$canned_menu = array();
	$i = 0;
	foreach($groups as $group)
	{
		if($i > 0)
		{
			$c = array();
			$c['name'] = "";
			$c['id'] = 0;
			$canned_menu[] = $c;
		}

		$c = array();
		$c['name'] = $group['group_name'];
		$c['id'] = 0;
		$canned_menu[] = $c;

		$c = array();
		$c['name'] = "----------------------------";
		$c['id'] = 0;
		$canned_menu[] = $c;
		
		$sql = "SELECT canned_id,canned_title
			FROM " . CANNED_TABLE . "
			WHERE group_id = " . $group['group_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select canned messages', '', __LINE__, __FILE__, $sql);
		}

		while ($row = $db->sql_fetchrow($result))
		{
			if(trim($row['canned_title']) != "")
			{
				$c = array();
				$c['id'] = $row['canned_id'];
				$c['name'] = $row['canned_title'];
				$canned_menu[] = $c;
			}
		}
		$db->sql_freeresult($result);

		$sql = "SELECT custom_canned_id,custom_canned_title
			FROM " . CUSTOM_CANNED_TABLE . "
			WHERE group_id = " . $group['group_id'] . " AND user_id = " . $userdata['user_id'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not select canned messages', '', __LINE__, __FILE__, $sql);
		}

		while ($row = $db->sql_fetchrow($result))
		{
			if(trim($row['custom_canned_title']) != "")
			{
				$c = array();
				$c['id'] = -$row['custom_canned_id'];
				$c['name'] = $row['custom_canned_title'];
				$canned_menu[] = $c;
			}
		}
		$db->sql_freeresult($result);

		$i++;
	}
	return($canned_menu);
}

?>