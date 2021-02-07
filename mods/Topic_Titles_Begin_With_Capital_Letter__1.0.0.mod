##############################################################
## MOD Title: Topic Titles Begin With Capital Letter
## MOD Author: battye < cricketmx@hotmail.com > (N/A) http://www.cricketmx.com
## MOD Description: A simple MOD which makes the viewforum page look cleaner, by forcing all topic titles to begin with a capital
## letter. This is also done on the viewtopic page. Even if the user submits the topic with a lower case letter beginning the topic
## name, the MOD will automatically make this a capital.
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minutes
##
## Files To Edit (6): 	viewforum.php
##							viewtopic.php
##
## Included Files (0): 	
##
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes: No SQL changes required
## A screenshot can be found at http://www.cmxmods.net/mods/ucstr100.PNG
############################################################## 
## MOD History: 	2005-07-25 - Version 1.0.0
##     						 - First release
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
viewforum.php

#
#-----[ FIND ]------------------------------------------
#
			'TOPIC_TITLE' => $topic_title,

#
#-----[ REPLACE WITH ]------------------------------------------
#
			'TOPIC_TITLE' => ucfirst($topic_title),

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
    'TOPIC_TITLE' => $topic_title,

#
#-----[ REPLACE WITH ]------------------------------------------
#
    'TOPIC_TITLE' => ucfirst($topic_title),

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM