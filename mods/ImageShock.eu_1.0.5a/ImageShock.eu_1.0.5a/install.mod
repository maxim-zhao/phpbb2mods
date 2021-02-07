##############################################################
## MOD Title: ImageShock.eu - 3rd party, auto-insertion, 100% customizable Mod
## MOD Author: zden < admin@imageshock.eu > (N/A) http://www.imageshock.eu/
## MOD Description: Allows users to upload images to ImageShock.eu while replying or creating a topic.
## MOD Version: 1.0.5a
##
## Installation Level: Easy
## Installation Time: ~3 Minutes
## Files To Edit: posting_body.tpl
##                posting.php
## Included Files: imageshock.eu.php
##                 imageshockeu_output_body.tpl
##                 imageshockeu_input_body.tpl
##                 lang_imageshock.eu.php
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
## This mod is based on the syndication feature at ImageShock.eu.
##
## After user uploads image the thumbnail link is inserted into 
## his message automatically. 
##
## The iframe includes page located on yoour server. Then form
## calls the script located at ImageShock.eu which procceses the
## image and then call back the imageshock.eu.php file on your server.
## This solution causes that against it's 3rd party hosting you can
## fully customize both pages - the page for choosing image and the
## page for viewing the image. 
##
## You can translate the pages to your language... you can modify
## outlook to match your forum design.
##
## But by basic knowledge of HTML and javascript you can also
## modify the functionality. For example you can choose that 
## not thumbnail link but hotlink will be inserted automatically.
##
## You can also add new checkbox such public image, resolution/filesize bar, even for example select to select the
## resolution, inputs to choose text or background color. You can even
## add the cropping or rotating checkbox but for this
## you would need much bigger iframe or maybe new window would be much better solution.
## You can study the www.imageshock.eu source code to add these functions
## (that big page uses the same processing script as imageshock.eu.php)...
## i am going to create larger documentation maybe also javascript to create Mod od Demand with
## thumbnail to view how it will look like but i have to know that some people
## will use this mod. 
##
## Support via icq - 169 106 168
################################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ COPY ]------------------------------------------
#
copy imageshock.eu.php to imageshock.eu.php
copy imageshockeu_input_body.tpl to templates/subSilver/imageshockeu_input_body.tpl
copy imageshockeu_output_body.tpl to templates/subSilver/imageshockeu_output_body.tpl
copy lang_imageshock.eu.php to language/lang_english/lang_imageshock.eu.php
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl
#
#-----[ FIND ]------------------------------------------
#     
     <td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span><br /><span class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
     <td class="row2"><span class="gen"> </span>
     <table cellspacing="0" cellpadding="1" border="0">

#
#-----[ AFTER, ADD ]------------------------------------------
#
	  <!-- begin ImageShock.eu - 3rd party, auto-insertion Mod -->
        <iframe id="imageshock" name="imageshock" style="width:450px;height:130px;border:1px solid #000" src="{U_IMAGESHOCK_URL}" frameborder="0" scrolling="no"></iframe>
    <!-- end ImageShock.eu - 3rd party, auto-insertion Mod -->

#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#     
     'S_POST_ACTION' => append_sid("posting.$phpEx"),

#
#-----[ AFTER, ADD ]------------------------------------------
#
	  'U_IMAGESHOCK_URL' => append_sid("imageshock.eu.$phpEx"),

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
