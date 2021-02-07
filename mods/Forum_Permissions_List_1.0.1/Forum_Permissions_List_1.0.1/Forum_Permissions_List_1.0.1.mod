############################################################## 
## MOD Title: Forum Permissions List
## MOD Author: Graham < phpbb@grahameames.co.uk > (Graham Eames) http://www.grahameames.co.uk/phpbb/
## MOD Description: This MOD provides a summary listing of the
##    permissions for all of your forums on one screen, with brief
##    tooltip explanations of what that permission setting means,
##    as well as integrated editing of the permissions for either
##    an individual forum, or for an entire category in one go.
##
## MOD Version: 1.0.1
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
## Files To Edit:
##    language/lang_english/lang_admin.php
## Included Files: 
##    admin_forumauth_list.php
##    auth_forum_list_body.tpl
##    auth_cat_body.tpl
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
## Mar 26, 2004 - Version 1.0.1
##  - Security Updates as per phpBB 2.0.8
## Oct 17, 2003 - Version 1.0.0
##  - Initial Release
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy admin_forumauth_list.php to admin/admin_forumauth_list.php 
copy auth_forum_list_body.tpl to templates/subSilver/admin/auth_forum_list_body.tpl 
copy auth_cat_body.tpl to templates/subSilver/admin/auth_cat_body.tpl 

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Permissions'] = 'Permissions';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['Permissions_List'] = 'Permissions List'; // Added by Permissions List MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Auth_Control_Forum'] = 'Forum Permissions Control'; 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['Auth_Control_Category'] = 'Category Permissions Control'; // Added by Permissions List MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Forum_auth_explain'] = 'Here you can alter the authorisation levels of each forum. You will have both a simple and advanced method for doing this, where advanced offers greater control of each forum operation. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
$lang['Forum_auth_list_explain'] = 'This provides a summary of the authorisation levels of each forum. You can edit these permissions, using either a simple or advanced method by clicking on the forum name. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.'; // Added by Permissions List MOD
$lang['Cat_auth_list_explain'] = 'This provides a summary of the authorisation levels of each forum within this category. You can edit the permissions of individual forums, using either a simple or advanced method by clicking on the forum name. Alternatively, you can set the permissions for all the forums in this category by using the drop-down menus at the bottom of the page. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.'; // Added by Permissions List MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Click_return_forumauth'] = 'Click %sHere%s to return to Forum Permissions';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// Added by Permissions List MOD
$lang['Forum_auth_list_explain_ALL'] = 'All users';
$lang['Forum_auth_list_explain_REG'] = 'All registered users';
$lang['Forum_auth_list_explain_PRIVATE'] = 'Only users granted special permission';
$lang['Forum_auth_list_explain_MOD'] = 'Only moderators of this forum';
$lang['Forum_auth_list_explain_ADMIN'] = 'Only administrators';

$lang['Forum_auth_list_explain_auth_view'] = '%s can view this forum';
$lang['Forum_auth_list_explain_auth_read'] = '%s can read posts in this forum';
$lang['Forum_auth_list_explain_auth_post'] = '%s can post in this forum';
$lang['Forum_auth_list_explain_auth_reply'] = '%s can reply to posts this forum';
$lang['Forum_auth_list_explain_auth_edit'] = '%s can edit posts in this forum';
$lang['Forum_auth_list_explain_auth_delete'] = '%s can delete posts in this forum';
$lang['Forum_auth_list_explain_auth_sticky'] = '%s can post sticky topics in this forum';
$lang['Forum_auth_list_explain_auth_announce'] = '%s can post announcements in this forum';
$lang['Forum_auth_list_explain_auth_vote'] = '%s can vote in polls in this forum';
$lang['Forum_auth_list_explain_auth_pollcreate'] = '%s can create polls in this forum';
// End addition by Permissions List MOD

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 