############################################################## 
## MOD Title: Yahoo Messanger Online/Offline 
## MOD Author: donpedro00 < palagyi@hotmail.com > (Peter Palagyi) http://www.SlovakiaClub.com 
## MOD Description: This MOD will allow you to have an 'Online/Offline' Icon For Yahoo Messanger.
##                  When cliked on icon, Yahoo web page will open with Lite version of web
##                  based messanger. This is how ot was originaly designed.
## MOD Version: 2.0.4 - WEB
## 
## Installation Level: Easy
## Installation Time: ~10 Minutes
## Files To Edit: 
##                   viewtopic.php
##                   templates/subSilver/viewtopic_body.tpl
##                   privmsg.php
##                   templates/subSilver/privmsgs_read_body.tpl
##                   includes/usercp_viewprofile.php
##                   templates/subSilver/profile_view_body.tpl
##                   templates/subSilver/subSilver.cfg
## Included Files: 
##                   templates/subSilver/images/lang_english/icon_yim_status.gif 
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
## Copyright © Peter Palagyi, < palagyi@hotmail.com >
##
## Make sure that in your Yahoo Public Profile you uncheck "Check the box to hide my 
## online status () from other users" checkbox. Otherwise the status will always show you as offline.
## More about that flag can be found here http://messenger.yahoo.com/messenger/onlinestatus.html
##
############################################################## 
## MOD History: 
## 
##   2003-06-21 - Version 1.0.0 
##      - Initial Release For phpBB 2.0.5 (also works with phpBB 2.0.2)
##   2003-06-21 - Version 1.0.1
##      - privmsg.php modified to include this MOD in PM
##   2003-07-28 - Version 2.0.0
##      - new "SubSilver" compatible icon added
##      - two version are maintained. web and pc messanger version
##   2003-08-09 - Version 2.0.1
##      - fixed issue with private message and profile (wrong icon)
##	  - tested on release phpBB 2.0.6 too
##   2003-08-10 - Version 2.0.2
##	  - fixed "to to" in copy command
##   2003-08-13 - Version 2.0.4
##      - fixed problem with missing FIND after profile_view_body.tpl
##      - tested with EasyMOD alpha3 (0.0.10a)
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]-------------------------------------
#
viewtopic.php
#
#-----[ FIND ]-------------------------------------
#
		$yim_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
#
#-----[ REPLACE WITH ]-------------------------------------
#
		// MOD - YAHOO ONLINE/OFFLINE - donpedro00
		//$yim_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
     		$yim_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim_status'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
		$yim_status_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="http://opi.yahoo.com/online?u=' . $postrow[$i]['user_yim'] . '&m=g&t="' . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
		// MOD - YAHOO ONLINE/OFFLINE - donpedro00
#
#-----[ FIND ]-------------------------------------
#
		'YIM_IMG' => $yim_img,
#
#-----[ AFTER, ADD ]-------------------------------------
#
		// MOD - YAHOO ONLINE/OFFLINE - donpedro00
		'YIM_STATUS_IMG' => $yim_status_img,
		// MOD - YAHOO ONLINE/OFFLINE - donpedro00
#
#-----[ OPEN ]-------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]-------------------------------------
#
				<td valign="middle" nowrap="nowrap">{postrow.PROFILE_IMG} {postrow.PM_IMG} {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} {postrow.MSN_IMG}<script language="JavaScript" type="text/javascript"><!-- 
#
#-----[ REPLACE WITH ]-------------------------------------
#
				<!-- MOD - YAHOO ONLINE/OFFLINE - donpedro00 -->
				<td valign="middle" nowrap="nowrap">
				{postrow.PROFILE_IMG} 
				{postrow.PM_IMG} 
				{postrow.EMAIL_IMG} 
				{postrow.WWW_IMG} 
				{postrow.MSN_IMG}
				{postrow.AIM_IMG} 

					<script language="JavaScript" type="text/javascript">

						if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 )
							document.write(' {postrow.YIM_IMG}');
						else
							document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{postrow.YIM_IMG}</div><div style="position:absolute;left:32px;top:4px">{postrow.YIM_STATUS_IMG}</div></div>');
						//-->
					</script>
					{postrow.YIM_IMG} 

					<script language="JavaScript" type="text/javascript"><!-- 
				<!-- MOD - YAHOO ONLINE/OFFLINE - donpedro00 -->
#
#-----[ OPEN ]-------------------------------------
#
privmsg.php
#
#-----[ FIND ]-------------------------------------
#
	$yim_img = ( $privmsg['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $privmsg['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
#
#-----[ REPLACE WITH ]-------------------------------------
#
      // MOD - YAHOO ONLINE/OFFLINE - donpedro00
	//$yim_img = ( $privmsg['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $privmsg['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
      $yim_img = ( $privmsg['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $privmsg['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim_status'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
      $yim_status_img = ( $privmsg['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $privmsg['user_yim'] . '&amp;.src=pg"><img src="http://opi.yahoo.com/online?u=' . $privmsg['user_yim'] . '&m=g&t="' . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
      // MOD - YAHOO ONLINE/OFFLINE - donpedro00
#
#-----[ FIND ]-------------------------------------
#
		'YIM_IMG' => $yim_img,
#
#-----[ AFTER, ADD ]-------------------------------------
#
		// MOD - YAHOO ONLINE/OFFLINE - donpedro00
		'YIM_STATUS_IMG' => $yim_status_img,
		// MOD - YAHOO ONLINE/OFFLINE - donpedro00
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/privmsgs_read_body.tpl
#
#-----[ FIND ]-------------------------------------
#
			  {WWW_IMG} {AIM_IMG} {YIM_IMG} {MSN_IMG}</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><script language="JavaScript" type="text/javascript"><!-- 
#
#-----[ REPLACE WITH ]-------------------------------------
#
			  <!-- MOD - YAHOO ONLINE/OFFLINE - donpedro00 -->
			  {WWW_IMG} {AIM_IMG} {MSN_IMG}
					<script language="JavaScript" type="text/javascript">

						if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 )
							document.write(' {YIM_IMG}');
						else
							document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{YIM_IMG}</div><div style="position:absolute;left:32px;top:4px">{YIM_STATUS_IMG}</div></div>');
						//-->
					</script>
					{YIM_IMG} 
					</td><td>&nbsp;</td><td valign="top" nowrap="nowrap">
				<script language="JavaScript" type="text/javascript"><!-- 
			  <!-- MOD - YAHOO ONLINE/OFFLINE - donpedro00 -->
# 
#-----[ OPEN ]------------------------------------------ 
#
includes/usercp_viewprofile.php
# 
#-----[ FIND ]------------------------------------------ 
#
$yim_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
// MOD - YAHOO ONLINE/OFFLINE - donpedro00
//$yim_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
$yim_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim_status'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
$yim_status_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg"><img src="http://opi.yahoo.com/online?u=' . $profiledata['user_yim'] . '&m=g&t="' . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
// MOD - YAHOO ONLINE/OFFLINE - donpedro00
#
#-----[ FIND ]-------------------------------------
#
	'YIM_IMG' => $yim_img,
#
#-----[ AFTER, ADD ]-------------------------------------
#
	// MOD - YAHOO ONLINE/OFFLINE - donpedro00
	'YIM_STATUS_IMG' => $yim_status_img,
	// MOD - YAHOO ONLINE/OFFLINE - donpedro00
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]-------------------------------------
#
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_YAHOO}:</span></td>
		  <td class="row1" valign="middle"><span class="gen">{YIM_IMG}</span></td>
		</tr>
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
		<!-- MOD - YAHOO ONLINE/OFFLINE - donpedro00 -->
		<tr> 
		  <td valign="middle" nowrap="nowrap" align="right"><span class="gen">{L_YAHOO}:</span></td>
		  <td class="row1"><script language="JavaScript" type="text/javascript"><!-- 

		if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 )
			document.write(' {YIM_IMG}');
		else
			document.write('<table cellspacing="0" cellpadding="0" border="0"><tr><td nowrap="nowrap"><div style="position:relative;height:18px"><div style="position:absolute">{YIM_IMG}</div><div style="position:absolute;left:32px;top:4px">{YIM_STATUS_IMG}</div></div></td></tr></table>');
		//--></script><noscript>{YIM_IMG}</noscript></td>
		</tr>
		<!-- MOD - YAHOO ONLINE/OFFLINE - donpedro00 -->
#
#-----[ OPEN ]-------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]-------------------------------------
#
$images['icon_yim'] = "$current_template_images/{LANG}/icon_yim.gif";
#
#-----[ AFTER, ADD ]-------------------------------------
#
// MOD - YAHOO ONLINE/OFFLINE - donpedro00
$images['icon_yim_status'] = "$current_template_images/{LANG}/icon_yim_status.gif";
// MOD - YAHOO ONLINE/OFFLINE - donpedro00
# 
#-----[ COPY ]------------------------------------------ 
# 
copy icon_yim_status.gif to templates/subSilver/images/lang_english/
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
