##############################################################
## MOD Title: Simple Topic Description - Announces Suite Add-on 
## MOD Author: dvandersluis < daniel@codexed.com > (Daniel Vandersluis) http://www.codexed.com
## MOD Description: Updates the Announces suite to display topic descriptions as necessary.
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: ~1 Minutes
## Files To Edit: 2 
##		includes/functions_topics_list.tpl
##		templates/subSilver/topics_list_box.tpl
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
##		This mod requires the Announces Suite, available at
##		http://www.phpbb.com/phpBB/viewtopic.php?t=150853
##		to be installed first.
##		
##############################################################
## MOD History:
##
##   2006-04-27 - Version 1.0.0
##      - First version
##		- submitted to MODs database at phpBB.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]-----------------------------------------
#
includes/functions_topics_list.php

#
#-----[ FIND ]-----------------------------------------
#
# Partial Find
		$topic_title		= ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word,

#
#-----[ AFTER, ADD ]-----------------------------------
#	
		// +Simple Topic Description + Announces Suite
		$topic_desc			= ( count($orig_word) )
			? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_description'])
			: $topic_rowset[$i]['topic_description'];
		// -Simple Topic Description
#
#-----[ FIND ]-----------------------------------------
#
			'TOPIC_TITLE'			=> $topic_title,

#
#-----[ AFTER, ADD ]-----------------------------------
#
			// +Simple Topic Description + Announces Suite
			'TOPIC_DESC'			=> $topic_desc,
			// -Simple Topic Description
#
#-----[ FIND ]-----------------------------------------
#
		$template->assign_block_vars( $tpl . '.row.topic', array());

#
#-----[ AFTER, ADD ]-----------------------------------
#


		// +Simple Topic Description + Announces Suite
		if (is_string($topic_desc) && strlen($topic_desc) > 0)
		{
			$template->assign_block_vars( $tpl . '.row.topic.switch_has_description', array());
		}
		// -Simple Topic Description
#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/topics_list_box.tpl

#
#-----[ FIND ]-----------------------------------------
#
	<td class="{topics_list_box.row.ROW_CLASS}" width="100%">
		<span class="topictitle">{topics_list_box.row.NEWEST_POST_IMG}{topics_list_box.row.TOPIC_TYPE}<a href="{topics_list_box.row.U_VIEW_TOPIC}" class="topictitle">{topics_list_box.row.TOPIC_TITLE}</a></span><span class="gensmall">&nbsp;&nbsp;{topics_list_box.row.TOPIC_ANNOUNCES_DATES}{topics_list_box.row.TOPIC_CALENDAR_DATES}</span>
		<span class="gensmall">
			{topics_list_box.row.GOTO_PAGE}
			<!-- BEGIN nav_tree -->
			{topics_list_box.row.TOPIC_NAV_TREE}
			<!-- END nav_tree -->
		</span>
	</td>

#
#-----[ REPLACE WITH ]---------------------------------
#
	<!-- +Simple Topic Description + Announces Suite -->
	<td class="{topics_list_box.row.ROW_CLASS}" width="100%">
		<span class="topictitle">
			{topics_list_box.row.NEWEST_POST_IMG}{topics_list_box.row.TOPIC_TYPE}
			<a href="{topics_list_box.row.U_VIEW_TOPIC}" class="topictitle">{topics_list_box.row.TOPIC_TITLE}</a>
		</span>
		<span class="gensmall">
			&nbsp;&nbsp;{topics_list_box.row.TOPIC_ANNOUNCES_DATES}{topics_list_box.row.TOPIC_CALENDAR_DATES}
		</span>
		<!-- BEGIN switch_has_description -->
		<br /><span class="topictitle">{topics_list_box.row.TOPIC_DESC}</span>
		<!-- END switch_has_description -->
		<span class="gensmall">
			{topics_list_box.row.GOTO_PAGE}
			<!-- BEGIN nav_tree -->
			{topics_list_box.row.TOPIC_NAV_TREE}
			<!-- END nav_tree -->
		</span>
	</td>
	<!-- -Simple Topic Description -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
