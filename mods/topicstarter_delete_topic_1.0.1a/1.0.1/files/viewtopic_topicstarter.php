<?php
// Ramon Fincken, Phpbbinstallers.com
// Topicstarter delete own topic
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}
	$sql = "SELECT t.topic_poster
		FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f" . $join_sql_table . "
		WHERE $join_sql
			AND f.forum_id = t.forum_id
			$order_sql";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain topic information", '', __LINE__, __FILE__, $sql);
	}
	
	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_topic_data['topic_poster'] = $row['topic_poster']; 	
	}      
	$topicstarter_mod = '';
	if($forum_topic_data['topic_poster'] == $userdata['user_id'])
	{
	 	$topicstarter_mod = "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;';  
		$topic_mod = $topicstarter_mod;
	}
?>