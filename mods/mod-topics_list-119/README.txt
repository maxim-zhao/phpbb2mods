############################################################## 
## Tool Title:		Topics list
## MOD Author:		Ptirhiik < ptirhiik@clanmckeen.com > (Pierre) http://rpgnet.clanmckeen.com
## Tool Description:	Topics list is a tool in order to display a list of topics anywhere.
##
## Tool Version:	1.1.6
##
############################################################## 
## Author Notes: 
##
##	using this tool :
##		- you will have to add a sql request in order to select the topics you want to display
##	(see in functions_topics_list.php the structure of this sql request) and to grab the result into
##	an array,
##	nb.: you will have to add the item type (basicely POST_TOPIC_URL for topics) in front of the topic_id column
##
##		- you will have to add a tpl var where the box is supposed to be displayed into the main
##	template file,
##
##		- you will have to add to your php, at top an 
##	includes_once($phpbb_root_path . 'includes/functions_topics_list.' . $phpEx);
##	and after having filled the $topic_rowset[] array resulting of the sql request, add the call to the function
##	topics_list();
##	(see in functions_topics_list.php the call parms structure)
## 
##
##	Features :
##		- split per topic type, in boxes or not,
##		- "user replied to" functionality
##		- select single or multi topics fields implemented
############################################################## 
## MOD History: 
##
##   2003-09-28 - Version 1.1.6
##      - slight fix for IE
##
##   2003-09-14 - Version 1.1.5
##      - isolate common usage of this part from many mods
##
############################################################## 


To add to your mod description :

(../..)
## Files To Edit:
##
##		templates/subSilver/subSilver.cfg

(../..)
## Included Files:
##
##		mod-topics_list/functions_topics_list.php
##		mod-topics_list/topics_list_box.tpl
##
##		mod-topics_list/graph.gif/folder_announce_own.gif
##		mod-topics_list/graph.gif/folder_announce_new_own.gif
##		mod-topics_list/graph.gif/folder_own.gif
##		mod-topics_list/graph.gif/folder_new_own.gif
##		mod-topics_list/graph.gif/folder_hot_own.gif
##		mod-topics_list/graph.gif/folder_new_hot_own.gif
##		mod-topics_list/graph.gif/folder_lock_own.gif
##		mod-topics_list/graph.gif/folder_lock_new_own.gif
##		mod-topics_list/graph.gif/folder_sticky_own.gif
##		mod-topics_list/graph.gif/folder_sticky_new_own.gif

(../..)
#
#-----[ COPY ]------------------------------------------------
#
# this part is relative to the topics list mod
#
copy mod-topics_list/functions_topics_list.php to includes/functions_topics_list.php
copy mod-topics_list/topics_list_box.tpl to templates/subSilver/topics_list_box.tpl

copy mod-topics_list/graph.gif/folder_announce_own.gif to templates/subSilver/images/folder_announce_own.gif
copy mod-topics_list/graph.gif/folder_announce_new_own.gif to templates/subSilver/images/folder_announce_new_own.gif
copy mod-topics_list/graph.gif/folder_own.gif to templates/subSilver/images/folder_own.gif
copy mod-topics_list/graph.gif/folder_new_own.gif to templates/subSilver/images/folder_new_own.gif
copy mod-topics_list/graph.gif/folder_hot_own.gif to templates/subSilver/images/folder_hot_own.gif
copy mod-topics_list/graph.gif/folder_new_hot_own.gif to templates/subSilver/images/folder_new_hot_own.gif
copy mod-topics_list/graph.gif/folder_lock_own.gif to templates/subSilver/images/folder_lock_own.gif
copy mod-topics_list/graph.gif/folder_lock_new_own.gif to templates/subSilver/images/folder_lock_new_own.gif
copy mod-topics_list/graph.gif/folder_sticky_own.gif to templates/subSilver/images/folder_sticky_own.gif
copy mod-topics_list/graph.gif/folder_sticky_new_own.gif to templates/subSilver/images/folder_sticky_new_own.gif

(../..)
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]------------------------------------------------
#
<?php
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : topics list -----------------------------------------------------------------------------
#
#-----[ FIND ]------------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
//-- mod : topics list -----------------------------------------------------------------------------
//-- add
$images['folder_global_announce']		= "$current_template_images/folder_announce.gif";
$images['folder_global_announce_new']		= "$current_template_images/folder_announce_new.gif";
$images['folder_global_announce_own']		= "$current_template_images/folder_announce_own.gif";
$images['folder_global_announce_new_own']	= "$current_template_images/folder_announce_new_own.gif";
$images['folder_own']				= "$current_template_images/folder_own.gif";
$images['folder_new_own']			= "$current_template_images/folder_new_own.gif";
$images['folder_hot_own']			= "$current_template_images/folder_hot_own.gif";
$images['folder_hot_new_own']			= "$current_template_images/folder_new_hot_own.gif";
$images['folder_locked_own']			= "$current_template_images/folder_lock_own.gif";
$images['folder_locked_new_own']		= "$current_template_images/folder_lock_new_own.gif";
$images['folder_sticky_own']			= "$current_template_images/folder_sticky_own.gif";
$images['folder_sticky_new_own']		= "$current_template_images/folder_sticky_new_own.gif";
$images['folder_announce_own']			= "$current_template_images/folder_announce_own.gif";
$images['folder_announce_new_own']		= "$current_template_images/folder_announce_new_own.gif";
//-- fin mod : topics list -------------------------------------------------------------------------
