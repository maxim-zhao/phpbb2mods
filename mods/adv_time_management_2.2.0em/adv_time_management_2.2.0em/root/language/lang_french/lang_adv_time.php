<?php
/***************************************************************************
 *                         lang_adv_time.php [French]
 *                            -------------------
 *   begin                : Sat July 09 2005
 *   copyright            : (C) 2005 -=ET=- http://www.golfexpert.net/phpbb
 *   email                : n/a
 *
 *   $Id: lang_adv_time.php, 1.0.0, 2005/07/09 00:00:00, -=ET=- Exp $
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

$lang['time_mode'] = 'Gestion du temps';
$lang['time_mode_text'] = 'Les paramétrages manuels sont ignorés quand un mode automatique est sélectionné (les 2 premiers nécessitent que JavaScript soit activé).<br />Pour le mode manuel, le décalage de l\'heure d\'été correspond au décalage entre l\'heure d\'été et l\'heure d\'hiver dans votre pays (de 0 à 120 minutes).<br /><br />* Le mode repéré par cet astérisque est celui utilisé par défaut sur ce forum et vous est recommandé par son administrateur.';
$lang['time_mode_auto'] = 'Modes automatiques...';
$lang['time_mode_full_pc'] = 'Heure de votre ordinateur';
$lang['time_mode_server_pc'] = 'Heure universelle du serveur, fuseau horaire<br /><span STYLE="margin-left: 25">et heure d\'été de votre ordinateur</span>';
$lang['time_mode_full_server'] = 'Heure locale du serveur';
$lang['time_mode_manual'] = 'Mode manuel...';
$lang['time_mode_dst'] = 'Heure d\'été activée';
$lang['time_mode_dst_server'] = 'Par le serveur';
$lang['time_mode_dst_time_lag'] = 'Décalage de l\'heure d\'été';
$lang['time_mode_dst_mn'] = 'mn';
$lang['time_mode_timezone'] = 'Fuseau horaire';

$lang['dst_time_lag_error'] = 'Saisie du décalage de l\'heure d\'été non conforme !<br />Vous devez saisir un nombre de minutes compris entre 0 et 120.';

$lang['dst_enabled_mode'] = ' [heure d\'été activée]';
$lang['full_server_mode'] = 'Heures synchro sur le serveur du forum';
$lang['server_pc_mode'] = 'Heures synchro sur le serveur - Fuseau & h. d\'été sur votre ordinateur';
$lang['full_pc_mode'] = 'Heures synchro sur votre ordinateur';

?>