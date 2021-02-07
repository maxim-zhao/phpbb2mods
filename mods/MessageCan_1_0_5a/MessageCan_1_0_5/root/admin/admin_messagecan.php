<?php
//-------------------------
// admin_messagecan.php
// version: 1.0.4
// by bu(Buwei Chiu) 2005
//-------------------------

/* 
 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.
*/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['MessageCan'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Variables
//
$mode = (isset($HTTP_GET_VARS['mode']) ) ? str_replace("\'", "''", $HTTP_GET_VARS['mode']) : '';
$id=intval($HTTP_GET_VARS['id']);
$subject = ( !empty($HTTP_POST_VARS['subject']) ) ? htmlspecialchars(str_replace("\'", "''", trim($HTTP_POST_VARS['subject']))) : '';
$message = ( !empty($HTTP_POST_VARS['message']) ) ? htmlspecialchars(str_replace("\'", "''", trim($HTTP_POST_VARS['message']))) : '';

//
// Let's start
//
switch($mode) {
	case "edit":
		$template->set_filenames(array(
			'body' => 'admin/messagecan_edit.tpl')
		);

		$sql="SELECT *
				FROM ".MESSAGECAN_TABLE."
				WHERE msg_id=".$id;
		
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get message information', '', __LINE__, __FILE__, $sql);
		}

		while( $row = $db->sql_fetchrow($result)) {
			$template->assign_vars(array(
				'SUBJECT' => $row['msg_title'],
				'MESSAGE' => $row['msg_text'],
				'L_MODIFY' => $lang['MessageCan_Edit'],
				'L_SUBJECT' => $lang['Subject'],
				'L_MESSAGE_BODY' => $lang['Message_body'],
				'L_SUBMIT' => $lang['Submit'],
				'L_MESSAGE' => $lang['MessageCan_Message'],
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
				'L_STYLES_TIP' => $lang['Styles_tip'],
				'S_POST_ACTION' => append_sid("admin_messagecan.$phpEx?mode=editMessage&id=".$id),
				
				'MESSAGE_ID' => $row['msg_id'])
			);
		}

	break;
	case "add":
		$template->set_filenames(array(
			'body' => 'admin/messagecan_add.tpl')
		);

		$template->assign_vars(array(
			'L_MODIFY' => $lang['MessageCan_Add'],
			'L_SUBJECT' => $lang['Subject'],
			'L_MESSAGE_BODY' => $lang['Message_body'],
			'L_SUBMIT' => $lang['Submit'],
			'L_MESSAGE' => $lang['MessageCan_Message'],
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
			'L_STYLES_TIP' => $lang['Styles_tip'],
			'S_POST_ACTION' => append_sid("admin_messagecan.$phpEx?mode=addMessage"))
		);
	break;

	case "addMessage":
		$sql="INSERT INTO " . MESSAGECAN_TABLE ."
				SET msg_title='".$subject."',msg_text='".$message."'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not add message', '', __LINE__, __FILE__, $sql);
		}

		message_die(GENERAL_MESSAGE, sprintf($lang['MessageCan_Complete'],$lang['MessageCan_Addi'],'<a href="'.append_sid("admin_messagecan.$phpEx").'">','</a>'));
	break;

	case "editMessage":
		$sql="UPDATE " . MESSAGECAN_TABLE ."
				 SET msg_title='".$subject."',msg_text='".$message."'
				 WHERE msg_id=".$id;

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update message', '', __LINE__, __FILE__, $sql);
		}

		message_die(GENERAL_MESSAGE, sprintf($lang['MessageCan_Complete'],$lang['Update'],'<a href="'.append_sid("admin_messagecan.$phpEx").'">','</a>'));

	break;

	case "delConfirm":
		$template->set_filenames(array(
			'body' => 'admin/messagecan_delConfirm.tpl')
		);
		
		$sql="SELECT *
				FROM ".MESSAGECAN_TABLE."
				WHERE msg_id=".$id;
		
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get message information', '', __LINE__, __FILE__, $sql);
		}

		while( $row = $db->sql_fetchrow($result)) {
			$template->assign_vars(array(
				'L_MODIFY' => $lang['MessageCan_Delete'],
				'L_MESSAGE' => $lang['MessageCan_Message'],
				'ConfirmQuestion' => sprintf($lang['MessageCan_DelConfirm'],$row['msg_title']),
				'YES' =>$lang['MessageCan_Del_Yes'],
				'NO' =>$lang['MessageCan_Del_No'],
				'OKTOPROC' => append_sid("admin_messagecan.$phpEx?mode=OKToDel"),
				'RETURNTOPANEL' => append_sid("admin_messagecan.$phpEx"),
				'MESSAGE_ID' => $row['msg_id'])
			);
		}
	break;

	case "OKToDel":
		$id=$id;
		$sql="DELETE FROM " . MESSAGECAN_TABLE ."
				WHERE msg_id=".$id;
		
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete message', '', __LINE__, __FILE__, $sql);
		}

		message_die(GENERAL_MESSAGE, sprintf($lang['MessageCan_Complete'],$lang['Delete'],'<a href="'.append_sid("admin_messagecan.$phpEx").'">','</a>'));
	break;
	
	default:
		$template->set_filenames(array(
			'body' => 'admin/messagecan_body.tpl')
		);

		$sql="SELECT *
				FROM ".MESSAGECAN_TABLE."
				ORDER BY msg_id";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not list message(s)', '', __LINE__, __FILE__, $sql);
		}

		while( $row = $db->sql_fetchrow($result) )
		{
			$template->assign_block_vars('messagecan', array(
				'MESSAGE_ID'=> $row['msg_id'],
				'MESSAGE_TITLE'=> $row['msg_title'],
				'MESSAGE_TEXT'=> $row['msg_text'])
				);
		}

		$template->assign_vars(array(
			'L_MESSAGECAN'=>$lang['MessageCan'],
			'L_MESSAGECAN_DESC' => $lang['MessageCan_Desc'],
			'L_ADD_MESSAGE' => $lang['MessageCan_Add'],
			'L_EDIT_MESSAGE' => $lang['MessageCan_EditAction'],
			'L_DEL_MESSAGE' => $lang['MessageCan_DeleteAction'],
			'L_MESSAGE' => $lang['MessageCan_Message'],
			'L_MESSAGE_TEXT' => $lang['MessageCan_Text'],
			'L_ACTION' => $lang['MessageCan_Action'],
			'S_MSGACP_ADD' => append_sid("admin_messagecan.$phpEx?mode=add"),
			'S_MSGACP_EDIT' => append_sid("admin_messagecan.$phpEx?mode=edit"),
			'S_MSGACP_DEL' => append_sid("admin_messagecan.$phpEx?mode=delConfirm"))
		);

	break;
}

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

//------------------
// End  (c)bu 2005
//------------------
?>