################################################################ 
## MOD Title:           Pseudo WYSIWYG BBcode Editor
## MOD Author:        Templater < N/A > (N/A) http://www.phpchb.robot1.org
##                           
## MOD Description:  This mod improves and enhances the posting body page so it makes
##                          it to look like a WYSIWYG (but actually it is not). Plus, this mod 
##                          adds new BBcodes for a better text formatting of your posts.
##
## MOD Version:         1.7.1
## 
## Installation Level:  EASY
## Installation Time:   ~25 minutes
## Files To Edit:       7
##                      Posting.php,
##                      privmsg.php
##                      includes/bbcode.php, 
##                      language/lang_english/lang_main.php, 
##                      templates/subSilver/bbcode.tpl,
##                      templates/subSilver/posting_body.tpl,
##                      templates/subSilver/subSilver.cfg 
## Included Files:      18
##                      templates/subSilver/ps_wysiwyg.tpl
##                      templates/subSilver/images/editor(directory)  
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
##              - Works with the latest version of phpBB2 (2.0.21)+ 
##              - EasyMod compliant (So you can flawlessly install it with easy mod!)
##
################################################################ 
## MOD History:
##   
##               Apr-08-2006 
##               + Version 1.0.0 - MOd Released    
##               Apr-16-2006 
##               + Version 1.0.1 - Corrected a typo in a part of a line code   
##               Apr-20-2006
##               + Version 1.1.0 - Added the Font family text format drop down menu 
##               Apr-22-2006
##               + Version 1.1.1 - Fixed a bug in the Font family drop down menu
##               Apr-25-2006
##               + Version 1.1.2 - Fixed another bug in the font family drop down menu
##               Apr-26-2006
##               + Version 1.5.0 - In this new release, the Pseudo WYSIWYG
##                                      BBcode Editor Has it's own tpl file for the sake
##                                      of lighten the size and bandwith of posting_body.tpl
##                                      therefore the WYSIWYG Editor will load faster! :D.
##                                      (To make this possible a couple of new code lines
##                                      were added to posting.php) In addition, the font
##                                      color drop list was enhanced, and the hard-coded 
##                                      English part (lang_main.php) of the BBcodes were
##                                      assigned to it's respeftive BBcode buttons.
##               May-02-2006          
##               + Version 1.5.1c - Fixed some minor bugs related to the hard-coded
##                                        English language code system.
##               May-20-2006          
##               + Version 1.7.0 -  Added the Alignment BBcode Suite mod, so now you
##                                        can justify align your posts and wrap text around
##                                        images!
##               Jun-15-2006
##               + Version 1.7.0a - Only some instructions of this mod template were updated.
##               Aug-17-2006
##               + Version 1.7.1 -  Fixed a security issue regarding [IMg=left|right] BBcodes.
##                                  
##                            
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################


#
#-----[ COPY ]------------------------------------------------
#
copy root/*.* to *.*
# 
#-----[ OPEN ]------------------------------------------ 
# 
posting.php 
# 
#-----[ FIND ]------------------------------------------
#
<?php
# 
#-----[ AFTER, ADD ]------------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.1 -----------------------------------
# 
#-----[ FIND ]------------------------------------------- 
#
	'L_BBCODE_B_HELP' => $lang['bbcode_b_help']
# 
#-----[ BEFORE, ADD ]-------------------------------------
# 	
//
// All this is no longer needed, it was added a few lines below
// by mod: Pseudo WYSIWYG BBcode Editor
//	
/*
# 
#-----[ FIND ]------------------------------------------- 
#
	'L_STYLES_TIP' => $lang['Styles_tip'],	
# 
#-----[ AFTER, ADD ]-------------------------------------
# 	
*/
# 
#-----[ FIND ]------------------------------------------- 
#
	'S_HIDDEN_FORM_FIELDS' => $hidden_form_fields)
);	
# 
#-----[ AFTER, ADD ]-------------------------------------
# 	

//-- mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------ 
//-- add
$template->set_filenames(array(
	'editor' => 'ps_wysiwyg.tpl')
);	

//
// Output the data to the template for Pseudo WYSIWYG BBcode Editor
//
$template->assign_vars(array(
	'L_FONT_FAMILY' => $lang['Font_family'],
	'L_FONT_ARIAL' => $lang['font_arial'],
	'L_FONT_GEORGIA' => $lang['font_georgia'],
	'L_FONT_IMPACT' => $lang['font_impact'],
	'L_FONT_SYMBOL' => $lang['font_symbol'],
    'L_FONT_TAHOMA' => $lang['font_tahoma'],
	'L_FONT_TIMES_NEW_ROMAN' => $lang['font_times_new_roman'],
	'L_FONT_VERDANA' => $lang['font_verdana'],
	'L_FONT_WEBDINGS' => $lang['font_webdings'],	
 
 	'L_FONT_COLOR' => $lang['Font_color'],
	'L_COLOR_DARK_RED' => $lang['color_dark_red'], 
	'L_COLOR_RED' => $lang['color_red'], 
	'L_COLOR_ORANGE' => $lang['color_orange'], 
	'L_COLOR_BROWN' => $lang['color_brown'], 
	'L_COLOR_YELLOW' => $lang['color_yellow'], 
	'L_COLOR_GREEN' => $lang['color_green'], 
	'L_COLOR_OLIVE' => $lang['color_olive'], 
	'L_COLOR_CYAN' => $lang['color_cyan'], 
	'L_COLOR_BLUE' => $lang['color_blue'], 
	'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'], 
	'L_COLOR_INDIGO' => $lang['color_indigo'], 
	'L_COLOR_VIOLET' => $lang['color_violet'], 
	'L_COLOR_WHITE' => $lang['color_white'], 
	'L_COLOR_BLACK' => $lang['color_black'],
	
	'L_FONT_SIZE' => $lang['Font_size'], 
	'L_FONT_TINY' => $lang['font_tiny'], 
	'L_FONT_SMALL' => $lang['font_small'], 
	'L_FONT_NORMAL' => $lang['font_normal'], 
	'L_FONT_LARGE' => $lang['font_large'], 
	'L_FONT_HUGE' => $lang['font_huge'],	
	
	'L_BBCODE_B_HELP' => $lang['bbcode_b_help'], 
	'L_BBCODE_I_HELP' => $lang['bbcode_i_help'], 
	'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
	'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'], 
	'L_BBCODE_C_HELP' => $lang['bbcode_c_help'], 
	'L_BBCODE_L_HELP' => $lang['bbcode_l_help'], 
	'L_BBCODE_O_HELP' => $lang['bbcode_o_help'], 
	'L_BBCODE_P_HELP' => $lang['bbcode_p_help'], 
	'L_BBCODE_W_HELP' => $lang['bbcode_w_help'], 
	'L_BBCODE_A_HELP' => $lang['bbcode_a_help'], 
	'L_BBCODE_S_HELP' => $lang['bbcode_s_help'], 
	'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
	'L_BBCODE_D_HELP' => $lang['bbcode_d_help'],
	'L_BBCODE_E_HELP' => $lang['bbcode_e_help'],
	'L_BBCODE_G_HELP' => $lang['bbcode_g_help'],	
	'L_BBCODE_J_HELP' => $lang['bbcode_j_help'],	
	'L_BBCODE_X_HELP' => $lang['bbcode_x_help'],
	'L_BBCODE_Y_HELP' => $lang['bbcode_y_help'],
	'L_BBCODE_Z_HELP' => $lang['bbcode_z_help'],	
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],
 
	'L_STYLES_TIP' => $lang['Styles_tip'],
	
//
// Pseudo WYSIWYG BBcode Editor (Icons)
//
	'WYSIWYG_EDITOR_BOLD' => $images['icon_bold'],
	'WYSIWYG_EDITOR_ITALIC' => $images['icon_italic'],
	'WYSIWYG_EDITOR_UNDERLINE' => $images['icon_underline'],
	'WYSIWYG_EDITOR_JUSTLEFT' => $images['icon_jl'],
	'WYSIWYG_EDITOR_JUSTCENTER' => $images['icon_jc'],	
	'WYSIWYG_EDITOR_JUSTRIGHT' => $images['icon_jr'],
	'WYSIWYG_EDITOR_JUSTIFY' => $images['icon_jy'],	
	'WYSIWYG_EDITOR_ORDERLIST' => $images['icon_orlist'],
	'WYSIWYG_EDITOR_LIST' => $images['icon_list'],
	'WYSIWYG_EDITOR_IMAGELEFT' => $images['icon_imageleft'],	
	'WYSIWYG_EDITOR_IMAGE' => $images['icon_image'],
	'WYSIWYG_EDITOR_IMAGERIGHT' => $images['icon_imageright'],	
	'WYSIWYG_EDITOR_HTTP_WWW' => $images['icon_url'],	
	'WYSIWYG_EDITOR_X_CODE' => $images['icon_code'],
	'WYSIWYG_EDITOR_QUOTE' => $images['icon_quotation'],
	'WYSIWYG_EDITOR_CLOSE_ALL_TAGS' => $images['icon_caot'],	
	'WYSIWYG_EDITOR_SPACER' => $images['spacer'])	
);

$template->assign_var_from_handle('PSEUDO_WYSIWYG_EDITOR', 'editor');	
//-- fin mod : Pseudo WYSIWYG BBcode Editor --------------------------------------	
# 
#-----[ OPEN ]------------------------------------------ 
# 
privmsg.php 
# 
#-----[ FIND ]------------------------------------------
#
<?php
# 
#-----[ AFTER, ADD ]------------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.1 -----------------------------------
# 
#-----[ FIND ]----------------------------
# 
		'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
# 
#-----[ BEFORE, ADD ]----------------------------
# 
//
// All this is no longer needed, it was added a few lines below
// by mod: Pseudo WYSIWYG BBcode Editor
//	
/*
# 
#-----[ FIND ]------------------------------------------
#
		'L_STYLES_TIP' => $lang['Styles_tip'],
# 
#-----[ AFTER, ADD ]------------------------------------
#
*/
# 
#-----[ FIND ]------------------------------------------
#
		'U_VIEW_FORUM' => append_sid("privmsg.$phpEx"))
	);
# 
#-----[ AFTER, ADD ]------------------------------------
#

//-- mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------ 
//-- add
$template->set_filenames(array(
	'editor' => 'ps_wysiwyg.tpl')
);	

//
// Output the data to the template for Pseudo WYSIWYG BBcode Editor
//
$template->assign_vars(array(
	'L_FONT_FAMILY' => $lang['Font_family'],
	'L_FONT_ARIAL' => $lang['font_arial'],
	'L_FONT_GEORGIA' => $lang['font_georgia'],
	'L_FONT_IMPACT' => $lang['font_impact'],
	'L_FONT_SYMBOL' => $lang['font_symbol'],
    'L_FONT_TAHOMA' => $lang['font_tahoma'],
	'L_FONT_TIMES_NEW_ROMAN' => $lang['font_times_new_roman'],
	'L_FONT_VERDANA' => $lang['font_verdana'],
	'L_FONT_WEBDINGS' => $lang['font_webdings'],	
 
 	'L_FONT_COLOR' => $lang['Font_color'],
	'L_COLOR_DARK_RED' => $lang['color_dark_red'], 
	'L_COLOR_RED' => $lang['color_red'], 
	'L_COLOR_ORANGE' => $lang['color_orange'], 
	'L_COLOR_BROWN' => $lang['color_brown'], 
	'L_COLOR_YELLOW' => $lang['color_yellow'], 
	'L_COLOR_GREEN' => $lang['color_green'], 
	'L_COLOR_OLIVE' => $lang['color_olive'], 
	'L_COLOR_CYAN' => $lang['color_cyan'], 
	'L_COLOR_BLUE' => $lang['color_blue'], 
	'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'], 
	'L_COLOR_INDIGO' => $lang['color_indigo'], 
	'L_COLOR_VIOLET' => $lang['color_violet'], 
	'L_COLOR_WHITE' => $lang['color_white'], 
	'L_COLOR_BLACK' => $lang['color_black'],
	
	'L_FONT_SIZE' => $lang['Font_size'], 
	'L_FONT_TINY' => $lang['font_tiny'], 
	'L_FONT_SMALL' => $lang['font_small'], 
	'L_FONT_NORMAL' => $lang['font_normal'], 
	'L_FONT_LARGE' => $lang['font_large'], 
	'L_FONT_HUGE' => $lang['font_huge'],	
	
	'L_BBCODE_B_HELP' => $lang['bbcode_b_help'], 
	'L_BBCODE_I_HELP' => $lang['bbcode_i_help'], 
	'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
	'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'], 
	'L_BBCODE_C_HELP' => $lang['bbcode_c_help'], 
	'L_BBCODE_L_HELP' => $lang['bbcode_l_help'], 
	'L_BBCODE_O_HELP' => $lang['bbcode_o_help'], 
	'L_BBCODE_P_HELP' => $lang['bbcode_p_help'], 
	'L_BBCODE_W_HELP' => $lang['bbcode_w_help'], 
	'L_BBCODE_A_HELP' => $lang['bbcode_a_help'], 
	'L_BBCODE_S_HELP' => $lang['bbcode_s_help'], 
	'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
	'L_BBCODE_D_HELP' => $lang['bbcode_d_help'],
	'L_BBCODE_E_HELP' => $lang['bbcode_e_help'],
	'L_BBCODE_G_HELP' => $lang['bbcode_g_help'],	
	'L_BBCODE_J_HELP' => $lang['bbcode_j_help'],	
	'L_BBCODE_X_HELP' => $lang['bbcode_x_help'],
	'L_BBCODE_Y_HELP' => $lang['bbcode_y_help'],
	'L_BBCODE_Z_HELP' => $lang['bbcode_z_help'],	
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],
 
	'L_STYLES_TIP' => $lang['Styles_tip'],
	
//
// Pseudo WYSIWYG BBcode Editor (Icons)
//
	'WYSIWYG_EDITOR_BOLD' => $images['icon_bold'],
	'WYSIWYG_EDITOR_ITALIC' => $images['icon_italic'],
	'WYSIWYG_EDITOR_UNDERLINE' => $images['icon_underline'],
	'WYSIWYG_EDITOR_JUSTLEFT' => $images['icon_jl'],
	'WYSIWYG_EDITOR_JUSTCENTER' => $images['icon_jc'],	
	'WYSIWYG_EDITOR_JUSTRIGHT' => $images['icon_jr'],
	'WYSIWYG_EDITOR_JUSTIFY' => $images['icon_jy'],	
	'WYSIWYG_EDITOR_ORDERLIST' => $images['icon_orlist'],
	'WYSIWYG_EDITOR_LIST' => $images['icon_list'],
	'WYSIWYG_EDITOR_IMAGELEFT' => $images['icon_imageleft'],	
	'WYSIWYG_EDITOR_IMAGE' => $images['icon_image'],
	'WYSIWYG_EDITOR_IMAGERIGHT' => $images['icon_imageright'],	
	'WYSIWYG_EDITOR_HTTP_WWW' => $images['icon_url'],	
	'WYSIWYG_EDITOR_X_CODE' => $images['icon_code'],
	'WYSIWYG_EDITOR_QUOTE' => $images['icon_quotation'],
	'WYSIWYG_EDITOR_CLOSE_ALL_TAGS' => $images['icon_caot'],	
	'WYSIWYG_EDITOR_SPACER' => $images['spacer'])		
);

$template->assign_var_from_handle('PSEUDO_WYSIWYG_EDITOR', 'editor');	
//-- fin mod : Pseudo WYSIWYG BBcode Editor --------------------------------------
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/bbcode.php 
# 
#-----[ FIND ]------------------------------------------
#
<?php
# 
#-----[ AFTER, ADD ]------------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.1 -----------------------------------	
# 
#-----[ FIND ]------------------------------------------
# 
$bbcode_tpl['email'] = str_replace('{EMAIL}', '\\1', $bbcode_tpl['email']);
#
#-----[ AFTER, ADD ]------------------------------------------
#

//-- mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------ 
//-- add
	// font family 
	$bbcode_tpl['font_open'] = str_replace('{FONT}', '\\1', $bbcode_tpl['font_open']);
	
   // Left and right alignment for wrapping texzt around images
	$bbcode_tpl['left'] = str_replace('{URL}', '\\1', $bbcode_tpl['left']);
	$bbcode_tpl['right'] = str_replace('{URL}', '\\1', $bbcode_tpl['right']);	
//-- fin mod : Pseudo WYSIWYG BBcode Editor -------------------------------------- 
# 
#-----[ FIND ]------------------------------------------
# 
	// [email]user@domain.tld[/email] code..
	$patterns[] = "#\[email\]([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]#si";
	$replacements[] = $bbcode_tpl['email'];
#
#-----[ AFTER, ADD ]------------------------------------------
#  

//-- mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------ 
//-- add
	// [font] and [/font] for setting text font
	$text = preg_replace("/\[font=(Arial|Georgia|Impact|Symbol|Tahoma|Times New Roman|Verdana|Webdings):$uid\]/si", $bbcode_tpl['font_open'], $text); 
	$text = str_replace("[/font:$uid]", $bbcode_tpl['font_close'], $text);

   // [img=left] and [/img] For wrapping text around images.
   $patterns[] = "#\[img=left:$uid\]([^?](?:[^\[]+|\[(?!url))*?)\[/img:$uid\]#i";
   $replacements[] = $bbcode_tpl['left'];

   // [img=right] and [/img] For wrapping text around images.
   $patterns[] = "#\[img=right:$uid\]([^?](?:[^\[]+|\[(?!url))*?)\[/img:$uid\]#i";
   $replacements[] = $bbcode_tpl['right'];

   // [left] and [/left] for left aligned text. 
   $text = str_replace("[left:$uid]", $bbcode_tpl['left_open'], $text); 
   $text = str_replace("[/left:$uid]", $bbcode_tpl['left_close'], $text);
   
   // [center] and [/center] for center aligned text. 
   $text = str_replace("[center:$uid]", $bbcode_tpl['center_open'], $text); 
   $text = str_replace("[/center:$uid]", $bbcode_tpl['center_close'], $text); 
   
   // [right] and [/right] for right aligned text. 
   $text = str_replace("[right:$uid]", $bbcode_tpl['right_open'], $text); 
   $text = str_replace("[/right:$uid]", $bbcode_tpl['right_close'], $text); 
   
   // [Justify] and [/Justify] for justify aligned text. 
   $text = str_replace("[justify:$uid]", $bbcode_tpl['justify_open'], $text); 
   $text = str_replace("[/justify:$uid]", $bbcode_tpl['justify_close'], $text); 
//-- fin mod : Pseudo WYSIWYG BBcode Editor --------------------------------------	
# 
#-----[ FIND ]------------------------------------------- 
# 
	// [img]image_url_here[/img] code..
	$text = preg_replace("#\[img\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text); 
# 
#-----[ AFTER, ADD ]-------------------------------------
# 

//-- mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------ 
//-- add
	// [font] and [/font] for setting text font
	$text = preg_replace("#\[font=(Arial|Georgia|Impact|Symbol|Tahoma|Times New Roman|Verdana|Webdings)\](.*?)\[/font\]#si", "[font=\\1:$uid]\\2[/font:$uid]", $text);
	
   // [img=left] and [/img] For wrapping text around images.
	$text = preg_replace("#\[img=left\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img=left:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);

   // [img=right] and [/img] For wrapping text around images	
	$text = preg_replace("#\[img=right\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", "'[img=right:$uid]\\1' . str_replace(' ', '%20', '\\3') . '[/img:$uid]'", $text);

   // [left] and [/left] for left aligned text. 
   $text = preg_replace("#\[left\](.*?)\[/left\]#si", "[left:$uid]\\1[/left:$uid]",
   $text);
   
   // [center] and [/center] for centered text. 
   $text = preg_replace("#\[center\](.*?)\[/center\]#si",
   "[center:$uid]\\1[/center:$uid]", $text); 
   
   // [right] and [/right] for right aligned text. 
   $text = preg_replace("#\[right\](.*?)\[/right\]#si",
   "[right:$uid]\\1[/right:$uid]", $text);
   
   // [justify] and [/justify] for justify aligned text. 
   $text = preg_replace("#\[justify\](.*?)\[/justify\]#si", "[justify:$uid]\\1[/justify:$uid]", $text);
//-- fin mod : Pseudo WYSIWYG BBcode Editor ---------------------------------------
# 
#-----[ OPEN ]------------------------------------------- 
# 
language/lang_english/lang_main.php 
# 
#-----[ FIND ]---------------------------------
#
<?php
# 
#-----[ AFTER, ADD ]---------------------------------
#
//-- mod : Pseudo WYSIWYG BBcode Editor V.1.7.1 ----------------------------------- 
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['bbcode_f_help']
# 
#-----[ AFTER, ADD ]------------------------------------
# 
//-- mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------ 
//-- add
$lang['bbcode_d_help'] = 'Font-Family: [font=Your font of choice]text[/font]';
$lang['bbcode_e_help'] = 'Wrap text around image: [img=left]http://image_url[/img]';
$lang['bbcode_g_help'] = 'Wrap text around image: [img=right]http://image_url[/img]';
$lang['bbcode_j_help'] = 'Justify text: [justify]text to be justified[/justify]';
$lang['bbcode_x_help'] = 'Left text: [left]text to be aligned to the left[/left]'; 
$lang['bbcode_y_help'] = 'Center text: [center]text to be centered[/center]'; 
$lang['bbcode_z_help'] = 'Right text: [right]text to be aligned to the right[/right]';	
//-- fin mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['More_emoticons']
# 
#-----[ AFTER, ADD ]------------------------------------
#

//-- mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------ 
//-- add
//
//--  NOTE: Font names must NOT be translated.
//
$lang['Font_family'] = 'Font';
$lang['font_arial'] = 'Arial';
$lang['font_georgia'] = 'Georgia';
$lang['font_impact'] = 'Impact';
$lang['font_symbol'] = 'Symbol';
$lang['font_tahoma'] = 'Tahoma';
$lang['font_times_new_roman'] = 'Times New Roman';
$lang['font_verdana'] = 'Verdana';
$lang['font_webdings'] = 'Webdings';
//-- fin mod : Pseudo WYSIWYG BBcode Editor ------------------------------------------
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Font_color']
# 
#-----[ REPLACE WITH ]------------------------------------
# 
# Nothing, this line must be deleted
#

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['color_default']
# 
#-----[ REPLACE WITH ]------------------------------------
# 
# Nothing, this line must be deleted
#

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['color_dark_red']
# 
#-----[ REPLACE WITH ]------------------------------------
# 
# Nothing, this line must be deleted
#

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['color_red']
# 
#-----[ BEFORE, ADD ]------------------------------------
# 
$lang['Font_color'] = 'Colour';
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['color_orange']
# 
#-----[ BEFORE, ADD ]------------------------------------
# 
$lang['color_dark_red'] = 'DarkRed';
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['color_dark_blue']
# 
#-----[ REPLACE WITH ]------------------------------------
# 
# Nothing, this line must be deleted
#

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['color_indigo']
# 
#-----[ BEFORE, ADD ]------------------------------------
# 
$lang['color_dark_blue'] = 'DarkBlue';
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Font_size']
# 
#-----[ REPLACE WITH ]------------------------------------
# 
# Nothing, this line must be deleted
#

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['font_tiny']
# 
#-----[ BEFORE, ADD ]------------------------------------
# 
$lang['Font_size'] = 'Size';
# 
#-----[ OPEN ]-----------------------------------------
# 
templates/subSilver/bbcode.tpl 
# 
#-----[ FIND ]----------------------------------------- 
# 
<!-- BEGIN email --><a href="mailto:{EMAIL}">{EMAIL}</a><!-- END email --> 
# 
#-----[ AFTER, ADD ]------------------------------------
# 

<!-- BEGIN font_open --><span style="font-family: '{FONT}'; line-height: normal">
<!-- END font_open -->
<!-- BEGIN font_close --></span><!-- END font_close --> 

<!-- BEGIN left --><img src="{URL}" border="0" align="left" /><!-- END left -->
<!-- BEGIN right --><img src="{URL}" border="0" align="right" /><!-- END right -->

<!-- BEGIN left_open --><div align="left"><!-- END left_open --> 
<!-- BEGIN left_close --></div><!-- END left_close -->

<!-- BEGIN center_open --><div align="center"><!-- END center_open --> 
<!-- BEGIN center_close --></div><!-- END center_close -->

<!-- BEGIN right_open --><div align="right"><!-- END right_open --> 
<!-- BEGIN right_close --></div><!-- END right_close --> 

<!-- BEGIN justify_open --><div style="text-align: justify;"><!-- END justify_open --> 
<!-- BEGIN justify_close --></div><!-- END justify_close --> 
# 
#-----[ OPEN ]-----------------------------------------
# 
templates/subSilver/posting_body.tpl 
# 
#-----[ FIND ]----------------------------------------- 
# 		  
f_help = "{L_BBCODE_F_HELP}";
# 
#-----[ AFTER, ADD ]------------------------------------
# 
// mod : Pseudo WYSIWYG BBcode Editor
d_help = "{L_BBCODE_D_HELP}";
e_help = "{L_BBCODE_E_HELP}";
g_help = "{L_BBCODE_G_HELP}";
j_help = "{L_BBCODE_J_HELP}";
x_help = "{L_BBCODE_X_HELP}";
y_help = "{L_BBCODE_Y_HELP}";
z_help = "{L_BBCODE_Z_HELP}";
// fin mod : Pseudo WYSIWYG BBcode Editor
# 
#-----[ FIND ]----------------------------------------- 
# 
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
# 
#-----[ IN-LINE FIND ]------------------------------------
# 
'[quote]','[/quote]','[code]','[/code]',
# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------
# 
'[left]','[/left]','[center]','[/center]','[right]','[/right]','[justify]','[/justify]',
# 
#-----[ IN-LINE FIND ]------------------------------------
# 
'[/list]',
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------
# 
'[img=left]','[/img]',
# 
#-----[ IN-LINE FIND ]------------------------------------
# 
,'[url]'
# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------
# 
,'[img=right]','[/img]'
# 
#-----[ IN-LINE FIND ]------------------------------------
# 
'[/url]'
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------
# 
,'[code]','[/code]','[quote]','[/quote]'
# 
#-----[ FIND ]----------------------------------------- 
# 
			  <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')" />	
# 
#-----[ BEFORE, ADD ]------------------------------------
# 			  
<!-- BEGIN: Pseudo WYSIWYG BBcode Editor -->			
{PSEUDO_WYSIWYG_EDITOR}
<!-- END: Pseudo WYSIWYG BBcode Editor -->

<!-- BEGIN DELETE BY: Pseudo WYSIWYG BBcode Editor V.1.7.1
# 
#-----[ FIND ]----------------------------------------- 
# 
				  <td nowrap="nowrap" align="right"><span class="gensmall"><a href="javascript:bbstyle(-1)" class="genmed" onMouseOver="helpline('a')">{L_BBCODE_CLOSE_TAGS}</a></span></td>
# 
#-----[ AFTER, ADD ]------------------------------------
# 
END DELETE BY: Pseudo WYSIWYG BBcode Editor V.1.7.1 -->
# 
#-----[ OPEN ]-----------------------------------------
# 
templates/subSilver/subSilver.cfg
# 
#-----[ FIND ]----------------------------------------- 
# 	
$images['voting_graphic'][4] = "$current_template_images/voting_bar.gif";
# 
#-----[ AFTER, ADD ]------------------------------------
# 

//
// Pseudo WYSIWYG BBcode Editor Icons
//
$images['icon_bold'] = $current_template_images . '/editor/icon_bold.gif';
$images['icon_italic'] = $current_template_images . '/editor/icon_italic.gif';
$images['icon_underline'] = $current_template_images . '/editor/icon_underline.gif';
$images['icon_jl'] = $current_template_images . '/editor/icon_jl.gif';
$images['icon_jc'] = $current_template_images . '/editor/icon_jc.gif';
$images['icon_jr'] = $current_template_images . '/editor/icon_jr.gif';
$images['icon_jy'] = $current_template_images . '/editor/icon_jy.gif';
$images['icon_orlist'] = $current_template_images . '/editor/icon_orlist.gif';
$images['icon_list'] = $current_template_images . '/editor/icon_list.gif';
$images['icon_imageleft'] = $current_template_images . '/editor/icon_imageleft.gif';
$images['icon_image'] = $current_template_images . '/editor/icon_image.gif';
$images['icon_imageright'] = $current_template_images . '/editor/icon_imageright.gif';
$images['icon_url'] = $current_template_images . '/editor/icon_url.gif';
$images['icon_code'] = $current_template_images . '/editor/icon_code.gif';
$images['icon_quotation'] = $current_template_images . '/editor/icon_quote.gif';
$images['icon_caot'] = $current_template_images . '/editor/icon_caot.gif';
$images['spacer'] = $current_template_images . '/editor/spacer.gif';
# 
#-----[ SAVE/CLOSE ALL FILES ]--------------------------------- 
# 
# EoM 			  