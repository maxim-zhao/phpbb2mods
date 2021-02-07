############################################################## 
## MOD Title: Modcp Extension
## MOD Author: netclectic < adrian@netclectic.com > (Adrian Cockburn) http://www.netclectic.com 
## MOD Description: Extend the moderators control panel to include Sticky / Announce / Normal of topics
##                  with Check All / UnCheck All.
## MOD Version: 1.1.3
## 
## Installation Level: easy
## Installation Time: 10 Minutes 
## Files To Edit:  (5)  modcp.php, lang_main.php, modcp_body.tpl, overall_header.tpl, viewtopic.php
## 
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
## 
##   2003-11-05 - Version 1.1.3
##      - confirmed on 2.0.6 (no changes)
##	  - moved check all / uncheck all in to table below buttons in modcp_body.tpl
## 
##        1.1.2         :    Moved Check All / UnCheck All into lang_main. Thanks to FX.
##        1.1.1         :    Fixed problem with redirect back to modcp. Thanks to zemaj.
##        1.1.0         :    Updated to work with 2.0.4 - removed the delete auth check as it has now
##                           been included in the core code :)
##        1.0.3         :    Updated to be EasyMod compatible.
##        1.0.2         :    Add sticky / announce buttons to viewtopic. Add Auth check to viewtopic.
##        1.0.1         :    Add Auth checks for Delete / Sticky / Announce. Add Check All / UnCheck All
##        1.0.0         :    Initial Release
##        0.9.1 Beta    :    Extended to include Announcements (now Modcp Extenstion)
##        0.9.0 Beta    :    Original Beta release as Modcp Sticky
##
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
modcp.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$unlock = ( isset($HTTP_POST_VARS['unlock']) ) ? TRUE : FALSE;

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
// MOD MODCP EXTENSION BEGIN
$sticky = ( isset($HTTP_POST_VARS['sticky']) ) ? TRUE : FALSE;
$announce = ( isset($HTTP_POST_VARS['announce']) ) ? TRUE : FALSE;
$normalise = ( isset($HTTP_POST_VARS['normalise']) ) ? TRUE : FALSE;
// MOD MODCP EXTENSION END


# 
#-----[ FIND ]------------------------------------------ 
# 
	else if ( $unlock )
	{
		$mode = 'unlock';
	}
    
# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
    // MOD MODCP EXTENSION BEGIN
    else if ( $sticky )
    {
        $mode = 'sticky';
    }
    else if ( $announce )
    {
        $mode = 'announce';
    }
    else if ( $normalise )
    {
        $mode = 'normalise';
    }
    // MOD MODCP EXTENSION END

 
# 
#-----[ FIND ]------------------------------------------ 
# 
		message_die(GENERAL_MESSAGE, $lang['Topics_Unlocked'] . '<br /><br />' . $message);

		break;

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
    // MOD MODCP EXTENSION BEGIN
	case 'sticky':
	case 'announce':
	case 'normalise':
        if ($mode == 'sticky' && !$is_auth['auth_sticky']) 
        { 
           $message = sprintf($lang['Sorry_auth_sticky'], $is_auth['auth_sticky_type']); 
           message_die(GENERAL_MESSAGE, $message); 
        } 
        if ($mode == 'announce' && !$is_auth['auth_announce']) 
        { 
           $message = sprintf($lang['Sorry_auth_announce'], $is_auth['auth_announce_type']); 
           message_die(GENERAL_MESSAGE, $message); 
        } 
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != "") ? ', ' : '' ) . $topics[$i];
		}

        $topic_type = ($mode == 'sticky') ? POST_STICKY : (($mode == 'announce') ? POST_ANNOUNCE : POST_NORMAL);
		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_type = " . $topic_type . " 
			WHERE topic_id IN ($topic_id_sql) 
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id");
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

        if ($mode == 'sticky') 
        { 
            $message = $lang['Topics_Stickyd'] . '<br /><br />' . $message;
        }
        else if ($mode == 'announce')
        {
            $message = $lang['Topics_Announced'] . '<br /><br />' . $message;
        }
        else if ($mode == 'normalise')
        {
            $message = $lang['Topics_Normalised'] . '<br /><br />' . $message;
        }

		message_die(GENERAL_MESSAGE, $message);
        break;
    // MOD MODCP EXTENSION END        

    
# 
#-----[ FIND ]------------------------------------------ 
# 
			'L_LOCK' => $lang['Lock'],
			'L_UNLOCK' => $lang['Unlock'],

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
            // MOD MODCP EXTENSTION BEGIN
			'L_STICKY' => $lang['Sticky'],
			'L_ANNOUNCE' => $lang['Announce'],
			'L_NORMALISE' => $lang['Normalise'],
            'L_CHECK_ALL' => $lang['Check_All'], 
            'L_UNCHECK_ALL' => $lang['Uncheck_All'], 
            // MOD MODCP EXTENSTION END

    
# 
#-----[ FIND ]------------------------------------------ 
# 
			'S_MODCP_ACTION' => append_sid("modcp.$phpEx"))
		);

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
        if ($is_auth['auth_delete']) 
        {
    		$template->assign_block_vars('switch_auth_delete', array());
        }
        if ($is_auth['auth_sticky']) 
        {
    		$template->assign_block_vars('switch_auth_sticky', array());
        }
        if ($is_auth['auth_announce']) 
        {
    		$template->assign_block_vars('switch_auth_announce', array());
        }
        

# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php        
        
# 
#-----[ FIND ]------------------------------------------ 
# 
$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;';

# 
#-----[ REPLACE WITH ]----------------------------------
#         
$topic_mod .= ( $is_auth['auth_delete'] ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;' : "";


# 
#-----[ FIND ]------------------------------------------ 
# 
$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=split&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_split'] . '" alt="' . $lang['Split_topic'] . '" title="' . $lang['Split_topic'] . '" border="0" /></a>&nbsp;';

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
    // MOD Modcp Extansion BEGIN
    $normal_button = "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=normalise&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['folder'] . '" alt="' . $lang['Normal_topic'] . '" title="' . $lang['Normal_topic'] . '" border="0" /></a>&nbsp;';
    $sticky_button = ( $is_auth['auth_sticky'] ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=sticky&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['folder_sticky'] . '" alt="' . $lang['Sticky_topic'] . '" title="' . $lang['Sticky_topic'] . '" border="0" /></a>&nbsp;' : "";
    $announce_button = ( $is_auth['auth_announce'] ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=announce&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['folder_announce'] . '" alt="' . $lang['Announce_topic'] . '" title="' . $lang['Announce_topic'] . '" border="0" /></a>&nbsp;' : "";
    switch( $forum_topic_data['topic_type'] )
    {
        case POST_NORMAL: 
            $topic_mod .= $sticky_button . $announce_button;
            break;
        case POST_STICKY:
            $topic_mod .= $announce_button . $normal_button;
            break;
        case POST_ANNOUNCE:
            $topic_mod .= $sticky_button . $normal_button;
            break;
    }
    // MOD Modcp Extansion END

    
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Split_topic'] = 'Split this topic';

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
// MOD MODCP EXTENSION BEGIN
$lang['Sticky_topic'] = 'Sticky this topic';
$lang['Announce_topic'] = 'Announce this topic';
$lang['Normal_topic'] = 'Reset this topic to normal';
// MOD MODCP EXTENSION END


# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Lock'] = 'Lock';
$lang['Unlock'] = 'Unlock';

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
// MOD MODCP EXTENSION BEGIN
$lang['Sticky'] = 'Sticky';
$lang['Announce'] = 'Announcement';
$lang['Normalise'] = 'Normal';
// MOD MODCP EXTENSION END


# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Topics_Unlocked'] = 'The selected topics have been unlocked.';
$lang['No_Topics_Moved'] = 'No topics were moved.';

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
// MOD MODCP EXTENSION BEGIN
$lang['Topics_Stickyd'] = 'The selected topics have been stickied';
$lang['Topics_Announced'] = 'The selected topics have been announced';
$lang['Topics_Normalised'] = 'The selected topics have been normalised';
// MOD MODCP EXTENSION END
    

# 
#-----[ FIND ]------------------------------------------ 
# 
//
// That's all, Folks!

# 
#-----[ BEFORE, ADD ]------------------------------------ 
# 
// MOD MODCP EXTENSION BEGIN
$lang['Check_All'] = 'Check All'; 
$lang['Uncheck_All'] = 'Uncheck All'; 
// MOD MODCP EXTENSION END

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/modcp_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<form method="post" action="{S_MODCP_ACTION}"> 

# 
#-----[ IN-LINE FIND ]----------------------------------
# 
<form method

# 
#-----[ IN-LINE REPLACE WITH ]----------------------------
#         
<form name="modcpForm" id="modcpForm" method


# 
#-----[ FIND ]------------------------------------------ 
# 
		<input type="submit" name="delete" class="liteoption" value="{L_DELETE}" />
		&nbsp; 
        
# 
#-----[ REPLACE WITH ]----------------------------------
#         
        <!-- BEGIN switch_auth_delete -->
		<input type="submit" name="delete" class="liteoption" value="{L_DELETE}" />
		&nbsp; 
        <!-- END switch_auth_delete -->

        
# 
#-----[ FIND ]------------------------------------------ 
# 
		&nbsp; 
		<input type="submit" name="unlock" class="liteoption" value="{L_UNLOCK}" />

# 
#-----[ AFTER, ADD ]------------------------------------ 
# 
		&nbsp;
        <!-- BEGIN switch_auth_sticky -->
		<input type="submit" name="sticky" class="liteoption" value="{L_STICKY}" />
		&nbsp; 
        <!-- END switch_auth_sticky -->
        <!-- BEGIN switch_auth_announce -->
		<input type="submit" name="announce" class="liteoption" value="{L_ANNOUNCE}" />
		&nbsp; 
        <!-- END switch_auth_announce -->
		<input type="submit" name="normalise" class="liteoption" value="{L_NORMALISE}" />
        	&nbsp;

# 
#-----[ FIND ]------------------------------------------ 
# 
<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span>

# 
#-----[ IN-LINE FIND ]----------------------------------
# 
<span class="gensmall">{S_TIMEZONE}

# 
#-----[ IN-LINE BEFORE, ADD  ]--------------------------
<span class="gensmall"><a href="#" onclick="setCheckboxes('modcpForm', 'topic_id_list[]', true); return false;">{L_CHECK_ALL}</a>&nbsp;&nbsp;<a href="#" onclick="setCheckboxes('modcpForm', 'topic_id_list[]', false); return false;">{L_UNCHECK_ALL}</a></span><br/><br/>
		
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/overall_header.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
</head>

# 
#-----[ BEFORE, ADD ]-----------------------------------
# 
<script language="Javascript" type="text/javascript"> 
<!-- 
function setCheckboxes(theForm, elementName, isChecked)
{
    var chkboxes = document.forms[theForm].elements[elementName];
    var count = chkboxes.length;

    if (count) 
	{
        for (var i = 0; i < count; i++) 
		{
            chkboxes[i].checked = isChecked;
    	}
    } 
	else 
	{
    	chkboxes.checked = isChecked;
    } 

    return true;
} 
//--> 
</script> 
		
        
# 
#-----[ SAVE/CLOSE ALL FILES ]-------------------------- 
# 
# EoM