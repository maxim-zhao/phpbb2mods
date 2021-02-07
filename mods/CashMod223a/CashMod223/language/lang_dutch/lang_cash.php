<?php 

/*************************************************************************** 
*                            lang_cash.php [Dutch] 
*                              ------------------- 
*     begin                : Sat Jul 20 2003 
*     copyright            : (C) 2003 carloclaessen
*     email                : vraag-en-antwoord@vraag-en-antwoord.nl 
* 
*     $Id: lang_cash.php,v 1.0.0.0 2003/10/08 00:55:17 Xore Exp $ 
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
$lang['Cmcat_main'] = 'Hoofd'; 
$lang['Cmcat_addons'] = 'Extra\'s'; 
$lang['Cmcat_other'] = 'Anders'; 
$lang['Cmcat_help'] = 'Help'; 

$lang['Cash_Configuration'] = 'Geld Configuratie'; 
$lang['Cash_Currencies'] = 'Geld Valuta\'s'; 
$lang['Cash_Exchange'] = 'Geld Wissselen'; 
$lang['Cash_Events'] = 'Geld Gebeurtenis'; 
$lang['Cash_Forums'] = 'Geld Forums'; 
$lang['Cash_Groups'] = 'Geld Groepen'; 
$lang['Cash_Help'] = 'Geld Help'; 
$lang['Cash_Logs'] = 'Geld Logs'; 
$lang['Cash_Settings'] = 'Geld Instellingen'; 

$lang['Cmenu_cash_config'] = 'Standaard geld MOD instellingen'; 
$lang['Cmenu_cash_currencies'] = 'Voeg toe, bewerk of verwijderen Valuta\'s'; 
$lang['Cmenu_cash_settings'] = 'Gespecificeerde instellingen voor de 
Valuta\'s'; 
$lang['Cmenu_cash_events'] = 'Geld hoeveelheden die worden verstrekt'; 
$lang['Cmenu_cash_reset'] = 'Reset of herstel de geld hoeveelheid'; 
$lang['Cmenu_cash_exchange'] = 'Schakel de wissel in ja of nee, wissel 
waardes'; 
$lang['Cmenu_cash_forums'] = 'Schakel valuta\'s in voor gespecificeerde 
forums in'; 
$lang['Cmenu_cash_groups'] = 'Aangepaste instellingen voor groepen, ranks, 
and niveaus'; 
$lang['Cmenu_cash_log'] = 'Bekijk of verwijder gelogde acties door 
moderators acties'; 
$lang['Cmenu_cash_help'] = 'Geld Mod help'; 

// Config 
$lang['Cash_config'] = 'Geld Mod Configuratie'; 
$lang['Cash_config_explain'] = 'Het veld hieronder laat je de Geld MOD 
instellen.'; 

$lang['Cash_admincp'] = 'Geld MOD AdminCP status'; 
$lang['Cash_adminnavbar'] = 'Geld MOD Navigatiebalk'; 
$lang['Sidebar'] = 'Navigatiebalk'; 
$lang['Menu'] = 'Menu'; 

$lang['Messages'] = 'Berichten'; 
$lang['Spam'] = 'Spam'; 
$lang['Click_return_cash_config'] = 'Klik %sHier%s om terug te gaan naar de 
Geld MOD instellingen'; 
$lang['Cash_config_updated'] = 'Geld MOD instellingen succesvol bijgewerkt'; 
$lang['Cash_disabled'] = 'Schakel Geld MOD uit'; 
$lang['Cash_message'] = 'Laat de verdiensten zien in het bevestigings 
scherm'; 
$lang['Cash_display_message'] = 'Bericht dat gebruikers krijgen te zien 
hoeveel ze hebben verdient'; 
$lang['Cash_display_message_explain'] = 'Moet minimaal een keer "%s" in zich 
hebben'; 
$lang['Cash_spam_disable_num'] = 'Aantal berichten nadat de verdiensten niet 
meer worden bijgewerkt (spam bescherming)'; 
$lang['Cash_spam_disable_time'] = 'Tijdsperiode die er minimaal tussen 
berichten en antwoorden moeten zitten per gebruiker (uren)'; 
$lang['Cash_spam_disable_message'] = 'Spam bericht voor geen verdiensten'; 

// Currencies 
$lang['Cash_currencies'] = 'Geld MOD valuta\'s'; 
$lang['Cash_currencies_explain'] = 'Het veld hieronder laat je de valuta\'s 
voor je geld instellen.'; 

$lang['Click_return_cash_currencies'] = 'Klik %shier%s om terug te gaan naar 
Geld MOD valuta\'s'; 
$lang['Cash_currencies_updated'] = 'Geld MOD valuta\'s succesvol bijgewerkt'; 
$lang['Cash_field'] = 'Veld'; 
$lang['Cash_currency'] = 'Valuta'; 
$lang['Name_of_currency'] = 'Naam van de valuta'; 
$lang['Default'] = 'Standaard'; 
$lang['Cash_order'] = 'Sorteer'; 
$lang['Cash_set_all'] = 'Stel in voor alle gebruikers'; 
$lang['Cash_delete'] = 'Verwijder valuta'; 
$lang['Decimals'] = 'Decimalen'; 

$lang['Cash_confirm_copy'] = 'Kopieer alle gebruikers %s gegevens naar 
%s?<br />Dit kan niet ongedaan gemaakt worden'; 
$lang['Cash_confirm_delete'] = 'Verwijder %s?<br />Dit kan niet ongedaan 
gemaakt worden'; 

$lang['Cash_copy_currency'] = 'Kopieër valuta data'; 

$lang['Cash_new_currency'] = 'Maak nieuwe valuta'; 
$lang['Cash_currency_dbfield'] = 'Database veld voor valuta'; 
$lang['Cash_currency_decimals'] = 'Aantal decimalen voor valuta'; 
$lang['Cash_currency_default'] = 'Standaard waarde voor valuta'; 

$lang['Bad_dbfield'] = 'Foutieve veld naam, moet in deze vorm \'gebruikers_woord\'<br 
/><br />%s<br /><br/>Voorbeelden:<br />gebruikers_punten<br />gebruikers_contanten<br 
/>gebruikers_geld<br />gebruikers_waarschuwingen<br /><br />'; 

// 0 currencies (most admin panels won't work... ) 
$lang['Insufficient_currencies'] = 'Je moet valuta aanmaken voordat je instellingen kunt wijzigen'; 

// 
// Add-ons ? 
// 

// Events 
$lang['Cash_events'] = 'Geld MOD gebeurtenissen'; 
$lang['Cash_events_explain'] = 'het veld hieronder laat je de geld MOD 
gebeurtenissen instellen.'; 

$lang['No_events'] = 'Geen gebeurtenissen ingesteld'; 
$lang['Existing_events'] = 'Bestaande gebeurtenissen'; 
$lang['Add_an_event'] = 'Voeg een gebeurtenis toe'; 
$lang['Cash_events_updated'] = 'Geld MOD gebeurtenissen succesvol 
bijgewerkt'; 
$lang['Click_return_cash_events'] = 'Klik %shier%s om terug te gaan naar 
Geld MOD gebeurtenissen'; 

//Reset 
$lang['Cash_reset_title'] = 'Geld MOD Reset'; 
$lang['Cash_reset_explain'] = 'Het veld hieronder laat je alle instellingen 
herstellen, ook voor de gebruikers dus'; 

$lang['Cash_resetting'] = 'Geld Herstellen'; 
$lang['User_of'] = 'Gebruiker %s van %s'; 

$lang['Set_checked'] = 'Stel geselecteerde valuta\'s in'; 
$lang['Recount_checked'] = 'Herstel geselecteerde valuta\'s'; 

$lang['Cash_confirm_reset'] = 'Bevestiging van geselecteerde valuta\'s?<br 
/>Dit kan niet ongedaan worden gemaakt'; 
$lang['Cash_confirm_recount'] = 'Bevestiging van geselecteerde valuta\'s 
hertellen?<br />Dit kan niet ongedaan worden gemaakt.<br /><br />Deze actie 
wordt niet aangeraden voor boards met grote aantallen gebruikers en/of onderwerpen.<br 
/><br />Het wordt aangeraden dat je je site of forum tijdelijk uitschakelt 
tijdens deze actie. <br />Je kunt je site of forum uitschakelen via het 
%sConfiguratie%s scherm'; 

$lang['Update_successful'] = 'Succesvol bijgewerkt!'; 
$lang['Click_return_cash_reset'] = 'Klik %shier%s om terug te gaan naar het 
Geld Herstellen'; 
$lang['User_updated'] = '%s bijgewerkt<br />'; 

// 
// Others 
// 

// Exchange 
$lang['Cash_exchange'] = 'Geld MOD wisselen'; 
$lang['Cash_exchange_explain'] = 'Het veld hieronder laat je de waardes en 
de wisselwaardes instellen voor je wisselen.'; 

$lang['Exchange_insufficient_currencies'] = 'Je hebt niet genoeg valuta\'s om 
je wisselen in te stellen<br />minimaal twee zijn vereist'; 

// Forums 
$lang['Forum_cm_settings'] = 'Geld MOD Forum Instellingen'; 
$lang['Forum_cm_settings_explain'] = 'Van hieruit kun je instellen welke 
forums van invloed zijn op de Geld hoeveelheid'; 

// Groups 
$lang['Cash_groups'] = 'Geld MOD Groepen Instellingen'; 
$lang['Cash_groups_explain'] = 'Van hieruit kan je de privileges en aparte 
instellingen doen voor de Geld MOD, per rang en/of gebruiker'; 

$lang['Click_return_cash_groups'] = 'Klik %shier%s om terug te gaan naar de 
Geld Groepen instellingen'; 
$lang['Cash_groups_updated'] = 'Geld Groepen instellingen succesvol 
bijgewerkt'; 

$lang['Set'] = 'Stel in'; 
$lang['Up'] = 'Omhoog'; 
$lang['Down'] = 'Omlaag'; 

// Help 
$lang['Cmh_support'] = 'Geld MOD Support'; 
$lang['Cmh_troubleshooting'] = 'Hulp via site'; 
$lang['Cmh_upgrading'] = 'Bijwerken'; 
$lang['Cmh_addons'] = 'Extra\'s'; 
$lang['Cmh_demo_boards'] = 'Demo sites'; 
$lang['Cmh_translations'] = 'Vertalingen'; 
$lang['Cmh_features'] = 'Nieuwe mogelijkheden'; 

$lang['Cmhe_support'] = 'Standaard Informatie'; 
$lang['Cmhe_troubleshooting'] = 'Als je problemen hebt met de geld MOD kijk 
dan hier'; 
$lang['Cmhe_upgrading'] = 'Je hebt momenteel versie %s, nieuwere versies 
worden hier bijgewerkt'; 
$lang['Cmhe_addons'] = 'Een lijst van andere MODS die samen gaan met de Geld 
MOD'; 
$lang['Cmhe_demo_boards'] = 'Een lijst van Demo sites of forums die deze MOD 
gebruiken'; 
$lang['Cmhe_translations'] = 'Een lijst met vertalingen voor de Geld MOD'; 
$lang['Cmhe_features'] = 'Een lijst met mogelijkheden voor de Geld MOD'; 

// Logs 
$lang['Logs'] = 'Geld MOD Logs'; 
$lang['Logs_explain'] = 'Vanuit dit scherm kun je de gelogde acties zien'; 

// Settings 
$lang['Cash_settings'] = 'Geld MOD Instellingen'; 
$lang['Cash_settings_explain'] = 'Van hieruit kun je diverse instellingen 
aanpassen.'; 


$lang['Display'] = 'Laat zien'; 
$lang['Implementation'] = 'Implementatie'; 
$lang['Allowances'] = 'Toestemmingen'; 
$lang['Allowances_explain'] = 'Toestemmingen vereisen de Geld Mod Toestemmingen 
plug-in'; 
$lang['Click_return_cash_settings'] = 'Klik %shier%s om terug te gaan naar 
de Geld MOD Instellingen'; 
$lang['Cash_settings_updated'] = 'Geld MOD Instellingen succesvol 
bijgewerkt'; 

$lang['Cash_enabled'] = 'Schakel Valuta in'; 
$lang['Cash_custom_currency'] = 'Aangepaste valuta voor de Geld MOD'; 
$lang['Cash_image'] = 'Laat de valuta als een plaatje zien'; 
$lang['Cash_imageurl'] = 'Plaatje (Relatief aan phpBB2 root map):'; 
$lang['Cash_imageurl_explain'] = 'Gebruik dit om een plaatje te associeëren 
met de Geld Valuta'; 
$lang['Prefix'] = 'Prefix'; 
$lang['Postfix'] = 'Postfix'; 
$lang['Cash_currency_style'] = 'Valuta stijl voor Geld MOD'; 
$lang['Cash_currency_style_explain'] = 'Valuta symbool als ' . 
$lang['Prefix'] . ' of ' . $lang['Postfix']; 
$lang['Cash_display_usercp'] = 'Laat verdiensten zien in gebruikers 
profiel'; 
$lang['Cash_display_userpost'] = 'Laat verdiensten zien in bericht'; 
$lang['Cash_display_memberlist'] = 'Laat verdiensten zien in Gebruikers 
Lijst'; 

$lang['Cash_amount_per_post'] = 'Hoeveelheid geld per nieuw bericht'; 
$lang['Cash_amount_post_bonus'] = 'Hoeveelheid Geld per antwoord voor de 
starter van het berichtt'; 
$lang['Cash_amount_per_reply'] = 'Hoeveelheid Geld per antwoord'; 
$lang['Cash_amount_per_character'] = 'Hoeveelheid Geld per letter of 
teken'; 
$lang['Cash_maxearn'] = 'Maximaal aantal verdiende Geld per bericht'; 
$lang['Cash_amount_per_pm'] = 'Hoeveelheid geld per Prive Bericht'; 
$lang['Cash_include_quotes'] = 'Neem de tekens in een Quote bericht van de 
Quote tekst ook mee'; 
$lang['Cash_exchangeable'] = 'Sta gebruikers toe om deze valuta te 
wisselen'; 
$lang['Cash_allow_donate'] = 'Sta gebruikers toe om geld te schenken aan 
andere gebruikers'; 
$lang['Cash_allow_mod_edit'] = 'Sta moderators toe om gebruikers geld te 
bewerken'; 
$lang['Cash_allow_negative'] = 'Sta gebruikers toe om negatieve waardes Geld 
te hebben'; 

$lang['Cash_allowance_enabled'] = 'Schakel beloningen in'; 
$lang['Cash_allowance_amount'] = 'Hoeveelheid geld verdient'; 
$lang['Cash_allownace_frequency'] = 'Hoe vaak er beloningen worden gegeven'; 
$lang['Cash_allownace_frequencies'][CASH_ALLOW_DAY] = 'Dag'; 
$lang['Cash_allownace_frequencies'][CASH_ALLOW_WEEK] = 'Week'; 
$lang['Cash_allownace_frequencies'][CASH_ALLOW_MONTH] = 'Maand'; 
$lang['Cash_allownace_frequencies'][CASH_ALLOW_YEAR] = 'Jaar'; 
$lang['Cash_allowance_next'] = 'Tijd tot de volgende beloning'; 

// Groups 
$lang['Cash_status_type'][CASH_GROUPS_DEFAULT] = 'Standaard'; 
$lang['Cash_status_type'][CASH_GROUPS_CUSTOM] = 'Aangepast'; 
$lang['Cash_status_type'][CASH_GROUPS_OFF] = 'Uit'; 
$lang['Cash_status'] = 'Status'; 

// Cash Mod Log Text 
// Note: there isn't really a whole lot i can do about it, if languages use 
a 
// grammar that requires these arguments (%s) to be in a different order, 
it's stuck in 
// this order. The up side is that this is about 10x more comprehensive than 
the 
// last way i did it. 
// 

/* argument order: [donater id][donater name][currency list][receiver 
id][receiver name] 

eg. 
Joe donated 14 gold, $10, 3 points to Peter 
*/ 
$lang['Cash_clause'][CASH_LOG_DONATE] = '<a href="' . $phpbb_root_path . 
'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> 
heeft geschonken <b>%s</b> aan <a href="' . $phpbb_root_path . 'profile.' . 
$phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>'; 

/* argument order: [admin/mod id][admin/mod name][editee id][editee 
name][Added list][removed list][Set list] 

eg. 
Joe modified Peter's Cash: 
Added 14 gold 
Removed $10 
Set 3 points 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_MODEDIT] = '<a href="' . 
$phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" 
target="_new">%s</a> heeft bewerkt <a href="' . $phpbb_root_path . 
'profile.' . $phpEx . '?mode=viewprofile&u=%s" 
target="_new"><b>%s</b></a>\'s Geld stand:<br />Toegevoegd <b>%s</b><br 
/>Verwijderd <b>%s</b><br />Ingesteld op <b>%s</b>'; 

/* argument order: [admin/mod id][admin/mod name][currency name] 

eg. 
Joe created points 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_CREATE_CURRENCY] = '<a href="' . 
$phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" 
target="_new"><b>%s</b></a> heeft gemaakt <b>%s</b>'; 

/* argument order: [admin/mod id][admin/mod name][currency name] 

eg. 
Joe deleted $ 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_DELETE_CURRENCY] = '<a href="' . 
$phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" 
target="_new"><b>%s</b></a> heeft verwijderd <b>%s</b>'; 

/* argument order: [admin/mod id][admin/mod name][old currency name][new 
currency name] 

eg. 
Joe renamed silver to gold 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_RENAME_CURRENCY] = '<a href="' . 
$phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" 
target="_new"><b>%s</b></a> heeft hernoemd <b>%s</b> to <b>%s</b>'; 

/* argument order: [admin/mod id][admin/mod name][copied currency 
name][copied over currency name] 

eg. 
Joe copied users' gold to points 
*/ 
$lang['Cash_clause'][CASH_LOG_ADMIN_COPY_CURRENCY] = '<a href="' . 
$phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" 
target="_new"><b>%s</b></a> heeft gebruikers\' <b>%s</b> naar <b>%s</b>'; 

$lang['Log'] = 'Log'; 
$lang['Action'] = 'Actie'; 
$lang['Type'] = 'Soort'; 
$lang['Cash_all'] = 'Alles'; 
$lang['Cash_admin'] = 'Admin'; 
$lang['Cash_user'] = 'Gebruiker'; 
$lang['Delete_all_logs'] = 'Verwijder alle logs'; 
$lang['Delete_admin_logs'] = 'Verwijder admin logs'; 
$lang['Delete_user_logs'] = 'Verwijder gebruikers logs'; 
$lang['All'] = 'Alles'; 
$lang['Day'] = 'Dag'; 
$lang['Week'] = 'Week'; 
$lang['Month'] = 'Maand'; 
$lang['Year'] = 'Jaar'; 
$lang['Page'] = 'Pagina'; 
$lang['Per_page'] = 'per pagina'; 

// 
// Now for some regular stuff... 
// 

// 
// User CP 
// 
$lang['Donate'] = 'Schenk'; 
$lang['Mod_usercash'] = 'Bewerk %s\'s Geld'; 
$lang['Exchange'] = 'Wissel'; 

// 
// Exchange 
// 
$lang['Convert'] = 'Converteer'; 
$lang['Select_one'] = 'Selecteer een'; 
$lang['Exchange_lack_of_currencies'] = 'Er zijn op dit moment niet genoeg 
valuta\'s in het system<br />Om dit te gebruiken moet de Beheerder minimaal 2 
valuta\'s instellen'; 
$lang['You_have'] = 'Je hebt'; 
$lang['One_worth'] = 'Een %s is waard:'; 
$lang['Cannot_exchange'] = 'Je kunt geen %s, wisselen momenteel'; 

// 
// Donate 
// 
$lang['Amount'] = 'Hoeveelheid'; 
$lang['Donate_to'] = 'Schenk aan %s'; 
$lang['Donation_recieved'] = 'Je hebt een schenking ontvangen van %s'; 
$lang['Has_donated'] = '%s heeft [b]%s[/b] geschonken aan jou. \n\n%s 
schreef:\n'; 

// 
// Mod Edit 
// 
$lang['Add'] = 'Voeg toe'; 
$lang['Remove'] = 'Verwijder'; 
$lang['Omit'] = 'Nalaten'; 
$lang['Amount'] = 'Hoeveelheid'; 
$lang['Donate_to'] = 'Schenk aan %s'; 
$lang['Has_moderated'] = '%s heeft je aantal bewerkt %s'; 
$lang['Has_added'] = '[*]Toegevoegd: [b]%s[/b]\n'; 
$lang['Has_removed'] = '[*]Verwijderd: [b]%s[/b]\n'; 
$lang['Has_set'] = '[*]Ingesteld op: [b]%s[/b]\n'; 

// That's all folks! 

?>