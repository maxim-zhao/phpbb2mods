<?php 
/************************************************************** 
* MOD Title:   Signatures control 
* MOD Version: 1.2.2
* Translation: Nederlands (Dutch)
* Rev date:    28/05/2005
* 
* Translator:  SNEEuWBAL < sneeuwbal@belgianmetal.com > (n/a) http://www.belgianmetal.com
*              jetnet.cc < admin@jetnet.cc > (n/a) n/a
* 
***************************************************************/ 

$lang['sig_settings'] = 'Signature instellingen'; 
$lang['sig_settings_explain'] = 'waarschuwing: voor alle numerieke velden (behalve deze voor lettergrote), "0" ofleeg betekent "onbeperkt"!'; 

$lang['sig_max_lines'] = 'Maximum aantal regels'; 
$lang['sig_wordwrap'] = 'Maximum aantal tekens zonder spatie'; 
$lang['sig_allow_font_sizes'] = 'Tekstgrootte [size]'; 
$lang['sig_allow_font_sizes_yes'] = 'Onbeperkt'; 
$lang['sig_allow_font_sizes_max'] = 'Beperkt'; 
$lang['sig_allow_font_sizes_imposed'] = 'Opgelegd'; 
$lang['sig_font_size_limit'] = 'tekst grootte is beperkt'; 
$lang['sig_font_size_limit_explain'] = 'phpBB ondersteund geen tekst grotes hoger dan 29. Ook worden er geen grotes kleiner dan 7 ondersteund.'; 
$lang['sig_min_font_size'] = 'minimum /'; 
$lang['sig_max_font_size'] = 'maximum of opgelegde grote'; 
$lang['sig_text_enhancement'] = 'tekst verbeteringen toestaan'; 
$lang['sig_allow_bold'] = 'Vet [b]'; 
$lang['sig_allow_italic'] = 'Schuin [i]'; 
$lang['sig_allow_underline'] = 'Onderlijnd [u]'; 
$lang['sig_allow_colors'] = 'Tekst kleur [color]'; 
$lang['sig_text_presentation'] = 'tekst presentaties toestaan'; 
$lang['sig_allow_quote'] = 'Quoteren [quote]'; 
$lang['sig_allow_code'] = 'Code Quoteren [code]'; 
$lang['sig_allow_list'] = 'Lijsten [list]'; 
$lang['sig_allow_url'] = 'Urls toestaan [url]'; 
$lang['sig_allow_images'] = 'Afbeeldingen toestaan [img]'; 
$lang['sig_max_images'] = 'Maximum aantal afbeeldingen'; 
$lang['sig_max_img_size'] = 'Maximum afbeeldings grote'; 
$lang['sig_max_img_size_explain1'] = 'In principe, mag het beheren van afbeeldings grootes geen problemen opleveren. Niettemin, als een afbeeldingsgrootte niet kan worden nagegaan, Dan moet het  toegelaten of geweigerd worden.'; 
$lang['sig_max_img_size_explain2'] = 'Het beheren van afbeeldingen kan soms voor problemen zorgen? (%s). Afbeeldingen die niet gecontroleerd worden moeten worden toegestaan of geweigerd.'; 
$lang['sig_max_img_size_explain3'] = 'In principe, is het beheren van afbeeldings grotes onmogelijk. (%s). Afbeeldingen die niet gecontroleerd worden moeten worden toegestaan of geweigerd.'; 
$lang['sig_img_size_legend'] = '(h x w)'; 
$lang['sig_allow_on_max_img_size_fail'] = 'Toestaan als het onmogelijk is om te controleren'; 
$lang['sig_max_img_files_size'] = 'Maximale bestandsgrootte van de afbeelding'; 
$lang['sig_max_img_av_files_size'] = 'maximale totale afbeeldings + avatar bestands grootte';
$lang['sig_max_img_av_files_size_explain'] = 'Als er een waarde in dit veld wordt gezet, zal er globale controle zijn voor de afbeelding en avatar, en de 2 afzonderlijke controles zullen worden uitgeschakels. Als er geen waarde of 0 wordt ingegeven, zal de globale controle worden gedeactiveerd.'; 
$lang['sig_Kbytes'] = 'Kb'; 
$lang['sig_exotic_bbcodes_disallowed'] = 'Andere BBCodes NIET toestaan';
$lang['sig_exotic_bbcodes_disallowed_explain'] = 'instellen van andere BBCodes die moeten worden geweigerd (eg.: fade,php,shadow)';
$lang['sig_allow_smilies'] = 'Smilies toestaan';
$lang['sig_reset'] = 'De gebruiker zijn signature resetten';
$lang['sig_reset_explain'] = 'Handtekeningen van <span style="color: #800000">alle gebruikers</span> verwijderen! Dit is om ze te verplichten om ze opnieuw in te stellen en te laten controleren';
$lang['sig_reset_confirm'] = 'Weet u zeker dat u de handtekeningen van alle gebruikers wilt verwijderen?';

$lang['sig_reset_successful'] = 'De Handtekeningen van alle gebruikers zijn verwijderd!';
$lang['sig_reset_failed'] = 'Error: Handtekeningen kunnen niet worden verwijderd.';

$lang['sig_config_error'] = 'Uw Handtekening settings zijn niet geldig.'; 
$lang['sig_config_error_int'] = 'U heeft negatieve getallen ingegeven (Of de minimum grootte van de fonts is groter dan 29):'; 
$lang['sig_config_error_min_max'] = 'U heeft tegenstrijdige waarden ingegeven voor de maximale en minimale font grootte (min: %s / max: %s). De maximale font grootte moet groter zijn dan 1.'; 
$lang['sig_config_error_imposed'] = 'U heeft ervoor gekozen om een font size te verplichten, maar deze is niet correct. (%). Het minimum is 7 en de maximum is 29.'; 

$lang['sig_allow_signature'] = 'Kan signature weergeven';
$lang['sig_yes_not_controled'] = 'Ja, niet gecontroleerd';
$lang['sig_yes_controled'] = 'Ja, gecontroleerd';

$lang['sig_explain'] = 'Een handtekening is een klein tekstje dat onder aan iedere post wordt toegevoegd die je plaatst.';
$lang['sig_explain_limits'] = 'Het is beperkt tot %s tekens%s%s%s.'; 
$lang['sig_explain_max_lines'] = ' op %s lijnen'; // Be careful to the space at the begining! 
$lang['sig_explain_font_size_limit'] = ' (grootte %s tot %s)'; // Be careful to the space at the begining! 
$lang['sig_explain_font_size_max'] = ' (grootte %s maximaal)'; // Be careful to the space at the begining! 
$lang['sig_explain_no_image'] = ' en GEEN afbeeldingen'; // Be careful to the space at the begining! 
$lang['sig_explain_images_limit'] = ' en %s en afbeeldingen met pixels niet gorter dan %sx%s en met een maximum van %sKb'; // Be careful to the space at the begining! 
$lang['sig_explain_unlimited_images'] = ' en zoveel afbeeldingen als je wilt, maar geen mag groter zijn dan %sx%s pixels, met een maximum van %sKb'; // Be careful to the space at the begining! 
$lang['sig_explain_avatar_included'] = ', avatar inbegrepen'; 
$lang['sig_explain_wordwrap'] = 'In de handtekening zijn meer dan %s tekens aan één stuk zonder een spatie ertussen niet toegestaan.'; 

$lang['sig_BBCodes_are_OFF'] = 'BBCodes staan <u>UIT</u>'; 
$lang['sig_bbcodes_on'] = '%sBBCodes%s AAN: '; 
$lang['sig_bbcodes_off'] = '%sBBCodes%s UIT: '; 
$lang['sig_none'] = 'geen'; 
$lang['sig_all'] = 'alle'; 

$lang['sig_error'] = 'Uw handtekening is ongeldig.'; 
$lang['sig_error_max_lines'] = 'Uw tekst bevat %s lijnen waar er maar %s zijn toegelaten.'; 
$lang['sig_error_wordwrap'] = 'Uw tekst bevat %s groepen van meer dan %s tekens zonder spatie, waar dit verboden is.'; 
$lang['sig_error_bbcode'] = 'U heeft deze verboden BBCode(s) gebruikt: %s'; 
$lang['sig_error_font_size_min'] = 'U hebt de font size %s gebruikt waar het minimum %s is.'; 
$lang['sig_error_font_size_max'] = 'U hebt de font size %s gebruikt waar het maximum %s is.'; 
$lang['sig_error_num_images'] = 'U heeft %s afbeeldingen gebruikt, waar het toegelaten maximum %s is.'; 
$lang['sig_error_images_size'] = 'De %s afbeelding is te groot.<br />De grootte is %s pixels hoog en %s breed, waar het maximum %s hoog en %s breed is.'; 
$lang['sig_unlimited'] = 'onbeperkt'; 
$lang['sig_error_images_size_control'] = 'Het is onmogelijk om de afbeeldings grootte te berekenen van: %s<br />Ofwel is er geen afbeelding op deze locatie, of het forum kan deze niet controleren, sowieso kan u deze niet gebruiken.'; 
$lang['sig_error_avatar_local'] = 'Er is een probleem met dit bestand: %s<br />Het is onmogelijk om de grootte na te gaan.'; 
$lang['sig_error_avatar_url'] = 'De URL moet fout zijn: %s<br />Er is geen avatar op deze locatie.'; 
$lang['sig_error_img_files_size'] = 'De totale grootte van de afbeeldingen gebruikt is %sKb waar het maximaal toegestaan %sKb is.'; 
$lang['sig_error_img_av_files_size'] = 'De totale grootte van de afbeeldingen in uw handtekening (%sKb) en uw avatar (%sKb) is hoger dan de toegestane %sKb.'; 

?>