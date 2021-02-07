
<script language="javascript" type="text/javascript">
function handleClick() {
	var obj = "";

	// Check browser compatibility
	if(document.getElementById)
		obj = document.getElementById('debug');
	else if(document.all)
		obj = document.all['debug'];
	else if(document.layers)
		obj = document.layers['debug'];
	else
		return 1;

	if (!obj)
		return 1;
	else if (obj.style)
		obj.style.display = ( obj.style.display != "none" ) ? "none" : "";
	else
		obj.visibility = "show";
}
</script>

<h1>{L_TITLE}</h1>

<p>{L_DESC}</p>

<p>{L_RETURN}</p>

<br />

<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
  		<th class="thHead">{L_TEST}</th>
	</tr>
	<tr>
		<td class="row1"><br />{TEST}<br />&nbsp;</td>
	</tr>
</table>
	
<br />

<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead"><span onclick="handleClick()" style="cursor: pointer">{L_DEBUG}</span></th>
		<tr id="debug" style="display: {S_DEBUG_DISPLAY}">
			<td class="row1">
			  <!-- BEGIN http_debug -->
			  <b>{http_debug.L_HTTP_QUERY_1}</b><br />
			  <blockquote>{http_debug.S_HTTP_QUERY_1}</blockquote>
			  <b>{http_debug.L_HTTP_QUERY_2}</b><br />
			  <blockquote>{http_debug.S_HTTP_QUERY_2}</blockquote>
			  <b>{http_debug.L_SQL_QUERY}</b><br />
			  <blockquote>{http_debug.S_SQL_QUERY}</blockquote>
			  <b>{L_ELAPSED_TIME}:</b> {S_ELAPSED_TIME}
			  <!-- END http_debug -->
			</td>
		</tr>
	</tr>
</table>

<br clear="all" />
