<?php
/** 
 * lang_who_posted.php [dutch]
 * 
 * @package		who_posted
 * @author		Raimon
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
	'topic_not_exist'		=> 'Het gevraagde Onderwerp bestaat niet',
	'whoposted_query_fail'	=> 'De volgende database opdracht is mislukt:',
	'whoposted_title'		=> 'Wie heeft er wat geplaatst?',
	'whoposted_exp'			=> 'Dit is de lijst van alle gebruikers wie iets geplaatst heeft in dit onderwerp.',
	'whoposted_close'		=> 'Geef onderwerp weer &amp; Sluit het venster',
);

?>