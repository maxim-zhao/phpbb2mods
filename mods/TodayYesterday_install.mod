############################################################## 
## MOD Title: Today At/Yesterday At
## MOD Author: netclectic < adrian@netclectic.com > (Adrian Cockburn) http://www.netclectic.com 
## MOD Description: Will show Today At if the post was posted today 
##                  Will show Yesterday At if the post was posted yesterday
##
## MOD Version: 1.3.1
## 
## Installation Level: easy
## Installation Time: 10 Minutes 
## Files To Edit: (6) page_header.php, index.php, search.php, viewforum.php, viewtopic.php, lang_main.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##
##  Original Author: blulegend
##  Update by netclectic to work on 2.0.4 & 2.0.6
## 
############################################################## 
## MOD History:
##
##  2003-12-15 - v1.3.1
##      - no change: confirmed as 2.0.6 compatible
##  2003-06-10 - v1.3.0
##      - updated for 2.0.4
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------
# 
includes/page_header.php 

# 
#-----[ FIND ]------------------------------------------ 
#  
//
// Parse and show the overall header.
//

#
#-----[ BEFORE, ADD ]-----------------------------------
# 
//
// MOD - TODAY AT - BEGIN
// PARSE DATEFORMAT TO GET TIME FORMAT 
//
$time_reg = '([gh][[:punct:][:space:]]{1,2}[i][[:punct:][:space:]]{0,2}[a]?[[:punct:][:space:]]{0,2}[S]?)';
eregi($time_reg, $board_config['default_dateformat'], $regs);
$board_config['default_timeformat'] = $regs[1];
unset($time_reg);
unset($regs);

//
// GET THE TIME TODAY AND YESTERDAY
//
$today_ary = explode('|', create_date('m|d|Y', time(),$board_config['board_timezone']));
$board_config['time_today'] = gmmktime(0 - $board_config['board_timezone'] - $board_config['dstime'],0,0,$today_ary[0],$today_ary[1],$today_ary[2]);
$board_config['time_yesterday'] = $board_config['time_today'] - 86400;
unset($today_ary);
// MOD - TODAY AT - END

#
#-----[ OPEN ]------------------------------
# 
index.php 

#
#-----[ FIND ]-----------------------------------
# 
$last_post = $last_post_time . '<br />';

#
#-----[ REPLACE WITH ]-----------------------------------
# 

								// OLD
								// $last_post = $last_post_time . '<br />';
								//
                                // MOD - TODAY AT - BEGIN
								//
								if ( $board_config['time_today'] < $forum_data[$j]['post_time'])
								{ 
									$last_post = sprintf($lang['Today_at'], create_date($board_config['default_timeformat'], $forum_data[$j]['post_time'], $board_config['board_timezone'])) . '<br />'; 
								}
								else if ( $board_config['time_yesterday'] < $forum_data[$j]['post_time'])
								{ 
									$last_post = sprintf($lang['Yesterday_at'], create_date($board_config['default_timeformat'], $forum_data[$j]['post_time'], $board_config['board_timezone'])) . '<br />'; 
								}
								else
								{ 
									$last_post = $last_post_time . '<br />'; 
								} 
                                // MOD - TODAY AT - END

#
#-----[ OPEN ]------------------------------
# 
search.php

#
#-----[ FIND ]-----------------------------------
# 
$post_date = create_date($board_config['default_dateformat'], $searchset[$i]['post_time'], $board_config['board_timezone']);

#
#-----[ AFTER, ADD ]-----------------------------------
# 

			//
            // MOD - TODAY AT - BEGIN
			//
			if ( $board_config['time_today'] < $searchset[$i]['post_time'])
			{ 
				$post_date = sprintf($lang['Today_at'], create_date($board_config['default_timeformat'], $searchset[$i]['post_time'], $board_config['board_timezone'])); 
			}
			else if ( $board_config['time_yesterday'] < $searchset[$i]['post_time'])
			{ 
				$post_date = sprintf($lang['Yesterday_at'], create_date($board_config['default_timeformat'], $searchset[$i]['post_time'], $board_config['board_timezone'])); 
			}
            // MOD - TODAY AT - END

#
#-----[ FIND ]-----------------------------------
# 
$last_post_time = create_date($board_config['default_dateformat'], $searchset[$i]['post_time'], $board_config['board_timezone']);

#
#-----[ AFTER, ADD ]-----------------------------------
# 

				//
                // MOD - TODAY AT - BEGIN
				//
				if ( $board_config['time_today'] < $searchset[$i]['post_time'])
				{ 
					$last_post_time = sprintf($lang['Today_at'], create_date($board_config['default_timeformat'], $searchset[$i]['post_time'], $board_config['board_timezone'])); 
				}
				else if ( $board_config['time_yesterday'] < $searchset[$i]['post_time'])
				{ 
					$last_post_time = sprintf($lang['Yesterday_at'], create_date($board_config['default_timeformat'], $searchset[$i]['post_time'], $board_config['board_timezone'])); 
				}
                // MOD - TODAY AT - END

#
#-----[ OPEN ]------------------------------
# 
viewforum.php 

#
#-----[ FIND ]-----------------------------------
# 
$last_post_time = create_date($board_config['default_dateformat'], $topic_rowset[$i]['post_time'], $board_config['board_timezone']);

#
#-----[ AFTER, ADD ]-----------------------------------
# 

		//
        // MOD - TODAY AT - BEGIN
		//
		if ( $board_config['time_today'] < $topic_rowset[$i]['post_time'])
		{ 
			$last_post_time = sprintf($lang['Today_at'], create_date($board_config['default_timeformat'], $topic_rowset[$i]['post_time'], $board_config['board_timezone'])); 
		}
		else if ( $board_config['time_yesterday'] < $topic_rowset[$i]['post_time'])
		{ 
			$last_post_time = sprintf($lang['Yesterday_at'], create_date($board_config['default_timeformat'], $topic_rowset[$i]['post_time'], $board_config['board_timezone'])); 
		}
        // MOD - TODAY AT - END

#
#-----[ OPEN ]------------------------------
# 
viewtopic.php 

#
#-----[ FIND ]-----------------------------------
# 
$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);

#
#-----[ AFTER, ADD ]-----------------------------------
# 

	//
    // MOD - TODAY AT - BEGIN
	//
	if ( $board_config['time_today'] < $postrow[$i]['post_time'])
	{ 
		$post_date = sprintf($lang['Today_at'], create_date($board_config['default_timeformat'], $postrow[$i]['post_time'], $board_config['board_timezone'])); 
	}
	else if ( $board_config['time_yesterday'] < $postrow[$i]['post_time'])
	{ 
		$post_date = sprintf($lang['Yesterday_at'], create_date($board_config['default_timeformat'], $postrow[$i]['post_time'], $board_config['board_timezone'])); 
	}
    // MOD - TODAY AT - END

#
#-----[ OPEN ]------------------------------
# 
language/lang_english/lang_main.php 

#
#-----[ FIND ]-----------------------------------
# 
?>

#
#-----[ BEFORE, ADD ]-----------------------------------
# 

// MOD - TODAY AT - BEGIN
$lang['Today_at'] = "Today at %s"; // %s is the time
$lang['Yesterday_at'] = "Yesterday at %s"; // %s is the time
// MOD - TODAY AT - END

# 
#-----[ SAVE/CLOSE ALL FILES ]-----------------------------------
# EoM

