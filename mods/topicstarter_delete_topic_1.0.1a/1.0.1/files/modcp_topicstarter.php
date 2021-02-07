<?php                                               
// Ramon Fincken, Phpbbinstallers.com
// Topicstarter delete own topic
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}
if ( !$is_auth['auth_mod'] && $mode = 'delete') 
{
	$forum_topic_data = array();
	$sql = "SELECT t.topic_poster
		FROM " . TOPICS_TABLE . " t
		WHERE t.topic_id = ". $topic_id ." LIMIT 1";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain topic information", '', __LINE__, __FILE__, $sql);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_topic_data['topic_poster'] = $row['topic_poster']; 	
	}
	
	if(!($forum_topic_data['topic_poster'] == $userdata['user_id']))
	{
		message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
	}
	$is_auth['auth_mod'] = true;  
	$is_auth['auth_delete'] = true;
}
?>