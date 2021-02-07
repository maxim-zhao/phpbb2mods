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

$page_title = $lang['MResults']; 

include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

// Begin Meta Tag Code

        // Strip HTML 
   		$title = strip_all($HTTP_POST_VARS['title']); 
   		$author = strip_all($HTTP_POST_VARS['author']); 
   		$description = strip_all($HTTP_POST_VARS['description']);
		$keywords = strip_all($HTTP_POST_VARS['keywords']);
		
		function strip_all($string) { 
        return strip_tags(stripslashes($string)); 
        } 
		// End Strip HTML
   
         // Dropdown menu
		$robots = $HTTP_POST_VARS['robots'];
		// End Dropdown menu
		
// End Meta Tag Code

$template->set_filenames(array( 
    'body' => 'meta_tag_results.tpl' 
    ) 
); 

$template->assign_vars(array( 
    'TITLE' => $title,
	'DESCRIPTION' => $description,
	'KEYWORDS' => $keywords,
	'AUTHOR' => $author,
	'ROBOTS' => $robots,
	'L_HEADER' => $lang['Mheader'],
	'L_SITE_TITLE' => $lang['Msite_title'],
	'L_DESCRIPTION' => $lang['Mdescription'],
    'L_LENGTH' => $lang['Mlength'],
	'L_KEYWORDS' => $lang['Mkeywords'],
	'L_SITE_AUTHOR' => $lang['Msite_author'],
	'L_WROTE' => $lang['Mwrote'],
	'L_ROBOTS' => $lang['Mrobots'],
	'L_META' => $lang['Mmeta'],
	'L_BACK' => $lang['Mback'],
    'L_COPY' => $lang['Mcopy'],
	'L_RTITLE' => $lang['Mrtitle'],
	'L_RDESCRIPTION' => $lang['Mrdescription'],
	'L_RKEYWORDS' => $lang['Mrkeywords'],
	'L_RAUTHOR' => $lang['Mrauthor'],
	'L_RROBOTS' => $lang['Mrrobots'],
	'L_CONTENT' => $lang['Mcontent']
	 ) 
); 

$template->pparse('body');


include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
