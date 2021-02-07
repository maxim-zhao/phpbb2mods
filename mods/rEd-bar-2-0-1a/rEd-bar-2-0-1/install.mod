############################################################## 
## MOD Title: rEd bar 2
## MOD Author: cherokee ced < cherokeered@cherokeered.co.uk > (Kenny Cameron) http://www.cherokeered.co.uk
##
## MOD Description: Places a links/navigation bar along the top and bottom of your forums (header & footer), which can be easily updated via the ACP :) 
## MOD Version: 2.0.1
## 
## Installation Level: Easy 
## Installation Time: ~5 Minutes (or 1min with Nuttzy's amazing EasyMod)
## Files To Edit: includes/page_header.php 
##             language/lang_english/lang_admin.php 
##             templates/subSilver/overall_header.tpl 
##             templates/subSilver/overall_footer.tpl  
##            
## Included Files: (2) admin/admin_redbar.php, templates/subSilver/admin/admin_redbar.tpl 
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
## 
## This Mod has been tested with Easymod & phpBB 2.0.19 and and has no problems installing.
##
## Before installing this MOD, please first run the db_update.php file included with this download.
## Alternatively, you can update you database manually using the queries in the extras/sql.txt file
## Also note, that I will not give support for this MOD anywhere else bar the official release thread at phpbb.com
## This includes - emails, pm's (on my site or phpBB.com), msn . . . 
##
##
## I designed this MOD mostly my own use, but released as I saw more and more people looking to
## easily add and administer links in their phpBB forum header.
## Version 2 of my rEd bar MOD makes this easier, by adding a separate ACP page to update the links,
## rather than have it stuck in the the depths of the configuration menu.
## 
## Below the the install history from the old MOD
## 
## ---------------------------------------------
##
##   2005-03-01 - MOD Development started 0.0.1 
## 
##   2005-03-05 - MOD Code re-written (it works now) 0.1.0 
##   -- set the rEd bar to be editable via the ACP configuration page, and dissolved the seperate admin_navbar.php   
## 
##   2005-03-06 - MOD Code updated 0.1.5 
##   -- bug fixes from 0.1.1 -- 0.1.5 
## 
##   2005-03-07 - MOD Code updated 0.1.6 
##   -- removed javascript for auto form filler -- basically useless test code that's not needed 
## 
##   2005-03-07 - MOD Code updated 0.1.7 
##   -- few Bug fixes and typos. Code now also Easy Mod compatible (although not officially)
## 
##   2005-03-07 - MOD Code updated 0.1.8 
##   -- EM compatiblility finalised and a few small typo/bug fixes
## 
##   2005-03-xx - MOD updated 1.0.0 
##   -- MOD submitted to phpBB Mods database
## 
##   2005-03-24 - MOD Code updated 1.0.1 
##   -- MOD fixed and released to phpBB Mods database
##
############################################################## 
## MOD History: 
## 
##   2006-03-23 - MOD Code updated 1.1.0 
##   -- MOD development for version 2 re-started
##   	-- ACP page written up and MOD templated updated
##   	-- Fixed SQL issue
##
##   2006-03-23 - MOD Code updated 1.1.2 
##   	-- Added some missing lang_vars
##   	-- Fixed a few minor template issues
##
##   2006-03-24 - MOD Code updated 1.2.0
##   	-- Install File updated, no code changed
##
##   2006-03-24 - MOD Code updated 2.0.0
##   	-- MOD submitted to phpBB MODs database
##
##   2006-04-12 - MOD Code updated 2.0.1
##   	-- Added missing admin language entry
##   	-- Fixed a minor bug in admin_redbar.php
##   	-- MOD templated fixed
##   	-- MOD re-submitted to phpBB MODs database as 2.0.1
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################### 
# 
#-----[ COPY ]------------------------------------------ 
# 
copy db_update.php to db_update.php
copy admin/admin_redbar.php to admin/admin_redbar.php
copy templates/subSilver/admin/admin_redbar.tpl to templates/subSilver/admin/admin_redbar.tpl
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/page_header.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
   'PRIVMSG_IMG' => $icon_pm, 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
// rEd bar 2 -- cherokeered 
   'NAV_NAME1' => $board_config['nav_name1'], 
   'NAV_LINK1' => $board_config['nav_link1'], 
   'NAV_NAME2' => $board_config['nav_name2'], 
   'NAV_LINK2' => $board_config['nav_link2'], 
   'NAV_NAME3' => $board_config['nav_name3'], 
   'NAV_LINK3' => $board_config['nav_link3'], 
   'NAV_NAME4' => $board_config['nav_name4'], 
   'NAV_LINK4' => $board_config['nav_link4'], 
   'NAV_NAME5' => $board_config['nav_name5'], 
   'NAV_LINK5' => $board_config['nav_link5'], 
   'NAV_NAME6' => $board_config['nav_name6'], 
   'NAV_LINK6' => $board_config['nav_link6'], 
   'NAV_NAME7' => $board_config['nav_name7'], 
   'NAV_LINK7' => $board_config['nav_link7'], 
   'NAV_NAME8' => $board_config['nav_name8'], 
   'NAV_LINK8' => $board_config['nav_link8'], 
   'NAV_NAME9' => $board_config['nav_name9'], 
   'NAV_LINK9' => $board_config['nav_link9'], 
   'NAV_NAME10' => $board_config['nav_name10'], 
   'NAV_LINK10' => $board_config['nav_link10'], 
// rEd bar 2 -- cherokeered 

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php 
# 
#-----[ FIND ]------------------------------------------ 
# 
?> 
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
// rEd bar 2 -- cherokee red 
$lang['Redbar'] = "Redbar";
$lang['redbar_config'] = "rEd bar configuration"; 
$lang['redbar_config_explain'] = "Here you can add up to 10 links to your forums header/footer.<br />Links and link names can be a maximum of 160 characaters. See the FAQ in the MODs release thread at phpBB.com for more information."; 
$lang['Red_config_updated'] = 'rEd bar was successfully updated';
$lang['Click_return_red_config'] = 'click %shere%s to return to the rEd bar configuration';
$lang['nav_title'] = "Navigation Bar"; 
$lang['nav_name1'] = "Name 1: &nbsp;&nbsp;"; 
$lang['nav_name2'] = "Name 2: &nbsp;&nbsp;"; 
$lang['nav_name3'] = "Name 3: &nbsp;&nbsp;"; 
$lang['nav_name4'] = "Name 4: &nbsp;&nbsp;"; 
$lang['nav_name5'] = "Name 5: &nbsp;&nbsp;"; 
$lang['nav_name6'] = "Name 6: &nbsp;&nbsp;"; 
$lang['nav_name7'] = "Name 7: &nbsp;&nbsp;"; 
$lang['nav_name8'] = "Name 8: &nbsp;&nbsp;"; 
$lang['nav_name9'] = "Name 9: &nbsp;&nbsp;"; 
$lang['nav_name10'] = "Name 10: &nbsp;&nbsp;"; 
$lang['nav_link1'] = "Link 1: &nbsp;&nbsp;"; 
$lang['nav_link2'] = "Link 2: &nbsp;&nbsp;"; 
$lang['nav_link3'] = "Link 3: &nbsp;&nbsp;"; 
$lang['nav_link4'] = "Link 4: &nbsp;&nbsp;"; 
$lang['nav_link5'] = "Link 5: &nbsp;&nbsp;"; 
$lang['nav_link6'] = "Link 6: &nbsp;&nbsp;"; 
$lang['nav_link7'] = "Link 7: &nbsp;&nbsp;"; 
$lang['nav_link8'] = "Link 8: &nbsp;&nbsp;"; 
$lang['nav_link9'] = "Link 9: &nbsp;&nbsp;"; 
$lang['nav_link10'] = "Link 10: &nbsp;&nbsp;"; 
// rEd bar 2 -- cherokee red 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/overall_header.tpl 
# 
#-----[ FIND ]------------------------------------------ 
# 
<a name="top"></a> 
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
<!-- rEdbar 2 --> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center"> 
   <tr> 
      <td class="catHead" height="37" align="center"> 
      <span class="genmed"><a href="{NAV_LINK1}" class="genmed">{NAV_NAME1}</a> 
      | <a href="{NAV_LINK2}" class="genmed">{NAV_NAME2}</a> 
      | <a href="{NAV_LINK3}" class="genmed">{NAV_NAME3}</a> 
      | <a href="{NAV_LINK4}" class="genmed">{NAV_NAME4}</a> 
      | <a href="{NAV_LINK5}" class="genmed">{NAV_NAME5}</a> 
      | <a href="{NAV_LINK6}" class="genmed">{NAV_NAME6}</a> 
      | <a href="{NAV_LINK7}" class="genmed">{NAV_NAME7}</a> 
      | <a href="{NAV_LINK8}" class="genmed">{NAV_NAME8}</a> 
      | <a href="{NAV_LINK9}" class="genmed">{NAV_NAME9}</a> 
      | <a href="{NAV_LINK10}" class="genmed">{NAV_NAME10}</a> 
   <br /> 
   </tr> 
</table> 
<!-- rEdbar 2 --> 
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/overall_footer.tpl 
# 
#-----[ FIND ]------------------------------------------ 
# 
</body> 
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
<!-- rEdbar 2 --> 
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center"> 
   <tr> 
      <td class="catHead" height="37" align="center"> 
      <span class="genmed"><a href="{NAV_LINK1}" class="genmed">{NAV_NAME1}</a> 
      | <a href="{NAV_LINK2}" class="genmed">{NAV_NAME2}</a> 
      | <a href="{NAV_LINK3}" class="genmed">{NAV_NAME3}</a> 
      | <a href="{NAV_LINK4}" class="genmed">{NAV_NAME4}</a> 
      | <a href="{NAV_LINK5}" class="genmed">{NAV_NAME5}</a> 
      | <a href="{NAV_LINK6}" class="genmed">{NAV_NAME6}</a> 
      | <a href="{NAV_LINK7}" class="genmed">{NAV_NAME7}</a> 
      | <a href="{NAV_LINK8}" class="genmed">{NAV_NAME8}</a> 
      | <a href="{NAV_LINK9}" class="genmed">{NAV_NAME9}</a> 
      | <a href="{NAV_LINK10}" class="genmed">{NAV_NAME10}</a> 
   <br /> 
   </tr> 
</table> 
<!-- rEdbar 2 --> 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM