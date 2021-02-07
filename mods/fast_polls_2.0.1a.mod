############################################################## 
## MOD Title: Fast Polls
## MOD Author: Kinfule < kinfule@lycos.com > (Kinfule) http://kinfule.tk 
## MOD Description: This mod replaces the way polls are build when posting a topic.
##									avoiding unnecessary page reloads.
## MOD Version: 2.0.1 
## 
## Installation Level: Easy
## Installation Time:  5 Minutes 
## Files To Edit:  3
##		posting.php
##		posting_body.tpl
##		posting_poll_body.tpl
##
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
##	This mod will use javascript to replace those page reloads when creating a poll.
############################################################## 
## MOD History: 
## 
##   2006-06-07 - Version 2.0.0
##      - Rewritten.
## 
##   2006-06-19 - Version 2.0.1
##      - Added option limit.
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
#
posting.php

# 
#-----[ FIND ]------------------------------------------ 
#
	'L_POLL_DELETE' => $lang['Delete_poll'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

	'L_TOO_MANY_POLL_OPTIONS' => $lang['To_many_poll_options'],
	'MAX_POLL_OPTIONS' => $board_config['max_poll_options'],

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# Around line 1
#
<script language="JavaScript" type="text/javascript">
<!--

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
// Begin Fast Polls Mod
function add_option()
{
	var tbody = document.getElementById('poll_options');
	var form = document.post;
	var table = tbody.parentNode;
	var newOption = form.add_poll_option_text.value;

	// Get total number of options
	var row_index = tbody.rows.length;
	
	if (row_index >= {MAX_POLL_OPTIONS})
	{
		alert('{L_TOO_MANY_POLL_OPTIONS}');
		return false;
	}

	// Insert the new option at the end
	var newRow   = tbody.insertRow(row_index);
	var newCell  = newRow.insertCell(0);
	var newCell2  = newRow.insertCell(1);
	
	newCell.className = 'row1';
	newCell2.className = 'row2';

	newCell.innerHTML = '<span class="gen"><b>{L_POLL_OPTION}</b></span>';
	newCell2.innerHTML = '<span class="genmed"><input name="poll_option_text[]" size="50" class="post" maxlength="255" value="'+ newOption +'" type="text" /></span> &nbsp;&nbsp;<input type="submit" onclick="del_option(this.parentNode.parentNode.rowIndex); return false;" name="del_poll_option[]" value="{L_DELETE_OPTION}" class="liteoption" /> ';
	
	form.add_poll_option_text.value = "";
	form.add_poll_option_text.focus();
}

function del_option(row_index)
{
	var tbody = document.getElementById('poll_options');
	var form = document.post;
	var table = tbody.parentNode;
	// Try to delete the row, if error occurs, alert the user
	try
	{
		table.deleteRow(row_index);
	} 
	catch (ex)
	{
		alert(ex);
	}
}
// End Fast Polls Mod

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/posting_poll_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
	<!-- BEGIN poll_option_rows -->
	
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	<tbody id="poll_options">

# 
#-----[ FIND ]------------------------------------------ 
#
				<td class="row2"><span class="genmed"><input type="text" name="poll_option_text[{poll_option_rows.S_POLL_OPTION_NUM}]" size="50" class="post" maxlength="255" value="{poll_option_rows.POLL_OPTION}" /></span> &nbsp;<input type="submit" name="edit_poll_option" value="{L_UPDATE_OPTION}" class="liteoption" /> <input type="submit" name="del_poll_option[{poll_option_rows.S_POLL_OPTION_NUM}]" value="{L_DELETE_OPTION}" class="liteoption" /></td>

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
&nbsp;<input type="submit" name="edit_poll_option" value="{L_UPDATE_OPTION}" class="liteoption" />

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# What we want is to delete this
#
&nbsp;

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
 value="{L_DELETE_OPTION}"

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
#
 onClick="del_option(this.parentNode.parentNode.rowIndex); return false;"

# 
#-----[ FIND ]------------------------------------------ 
#
	<!-- END poll_option_rows -->

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	</tbody>

# 
#-----[ FIND ]------------------------------------------ 
#
				<td class="row2"><span class="genmed"><input type="text" name="add_poll_option_text" size="50" maxlength="255" class="post" value="{ADD_POLL_OPTION}" /></span> &nbsp;<input type="submit" name="add_poll_option" value="{L_ADD_OPTION}" class="liteoption" /></td>

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
 value="{L_ADD_OPTION}"
 
# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
#
 onClick="add_option(); return false;"
 
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 