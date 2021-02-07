_______________________________________________________________________________________

Mods settings is a tool for mod developper, designed to handle config table new entries

version note :
	- this version includes the ability to define new types and to add sub-menu options, also main menu options
	- you can now use the mods_settings in order to update users table without creating a config key,
	- you can add screen fields not comming from config or users table
	- the init of the mods has been moved to functions.php rather than page_header.php. It handles now
		all the mods_settings dir (no need to add a specific includes in page_header.php),
	- the prec includes/mods_settings/ descriptions files don't require an upgrade,
	- the standard phpBB version accepts now the parm &u=user_id in order to access a specific
		user preferences. You will be so able to add a link to the viewprofile view.
_______________________________________________________________________________________

***************************************************************

What should be included to your mod (minimum requirement) :

***************************************************************

Assuming your mod is called : example v 0.0.0 (adapt it to your needs of course :))

The mod "example v 0.0.0" requires the add of 4 config table entries :

	o key1, which is a drop down list, values possible are
		- 0 = None,
		- 1 = Medium,
		- 2 = Full
	The user can choose his prefered setting for this one.

	o key2 : a yes/no choice, admin only

	o key3 : a TINYINT value (2 digits), admin only (ie a title length)

	o key4 : a undefined type : DATEFMT, designed to get a format of date


See the mod_example.php for the declaration of this parameters. 


	mod definition global vars
	--------------------------
	$mod_name : $lang[] entry : will be the menu option name

	$mod_main_menu : facultative : $lang[] entry and url mode= value : 
			allows to use a mode= on the url of the preferences option, letting you add a new menu option
			ie: "profile_options.php?mode=settings" will display only the mods defined with "$mod_main_menu='settings';"
			default value when not provided is 'Preferences', for mods and profile_options.php
	$mod_main_sort : facultative : allow to sort the menu for the config+ acp view,
	$mod_sort : facultative : use it to sort the mods in the menu (default sort is $lang[$mod_name])
	$sub_name : facultative : $lang[] entry : when provided, will create a sub-menu
	$sub_sort : facultative : use it to sort the sub-menu options (default sort is $lang[$sub_name])


	Here is the sum-up of the declaration array :

	config_field array : structure
	------------------------------
	key => array() : key is the name of the config entry

		'lang_key'	: $lang[] entry : column heading for the config entry

		'explain'	: $lang[] entry : column heading - detailed explanation

		'type'		: type of the field : values allowed :
				'LIST_RADIO'	: a set of radio button : require the 'values' array to be defined
				'LIST_DROP'	: drop down list : require the 'values' array to be defined
				'TINYINT', 
				'SMALLINT', 
				'MEDIUMINT', 
				'INT'		: integer (the lenght of the input zone vary)
				'VARCHAR'	: string field
				'HTMLVARCHAR'	: string field allowing HTML in it
				'TEXT'		: text box field
				'HTMLTEXT'	: text box fied allowing HTML in it

				other values will require get_func and chk_func to be provided

		'default'	: $lang[] entry if exists : default value for the field

		'values' => array() : set of values for LIST_* type fields
				'Cst'	=> value : 'Cst' is a $lang[] entry, value the value that will be returned (so stored)

		'user'		: field name : name of the users table field for preferences if defined

		'hide'		: boolean : if true, the field won't be displayed, nor in admin nor in users prefs
				The config value will be created and initiate

		'get_func'	: function name : this allows to add other types that the one implemented in the basic version.
				parms description : func(parm1, parm2) returns $result
					- parm1 : $fied_name : the name of the field that has to appear on the input statement
					- parm2 : $value : the current value of the field
					- result : the function has to return a full html sentence, ie :
					return '<input type="post" name="' . $field_name . '" value="' . $value .'" />';

		'chk_func'	: function name : this allows to add other types (cf. get_func parm)
				parms description : func(parm1, parm2) returns $result :
					- parm1 : fied_name : the name of the field that appears on the input statement
					- parm2 : value inputed (equal to $HTTP_POST_VARS[$field_name])
					- result : the value ready to be inserted in the sql statement, ie :
					return trim(str_replace("\'", "''", htmlspecialchars($value)));

					global vars : your can use :
					- $error : boolean value : set it to true to break with an error,
					- $error_msg : error message that will be displayed if error = true

		'user_only'	: boolean : sat to true, no config key entry will be created, and only the user field will be updated

		'auth'		: none or USER, ADMIN, BOARD_ADMIN (admin and board_admin are the same without the Profile Control Panel)
					this allows to restrict some fields only to the admins

		'system'	: allows to set fields without updating config or users table

***************************************************************

***************************************************************

I - To be added to your mod "how to" description :

	- initialisation and creation of config table entry
	- admin interface

NB.: if you are using lang_settings tool too :

	o replace the modifications of lang_main and lang_admin.php with :

## Included Files:
##	mod-mods_settings/lang_extend_mods_settings.php
(../..)
copy mod-mods_settings/lang_extend_mods_settings.php to language/lang_english/lang_extend_mods_settings.php

***************************************************************

(../..)

## Files To Edit:
##	includes/functions.php
##	language/lang_english/lang_admin.php
##	language/lang_english/lang_main.php

(../..)

## Included Files:
##	mod_example.php
##	mod-mods_settings/functions_mods_settings.php
##	mod-mods_settings/admin_board_extend.php
##	mod-mods_settings/board_config_extend_body.tpl

(../..)

## Author Notes: 
##	o users can choose their prefered setup (required full mods settings mod to be installed).
##		Admin can also choose to override the users choice for each setup parameter.

(../..)

#
#-----[ SQL ]-------------------------------------------------
#
# This part is optional : do it only if you want your users to be able to choose their setup
#	if you want so, you'll have to install the MOD-mods_settings mod included in the pack
#
ALTER TABLE phpbb_users ADD user_key1 TINYINT(1) DEFAULT '1' NOT NULL;

(../..)

#
#-----[ COPY ]------------------------------------------------
#
#
# those ones are a part of the MOD-mods_settings mod, and are required for example v 0.0.0
#
copy mod_example.php to includes/mods_settings/mod_example.php
copy mod-mods_settings/functions_mods_settings.php to includes/functions_mods_settings.php
copy mod-mods_settings/admin_board_extend.php to admin/admin_board_extend.php
copy mod-mods_settings/board_config_extend_body.tpl to templates/subSilver/admin/board_config_extend_body.tpl

(../..)

#
#-----[ OPEN ]------------------------------------------------
#
# this part can already exists : don't do it if so
#
includes/functions.php
#
#-----[ FIND ]------------------------------------------------
#
<?php
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : mods settings ---------------------------------------------------------------------------

(../..)

#
#-----[ FIND ]------------------------------------------------
#
	if ( $userdata['user_id'] != ANONYMOUS )
	{
		if ( !empty($userdata['user_lang']))
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
//-- mod : mods settings ---------------------------------------------------------------------------
//-- add
	global $db, $mods, $list_yes_no, $userdata;

	//	get all the mods settings
	$dir = @opendir($phpbb_root_path . 'includes/mods_settings');
	while( $file = @readdir($dir) )
	{
		if( preg_match("/^mod_.*?\." . $phpEx . "$/", $file) )
		{
			include_once($phpbb_root_path . 'includes/mods_settings/' . $file);
		}
	}
	@closedir($dir);
//-- fin mod : profile cp --------------------------------------------------------------------------

(../..)

#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------------
#
<?php
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : mods settings ---------------------------------------------------------------------------
#
#-----[ FIND ]------------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
//-- mod : mods settings ---------------------------------------------------------------------------
//-- add
$lang['Configuration_extend']	= 'Configuration +';
$lang['Override_user_choices']	= 'Override user choices';
//-- end of mod : mods settings --------------------------------------------------------------------

(../..)

#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------------
#
<?php
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : example ---------------------------------------------------------------------------------
#
#-----[ FIND ]------------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
//-- mod : example ---------------------------------------------------------------------------------
//-- add
$lang['Example_setting'] = 'Example Settings';

(../..) ( : other values for the mod )

// Config fields legends (note: here we're sticking example mod : see mod_example.php :))
$lang['Key1']		= 'Key 1 legend';
$lang['Key1_explain']	= 'Key 1 longer explanation';
$lang['Key2']		= 'Key 2 legend';
$lang['Key3']		= 'Key 3 legend';

// set of custom values for key1
$lang['None']		= 'None';
$lang['Medium']		= 'Medium';
$lang['Full']		= 'Full';
//-- end of mod : example --------------------------------------------------------------------------

(../..)



***************************************************************

II - The user interface :

	has to be included in the mod pack under the directory mod-mods_settings/

***************************************************************

The user interface allows your user to set their prefered values for each field added to the users 
table in this purpose, if the admin doesn't choose to overwrite those preferences (per field choices).


standard phpBB
--------------
	It adds a new option to the board menu, called "Preferences", very similar to the admin config
	panel option "Configuration +", with only the fields authorized.

nb.: the pcp version is now included in the profile control panel v 1.0.2 and is no more required

foreign_pack directory :
-----------------------
	Feel free to share your translation :)


List of files to set in the directory mod-mods_settings :
--------------------------------------------------------
	- used by your mod
	------------------
	o admin_board_extend.php
	o functions_mods_settings.php
	o board_config_extend_body.tpl
	o lang_extend_mods_settings.php

	- optional user prefs scripts
	-----------------------------
	o profile_options.php			(standard phpBB version)
	o profile_options_body.tpl		(standard phpBB version)

	- install "how to" descriptions
	-------------------------------
	o MOD-mods_settings-users_choices.txt	(standard phpBB version)


Languages with or without lang_settings :
----------------------------------------
	If you are using lang_settings tool too, don't include in your pack the languages
	modifications descriptions standing in the lang_pack directory : just include the
	sub-directories. 

	I - of course - encourage you to use the lang_settings tool also in your mods, 
	as it will ease your life regarding installation and translation in different 
	languages (only one file to care, no edition for the user, no missing lang keys 
	even if the mod is not translated for the language used on the user's board).
_______________________________________________________________________________________