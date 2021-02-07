############################################################## 
## MOD Title: EditPlus MOD Pack
## MOD Author: DanielT < danielt@danielt.com > (Daniel Taylor) http://www.danielt.com 
## MOD Description: A clip text libary for use with EditPlus. An aid for producing MOD install templates, and more!
## MOD Version: 0.0.2 
## 
## Installation Level: Easy
## Installation Time: 3 Minutes 
## Files To Edit:  C:\program files\EditPlus 2\php.stx
## Included Files: mod.ctl
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## 
##	Cliptext Library for the phpBB MOD Template (and several other files) written by 
##	Daniel Taylor (http://www.danielt.com).
##	This file is copyright Daniel Taylor, it is _not_ released under the GNU GPL licence and is 
##	_not_ to be distrubuted in any way, without permission of the author (Daniel Taylor).
##
##	Thanks to BFL for the phpBB functions list see here for more details:
##	http://www.phpbb.com/phpBB/viewtopic.php?t=90489
##	Please contact BFL for licencing and copyright information.
##
##
##	Installing template.mod and phpbbtemplate.php:
##
##	once the files have been copied to the correct directory, run Edit Plus and on the toolbar do:
##
##	Tools -> Preferences -> Files -> Templates
##
##	Then click the 'Add' button and Type in the inbox titled 'Menu text':
##
##	phpBB MOD Template
##
##	then click the box next to to the 'File path' input box, the box containing three dots,
##	and then navigate and select the 'template.mod' file, and then press 'Ok' and then on the
##	main dialog box click 'Load',
##
##	Now...
##
##	Then click the 'Add' button and Type in the inbox titled 'Menu text':
##
##	phpBB PHP Template
##
##	then click the box next to to the 'File path' input box, the box containing three dots,
##	and then navigate and select the 'phpbbtemplate.php' file, and then press 'Ok' and then on the
##	main dialog box click 'Load',
##
##	and now press the 'Ok' button,
##
##	Enjoy!
##	-Daniel Taylor
##	-phpBB MOD Team
##
############################################################## 
## MOD History: 
## 
##	0.0.2 - "i like to see all the road thankyou very much!" ~ Lee Evans, expanded the boundries of this MOD
##	0.0.1 - Several fixes and addons
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ COPY ]------------------------------------------ 
#

copy mod.ctl to the root of your EditPlus install, (Default: C:\Program Files\EditPlus 2\)
copy template.mod to the root of your EditPlus install,
copy phpbbtemplate.php to the root of your EditPlus install,

# 
#-----[ OPEN ]------------------------------------------ 
#

C:\program files\EditPlus 2\php.stx

# 
#-----[ FIND ]------------------------------------------ 
#

#KEYWORD=Variables
#

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#

;phpBB Functions
_close_data_connection
_debug_print
_ok
_open_data_connection
_pasv
_port
_putcmd
_sql
_type
add_search_words
append_sid
array_pop
array_push
assign_block_vars
assign_var
assign_var_from_handle
assign_vars
attachfile
auth
auth_check_user
auto_prune
bbcode_array_pop
bbcode_array_push
bbencode_first_pass
bbencode_first_pass_pda
bbencode_second_pass
bbencode_second_pass_code
bcc
cc
check_access_chmod
check_access_copy
check_access_ftp_ext
check_access_mkdir
check_access_read
check_access_unlink
check_access_write
check_access_write_root
check_access_write_tmp
check_auth
check_image_type
clean_words
compile
complete_file_reproduction
create_date
decode_ip
delete_post
destroy
display_avatar_gallery
display_debug_html
display_debug_info
display_error
display_line
display_unprocessed_line
em_array_shift
em_db_insert
em_db_update
email_address
emailer
emftp_connect
emftp_mkdir_struct
emftp_mkdir_struct_copy
emftp_rootdir
emftp_rootwrite
encode
encode_file
encode_ip
escape_slashes
extra_headers
find_lang_admin
form_settings
from
ftp
ftp_cdup
ftp_chdir
ftp_connect
ftp_delete
ftp_file_exists
ftp_get
ftp_login
ftp_mdtm
ftp_mkdir
ftp_nlist
ftp_put
ftp_put_array
ftp_pwd
ftp_quit
ftp_rawlist
ftp_rename
ftp_rmdir
ftp_site
ftp_size
ftp_systype
gen_rand_string
generate_block_data_ref
generate_block_varref
generate_pagination
generate_smilies
generate_user_info
get_access_option
get_db_stat
get_em_pw
get_em_settings
get_info
get_lang_files
get_languages
get_list
get_mod_properties
get_phpbb_version
get_table_content_mysql
get_table_content_postgresql
get_table_def_mysql
get_table_def_postgresql
get_theme_files
get_themes
get_userdata
getmimeheaders
gzip_printfourchars
handle_error
helpwin
inarray
init_userprefs
is_unprocessed
language_select
load_bbcode_template
loadfile
make_bbcode_uid
make_clickable
make_filename
make_forum_select
make_jumpbox
message_die
mfungetperms
mod_io
modio_cleanup
modio_close
modio_mkdirs
modio_mkdirs_copy
modio_move
modio_open
modio_prep
modio_write
mychunksplit
obtain_word_list
open_files
output_table_content
page_footer
page_header
perform_find
perform_inline_add
pg_get_sequences
phpbb_preg_quote
phpbb_realpath
pparse
prepare_bbcode_template
prepare_message
prepare_post
prune
redirect
remove_comments
remove_common
remove_remarks
remove_search_post
renumber_order
replace_listitems
replyto
reset
send
server_parse
session_begin
session_end
session_pagestart
set_filenames
set_rootdir
set_subject
setup_style
show_coppa
smiley_sort
smilies_pass
smtpmail
split_sql_file
split_words
sql_affectedrows
sql_close
sql_db
sql_error
sql_fetchfield
sql_fetchrow
sql_fetchrowset
sql_fieldname
sql_fieldtype
sql_freeresult
sql_nextid
sql_numfields
sql_numrows
sql_query
sql_rowseek
strip_whitespace
style_select
submit_post
sync
template
topic_review
tz_select
undo_htmlspecialchars
undo_make_clickable
unprepare_message
update_post_stats
use_template
user_avatar_delete
user_avatar_gallery
user_avatar_upload
user_avatar_url
user_notification
username_search
validate_email
validate_optional_fields
validate_username
wrapper_find
wrapper_insert
write_files
write_find_array

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 

