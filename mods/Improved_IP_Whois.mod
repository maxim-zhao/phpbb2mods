##############################################################
## MOD Title: Improved IP Whois	
## MOD Author: TheWizard < wizard@midnightrpgs.com > (Francisco Ayala) http://www.theanimeplace.com
## MOD Description: Changes the previous IP Whois look up from network-tools to DNS Stuff
## MOD Version: 1.0.0
##
## Installation Level: (Easy)
## Installation Time: 1 Minutes
## Files To Edit: admin/index.php
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##############################################################
## MOD History:
##
##   2004-09-09 - Version 1.0.0
##      - First and Only release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ FIND ]---------------------------------------------
#
"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$reg_ip",

#
#-----[ REPLACE WITH ]---------------------------------------
#
"U_WHOIS_IP" => "http://www.dnsstuff.com/tools/whois.ch?ip=$reg_ip",

#
#-----[ FIND ]---------------------------------------------
#
"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$guest_ip",

#
#-----[ REPLACE WITH ]---------------------------------------
#
"U_WHOIS_IP" => "http://www.dnsstuff.com/tools/whois.ch?ip=$guest_ip",

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 