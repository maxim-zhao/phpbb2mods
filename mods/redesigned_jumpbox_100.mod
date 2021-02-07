############################################################## 
## MOD Title: Redesigned Jumpbox 
## MOD Author: Bij < bee.veer@gmail.com > (Bas Veerman) http://www.phpbbmods.nl/
## MOD Description: This little mod redesigns the jumpbox, 
##                  and uses the HTML 4.0 optgroup tag. 
##                  This saves some of the jumpbox length 
##                  and makes category names unselectable. 
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: 3 minutes 
## Files To Edit: includes/functions.php 
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
## Author Notes: Please be carefull when installing this mod, 
## else you will be likely to create errors. 
## 
## When using some of the templates created by Cyberalien, you 
## don't need to install this. The template redesigns the jumpbox 
## when eXtreme Styles is installed too. 
############################################################## 
## MOD History: 
## 
##   2005-11-10 - Version 1.0.0 
## 
## This is the first stable version. Removed spaces and added optgroup.
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
               $boxstring .= '<option value="-1">&nbsp;</option>'; 
               $boxstring .= '<option value="-1">' . $category_rows[$i]['cat_title'] . '</option>'; 
               $boxstring .= '<option value="-1">----------------</option>'; 
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
               $boxstring .= '<optgroup label="' . $category_rows[$i]['cat_title'] . '">'; 
# 
#-----[ FIND ]------------------------------------------ 
# 
               $boxstring .= $boxstring_forums; 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
               $boxstring .= '</optgroup>'; 
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM