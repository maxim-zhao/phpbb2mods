############################################################## 
## MOD Title: No flood control on edit
## MOD Author: Graham < phpbb@grahameames.co.uk > (Graham Eames) http://www.grahameames.co.uk/phpbb/
## MOD Description: This MOD removes the flood control when 
## editing posts, allowing you to have a high flood limit to
## prevent spamming whilst not restricting the ability to edit
## posts.
##
## MOD Version: 1.0.1
## 
## Installation Level: Easy 
## Installation Time: 1 Minutes 
## Files To Edit: includes/functions_post.php 
## Included Files: N/A
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
############################################################## 
## MOD History: 
## Aug 29, 2005 - Version 1.0.1
##  - Change to using IN-LINE REPLACE WITH so it works with EM
## Oct 03, 2003 - Version 1.0.0
##  - Initial Release
############################################################## 
## Author Notes: 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_post.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	if ($mode == 'newtopic' || $mode == 'reply' || $mode == 'editpost') 

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
 || $mode == 'editpost')

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
)

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 