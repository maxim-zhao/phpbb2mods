<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<!-- BEGIN warning -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
<tr>
	<th class="thHead">{warning.WARNING_TITLE}</th>
</tr>
<tr>
	<td class="row1" align="center"><span class="gen"><br />{warning.WARNING_MSG}<br /><br /></span></td>
</tr>
</table>
<br class="nav" />
<!-- END warning -->

<form method="post" action="{S_ACTION}" name="post">
<table cellspacing="1" cellpadding="4" border="0" width="100%" align="center" class="forumline">
<tr>
	<th class="thHead" align="center" colspan="2">{L_FORM}</th>
</tr>
{FORM}
<tr>
	<td class="catBottom" align="center" colspan="2"><span class="gensmall">
		<input type="image" name="SELECT" src="{I_SELECT}" alt="{L_SELECT}" title="{L_SELECT}" />
	</span></td>
</tr>
</table>
<br class="nav" />

<table cellspacing="1" cellpadding="4" border="0" width="100%" align="center" class="forumline">
<tr>
	<!-- BEGIN empty -->
	<th class="thHead" align="center">{L_AUTHS}</th>
	<!-- BEGINELSE empty -->
	<th class="thCornerL" align="center" colspan="2">{L_AUTHS}</th>
	<th class="thCornerR" align="center">{L_ACTION}</th>
	<!-- END empty -->
</tr>
<!-- BEGIN row -->
<tr>
	<!-- BEGIN title -->
	<td class="row3" nowrap="nowrap" colspan="2"><span class="genmed">
		<a href="{row.U_EDIT}" class="forumlink" title="{L_EDIT}"><b>{row.AUTH_NAME}</b></a>:&nbsp;{row.AUTH_DESC}
	</span></td>
	<!-- END title -->
	<!-- BEGIN light -->
	<td class="row1" nowrap="nowrap"><span class="forumlink">
		<a href="{row.U_EDIT}" class="forumlink" title="{L_EDIT}">{row.AUTH_NAME}</a>
	</span></td>
	<!-- END light -->
	<!-- BEGIN light_ELSE -->
	<td class="row2" nowrap="nowrap"><span class="forumlink">
		<a href="{row.U_EDIT}" class="forumlink" title="{L_EDIT}">{row.AUTH_NAME}</a>
	</span></td>
	<!-- END light_ELSE -->

	<!-- BEGIN light -->
	<td class="row1" width="100%"><span class="gen">{row.AUTH_DESC}
	</span></td>
	<!-- END light -->
	<!-- BEGIN light_ELSE -->
	<td class="row2" width="100%"><span class="gen">{row.AUTH_DESC}
	</span></td>
	<!-- END light_ELSE -->

	<!-- BEGIN title -->
	<td class="row3" align="center" nowrap="nowrap">
	<!-- END title -->
	<!-- BEGIN light -->
	<td class="row1" align="center" nowrap="nowrap">
	<!-- END light -->
	<!-- BEGIN light_ELSE -->
	<td class="row2" align="center" nowrap="nowrap">
	<!-- END light_ELSE -->
	<span class="gen">&nbsp;
		<a href="{row.U_MOVEUP}" class="gensmall" title="{L_MOVEUP}"><img src="{I_MOVEUP}" alt="{L_MOVEUP}" border="0" /></a>
		<a href="{row.U_EDIT}" class="gensmall" title="{L_EDIT}"><img src="{I_EDIT}" alt="{L_EDIT}" border="0" /></a>
		<a href="{row.U_DELETE}" class="gensmall" title="{L_DELETE}"><img src="{I_DELETE}" alt="{L_DELETE}" border="0" /></a>
		<a href="{row.U_MOVEDW}" class="gensmall" title="{L_MOVEDW}"><img src="{I_MOVEDW}" alt="{L_MOVEDW}" border="0" /></a>
	&nbsp;</span></td>
</tr>
<!-- END row -->
<!-- BEGIN empty -->
<tr>
	<td class="row1" height="35" align="center"><span class="gen">
		{L_EMPTY}
	</span></td>
</tr>
<!-- END empty -->
<tr>
	<td class="catBottom" align="center" <!-- BEGIN empty_ELSE -->colspan="3"<!-- END empty_ELSE -->>{S_HIDDEN_FIELDS}<span class="gensmall">&nbsp;
		<!-- BEGIN buttons --><input type="image" name="{buttons.BUTTON}" src="{buttons.I_BUTTON}" alt="{buttons.L_BUTTON}" title="{buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>

</form>

<br clear="all" />
