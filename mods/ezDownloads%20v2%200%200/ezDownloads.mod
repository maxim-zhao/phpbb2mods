############################################################## 
## MOD Title:    ezDownloads
## MOD Author:   HerrBawl < admin@herrbawl.com > (HerrBawl) http://www.herrbawl.com
## MOD Description:  This mod will create a Downloads page that dynamically pulls
##   		 	attachments from posts in specified forums using forum names as 
##			category headers and using the post title as sub categories with
##			all of the attachments in that post listed below it.
## MOD Version: 2.0.0 
## 
## Installation Level:  Easy
## Installation Time:   ~1 Minute
## Files To Edit: includes/page_header.php,
##		language/lang_english/lang_main.php,
##		templates/subSilver/overall_header.tpl
## Included Files: ezdloads.php,
##		templates/subSilver/ezdloads_body.tpl,
##		templates/subSilver/images/icon_mini_dload.gif
##
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: (IMPORTANT) You must have Acyd Burn's Attachment Mod.
##			After you have uploaded all of the files and followed
##			the mod instructions below you need to edit ezdloads.php
##			and change $CFG['dload_forum'] = '1'; to point to the forum
##			id's that you want ezDownloads to pulls attachments from.
## INSTALLATION:
## This MOD has been tested with Acyd Burn's Attachment Mod v 2.3.10 and
## phpBB v 2.0.10 ONLY, so I don't know if it will work with other versions.
############################################################## 
## MOD History:
##    2004-09-10 - v. 2.0.0 Rewrote MOD to change the look of the 
##				ezdloads.php page. Also removed a few bugs
##				and made it so that it uses the forum name
##				as the category with the post title as a 
##				sub category, and corrected some syntax
##				per the phpBB group.
##    2004-09-07 - v. 1.0.0 Original creation of MOD
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ COPY ]-------------------------------------------------------
#

copy phpbb_root/ezdloads.php to ezdloads.php
copy phpbb_root/templates/subSilver/ezdloads_body.tpl to templates/subSilver/ezdloads_body.tpl
copy phpbb_root/templates/subSilver/images/icon_mini_dload.gif to templates/subSilver/images/icon_mini_dload.gif

# 
#-----[ OPEN ]------------------------------------------ 
#

includes/page_header.php

# 
#-----[ FIND ]------------------------------------------ 
# 

	'L_SEARCH' => $lang['Search'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	'L_DOWNLOADS' => $lang['Download'],

# 
#-----[ FIND ]------------------------------------------ 
# 

	'U_SEARCH' => append_sid('search.'.$phpEx),

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	'U_DOWNLOADS' => append_sid('ezdloads.'.$phpEx),

# 
#-----[ OPEN ]------------------------------------------ 
#

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// That's all, Folks!
// -------------------------------------------------

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// ezDownloads MOD
$lang['File_Name'] = 'File Name';
$lang['File_Description'] = 'File Description';
$lang['Uploaded_On'] = 'Uploaded';
$lang['Download_Count'] = 'Downloaded';
$lang['View_File_Comments'] = 'Comments';
$lang['Add_File_Comments'] = 'Add/View';
$lang['Downloads'] = 'Downloads Page';
$lang['Download'] = 'Downloads';
$lang['No_Downloads'] = 'No Downloads Are Currently Available';

# 
#-----[ OPEN ]------------------------------------------ 
#

templates/subSilver/overall_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<a href="{U_SEARCH}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH}</a>&nbsp; &nbsp;

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

{L_SEARCH}</a>&nbsp; &nbsp;

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

<a href="{U_DOWNLOADS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_dload.gif" width="12" height="13" border="0" alt="{L_DOWNLOADS}" hspace="3" />{L_DOWNLOADS}</a>&nbsp; &nbsp;

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 