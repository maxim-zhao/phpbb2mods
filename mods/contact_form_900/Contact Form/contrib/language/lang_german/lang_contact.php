<?php
/***************************************************************************
 *                               lang_contact.php - German
 *                              ---------------------------
 *
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *	Copyright:	(C) 2006, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:22 01/06/2007
 *
 *	Translated by:	Lefty74
 *	Translated by:	IPB_Refugee
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software;you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation;either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

$lang['Contact_intro'] = 'Solltest Du Kommentare, Feedback oder Vorschläge in Bezug auf diese Seite haben, oder wenn Probleme beim Registrieren oder Einloggen aufgetreten sind, dann benutze bitte dieses Formular, um mit dem Administrator in Kontakt zu treten.';

$lang['Username'] = 'Benutzername';
$lang['Real_name'] = 'Wirklicher Name';
$lang['Rname_require'] = 'Wirklicher Name *';
$lang['E-mail'] = 'E-Mail Adresse';
$lang['E-mail_require'] = 'E-Mail Adresse *';
$lang['Comments'] = 'Kommentar';
$lang['Comments_require'] = 'Kommentar *';
$lang['Attachment'] = 'Attachment';

$lang['Feedback'] = 'Feedback erhalten';

$lang['Real_name_explain'] = 'Trage hier Deinen Namen ein. Dies hilft uns, mit Dir in Kontakt zu treten, falls Du nicht registriert bist.';
$lang['Explain_email'] = 'Trage hier Deine E-Mail Adresse ein. Diese wird benutzt, falls wir Dir direkt antworten müssen.';
$lang['Comments_explain'] = 'Gib hier Dein Feedback oder Deinen Kommentar ein.';
$lang['Flood_explain'] = '<br /><br />Dieses Formular besitzt ein Flood Control System. Du kannst dieses Formular nur einmal alle %s %s absenden.';
$lang['Comments_limit'] = '<br /><br />Der Admin hat maximal %s Zeichen in dieser Nachricht erlaubt.';
$lang['Attachment_explain'] = 'Wenn Du möchtest, kannst Du dem Administrator ein Attachment mitsenden. Nur Dateien mit höchstens %sKb sind erlaubt.';

$lang['Guest'] = 'Gast';
$lang['Notify_IP'] = 'Deine IP-Adresse wird aus Sicherheitsgründen gespeichert.';
$lang['Fields_required'] = 'Felder, die mit einem * gekennzeichnet sind, müssen ausgefüllt werden.';
$lang['Contact_form'] = 'Kontaktformular';
$lang['Empty'] = 'Nicht spezifiziert';

$lang['hours'] = 'Stunden';
$lang['hour'] = 'Stunde';

$lang['Chars'] = ' Zeichen';

$lang['Captcha_code'] = 'Captcha *';
$lang['Captcha_code_explain'] = 'Bitte bestätige den Sicherheitscode. Dies ist erforderlich, um Spambots die Arbeit zu erschweren.';

//
// Errors
//
$lang['Rname-Empty'] = 'Dein wirklicher Name wurde nicht eingegeben.';
$lang['Comments-Empty'] = 'Das Kommentarfeld wurde nicht ausgefüllt.';
$lang['Comments_exceeded'] = 'Deine Nachricht ist länger als erlaubt.';
$lang['Email-Empty'] = 'Das E-Mail-Feld wurde nicht ausgefüllt.';
$lang['Email-Check'] = 'Deine eingegebene E-Mail-Adresse ist nicht gültig.';
$lang['Attach-File_exists'] = 'Eine Datei mit diesem Namen existiert schon von Deiner IP-Adresse.';
$lang['Attach-Too_big'] = 'Das Attachment war zu groß. Stelle sicher, dass die Größe maximal %sKb beträgt.';
$lang['Attach_dud'] = 'Das Attachment, das Du zu senden versucht hast, existiert nicht. Bitte überprüfe Deinen Uploadlink.';
$lang['Attach-Uploaded'] = 'Dein Attachment wurde erfolgreich hochgeladen.';
$lang['Flood_limit'] = 'Sorry, aber aus Sicherheitsgründen musst Du %d Stunde(n) warten, bis Du das Formular erneut benutzen kannst.';
$lang['Illegal_ext'] = 'Dieser Dateityp (%s) ist nicht erlaubt!';
$lang['Unknown_ext'] = 'Dieser Dateityp (%s) kann nicht akzeptiert werden!';
$lang['zip_advise'] = 'Falls notwendig, komprimiere die Datei, bevor Du sie erneut sendest.';
$lang['POST_ERROR'] = 'Upload Fehler - Bitte versuche es noch einmal!';
$lang['Image_error'] = 'Upload Fehler - Es ist nicht möglich, dieses Bild zu bearbeiten!';
$lang['Image_zip'] = 'Bitte komprimiere diesen Bildtyp, bevor Du ihn sendest.';
$lang['Code_Empty'] = 'Du hast den visuellen Sicherheitscode nicht bestätigt!';
$lang['Code_Wrong'] = 'Der eingegebene Code war nicht korrekt!';

$lang['Contact_error'] = '<b>Ein Fehler ist beim Senden Deines Feedbacks aufgetreten!</b>';
$lang['Contact_success'] = '<b>Deine Nachricht wurde erfolgreich gesendet!</b>';

$lang['Click_return_form'] = '<br /><br />Klicke %shier,%s um zum Kontaktformular zurückzukehren.';

$lang['Contact_Disabled'] = 'Das Kontaktformular ist zur Zeit leider nicht verfügbar';

//
// Admin
//
$lang['General_settings'] = 'Generelle Einstellungen';
$lang['Contact_title'] = 'Kontaktformular';
$lang['Contact_explain'] = 'Benutze diese Seite, um die Einstellungen und Eigenschaften sowie die benötigten Felder des Kontaktformulars zu ändern.';
$lang['Req_settings'] = 'Einstellungen der benötigten Felder';
$lang['Attachment_settings'] = 'Einstellungen für Attachments';
$lang['Contact_updated'] = 'Die Konfiguration des Kontaktformulars wurde erfolgreich geändert.';
$lang['Click_return_contact'] = 'Klicke %shier%s, um zur Konfiguration des Kontaktformulars zurückzukehren.';
$lang['Admin_email_explain'] = 'Wenn das Feld nicht ausgefüllt wird, werden die E-Mails an den Administrator dieses Boards gesandt.';

$lang['Form_Enable'] = 'Aktiviere das Kontaktformular';

$lang['kb'] = 'Kilobytes';

$lang['Hash'] = 'Attachment Hashing Methode';
$lang['Hash_explain'] = 'Alle Uploads können mit einem Zufalls-Hash zwecks höherer Sicherheit umbenannt werden.';
$lang['md5'] = 'MD5';
$lang['no_hash'] = 'Kein Hash';

$lang['auth_permission'] = 'Attachmentbefugnisse';
$lang['auth_perm_explain'] = 'Wenn Attachments erlaubt sind, kannst Du auswählen, wer Dateien hochladen darf.';
$lang['auth_guests'] = 'Gäste';
$lang['auth_members'] = 'Benutzer';
$lang['auth_mods'] = 'Moderatoren';
$lang['auth_admins'] = 'Administratoren';

$lang['Require_rname'] = 'Wirklicher Name benötigt';
$lang['Require_email'] = 'E-Mail benötigt';
$lang['Require_comments'] = 'Kommentar benötigt';
$lang['Permit_attachments'] = 'Erlaube Attachments';
$lang['Prune'] = 'Aktiviere automatisches Löschen';
$lang['Prune_explain'] = 'Aktiviere diese Option, um SQL-Einträge zu löschen, die für den Floodschutz nicht mehr benötigt werden.';
$lang['Max_file_size'] = 'Maximale Dateigröße';
$lang['Max_file_size_explain'] = 'Die maximal zulässige Dateigröße je Attachment, das auf Deinem Webspace gespeichert wird. Vergiss nicht, dass der Wert nicht höher als die Einstellung in der php.ini sein kann. (%s)';
$lang['File_root'] = 'Attachment Dateien Ordner';
$lang['File_root_explain'] = 'Der Ordner, in dem die Attachments gespeichert werden. Dieser Ordner muss CHMOD 777 haben und relativ zum phpBB Root-Pfad angegeben werden.';
$lang['Flood_limit_admin'] = 'Flood Limit';
$lang['Flood_limit_admin_explain'] = 'Zeit, die vergehen muss, bevor ein Benutzer das Kontaktformular erneut verwenden kann. Trage \'0\' ein, um diese Funktion zu deaktivieren (nur zum Testen empfohlen).';
$lang['Char_limit_admin'] = 'Maximale Anzahl der Zeichen';
$lang['Char_limit_admin_explain'] = 'Du kannst ein Höchstlimit für Zeichen eingeben, die in einer Nachricht enthalten sein dürfen. Trage \'0\' ein, um diese Option zu deaktivieren.';

$lang['Captcha'] = 'Captcha Optionen';
$lang['Activate'] = 'Aktiviere Captcha?';
$lang['Enable'] = 'Aktiviere';
$lang['Disable'] = 'Deaktiviere';
$lang['Captcha_explain'] = 'Aktiviere diese Option, damit Benutzer einen Code vor dem Senden der Nachricht eingeben müssen. Dies soll verhindern, dass Spambots dieses Formular missbrauchen.';
$lang['Type'] = 'Captcha Aussehen';
$lang['Type_explain'] = 'Wähle die Art des Captchas aus, die Du in Deinem Formular anzeigen möchtest.';
$lang['Image_bg'] = 'Bild basierend';
$lang['Coloured'] = 'Farbig';
$lang['Random'] = 'Zufall';

$lang['Copyright'] = '"Contact Form" by <a href="http://www.phobbia.net/mods/" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy;2006-2007<br />(Original mod: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Schnell-Löschung';
$lang['QDelete_disabled'] = 'Die Funktion der Schnell-Löschung wurde deaktiviert.';
$lang['File_Not_Here'] = 'Dieses Attachment scheint nicht zu existieren.';
$lang['File_Removed'] = 'Die Datei wurde erfolgreich gelöscht.';
$lang['QDelete_explain'] = 'Erlaubt dem Administrator, Attachments über einen E-Mail-Link schnell zu löschen.';
$lang['Remove_file'] = 'Um diese Datei zu löschen, klicke auf folgenden Link: %s';

// 
// "Messages Log" - Added in 8.6.0 
// 
$lang['Contact_date'] = 'Datum';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sSpeichern%s';
$lang['Contact_remove'] = '%sEntfernen%s';
$lang['Msg_delete'] = 'Löschen';

$lang['Contact_msgs_title'] = 'Kontaktformular :: Nachrichten-Log';
$lang['Contact_msgs_text'] = 'Hier findest Du die Nachrichten, die Du über das Kontaktformular erhalten hast, wobei die neuesten Nachrichten zuerst angezeigt werden.<br />&nbsp;&bull; Die Nachrichten können angesehen und gelöscht werden.<br />&nbsp;&bull; Angehängte Dateien können gesichert und gelöscht werden.';

$lang['Msg_del_success'] = 'Die Nachricht wurde erfolgreich gelöscht.';
$lang['File_del_success'] = 'Das Attachment wurde erfolgreich gelöscht.';
$lang['Confirm_delete_msg'] = 'Bist Du sicher, dass Du diese Nachricht löschen möchtest?';
$lang['Confirm_delete_file'] = 'Bist Du sicher, dass Du dieses Attachment löschen möchtest?';
$lang['File_Not_Here'] = 'Dieses Attachment scheint nicht zu existieren.';
$lang['Click_return_msglog'] = 'Klicke %shier%s, um zum Nachrichten-Log zurückzukehren.';

$lang['Msg_Log'] = 'Nachrichten-Log';
$lang['Msg_Log_explain'] = 'Die Aktivierung dieser Option erlaubt es, die Nachrichten zu Referenzzwecken in der Datenbank zu speichern.';

$lang['more'] = 'mehr';

//
// "Thank You" - Added in 8.9.8
//
$lang['Thankyou_settings'] = 'Einstellungen für Dankeschöns';
$lang['Thankyou_option'] = 'Danke dem Absender';
$lang['Thankyou_explain'] = 'Wer soll eine Dankes- bzw. Bestätigungsmail für seine Rückmeldung erhalten?';
$lang['Thank_none'] = 'Niemand';
$lang['Thank_members'] = 'Nur Mitglieder';
$lang['Thank_all'] = 'Jeder';
$lang['Thankyou_limit'] = 'Es tut uns Leid, aber wir können für die Dauer von 24 Stunden von dieser E-Mail-Adresse keine weitere Anfrage akzeptieren.';

?>