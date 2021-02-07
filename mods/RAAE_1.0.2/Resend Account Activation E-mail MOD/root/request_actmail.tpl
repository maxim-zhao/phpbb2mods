
<form action="{S_RESEND_ACTIVATION_ACTION}" method="post" target="_top">

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
<tr> 
	<th height="25" class="thHead" nowrap="nowrap" colspan="2">{L_RESEND_ACTIVATION_EMAIL}</th>
</tr>
<tr>
	<td class="row1"><table border="0" cellpadding="3" cellspacing="1" width="100%">
		<tr> 
			<td class="row1" width="45%" align="right"><span class="gen">{L_USERNAME}:</span></td>
			<td class="row1"><input type="text" class="post" name="username" size="25" maxlength="25" /></td>
		</tr>
		<tr> 
			<td class="row1" align="right"><span class="gen">{L_EMAIL}:</span></td>
			<td class="row1"><input type="text" class="post" name="email" size="25" maxlength="255" /></td>
		</tr>
		<tr align="center"> 
			<td class="row1" colspan="2"><input type="submit" name="sendmail" class="mainoption" value="{L_SUBMIT}" /></td>
		</tr>
	</table></td>
</tr>
</table>

</form>