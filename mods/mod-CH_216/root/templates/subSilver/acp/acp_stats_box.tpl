
<!-- BEGIN userform -->
<table cellpadding="4" cellspacing="1" border="0" width="100%" class="forumline">
<colgroup>
	<col width="40%">
	<col width="60%">
</colgroup>
<tr>
	<th colspan="2" class="thHead">{L_FORM}</th>
</tr>
<tr>
	<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
	<td class="row2"><span class="gen">
		<input type="text" class="post" name="username" value="{USERNAME}" maxlength="50" size="20" />&nbsp;<input type="image" src="{I_SEARCH_USER}" name="searchuser" alt="{L_FIND_USERNAME}" align="top" onclick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" />
	</span></td>
</tr>
<tr>
	<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<span class="genmed">&nbsp;
		<input type="image" src="{I_LOOK_UP}" name="submituser" alt="{L_LOOK_UP}" />&nbsp;
	</span></td>
</tr>
</table>
<br style="font-size: 2px" />
<!-- END userform -->

<table cellpadding="4" cellspacing="1" border="0" class="forumline" align="center" width="100%">
<tr>
	<th colspan="2" nowrap="nowrap" class="thCornerL">&nbsp;{L_FORM}&nbsp;</th>
	<!-- BEGIN data -->
	<th nowrap="nowrap" class="thTop">&nbsp;{data.L_TOTAL}&nbsp;</th>
	<!-- END data -->
	<th nowrap="nowrap" class="thCornerR">&nbsp;{L_TOTAL}&nbsp;</th>
</tr>
<!-- BEGIN row -->
<tr>
	<td class="row1" nowrap="nowrap">
		<span class="gen"><!-- BEGIN link --><a href="{row.U_LEGEND}" class="gen"><!-- END link -->{row.LEGEND}<!-- BEGIN link --></a><!-- END link --></span>
	</td>
	<td class="row1" valign="middle" width="100%">
	<!-- BEGIN data -->
		<!-- BEGIN left -->
		<table cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td><img src="{row.data.I_LEFT}" width="4" alt="" height="12" /></td>
		<!-- END left -->
		<!-- BEGIN middle -->
			<td><img src="{row.data.I_MIDDLE}" width="{row.data.S_WIDTH}" height="12" alt="{row.data.PERCENT}" /></td>
		<!-- END middle -->
		<!-- BEGIN right -->
			<td><img src="{row.data.I_RIGHT}" width="4" alt="" height="12" /></td>
		</tr>
		</table>
		<!-- END right -->
	<!-- END data -->
	</td>
	<!-- BEGIN data -->
	<td class="row2"<!-- BEGIN title --> valign="bottom"<!-- END title -->>
		<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
			<!-- BEGIN extra --><td><a href="{row.data.U_EXTRA}" title="{L_EXTRA}"><img src="{I_EXTRA}" border="0" alt="{L_EXTRA}" /></a></td><!-- END extra -->
			<td><span class="gensmall">{row.data.PERCENT}&nbsp;</span></td>
			<td align="right"><span class="gen"><b>&nbsp;{row.data.TOTAL}</b></span></td>
		</tr>
		<!-- BEGIN title -->
		<tr>
			<td colspan="<!-- BEGIN extra -->3<!-- BEGINELSE extra -->2<!-- END extra -->"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
				<td><img src="{row.data.I_LEFT}" width="4" alt="" height="12" /></td>
				<td width="100%"><img src="{row.data.I_MIDDLE}" width="100%" alt="" height="12" /></td>
				<td><img src="{row.data.I_RIGHT}" width="4" alt="" height="12" /></td>
			</tr></table></td>
		</tr>
		<!-- END title -->
		</table>
	</td>
	<!-- END data -->
	<td class="row1"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
		<td><span class="gensmall">{row.PERCENT}&nbsp;</span></td>
		<td align="right"><span class="gen"><b>&nbsp;{row.TOTAL}</b></span></td>
	</tr></table></td>
</tr>
<!-- BEGIN title -->
<tr>
	<td class="spaceRow" colspan="{SPAN_ALL}"><img src="{I_SPACER}" alt="" border="0" height="1" /></td>
</tr>
<!-- END title -->
<!-- END row -->
<!-- BEGIN users -->
<tr>
	<td class="row1" colspan="{SPAN_ALL}"><span class="genmed">
		<!-- BEGIN connected --><!-- BEGIN first --><!-- BEGINELSE first -->, <!-- END first --><!-- BEGIN link --><a href="{users.connected.U_USERNAME}" title="{L_PROFILE_VISIT}" class="genmed"{users.connected.STYLE}><!-- BEGINELSE link --><b{users.connected.STYLE}><!-- END link -->{users.connected.USERNAME}<!-- BEGIN link --></a><!-- BEGINELSE link --></b><!-- END link -->&nbsp;({users.connected.USER_VISIT})<!-- BEGINELSE connected -->{L_NO_CONNECTED}<!-- END connected -->
	</span></td>
</tr>
<!-- END users -->
<tr>
	<td class="catBottom" colspan="{SPAN_ALL}" align="center"><span class="gensmall">&nbsp;
		<!-- BEGIN buttons --><a href="{buttons.U_BUTTON}" title="{buttons.L_BUTTON}" accesskey="{buttons.S_BUTTON}"><img src="{buttons.I_BUTTON}" border="0" alt="{buttons.L_BUTTON}" /></a>&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>

<br clear="all" />