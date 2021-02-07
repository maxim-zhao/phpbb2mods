<?php
/***************************************************************************
 *                                slippage.php
 *                            -------------------
 *   begin                : Tuesday, March 23, 2005
 *   copyright            : (C) 2005 Elite Computing Services
 *   email                : mikel.beck@elite-computing.net
 *
 *   $Id: slippage.php,v 1.0.1 2005/03/23 08:43:00 mikelbeck Exp $
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

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX, $board_config['session_length']); 
init_userprefs($userdata);
//
// End session management
//

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);

	if ($mode == 'calculate')
	{
		$slippage_mph = htmlspecialchars($HTTP_POST_VARS['slippage_mph']);
		$slippage_ratio = htmlspecialchars($HTTP_POST_VARS['slippage_ratio']);
		$slippage_trap_rpm = htmlspecialchars($HTTP_POST_VARS['slippage_trap_rpm']);
		$slippage_tire_height = htmlspecialchars($HTTP_POST_VARS['slippage_tire_height']);

		if (!is_numeric($HTTP_POST_VARS['slippage_mph']) ||
		    !is_numeric($HTTP_POST_VARS['slippage_ratio']) ||
		    !is_numeric($HTTP_POST_VARS['slippage_trap_rpm']) ||
		    !is_numeric($HTTP_POST_VARS['slippage_tire_height']) )
		{
			$error_msg = $lang['Slippage_Error'];
		
			$template->set_filenames(array(
				'reg_header' => 'error_body.tpl')
			);

			$template->assign_vars(array(
				'ERROR_MESSAGE' => $error_msg)
			);
			$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
		}
		else
		{
			$slippage_percent = number_format (100 - ($slippage_mph * $slippage_ratio * 105600) / ($slippage_trap_rpm * ($slippage_tire_height * M_PI)), 2, '.', '');
		}
	}
}

//
// Generate page
//
$page_title = $lang['Slippage'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'body' => 'slippage_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

$template->assign_vars(array(
	'L_SLIPPAGE' => $lang['Slippage'],
	'L_SLIPPAGE_MPH' => $lang['Slippage_MPH'],
	'L_SLIPPAGE_RATIO' => $lang['Slippage_Ratio'],
	'L_SLIPPAGE_TRAP_RPM' => $lang['Slippage_Trap_RPM'],
	'L_SLIPPAGE_TIRE_HEIGHT' => $lang['Slippage_Tire_Height'],
	'L_SLIPPAGE_PERCENT' => $lang['Slippage_Percent'],
	'L_SLIPPAGE_SUBMIT' => $lang['Slippage_Submit'],
	'L_SLIPPAGE_RESET' => $lang['Slippage_Reset'],
	'L_SLIPPAGE_VERSION' => $lang['Slippage_Version'],
	'L_SLIPPAGE_COPYRIGHT' => $lang['Slippage_Copyright'],
	'SLIPPAGE_MPH' => $slippage_mph,
	'SLIPPAGE_RATIO' => $slippage_ratio,
	'SLIPPAGE_TRAP_RPM' => $slippage_trap_rpm,
	'SLIPPAGE_TIRE_HEIGHT' => $slippage_tire_height,
	'SLIPPAGE_PERCENT' => isset($slippage_percent) ? $slippage_percent . '%' : '00.00%',
	'SLIPPAGE_ACTION' => append_sid("slippage.$phpEx?mode=calculate"))
);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>