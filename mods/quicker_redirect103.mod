##############################################################
## MOD Title:          Quicker Redirect
## MOD Author:         glw-inc < webmaster@glw-inc.tk > (Garrett Whitehorn) http://www.glw-inc.tk
## MOD Description:    This MOD allows for quicker <meta> redirect after confirmation pages and stuff
## MOD Version:        1.0.3
## Compatibility:      tested with 2.0.6
##
## Installation Level: Easy
## Installation Time:  ~20min? (25sec by EasyMOD of Nuttzy - tested with this)
## Files To Edit:      12
##      groupcp.php
##      index.php
##      modcp.php
##      posting.php
##      privmsg.php
##      viewforum.php
##      viewtopic.php
##      includes/functions_post.php
##      includes/usercp_activate.php
##      includes/usercp_email.php
##      includes/usercp_register.php
##      includes/usercp_sendpasswd.php
##
## Included Files:     0
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##   There's not really a whole lot to say - this isn't a remake
## of someone else's mod, it's not a newer version of the same
## mod, and it's not similar to any other mod (to my knowledge).
## So just enjoy v1 of this, my first mod. Let me know (by email
## or on my site) if I missed any pages I could have changed.
##   It's real easy to edit, if you're doing it by hand, but just
## very time-consuming. I would definitely recommend EasyMOD to
## do it for you, and a whole lot quicker, at that.
##   About the MOD itself: all it does is reduce the number of
## seconds that confirmation pages wait before redirecting.
## Here is a listing of the current redirect times and what they
## will be reduced to:
## 15 seconds -> will be shortened to 10 seconds
## 10 -> 7
## 5 -> 2
## 3 -> 1
## These are all the different configurations I found while
## making the MOD. Each file will have a different configuration.
##############################################################
## MOD History:
##
##   2004-07-13 - Version 1.0.3
##      - Yet another header correction
##   2004-07-13 - Version 1.0.2
##      - Corrected header for submission to phpBB's MOD listings
##   2004-07-12 - Version 1.0.1
##      - Removed file: couldn't mod login.php: FIND FAILED
##   2004-07-11 - Version 1.0.0
##      - First incarnation
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------------
#
groupcp.php

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

#
#-----[ OPEN ]------------------------------------------------
#
index.php

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

#
#-----[ OPEN ]------------------------------------------------
#
modcp.php

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------ 
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

#
#-----[ OPEN ]------------------------------------------------
#
posting.php

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

#
#-----[ OPEN ]------------------------------------------------
#
privmsg.php

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

#
#-----[ OPEN ]------------------------------------------------
#
viewforum.php

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ OPEN ]------------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

#
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

#
#-----[ OPEN ]------------------------------------------------
#
includes/functions_post.php

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="3;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
3;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
1;

#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_activate.php

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="10;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
10;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
7;

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="10;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
10;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
7;

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="10;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
10;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
7;

#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_email.php

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="5;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
5;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
2;

#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_register.php

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="5;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
5;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
2;

#
#-----[ OPEN ]------------------------------------------------
#
includes/usercp_sendpasswd.php

# 
#-----[ FIND ]------------------------------------------------
#
'<meta http-equiv="refresh" content="15;url='

#
#-----[ IN-LINE FIND ]----------------------------------------
#
15;

#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
10;

#
#-----[ SAVE/CLOSE ALL FILES ]-------------------------------- 
#
# EoM 