##############################################################
## MOD Title: Smilies Invasion
## MOD Author: darklordsatan < N/A > (N/A) http://eviltrend.sourceforge.net
## MOD Description: Update from 1.0.0 to 1.2.1
## MOD Version: 1.2.1
##
## Installation Level: (Easy)
## Installation Time: 5 Minutes
## Files To Edit: includes/bbcode.php
##                includes/functions_post.php
##                language/lang_english/lang_main.php
##                modcp.php
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
## Author Notes: In case you installed 1.0.0 version of this MOD, use this file to update 
##               it to the latest version (1.2.1)
##
##               Before you upload your modified files to the server, you might want to check the Manual Configuration Variable $smilies_limit (default 3)
##               after the block // -~= { Start User Configuration } =~- \\ in the file "includes/functions_post.php"
##
##############################################################
## MOD History:
##
##   2005-10-16 - Version 1.0.0
##      - Release of the first version
##
##   2005-11-23 - Version 1.2.0
##      - The mod is compliant with the latest phpBB release (2.0.18)
##      - Post subject (topic title/reply subject) smiley number is restricted to everybody but the administrator
##      - FIND Install Actions in the Mod Template reduced as much as possible, so that people with heavily modded boards can install this mod easily
##      - Added new places for the smilies to be shown. Namely the Moderator Control Panel and Split Topic Control Panel
##
##   2005-12-06 - Version 1.2.1
##      - Minor code fixes/additions in order to resubmit the mod at the phpBB MOD database
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Start Smilies Invasion Mod
function smilies_count($message)
{
	
	$smilies_count = 0;

	global $db, $board_config;

	$sql = 'SELECT * FROM ' . SMILIES_TABLE;
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain smilies data", "", __LINE__, __FILE__, $sql);
	}
	$smilies = $db->sql_fetchrowset($result);

	if (count($smilies))
	{
		usort($smilies, 'smiley_sort');
	}

	$i = 0;
	while ($i < count($smilies))
	{
		$orig = "/(?<=.\W|\W.|^\W)" . preg_quote($smilies[$i]['code'], "/") . "(?=.\W|\W.|\W$)/";
		$repl = '<img src="'. $board_config['smilies_path'] . '/' . $smilies[$i]['smile_url'] . '" alt="' . $smilies[$i]['emoticon'] . '" title="' . $smilies[$i]['emoticon'] . '" border="0" />';
		// Matching limit set to 1 otherwise the user could enter the same smiley N times (lets call it Armageddon from now on)
		$tmp = preg_replace($orig, $repl, ' ' . $message . ' ', 1);
		$tmp = trim($tmp);
				
		if(strcasecmp($tmp, $message) != 0)
		{
			$smilies_count++;
			$message = $tmp;
		}
		else
		{
			// If we are not in Armageddon
			$i++;
		}
	}
	
	return $smilies_count;
}
// End Smilies Invasion Mod


#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#
	// Check message
	if (!empty($message))

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	// Start Smilies Invasion Mod
	// Check Smiley Count
	if ($userdata['user_level'] != ADMIN)
	{
		// -~= { Start User Configuration } =~- \\		
		$smilies_limit = 3;		
		// -~= { End User Configuration { =~- \\		
		
		$smilies_count = smilies_count($subject);
		if ($smilies_count > $smilies_limit)
		{
			$error_msg .= (!empty($error_msg)) ? '<br />' . sprintf($lang['Smilies_invasion_error_count'], $smilies_count, $smilies_limit) : sprintf($lang['Smilies_invasion_error_count'], $smilies_count, $smilies_limit);
		}
	}
	// End Smilies Invasion Mod


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
// Start Remote Avatar Check Mod
$lang['Smilies_invasion_error_count'] = 'The number of smilies in the post subject (%d) is over the limit (%d)';
// End Remote Avatar Check Mod


#
#-----[ OPEN ]------------------------------------------
#
modcp.php

#
#-----[ FIND ]------------------------------------------
#
				$postrow = $db->sql_fetchrowset($result);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				// Start Smilies Invasion Mod
				if ( $board_config['allow_smilies'] )
				{
					$forum_name = smilies_pass($forum_name);
				}
				// End Smilies Invasion Mod


#
#-----[ FIND ]------------------------------------------
#
					$checkbox = ( $i > 0 ) ? '<input type="checkbox" name="post_id_list[]" value="' . $post_id . '" />' : '&nbsp;';

#
#-----[ AFTER, ADD ]------------------------------------------
#
					// Start Smilies Invasion Mod
					if ( $board_config['allow_smilies'] )
					{
						$post_subject = smilies_pass($post_subject);
					}
					// End Smilies Invasion Mod


#
#-----[ FIND ]------------------------------------------
#
	default:
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// Start Smilies Invasion Mod
		if ( $board_config['allow_smilies'] )
		{
			$forum_name = smilies_pass($forum_name);
		}
		// End Smilies Invasion Mod


#
#-----[ FIND ]------------------------------------------
#
			$template->assign_block_vars('topicrow', array(

#
#-----[ BEFORE, ADD ]------------------------------------------
#
			// Start Smilies Invasion Mod
			if ( $board_config['allow_smilies'] )
			{
				$topic_title = smilies_pass($topic_title);
			}
			// End Smilies Invasion Mod


#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
Check the file includes/functions_post.php, and look for the line
		// -~= { Start User Configuration } =~- \\
After that line there is an user-configurable variable called $smilies_limit (default value 3). Change at will.
This variable basically sets the limit for smilies in the post subject (topic title or reply subject)

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM