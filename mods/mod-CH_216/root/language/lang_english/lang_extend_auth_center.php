<?php
//
//	file: language/lang_english/lang_extend_auth_center.php
//	author: ptirhiik
//	begin: 26/10/2004
//	version: 1.6.0 - 10/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// admin part
if ( $is['admin'] )
{
	$lang['Lang_extend_auth_center'] = 'Permissions Center';

	// special groups
	$lang['Group_own'] = 'Own user';
	$lang['Group_own_desc'] = 'User acting on his profile';

	// complementary for group management
	$lang['Board_founder_explain'] = 'Note : the Main administrators group doesn\'t require any permissions to be set : it has already all authorised.';
	$lang['Delete_sysgroup_denied'] = 'You can not delete a system group';
	$lang['Change_sysgroup_denied'] = 'You can not change the system status of this group.';
	$lang['Unknown_group_sysstatus'] = 'Unknown system status';
	$lang['System_group'] = 'System group';

	// main panel name
	$lang['Panels_index'] = 'Panels index';
	$lang['phpbb_acp'] = 'phpBB Administration Panel';

	// direct entry for the menu
	$lang['Auths_Center'] = 'Auths Center';
	$lang['Control_panels'] = 'Control panels';
	$lang['10_Permissions_manager'] = 'Permissions/Manager';
	$lang['11_Permissions_managed'] = 'Permissions/Managed';

	// auth values
	$lang['Auth_not_authorised'] = ' -- ';
	$lang['Auth_authorised'] = 'Authorised';
	$lang['Auth_denied'] = 'Denied even if authorised';
	$lang['Auth_forced'] = 'Authorised even if denied';

	// forums auths list
	$lang['auth_view'] = 'View forum';
	$lang['auth_read'] = 'Read topics';
	$lang['auth_post'] = 'Create new topics';
	$lang['auth_reply'] = 'Reply to existing topics';
	$lang['auth_edit'] = 'Edit own posts';
	$lang['auth_delete'] = 'Delete own posts';
	$lang['auth_sticky'] = 'Create stickies';
	$lang['auth_announce'] = 'Create announcements';
	$lang['auth_global_announce'] = 'Create global announcement';
	$lang['auth_vote'] = 'Vote';
	$lang['auth_pollcreate'] = 'Create new polls';
	$lang['auth_mod'] = 'Can moderate the forum';
	$lang['auth_mod_display'] = 'Is displayed as a forum moderator';
	$lang['auth_attachments'] = 'Post Files';
	$lang['auth_download'] = 'Download Files';
	$lang['auth_manage'] = 'Can administrate';

	// panels auths list
	$lang['Access'] = 'Access the panel';

	// groups auths list
	$lang['ucp_edit_profile'] = 'Can edit profile';
	$lang['ucp_edit_privacy'] = 'Can edit privacy informations';
	$lang['ucp_edit_i18n'] = 'Can edit internationalisation options';
	$lang['ucp_edit_posting'] = 'Can edit posting options';
	$lang['ucp_edit_topicread'] = 'Can edit topic read options';
	$lang['ucp_edit_layout'] = 'Can edit board layout preferences options';

	// presets
	$lang['Auths_presets'] = 'Authorisations presets';
	$lang['Presets_not_found'] = 'Preset not found';
	$lang['Preset_name'] = 'Preset name';
	$lang['Preset_name_explain'] = 'Hitting export : if you use an existing name, the preset with this name will be updated ; if authorisations match an existing preset, the name of this preset will be updated ; in other cases, the preset will be created.';
	$lang['Export_preset'] = 'Export into a preset';
	$lang['Delete_preset'] = 'Delete this preset';
	$lang['Preset_changed'] = 'This authorisations set matches another preset : please verify the preset name and confirm you action.';
	$lang['Preset_name_empty'] = 'You must enter a preset name in order to achieve this action.';
	$lang['Preset_name_exists'] = 'This preset name is already used for another preset.';
	$lang['Preset_created'] = 'Preset created.';
	$lang['Preset_updated'] = 'Preset updated.';
	$lang['Preset_deleted'] = 'Preset deleted.';
	$lang['Submit_presets'] = 'Submit presets';

	// presets name
	$lang['Custom'] = 'Custom';
	$lang['None'] = ' -- none -- ';

	// forums
	$lang['Preset_read_post_vote'] = 'Read, post and vote';
	$lang['Preset_read_only'] = 'Read only';
	$lang['Preset_moderator'] = 'Moderate';
	$lang['Preset_moderator_hidden'] = 'Moderate (hidden)';
	$lang['Preset_admin'] = 'Administrate';
	$lang['Preset_guest_posting'] = 'Guest post and reply';

	// panels
	$lang['Preset_access'] = 'Access';

	// groups
	$lang['Preset_view'] = 'View';
	$lang['Preset_edit_denied'] = 'Edit denied';
	$lang['Preset_edit_public'] = 'Edit public informations';
	$lang['Preset_edit_own'] = 'Edit own profile';

	// generic return message
	$lang['Click_return_auths'] = 'Click %sHere%s to return to permissions';
	$lang['No_objects'] = 'No object managed';

	// group selection
	$lang['Select_source_groups'] = 'Select a manager (User or Group)';
	$lang['Select_source_groups_explain'] = 'Select the group or the user you want to grant permissions to.';
	$lang['Select_target_groups'] = 'Select a user or a group to manage';
	$lang['Select_target_groups_explain'] = 'Select the group or the user you want to set permissions on.';

	// forum selection
	$lang['Click_return_select_forums'] = 'Click %sHere%s to return to forums selection.';
	$lang['Select_target_forums'] = 'Select a forum';
	$lang['Select_target_forums_explain'] = 'Select the forum you want to give access to.';

	// panel selection
	$lang['Select_panels'] = 'Select a panel';
	$lang['Click_return_select_panels'] = 'Click %sHere%s to return to panels selection.';
	$lang['Select_target_panels'] = 'Select a panel';
	$lang['Select_target_panels_explain'] = 'Select the panel you want to give access to.';
	$lang['Panel_name'] = 'Name';
	$lang['Panel_shortcut'] = 'Shortcut';

	// auth type & direction selection
	$lang['Auth_center'] = 'Permissions Center';
	$lang['Auth_center_explain'] = 'Here you will be able to edit permissions used by the board.';
	$lang['Click_return_auth_center'] = 'Click %sHere%s to return to Permissions Center';

	$lang['Select_auth_type_dir'] = 'Select Permission type and action';
	$lang['Auth_type'] = 'Permission type';
	$lang['Forum_auth_type'] = 'Forum';
	$lang['Panel_auth_type'] = 'Control panel';
	$lang['Group_auth_type'] = 'User or Group';

	$lang['Auth_direction'] = 'See permissions per';
	$lang['Manager'] = 'Manager (User or group)';
	$lang['Object_managed'] = 'Object managed (%s)';

	// overviews
	$lang['Panels_managed'] = 'Control panels managed';
	$lang['Forums_managed'] = 'Forums managed';
	$lang['Group_managed'] = 'User or Group Managed';
	$lang['Group_manager'] = 'User or Group Manager';
	$lang['No_groups'] = 'No groups or users have been choosen. Please click Add to add one.';
	$lang['Add_group'] = 'Add a new group or user';
	$lang['Usergroup_members_legend'] = '<b>Legend:</b>&nbsp;<b>name</b> = this group has permissions';
	$lang['Group_members_legend'] = '<b>Legend:</b>&nbsp;<b>name</b> = this user has individual permissions';

	// forums overview
	$lang['Click_return_overviewforums'] = 'Click %sHere%s to return to the forums overview.';
	$lang['Overview_forums'] = 'Forums overview (per User or Group manager)';
	$lang['Overview_forums_explain'] = 'Here you can set permissions to the forums';
	$lang['Please_confirm'] = 'Please verify the inputs, then confirm your action';

	// panels overview
	$lang['Click_return_overviewpanels'] = 'Click %sHere%s to return to the panels overview.';
	$lang['Overview_panels'] = 'Panels overview (per User or Group manager)';
	$lang['Overview_panels_explain'] = 'Here you can set permissions to the panels';

	// groups overview
	$lang['Click_return_overviewgroups'] = 'Click %sHere%s to return to the groups overview.';
	$lang['Overview_groups'] = 'Groups overview (per User or Group manager)';
	$lang['Overview_groups_explain'] = 'Here you can set permissions to the groups';

	// forums reversed overviewed
	$lang['Click_return_overviewforums_rev'] = 'Click %sHere%s to return to the forums reversed overview.';
	$lang['Overview_rev_forums'] = 'Forums reversed overview (per forum managed)';
	$lang['Overview_rev_forums_explain'] = 'Here you can manage the permissions of all the groups manager for the forum choosen.';

	// panels reversed overviewed
	$lang['Click_return_overviewpanels_rev'] = 'Click %sHere%s to return to the panels reversed overview.';
	$lang['Overview_rev_panels'] = 'Panels reversed overview (per panel managed)';
	$lang['Overview_rev_panels_explain'] = 'Here you can manage the permissions of all the groups for the panel choosen.';

	// groups reversed overviewed
	$lang['Click_return_overviewgroups_rev'] = 'Click %sHere%s to return to the groups reversed overview.';
	$lang['Overview_rev_groups'] = 'Groups reversed overview (per User or Group managed)';
	$lang['Overview_rev_groups_explain'] = 'Here you can manage the permissions of all the groups manager for the group choosen.';

	// edit forum auths details
	$lang['Click_return_edit_auth_forums'] = 'Click %sHere%s to return to the forum permissions edition.';
	$lang['Edit_forums_auth'] = 'Forum permissions details';
	$lang['Edit_forums_auth_explain'] = 'Here you can define the permissions to set to this forum, and create, update or delete presets.';

	// edit panel auths details
	$lang['Click_return_edit_auth_panels'] = 'Click %sHere%s to return to the panel permissions edition.';
	$lang['Edit_panels_auth'] = 'Panel permissions details';
	$lang['Edit_panels_auth_explain'] = 'Here you can define the permissions to set to this panel, and create, update or delete presets.';
	$lang['No_such_panel'] = 'No such panel exists.';

	// edit group auths details
	$lang['Click_return_edit_auth_groups'] = 'Click %sHere%s to return to the group permissions edition.';
	$lang['Edit_groups_auth'] = 'Group permissions details';
	$lang['Edit_groups_auth_explain'] = 'Here you can define the permissions to set to this group, and create, update or delete presets.';

	// auths definitions
	$lang['Definition'] = 'Definition';
	$lang['Auths_definition'] = 'Permissions definition';
	$lang['Auths_definition_explain'] = 'Here you can edit, add or remove permissions fields';
	$lang['Click_return_auths_def'] = 'Click %sHere%s to return to permission definition';
	$lang['Create_auths_def'] = 'Create a new permissions field';
	$lang['Create_auths_def_explain'] = 'Here you can create a new permission definition';
	$lang['Edit_auths_def'] = 'Edit a permission definition';
	$lang['Edit_auths_def_explain'] = 'Here you can edit the definition of a permission';
	$lang['Delete_auths_def'] = 'Delete permission definition';
	$lang['Delete_auths_def_explain'] = 'Here you can delete a permission definition';
	$lang['Import_auths_def'] = 'Import permissions definition';
	$lang['Select_auth_type'] = 'Select permission type';
	$lang['No_auths_def'] = 'No permissions created yet. <br />Please press "Create" to create a new one, <br />"Regen" to import existing ones.';
	$lang['No_such_auth_type'] = 'The permissions type you are requesting does not exist.';

	// importing auths defs and forums auths
	$lang['Forums_auths_def_imported'] = 'Forums permissions definitions have been imported.';
	$lang['Forums_auths_def_done'] = 'There were no new forums permissions definitions to import.';
	$lang['Forums_auths_imported'] = 'Forums permissions have been imported too.';
	$lang['Panels_auths_def_imported'] = 'Panels permissions definitions have been imported.';
	$lang['Panels_auths_def_done'] = 'There were no new panels permissions definitions to import.';
	$lang['Groups_auths_def_imported'] = 'Groups permissions definitions have been imported.';
	$lang['Groups_auths_def_done'] = 'There were no new groups permissions definitions to import.';

	// auths def detail
	$lang['No_such_auth_id'] = 'The permission you are requesting does not exist.';
	$lang['Auth_name'] = 'Permission name';
	$lang['Auth_name_explain'] = 'This is the symbolic name used to test the authorisation within the script.';
	$lang['Auth_desc'] = 'Permission description';
	$lang['Auth_title'] = 'Title';
	$lang['Auth_title_explain'] = 'Setting this field to yes will make it used as a title within the permissions lists.';
	$lang['Auth_order'] = 'Position this permission after';

	// update messages
	$lang['Auths_def_created'] = 'The permission definition has been added.';
	$lang['Auths_def_updated'] = 'The permission definition has been updated.';
	$lang['Auths_def_deleted'] = 'The permission definition has been deleted.';

	// group selection
	$lang['Click_return_select_groups'] = 'Click %sHere%s to return to groups selection.';
	$lang['Select_groups'] = 'Select a group or a user';
}

?>