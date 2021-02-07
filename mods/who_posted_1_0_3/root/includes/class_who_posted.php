<?php
/** 
 * class_who_posted.php
 * 
 * @package		who_posted
 * @author		eviL3 <evil@phpbbmodders.net>
 * @copyright	(c) 2006 - 2007 eviL3
 * @license		http://opensource.org/licenses/gpl-license.php GNU Public License
 * 
 */

if ( !defined('IN_PHPBB') || class_exists('who_posted') )
{
	return;
}

/** 
 * Who Posted?
 * This is a MOD to imitate vBulletins "who posted" feature.
 * I'm using OOP, because i can (and want to).
 * 
 * 10-01-2007: The OOP has been improved a lot, most code moved to constructor
 * 
 */
class who_posted
{
	/**
	 * Constructor and main function
	 *
	 * @param	int $topic_id
	 * @global	db $db
	 * @global	array $board_config
	 * @global	template $template
	 * @global	array $lang
	 * @global	array $theme
	 * @global	string $phpEx
	 * @global	string $phpbb_root_path
	 * @global	array $userdata
	 * @global	string $user_ip
	 * @global	int $page_id
	 * @return	void
	 */
	function who_posted($topic_id)
	{
		global $db, $board_config, $template, $lang, $theme, $phpEx, $phpbb_root_path;
		global $userdata, $user_ip;
		global $page_id;
		/**
		 * Commented out for performance
		 * Uncomment if these get used in page_tail.php or page_header.php
		 */
//		global $starttime;
//		global $images;
		
		// Load language
		$this->load_lang('who_posted');
		
		// Start session
		$userdata = session_pagestart( $user_ip, $page_id );
		init_userprefs( $userdata );
		
		// Check auth and topic existance
		if( !( $this->check_topic_exists($topic_id) ) || !$this->check_topic_auth($topic_id) )
		{
			message_die( GENERAL_MESSAGE, $lang['topic_not_exist'] );
		}
		
		// Fetch data
		$sql = 'SELECT
				u.username,
				u.user_id,
				COUNT( DISTINCT p.post_id ) AS count
			FROM	' . POSTS_TABLE . ' p,
					' . USERS_TABLE . " u
			WHERE	p.topic_id	= {$topic_id}
			AND		u.user_id	= p.poster_id
			GROUP BY	u.user_id
			ORDER BY	count		DESC,
						u.username	ASC";
		
		if( !( $result = $db->sql_query($sql) ) )
		{
			$this->query_error( $sql, __LINE__, __FILE__ );
		}
		$data = $db->sql_fetchrowset( $result );
		
		$page_title = $lang['whoposted_title'];
		$gen_simple_header = true;
		include( "{$phpbb_root_path}includes/page_header.$phpEx" );
		
		$template->set_filenames(array(
			'body' => 'who_posted_body.tpl')
		);
		
		$template->assign_vars(array(
				'L_WHO_POSTED_TITLE'	=> $lang['whoposted_title'],
				'L_WHO_POSTED_EXP'		=> $lang['whoposted_exp'],
				
				'L_USERNAME'	=> $lang['Username'],
				'L_POSTS'		=> $lang['Posts'],
				
				'L_CLOSE'		=> $lang['whoposted_close'],
				'U_CLOSE'		=> append_sid( "{$phpbb_root_path}viewtopic.$phpEx?" . POST_TOPIC_URL . "={$topic_id}" ),
		));
		
		for( $i = 0; $i < sizeof( $data ); $i++ )
		{
			$username	= ( $data[$i]['user_id'] != ANONYMOUS ) ? '<a href="' . append_sid( "{$phpbb_root_path}profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "={$data[$i]['user_id']}" ) . '">' .  $data[$i]['username'] . '</a>' : $lang['Guest'];
			
			$user_posts	= $data[$i]['count'];
			
			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
			
			$template->assign_block_vars(
				'who_posted_row',
				array(
					'USERNAME'	=> $username,
					'POSTS'		=> $user_posts,
					
					'COLOR'		=> $row_color,
					'CLASS'		=> $row_class,
				)
			);
		}
		
		$template->pparse( 'body' );
		
		include( "{$phpbb_root_path}includes/page_tail.$phpEx" );
		
		return;
	}
	
	/**
	 * Check if a topic exists, creates an error on fail
	 *
	 * @param	int $topic_id
	 * @global	db $db
	 * @return	bool topic exists
	 */
	function check_topic_exists($topic_id)
	{
		global $db;
		
		if( $topic_id <= 0 )
		{
			return false;
		}
		
		$sql = 'SELECT topic_id
			FROM ' . TOPICS_TABLE . "
			WHERE topic_id = {$topic_id}
			LIMIT 1";
		if( !( $db->sql_query( $sql ) ) )
		{
			$this->query_error( $sql, __LINE__, __FILE__ );
		}
		
		return (bool) $db->sql_numrows();
	}
	
	/**
	 * Check if you're authorized to view the topic
	 *
	 * @param	int $topic_id
	 * @global	db $db
	 * @global	array $userdata
	 * @return	bool is_auth (read)
	 */
	function check_topic_auth($topic_id)
	{
		global	$db;
		global	$userdata;
		
		$is_auth = array();
		
		$sql = 'SELECT f.forum_id, f.auth_read
			FROM	' . FORUMS_TABLE . ' f,
					' . TOPICS_TABLE . " t
			WHERE	t.topic_id = {$topic_id}
			AND		t.forum_id = f.forum_id
			LIMIT 1";
		if( !( $result = $db->sql_query( $sql ) ) )
		{
			$this->query_error( $sql, __LINE__, __FILE__ );
		}
		$forum_info = $db->sql_fetchrow( $result );
		
		$is_auth = auth( AUTH_READ, $forum_info['forum_id'], $userdata, $forum_info );
		
		return (bool) $is_auth['auth_read'];
	}
	
	/**
	 * Display a message die
	 *
	 * @param	string $sql
	 * @param	string $line
	 * @param	string $file
	 * @global	array $lang
	 * @return	void
	 */
	function query_error( $sql, $line, $file )
	{
		global $lang;
		
		message_die( GENERAL_ERROR, $lang['whoposted_query_fail'], '', $line, $file, $sql );
		
		return;
	}
	
	/**
	 * Load language function
	 * 
	 * The function checks if the file exists, and includes it.
	 * If the file gets included, it returns true, if it doesn't
	 * exist, or couldn't get included, it returns false.
	 * 
	 * @param	string $lang_file
	 * @param	string $language
	 * @global	array $board_config
	 * @global	string $phpbb_root_path
	 * @global	string $phpEx
	 * @global	array $lang
	 * @return	bool file included
	 */
	function load_lang( $lang_file, $language = '' )
	{
		global $board_config, $phpbb_root_path, $phpEx, $lang;
		
		if( empty( $language ) )
		{
			$language = $board_config['default_lang'];
		}
		
		$file = "{$phpbb_root_path}language/lang_$language/lang_{$lang_file}.{$phpEx}";
		if ( file_exists( $file ) )
		{
			if( include_once( $file ) )
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}

?>
