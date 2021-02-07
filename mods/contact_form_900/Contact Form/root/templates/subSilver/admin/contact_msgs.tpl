<h1>{L_MSGS_TITLE}</h1>
<p>{L_MSGS_TEXT}</p>

<form method="post" action="{S_MSG_ACTION}">
 <table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_DATE}</th>
		<th class="thTop">{L_USER}</th>
		<th class="thTop">{L_NAME}</th>
		<th class="thTop">{L_EMAIL}</th>
		<th class="thTop">{L_MESSAGE}</th>
		<th class="thTop">{L_IP}</th>
		<th class="thTop">{L_FILE}</th>
		<th class="thCornerR">{L_ACTION}</th>
	</tr>
	<!-- BEGIN messages -->
	<tr>
		<td class="{messages.ROW_CLASS}" align="center" nowrap="nowrap">{messages.DATE}<br />{messages.TIME}</td>
		<td class="{messages.ROW_CLASS}" align="center" nowrap="nowrap">{messages.USER}</td>
		<td class="{messages.ROW_CLASS}" align="center" nowrap="nowrap">{messages.NAME}</td>
		<td class="{messages.ROW_CLASS}" align="center" nowrap="nowrap">{messages.EMAIL}</td>
		<td class="{messages.ROW_CLASS}">{messages.MESSAGE}</td>
		<td class="{messages.ROW_CLASS}" align="center" nowrap="nowrap">{messages.IP}</td>
		<td class="{messages.ROW_CLASS}" align="center" nowrap="nowrap">{messages.U_GET_FILE}<br />{messages.U_REMOVE_FILE}</td>
		<td class="{messages.ROW_CLASS}" align="center" nowrap="nowrap"><input type="checkbox" name="{messages.S_THIS_ID}[]" value="{messages.MSG_ID}" /></td>
	</tr>
	<!-- END messages -->
	<tr>
		<td class="catBottom" colspan="8">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td nowrap="nowrap">{PAGE_NUMBER}</td>
					<td width="100%" align="right">{PAGINATION}</td>
					<td>&nbsp;<input type="submit" name="delete" value="{L_DELETE}" class="mainoption" /></td>
				</tr>
			</table>
		</td>
	</tr>
 </table>
</form>

<p align="center"><span class="gensmall">{COPYRIGHT}</span></p>