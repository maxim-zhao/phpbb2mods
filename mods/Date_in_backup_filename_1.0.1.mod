##############################################################
## MOD Title: Date in backup filename MOD
## MOD Author: Blijbol < software@blijbol.nl > (Jeroen van der Gun) N/A
## MOD Description: This MOD automatically adds the current date to the filename of database backup files
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 1 Minute
## Files To Edit: admin/admin_db_utilities.php
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
## By default, a database backup has the filename "phpbb_db_backup.sql".
## This MOD changes it e.g. into "phpbb_backup_8_Nov_2005.sql".
## (depending on your language and the current time)
##
##############################################################
## MOD History:
##
##   2005-11-12 - Version 1.0.1
##      - Replaced spaces with underscores (thanks to MOD Team)
##
##   2005-11-08 - Version 1.0.0
##      - First release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_db_utilities.php

#
#-----[ FIND ]------------------------------------------
#
			if($do_gzip_compress)
			{

#
#-----[ BEFORE, ADD ]------------------------------------------
#
			$gendate = str_replace(' ', '_', create_date($lang['DATE_FORMAT'], time(), $board_config['board_timezone']));

#
#-----[ FIND ]------------------------------------------
#
				header("Content-Type: application/x-gzip; name=\"phpbb_db_backup.sql.gz\"");
				header("Content-disposition: attachment; filename=phpbb_db_backup.sql.gz");

#
#-----[ REPLACE WITH ]------------------------------------------
#
				header("Content-Type: application/x-gzip; name=\"phpbb_backup_$gendate.sql.gz\"");
				header("Content-disposition: attachment; filename=phpbb_backup_$gendate.sql.gz");

#
#-----[ FIND ]------------------------------------------
#
				header("Content-Type: text/x-delimtext; name=\"phpbb_db_backup.sql\"");
				header("Content-disposition: attachment; filename=phpbb_db_backup.sql");

#
#-----[ REPLACE WITH ]------------------------------------------
#
				header("Content-Type: text/x-delimtext; name=\"phpbb_backup_$gendate.sql\"");
				header("Content-disposition: attachment; filename=phpbb_backup_$gendate.sql");

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
