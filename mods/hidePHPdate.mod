##############################################################
## MOD Title: Hide PHP Date
## MOD Author: rjoiram < rjoiram@gmail.com > (Mario Finelli) http://www.sculch.com
## MOD Description: Adds an option in the ACP to hide the PHP date field, to avoid
##		    confusion among less tech-savvy users and those who do not know
## 		    PHP, or understand PHP date syntax.
## MOD Version: 2.1.1
##
## Installation Level: (Easy)
## Installation Time: ~10 Minutes
## Files To Edit: admin/admin_board.php
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/admin/board_config_body.tpl
##                language/lang_english/lang_admin.php
##                includes/usercp_register.php
## Included Files: (n/a)
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
## This is my first MOD, and I used a lot of stuff from Falstaff's
## Hide Language MOD to figure out which files to edit and what to edit
## and how to do it.
##############################################################
## MOD History:
##   
##   2006-07-08 - version 2.1.1   
##	- Final Testing, and made it so it actually worked. (Different
##	  names were assigned causing nothing to be displayed.)
##
##   2006-07-07 - version 2.0.1
##      - Added the functionality to turn on or off.
##   
##   2006-02-19 - Version 1.0.1
##      - MOD's original creation. Just hiding, no options, more to come.
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ SQL ]------------------------------------------ 
# 

INSERT INTO phpbb_config (config_name, config_value) VALUES ('hide_date', '0');

# 
#-----[ OPEN ]------------------------------------------ 
#

admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$disable_board_yes = ( $new['board_disable'] ) ? "checked=\"checked\"" : "";

# 
#-----[ BEFORE, ADD ]------------------------------------------
# 

// Begin Hide PHP Date MOD
$hide_date_yes = ( $new['hide_date'] ) ? "checked=\"checked\"" : "";
$hide_date_no = ( !$new['hide_date'] ) ? "checked=\"checked\"" : "";
// End Hide PHPH Date MOD


# 
#-----[ FIND ]------------------------------------------ 
# 

	"SERVER_NAME" => $new['server_name'], 

# 
#-----[ BEFORE, ADD ]------------------------------------------
#  


	// Begin Hide PHP Date MOD
	"L_HIDE_DATE" => $lang['hide_date'] ,
	"L_HIDE_DATE_EXPLAIN" => $lang['hide_date_explain'],
	"HIDE_DATE_YES" => $hide_date_yes, 
	"HIDE_DATE_NO" => $hide_date_no,
	// End Hide PHP Date MOD


# 
#-----[ OPEN ]-------------------------------------------
#

templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]-------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}:</span><br />
		<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14" class="post" />
	  </td>
	</tr>

# 
#-----[ REPLACE WITH ]------------------------------------------
# 

	<!-- BEGIN hide_date_no_block -->
	<tr> 
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}:</span><br />
		<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14" class="post" />
	  </td>
	</tr>
	<!-- END hide_date_no_block -->
	<!-- BEGIN hide_date_yes_block -->
		<input type="hidden" name="dateformat" value="{DATE_FORMAT}" maxlength="14" />
        <!-- END hide_date_yes_block -->

# 
#-----[ OPEN ]------------------------------------------ 
#

templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<tr>
		<td class="row1">{L_DATE_FORMAT}<br /><span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="default_dateformat" value="{DEFAULT_DATEFORMAT}" /></td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------
# 

	<tr>
		<td class="row1">{L_HIDE_DATE}<br /><span class="gensmall">{L_HIDE_DATE_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="hide_date" value="1" {HIDE_DATE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="hide_date" value="0" {HIDE_DATE_NO} /> {L_NO}</td>
	</tr>

# 
#-----[ OPEN ]------------------------------------------ 
#

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// That's all Folks!
// -------------------------------------------------

# 
#-----[ BEFORE, ADD ]------------------------------------------
# 


//
// Hide PHP Date MOD
//
$lang['hide_date'] = 'Hide Date';
$lang['hide_date_explain'] = 'Hides date field in user\'s profile to avoid confusion by those who don\'t know PHP or the PHP date syntax.';


# 
#-----[ OPEN ]---------------------------------------------- 
#

includes/usercp_register.php

# 
#-----[ FIND ]---------------------------------------------- 
# 

	}

	$template->pparse('body');

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

	?>

# 
#-----[ BEFORE, ADD ]---------------------------------------------- 
#

	// Begin Hide PHP Date MOD
	if ($board_config['hide_date']) 
    	{
		$template->assign_block_vars('hide_date_yes_block', array());
    	} 
    	else 
    	{ 	
		$template->assign_block_vars('hide_date_no_block', array());
	}
	// End Hide PHP Date MOD


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 