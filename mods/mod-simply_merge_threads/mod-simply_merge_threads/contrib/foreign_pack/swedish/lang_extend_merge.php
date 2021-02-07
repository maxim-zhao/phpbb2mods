<?php
/***************************************************************************
 *						lang_extend_merge.php [French]
 *						------------------------------
 *	begin				: 28/09/2003
 *	copyright			: Ptirhiik
 *	email				: ptirhiik@clanmckeen.com
 *
 *	version				: 1.0.1 - 21/10/2003
 *	Translation author	: Carpe Diem
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

$lang['Refresh'] = 'Uppdatera'; 
$lang['Merge_topics'] = 'Sammanslå strängar'; 
$lang['Merge_title'] = 'Ny strängtitel'; 
$lang['Merge_title_explain'] = 'Detta kommer att bli den nya titeln för strängen. Lämna det blankt om du istället vill att systemet ska använda destinationssträngens titel'; 
$lang['Merge_topic_from'] = 'Sträng att slå samman'; 
$lang['Merge_topic_from_explain'] = 'Denna sträng kommer att slås samman med den andra strängen. Du kan mata in strängens id, hela url:en för strängen, eller url:en för en enskild post i denna sträng'; 
$lang['Merge_topic_to'] = 'Destinationssträng'; 
$lang['Merge_topic_to_explain'] = 'Denna sträng kommer att ärva samtliga enskilda poster som fanns i den föregående strängen. Du kan mata in strängens id, hela url:en för strängen, eller url:en för en enskild post i denna sträng'; 
$lang['Merge_from_not_found'] = 'Kunde ej finna någon sträng att slå samman'; 
$lang['Merge_to_not_found'] = 'Kunde ej finna destinationssträngen att slå samman med'; 
$lang['Merge_topics_equals'] = 'Du kan ej slå samman en sträng med sig själv!'; 
$lang['Merge_from_not_authorized'] = 'Du är ej behörig att välja göra sammanslagning av strängar som kommer från det valda forumet'; 
$lang['Merge_to_not_authorized'] =  'Du är ej behörig att välja göra sammanslagning till strängar som finns i det valda destinationsforumet'; 
$lang['Merge_poll_from'] = 'Det finns en röststräng att utföra sammanslagning på. Röststrängen kommer att kopieras till destinationssträngen'; 
$lang['Merge_poll_from_and_to'] = 'Destinationssträngen innehåller redan en röststräng. Röststrängen som finns i den gamla strängen kommer därför att raderas bort.'; 
$lang['Merge_confirm_process'] = 'Är du säker på att du vill slå samman <br />"<b>%s</b>"<br />med<br />"<b>%s</b>"'; 
$lang['Merge_topic_done'] = 'Strängarna har nu slagits samman på ett korrekt sätt';

?>