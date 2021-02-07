##############################################################
## MOD Title: No PMs to self
## MOD Author: Balint < balint@krizsan.de > (Balint Krizsan) http://www.krizsan.de
## MOD Description: Prevents users to sending private messages to themselves.
## MOD Version: 1.0.2
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: privmsg.php,
##                language/lang_english/lang_main.php
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
##############################################################
## MOD History:
## 
##   2008-03-02 - Version 1.0.2
##	- Ensured compatibility for phpBB 2.0.23
##   2005-03-08 - Version 1.0.1
##      - Proper detection of case conditions
##   2005-02-21 - Version 1.0.0
##      - First release.
## 
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
$to_username = phpbb_clean_username($HTTP_POST_VARS['username']);

#
#-----[ AFTER, ADD ]------------------------------------------
#
// No PMs to self MOD begin
			if (strtolower($to_username) == strtolower($userdata['username']))
			{
				$error = TRUE;
				$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $lang['No_to_self'];
			}
// No PMs to self MOD end

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['No_to_user'] = 'You must specify a username to whom to send this message.';

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['No_to_self'] = 'You cannot send a private message to yourself.';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM