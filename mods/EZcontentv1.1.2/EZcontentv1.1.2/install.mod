##############################################################
## MOD Title: EZ Content
## MOD Author: christhatsme < chris.j.bridges@gmail.com > (Chris Bridges) http://chris.laxforums.co.uk
## MOD Description: Provides an easy way of having website content. Uses topics 
## from your board, and displays them as webpages (http://yourdomain.com/content.php?t=TOPICid). 
## Forum permission is configureable. Supplied is an addon, to show how to customize into an Announcements Page. 
## MOD Version: 1.1.2
##
## Installation Level: Easy
## Installation Time: 3-5 Minutes
## Files To Edit: includes/constants.php
##                viewonline.php
##                admin/index.php
##                language/lang_english/lang_main.php
## Included Files: content.php
##		   templates/subSilver/content_body.tpl
##		   templates/subSilver/content_pages_body.tpl
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Please read the README.html to find out how to use
## and configure this addon
##
##############################################################
## MOD History:
##
##   2006-05-31 - Version 1.1.2
##	- fixed minor bugs for MOD team
##
##   2006-04-16 - Version 1.1.1
##	- fixed minor bugs for MOD team
##
##   2006-04-02 - Version 1.1.0
##	- content.php is now a menu
##  - new way of viewing (content.php?mode=view&t=ID
##  - Fixed all bugs, now resubmitting to MOD DB
##
##   2006-02-13 - Version 1.0.0
##	- First Release
##
##   2006-02-12 - Version 0.8.1
##	- Fixed bug in install script
##
##   2006-02-11 - Version 0.8.0
##  - View bug fixes
##	- Added language support
##
##   2006-02-11 - Version 0.7.0
##  - BETA
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]------------------------------------------
# 
copy root/content.php to content.php
copy root/templates/subSilver/content_body.tpl to templates/subSilver/content_body.tpl
copy root/templates/subSilver/content_pages_body.tpl to templates/subSilver/content_pages_body.tpl

#
#-----[ OPEN ]------------------------------------------
# 
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
# 
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
# 

//
// BEGIN EZ Content MOD by christhatsme
//

$lang['data_error'] = 'Error in Getting Data';
$lang['permission_error'] = 'This entry does not have the requred permission to be viewed';
$lang['Viewing_Content'] = 'Viewing Content';
$lang['News_Posted_By'] = 'Posted by';
$lang['News_Views'] = 'Views';
$lang['And'] = 'and';
$lang['News_Replies'] = 'Replies';
$lang['News_Post'] = 'Post reply';
$lang['EZcontent'] = 'Content';

// 
// END EZ Content MOD by christhatsme
//

#
#-----[ OPEN ]------------------------------------------
# 
includes/constants.php

#
#-----[ FIND ]------------------------------------------
# 
define('PAGE_TOPIC_OFFSET', 5000);

#
#-----[ AFTER, ADD ]------------------------------------------
# 
define('PAGE_CONTENT', -1250);

#
#-----[ OPEN ]------------------------------------------
# 
viewonline.php

#
#-----[ FIND ]------------------------------------------
# 
				case PAGE_FAQ:
					$location = $lang['Viewing_FAQ'];
					$location_url = "faq.$phpEx";
					break;

#
#-----[ AFTER, ADD ]------------------------------------------
# 
				case PAGE_CONTENT:
					$location = $lang['Viewing_Content'];
					$location_url = "content.$phpEx";
					break;

#
#-----[ OPEN ]------------------------------------------
# 
admin/index.php

#
#-----[ FIND ]------------------------------------------
# 
						case PAGE_FAQ:
							$location = $lang['Viewing_FAQ'];
							$location_url = "index.$phpEx?pane=right";
							break;

#
#-----[ AFTER, ADD ]------------------------------------------
# 
						case PAGE_CONTENT:
							$location = $lang['Viewing_Content'];
							$location_url = "index.$phpEx?pane=right";
							break;

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
# 
In order to configure this MOD:

1) Edit content.php

2) Enter configuration Details

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM