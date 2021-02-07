<?php
/** 
 * lang_rules.php
 * 
 * @package		Rules Page
 * @author		eviL3 <evil@phpbbmodders.net>
 * @copyright	(c) 2006 eviL3
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License 
 *
 */

/**
 * To add an entry to your Rules simply add a line to this file in this format:
 * It must be after this:
 * $faq = array_merge($faq, array(
 * And before:
 * 	)
 * );
 * 
 * array('question', 'answer'),
 * If you want to separate a section enter array('--','Block heading goes here if wanted');
 * 
 * 
 * Links will be created automatically
 * 
 * DO NOT forget the , at the end of the line.
 * Do NOT put single quotes (') in your Rules entries, if you absolutely must then escape them ie. \'something\'
 * 
 * The Rules items will appear on the Rules page in the same order they are listed in this file 
 */


if( !isset($faq) )
{
	$faq = array();
}

/**
 * Add some rules entries
 */
$faq = array_merge($faq, array(
	array('--', 'Rules category'),
	array('Rules item', 'This item demonstrates the rules page. To edit/add/remove items, please edit language/lang_english/lang_rules.php.<br /><i>HTML is also possible!</i><br />'),
	)
);


//
// This ends the Rules entries
//

?>
