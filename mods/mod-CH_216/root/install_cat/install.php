<?php
//
//	file: install_cat/install.php
//	author: ptirhiik
//	begin: 25/08/2004
//	version: 1.6.10 - 20/10/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
define('IN_INSTALL', true);

$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'install_cat/install';

include($phpbb_root_path . 'common.'.$phpEx);
include($config->url('includes/class_install'));
include($config->url('includes/class_forums'));
include($config->url('includes/class_cp'));
include($config->url('install_cat/install_inc'));

// constants
define('ROWS_A_TURN', 500);

// steps
$steps = array(
//-- new install & upgrades
	'CH_welcome',
	'CH_previous_version',
	'CH_founder',
	'CH_config_check',
	'CH_tracesql',
	'CH_dbschemas',
	'CH_dbstruct',
	'CH_upg_data',
	'CH_cache',
	'CH_config',

//-- new install only
	'CH_presets',
	'CH_topic_icons',
	'CH_topic_attributes',
	'CH_categories',
	'CH_sync_topics',
	'CH_sync_forums',

//-- new install & upgrades
	'CH_resume',
	'CH_anon_user',
	'CH_orphean_groups',
	'CH_surnumerous_membership',
	'CH_individual_groups_surnumerous',
	'CH_individual_groups',
	'CH_founder_req',
	'CH_system_groups',
	'CH_user_groups_sync',
	'CH_sync_users',
	'CH_copy_unreads',

	'CH_patch_panels',
	'CH_import_pgauths',
	'CH_import_fauths',

	'CH_ptifo',

//-- end of process
	'CH_end',
);

// parms (not set is : type => TYPE_INT, default => 0)
$parms_def = array(
	'step' => array('list' => &$steps),
	'chpv' => array('type' => TYPE_NO_HTML, 'default' => ''),
	'fnd' => '',
	'fndreq' => '',
	'dbc' => '',
	'dbs' => '',
	'dbd' => '',
	'upr' => '',
	'uta' => '',
	'utb' => '',

	'cache' => '',
	'cpr' => '',
	'cti' => '',
	'cta' => '',
	'ccfg' => '',
	'ccat' => '',
	'tt' => '',
	'tf' => '',
	'tu' => '',
	'tur' => '',
	'error_tur' => '',

	'anon' => '',
	'og' => '',
	'tgs' => '',
	'tg' => '',
	'ti' => '',
	'tms' => '',
	'stv' => '',

	'pp' => '',
	'ipa' => '',
	'ifad' => '',
	'ifav' => '',

	'ptifo' => '',
);

// tpls
function welcome_form()
{
	global $page;
?><form name="post" method="post" action="<?php echo $page->url(); ?>"><br /><br /><div align="center"><table cellpadding="4" cellspacing="1" border="0" width="80%" class="background">
<tr><th><?php echo sprintf($page->lang('CH_welcome'), CH_CURRENT_VERSION); ?></th></tr>
<tr><td align="justify" class="row1"><?php echo '<img src="./install_pic.jpg" align="left" border="0" />'; ?><?php echo sprintf($page->lang('CH_welcome_explain'), CH_CURRENT_VERSION); ?><br /><br /><br /></td></tr>
<tr><td align="center" class="row2"><?php echo $page->lang('CH_start'); ?>: <input name="submit" type="submit" value="<?php echo $page->lang('CH_proceed'); ?>" /></td></tr>
</table></div><?php $page->hide(); ?></form>
<?php
}

function founder_form($possible_founders)
{
	global $page;
?><form name="post" method="post" action="<?php echo $page->url(); ?>"><br /><br /><div align="center"><table cellpadding="4" cellspacing="1" border="0" width="80%" class="background">
<tr><th><?php echo $page->lang('CH_choose_founder'); ?></th></tr>
<tr><td align="center" class="row1"><br /><br />
<?php echo $page->lang('CH_founder'); ?>: <select name="fnd"><?php

	$i = 0;
	foreach ( $possible_founders as $id => $name )
	{
		$i++;
?><option value="<?php echo $i; ?>"><?php echo $name; ?></option><?php
	}

?></select> <input name="select" type="submit" value="<?php echo $page->lang('CH_select'); ?>" />
<br /><br /></td></tr>
</table></div><?php $page->hide(); ?></form>
<?php
}

function percent_box($title, $percent)
{
	global $page;
	$mult = 2;
	$page->output('<table cellpadding="1" cellspacing="0" border="0"><tr><td>' . $title . ':&nbsp;</td><td style="width: ' . (100 * $mult) . 'px; height: 13px; background-color: #FEFEFF; border: 1px #98AAB1 solid;"><div style="width: ' . ($percent * $mult). 'px; height: 13px; background-color: #00D000;"></div></td></tr></table>');
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

//--------------------------------------
//
// Start of the process
//
//--------------------------------------

// parms reading
$parms = array();
foreach ( $parms_def as $parm => $data )
{
	$type = empty($data) || !isset($data['type']) ? TYPE_INT : $data['type'];
	$default = empty($data) || !isset($data['default']) ? (($type == TYPE_INT) ? 0 : '') : $data['default'];
	$list = empty($data) || !isset($data['list']) ? '' : $data['list'];
	$parms[$parm] = _read($parm, $type, $default, $list);
}

// data
$founder_id = 0;
$founder_name = '';

// start
$page = new page($requester);
$page->set_parms($parms);
$page->sub_title = 'CH_code_name';

// set version
$lang['Script_title'] = sprintf($lang['Script_title'], CH_CURRENT_VERSION);
$lang['CH_code_name'] = '"The Arctic Half-Moon Quest" edition';

// log in
$session = new light_session();
$session->log_in(ADMIN);

// send welcome
if ( step() == 'CH_welcome' )
{
	$page->header();
	next_step();
	welcome_form();
	$page->footer();
}

// detect CH
if ( step() == 'CH_previous_version' )
{
	$sql = 'SELECT config_value
				FROM ' . CONFIG_TABLE . '
				WHERE config_name = \'mod_cat_hierarchy\'';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	if ( $row = $db->sql_fetchrow($result) )
	{
		$parms['chpv'] = $row['config_value'];
	}
	$db->sql_freeresult($result);
	next_step();
}

// get founder
if ( (step() == 'CH_founder') || ($parms['fnd'] && $parms['fndreq']) )
{
	$done = false;
	$possible_founders = array();

	// a previous version of CH is installed : the founder so is the Board_founder group moderator
	if ( !empty($parms['chpv']) )
	{
		$sql = 'SELECT config_value
					FROM ' . CONFIG_TABLE . '
					WHERE config_name = \'group_founder\'';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ( $row )
		{
			$group_founder = intval($row['config_value']);
			if ( !empty($group_founder) )
			{
				$sql = 'SELECT u.user_id, u.username
							FROM ' . GROUPS_TABLE . ' g, ' . USERS_TABLE . ' u
							WHERE g.group_id = ' . $group_founder . '
								AND u.user_id = g.group_moderator
								AND u.user_active = ' . true;
				$result = $db->sql_query($sql, false, __LINE__, __FILE__);
				if ( $row = $db->sql_fetchrow($result) )
				{
					$founder_id = intval($row['user_id']);
					if ( !empty($founder_id) )
					{
						$founder_name = $row['username'];
						$done = true;
					}
					$parms['fnd'] = -1;
				}
				$db->sql_freeresult($result);
			}
		}
	}

	// previous CH install not complete, or no previous CH
	if ( !$done )
	{
		$sql = 'SELECT user_id, username
					FROM ' . USERS_TABLE . '
					WHERE user_level = ' . ADMIN . '
						AND user_active = ' . true . '
					ORDER BY user_id';
		if ( !empty($parms['fnd']) )
		{
			$sql .= ' LIMIT ' . (intval($parms['fnd']) - 1) . ', 1';
		}
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$possible_founders[ intval($row['user_id']) ] = $row['username'];
		}
		$db->sql_freeresult($result);
		if ( empty($possible_founders) )
		{
			$sql = 'SELECT username
						FROM ' . USERS_TABLE . '
						WHERE user_id = ' . $session->user_id;
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			if ( $row = $db->sql_fetchrow($result) )
			{
				$possible_founders[$session->user_id] = $row['username'];
			}
			else
			{
				$page->critical_error('CH_no_founder');
			}
			$db->sql_freeresult($result);
		}
		$count_possible_founders = count($possible_founders);
		if ( $count_possible_founders == 1 )
		{
			if ( empty($parms['fnd']) )
			{
				$parms['fnd'] = 1;
			}
			@reset($possible_founders);
			list($founder_id, $founder_name) = @each($possible_founders);
			$done = !empty($founder_id);
		}
	}

	// possible founders array contains more than one founder : send a form
	if ( !$done )
	{
		$page->header();
		founder_form($possible_founders);
		$page->footer();
	}
	if ( step() == 'CH_founder' )
	{
		next_step();
	}
}

// check config
if ( step() == 'CH_config_check' )
{
	$config_check = new config_check();
	$config_check->process();
	next_step();
}

// display previous version and founder messsages
if ( !empty($parms['chpv']) )
{
	$page->output(sprintf($page->lang('CH_previous_version'), $parms['chpv']));
}
if ( !empty($parms['fnd']) && !empty($parms['fndreq']) )
{
	$page->output(sprintf($page->lang('CH_founder_is'), $founder_id, $founder_name));
}

if ( (step() == 'CH_tracesql') || (step() == 'CH_dbstruct') )
{
	// get the db install layer
	if ( !($sql_layer = $db->get_layer()) )
	{
		$page->critical_error('CH_db_not_supported');
	}
	if ( $sql_layer['SCHEMA'] == 'postgres' )
	{
		$sql_layer['SCHEMA'] = 'pgsql';
	}
	$dbi_layer = 'dbi_' . $sql_layer['SCHEMA'];

	// include the layers
	include($config->url('includes/class_xml'));
	include($config->url('includes/db/class_dbi'));
	include($config->url('includes/db/class_' . $dbi_layer));
}

// check the install table creation
if ( step() == 'CH_tracesql' )
{
	$sql = 'SELECT *
				FROM ' . INSTSQL_TABLE . '
				LIMIT 1';
	if ( !($result = $db->sql_query($sql, false, __LINE__, __FILE__, false)) )
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
<actions>
	<action name="inst_sql">
		<create_table>
			<table name="instsql">
				<field name="isql_id"><type>mediumint</type><size>8</size><default>0</default><extra>auto_increment</extra></field>
				<field name="isql_schema"><type>varchar</type><size>80</size></field>
				<field name="isql_request"><type>text</type></field>
				<field name="isql_done"><type>tinyint</type><size>1</size><default>0</default></field>
				<field name="isql_report"><type>varchar</type><size>255</size></field>
				<index name="pkey">
					<type>PRIMARY</type>
					<field name="isql_id" />
				</index>
				<index name="isql_done">
					<field name="isql_done" />
				</index>
			</table>
		</create_table>
	</action>
</actions>';

		// process the schemas
		$xml_parser = new xml_parser();
		$actions = empty($xml) ? false : $xml_parser->parse($xml);
		unset($xml);
		if ( $actions === false )
		{
			$page->critical_error($xml_parser->errmsg);
		}

		// translate the schema to requests
		$dbi = new $dbi_layer($table_prefix);
		if ( $actions && isset($actions['cdata']) && ($count_actions = count($actions['cdata'])) )
		{
			for ( $j = 0; $j < $count_actions; $j++ )
			{
				$sqls = isset($actions['cdata'][$j]['actions']) ? $dbi->process($actions['cdata'][$j]['actions']) : false;
				unset($actions['cdata'][$j]);

				$count_sqls = $sqls ? count($sqls) : 0;
				for ( $k = 0; $k < $count_sqls; $k++ )
				{
					$result = $db->sql_query($sqls[$k], false, __LINE__, __FILE__, false);
					if ( $result === false )
					{
						$sql_error = $db->sql_error();
						$page->error(sprintf($page->lang('CH_sql_already_done'), ($sql_error['message'] ? $sql_error['message'] . ': ' : '') . $sqls[$k]));
					}
					else if ( $result !== true )
					{
						$db->sql_freeresult($result);
					}
					unset($result);
				}
				unset($sqls);
			}
		}
		unset($actions);
		unset($dbi);
		unset($xml_parser);
	}
	else
	{
		$db->sql_freeresult($result);
	}
	next_step();
}

// get the schema and fill the instsql table
if ( step() == 'CH_dbschemas' )
{
	// clear any previous sql
	$sql = 'TRUNCATE TABLE ' . INSTSQL_TABLE;
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// read the sql instructions
	$schemas = array();
	switch ( $parms['chpv'] )
	{
		// upgrade from a previous version
		case '2.1.0':
		case '2.1.0b':
		case '2.1.0c':
		case '2.1.0d':
		case '2.1.0e':
		case '2.1.0f':
			$schemas[] = 'schema_2_1_0';

		case '2.1.1':
		case '2.1.1RC2':
		case '2.1.1RC3':
		case '2.1.1RC4':
		case '2.1.1RC5':
		case '2.1.1RC6':
			$schemas[] = 'schema_2_1_1';

		case '2.1.2':
		case '2.1.4':
		case '2.1.4c':
		case '2.1.4d':
		case '2.1.4e':
			$schemas[] = 'schema_2_1_2';

		case '2.1.5RC1':
		case '2.1.5RC2':
		case '2.1.5RC3':
		case '2.1.5RC4':
		case '2.1.5RC5':
		case '2.1.5RC6':
		case '2.1.5RC7':
			$schemas[] = 'schema_2_1_5';

		case '2.1.6':
		case '2.1.6b':
		case '2.1.6c':
			$schemas[] = 'schema_2_1_6';

		case '2.1.6d':
			$schemas[] = 'schema_fix_phpbb';
			$schemas[] = 'schema_2_1_6d';

		case '2.1.6e':
		case '2.1.6f':
		case '2.1.6g':

		// new install
		break;
		case '':
			$schemas[] = 'schema_fix_phpbb';
			$schemas[] = 'schema_phpbb';
			break;

		default:
			$page->critical_error('Unknown_version');
			break;
	}

	// process the schemas
	if ( ($count_schemas = count($schemas)) )
	{
		$xml_parser = new xml_parser();
		$dbi = new $dbi_layer($table_prefix);
		for ( $i = 0; $i < $count_schemas; $i++ )
		{
			// read & parse the XML schema
			$actions = false;
			if ( ($xml_name = phpbb_realpath($phpbb_root_path . 'install_cat/schemas/' . $schemas[$i] . '.xml')) && ($handler = @fopen($xml_name, 'r')) )
			{
				$xml = trim(fread($handler, filesize($xml_name)));
				fclose($handler);
				unset($handler);
				$actions = empty($xml) ? false : $xml_parser->parse($xml);
				unset($xml);
				if ( $actions === false )
				{
					$page->critical_error($xml_parser->errmsg);
				}
			}

			// process the sqls
			if ( $actions && isset($actions['cdata']) && ($count_actions = count($actions['cdata'])) )
			{
				for ( $j = 0; $j < $count_actions; $j++ )
				{
					$sqls = isset($actions['cdata'][$j]['actions']) ? $dbi->process($actions['cdata'][$j]['actions']) : false;
					unset($actions['cdata'][$j]);

					$count_sqls = $sqls ? count($sqls) : 0;
					for ( $k = 0; $k < $count_sqls; $k++ )
					{
						$fields = array(
							'isql_schema' => $schemas[$i],
							'isql_request' => $sqls[$k],
							'isql_done' => 0,
						);
						$sql = 'INSERT INTO ' . INSTSQL_TABLE . '
									(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
						$db->sql_query($sql, false, __LINE__, __FILE__);
					}
					unset($sqls);
				}
			}
			unset($actions);
		}
		unset($dbi);
		unset($xml_parser);
		unset($schemas);
	}

	// ok for this one
	$parms['dbc'] = true;
	next_step();
	$page->loop();
}
if ( !empty($parms['dbc']) )
{
	$page->output('CH_dbschema_done');
}

// create or upgrade the database structure
if ( step() == 'CH_dbstruct' )
{
	$max = $id = $request = false;

	// get count
	$sql = 'SELECT MAX(isql_id) AS max_isql_id
				FROM ' . INSTSQL_TABLE;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$max = ($row = $db->sql_fetchrow($result)) ? intval($row['max_isql_id']) : 0;
	$db->sql_freeresult($result);

	// get request
	if ( $max )
	{
		$sql = 'SELECT *
					FROM ' . INSTSQL_TABLE . '
					WHERE isql_done = 0
					ORDER BY isql_id
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$request = ($row = $db->sql_fetchrow($result)) ? $row : false;
		$db->sql_freeresult($result);

		$id = $request ? intval($request['isql_id']) : false;
	}

	// process request
	if ( $id )
	{
		// send a percent box
		percent_box(sprintf($page->lang('CH_dbstruct_percent'), $id, $max), round($id * 100 / $max));

		// process the request
		$result = $db->sql_query(trim($request['isql_request']), false, __LINE__, __FILE__, false);
		unset($request);
		if ( $result === false )
		{
			$sql_error = $db->sql_error();
			$fields = array(
				'isql_done' => 2,
				'isql_report' => $sql_error['message'] ? (string) $sql_error['message'] : '',
			);
		}
		else
		{
			if ( $result !== true )
			{
				$db->sql_freeresult($result);
			}
			$fields = array(
				'isql_done' => 1,
			);
		}
		$sql = 'UPDATE ' . INSTSQL_TABLE . '
					SET ' . $db->sql_fields('update', $fields) . '
					WHERE isql_id = ' . intval($id);
		$db->sql_query($sql, false, __LINE__, __FILE__);
		unset($result);
	}

	if ( !$max || ($id === false) || ($id == $max) )
	{
		$sql = 'SELECT *
					FROM ' . INSTSQL_TABLE . '
					WHERE isql_done = 2
					ORDER BY isql_id';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( ($row = $db->sql_fetchrow($result)) )
		{
			$page->error(sprintf($page->lang('CH_sql_already_done'), ($row['isql_report'] ? '<strong>' . $row['isql_report'] . '</strong>:<br />' : '') . htmlspecialchars($row['isql_request']) . '<br />'));
		}
		$parms['dbs'] = $max ? true : false;
		next_step();
	}
	$page->loop();
}
if ( !empty($parms['dbs']) )
{
	$page->output(empty($parms['chpv']) ? 'CH_dbstruct_done' : 'CH_dbstruct_upgraded');
}

// populate the database
if ( step() == 'CH_upg_data' )
{
	switch( $parms['chpv'] )
	{
		case '2.1.0':
		case '2.1.0b':
		case '2.1.0c':
		case '2.1.0d':
		case '2.1.0e':
		case '2.1.0f':
			//--------------------------
			// auths presets creation
			//--------------------------
			// create header
			$fields = array(
				'preset_type' => 'f',
				'preset_name' => 'Preset_guest_posting',
			);
			$sql = 'INSERT INTO ' . PRESETS_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$preset_id = $db->sql_nextid();

			// create a guest preset
			$db->sql_stack_reset();
			$db->sql_stack_fields = 'preset_id, preset_auth, preset_value';
			$db->sql_stack_values = array(
				'(' . $preset_id . ', \'auth_view\', 1)', '(' . $preset_id . ', \'auth_read\', 1)', '(' . $preset_id . ', \'auth_post\', 1)', '(' . $preset_id . ', \'auth_reply\', 1)',
			);
			$db->sql_stack_insert(PRESETS_DATA_TABLE, false, __LINE__, __FILE__);
			$parms['upr'] = true;

			//--------------------------
			// topic title attribute
			//--------------------------
			$sql = 'TRUNCATE TABLE ' . TOPICS_ATTR_TABLE;
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$db->sql_stack_reset();
			$db->sql_stack_fields = 'attr_name, attr_fname, attr_fimg, attr_tname, attr_timg, attr_order, attr_field, attr_cond, attr_value, attr_auth';
			$db->sql_stack_values = array(
				'(\'Topic_Moved\', \'Topic_Moved\', \'folder_moved\', \'Topic_Moved\', \'\', 80, \'topic_moved_id\', \'GT\', 0, \'\')',
				'(\'Topic_Locked\', \'Topic_Locked\', \'folder_locked\', \'Topic_Locked\', \'topic_locked_tiny\', 30, \'topic_status\', \'GT\', 0, \'\')',
				'(\'Topic_Global_Announcement\', \'Topic_Global_Announcement\', \'folder_global\', \'Post_Global_Announcement\', \'\', 70, \'topic_type\', \'GE\', 3, \'\')',
				'(\'Topic_Announcement\', \'Topic_Announcement\', \'folder_announce\', \'Post_Announcement\', \'\', 60, \'topic_type\', \'EQ\', 2, \'\')',
				'(\'Topic_Sticky\', \'Topic_Sticky\', \'folder_sticky\', \'Post_Sticky\', \'\', 50, \'topic_type\', \'EQ\', 1, \'\')',
				'(\'Topic_Poll\', \'Topic_Poll\', \'\', \'Topic_Poll\', \'topic_poll_tiny\', 20, \'topic_vote\', \'GT\', 0, \'\')',
				'(\'Topic_Attached\', \'Topic_Attached\', \'\', \'Topic_Attached\', \'\', 10, \'topic_attachment\', \'GT\', 0, \'\')',
				'(\'Topic_calendar\', \'Topic_calendar\', \'folder_calendar\', \'Topic_calendar\', \'topic_calendar_tiny\', 40, \'topic_calendar_time\', \'GT\', 0, \'\')',
			);
			$db->sql_stack_insert(TOPICS_ATTR_TABLE, false, __LINE__, __FILE__);
			$parms['uta'] = true;

		case '2.1.1':
		case '2.1.1RC2':
		case '2.1.1RC3':
		case '2.1.1RC4':
		case '2.1.1RC5':
		case '2.1.1RC6':
		case '2.1.2':
		case '2.1.4':
		case '2.1.4c':
		case '2.1.4d':
		case '2.1.4e':
			// create bots
			create_bots();
			$parms['utb'] = true;

		case '2.1.5RC1':
		case '2.1.5RC2':
		case '2.1.5RC3':
		case '2.1.5RC4':
		case '2.1.5RC5':
		case '2.1.5RC6':
		case '2.1.5RC7':
			$sqls = array(
				'TRUNCATE TABLE ' . CP_PANELS_TABLE,
				'TRUNCATE TABLE ' . CP_FIELDS_TABLE,
				'TRUNCATE TABLE ' . CP_PATCHES_TABLE,
				'DELETE FROM ' . AUTHS_TABLE . '
					WHERE obj_type <> \'' . POST_FORUM_URL . '\'',
				'UPDATE ' . TOPICS_ATTR_TABLE . '
					SET attr_fname = \'Topic_Locked\'
					WHERE attr_fname = \'Topic_locked\'',
			);

			// process the sql
			$count_sqls = count($sqls);
			for ( $i = 0; $i < $count_sqls; $i++ )
			{
				$sql = trim($sqls[$i]);
				if ( !empty($sql) )
				{
					if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) )
					{
						$page->error(sprintf($page->lang('CH_sql_already_done'), $sql));
					}
				}
			}

			// delete groups preset data
			$sql = 'DELETE FROM ' . PRESETS_DATA_TABLE . '
						WHERE preset_id IN(' . $db->sql_subquery('preset_id', '
							SELECT DISTINCT preset_id
								FROM ' . PRESETS_TABLE . '
								WHERE preset_type = \'' . POST_GROUPS_URL . '\'
							', __LINE__, __FILE__) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// delete groups preset headers
			$sql = 'DELETE FROM ' . PRESETS_TABLE . '
						WHERE preset_type = \'' . POST_GROUPS_URL . '\'';
			$db->sql_query($sql, false, __LINE__, __FILE__);

			$presets = array(
				'g' => array(
					'None' => array(),
					'Preset_view' => array('value' => 1, 'fields' => array('ucp_view_profile')),
					'Preset_admin' => array('value' => 1, 'fields' => array('ucp_edit_admin', 'ucp_edit_avatar', 'ucp_edit_contact', 'ucp_edit_i18n', 'ucp_edit_layout', 'ucp_edit_personal', 'ucp_edit_posting', 'ucp_edit_privacy', 'ucp_edit_profile', 'ucp_edit_registration', 'ucp_edit_signature', 'ucp_edit_topicread')),
					'Preset_edit_denied' => array('value' => 2, 'fields' => array('ucp_edit_admin', 'ucp_edit_avatar', 'ucp_edit_contact', 'ucp_edit_i18n', 'ucp_edit_layout', 'ucp_edit_personal', 'ucp_edit_posting', 'ucp_edit_privacy', 'ucp_edit_profile', 'ucp_edit_registration', 'ucp_edit_signature', 'ucp_edit_topicread')),
					'Preset_edit_own' => array('value' => 1, 'fields' => array('ucp_edit_avatar', 'ucp_edit_contact', 'ucp_edit_i18n', 'ucp_edit_layout', 'ucp_edit_personal', 'ucp_edit_posting', 'ucp_edit_privacy', 'ucp_edit_profile', 'ucp_edit_registration', 'ucp_edit_signature', 'ucp_edit_topicread', 'ucp_view_profile')),
					'Preset_edit_public' => array('value' => 1, 'fields' => array('ucp_edit_avatar', 'ucp_edit_contact', 'ucp_edit_i18n', 'ucp_edit_layout', 'ucp_edit_personal', 'ucp_edit_posting', 'ucp_edit_privacy', 'ucp_edit_profile', 'ucp_edit_signature', 'ucp_edit_topicread')),
				),
			);

			// re-create presets
			create_presets($presets);
			$parms['upr'] = true;

			// init board visit statistics
			$parms['stv'] = create_stats_visit();

		case '2.1.6':
		case '2.1.6b':
		case '2.1.6c':
		case '2.1.6d':
		case '2.1.6e':
		case '2.1.6f':
		case '2.1.6g':
			break;

		// full install
		case '':
			// create bots
			create_bots();
			$parms['utb'] = true;

			// init board visit statistics
			$parms['stv'] = create_stats_visit();
			break;

		default:
			$page->critical_error('Unknown_version');
			break;
	}
	next_step();
	$page->loop();
}
if ( !empty($parms['upr']) )
{
	$page->output('CH_presets_added');
}
if ( !empty($parms['uta']) )
{
	$page->output('CH_db_topics_attribute_done');
}
if ( !empty($parms['utb']) )
{
	$page->output('CH_db_bots_done');
}
if ( !empty($parms['stv']) )
{
	$page->output('CH_stats_visit_done');
}

// check if cache/ directory is writable
if ( step() == 'CH_cache' )
{
	$cache_id = md5(uniqid(mt_rand(), true));

	// create the file
	$file = $page->root . 'cache/tst_cache.php';
	@unlink($file);
	$handle = @fopen($file, 'w');
	@flock($handle, LOCK_EX);
	@fwrite($handle, $cache_id);
	@flock($handle, LOCK_UN);
	@fclose($handle);
	@umask(0000);
	@chmod($filename, 0644);

	// reread
	$data = @fread(@fopen($file, 'r'), @filesize($file));
	@unlink($file);
	$parms['cache'] = ($data == $cache_id) ? 2 : 1;
	next_step();
}
switch ( $parms['cache'] )
{
	case 1:
		$page->output('CH_caches_not_available');
		break;
	case 2:
		$page->output('CH_caches_available');
		break;
}
$cache_set = ($parms['cache'] == 1) ? 1 : 0;

// populate config table
if ( step() == 'CH_config' )
{
	// config set definition
	$config_set = array(
		// stats
		'stat_total_posts' => array('config_value' => 0, 'config_static' => 0),
		'stat_total_topics' => array('config_value' => 0, 'config_static' => 0),
		'stat_total_users' => array('config_value' => 0, 'config_static' => 0),
		'stat_last_user' => array('config_value' => 0, 'config_static' => 0),
		'stat_last_username' => array('config_value' => 0, 'config_static' => 0),
		'stats_display_past' => array('config_value' => 1, 'config_static' => 0),

		// board level
		'site_fav_icon' => array('config_value' => 'images/favicon.ico', 'config_static' => 1),
		'keep_unreads' => array('config_value' => 0, 'config_static' => 1),
		'keep_unreads_over' => array('config_value' => 0, 'config_static' => 1),
		'smart_date' => array('config_value' => 1, 'config_static' => 1),
		'smart_date_over' => array('config_value' => 0, 'config_static' => 1),
		'icons_path' => array('config_value' => 'images/icons/', 'config_static' => 1),

		'topics_split_global' => array('config_value' => 0, 'config_static' => 1),
		'topics_split_announces' => array('config_value' => 0, 'config_static' => 1),
		'topics_split_stickies' => array('config_value' => 0, 'config_static' => 1),

		'posts_sort' => array('config_value' => 'lastpost', 'config_static' => 1),
		'posts_order' => array('config_value' => 'ASC', 'config_static' => 1),
		'posts_sort_over' => array('config_value' => 0, 'config_static' => 1),

		'default_duration' => array('config_value' => 7, 'config_static' => 1),

		'pagination_min' => array('config_value' => 5, 'config_static' => 1),
		'pagination_max' => array('config_value' => 11, 'config_static' => 1),
		'pagination_percent' => array('config_value' => 10, 'config_static' => 1),

		'topic_title_length' => array('config_value' => 60, 'config_static' => 1),
		'sub_title_length' => array('config_value' => 100,  'config_static' => 1),

		// forum level
		'index_fav_icon' => array('config_value' => 'images/favicon.gif', 'config_static' => 1),
		'topics_sort' => array('config_value' => 'lastpost', 'config_static' => 1),
		'topics_order' => array('config_value' => 'DESC', 'config_static' => 1),
		'topics_sort_over' => array('config_value' => 0, 'config_static' => 1),
		'last_topic_title_length' => array('config_value' => 25, 'config_static' => 1),
		'index_pack' => array('config_value' => 0, 'config_static' => 1),
		'index_pack_over' => array('config_value' => 0, 'config_static' => 1),
		'index_split' => array('config_value' => 0, 'config_static' => 1),
		'index_split_over' => array('config_value' => 0, 'config_static' => 1),
		'board_box' => array('config_value' => 1, 'config_static' => 1),
		'board_box_over' => array('config_value' => 0, 'config_static' => 1),

		// cache (cfg cache, cache path & cache key have to remain dynamic)
		'cache_key' => array('config_value' => md5(uniqid(rand())), 'config_static' => 0),
		'cache_path' => array('config_value' => 'cache/', 'config_static' => 0),
		'cache_disabled_cfg' => array('config_value' => $cache_set, 'config_static' => 0),
		'cache_disabled_f' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_mods' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_themes' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_ranks' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_words' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_smilies' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_icons' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_cp_patches' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_cp_panels' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_bots' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_disabled_lang' => array('config_value' => $cache_set, 'config_static' => 1),

		// users caches level time markers
		'cache_time_f' => array('config_value' => 0, 'config_static' => 1),
		'cache_time_m' => array('config_value' => 0, 'config_static' => 1),
		'cache_time_g' => array('config_value' => 0, 'config_static' => 1),
		'cache_time_fjbox' => array('config_value' => 0, 'config_static' => 1),
		'cache_time_glist' => array('config_value' => 0, 'config_static' => 1),

		// template cache
		'cache_disabled_template' => array('config_value' => $cache_set, 'config_static' => 1),
		'cache_check_template' => array('config_value' => 1, 'config_static' => 1),

		// posting
		'enable_confirm_post' => array('config_value' => 1, 'config_static' => 1),
		'guests_proxies_disabled' => array('config_value' => 0, 'config_static' => 1),

		// registration
		'forum_rules' => array('config_value' => 0, 'config_static' => 1),
		'coppa_required' => array('config_value' => 1, 'config_static' => 1),
		'password_mini' => array('config_value' => 5, 'config_static' => 1),

		// email
		'email_disable' => array('config_value' => 0, 'config_static' => 1),

		// DDoS control
		'search_max_concur' => array('config_value' => 10, 'config_static' => 1),
		'search_time_concur' => array('config_value' => 5, 'config_static' => 1),
		'posting_max_guests' => array('config_value' => 10, 'config_static' => 1),
		'posting_time_guests' => array('config_value' => 1, 'config_static' => 1),
	);

	// recover existing values (except for cache_* minus cache_path)
	$sql = 'SELECT config_name, config_value
				FROM ' . CONFIG_TABLE . '
				WHERE config_name IN(\'' . implode('\', \'', array_keys($config_set)) . '\')
					AND (config_name NOT LIKE \'cache_%\' OR config_name = \'cache_path\')';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		$config_set[ $row['config_name'] ]['config_value'] = $row['config_value'];
	}
	$db->sql_freeresult($result);

	// do some cleaning
	$sql = 'DELETE FROM ' . CONFIG_TABLE . '
				WHERE config_name IN(\'' . implode('\', \'', array_keys($config_set)) . '\', \'mod_extended_tpl_CH\', \'mod_extend_ucp_CH\')
					OR config_name LIKE \'stats_gcount_%\'';
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// update cache switch in config table (force)
	$sql = 'UPDATE ' . CONFIG_TABLE . '
				SET config_static = 1';
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// update cache switch in config table (reset some)
	$sql = 'UPDATE ' . CONFIG_TABLE . '
				SET config_static = 0
				WHERE config_name LIKE \'record_%\'
					OR config_name LIKE \'stats_%\'
					OR config_name LIKE \'XS_%\'
					OR config_name = \'sendmail_fix\'
					OR config_name = \'rand_seed\'';
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// re insert config data
	$count_config_set = count($config_set);
	$db->sql_stack_reset();
	foreach ( $config_set as $config_name => $config_data )
	{
		$fields = array(
			'config_name' => $config_name,
			'config_value' => $config_data['config_value'],
			'config_static' => $config_data['config_static'],
		);
		$db->sql_stack_statement($fields);
	}
	$db->sql_stack_insert(CONFIG_TABLE, false, __LINE__, __FILE__);

	// recache
	$config->read(true);
	$parms['ccfg'] = true;
	next_step($parms['chpv'] ? 'CH_resume' : '');
}
if ( !empty($parms['ccfg']) )
{
	$page->output('CH_db_config_done');
}

// -------------------------------------
//
// there starts new install specific work
//
// -------------------------------------

// populate presets table
if ( step() == 'CH_presets' )
{
	// do some cleaning
	$sql = 'TRUNCATE TABLE ' . PRESETS_DATA_TABLE;
	$db->sql_query($sql, false, __LINE__, __FILE__);

	$sql = 'TRUNCATE TABLE ' . PRESETS_TABLE;
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// define presets
	$presets = array(
		POST_FORUM_URL => array(
			'None' => array(),
			'Preset_read_only' => array('value' => 1, 'fields' => array('auth_read', 'auth_view')),
			'Preset_read_post_vote' => array('value' => 1, 'fields' => array('auth_delete', 'auth_edit', 'auth_post', 'auth_read', 'auth_reply', 'auth_view', 'auth_vote')),
			'Preset_moderator' => array('value' => 1, 'fields' => array('auth_announce', 'auth_delete', 'auth_edit', 'auth_global_announce', 'auth_mod', 'auth_mod_display', 'auth_pollcreate', 'auth_post', 'auth_read', 'auth_reply', 'auth_sticky', 'auth_view', 'auth_vote')),
			'Preset_moderator_hidden' => array('value' => 1, 'fields' => array('auth_announce', 'auth_delete', 'auth_edit', 'auth_global_announce', 'auth_mod', 'auth_pollcreate', 'auth_post', 'auth_read', 'auth_reply', 'auth_sticky', 'auth_view', 'auth_vote')),
			'Preset_admin' => array('value' => 1, 'fields' => array('auth_announce', 'auth_delete', 'auth_edit', 'auth_global_announce', 'auth_mod', 'auth_pollcreate', 'auth_post', 'auth_read', 'auth_reply', 'auth_sticky', 'auth_view', 'auth_vote', 'auth_manage')),
			'Preset_guest_posting' => array('value' => 1, 'fields' => array('auth_view', 'auth_read', 'auth_post', 'auth_reply')),
		),
		POST_PANELS_URL => array(
			'None' => array(),
			'Preset_access' => array('value' => 1, 'fields' => array('access')),
		),
		POST_GROUPS_URL => array(
			'None' => array(),
			'Preset_view' => array('value' => 1, 'fields' => array('ucp_view_profile')),
			'Preset_admin' => array('value' => 1, 'fields' => array('ucp_edit_admin', 'ucp_edit_avatar', 'ucp_edit_contact', 'ucp_edit_i18n', 'ucp_edit_layout', 'ucp_edit_personal', 'ucp_edit_posting', 'ucp_edit_privacy', 'ucp_edit_profile', 'ucp_edit_registration', 'ucp_edit_signature', 'ucp_edit_topicread')),
			'Preset_edit_denied' => array('value' => 2, 'fields' => array('ucp_edit_admin', 'ucp_edit_avatar', 'ucp_edit_contact', 'ucp_edit_i18n', 'ucp_edit_layout', 'ucp_edit_personal', 'ucp_edit_posting', 'ucp_edit_privacy', 'ucp_edit_profile', 'ucp_edit_registration', 'ucp_edit_signature', 'ucp_edit_topicread')),
			'Preset_edit_own' => array('value' => 1, 'fields' => array('ucp_edit_avatar', 'ucp_edit_contact', 'ucp_edit_i18n', 'ucp_edit_layout', 'ucp_edit_personal', 'ucp_edit_posting', 'ucp_edit_privacy', 'ucp_edit_profile', 'ucp_edit_registration', 'ucp_edit_signature', 'ucp_edit_topicread', 'ucp_view_profile')),
			'Preset_edit_public' => array('value' => 1, 'fields' => array('ucp_edit_avatar', 'ucp_edit_contact', 'ucp_edit_i18n', 'ucp_edit_layout', 'ucp_edit_personal', 'ucp_edit_posting', 'ucp_edit_privacy', 'ucp_edit_profile', 'ucp_edit_signature', 'ucp_edit_topicread')),
		),
	);

	// create the presets
	create_presets($presets);

	$parms['cpr'] = true;
	next_step();
}
if ( !empty($parms['cpr']) )
{
	$page->output('CH_db_presets_done');
}

// populate topic icons table
if ( step() == 'CH_topic_icons' )
{
	$sql = 'TRUNCATE TABLE ' . ICONS_TABLE;
	$db->sql_query($sql, false, __LINE__, __FILE__);
	$db->sql_stack_reset();
	$db->sql_stack_fields = 'icon_name, icon_url, icon_auth, icon_types, icon_order';
	$db->sql_stack_values = array(
		'(\'icon_note\', \'images/icons/icon1.gif\', \'\', \'0\', 10)',
		'(\'icon_important\', \'images/icons/icon2.gif\', \'\', \'1\', 20)',
		'(\'icon_idea\', \'images/icons/icon3.gif\', \'\', \'\', 30)',
		'(\'icon_warning\', \'images/icons/icon4.gif\', \'\', \'2, 3\', 40)',
		'(\'icon_question\', \'images/icons/icon5.gif\', \'\', \'\', 50)',
		'(\'icon_cool\', \'images/icons/icon6.gif\', \'\', \'\', 60)',
		'(\'icon_funny\', \'images/icons/icon7.gif\', \'\', \'\', 70)',
		'(\'icon_angry\', \'images/icons/icon8.gif\', \'\', \'\', 80)',
		'(\'icon_sad\', \'images/icons/icon9.gif\', \'\', \'\', 90)',
		'(\'icon_mocker\', \'images/icons/icon10.gif\', \'\', \'\', 100)',
		'(\'icon_shocked\', \'images/icons/icon11.gif\', \'\', \'\', 110)',
		'(\'icon_complicity\', \'images/icons/icon12.gif\', \'\', \'\', 120)',
		'(\'icon_bad\', \'images/icons/icon13.gif\', \'\', \'\', 130)',
		'(\'icon_great\', \'images/icons/icon14.gif\', \'\', \'\', 140)',
		'(\'icon_disgusting\', \'images/icons/icon15.gif\', \'\', \'\', 150)',
		'(\'icon_winner\', \'images/icons/icon16.gif\', \'\', \'\', 160)',
		'(\'icon_impressed\', \'images/icons/icon17.gif\', \'\', \'\', 170)',
		'(\'icon_roleplay\', \'images/icons/icon18.gif\', \'\', \'\', 180)',
		'(\'icon_fight\', \'images/icons/icon19.gif\', \'\', \'\', 190)',
		'(\'icon_loot\', \'images/icons/icon20.gif\', \'\', \'\', 200)',
		'(\'icon_picture\', \'images/icons/icon21.gif\', \'auth_mod\', \'\', 210)',
		'(\'icon_calendar\', \'images/icons/icon22.gif\', \'auth_mod\', \'\', 220)',
	);
	$db->sql_stack_insert(ICONS_TABLE, false, __LINE__, __FILE__);

	$parms['cti'] = true;
	next_step();
}
if ( !empty($parms['cti']) )
{
	$page->output('CH_db_topic_icons_done');
}

// populate topic attributes table
if ( step() == 'CH_topic_attributes' )
{
	$sql = 'TRUNCATE TABLE ' . TOPICS_ATTR_TABLE;
	$db->sql_query($sql, false, __LINE__, __FILE__);
	$db->sql_stack_reset();
	$db->sql_stack_fields = 'attr_name, attr_fname, attr_fimg, attr_tname, attr_timg, attr_order, attr_field, attr_cond, attr_value, attr_auth';
	$db->sql_stack_values = array(
		'(\'Topic_Moved\', \'Topic_Moved\', \'folder_moved\', \'Topic_Moved\', \'\', 80, \'topic_moved_id\', \'GT\', 0, \'\')',
		'(\'Topic_Locked\', \'Topic_locked\', \'folder_locked\', \'Topic_Locked\', \'topic_locked_tiny\', 30, \'topic_status\', \'GT\', 0, \'\')',
		'(\'Topic_Global_Announcement\', \'Topic_Global_Announcement\', \'folder_global\', \'Post_Global_Announcement\', \'\', 70, \'topic_type\', \'GE\', 3, \'\')',
		'(\'Topic_Announcement\', \'Topic_Announcement\', \'folder_announce\', \'Post_Announcement\', \'\', 60, \'topic_type\', \'EQ\', 2, \'\')',
		'(\'Topic_Sticky\', \'Topic_Sticky\', \'folder_sticky\', \'Post_Sticky\', \'\', 50, \'topic_type\', \'EQ\', 1, \'\')',
		'(\'Topic_Poll\', \'Topic_Poll\', \'\', \'Topic_Poll\', \'topic_poll_tiny\', 20, \'topic_vote\', \'GT\', 0, \'\')',
		'(\'Topic_Attached\', \'Topic_Attached\', \'\', \'Topic_Attached\', \'\', 10, \'topic_attachment\', \'GT\', 0, \'\')',
		'(\'Topic_calendar\', \'Topic_calendar\', \'folder_calendar\', \'Topic_calendar\', \'topic_calendar_tiny\', 40, \'topic_calendar_time\', \'GT\', 0, \'\')',
	);
	$db->sql_stack_insert(TOPICS_ATTR_TABLE, false, __LINE__, __FILE__);
	$parms['cta'] = true;
	next_step();
	$page->loop();
}
if ( !empty($parms['cta']) )
{
	$page->output('CH_db_topics_attribute_done');
}

// create forums with cats & reorder all
if ( step() == 'CH_categories' )
{
	// identify the fields from a previous version
	$sql = 'SELECT cat_main
				FROM ' . CATEGORIES_TABLE . '
				LIMIT 1';
	$cat_main_id = $db->sql_query($sql, false, __LINE__, __FILE__, false) ? true : false;
	$sql = 'SELECT cat_main_type
				FROM ' . CATEGORIES_TABLE . '
				LIMIT 1';
	$cat_main_type = $db->sql_query($sql, false, __LINE__, __FILE__, false) ? true : false;
	$sql = 'SELECT main_type
				FROM ' . FORUMS_TABLE . '
				LIMIT 1';
	$forum_main_type = $db->sql_query($sql, false, __LINE__, __FILE__, false) ? true : false;

	// update the forum type in forums table
	$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET forum_type = \'' . POST_FORUM_URL . '\'';
	$db->sql_query($sql, false, __LINE__, __FILE__);

	$fields = array(
		'forum_type' => POST_LINK_URL,
		'forum_link_start' => empty($config->data['board_startdate']) ? time() : intval($config->data['board_startdate']),
	);
	$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET ' . $db->sql_fields('update', $fields) . '
				WHERE (forum_link <> \'\' AND forum_link IS NOT NULL)';
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// get last forum id
	$sql = 'SELECT MAX(forum_id) as last_forum_id
				FROM ' . FORUMS_TABLE;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	$last_forum_id = intval($row['last_forum_id']);

	// init the tree
	$tree = array();

	// read forums
	$sql = 'SELECT *
				FROM ' . FORUMS_TABLE . '
				ORDER BY forum_order';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		$main_id = intval($row['cat_id']);
		$main_type = $forum_main_type && !empty($main_id) ? $row['main_type'] : POST_CAT_URL;
		$tree[POST_FORUM_URL][ intval($row['forum_id']) ] = array('forum_id' => $row['forum_id'], 'main_type' => $main_type, 'main_id' => $main_id, 'order' => $row['forum_order']);
	}
	$db->sql_freeresult($result);

	// read categories
	$sql = 'SELECT *
				FROM ' . CATEGORIES_TABLE . '
				ORDER BY cat_order';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$db->sql_stack_reset();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$last_forum_id++;
		$main_id = $cat_main_id ? intval($row['cat_main']) : 0;
		$main_type = $cat_main_type && !empty($main_id) ? $row['cat_main_type'] : POST_CAT_URL;
		$tree[POST_CAT_URL][ intval($row['cat_id']) ] = array('forum_id' => $last_forum_id, 'main_type' => $main_type, 'main_id' => $main_id, 'order' => $row['cat_order']);

		// create the forum with the cat
		$fields = array(
			'forum_id' => $last_forum_id,
			'forum_name' => $row['cat_title'],
			'forum_main' => 0,
			'forum_type' => POST_CAT_URL,
			'forum_order' => 0,
		);
		$db->sql_stack_statement($fields);
	}
	$db->sql_freeresult($result);
	$db->sql_stack_insert(FORUMS_TABLE, false, __LINE__, __FILE__);

	// now we have the cats and the forums, get all parent ids
	$subs = array();
	if ( !empty($tree) )
	{
		foreach ( $tree as $type => $tdata )
		{
			if ( !empty($tdata) )
			{
				foreach ( $tdata as $key => $data )
				{
					$parent_id = !empty($data['main_id']) && isset($tree[ $data['main_type'] ][ $data['main_id'] ]) ? intval($tree[ $data['main_type'] ][ $data['main_id'] ]['forum_id']) : 0;
					if ( !isset($subs[$parent_id]) )
					{
						$subs[$parent_id] = array();
					}
					$subs[$parent_id][] = $data['forum_id'];
					$order[$parent_id][] = $data['order'];
				}
			}
		}
	}
	if ( !empty($subs) )
	{
		foreach ( $subs as $parent_id => $sub_ids )
		{
			if ( !empty($sub_ids) )
			{
				array_multisort($order[$parent_id], $subs[$parent_id]);
				$subs[$parent_id] = array_values($subs[$parent_id]);
			}
		}
	}

	// reorder all of this
	function build_tree($cur_id=0, $parent_id=0)
	{
		global $tree, $subs;

		// add the level
		if ( !empty($cur_id) )
		{
			$tree[] = array('id' => $cur_id, 'main' => $parent_id);
		}
		for ( $i = 0; $i < count($subs[$cur_id]); $i++ )
		{
			build_tree($subs[$cur_id][$i], $cur_id);
		}
	}
	$tree = array();
	build_tree();
	unset($subs);

	// now we can update the whole tree
	if ( $count_tree = count($tree) )
	{
		$last_order = 0;
		for ( $i = 0; $i < $count_tree; $i++ )
		{
			$last_order += 10;
			$fields = array(
				'forum_main' => $tree[$i]['main'],
				'forum_order' => $last_order,
			);
			$sql = 'UPDATE ' . FORUMS_TABLE . '
						SET ' . $db->sql_fields('update', $fields) . '
						WHERE forum_id = ' . intval($tree[$i]['id']);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}
	unset($tree);

	// recache all
	$forums = new forums();
	$forums->read(true);
	unset($forums);

	// ok, go next
	$parms['chcat'] = true;
	next_step();
	$page->loop();
}
if ( !empty($parms['chcat']) )
{
	$page->output('CH_db_categories_done');
}

// synchronise topics
if ( step() == 'CH_sync_topics' )
{
	$sql = 'SELECT t.topic_id, t.topic_type, t.topic_time, t.topic_title, fp.post_id AS fp_post_id, fp.post_username AS first_username, lp.post_id AS lp_post_id, lp.poster_id AS last_poster, lp.post_username AS last_username, lp.post_time AS last_time
				FROM ' . TOPICS_TABLE . ' t
					LEFT JOIN ' . POSTS_TABLE . ' fp ON fp.post_id = t.topic_first_post_id
					LEFT JOIN ' . POSTS_TABLE . ' lp ON lp.post_id = t.topic_last_post_id
				WHERE t.topic_last_time = 0
					AND t.topic_moved_id = 0';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$remaining = $db->sql_numrows($result);
	$parms['tt'] = max(intval($parms['tt']), $remaining + 1);
	$percent_done = empty($remaining) ? 100 : 100 - round(doubleval($remaining * 100) / ($parms['tt'] - 1));
	if ( $remaining >= ROWS_A_TURN )
	{
		// send percent box
		percent_box(sprintf($page->lang('CH_db_topics_percent_sync'), $parms['tt'] - 1 - $remaining, $parms['tt'] - 1), $percent_done);
	}

	$i = 0;
	while ( ($row = $db->sql_fetchrow($result)) && ($i < ROWS_A_TURN) )
	{
		$deleted = false;
		$fields = array(
			'topic_first_username' => $row['first_username'],
			'topic_last_poster' => intval($row['last_poster']),
			'topic_last_username' => $row['last_username'],
			'topic_last_time' => intval($row['last_time']),
		);
		if ( $row['topic_type'] == POST_ANNOUNCE )
		{
			$fields += array(
				'topic_duration' => intval($row['topic_time']),
			);
		}
		if ( !intval($row['fp_post_id']) )
		{
			$sql = 'SELECT post_id, poster_id, post_username, post_time
						FROM ' . POSTS_TABLE . '
						WHERE topic_id = ' . intval($row['topic_id']) . '
						ORDER BY post_id
						LIMIT 1';
			$result2 = $db->sql_query($sql, false, __LINE__, __FILE__);
			$prow = $db->sql_fetchrow($result2);
			$db->sql_freeresult($result2);

			// ok, the topic wasn't synchronized
			$deleted = !$prow;
			if ( !$deleted )
			{
				$fields = array_merge($fields, array(
					'topic_first_post_id' => intval($prow['post_id']),
					'topic_poster' => intval($prow['poster_id']),
					'topic_first_username' => $prow['post_username'],
				));
			}
		}
		if ( !$deleted && !intval($row['lp_post_id']) )
		{
			$sql = 'SELECT post_id, poster_id, post_username, post_time
						FROM ' . POSTS_TABLE . '
						WHERE topic_id = ' . intval($row['topic_id']) . '
						ORDER BY post_id DESC
						LIMIT 1';
			$result2 = $db->sql_query($sql, false, __LINE__, __FILE__);
			$prow = $db->sql_fetchrow($result2);
			$db->sql_freeresult($result2);

			// ok, the topic was definitivaly not synchronized
			$deleted = !$prow;
			if ( !$deleted )
			{
				$fields = array_merge($fields, array(
					'topic_last_post_id' => intval($prow['post_id']),
					'topic_last_poster' => intval($prow['poster_id']),
					'topic_last_username' => $prow['post_username'],
					'topic_last_time' => intval($prow['post_time']),
				));
			}
		}
		if ( $deleted )
		{
			// change the topic to a ghost one
			$fields = array(
				'topic_moved_id' => 1,
				'topic_title' => substr('[Ghost] ' . $row['topic_title'], 0, 255),
			);
		}
		$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET ' . $db->sql_fields('update', $fields) . '
					WHERE topic_id = ' . $row['topic_id'];
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$i++;
	}
	$db->sql_freeresult($result);
	$remaining -= ROWS_A_TURN;
	if ( $remaining > 0 )
	{
		$page->loop($parms);
	}
	next_step();

	// one last turn to reset the probable time overflow
	$page->loop();
}
if ( !empty($parms['tt']) )
{
	$page->output(sprintf($page->lang('CH_db_topics_sync'), $parms['tt'] - 1));
}

// synchronise forums & posts count
if ( step() == 'CH_sync_forums' )
{
	// read forum ids
	$sql = 'SELECT forum_id, forum_topics, forum_posts
				FROM ' . FORUMS_TABLE;
	$result = $db->sql_query($sql, false, __LINE__, __FILE);
	$total_topics = $total_posts = 0;
	$forums = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$forums[] = intval($row['forum_id']);
		$total_topics += intval($row['forum_topics']);
		$total_posts += intval($row['forum_posts']);
	}

	// store the posts & topics counts
	$config->set('stat_total_topics', $total_topics);
	$config->set('stat_total_posts', $total_posts);

	// synchronise last post data
	$count_forums = count($forums);
	for ( $i = 0; $i < $count_forums; $i++ )
	{
		$sql = 'SELECT t.topic_title, t.topic_last_post_id, t.topic_last_poster, t.topic_last_username, t.topic_last_time, u.username
					FROM ' . TOPICS_TABLE . ' t
						LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t.topic_last_poster
					WHERE forum_id = ' . $forums[$i] . '
					ORDER BY t.topic_last_post_id DESC
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$fields = array(
			'forum_last_title' => $row['topic_title'],
			'forum_last_poster' => intval($row['topic_last_poster']),
			'forum_last_username' => (($row['topic_last_poster'] == ANONYMOUS) || empty($row['username'])) ? $row['topic_last_username'] : $row['username'],
			'forum_last_time' => intval($row['topic_last_time']),
		);
		$sql = 'UPDATE ' . FORUMS_TABLE . '
					SET ' . $db->sql_fields('update', $fields) . '
					WHERE forum_id = ' . $forums[$i];
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	next_step();
	$page->loop();
}
if ( !empty($parms['tf']) )
{
	$page->output(sprintf($page->lang('CH_db_forums_sync'), $parms['tf']));
}

// ----------------------------------------------------
//
// from here we resume on both upgrade and new installs
//
// ----------------------------------------------------
if ( step() == 'CH_resume' )
{
	next_step();
	$config->read(true);
}

// check anonymous user
if ( step() == 'CH_anon_user' )
{
	// verify anonymous user
	$sql = 'SELECT user_id
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . ANONYMOUS;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	if ( !($row = $db->sql_fetchrow($result)) )
	{
		// user anonymous is missing
		$fields = anonymous();
		$sql = 'INSERT INTO ' . USERS_TABLE . '
					(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$parms['anon'] = true;
	}
	$db->sql_freeresult($result);
	next_step();
}
if ( $parms['anon'] )
{
	$page->output('CH_anonymous_user_created');
}

// orphean groups : individual groups that are not linked to a user
if ( step() == 'CH_orphean_groups' )
{
	// get unlinked to users groups
	$sql = 'SELECT DISTINCT ug.group_id
				FROM ' . USER_GROUP_TABLE . ' ug
					LEFT JOIN ' . USERS_TABLE . ' u
						ON ug.user_id = u.user_id
				WHERE u.user_id IS NULL';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$group_ids = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$group_ids[] = $row['group_id'];
	}
	$db->sql_freeresult($result);

	// delete them
	$unlinked = 0;
	if ( !empty($group_ids) )
	{
		// delete individual groups not linked to a user
		$sql = 'DELETE FROM ' . GROUPS_TABLE . '
					WHERE group_single_user = 1
						AND group_id IN(' . implode(', ', $group_ids) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$unlinked += $db->sql_affectedrows();
	}
	unset($group_ids);

	// delete empty links
	$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
				WHERE user_id = 0 OR user_id IS NULL
					OR group_id = 0 OR group_id IS NULL';
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// delete unlinked individual groups
	$sql = 'SELECT g.group_id
				FROM ' . GROUPS_TABLE . ' g
					LEFT JOIN ' . USER_GROUP_TABLE . ' ug
						ON ug.group_id = g.group_id
				WHERE g.group_single_user = 1
					AND ug.group_id IS NULL';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$group_ids = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$group_ids[] = intval($row['group_id']);
	}
	$db->sql_freeresult($result);
	if ( $parms['og'] = count($group_ids) )
	{
		$sql = 'DELETE FROM ' . GROUPS_TABLE . '
					WHERE group_id IN(' . implode(', ', $group_ids) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$unlinked += $db->sql_affectedrows();
	}
	$parms['og'] += $unlinked + 1;
	next_step();
}
if ( !empty($parms['og']) )
{
	$page->output(sprintf($page->lang('CH_orphean_groups_deleted'), $parms['og'] - 1));
}

// surnumerous membership
if ( step() == 'CH_surnumerous_membership' )
{
	$rows_a_turn = ceil(ROWS_A_TURN / 2);
	$sql = 'SELECT user_id, group_id, COUNT(user_id) AS count_user_id, MAX(user_pending) AS max_user_pending
				FROM ' . USER_GROUP_TABLE . '
				GROUP BY user_id, group_id
				HAVING COUNT(user_id) > 1';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);

	// count
	$remaining = $db->sql_numrows($result);
	$parms['tms'] = max(intval($parms['tms']), $remaining + 1);
	$percent_done = empty($remaining) ? 100 : 100 - round(doubleval($remaining * 100) / ($parms['tms'] - 1));
	if ( $remaining >= ROWS_A_TURN )
	{
		percent_box(sprintf($page->lang('CH_surnumerous_membership_percent'), $parms['tms'] - 1 - $remaining, $parms['tms'] - 1), $percent_done);
	}

	// read
	$links = array();
	$i = 0;
	while ( ($row = $db->sql_fetchrow($result)) && ($i < $rows_a_turn) )
	{
		$links[] = array('u' => intval($row['user_id']), 'g' => intval($row['group_id']), 'p' => intval($row['max_user_pending']));
		$i++;
	}
	$db->sql_freeresult($result);
	if ( $count_links = count($links) )
	{
		for ( $i = 0; $i < $count_links; $i++ )
		{
			$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
						WHERE user_id = ' . $links[$i]['u'] . '
							AND group_id = ' . $links[$i]['g'];
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$fields = array(
				'user_id' => $links[$i]['u'],
				'group_id' => $links[$i]['g'],
				'user_pending' => $links[$i]['p'],
			);
			$sql = 'INSERT INTO ' . USER_GROUP_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}
	$remaining -= $rows_a_turn;
	if ( $remaining > 0 )
	{
		$page->loop($parms);
	}
	next_step();
	$page->loop();
}
if ( !empty($parms['tms']) )
{
	$page->output(sprintf($page->lang('CH_surnumerous_membership'), $parms['tms'] - 1));
}

// get user having more than one individual groups
if ( step() == 'CH_individual_groups_surnumerous' )
{
	$rows_a_turn = ceil(ROWS_A_TURN / 10);
	$sql = 'SELECT ug.user_id, MIN(ug.group_id) AS lower_group_id, SUM(g.group_single_user) AS total_single
				FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
				WHERE g.group_id = ug.group_id
					AND g.group_single_user = 1
				GROUP BY ug.user_id
				HAVING SUM(g.group_single_user) > 1';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);

	// count
	$remaining = $db->sql_numrows($result);
	$parms['tgs'] = max(intval($parms['tgs']), $remaining + 1);
	$percent_done = empty($remaining) ? 100 : 100 - round(doubleval($remaining * 100) / ($parms['tgs'] - 1));
	if ( $remaining >= $rows_a_turn )
	{
		percent_box(sprintf($page->lang('CH_individual_groups_surnumerous_percent'), $parms['tgs'] - 1 - $remaining, $parms['tgs'] - 1), $percent_done);
	}

	// read
	$user_ids = array();
	$i = 0;
	while ( ($row = $db->sql_fetchrow($result)) && ($i < $rows_a_turn) )
	{
		$user_ids[ intval($row['user_id']) ] = intval($row['lower_group_id']);
		$i++;
	}
	$db->sql_freeresult($result);
	if ( !empty($user_ids) )
	{
		$group_ids = array();
		foreach ( $user_ids as $user_id => $group_id )
		{
			// read groups membership
			$sql = 'SELECT ug.group_id
						FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
						WHERE ug.user_id = ' . $user_id . '
							AND ug.group_id <> ' . $group_id . '
							AND g.group_id = ug.group_id
							AND g.group_single_user = 1';
			$result = $db->sql_query($sql, false, __LINE__, __FILE__);
			while ( $row = $db->sql_fetchrow($result) )
			{
				$group_ids[] = intval($row['group_id']);
			}
			$db->sql_freeresult($result);
		}
		if ( !empty($group_ids) )
		{
			// delete membership
			$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
						WHERE group_id IN(' . implode(', ', $group_ids) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);

			// delete groups
			$sql = 'DELETE FROM ' . GROUPS_TABLE . '
						WHERE group_id IN(' . implode(', ', $group_ids) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}
	$remaining -= $rows_a_turn;
	if ( $remaining > 0 )
	{
		$page->loop($parms);
	}
	next_step();
	$page->loop();
}
if ( !empty($parms['tgs']) )
{
	$page->output(sprintf($page->lang('CH_individual_groups_surnumerous'), $parms['tgs'] - 1));
}

// individual groups missing
if ( step() == 'CH_individual_groups' )
{
	$rows_a_turn = ROWS_A_TURN;
	$sql = 'SELECT u.user_id, SUM(g.group_single_user) AS total_single
				FROM ' . USERS_TABLE . ' u 
					LEFT JOIN ' . USER_GROUP_TABLE . ' ug
						ON ug.user_id = u.user_id
					LEFT JOIN ' . GROUPS_TABLE . ' g
						ON g.group_id = ug.group_id
							AND g.group_single_user = 1
				GROUP BY u.user_id
				HAVING SUM(g.group_single_user) IS NULL';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);

	// count
	$remaining = $db->sql_numrows($result);
	$parms['tg'] = max(intval($parms['tg']), $remaining + 1);
	$percent_done = empty($remaining) ? 100 : 100 - round(doubleval($remaining * 100) / ($parms['tg'] - 1));
	if ( $remaining >= $rows_a_turn )
	{
		percent_box(sprintf($page->lang('CH_individual_groups_percent'), $parms['tg'] - 1 - $remaining, $parms['tg'] - 1), $percent_done);
	}

	// read
	$user_ids = array();
	$i = 0;
	while ( ($row = $db->sql_fetchrow($result)) && ($i < $rows_a_turn) )
	{
		$user_ids[] = intval($row['user_id']);
		$i++;
	}
	$db->sql_freeresult($result);
	if ( $count_user_ids = count($user_ids) )
	{
		for ( $i = 0; $i < $count_user_ids; $i++ )
		{
			// create groups
			$fields = array(
				'group_name' => ($user_ids[$i] == ANONYMOUS) ? 'Group_anonymous' : '',
				'group_description' => ($user_ids[$i] == ANONYMOUS) ? 'Group_anonymous_desc' : 'Personal User',
				'group_status' => ($user_ids[$i] == ANONYMOUS) ? GROUP_SYSTEM : GROUP_STANDARD,
				'group_single_user' => 1,
				'group_moderator' => 0,
				'group_style' => 0,
			);
			$sql = 'INSERT INTO ' . GROUPS_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$group_id = $db->sql_nextid();

			// create user group link
			$fields = array(
				'user_id' => $user_ids[$i],
				'group_id' => $group_id,
				'user_pending' => 0,
			);
			$sql = 'INSERT INTO ' . USER_GROUP_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}
	$remaining -= $rows_a_turn;
	if ( $remaining > 0 )
	{
		$page->loop($parms);
	}
	next_step();

	// one last turn to reset the probable time overflow
	$page->loop();
}
if ( !empty($parms['tg']) )
{
	$page->output(sprintf($page->lang('CH_individual_groups_created'), $parms['tg'] - 1));
}

// reset user_id cache on groups & reclaim board founder
if ( step() == 'CH_founder_req' )
{
	// reset user_id cache on groups
	$sql = 'UPDATE ' . GROUPS_TABLE . '
				SET group_user_id = 0';
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// reclaim board founder
	$parms['fndreq'] = true;
	next_step();
	$page->loop();
}

// create/recreate system groups
if ( step() == 'CH_system_groups' )
{
	$sys_groups = array(
		'group_founder' => array('group_id' => 0, 'group_name' => 'Board_founder'),
		'group_admin' => array('group_id' => 0, 'group_name' => 'Group_admin'),
		'group_registered' => array('group_id' => 0, 'group_name' => 'Group_registered'),
		'group_anonymous' => array('group_id' => 0, 'group_name' => 'Group_anonymous'),
		'group_bots' => array('group_id' => 0, 'group_name' => 'Group_bots'),
	);

	// search the groups in config table
	$sql = 'SELECT config_name, config_value
				FROM ' . CONFIG_TABLE . '
				WHERE config_name IN(\'' . implode('\', \'', array_keys($sys_groups)) . '\')';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		$sys_groups[ $row['config_name'] ]['group_id'] = intval($row['config_value']);
	}
	$db->sql_freeresult($result);

	// get anonymous group
	$sql = 'SELECT ug.group_id
				FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
				WHERE ug.user_id = ' . ANONYMOUS . '
					AND g.group_id = ug.group_id
					AND g.group_single_user = 1';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	if ( $row = $db->sql_fetchrow($result) )
	{
		$sys_groups['group_anonymous']['group_id'] = intval($row['group_id']);
	}
	else
	{
		$page->critical_error('CH_anonymous_group_missing');
	}
	$db->sql_freeresult($result);

	// check missing groups reading groups table on name
	$group_names = array();
	foreach ( $sys_groups as $config_name => $data )
	{
		if ( empty($data['group_id']) )
		{
			$group_names[ $data['group_name'] ] = $config_name;
		}
	}
	if ( !empty($group_names) )
	{
		$sql = 'SELECT group_id, group_name
					FROM ' . GROUPS_TABLE . '
					WHERE group_name IN(\'' . implode('\', \'', array_keys($group_names)) . '\')
						AND group_status = ' . GROUP_SYSTEM;
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sys_groups[ $group_names[ $row['group_name'] ] ]['group_id'] = intval($row['group_id']);
		}
		$db->sql_freeresult($result);
	}

	// create or update groups
	$config->begin_transaction();
	foreach ( $sys_groups as $config_name => $data )
	{
		switch ( $config_name )
		{
			// update anonymous group
			case 'group_anonymous':
				$fields = array(
					'group_name' => 'Group_anonymous',
					'group_description' => 'Group_anonymous_desc',
					'group_type' => GROUP_OPEN,
					'group_status' => GROUP_SYSTEM,
					'group_moderator' => 0,
					'group_single_user' => 1,
					'group_user_id' => ANONYMOUS,
					'group_style' => 0,
					'group_unread_date' => 0,
				);
				$sql = 'UPDATE ' . GROUPS_TABLE . '
							SET ' . $db->sql_fields('update', $fields) . '
							WHERE group_id = ' . $data['group_id'];
				$db->sql_query($sql, false, __LINE__, __FILE__);
				break;

			// update or create other groups
			default:
				$fields = array(
					'group_name' => $data['group_name'],
					'group_description' => $data['group_name'] . '_desc',
					'group_type' => GROUP_CLOSED,
					'group_status' => GROUP_SYSTEM,
					'group_moderator' => 0,
					'group_single_user' => 0,
					'group_user_id' => 0,
				);
				if ( $config_name == 'group_founder' )
				{
					$fields['group_moderator'] = $founder_id;
				}
				if ( empty($data['group_id']) )
				{
					$fields += array(
						'group_style' => 0,
						'group_unread_date' => 0,
					);
					$sql = 'INSERT INTO ' . GROUPS_TABLE . '
								(' . $db->sql_fields('fields', $fields) . ') VALUES (' . $db->sql_fields('values', $fields) . ')';
					$db->sql_query($sql, false, __LINE__, __FILE__);
					$sys_groups[$config_name]['group_id'] = $db->sql_nextid();
				}
				else
				{
					$sql = 'UPDATE ' . GROUPS_TABLE . '
								SET ' . $db->sql_fields('update', $fields) . '
								WHERE group_id = ' . $data['group_id'];
					$db->sql_query($sql, false, __LINE__, __FILE__);
				}
				break;
		}
		$config->set($config_name, $sys_groups[$config_name]['group_id'], true);
	}
	$config->end_transaction();

	// populate the founder group
	$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
				WHERE group_id = ' . intval($sys_groups['group_founder']['group_id']) . '
					AND user_id = ' . $founder_id;
	$db->sql_query($sql, false, __LINE__, __FILE__);

	$fields = array(
		'group_id' => $sys_groups['group_founder']['group_id'],
		'user_id' => $founder_id,
		'user_pending' => false,
	);
	$sql = 'INSERT INTO ' . USER_GROUP_TABLE . '
				(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
	$db->sql_query($sql, false, __LINE__, __FILE__, false);

	// read the current admin groups
	if ( !empty($parms['chpv']) )
	{
		$sql = 'SELECT DISTINCT user_id
					FROM ' . USER_GROUP_TABLE . '
					WHERE group_id IN(' . $sys_groups['group_admin']['group_id'] . ', ' . $sys_groups['group_founder']['group_id'] . ')
						AND user_pending <> 1
					GROUP BY user_id';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$user_ids = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['user_id'] != ANONYMOUS )
			{
				$user_ids[] = intval($row['user_id']);
			}
		}
		$db->sql_freeresult($result);
		if ( !empty($user_ids) )
		{
			// update level
			$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_level = ' . ADMIN . '
						WHERE user_id IN(' . implode(', ', $user_ids) . ')
							AND user_active = ' . TRUE;
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}

	// clear the admin group
	$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
				WHERE group_id = ' . $sys_groups['group_admin']['group_id'];
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// populate the admin group
	$sql = 'SELECT user_id
				FROM ' . USERS_TABLE . '
				WHERE user_level = ' . ADMIN . '
					AND user_active = 1';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		$fields = array(
			'group_id' => $sys_groups['group_admin']['group_id'],
			'user_id' => intval($row['user_id']),
			'user_pending' => 0,
		);
		$sql = 'INSERT INTO ' . USER_GROUP_TABLE . '
					(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__, false);
	}
	$db->sql_freeresult($result);

	// clear the registered group
	$sql = 'DELETE FROM ' . USER_GROUP_TABLE . '
				WHERE group_id = ' . $sys_groups['group_registered']['group_id'];
	$db->sql_query($sql, false, __LINE__, __FILE__);

	// next
	next_step();
}
$page->output('CH_system_groups_done');

// link users to individual groups
if ( step() == 'CH_user_groups_sync' )
{
	$rows_a_turn = ceil(ROWS_A_TURN / 4);
	$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . '
				WHERE group_user_id = 0
					AND group_single_user = 1';
	// count
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$remaining = $db->sql_numrows($result);
	$db->sql_freeresult($result);

	$parms['ti'] = max(intval($parms['ti']), $remaining + 1);
	$percent_done = empty($remaining) ? 100 : 100 - round(doubleval($remaining * 100) / ($parms['ti'] - 1));
	if ( $remaining >= $rows_a_turn )
	{
		percent_box(sprintf($page->lang('CH_user_groups_percent'), $parms['ti'] - 1 - $remaining, $parms['ti'] - 1), $percent_done);
	}

	// read individual groups
	$sql = 'SELECT ug.user_id, ug.group_id
				FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
				WHERE ug.group_id = g.group_id
					AND g.group_user_id = 0
					AND g.group_single_user = 1
				LIMIT ' . $rows_a_turn;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$group_ids = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$group_ids[ intval($row['group_id']) ] = intval($row['user_id']);
	}
	$db->sql_freeresult($result);

	// update
	if ( !empty($group_ids) )
	{
		foreach ( $group_ids as $group_id => $user_id )
		{
			$sql = 'UPDATE ' . GROUPS_TABLE . '
						SET group_user_id = ' . intval($user_id) . '
						WHERE group_id = ' . intval($group_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
	}
	$remaining -= $rows_a_turn;
	if ( $remaining > 0 )
	{
		$page->loop($parms);
	}
	next_step();

	// one last turn to reset the probable time overflow
	$page->loop();
}
if ( !empty($parms['ti']) )
{
	$page->output(sprintf($page->lang('CH_user_groups_created'), $parms['ti'] - 1));
}

// synchronise users stats and data
if ( step() == 'CH_sync_users' )
{
	// count users
	$sql = 'SELECT COUNT(user_id) AS count_user_id
				FROM ' . USERS_TABLE;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$count_users = ($row = $db->sql_fetchrow($result)) ? max(0, intval($row['count_user_id']) -1) : 0;
	$db->sql_freeresult($result);

	// update last user stats
	if ( $count_users )
	{
		$sql = 'SELECT user_id, username
					FROM ' . USERS_TABLE . '
					WHERE user_id <> ' . ANONYMOUS . '
					ORDER BY user_id DESC
					LIMIT 1';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
	}

	$config->set('stat_total_users', $count_users);
	$config->set('stat_last_user', $count_users ? intval($row['user_id']) : 0);
	$config->set('stat_last_username', $count_users ? $row['username'] : '');
	$config->end_transaction();

	// populate the bots group
	$bots = new bots($requester, $config->data['group_bots']);
	$bots->read(true);
	unset($bots);

	$parms['tu'] = intval($db->sql_affectedrows($result));
	next_step();
}
if ( !empty($parms['tu']) )
{
	$page->output(sprintf($page->lang('CH_db_users_sync'), $parms['tu']));
}

// recall unreads topics
if ( step() == 'CH_copy_unreads' )
{
	if ( empty($parms['chpv']) || !in_array(substr($parms['chpv'], 0, 5), array('2.1.0', '2.1.1', '2.1.2')) )
	{
		next_step();
		$page->loop();
	}

	// copy unreads from users table to individual groups
	$rows_a_turn = ceil(ROWS_A_TURN / 2);
	$sql = 'SELECT user_id, user_unread_date, user_unread_topics
				FROM ' . USERS_TABLE . '
				WHERE user_unread_date <> 0
					AND user_unread_topics IS NOT NULL
					AND user_unread_topics <> \'\'';
	if ( !($result = $db->sql_query($sql, false, __LINE__, __FILE__, false)) )
	{
		next_step();
		$page->loop();
	}

	// count
	$remaining = $db->sql_numrows($result);
	$parms['tur'] = max(intval($parms['tur']), $remaining + 1);
	$percent_done = empty($remaining) ? 100 : 100 - round(doubleval($remaining * 100) / ($parms['tur'] - 1));
	if ( $remaining >= $rows_a_turn )
	{
		percent_box(sprintf($page->lang('CH_copy_unreads_percent'), $parms['tur'] - 1 - $remaining, $parms['tur'] - 1), $percent_done);
	}

	// read
	$user_ids = array();
	$i = 0;
	while ( ($row = $db->sql_fetchrow($result)) && ($i < $rows_a_turn) )
	{
		$user_ids[ intval($row['user_id']) ] = array('group_unread_date' => intval($row['user_unread_date']), 'group_unread_topics' => $row['user_unread_topics']);
		$i++;
	}
	$db->sql_freeresult($result);

	// update groups
	if ( !empty($user_ids) )
	{
		foreach ( $user_ids as $user_id => $fields )
		{
			$sql = 'UPDATE ' . GROUPS_TABLE . '
						SET ' . $db->sql_fields('update', $fields) . '
						WHERE group_user_id = ' . intval($user_id);
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}

		// mark users
		$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_unread_date = 0, user_unread_topics = \'\'
					WHERE user_id IN(' . implode(', ', array_keys($user_ids)) . ')';
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	// all the data has been copied : drop the fields
	if ( empty($user_ids) )
	{
		if ( !($sql_layer = $db->get_layer()) )
		{
			$page->critical_error('CH_db_not_supported');
		}
		$sqls = array();
		switch ( $sql_layer['SCHEMA'] )
		{
			case 'mysql':
				$sqls = array(
					'ALTER TABLE ' . USERS_TABLE . ' DROP user_unread_date',
					'ALTER TABLE ' . USERS_TABLE . ' DROP user_unread_topics',
				);
				break;
			case 'postgres':
				$sqls = array(
					'ALTER TABLE ' . USERS_TABLE . ' DROP COLUMN user_unread_date',
					'ALTER TABLE ' . USERS_TABLE . ' DROP COLUMN user_unread_topics',
				);
				break;
			case 'mssql':
				$sqls = array(
					'ALTER TABLE [' . USERS_TABLE . '] DROP [CONSTRAINT] DF_' . USERS_TABLE . '_user_unread_date',
					'ALTER TABLE [' . USERS_TABLE . '] DROP COLUMN user_unread_date',
					'ALTER TABLE [' . USERS_TABLE . '] DROP COLUMN user_unread_topics',
				);
				break;
		}
		$count_sqls = count($sqls);
		for ( $i = 0; $i < $count_sqls; $i++ )
		{
			$sql = $sqls[$i];
			if ( !$db->sql_query($sql, false, __LINE__, __FILE__, false) )
			{
				$parms['error_tur'] = true;
			}
		}
	}
	if ( empty($user_ids) )
	{
		next_step();
	}
	$page->loop();
}
if ( !empty($parms['tur']) )
{
	$page->output(sprintf($page->lang('CH_copy_unreads_done'), $parms['tur'] - 1));
}
if ( intval($parms['error_tur']) )
{
	$page->output('CH_copy_unreads_error');
}

// patch panels
if ( step() == 'CH_patch_panels' )
{
	// search for the ucp.confirm panel
	$ucp = false;
	$ucp_confirm = false;
	$sql = 'SELECT panel_id, panel_shortcut, panel_order, panel_main
				FROM ' . CP_PANELS_TABLE . '
				WHERE panel_shortcut IN(\'' . implode('\', \'', array('ucp', 'confirm')) . '\')
				ORDER BY panel_order';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( $row['panel_shortcut'] == 'ucp' )
		{
			$ucp = array('panel_id' => intval($row['panel_id']));
		}
		else if ( ($row['panel_shortcut'] == 'confirm') && $ucp && (intval($row['panel_main']) == $ucp['panel_id']) )
		{
			$ucp_confirm = array('panel_id' => intval($row['panel_id']), 'panel_order' => intval($row['panel_order']));
		}
	}
	$db->sql_freeresult($result);
	unset($ucp);
	if ( $ucp_confirm )
	{
		// delete the panel (the recache is done just after)
		$sql = 'DELETE FROM ' . CP_PANELS_TABLE . '
					WHERE panel_id = ' . intval($ucp_confirm['panel_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// renum other
		$sql = 'UPDATE ' . CP_PANELS_TABLE . '
					SET panel_order = panel_order - 10
					WHERE panel_order > ' . intval($ucp_confirm['panel_order']);
		$db->sql_query($sql, false, __LINE__, __FILE__);

		// delete auths (the auths_cache table is cleared at end of the install)
		$sql = 'DELETE FROM ' . AUTHS_TABLE . '
					WHERE obj_type = \'' . POST_PANELS_URL . '\'
						AND obj_id = ' . intval($ucp_confirm['panel_id']);
		$db->sql_query($sql, false, __LINE__, __FILE__);
	}

	// instantiate the acting user
	$sav_lang = $lang;
	$user = new user();
	$user->read($session->user_id);

	// patch the panels
	$cp_panels = new cp_panels($requester);
	$cp_panels->read(true);
	$cp_panels->patch(true);
	$parms['pp'] = true;

	// remove the acting user
	unset($user);
	$lang = $sav_lang;

	next_step();
}
if ( !empty($parms['pp']) )
{
	$page->output('CH_panels_patched');
}

// import panels auths (shouldn't be required as already done by the patch process)
if ( step() == 'CH_import_pgauths' )
{
	// read current panels auth defs
	$sql = 'SELECT auth_type, auth_name, auth_order, auth_title
				FROM ' . AUTHS_DEF_TABLE . '
				ORDER BY auth_type, auth_order';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$auths_def = array();
	$last_order = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$auths_def[ $row['auth_type'] ][ $row['auth_name'] ] = true;
		$last_order[ $row['auth_type'] ] = intval($row['auth_order']);
	}
	$db->sql_freeresult($result);

	// auths to add
	$auths_to_add = array();
	if ( !isset($auths_def[POST_PANELS_URL]['auth_manage']) )
	{
		$auths_to_add[POST_PANELS_URL]['auth_manage'] = true;
	}
	if ( !isset($auths_def[POST_PANELS_URL]['access']) )
	{
		$auths_to_add[POST_PANELS_URL]['access'] = true;
	}

	// get auths from panels
	$sql = 'SELECT DISTINCT panel_auth_type, panel_auth_name
				FROM ' . CP_PANELS_TABLE . '
				WHERE panel_auth_type <> \'\'
					AND panel_auth_name <> \'\'
				GROUP BY panel_auth_type, panel_auth_name';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( !isset($auths_def[ $row['panel_auth_type'] ][ $row['panel_auth_name'] ]) )
		{
			$auths_to_add[ $row['panel_auth_type'] ][ $row['panel_auth_name'] ] = true;
		}
	}
	$db->sql_freeresult($result);

	// get auths from fields (can only be groups type)
	$sql = 'SELECT field_attr
				FROM ' . CP_FIELDS_TABLE . '
				WHERE field_attr LIKE \'%field_auth%\'
					AND field_name <> \'\'';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	while ( $row = $db->sql_fetchrow($result) )
	{
		// unpack data
		$field = unserialize(stripslashes($row['field_attr']));

		// check auths
		if ( !empty($field['field_auth']) )
		{
			if ( is_array($field['field_auth']) )
			{
				$count_auths_names = count($field['field_auth']);
				for ( $i = 0; $i < $count_auths_names; $i++ )
				{
					if ( !isset($auths_def[POST_GROUPS_URL][ $field['field_auth'][$i] ]) )
					{
						$auths_to_add[POST_GROUPS_URL][ $field['field_auth'][$i] ] = true;
					}
				}
			}
			else
			{
				if ( !isset($auths_def[POST_GROUPS_URL][ $field['field_auth'] ]) )
				{
					$auths_to_add[POST_GROUPS_URL][ $field['field_auth'] ] = true;
				}
			}
		}
	}
	$db->sql_freeresult($result);

	// add the auths defs
	$db->sql_stack_reset();
	foreach ( $auths_to_add as $auth_type => $data )
	{
		if ( !isset($last_order[$auth_type]) )
		{
			$last_order[$auth_type] = 0;
		}
		if ( !empty($data) )
		{
			foreach ( $data as $auth_name => $dummy )
			{
				if ( !isset($auths_def[$auth_type][$auth_name]) )
				{
					$last_order[$auth_type] += 10;
					$fields = array(
						'auth_type' => $auth_type,
						'auth_name' => $auth_name,
						'auth_desc' => $auth_name,
						'auth_title' => false,
						'auth_order' => $last_order[$auth_type],
					);
					// prepare insert rows
					$db->sql_stack_statement($fields);
				}
			}
		}
	}
	if ( !empty($db->sql_stack_values) )
	{
		$db->sql_stack_insert(AUTHS_DEF_TABLE, false, __LINE__, __FILE__);
		$parms['ipa'] = true;
	}
	next_step();
	$page->loop();
}
if ( !empty($parms['ipa']) )
{
	$page->output('CH_panels_auths_def_added');
}

// import forums auths
if ( step() == 'CH_import_fauths' )
{
	// read current forum auth defs
	$sql = 'SELECT auth_name, auth_order, auth_title
				FROM ' . AUTHS_DEF_TABLE . '
				WHERE auth_type = \'' . POST_FORUM_URL . '\'
				ORDER BY auth_order';
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);
	$auths_def = array();
	$last_order = 0;
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( !$row['auth_title'] )
		{
			$auths_def[ $row['auth_name'] ] = true;
		}
		$last_order = intval($row['auth_order']);
	}
	$db->sql_freeresult($result);

	// get auths def from auth.php (original phpBB auths) and add the new that don't require phpBB forums table auth field
	$no_req_auths_def = array('auth_mod', 'auth_mod_display', 'auth_manage');
	$phpbb_auths_def = array_merge(get_forums_auths_def(), $no_req_auths_def);

	// create auths defs
	$count_phpbb_auths_def = count($phpbb_auths_def);
	$auth_names = array();
	$auth_fields = array();
	$db->sql_stack_reset();
	for ( $i = 0; $i < $count_phpbb_auths_def; $i++ )
	{
		$auth_name = $phpbb_auths_def[$i];
		if ( !isset($auths_def[$auth_name]) )
		{
			$last_order += 10;
			$fields = array(
				'auth_type' => POST_FORUM_URL,
				'auth_name' => $auth_name,
				'auth_desc' => $auth_name,
				'auth_title' => false,
				'auth_order' => $last_order,
			);
			$db->sql_stack_statement($fields);
			$auth_names[] = $auth_name;
			if ( !in_array($auth_name, $no_req_auths_def) )
			{
				$auth_fields[] = $auth_name;
			}
		}
	}
	if ( !empty($db->sql_stack_values) )
	{
		$db->sql_stack_insert(AUTHS_DEF_TABLE, false, __LINE__, __FILE__);
		$parms['ifad'] = true;
	}

	// set values
	if ( empty($parms['chpv']) && ($count_auth_names = count($auth_names)) )
	{
		// read authed groups
		$sql = 'SELECT *
					FROM ' . AUTH_ACCESS_TABLE . '
					ORDER BY forum_id';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$acls = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			for ( $i = 0; $i < $count_auth_names; $i++ )
			{
				$auth_name = $auth_names[$i];

				// adjust some auths
				if ( $auth_name == 'auth_mod_display' )
				{
					$row[$auth_name] = $row['auth_mod'];
				}
				if ( $row[$auth_name] )
				{
					if ( !isset($acls[ intval($row['forum_id']) ]) )
					{
						$acls[ $row['forum_id'] ] = array();
					}
					if ( !isset($acls[ intval($row['forum_id']) ][$auth_name]) )
					{
						$acls[ intval($row['forum_id']) ][$auth_name] = array();
					}
					$acls[ intval($row['forum_id']) ][$auth_name][] = intval($row['group_id']);
				}
			}
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT *
					FROM ' . FORUMS_TABLE;
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$db->sql_stack_reset();
		while ( $row = $db->sql_fetchrow($result) )
		{
			// check requirements
			for ( $i = 0; $i < $count_auth_names; $i++ )
			{
				switch ( $auth_names[$i] )
				{
					case 'auth_mod':
						$auth_req = AUTH_ACL;
						break;
					case 'auth_mod_display':
						$auth_req = AUTH_MOD;
						break;
					case 'auth_manage':
						$auth_req = AUTH_ADMIN;
						break;
					default:
						$auth_req = isset($row[ $auth_names[$i] ]) ? $row[ $auth_names[$i] ] : AUTH_ADMIN;
						break;
				}
				$group_ids = array();
				switch ( $auth_req )
				{
					case AUTH_ALL:
						$group_ids[] = intval($config->data['group_anonymous']);
					case AUTH_REG:
						$group_ids[] = intval($config->data['group_registered']);
						break;
					case AUTH_MOD:
					case AUTH_ACL:
						$auth_name = ($auth_req == AUTH_MOD) ? 'auth_mod' : $auth_names[$i];
						if ( !empty($acls[ intval($row['forum_id']) ][$auth_name]) )
						{
							$group_ids = $acls[ intval($row['forum_id']) ][$auth_name];
						}
						// we don't want to display admin as moderators
						if ( $auth_names[$i] == 'auth_mod_display' )
						{
							break;
						}
					case AUTH_ADMIN:
						$group_ids[] = intval($config->data['group_admin']);
						break;
				}

				// build the sql request
				if ( !empty($group_ids) )
				{
					$count_group_ids = count($group_ids);
					for ( $j = 0; $j < $count_group_ids; $j++ )
					{
						$fields = array(
							'group_id' => $group_ids[$j],
							'obj_type' => POST_FORUM_URL,
							'obj_id' => intval($row['forum_id']),
							'auth_name' => $auth_names[$i],
							'auth_value' => true,
						);
						$db->sql_stack_statement($fields);
					}
				}
			}

			// create the auths access
			if ( !empty($db->sql_stack_values) )
			{
				$db->sql_stack_insert(AUTHS_TABLE, false, __LINE__, __FILE__);
				$parms['ifav'] = true;
			}
		}
		$db->sql_freeresult($result);
	}

	next_step();
	$page->loop();
}
if ( !empty($parms['ifad']) )
{
	$page->output('CH_forum_auths_def_added');
}
if ( !empty($parms['ifav']) )
{
	$page->output('CH_forum_auths_values_added');
}

if ( step() == 'CH_ptifo' )
{
	// check if ptifo directory exists
	if ( @file_exists(phpbb_realpath($phpbb_root_path . 'templates/ptifo/ptifo.cfg')) )
	{
		// if it is an upgrade, don't touch the users settings
		if ( empty($parms['chpv']) )
		{
			$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_style = 0';
			$db->sql_query($sql, false, __LINE__, __FILE__);
		}
		$sql = 'SELECT themes_id
					FROM ' . THEMES_TABLE . '
					WHERE template_name = \'ptifo\'';
		$result = $db->sql_query($sql, false, __LINE__, __FILE__);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		if ( $row )
		{
			$ptifo_id = intval($row['themes_id']);
			$parms['ptifo'] = 1;
		}
		else
		{
			$fields = array(
				'template_name' => 'ptifo',
				'style_name' => 'ptifo',
				'images_pack' => '',
				'custom_tpls' => '',
				'head_stylesheet' => 'ptifo.css',
				'body_background' => '',
				'body_bgcolor' => '',
				'body_text' => '',
				'body_link' => '',
				'body_vlink' => '',
				'body_alink' => '',
				'body_hlink' => '',
				'tr_color1' => '',
				'tr_color2' => '',
				'tr_color3' => '',
				'tr_class1' => '',
				'tr_class2' => '',
				'tr_class3' => '',
				'th_color1' => '',
				'th_color2' => '',
				'th_color3' => '',
				'th_class1' => '',
				'th_class2' => '',
				'th_class3' => '',
				'td_color1' => '',
				'td_color2' => '',
				'td_color3' => '',
				'td_class1' => '',
				'td_class2' => '',
				'td_class3' => '',
				'fontface1' => '',
				'fontface2' => '',
				'fontface3' => '',
				'fontsize1' => 0,
				'fontsize2' => 0,
				'fontsize3' => 0,
				'fontcolor1' => '444444',
				'fontcolor2' => '006600',
				'fontcolor3' => 'FFA34F',
				'span_class1' => '',
				'span_class2' => '',
				'span_class3' => '',
				'img_size_poll' => 0,
				'img_size_privmsg' => 0,
			);
			$sql = 'INSERT INTO ' . THEMES_TABLE . '
						(' . $db->sql_fields('fields', $fields) . ') VALUES(' . $db->sql_fields('values', $fields) . ')';
			$db->sql_query($sql, false, __LINE__, __FILE__);
			$ptifo_id = $db->sql_nextid();
			$parms['ptifo'] = 2;
		}
		$config->begin_transaction();
		$config->set('default_style', $ptifo_id);
		$config->set('override_user_style', true);
		$config->end_transaction();
	}
	next_step();
}
if ( $parms['ptifo'] == 1 )
{
	$page->output('CH_ptifo_default');
}
if ( $parms['ptifo'] == 2 )
{
	$page->output('CH_ptifo_installed');
}

// all is done, recache
if ( step() == 'CH_end' )
{
	$sql = 'DELETE FROM ' . USERS_CACHE_TABLE;
	$db->sql_query($sql, false, __LINE__, __FILE__);

	$config->read(true);
	$forums = new forums();
	$forums->read(true);

	$config->set('mod_cat_hierarchy', CH_CURRENT_VERSION, true);

	$page->error(empty($parms['chpv']) ? 'CH_install_done' : 'CH_install_upgraded');
	$page->critical_error('CH_return_to_board');
}

// send page
$page->header();
$page->footer();

?>