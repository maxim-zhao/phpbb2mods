<!-- This code is borrowed from wGEric's Admin Userlist MOD -->
<script language="javascript" type="text/javascript">
<!--

function handleClick(id) {
	var obj = "";	

		// Check browser compatibility
		if(document.getElementById)
			obj = document.getElementById(id);
		else if(document.all)
			obj = document.all[id];
		else if(document.layers)
			obj = document.layers[id];
		else
			return 1;

		if (!obj) {
			return 1;
		}
		else if (obj.style) 
		{			
			obj.style.display = ( obj.style.display != "none" ) ? "none" : "";
		}
		else 
		{ 
			obj.visibility = "show"; 
		}
}
//-->
</script>

<h1>{L_VERSION_CHECK}</h1>

<p>{L_VERSION_CHECK_EXPLAIN}</p>

<form action="{S_ACTION}" method="post"> 
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr>
		<th width="13%">&nbsp;</th>
		<th width="33%">{L_MOD_NAME_HEADER}</th>
		<th width="54%">{L_VERSION_CHECK}</th>
	</tr>
	<!-- BEGIN switch_version_check_loop -->
	<tr>
		<td class="{switch_version_check_loop.ROW_CLASS}" nowrap="nowrap"><a href="javascript:handleClick('more_info{switch_version_check_loop.L_LOOP_NUMBER}');">{switch_version_check_loop.L_MORE_INFO}</a></td>
		<td class="{switch_version_check_loop.ROW_CLASS}"><a href="{switch_version_check_loop.U_TOPIC_LOC}" target="_blank">{switch_version_check_loop.L_MOD_NAME}</a></td>
		<td class="{switch_version_check_loop.ROW_CLASS}"><b><span style="{switch_version_check_loop.F_COLOR}">{switch_version_check_loop.L_VERSION_CHECK_RESULT}</span></b></td>
	</tr>
	<tr id="more_info{switch_version_check_loop.L_LOOP_NUMBER}" style="display: none">
        <form action="{switch_version_check_loop.S_VERSION_ACTION}" method="post">
            <td class="{switch_version_check_loop.ROW_CLASS}" colspan="3" width="100%">
                <span class="gen" style="color:red">{switch_version_check_loop.L_MOD_ERROR}</span>
                <b>{L_CURRENT_VERSION_HEADER}:</b>&nbsp;{switch_version_check_loop.L_CURRENT_VERSION}&nbsp; &nbsp;<b>{L_MOD_STATUS_HEADER}:</b>&nbsp;{switch_version_check_loop.L_MOD_STATUS}<br />
                <b>{L_LATEST_VERSION_HEADER}:</b>&nbsp;{switch_version_check_loop.L_LATEST_VERSION}<br />
                <b>{switch_version_check_loop.L_LAST_UPDATED}</b>&nbsp;{switch_version_check_loop.L_LAST_UPDATED_TIME}<br /><br />
                {switch_version_check_loop.L_SECONDARY_VERSION}
                <b><a href="{switch_version_check_loop.U_DOWNLOAD_MOD}" target="_blank">{switch_version_check_loop.L_DOWNLOAD_MOD}</a></b>&nbsp; &nbsp;{switch_version_check_loop.S_HIDDEN_VID}<input type="submit" name="mode" value="{switch_version_check_loop.L_RECHECK_V}" class="mainoption" />
            </td>
        </form>
	</tr>
	<!-- END switch_version_check_loop -->
    <tr>
        <form action="{S_VERSION_ACTION}" method="post">
            <td class="catbottom" colspan="8"><input type="submit" name="mode" value="{L_RECHECK_V_ALL}" class="mainoption" /></td>
        </form>
    </tr>
</table>

<br clear="all" />