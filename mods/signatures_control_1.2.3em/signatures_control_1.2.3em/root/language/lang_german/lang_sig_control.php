<?php 
/************************************************************** 
* MOD Title:   Signatures control 
* MOD Version: 1.2.2 
* Translation: German (Deutsch)
* Rev date:    27/05/2005 
* 
* Translator:  chybo < ? > (n/a) http://chyra.wuffels.de
* 
***************************************************************/ 

$lang['sig_settings'] = 'Signatur Einstellungen'; 
$lang['sig_settings_explain'] = 'Warnung: für alle numerischen Felder (ausser auferlegte Schriftgrösse) gilt "0" oder leer für unbegrenzt !'; 

$lang['sig_max_lines'] = 'Maximale Anzahl der Zeilen'; 
$lang['sig_wordwrap'] = 'Maximale Anzahl der Zeichen ohne Leerzeichen'; 
$lang['sig_allow_font_sizes'] = 'Schriftgrösse [size]'; 
$lang['sig_allow_font_sizes_yes'] = 'frei'; 
$lang['sig_allow_font_sizes_max'] = 'begrenzt'; 
$lang['sig_allow_font_sizes_imposed'] = 'voreingestellt'; 
$lang['sig_font_size_limit'] = 'Schriftgrössenbegrenzung'; 
$lang['sig_font_size_limit_explain'] = 'phpBB unterstützt keine Schriftgrösse grösser als 29. Eine voreingestellte Schriftgrösse darf nicht kleiner als 7 sein.'; 
$lang['sig_min_font_size'] = 'min /'; 
$lang['sig_max_font_size'] = 'max oder auferlegte Grösse'; 
$lang['sig_text_enhancement'] = 'Textverzierungen erlauben'; 
$lang['sig_allow_bold'] = 'Fett [b]'; 
$lang['sig_allow_italic'] = 'Kursiv [i]'; 
$lang['sig_allow_underline'] = 'Unterstrichen [u]'; 
$lang['sig_allow_colors'] = 'Schriftarbe [color]'; 
$lang['sig_text_presentation'] = 'Textdarstellungen erlauben'; 
$lang['sig_allow_quote'] = 'Quotes [quote]'; 
$lang['sig_allow_code'] = 'Code quotes [code]'; 
$lang['sig_allow_list'] = 'Lists [list]'; 
$lang['sig_allow_url'] = 'URLs erlauben [url]'; 
$lang['sig_allow_images'] = 'Bilder erlauben [img]'; 
$lang['sig_max_images'] = 'Maximale Anzahl der Bilder'; 
$lang['sig_max_img_size'] = 'Maximale Bildergrösse'; 
$lang['sig_max_img_size_explain1'] = 'Prinzipiell ist die Kontrolle der Bildgrösse auf diesem Board möglich. Wenn jeoch eine Bildgrösse nicht überprüft werden kann, stelle ein, ob das Bild durch Rückstellung erlaubt oder abgelehnt wird.'; 
$lang['sig_max_img_size_explain2'] = 'Die Kontrolle der Bildgrösse ist unmöglich (%s). Einstellung, ob das Bild durch Rückstellung erlaubt oder abgelehnt wird.'; 
$lang['sig_max_img_size_explain3'] = 'Prinzipiell ist die Kontrolle der Bildgrösse auf diesem Board möglich (%s). Einstellung, ob das Bild durch Rückstellung erlaubt oder abgelehnt wird.'; 
$lang['sig_img_size_legend'] = '(h x w)'; 
$lang['sig_allow_on_max_img_size_fail'] = 'Erlauben, wenn Kontrolle unmöglich'; 
$lang['sig_max_img_files_size'] = 'Maximal erlaubte Dateigrösse des Bildes'; 
$lang['sig_max_img_av_files_size'] = 'Maximal erlaubte Dateigrösse für Bild + Avatar zusammen'; 
$lang['sig_max_img_av_files_size_explain'] = 'Ist hier ein Wert eingestellt, so überprüft eine globale Steuerung die Dateigrösse des Signaturbildes UND des Avatars und die 2 separaten Steuerungen werden abgeschaltet. Ist nichts angegeben oder "0", so wird diese Kontrolle abgeschaltet.'; 
$lang['sig_Kbytes'] = 'Kb'; 
$lang['sig_exotic_bbcodes_disallowed'] = 'Verbiete andere BBCodes'; 
$lang['sig_exotic_bbcodes_disallowed_explain'] = 'Einstellung, andere BBCodes zu verbieten (z.B.: fade,php,shadow)'; 
$lang['sig_allow_smilies'] = 'Erlaube Smilies'; 
$lang['sig_reset'] = 'Reset Mitglieder Signatur'; 
$lang['sig_reset_explain'] = 'Löschen der Sigantur <span style="color: #800000">aller Mitglieder!</span> in deren Profil. Dies stellt sicher, dass alle beim erneuten Einbinden ihrer Signatur die Kontrolle passieren.'; 
$lang['sig_reset_confirm'] = 'Bist Du sicher, dass Du die Signaturen aller Mitglieder löschen willst?'; 

$lang['sig_reset_successful'] = 'Signaturen aller Mitglieder erfolgreich gelöscht!'; 
$lang['sig_reset_failed'] = 'Fehler: Signaturen können nicht gelöscht werden.'; 

$lang['sig_config_error'] = 'Deine Signatureinstellungen sind unzulässig.'; 
$lang['sig_config_error_int'] = 'Die Einstellungen in diesem Feld passen nicht oder Deine Schriftgrösse ist grösser als 29:'; 
$lang['sig_config_error_min_max'] = 'Es sind keine korrekten Werte für die minimale und maximale Schriftgrösse eingestellt (min: %s / max: %s). Die maximale Schriftgrösse muss höher sein, als die minimale.'; 
$lang['sig_config_error_imposed'] = 'Sie haben eine feste Schriftgrösse vordefiniert, aber die Grösse ist unzulässig (%). Das minimum ist 7 und das maximum 29.'; 

$lang['sig_allow_signature'] = 'Kann Signatur anzeigen'; 
$lang['sig_yes_not_controled'] = 'Ja, unkontrolliert'; 
$lang['sig_yes_controled'] = 'Ja, kontrolliert'; 

$lang['sig_explain'] = 'Eine Signatur wird am Ende jeder Deiner Beiträge angezeigt.'; 
$lang['sig_explain_limits'] = 'Limitiert auf %s Zeichen%s%s%s.'; 
$lang['sig_explain_max_lines'] = ' über %s Zeilen'; // Be careful to the space at the begining! 
$lang['sig_explain_font_size_limit'] = ' (Schriftgrösse %s bis %s)'; // Be careful to the space at the begining! 
$lang['sig_explain_font_size_max'] = ' (size %s maximum)'; // Be careful to the space at the begining! 
$lang['sig_explain_no_image'] = ' und kein Bild'; // Be careful to the space at the begining! 
$lang['sig_explain_images_limit'] = ' und %s Bild nicht grösser als %sx%s pixel mit max. %sKb'; // Be careful to the space at the begining! 
$lang['sig_explain_unlimited_images'] = ' und so viele Bilder, wie Du magst, aber keines darf %sx%s pixel mit max. %sKb übersteigen'; // Be careful to the space at the begining! 
$lang['sig_explain_avatar_included'] = ', Inklusive Avatar (10 kb)'; 
$lang['sig_explain_wordwrap'] = 'Der Text darf nicht länger sein als %s Zeichen ohne Leerzeichen.'; 

$lang['sig_BBCodes_are_OFF'] = 'BBCodes sind <u>aus</u>'; 
$lang['sig_bbcodes_on'] = '%sBBCodes%s an: '; 
$lang['sig_bbcodes_off'] = '%sBBCodes%s aus: '; 
$lang['sig_none'] = 'Keiner'; 
$lang['sig_all'] = 'Alle'; 

$lang['sig_error'] = 'Deine Signatur ist unzulässig.'; 
$lang['sig_error_max_lines'] = 'Deine Signatur hat %s Zeilen. Es sind aber nur %s zugelassen.'; 
$lang['sig_error_wordwrap'] = 'Dein Text enthält %s group(s) mit mehr als %s Zeichen ohne Leerzeichen, was nicht erlaubt ist.'; 
$lang['sig_error_bbcode'] = 'Diese(r) BBCode(s) ist/sind verboten: %s'; 
$lang['sig_error_font_size_min'] = 'Du hast eine Schriftgrösse von %s angegeben. Minimal erlaubt sind %s.'; 
$lang['sig_error_font_size_max'] = 'Du hast eine Schriftgrösse von %s angegeben. Maximal erlaubt sind %s.'; 
$lang['sig_error_num_images'] = 'Du hast %s Bilder eingefügt. Erlaubt sind aber nur %s.'; 
$lang['sig_error_images_size'] = 'Das %s Bild ist zu gross.<br />Die Grösse ist %s pixel hoch und %s breit. Die Maximale Grösse für Bilder ist %s Höhe und %s Breite.'; 
$lang['sig_unlimited'] = 'unbegrenzt'; 
$lang['sig_error_images_size_control'] = 'Unmöglich, die Bildgrösse zu kontrollieren: %s<br />Entweder ist kein Bild unter dieser Adresse oder das Forum kann die Grösse nicht steuern. Somit ist es Dir nicht erlaubt, dieses Bild zu verwenden.'; 
$lang['sig_error_avatar_local'] = 'Es gibt ein Problem mit dieser Datei: %s<br />Es ist unmöglich, die Grösse zu überprüfen.'; 
$lang['sig_error_avatar_url'] = 'Diese URL muss falsch sein: %s<br />Es gibt kein Avatar unter dieser Adresse.'; 
$lang['sig_error_img_files_size'] = 'Die Gesamtgrösse der benutzten Bilddatei(en) ist/sind %sKb, es sind aber nur %sKb erlaubt.'; 
$lang['sig_error_img_av_files_size'] = 'Die Gesamtgrösse der benutzten Bilddatei für die Signatur (%sKb) und das Avatar (%sKb) ist grösser als die autorisierten %sKb.'; 

?>