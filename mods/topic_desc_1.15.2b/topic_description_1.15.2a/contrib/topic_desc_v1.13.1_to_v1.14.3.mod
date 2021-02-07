############################################################## 
## MOD Title: topic description 
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: Just an update for TOpic Description v1.13.1 to 1.14.3
## MOD Version: 1.14.3
## 
## Installation Level: Intermediate
## Installation Time: ~5 Minutes 
## Files To Edit: 
##		  admin/admin_users.php
##		  templates/subSilver/admin/user_edit_body.tpl
##		  language/lang_english/lang_main.php
## Included Files: includes/functions_desc.php
##		   admin/admin_desc.php
##		   templates/subSilver/preview_tooltip_params.cfg
##		   templates/subSilver/admin/desc_config_body.tpl
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
##
## I got the tooltip script from http://www.walterzorn.com/tooltip/tooltip_e.htm
## This thingo is also LGPL and the MODs think this should be mentioned so it is :) (that's for the JS script)
## demo board: http://www.swizec.com/forum
##
## READ THE README
## 
############################################################## 
## MOD History: 
## 
## history.txt
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
#

copy includes/functions_desc.php to includes/functions_desc.php
copy admin/admin_desc.php to admin/admin_desc.php
copy templates/subSilver/preview_tooltip_params.cfg to templates/subSilver/preview_tooltip_params.cfg
copy templates/subSilver/admin/desc_config_body.tpl to templates/subSilver/admin/desc_config_body.tpl

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 

user_allowdesc = $user_allowdesc, user_allowmoddesc = $user_allowmoddesc, user_showdescriptions = $showdescriptions, user_showtooltips = $showtooltips, user_tooltips_parse = $tooltips_parse, user_tooltips_static = $tooltips_static, user_toolimg_width = $toolimg_width, user_toolimg_height = $toolimg_height,

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

user_allowdesc = '$user_allowdesc', user_allowmoddesc = '$user_allowmoddesc', user_showdescriptions = '$showdescriptions', user_showtooltips = '$showtooltips', user_tooltips_parse = '$tooltips_parse', user_tooltips_static = '$tooltips_static', user_toolimg_width = '$toolimg_width', user_toolimg_height = '$toolimg_height', 

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_TOOLTIPS_STATIC_EXP' => $lang['tooltips_static_explain'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

'L_TOOLIMG_SIZE' => $lang['toolimg_size'],

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/user_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<tr> 
	  <td class="row1"><span class="gen">{L_TOOLTIPS_STATIC}:</span><br /><span class="gensmall">{L_TOOLTIPS_PARSE_EXP}</span></td>
	  <td class="row2"> 
		<input type="radio" name="tooltips_static" value="1" {TOOLTIPS_STATIC_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="tooltips_static" value="0" {TOOLTIPS_STATIC_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 	
	
	<tr> 
	  <td class="row1"><span class="gen">{L_TOOLTIPS_STATIC}:</span><br /><span class="gensmall">{L_TOOLTIPS_STATIC_EXP}</span></td>
	  <td class="row2"> 
		<input type="radio" name="tooltips_static" value="1" {TOOLTIPS_STATIC_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="tooltips_static" value="0" {TOOLTIPS_STATIC_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>	
	
# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['tooltips_static_explain'] = 'Tooltips don\'t move with the mouse and can be clicked on';

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

$lang['tooltips_static_explain'] = 'Tooltips don\'t move with the mouse and can be clicked';

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['desc_tooltips_maxpostize'] = 'Maximum length of post preview in tooltips';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang['desc_tooltips_modify'] = 'To modify the way tooltips with previews look and behave you should edit the file template/<your template>/preview_tooltip_params.cfg.<br />There you can set many options from the color scheme to placement. For a list of options you should go <a href="http://www.walterzorn.com/tooltip/tooltip_e.htm" target="_blank">here</a><br />Please do not meddle with the T_STICKY option, it might give unexpected results as it is already set through the ACP / UCP.';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM