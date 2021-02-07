
<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center" width="100%">
<tr>
	<th class="thCornerL" nowrap="nowrap" width="200">&nbsp;{L_BOT_NAME}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_BOT_AGENT}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_BOT_IPS}&nbsp;</th>
	<th class="thCornerR" width="100">&nbsp;{L_ACTION}&nbsp;</th>
</tr>
<!-- BEGIN row -->
<tr>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" nowrap="nowrap"><span class="gen">
		<a href="{row.U_EDIT}" title="{L_EDIT}" class="gen"><b>{row.BOT_NAME}</b></a>
	</span></td>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><span class="gen">
		{row.BOT_AGENT}
	</span></td>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><span class="gen">
		{row.BOT_IPS}
	</span></td>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" nowrap="nowrap" align="center"><span class="gen">
		&nbsp;<a href="{row.U_EDIT}" title="{L_EDIT}"><img src="{I_EDIT}" border="0" alt="{L_EDIT}" /></a>&nbsp;<br />
		&nbsp;<a href="{row.U_DELETE}" title="{L_DELETE}"><img src="{I_DELETE}" border="0" alt="{L_DELETE}" /></a>&nbsp;
	</span></td>
</tr>
<!-- END row -->
<!-- BEGIN empty -->
<tr>
	<td colspan="4" align="center" height="35" class="row1"><span class="gen">{L_EMPTY}
	</span></td>
</tr>
<!-- END empty -->
<tr>
	<td class="catBottom" colspan="4" align="center"><span class="gensmall">&nbsp;
		<!-- BEGIN buttons --><a href="{buttons.U_BUTTON}" title="{buttons.L_BUTTON}" accesskey="{buttons.S_BUTTON}"><img src="{buttons.I_BUTTON}" border="0" alt="{buttons.L_BUTTON}" /></a>&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>

<br clear="all" />
