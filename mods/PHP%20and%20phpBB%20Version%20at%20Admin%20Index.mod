##############################################################
## MOD Title: PHP and phpBB Version at Admin Index
## MOD Author: Blijbol < software@blijbol.nl > (Jeroen van der Gun) N/A
## MOD Description: This MOD adds the PHP version and the phpBB version to the statistics table at the Admin Index.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit (3): language/lang_english/lang_admin.php
##                    admin/index.php
##                    templates/subSilver/admin/index_body.tpl
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
## This MOD adds the PHP version and the phpBB version to the statistics table at the Admin Index.
##
##############################################################
## MOD History:
##
##   2005-11-11 - Version 1.0.0
##      - First release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
# Remember to do this for all your installed languages
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Not_available'] = 'Not available';

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['phpBB_version'] = 'phpBB version';
$lang['PHP_version'] = 'PHP version';

#
#-----[ OPEN ]------------------------------------------
#
admin/index.php

#
#-----[ FIND ]------------------------------------------
#
		"L_GZIP_COMPRESSION" => $lang['Gzip_compression'])

#
#-----[ REPLACE WITH ]------------------------------------------
#
		"L_GZIP_COMPRESSION" => $lang['Gzip_compression'],
		"L_PHPBB_VERSION" => $lang['phpBB_version'],
		"L_PHP_VERSION" => $lang['PHP_version'])

#
#-----[ FIND ]------------------------------------------
#
		"GZIP_COMPRESSION" => ( $board_config['gzip_compress'] ) ? $lang['ON'] : $lang['OFF'])

#
#-----[ REPLACE WITH ]------------------------------------------
#
		"GZIP_COMPRESSION" => ( $board_config['gzip_compress'] ) ? $lang['ON'] : $lang['OFF'],
		"PHP_VERSION" => phpversion(),
		"PHPBB_VERSION" => '2' . $board_config['version'])

#
#-----[ OPEN ]------------------------------------------
#
# Remember to do this for all your installed templates
#
templates/subSilver/admin/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#
  <tr>
	<td class="row1" nowrap="nowrap">{L_DB_SIZE}:</td>
	<td class="row2"><b>{DB_SIZE}</b></td>
	<td class="row1" nowrap="nowrap">{L_GZIP_COMPRESSION}:</td>
	<td class="row2"><b>{GZIP_COMPRESSION}</b></td>
  </tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#
  <tr>
	<td class="row1" nowrap="nowrap">{L_DB_SIZE}:</td>
	<td class="row2"><b>{DB_SIZE}</b></td>
	<td class="row1" nowrap="nowrap">{L_PHPBB_VERSION}:</td>
	<td class="row2"><b>{PHPBB_VERSION}</b></td>
  </tr>
  <tr>
	<td class="row1" nowrap="nowrap">{L_GZIP_COMPRESSION}:</td>
	<td class="row2"><b>{GZIP_COMPRESSION}</b></td>
	<td class="row1" nowrap="nowrap">{L_PHP_VERSION}:</td>
	<td class="row2"><b>{PHP_VERSION}</b></td>
  </tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
