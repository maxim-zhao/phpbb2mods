##############################################################
## MOD Title: Random Style Selection
## MOD Author: DavidIQ < david@davidiq.com > (David Colon) http://www.davidiq.com
## MOD Description: This mod will set a random style for those users with the option configured.
## MOD Version: 1.1.2
##
## Installation Level: Easy
## Installation Time: 5 Minute
## Files To Edit: admin/admin_users.php
##			includes/functions.php,
##			includes/usercp_register.php
##			language/lang_english/lang_main.php
##			templates/subSilver/profile_add_body.tpl
##			templates/subSilver/admin/user_edit_body.tpl
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
## Author Notes: Random style will be selected every 15 minutes for those users wanting this option.
##              Will work with Random Style for Guests MOD.
##############################################################
## MOD History:
##
##   2006-4-26 - Version 1.0.0
##      - Mod creation
##
##   2006-5-2  - Version 1.1.0
##	  - Added MOD to admin user management page
##
##   2006-5-24 - Version 1.1.1
##	  - Made corrections for mod database
##
##   2006-6-28 - Version 1.1.2
##	  - Removed RAND() from sql query statement and used PHP's array_rand() function instead to
##		accomodate for all DMBS's
##
##############################################################
## BEFORE, ADDing This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]------------------------------------------
#
		$user_style = ( isset( $HTTP_POST_VARS['style'] ) ) ? intval( $HTTP_POST_VARS['style'] ) : $board_config['default_style'];

#
#-----[ AFTER, ADD ]------------------------------------------
# 
		//BEGIN Random Style Selection MOD
	  $randomstyle_sel = ( isset($HTTP_POST_VARS['randomstyle']) ) ? ( ($HTTP_POST_VARS['randomstyle']) ? TRUE : 0 ) : 0;
		//END Random Style Selection MOD

#
#-----[ FIND ]------------------------------------------
#
				// We remove all stored login keys since the password has been updated
				// and change the current one (if applicable)

#
#-----[ BEFORE, ADD ]------------------------------------------
# 
				//BEGIN Random Style Selection MOD
		    		if ( $randomstyle_sel == 1 )
				{
					$user_style = 0;
		    		}
				//END Random Style Selection MOD

#
#-----[ FIND ]------------------------------------------
#
		$user_style = $this_userdata['user_style'];

#
#-----[ AFTER, ADD ]------------------------------------------
# 
		//BEGIN Random Style Selection MOD
		if ( $userdata['user_style'] == 0 )
		{
			$randomstyle_sel = 1;
		}
		else
		{
			$randomstyle_sel = 0;
		}
		//END Random Style Selection MOD

#
#-----[ FIND ]------------------------------------------
#
			'STYLE_SELECT' => style_select($user_style, 'style'),

#
#-----[ AFTER, ADD ]------------------------------------------
# 
			//BEGIN Random Style Selection MOD
			'RANDOM_STYLE_SELECT' => ( $randomstyle_sel ) ? 'checked="checked"' : '',
			//END Random Style Selection MOD

#
#-----[ FIND ]------------------------------------------
#
			'L_BOARD_STYLE' => $lang['Board_style'],

#
#-----[ AFTER, ADD ]------------------------------------------
# 
			//BEGIN Random Style Selection MOD
			'L_RANDOM_STYLE_SELECT' => $lang['Random_style_select'],
			//END Random Style Selection MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#
		if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_style'] > 0 )
		{
			if ( $theme = setup_style($userdata['user_style']) )
			{
				return;
			}
		}

#
#-----[ REPLACE WITH ]------------------------------------------
#
		//BEGIN Random Style Selection MOD
		if ( $userdata['user_id'] != ANONYMOUS )
		{
			if (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'].'_rand_style']))
			{
				setcookie($board_config['cookie_name'].'_rand_style', $rand_style, (time()-1));			
			}
			
			if ( $userdata['user_style'] == 0 )
			{
				if (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'].'_rand_style_sel']))
				{
					$theme = setup_style($HTTP_COOKIE_VARS[$board_config['cookie_name'].'_rand_style_sel']);
				}
				else
				{
					global $db;
					$sql = "SELECT themes_id
						FROM " . THEMES_TABLE;

					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(CRITICAL_ERROR, "Could not query database for theme info", "", __LINE__, __FILE__, $sql);
					}
					
					$style_rows = array();
					while ($row = $db->sql_fetchrow($result))
					{
						$style_rows[] = $row['themes_id'];
					}
					$db->sql_freeresult($result);

					$rand_style = array_rand($style_rows);
					$theme = setup_style($style_rows[$rand_style]);
					setcookie($board_config['cookie_name'].'_rand_style_sel', $rand_style, (time()+900), $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']); 
					return;
				}
			}
			else
			{
				if ( $theme = setup_style($userdata['user_style']) )
				{
					return;
				}
			}
		}
		//END Random Style Selection MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
	$user_style = ( isset($HTTP_POST_VARS['style']) ) ? intval($HTTP_POST_VARS['style']) : $board_config['default_style'];

#
#-----[ AFTER, ADD ]------------------------------------------
# 
	//BEGIN Random Style Selection MOD
	$randomstyle_sel = ( isset($HTTP_POST_VARS['randomstyle']) ) ? ( ($HTTP_POST_VARS['randomstyle']) ? TRUE : 0 ) : 0;
	//END Random Style Selection MOD

#
#-----[ FIND ]------------------------------------------
#
				$user_actkey = '';
			}

#
#-----[ AFTER, ADD ]------------------------------------------
# 
			//BEGIN Random Style Selection MOD
		    	if ( $randomstyle_sel == 1 )
			{
				$user_style = 0;
		    	}
			//END Random Style Selection MOD

#
#-----[ FIND ]------------------------------------------
#
	$user_style = $userdata['user_style'];

#
#-----[ AFTER, ADD ]------------------------------------------
# 
	//BEGIN Random Style Selection MOD
	if ( $userdata['user_style'] == 0 )
	{
		$randomstyle_sel = 1;
	}
	else
	{
		$randomstyle_sel = 0;
	}
	//END Random Style Selection MOD

#
#-----[ FIND ]------------------------------------------
#
		'STYLE_SELECT' => style_select($user_style, 'style'),

#
#-----[ AFTER, ADD ]------------------------------------------
# 
		//BEGIN Random Style Selection MOD
		'RANDOM_STYLE_SELECT' => ( $randomstyle_sel ) ? 'checked="checked"' : '',
		//END Random Style Selection MOD

#
#-----[ FIND ]------------------------------------------
#
		'L_BOARD_STYLE' => $lang['Board_style'],

#
#-----[ AFTER, ADD ]------------------------------------------
# 
		//BEGIN Random Style Selection MOD
		'L_RANDOM_STYLE_SELECT' => $lang['Random_style_select'],
		//END Random Style Selection MOD

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!

#
#-----[ BEFORE, ADD ]------------------------------------------
# 
//BEGIN Random Style Selection MOD
$lang['Random_style_select'] = 'Randomize style selection (automatically changed every 15 minutes)';
//END Random Style Selection MOD

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	  <td class="row2"><span class="gensmall">{STYLE_SELECT}</span></td>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
</td>

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
# 
&nbsp;&nbsp;<input type="checkbox" name="randomstyle" {RANDOM_STYLE_SELECT} /><span class="gen">{L_RANDOM_STYLE_SELECT}</span>

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	  <td class="row2">{STYLE_SELECT}</td>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
</td>

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
# 
&nbsp;&nbsp;<input type="checkbox" name="randomstyle" {RANDOM_STYLE_SELECT} /><span class="gen">{L_RANDOM_STYLE_SELECT}</span>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM