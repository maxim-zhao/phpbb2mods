<?php
/***************************************************************************
 *                            pm_quickreply.php
 *                          ------------------------
 *     begin                : Sat Jun 3 2006
 *     copyright            : (C) 2006 Swatquest
 *   $Id: pm_quick_reply.php,v 1.3.5 2004/01/06 22:02:20 Rondom Exp $
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
if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}
//
// Debug Mode
$debug = False;
// 

if ( $debug || $privmsg['privmsgs_from_userid'] = $userdata['user_id'] )
{
			$template->set_filenames(array(
				'pm_quickreply_output' => 'pm_quickreply.tpl')
				);

   
   $s_hidden_fields = '
	<input type="hidden" name="folder" value="'.$folder.'" />
	<input type="hidden" name="mode" value="post" />
	<input type="hidden" name="username" value="' . $privmsg['username_1'] . '" />
	<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

   $template->assign_block_vars('PM_QUICKREPLY', array(
      'POST_ACTION' => append_sid("privmsg.$phpEx"),
      'S_HIDDEN_FIELDS' => $s_hidden_fields,
      'SUBJECT' => ( ( !preg_match('/^Re:/', $privmsg['privmsgs_subject']) ) ? 'Re: ' : '' ) . $privmsg['privmsgs_subject'],
      'S_HTML_CHECKED' => ( !$userdata['user_allowhtml'] ) ? ' checked="checked"' : '',
      'S_BBCODE_CHECKED' => ( !$userdata['user_allowbbcode'] ) ? ' checked="checked"' : '',
      'S_SMILIES_CHECKED' => ( !$userdata['user_allowsmile'] ) ? ' checked="checked"' : '',
      'S_SIG_CHECKED' => ( $userdata['user_attachsig'] ) ? ' checked="checked"' : ''
      ));

if ( $board_config['allow_html'] ){
   $template->assign_block_vars('PM_QUICKREPLY.HTMLPMRP', array());
   }
if ( $board_config['allow_bbcode'] )
{
   $template->assign_block_vars('PM_QUICKREPLY.BBCODEPMRP', array());
   if ( $userdata['user_pm_quickreply_bbcode'] ){
     $template->assign_block_vars('PM_QUICKREPLY.BBCODEBUTTON', array());
	 }
}
if ( $board_config['allow_smilies'] )
{
   $template->assign_block_vars('PM_QUICKREPLY.SMILIESPMRP', array());
    if ( $userdata['user_pm_quickreply_smilies_ed'] ){
   generate_smilies_row();
   }
}


   $template->assign_vars(array(
      'U_MORE_SMILIES' => append_sid("posting.$phpEx?mode=smilies"),
      'L_EMPTY_MESSAGE' => $lang['Empty_message'],
      'L_PREVIEW' => $lang['Preview'],
      'L_SUBMIT' => $lang['Submit'],
      'L_CANCEL' => $lang['Cancel'],
      'L_OPTIONS' => $lang['Pm_Options'],
      'L_ATTACH_SIGNATURE' => $lang['Pm_Attach_signature'],
      'L_DISABLE_HTML' => $lang['Pm_Disable_HTML_post'],
      'L_DISABLE_BBCODE' => $lang['Pm_Disable_BBCode_post'],
      'L_DISABLE_SMILIES' => $lang['Pm_Disable_Smilies_post'],
      'L_ALL_SMILIES' => $lang['Pm_smilies'],
      'L_QUOTE_SELECTED' => $lang['Pm_QuoteSelelected'],
      'L_NO_TEXT_SELECTED' => $lang['Pm_QuoteSelelectedEmpty'],
	  'L_QUICK_REPLY' => $lang['Pm_Quick_Reply'],
	  'L_SUBJECT' => $lang['Subject'],
      'L_EMPTY_MESSAGE' => $lang['Empty_message'],
      'L_EMPTY_SUBJECT' => $lang['Empty_subject'],
      'L_ERROR' => $lang['Error'],
      'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
	  'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
	  'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
	  'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
	  'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
	  'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
	  'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
	  'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
	  'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
	  'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
	  'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
	  'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
      'L_BBCODE_Y_HELP' => $lang['bbcode_y_help'],
	  'L_EMPTY_MESSAGE' => $lang['Empty_message'],

	  'L_FONT_COLOR' => $lang['Font_color'],
	  'L_COLOR_DEFAULT' => $lang['color_default'],
	  'L_COLOR_DARK_RED' => $lang['color_dark_red'],
	  'L_COLOR_RED' => $lang['color_red'],
	  'L_COLOR_ORANGE' => $lang['color_orange'],
	  'L_COLOR_BROWN' => $lang['color_brown'],
      'L_COLOR_YELLOW' => $lang['color_yellow'],
	  'L_COLOR_GREEN' => $lang['color_green'],
	  'L_COLOR_OLIVE' => $lang['color_olive'],
	  'L_COLOR_CYAN' => $lang['color_cyan'],
	  'L_COLOR_BLUE' => $lang['color_blue'],
	  'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'],
	  'L_COLOR_INDIGO' => $lang['color_indigo'],
	  'L_COLOR_VIOLET' => $lang['color_violet'],
	  'L_COLOR_WHITE' => $lang['color_white'],
	  'L_COLOR_BLACK' => $lang['color_black'],

	  'L_FONT_SIZE' => $lang['Font_size'],
	  'L_FONT_TINY' => $lang['font_tiny'],
	  'L_FONT_SMALL' => $lang['font_small'],
	  'L_FONT_NORMAL' => $lang['font_normal'],
	  'L_FONT_LARGE' => $lang['font_large'],
	  'L_FONT_HUGE' => $lang['font_huge'],

	  'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
	  'L_STYLES_TIP' => $lang['Styles_tip'])
				
	);

		$template->assign_var_from_handle('PM_QUICKREPLY_OUTPUT', 'pm_quickreply_output');
}

function generate_smilies_row()
{
   global $db, $board_config, $template;

   $max_smilies = $board_config['pm_quickreply_smilies'];

   switch ( SQL_LAYER )
   {
      case 'mssql':
         $sql = 'SELECT TOP ' . $max_smilies . 'min(emoticon) AS emoticon,
         min(code) AS code, smile_url
         FROM ' . SMILIES_TABLE . '
         GROUP BY [smile_url]';
      break;

      default:
         $sql = 'SELECT emoticon, code, smile_url
         FROM ' . SMILIES_TABLE . '
         GROUP BY smile_url
         ORDER BY smilies_id LIMIT ' . $max_smilies;
      break;
   }
   if (!$result = $db->sql_query($sql))
   {
      message_die(GENERAL_ERROR, "Couldn't retrieve smilies list", '', __LINE__, __FILE__, $sql);
   }
   $smilies_count = $db->sql_numrows($result);
   $smilies_data = $db->sql_fetchrowset($result);
   for ($i = 0; $i < $smilies_count; $i++)
   {
         $template->assign_block_vars('PM_QUICKREPLY.SMILIES', array(
            'CODE' => $smilies_data[$i]['code'],
            'URL' => $board_config['smilies_path'] . '/' . $smilies_data[$i]['smile_url'],
            'DESC' => $smilies_data[$i]['emoticon'])
         );
}
   $sql = 'SELECT COUNT(*) FROM ' . SMILIES_TABLE . '
           GROUP BY smile_url;';

   if (!$result = $db->sql_query($sql))
   {
      message_die(GENERAL_ERROR, "Couldn't count smilies", '', __LINE__, __FILE__, $sql);
   }
   $real_smilies_count = $db->sql_numrows($result);
   if ($real_smilies_count > $max_smilies || !$max_smilies)
   $template->assign_block_vars('PM_QUICKREPLY.MORESMILIES', array());
}
?>
