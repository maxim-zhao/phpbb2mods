##############################################################
## MOD Title: ImageShack MOD
## MOD Author: Janmarques < gigjan@gmail.com > (Jan Marques) http://www.janmarques.net
## MOD Description: This MOD add's a small ImageShack toolbar, so it's easy to upload your image quick.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 4 minutes
## Files To Edit: posting.php
##                language/lang_english/lang_main.php
##                templates/subSilver/posting_body.tpl
## Included Files: 
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
## 2007-08-01 - Version 1.0.2
## -One bugfix concerning privmsg.php
##
## 2006-08-31 - Version 1.0.1
## -Made some small changes, on phpBB Team Request.
##
## 2006-08-12 - Version 0.9.9
## -First version launced, don't expect any trouble
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
	'L_SUBJECT' => $lang['Subject'],
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//Image in post MOD - start
	'ADD_IMG' => $lang['add_img'],
//Image in post MOD - stop
#
#-----[ OPEN ]------------------------------------------
#
privmsg.php
#
#-----[ FIND ]------------------------------------------
#
   'L_SUBJECT' => $lang['Subject'],
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//Image in post MOD - start
   'ADD_IMG' => $lang['add_img'],
//Image in post MOD - stop
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!
// -------------------------------------------------
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//Image in post MOD - start
$lang['add_img'] = 'Add an Image';
//Image in post MOD - stop
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------
#
    </tr>
	{POLLBOX} 
	<tr> 
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!--Image in post MOD - start-->
	<tr>
      <th class="thHead" colspan="2" height="25"><b>{ADD_IMG}</b></th>
    </tr>
	<tr>
      <td class="row1" colspan="2" align="center" height="28"><iframe src="http://imageshack.us/iframe.php?txtcolor=111111&amp;type=blank&amp;size=30" scrolling="no" allowtransparency="true" frameborder="0" width="290" height="100"></iframe></td>
	</tr>
 <!--Image in post MOD - stop-->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
