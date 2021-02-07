##############################################################
## MOD Title: Simple Bin MOD
## MOD Author: eviL3 < evil@phpbbmodders.com > (Igor Wiedler) http://phpbbmodders.com
## MOD Description: Whenever a moderator or admin deletes a post it will be moved
##                  to the "bin forum" (specified in ACP) instead. This is really
##                  simple. If it's deleted in that forum, it will be gone though.
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 6 minutes
## Files To Edit: modcp.php
##                admin/admin_board.php
##                templates/subSilver/admin/board_config_body.tpl
##                language/lang_english/lang_admin.php
##
## Included Files: n/a
##
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
##############################################################
## MOD History:
##
## 2006-07-24 - Version 1.0.0
## -Updated and submitted
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]------------------------------------------
#
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bin_forum',1);

#
#-----[ OPEN ]------------------------------------------
#
modcp.php

#
#-----[ FIND ]------------------------------------------
#
			//
			// Got all required info so go ahead and start deleting everything
			//

#
#-----[ AFTER, ADD ]------------------------------------------
#
      if ( $forum_id != $board_config['bin_forum'] )
      {
				for($i = 0; $i < count($row); $i++)
				{
					$topic_id = $row[$i]['topic_id'];

					$sql = "UPDATE " . TOPICS_TABLE . "
						SET forum_id = '" . $board_config['bin_forum'] . "'
				    WHERE topic_id IN ($topic_id_sql)";
          if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update old topic', '', __LINE__, __FILE__, $sql);
					}

					$sql = "UPDATE " . POSTS_TABLE . "
						SET forum_id = '" . $board_config['bin_forum'] . "'
				    WHERE topic_id IN ($topic_id_sql)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update post topic ids', '', __LINE__, __FILE__, $sql);
					}
				}
				// Sync the forum indexes
				sync('forum', $board_config['bin_forum']);
				sync('forum', $forum_id);

        $redirect_page = "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$l_redirect = sprintf($lang['Click_return_forum'], '<a href="' . $redirect_page . '">', '</a>');

  			$template->assign_vars(array(
  				'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
  			);

        message_die(GENERAL_MESSAGE, $lang['Topics_Removed'] . '<br /><br />' . $l_redirect);
      }

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

#
#-----[ FIND ]------------------------------------------
#
$template->set_filenames(array(

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Simple Bin
$bin_forum = make_forum_select('bin_forum', false, $new['bin_forum']);
// Simple Bin

#
#-----[ FIND ]------------------------------------------
#
	"L_SYSTEM_TIMEZONE" => $lang['System_timezone'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	"L_BIN_FORUM" => $lang['Bin_forum'],

#
#-----[ FIND ]------------------------------------------
#
	"TIMEZONE_SELECT" => $timezone_select,

#
#-----[ AFTER, ADD ]------------------------------------------
#
	"BIN_FORUM" => $bin_forum,

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<tr>
		<td class="row1">{L_SYSTEM_TIMEZONE}</td>
		<td class="row2">{TIMEZONE_SELECT}</td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_BIN_FORUM}</td>
		<td class="row2"><span class="gen">{BIN_FORUM}</span></td>
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['Bin_forum'] = 'Bin Forum';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
