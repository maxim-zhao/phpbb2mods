<!-- Select All/Deselect All JS borrowed from privmsgs_body.tpl -->
<script language="Javascript" type="text/javascript">
	//
	// Should really check the browser to stop this whining ...
	//
	function select_switch(status)
	{
		for (i = 0; i < document.log_list.length; i++)
		{
			document.log_list.elements[i].checked = status;
		}
	}
</script>

<h1>{L_VERSION_LOG}</h1>
<p>{L_VERSION_LOG_EXPLAIN}</p>
<form action="{S_VERSION_ACTION}" name="log_list" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
        <th width="5%">&nbsp;</th>
        <th width="25%">{L_TIME}</th>
        <th width="20%">{L_MOD_NAME}</th>
        <th width="49%">{L_LOG_MESSAGE}</th>
	</tr>
	<!-- BEGIN version_log_loop -->
	<tr>
		<td class="{version_log_loop.ROW_CLASS}"><input type="checkbox" name="delete_{version_log_loop.LOG_ID}" value="delete" /></td>
		<td class="{version_log_loop.ROW_CLASS}">{version_log_loop.LOG_TIMESTAMP}</td>
		<td class="{version_log_loop.ROW_CLASS}">{version_log_loop.L_MOD_NAME}</td>
		<td class="{version_log_loop.ROW_CLASS}">{version_log_loop.L_LOG_MSG}</td>
	</tr>
	<!-- END version_log_loop -->
	<tr>
        <td class="catBottom" colspan="4" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_DELETE_ENTRIES}" class="mainoption" /></td>
    </tr>
</table>


<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
    <tr> 
        <td align="right" valign="top" nowrap="nowrap"><b><span class="gensmall"><a href="javascript:select_switch(true);" class="gensmall">{L_MARK_ALL}</a> :: <a href="javascript:select_switch(false);" class="gensmall">{L_UNMARK_ALL}</a></span></b></td>
    </tr>
</table>
</form>
<br />