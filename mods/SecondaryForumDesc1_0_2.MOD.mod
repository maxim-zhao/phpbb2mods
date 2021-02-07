##############################################################
## MOD Title: Secondary Forum Descriptions
## MOD Author: TWoods < tina@warofconquest.com > (Tina Woods) N/A
## MOD Description: This allows you to enter a second, more detailed forum description 
## which is displayed on viewforum.php. Requires 1 small database update.
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 25 Minutes
## Files To Edit:6
##    admin/admin_forums.php
##    templates/subSilver/admin/forum_admin_body.tpl
##    templates/subSilver/admin/forum_edit_body.tpl
##		viewforum.php
##		templates/subSilver/viewforum_body.tpl
##    language/lang_english/lang_main.php
##
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
## Author Notes: This is a great little function if you want to display specific rules
## for a particular forum, or other text which would be too long for the index page.
##
##############################################################
## MOD History:
##
##
##   2005-01-09 - Version 1.0.2
##      - Initial release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]------------------------------------------------
#
ALTER TABLE phpbb_forums ADD forum_desc_long TEXT;
#
#-----[ OPEN ]------------------------------------------------
#
admin/admin_forums.php
#
#-----[ FIND ]------------------------------------------------
#
				$forumdesc = $row['forum_desc'];
#
#-----[ AFTER, ADD ]----------------------------------------
#
				$forumdesc_long = $row['forum_desc_long'];
#
#-----[ FIND ]------------------------------------------------
#
				$forumdesc = '';
#
#-----[ AFTER, ADD ]----------------------------------------
#
				$forumdesc_long = '';
#
#-----[ FIND ]------------------------------------------------
#
				'L_FORUM_DESCRIPTION' => $lang['Forum_desc'],
#
#-----[ AFTER, ADD ]----------------------------------------
#
				'L_FORUM_DESC_EXPLAIN' => $lang['Forum_desc_explain'],
				'L_FORUM_DESC_LONG' => $lang['Forum_desc_long'],				
				'L_DESC_LONG_EXPLAIN' => $lang['Forum_desc_long_explain'],
#
#-----[ FIND ]------------------------------------------------
#
				'DESCRIPTION' => $forumdesc)
#
#-----[ BEFORE, ADD ]----------------------------------------
#
				'DESCRIPTION_LONG' => $forumdesc_long,
#
#-----[ FIND ]------------------------------------------------
#
		$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id, forum_name,
#
#-----[ IN-LINE FIND ]----------------------------------------
#
forum_desc,
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------
#
forum_desc_long,
#
#-----[ FIND ]------------------------------------------------
#
				VALUES ('" . $next_id . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname'])
#
#-----[ IN-LINE FIND ]----------------------------------------
#
. str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "',
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------
#
forum_desc_long = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc_long']) . "',
#
#-----[ FIND ]------------------------------------------------------
#
				SET forum_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname'])
#
#-----[ IN-LINE FIND ]----------------------------------------
#
. str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "',
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------
#
forum_desc_long = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc_long']) . "',
#
#-----[ FIND ]------------------------------------------------
#
				$template->assign_block_vars("catrow.forumrow",	array(
#
#-----[BEFORE, ADD]--------------------------------------------
#				
				  if (!empty($forum_rows[$j]['forum_desc_long']))
				  {
					 $long_desc_title = $lang['Forum_desc_long'] . ': ';				      
				  }
				  else
				  {
				    $long_desc_title = ''; 
				  }
#
#-----[ FIND ]------------------------------------------------
#
						'FORUM_DESC' => $forum_rows[$j]['forum_desc'],
#
#-----[ AFTER, ADD ]----------------------------------------
#
				    'L_FORUM_DESC_LONG' => $long_desc_title,
						'FORUM_DESC_LONG' => $forum_rows[$j]['forum_desc_long'],
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/admin/forum_admin_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
{catrow.forumrow.FORUM_DESC}</span></td>
#
#-----[ IN-LINE FIND ]----------------------------------------
#
{catrow.forumrow.FORUM_DESC}
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------
#
<br /><br />{catrow.forumrow.L_FORUM_DESC_LONG}{catrow.forumrow.FORUM_DESC_LONG}
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/admin/forum_edit_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
	<tr> 
	  <td class="row1">{L_FORUM_DESCRIPTION}</td>
	  <td class="row2"><textarea rows="5" cols="45" wrap="virtual" name="forumdesc" class="post">{DESCRIPTION}</textarea></td>
	</tr>
#
#-----[ REPLACE WITH ]------------------------------------------------
#
	<tr> 
	  <td class="row1">{L_FORUM_DESCRIPTION}<br /><span class="gensmall">{L_FORUM_DESC_EXPLAIN}<span></td>
	  <td class="row2"><textarea rows="5" cols="45" wrap="virtual" name="forumdesc" class="post">{DESCRIPTION}</textarea></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_DESC_LONG}<br /><span class="gensmall">{L_DESC_LONG_EXPLAIN}</span></td>
	  <td class="row2"><textarea rows="5" cols="45" wrap="virtual" name="forumdesc_long" class="post">{DESCRIPTION_LONG}</textarea></td>
	</tr>
#
#-----[ OPEN ]------------------------------------------------
#
viewforum.php
#
#-----[ FIND ]------------------------------------------------
#
	'FORUM_NAME' => $forum_row['forum_name'],
#
#-----[ AFTER, ADD ]----------------------------------------
#
	'FORUM_DESC_LONG' => $forum_row['forum_desc_long'],
#
#-----[ OPEN ]------------------------------------------------
#
templates/subSilver/viewforum_body.tpl
#
#-----[ FIND ]------------------------------------------------
#
	  <td align="left" valign="bottom" colspan="2"><a class="maintitle" href="{U_VIEW_FORUM}">
#
#-----[ IN-LINE FIND ]----------------------------------------
#
{FORUM_NAME}</a>
#
#-----[ IN-LINE AFTER, ADD ]----------------------------------------
#
<br /><span class="gen">{FORUM_DESC_LONG}</span>
#
#-----[ OPEN ]------------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------------
#
$lang['Forum_desc_explain'] = 'This is generally a short description of this forum. It is displayed on the index page.';
$lang['Forum_desc_long'] = 'Long Description';			
$lang['Forum_desc_long_explain'] = 'This is a more detailed description or rules for this forum. It is displayed on the viewform page.';
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM