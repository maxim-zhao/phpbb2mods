############################################################## 
## MOD Title: Advanced IP Results
## MOD Author: dESiLVer < desilverx@gmail.com > (Kemal Guner) http://x-play.bbg-servers.com
## MOD Description: Advanced detailed IP search results.
## MOD Version: 1.0.0 
## 
## Installation Level: (Easy) 
## Installation Time: 1 Minutes 
## Files To Edit: admin/index.php 
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: My first mod ;)
## 
############################################################## 
## MOD History: 
## 
##   2005-05-31 - Version 1.0.0
##      - First release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------ 
# 
admin/index.php
# 
#-----[ FIND ]----------------------------------- 
# 

"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$reg_ip",

# 
#-----[ REPLACE WITH ]------------------------------------------- 
#

"U_WHOIS_IP" => "http://www.ripe.net/whois?form_type=simple&full_query_string=&searchtext=$reg_ip", 

# 
# 
#-----[ FIND ]----------------------------------- 
# 

"U_WHOIS_IP" => "http://network-tools.com/default.asp?host=$guest_ip", 

# 
#-----[ REPLACE WITH ]------------------------------------------- 
# 

"U_WHOIS_IP" => "http://www.ripe.net/whois?form_type=simple&full_query_string=&searchtext=$guest_ip",

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM
