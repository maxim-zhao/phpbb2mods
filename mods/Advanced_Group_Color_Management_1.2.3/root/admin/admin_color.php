<?php
/***************************************************************************
*							admin_color.php
*							--------------
*	begin		: 30/09/2005
*	copyright	: phantomk
*	email		: phantomk@modmybb.com
*
*	Version		: 0.0.10 - 24/01/2006
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

define('IN_PHPBB', true);

if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Groups']['Colors'] = $filename;

	return;
}

$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ( isset($HTTP_POST_VARS[POST_STYLES_URL]) || isset($HTTP_GET_VARS[POST_STYLES_URL]) )
{
	$style_id = ( isset($HTTP_POST_VARS[POST_STYLES_URL]) ) ? intval($HTTP_POST_VARS[POST_STYLES_URL]) : intval($HTTP_GET_VARS[POST_STYLES_URL]);
}
else
{
	$style_id = '';
}

if ( ( isset($HTTP_POST_VARS['edit']) || isset($HTTP_GET_VARS['edit']) ) && !empty($style_id ) )
{
	if ( isset($HTTP_POST_VARS[POST_GROUPS_URL]) || isset($HTTP_GET_VARS[POST_GROUPS_URL]) )
	{
		$group_id = ( isset($HTTP_POST_VARS[POST_GROUPS_URL]) ) ? intval($HTTP_POST_VARS[POST_GROUPS_URL]) : intval($HTTP_GET_VARS[POST_GROUPS_URL]);

		$move = ( isset($HTTP_POST_VARS['edit']) ) ? intval($HTTP_POST_VARS['edit']) : intval($HTTP_GET_VARS['edit']);

		$sql = 'UPDATE ' . GROUPS_TABLE . '
				SET group_weight = ' . $move . '
				WHERE group_id = ' . $group_id;
		if ( !($db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error updateing groups table', '', __LINE__, __FILE__, $sql);
		}

		$colors->set_group_weight();
	}

	if ( $style_id != -1 )
	{
		$sql = 'SELECT themes_id, style_name
				FROM ' . THEMES_TABLE . '
				WHERE themes_id = ' . intval($style_id);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain themes data', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$style_id = $row['themes_id'];
			$style_name = $row['style_name'];
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['No_style_exists']);
		}

		$db->sql_freeresult($result);
	}
	else
	{
		$style_id = -1;
		$style_name = $lang['AGCM_editing_all'];
	}

	if ( defined('IN_CH') )
	{
		$sql = 'SELECT group_id, group_name, group_weight, group_legend, group_color, group_status
				FROM ' . GROUPS_TABLE . '
				WHERE group_single_user <> ' . true . '
					AND group_status < ' . GROUP_SPECIAL . '
				ORDER BY group_weight ASC';
	}
	else
	{
		$sql = 'SELECT group_id, group_name, group_weight, group_legend, group_color
				FROM ' . GROUPS_TABLE . '
				WHERE group_single_user <> ' . true . '
				ORDER BY group_weight ASC';
	}

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain group data', '', __LINE__, __FILE__, $sql);
	}

	$i = 0;
	$groups = array();

	while ($row = $db->sql_fetchrow($result))
	{
		$groups[$i] = $row;
		$i++;
	}

	$db->sql_freeresult($result);

	if ( $style_id != -1 )
	{
		$style_color = array();

		$sql = 'SELECT *
				FROM ' . THEMES_TABLE . '
				WHERE themes_id = ' . intval($style_id);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain themes data', '', __LINE__, __FILE__, $sql);
		}

		$row = $db->sql_fetchrow($result);

		for ($j = 0; $j < $i; $j++)
		{
			$style_color[$j] = $row['g' . intval($groups[$j]['group_id']) ];
		}

		$db->sql_freeresult($result);
	}

	$s_hidden_fields = '<input type="hidden" name="s" value="' . $style_id . '" />';

	$template->set_filenames(array(
		'body' => 'admin/color_edit_body.tpl')
	);

	$template->assign_vars(array(
		'FALSE' => '0',
		'TRUE' => '1',
		'GROUP_SESSION' => $row['session_time'],
		'GROUP_ANONYMOUS' => $row['g0'],

		'I_UP' => $phpbb_root_path . $images['Up'],
		'I_DOWN' => $phpbb_root_path . $images['Down'],

		'L_TITLE' => $lang['AGCM_color_admin'],
		'L_EDIT' => $style_id == -1 ? $style_name : sprintf($lang['AGCM_edit_style'], $style_name),
		'L_NO' => $lang['No'],
		'L_YES' => $lang['Yes'],
		'L_UP' => $lang['AGCM_up'],
		'L_DOWN' => $lang['AGCM_down'],
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_COLOR' => $lang['AGCM_color'],
		'L_COLOR_EXPLAIN' => $lang['AGCM_color_explain'],
		'L_FIND_COLOR' => $lang['AGCM_find_color'],
		'L_LEGEND' => $lang['AGCM_legend'],
		'L_SESSION' => $lang['AGCM_session'],
		'L_SESSION_EXPLAIN' => $lang['AGCM_session_explain'],
		'L_ANONYMOUS' => $lang['AGCM_anonymous'],
		'L_ANONYMOUS_EXPLAIN' => $lang['AGCM_anonymous_explain'],
		'L_REGISTERED' => $lang['AGCM_registered'],
		'L_REGISTERED_EXPLAIN' => $lang['AGCM_registered_explain'],
		'L_TIME' => $lang['AGCM_time'],
		'L_TIME_EXPLAIN' => $lang['AGCM_time_explain'],
		'L_CHECK' => $lang['AGCM_check'],
		'L_CHECK_EXPLAIN' => $lang['AGCM_check_explain'],

		'U_SEARCH_COLOR' => append_sid($phpbb_root_path . "search." . $phpEx . "?mode=searchcolor"),

		'S_TIME' => $colors->inactive_select('agcm_time'),
		'S_CHECK_YES' => ($board_config['agcm_check']) ? ' checked="checked"' : '',
		'S_CHECK_NO' => (!$board_config['agcm_check']) ? ' checked="checked"' : '',
		'S_HIDDEN_FIELDS' => $s_hidden_fields,
		'S_ACTION' => append_sid("admin_color.$phpEx"))
	);

	if ( !defined('IN_CH') )
	{
		$template->assign_block_vars('group_registered', array(
			'GROUP_REGISTERED' => $row['g'])
		);
	}

	if ( !empty($groups) )
	{
		for ($j = 0; $j < $i; $j++)
		{
			$template->assign_block_vars('group_color_edit', array(
				'ID' => $groups[$j]['group_id'],
				'GROUP_NAME' => defined('IN_CH') ? ( ( $groups[$j]['group_status'] == GROUP_SYSTEM ) ? $user->lang($groups[$j]['group_name']) : $groups[$j]['group_name'] ) : $groups[$j]['group_name'],
				'GROUP_COLOR' => $style_id == -1 ? '' : $style_color[$j],

				'U_WEIGHT_UP' => append_sid("admin_color." . $phpEx . "?" . POST_GROUPS_URL . "=" . $groups[$j]['group_id'] . "&amp;edit=" . ($groups[$j]['group_weight'] - 15) . "&amp;" . POST_STYLES_URL . "=" . $style_id),
				'U_WEIGHT_DOWN' => append_sid("admin_color." . $phpEx . "?" . POST_GROUPS_URL . "=" . $groups[$j]['group_id'] . "&amp;edit=" . ($groups[$j]['group_weight'] + 15) . "&amp;" . POST_STYLES_URL . "=" . $style_id),

				'S_LEGEND_YES' => ($groups[$j]['group_legend']) ? ' checked="checked"' : '',
				'S_LEGEND_NO' => (!$groups[$j]['group_legend']) ? ' checked="checked"' : '')
			);

			if ( $j != 0 )
			{
				$template->assign_block_vars('group_color_edit.up', array());
			}

			if ( $j < ($i - 1) )
			{
				$template->assign_block_vars('group_color_edit.down', array());
			}
		}
	}
}
else if ( isset($HTTP_POST_VARS['color_update']) && !empty($style_id ) )
{
	if ( $style_id != -1 )
	{
		$sql = 'SELECT themes_id, style_name
				FROM ' . THEMES_TABLE . '
				WHERE themes_id = ' . intval($style_id);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Couldn\'t obtain themes data', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$style_id = $row['themes_id'];
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['AGCM_no_style_exists']);
		}

		$db->sql_freeresult($result);
	}
	else
	{
		$style_id = -1;
	}

	if ( defined('IN_CH') )
	{
		$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . '
				WHERE group_single_user <> ' . true . '
					AND group_status < ' . GROUP_SPECIAL . '
				ORDER BY group_weight ASC';
	}
	else
	{
		$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . '
				WHERE group_single_user <> ' . true . '
				ORDER BY group_weight ASC';
	}

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain groups data', '', __LINE__, __FILE__, $sql);
	}

	$i = 0;
	$groups = array();

	while( $row = $db->sql_fetchrow($result) )
	{
		$groups[$i] = $row;
		$i++;
	}

	$db->sql_freeresult($result);
	$error = false;

	for ($j = 0; $j < $i; $j++)
	{
		$color_id = 'color' . intval($groups[$j]['group_id']);
		$color = htmlspecialchars($HTTP_POST_VARS[$color_id]);

		$legend_id = 'legend' . intval($groups[$j]['group_id']);
		$legend = empty($color) ? 0 : intval($HTTP_POST_VARS[$legend_id]);

		$group_color = empty($color) ? 0 : 1;

		$sql = 'UPDATE ' . THEMES_TABLE . '
				SET g' . intval($groups[$j]['group_id']) . ' = \'' . $color . '\'
				' . ( $style_id == -1 ? '' : 'WHERE themes_id = ' . $style_id );
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error updateing themes table', '', __LINE__, __FILE__, $sql);
		}

		$sql = 'UPDATE ' . GROUPS_TABLE . '
				SET group_legend = ' . $legend . ', group_color = ' . $group_color . '
				WHERE group_id = ' . intval($groups[$j]['group_id']);
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error updateing themes table', '', __LINE__, __FILE__, $sql);
		}
	}

	$color_session = htmlspecialchars($HTTP_POST_VARS['color_session']);

	$sql = 'UPDATE ' . THEMES_TABLE . '
			SET session_time = \'' . $color_session . '\'
			' . ( $style_id == -1 ? '' : 'WHERE themes_id = ' . $style_id );
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error updateing themes table', '', __LINE__, __FILE__, $sql);
	}

	$color_anonymous = htmlspecialchars($HTTP_POST_VARS['color_anonymous']);

	$sql = 'UPDATE ' . THEMES_TABLE . '
			SET g0 = \'' . $color_anonymous . '\'
			' . ( $style_id == -1 ? '' : 'WHERE themes_id = ' . $style_id );
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error updateing themes table', '', __LINE__, __FILE__, $sql);
	}

	if ( !defined('IN_CH') )
	{
		$color_registered = htmlspecialchars($HTTP_POST_VARS['color_registered']);

		$sql = 'UPDATE ' . THEMES_TABLE . '
				SET g = \'' . $color_registered . '\'
				' . ( $style_id == -1 ? '' : 'WHERE themes_id = ' . $style_id );
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Error updateing themes table', '', __LINE__, __FILE__, $sql);
		}
	}

	$agcm_check = ( isset($HTTP_POST_VARS['agcm_check']) ) ? ( ($HTTP_POST_VARS['agcm_check']) ? TRUE : 0 ) : 0;

	$sql = 'UPDATE ' . CONFIG_TABLE . '
			SET config_value = \'' . $agcm_check . '\'
			WHERE config_name = \'agcm_check\'';
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error updateing config table', '', __LINE__, __FILE__, $sql);
	}

	$agcm_time = (!empty($HTTP_POST_VARS['agcm_time'])) ? trim(htmlspecialchars($HTTP_POST_VARS['agcm_time'])) : '';

	$sql = 'UPDATE ' . CONFIG_TABLE . '
			SET config_value = \'' . $agcm_time . '\'
			WHERE config_name = \'agcm_time\'';
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Error updateing config table', '', __LINE__, __FILE__, $sql);
	}

	if (defined('IN_CH'))
	{
		$themes = new themes();
		$themes->read(true);
		$config->read(true);
		$colors->read(true);
	}

	$message = $lang['AGCM_update_successfull'] . '<br /><br />' . sprintf($lang['AGCM_click_return_color_admin'], '<a href="' . append_sid("admin_color.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');

	message_die(GENERAL_MESSAGE, $message);
}
else
{
	$sql = 'SELECT themes_id, style_name
			FROM ' . THEMES_TABLE . '
			ORDER BY template_name';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);

	$select_list = '<select name="' . POST_STYLES_URL . '">';

	$select_list .= '<option value="-1">' . $lang['AGCM_edit_all'] . '</option>';

	while( $row = $db->sql_fetchrow($result) )
	{
		$select_list .= '<option value="' . $row['themes_id'] . '">' . $row['style_name'] . '</option>';
	}

	$select_list .= '</select>';

	$db->sql_freeresult($result);

	$template->set_filenames(array(
		'body' => 'admin/color_style_select.tpl')
	);

	$template->assign_vars(array(
		'L_TITLE' => $lang['AGCM_color_admin'],
		'L_EXPLAIN' => $lang['AGCM_color_admin_explain'],
		'L_SELECT' => $lang['AGCM_select_style'],
		'L_LOOK_UP' => $lang['AGCM_look_up_group_color'],

		'S_ACTION' => append_sid("admin_color.$phpEx"),
		'S_SELECT' => $select_list)
	);
}

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>