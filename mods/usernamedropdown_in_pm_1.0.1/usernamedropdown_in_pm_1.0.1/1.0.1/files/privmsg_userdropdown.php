<?php
// Ramon Fincken, Username dropdown in PM
// Phpbbinstallers.com  

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$sql_drpdwn = "SELECT user_id, username from " . USERS_TABLE .  
					" WHERE user_id != ". ANONYMOUS  ." AND user_id != ".$userdata['user_id'] . 
					" GROUP BY username";
// fetch
if ( !($result_drpdwn = $db->sql_query($sql_drpdwn)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain users information', '', __LINE__, __FILE__, $sql_drpdwn);
}

$output_dropdown = '<select size="1" name="username">';
while ( $row_drpdwn = $db->sql_fetchrow($result_drpdwn) )
{	
	if($to_username === $row_drpdwn['username']) 
	{ 
		$sel = ' selected="selected"';
	} 
	else 
	{ 
		$sel = ''; 
	}
	$output_dropdown .= '<option value="'.$row_drpdwn['username'].'"'. $sel . '>'.$row_drpdwn['username'].'</option>';
}
$db->sql_freeresult($result_drpdwn);
$output_dropdown .= '	</select>';                                                   
?>