<?php
/***************************************************************************
 *                            class_calendar_birthday_mdy.php
 *                            -------------------------------
 *	begin			: 24/04/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 0.0.3 - 06/06/2006
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
	// birthday format is mmddyyyy
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

		// no selection : get all birthday
		if ( !$select )
		{
			$sql = 'SELECT ' . implode(', ', $this->user_fields) . '
						FROM ' . USERS_TABLE . '
						WHERE user_id <> ' . ANONYMOUS . '
							AND user_active = 1
							AND user_birthday > 0
						ORDER BY username';
		}

		// select
		else
		{
			// we only consider the month and day
			$md_from = $this->md($xfrom);
			$md_to = $this->md($xto);

			$md_min1 = $this->md($calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'] - 1, $xfrom['y']));
			$md_min2 = $this->md($calendar_api->adjust_time(0, 0, 0, $xfrom['m'], $xfrom['d'] - 2, $xfrom['y']));
			$md_maj1 = $this->md($calendar_api->adjust_time(0, 0, 0, $xto['m'], $xto['d'] + 1, $xto['y']));

			// now we can read
			$sql = 'SELECT ' . implode(', ', $this->user_fields) . '
						FROM ' . USERS_TABLE . '
						WHERE user_id <> ' . ANONYMOUS . '
							AND user_active = 1
							AND user_birthday > 0
							AND ((
									((user_timezone' . ($this->is_dst ? ' + user_dst' : '') . ' - ' . $tz . ') < -24 AND user_birthday >= ' . $md_min2 . '0000 AND user_birthday <= ' . $md_min2 . '9999)
								OR ((user_timezone' . ($this->is_dst ? ' + user_dst' : '') . ' - ' . $tz . ') < 0 AND user_birthday >= ' . $md_min1 . '0000 AND user_birthday <= ' . $md_min1 . '9999)
								OR (user_birthday >= ' . $md_from . '0000)
								)' . ($md_from < $md_to ? ' AND ' : ' OR ') . '(
									((user_timezone' . ($this->is_dst ? ' + user_dst' : '') . ' - ' . $tz . ') > 24 AND user_birthday >= ' . $md_maj1 . '0000 AND user_birthday <= ' . $md_maj1 . '9999)
								OR ((user_timezone' . ($this->is_dst ? ' + user_dst' : '') . ' - ' . $tz . ') > 0 AND user_birthday >= ' . $md_to . '0000 AND user_birthday <= ' . $md_to . '9999)
								OR (user_birthday < ' . $md_to . '0000)
							))
						ORDER BY username';
		}
		if ( !($result = $db->sql_query($sql, false, __LINE__, __FILE__, false)) )
		{
			message_die(GENERAL_ERROR, 'Could not read users data', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$bmd = intval($row['user_birthday'] / 10000);
			$bm = intval($bmd / 100);
			$bd = $bmd % 100;
			$by = $row['user_birthday'] % 10000;

			$row['user_birthday'] = intval($row['user_birthday']) ? array('m' => $bm, 'd' => $bd, 'y' => $by) : array();
			$this->adjust_event($row, $xfrom);
			if ( $calendar_api->is_ge($row['viewed_birthday_start'], $xfrom) && (!$row['viewed_birthday_end'] || $calendar_api->is_lt($row['viewed_birthday_end'], $xto)) )
			{
				$this->data[ intval($row['user_id']) ] = $row;
			}
		}
		$db->sql_freeresult($result);
	}

	function md($xtime)
	{
		return intval(sprintf('%02d%02d', $xtime['m'], $xtime['d']));
	}
}

?>