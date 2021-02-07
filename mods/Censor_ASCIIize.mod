##############################################################
## MOD Title: Censor ASCIIize
## MOD Author: Sko22 < webmaste@quellicheilpc.com > (Gianluca Scerni) http://www.quellicheilpc.com/
## MOD Description: Allows Administrator(s) to censor in ASCII mode.
## MOD Version: 1.0.0
##
## Installation Level: (Easy)
## Installation Time: 1 Minute
## Files To Edit: templates/subSilver/admin/words_edit_body.tpl
## Included Files: (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: For all phpBB version. Support http://www.quellicheilpc.com
##############################################################
## MOD History:
##
##   2003-12-06 - Version 1.0.0
##      - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/words_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<p>{L_WORDS_TEXT}</p>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<script language="JavaScript1.2">
<!--

function ASCIIize()
{

	var txtCens = document.forms[0].word.value;
	var export_text = '';
	var current_char = '';
	var i;
	for (i = 0; i <= txtCens.length; i++)
	{
		current_char = txtCens.charAt(i);
		if ( (current_char == 'a') || (current_char == 'A') )
		{
			export_text += '4';
		}
		else if ( (current_char == 'e') || (current_char == 'E') )
		{
			export_text += '3';
		}
		else if ( (current_char == 'g') || (current_char == 'G') )
		{
			export_text += '6';
		}
		else if ( (current_char == 'i') || (current_char == 'I') )
		{
			export_text += '|';
		}
		else if ( (current_char == 'l') || (current_char == 'L') )
		{
			export_text += '1';
		}
		else if ( (current_char == 'o') || (current_char == 'O') )
		{
			export_text += '0';
		}
		else if ( (current_char == 's') || (current_char == 'S') )
		{
			export_text += '5';
		}
		else if ( (current_char == 't') || (current_char == 'T') )
		{
			export_text += '7';
		}
		else
		{
			export_text += current_char;
		}
	}
	document.forms[0].replacement.value = export_text;
	return;

}

//-->
</script>
#
#-----[ FIND ]------------------------------------------
#
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="save" value="{L_SUBMIT}" class="mainoption" /></td>

#
#-----[ REPLACE WITH ]------------------------------------------
#
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="save" value="{L_SUBMIT}" class="mainoption" />&nbsp;<input type="button" class="button" name="freak" value="ASCIIize" onClick="ASCIIize()" /></td>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 