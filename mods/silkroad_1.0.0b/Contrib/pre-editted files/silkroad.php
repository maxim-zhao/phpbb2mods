<?php
/***************************************************************************
 *                              silkroad.php
 *                            -------------------
 *   begin                : Wednesday, Sept 20, 2006
 *   copyright         : (C) 2006 The Exiled
 *   email                : noxwizard@gmail.com
 *
  *	Silkroad Online is a registered trademark of Joymax Co., Ltd
 *
 ***************************************************************************/
 
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config[ 'default_lang' ] . '/lang_silkroad.' . $phpEx );

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_PROFILE);
init_userprefs($userdata);
//
// End session management
//

// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

//
// Start of program proper
//
if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_GET_VARS['mode']) ) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);

	if ( $mode == 'viewprofile' )
	{
		include($phpbb_root_path . 'includes/silkroad_viewprofile.'.$phpEx);
		exit;
	}
	else if ( $mode == 'editprofile')
	{
		if ( !$userdata['session_logged_in'] && $mode == 'editprofile' )
		{
			redirect(append_sid("login.$phpEx?redirect=silkroad.$phpEx&mode=editprofile", true));
		}

		include($phpbb_root_path . 'includes/silkroad_editprofile.'.$phpEx);
		exit;
	}
}

redirect(append_sid("index.$phpEx", true));

?>