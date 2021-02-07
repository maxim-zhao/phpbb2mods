############################################################## 
## MOD Title: Available characters in title
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/
## MOD Description: Shows the remaining available characters for a subject title with JavaScript
## MOD Version: 1.3.2
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		posting.php
##		privmsg.php
##		templates/subSilver/posting_body.tpl
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
## Screenshot: http://www.underhill.de/downloads/phpbb2mods/availablecharsintitle.png
## Download: http://www.underhill.de/downloads/phpbb2mods/availablecharsintitle.txt
############################################################## 
## MOD History: 
## 
##   2006-04-08 - Version 1.3.2 
##		- Successfully tested with phpBB 2.0.20
##		- Successfully tested with EasyMOD beta (0.3.0)
## 
##   2005-12-31 - Version 1.3.1 
##		- Successfully tested with phpBB 2.0.19
## 
##   2005-12-21 - Version 1.3.0 
##		- Fixed bug with private messages (Blazer)
## 
##   2005-12-11 - Version 1.2.2 
##		- MOD Syntax changes for the phpBB MOD Database
##		- Successfully tested with phpBB 2.0.18
## 
##   2005-10-03 - Version 1.2.1 
##		- MOD Syntax changes for the phpBB MOD Database
## 
##   2005-10-01 - Version 1.2.0 
##		- Format changed to the phpBB MOD Template
##		- Successfully tested with phpBB 2.0.17
## 
##   2004-12-04 - Version 1.0.0 
##		- Built and successfully tested with phpBB 2.0.13
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------------------------------
#

posting.php

#
#-----[ FIND ]------------------------------------------------------------------
#

	'SUBJECT' => $subject,

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

	'SUBJECT_LEN_MAX' => 60,  // Maximum characters in title
	'SUBJECT_LEN' => 60 - strlen($subject), // Maximum characters in title without count of used characters

#
#-----[ FIND ]------------------------------------------------------------------
#

	'L_SUBJECT' => $lang['Subject'],

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

	'L_SUBJECT_LEN_EXPLAIN' => $lang['Subject_len_explain'],

#
#-----[ OPEN ]------------------------------------------------------------------
#

privmsg.php

#
#-----[ FIND ]------------------------------------------------------------------
#

		'SUBJECT' => $privmsg_subject,

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		'SUBJECT_LEN_MAX' => 60,  // Maximum characters in title
		'SUBJECT_LEN' => 60 - strlen($privmsg_subject), // Maximum characters in title without count of used characters

#
#-----[ FIND ]------------------------------------------------------------------
#

		'L_MESSAGE_BODY' => $lang['Message_body'],

#
#-----[ BEFORE, ADD ]-----------------------------------------------------------
#

		'L_SUBJECT_LEN_EXPLAIN' => $lang['Subject_len_explain'],

#
#-----[ OPEN ]------------------------------------------------------------------
#

templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------------------------------
#

	  <td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span></td>
	  <td class="row2" width="78%"> <span class="gen">

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#

		<script language="JavaScript" type="text/javascript">
		<!--
		// Available characters in title
		function subjectCounter(field, countfield, maxlimit)
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

		<input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" />
		
#
#-----[ REPLACE WITH ]----------------------------------------------------------
#

		<input type="text" name="subject" size="45" maxlength="{SUBJECT_LEN_MAX}" style="width:400px" tabindex="2" class="post" value="{SUBJECT}" onKeyDown="subjectCounter(this.form.subject, this.form.subjectLen, {SUBJECT_LEN_MAX});" onKeyUp="subjectCounter(this.form.subject, this.form.subjectLen, {SUBJECT_LEN_MAX});" />

#
#-----[ AFTER, ADD ]------------------------------------------------------------
#
		
		<input class="post" readonly="readonly" type="text" name="subjectLen" size="3" maxlength="3" value="{SUBJECT_LEN}" /><span class="gensmall">&nbsp;{L_SUBJECT_LEN_EXPLAIN}</span>

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

$lang['Subject_len_explain'] = "[ Characters left ]";

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
#
# EoM
