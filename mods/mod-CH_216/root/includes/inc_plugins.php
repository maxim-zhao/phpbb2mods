<?php
//
//	file: includes/inc_plugins.php
//	author: ptirhiik
//	begin: 01/02/2007
//	version: 1.6.0 - 01/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$plug_ins = array(
	'mod_attachmod_CH' => array('layer' => 'includes/attach/class_attach'),
	'mod_topic_calendar_CH' => array('layer' => 'includes/calendar/class_calendar'),
);

?>