<?php
/***************************************************************************
 *                           admin_resync_forum_ids.php
 *                           -----------------------
 *	Author			:	Manipe - admin@manipef1.com - http://www.manipef1.com
 *	Created			:	Wednesday, August 24, 2005
 *	Modified		:	Friday, September 02, 2005
 *
 *	Version			:	1.0.1
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Forums']['Resync_forum_ids'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

if ($HTTP_POST_VARS['confirmed'] == 'yes')
{
	if (!$HTTP_POST_VARS['resync_forum_ids'] && !$HTTP_POST_VARS['resync_category_ids'])
	{
		message_die(GENERAL_MESSAGE, $lang['Must_select_resync'] . "<br /><br />" . sprintf($lang['Click_return_resync_index'], "<a href=\"" . append_sid("admin_resync_forum_ids.$phpEx") . "\">", "</a>"));
	}
	//
	// Do the Major work
	//
	if ($HTTP_POST_VARS['resync_forum_ids'])
	{
		// Get old Forum ids
		$sql_big = "SELECT f.*
			FROM " . FORUMS_TABLE . " AS f, " . CATEGORIES_TABLE . " AS c
			WHERE f.cat_id = c.cat_id
			ORDER BY c.cat_order, f.forum_order";
		if ( !($result_big = $db->sql_query($sql_big)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not get forum id information', '', __LINE__, __FILE__, $sql);
		}

		// Delete all info from phpbb_forums
		$sql = "TRUNCATE " . FORUMS_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not delete forum info', '', __LINE__, __FILE__, $sql);
		}

		// phpbb_auth_access
		$sql = "ALTER TABLE " . AUTH_ACCESS_TABLE . "
			ADD resynced SMALLINT (1) DEFAULT '0' NOT NULL";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not add new column', '', __LINE__, __FILE__, $sql);
		}

		// phpbb_prune_forum
		$sql = "ALTER TABLE " . PRUNE_TABLE . "
			ADD resynced SMALLINT (1) DEFAULT '0' NOT NULL";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not add new column', '', __LINE__, __FILE__, $sql);
		}

		// phpbb_posts
		$sql = "ALTER TABLE " . POSTS_TABLE . "
			ADD resynced SMALLINT (1) DEFAULT '0' NOT NULL";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not add new column', '', __LINE__, __FILE__, $sql);
		}

		// phpbb_topics
		$sql = "ALTER TABLE " . TOPICS_TABLE . "
			ADD resynced SMALLINT (1) DEFAULT '0' NOT NULL";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not add new column', '', __LINE__, __FILE__, $sql);
		}

		while($row_big = $db->sql_fetchrow($result_big))
		{
			unset($columns, $values);
			$new_forum_id += 1;
			$old_forum_id = $row_big['forum_id'];

			for($j=0;$j<$db->sql_numfields($result_big);$j++)
			{
				$field_name = $db->sql_fieldname($j, $result_big);
				$columns .= ($j==0)?"":", ";
				$columns .= $field_name;

				$values .= ($j==0)?"":", ";
				$values .= "'" . (($field_name == 'forum_id')?$new_forum_id:str_replace("'", "\\'", $row_big[$field_name])) . "'";
			}

			$sql = "INSERT INTO " . FORUMS_TABLE . "($columns)
				VALUES($values)";
			if ( !($result = $db->sql_query($sql)) )
			{
			 	message_die(GENERAL_ERROR, 'Could not insert data into forums table', '', __LINE__, __FILE__, $sql);
			}

			// Check to see if forum already has proper id
			if ($new_forum_id == $old_forum_id)
			{
				continue;
			}

			// phpbb_auth_access
			$sql = "UPDATE " . AUTH_ACCESS_TABLE . "
				SET forum_id = $new_forum_id, resynced = 1
				WHERE forum_id = $old_forum_id
					AND resynced = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
			 	message_die(GENERAL_ERROR, 'Could not update Auth Access Table', '', __LINE__, __FILE__, $sql);
			}

			// phpbb_prune_forum
			$sql = "UPDATE " . PRUNE_TABLE . "
				SET forum_id = $new_forum_id, resynced = 1
				WHERE forum_id = $old_forum_id
					AND resynced = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
			 	message_die(GENERAL_ERROR, 'Could not update Prune Forums Table', '', __LINE__, __FILE__, $sql);
			}

			// phpbb_posts
			$sql = "UPDATE " . POSTS_TABLE . "
				SET forum_id = $new_forum_id, resynced = 1
				WHERE forum_id = $old_forum_id
					AND resynced = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
			 	message_die(GENERAL_ERROR, 'Could not update Posts Table', '', __LINE__, __FILE__, $sql);
			}

			// phpbb_topics
			$sql = "UPDATE " . TOPICS_TABLE . "
				SET forum_id = $new_forum_id, resynced = 1
				WHERE forum_id = $old_forum_id
					AND resynced = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
			 	message_die(GENERAL_ERROR, 'Could not update Topics Table', '', __LINE__, __FILE__, $sql);
			}
		}

		// phpbb_auth_access
		$sql = "ALTER TABLE " . AUTH_ACCESS_TABLE . "
			DROP resynced";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not drop new column', '', __LINE__, __FILE__, $sql);
		}

		// phpbb_prune_forum
		$sql = "ALTER TABLE " . PRUNE_TABLE . "
			DROP resynced";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not drop new column', '', __LINE__, __FILE__, $sql);
		}

		// phpbb_posts
		$sql = "ALTER TABLE " . POSTS_TABLE . "
			DROP resynced";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not drop new column', '', __LINE__, __FILE__, $sql);
		}

		// phpbb_topics
		$sql = "ALTER TABLE " . TOPICS_TABLE . "
			DROP resynced";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not drop new column', '', __LINE__, __FILE__, $sql);
		}

		$db->sql_freeresult($result_big);
	}

	if ($HTTP_POST_VARS['resync_category_ids'])
	{
		$sql_big = "SELECT *
			FROM " . CATEGORIES_TABLE . "
			ORDER BY cat_order";
		if ( !($result_big = $db->sql_query($sql_big)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not get category id information', '', __LINE__, __FILE__, $sql_big);
		}

		// Delete all info from phpbb_categories
		$sql = "TRUNCATE " . CATEGORIES_TABLE;
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not delete category info', '', __LINE__, __FILE__, $sql);
		}

		// phpbb_forums
		$sql = "ALTER TABLE " . FORUMS_TABLE . "
			ADD resynced SMALLINT (1) DEFAULT '0' NOT NULL";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not add new column', '', __LINE__, __FILE__, $sql);
		}

		while($row_big = $db->sql_fetchrow($result_big))
		{
			unset($columns, $values);
			$new_category_id += 1;
			$old_category_id = $row_big['cat_id'];

			for($j=0;$j<$db->sql_numfields($result_big);$j++)
			{
				$field_name = $db->sql_fieldname($j, $result_big);
				$columns .= ($j==0)?"":", ";
				$columns .= $field_name;

				$values .= ($j==0)?"":", ";
				$values .= "'" . (($field_name == 'cat_id')?$new_category_id:str_replace("'", "\\'", $row_big[$field_name])) . "'";
			}

			// Insert the info again to phpbb_categories with new ids
			$sql = "INSERT INTO " . CATEGORIES_TABLE . "($columns)
				VALUES($values)";
			if ( !($result = $db->sql_query($sql)) )
			{
			 	message_die(GENERAL_ERROR, 'Could not update Categories Table', '', __LINE__, __FILE__, $sql);
			}

			if ($new_category_id == $old_category_id)
			{
				continue;
			}

			// phpbb_forums
			$sql = "UPDATE " . FORUMS_TABLE . "
				SET cat_id = $new_category_id, resynced = 1
				WHERE cat_id = $old_category_id
					AND resynced = 0";
			if ( !($result = $db->sql_query($sql)) )
			{
			 	message_die(GENERAL_ERROR, 'Could not update Forums Table', '', __LINE__, __FILE__, $sql);
			}
		}

		// phpbb_forums
		$sql = "ALTER TABLE " . FORUMS_TABLE . "
			DROP resynced";
		if ( !($result = $db->sql_query($sql)) )
		{
		 	message_die(GENERAL_ERROR, 'Could not drop new column', '', __LINE__, __FILE__, $sql);
		}

		$db->sql_freeresult($result_big);
	}


	if ($HTTP_POST_VARS['resync_forum_ids'] && $HTTP_POST_VARS['resync_category_ids'])
	{
		$message = $lang['Both_resynced'];
	}
	else if ($HTTP_POST_VARS['resync_forum_ids'])
	{
		$message = $lang['Forums_resynced'];
	}
	else if ($HTTP_POST_VARS['resync_category_ids'])
	{
		$message = $lang['Categories_resynced'];
	}

	if ($board_config['board_disable'])
	{
		$message .= "<br /><br />" . sprintf($lang['Click_enable_board'], "<a href=\"" . append_sid("admin_resync_forum_ids.$phpEx?disable_board=no") . "\">", "</a>");
	}
	$message .= "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}

if ($HTTP_GET_VARS['disable_board'] == 'yes')
{
	$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = 1
		WHERE config_name = 'board_disable'";
	if ( !($result = $db->sql_query($sql)) )
	{
	 	message_die(GENERAL_ERROR, 'Could not update board disabled information', '', __LINE__, __FILE__, $sql);
	}
	$board_config['board_disable'] = 1;
}
else if ($HTTP_GET_VARS['disable_board'] == 'no')
{
	$sql = "UPDATE " . CONFIG_TABLE . "
		SET config_value = 0
		WHERE config_name = 'board_disable'";
	if ( !($result = $db->sql_query($sql)) )
	{
	 	message_die(GENERAL_ERROR, 'Could not update board disabled information', '', __LINE__, __FILE__, $sql);
	}
	message_die(GENERAL_MESSAGE, $lang['Board_now_enabled'] . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>"));
}

$template->set_filenames(array(
	"body" => "admin/resync_forum_ids_body.tpl")
);


if ($board_config['board_disable'] == 0)
{
	$template->assign_block_vars("switch_board_disabled", array(
		"L_DISABLE_BOARD" => $lang['Resync_disable_board'],
		"L_DISABLE_BOARD_EXPLAIN" => $lang['Resync_disable_board_explain'],
		"L_DISABLE_BOARD_NOW" => sprintf($lang['Click_disable_board_now'], "<a href=\"" . append_sid("admin_resync_forum_ids.$phpEx?disable_board=yes") . "\">", "</a>"))
	);
}

$template->assign_vars(array(
	"S_RESYNC_ACTION" => append_sid("admin_resync_forum_ids.$phpEx"),
	"S_HIDDEN_FIELDS" => '<input type="hidden" name="confirmed" value="yes" />',

	"L_RESYNC_TITLE" => $lang['Resync_title'],
	"L_RESYNC_EXPLAIN" => $lang['Resync_explain'],
	"L_MUST_SELECT_RESYNC" => $lang['Must_select_resync'],
	"L_RESYNC_FORUM_CATEGORY_IDS" => $lang['Resync_forum_category_ids'],
	"L_SELECT_RESYNC" => $lang['Resync_select'],
	"L_RESYNC_FORUMS" => $lang['Resync_forums'],
	"L_RESYNC_CATEGORIES" => $lang['Resync_categories'],
	"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset'])
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);
?>