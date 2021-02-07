##############################################################
## MOD Title: Simple Topic Description
## MOD Author: dvandersluis < daniel@codexed.com > (Daniel Vandersluis) http://www.codexed.com
## MOD Description: Simply allows for topics to have a description (similar to forums).
## MOD Version: 1.0.3
##
## Installation Level: Easy
## Installation Time: ~15 Minutes
## Files To Edit: 7 
##		posting.php
##		viewforum.php
##		includes/functions.php
##		includes/functions_post.php
##		language/lang_english/lang_main.php
##		templates/subSilver/posting_body.tpl
##		templates/subSilver/viewforum_body.tpl
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
##		This mod must obviously be installed first, before
##		any of the add-ons. It adds the ability for users
##		to add a description to a topic, which will be seen
##		on the viewtopic.php pages.
##
##		Add-ons can be installed in any order, and do not
##		depend on anything other than the installation of
##		this mod, unless otherwise specified.
##
##		Add-ons:
##		 * Permissions [contrib/install-permissions]:
##			Allows admins to set which user levels are
##			allowed to add topic descriptions, via the
##			ACP.
##		 * User Override [contrib/install-user-override]:
##			Allows admins to explicitly allow or disallow
##			users to add descriptions, via User Management
##			in the ACP.
##		 * Group Override [contrib/install-group-override]:
##			Allows admins to explicitly allow or disallow
##			usergroups to add descriptions, via Group
##			Management in the ACP.
##		 * Announces Suite [contrib/install-announces]:
##			Shows topic descriptions in the announces suite
##			box. (Announces Suite MOD required).
##		
##############################################################
## MOD History:
##
##	 2006-05-23
##		Version 1.0.3a
##		- Rerelease for MODDB.
##
##	 2006-05-19
##		Version 1.0.3
##		- Put the correct versions of the add-ons in the
##		  contrib/ dir (announces was missing, others were
##		  not correctly updated).
##		- Fixed broken FIND commands in functions_post.php
##
##	 2006-04-27
##		Version 1.0.2
##		- Added Announces Suite Add-on
##		- Fixed disappearing topic bug in preview mode on
##			posting.php
##
##	 2006-04-25
##		Version 1.0.1
##		- Fixed a couple bugs
##
##   2006-04-24
##		Version 1.0.0
##		- First version
##		- submitted to MODs database at phpBB.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_topics` ADD `topic_description` VARCHAR( 60 ) NULL DEFAULT NULL ;

#
#-----[ OPEN ]-----------------------------------------
#
posting.php

#
#-----[ FIND ]-----------------------------------------
#
$post_data = array();

#
#-----[ AFTER, ADD ]-----------------------------------
#
// +Simple Topic Description
$first_post_in_topic = false;
// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
	case 'newtopic':
		if ( empty($forum_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['Forum_not_exist']);
		}

#
#-----[ AFTER, ADD ]-----------------------------------
#
		// +Simple Topic Description
		$first_post_in_topic = true;
		// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
# Partial line
		$sql = "SELECT f.*, t.topic_id, 

#
#-----[ BEFORE, ADD ]----------------------------------
#
		// +Simple Topic Description
		// add after: t.topic_id
		// , t.topic_description
		// -Simple Topic Description

#
#-----[ IN-LINE FIND ]-----------------------------------
#
t.topic_id

#
#-----[ IN-LINE AFTER, ADD ]-----------------------------
#
, t.topic_description

#
#-----[ FIND ]-----------------------------------------
#
		$post_data['poster_id'] = $post_info['poster_id'];

#
#-----[ AFTER, ADD ]-----------------------------------
#
		// +Simple Topic Description
		if ($post_data['first_post'])
		{
			$post_data['topic_description'] = $post_info['topic_description'];
		}
		// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
# Partial Find
				submit_post($mode, $post_data

#
#-----[ BEFORE, ADD ]-----------------------------------
#
				// +Simple Topic Description
				$topic_description = ( $post_data['first_post'] && !empty($HTTP_POST_VARS['topic_description']) )
					? $HTTP_POST_VARS['topic_description'] : '';
				// add before: );
				// , str_replace("\'", "''", $topic_description)
				// -Simple Topic Description

#
#-----[ IN-LINE FIND ]-----------------------------------
#
);

#
#-----[ IN-LINE BEFORE, ADD ]----------------------------
#
, str_replace("\'", "''", $topic_description)

#
#-----[ FIND ]------------------------------------------
#
	$message = ( !empty($HTTP_POST_VARS['message']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['message']))) : '';

#
#-----[ AFTER, ADD ]------------------------------------
	// +Simple Topic Description
	$description = ( !empty($HTTP_POST_VARS['topic_description']) )
		? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['topic_description']))) : '';
	// -Simple Topic Description

#
#-----[ FIND ]------------------------------------------
#
	else if ( $mode == 'quote' || $mode == 'editpost' )
	{
		$subject = ( $post_data['first_post'] ) ? $post_info['topic_title'] : $post_info['post_subject'];
		$message = $post_info['post_text'];

#
#-----[ AFTER, ADD ]-----------------------------------
#
		// +Simple Topic Description
		$description = ( $post_data['first_post'] && $mode == 'editpost' ) ? $post_data['topic_description'] : '';
		// -Simple Topic Description

#
#-----[ FIND ]------------------------------------------
#
$template->assign_block_vars('switch_not_privmsg', array());

#
#-----[ AFTER, ADD ]------------------------------------
#
// +Simple Topic Description
if (user_has_td_auth($userdata))
{
	// Only display the description input if this is a new post or if it's the first post of a topic
	if ($post_data['first_post']) $template->assign_block_vars('switch_has_td_auth', array());
}
// -Simple Topic Description

#
#-----[ FIND ]------------------------------------------
#
$template->assign_vars(array(
	'USERNAME' => $username,
	'SUBJECT' => $subject,

#
#-----[ AFTER, ADD ]------------------------------------
#
	// +Simple Topic Description
	'DESCRIPTION' => $description,
	// -Simple Topic Description

#
#-----[ FIND ]------------------------------------------
#
	'L_SUBJECT' => $lang['Subject'],

#
#-----[ AFTER, ADD ]------------------------------------
#
	// +Simple Topic Description
	'L_DESCRIPTION' => $lang['Topic_Description'],
	// -Simple Topic Description

#
#-----[ OPEN ]------------------------------------------
#
viewforum.php

#
#-----[ FIND ]------------------------------------------
#
		$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title'];

#
#-----[ AFTER, ADD ]------------------------------------
#
		// +Simple Topic Description
		$topic_desc = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_description'])
			: $topic_rowset[$i]['topic_description'];
		// -Simple Topic Description

#
#-----[ FIND ]------------------------------------------
#
			'TOPIC_TYPE' => $topic_type,

#
#-----[ AFTER, ADD ]------------------------------------
#
			// +Simple Topic Description
			'TOPIC_DESCRIPTION' => (!empty($topic_desc) ? $topic_desc : ''),
			// -Simple Topic Description

#
#-----[ FIND ]------------------------------------------
#
			'U_VIEW_TOPIC' => $view_topic_url)
		);

#
#-----[ AFTER, ADD ]------------------------------------
#	
		// +Simple Topic Description
		if (!empty($topic_desc))
		{
			$template->assign_block_vars('topicrow.switch_has_description', array());
		}
		// -Simple Topic Description

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]-----------------------------------
#
# This function stub is added here, so that add-ons can
# be installed in any order.

// +Simple Topic Description
function user_has_td_auth($userdata)
{
	// Precedence Hierarchy for determining authentication:
	// 1. User Override (ignored if default)
	// 2. Group Override (ignored if default)
	// 3. User Level

	return true;
}
// -Simple Topic Description

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#
# Partial Find
function submit_post($mode,

#
#-----[ BEFORE, ADD ]------------------------------------
#
// +Simple Topic Description
// add before: )
// , $topic_description = ''
// -Simple Topic Description
#
#-----[ IN-LINE FIND ]-----------------------------------
#
)

#
#-----[ IN-LINE BEFORE, ADD ]----------------------------
#
, $topic_description = ''

#
#-----[ FIND ]------------------------------------------
#
	current_time = time();

#
#-----[ AFTER, ADD ]------------------------------------
#
	// +Simple Topic Description
	if (!is_string($topic_description) || is_null($topic_description)) $topic_description = '';
	$topic_description = htmlspecialchars(trim($topic_description));
	// -Simple Topic Description

#
#-----[ FIND ]------------------------------------------
#
			$sql  = ($mode != "editpost") ? "INSERT INTO " . TOPICS_TABLE

#
#-----[ BEFORE, ADD ]-----------------------------------
#
		// +Simple Topic Description
		// add after: topic_title 
		// , topic_description 
		// add after: '$post_subject'
		// " . ($topic_description != '' ? ", '$topic_description'" : "NULL") . " 
		// add after: topic_title = '$post_subject'
		// , topic_description = " . ($topic_description != '' ? " '$topic_description'" : "NULL") . " 
		// -Simple Topic Description
#
#-----[ IN-LINE FIND ]----------------------------------------
#
topic_title

#
#-----[ IN-LINE AFTER, ADD ]-----------------------------
#
, topic_description

#
#-----[ IN-LINE FIND ]-----------------------------------
#
'$post_subject'

#
#-----[ IN-LINE AFTER, ADD ]-----------------------------
#
, " . ($topic_description != '' ? " '$topic_description'" : "NULL") . "

#
#-----[ IN-LINE FIND ]-----------------------------------
#
topic_title = '$post_subject'

#
#-----[ IN-LINE AFTER, ADD ]-----------------------------
#
, topic_description = " . ($topic_description != '' ? " '$topic_description'" : "NULL") . "

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]-----------------------------------
#
// +Simple Topic Description
$lang['Topic_Description'] = "Topic Description";
// -Simple Topic Description

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/posting_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span></td>
	  <td class="row2" width="78%"> <span class="gen"> 
		<input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" />
		</span> </td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------
#
	<!-- +Simple Topic Description -->
	<!-- BEGIN switch_has_td_auth -->
	<tr>
		<td class="row1" width="22%">
			<span class="gen"><b>{L_DESCRIPTION}</b></span>
		</td>
		<td class="row2" width="78%">
			<span class="gen">
				<input type="text" name="topic_description" size="45" maxlength="60" style="width: 450px;" tabindex="3"
					class="post" value="{DESCRIPTION}" />
			</span>
		</td>
	</tr>
	<!-- END switch_has_td_auth -->
	<!-- -Simple Topic Description -->
#
#-----[ FIND ]------------------------------------------
#
			  <textarea name="message" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="{%:1}" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea>

#
#-----[ BEFORE, ADD ]-----------------------------------
#
			  <!-- Simple Topic Description: incremented tabindex + 1 -->
#
#-----[ INCREMENT ]-------------------------------------
#
%:1 +1

#
#-----[ FIND ]------------------------------------------
#
<input type="submit" tabindex="{%:1}" name="preview" class="mainoption" value="{L_PREVIEW}" />&nbsp;<input type="submit" accesskey="s" tabindex="{%:2}" name="post" class="mainoption" value="{L_SUBMIT}" />

#
#-----[ BEFORE, ADD ]-----------------------------------
#
	  <!-- Simple Topic Description: incremented two tabindexes + 1 -->
#
#-----[ INCREMENT ]-------------------------------------
#
%:1 +1

#
#-----[ INCREMENT ]-------------------------------------
#
%:2 +1

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewforum_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	  <td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />
		{topicrow.GOTO_PAGE}</span></td>

#
#-----[ REPLACE WITH ]----------------------------------
#
	  <td class="row1" width="100%">
		<span class="topictitle">
			{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}
			<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a>
		</span><br />
		<!-- BEGIN switch_has_description -->
		<span class="topictitle" style="margin-left: 2px;">{topicrow.TOPIC_DESCRIPTION}</span><br />
		<!-- END switch_has_description -->
		<span class="gensmall">{topicrow.GOTO_PAGE}</span>
	  </td>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
