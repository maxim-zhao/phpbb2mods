
<h1>{L_TITLE}</h1>

<p>{L_DESC}</p>

<p>{L_RETURN}</p>

<br />

<form action="{S_CONFIG_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_CONFIG}</th>
	</tr>
	<tr>
		<td class="row1">{L_CHECK_DNSBLS}<br /><span class="gensmall">{L_CHECK_DNSBLS_DESC}</span></td>
		<td class="row2"><input type="radio" name="proxy_dnsbls" value="1" {S_DNSBLS_YES} />{L_YES}&nbsp; &nbsp;<input type="radio" name="proxy_dnsbls" value="0" {S_DNSBLS_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_IP_LINK}<br /><span class="gensmall">{L_IP_LINK_DESC}</span></td>
		<td class="row2"><input class=""post" type="text" size="40" maxlength="255" name="ip_link" value="{S_IP_LINK}" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</form>

<br />

<form action="{S_DNSBL_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th height="25" class="thCornerL" nowrap="nowrap">#</th>
		<th class="thTop" nowrap="nowrap">&nbsp;</th>
		<th class="thTop" nowrap="nowrap">{L_DNSBL_DOMAIN}</th>
		<th class="thCornerR" nowrap="nowrap">{L_DNSBL_LINK}</th>
	</tr>
	<tr>
		<td class="row2" colspan="4"><span class="gensmall">{L_DNSBL_DESC}</span></td>
	</tr>
	<!-- BEGIN dnsbl_row -->
	<tr>
		<td class="{dnsbl_row.ROW_CLASS}" align="center"><span class="gen">&nbsp;{dnsbl_row.ROW_NUMBER}&nbsp;</span></td>
		<td class="{dnsbl_row.ROW_CLASS}" align="center"><span class="gen"><a href="{dnsbl_row.U_DELETE}">{L_DELETE}</a></span></td>
		<td class="{dnsbl_row.ROW_CLASS}" align="center">{dnsbl_row.U_DOMAIN}</td>
		<td class="{dnsbl_row.ROW_CLASS}" align="center">{dnsbl_row.U_LINK}</td>
	</tr>
	<!-- END dnsbl_row -->
	<tr>
		<td class="{ROW_CLASS}" align="center"><span class="gen">&nbsp;{ROW_NUMBER}&nbsp;</span></td>
		<td class="{ROW_CLASS}" align="center"><span class="gen">{L_ADD}</span></td>
		<td class="{ROW_CLASS}" align="center"><input class=""post" type="text" size="25" maxlength="255" name="domain" /></td>
		<td class="{ROW_CLASS}" align="center"><input class=""post" type="text" size="40" maxlength="255" name="url" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="4" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>

<br clear="all" />