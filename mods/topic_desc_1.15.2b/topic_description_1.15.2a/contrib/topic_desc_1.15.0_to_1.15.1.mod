############################################################## 
## MOD Title: topic description 
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: An update of Topic Description mod
## MOD Version: 1.15.0 to 1.15.1
## 
## Installation Level: Intermediate
## Installation Time: ~50 Minutes 
## Files To Edit: 
##		  common.php
##		  viewforum.php
##		  viewtopic.php
##		  includes/page_header.php
##		  templates/subSilver/overall_header.tpl
##		  language/lang_english/lang_admin.php
##		  language/lang_english/lang_main.php
## Included Files: 
##		admin/admin_desc.php
##		includes/functions_desc.php
##		includes/Sajax.php
##		templates/subSilver/admin/desc_config_body.tpl
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
#-----[ SQL ]------------------------------------------ 
#

INSERT INTO phpbb_config( config_name, config_value ) VALUES ('desc_postparsing_tool', '1');

# 
#-----[ COPY ]------------------------------------------ 
#

copy admin/admin_desc.php to admin/admin_desc.php
copy includes/Sajax.php to includes/Sajax.php
copy includes/functions_desc.php to includes/functions_desc.php
copy templates/subSilver/admin/desc_config_body.tpl to templates/subSilver/admin/desc_config_body.tpl

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 

t.topic_title, t.topic_description,

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

t.topic_description,

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

 t.topic_descmod,
 
# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_desc = fetch_desc( $forum_topic_data['topic_description'], $bbcode_uid );

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

$topic_desc4mod = $forum_topic_data['topic_descmod'];

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/page_header.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$Sajax->add2export( 'description_parse', '$desc, $id' );

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

$Sajax->add2export( 'tooltip_postparse', '$topic_id' );

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/overall_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

{SAJAX_JAVASCRIPT}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

function tool_postparse( id )
{
	x_tooltip_postparse( id, tool_backparse );
}

function tool_backparse( get )
{
	document.getElementById( get[ 0 ] ).innerHTML = get[ 1 ];
}

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

// mod topic description: add

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang['desc_postparsingt'] = 'Enable tooltip postparsing (move BBCode parsing of tooltips to ajax to lighten load)'; 

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

// mod topic description: add

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang['Desc_parsetool'] = '<b>Parse tool</b>';
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM
