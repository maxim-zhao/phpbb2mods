############################################################## 
## MOD Title: Removes number of times a post is edited
## MOD Author: jim_i_am < N/A > (N/A) N/A
## MOD Description:  This simple MOD removes the 'number of times 
## edited' notation that's part of the "Last edited by . . ." 
## line phpBB adds to the end of every edited post.
## MOD Version: 1.0.2
## 
## Installation Level: (Easy) 
## Installation Time: 1 Minute 
## Files To Edit: language/lang_english/lang_main.php
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: I tend to be compulsive about removing typos in a 
## post.  Also, I keep seeing ways to make my comment/question/answer
## clearer.  It’s embarrassing to see how many times I edit a post, 
## so I assume it’s the same for other people who do this. :)  By 
## default phpBB adds the number of times edited to the ‘Edited by . . . 
## time & date?line at the end of edited posts.  This MOD removes the 
## number of times edited from this line. 
##
## I’m writing up this MOD, but the credit goes to Shawn Sorrell 
## (Wild Joker Design), who provided invaluable assistance when I 
## set up my board.
############################################################## 
## MOD History: 
## 
##   2005-05-29 - Version 1.0.0
##	  - Initial version
## 
##   2005-06-15 - Version 1.0.1
##	  - made requested MOD formatting changes
## 
##   2005-06-15 - Version 1.0.
##        - corrected typo in file path
##	  - made requested textual formatting changes
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
#
#-----[ OPEN ]---------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]---------------------------------------------
#
$lang['Edited_time_total'] = 'Last edited by %s on %s; edited %d time in total'; // Last edited by me on 12 Oct 2001; edited 1 time in total
$lang['Edited_times_total'] = 'Last edited by %s on %s; edited %d times in total'; // Last edited by me on 12 Oct 2001; edited 2 times in total
#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Edited_time_total'] = 'Last edited by %s on %s'; // Last edited by 'username' on 5/29/05
$lang['Edited_times_total'] = 'Last edited by %s on %s'; // Last edited by 'username' on 5/29/05
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM