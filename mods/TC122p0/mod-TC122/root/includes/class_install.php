<?php
/***************************************************************************
 *							class_install.php
 *							-----------------
 *	begin		: 06/08/2005
 *	copyright	: Ptirhiik
 *	email		: ptirhiik@clanmckeen.com
 *
 *	Version		: 0.0.5 - 29/01/2006
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

// lang keys used in this class
$sys_lang = array(
	'SQL_error' => '<b><u>SQL request not achieved:</u></b><ul><li><b>reason:</b> %s<li><b>file:</b> %s, <b>line:</b> %s<li><b>request:</b><hr /> %s<hr /></ul>',
	'Login_required' => 'You must log in',
	'Login_title' => 'Login',
	'Login_failed' => 'Login failed. Check the username and the password you\'ve typed in, then retry.',
	'Login_username' => 'Username',
	'Login_password' => 'Password',
	'Login_submit' => 'Log me in',
	'Login_admin' => 'You must be an administrator to go further.',
	'Login_mod' => 'You must be an administrator or a moderator to go further.',
	'Error_resume_explain' => 'These are warnings only : press "Resume" to continue :',
	'Error_resume' => 'Resume',
);

// install the new db class
$original_db = $db;
$db = new light_db();

// page management
class page
{
	var $requester;
	var $parms;
	var $messages;
	var $error_msg;
	var $title;
	var $sub_title;

	var $root;
	var $ext;
	var $header_sent;

	function page($requester, $title='', $lang_file='')
	{
		global $phpbb_root_path, $phpEx;

		$this->requester = $requester;
		$this->parms = array();
		$this->root = $phpbb_root_path;
		$this->ext = $phpEx;
		$this->messages = array();
		$this->error_msg = array();
		$this->header_sent = false;
		$this->guess_lang($lang_file);
		$this->title = empty($title) ? 'Script_title' : $title;
		$this->sub_title = '';
	}

	function set_parms($parms)
	{
		$this->parms = empty($this->parms) ? $parms : array_merge($this->parms, $parms);
	}

	function unset_parms($parms)
	{
		if ( empty($parms) )
		{
			return;
		}
		if ( !is_array($parms) )
		{
			$parms = array($parms);
		}
		if ( empty($this->parms) )
		{
			return;
		}
		$count_parms = count($parms);
		for ( $i = 0; $i < $count_parms; $i++ )
		{
			if ( isset($this->parms[ $parms[$i] ]) )
			{
				unset($this->parms[ $parms[$i] ]);
			}
		}
	}

	// this one comes from phpBB install.php
	function guess_lang($lang_file)
	{
		global $HTTP_SERVER_VARS, $lang;

		// The order here _is_ important, at least for major_minor
		// matches. Don't go moving these around without checking with
		// me first - psoTFX
		$match_lang = array(
			'arabic'					=> 'ar([_-][a-z]+)?',
			'bulgarian'					=> 'bg',
			'catalan'					=> 'ca',
			'czech'						=> 'cs',
			'danish'					=> 'da',
			'german'					=> 'de([_-][a-z]+)?',
			'english'					=> 'en([_-][a-z]+)?',
			'estonian'					=> 'et',
			'finnish'					=> 'fi',
			'french'					=> 'fr([_-][a-z]+)?',
			'greek'						=> 'el',
			'spanish_argentina'			=> 'es[_-]ar',
			'spanish'					=> 'es([_-][a-z]+)?',
			'gaelic'					=> 'gd',
			'galego'					=> 'gl',
			'gujarati'					=> 'gu',
			'hebrew'					=> 'he',
			'hindi'						=> 'hi',
			'croatian'					=> 'hr',
			'hungarian'					=> 'hu',
			'icelandic'					=> 'is',
			'indonesian'				=> 'id([_-][a-z]+)?',
			'italian'					=> 'it([_-][a-z]+)?',
			'japanese'					=> 'ja([_-][a-z]+)?',
			'korean'					=> 'ko([_-][a-z]+)?',
			'latvian'					=> 'lv',
			'lithuanian'				=> 'lt',
			'macedonian'				=> 'mk',
			'dutch'						=> 'nl([_-][a-z]+)?',
			'norwegian'					=> 'no',
			'punjabi'					=> 'pa',
			'polish'					=> 'pl',
			'portuguese_brazil'			=> 'pt[_-]br',
			'portuguese'				=> 'pt([_-][a-z]+)?',
			'romanian'					=> 'ro([_-][a-z]+)?',
			'russian'					=> 'ru([_-][a-z]+)?',
			'slovenian'					=> 'sl([_-][a-z]+)?',
			'albanian'					=> 'sq',
			'serbian'					=> 'sr([_-][a-z]+)?',
			'slovak'					=> 'sv([_-][a-z]+)?',
			'swedish'					=> 'sv([_-][a-z]+)?',
			'thai'						=> 'th([_-][a-z]+)?',
			'turkish'					=> 'tr([_-][a-z]+)?',
			'ukranian'					=> 'uk([_-][a-z]+)?',
			'urdu'						=> 'ur',
			'viatnamese'				=> 'vi',
			'chinese_traditional_taiwan'=> 'zh[_-]tw',
			'chinese_simplified'		=> 'zh',
		);
		if ( empty($lang_file) )
		{
			$lang_file = 'lang_CH_install';
		}
		$lang_file = $this->root . 'language/lang_%s/' . $lang_file . '.' . $this->ext;

		$file = sprintf($lang_file, 'english');
		if ( @file_exists(@phpbb_realpath($file)) )
		{
			include($file);
		}
		if ( isset($HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE']) )
		{
			$accepted_langs = explode(',', $HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE']);
			$count_accepted_langs = count($accepted_langs);
			for ( $i = 0; $i < $count_accepted_langs; $i++ )
			{
				foreach ( $match_lang as $lang_available => $match )
				{
					if ( ($lang_available != 'english') && preg_match('#' . $match . '#i', trim($accepted_langs[$i])) )
					{
						$file = sprintf($lang_file, trim($lang_available));
						if ( @file_exists(@phpbb_realpath($file)) )
						{
							include($file);
							return;
						}
					}
				}
			}
		}

		return;
	}

	function lang($key)
	{
		global $lang, $sys_lang;
		return empty($key) ? '' : (isset($lang[$key]) ? $lang[$key] : (isset($sys_lang[$key]) ? $sys_lang[$key] : $key));
	}

	function url($parms='', $script='')
	{
		if ( empty($script) )
		{
			$script = $this->requester;
		}
		$url_parms = '';
		if ( !empty($parms) )
		{
			foreach ( $parms as $parm => $value )
			{
				if ( !empty($value) )
				{
					$url_parms .= (empty($url_parms) ? '?' : '&amp;') . $parm . '=' . $value;
				}
			}
		}
		return $this->root . $script . '.' . $this->ext . $url_parms;
	}

	function error($msg='')
	{
		if ( empty($msg) )
		{
			return !empty($this->error_msg);
		}
		$this->error_msg[] = $this->lang($msg);
		return true;
	}

	function critical_error($msg='')
	{
		$this->error_msg[] = $this->lang($msg);
		$this->header();
		$this->footer();
	}

	function output($msg='')
	{
		if ( empty($msg) )
		{
			return !empty($this->messages);
		}
		$this->messages[] = $this->lang($msg);
		return true;
	}

	function header($meta='')
	{
		if ( $this->header_sent )
		{
			return;
		}
		$this->header_sent = true;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css"><?php echo $meta; ?>
<title><?php echo $this->lang($this->title); ?></title>
<style type="text/css">
<!--
font,th,td,p {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}
th {font-size: 11px; font-weight : bold; color: #FFA34F; background-color: #0000A0;}
hr {height: 0px; border: solid #D1D7DC 0px; border-top-width: 1px;}
.gen {font-size: 12px}
.gensmall {font-size: 11px}
.background {background-color: #FFFFFF; border: 1px #98AAB1 solid;}
.row1 {background-color: #F0F0FE;}
.row2 {background-color: #E0E0F0;}
//-->
</style>
</head>
<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">
<table cellpadding="10" cellspacing="1" border="0" class="background" width="100%" style="height: 100%"><tr><td valign="top">
<div align="center" class="background"><br /><br /><h1><u><b><?php echo $this->lang($this->title); ?></b></u></h1><?php if ( !empty($this->sub_title) ) {echo $this->lang($this->sub_title);} ?><br /><br /></div>
<div align="justify" class="gen"><br /><br />
<?php
	}

	function send_messages()
	{
		// send error messages if any
		if ( $count_error_msg = count($this->error_msg) )
		{
?><div class="background" style="width: 100%;"><div class="row1" align="center"><br /><br />
<?php
			for ( $i = 0; $i < $count_error_msg; $i++ )
			{
				echo $this->error_msg[$i] . '<br />';
			}
?><br /><br /></div></div><br /><br />
<?php
			$this->error_msg = array();
		}

		// send other messages if any
		if ( $count_messages = count($this->messages) )
		{
?><div class="background" style="width: 100%;"><br /><?php
			for ( $i = 0; $i < $count_messages; $i++ )
			{
				echo $this->messages[$i] . '<br />';
			}
?><br /></div><?php
			$this->messages = array();
		}
	}

	function hide()
	{
		if ( !empty($this->parms) )
		{
			foreach ( $this->parms as $parm => $value )
			{
				if ( !empty($value) )
				{
?><input type="hidden" name="<?php echo $parm; ?>" value="<?php echo str_replace('"', '&quot;', $value); ?>" /><?php
				}
			}
		}
	}

	function footer()
	{
		// send header if not done
		if ( !$this->header_sent )
		{
			$this->header();
		}

		// send messages if any
		$this->send_messages();

		// close db
		if ( !empty($db) && is_object($db) )
		{
			$db->sql_close();
		}

		// send footer
?>
</div><br /><hr />
<div align="center" class="gensmall"><a href="http://www.phpbb.com/" target="phpbb" class="gensmall">phpBB</a> &copy; 2001,2002 phpBB Group</div>
</td></tr></table>
</body>
</html>
<?php
		// stop
		exit;
	}

	function loop($parms='', $no_wait=true)
	{
		$parms = empty($parms) ? $this->parms : array_merge($this->parms, $parms);
		if ( $this->error() )
		{
			$this->set_parms($parms);
			$this->resume_form();
		}
		$meta = '<meta http-equiv="refresh" content="' . ($no_wait ? 0 : 3) . ';url=' . $this->url($parms) . '">';
		$this->header($meta);
		$this->footer();
	}

	function _button($var)
	{
		global $HTTP_POST_VARS, $HTTP_GET_VARS;
		return (isset($HTTP_POST_VARS[$var]) && !empty($HTTP_POST_VARS[$var])) || (isset($HTTP_GETT_VARS[$var]) && intval($HTTP_GET_VARS[$var]));
	}

	function resume_form()
	{
		if ( ($count_error_msg = count($this->error_msg)) && !$this->_button('resume') )
		{
			$this->header();
?><form name="post" method="post" action="<?php echo $this->url(); ?>"><div class="background" style="width: 100%;"><div class="row1" align="center"><br /><br />
<?php
			for ( $i = 0; $i < $count_error_msg; $i++ )
			{
				echo $this->error_msg[$i] . '<br />';
			}
?><br /><hr /><?php echo $this->lang('Error_resume_explain') ?>&nbsp;<input type="submit" name="resume" value="<?php echo $this->lang('Error_resume') ?>" /><?php $this->hide() ?><br /><br /></div></div><br /><br /></form>
<?php
			$this->error_msg = array();

			// other mesages
			$this->send_messages();
			$this->footer();
		}
	}
}

// sample from class_db
class light_db
{
	var $sql_fields;
	var $sql_values;
	var $sql_update;
	var $sql_version;
	var $sql_stack_fields;
	var $sql_stack_values;

	function sql_close()
	{
		global $original_db;
		return $original_db->sql_close($id);
	}
	function sql_query($query='', $transaction=false, $line='', $file='', $break_on_error=true)
	{
		global $original_db;

		$query_res = $original_db->sql_query($query, $transaction);
		if ( !$query_res && $break_on_error )
		{
			if ( empty($file) && function_exists('debug_backtrace') )
			{
				$dbg = debug_backtrace();
				$file = $dbg[0]['file'];
				$line = $dbg[0]['line'];
				unset($dbg);
			}
			else
			{
				$file = basename(__FILE__);
			}
			$this->error($line, $file, $query);
		}
		return $query_res;
	}
	function sql_numrows($id=0)
	{
		global $original_db;
		return $original_db->sql_numrows($id);
	}
	function sql_affectedrows()
	{
		global $original_db;
		return $original_db->sql_affectedrows();
	}
	function sql_numfields($id=0)
	{
		global $original_db;
		return $original_db->sql_numfields($id);
	}
	function sql_fieldname($offset, $id=0)
	{
		global $original_db;
		return $original_db->sql_fieldname($offset, $id);
	}
	function sql_fieldtype($offset, $id=0)
	{
		global $original_db;
		return $original_db->sql_fieldtype($offset, $id);
	}
	function sql_fetchrow($id=0)
	{
		global $original_db;
		return $original_db->sql_fetchrow($id);
	}
	function sql_fetchrowset($id=0)
	{
		global $original_db;
		return $original_db->sql_fetchrowset($id);
	}
	function sql_fetchfield($field, $rownum=-1, $id=0)
	{
		global $original_db;
		return $original_db->sql_fetchfield($field, $rownum, $id);
	}
	function sql_rowseek($rownum, $id=0)
	{
		global $original_db;
		return $original_db->sql_rowseek($rownum, $id);
	}
	function sql_nextid()
	{
		global $original_db;
		return $original_db->sql_nextid();
	}
	function sql_freeresult($id=0)
	{
		global $original_db;
		return $original_db->sql_freeresult($id);
	}

	// additional
	function error($line, $file, $query)
	{
		global $page, $lang;

		$sql_error = $this->sql_error();
		$page->critical_error(sprintf($lang['SQL_error'], empty($sql_error['message']) ? '' : $sql_error['code'] . ' - ' . $sql_error['message'], $file, $line, htmlspecialchars(preg_replace('/[\n\r\s\t]+/', ' ', $query))));
	}

	function sql_escape_string($str)
	{
		return str_replace(array('\\\'', '\\"'), array('\'\'', '"'), addslashes($str));
	}

	function sql_type_cast(&$value)
	{
		if ( is_float($value) )
		{
			return doubleval($value);
		}
		if ( is_integer($value) || is_bool($value) )
		{
			return intval($value);
		}
		if ( is_string($value) || empty($value) )
		{
			return '\'' . $this->sql_escape_string($value) . '\'';
		}
		// uncastable var : let's do a basic protection on it to prevent sql injection attempt
		return '\'' . $this->sql_escape_string(htmlspecialchars($value)) . '\'';
	}

	function sql_statement(&$fields)
	{
		global $original_db;

		// init result
		$this->sql_fields = $this->sql_values = $this->sql_update = '';
		if ( empty($fields) )
		{
			return;
		}

		// process
		$first = true;
		foreach ( $fields as $field => $value )
		{
			// field must contain a field name
			if ( !empty($field) && is_string($field) )
			{
				$value = $this->sql_type_cast($value);
				$this->sql_fields .= ( $first ? '' : ', ' ) . $field;
				$this->sql_values .= ( $first ? '' : ', ' ) . $value;
				$this->sql_update .= ( $first ? '' : ', ' ) . $field . ' = ' . $value;
				$first = false;
			}
		}
	}

	function sql_stack_reset($id='')
	{
		if ( empty($id) )
		{
			$this->sql_stack_fields = array();
			$this->sql_stack_values = array();
		}
		else
		{
			$this->sql_stack_fields[$id] = array();
			$this->sql_stack_values[$id] = array();
		}
	}

	function sql_stack_statement(&$fields, $id='')
	{
		$this->sql_statement($fields);
		if ( empty($id) )
		{
			$this->sql_stack_fields = $this->sql_fields;
			$this->sql_stack_values[] = '(' . $this->sql_values . ')';
		}
		else
		{
			$this->sql_stack_fields[$id] = $this->sql_fields;
			$this->sql_stack_values[$id][] = '(' . $this->sql_values . ')';
		}
	}

	function sql_stack_insert($table, $transaction=false, $line='', $file='', $break_on_error=true, $id='')
	{
		if ( (empty($id) && empty($this->sql_stack_values)) || (!empty($id) && empty($this->sql_stack_values[$id])) )
		{
			return false;
		}
		switch( SQL_LAYER )
		{
			case 'mysql':
			case 'mysql4':
				if ( empty($id) )
				{
					$sql = 'INSERT INTO ' . $table . '
								(' . $this->sql_stack_fields . ') VALUES ' . implode(",\n", $this->sql_stack_values);
				}
				else
				{
					$sql = 'INSERT INTO ' . $table . '
								(' . $this->sql_stack_fields[$id] . ') VALUES ' . implode(",\n", $this->sql_stack_values[$id]);
				}
				$this->sql_stack_reset($id);
				return $this->sql_query($sql, $transaction, $line, $file, $break_on_error);
				break;
			default:
				$count_sql_stack_values = empty($id) ? count($this->sql_stack_values) : count($this->sql_stack_values[$id]);
				$result = !empty($count_sql_stack_values);
				for ( $i = 0; $i < $count_sql_stack_values; $i++ )
				{
					if ( empty($id) )
					{
						$sql = 'INSERT INTO ' . $table . '
									(' . $this->sql_stack_fields . ') VALUES ' . $this->sql_stack_values[$i];
					}
					else
					{
						$sql = 'INSERT INTO ' . $table . '
									(' . $this->sql_stack_fields[$id] . ') VALUES ' . $this->sql_stack_values[$id][$i];
					}
					$result &= $this->sql_query($sql, $transaction, $line, $file, $break_on_error);
				}
				$this->sql_stack_reset($id);
				return $result;
				break;
		}
	}

	function sql_subquery($field, $sql, $line='', $file='', $break_on_error=true, $type=TYPE_INT)
	{
		// sub-queries doable
		$this->sql_get_version();
		if ( !in_array(SQL_LAYER, array('mysql', 'mysql4')) || (($this->sql_version[0] + ($this->sql_version[1] / 100)) >= 4.01) )
		{
			return $sql;
		}

		// no sub-queries
		$ids = array();
		$result = $this->sql_query(trim($sql), false, $line, $file, $break_on_error);
		while ( $row = $this->sql_fetchrow($result) )
		{
			$ids[] = $type == TYPE_INT ? intval($row[$field]) : '\'' . $this->sql_escape_string($row[$field]) . '\'';
		}
		$this->sql_freeresult($result);
		return empty($ids) ? 'NULL' : implode(', ', $ids);
	}

	function sql_get_version()
	{
		if ( empty($this->sql_version) )
		{
			$this->sql_version = array(0, 0, 0);
			switch ( SQL_LAYER )
			{
				case 'mysql':
				case 'mysql4':
					if ( function_exists('mysql_get_server_info') )
					{
						$lo_version = explode('-', mysql_get_server_info());
						$this->sql_version = explode('.', $lo_version[0]);
						$this->sql_version = array(intval($this->sql_version[0]), intval($this->sql_version[1]), intval($this->sql_version[2]), $lo_version[1]);
					}
					break;

				case 'postgresql':
				case 'mssql':
				case 'mssql-odbc':
				default:
					break;
			}
		}
		return $this->sql_version;
	}

	function sql_error()
	{
		global $original_db;

		if ( $original_db->db_connect_id )
		{
			return $original_db->sql_error();
		}
		else
		{
			return array();
		}
	}

	function get_layer()
	{
		// Define schemes info
		$available_dbms = array(
			'mysql'=> array(
				'LABEL'			=> 'MySQL 3.x',
				'SCHEMA'		=> 'mysql',
				'DELIM'			=> ';',
				'DELIM_BASIC'	=> ';',
				'COMMENTS'		=> 'remove_remarks',
			),
			'mysql4' => array(
				'LABEL'			=> 'MySQL 4.x',
				'SCHEMA'		=> 'mysql',
				'DELIM'			=> ';',
				'DELIM_BASIC'	=> ';',
				'COMMENTS'		=> 'remove_remarks',
			),
			'postgresql' => array(
				'LABEL'			=> 'PostgreSQL 7.x',
				'SCHEMA'		=> 'postgres',
				'DELIM'			=> ';',
				'DELIM_BASIC'	=> ';',
				'COMMENTS'		=> 'remove_comments',
			),
			'mssql' => array(
				'LABEL'			=> 'MS SQL Server 7/2000',
				'SCHEMA'		=> 'mssql',
				'DELIM'			=> 'GO',
				'DELIM_BASIC'	=> ';',
				'COMMENTS'		=> 'remove_comments',
			),
			'mssql-odbc' =>	array(
				'LABEL'			=> 'MS SQL Server [ ODBC ]',
				'SCHEMA'		=> 'mssql',
				'DELIM'			=> 'GO',
				'DELIM_BASIC'	=> ';',
				'COMMENTS'		=> 'remove_comments',
			),
		);
		return isset($available_dbms[SQL_LAYER]) ? $available_dbms[SQL_LAYER] : false;
	}
}

class light_session
{
	var $session_max_length;
	var $session_id;
	var $session_ip;
	var $session_logged_in;
	var $user_id;
	var $user_level;

	function light_session()
	{
		$this->session_id = $this->get_id();
		$this->session_ip = $this->get_ip();
		$this->session_logged_in = false;
		$this->user_id = ANONYMOUS;
		$this->user_level = USER;
	}

	function get_id()
	{
		global $HTTP_POST_VARS, $HTTP_GET_VARS;

		$session_id = '';
		if ( isset($HTTP_POST_VARS['sid']) || isset($HTTP_GET_VARS['sid']) )
		{
			$session_id = htmlspecialchars(trim(isset($HTTP_POST_VARS['sid']) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid']));
		}
		if ( empty($session_id) || !preg_match('/^[A-Za-z0-9]*$/', $session_id) )
		{
			list($sec, $usec) = explode(' ', microtime());
			mt_srand((float) $sec + ((float) $usec * 100000));
			$session_id = md5(uniqid(mt_rand(), true));
		}
		return $session_id;
	}

	function get_ip()
	{
		global $HTTP_SERVER_VARS, $HTTP_ENV_VARS;
		$ip = explode('.', !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR')));
		return sprintf('%02x%02x%02x%02x', intval($ip[0]), intval($ip[1]), intval($ip[2]), intval($ip[3]));
	}

	function log_out()
	{
		global $page, $db;
		if ( empty($this->session_id) )
		{
			return;
		}
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
					WHERE session_id = \'' . $this->session_id . '\'';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$this->session_id = '';
		$this->session_logged_in = false;
		$this->user_id = ANONYMOUS;
		$this->user_level = USER;
		$page->unset_parms('sid');
	}

	function log_in($level=USER)
	{
		$this->init();
		$this->check($level);
		$this->validate();
		$this->display();
	}

	function init()
	{
		global $db, $page;

		$this->session_logged_in = false;
		$session_max_length = 600; // 10 minutes

		// do not use a previous session while validating a login
		if ( $page->_button('logme') )
		{
			return $this->session_logged_in;
		}

		// read session from table
		$sql = 'SELECT s.session_id, s.session_ip, s.session_time, u.user_id, u.user_level
					FROM ' . SESSIONS_TABLE . ' s
						LEFT JOIN ' . USERS_TABLE . ' u
							ON u.user_id = s.session_user_id
					WHERE session_id = \'' . $this->session_id . '\'';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		if ( $row = $db->sql_fetchrow($result) )
		{
			// check session ip with current ip
			$ip_stored = substr($row['session_ip'], 0, 6);
			$ip_current = substr($this->session_ip, 0, 6);
			if ( $ip_stored == $ip_current )
			{
				// the ips match : does the session lenght ok ?
				if ( (time() - intval($row['session_time'])) < $session_max_length )
				{
					// does the user exists
					if ( !empty($row['user_id']) )
					{
						$this->user_id = intval($row['user_id']);
						$this->user_level = intval($row['user_level']);

						// this session is ok : update the session table
						$fields = array(
							'session_ip' => $this->session_ip,
							'session_time' => time(),
						);
						$db->sql_statement($fields);
						$sql = 'UPDATE ' . SESSIONS_TABLE . '
									SET ' . $db->sql_update . '
									WHERE session_id = \'' . $this->session_id . '\'';
						$db->sql_query($sql, false, __LINE__, __FILE__);
						$this->session_logged_in = true;
					}
				}
			}
		}
		return $this->session_logged_in;
	}

	function check($level=USER)
	{
		global $page, $db;
		global $HTTP_POST_VARS;

		if ( $this->session_logged_in || !$page->_button('submit') )
		{
			return;
		}
		$username = isset($HTTP_POST_VARS['username']) ? trim(stripslashes(phpbb_clean_username($HTTP_POST_VARS['username']))) : '';
		$password = isset($HTTP_POST_VARS['password']) ? md5($HTTP_POST_VARS['password']) : '';
		if ( empty($username) || empty($password) )
		{
			$page->error('Login_required');
		}
		else
		{
			// search the user
			$sql = 'SELECT user_id, user_password, user_level, user_active
						FROM ' . USERS_TABLE . '
						WHERE LOWER(username) = \'' . $db->sql_escape_string(strtolower($username)) . '\'';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( !($row = $db->sql_fetchrow($result)) || !$row['user_active'] || ($row['user_id'] == ANONYMOUS) || ($password != $row['user_password']) )
			{
				$page->error('Login_failed');
			}
			else if ( (($level == ADMIN) && (intval($row['user_level']) != ADMIN)) || (($level == MOD) && !in_array(intval($row['user_level']), array(MOD, ADMIN))) )
			{
				$page->error($level == ADMIN ? 'Login_admin' : 'Login_mod');
			}
			else
			{
				$this->user_id = intval($row['user_id']);
				$this->user_level = intval($row['user_level']);
			}
			$db->sql_freeresult($result);
		}
	}

	function validate()
	{
		global $page, $db;

		if ( $this->session_logged_in )
		{
			$page->set_parms(array('sid' => $this->session_id));
			return $this->session_logged_in;
		}
		else if ( !$page->_button('submit') || $page->error() )
		{
			return $this->session_logged_in;
		}

		// delete outdated session
		$sql = 'DELETE FROM ' . SESSIONS_TABLE . '
					WHERE session_user_id = ' . $this->user_id;
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// create the session row
		$fields = array(
			'session_id' => $this->session_id,
			'session_ip' => $this->session_ip,
			'session_user_id' => $this->user_id,
			'session_start' => time(),
			'session_time' => time(),
		);
		$db->sql_statement($fields);
		$sql = 'INSERT INTO ' . SESSIONS_TABLE . '
					(' . $db->sql_fields . ') VALUES(' . $db->sql_values . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$this->session_logged_in = true;
		$page->set_parms(array('sid' => $this->session_id));
		return $this->session_logged_in;
	}

	function display()
	{
		global $page;

		if ( $this->session_logged_in )
		{
			return;
		}

		$page->header();
		$page->send_messages();
?><form name="post" method="post" action="<?php echo str_replace('"', '&quot;', $page->url($parms)); ?>"><div align="center"><div class="background" style="width: 50%;"><table cellpadding="4" cellspacing="1" border="0" width="100%">
<tr><th colspan="2"><?php echo $page->lang('Login_title'); ?></th></tr>
<tr><td width="40%" class="row1"><b><?php echo $page->lang('Login_username'); ?>:</b></td><td class="row2"><input type="text" name="username" value="" size="25" /></td></tr>
<tr><td class="row1"><b><?php echo $page->lang('Login_password'); ?>:</b></td><td class="row2"><input type="password" name="password" value="" size="40" /></td></tr>
<tr><td class="row2" colspan="2" align="center"><input type="submit" name="submit" value="<?php echo str_replace('"', '&quot;', $page->lang('Login_submit')); ?>" /><input type="hidden" name="logme" value="1" /><?php $page->hide(); ?></td></tr>
</table></div></div></form>
<?php
		$page->footer();
	}
}

?>