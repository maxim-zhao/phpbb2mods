<?php
//
//	file: faq.php
//	author: ptirhiik
//	begin: 06/06/2006
//	version: 1.6.1 - 09/02/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'faq';
include($phpbb_root_path . 'common.'.$phpEx);

// read mode
$mode = _read('mode', TYPE_NO_HTML);

// plugs
if ( $config->plug_ins[$requester] )
{
	foreach ( $config->plug_ins[$requester] as $plug => $dummy )
	{
		if ( method_exists($config->plug_ins[$requester][$plug], 'start') )
		{
			$config->plug_ins[$requester][$plug]->start();
		}
	}
}

// init session
$userdata = session_pagestart($user_ip, PAGE_FAQ);
$user->set($requester, 'faq');

$navigation = new navigation();
$navigation->add('FAQ', '', 'faq', '', '');
$navigation->display();

$faq = array();
switch ( $mode )
{
	case 'bbcode':
		$title = 'BBCode_guide';
		include($config->url('language/lang_' . $user->lang_used . '/lang_bbcode'));
		break;

	default:
		$title = 'FAQ';
		include($config->url('language/lang_' . $user->lang_used . '/lang_faq'));
		break;
}

// plugs
if ( $config->plug_ins[$requester] )
{
	foreach ( $config->plug_ins[$requester] as $plug => $dummy )
	{
		if ( method_exists($config->plug_ins[$requester][$plug], 'get') )
		{
			$config->plug_ins[$requester][$plug]->get($mode);
		}
	}
}

$count_faq = count($faq);
$color = false;
for ( $i = 0; $i < $count_faq; $i++ )
{
	$a_id = POST_POST_URL . ($i + 1);
	$p_id = array(POST_POST_URL => $i + 1);
	if ( $faq[$i][0] == '--' )
	{
		$template->assign_block_vars('faq_block', array(
			'BLOCK_TITLE' => $faq[$i][1],
			'U_FAQ_ID' => $a_id,
			'U_FAQ' => $config->url($requester, $p_id, true, $a_id),
		));
		$color = false;
	}
	else
	{
		$color = !$color;
		$row_color = $color ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = $color ? $theme['td_class1'] : $theme['td_class2'];
		$template->assign_block_vars('faq_block.faq_row', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'FAQ_QUESTION' => $faq[$i][0],
			'FAQ_ANSWER' => $faq[$i][1],
			'U_FAQ_ID' => $a_id,
			'U_FAQ' => $config->url($requester, $p_id, true, $a_id),
		));
		$template->set_switch('faq_block.faq_row.light', $color);
	}
}

// constants
$template->assign_vars(array(
	'L_FAQ_TITLE' => $user->lang($title),
	'L_BACK_TO_TOP' => $user->lang('Back_to_top'),
	'I_BACK_TO_TOP' => $user->img('icon_go_top'),
));

$page_title = $user->lang($title);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
$template->set_filenames(array('body' => 'faq_body.tpl'));
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>