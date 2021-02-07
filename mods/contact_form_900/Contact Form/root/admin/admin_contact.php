<?php
/***************************************************************************
 *                              admin_contact.php
 *                             -------------------
 *	Version:	9.0.0
 *	Begin:		Sunday, Sept 17, 2006
 *   	Copyright:	(C) 2006-07, Marcus
 *	E-mail:		marcus@phobbia.net
 *	$id:		21:20 01/06/2007
 *
 ***************************************************************************/

define('IN_PHPBB', true);

if(!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['General']['Contact_Form'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = './../';
include($phpbb_root_path . 'extension.inc');
include('./pagestart.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_contact.'.$phpEx);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . CONTACT_CONFIG_TABLE;

if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, 'Could not query contact config information', '', __LINE__, __FILE__, $sql);
}
else
{
	while($row = $db->sql_fetchrow($result))
	{
		$contact_config[$row['config_name']] = $row['config_value'];
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];

		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;

		$new[$config_name] = (isset($HTTP_POST_VARS[$config_name])) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if(isset($HTTP_POST_VARS['submit']))
		{
			$sql = "UPDATE " . CONTACT_CONFIG_TABLE . "
				SET config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";

			if(!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Failed to update general configuration for $config_name', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if(isset($HTTP_POST_VARS['submit']))
	{
		$message = $lang['Contact_updated'] . "<br /><br />" . sprintf($lang['Click_return_contact'], "<a href=\"" . append_sid("admin_contact.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}
}

// Contact Captcha
define('CAPTCHA_TYPE_IMAGE', 0);
define('CAPTCHA_TYPE_COLOURED', 1);
define('CAPTCHA_TYPE_RANDOM', 2);

// Thank You Options
define('DISABLE_THANKYOU', 0);
define('REGONLY_THANKYOU', 1);
define('ALL_THANKYOU', 2);

$form_enable_yes = ($new['contact_form_enable']) ? "checked=\"checked\"" : "";
$form_enable_no =  (!$new['contact_form_enable']) ? "checked=\"checked\"" : "";

$hash_yes = ($new['contact_hash']) ? "checked=\"checked\"" : "";
$hash_no =  (!$new['contact_hash']) ? "checked=\"checked\"" : "";

$prune_yes = ($new['contact_prune']) ? "checked=\"checked\"" : "";
$prune_no = (!$new['contact_prune']) ? "checked=\"checked\"" : "";

$require_rname_yes = ($new['contact_require_rname']) ? "checked=\"checked\"" : "";
$require_rname_no = (!$new['contact_require_rname']) ? "checked=\"checked\"" : "";

$require_email_yes = ($new['contact_require_email']) ? "checked=\"checked\"" : "";
$require_email_no = (!$new['contact_require_email']) ? "checked=\"checked\"" : "";

$require_comments_yes = ($new['contact_require_comments']) ? "checked=\"checked\"" : "";
$require_comments_no = (!$new['contact_require_comments']) ? "checked=\"checked\"" : "";

$permit_attachments_yes = ($new['contact_permit_attachments']) ? "checked=\"checked\"" : "";
$permit_attachments_no = (!$new['contact_permit_attachments']) ? "checked=\"checked\"" : "";

$contact_auth_guest_yes = ($new['contact_auth_guest']) ? "checked=\"checked\"" : "";
$contact_auth_guest_no = (!$new['contact_auth_guest']) ? "checked=\"checked\"" : "";

$contact_auth_user_yes = ($new['contact_auth_user']) ? "checked=\"checked\"" : "";
$contact_auth_user_no = (!$new['contact_auth_user']) ? "checked=\"checked\"" : "";

$contact_auth_mod_yes = ($new['contact_auth_mod']) ? "checked=\"checked\"" : "";
$contact_auth_mod_no = (!$new['contact_auth_mod']) ? "checked=\"checked\"" : "";

$contact_auth_admin_yes = ($new['contact_auth_admin']) ? "checked=\"checked\"" : "";
$contact_auth_admin_no = (!$new['contact_auth_admin']) ? "checked=\"checked\"" : "";

$contact_captcha_yes = ( $new['contact_captcha'] ) ? "checked=\"checked\"" : "";
$contact_captcha_no = ( !$new['contact_captcha'] ) ? "checked=\"checked\"" : "";

$captcha_type_image = ( $new['contact_captcha_type'] == CAPTCHA_TYPE_IMAGE ) ? "checked=\"checked\"" : "";
$captcha_type_colour = ( $new['contact_captcha_type'] == CAPTCHA_TYPE_COLOURED ) ? "checked=\"checked\"" : "";
$captcha_type_random = ( $new['contact_captcha_type'] == CAPTCHA_TYPE_RANDOM ) ? "checked=\"checked\"" : "";

$contact_thank_none = ( $new['contact_thankyou'] == DISABLE_THANKYOU ) ? "checked=\"checked\"" : "";
$contact_thank_reg = ( $new['contact_thankyou'] == REGONLY_THANKYOU ) ? "checked=\"checked\"" : "";
$contact_thank_all = ( $new['contact_thankyou'] == ALL_THANKYOU ) ? "checked=\"checked\"" : "";

$contact_delete_yes = ( $new['contact_delete'] ) ? "checked=\"checked\"" : "";
$contact_delete_no = ( !$new['contact_delete'] ) ? "checked=\"checked\"" : "";

$contact_storage_yes = ( $new['contact_storage'] ) ? "checked=\"checked\"" : "";
$contact_storage_no = ( !$new['contact_storage'] ) ? "checked=\"checked\"" : "";


$template->set_filenames(array(
	'body' => 'admin/contact_config_body.tpl')
);

$template->assign_vars(array(
	'L_VERSION' => sprintf($contact_config['contact_version']),

	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_DISABLE' => $lang['Disable'],
	'L_ENABLE' => $lang['Enable'],

	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],

	'L_ADMIN_EMAIL' => $lang['Admin_email'],
	'L_ADMIN_EMAIL_EXPLAIN' => $lang['Admin_email_explain'],

	'L_CONTACT_TITLE' => $lang['Contact_title'],
	'L_CONTACT_EXPLAIN' => $lang['Contact_explain'],
	'L_GENERAL_SETTINGS' => $lang['General_settings'],
	'L_REQ_SETTINGS' => $lang['Req_settings'],
	'L_REQUIRE_RNAME' => $lang['Require_rname'],
	'L_REQUIRE_EMAIL' => $lang['Require_email'],
	'L_REQUIRE_COMMENTS' => $lang['Require_comments'],

	'L_PERMIT_ATTACHMENTS' => $lang['Permit_attachments'],
	'L_ATTACHMENTS' => $lang['Attachment_settings'],
	'L_MAX_FILE_SIZE' => $lang['Max_file_size'],
	'L_MAX_FILE_SIZE_EXPLAIN' => sprintf($lang['Max_file_size_explain'], (@phpversion() >= '4.0.0') ? ini_get('upload_max_filesize') : get_cfg_var('upload_max_filesize')),
	'L_FILE_ROOT' => $lang['File_root'],
	'L_FILE_ROOT_EXPLAIN' => $lang['File_root_explain'],

	'L_PRUNE' => $lang['Prune'],
	'L_PRUNE_EXPLAIN' => $lang['Prune_explain'],
	'L_FLOOD_LIMIT' => $lang['Flood_limit_admin'],
	'L_FLOOD_LIMIT_EXPLAIN' => $lang['Flood_limit_admin_explain'],
	'L_CHAR_LIMIT' => $lang['Char_limit_admin'],
	'L_CHAR_LIMIT_EXPLAIN' => $lang['Char_limit_admin_explain'],

	'L_HASH' => $lang['Hash'],
	'L_HASH_EXPLAIN' => $lang['Hash_explain'],
	'L_MD5' => $lang['md5'],
	'L_NO_HASH' => $lang['no_hash'],

	'L_DELETE' => $lang['QDelete'],
	'L_DELETE_EXPLAIN' => $lang['QDelete_explain'],

	'L_STORAGE' => $lang['Msg_Log'],
	'L_STORAGE_EXPLAIN' => $lang['Msg_Log_explain'],

	'L_KB' => $lang['kb'],
	'L_HOURS' => $lang['hours'],

	'L_AUTH_PERMISSION' => $lang['auth_permission'],
	'L_AUTH_PERMISSION_EXPLAIN' => $lang['auth_perm_explain'],

	'L_ANON' => $lang['auth_guests'],
	'L_USER' => $lang['auth_members'],
	'L_MOD' => $lang['auth_mods'],
	'L_ADMIN' => $lang['auth_admins'],

	'L_FORM_ENABLE' => $lang['Form_Enable'],

	'L_CAPTCHA_TITLE' => $lang['Captcha'],
	'L_ACTIVATE' => $lang['Activate'],
	'L_ACTIVATE_EXPLAIN' => $lang['Captcha_explain'],

	'L_CAPTCHA_TYPE' => $lang['Type'],
	'L_CAPTCHA_TYPE_EXPLAIN' => $lang['Type_explain'],
	'L_IMAGEBG' => $lang['Image_bg'],
	'L_COLOURED' => $lang['Coloured'],
	'L_RANDOM' => $lang['Random'],

	'L_THANKYOU_SETTINGS' => $lang['Thankyou_settings'],
	'L_THANKYOU_OPTION' => $lang['Thankyou_option'],
	'L_THANKYOU_EXPLAIN' => $lang['Thankyou_explain'],
	'L_THANK_NONE' => $lang['Thank_none'],
	'L_THANK_MEMBERS' => $lang['Thank_members'],
	'L_THANK_ALL' => $lang['Thank_all'],

	'THANK_NONE' => DISABLE_THANKYOU,
	'THANK_NONE_CHECKED' => $contact_thank_none,
	'THANK_MEMBERS' => REGONLY_THANKYOU,
	'THANK_MEMBERS_CHECKED' => $contact_thank_reg,
	'THANK_ALL' => ALL_THANKYOU,
	'THANK_ALL_CHECKED' => $contact_thank_all,

	'TYPE_IMAGE' => CAPTCHA_TYPE_IMAGE, 
	'CAPTCHA_TYPE_IMAGE_CHECKED' => $captcha_type_image,
	'TYPE_COLOUR' => CAPTCHA_TYPE_COLOURED, 
	'CAPTCHA_TYPE_COLOUR_CHECKED' => $captcha_type_colour,
	'TYPE_RANDOM' => CAPTCHA_TYPE_RANDOM, 
	'CAPTCHA_TYPE_RANDOM_CHECKED' => $captcha_type_random,

	'ADMIN_EMAIL' => $contact_config['contact_admin_email'],
	'FLOOD_LIMIT' => $contact_config['contact_flood_limit'],
	'MAX_FILE_SIZE' => $contact_config['contact_max_file_size'],
	'FILE_ROOT' => $contact_config['contact_file_root'],
	'CHAR_LIMIT' => $contact_config['contact_char_limit'],

	'COPYRIGHT' => $lang['Copyright'],

	'S_CONFIG_ACTION' => append_sid('admin_contact.'.$phpEx),

	'S_FORM_ENABLE_YES' => $form_enable_yes,
	'S_FORM_ENABLE_NO' => $form_enable_no,
	'S_CAPTCHA_ENABLE' => $contact_captcha_yes,
	'S_CAPTCHA_DISABLE' => $contact_captcha_no,

	'S_DELETE_FILES_YES' => $contact_delete_yes,
	'S_DELETE_FILES_NO' => $contact_delete_no,

	'S_STORE_MSGS_YES' => $contact_storage_yes,
	'S_STORE_MSGS_NO' => $contact_storage_no,

	'S_HASH_YES' => $hash_yes,
	'S_HASH_NO' => $hash_no,
	'S_PRUNE_YES' => $prune_yes,
	'S_PRUNE_NO' => $prune_no,

	'S_PERM_GUEST_YES' => $contact_auth_guest_yes,
	'S_PERM_GUEST_NO' => $contact_auth_guest_no,
	'S_PERM_USER_YES' => $contact_auth_user_yes,
	'S_PERM_USER_NO' => $contact_auth_user_no,
	'S_PERM_MOD_YES' => $contact_auth_mod_yes,
	'S_PERM_MOD_NO' => $contact_auth_mod_no,
	'S_PERM_ADMIN_YES' => $contact_auth_admin_yes,
	'S_PERM_ADMIN_NO' => $contact_auth_admin_no,

	'S_REQUIRE_RNAME_YES' => $require_rname_yes,
	'S_REQUIRE_RNAME_NO' => $require_rname_no,
	'S_REQUIRE_EMAIL_YES' => $require_email_yes,
	'S_REQUIRE_EMAIL_NO' => $require_email_no,
	'S_REQUIRE_COMMENTS_YES' => $require_comments_yes,
	'S_REQUIRE_COMMENTS_NO' => $require_comments_no,
	'S_PERMIT_ATTACHMENTS_YES' => $permit_attachments_yes,
	'S_PERMIT_ATTACHMENTS_NO' => $permit_attachments_no)
);

if(extension_loaded('gd'))
{
	$template->assign_block_vars('captcha_config', array());
}

$template->pparse('body');
include('./page_footer_admin.'.$phpEx);

?>