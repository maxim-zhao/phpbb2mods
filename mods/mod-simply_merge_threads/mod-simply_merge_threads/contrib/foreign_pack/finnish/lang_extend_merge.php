<?php
/***************************************************************************
 *						lang_extend_merge.php [French]
 *						------------------------------
 *	begin				: 28/09/2003
 *	copyright			: Ptirhiik
 *	email				: ptirhiik@clanmckeen.com
 *
 *	version				: 1.0.1 - 21/10/2003
 *	Translation author	: Wolferine
 *
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
	die("Hacking attempt");
}

// admin part
if ( $lang_extend_admin )
{
	$lang['Lang_extend_merge'] = 'Simply Merge Threads';
}

$lang['Refresh'] = 'Päivitä'; 
$lang['Merge_topics'] = 'Yhdistä aiheet'; 
$lang['Merge_title'] = 'Aiheen otsikko'; 
$lang['Merge_title_explain'] = 'Tämä on uuden aiheen lopullinen otsikko. Jätä kenttä tyhjäksi jos haluat otsikon olevan kohde aiheen otsikko'; 
$lang['Merge_topic_from'] = 'Yhdistettävä aihe'; 
$lang['Merge_topic_from_explain'] = 'Tämä aihe yhdistetään toiseen. Voit pistää aiheen tunnistenumeron, aiheen osoitteen, tai viestin osoitteen tässä aiheessa'; 
$lang['Merge_topic_to'] = 'Kohdeaihe'; 
$lang['Merge_topic_to_explain'] = 'Tämä aihe hakee kaikki viestit edeltävästä aiheesta. voit pistää aiheen tunnistenumeron, aiheen osoitteen, tai viestin osoitteen tässä aiheessa'; 
$lang['Merge_from_not_found'] = 'Yhdistettävää aihetta ei löytynyt'; 
$lang['Merge_to_not_found'] = 'Kohdeaihetta ei löytynyt'; 
$lang['Merge_topics_equals'] = 'Et voi yhdistää samaa aihetta'; 
$lang['Merge_from_not_authorized'] = 'Et ole valtuutettu muokkaamaan aiheita foorumista jossa aihe on'; 
$lang['Merge_to_not_authorized'] =  'Et ole valtuutettu muokkaamaan aiheita foorumissa jonne aihe luodaan'; 
$lang['Merge_poll_from'] = 'Yhdistettävässä aiheessa on äänestys. Se kopioidaan kohdeaiheeseen'; 
$lang['Merge_poll_from_and_to'] = 'Kohdeaiheessa on jo äänestys. Yhdistettävän aiheen äänestys tuhotaan'; 
$lang['Merge_confirm_process'] = 'Oletko varma että haluat yhdistää <br />"<b>%s</b>"<br />tähän<br />"<b>%s</b>"'; 
$lang['Merge_topic_done'] = 'Aiheet ovat onnistuneesti yhdistetty.';

?>