<?php
/***************************************************************************
 *                                ezdloads.php
 *                            -------------------
 *   begin                : Tuesday, September 7, 2004
 *   copyright            : (C) 2004 HerrBawl Technologies
 *   email                : admin@herrbawl.com
 *
 *   $Id: downloads.php,v 1.0.0 2004/09/07, 18:42:00 HerrBawl $
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
 
 /***************************************************************************
 *
 *   Alot of this code I borrowed from Smartor's ezPortal (smartor.is-root.com)
 *
 ***************************************************************************/

// Download Forum ID: separate by comma for multi-forums, eg. '1,2,5'
$CFG['dload_forum'] = '1';

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

if( $userdata['session_logged_in'] )
{
	$sql = "SELECT COUNT(post_id) as total
			FROM " . POSTS_TABLE . "
			WHERE post_time >= " . $userdata['user_lastvisit'];
	$result = $db->sql_query($sql);
	if( $result )
	{
		$row = $db->sql_fetchrow($result);
		$lang['Search_new'] = $lang['Search_new'] . "&nbsp;(" . $row['total'] . ")";
	}
}

$page_title = $lang['Downloads'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'ezdloads_body.tpl')
);

$template->assign_vars(array(
	'CAT_FLNAM' => $lang['File_Name'],
	'CAT_FDESC' => $lang['File_Description'],
	'CAT_FDATE' => $lang['Uploaded_On'],
	'CAT_DLCNT' => $lang['Download_Count'],
	'CAT_FCOMM' => $lang['View_File_Comments'],
	'CAT_FCADD' => $lang['Add_File_Comments'])
);

function phpbb_fetch_forum_names($fids)
{
	global $db;
	
	$sql = 'SELECT `forum_id` , `forum_name` ';
	$sql .= 'FROM `' . FORUMS_TABLE . '` ';
	$sql .= 'WHERE `forum_id` IN (' . $fids . ')';
	
	$result = $db->sql_query($sql);
	
	$forums = array();
		
	if ($row = $db->sql_fetchrow($result))
	{
		$i = 0;
		do
		{
			$forums[$i]['forum_id'] = $row['forum_id'];
			$forums[$i]['forum_name'] = $row['forum_name'];
			$i++;
		}
		while ($row = $db->sql_fetchrow($result));
	};
	
	return $forums;
};

function phpbb_fetch_posts($fid)
{
	global $db, $board_config;
	
	$sql = 'SELECT
			  t.topic_id,
			  t.topic_time,
			  t.topic_title,
			  u.user_id,
			  t.topic_replies,
			  t.forum_id,
			  t.topic_poster,
			  t.topic_first_post_id,
			  t.topic_status,
			  pt.post_id,
			  p.post_id
			FROM
			  ' . TOPICS_TABLE . ' AS t,
			  ' . USERS_TABLE . ' AS u,
			  ' . POSTS_TEXT_TABLE . ' AS pt,
			  ' . POSTS_TABLE . ' AS p
			WHERE
			  t.forum_id = ' . $fid . ' AND
			  t.topic_time <= ' . time() . ' AND
			  t.topic_poster = u.user_id AND
			  t.topic_first_post_id = pt.post_id AND
			  t.topic_first_post_id = p.post_id AND
			  t.topic_status <> 2
			ORDER BY
			  t.topic_time DESC';
			 
	if(!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not query announcements information', '', __LINE__, __FILE__, $sql);
	}
	$posts = array();
	if ($row = $db->sql_fetchrow($result))
	{
		$i = 0;
		do
		{
			$posts[$i]['post_id'] = $row['post_id'];
			$posts[$i]['topic_title'] = $row['topic_title'];
			$posts[$i]['topic_id'] = $row['topic_id'];
			$i++;
		}
		while ($row = $db->sql_fetchrow($result));
	}
	return $posts;
};

function phpbb_fetch_attach_id($id)
{
	global $db;
	
	$sql = 'SELECT `attach_id` , `post_id` ';
	$sql .= 'FROM `' . ATTACHMENTS_TABLE . '` ';
	$sql .= 'WHERE `post_id` = ' . $id;
	
	$result = $db->sql_query($sql);
	
	$aid = array();
		
	if ($row = $db->sql_fetchrow($result))
	{
		$i = 0;
		do
		{
			$aid[$i]['attach_id'] = $row['attach_id'];
			$i++;
		}
		while ($row = $db->sql_fetchrow($result));
	};
	
	return $aid;
};

function phpbb_fetch_attach_info($aid)
{
	global $db;
	
	$sql = 'SELECT `attach_id` , `comment` , `download_count` , `real_filename` , `filetime` ';
	$sql .= 'FROM `' . ATTACHMENTS_DESC_TABLE . '` ';
	$sql .= 'WHERE `attach_id` = ' . $aid;
	
	$result = $db->sql_query($sql);
	
	$myattach = $db->sql_fetchrow($result);
	
	return $myattach;
};

if(!isset($HTTP_GET_VARS['article']))
{
	$none = true;
	
	$myforums = phpbb_fetch_forum_names($CFG['dload_forum']);
	
	for ($fi = 0; $fi < count($myforums); $fi++)
	{
		$myforums[$fi]['posts'] = phpbb_fetch_posts($myforums[$fi]['forum_id']);
		
		$cat = false;
		
		for ($pi = 0; $pi < count($myforums[$fi]['posts']); $pi++)
		{
			$myforums[$fi]['posts'][$pi]['attachs'] = phpbb_fetch_attach_id($myforums[$fi]['posts'][$pi]['post_id']);
			if (count($myforums[$fi]['posts'][$pi]['attachs']) > 0)
			{
				if (!$cat)
				{
					$template->assign_block_vars('download_cat', array(
						'CATNAME' => $myforums[$fi]['forum_name'])
					);
					$cat = true;
				};				
				$template->assign_block_vars('download_cat.sub', array(
					'TITLE' => $myforums[$fi]['posts'][$pi]['topic_title'],
					'U_VIEW_COMMENTS' => append_sid('viewtopic.' . $phpEx . '?t=' . $myforums[$fi]['posts'][$pi]['topic_id']))
				);
				for ($ai = 0; $ai < count($myforums[$fi]['posts'][$pi]['attachs']); $ai++)
				{
					$myforums[$fi]['posts'][$pi]['attachs'][$ai]['info'] = phpbb_fetch_attach_info($myforums[$fi]['posts'][$pi]['attachs'][$ai]['attach_id']);
					$template->assign_block_vars('download_cat.sub.DLs', array(
						'NAME' => $myforums[$fi]['posts'][$pi]['attachs'][$ai]['info']['real_filename'],
						'DESC' => $myforums[$fi]['posts'][$pi]['attachs'][$ai]['info']['comment'],
						'DLCT' => $myforums[$fi]['posts'][$pi]['attachs'][$ai]['info']['download_count'],
						'TIME' => create_date($board_config['default_dateformat'], $myforums[$fi]['posts'][$pi]['attachs'][$ai]['info']['filetime'], $board_config['board_timezone']),
						'LINK' => append_sid('download.' . $phpEx . '?id=' . $myforums[$fi]['posts'][$pi]['attachs'][$ai]['attach_id']))			
					);
					if ( $userdata['session_logged_in'] ) 
					{
						if (count($myforums[$fi]['posts'][$pi]['attachs']) > 0)
						{
							$template->assign_block_vars('download_cat.sub.DLs.LOGGEDIN', array());
						};
					};
				};
				if ( $userdata['session_logged_in'] ) 
				{
					$template->assign_block_vars('download_cat.sub.LOGGEDIN', array());
				};
				$none = false;
			};	
		};	
	};
	if ($none)
	{
		$template->assign_block_vars('download_none', array(
			'NONE' => $lang['No_Downloads'])
		);
	};
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>