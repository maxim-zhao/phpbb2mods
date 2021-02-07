##############################################################
## MOD Title: userfriendly URL-input while posting
## MOD Author: Tsjakkaa < tsjakkaa@lycos.nl > (N/A) N/A
## MOD Description: This MOD makes it easier for the user to add a link text while posting.
##                When inserting a [url]-tag, it will prompt for the URL and link text of the URL
##               The complete bbcode-tag will be added this to the message.
##               It's just to force gently to add a text when adding a link
##
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 3 Minutes
## Files To Edit:
##            posting.php
##            language/lang_english/lang_main.php
##            templates/subSilver/posting_body.tpl
##
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
##
##############################################################
## MOD History:
##
##   2005-01-05 - Version 0.1.0
##      - first (beta) release of this MOD
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]---------------------------------------------
#
posting.php

#
#-----[ FIND ]---------------------------------------------
# Line 1006
   'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],


#
#-----[ AFTER, ADD ]---------------------------------------------
#
   'L_BBCODE_URL_LOCATION' => $lang['bbcode_url_location'],
   'L_BBCODE_URL_TEXT' => $lang['bbcode_url_text'],

#
#-----[ OPEN ]---------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]---------------------------------------------
# Line 390
$lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';


#
#-----[ AFTER, ADD ]---------------------------------------------
#
$lang['bbcode_url_location'] = 'Enter the URL';
$lang['bbcode_url_text'] = 'Enter link text';

#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]---------------------------------------------
# Line 190
   } else { // Open tags


#
#-----[ AFTER, ADD ]---------------------------------------------
#
      if(bbnumber == 16){ // inserting a new URL-tag
         var URL = prompt('{L_BBCODE_URL_LOCATION}' , 'http://');
         if(URL && URL != 'http://'){
            var linktext = prompt('{L_BBCODE_URL_TEXT}' , URL.replace("http://", ""));
            if(linktext){
                txtarea.value += "[url=" + URL + "]" + linktext + bbtags[bbnumber+1];
             }
             else{
                txtarea.value += bbtags[bbnumber] + URL + bbtags[bbnumber+1];
             }
             txtarea.focus();
              return;
         }
         else{
            return;
         }

        }

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM