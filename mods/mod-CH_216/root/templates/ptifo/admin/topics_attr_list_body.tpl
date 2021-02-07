
<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center" width="100%">
<tr>
	<th class="thCornerL" nowrap="nowrap">&nbsp;{L_NAME}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_FOLDER}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_FRONT}&nbsp;</th>
	<th class="thCornerR" width="100">&nbsp;{L_ACTION}&nbsp;</th>
</tr>
<!-- BEGIN row -->
<tr>
	<td height="45" class="row1" nowrap="nowrap"><span class="forumlink">
		<!-- BEGIN command --><a href="{row.U_NAME}" class="forumlink"><!-- END command -->{row.L_NAME}<!-- BEGIN command --></a><!-- END command -->
	</span><span class="gensmall">
		<!-- BEGIN cond --><br />{row.L_COND}<!-- END cond -->
		<!-- BEGIN auth --><br />{row.L_AUTH}<!-- END auth -->
	</span></td>
	<td class="row1">
		<!-- BEGIN fname --><span class="gen">{row.L_FNAME}<br /></span><!-- END fname -->
		<!-- BEGIN sub --><!-- BEGIN img --><img src="{row.sub.I_FOLDER}" alt="{row.sub.L_FOLDER}" border="0" hspace="2" /><!-- END img --><!-- END sub -->
	</td>
	<td class="row1" nowrap="nowrap">
		<!-- BEGIN ttxt --><span class="forumlink">[{row.L_TNAME}]&nbsp;</span><!-- END ttxt -->
		<!-- BEGIN timg --><img src="{row.I_TAG}" alt="{row.L_TAG}" border="0" align="top" /><!-- BEGINELSE timg --><span class="gensmall">{row.L_TAG}&nbsp;</span><!-- END timg -->
	</td>
	<td class="row3Right" align="center" nowrap="nowrap"><!-- BEGIN command -->
		<table cellpadding="0" cellspacing="1" border="0">
		<tr>
			<td><a href="{row.U_MOVE_UP}" title="{L_MOVE_UP}"><img src="{I_MOVE_UP}" alt="{L_MOVE_UP}" border="0" /></a></td>
			<td><a href="{row.U_EDIT}" title="{L_EDIT}"><img src="{I_EDIT}" alt="{L_EDIT}" border="0" /></a></td>
		</tr>
		<tr>
			<td><a href="{row.U_MOVE_DOWN}" title="{L_MOVE_DOWN}"><img src="{I_MOVE_DOWN}" alt="{L_MOVE_DOWN}" border="0" /></a></td>
			<td><a href="{row.U_DELETE}" title="{L_DELETE}"><img src="{I_DELETE}" alt="{L_DELETE}" border="0" /></a></td>
		</tr>
		</table>
	<!-- END command --></td>
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
