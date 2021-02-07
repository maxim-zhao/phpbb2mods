##############################################################
## MOD Title: Backup All Tables
## MOD Author: DaveMiller < phpbb_mods@melgir.net > (David E. Miller) http://www.melgir.net/
## MOD Description: Backup all tables in database named with $table_prefix
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
## Author Notes: This MOD is intended to include all tables which start 
## with $table_prefix in the backup download. This is for any instances of 
## phpBB2 which have added extra tables and want them included without needing 
## to hardcode the table names in the code.
## It has only been tested against versions of MySQL.
##
##############################################################
## MOD History:
##
##   2005-10-30 - Version 1.0.0
##      - created as MOD
##   2005-11-09 - Version 1.0.1
##      - revised for submission
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
			$tables = array('auth_access', 'banlist', 'categories', 'config', 'disallow', 'forums', 'forum_prune', 'groups', 'posts', 'posts_text', 'privmsgs', 'privmsgs_text', 'ranks', 'search_results', 'search_wordlist', 'search_wordmatch', 'sessions', 'smilies', 'themes', 'themes_name', 'topics', 'topics_watch', 'user_group', 'users', 'vote_desc', 'vote_results', 'vote_voters', 'words', 'confirm');
#
#-----[ AFTER, ADD ]------------------------------------------
#
			$sql = "SHOW TABLES LIKE '{$table_prefix}%'";
			$result = $db->sql_query($sql);
			if ( !$result )
			{
				message_die(GENERAL_ERROR, "Error listing table names", "", __LINE__, __FILE__, $sql);
			}
			else
			{
				$tables = array();
				$prefix_length = strlen($table_prefix);
				while ( ($row=$db->sql_fetchrow($result)) )
				{
					// Not all sql engines return key named '0'
					$keys = array_keys($row);
					$key0 = is_array($keys) ? $keys[0] : 0;
					$tbl = $row[$key0];
					if ( strlen($tbl) > $prefix_length )
					{	
						$tables[] = substr($tbl,$prefix_length);
					}
				}
			}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM