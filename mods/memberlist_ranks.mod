############################################################## 
## MOD Title: Memberlist Rank
## MOD Author: johnl1479 < johnl1479@gmail.com > (John Luetke) http://john.redhedinsanity.net 
## MOD Description: This MOD displays 'User' or 'Moderator' or 'Admin' in the memberlist depending on the user's rank
## MOD Version: 1.0.3
## 
## Installation Level: Easy
## Installation Time: ~5 Minutes 
## Files To Edit: 
##      /language/lang_english/lang_main.php,
##      /templates/subSilver/memberlist_body.tpl, 
##      /memberlist.php 
## Included Files: None
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2 
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
## If you use another template than subSilver, this MOD is still applicable. You
## just need to pay more attention to the code and add to it respectively.
##
## This MOD was created on phpBB version 2.0.17. Support for previous verisons is
## NOT guarunteed
## 
############################################################## 
## MOD History:
##   2005-07-28 - Version 1.0.3
##      - Made even more minor adjustments for acceptance into the MOD database
##   2005-07-28 - Version 1.0.2
##      - Made more minor adjustments for acceptance into the MOD database
##   2005-07-25 - Version 1.0.1
##      - Fixed instruction to accomidate addition to the phpBB MOD database
##      - Is now able to differentiate between 'Mod' and 'Admin'
##   2005-07-25 - Version 1.0.0 
##      - Initial Release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
#
 
/memberlist.php

#
#-----[ FIND ]------------------------------------------
#

'L_POSTS' => $lang['Posts'], 

#
#-----[ AFTER, ADD ]------------------------------------
#

// USER RANKS MOD
  'L_RANK' => $lang['Rank'],
// USER RANKS MOD

# 
#-----[ FIND ]------------------------------------------ 
# 

$sql = "SELECT username, user_id, 
	FROM " . USERS_TABLE . "
	WHERE user_id <> " . ANONYMOUS . "
	ORDER BY $order_by";
	
# 
#-----[ IN-LINE FIND ]----------------------------------
# 

user_regdate,

# 
#-----[ IN-LINE AFTER, ADD ]----------------------------
# 

user_level,
 
# 
#-----[ FIND ]------------------------------------------
# 

$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

# 
#-----[ AFTER, ADD ]------------------------------------
# 

// USER RANKS MOD
  if ($row['user_level'] == ADMIN) {
    $rank = $lang['Rank_admin'];
  }
  elseif ($row['user_level'] == MOD) {
    $rank = $lang['Rank_mod'];
  }
  else {
    $rank = $lang['Rank_user'];
  }
// USER RANKS MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 

/language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
#

$lang['Views'] = 'Views';


#
#-----[ AFTER, ADD ]------------------------------------
# 

// USER RANKS MOD
$lang['Rank'] = 'Rank';
$lang['Rank_admin'] = 'Admin';
$lang['Rank_mod'] = 'Moderator';
$lang['Rank_user'] = 'User';
// USER RANKS MOD

# 
#-----[ OPEN ]------------------------------------------
# 

/templates/subSilver/memberlist_body.tpl

# 
#-----[ FIND ]------------------------------------------
#

<th class="thTop" nowrap="nowrap">{L_POSTS}</th>

# 
#-----[ AFTER, ADD ]------------------------------------
#

<th class="thTop" nowrap="nowrap">{L_RANK}</th>

# 
#-----[ FIND ]-------------------------------------------
#

<td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.POSTS}</span></td>

# 
#-----[ AFTER, ADD ]-------------------------------------
#

<td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.RANK}</span></td>

#
#-----[ FIND ]-------------------------------------------
#

<tr> 
  <td class="catBottom" colspan="{%:1}" height="28">&nbsp;</td> 
</tr> 

# 
#-----[ INCREMENT ]---------------------------------- 
# 

%:1

# 
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
# 
# EoM