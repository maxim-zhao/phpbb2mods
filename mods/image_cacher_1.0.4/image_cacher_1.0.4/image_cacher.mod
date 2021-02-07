############################################################## 
## MOD Title: Image Cacher
## MOD Author: Swizec < swizec@randy-comic.com > (N/A) http://www.randy-comic.com
## MOD Description: Caches all posted images that are from a different server onto your server for faster load times. Gets rid of the frustration with broken images and images heavily changing after being commented upon.
## MOD Version: 1.0.4
## 
## Installation Level: Easy
## Installation Time: ~5 Minutes 
## Files To Edit: 
##		common.php
##		viewtopic.php
##		includes/constants.php
##		includes/bbcode.php
##		includes/page_header.php
##		templates/subSilver/overall_header.tpl
##		language/lang_english/lang_main.php
##		language/lang_english/lang_admin.php
## Included Files:
##		cache_browser.php
##		includes/functions_cache.php
##		includes/cache_browser.php
##		admin/admin_cache.php
##		templates/wz_tooltip.js
##		templates/subSilver/cache_browser.tpl
##		templates/subSilver/images/cachesize_barl.png
##		templates/subSilver/images/cachesize_barr.png
##		templates/subSilver/images/cachesize_barc.png
##		templates/subSilver/images/image.png
##		templates/subSilver/admin/cache_config_body.tpl
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
##
## you need the GD library functioning for this to work
##
## note to anyone making a robots.txt file, this "robot" hears to the name of phpbb2-imgcache
##
## gif support won't work on gd-1.6 through gd-2.0.28
## 
############################################################## 
## MOD History: 
## 
## 
##   2005-04-25 - Version 0.0.1
##      - started development
## 
##   2005-04-25 - Version 0.4.0
##      - basically works
##	- still some features to add
## 
##   2005-04-26 - Version 0.5.0
##      - filesize and cache size restrictions
##	- information about the cache in the ACP
## 
##   2005-04-26 - Version 0.6.0
##      - bug with exceeding cache size fixed
##	- cache usage optimization
##	- fixed incompatibility with php versions lower than 4.3.0
##	- robots.txt is being listened to
##	- speeded things up even more by having a table of all the cached/noncached images
##	- checking if there is enough space on disk to cache
## 
##   2005-04-27 - Version 0.7.0
##	- error reporting
##	- FTP support
## 
##   2005-04-27 - Version 0.7.1
##	- some tweaking
## 
##   2005-04-28 - Version 0.8.0
##	- fastened stuff up a bit again, using same ftp connection for the whole viewtopic
##	- cached images link to original image
##	- cache browser
##	- thumbnail support
##	- cache browser available to all
## 
##   2005-04-28 - Version 0.8.3
##	- fixed a bug with noncached images resizer
##	- fixed problems with lang in the cache browser
##	- fixed known problems with ftp support
## 
##   2005-05-02 - Version 0.8.4
##	- fixed a bug with noncached images not getting resized
##	- fixed the error/notice stuff in the cache browser
##	- robots.txt was getting loop trapped
##	- fixed image refreshing
##	- admin doesn't see the cache browser in the ACP by default 
##	  (mainly because of sometimes long load times)
## 
##   2005-05-19 - Version 1.0.0
##	- fixed problems and resubmited
## 
##   2005-05-30 - Version 1.0.1
##	- fixed problems and resubmited
## 
##   2005-05-30 - Version 1.0.2
##	- found a pesky little bug
## 
##   2005-06-16 - Version 1.0.3
##	- submission stuff
## 
##   2005-07-02 - Version 1.0.4
##	- submission stuff
##
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 

INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'enable_img_cache', '0' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'cachepath', 'images/cache' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'max_image_size', '1024' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'image_cache_maxsize', '50' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'image_cache_size', '0' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'cached_images', '0' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'cache_useftp', '0' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'cache_ftp', '' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'cache_ftp_port', '' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'cache_ftp_user', '' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'cache_ftp_pass', '' );
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ( 'cache_ftp_path', '' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'postimg_width', '800' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'postimg_height', '600' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'display_thumbs', '1' );
CREATE TABLE `phpbb_cache_processed` (
`id` INT NOT NULL AUTO_INCREMENT ,
`cached` TINYINT( 1 ) NOT NULL ,
`image` TEXT NOT NULL ,
`original` TEXT NOT NULL,
KEY ( `id` ) 
) ;

# 
#-----[ COPY ]------------------------------------------ 
# 

copy cache_browser.php to cache_browser.php
copy includes/functions_cache.php to includes/functions_cache.php
copy includes/cache_browser.php to includes/cache_browser.php
copy admin/admin_cache.php to admin/admin_cache.php
copy templates/wz_tooltip.js to templates/wz_tooltip.js
copy templates/subSilver/cache_browser.tpl to templates/subSilver/cache_browser.tpl
copy templates/subSilver/images/cachesize_barl.png to templates/subSilver/images/cachesize_barl.png
copy templates/subSilver/images/cachesize_barr.png to templates/subSilver/images/cachesize_barr.png
copy templates/subSilver/images/cachesize_barc.png to templates/subSilver/images/cachesize_barc.png
copy templates/subSilver/images/image.png to templates/subSilver/images/image.png
copy templates/subSilver/admin/cache_config_body.tpl to templates/subSilver/admin/cache_config_body.tpl

# 
#-----[ OPEN ]------------------------------------------ 
# 

common.php

# 
#-----[ FIND ]------------------------------------------ 
# 

include($phpbb_root_path . 'includes/db.'.$phpEx);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod image cacher
include($phpbb_root_path . 'includes/functions_cache.'.$phpEx);

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 

init_userprefs($userdata);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod image cacher add
$ftp = connect_ftp( );
$userdata['ftpcache']['connected'] = $ftp['connected'];
$userdata['ftpcache']['conn_id'] = $ftp['conn_id'];
// mod image cacher end

# 
#-----[ FIND ]------------------------------------------ 
# 

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod image cacher add
connect_ftp( $userdata['ftpcache']['conn_id'], TRUE );

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/constants.php

# 
#-----[ FIND ]------------------------------------------ 
# 

define('VOTE_USERS_TABLE', $table_prefix.'vote_voters');

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod image cacher add
define( 'CACHE_PROCESSED_TABLE', $table_prefix.'cache_processed' );
define( 'IMGIF', 1 );
define( 'IMJPG', 2 );
define( 'IMPNG', 3 );
// mod image cacher end

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/bbcode.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$patterns[] = "#\[img:$uid\]([^?].*?)\[/img:$uid\]#i";

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod image cacher replace
$text = parse_images( $text, $uid );

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/page_header.php

# 
#-----[ FIND ]------------------------------------------ 
# 

'L_SEARCH' => $lang['Search'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod image cacher add
'L_IMGCACHE' => $lang['cache_browser'],

# 
#-----[ FIND ]------------------------------------------ 
# 

'U_SEARCH' => append_sid('search.'.$phpEx),

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod image cacher add
'U_IMGCACHE' => append_sid('cache_browser.'.$phpEx),

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/overall_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

{L_SEARCH}</a>&nbsp;

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

{L_SEARCH}</a>&nbsp;

# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# 

&nbsp;<a href="{U_IMGCACHE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_IMGCACHE}" hspace="3" />{L_IMGCACHE}</a>&nbsp;

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 


// mod image cacher add
$lang['cache_browser'] = 'Image cache';
$lang['postimg_clickme'] = 'Thumbnail, click to enlarge.';


# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod image cacher add
$lang['Cache'] = 'Image Cache';
$lang['delete'] = 'Delete';
$lang['cache_enable'] = 'Enable caching of images';
$lang['cache_enable_exp'] = 'You need the GD library for this';
$lang['fail_gdchk'] = 'The GD library is not installed, or it just isn\'t enabled, contact your host provider about this.';
$lang['ok_gdchk'] = 'The GD LIbrary is installed and ready to use.';
$lang['empty'] = 'Empty';
$lang['empty_imgcache'] = 'Empty image cache';
$lang['cache_ok_empty'] = 'Image cache emptied';
$lang['cache_fail_empty'] = 'There was an error emptiing the rank image cache';
$lang['Click_return_cacheconfig'] = 'Click %sHere%s to return to image cache configuration';
$lang['image_cache'] = 'Image cache';
$lang['image_cache_exp'] = 'Configure the caching of images in posts.';
$lang['cachepath'] = 'Path to cached images';
$lang['maximgsize'] = 'Max. image size';
$lang['maximgsize_exp'] = 'The maximum size of cached images in kilobytes';
$lang['cachemaxsize'] = 'Max. image cache size';
$lang['cachemaxsize_exp'] = 'The maximum size of image cache in megabytes';
$lang['cachesize'] = 'Current size of cache in megabytes';
$lang['Sync'] = 'Sync';
$lang['sizesync_fail'] = 'Could not sync cache size.';
$lang['sizesync_ok'] = 'Succesfully synced cache size.';
$lang['cacheusage'] = 'Cache usage';
$lang['cacheusage_sats'] = '[ %s MB / %s MB used ][ %s ][ %d images ]';
$lang['errors'] = 'Warnings';
$lang['cache_full'] = 'There is less than 10% of the set cache size left.';
$lang['cache_nospace'] = 'There is less than 10% of the set cache size of space left on device.';
$lang['nocache_nocreate'] = 'Cache could not be created on device.';
$lang['nocache_create'] = 'Cache has not yet been created but it can be.';
$lang['cache_nowrite'] = 'Cache is not writable';
$lang['cache_noread'] = 'Cache is not readable';
$lang['cache_noerror'] = 'Currently no problems with cache';
$lang['cache_ftpconf'] = 'FTP access configuration';
$lang['cache_ftp'] = 'FTP server';
$lang['cache_ftpport'] = 'FTP port';
$lang['cache_ftpuse'] = 'Use FTP to save to cache';
$lang['cache_ftpuse_exp'] = '<b>Warning:</b> Enabling this will slow down caching and this ACP!!';
$lang['cache_ftpuser'] = 'FTP username';
$lang['cache_ftppass'] = 'FTP password';
$lang['cache_ftppath'] = 'FTP path to cache path( set above )';
$lang['ftp_err_noconnect'] = 'Cannot connect to FTP.';
$lang['ftp_err_nologin'] = 'Cannot login to FTP.';
$lang['ftp_err_noupload'] = 'Cannot upload to FTP. Most probably the directory doesn\'t exist.';
$lang['ftp_err_nope'] = 'No FTP related errors.';
$lang['cache_view'] = 'Image cache browser';
$lang['refresh'] = 'Refresh';
$lang['cache_nofiles'] = 'No files in cache';
$lang['image_faildel'] = 'Failed deleting image';
$lang['image_okdel'] = 'Deleted image. Please use the sync function.';
$lang['image_failref'] = 'Failed refreshing image';
$lang['image_okref'] = 'Refreshed image';
$lang['image_info'] = 'Width: %dpx &nbsp; Height: %dpx<br />Size: %s kB';
$lang['original'] = 'Original';
$lang['image_noused'] = 'Image not being used';
$lang['image_noremote'] = 'Remote file not accessable';
$lang['postimg_size'] = 'Maximum size of images in posts';
$lang['usethumbs'] = 'Constrain image size in posts';
$lang['thumbs'] = 'Thumbnails';
$lang['check'] = 'Check';
$lang['browser_open'] = 'Display the cache browser';
$lang['browser_close'] = 'Stop displaying the cache browser';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 