##############################################################
## MOD Title: Digg, Del.icio.us & Slashdot Mod
## MOD Author: Cobby < cobby@rentadev.net > (Cobby Drost) N/A
## MOD Author: HoundoftheB < bbolman@gmail.com > (Brad Bolman) N/A
## MOD Description: This mod adds a Digg, Slashdot, and Del.icio.us Links into your topics so users can promote your posts.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: templates/subSilver/viewtopic_body.tpl
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
##	Digg: http://www.digg.com
##	Slashdot: http://slashdot.org/
##	Del.icio.us: http://del.icio.us
##
##	Popular sites where users choose the news that makes it to the front page(s).
##
##	Demo: http://www.hostingforum.ca/viewtopic.70034.html (look on the left under user)
##############################################################
## MOD History:
## 
## 2006-12-03 - Version 1.0.0
##   - First release
##
## 2006-12-04 - Version 1.0.1
##   - Second release, fixed some errors stopping easymod from installing correctly	
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<td width="150" align="left" valign="top" class="{postrow.ROW_CLASS}">
#
#-----[ IN-LINE FIND ]------------------------------------------
#
{postrow.POSTER_FROM}</span><br />
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
<span class="topictitle"><a href="http://digg.com/submit?phase=2&amp;url=http://www.YOUR_URL/{U_VIEW_TOPIC}&amp;title={TOPIC_TITLE_FULL}">Digg It</a><br /><span class="topictitle"><a href="http://del.icio.us/post?url=http://www.YOUR_URL/{U_VIEW_TOPIC}&amp;title={TOPIC_TITLE_FULL}">Del.icio.us</a> <br /><span class="topictitle"><a href="javascript:location.href='http://slashdot.org/bookmark.pl?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)"></a><a href="javascript:location.href='http://slashdot.org/bookmark.pl?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)">Slashdot It!</a>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM