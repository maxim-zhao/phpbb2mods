<script language="JavaScript" type="text/javascript" src="{S_ROOT}includes/js_dom_branch.js"></script>

<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<form action="{S_ACTION}" method="post" name="post"><table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
<colgroup>
	<col width="40%">
	<col width="60%">
</colgroup>
<tr>
	<th class="thHead" colspan="2">&nbsp;{L_PARMS}</th>
</tr>
{FORM}
<tr>
	<td class="catBottom" colspan="2" align="center"><span class="gensmall">
		<input type="image" name="submit_form" src="{I_SUBMIT}" border="0" title="{L_SUBMIT}" alt="{L_SUBMIT}" />
	</span></td>
</tr>
</table>
<br class="nav" />

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thCornerL" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
	<th class="thTop" height="25" nowrap="nowrap" width="100%">&nbsp;{L_PANELS}&nbsp;</th>
</tr>
<tr>
	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td height="25" align="center" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><span class="gensmall">&nbsp;
			<!-- BEGIN command --><input type="checkbox" name="item_ids[]" value="{row.ITEM_ID}" onclick="branch.set({row.ITEM_ID}, {row.LAST_CHILD_ID});" />&nbsp;<!-- END command -->
		</span></td>
	</tr>
	<!-- END row -->
	</table></td>

	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="25">
			<table cellpadding="0" cellspacing="0" width="100%"><tr>
			<td><img src="{I_SPACER}" border="0" width="4" alt="" /></td>
			<!-- BEGIN inc --><td><img src="{row.inc.I_INC}" border="0" alt="" /></td><!-- END inc -->
			<td width="100%" nowrap="nowrap"><span class="forumlink">
				<!-- BEGIN panel_ELSE -->&nbsp;&raquo;<!-- END panel_ELSE -->&nbsp;{row.ITEM_NAME}<!-- BEGIN desc -->:&nbsp;{row.ITEM_DESC}<!-- END desc -->
			</span></td>
			</tr></table>
		</td>
	</tr>
	<!-- END row -->
	</table></td>
</tr>
<!-- BEGIN empty -->
<tr>
	<td class="row1" colspan="2" align="center" height="30"><span class="gen">{L_EMPTY}
	</span></td>
</tr>
<!-- END empty -->
<tr>
	<td class="catBottom" colspan="2" align="center" valign="middle">{S_HIDDEN_FIELDS}<span class="gensmall">
		<input type="image" name="submit_form" src="{I_SUBMIT}" border="0" title="{L_SUBMIT}" alt="{L_SUBMIT}" />
	</span></td>
</tr>
</table></form>
<br clear="all" />

<script language="JavaScript" type="text/javascript">
<!--
branch = new _dom_branch('item_ids');
//-->
</script>