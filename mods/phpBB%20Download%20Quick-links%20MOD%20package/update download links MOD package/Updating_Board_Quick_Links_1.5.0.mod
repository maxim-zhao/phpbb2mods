##############################################################
## MOD Title: ACP Update Download Links
## MOD Author: dfritter4 < dfritter4@yahoo.com > (David Fritz) http://www.motrclan.com
##
## MOD Description: adds direct download links to the phpBB files if your phpBB installation is out of date
##
## MOD Version: 1.5.0
##
## Installation Level: Easy
## Installation Time: ~10 Minutes based off EasyTIME
##               (http://www.cmxmods.net/easytime.php)
##
## Files To Edit: 4
##      admin/index.php
##      language/lang_english/lang_admin.php
##      templates/subSilver/subSilver.cfg
##      templates/subSilver/admin/index_body.tpl
##
## Included Files:
##      templates/subSilver/images/icon-dl-zip.gif
##      templates/subSilver/images/icon-dl-gzip.gif
##      templates/subSilver/images/icon-dl-bz1.gif
##
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: very convienent i think and easy to install
## 
## special thanks to ycl6 from the phpBB mod team for pointing
## out a lot of problems and generously fixing them
##
##############################################################
## MOD History:
##
##   2006-07-12 - Version 0.0.1
##      - start product
##   2006-07-12 - Version 0.0.2
##      - changed it so it the img src went to the phpbb root folder
##   2006-07-12 - Version 0.3.0
##     - i just wanted to make it 0.3.0 but i did change some stuff
##       i just dont feel like writing it all down
##   2006-07-12 - Version 0.4.0
##     - i changed it so that it would auto format the table in the
##       admin index.php instead of having a big empty space if it is
##       up to date
##   2006-07-13 - Version 1.4.1
##     - ready for initial release
##   2006-08-11 - Version 1.5.0
##     - Fixed some MOD template action problems
##     - Fixed many HTML tag problems
##     - Now using phpBB's language system
##     - Now using phpBB's image management system
##     - Now using phpBB's template system
##     - Use template switch to control when to show the download links
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ COPY ]-----------------------------------------
#
copy templates/subSilver/images/icon-dl-zip.gif to templates/subSilver/images/icon-dl-zip.gif
copy templates/subSilver/images/icon-dl-gzip.gif to templates/subSilver/images/icon-dl-gzip.gif
copy templates/subSilver/images/icon-dl-bz2.gif to templates/subSilver/images/icon-dl-bz2.gif
#
#-----[ OPEN ]-----------------------------------------
#
admin/index.php
#
#-----[ FIND ]-----------------------------------------
#
	$version_info .= '<br />' . sprintf($lang['Latest_version_info'], $latest_version) . ' ' . sprintf($lang['Current_version_info'], '2' . $board_config['version']) . '</p>';
#
#-----[ AFTER, ADD ]-----------------------------------
#
         $download_full_zip = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '.zip"><img border="0" src="' . $phpbb_root_path . $images['dl_zip'] . '" alt="' . $lang['Download_full'] . '" title="' . $lang['Download_full'] . '" /></a>';
         $download_full_gzip = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '.tar.gz"><img border="0" src="' . $phpbb_root_path . $images['dl_gzip'] . '" alt="' . $lang['Download_full'] . '" title="' . $lang['Download_full'] . '" /></a>';
         $download_full_bz2 = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '.tar.bz2"><img border="0" src="' . $phpbb_root_path . $images['dl_bz2'] . '" alt="' . $lang['Download_full'] . '" title="' . $lang['Download_full'] . '" /></a>';
         $download_changed_zip = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-files.zip"><img border="0" src="' . $phpbb_root_path . $images['dl_zip'] . '" alt="' . $lang['Download_changed'] . '" title="' . $lang['Download_changed'] . '" /></a>';
         $download_changed_gzip = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-files.tar.gz"><img border="0" src="' . $phpbb_root_path . $images['dl_gzip'] . '" alt="' . $lang['Download_changed'] . '" title="' . $lang['Download_changed'] . '" /></a>';
         $download_changed_bz2 = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-files.tar.bz2"><img border="0" src="' . $phpbb_root_path . $images['dl_bz2'] . '" alt="' . $lang['Download_changed'] . '" title="' . $lang['Download_changed'] . '" /></a>';
         $download_patch_zip = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-patch.zip"><img border="0" src="' . $phpbb_root_path . $images['dl_zip'] . '" alt="' . $lang['Download_patch'] . '" title="' . $lang['Download_patch'] . '" /></a>';
         $download_patch_gzip = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-patch.tar.gz"><img border="0" src="' . $phpbb_root_path . $images['dl_gzip'] . '" alt="' . $lang['Download_patch'] . '" title="' . $lang['Download_patch'] . '" /></a>';
         $download_patch_bz2 = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-patch.tar.bz2"><img border="0" src="' . $phpbb_root_path . $images['dl_bz2'] . '" alt="' . $lang['Download_patch'] . '" title="' . $lang['Download_patch'] . '" /></a>';
         $download_code_zip = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-codechanges.zip"><img border="0" src="' . $phpbb_root_path . $images['dl_zip'] . '" alt="' . $lang['Download_code'] . '" title="' . $lang['Download_code'] . '" /></a>';
         $download_code_gzip = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-codechanges.tar.gz"><img border="0" src="' . $phpbb_root_path . $images['dl_gzip'] . '" alt="' . $lang['Download_code'] . '" title="' . $lang['Download_code'] . '" /></a>';
         $download_code_bz2 = '<a href="http://prdownloads.sourceforge.net/phpbb/phpBB-' . $latest_version . '-codechanges.tar.bz2"><img border="0" src="' . $phpbb_root_path . $images['dl_bz2'] . '" alt="' . $lang['Download_code'] . '" title="' . $lang['Download_code'] . '" /></a>';

         $template->assign_block_vars('switch_out_of_date', array() );
#
#-----[ FIND ]-----------------------------------------
#
	'VERSION_INFO'	=> $version_info,
#
#-----[ AFTER, ADD ]-----------------------------------
#
      'L_VERSION_WARNING' => $lang['Version_warning'],
      'L_VERSION_WARNING_EXPLAIN' => $lang['Version_warning_explain'],
      'L_DOWNLOAD_LINK' => $lang['Download_link'],
      'L_PHPBB_WORD' => $lang['phpBB_word'],
      'L_DOWNLOAD_FULL' => $lang['Download_full'],
      'L_DOWNLOAD_CHANGED' => $lang['Download_changed'],
      'L_DOWNLOAD_PATCH' => $lang['Download_patch'],
      'L_DOWNLOAD_CODE' => $lang['Download_code'],
      'DOWNLOAD_FULL_ZIP' => $download_full_zip,
      'DOWNLOAD_FULL_GZIP' => $download_full_gzip,
      'DOWNLOAD_FULL_BZ2' => $download_full_bz2,
      'DOWNLOAD_CHANGED_ZIP' => $download_changed_zip,
      'DOWNLOAD_CHANGED_GZIP' => $download_changed_gzip,
      'DOWNLOAD_CHANGED_BZ2' => $download_changed_bz2,
      'DOWNLOAD_PATCH_ZIP' => $download_patch_zip,
      'DOWNLOAD_PATCH_GZIP' => $download_patch_gzip,
      'DOWNLOAD_PATCH_BZ2' => $download_patch_bz2,
      'DOWNLOAD_CODE_ZIP' => $download_code_zip,
      'DOWNLOAD_CODE_GZIP' => $download_code_gzip,
      'DOWNLOAD_CODE_BZ2' => $download_code_bz2,      
#
#-----[ OPEN ]-----------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]-----------------------------------------
#
$lang['Version_not_up_to_date'] = 'Your installation does <b>not</b> seem to be up to date. Updates are available for your version of phpBB, please visit <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> to obtain the latest version.';

#
#-----[ REPLACE WITH ]---------------------------------
#
$lang['Version_not_up_to_date'] = 'Your installation does <b>not</b> seem to be up to date. Updates are available for your version of phpBB, please visit <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/downloads.php</a> or click on one of the following download links to obtain the latest version.';

$lang['Download_link'] = 'Download Links';
$lang['phpBB_word'] = 'phpBB';
$lang['Download_full'] = '[ Full Package ]';
$lang['Download_changed'] = '[ Changed Files Only ]';
$lang['Download_patch'] = '[ Patch File Only ]';
$lang['Download_code'] = '[ Code Changes ]';
$lang['Version_warning'] = 'IT IS CRUCIAL THAT YOU UPDATE YOUR BOARD IMMEDIATELY!!';
$lang['Version_warning_explain'] = 'Updating your board is very important as 99% of all hacks/attacks occur because boards are outdated!';
#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/admin/index_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
{VERSION_INFO}

#
#-----[ AFTER, ADD ]-----------------------------------
#
<!-- BEGIN switch_out_of_date -->
<br />

<p><u><b>{L_DOWNLOAD_LINK}</b></u></p>
<table border="0">
   <tr>
      <td align="left" valign="top">
         <p style="line-height: 200%; color:#CD6600"><b>{L_PHPBB_WORD} {VERSION_INFO_2}&nbsp;{L_DOWNLOAD_FULL}</b></p>
         <p style="line-height: 200%; color:#CD6600"><b>{L_PHPBB_WORD} {VERSION_INFO_2}&nbsp;{L_DOWNLOAD_CHANGED}</b></p>
         <p style="line-height: 200%; color:#CD6600"><b>{L_PHPBB_WORD} {VERSION_INFO_2}&nbsp;{L_DOWNLOAD_PATCH}</b></p>
         <p style="line-height: 200%; color:#CD6600"><b>{L_PHPBB_WORD} {VERSION_INFO_2}&nbsp;{L_DOWNLOAD_CODE}</b></p>
      </td>
      <td align="left" valign="top" width="660">
         <p>{DOWNLOAD_FULL_ZIP}&nbsp;&nbsp;&nbsp;{DOWNLOAD_FULL_GZIP}&nbsp;&nbsp;&nbsp;{DOWNLOAD_FULL_BZ2}</p>
         <p>{DOWNLOAD_CHANGED_ZIP}&nbsp;&nbsp;&nbsp;{DOWNLOAD_CHANGED_GZIP}&nbsp;&nbsp;&nbsp;{DOWNLOAD_CHANGED_BZ2}</p>
         <p>{DOWNLOAD_PATCH_ZIP}&nbsp;&nbsp;&nbsp;{DOWNLOAD_PATCH_GZIP}&nbsp;&nbsp;&nbsp;{DOWNLOAD_PATCH_BZ2}</p>
         <p>{DOWNLOAD_CODE_ZIP}&nbsp;&nbsp;&nbsp;{DOWNLOAD_CODE_GZIP}&nbsp;&nbsp;&nbsp;{DOWNLOAD_CODE_BZ2}</p>
      </td>
   </tr>
</table>
<h3><p style="color:red">{L_VERSION_WARNING}<br />{L_VERSION_WARNING_EXPLAIN}</p></h3>
<!-- END switch_out_of_date -->
#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]-----------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]-----------------------------------
#
$images['dl_zip'] = "$current_template_images/icon-dl-zip.gif";
$images['dl_gzip'] = "$current_template_images/icon-dl-gzip.gif";
$images['dl_bz2'] = "$current_template_images/icon-dl-bz2.gif";
#
#-----[ SAVE/CLOSE ALL FILES ]--------------------------
#
# EoM