<?php
/***************************************************************************
 *                             clean_tables.php
 *                            -------------------
 *   begin                : Wednesday, Dec 15 2004
 *   copyright            : (C) 2004 - 2005 Vic D'Elfant
 *   email                : vic@phpbb.com
 *
 *   $Id: clean_tables.php,v 1.0.5 2005/12/15 19:46:00 Vic Exp $
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

define('IN_PHPBB', true);
$phpbb_root_path = './../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.' . $phpEx);

//
// Language
//
$lang['title'] = 'Clean phpBB SQL tables';
$lang['incompatible_dbms'] = 'This script will only work with MySQL';
$lang['explain'] = 'This script has generated a list with fieldnames in your phpBB SQL tables which have (probably) been created by MODs, as well as a list with all <i>tables</i> and phpBB configuration settings in your SQL database which could have been created by MODs.<br /><br />You can prevent a fieldname, table or configuration setting from being dropped by removing the check in front of that specific item. After you have made sure that no valuable fields, tables or configuration settings will be dropped you can click \'Clean tables\' to drop the selected items.<br /><br /><br /><b>Note that it is entirely your own responsibility to create a backup of your SQL database before running this script</b>';
$lang['unknown_fields'] = 'Unknown fieldnames';
$lang['unknown_tables'] = 'Unknown tables';
$lang['unknown_config'] = 'Unknown configuration settings';
$lang['no_fields_found'] = 'No unknown fieldnames have been found';
$lang['no_tables_found'] = 'No unknown tables have been found';
$lang['no_config_found'] = 'No unknown configuration settings have been found';
$lang['submit_button_caption'] = 'Clean tables';
$lang['cleaned_title'] = 'Cleaned succesfully';
$lang['cleaned_explain'] = '<b>Your tables have successfully been cleaned</b></span><br /><br />Now delete this file';

$cleaned = false;

if ( $dbms != 'mysql' && $dbms != 'mysql4' )
{
	message_die(GENERAL_MESSAGE, $lang['incompatible_dbms']);
	exit;
}

//
// $html class
//
class html
{
	var $table_name;

	function title($caption)
	{
		print '<tr><th colspan="2">' . $caption . '</th></tr>';
	}

	function header()
	{
		print '<tr>';
	}

	function table_name($table_name)
	{
		$this->table_name = $table_name;

		print '<td class="row1" align="left" valign="top" width="20%" style="padding-top: 5; padding-left: 5"><span class="genmed"><b>' . $table_name . '</b></span></td><td class="row2"><table width="100%" cellspacing="0" cellpadding="0" border="0">';
	}

	function right_row($type, $title)
	{
		if ( $type == 'field' )
		{
			print '<tr><td width="15"><input type="checkbox" name="' . $this->table_name . '__' . $title . '" checked="checked" value="1" /></td><td><span class="genmed">' . $title . '</span></td></tr>';
		}
		elseif ( $type == 'config' )
		{
			print '<tr><td width="15"><input type="checkbox" name="' . 'config__' . $title . '" checked="checked" value="1" /></td><td><span class="genmed">' . $title . '</span></td></tr>';
		}
		else
		{
			print '<tr><td width="15"><input type="checkbox" name="' . $title . '" checked="checked" value="1" /></td><td><span class="genmed">' . $title . '</span></td></tr>';
		}
	}

	function footer()
	{
		print '</table></td></tr>' . "\n";
	}
}

$html = new html();

//
// Did the user submitted the form?
//

if ( isset($HTTP_POST_VARS['submit']) )
{
	reset($HTTP_POST_VARS);
	while ( list($key, $value) = each($HTTP_POST_VARS) )
	{
		$key = htmlspecialchars(addslashes($key));
		$key = str_replace("\'", "''", $key);

		$value = intval($value);

		if ( $key != 'submit' )
		{
			// Drop a config setting
			if ( strstr($key, 'config__') && $value == 1 )
			{
				$field = substr($key, 8);

				$sql = "DELETE FROM " . CONFIG_TABLE . " WHERE config_name = '" . $field . "'";
				$result = $db->sql_query($sql);

				if ( !$result )
				{
					message_die(GENERAL_ERROR, "Failed dropping configuration setting '$field'", '', __LINE__, __FILE__, $sql);
				}
			}

			// Drop a field
			elseif ( strstr($key, '__') && $value == 1 )
			{
				$table = substr($key, 0, strpos($key, '__'));
				$field = substr($key, ( strpos($key, '__') + 2 ));

				$sql = "ALTER TABLE " . $table . " DROP " . $field;
				$result = $db->sql_query($sql);

				if ( !$result )
				{
					message_die(GENERAL_ERROR, "Failed dropping $table.$field", '', __LINE__, __FILE__, $sql);
				}
			}

			// Drop a table
			elseif ( $value == 1 )
			{
				$table = $key;

				$sql = "DROP TABLE " . $table;
				$result = $db->sql_query($sql);

				if ( !$result )
				{
					message_die(GENERAL_ERROR, "Failed dropping $table", '', __LINE__, __FILE__, $sql);
				}
			}
		}
	}

	$cleaned = true;
}

//
// This array holds the table names which are created by phpBB, as well as
// their fieldnames
//
$config_records = array('allow_autologin', 'allow_avatar_local', 'allow_avatar_remote', 'allow_avatar_upload', 'allow_bbcode', 'allow_html', 'allow_html_tags', 'allow_namechange', 'allow_sig', 'allow_smilies', 'allow_theme_create', 'avatar_filesize', 'avatar_gallery_path', 'avatar_max_height', 'avatar_max_width', 'avatar_path', 'board_disable', 'board_email', 'board_email_form', 'board_email_sig', 'board_startdate', 'board_timezone', 'config_id', 'cookie_domain', 'cookie_name', 'cookie_path', 'cookie_secure', 'coppa_fax', 'coppa_mail', 'default_dateformat', 'default_lang', 'default_style', 'enable_confirm', 'flood_interval', 'gzip_compress', 'hot_threshold', 'max_autologin_time', 'max_inbox_privmsgs', 'max_poll_options', 'max_savebox_privmsgs', 'max_sentbox_privmsgs', 'max_sig_chars', 'override_user_style', 'posts_per_page', 'privmsg_disable', 'prune_enable', 'record_online_date', 'record_online_users', 'require_activation', 'script_path', 'sendmail_fix', 'server_name', 'server_port', 'session_length', 'sitename', 'site_desc', 'smilies_path', 'smtp_delivery', 'smtp_host', 'smtp_password', 'smtp_username', 'topics_per_page', 'version', 'login_reset_time', 'max_login_attempts', 'rand_seed', 'search_flood_interval', 'search_min_chars');

$valid_fields = array(
	AUTH_ACCESS_TABLE => array('group_id', 'forum_id', 'auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_delete', 'auth_sticky', 'auth_announce', 'auth_vote', 'auth_pollcreate', 'auth_mod', 'auth_attachments'),
	BANLIST_TABLE => array('ban_id', 'ban_userid', 'ban_ip', 'ban_email'),
	CATEGORIES_TABLE => array('cat_id', 'cat_title', 'cat_order'),
	CONFIG_TABLE => array('config_name', 'config_value'),
	DISALLOW_TABLE => array('disallow_id', 'disallow_username'),
	FORUMS_TABLE => array('forum_id', 'cat_id', 'forum_name', 'forum_desc', 'forum_status', 'forum_order', 'forum_posts', 'forum_topics', 'forum_last_post_id', 'prune_next', 'prune_enable', 'auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_delete', 'auth_sticky', 'auth_announce', 'auth_vote', 'auth_pollcreate', 'auth_attachments'),
	GROUPS_TABLE => array('group_id', 'group_type', 'group_name', 'group_description', 'group_moderator', 'group_single_user'),
	POSTS_TABLE => array('post_id', 'topic_id', 'forum_id', 'poster_id', 'post_time', 'poster_ip', 'post_username', 'enable_bbcode', 'enable_html', 'enable_smilies', 'enable_sig', 'post_edit_time', 'post_edit_count'),
	POSTS_TEXT_TABLE => array('post_id', 'bbcode_uid', 'post_subject', 'post_text'),
	PRIVMSGS_TABLE => array('privmsgs_id', 'privmsgs_type', 'privmsgs_subject', 'privmsgs_from_userid', 'privmsgs_to_userid', 'privmsgs_date', 'privmsgs_ip', 'privmsgs_enable_bbcode', 'privmsgs_enable_html', 'privmsgs_enable_smilies', 'privmsgs_attach_sig'),
	PRIVMSGS_TEXT_TABLE => array('privmsgs_text_id', 'privmsgs_bbcode_uid', 'privmsgs_text'),
	PRUNE_TABLE => array('prune_id', 'forum_id', 'prune_days', 'prune_freq'),
	RANKS_TABLE => array('rank_id', 'rank_title', 'rank_min', 'rank_special', 'rank_image'),
	SEARCH_TABLE => array('search_id', 'session_id', 'search_array', 'search_time'),
	SEARCH_WORD_TABLE => array('word_text', 'word_id', 'word_common'),
	SEARCH_MATCH_TABLE => array('post_id', 'word_id', 'title_match'),
	SESSIONS_TABLE => array('session_id', 'session_user_id', 'session_start', 'session_time', 'session_ip', 'session_page', 'session_logged_in', 'session_admin'),
	SMILIES_TABLE => array('smilies_id', 'code', 'smile_url', 'emoticon'),
	THEMES_TABLE => array('themes_id', 'template_name', 'style_name', 'head_stylesheet', 'body_background', 'body_bgcolor', 'body_text', 'body_link', 'body_vlink', 'body_alink', 'body_hlink', 'tr_color1', 'tr_color2', 'tr_color3', 'tr_class1', 'tr_class2', 'tr_class3', 'th_color1', 'th_color2', 'th_color3', 'th_class1', 'th_class2', 'th_class3', 'td_color1', 'td_color2', 'td_color3', 'td_class1', 'td_class2', 'td_class3', 'fontface1', 'fontface2', 'fontface3', 'fontsize1', 'fontsize2', 'fontsize3', 'fontcolor1', 'fontcolor2', 'fontcolor3', 'span_class1', 'span_class2', 'span_class3', 'img_size_poll', 'img_size_privmsg'),
	THEMES_NAME_TABLE => array('themes_id', 'tr_color1_name', 'tr_color2_name', 'tr_color3_name', 'tr_class1_name', 'tr_class2_name', 'tr_class3_name', 'th_color1_name', 'th_color2_name', 'th_color3_name', 'th_class1_name', 'th_class2_name', 'th_class3_name', 'td_color1_name', 'td_color2_name', 'td_color3_name', 'td_class1_name', 'td_class2_name', 'td_class3_name', 'fontface1_name', 'fontface2_name', 'fontface3_name', 'fontsize1_name', 'fontsize2_name', 'fontsize3_name', 'fontcolor1_name', 'fontcolor2_name', 'fontcolor3_name', 'span_class1_name', 'span_class2_name', 'span_class3_name'),
	TOPICS_TABLE => array('topic_id', 'forum_id', 'topic_title', 'topic_poster', 'topic_time', 'topic_views', 'topic_replies', 'topic_status', 'topic_vote', 'topic_type', 'topic_first_post_id', 'topic_last_post_id', 'topic_moved_id'),
	TOPICS_WATCH_TABLE => array('topic_id', 'user_id', 'notify_status'),
	USER_GROUP_TABLE => array('group_id', 'user_id', 'user_pending'),
	USERS_TABLE => array('user_id', 'user_active', 'username', 'user_password', 'user_session_time', 'user_session_page', 'user_lastvisit', 'user_regdate', 'user_level', 'user_posts', 'user_timezone', 'user_style', 'user_lang', 'user_dateformat', 'user_new_privmsg', 'user_unread_privmsg', 'user_last_privmsg', 'user_emailtime', 'user_viewemail', 'user_attachsig', 'user_allowhtml', 'user_allowbbcode', 'user_allowsmile', 'user_allowavatar', 'user_allow_pm', 'user_allow_viewonline', 'user_notify', 'user_notify_pm', 'user_popup_pm', 'user_rank', 'user_avatar', 'user_avatar_type', 'user_email', 'user_icq', 'user_website', 'user_from', 'user_sig', 'user_sig_bbcode_uid', 'user_aim', 'user_yim', 'user_msnm', 'user_occ', 'user_interests', 'user_actkey', 'user_newpasswd', 'user_login_tries', 'user_last_login_try'),
	WORDS_TABLE => array('word_id', 'word', 'replacement'),
	VOTE_DESC_TABLE => array('vote_id', 'topic_id', 'vote_text', 'vote_start', 'vote_length'),
	VOTE_RESULTS_TABLE => array('vote_id', 'vote_option_id', 'vote_option_text', 'vote_result'),
	VOTE_USERS_TABLE => array('vote_id', 'vote_user_id', 'vote_user_ip'),
	CONFIRM_TABLE => array('confirm_id', 'session_id', 'code'),
	SESSIONS_KEYS_TABLE => array('key_id', 'user_id', 'last_ip', 'last_login')
);

//
// Figure out which fields do not belong in the SQL table, and store the
// names in $unknown_fields[tablename]
//
reset($valid_fields);
$unknown_fields = array();

while ( list($table_name, $fields) = each($valid_fields) )
{
	$result = $db->sql_query("SHOW FIELDS FROM $table_name");

	while ( $record = $db->sql_fetchrow($result) )
	{
		if ( !in_array($record['Field'], $fields) )
		{
			if ( !is_array($unknown_fields[$table_name]) )
			{
				$unknown_fields[$table_name] = array();
			}

			array_push($unknown_fields[$table_name], $record['Field']);
		}
	}
}

//
// Check all tables in the SQL db to see if any of them doesn't belong to
// the default phpBB installation
//
$tables = array();
$unknown_tables = array();

$result = $db->sql_query('SHOW TABLES');

while ( $row = $db->sql_fetchrow($result) )
{
    $current_table = $row['Tables_in_' . $dbname];
    $current_prefix = substr($current_table, 0, strlen($table_prefix));

    if ( $current_prefix == $table_prefix )
    {
        array_push($tables, $current_table);
    }
}

reset($tables);
reset($valid_fields);

while ( list(, $table_name) = each($tables) )
{
	$match_found = false;

	reset($valid_fields);
	while ( list($valid_table_name) = each($valid_fields) )
	{
		if ( $valid_table_name == $table_name )
		{
			$match_found = true;
		}
	}

	if ( !$match_found )
	{
		array_push($unknown_tables, $table_name);
	}
}

//
// Now we'll go through phpbb_config
//
$unknown_config = array();

$sql = "SELECT config_name FROM " . CONFIG_TABLE . " WHERE config_name NOT IN ('" . implode("', '", $config_records) . "')";
if ( !( $result = $db->sql_query($sql) ) )
{
	message_die(GENERAL_ERROR, "Failed getting configuration records", '', __LINE__, __FILE__, $sql);
}

while ( $config_data = $db->sql_fetchrow($result) )
{
	$unknown_config[] = $config_data['config_name'];
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<title><?php echo $lang['title']; ?></title>
		<link rel="stylesheet" href="subSilver.css" type="text/css">
	</head>

	<body bgcolor="#E5E5E5" text="#000000" link="#006699" vlink="#5584AA">
		<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center">
			<tr>
				<td class="bodyline" width="100%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td>
											<img src="logo.jpg" border="0" alt="" vspace="1" />
										</td>
										<td align="center" width="100%" valign="middle">
											<span class="maintitle"><?php echo $lang['title']; ?></span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<br /><br /><br /><br />
							</td>
						</tr>
<?php
if ( !$cleaned )
{
	?>
						<tr>
							<td colspan="2">
								<table width="90%" border="0" align="center" cellspacing="0" cellpadding="0">
									<tr>
										<td>
											<span class="gen">
												<?php echo $lang['explain']; ?>
											</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
	<?php
}
?>
						<tr>
							<td>
								<br /><br />
							</td>
						</tr>
						<tr>
							<td width="100%">
								<form action="clean_tables.php" name="clean" method="post">
								<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">

<?php
if ( $cleaned )
{
	$html->title($lang['cleaned_title']);
	print '<tr><td height="30" class="row1" colspan="2" align="center"><span class="genmed"><br /><span class="green">' . $lang['cleaned_explain'] . '<br />&nbsp;</span></td></tr>';
}
else
{
	// Unknown fields
	$html->title($lang['unknown_fields']);

	if ( count($unknown_fields) > 0 )
	{
		reset($unknown_fields);

		while ( list($table_name, $data) = each($unknown_fields) )
		{
			$html->header();
			$html->table_name($table_name);

			while ( list(, $fieldname) = each($data) )
			{
				$html->right_row('field', $fieldname);
			}

			$html->footer();
		}
	}
	else
	{
		print '<tr><td height="30" class="row1" colspan="2" align="center"><span class="genmed"><br /><span class="green"><b>' . $lang['no_fields_found'] . '</b></span><br />&nbsp;</span></td></tr>';
	}

	// Unknown tables
	$html->title($lang['unknown_tables']);

	if ( count($unknown_tables) > 0 )
	{
		reset($unknown_tables);

		$html->header();
		$html->table_name($lang['unknown_tables']);

		while ( list(, $table_name) = each($unknown_tables) )
		{
			$html->right_row('table', $table_name);
		}

		$html->footer();
	}
	else
	{
		print '<tr><td height="30" colspan="2" class="row1" align="center"><span class="genmed"><br /><span class="green"><b>' . $lang['no_tables_found'] . '</b></span><br />&nbsp;</span></td></tr>';
	}

	// Unknown config settings
	$html->title($lang['unknown_config']);

	if ( count($unknown_config) > 0 )
	{
		reset($unknown_config);

		$html->header();
		$html->table_name($lang['unknown_config']);

		while ( list(, $table_name) = each($unknown_config) )
		{
			$html->right_row('config', $table_name);
		}

		$html->footer();
	}
	else
	{
		print '<tr><td height="30" colspan="2" class="row1" align="center"><span class="genmed"><br /><span class="green"><b>' . $lang['no_config_found'] . '</b></span><br />&nbsp;</span></td></tr>';
	}

	print '<tr><td class="catBottom" align="center" colspan="2"><input class="mainoption" name="submit" type="submit" value="' . $lang['submit_button_caption'] . '"' . ( ( count($unknown_fields) == 0 && count($unknown_tables) == 0 && count($unknown_config) == 0 ) ? ' disabled="disabled"' : '') .  '/></td></tr>';
}
?>
								</table>
								</form>
							</td>
						</tr>
						<tr>
							<td>
								<br />
							</td>
						</tr>
						<tr>
							<td align="center">
								<span class="copyright">clean_tables.php &copy; 2004 - 2006 Vic D'Elfant<br />[ <a href="http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&u=118634" class="copyright" target="_blank">phpBB.com Profile</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://www.coronis.nl" class="copyright" target="_blank">Website</a> ]</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
