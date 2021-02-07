##############################################################
## MOD Title: Show Replies and Views in Topic
## MOD Author: alexi02 < N/A > (Alejandro Iannuzzi) http://www.uzzisoft.com
## MOD Description: Shows the replies and views of the topic that you are viewing in the topic
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit: viewtopic.php
##                language/lang_english/lang_main.php
##                templates/subSilver/viewtopic_body.tpl
## Included Files: N/A
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
##      Very simple mod to show the replies and views of the topic you are currently viewing.
##
##############################################################
## MOD History:
##
##  2006-09-19 - Version 1.0.0
##      - Updated to v1.0.0 for the MOD-DB
##
##  2006-09-14 - Version 0.1.0
##      - Initial Release (for phpBB 2.0.21)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

viewtopic.php

#
#-----[ FIND ]------------------------------------------
#

$sql = "SELECT t.topic_id,

#
#-----[ IN-LINE FIND ]------------------------------------------
#

t.topic_replies,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

 t.topic_views,

#
#-----[ FIND ]------------------------------------------
#

//
// Go ahead and pull all data for this topic
//

#
#-----[ BEFORE, ADD ]------------------------------------------
#

//
// Start Show Replies and Views in Topic Mod
//

$topic_replies_and_views = $forum_topic_data['topic_replies'] . ' ' . $lang['Showrav_replies'] . ' / ' . $forum_topic_data['topic_views'] . ' ' . $lang['Showrav_views'];

//
// End Show Replies and Views in Topic Mod
//

#
#-----[ FIND ]------------------------------------------
#

'S_WATCH_TOPIC_IMG' => $s_watching_topic_img,

#
#-----[ AFTER, ADD ]------------------------------------------
#

        'S_REPLIES_AND_VIEWS' => $topic_replies_and_views,
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

//
// Start Show Replies and Views in Topic Mod
//

$lang['Showrav_replies'] = 'Replies';
$lang['Showrav_views'] = 'Views';

//
// End Show Replies and Views in Topic Mod
//

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>

#
#-----[ AFTER, ADD ]------------------------------------------
#

	<td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall">{S_REPLIES_AND_VIEWS}</span><br /><span class="nav">{PAGINATION}</span>
	</td>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM