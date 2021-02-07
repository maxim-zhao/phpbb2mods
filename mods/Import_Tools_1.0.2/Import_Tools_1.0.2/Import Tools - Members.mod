############################################################## 
## MOD Title: Import Tools - Members
## MOD Author: Graham < phpbb@grahameames.co.uk > (Graham Eames) http://www.grahameames.co.uk/phpbb/
## MOD Description: This MOD will import a list of members held
##    in a CSV file and create user accounts for each of those members
##    on the forum.
##
## MOD Version: 1.0.2
## 
## Installation Level: Easy 
## Installation Time: 3 Minutes
## Files To Edit:
##    language/lang_english/lang_admin.php
## Included Files: 
##    admin_import_members.php
##    import_members_settings.tpl
##    import_message_body.tpl
##    lang_import.php
##    functions_mod_user.php
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
##    The CSV file should be formatted as follows:
##    username, email, password
##    Password can either be provided in plain text, or as an MD5
##    hash, just select the appropriate option on the initial screen.
##
##    Additional information can be included in the CSV file and
##    imported by altering the relevant lines in the script.
##    For further information please post in the relevant thread at
##    phpBB.com.
##
############################################################## 
## MOD History:
## Sep 30, 2006 - Version 1.0.2
##  - Updated to latest version of insert_user code
## Apr 29, 2005 - Version 1.0.1
##  - Submitted to MOD DB
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy admin_import_members.php to admin/admin_import_members.php 
copy import_members_settings.tpl to templates/subSilver/admin/import_members_settings.tpl 
copy import_message_body.tpl to templates/subSilver/admin/import_message_body.tpl 
copy lang_import.php to language/lang_english/lang_import.php
copy functions_mod_user.php to includes/functions_mod_user.php

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Restore_DB'] = 'Restore Database';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// Import Tools Menu Entries
$lang['Import_Tools'] = 'Import Tools';
$lang['Members'] = 'Members';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
