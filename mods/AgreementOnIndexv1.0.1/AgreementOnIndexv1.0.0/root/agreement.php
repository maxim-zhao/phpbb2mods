<?php
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//

$page_title = $lang['index_terms'];

$sql = "SELECT * FROM " . AGREEMENT_TABLE . " WHERE config_name = 'agreement_body'";
	if (!($result= $db->sql_query($sql)) ) 
		{	
			message_die(GENERAL_ERROR, "Could not obtain agreement text!", "", __LINE__, __FILE__, $sql);
		}

$row = $db->sql_fetchrow($result);
$terms = $row['config_value'];

include($phpbb_root_path .'includes/page_header.'. $phpEx);

		$template->set_filenames(array(
			'body' => 'index_agreement_body.tpl')
);


	$template->assign_vars(array(
			'U_AGREED' => append_sid('index.'.$phpEx.'?agreed=true'),
			'U_NOT' => append_sid('index.'.$phpEx.'?agreed=false'),
			'L_AGREED' => $lang['index_agree'],
			'L_NOT' => $lang['index_do_not_agree'],

			'TERMS' => $terms)
);
				  
$template->pparse('body'); 
include($phpbb_root_path .'includes/page_tail.'. $phpEx);
?>