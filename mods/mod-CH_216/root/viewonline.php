<?php
//
//	file: viewonline.php
//	author: ptirhiik
//	begin: 21/05/2006
//	version: 1.6.1 - 24/10/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'viewonline';
include($phpbb_root_path . 'common.'.$phpEx);

include($config->url('includes/class_forums'));
include($config->url('includes/class_stats'));
include($config->url('includes/class_stats_online'));

// read forums
$forums = new forums();
$forums->read();

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_VIEWONLINE);
$user->set($requester, array('viewonline', 'class_forums', 'class_stats'));
//
// End session management
//

// no access for bots
if ( $user->data['session_is_bot'] )
{
	message_return('Not_Authorised');
}

// init objects
$user->get_cache(array(POST_FORUM_URL, POST_FORUM_URL . 'jbox'));

// users online stats
$stats_online = new stats_online('in_user');
$stats_online->read();
$stats_online->display();
unset($stats_online);

// page
$navigation = new navigation();
$navigation->add('Who_is_Online', '', 'viewonline', '', '');
$navigation->display();
unset($navigation);

make_jumpbox(INDEX);

// Generate the page
$page_title = $user->lang('Who_is_Online');
include($config->url('includes/page_header'));
$template->set_filenames(array('body' => 'viewonline_body.tpl'));
$template->pparse('body');
include($config->url('includes/page_tail'));

?>