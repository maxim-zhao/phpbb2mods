##############################################################
## MOD Title: Music Player
## MOD Author: subAVLHPF < watt.john.runyon@gmail.com > (John F. R.) N/A
## MOD Description: Plays Music (preloaded with some music from Google Video)
## MOD Version: 2.0.0
##
## Installation Level: (Easy)
## Installation Time: 3 Minutes
## Files To Edit: lang_main.php,
##      includes/constants.php
##
## Included Files: music.php,
##      music.tpl
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: This adds any music with an EMBED code, I find Google Video (http://video.google.com) useful for this
## I am looking for a coder to make an MP3 player in flash for this.
##
##############################################################
## MOD History:
##
##   2006-06-07 - Version 1.5.0
##      - Added ability to sort songs
##
##   2006-06-07 - Version 1.4.0
##      - Fixed bug that would not display list of songs
##
##   2006-06-07 - Version 1.1.0 thru 1.3.0
##      - Undocumented
##
##   2006-06-07 - Version 1.0.2
##      - Added version check
##
##   2006-06-07 - Version 1.0.1
##      - Began using template system, thus lowering the quality of it.
##
##   2006-05-19 - Version 0.0.5
##      - Added append_sid() to links.
##
##   2006-05-19 - Version 0.0.1
##      - First Version
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 

#
#-----[ SQL ]------------------------------------------
#
CREATE TABLE `phpbb_music` (
  `name` varchar(200) NOT NULL default '',
  `link` varchar(200) NOT NULL default '',
  `code` text NOT NULL,
  PRIMARY KEY  (`link`)
);
INSERT INTO `phpbb_music` (`name`, `link`, `code`) VALUES ('Breaking Benjamin: So Cold', 'socold', '<embed style="width:400px; height:326px;" id="VideoPlayback" align="middle" type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?videoUrl=http%3A%2F%2Fvp.video.google.com%2Fvideodownload%3Fversion%3D0%26secureurl%3DwAAAAG7ggqAHSiJjpW0D3w4aYTWOA35rlbiNXoObEaCnrh4EQGaNBOWE9SHOOQLkxrbQkc6eb2rZKZc30XNOCrRYyg71oXDomDMl77OP1rVtlaSnZEt19sZYEq5Syf0PNTAdAAOztbPcU8LnJ2s8vg5w8AlRXUFAAa69JgtZ9viMQe_qKNcv1kgk_H8cPrC9lGOlAdhfksh19ancyXkd5CDzUIOncJ-vz8Hh5z4xSUaoL2SSH39nhOm9OUt1Ah2lZ-ZwWq29OxzGnHB_jiwWuPvdrj4%26sigh%3DaldZZfNGvqOLFx2Y5lp60NC-d-c%26begin%3D0%26len%3D270135%26docid%3D4683399794446875827&thumbnailUrl=http%3A%2F%2Fvideo.google.com%2FThumbnailServer%3Fapp%3Dvss%26contentid%3Da731c5b2997e81ad%26second%3D5%26itag%3Dw320%26urlcreated%3D1147643264%26sigh%3DbbJ6shxsxJy1g6H-z5-PjwUbS-U&playerId=4683399794446875827" allowScriptAccess="sameDomain" quality="best" bgcolor="#ffffff" scale="noScale" wmode="window" salign="TL"  FlashVars="playerMode=embedded"> </embed>'),
('Linkin Park: Nobodys Listening (9/11 Tribute)', '911', '<embed style="width:400px; height:326px;" id="VideoPlayback" align="middle" type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docId=1877812124384546215" allowScriptAccess="sameDomain" quality="best" bgcolor="#ffffff" scale="noScale" salign="TL"  FlashVars="playerMode=embedded"> </embed>'),
('Bot(en) Anna (English Subs)', 'botanna', '<embed style="width:583px; height:475px;" id="VideoPlayback" align="middle" type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docId=6880888700625496919" allowScriptAccess="sameDomain" quality="best" bgcolor="#ffffff" scale="noScale" salign="TL"  FlashVars="playerMode=embedded"> </embed>');

#
#-----[ COPY ]------------------------------------------
#
copy root/music.php to music.php
copy root/templates/subSilver/music.tpl to templates/subSilver/music.tpl

#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php

#
#-----[ FIND ]------------------------------------------
#
define('PAGE_GROUPCP', -11);

#
#-----[ AFTER, ADD ]------------------------------------------
#
define('PAGE_MUSIC', -1315);

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
// $lang['TRANSLATION'] = '';

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// BEGIN MUSIC PAGE MOD
$lang['musicintro'] = '';
$lang['th_musicintro'] = 'Introduction to the Music Player';
$lang['music']['th']['author'] = 'Author:';
$lang['music']['th']['song'] = 'Song';
$lang['music']['page']['title'] = 'Music Page';
$lang['music']['th']['player'] = 'Music Player';
// END MUSIC PAGE MOD
//

#
#-----[ DIY INSTRUCTIONS ]------------------------------------------
#
Note that this MOD will NOT add a link to the music player. It will be located at music.php in your forum root directory
You may want to edit the text in language/YOUR_LANGUAGE/lang_main.php variable $lang['musicintro'] if you want an "introduction to the music player" to be displayed below where the music shows.

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
