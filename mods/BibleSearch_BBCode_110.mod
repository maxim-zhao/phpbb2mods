##############################################################
## MOD Title: Bible Passages BBCode
## MOD Author: Cross_+_Flame < admin@crossandflame.com > (N/A) http://www.crossandflame.com/forum
## MOD Description: Adds a new bbcode.  Allows you put make references to the Bible in your posts.
##              Clicking on the resulting link will pop-up the verse in an online bible database.  
##              Syntax is: [bible]Bible Verse[/bible] ([bible=?] if version other than NRSV)
## MOD Version: 1.1.0
##
## Installation Level: (Easy)
## Installation Time: 5 Minutes
## Files To Edit: - includes/bbcode.php,
##                - langugage/lang_english/lang_main.php,
##                - templates/subSilver/bbcode.tpl,
##                - templates/subSilver/posting_body.tpl
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##          You must have Multiple BBCode MOD installed for this to work.
##          Get it on this page: http://www.phpbb.com/phpBB/viewtopic.php?t=145513
##
##          The scripture passage can be a run of verses (ex. John 1:1-3) or a single verse
##          (ex. John 1:1) or a chapter (ex. John 1).  If you shorten the passage, use
##          standard abbreviations (ex. Jn 1:1).  You can even use a specific term (ex. Word).
##
##          You can select a different version to reference.  Enter [bible=?]Bible Verse[/bible]
##          where ? = nrs (New Revised Standard)
##                  = nas (New American Standard Version)
##                  = kjv (King James Version)
##                  = niv (New International Version)
##                  = nlt (New Living Translation)
##          If no bible version is chosen ([bible]) then the New Revised Standard will be used.
##          For version information, see this page: http://zondervanbibles.com/translations.htm
##          For more versions, see this thread: http://phpbb.com/phpBB/viewtopic.php?t=146287
##
##          This mod was based on wGEric's "Google Search BBCode" mod found on this page:
##          http://www.phpbb.com/phpBB/viewtopic.php?t=123139.  Bless you wGEric!
##############################################################
## MOD History:
##
##   2005-01-31 - Version 1.1.0
##              - Updated for 2.0.11
##              - Updated to work with Multiple BBCode 1.4.0.
##              - Added ability to search in multiple translations.  
##                Syntax: [bible=?]STRING[/bible]
##
##   2003-10-08 - Version 1.0.1
##              - Updated for 2.0.6
##
##   2003-08-08 - Version 1.0.0
##              - Initial Release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]---------------------------------
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
,'Bible'

#
#-----[ FIND ]------------------------------------------
#
	$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);

#
#-----[ AFTER, ADD ]------------------------------------------
#

  $bbcode_tpl['bible'] = '\'' . $bbcode_tpl['bible'] . '\'';
  $bbcode_tpl['bible'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['bible']);
  $bbcode_tpl['bible'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['bible']);
  
  $bbcode_tpl['bible_nas'] = '\'' . $bbcode_tpl['bible_nas'] . '\'';
  $bbcode_tpl['bible_nas'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['bible_nas']);
  $bbcode_tpl['bible_nas'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['bible_nas']);
  $bbcode_tpl['bible_kjv'] = '\'' . $bbcode_tpl['bible_kjv'] . '\'';
  $bbcode_tpl['bible_kjv'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['bible_kjv']);
  $bbcode_tpl['bible_kjv'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['bible_kjv']);
  $bbcode_tpl['bible_niv'] = '\'' . $bbcode_tpl['bible_niv'] . '\'';
  $bbcode_tpl['bible_niv'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['bible_niv']);
  $bbcode_tpl['bible_niv'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['bible_niv']);
  $bbcode_tpl['bible_nlt'] = '\'' . $bbcode_tpl['bible_nlt'] . '\'';
  $bbcode_tpl['bible_nlt'] = str_replace('{STRING}', "' . str_replace('\\\"', '\"', '\\1') . '", $bbcode_tpl['bible_nlt']);
  $bbcode_tpl['bible_nlt'] = str_replace('{QUERY}', "' . urlencode(str_replace('\\\"', '\"', '\\1')) . '", $bbcode_tpl['bible_nlt']);

#
#-----[ FIND ]------------------------------------------
#
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	// [bible]string for Bible Passage[/bible] code..
	$patterns[] = "#\[bible\](.*?)\[/bible\]#ise";
	$replacements[] = $bbcode_tpl['bible'];
	
	// [bible=nrs]string for NRSV Bible Passage[/bible] code..
	$patterns[] = "#\[bible=nrs\](.*?)\[/bible\]#ise";
	$replacements[] = $bbcode_tpl['bible'];
	// [bible=nas]string for NASB Bible Passage[/bible] code..
	$patterns[] = "#\[bible=nas\](.*?)\[/bible\]#ise";
	$replacements[] = $bbcode_tpl['bible_nas'];
	// [bible=kjv]string for KJV Bible Passage[/bible] code..
	$patterns[] = "#\[bible=kjv\](.*?)\[/bible\]#ise";
	$replacements[] = $bbcode_tpl['bible_kjv'];
	// [bible=niv]string for NIV Bible Passage[/bible] code..
	$patterns[] = "#\[bible=niv\](.*?)\[/bible\]#ise";
	$replacements[] = $bbcode_tpl['bible_niv'];
	// [bible=nlt]string for NLT Bible Passage[/bible] code..
	$patterns[] = "#\[bible=nlt\](.*?)\[/bible\]#ise";
	$replacements[] = $bbcode_tpl['bible_nlt'];
	
#
#-----[ OPEN ]---------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]---------------------------------
#
# NOTE: the full line to look for is:
#$lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';
#
$lang['bbcode_f_help'] =

#
#-----[ AFTER, ADD ]---------------------------------
#

$lang['bbcode_help']['bible'] = 'Bible: [bible=?]Bible passage[/bible] (?=nrs,nas,kjv,niv,nlt) (alt+%s)';

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

<!-- BEGIN bible --><a href="http://bible.crosswalk.com/OnlineStudyBible/bible.cgi?word={QUERY}&version=nrs" target="_blank">{STRING}</a><!-- END bible -->
<!-- BEGIN bible_nas --><a href="http://bible.crosswalk.com/OnlineStudyBible/bible.cgi?word={QUERY}&version=nas" target="_blank">{STRING}</a><!-- END bible_nas -->
<!-- BEGIN bible_kjv --><a href="http://bible.crosswalk.com/OnlineStudyBible/bible.cgi?word={QUERY}&version=kjv" target="_blank">{STRING}</a><!-- END bible_kjv -->
<!-- BEGIN bible_niv --><a href="http://bible.gospelcom.net/passage/?search={QUERY};&version=31;" target="_blank">{STRING}</a><!-- END bible_niv -->
<!-- BEGIN bible_nlt --><a href="http://bible.crosswalk.com/OnlineStudyBible/bible.cgi?word={QUERY}&version=nlt" target="_blank">{STRING}</a><!-- END bible_nlt -->

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
,'[bible]','[/bible]'

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM