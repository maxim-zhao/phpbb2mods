##############################################################
## MOD Title: phpBB Jabber Support (XMPP URI)
## MOD Author: ptlis < ptlis@ptlis.com > (Brian Ridley) http://www.ptlis.com
## MOD Description: Modifies the phpBB Jabber Support mod to use the XMPP URI
## MOD Version: 1.1.0
##
## Installation Level: (Beginner)
## Installation Time: 2 Minutes
## Files To Edit: viewtopic.php
##                includes/usercp_viewprofile.php 
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
##     As with the phpBB Jabber MOD, this has been tested with phpBB 2.0.10 -
##     2.0.17 only, although I would imagine it should install sucessfully on
##     previous and/or future revisions of the 2.0.xx release.
##
##     This modification is Free software; you can redistribute it and/or
##     modify it under the terms of the GNU General Public License as published
##     by the Free Software Foundation; either version 2 of the License, or (at
##     your option) any later version.
##
##     http://www.fsf.org/licensing/licenses/gpl.html
##############################################################
## MOD History:
##
##   2005-08-23 - Version 1.0.0
##      - Initial addition of this mod to the /contrib/ section of the phpBB
##            Jabber MOD
##
##   2006-04-10 - Version 1.1.0
##      - Synced with the changes made to phpBB and the main Jabber MOD
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------------
#
privmsgs.php
#
#-----[ FIND ]------------------------------------------------
#
$jabber_img = ( $privmsg['user_jabber'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '';
#
#-----[ REPLACE WITH ]----------------------------------------
#
$jabber_img = ( $privmsg['user_jabber'] ) ? '<a href=""xmpp:' . $privmsg['user_jabber'] . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '';


#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------------
#
$jabber_img = ( $profiledata['user_jabber'] ) ? $profiledata['user_jabber'] : '&nbsp;';
#
#-----[ REPLACE WITH ]----------------------------------------
#
$jabber_img = ( $profiledata['user_jabber'] ) ? '<a href="xmpp:' . $profiledata['user_jabber'] . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '&nbsp;';
#
#-----[ OPEN ]------------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------------
#
$jabber_img = ( $postrow[$i]['user_jabber'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '';
#
#-----[ REPLACE WITH ]----------------------------------------
#
$jabber_img = ( $postrow[$i]['user_jabber'] ) ? '<a href="xmpp:' . $postrow[$i]['user_jabber'] . '"><img src="' . $images['icon_jabber'] . '" alt="' . $lang['JABBER'] . '" title="' . $lang['JABBER'] . '" border="0" /></a>' : '';
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM