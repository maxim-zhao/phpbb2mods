############################################################## 
## MOD Title: Post Is Sending 
## MOD Author: R@ < meos@mail.ru > (Kirill) N/A 
## MOD Description: This mod changes post submit button text  from "Submit" to "Sending" on posting to ensure user 
## that his message is being send. And adds protection from double post 
## MOD Version: 1.1.1 
## 
## Installation Level: Easy 
## Installation Time: 3 Minutes 
## Files To Edit: posting.php 
##                privmsg.php 
##                language/lang_english/lang_main.php    
##                templates/subSilver/posting_body.tpl 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbbguru.net/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. 
############################################################## 
## Author Notes: 
##      Thanks to: 
##              Xpert < xpert@phpbbguru.net > for MOD Description 
## 
##              Jovani for idea of double post protection 
############################################################## 
## MOD History: 
## 
##   2004-06-06 - Version 1.0.0 
##      - Initial Release 
## 
##   2004-06-07 - Version 1.1.0 
##      - Double post protection added 
## 
##   2004-06-08 - Version 1.1.1 
##      - Bug with PM sending fixed 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

posting.php 

# 
#-----[ FIND ]------------------------------------------ 
# 

   'L_SUBMIT' => $lang['Submit'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

   'L_SENDING' => $lang['Sending'], 

# 
#-----[ OPEN ]------------------------------------------ 
# 

privmsg.php 

# 
#-----[ FIND ]------------------------------------------ 
# 

   'L_SUBMIT' => $lang['Submit'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

   'L_SENDING' => $lang['Sending'], 

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php 

# 
#-----[ FIND ]------------------------------------------ 
# 

$lang['Submit'] = 'Submit'; 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

$lang['Sending'] = 'Sending'; 

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/posting_body.tpl 

# 
#-----[ FIND ]------------------------------------------ 
# 

      bbstyle(-1); 
      //formObj.preview.disabled = true; 
      //formObj.submit.disabled = true; 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

      setTimeout("document.post.post.disabled = true; document.post.post.value='{L_SENDING}'", 0); 

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM