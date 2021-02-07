############################################################## 
## MOD Title: View Profile Sig
## MOD Author: netclectic < adrian@netclectic.com > (Adrian Cockbutn) http://www.netclectic.com 
## MOD Description: Adds the user's signature to their view profile page.
## MOD Version: 1.1.1
## 
## Installation Level: easy
## Installation Time: 3 Minutes 
## Files To Edit: (2) usercp_viewprofile.php, profile_view_body.tpl
## Included Files: n/a
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##
############################################################## 
## MOD History:
##     2003-11-07  - Version 1.1.1
##          - updated for 2.0.6 (no changes)
##          - removed the <b> </b> tags from around the signature.
##
##     xxxx-xx-xx  - Version 1.1.0
##          - Updated for 2.0.4 and fixed a problem with formatting of the signature.
##
##     xxxx-xx-xx  - Version 1.0.0
##          - First release.
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
$search = '<a href="' . $temp_url . '">' . $lang['Search_user_posts'] . '</a>';

# 
#-----[ AFTER, ADD ]------------------------------------
# 
$user_sig = '';
if ( $profiledata['user_attachsig'] && $board_config['allow_sig'] )
{
    include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
    $user_sig = $profiledata['user_sig'];
    $user_sig_bbcode_uid = $profiledata['user_sig_bbcode_uid'];
	if ( $user_sig != '' )
    {
        if ( !$board_config['allow_html'] && $profiledata['user_allowhtml'] )
       	{
       		$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
       	}
    	if ( $board_config['allow_bbcode'] && $user_sig_bbcode_uid != '' )
   		{
   			$user_sig = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $user_sig);
   		}
   		$user_sig = make_clickable($user_sig);

        if (!$userdata['user_allowswearywords'])
        {
            $orig_word = array();
            $replacement_word = array();
            obtain_word_list($orig_word, $replacement_word);
            $user_sig = preg_replace($orig_word, $replacement_word, $user_sig);
        }
        if ( $profiledata['user_allowsmile'] )
        {
            $user_sig = smilies_pass($user_sig);
        }
        $user_sig = str_replace("\n", "\n<br />\n", $user_sig);
    }
    $template->assign_block_vars('switch_user_sig_block', array());
}

# 
#-----[ FIND ]------------------------------------------ 
# 
'INTERESTS' => ( $profiledata['user_interests'] ) ? $profiledata['user_interests'] : '&nbsp;',

# 
#-----[ AFTER, ADD ]------------------------------------
# 
	'L_SIGNATURE' => $lang['Signature'],
    'USER_SIG' => $user_sig,

    
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/profile_view_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
		<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_INTERESTS}:</span></td>
		  <td> <b><span class="gen">{INTERESTS}</span></b></td>
		</tr>

# 
#-----[ AFTER, ADD ]------------------------------------
# 
        <!-- BEGIN switch_user_sig_block -->
		<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_SIGNATURE}:&nbsp;</span></td>
		  <td> <span class="postbody">{USER_SIG}</span></td>
		</tr>
        <!-- END switch_user_sig_block -->
        
# 
#-----[ SAVE/CLOSE ALL FILES ]-------------------------- 
# 
# EoM
        
