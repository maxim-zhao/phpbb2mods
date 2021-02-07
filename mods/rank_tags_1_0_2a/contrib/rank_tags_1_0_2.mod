##############################################################
## MOD Title: Rank Tags
## MOD Author: eviL3 < evil@phpbbmodders.net > (Igor Wiedler) http://phpbbmodders.net
## MOD Description: This MOD will make it easier to add HTML formating tags to your ranks.
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 5 Minutes
##
## Files To Edit: viewtopic.php,
##                admin/admin_ranks.php,
##                includes/usercp_viewprofile.php,
##                language/lang_english/lang_admin.php,
##                templates/subSilver/admin/ranks_edit_body.tpl
##
## Included Files: n/a
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
## This MOD is inspired by one for vBulletin. It makes it easier
## to add html to the rank. Such as CSS styles or glow tags (ie only).
##
## Thanks to angelp1ay, who made a memberlist addon.
##
##############################################################
## MOD History:
##
##   2006-09-07 - Version 0.1.0
##      - First release :)
##
##   2006-09-08 - Version 0.1.1
##      - Replaced serialize() with implode()
##
##   2006-09-08 - Version 0.1.2
##      - fixed edit using htmlentities()
##
##   2006-09-09 - Version 0.1.3
##      - changed the explode() seperator with \n
##      - removed sprintf()'s
##      - added some sizeof()'s
##      - fixed 2 BEFORE, ADDs (thanks alexi02)
##
##   2006-09-24 - Version 1.0.0
##      - Submitted to MODDB
##
##   2006-11-02 - Version 1.0.1
##      - Changed description 8)
##
##   2006-11-28 - Version 1.0.2
##      - Recommented
##      - MODx
##      - Added an addon for the memberlist (thanks angelp1ay)
##
##   2006-12-10 - Version 1.0.2a
##      - Fixed up the alt="" (thanks angelp1ay)
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#

ALTER TABLE `phpbb_ranks` ADD `rank_tags` TEXT NOT NULL DEFAULT '';

#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
// Generate ranks, set them to empty string initially.
#
#-----[ FIND ]------------------------------------------
#
	$rank_image = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
	$rank_tags = '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
				$poster_rank
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
				$rank_tags = ($ranksrow[$j]['rank_tags']) ? explode("\n", $ranksrow[$j]['rank_tags']) : '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
				$rank_image
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
				$poster_rank = ( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $poster_rank . $rank_tags[1] : $poster_rank;
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
				$poster_rank
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
				$rank_tags = ($ranksrow[$j]['rank_tags']) ? explode("\n", $ranksrow[$j]['rank_tags']) : '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
				$rank_image
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
				$poster_rank = ( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $poster_rank . $rank_tags[1] : $poster_rank;
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_ranks.php
#
#-----[ FIND ]------------------------------------------
#
		$rank_is_not_special
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
		$rank_tags = ($rank_info['rank_tags']) ? explode("\n", $rank_info['rank_tags']) : '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
			"RANK" => $rank_info['rank_title'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
			'RANK_TAGS_BEFORE'	=> htmlentities($rank_tags[0]),
			'RANK_TAGS_AFTER'	=> htmlentities($rank_tags[1]),
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
			"L_RANK_TITLE" => $lang['Rank_title'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
			'L_RANK_TAGS'			=> $lang['Rank_tags'],
			'L_RANK_TAGS_EXPLAIN'	=> $lang['Rank_tags_explain'],
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
		$rank_image
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
		$rank_tags_post[0] = ( (isset($HTTP_POST_VARS['tags_before'])) ) ? trim($HTTP_POST_VARS['tags_before']) : '';
		$rank_tags_post[1] = ( (isset($HTTP_POST_VARS['tags_after'])) ) ? trim($HTTP_POST_VARS['tags_after']) : '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
	if( $special_rank == 1 )
#
#-----[ FIND ]------------------------------------------
#
	}
#
#-----[ AFTER, ADD ]------------------------------------------
#

//-- mod : Rank Tags ------------------------------------------------------------
//-- add
		$rank_tags = '';
		if( $rank_tags_post )
		{
			$rank_tags = implode("\n", $rank_tags_post);
		}
//-- fin mod : Rank Tags --------------------------------------------------------

#
#-----[ FIND ]------------------------------------------
#
				SET rank_title
#
#-----[ IN-LINE FIND ]------------------------------------------
#
str_replace("\'", "''", $rank_title)
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 . "', rank_tags = '" . str_replace("\'", "''", $rank_tags)
#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO "
#
#-----[ IN-LINE FIND ]------------------------------------------
#
rank_title,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 rank_tags,
#
#-----[ FIND ]------------------------------------------
#
				VALUES
#
#-----[ IN-LINE FIND ]------------------------------------------
#
str_replace("\'", "''", $rank_title)
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 . "', '" . str_replace("\'", "''", $rank_tags)
#
#-----[ FIND ]------------------------------------------
#
	$rank_min = $rank_rows[$i]['rank_min'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
	$rank_tags = ($rank_rows[$i]['rank_tags']) ? explode("\n", $rank_rows[$i]['rank_tags']) : '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
		"RANK" => $rank,
#
#-----[ IN-LINE FIND ]------------------------------------------
#
$rank
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $rank . $rank_tags[1] : $rank
#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------
#
$poster_rank = '';
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
$rank_tags = '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
			$poster_rank
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
			$rank_tags = ($ranksrow[$i]['rank_tags']) ? explode("\n", $ranksrow[$i]['rank_tags']) : '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
			$rank_image
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
			$poster_rank = ( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $poster_rank . $rank_tags[1] : $poster_rank;
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
			$poster_rank
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
			$rank_tags = ($ranksrow[$i]['rank_tags']) ? explode("\n", $ranksrow[$i]['rank_tags']) : '';
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ FIND ]------------------------------------------
#
			$rank_image
#
#-----[ AFTER, ADD ]------------------------------------------
#
//-- mod : Rank Tags ------------------------------------------------------------
//-- add
			$poster_rank = ( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $poster_rank . $rank_tags[1] : $poster_rank;
//-- fin mod : Rank Tags --------------------------------------------------------
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Confirm_delete_rank']
#
#-----[ AFTER, ADD ]------------------------------------------
#

//-- mod : Rank Tags ------------------------------------------------------------
//-- add
$lang['Rank_tags']			= 'Rank Tags';
$lang['Rank_tags_explain']	= 'Enter the starting tag into the first field and the ending into the second.';
//-- fin mod : Rank Tags --------------------------------------------------------

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/ranks_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_RANK_TITLE}:</span></td>
		<td class="row2"><input class="post" type="text" name="title" size="35" maxlength="40" value="{RANK}" /></td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<!-- Rank Tags -->
	<tr>
		<td class="row1" width="38%">
			<span class="gen">{L_RANK_TAGS}:</span><br />
			<span class="gensmall">{L_RANK_TAGS_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input class="post" type="text" name="tags_before" size="18" value="{RANK_TAGS_BEFORE}" />&nbsp;
			<input class="post" type="text" name="tags_after" size="18" value="{RANK_TAGS_AFTER}" />
    	</td>
	</tr>
	<!-- Rank Tags -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
