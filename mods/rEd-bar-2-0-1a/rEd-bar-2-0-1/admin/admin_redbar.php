<?php
/***************************************************************************
 *                              admin_redbar.php
 *                            -------------------
 *   begin                : Thursday, Mar 23, 2006
 *   copyright            : (C) cherokee red (kenny cameron)
 *   email                : phpbb@cherokeered.co.uk
 *
 *   $Id: admin_redbar.php,v 1.0.6 2006/03/23 22:57 cherokeered Exp $
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) ) 
{ 
    $file = basename(__FILE__); 
    $module['Navigation']['Redbar'] = $file;
    return; 
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Pull all config data
//
$sql = "SELECT *
        FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
        message_die(CRITICAL_ERROR, "Could not query information in admin_redbar", "", __LINE__, __FILE__, $sql);
}
else
{
        while( $row = $db->sql_fetchrow($result) )
        {
                $config_name = $row['config_name'];
                $config_value = $row['config_value'];
                $default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;

                $new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

                if ($config_name == 'cookie_name')
                {
                        $cookie_name = str_replace('.', '_', $new['cookie_name']);
                }

                if( isset($HTTP_POST_VARS['submit']) )
                {
                        $sql = "UPDATE " . CONFIG_TABLE . " SET
                                config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
                                WHERE config_name = '$config_name'";
                        if( !$db->sql_query($sql) )
                        {
                                message_die(GENERAL_ERROR, "Failed to update Redbar configuration for $config_name", "", __LINE__, __FILE__, $sql);
                        }
                }
        }

        if( isset($HTTP_POST_VARS['submit']) )
        {
                $message = $lang['Red_config_updated'] . "<br /><br />" . sprintf($lang['Click_return_red_config'], "<a href=\"" . append_sid("admin_redbar.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

                message_die(GENERAL_MESSAGE, $message);
        }
}

$template -> assign_vars(array(
          'L_REDBAR_CONFIG' => $lang['redbar_config'],
          'L_REDBAR_CONFIG_EXPLAIN' => $lang['redbar_config_explain'],

          'L_NAV' => $lang['nav_title'], 
          'L_1' => $lang['nav_name1'], 
          'L_LINK1' => $lang['nav_link1'], 
          'L_2' => $lang['nav_name2'], 
          'L_LINK2' => $lang['nav_link2'], 
          'L_3' => $lang['nav_name3'], 
          'L_LINK3' => $lang['nav_link3'], 
          'L_4' => $lang['nav_name4'], 
          'L_LINK4' => $lang['nav_link4'], 
          'L_5' => $lang['nav_name5'], 
          'L_LINK5' => $lang['nav_link5'], 
          'L_6' => $lang['nav_name6'], 
          'L_LINK6' => $lang['nav_link6'], 
          'L_7' => $lang['nav_name7'], 
          'L_LINK7' => $lang['nav_link7'], 
          'L_8' => $lang['nav_name8'], 
          'L_LINK8' => $lang['nav_link8'], 
          'L_9' => $lang['nav_name9'], 
          'L_LINK9' => $lang['nav_link9'], 
          'L_10' => $lang['nav_name10'], 
          'L_LINK10' => $lang['nav_link10'], 

          'L_SUBMIT' => $lang['Submit'],
          'L_RESET' => $lang['Reset'],

          'NAV_LINK1' => $new['nav_link1'], 
          'NAV_NAME1' => $new['nav_name1'], 
          'NAV_LINK2' => $new['nav_link2'], 
          'NAV_NAME2' => $new['nav_name2'], 
          'NAV_LINK3' => $new['nav_link3'], 
          'NAV_NAME3' => $new['nav_name3'], 
          'NAV_LINK4' => $new['nav_link4'], 
          'NAV_NAME4' => $new['nav_name4'], 
          'NAV_LINK5' => $new['nav_link5'], 
          'NAV_NAME5' => $new['nav_name5'], 
          'NAV_LINK6' => $new['nav_link6'], 
          'NAV_NAME6' => $new['nav_name6'], 
          'NAV_LINK7' => $new['nav_link7'], 
          'NAV_NAME7' => $new['nav_name7'], 
          'NAV_LINK8' => $new['nav_link8'], 
          'NAV_NAME8' => $new['nav_name8'], 
          'NAV_LINK9' => $new['nav_link9'], 
          'NAV_NAME9' => $new['nav_name9'], 
          'NAV_LINK10' => $new['nav_link10'], 
          'NAV_NAME10' => $new['nav_name10'],

          'S_FORM_ACTION' => append_sid('admin_redbar.$phpEx')
));

$template -> set_filenames(array(
          'body' => 'admin/admin_redbar.tpl'
));

$template -> pparse('body');

require('./page_footer_admin.php');

?>