############################################################## 
## MOD Title: Open Inbox in a new window
## MOD Author: Balint < balint@krizsan.de > (Balint Krizsan) http://www.krizsan.de
## MOD Description: Adds an additional link to the 'Private Message' popup window to open the Inbox
## 		    in a new window instead in the main forum window.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: privmsg.php,
##		  language/lang_english/lang_main.php,
##		  templates/subSilver/privmsgs_popup.tpl
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
## THIS SOFTWARE IS PROVIDED BY THE AUTHOR 'AS IS' AND ANY 
## EXPRESSED OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED 
## TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS 
## FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL 
## THE AUTHOR OR ITS CONTRIBUTORS BE LIABLE FOR ANY DIRECT, 
## INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL 
## DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
## SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR 
## PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON 
## ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT 
## LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
## ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF 
## ADVISED OF THE POSSIBILITY OF SUCH DAMAGE. 
##
############################################################## 
## MOD History: 
##	 2008-03-01 - Version 1.0.1
##		- Replaced REPLACE WITH instructions with IN-LINE FINDS for compatibility
##		- Phrase adjustment
##		- Verified phpBB 2.0.23 compatibility
##	 2004-06-12 - Version 1.0.0
##		- Initial Release
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------ 
#
privmsg.php

#
#-----[ FIND ]------------------------------------------ 
#
$l_new_message .= '<br /><br />' . sprintf($lang['Click_view_privmsg'], '<a href="' . append_sid("privmsg.".$phpEx."?folder=inbox") . '" onclick="jump_to_inbox();return false;" target="_new">', '</a>');

#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
</a>

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
','<br /><br /><a href="' . append_sid("privmsg.".$phpEx."?folder=inbox") . '" onclick="jump_to_inbox_new();return false;" target="_blank">','</a>

#
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Click_view_privmsg'] = 'Click %sHere%s to visit your Inbox';

#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
Inbox

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
%sOpen Inbox in a new window%s

#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/privmsgs_popup.tpl

#
#-----[ FIND ]------------------------------------------ 
#
//-->

#
#-----[ BEFORE, ADD ]------------------------------------------
#
function jump_to_inbox_new()
{
	window.open("{U_PRIVATEMSGS}","_blank");
	self.focus();
	self.close();
}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM