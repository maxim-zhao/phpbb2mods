<?php
//
//	file: language/lang_english/lang_extend_uprune.php
//	author: ptirhiik
//	begin: 26/01/2006
//	version: 1.6.1 - 23/06/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

if ( $is['admin'] )
{
	$lang['Users_prune'] = 'Prune users';
	$lang['Users_prune_explain'] = 'Here you can prune inactive users.';
	$lang['Users_pruned'] = '%d inactive users have been pruned.';
	$lang['Users_prune_admin'] = 'You are trying to delete an admin or the guest profile.';

	$lang['Users_prune_days'] = 'Registered since';
	$lang['Users_prune_days_explain'] = 'Prune users registered since more than this number of days having 0 posts';
	$lang['Users_prune_inactive_only'] = 'Prune not activated profiles only';

	$lang['Click_return_users_prune'] = 'Click %sHere%s to return to Users prune.';
}

?>