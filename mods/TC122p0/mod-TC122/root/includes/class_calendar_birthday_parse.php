<?php
/***************************************************************************
 *                            class_calendar_birthday_parse.php
 *                            ---------------------------------
 *	begin			: 04/05/2006
 *	copyright		: Ptirhiik
 *	email			: admin@rpgnet-fr.com
 *	version			: 0.0.2 - 19/05/2006
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

class ranks
{
	function read()
	{
		global $db;

		$sql = 'SELECT *
					FROM ' . RANKS_TABLE . '
					ORDER BY rank_special, rank_min';
		if ( !($result = $db->sql_query($sql, false, __LINE__, __FILE__, false)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain ranks information', '', __LINE__, __FILE__, $sql);
		}
		$data = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$data[] = $row;
		}
		$db->sql_freeresult($result);
		return $data;
	}
}

class calendar_profile
{
	var $ranks_done;
	var $ranks_special;
	var $ranks_regular;

	function calendar_profile()
	{
		$this->ranks_special = array();
		$this->ranks_regular = array();
		$this->ranks_done = false;
	}

	function read_ranks()
	{
		if ( $this->ranks_done )
		{
			return;
		}

		$this->ranks_done = true;
		$this->ranks_special = array();
		$this->ranks_regular = array();
		$ranks = new ranks();
		$ranksrow = $ranks->read();
		unset($ranks);
		for ( $i = count($ranksrow) - 1 ; $i >= 0; $i-- )
		{
			if ( $ranksrow[$i]['rank_special'] )
			{
				$this->ranks_special[ $ranksrow[$i]['rank_id'] ] = array('txt' => $ranksrow[$i]['rank_title'], 'img' => $ranksrow[$i]['rank_image']);
			}
			else
			{
				$this->ranks_regular[ $ranksrow[$i]['rank_min'] ] = array('txt' => $ranksrow[$i]['rank_title'], 'img' => $ranksrow[$i]['rank_image']);
			}
		}
	}

	function get_rank(&$data)
	{
		global $user;

		$this->read_ranks();

		// find the rank
		if ( $data['user_id'] == ANONYMOUS )
		{
			return array('txt' => $user->lang('Guest'), 'img' => '');
		}

		if ( $data['user_rank'] && isset($this->ranks_special[ $data['user_rank'] ]) )
		{
			return $this->ranks_special[ $data['user_rank'] ];
		}

		if ( !empty($this->ranks_regular) )
		{
			foreach ( $this->ranks_regular as $rank_min => $dummy )
			{
				if ( intval($data['user_posts']) >= $rank_min )
				{
					return $this->ranks_regular[$rank_min];
				}
				else
				{
					break;
				}
			}
		}
		return array();
	}

	function get_avatar(&$data)
	{
		global $user, $config;

		$avatar = '';
		if ( ($data['user_id'] != ANONYMOUS) && $data['user_allowavatar'] )
		{
			switch ( $data['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$avatar = $config->data['allow_avatar_upload'] && (trim($config->data['avatar_path']) != '') ? $config->data['avatar_path'] . '/' . trim($data['user_avatar']) : '';
					break;
				case USER_AVATAR_REMOTE:
					$avatar = $config->data['allow_avatar_remote'] && (trim($data['user_avatar']) != '') ? trim($data['user_avatar']) : '';
					break;
				case USER_AVATAR_GALLERY:
					$avatar = $config->data['allow_avatar_local'] && (trim($config->data['avatar_gallery_path']) != '') ? $config->data['avatar_gallery_path'] . '/' . trim($data['user_avatar']) : '';
					break;
				default:
					$avatar = trim($config->data['default_avatar']) != '' ? $user->img($config->data['default_avatar']) : '';
					break;
			}
		}
		return $avatar;
	}
}

?>