##############################################################
## MOD Title: Agreement on Index MOD
## MOD Author: christhatsme < chris.j.bridges@gmail.com > (Chris Bridges) http://chris.laxforums.co.uk
## MOD Description: Adds an agreement on the index, that is trigged when the user is coming from an outside site. The agreement can be set in the ACP.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 8 minutes
## Files To Edit: index.php
##                includes/constants.php
##                language/lang_english/lang_main.php
##                language/lang_english/lang_admin.php
## Included Files: root/db_update.php
##                 root/agreement.php
##                 root/templates/subSilver/index_agreement_body.tpl
##                 root/admin/admin_agreement.php
##                 root/templates/subSilver/admin/agreement_edit.tpl
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
##############################################################
## MOD History:
## 
## 2006-05-31 - Version 1.0.1
## - bug fixes
##
## 2006-02-19 - Version 1.0.0
## -Cookies now used to determine if a user did not agree
## 
## 2006-02-18 - Version 0.6.1
## -Fixed minor bug on agreement template file
## 
## 2006-02-18 - Version 0.6.0
## -First Public Release
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy root/db_update.php to db_update.php
copy root/agreement.php to agreement.php
copy root/templates/subSilver/index_agreement_body.tpl to templates/subSilver/index_agreement_body.tpl
copy root/admin/admin_agreement.php to admin/admin_agreement.php
copy root/templates/subSilver/admin/agreement_edit.tpl to templates/subSilver/admin/agreement_edit.tpl
#
#-----[ OPEN ]------------------------------------------
#
index.php
#
#-----[ FIND ]------------------------------------------
#
//
// End session management
//
#
#-----[ AFTER, ADD ]------------------------------------------
#

//
// function to obtain the forum script path
//

    function get_script_path()
   {
	  global $board_config;
      $server_name = $board_config['server_name'];
      $script_path = $board_config['script_path'];
      $script_path = $server_name . $script_path;
      return $script_path;
   }
   
if( isset($HTTP_GET_VARS['agreed']) || isset($HTTP_POST_VARS['agreed']) )
{
	$agreed = ( isset($HTTP_GET_VARS['agreed']) ) ? $HTTP_GET_VARS['agreed'] : $HTTP_POST_VARS['agreed'];
	$agreed = htmlspecialchars($agreed);
}
else 
{
	$agreed = "";
}

switch( $agreed )
	{
		//
		// Function to save agreement to the database
		//
		case "true":
setcookie("agree_not", "not_agreed", time()-36000, $board_config['script_path'], $board_config['server_name']);	
#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
#
#-----[ AFTER, ADD ]------------------------------------------
#
	break;
// if the user doesn't agree, tell them to get lost
	case "false":
	setcookie("agree_not", "not_agreed", time()+36000, $board_config['script_path'], $board_config['server_name']);
	message_die(GENERAL_MESSAGE, $lang['index_must_agree']);
		break;
// set the default page they will come to
	default:
		if (isset($HTTP_COOKIE_VARS["agree_not"]))
		{
			redirect(append_sid("agreement.$phpEx", true));
		} 
		
// if the user is from your script path, let them through	
		if (strpos($HTTP_SERVER_VARS['HTTP_REFERER'], get_script_path())!=0)
			{
				redirect(append_sid('index.'.$phpEx.'?agreed=true', true));
			}
// if they have come from outside your root, send them off the the agreement
		else
			{
				redirect(append_sid("agreement.$phpEx", true));
			}
		break;
// end the switch
}
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
define('AUTH_ACCESS_TABLE', $table_prefix.'auth_access');
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// BEGIN Agreement on Index MOD by christhatsme
//
define('AGREEMENT_TABLE', $table_prefix.'agreement');
//
// END Agreement on Index MOD by christhatsme
//
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

//
// BEGIN agreement on index MOD by christhatsme
//
$lang['index_terms'] = 'Terms of Use';
$lang['index_agree'] = 'I agree to these terms';
$lang['index_do_not_agree'] = 'I do not agree to these terms';
$lang['index_must_agree'] = 'You must agree to our terms for use of this board';
//
// END agreement on index MOD by christhatsme
//

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

//
// BEGIN agreement on index MOD by christhatsme
//
$lang['index_agreement'] = 'Index Agreement';
$lang['no_agreement'] = 'You did not enter an agreement';
$lang['agreement_edit_success'] = 'The agreement was successfully updated.';
$lang['click_return_agreement'] = 'Click %sHere%s to return to agreement administration';
$lang['save_agreement'] = 'Save Agreement';
$lang['agreement_edit_header'] = 'Edit Index Agreement';
$lang['agreement_edit_explain'] = 'Here you can edit the Index agreement text. Note that html must be used for formatting (including line breaks)';
//
// END agreement on index MOD by christhatsme
//

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
You must run the db_update.php file to update your db for this mod to work
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
