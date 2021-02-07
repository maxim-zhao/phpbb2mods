<?php
/***************************************************************************
 *                              admin_desc.php
 *                            -------------------
 *   begin                : Tuesday, Apr 12, 2005
 *   copyright            : swizec
 *   email                : swizec@swizec.com
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Descriptions'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

//
// Pull all config data
//
// Dear MODs, I am using the config table for ease of use throughout the board
// so as to interfere with the basic code as little as possible and avoid adding
// SQL queries where they actually hurt, in the displaying of the page. Thank you :)
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if ( $config_name == 'desc_length' && $new[$config_name] > 255) 
		{
			$new[$config_name] = 255;
		}

		if( isset($HTTP_POST_VARS['submit']) )
		{
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}


	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_descconfig'], "<a href=\"" . append_sid("admin_desc.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}

}

$description_yes = ( $new['allow_descriptions'] ) ? "checked=\"checked\"" : "";
$description_no = ( !$new['allow_descriptions'] ) ? "checked=\"checked\"" : "";

$descmods_yes = ( $new['only_mods_desc'] ) ? "checked=\"checked\"" : "";
$descmods_no = ( !$new['only_mods_desc'] ) ? "checked=\"checked\"" : "";

$guestdesc_yes = ( $new['guests_desc'] ) ? "checked=\"checked\"" : "";
$guestdesc_no = ( !$new['guests_desc'] ) ? "checked=\"checked\"" : "";

$guestmoddesc_yes = ( $new['guests_moddesc'] ) ? "checked=\"checked\"" : "";
$guestmoddesc_no = ( !$new['guests_moddesc'] ) ? "checked=\"checked\"" : "";

$disseedesc_yes = ( $new['disallowed_seedesc'] ) ? "checked=\"checked\"" : "";
$disseedesc_no = ( !$new['disallowed_seedesc'] ) ? "checked=\"checked\"" : "";

$showtooltips_yes = ( $new['show_tooltips'] ) ? "checked=\"checked\"" : "";
$showtooltips_no = ( !$new['show_tooltips'] ) ? "checked=\"checked\"" : "";

$tooltips_static_yes = ( $new['tooltips_static'] ) ? "checked=\"checked\"" : "";
$tooltips_static_no = ( !$new['tooltips_static'] ) ? "checked=\"checked\"" : "";

$tooltips_parse_yes = ( $new['tooltips_parse'] ) ? "checked=\"checked\"" : "";
$tooltips_parse_no = ( !$new['tooltips_parse'] ) ? "checked=\"checked\"" : "";

$desc_length = $new['desc_length'];

$desc2link_yes = ( $new['desc_tolink'] ) ? "checked=\"checked\"" : "";
$desc2link_no = ( !$new['desc_tolink'] ) ? "checked=\"checked\"" : "";

$desclinkforce_yes = ( $new['desc_linkforce'] ) ? "checked=\"checked\"" : "";
$desclinkforce_no = ( !$new['desc_linkforce'] ) ? "checked=\"checked\"" : "";

$desclinkempty_yes = ( $new['desc_linkempty'] ) ? "checked=\"checked\"" : "";
$desclinkempty_no = ( !$new['desc_linkempty'] ) ? "checked=\"checked\"" : "";

$toolimg_width = $new['toolimg_width'];
$toolimg_height = $new['toolimg_height'];

$descprev_yes = ( $new['desc_prev'] ) ? "checked=\"checked\"" : "";
$descprev_no = ( !$new['desc_prev'] ) ? "checked=\"checked\"" : "";

$deschtml_yes = ( $new['desc_html'] ) ? "checked=\"checked\"" : "";
$deschtml_no = ( !$new['desc_html'] ) ? "checked=\"checked\"" : "";

$descbbcode_yes = ( $new['desc_bbcode'] ) ? "checked=\"checked\"" : "";
$descbbcode_no = ( !$new['desc_bbcode'] ) ? "checked=\"checked\"" : "";

$descsmile_yes = ( $new['desc_smile'] ) ? "checked=\"checked\"" : "";
$descsmile_no = ( !$new['desc_smile'] ) ? "checked=\"checked\"" : "";

$bbcode_hatelist = $new['desc_bbcode_hatelist'];

$bbcoderemove_yes = ( $new['desc_bbcode_remove'] ) ? "checked=\"checked\"" : "";
$bbcoderemove_no = ( !$new['desc_bbcode_remove'] ) ? "checked=\"checked\"" : "";

$postparsing_yes = ( $new['desc_postparsing'] ) ? "checked=\"checked\"" : "";
$postparsing_no = ( !$new['desc_postparsing'] ) ? "checked=\"checked\"" : "";

$postparsingt_yes = ( $new['desc_postparsing_tool'] ) ? "checked=\"checked\"" : "";
$postparsingt_no = ( !$new['desc_postparsing_tool'] ) ? "checked=\"checked\"" : "";

$toolpostsize = $new['tooltips_post_maxsize'];

$template->set_filenames(array(
	'body' => 'admin/desc_config_body.tpl'
	)
);

$template->assign_vars(array(
	'S_CONFIG_ACTION' => append_sid('admin_desc.' . $phpEx),

	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_SUBMIT' => $lang['Submit'], 
	'L_RESET' => $lang['Reset'], 
	'L_ALLOW_DESC' => $lang['allow_desc'],
	'L_MODS_DESC' => $lang['mods_desc'],
	'L_DESCRIPTION_SETTINGS' => $lang['desc_settings'],
	'L_CONFIGURATION_TITLE' => $lang['desc_settings'],
	'L_CONFIGURATION_EXPLAIN' => $lang['desc_settings_explain'],
	'L_PERMISSIONS' => $lang['permissions'],
	'L_GUESTDESC' => $lang['guestdesc'],
	'L_GUESTMODDESC' => $lang['guestmoddesc'],
	'L_DISSEEDESC' => $lang['disallowed_seedesc'],
	'L_TOOLTIPS' => $lang['tooltips'],
	'L_TOOLTIPS_SHOW' => $lang['tooltips_show'],
	'L_TOOLTIPS_STATIC' => $lang['tooltips_static'],
	'L_TOOLTIPS_PARSE' => $lang['tooltips_parse'],
	'L_DESC_LENGTH' => $lang['desc_length'],
	'L_DESC2LINK' => $lang['desc_tolink'],
	'L_DESCLINKFORCE' => $lang['desc_linkforce'],
	'L_DESCLINKEMPY' => $lang['desc_linkempty'],
	'L_TOOLIMG_SIZE' => $lang['toolimg_size'],
	'L_DESCPREV' => sprintf( $lang['desc_prev'], $board_config['desc_length'] ),
	'L_PARSE' => $lang['desc_parse'],
	'L_PARSE_HTML' => $lang['desc_html'],
	'L_PARSE_BBCODE' => $lang['desc_bbcode'],
	'L_PARSE_SMILE' => $lang['desc_smile'],
	'L_BBCODE_HATELIST' => $lang['desc_bbcode_hatelist'],
	'L_BBCODE_REMOVE' => $lang['desc_bbcode_remove'],
	'L_TOOLPOSTSIZE' => $lang['desc_tooltips_maxpostize'],
	'L_TOOLMODIFY' => $lang['desc_tooltips_modify'],
	'L_POSTPARSING' => $lang['desc_postparsing'],
	'L_POSTPARSINGT' => $lang['desc_postparsingt'],
	'L_BBCODE' => $lang['desc_bbcodeparsing'],

	'DESCRIPTION_YES' => $description_yes,
	'DESCRIPTION_NO' => $description_no,
	'DESCMODS_YES' => $descmods_yes,
	'DESCMODS_NO' => $descmods_no,
	'GUESTDESC_YES' => $guestdesc_yes,
	'GUESTDESC_NO' => $guestdesc_no,
	'GUESTMODDESC_YES' => $guestmoddesc_yes,
	'GUESTMODDESC_NO' => $guestmoddesc_no,
	'DISSEEDESC_YES' => $disseedesc_yes,
	'DISSEEDESC_NO' => $disseedesc_no,
	'SHOWTOOLTIPS_YES' => $showtooltips_yes,
	'SHOWTOOLTIPS_NO' => $showtooltips_no,
	'TOOLTIPS_STATIC_YES' => $tooltips_static_yes,
	'TOOLTIPS_STATIC_NO' => $tooltips_static_no,
	'TOOLTIPS_PARSE_YES' => $tooltips_parse_yes,
	'TOOLTIPS_PARSE_NO' => $tooltips_parse_no,
	'DESC_LENGTH' => $desc_length,
	'DESC2LINK_YES' => $desc2link_yes,
	'DESC2LINK_NO' => $desc2link_no,
	'DESCLINKFORCE_YES' => $desclinkforce_yes,
	'DESCLINKFORCE_NO' => $desclinkforce_no,
	'DESCLINKEMPTY_YES' => $desclinkempty_yes,
	'DESCLINKEMPTY_NO' => $desclinkempty_no,
	'TOOLIMG_WIDTH' => $toolimg_width,
	'TOOLIMG_HEIGHT' => $toolimg_height,
	'DESCPREV_YES' => $descprev_yes,
	'DESCPREV_NO' => $descprev_no,
	'PARSE_HTML_YES' => $deschtml_yes,
	'PARSE_HTML_NO' => $deschtml_no,
	'PARSE_BBCODE_YES' => $descbbcode_yes,
	'PARSE_BBCODE_NO' => $descbbcode_no,
	'PARSE_SMILE_YES' => $descsmile_yes,
	'PARSE_SMILE_NO' => $descsmile_no,
	'BBCODE_HATELIST' => $bbcode_hatelist,
	'BBCODE_REMOVE_YES' => $bbcoderemove_yes,
	'BBCODE_REMOVE_NO' => $bbcoderemove_no,
	'TOOLPOSTSIZE' => $toolpostsize,
	'POSTPARSING_YES' => $postparsing_yes,
	'POSTPARSING_NO' => $postparsing_no,
	'POSTPARSINGT_YES' => $postparsingt_yes,
	'POSTPARSINGT_NO' => $postparsingt_no,
	
) );

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
