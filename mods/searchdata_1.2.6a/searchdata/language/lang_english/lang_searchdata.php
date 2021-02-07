<?php
/***************************************************
 * Project: 	Search Data
 * File Name:   lang_searchdata.php
 * File Path:   language/lang_english/
 * Start Date:  22-11-2006 21:38:22
 * Written By:  Joe Belmaati
 * Version #:   1.2.6
 * Last MOD:    13-04-2006 14:40:55
 ***************************************************/

/***************************************************
 * Notes:
 *
 ***************************************************/

//
// Phrases
//
$lang['Search_phrases'] = 'Search Phrases';
$lang['Search_phrase'] = 'Search Phrase';
$lang['Phrases'] = 'Phrases';
$lang['Phrase'] = 'Phrase';
$lang['Search_phrases_explain'] = 'Here you can view the words people have searched for in your forum';
$lang['Click_return_search_phrases'] = 'Click %shere%s to return to the Admin Search Phrases';
$lang['Search_time'] = 'Search Time';
$lang['User_IP'] = 'IP';
$lang['No_search_phrases'] = 'No data to show';
$lang['Referer'] = 'Referer';
$lang['Status'] = 'Status';
$lang['Parameter'] = 'Parameter';
$lang['Search_and_sort'] = 'Search and Sort';
$lang['Delete_entry'] = 'Delete Entry';
$lang['OK'] = '<span style="color: green"><b>OK</b></span>';
$lang['Failed'] = '<span style="color: red"><b>Failed!</b></span>';
$lang['Entry_deleted'] = 'Entry deleted';
$lang['Search_title_only'] = 'Search title only';
$lang['Records'] = 'Records';
$lang['Record'] = 'Record';
$lang['Query'] = 'Query';
$lang['Update_complete'] = 'Your database has been updated to accommodate Search Data <b>%s</b>';

//
// Statistics
//
$lang['Result'] = 'Result';
$lang['Stats'] = 'Stats';
$lang['Stats_explain'] = 'These are the general search statistics as well as statistics for the various search parameters';
$lang['General_page'] = 'General';
$lang['Num_results'] = 'Number of results to display';
$lang['Percentage'] = 'Percentage';
$lang['First_search'] = 'Time of first logged search';
$lang['Last_search'] = 'Time of last logged search';
$lang['Days_active'] = 'Number of days since first logged search';
$lang['Searches_per_day'] = 'Average number of searches per day';
$lang['Total_searches'] = 'Total logged board searches';
$lang['Succesful_searches'] = 'Succesful searches';
$lang['Failed_searches'] = 'Failed searches';
$lang['Succes_rate'] = 'Succes rate';
$lang['Filter_stop_words'] = 'Filter stop words';
$lang['Sort_options'] = 'Sort options';
$lang['Search_fields'] = 'Search Fields';
$lang['Search_terms'] = 'Search Terms';
$lang['Sort_dir'] = 'Sort Direction';
$lang['Specific_data'] = 'Specific Data';
$lang['All'] = 'All';
$lang['Guests'] = 'Guests';
$lang['No_config'] = 'Please visit the configuration page. There you can enable Statistics modules for this page.';
$lang['Connect_proxy'] = 'Connected through proxy';
$lang['Date_specific_stats'] = 'Date specific statistics';
$lang['Date_specific_stats_explain'] = 'Here you can assign a date span and that will cause the statistics for that specific period to be shown';
$lang['Begin_datespan'] = 'Date start (MM/DD/YYYY)';
$lang['End_datespan'] = 'Date end (MM/DD/YYYY)';
$lang['Define_datespan'] = 'Define date span';
$lang['Invalid_datespan'] = 'Invalid Datespan';
$lang['Click_return_search_stats'] = 'Click %shere%s to return to Search Data Statistics';
$lang['Datespan_result'] = 'Search Data Statistics for the period between %s and %s';

//
// Words
//
$lang['Word'] = 'Word';
$lang['Words'] = 'Words';
$lang['Words_explain'] = 'This page breaks every search phrase into single words';
$lang['Max_word'] = 'The most popular search word is';
$lang['Max_word_occ'] = 'The most popular search word occurs';
$lang['Max_words'] = 'Number of logged unique search words';
$lang['Times'] = 'Times';
$lang['Once'] = 'Once';
$lang['Result_ascending'] = 'Result Ascending';
$lang['Result_descending'] = 'Result Descending';
$lang['Word_ascending'] = 'Word Ascending';
$lang['Word_descending'] = 'Word Descending';

//
// Config
//
$lang['Config'] = 'Config';
$lang['Config_explain'] = 'In this page you can setup your stats page and disable search tracking. You can also delete selected results.';
$lang['Disable_mod'] = 'Disable Search Tracking';
$lang['Disable_mod_admin'] = 'Disable Search Tracking For Administrators';
$lang['Disable_mod_moderator'] = 'Disable Search Tracking For Moderators';
$lang['Checkboxes'] = 'Use the checkboxes to configure which modules you want in your stats page';
$lang['Option'] = 'Option';
$lang['Stats_page_settings'] = 'Stats Page Settings';
$lang['Enable'] = 'Enable';
$lang['User_id'] = 'User ID';
$lang['Forum_id'] = 'Forum ID';
$lang['Category_id'] = 'Category ID';
$lang['Click_return_search_config'] = 'Click %shere%s to return to Search Data Configuration';
$lang['Click_return_search_phrases'] = 'Click %shere%s to return to Search Data Phrases';
$lang['Search_config_updated'] = 'Search Data Configuration successfully updated';
$lang['Selective_deleted'] = 'Selected data succesfully deleted. Total number of affected rows = <b>%d</b>';
$lang['No_matches'] = 'We could not find any matches for <b>%s</b> = <b>%s</b>';
$lang['Selective_delete'] = 'Selective Delete';
$lang['Selective_delete_explain'] = 'Here you can delete selected search data results';
$lang['Backup_explain_sd'] = 'Here you can backup your phpBB Search Data related information. This function will send an sql file to your browser. You can then save the file and restore it at a later time using phpMyAdmin, phpBB\'s restore feature or similar';
$lang['Backup_data'] = 'Data only';
$lang['Backup_data_structure'] = 'Data and table structure';
$lang['Mod_version'] = 'phpBB Search Data Version <b>%s</b>';
$lang['Tidy_ok'] = 'Search phrases table succesfully tidied up. Affected rows = <b>%s</b>';
$lang['Tidy'] = 'Tidy Up';
$lang['Tidy_explain'] = 'Here you can tidy up your search phrases table. This function will clean up double spaces and remove leading and trailing white space';
$lang['No_tidy_matches'] = 'Search data table all tidied up already';
$lang['Bogus_chars'] = 'Strip out these characters as well?';
$lang['Bogus_cleaned'] = '<span class="gensmall" style="color: orange;"><i>This entry has been stripped of bogus characters</i></span>';
$lang['Version_check'] = 'Version Check';
$lang['Version_check_explain'] = 'Here you can check whether or not you\'ve got the latest version of Search Data. You are currently running version <b>%s</b>';
$lang['Version_check_deny'] = 'Your last version check was <b>%s</b>. You can only make one version check per day';
$lang['Check_now'] = 'Check Now';
$lang['Version_check_latest'] = '<span style="font-weight: bold; color: green;">You\'ve got the latest version of Search Data</span>';
$lang['Version_check_not_latest'] = '<span style="font-weight: bold; color: red;">There\'s a newer version of Search Data.</span><br /><br />You\'ve got version <b>%s</b> and the newest version is <b>%s</b>';
$lang['Download_latest'] = 'Click %s<b>here</b>%s to download Search Data %s which is the latest version';
$lang['Purge_search_phrases'] = 'Purge';
$lang['Purge_search_phrases_explain'] = 'This module will purge all search data';
$lang['Purge_search_phrases_warn'] = 'This will delete all your search data - it is advisable to backup your search data before purging';
$lang['Confirm_delete_search_phrases'] = 'Please confirm that you want to purge all search data';
$lang['Search_phrases_purged'] = 'Search data purged successfully';
$lang['Stopwords'] = 'Stop Words';
$lang['Synonyms'] = 'Synonyms';
$lang['PHP_Version_disclaimer'] = 'Unfortunately there is a bug in PHP Version %s that prevents this feature from working properly';

//
// That's all Folks!
// -------------------------------------------------

?>