##############################################################
## MOD Title:      Poster local time in viewtopic
## MOD Author:       Marshalrusty < phpbb@marshalrusty.com > (Yuriy Rusko) N/A
## MOD Description:   This very light MOD will add the user's local time under
##               his/her avatar in viewtopic. A great MOD if you have
##               members from different timezones.
##
## MOD Version: 1.0.0
## Installation Level:   Easy
## Installation Time:  ~5 Minutes
##
## Files To Edit:    viewtopic.php
##               language/lang_english/lang_main.php
##               templates/subSilver/viewtopic_body.tpl
##
## Included Files:   N/A
##
## License:      http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##
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
##   2006-10-02 - Version 1.0.0
##        Initial release
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
$sql = "SELECT u.username, u.user_id, u.user_posts, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate, u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_sig_bbcode_uid, u.user_avatar, u.user_avatar_type, u.user_allowavatar, u.user_allowsmile, p.*,  pt.post_text, pt.post_subject, pt.bbcode_uid

#
#-----[ IN-LINE FIND ]------------------------------------------
#
u.user_regdate

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, u.user_timezone

#
#-----[ FIND ]------------------------------------------
#
      'POSTER_JOINED' => $poster_joined,

#
#-----[ AFTER, ADD ]------------------------------------------
#
      'LOCAL_TIME' => $lang['Local_Time'] . create_date('g:i A', time(), $postrow[$i]['user_timezone']),

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
$lang['Local_Time'] = 'Local time: ';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]------------------------------------------
#
      <td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span><br /><span class="postdetails">{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}<br /><br />{postrow.POSTER_JOINED}<br />{postrow.POSTER_POSTS}<br />{postrow.POSTER_FROM}</span><br /></td>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
{postrow.POSTER_POSTS}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
<br />{postrow.LOCAL_TIME}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM