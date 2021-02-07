<?php
/***************************************************************************
 *							install.php
 *							-----------
 *	begin		: 26/04/2006
 *	copyright	: Ptirhiik
 *	email		: ptirhiik@clanmckeen.com
 *
 *	Version		: 0.0.1 - 26/04/2006
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
define('IN_INSTALL', true);

$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'install_cal/install';

include($phpbb_root_path . 'common.'.$phpEx);
include($config->url('includes/sql_parse'));
include($config->url('includes/class_install'));

// constants
define('ROWS_A_TURN', 500);

// steps
$steps = array(
//-- new install & upgrades
	'TC_welcome',
	'TC_previous_version',
	'TC_dbstruct',
	'TC_upg_data',
	'TC_config',

//-- new install
	'TC_users',

//-- end of process
	'TC_resume',
	'TC_end',
);

// parms (not set is : type => TYPE_INT, default => 0)
$parms_def = array(
	'step' => array('type' => 'str', 'list' => &$steps),
	'tcpv' => array('type' => 'str', 'default' => ''),
	'dbs' => '',
	'dbd' => '',
	'ccfg' => '',

	'fus' => '',
);

// tpls
function welcome_form()
{
	global $page;
?><form name="post" method="post" action="<?php echo $page->url(); ?>"><br /><br /><div align="center"><table cellpadding="4" cellspacing="1" border="0" width="80%" class="background">
<tr><th><?php echo sprintf($page->lang('TC_welcome'), TC_CURRENT_VERSION); ?></th></tr>
<tr><td align="justify" class="row1"><?php echo sprintf($page->lang('TC_welcome_explain'), TC_CURRENT_VERSION); ?><br /><br /><br /></td></tr>
<tr><td align="center" class="row2"><?php echo $page->lang('Start'); ?>: <input name="submit" type="submit" value="<?php echo $page->lang('Proceed'); ?>" /></td></tr>
</table></div><?php $page->hide(); ?></form>
<?php
}

function percent_box($title, $percent)
{
	global $page;
	$mult = 2;
	$page->output('<table cellpadding="1" cellspacing="0" border="0"><tr><td>' . $title . ':&nbsp;</td><td style="width: ' . (100 * $mult) . 'px; height: 13px; background-color: #FEFEFF; border: 1px #98AAB1 solid;"><div style="width: ' . ($percent * $mult). 'px; height: 13px; background-color: #00D000;"></div></td></tr></table>');
}

function read_file($file)
{
	$data = @fread(@fopen($file, 'r'), @filesize($file));
	return $data ? "\n" . trim($data) : '';
}

// step functions
function step()
{
	global $parms, $steps;
	return $steps[ $parms['step'] ];
}
function next_step($step='')
{
	global $page, $parms, $steps;
	if ( !empty($step) )
	{
		$t_steps = array_flip($steps);
		$parms['step'] = $t_steps[$step];
	}
	else
	{
		$parms['step']++;
	}
	$page->set_parms($parms);
}

function _get($name, $type='', $dft='', $list='')
{
	global $HTTP_POST_VARS, $HTTP_GET_VARS;
	$value = _cast_get($dft, $type, $list);
	if ( isset($HTTP_POST_VARS[$name]) )
	{
		$value = _cast_get($HTTP_POST_VARS[$name], $type, $list);
	}
	else if ( isset($HTTP_GET_VARS[$name]) )
	{
		$value = _cast_get($HTTP_GET_VARS[$name], $type, $list);
	}
	return $value;
}

function _cast_get($value, $type, $list)
{
	switch ( $type )
	{
		case 'str':
			$value = htmlspecialchars(stripslashes($value));
			break;
		default:
			$value = intval($value);
			break;
	}
	if ( is_array($list) && !isset($list[$value]) )
	{
		@reset($list);
		list($value, $dummy) = @each($list);
	}
	return $value;
}

//--------------------------------------
//
// Start of the process
//
//--------------------------------------

// parms reading
$parms = array();
foreach ( $parms_def as $parm => $data )
{
	$type = empty($data) || !isset($data['type']) ? 'int' : $data['type'];
	$default = empty($data) || !isset($data['default']) ? (($type == TYPE_INT) ? 0 : '') : $data['default'];
	$list = empty($data) || !isset($data['list']) ? '' : $data['list'];
	$parms[$parm] = _get($parm, $type, $default, $list);
}

// start
$page = new page($requester, 'Script_title', 'lang_TC_install');
$page->set_parms($parms);
$page->sub_title = 'TC_code_name';

// set version
$lang['Script_title'] = sprintf($lang['Script_title'], TC_CURRENT_VERSION);
$lang['TC_code_name'] = 'Regular phpBB edition';

// log in
$session = new light_session();
$session->log_in(ADMIN);

// send welcome
if ( step() == 'TC_welcome' )
{
	$page->header();
	next_step();
	welcome_form();
	$page->footer();
}

// detect TC
if ( step() == 'TC_previous_version' )
{
	$sql = 'SELECT config_value
				FROM ' . CONFIG_TABLE . '
				WHERE config_name = \'mod_topic_calendar\'';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	if ( $row = $db->sql_fetchrow($result) )
	{
		$parms['tcpv'] = $row['config_value'];
	}
	$db->sql_freeresult($result);
	next_step();
}

// display previous version
if ( !empty($parms['tcpv']) )
{
	$page->output(sprintf($page->lang('TC_previous_version'), $parms['tcpv']));
}

// create or upgrade the database structure
if ( step() == 'TC_dbstruct' )
{
	$sql_struct = array();
	if ( !($sql_layer = $db->get_layer()) )
	{
		$page->critical_error('TC_db_not_supported');
	}

	// go with adds/modifications
	$remove_remarks = $sql_layer['COMMENTS'];
	$delimiter = $sql_layer['DELIM'];
	$delimiter_basic = $sql_layer['DELIM_BASIC'];

	// read the sql instructions
	$data = '';
	switch ( $parms['tcpv'] )
	{
		// upgrade from a previous version
		case '1.2.0':
		case '1.2.2':
			break;

		// new install
		case '':
			$dbms_schema = 'schemas/' . $sql_layer['SCHEMA'] . '.sql';
			$data .= read_file($dbms_schema);
			break;

		default:
			$page->critical_error('Unknown_version');
			break;
	}

	// parse the data
	if ( !empty($data) )
	{
		$data = preg_replace('/phpbb_/', $table_prefix, $data);
		$data = $remove_remarks($data);
		$sql_struct = split_sql_file($data, $delimiter);
		unset($data);
	}

	// process the sql
	$count_sql_struct = count($sql_struct);
	for ( $i = 0; $i < $count_sql_struct; $i++ )
	{
		$sql = trim($sql_struct[$i]);
		if ( !empty($sql) )
		{
			if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) )
			{
				$page->error(sprintf($page->lang('TC_sql_already_done'), $sql));
			}
		}
	}

	// ok for this one
	$parms['dbs'] = true;
	next_step();
	$page->loop();
}
if ( !empty($parms['dbs']) )
{
	$page->output(empty($parms['tcpv']) ? 'TC_dbstruct_done' : 'TC_dbstruct_upgraded');
}

// populate the database
if ( step() == 'TC_upg_data' )
{
	switch( $parms['tcpv'] )
	{
		case '1.2.0':
		case '1.2.2':
			break;

		// full install
		case '':
			break;

		default:
			$page->critical_error('Unknown_version');
			break;
	}

	// ok for this one too
	$parms['dbd'] = true;
	next_step();
	$page->loop();
}

// populate config table
if ( step() == 'TC_config' )
{
	// config set definition
	$config_set = array(
		'calendar_javascript' => array('config_value' => 1),
		'calendar_overview' => array('config_value' => 1),
		'calendar_display_open' => array('config_value' => 0),
		'calendar_week_start' => array('config_value' => 1),
		'calendar_title_length' => array('config_value' => 30),
		'calendar_text_length' => array('config_value' => 200),
		'calendar_header_cells' => array('config_value' => 7),
		'calendar_nb_row' => array('config_value' => 5),

		'calendar_javascript_over' => array('config_value' => 0),
		'calendar_overview_over' => array('config_value' => 0),
		'calendar_display_open_over' => array('config_value' => 0),
		'calendar_week_start_over' => array('config_value' => 0),
		'calendar_title_length_over' => array('config_value' => 0),
		'calendar_text_length_over' => array('config_value' => 0),
		'calendar_header_cells_over' => array('config_value' => 0),
		'calendar_nb_row_over' => array('config_value' => 0),
	);

	// recover existing values (except for cache_* minus cache_path)
	$sql = 'SELECT config_name, config_value
				FROM ' . CONFIG_TABLE . '
				WHERE config_name IN(\'' . implode('\', \'', array_keys($config_set)) . '\')';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		$config_set[ $row['config_name'] ]['config_value'] = $row['config_value'];
	}
	$db->sql_freeresult($result);

	// do some cleaning
	$sql = 'DELETE FROM ' . CONFIG_TABLE . '
				WHERE config_name IN(\'' . implode('\', \'', array_keys($config_set)) . '\')';
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// re insert config data
	$count_config_set = count($config_set);
	$db->sql_stack_reset();
	foreach ( $config_set as $config_name => $config_data )
	{
		$fields = array(
			'config_name' => $config_name,
			'config_value' => $config_data['config_value'],
		);
		$db->sql_stack_statement($fields);
	}
	$db->sql_stack_insert(CONFIG_TABLE, false, __LINE__, __FILE__);

	// next
	$parms['ccfg'] = true;
	next_step($parms['tcpv'] ? 'TC_resume' : '');
}
if ( !empty($parms['ccfg']) )
{
	$page->output('TC_db_config_done');
}

// -------------------------------------
//
// there starts new install specific work
//
// -------------------------------------

// force the user settings
if ( step() == 'TC_users' )
{
	$fields = array(
		'user_calendar_javascript' => 1,
		'user_calendar_overview' => 1,
		'user_calendar_display_open' => 0,
		'user_calendar_week_start' => 1,
		'user_calendar_title_length' => 30,
		'user_calendar_text_length' => 200,
		'user_calendar_header_cells' => 7,
		'user_calendar_nb_row' => 5,
	);
	$db->sql_statement($fields);
	$sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $db->sql_update;
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// done
	$parms['fus'] = true;
	next_step();
}
if ( !empty($parms['fus']) )
{
	$page->output('TC_force_settings_done');
}

// ----------------------------------------------------
//
// from here we resume on both upgrade and new installs
//
// ----------------------------------------------------
if ( step() == 'TC_resume' )
{
	next_step();
}

// all is done, recache
if ( step() == 'TC_end' )
{
	$fields = array(
		'config_name' => 'mod_topic_calendar',
		'config_value' => TC_CURRENT_VERSION,
	);
	$db->sql_statement($fields);
	if ( $config->data['mod_topic_calendar'] )
	{
		$sql = 'UPDATE ' . CONFIG_TABLE . '
					SET ' . $db->sql_update . '
					WHERE config_name = \'mod_topic_calendar\'';
	}
	else
	{
		$sql = 'INSERT INTO ' . CONFIG_TABLE . '
					(' . $db->sql_fields . ') VALUES(' . $db->sql_values . ')';
	}
	$db->sql_query($sql, false, __LINE__, __FILE__);

	$page->error(empty($parms['tcpv']) ? 'TC_install_done' : 'TC_install_upgraded');
	$page->critical_error('TC_return_to_board');
}

// send page
$page->header();
$page->footer();

?>