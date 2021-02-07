############################################################## 
## MOD Title: Random User (On Forum Index)
## MOD Author: AbelaJohnB <abela@phpbb.com> (John B. Abela) http://www.johnabela.com/
## MOD Description: This MOD will add a random user to your forum index, directly below
##                   the 'newest member section.
## MOD Version: 1.0.2
## 
## Installation Level:  Easy
## Installation Time:   ~5 Minutes 
## Files To Edit: 
##                   index.php
##                   templates/subSilver/index_body.tpl
##                   langauge/lang_english/lang_main.php
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
## Copyright © John B. Abela, < abela@johnabela.com >
##
## I do not allow distribution of my MOD's anywhere except http://www.phpBB.com/ or my own site,
## (in full or partial format). If you intend to take my work and add to it, you must retain my above
## Copyright and notify me of your actions via email. http://www.johnabela.com/  - abela@phpbb.com
## This does not mean you have to ask me to -use- this MOD, but that does mean you cannot -distribute-
## this MOD without my direct and express permission!
##
## ~ John B. Abela
##   http://www.JohnAbela.Com/  - Sign my guestbook if you feel like it :)
##############################################################
## MOD History:
##
##   2003-06-17 - Version 1.0.2
##      - Updated for phpBB 2.0.5
##
##   2003-01-01 - Version 1.0.1
##      - Rewrote for phpBB2.0.4+
##
##   2002-12-01 - Version 1.0.0
##      - Initial Release
##############################################################
## MOD Localisation:
##
##  N/A
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]-------------------------------------
#
index.php

#
#-----[ FIND ]-------------------------------------
#

$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $forum_data);

#
#-----[ AFTER, ADD ]-------------------------------------
#

    // MOD - RANDOM USER MOD - AbelaJohnB
    function random_user()
    {
        global $db;

    $sql = "SELECT user_id, username
                FROM " . USERS_TABLE . " 
                    WHERE user_active = '1' 
                    AND user_id <> " . ANONYMOUS . "
                ORDER BY RAND() LIMIT 1";
        if ( !($result = $db->sql_query($sql)) )
        {
		    message_die(GENERAL_ERROR, 'Could not query random user data.', '', __LINE__, __FILE__, $sql);
        }
        return ( $row = $db->sql_fetchrow($result) ) ? $row : false;
    }
    $profiledata = random_user();
    $random_link = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=".$profiledata['user_id']."") . '">'. $profiledata['username']. '</a>';
    // MOD - RANDOM USER MOD - AbelaJohnB

#
#-----[ FIND ]-------------------------------------
#

'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),

#
#-----[ BEFORE, ADD ]-------------------------------------
#

        // MOD - RANDOM USER MOD - AbelaJohnB
    	'L_RANDOM_USER' => $lang['Random_user'],
        'RANDOM_USER_LINK' => $random_link, 
        // MOD - RANDOM USER MOD - AbelaJohnB

#
#-----[ OPEN ]------------------------------------- 
#

templates/subSilver/index_body.tpl 

# 
#-----[ FIND ]------------------------------------- 
# 

<td class="row1" align="left" width="100%"><span class="gensmall">{TOTAL_POSTS}<br />{TOTAL_USERS}<br />{NEWEST_USER}</span>

# 
#-----[ IN-LINE FIND ]------------------------------------- 
# 

{NEWEST_USER}

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------- 
# 

<br />{L_RANDOM_USER} {RANDOM_USER_LINK}<br />
	
# 
#-----[ OPEN ]------------------------------------------ 
#

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
#

$lang['Newest_user'] = 'The newest registered user is <b>%s%s%s</b>'; // a href, username, /a

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

// MOD - RANDOM USER MOD - AbelaJohnB
$lang['Random_user'] = 'A random user is: ';
// MOD - RANDOM USER MOD - AbelaJohnB


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM