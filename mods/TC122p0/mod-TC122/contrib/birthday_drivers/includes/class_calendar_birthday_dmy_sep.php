<?php
/***************************************************************************
 *                            class_calendar_birthday_dmy_sep.php
 *                            -----------------------------------
 *	begin			: 24/04/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 0.0.2 - 01/06/2006
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
}

class calendar_event_birthday_reader extends calendar_event_birthday_root
{
	// birthday format is dd-mm-yyyy
	function read($xfrom, $xto)
	{
		global $db, $user;
		global $calendar_api;

		$tz = doubleval($user->data['user_timezone']) + intval($user->data['user_dst']);

		$tac = $xto['y'] < 0 ? -1 : +1;
		$fac = $xfrom['y'] < 0 ? -1 : +1;
		$tm = $tac * ($xto['m'] - 1);
		$fm = $fac * ($xfrom['m'] - 1);
		$td = $tac * ($xto['d'] - 1);
		$fd = $fac * ($xfrom['d'] - 1);
		$delta = ($xto['y'] - $xfrom['y']) * 372 + ($tm - $fm) * 31 + ($td - $fd) - 1;
		if ( $delta < 0 )
		{
			return;
		}
		$select = $delta < 372; // 31 * 12

		// check if we need the twelves monthes
		if ( $select )
		{
			$xmin2 = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'] - 2, $xfrom['y']);
			$xmin1 = $calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'] - 1, $xfrom['y']);
			$xmaj1 = $calendar_api->adjust_time(0, 0, 0, $xto['m'], $xto['d'] + 1, $xto['y']);

			$mfrom = $xfrom['m'] - 1;
			$mto = ($xto['y'] - $xfrom['y']) * 12 + $tm + ($xto['d'] > 1 ? 1 : 0);
			$monthes = array();
			for ( $m = $mfrom; $m < $mto; $m++ )
			{
				$monthes[ (($m % 12) + 1) ] = true;
			}
			$select = count($monthes) < 12;
		}

		// no selection : get all birthday
		if ( !$select )
		{
			$sql = 'SELECT ' . implode(', ', $this->user_fields) . '
						FROM ' . USERS_TABLE . '
						WHERE user_id <> ' . ANONYMOUS . '
							AND user_active = 1
							AND user_birthday IS NOT NULL
							AND user_birthday <> \'\'
							AND user_birthday <> \'--\'
						ORDER BY username';
		}

		// select
		else
		{
			$sql_where = array();
			if ( !$monthes[ $xmin2['m'] ] )
			{
				$sql_where[] = '((user_timezone' . ($this->is_dst ? ' + user_dst' : '') . ' - ' . $tz . ') < -24 AND user_birthday LIKE \'' . $xmin2['d'] . '-' . $xmin2['m'] . '%\')';
			}
			if ( !$monthes[ $xmin1['m'] ] )
			{
				$sql_where[] = '((user_timezone' . ($this->is_dst ? ' + user_dst' : '') . ' - ' . $tz . ') < 0 AND user_birthday LIKE \'' . $xmin1['d'] . '-' . $xmin1['m'] . '%\')';
			}
			if ( !$monthes[ $xto['m'] ] )
			{
				$sql_where[] = '((user_timezone' . ($this->is_dst ? ' + user_dst' : '') . ' - ' . $tz . ') > 0 AND user_birthday LIKE \'' . $xto['d'] . '-' . $xto['m'] . '%\')';
			}
			if ( !$monthes[ $xmaj1['m'] ] )
			{
				$sql_where[] = '((user_timezone' . ($this->is_dst ? ' + user_dst' : '') . ' - ' . $tz . ') > 24 AND user_birthday LIKE \'' . $xmaj1['d'] . '-' . $xmaj1['m'] . '%\')';
			}

			if ( count($monthes) <= 6 )
			{
				foreach ( $monthes as $month => $dummy )
				{
					$sql_where[] = 'user_birthday LIKE \'%-' . intval($month) . '-%\'';
				}
			}
			else
			{
				$sql_where_and = array();
				for ( $i = 1; $i <= 12; $i++ )
				{
					if ( !$monthes[$i] )
					{
						$sql_where_and[] = 'user_birthday NOT LIKE \'%-' . $i . '-%\'';
					}
				}
				if ( !empty($sql_where_and) )
				{
					$sql_where[] = '(
									' . implode('
									AND ', $sql_where_and) . '
								)';
				}
				unset($sql_where_and);
			}

			// build the sql request
			$sql = 'SELECT ' . implode(', ', $this->user_fields) . '
						FROM ' . USERS_TABLE . '
						WHERE user_id <> ' . ANONYMOUS . '
							AND user_active = 1
							AND user_birthday IS NOT NULL
							AND user_birthday <> \'\'
							AND user_birthday <> \'--\'
							AND (
									' . implode('
								OR ', $sql_where) . '
							)
						ORDER BY username';
		}
		if ( !($result = $db->sql_query($sql, false, __LINE__, __FILE__, false)) )
		{
			message_die(GENERAL_ERROR, 'Could not read users data', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$b = explode('-', $row['user_birthday']);
			$xbirthday = array('m' => intval($b[1]), 'd' => intval($b[0]), 'y' => intval($b[2]));

			$row['user_birthday'] = $xbirthday;
			$this->adjust_event($row, $xfrom);
			if ( $calendar_api->is_ge($row['viewed_birthday_start'], $xfrom) && (!$row['viewed_birthday_end'] || $calendar_api->is_lt($row['viewed_birthday_end'], $xto)) )
			{
				$this->data[ intval($row['user_id']) ] = $row;
			}
		}
		$db->sql_freeresult($result);
	}
}

?>