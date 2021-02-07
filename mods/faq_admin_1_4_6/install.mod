############################################################## 
## MOD Title: faq admin mod
## MOD Author: ZParta < zparta@upnorth.se > (Jens Holmqvist) http://www.upnorth.se 
## MOD Description: This MOD will put the faq in the database and make it editable from the ACP
## MOD Version: 1.4.6 
## 
## Installation Level: Easy 
## Installation Time: ~3 Minutes 
## Files To Edit: language/lang_english/lang_admin.php, includes/constants.php 
## Included Files: admin_faq.php 
##			 admin_faq.tpl 
##			 faq_edit_body.tpl 
##			 admin_faq_inst.php 
##			 admin_faq_inst.tpl 
##			 admin_faq_inst_aff.tpl 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: releasing in to the MODDB
############################################################## 
## MOD History: 
## 
## 2003-11-28 - Version 1.4.6
## - Fixed hardcoded language
## 2003-11-23 - Version 1.4.5
## - Fixed validation issues
## 2003-10-28 - Version 1.4.4
## - Fixed some bugs
## 2003-10-27 - Version 1.4.3
## - Fixed some harcoded language
## 2003-10-25 - version 1.4.2
## - Fixed some typos and bugs Thanks to GPHemsley
## 2003-10-20 - version 1.4.1
## - Fixed typos
## 2003-09-27 - version 1.4.0
## - Fixed typos and file missplacements and added language installer :)
## 2003-09-10 - version 1.3.1
## - Fixed bug when deleting faq's/category's it used standard language instead of chosen language
## 2003-06-18 - version 1.3.0
## - Admin interface has bbcode admin implemented
## 2003-06-13 - Version 1.2.0 
## - Admin interface was initialy implemented 
## 2003-06-07 - Version 1.1.0 
## - Some fixes to the database an multilanguage support was integrated 
## 2003-06-07 - Version 1.0.1 
## - Initial Release the faq.php was made 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 
CREATE TABLE `phpbb_faq` (
  `lang_id` varchar(50) NOT NULL default 'english',
  `faq_id` tinyint(11) NOT NULL default '0',
  `faq_title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`faq_id`,`lang_id`)
) TYPE=MyISAM;

# 
#-----[ SQL ]------------------------------------------ 
# 
CREATE TABLE `phpbb_faq_text` (
  `lang_id` varchar(50) NOT NULL default 'english',
  `q_id` tinyint(11) NOT NULL default '0',
  `faq_id` tinyint(11) NOT NULL default '0',
  `q` text NOT NULL,
  `a` text NOT NULL,
  PRIMARY KEY  (`q_id`,`lang_id`)
) TYPE=MyISAM;

# 
#-----[ SQL ]------------------------------------------ 
# 
CREATE TABLE `phpbb_bbcode` (
  `lang_id` varchar(50) NOT NULL default 'english',
  `faq_id` tinyint(11) NOT NULL default '0',
  `faq_title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`faq_id`,`lang_id`)
) TYPE=MyISAM;

# 
#-----[ SQL ]------------------------------------------ 
# 
CREATE TABLE `phpbb_bbcode_text` (
  `lang_id` varchar(50) NOT NULL default 'english',
  `q_id` tinyint(11) NOT NULL default '0',
  `faq_id` tinyint(11) NOT NULL default '0',
  `q` text NOT NULL,
  `a` text NOT NULL,
  PRIMARY KEY  (`q_id`,`lang_id`)
) TYPE=MyISAM;

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// START-faq_admin_mod
$lang['bbcode'] = 'BBCode';
$lang['bbcode_admin'] = 'BBCode Administration';
$lang['Faq_admin'] = 'FAQ Administration';
$lang['Faq_admin_explain'] = 'From this panel you can add, delete and edit categories and FAQ\'s and BBCode entries';
$lang['Edit_faq'] = 'Edit FAQ';
$lang['Create_faq'] = 'Create a new FAQ entry';
$lang['Faq_edit_delete_explain'] = 'The form below will allow you to customize all FAQ configuration\'s of this Question';
$lang['Faq_settings'] = 'General question settings';
$lang['Faq_name'] = 'Question name';
$lang['Faq_desc'] = 'Answer';
$lang['Faqs_updated'] = 'FAQ and category information updated successfully';
$lang['Faq_delete'] = 'Delete FAQ';
$lang['Faq_delete_explain'] = 'The form below will allow you to delete a FAQ (or category) and decide where the content should be moved to';
$lang['Language'] = 'Language';
$lang['Click_return_faqadmin'] = 'Click %sHere%s to return to FAQ Administration';
$lang['Must_delete_faqs'] = 'You need to delete all FAQs before you can delete this category';
$lang['Aff_rows_faq'] = 'Affected rows in FAQ tables';
$lang['Aff_rows_bbcode'] = 'Affected rows in BBCode tables';
$lang['Aff_rows_cat_t'] = 'Affected rows in category table';
$lang['Aff_rows_q_t'] = 'Affected rows in question table';
$lang['faq_admin_ad_explain'] = 'From this panel you can install FAQs and BBCode from language pack\'s downloaded from <a href="http://www.phpbb.com">phpBB\'s</a> official page';
$lang['no_language_in_db'] = 'No language installed';
$lang['no_language_on_hd'] = 'No language to install';
// END-faq_admin_mod

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/constants.php

# 
#-----[ FIND ]------------------------------------------ 
# 
?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// START-faq_admin_mod
define('FAQ_TABLE', $table_prefix.'faq');
define('FAQ_TEXT_TABLE', $table_prefix.'faq_text');
define('POST_FAQ_LANG', 'l');
define('POST_FAQ_TYPE', 'type');
define('BBCODE_TABLE', $table_prefix.'bbcode');
define('BBCODE_TEXT_TABLE', $table_prefix.'bbcode_text');
// END-faq_admin_mod

# 
#-----[ OPEN ]------------------------------------------ 
# 
faq.php

# 
#-----[ FIND ]------------------------------------------ 
# 
// End session management
//

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
/*

# 
#-----[ FIND ]------------------------------------------ 
# 
?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
*/

// START-faq_admin_mod
//
// Load the appropriate sql-statement
//
if( isset($HTTP_GET_VARS['mode']) )
{
	switch( $HTTP_GET_VARS['mode'] )
	{
		case 'bbcode':
			$lang_sql = '1';
			$l_title = $lang['BBCode_guide'];
			break;
		default:
			$lang_sql = '0';
			$l_title = $lang['FAQ'];
			break;
	}
}
else
{
	$lang_sql = '0';
	$l_title = $lang['FAQ'];
}

if ( $userdata['user_lang'] != "" )
{
	$faq_lang = $userdata['user_lang'];
}
else
{
	$faq_lang = $board_config['default_lang'];
}

//
// Lets build a page ...
//
$page_title = $l_title;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'faq_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx, $forum_id);

$template->assign_vars(array(
	'L_FAQ_TITLE' => $l_title, 
	'L_BACK_TO_TOP' => $lang['Back_to_top'])
);

//
// database stuff to faq
//
if ( $lang_sql == 1 )
{
	$sql = "SELECT faq_id, faq_title FROM " . BBCODE_TABLE . " WHERE lang_id = '" . $faq_lang . "' ORDER BY faq_id";
}
else
{
	$sql = "SELECT faq_id, faq_title FROM " . FAQ_TABLE . " WHERE lang_id = '" . $faq_lang . "' ORDER BY faq_id";
}
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query faq entries', '', __LINE__, __FILE__, $sql);
}
if ($row = $db->sql_fetchrowset($result))
{
	$db->sql_freeresult($result);
}
for($i = 0; $i < count($row); $i++)
{
	$template->assign_block_vars('faq_block', array(
		'BLOCK_TITLE' => $row[$i]["faq_title"])
	);
	$template->assign_block_vars('faq_block_link', array(
		'BLOCK_TITLE' => $row[$i]["faq_title"])
	);
	if ( $lang_sql == 1 )
	{
		$sql = "SELECT * FROM " . BBCODE_TEXT_TABLE . " WHERE lang_id = '" . $faq_lang . "' AND faq_id = " . $row[$i]["faq_id"] . " ORDER BY faq_id,q_id";
	}
	else
	{
		$sql = "SELECT * FROM " . FAQ_TEXT_TABLE . " WHERE lang_id = '" . $faq_lang . "' AND faq_id = " . $row[$i]["faq_id"] . " ORDER BY faq_id,q_id";
	}
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query faq entries', '', __LINE__, __FILE__, $sql);
	}
	if ($row2 = $db->sql_fetchrowset($result))
	{
		$db->sql_freeresult($result);
	}
	for($j = 0; $j < count($row2); $j++)
	{
		$row_color = ( !($j % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($j % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		$template->assign_block_vars('faq_block.faq_row', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'FAQ_QUESTION' => $row2[$j]["q"],
			'FAQ_ANSWER' => $row2[$j]["a"],

			'U_FAQ_ID' => $row2[$j]["q_id"])
		);
		$template->assign_block_vars('faq_block_link.faq_row_link', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'FAQ_LINK' => $row2[$j]["q"],

			'U_FAQ_LINK' => '#' . $row2[$j]["q_id"])
		);
	}
}


$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
// END-faq_admin_mod

# 
#-----[ COPY ]------------------------------------------ 
# 
copy admin_faq.tpl to templates/subSilver/admin/admin_faq.tpl 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy admin_faq.php to admin/admin_faq.php 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy faq_edit_body.tpl to templates/subSilver/admin/faq_edit_body.tpl 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy admin_faq_inst.php to admin/admin_faq_inst.php 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy admin_faq_inst.tpl to templates/subSilver/admin/admin_faq_inst.tpl

# 
#-----[ COPY ]------------------------------------------ 
# 
copy admin_faq_inst_aff.tpl to templates/subSilver/admin/admin_faq_inst_aff.tpl 

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 