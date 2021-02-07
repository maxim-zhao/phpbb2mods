##############################################################
## MOD Title:		Custom Title Mod for Profile Control Panel 2.0.0-1
## MOD Author: jrg3 < phpbb@grifent.com > (John) http://www.grifent.com/
## MOD Description:	This mod is an add-on of the Custom Title Mod version 1.0.2 from Aexoden < gerek@softhome.net >
##			(Jason Lynch) http://www.aexoden.com
##			to Profile Control Panel 2.0.0-1 by Ptirhiik < admin@rpgnet-fr.com > (Pierre) http://rpgnet.clanmckeen.com
##
##
## MOD Version:		1.0.2-1
##
## Installation Level:	Easy
## Installation Time:	10 Minutes
## Files To Edit:
##			profilcp/def/def_userfuncs_std.php
##			profilcp/profilcp_profil_signature.php
##			templates/subSilver/profilcp/profil_signature_body.tpl
##
## Included Files:
##
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
## Or my board http://www.grifent.com/forums/viewtopic.php?t=992
##############################################################
##
## Author Notes:
##
##  Copyright   Griffiths Enterprises, Inc. 2004 - http://www.grifent.com/
##
## ** No Placement Of This MOD At Sites Other Than www.phpbb.com or www.grifent.com Without My Permission.
##
##	This is not a complete install. The Custom Title Mod version 1.0.2 must be installed, and
##	the Profile Control Panel 2.0.0-1 must be installed.
##
##	Additional feature of the profile cp :
##	- Custom Titles are added to profile
##
##
##############################################################
##
## MOD History:
##
##   2004-08-02 - Version 1.0.2-1
##			use htmlspecialchars and stripslashes functions  instead of str_replace function
##
##   2004-01-26 - Version 1.0.1-2
##			Added Security statement and removed empty SQL and COPY section
##			MOD passed phpBB MOD template verification
##
##   2004-01-24 - Version 1.0.1-1
##			Correct MOD History dates - DUH - copy and paste error
##			Correct typo of file name of profilcp/profilcp_profil_signature.php
##			Added edit of file profilcp/def/def_userfuncs_std.php - a DUH moment
##			Added section left out of edit of profilcp/profilcp_signature_body.php
##
##   2004-01-19 - Version 1.0.0
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------------
#
profilcp/def/def_userfuncs_std.php
#
#-----[ FIND ]------------------------------------------------
#
function pcp_output_rank_title($field_name, $view_userdata, $map_name='')
{
	global $board_config, $phpbb_root_path, $phpEx, $lang, $images, $userdata;
	global $values_list, $tables_linked, $classes_fields, $user_maps, $user_fields;

	if ( $view_userdata['user_id'] != ANONYMOUS )
	{
		$rank = get_user_rank($view_userdata);
		$txt = $rank['rank_title'];
		$img = $rank['rank_image'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Custom Title MOD
//
//
// Verify Custom Title Status
//
/* Uncomment this section if you don't want custom title to appear even if it is defined but the user does not meet criteria
		$membertime = ($mode != 'register') ? (time() - $userdata['user_regdate']) : 0;
		if (( $view_userdata['user_custom_title_status'] == CUSTOM_TITLE_ENABLED ) ||
			(( $view_userdata['user_custom_title_status'] == CUSTOM_TITLE_REGDATE ) &&
			( $membertime >= $board_config['custom_title_days'] * 86400) &&
			( $view_userdata['user_posts'] >= $board_config['custom_title_posts'])))
*/
		{
			if ( !empty($view_userdata['user_custom_title']) )
			{
				switch( $board_config['custom_title_mode'] )
				{
					case CUSTOM_TITLE_MODE_INDEPENDENT:
						$txt = $view_userdata['user_custom_title'] . "<br />" . $txt;
						break;
					case CUSTOM_TITLE_MODE_REPLACE_RANK:
						$txt = $view_userdata['user_custom_title'];
						break;
					case CUSTOM_TITLE_MODE_REPLACE_BOTH:
						$txt = $view_userdata['user_custom_title'];
						$img = '';
						break;
					default:
						break;
				}
			}
		}
//
// Custom Title MOD End
//
#
#-----[ OPEN ]------------------------------------------------
#
profilcp/profilcp_profil_signature.php
#
#-----[ FIND ]------------------------------------------------
#
if ( !empty($setmodules) )
{
	if ($board_config['allow_sig'])
#
#-----[ BEFORE, ADD ]------------------------------------------
#

//
// Custom Title MOD
//
//
// Verify Custom Title Status
//
$membertime = ($mode != 'register') ? (time() - $userdata['user_regdate']) : 0;
$custom_title_activated = FALSE;
if (( $userdata['user_custom_title_status'] == CUSTOM_TITLE_ENABLED ) ||
	(( $userdata['user_custom_title_status'] == CUSTOM_TITLE_REGDATE ) &&
	( $membertime >= $board_config['custom_title_days'] * 86400) &&
	( $userdata['user_posts'] >= $board_config['custom_title_posts'])))
{
	$custom_title_activated = TRUE;
	$lang['profilcp_signature_shortcut'] = $lang['Custom_title'] . '/Signature';
}
//
// Custom Title MOD End
//

#
#-----[ FIND ]------------------------------------------------
#
//
// template file
$template->set_filenames(array(
	'body' => 'profilcp/profil_signature_body.tpl')
);

if ($submit || $preview)
{
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Custom Title MOD
//
        $custom_title =  htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['custom_title'])) ); // new
	// Verify the user is allowed to alter their custom title.  If not, replace it with their old one.
	if ($custom_title_activated == FALSE)
	{
		$custom_title = addslashes($view_userdata['user_custom_title']);
	}

	// Check the length of the custom title.  Prevents people from editing the HTML to get a longer one.
	if (strlen($custom_title) > $board_config['custom_title_maxlength'])
	{
		if ($custom_title != addslashes($view_userdata['user_custom_title'])) {
			$custom_title = addslashes($view_userdata['user_custom_title']);
			$error = TRUE;
			if (isset($error_msg)) $error_msg .= '<br />';
			$error_msg .= $lang['Custom_title_toolong'];
		}
	}
//
// Custom Title MOD End
//

#
#-----[ FIND ]------------------------------------------------
#
	$signature_bbcode_uid = $view_userdata['user_sig_bbcode_uid'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Custom Title MOD
//
		$custom_title = stripslashes($custom_title);
//
// Custom Title MOD End
//
#
#-----[ FIND ]------------------------------------------------
#
	if ( $error )
	{
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Custom Title MOD
//
	$custom_title = stripslashes($custom_title);
//
// Custom Title MOD End
//
#
#-----[ FIND ]------------------------------------------------
#
		$sql = "UPDATE " . USERS_TABLE . "
				SET
					user_sig = '" . $signature . "',
					user_sig_bbcode_uid = '" . $signature_bbcode_uid . "'
				WHERE
					user_id = " . $view_userdata['user_id'];
#
#-----[ REPLACE WITH ]------------------------------------------
#
//
// Custom Title MOD
//
//-- delete
//		$sql = "UPDATE " . USERS_TABLE . "
//				SET
//					user_sig = '" . $signature . "',
//					user_sig_bbcode_uid = '" . $signature_bbcode_uid . "'
//				WHERE
//					user_id = " . $view_userdata['user_id'];
//-- add
		$sql = "UPDATE " . USERS_TABLE . "
				SET
					user_sig = '" . $signature . "',
					user_sig_bbcode_uid = '" . $signature_bbcode_uid . "',
					user_custom_title = '" . $custom_title . "'
				WHERE
					user_id = " . $view_userdata['user_id'];
//
// Custom Title MOD End
//
#
#-----[ FIND ]------------------------------------------------
#
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update user table', '', __LINE__, __FILE__, $sql);
		}
	}
}
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Custom Title MOD
//
	switch($board_config['custom_title_mode'])
	{
		case CUSTOM_TITLE_MODE_INDEPENDENT:
			$custom_title_mode_explain = $lang['Custom_title_independent_explain'];
			break;
		case CUSTOM_TITLE_MODE_REPLACE_RANK:
			$custom_title_mode_explain = $lang['Custom_title_replace_rank_explain'];
			break;
		case CUSTOM_TITLE_MODE_REPLACE_BOTH:
			$custom_title_mode_explain = $lang['Custom_title_replace_both_explain'];
			break;
		default:
			break;
	}
//
// Custom Title MOD End
//
#
#-----[ FIND ]------------------------------------------------
#
if (!$submit)
{
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Custom Title MOD
//
	$custom_title = $view_userdata['user_custom_title'];
//
// Custom Title MOD End
//
#
#-----[ FIND ]------------------------------------------------
#
		'L_BBCODE_CLOSE_TAGS'	=> $lang['Close_Tags'],
		'L_STYLES_TIP'			=> $lang['Styles_tip'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Custom Title MOD
//
		'CUSTOM_TITLE' => $custom_title,
		'CUSTOM_TITLE_MAXLENGTH' => $board_config['custom_title_maxlength'],
		'L_CUSTOM_TITLE' => $lang['Custom_title'],
		'L_CUSTOM_TITLE_EXPLAIN' => sprintf($lang['Custom_title_explain'], $custom_title_mode_explain, $board_config['custom_title_maxlength']),
//
// Custom Title MOD End
//
//
#
#-----[ FIND ]------------------------------------------------
#
	// page
	$template->pparse('body');
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// Custom Title MOD
//
	if ($custom_title_activated == TRUE)
	{
		$template->assign_block_vars('switch_custom_title', array() );
	}
//
// Custom Title MOD End
//
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/profilcp/profil_signature_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
<tr>
	<td valign="top" align="center">
		<table cellpadding="4" cellspacing="1" border="0" class="forumline">
#
#-----[ AFTER, ADD ]------------------------------------------
#
		<!-- Custom Title MOD -->
		<!-- BEGIN switch_custom_title -->
		<tr>
			<th colspan="2" valign="middle">{L_CUSTOM_TITLE}</th>
		</tr>
		<tr>
			<td class="row2"><span class="gensmall">{L_CUSTOM_TITLE_EXPLAIN}</span></td>
			<td class="row2">
				<input type="text" class="post"style="width: 200px"  name="custom_title" size="45" maxlength="{CUSTOM_TITLE_MAXLENGTH}" value="{CUSTOM_TITLE}" />
			</td>
		</tr>
		<!-- END switch_custom_title -->
		<!-- Custom Title MOD End -->
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
