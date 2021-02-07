<?php
/*
 *Music Page MOD
 *By John F. R. (subAVLHPF) 
 *EMail: watt.john.runyon@gmail.com
 *Personal Website: http://avlhpf.org
 *Version: 2.0.0
 *|-Added ability to sort songs.
 *|-Added use of SQL
 *`-Looking for a coder to make a flash player for mp3's
*/

/*
 * This variable determines whether or not to sort the $songs array.
 * true = sorted. false = not sorted. 
*/
$sortsongs = true;

$music = basename(__FILE__);
$phpbb_root_path = './';
define('IN_PHPBB', true);
include($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'common.' . $phpEx);
$userdata = session_pagestart($user_ip, PAGE_MUSIC);
init_userprefs($userdata);
$page_title = $lang['music']['page']['title'];
include($phpbb_root_path . 'includes/page_header.' . $phpEx);
$template->set_filenames(
	array(
		'body' => 'music.tpl'
	)
);
$template->assign_var('LANG_AUTHOR', $lang['music']['th']['author']);
$template->assign_var('LANG_SONG', $lang['music']['th']['song']);

/*
 * Getting songs list
*/
$sql = 'SELECT * FROM ' . $table_prefix . 'music';
if ( !$result = $db->sql_query($sql) ) {
	message_die(GENERAL_ERROR, 'Could not find song info');
}
while ($row = $db->sql_fetchrow($result)) {
	$names[]	= $row['name'];
	$link[]		= $row['link'];
	$code[]		= $row['code'];
};
foreach ($link as $key => $attr) {
	if ($HTTP_GET_VARS['song']==$attr) {
		$embedcode = stripslashes($code[$key]);
	};
};
foreach ($link as $key2 => $attr2) {
	$songs[$attr2] = stripslashes($names[$key2]);
}

//Sorting the songs list is it is configured to do so...
if ($sortsongs) {
	asort($songs);
}

foreach ($songs as $url => $song) {
	$template->assign_block_vars('repeat_table', array(
		'SONG' => $song,
		'URL_SONG' => append_sid($music.'?song='.$url))
	);
}

if (isset($HTTP_GET_VARS['song'])) {
	$template->assign_block_vars('switch_player', array(
		'PLAYER_TITLE' => $lang['music']['th']['player'],
		'EMBED_CODE' => $embedcode)
	);
}

if (isset($lang['musicintro']) && !empty($lang['musicintro'])) {
	$template->assign_block_vars('switch_musicintro',array('TH_MUSICINTRO'=>$lang['th_musicintro'], 'MUSICINTRO'=>$lang['musicintro']) );
}

$template->pparse('body');

//Page Footer
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
