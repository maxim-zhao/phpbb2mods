############################################################## 
## MOD Title: Email adresses with umlauts
## MOD Author: Underhill < webmaster@underhill.de > (N/A) http://www.underhill.de/
## MOD Description: Allows the use of umlauts in email adresses in new IDN-Domains (example: peter@müller.de)
## MOD Version: 1.3.4
## 
## Installation Level: easy
## Installation Time: 5 minutes
## Files To Edit:
##		includes/functions_validate.php
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
## Author Notes: 
## 
## This modification allows three additional german umlauts "ä", "ü" und "ö" in the email adress check function
## There are many more special characters (example: 203 for .com-Domains) allowed
## "ä", "ü" und "ö" are the allowed special characters for use in .info-Domain and are suitable for use in Germany
## See also http://www.iana.org/assignments/idn/info-german.html
##
## Screenshot: http://www.underhill.de/downloads/phpbb2mods/emailadresseswithumlauts.png
## Download: http://www.underhill.de/downloads/phpbb2mods/emailadresseswithumlauts.txt
############################################################## 
## MOD History: 
## 
##   2006-04-08 - Version 1.3.4 
##		- Successfully tested with phpBB 2.0.20
##		- Successfully tested with EasyMOD beta (0.3.0)
## 
##   2005-12-31 - Version 1.3.3 
##		- Successfully tested with phpBB 2.0.19
## 
##   2005-12-11 - Version 1.3.2 
##		- MOD Syntax changes for the phpBB MOD Database
##		- Successfully tested with phpBB 2.0.18
## 
##   2005-10-03 - Version 1.3.1 
##		- MOD Syntax changes for the phpBB MOD Database
## 
##   2005-10-01 - Version 1.3.0 
##		- Format changed to the phpBB MOD Template
##		- Successfully tested with phpBB 2.0.17
## 
##   2004-03-06 - Version 1.0.0 
##		- Built and successfully tested with phpBB 2.0.7
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------------------------------
#

includes/functions_validate.php

#
#-----[ FIND ]------------------------------------------------------------------
#

		if (preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is', $email))

#
#-----[ IN-LINE FIND ]----------------------------------------------------------
#

+@[a-z0-9\-

#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------------------
#

äöü

#
#-----[ IN-LINE FIND ]----------------------------------------------------------
#

+\.([a-z0-9\-

#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------------------
#

äöü

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------------------------
#
#
# EoM
