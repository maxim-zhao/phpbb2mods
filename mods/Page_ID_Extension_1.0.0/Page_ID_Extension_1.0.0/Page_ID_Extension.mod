############################################################## 
## MOD Title: Page ID Extension
## MOD Author: Graham < phpbb@grahameames.co.uk > (Graham Eames) http://www.grahameames.co.uk/phpbb/
## MOD Description: Provides a simple means for MOD Authors to add new
## page ID's for use in their MODs to provide more accurate session
## tracking without the need for each MOD to alter constants.php,
## viewonline.php and admin/index.php
##
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
## Files To Edit:
##    language/lang_english/lang_main.php
##    common.php
##    viewonline.php
##    admin/index.php
## Included Files: 
##    mod_page_id.php
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## Information on the ranges of values which are available for
## use, and which are reserved for the core code and individual
## MOD authors is available at:
## http://www.phpbb.com/kb/article.php?article_id=149
############################################################## 
## MOD History:
## Nov 15, 2003 - Version 1.0.0
##  - Initial Release for phpBB 2.0.6
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy mod_page_id.php to includes/mod_page_id.php 

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Viewing_FAQ'] = 'Viewing FAQ';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['Viewing_Page_MOD'] = 'Viewing a forum add-on'; // Added by Page ID Extension MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
common.php

# 
#-----[ FIND ]------------------------------------------ 
# 
include($phpbb_root_path . 'includes/constants.'.$phpEx);

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
include($phpbb_root_path . 'includes/mod_page_id.'.$phpEx); // Added by Page ID Extension MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
viewonline.php

# 
#-----[ FIND ]------------------------------------------ 
# 
				default:
					$location = $lang['Forum_index'];
					$location_url = "index.$phpEx";

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
					$page_id_count = count($page_id);
					for ($i=0; $i<$page_id_count; $i++)
					{
						if ($page_id[$i]['CONSTANT_VALUE'] == $row['session_page'])
						{
							$location = $lang[$page_id[$i]['LANG_STRING']];
							$location_url = $page_id[$i]['PAGE_URL'];
							break;
						}
					}

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/index.php

# 
#-----[ FIND ]------------------------------------------ 
# 
						default:
							$location = $lang['Forum_index'];
							$location_url = "index.$phpEx?pane=right";
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
							$page_id_count = count($page_id);
							for ($i=0; $i<$page_id_count; $i++)
							{
								if ($page_id[$i]['CONSTANT_VALUE'] == $onlinerow_reg[$i]['user_session_page'])
								{
									$location = $lang[$page_id[$i]['LANG_STRING']];
									break;
								}
							}
# 
#-----[ FIND ]------------------------------------------ 
# 
					default:
						$location = $lang['Forum_index'];
						$location_url = "index.$phpEx?pane=right";
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
						$page_id_count = count($page_id);
						for ($i=0; $i<$page_id_count; $i++)
						{
							if ($page_id[$i]['CONSTANT_VALUE'] == $onlinerow_guest[$i]['session_page'])
							{
								$location = $lang[$page_id[$i]['LANG_STRING']];
								break;
							}
						}
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 