############################################################## 
## MOD Title: Wikipedia Reference BBCode 
## MOD Author: paul.tgk < paul@theseguysknow.com >  (Paul) http://www.theseGuysKnow.com
## MOD Description: Allows you to make keywords in your post
## 	   	    link to those entries at WikiPedia. 
##		    ([wiki=en]keyword[/wiki]) en being english, 
##				Supports the following Wikipedia languages:
##					English (en), Deutsch (de), Francias (fr), Nederlands (nl),
##					Portugues (pt), Italiano (it), Espanol (es), Polski (pl)
## 					Svenski (sv). 
##					By default all but english is commented out.
##					For those bilingual or non english boards, just uncomment 
##					the lines that correspond to your language code. There 
##					are three places you need to uncomment. They are clearly 
##					marked with "========== Spot # ==========".					
##
## MOD Version: 1.0.43
## 
## Installation Level: (Easy) 
## Installation Time: 5 Minutes
## Files To Edit: includes/bbcode.php,
##           langugage/lang_english/lang_main.php,
##           templates/subSilver/bbcode.tpl,
##           templates/subSilver/posting_body.tpl
## Included Files: n/a
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##      You must have Multiple BBCode MOD v1.4.0 or newer 
##         installed for this to work.
##      Get it here: http://www.phpbb.com/phpBB/viewtopic.php?t=145513
##
##      example:
##		  [wiki]keyword[/wiki], English is the default, other languages are supported (see above).
##		  If you are using multiple languages its necessary to define the langauge in the wiki tag
##			example [wiki=es]keyword[/wiki] will link to the spanish wikipedia.
## 
############################################################## 
## MOD History: 
##
##  2005-07-13 - Version 1.0.43
##		   - Updated template to support new format.
##
##  2005-07-13 - Version 1.0.42
##		   - Added multiple language support
##		   - Updated template to support new format.
##
##  2005-06-28 - Version 0.4.2
##             - First public release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php

#
#-----[ FIND ]---------------------------------
#
$EMBB_widths = array(''

#
#-----[ IN-LINE FIND ]---------------------------------
#
 array(''

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'55'

#
#-----[ FIND ]---------------------------------
#
$EMBB_values = array(''

#
#-----[ IN-LINE FIND ]---------------------------------
#
$EMBB_values = array(''

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'Wiki'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#
# =============== Spot 1 ===============

  $bbcode_tpl['wiki'] = '\'' . $bbcode_tpl['wiki'] . '\'';
  $bbcode_tpl['wiki'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki']);
  $bbcode_tpl['wiki'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki']);

  $bbcode_tpl['wiki_en'] = '\'' . $bbcode_tpl['wiki_en'] . '\'';
  $bbcode_tpl['wiki_en'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_en']);
  $bbcode_tpl['wiki_en'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_en']);

#  $bbcode_tpl['wiki_de'] = '\'' . $bbcode_tpl['wiki_de'] . '\'';
#  $bbcode_tpl['wiki_de'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_de']);
#  $bbcode_tpl['wiki_de'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_de']);

#  $bbcode_tpl['wiki_fr'] = '\'' . $bbcode_tpl['wiki_fr'] . '\'';
#  $bbcode_tpl['wiki_fr'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_fr']);
#  $bbcode_tpl['wiki_fr'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_fr']);

#  $bbcode_tpl['wiki_nl'] = '\'' . $bbcode_tpl['wiki_nl'] . '\'';
#  $bbcode_tpl['wiki_nl'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_nl']);
#  $bbcode_tpl['wiki_nl'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_nl']);

#  $bbcode_tpl['wiki_pt'] = '\'' . $bbcode_tpl['wiki_pt'] . '\'';
#  $bbcode_tpl['wiki_pt'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_pt']);
#  $bbcode_tpl['wiki_pt'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_pt']);

#  $bbcode_tpl['wiki_it'] = '\'' . $bbcode_tpl['wiki_it'] . '\'';
#  $bbcode_tpl['wiki_it'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_it']);
#  $bbcode_tpl['wiki_it'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_it']);

#  $bbcode_tpl['wiki_es'] = '\'' . $bbcode_tpl['wiki_es'] . '\'';
#  $bbcode_tpl['wiki_es'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_es']);
#  $bbcode_tpl['wiki_es'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_es']);

#  $bbcode_tpl['wiki_pl'] = '\'' . $bbcode_tpl['wiki_pl'] . '\'';
#  $bbcode_tpl['wiki_pl'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_pl']);
#  $bbcode_tpl['wiki_pl'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_pl']);

#  $bbcode_tpl['wiki_sv'] = '\'' . $bbcode_tpl['wiki_sv'] . '\'';
#  $bbcode_tpl['wiki_sv'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['wiki_sv']);
#  $bbcode_tpl['wiki_sv'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['wiki_sv']);

#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
# 
# =============== Spot 2 ===============	

	// [wiki]string for search[/wiki] code..
	$patterns[] = "#\[wiki\](.*?)\[/wiki\]#ise";
	$replacements[] = $bbcode_tpl['wiki'];

	$patterns[] = "#\[wiki=en\](.*?)\[/wiki\]#ise";
	$replacements[] = $bbcode_tpl['wiki_en'];

#	$patterns[] = "#\[wiki=de\](.*?)\[/wiki\]#ise";
#	$replacements[] = $bbcode_tpl['wiki_de'];

#	$patterns[] = "#\[wiki=fr\](.*?)\[/wiki\]#ise";
#	$replacements[] = $bbcode_tpl['wiki_fr'];

#	$patterns[] = "#\[wiki=nl\](.*?)\[/wiki\]#ise";
#	$replacements[] = $bbcode_tpl['wiki_nl'];

#	$patterns[] = "#\[wiki=pt\](.*?)\[/wiki\]#ise";
#	$replacements[] = $bbcode_tpl['wiki_pt'];

#	$patterns[] = "#\[wiki=it\](.*?)\[/wiki\]#ise";
#	$replacements[] = $bbcode_tpl['wiki_it'];

#	$patterns[] = "#\[wiki=es\](.*?)\[/wiki\]#ise";
#	$replacements[] = $bbcode_tpl['wiki_es'];

#	$patterns[] = "#\[wiki=pl\](.*?)\[/wiki\]#ise";
#	$replacements[] = $bbcode_tpl['wiki_pl'];

#	$patterns[] = "#\[wiki=sv\](.*?)\[/wiki\]#ise";
#	$replacements[] = $bbcode_tpl['wiki_sv'];

#
#-----[ OPEN ]---------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]---------------------------------
#
# NOTE: the full line to look for is:
#$lang['bbcode_f_help'] = "Font size: [size=x-small]small text[/size]";
#
$lang['bbcode_f_help'] =

#
#-----[ AFTER, ADD ]---------------------------------
#

$lang['bbcode_help']['wiki'] = "Wiki: [wiki]keyword[/wiki] or [wiki=en]keyword[/wiki] ";

#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/bbcode.tpl
    
#
#-----[ FIND ]------------------------------------------ 
#
<!-- BEGIN email --><a href="mailto:{EMAIL}">{EMAIL}</A><!-- END email -->
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
# =============== Spot 3 ===============
# NOTE: Change the url of the first line to change the "default" Language
# 
<!-- BEGIN wiki --><a href="http://en.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki -->
<!-- BEGIN wiki_en --><a href="http://en.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_en -->
#<!-- BEGIN wiki_de --><a href="http://de.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_de -->
#<!-- BEGIN wiki_fr --><a href="http://fr.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_fr -->
#<!-- BEGIN wiki_nl --><a href="http://nl.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_nl -->
#<!-- BEGIN wiki_pt --><a href="http://pt.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_pt -->
#<!-- BEGIN wiki_it --><a href="http://it.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_it -->
#<!-- BEGIN wiki_es --><a href="http://es.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_es -->
#<!-- BEGIN wiki_pl --><a href="http://pl.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_pl -->
#<!-- BEGIN wiki_sv --><a href="http://sv.wikipedia.org/wiki/{QUERY}" target="_blank">{STRING}</a><!-- END wiki_sv -->

#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]---------------------------------
#
# NOTE: the actual line to find is MUCH longer, containing all the bbcode tags
#
bbtags = new Array(

#
#-----[ IN-LINE FIND ]---------------------------------
#
'[url]','[/url]'

#
#-----[ IN-LINE AFTER, ADD ]---------------------------------
#
,'[wiki]','[/wiki]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM
