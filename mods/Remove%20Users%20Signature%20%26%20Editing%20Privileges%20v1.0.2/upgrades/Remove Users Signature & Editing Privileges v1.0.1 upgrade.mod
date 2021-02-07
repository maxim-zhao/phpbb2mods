############################################################## 
## MOD Title: Remove Users Signature & Editing Privileges 1.0.1 upgrade
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) http://phpbb.lovewithsmg.com/ 
## MOD Description: Will allow ADMIN to remove signature & post editing priviliges to specific users
## MOD Version: 1.0.2
## 
## Installation Level: Easy 
## Installation Time: 1 Minute (less than one with the great EasyMOD! :-) 
## Files To Edit:	posting.php
## Included Files:	n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##	This MOD will add two options in ACP/Users management so you can remove signature/post editing
##	priviliges for specific users. Removing signature will make them unable to edit their signature in
##	their profile, and their signature won't show up in any new posts they have or will make.
##	Removing post editing privileges will make them unable to edit their posts.
############################################################## 
## MOD History: 
## 
##   2004-10-29 - Version 1.0.2
##	- Fixed: when users used the preview option when posting, it removed the signature from the post
##
##   2004-09-01 - Version 1.0.1
##	- Some minor changes to the MOD
##
##   2004-08-24 - Version 1.0.0
##	- Submitted to phpBB's MODDB 
##
##   2004-07-14 - Version 0.0.1 [BETA]
##	- First version, should work just fine ;) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 


# 
#-----[ OPEN ]----- 
# 
posting.php
# 
#-----[ FIND ]----- 
# 
// Signature toggle selection 
// 
//MOD-REPLACE: Remove Users Signature & Editing Privileges ---------------------------------------- 
//added: && $user_allowsig 
if( $user_sig != '' && $user_allowsig ) 
# 
#-----[ REPLACE WITH ]----- 
# 
// Signature toggle selection 
// 
//MOD-REPLACE: Remove Users Signature & Editing Privileges ---------------------------------------- 
//added: && $userdata['user_allowsig'] 
if( $user_sig != '' && $userdata['user_allowsig'] )
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 