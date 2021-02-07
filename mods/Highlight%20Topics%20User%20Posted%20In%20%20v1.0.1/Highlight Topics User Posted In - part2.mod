############################################################## 
## MOD Title: Highlight Topics User Posted In - PART2
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/
## Images Creator: Ptirhiik < admin@rpgnet-fr.com > (Pierre) http://rpgnet.clanmckeen.com 
## MOD Description: Will highlight topics in which the user has posted (PART2:different pictures)
## MOD Version: 1.0.1
## 
## Installation Level: Esay
## Installation Time: 1 Minute (less with the great EasyMOD! :-) 
## Files To Edit:	viewforum.php
##			search.php
##			templates/subSilver/subSilver.cfg
## Included Files: 	folder_own.gif
##			folder_new_own.gif
##			folder_hot_own.gif
##			folder_new_hot_own.gif
##			folder_lock_own.gif
##			folder_lock_new_own.gif
##			folder_sticky_own.gif
##			folder_sticky_new_own.gif
##			folder_announce_own.gif
##			folder_announce_new_own.gif
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	YOU NEED TO INTALL PART1 BEFORE!!
##
##	PART2 : This one will use different pictures for topics ; this means you'll need to have
##	new images for every case: topic, topic w/new posts, hot, hot w/new, sticky, sticky w/new, etc)
##
##		** IMPORTANT **
##	This PART2 uses pictures made by Ptirhiik for his MOD: Last Topics From
##	IF YOU HAVE THIS MOD INSTALLED, DO NOT INSTALL THIS ONE FULLY!!!
##	Since I used the same names, if you've Ptirhiik's MOD installed you don't have to
##	 A) copy the pictures files, you already have them
##	 B) make any changes in subSilver.cfg, it's already been done!
##
############################################################## 
## MOD History: 
## 
##   2004-07-02 - Version 1.0.1 
##	- PART2: Fix: missed a  =  in subSilver.cfg !!
##	- Add PART# in MOD Title to work with EasyMOD 
##
##   2004-06-30 - Version 1.0.0 
##	- PART4: Replace <font> by <span> (MOD Validator)
##	- Submitted to the MOD-DB (no changes were made)
##
##   2004-06-26 - Version 0.2.1 
##	- Highlight is also done in search results (is displayed as topics)
##	- New picture for PART3, better with dark background (Thx beggers ;)
##
##   2004-06-25 - Version 0.2.0 
##	- Made 4 parts, and 3 different versions, so you can choose what you like the most
##	  (different topic's pictures, a new picture before the title, or a different title's color)
##
##   2004-06-24 - Version 0.1.0 
##	- Use new images made by Ptirhiik for his MOD: Last Topics From
##	- Fixed a bug, didn't work with Announcements
##
##   2004-06-23 - Version 0.0.1 
##	- First version, should work just fine ;) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


# 
#-----[ COPY ]----- 
# 
copy folder_own.gif to templates/subSilver/images/folder_own.gif
copy folder_own.gif to templates/subSilver/images/folder_own.gif
copy folder_hot_own.gif to templates/subSilver/images/folder_hot_own.gif
copy folder_new_hot_own.gif to templates/subSilver/images/folder_new_hot_own.gif
copy folder_lock_own.gif to templates/subSilver/images/folder_lock_own.gif
copy folder_lock_new_own.gif to templates/subSilver/images/folder_lock_new_own.gif
copy folder_sticky_own.gif to templates/subSilver/images/folder_sticky_own.gif
copy folder_sticky_new_own.gif to templates/subSilver/images/folder_sticky_new_own.gif
copy folder_announce_own.gif to templates/subSilver/images/folder_announce_own.gif
copy folder_announce_new_own.gif to templates/subSilver/images/folder_announce_new_own.gif
# 
#-----[ OPEN ]----- 
# 
viewforum.php
# 
#-----[ FIND ]----- 
# 
			$folder_image =  $images['folder'];
# 
#-----[ REPLACE WITH ]----- 
# 
			$folder_image = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_own'] : $images['folder'] );
# 
#-----[ FIND ]----- 
# 
				$folder = $images['folder_announce'];
				$folder_new = $images['folder_announce_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
				$folder = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_announce_own'] : $images['folder_announce'] );
				$folder_new = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_announce_new_own'] : $images['folder_announce_new'] );
# 
#-----[ FIND ]----- 
# 
				$folder = $images['folder_sticky'];
				$folder_new = $images['folder_sticky_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
				$folder = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_sticky_own'] : $images['folder_sticky'] );
				$folder_new = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_sticky_new_own'] : $images['folder_sticky_new'] );
# 
#-----[ FIND ]----- 
# 
				$folder = $images['folder_locked'];
				$folder_new = $images['folder_locked_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
				$folder = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_locked_own'] : $images['folder_locked'] );
				$folder_new = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_locked_new_own'] : $images['folder_locked_new'] );
# 
#-----[ FIND ]----- 
# 
					$folder = $images['folder_hot'];
					$folder_new = $images['folder_hot_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
					$folder = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_hot_own'] : $images['folder_hot'] );
					$folder_new = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_hot_new_own'] : $images['folder_hot_new'] );
# 
#-----[ FIND ]----- 
# 
					$folder = $images['folder'];
					$folder_new = $images['folder_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
					$folder = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_own'] : $images['folder'] );
					$folder_new = ( ($topic_rowset[$i]['my_reply_id']) ? $images['folder_new_own'] : $images['folder_new'] );
# 
#-----[ OPEN ]----- 
# 
search.php
# 
#-----[ FIND ]----- 
# 
				$template->assign_block_vars("searchresults", array( 
# 
#-----[ FIND ]----- 
# 
					$folder_image = '<img src="' . $images['folder'] . '" alt="' . $lang['No_new_posts'] . '" />';
# 
#-----[ REPLACE WITH ]----- 
# 
					$folder_image = '<img src="' . ( ($searchset[$i]['my_reply_id']) ? $images['folder_own'] : $images['folder'] ) . '" alt="' . $lang['No_new_posts'] . '" />';
# 
#-----[ FIND ]----- 
# 
						$folder = $images['folder_locked'];
						$folder_new = $images['folder_locked_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
						$folder = ( ($searchset[$i]['my_reply_id']) ? $images['folder_locked_own'] : $images['folder_locked'] );
						$folder_new = ( ($searchset[$i]['my_reply_id']) ? $images['folder_locked_new_own'] : $images['folder_locked_new'] );
# 
#-----[ FIND ]----- 
# 
						$folder = $images['folder_announce'];
						$folder_new = $images['folder_announce_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
						$folder = ( ($searchset[$i]['my_reply_id']) ? $images['folder_announce_own'] : $images['folder_announce'] );
						$folder_new = ( ($searchset[$i]['my_reply_id']) ? $images['folder_announce_new_own'] : $images['folder_announce_new'] );
# 
#-----[ FIND ]----- 
# 
						$folder = $images['folder_sticky'];
						$folder_new = $images['folder_sticky_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
						$folder = ( ($searchset[$i]['my_reply_id']) ? $images['folder_sticky_own'] : $images['folder_sticky'] );
						$folder_new = ( ($searchset[$i]['my_reply_id']) ? $images['folder_sticky_new_own'] : $images['folder_sticky_new'] );
# 
#-----[ FIND ]----- 
# 
							$folder = $images['folder_hot'];
							$folder_new = $images['folder_hot_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
							$folder = ( ($searchset[$i]['my_reply_id']) ? $images['folder_hot_own'] : $images['folder_hot'] );
							$folder_new = ( ($searchset[$i]['my_reply_id']) ? $images['folder_hot_new_own'] : $images['folder_hot_new'] );
# 
#-----[ FIND ]----- 
# 
							$folder = $images['folder'];
							$folder_new = $images['folder_new'];
# 
#-----[ REPLACE WITH ]----- 
# 
							$folder = ( ($searchset[$i]['my_reply_id']) ? $images['folder_own'] : $images['folder'] );
							$folder_new = ( ($searchset[$i]['my_reply_id']) ? $images['folder_new_own'] : $images['folder_new'] );
# 
#-----[ OPEN ]----- 
# 
templates/subSilver/subSilver.cfg
# 
#-----[ FIND ]----- 
# 
$images['folder_announce_new'] = "$current_template_images/folder_announce_new.gif";
# 
#-----[ AFTER, ADD ]----- 
# 

$images['folder_own'] = "$current_template_images/folder_own.gif";
$images['folder_new_own'] = "$current_template_images/folder_new_own.gif";
$images['folder_hot_own'] = "$current_template_images/folder_hot_own.gif";
$images['folder_hot_new_own'] = "$current_template_images/folder_new_hot_own.gif";
$images['folder_locked_own'] = "$current_template_images/folder_lock_own.gif";
$images['folder_locked_new_own'] = "$current_template_images/folder_lock_new_own.gif";
$images['folder_sticky_own'] = "$current_template_images/folder_sticky_own.gif";
$images['folder_sticky_new_own'] = "$current_template_images/folder_sticky_new_own.gif";
$images['folder_announce_own'] = "$current_template_images/folder_announce_own.gif";
$images['folder_announce_new_own'] = "$current_template_images/folder_announce_new_own.gif";

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 