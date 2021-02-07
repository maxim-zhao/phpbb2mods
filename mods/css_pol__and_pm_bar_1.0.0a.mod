##############################################################
## MOD Title: css poll and pm bar
## MOD Author: Alexis Canver < N/A > (Alexis Canver) http://www.canver.net
## MOD Description: This mod replace poll and pm status box to css bar
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit: (5) templates/subSilver/subSilver.css
##                    templates/subSilver/overall_header.tpl
##                    templates/subSilver/viewtopic_poll_result.tpl
##                    templates/subSilver/privmsgs_body.tpl
##                    templates/subSilver/subSilver.cfg
## Included Files: n/a
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
## After find and delete this images:
## 
## templates/subSilver/images/
##   vote_lcap.gif
##   vote_rcap.gif
##   voting_bar.gif
##
##############################################################
## MOD History:
##
## 2006-10-21 - Version 1.0.0
##   - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/subSilver.css

#
#-----[ FIND ]------------------------------------------------
#

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("formIE.css");

#
#------[ BEFORE, ADD ]----------------------------------------
#

/* Basic Bar Graph */
.graph { 
	position: relative; /* IE is dumb */
	width: 200px; 
	border: 1px solid #98aab1; 
	padding: 2px; 
	/*margin-bottom: .5em;*/					
}
.graph .bar { 
	display: block;	
	position: relative;
	background: #98aab1; 
	text-align: center; 
	color: #333; 
	height: 1.5em; 
	line-height: 1.5em;	
						
}
.graph .bar span { position: absolute; left: 1em; }
 /* This extra markup is necessary because 
IE doesn't want to follow the rules for overflow: visible */

#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/overall_header.tpl

#
#-----[ FIND ]------------------------------------------------
#

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("templates/subSilver/formIE.css"); 

#
#------[ BEFORE, ADD ]----------------------------------------
#

/* Basic Bar Graph */
.graph { 
	position: relative; /* IE is dumb */
	width: 200px; 
	border: 1px solid #98aab1; 
	padding: 2px; 
	/*margin-bottom: .5em;*/					
}
.graph .bar { 
	display: block;	
	position: relative;
	background: #98aab1; 
	text-align: center; 
	color: #333; 
	height: 1.5em; 
	line-height: 1.5em;	
						
}
.graph .bar span { position: absolute; left: 1em; }
 /* This extra markup is necessary because 
IE doesn't want to follow the rules for overflow: visible */

#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/viewtopic_poll_result.tpl

#
#-----[ FIND ]------------------------------------------------
#

				<table cellspacing="0" cellpadding="0" border="0">
				  <tr> 
					<td><img src="templates/subSilver/images/vote_lcap.gif" width="4" alt="" height="12" /></td>
					<td><img src="{poll_option.POLL_OPTION_IMG}" width="{poll_option.POLL_OPTION_IMG_WIDTH}" height="12" alt="{poll_option.POLL_OPTION_PERCENT}" /></td>
					<td><img src="templates/subSilver/images/vote_rcap.gif" width="4" alt="" height="12" /></td>
				  </tr>
				</table>

#
#-----[ REPLACE WITH ]----------------------------------------
#

				<div class="graph gensmall">
				<strong class="bar" style="width: {poll_option.POLL_OPTION_PERCENT};"><span>{poll_option.POLL_OPTION_PERCENT}</span></strong>
				</div>


#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/privmsgs_body.tpl

#
#-----[ FIND ]------------------------------------------------
#

			<table cellspacing="0" cellpadding="1" border="0">
			  <tr> 
				<td bgcolor="{T_TD_COLOR2}"><img src="templates/subSilver/images/spacer.gif" width="{INBOX_LIMIT_IMG_WIDTH}" height="8" alt="{INBOX_LIMIT_PERCENT}" /></td>
			  </tr>
			</table>

#
#-----[ REPLACE WITH ]----------------------------------------
#

			<div class="graph gensmall">
			<strong class="bar" style="width: {INBOX_LIMIT_IMG_WIDTH}%;"><span>{INBOX_LIMIT_PERCENT}%</span></strong>
			</div>

#
#-----[ OPEN ]------------------------------------------------
#

templates/subSilver/subSilver.cfg

#
#------[ FIND ]------------------------------------------------------------------------
#

$images['voting_graphic'][0] = "$current_template_images/voting_bar.gif";
$images['voting_graphic'][1] = "$current_template_images/voting_bar.gif";
$images['voting_graphic'][2] = "$current_template_images/voting_bar.gif";
$images['voting_graphic'][3] = "$current_template_images/voting_bar.gif";
$images['voting_graphic'][4] = "$current_template_images/voting_bar.gif";

#
#-----[ REPLACE WITH ]----------------------------------------
#

/*
$images['voting_graphic'][0] = "$current_template_images/voting_bar.gif";
$images['voting_graphic'][1] = "$current_template_images/voting_bar.gif";
$images['voting_graphic'][2] = "$current_template_images/voting_bar.gif";
$images['voting_graphic'][3] = "$current_template_images/voting_bar.gif";
$images['voting_graphic'][4] = "$current_template_images/voting_bar.gif";
*/

#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM