<?php
/**
*
* @package format_date_evolved_mod [french]
* @version $Id: lang_extend_dateformat.php,v 1.0 08/09/2006 15:57 reddog Exp $
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
		'today'		=> 'Aujourd\'hui, ',
		'yesterday'	=> 'Hier, ',

		'Sunday'	=> 'Dimanche',
		'Monday'	=> 'Lundi',
		'Tuesday'	=> 'Mardi',
		'Wednesday'	=> 'Mercredi',
		'Thursday'	=> 'Jeudi',
		'Friday'	=> 'Vendredi',
		'Saturday'	=> 'Samedi',

		'Sun'		=> 'Dim',
		'Mon'		=> 'Lun',
		'Tue'		=> 'Mar',
		'Wed'		=> 'Mer',
		'Thu'		=> 'Jeu',
		'Fri'		=> 'Ven',
		'Sat'		=> 'Sam',

		'January'	=> 'Janvier',
		'February'	=> 'Février',
		'March'		=> 'Mars',
		'April'		=> 'Avril',
		'May'		=> 'Mai',
		'June'		=> 'Juin',
		'July'		=> 'Juillet',
		'August'	=> 'Août',
		'September'	=> 'Septembre',
		'October'	=> 'Octobre',
		'November'	=> 'Novembre',
		'December'	=> 'Décembre',

		'Jan'		=> 'Jan',
		'Feb'		=> 'Fév',
		'Mar'		=> 'Mar',
		'Apr'		=> 'Avr',
		'May'		=> 'Mai',
		'Jun'		=> 'Juin',
		'Jul'		=> 'Juil',
		'Aug'		=> 'Aoû',
		'Sep'		=> 'Sep',
		'Oct'		=> 'Oct',
		'Nov'		=> 'Nov',
		'Dec'		=> 'Déc',
	),

	'tz' => array(
		'-12'	=> 'UTC - 12 heures',
		'-11'	=> 'UTC - 11 heures',
		'-10'	=> 'UTC - 10 heures',
		'-9.5'	=> 'UTC - 9:30 heures',
		'-9'	=> 'UTC - 9 heures',
		'-8'	=> 'UTC - 8 heures',
		'-7'	=> 'UTC - 7 heures',
		'-6'	=> 'UTC - 6 heures',
		'-5'	=> 'UTC - 5 heures',
		'-4'	=> 'UTC - 4 heures',
		'-3.5'	=> 'UTC - 3:30 heures',
		'-3'	=> 'UTC - 3 heures',
		'-2'	=> 'UTC - 2 heures',
		'-1'	=> 'UTC - 1 heure',
		'0'	=> 'UTC',
		'1'	=> 'UTC + 1 heure',
		'2'	=> 'UTC + 2 heures',
		'3'	=> 'UTC + 3 heures',
		'3.5'	=> 'UTC + 3:30 heures',
		'4'	=> 'UTC + 4 heures',
		'4.5'	=> 'UTC + 4:30 heures',
		'5'	=> 'UTC + 5 heures',
		'5.5'	=> 'UTC + 5:30 heures',
		'5.75'	=> 'UTC + 5:45 heures',
		'6'	=> 'UTC + 6 heures',
		'6.5'	=> 'UTC + 6:30 heures',
		'7'	=> 'UTC + 7 heures',
		'8'	=> 'UTC + 8 heures',
		'8.75'	=> 'UTC + 8:45 heures',
		'9'	=> 'UTC + 9 heures',
		'9.5'	=> 'UTC + 9:30 heures',
		'10'	=> 'UTC + 10 heures',
		'10.5'	=> 'UTC + 10:30 heures',
		'11'	=> 'UTC + 11 heures',
		'11.5'	=> 'UTC + 11:30 heures',
		'12'	=> 'UTC + 12 heures',
		'12.75'	=> 'UTC + 12:45 heures',
		'13'	=> 'UTC + 13 heures',
		'14'	=> 'UTC + 14 heures',
	),

	'tz_zones' => array(
		'-12'	=> '[UTC - 12, Y] Île Baker',
		'-11'	=> '[UTC - 11, X] Samoa',
		'-10'	=> '[UTC - 10, W] Hawaii et les îles Aléoutiennes, Polynésie française',
		'-9.5'	=> '[UTC - 9:30, V*] Îles Marquises',
		'-9'	=> '[UTC - 9, V] Alaska, Îles Gambier',
		'-8'	=> '[UTC - 8, U] Heure standard du Pacifique',
		'-7'	=> '[UTC - 7, T] Heure standard des Montagnes, les Rocheuses',
		'-6'	=> '[UTC - 6, S] Heure standard du Centre',
		'-5'	=> '[UTC - 5, R] Heure standard de l\'Est de l\'amérique du nord',
		'-4'	=> '[UTC - 4, Q] Heure standard de l\'Atlantique',
		'-3.5'	=> '[UTC - 3:30, P*] Île Terre-Neuve, Labrador',
		'-3'	=> '[UTC - 3, P] Amazonie, Groenland, Guyane française',
		'-2'	=> '[UTC - 2, O] Fernando de Noronha, Grytviken',
		'-1'	=> '[UTC - 1, N] Les Açores, Cap-Vert, Est du Groenland',
		'0'	=> '[UTC, Z] Europe occidentale, méridien de Greenwich',
		'1'	=> '[UTC + 1, A] Europe centrale, Afrique de l\'Ouest',
		'2'	=> '[UTC + 2, B] Europe orientale, Afrique Centrale',
		'3'	=> '[UTC + 3, C] Moscow, Afrique de l\'Est, Mayotte',
		'3.5'	=> '[UTC + 3:30, C*] Iran',
		'4'	=> '[UTC + 4, D] Golfe, Île de la Réunion',
		'4.5'	=> '[UTC + 4:30, D*] Afghanistan',
		'5'	=> '[UTC + 5, E] Pakistan, Îles Kerguelen',
		'5.5'	=> '[UTC + 5:30, E*] Inde, Sri Lanka',
		'5.75'	=> '[UTC + 5:45, E&Dagger;] Népal',
		'6'	=> '[UTC + 6, F] Bangladesh, Bhoutan, Novosibirsk',
		'6.5'	=> '[UTC + 6:30, F*] Îles Cocos',
		'7'	=> '[UTC + 7, G] Indochine, Krasnoyarsk',
		'8'	=> '[UTC + 8, H] Australie occidentale, Chine, Irkoutsk',
		'8.75'	=> '[UTC + 8:45, H&Dagger;] Australie occidentale (extrême Sud-Est)',
		'9'	=> '[UTC + 9, I] Japon, Corée',
		'9.5'	=> '[UTC + 9:30, I*] Australie centrale',
		'10'	=> '[UTC + 10, K] Australie orientale, Vladivostok',
		'10.5'	=> '[UTC + 10:30, K*] Nouvelle-Galles du Sud',
		'11'	=> '[UTC + 11, L] Nouvelle-Calédonie, Îles Salomon',
		'11.5'	=> '[UTC + 11:30, L*] Île Norfolk',
		'12'	=> '[UTC + 12, M] Nouvelle Zélande, Wallis-et-Futuna, Îles Fidji',
		'12.75'	=> '[UTC + 12:45, M&Dagger;] Îles Chatham',
		'13'	=> '[UTC + 13, M*] Îles Phoenix, Tonga',
		'14'	=> '[UTC + 14, M&dagger;] Îles de la Ligne',
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

	'relative_days'		=> 'jours relatifs',
	'custom_dateformat'	=> 'Personnalisé...',
));

?>