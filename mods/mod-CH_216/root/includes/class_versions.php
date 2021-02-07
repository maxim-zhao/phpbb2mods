<?php
//
//	file: includes/class_versions.php
//	author: ptirhiik
//	begin: 03/01/2006
//	version: 1.6.1 - 01/06/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

define('VERSION_CHECK_DELAY', 86400);

class versions
{
	var $requester;
	var $parms;
	var $data;
	var $files;
	var $plug_ins;

	function versions($requester, $parms='')
	{
		global $config;

		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->data = array();
		$this->files = array();

		// plugs
		$plug_ins = new plug_ins();
		$plug_ins->load('class_versions');
		unset($plug_ins);
		$this->plug_ins = &$config->plug_ins['class_versions'];
	}

	function read()
	{
		global $config;

		// get data (fake a table at this time)
		$this->data = array(
			array(),
			array('app_name' => 'phpBB', 'app_desc' => '', 'app_marker' => 'version', 'app_author' => 'phpBB group', 'app_author_url' => 'http://www.phpbb.com', 'app_info' => 'Mailing_list_subscribe_reminder', 'app_server' => 'www.phpbb.com', 'app_file' => '/updatecheck/20x.txt', 'app_protocol' => 'phpbb', 'app_page' => 'http://www.phpbb.com/downloads.php'),
			array('app_name' => 'Categories hierarchy', 'app_desc' => '', 'app_marker' => 'mod_cat_hierarchy', 'app_author' => 'Ptirhiik', 'app_author_url' => 'http://ptifo.clanmckeen.com', 'app_server' => 'ptifo.clanmckeen.com', 'app_file' => '/download/versions.dta', 'app_protocol' => 'native', 'app_page' => 'http://ptifo.clanmckeen.com/download.php'),
		);
		unset($this->data[0]);

		// plugs
		if ( $this->plug_ins )
		{
			foreach ( $this->plug_ins as $plug => $dummy )
			{
				if ( method_exists($this->plug_ins[$plug], 'read') )
				{
					$this->plug_ins[$plug]->read($this->data);
				}
			}
		}

		// organize per author and files
		$this->files = array();
		foreach ( $this->data as $app_id => $data )
		{
			// get current version
			$this->data[$app_id]['app_installed'] = ($this->data[$app_id]['app_name'] == 'phpBB' ? '2' : '') . ($config->data[ $data['app_marker'] ] ? $config->data[ $data['app_marker'] ] : (defined($data['app_marker']) ? constant($data['app_marker']) : ''));

			// store to files array
			if ( !isset($this->files[ $data['app_author'] ]) )
			{
				$this->files[ $data['app_author'] ] = array(
					'app_author_url' => $data['app_author_url'],
					'app_files' => array(),
				);
			}
			if ( !isset($this->files[ $data['app_author'] ]['app_files'][ $data['app_server'] . $data['app_file'] ]) )
			{
				$this->files[ $data['app_author'] ]['app_files'][ $data['app_server'] . $data['app_file'] ] = array(
					'app_server' => $data['app_server'],
					'app_protocol' => $data['app_protocol'],
					'app_ids' => array($app_id),
				);
			}
			else
			{
				$this->files[ $data['app_author'] ]['app_files'][ $data['app_server'] . $data['app_file'] ]['app_ids'][] = $app_id;
			}
		}
	}

	function refresh($force=false)
	{
		global $config;

		// we don't want to check at any time : do it only once a day
		if ( !$force |= !intval($config->data['version_check_delay']) || (time() - intval($config->data['version_check_delay']) > VERSION_CHECK_DELAY) )
		{
			return;
		}
		foreach ( $this->files as $provider => $files )
		{
			foreach ( $files['app_files'] as $filename => $file )
			{
				// read file content
				$content = $this->read_file_socket($provider, $filename);

				// analyse content
				switch ( $file['app_protocol'] )
				{
					case 'phpbb':
						$this->process_phpBB($provider, $filename, $content);
						break;

					case 'native':
						$this->process_native($provider, $filename, $content);
						break;

					case 'xml':
						break;
				}
			}
		}
		$config->set('version_check_delay', time(), true);
	}

	function read_file_socket($provider, $filename)
	{
		$res = '';
		$this->files[$provider]['app_files'][$filename]['error'] = $this->files[$provider]['app_files'][$filename]['error_msg'] = '';
		if ( $fsock = @fsockopen($this->files[$provider]['app_files'][$filename]['app_server'], 80, $this->files[$provider]['app_files'][$filename]['error'], $this->files[$provider]['app_files'][$filename]['error_msg'], 10) )
		{
			$lf = "\r\n";
			@fputs($fsock, 'GET ' . substr($filename, strlen($this->files[$provider]['app_files'][$filename]['app_server'])) . ' HTTP/1.1' . $lf);
			@fputs($fsock, 'HOST: ' . $this->files[$provider]['app_files'][$filename]['app_server'] . $lf);
			@fputs($fsock, 'Connection: close' . $lf . $lf);

			$get_info = false;
			while ( !@feof($fsock) )
			{
				if ( $get_info || (($get_info = @fgets($fsock, 1024) == $lf) && !@feof($fsock)) )
				{
					$res .= @fread($fsock, 1024);
				}
			}
		}
		@fclose($fsock);
		return trim($res);
	}

	function process_phpBB($provider, $filename, $content)
	{
		if ( empty($content) )
		{
			return;
		}
		$content = explode("\n", $content);
		$count_content = count($content);
		for ( $i = 0; $i < $count_content; $i++ )
		{
			$content[$i] = intval(trim(preg_replace("/[\r\n]/", '', $content[$i])));
		}
		$app_name = 'phpBB';
		$app_id = $this->search_id($app_name, $this->files[$provider]['app_files'][$filename]['app_ids']);
		$this->data[$app_id]['app_stable'] = implode('.', array_slice($content, 0, 3));
	}

	function process_native($provider, $filename, $content)
	{
		if ( empty($content) )
		{
			return;
		}
		$content = explode("\n", $content);
		$count_content = count($content);
		$app_ids = $this->files[$provider]['app_files'][$filename]['app_ids'];
		for ( $i = 0; $i < $count_content; $i++ )
		{
			if ( !empty($app_ids) )
			{
				$str = trim(preg_replace("/[\r\n]/", '', $content[$i]));
				$line = empty($str) ? array() : explode(':', $str);
				$app_name = trim($line[0]);
				$versions = trim($line[1]);
				if ( empty($app_name) || empty($versions) )
				{
					continue;
				}
				if ( $app_id = $this->search_id($app_name, $app_ids) )
				{
					$versions = explode(',', $versions);
					$this->data[$app_id]['app_stable'] = trim($versions[0]);
					if ( isset($versions[1]) )
					{
						$this->data[$app_id]['app_dev'] = trim($versions[1]);
					}
				}
			}
		}
	}

	function search_id($app_name, $app_ids)
	{
		$count_app_ids = count($app_ids);
		$app_name = strtolower($app_name);
		for ( $i = 0; $i < $count_app_ids; $i++ )
		{
			if ( !empty($app_ids[$i]) && (strtolower($this->data[ $app_ids[$i] ]['app_name']) == $app_name) )
			{
				return $app_ids[$i];
			}
		}
		return false;
	}

	function display($tpl_var='')
	{
		global $template, $user, $config;

		// check which author and files are concerned with an installed version
		$installed = array();
		$refreshed = false;
		$in_dev = false;
		if ( !empty($this->data) )
		{
			foreach ( $this->data as $app_id => $data )
			{
				if ( !empty($data['app_installed']) )
				{
					if ( !isset($installed[ $data['app_author'] ]) )
					{
						$installed[ $data['app_author'] ] = array($data['app_server'] . $data['app_file'] => true);
					}
					else
					{
						$installed[ $data['app_author'] ][ $data['app_server'] . $data['app_file'] ] = true;
					}
					$refreshed |= !empty($data['app_stable']);
					$in_dev |= !empty($data['app_dev']);
				}
			}
		}

		$something = false;
		foreach( $this->files as $provider => $files )
		{
			if ( isset($installed[$provider]) )
			{
				$something = true;

				// process author
				$template->assign_block_vars('author', array(
					'AUTHOR' => $provider,
					'U_AUTHOR' => $files['app_author_url'],
				));
				$template->set_switch('author.link', !empty($files['app_author_url']));
				$template->set_switch('author.refreshed', $refreshed);
				$template->set_switch('author.in_dev', $in_dev);

				// process files
				foreach ( $files['app_files'] as $filename => $file )
				{
					if ( isset($installed[$provider][$filename]) )
					{
						$template->assign_block_vars('author.file', array(
							'ERROR_MSG' => sprintf($user->lang('App_socket_error'), $file['error_msg']),
						));
						$template->set_switch('author.file.error', $file['error']);
						if ( $file['error'] )
						{
							$template->set_switch('author.file.error.refreshed', $refreshed);
							$template->set_switch('author.file.error.in_dev', $in_dev);
						}
						if ( !$file['error'] )
						{
							$count_app_ids = count($file['app_ids']);
							for ( $i = 0; $i < $count_app_ids; $i++ )
							{
								$app_id = $file['app_ids'][$i];
								if ( !empty($this->data[$app_id]['app_installed']) )
								{
									$template->assign_block_vars('author.file.app', array(
										'NAME' => $this->data[$app_id]['app_name'],
										'DESC' => $user->lang($this->data[$app_id]['app_desc']),
										'U_SITE' => $this->data[$app_id]['app_page'],
										'CURRENT' => $this->data[$app_id]['app_installed'],
										'STABLE' => $this->data[$app_id]['app_stable'],
										'IN_DEV' => $this->data[$app_id]['app_dev'],
										'INFO' => $user->lang($this->data[$app_id]['app_info']),
									));
									$template->set_switch('author.file.app.desc', !empty($this->data[$app_id]['app_desc']));
									$template->set_switch('author.file.app.page', !empty($this->data[$app_id]['app_page']));
									$template->set_switch('author.file.app.info', !empty($this->data[$app_id]['app_info']));
									$template->set_switch('author.file.app.refreshed', $refreshed && !empty($this->data[$app_id]['app_stable']));
									$template->set_switch('author.file.app.in_dev', $in_dev && !empty($this->data[$app_id]['app_dev']));

									$status = 'unknown';
									if ( $refreshed )
									{
										$status = '';
										if ( $this->data[$app_id]['app_installed'] == $this->data[$app_id]['app_stable'] )
										{
											$status = 'stable';
										}
										if ( $in_dev && ($this->data[$app_id]['app_installed'] == $this->data[$app_id]['app_dev']) )
										{
											$status = 'dev';
										}
										if ( $refreshed && ($this->data[$app_id]['app_installed'] != $this->data[$app_id]['app_stable']) && !$this->greater($this->data[$app_id]['app_installed'], $this->data[$app_id]['app_stable']) && (!$in_dev || ($this->data[$app_id]['app_installed'] != $this->data[$app_id]['app_dev'])) )
										{
											$status = 'obsolete';
										}
										if ( empty($status) )
										{
											$status = 'undefined';
										}
									}
									$template->set_switch('author.file.app.unknown', $status == 'unknown');
									$template->set_switch('author.file.app.stable', $status == 'stable');
									$template->set_switch('author.file.app.obsolet', $status == 'obsolete');
									$template->set_switch('author.file.app.dev', $status == 'dev');
									$template->set_switch('author.file.app.undefined', $status == 'undefined');
									if ( $refreshed && !empty($this->data[$app_id]['app_stable']) )
									{
										$template->set_switch('author.file.app.refreshed.stable', $status == 'stable');
										$template->set_switch('author.file.app.refreshed.obsolet', $status == 'obsolete');
									}
									if ( $in_dev && !empty($this->data[$app_id]['app_dev']) )
									{
										$template->set_switch('author.file.app.in_dev.dev', $status == 'dev');
										$template->set_switch('author.file.app.in_dev.undefined', $status == 'undefined');
									}
								}
							}
						}
					}
				}
			}
		}

		// constants
		$template->assign_vars(array(
			'L_AUTHOR' => $user->lang('App_author'),
			'L_NAME' => $user->lang('App_name'),
			'L_DESC' => $user->lang('App_desc'),
			'L_SITE' => $user->lang('App_site'),
			'L_CURRENT_VERSION' => $user->lang('App_current'),
			'L_STABLE_VERSION' => $user->lang('App_stable'),
			'L_IN_DEV_VERSION' => $user->lang('App_in_dev'),

			'L_STATUS' => $user->lang('App_status'),
			'I_STABLE' => $user->img('app_stable'),
			'L_STABLE' => $user->lang('App_stable_status'),
			'I_IN_DEV' => $user->img('app_in_dev'),
			'L_IN_DEV' => $user->lang('App_in_dev_status'),
			'I_UNKNOWN' => $user->img('app_unknown'),
			'L_UNKNOWN' => $user->lang('App_unknown_status'),
			'I_OBSOLET' => $user->img('app_obsolet'),
			'L_OBSOLET' => $user->lang('App_obsolet_status'),
			'I_UNDEFINED' => $user->img('app_undefined'),
			'L_UNDEFINED' => $user->lang('App_undefined_status'),

			'L_VERSION_INFORMATION' => $user->lang('Version_information'),
			'I_CHECK' => $user->img('cmd_check'),
			'L_CHECK' => $user->lang('App_check'),
			'U_CHECK' => $config->url($this->requester, $this->parms + array('vchk' => true), true),
		));
		$template->assign_vars(array($tpl_var => $template->include_file('admin/versions_box.tpl')));
	}

	function greater($first, $second)
	{
		if ( strlen($first) > strlen($second) )
		{
			$first = substr($first, 0, strlen($second));
			$gt = $first == $second;
		}
		else if ( strlen($first) < strlen($second) )
		{
			$second = substr($second, 0, strlen($first));
			$gt = $first != $second;
		}
		return $first == $second ? $gt : $first > $second;
	}
}

?>