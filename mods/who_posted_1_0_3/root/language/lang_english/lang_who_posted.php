<?php
/** 
 * lang_who_posted.php
 * 
 * @package		who_posted
 * @author		eviL3 <evil@phpbbmodders.net>
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
	'topic_not_exist'		=> 'The requested Topic does not exist',
	'whoposted_query_fail'	=> 'The following query has failed:',
	'whoposted_title'		=> 'Who Posted?',
	'whoposted_exp'			=> 'This is a list of all Members who posted in this topic.',
	'whoposted_close'		=> 'Show Topic &amp; Close Window',
);

?>