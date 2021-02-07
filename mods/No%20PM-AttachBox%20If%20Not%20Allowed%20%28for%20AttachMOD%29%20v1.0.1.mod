############################################################## 
## MOD Title: No PM-AttachBox If Not Allowed (for AttachMOD)
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http:/phpbb.lovewithsmg.com/
## MOD Description: Hide AttachBox status for Inbox when attachments not allowed in PM
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 1 Minute (even faster with the great EasyMOD! :-)
## Files To Edit:	templates/subSilver/privmsgs_body.tpl
##			attach_mod/pm_attachments.php
## Included Files:	n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes:
##	This MOD is a little patch for Acyd Burn's AttachMOD
##
##	Just a little "bug" I found, when attachments are not allowed in PM the Attachbox status is still
##	showed, this will hide it! ;-) (of course it'll be showed if it is allowed :-)
##
##	And many Thanks & Congratulations to Acyd Burn for his amazing great work!! :D
##
############################################################## 
## MOD History: 
## 
##   2004-07-04 - Version 1.0.1
##	- Fixed order of FINDs for attach_mod/pm_attachments.php
##
##   2004-06-30 - Version 1.0.0 
##	- Submitted to the MOD-DB (no changes were made)
##
##   2004-06-12 - Version 0.0.2
##	- Removed a big bug (call to undefined function) - Sorry I missed it the first time!
##
##   2004-06-11 - Version 0.0.1 
##	- First version, should work just fine ;) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


# 
#-----[ OPEN ]----- 
# 
templates/subSilver/privmsgs_body.tpl
# 
#-----[ FIND ]----- 
#
	  <!-- BEGIN switch_box_size_notice -->
# 
#-----[ REPLACE WITH ]----- 
# 
	  <!-- BEGIN switch_attachbox_size_notice -->
# 
#-----[ FIND ]----- 
#
		  <td colspan="3" width="175" class="row1" nowrap="nowrap"><span class="gensmall">{ATTACH_BOX_SIZE_STATUS}</span></td>
# 
#-----[ REPLACE WITH ]----- 
# 
		  <td colspan="3" width="175" class="row1" nowrap="nowrap"><span class="gensmall">{switch_attachbox_size_notice.ATTACH_BOX_SIZE_STATUS}</span></td>
# 
#-----[ FIND ]----- 
#
				<td bgcolor="{T_TD_COLOR2}"><img src="templates/subSilver/images/spacer.gif" width="{ATTACHBOX_LIMIT_IMG_WIDTH}" height="8" alt="{ATTACH_LIMIT_PERCENT}" /></td>
# 
#-----[ REPLACE WITH ]----- 
#
				<td bgcolor="{T_TD_COLOR2}"><img src="templates/subSilver/images/spacer.gif" width="{switch_attachbox_size_notice.ATTACHBOX_LIMIT_IMG_WIDTH}" height="8" alt="{switch_attachbox_size_notice.ATTACH_LIMIT_PERCENT}" /></td>
# 
#-----[ FIND ]----- 
#
	  <!-- END switch_box_size_notice -->
# 
#-----[ REPLACE WITH ]----- 
# 
	  <!-- END switch_attachbox_size_notice -->
# 
# 
#-----[ OPEN ]----- 
#
attach_mod/pm_attachments.php
# 
#-----[ FIND ]----- 
#
		$template->assign_vars(array(
# 
#-----[ REPLACE WITH ]----- 
# 
		$template->assign_block_vars('switch_attachbox_size_notice', array(
# 
#-----[ FIND ]----- 
#
#Here we'll actually switch thoose two "if" blocks
		if ($folder != 'outbox')
		{
			$this->display_attach_box_limits();
		}

		if (!intval($attach_config['allow_pm_attach']))
		{
			return;
		}
# 
#-----[ REPLACE WITH ]----- 
#
		if (!intval($attach_config['allow_pm_attach']))
		{
			return;
		}

		if ($folder != 'outbox')
		{
			$this->display_attach_box_limits();
		}
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 