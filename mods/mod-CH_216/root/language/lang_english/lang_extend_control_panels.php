<?php
//
//	file: language/lang_english/lang_extend_control_panels.php
//	author: ptirhiik
//	begin: 08/10/2004
//	version: 1.6.1 - 24/10/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// admin part
if ( $is['admin'] )
{
	$lang['Lang_extend_control_panels'] = 'Control panels';

	// admin, cp menus
	$lang['cp_Management'] = 'Management';
	$lang['cp_Patches'] = 'Patches';

	// admin_cp, index
	$lang['cp_management'] = 'Control panels management';
	$lang['cp_management_explain'] = 'Here you can create, modify or delete panels and forms used by the control panels.';

	$lang['Panels'] = 'Panels';
	$lang['Fields'] = 'Form fields';
	$lang['Panel_file'] = 'Script';
	$lang['Panel_file_explain'] = 'Enter here the script name to execute, or leave this field blank.';
	$lang['Panel_hidden'] = 'Hidden from menu';
	$lang['Form_management'] = 'Access form';

	$lang['Click_return_cp'] = 'Click %sHere%s to return to control panels management.';

	// admin cp, preview menu
	$lang['Preview_menu'] = 'Preview control panel menu';
	$lang['Preview_menu_explain'] = 'Here you can see a sample of the control panel menu appearance.';

	$lang['Not_a_control_panel'] = 'You can not do this on this panel.';
	$lang['acp'] = 'Configuration';
	$lang['ucp'] = 'Profile';
	$lang['gcp'] = 'Groups';

	$lang['Panel_definition'] = 'Panel definition';

	// admin cp, panel details
	$lang['Edit_panel'] = 'Edit a panel';
	$lang['Edit_panel_explain'] = 'Here you can edit a panel.';
	$lang['Delete_panel'] = 'Delete a panel';
	$lang['Delete_panel_explain'] = 'Here you can delete a panel.';
	$lang['Create_panel'] = 'Create a new panel';
	$lang['Create_panel_explain'] = 'Here you can create a new panel.';

	$lang['Panel_updated'] = 'The panel has been updated.';
	$lang['Panel_created'] = 'The panel has been created.';
	$lang['Panel_edited'] = 'The panel has been edited.';
	$lang['Panel_deleted'] = 'The panel has been deleted.';

	$lang['Panel_shortcut_explain'] = 'This shortcut will be use in the url as mode.';
	$lang['Panel_main'] = 'Parent panel';
	$lang['Panel_order'] = 'Position this panel after';
	$lang['Panel_auth'] = 'Authorisation to access the panel';
	$lang['Panel_auth_explain'] = 'Choose which authorisation restricts the panel access (default is "m::access").';

	$lang['Panel_move_content'] = 'Move all content';
	$lang['Panel_move_content_explain'] = 'Choose a panel where to move the sub-panels.';

	$lang['Panel_root_edit_deny'] = 'You can not edit or delete the panels index.';
	$lang['Panel_not_empty'] = 'There is still fields attached to this panel, and you can not move them to the panel index : choose a different location for the move, or delete them.';
	$lang['Panel_empty_move_to'] = 'Please choose a panel to move contents or "Delete All" to delete them.';
	$lang['Panel_auth_wrong'] = 'This is not a valid authorisation';

	// admin cp, map
	$lang['Map_management'] = 'Fields management';
	$lang['Map_management_explain'] = 'Here you can create, delete or modify fields belonging to the panel.';

	$lang['Field_standard_types'] = '__ Standard types __';
	$lang['Field_standard_attrs'] = '__ Standard attributes __';

	$lang['Table_open'] = 'Open';
	$lang['Table_close'] = 'Close';

	$lang['Field_description'] = 'Field description';
	$lang['Delete_field'] = 'Delete field';
	$lang['Delete_field_explain'] = 'Pressing delete will remove this field definition.';
	$lang['Form_preview'] = 'Form preview';
	$lang['Form_preview_explain'] = 'Here is a preview of the form.';
	$lang['Create_field'] = 'Create a new field';
	$lang['Create_field_explain'] = 'Here you can create a new field definition';

	$lang['Field_copy_from'] = 'Copy from field';
	$lang['Field_copy_choose'] = '____ Pick up a field to copy from ____';
	$lang['Field_attributes'] = 'Field attributes';
	$lang['Field_attributes_explain'] = 'You can either set : <br /> - a direct value, <br /> - a var name using <b>[var][<i>script_name</i>]<i>your_var_name</i></b>, <br /> - a function name using <b>[func][<i>script_name</i>]<i>your_function</i></b>, <br /> - an array using <b>[array]<i>key_1</i> =&gt; <i>text_value_1</i>, <i>key_2</i> =&gt; <i>text_value_2</i>, <i>key_3</i> =&gt; <i>text_value_3</i>, </b>...<br />NB: script_name is the script where stands the function or the var, and is optional. The syntax is "includes/ucp/ucp_fields" for the file "./includes/ucp/ucp_fields.php".<br /><br />Set the value blank (or None in lists) to delete the attribute.';
	$lang['Field_attributes_add'] = 'Add a new attribute';
	$lang['Field_attr_name'] = 'Attribute name';
	$lang['Field_order'] = 'Position this field after';

	$lang['Field_name'] = 'Field name';
	$lang['Field_name_explain'] = 'This is the name the field will have on form. It has to be unique per panel.';
	$lang['Field_class_file'] = 'Class definition script';
	$lang['Field_class_file_explain'] = 'Local script url (without the .php at end) where stands the field class definition.';
	$lang['Field_type'] = 'Field type';
	$lang['Field_type_explain'] = 'This type will determine the methods to input and output the field on form.';
	$lang['Field_output'] = 'For output only';
	$lang['Field_form_only'] = 'Form only';
	$lang['Field_form_only_explain'] = 'Data will be only retrieve from $_POST';
	$lang['Field_hidden'] = 'Hidden';
	$lang['Field_legend'] = 'Legend';
	$lang['Field_legend_explain'] = 'This will be the legend of the field. Prefer using a lang key entry (check the lang_* files).';
	$lang['Field_explain'] = 'Explanation';
	$lang['Field_explain_explain'] = 'Complementary text for the legend, displayed under it (like this one).';
	$lang['Field_value'] = 'Initial value';
	$lang['Field_post_value'] = 'Complementary value';
	$lang['Field_config_over'] = '"Overwrite users choice" field';
	$lang['Field_image'] = 'Image';
	$lang['Field_image_explain'] = 'You can use a direct URL, or prefer an entry of the $images[] array (check templates/<i>your_template</i>/<i>your_template</i>.cfg)';
	$lang['Field_title'] = 'Image title';
	$lang['Field_title_explain'] = 'This will be the title of the image displayed when mouse gets over it. Prefer using a lang key entry (check the lang_* files).';
	$lang['Field_link'] = 'Link';
	$lang['Field_html'] = 'HTML';
	$lang['Field_html_explain'] = 'Depending the type of field used, this attribute will allow you to add some html fragments (ie on list : <i>onchange="action();"</i>)';
	$lang['Field_table_field'] = 'Database field';
	$lang['Field_table_field_explain'] = 'In user profile context, this will be a users table field. In admin control panel context, this will be a config entry.';
	$lang['Field_combined'] = 'Combined with previous';
	$lang['Field_linefeed'] = 'Linefeed';
	$lang['Field_over'] = 'Span over the two columns of the form';
	$lang['Field_over_center'] = 'Centered when span over';
	$lang['Field_width'] = 'Width';
	$lang['Field_length'] = 'Field length';
	$lang['Field_length_mini'] = 'Minimum length';
	$lang['Field_empty_allowed'] = 'Empty value allowed';
	$lang['Field_length_mini_error'] = '"Field too short" error message';
	$lang['Field_length_maxi'] = 'Maximum length';
	$lang['Field_length_maxi_error'] = '"Field too long" error message';
	$lang['Field_value_mini'] = 'Minimum value';
	$lang['Field_value_mini_error'] = '"Value too low" error message';
	$lang['Field_value_maxi'] = 'Maximum value';
	$lang['Field_value_maxi_error'] = '"Value too high" error message';
	$lang['Field_url_error'] = '"URL error" message';
	$lang['Field_options'] = 'Options of the list';
	$lang['Field_options_no_translate'] = 'Options not translated';
	$lang['Field_options_empty_error'] = '"Empty options list" error message';
	$lang['Field_options_error'] = '"Selected option not exists" message';
	$lang['Field_options_linefeed'] = 'Options linefeed';
	$lang['Field_padding'] = 'Table: padding';
	$lang['Field_class'] = 'Table: class (strong or light)';
	$lang['Field_action'] = 'Table: open or close';
	$lang['Field_new_row'] = 'Table: open/close row';
	$lang['Field_new_column'] = 'Table: open/close column';

	// admin cp, map, macro fields
	$lang['Field_macro_switch_no_yes'] = 'Switch no/yes';
	$lang['Field_macro_overwrite_choice'] = 'Override user choice (acp)';
	$lang['Field_macro_list_auto_valid'] = 'List submitted on change';
	$lang['Field_macro_user_text'] = 'Text in ucp';
	$lang['Field_macro_req_value'] = 'Single-line text not empty';
	$lang['No_attributes'] = 'There is no definition for this field';
	$lang['Script_not_found'] = 'Script not found';
	$lang['Unknown_value_type'] = 'Unknown value type';
	$lang['Field_value_empty'] = 'No value. Please set one, or erase the value entirely to delete this attribute.';
	$lang['Not_an_array'] = 'I didn\'t succeed in parsing the values of the array : check they are correctly defined.';

	// admin cp, map, delete
	$lang['Existing_fields'] = 'Existing fields';
	$lang['Macro_fields'] = 'Macro fields';
	$lang['No_such_field'] = 'No such field';
	$lang['Field_deleted'] = 'The field definition has been deleted.';
	$lang['Field_updated'] = 'The field definition has been updated.';
	$lang['Field_created'] = 'The field definition has been created.';

	// admin cp, patches
	$lang['cp_patch'] = 'Control panels Patches';
	$lang['cp_patch_explain'] = 'Here you can generate patches and saves.';
	$lang['Click_return_cp_patch'] = 'Click %sHere%s to return to control panels patches.';
	$lang['Patches_settings'] = 'Patches settings';
	$lang['Panels_Fields'] = 'Panels and fields';

	$lang['Patch_file'] = 'Patch filename';
	$lang['Patch_version'] = 'Patch version';
	$lang['Patch_date'] = 'Patch date';
	$lang['Patch_ref'] = 'Patch references';
	$lang['Patch_author'] = 'Patch author name';
	$lang['Patch_mode'] = 'Patch generation mode';
	$lang['Patch_mode_explain'] = 'Choose "Only definitions" to save only the panels and fields definitions, choose "Patch" to save system groups permissions with, choose "Save" to save all.';
	$lang['Patch_mode_defs'] = 'Only definitions';
	$lang['Patch_mode_patch'] = 'Patch';
	$lang['Patch_mode_save'] = 'Save';
}

?>