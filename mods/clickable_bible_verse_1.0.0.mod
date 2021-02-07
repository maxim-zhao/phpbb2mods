##############################################################
## MOD Title: Clickable Bible Verse
## MOD Author: WelcomB < welcomb@hotmail.com > (N/A) N/A
## MOD Description: Rather than use a BBCode for verses, this mod
##                  replaces all bible verse quotation with a link
##                  to an external site. For English language only.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 1 Minutes
## Files To Edit: includes/bbcode.php
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
##   Should be working fine. Maybe in the future I might link it to the bible in MySQL
##   Available for English language only.
##
##############################################################
## MOD History:
##
##  2006-02-04 - Version 1.0.0
##     - Final release version.
##
##  2006-01-21 - Version 0.3.0b
##     - Now suports combinations across chapters, eg, John 3:16-4:1 and comma delimeted verses, eg,  John 3:16,4:1 and John 3,4,5:16
##
##   2004-06-04 - Version 0.2.0b
##      - Allowed roman numerials like I II to be used instead of 1 and 2
##      - Removed short form 'is' of Isaiah as it cause confusion with the English word 'is'
##
##   2004-06-03 - Version 0.1.0b
##      - Initial release
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/bbcode.php
#
#-----[ FIND ]------------------------------------------
#
// Remove our padding..
#
#-----[ BEFORE, ADD ]------------------------------------------
#
  //-- start add: Clickable bible verse -----------
  // matches an "verse yy:yy-zz" where - and zz are optional
  // yy and zz must be digits
  // verse must be one of the allowed bible books
  // to customise the version and language refer to http://bible.gospelcom.net/help/webmaster_tools/linking.php
$ret = preg_replace("#(^|[\n ])((ge(?:n|nesis|)|ex(?:o|odus|)|le(?:v|viticus|)|nu(?:m|mbers|)|de(?:u|uteronomy|)|jos(?:h|hua|)|judg(?:es|)|ru(?:th|)|(?:1|2|(?-i)I|II) sam(?:uel|)|(?:1|2|(?-i)I|II) kin(?:gs|)|(?:1|2|(?-i)I|II) ch(?:r|ronicles|)|".
          "ez(?:r|ra|)|ne(?:h|hemiah|)|es(?:t|ther|)|job|ps(?:a|alm|alms|)|pr(?:o|overbs|)|ec(?:c|clesiastes|)|so(?:n|ng|ng of solomon|)|solomon|isa(?:iah)?|je(?:r|remiah|)|la(?:m|mentations|)|eze(?:kiel|)|da(?:n|niel|)|ho(?:s|sea|)|joel?|am(?:o|os|)|ob(?:a|adiah|)|".
          "jon(?:ah|)|mic(?:ah|)|na(?:h|hum|)|hab(?:akkuk|)|zep(?:haniah|)|hag(?:gai|)|zec(?:hariah|)|mal(?:achi|)|".
          "mat(?:t|thew|)|mark?|lu(?:k|ke|)|john?|ac(?:t|ts|)|ro(?:m|mans|)|(?:1|2|(?-i)I|II) cor(?:inthians|)|ga(?:l|latians|)|ep(?:h|hesians|)|ph(?:i|ilippians|)|col(?:ossians|)|(?:1|2|(?-i)I|II) th(?:e|essalonians|)|(?:1|2|(?-i)I|II) tim(?:othy|)|".
          "tit(?:us|)|phile(?:mon|)|heb(?:rews|)|ja(?:m|mes|)|(?:1|2|(?-i)I|II) pet(?:er|)|(?:1|2|3|(?-i)I|II|III) john?|ju(?:de|)|re(?:v|velation|)".
          ")\s(\d+((:\d+)?([,\-,]?\d+(:\d+)?)*)?))#i", "\\1<a href=\"http://bible.gospelcom.net/cgi-bin/bible?language=english&passage=\\3+\\4&version=NIV\" target=\"_blank\">\\2</a>", $ret);
  //-- fin: Clickable bible verse -----------------

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM