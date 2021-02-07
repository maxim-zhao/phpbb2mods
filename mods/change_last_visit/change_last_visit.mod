##############################################################
## MOD Title: Marking posts as unread (+ js calendar).
## MOD Author: Nux < egil -at- wp.pl > (Maciej Jaros) N/A
## MOD Description:
##		It gives all users the possibility to change their last visit time. Last visit time (along with cookies) enables marking posts as unread.
##		That means that if someone changes that time to e.g. 18 may 2005, he will see all posts sent after that date marked as unread (if not already marked as read by his cookies).
##		He may also see all topics containing posts sent after that date, which is done by clicking the 'View posts since last visit' link (cookies don't play any role in this). 
##
## MOD Version:   1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
##
## Files To Edit: 
##		index.php
##		language/lang_english/lang_main.php
##		templates/subSilver/index_body.tpl
##
## Included Files:
##		modvisit.php
##		templates/subSilver/profile_modvisit.tpl
##		js/calend_t.js
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
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
##	Note: The MOD was previously named "Changeable last visit", 
##	but I think it doesn't give you the right feeling of 
##	what you get.
##
##	Languages & templates:
##	 + Changes to Polish language files may be found in 
##	   'translations/polish_translation.mod'
##	 + Of course the changes to the templates are necessary 
##	   so that users can use this MOD. This means that you may 
##	   put this where you want to, but the current version should 
##	   work with all versions that have 'index_body.tpl'
##	   and show {LAST_VISIT_DATE}.
##	 + please note that changes should be done to all of your 
##	   languages and templates (with EM it should be done 
##	   automatically for templates).
##
##	EasyMOD:
##	 This MOD was tested with EasyMOD 0.3.0 beta and should 
##	 work without any problems - please contact me if it doesn't.
##
##	Support:
##	 For support please use this MOD's topic on http://www.phpbb.com/phpBB/
##	 if you won't be able to contact me through the page you might want to 
##	 mail me at: <egil (at) wp.pl>, but please use this MOD's topic if you can.
##
##	Manual MOD installation info:
##	 + When you find a 'AFTER, ADD'-Statement, the Code have to be added after the last
##	   line quoted in the 'FIND'-Statement.
##	 + When you find a 'BEFORE, ADD'-Statement, the Code have to be added before the
##	   first line quoted in the 'FIND'-Statement.
##	 + When you find a 'REPLACE WITH'-Statement, the Code quoted in the
##	   'FIND'-Statement have to be replaced _completely_ with the quoted Code in the
##	   'REPLACE WITH'-Statement.
##
##	For further details on installing MODs see this Knowledge Base articles:
##	 + How to Install MODs  ->  http://www.phpbb.com/kb/article.php?article_id=150
##	 + Installing a MOD in a safe way  ->  http://www.phpbb.com/kb/article.php?article_id=175
##
############################################################## 
## MOD History: 
## 
##	2006-01-19 - Version 1.0.0 (RC1)
##	 - first official release
##
##	2006-01-17 - Version 0.1.2 (beta)
##	 - fixed JavaScript time/date slip bugs
##	 - some changes to notes of the MODs
##	 - changed the name of the MOD
##
##	2006-01-13 - Version 0.1.1 (beta)
##	 - fixed JavaScript time bug
##
##	2006-01-13 - Version 0.1.0 (beta)
##	 - JavaScript calendar
##
##	2005-05-27 - Version 0.0.2 (beta)
##	 - fixed year change bug
##
##  	2005-05-26 - Version 0.0.1 (beta)
##	 - first beta
## 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy files/modvisit.php to modvisit.php
copy files/templates/subSilver/profile_modvisit.tpl to templates/subSilver/profile_modvisit.tpl
copy files/js/calend_t.js to js/calend_t.js

#
#-----[ OPEN ]------------------------------------------
#
#
index.php

#
#-----[ FIND ]------------------------------------------
#
# around line 1
#
<?php

#
#-----[ AFTER, ADD ]------------------------------------------
#
# just to mark that this file is moded by it
#
// MOD: modvisit

#
#-----[ FIND ]------------------------------------------
#
# around line 270
# after '$template->assign_vars(array('
#
		'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		//-----------------------------------------------------
		// MOD: modvisit :BEGIN
		'U_MODVISIT' => append_sid("modvisit.$phpEx"),
		'L_CHANGE' => $lang['Change'],
		// MOD: modvisit :END
		//-----------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
# around line 1
#
<?php

#
#-----[ AFTER, ADD ]------------------------------------------
#
# just to mark that this file is moded by it
#
// MOD: modvisit

#
#-----[ FIND ]------------------------------------------
#
# just before the end of file
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// MOD: modvisit :BEGIN
$lang['Change'] = 'Change';
$lang['Click_return_try_again'] = 'Click %sHere%s to try again';
$lang['modvisit_title'] = 'Change settings of marking posts.';
$lang['modvisit_date_title'] = 'Set as unread from date:';
$lang['modvisit_explain'] = 'After this your "last visited" date will be changed.
	It handles marking posts as read or unread (with a little help from your cookies).';
$lang['modvisit_date_invalid'] = 'The date is invalid.';
// single quotes here! it is meant to be parsed by JavaScript, not PHP
$lang['modvisit_time_invalid'] = 'Incorrect time format!\nTry 13:10 or 14:57:29.';
// MOD: modvisit :END

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#
# around line 5
#
# Whole line is: {LAST_VISIT_DATE}<br />
#
{LAST_VISIT_DATE}

#
#-----[ IN-LINE FIND ]------------------------------------------
#
{LAST_VISIT_DATE}

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
&nbsp;(<a href="{U_MODVISIT}" class="gensmall" target="modvisit" onClick="okienko=window.open('{U_MODVISIT}', 'modvisit', 'HEIGHT=580,resizable=yes,WIDTH=490');okienko.focus();return false;">{L_CHANGE}</a>)

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM