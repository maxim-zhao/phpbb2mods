
<br /><br />

<form method="post" action="{S_FORM_ACTION}">
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thHead" align="center">{MESSAGE_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="100%" align="center"><span class="gen">{MESSAGE_TEXT}</span></td>
	</tr>
	<!-- BEGIN switch_continue -->
	<tr>
		<td class="catBottom" align="center" colspan="2">
			{switch_continue.S_HIDDEN_FIELDS}
			<input type="submit" class="mainoption" name="continue" value="{switch_continue.CONTINUE_CAPTION}" />
		</td>
	</tr>
	<!-- END switch_continue -->
</table>
</form>

<br />
