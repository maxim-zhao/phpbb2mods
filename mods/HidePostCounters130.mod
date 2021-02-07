##############################################################
## MOD Title:          ADMIN Posts Counters and Author's Search
## MOD Author:         3Di < 3d@you3d.za.net > (Marco) http://phpbb2italia.za.net/phpbb2/index.php
## MOD Description:	Hide the fields where the posts counter is shown.
##					(memberlist, viewtopic and viewprofile) are so now available only for the ADMIN.
##					Hides the Author's Search Field in search page, Author's search is ADMIN reserved . 
## MOD Version:        1.3.0
##
## Installation Level: (Easy) 
## Installation Time:  10 Minutes
##
## Files To Edit:
##	memberlist.php
##	search.php
##	viewtopic.php
##	includes/page_header.php
##	templates/subSilver/profile_view_body.tpl
##	templates/subSilver/search_body.tpl
##
## Included Files: (n/a)
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
##
##	Tested on a fresh 2.0.17
##
##############################################################
## MOD History:
##
##   2005-10-13 - Version 1.3.0
##		- Code re written
##		- added ADMIN privileges also in the main search.php code ;-)
##		- MOD's title changed again
##		- The MOD passed the MOD pre-validation process
##		- MOD submitted
##
##   2005-10-04 - Version 1.0.0 BETA
##		- MOD template mistmatch errors fixed
##		- Code re written
##		- MOD's title changed to better fit what it now does
##		- The MOD passed the MOD pre-validation process
##		- MOD submitted
##
##   2005-09-26 - Version 0.1.1 BETA
##		- mod submitted
##
##   2005-08-24 - Version 0.0.1 BETA
##		- first release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------
#
memberlist.php
#
#-----[ FIND ]------------------------------------------
#
		$posts = ( $row['user_posts'] ) ? $row['user_posts'] : 0;
#
#-----[ REPLACE WITH ]------------------------------------------
#
// Post Counters and Author's Search only for ADMIN mod start
	if ( $userdata['user_level'] == ADMIN ) 
		{
		$posts = ( $row['user_posts'] ) ? $row['user_posts'] : 0;
		}
// Post Counters and Author's Search only for ADMIN mod - end
#
#-----[ OPEN ]------------------------------------------
#
search.php
#
#-----[ FIND ]------------------------------------------
#
				$search_author = str_replace('*', '%', trim($search_author));
#
#-----[ AFTER, ADD ]------------------------------------------
#
// Post Counters and Author's Search only for ADMIN mod start
		if ( $userdata['user_level'] == ADMIN ) 
			{
#
#-----[ FIND ]------------------------------------------
#
					message_die(GENERAL_ERROR, "Couldn't obtain list of matching users (searching for: $search_author)", "", __LINE__, __FILE__, $sql);
				}
#
#-----[ AFTER, ADD ]------------------------------------------
#
			}
// Post Counters and Author's Search only for ADMIN mod - end
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
	$poster_posts = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $postrow[$i]['user_posts'] : '';
#
#-----[ REPLACE WITH ]------------------------------------------
#
// Post Counters and Author's Search only for ADMIN mod start
if ( $userdata['user_level'] == ADMIN ) 
	{
	$poster_posts = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $postrow[$i]['user_posts'] : '';
	}
// Post Counters and Author's Search only for ADMIN mod - end
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
$template->assign_block_vars('switch_user_logged_in', array());
#
#-----[ AFTER, ADD ]------------------------------------------
#
// Post Counters and Author's Search only for ADMIN mod start
if ( $userdata['user_level'] == ADMIN ) 
	{ 
		$template->assign_block_vars('switch_post_counters', array()); 
	}
// Post Counters and Author's Search only for ADMIN mod end

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]------------------------------------------
#
		<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_TOTAL_POSTS}:&nbsp;</span></td>
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
<!-- BEGIN switch_post_counters -->
#
#-----[ FIND ]------------------------------------------
#
		  <td valign="top"><b><span class="gen">{POSTS}</span></b><br /><span class="genmed">[{POST_PERCENT_STATS} / {POST_DAY_STATS}]</span> <br /><span class="genmed"><a href="{U_SEARCH_USER}" class="genmed">{L_SEARCH_USER_POSTS}</a></span></td>
		</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_post_counters -->
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/search_body.tpl
#
#-----[ FIND ]------------------------------------------
#	the line is longer..
	<tr>
		<td class="row1" colspan="2"><span class="gen">{L_SEARCH_AUTHOR}
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
<!-- BEGIN switch_post_counters -->
#
#-----[ FIND ]------------------------------------------
#	the line is longer..
		<td class="row2" colspan="2" valign="middle"><span class="genmed"><input type="text"
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- END switch_post_counters -->

#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM