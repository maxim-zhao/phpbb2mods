<!-- BEGIN calendar_form -->
<form name="calendar" method="post" action="{calendar_form.S_ACTION}">
<!-- END calendar_form -->
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
<tr> 
	<td align="left" valign="middle" class="nav" width="100%"><span class="nav">
		<a href="{U_INDEX}" class="nav">{L_INDEX}</a>&nbsp;-&gt;&nbsp;<a href="{U_CALENDAR_PAGE}" class="nav">{L_CALENDAR_PAGE}</a>
	</span></td>
</tr>
</table>

{SCHEDULAR_OVERVIEW_BOX}

<!-- BEGIN calendar -->
<!-- BEGIN module -->
{calendar.module.OVERVIEW}
<!-- END module -->

<!-- BEGIN java -->
<script language="JavaScript" type="text/javascript" src="./includes/js_dom_toggle.js"></script>
<script language="Javascript" type="text/javascript" src="./includes/js_dom_overview.js"></script>
<!-- END java -->

<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="250" valign="top">

<!-- BEGIN month -->
<!-- BEGIN day_overview -->
<div id="{calendar.month.day_overview.ID}" class="_dom_overview_abshidden"><table cellpadding="2" cellspacing="1" border="0" class="bodyline" width="100%"><tr><td><table cellspacing="1" cellpadding="2" border="0" class="forumline" width="100%">
<tr>
	<td class="catHead" colspan="2"><a href="{calendar.month.day_overview.U_DATE}" class="cattitle">{calendar.month.day_overview.DATE}</a></td>
</tr>
<!-- BEGIN event -->
<tr>
	<td class="row1">
		<img src="{calendar.month.day_overview.event.I_TITLE}" border="0" alt="{calendar.month.day_overview.event.L_TITLE}" title="{calendar.month.day_overview.event.L_TITLE}" />
	</td>
	<td class="row1" width="100%">
		<a href="{calendar.month.day_overview.event.U_TITLE}" class="gensmall">{calendar.month.day_overview.event.TITLE}</a>
	</td>
</tr>
<!-- END event -->
</table></td></tr></table></div>
<!-- END day_overview -->

<table cellpadding="2" cellspacing="1" border="0" width="250" class="forumline">
<tr>
	<th class="thHead" colspan="7">
		<!-- BEGIN linked -->
		<a href="{calendar.month.U_MONTH}" title="{L_CALENDAR}"><img src="{calendar.month.I_MONTH}" border="0" alt="." align="top" /></a>&nbsp;
		<!-- END linked -->
		{calendar.month.MONTH}
	</th>
</tr>
<tr>
	<!-- BEGIN header_cell -->
	<!-- BEGIN left -->
	<td class="catLeft" width="14%" align="center">
	<!-- END left -->
	<!-- BEGIN middle -->
	<td class="cat" width="14%" align="center">
	<!-- END middle -->
	<!-- BEGIN right -->
	<td class="catRight" width="14%" align="center">
	<!-- END right -->
	<span class="gensmall">
		<b>{calendar.month.header_cell.L_DAY}</b>
	</span></td>
	<!-- END header_cell -->
</tr>
<!-- BEGIN row -->
<tr>
	<!-- BEGIN empty_cells_front -->
	<td class="row3" width="14%" colspan="{calendar.month.row.empty_cells_front.SPAN}" height="25">&nbsp;</td>
	<!-- END empty_cells_front -->
	<!-- BEGIN cell -->
	<!-- BEGIN selected -->
	<td class="bodyline" align="center" width="14%" height="25">
	<!-- END selected -->
	<!-- BEGIN today -->
	<td class="row1" align="center" width="14%" height="25">
	<!-- END today -->
	<!-- BEGIN otherday -->
	<td class="row2" align="center" width="14%" height="25">
	<!-- END otherday -->
		<!-- BEGIN content -->
		<!-- BEGIN java -->
		<b><a href="{calendar.month.row.cell.U_DAY}" class="genmed" onMouseOver="dom_overview.show('{calendar.month.row.cell.ID}');">{calendar.month.row.cell.DAY}</a></b>
		<!-- END java -->
		<!-- BEGIN java_ELSE -->
		<b><a href="{calendar.month.row.cell.U_DAY}" class="genmed" title="{calendar.month.row.cell.S_DAY}">{calendar.month.row.cell.DAY}</a></b>
		<!-- END java_ELSE -->
		<!-- END content -->
		<!-- BEGIN content_ELSE -->
		<a href="{calendar.month.row.cell.U_DAY}" class="genmed">{calendar.month.row.cell.DAY}</a>
		<!-- END content_ELSE -->
	</td>
	<!-- END cell -->
	<!-- BEGIN empty_cells_rear -->
	<td class="row3Right" width="14%" colspan="{calendar.month.row.empty_cells_rear.SPAN}" height="25">&nbsp;</td>
	<!-- END empty_cells_rear -->
</tr>
<!-- END row -->
<tr>
	<td class="catBottom" align="center" colspan="7">&nbsp;</td>
</tr>
</table>
<br style="font-size: 3px" />
<!-- END month -->

</td><td width="3" valign="top"><img src="{I_SPACER}" alt="" width="3" /></td><td valign="top">

{CALENDAR_SELECT_FORM}

<table cellpadding="2" cellspacing="1" border="0" class="forumline" width="100%">
<tr>
	<th class="thHead">{calendar.L_CALENDAR}</th>
</tr>
<tr>
	<td class="catSides" align="center"><table cellpadding="2" cellspacing="0" width="100%" border="0"><tr>
		<td class="bodyline"><a href="{calendar.U_PREVIOUS_DAY}" class="nav" title="{L_PREVIOUS}">&nbsp;&laquo;&nbsp;</a></td>
		<td width="100%" align="center"><span class="cattitle">
			{calendar.TITLE}
		</span></td>
		<td class="bodyline"><a href="{calendar.U_NEXT_DAY}" class="nav" title="{L_NEXT}">&nbsp;&raquo;&nbsp;</a></td>
	</tr></table></td>
</tr>
<tr>
	<td class="row3" height="100%"><table cellpadding="10" cellspacing="0" width="100%" border="0">
	<!-- BEGIN cat -->
	<tr><td width="100%"><table cellpadding="2" cellspacing="1" border="0" class="bodyline" width="100%">
	<tr>
		<td class="row1"><div class="maintitle">{calendar.cat.TITLE}</div><hr /><table cellpadding="2" cellspacing="1" border="0" width="100%">
			<!-- BEGIN event -->
			<!-- BEGIN single_line -->
			<!-- BEGIN first -->
			<tr>
				<td><span class="topictitle">
			<!-- END first -->
			<!-- END single_line -->
			<!-- BEGIN single_line_ELSE -->
			<tr>
				<td><span class="topictitle">
			<!-- END single_line_ELSE -->
					<!-- BEGIN java -->
					<a href="{calendar.cat.event.U_TITLE}" class="topictitle" onMouseOver="dom_overview.show('{calendar.cat.event.ID}');">{calendar.cat.event.TITLE}</a>{calendar.cat.event.L_SEP}
					<!-- END java -->
					<!-- BEGIN java_ELSE -->
					<a href="{calendar.cat.event.U_TITLE}" class="topictitle" title="{calendar.cat.event.S_OVERVIEW}">{calendar.cat.event.TITLE}</a>{calendar.cat.event.L_SEP}
					<!-- END java_ELSE -->
					<!-- BEGIN dates -->
					</span><br /><span class="gensmall">{calendar.cat.event.S_DATES}<br />
					<!-- END dates -->
			<!-- BEGIN single_line_ELSE -->
				</span></td>
			<!-- END single_line_ELSE -->
				<!-- BEGIN timeframe -->
				<td width="400" nowrap="nowrap" align="right" valign="top"><table cellpadding="0" cellspacing="1" border="0" class="bodyline">
				<tr>
				<!-- BEGIN hours -->
					<!-- BEGIN header_light -->
					<td width="14" class="row1" height="14"><a href="{calendar.cat.event.timeframe.hours.U_HOUR}" class="gensmall">{calendar.cat.event.timeframe.hours.HOUR}</a></td>
					<!-- END header_light -->
					<!-- BEGIN header_light_ELSE -->
					<td width="14" class="row2" height="14"><a href="{calendar.cat.event.timeframe.hours.U_HOUR}" class="gensmall">&nbsp;&nbsp;&nbsp;</a></td>
					<!-- END header_light_ELSE -->
				<!-- END hours -->
				</tr>
				<tr>
				<!-- BEGIN hours -->
					<!-- BEGIN selected -->
					<td class="row3" width="14" align="center" height="14"><a href="{calendar.cat.event.timeframe.hours.U_HOUR}" class="gensmall"><b>&bull;</b></a></td>
					<!-- END selected -->
					<!-- BEGIN light -->
					<td class="row1" width="14" align="center" height="14"><a href="{calendar.cat.event.timeframe.hours.U_HOUR}" class="gensmall">&nbsp;&nbsp;&nbsp;</a></td>
					<!-- END light -->
					<!-- BEGIN dark -->
					<td class="row2" width="14" align="center" height="14"><a href="{calendar.cat.event.timeframe.hours.U_HOUR}" class="gensmall">&nbsp;&nbsp;&nbsp;</a></td>
					<!-- END dark -->
				<!-- END hours -->
				</tr></table></td>
				<!-- END timeframe -->
			<!-- BEGIN single_line -->
			<!-- BEGIN last -->
				</span></td>
			</tr>
			<!-- END last -->
			<!-- END single_line -->
			<!-- BEGIN single_line_ELSE -->
			</tr>
			<!-- END single_line_ELSE -->
			<!-- END event -->
		</table></td>
	</tr>
	</table></td></tr>
	<!-- END cat -->
	<!-- BEGIN empty -->
	<tr><td width="100%"><table cellpadding="2" cellspacing="1" border="0" class="bodyline" width="100%">
	<tr>
		<td class="row1"><div class="maintitle">{calendar.L_EMPTY}</div></td>
	</tr></table></td></tr>
	<!-- END empty -->
	</table></td>
</tr>
<tr>
	<td class="catBottom" align="center">&nbsp;</td>
</tr>
</table>

</td></tr></table>
<!-- END calendar -->

<!-- BEGIN calendar_form -->
</form>
<!-- END calendar_form -->