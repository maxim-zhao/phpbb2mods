##############################################################
## MOD Title: BBCode in forum Description
## MOD Author: eviL3 < evil@phpbbmodders.com > (Igor Wiedler) http://phpbbmodders.com/
## MOD Description: This MOD will allow the use of Smilies and BBCode in the forum's description.
##
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 5 minutes
## Files To Edit: index.php
##                admin/admin_forums.php
##                includes/bbcode.php
##                language/lang_english/lang_admin.php
##                templates/subSilver/admin/forum_edit_body.tpl
##
## Included Files: (n/a)
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
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE phpbb_forums ADD forum_use_bbcode TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD forum_bbcode_uid CHAR(10) DEFAULT '0' NOT NULL;

#
#-----[ OPEN ]------------------------------------------
#
index.php

#
#-----[ FIND ]------------------------------------------
#
$row_class =

#
#-----[ AFTER, ADD ]------------------------------------------
#
              // Forum BBCode Description
              $forum_desc = $forum_data[$j]['forum_desc'];
              if ( $forum_data[$j]['forum_use_bbcode'] == true )
              {
                include_once($phpbb_root_path . "includes/bbcode.$phpEx");
                $desc_uid     = $forum_data[$j]['forum_bbcode_uid'];
                $forum_desc   = bbencode_first_pass( $forum_desc, $desc_uid );
                $forum_desc   = bbencode_second_pass ( $forum_desc, $desc_uid );
                $forum_desc   = smilies_pass ( $forum_desc );
                $forum_desc   = str_replace("\n", "\n<br />\n", $forum_desc);
              }
              // Forum BBCode Description

#
#-----[ FIND ]------------------------------------------
#
$forum_data[$j]['forum_desc']

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$forum_data[$j]['forum_desc']

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$forum_desc

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_forums.php

# 
#-----[ FIND ]------------------------------------------ 
#
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
include_once($phpbb_root_path . "includes/bbcode.$phpEx");

# 
#-----[ FIND ]------------------------------------------ 
# 
				'S_PRUNE_ENABLED' => $prune_enabled,

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
				// Forum BBCode Description
        'S_BBCODE_ENABLED' => ( isset($row) && isset($row['forum_use_bbcode']) && ($row['forum_use_bbcode'] == 0) ) ? '' : 'checked="checked"',

# 
#-----[ FIND ]------------------------------------------ 
# 
				'L_DAYS' => $lang['Days'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
				// Forum BBCode Description
        'L_USE_BBCODE' => $lang['Forum_use_bbcode'],

# 
#-----[ FIND ]------------------------------------------ 
# 
prune_enable" . $field_sql

# 
#-----[ IN-LINE FIND  ]------------------------------------------ 
# 
prune_enable

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# (before the " )
#
, forum_use_bbcode, forum_bbcode_uid

# 
#-----[ FIND ]------------------------------------------ 
# 
intval($HTTP_POST_VARS['prune_enable']) . $value_sql

# 
#-----[ IN-LINE FIND  ]------------------------------------------ 
# 
intval($HTTP_POST_VARS['prune_enable'])

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# (before the . )
#
 . ", " . intval($HTTP_POST_VARS['forum_use_bbcode']) . ", '" . make_bbcode_uid() . "'"

# 
#-----[ FIND ]------------------------------------------ 
# 
prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 
, forum_use_bbcode = " . intval($HTTP_POST_VARS['forum_use_bbcode']) . ", forum_bbcode_uid = '" . make_bbcode_uid() . "'

# 
#-----[ FIND ]------------------------------------------ 
# 
// Start page proper

# 
#-----[ FIND ]------------------------------------------ 
# 
$forum_id = $forum_rows[$j]['forum_id'];

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
      // Forum BBCode Description
      $forum_desc = $forum_rows[$j]['forum_desc'];
      if ( $forum_rows[$j]['forum_use_bbcode'] == true )
      {
        $desc_uid     = $forum_rows[$j]['forum_bbcode_uid'];
        $forum_desc   = bbencode_first_pass( $forum_desc, $desc_uid );
        $forum_desc   = bbencode_second_pass ( $forum_desc, $desc_uid );
        $forum_desc   = smilies_pass ( $forum_desc, '../' );
        $forum_desc   = str_replace("\n", "\n<br />\n", $forum_desc);
      }
      // Forum BBCode Description

# 
#-----[ FIND ]------------------------------------------ 
# 
$forum_rows[$j]['forum_desc']

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
$forum_rows[$j]['forum_desc']

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
$forum_desc

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php

# 
#-----[ FIND ]------------------------------------------ 
# 
function smilies_pass

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
)

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 
, $path = false

# 
#-----[ FIND ]------------------------------------------ 
# 
$board_config['smilies_path']

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
$board_config['smilies_path']

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 
$path . 

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['prune_freq']

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// Forum BBCode Description
$lang['Forum_use_bbcode'] = 'Parse BBCode in Description';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/forum_edit_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	<tr> 
	  <td class="row1">{L_USE_BBCODE}</td>
	  <td class="row2">{L_ENABLED}<input type="checkbox" name="forum_use_bbcode" value="1" {S_BBCODE_ENABLED} /></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
