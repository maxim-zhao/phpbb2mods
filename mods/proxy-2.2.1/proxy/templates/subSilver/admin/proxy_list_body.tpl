
<h1>{L_TITLE}</h1>

<p>{L_DESC}</p>

<p>{L_RETURN}</p>

<br />

<form action="{S_LIST_ACTION}" method="post">
<table width="100%" cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td width="100%">&nbsp;</td>
		<td align="right" nowrap="nowrap"><span class="gen">{L_SORT_BY}</td>
		<td nowrap="nowrap"><select name="sort" class="post">
			<option value="last_checked"{S_LAST_CHECKED}>{L_LAST_CHECKED}</option>
			<option value="port"{S_PORT}>{L_PORT}</option>
			<option value="status"{S_STATUS}>{L_TYPE}</option>
			<option value="ip_address"{S_IP}>{L_IP}</option>
		</select></td>
		<td nowrap="nowrap"><select name="order" class="post">
			<option value="ASC"{S_ASC}>{L_ASCENDING}</option>
			<option value="DESC"{S_DESC}>{L_DESCENDING}</option>
		</select></td>
		<td nowrap="nowrap"><span class="gen">{L_SHOW}</span></td>
		<td nowrap="nowrap"><input type="text" size="5" value="{S_SHOW}" name="show" /></td>
		<td nowrap="nowrap">{S_HIDDEN_FIELDS}<input type="submit" value="{S_SORT}" name="change_sort" class="liteoption" /></td>
	</tr>
</table>
</form>

<form action="{S_DOWNLOAD_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th height="25" class="thCornerL" nowrap="nowrap">#</th>
		<th class="thTop" nowrap="nowrap">&nbsp;</th>
		<th class="thTop" nowrap="nowrap">{L_IP}</th>
		<th class="thTop" nowrap="nowrap">{L_PORT}</th>
		<th class="thTop" nowrap="nowrap">{L_TYPE}</th>
		<th class="thCornerR" nowrap="nowrap">{L_LAST_CHECKED}</th>
	</tr>
	<!-- BEGIN proxyrow -->
	<tr>
		<td class="{proxyrow.ROW_CLASS}" align="center"><span class="gen">&nbsp;{proxyrow.ROW_NUMBER}&nbsp;</span></td>
		<td class="{proxyrow.ROW_CLASS}" align="center">&nbsp;<a href="{proxyrow.U_CHECKPROXY}" class="gen">{L_CHECK}</a> - <a href="{proxyrow.U_DELPROXY}" class="gen">{L_DELETE}</a>&nbsp;</td>
		<td class="{proxyrow.ROW_CLASS}" align="center"><a href="{proxyrow.IP_LINK}" class="gen">{proxyrow.IP_ADDRESS}</a></td>
		<td class="{proxyrow.ROW_CLASS}" align="center">&nbsp;{proxyrow.PORT}&nbsp;</td>
		<td class="{proxyrow.ROW_CLASS}" align="center"><span class="gen">{proxyrow.TYPE}</span></td>
		<td class="{proxyrow.ROW_CLASS}" align="center"><span class="gensmall">{proxyrow.DATE}</span></td>
	</tr>
	<!-- END proxyrow -->
	<tr>
		<td class="catBottom" colspan="6" height="28" align="center"><input type="submit" name="submit" value="{L_DOWNLOAD}" class="mainoption" /></td>
	</tr>
</table>
</form>

<table width="100%" cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td align="left" width="50%"><span class="gen">{PAGE_NUMBER}</span></td>
		<td align="right" width="50%"><span class="gen">{PAGINATION}</span></td>
	</tr>
</table>

<br clear="all" />