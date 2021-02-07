############################################################## 
## MOD Title: No Double Attachments (for AttachMOD)
## MOD Author: fredol < fredol@lovewithsmg.com > (fredol) N/A
## MOD Author: Steve F < N/A > (N/A) N/A
## MOD Description: This will adds MD5 calculation/checking when an attachment is
##	posted/upgraded, and if the same file (same hash) is already in the database
##	then the file will be deleted, telling user that the file has already been
##	posted (to avoid same file posted twice)
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 1 Minute (less with the great EasyMOD! :-)
## Files To Edit:	attach_mod/posting_attachments.php
##			language/lang_english/lang_main_attach.php
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
##	Just a few changes to the great MOD that is AttachMOD ; MD5 hash will be calculated when
##	an attachment is posted/upgraded, and if the same file (same hash) is already in the database
##	when the file will be deleted, telling user that the file has already been posted (to avoid
##	same file posted twice)
##
##	To work you'll need to alter ATTACHMENTS_DESC_TABLE to store MD5hashes, and you need to have 
##	at least PHP 4.2.0 (if you have an earlier version of PHP then DO NOT INSTALL THIS MOD, it won't
##	work (since the md5_file function doesn't exists!)
##
##	IMPORTANT:
##	- You need PHP 4.2.0 or above to be able to use this MOD!!
##	- I haven't tested it with using ftp, it might not work!! (Please if you've tested it tell me if
##	  it works or not, thanks!)
##
##	And many Thanks & Congratulations to Acyd Burn for his amazing great work!! :D
##
############################################################## 
## MOD History: 
## 
##   2005-09-03 - Version 1.0.1
##      - Corrected FIND lines to work with AttachmentMod 2.3.14
##      - Added note for mssql installations
##
##   2004-06-30 - Version 1.0.0 
##	- Submitted to the MOD-DB (no changes were made)
##	- Renamed to: No Double Attachments
##
##   2004-06-21 - Version 0.0.1 
##	- First version, should work just fine ;) 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]----- 
# 
# Note: Change phpbb_ to your prefix!!!
#
ALTER TABLE `phpbb_attachments_desc` ADD `MD5hash` CHAR(32) DEFAULT '' NOT NULL ;
#
#-----[ DIY INSTRUCTIONS ]-----
#
On mssql change MD5hash field length to 32 in phpbb_attachments_desc due to EasyMOD 0.2.1 limitations with mssql
# 
#-----[ OPEN ]----- 
# 
attach_mod/posting_attachments.php
# 
#-----[ FIND ]----- 
#
#Note: full line is longer
					$sql = "INSERT INTO " . ATTACHMENTS_DESC_TABLE . " (physical_filename
# 
#-----[ BEFORE, ADD ]----- 
#
					$MD5hash = md5_file($upload_dir . '/' . $this->attachment_list[$i]);
# 
#-----[ IN-LINE FIND ]----- 
#
)
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
, MD5hash
# 
#-----[ FIND ]----- 
#
					VALUES ( 
# 
#-----[ IN-LINE FIND ]----- 
#
)";
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
, '$MD5hash'
# 
#-----[ FIND ]----- 
#
#Note: full line is longer
				$sql = "INSERT INTO " . ATTACHMENTS_DESC_TABLE . " (physical_filename
# 
#-----[ BEFORE, ADD ]----- 
#
					$MD5hash = md5_file($upload_dir . '/' . $this->attach_filename);
# 
#-----[ IN-LINE FIND ]----- 
#
)
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
, MD5hash
# 
#-----[ FIND ]----- 
#
				VALUES ( 
# 
#-----[ IN-LINE FIND ]----- 
#
)";
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
# 
, '$MD5hash'
# 
#-----[ FIND ]----- 
#
#Note: in function move_uploaded_attachment
		global $error, $error_msg, $lang, $upload_dir;
# 
#-----[ IN-LINE FIND ]----- 
#
;
# 
#-----[ IN-LINE BEFORE, ADD ]----- 
#
, $db
# 
#-----[ FIND ]----- 
#
		if ( (!$error) && ($this->thumbnail == 1) )
# 
#-----[ BEFORE, ADD ]----- 
# 
		if (!$error)
		{
			$MD5hash = md5_file($upload_dir . '/' . $this->attach_filename);
			$sql = "SELECT attach_id FROM " . ATTACHMENTS_DESC_TABLE . " WHERE MD5hash = '$MD5hash'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get existing attachments information', '', __LINE__, __FILE__, $sql);
			}
			if ($db->sql_numrows($result) > 0)
			{
				unlink($upload_dir . '/' . $this->attach_filename);
				//
				$error = TRUE;
				if(!empty($error_msg))
				{
					$error_msg .= '<br />';
				}
				$error_msg .= $lang['Attachment_already_exists'];
				return;
			}
		}

# 
#-----[ OPEN ]----- 
#
language/lang_english/lang_main_attach.php
# 
#-----[ FIND ]----- 
#
$lang['General_upload_error']
# 
#-----[ AFTER, ADD ]----- 
# 
$lang['Attachment_already_exists'] = 'Sorry but this file has already been posted!';
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 