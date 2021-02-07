<!-- BEGIN stat_run_table -->
<br class="nav" />
<table cellpadding="2" cellspacing="1" border="0" width="100%" class="bodyline">
<tr>
	<td colspan="2" align="center"><span class="gensmall">
	{L_STAT_PAGE_DUR}{L_STAT_QUERIES}{L_STAT_SETUP}
	</span></td>
</tr>
<!-- END stat_run_table -->
<!-- BEGIN stat_run -->
<tr>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><span class="gensmall">
		{stat_run.STAT_FILE}<br />
		{stat_run.STAT_LINE}<br />
		<!-- BEGIN cached -->{stat_run.STAT_TIME_CACHE}<br /><!-- END cached -->
		{stat_run.STAT_TIME_DB}<br />
		</span>
	</td>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->">
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
			<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><span class="gensmall">&nbsp;
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
<!-- BEGIN stat_run_table -->
</table>
<br clear="all" />
<!-- END stat_run_table -->
<!-- BEGIN stat_run_pgm -->
<table cellpadding="2" cellspacing="1" border="0" width="100%" class="bodyline">
<tr>
	<td colspan="2"><span class="gensmall">{stat_run_pgm.L_BACKTRACE}</span></td>
</tr>
<!-- BEGIN call -->
<tr>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" nowrap="nowrap"><span class="gensmall">
		{stat_run_pgm.call.FILE}<br />
		{stat_run_pgm.call.LINE}<br />
		{stat_run_pgm.call.ELAPSED}<br />
	</span></td>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" width="100%"><span class="gensmall">
		<!-- BEGIN requester -->
		{stat_run_pgm.call.requester.FILE} - {stat_run_pgm.call.requester.LINE}<br />
		<!-- END requester -->
	</span></td>
</tr>
<!-- END call -->
</table>
<!-- END stat_run_pgm -->