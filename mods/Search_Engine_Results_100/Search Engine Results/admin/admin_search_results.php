<?php
/***************************************************************************
 *                               admin_search_results.php
 *                            -------------------
 *   begin                : Friday, May 13, 2005
 *   copyright          : (C) 2005 Battye @ CricketMX.com
 *   email                : cricketmx@hotmail.com
 *
 *   $Id: admin_search_results.php, v1.000.0.00 2004/08/24 19:14:44 battye Exp $
 *
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

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Search Results'] = $filename;

	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$template->set_filenames(array('main' => 'admin/admin_search_results_body.tpl'));

// Say you don't want the default to be the sitename?
$board_config_sitename = $board_config['sitename']; 
// Set it to $board_config_sitename = "My Default";

$sitename = ( isset($HTTP_POST_VARS['term']) ) ? str_replace(' ', '+', $HTTP_POST_VARS['term']) : str_replace(' ', '+', $board_config_sitename);
	
// Borrowed from Sitepoint (but edited heavily)
// Logo's & search engines are property of their respective owners
//
// www.google.com - Google
// www.msn.com - MSN
// www.altavista.com - Altavista
// www.askjeeves.com - Ask Jeeves
// www.yahoo.com - Yahoo!

$msn_page = "<a href=http://search.msn.com/results.aspx?q=" . $sitename . "&FORM=QBRE>" . $lang['SRM_MSN'] . "</a>";			  
$msn_address = 'http://search.msn.com/results.aspx?q=' . $sitename . '&FORM=QBRE';
$msn_pattern= '/of (\d[\d,]*) containing/';
preg_match($msn_pattern, file_get_contents($msn_address), $msn_info);

	if(!isset($msn_info[1]))
	{
	$msn_info[1] = '-';
	}
	
$google_page = "<a href=http://www.google.com/search?q=" . $sitename . "&hl=en>" . $lang['SRM_Google'] . "</a>";	
$google_address = 'http://www.google.com/search?q=' . $sitename . '&hl=en';
$google_pattern = '/of about <b>(\d[\d,]*)<\/b>/';
preg_match($google_pattern, file_get_contents($google_address), $google_info);

	if(!isset($google_info[1]))
	{
	$google_info[1] = '-';
	}

$altavista_page = "<a href=http://www.altavista.com/web/results?itag=ody&q=" . $sitename . "&kgs=1&kls=0>" . $lang['SRM_Altavista'] . "</a>";	
$altavista_address = 'http://www.altavista.com/web/results?itag=ody&q=' . $sitename . '&kgs=1&kls=0';
$altavista_pattern = '/found (\d[\d,]*) results/';
preg_match($altavista_pattern, file_get_contents($altavista_address), $altavista_info);

	if(!isset($altavista_info[1]))
	{
	$altavista_info[1] = '-';
	}

$yahoo_page = "<a href=http://search.yahoo.com/search?p=" . $sitename . "&prssweb=Search&ei=UTF-8&fr=FP-tab-web-t&fl=0&x=wrt>" . $lang['SRM_Yahoo'] . "</a>";	
$yahoo_address = 'http://search.yahoo.com/search?p=' . $sitename . '&prssweb=Search&ei=UTF-8&fr=FP-tab-web-t&fl=0&x=wrt';
$yahoo_pattern = '/about <strong>(\d[\d,]*)<\/strong> for/';
preg_match($yahoo_pattern, file_get_contents($yahoo_address), $yahoo_info);

	if(!isset($yahoo_info[1]))
	{
	$yahoo_info[1] = '-';
	}

$aj_page = "<a href=http://web.ask.com/web?q=" . $sitename . "&qsrc=0&o=0>" . $lang['SRM_Askjeeves'] . "</a>";	
$aj_address = 'http://web.ask.com/web?q=' . $sitename . '&qsrc=0&o=0';
$aj_pattern = '/of&nbsp;(\d[\d,]*)<\/td>/';
preg_match($aj_pattern, file_get_contents($aj_address), $aj_info);

	if(!isset($aj_info[1]))
	{
	$aj_info[1] = '-';
	}

	
	$template->assign_vars(array(
			  'SEARCH_ENGINE' => $lang['SRM_Search_Engine'],
			  'RESULTS' => $lang['SRM_Number_Of_Results'],
			  'SUBMIT' => $lang['SRM_Submit'],
			  'ENTER' => $lang['SRM_Enter'],
			  'FORM' => append_sid("admin_search_results.$phpEx"),
			  'COOKIE' => str_replace('+', ' ', $sitename),
			  'MSN_PAGE' => $msn_page,
			  'MSN_FOUNDRESULT' => @$msn_info[1],
			  'GOOGLE_PAGE' => $google_page,
			  'GOOGLE_FOUNDRESULT' => @$google_info[1],
			  'ALTAVISTA_PAGE' => $altavista_page,
			  'ALTAVISTA_FOUNDRESULT' => @$altavista_info[1],
			  'YAHOO_PAGE' => $yahoo_page,
			  'YAHOO_FOUNDRESULT' => @$yahoo_info[1],
			  'ASKJEEVES_PAGE' => $aj_page,
			  'ASKJEEVES_FOUNDRESULT' => @$aj_info[1]));
			  
$template->pparse('main');
include('page_footer_admin.php'); 
?>