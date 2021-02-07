##############################################################
## MOD Title: printer-friendly topic view option mod
## MOD Author: Svyatozar < svyatozar@pochtamt.ru > (N/A) N/A
## MOD Description: This mode will add a button with a printer in topic view
## MOD Version: 1.0.8
##
## Installation Level: Intermediate
## Installation Time: 10 minutes.
## Files To Edit: templates/subSilver/subSilver.cfg
##              viewtopic.php
##              templates/subSilver/viewtopic_body.tpl
##              language/lang_english/lang_faq.php
## Included Files: templates/subSilver/images/printer.gif
##              templates/subSilver/printer_header.tpl
##              templates/subSilver/printertopic_body.tpl
##              include/page_header_printer.php
##              language/lang_english/lang_printertopic.php
## Generator: MOD Studio.net [Beta 3c 1.2.1306.29431]
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes:
## NOTE: this version 1.0.8 is the same as version 1.0.8test, so do not run this file if you have 1.0.8test installed!
## After installing the mod, you may want to install additional language support by running corresponding .mod files.
## Printer-friendly Topic Mod's home page with demo forum:
## http://wiking.sourceforge.net/phpBB2/wakka.php?wakka=PrinterFriendlyTopicView
##############################################################
## MOD History:
##
##   2004-03-24 - Version 1.0.8
##      - important: this release works with phpBB version 2.0.7!
##      - no more symbols: all the buttons are now named properly
##      - introduced language files for English, Russian, Russian_tu, Romanian, Spanish
##        thanks to Vegara < Vegara [ad hoc] tomatoma [dot] ws > for Spanish translation
##        and to bog_tom (Bogdan) < bog_tom@yahoo.com > for Romanian translation
##        please send your translation(s) to http://wiking.sourceforge.net/phpBB2/viewtopic.php?t=3
##      - improved user interface, more intuitive look and feel, javascript "Print" button to start printing
##        thanks to wirewolf (http://shipmodeling.info) for his ideas on how to improve the look of this mod
##      - version 1.0.8 has been tested for almost 3 months so far and is being released without major changes
##
##   2003-11-16 - Version 1.0.7
##      - bugfix release: now fonts in the printer-friendly view are totally template-independent  
##      - added some {} inside if clauses, to conform with the phpbb coding standart
##      - added a faq section to the forum
##
##   2003-10-05 - Version 1.0.6
##      - now finish_rel when negative enables old msgcount's functionality
##      - changed everything that goes with the additional use of finish_rel
##      - major improvement in the clarity of the code, hoping to officially release it soon
##
##   2003-10-05 - Version 1.0.5
##      - this mod is now 100% easymod compatible, thanks to POilf for the example code
##      - alternate text for "printer-friendly" button is now: |##| -> |=|
##
##   2003-09-21 - Version 1.0.4
##      - replaced msgcount with finish_rel get variable to improve on user interface
##      - added start_rel get variable to improve on user interface
##      - added possibility for reader to set a range of messages to print
##      - each message in a topic now has a number shown in the beginning in the printer view
##
##   2003-09-14 - Version 1.0.3
##      - fixed an inconsistent bug of missing timezone in the printer-friendly view
##      - general clean up to prepare for release
##      - passed local test of compatibility with phpBB 2.0.6
##      - passed test to comply with phpBB2 MOD validator tool
##
##   2003-07-18 - Version 1.0.2
##      - added an option for the user to remove pagination
##      - GET variable msgcount is introduced to allow change pagination in the printable view
##      - the printer button is now language independed, making the mod totally language independed
##      - you can now flip pages of a topic within the printable view mode
##      - changed separator between author and the message to make it more readable
##
##   2003-02-03 - Version 1.0.1
##      - pages beyond 1 can now be printed as well
##      - removed signatures from the printer output
##      - poll results are now always in the printer output
##
##   2003-01-21 - Version 1.0.0
##      - this mod was created from scratch when I found out that Print Engine mod (Printable Topics v2)
## apparently discontinued http://phpbb.com/phpBB/viewtopic.php?t=66347
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy printer.gif to templates/subSilver/images/printer.gif
copy printer_header.tpl to templates/subSilver/printer_header.tpl
copy printertopic_body.tpl to templates/subSilver/printertopic_body.tpl
copy page_header_printer.php to includes/page_header_printer.php
copy lang_printertopic.php to language/lang_english/lang_printertopic.php
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]------------------------------------------
#
$images['reply_locked'] = "$current_template_images/{LANG}/reply-locked.gif";
#
#-----[ AFTER, ADD ]------------------------------------------
#
$images['printer'] = "$current_template_images/printer.gif";
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
#
#-----[ AFTER, ADD ]------------------------------------------
#
if(isset($HTTP_GET_VARS['printertopic']))
{
	$start = ( isset($HTTP_GET_VARS['start_rel']) ) && ( isset($HTTP_GET_VARS['printertopic']) ) ? intval($HTTP_GET_VARS['start_rel']) - 1 : $start;
	// $finish when positive indicates last message; when negative it indicates range; can't be 0
	if(isset($HTTP_GET_VARS['finish_rel']))
	{
		$finish = intval($HTTP_GET_VARS['finish_rel']);
	}
	if(($finish >= 0) && (($finish - $start) <=0))
	{
	unset($finish);
	}
}
#
#-----[ FIND ]------------------------------------------
#
//
// End session management
//
#
#-----[ AFTER, ADD ]------------------------------------------
#
if(!file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_printertopic.'.$phpEx)))
{
	include($phpbb_root_path . 'language/lang_english/lang_printertopic.' . $phpEx);
} else
{
	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_printertopic.' . $phpEx);
}
#
#-----[ FIND ]------------------------------------------
#
	LIMIT $start, ".$board_config['posts_per_page'];
#
#-----[ REPLACE WITH ]------------------------------------------
#
	LIMIT $start, ".(isset($finish)? ((($finish - $start) > 0)? ($finish - $start): -$finish): $board_config['posts_per_page']);
#
#-----[ FIND ]------------------------------------------
#
// Post, reply and other URL generation for
// templating vars
#
#-----[ AFTER, ADD ]------------------------------------------
#
$printer_topic_url = append_sid("viewtopic.$phpEx?printertopic=1&" . POST_TOPIC_URL . "=$topic_id&start=$start&postdays=$post_days&postorder=$post_order&vote=viewresult");
#
#-----[ FIND ]------------------------------------------
#
$post_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['Post_new_topic'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
$printer_img = $images['printer'];
$printer_alt = $lang['printertopic_button'];
#
#-----[ FIND ]------------------------------------------
#
//
// Load templates
//
$template->set_filenames(array(
	'body' => 'viewtopic_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx, $forum_id);
#
#-----[ REPLACE WITH ]------------------------------------------
#
//
// Load templates
//
if(isset($HTTP_GET_VARS['printertopic']))
{
	$template->set_filenames(array(
		'body' => 'printertopic_body.tpl')
	);
} else
{
	$template->set_filenames(array(
		'body' => 'viewtopic_body.tpl')
	);
}
make_jumpbox('viewforum.'.$phpEx, $forum_id);
#
#-----[ FIND ]------------------------------------------
#
//
// Output page header
// 
$page_title = $lang['View_topic'] .' - ' . $topic_title;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
#
#-----[ REPLACE WITH ]------------------------------------------
#
//
// Output page header
//
$page_title = $lang['View_topic'] .' - ' . $topic_title;
if(isset($HTTP_GET_VARS['printertopic']))
{
	include($phpbb_root_path . 'includes/page_header_printer.'.$phpEx);
} else
{
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);
}
#
#-----[ FIND ]------------------------------------------
#
$pagination = ( $highlight != '' ) ? generate_pagination("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;highlight=$highlight", $total_replies, $board_config['posts_per_page'], $start) : generate_pagination("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order", $total_replies, $board_config['posts_per_page'], $start);
#
#-----[ REPLACE WITH ]------------------------------------------
#
if(isset($HTTP_GET_VARS['printertopic']))
{
$pagination_printertopic = "printertopic=1&amp;";
}
if($highlight != '')
{
$pagination_highlight = "highlight=$highlight&amp;";
}
$pagination_ppp = $board_config['posts_per_page'];
if(isset($finish))
{
	$pagination_ppp = ($finish < 0)? -$finish: ($finish - $start);
	$pagination_finish_rel = "finish_rel=". -$pagination_ppp. "&amp";
}

$pagination = generate_pagination("viewtopic.$phpEx?". $pagination_printertopic . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;". $pagination_highlight . $pagination_finish_rel, $total_replies, $pagination_ppp, $start);
if($pagination != '' && isset($pagination_printertopic))
{
$pagination .= " &nbsp;<a href=\"viewtopic.$phpEx?". $pagination_printertopic. POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;". $pagination_highlight. "start=0&amp;finish_rel=-10000\" title=\"" . $lang['printertopic_cancel_pagination_desc'] . "\">:|&nbsp;|:</a>";
}
#
#-----[ FIND ]------------------------------------------
#
	'FORUM_ID' => $forum_id,
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	'START_REL' => ($start + 1),
	'FINISH_REL' => (isset($HTTP_GET_VARS['finish_rel'])? intval($HTTP_GET_VARS['finish_rel']) : ($board_config['posts_per_page'] - $start)),
#
#-----[ FIND ]------------------------------------------
#
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / intval($board_config['posts_per_page']) ) + 1 ), ceil( $total_replies / intval($board_config['posts_per_page']) )),

#
#-----[ REPLACE WITH ]------------------------------------------
#
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $pagination_ppp ) + 1 ), ceil( $total_replies / $pagination_ppp )),
#
#-----[ FIND ]------------------------------------------
#
	'REPLY_IMG' => $reply_img,
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'PRINTER_IMG' => $printer_img,
#
#-----[ FIND ]------------------------------------------
#
	'L_POST_REPLY_TOPIC' => $reply_alt,
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_PRINTER_TOPIC' => $printer_alt,
#
#-----[ FIND ]------------------------------------------
#
	'U_POST_NEW_TOPIC' => $new_topic_url,
#
#-----[ AFTER, ADD ]------------------------------------------
#
	'U_PRINTER_TOPIC' => $printer_topic_url,
#
#-----[ FIND ]------------------------------------------
#
		'POST_DATE' => $post_date,
#
#-----[ BEFORE, ADD ]------------------------------------------
#
		'POST_NUMBER' => ($i + $start + 1),
#
#-----[ FIND ]------------------------------------------
#
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
#
#-----[ BEFORE, ADD ]------------------------------------------
#
if(isset($HTTP_GET_VARS['printertopic']))
{
	$gen_simple_header = 1;
}
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<td align="left" valign="bottom" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
#
#-----[ IN-LINE FIND ]------------------------------------------
#
{L_POST_REPLY_TOPIC}" align="middle" /></a>
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
&nbsp;&nbsp;&nbsp;<a target="_blank" href="{U_PRINTER_TOPIC}"><img src="{PRINTER_IMG}" border="0" alt="{L_PRINTER_TOPIC}" align="middle" /></a>
#
#-----[ FIND ]------------------------------------------
#
	<td align="left" valign="middle" nowrap="nowrap"><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
#
#-----[ IN-LINE FIND ]------------------------------------------
#
{L_POST_REPLY_TOPIC}" align="middle" /></a>
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
&nbsp;&nbsp;&nbsp;<a target="_blank" href="{U_PRINTER_TOPIC}"><img src="{PRINTER_IMG}" border="0" alt="{L_PRINTER_TOPIC}" align="middle" /></a>
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_faq.php
#
#-----[ FIND ]------------------------------------------
#
$faq[] = array("--","Private Messaging");
#
#-----[ BEFORE, ADD ]------------------------------------------
#
$faq[] = array("--","Printer-Friendly Topic View");
$faq[] = array("What is the :| |: button for? - Cancelling the board's pagination", "By clicking on this button you can locally remove the board's fixed pagination for the current topic to help your web browser do the proper pagination for printing based on actual line spacing, rather than the forum-wide limit for number of messages per page.");
$faq[] = array("What are the boxes on top of the printable output? - Range selection", "There are two boxes on top of the page and a tape-recorder-like button Show. They allow to select a range of messages. Note that every message in the printable view has a number. Use those numbers to fill out the boxes on top to set up the first and the last message you want to be printed, and press the Show button to rearrange the messages. Another way to set a range is to put a negative number in the second box, which will mean that you want -n of messages to be printed. For example, 4 7 will output messages 4, 5, 6, 7. However if you enter values 4 -7 in first and second box respectively, messages 4, 5, 6, 7, 8, 9, 10 will be shown after you press the rewind button.");
$faq[] = array("How to print only one message? - Advanced range selection", "First, go to the printable view of the topic by pressing the Printer button in the topic view. Find your message and note the number in the left of it. Type that number into the first box in the top left of the printable view. In the second box put value -1 and press the Show button. This will tell the database to output only one message starting from the given one. Another way of getting this result is by putting the same number in both boxes. Let's say you want to print only the message number 16. Fill out the boxes in the top as such: 16 -1 and press the go button Show. Instead of 16 and -1 you could as well enter 16 and 16. The result will be the same. This example will work only if there are at least sixteen messages in the current topic, of course.");
$faq[] = array("More questions?", "Detailed documentation and support forums are <a href=\"http://wiking.sourceforge.net/phpBB2/wakka.php?wakka=PrinterFriendlyTopicView\">here</a>");
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM

