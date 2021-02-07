##############################################################
## MOD Title: Inline Banner Ad
## MOD Author: geocator < geocator@gmail.com > (Brian) http://www.geocator.us
## MOD Description: Allows placement of banner ads inline with posts. Contains a variety of options to control display behavior
## MOD Version: 1.0.3
## 
## Installation Level: Moderate
## Installation Time: 14 minutes
## Files To Edit: viewtopic.php
##                includes/constants.php
##                templates/subSilver/overall_header.tpl
##                templates/subSilver/viewtopic_body.tpl
##                language/lang_english/lang_main.php
##                language/lang_english/lang_admin.php
## Included Files: (admin_inline_ad.php, inline_ad_config_body.tpl, admin_inline_ad_code.php, inline_ad_code_body.tpl, inline_ad_code_edit.tpl)
## Generator: MOD Studio 3.0 Alpha 1 [mod functions 0.2.1677.25348]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 
##############################################################
## MOD History:
## 
##   2005-07-13 - Version 1.0.3
## 
##      - Various Optimizations
##      - Added srand() for php compatibility
##
##   2005-06-18 - Version 1.0.2
## 
##      - Exclude Forums Fix
##      - Various code clean-ups
##
##   2005-06-15 - Version 1.0.1
## 
##      - Minor changes for MOD Validation
##
##   2005-06-05 - Version 1.0.0
## 
##      - MOD DB Release
##      - Fixed admin styling bug
##
##   2005-05-01 - Version 0.2.0
## 
##      - Added psedo random rotation
##		- Added new display mode/style
##		- Added post threshold to disable ads for a user
##		- Heavy code rework for performance and cleanliness
##		- DB Schema Cahnges
##
##   2005-03-15 - Version 0.0.5
## 
##      - Added ability to exclude specific groups from ad display
## 
##   2005-02-27 - Version 0.0.4
## 
##      - Added ability to configure what forums ad is displayed in
##      - Added ability to configure who ad is displayed to
##      - Added ability to configure placement of ad in topic
## 
##   2004-10-16 - Version 0.0.3
## 
##      - Now has own table and admin page
## 
##   2004-10-14 - Version 0.0.2
## 
##      - Changed to admin panel, now works for any ad code
## 
##   2004-10-14 - Version 0.0.1
## 
##      - First Beta release.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
CREATE TABLE `phpbb_inline_ads` (
`ad_id` TINYINT( 5 ) NOT NULL auto_increment,
`ad_code` TEXT NOT NULL ,
`ad_name` CHAR( 25 ) NOT NULL,
PRIMARY KEY (`ad_id`)
);

INSERT INTO `phpbb_inline_ads` (`ad_id` , `ad_code`, `ad_name` )
VALUES 
('1', 'Your banner code goes here', 'Default');

INSERT INTO `phpbb_config` ( `config_name` , `config_value` )
VALUES 
('ad_after_post', '1'),
('ad_post_threshold', ''),
('ad_every_post', ''),
('ad_who', '1'),
('ad_no_forums', ''),
('ad_no_groups', ''),
('ad_old_style', '1');
#
#-----[ COPY ]------------------------------------------
#
copy inline_ad_config_body.tpl to templates/subSilver/admin/inline_ad_config_body.tpl
copy inline_ad_code_body.tpl to templates/subSilver/admin/inline_ad_code_body.tpl
copy inline_ad_code_edit.tpl to templates/subSilver/admin/inline_ad_code_edit.tpl	
copy admin_inline_ad.php to admin/admin_inline_ad.php
copy admin_inline_ad_code.php to admin/admin_inline_ad_code.php
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
    $inline_ad_code = '';
	$display_ad = ($i == $board_config['ad_after_post'] - 1) || (($board_config['ad_every_post'] != 0) && ($i + 1) % $board_config['ad_every_post'] == 0);
   	//This if statement should keep server processing down a bit
   	if ($display_ad)
   	{
   		$display_ad = ($board_config['ad_who'] == ALL) || ($board_config['ad_who'] == ANONYMOUS && $userdata['user_id'] == ANONYMOUS) || ($board_config['ad_who'] == USER && $userdata['user_id'] != ANONYMOUS);
   		$ad_no_forums = explode(",", $board_config['ad_no_forums']);
		for ($a=0; $a < count($ad_no_forums); $a++){
			if ($forum_id == $ad_no_forums[$a]){
				$display_ad = false;
				break;	
			}
		}
		if ($board_config['ad_no_groups'] != '')
		{
		$ad_no_groups = explode(",", $board_config['ad_no_groups']);
   		$sql = "SELECT 1
   				FROM " . USER_GROUP_TABLE . "
   				WHERE user_id=" . $userdata['user_id'] . " AND (group_id=0";
   		for ($a=0; $a < count($ad_no_groups); $a++){
			$sql .= " OR group_id=" . $ad_no_groups[$a];
   		}
   		$sql .= ")";
   		if ( !($result = $db->sql_query($sql)) )
   		{
			message_die(GENERAL_ERROR, 'Could not query ad information', '', __LINE__, __FILE__, $sql);
   		}
   		if ($row = $db->sql_fetchrow($result)){
   			$display_ad = false;
   		}
		}
		if (($board_config['ad_post_threshold'] != '') &&($userdata['user_posts'] >= $board_config['ad_post_threshold']))
		{
			$display_ad = false;	
		}
   	}
   	//check once more, for server performance
   	
   	if ($display_ad)
   	{
   		$sql = "SELECT a.ad_code
				FROM " . ADS_TABLE . " a";
   		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query ad information', '', __LINE__, __FILE__, $sql);
		}
		$adRow = array();
		$adRow = $db->sql_fetchrowset($result);
		srand((double)microtime()*1000000);
		$adindex = rand(1, $db->sql_numrows($result)) - 1;
		$db->sql_freeresult($result);
   		$inline_ad_code = $adRow[$adindex]['ad_code'];
   	}
#
#-----[ FIND ]------------------------------------------
#
		'DELETE' => $delpost,
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_SPONSOR' => $lang['Sponsor'],
		'INLINE_AD' => $inline_ad_code,
#
#-----[ FIND ]------------------------------------------
#
		'U_POST_ID' => $postrow[$i]['post_id'])
	);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	if ($display_ad){
		if (!$board_config['ad_old_style'] && $display_ad)
		{
			$template->assign_block_vars('postrow.switch_ad',array());
		}
		else
		{
			$template->assign_block_vars('postrow.switch_ad_style2',array());
		}
	}
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
define('AUTH_ATTACH', 11);
#
#-----[ AFTER, ADD ]------------------------------------------
#
define('ALL', 1);
#
#-----[ FIND ]------------------------------------------
#
define('VOTE_USERS_TABLE', $table_prefix.'vote_voters');
#
#-----[ AFTER, ADD ]------------------------------------------
#
define('ADS_TABLE', $table_prefix.'inline_ads');
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
.helpline { background-color: {T_TR_COLOR2}; border-style: none; }
#
#-----[ AFTER, ADD ]------------------------------------------
#
td.inlineadtitle {
	background-color: {T_TR_COLOR3}; border: {T_TH_COLOR3}; border-style: solid; border-width: 1px;
}
td.inlinead {
	background-color: {T_TR_COLOR3}; border: {T_TH_COLOR3}; border-style: solid; border-width: 1px; text-align: center;
}
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- END postrow -->
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	<!-- BEGIN switch_ad -->
	<tr> 
		<td width="150" align="left" valign="top" class="inlineadtitle"><span class="name"><b>{postrow.L_SPONSOR}</b></span><br /</td>
		<td class="inlinead" width="100%" height="28" valign="top">
			{postrow.INLINE_AD}
		</td>
	</tr>
	<tr> 
		<td class="spaceRow" colspan="2" height="1"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END switch_ad -->
	<!-- BEGIN switch_ad_style2 -->
	<tr>
		<td colspan=2 class="inlinead">
			{postrow.INLINE_AD}
		</td>
	</tr>
	<!-- END switch_ad_style2 -->
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['Sponsor'] = 'Sponsor';
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['ad_managment']  = 'Ad Management';
$lang['inline_ad_config']  = 'Inline Ad Config';
$lang['inline_ads']  = 'Inline Ads';
$lang['ad_code_about']  = 'This page lists current ads.  You may edit, delete or add new ads here.';
$lang['Click_return_firstpost'] = 'Click %sHere%s to return to Inline Ad Configuration';
$lang['Click_return_inline_code'] = 'Click %sHere%s to return to Inline Ad Code Configuration';
$lang['ad_after_post'] = 'Display Ad After x Post';
$lang['ad_every_post'] = 'Display Ad Every x Post';
$lang['ad_display'] = 'Display Ads To';
$lang['ad_all'] = 'All';
$lang['ad_reg'] = 'Registered Users';
$lang['ad_guest'] = 'Guests';
$lang['ad_exclude'] = 'Exclude These Groups (List by comma-seperated group ID)';
$lang['ad_forums'] = 'Exclude These Forums (List by comma-seperated forum ID)';
$lang['ad_code'] = 'Ad Code';
$lang['ad_style'] = 'Display Style';
$lang['ad_new_style'] = 'Ad looks like a special user post';
$lang['ad_old_style'] = 'Ad falls inline with the topic';
$lang['ad_post_threshold'] = 'Do not display if user has more than x posts (Leave blank to disable)';
$lang['ad_add']  = 'Add New Ad';
$lang['ad_name']  = 'Short name to identify ad';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM