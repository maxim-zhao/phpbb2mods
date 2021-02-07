############################################################## 
## MOD Title: Signature in Profile
## MOD Author: Dicky < rfoote@tellink.net > (Richard Foote) http://dicky.askmaggymae.com
## MOD Description: Adds the member's signature to their view profile page.
## MOD Version: 1.0.0b
## 
## Installation Level: easy
## Installation Time: 5 Minutes 
## Files To Edit: (2) 
##            includes/usercp_viewprofile.php
##            templates/subSilver/profile_view_body.tpl
## Included Files: N/A
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
## 	 This MOD has been verified to work with phpBB 2.0.22
##	 This MOD can be installed by EasyMOD
############################################################## 
## MOD History:
##
##     2007-01-21
##          - Corrected missing instruction in modX file
##     2006-12-22
##          - Updated FIND instructions
##	   2006-11-25 - Version 1.0.0 Released
##			- Fix smilies not working and bbcode configurations
##     2006-01-03 - Version 0.0.3
##          - Move signature block so that header goes all the way across
##     2006-01-07 - Version 0.0.2
##          - Add switch by Kiwietje
##     2006-01-05 - Version 0.0.1
##          - Initial version
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/usercp_viewprofile.php
# 
#-----[ FIND ]------------------------------------------ 
# 
$sql = "SELECT *
# 
#-----[ BEFORE, ADD ]------------------------------------
#

// BEGIN ADD Signature in Profile
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);
// END ADD Signature in Profile

# 
#-----[ FIND ]------------------------------------------ 
# 
$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $profiledata['username']) . '</a>';
# 
#-----[ AFTER, ADD ]------------------------------------
#

// BEGIN Signature in Profile
$user_sig = '';
if ( $profiledata['user_attachsig'] && $board_config['allow_sig'] )
{
    $user_sig = $profiledata['user_sig'];
    $user_sig_bbcode_uid = $profiledata['user_sig_bbcode_uid'];
	if ( $user_sig != '' )
    {
    	$template -> assign_block_vars('switch_signature', array());
        if ( !$board_config['allow_html'] || !$profiledata['user_allowhtml'])
       	{
       		$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
       	}
    	if ( $user_sig_bbcode_uid != '' && $profiledata['user_allowbbcode'] )
   		{
   			$user_sig = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace("/\:$user_sig_bbcode_uid/si", '', $user_sig);
   		}

   		$user_sig = make_clickable($user_sig);

        if ( $profiledata['user_allowsmile'] && $board_config['allow_smilies'] )
        {
            $user_sig = smilies_pass($user_sig);
        }

   		if (count($orig_word))
		{
   			$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $user_sig . '<'), 1, -1));
   		}

		$user_sig = str_replace("\n", "\n<br />\n", $user_sig);
    }
}
// END Signature in Profile
# 
#-----[ FIND ]------------------------------------------ 
# 
	'AVATAR_IMG' => $avatar_img,
# 
#-----[ AFTER, ADD ]------------------------------------
# 
    'USER_SIG' => $user_sig,
#
#-----[ FIND ]------------------------------------------ 
#
	'L_INTERESTS' => $lang['Interests'],
# 
#-----[ AFTER, ADD ]------------------------------------
#
	'L_SIGNATURE' => $lang['Signature'],
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/profile_view_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
{L_CONTACT} {USERNAME} </span></b></td>
  </tr>
  <tr>
#
#-----[ FIND ]------------------------------------------ 
# 
<td class="row1"
# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
"row1"
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------
#
 rowspan="3"
#
#-----[ FIND ]------------------------------------------ 
#
		  //--></script><noscript>{ICQ_IMG}</noscript></td>
		</tr>
	  </table>
	</td>
  </tr>
# 
#-----[ AFTER, ADD ]------------------------------------
#
		<!-- BEGIN switch_signature -->
	<tr> 
		<td class="catRight" width="60%"><b><span class="gen">{L_SIGNATURE}</span></b></td>
	</tr>
	<tr>
		<td class="row1"> <span class="postbody">{USER_SIG}</span></td>
	</tr>
		<!-- END switch_signature -->
#
#-----[ SAVE/CLOSE ALL FILES ]-------------------------- 
# 
# EoM