##############################################################
## MOD Title: remove_images.mod
## MOD Author: Blankety Blank Man < blanketyblankman@gmail.com > (Brian Shields) http://edos.siteburg.com/phpBB2/index.php
## MOD Description: Removes images from signatures in chosen forums (removal of avatars is optional),
##                  or replaces them with something else.
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: ~1 Minute
## Files To Edit: viewtopic.php
## Included Files: N/A
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##  My first mod, made by request of one of hte moderators on my forum, to remove
##   images from the signatures in the Trade Forum so that users could not create flashy
##   signatures to draw people to thier trade topics.
##
##  Selecting the forum:
##    At the line 'if($forum_id == 1)' replace the 1 with the forum id (viewforum.php?f=[ID])
##    of the forum you wish to affect.
##
##  Selecting multiple forums (less than half of total):
##    If you have more than one forum you wish to remove images from, change the 'if($forum_id == 1)'
##    to 'if($forum_id == 1 || $forum_id == 2)' for $forum_id's 1 and 2,
##    'if($forum_id == 1 || $forum_id == 2 || $forum_id == 3)' for $forum_id's 1, 2, and 3, etc.
##
##  Selecting multiple forums (more than half of total):
##    If you want to remove image from more than half of your forums, do the above for the forums
##    that _will_ have images, but instead of '==' use '!=', because this way you have less to
##    actually type.
##
##  Removing avatars:
##    At the line '//$poster_avatar = '';' remove the comment slashes (//) in order to remove
##    avatars.
##
##  Replacing avatars:
##    Uncomment the '//$poster_avatar = '';' line, and place something between the quotes in order to
##    replace the avatar with something of your own. example:
##      $poster_avatar = '[No avatars allowed in this forum]';
##
##  Replacing images:
##    Rather than removing the images entirely, you can replace then with something else by
##    changing the line '$replace = '';' with what you want to replace. I you want to use HTML,
##    HTML will have to be enabled on your board and the user will need HTML to be enabled.
##    If you want to use BBCode, you'll have to add the id to the tag. example:
##      $replace = '[img:'.$user_sig_bbcode_uid.']noimgsallowed.gif[/img:'.$user_sig_bbcode_uid.']';
##
##  Replacing images with the image url:
##    If you uncomment the line '//$replace = '\\1';', then only the [img] and [/img] will be removed,
##    not the url of the image. So, '[img]http://mysite.com/myimage.gif[/img]' will become
##    'http://mysite.com/myimage.gif'
##############################################################
## MOD History:
##
##   2005-04-25 - Version 1.0.1
##      - v1.0.0 EasyMOD and security rejection problems (hopefully) fixed
##      - Sped up script by a minute amount -- unoticeable, but something
##
##   2005-04-16 - Version 1.0.0
##      - Mod created and (if you're reading this) probably validated :D
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
# around line 1051
	$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
	if($forum_id == 1)
	{
		$regex_pattern = "#\[img:$user_sig_bbcode_uid\]([^\[]*)\[/img:$user_sig_bbcode_uid\]#";
		$replace = '';
		//$replace = '\\1';
		$user_sig = preg_replace($regex_pattern,$replace,$user_sig);
		//$poster_avatar = '';
	}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM