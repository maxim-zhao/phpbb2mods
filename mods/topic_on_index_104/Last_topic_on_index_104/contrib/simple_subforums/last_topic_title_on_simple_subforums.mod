##############################################################
## MOD Title: Last Topic Title on Simple Subforums Mod
## MOD Author: Dicky <rfoote@tellink.net> (Richard Foote) http://dicky.askmaggymae.com
## MOD Description: Displays the title of and adds a link to the last topic replied to 
##                    in a particular subforum on the view forum page.
## MOD Version: 0.0.3
##
## Installation Level: Easy
## Installation Time: 10 Minutes
## Files To Edit: (2)
##				viewforum.php
##				templates/subSilver/viewforum_body.tpl
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
## Author Notes: Dicky
##
##   Requires the installation of Simple Subforums by pentapenquin http://www.phpbb.com/phpBB/viewtopic.php?t=336974
##   Requires the installation of Last Topic Title on Index by Dicky http://www.phpbb.com/phpBB/viewtopic.php?t=350442
## 	 This MOD has been verified to work with phpBB 2.0.21
##	 This MOD can be installed by EasyMOD
##############################################################
## MOD History:
##
##   2006-11-28 - Version 0.0.3
##		- Improved on converting html characters to prevent XSS exploit
##		- Fixed selection of topics with null status
##   2006-03-12 - Version 0.0.2
##      - Change function to strip html characters
##   2006-01-26 - Version 0.0.1
##      - initial version of the Last Topic Title on Simple Subforums Mod
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

viewforum.php

# 
#-----[ FIND ]----------------------------------------- 
#
<?php
# 
#-----[ AFTER, ADD ]---------------------------------------- 
#
//-- MOD : Last Topic Title on subforum Index -------------------
# 
#-----[ FIND ]----------------------------------------- 
#
include($phpbb_root_path . 'common.'.$phpEx);
#
#-----[ AFTER, ADD ]----------------------------------------- 
#

//-- MOD BEGIN: Last Topic Title on Index -------------------
$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');
 
$html_entities_match = array('#&(?!(\#[0-9]+;))#', '#<#', '#>#', '#"#');
$html_entities_replace = array('&amp;', '&lt;', '&gt;', '&quot;');
//-- MOD END: Last Topic Title on Index -------------------

# 
#-----[ FIND ]----------------------------------------- 
#
		default:
# 
#-----[ AFTER, ADD ]----------------------------------------- 
#
//-- MOD BEGIN: Last Topic Title on subforum Index -------------------
# 
#-----[ FIND ]----------------------------------------- 
#
			$sql
# 
#-----[ IN-LINE FIND ]----------------------------------------- 
#
u.user_id
# 
#-----[ IN-LINE AFTER, ADD ]----------------------------------------- 
#
, t.topic_id, t.topic_title, t.topic_last_post_id
# 
#-----[ FIND ]----------------------------------------- 
#
FROM
# 
#-----[ IN-LINE FIND ]----------------------------------------- 
#
(
# 
#-----[ IN-LINE AFTER, ADD ]----------------------------------------- 
#
(
# 
#-----[ FIND ]----------------------------------------- 
#
				LEFT JOIN " . USERS_TABLE . " u ON u.user_id = p.poster_id )
# 
#-----[ AFTER, ADD ]----------------------------------------- 
#
				LEFT JOIN " . TOPICS_TABLE . " t ON t.topic_last_post_id = p.post_id )
# 
#-----[ FIND ]----------------------------------------- 
#
				ORDER BY f.cat_id, f.forum_order";
# 
#-----[ AFTER, ADD ]----------------------------------------- 
#
//-- MOD END: Last Topic Title on subforum Index -------------------
# 
#-----[ FIND ]----------------------------------------- 
#  
	$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $subforum_data);
# 
#-----[ AFTER, ADD ]---------------------------------------- 
#

//-- MOD BEGIN: Last Topic Title on subforum Index -------------------
	//
	// Find which forums are readable for this user
	//
	$auth_read_ary = array();
	$auth_read_ary = auth(AUTH_READ, AUTH_LIST_ALL, $userdata, $subforum_data);
//-- MOD END: Last Topic Title on subforum Index -------------------

#
#-----[ FIND ]------------------------------------------
#
				$last_post .= ( $subforum_data[$j]['user_id'] == ANONYMOUS ) ? ( ($subforum_data[$j]['post_username'] != '' ) ? $subforum_data[$j]['post_username'] . ' ' : $lang['Guest'] . ' ' ) : '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $subforum_data[$j]['user_id']) . '">' . $subforum_data[$j]['username'] . '</a> ';
#
#-----[ REPLACE WITH ]------------------------------------------
#
					//-- MOD BEGIN: Last Topic Title on subforum Index -------------------
								$ltid = $subforum_data[$j]['topic_id'];
								$lttitle = $subforum_data[$j]['topic_title'];

						//
						// Censor topic title
						//
								if ( count($orig_word) )
								{
									$lttitle = preg_replace($orig_word, $replacement_word, $lttitle);
								}
								$altlttitle = $lttitle;
								$lang_in = $lang['in'];

						//
						// Filter topic_title if not allowed to read
						//
								if (!$auth_read_ary[$subforum_data[$j]['forum_id']]['auth_read'])
								{
									$lttitle = '';
									$lang_in = '';
						    	}

						// undo_htmlspecialchars();
								$lttitle = preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, $lttitle);

						// do_htmlspecialchars();
						// set length of topic title to 25 characters
								$lttitle = preg_replace($html_entities_match, $html_entities_replace, (strlen($lttitle) > 25) ? substr($lttitle,0,25) . '...' : $lttitle);

								$last_post .= $lang_in . '&nbsp;' . '<a title="' . $altlttitle . '" alt="' . $altlttitle . '" href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$ltid") . '">' . $lttitle . '</a><br />';

								$last_post .= ( $subforum_data[$j]['user_id'] == ANONYMOUS ) ? $lang['by'] . '&nbsp;' . ( ($subforum_data[$j]['post_username'] != '' ) ? $subforum_data[$j]['post_username'] . ' ' : $lang['Guest'] . ' ' ) : $lang['by'] . '&nbsp;' . '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . '='  . $subforum_data[$j]['user_id']) . '">' . $subforum_data[$j]['username'] . '</a> ';

					//-- MOD END: Last Topic Title on subforum Index -------------------
# 
#-----[ OPEN ]------------------------------------------------ 
#

templates/subSilver/viewforum_body.tpl

# 
#-----[ FIND ]----------------------------------------- 
# 
catrow.forumrow.LAST_POST
# 
#-----[ IN-LINE FIND ]----------------------------------------- 
#
center
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
left
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM