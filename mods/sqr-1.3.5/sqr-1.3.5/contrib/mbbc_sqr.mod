##############################################################
## MOD Title: Multiple BBCode MOD with SQR MOD
## MOD Author: hayk < hayk@mail.ru > (Hayk Chamyan) http://www.a13n.org
## MOD Description: This MOD allows to install Multiple BBCode MOD
##                  together with Super Quick Reply MOD v1.3.2+
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: includes/viewtopic_quickreply.php
##                templates/subSilver/viewtopic_quickreply.tpl
##
## Included Files: (n/a)
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
## 1. Multiple BBCode MOD ( http://www.phpbb.com/phpBB/viewtopic.php?t=145513 )
## 2. Install Super Quick Reply MOD
## 3. Install this MOD
##
## This MOD is released under the GPL License.
##############################################################
## MOD History:
##
##   2005-07-09 - Version 1.0.0
##      - initial version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_quickreply.tpl


#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# f_help = "{L_BBCODE_F_HELP}";
f_help


#
#-----[ AFTER, ADD ]---------------------------------
#
<!-- END switch_advanced_qr -->

<!-- BEGIN MultiBB -->
{MultiBB.VALUE}_help = "{MultiBB.HELP}";
<!-- END MultiBB -->

<!-- BEGIN switch_advanced_qr -->


#
#-----[ FIND ]---------------------------------
#
#  NOTE - the full line to look for is:
#			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
#			  </span></td>
#
	name="addbbcode16"
	</td>


#
#-----[ AFTER, ADD ]---------------------------------
#
			<!-- END switch_advanced_qr -->

			<!-- BEGIN MultiBB -->
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="{MultiBB.KEY}" name="{MultiBB.NAME}" value="{MultiBB.VALUE}" style="width: {MultiBB.WIDTH}px" onClick="{MultiBB.STYLE}" onMouseOver="helpline('{MultiBB.VALUE}')" />
			  </span></td>
			<!-- END MultiBB -->

		  <!-- BEGIN switch_advanced_qr -->


#
#-----[ FIND ]---------------------------------
#
#  NOTE - the full line to look for is:
#					<select name="addbbcodefontcolor" onChange="bbfontstyle('[color=' + this.form.addbbcodefontcolor.options[this.form.addbbcodefontcolor.selectedIndex].value + ']', '[/color]')" onMouseOver="helpline('s')">
#
	name="addbbcode18"


#
#-----[ IN-LINE FIND ]---------------------------------
#
name="addbbcode18"


#
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
name="addbbcodefontcolor"


#
#-----[ IN-LINE FIND ]---------------------------------
#
this.form.addbbcode18.options


#
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
this.form.addbbcodefontcolor.options


#
#-----[ IN-LINE FIND ]---------------------------------
#
this.form.addbbcode18.selectedIndex


#
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
this.form.addbbcodefontcolor.selectedIndex


#
#-----[ FIND ]---------------------------------
#
#  NOTE - the full line to look for is:
#					</select> &nbsp;{L_FONT_SIZE}:<select name="addbbcodefontsize" onChange="bbfontstyle('[size=' + this.form.addbbcodefontsize.options[this.form.addbbcodefontsize.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
#
	name="addbbcode20"

#
#-----[ IN-LINE FIND ]---------------------------------
#
name="addbbcode20"


#
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
name="addbbcodefontsize"


#
#-----[ IN-LINE FIND ]---------------------------------
#
this.form.addbbcode20.options


#
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
this.form.addbbcodefontsize.options


#
#-----[ IN-LINE FIND ]---------------------------------
#
this.form.addbbcode20.selectedIndex


#
#-----[ IN-LINE REPLACE WITH ]---------------------------------
#
this.form.addbbcodefontsize.selectedIndex


#
#-----[ OPEN ]------------------------------------------
#
includes/viewtopic_quickreply.php


#
#-----[ FIND ]------------------------------------------
#
$template->assign_block_vars('switch_advanced_qr', array());


#
#-----[ BEFORE, ADD ]------------------------------------------
#
	Multi_BBCode();


#
#-----[ FIND ]------------------------------------------
#
# NOTE - the origial text is:
# 'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
'L_BBCODE_F_HELP'


#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_BBCODE_E_HELP' => $lang['bbcode_e_help'],


#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM