############################################################## 
## MOD Title: Pagination MOD 
## MOD Author: Xore < xore at azuriah dot com > (Robert Hetzler) http://www.azuriah.com 
## MOD Description: Alter the pagination link settings
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: 4 Minutes 
## Files To Edit: includes/functions.php 
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: Manually variablizing all those hardcoded constants was... interesting
##
## During the installation, replace the values for
##
## 				$begin_end = 3;
##				$from_middle = 1;
##
## With the ones you want for your pagination. A description is supplied.
##
## Be very careful with what you copy and paste.
## 
############################################################## 
## MOD History: 
## 
##   2003-09-23 - Version 1.0.0 
##      - Initial Release 
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
	$total_pages = ceil($num_items/$per_page);
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
//
// BEGIN Pagination Mod
//
	$begin_end = 3;
	$from_middle = 1;
/*
	By default, $begin_end is 3, and $from_middle is 1, so on page 6 in a 12 page view, it will look like this:

	a, d = $begin_end = 3
	b, c = $from_middle = 1

 "begin"        "middle"           "end"
    |              |                 |
    |     a     b  |  c     d        |
    |     |     |  |  |     |        |
    v     v     v  v  v     v        v
    1, 2, 3 ... 5, 6, 7 ... 10, 11, 12

	Change $begin_end and $from_middle to suit your needs appropriately
*/
//
// END Pagination Mod
//

# 
#-----[ FIND ]------------------------------------------ 
#
	if ( $total_pages > 10 )
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	if ( $total_pages > ((2*($begin_end + $from_middle)) + 2) )

# 
#-----[ FIND ]------------------------------------------ 
#
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
		$init_page_max = ( $total_pages > $begin_end ) ? $begin_end : $total_pages;

# 
#-----[ FIND ]------------------------------------------ 
#
		if ( $total_pages > 3 )
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
		if ( $total_pages > $begin_end )

# 
#-----[ FIND ]------------------------------------------ 
#
				$page_string .= ( $on_page > 5 ) ? ' ... ' : ', ';
# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
				$page_string .= ( $on_page > ($begin_end + $from_middle + 1) ) ? ' ... ' : ', ';

# 
#-----[ FIND ]------------------------------------------ 
#
				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
				$init_page_min = ( $on_page > ($begin_end + $from_middle) ) ? $on_page : ($begin_end + $from_middle + 1);

# 
#-----[ FIND ]------------------------------------------ 
#
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
# 
#-----[  REPLACE WITH ]------------------------------------------ 
#
				$init_page_max = ( $on_page < $total_pages - ($begin_end + $from_middle) ) ? $on_page : $total_pages - ($begin_end + $from_middle);

# 
#-----[ FIND ]------------------------------------------ 
#
				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
				for($i = $init_page_min - $from_middle; $i < $init_page_max + ($from_middle + 1); $i++)

# 
#-----[ FIND ]------------------------------------------ 
#
					if ( $i <  $init_page_max + 1 )
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
					if ( $i <  $init_page_max + $from_middle )

# 
#-----[ FIND ]------------------------------------------ 
#
				$page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ', ';
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
				$page_string .= ( $on_page < $total_pages - ($begin_end + $from_middle) ) ? ' ... ' : ', ';

# 
#-----[ FIND ]------------------------------------------ 
#
			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
			for($i = $total_pages - ($begin_end - 1); $i < $total_pages + 1; $i++)

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
