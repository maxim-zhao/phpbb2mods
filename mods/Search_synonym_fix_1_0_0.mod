##############################################################
## MOD Title: Correct search synonyms
## MOD Author: jelv1 < N/A > (John Elvin) N/A
## MOD Description: Corrects the indexing and searching for entries in the synonyms file. (see bug #824)
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 1 minutes
## Files To Edit: includes/functions_search.php
##                search.php
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2108.38030 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Where a correctly spelled word has an incorrect synonym in language\lang_english\search_synonyms.txt
## it is indexed by the incorrect spelling. When searching not all variations found in the synonyms file are
## found. This is because interpretation of the two columns in the synonym file is the wrong way round.
## 
## IMPORTANT
## After applying this mod the indexing of existing posts needs to be corrected using the
## Rebuild Search mod here: http://www.phpbb.com/phpBB/viewtopic.php?t=329629
##############################################################
## MOD History:
## 
## 2006-01-26 - Version 1.0.0
## Mod created from previously applied and tested hand patches
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
# Correct indexing - incorrect words are indexed as correct equivalent
# 
includes/functions_search.php
#
#-----[ FIND ]------------------------------------------
#
list($replace_synonym, $match_synonym) = split(' ', trim(strtolower($synonym_list[$j])));

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$replace_synonym, $match_synonym

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$match_synonym, $replace_synonym

#
#-----[ OPEN ]------------------------------------------
#
# Correct highlighting so that all equivalents are highlighted
# 
search.php
#
#-----[ FIND ]------------------------------------------
#
list($replace_synonym, $match_synonym) = split(' ', trim(strtolower($synonym_array[$k])));

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$replace_synonym, $match_synonym

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
$match_synonym, $replace_synonym

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
