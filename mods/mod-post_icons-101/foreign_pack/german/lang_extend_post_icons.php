<?php
/***************************************************************************
 *						lang_extend_post_icons.php [German]
 *						--------------------------
 *	begin				: 28/09/2003
 *	copyright			: Ptirhiik
 *	email				: ptirhiik@clanmckeen.com
 *
 *	version				: 1.0.1 - 28/10/2003
 *	Translation author	: http://phpbb2.de
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
	$lang['Lang_extend_post_icons']		= 'Post Icons';

	$lang['Icons_settings_explain']		= 'Hier kannst Du die Post Icons verwalten';
	$lang['Icons_auth']					= 'Auth Level';
	$lang['Icons_auth_explain']			= 'Die Icons werden nur den Usern angezeigt, die diese Anforderung erfüllen';
	$lang['Icons_defaults']				= 'Standard Zuordnung';
	$lang['Icons_defaults_explain']		= 'Diese Zuordnungen werden bei den Themen verwendet, wo kein Icon definiert wurde';
	$lang['Icons_delete']				= 'Lösche ein Icon';
	$lang['Icons_delete_explain']		= 'Please choose an icon in order to replace this one :';
	$lang['Icons_confirm_delete']		= 'Bist Du sicher, das Du dieses löschen möchtest ?';

	$lang['Icons_lang_key']				= 'Icon Titel';
	$lang['Icons_lang_key_explain']		= 'Der Icon Titel wird angezeigt, wenn der User seine Maus über das Icon hält (Titel oder alt HTML Befehl). Du kannst hier Text verwenden, oder auch eine Variable aus den Sprachdateien verwenden. <br />(siehe language/lang_<i>deine_Sprache</i>/lang_main.php).';
	$lang['Icons_icon_key']				= 'Icon';
	$lang['Icons_icon_key_explain']		= 'Icon URL oder eine Variable aus der Images Datei. <br />(siehe templates/<i>dein_template</i>/<i>dein_template</i>.cfg)';

	$lang['Icons_error_title']			= 'Der Icon Titel ist leer';
	$lang['Icons_error_del_0']			= 'Du kannst nicht das Standard Icon für "leer" löschen';

	$lang['Refresh']					= 'Aktualisieren';
	$lang['Usage']						= 'Verwendet';

	$lang['Image_key_pick_up']			= 'Heben Sie einen Eintragung Bild schlüssel auf';
	$lang['Lang_key_pick_up']			= 'Heben Sie einen Eintragung lang Schlüssel auf';
}

$lang['Icons_settings']			= 'Post Icons';
$lang['Icons_per_row']			= 'Icons pro Zeile';
$lang['Icons_per_row_explain']	= 'Stelle hier die Anzahl an Icons ein, die in einer Zeile in der Posting Ansicht dargestellt werden sollen';
$lang['post_icon_title']		= 'Nachricht Icon';
// icons
$lang['icon_none']				= 'Kein Icon';
$lang['icon_note']				= 'Notiz';
$lang['icon_important']			= 'Wichtig';
$lang['icon_idea']				= 'Idee';
$lang['icon_warning']			= 'Warnung !';
$lang['icon_question']			= 'Frage';
$lang['icon_cool']				= 'Cool';
$lang['icon_funny']				= 'Witzig';
$lang['icon_angry']				= 'Grrrr !';
$lang['icon_sad']				= 'Snif !';
$lang['icon_mocker']			= 'Hehehe !';
$lang['icon_shocked']			= 'Oooh !';
$lang['icon_complicity']		= 'Complicity';
$lang['icon_bad']				= 'Schlecht !';
$lang['icon_great']				= 'Grossartig !';
$lang['icon_disgusting']		= 'Beark !';
$lang['icon_winner']			= 'Gniark !';
$lang['icon_impressed']			= 'Oh Ja !';
$lang['icon_roleplay']			= 'Rollenspiel';
$lang['icon_fight']				= 'Kämpfet';
$lang['icon_loot']				= 'Loot';
$lang['icon_picture']			= 'Bild';
$lang['icon_calendar']			= 'Kalendar Termin';

?>