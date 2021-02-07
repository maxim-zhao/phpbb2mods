############################################################## 
## MOD Title: Page Stats MOD 
## MOD Author: pulling_his_hair < N/A > (Geoffrey Sneddon) N/A 
## MOD Description: Displays the time taken to execute the script, and the number of SQL Queries at the bottom of the page 
## MOD Version: 1.0.3 
## 
## Installation Level: Easy
## Installation Time: ~ 10 Minutes 
## Files To Edit: 
##               common.php 
##               includes/page_tail.php 
##               language/lang_english/lang_main.php 
##               templates/subSilver/overall_footer.tpl 
## Included Files: (n/a) 
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2
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
##      - The latest version can always be found at http://www.phpbb.com/
##
## Thank You, Geoffrey
##
############################################################## 
## MOD History: 
## 
##   2005-08-11 - Version 1.0.3
##      - Update to new phpBB MOD Template
## 
##   2005-08-10 - Version 1.0.2 
##      - Removing duplicate mysql4.php code
## 
##   2005-06-06 - Version 1.0.1 
##      - Clearing up the final couple of things for submission in the phpBB MOD database
## 
##   2005-04-24 - Version 1.0.0 
##      - Initial Release :) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------ 
#
common.php

#
#-----[ FIND ]------------------------------------------ 
#

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

#
#-----[ AFTER, ADD ]------------------------------------------ 
#

// Timer - Page Stats MOD

// Produces the microtime() as a float, on PHP5, it uses the built in ability of the microtime() function, otherwise it uses some code borrowed from php.net
function microtime_float()
{
	if (@phpversion() < '5.0.0')
	{
		list($user, $sec) = explode(" ", microtime());
		return ((float)$user + (float)$sec);
	}
	else
	{
		return microtime(true);
	}
}

// Starts the timer
$GLOBALS['timer_start'] = microtime_float();

// End Timer - Page Stats MOD


# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/page_tail.php

#
#-----[ FIND ]------------------------------------------ 
#
	'ADMIN_LINK' => $admin_link)
);

#
#-----[ REPLACE WITH ]------------------------------------------ 
#
	'ADMIN_LINK' => $admin_link,
	// Page Stats MOD
	'PAGE_INFO_MOD' => sprintf($lang['stats'], number_format(microtime_float() - $GLOBALS['timer_start'], 3), $db->num_queries()))
	// End Page Stats MOD
);

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------ 
#
//
// That's all, Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
//
// Page Stats MOD
//
$lang['stats'] = 'Page created in %s seconds with %s SQL queries';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/overall_footer.tpl

#
#-----[ FIND ]------------------------------------------ 
#
Powered by <a href="http://www.phpbb.com/" target="_phpbb" class="copyright">phpBB</a> &copy; 2001, 2005 phpBB Group<br />{TRANSLATION_INFO}</span></div>

#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
{TRANSLATION_INFO}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
<br />{PAGE_INFO_MOD}

# 
#-----[ OPEN ]------------------------------------------ 
# 
db/db2.php

#
#-----[ FIND ]------------------------------------------ 
#
} // class sql_db

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	function num_queries()
	{
		return $this->num_queries;
	}


# 
#-----[ OPEN ]------------------------------------------ 
# 
db/msaccess.php

#
#-----[ FIND ]------------------------------------------ 
#
} // class sql_db

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	function num_queries()
	{
		return $this->num_queries;
	}


# 
#-----[ OPEN ]------------------------------------------ 
# 
db/mssql-odbc.php

#
#-----[ FIND ]------------------------------------------ 
#
} // class sql_db

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	function num_queries()
	{
		return $this->num_queries;
	}


# 
#-----[ OPEN ]------------------------------------------ 
# 
db/mssql.php

#
#-----[ FIND ]------------------------------------------ 
#
} // class sql_db

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	function num_queries()
	{
		return $this->num_queries;
	}


# 
#-----[ OPEN ]------------------------------------------ 
# 
db/mysql.php

#
#-----[ FIND ]------------------------------------------ 
#
} // class sql_db

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	function num_queries()
	{
		return $this->num_queries;
	}


# 
#-----[ OPEN ]------------------------------------------ 
# 
db/mysql4.php

#
#-----[ FIND ]------------------------------------------ 
#
} // class sql_db

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	function num_queries()
	{
		return $this->num_queries;
	}


# 
#-----[ OPEN ]------------------------------------------ 
# 
db/postgres7.php

#
#-----[ FIND ]------------------------------------------ 
#
} // class ... db_sql

#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	function num_queries()
	{
		return $this->num_queries;
	}


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM