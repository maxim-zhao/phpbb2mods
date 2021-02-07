##############################################################
## MOD Title: AntiSpam Mod
## MOD Author: deMone < mail@demone.net.ru > (Evgeny Neverov) http://evgeny.neverov.name
## MOD Description: Protects your forum from automatically dispatched spam
## MOD Version: 1.0.3
##
## Installation Level: EASY
## Installation Time: 3 minutes
## Files To Edit: posting.php
##		 includes/constants.php
##               templates/subSilver/posting_body.tpl
##		 language/lang_english/lang_main.php
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
## Attention: if you use forms for a prompt reply (for example, quick_reply),
## add <input>-s code in a HTML-code of those template files
##
## Note: Instead of «any text» (in "define"-command in includes/constants.php)
## specify some casual line - on its basis protection will
## beconstructed. Can use any word, number and in general
## any text, for example: jflc9v8bdfkkg
##############################################################
## MOD History:
##   2006-01-20 - Version 1.0.2
##        + initial release
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]---------------------------------
#
posting.php

#
#-----[ FIND ]---------------------------------
#
$bbcode_uid = '';

#
#-----[ AFTER, ADD ]---------------------------------
#
			$hcode=$HTTP_POST_VARS[md5($userdata['username'] . $HTTP_POST_VARS['date'] . ANTISPAM)];
			if (isset($hcode) && !empty($hcode) && $hcode==md5($userdata['username'] . $userdata['user_regdate']) && (gmdate('U')-$HTTP_POST_VARS['date'])<600) {

#
#-----[ FIND ]---------------------------------
#
					submit_post($mode, $post_data, $return_message, $return_meta, $forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on, $html_on, $smilies_on, $attach_sig, $bbcode_uid, str_replace("\'", "''", $username), str_replace("\'", "''", $subject), str_replace("\'", "''", $message), str_replace("\'", "''", $poll_title), $poll_options, $poll_length);
				}

#
#-----[ AFTER, ADD ]---------------------------------
#
			} else message_die(GENERAL_MESSAGE, $lang['antispam']);

#
#-----[ FIND ]---------------------------------
#

'L_FONT_HUGE' => $lang['font_huge'], 

#
#-----[ AFTER, ADD ]---------------------------------
#

	'HCODE' => md5($userdata['username'] . $userdata['user_regdate']),
	'HCODENAME' => md5($userdata['username'] . gmdate('U') . ANTISPAM),

	'DATE' => gmdate('U'),

#
#-----[ OPEN ]---------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]---------------------------------
#

{ERROR_BOX}

#
#-----[ AFTER, ADD ]------------------------------------------
#

<input type="hidden" name="date" value="{DATE}" />
<input type="hidden" name="{HCODENAME}" value="{HCODE}" />

#
#-----[ OPEN ]---------------------------------
# You need to do this for all installed languages
#
language/lang_english/lang_main.php

#
#-----[ FIND ]---------------------------------
#
$lang['Found_search_matches'] = 'Search found %d matches'; // eg. Search found 24 matches

#
#-----[ AFTER, ADD ]------------------------------------------
# You need to do this for all installed languages
#
$lang['antispam'] = 'Mistake! There was an attempt of an automatic insert of the message in a forum. Your message is sent to hell. Try still times who knows - can it will turn out? Still probably, that you too long wrote the message - then pass to page back, copy the text, update page, insert the copied text and press button "Send".';

#
#-----[ OPEN ]---------------------------------
#
includes/constants.php

#
#-----[ FIND ]---------------------------------
#
define('MOD', 2);

#
#-----[ AFTER, ADD ]------------------------------------------
#
define('ANTISPAM', 'any text');

#
#-----[ SAVE/CLOSE ALL FILES ]---------------------------------
#
# EoM