############################################################## 
## MOD Title: topic description 
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: An update of Topic Description mod
## MOD Version: 1.14.9 to 1.15.1
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

INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'desc_postparsing', '1' );
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

common.php

# 
#-----[ FIND ]------------------------------------------ 
# 

include($phpbb_root_path . 'includes/functions_desc.'.$phpEx);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

include($phpbb_root_path . 'includes/Sajax.'.$phpEx);
$Sajax = new Sajax( FALSE, 'GET' );
// mod topic description end

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewforum.php

# 
#-----[ FIND ]------------------------------------------ 
#

$post_desc4mod = $topic_rowset[$i]['topic_descmod'];

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#

$topic_desc4mod = $topic_rowset[$i]['topic_descmod'];

# 
#-----[ FIND ]------------------------------------------ 
# 

$topic_desc = fetch_desc ( $topic_desc, $bbcode_uid, TRUE );

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

if ( empty( $desc_perm ) || !isset( $desc_perm ) )
{
	get_descperm( $desc_perm );
	get_tooltipperm( $tool_perm, $forum_id );
}
if ( empty( $tooltips_full ) || !isset( $tooltips_full ) )
{
	get_tooltips( $tooltips_full, $topic_rowset );
}
$tooltip_options = implode( '', file( $phpbb_root_path . 'templates/' . $theme['template_name'] . '/preview_tooltip_params.cfg' ) );

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

$template->pparse('overall_header');

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod topic description add
if ( $board_config['desc_postparsing'] )
{
	if ( is_object( $Sajax ) )
	{
		$Sajax->add2export( 'description_parse', '$desc, $id' );
		$Sajax->add2export( 'tooltip_postparse', '$topic_id' );
		$Sajax->sajax_remote_uri = $Sajax->sajax_get_my_uri();
		$Sajax->sajax_init();
		$Sajax->sajax_export();
		$Sajax->sajax_handle_client_request();
		$template->assign_var( 'SAJAX_JAVASCRIPT', $Sajax->sajax_get_javascript() );
	}
}
// mod topic description end

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/overall_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

</head>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

<script language="Javascript" type="text/javascript">
<!--
{SAJAX_JAVASCRIPT}

function description_postparse( desc, id )
{
	x_description_parse( desc, id, description_backparse );
}

function description_backparse( get )
{
	document.getElementById( get[ 0 ] ).innerHTML = get[ 1 ];
}

function tool_postparse( id )
{
	x_tooltip_postparse( id, tool_backparse );
}

function tool_backparse( get )
{
	document.getElementById( get[ 0 ] ).innerHTML = get[ 1 ];
}
//-->
</script>

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

$lang['desc_postparsing'] = 'Enable description postparsing (move bbcode parsing of descriptions to ajax to lighten load)';
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

$lang['Desc_only4mod'] = 'Description for mods: ';
$lang['Desc_parsetool'] = '<b>Parse tool</b>';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM