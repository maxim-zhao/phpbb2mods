############################################################## 
## MOD Title: Advanced Pruning 
## MOD Author: kp3011 < asv83.lr4087@gmail.com > (Jisp Cheung) http://269m.no-ip.org
## MOD Description: This MOD provides some advanced options in pruning, for example
## choosing to leave sticky posts (even if they are outdated) unpruned, prune also the active
## votes (although they are outdated) or to prune outdated active votes and announcements.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 5 Minutes 
## Files To Edit:	admin/admin_forum_prune.php, 
## 		includes/prune.php, 
## 		templates/subSilver/admin/forum_prune_body.tpl, 
## 		language/lang_english/lang_admin.php
## Included Files: N/A
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
## This MOD is very handy if you want to prune posts according to your wish.
############################################################## 
## MOD History: 
## 
##   2006-02-07 - Version 1.0.0
##      - Initial Release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_forum_prune.php

# 
#-----[ FIND ]------------------------------------------ 
#
	$template->set_filenames(array(
		'body' => 'admin/forum_prune_result_body.tpl')
	);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	$preserve_sticky = ($HTTP_POST_VARS['preserve_sticky'] == 1 ? 1 : 0);
	$prune_all = ($HTTP_POST_VARS['prune_all'] == 1 ? 1 : 0);
	$prune_vote = ($HTTP_POST_VARS['prune_vote'] == 1 ? 1 : 0);

# 
#-----[ FIND ]------------------------------------------ 
#
		$p_result = prune($forum_rows[$i]['forum_id'], $prunedate);

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
		$p_result = prune($forum_rows[$i]['forum_id'], $prunedate, $preserve_sticky, $prune_vote, $prune_all);

# 
#-----[ FIND ]------------------------------------------ 
#
			'L_DO_PRUNE' => $lang['Do_Prune'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
			'L_PRE_STICKY' => $lang['Preserve_Sticky'],
			'L_PRUNE_VOTE' => $lang['Prune_vote'],
			'L_PRUNE_ALL' => $lang['Prune_all'],

# 
#-----[ OPEN ]------------------------------------------ 
#
includes/prune.php

# 
#-----[ FIND ]------------------------------------------ 
#
function prune($forum_id, $prune_date, $prune_all = false)

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
function prune($forum_id, $prune_date, $preserve_sticky = false, $prune_vote = false, $prune_all = false)

# 
#-----[ FIND ]------------------------------------------ 
#
	$prune_all = ($prune_all) ? '' : 'AND t.topic_vote = 0 AND t.topic_type <> ' . POST_ANNOUNCE;

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	if ($prune_all) {
		$prune_all = '';
	} else {
		$prune_all = 'AND t.topic_type <> ' . POST_ANNOUNCE;
		if ($preserve_sticky) {
			$prune_all .= ' AND t.topic_type <> ' . POST_STICKY;
		}
		if (!$prune_vote) {
			$prune_all .= ' AND t.topic_vote = 0';
		}
	}

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/admin/forum_prune_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
	<tr>
	  <td class="row1">{S_PRUNE_DATA}</td>
	</tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	<tr>
	  <td class="row2"><input type="checkbox" name="preserve_sticky" checked="checked" value="1">{L_PRE_STICKY}</td>
	</tr>
	<tr>
	  <td class="row2"><input type="checkbox" name="prune_vote" value="1">{L_PRUNE_VOTE}</td>
	</tr>
	<tr>
	  <td class="row2"><input type="checkbox" name="prune_all" value="1">{L_PRUNE_ALL}</td>
	</tr>

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Prune_topics_not_posted'] = '

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['Preserve_Sticky'] = 'Preserve Sticky Topics';
$lang['Prune_vote'] = 'Prune also active votes';
$lang['Prune_all'] = 'Prune also announcements and active posts';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM