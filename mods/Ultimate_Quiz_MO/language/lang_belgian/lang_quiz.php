<?php
/***************************************************************************
*                        				   lang_quiz.php
***************************************************************************/
/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

// Ultimate Quiz MOD v1.1.4

// Lang variables concerning the installation / updating of the MOD

$lang['Quiz_install'] = 'Ultimate Quiz MOD Installatie';
$lang['Quiz_install_mod'] = 'Ultimate Quiz MOD <b>v1.1 Series</b>';
$lang['Quiz_install_description'] = 'Dit script zal nu je database aanpassen zodat de Ultimate Quiz MOD kan functioneren!<br />Queries die getoond worden in groen zijn succesvol uitgevoerd, voor deze in rood, werd een probleem tegengekomen. Het is absoluut van vitaal belang dat je alle code-aanpassingen hebt gedaan, en dat je alle quiz bestanden hebt opgeladen op hun respectievelijke plaatsen.';
$lang['Quiz_install_success'] = 'De installatie is compleet, en er werden geen fouten tegengekomen. Je kan nu beginnen de Ultimate Quiz MOD te gebruiken!';
$lang['Quiz_install_failure'] = 'De installatie is compleet, er werden echter fouten tegengekomen. Het wordt aangeraden deze fouten recht te zetten vooraleer je de Ultimate Quiz MOD gebruikt!';
$lang['Quiz_install_no_permissions'] = 'U heeft geen toelating om deze file te benaderen';
$lang['Quiz_install_or_update'] = 'Wenst u een nieuwe installatie, of een update van v1.0.6 door te voeren<br /><a href="%s">Installeren</a> - <a href="%s">Updaten</a>';
$lang['Quiz_install_continue'] = 'Om verder te gaan met de update, klik <a href="%s">hier</a>!<br />Het is aangeraden om eerst een backup te doen!<br /><br />Het is van vitaal belang dat u nu quiz_updater.php uitvoert.';

$lang['Quiz_update_introduction'] = 'Ultimate Quiz MOD 1.1.4 RC / 1.2 FINAL<br />Door battye<br /><br />Dit is de updater van v1.0.6 tot v1.1.4 RC / v1.2.x.<br />Dit kan een aantal minuten in beslag nemen, afhankelijk van de grootte van je database! Categoriën, quizzen en quiz gegevens zullen worden getransfereerd. Statistieken, zullen niet worden bewaard, door hun aard.';
$lang['Quiz_update_category'] = 'Updaten van categorie: <b>%s</b><br />';
$lang['Quiz_update_quiz'] = 'Updaten van algemene quiz gegevens: <b>%s</b><br />';
$lang['Quiz_update_questions'] = 'Updaten van quizvragen gegevens: <b>%s</b><br />';
$lang['Quiz_update_dropped_renamed'] = 'Tabellen gedropt en hernoemd';
$lang['Quiz_update_complete_update'] = '<br /><br />De update is vervolledigd, indien u fouten tegenkwam of vragen heeft, contacteer dan aub battye @ <a href=http://forums.cricketmx.com>http://forums.cricketmx.com</a>';
$lang['Quiz_update_statistics_file'] = 'Statistiekenbestand werd gecreëerd';
$lang['Quiz_update_spacer'] = '<br /><br />';

// Cash

$lang['Quiz_cash_total_result_gain'] = 'U won in totaal <b>%d %s</b>';
$lang['Quiz_cash_total_result_loss'] = 'U verloor in totaal <b>%d %s</b>';
$lang['Quiz_cash_information'] = 'Winst per correct antwoord: <b>%d</b> &middot; Verlies per foutief antwoord: <b>%d</b> &middot; Taks per quiz: <b>%d</b>';

// Statistics

$lang['Quiz'] = 'Quiz';
$lang['Quiz_stats'] = 'Quiz Statistieken';
$lang['Quiz_stats_none'] = 'Er zijn geen statistieken voor deze quiz!';

$lang['Quiz_stats_author'] = 'Quiz Auteur';
$lang['Quiz_stats_correct'] = 'Correct';
$lang['Quiz_stats_incorrect'] = 'Foutief';
$lang['Quiz_stats_percentage'] = 'Percentage';
$lang['Quiz_stats_all_time_highest'] = 'All Time Hoogste Scores';

$lang['Quiz_stats_most_plays'] = 'Meest Gespeelde Quizzen';
$lang['Quiz_stats_plays'] = 'Keren Gespeeld';

$lang['Quiz_stats_individual_high'] = 'High Scorers voor <i>%s</i>';

// Variables concerning quiz moderators:
	
$lang['Quiz_cp_not_moderator'] = 'U bent geen quiz moderator!';
$lang['Quiz_cp_delete_sure'] = 'Bent u er zeker van deze quiz te verwijderen? Dit kan niet ongedaan worden gemaakt!';
$lang['Quiz_cp'] = 'Quiz Moderator Controle Paneel';
$lang['Quiz_cp_delete'] = 'Verwijder Quiz';
$lang['Quiz_cp_deleted'] = 'De quiz is succesvol verwijderd!';
$lang['Quiz_cp_edit'] = 'Bewerk Quiz';
$lang['Quiz_cp_edited'] = 'Quiz successvol bewerkt!';
$lang['Quiz_cp_edit_explaination'] = 'Je kan de naam, de vragen en de anwtoorden van een quiz hier bewerken:';
$lang['Quiz_cp_place_check'] = 'Vink het vakje naast het correcte anwtoord aan';
$lang['Quiz_cp_move_explain'] = 'Verplaats deze quiz naar een andere categorie:';
$lang['Quiz_cp_move'] = 'Verplaats Quiz';
$lang['Quiz_cp_move_sucess'] = 'de quiz is succesvol verplaatst!';
$lang['Quiz_cp_play_quiz_mod'] = '<b>You are have the appropriate permissions to edit this quiz:</b>';
$lang['Quiz_cp_play_quiz_mod_do'] = '%sBewerk Quiz%s, %sVerwijder Quiz%s, %sVerplaats Quiz%s';

// All the variables concerning the end user:

$lang['Quiz_click_return_quiz'] = 'Klik %sHier%s om terug te gaan naar de Quiz Pagina';
$lang['Quiz_number_of_plays'] = '%s x Gespeeld';
$lang['Quiz_number_of_play'] = '1 x Gespeeld';
$lang['Quiz_must_be_registered'] = 'Het is vereist dat u geregistreerd en ingelogd bent op mee te doen aan quizzen of er toe te voegen';
$lang['Quiz_post_requirement_not_met'] = 'U dient %s berichten geplaatst hebben op de forums om deel te nemen aan quizzen of er toe te voegen';
$lang['Quiz_insufficient_questions'] = 'U heeft ofwel een cijfer ingevoerd boven het toegelaten aantal, of beneden het toegelaten cijfer, voor vragen toegestaan per quiz. Kies aub een ander nummer';
$lang['Submit_multiple_choice_quiz'] = 'Voeg een Multiple Choice Quiz toe';
$lang['Submit_true_false_quiz'] = 'Voeg een Waar / Niet Waar Quiz toe';
$lang['Submit_input_quiz'] = 'Voeg een Geef Antwoord in Quiz toe';
$lang['Submit_quiz'] = 'Voeg Quiz toe';
$lang['Quiz_only_mod_can_submit'] = 'Alleen Quiz moderatoren kunnen quizzen toevoegen!';
$lang['Quiz_alternate'] = 'Foutief Antwoord';
$lang['Quiz_question'] = 'Vraag';
$lang['Quiz_insert_name'] = 'Geef Quiznaam op';
$lang['Quiz_set_up_options'] = 'Opties';
$lang['Quiz_select_number'] = 'Selecteer het aantal vragen die je wenst voor je quiz:';
$lang['Quiz_only_admin_submit'] = 'Alleen administrators mogen quizzen toevoegen'; 
$lang['Quiz_only_registered_submit'] = 'U dient geregistreerd en ingelogd te zijn om quizzen toe te voegen';
$lang['Quiz_no_multiple_choice'] = 'Multiple Choice quizzen zijn niet toegestaan'; 
$lang['Quiz_no_true_false'] = 'Waar & Niet Waar quizzen zijn niet toegestaan'; 
$lang['Quiz_no_input_answer'] = 'Invoer quizzen zijn niet toegestaan'; 
$lang['Quiz_no_number_chosen'] = 'U dient het aantal vragen dat u wenst in de quiz te selecteren!'; 
$lang['Quiz_answer_true'] = 'Waar'; 
$lang['Quiz_answer_false'] = 'Niet Waar'; 
$lang['Quiz_answer_correct'] = 'Correct Antwoord'; 
$lang['Quiz_added_successfully'] = 'Uw quiz is succesvol toegevoegd aan de database!'; 
$lang['Quiz_input_information'] = 'Na het lezen van de vraag vult u het anwtoord in het tekstveld ernaast!';
$lang['Quiz_multiple_information'] = 'Na het lezen van de vraag, selecteert u het correcte antwoord ernaast!';
$lang['Quiz_true_false_information'] = 'Na het lezen van de vraag, selecteert u of het Waar of Niet Waar is!';
$lang['Quiz_answer_status'] = 'Uw antwoord was <b>%s</b>, het correcte anwtoord is <b>%s</b>';
$lang['Quiz_show_correct_score'] = 'Correcte Antwoorden: <b>%s</b>';
$lang['Quiz_show_incorrect_score'] = 'Foutieve Antwoorden: <b>%s</b>';
$lang['Quiz_score'] = 'Quiz Resultaten';
$lang['Quiz_quizzes'] = 'Quizzen';
$lang['Quiz_type_true_false'] = 'Waar / Niet Waar Quiz';
$lang['Quiz_type_multiple_choice'] = 'Multiple Choice Quiz';
$lang['Quiz_type_input_answer'] = 'Voer Antwoord In Quiz';
$lang['Quiz_view_alphabetical'] = 'Bekijk Alfabetisch';
$lang['Quiz_view_chronilogical'] = 'Bekijk per Datum';
$lang['Quiz_view_type'] = 'Bekijk per Quiz Type';
$lang['Quiz_view_author'] = 'Bekijk per Auteur';
$lang['Quiz_author_cannot_play'] = 'U kan geen Quizzen spelen die u zelf heeft ingevoerd!';
$lang['Quiz_no_quizzes'] = 'Er werden nog geen quizzen toegevoegd in deze categorie!<br />Klik <a href="%s">hier</a> om een Quiz toe te voegen!';
$lang['Quiz_password_protect'] = 'Paswoord Categorie';
$lang['Quiz_password_protect_information'] = 'Deze categorie is beveiligd met een paswoord:';
$lang['Quiz_category_password_wrong'] = 'Het paswoord dat u opgaf is foutief, ga aub terug en probeer opnieuw!';
$lang['Quiz_min_max'] = 'De administrator heeft een minimum van <b>%d</b> vragen en een maximum van <b>%d</b> vragen ingesteld!';
$lang['Quiz_min_max_set'] = 'De administrator heeft een vast aantal van <b>%d</b> vragen ingesteld!';
$lang['Quiz_min_max_exceed'] = 'U heeft ofwel een cijfer ingegeven dat het maximum overstijgt, of lager is dan het minimum.<br />Klik aub op Terug in je browser en probeer opnieuw!';
$lang['Quiz_registered_category_permissions_no_access'] = 'U heeft niet de vereiste rechten om toegang te hebben tot deze categorie. Dit is enkel voor geregistreerde gebruikers.';
$lang['Quiz_only_play_it_once'] = 'U kan een quiz slechts eenmaal spelen.';

// Lang variables concerning the admin:

$lang['Quiz_admin_latest_version'] = 'The latest version of the Ultimate Quiz MOD: <b>%s</b><br />If you experience any problems with the Ultimate Quiz MOD, please visit either (or both) of the following websites for assistance:<br /><a href="http://www.phpbb.com/phpBB/">phpBB.com</a> or <a href="http://www.cmxmods.net/demo_board/">Cmxmods.net</a>.';
$lang['Quiz_admin_cash_currency'] = 'Welke cash munt wenst u te gebruiken voor de quizzen?<br />Geef aub het database veld op (<b>user_</b>*), niet de naam van de munt!';
$lang['Quiz_admin_cash_settings'] = 'Quiz Cash Settings';
$lang['Quiz_admin_cash_enable'] = 'Moet cash aanstaan? (Gebruik dit alleen als de Cash MOD geïnstalleerd!)';
$lang['Quiz_admin_cash_correct'] = 'Hoeveel moet een gebruiker verdienen per correct antwoord?';
$lang['Quiz_admin_cash_incorrect'] = 'Hoeveel moet een gebruiker verliezen per foutief anwtoord?';
$lang['Quiz_admin_cash_taxation'] = 'Hoeveel moet de taks bedragen om een quiz te spelen?';
$lang['Quiz_admin_mod_only_submit'] = 'Quizzen toevoegen alleen toegelaten voor moderators?';
$lang['Quiz_admin_stats_display'] = 'Hoeveel statistieken moeten worden getoond per module?';
$lang['Quiz_admin_category_permissions_choose'] = 'Welke permissies moet deze categorie hebben?';
$lang['Quiz_admin_category_guest'] = 'Gast';
$lang['Quiz_admin_category_registered'] = 'Geregistreerd';
$lang['Quiz_admin_category_registered_hidden'] = 'Geregistreerd [ Verborgen ]';
$lang['Quiz_admin_show_answers'] = 'Wenst u dat de anwtoorden worden getoond nadat de quiz is gespeeld?';
$lang['Quiz_admin_register_to_play'] = 'Moeten gebruikers geregistreerd zijn om deel te nemen aan een quiz of een quiz toe te voegen?';
$lang['Quiz_admin_post_count'] = 'Moeten gebruikers een zeker aantal berichten hebben geplaatst om deel te nemen aan een quiz of om een quiz toe te voegen?';
$lang['Quiz_admin_quiz_numbers'] = 'Wat is het minimum en maximum aantal vragen dat een gebruiker kan hebben in een quiz?<br />Schaidt de waarden met een komma, en gebruik hetzelfde getal 2 maal (<i>x,x</i>) om een vast getal te gebruiken voor iedereen.';
$lang['Quiz_admin_posts'] = 'Geef het minimum aantal berichten op:';
$lang['Quiz_admin_play_once'] = 'Mogen gebruikers een kwis slechts eenmaal spelen?';
$lang['Quiz_admin_author_play'] = 'Mag de auteur van de quiz zijn/haar eigen quiz spelen?';
$lang['Quiz_admin_moderators'] = 'Geef alle gebruikers op welke je als quizmoderator wenst aan te stellen (verplaatsen, bewerken, verwijderen van quizzen).<br />Scheid de gebruikers id\'s met een komma!';
$lang['Quiz_admin_banned'] = 'Geef alle gebruikers op die je wil bannen van de quiz.<br />Scheid de gebruikers id\'s met een komma!';
$lang['Quiz_admin_configuration'] = 'Quiz Configuratie';
$lang['Quiz_admin_permissions'] = 'Quiz Permissies';
$lang['Quiz_admin_categories'] = 'Quiz Categoriën';
$lang['Quiz_admin_yes'] = 'Ja';
$lang['Quiz_admin_no'] = 'Nee';
$lang['Quiz_admin_cat_edit'] = 'Bewerk';
$lang['Quiz_admin_cat_delete'] = 'Verwijder';
$lang['Quiz_admin_cat_add'] = 'Voeg een nieuwe categorie toe';
$lang['Quiz_admin_cat_move'] = 'Verplaats Quizzen';
$lang['Quiz_admin_cat_move_to_category'] = 'Deze functie kan worden gebruikt om alle quizzen in een categorie te verplaatsen naar een andere.<br />Dit kan gemakkelijk zijn als je van plan bent een categorie te verwijderen, maar de quizzen wenst te behouden.<br /><br />Selecteer uit de lijst naar welke categorie je de quizzen wenst te verplaatsen:';
$lang['Quiz_admin_delete_category'] = 'Ben je zeker dat je deze categorie wenst te verwijderen, en alle quizzen die er zich in bevinden?<br />Klik <a href="%s">hier</a> om verder te gaan.';
$lang['Quiz_admin_configuration_updated'] = 'Quiz settings succesvol geupdate<br />Klik %shier%s om terug te keren naar het Quiz settings paneel!';
$lang['Quiz_admin_move_category_successful'] = 'Alle quizzen zijn succesvol verplaatst naar de nieuwe categorie!';
$lang['Quiz_admin_number_quizzes'] = '(%d Quizzen)';
$lang['Quiz_admin_description'] = 'Beschrijving Categorie:';
$lang['Quiz_admin_name'] = 'Naam Categorie:';
$lang['Quiz_admin_edit_explanation'] = 'Bewerk je categorie indormatie hieronder: (Categorie paswoorden zijn optioneel)';
$lang['Quiz_admin_editing'] = 'Bewerk Categorie';
$lang['Quiz_admin_category_update_successful'] = 'De categorie is succesvol geupdate!';
$lang['Quiz_admin_add_explanation'] = 'Hier, kan je een nieuwe categorie voor je quizzen toevoegen. Geef hieronder de informatie op! (Categorie paswoorden zijn optioneel)';
$lang['Quiz_admin_add'] = 'Maak een nieuwe Categorie';
$lang['Quiz_admin_new_category_successful'] = 'De nieuwe categorie is succesvol aangemaakt!';
$lang['Quiz_admin_password_protect'] = 'Categorie paswoord:';
$lang['Quiz_admin_author_mod'] = 'Kunnen quiz auteurs moderator zijn van hun <b>eigen</b> quizzen?';
?>