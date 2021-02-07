##############################################################
## MOD Title: Search Box 
## MOD Author: Alfatek < alfatek [nospam] hardware.com.pt > (Paulo JF Silva) http://www.hardware.com.pt/
## MOD Description: When you click in the search link at the top of your pages, a search box appears.
## If you don't have javascript it degrades and goes to search.php as usual.
## 
## See screenshots for more information
## 
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 6 minutes
## Files To Edit: templates/subSilver/overall_header.tpl
##                includes/page_header.php
##                language/lang_english/lang_main.php
## Included Files: icon_mini_menu_down.gif
##		   prototype.js
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
## 1) This mod uses the Prototype Javascript Framework 
## http://prototype.conio.net/
##
## 2) This mod works fine with EasyMod. In a modded board maybe it doesn't work but you can get the idea how to do it
##
##
## 3) The search box can appear behind a Flash Movie or an Iframe (only Opera <= 8.5) (google ads). 
## 
## Both these problems have solutions:
## 
##  - Flash Movie:
## Set your flash movie to opaque mode: http://www.macromedia.com/cfusion/knowledgebase/index.cfm?id=tn_15523
## 
## - Iframe
## Use Opera 9 or just disable the box in Opera <= 8.5, for this replace the searchTooltip javascript function with this one:
## function searchTooltip(){
## 
##   if (tooltipon){
##     $('searchbox').style.display = 'none';
## 
##     tooltipon = false;
##   }
##   else{
##     /* Detect Opera */
##     var detect = navigator.userAgent.toLowerCase();
##     place = detect.indexOf('opera');
## 
##     /* Opera browser, now see if its 9.0 or > */
##     var version = detect.charAt(6);
##     if (place != -1 && version < 9){
##       return true;
##     }
## 
##     $('searchbox').style.display = 'block';
##     $('searchbox').style.position = 'absolute';
##     
##     var obj = $('searchlink');
##     var pos = Position.cumulativeOffset(obj);
##     $('searchbox').style.left = pos[0] + 'px'; 
##     $('searchbox').style.top = pos[1]+20 + 'px'; 
##     
## 
##     tooltipon = true;
##   }
## 
##   return false;
## }
##############################################################
## MOD History:
##
##   2006-01-26 - Version 1.0.0
##      - oficial launch
##
##   2006-02-13 - Version 1.0.1
##      - small corrections in this file (added mod history and included files
##	and in overall_header.tpl 
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
</head>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<script src="templates/prototype.js" type="text/javascript"></script>
<script language="Javascript" type="text/javascript">
<!--
var tooltipon = false;

function searchTooltip(){

  if (tooltipon){
    $('searchbox').style.display = 'none';

    tooltipon = false;
  }
  else{
    $('searchbox').style.display = 'block';
    $('searchbox').style.position = 'absolute';
    
    var obj = $('searchlink');
    var pos = Position.cumulativeOffset(obj);
    $('searchbox').style.left = pos[0] + 'px'; 
    $('searchbox').style.top = pos[1]+20 + 'px'; 
    
    tooltipon = true;
  }

  return false;
}

//-->
</script>
#
#-----[ FIND ]------------------------------------------
#
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a>&nbsp; &nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH}</a>&nbsp; &nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_members.gif" width="12" height="13" border="0" alt="{L_MEMBERLIST}" hspace="3" />{L_MEMBERLIST}</a>&nbsp; &nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_USERGROUPS}" hspace="3" />{L_USERGROUPS}</a>&nbsp; 
#
#-----[ REPLACE WITH ]------------------------------------------
#
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a>&nbsp; &nbsp;<a onclick="return searchTooltip();" href="{U_SEARCH}" class="mainmenu" id="searchlink"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH} <img src="templates/subSilver/images/icon_mini_menu_down.gif" width="8" height="5" border="0" /></a>
						<div id="searchbox" style="display:none;z-index: 100;">
						<form action="{S_SEARCH_ACTION}" method="POST">
						<table class="forumline" cellpadding="4" cellspacing="1" border="0">
						  <tr>
						    <th class="thHead" height="25"><a onclick="searchTooltip(); return false;" href="#" style="float:right;color: #FFF;font-size: 9px;font-family:Verdana, sans-serif; text-decoration: none;">(X)</a>{L_SEARCH_QUERY}</th>
						  </tr>
						  <tr>
						    <td class="row1" align="center">
						      <input type="text" style="width: 180px" class="post" name="search_keywords" size="30" /> <input class="liteoption" type="submit" value="{L_SEARCH}" />
						      <input type="hidden" name="search_terms" value="all" />
						      <input type="hidden" name="search_forum" value="-1" />
						      <input type="hidden" name="search_time" value="0" />
						      <input type="hidden" name="search_cat value="-1" />
						      <input type="hidden" name="sort_by value="0" />
						      <input type="hidden" name="sort_dir value="ASC" />
						      <input type="hidden" name="show_results value="posts" />
						      <input type="hidden" name="return_chars value="200" />
						      <input type="hidden" name="search_fields" value="all" />
						    </td>
						  </tr>
						  <tr>
						    <td class="catBottom" align="center">
							  <a href="{U_SEARCH}" class="nav">{L_ADVANCED_SEARCH}</a> 
							</td>
						  </tr>
						</table>
						</form>
						</div>&nbsp; &nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_members.gif" width="12" height="13" border="0" alt="{L_MEMBERLIST}" hspace="3" />{L_MEMBERLIST}</a>&nbsp; &nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_USERGROUPS}" hspace="3" />{L_USERGROUPS}</a>&nbsp; 

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
	'T_SPAN_CLASS2' => $theme['span_class2'],
	'T_SPAN_CLASS3' => $theme['span_class3'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
  'S_SEARCH_ACTION' => append_sid("search.$phpEx?mode=results"),
  'L_SEARCH_QUERY' => $lang['Search_query'],
  'L_ADVANCED_SEARCH' => $lang['Advanced_Search'],

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Search_query'] = 'Search Query';
#
#-----[ AFTER, ADD ]------------------------------------------
#

$lang['Advanced_Search'] = 'Advanced Search';
#
#-----[ COPY ]------------------------------------------
#
copy icon_mini_menu_down.gif to templates/subSilver/images/icon_mini_menu_down.gif 
copy prototype.js to templates/prototype.js
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
