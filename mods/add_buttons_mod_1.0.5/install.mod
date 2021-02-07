##############################################################
## MOD Title: Add Announcement and Sticky Buttons
## MOD Author: tehbmwman < tehbmwman@gmail.com > (N/A) N/A
## MOD Description: It will add buttons to make a topic an announcement or sticky
##					next to the moderater buttons at the bottom. There is also a
##					button to make the topic normal if it is stickied or an announcement.
## MOD Version: 1.0.5
##
## Installation Level: Easy
## Installation Time: ~5 Minutes
## Files To Edit: viewtopic.php,
##      		  modcp.php,
##      		  /templates/subSilver/subSilver.cfg,
##				  /language/lang_english/lang_main.php
##
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: This mod will add buttons next to the delete, move, lock, and split buttons
##				 to change a topic's status as a normal, stickied, or announcement topic.
##				 If the topic is normal, you will see a sticky and announcement button.
##				 If the topic is a sticky, you will see a normal and announcement button.
##				 If the topic is an announcement, you will see a normal and sticky button.
##
##############################################################
## MOD History:
##
##   2005-11-19 - Version 1.0.0
##      - Initial Release
##   2005-11-25 - Version 1.0.3
##		- Accepted into Mod DB
##	 2005-12-20 - Version 1.0.4
##		-Fixed slight bug, added NightriderXP's mod to change the
##		 images in the pack.
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]------------------------------------------
#
$images['topic_mod_delete'] = "$current_template_images/topic_delete.gif";
#
#-----[ AFTER, ADD ]------------------------------------
#
$images['topic_mod_sticky'] = "$current_template_images/folder_sticky.gif";
$images['topic_mod_announce'] = "$current_template_images/folder_announce.gif";
$images['topic_mod_normal'] = "$current_template_images/folder.gif";
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=split&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_split'] . '" alt="' . $lang['Split_topic'] . '" title="' . $lang['Split_topic'] . '" border="0" /></a>&nbsp;';
#
#-----[ AFTER, ADD ]------------------------------------
#
 switch($forum_topic_data['topic_type'])
   {   
      case 0:
            $topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=sticky&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_sticky'] . '" alt="' . $lang['Mark_sticky'] . '" title="' . $lang['Mark_sticky'] . '" border="0" /></a>&nbsp;';
            $topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=announce&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_announce'] . '" alt="' . $lang['Mark_announce'] . '" title="' . $lang['Mark_announce'] . '" border="0" /></a>&nbsp;';
            break;
         
      case 1:
            $topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=normal&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_normal'] . '" alt="' . $lang['Mark_normal'] . '" title="' . $lang['Mark_normal'] . '" border="0" /></a>&nbsp;';
            $topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=announce&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_announce'] . '" alt="' . $lang['Mark_announce'] . '" title="' . $lang['Mark_announce'] . '" border="0" /></a>&nbsp;';
            break;
            
      case 2:
            $topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=normal&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_normal'] . '" alt="' . $lang['Mark_normal'] . '" title="' . $lang['Mark_normal'] . '" border="0" /></a>&nbsp;';
            $topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=sticky&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_sticky'] . '" alt="' . $lang['Mark_sticky'] . '" title="' . $lang['Mark_sticky'] . '" border="0" /></a>&nbsp;';
            break;
   }
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Post_Normal'] = 'Normal';
#
#-----[ AFTER, ADD ]------------------------------------
#
$lang['Topic_announce'] = 'The topic has been marked as an announcement.';
$lang['Topic_sticky'] = 'The topic has been stickied.';
$lang['Topic_normal'] = 'The topic has been marked as normal.';
$lang['Mark_announce'] = 'Mark topic announcement';
$lang['Mark_sticky'] = 'Mark topic sticky';
$lang['Mark_normal'] = 'Mark topic normal';
#
#-----[ OPEN ]------------------------------------------
#
modcp.php
#
#-----[ FIND ]------------------------------------------
#
$unlock = ( isset($HTTP_POST_VARS['unlock']) ) ? TRUE : FALSE;
#
#-----[ AFTER, ADD ]------------------------------------
#
$sticky = ( isset($HTTP_POST_VARS['sticky']) ) ? TRUE : FALSE;
$announce = ( isset($HTTP_POST_VARS['announce']) ) ? TRUE : FALSE;
#
#-----[ FIND ]------------------------------------------
#
else if ( $unlock )
#
#-----[ BEFORE, ADD ]------------------------------------
#
else if ( $sticky )
	{
		$mode = 'sticky';
	}
else if ( $announce )
	{
		$mode = 'announce';
	}
#
#-----[ FIND ]------------------------------------------
#
case 'delete':
#
#-----[ BEFORE, ADD ]------------------------------------
#
#
case 'normal':
	if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}
		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_type = 0 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topic_normal'] . '<br /><br />' . $message);

		break;
case 'sticky':
	if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}
		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_type = 1 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topic_sticky'] . '<br /><br />' . $message);

		break;
	case 'announce':
	if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}
		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_type = 2 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topic_announce'] . '<br /><br />' . $message);

		break;
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM