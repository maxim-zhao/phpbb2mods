<?php 
/***************************************************************************
 *                           search_engine_list.php
 *                            -------------------
 *   begin                : Sunday, May 02, 2005
 *   copyright            : (C) 2005 FuNEnD3R
 *   email                : admin@funender.com
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


/**** CHANGE THIS NAME TO YOUR OWN SITE WITHOUT THE .COM/.NET/ORG/.DE/ETC AT THE END
***** IF YOUR SITE NAME IS BOB.COM FOR EXAMPLE, ONLY USE THE WORD BOB AND LEAVE OUT THE .COM ****/ 

   $sname= 'SITE_NAME_GOES_HERE'; 
     
/***********************************
 *
 *   NO NEED TO EDIT ANYTHING BELOW THIS LINE  
 * 
 *************************************/
  

define('IN_PHPBB', true); 

$phpbb_root_path = './'; 

include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_search_engine_list.' . $phpEx);

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

$page_title = $lang['Slist'];

include($phpbb_root_path . 'includes/page_header.'.$phpEx); 

// Search Engines

	$yahoo = 'http://search.yahoo.com/search?p=' . $sname . '';
	$msn = 'http://search.msn.com/results.aspx?q=' . $sname . '';
	$lycos = 'http://mia-search.mia.lycos.com/default.asp?query=' . $sname . '';
	$dogpile = 'http://www.dogpile.com/info.dogpl/search/web/' . $sname . '';
	$google = 'http://www.google.com/search?hl=en&q=' . $sname . '';
	$altavista = 'http://www.altavista.com/web/results?q=' . $sname . '';
	$teoma = 'http://s.teoma.com/search?q=' . $sname . '';
	$anine = 'http://a9.com/' . $sname . '';
	$hotbot = 'http://www.hotbot.com/default.asp?query=' . $sname . '';
	$webcrawler = 'http://msxml.webcrawler.com/info.wbcrwl/search/web/' . $sname . '';
	$babieca = 'http://www.babieca.com/cgi-bin/engine/smartsearch.cgi?keywords=' . $sname . '';
	$brainboost = 'http://www.brainboost.com/search.asp?Q=' . $sname . '';
	$netscape = 'http://search.netscape.com/ns/search?query=' . $sname . '';
	$looksmart = 'http://www.looksmart.com/r_search?key=' . $sname . '';
	$excite = 'http://msxml.excite.com/info.xcite/search/web/' . $sname . '';
	$alltheweb = 'http://www.alltheweb.com/search?q=' . $sname . '';
	$metawebsearch = 'http://www.metawebsearch.com/cgi-bin/search.cgi?term=' . $sname . '';
	$aol = 'http://search.aol.com/aolcom/search?invocationType=topsearchbox.webhome&query=' . $sname . '';
	$search = 'http://www.search.com/search?q=' . $sname . '';
	$askjeeves = 'http://web.ask.com/web?q=' . $sname . '';



$template->set_filenames(array( 
    'body' => 'search_engine_list.tpl' 
    ) 
); 

$template->assign_vars(array( 
    'L_HEADER' => $lang['Sheader'],
	'L_YAHOO' => $lang['Syahoo'],
	'L_MSN' => $lang['Smsn'],
	'L_LYCOS' => $lang['Slycos'],
	'L_DOGPILE' => $lang['Sdogpile'],
	'L_GOOGLE' => $lang['Sgoogle'],
	'L_ALTAVISTA' => $lang['Saltavista'],
	'L_TEOMA' => $lang['Steoma'],
	'L_A9' => $lang['Sanine'],
	'L_HOTBOT' => $lang['Shotbot'],
	'L_WEBCRAWLER' => $lang['Swebcrawler'],
	'L_BABIECA' => $lang['Sbabieca'],
	'L_BRAINBOOST' => $lang['Sbrainboost'],
	'L_NETSCAPE' => $lang['Snetscape'],
	'L_LOOKSMART' => $lang['Slooksmart'],
	'L_EXCITE' => $lang['Sexcite'],
	'L_ALLTHEWEB' => $lang['Salltheweb'],
	'L_METAWEBSEARCH' => $lang['Smetawebsearch'],
	'L_AOL' => $lang['Saol'],
	'L_SEARCH' => $lang['Ssearch'],
	'L_ASK_JEEVES' => $lang['Saskjeeves'],
	'L_INFO' => $lang['Sinfo'],
	'SNAME' => $sname,
	
   	'U_YAHOO' => $yahoo,
	'U_MSN' => $msn,
	'U_LYCOS' => $lycos,
	'U_DOGPILE' => $dogpile,
	'U_GOOGLE' => $google,
	'U_ALTAVISTA' => $altavista,
	'U_TEOMA' => $teoma,
	'U_A9' => $anine,
	'U_HOTBOT' => $hotbot,
	'U_WEBCRAWLER' => $webcrawler,
	'U_BABIECA' => $babieca,
	'U_BRAINBOOST' => $brainboost,
	'U_NETSCAPE' => $netscape,
	'U_LOOKSMART' => $looksmart,
	'U_EXCITE' => $excite,
	'U_ALLTHEWEB' => $alltheweb,
	'U_METAWEBSEARCH' => $metawebsearch,
	'U_AOL' => $aol,
	'U_SEARCH' => $search,
	'U_ASK_JEEVES' => $askjeeves
    ) 
); 

$template->pparse('body'); 


include('includes/page_tail.'.$phpEx); 

?>