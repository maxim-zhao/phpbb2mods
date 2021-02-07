##############################################################
## MOD Title: EZ Content Annoucement Addon
## MOD Author: christhatsme < chris.j.bridges@gmail.com > (Chris Bridges) http://chris.laxforums.co.uk
## MOD Description: Announcement page addon of EZ Content. Displays latest 10 topics
## from a specific forum as news items. Requires EZ Content.
## MOD Version: 1.1.2
##
## Installation Level: Easy
## Installation Time: 3-5 Minutes
## Files To Edit: includes/constants.php
##                viewonline.php
##                admin/index.php
##                language/lang_english/lang_main.php
## Included Files: news.php
##		   templates/subSilver/news_body.tpl
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
##	- Repackaged with EZ Content changes
##
##   2006-04-02 - Version 1.1.0
##	- Repackaged with EZ Content changes
##
##   2006-02-13 - Version 1.0.0
##	- First Release
##
##   2006-02-12 - Version 0.8.1
##	- Fixed bug in install script
##
##   2006-02-11 - Version 0.8.0
##      - View bug fixes
##	- Added Language Support
##
##   2005-02-11 - Version 0.7.0
##      - BETA
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]------------------------------------------
# 
copy AnnouncementAddon/news.php to news.php
copy AnnouncementAddon/templates/subSilver/news_body.tpl to templates/subSilver/news_body.tpl

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
// BEGIN EZ Content Announcement Addon by christhatsme
//

$lang['Viewing_News'] = 'Viewing News';

// 
// END EZ Content Announcement Addon MOD by christhatsme
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
define('PAGE_NEWS', -1251);

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
				case PAGE_NEWS:
					$location = $lang['Viewing_News'];
					$location_url = "news.$phpEx";
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
						case PAGE_NEWS:
							$location = $lang['Viewing_News'];
							$location_url = "index.$phpEx?pane=right";
							break;

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
# 
in order to configure this MOD you should:

1) open news.php
2) enter configuration details towards the top of the file

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM