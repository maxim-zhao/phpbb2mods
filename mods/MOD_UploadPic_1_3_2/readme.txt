	/*******************************************
	*        UploadPic, a MOD for phpBB        *
	*        --------------------------        *
	*                                          *
	*   date       : 08/2005 - 02/2006         *
	*   (C)/author : B.Funke                   *
	*   URL        : http://forum.beehave.de   *
	*                                          *
	********************************************/


UploadPic gives users of a phpBB-forum the opportunity to upload pictures to
the forum-webspace.
A lot of users don't have access to their own webspace and/or do not know how
to handle a FTP-program, so their only resource of pictures for your forum are
images already upload to the net, while the availability of those images
cannot be granted.
This is where UploadPic sets in ...



The admin
---------

UploadPic

This panel gives you an overview over all users with uploaded pictures.
The number of files and the used webspace are displayed.
The link "delete all unused images" will delete all pictures, that are not in
use in any post in the forum (or as an avatar or in a PM), to save webspace.
The function "delete old images from PMs" will delete all pictures from
private messages, if the time for keeping them is exceeded.
You can set the config to view the "latest x uploads" on this page (if you
set this value to 0, no files will be displayed).

UploadPic config

This link will open a page with setting for UploadPic. All options are
stored in the database.

UploadPic groups

Will open a list with all groups. After selecting a group you can set
(or remove) permissions for all users in this group.
Note: The permissions are saved per member only and not per group for
security reasons. Permissions are not set automatically based on
group-membership.

UploadPic recent

Will show the most recent pictures. You can configure, how many pictures
you want in this list.
Next to the images you see information on the usage, the size and the
uploader - you can also choose to delete the image (if it's not in use)
or "censor" it. This feature can be used to get rid of unwanted and/or
inappropriate pictures without having to edit the post, comb through
the database or leaving an ugly "picture not found"-icon in the post.
This way, everybody knows that a picture has been removed, the original
file is overwritten.
You can change the "censored"-pictures in your template's picture
directory: templates/subSilver/images/lang_english, there's 3 of them,
one for each format: gif/jpg/png. You should check that the pictures
are not bigger than the maximum size for avatar-pictures, if you allow
remote-avatars because in this case pictures uploaded with UploadPic
could also be used as avatars and would "break" the layout if they
are replaced with bigger "censored"-pictures.
Note: if you don't want "censored"-pictures to appear, just delete them
from your webspace, uploaded pictures will be deleted in this case, if
you "censor" them-

UploadPic users

With the panel you can set the permission to upload for several users at
the same time, so you don't have to edit each user profile in large forums.
Clicking the username will open a detailed view, pictures not in use are
marked with a "delete"-link, clicking a filename will show the image in a new
window.




UploadPic will allow the uploaded pictures to be inserted using the BBCode-
[img]-Tag (the picture will be visible in the post itself), with left-/right-
alignment, if you have the lef/right-MOD installed, or using the [url]-Tag (or
both, can be changed in the configuration).
If you allow picture to be uploaded that are too big and would "break" the
forum-layout, I recommend to only permit the use of the [url]-Tag. The picture
will be inserted into the post as a textlink, clicking it will open a new
window showing the uploaded image.
If you experience problems with uploading, try to lower the allowed image-
dimensions. Some providers are known to set the memory-limits very low so
creating a big picture will result in an error.

UploadPic can be used to insert BBCode in input-fields other than the
message-textarea. To use UploadPic this way, it has to be called with the
variable "inputname", if the input-field's name is other than "message"
(which is the standard name of the textarea in the phpBB-file posting.php).
By using the variable "inputname" you can use UploadPic with the MOD
"Quick Reply" (or others).
The code to insert in those MODs and further information on how to use the
variable can be found in the FAQ, III. 5.:
http://www.beehave.de/forum/viewtopic.php?t=574

You can make UploadPic work with the "Knowledge Base". To prepare the
necessary Knowledge Base-files, execute the code found in the FAQ, III. 7.:
http://www.beehave.de/forum/viewtopic.php?t=574

You can make UploadPic work with "easyCMS". To prepare the necessary
files, execute the code found in the FAQ, III. 11.:
http://www.beehave.de/forum/viewtopic.php?t=574

Beyond this, I can and will NOT offer any more support for other people's
MODs nor will I take responsibility for using this code in other MODs.




Hints for the installation:

The provided .tpl-files are to be changed/uploaded for all installed templates
of your forum. Because "subSilver" is the standard template for phpBB, build
this MOD based on subSilver (even though I don't use it myself :).
As it's impossible to know all templates, I cannot grant any support for
problems with templates different to subSilver
The directory "translations" contains the changes for languages other than
english. If you're using a different language in your forum, you will have
to perform the changes from the specific file after you made those found in
the file "uploadpic.txt" (in the archive's root).
Files found in this directory will change THE LANGUAGE FILES ONLY. To install
UploadPic the file /uploadpic.txt has to be executed.
If somebody translated StatusMail to his/her language and wants to share
his/her effort, please send over your files so I can include them in the
next update.

Important:
After uploading/changing the files, you will have to execute
/install/install_uploadpic.php once. Afterward the install-directory needs to
be deleted.

To set the the standard-permission for picture-upload to "yes", change the
file install_uploadpic.php BEFORE executing it. Change line:
	$sql[] = 'ALTER TABLE ' . USERS_TABLE . ' ADD user_allow_uploadpic TINYINT NOT NULL DEFAULT 0';
to:
	$sql[] = 'ALTER TABLE ' . USERS_TABLE . ' ADD user_allow_uploadpic TINYINT NOT NULL DEFAULT 1';

or, if you're using PostgreSQL, change the lines:
	$sql[] = 'ALTER TABLE ' . USERS_TABLE . ' ALTER COLUMN user_allow_uploadpic SET DEFAULT 0';
	$sql[] = 'UPDATE TABLE ' . USERS_TABLE . ' SET user_allow_uploadpic = 0 WHERE user_allow_uploadpic IS NULL';
to:
	$sql[] = 'ALTER TABLE ' . USERS_TABLE . ' ALTER COLUMN user_allow_uploadpic SET DEFAULT 1';
	$sql[] = 'UPDATE TABLE ' . USERS_TABLE . ' SET user_allow_uploadpic = 1 WHERE user_allow_uploadpic IS NULL';

If you like to change the name of the userpix-directory, change word "userpix"
in the following line:
$str_updirname = 'userpix';
(if you want the directory somewhere else, enter a path, e.g. 'images/userpix')



Hints about security:

This MOD is provided "AS IS". Even though all functions and security-checks of
this MOD have been thoroughly tested, I cannot grant responsibility of any
kind, concerning any result based on the installation/use of this MOD
(intended or not). The use of this MOD is at your own risk.

If your server-configuration allows the viewing of directories via a browser,
I recommend putting an index.htm-file into the UploadPic-directory, so
noone can view the directory-contents by calling the directory-URL in a
browser. Just copy the file "index.htm" from the directory "images" and put
it into your UploadPic-directory.

UploadPic can be freely copied and used, as long as all provided files remain
unchanged. For all further terms, the GNU GENERAL PUBLIC LICENSE applies to
this MOD.


Again: UploadPic can be used to fill your webspace with junk and increase your
forum-traffic. If you don't have a lot of diskspace, only give permission to
upload to users you know and trust, so you don't wake up without any webspace
left just because a user thought it was a good idea to upload his/her whole
photo-collection to your forum.


Another thing I DON'T recommend, is the setting of the flag "uploadpic_delete"
to "false", especially in combination with the flag "uploadpic_uniqfn" set to
"true":
uploadpic_delete determins, if uploaded pictures will be deleted to safe
diskspace, if the user doesn't want to use the uploaded picture and clicks
"back" or "cancel". If you (the admin) have to know, what pictures where
uploaded and *not* used afterwards, set this flag to "false".
uploadpic_uniqfn makes the MOD to check for existing files after each upload.
If a file with the same name already exists, the combination "_NR" will be
attached to the filname, "NR" being a counter. This is to prevent users from
overwriting files when they upload different pictures with the same name.


Furthermore: is is not a good idea to add more file-types to the list of
allowed ones. Without the use of external programs (not included), PHP is not
able to process tif- or bmp-files. Non-picure files should never be added
(despite the compromised security of your forum, they'd cause script errors,
too).



Hints about support:

For suggestions for UploadPic, bug reports / problems or expressions of
gratitude :), you can use my forum:
http://www.beehave.de/forum/viewforum.php?f=17

Before you ask questions or have general problems with "modding" of phpBB,
I recommend the articles concerning those topics on phpbb.de/phpbb.com.
Inquiries that are already covered in this documentation and/or the FAQ in
my forum (http://www.beehave.de/forum/viewtopic.php?t=574) or general
problems/questions about the use of PHP/FTP/SQL etc. will NOT be answered -
I do have a live away from the machine, you know ;)

For general help on how to install MODs in phpBB see here:
http://www.phpbb.com/mods/faq.php
for instructions on how to use phpMyAdmin see here:
http://www.phpbb.com/phpBB/viewtopic.php?t=74143



have fun, BF
