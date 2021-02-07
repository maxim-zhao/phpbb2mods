<?php
//
//	file: includes/class_run_stats.php
//	author: ptirhiik
//	begin: 25/08/2004
//	version: 1.6.3 - 21/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// sql/run stat class
class stat_run_class
{
	var $endtime;

	function stat_run_class($endtime)
	{
		$this->endtime = $endtime;
	}

	function display()
	{
		global $db, $template, $user, $config;
		global $lang;

		if ( !defined('DEBUG_RUN_STATS') )
		{
			return;
		}
		list($trc_pgm, $trc_memory) = _backtrace('', true);
		$starttime = $trc_pgm[0]['time'];

		// lang keys
		if ( empty($lang) || empty($lang['Stat_surround']) )
		{
			$lang = array(
				'Stat_surround' => '[ %s ]',
				'Stat_sep' => ' - ',
				'Stat_page_duration' => 'Time: %.4fs',
				'Stat_local_duration' => 'local trace: %.4fs',
				'Stat_part_php' => 'PHP: %.2d%%',
				'Stat_part_sql' => 'SQL: %.2d%%',
				'Stat_queries_total' => 'Queries: %2d (%.4fs)',
				'Stat_queries_db' => 'db: %2d (%.4fs)',
				'Stat_queries_cache' => 'cache: %2d (%.4fs/%.4fs)',
				'Stat_gzip_enable' => 'GZIP on',
				'Stat_debug_enable' => 'Debug on',

				'Stat_request' => 'Request',
				'Stat_line' => 'Line:&nbsp;%d',
				'Stat_cache' => 'cache:&nbsp;%.4fs',
				'Stat_db' => 'db:&nbsp;%.4fs',
				'Stat_table' => 'Table',
				'Stat_type' => 'Type',
				'Stat_possible_keys' => 'Possible keys',
				'Stat_key' => 'Used key',
				'Stat_key_len' => 'Key length',
				'Stat_ref' => 'Ref.',
				'Stat_rows' => 'Rows',
				'Stat_Extra' => 'Comment',
				'Stat_Comment' => 'Comment',

				'Stat_backtrace' => 'Backtrace required',
			);
		}
		if ( !isset($lang['Stat_memory']) )
		{
			$lang += array(
				'Stat_memory' => 'Memory: %d K',
			);
		}

		// trace informations
		$pag_duration = convert_microtime($this->endtime) - convert_microtime($starttime);
		$sql_dump = '';
		$sql_duration = $count_cached = $dur_cached = $dur_cached_real = 0;
		$debug_duration = 0;

		// browse all requests
		$color = false;
		$trc_sql = $db->trc_sql;
		$count_trc_sql = count($trc_sql);
		for ( $i = 0; $i < $count_trc_sql; $i++ )
		{
			// cached request
			$cached = isset($trc_sql[$i]['cached']) && $trc_sql[$i]['cached'];

			// duration
			$sql_dur = convert_microtime($trc_sql[$i]['end']) - convert_microtime($trc_sql[$i]['start']);
			$sql_duration += $sql_dur;
			if ( $cached )
			{
				$count_cached++;
				$dur_cached += $sql_dur;
			}

			// debug duration
			$debug_duration += (convert_microtime($trc_sql[$i]['after_debug']) - convert_microtime($trc_sql[$i]['end']));

			// dump informations
			if ( defined('DEBUG_SQL') && ($user->data['user_level'] == ADMIN) )
			{
				$sql_real_dur = 0;
				if ( $cached )
				{
					$db->trc_sql = array();
					$sql = $trc_sql[$i]['sql'];
					$db->sql_query($sql, false, __LINE__, __FILE__);
					$sql_real_dur = convert_microtime($db->trc_sql[0]['end']) - convert_microtime($db->trc_sql[0]['start']);
					$dur_cached_real += $sql_real_dur;
				}

				// display
				$color = !$color;
				$template->assign_block_vars('stat_run', array(
					'STAT_FILE' => $trc_sql[$i]['file'],
					'STAT_LINE' => sprintf($lang['Stat_line'], $trc_sql[$i]['line']),
					'STAT_TIME_CACHE' => $cached ? sprintf($lang['Stat_cache'], $sql_dur) : '',
					'STAT_TIME_DB' => $cached ? sprintf($lang['Stat_db'], $sql_real_dur) : sprintf($lang['Stat_db'], $sql_dur),
					'STAT_REQUEST' => htmlspecialchars(preg_replace('/[\n\r\s\t]+/', ' ', $trc_sql[$i]['sql'])),
				));
				$template->set_switch('stat_run.light', $color);
				$template->set_switch('stat_run.cached', $cached);

				// for mysql, explain request
				$request_explain = '';
				if ( in_array(SQL_LAYER, array('mysql', 'mysql4', 'postgresql')) && !preg_match('/^(UPDATE|INSERT|DELETE|SHOW|TRUNCATE|ALTER|EXPLAIN)/i', $trc_sql[$i]['sql']) )
				{
					// get explainations
					$sql = 'EXPLAIN ' . $trc_sql[$i]['sql'];
					if ( $result = @$db->sql_query($sql, false, __LINE__, __FILE__, false) )
					{
						$first_table = true;
						$explain_color = false;
						while ( $row = $db->sql_fetchrow($result) )
						{
							// send legend
							if ( $first_table )
							{
								$template->set_switch('stat_run.explain');
								foreach ( $row as $key => $value )
								{
									if ( !is_integer($key) )
									{
										$template->assign_block_vars('stat_run.explain.cell', array(
											'STAT_LEGEND' => isset($lang['Stat_' . $key]) ? $lang['Stat_' . $key] : str_replace('_', ' ', $key),
										));
									}
								}
							}
							$first_table = false;

							// send explain values
							$explain_color = !$explain_color;
							$template->set_switch('stat_run.explain.table');
							foreach ( $row as $key => $value )
							{
								if ( !is_integer($key) )
								{
									$template->assign_block_vars('stat_run.explain.table.cell', array(
										'STAT_VALUE' => $value,
									));
									$template->set_switch('stat_run.explain.table.cell.light', $explain_color);
								}
							}
						}
						$db->sql_freeresult($result);
					}

					// error while attempting explain request
					else
					{
						$template->set_switch('stat_run.explain');
						$template->assign_block_vars('stat_run.explain.cell', array(
							'STAT_LEGEND' => $lang['Stat_explain_failed'],
						));
					}
				}
			}
		}

		// dump request chain
		if ( ($count_trc = count($trc_pgm)) )
		{
			$color = false;
			for ( $i = 1; $i < $count_trc; $i++ )
			{
				$color = !$color;
				if ( $i == 1 )
				{
					$template->assign_block_vars('stat_run_pgm', array(
						'L_BACKTRACE' => $lang['Stat_backtrace'],
					));

					// debug duration
					$debug_duration += (convert_microtime($trc_pgm[$i]['after_debug']) - convert_microtime($trc_pgm[$i]['time']));
				}

				// memory
				$mem = '';
				if ( defined('DEBUG_MEMORY') && DEBUG_MEMORY && ($trc_memory > 1) )
				{
					$mem = '<br />' . sprintf($lang['Stat_memory'], round(($trc_pgm[$i]['mem'] - $trc_memory) / 1024)) . ($i > 1 ? '/' . ($trc_pgm[$i]['mem'] - $trc_pgm[($i - 1)]['mem']) . ' Bytes' : '');
				}
				$template->assign_block_vars('stat_run_pgm.call', array(
					'FILE' => $trc_pgm[$i]['trace'][0]['file'],
					'LINE' => sprintf($lang['Stat_line'], $trc_pgm[$i]['trace'][0]['line']),
					'ELAPSED' => sprintf($lang['Stat_local_duration'], convert_microtime($trc_pgm[$i]['time']) - convert_microtime($starttime)) . ($i > 1 ? sprintf('/%.4fs', convert_microtime($trc_pgm[$i]['time']) - convert_microtime($trc_pgm[ ($i- 1) ]['after_debug'])) : '') . $mem,
				));
				$template->set_switch('stat_run_pgm.call.light', $color);
				$count_requester = count($trc_pgm[$i]['trace']);
				for ( $j = 0; $j < $count_requester; $j++ )
				{
					$template->assign_block_vars('stat_run_pgm.call.requester', array(
						'FILE' => ($j ? str_repeat('&nbsp;', ($j - 1) * 3) . '|_&nbsp;' : ($trc_pgm[$i]['comment'] ? $trc_pgm[$i]['comment'] . ': ' : '')) . $trc_pgm[$i]['trace'][$j]['file'],
						'LINE' => sprintf($lang['Stat_line'], $trc_pgm[$i]['trace'][$j]['line']),
					));
				}
			}
		}

		// duration
		$duration = array(
			sprintf($lang['Stat_page_duration'], $pag_duration - $debug_duration),
		);

		// memory
		if ( defined('DEBUG_MEMORY') && DEBUG_MEMORY && ($trc_memory > 1) )
		{
			if ( function_exists('memory_get_peak_usage') )
			{
				$duration[] = sprintf($lang['Stat_memory'], round((memory_get_peak_usage() - $trc_memory) / 1024));
			}
			else
			{
				$duration[] = sprintf($lang['Stat_memory'], round((memory_get_usage() - $trc_memory) / 1024));
			}
		}

		// parts
		$sql_part = round(($sql_duration / ($pag_duration - $debug_duration)) * 100);
		$parts = array(
			sprintf($lang['Stat_part_php'], 100 - $sql_part),
			sprintf($lang['Stat_part_sql'], $sql_part),
		);

		// queries
		$queries = defined('DEBUG_SQL') && !empty($count_cached) ? array(
			sprintf($lang['Stat_queries_total'], $count_trc_sql, $sql_duration),
			sprintf($lang['Stat_queries_db'], $count_trc_sql - $count_cached, $sql_duration - $dur_cached),
			sprintf($lang['Stat_queries_cache'], $count_cached, $dur_cached, $dur_cached_real),
		) : array(
			sprintf($lang['Stat_queries_total'], $count_trc_sql - $count_cached, $sql_duration - $dur_cached),
		);

		// setup
		$setup = array();
		if ( $config->data['gzip_compress'] )
		{
			$setup[] = $lang['Stat_gzip_enable'];
		}
		if ( DEBUG )
		{
			$setup[] = $lang['Stat_debug_enable'];
		}

		// display stats
		$template->assign_vars(array(
			'L_STAT_PAGE_DUR' => sprintf($lang['Stat_surround'], implode($lang['Stat_sep'], $duration)),
			'L_STAT_PARTS' => sprintf($lang['Stat_surround'], implode($lang['Stat_sep'], $parts)),
			'L_STAT_QUERIES' => sprintf($lang['Stat_surround'], implode($lang['Stat_sep'], $queries)),
			'L_STAT_SETUP' => empty($setup) ? '' : sprintf($lang['Stat_surround'], implode($lang['Stat_sep'], $setup)),
			'L_STAT_REQUEST' => $lang['Stat_request'],
		));
		$template->set_switch('stat_run_table');
	}
}

?>