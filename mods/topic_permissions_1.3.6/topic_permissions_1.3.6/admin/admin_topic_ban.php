<?php
/***************************************************************************
 *                            admin_topic_ban.php
 *                            -------------------
 *   begin                : Saturday, Mar 0f, 2005
 *   copyright            : swizec
 *   email                : iareswizec@hotmail.com
 *
 *
 ***************************************************************************/

define ( 'IN_PHPBB', 1 ); 

if ( !empty ( $setmodules) ) 
{ 
   $filename = basename(__FILE__); 
   $module [ 'topic_permissions' ][ 'Ban_control' ] = $filename; 
   
   return; 
}

// 
// Load default header 
// 
$no_page_header = TRUE; 
$phpbb_root_path = './../'; 
$admin_root = './';
require($phpbb_root_path . 'extension.inc'); 
require($admin_root . 'pagestart.' . $phpEx);

include($admin_root . '/page_header_admin.'.$phpEx);

//edit data if needed
if ( isset ( $HTTP_POST_VARS [ 'submit' ] ) ) {
	$hash = ( isset ( $HTTP_POST_VARS [ 'num_list' ] ) ) ? $HTTP_POST_VARS [ 'num_list' ] : array ( );
	for ( $i = 0; $i < count ( $hash ); $i++ ) {
		$desc = $HTTP_POST_VARS [ 'desc_list' ][ $i ];
		$desc = ( !empty ( $desc ) ) ? htmlspecialchars ( trim ( $desc ) ) : '';
		
		if ( empty ( $HTTP_POST_VARS [ 'id_list' ][ $i ] ) ) continue;
		else $id = intval ( $HTTP_POST_VARS [ 'id_list' ][ $i ] );
		
		$del = ( in_array ( $id, $HTTP_POST_VARS[ 'del_list' ] ) ) ? TRUE : FALSE;
		
		if ( !$del ) {
			$sql = "UPDATE " . TOPIC_BANS_TABLE . " SET " .
				"ban_desc = '" . str_replace ( "\'", "''", $desc ) . "' " .
				"WHERE id = '$id' LIMIT 1 ";
		}else{
			$sql = "DELETE FROM " . TOPIC_BANS_TABLE .
				" WHERE id = '$id' ".
				"LIMIT 1 ";
		}
		if ( !$result = $db -> sql_query ( $sql ) ) {
			message_die(CRITICAL_ERROR, "Could not edit ban data in admin_topic_ban", "", __LINE__, __FILE__, $sql);
		}
	}
	//if we got here everything went fine, output the message
	$message = $lang['ban_updated'] . "<br /><br />" . sprintf($lang['Click_return_tban'], "<a href=\"" . append_sid("admin_topic_ban.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}

//fetch data
$sql = "SELECT b.*, t.topic_title, u.username AS baner, uu.username AS banned " .
	"FROM " . TOPIC_BANS_TABLE . " b LEFT JOIN " . TOPICS_TABLE . " t ON b.topic_id = t.topic_id " .
	"LEFT JOIN " . USERS_TABLE . " u ON b.baner_id = u.user_id LEFT JOIN " . USERS_TABLE . " uu ON b.user_id = uu.user_id";
if(!$result = $db -> sql_query ( $sql ) ) {
	message_die(CRITICAL_ERROR, "Could not query topic ban information in admin_topic_ban", "", __LINE__, __FILE__, $sql);
}

if ( $db -> sql_numrows ( $result ) == 0 ) {
	$template -> assign_block_vars ( 'nobans', array ( ) );
}else{
	$template -> assign_block_vars ( 'arebans', array ( ) );
	$i = 0;
	while ( $row = $db -> sql_fetchrow ( $result ) ) {
		$template -> assign_block_vars ( 'banrow', array (
			'U_VIEW_TOPIC' => append_sid ( $phpbb_root_path . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $row [ 'topic_id' ] ),
			'U_BANER' => append_sid ( $phpbb_root_path . "profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=". $row [ 'baner_id' ] ),
			'U_BANNED' => append_sid ( $phpbb_root_path . "profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=". $row [ 'user_id' ] ),
	
			'TOPIC_TITLE' => $row [ 'topic_title' ],
			'BANER' => $row [ 'baner' ],
			'BANNED' => $row [ 'banned' ],
			'DESC' => stripslashes( $row [ 'ban_desc' ] ),
			'ID' => $row [ 'id' ],
			'NUM' => $i
		) );
		$i++;
	}
}

$template -> set_filenames ( array ( 
	'body' => 'admin/topic_ban_body.tpl' 
	) );
	
//pass vars to template
$template -> assign_vars ( array (
	'L_CONFIGURATION_TITLE' => $lang [ 'tban_config' ],
	'L_CONFIGURATION_EXPLAIN' => $lang [ 'tban_config_explain' ],
	'L_BAN_CONFIG' => $lang [ 'tban_config' ],
	'L_SUBMIT' => $lang [ 'Submit' ],
	'L_RESET' => $lang [ 'Reset' ],
	'L_TOPICS' => $lang [ 'Topics' ],
	'L_DELETE' => $lang [ 'Delete' ],
	'L_BANER' => $lang [ 'baner' ],
	'L_BANNED' => $lang [ 'banned' ],
	'L_DESC' => $lang [ 'tban_desc' ],
	'L_NOBANS' => $lang [ 'nobans' ],
	
	'S_CONFIG_ACTION' => append_sid ( "admin_topic_ban.$phpEx" )
) );
	
//output page

$template -> pparse ( 'body' );

include($admin_root . 'page_footer_admin.'.$phpEx);

?>