############################################################## 
## MOD Title: SQL Backup
## MOD Author: Vic D'Elfant < vic@phpbb.com > (Vic D'Elfant) http://www.coronis.nl 
## MOD Description: This MOD will add an additional module to the Administration Panel
##                  which will allow you to backup your phpBB database without having
##                  to worry about the "Maximum execution time reached" errors, which
##                  normally would prevent you from creating a full database of a
##                  large forum.
## MOD Version: 1.0.12
## 
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit:  language/lang_english/lang_admin.php
## Included Files: root/admin/admin_backup.php
##                 root/admin/backups/.htaccess
##                 root/admin/backups/index.htm
##                 root/includes/functions_backup.php
##                 root/includes/functions_compress.php
##                 root/includes/xml.php
##                 root/templates/subSilver/admin/backup_body.tpl
##                 root/templates/subSilver/admin/backup_progress.tpl
##                 root/templates/subSilver/admin/backup_list_body.tpl
##
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
##
############################################################## 
## MOD History: 
## 
##   2006-01-06 - Version 1.0
##      - First public release
##
##   2006-01-06 - Version 1.0.1
##      - Fixed minor issue with the .mod file
##      - Changed functions_backup.php to use mysql_escape_string()
##        instead of addslashes()
##
##   2006-01-19 - Version 1.0.2
##      - Modified script file to use $phpEx instead of .php
##
##   2006-01-31 - Version 1.0.3
##      - Fixed bug with selecting non-phpbb tables
##      - Added "Check all tables" button
##
##   2006-02-15 - Version 1.0.4
##      - Fixed problem which caused the backup process to fail if a table
##        didn't contain a primary key
##      - Updated Content-Type for downloading zipfiles in admin_backup.php
##
##   2006-02-23 - Version 1.0.5
##      - Back-ported Olympus' compression class which adds 4 alternative
##        compression methods (.tar, .tgz, .tar.gz, .tar.bz2)
##
##   2006-02-23 - Version 1.0.6
##      - Updated tar compression methods
##
##   2006-02-24 - Version 1.0.7
##      - Updated both zip and tar compression methods
##
##   2006-03-25 - Version 1.0.8
##      - Added 'none' compression method, which will cause the MOD to write the
##        entire backup to a single .sql file
##      - MOD now exports tables in chunks of ~15 MB each, and compresses those chunks
##      - Backup process is considerably faster now
##      - Improved error checking during the backup process
##
##   2006-04-10 - Version 1.0.9
##      - Improved error checking, as suggested by TerraFrost
##      - Fixed problem with database names that contained capitals
##      - Fixed problem with compression when register_globals was enabled - da_badtz_one
##      - Added confirmation dialog when deleting a backup
##      - Backups will now be sorted from old to new at the 'Download backups' page
##
##   2006-04-10 - Version 1.0.10
##      - Fixed problem with .tar.gz and .tar.bz2 compression
##
##   2006-04-17 - Version 1.0.11
##      - Fixed issue which caused a number of lines to be missing in the backup file
##      - Added German translation - thanks to "Evil<3"
##
##   2007-04-12 - Version 1.0.12
##      - Fixed compatibility issue with register_long_arrays set to Off
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ COPY ]------------------------------------------
#
copy root/admin/admin_backup.php to admin/admin_backup.php
copy root/admin/backups/.htaccess to admin/backups/.htaccess
copy root/admin/backups/index.htm to admin/backups/index.htm
copy root/includes/*.* to includes/*.*
copy root/templates/subSilver/admin/*.* to templates/subSilver/admin/*.*

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// SQL Backup
//
$lang['SQL_Backup'] = 'SQL Backup';
$lang['SQL_Download'] = 'Download Backups';
$lang['SB_title'] = 'SQL Backup';
$lang['SB_compression'] = 'Compression method';
$lang['SB_compression_th'] = 'Select compression method';
$lang['SB_explain'] = 'You\'ll see a list with all table names which start with your phpBB table prefix below. The default phpBB tables have been checked already, but in case you installed MODs which created additional tables you might want to select those as well. All tables which have been checked will be included in the backup.<br /><br />The table names mentioned in bold do not belong to a standard phpBB installation and will be left out of the backup unless you place a check in front of them.';
$lang['SB_unwritable'] = 'Cannot write to the /admin/backups folder.<br />Make sure that the folder exists and that it has been CHMODed to 777';
$lang['SB_incompatible'] = 'The SQL Backup MOD is not compatible with the database type your board is using';
$lang['SB_download_title'] = 'Download backups';
$lang['SB_download_explain'] = 'Previously created backups are listed below. To download a backup to your local computer, select "Download" next to the backup which you want to download. In order to delete a backup from your server, click "Delete".';
$lang['SB_download_th_title'] = 'Previously created backups';
$lang['SB_download_datetime'] = 'Date - time';
$lang['SB_download_size'] = 'Size';
$lang['SB_download_action'] = 'Action';
$lang['SB_no_backups'] = 'No backups found';
$lang['SB_deleted'] = 'Backup file has successfully been removed<br /><br />Click %shere%s to return to the SQL Backup module';
$lang['SB_failed_deleting'] = 'Failed deleting %s';
$lang['SB_tasks_file_failed'] = 'Could not load tasks file';
$lang['SB_sql_file_failed'] = 'Could not create handle for SQL backup file';
$lang['SB_body_th'] = 'Create database backup';
$lang['SB_create'] = 'Create backup';
$lang['SB_select_all'] = 'Select all tables';
$lang['SB_deselect_all'] = 'Deselect all tables';
$lang['SB_creating_zipfile'] = 'Creating backup file...';
$lang['SB_processing_th'] = 'Creating backup';
$lang['SB_processing_title'] = 'The backup is being created, please be patient...';
$lang['SB_processing_explain'] = 'Do <b><u>not</u></b> close this window until the backup process has been completed';
$lang['SB_finished_msg'] = 'Backup successfully created!<br /><br />You may download it by clicking %shere%s';
$lang['SB_error_request'] = 'Could not make HTTP request to the server';
$lang['SB_error_parse'] = 'An error occured while parsing the data sent by the server. Click OK to try again, or Cancel to cancel the backup process. The data returned by server the server is as follows:';
$lang['SB_confirm_backup_delete'] = 'Are you sure you want to delete this backup file?';

#
#-----[ DIY INSTRUCTIONS ]----------------------------------------
#
IIS users: the /admin/backups/ folder is protected using a .htaccess file, which probably won't work on IIS. You will have to make sure that this directory cannot be accessed by visitors of your website

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM


