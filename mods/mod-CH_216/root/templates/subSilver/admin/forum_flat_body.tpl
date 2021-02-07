<script language="JavaScript" type="text/javascript" src="{S_ROOT}includes/js_dom_branch.js"></script>

<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

<form action="{S_ACTION}" method="post" name="post">
<table cellspacing="0" cellpadding="2" border="0" align="center" width="100%">
<tr> 
	<td align="left" valign="bottom" width="100%"><span class="nav">&nbsp;
	</span></td>
	<td valign="bottom" align="right" nowrap="nowrap"><span class="gensmall">
		<a href="{U_CHANGE_VIEW}" title="{L_CHANGE_VIEW}" class="gensmall">{L_CHANGE_VIEW}</a>
	</span></td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thCornerL" height="25" nowrap="nowrap" width="100%">&nbsp;{L_FORUM}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_PROPAG_VAR}&nbsp;</th>
	<th class="thCornerR" nowrap="nowrap" width="140">&nbsp;{L_ACTION}&nbsp;</th>
</tr>
<tr>
	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="25">
			<table cellpadding="0" cellspacing="0" width="100%"><tr>
			<td><img src="{I_SPACER}" border="0" width="4" alt="" /></td>
			<!-- BEGIN inc --><td><img src="{row.inc.I_INC}" border="0" alt="" /></td><!-- END inc -->
			<td width="100%" nowrap="nowrap"><span class="forumlink"><!-- BEGIN root_ELSE -->&nbsp;<!-- END root_ELSE -->
				<!-- BEGIN edit --><a href="{row.U_EDIT}" class="forumlink" title="{row.FORUM_DESC}"><!-- END edit -->{row.FORUM_NAME}<!-- BEGIN edit --></a><!-- END edit -->&nbsp;
				<!-- BEGIN root_ELSE -->[<img src="{row.I_FORUM_FOLDER}" title="{row.L_FORUM_FOLDER}" alt="" border="0" class="absbottom" />]<!-- END root_ELSE -->
			</span></td>
			</tr></table>
		</td>
	</tr>
	<!-- END row -->
	</table></td>

	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center" height="25" nowrap="nowrap"><span class="gensmall">&nbsp;
			<!-- BEGIN show_propag -->
			<a href="javascript:branch.set({row.FORUM_ID}, {row.LAST_CHILD_ID});" title="{L_COPY}"><img src="{I_COPY}" border="0" align="top" alt="{L_COPY}" /></a>&nbsp;<select name="{PROPAG_VAR}[{row.FORUM_ID}]">{row.S_PROPAG_VAR}</select>&nbsp;
			<!-- BEGINELSE show_propag -->
			<input type="hidden" name="{PROPAG_VAR}[{row.FORUM_ID}]" value="" />
			<!-- END show_propag -->
		</span></td>
	</tr>
	<!-- END row -->
	</table></td>

	<td><table cellpadding="0" cellspacing="0" border="0" width="100%">
	<!-- BEGIN row -->
	<tr>
		<td align="center" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="25" nowrap="nowrap"><span class="gensmall">&nbsp;<!-- BEGIN command -->
			<!-- BEGIN root_ELSE --><a href="{row.U_MOVE_UP}" title="{L_MOVE_UP}"><img src="{I_MOVE_UP}" border="0" alt="{L_MOVE_UP}" /></a>&nbsp;<!-- END root_ELSE --><a href="{row.U_EDIT}" title="{L_EDIT}"><img src="{I_EDIT}" border="0" alt="{L_EDIT}" /></a>&nbsp;<a href="{row.U_CREATE}" title="{L_CREATE}"><img src="{I_CREATE}" border="0" alt="{L_CREATE}" /></a>&nbsp;<!-- BEGIN root_ELSE --><a href="{row.U_DELETE}" title="{L_DELETE}"><img src="{I_DELETE}" border="0" alt="{L_DELETE}" /></a>&nbsp;<!-- END root_ELSE --><a href="{row.U_SYNCHRO}" title="{L_SYNCHRO}"><img src="{I_SYNCHRO}" border="0" alt="{L_SYNCHRO}" /></a>&nbsp;<!-- BEGIN root_ELSE --><a href="{row.U_MOVE_DOWN}" title="{L_MOVE_DOWN}"><img src="{I_MOVE_DOWN}" border="0" alt="{L_MOVE_DOWN}" /></a>&nbsp;<!-- END root_ELSE -->
		<!-- END command --></span></td>
	</tr>
	<!-- END row -->
	</table></td>
</tr>
<tr>
	<td class="catBottom" colspan="3" align="center" valign="middle">{S_HIDDEN_FIELDS}<span class="gensmall">&nbsp;
		<!-- BEGIN buttons --><input type="image" name="{buttons.BUTTON}" src="{buttons.I_BUTTON}" alt="{buttons.L_BUTTON}" title="{buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>

<table cellspacing="0" cellpadding="2" border="0" align="center" width="100%">
<tr> 
	<td align="left" valign="bottom" width="100%"><span class="nav">&nbsp;
	</span></td>
	<td valign="bottom" align="right" nowrap="nowrap"><span class="gensmall">
		<a href="{U_CHANGE_VIEW}" title="{L_CHANGE_VIEW}" class="gensmall">{L_CHANGE_VIEW}</a>
	</span></td>
</tr>
</table>
</form>

<br clear="all" />

<script language="JavaScript" type="text/javascript">
<!--
branch = new _dom_branch('{PROPAG_VAR}');
//-->
</script>