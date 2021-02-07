############################################################## 
## MOD Title: Cat Index Alternative
## MOD Author: netclectic < adrian@netclectic.com > (Adrian Cockburn) http://www.netclectic.com 
## MOD Description: This mod will enable you to 
##                      a) view single categories on the forums index 
##                          e.g. index.php?c=1 will show only the first category
##
##                      b) disable individual categories from appearing on the forums index
##                          (this is set by Editing the category in the admin control panel)
##
## MOD Version: 1.0.1
## 
## Installation Level: moderate
## Installation Time: 10 Minutes 
## Files To Edit: (4) index.php, lang_admin.php, admin_forums.php, category_edit_body.tpl
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##
##      Includes one database alteration - Add field to phpbb categories table
## 
############################################################## 
## MOD History:
##
##   2003-08-11 - 1.0.1
##      - confirmed on 2.0.6
##
##   2003-01-01 - 1.0.0   
##      - Initial Release
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------- 
# 
ALTER TABLE phpbb_categories ADD include_on_index TINYINT( 1 ) DEFAULT '1' NOT NULL

# 
#-----[ OPEN ]------------------------------------------ 
# 
index.php

# 
#-----[ FIND ]------------------------------------------ 
#  
// Start page proper
//

# 
#-----[ AFTER, ADD ]------------------------------------
#  
$cat_sql = ($viewcat == -1) ? ' WHERE c.include_on_index = 1 ' : " WHERE c.cat_id = $viewcat ";
$f_w_cat_sql = ($viewcat != -1) ? " WHERE f.cat_id = $viewcat " : '';
$f_a_cat_sql = ($viewcat != -1) ? " AND f.cat_id = $viewcat " : '';

# 
#-----[ FIND ]------------------------------------------ 
#  
$sql = "SELECT c.cat_id, c.cat_title, 

# 
#-----[ IN-LINE FIND ]---------------------------------- 
#  
c.cat_order

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------- 
#  
, c.include_on_index 

# 
#-----[ FIND ]------------------------------------------ 
#  
FROM " . CATEGORIES_TABLE . " c

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
    $cat_sql

# 
#-----[ FIND ]------------------------------------------ 
#  
$page_title = $lang['Index'];

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
    if ( ($viewcat > 0) && ($total_categories > 0) ) 
    {
    	$page_title = $category_rows[0]['cat_title'];
    }
    
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
#  
//
// That's all Folks!

# 
#-----[ BEFORE, ADD ]----------------------------------- 
#  
// MOD - Cat Index Alternative
$lang['Category_Include_On_Index'] = 'Include on index';

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_forums.php

# 
#-----[ FIND ]------------------------------------------ 
#  
			$next_order = $max_order + 10;

			//
			// There is no problem having duplicate forum names so we won't check for it.
			//

# 
#-----[ AFTER, ADD ]------------------------------------ 
#  
            $include_on_index = isset($HTTP_POST_VARS['cat_on_index']) ? intval($HTTP_POST_VARS['cat_on_index']) : 1;
            
# 
#-----[ FIND ]------------------------------------------ 
#  
$sql = "INSERT INTO " . CATEGORIES_TABLE 

# 
#-----[ IN-LINE FIND ]---------------------------------- 
#  
, cat_order

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------- 
#  
, include_on_index

# 
#-----[ FIND ]------------------------------------------ 
#  
VALUES ('" . str_replace("\'", "''", $HTTP_POST_VARS['categoryname'])

# 
#-----[ IN-LINE FIND ]---------------------------------- 
#  
, $next_order

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------- 
#  
, $include_on_index

# 
#-----[ FIND ]------------------------------------------ 
#  
$cat_title = $row['cat_title'];

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
			$cat_on_index = $row['include_on_index'];
            $e_selected[$cat_on_index] = ' selected="selected"';
            $cat_on_index_select = '<select name="cat_on_index">';
            $cat_on_index_select .= '<option value="0"' . $e_selected[0] . '>' . $lang['No'] . '</option>';
            $cat_on_index_select .= '<option value="1"' . $e_selected[1] . '>' . $lang['Yes'] . '</option>';
            $cat_on_index_select .= '</select>';

# 
#-----[ FIND ]------------------------------------------ 
#  
'CAT_TITLE' => $cat_title,
            
# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
				'CAT_ON_INDEX_SELECT' => $cat_on_index_select,

# 
#-----[ FIND ]------------------------------------------ 
#  
'L_CATEGORY' => $lang['Category'], 

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
				'L_CAT_INCLUDE_ON_INDEX' => $lang['Category_Include_On_Index'], 

# 
#-----[ FIND ]------------------------------------------ 
#  
		case 'modcat':
			// Modify a category in the DB

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
            $include_on_index = isset($HTTP_POST_VARS['cat_on_index']) ? intval($HTTP_POST_VARS['cat_on_index']) : 1;

# 
#-----[ FIND ]------------------------------------------ 
#  
SET cat_title = '" . str_replace("\'"

# 
#-----[ IN-LINE FIND ]---------------------------------- 
#  
$HTTP_POST_VARS['cat_title']) . "'

# 
#-----[ IN-LINE AFTER, ADD ]---------------------------- 
#  
, include_on_index = $include_on_index 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/category_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
#  
	<tr> 
	  <td class="row1">{L_CATEGORY}</td>
	  <td class="row2"><input class="post" type="text" size="25" name="cat_title" value="{CAT_TITLE}" /></td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
	<tr> 
	  <td class="row1">{L_CAT_INCLUDE_ON_INDEX}</td>
	  <td class="row2">{CAT_ON_INDEX_SELECT}</td>
	</tr>
                
    
# 
#-----[ SAVE/CLOSE ALL FILES ]-------------------------- 
# 
# EoM 
