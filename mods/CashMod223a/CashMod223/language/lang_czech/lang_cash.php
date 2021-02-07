<?php

/***************************************************************************
 *                            lang_cash.php [Czech]
 *                              -------------------
 *     begin                : sobota, 06. srpen 2005
 *     copyright            : (C) 2005 by mullDie, Kaspy (www.cznonsteam.tk)
 *     email                : mullder@zliv.net, kaspy@kaspy.net 
 *
 *     
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

// Revised by churchyard

//
// Admin menu
//
$lang['Cmcat_main'] = 'Hlavní';
$lang['Cmcat_addons'] = 'Doplòky';
$lang['Cmcat_other'] = 'Ostatní';
$lang['Cmcat_help'] = 'Pomoc';

$lang['Cash_Configuration'] = 'Cash&nbsp;Konfigurace';
$lang['Cash_Currencies'] = 'Cash&nbsp;Mìny';
$lang['Cash_Exchange'] = 'Cash&nbsp;Výmìna';
$lang['Cash_Events'] = 'Cash&nbsp;Události';
$lang['Cash_Forums'] = 'Cash&nbsp;Forums';
$lang['Cash_Groups'] = 'Cash&nbsp;Skupiny';
$lang['Cash_Help'] = 'Cash&nbsp;Pomoc';
$lang['Cash_Logs'] = 'Cash&nbsp;Logy';
$lang['Cash_Settings'] = 'Cash&nbsp;Nastavení';

$lang['Cmenu_cash_config'] = 'Golbální Cash Mód Nastavení platí na všechny mìny';
$lang['Cmenu_cash_currencies'] = 'Pøidat, Odstranit, nebo pøeskupit mìny';
$lang['Cmenu_cash_settings'] = 'Specifická nastavení pro každou mìnu';
$lang['Cmenu_cash_events'] = 'Hotovosti které se rozdávaní uživatelùm za události';
$lang['Cmenu_cash_reset'] = 'Vynulovat nebo Pøepoèítat úèty';
$lang['Cmenu_cash_exchange'] = 'Umožnit/Vyøadit smìnárnu  kursù mìn';
$lang['Cmenu_cash_forums'] = 'Zapnout mìnu pro každé fórum';
$lang['Cmenu_cash_groups'] = 'Zvláštní nastavení pro skupiny, hodnosti a úrovnì';
$lang['Cmenu_cash_log'] = 'Ukázat/Smazat Logy Cash Mód dìní';
$lang['Cmenu_cash_help'] = 'Cash Mód Nápovìda';

// Config
$lang['Cash_config'] = 'Cash Mód Konfigurace';
$lang['Cash_config_explain'] = 'Formuláø který vám dovoluje nastavit Cash Mód konfiguraci.';

$lang['Cash_admincp'] = 'Cash Mód AdminCP Mode';
$lang['Cash_adminnavbar'] = 'Cash Mód Podrobnosti';
$lang['Sidebar'] = 'Podrobnosti';
$lang['Menu'] = 'Menu';

$lang['Messages'] = 'Zprávy';
$lang['Spam'] = 'Spam';
$lang['Click_return_cash_config'] = 'Kliknìte %szde%s pro vrácení do Cash Mód Konfigurace';
$lang['Cash_config_updated'] = 'Cash Mód konfigurace byla úspešnì aktualizována';
$lang['Cash_disabled'] = 'Vypnout Cash Mód';
$lang['Cash_message'] = 'Ukázat pøi odeslání odpovìïi/pøízpìvku Zprávu o pøijatých pøíjmech';
$lang['Cash_display_message'] = 'Zpráva ukazující uživateli pøíjmy';
$lang['Cash_display_message_explain'] = 'Musí obsahovat "%s" ';
$lang['Cash_spam_disable_num'] = 'Èíslo, které urèuje, po kolika pøíspìvcích se májí vyøadit pøíjmy (spam ochrana) ';
$lang['Cash_spam_disable_time'] = 'Doba kterou musí pøesahovat rozdíl mezi pøíspìvky (hodiny)';
$lang['Cash_spam_disable_message'] = 'Oznámení pri nulovém výdìleku';

// Currencies
$lang['Cash_currencies'] = 'Cash Mód Mìny';
$lang['Cash_currencies_explain'] = 'Formuráø který vám dovoluje konfigurovat vaše mìny';

$lang['Click_return_cash_currencies'] = 'Kliknìte %szde%s navrácení do Cash Mód Mìny';
$lang['Cash_currencies_updated'] = 'Cash Mód Mìny byly úzpešnì aktualizovány';
$lang['Cash_field'] = 'Pole';
$lang['Cash_currency'] = 'Mìna';
$lang['Name_of_currency'] = 'Název Mìny';
$lang['Default'] = 'Standart';
$lang['Cash_order'] = 'Ostatní';
$lang['Cash_set_all'] = 'Nastavit všem uživatelùm';
$lang['Cash_delete'] = 'Smazat Mìnu';
$lang['Decimals'] = 'Desetiny';

$lang['Cash_confirm_copy'] = 'Zkopírovat data všech uživatelù %s do %s?<br />Nelze vzít zpìt';
$lang['Cash_confirm_delete'] = 'Smazat %s?<br />Nelze vzít zpìt';

$lang['Cash_copy_currency'] = 'Kopírovat Mìnová data';

$lang['Cash_new_currency'] = 'Vytvoøit Novou mìnu';
$lang['Cash_currency_dbfield'] = 'Databazové pole pro mìnu';
$lang['Cash_currency_decimals'] = 'Poèet desetiných míst pro mìnu';
$lang['Cash_currency_default'] = 'Standartní hodnota pro mìny';

$lang['Bad_dbfield'] = 'Špatnì udané informace, informace musí být ve tvaru \'user_slovo\'<br /><br />%s<br /><br/>Napøíklad:<br />user_points<br />user_cash<br />user_money<br />user_warnings<br /><br />';

// 0 currencies (most admin panels won't work... )
$lang['Insufficient_currencies'] = 'Nejprve potøebujete vytvoøit mìny, až potom zmìnit nastavení';

//
// Add-ons ?
//

// Events
$lang['Cash_events'] = 'Události Cash Módu';
$lang['Cash_events_explain'] = 'Zde mùžete nastavit úèty pro existující údálosti.';

$lang['No_events'] = 'Žádné zavedené úèty';
$lang['Existing_events'] = 'Existující úèty';
$lang['Add_an_event'] = 'Pøidat úèet';
$lang['Cash_events_updated'] = 'Úprava probìhla úspìšnì';
$lang['Click_return_cash_events'] = 'Kliknìte %szde%s do Událostí Cash Módu';

//Reset
$lang['Cash_reset_title'] = 'Restart Cash Módu';
$lang['Cash_reset_explain'] = 'Zde mùžete resetovat všechny úèty uživatelù na urèitou hodnotu';

$lang['Cash_resetting'] = 'Resetování';
$lang['User_of'] = 'Uživatl %s z %s';

$lang['Set_checked'] = 'Nastavit vybranou hodnotu';
$lang['Recount_checked'] = 'Zkontrolovat nastavenou hodnotu';

$lang['Cash_confirm_reset'] = 'Potvrdit reset?<br />Nelze se vrátit zpìt';
$lang['Cash_confirm_recount'] = 'Potvrdit nahrazení vybrané mìny?<br />Nelze se vrátit zpìt.<br /><br />Toto je doporuèeno pro fóra s mnoha uživately a/nebo pøíspìvky.<br /><br />Je doporuèeno vypnout své fórum pøed provedením. <br />Fórum mùžete vypnout pøes %sNastavení%';

$lang['Update_successful'] = 'Zmìna kompletní!';
$lang['Click_return_cash_reset'] = 'Kliknìte %szde%s pro návrat do Restartu Cash Módu.';
$lang['User_updated'] = '%s updatováno<br />';

//
// Others
//

// Exchange
$lang['Cash_exchange'] = 'Zmìna Cash Módu';
$lang['Cash_exchange_explain'] = 'Zde mùžete nastavit vzájemnou cenu mìn a povolit uživatelùm výmìnu.';

$lang['Exchange_insufficient_currencies'] = 'Nemáte vytvoøený dostateèný poèet mìn vytvoøených pro výmìnné kurzy.<br />Minimálnì jsou požadovány 2.';

// Forums
$lang['Forum_cm_settings'] = 'Nastavení Cash Mód Forum';
$lang['Forum_cm_settings_explain'] = 'V tomto panelu mùžete nastavit v jaké èasti fóra funguje Cash Mód';

// Groups
$lang['Cash_groups'] = 'Skupiny Cash Módu';
$lang['Cash_groups_explain'] = 'V tomto panelu mùžete nastavit hodnocení, uživatelské skupiny, administrátory a moderátory';

$lang['Click_return_cash_groups'] = 'Kliknìte %szde%s pro návrat do Skupin';
$lang['Cash_groups_updated'] = 'Skupiny byly úspìšnì aktualizovány';

$lang['Set'] = 'Nastav';
$lang['Up'] = 'Nahorù';
$lang['Down'] = 'Dolù';

// Help
$lang['Cmh_support'] = 'Podpora Cash Módu';
$lang['Cmh_troubleshooting'] = 'Problémy';
$lang['Cmh_upgrading'] = 'Upgradování';
$lang['Cmh_addons'] = 'Add-Ony';
$lang['Cmh_demo_boards'] = 'Ukázkové fóra';
$lang['Cmh_translations'] = 'Pøeklady';
$lang['Cmh_features'] = 'Rysy';

$lang['Cmhe_support'] = 'Hlavní informace';
$lang['Cmhe_troubleshooting'] = 'Pokud máte nìjaký problem s Cash Módem, kouknìte sem';
$lang['Cmhe_upgrading'] = 'Právì používáte verzi %s Cash módu, novìjší verze najdete zde';
$lang['Cmhe_addons'] = 'Seznam módù, které využívají Cash Mód';
$lang['Cmhe_demo_boards'] = 'Seznam fór využívající Cash Mód';
$lang['Cmhe_translations'] = 'Seznam pøekladù pro Cash Mód';
$lang['Cmhe_features'] = 'Seznam funkcí Cash Módu a seznam pøipravovaných vylepšení';

// Logs
$lang['Logs'] = 'Logy Cash Módu';
$lang['Logs_explain'] = 'Z tohoto panelu mùžete vydìt všechno dìní okolo penìz';

// Settings
$lang['Cash_settings'] = 'Nastavení Cash Módu';
$lang['Cash_settings_explain'] = 'Formuláøe dole umožní vlastní nastavení módu.';


$lang['Display'] = 'Zobraz';
$lang['Implementation'] = 'Realizace';
$lang['Allowances'] = 'Pøíjmy';
$lang['Allowances_explain'] = 'Odmìny vyžadují Cash Mod Allowances plug-in';
$lang['Click_return_cash_settings'] = 'Kliknìte %szde%s pro návrat do Nastavení Cash módu';
$lang['Cash_settings_updated'] = 'Nastavení Cash Módu bylo úspìšné.';

$lang['Cash_enabled'] = 'Zapnout mìnu';
$lang['Cash_custom_currency'] = 'Vlastní mìna pro Cash Mod';
$lang['Cash_image'] = 'Zobraz mìnu jako obrázek';
$lang['Cash_imageurl'] = 'Obrázek (Cesta od phpBB2 root složky):';
$lang['Cash_imageurl_explain'] = 'Použijte pro slouèení malého obrázku s mìnou';
$lang['Prefix'] = 'Pøedpona';
$lang['Postfix'] = 'Pøípona';
$lang['Cash_currency_style'] = 'Styl mìny pro Cash Mód';
$lang['Cash_currency_style_explain'] = 'Symbol mìny je ' . $lang['Prefix'] . ' nebo ' . $lang['Postfix'];
$lang['Cash_display_usercp'] = 'Zobraz pøijmy v profilu';
$lang['Cash_display_userpost'] = 'Zobraz pøíjmy u pøíspìvku';
$lang['Cash_display_memberlist'] = 'Zobraz pøíjmy v Seznamu uživatelù';

$lang['Cash_amount_per_post'] = 'Výdìlek za nové Téma';
$lang['Cash_amount_post_bonus'] = 'Výdìlek za odpovìd pro autora Tématu';
$lang['Cash_amount_per_reply'] = 'Výdìlek za odpovìï';
$lang['Cash_amount_per_character'] = 'Výdìlek za každý napsaný znak';
$lang['Cash_maxearn'] = 'Maximální výdìlek za Pøíspìvek';
$lang['Cash_amount_per_pm'] = 'Výdìlek za Soukromou zprávu';
$lang['Cash_include_quotes'] = 'Zahrnout Citace pøi poèítání za znaky';
$lang['Cash_exchangeable'] = 'Povolit uživatelùm mìnit peníze';
$lang['Cash_allow_donate'] = 'Povolit uživatelùm platit jiným';
$lang['Cash_allow_mod_edit'] = 'Povolit moderátorùm mìnit peníze uživatelùm';
$lang['Cash_allow_negative'] = 'Povolit záporné jednotky';

$lang['Cash_allowance_enabled'] = 'Povolit Výplaty';
$lang['Cash_allowance_amount'] = 'Èástka penìz získaná jako Výplata';
$lang['Cash_allownace_frequency'] = 'Jak èasto se Výplata vyplácí';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_DAY] = 'Den';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_WEEK] = 'Týden';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_MONTH] = 'Mìsíc';
$lang['Cash_allownace_frequencies'][CASH_ALLOW_YEAR] = 'Rok';
$lang['Cash_allowance_next'] = 'Èas do další Výplaty';

// Groups
$lang['Cash_status_type'][CASH_GROUPS_DEFAULT] = 'Standartní';
$lang['Cash_status_type'][CASH_GROUPS_CUSTOM] = 'Vlastní';
$lang['Cash_status_type'][CASH_GROUPS_OFF] = 'Vypnuta';
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
$lang['Cash_clause'][CASH_LOG_DONATE] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> daroval <b>%s</b> pro <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>'; // churchyard

/* argument order: [admin/mod id][admin/mod name][editee id][editee name][Added list][removed list][Set list]

eg.
Joe modified Peter's Cash:
Added 14 gold
Removed $10
Set 3 points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_MODEDIT] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new">%s</a> upravil Cash uživatele <a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a>:<br />Pøidáno: <b>%s</b><br />Ubráno: <b>%s</b><br />Výsledek: <b>%s</b>'; //churchyard

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe created points 
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_CREATE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> vytvoøil <b>%s</b>'; // churchyard

/* argument order: [admin/mod id][admin/mod name][currency name]

eg.
Joe deleted $ 
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_DELETE_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> smazal <b>%s</b>'; // churchyard

/* argument order: [admin/mod id][admin/mod name][old currency name][new currency name]

eg.
Joe renamed silver to gold
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_RENAME_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> pøejmenoval <b>%s</b> na <b>%s</b>';

/* argument order: [admin/mod id][admin/mod name][copied currency name][copied over currency name]

eg.
Joe copied users' gold to points
*/
$lang['Cash_clause'][CASH_LOG_ADMIN_COPY_CURRENCY] = '<a href="' . $phpbb_root_path . 'profile.' . $phpEx . '?mode=viewprofile&u=%s" target="_new"><b>%s</b></a> zkopíroval užiavelovy <b>%s</b> na <b>%s</b>'; // churchyard

$lang['Log'] = 'Log';
$lang['Action'] = 'Akce';
$lang['Type'] = 'Typ';
$lang['Cash_all'] = 'Všechny';
$lang['Cash_admin'] = 'Admin';
$lang['Cash_user'] = 'Uživatel';
$lang['Delete_all_logs'] = 'Vymaž všechny logy';
$lang['Delete_admin_logs'] = 'Vymaž logy adminù';
$lang['Delete_user_logs'] = 'Vzmaž logy uživatelù';
$lang['All'] = 'Všechny';
$lang['Day'] = 'Den';
$lang['Week'] = 'Týden';
$lang['Month'] = 'Mìsíc';
$lang['Year'] = 'Rok';
$lang['Page'] = 'Stránka';
$lang['Per_page'] = 'na stránku';

//
// Now for some regular stuff...
//

//
// User CP
//
$lang['Donate'] = 'Zapla';
$lang['Mod_usercash'] = 'Upravit %s\'s Cash';
$lang['Exchange'] = 'Vymìn';

//
// Exchange
//
$lang['Convert'] = 'Pøeveï';
$lang['Select_one'] = 'Vyber';
$lang['Exchange_lack_of_currencies'] = 'Není zde dostatek mìny, abyste mohle pøevádìt<br />Aby to šlo, administrátor musí vytvoøit alespoò 2 mìny'; // by churchyard
$lang['You_have'] = 'Máte';
$lang['One_worth'] = 'Jeden %s je:';
$lang['Cannot_exchange'] = 'Nemùžete vymìnit %s, právì máte';

//
// Donate
//
$lang['Amount'] = 'Èástka';
$lang['Donate_to'] = 'Darovat %s';
$lang['Donation_recieved'] = 'Dostali jste pøíspìvek od %s';
$lang['Has_donated'] = '%s vám pøispìl [b]%s[/b]. \n\n%s napsal:\n'; // churchyard
// $lang['Has_donated'] = '%s vám pøispìl [b]%s[/b]. \n\n%s napsal(a):\n'; // churchyard

//
// Mod Edit
//
$lang['Add'] = 'Pøidej';
$lang['Remove'] = 'Odeber';
$lang['Omit'] = 'Odmítnout';
$lang['Amount'] = 'Èástka';
$lang['Donate_to'] = 'Daruj %s';
$lang['Has_moderated'] = '%s upravil %s';
$lang['Has_added'] = '[*]Pøidal: [b]%s[/b]\n';
$lang['Has_removed'] = '[*]Odebral: [b]%s[/b]\n';
$lang['Has_set'] = '[*]Nastavil: [b]%s[/b]\n';

//
// That's all folks!
//

?>
