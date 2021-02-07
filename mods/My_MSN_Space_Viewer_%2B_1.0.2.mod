##############################################################
## MOD Title:           My MSN Space Viewer +
## MOD Author:          Kalipo < N/A > (N/A) N/A
## MOD Description:     Makes your MSN image in viewtopic, viewprofile and in privmsg link
##                      to your MSN MySpace page in a new page. It also adds
##                      clarification to the MSN, YIM and AIM blocks in your profile--no
##                      longer will new users guess if they have to add "@whatever".
##                        
## MOD Version:         1.0.2
##
## Installation Level:  (Easy)
## Installation Time:   2 Minutes
## Files To Edit:
##              privmsg.php,
##              viewtopic.php,
##              language/lang_english/lang_main.php,
##              includes/usercp_viewprofile.php,
##              includes/usercp_register.php,
##              templates/subSilver/profile_add_body.tpl,
##              templates/subSilver/profile_view_body.tpl
##      
## Included Files: (N/A)
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
##   -  The MOD does NOT distinguish between @hotmail and @msn users (if @msn is used anymore ~shrugs).
##      Because of the My MSN Space URL, you only need to enter your MSNM username.
##
##############################################################
## MOD History:
##
##   2006-03-06 - Version 1.0.2
##      - Reformatted template instructions suggested by wGEric.
##      - Resubmitted.
##   2006-02-12 - Version 1.0.1
##      - Fixed a dumb mistake on my part & cleaned up the template.
##      - Resubmitted.
##   2006-02-03 - Version 1.0.0 
##      - Submitted
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

        $msn_img = ( $privmsg['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
        $msn = ( $privmsg['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

#
#-----[ REPLACE WITH ]------------------------------------------
#

// Start My MSN Space Viewer +
        $msn_img = ( $privmsg['user_msnm'] ) ? '<a href="http://spaces.msn.com/' . $privmsg['user_msnm'] . '/" target="_blank"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
        $msn = ( $privmsg['user_msnm'] ) ? '<a href="http://spaces.msn.com/' . $privmsg['user_msnm'] . '/" target="_blank">' . $lang['MSNM'] . '</a>' : '';
// End My MSN Space Viewer +

#
#-----[ OPEN ]------------------------------------------
#

viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
                $msn_img = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
                $msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

#
#-----[ REPLACE WITH ]------------------------------------------
#

// Start My MSN Space Viewer +
                $msn_img = ( $postrow[$i]['user_msnm'] ) ? '<a href="http://spaces.msn.com/' . $postrow[$i]['user_msnm'] . '/" target="_blank"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
                $msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="http://spaces.msn.com/' . $postrow[$i]['user_msnm'] . '/" target="_blank">' . $lang['MSNM'] . '</a>' : '';
// End My MSN Space Viewer +

#
#-----[ OPEN ]------------------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#

$lang['YIM'] = 'Yahoo Messenger';

#
#-----[ AFTER, ADD ]----------------------------------------
#

// Start My MSN Space Viewer +
$lang['AIMX'] = 'Enter only your AIM username,<br />"@aol.com" isn\'t needed.';
$lang['MSNMX'] = 'Enter only your MSNM username,<br />"@hotmail.com" isn\'t needed.';
$lang['YIMX'] = 'Enter only your YIM username,<br />"@yahoo.com" isn\'t needed.';
// End My MSN Space Viewer +

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#

$msn_img = ( $profiledata['user_msnm'] ) ? $profiledata['user_msnm'] : '&nbsp;';

#
#-----[ REPLACE WITH ]----------------------------------------
#

// Start My MSN Space Viewer +
$msn_img = ( $profiledata['user_msnm'] ) ? '<a href="http://spaces.msn.com/' . $profiledata['user_msnm'] . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
// End My MSN Space Viewer +

#
#-----[ OPEN ]------------------------------------------
#

includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#

                'L_AIM' => $lang['AIM'],


#
#-----[ AFTER, ADD ]----------------------------------------
#

// Start My MSN Space Viewer +
                'L_MSNM_EXPLAIN' => $lang['MSNMX'],
                'L_YIM_EXPLAIN' => $lang['YIMX'],
                'L_AIM_EXPLAIN' => $lang['AIMX'],
// End My MSN Space Viewer +

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#

          <td class="row1"><span class="gen">{L_AIM}:</span></td>

#
#-----[ IN-LINE FIND ]----------------------------------------
#

</td>

#
#-----[ IN-LINE REPLACE WITH ]----------------------------------------
#

<br />

#
#-----[ AFTER, ADD ]----------------------------------------
#This is added right below the above edited line

                <span class="gensmall">{L_AIM_EXPLAIN}</span></td>

#
#-----[ FIND ]------------------------------------------
#

          <td class="row1"><span class="gen">{L_MESSENGER}:</span></td>

#
#-----[ IN-LINE FIND ]----------------------------------------
#

</td>

#
#-----[ IN-LINE REPLACE WITH ]----------------------------------------
#

<br />

#
#-----[ AFTER, ADD ]----------------------------------------
#This is added right below the above edited line

                <span class="gensmall">{L_MSNM_EXPLAIN}</span></td>

#
#-----[ FIND ]------------------------------------------
#

          <td class="row1"><span class="gen">{L_YAHOO}:</span></td>

#
#-----[ IN-LINE FIND ]----------------------------------------
#

</td>

#
#-----[ IN-LINE REPLACE WITH ]----------------------------------------
#

<br />

#
#-----[ AFTER, ADD ]----------------------------------------
#This is added right below the above edited line

                <span class="gensmall">{L_YIM_EXPLAIN}</span></td>

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/profile_view_body.tpl

#
#-----[ FIND ]------------------------------------------
#

                  <td class="row1" valign="middle"><span class="gen">{MSN}</span></td>

#
#-----[ IN-LINE FIND ]----------------------------------------
#

{MSN}

#
#-----[ IN-LINE REPLACE WITH ]----------------------------------------
#

{MSN_IMG}

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM
