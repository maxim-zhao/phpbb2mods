############################################################## 
## MOD Title: topic description 
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: Update for topic description
## MOD Version: 1.15.1 to 1.15.2
## 
## Installation Level: Intermediate
## Installation Time: ~50 Minutes 
## Files To Edit: 
##		  includes/page_header.php
##		  language/lang_english/lang_admin.php
##		  language/lang_english/lang_main.php
## Included Files: includes/functions_desc.php
##		   includes/Sajax.php
##		   admin/admin_desc.php
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

copy includes/Sajax.php to includes/Sajax.php
copy admin/admin_desc.php to admin/admin_desc.php
copy templates/subSilver/admin/desc_config_body.tpl to templates/subSilver/admin/desc_config_body.tpl

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/page_header.php

# 
#-----[ FIND ]------------------------------------------ 
# 

if ( $board_config['desc_postparsing'] )

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

if ( $board_config['desc_postparsing'] || $board_config['desc_postparsing_tool'] )

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

// mod topic description add

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang['desc_bbcodeparsing'] = 'BBCode parsing options';

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['Desc_parsetool'] = '<b>Parse tool</b>';

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

$lang['Desc_parsetool'] = '<b>Postparse tooltip</b>';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM