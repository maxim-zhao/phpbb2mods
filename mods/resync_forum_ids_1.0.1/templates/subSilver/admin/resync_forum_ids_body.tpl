
<h1>{L_RESYNC_TITLE}</h1>

<p>{L_RESYNC_EXPLAIN}</p>
<!-- BEGIN switch_board_disabled -->
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">	
	<tr>
	  <th class="thHead">{switch_board_disabled.L_DISABLE_BOARD}</th>
	</tr>
	<tr>
		<td>{switch_board_disabled.L_DISABLE_BOARD_EXPLAIN}</td>
	</tr>
	<tr>
		<td>{switch_board_disabled.L_DISABLE_BOARD_NOW}</td>
</table><br />
<!-- END switch_board_disabled -->

<form action="{S_RESYNC_ACTION}" method="post" name="resync" onSubmit="if(!document.resync.resync_forum_ids.checked && !document.resync.resync_category_ids.checked){alert('{L_MUST_SELECT_RESYNC}');return false;}"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_RESYNC_FORUM_CATEGORY_IDS}</th>
	</tr>
	<tr>
		<td class="row1">{L_SELECT_RESYNC}</td>
		<td class="row2"><input type="checkbox" name="resync_forum_ids" value="1" /> {L_RESYNC_FORUMS}<br /><input type="checkbox" name="resync_category_ids" value="1" /> {L_RESYNC_CATEGORIES}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<br clear="all" />
