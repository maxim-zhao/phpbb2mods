##############################################################
## MOD Title: SQR 1.2.2 to SQR 1.3.0 Code Changes
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: Changes from Super Quick Reply 1.2.2 to 1.3.0
##
## MOD Version: 1.0.0
##
## Installation Level: Intermediate
## Installation Time: 5-10 Minutes
## Files To Edit: includes/viewtopic_quickreply.php,
##                language/lang_english/lang_main.php,
##                templates/subSilver/viewtopic_body.tpl,
##                templates/subSilver/viewtopic_quickreply.tpl,
##                templates/subSilver/subSilver.cfg
##
## Included Files: quickreply.gif
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
##
## phpBB 2.0.13 compatible.
##
## This MOD will install using EasyMOD.
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-03-14 - Version 1.0.0
##      - initial public version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy quickreply.gif to templates/subSilver/images/lang_english/quickreply.gif

#
#-----[ OPEN ]------------------------------------------
#
includes/viewtopic_quickreply.php

#
#-----[ FIND ]------------------------------------------
#
'L_EMPTY_MESSAGE' => $lang['Empty_message'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	'U_POST_SQR_TOPIC' => 'javascript:sqr_show_hide();',
	'SQR_IMG' => $images['quickreply'],
	'L_POST_SQR_TOPIC' => $lang['Show_hide_quick_reply_form'],

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Quick_reply_mode_advanced']

#
#-----[ AFTER, ADD ]--------------------------------------
#
$lang['Show_hide_quick_reply_form'] = 'Show/hide quick reply form';


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# <td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
<td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}">

#
#-----[ IN-LINE FIND ]------------------------------------------
#
</a></span></td>

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
</a>

#
#-----[ AFTER, ADD ]--------------------------------------
#
<!-- BEGIN switch_quick_reply -->
&nbsp;&nbsp;&nbsp;<a href="{U_POST_SQR_TOPIC}"><img src="{SQR_IMG}" border="0" alt="{L_POST_SQR_TOPIC}" align="middle" /></a>
<!-- END switch_quick_reply -->
</span></td>


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_quickreply.tpl

#
#-----[ FIND ]------------------------------------------
#
//-->
</script>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
function sqr_show_hide()
{
	var id = 'sqr';
	var item = null;

	if (document.getElementById)
	{
		item = document.getElementById(id);
	}
	else if (document.all)
	{
		item = document.all[id];
	}
	else if (document.layers)
	{
		item = document.layers[id];
	}

	if (item && item.style)
	{
		if (item.style.display == "none")
		{
			item.style.display = "";
		}
		else
		{
			item.style.display = "none";
		}
	}
	else if (item)
	{
		item.visibility = "show";
	}
}

#
#-----[ AFTER, ADD ]--------------------------------------
#
<div id="sqr" style="display: none; position: relative; ">

#
#-----[ FIND ]------------------------------------------
#
</form>

#
#-----[ AFTER, ADD ]--------------------------------------
#
</div>


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.cfg

#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# $images['reply_locked'] = "$current_template_images/{LANG}/reply-locked.gif";
$images['reply_locked'] =

#
#-----[ AFTER, ADD ]--------------------------------------
#
$images['quickreply'] = "$current_template_images/{LANG}/quickreply.gif";

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM