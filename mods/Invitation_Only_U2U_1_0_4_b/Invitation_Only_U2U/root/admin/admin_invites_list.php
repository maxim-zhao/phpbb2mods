<?php
/***************************************************************************
 *                              admin_invites_list.php
 *                            -------------------
 *   begin            : Friday, July 28, 2005
 *   version          : 1.0.4 $Date: 2006/07/09 16:50:33 $; $Revision: 1.2 $
 *   version          : 1.0.0 RC5
 *   copyright        : (C) 2005, Kellanved; based on phpBB2 by the phpBB group.
 *    
 *
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
	$file = basename(__FILE__);
	$module['Invitations']['Invitations_list'] = "$file"; //this might just as well be in invites_explore
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
 

include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/functions_invite.'.$phpEx);
//This page will come with two modes: a= the big list, with sort and stuff and b) an explorer Mode  
	$start = (isset($HTTP_GET_VARS['start'])) ? intval($HTTP_GET_VARS['start']) : 0;
 		 
	if (isset($HTTP_POST_VARS['sort_order']) ||   isset($HTTP_GET_VARS['sort_order']))
	{        
		$sort_order = $order= (isset($HTTP_GET_VARS['sort_order'])) ? intval($HTTP_GET_VARS['sort_order']) : intval($HTTP_POST_VARS['sort_order']);
	} 
	$ascdesc = 0; 
	if (!empty($HTTP_POST_VARS['sort_desc']) ||   !empty($HTTP_GET_VARS['sort_desc']))
	{         
		$sort_order = $sort_order * -1; //reverse the sort order - yes, that's a hack. so what?
		$ascdesc = 1;
	} 
	
    $template->set_filenames(array(
		'options' => 'admin/invite_list_options.tpl')
	);
    $sort_drop_box_data = array(
            array('order' => SORT_BY_INVITE_ID, 'selected' =>  (($order == SORT_BY_INVITE_ID) ? 'selected' : ''), 'lang' => $lang['Invitation_id']),
            array('order' => SORT_BY_USELS_LEFT, 'selected' =>  (($order == SORT_BY_USELS_LEFT) ? 'selected' : ''), 'lang' =>  $lang['Invitation_uses_left']),
            array('order' => SORT_BY_SENDER_NAME, 'selected' =>  (($order == SORT_BY_SENDER_NAME) ? 'selected' : ''), 'lang' =>  $lang['Invitation_sender_name']),
            array('order' => SORT_BY_USER_COUNT, 'selected' =>  (($order == SORT_BY_USER_COUNT) ? 'selected' : ''), 'lang' =>  $lang['Invitation_user_count']),
            array('order' => SORT_BY_INVITATION_GROUP, 'selected' =>  (($order == SORT_BY_INVITATION_GROUP) ? 'selected' : ''), 'lang' =>  $lang['Invitation_group'])
            );
    foreach ($sort_drop_box_data as $row)
    {
    	$template->assign_block_vars('sort_order', array(                
				'ORDER' => $row['order'],
				'SELECTED' => $row['selected'],
				'NAME' => $row['lang']  
                )
		);
    }
	
	
	$ascedsc_drop_box_data = array(
            array('order' => 0, 'selected' =>  (($ascdesc == 0) ? 'selected' : ''), 'lang' => $lang['Sort_Ascending']),
            array('order' => 1, 'selected' =>  (($ascdesc == 1) ? 'selected' : ''), 'lang' =>  $lang['Sort_Descending'])           
            );
    foreach ($ascedsc_drop_box_data as $row)
    {
    	$template->assign_block_vars('sort_ascdesc', array(                
				'ORDER' => $row['order'],
				'SELECTED' => $row['selected'],
				'NAME' => $row['lang']  
                )
		);
    }
	
 
	
	
	$invites_per_page = $board_config['topics_per_page'];

 
	$sql = 'SELECT count(invitation_id) as total FROM '.INVITATION_TABLE;

	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not count invites', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	$total_invites = $row['total'];
	$db->sql_freeresult($result);
	
	$template->assign_vars(array(
		'L_LIST_ALL_INVITES' => $lang['List_all_invites'],
		'L_LIST_ALL_INVITES_EXPLAIN' => $lang['List_all_invites_explain'],
		'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
		'L_ORDER' => $lang['Order'],
		'L_SORT' => $lang['Sort'],
		'S_INVITE_ACTION' => append_sid("admin_invites_list.$phpEx",true))
	);    
	$invite_rows = get_invites(0,0,$start,$invites_per_page, $sort_order);
	prepare_invitation_table($invite_rows, 'body', sprintf($lang['Page_of'], 
							( floor( $start / $invites_per_page ) + 1 ), 
							ceil( $total_invites / $invites_per_page )), 
							generate_pagination(append_sid("admin_invites_list.$phpEx?sort_desc=$ascdesc&amp;sort_order=".abs($sort_order),true), $total_invites, $invites_per_page, $start));  


	$template->pparse('options');
	$template->pparse('body');

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>