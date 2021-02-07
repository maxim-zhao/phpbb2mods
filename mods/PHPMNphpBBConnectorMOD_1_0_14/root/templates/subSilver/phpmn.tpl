<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td align="left" valign="bottom"><a href="{U_PHPMN}" class="maintitle">{L_PHPMN}</a></td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{U_PHPMN}" class="nav">{L_PHPMN}</a></span></td>
	</tr>
</table>
<!-- BEGIN action -->
<table align="center" class="forumline" width="100%">
	<th colspan='2'>{L_PHPMN_ACTION}</th>
	<tr>
		<td class="row1" valign="top"><span class="gen">{L_PHPMN_NAME}</span><br />
			<span class="genmed">&nbsp;-&nbsp;{L_PHPMN_DESCRIPTION}:</span></td>
		<td class="row2"><span class="gen"><b>{action.NAME}</b></span><br />
			<span class="genmed">&nbsp;-&nbsp;{action.DESCRIPTION}</span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_PHPMN_EMAIL}</span>&nbsp;&nbsp;</span><span class="mainmenu"><a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a></td>
		<td class="row2"><span class="gen"><b>{action.USEREMAIL}</b></span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_PHPMN_TOPICAL}</span></td>
		<td class="row2"><span class="gen"><b>{action.TOPICALVIEW}</b></span></td>
	</tr>
	<form method="get" action="phpmn.php">
	<tr>
		<td class="row3" colspan="2" align="center"><span class="gen">
			<b>{L_PHPMN_HTML}:</b>&nbsp;<input type="radio" name="do" value="1">&nbsp; - &nbsp;
			<b>{L_PHPMN_PLAIN}:</b>&nbsp;<input type="radio" name="do" value="2">&nbsp; - &nbsp;
			<b>{L_PHPMN_UNSUBSCRIBE}:</b>&nbsp;<input type="radio" name="do" value="3">
		</span></td>
	</tr>
	<tr>
		<td class="row3" colspan="2" align="center">
			<input type="submit" accesskey="s" name="post" class="mainoption" value="{L_PHPMN_SEND}">&nbsp;&nbsp;
			<input type="reset" accesskey="r" class="mainoption" value="{L_PHPMN_RESET}">
		</td>
	</tr>
		<input type="hidden" name="edit" value="2">
		<input type="hidden" name="id" value="{action.ID}">
		<input type="hidden" name="topical" value="{action.TOPICAL}">
	</form>
</table>
<br /><hr><br />
<!-- END action -->

<!-- BEGIN done -->
{done.DONE}
<!-- END done -->

<table align="center" class="forumline" width="100%">
<th>{L_PHPMN_NAME}</th><th>{L_PHPMN_STATUS}</th><th>{L_PHPMN_EDIT}</th><th>{L_PHPMN_ARCHIVE}</th>

<!-- BEGIN newsletterlist -->
	<tr>
		<td class="row1" valign="top"><span class="gen"><b>{newsletterlist.NAME}</b></span><br />
			<span class="genmed">&nbsp;-&nbsp;{newsletterlist.DESCRIPTION}</span></td>
		<td class="row2" align="center" nowrap><span class="gen"><b>&nbsp;&nbsp;{newsletterlist.TOPICALVIEW}&nbsp;&nbsp;</b></span></td>
		<td class="row3" align="center"><a href="{newsletterlist.LINK}"><img src="{EDIT_IMG}" alt="{L_EDIT_IMG}" title="{L_EDIT_IMG}" border="0"></a></td>
		<td class="row1" align="center"><a href="{newsletterlist.ARCHIVE}"><img src="{ARCHIVE_IMG}" alt="{L_ARCHIVE_IMG}" title="{L_ARCHIVE_IMG}" border="0"></a></td>
	</tr>
<!-- END newsletterlist -->
</table>
