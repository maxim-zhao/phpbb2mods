<?php
/***************************************************************************
 *                                admin_rss.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2005 by Lucas van Dijk
 *   email                : lucas@aoe3capitol.nl
 *
 *   $Id: admin_rss.php,v 1.00 2004/07/11 16:46:15 mrlucky Exp $
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
        $file = basename(__FILE__);
        $module['General']['rss_config'] = $file;
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
                                message_die(GENERAL_ERROR, "Failed to update RSS configuration for $config_name", "", __LINE__, __FILE__, $sql);
                        }
                }
        }

        if( isset($HTTP_POST_VARS['submit']) )
        {
                $message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_rss.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

                message_die(GENERAL_MESSAGE, $message);
        }
}

$template -> assign_vars(array(
          'RSS_IMAGE' => $board_config['rss_image'],
          'RSS_MAX_TOPICS' => intval($board_config['max_rss_topics']),

          'L_RSS_IMAGE' => $lang['rss_image'],
          'L_RSS_IMAGE_EXP' => $lang['rss_image_exp'],
          'L_RSS_MAX_TOPICS' => $lang['rss_max_topics'],
          'L_RSS_CONFIG' => $lang['rss_config'],
          'L_RSS_CONFIG_EXPLAIN' => $lang['rss_config_explain'],
          'L_SUBMIT' => $lang['Submit'],
          'L_RESET' => $lang['Reset'],

          'S_FORM_ACTION' => append_sid('admin_rss.php'),
));

$template -> set_filenames(array(
          'body' => 'admin/rss_body.tpl'
));

$template -> pparse('body');

require('./page_footer_admin.php');

?>

