<?php
/** 
 * lang_who_posted.php [german]
 * 
 * @package		who_posted
 * @author		eviL3
 * @copyright	(c) 2006 - 2007 eviL3
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License
 * 
 */

/**
 * Check if $lang exists
 */
if( !$lang || !is_array($lang) )
{
	$lang = array();
}

/**
 * This is the language file for the "Who Posted" MOD
 */
$lang += array(
	'topic_not_exist'		=> 'Das gewünschte Thema existiert nicht',
	'whoposted_query_fail'	=> 'Die folgende Datenbankabfrage ist fehlgeschlagen:',
	'whoposted_title'		=> 'Wer hat gepostet?',
	'whoposted_exp'			=> 'Dies ist eine Liste aller Mitglieder, welche in diesem Thema einen Beitrag geleistet haben.',
	'whoposted_close'		=> 'Thema anzeigen &amp; Fenster schliessen',
);

?>