############################################################## 
## MOD Title: Available characters in signature
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/
## MOD Description: Shows the remaining available characters for a signature with JavaScript
## MOD Version: 1.1.4
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		includes/usercp_register.php
##		templates/subSilver/profile_add_body.tpl
##		language/lang_english/lang_main.php
## Included Files: N/A
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
## This modification was built for use with the phpBB template "subSilver"
##
## Screenshot: http://www.underhill.de/downloads/phpbb2mods/availablecharsinsignature.png
## Download: http://www.underhill.de/downloads/phpbb2mods/availablecharsinsignature.txt
############################################################## 
## MOD History: 
## 
##   2006-04-08 - Version 1.1.4 
##		- Successfully tested with phpBB 2.0.20
##		- Successfully tested with EasyMOD beta (0.3.0)
## 
##   2005-12-31 - Version 1.1.3 
##		- Successfully tested with phpBB 2.0.19
## 
##   2005-12-11 - Version 1.1.2 
##		- MOD Syntax changes for the phpBB MOD Database
##		- Successfully tested with phpBB 2.0.18
## 
##   2005-10-03 - Version 1.1.1 
##		- MOD Syntax changes for the phpBB MOD Database
## 
##   2005-10-01 - Version 1.1.0 
##		- Format changed to the phpBB MOD Template
##		- Successfully tested with phpBB 2.0.17
## 
##   2004-12-04 - Version 1.0.0 
##		- Built and successfully tested with phpBB 2.0.10
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------------------------------
#

		'SIGNATURE' => str_replace('<br />', "\n", $signature),

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		'SIGNATURE_LEN' => $board_config['max_sig_chars'] - strlen(str_replace('<br />', "\n", $signature)),

#
#-----[ FIND ]------------------------------------------------------------------
#

		'L_SIGNATURE' => $lang['Signature'],
		'L_SIGNATURE_EXPLAIN' => sprintf($lang['Signature_explain'], $board_config['max_sig_chars']),

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		'L_SIGNATURE_LEN' => $board_config['max_sig_chars'],
		'L_SIGNATURE_LEN_EXPLAIN' => $lang['Signature_len_explain'],

#
#-----[ OPEN ]------------------------------------------------------------------
#

templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------------------------------
#

	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span><br /><span class="gensmall">{L_SIGNATURE_EXPLAIN}<br /><br />{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2">

#
#-----[ AFTER, ADD ]-----------------------------------------------------------
#

		<script language="JavaScript" type="text/javascript">
		<!--
		// Available characters in signature 
		function signatureCounter(field, countfield, maxlimit)
		{
			if (field.value.length > maxlimit)
			{
				field.value = field.value.substring(0, maxlimit);
			}
			else
			{ 
			countfield.value = maxlimit - field.value.length;
			}
		}
		//-->
		</script>

#
#-----[ FIND ]------------------------------------------------------------------
#

		<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post">{SIGNATURE}</textarea>

#
#-----[ IN-LINE FIND ]----------------------------------------------------------
#

<textarea name="signature" style="width: 300px" rows="6" cols="30" class="post"
		
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------------------
#
		
 wrap="virtual" onKeyDown="signatureCounter(this.form.signature, this.form.signatureLen, {L_SIGNATURE_LEN});" onKeyUp="signatureCounter(this.form.signature, this.form.signatureLen, {L_SIGNATURE_LEN});"

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		<input class="post" readonly="readonly" type="text" name="signatureLen" size="3" maxlength="3" value="{SIGNATURE_LEN}" /><span class="gensmall">&nbsp;{L_SIGNATURE_LEN_EXPLAIN}</span>

#
#-----[ OPEN ]------------------------------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------------------------------
#

$lang['Admin_reauthenticate'] =

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

$lang['Signature_len_explain'] = "[ Characters left ]";

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
#
# EoM
