
<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<!-- BEGIN empty_ELSE -->
<table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center" width="75%">
<tr>
	<th class="thHead" colspan="2">{L_SAMPLE}</th>
</tr>
<!-- END empty_ELSE -->
{ICON_BOX}
<!-- BEGIN empty_ELSE -->
</table>
<br class="nav" />
<!-- END empty_ELSE -->

<table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center" width="75%">
<tr>
	<th class="thCornerL" colspan="2" nowrap="nowrap">&nbsp;{L_ICONS}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_AUTHS}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_TYPES}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_STATS}&nbsp;</th>
	<th class="thCornerR" width="100">&nbsp;{L_ACTION}&nbsp;</th>
</tr>
<!-- BEGIN empty -->
<tr>
	<td colspan="6" align="center" class="row1" height="30"><span class="gen">
		{L_EMPTY}
	</span></td>
</tr>
<!-- END empty -->
<!-- BEGIN row -->
<tr>
	<td width="20" align="center" class="row1"><img src="{row.I_ICON}" title="{row.L_ICON}" border="0" />
	</td>
	<td class="row1"><span class="gen">{row.L_ICON}
		<!-- BEGIN lang_key -->
		</span><span class="gensmall">
			<br />({row.LANG_KEY})
		<!-- END lang_key -->
	</span></td>
	<td align="center" class="row2"><span class="gen">
		{row.L_AUTH}
	</span></td>
	<td align="center" class="row1"><span class="gen">
		<!-- BEGIN type -->
		{row.type.L_TYPE}<br />
		<!-- END type -->
	</span></td>
	<td align="center" class="row2"><span class="gen">
		{row.COUNT}&nbsp;({row.PER_CENT}%)
	</span></td>
	<td class="row3Right" align="center" nowrap="nowrap"><table cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td><a href="{row.U_MOVE_UP}" title="{L_MOVE_UP}"><img src="{I_MOVE_UP}" alt="{L_MOVE_UP}" border="0" /></a></td>
		<td><a href="{row.U_EDIT}" title="{L_EDIT}"><img src="{I_EDIT}" alt="{L_EDIT}" border="0" /></a></td>
	</tr>
	<tr>
		<td><a href="{row.U_MOVE_DOWN}" title="{L_MOVE_DOWN}"><img src="{I_MOVE_DOWN}" alt="{L_MOVE_DOWN}" border="0" /></a></td>
		<td><a href="{row.U_DELETE}" title="{L_DELETE}"><img src="{I_DELETE}" alt="{L_DELETE}" border="0" /></a></td>
	</tr>
	</table></td>
</tr>
<!-- END row -->
<tr>
	<td class="catBottom" colspan="6" align="center"><span class="gensmall">&nbsp;
		<!-- BEGIN buttons --><a href="{buttons.U_BUTTON}" title="{buttons.L_BUTTON}" accesskey="{buttons.S_BUTTON}"><img src="{buttons.I_BUTTON}" border="0" alt="{buttons.L_BUTTON}" /></a>&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>


<br clear="all" />
