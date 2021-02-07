<?php
//
//	file: includes/class_stats_admin.php
//	author: ptirhiik
//	begin: 07/02/2006
//	version: 1.6.1 - 30/12/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('MULT_SIZE', 1.5);

class stats_admin
{
	var $requester;
	var $parms;
	var $cells;

	var $data;
	var $total;
	var $sum;

	var $graphics;

	function stats_admin($requester, $parms, $cells)
	{
		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->cells = $cells;

		$this->data = array();
		$this->total = array();
		$this->sum = array();

		$this->graphics = array();
		$this->init();
	}

	function init()
	{
		global $config, $images;

		$count_img = count($images['voting_graphic']);
		$this->graphics = array();
		$count_cells = count($this->cells);
		for ( $i = 0; $i < $count_cells; $i++ )
		{
			$j = ($i % $count_img);
			$this->graphics[$i]['left'] = $config->root . $images['voting_left'][$j];
			$this->graphics[$i]['middle'] = $config->root . $images['voting_graphic'][$j];
			$this->graphics[$i]['right'] = $config->root . $images['voting_right'][$j];
		}
	}

	function display_a_bar($is_title, $time, $set, $values)
	{
		global $config, $user, $template;

		// $set = array(
		//	'legend' => front, 'legend_fmt' => sprintf time for legend, 'nolink' => if legend not linked,
		//	'parms' => date format for link, 'extra' = array($key => array(parm => value, 'fmt' => date format for extra link)),
		// )

		$sum = 0;
		$row_values = array();
		foreach ( $this->cells as $key => $dummy )
		{
			$row_values[$key] = intval($values[$key]);
			$sum += intval($values[$key]);
		}
		$values = $row_values;
		unset($row_values);

		$graph_base = count($this->cells);

		// display
		$template->assign_block_vars('row', array(
			'LEGEND' => $template->sprintf($template->lang($set['legend']), $set['legend_fmt'] ? $this->date_local($this->date_format($set['legend_fmt']), $time) : ''),
			'U_LEGEND' => $set['nolink'] ? '' : $config->url($this->requester, $this->parms + array('date' => date($set['parms'], $time)), true),
			'TOTAL' => $sum || $is_title ? $sum : '',
			'PERCENT' => $sum && ! $is_title ? $template->sprintf($template->lang('Stats_percent'), min(round(($sum * 100) / $this->sum), 100)) : '',
		));
		$template->set_switch('row.link', !$set['nolink']);

		// graphics
		$left_displayed = false;
		$displayed = 0;
		foreach ( $values as $key => $value )
		{
			$graph_base--;
			$extra_parms = $set['extra'] && $set['extra'][$key] ? $set['extra'][$key] :array();
			if ( isset($extra_parms['fmt']) )
			{
				$extra_parms += array('date' => date($set['parms'], $time));
				unset($extra_parms['fmt']);
			}
			if ( $value )
			{
				$template->assign_block_vars('row.data', array(
					'U_EXTRA' => $extra_parms ? $config->url($this->requester, $this->parms + $extra_parms, true) : '',
					'TOTAL' => intval($value) ? intval($value) : '',
					'PERCENT' => intval($value) ? sprintf($user->lang('Stats_percent'), min(round(($value * 100) / max(1, $sum)), 100)) : '',

					'S_WIDTH' => round(($value * $config->data['vote_graphic_length'] * MULT_SIZE) / $this->sum),
					'I_LEFT' => $this->graphics[$graph_base]['left'],
					'I_MIDDLE' => $this->graphics[$graph_base]['middle'],
					'I_RIGHT' => $this->graphics[$graph_base]['right'],
				));
				$displayed += $value;
				$template->set_switch('row.data.extra', $extra_parms);

				$template->set_switch('row.data.left', !$left_displayed);
				$template->set_switch('row.data.middle');
				$template->set_switch('row.data.right', $displayed >= $sum);
				if ( $is_title )
				{
					$template->set_switch('row.data.title');
					$template->set_switch('row.data.title.extra', $extra_parms);
				}
				if ( !$left_displayed )
				{
					$left_displayed = true;
				}
			}
			else
			{
				$template->assign_block_vars('row.data', array(
					'U_EXTRA' => $extra_parms ? $config->url($this->requester, $this->parms + $extra_parms, true) : '',
					'I_LEFT' => $this->graphics[$graph_base]['left'],
					'I_MIDDLE' => $this->graphics[$graph_base]['middle'],
					'I_RIGHT' => $this->graphics[$graph_base]['right'],
				));
				$template->set_switch('row.data.extra', $extra_parms && $sum);
				if ( $is_title )
				{
					$template->assign_lastblock_vars('row.data', array(
						'TOTAL' => 0,
						'PERCENT' => sprintf($user->lang('Stats_percent'), 0),
					));
					$template->set_switch('row.data.title');
					$template->set_switch('row.data.title.extra', $extra_parms);
				}
			}
		}
	}

	function date_format($fmt)
	{
		global $user;
		static $date_order, $date_h_fmt, $done;

		if ( $fmt == 'YmdH' )
		{
			return $user->data['user_dateformat'];
		}
		if ( !$done )
		{
			// set user suplementary date format
			$date_order = _date_order($user->data['user_dateformat'], true);
			$date_h_fmt = _date_h_fmt($user->data['user_dateformat']);
			$done = true;
		}

		$res = '';
		$fmt = ' ' . strtolower($fmt);
		foreach ( $date_order as $item => $order )
		{
			if ( strpos($fmt, $item) )
			{
				$item = $item == 'h' ? $date_h_fmt : ($item == 'y' ? 'Y' : ($item == 'm' ? 'F' : $item));
				$res .= (empty($res) ? '' : ' ') . $item;
			}
		}
		return $res;
	}

	function date_local($format, $date)
	{
		global $lang;
		return strtr(date($format, $date), $lang['datetime']);
	}

	function date_minus($date, $date_inc)
	{
		$ary_date = explode(', ', date('m, d, Y', $date));
		switch ( $date_inc )
		{
			case 'H':
				$date -= 3600;
				break;
			case 'd':
				$date = mktime(0, 0, 0, $ary_date[0], $ary_date[1] - 1, $ary_date[2]);
				break;
			case 'Ym':
				$date = mktime(0, 0, 0, $ary_date[0]-1, $ary_date[1], $ary_date[2]);
				break;
		}
		return $date;
	}
}

?>