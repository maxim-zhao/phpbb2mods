##############################################################
## MOD Title: Tinypic MOD
## MOD Author: Krank < krank98@gmail.com > (N/A) N/A
## MOD Description: This MOD add's a small Tinypic toolbar, so it's easy to upload your image and video quickly.
## MOD Version: 1.0.2
## 
## Installation Level: Easy
## Installation Time: 5 minutes
## Files To Edit: posting.php
##                privmsg.php
##                language/lang_english/lang_main.php
##                templates/subSilver/posting_body.tpl
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2288.38406 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
## This MOD is based on the Imageshack MOD by Janmarques
##############################################################
## MOD History:
##
## 2007-03-5 - Version 1.0.2
## -Fixed Tinpic iframe in posting body
## -forgot to put privmsg.php in files to edit field :p 
## -Re-Submitted to phpBB
##
## 2007-02-17 - Version 1.0.1
## -Fixed the MOD Author line.
## -Added some information in Author Notes.
## -Fixed the iframe for tinypic
## -Submited
##
## 2007-01-11 - Version 1.0.0
## -Changes Made in the Original MOD (Imageshack MOD by Janmarques) 
## to make it with Tinypic, Changes Made by Krank.
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
    //Tinypic MOD by Krank - start
	'ADD_IMG' => $lang['add_img'],
    //Tinypic MOD by Krank - end
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
        //Tinypic MOD by Krank - start
        'ADD_IMG' => $lang['add_img'],
        //Tinypic MOD by Krank - end

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
//Tinypic MOD by Krank - start
$lang['add_img'] = 'Add an Image';
//Tinypic MOD by Krank - end
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
<!--Tinypic MOD by Krank - start-->
	<tr>
      <th class="thHead" colspan="2" height="25"><b>{ADD_IMG}</b></th>
    </tr>
	<tr>
      <td class="row1" colspan="2" align="center" height="28"><iframe src="http://tinypic.com/upload.php?&amp;type=blank&amp;size=30" scrolling="no" allowtransparency="true" frameborder="0" width="400" height="250"></iframe></td>
	</tr>
 <!--Tinypic MOD by Krank - end-->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
