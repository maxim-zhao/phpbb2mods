<?php

/***************************************************************************
 *
 * listavatars.php
 * http://www.1-4a.com
 *
 * Demo:
 * http://www.in-my-opinion.org/listavatars.php
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);


$lang_file = $phpbb_root_path.'language/lang_'.$board_config['default_lang'].'/lang_listavatars.'.$phpEx;
if (!@file_exists($lang_file)) // load English version if there is no translation to current language
	{
	$lang_file = $phpbb_root_path.'language/lang_english/lang_listavatars.'.$phpEx;
	}
include($lang_file);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

function addavatar($avatar,$typ,$avatars,$counter)
	{
	global $board_config,$lang;
	
	if ($avatar == '')
		{
		return  $avatars;
		}
	
	switch ($typ)
		{
		CASE 1: $avatar = '"'.$phpbb_root_path.$board_config['avatar_path'].'/'.$avatar.'"';break; // Uploaded Avatar
		CASE 2: $avatar = '"'.$avatar.'"';break; // Avatar on other server
		CASE 3: $avatar = '"'.$phpbb_root_path.$board_config['avatar_gallery_path'].'/'.$avatar.'"';break; // Avatar from the Forum's Avatar Galery
		}
	
	if (strpos($avatars,$avatar) > 0) 
		{
		return  $avatars;
		}
	else // Avatar not added yet -> Add it
		{
		return  $avatars.'<img src='.$avatar.' alt="'.$counter.' '.$lang['listavatars_timesused'].'"> ';
		}
	}

$sqlu=	' SELECT	DISTINCT u.user_id, u.username, user_posts, u.user_avatar, u.user_avatar_type '. // Get all users who have posted at least 1 post
	' FROM '.USERS_TABLE.' u, '.POSTS_TABLE.' p '.
	' WHERE		u.user_id <> '.ANONYMOUS.' '.
	'	and	u.user_id = p.poster_id '.
	' ORDER BY u.user_posts DESC ';
	
$resultuser = $db->sql_query($sqlu);
$i = 0;

while (($user = $db->sql_fetchrow($resultuser)) )
	{
	$i++;
	$avatars = '';
	$sql=	' SELECT	p.user_avatar, p.user_avatar_type, COUNT(p.user_avatar) as postcount '.   // Get all avatars for this user
		' FROM	'.POSTS_TABLE.' p '.
		' where 	p.poster_id = '.$user['user_id'].' '.
		' GROUP BY p.user_avatar ';
		' ORDER BY p.user_avatar ASC';
	
	
	if ($result = $db->sql_query($sql)) // Sticky Avatar Mod installed
		{
		while (($row = $db->sql_fetchrow($result)) ) // Cycle thru each Avatar
			{
			if ($row['user_avatar'] == '') // No Avatar used for these posts -> Use standard user avatar
				{
				$avatars = addavatar($user['user_avatar'],$user['user_avatar_type'],$avatars,$row['postcount']);
				}
			else // Sticky Avatar used for these posts
				{
				$avatars = addavatar($row['user_avatar'],$row['user_avatar_type'],$avatars,$row['postcount']);
				}
			
			}
		}
	else
		{
		$avatars = addavatar($user['user_avatar'],$user['user_avatar_type'],$avatars,$user['user_posts']);
		}
	
	if ($avatars != '') // Display user, if the user has at least 1 avatar
		{
		$template->assign_block_vars('avatarblock', array(
			'USERNAME' => $user['username'],
			'USERNAMELINK' => append_sid('profile.'.$phpEx.'?mode=viewprofile&amp;u='.$user['user_id']),
			'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
			'AVATARS' => $avatars
			)
			);
		}
	}


// Start output of page
$page_title = $lang['listavatars_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
$template->set_filenames(array(
	'listavatars' => 'listavatars.tpl')
);

$template->pparse('listavatars');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>