<table width="100%" border="0" cellpadding="0" cellspacing="5">
<thead>
<tr>
	<td colspan="2">
		<!-- BEGIN title -->
		<span class="maintitle">{title.L_RANK}</span><br />
		<!-- END title -->
		<span class="nav">
			<a href="{U_INDEX}" class="nav">{L_INDEX}</a>&nbsp;-&gt;
			<a href="{U_RANKS}" class="nav">{L_RANKS}</a>
		</span>
		<!-- BEGIN pagination -->
		<div style="float: right"><span class="nav">{pagination.PAGINATION}&nbsp;</span></div>
		<div class="nav">&nbsp;{pagination.PAGE_NUMBER}</div>
		<!-- END pagination -->
	</td>
</tr>
</thead>
<tfoot>
<!-- BEGIN pagination -->
<tr>
	<td colspan="2">
		<div style="float: right"><span class="nav">{pagination.PAGINATION}&nbsp;</span></div>
		<div class="nav">&nbsp;{pagination.PAGE_NUMBER}</div>
	</td>
</tr>
<!-- END pagination -->
<tr>
	<td colspan="2" align="right"><span class="gensmall">&nbsp;{S_TIMEZONE}</span></td>
</tr>
</tfoot>
<tbody>
<tr>
	<!-- BEGIN block -->

	<!-- BEGIN ranks -->
	<td valign="top" width="50%">
		<table border="0" cellpadding="4" cellspacing="1" class="forumline" width="100%">
		<thead>
		<tr>
			<th class="thCornerL" nowrap="nowrap" align="center">&nbsp;{block.ranks.L_RANKS}&nbsp;</th>
			<!-- BEGIN edge -->
			<th class="thTop" nowrap="nowrap" align="center">&nbsp;{L_MINI}&nbsp;</th>
			<!-- END edge -->
			<th class="thCornerR" width="1%" nowrap="nowrap" align="center">&nbsp;{L_COUNT}&nbsp;</th>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<!-- BEGIN edge -->
			<td class="catbottom" colspan="3" align="right">
			<!-- END edge -->
			<!-- BEGIN edge_ELSE -->
			<td class="catbottom" colspan="2" align="right">
			<!-- END edge_ELSE -->
				<span class="cattitle">&nbsp;{block.ranks.TOTAL}</span>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<!-- BEGIN row -->
		<tr>
			<td class="row1" align="center" nowrap="nowrap"><span class="gen">
				<!-- BEGIN image -->
				<img src="{block.ranks.row.I_RANK}" alt="" border="0" /><br />
				<!-- END image -->
				{block.ranks.row.L_RANK}<br />
			</span></td>
			<!-- BEGIN edge -->
			<td class="row2" align="center"><span class="gen">{block.ranks.row.MINI}</span></td>
			<!-- END edge -->
			<td class="row3Right">
				<div class="gensmall" style="float: left; width: 70px; text-align: right;"><strong>{block.ranks.row.PERCENT}</strong>%</div>
				<div style="width: 100px; background-color: #fefefe; border: 1px inset #333366;"><div style="height: 11px; width: {block.ranks.row.PERCENT_DRAW}px; background-color: #33f066; border: none;">&nbsp;</div></div>
				<div style="clear: left; float: left; width: 50%" class="genmed">
					<!-- BEGIN view -->
					<a href="{block.ranks.row.U_RANK}" title="{L_RANK_VIEW_LONG}" class="genmed">{L_RANK_VIEW}</a>
					<!-- END view -->
				&nbsp;</div>
				<div class="genmed" style="text-align: right;">{block.ranks.row.TOTAL}</div>
			</td>
		</tr>
		<!-- END row -->
		<!-- BEGIN row_ELSE -->
		<tr>
			<!-- BEGIN edge -->
			<td class="row1" colspan="3" align="center">
			<!-- END edge -->
			<!-- BEGIN edge_ELSE -->
			<td class="row1" colspan="2" align="center">
			<!-- END edge_ELSE -->
				<span class="gen"><br />{block.ranks.L_EMPTY_RANKS}<br /><br /></span>
			</td>
		</tr>
		<!-- END row_ELSE -->
		</tbody>
		</table>
	</td>
	<!-- END ranks -->

	<!-- BEGIN ranks_short -->
	<td valign="top" width="200">
		<table border="0" cellpadding="4" cellspacing="1" class="forumline" width="100%">
		<thead>
		<tr>
			<th class="thCornerL" nowrap="nowrap" align="center">&nbsp;{block.ranks_short.L_RANKS}&nbsp;</th>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<td class="catbottom" align="right">
				<span class="cattitle">&nbsp;{block.ranks_short.TOTAL}</span>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<!-- BEGIN row -->
		<tr>
			<!-- BEGIN light -->
			<td class="row1" align="center" width="200">
			<!-- END light -->
			<!-- BEGIN light_ELSE -->
			<td class="row2" align="center" width="200">
			<!-- END light_ELSE -->
				<span class="gen">
					{block.ranks_short.row.L_RANK}
					<!-- BEGIN image -->
					<br /><img src="{block.ranks_short.row.I_RANK}" alt="" border="0" />
					<!-- END image -->
				</span>
				<!-- BEGIN edge -->
				<br /><span class="gensmall">{L_MINI}:&nbsp;{block.ranks_short.row.MINI}</span>
				<!-- END edge -->
				<hr /><table cellpadding="0" cellspacing="0" border="0"><tr><td>
					<div class="gensmall" style="float: left; width: 70px; text-align: right;"><strong>{block.ranks_short.row.PERCENT}</strong>%</div>
					<div style="width: 100px; background-color: #fefefe; border: 1px inset #333366;"><div style="height: 11px; width: {block.ranks_short.row.PERCENT_DRAW}px; background-color: #33f066; border: none;">&nbsp;</div></div>
					<div style="clear: left; float: left; width: 50%" class="genmed">
						<!-- BEGIN view -->
						<a href="{block.ranks_short.row.U_RANK}" title="{L_RANK_VIEW_LONG}" class="genmed">{L_RANK_VIEW}</a>
						<!-- END view -->
					&nbsp;</div>
					<div class="genmed" style="text-align: right;">{block.ranks_short.row.TOTAL}</div>
				</td></tr></table>
			</td>
		</tr>
		<!-- END row -->
		<!-- BEGIN row_ELSE -->
		<tr>
			<td class="row1" align="center"><span class="genmed"><br />{block.ranks_short.L_EMPTY_RANKS}<br /><br /></span></td>
		</tr>
		<!-- END row_ELSE -->
		</tbody>
		</table>
	</td>
	<!-- END ranks_short -->

	<!-- BEGIN members -->
	<td valign="top" rowspan="2"><table cellpadding="4" cellspacing="1" border="0" width="100%" class="forumline">
	<thead>
	<tr>
		<th height="25" class="thCornerL" nowrap="nowrap">#</th>
		<th class="thTop" nowrap="nowrap">{L_USERNAME}</th>
		<th class="thTop" nowrap="nowrap">&nbsp;</th>
		<th class="thTop" nowrap="nowrap">{L_EMAIL}</th>
		<th class="thTop" nowrap="nowrap">{L_FROM}</th>
		<th class="thTop" nowrap="nowrap">{L_JOINED}</th>
		<th class="thTop" nowrap="nowrap">{L_POSTS}</th>
		<th class="thCornerR" nowrap="nowrap">{L_WEBSITE}</th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<td class="catbottom" colspan="8" align="center"><form name="post" method="post" action="{S_ACTION}" style="padding: 0; margin: 0; border: none;">{S_HIDDEN_FIELDS}<span class="genmed">
			{L_SORT}:&nbsp;<select name="sort">
				<!-- BEGIN sort -->
				<option value="{block.members.sort.VALUE}"{block.members.sort.S_SELECTED}>{block.members.sort.L_OPTION}</option>
				<!-- END sort -->
			</select>&nbsp;<select name="order">
				<!-- BEGIN order -->
				<option value="{block.members.order.VALUE}"{block.members.order.S_SELECTED}>{block.members.order.L_OPTION}</option>
				<!-- END order -->
			</select>&nbsp;<input type="submit" name="submit" value="{L_GO}" class="liteoption" />
		</span></form></td>
	</tr>
	</tfoot>
	<tbody>
	<!-- BEGIN row -->
	<tr>
		<!-- BEGIN light -->
		<td class="row1" align="center">
		<!-- END light -->
		<!-- BEGIN light_ELSE -->
		<td class="row2" align="center">
		<!-- END light_ELSE -->
			<span class="gen">&nbsp;{block.members.row.ROW_NUMBER}&nbsp;</span>
		</td>
		<!-- BEGIN light -->
		<td class="row1" align="center">
		<!-- END light -->
		<!-- BEGIN light_ELSE -->
		<td class="row2" align="center">
		<!-- END light_ELSE -->
			<span class="gen"><a href="{block.members.row.U_VIEWPROFILE}" class="gen">{block.members.row.USERNAME}</a>
		</span></td>
		<!-- BEGIN light -->
		<td class="row1" align="center">
		<!-- END light -->
		<!-- BEGIN light_ELSE -->
		<td class="row2" align="center">
		<!-- END light_ELSE -->
			&nbsp;{block.members.row.PM_IMG}&nbsp;
		</td>
		<!-- BEGIN light -->
		<td class="row1" align="center" valign="middle">
		<!-- END light -->
		<!-- BEGIN light_ELSE -->
		<td class="row2" align="center" valign="middle">
		<!-- END light_ELSE -->
			&nbsp;{block.members.row.EMAIL_IMG}&nbsp;
		</td>
		<!-- BEGIN light -->
		<td class="row1" align="center" valign="middle">
		<!-- END light -->
		<!-- BEGIN light_ELSE -->
		<td class="row2" align="center" valign="middle">
		<!-- END light_ELSE -->
			<span class="gen">{block.members.row.FROM}</span>
		</td>
		<!-- BEGIN light -->
		<td class="row1" align="center" valign="middle">
		<!-- END light -->
		<!-- BEGIN light_ELSE -->
		<td class="row2" align="center" valign="middle">
		<!-- END light_ELSE -->
			<span class="gensmall">{block.members.row.JOINED}</span>
		</td>
		<!-- BEGIN light -->
		<td class="row1" align="center" valign="middle">
		<!-- END light -->
		<!-- BEGIN light_ELSE -->
		<td class="row2" align="center" valign="middle">
		<!-- END light_ELSE -->
			<span class="gen">{block.members.row.POSTS}</span>
		</td>
		<!-- BEGIN light -->
		<td class="row1" align="center">
		<!-- END light -->
		<!-- BEGIN light_ELSE -->
		<td class="row2" align="center">
		<!-- END light_ELSE -->
			&nbsp;{block.members.row.WWW_IMG}&nbsp;
		</td>
	</tr>
	<!-- END row -->
	<!-- BEGIN row_ELSE -->
	<tr>
		<td class="row1" colspan="8" align="center"><span class="gen"><br />{L_EMPTY_USERS}</br /></br /></span></td>
	</tr>
	<!-- END row_ELSE -->
	</tbody>
	</table></td>
</tr>
<tr>
	<!-- END members -->

	<!-- END block -->
</tr>
</tbody>
</table>