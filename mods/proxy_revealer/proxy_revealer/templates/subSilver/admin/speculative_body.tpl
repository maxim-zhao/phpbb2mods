
<h1>{L_SPECULATIVE}</h1>

<p>{L_SPECULATIVE_DESC}</p>

<br />

<table width="100%" cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td width="100%">
			<form action="{S_LIST_ACTION}" method="post">
			<span class="gen">{L_SEARCH_FOR}</span>
			<input class="post" type="text" size="15" maxlength="15" value="{SEARCH}" name="ip" />
			<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />
			</form>
		</td>
		<td align="right" nowrap="nowrap">
			<form action="{S_LIST_ACTION}" method="post">
			<span class="gen">{L_SORT_BY}</span>
			<select name="order" class="post">
				<option value="ASC"{S_ASC}>{L_LEAST_RECENTLY}</option>
				<option value="DESC"{S_DESC}>{L_MOST_RECENTLY}</option>
			</select>
			<span class="gen">{L_SHOW}</span>
			<input type="text" size="5" value="{S_SHOW}" name="show" />
			<input type="submit" value="{S_SORT}" name="change_sort" class="liteoption" />
			</form>
		</td>
	</tr>
</table>

<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th height="25" class="thCornerL" nowrap="nowrap">{L_SPOOFED}</th>
		<th class="thTop" nowrap="nowrap">{L_METHOD}</th>
		<th class="thTop" nowrap="nowrap">{L_REAL}</th>
		<th class="thCornerR" nowrap="nowrap">{L_DATE}</th>
	</tr>
	<tr>
		<td class="row2" align="center"><span class="gensmall">&nbsp;</span></td>
		<td class="row2" align="center"><span class="gensmall">{L_METHOD_DESC}</span></td>
		<td class="row2" align="center"><span class="gensmall">{L_REAL_DESC}</span></td>
		<td class="row2" align="center"><span class="gensmall">&nbsp;</span></td>
	</tr>
	<!-- BEGIN speculativerow -->
	<tr>
		<td class="{speculativerow.ROW_CLASS}" align="center"><span class="gen"><a href="{speculativerow.SPOOFED_LINK}">{speculativerow.SPOOFED_IP}</a></span></td>
		<td class="{speculativerow.ROW_CLASS}" align="center"><span class="gen">{speculativerow.METHOD}</span></td>
		<td class="{speculativerow.ROW_CLASS}" align="center"><span class="gen">{speculativerow.REAL_IP}</span></td>
		<td class="{speculativerow.ROW_CLASS}" align="center"><span class="gen">{speculativerow.DATE}</span></td>
	</tr>
	<!-- END speculativerow -->
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td align="left" width="50%"><span class="gen">{PAGE_NUMBER}</span></td>
		<td align="right" width="50%"><span class="gen">{PAGINATION}</span></td>
	</tr>
</table>

<br clear="all" />