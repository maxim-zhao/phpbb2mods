############################################################## 
## MOD Title: Clean phpBB SQL Tables
## MOD Author: Vic D'Elfant < vic@phpbb.com > (Vic D'Elfant) http://www.coronis.nl 
## MOD Description: Originally designed to clean your database prior to re-installing
##                  phpBB, this tool allows you to remove all SQL tables, fields and
##                  configuration settings which do not belong to a so-called "vanilla"
##                  phpBB installation. This tool is particularly useful if you want
##                  to remove all tables/fields which have been created by MODs if
##                  you want to start all over again, or to remove a specific MOD.
## MOD Version: 1.0.9
## 
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: n/a
## Included Files: install/clean_tables.php
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
##   - Note that this script only works with MySQL databases
##   - You should remove the file as soon cleaned your database,
##     in order to avoid abuse of it
##
############################################################## 
## MOD History: 
## 
##   2005-05-28 - Version 1.0.0
##      - First stable release
##
##   2005-05-28 - Version 1.0.1
##      - Fixed minor bug in .mod file
##      - Fixed $lang problem in clean_tables.php
##
##   2005-12-03 - Version 1.0.2
##      - Adding phpbb_sessions_keys table
##      - Added new feature which also checks the phpbb_config table
##        for unknown configuration settings
##
##   2005-12-04 - Version 1.0.3
##      - Updated MOD template
##      - Made a few minor changes to the script file
##
##   2005-12-11 - Version 1.0.4
##      - Fixed minor issue with the script
##
##   2005-12-24 - Version 1.0.5
##      - Fixed potential security issue with the script
##
##   2005-12-30 - Version 1.0.6
##      - Updated for phpBB 2.0.19
##
##   2006-05-08 - Version 1.0.7
##      - Updated for phpBB 2.0.20
##
##   2006-08-22 - Version 1.0.8
##      - Updated for phpBB 2.0.21
##
##   2006-12-10 - Version 1.0.9
##      - Fixed problem that occured on hosts that had short_tags set to Off
##      - Fixed issue with the logo image - it was pointing to a non-existing url
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ COPY ]------------------------------------------
#
copy install/cellpic1.gif to install/cellpic1.gif
copy install/cellpic3.gif to install/cellpic3.gif
copy install/clean_tables.php to install/clean_tables.php
copy install/formIE.css to install/formIE.css
copy install/logo.jpg to install/logo.jpg
copy install/subSilver.css to install/subSilver.css
copy install/index.htm to install/index.htm

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
After having 'installed' this MOD, simply point your browser to the clean_tables.php script (e.g. http://www.domain.com/forum/install/clean_tables.php)

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM


