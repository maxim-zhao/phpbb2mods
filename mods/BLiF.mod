##############################################################
## MOD Title: BBCode Link in FAQ (BLiF)
## MOD Author: Wulf_9 < webmaster@zodiac-infosystems.co.uk > (Wulf) http://www.zodiac-infosystems.co.uk
## MOD Description: Places live link to BBCode Guide in FAQ BBCode Section
##
## MOD Version: 0.0.1
##
## Installation Level: Easy
## Installation Time: 5 Minutes
##
## Files To Edit: 3
##
##        faq.php, language/lang_english/lang_faq.php, language/lang_english/lang_bbcode.php
##
## Included Files: n/a
##
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
##      Since the BBCode Guide link only appears when posting a message, this MOD
##      adds it to the 'What is BBCode' question in the FAQ. This link will also cause
##      the 'Introduction' heading containing this question in the Guide to be hidden
##      since you just read it :)
##############################################################
## MOD History:
##
##   2007-02-09 - Version 0.0.1
##
##   Initial version, nice and simple :)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
faq.php

#
#-----[ FIND ]------------------------------------------
#
if( isset($HTTP_GET_VARS['mode']) )
{
  switch( $HTTP_GET_VARS['mode'] )
  {
    case 'bbcode':
      $lang_file = 'lang_bbcode';
      $l_title = $lang['BBCode_guide'];
      break;
    default:
      $lang_file = 'lang_faq';
      $l_title = $lang['FAQ'];
      break;
  }
}

#
#-----[ REPLACE WITH ]------------------------------------------
#
if( isset($HTTP_GET_VARS['mode']) )
{
  switch( $HTTP_GET_VARS['mode'] )
  {
    case 'bbcode':
      $lang_file = 'lang_bbcode';
      $l_title = $lang['BBCode_guide'];
      break;
    case 'bbcode_no_intro':
      $lang_file = 'lang_bbcode';
      $l_title = $lang['BBCode_guide'];
      $no_intro = 1;
    break;
    default:
      $lang_file = 'lang_faq';
      $l_title = $lang['FAQ'];
      break;
  }
}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_faq.php

#
#-----[ FIND ]------------------------------------------
#
$faq[] = array("--","Formatting and Topic Types");

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$bbc_guide = '<a href="' . append_sid('faq.' . $phpEx . '?mode=bbcode_no_intro') . '"><b>BBCode Guide</b></a>';

#
#-----[ FIND ]------------------------------------------
#
$faq[] = array("What is BBCode?",
#
#-----[ IN-LINE FIND ]------------------------------------------
#
For more information on BBCode see the guide which can be accessed from the posting page

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
For more information see the $bbc_guide

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_bbcode.php

#
#-----[ FIND ]------------------------------------------
#
  $faq[] = array("--","Introduction");
  $faq[] = array("What is BBCode?", "BBCode is a special implementation of HTML. Whether you can actually use BBCode in your posts on the forum is determined by the administrator. In addition, you can disable BBCode on a per post basis via the posting form. BBCode itself is similar in style to HTML: tags are enclosed in square braces [ and ] rather than &lt; and &gt; and it offers greater control over what and how something is displayed. Depending on the template you are using you may find adding BBCode to your posts is made much easier through a clickable interface above the message area on the posting form. Even with this you may find the following guide useful.");

#
#-----[ REPLACE WITH ]------------------------------------------
#
if ( !isset($no_intro) )
{
  $faq[] = array("--","Introduction");
  $faq[] = array("What is BBCode?", "BBCode is a special implementation of HTML. Whether you can actually use BBCode in your posts on the forum is determined by the administrator. In addition, you can disable BBCode on a per post basis via the posting form. BBCode itself is similar in style to HTML: tags are enclosed in square braces [ and ] rather than &lt; and &gt; and it offers greater control over what and how something is displayed. Depending on the template you are using you may find adding BBCode to your posts is made much easier through a clickable interface above the message area on the posting form. Even with this you may find the following guide useful.");
}

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
