################################################################# 
## MOD Title: Last Visit
## MOD Author: Debillus < debillus.joker@gmail.com > (Thomas Kraft) http://www.mistmoore.net 
## MOD Description: 
##		
##	This MOD adds an extra column to the memberlist, next to the 'joined'
##	column, showing the date of a users last login.
##	It also adds 'Last Visit' as an option to the sorting drilldown. 
##
##	If a user has chosen to hide hos or her online status, the date will be
##	replaced with 'n/a'. Otherwise the date of the last registered login will
##      be shown, or 'Never' if no login has been recorded. 
##	The 'n/a' restriction doesn't apply to administrators and moderators.
##
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 5-10 Minutes 
## Files To Edit: 
##		templates/subSilver/memberlist_body.tpl
##		language/lang_english/lang_main.php
##		memberlist.php
##
## Included Files: none
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
##	You can use this modification to sort out inactive users and users that 
##	never logged in after registering (typically spambots). 
##	
############################################################## 
## MOD History: 
## 
##   2007-01-18 - Version 1.0.0
##      - Final Release Version
##	- MOD header updated, otherwise no changes from 0.9.1 BETA
##   2007-01-17 - Version 0.9.1 BETA
##	- The column will now display 'Never' instead of 1/1-1970.
##	- The column will now display 'n/a' for users hiding their online status.
##	- (Moderators and Administrators will still see the date)
##   2007-01-16 - Version 0.9.0 BETA
##	- beta release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################


# 
#-----[ OPEN ]--------------------------------------------- 
# 
memberlist.php

#
#-----[ FIND ]---------------------------------------------
# 
$mode_types_text = array(

# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
array($lang['Sort_Joined']

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
, $lang['Sort_Last_Visit']

#
#-----[ FIND ]---------------------------------------------
# 
$mode_types = array(

# 
#-----[ IN-LINE FIND ]--------------------------------- 
# 
'joined'

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
, 'last_visit'

#
#-----[ FIND ]---------------------------------------------
# 
	'L_JOINED' => $lang['Joined'], 

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
	'L_LAST_VISIT' => $lang['Last_Visit'],

#
#-----[ FIND ]---------------------------------------------
# 
	case 'joined':
		$order_by = "user_regdate $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
	case 'last_visit' :
		$order_by = "user_lastvisit $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;		

#
#-----[ FIND ]---------------------------------------------
#
$sql = "SELECT username, user_id,

#
#-----[ IN-LINE FIND ]--------------------------------- 
# 
user_regdate

# 
#-----[ IN-LINE AFTER, ADD ]--------------------------------- 
# 
, user_lastvisit, user_allow_viewonline

#
#-----[ FIND ]---------------------------------------------
# 
		$joined = create_date($lang['DATE_FORMAT'], $row['user_regdate'], $board_config['board_timezone']);

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
		if ( $row['user_allow_viewonline'] || $userdata['user_level'] == MOD || $userdata['user_level'] == ADMIN )
		{
			if ( $row['user_lastvisit'] != 0 )
			{
				$last_visit = create_date($lang['DATE_FORMAT'], $row['user_lastvisit'], $board_config['board_timezone']);
			}
			else
			{
				$last_visit = $lang['Never'];
			}
		}
		else
		{
			$last_visit = $lang['n/a'];
		}

#
#-----[ FIND ]---------------------------------------------
#
			'JOINED' => $joined,

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
			'LAST_VISIT' => $last_visit,

# 
#-----[ OPEN ]--------------------------------------------- 
# 
language/lang_english/lang_main.php

#
#-----[ FIND ]---------------------------------------------
# 
$lang['Joined'] = 'Joined';

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
$lang['Last_Visit'] = 'Last Visit';
$lang['Never'] = 'Never';
$lang['n/a'] = 'n/a';

#
#-----[ FIND ]---------------------------------------------
# 
$lang['Sort_Joined'] = 'Joined Date';

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
$lang['Sort_Last_Visit'] = 'Last Visit';

# 
#-----[ OPEN ]--------------------------------------------- 
# 
templates/subSilver/memberlist_body.tpl

#
#-----[ FIND ]---------------------------------------------
# 
	<th class="thTop" nowrap="nowrap">{L_JOINED}</th>

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
	<th class="thTop" nowrap="nowrap">{L_LAST_VISIT}</th>

#
#-----[ FIND ]---------------------------------------------
#
	<td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{memberrow.JOINED}</span></td>

#
#-----[ AFTER, ADD ]---------------------------------------------
# 
	<td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gensmall">{memberrow.LAST_VISIT}</span></td>	  

#
#-----[ FIND ]---------------------------------------------
#
	<td class="catBottom" colspan="8" height="28">&nbsp;</td>

#
#-----[ REPLACE WITH ]---------------------------------------------
# 
	<td class="catBottom" colspan="9" height="28">&nbsp;</td>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 

# EoM