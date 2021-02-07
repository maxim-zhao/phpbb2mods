<?php
/***************************************************************************
 *                               lang_contact.php
 *                              ------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *   	Copyright:	(C) 2006, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:21 01/06/2007
 *
 *	Translated by:	Dark Inca
 *	E-mail:		darkinca@multimedia-madness.be
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

$lang['Contact_intro'] = 'Als je commentaar of suggesties hebt over de site, of als je problemen hebt met het registreren of inloggen van je account, gebruik dan dit formulier om de Admin zo snel mogelijk te contacteren.';

$lang['Username'] = 'Gebruikersnaam';
$lang['Real_name'] = 'Echte Naam';
$lang['Rname_require'] = 'Echte Naam *';
$lang['E-mail'] = 'E-mail Adres';
$lang['E-mail_require'] = 'E-mail Adres *';
$lang['Comments'] = 'Commentaar';
$lang['Comments_require'] = 'Commentaar *';
$lang['Attachment'] = 'Bijlage';

$lang['Feedback'] = 'Feedback ontvangen';

$lang['Real_name_explain'] = 'Vul je naam hier in. Dit helpt ons je te contacteren als je niet bent geregistreerd.';
$lang['Explain_email'] = 'Vul je e-mail adres hier in. Deze wordt gebruikt indien we je direct willen beantwoorden.';
$lang['Comments_explain'] = 'Vul je feedback commentaar hier in.';
$lang['Flood_explain'] = '<br /><br />Dit formulier heeft een flood controle systeem. Je mag per %s %s dit formulier versturen.';
$lang['Comments_limit'] = '<br /><br />De Admin heeft een maximum van %s karakters toegestaan in je bericht.';
$lang['Attachment_explain'] = 'Post een bijlage hier, indien nodig, en het zal worden ontvangen door de board admin. Alleen bestanden van %sKb of kleiner zijn toegestaan.';

$lang['Guest'] = 'Gast';
$lang['Notify_IP'] = 'Je IP adres zal opgenomen worden voor veiligheids kwesties.';
$lang['Fields_required'] = 'Velden met een * zijn vereist.';
$lang['Contact_form'] = 'Contact Formulier';
$lang['Empty'] = 'Niet ingevuld';

$lang['hours'] = 'uren';
$lang['hour'] = 'uur';

$lang['Chars'] = ' karakters';

$lang['Captcha_code'] = 'Captcha *';
$lang['Captcha_code_explain'] = 'Bevestig de code in de afbeelding. Deze is nodig om spambots tegen te houden.';

//
// Errors
//
$lang['Rname-Empty'] = 'Je echte naam is niet ingevuld.';
$lang['Comments-Empty'] = 'Er is geen commentaar ingevuld';
$lang['Comments_exceeded'] = 'Je bericht is langer dan toegestaan.';
$lang['Email-Empty'] = 'Je e-mail adress is niet ingevuld.';
$lang['Email-Check'] = 'je gegeven e-mail adress is niet geldig.';
$lang['Attach-File_exists'] = 'Het bestand bestaat al met die naam vanaf je IP adres.';
$lang['Attach-Too_big'] = 'De bijlage dat je probeerde te verzenden is te groot. Zorg ervoor dat het kleiner is dan %sKb .';
$lang['Attach_dud'] = 'De bijlage dat je probeerde te verzenden bestaat niet. Controleer je upload link.';
$lang['Attach-Uploaded'] = 'Je bijlage is succesvol geupload.';
$lang['Flood_limit'] = 'Sorry, maar je moet %d u(u)r(en) wachten totdat je een ander formulier kunt versturen.';
$lang['Illegal_ext'] = 'Dit bestandstype (%s) is niet toegestaan!';
$lang['Unknown_ext'] = 'Dit bestandstype %s) kan niet worden geaccepteerd!';
$lang['zip_advise'] = 'Indien nodig, zip het bestand voor dat je het opnieuw verzend.';
$lang['POST_ERROR'] = 'Upload Error - Probeer het aub opnieuw!';
$lang['Image_error'] = 'Upload Error - Onmogelijk om deze afbeelding te verwerken!';
$lang['Image_zip'] = 'Please zip dit type afbeelding voordat je het verzend.';
$lang['Code_Empty'] = 'Je hebt de code afbeelding niet bevestgd!';
$lang['Code_Wrong'] = 'De ingevulde code is niet correct!';

$lang['Contact_error'] = '<b>Er is een error voor gekomen wanneer je je feedback probeerde te verzenden!</b>';
$lang['Contact_success'] = '<b>Je bericht is succesvol verzonden !</b>';

$lang['Click_return_form'] = '<br /><br />Klik %sHier%s om terug te gaan naar het Contact formulier';

$lang['Contact_Disabled'] = 'Het Contact Formulier is momenteel niet beschikbaar';

//
// Admin
//
$lang['General_settings'] = 'Algemene Instellingen';
$lang['Contact_title'] = 'Contact Formulier';
$lang['Contact_explain'] = 'Gebruik deze pagina om instellingen en kenmerken te veranderen van het Contact Formulier, evenal de benodigde velden.';
$lang['Req_settings'] = 'Behoefte Instellingen';
$lang['Attachment_settings'] = 'Bijlage Instellingen';
$lang['Contact_updated'] = 'Contact Configuratie Succesvol geupdate';
$lang['Click_return_contact'] = 'Klik %sHier%s om terug te gaan naar de Contact formulier instellingen';
$lang['Admin_email_explain'] = 'Indien leeg, e-mails zullen worden verzonden naar de hoofdbeheerder van dit forum.';

$lang['Form_Enable'] = 'Activeer contact formulier';

$lang['kb'] = 'kilobytes';

$lang['Hash'] = 'Bijlage Hashing Methode';
$lang['Hash_explain'] = 'Alle uploads kunnen worden hernoemt naar een willekeurige hash, voor verhoogde beveiliging.';
$lang['md5'] = 'MD5';
$lang['no_hash'] = 'Geen Hash';

$lang['auth_permission'] = 'Bijlage Toestemmingen';
$lang['auth_perm_explain'] = 'Als bijlagen toegestaan zijn, dan kan je selecteren wie bestanden kan uploaden.';
$lang['auth_guests'] = 'Gasten';
$lang['auth_members'] = 'Leden';
$lang['auth_mods'] = 'Moderators';
$lang['auth_admins'] = 'Admins';

$lang['Require_rname'] = 'Vereis Echte Naam';
$lang['Require_email'] = 'Vereis E-mail';
$lang['Require_comments'] = 'Vereis Commentaar';
$lang['Permit_attachments'] = 'Sta Bijlagen toe';
$lang['Prune'] = 'Activeer flood limiet tabel opruiming';
$lang['Prune_explain'] = 'Activeer dit om SQL entries te verwijderen die hun flood limiet functie al hebben gedaan, om database grootte te verkleinen.';
$lang['Max_file_size'] = 'Max Bestandsgrootte';
$lang['Max_file_size_explain'] = 'De maximum bestandsgrootte voor bijlages die worden opgeslagen op je webserver . Onthoud dat dit niet je php.ini instellingen kan overschrijven. (%s)';
$lang['File_root'] = 'Bijlage bestands map';
$lang['File_root_explain'] = 'De map waar alle bijlages worden opgeslagen. De map moet worden ge-CHMOD naar 777 en is relatief aan de phpBB map pad.';
$lang['Flood_limit_admin'] = 'Flood Limiet';
$lang['Flood_limit_admin_explain'] = 'Dit is de tijd die toegestaan voordat een gebruiker een nieuw formulier kan versturen. Set naar \'0\' om deze functie uit te schakelen (alleen aanbevolen voor testen).';
$lang['Char_limit_admin'] = 'Maximum Karakters';
$lang['Char_limit_admin_explain'] = 'Je kan de maximum aantal karakters setten die mogelijk zijn in je bericht.  Set naar \'0\' om deze functie uit te schakelen.';

$lang['Captcha'] = 'Captcha opties';
$lang['Activate'] = 'Activeer Captcha?';
$lang['Enable'] = 'Inschakelen';
$lang['Disable'] = 'Uitschakelen';
$lang['Captcha_explain'] = 'Schakel deze optie in zodat gebruikers vereist zijn een code in te vullen voordat ze het formulier verzenden. Dit zal voorkomen dat spambots je formulier misbruiken.';
$lang['Type'] = 'Captcha uiterlijk';
$lang['Type_explain'] = 'Selecteer het type van Captcha dat je wilt laten zien op je formulier .';
$lang['Image_bg'] = 'Afbeelding gebaseerd';
$lang['Coloured'] = 'Gekleurd';
$lang['Random'] = 'Willekeurig';

$lang['Copyright'] = '"Contact Formulier" door <a href="http://www.phobbia.net/mods/" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy; 2006-2007<br />(Originele mod: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Snel verwijderen';
$lang['QDelete_disabled'] = 'De optie snel verwijderen is uitgeschakeld';
$lang['File_Not_Here'] = 'De bijlage lijkt niet te bestaat.';
$lang['File_Removed'] = 'Het bestand is succesvol verwijderd.';
$lang['QDelete_explain'] = 'Sta de Admin toe om bijlages snel te verwijderen via een e-mail link?';
$lang['Remove_file'] = 'Om dit bestande te verwijderen, volg deze link: %s';

// 
// "Messages Log" - Added in 8.6.0 
// 
$lang['Contact_date'] = 'Datum';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sDownload%s';
$lang['Contact_remove'] = '%sVerwijder%s';
$lang['Msg_delete'] = 'Verwijder';

$lang['Contact_msgs_title'] = 'Contact Formulier :: Berichten log';
$lang['Contact_msgs_text'] = 'Dit zijn de berichten die je hebt ontvangen via je Contact Formulier, met de niewste berichten eerst.<br />&nbsp;&bull; Berichten kunnen worden bekeken en verwijderd.<br />&nbsp;&bull; Toegevoegde bestanden kunnen worden opgehaald en verwijderd.';

$lang['Msg_del_success'] = 'Het bericht was succesvol verwijderd.';
$lang['File_del_success'] = 'De bijlage was succesvol verwijderd';
$lang['Confirm_delete_msg'] = 'Ben je zeker dat je dit bericht wilt verwijderen?';
$lang['Confirm_delete_file'] = 'Ben je zeker dat je deze bijlage wilt verwijderen?';
$lang['File_Not_Here'] = 'De bijlage lijkt niet te bestaan.';
$lang['Click_return_msglog'] = 'Klik %sHier%s om terug te keren naar de Berichten Log';

$lang['Msg_Log'] = 'Berichten Log';
$lang['Msg_Log_explain'] = 'Dit activeren laat je toe om berichten op te slaan in je database als referentie';

$lang['more'] = 'meer';

//
// "Thank You" - Added in 8.9.8
//
$lang['Thankyou_settings'] = '"Bedankt" instellingen';
$lang['Thankyou_option'] = 'Bedank de zender';
$lang['Thankyou_explain'] = 'Stel "Niemand" in om te deactiveren, "Leden" voor alleen geregistreerde gebruikers of "Iedereen" voor ook de gasten.';
$lang['Thank_none'] = 'Niemand';
$lang['Thank_members'] = 'Leden';
$lang['Thank_all'] = 'Iedereen';
$lang['Thankyou_limit'] = 'Sorry, we kunnen niet meer feedback accepteren van dit e-mailadres voor 24 uur.';

?>