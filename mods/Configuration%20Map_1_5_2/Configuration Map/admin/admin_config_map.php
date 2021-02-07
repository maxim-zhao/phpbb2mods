<?php
/***************************************************************************
 *                              admin_config_map.php
 *                            -------------------
 *   begin                : Saturday, August 15, 2004
 *   copyright            : (C) 2004 Shof515
 *   email                : shof515@gmail.com
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

//
// First we do the setmodules stuff for the admin cp.
//
if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Configuration Map'] = $filename;

	return;
}

//
// Load default header
//
$no_page_header = TRUE;
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include('./page_header_admin.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_config_map.'.$phpEx);
//
// Output the authorisation details
//
$template->set_filenames(array(
	'body' => 'admin/configuration_map.tpl')
);

$template->assign_vars(array(
    // Links
        "U_FORUM_INDEX" => append_sid("../index.$phpEx"),
        "U_ADMIN_INDEX" => append_sid("index.$phpEx?pane=right"),
        "U_MANAGE" => append_sid("admin_forums.$phpEx"),
        "U_PREMISSION" => append_sid("admin_forumauth.$phpEx"),
        "U_PRUNE" => append_sid("admin_forum_prune.$phpEx"),
        "U_BACKUP" => append_sid("admin_db_utilities.$phpEx"),
        "U_BOARD" => append_sid("admin_board.$phpEx"),
        "U_MAP" => append_sid("admin_config_map.$phpEx"),
        "U_EMAIL" => append_sid("admin_mass_email.$phpEx"),
        "U_RESTORE" => append_sid("admin_db_utilities.$phpEx?perform=restore"),
        "U_SMILE" => append_sid("admin_smilies.$phpEx"),
        "U_WORD" => append_sid("admin_words.$phpEx"),
        "U_GROUP" => append_sid("admin_groups.$phpEx"),
        "U_GROUPPRE" => append_sid("admin_ug_auth.$phpEx?mode=group"),
        "U_SKIN" =>  append_sid("admin_styles.$phpEx?mode=addnew"),
        "U_MAKE" =>  append_sid("admin_styles.$phpEx?mode=create"),
        "U_EXPORT" =>  append_sid("admin_styles.$phpEx?mode=export"),
        "U_SKINMAN" => append_sid("admin_styles.$phpEx"),
        "U_USERBAN" => append_sid("admin_user_ban.$phpEx"),
        "U_DISALLOW" => append_sid("admin_disallow.$phpEx"),
        "U_USERMAN" => append_sid("admin_users.$phpEx"),
        "U_USERPRE" => append_sid("admin_ug_auth.$phpEx?mode=user"),
        "U_RANK" => append_sid("admin_ranks.$phpEx"),
    // Admin.
        "L_MAP" => $lang['map'],
        "L_MAP_EXPLAIN" => $lang['map_explain'],
        "L_FORUM_INDEX" => $lang['Main_index'],
        "L_ADMIN_INDEX" => $lang['Admin_Index'], 
        "L_PREVIEW_FORUM" => $lang['Preview_forum'],
        "L_INSIDE" => $lang['inside'],
        "L_INSIDE_EXPLAIN" => $lang['inside_explain'],
        "L_USERMANGEMENT" => $lang['usermanagement'],
    // Forums
        "L_FORUM" => $lang['Forums'],
        "L_MANAGE" => $lang['Manage'],
        "L_EDIT_CATEGORY" => $lang['Edit_Category'],
        "L_EDIT_FORUMS" => $lang['Edit_forum'],
        "L_DELETE_FORUMS" => $lang['Delete_forum'],
        "L_RESYNC" => $lang['Resync_move'],
        "L_PREMISSION" => $lang['Premission'], 
        "L_MISSION" => $lang['mission'],
        "L_PRUNING" => $lang['Pruning'],
        "L_PRUNE" => $lang['Prune'],
    // General Admin
        "L_GENERAL" => $lang['General'],
        "L_BACKDATABASE" => $lang['Database_Backup'],
        "L_BACKUP" => $lang['Backup'],
        "L_BOARD" => $lang['Configuration'],
        "L_CONFIG" => $lang['Config'],
        "L_ROADMAP" => $lang['roadmap'],
        "L_EMAIL" => $lang['email'],
        "L_EMAILME" => $lang['emailme'],
        "L_RESTORE" => $lang['restore'],
        "L_RESTOREME" => $lang['restoreme'],
        "L_SMILE" => $lang['smile'],
        "L_BIGSMILE" => $lang['bigsmile'],
        "L_WORD" => $lang['word'],
        "L_BADWORD" => $lang['badword'],
    // Group Admin
        "L_GROUP" => $lang['Groups'],
        "L_GROUPMAN" => $lang['groupman'],
        "L_USERGROUP" => $lang['usergroup'],
        "L_USERPRE" => $lang['grouppre'],
        "L_USERPREMIS" => $lang['groupmis'],
    // Styles Admin
        "L_STYLE" => $lang['Styles'],
        "L_STYLEADD" => $lang['Stylesadd'],
        "L_STYLEIN" => $lang['Stylesin'],
        "L_CREATE" => $lang['Stylesmake'],
        "L_CREATEIN" => $lang['Stylemaking'],
        "L_EXPORT" => $lang['Stylesexport'],
        "L_EXPORTIN" => $lang['Stylexp'],
        "L_SKINMAN" => $lang['Styleman'],
        "L_SKINMANGE" => $lang['Stylemange'],
    // User Admin
        "L_USER" => $lang['Users'],
        "L_USERBAN" => $lang['Usersbann'],
        "L_USERBANING" => $lang['Usersbanning'],
        "L_DISALLOW" => $lang['Usersdisallow'],
        "L_ALLOW" => $lang['Usersallow'],
        "L_USERMAN" => $lang['Usersman'],
        "L_USERMANGE" => $lang['Usersmange'],
        "L_USERPRE" => $lang['Userspre'],
        "L_USERPREMISS" => $lang['Userspremission'],
        "L_RANK" => $lang['Usersrank'],
        "L_RANKSYS" => $lang['Usersranking'],
    // General
        "L_GENERALIST" => $lang['generallist'],
        "L_GENERALBOARD" => $lang['generalboard'],
        "L_DOMAINNAME" => $lang['domainname'],     
        "L_SERVERPORT" => $lang['serverport'],
        "L_SCRIPTPATH" => $lang['scriptpath'],
        "L_SITENAME" => $lang['sitename'],
        "L_SITEDESC" => $lang['sitedesc'],
        "L_DISABLEBOARD" => $lang['disableboard'],
        "L_ACCOUNTACT" => $lang['accountact'],
        "L_EMAILBOARD" => $lang['emailboard'],
        "L_EMAILOTHER" => $lang['emailother'], 
        "L_FLOOD" => $lang['flood'], 
        "L_WAIT" => $lang['wait'], 
        "L_TOPICPAGE" => $lang['topicpage'], 
        "L_POSTPAGE" => $lang['postspage'], 
        "L_POPULARTHRES" => $lang['popularthres'], 
        "L_DEFAULTSTYLE" => $lang['defaultstyle'],
        "L_USERSTYLE" => $lang['userstyle'],
        "L_DEFAULTLANG" => $lang['defaultlang'],
        "L_DATES" => $lang['dates'],
        "L_TIMEZONE" => $lang['timezone'],
        "L_GZIPPING" => $lang['gziping'],
        "L_FORUMPRUNE" => $lang['forumprune'],
    // Cookie
        "L_COOKIE" => $lang['cookie'],
        "L_COOKIEDOMAIN" => $lang['cookiedomain'],
        "L_COOKIENAME" => $lang['cookiename'],
        "L_COOKIEPATH" => $lang['cookiepath'],
        "L_COOKIESECURE" => $lang['cookesecure'],
        "L_COOKIELENTH" => $lang['cookielenth'],
    // Private Message
        "L_PRIVATE" => $lang['private'],
        "L_PRIVBOX" => $lang['privbox'],
        "L_PRIVSENT" => $lang['privsentbox'],
        "L_PRIVSAVE" => $lang['privsavebox'],
    // User Settings
        "L_FORUMSET" => $lang['userforumset'],
        "L_POLLNUMBER" => $lang['pollnumber'],
        "L_HTMLALLOW" => $lang['allowhtml'],
        "L_HTMLTAGES" => $lang['htmltages'],
        "L_BBALLOW" => $lang['allowbbcode'],
        "L_ALLOWSMILE" => $lang['allowsimiles'],
        "L_SIMPLEPATH" => $lang['similepath'],
        "L_ALLOWSIG" => $lang['allowsig'],
        "L_SIGLENGTH" => $lang['siglength'],
        "L_SIGCHAR" => $lang['sigchar'],
        "L_NAMECHANGE" => $lang['namechange'],
    // Avatar
        "L_AVATERSET" => $lang['avaterset'],
        "L_AVATERGALL" => $lang['avatergall'],
        "L_REMOTEAVATER" => $lang['remoteavater'],
        "L_AVATERUP" => $lang['upavater'],
        "L_AVATERSIZE" => $lang['avatersize'],
        "L_AVATERDIM" => $lang['avaterdim'],
        "L_AVATERPATH" => $lang['avaterpath'],
        "L_AVATERGALLPAT" => $lang['avatergallpath'],
    // COPPA
        "L_COPPASET" => $lang['coppaset'],
        "L_COPPAFAX" => $lang['coppafax'],
        "L_COPPAMAIL" => $lang['coppamail'],
    // Email Settings
        "L_EMAILSET" => $lang['setemail'],
        "L_ADMINEMAIL" => $lang['adminemail'],
        "L_EMAILSIG" => $lang['emailsig'],
        "L_MAILSMTP" => $lang['mailsmtp'],
        "L_SMTPSEVER" => $lang['smtpsever'],
        "L_SMTPNAME" => $lang['smtpname'],
        "L_SMTPPASS" => $lang['smtppass'],
    // Reg. Info
        "L_REGINFO" => $lang['regisinfo'],
        "L_REGUSER" => $lang['regusername'],
        "L_USERMAIL" => $lang['useremail'],
        "L_USERPASS" => $lang['userpass'],
        "L_USERPASSCON" => $lang['userpasscon'],
    // Profile Info
        "L_PROFILEINFO" => $lang['profileinfo'],
        "L_ICQNUMBER" => $lang['icqnumber'],
        "L_AIMNAME" => $lang['aimname'],
        "L_MSNMESS" => $lang['msnmess'],
        "L_YAHOOM" => $lang['yahoom'],
        "L_USERSITE" => $lang['uwebsite'],
        "L_LOCATION" => $lang['locat'],
        "L_JOB" => $lang['job'],
        "L_INTREST" => $lang['intrest'],
        "L_SIGN" => $lang['sign'],
    // User Preferences
        "L_PREFERS" => $lang['prefer'],
        "L_SEMAIL" => $lang['show email'],
        "L_ONLINESTAT" => $lang['onlinestatus'],
        "L_NOTIFYME" => $lang['notifyme'],
        "L_NOTIFYPM" => $lang['notifypm'],
        "L_PMPOPUP" => $lang['popuppm'],
        "L_SIGATTACH" => $lang['sigattach'],
        "L_AALLOWBB" => $lang['aallowbb'],
        "L_AALLOWHTML" => $lang['aallowwhtml'],
        "L_AALLOWSMILE" => $lang['aallowsmile'],
        "L_BOARDLANG" => $lang['boardlang'],
        "L_BOARDSTYLE" => $lang['boardstyle'],
        "L_TIMEZONES" => $lang['timezones'],
        "L_DATEFORMAT" => $lang['formatdata'],
    // ProfileAvater
        "L_AVATERCP" => $lang['avatercp'],
        "L_DELTEAVA" => $lang['delteava'],
    // Special Admin-only
        "L_PROFILEADMIN" => $lang['profileadmin'],
        "L_USERACT" => $lang['useract'],
        "L_USERSENDPM" => $lang['sendpm'],
        "L_AVATERSEE" => $lang['seeavater'],
        "L_RANKUSER" => $lang['userankt'],
        "L_DELETEUSER" => $lang['userdelet'],)
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>