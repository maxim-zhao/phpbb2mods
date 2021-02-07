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


// 

// Start output of page 

// 

$page_title = $lang['Mheader']; 


include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

// FAQ icon
$img_faq = '<img src="' . $images['faq'] . '" alt="' . $lang['faqimg'] . '" border="0"';
// End FAQ icon

$template->set_filenames(array( 
    'body' => 'meta_tag_creator.tpl' 
    ) 
); 

$template->assign_vars(array( 
    'L_INTRO' => $lang['Mintro'],
    'L_HEADER' => $lang['Mheader'],
	'L_WHAT' => $lang['Mwhat'],
	'L_EXPLAIN' => $lang['Mexplain'],
	'L_SITE_TITLE' => $lang['Msite_title'],
	'L_DESCRIPTION' => $lang['Mdescription'],
    'L_LENGTH' => $lang['Mlength'],
	'L_KEYWORDS' => $lang['Mkeywords'],
	'L_SITE_AUTHOR' => $lang['Msite_author'],
	'L_WROTE' => $lang['Mwrote'],
	'L_ROBOTS' => $lang['Mrobots'],
    'L_ALL' => $lang['Mall'],
	'L_NONE' => $lang['Mnone'],
	'L_MINDEX' => $lang['Mindex'],
	'L_NOINDEX' => $lang['Mnoindex'],
	'L_FOLLOW' => $lang['Mfollow'],
	'L_NOFOLLOW' => $lang['Mnofollow'],
	'L_CREATE' => $lang['Mcreate'],
	'L_CLEAR' => $lang['Mclear'],
	'IMG_FAQ' => $img_faq
	 ) 
); 

$template->pparse('body');


include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
