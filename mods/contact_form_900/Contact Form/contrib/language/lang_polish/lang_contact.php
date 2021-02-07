<?php
/***************************************************************************
 *                               lang_contact.php
 *                              ------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *   	Copyright:	(C) 2006-07, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		23:08 21/06/2007
 *
 *	Translated by:	Kastak
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

$lang['Contact_intro'] = 'Je¿eli masz jakie¶ pytania, uwagi, b±d¼ propozycje odno¶nie serwisu/forum lub masz jakie¶ problemy (z rejestracj±, logowaniem itp.) u¿yj poni¿szego formularza.';

$lang['Username'] = 'U¿ytkownik';
$lang['Real_name'] = 'Imiê';
$lang['Rname_require'] = 'Imiê *';
$lang['E-mail'] = 'Twój E-mail';
$lang['E-mail_require'] = 'Twój E-mail *';
$lang['Comments'] = 'Wiadomo¶æ';
$lang['Comments_require'] = 'Wiadomo¶æ *';
$lang['Attachment'] = 'Za³±cznik';

$lang['Feedback'] = 'Otrzymano wiadomo¶æ';

$lang['Real_name_explain'] = 'Wpisz swoje imiê. U³atwi nam to kontakt gdy jeste¶ niezarejestrowany.';
$lang['Explain_email'] = 'Wpisz swój E-mail. Na ten adres zostanie wys³ana odpowied¼.';
$lang['Comments_explain'] = 'Wpisz tu tre¶æ swojej wiadomo¶ci';
$lang['Flood_explain'] = '<br /><br />Ten formularz ma w³±czony system anty-floodowy. Mo¿esz wys³aæ tylko jedn± wiadomo¶æ co %s %s.' ;
$lang['Comments_limit'] = '<br /><br />Administrator ustawi³ limit %s znaków.';
$lang['Attachment_explain'] = 'Do³±cz do wiadomo¶ci za³±cznik je¶li to konieczne, trafi on do administratora forum. Maksymalny rozmiar pliku to %sKb lub mniejszy.';

$lang['Guest'] = 'Go¶æ';
$lang['Notify_IP'] = 'Twoje IP bêdzie zapisane w celach bezpieczeñstwa.';
$lang['Fields_required'] = 'Pola oznaczone * s± obowi±zkowe.';
$lang['Contact_form'] = 'Formularz Kontaktowy';
$lang['Empty'] = 'Nie podano';

$lang['hours'] = 'godziny';
$lang['hour'] = 'godzinê';

$lang['Chars'] = ' znaków';

$lang['Captcha_code'] = 'Kod zabezpieczaj±cy *';
$lang['Captcha_code_explain'] = 'Przepisz kod z obrazka.';

//
// Errors
//
$lang['Rname-Empty'] = 'Musisz wpisaæ swoje imiê.';
$lang['Comments-Empty'] = 'Musisz wpisaæ wiadomo¶æ.';
$lang['Comments_exceeded'] = 'Twoja wiadomo¶æ jest d³u¿sza ni¿ dozwolony limit.';
$lang['Email-Empty'] = 'Musisz wpisaæ swój adres e-mail.';
$lang['Email-Check'] = 'Adres e-mail jest nieprawid³owy.';
$lang['Attach-File_exists'] = 'Ju¿ istnieje plik o takiej nazwie, który zosta³ wys³any z twojego adresu IP.';
$lang['Attach-Too_big'] = 'Za³±cznik, który próbujesz wys³aæ ma zbyt du¿y rozmiar. Dozwolona maksymalna wielko¶æ pliku to %sKb lub mniejsza.';
$lang['Attach_dud'] = 'Za³±cznik, który próbowa³e¶ wys³aæ nie istnieje. Proszê sprawdziæ ponownie ¶cie¿kê do pliku.';
$lang['Attach-Uploaded'] = 'Twój za³±cznik zosta³ poprawnie dodany.';
$lang['Flood_limit'] = 'Przepraszamy, ale musisz poczekaæ %d godzin(y) zanim bêdziesz móg³ skorzystaæ ponownie z formularza kontaktowego.';
$lang['Illegal_ext'] = 'Ten typ pliku (%s) jest zabroniony!';
$lang['Unknown_ext'] = 'Ten typ pliku (%s) nie mo¿e byæ zaakceptowany!';
$lang['zip_advise'] = 'W razie konieczno¶ci, proszê spakowaæ plik (format zip) przed ponownym wys³aniem.';
$lang['POST_ERROR'] = 'B³±d podczas wysy³ania - proszê spróbowaæ ponownie!';
$lang['Image_error'] = 'B³±d podczas wysy³ania - przetworzenie tego obrazka by³o niemo¿liwe!';
$lang['Image_zip'] = 'Proszê spakowaæ ten typ obrazka przed wys³aniem (format zip).';
$lang['Code_Empty'] = 'Musisz wpisaæ kod z obrazka!';
$lang['Code_Wrong'] = 'Wpisany kod jest niepoprawny!';

$lang['Contact_error'] = '<b>Wyst±pi³ b³±d podczas wysy³ania wiadomo¶ci</b>';
$lang['Contact_success'] = '<b>Wiadomo¶æ zosta³a wys³ana.</b>';

$lang['Click_return_form'] = '<br /><br />Kliknij %sTutaj%s, aby wróciæ do formularza.';

$lang['Contact_Disabled'] = 'Formularz jest obecnie wy³±czony';

//
// Admin
//
$lang['General_settings'] = 'Ustawienia Formularza';
$lang['Contact_title'] = 'Formularz Konktaktowy';
$lang['Contact_explain'] = 'Tutaj mo¿esz zmieniæ ustawienia i wygl±d formularza kontaktowego oraz obowi±zkowe pola.';
$lang['Req_settings'] = 'Wymagane pola';
$lang['Attachment_settings'] = 'Ustawienia Za³±czników';
$lang['Contact_updated'] = 'Zmiany zatwierdzone';
$lang['Click_return_contact'] = 'Kliknij %sTutaj%s aby wróciæ do konfiguracji.';
$lang['Admin_email_explain'] = 'Je¿eli pole pozostanie puste e-maile bêd± wysy³ane do g³ównego administratora forum.';

$lang['Form_Enable'] = 'Formularz w³±czony?';

$lang['kb'] = 'kilobajtów';

$lang['Hash'] = 'Kodowanie za³±czników';
$lang['Hash_explain'] = 'Wszystkie nazwy za³±czanych plików zostan± zmienione na losowy hash dla wiêkszego bezpieczeñstwa.';
$lang['md5'] = 'MD5';
$lang['no_hash'] = 'Brak';

$lang['auth_permission'] = 'Zezwolenia';
$lang['auth_perm_explain'] = 'Je¿eli za³±czniki s± dozwolone, mo¿esz wybraæ kto mo¿e uploadowaæ pliki.';
$lang['auth_guests'] = 'Go¶cie';
$lang['auth_members'] = 'U¿ytkownicy';
$lang['auth_mods'] = 'Moderatorzy';
$lang['auth_admins'] = 'Administratorzy';

$lang['Require_rname'] = 'Imiê';
$lang['Require_email'] = 'E-mail';
$lang['Require_comments'] = 'Wiadomo¶æ';
$lang['Permit_attachments'] = 'Za³±czniki w³±czone?';
$lang['Prune'] = 'W³±cz automatyczne czyszczenie';
$lang['Prune_explain'] = 'W³±cz to, aby wyczy¶ciæ wpisy SQL, które nie s± ju¿ potrzebne dla opcji "Interwa³ Anty-Floodowy", zmniejszy to rozmiar bazy danych.';
$lang['Max_file_size'] = 'Maksymalny rozmiar pliku';
$lang['Max_file_size_explain'] = 'Ustaw maksymalny dozwolony rozmiar pliku (za³±cznika). Pamiêtaj, wielko¶æ za³±cznika nie mo¿e przekraczaæ ustawieñ twojego php.ini. (%s)';
$lang['File_root'] = 'Katalog za³±czników';
$lang['File_root_explain'] = 'Wpisz nazwê folderu, w którym bêd± zapisywane za³±czniki. Folder musi mieæ ustawione CHMOD 777 i znajdowaæ siê w g³ównym katalogu forum.';
$lang['Flood_limit_admin'] = 'Interwa³ Anty-Floodowy';
$lang['Flood_limit_admin_explain'] = 'Ilo¶æ godzin, zanim bêdzie mo¿na wys³aæ nowy e-mail poprzez formularz kontaktowy. Ustaw \'0\', aby wy³±czyæ tê funkcjê (zalecane tylko dla testów).';
$lang['Char_limit_admin'] = 'Maksymalna ilo¶æ znaków';
$lang['Char_limit_admin_explain'] = 'Tutaj mo¿esz ustawiæ limit znaków dopuszczalny w wiadomo¶ci. Ustaw \'0\', aby wy³±czyæ limit.';

$lang['Captcha'] = 'Kod zabezpieczeñ';
$lang['Activate'] = 'Zabezpieczenie aktywne?';
$lang['Enable'] = 'W³±czone';
$lang['Disable'] = 'Wy³±czone';
$lang['Captcha_explain'] = 'W³±cz tê opcjê, aby u¿ytkownicy obowi±zkowo musieli przepisaæ kod z obrazka przed wys³aniem wiadomo¶ci. Zapobiega to przed nadu¿eciem formularza przez spamboty.';
$lang['Type'] = 'Rodzaj obrazka';
$lang['Type_explain'] = 'Wybierz typ obrazka, jaki ma byæ pokazany w twoim formularzu kontaktowym.';
$lang['Image_bg'] = 'Obrazek bazowy';
$lang['Coloured'] = 'Kolorowy';
$lang['Random'] = 'Losowy';

$lang['Copyright'] = '"Formularz kontaktowy" by <a href="http://www.phobbia.net" target="_phpbb"><b>Ma&reg;&copy;uS</b></a> &copy; 2006-2007<br />(Original mod: darkassasin93)';

//
// "Quick Delete" - Added to 7.0.0
//
$lang['QDelete'] = 'Szybkie usuwanie';
$lang['QDelete_disabled'] = 'Opcja szybkiego usuwania zosta³a wy³±czona';
$lang['File_Not_Here'] = 'Ten za³±cznik najprawdopodobniej nie istnieje';
$lang['File_Removed'] = 'Plik zosta³ usuniêty pomy¶lnie.';
$lang['QDelete_explain'] = 'Zezwoliæ adminowi na szybkie usuwanie za³±cznika poprzez link podany w e-mailu?';
$lang['Remove_file'] = 'Aby usun±æ plik, kliknij na ten link: %s';

//
// "Messages Log" - Added in 8.6.0
//

$lang['Contact_date'] = 'Data';
$lang['Contact_ip'] = 'IP';
$lang['Contact_get'] = '%sPobierz%s';
$lang['Contact_remove'] = '%sUsuñ%s';
$lang['Msg_delete'] = 'Usuñ';

$lang['Contact_msgs_title'] = 'Formularz kontaktowy :: Logi wiadomo¶ci';
$lang['Contact_msgs_text'] = 'Tutaj znajduj± siê wiadomo¶ci, które zosta³y wys³ane poprzez formularz kontaktowy. Nowsze wiadomo¶ci s± jako pierwsze.<br />&nbsp;&bull; Wiadomo¶ci mog± zostaæ przegl±dniête i usuniête.<br />&nbsp;&bull; Za³±czniki mog± zostaæ pobrane na dysk i usuniête.';

$lang['Msg_del_success'] = 'Wiadomo¶ci usuniête';
$lang['File_del_success'] = 'Za³±cznik usuniêty';
$lang['Confirm_delete_msg'] = 'Czy jeste¶ pewien, ¿e chcesz usun±æ wiadomo¶æ(i)?';
$lang['Confirm_delete_file'] = 'Czy jeste¶ pewien, ¿e chcesz usun±æ ten za³±cznik';
$lang['File_Not_Here'] = 'Ten za³±cznik najprawdopodobniej nie istnieje';
$lang['Click_return_msglog'] = 'Kliknij %sTutaj%s, aby powróciæ do Logi wiadomo¶ci';

$lang['Msg_Log'] = 'Logi wiadomo¶ci w³±czone?';
$lang['Msg_Log_explain'] = 'Ta opcja pozwala Ci na zpisywanie wysy³anych e-maili w  Twojej bazie danych, podgl±d bêdzie widoczny w Logach Wiadomo¶ci';

$lang['more'] = 'wiêcej';

//
// "Thank You" - Added in 8.9.8
//
$lang['Thankyou_settings'] = 'Ustawienia "Podziêkowañ"';
$lang['Thankyou_option'] = 'Podziêkuj nadawcy';
$lang['Thankyou_explain'] = 'Ustaw "¯aden", aby wy³±czyæ, "U¿ytkownicy", aby tylko zarejestrowani u¿ytkownicy otrzymywali podziêkowanie lub "Wszyscy", aby równie¿ go¶cie otrzymywali podziêkowanie.';
$lang['Thank_none'] = '¯aden';
$lang['Thank_members'] = 'U¿ytkownicy';
$lang['Thank_all'] = 'Wszyscy';
$lang['Thankyou_limit'] = 'Przepraszamy, ale nie akceptujemy wiêcej wiadomo¶ci z tego adresu e-mail przez najbli¿sze 24 godziny.';

?>