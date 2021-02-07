<?php
//
//	file: language/lang_english/lang_extend_cat_hierarchy.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.4 - 09/05/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// use this one to set your translation copyright if any
// $lang['CH_TRANSLATION'] = '';

// admin part
if ( $is['admin'] )
{
	$lang['Lang_extend_cat_hierarchy'] = 'Categories Hierarchy';

	// admin_forums
	$lang['Forum_styles'] = 'Styles';
	$lang['Configuration+'] = 'Configuration +';
	$lang['Bots_management'] = 'Bots management';

	$lang['View_details'] = 'View details';
	$lang['change_view'] = 'Change view';
	$lang['Forum_edit_explain'] = 'The form below will allow you to edit a forum (or category).';
	$lang['Forum_create_explain'] = 'The form below will allow you to create a forum (or category).';
	$lang['Forum_type'] = 'Forum type';
	$lang['Forum_main'] = 'Parent forum';
	$lang['Forum_order'] = 'Position this forum after';
	$lang['Move_contents_explain'] = 'Choose a forum to where move all contents (topics and sub-forums).';
	$lang['Forum_style'] = 'Style used to display this forum';
	$lang['Forum_style_explain'] = 'This style will be used in place of the user or default style. Choose "None" if you don\'t want to override them.';
	$lang['Images'] = 'Images';
	$lang['Images_explain'] = 'You can use either an url or an images[] key entry (check template/<i>your_template</i>/<i>your_template</i>.cfg).';
	$lang['Forum_nav_icon'] = 'Navigation icon';
	$lang['Forum_nav_icon_explain'] = 'This icon will appear in front of the forum name in the navigation sentences (Forum index &raquo forum 1 &raquo ...).';
	$lang['Forum_icon'] = 'Forum image';
	$lang['Forum_icon_explain'] = 'This image will appear in front of the forum name in the forum cell of the index page.';
	$lang['Forum_link_hit_count'] = 'Count forum hits';
	$lang['Forum_subs_hidden'] = 'Hide sub-forums list';
	$lang['Forum_subs_hidden_explain'] = 'Allow to hide the sub-forums list appearing under the forum name in the forum cell of the index page.';

	$lang['Topics_per_page_explain'] = 'Set the value to 0 to use the default configuration or user choice.';
	$lang['Topics_sort'] = 'Sort topics by';
	$lang['Topics_sort_explain'] = 'Select the sort method you want for this forum. Leave "None" to use the default or the user settings.';
	$lang['Topics_split_in_box'] = 'New box';
	$lang['Topics_split_title_only'] = 'Split with only a title row header';
	$lang['Topics_split_global'] = 'Split global announcements from regular announcements';
	$lang['Topics_split_announces'] = 'Split Announcements from regular and sticky topics';
	$lang['Topics_split_stickies'] = 'Split Stickies from regular topics';

	$lang['Index_layout'] = 'Sub-forums Layout';
	$lang['Last_topic_title_length'] = 'Title length of the last topic on index';
	$lang['Last_topic_title_length_explain'] = 'Set the number of chars you want to display for the last topic title on index to prevent the layer to be screw with too long titles. Set it to 0 if you don\'t want to cut the titles.';
	$lang['Override_user_choice'] = 'Override user choice';

	$lang['Board_box_content'] = 'Board announcements setup';
	$lang['Board_box_content_explain'] = 'Choose what kind of announcements you want to display in the board announcements box.';
	$lang['Do_not_display'] = 'Do not display';
	$lang['Global_Parent_announces'] = 'Global and parent-forums announcements';
	$lang['Global_Childs_announces'] = 'Global and sub-forums announcements';
	$lang['Global_Branch_announces'] = 'Global and whole-section announcements';

	$lang['Default_setup'] = 'Default configuration or user choice';

	$lang['Forum_not_empty'] = 'There is still topics standing in this forum : move or delete them before changing the type.';
	$lang['Root_delete_deny'] = 'You can not delete the forum index.';
	$lang['Attach_to_link_denied'] = 'You can not move contents to a link.';
	$lang['Empty_move_to'] = 'Please choose a forum to move contents or "Delete All" to delete them.';
	$lang['Forums_resync_done'] = 'The forum and its sub-forums have been re-synchronised.';

	$lang['Copy'] = 'Copy';
	$lang['Details'] = 'Details';
	$lang['Group'] = 'Group';
	$lang['Selected'] = 'Selected';

	// caches management
	$lang['Caches'] = 'Caches';
	$lang['Cache_admin'] = 'Caches administration';
	$lang['Click_return_cacheadmin'] = 'Click %sHere%s to return to the caches administration.';

	$lang['Table_caches'] = 'Generic level caches';
	$lang['Template_cache'] = 'Template Cache';
	$lang['Cache_path'] = 'Caches directory';
	$lang['Cache_path_explain'] = 'Path under your phpBB root directory where will the cache files will be stored. Default is cache/';
	$lang['Check_setup'] = 'Check the directory';

	$lang['Cache_regen'] = 'Regenerate the cache';
	$lang['Cache_last_generation'] = 'Data last regeneration';

	$lang['Enable_cache_langs'] = 'Enable lang cache';
	$lang['Enable_cache_config'] = 'Enable config table cache';
	$lang['Enable_cache_forums'] = 'Enable forums table cache';
	$lang['Enable_cache_moderators'] = 'Enable moderators list cache';
	$lang['Enable_cache_bots'] = 'Enable search engines crawlers list cache';
	$lang['Enable_cache_topics_attr'] = 'Enable topic title attributes list cache';
	$lang['Enable_cache_themes'] = 'Enable themes table cache';
	$lang['Enable_cache_ranks'] = 'Enable ranks table cache';
	$lang['Enable_cache_words'] = 'Enable words censorship table cache';
	$lang['Enable_cache_smilies'] = 'Enable smilies table cache';
	$lang['Enable_cache_icons'] = 'Enable icons table cache';
	$lang['Enable_cache_cp_patches'] = 'Enable installed control panels patches table cache';
	$lang['Enable_cache_cp_panels'] = 'Enable control panels definitions table cache';
	$lang['Enable_cache_template'] = 'Enable cache template';
	$lang['Check_recent_tpl'] = 'Check if .tpl files have changed';

	$lang['Cache_failed_langs'] = 'Lang cache failed. The cache has been disabled.';
	$lang['Cache_failed_config'] = 'Config table cache failed. The cache has been disabled.';
	$lang['Cache_failed_forums'] = 'Forums table cache failed. The cache has been disabled.';
	$lang['Cache_failed_moderators'] = 'Moderators list cache failed. The cache has been disabled.';
	$lang['Cache_failed_bots'] = 'Search engines crawlers list cache failed. The cache has been disabled.';
	$lang['Cache_failed_topics_attr'] = 'Topic title attributes list cache failed. The cache has been disabled.';
	$lang['Cache_failed_themes'] = 'Themes table cache failed. The cache has been disabled.';
	$lang['Cache_failed_ranks'] = 'Ranks table cache failed. The cache has been disabled.';
	$lang['Cache_failed_words'] = 'Words censorship table cache failed. The cache has been disabled.';
	$lang['Cache_failed_smilies'] = 'Smilies table cache failed. The cache has been disabled.';
	$lang['Cache_failed_icons'] = 'Icons table cache failed. The cache has been disabled.';
	$lang['Cache_failed_cp_patches'] = 'Installed control panels patches table cache failed. The cache has been disabled.';
	$lang['Cache_failed_cp_panels'] = 'Control panels definitions table cache failed. The cache has been disabled.';

	$lang['Cache_succeed_langs'] = 'Lang cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_config'] = 'Config table cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_forums'] = 'Forums table cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_moderators'] = 'Moderators list cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_bots'] = 'Search engines crawlers list cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_topics_attr'] = 'Topic title attributes list cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_themes'] = 'Themes table cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_ranks'] = 'Ranks table cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_words'] = 'Words censorship table cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_smilies'] = 'Smilies table cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_icons'] = 'Icons table cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_cp_patches'] = 'Installed control panels patches table cache succeed. The cache has been enabled.';
	$lang['Cache_succeed_cp_panels'] = 'Control panels definitions table cache succeed. The cache has been enabled.';

	$lang['User_caches'] = 'User level caches';
	$lang['Cache_fauths'] = 'Forums access permissions cache';
	$lang['Cache_fjbox'] = 'Forums jumpbox cache';

	$lang['Board_stats_caches'] = 'Board statistics caches';
	$lang['Total_topics'] = 'Total topics';
	$lang['Last_user'] = 'Last registered user';
	$lang['Board_stats_sync'] = 'The board statistics caches have been synchronised.';

	$lang['Check_results'] = 'Check results';
	$lang['Cache_path_not_found'] = 'The cache directory was not found. The check has ended there, and the generic level caches has been disabled.';
	$lang['Cache_path_found'] = 'The cache directory was found.';
	$lang['Cache_create_unavailable'] = 'The creation of new caches is not available on your system.';
	$lang['Cache_filelist'] = 'Please upload empty files named: %s, and CHMOD them to 666. Unavailable caches has been for now disallowed.';
	$lang['Cache_sysfile_missing'] = 'The file "sys_tests.dta" dedicated to tests has not been found. Please upload it to your system and CHMOD it to 666. The check has ended there.';
	$lang['Cache_write_disabled'] = 'The script wasn\'t able to write onto the test file (%s). Please adjust the CHMOD for the file and/or the directory (it should be at least 644). The check has ended there, unavailable caches has been for now disallowed.';
	$lang['Cache_io_unavailable'] = 'The script wasn\'t able to write or read the test file (%s). Unavailable caches has been for now disallowed.';
	$lang['Cache_successfull'] = 'All tests has been passed successfully. You can use the table caches.';

	$lang['Cache_regenerated'] = 'The cache has been marked for regeneration.';
	$lang['Cache_setup_updated'] = 'The caches setup has been updated.';

	// message icon admin
	$lang['Icons_settings'] = 'Message icons';
	$lang['Icons_admin'] = 'Message icons management';
	$lang['Icons_admin_explain'] = 'Here you can edit, delete, create and re-order icons used in front of messages title.';
	$lang['Icons_create'] = 'Create a message icon';
	$lang['Icons_create_explain'] = 'Here you register a new icon for the messages.';
	$lang['Icons_edit'] = 'Edit a message icon';
	$lang['Icons_edit_explain'] = 'Here you can modify the message icon definition and priviledges.';
	$lang['Icons_delete'] = 'Delete a message icon';
	$lang['Icons_delete_explain'] = 'Here you can delete a message icon.';

	$lang['Icons_box'] = 'Sample of posting box';
	$lang['Icons_types'] = 'Default for';
	$lang['Icons_usage'] = 'Usage';
	$lang['No_icons_create'] = 'No icons are available for the messages. Please hit "Create" to add some.';

	$lang['Icon_not_exists'] = 'This icon does not exist';
	$lang['Click_return_iconsadmin'] = 'Click %sHere%s to return to Message icons administration.';

	$lang['Icon_name'] = 'Icon name';
	$lang['Icon_name_explain'] = 'You can use a lang entry key (check your language/lang_<i>your_language</i>/lang_*.php), or enter directly the icon name.';
	$lang['Icon_url'] = 'Icon URI';
	$lang['Icon_url_explain'] = 'Pick up an icon in the dropw down list.';
	$lang['Icon_auth'] = 'Authorisation required';
	$lang['Icon_auth_explain'] = 'Choose which authorisation will be required to use this icon.';
	$lang['Icon_types'] = 'Default for topic type';
	$lang['Icon_types_explain'] = 'Choose for which topic types this icon will be displayed when none has been choosen by the poster.';
	$lang['Icon_replace'] = 'Replace with icon';
	$lang['Icon_replace_explain'] = 'Choose an icon to replace in posts and topics the one to delete. Choose "None" to reset messages icons.';
	$lang['Icon_after'] = 'Move this icon after';

	$lang['Icon_created'] = 'The icon has been created.';
	$lang['Icon_edited'] = 'The icon has been edited.';
	$lang['Icon_deleted'] = 'The icon has been deleted.';

	$lang['Top'] = '___Top___';

	// topics attributes admin
	$lang['Topics_attr_settings'] = 'Topic title attributes';
	$lang['Topics_attr_admin'] = 'Topic title attributes management';
	$lang['Topics_attr_admin_explain'] = 'Here you can edit, delete, create and re-order text and icons used in front of topic titles.';
	$lang['Topics_attr_create'] = 'Create a topic title attribute';
	$lang['Topics_attr_create_explain'] = 'Here you register a new topic title attribute. You can use $lang entry keys for legends. Images will be picked up from the $images entries (Check templates/<i>your_template</i>/<i>your_template</i>.cfg).';
	$lang['Topics_attr_edit'] = 'Edit a topic title attribute';
	$lang['Topics_attr_edit_explain'] = 'Here you can modify the topic title attribute definition and priviledges. Images will be picked up from the $images entries (Check templates/<i>your_template</i>/<i>your_template</i>.cfg).';
	$lang['Topics_attr_delete'] = 'Delete a topics title attribute';
	$lang['Topics_attr_delete_explain'] = 'Here you can delete a topic title attribute.';

	$lang['Topics_attr_folder'] = 'Folder';
	$lang['Topics_attr_title'] = 'Title';
	$lang['Topics_attr_name'] = 'Attribute name';
	$lang['Topics_attr_name_explain'] = 'Set here the attribute name you want to see in the drop down lists.';
	$lang['Topics_attr_fname'] = 'Mouseover folder name';
	$lang['Topics_attr_fname_explain'] = 'Set here the name the folder image will have when the mouse will be over it.';
	$lang['Topics_attr_fimg'] = 'Folder image';
	$lang['Topics_attr_fimg_explain'] = 'This will be the folder image used when the condition will be fullfilled.';
	$lang['Topics_attr_tname'] = 'Tag';
	$lang['Topics_attr_tname_explain'] = 'This will be the tag used in front of the topic title.';
	$lang['Topics_attr_timg'] = 'Tag image';
	$lang['Topics_attr_timg_explain'] = 'If provided, the image will be displayed in place of the tag.';
	$lang['Topics_attr_field'] = 'Topics field to check';
	$lang['Topics_attr_field_explain'] = 'Set here the condition that will be used to check the topic title attribute.';
	$lang['Topics_attr_auth'] = 'Authorisation required';
	$lang['Topics_attr_auth_explain'] = 'Choose which authorisation will be required to use this topic attribute. This one is only use for the topic sub type.';

	$lang['Topics_attr_ttype'] = 'Topic type';
	$lang['Topics_attr_tsubtype'] = 'Topic sub type';
	$lang['Topics_attr_tmoved'] = 'Shadow topic';
	$lang['Topics_attr_tstatus'] = 'Topic is locked';
	$lang['Topics_attr_tvote'] = 'Topic has a poll';
	$lang['Topics_attr_tattach'] = 'Topic has an attached file';
	$lang['Topics_attr_tcalendar'] = 'Topic is a calendar event';

	$lang['Topics_attr_after'] = 'Folder image priority is just less than';
	$lang['Topics_attr_replace'] = 'Replace with attribute';
	$lang['Topics_attr_replace_explain'] = 'Choose a sub type to replace in topics the one to delete. Choose "None" to reset this sub type in topic using it.';

	$lang['Topics_attr_not_exists'] = 'This topic title attribute does not exist.';
	$lang['Topics_attr_created'] = 'The topic title attribute has been created.';
	$lang['Topics_attr_edited'] = 'The topic title attribute has been edited.';
	$lang['Topics_attr_deleted'] = 'The topic title attribute has been deleted.';

	$lang['Click_return_topics_attr_admin'] = 'Click %sHere%s to return to Topic title attributes administration.';

	// styles management
	$lang['Submit_styles'] = 'Submit style';
	$lang['Images_pack'] = 'Images pack';
	$lang['Images_pack_explain'] = 'Enter here the <i>template</i>.cfg file where stands the images definition you want to use (ie.: <i>subSilver/subSilver.cfg</i>).<br />Leave it blank to use the template images pack.';
	$lang['Custom_tpls'] = 'Customised template files directory';
	$lang['Custom_tpls_explain'] = 'Enter here the directory where can be found the customised .tpl files you want to use (ie if the customised .tpl files are located in <i>templates/subSilver/customs</i>, enter <i>customs</i>).<br />Leave it blank if you don\'t use customised tpls.';
	$lang['Stylesheet_explain'] = 'Filename for CSS stylesheet to use for this theme.';
	$lang['Images_pack_not_found'] = 'The images pack you entered has not be found.';
	$lang['Custom_tpls_not_found'] = 'The customised template files directory has not be found.';
	$lang['Head_stylesheet_not_found'] = 'The CSS stylesheet can not be found.';
	$lang['Style_private'] = 'Private style';
	$lang['Style_private_explain'] = 'By checking this, the style will be only choosable from the Administration Control Panel.';

	// groups management
	$lang['Group_style'] = 'Group style';
	$lang['Group_style_explain'] = 'If you set a specific style for this group, all the members will use only this style, whatever the settings are.';

	// panels
	$lang['Admin_control_panel'] = 'Administration control panel';
	$lang['User_control_panel'] = 'User control panel';
	$lang['Group_control_panel'] = 'Group control panel';

	// config
	$lang['Enabled'] = 'Enabled';
	$lang['Disabled'] = 'Disabled';

	$lang['Config_updated'] = 'The configuration has been updated successfully.';

	$lang['Click_return_server'] = 'Click %sHere%s to return to Server settings.';
	$lang['Click_return_i18n'] = 'Click %sHere%s to return to Internationalisation settings.';
	$lang['Click_return_layout'] = 'Click %sHere%s to return to Board layout settings.';
	$lang['Click_return_topicopt'] = 'Click %sHere%s to return to Topics options.';
	$lang['Click_return_msgopt'] = 'Click %sHere%s to return to Messages options.';
	$lang['Click_return_logset'] = 'Click %sHere%s to return to Login settings.';
	$lang['Click_return_email'] = 'Click %sHere%s to return to E-mail settings.';
	$lang['Click_return_privmsg'] = 'Click %sHere%s to return to Private messages settings.';
	$lang['Click_return_avatar'] = 'Click %sHere%s to return to Avatar settings.';

	$lang['Server_settings'] = 'Server settings';
	$lang['Board_url_settings'] = 'Board url settings';
	$lang['Board_url_settings_explain'] = '<div align="left">This details the components of your board url: http[<b>s</b> <i>if Server secure enabled</i>]://<b>Server name</b>[:<b>Server port</b> <i>if not equal to 80</i>]<b>Script path</b><hr /><u>Example</u>: if http://www.my_domain.com/my_phpBB/ is your board url:<br /><br />&nbsp;&bull; <b>Server secure:</b> Disabled<br />&nbsp;&bull; <b>Domain name</b>: www.my_domain.com<br />&nbsp;&bull; <b>Server port</b>: 80<br />&nbsp;&bull; <b>Script path</b>: /my_phpBB/</div>';
	$lang['Cookie_settings_explain'] = '<div align="left">This details how cookies are sent to your user\'s browsers.<hr /><u>Example</u>: if http://www.my_domain.com/my_phpBB/ is your board url:<br /><br />&nbsp;&bull; <b>Cookie domain</b>: .my_domain.com <i>(note the dot in front)</i><br />&nbsp;&bull; <b>Cookie name</b>: phpbb2mysql <i>(prefer a different name to prevent comflict, ie board, phpbb, forum, etc.)</i><br />&nbsp;&bull; <b>Cookie path</b>: / <i>(always)</i></div>';
	$lang['System_settings'] = 'System settings';
	$lang['Root_settings'] = 'Index settings';
	$lang['Index_settings'] = 'Forums lists';
	$lang['Forums_settings'] = 'Topics lists';
	$lang['Topics_options'] = 'Topics options';
	$lang['Messages_options'] = 'Messages options';
	$lang['Email_settings'] = 'E-mail settings';
	$lang['Login_settings'] = 'Login settings';
	$lang['SMTP_settings'] = 'SMTP settings';

	$lang['Server_secure'] = 'Server secure';
	$lang['Server_secure_explain'] = 'If your server is running via SSL (https://...), set this to enabled, else leave as disabled';
	$lang['Keep_unreads_explain'] = 'Choose "Yes" to keep the unread flags in a cookie, "in database" to keep them in the user profile.';
	$lang['Keep_unreads_in_db'] = 'Saved in database';
	$lang['Keep_unreads_guests'] = 'Keep unread messages for guests';
	$lang['Keep_unreads_guests_explain'] = 'Choosing "Yes", the unread flags will be kept for guests in a cookie if "Keep unread" is activated.';
	$lang['Icons_path'] = 'Messages icons path';
	$lang['Icons_path_explain'] = 'Default value is "images/icons/".';
	$lang['Default_duration'] = 'Announcements default duration';
	$lang['Default_duration_explain'] = 'Default duration proposed while writing an announcement.';
	$lang['Site_fav_icon'] = 'Site favorite icon';
	$lang['Site_fav_icon_explain'] = 'This icon is the one appearing in front of the site name of your browser bookmarks. It has to be a .ico file, 16x16 pixels.';
	$lang['Pagination_min'] = 'Minimum number of pages in pagination';
	$lang['Pagination_max'] = 'Maximum number of pages in pagination';
	$lang['Pagination_percent'] = 'Percentage of pages in pagination';
	$lang['Fulltext_index'] = 'Fulltext indexation for search';
	$lang['Fulltext_index_explain'] = 'Setting this to "Yes", a fulltext index will be built on posts text table, and the regular phpBB table for search will be cleared. If you want to get back to "No", don\'t forget to use the "Search rebuild" option.';

	$lang['Bytes'] = 'Bytes';
	$lang['Visual_confirm_post'] = 'Enable Visual Confirmation for guests while posting';
	$lang['Visual_confirm_post_explain'] = 'Requires guests enter a code defined by an image when creating a post or a topic.';
	$lang['Guests_proxies_disabled'] = 'Disable posting for guests using anonymous proxies';
	$lang['Guests_proxies_disabled_explain'] = 'Prevent guests who have an ip not solvable into a host name to post or reply. They can still register though.';
	$lang['Posting_controls'] = 'Posting controls';
	$lang['Posting_max_guests'] = 'Number of guests posting at the same time allowed';
	$lang['Posting_max_guests_explain'] = 'Set here the number of guests posting allowed during the timeframe below. Set it to 0 to ignore this setting.';
	$lang['Posting_time_guests'] = 'Timeframe limit for guests posting';
	$lang['Posting_time_guests_explain'] = 'Set here the duration used (in seconds) to check the guests posting. Set it to 0 to ignore this setting.';

	$lang['Forum_rules'] = 'Board rules topic';
	$lang['Forum_rules_explain'] = 'Enter here the topic id where stands your board rules. Leave it empty to use the default rules text.';
	$lang['COPPA_required'] = 'Use COPPA';
	$lang['Password_mini'] = 'Password minimal length';
	$lang['Password_mini_explain'] = 'Minimal number of chars the user password must have. Default value is 5.';

	// sub-title
	$lang['Topic_title_length'] = 'Title length of the topic title on index';
	$lang['Topic_title_length_explain'] = 'Set the number of chars you want to display for the topic title on index.';
	$lang['Sub_title_length'] = 'Title length of the sub-title (description) on index';
	$lang['Sub_title_length_explain'] = 'Set the number of chars you want to display for the sub-title (description) on index. Set it to 0 if you doesn\'t want to use the sub-title on the board.';

	// versions check
	$lang['App_author'] = 'Author';
	$lang['App_name'] = 'Application name';
	$lang['App_desc'] = 'Description';
	$lang['App_site'] = 'Site';
	$lang['App_current'] = 'Version currently installed';
	$lang['App_stable'] = 'Last stable version';
	$lang['App_in_dev'] = 'Last dev. version';
	$lang['App_check'] = 'Check for latest versions';

	$lang['App_status'] = 'Status';
	$lang['App_unknown_status'] = 'Unknown status : hit "Check" to attempt to read the current status.';
	$lang['App_stable_status'] = 'This application is up to date with the latest stable version.';
	$lang['App_in_dev_status'] = 'You are using the latest development version available : be sure to follow the updates and fixes.';
	$lang['App_obsolet_status'] = 'You are using an older version : please upgrade this application to at least the latest stable release.';
	$lang['App_undefined_status'] = 'You are using an un-identified development version. Check the application page for the latest.';

	$lang['App_socket_error'] = 'Unable to open connection to the server, reported error is:<br />%s';

	// bots management
	$lang['Bots_management_explain'] = 'Here you can add, edit or delete search engines bot-crawlers definitions.';
	$lang['Bots_edit'] = 'Edit a bot';
	$lang['Bots_edit_explain'] = 'Here you can edit the bots signature and name.';
	$lang['Bots_delete'] = 'Delete a bot';
	$lang['Bots_delete_explain'] = 'Validating this form, you will delete this bot definition.';
	$lang['Bots_create'] = 'Add a new bot';
	$lang['Bots_create_explain'] = 'Here you are adding a new bot definition.';

	$lang['Bot_name'] = 'Bot name';
	$lang['Bot_name_explain'] = 'Enter a short name to identify this bot.';
	$lang['Bot_agent'] = 'Bot agent';
	$lang['Bot_agent_explain'] = 'Enter the fragment of USER_AGENT allowing to identify this bot. If the identification is not based on USER_AGENT, leave this field empty.';
	$lang['Bot_ips'] = 'Bot IPs';
	$lang['Bot_ips_explain'] = 'Enter the IPs or part of IPs identifying this bot, separated with comma. If the identification is not based on IPs, leave this field empty.';

	$lang['No_bots_create'] = 'There are currently no search engines bot-crawlers definitions. Please press "Create" to create a new one.';
	$lang['Click_return_bots_management'] = 'Click %sHere%s to return to bots list.';
	$lang['Bot_not_exists'] = 'The bot you are attempting to edit does not exist.';
	$lang['Bot_name_adjusted'] = 'The bot name has been adjusted to use only alphabetical chars. Please verify if the name is still appropriate and validate.';
	$lang['Bot_name_short'] = 'The bot name is too short.';
	$lang['Bot_ips_adjusted'] = 'The bot IPs have been adjusted. Please verify them and validate.';
	$lang['Bot_agent_or_ips'] = 'Please provide Bot IPs and/or Bot agent.';
	$lang['Bot_name_exists'] = 'This bot name is already taken by a user or another bot.';
	$lang['Bot_created'] = 'The new bot-crawler has been added.';
	$lang['Bot_edited'] = 'The bot-crawler has been edited.';
	$lang['Bot_deleted'] = 'The bot-crawler has been deleted.';

	// search rebuild
	$lang['Search_rebuild'] = 'Rebuild search';
	$lang['Search_rebuild_title'] = 'Rebuild search engine indexes';
	$lang['Search_rebuild_title_explain'] = 'This tool allows you to rebuild the search tables, used by the phpBB search engine.';
	$lang['Search_rebuild_confirm'] = 'Read carefully, then confirm.';
	$lang['Search_rebuild_text'] = '<b>This process will be very long</b> (expect one hour per 30k posts), and will put a high load onto your SQL server. <br />Before proceeding, don\'t forget to warn your hoster about it.<br /><br /><br /><b>Don\'t close this window until you receive the achievement message</b> : <br />if you loose your connection or close accidentaly the window, you will have to relaunch the whole process.<br /><br /><hr /><b>Number of posts to proceed:</b> %d<hr /><br /><br />If you are ok to proceed, press "Submit".';
	$lang['Search_rebuild_achieve'] = 'Achievement message';
	$lang['Search_rebuild_achieve_text'] = 'The search tables have been entirely rebuild, and the procees is achieved.<br /><hr /><br />%d posts have been proceed in %s.<br /><br /><br />';
	$lang['Search_rebuild_progress'] = 'Progression';
	$lang['Search_rebuild_processed'] = 'Processed posts : %d/%d in %s';
	$lang['Search_rebuild_elapse'] = '%dH %dm %ds';

	// admin_auth, admin_icons, admin_topics_attr
	$lang['No_valid_action'] = 'The action you are trying to perform is not supported.';

	// admin_user
	$lang['User_delete_deny'] = 'You are not allowed to delete this user.';

	// acp_caches
	$lang['Past_guests'] = 'Guests visits count';

	// admin_settings
	$lang['Stats_display_past'] = 'Display visits historic on index';

	// admin_topics_attr
	// operand
	$lang['Less'] = 'Less than';
	$lang['Less_equal'] = 'Less or Equal to';
	$lang['Equal'] = 'Equal to';
	$lang['Greater_equal'] = 'Greater or Equal to';
	$lang['Greater'] = 'Greater than';
	$lang['Not_equal'] = 'Not equal to';

	// admin/index
	$lang['IP_Address'] = 'IP Address';

	// admin/admin_users
	$lang['Only_one_avatar'] = 'Only one type of avatar can be specified';

	// search flood control
	$lang['Click_return_searchopt'] = 'Click %sHere%s to return to Search options.';
	$lang['Search_max_concur'] = 'Number of concurrent search allowed';
	$lang['Search_max_concur_explain'] = 'Set here the number of searches on keywords allowed during the timeframe below. Set it to 0 to ignore this setting.';
	$lang['Search_time_concur'] = 'Timeframe limit for concurrent searches';
	$lang['Search_time_concur_explain'] = 'Set here the duration used (in seconds) to check the concurrent searches on keywords. Set it to 0 to ignore this setting.';
}

//
// lang_main
//

// search username
$lang['Select_username'] = 'Select a Username';

// debug
$lang['dbg_line'] = 'Line: %s';
$lang['dbg_file'] = 'File: %s';
$lang['dbg_empty'] = 'Empty';
$lang['dbg_backtrace'] = 'Back trace';
$lang['dbg_requester'] = 'Requester';

// access key commands (keyboard shortcuts)
$lang['cmd_submit'] = 's';
$lang['cmd_select'] = 's';
$lang['cmd_delete'] = 'x';
$lang['cmd_edit'] = 'e';
$lang['cmd_create'] = 'c';
$lang['cmd_add'] = 'd';
$lang['cmd_cancel'] = 'a';
$lang['cmd_synchro'] = 'y';
$lang['cmd_add_group'] = 'g';
$lang['cmd_regen'] = 'r';
$lang['cmd_preview'] = 'p';
$lang['cmd_up'] = '-';
$lang['cmd_down'] = '+';
$lang['cmd_export'] = 'o';

// functions_selects
$lang['Default'] = 'Default';

// tree drawing (functions_admin, class_tree & class_tree_admin)
$lang['tree_pic_' . TREE_HSPACE] = '&nbsp;&nbsp;&nbsp;&nbsp;';
$lang['tree_pic_' . TREE_VSPACE] = '|&nbsp;&nbsp;&nbsp;';
$lang['tree_pic_' . TREE_CROSS] = '|___';
$lang['tree_pic_' . TREE_CLOSE] = '|___';

// class_user
$lang['Today'] = 'Today';
$lang['Yesterday'] = 'Yesterday';
$lang['Today_at'] = 'Today, at %s';
$lang['Yesterday_at'] = 'Yesterday, at %s';
$lang['UTC_DST'] = 'UTC %s %s (DST in action)';
$lang['UTC'] = 'UTC %s %s';

// critical error (functions)
$lang['Under_maintenance_title'] = 'Under maintenance';
$lang['Under_maintenance'] = 'The site is currently under maintenance.<br />Sorry for the inconvenience, please retry later.';

// system groups
$lang['Board_founder'] = 'Main administrators';
$lang['Board_founder_desc'] = 'Main administrators';
$lang['Group_admin'] = 'Administrators';
$lang['Group_admin_desc'] = 'Users having the permissions to administrate the board';
$lang['Group_anonymous'] = 'Guests';
$lang['Group_anonymous_desc'] = 'Not registered users';
$lang['Group_registered'] = 'Registered users';
$lang['Group_registered_desc'] = 'All registered users';
$lang['Group_bots'] = 'Bots';
$lang['Group_bots_desc'] = 'Search engines crawlers';

// standard size units
$lang['Bytes'] = 'Bytes';
$lang['KB'] = 'KB';
$lang['MB'] = 'MB';

// front title
if ( !$is ||$is['admin'] || $is['class_topics'] || $is['class_posts'] )
{
	$lang['Announce_ends'] = 'Announcement end: %s';
	$lang['Sub_title'] = 'Subject description';

	// topic attribute
	$lang['Own_topic'] = 'You have posted in this topic';
	$lang['Poll'] = 'Poll';

	// topic folder icon
	$lang['Topic_Global_Announcement'] = 'Global announcement';
	$lang['Topic_Announcement'] = 'Announcement';
	$lang['Topic_Sticky'] = 'Sticky';
	$lang['Topic_Poll'] = 'Poll';
	$lang['Topic_Locked'] = 'Locked';
	$lang['Topic_Moved'] = 'Moved';
	$lang['Topic_calendar'] = 'Event';
	$lang['Topic_Attached'] = 'Attachment';

	// topic tags
	$lang['Post_Global_Announcement'] = 'Global announcement';

	// topic icons
	$lang['Message_icon'] = 'Message icons';
	$lang['No_icon'] = 'No icon';
	$lang['icon_none'] = 'No icon';
	$lang['icon_note'] = 'Note';
	$lang['icon_important'] = 'Important';
	$lang['icon_idea'] = 'Idea';
	$lang['icon_warning'] = 'Warning !';
	$lang['icon_question'] = 'Question';
	$lang['icon_cool'] = 'Cool';
	$lang['icon_funny'] = 'Funny';
	$lang['icon_angry'] = 'Grrrr !';
	$lang['icon_sad'] = 'Snif !';
	$lang['icon_mocker'] = 'Hehehe !';
	$lang['icon_shocked'] = 'Oooh !';
	$lang['icon_complicity'] = 'Complicity';
	$lang['icon_bad'] = 'Bad !';
	$lang['icon_great'] = 'Great !';
	$lang['icon_disgusting'] = 'Beark !';
	$lang['icon_winner'] = 'Gniark !';
	$lang['icon_impressed'] = 'Oh yes !';
	$lang['icon_roleplay'] = 'Roleplay';
	$lang['icon_fight'] = 'Fight';
	$lang['icon_loot'] = 'Loot';
	$lang['icon_picture'] = 'Picture';
	$lang['icon_calendar'] = 'Calendar event';
}

// class_run_stats
if ( !$is || $is['admin'] || $is['class_run_stats'] )
{
	$lang['Stat_explain_failed'] = 'Could not EXPLAIN this SQL request : it is probably not valid.';
	$lang['Stat_surround'] = '[ %s ]';
	$lang['Stat_sep'] = ' - ';
	$lang['Stat_page_duration'] = 'Time: %.4fs';
	$lang['Stat_local_duration'] = 'local trace: %.4fs';
	$lang['Stat_memory'] = 'Memory: %d K';
	$lang['Stat_part_php'] = 'PHP: %.2d%%';
	$lang['Stat_part_sql'] = 'SQL: %.2d%%';
	$lang['Stat_queries_total'] = 'Queries: %2d (%.4fs)';
	$lang['Stat_queries_db'] = 'db: %2d (%.4fs)';
	$lang['Stat_queries_cache'] = 'cache: %2d (%.4fs/%.4fs)';
	$lang['Stat_gzip_enable'] = 'GZIP on';
	$lang['Stat_debug_enable'] = 'Debug on';
	$lang['Stat_request'] = 'Request';
	$lang['Stat_line'] = 'Line:&nbsp;%d';
	$lang['Stat_cache'] = 'cache:&nbsp;%.4fs';
	$lang['Stat_db'] = 'db:&nbsp;%.4fs';
	$lang['Stat_table'] = 'Table';
	$lang['Stat_type'] = 'Type';
	$lang['Stat_possible_keys'] = 'Possible keys';
	$lang['Stat_key'] = 'Used key';
	$lang['Stat_key_len'] = 'Key length';
	$lang['Stat_ref'] = 'Ref.';
	$lang['Stat_rows'] = 'Rows';
	$lang['Stat_Extra'] = 'Comment';
	$lang['Stat_Comment'] = 'Comment';
	$lang['Stat_id'] = 'Id';
	$lang['Stat_select_type'] = 'Select type';
	$lang['Stat_backtrace'] = 'Backtrace required';
}

//
// forums & topics list display (index, modcp, class_topics)
//
// class_forums/class_topics
if ( !$is || $is['admin'] || $is['class_topics'] )
{
	$lang['View_group'] = 'View group informations';
	$lang['Subforums'] = 'Sub-forums';
	$lang['Auth_read_required'] = 'Only users granted special access can access topics in this forum.';
	$lang['Registration_required'] = 'You must register to access topics in this forum.';
	$lang['Category'] = 'Category';
	$lang['Link'] = 'Link';
	$lang['Forum_link_visited'] = 'This link has been visited %d times <br />since %s';

	$lang['Important_topics'] = 'Important topics';
	$lang['Global_Announces'] = 'Global Announcements';
	$lang['Announces'] = 'Announcements';
	$lang['Stickies'] = 'Stickies';

	$lang['First_Post'] = 'First Post';
	$lang['No_topics'] = 'There are no posts in this forum.';
	$lang['Topics_count'] = '[%d Topics]';
	$lang['Topics_count_1'] = '[%d Topic]';
	$lang['Board_announces'] = 'Board Announcements';
	$lang['Sort_topic_status'] = 'Topic Status';
}

//
// posts : viewtopic, class_posts
//
// class_posts
if ( !$is || $is['admin'] || $is['class_posts'] )
{
	$lang['Post_unmark_read'] = 'Mark this post and the followings unread';
	$lang['No_posts_match'] = 'No posts match your search criteria.';
	$lang['Posts_count'] = '[%d Posts]';
	$lang['Posts_count_1'] = '[%d Post]';
}

//
// form : class_fields, class_cp, usercp, ucp_fields...
//
if ( !$is || $is['admin'] || $is['class_fields'] )
{
	$lang['empty_error'] = 'the value must be filled.';
	$lang['length_mini_error'] = 'the value is too short.';
	$lang['length_maxi_error'] = 'the value is too long.';
	$lang['value_mini_error'] = 'the value must be greater.';
	$lang['value_maxi_error'] = 'the value must be lower.';
	$lang['options_error'] = 'the value choosen is not available in the list.';
	$lang['options_empty_error'] = 'no value available for this field.';
	$lang['url_error'] = 'this is not a valid url.';
	$lang['Date_not_valid'] = 'This is not a valid date';
	$lang['Not_a_valid_directory'] = 'This is not a valid directory';
	$lang['Not_a_valid_script'] = 'This is not a valid script';
	$lang['No_options'] = 'No options available.';
}

// class_stat
if ( !$is || $is['admin'] || $is['class_stats'] )
{
	$lang['Legend'] = 'Legend';
	$lang['Administrator'] = 'Administrator';
	$lang['User'] = 'User';
	$lang['Bot'] = 'Bot';

	$lang['Past_users_zero_total'] = 'There have been <b>0</b> users online since yesterday :: ';
	$lang['Past_user_total'] = 'There has been <b>%d</b> user online since yesterday :: ';
	$lang['Past_users_total'] = 'There have been <b>%d</b> users online since yesterday :: ';
	$lang['Past_visits'] = '(%s since yesterday)';

	$lang['Hour_users_zero_total'] = 'There have been <b>0</b> users online within the current hour :: ';
	$lang['Hour_user_total'] = 'There has been <b>%d</b> user online within the current hour :: ';
	$lang['Hour_users_total'] = 'There have been <b>%d</b> users online within the current hour :: ';
	$lang['Hour_visits'] = '(%s within the current hour)';

	$lang['Newest_user'] = 'The newest registered user is ';
}

//
// main scripts
//

// index
if ( !$is || $is['admin'] || $is['index'] )
{
	$lang['Cat_no_subs'] = 'This category has no sub-forums.';
	$lang['Click_return_parent'] = 'Click %sHere%s to return to the parent forum.';
	$lang['Hot_topic'] = 'Popular';
}

// viewtopic
if ( !$is || $is['admin'] || $is['viewtopic'] )
{
	$lang['Topic_unmarked_read'] = 'The topic has been marked unread';
	$lang['Topic_unmark_read'] = 'Mark the topic unread';
}

// posting
if ( !$is || $is['admin'] || $is['posting'] || $is['modcp'] )
{
	$lang['Move_to_forum_error'] = 'The target forum you choose is a category or a link, so can not contain topics.';
	$lang['Topic_duration'] = 'Announcement ending date';
	$lang['Topic_duration_explain'] = 'This is the date an announcement will stop to appear in other forums as a global announcement or a board announcement.';
	$lang['Topic_duration_special'] = 'Choose "Never displayed" to never show this announcement elsewhere than in its own forum. <br />Choose "Always displayed" to display it forever.';
	$lang['Never_displayed'] = 'Never displayed';
	$lang['Always_displayed'] = 'Always displayed';
	$lang['New_post_meanwhile_reply'] = 'A new reply has been posted or the last post has been deleted while you were replying. Check the "Topic review" at bottom of this page, and resubmit your post if appropriate.';
	$lang['New_post_meanwhile_edit'] = 'A new reply has been posted or the last post has been deleted while you were editing.';
	$lang['Topic_sub_type'] = 'Add a tag to the title';
	$lang['Too_many_attempts'] = 'You have exceeded the number of posting attempts for this session. Please try again later.';
	$lang['Too_many_connections'] = 'Too many connections: hit the browser back button and retry.';
}

// search
if ( !$is || $is['admin'] || $is['search'] )
{
	$lang['Search_in_forum'] = 'Search in forum';
	$lang['Search_no_subs'] = 'Do not include sub-forums in the search scope';
	$lang['Search_title_msg'] = 'Search post title and message text';
	$lang['Search_msg_only'] = 'Search message text only';
	$lang['Search_title_only'] = 'Search post title only';
}

// privmsg
if ( !$is || $is['admin'] || $is['privmsg'] )
{
	$lang['Pms_count'] = '[%d messages]';
	$lang['Pms_count_1'] = '[%d message]';
}

// memberlists : groupcp, memberlist
if ( !$is || $is['admin'] || $is['groupcp'] || $is['memberlist'] )
{
	$lang['Users_count'] = '[%d Users]';
	$lang['Users_count_1'] = '[%d User]';
}
if ( !$is || $is['memberlist'] )
{
	$lang['Add_inactive_users'] = 'Select inactive users';
	$lang['Active_users'] = 'Active users';
	$lang['Inactive_users'] = 'Inactive users';
}
if ( !$is || $is['admin'] || $is['groupcp'] )
{
	$lang['No_such_group'] = 'This group does not exist';
	$lang['Change_sysgroup_type_denied'] = 'This group has to be at least closed';
	$lang['Manage_group_denied'] = 'You are not authorised to modify this group definition.';
}

// viewonline
if ( !$is || $is['admin'] || $is['viewonline'] )
{
	$lang['Viewing_groups'] = 'Viewing groups';
}

?>