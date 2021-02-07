############################################################## 
## MOD Title: Post Image Size
## MOD Author: Swizec < swizec@swizec.com > (N/A) http://www.swizec.com
## MOD Description: Admin can set the maximum display size of images displayed in posts. Images bigger than that are shrunk and turned into a link to the normal sized version.
## MOD Version: 1.2.7
## 
## Installation Level: Easy
## Installation Time: ~3 Minutes 
## Files To Edit: 
##		  includes/bbcode.php
##		  admin/admin_board.php
##		  templates/subSilver/bbcode.tpl
##		  templates/subSilver/admin/board_config_body.tpl
##		  language/lang_english/lang_main.php
##		  language/lang_english/lang_admin.php
## Included Files: N/A
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
## Author Notes: 
##
## demo board: http://www.swizec.com/forum
## 
############################################################## 
## MOD History: 
## 
## 2005-04-17 - Version 1.0.0
##    - working mod
##
## 2005-04-17 - Version 1.0.1
##    - oops, small bug in the .mod file
##
## 2005-04-17 - Version 1.0.2
##    - omg I'm so fucken hasty
##
## 2005-05-01 - Version 1.0.3
##    - fixed a bug
##
## 2005-05-01 - Version 1.0.4
##    - some slashes got left behind
##
## 2005-05-02 - Version 1.0.5
##    - added "this is thumbnail" notice wished by MaddoxX
##
## 2005-05-24 - Version 1.0.6
##	- use of bbcode.tpl added
##
## 2005-05-31 - Version 1.0.7
##	- getting closer :)
##
## 2005-05-31 - Version 1.1.0
##	-fixed a bug
##	-implemented image aligning by pichirichi
##
## 2005-06-23 - Version 1.1.1
##	- fixed XHTML compliancy
##
## 2005-11-05 - Version 1.1.2
##	- fixed for 2.0.18
##
## 2005-11-11 - Version 1.1.3
##	- forgot to change the license and security warning before
##
## 2005-11-23 - Version 1.1.4
##	- small mistake in the HTML
##
## 2005-12-09 - Version 1.2.0
##	- fixed some "pretty" issues
##	- fixed slow load issue as best I could
##	- and an issue with left, right, center stuff
##
## 2005-12-17 - Version 1.2.1
##	- some minor HTML fixes
##	- parsing of "old" images and those that were not getimagesized properly
##
## 2005-12-17 - Version 1.2.2
##	- ok, now parsing of "old" images does actually work :)
##
## 2005-12-17 - Version 1.2.3
##	- some people really take care to report bugs O.o how nice of them
##
## 2005-12-21 - Version 1.2.4
##	- changes to the template were not pretty
##
## 2005-12-25 - Version 1.2.5
##	- there was a bug with small images
##
## 2006-01-01 - Version 1.2.6
##	- coding standards :P
##
## 2006-01-04 - Version 1.2.7
##	- even more coding standards :D
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# 

INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'postimg_width', '800' );
INSERT INTO phpbb_config( config_name, config_value ) VALUES ( 'postimg_height', '600' );

# 
#-----[ OPEN ]------------------------------------------ 
# 

includes/bbcode.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$bbcode_tpl = null;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod img size add
function makeimgsize ( $width, $height ) 
{
	global $board_config;
	
	$size = '';
	
	// check for smallness
	if ( $width < $board_config['postimg_width'] && $height < $board_config['postimg_height'] )
	{
		return 'SMALL';
	}
	elseif ( $width > $height ) 
	{
		if ( $board_config['postimg_width'] < $width )
		{
			$size = 'width="' . $board_config['postimg_width'] . '"';
		}
	}else
	{
		if ( $board_config['postimg_height'] < $height )
		{
			$size = 'height="' . $board_config['postimg_height'] . '"';
		}
	}
	
	return $size;
}

function image_parse ( $post, $uid ) 
{
	global $board_config, $lang, $bbcode_tpl;

	preg_match_all( "/\[img(.*?):$uid\](.*?)\[\/img:$uid\]/i", $post, $matches);
	foreach ( $matches[0] as $i => $img ) 
	{ 
		$stuff = $matches[1][$i];
		$stuff = explode( ':', $stuff );
		if ( count( $stuff ) != 4 )
		{ // old image or something
			$post = preg_replace( "#\[img:$uid\]([^?].*?)\[/img:$uid\]#i", $bbcode_tpl['img'], $post );
		}
		switch($stuff[0]) 
		{
			case '=right': 
				$align = $lang['RIGHT']; 
				break;
			case '=center':
				$align = 'center';
				break;
			case '=left':
        		default: 
				$align = $lang['LEFT']; 
			break; 
		}
		$width = $stuff[1];
		$height = $stuff[2];
		$size = makeimgsize( $width, $height );
		
		if ( $size != 'SMALL' )
		{
			$replace = $bbcode_tpl['thmbimg'];
			$seek = array( '{IMAGE}', '{WIDTH}', '{HEIGHT}', '{SIZE}', '{NOTICE}', '{ALIGN}' );
			$with = ( !empty( $size ) ) ? array( $matches[2][$i] , $width, $height, $size, $lang['postimg_clickme'], $align ) : array( $matches[2][$i] , $width, $height, $size, '', $align );
			$replace = str_replace( $seek, $with, $replace );
		}
		else
		{
			$replace = str_replace( '\1', $matches[2][$i], $bbcode_tpl['img'] );
		}
		$post = str_replace( $img, $replace, $post );
	}
		
	return $post;
}
// mod img size end

# 
#-----[ FIND ]------------------------------------------ 
# 

$patterns[] = "#\[img:$uid\]([^?].*?)\[/img:$uid\]#i";

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// mod img size replace with call to image parsing function
$text = image_parse ( $text, $uid );

# 
#-----[ FIND ]------------------------------------------ 
# 

$text = preg_replace("#\[img\]

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

	// mod max img size changed the first pass thingo
	preg_match_all( "#\[(img.*?)\]((http|ftp|https|ftps)://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png)))\[/img\]#sie", $text, $matches );
	// now we go through these matches and do what's needed
	foreach ( $matches[0] as $i => $m )
	{
		// easier use
		$tag = $matches[1][$i];
		$url1 = $matches[2][$i];
		$url2 = $matches[4][$i];
		
		// if we already tagged this one then we leave it be ;)
		preg_match( '#img.*?:(\d+):(\d+)#i', $tag, $match );
		if ( empty( $match ) )
		{
			// get the size so we can store it
			if ( !$size = @getimagesize( $url1 . $url2 ) )
			{ // image will not get resized
				$width = '';
				$height = '';
			}
			else
			{
				$width = $size[0];
				$height = $size[1];
			}
		}
		else
		{ // we already have the size
			$width = $match[1];
			$height = $match[2];
		}
		$tag = explode( ':', $tag ); // remove any possible left over : stuff
		$tag = $tag[0];
		// lastly we replace it within the text
		$text = str_replace( $m, '[' . $tag . ':' . $width . ':' . $height . ':' . $uid . ']' . $url1 . $url2 . '[/img:' . $uid . ']', $text );
	}

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 

$text

# 
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------ 
# 

//

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// end mod img size changes

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 

$namechange_no = ( !$new['allow_namechange'] ) ? "checked=\"checked\"" : "";

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod img size add
$postimg_width = $new['postimg_width'];
$postimg_height = $new['postimg_height'];
// mod img size end

# 
#-----[ FIND ]------------------------------------------ 
# 

"L_RESET" => $lang['Reset'], 

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// mod img size add
"L_POSTIMG_SIZE" => $lang['postimg_size'],
"POSTIMG_WIDTH" => $postimg_width,
"POSTIMG_HEIGHT" => $postimg_height,
// mod img size end

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/bbcode.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

<!-- END email -->

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

<!-- BEGIN thmbimg -->
<div align="{ALIGN}">
 <table border="0">
  <tr>
   <td><img src="{IMAGE}" align="center" border="0" {SIZE}  onclick="window.open( '{IMAGE}', 'imgpop',  'width={WIDTH},height={HEIGHT},status=no,toolbar=no,menubar=no' );return false" /></td>
  </tr>
  <tr>
   <td align="center" class="gensmall"><i>{NOTICE}</i></td>
  </tr>
 </table>
</div>
<!-- END thmbimg -->

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<tr>
		<td class="row1">{L_ENABLE_PRUNE}</td>
		<td class="row2"><input type="radio" name="prune_enable" value="1" {PRUNE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="prune_enable" value="0" {PRUNE_NO} /> {L_NO}</td>
	</tr>
	
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	<tr>
		<td class="row1">{L_POSTIMG_SIZE}</td>
		<td class="row2"><input type="text" size="5" maxlength="5" name="postimg_width" value="{POSTIMG_WIDTH}" /> X <input type="text" size="5" maxlength="5" name="postimg_height" value="{POSTIMG_HEIGHT}" /></td>
	</tr>

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

// mod img size add
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

// mod img size add
$lang['postimg_size'] = 'Maximum size of images in posts';

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM