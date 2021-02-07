############################################################## 
## MOD Title: phpBB 2.0.5 to phpBB 2.0.6 Changes
## MOD Author: Acyd Burn < acyd.burn@gmx.de > (Meik Sievertsen) http://www.opentools.de
## MOD Author, Secondary: LifeIsPain < brian@orvp.net> (Brian Evans) n/a
## MOD Description: 
##	These are the Changes from phpBB 2.0.5 to phpBB 2.0.6 summed up into a 
##	little Mod. This might be very helpful if you want to update your 
##	Board and have installed a bunch of Mods. Then it's normally easier to 
##	apply the Code Changes than to install all Mods again.
## MOD Version: 1.0.0
##
## Installation Level:	Intermediate
## Installation Time:	30-60 Minutes 
## Files To Edit: admin/admin_styles.php, admin/admin_users.php, admin/index.php, includes/emailer.php,
##		includes/functions.php, includes/functions_post.php, includes/functions_search.php,
##		includes/smtp.php, includes/usercp_register.php, login.php, modcp.php, search.php,
##		viewtopic.php
##
## Included Files: n/a
##############################################################
## Author Notes:
##	When you find a 'AFTER, ADD'-Statement, the Code have to be added after 
##	the last line quoted in the 'FIND'-Statement.
##	
##	When you find a 'BEFORE, ADD'-Statement, the Code have to be added before 
##	the first line quoted in the 'FIND'-Statement.
##	
##	When you find a 'REPLACE WITH'-Statement, the Code quoted in the 'FIND'-Statement 
##	have to be replaced completely with the quoted Code in the 'REPLACE WITH'-Statement.
##	
##	After you have finished this tutorial, you have to upload the update_to_206.php 
##	file provided in the standard phpBB 2.0.6 package to the install/ directory,
##	execute it and then delete it from your webspace.
############################################################## 
## This MOD is released under the GPL License.
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]--------------------------------------------- 
# 
admin/admin_styles.php

#
#-----[ FIND ]---------------------------------------------
# Line 42
$confirm = ( isset($HTTP_POST_VARS['confirm']) ) ? TRUE : FALSE;
$cancel = ( isset($HTTP_POST_VARS['cancel']) ) ? TRUE : FALSE;

if (empty($HTTP_POST_VARS['send_file']))
{
	$no_page_header = ( $cancel ) ? TRUE : FALSE;
	require($phpbb_root_path . 'extension.inc');
	require('./pagestart.' . $phpEx);
}

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
require($phpbb_root_path . 'extension.inc');

$confirm = ( isset($HTTP_POST_VARS['confirm']) ) ? TRUE : FALSE;
$cancel = ( isset($HTTP_POST_VARS['cancel']) ) ? TRUE : FALSE;

$no_page_header = (!empty($HTTP_POST_VARS['send_file']) || $cancel) ? TRUE : FALSE;

require('./pagestart.' . $phpEx);

# 
#-----[ OPEN ]--------------------------------------------- 
# 
admin/admin_users.php

#
#-----[ FIND ]---------------------------------------------
# Line 319
				else if ( strtolower(str_replace("\'", "''", $username)) == strtolower($userdata['username']) )

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
				else if ( strtolower(str_replace("\\'", "''", $username)) == strtolower($userdata['username']) )

#
#-----[ FIND ]---------------------------------------------
# Line 328
				$username_sql = "username = '" . str_replace("\'", "''", $username) . "', ";

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
				$username_sql = "username = '" . str_replace("\\'", "''", $username) . "', ";

# 
#-----[ OPEN ]--------------------------------------------- 
# 
admin/index.php

#
#-----[ FIND ]---------------------------------------------
# Line 458
					"U_WHOIS_IP" => "http://www.geektools.com/cgi-bin/proxy.cgi?query=$reg_ip&targetnic=auto", 

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
					"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$reg_ip", 

#
#-----[ FIND ]---------------------------------------------
# Line 550
				"U_WHOIS_IP" => "http://www.geektools.com/cgi-bin/proxy.cgi?query=$guest_ip&targetnic=auto", 

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
				"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$guest_ip", 


# 
#-----[ OPEN ]--------------------------------------------- 
# 
includes/emailer.php

#
#-----[ FIND ]---------------------------------------------
# Line 39
	}

	// Resets all the data (address, template file, etc etc to default
	function reset()
	{
		$this->addresses = array();
		$this->vars = $this->msg = $this->extra_headers = $this->replyto = $this->from = '';
	}

	// Sets an email address to send to
	function email_address($address, $realname = '')
	{
		$pos = sizeof($this->addresses['to']);
		$this->addresses['to'][$pos]['email'] = trim($address);
		$this->addresses['to'][$pos]['name'] = trim($realname);
	}

	function cc($address, $realname = '')
	{
		$pos = sizeof($this->addresses['cc']);
		$this->addresses['cc'][$pos]['email'] = trim($address);
		$this->addresses['cc'][$pos]['name'] = trim($realname);
	}

	function bcc($address, $realname = '')
	{
		$pos = sizeof($this->addresses['bcc']);
		$this->addresses['bcc'][$pos]['email'] = trim($address);
		$this->addresses['bcc'][$pos]['name'] = trim($realname);
	}

	function replyto($address)
	{
		$this->replyto = trim($address);

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$this->reply_to = $this->from = '';
	}

	// Resets all the data (address, template file, etc etc to default
	function reset()
	{
		$this->addresses = array();
		$this->vars = $this->msg = $this->extra_headers = '';
	}

	// Sets an email address to send to
	function email_address($address)
	{
		$this->addresses['to'] = trim($address);
	}

	function cc($address)
	{
		$this->addresses['cc'][] = trim($address);
	}

	function bcc($address)
	{
		$this->addresses['bcc'][] = trim($address);
	}

	function replyto($address)
	{
		$this->reply_to = trim($address);

#
#-----[ FIND ]---------------------------------------------
# Line 78
		$this->subject = trim($subject);

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$this->subject = trim(preg_replace('#[\n\r]+#s', '', $subject));

#
#-----[ FIND ]---------------------------------------------
# Line 189
		$to = $cc = $bcc = '';
		// Build to, cc and bcc strings
		@reset($this->addresses);
		while (list($type, $address_ary) = each($this->addresses))
		{
			@reset($address_ary);
			while (list(, $which_ary) = each($address_ary))
			{
				$$type .= (($$type != '') ? ',' : '') . (($which_ary['name'] != '') ? '"' . $this->encode($which_ary['name']) . '" <' . $which_ary['email'] . '>' : '<' . $which_ary['email'] . '>');
			}
		}

		// Build header
		$this->extra_headers = (($this->replyto != '') ? "Reply-to: <$this->replyto>\n" : '') . (($this->from != '') ? "From: <$this->from>\n" : "From: <" . $board_config['board_email'] . ">\n") . "Return-Path: <" . $board_config['board_email'] . ">\nMessage-ID: <" . md5(uniqid(time())) . "@" . $board_config['server_name'] . ">\nMIME-Version: 1.0\nContent-type: text/plain; charset=" . $this->encoding . "\nContent-transfer-encoding: 8bit\nDate: " . gmdate('D, d M Y H:i:s Z', time()) . "\nX-Priority: 3\nX-MSMail-Priority: Normal\nX-Mailer: PHP\nX-MimeOLE: Produced By phpBB2\n" . trim($this->extra_headers) . (($cc != '') ? "Cc:$cc\n" : '')  . (($bcc != '') ? "Bcc:$bcc\n" : ''); 

		$empty_to_header = ($to == '') ? TRUE : FALSE;
		$to = ($to == '') ? (($board_config['sendmail_fix'] && !$this->use_smtp) ? ' ' : 'Undisclosed-recipients:;') : $to;

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$to = $this->addresses['to'];

		$cc = (count($this->addresses['cc'])) ? implode(', ', $this->addresses['cc']) : '';
		$bcc = (count($this->addresses['bcc'])) ? implode(', ', $this->addresses['bcc']) : '';

		// Build header
		$this->extra_headers = (($this->reply_to != '') ? "Reply-to: $this->reply_to\n" : '') . (($this->from != '') ? "From: $this->from\n" : "From: " . $board_config['board_email'] . "\n") . "Return-Path: " . $board_config['board_email'] . "\nMessage-ID: <" . md5(uniqid(time())) . "@" . $board_config['server_name'] . ">\nMIME-Version: 1.0\nContent-type: text/plain; charset=" . $this->encoding . "\nContent-transfer-encoding: 8bit\nDate: " . date('r', time()) . "\nX-Priority: 3\nX-MSMail-Priority: Normal\nX-Mailer: PHP\nX-MimeOLE: Produced By phpBB2\n" . $this->extra_headers . (($cc != '') ? "Cc: $cc\n" : '')  . (($bcc != '') ? "Bcc: $bcc\n" : ''); 

#
#-----[ FIND ]---------------------------------------------
# Line 208
			$result = smtpmail($to, $this->subject, $this->msg, $this->extra_headers);
		}
		else
		{


#
#-----[ AFTER, ADD ]---------------------------------------------
# 
			$empty_to_header = ($to == '') ? TRUE : FALSE;
			$to = ($to == '') ? (($board_config['sendmail_fix']) ? ' ' : 'Undisclosed-recipients:;') : $to;

#
#-----[ FIND ]---------------------------------------------
# Line 264
		$str = preg_replace('#' . phpbb_preg_quote($spacer) . '$#', '', $str);

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$str = preg_replace('#' . phpbb_preg_quote($spacer, '#') . '$#', '', $str);

# 
#-----[ OPEN ]--------------------------------------------- 
# 
includes/functions.php

#
#-----[ FIND ]---------------------------------------------
# Line 87
		$user = substr(str_replace("\'", "'", $user), 0, 25);

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$user = substr(str_replace("\\'", "'", $user), 0, 25);
		$user = str_replace("'", "\\'", $user);

#
#-----[ FIND ]---------------------------------------------
# Line 507
			$orig_word[] = '#(' . str_replace('\*', '\w*?', phpbb_preg_quote($row['word'], '#')) . ')#i';

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			$orig_word[] = '#\b(' . str_replace('\*', '\w*?', phpbb_preg_quote($row['word'], '#')) . ')\b#i';

# 
#-----[ OPEN ]--------------------------------------------- 
# 
includes/functions_post.php

#
#-----[ FIND ]---------------------------------------------
# Line 77
						$tagallowed = (preg_match('#^<\/?' . $match_tag . ' .*?(style[\t ]*?=|on[\w]+[\t ]*?=)#i', $hold_string)) ? false : true;

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
						$tagallowed = (preg_match('#^<\/?' . $match_tag . ' .*?(style[ ]*?=|on[\w]+[ ]*?=)#i', $hold_string)) ? false : true;

#
#-----[ FIND ]---------------------------------------------
# Line 94
		if (!$end_html || ($end_html != strlen($message) && $tmp_message != ''))

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		if ($end_html != strlen($message) && $tmp_message != '')

# 
#-----[ OPEN ]--------------------------------------------- 
# 
includes/functions_search.php

#
#-----[ FIND ]---------------------------------------------
# Line 61
		$entry = explode(' ', $entry);
		for ($i = 0; $i < sizeof($entry); $i++)
		{
			$entry[$i] = trim($entry[$i]);
			if ((strlen($entry[$i]) < 3) || (strlen($entry[$i]) > 20))
			{
				$entry[$i] = '';
			}
		}
		$entry = implode(' ', $entry);

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$entry = preg_replace('/[ ]([\S]{1,2}|[\S]{21,})[ ]/',' ', $entry);

#
#-----[ FIND ]---------------------------------------------
# Line 101
	$split_entries = array();
	$split = explode(' ', $entry);
	for ($i = 0; $i < count($split); $i++)
	{
		if (trim($split[$i]) != '')
		{
			$split_entries[] = trim($split[$i]);
		}
	}

	return $split_entries;

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
	// Trim 1+ spaces to one space and split this trimmed string into words.
	return explode(' ', trim(preg_replace('#\s+#', ' ', $entry)));

#
#-----[ FIND ]---------------------------------------------
# Line 116
	$search_raw_words['text'] = split_words(clean_words('post', $post_text, $stopword_array, $synonym_array));
	$search_raw_words['title'] = split_words(clean_words('post', $post_title, $stopword_array, $synonym_array));

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
	@set_time_limit(0);

#
#-----[ FIND ]---------------------------------------------
# Line 243
			$sql = "INSERT INTO " . SEARCH_MATCH_TABLE . " (post_id, word_id, title_match) 

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			$sql = "INSERT IGNORE INTO " . SEARCH_MATCH_TABLE . " (post_id, word_id, title_match) 

# 
#-----[ OPEN ]--------------------------------------------- 
# 
includes/smtp.php

#
#-----[ FIND ]---------------------------------------------
# Line 93
		$cc = explode(',', $cc);
		$bcc = explode(',', $bcc);

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$cc = explode(', ', $cc);
		$bcc = explode(', ', $bcc);

#
#-----[ FIND ]---------------------------------------------
# Line 107
	$mail_to_array = explode(',', $mail_to);

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
	// some code was removed here for 2.0.6

#
#-----[ FIND ]---------------------------------------------
# Line 145
	@reset($mail_to_array);
	while(list(, $mail_to_address) = each($mail_to_array))
	{
		// Add an additional bit of error checking to the To field.
		$mail_to_address = trim($mail_to_address);
		if (preg_match('#[^ ]+\@[^ ]+#', $mail_to_address))
		{
			fputs($socket, "RCPT TO: $mail_to_address\r\n");
			server_parse($socket, "250", __LINE__);
		}
		$to_header .= (($to_header !='') ? ', ' : '') . "$mail_to_address";
	}

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
	$to_header = '';

	// Add an additional bit of error checking to the To field.
	$mail_to = (trim($mail_to) == '') ? 'Undisclosed-recipients:;' : trim($mail_to);
	if (preg_match('#[^ ]+\@[^ ]+#', $mail_to))
	{
		fputs($socket, "RCPT TO: <$mail_to>\r\n");
		server_parse($socket, "250", __LINE__);
	}

#
#-----[ FIND ]---------------------------------------------
# Line 163
			fputs($socket, "RCPT TO: $bcc_address\r\n");

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			fputs($socket, "RCPT TO: <$bcc_address>\r\n");

#
#-----[ FIND ]---------------------------------------------
# Line 175
			fputs($socket, "RCPT TO: $cc_address\r\n");

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			fputs($socket, "RCPT TO: <$cc_address>\r\n");

#
#-----[ FIND ]---------------------------------------------
# Line 190
	fputs($socket, "To: $to_header\r\n");

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
	fputs($socket, "To: $mail_to\r\n");

# 
#-----[ OPEN ]--------------------------------------------- 
# 
includes/usercp_register.php

#
#-----[ FIND ]---------------------------------------------
# Line 170
	$user_timezone = ( isset($HTTP_POST_VARS['timezone']) ) ? doubleval($HTTP_POST_VARS['timezone']) : $board_config['board_timezone'];

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
	$sql = "SELECT config_value
		FROM " . CONFIG_TABLE . "
		WHERE config_name = 'default_dateformat'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not select default dateformat', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$board_config['default_dateformat'] = $row['config_value'];

#
#-----[ FIND ]---------------------------------------------
# Line 625
				$sql = "SELECT user_email 

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
				$sql = "SELECT user_email, user_lang 

#
#-----[ FIND ]---------------------------------------------
# Line 636
					$emailer->bcc(trim($row['user_email']));
				}

				$emailer->use_template("admin_activate", $board_config['default_lang']);
				$emailer->email_address($lang['New_account_subject'] . ':;');

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
					$emailer->from($board_config['board_email']);
					$emailer->replyto($board_config['board_email']);
					
					$emailer->email_address(trim($row['user_email']));
					$emailer->use_template("admin_activate", $row['user_lang']);

#
#-----[ FIND ]---------------------------------------------
# Line 652
				$emailer->send();
				$emailer->reset();
			}

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
				$db->sql_freeresult($result);
			}

# 
#-----[ OPEN ]--------------------------------------------- 
# 
login.php

#
#-----[ FIND ]---------------------------------------------
# Line 58
		$username = substr(str_replace("\'", "'", $username), 0, 25);
		$password = isset($HTTP_POST_VARS['password']) ? $HTTP_POST_VARS['password'] : '';

		$sql = "SELECT user_id, username, user_password, user_active, user_level
			FROM " . USERS_TABLE . "
			WHERE username = '" . str_replace("\'", "''", $username) . "'";

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
		$username = substr(str_replace("\\'", "'", $username), 0, 25);
		$username = str_replace("'", "\\'", $username);
		$password = isset($HTTP_POST_VARS['password']) ? $HTTP_POST_VARS['password'] : '';

		$sql = "SELECT user_id, username, user_password, user_active, user_level
			FROM " . USERS_TABLE . "
			WHERE username = '" . str_replace("\\'", "''", $username) . "'";

# 
#-----[ OPEN ]--------------------------------------------- 
# 
modcp.php

#
#-----[ FIND ]---------------------------------------------
# Line 229

				$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . $topics[$i];
			}

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
				$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
			}

			$sql = "SELECT topic_id 
				FROM " . TOPICS_TABLE . "
				WHERE topic_id IN ($topic_id_sql)
					AND forum_id = $forum_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic id information', '', __LINE__, __FILE__, $sql);
			}
			
			$topic_id_sql = '';
			while ($row = $db->sql_fetchrow($result))
			{
				$topic_id_sql .= (($topic_id_sql != '') ? ', ' : '') . intval($row['topic_id']);
			}
			$db->sql_freeresult($result);

#
#-----[ FIND ]---------------------------------------------
# Line 288
				$post_id_sql .= ( ( $post_id_sql != '' ) ? ', ' : '' ) . $row['post_id'];

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
				$post_id_sql .= ( ( $post_id_sql != '' ) ? ', ' : '' ) . intval($row['post_id']);

#
#-----[ FIND ]---------------------------------------------
# Line 452
			$new_forum_id = $HTTP_POST_VARS['new_forum'];

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			$new_forum_id = intval($HTTP_POST_VARS['new_forum']);

#
#-----[ FIND ]---------------------------------------------
# Line 468
				$sql = "SELECT * 
					FROM " . TOPICS_TABLE . " 
					WHERE topic_id IN ($topic_list)

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
						AND forum_id = $old_forum_id

#
#-----[ FIND ]---------------------------------------------
# Line 602
			$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . $topics[$i];
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_LOCKED . " 
			WHERE topic_id IN ($topic_id_sql) 

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_LOCKED . " 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id

#
#-----[ FIND ]---------------------------------------------
# Line 647
			$topic_id_sql .= ( ( $topic_id_sql != "") ? ', ' : '' ) . $topics[$i];
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_UNLOCKED . " 
			WHERE topic_id IN ($topic_id_sql) 

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			$topic_id_sql .= ( ( $topic_id_sql != "") ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_UNLOCKED . " 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id

#
#-----[ FIND ]---------------------------------------------
# Line 699
		if ($post_id_sql != '')
		{

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
			$sql = "SELECT post_id 
				FROM " . POSTS_TABLE . "
				WHERE post_id IN ($post_id_sql)
					AND forum_id = $forum_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post id information', '', __LINE__, __FILE__, $sql);
			}
			
			$post_id_sql = '';
			while ($row = $db->sql_fetchrow($result))
			{
				$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . intval($row['post_id']);
			}
			$db->sql_freeresult($result);

#
#-----[ FIND ]---------------------------------------------
# Line 938
			WHERE post_id = $post_id";

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			WHERE post_id = $post_id
				AND forum_id = $forum_id";

# 
#-----[ OPEN ]--------------------------------------------- 
# 
search.php

#
#-----[ FIND ]---------------------------------------------
# Line 863
						if ( count($search_string) )
						{
							$message = preg_replace($search_string, $replace_string, $message);
						}

#
#-----[ REPLACE WITH ]---------------------------------------------
#
						// some code was removed here for 2.0.6

# 
#-----[ OPEN ]--------------------------------------------- 
# 
viewtopic.php

#
#-----[ FIND ]---------------------------------------------
# Line 32
//
// Start initial var setup
//

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
$topic_id = $post_id = 0;

#
#-----[ FIND ]---------------------------------------------
# Line 108
			FROM " . TOPICS_TABLE . " t, " . TOPICS_TABLE . " t2, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2
			WHERE t2.topic_id = $topic_id
				AND p2.post_id = t2.topic_last_post_id
				AND t.forum_id = t2.forum_id
				AND p.post_id = t.topic_last_post_id
				AND p.post_time $sql_condition p2.post_time
				AND p.topic_id = t.topic_id
			ORDER BY p.post_time $sql_ordering

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
			FROM " . TOPICS_TABLE . " t, " . TOPICS_TABLE . " t2
			WHERE
				t2.topic_id = $topic_id
				AND t.forum_id = t2.forum_id
				AND t.topic_last_post_id $sql_condition t2.topic_last_post_id
			ORDER BY t.topic_last_post_id $sql_ordering

#
#-----[ FIND ]---------------------------------------------
# Line 137
$join_sql_table = ( !isset($post_id) ) ? '' : ", " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2 ";
$join_sql = ( !isset($post_id) ) ? "t.topic_id = $topic_id" : "p.post_id = $post_id AND t.topic_id = p.topic_id AND p2.topic_id = p.topic_id AND p2.post_id <= $post_id";
$count_sql = ( !isset($post_id) ) ? '' : ", COUNT(p2.post_id) AS prev_posts";

$order_sql = ( !isset($post_id) ) ? '' : "GROUP BY p.post_id, t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments ORDER BY p.post_id ASC";

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
$join_sql_table = ( empty($post_id) ) ? '' : ", " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2 ";
$join_sql = ( empty($post_id) ) ? "t.topic_id = $topic_id" : "p.post_id = $post_id AND t.topic_id = p.topic_id AND p2.topic_id = p.topic_id AND p2.post_id <= $post_id";
$count_sql = ( empty($post_id) ) ? '' : ", COUNT(p2.post_id) AS prev_posts";

$order_sql = ( empty($post_id) ) ? '' : "GROUP BY p.post_id, t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments ORDER BY p.post_id ASC";

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 

# EoM
