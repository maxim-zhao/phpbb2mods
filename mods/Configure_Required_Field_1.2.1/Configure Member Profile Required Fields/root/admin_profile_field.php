<?php
/***************************************************************************
 *                          admin_profile_field.php
 *                            -------------------
 * Email				: ycl6@users.sourceforge.net (http://macphpbbmod.sourceforge.net/)
 * Begin                : Wednesday, Jan 21, 2004
 * Last Updated         : Thursday, Nov 24, 2005
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Profile_field_config'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

// Pull all profile field required status
$sql = "SELECT *
	FROM " . PROFILE_CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query required field config information", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . PROFILE_CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update required profile field status for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Profile_config_updated'] . "<br /><br />" . sprintf($lang['Click_return_profile_config'], "<a href=\"" . append_sid("admin_profile_field.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

$user_icq_yes = ( $new['icq'] ) ? "checked=\"checked\"" : "";
$user_icq_no = ( !$new['icq'] ) ? "checked=\"checked\"" : "";

$user_website_yes = ( $new['website'] ) ? "checked=\"checked\"" : "";
$user_website_no = ( !$new['website'] ) ? "checked=\"checked\"" : "";

$user_from_yes = ( $new['location'] ) ? "checked=\"checked\"" : "";
$user_from_no = ( !$new['location'] ) ? "checked=\"checked\"" : "";

$user_sig_yes = ( $new['signature'] ) ? "checked=\"checked\"" : "";
$user_sig_no = ( !$new['signature'] ) ? "checked=\"checked\"" : "";

$user_aim_yes = ( $new['aim'] ) ? "checked=\"checked\"" : "";
$user_aim_no = ( !$new['aim'] ) ? "checked=\"checked\"" : "";

$user_yim_yes = ( $new['yim'] ) ? "checked=\"checked\"" : "";
$user_yim_no = ( !$new['yim'] ) ? "checked=\"checked\"" : "";

$user_msnm_yes = ( $new['msnm'] ) ? "checked=\"checked\"" : "";
$user_msnm_no = ( !$new['msnm'] ) ? "checked=\"checked\"" : "";

$user_occ_yes = ( $new['occupation'] ) ? "checked=\"checked\"" : "";
$user_occ_no = ( !$new['occupation'] ) ? "checked=\"checked\"" : "";

$user_interests_yes = ( $new['interests'] ) ? "checked=\"checked\"" : "";
$user_interests_no = ( !$new['interests'] ) ? "checked=\"checked\"" : "";

$template->set_filenames(array(
	"body" => "admin/admin_profile_field.tpl")
);

$template->assign_vars(array(
	"S_CONFIG_ACTION" => append_sid("admin_profile_field.$phpEx"),

	"L_YES" => $lang['Reg_compulsory'],
	"L_NO" => $lang['Reg_optional'],
	"L_PROFILE_CONFIGURATION_TITLE" => $lang['Profile_field_config'],
	"L_PROFILE_CONFIGURATION_EXPLAIN" => $lang['Profile_field_explain'],
	"L_SETTINGS" => $lang['Settings'],
	"L_USER_ICQ" => $lang['ICQ'], 
	"L_USER_WWW" => $lang['Website'], 
	"L_USER_FROM" => $lang['Location'], 
	"L_USER_SIG" => $lang['Signature'],
	"L_USER_AIM" => $lang['AIM'], 
	"L_USER_YIM" => $lang['YIM'],
	"L_USER_MSN" => $lang['MSNM'], 
	"L_USER_OCC" => $lang['Occupation'], 
	"L_USER_INTEREST" => $lang['Interests'],
	"L_CMPRF_MOD_VERSION" => $lang['CMPRF_mod_version'],
	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'], 

	"ICQ_YES" => $user_icq_yes,
	"ICQ_NO" => $user_icq_no,
	"WWW_YES" => $user_website_yes, 
	"WWW_NO" => $user_website_no, 
	"FROM_YES" => $user_from_yes,
	"FROM_NO" => $user_from_no,
	"SIG_YES" => $user_sig_yes, 
	"SIG_NO" => $user_sig_no, 
	"AIM_YES" => $user_aim_yes,
	"AIM_NO" => $user_aim_no,
	"YIM_YES" => $user_yim_yes,
	"YIM_NO" => $user_yim_no, 
	"MSN_YES" => $user_msnm_yes,
	"MSN_NO" => $user_msnm_no,
	"OCC_YES" => $user_occ_yes,
	"OCC_NO" => $user_occ_no,
	"INTEREST_YES" => $user_interests_yes,
	"INTEREST_NO" => $user_interests_no)
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
