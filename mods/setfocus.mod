#################################################################
## MOD Title: Form SetFocus MOD
## MOD Author: AbelaJohnB <abela@phpbb> (John B. Abela) http://www.johnabela.com/
## MOD Description: This MOD will set your cursor to be auto-focused on most (but not all) forms
##                  within phpBB. Uses simply JavaScript.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~15 minutes
## Files To Edit: 
##                   templates/subSilver/overall_header.tpl
##                   templates/subSilver/login_body.tpl
##                   templates/subSilver/posting_body.tpl
##                   templates/subSilver/profile_add_body.tpl
##                   templates/subSilver/profile_send_email.tpl
##                   templates/subSilver/profile_send_pass.tpl
##                   templates/subSilver/search_body.tpl
##                   templates/subSilver/admin/board_config_body.tpl
##                   templates/subSilver/admin/category_edit_body.tpl
##                   templates/subSilver/admin/user_edit_body.tpl
##
## Included Files: n/a
#################################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
#################################################################
## Author Notes:
## Copyright © John B. Abela, < abela@johnabela.com >
##
## I do not allow distribution of my MOD's anywhere except http://www.phpBB.com/ or my own site,
## (in full or partial format). If you intend to take my work and add to it, you must retain my above
## Copyright and notify me of your actions via email. http://www.johnabela.com/  - abela@phpbb.com
## This does not mean you have to ask me to -use- this MOD, but that does mean you cannot -distribute-
## this MOD without my direct and express permission!
##
##  Please note: I have not done _every_ form within phpBB. The below instructions are for applying
##  this MOD to the most common (or something like that) forms that I find myself using.
##  If you can't figure out how to apply it to the rest... perhaps you shouldn't be using this MOD :P
##
## ~ John B. Abela
##
#################################################################
## MOD History:
##
##   2003-06-12 - Version 1.0.0
##      - Initial Release :) 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
#################################################################

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/overall_header.tpl

#
#-----[ FIND ]------------------------------------------
#

</head>

#
#-----[ AFTER, ADD ]------------------------------------------
#

<script type="text/javascript">
<!--
function SetFocus()
{
var NumElements=document.form.elements.length;
for (i=0; i<NumElements;i++)
{
    if (document.form.elements[i].type=="select" ||
        document.form.elements[i].type=="radio" ||
        document.form.elements[i].type=="button" ||
        document.form.elements[i].type=="checkbox" ||
        document.form.elements[i].type=="textarea" ||
        document.form.elements[i].type=="text")
    {
        if (document.form.elements[i].value!=" ")
             document.form.elements[i].select();
             document.form.elements[i].focus();
            break;
    }
}
}
-->
</script>

#
#-----[ FIND ]------------------------------------------
#

<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}" onload="SetFocus()">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/login_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_LOGIN_ACTION}" method="post" target="_top">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_LOGIN_ACTION}" method="post" target="_top" name="form">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_POST_ACTION}" method="post" name="form" onsubmit="return checkForm(this)">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/profile_add_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post" name="form">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/profile_send_email.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_POST_ACTION}" method="post" name="post" onSubmit="return checkForm(this)">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_POST_ACTION}" method="post" name="form" onSubmit="return checkForm(this)">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/profile_send_pass.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_PROFILE_ACTION}" method="post">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_PROFILE_ACTION}" method="post" name="form">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/search_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_SEARCH_ACTION}" method="POST">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_SEARCH_ACTION}" method="POST" name="form">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_CONFIG_ACTION}" method="post">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_CONFIG_ACTION}" method="post" name="form">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/category_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_FORUM_ACTION}" method="post">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_FORUM_ACTION}" method="post" name="form">

#
#-----[ OPEN ]------------------------------------------
#

templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#

<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post">

#
#-----[ REPLACE WITH ]------------------------------------------
#

<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post" name="form">

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM