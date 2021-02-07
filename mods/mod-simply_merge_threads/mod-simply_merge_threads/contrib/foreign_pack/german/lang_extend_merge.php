<?php
/***************************************************************************
 *						lang_extend_merge.php [German]
 *						------------------------------
 *	begin				: 28/09/2003
 *	copyright			: Ptirhiik
 *	email				: ptirhiik@clanmckeen.com
 *
 *	version				: 1.0.1 - 21/10/2003
 *
 * Tanslation author	: likeatim
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

$lang['Refresh'] = 'Refresh';
$lang['Merge_topics'] = 'Themen zusammenführen';
$lang['Merge_title'] = 'Neuer Thementitel';
$lang['Merge_title_explain'] = 'Dies ist der neue Thementitel. Leerlassen, um den vorgegebenen Titel zu benutzen.';
$lang['Merge_topic_from'] = 'Zusammenzuführendes Thema';
$lang['Merge_topic_from_explain'] = 'Dieses Thema wird mit einem anderen zusammengeführt. Man kann entweder die Topic-ID, die URL des Themas oder die URL eines einzigen Beitrags angeben.';
$lang['Merge_topic_to'] = 'Zielthema';
$lang['Merge_topic_to_explain'] = 'Dieses Thema wird um die Beiträge des zusammenzuführenden Themas ergänzt. Man kann entweder die Topic-ID, die URL des Themas oder die URL eines einzigen Beitrags angeben.';
$lang['Merge_from_not_found'] = 'Das zusammenzuführende Thema wurde nicht gefunden.';
$lang['Merge_to_not_found'] = 'Das Zielthema wurde nicht gefunden.';
$lang['Merge_topics_equals'] = 'Man kann ein Thema nicht mit sich selbst zusammenführen.';
$lang['Merge_from_not_authorized'] = 'Du bist nicht autorisiert das Forum zu moderieren, dass das Thema enthält, das zusammengeführt werden soll.';
$lang['Merge_to_not_authorized'] =  'Du bist nicht autorisiert das Forum zu moderieren, dass das Zielthema enthält.';
$lang['Merge_poll_from'] = 'Die Umfrage im zusammenzuführenden Thema wird zum Zielthema kopiert.';
$lang['Merge_poll_from_and_to'] = 'Das Zielthema enthält bereits eine Umfrage. Die Umfrage des zusammenzuführenden Themas wird daher gelöscht.';
$lang['Merge_confirm_process'] = 'Bist Du sicher, <br />"<b>%s</b>"<br />mit<br />"<b>%s</b>"<br />zusammenzuführen?"';
$lang['Merge_topic_done'] = 'Die Themen wurden erfolgreich zusammengeführt.';

?>