<?php

/***************************************************************************
 *                            lang_cash.php [Norwegian]
 *                              -------------------
 *     begin                : Sat Nov 15 2003
 *     copyright            : (C) 2003 Mr.Man
 *     email                : mrman5m5@msn.com
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
$lang['Cmcat_main'] = 'Generelt';
$lang['Cmcat_addons'] = 'Utvidelser';
$lang['Cmcat_other'] = 'Andre';
$lang['Cmcat_help'] = 'Hjelp';

$lang['Cash_Configuration'] = 'Konfigurasjon';
$lang['Cash_Currencies'] = 'Myntenheter';
$lang['Cash_Exchange'] = 'Veksling';
$lang['Cash_Events'] = 'Hendelser';
$lang['Cash_Forums'] = 'Forumer';
$lang['Cash_Groups'] = 'Grupper';
$lang['Cash_Help'] = 'Hjelp';
$lang['Cash_Logs'] = 'Logger';
$lang['Cash_Settings'] = 'Innstillinger';

$lang['Cmenu_cash_config'] = 'Globale Cash Mod Innstillinger som påvirker alle myntenheter';
$lang['Cmenu_cash_currencies'] = 'Legg til, Fjern, eller Rokkér Myntenheter';
$lang['Cmenu_cash_settings'] = 'Spesielle innstillinger for hver Myntenhet';
$lang['Cmenu_cash_events'] = 'Valuta som skal deles ut ved spesielle Hendelser';
$lang['Cmenu_cash_reset'] = 'Tilbakestill eller tell om igjen valuta mengder';
$lang['Cmenu_cash_exchange'] = 'Skru På/Av valuta veksling og kurs/avgift';
$lang['Cmenu_cash_forums'] = 'Skru Myntenheter på eller av for hvert forum';
$lang['Cmenu_cash_groups'] = 'Spesialinnstillinger for spesielle brukergrupper, rangering, og nivå';
$lang['Cmenu_cash_log'] = 'Se på/Slett loggede Cash Mod handlinger';
$lang['Cmenu_cash_help'] = 'Cash Mod hjelp';

// Config
$lang['Cash_config'] = 'Cash Mod Konfigurasjon';
$lang['Cash_config_explain'] = 'Skjemaet nedenfor vil gi deg muligheten til å stille på Cash Mod konfigurasjonen.';

$lang['Cash_admincp'] = 'Cash Mod AdminCP Modus';
$lang['Cash_adminnavbar'] = 'Cash Mod Navigasjonspanel';
$lang['Sidebar'] = 'Sidestople';
$lang['Menu'] = 'Meny';

$lang['Messages'] = 'Meldinger';
$lang['Spam'] = 'Spam';
$lang['Click_return_cash_config'] = 'Klikk %sHere%s for å returnere til Cash Mod Konfigurasjon';
$lang['Cash_config_updated'] = 'Cash Mod Konfigurasjon oppdatert';
$lang['Cash_disabled'] = 'Deaktivere Cash Mod';
$lang['Cash_message'] = 'Vis opptjente midler i Send/Svar bekreftelses-skjermbilde';
$lang['Cash_display_message'] = 'Beskjed for å vise brukerens opptjente midler';
$lang['Cash_display_message_explain'] = 'Må ha akkurat en "%s" i den';
$lang['Cash_spam_disable_num'] = 'Antall innlegg før opptjening deaktiveres (spam beskyttelse)';
$lang['Cash_spam_disable_time'] = 'Tidsramme disse innleggene må overstige (timer)';
$lang['Cash_spam_disable_message'] = 'Spam annonsering for null opptjente midler';

// Currencies
$lang['Cash_currencies'] = 'Cash Mod Myntenheter';
$lang['Cash_currencies_explain'] = 'Med skjemaet nedenfor kan du administrere dine Myntenheter.';

$lang['Click_return_cash_currencies'] = 'Klikk %sHer%s for å returnere til Cash Mod Myntenheter';
$lang['Cash_currencies_updated'] = 'Cash Mod Myntenheter Updated Successfully';
$lang['Cash_field'] = 'Felt';
$lang['Cash_currency'] = 'Myntenhet';
$lang['Name_of_currency'] = 'Navn på Myntenhet';
$lang['Default'] = 'Standard';
$lang['Cash_order'] = 'Ordre';
$lang['Cash_set_all'] = 'Innstilling for alle brukere';
$lang['Cash_delete'] = 'Slett Myntenhet';
$lang['Decimals'] = 'Desimaler';

$lang['Cash_confirm_copy'] = 'Kopier alle brukers %s data til %s?<br />Dette kan du ikke angre på';
$lang['Cash_confirm_delete'] = 'Slett %s?<br />Dette kan du ikke angre på';

$lang['Cash_copy_currency'] = 'Kopier Myntenhet Data';

$lang['Cash_new_currency'] = 'Lag ny Myntenhet';
$lang['Cash_currency_dbfield'] = 'Databasefelt for Myntenhet';
$lang['Cash_currency_decimals'] = 'Antall desimaler for Myntenhet';
$lang['Cash_currency_default'] = 'Standardverdi for Myntenhet';

$lang['Bad_dbfield'] = 'Ugyldig feltnavn, må være i formen \'user_word\'<br /><br />%s<br /><br/>Eksempler:<br />user_points<br />user_cash<br />user_money<br />user_warnings<br /><br />';

// 0 currencies (most admin panels won't work... )
$lang['Insufficient_currencies'] = 'Du må lage Myntenheter før du kan forandre på innstillingene';

//
// Add-ons ?
//

// Events
$lang['Cash_events'] = 'Cash Mod Hendelser';
$lang['Cash_events_explain'] = 'I skjemaet nedenfor kan du sette opp beløp som blir utbetalt ved spesielle Hendelser.';

$lang['No_events'] = 'Ingen Hendelser';
$lang['Existing_events'] = 'Eksisterende Hendelser';
$lang['Add_an_event'] = 'Legg til en Hendelse';
$lang['Cash_events_updated'] = 'Cash Mod Hendelser Oppdatert';
$lang['Click_return_cash_events'] = 'Klikk %sHer%s for å gå tilbake til Cash Mod Hendelser';

//Reset
$lang['Cash_reset_title'] = 'Cash Mod Tilbakestilling';
$lang['Cash_reset_explain'] = 'I skjemaet nedenfor kan du sette igang en global tilbakestilling av all brukernes beløp.';

$lang['Cash_resetting'] = 'Valuta Tilbakestilling';
$lang['User_of'] = 'Bruker %s av %s';

$lang['Set_checked'] = 'Innstill valgte Myntenheter';
$lang['Recount_checked'] = 'Tell valgte Myntenheter om igjen';

$lang['Cash_confirm_reset'] = 'Bekreft tilbakestilling av valgte myntenheter?<br />Dette kan du ikke angre på';
$lang['Cash_confirm_recount'] = 'Bekreft nyopptelling av valgte myntenheter?<br />Dette kan du ikke angre på.<br /><br />Dette anbefales ikke for forum med store antall brukere og/eller innlegg.<br /><br />Det anbefales at du deaktiverer forumet mens dette pågår. <br />Du kan deaktivere forumet via %sKonfigurasjon%s';

$lang['Update_successful'] = 'Oppdatering gjennomført!';
$lang['Click_return_cash_reset'] = 'Klikk %sHer%s for å returnere til Valuta Tilbakestilling';
$lang['User_updated'] = '%s oppdatert<br />';

//
// Others
//

// Exchange
$lang['Cash_exchange'] = 'Cash Mod Veksling';
$lang['Cash_exchange_explain'] = 'I skjemaet nedenfor kan du stille inn den relative verdien av Myntenheter, og tillate brukerne å veksle.';

$lang['Exchange_insufficient_currencies'] = 'Du har ikke laget mange nok myntenheter for å sette opp veksling<br />Minst 2 kreves';

// Forums
$lang['Forum_cm_settings'] = 'Cash Mod Forum Innstillinger';
$lang['Forum_cm_settings_explain'] = 'Fra dette panelet kan du sette opp hvilke forum som skal ha Cash Mod aktivert';

// Groups
$lang['Cash_groups'] = 'Cash Mod Grupper';
$lang['Cash_groups_explain'] = 'Fra dette panelet kan du sette opp spesielle privelegier mot rangering, brukergrupper, administratorer og moderatorer';

$lang['Click_return_cash_groups'] = 'Klikk %sHer%s for å returnere til Cash Mod Grupper';
$lang['Cash_groups_updated'] = 'Cash Mod Grupper Oppdatert';

$lang['Set'] = 'Sett';
$lang['Up'] = 'Opp';
$lang['Down'] = 'Ned';

// Help
$lang['Cmh_support'] = 'Cash Mod Brukerstøtte';
$lang['Cmh_troubleshooting'] = 'Problemløsning';
$lang['Cmh_upgrading'] = 'Oppgradering';
$lang['Cmh_addons'] = 'Utvidelser';
$lang['Cmh_demo_boards'] = 'Demo Forum';
$lang['Cmh_translations'] = 'Oversettelser';
$lang['Cmh_features'] = 'Funksjoner';

$lang['Cmhe_support'] = 'Generell informasjon';
$lang['Cmhe_troubleshooting'] = 'Hvis du har problemer med Cash Mod, se etter feilrettinger her';
$lang['Cmhe_upgrading'] = 'Du har for øyeblikket versjon %s, oppgraderinger for siste versjon vil legges ut her';
$lang['Cmhe_addons'] = 'En liste over MOD\'er som tar i bruk Cash Mod\'s muligheter';
$lang['Cmhe_demo_boards'] = 'En liste over noen demo forum som bruker Cash Mod';
$lang['Cmhe_translations'] = 'En liste over oversettelser for Cash Mod';
$lang['Cmhe_features'] = 'En liste over Cash Mod\'s funksjoner, og utvikling av fremtidige versjoner';

// Logs
$lang['Logs'] = 'Cash Mod Logger';
$lang['Logs_explain'] = 'Fra dette panelet kan du se loggede Cash Mod hendelser';

// Settings
$lang['Cash_settings'] = 'Cash Mod Innstillinger';
$lang['Cash_settings_explain'] = 'I skjemaet nedenfor kan du justere alle myntenhet innstillinger.';


$lang['Display'] = 'Skjermbilde';
$lang['Implementation'] = 'Implementasjon';
$lang['Allowances'] = 'Ukelønner';
$lang['Allowances_explain'] = 'Ukelønner krever Cash Mod Allowances plug-in';
$lang['Click_return_cash_settings'] = 'Klikk %sHer%s for å returnere til Cash Mod Innstillinger';
$lang['Cash_settings_updated'] = 'Cash Mod Settings Updated Successfully';

$lang['Cash_enabled'] = 'Aktivér Myntenhet';
$lang['Cash_custom_currency'] = 'Spesiell Myntenhet for Cash Mod';
$lang['Cash_image'] = 'Vis myntenheten som et bilde';
$lang['Cash_imageurl'] = 'Bilde (Ralativ til phpBB2 rot sti):';
$lang['Cash_imageurl_explain'] = 'Bruk dette for å definere alle småbilder assosiert med myntenheten';
$lang['Prefix'] = 'Prefix';
$lang['Postfix'] = 'Postfix';
$lang['Cash_currency_style'] = 'Myntenhetstil for Cash Mod';
$lang['Cash_currency_style_explain'] = 'Myntenhetsymbol som ' . $lang['Prefix'] . ' or ' . $lang['Postfix'];
$lang['Cash_display_usercp'] = 'Vis opptjente midler i bruker kontrollpanel';
$lang['Cash_display_userpost'] = 'Vis opptjente midler i Post Profil';
$lang['Cash_display_memberlist'] = 'Vis opptjente midler i medlemslisten';

$lang['Cash_amount_per_post'] = 'Beløp utbetalt for hvert nye tema';
$lang['Cash_amount_post_bonus'] = 'Bonus utbetalt til forfatter for hvert svar på tema';
$lang['Cash_amount_per_reply'] = 'Beløp utbetalt for hvert svar';
$lang['Cash_amount_per_character'] = 'Beløp utbetalt per bokstav';
$lang['Cash_maxearn'] = 'Maksimum beløp opptjent for innlegg';
$lang['Cash_amount_per_pm'] = 'Beløp utbetalt per private beskjed';
$lang['Cash_include_quotes'] = 'Ta med sitat når beløp per bokstav skal utregnes';
$lang['Cash_exchangeable'] = 'Tillat brukere å veksle denne myntenheten';
$lang['Cash_allow_donate'] = 'Tillat brukere å donere midler til andre spillere';
$lang['Cash_allow_mod_edit'] = 'Tillat moderatorer å modifisere brukernes kontoer';
$lang['Cash_allow_negative'] = 'Tillat brukere å ha negative beløp på konto';

$lang['Cash_allowance_enabled'] = 'Aktiver ukelønn';
$lang['Cash_allowance_amount'] = 'Beløp utbetalt som ukelønn';
$lang['Cash_allownace_frequency'] = 'Hvor ofte ukelønn blir utbetalt';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_DAY] = 'Dag';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_WEEK] = 'Uke';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_MONTH] = 'Måned';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_YEAR] = 'År';
$lang['Cash_allowance_next'] = 'Tid før neste ukelønn';

// Groups
$lang['Cash_status_type'][CASH_GROUPS_DEFAULT] = 'Standard';
$lang['Cash_status_type'][CASH_GROUPS_CUSTOM] = 'Spesiell';
$lang['Cash_status_type'][CASH_GROUPS_OFF] = 'Av';
$lang['Cash_status'] = 'Status';

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
$lang['Cash_clause'][CASH_LOG_DONATE] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> donert <b>%s</b> til <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>';

/* argument order: [admin/mod id][admin/mod name][editee id][editee name][Added list][removed list][Set list]

eg.
Joe modified Peter's Cash:
Added 14 gold
Removed $10
Set 3 points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_MODEDIT] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new">%s</a> modifiserte <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>\'s Valuta:<br />Lagt til <b>%s</b><br />Trukket fra <b>%s</b><br />Satt til <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe created points 
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_CREATE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> skapte <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe deleted $ 
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_DELETE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> slettet <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][old currency name][new currency name]

eg.
Joe renamed silver to gold
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_RENAME_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> døpte om <b>%s</b> til <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][copied currency name][copied over currency name]

eg.
Joe copied users' gold to points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_COPY_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> kopierte brukerens <b>%s</b> to <b>%s</b>';

$lang['Log'] = 'Logg';
$lang['Action'] = 'Action';
$lang['Type'] = 'Type';
$lang['Cash_all'] = 'Alle';
$lang['Cash_admin'] = 'Admin';
$lang['Cash_user'] = 'Bruker';
$lang['Delete_all_logs'] = 'Slett alle logger';
$lang['Delete_admin_logs'] = 'Slett adminlogger';
$lang['Delete_user_logs'] = 'Slett brukerlogger';
$lang['All'] = 'Alle';
$lang['Day'] = 'Dag';
$lang['Week'] = 'Uke';
$lang['Month'] = 'Måned';
$lang['Year'] = 'År';
$lang['Page'] = 'Side';
$lang['Per_page'] = 'per side';

//
// Now for some regular stuff...
//

//
// User CP
//
$lang['Donate'] = 'Donere';
$lang['Mod_usercash'] = 'Modifiser %s\'s Valuta';
$lang['Exchange'] = 'Veksle';

//
// Exchange
//
$lang['Convert'] = 'Konvertere';
$lang['Select_one'] = 'Velg En';
$lang['Exchange_lack_of_currencies'] = 'Det er ikke laget mange nok myntenheter for å få vekslet<br />For å aktivere denne funksjonen, må administrator lage minst 2 myntenheter';
$lang['You_have'] = 'Du har';
$lang['One_worth'] = 'En %s er verdt:';
$lang['Cannot_exchange'] = 'Du kan ikke veksle %s, for øyeblikket';

//
// Donate
//
$lang['Amount'] = 'Beløp';
$lang['Donate_to'] = 'Donér til %s';
$lang['Donation_recieved'] = 'Du har mottat en donasjon fra %s';
$lang['Has_donated'] = '%s har donert [b]%s[/b] til deg. \n\n%s skrev:\n';

//
// Mod Edit
//
$lang['Add'] = 'Legge til';
$lang['Remove'] = 'Ta bort';
$lang['Omit'] = 'Utelate';
$lang['Amount'] = 'Beløp';
$lang['Donate_to'] = 'Donér til %s';
$lang['Has_moderated'] = '%s har moderert din %s';
$lang['Has_added'] = '[*]Lagt til: [b]%s[/b]\n';
$lang['Has_removed'] = '[*]Trukket fra: [b]%s[/b]\n';
$lang['Has_set'] = '[*]Satt til: [b]%s[/b]\n';

// That's all folks!

?>