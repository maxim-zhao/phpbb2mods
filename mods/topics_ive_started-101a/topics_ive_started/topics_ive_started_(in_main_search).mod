##############################################################
## MOD Title: Topics I've Started (in main search)
## MOD Author: deejay <danieljanesch@gmx.at> (Daniel Janesch) http://www.the-deejay.com/
## MOD Description: This MOD will allow you to have a new page that lists all threads you've started.
## MOD Version: 1.0.1
##
## Installation Level:  Easy
## Installation Time:   ~5 Minutes
## Files To Edit:
##                   includes/page_header.php
##                   templates/subSilver/index_body.tpl
##                   search.php
##                   language/lang_english/lang_main.php
##                   language/lang_german/lang_main.php
## Included Files:
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
## Topics I've Started (in main search) - Copyright © DanielJanesch <danieljanesch@gmx.at>
##
## This MOD is based on the idea of AbelaJohnB which build an own site for the result,
## but this site does not support all styles. I wrote a mode which is added to the
## basic search functionality.
## I do not support my MOD's anywhere except at http://www.phpBB.com/ so please visit there
## for support. If you intend to take my work and modify it, you must retain my above
## Copyright within any install file. This does not mean you have to ask me to -use- this MOD,
## but that does mean you cannot -distribute- this MOD, in modified or non-modified format,
## without my copyright left intact. Contact me at: abela@johnabela.com - www.JohnAbela.Com
##
## ~ Daniel Janesch - danieljanesch@gmx.at - www.the-DeeJay.com
##   http://www.the-DeeJay.com/  - Sign my guestbook if you feel like it :)
##############################################################
## MOD History:
##
##   2003-10-11 - Version 1.0.1
##      - Made some changes because of MOD-DB deny
##
##   2003-08-10 - Version 1.0.0
##      - Initial Release
##
##############################################################
## MOD Localisation:
##
##  $lang['topics_created'] = "Eigene Themen anzeigen"; //  German (original)
##  $lang['topics_created'] = "I soggetti che lei ha cominciato"; //  Italian freetranslation
##  $lang['topics_created'] = "Soggetti che avete iniziato"; //  Italian babel
##  $lang['topics_created'] = "Onderwerpen, die u begonnen bent"; //  Dutch freetranslation
##  $lang['topics_created'] = "Os temas que você começou"; //  Portuguese freetranslation
##  $lang['topics_created'] = "Tópicos que você começou"; //  Portuguese babel
##  $lang['topics_created'] = "Emner De De' startet ve"; //  Norwegian freetranslation
##  $lang['topics_created'] = "Les sujets que vous avez commencé"; //  French freetranslation
##  $lang['topics_created'] = "Matières que vous avez commencées"; //  French babel
##  $lang['topics_created'] = "Los temas que usted ha comenzado"; // Spanish freetranslation
##  $lang['topics_created'] = "Asuntos que usted ha comenzado"; // Spanish babel
##
##  I used both freetranslation.com and babel to do the translation, if they are not correct don't
##  blame me :P For Localisation into a language not listed, or a correctin of the above, please
##  email me at abela@phpbb.com (be sure to include the name of this MOD, as I have multiple
##  MOD's that have Localisation support)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#

includes/page_header.php

#
#-----[ FIND ]-----------------------------------------
#

'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>'),

#
#-----[ AFTER, ADD ]----------------------------------
#

  //
  // MOD - TOPICS I'VE STARTED - deejay
  'L_SEARCH_STARTEDTOPICS' => $lang['topics_created'],
  'U_SEARCH_STARTEDTOPICS' => append_sid('search.'.$phpEx.'?search_id=startedtopics'),
  // MOD - TOPICS I'VE STARTED - deejay
  //

#
#-----[ OPEN ]-----------------------------------------
#

templates/subSilver/index_body.tpl

#
#-----[ FIND ]-----------------------------------------
#

<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br /><a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />

#
#-----[ AFTER, ADD ]-----------------------------------------
#

<!-- // MOD BEGIN - TOPICS I'VE STARTED - deejay -->
<a href="{U_SEARCH_STARTEDTOPICS}" class="gensmall">{L_SEARCH_STARTEDTOPICS}</a><br />
<!-- // MOD END - TOPICS I'VE STARTED - deejay -->

# 
#-----[ OPEN ]----------------------------------------- 
# 

search.php 

# 
#-----[ FIND ]----------------------------------------- 
# 

if ( $search_id == 'newposts' || $search_id == 'egosearch' || $search_id == 'unanswered' || $search_keywords != '' || $search_author != '' ) 

# 
#-----[ IN-LINE FIND ]----------------------------------------- 
# 
$search_id == 'unanswered' 

# 
#-----[ IN-LINE AFTER, ADD ]----------------------------------------- 
# 
 || $search_id == 'startedtopics' 


#
#-----[ FIND ]-----------------------------------------
#

  // Basic requirements
  //
  $show_results = 'topics';
  $sort_by = 0;
  $sort_dir = 'DESC';
}

#
#-----[ AFTER, ADD ]-----------------------------------------
#

// MOD BEGIN - TOPICS I'VE STARTED - deejay
else if ( $search_id == 'startedtopics' )
{
  if ( $auth_sql != '' )
  {
    $sql = "SELECT t.topic_id, f.forum_id
      FROM " . TOPICS_TABLE . "  t, " . FORUMS_TABLE . " f
      WHERE t.topic_poster = " . $userdata['user_id'] . "
        AND t.forum_id = f.forum_id
        AND t.topic_moved_id = 0
        AND $auth_sql";
  }
  else
  {
    $sql = "SELECT topic_id
      FROM " . TOPICS_TABLE . "
      WHERE topic_poster = " . $userdata['user_id'] . "
        AND topic_moved_id = 0";
  }

  if ( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not obtain post ids', '', __LINE__, __FILE__, $sql);
  }

  $search_ids = array();
  while( $row = $db->sql_fetchrow($result) )
  {
    $search_ids[] = $row['topic_id'];
  }
  $db->sql_freeresult($result);

  $total_match_count = count($search_ids);

  //
  // Basic requirements
  //
  $show_results = 'topics';
  $sort_by = 0;
  $sort_dir = 'DESC';
}
// MOD END - TOPICS I'VE STARTED - deejay

#
#------[ OPEN ]--------------------------------------
#

language/lang_english/lang_main.php

#
#------[ FIND ]--------------------------------------
#
?>

#
#------[ BEFORE, ADD ]-----------------------------
#

// MOD - TOPICS I'VE STARTED - deejay
$lang['topics_created'] = "Show own topics";
// MOD - TOPICS I'VE STARTED - deejay

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM