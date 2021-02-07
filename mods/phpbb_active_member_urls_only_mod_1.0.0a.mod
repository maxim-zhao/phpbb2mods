############################################################## 
## MOD Title: Anti-Spam: Only Active Members Can Post URLs
## MOD Author: calamus77 < N/A > (Kevin Nelson) http://www.flashfiredesigns.com/
## MOD Description: 
##     Members must be registered for at least X days and have
##     more than Y posts (configurable on the admin config page)
##     before they can post URLs. Guest user can never post URLs
##
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: ~5 Minutes 
## Files To Edit:
##          language/lang_english/lang_main.php
##          language/lang_english/lang_admin.php
##          posting.php
##          admin/admin_board.php
##          templates/subSilver/admin/board_config_body.tpl
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
## Author Notes: 
##
##    Very simply, you can require that a poster be a member of
##    the site for a certain number of days and/or require them
##    to have a certain number of posts already before allowing
##    them to post URLs to the site.  This should help reduce
##    links being posted by spambots, since they will have to
##    wait days or post posts with no links in them before they
##    will be able to post any links.
##
##    The code checks to see if the user has past the "trial
##    period" of days and posts.  If they do not, then it does
##    a regular expression check to see if certain strings are
##    in the text.  The code is currently setup to block the
##    following strings:
##    "url", "http", "www", ".com", ".us", ".net", ".biz"
##    ".info", ".org", ".ru", and ".su"
##
##    So, sitename.com and [url]mysite[/url] will both fail.
##
##    UPGRADE Notes:
##
##    The patch only affects posting.php, so if you have already
##    installed version 1.0.0, you only need to follow the MOD
##    for that page
############################################################## 
## MOD History:
##
##   2006-12-28 - Version 1.0.0 PATCHED
##      - Fixed regular expression match so that "www" and "url"
##        wouldn't block users from being able to type "ewwwww"
##        or "curl", and so that the URL expression was case-
##        insensitive so that Http://wWw.site.Com wouldn't
##        get through.
##   2006-10-30 - Version 1.0.0 
##      - Submitted for release
##   2006-10-19 - Version 0.0.2 
##      - Just added more "Author Notes" above
##   2006-10-18 - Version 0.0.2 
##      - Added ability for admin to modify configuration for
##        days from registration and number of posts required
##        before URL postings are allowed
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ SQL ]------------------------------------------ 
# 
INSERT INTO phpbb_config (config_name, config_value) VALUES ('url_post_days', '7');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('url_post_posts', '10');
# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
<?php
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//-- mod : Active-Member-URLs-Only -----------------------------------------------------

# 
#-----[ FIND ]------------------------------------------ 
# 
?>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
//-- mod : Active-Member-URLs-Only -----------------------------------------------------
//-- add
$lang['url_active_only_message']    = "In order to try to prevent spammers, we do not allow our users to post URLs in any form until they have posted at least %d legitimate posts and have been with us for more than %d days.  We appreciate your understanding in this matter in order to help us eliminate spam from this forum.  If you have somehow gotten this message even though you meet both of the criteria, please let us know ASAP.<br /><br />Thanks!";
//-- fin mod : Active-Member-URLs-Only -------------------------------------------------
# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
<?php
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//-- mod : Active-Member-URLs-Only -----------------------------------------------------

# 
#-----[ FIND ]------------------------------------------ 
# 
?>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
//-- mod : Active-Member-URLs-Only -----------------------------------------------------
//-- add
$lang['url_post_settings'] = "URL Posting Settings";
$lang['url_post_days'] = "Required Days of Membership";
$lang['url_post_days_explain'] = "Number of days a user must be a member before they can post URLs";
$lang['url_post_posts'] = "Required Number of Posts";
$lang['url_post_posts_explain'] = "Number of times a user must post (without URLs) before URLs are allowed";
//-- fin mod : Active-Member-URLs-Only -------------------------------------------------
# 
#-----[ OPEN ]------------------------------------------ 
#
posting.php

# 
#-----[ FIND ]------------------------------------------ 
# 
<?php
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//-- mod : Active-Member-URLs-Only -----------------------------------------------------
# 
#-----[ FIND ]------------------------------------------ 
# 
//
// End session management
//
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//-- mod : Active-Member-URLs-Only -----------------------------------------------------
//-- add
if( $submit && (($userdata['user_regdate']+intval($board_config['url_post_days'])*86400) >= time() || $userdata['user_posts'] <= intval($board_config['url_post_posts']) || $userdata['user_id']==ANONYMOUS) )
{
    if( preg_match("/(\burl\b|http|\bwww\.|\.(com|us|net|biz|info|org|ru|su)\b)/i",$HTTP_POST_VARS['message']) )
    {
        message_die(GENERAL_ERROR, sprintf($lang['url_active_only_message'],intval($board_config['url_post_posts']),intval($board_config['url_post_days'])));
    }
}
//-- fin mod : Active-Member-URLs-Only -------------------------------------------------
# 
#-----[ OPEN ]------------------------------------------ 
#
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 
<?php
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//-- mod : Active-Member-URLs-Only -----------------------------------------------------
# 
#-----[ FIND ]------------------------------------------ 
# 
    "S_CONFIG_ACTION" => append_sid("admin_board.$phpEx"),
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
//-- mod : Active-Member-URLs-Only -----------------------------------------------------
//-- add
    "L_URL_POST_SETTINGS" => $lang['url_post_settings'],
    "L_URL_POST_DAYS" => $lang['url_post_days'],
    "L_URL_POST_DAYS_EXPLAIN" => $lang['url_post_days_explain'],
    "URL_POST_DAYS" => $new['url_post_days'],
    "L_URL_POST_POSTS" => $lang['url_post_posts'],
    "L_URL_POST_POSTS_EXPLAIN" => $lang['url_post_posts_explain'],
    "URL_POST_POSTS" => $new['url_post_posts'],
//-- fin mod : Active-Member-URLs-Only -------------------------------------------------
# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<h1>{L_CONFIGURATION_TITLE}</h1>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
<!-- mod : Active-Member-URLs-Only ------------------------------------------------- -->

# 
#-----[ FIND ]------------------------------------------ 
# 
    <tr>
        <td class="row1">{L_SMTP_PASSWORD}<br /><span class="gensmall">{L_SMTP_PASSWORD_EXPLAIN}</span></td>
        <td class="row2"><input class="post" type="password" name="smtp_password" value="{SMTP_PASSWORD}" size="25" maxlength="255" /></td>
    </tr>
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
<!-- mod : Active-Member-URLs-Only ------------------------------------------------- -->
<!-- add -->
    <tr>
      <th class="thHead" colspan="2">{L_URL_POST_SETTINGS}</th>
    </tr>
    <tr>
        <td class="row1">{L_URL_POST_DAYS}<br /><span class="gensmall">{L_URL_POST_DAYS_EXPLAIN}</span></td>
        <td class="row2"><input class="post" type="text" name="url_post_days" value="{URL_POST_DAYS}" size="25" maxlength="5" /></td>
    </tr>
    <tr>
        <td class="row1">{L_URL_POST_POSTS}<br /><span class="gensmall">{L_URL_POST_POSTS_EXPLAIN}</span></td>
        <td class="row2"><input class="post" type="text" name="url_post_posts" value="{URL_POST_POSTS}" size="25" maxlength="5" /></td>
    </tr>
<!-- fin mod : Active-Member-URLs-Only --------------------------------------------- -->
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM