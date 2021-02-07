
<h1>{L_TITLE}</h1>

<p>{L_DESC}</p>

<br />

<form action="{S_TEST_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
  		<th class="thHead" colspan="2">{L_TEST}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_TEST_DESC}</span></td>
	</tr>
	<tr>
		<td class="row1" width="40%">{L_IP}</td>
		<td class="row2"><input class="post" type="text" size="15" maxlength="15" name="address" value="{U_IP}" onclick="document.forms[0].address.value = ''" /> <input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
	</tr>
</table>
</form>
	
<br />

<form action="{S_CONFIG_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" colspan="2">{L_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_PROXY_ENABLE}<br /><span class="gensmall">{L_PROXY_ENABLE_DESC}</span></td>
		<td class="row2"><input type="radio" name="proxy_enable" value="{ENABLE_VALUE}" {ENABLE} />{L_ENABLED}&nbsp; &nbsp;<input type="radio" name="proxy_enable" value="{DISABLE_VALUE}" {DISABLE} />{L_DISABLED}</td>
	</tr>
	<tr>
		<td class="row1">{L_BAN}<br /><span class="gensmall">{L_BAN_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="proxy_ban" value="1" {BAN_YES} />{L_YES}&nbsp; &nbsp;<input type="radio" name="proxy_ban" value="0" {BAN_NO} />{L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_USER_AGENT}<br /><span class="gensmall">{L_USER_AGENT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="proxy_user_agent" value="{USER_AGENT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_CACHE_TIME}<br /><span class="gensmall">{L_CACHE_TIME_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="4" maxlength="4" name="proxy_cache_time" value="{CACHE_TIME}" /> {SELECT_UNIT}</td>
	</tr>
	<tr>
		<td class="row1">{L_TIMEOUT}<br /><span class="gensmall">{L_TIMEOUT_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" size="2" maxlength="2" name="proxy_delay" value="{TIMEOUT}" /> {L_SECONDS}</td>
	</tr>
	<tr>
		<td class="row1">{L_PORTS}<br /><span class="gensmall">{L_PORTS_EXPLAIN}</span></td>
		<td class="row2"><textarea name="proxy_ports" rows="5" cols="30">{PORTS}</textarea></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
</form>

<br />

<form action="{S_LIST_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th height="25" class="thCornerL" nowrap="nowrap">#</th>
		<th class="thTop" nowrap="nowrap">&nbsp;</th>
		<th class="thTop" nowrap="nowrap">{L_IP}</th>
		<th class="thTop" nowrap="nowrap">{L_PORT}</th>
		<th class="thTop" nowrap="nowrap">{L_TYPE}</th>
		<th class="thCornerR" nowrap="nowrap">{L_LAST_CHECKED}</th>
	</tr>
	<tr>
		<td class="row2" colspan="6"><span class="gensmall">{L_LIST_DESC}</span></td>
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
		<td class="catBottom" colspan="6" height="28" align="center"><input type="submit" name="submit" value="{L_VIEW_LIST}" class="mainoption" /></td>
	</tr>

</table>
</form>

<br clear="all" />