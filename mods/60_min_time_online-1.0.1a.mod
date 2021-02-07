##############################################################
## MOD Title: 60 Minute Time Online
## MOD Author: Rambo4104 < Admin@thesaltinez.com > (Ryan Smith) http://www.thesaltinez.com/
## MOD Description:  Extends the ammount of time users are listed
##			   online from 5 minutes to 60 minutes.
## MOD Version: 1.0.1
##
## Installation Level: (Easy)
## Installation Time: 3 Minutes
## Files To Edit:
## Included Files: (N/A)
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
##		Nothing special, but helpful nontheless.
##
##############################################################
## MOD History:
##   01-21-2007 - Version 1.0.1
##      - Initial release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]----------------------------------
#

viewonline.php

#
#-----[ FIND ]----------------------------------
#

AND s.session_time >= ".( time() - 300 ) . "

#
#-----[ REPLACE WITH ]--------------------------
#

AND s.session_time >= ".( time() - 3600 ) . "

#
#-----[ OPEN ]----------------------------------
#

includes/page_header.php

#
#-----[ FIND ]----------------------------------
#

AND s.session_time >= ".( time() - 300 ) . "

#
#-----[ REPLACE WITH ]--------------------------
#

AND s.session_time >= ".( time() - 3600 ) . "

#
#-----[ OPEN ]----------------------------------
#

admin/index.php

#
#-----[ FIND ]----------------------------------
#

AND s.session_time >= " . ( time() - 300 ) . "

##-----[ REPLACE WITH ]--------------------------
#

AND s.session_time >= " . ( time() - 3600 ) . "

#
#-----[ FIND ]----------------------------------
#

AND session_time >= " . ( time() - 300 ) . "

#
#-----[ REPLACE WITH ]--------------------------
#

AND session_time >= " . ( time() - 3600 ) . "

#
#-----[ OPEN ]----------------------------------
#

language/lang_english/lang_main.php

#
#-----[ FIND ]----------------------------------
#

$lang['Online_explain'] = 'This data is based on users active over the past five minutes';

#
#-----[ IN-LINE FIND ]----------------------------------
#

five

#
#-----[ IN-LINE REPLACE WITH ]--------------------------
#

sixty

#
#-----[ SAVE/CLOSE ALL FILES ]------------------
#
# EoM
