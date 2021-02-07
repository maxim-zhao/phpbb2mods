##############################################################
## MOD Title:           Grouped-Option Jumpbox
## MOD Author:          Weeble < weeble@bushtarion.co.uk > (Alexander House) http://www.alexanderhouse.org/
## MOD Description:     Creates a more aesthetically-pleasing jumpbox
##
## MOD Version:         1.0.1
##
## Installation Level:  Easy
## Installation Time:   5 Minutes
## Files To Edit:       functions.php
##
## Included Files:      (n/a)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##############################################################
## MOD History:
##
##   2004-12-30 : Version 1.0.0
##      - first publication
##   2005-01-08 : Version 1.0.1
##      - mod-template syntax updated and re-submitted
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ OPEN ]------------------------------------------------
#
includes/functions.php
#
#-----[ FIND ]------------------------------------------------
#
<?php
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : grouped-option jumpbox --------------------------------------------------------------
#
#-----[ FIND ]------------------------------------------------
#
        $boxstring = '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"><option value="-1">' . $lang['Select_forum'] . '</option>';
#
#-----[ BEFORE, ADD ]----------------------------------------
#
//-- mod : grouped-option jumpbox --------------------------------------------------------------
// here we replaced
//  forms[\'jumpbox\'].submit() }"><option value="-1">' . $lang['Select_forum'] . '</option>';
// with
//  form.submit() }"><option value="-1">&nbsp;&nbsp;' . $lang['Select_forum'] . '</option>';
//-- modify
#
#-----[ IN-LINE FIND ]----------------------------------------
#
forms[\'jumpbox\'].submit() }"><option value="-1">' . $lang['Select_forum'] . '</option>';
#
#-----[ IN-LINE REPLACE WITH ]--------------------------------
#
form.submit() }"><option value="-1">&nbsp;&nbsp;' . $lang['Select_forum'] . '</option>';
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- fin mod : grouped-option jumpbox ----------------------------------------------------------
#
#-----[ FIND ]------------------------------------------------
#
        if ( $total_forums = count($forum_rows) )
        {
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : grouped-option jumpbox --------------------------------------------------------------
//-- add
            $first_pass = TRUE;

//-- fin mod : grouped-option jumpbox ----------------------------------------------------------
#
#-----[ FIND ]------------------------------------------------
#
                    $boxstring .= '<option value="-1">&nbsp;</option>';
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : grouped-option jumpbox --------------------------------------------------------------
// here we replaced
//  $boxstring .= '<option value="-1">' . $category_rows[$i]['cat_title'] . '</option>';
//  $boxstring .= '<option value="-1">----------------</option>';
// with
//  if ( $first_pass == TRUE )
//  {
//      $boxstring .= '<optgroup label="' . $category_rows[$i]['cat_title'] . '">';
//      $first_pass = FALSE;
//  }
//  else {
//      $boxstring .= '</optgroup>';
//      $boxstring .= '<optgroup label="' . $category_rows[$i]['cat_title'] . '">';
//  }
//-- modify
#
#-----[ FIND ]------------------------------------------------
#
                    $boxstring .= '<option value="-1">' . $category_rows[$i]['cat_title'] . '</option>';
                    $boxstring .= '<option value="-1">----------------</option>';
#
#-----[ REPLACE WITH ]----------------------------------------
#
                    if ( $first_pass == TRUE )
                    {
                        $boxstring .= '<optgroup label="' . $category_rows[$i]['cat_title'] . '">';
                        $first_pass = FALSE;
                    }
                    else {
                        $boxstring .= '</optgroup>';
                        $boxstring .= '<optgroup label="' . $category_rows[$i]['cat_title'] . '">';
                    }
#
#-----[ FIND ]------------------------------------------------
#
                    $boxstring .= $boxstring_forums;
#
#-----[ BEFORE, ADD ]-----------------------------------------
#
//-- fin mod : grouped-option jumpbox ----------------------------------------------------------
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------
#
# EoM