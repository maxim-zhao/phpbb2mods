<h1>{L_IMPORT_TITLE}</h1>

<p>{L_IMPORT_EXPLAIN}</p>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thTop">{L_USERNAME}</td>
		<th class="thTop">{L_EMAIL}</td>
		<th class="thTop">{L_PASSWORD}</td>
	</tr>
	<tr>
		<td class="row1">Admin</td>
		<td class="row2">admin@domain.tld</td>
		<td class="row1">abc123def</td>
	</tr>
</table>

<br />

<form method="post" action="{S_FORM_ACTION}">
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thTop" colspan="2">{L_IMPORT_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">
			{L_PASSWORD_FORMAT}:<br /><span class="gensmall">{L_PASSWORD_FORMAT_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="radio" name="password_format" value="plain" selected="selected" />{L_PLAIN} <input type="radio" name="password_format" value="md5" />{L_MD5}
		</td>
	</tr>
	<tr>
		<td class="row1">
			{L_IMPORT_RATE}:<br /><span class="gensmall">{L_IMPORT_RATE_EXPLAIN}</span>
		</td>
		<td class="row2">
			{IMPORT_RATE_SELECT}
		</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_START_IMPORT}" class="mainoption" /></td>
	</tr>
</table>
</form>
<br />