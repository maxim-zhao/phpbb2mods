##############################################################
## MOD Title: Add "Full Name" to Profile
## MOD Author: The Defpom < N/A > (Scott Gausden) http://www.radiomods.co.nz
## MOD Description: Adds fields for First Name and Last Name to the users profile, so that their name can be seen in their profile, it also has an ACP to select which fields should be displayed in the users profile and if they are required fields.
## MOD Version: 1.0.5
##
## Installation Level: Intermediate
## Installation Time:  15 Minutes
## Files To Edit:	9
##     admin/admin_users.php
##     language/lang_english/lang_main.php
##     language/lang_english/lang_admin.php
##     includes/usercp_viewprofile.php 
##     includes/usercp_register.php
##     icludes/usercp_avatar.php 
##     templates/subSilver/admin/user_edit_body.tpl
##     templates/subSilver/profile_add_body.tpl 
##     templates/subSilver/profile_view_body.tpl 
##
## Included Files:
##		templates/subSilver/admin/name_in_profile_body.tpl
##		admin/admin_name_in_profile.php to admin/admin_name_in_profile.php
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: Pop in easy mod and you are all set.
## 
## This mod will add a new field to the user profile, for the First Name and the Last Name,
## it also includes an admin control panel to turn the display of each name On/Off in the public profile
## and have the option of making either field compulsary.
##
## This is a spin off from another MOD I created "Add First Name to profile".
##
## This MOD can be seen in action on my forum: http://www.radiomods.co.nz/forum/
## 
############################################################## 
## MOD History: 
##
## 04/29/05 - 1.0.5
##	    - Minor code fixes (using tabs instead of spaces, removed unneccessary code from ACP, and fixed typo).
## 04/21/05 - 1.0.4
##	    - Minor code fixes (added quotes, fixed typo).
## 04/17/05 - 1.0.3
##	    - Minor code fixes (more invisible characters).
## 04/15/05 - 1.0.2
##	    - Minor find code fixes.
## 04/13/05 - 1.0.1
##	    - Minor code fixes, removed some trailing spaces.
## 03/28/05 - 1.0.0
##	    - Submitted for release.
## 03/28/05 - 0.2.2
##	    - Corrected ACP panel display in sidebar, it now has its own heading.
## 03/28/05 - 0.2.1
##	    - Added warning text in profile and ACP stating that the names may be visible in the public profile.
## 03/27/05 - 0.2.0
##	    - First Public Version
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy templates/subSilver/admin/name_in_profile_body.tpl to templates/subSilver/admin/name_in_profile_body.tpl
copy admin/admin_name_in_profile.php to admin/admin_name_in_profile.php

#
#-----[ SQL ]-------------------------------------------
#  

ALTER TABLE phpbb_users ADD user_name_first VARCHAR(64) DEFAULT '' NOT NULL;
ALTER TABLE phpbb_users ADD user_name_last VARCHAR(64) DEFAULT '' NOT NULL;
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('name_first_display',1),('name_last_display',0),('name_first_required',1),('name_last_required',0);



# 
#-----[ OPEN ]------------------------------------------ 
#  
language/lang_english/lang_main.php
 
# 
#-----[ FIND ]---------------------------------------------------
# 

//
// That's all, Folks!
// -------------------------------------------------


# 
#-----[ BEFORE, ADD ]----------------------------------------------
# 
///
/// Begin Names in Profile MOD
///

$lang['name_first'] = 'First Name';
$lang['name_last'] = 'Last Name';

$lang['name_title'] = 'Configuration for Names in Profile';
$lang['name_explain'] = 'This control panel allows you to set whether the users real names should be displayed in the profile and whether they should be compulsory fields.';
	
$lang['name_required'] = 'Set Required fields';
$lang['name_display'] = 'Display Names in Profile';
$lang['name_display_warning'] = 'If set, this will cause each name to be displayed in the public profile';

$lang['name_first_required'] = 'First Name Compulsory:';
$lang['name_last_required'] = 'Last Name Compulsory:';
$lang['name_first_display'] = 'Display First Name:';
$lang['name_last_display'] = 'Display Last Name:';

$lang['name_first_empty'] = 'Please enter your First Name';
$lang['name_last_empty'] = 'Please enter your Last Name';

$lang['name_first_display_warning'] = '(This board is configured to display this name in your public profile).';
$lang['name_last_display_warning'] = '(This board is configured to display this name in your public profile).';


///
/// End Names in Profile MOD
///


# 
#-----[ OPEN ]------------------------------------------ 
#  
language/lang_english/lang_admin.php
 
# 
#-----[ FIND ]---------------------------------------------------
# 
//
// That's all Folks!
// -------------------------------------------------

# 
#-----[ BEFORE, ADD ]----------------------------------------------
# 
///
/// Begin Names in Profile MOD
///

$lang['Click_name_config'] = 'Click %sHere%s to return to the Name In Profile ACP';

///
/// End Names in Profile MOD
///



# 
#-----[ OPEN ]------------------------------------------ 
#  
includes/usercp_viewprofile.php

# 
#-----[ FIND ]---------------------------------------------------
# 
	'USERNAME' => $profiledata['username'],
# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
///
/// Begin Names in Profile MOD
///
	'NAME_FIRST' => ( $profiledata['user_name_first'] ) ? $profiledata['user_name_first'] : '',
	'NAME_LAST' => ( $profiledata['user_name_last'] ) ? $profiledata['user_name_last'] : '',
///
/// End Names in Profile MOD
///
	
# 
#-----[ FIND ]---------------------------------------------------
# 
	'L_VIEWING_PROFILE' => sprintf($lang['Viewing_user_profile'], $profiledata['username']),

 
# 
#-----[ BEFORE, ADD ]---------------------------------------------------
# 
///
/// Begin Names in Profile MOD
///
	'L_NAME_FIRST' => $lang['name_first'],
	'L_NAME_LAST' => $lang['name_last'],
///
/// End Names in Profile MOD
///



# 
#-----[ FIND ]---------------------------------------------------
# 
$template->pparse('body');

# 
#-----[ BEFORE, ADD ]---------------------------------------------------
# 
///
/// Begin Names in Profile MOD
///

if ( $board_config['name_first_display'] )
	{
	$template->assign_block_vars('switch_name_first_display',array() );
	}

if ( $board_config['name_last_display'] )
	{
	$template->assign_block_vars('switch_name_last_display',array() );
	}

///
/// End Names in Profile MOD
///





# 
#-----[ OPEN ]------------------------------------------ 
#  
includes/usercp_register.php

# 
#-----[ FIND ]---------------------------------------------------
# 
	$strip_var_list = array('username' => 'username', 'email' => 'email',

# 
#-----[ IN-LINE FIND ]---------------------------------------------------
# 
'interests' => 'interests'

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------------
# 
, 'name_first' => 'name_first', 'name_last' => 'name_last'

# 
#-----[ FIND ]---------------------------------------------------
# 
		$username = stripslashes($username);

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
        $name_first = stripslashes($name_first);
        $name_last = stripslashes($name_last);


# 
#-----[ FIND ]--------------------------
# 
	$passwd_sql = '';
	if ( $mode == 'editprofile' )
	{
		if ( $user_id != $userdata['user_id'] )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Wrong_Profile'];
		}
 
# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
	///
	/// Begin Names in Profile MOD
	///

	if ( $board_config['name_first_required'] )
	 {
	  if ( empty($name_first) )
	  {
	  $error = TRUE;
	  $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['name_first_empty'];
	  }
	 }
 
	 if ( $board_config['name_last_required'] )
	 {
	  if ( empty($name_last) )
	  {
	  $error = TRUE;
	  $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['name_last_empty'];
	  }
	 }

	///
	/// End Names in Profile MOD
	///

# 
#-----[ FIND ]--------------------------
#  
	}
	else if ( $mode == 'register' )
	{
 

#-----[ AFTER, ADD ]---------------------------------------------------
# 
	///
	/// Begin Names in Profile MOD
	///

	if ( $board_config['name_first_required'] )
	 {
	  if ( empty($name_first) )
	  {
	  $error = TRUE;
	  $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['name_first_empty'];
	  }
	 }
 
	 if ( $board_config['name_last_required'] )
	 {
	  if ( empty($name_last) )
	  {
	  $error = TRUE;
	  $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['name_last_empty'];
	  }
	 }

	///
	/// End Names in Profile MOD
	///
	
# 
#-----[ FIND ]---------------------------------------------------
# 
SET " . $username_sql . $passwd_sql . "

# 
#-----[ IN-LINE FIND ]---------------------------------------------------
# 
$interests) . "'

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------------
# 
, user_name_first = '" . str_replace("\'", "''", $name_first) . "', user_name_last = '" . str_replace("\'", "''", $name_last) . "'


# 
#-----[ FIND ]---------------------------------------------------
# 
			$sql = "INSERT INTO " . USERS_TABLE . "

# 
#-----[ IN-LINE FIND ]---------------------------------------------------
# 
user_interests

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------------
# 
, user_name_first, user_name_last

# 
#-----[ FIND ]---------------------------------------------------
# 
				VALUES ($user_id, '" . str_replace			
# 
#-----[ IN-LINE FIND ]---------------------------------------------------
# 
$interests) . "'

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------------
# 
, '" . str_replace("\'", "''", $name_first) . "', '" . str_replace("\'", "''", $name_last) . "'


# 
#-----[ FIND ]---------------------------------------------------
# 
	$username = stripslashes($username);

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
	$name_first = stripslashes($name_first);
	$name_last = stripslashes($name_last);


# 
#-----[ FIND ]---------------------------------------------------
# 
	$username = $userdata['username'];

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
	$name_first = $userdata['user_name_first'];
	$name_last = $userdata['user_name_last'];


# 
#-----[ FIND ]---------------------------------------------------
# 
display_avatar_gallery($mode, $avatar_category

# 
#-----[ IN-LINE FIND ]---------------------------------------------------
# 
$interests

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------------
# 
, $name_first, $name_last

# 
#-----[ FIND ]--------------------------
# 
$template->assign_vars(array(
		'USERNAME' => $username,

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
		'NAME_FIRST' => $name_first,
		'NAME_LAST' => $name_last,


# 
#-----[ FIND ]--------------------------
# 
		'L_CURRENT_PASSWORD' => $lang['Current_password'],

# 
#-----[ BEFORE, ADD ]---------------------------------------------------
# 

		'L_NAME_FIRST' => $lang['name_first'],
		'L_NAME_LAST' => $lang['name_last'],
		'L_NAME_FIRST_DISPLAY_WARNING' => $lang['name_first_display_warning'],
		'L_NAME_LAST_DISPLAY_WARNING' => $lang['name_last_display_warning'],



# 
#-----[ FIND ]---------------------------------------------------
# 
$template->pparse('body');

# 
#-----[ BEFORE, ADD ]---------------------------------------------------
# 
///
/// Begin Names in Profile MOD
///

if ( $board_config['name_first_required'] )
	{
	$template->assign_block_vars('switch_name_first_required',array() );
	}

if ( $board_config['name_last_required'] )
	{
	$template->assign_block_vars('switch_name_last_required',array() );
	}
 
if ( $board_config['name_first_display'] )
	{
	$template->assign_block_vars('switch_name_first_display', array());
	}

if ( $board_config['name_last_display'] )
	{
	$template->assign_block_vars('switch_name_last_display', array());
	}

///
/// End Names in Profile MOD
///




# 
#-----[ OPEN ]------------------------------------------ 
#  
includes/usercp_avatar.php

# 
#-----[ FIND ]---------------------------------------------------
# 
function display_avatar_gallery($mode, &$category

# 
#-----[ IN-LINE FIND ]---------------------------------------------------
# 
&$interests

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------------
# 
, &$name_first, &$name_last

# 
#-----[ FIND ]---------------------------------------------------
# 
$params = array('coppa', 'user_id'

# 
#-----[ IN-LINE FIND ]---------------------------------------------------
# 
'interests'

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------------
# 
, 'name_first', 'name_last'




# 
#-----[ OPEN ]------------------------------------------ 
#  
admin/admin_users.php 

# 
#-----[ FIND ]---------------------------------------------------
# 
		$interests = ( !empty($HTTP_POST_VARS['interests']) ) ? trim(strip_tags( $HTTP_POST_VARS['interests'] ) ) : '';

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
		$name_first = ( !empty($HTTP_POST_VARS['name_first']) ) ? trim(strip_tags( $HTTP_POST_VARS['name_first'] ) ) : '';
		$name_last = ( !empty($HTTP_POST_VARS['name_last']) ) ? trim(strip_tags( $HTTP_POST_VARS['name_last'] ) ) : '';


# 
#-----[ FIND ]--------------------------------------------
# 
			$username = stripslashes($username);
			
# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
			$name_first = htmlspecialchars(stripslashes($name_first));
			$name_last = htmlspecialchars(stripslashes($name_last));
			

# 
#-----[ FIND ]---------------------------------------------------
# 
				SET " . $username_sql . $passwd_sql . "user_email = '" 

# 
#-----[ IN-LINE FIND ]---------------------------------------------------
# 
$interests) . "'

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------------
# 
, user_name_first = '" . str_replace("\'", "''", $name_first) . "', user_name_last = '" . str_replace("\'", "''", $name_last) . "'


			
# 
#-----[ FIND ]--------------------------------------------
# 
			$username = htmlspecialchars(stripslashes($username));

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
			$name_first = htmlspecialchars(stripslashes($name_first));
			$name_last = htmlspecialchars(stripslashes($name_last));


# 
#-----[ FIND ]---------------------------------------------------
# 
		$username = $this_userdata['username'];

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
		$name_first = htmlspecialchars($this_userdata['user_name_first']);
		$name_last = htmlspecialchars($this_userdata['user_name_last']);

# 
#-----[ FIND ]---------------------------------------------------
# 
			$s_hidden_fields .= '<input type="hidden" name="interests" value="' . str_replace("\"", "&quot;", $interests) . '" />';

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
			$s_hidden_fields .= '<input type="hidden" name="name_first" value="' . str_replace("\"", "&quot;", $name_first) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="name_last" value="' . str_replace("\"", "&quot;", $name_last) . '" />';

# 
#-----[ FIND ]---------------------------------------------------
# 
			'INTERESTS' => $interests,

# 
#-----[ AFTER, ADD ]---------------------------------------------------
# 
			'NAME_FIRST' => $name_first, 
			'L_NAME_FIRST' => $lang['name_first'],
			'NAME_LAST' => $name_last, 
			'L_NAME_LAST' => $lang['name_last'],



# 
#-----[ OPEN ]------------------------------------------ 
#  
templates/subSilver/profile_add_body.tpl

# 
#-----[ FIND ]---------------------------------------------------
# 
	<tr> 
		<td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="email" size="25" maxlength="255" value="{EMAIL}" /></td>
	</tr>

# 
#-----[ BEFORE, ADD ]---------------------------------------------------
# 
	<tr> 
		<td class="row1"><span class="gen">{L_NAME_FIRST}: 
		<!-- BEGIN switch_name_first_required --> 
		*
		<!-- END switch_name_first_required -->
		<!-- BEGIN switch_name_first_display -->
		</span><br />
		<span class="gensmall">{L_NAME_FIRST_DISPLAY_WARNING}</span>
		<!-- END switch_name_first_display -->
		</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="name_first" size="25" maxlength="64" value="{NAME_FIRST}" /></td>
	</tr>
	<tr> 
		<td class="row1"><span class="gen">{L_NAME_LAST}: 
		<!-- BEGIN switch_name_last_required --> 
		*
		<!-- END switch_name_last_required -->
		<!-- BEGIN switch_name_last_display -->
		</span><br />
		<span class="gensmall">{L_NAME_LAST_DISPLAY_WARNING}</span>
		<!-- END switch_name_last_display -->
		</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="name_last" size="25" maxlength="64" value="{NAME_LAST}" /></td>
	</tr>
	

# 
#-----[ OPEN ]------------------------------------------ 
#  
templates/subSilver/profile_view_body.tpl

# 
#-----[ FIND ]---------------------------------------------------
# 
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_EMAIL_ADDRESS}:</span></td>
		  <td class="row1" valign="middle" width="100%"><b><span class="gen">{EMAIL_IMG}</span></b></td>
		</tr>
# 
#-----[ BEFORE, ADD ]---------------------------------------------------
# 
<!-- BEGIN switch_name_first_display --> 
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_NAME_FIRST}:</span></td>
		  <td class="row1" valign="middle" width="100%"><b><span class="gen">{NAME_FIRST}</span></b></td>
		</tr>
<!-- END switch_name_first_display --> 

<!-- BEGIN switch_name_last_display --> 
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_NAME_LAST}:</span></td>
		  <td class="row1" valign="middle" width="100%"><b><span class="gen">{NAME_LAST}</span></b></td>
		</tr>
<!-- END switch_name_last_display --> 



# 
#-----[ OPEN ]------------------------------------------ 
#  
templates/subSilver/admin/user_edit_body.tpl

# 
#-----[ FIND ]---------------------------------------------------
# 
	<tr> 
	  <td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="email" size="35" maxlength="255" value="{EMAIL}" />
	  </td>
	

# 
#-----[ BEFORE, ADD ]---------------------------------------------------
# 
	<tr> 
	  <td class="row1"><span class="gen">{L_NAME_FIRST}: 
	  	<!-- BEGIN switch_name_first_required --> 
		*
		<!-- END switch_name_first_required -->
		<!-- BEGIN switch_name_first_display -->
		</span><br />
		<span class="gensmall">{L_NAME_FIRST_DISPLAY_WARNING}</span>
		<!-- END switch_name_first_display -->
		</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="name_first" size="35" maxlength="64" value="{NAME_FIRST}" />
	  </td>	  
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NAME_LAST}: 
	  	<!-- BEGIN switch_name_last_required --> 
		*
		<!-- END switch_name_last_required -->
		<!-- BEGIN switch_name_last_display -->
		</span><br />
		<span class="gensmall">{L_NAME_LAST_DISPLAY_WARNING}</span>
		<!-- END switch_name_last_display -->
		</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="name_last" size="35" maxlength="64" value="{NAME_LAST}" />
	  </td>	  
	</tr>
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 