############################################################## 
## MOD Title:              Gadu-Gadu Online/Offline
## MOD Author:              DoDe < dode@dfgrom.com > (N/A) http://www.dfgrom.com
## MOD Description:  This MOD will allow you to have an 'Online/Offline' icon for Gadu-Gadu.
##                   When the icon is clicked, Gadu-Gadu that is installed on your PC will popup in a new window.
## MOD Version: 1.0.3
## 
## Installation Level: Intermediate
## Installation Time: ~20 Minutes
## Installation time with EasyMOD: 1 Minute
## Files To Edit: 
##                   admin/admin_users.php
##                   includes/functions_validate.php
##                   includes/usercp_avatar.php
##                   includes/usercp_register.php
##                   includes/usercp_viewprofile.php
##                   language/lang_english/email/coppa_welcome_inactive.tpl
##                   language/lang_english/lang_main.php
##                   templates/subSilver/admin/user_edit_body.tpl
##                   templates/subSilver/subSilver.cfg
##                   templates/subSilver/privmsgs_read_body.tpl
##                   templates/subSilver/profile_add_body.tpl
##                   templates/subSilver/profile_view_body.tpl
##                   templates/subSilver/viewtopic_body.tpl
##                   groupcp.php
##                   memberlist.php
##                   privmsg.php
##                   viewtopic.php
## Included Files: 
##                   templates\subSilver\images\lang_english\icon_gg.gif
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
## Copyright DoDe, < dode@dfgrom.com >
##
## In the future versions the description of your stautus will be dispayed on the icon
## More about the status can be found here http://www.gadu-gadu.pl/pomoc-faq.html#18
##
##############################################################
## MOD History:
##
##   2005-04-15 - Version 1.0.0
##  	- Beta release
##
##   2005-10-20 - Version 1.0.1
##  	- Minor changes to the wrong code
##
##   2006-01-25 - Version 1.0.2
##  	- Improved the code
##
##   2006-09-14 - Version 1.0.3
##      - Removed the unnecessary code
##      - Made some improves to the code
##      - Changed some code to work with easymode compliancy
##      - Updated to work with phpBB 2.0.21
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ SQL ]--------------------------------------
#
ALTER TABLE phpbb_users ADD user_gg VARCHAR(10) NULL;
#
#-----[ OPEN ]-------------------------------------
#
admin/admin_users.php
#
#-----[ FIND ]-------------------------------------
#
                $yim = ( !empty($HTTP_POST_VARS['yim']) ) ? trim(strip_tags( $HTTP_POST_VARS['yim'] ) ) : '';
#
#-----[ AFTER, ADD ]-------------------------------------
#
                  $gg = ( !empty($HTTP_POST_VARS['gg']) ) ? trim(strip_tags( $HTTP_POST_VARS['gg'] ) ) : '';
#
#-----[ FIND ]-------------------------------------
#
                validate_optional_fields($icq, $aim, $msn,
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
                $yim,

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
                 $gg,
#
#-----[ FIND ]-------------------------------------
#
                SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) . "', user_icq = '" . str_replace("\'", "''", $icq)
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
                str_replace("\'", "''", $yim) . "',
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
                user_gg = '" . str_replace("\'", "''", $gg) . "',
#
#-----[ FIND ]-------------------------------------
#
                $s_hidden_fields .= '<input type="hidden" name="yim" value="' . str_replace("\"", "&quot;", $yim) . '" />';
#
#-----[ AFTER, ADD ]-------------------------------------
#
                $s_hidden_fields .= '<input type="hidden" name="gg" value="' . str_replace("\"", "&quot;", $gg) . '" />';
#
#-----[ FIND ]-------------------------------------
#
               'AIM' => $aim,
#
#-----[ AFTER, ADD ]-------------------------------------
#
               'GG'  => $gg,
#
#-----[ FIND ]-------------------------------------
#
               'L_AIM' => $lang['AIM']
#
#-----[ AFTER, ADD ]-------------------------------------
#
               'L_GADU-GADU' => $lang['GG'],
#
#-----[ OPEN ]-------------------------------------
#
includes/functions_validate.php

#
#-----[ FIND ]-------------------------------------
#
               function validate_optional_fields(&$icq, &$aim, &$msnm,
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
               &$yim,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
               &$gg,
#
#-----[ FIND ]-------------------------------------
#
                // ICQ number has to be only numbers.
                if (!preg_match('/^[0-9]+$/', $icq))
                {
                $icq = '';
                 }
#
#-----[ AFTER, ADD ]-------------------------------------
#
                      // GG number has to be only numbers.
                      if (!preg_match('/^[0-9]+$/', $gg))
                      {
                       $gg = '';
                     }
#
#-----[ OPEN ]-------------------------------------
#
includes/usercp_avatar.php
#
#-----[ FIND ]-------------------------------------
#
               function display_avatar_gallery($mode, &$category, &$user_id, &$email, &$current_email, &$coppa, &$username, &$email, &$new_password, &$cur_password, &$password_confirm, &$icq, &$aim, &$msn,
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
               &$yim,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
               &$gg,
#
#-----[ FIND ]-------------------------------------
#
               $params = array('coppa', 'user_id', 'username', 'email', 'current_email', 'cur_password', 'new_password', 'password_confirm', 'icq', 'aim', 'msn',
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
              'yim',
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
              'gg',
#
#-----[ OPEN ]-------------------------------------
#
includes/usercp_register.php
#
#-----[ FIND ]-------------------------------------
#
              $strip_var_list = array('email' => 'email', 'icq' => 'icq', 'aim' => 'aim', 'msn' => 'msn',
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
             'yim' => 'yim',
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
            'gg' => 'gg',
#
#-----[ FIND ]-------------------------------------
#
            validate_optional_fields($icq, $aim, $msn,
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
            $yim,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
           $gg,
#
#-----[ FIND ]-------------------------------------
#
           $yim = stripslashes($yim);
#
#-----[ AFTER, ADD ]-------------------------------------
#
           $gg  = stripslashes($gg);
#
#-----[ FIND ]-------------------------------------
#
           SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."',
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
           user_yim = '" . str_replace("\'", "''", $yim) . "',
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
           user_gg = '" . str_replace("\'", "''", $gg) . "',
#
#-----[ FIND ]-------------------------------------
#
	   $sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate,
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
           user_yim,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
           user_gg,
#
#-----[ FIND ]-------------------------------------
#
           VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ",
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
          '" . str_replace("\'", "''", $yim) . "',
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
          '" . str_replace("\'", "''", $gg) . "',
#
#-----[ FIND ]-------------------------------------
#
          'MSN' => $msn,
#
#-----[ AFTER, ADD ]-------------------------------------
#
          'GG'  => $gg,
#
#-----[ FIND ]-------------------------------------
#
          $yim = stripslashes($yim);
#
#-----[ AFTER, ADD ]-------------------------------------
#
         $gg  = stripslashes($gg);
#
#-----[ FIND ]-------------------------------------
#
         $yim = $userdata['user_yim'];
#
#-----[ AFTER, ADD ]-------------------------------------
#
         $gg  = $userdata['user_gg'];
#
#-----[ FIND ]-------------------------------------
#
         display_avatar_gallery($mode, $avatar_category, $user_id, $email,
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
         $yim,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
         $gg,

#
#-----[ FIND ]-------------------------------------
#
        'AIM' => $aim,
#
#-----[ AFTER, ADD ]-------------------------------------
#
        'GG'  => $gg,
#
#-----[ FIND ]-------------------------------------
#
        'L_AIM' => $lang['AIM'],
#
#-----[ AFTER, ADD ]-------------------------------------
#
        'L_GADU-GADU' => $lang['GG'],
#
#-----[ OPEN ]-------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]-------------------------------------
#
          else
        {
        $icq_status_img = '&nbsp;';
        $icq_img = '&nbsp;';
        $icq = '&nbsp;';
        }
#
#-----[ AFTER, ADD ]-------------------------------------
#
              if ( !empty($profiledata['user_gg']) )
              {
                      $gg_status_img = '<a href="gg:' . $profiledata['user_gg'] . '"><img src="http://www.gadu-gadu.pl/users/status.asp?id=' . $profiledata['user_gg'] . '&img=5" width="18" height="18" border="0" /></a>';
                      $gg_img = '<a href="gg:' . $profiledata['user_gg'] . '"><img src="' . $images['icon_gg'] . '" alt="' . $lang['GG'] . '" title="' . $lang['GG'] . '" border="0" /></a>';
                      $gg =  '<a href="gg:' . $profiledata['user_gg'] . '">' . $lang['GG'] . '</a>';
              }
              else
              {
                      $gg_status_img = '&nbsp;';
                      $gg_img = '&nbsp;';
                      $gg = '&nbsp;';
              }
#
#-----[ FIND ]-------------------------------------
#
        'MSN' => $msn,
#
#-----[ AFTER, ADD ]-------------------------------------
#
        'GG_STATUS_IMG' => $gg_status_img,
               'GG_IMG' => $gg_img,
          'GG' => $gg,
#
#-----[ FIND ]-------------------------------------
#
        'L_YAHOO' => $lang['YIM'],
#
#-----[ AFTER, ADD ]-------------------------------------
#
        'L_GADU-GADU' => $lang['GG'],
#
#-----[ OPEN ]-------------------------------------
#
language/lang_english/email/coppa_welcome_inactive.tpl
#
#(If you have other language directories you will have to change this file from that directory as showen here)
#
#-----[ FIND ]-------------------------------------
#
        Yahoo Messenger: {YIM}
#
#-----[ AFTER, ADD ]-------------------------------------
#
       GG Number: {GG}
#
#-----[ OPEN ]-------------------------------------
#
#(If you have other language directories you will have to change this file from that directory as showen here)
language/lang_english/lang_main.php
#
#-----[ FIND ]-------------------------------------
#
        $lang['YIM'] = 'Yahoo Messenger';
#
#-----[ AFTER, ADD ]-------------------------------------
#
        $lang['GG'] = 'Gadu-Gadu Number';
#
#-----[ FIND ]-------------------------------------
#
       $lang['ICQ_status'] = 'ICQ Status';
#
#-----[ AFTER, ADD ]-------------------------------------
#
       $lang['GG_status'] = 'GG Status';
#
#-----[ OPEN ]-------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]-------------------------------------
#
            <tr> 
          <td class="row1"><span class="gen">{L_YAHOO}</span></td>
          <td class="row2"> 
                <input class="post" type="text" name="yim" size="20" maxlength="255" value="{YIM}" />
          </td>
        </tr>
#
#-----[ AFTER, ADD ]-------------------------------------
#
              <tr> 
          <td class="row1"><span class="gen">{L_GADU-GADU}</span></td>
          <td class="row2"> 
                <input class="post" type="text" name="gg" size="10" maxlength="15" value="{GG}" />
          </td>
        </tr>
#
#-----[ OPEN ]-------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]-------------------------------------
#
        $images['icon_msnm'] = "$current_template_images/{LANG}/icon_msnm.gif";
#
#-----[ AFTER, ADD ]-------------------------------------
#
        $images['icon_gg'] = "$current_template_images/{LANG}/icon_gg.gif";
#
#-----[ OPEN ]-------------------------------------
#
templates/subSilver/privmsgs_read_body.tpl
#
#-----[ FIND ]-------------------------------------
#
		  //--></script><noscript>{ICQ_IMG}</noscript></td>
#
#-----[ REPLACE WITH ]-------------------------------------
#
                  //--></script><noscript>{ICQ_IMG}</noscript><script language="JavaScript" type="text/javascript"><!--
                if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
                        document.write('{GG_IMG}');
                else
                        document.write('<td nowrap="nowrap"><div style="position:relative;height:18px;left:60px"><div style="position:absolute">{GG_IMG}</div><div style="position:absolute;left:2px;top:0px">{GG_STATUS_IMG}</div></div></td>');

                  //--></script><noscript>{GG_IMG}</noscript></td>
#
#-----[ OPEN ]-------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]-------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post" style="width: 150px"  name="yim" size="20" maxlength="255" value="{YIM}" />
	  </td>
	</tr>
#
#-----[ AFTER, ADD ]-------------------------------------
#
              <tr> 
          <td class="row1"><span class="gen">{L_GADU-GADU}:</span></td>
          <td class="row2"> 
                <input type="text" name="gg" class="post"style="width: 100px"  size="10" maxlength="15" value="{GG}" />
          </td>
        </tr>
#
#-----[ OPEN ]-------------------------------------
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]-------------------------------------
#
                      //--></script><noscript>{ICQ_IMG}</noscript></td>
                </tr>
#
#-----[ AFTER, ADD ]-------------------------------------
#
                      <tr> 
                  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_GADU-GADU}:</span></td>
                  <td class="row1"><script language="JavaScript" type="text/javascript"><!-- 

                if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 )
                        document.write(' {GG_IMG}');
                else
                        document.write('<table cellspacing="0" cellpadding="0" border="0"><tr><td nowrap="nowrap"><div style="position:relative;height:18px"><div style="position:absolute">{GG_IMG}</div><div style="position:absolute;left:3px;top:-1px">{GG_STATUS_IMG}</div></div></td></tr></table>');
                //--></script><noscript>{GG_IMG}</noscript></td>
                </tr>
#
#-----[ OPEN ]-------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]-------------------------------------
#
		     //--></script><noscript>{postrow.ICQ_IMG}</noscript></td>
#
#-----[ REPLACE WITH ]-------------------------------------
#
                     //--></script><noscript>{postrow.ICQ_IMG}</noscript><script language="JavaScript" type="text/javascript"><!--
            if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
                document.write(' {postrow.GG_IMG}');
        else
                document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative;left:60px"><div style="position:absolute">{postrow.GG_IMG}</div><div style="position:absolute;left:3px;top:0px">{postrow.GG_STATUS_IMG}</div></div>');
                                
                //--></script><noscript>{postrow.GG_IMG}</noscript></td>
#
#-----[ OPEN ]-------------------------------------
#
privmsg.php
#
#-----[ FIND ]-------------------------------------
#
        $sql = "SELECT u.username AS username_1, u.user_id AS user_id_1,
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
        u.user_yim,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
        u.user_gg,
#
#-----[ FIND ]-------------------------------------
#
    else
        {
                $icq_status_img = '';
                $icq_img = '';
                $icq = '';
        }
#
#-----[ AFTER, ADD ]-------------------------------------
#
      if ( !empty($privmsg['user_gg']) )
       {
                $gg_status_img = '<a href="gg:' . $privmsg['user_gg'] . '"><img src="http://www.gadu-gadu.pl/users/status.asp?id=' . $privmsg['user_gg'] . '&img=5" width="18" height="18" border="0" /></a>';
                $gg_img = '<a href="gg:' . $privmsg['user_gg'] . '"><img src="' . $images['icon_gg'] . '" alt="' . $lang['GG'] . '" title="' . $lang['GG'] . '" border="0" /></a>';
                $gg =  '<a href="gg:' . $privmsg['user_gg'] . '">' . $lang['GG'] . '</a>';
        }
        else
        {
                $gg_status_img = '';
                $gg_img = '';
                $gg = '';
        }
#
#-----[ FIND ]-------------------------------------
#
       'ICQ' => $icq,
#
#-----[ AFTER, ADD ]-------------------------------------
#
       'GG_STATUS_IMG' => $gg_status_img,
       'GG_IMG' => $gg_img,
       'GG' => $gg,
#
#-----[ OPEN ]-------------------------------------
#
viewtopic.php
#
#-----[ FIND ]-------------------------------------
#
    //
    // Go ahead and pull all data for this topic
    //
    $sql = "SELECT u.username, u.user_id, u.user_posts, u.user_from,
#
#-----[ IN-LINE FIND ]------------------------------------------------
#
        u.user_yim,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------------
#
        u.user_gg,
#
#-----[ FIND ]-------------------------------------
#
    else
                {
                        $icq_status_img = '';
                        $icq_img = '';
                        $icq = '';
                }
#
#-----[ AFTER, ADD ]-------------------------------------
#
      if ( !empty($postrow[$i]['user_gg']) )
               {
                        $gg_status_img = '<a href="gg:' . $postrow[$i]['user_gg'] . '"><img src="http://www.gadu-gadu.pl/users/status.asp?id=' . $postrow[$i]['user_gg'] . '&img=5" width="18" height="18" border="0" /></a>';
                              $gg_img = '<a href="gg:' . $postrow[$i]['user_gg'] . '"><img src="' . $images['icon_gg'] . '" alt="' . $lang['GG'] . '" title="' . $lang['GG'] . '" border="0" /></a>';
                              $gg =  '<a href="gg:' . $postrow[$i]['user_gg'] . '">' . $lang['GG'] . '</a>';
               }
               else
               {
                               $gg_status_img = '';
                              $gg_img = '';
                              $gg = '';
               }
#
#-----[ FIND ]-------------------------------------
#
        $yim = '';
#
#-----[ AFTER, ADD ]-------------------------------------
#
        $gg_status_img = '';
        $gg_img = '';
        $gg = '';
#
#-----[ FIND ]-------------------------------------
#
       'YIM' => $yim,
#
#-----[ AFTER, ADD ]-------------------------------------
#
       'GG_STATUS_IMG' => $gg_status_img,
       'GG_IMG' => $gg_img,
       'GG' => $gg,
# 
#-----[ COPY ]------------------------------------------ 
# (copy it also to the directories of other languages)
copy templates/subSilver/images/lang_english/icon_gg.gif to templates/subSilver/images/lang_english/icon_gg.gif
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM

