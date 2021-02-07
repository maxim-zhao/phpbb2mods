##############################################################
## MOD Title: Easy No BBcode Links
## MOD Author: Mittineague < N/A > (N/A) http://www.mittineague.com
## MOD Description: 	Removes the ability to use URL BBcode.
##			Removes "make clickable" text URLs.
##			Removes URL BBcode button and it's "alt-key" help.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~ 1 Minute
##
## Files To Edit:	language/lang_english/lang_main.php
##			includes/bbcode.php
##			templates/subSilver/posting_body.tpl
##			language/lang_english/lang_bbcode.php
##
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
##		URLs - not links - can still be entered in posts and
##		will be seen as non-clickable text (which can still
##		be changed by using the ACP "word censors").
##
##############################################################
## MOD History:
##
##   2007-01-08 - Version 1.0.0
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['bbcode_w_help'] = 'Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url]  (alt+w)';

# 
#-----[ REPLACE WITH ]------------------------------------
#
$lang['bbcode_w_help'] = 'No links in posts - Admin';
$lang['link_replacement_text'] = '&#60;SNIP/> No links in posts - Admin ';

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	$bbcode_tpl['url4'] = str_replace('{DESCRIPTION}', '\\3', $bbcode_tpl['url4']);

# 
#-----[ AFTER, ADD ]------------------------------------
#
	$bbcode_tpl['no_links'] = $lang['link_replacement_text'];
	$bbcode_tpl['url1'] = $bbcode_tpl['no_links'];
	$bbcode_tpl['url2'] = $bbcode_tpl['no_links'];
	$bbcode_tpl['url3'] = $bbcode_tpl['no_links'];
	$bbcode_tpl['url4'] = $bbcode_tpl['no_links'];

# 
#-----[ FIND ]------------------------------------------ 
# 
$ret = ' ' . $text;

# 
#-----[ AFTER, ADD ]------------------------------------
#
/*

# 
#-----[ FIND ]------------------------------------------ 
# 
	// Remove our padding..
	$ret = substr($ret, 1);

# 
#-----[ BEFORE, ADD ]------------------------------------
#
*/

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/posting_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
			  </span></td>

# 
#-----[ REPLACE WITH ]------------------------------------
#
			<td><span class="genmed"></span></td>

#
#-----[ DIY INSTRUCTIONS ]------------------------------------
#
This MOD does NOT remove the instructions similar
to those below regarding the use of the URL bbtags.
OPEN - language/lang_english/lang_bbcode.php
FIND -
$faq[] = array("--", "Creating Links");
$faq[] = array("Linking to another site", "phpBB BBCode supports a number of ways of creating URIs, Uniform Resource Indicators better known as URLs.
The first of these uses the [url=][/url] tag; whatever you type after the = sign will cause the contents of that tag to act as a URL.
 For example, to link to phpBB.com you could use:
[url=http://www.phpbb.com/]Visit phpBB![/url]
This would generate the following link, Visit phpBB! You will notice the link opens in a new window so the user can continue browsing the forums if they wish.
If you want the URL itself displayed as the link you can do this by simply using:
[url]http://www.phpbb.com/[/url]
This would generate the following link: http://www.phpbb.com/
Additionally phpBB features something called Magic Links which will turn any syntatically correct URL into a link without you needing to specify any tags or even the leading http://.
 For example typing www.phpbb.com into your message will automatically lead to www.phpbb.com being output when you view the message.
The same thing applies equally to email addresses; you can either specify an address explicitly, like:
[email]no.one@domain.adr[/email]
which will output no.one@domain.adr or you can just type no.one@domain.adr into your message and it will be automatically converted when you view.
As with all the BBCode tags you can wrap URLs around any of the other tags such as [img][/img] (see next entry), [b][/b], etc.
 As with the formatting tags it is up to you to ensure the correct open and close order is following. For example:
[url=http://www.phpbb.com/][img]http://www.phpbb.com/images/phplogo.gif[/url][/img]
is not correct which may lead to your post being deleted so take care.";
REMOVE
or
REPLACE WITH - your own message. Remember, using " will terminate the string.

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM 