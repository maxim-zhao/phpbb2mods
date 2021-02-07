############################################################## 
## MOD Title: Auto Subject On Reply 
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/ 
## MOD Description: Will show "Re: [topic title]" as subject for reply without subject
## MOD Version: 1.0.2
## 
## Installation Level: Easy 
## Installation Time: 1 Minute (less than one with the great EasyMOD! :-) 
## Files To Edit:	viewtopic.php
##					posting.php
##					includes/topic_review.php
##					search.php
##					language/lang_english/lang_main.php 
## Included Files:	n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	This MOD will show "Re: [topic title]" as post subject
##	for replies without a subject, and this "auto-subject"
##	won't even be stored in the database ;)
##
##	Search results shown as posts will also have "Re: [topic title]"
##	used instead of "[topic title]" as usual (when no subject)
############################################################## 
## MOD History: 
## 
##   2004-08-08 - Version 1.0.2
##	- Added autosubject in post preview & topic review (thanks to doc-emc for pointing this out ;)
##
##   2004-07-02 - Version 1.0.1
##	- Fix: OPEN viewforum.php instead of viewtopic.php !!
##
##   2004-06-30 - Version 1.0.0 
##	- Submitted to the MOD-DB (no changes were made)
##
##   2004-06-12 - Version 0.0.1 
##	- First version, should work just fine ;) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


# 
#-----[ OPEN ]----- 
# 
viewtopic.php 
# 
#-----[ FIND ]----- 
# 
	$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : '';
# 
#-----[ REPLACE WITH ]----- 
# 
	$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : $lang['Re'] . ': ' . $topic_title;
# 
#-----[ OPEN ]----- 
# 
posting.php 
# 
#-----[ FIND ]----- 
# 
		$preview_subject = $subject;
# 
#-----[ AFTER, ADD ]----- 
# 
		if ( ($preview_subject=='') && ($mode=='reply' || $mode=='quote') )
		{
			$preview_subject = $lang['Re'] . ': ' . $post_info['topic_title'];
		}
# 
#-----[ OPEN ]----- 
#
includes/topic_review.php
# 
#-----[ FIND ]----- 
# 
	global $starttime;
# 
#-----[ AFTER, ADD ]----- 
# 
	global $post_info;
# 
#-----[ FIND ]----- 
# 
			$post_subject = ( $row['post_subject'] != '' ) ? $row['post_subject'] : '';
# 
#-----[ REPLACE WITH ]----- 
# 
			$post_subject = ( $row['post_subject'] != '' ) ? $row['post_subject'] : $lang['Re'] . ': ' . (($is_inline_review) ? $post_info['topic_title'] : $topic_title);
# 
#-----[ OPEN ]----- 
# 
search.php
# 
#-----[ FIND ]----- 
# 
						$post_subject = ( $searchset[$i]['post_subject'] != "" ) ? preg_replace($orig_word, $replacement_word, $searchset[$i]['post_subject']) : $topic_title;
# 
#-----[ REPLACE WITH ]----- 
# 
						$post_subject = ( $searchset[$i]['post_subject'] != "" ) ? preg_replace($orig_word, $replacement_word, $searchset[$i]['post_subject']) : $lang['Re'] . ': ' . $topic_title;
# 
#-----[ FIND ]----- 
# 
						$post_subject = ( $searchset[$i]['post_subject'] != '' ) ? $searchset[$i]['post_subject'] : $topic_title;
# 
#-----[ REPLACE WITH ]----- 
# 
						$post_subject = ( $searchset[$i]['post_subject'] != '' ) ? $searchset[$i]['post_subject'] : $lang['Re'] . ': ' . $topic_title;
# 
#-----[ OPEN ]----- 
# 
language/lang_english/lang_main.php
# 
#-----[ FIND ]----- 
# 
//
// That's all, Folks!
// -------------------------------------------------
# 
#-----[ BEFORE, ADD ]----- 
# 
$lang['Re'] = 'Re';
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 