<?php 
/***************************************************************************
                             lang_smartfeed.php
                             -------------------
    begin                : Mon, Jan 15, 2007
    copyright            : (c) Mark D. Hamill
    email                : mhamill@computer.org

    $Id: $

 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// lang_smartfeed.php
// Written by Mark D. Hamill, mhamill@computer.org
// This software is designed to work with phpBB Version 2.0.22

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$lang['smartfeed_atom_10'] = 'Atom 1.0';
$lang['smartfeed_rss_20'] = 'RSS 2.0';
$lang['smartfeed_rss_10'] = 'RSS 1.0';
$lang['smartfeed_rss_091'] = 'RSS 0.91 (RDF) - 15 items maximum';

$lang['smartfeed_copyright'] = ''; // Add a copyright statement for your site if it applies
$lang['smartfeed_editor'] = ''; // Most likely your site will not have a managing editor. If so enter email address of managing editor 
$lang['smartfeed_webmaster'] = ''; // If so inclined, enter email address of the webmaster of the phpBB forum

// Various error messages. Customize or internationalize as you prefer.
$lang['smartfeed_error_title'] = 'Fehler in Deiner SmartFeed URL';
$lang['smartfeed_error_introduction'] = 'Die zum Abrufen dieses Newsfeeds benutzte URL ist fehlerhaft und kann deshalb keine Inhalte zurueckliefern. Benutze diese Fehlermeldung als Anleitung um das Problem zu beheben. Bitte beachte, dass Du <a href="%s">dieses Programm</a> benutzen musst um eine von SmartFeed verwertbare URL zu erstellen. Der Fehler lautet: ';
$lang['smartfeed_no_e_param'] = 'Der "u" Parameter muss zusammen mit dem "e" parameter benutzt werden. ';
$lang['smartfeed_no_u_param'] = 'Der "e" Parameter muss zusammen mit dem "u" parameter benutzt werden. ';
$lang['smartfeed_user_table_count_error'] = 'Fehler, den user_id von den Verbrauchern wiedergewinnt, stellt zurück';
$lang['smartfeed_user_id_does_not_exist'] = 'Benutzer-ID, die von "u" Parameter identifiziert wird nicht existiert. Das Konto kann gelöscht worden sein.';
$lang['smartfeed_user_table_password_error'] = 'Datenbankfehler. Passwort konnte keinem Benutzer zugeordnet werden.';
$lang['smartfeed_bad_password_error'] = 'Authentifizierungsfehler. "e" -Parameter von "%s" passt nicht zu "u"-Parameter von "%s". Dieser Fehler kann auftreten, wenn Sie ihr Board-Passwort geaendert haben, oder wenn die hier genutzte SmartFeed Software upgedated wurde. Um das Problem zu beheben erstelle bitte eine neue gueltige URL unter %s, kopiere die generierte URL und fuege sie in deinen bevorzugten Newsreader ein.';
$lang['smartfeed_forum_access_reg'] = 'Fehler. Kann Liste der öffentlichen Foren nicht einlesen.';
$lang['smartfeed_forum_access_priv'] = 'Fehler. Kann Liste der nichtöffentlichen Foren nicht einlesen.';
$lang['smartfeed_user_error'] = 'Fehler. Kann user_lastvisit aus Benutzer-Tabelle nicht einlesen.';
$lang['smartfeed_limit_format_error'] = 'Fehler. Limit parameter hat keinen erkennbaren Wert.';
$lang['smartfeed_retrieve_error'] = 'Fehler. Kann keine Daten aus der Datenbank einlesen um newsfeed zu erstellen.';
$lang['smartfeed_feed_type_error'] = 'SmartFeed akzeptiert den angeforderten Newstyp nicht.';
$lang['smartfeed_sort_by_error'] = 'SmartFeed akzeptiert die angeforderte Sortierreihenfolge nicht.';
$lang['smartfeed_topics_only_error'] = 'SmartFeed akzeptiert den angeforderten Thementyp nicht.';
$lang['smartfeed_lastvisit_param'] = 'SmartFeed akzeptiert den ungültigen lastvisit Parameter nicht.';
$lang['smartfeed_reset_error'] = 'Datenbankfehler: last visit date kann nicht zurück gesetzt werden.';
$lang['smartfeed_ip_auth_error'] = 'Diese URL kann nicht zum Empfang eines Newsfeeds von dieser IP-Adresse genutzt werden. Benutze smartfeed_url.' . $phpEx . ' auf dieser Domäne um eine gültige URL zu erhalten.'; 
$lang['smartfeed_not_logged_in'] = '<b>Du bist nicht eingeloggt. Dir stehen deshalb nur folgende oeffentlichen Foren zur Auswahl. Bitte <a href="' . append_sid("login.$phpEx?redirect=smartfeed_url.$phpEx", true) . "\">logge Dich ein</a> oder <a href=\"./profile.$phpEx?mode=register\">registriere dich </a> wenn Du auch nicht oeffentliche Foren empfangen willst.</b>";
$lang['smartfeed_remove_yours_error'] = 'Fehler. Der ENTFERNE MEINE Parameter ist ungültig';
$lang['smartfeed_no_arguments'] = 'Fehler. Dieses Programm benötigt Argumente.';
$lang['smartfeed_max_word_size_error'] = 'Fehler. Der max_word_size Parameter ist ungültig.';
$lang['smartfeed_first_post_only_error'] = 'Der "nur ersten Beitrag liefern" Parameter ist ungueltig. Falls vorhanden sollte derParameter den Wert 1 haben.';
$lang['smartfeed_pms_not_for_public_users'] = 'pms-Parameter (private Nachrichten) ist fuer nicht registrierte Benutzer nicht zugelassen.';
$lang['smartfeed_bad_pms_value'] = 'Der pms-Parameter (fuer private Nachrichten) muss den Wert 1 haben';
$lang['smartfeed_pm_retrieve_error'] = 'Konnte keine Informationen zu privaten Nachrichten in der Datenbank abfragen.';
$lang['smartfeed_pm_count_error'] = 'Konnte die Anzahl der privaten Nachrichten fuer den Benutzer nicht in der Datenbank abfragen.';
$lang['smartfeed_p_parameter_obsolete'] = 'Authentication failure. Due to a software upgrade, the "p" parameter is no longer allowed. To solve this problem, create a new SmartFeed URL at %s, then copy and paste the generated URL into your newsreader application.';

// Miscellaneous variables
$lang['smartfeed_feed_title'] = $board_config['sitename'];
$lang['smartfeed_feed_description'] = $board_config['site_desc'];
$lang['smartfeed_image_title'] = $board_config['site_desc'] . ' Logo';
$lang['smartfeed_reply'] = 'Antwort von';
$lang['smartfeed_reply_by'] = 'Antwort geschrieben von'; 
$lang['smartfeed_version'] = 'Version';

// These are used by smartfeed_url.php
$lang['smartfeed_feed_type'] = '<b>Wähle das Format des Newsfeeds:</b><br />(Stellesicher, dass es das richtige Format für Deinen Newsreader ist)';
$lang['smartfeed_page_title'] = 'SmartFeed';
$lang['smartfeed_explanation'] = "Immer mehr Menschen entdecken die Vorteile von Themen- und/oder Interessenbezogenen Newsfeeds. Dank Newsfeeds muß eine Webseite nicht besucht werden um ihren Inhalt zu lesen. Ein Programm, ein sogenannter <i>web aggregator</i> oder <i>Newsreader</i> holt die Nachrichten von verschiedenen Webseiten für dich ab und stellt sie unter einer Oberfläche zur Verfügung.<br /><br />\r\nManche Foren können nur von Mitgliedern gelesen werden, oder erfordern, daß du Mitglied einer bestimmten Benutzergruppe des Forums bist. Normalerweise würden diese Foren nicht als allgemeiner Newsfeed zugänglich sein. Für dieses Forum ist <em>SmartFeed</em> installiert. <em>SmartFeed</em> ist eine phpBB Änderung, die angemeldeten Benutzern erlaubt, öffentliche und nicht öffentliche Foren auf dieser Domäne als Newsfeed zu empfangen. Dies wird ermöglicht, in dem Du Dich mit einer speziellen hier generierten URL authentifizierst. Du bestimmst über die Optionen dieser Seite, welche Informationen Du in deinem personalisierten Newsfeed erhalten möchtest. Du kannst die Art des Newsfeedformats wählen, die du bevorzugst. SmartFeed unterstützt sowohl RSS- als auch Atomprotokolle. Indem Du die URL generieren Taste ganz unten auf dieser Seite anklickst, erhälst Du die spezielle URL, die du benötigst. Kopiere diese frisch generierte URL und füge sie in deinen Newsreader ein um die Beiträge des Forums in Deinem Newsreader zu erhalten. Wenn Du nicht weist, was Newsfeeds und Newsreader sind, schlagen wir vor, <a href=\"http://de.wikipedia.org/wiki/RSS-Reader\">dass du diesen Wikipedia-Artikel</a> liest. Dort findest Du unter anderem auch Links zu verschiedenen Newsreadern, die Du vielleicht ausprobieren möchtest. <br /><br />\r\nVielleicht möchtest Du Newsfeeds über Websites die zu diesem Zweck erstellt wurden als <a href=\"http://www.bloglines.com\">Bloglines</a> zugänglich machen.<br /><br />Wenn Du kein registriertes Mitglied dieses Forums bist, kannst Du nur die öffentlichen Foren lesen. Als Mitglied solltest Du darauf achten, dass Du beim erstellen der URL für Deinen Newsreader eingelogt bist. ";
$lang['smartfeed_lastvisit'] = '<b>Soll das Datum Deines letzten Besuches zurückgesetzt werden?</b><br />(Wähle "Ja" wenn Du üblicherweise die Foren über Newsreader liest. Wähle "Nein" wenn Du üblicherweise die Foren besuchst <i>und</i> die neuen Beiträge als ungelesen bei Deinem nächsten Forenbesuch angezeigt werden. Achtung: Wählst Du "Nein" kann zu sehr langen Newsfeeds führen. Ausserdem kann es passieren, dass bereits gelesene Artikel als ungelesen gekennzeichnet sind.)';
$lang['smartfeed_yes'] = 'Ja';
$lang['smartfeed_no'] = 'Nein';
$lang['smartfeed_all_forums']='Alle abonnierten Foren';
$lang['smartfeed_select_forums']='<b>Newsfeeds sollen Posts aus folgenden Foren enthalten:</b>';
$lang['smartfeed_generate_url_text']='URL generieren';
$lang['smartfeed_reset_text']='Formular zurücksetzen';
$lang['smartfeed_auth_reg_text']='<i>(Nur registrierte Benutzer)</i>';
$lang['smartfeed_auth_acl_text']='<i>(Nur Besonderer Zugang)</i>'; 
$lang['smartfeed_auth_mod_text']='<i>(Nur Moderatoren)</i>';
$lang['smartfeed_auth_admin_text']='<i>(Nur Administratoren)</i>';
$lang['smartfeed_limit_text']='<b>Beim Abholen der Posts, limitiere den Newsfeed auf ?? posts:</b><br />(Wenn Du eine Browser Erweiterung wie Sage für Firefox als Newsreader benutzt, wird ein dauerhaftes Cookie gesetzt in dem Dein letzter Besuch festgehalten wird. Die meisten Desktop-Newsreader werden Cookies ignorieren.)';
$lang['smartfeed_since_last_fetch_or_visit']='Seit letztem Besuch oder letzem Newsfeed';
$lang['smartfeed_since_last_fetch_or_visit_value']='LF';
$lang['smartfeed_last_week']='Seit letzter Woche';
$lang['smartfeed_last_week_value']='7 DAY';
$lang['smartfeed_last_day']='In den letzten 24 Stunden';
$lang['smartfeed_last_day_value']='1 DAY';
$lang['smartfeed_last_12_hours']='In den letzten 12 Stunden';
$lang['smartfeed_last_12_hours_value']='12 HOUR';
$lang['smartfeed_last_6_hours']='In den letzten 6 Stunden';
$lang['smartfeed_last_6_hours_value']='6 HOUR';
$lang['smartfeed_last_3_hours']='In den letzten 3 Stunden';
$lang['smartfeed_last_3_hours_value']='3 HOUR';
$lang['smartfeed_last_1_hours']='In der letzten Stunde';
$lang['smartfeed_last_1_hours_value']='1 HOUR';
$lang['smartfeed_last_30_minutes']='In den letzten 30 Minuten';
$lang['smartfeed_last_30_minutes_value']='30 MINUTE';
$lang['smartfeed_last_15_minutes']='In den letzten 15 Minuten';
$lang['smartfeed_last_15_minutes_value']='15 MINUTE';
$lang['smartfeed_sort_by']='<b>Sortieren nach:</b><br />(Standard Sortierreihenfolge ist die Reihenfolge wie Posts hier im Forum gelistet werden, z.B. Kategorien, Forum, Forumthema, Last Post Time (Desc), Topic Post Date/Time)';
$lang['smartfeed_sort_forum_topic']='Standard Sortierreihenfolge';
$lang['smartfeed_sort_forum_topic_desc']='Standardsortierung, Letzte Posts zuerst';
$lang['smartfeed_sort_post_date']='Post Datum/Zeit';
$lang['smartfeed_sort_post_date_desc']='Post Datum/Zeit, Letzte Posts zuerst';
$lang['smartfeed_count_limit'] = '<b>Maximale Anzahl der Beitraege im Feed:</b><br />(Gueltig nur wenn Beitraege/Datum Zeit, Letzte Beitraege zuerst ausgewaehlt ist. Bitte eine positive Zahl eingeben. \'Alle\' eingeben um alle Beitraege zu sehen, die Deiner Auswahl entsprechen.)';
$lang['smartfeed_no_forums_selected']='Du hast keine Foren ausgewählt. URL kann nicht generiert werden. Bitte wähle mindestens ein Forum aus.';
$lang['smartfeed_topics_only']='<b>Sollen nur neue Beiträge angezeigt werden?</b>';
$lang['smartfeed_url_label']='Nachdem Du URL-generieren gedrückt hast erscheint im unteren Feld die für den Newsfeed benötigte URL. <b>Kopiere diese URL in die Zwischenablage und füge sie in Deinen Newsreader ein.</b> Wenn Du Deine Optionen änderst, klicke noch mal auf URL generieren und Du erhälst eine neue URL, passend zu Deinen neuen Optionen.';
$lang['smartfeed_ip_auth']='<b>Newsfeed IP Authentication aktivieren?</b><br />(Kann als zusätzliche Sicherheit verwendet werden um URL hijacking zu vermeiden. Die generierte URL kann dann nur mit Deinem Computer genutzt werden. Z. B., wenn Deine aktuelle IP 123.45.67.89 ist und IP Authentication aktiviert wurde, dann wirde die generierte URL nur funktionieren, wenn Deine IP im Bereich 123.45.67.* ist.)';
$lang['smartfeed_remove_yours']='<b>Sollen Deine Beiträge aus dem Feed entfernt werden?</b>';
$lang['smartfeed_max_size']='<b>Maximale Wortzahl die von einem Beitrag angezeigt werden soll:</b><br />(Positive Zahl eingeben. Wähle \'All\' um den gesamten Beitrag zu sehen. Achtung: Die Eingabe einer Zahl kann zu Fehlern im Feedvalidator führen.)';
$lang['smartfeed_max_words_wanted']='All';
$lang['smartfeed_size_error']='Du musst eine positive Zahl oder das Wort \'All\' in diesem Feld eintragen';
$lang['smartfeed_count_limit_error']='Der count_limit Parameter muss grösser als 0 sein.';
$lang['smartfeed_count_limit_consistency_error']= 'Der count_limit Parameter kann nur verwendet werden, wenn sort_by parameter is "postdate_desc"';
$lang['smartfeed_first_post_only']='Nur ersten Beitrag uebermitteln (Gueltig nur wenn "JA")';
$lang['smartfeed_private_messages_in_feed']='<b>Private Nachrichten im Feed zeigen?</b>'; 
$lang['smartfeed_no_mcrypt'] = '<b>*** Warning! PHP mcrypt extension is not available! Consequently only public forums can be selected. ***</b>';

// Used in Admininstrator interface to smartfeed_url.php
$lang['smartfeed_advertising_interface_title'] = 'Administrator: Anzeigen-/Werbeoptionen';
$lang['smartfeed_enable_ads'] = '<b>Anzeigen/Werbung im Newsfeed einblenden?</b>';
$lang['smartfeed_set_ad_options'] = 'Anzeigen-/Werbeoptionen festlegen';
$lang['smartfeed_set_top_options'] = 'Anzeige/Werbung am Anfang des Feeds platzieren';
$lang['smartfeed_set_middle_options'] = 'Anzeige/Werbung zwischen den einzelnen Beitraegen platzieren';
$lang['smartfeed_set_bottom_options'] = 'Anzeige/Werbung am Ende des Feeds platzieren';
$lang['smartfeed_ad_item_title'] = '<b>Titel der Anzeige/Werbung</b><br />(Eingabe erforderlich falls dieser Abschnitt aktiviert wurde. Ausschliesslich einfacher Text; keine Sonderzeichen oder HTML.)';
$lang['smartfeed_ad_item_link'] = '<b>weiterfuehrender Link</b><br />(Keine Eingabe, falls nicht benoetigt. Der Link muss mit http:// beginnen)';
$lang['smartfeed_ad_item_desc'] = '<b>Vollstaendiger Anzeigen-/Werbetext</b><br />(Keine Eingabe, falls nicht benoetigt. In den meisten Faellen wird man hier Zusatzinformationen zum angebotenen Produkt oder Service hinterlegen. Hier kann einfacher Text, HTML oder fuer RSS oder Atom feeds erstellter parsed XML Inhalt eingegeben werden. Warnung: Nicht alle Newsreader koennen HTML korrekt wiedergeben. Bitte KEIN Javascript verwenden, da die meisten Newsreader Javascript nicht ausfuehren koennen. Backslash Zeichen (\) werden entfernt.)';
$lang['smartfeed_ad_item_header_top'] = 'Anzeige/Werbung am Anfang des Feeds';
$lang['smartfeed_ad_item_header_middle'] = 'Anzeige zwischen den einzelnen Beitraegen';
$lang['smartfeed_ad_item_header_bottom'] = 'Anzeige am Ende des Feeds';
$lang['smartfeed_ad_item_repeat'] = '<b>Wieviele Beitraege sollen angezeigt werden, bevor die Anzeige/Werbung eingeblendet wird?</b><br />(Eingabe erforderlich. Zahl muss groesser als 0 sein)';
$lang['smartfeed_ad_clear'] = 'Alle Anzeigenfelder leeren';
$lang['smartfeed_repeat_must_be_numeric'] = 'Anzuzeigende Artikelanzahl muss eine Zahl sein';
$lang['smartfeed_repeat_must_be_greater_0'] = 'Anzuzeigende Artikelanzahl muss groesser 0 sein';
$lang['smartfeed_title_required'] = 'Wenn ein Bereich aktiviert ist, muss die Titelzeile ausgefuellt sein.';
$lang['smartfeed_advertising_introduction'] = 'Dieser Bereich wird nur Administratoren angezeigt.<br /><br />Smartfeed erlaubt dashinzufuegen von Nachrichten/Werbung zwischen die einzelnen Artikel die den Benutzern bereit gestellt werden. Benutze diese Schnittstelle um Anzeigen/Werbung zu aktivieren. Die Anzeige/Werbung erscheint als einzelner Artikel des Feeds, wird aber eindeutig als Anzeige/Werbung gekennzeichnet. (Merkt, dass einige Internet-news, IE 7 mag, erlaubt, dass der Verbraucher die Reihenfolge ändert, dass Punkte im Futter gezeigt sind. Folglich gibt es keine Garantie der die Kleinanzeigen werden erscheinen am Ort sie wurden geschrieben an in den newsfeed.) Die Anzeige kann an drei stellen innerhalb des Feeds platziert werden: vor dem ersten Artikel, ans Ende des Feeds und abwechselnd innerhalb des Feeds. Jeder Anzeigenbereich kann an- bzw. ausgeschaltet werden. Anzeigen-/Werbetext kann ueber die zugehoerige Checkbox an- und ausgeschaltet werden. Wenn abgeschaltet, kann jedes Feld einzeln spaeter hinzugefuegt werden.<br /><br />Bitte beachten: Google Adsense unterstuetzt kein RSS und somit wird das mit Google Adsense angebotene Javascript vermutlich nicht funktionieren. Bitte pruefe den Feed mit Anzeigen/Werbung mit einer Vielzahl an Newsreader um sicherzustellen, dass Dein Text weitergereicht und sauber empfangen werden kann. Bitte beachte, dass unterschiedliche Newsreader den Inhalt unterschiedlich darstellen.<br /><br />Um Fehlermeldungen darstellen zu koennen muss Dein Browser PopUps fuer diese Seite zulassen! Ohne diese Moeglichkeit werden Dir Fehler nicht angezeigt.';
$lang['smartfeed_advertising_path_error'] = 'Kann Datei mit Anzeige-/Werbeoptionen nicht lesen oder erstellen. Bitte stelle sicher, dass das Verzeichnis in dem die Datei abgelegt wird ueer die noetigen Schreibrechte verfuegt.';
$lang['smartfeed_ad_data_saved'] = 'Die Daten mit den Anzeigeoptionen wurden gespeichert';
$lang['smartfeed_ad_data_invalid_user'] = 'Die Daten mit den Anzeigeoptionen wurden NICHT gespeichert. Der Benutzer der die Anzeigeoptionen zu speichern versucht, verfuegt nicht ueber Administratorrechte. Hackversuch?';
$lang['smartfeed_ad_data_access_error'] = 'Kein Zugriff auf Datei mit Anzeigeoptionen. Wahrscheinlich nicht ausreichende Lese-/Schreibberechtigung im Verzeichnis.';
$lang['smartfeed_ad_feed_category'] = 'Anzeige'; // Die Artikelkategorie des Feeds fuer Anzeigen/Werbung und gleichzeitig die Artikelueberschrift im Feed um den Artikel als Anzeige/Werbung zu kennzeichen
$lang['smartfeed_show_ads_to_public_only'] = 'Anzeigen/Werbung nur fuer nicht registrierte Benutzer (gueltig nur, wenn Anzeige/Werbung aktiv ist)';

?>