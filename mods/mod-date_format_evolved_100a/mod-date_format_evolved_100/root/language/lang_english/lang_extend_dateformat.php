<?php
/**
*
* @package format_date_evolved_mod [english]
* @version $Id: lang_extend_dateformat.php,v 1.0 08/09/2006 15:50 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

$lang = array_merge($lang, array(
	'datetime' => array(
		'today'		=> 'Today, ',
		'yesterday'	=> 'Yesterday, ',

		'Sunday'	=> 'Sunday',
		'Monday'	=> 'Monday',
		'Tuesday'	=> 'Tuesday',
		'Wednesday'	=> 'Wednesday',
		'Thursday'	=> 'Thursday',
		'Friday'	=> 'Friday',
		'Saturday'	=> 'Saturday',

		'Sun'		=> 'Sun',
		'Mon'		=> 'Mon',
		'Tue'		=> 'Tue',
		'Wed'		=> 'Wed',
		'Thu'		=> 'Thu',
		'Fri'		=> 'Fri',
		'Sat'		=> 'Sat',

		'January'	=> 'January',
		'February'	=> 'February',
		'March'		=> 'March',
		'April'		=> 'April',
		'May'		=> 'May',
		'June'		=> 'June',
		'July'		=> 'July',
		'August'	=> 'August',
		'September'	=> 'September',
		'October'	=> 'October',
		'November'	=> 'November',
		'December'	=> 'December',

		'Jan'		=> 'Jan',
		'Feb'		=> 'Feb',
		'Mar'		=> 'Mar',
		'Apr'		=> 'Apr',
		'May'		=> 'May',
		'Jun'		=> 'Jun',
		'Jul'		=> 'Jul',
		'Aug'		=> 'Aug',
		'Sep'		=> 'Sep',
		'Oct'		=> 'Oct',
		'Nov'		=> 'Nov',
		'Dec'		=> 'Dec',
	),

	'tz' => array(
		'-12'	=> 'UTC - 12 hours',
		'-11'	=> 'UTC - 11 hours',
		'-10'	=> 'UTC - 10 hours',
		'-9.5'	=> 'UTC - 9:30 hours',
		'-9'	=> 'UTC - 9 hours',
		'-8'	=> 'UTC - 8 hours',
		'-7'	=> 'UTC - 7 hours',
		'-6'	=> 'UTC - 6 hours',
		'-5'	=> 'UTC - 5 hours',
		'-4'	=> 'UTC - 4 hours',
		'-3.5'	=> 'UTC - 3:30 hours',
		'-3'	=> 'UTC - 3 hours',
		'-2'	=> 'UTC - 2 hours',
		'-1'	=> 'UTC - 1 hour',
		'0'	=> 'UTC',
		'1'	=> 'UTC + 1 hour',
		'2'	=> 'UTC + 2 hours',
		'3'	=> 'UTC + 3 hours',
		'3.5'	=> 'UTC + 3:30 hours',
		'4'	=> 'UTC + 4 hours',
		'4.5'	=> 'UTC + 4:30 hours',
		'5'	=> 'UTC + 5 hours',
		'5.5'	=> 'UTC + 5:30 hours',
		'5.75'	=> 'UTC + 5:45 hours',
		'6'	=> 'UTC + 6 hours',
		'6.5'	=> 'UTC + 6:30 hours',
		'7'	=> 'UTC + 7 hours',
		'8'	=> 'UTC + 8 hours',
		'8.75'	=> 'UTC + 8:45 hours',
		'9'	=> 'UTC + 9 hours',
		'9.5'	=> 'UTC + 9:30 hours',
		'10'	=> 'UTC + 10 hours',
		'10.5'	=> 'UTC + 10:30 hours',
		'11'	=> 'UTC + 11 hours',
		'11.5'	=> 'UTC + 11:30 hours',
		'12'	=> 'UTC + 12 hours',
		'12.75'	=> 'UTC + 12:45 hours',
		'13'	=> 'UTC + 13 hours',
		'14'	=> 'UTC + 14 hours',
	),

	'tz_zones' => array(
		'-12'	=> '[UTC - 12, Y] Baker Island',
		'-11'	=> '[UTC - 11, X] Niue, Samoa',
		'-10'	=> '[UTC - 10, W] Hawaii-Aleutian, Cook Island, French Polynesia',
		'-9.5'	=> '[UTC - 9:30, V*] Marquesas Islands',
		'-9'	=> '[UTC - 9, V] Alaska, Gambier Island',
		'-8'	=> '[UTC - 8, U] Pacific Standard Time',
		'-7'	=> '[UTC - 7, T] Mountain Standard Time',
		'-6'	=> '[UTC - 6, S] Central Standard Time',
		'-5'	=> '[UTC - 5, R] Eastern Standard Time',
		'-4'	=> '[UTC - 4, Q] Atlantic Standard Time',
		'-3.5'	=> '[UTC - 3:30, P*] Newfoundland',
		'-3'	=> '[UTC - 3, P] Amazon, Central Greenland, French Guiana',
		'-2'	=> '[UTC - 2, O] Fernando de Noronha, Grytviken',
		'-1'	=> '[UTC - 1, N] Azores, Cape Verde, Eastern Greenland',
		'0'	=> '[UTC, Z] Western European Time, Greenwich Mean Time',
		'1'	=> '[UTC + 1, A] Central European Time, West African Time',
		'2'	=> '[UTC + 2, B] Eastern European Time, Central African Time',
		'3'	=> '[UTC + 3, C] Moscow, Eastern African Time',
		'3.5'	=> '[UTC + 3:30, C*] Iran',
		'4'	=> '[UTC + 4, D] Gulf, Samara',
		'4.5'	=> '[UTC + 4:30, D*] Afghanistan',
		'5'	=> '[UTC + 5, E] Pakistan, Yekaterinburg',
		'5.5'	=> '[UTC + 5:30, E*] Indian, Sri Lanka',
		'5.75'	=> '[UTC + 5:45, E&Dagger;] Nepal',
		'6'	=> '[UTC + 6, F] Bangladesh, Bhutan, Novosibirsk',
		'6.5'	=> '[UTC + 6:30, F*] Cocos Islands, Myanmar',
		'7'	=> '[UTC + 7, G] Indochina, Krasnoyarsk',
		'8'	=> '[UTC + 8, H] China, Western Australia, Irkutsk',
		'8.75'	=> '[UTC + 8:45, H&Dagger;] Southeastern Western Australia',
		'9'	=> '[UTC + 9, I] Japan, Korea, Chita',
		'9.5'	=> '[UTC + 9:30, I*] Central Australia',
		'10'	=> '[UTC + 10, K] Eastern Australia, Vladivostok',
		'10.5'	=> '[UTC + 10:30, K*] Lord Howe',
		'11'	=> '[UTC + 11, L] Solomon Island, Magadan',
		'11.5'	=> '[UTC + 11:30, L*] Norfolk Island',
		'12'	=> '[UTC + 12, M] New Zealand, Fiji, Kamchatka',
		'12.75'	=> '[UTC + 12:45, M&Dagger;] Chatham Islands',
		'13'	=> '[UTC + 13, M*] Tonga, Phoenix Islands',
		'14'	=> '[UTC + 14, M&dagger;] Line Island',
	),

	// The value is only an example and will get replaced by the current time on view
	'dateformats' => array(
		'|d M Y| H:i'		=> '10 Jan 2005 17:54 [Relative days]',
		'd M Y, H:i'		=> '10 Jan 2005, 17:57',
		'd M Y H:i'		=> '10 Jan 2005 17:57',
		'D M d, Y g:i a'	=> 'Mon Jan 10, 2005 5:57 pm',
		'M j, y, H:i'		=> 'Jan 10, 05, 5:57 pm',
		'F j, Y, g:i a'		=> 'January 10, 2005, 5:57 pm'
	),

	'relative_days'		=> 'Relative days',
	'custom_dateformat'	=> 'Custom...',
));

?>