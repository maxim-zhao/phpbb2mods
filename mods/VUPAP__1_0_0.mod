##############################################################
## MOD Title: View Unread Posts As Posts (VUPAP)
## MOD Author: psouza4 < psouza@role-players.com > (Peter Souza IV) http://www.role-players.com/
## MOD Description: This mod tweaks how unread posts are displayed when using the 'View Unread Posts' link
## MOD Version: 1.0.0
##
## Installation Level: (easy)
## Installation Time: ~1 Minute
## Files To Edit: search.php
## Included Files: (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##   This mod will simply change the default sort for new posts (when clicking
##   the 'View Unread Posts' link from the forum index) to show posts in the
##   order that they were posted.  Also, each post is displayed as their own
##   entry in the list instead of consolodating into threads.  We like individual
##   posts when seeing how many total posts we haven't yet read.  This version works
##   with phpBB version 2.0.8, but should also work with 2.0.6 and 2.0.7 -- possibly
##   with all 2.0.x versions.
##############################################################
## MOD History:
##   2004/04/02  PS  Initial mod creation, version 1.0.0
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
search.php

#
#-----[ FIND ]------------------------------------------
#
			$show_results = 'topics';
			$sort_by = 0;
			$sort_dir = 'DESC';
#
#-----[ REPLACE WITH ]------------------------------------------
#
//-- mod : 'View Unread Posts As Posts', in order by oldest unread post-----------------------------
//-- delete
//			$show_results = 'topics';
//			$sort_by = 0;
//			$sort_dir = 'DESC';
//-- add
				$show_results = 'posts';
				$sort_by = 0;
				$sort_dir = 'ASC';
//-- fin mod : 'View Unread Posts As Posts', in order by oldest unread post-------------------------

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
