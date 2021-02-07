<?php
//
//	file: admin/index.php
//	author: ptirhiik
//	begin: 21/05/2006
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);

//
// Load default header
//
$no_page_header = true;
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/index';

require($phpbb_root_path . 'admin/pagestart.'.$phpEx);

//
// Generate relevant output
//
switch ( _read('pane', TYPE_NO_HTML) )
{
	// menu
	case 'left':
		// get available admin modules
		$module = array();
		if ( $dir = @opendir('.') )
		{
			$setmodules = true;
			while( $file = @readdir($dir) )
			{
				if ( preg_match('/^admin_.*?\.' . $phpEx . '$/', $file) && !in_array(preg_replace('/\.' . $phpEx . '$/i', '', $file), $denied_scripts) )
				{
					include('./' . $file);
				}
			}
			@closedir($dir);
			unset($setmodules);
		}

		// modules
		if ( !empty($module) )
		{
			ksort($module);
			foreach ( $module as $cat => $action_array )
			{
				$template->assign_block_vars('catrow', array(
					'ADMIN_CATEGORY' => $user->lang(preg_replace('#^\d*?_(.*)#i', '\1', $cat)),
				));
				if ( !empty($action_array) )
				{
					$color = false;
					ksort($action_array);
					foreach ( $action_array as $action => $file )
					{
						$color = !$color;
						$row_color = $color ? $theme['td_color1'] : $theme['td_color2'];
						$row_class = $color ? $theme['td_class1'] : $theme['td_class2'];
						$template->assign_block_vars('catrow.modulerow', array(
							'ROW_COLOR' => '#' . $row_color,
							'ROW_CLASS' => $row_class,
							'ADMIN_MODULE' => $user->lang(preg_replace('#^\d*?_(.*)#i', '\1', $action)),
							'U_ADMIN_MODULE' => append_sid($file),
						));
						$template->set_switch('catrow.modulerow.light', $color);
					}
				}
			}
		}

		// main options
		$template->assign_vars(array(
			'L_FORUM_INDEX' => $user->lang('Main_index'),
			'L_ADMIN_INDEX' => $user->lang('Admin_Index'),
			'L_PREVIEW_FORUM' => $user->lang('Preview_forum'),
			'U_FORUM_INDEX' => $config->url(INDEX, '', true),
			'U_ADMIN_INDEX' => $config->url($requester, array('pane' => 'right'), true),
		));

		// send the display
		$template->set_filenames(array('body' => 'admin/index_navigate.tpl'));
		include($config->url('admin/page_header_admin'));
		$template->pparse('body');
		include($config->url('admin/page_footer_admin'));
		break;

	// stats, versions, who's online
	case 'right':
		// forums statistics
		define('FROM_ADMIN_INDEX', true);
		include($config->url('includes/acp/acp_stats_summary'));

		// version verification
		include($config->url('includes/class_versions'));

		$versions = new versions($requester, array('pane' => 'right'));
		$versions->read();
		$versions->refresh(_read('vchk', TYPE_INT));
		$versions->display('VERSION_INFO');

		// users online stats
		include($config->url('includes/class_forums'));
		include($config->url('includes/class_stats'));
		include($config->url('includes/class_stats_online'));

		$forums = new forums();
		$forums->read();
		$user->get_cache(POST_FORUM_URL);
		$stats_online = new stats_online('in_admin');
		$stats_online->read();
		$stats_online->display();
		unset($stats_online);

		// generic legend
		$template->assign_vars(array(
			'L_WELCOME' => $user->lang('Welcome_phpBB'),
			'L_ADMIN_INTRO' => $user->lang('Admin_intro'),
		));

		// send the display
		$template->set_filenames(array('body' => 'admin/index_body.tpl'));
		include($config->url('admin/page_header_admin'));
		$template->pparse('body');
		include($config->url('admin/page_footer_admin'));
		break;

	// frameset
	default:
		$template->assign_vars(array(
			'S_FRAME_NAV' => $config->url($requester, array('pane' => 'left'), true),
			'S_FRAME_MAIN' => $config->url($requester, array('pane' => 'right'), true),
			'S_CONTENT_DIRECTION' => $user->lang('DIRECTION'),
			'S_CONTENT_ENCODING' => $user->lang('ENCODING'),
			'S_CONTENT_DIR_LEFT' => $user->lang('LEFT'),
			'S_CONTENT_DIR_RIGHT' => $user->lang('RIGHT'),
		));

		// send the display
		header ('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		$template->set_filenames(array('body' => 'admin/index_frameset.tpl'));
		$template->pparse('body');
		$db->sql_close();
		exit;
		break;
}

?>