##############################################################
## MOD Title: Move forum logo setting to phpbb_config table
## MOD Author: espicom < phpbb2mods@espi.com > http://espi.com/
## MOD Description: Removes hard-coded logo from overall_header.tpl
## MOD Version: 1.1.3
##
## Installation Level: Easy
## Installation Time: ~10 Minutes
## Files To Edit: includes/page_header.php, 
##                admin/admin_board.php,
##                admin/admin_styles.php,
##                templates/subSilver/overall_header.tpl, 
##                templates/subSilver/admin/board_config_body.tpl,
##                templates/subSilver/admin/styles_edit_body.tpl,
##                language/lang_english/lang_admin.php 
## Included Files: n/a
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## This version of the MOD adds provision for changing this value through PHPBB's ACP. 
## I put this together so that I could remove the hard-coded logo value in overall_header.tpl,
## so that it is easier to mass-upgrade our forums as PHPBB is upgraded. Since the config table
## value would be separate for each forum, simply copying the updated files into place from the
## master copy would accomplish the update with minimum fuss.
##
## Updated version allows you to have theme-specific logos, if desired.
##
## Prior to installing this mod, you need to add a configuration item to your phpbb_config table,
## and alter your phpbb_theme table.
##
## INSERT INTO phpbb_config (config_name,config_value) VALUES ('forum_logo','/path/to/desired/logo');
## ALTER TABLE phpbb_themes ADD theme_logo VARCHAR( 255 ) NOT NULL AFTER head_stylesheet;
##
## Of course, you need to substitute the names for YOUR config table and the path to your logo.
## The path to the logo file must be the same path the browser would use to retrieve it. It can be
## relative, absolute, or "fully qualified". Examples, assuming your site is accessed as 
## http://www.mysite.com/phpbb2/ and your logo is in phpbb2/templates/subSilver/images/mylogo.gif,
## you can use either of these paths:
## /phpbb2/templates/subSilver/images/mylogo.gif  (absolute path)
## templates/subSilver/images/mylogo.gif          (relative path)
## http://www.mysite.com/phpbb2/templates/subSilver/images/mylogo.gif (fully qualified path)
##
## Logo is in /images/mylogo.gif, off your main site, you can use:
## /images/mylogo.gif                             (absolute path)
## ../images/mylogo.gif                           (relative path)
## http://www.mysite.com/images/mylogo.gif        (fully qualified path)
##
## Logo is hosted on another server, http://www.othersite.com/images/mylogo.gif, must use:
## http://www.othersite.com/images/mylogo.gif     (fully qualified path)
##
## When saving the files to a live site, save include/page_header.php first, so that everything will
## be in place when the revised template/subSilver/overall_header.tpl is saved. As long as you do not
## go into the Administrative Control Panel, the order of saving the other files is unimportant.
##
## IMPORTANT!!!!!!!!!!!!!
## If you are using any templates other than subSilver, overall_header.tpl, admin/board_config_body.tpl,
## and admin/styles_edit_body.tpl in each of them will need to be modified, as well.
##
## If you are using any languages other than English, lang_admin.php in each language will need to
## be modified, as well.
##
## Note to EasyMOD users, per Throckmorton:
## Even though EasyMOD will install to multiple templates, overall_header.tpl still needs to be edited
## manually in any template that does not initially point to "templates/subSilver/images/logo_phpBB.gif"
## as the logo source.
##
##############################################################
## MOD History:
##
##   2006-02-01 - Version 1.1.3
##      - Changes to make it more likely EasyMOD will be able to edit templates with other MODs in them,
##        including the FIND string I broke when I submitted a bug report...
##   2006-01-16 - Version 1.1.2
##      - No substantive changes, other than for MODDB submission criteria
##   2005-08-15 - Version 1.1.1
##      - Fixed spelling problem per correction by Throckmorton
##   2005-08-14 - Version 1.1.0
##      - Added the ability to select different logos for different themes
##   2005-08-10 - Version 1.0.4
##      - Fixed spelling problem to make compatible with EasyMOD per suggestion by Throckmorton
##   2005-03-05 - Version 1.0.3
##      - Moved L_SITE_LOGO_EXPLAIN to more logical location
##   2005-03-05 - Version 1.0.2
##      - Adminstrative Control Panel interface added
##   2005-03-04 - Version 1.0.1
##      - Path explanation expanded
##   2005-03-04 - Version 1.0.0
##      - mod created
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#-----[ SQL ]-------------------------------------------
#
INSERT INTO phpbb_config(config_name, config_value) VALUES ('forum_logo', 'templates/subSilver/images/logo_phpBB.gif');
ALTER TABLE phpbb_themes ADD theme_logo VARCHAR( 255 ) NOT NULL DEFAULT '';
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
	'SITE_DESCRIPTION' => $board_config['site_desc'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'SITE_LOGO' => ($theme['theme_logo'] == '' ? $board_config['forum_logo'] : $theme['theme_logo']),
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#
	"L_SITE_DESCRIPTION" => $lang['Site_desc'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_SITE_LOGO' => $lang['Forum_logo'],
	'L_SITE_LOGO_EXPLAIN' => $lang['Site_logo_explain'], 
#
#-----[ FIND ]------------------------------------------
#
	"SITE_DESCRIPTION" => $new['site_desc'], 
#
#-----[ AFTER, ADD ]------------------------------------------
#
	"SITE_LOGO" => $new['forum_logo'],
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_styles.php
#
#-----[ FIND ]------------------------------------------
#
			$updated['head_stylesheet'] = $HTTP_POST_VARS['head_stylesheet'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
			$updated['theme_logo'] = $HTTP_POST_VARS['theme_logo'];
#
#-----[ FIND ]------------------------------------------
#
				"L_STYLESHEET" => $lang['Stylesheet'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
				"L_THEME_LOGO" => $lang['Theme_logo'],
				"L_THEME_LOGO_EXPLAIN" => $lang['Theme_logo_explain'],
#
#-----[ FIND ]------------------------------------------
#
				"HEAD_STYLESHEET" => $selected['head_stylesheet'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
				"THEME_LOGO" => $selected['theme_logo'],
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
				<td><a href="{U_INDEX}">
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<img src="templates/subSilver/images/logo_phpBB.gif"
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
<img src="{SITE_LOGO}"
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<td class="row1">{L_SITE_DESCRIPTION}</td>
#
#-----[ FIND ]------------------------------------------
#
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_SITE_LOGO}<br /><span class="gensmall">{L_SITE_LOGO_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="forum_logo" value="{SITE_LOGO}" /></td>
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/styles_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<td class="row1">{L_STYLESHEET}:<br />
#
#-----[ FIND ]------------------------------------------
#
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_THEME_LOGO}<br /><span class="gensmall">{L_THEME_LOGO_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="25" maxlength="255" name="theme_logo" value="{THEME_LOGO}" /></td>
		<td class="row2">&nbsp;</td>		
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Site_desc'] = 'Site description';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Forum_logo'] = 'Forum logo path';
$lang['Site_logo_explain'] = 'The path where your default forum logo graphic is located relative to the domain name.';
#
#-----[ FIND ]------------------------------------------
#
$lang['Stylesheet'] = 'CSS Stylesheet';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Theme_logo'] = 'Forum logo path';
$lang['Theme_logo_explain'] = 'The path where your theme-specific forum logo graphic is located relative to the domain name.';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM