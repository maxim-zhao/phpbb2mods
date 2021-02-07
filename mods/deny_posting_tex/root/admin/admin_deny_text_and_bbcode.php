<?php
/***************************************************************************
 *                        admin_deny_text_and_bbcode.php
 *                        ---------------------------------
 *   begin                : Monday, 25 September 2006
 *   copyright            : (C) 2006 Alejandro Iannuzzi
 *
 *   $Id: admin_deny_text_and_bbcode.php, v 1.0.1  2006/11/16 09:52 (GMT+10)
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
   $filename = basename(__FILE__);
   $module['Forums']['Deny_Posting_Text_and_BBcode'] = $filename;
   return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);


// Update Form
if ( !isset($HTTP_POST_VARS['update']) ) {

   // Change the numbers to show the different radio circles / fields
   $status_enabled = ($board_config['deny_status'] == 1) ? "checked=\"checked\"" : "";
   $status_disabled = ($board_config['deny_status'] == 0) ? "checked=\"checked\"" : "";
   $bbcode_enabled = ($board_config['deny_bbcode'] == 1) ? "checked=\"checked\"" : "";
   $bbcode_disabled = ($board_config['deny_bbcode'] == 0) ? "checked=\"checked\"" : "";
   $post_restrict = (!$board_config['deny_post_restrict']) ? 0 : $board_config['deny_post_restrict'];
}

else {

   // Variable where the output message goes - either an error or success message
   $output_message = "";

   // POSTs
   $form_status = ( !empty($HTTP_POST_VARS['status']) ) ? intval($HTTP_POST_VARS['status']) : 0;
   $form_bbcode = ( !empty($HTTP_POST_VARS['bbcode']) ) ? intval($HTTP_POST_VARS['bbcode']) : 0;
   $form_post_restrict = ( !empty($HTTP_POST_VARS['postrestrict']) ) ? intval($HTTP_POST_VARS['postrestrict']) : 0;

   // If the user submitted anything for post restrict
   if ($form_post_restrict) {
      if ($form_post_restrict < 0) {
         $output_message .= $lang['Deny_text_bbcode_restriction_text'] . " " . $lang['Deny_text_bbcode_error_more_than_zero'] . "<BR />";
         $form_post_restrict = 0;
      }
   }

   // If enabled is selected and post restriction has a value, we can enable this service
   if ($form_status == 1) {
      if (!$form_post_restrict) {
         $output_message .= $lang['Deny_text_bbcode_error_input_post_restriction'];
         $form_status = 0;
      }
   }

   // If there were no errors
   if ($output_message == "") {

      // Update DB
      update_db ("deny_status", $form_status);
      update_db ("deny_bbcode", $form_bbcode);
      update_db ("deny_post_restrict", $form_post_restrict);

      $output_message = $lang['Deny_text_bbcode_success_update'];
   }

   // Update Form
   $status_enabled = ($form_status == 1) ? "checked=\"checked\"" : "";
   $status_disabled = ($form_status == 0) ? "checked=\"checked\"" : "";
   $bbcode_enabled = ($form_bbcode == 1) ? "checked=\"checked\"" : "";
   $bbcode_disabled = ($form_bbcode == 0) ? "checked=\"checked\"" : "";
   $post_restrict = (!$form_post_restrict) ? 0 : $form_post_restrict;

   // Output Message
   $template->assign_block_vars("output", array(
      "MESSAGE" => $output_message,
      "INFORMATION_TITLE" => $lang['Information'])
   );
}

$text_list = (!$board_config['deny_text']) ? '' : $board_config['deny_text'];

// Submit New Text
if ( isset($HTTP_POST_VARS['submit']) ) {
   $form_new_text = ( !empty($HTTP_POST_VARS['newtext']) ) ? htmlspecialchars($HTTP_POST_VARS['newtext']) : 0;

   if ($form_new_text) {

      // If text_list isn't empty, then add the text to the existing list
      if ($text_list) {
         $text_list_array = explode("\n",$text_list);
         $text_list_array[count($text_list_array)] = $form_new_text;
      }
      else {
         $text_list_array[0] = $form_new_text;
      }

      $text_list = implode("\n",$text_list_array);
      $text_list = addslashes($text_list);
      $text_list = str_replace("\'", "''", $text_list);

      // Update DB
      update_db ("deny_text", $text_list);

      // So the user doesn't see the add_slashes or str_replace
      $text_list = implode("\n",$text_list_array);

      $output_new_text = sprintf($lang['Deny_text_bbcode_success_submit'],$form_new_text);

      $template->assign_block_vars("output", array(
         "MESSAGE" => $output_new_text,
         "INFORMATION_TITLE" => $lang['Information'])
      );
   }
}

// Deleting Text from Text List
if ( isset($HTTP_GET_VARS['id']) || isset($HTTP_POST_VARS['id']) ) {
   $id = (isset($HTTP_GET_VARS['id'])) ? $HTTP_GET_VARS['id'] : $HTTP_POST_VARS['id'];
   $id = intval($id);

   // If there is text in text list
   if ($text_list) {

      $text_list_array = explode("\n",$text_list);

      // ID shouldn't be less than 0 or more than the count of the text list array (else it's out of bound)
      if ($id >= 0 && $id < count($text_list_array)) {

         // Remove the selected text from the text list
         $removed_text = $text_list_array[$id];
         array_splice($text_list_array, $id, 1);
         $text_list = implode("\n",$text_list_array);
         $text_list = addslashes($text_list);
         $text_list = str_replace("\'", "''", $text_list);

         // Update DB, if this was the last text to delete update DB with the value of 0
         if (count($text_list_array) == 0) {
            update_db ("deny_text", 0);
         }
         else {
            update_db ("deny_text", $text_list);
         }

         // So the user doesn't see the add_slashes or str_replace
         $text_list = implode("\n",$text_list_array);

         $output_remove_text = sprintf($lang['Deny_text_bbcode_success_delete'], $removed_text);

         $template->assign_block_vars("output", array(
            "MESSAGE" => $output_remove_text,
            "INFORMATION_TITLE" => $lang['Information'])
         );
      }
      else {
         $error = 1;
      }
   }
   else {
      $error = 1;
   }

   if ($error == 1) {
      $template->assign_block_vars("output", array(
         "MESSAGE" => $lang['Deny_text_bbcode_error_id'],
         "INFORMATION_TITLE" => $lang['Information'])
      );
   }
}

// Display the Text List
if ($text_list) {
   $text_list_array = explode("\n",$text_list);

   for ($x = 0; $x < count($text_list_array); $x++) {
      $row_color = ( !($x % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
      $row_class = ( !($x % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

      $template->assign_block_vars("text", array(
         "ROW_COLOR" => "#" . $row_color,
         "ROW_CLASS" => $row_class,
         "TEXT" => $text_list_array[$x],
         "REPLACEMENT" => $replacement,

         "U_TEXT_DELETE" => append_sid("admin_deny_text_and_bbcode.$phpEx?id=$x"))
      );
   }
}

$template->set_filenames(array(
   "body" => "admin/deny_text_and_bbcode.tpl")
);

$template->assign_vars(array(
   "DENY_TEXT_AND_BBCODE_TITLE" => $lang['Deny_text_bbcode_title'],
   "DENY_TEXT_AND_BBCODE_TEXT" => $lang['Deny_text_bbcode_explain'],

   "SETTINGS_TITLE" => $lang['Deny_text_bbcode_settings_title'],
   "STATUS_TEXT" => $lang['Deny_text_bbcode_status_text'],
   "BBCODE_TEXT" => $lang['Deny_text_bbcode_bbcode_text'],
   "BBCODE_EXPLAIN" => $lang['Deny_text_bbcode_bbcode_explain'],
   "TEXTLIST_TEXT" => $lang['Deny_text_bbcode_textlist_text'],
   "TEXTLIST_EXPLAIN" => $lang['Deny_text_bbcode_textlist_explain'],
   "POST_RESTRICTION_TEXT" => $lang['Deny_text_bbcode_restriction_text'],
   "POST_RESTRICTION_EXPLAIN" => $lang['Deny_text_bbcode_restriction_explain'],

   "STATUS_ENABLED" => $status_enabled,
   "STATUS_DISABLED" => $status_disabled,
   "BBCODE_ENABLED" => $bbcode_enabled,
   "BBCODE_DISABLED" => $bbcode_disabled,
   "TEXTLIST" => $text_list,
   "POST_RESTRICTION" => $post_restrict,

   "L_TEXT" => $lang['Deny_text_bbcode_text'],
   "L_ACTION" => $lang['Deny_text_bbcode_action_text'],
   "L_DELETE" => $lang['Delete'],
   "TEXT_TITLE" => $lang['Deny_text_bbcode_add_text'],

   "ENABLED_TEXT" => $lang['Deny_text_bbcode_enabled'],
   "DISABLED_TEXT" => $lang['Deny_text_bbcode_disabled'],
   "SUBMIT" => $lang['Deny_text_bbcode_submit'],
   "UPDATE" => $lang['Deny_text_bbcode_update'],
   "RESET" => $lang['Deny_text_bbcode_reset'],
   "DENY_TEXT_BBCODE_ACTION" => append_sid("admin_deny_text_and_bbcode.$phpEx"))
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);


// Updates the DB
function update_db ($field, $value) {
   global $db;

   $update_sql = "UPDATE " . CONFIG_TABLE . "
                  SET config_value = '$value'
                  WHERE config_name = '$field'";

   if ( !($result = $db->sql_query($update_sql)) ) {
      message_die(GENERAL_ERROR, 'Could not update config table', '', __LINE__, __FILE__, $update_sql);
   }
}

?>