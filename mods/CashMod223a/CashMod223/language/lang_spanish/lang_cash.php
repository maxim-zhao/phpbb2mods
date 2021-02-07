<?php



/***************************************************************************

 *                            lang_cash.php [Español]

 *                              -------------------

 *     begin                : Wednesday Nov 16 2005

 *     copyright            : (C) 2005 Hell

 *     email                : hellito@gmail.com

 *	   web					: http://www.hellblade.tk

 *     $Id: lang_cash.php,v 1.0.0.0 2003/10/08 00:55:17 Hell Exp $

 *

 ****************************************************************************/



/***************************************************************************

 *

 *   This program is free software; you can redistribute it and/or modify

 *   it under the terms of the GNU General Public License as published by

 *   the Free Software Foundation; either version 2 of the License, or

 *   (at your option) any later version.

 *

 ***************************************************************************/



//

// Admin menu

//

$lang['Cmcat_main'] = 'Principal';

$lang['Cmcat_addons'] = 'Add-ons';

$lang['Cmcat_other'] = 'Otros';

$lang['Cmcat_help'] = 'Ayuda';



$lang['Cash_Configuration'] = 'Configuración';

$lang['Cash_Currencies'] = 'Monedas';

$lang['Cash_Exchange'] = 'Intercambio';

$lang['Cash_Events'] = 'Eventos';

$lang['Cash_Forums'] = 'Foros&nbsp;con&nbsp;Paga';

$lang['Cash_Groups'] = 'Paga&nbsp;a&nbsp;Grupos';

$lang['Cash_Help'] = 'Ayuda';

$lang['Cash_Logs'] = 'Logs';

$lang['Cash_Settings'] = 'Preferencias';



$lang['Cmenu_cash_config'] = 'Preferencias Globales que afectan a todas las Monedas';

$lang['Cmenu_cash_currencies'] = 'Añade, elimina o modifica Monedas';

$lang['Cmenu_cash_settings'] = 'Especifica preferencias para cada Moneda';

$lang['Cmenu_cash_events'] = 'Cantidades de dinero dadas en eventos';

$lang['Cmenu_cash_reset'] = 'Resetea o recuenta Dinero';

$lang['Cmenu_cash_exchange'] = 'Habilita/Deshabilita intercambios y equivalencias';

$lang['Cmenu_cash_forums'] = 'Poner dinero on/off en cada foro';

$lang['Cmenu_cash_groups'] = 'Preferencias para grupos, rangos, y niveles';

$lang['Cmenu_cash_log'] = 'Ver/Borrar Logs';

$lang['Cmenu_cash_help'] = 'Ayuda';



// Config

$lang['Cash_config'] = 'Configuración';

$lang['Cash_config_explain'] = 'El siguiente formulario permite configurar el dinero.';



$lang['Cash_admincp'] = 'Modo AdminCP';

$lang['Cash_adminnavbar'] = 'Modo Navbar';

$lang['Sidebar'] = 'Barra lateral';

$lang['Menu'] = 'Menu';



$lang['Messages'] = 'Mensajes';

$lang['Spam'] = 'Spam';

$lang['Click_return_cash_config'] = 'Click %sHere%s para volver a la Configuración';

$lang['Cash_config_updated'] = 'Configuración actualizada correctamente';

$lang['Cash_disabled'] = 'Deshabilitar Cash Mod';

$lang['Cash_message'] = 'Enseñar ganancias en la confirmación de Post/Reply';

$lang['Cash_display_message'] = 'Mensaje que enseña las ganancias por Post/Reply';

$lang['Cash_display_message_explain'] = '¡Debe incluir "%s" en él!';

$lang['Cash_spam_disable_num'] = 'Numero de posts máximos para desactivar ganancias (protección de spam)';

$lang['Cash_spam_disable_time'] = 'Periodo de tiempo en que estos posts no deben exceder (hours)';

$lang['Cash_spam_disable_message'] = 'Anuncio de SPAM para ganancia nula';



// Monedas

$lang['Cash_currencies'] = 'Monedas en Cash Mod';

$lang['Cash_currencies_explain'] = 'El siguiente formulario permite configurar las divisas';



$lang['Click_return_cash_currencies'] = 'Click %sHere%s para volver a Monedas Cash Mod';

$lang['Cash_currencies_updated'] = 'Monedas de Cash Mod actualizadas correctamente';

$lang['Cash_field'] = 'Entidad en la Tabla';

$lang['Cash_currency'] = 'Moneda';

$lang['Name_of_currency'] = 'Nombre';

$lang['Default'] = 'Comienzo';

$lang['Cash_order'] = 'Orden';

$lang['Cash_set_all'] = 'Para todos los usuarios';

$lang['Cash_delete'] = 'Eliminar';

$lang['Decimals'] = 'Decimales';



$lang['Cash_confirm_copy'] = 'Copiar todos los datos de %s de los usuarios a %s?<br />Esto no se puede deshacer';

$lang['Cash_confirm_delete'] = 'Eliminar %s?<br />Esto no se puede deshacer';



$lang['Cash_copy_currency'] = 'Copiar los datos de la Moneda';



$lang['Cash_new_currency'] = 'Crear nueva Moneda';

$lang['Cash_currency_dbfield'] = 'Entidad en la Tabla';

$lang['Cash_currency_decimals'] = 'Numero de decimales de la Moneda';

$lang['Cash_currency_default'] = 'Valor por defecto de la Moneda';



$lang['Bad_dbfield'] = 'Nombre de Entidad incorrecto, debe estar en formato \'user_word\'<br /><br />%s<br /><br/>Ejemplos:<br />user_points<br />user_cash<br />user_money<br />user_warnings<br /><br />';



// 0 currencies (most admin panels won't work... )

$lang['Insufficient_currencies'] = 'Necesitas crear Monedas antes de modificar las preferencias';



//

// Add-ons ?

//



// Events

$lang['Cash_events'] = 'Eventos de Cash Mod';

$lang['Cash_events_explain'] = 'El siguiente formulario permite configurar las ganancias de los eventos.';



$lang['No_events'] = 'No hay eventos a listar';

$lang['Existing_events'] = 'Eventos Existentes';

$lang['Add_an_event'] = 'Añadir un evento';

$lang['Cash_events_updated'] = 'Eventos actualizados correctamente';

$lang['Click_return_cash_events'] = 'Click %sHere%s para regresar a Eventos';



//Reset

$lang['Cash_reset_title'] = 'Resetear Cash Mod';

$lang['Cash_reset_explain'] = 'El siguiente formulario permite resetear las ganancias de todos los usuarios';



$lang['Cash_resetting'] = 'Reseteando Cash';

$lang['User_of'] = 'Usuarios %s de %s';



$lang['Set_checked'] = 'Cambiar Monedas marcadas';

$lang['Recount_checked'] = 'Recontar Monedas marcadas';



$lang['Cash_confirm_reset'] = 'Confirmas el reseteo de las siguientes Monedas?<br />Esto no puede deshacerse';

$lang['Cash_confirm_recount'] = 'Confirmas el recuento de las siguientes Monedas?<br />Esto no puede deshacerse<br /><br />Esta accion no es recomendada para foros con grandes cantidades de temas<br /><br />Es recomendable que desactives tu foro mientras ejecutas esta acción. <br />Puedes desactivar tu foro mediante %sConfiguration%s';



$lang['Update_successful'] = 'Actualización correcta!';

$lang['Click_return_cash_reset'] = 'Click %sHere%s para volver al Reseteo de Moneda';

$lang['User_updated'] = '%s actualizado<br />';



//

// Others

//



// Exchange

$lang['Cash_exchange'] = 'Intercambios de Cash Mod';

$lang['Cash_exchange_explain'] = 'El siguiente formulario permite establecer valores relativos de tus monedas, y permitir a los usuarios intercambiarlas.';



$lang['Exchange_insufficient_currencies'] = 'No tienes suficientes Monedas creadas para establecer valores dr intercambio<br />Al menso necesitas 2';



// Forums

$lang['Forum_cm_settings'] = 'Preferencias de Cash Mod';

$lang['Forum_cm_settings_explain'] = 'En este panel puedes decidir que foros otorgan ganancias';



// Groups

$lang['Cash_groups'] = 'Grupos de Cash Mod';

$lang['Cash_groups_explain'] = 'En este panel puedes establecer privilegios a rangos, grupos, administradores y moderadores';



$lang['Click_return_cash_groups'] = 'Click %sHere%s para volver a Grupos de Cash Mod';

$lang['Cash_groups_updated'] = 'Grupos actualizados correctamente';



$lang['Set'] = 'Cambiar';

$lang['Up'] = 'Subir';

$lang['Down'] = 'Bajar';



// Help

$lang['Cmh_support'] = 'Soporte de Cash Mod';

$lang['Cmh_troubleshooting'] = 'Problemas';

$lang['Cmh_upgrading'] = 'Actualizar';

$lang['Cmh_addons'] = 'Add-Ons';

$lang['Cmh_demo_boards'] = 'Foros de demostración';

$lang['Cmh_translations'] = 'Traducciones';

$lang['Cmh_features'] = 'Caracteristicas';



$lang['Cmhe_support'] = 'Información General';

$lang['Cmhe_troubleshooting'] = 'Si tienes problemas con Cash Mod, mira aqui los parches';

$lang['Cmhe_upgrading'] = 'Actualmente posees la versión %s, las actualizaciones serán puestas aquí';

$lang['Cmhe_addons'] = 'Lista de MODs que aprovechan las caracteristicas de Cash Mod';

$lang['Cmhe_demo_boards'] = 'Lista de foros de ejemplo que utilizan Cash Mod';

$lang['Cmhe_translations'] = 'Lista de traducciones para Cash Mod';

$lang['Cmhe_features'] = 'Lista de caracteristicas de Cash Mod, y desarrollo de proximas versiones';



// Logs

$lang['Logs'] = 'Logs de Cash Mod';

$lang['Logs_explain'] = 'En este panel puedes ver los logs de eventos de Cash Mod';



// Settings

$lang['Cash_settings'] = 'Preferencias de Cash Mod';

$lang['Cash_settings_explain'] = 'El siguiente formulario te permite establecer tus preferencias de Moneda';





$lang['Display'] = 'Mostrar';

$lang['Implementation'] = 'Implementación';

$lang['Allowances'] = 'Subenciones';

$lang['Allowances_explain'] = 'Esto necesita Cash Mod Allowances plug-in';

$lang['Click_return_cash_settings'] = 'Click %sHere%s para volver a preferencias de Cash Mod';

$lang['Cash_settings_updated'] = 'Preferencias de Cash Mod actualizadas correctamente';



$lang['Cash_enabled'] = 'Activar Moneda';

$lang['Cash_custom_currency'] = 'Moneda personalizada';

$lang['Cash_image'] = 'Mostrar moneda como imagen';

$lang['Cash_imageurl'] = 'Imagen (Relativa a la raiz del sitio phpBB2):';

$lang['Cash_imageurl_explain'] = 'Usa esto para definir una pequeña imagen relativa a la moneda';

$lang['Prefix'] = 'Prefijo';

$lang['Postfix'] = 'Sufijo';

$lang['Cash_currency_style'] = 'Estilo de Moneda para Cash Mod';

$lang['Cash_currency_style_explain'] = 'Simbolo actual como ' . $lang['Prefix'] . ' o ' . $lang['Postfix'];

$lang['Cash_display_usercp'] = 'Mostrar ahorros en el panel de control de los usuarios';

$lang['Cash_display_userpost'] = 'Mostrar ahorros en Post';

$lang['Cash_display_memberlist'] = 'Mostrar ahorros en la lista de miembros';



$lang['Cash_amount_per_post'] = 'Ganancias por nuevo tema';

$lang['Cash_amount_post_bonus'] = 'Ganancias ahorradas por que contesten a un topic propio';

$lang['Cash_amount_per_reply'] = 'Ganancias ahorradas por respuesta';

$lang['Cash_amount_per_character'] = 'Ganancias ahorradas por personaje';

$lang['Cash_maxearn'] = 'Maxima cantidad de Ganancias por postear';

$lang['Cash_amount_per_pm'] = 'Ganancias conseguidas por mensajes privados';

$lang['Cash_include_quotes'] = 'Incluye comilla al calcular las ganancias por personaje';

$lang['Cash_exchangeable'] = 'Permitir a los usuarios intercambiar esta moneda';

$lang['Cash_allow_donate'] = 'Permitir a los usuarios donar su dinero a otros usuarios';

$lang['Cash_allow_mod_edit'] = 'Permite a los moderadores modificar el dinero de los usuarios';

$lang['Cash_allow_negative'] = 'Permite a los usuarios tener cantidades de dinero negativas';



$lang['Cash_allowance_enabled'] = 'Activar subenciones';

$lang['Cash_allowance_amount'] = 'Cantidad de dinero ahorrado en subenciones';

$lang['Cash_allownace_frequency'] = 'Cada cuanto son ofrecidas las subenciones';

$lang['Cash_allownace_frequencies'][CASH_ALLOW_DAY] = 'Día';

$lang['Cash_allownace_frequencies'][CASH_ALLOW_WEEK] = 'Semana';

$lang['Cash_allownace_frequencies'][CASH_ALLOW_MONTH] = 'Mes';

$lang['Cash_allownace_frequencies'][CASH_ALLOW_YEAR] = 'Año';

$lang['Cash_allowance_next'] = 'Tiempo hasta la próxima subención';



// Groups

$lang['Cash_status_type'][CASH_GROUPS_DEFAULT] = 'Defecto';

$lang['Cash_status_type'][CASH_GROUPS_CUSTOM] = 'Personalizado';

$lang['Cash_status_type'][CASH_GROUPS_OFF] = 'Off';

$lang['Cash_status'] = 'Estado';



// Cash Mod Log Text

// Note: there isn't really a whole lot i can do about it, if languages use a

// grammar that requires these arguments (%s) to be in a different order, it's stuck in

// this order. The up side is that this is about 10x more comprehensive than the

// last way i did it.

//



/* argument order: [donater id][donater name][currency list][receiver id][receiver name]



eg.

Joe donated 14 gold, $10, 3 points to Peter

*/

$lang['Cash_clause'][CASH_LOG_DONATE] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> donated <b>%s</b> to <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>';



/* argument order: [admin/mod id][admin/mod name][editee id][editee name][Added list][removed list][Set list]



eg.

Joe modified Peter's Cash:

Added 14 gold

Removed $10

Set 3 points

*/

$lang['Cash_clause'][CASH_LOG_ADMIN_MODEDIT] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new">%s</a> edited <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>\'s Cash:<br />Added <b>%s</b><br />Removed <b>%s</b><br />Set to <b>%s</b>';



/* argument order: [admin/mod id][admin/mod name][currency name]



eg.

Joe created points 

*/

$lang['Cash_clause'][CASH_LOG_ADMIN_CREATE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> created <b>%s</b>';



/* argument order: [admin/mod id][admin/mod name][currency name]



eg.

Joe deleted $ 

*/

$lang['Cash_clause'][CASH_LOG_ADMIN_DELETE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> deleted <b>%s</b>';



/* argument order: [admin/mod id][admin/mod name][old currency name][new currency name]



eg.

Joe renamed silver to gold

*/

$lang['Cash_clause'][CASH_LOG_ADMIN_RENAME_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> renamed <b>%s</b> to <b>%s</b>';



/* argument order: [admin/mod id][admin/mod name][copied currency name][copied over currency name]



eg.

Joe copied users' gold to points

*/

$lang['Cash_clause'][CASH_LOG_ADMIN_COPY_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> copied users\' <b>%s</b> to <b>%s</b>';



$lang['Log'] = 'Log';

$lang['Action'] = 'Acción';

$lang['Type'] = 'Tipo';

$lang['Cash_all'] = 'Todos';

$lang['Cash_admin'] = 'Admin';

$lang['Cash_user'] = 'Usuario';

$lang['Delete_all_logs'] = 'Borrar todos los logs';

$lang['Delete_admin_logs'] = 'Borrar log del admin';

$lang['Delete_user_logs'] = 'Borrar logs de usuarios';

$lang['All'] = 'Todos';

$lang['Day'] = 'Día';

$lang['Week'] = 'Semana';

$lang['Month'] = 'Mes';

$lang['Year'] = 'Año';

$lang['Page'] = 'Página';

$lang['Per_page'] = 'por página';



//

// Now for some regular stuff...

//



//

// User CP

//

$lang['Donate'] = 'Donar Gil';

$lang['Mod_usercash'] = 'Modificar Dinero de %s';

$lang['Exchange'] = 'Cambiar';



//

// Exchange

//

$lang['Convert'] = 'Convertir';

$lang['Select_one'] = 'Selecciona';

$lang['Exchange_lack_of_currencies'] = 'No hay suficientes tipos de moneda para cambiar<br />Para habilitar esta opción, tu admin tiene que crear al menos dos tipos de moneda';

$lang['You_have'] = 'Tu tienes';

$lang['One_worth'] = 'un %s equivale a:';

$lang['Cannot_exchange'] = 'No puedes cambiar %s, ahora';



//

// Donate

//

$lang['Amount'] = 'Cantidad';

$lang['Donate_to'] = 'Donar a %s';

$lang['Donation_recieved'] = 'Has recibido una donación de %s';

$lang['Has_donated'] = '%s te ha donado [b]%s[/b]. \n\n%s escribió:\n';



//

// Mod Edit

//

$lang['Add'] = 'Sumar';

$lang['Remove'] = 'Quitar';

$lang['Omit'] = 'Omitir';

$lang['Amount'] = 'Cantidad';

$lang['Donate_to'] = 'Donar a %s';

$lang['Has_moderated'] = '%s a moderado tu %s';

$lang['Has_added'] = '[*]Añadidos: [b]%s[/b]\n';

$lang['Has_removed'] = '[*]Quitados: [b]%s[/b]\n';

$lang['Has_set'] = '[*]Cambiado a: [b]%s[/b]\n';



// That's all folks!



?>