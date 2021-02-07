##############################################################
## MOD Title: Users set Posts & Topics count
## MOD Author: cYbercOsmOnauT < mods@cybercosmonaut.de > (Tekin B.) http://www.cybercosmonaut.de
## MOD Description: Users can set Posts/Topics shown per Page.
## MOD Version: 1.0.1
## Installation Level: Easy
## Installation Time: 23 Minutes
## Files To Edit: admin/admin_users.php
##                includes/functions.php
##                includes/usercp_avatar.php
##                includes/usercp_register.php
##                language/lang_english/lang_main.php
##                templates/subSilver/admin/user_edit_body.tpl
##                templates/subSilver/profile_add_body.tpl
## Included Files: n/a
## Generator: MOD eclipse
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
## Thanks for Selderaya for betatesting and sending me the errors :-)
##############################################################
## MOD History: 
## 
##   2005-08-07 - Version 1.0.0
##      - Initial Release
## 
##   2005-08-22 - Version 1.0.1
##      - Changed some minor faults in the mod
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE phpbb_users ADD user_postspp VARCHAR(4) AFTER user_allowsmile;
ALTER TABLE phpbb_users ADD user_topicspp VARCHAR(4) AFTER user_postspp;

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#
		$allowsmilies = ( isset( $HTTP_POST_VARS['allowsmilies']) ) ? intval( $HTTP_POST_VARS['allowsmilies'] ) : $board_config['allow_smilies'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$postspp = ( !empty($HTTP_POST_VARS['postspp']) ) ? trim(strip_tags( $HTTP_POST_VARS['postspp'] ) ) : '';
		$topicspp = ( !empty($HTTP_POST_VARS['topicspp']) ) ? trim(strip_tags( $HTTP_POST_VARS['topicspp'] ) ) : '';

#
#-----[ FIND ]------------------------------------------
#
			$signature = htmlspecialchars(stripslashes($signature));

#
#-----[ AFTER, ADD ]------------------------------------------
#
			$postspp = htmlspecialchars(stripslashes($postspp));
			$topicspp = htmlspecialchars(stripslashes($topicspp));

#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "user_email =

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_allowsmile = $allowsmilies

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_postspp = '" . str_replace("\'", "''", $postspp) . "', user_topicspp = '" . str_replace("\'", "''", $topicspp) . "'

#
#-----[ FIND ]------------------------------------------
#
		$allowsmilies = $this_userdata['user_allowsmile'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$postspp = htmlspecialchars($this_userdata['user_postspp']);
		$topicspp = htmlspecialchars($this_userdata['user_topicspp']);

#
#-----[ FIND ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="allowsmilies" value="' . $allowsmilies . '" />';

#
#-----[ AFTER, ADD ]------------------------------------------
#
			$s_hidden_fields .= '<input type="hidden" name="postspp" value="' . str_replace("\"", "&quot;", $postspp) . '" />';
			$s_hidden_fields .= '<input type="hidden" name="topicspp" value="' . str_replace("\"", "&quot;", $topicspp) . '" />';

#
#-----[ FIND ]------------------------------------------
#
			'ALWAYS_ALLOW_SMILIES_NO' => (!$allowsmilies) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]------------------------------------------
#
			'POSTS_PER_PAGE' => $postspp,
			'TOPICS_PER_PAGE' => $topicspp,

#
#-----[ FIND ]------------------------------------------
#
			'L_ALWAYS_ALLOW_SMILIES' => $lang['Always_smile'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
			'L_TOPICS_PER_PAGE' => $lang['Topics_per_page'],
			'L_TOPICS_PER_PAGE_EXPLAIN' => $lang['Topics_per_page_explain'],
			'L_POSTS_PER_PAGE' => $lang['Posts_per_page'],
			'L_POSTS_PER_PAGE_EXPLAIN' => $lang['Posts_per_page_explain'],

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#
		if ( isset($userdata['user_timezone']) )
		{
			$board_config['board_timezone'] = $userdata['user_timezone'];
		}

#
#-----[ AFTER, ADD ]------------------------------------------
#
		if ( !empty($userdata['user_postspp']) )
		{
			$board_config['posts_per_page'] = $userdata['user_postspp'];
		}
		
		if ( !empty($userdata['user_topicspp']) )
		{
			$board_config['topics_per_page'] = $userdata['user_topicspp'];
		}

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_avatar.php

#
#-----[ FIND ]------------------------------------------
#
function display_avatar_gallery(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, &$allowsmilies

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, &$postspp, &$topicspp

#
#-----[ FIND ]------------------------------------------
#
	$params = array('coppa'

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, 'allowsmilies'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, 'postspp', 'topicspp'

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
	$strip_var_list = array('username'

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, 'interests' => 'interests'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, 'postspp' => 'postspp', 'topicspp' => 'topicspp'

#
#-----[ FIND ]------------------------------------------
#
		$interests = stripslashes($interests);

#
#-----[ AFTER, ADD ]------------------------------------------
#
		$postspp = stripslashes($postspp);
		$topicspp = stripslashes($topicspp);

#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql .

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_allowsmile = $allowsmilies

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_postspp = '" . str_replace("\'", "''", $postspp) . "', user_topicspp = '" . str_replace("\'", "''", $topicspp) . "'

#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, user_allowsmile

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, user_postspp, user_topicspp

#
#-----[ FIND ]------------------------------------------
#
				VALUES ($user_id

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $allowsmilies

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, '" . str_replace("\'", "''", $postsspp) . "', '" . str_replace("\'", "''", $topicspp) . "'

#
#-----[ FIND ]------------------------------------------
#
	$interests = stripslashes($interests);

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$postspp = stripslashes($postspp);
	$topicspp = stripslashes($topicspp);

#
#-----[ FIND ]------------------------------------------
#
	$allowsmilies = $userdata['user_allowsmile'];

#
#-----[ AFTER, ADD ]------------------------------------------
#
	$postspp = $userdata['user_postspp'];
	$topicspp = $userdata['user_topicspp'];

#
#-----[ FIND ]------------------------------------------
#
	display_avatar_gallery(

#
#-----[ IN-LINE FIND ]------------------------------------------
#
, $allowsmilies

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $postspp, $topicspp

#
#-----[ FIND ]------------------------------------------
#
		'ALWAYS_ALLOW_SMILIES_NO' => ( !$allowsmilies ) ? 'checked="checked"' : '',

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'POSTS_PER_PAGE' => $postspp,
		'TOPICS_PER_PAGE' => $topicspp,

#
#-----[ FIND ]------------------------------------------
#
		'L_ALWAYS_ALLOW_SMILIES' => $lang['Always_smile'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_POSTS_PER_PAGE' => $lang['Posts_per_page'],
		'L_POSTS_PER_PAGE_EXPLAIN' => $lang['Posts_per_page_explain'],
		'L_TOPICS_PER_PAGE' => $lang['Topics_per_page'],
		'L_TOPICS_PER_PAGE_EXPLAIN' => $lang['Topics_per_page_explain'],
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Timezone']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Posts_per_page'] = 'Posts per Page';
$lang['Posts_per_page_explain'] = 'The amount of posts shown per page. Leave it empty for board default.';
$lang['Topics_per_page'] = 'Topics per Page';
$lang['Topics_per_page_explain'] = 'The amount of topics shown per page. Leave it empty for board default.';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_POSTS_PER_PAGE}</span><br />
		<span class="gensmall">{L_POSTS_PER_PAGE_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="postspp" value="{POSTS_PER_PAGE}" maxlength="3" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TOPICS_PER_PAGE}</span><br />
		<span class="gensmall">{L_TOPICS_PER_PAGE_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input class="post" type="text" name="topicspp" value="{TOPICS_PER_PAGE}" maxlength="3" />
	  </td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_POSTS_PER_PAGE}:</span><br />
		<span class="gensmall">{L_POSTS_PER_PAGE_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="text" name="postspp" style="width: 25px" value="{POSTS_PER_PAGE}" maxlength="3" class="post" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TOPICS_PER_PAGE}:</span><br />
		<span class="gensmall">{L_TOPICS_PER_PAGE_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="text" name="topicspp" style="width: 25px" value="{TOPICS_PER_PAGE}" maxlength="3" class="post" />
	  </td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM