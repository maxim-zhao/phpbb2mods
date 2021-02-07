<?php
/***************************************************************************
 *						lang_extend_merge.php [Spanish]
 *						-------------------------------
 *	begin				: 28/09/2003
 *	copyright			: Ptirhiik
 *	email				: ptirhiik@clanmckeen.com
 *
 *	version				: 1.0.1 - 21/10/2003
 *
 * Tanslation author	: Poyet11
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

$lang['Refresh'] = 'Actualizar'; 
$lang['Merge_topics'] = 'Fusionar temas'; 
$lang['Merge_title'] = 'Nuevo título del tema'; 
$lang['Merge_title_explain'] = 'Escriba el título que habrá de tener el nuevo tema final. Déjelo en blanco si quiere que el sistema utilice el título del tema de destino'; 
$lang['Merge_topic_from'] = 'Tema a fusionar'; 
$lang['Merge_topic_from_explain'] = 'Los mensajes de este tema pasarán al tema siguiente. Puede indicar el número del tema, el enlace del tema, o el enlace de uno de los mensajes de este tema'; 
$lang['Merge_topic_to'] = 'Tema de destino'; 
$lang['Merge_topic_to_explain'] = 'Este tema recibirá todos los mensajes del tema anterior. Puede indicar el número del tema, el enlace del tema, o el enlace de uno de los mensajes de este tema'; 
$lang['Merge_from_not_found'] = 'No se ha encontrado el tema a fusionar'; 
$lang['Merge_to_not_found'] = 'No se ha encontrado el tema de destino'; 
$lang['Merge_topics_equals'] = 'No se puede fusionar un tema consigo mismo'; 
$lang['Merge_from_not_authorized'] = 'Usted no está autorizado para moderar temas procedentes del foro al que pertenece el tema a fusionar'; 
$lang['Merge_to_not_authorized'] =  'Usted no está autorizado para moderar temas procedentes del foro al que pertenece el tema de destino'; 
$lang['Merge_poll_from'] = 'Hay una encuesta en el tema a fusionar. Se copiará al tema de destino'; 
$lang['Merge_poll_from_and_to'] = 'El tema de destino ya tiene una encuesta. Se borrará la encuesta del tema a fusionar'; 
$lang['Merge_confirm_process'] = '¿Está seguro de que desea fusionar <br />"<b>%s</b>"<br />con<br />"<b>%s</b>"'; 
$lang['Merge_topic_done'] = 'Los temas se han fusionado correctamente.';

?>