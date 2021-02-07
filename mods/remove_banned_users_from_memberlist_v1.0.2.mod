##############################################################
## MOD Title: Remove Banned Users From Memberlist
## MOD Author: alexi02 < N/A > (Alejandro Iannuzzi) http://www.uzzisoft.com
## MOD Description: Removes banned users from being displayed on the memberlist
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: memberlist.php
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
##      Can't get any simpler than this.
##
##############################################################
## MOD History:
##
##  2006-11-05 - Version 1.0.2
##      - Bug Fix: Pagination wasn't displayed correctly (it was counting the banned users)
##
##  2006-09-19 - Version 1.0.1
##      - Changed REPLACE WITH to INLINE FIND/ADD for those who have other memberlist mods installed
##
##  2006-09-19 - Version 1.0.0
##      - Initial Release (for phpBB 2.0.21)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
# 

memberlist.php 

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT username, user_id, user_viewemail, user_posts, user_regdate, user_from, user_website, user_email, user_icq, user_aim, user_yim, user_msnm, user_avatar, user_avatar_type, user_allowavatar

#
#-----[ IN-LINE FIND ]------------------------------------------
#

username

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_id

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_viewemail

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_posts

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_regdate

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_from

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_website

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_email

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_icq

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_aim

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_yim

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_msnm

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_avatar

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_allowavatar

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

, b.ban_userid

#
#-----[ FIND ]------------------------------------------
#

FROM " . USERS_TABLE . "

#
#-----[ IN-LINE FIND ]------------------------------------------
#

FROM " . USERS_TABLE . "

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

 u LEFT JOIN " . BANLIST_TABLE . " b ON u.user_id = b.ban_userid

#
#-----[ FIND ]------------------------------------------
#

WHERE user_id <> " . ANONYMOUS . "

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_id <> " . ANONYMOUS . "

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

 AND ISNULL( b.ban_userid )

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT count(*) AS total
                FROM " . USERS_TABLE . "
#
#-----[ IN-LINE FIND ]------------------------------------------
#

FROM " . USERS_TABLE . "

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

 u LEFT JOIN " . BANLIST_TABLE . " b ON u.user_id = b.ban_userid

#
#-----[ FIND ]------------------------------------------
#

WHERE user_id <> " . ANONYMOUS

#
#-----[ IN-LINE FIND ]------------------------------------------
#

user_id <> " . ANONYMOUS

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#

u.

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#

 . " AND ISNULL( b.ban_userid )"

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM