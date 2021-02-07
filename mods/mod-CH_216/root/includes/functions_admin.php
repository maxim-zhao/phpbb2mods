<?php
//
//	file: includes/functions_admin.php
//	author: ptirhiik
//	begin: 01/06/2006
//	version: 1.6.1 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// only used in modcp
function make_forum_select($box_name, $ignore_forum = false, $select_forum = '')
{
	global $config, $forums, $user;

	$front_pic = $forums->get_front_pic();
	if ( !empty($front_pic) )
	{
		$forum_list = '';
		foreach ( $front_pic as $cur_id => $front )
		{
			$selected = !empty($select_forum) && ($select_forum == $cur_id) ? ' selected="selected"' : '';
			$forum_list .= '<option value="' . (($cur_id >= 0) ? $cur_id : -1) . '"' . $selected . '>';
			$count_front = strlen($front);
			for ( $i = 0; $i < $count_front; $i++ )
			{
				$forum_list .= $user->lang('tree_pic_' . $front[$i]);
			}
			if ( $cur_id >= 0 )
			{
				$forum_list .= $user->lang($forums->data[$cur_id]['forum_name']);
			}
			$forum_list .= '</option>';
		}
	}
	else
	{
		$forum_list = '<option value="-1">' . $user->lang('None') . '</option>';
	}
	$forum_list = '<select name="' . $box_name . '">' . $forum_list . '</select>';

	return $forum_list;
}

?>