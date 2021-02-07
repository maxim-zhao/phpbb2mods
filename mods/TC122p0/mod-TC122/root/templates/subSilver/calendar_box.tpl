<!-- BEGIN calendar -->

<!-- BEGIN module -->
{calendar.module.OVERVIEW}
<!-- END module -->

<!-- BEGIN java -->
<script language="JavaScript" type="text/javascript" src="./includes/js_dom_toggle.js"></script>
<script language="Javascript" type="text/javascript" src="./includes/js_dom_overview.js"></script>
<!-- END java -->

<!-- BEGIN header_box -->
<!-- BEGIN java -->
<table align="center" cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td align="right"><span class="mainmenu">
		<a href="#" onClick="dom_toggle.toggle('calrow','calrow_pic', '{I_DOWN_ARROW}', '{I_UP_ARROW}'); return false;" class="gensmall"><img src="{I_TOGGLE}" id="calrow_pic" hspace="2" border="0" alt="" />{L_CALENDAR}</a>
	</span></td>
	<td width="2"></td>
</tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="calrow" style="display:{S_TOGGLE}"><tr><td>
<!-- END java -->
<!-- END header_box -->

<table cellpadding="2" cellspacing="1" border="0" width="100%" class="forumline">
<!-- BEGIN only -->
<tr>
	<th class="thHead" height="25" colspan="{calendar.CELL_SPAN}">
		<a href="{calendar.U_TITLE}" title="{calendar.TITLE}"><img src="{calendar.I_TITLE}" align="top" border="0" alt="{calendar.TITLE}" /></a>&nbsp;{calendar.TITLE}
	</th>
</tr>
<!-- END only -->
<!-- BEGIN first -->
<tr>
	<td class="catHead" colspan="7"><table cellpadding="2" cellspacing="0" width="100%" border="0"><tr>
		<td class="bodyline"><a href="{calendar.U_PREVIOUS}" class="nav" title="{L_PREVIOUS}">&nbsp;&laquo;&nbsp;</a></td>
		<td width="100%" align="center"><span class="cattitle">{calendar.TITLE}</span></td>
		<td class="bodyline"><a href="{calendar.U_NEXT}" class="nav" title="{L_NEXT}">&nbsp;&raquo;&nbsp;</a></td>
	</tr></table></td>
</tr>
<tr>
	<!-- BEGIN cell -->
	<!-- BEGIN left -->
	<th class="thCornerL" width="{calendar.CELL_WIDTH}%">
	<!-- END left -->
	<!-- BEGIN middle -->
	<th class="thTop" width="{calendar.CELL_WIDTH}%">
	<!-- END middle -->
	<!-- BEGIN right -->
	<th class="thCornerR" width="{calendar.CELL_WIDTH}%">
	<!-- END right -->
		{calendar.first.cell.L_DAY}
	</th>
	<!-- END cell -->
</tr>
<!-- END first -->
<!-- BEGIN row -->
<tr>
	<!-- BEGIN empty_cells_front -->
	<td rowspan="2" class="row3" colspan="{calendar.row.empty_cells_front.SPAN}" height="70">&nbsp;</td>
	<!-- END empty_cells_front -->
	<!-- BEGIN cell -->
	<td class="row2" align="center" width="{calendar.CELL_WIDTH}%"><span class="genmed">
		<!-- BEGIN selected -->
		<b>
		<!-- END selected -->
		<a href="{calendar.row.cell.U_TITLE}" class="genmed">{calendar.row.cell.TITLE}</a>
		<!-- BEGIN selected -->
		</b>
		<!-- END selected -->
	</span></td>
	<!-- END cell -->
	<!-- BEGIN empty_cells_rear -->
	<td rowspan="2" class="row3Right" colspan="{calendar.row.empty_cells_rear.SPAN}" height="70">&nbsp;</td>
	<!-- END empty_cells_rear -->
</tr>
<tr>
	<!-- BEGIN cell -->
	<td class="row1" width="{calendar.CELL_WIDTH}%" height="70" valign="top"><table cellpadding="0" cellspacing="1" border="0" width="100%">
	<!-- BEGIN event -->
	<!-- BEGIN more_header -->
	<tbody id="calcell_{calendar.row.cell.EVENT_DATE}" style="display:{calendar.row.cell.S_TOGGLE}">
	<!-- END more_header -->
	<tr>
		<!-- BEGIN content -->
		<td><img src="{calendar.row.cell.event.I_TITLE}" border="0" alt="{calendar.row.cell.event.L_TITLE}" title="{calendar.row.cell.event.L_TITLE}" /></td>
		<td width="100%"><span class="gensmall">
			<!-- BEGIN java -->
			<a href="{calendar.row.cell.event.U_TITLE}" class="gensmall" onMouseOver="dom_overview.show('{calendar.row.cell.event.ID}');">{calendar.row.cell.event.TITLE}</a>
			<!-- END java -->
			<!-- BEGIN java_ELSE -->
			<a href="{calendar.row.cell.event.U_TITLE}" class="gensmall" title="{calendar.row.cell.event.S_OVERVIEW}">{calendar.row.cell.event.TITLE}</a>
			<!-- END java_ELSE -->
		</span></td>
		<!-- END content -->
		<!-- BEGIN content_ELSE -->
		<td valign="top" colspan="2"><span class="gensmall">&nbsp;</span></td>
		<!-- END content_ELSE -->
		<td align="right" nowrap="nowrap"><span class="gensmall">
			<!-- BEGIN more -->
			<!-- BEGIN java -->
			<a href="#" onClick="dom_toggle.toggle('calcell_{calendar.row.cell.EVENT_DATE}','calcell_pic_{calendar.row.cell.EVENT_DATE}', '{I_DOWN_ARROW}', '{I_UP_ARROW}'); return false;" title="{L_MORE}" class="gensmall"><img src="{calendar.row.cell.I_TOGGLE}" id="calcell_pic_{calendar.row.cell.EVENT_DATE}" hspace="2" border="0" alt="" /></a>
			<!-- END java -->
			<!-- BEGIN java_ELSE -->
			<a href="{calendar.row.cell.U_TITLE}" title="{L_MORE}" class="gensmall"><img src="{calendar.row.cell.I_TOGGLE}" id="calcell_pic_{calendar.row.cell.EVENT_DATE}" hspace="2" border="0" /></a>
			<!-- END java_ELSE -->
			<!-- END more -->
			<!-- BEGIN more_ELSE -->
			&nbsp;
			<!-- END more_ELSE -->
		</span></td>
	</tr>
	<!-- BEGIN more_footer -->
	</tbody>
	<!-- END more_footer -->
	<!-- END event -->
	</table></td>
<!-- END cell -->
</tr>
<!-- END row -->
<!-- BEGIN first -->
<tr>
	<td class="catBottom" colspan="7">&nbsp;</td>
</tr>
<!-- END first -->
</table>

<!-- BEGIN header_box -->
<!-- BEGIN java -->
</td></tr></table>
<!-- END java -->
<!-- END header_box -->

<!-- END calendar -->