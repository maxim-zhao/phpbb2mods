##############################################################
## MOD Title: Change Poster
## MOD Author: Joe Belmaati < belmaati@gmail.com > (Joe Belmaati) N/A
## MOD Description: With this MOD you can change the poster of each
## individual post. If the post is the first post in a topic, then the
## topic poster will also be updated. You can also change ALL post by
## user X to user Y - but be careful...
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 7 Minutes
## Files To Edit: 4
##		viewtopic.php,
##      language/lang_english/lang_main.php
##      templates/subSilver/viewtopic_body.tpl
##      templates/subSilver/subSilver.cfg
##
## Included Files: 3
##      changeposter.php
##      templates/subSilver/change_poster.tpl
##      templates/subSilver/images/icon_change_poster.gif
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
## Author Notes: This MOD is written for subsilver. You may
## want to change the css classes I have used to classes
## compatible with you template
##
##############################################################
## MOD History:
##
##   2006-09-13 - 1.0.1
##      - resubmitted to MODs database at phpBB
##
##   2006-08-16 - 1.0.0
##      - submitted to MODs database at phpBB
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy root/changeposter.php to changeposter.php
copy root/templates/subSilver/change_poster.tpl to templates/subSilver/change_poster.tpl
copy root/templates/subSilver/images/icon_change_poster.gif to templates/subSilver/images/icon_change_poster.gif
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
	$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : '';
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	$change_poster = ($userdata['user_level'] == ADMIN) ? '<a href="' . append_sid("changeposter.$phpEx?post_id=" . $postrow[$i]['post_id']) . '" class="gensmall"><img src="' . $images['icon_change_poster'] . '" alt="' . $lang['Change_poster'] . '" title="' . $lang['Change_poster'] . '" border="0" /></a>' : '';
#
#-----[ FIND ]------------------------------------------
#
		'IP' => $ip,
#
#-----[ AFTER, ADD ]------------------------------------------
#
		'CHANGE_POSTER_IMG' => $change_poster,
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
// Change Poster
//
$lang['Change_poster'] = 'Change poster';
$lang['Post_updated'] = 'Post succesfully updated';
$lang['Select_new_poster'] = 'Select new user for this posting';
$lang['Click_return_post'] = 'Click %sHere%s to return to the post';
$lang['Move_all'] = 'Tick this checkbox to change <em><b>all</b></em> posts by <b>%s</b> to the new user (**WARNING!! This action is irreversible - use at your own risk**)';
$lang['Moved_posts'] = '%d posts moved from <b>%s</b> to <b>%s</b>';
$lang['Move_posts_confirm'] = 'Are you sure that you want to move all posts from <b>%s</b> to <b>%s</b>?';
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
#
				<td valign="top" nowrap="nowrap">{postrow.QUOTE_IMG}
#
#-----[ IN-LINE FIND ]------------------------------------------
#
{postrow.IP_IMG}
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 {postrow.CHANGE_POSTER_IMG}
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]------------------------------------------
#
$images['icon_newest_reply'] = "$current_template_images/icon_newest_reply.gif";
#
#-----[ AFTER, ADD ]------------------------------------------
#
$images['icon_change_poster'] = "$current_template_images/icon_change_poster.gif";
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM