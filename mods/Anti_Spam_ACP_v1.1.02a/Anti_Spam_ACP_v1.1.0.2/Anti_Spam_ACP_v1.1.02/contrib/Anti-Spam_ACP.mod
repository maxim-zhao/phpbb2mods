##############################################################
## MOD Title: Anti-spam ACP
## MOD Author: EXreaction < exreaction@lithiumstudios.org > (Nathan Guse) http://www.lithiumstudios.org
##
## MOD Description: Prevents spam bots registering on your forum by
##       removing fields you want in registration and profile form
##       until users reach certain requirements.  If spam bot is
##       detected, it sends an email notification to you with username,
##       IP address, and more.
##
## MOD Version: 1.1.02 (designed for phpBB 2.0.21)
##
## Installation Level:	Intermediate
## Installation Time:	~10 min (less than 1 min with EasyMOD)
##
## Files To Edit:	includes/usercp_register.php
##					language/lang_english/lang_admin.php
##					language/lang_english/lang_main.php
## 					templates/subSilver/profile_add_body.tpl
##
## Included Files:	admin/admin_anti_spam_acp.php
##					includes/anti_spam_acp.php
##					language/lang_english/email/admin_spam_notification.tpl
##					templates/subSilver/admin/anti_spam_acp_body.tpl
##
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
##	+ If you are not able to manually do the SQL sections you may run the db_install.php.  Read more about it below in the
##		- SQL section, it tells you what to do.
##	+ My official thread for this mod is here: http://www.lithiumstudios.org/phpBB3/viewtopic.php?f=10&t=4
##		- You may ask for support there or at phpBB.com
##	+ If you would like to support my work, you can do so by donating.  It can take a lot of time to code and support your modifications.
##		- You can donate with PayPal here:
##		- http://tinyurl.com/ymtctj
##############################################################
## MOD History:
##	(yyyy-mm-dd)
##	2006-06-25
##		+ 1.0.0 Initial Release
##	2006-08-23
##		+ 1.1.0 Complete Overhaul...
##	2006-08-27
##		+ 1.1.0a Hard codded language fixed and emailer template added(was forgotten in 1.1.0)
##	2006-09-06
##		+ 1.1.01 Bug fixes, a few minor things, a bots caught watcher, and a cool version checker ^_^
##			- As long as there are no bugs found or and all of the future versions of phpBB are compatible with this mod,
##				+ this will be the last version I code(I will still support it though). :-P
##	2006-09-11
##		+ 1.1.01a Dang it...I missed a small bug. :(
##			- Thanks gpraceman for finding it.
##	2006-11-01
##		+ 1.1.02 Many fixes...
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
# Note: SQL entries may need to be changed depending on your forum's table prefix.
#  If you are using the default prefix the values are fine(if you are not sure just use the db_install.php file).
#
# Optionally, you may run the db_install.php instead.
#  If you want to do that, copy contrib/db_install.php to your root phpBB2 directory, 
#  and run it from your web browser.  You should delete the file afterwards.
#

INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_icq', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_aim', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_msn', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_yim', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_web', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_loc', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_occ', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_int', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_sig', 'reg off');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_icq_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_aim_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_msn_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_yim_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_web_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_loc_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_occ_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_int_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_sig_post', '10');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_notify_on_spam', '0');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_email_for_spam', '');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_show_email_on_die', '0');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_version', '1.1.02');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_check_version', '1');
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ('as_acp_bots_stopped', '0');

#
#-----[ COPY ]------------------------------------------
#

copy root/admin/admin_anti_spam_acp.php								to	admin/admin_anti_spam_acp.php
copy root/includes/anti_spam_acp.php								to	includes/anti_spam_acp.php
copy root/language/lang_english/email/admin_spam_notification.tpl	to	language/lang_english/email/admin_spam_notification.tpl
copy root/templates/subSilver/admin/anti_spam_acp_body.tpl			to	templates/subSilver/admin/anti_spam_acp_body.tpl

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#

$error = FALSE;

#
#-----[ AFTER, ADD ]------------------------------------------
#

// Start Anti-Spam ACP MOD
require($phpbb_root_path . 'includes/anti_spam_acp.' . $phpEx);
// End Anti-Spam ACP MOD

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

// Start Anti-Spam ACP MOD
$lang['Anti_Spam']						= 'Anti-Spam';
$lang['Anti_Spam_ACP']					= 'Anti-Spam ACP';
$lang['Check_Version']					= 'Check lithiumstudios.org automatically for updates?';
$lang['Check_Version_Explain']			= 'Automatically accesses my server and checks to see if you have the latest version(just like phpBB does).';
$lang['Email_Address']					= 'Email Address';
$lang['Email_Address_Explain']			= 'Email address that the spam notifications will get sent to and that will be displayed if you have show email enabled.<br/>To enter multiple email addresses use a comma between each.';
$lang['Show_Email']						= 'Show Email';
$lang['Show_Email_Explain']				= 'Show your email address when a user gets the message die if they enter in something we don\'t allow.<br/>If this is disabled it will just say to contact the board administrator.';
$lang['Send_Email']						= 'Send notification email';
$lang['Send_Email_Explain']				= 'Sends out a notification email when someone attempts to insert illegal data.';
$lang['L_Test_Mail']					= 'Submit & Test Email';
$lang['L_Test_Mail_Explain']			= 'Send a test email to yourself, an example of one you would get if a spammer tries to do something they are not allowed to do.';
$lang['AS_Page_Settings']				= 'Anti-Spam ACP v%s Settings';
$lang['Anti_Spam_ACP_Created_By']		= 'Created By: <a href="http://www.lithiumstudios.org" style="text-decoration:none">EXreaction</a>';
$lang['Click_return_AS_ACP']			= 'Click %sHere%s to return to Anti-Spam Configuration';
$lang['Message_Sent']					= 'Test email has been sent.';
$lang['Always_Off']						= 'Always Off';
$lang['Reg_Off']						= 'Off For Registration';
$lang['On']								= 'Always On';
$lang['By_Post_Count']					= 'Set According to Post Count';
$lang['Post_Count']						= 'Post Count';
$lang['Test_Username']					= 'Test Username';
$lang['Test_Password']					= 'Test Password';
$lang['Test_Email']						= 'test@%s';
$lang['Test_Occupation']				= 'Email Tester';
$lang['Test_Interests']					= 'Sending out Emails';
$lang['Test_Signature']					= 'Thank you for testing the email feture of the Anti-Spam ACP mod.  Please visit http://www.lithiumstudios.org if you need help.';
$lang['AS_Acp_Update_Error']			= 'Errors were reported, the rest of the ';
$lang['AS_ACP_up_to_date']				= 'Your version of Anti-Spam ACP is up to date.';
$lang['AS_ACP_not_up_to_date']			= 'You are not running the latest stable version of Anti-Spam ACP.  The latest stable version is available at <a href="http://www.lithiumstudios.org/phpBB3/viewtopic.php?f=10&t=4">Lithium Studios</a>.';
$lang['AS_ACP_Latest_Version']			= 'The latest stable version is %s.';
$lang['AS_ACP_Current_Version']			= 'You are running %s.';
$lang['Num_Bots_Caught']				= 'Number of spammers stopped by this mod since installation';
// End Anti-Spam ACP MOD

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

// Start Anti-Spam ACP MOD
$lang['Spam_Bot_Yes']			= 'Are you an automated spam-bot? If not, please send an email to %s for help.';
$lang['Spam_Bot_No']			= 'Are you an automated spam-bot? If not, please contact the Board Administrator.';
$lang['Not_Available']			= 'Not available for profile editing.';
$lang['Test_Email_Header']		= 'You sent a test email from';
$lang['Not_Test_Email_Header']	= 'A user just attempted an illegal operation with their profile(while they were %s) on';
$lang['Registering']			= 'registering';
$lang['Editing_Profile']		= 'editing their profile';
$lang['Spam_Bot_Attempt']		= 'Spam Bot attempt at ';
// End Anti-Spam ACP MOD

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="25" valign="middle">{L_PROFILE_INFO}</th>
	</tr>
	<tr> 
	  <td class="row2" colspan="2"><span class="gensmall">{L_PROFILE_INFO_NOTICE}</span></td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_all -->
	<tr> 
	  <td class="catSides" colspan="2" height="28">&nbsp;</td>
	</tr>
	<tr> 
	  <th class="thSides" colspan="2" height="25" valign="middle">{L_PROFILE_INFO}</th>
	</tr>
	<tr> 
	  <td class="row2" colspan="2"><span class="gensmall">{L_PROFILE_INFO_NOTICE}</span></td>
	</tr>
<!-- END switch_edit_all -->

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_ICQ_NUMBER}:</span></td>
	  <td class="row2"> 
		<input type="text" name="icq" class="post" style="width: 100px"  size="10" maxlength="15" value="{ICQ}" />
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_icq -->
	<tr> 
	  <td class="row1"><span class="gen">{L_ICQ_NUMBER}:</span></td>
	  <td class="row2"> 
		<input type="text" name="icq" class="post" style="width: 100px"  size="10" maxlength="15" value="{ICQ}" />
	  </td>
	</tr>
<!-- END switch_edit_icq -->

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_AIM}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="aim" size="20" maxlength="255" value="{AIM}" />
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_aim -->
	<tr> 
	  <td class="row1"><span class="gen">{L_AIM}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="aim" size="20" maxlength="255" value="{AIM}" />
	  </td>
	</tr>
<!-- END switch_edit_aim -->

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_MESSENGER}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="msn" size="20" maxlength="255" value="{MSN}" />
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_msn -->
	<tr> 
	  <td class="row1"><span class="gen">{L_MESSENGER}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="msn" size="20" maxlength="255" value="{MSN}" />
	  </td>
	</tr>
<!-- END switch_edit_msn -->

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="yim" size="20" maxlength="255" value="{YIM}" />
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_yim -->
	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="yim" size="20" maxlength="255" value="{YIM}" />
	  </td>
	</tr>
<!-- END switch_edit_yim -->

#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_WEBSITE}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="website" size="25" maxlength="255" value="{WEBSITE}" />
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_web -->
	<tr> 
	  <td class="row1"><span class="gen">{L_WEBSITE}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="website" size="25" maxlength="255" value="{WEBSITE}" />
	  </td>
	</tr>
<!-- END switch_edit_web -->

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_LOCATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="location" size="25" maxlength="100" value="{LOCATION}" />
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_loc -->
	<tr> 
	  <td class="row1"><span class="gen">{L_LOCATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="location" size="25" maxlength="100" value="{LOCATION}" />
	  </td>
	</tr>
<!-- END switch_edit_loc -->

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_OCCUPATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="occupation" size="25" maxlength="100" value="{OCCUPATION}" />
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_occ -->
	<tr> 
	  <td class="row1"><span class="gen">{L_OCCUPATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="occupation" size="25" maxlength="100" value="{OCCUPATION}" />
	  </td>
	</tr>
<!-- END switch_edit_occ -->

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_INTERESTS}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="interests" size="35" maxlength="150" value="{INTERESTS}" />
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_int -->
	<tr> 
	  <td class="row1"><span class="gen">{L_INTERESTS}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 200px"  name="interests" size="35" maxlength="150" value="{INTERESTS}" />
	  </td>
	</tr>
<!-- END switch_edit_int -->

#
#-----[ FIND ]------------------------------------------
#

	<tr> 
	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span><br /><span class="gensmall">{L_SIGNATURE_EXPLAIN}<br /><br />{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2"> 
		<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
	</tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#

<!-- BEGIN switch_edit_sig -->
	<tr> 
	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span><br /><span class="gensmall">{L_SIGNATURE_EXPLAIN}<br /><br />{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2"> 
		<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
	</tr>
<!-- END switch_edit_sig -->

#
#-----[ SAVE/CLOSE ALL FILES ]-----------------------------------------
#
# EoM