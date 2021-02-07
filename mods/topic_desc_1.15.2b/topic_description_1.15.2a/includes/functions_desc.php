<?php
/***************************************************************************
 *                            functions_desc.php
 *                            -------------------
 *   begin                : Friday, Apr 15, 2005
 *   copyright            : swizec
 *   email                : swizec@swizec.com
 *
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') ) 
{ 
   die("Hacking attempt"); 
}

// this should help relieve us of some of those ifs ^^
function auth_config_check( &$candesc, &$canmoddesc )
{
	global $board_config, $userdata, $post_id, $mode, $is_auth, $post_info;

	if ( !$candesc && !$canmoddesc )
	{
		return;
	}
	if ( ( !$board_config['allow_descriptions'] ) || ( $board_config['only_mods_desc'] && !$is_auth['auth_mod'] ) || ( !$board_config['guests_desc'] && $userdata['user_id'] == ANONYMOUS ) ) 
	{
		$candesc = FALSE;
		$canmoddesc = FALSE;
		return;
	}
	if ( ( $post_info['topic_first_post_id'] != $post_id && $mode != 'newtopic' ) || $board_config['desc_tolink'] ) 
	{
		$candesc = FALSE;
		$canmoddesc = FALSE;
		return;
	}
	if ( !$userdata['user_allowdesc'] ) 
	{
		$candesc = FALSE;
	}
	if ( !$board_config['guests_moddesc'] && $userdata['user_id'] == ANONYMOUS )
	{
		$canmoddesc = FALSE;
	}
	elseif ( !$userdata['user_allowmoddesc'] ) 
	{
		$canmoddesc = FALSE;
	}
}

// checks the forum's permissions descritpions
function get_descperm( &$desc_perm )
{
	global $forum_id, $db, $userdata;
	
	$sql = "SELECT f.auth_desc, f.auth_moddesc FROM " . FORUMS_TABLE . " f " .
		"WHERE f.forum_id=$forum_id LIMIT 0,1";
	if ( !( $result = $db -> sql_query( $sql ) ) ) 
	{
		message_die ( GENERAL_ERROR, 'Failed obtaining description data', '', __LINE__, __FILE__, $sql );
	}
	$desc_perm = $db -> sql_fetchrow ( $result );
	
	$uid = $userdata['user_id'];
	$sql = "SELECT g.auth_desc, g.auth_moddesc " .
		"FROM " . USER_GROUP_TABLE . " ug LEFT JOIN " . AUTH_ACCESS_TABLE . " g ON ug.group_id = g.group_id " .
		"WHERE ug.user_id = $uid AND g.forum_id = $forum_id LIMIT 0,1";
	if ( !( $result = $db -> sql_query( $sql ) ) )
	{
		message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
	}
	$auth = $db -> sql_fetchrow ( $result );
	$desc_perm[ 'auth_group1' ] = $auth[ 'auth_desc' ];
	$desc_perm[ 'auth_group2' ] = $auth[ 'auth_desc' ];
}

// checks if the current user can view/add/edit decriptions
function check_descperm ( $view = FALSE ) 
{
	global $is_auth, $userdata, $board_config, $post_info, $post_id, $mode, $db, $forum_id, $desc_perm;
	
	if ( empty( $desc_perm ) )
	{
		get_descperm( $desc_perm );
	}
	
	$adesc = $desc_perm['auth_desc'];
	$admod = $desc_perm['auth_moddesc'];
	$adgroup1 = $desc_perm['auth_group1'];
	$adgroup2 = $desc_perm['auth_group2'];
	
	// the validator kindly pointed out a security risk, this should fix it :)
	$candesc = FALSE;
	$canmoddesc = FALSE;
		
	switch ( $adesc ) 
	{
		case AUTH_ALL:
			$candesc = TRUE;
			break;
		case AUTH_REG:
			if ( $userdata['user_id'] != ANONYMOUS ) 
			{
				$candesc = TRUE;
			}
			break;
		case AUTH_ACL:
			if ( $adgroup1 ) 
			{
				$candesc = TRUE;
			}
			break;
		case AUTH_MOD:
			if ( $is_auth['auth_mod'] ) 
			{
				$candesc = TRUE;
			}
			break;
		case AUTH_ADMIN:
			if ( $userdata['user_level'] == ADMIN ) 
			{
				$candesc = TRUE;
			}
			break;
	}
	switch ( $admod ) 
	{
		case AUTH_ALL:
			$canmoddesc = TRUE;
			break;	
		case AUTH_REG:
			if ( $userdata['user_id'] != ANONYMOUS ) 
			{
				$canmoddesc = TRUE;
			}
			break;
		case AUTH_ACL:
			if ( $adgroup2 ) 
			{
				$canmoddesc = TRUE;
			}
			break;
		case AUTH_MOD:
			if ( $is_auth['auth_mod'] ) 
			{
				$canmoddesc = TRUE;
			}
			break;
		case AUTH_ADMIN:
			if ( $userdata['user_level'] == ADMIN ) 
			{
				$canmoddesc = TRUE;
			}
			break;
	}
	
	auth_config_check( $candesc, $canmoddesc );
	
	// this two have to be like this because of their "strength"
	if ( ( $board_config['desc_linkforce'] || $board_config['desc_prev'] ) && !isset( $mode ) ) 
	{
		$candesc = TRUE;
	}
	if ( isset( $mode ) && ( $board_config['desc_linkforce'] || $board_config['desc_prev'] ) ) 
	{
		$candesc = FALSE;
	}

	if ( !$view ) 
	{
		if ( !$candesc && !$canmoddesc ) 
		{
			return AUTH_NODESC;
		}
		if ( $candesc && !$canmoddesc ) 
		{
			return AUTH_DESC;
		}
		if ( $candesc && $canmoddesc ) 
		{
			return AUTH_MODDESC;
		}
	}
	else
	{
		if ( !$board_config['disallowed_seedesc'] && ( !$candesc && !$board_config['desc_tolink'] && !$board_config['desc_prev'] ) ) 
		{
			return FALSE;
		}
		elseif ( !$userdata['user_showdescriptions'] && !$board_config['disallowed_seedesc'] )
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}

// checks forum permissions for tooltips
function get_tooltipperm( &$tool_perm, $forum_id )
{
	global $userdata, $db;
	
	$sql = "SELECT f.auth_tooltip FROM " . FORUMS_TABLE . " f WHERE f.forum_id=$forum_id LIMIT 0, 1";
	if ( !( $result = $db -> sql_query( $sql ) ) ) 
	{
		message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
	}
	$tool_perm = $db -> sql_fetchrow ( $result );
	
	$uid = $userdata['user_id'];
	$sql = "SELECT g.auth_tooltip " .
		"FROM " . USER_GROUP_TABLE . " ug LEFT JOIN " . AUTH_ACCESS_TABLE . " g ON ug.group_id = g.group_id " .
		"WHERE ug.user_id = $uid AND g.forum_id = $forum_id LIMIT 0,1";
	if ( !( $result = $db -> sql_query( $sql ) ) ) 
	{
		message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
	}
	$auth = $db -> sql_fetchrow ( $result );
	
	$tool_perm[ 'auth_group' ] = $auth[ 'auth_tooltip' ];
}

// fetches all the tooltips at once
function get_tooltips( &$tooltips, $topic_rowset )
{
	global $db;
	
	$topics = '';
	for ( $i = 0; $i < count( $topic_rowset ); $i++ )
	{
		$topics .= $topic_rowset[$i]['topic_id'] . ', ';
	}
	$topics = substr( $topics, 0, -2 );
	
	$sql = "SELECT te.post_text, te.bbcode_uid, p.post_time, p.post_username, u.user_id, u.username, u.user_dateformat, t.topic_id FROM " .
		POSTS_TEXT_TABLE . " te LEFT JOIN " . POSTS_TABLE . " p ON te.post_id = p.post_id LEFT JOIN " . TOPICS_TABLE . " t ON p.post_id = t.topic_first_post_id OR p.post_id = t.topic_last_post_id LEFT JOIN " . USERS_TABLE . " u ON p.poster_id = u.user_id " .
		"WHERE t.topic_id IN ( $topics )";
	
	if ( !( $result = $db -> sql_query( $sql ) ) )
	{
		message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
	}
	
	$tooltips = array();
	while ( $row = $db -> sql_fetchrow( $result ) )
	{
		if ( !isset( $tooltips[ $row[ 'topic_id' ] ] ) )
		{
			$tooltips[ $row[ 'topic_id' ] ] = array();
		}
		$tooltips[ $row[ 'topic_id' ] ][] = $row;
	}
}

// checks if the user can view tooltips
function show_tooltip ( $forum_id, $topic_id ) 
{	
	global $userdata, $board_config, $db, $is_auth, $tool_perm;
	
	if ( empty( $tool_perm ) )
	{
		$tool_perm = get_tooltipperm( $forum_id, $topic_id );
	}
	
	// this used to be an or but an and seems to be more desirable :)
	if ( $board_config['show_tooltips'] && $userdata['user_showtooltips'] ) 
	{
		switch ( $tool_perm['auth_tooltip'] ) 
		{
			case AUTH_ALL:
				return TRUE;
			case AUTH_REG:
				if ( $userdata['user_id'] != ANONYMOUS ) 
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			case AUTH_ACL:
				if ( !$tool_perm['auth_group'] ) 
				{
					return FALSE;
				}
				else
				{
					return TRUE;
				}
				break;
			case AUTH_MOD:
				if ( $is_auth['auth_mod'] ) 
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			case AUTH_ADMIN:
				if ( $userdata['user_level'] == ADMIN ) 
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			default:
				return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
}

// returns the size correction of the image
function maketimgsize ( $width, $height ) 
{
	
	global $userdata, $board_config;
	
	if ( $width > $height ) 
	{
		if ( $userdata['user_toolimg_width'] < $board_config['toolimg_width'] ) 
		{
			if ( $userdata['user_toolimg_width'] < $width ) 
			{
				$size = 'width="' . $userdata['user_toolimg_width'] . '"';
			}
		}
		else
		{
			if ( $board_config['toolimg_width'] < $width ) 
			{
				$size = 'width="' . $board_config['toolimg_width'] . '"';
			}
		}
	}
	else
	{
		if ( $userdata['user_toolimg_height'] < $board_config['toolimg_height'] ) 
		{
			if ( $userdata['toolimg_height'] < $height ) 
			{
				$size = 'width="' . $userdata['user_toolimg_height'] . '"';
			}
		}
		else
		{
			if ( $board_config['toolimg_height'] < $height ) 
			{
				$size = 'height="' . $board_config['toolimg_height'] . '"';
			}
		}
	}
	
	return $size;
}

// makes BBCode from the hatelist unparsable or removes it if needed
function check_bbcode( $text, $bbcode_uid )
{
	global $board_config;
	
	// the extra .*? are there because some MODs might add stuff there :)
	if ( empty( $board_config['desc_bbcode_hatelist'] ) || empty( $text ) )
	{
		return $text;
	}
	
	preg_match_all( '#(\[(' . $board_config['desc_bbcode_hatelist'] . ').*?:' . $bbcode_uid . '\])(.*?)(\[/(' . $board_config['desc_bbcode_hatelist'] . ').*?:' . $bbcode_uid . '\])#is', $text, $matches );
	
	// the all famous loop ^^
	foreach ( $matches[ 0 ] as $i => $match )
	{
		if ( $board_config['desc_bbcode_remove'] )
		{ // simply remove it
			$text = str_replace( $match, '', $text );
		}
		else
		{ // a tad more complex :)
			$finds = array( ':' . $bbcode_uid, '[', ']' );
			$replaces = array( '', '&#91;', '&#93;' );
			$rep1 = '[b:' . $bbcode_uid . ']' . str_replace( $finds, $replaces, $matches[ 1 ][ $i ] ) . '[/b:' . $bbcode_uid . ']';
			$rep2 = '[b:' . $bbcode_uid . ']' . str_replace( $finds, $replaces, $matches[ 4 ][ $i ] ) . '[/b:' . $bbcode_uid . ']';
			$text = str_replace( $match, $rep1 . $matches[ 3 ][ $i ] . $rep2, $text );
		}
	}

	return $text;
}

function parse_tool( $posts, &$user1, &$time1, $normal = TRUE )
{
	global $board_config, $db, $phpEx, $lang, $phpbb_root_path, $userdata, $theme, $tooltips_full, $tooltip_options;
	
	$tooltip = '';
	$cnt = 1;
	
	$i = 0;
	
	while ( $i < 2 ) 
	{
		$post = $posts[ $i ];
		if ( empty( $post[ 'post_text' ] ) )
		{
			$i++;
			continue;
		}
		$dateformat = ( !empty( $post['user_dateformat'] ) ) ? $userdata['user_dateformat'] : $board_config['default_dateformat'];
		$bbcode_uid = $post['bbcode_uid'];
		$time = date( $dateformat, $post['post_time'] );
		$user = ( $post['user_id'] != ANONYMOUS ) ? $post['username'] :  $post['post_username'];
		
		$post = $post['post_text'];
		
		if ( $normal )
		{
			$post = check_bbcode( $post, $bbcode_uid );
		}
		
		$post = ( strlen( $post ) > $board_config['tooltips_post_maxsize'] ) ? substr( $post, 0, $board_config['tooltips_post_maxsize'] ) . '...' : $post;
	
		// again an and instead of or seems to be more desirable
		if ( $board_config['tooltips_parse'] && $userdata['user_tooltips_parse'] || !$normal ) 
		{
			include_once( $phpbb_root_path . 'includes/bbcode.'.$phpEx );
			if ( $board_config['allow_smilies'] ) 
			{
				$post = smilies_pass ( $post );
			}
			if ( $board_config['allow_bbcode'] ) {
				// using \S+ instead of $bbcode_uid because that solution didn't work in all cases, don't ask why, just didn't
				preg_match_all( "/\[(img(\S+))\](\S+)\[\/(img\S+)\]/i", $post, $matches); 
				foreach ( $matches[3] as $k => $img ) { 
// 					if ( !$size = @getimagesize( $img ) ) 
// 					{
// 						continue;
// 					}
// 					$width = $size[0]; $height = $size[1]; 
// 					$size = maketimgsize ( $size[0], $size[1] ); 
// 					$first = $matches[2][$k]; 
// 					$secnd = $matches[3][$k]; 
// 					$search = "[" . $first . "]" . $img . "[/" . $secnd . "]"; 
// 					echo $search . '<br>';
// 		
// 					// this is not in a template because it is nothing special, it's just a short javascript call
// 					// the onclick DOES work, but only when tooltips are set to be static
// 					$click = "<a href=\"#\" onclick=\"window.open( '$img', 'imgpop',  'width=$width,height=$height,status=no,toolbar=no,menubar=no' );\">";
// 		
// 					$result = "$click<img src=\"$img\" border=\"0\" $size></a>";
// 					$post = str_replace ( $search, $result, $post ); 
					
					// we use this instead so it works faster :)
					// but the old is retained becuase it might be chosen as useful one day when time is in bigger supply :)
					
					// the substr is mainly because img tags might have stuff added and we just need the bbcode_uid
					// (this is the case when another of my MODs is installed, that I know of)
					$ob = '[b:' .  substr( strrchr( $matches[2][$k], ':' ), 1 ) . ']'; // open bold
					$cb = '[/b:' . substr( strrchr( $matches[2][$k], ':' ), 1 ) . ']'; // close bold
					$post = str_replace( $matches[0][$k], $ob . '&#91;img&#93;' . $cb . $img . $ob . '&#91;/img&#93;' . $cb, $post );
				}
				$post = bbencode_second_pass ( $post, $bbcode_uid );
			}
		}
		else
		{
			$pattern = array( "/\[(\S*)=\S*\](\S*)\[(\S*):\S+\]/",
				  	"/\[(\S*):\S*\](\S*)\[(\S*):\S+\]/",
				  	"/\[(\S*)\](\S*)\[(\S*):\S+\]/"
					);
			$post = preg_replace ( $pattern, '<b>[$1]</b>$2<b>[$3]</b>', $post );
		}
		
		if ( $i == 0 )
		{
			$user1 = $user;
			$time1 = $time;
		}
		
		$tooltip .= ( $cnt == 1 ) ? '<b>' . $lang['first_post'] . ' :</b><br />' . $post . '<br /><br />' : '<b>' . $lang['last_post'] . ' :</b><br /><i>' . "$user : $time" . '</i><br />' . $post;	
		
		$cnt++;
		$i++;
	}
	
	return $tooltip;
}

function tooltip_postparse( $topic_id )
{
	global $board_config, $db, $phpEx, $lang, $phpbb_root_path, $userdata, $theme, $tooltips_full, $tooltip_options;
	
	if ( !$posts = $tooltips_full[ $topic_id ] )
	{ // blargh need to query for it
		$sql = "SELECT te.post_text, te.bbcode_uid, p.post_time, p.post_username, u.user_id, u.username, u.user_dateformat, t.topic_id FROM " .
		POSTS_TEXT_TABLE . " te LEFT JOIN " . POSTS_TABLE . " p ON te.post_id = p.post_id LEFT JOIN " . TOPICS_TABLE . " t ON p.post_id = t.topic_first_post_id OR p.post_id = t.topic_last_post_id LEFT JOIN " . USERS_TABLE . " u ON p.poster_id = u.user_id " .
		"WHERE t.topic_id = $topic_id";
	
		if ( !( $result = $db -> sql_query( $sql ) ) )
		{
			message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
		}
		
		$posts = $db->sql_fetchrowset( $result );
	}
	
	$tooltip = '<div id="' . $topic_id . '">' . parse_tool( $posts, $user, $time, FALSE ) . '</div>';
	
	$tooltip = str_replace("\r\n", "<br />", $tooltip);
// 	$tooltip = str_replace( "'", "\'", $tooltip );
// 	$tooltip = str_replace( '"', "\'", $tooltip );
// 	$tooltip = htmlspecialchars( $tooltip );
	
	return array( $topic_id, $tooltip );
}

// creates the tooltip and returns the code needed to display it
function topic_tooltip ( $topic_id )
{
	global $board_config, $db, $phpEx, $lang, $phpbb_root_path, $userdata, $theme, $tooltips_full, $tooltip_options;
	
	if ( !$posts = $tooltips_full[ $topic_id ] )
	{ // blargh need to query for it
		$sql = "SELECT te.post_text, te.bbcode_uid, p.post_time, p.post_username, u.user_id, u.username, u.user_dateformat, t.topic_id FROM " .
		POSTS_TEXT_TABLE . " te LEFT JOIN " . POSTS_TABLE . " p ON te.post_id = p.post_id LEFT JOIN " . TOPICS_TABLE . " t ON p.post_id = t.topic_first_post_id OR p.post_id = t.topic_last_post_id LEFT JOIN " . USERS_TABLE . " u ON p.poster_id = u.user_id " .
		"WHERE t.topic_id = $topic_id";
	
		if ( !( $result = $db -> sql_query( $sql ) ) )
		{
			message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
		}
		
		$posts = $db->sql_fetchrowset( $result );
	}
	
	$tooltip = '<div id="' . $topic_id . '">' . parse_tool( $posts, $user, $time ) . '</div>';
	
	$tooltip = str_replace("\r\n", "<br />", $tooltip);
	$tooltip = str_replace( "'", "\'", $tooltip );
	$tooltip = str_replace( '"', "\'", $tooltip );
	$tooltip = htmlspecialchars( $tooltip );

	$options = "this.T_TITLE='$user : $time';";
// 	$options .= "this.T_TEXTALIGN='justify';";
// 	$options .= "this.T_WIDTH='500';";
	if ( $board_config['tooltips_static'] || $userdata['user_tooltips_static'] )
	{
		$options .= 'this.T_STICKY=true;';
	}
	$options .= $tooltip_options;
	
	return 'onmouseover="' . $options . " return escape('$tooltip');\""; 	
}

function parse_desc( $text, $bbcode_uid )
{
	global $board_config, $userdata, $phpbb_root_path, $phpEx;
	
	if ( !function_exists( 'bbencode_second_pass' ) )
	{
		include( $phpbb_root_path . 'includes/bbcode.' . $phpEx );
	}
	
	if ( !$board_config['desc_html'] || !$userdata['user_allowhtml'] )
	{
		$text = preg_replace( '#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $text );
	}
	if ( $board_config['desc_bbcode'] && $userdata['user_allowbbcode'] )
	{
		$text = check_bbcode( $text, $bbcode_uid );
		$text = ( $board_config['allow_bbcode']) ? bbencode_second_pass( $text, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $text );
	}
	else
	{
		$text = preg_replace("/\:$bbcode_uid/si", '', $text );
	}
	if ( $board_config['desc_smile'] && $userdata['user_allowsmile'] )
	{
		$text = smilies_pass( $text );
	}
	
	return $text;
}

function prepare_postparse( $desc, $o_desc, $id )
{
	global $board_config, $Sajax;
		
	if ( $board_config['desc_postparsing'] && is_object( $Sajax ) )
	{
		return "<span id=\"$id\" style=\"cursor: pointer;\" onclick=\"description_postparse( '" . addslashes( $o_desc ). "', '$id' )\">$desc</span>";
	}
	else
	{
		return "<span>$desc</span>";
	}
}

function description_parse( $desc, $id )
{
	return array( $id, parse_desc( $desc, $id ) );
}

// returns the description in the wanted form, the reason why
// the descriptions needs to already be supplied is so we don't
// use another sql query
function fetch_desc ( $topic_desc, $bbcode_uid, $isviewforum = FALSE, $topic_author = '' ) 
{

	global $is_auth, $userdata, $board_config, $post_info, $post_id, $db, $forum_id, $topic_id, $phpEx, $topic_desc4mod, $lang;
	
	if ( $board_config['desc_prev'] ) 
	{
		$sql = "SELECT pt.post_text " .
			"FROM " . POSTS_TEXT_TABLE . " pt LEFT JOIN " . POSTS_TABLE . " p ON p.post_id = pt.post_id LEFT JOIN " . TOPICS_TABLE . " t ON p.post_id=t.topic_first_post_id " .
			"WHERE t.topic_id=$topic_id LIMIT 0,1";
		if ( !( $result = $db -> sql_query( $sql ) ) )
		{
			message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
		}
		$row = $db -> sql_fetchrow( $result );
		$desc = $row['post_text'];
		$desc = ( strlen( $desc ) > $board_config['desc_length'] ) ? substr( $desc, 0, $board_config['desc_length'] ) . '...' : $desc;
		
		$desc = parse_desc( $desc, $bbcode_uid );
		
		return ( $isviewforum ) ? '<br />' . $desc : $desc;
	}
	
	if ( $board_config['desc_linkforce'] )
	{
		if ( empty( $topic_author ) )
		{
			$sql = "SELECT u.username, u.user_id FROM " .
				USERS_TABLE . " u LEFT JOIN " . TOPICS_TABLE . " t ON u.user_id = t.topic_poster " .
				"WHERE t.topic_id = $topic_id LIMIT 0,1";
			if ( !( $result = $db -> sql_query( $sql ) ) )
			{
				message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
			}
			
			$user = $db -> sql_fetchrow ( $result );
			
			$link = append_sid( "profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . $userdata['user_id'] );
			$name = $user['username'];
			$desc = ( $user['user_id'] != ANONYMOUS ) ?'<a href="' . $link . '" border="0">' . $name . '</a>' : '';
		}
		else
		{
			$desc = $topic_author;
		}
			
		return ( $isviewforum ) ? '<br />' . $desc : $desc;
	}
	
	if ( check_descperm ( TRUE ) ) 
	{
		if ( $board_config['desc_tolink'] || $board_config['desc_linkforce'] || ( $board_config['desc_linkempty'] && empty( $topic_desc ) ) ) 
		{
			if ( empty( $topic_author ) )
			{
				$sql = "SELECT u.username, u.user_id FROM " .
					USERS_TABLE . " u LEFT JOIN " . TOPICS_TABLE . " t ON u.user_id = t.topic_poster " .
					"WHERE t.topic_id = $topic_id LIMIT 0,1";
				if ( !( $result = $db -> sql_query( $sql ) ) )
				{
					message_die ( GENERAL_ERROR, 'Failed obtaining tooltip data', '', __LINE__, __FILE__, $sql );
				}
		
				$user = $db -> sql_fetchrow ( $result );
				
				$link = append_sid( "profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . $userdata['user_id'] );
				$name = $user['username'];
				$desc = ( $user['user_id'] != ANONYMOUS ) ?'<a href="' . $link . '" border="0">' . $name . '</a>' : '';
			}
			else
			{
				$desc = $topic_author;
			}
			
			return ( $isviewforum ) ? '<br />' . $desc : $desc;
		}
		else
		{
			$o_topic_desc = $topic_desc;
			$topic_desc = parse_desc( $topic_desc, $bbcode_uid );
			$topic_desc = ( strlen( $post_desc ) > $board_config['desc_length'] ) ? substr( $topic_desc, 0, $board_config['desc_length'] ) . '...' : $topic_desc;
			
			if ( $is_auth[ 'auth_mod' ] && $topic_desc4mod )
			{
				$topic_desc =  '<i>' . $lang[ 'Desc_only4mod' ]. '</i>' . $topic_desc;
			}
			elseif ( $topic_desc4mod ) // this is the last check because it is otherwise hard to make
			{
				$topic_desc = '';
			}
			
			if ( $board_config[ 'desc_postparsing_tool' ] && $isviewforum )
			{
				$tool_postparse = '<br /><a href="#" onclick="tool_postparse( ' . $topic_id . ' );">' . $lang[ 'Desc_parsetool' ] . '</a>';
			}
			
			$topic_desc = ( $isviewforum && !empty( $topic_desc ) ) ? '<br />' . prepare_postparse( $topic_desc, $o_topic_desc, $bbcode_uid ) . $tool_postparse : prepare_postparse( $topic_desc, $o_topic_desc, $bbcode_uid ) . $tool_postparse;
			
			return $topic_desc;
		}
	}
}

?>