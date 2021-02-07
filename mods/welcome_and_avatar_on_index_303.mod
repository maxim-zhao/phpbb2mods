## EasyMod 0.0.9 compliant
############################################################## 
## MOD Title: Welcome & Avatar On phpBB Index
## MOD Author: AbelaJohnB < abela@phpbb.com > (John B. Abela) http://www.JohnAbela.Com/ 
## MOD Description: This MOD will place a 'welcome your_name' and your avatar
##   (if you have one) within the 'who is online' section of the index page.
##   If you do not have an avatar, it will display the default 'whosonline.gif'
##
## MOD Version: 3.0.3
##
## Installation Level: Easy
## Installation Time: ~10 minutes
## Files To Edit: 
##                   index.php
##                   includes/functions.php
##                   language/lang_english/lang_main.php
##                   templates/subSilver/index_body.tpl
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
## I do not support my MOD's anywhere except http://www.phpBB.com/ or my own site,
## (in full or partial format). If you intend to take my work and add to it, you must retain my
## above Copyright and notify me of your actions via email.
##
## ~ John B. Abela - (aka: AbelaJohnB) http://www.johnabela.com/  - abela@phpbb.com
##   Stop By And Sign My Guestbook If You Feel Like It :)
##############################################################
## MOD History:
##
##   2003-07-05 - Version 3.0.3
##      - Added new function to get users template (might be useful for other mod authors!)
##      - Made EasyMod 0.0.9 Compliant, as best as I can tell.
##
##   2003-06-21 - Version 3.0.2
##      - Bug Fix: $profiledata != $userdata <sigh>
##
##   2003-06-17 - Version 3.0.1
##      - Updated for phpBB 2.0.5
##
##   2003-06-09 - Version 3.0.0
##      - Rewrote for phpBB2.0.4+
##
##   2002-05-12 - Version 1.0.0
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
#-----[ OPEN ]------------------------------------------ 
# 
index.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	$template->set_filenames(array(
		'body' => 'index_body.tpl')
	);


# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

    //
    // START MOD: Avatar On Index  - AbelaJohnB
    //
    $avatar_img = '';
    if ( $userdata['user_avatar_type'] && $userdata['user_allowavatar'] )
    {
        switch( $userdata['user_avatar_type'] )
        {
            case USER_AVATAR_UPLOAD:
                $avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
                break;
            case USER_AVATAR_REMOTE:
                $avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
                break;
            case USER_AVATAR_GALLERY:
                $avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
                break;
        }
    }
    if ($avatar_img == '')
    {
        //
        // Set up style
        //
        if ( !$board_config['override_user_style'] )
        {
            if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_style'] > 0 )
            {
                $template_name = get_template_name($board_config['default_style']);
                $avatar_img = '<img src="'. $phpbb_root_path . 'templates/' . $template_name . '/images/whosonline.gif" >';
            }
        }
        else
        {
            $avatar_img = '<img src="templates/subSilver/images/whosonline.gif" >';
        }
    }
    // Check For Anonymous User
    if ($userdata['user_id'] != '-1')
    {
        $name_link = '<a href="' . append_sid("profile.$phpEx?mode=editprofile&amp;amp;" . $userdata['user_id']) . '" />' . $userdata['username'] . '</a>';
    }
    else
    {
        $name_link = $lang['Guest'];
    }
    //
    // END MOD: Avatar On Index  - AbelaJohnB
    //

# 
#-----[ FIND ]------------------------------------------ 
# 

'FORUM_LOCKED_IMG' => $images['forum_locked'],


# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

        //
        // START MOD: Avatar On Index  - AbelaJohnB
        //
        'L_NAME_WELCOME' => $lang['Welcome'],
        'U_NAME_LINK' => $name_link,
        'AVATAR_IMG' => $avatar_img,
        //
        // END MOD: Avatar On Index  - AbelaJohnB
        //

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/functions.php

# 
#-----[ FIND ]------------------------------------------ 
# 
function encode_ip($dotquad_ip)

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

//
// START MOD: Avatar On Index  - AbelaJohnB
//
//
// Get Template Value
//
function get_template_name($style)
{
	global $db, $board_config, $template, $images, $phpbb_root_path;

	$sql = "SELECT template_name 
		FROM " . THEMES_TABLE . "
		WHERE themes_id = $style";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(CRITICAL_ERROR, 'Could not query database for theme info');
	}

	if ( !($row = $db->sql_fetchrow($result)) )
	{
		message_die(CRITICAL_ERROR, "Could not get theme data for themes_id [$style]");
	}
	$template_name = $row['template_name'] ;

	return $template_name;
}
//
// END MOD: Avatar On Index  - AbelaJohnB
//

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['Welcome_subject'] = 'Welcome to %s Forums'; // Welcome to my.com forums

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

//
// START MOD: Avatar On Index  - AbelaJohnB
//
$lang['Welcome'] = "Welcome"; // Welcome
//
// END MOD: Avatar On Index  - AbelaJohnB
//

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/index_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<td class="row1" align="center" valign="middle" rowspan="2"><img src="templates/subSilver/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

<!--
	<td class="row1" align="center" valign="middle" rowspan="2"><img src="templates/subSilver/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>
 -->
	<td class="row1" align="center" valign="middle" rowspan="2"><span class="mainmenu">{L_NAME_WELCOME}</span><BR /><span class="mainmenu">{U_NAME_LINK}</span><BR /><BR />{AVATAR_IMG}</td>


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM