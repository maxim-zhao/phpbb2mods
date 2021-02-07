############################################################## 
## MOD Title:           3D PM box_size_notice
## MOD Author:          SwissCheese < N/A > (Daniel Schaad) http://mods.DanielSchaad.com
## MOD Description:     This MOD upgrades the PM 'box_size_notice' (originaly displaying
##			a 2D bar showing how much space in % of the Inbox/Sentbox/Savebox
##			has been used) to the same 3D bar used to display poll results.
## 
## MOD Version:		1.0.1 
## 
## Installation Level:	Easy 
## Installation Time:	~1 Minute 
## Files To Edit:	templates/subSilver/privmsgs_body.tpl
## 
## Included Files:	(N/A) 
## License:		http://opensource.org/licenses/gpl-license.php GNU Public License v2 
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
############################################################## 
## MOD History: 
## 
##   2005-07-26 - Version 1.0.1 
##      - Updated Security Disclaimer  
## 
##   2005-07-26 - Version 1.0.0 
##      - Initial Release 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/privmsgs_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	  <table width="175" cellspacing="1" cellpadding="2" border="0" class="bodyline">
		<tr> 
		  <td colspan="3" width="175" class="row1" nowrap="nowrap"><span class="gensmall">{BOX_SIZE_STATUS}</span></td>
		</tr>
		<tr> 
		  <td colspan="3" width="175" class="row2">
			<table cellspacing="0" cellpadding="1" border="0">
			  <tr> 
				<td bgcolor="{T_TD_COLOR2}"><img src="templates/subSilver/images/spacer.gif" width="{INBOX_LIMIT_IMG_WIDTH}" height="8" alt="{INBOX_LIMIT_PERCENT}" /></td>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	  <table width="189" cellspacing="1" cellpadding="2" border="0" class="bodyline">
		<tr> 
		  <td colspan="3" width="189" class="row1" nowrap="nowrap" align="center"><span class="gensmall">{BOX_SIZE_STATUS}</span></td>
		</tr>
		<tr> 
		  <td colspan="3" width="189" class="row2">
			<table cellspacing="0" cellpadding="1" border="0">
			  <tr> 
				<td><img src="templates/subSilver/images/vote_lcap.gif" width="4" height="12" alt="{BOX_SIZE_STATUS}" /><img src="templates/subSilver/images/voting_bar.gif" width="{INBOX_LIMIT_IMG_WIDTH}" height="12" alt="{BOX_SIZE_STATUS}" /><img src="templates/subSilver/images/vote_rcap.gif" width="4" height="12" alt="{BOX_SIZE_STATUS}" /></td>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM
