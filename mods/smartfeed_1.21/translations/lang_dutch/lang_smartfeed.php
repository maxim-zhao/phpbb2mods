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
$lang['smartfeed_error_title'] = 'Fout in uw SmartFeed URL';
$lang['smartfeed_error_introduction'] = 'Er is een fout opgetreden in de URL die je gebruikte om deze niewsfeed te ontvangen. Hierdoor kan er geen inhoud getoond worden. Gebruik deze foutinformatie om de fout te verhelpen. Houd er relening mee dat je <a href="%s">dit programma</a> dient te gebruiken om een URL aan te maken dioe kan gebruikt worden door SmartFeed. De foutmelding is: ';
$lang['smartfeed_no_e_param'] = 'De "u" parameter moet gebruikt worden met de "e" parameter. ';
$lang['smartfeed_no_u_param'] = 'De "e" parameter moet gebruikt worden met de "u" parameter. ';
$lang['smartfeed_user_table_count_error'] = 'Gebruikers ID geïdentificeerd door "u" parameter bestaat niet. De accountinformatie kan verwijderd zijn.';
$lang['smartfeed_user_id_does_not_exist'] = '"u" parameter stemt niet overeen met een user_id %s op dit forum, daardoor kunnen geen artikels doorgestuurd worden.';
$lang['smartfeed_user_table_password_error'] = 'Databasefout bij het bekomen van het wachtwoord van de gebruikerstabel.';
$lang['smartfeed_bad_password_error'] = 'Authentificatiefout. "e" parameter "%s" is ongeldig met "u" parameter van "%s". Deze foutmelding kan voorkomen na het veranderen van je phpBB wachtwoord, of bij een upgrade in deze SmartFeed software. Om het probleem te verhelpen kan je best een nieuwe SmartFeed URL aanmaken op %s, daarna copieer en plak je de gegenereerde URL in je nieuwslezer applicatie..';
$lang['smartfeed_forum_access_reg'] = 'Fout bij het ophalen van een lijst van forum_ids die toegankelijk zijn voor alle gebruikers.';
$lang['smartfeed_forum_access_priv'] = 'Fout bij het ophalen van een lijst van private forum_ids.';
$lang['smartfeed_user_error'] = 'Fout bij het ophalen van de user_lastvisit uit de gebruikerstabel.';
$lang['smartfeed_limit_format_error'] = 'Limiet parameter is geen erkende waarde.';
$lang['smartfeed_retrieve_error'] = 'Het ophalen van informatie uit de database om een newsfeed te creëren is onmogelijk.';
$lang['smartfeed_feed_type_error'] = 'SmartFeed aanvaardt het gevraagde type feed niet.';
$lang['smartfeed_sort_by_error'] = 'SmartFeed aanvaardt het gevraagde sorteertype niet.';
$lang['smartfeed_topics_only_error'] = 'SmartFeed aanvaardt de gevraagde topictypewaarde niet.';
$lang['smartfeed_lastvisit_param'] = 'De gespecifieerde lastvisit parameter is ongeldig.';
$lang['smartfeed_reset_error'] = 'Databasefout: Kan je laatste bezoekdatum niet resetten.';
$lang['smartfeed_ip_auth_error'] = 'Deze URL kan niet gebruikt worden om een newsfeed op te halen van dit IP adres. Gebruik smartfeed_url.' . $phpEx . 'van deze machine en gebruik de nieuw gegenereerde URL om een newsfeed op te halen.';
$lang['smartfeed_not_logged_in'] = '<b>Omdat je niet ingelogd bent op de site, kan je enkel abonneren op de lijst van publieke forums die hieronder getoond worden. <a href="' . append_sid("login.$phpEx?redirect=smartfeed_url.$phpEx", true) . "\">Log in</a> of <a href=\"./profile.$phpEx?mode=register\">registreer</a> indien je je ook wilt abonneren op niet publieke fora.</b>";
$lang['smartfeed_remove_yours_error'] = 'De removemine parameterwaarde is ongeldig.';
$lang['smartfeed_no_arguments'] = 'Dit programma vereist argumenten.';
$lang['smartfeed_max_word_size_error'] = 'De max_word_size parameter is ongeldig.';
$lang['smartfeed_first_post_only_error'] = 'De firstpostonly parameter is ongeldig. Indien aanwezig moet deze paramater een waarde 1 hebben.'; 
$lang['smartfeed_pms_not_for_public_users'] = 'pms parameter is niet toegestaan voor niet-geregistreerde gebruikers.'; 
$lang['smartfeed_bad_pms_value'] = 'The pms parameter (voor privéberichten) moet een waarde 1 hebben.'; 
$lang['smartfeed_pm_retrieve_error'] = 'Onmogelijk om de privébericht informatie op te vragen uit de database.'; 
$lang['smartfeed_pm_count_error'] = 'Onmogelijk om het aantal privéberichten voor de gebruiker op te vragen uit de database.'; 
$lang['smartfeed_p_parameter_obsolete'] = 'Authentication failure. Due to a software upgrade, the "p" parameter is no longer allowed. To solve this problem, create a new SmartFeed URL at %s, then copy and paste the generated URL into your newsreader application.';

// Miscellaneous variables
$lang['smartfeed_feed_title'] = $board_config['sitename'];
$lang['smartfeed_feed_description'] = $board_config['site_desc'];
$lang['smartfeed_image_title'] = $board_config['site_desc'] . ' Logo';
$lang['smartfeed_reply'] = 'Antwoord door';
$lang['smartfeed_reply_by'] = 'Antwoord door';
$lang['smartfeed_version'] = 'Versie';

// These are used by smartfeed_url.php
$lang['smartfeed_feed_type'] = '<b>Selecteer een type newsfeed:</b><br />(Zorg ervoor dat je een formaat kiest dat door je nieuwslezer ondersteund wordt)';
$lang['smartfeed_page_title'] = 'SmartFeed';
$lang['smartfeed_explanation'] = 'Veel mensen zijn het gemak aan het ontdekken van <i>syndicated newsfeeds</i>. Als je newsfeeds gebruikt hoef je een site niet te bezoeken om zijn inhoud te lezen.<br />Een programma dat men een <i>web aggregator</i> noemt gaat nieuws halen van verschillende sites en biedt het je aan.<br /><br />Sommige forums op deze site kunnen enkel door leden gelezen worden, of vereisen dat je je inschrijft bij de juiste gebruikersgroep. Normaal gezien zouden deze forums niet toegankelijk zijn als openbare newsfeed. Dit forum werd echter voorzien van <em>SmartFeed</em>. Dit is een phpBB modificatie die ingelogde gebruikers toelaat om zowel beperkte als onbeperkte forums te bekijken als newsfeed. Dit wordt gedaan door jezelf te authenticeren met een speciale URL die je kan creëren op deze pagina. Je selecteert de pagina&acute;s op deze site die je interesseren en die je wil opnemen in je aangepaste newsfeed. Je kan het type newsfeed formaat kiezen dat je verkiest. SmartFeed ondersteunt de RSS en Atom protocollen. Zorg ervoor dat je het formaat kiest dat je nodig hebt. Door op de <i>Genereer URL</i> knop op deze pagina te drukken kan je de speciale URL zien die je zal gebruiken. Kopieer deze URL en plak hem in je newsreader om toegang te krijgen tot deze site met je newsreader.<br /><br />Als newsfeeds en web aggregators nieuw zijn voor jou, raden we aan dat je <a href="http://nl.wikipedia.org/wiki/RSS">deze</a> of <a href="http://en.wikipedia.org/wiki/News_aggregator\">deze Wikipedia topic</a> leest. Deze laatste is Engelstalig maar iets uitgebreider dan de eerste en bevat een link naar verschillende newsreaders die je misschien wil downloaden. Misschien geef je er de voorkeur aan om je newsfeeds te lezen via websites zoals <a href="http://www.bloglines.com">Bloglines</a> die voor dit doel gemaakt werden.<br /><br />Als je niet geregistreerd bent op deze site kan je toch een newsfeed krijgen. Je kan dan wel enkel kiezen uit de lijst van openbare forums.';
$lang['smartfeed_lastvisit'] = '<b>De datum van je laatste bezoek resetten wanneer je de newsfeed bekijkt?</b><br />(Selecteer "Ja" als je meestal een newsfeed zal gebruiken om de inhoud van deze site te lezen. Selecteer "Neen" als je de site regelmatig zal bezoeken <i>en</i> als je wil dat items in de newsfeed als ongelezen verschijnen wanneer je de site bezoekt. Opgepast: "Neen" selecteren kan je heel lange newsfeeds geven. Bovendien zal je misschien overbodige artikels opmerken de volgende keer dat je je newsfeed leest.)';
$lang['smartfeed_yes'] = 'Ja';
$lang['smartfeed_no'] = 'Neen';
$lang['smartfeed_all_forums']='Alle aangeboden forums';
$lang['smartfeed_select_forums']='<b>Newsfeeds moeten postings bevatten van deze forums:</b>';
$lang['smartfeed_generate_url_text']='Genereer URL';
$lang['smartfeed_reset_text']='Reset';
$lang['smartfeed_auth_reg_text']='<i>(Enkel voor geregistreerde leden)</i>';
$lang['smartfeed_auth_acl_text']='<i>(Enkel voor de speciale toegang)</i>';
$lang['smartfeed_auth_mod_text']='<i>(Enkel voor moderators)</i>';
$lang['smartfeed_auth_admin_text']='<i>(Enkel voor administrators)</i>';
$lang['smartfeed_limit_text']='<b>Bij het ophalen van postings, beperk de newsfeed tot postings:</b><br />(Als je een browserextensie zoals Sage voor Firefox gebruikt als newsreader zal een hardnekkige cookie die de laatste keer dat je de newsfeed bezocht hebt aanduidt geplaatst worden. Merk op dat de meeste desktop news readers cookies zullen negeren.)';
$lang['smartfeed_since_last_fetch_or_visit']='Sinds laatste newsfeed ophaling of laatste bezoek';
$lang['smartfeed_since_last_fetch_or_visit_value']='LF';
$lang['smartfeed_last_week']='Sinds vorige week';
$lang['smartfeed_last_week_value']='7 DAY';
$lang['smartfeed_last_day']='In de laatste 24 uren';
$lang['smartfeed_last_day_value']='1 DAY';
$lang['smartfeed_last_12_hours']='In de laatste 12 uren';
$lang['smartfeed_last_12_hours_value']='12 HOUR';
$lang['smartfeed_last_6_hours']='In de laatste 6 uren';
$lang['smartfeed_last_6_hours_value']='6 HOUR';
$lang['smartfeed_last_3_hours']='In de laatste 3 uren';
$lang['smartfeed_last_3_hours_value']='3 HOUR';
$lang['smartfeed_last_1_hours']='In het laatste uur';
$lang['smartfeed_last_1_hours_value']='1 HOUR';
$lang['smartfeed_last_30_minutes']='In de laatste 30 minuten';
$lang['smartfeed_last_30_minutes_value']='30 MINUTE';
$lang['smartfeed_last_15_minutes']='In de laatste 15 minuten';
$lang['smartfeed_last_15_minutes_value']='15 MINUTE';
$lang['smartfeed_sort_by']='<b>Sorteer op:</b><br />(Standaardvolgorde is de volgorde waarin postings worden gepresenteerd op dit forum, d.w.z.per Categorie, Forum, Forum topic laatste posttijd (aflopend), Topic post datum/uur';
$lang['smartfeed_sort_forum_topic']='Standaardvolgorde';
$lang['smartfeed_sort_forum_topic_desc']='Standaardvolgorde, Laatste postings eerst';
$lang['smartfeed_sort_post_date']='Post datum/uur';
$lang['smartfeed_sort_post_date_desc']='Post datum/uur, Laatste postings eerst';
$lang['smartfeed_count_limit'] = '<b>Maximum aantal postings in de feed:</b><br />(Enkel van toepassing indien Post/Datum Tijd, Laatste Posting eerst is geselecteerd. Voer een positief nummer in. Voer  \'All\'  in om alle postings te bekijken die aan al jouw opzoekcriteria voldoen.)';
$lang['smartfeed_no_forums_selected']='Je hebt geen forums geselecteerd, dus kan er geen URL gegenereerd worden. Gelieve tenminste 1 forum te selecteren.';
$lang['smartfeed_topics_only']='<b>Alleen nieuwe topics tonen?</b>';
$lang['smartfeed_url_label']='Nadat je op de <i>Genereer URL</i> knop gedrukt hebt zal de URL die je nodig hebt in onderstaande box verschijnen.<br /><b>Kopieer deze URL en plak hem in je newsreader.</b> Als je je opties wijzigt, druk dan opnieuw op de <i>Genereer URL</i> knop en je zal een andere URL krijgen.';
$lang['smartfeed_ip_auth']='<b>Activeer Newsfeed IP Authenticatie?</b><br />(Dit kan gebruikt worden als een extra veiligheidsvoorzorg om URL kaping te beperken. De URL die gegenereerd werd zal enkel werken binnen het gebied van IP addressen die geassocieerd worden met jouw computer. Bijvoorbeeld, als je huidige IP 123.45.67.89 is, en IP Authenticatie wordt geactiveerd, dan zal de feed alleen werken binnen het gebied van 123.45.67.*.)';
$lang['smartfeed_remove_yours']='<b>Je eigen berichten van de feed verwijderen?</b>';
$lang['smartfeed_max_size']='<b>Maximum aantal woorden weer te geven per posting:</b><br />(Geef een positief aantal in. Geef \'Alle\' in om het volledige bericht te zien. Waarschuwing: een aantal instellen kan feedvalidator-fouten veroorzaken.)';
$lang['smartfeed_max_words_wanted']='Alle';
$lang['smartfeed_size_error']='Gelieve een positieve waarde of het woord \'Alle\' in te vullen in dit veld';
$lang['smartfeed_count_limit_error']='De count_limit parameter moet hoger zijn dan 0.';
$lang['smartfeed_count_limit_consistency_error']= 'De count_limit parameter mag enkel gebruikt worden als de sort_by parameter "postdate_desc" is.'; 
$lang['smartfeed_first_post_only']='Limiteer tot “Enkel eerste posting” (Enkel van toepassing indien "Ja")'; 
$lang['smartfeed_private_messages_in_feed']='<b>Toon privéberichten in de feed?</b>';
$lang['smartfeed_no_mcrypt'] = '<b>*** Warning! PHP mcrypt extension is not available! Consequently only public forums can be selected. ***</b>';

// Used in Admininstrator interface to smartfeed_url.php
$lang['smartfeed_advertising_interface_title'] = 'Administrator Advertentie Opties'; 
$lang['smartfeed_enable_ads'] = '<b>Geef advertenties weer in jouw nieuwsfeed?</b>'; 
$lang['smartfeed_set_ad_options'] = 'Stel advertentie opties in'; 
$lang['smartfeed_set_top_options'] = 'Plaats een advertentie bovenaan je nieuwsfeed'; 
$lang['smartfeed_set_middle_options'] = 'Plaats advertenties tussen de onderwerpen in je  nieuwsfeed'; 
$lang['smartfeed_set_bottom_options'] = 'Plaats een advertentie onderaan je nieuwsfeed'; 
$lang['smartfeed_ad_item_title'] = '<b>Titel van de advertentie</b><br />(Verplicht wanneer deze sectie aangezet werd. Gebruik enkel platte tekst; geen speciale karakters of HTML.)'; 
$lang['smartfeed_ad_item_link'] = '<b>Link naar detailgegevens</b><br />(Je kan deze leeg laten indien niet van toepassing. Zorg ervoor dat je link steeds start met http://)'; 
$lang['smartfeed_ad_item_desc'] = '<b>Volledige advertentie omschrijving</b><br />(Je kan deze leeg laten indien niet van toepassing. In de meeste gevallen zal je wel degelijk bijkomende details omtrent je product of service willen geven. Je kan hiervoor platte tekst gebruiken, HTML of parsed XML inhoud die specifiek ontworpen is voor RSS of Atom feeds. OPGELET: niet alle niewslezers zullen de HTML correct parsen of weergeven. Gelieve GEEN Javascript te gebruiken omdat de meeste nieuwslezers geen Javascript kunnen uitvoeren. Backslash karakters (\) zullen verwijderd worden.)'; 
$lang['smartfeed_ad_item_header_top'] = 'Bovenkant van de nieuwsfeed advertentie'; 
$lang['smartfeed_ad_item_header_middle'] = 'Midden van de nieuwsfeed advertentie'; 
$lang['smartfeed_ad_item_header_bottom'] = 'Onderkant van de nieuwsfeed advertentie'; 
$lang['smartfeed_ad_item_repeat'] = '<b>Geef het aantal nieuwsfeed items in dat moet getoond worden alvorens een advertentie in te voegen </b><br />(Verplicht in te geven en moet groter zijn dan 0.)'; 
$lang['smartfeed_ad_clear'] = 'Wis alle velden in de advertentiesectie'; 
$lang['smartfeed_repeat_must_be_numeric'] = 'Nieuwsfeed items die getoond dienen te worden dienen numeriek te zijn'; 
$lang['smartfeed_repeat_must_be_greater_0'] = 'De waarde van het nieuwsfeed item moet groter zijn dan 0'; 
$lang['smartfeed_title_required'] = 'Indien een sectie geactiveerd werd, zal het titelveld inhoud bevatten.'; 
$lang['smartfeed_advertising_introduction'] = 'Deze sectie is enkel zichtbaar voor Beheerders.<br /><br />Smartfeed laat toe om de inhoud van advertenties te tonen in de nieuwsfeed die aan gebruikers gestuurd wordt. Gebruik deze interface om de advertentieopties aan of uit te zetten of  in te stellen. Advertenties verschijnen net als andere items in de nieuwsfeed maar worden zeer herkenbaar aangeduid als zijnde advertenties. Advertenties kunnen op 3 verschillende plaatsen binnen de nieuwsfeed getoond worden: Voor het eerste feed item, helemaal onderaan de feed, en op regelmatige plaatsen binnen de feed. Elke sectie kan in- of uitgeschakeld worden. De inhoud kan in of uitgeschakeld worden door middel van de algemene checkbox. Indien uitgeschakeld kan je de informatie in de advertentievelden  terug activeren.<br /><br />Gelieve nota te nemen dat op dit moment het Google Adsense programma geen RSS ondersteunt, en bijgevolg zal de Javascript code die door Google Adsense gegenereerd wordt, hoogstwaarschijnlijk niet werken. Het is aangewezen dat je de feed inhoud test in verschillende nieuwslezers om er zeker van te zijn dat je tekst verschijnt zoals jij dat wenst. Houd er rekening mee dat verschillende nieuwslezerprogramma’s verschillende resultaten kunnen tonen.<br /><br />Stel je browser zo in dat je pop-up vensters kan ontvangen voor deze website. Indien je dit niet doet, loop je de kans dat je eventuele foutmeldingen niet kan lezen.'; 
$lang['smartfeed_advertising_path_error'] = 'Het is niet mogelijk om het bestand met de advertentiedata te lezen of aan te maken. Het is mogelijk dat de directory waarin het bestand zich bevindt niet de juiste bewerkingspermissies heeft. '; 
$lang['smartfeed_ad_data_saved'] = 'De gegevens van je advertentie opties werden bewaard'; 
$lang['smartfeed_ad_data_invalid_user'] = 'De gegevens van je advertentie opties werden NIET bewaard. Waarschijnlijk werd een poging tot hacken uitgevoerd omdat de gebruiker die de advertentiedata bewaarde geen beheerderprivileges heeft.'; 
$lang['smartfeed_ad_data_access_error'] = 'Het bestand met de advertentie informatie kon niet gelezen worden. Vermoedelijk is deze fout te wijten aan een permissieprobleem.'; 
$lang['smartfeed_ad_feed_category'] = 'Advertenties'; // De feed item categorie die te gebruiken is voor advertenties, alsook in de itemtitel om het item aan te duiden als advertentie. 
$lang['smartfeed_show_ads_to_public_only'] = 'Toon advertenties enkel aan publieke (niet-geregistreerde) gebruikers (Enkel mogelijk wanneer advertentiemogelijkheden aangeschakeld zijn)';

?>