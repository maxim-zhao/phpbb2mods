##############################################################
## MOD Title: Auto-prune Polls
## MOD Author: ggbbguy < N/A > (N/A) N/A
## MOD Description: Allows topics with polls to be auto-pruned
##                  including poll data removal from the database.
## MOD Version: 1.0.0
##
##
## Installation Level: Easy
## Installation Time: 1 minute
## Files To Edit: includes/prune.php
## Included Files: None
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
##   Allows topics with polls to be automatically pruned, and
##   also removes associated data in vote_desc, vote_results,
##   and vote_voters tables.
##
##   Extremely minimal testing has been done, but so far no
##   problems.
##
##   WARNING: This MOD will affect all pruning operations, whether
##   via the Auto-pruning feature or manually via Forum Prune.
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

includes/prune.php

#
#-----[ FIND ]------------------------------------------
#

	$prune_all = ($prune_all) ? '' : 'AND t.topic_vote = 0 AND t.topic_type <> ' . POST_ANNOUNCE;
	//
	// Those without polls and announcements ... unless told otherwise!
	//

#
#-----[ REPLACE WITH ]------------------------------------------
#

	$prune_all = ($prune_all) ? '' : 'AND t.topic_type <> ' . POST_ANNOUNCE;
	//
	// Those without announcements ... unless told otherwise!  POLLS INCLUDED!
	//

#
#-----[ FIND ]------------------------------------------
#

	if( $sql_topics != '' )
	{

#
#-----[ AFTER, ADD ]------------------------------------------
#

		/**************************
		 * Auto-prune polls BEGIN *
		 **************************/
		$sql = "SELECT vote_id
			FROM " . VOTE_DESC_TABLE . "
			WHERE topic_id IN ($sql_topics)";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain list of polls to prune', '', __LINE__, __FILE__, $sql);
		}

		$sql_polls = '';
		while ( $row = $db->sql_fetchrow($result) )
		{
			$sql_polls .= ( ( $sql_polls != '' ) ? ', ' : '' ) . $row['vote_id'];
		}
		$db->sql_freeresult($result);

		if ( $sql_polls != '' )
		{
			$sql = "DELETE FROM " . VOTE_DESC_TABLE . "
				WHERE vote_id IN ($sql_polls)";
			if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not delete polls during prune', '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . VOTE_RESULTS_TABLE . "
				WHERE vote_id IN ($sql_polls)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete poll results during prune', '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . VOTE_USERS_TABLE . "
				WHERE vote_id IN ($sql_polls)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete poll voters during prune', '', __LINE__, __FILE__, $sql);
			}
		}
		/************************
		 * Auto-prune polls END *
		 ************************/

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
