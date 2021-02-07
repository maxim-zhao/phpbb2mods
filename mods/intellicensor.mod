############################################################## 
## MOD Title: IntelliCensor
## MOD Author: jsmotta < phpbb@rusticweb.com > (Jonathan Motta) http://www.geoclashing.com/
## MOD Description: Closes most of the loopholes users
##       find to outwit the standard word censor, without
##       increasing false positives. 
## 
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: ~3 Minutes
## Files To Edit: includes/functions.php
##
## Included Files: N/A
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## MOD History:
## 
## Feb 12, 2004 - Version 1.0.0
##    Mod has survived substantial testing. Changed
##    version number to signify mod is complete.
## Jan 06, 2004 - version 0.2.1
##    * added sort so that longer words get matched
##      first when poster uses spacing to break up a word
##      (i.e. if 'fu' and 'fubar' are both in the Word
##      Censor list, 'f.u.b.a.r' will match entirely.
##      Previously, IC would sometimes only catch 'f.u'.
## Jan 05, 2004 - version 0.2.0
##  - Beta Release 2, with a supercharged regex
## Jan 04, 2004 - Version 0.1.0
##  - Beta Release as just a fix for the a$$ issue.
############################################################## 
## Author Notes: 
##   For the standard Word Censor to catch the word 'fubar',
##   you must enter 'fubar' into the censor's word list.
##   However, if a forum member wants to trick the censor,
##   all they need to do is type fub@r, f u b a r, f.u.b.a.r,
##   F#U#B#A#R, f_u.b+a'r, etc, or they can enclose it in
##   BBCode, like [b]fubar[/b]. So, if 'fubar' was considered
##   a horendously offensive word on your board, you'd need
##   to enter a nearly infinite number of potential 
##   variations of the word into the censor's list. Plus,
##   the standard Word Censor has serious problems with any
##   BBCode or non-alphanumeric characters appearing at the
##   beginning or end of the censord word (i.e. pa$$),and
##   fails to ever catch those words. All of which makes
##   the standard Word Censor pretty useless.
##
##   Enter IntelliCensor. Just enter the word 'fubar' once
##   into your censored word list, and instantly IC will
##   close the door on all of the above tricks and a whole
##   lot more (yes, including the BBCode). Then, just sit
##   back, and enjoy as the usual offenders scramble to
##   find new and creative ways to cuss at each other,
##   and now probably you too. ;)
## 
##
## Final Note regarding [code]:
##   When analyzing normal conversational text, IC is
##   designed to catch censored words much better, and without
##   any more false positives, than the standard Word Censor.
##   However, if your board is the type that frequently
##   has users posting software code into their messages,
##   IC may be a little too aggressive for your tastes.
##   For instance, the variable $hit would be censored
##   every time. However, I've pasted huge blocks of phpBB2
##   source into messages to test this, and failed to have
##   it censor anything. So, you'll need to decide for
##   yourself. It may be worth it, or not.
##  
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions.php

# 
#-----[ FIND ]------------------------------------------ 
#
$sql = "SELECT word, replacement
                FROM  " . WORDS_TABLE;

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
$sql = "SELECT word, replacement
                FROM  " . WORDS_TABLE . " ORDER BY length(word) DESC";

# 
#-----[ FIND ]------------------------------------------ 
#
$orig_word[] = '#\b(' . str_replace('\*', '\w*?', phpbb_preg_quote($row['word'], '#')) . ')\b#i'; 
$replacement_word[] = $row['replacement'];

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
$ic_word = ''; $ic_first = 0;
$ic_chars = preg_split('//', $row['word'], -1, PREG_SPLIT_NO_EMPTY);
foreach ($ic_chars as $char) {
if (($ic_first == 1) && ($char != "*")) { $ic_word .= "_"; }
   $ic_word .= $char; $ic_first = 1;
}
$ic_search = array('\*','s','a','b','l','i','o','p','_');
$ic_replace = array('\w*?','(?:s|\$)','(?:a|\@)','(?:b|8|3)','(?:l|1|i|\!)','(?:i|1|l|\!)','(?:o|0)','(?:p|\?)','(?:_|\W)*');
$orig_word[] = '#(?<=^|\W)(' . str_replace($ic_search, $ic_replace, phpbb_preg_quote($ic_word, '#')) . ')(?=\W|$)#i';
$replacement_word[] = $row['replacement'];

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 