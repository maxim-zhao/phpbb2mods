############################################################## 
## MOD Title: Fixed date format for non technical users 
## MOD Author: pichirichi <pichirichi@pichirichi.com> (N/A) http://www.pichirichi.com
## MOD Description: Drop down menu in profile definition for non technical users
## MOD Version: 1.0.4 
## 
## Installation Level: Easy
## Installation Time: 5 Minutes 
## Files To Edit: 7
##                templates/subSilver/profile_add_body.tpl
##                templates/subSilver/admin/user_edit_body.tpl
##                templates/subSilver/admin/board_config_body.tpl
##                includes/usercp_register.php
##                admin/admin_users.php
##                admin/admin_board.php
##                includes/functions_selects.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##    I found out that non technical users find the date() 
##     format to complicated. The mod provide the users a list 
##     of date format to chose from with an output example.
############################################################## 
## MOD History: 
##
##   2004-09-14 - Version 1.0.4 
##      - Remove date format explain (L_DATE_FORMAT_EXPLAIN) from date field.
##      - Add the date select for profile edit option from Admin Control Panel.
##      - Add date select in the ACP 'board config' screen.
## 
##   2004-09-10 - Version 1.0.3 
##      - missspelling in some file names.
## 
##   2004-08-28 - Version 1.0.2 
##      - updated the version number.
##      - implemented a more intuitive way to add new dates 
##        formats.
##
##   2004-08-28 - Version 1.0.1 
##      - missspelling in some file names. 
## 
##   2004-08-28 - Version 1.0.0 
##      - First release. 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14" class="post" />

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
{DATE_FORMAT}

# 
#-----[ FIND ]------------------------------------------ 
# 
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}:</span><br />
		<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}:</span></td>

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/user_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<input class="post" type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="16" />

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
{DATE_FORMAT}

# 
#-----[ FIND ]------------------------------------------ 
# 
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}</span><br />
		<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}</span></td>


# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<td class="row2"><input class="post" type="text" name="default_dateformat" value="{DEFAULT_DATEFORMAT}" /></td>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
<td class="row2">{DEFAULT_DATEFORMAT}</td>


# 
#-----[ FIND ]------------------------------------------ 
# 
<td class="row1">{L_DATE_FORMAT}<br /><span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
<td class="row1">{L_DATE_FORMAT}</td>

#
##-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_register.php

# 
#-----[ FIND ]------------------------------------------ 
# 
'DATE_FORMAT' => $user_dateformat,

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
'DATE_FORMAT' => date_select($user_dateformat,'dateformat'),

#
##-----[ OPEN ]------------------------------------------ 
# 
admin/admin_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 
'DATE_FORMAT' => $user_dateformat,

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
'DATE_FORMAT' => date_select($user_dateformat,'dateformat'),


#
##-----[ OPEN ]------------------------------------------ 
# 
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 
"DEFAULT_DATEFORMAT" => $new['default_dateformat'],

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
"DEFAULT_DATEFORMAT" => date_select($new['default_dateformat'],'default_dateformat'),

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_selects.php

# 
#-----[ FIND ]------------------------------------------ 
# 
?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
//
// Visual pick Date Format for non technical users
//
function date_select($default_format, $select_name = 'dateformat')
{
	global $lang,$board_config;

	//---------------------------------------------------
	$date_format_list[] = array('F d Y');	
	$date_format_list[] = array('F d Y, H:i');
	$date_format_list[] = array('F d Y, G:i A');
	//---------------------------------------------------
	$date_format_list[] = array('d F Y');	
	$date_format_list[] = array('d F Y, H:i');
	$date_format_list[] = array('d F Y, G:i A');
	//---------------------------------------------------
	$date_format_list[] = array('l, d F Y');	
	$date_format_list[] = array('l, d F Y, H:i');
	$date_format_list[] = array('l, d F Y, G:i A');
	//---------------------------------------------------
	$date_format_list[] = array('D, M d Y');
	$date_format_list[] = array('D, M d Y, H:i');
	$date_format_list[] = array('D, M d Y, G:i A');
	//---------------------------------------------------
	$date_format_list[] = array('D d M');
	$date_format_list[] = array('D d M, Y H:i');
	$date_format_list[] = array('D d M, Y G:i A');
	//---------------------------------------------------
	$date_format_list[] = array('d/m/Y');	
	$date_format_list[] = array('d/m/Y H:i');
	$date_format_list[] = array('d/m/Y G:i A');
	//---------------------------------------------------
	$date_format_list[] = array('m/d/Y');	
	$date_format_list[] = array('m/d/Y H:i');
	$date_format_list[] = array('m/d/Y G:i A');
	//---------------------------------------------------
	$date_format_list[] = array('m.d.Y');	
	$date_format_list[] = array('m.d.Y H:i');
	$date_format_list[] = array('m.d.Y G:i A');
	//---------------------------------------------------


	//---------------------------------------------------
	// Set a default value.
	//---------------------------------------------------
	if ( empty($default_format) )
	{
		$default_format = $date_format_list[11][0];
	}


	$date_select = '<select name="' . $select_name . '">'."\n";
	for($i = 0; $i < count($date_format_list); $i++)
	{
		$date_format = $date_format_list[$i][0];
		$date_desc   = create_date($date_format_list[$i][0],time(),$board_config['board_timezone']);

		$selected = ( $date_format == $default_format ) ? ' selected="selected"' : '';
		$date_select .= '<option value="' . $date_format . '"' . $selected . '>' . $date_desc . '</option>'."\n";

		$counter = 0;
	}
	$date_select .= '</select>'."\n";

	return $date_select;
}


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
