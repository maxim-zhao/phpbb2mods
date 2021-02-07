##############################################################
## MOD Title: Permissions List Box
## MOD Author:  eviL3 < evil@phpbbmodders.org > (Igor Wiedler) http://phpbbmodders.org
## MOD Description: This MOD will add a vbulletin style permissions box.
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time:  5 Minutes
## Files To Edit: posting.php,
##                viewforum.php,
##                viewtopic.php,
##                language/lang_english/lang_main.php,
##                templates/subSilver/overall_header.tpl,
##                templates/subSilver/posting_body.tpl,
##                templates/subSilver/viewforum_body.tpl,
##                templates/subSilver/viewtopic_body.tpl
##
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
##  This MOD was requested by kber
##  Thanks to prince of phpbb for the help :)
##
##############################################################
## MOD History:
##
##   2006-08-06 - Version 0.1.0
##      - First release
##
##   2006-09-24 - Version 1.0.0
##      - Submitted to MODDB
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
	'L_DELETE_POST' => $lang['Delete_post'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_PERM_LIST' => $lang['perm_list'],
#
#-----[ OPEN ]------------------------------------------
#
viewforum.php
#
#-----[ FIND ]------------------------------------------
#
	'L_AUTHOR' => $lang['Author'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_PERM_LIST' => $lang['perm_list'],
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
	'L_GOTO_PAGE' => $lang['Goto_page'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_PERM_LIST' => $lang['perm_list'],
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!
#
#-----[ BEFORE, ADD ]------------------------------------------
#

$lang['perm_list'] = 'Permissions';
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
</head>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<script language="Javascript" type="text/javascript">
<!--
function show_hide(the_layer)
{
  if(document.getElementById(the_layer))
  {
    if(document.getElementById(the_layer).style.display == 'none')
    {
      document.getElementById(the_layer).style.display = 'inline';
    }
    else
    {
      document.getElementById(the_layer).style.display = 'none';
    }
  }
}
//-->
</script>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------
# Partial FIND
#
<td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b>
#
#-----[ REPLACE WITH ]------------------------------------------
#
      <td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b>
      <table width="100%" border="0" cellpadding="4" cellspacing="1" class="forumline">
           <tr>
         <th align="center" height="25" class="thTop" nowrap="nowrap" onclick="show_hide('authlist')">{L_PERM_LIST}</th>
         </tr>
         <tr>
         <td class="row1"><span id="authlist" class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
         </tr>
      </table>
     </td>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewforum_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<td align="right"><span class="gensmall">{S_AUTH_LIST}</span></td>
#
#-----[ REPLACE WITH ]------------------------------------------
#
		<td align="right"><table width="50%" border="0" cellpadding="4" cellspacing="1" class="forumline">
      <tr>
        <th align="center" height="25" class="thTop" nowrap="nowrap" onclick="show_hide('authlist')">{L_PERM_LIST}</th>
      </tr>
      <tr>
        <td class="row1"><span id="authlist" class="gensmall">{S_AUTH_LIST}</span></td>
      </tr>
    </table></td>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
# Partial FIND
#
<td align="right" valign="top" nowrap="nowrap">{JUMPBOX}
#
#-----[ REPLACE WITH ]------------------------------------------
#
   <td align="right" valign="top" nowrap="nowrap">{JUMPBOX}
      <table width="50%" border="0" cellpadding="4" cellspacing="1" class="forumline">
      <tr>
         <th align="center" height="25" class="thTop" nowrap="nowrap" onclick="show_hide('authlist')">{L_PERM_LIST}</th>
      </tr>
      <tr>
         <td class="row1"><span id="authlist" class="gensmall">{S_AUTH_LIST}</span></td>
      </tr>
      </table>
   </td>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
