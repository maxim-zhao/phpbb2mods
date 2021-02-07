<br class="nav" />
<table cellpadding="2" cellspacing="1" border="0" width="100%" class="bodyline">
<tr>
	<td colspan="2" align="center"><span class="gensmall">
	{L_STAT_PAGE_DUR}{L_STAT_QUERIES}{L_STAT_SETUP}
	</span></td>
</tr>
<!-- BEGIN stat_run -->
<tr>
	<!-- BEGIN light -->
	<td class="row1">
	<!-- END light -->
	<!-- BEGIN light_ELSE -->
	<td class="row2">
	<!-- END light_ELSE -->
	<span class="gensmall">
		<b>{stat_run.STAT_FILE}</b><br />
		{stat_run.STAT_LINE}<br />
		{stat_run.STAT_TIME}<br />
	</span></td>
	<!-- BEGIN light -->
	<td class="row1">
	<!-- END light -->
	<!-- BEGIN light_ELSE -->
	<td class="row2">
	<!-- END light_ELSE -->
		<table cellpadding="2" cellspacing="1" width="100%" class="bodyline">
		<tr><td class="row3"><span class="gensmall">{L_STAT_REQUEST}
		</span></td></tr><tr><td class="row1"><span class="gensmall">&nbsp;{stat_run.STAT_REQUEST}&nbsp;
		</span></td></tr>
		</table>
		<!-- BEGIN explain -->
		<table cellpadding="2" cellspacing="1" width="100%" class="bodyline">
		<tr>
			<!-- BEGIN cell -->
			<td align="center" class="row3"><span class="gensmall">&nbsp;
				{stat_run.explain.cell.STAT_LEGEND}&nbsp;
			</span></td>
			<!-- END cell -->
		</tr>
		<!-- BEGIN table -->
		<tr>
			<!-- BEGIN cell -->
			<!-- BEGIN light -->
			<td class="row1">
			<!-- END light -->
			<!-- BEGIN light_ELSE -->
			<td class="row2">
			<!-- END light_ELSE -->
			<span class="gensmall">&nbsp;
				{stat_run.explain.table.cell.STAT_VALUE}&nbsp;
			</span></td>
			<!-- END cell -->
		</tr>
		<!-- END table -->
		</table>
		<!-- END explain -->
	</td>
</tr>
<!-- END stat_run -->
</table>
<br clear="all" />