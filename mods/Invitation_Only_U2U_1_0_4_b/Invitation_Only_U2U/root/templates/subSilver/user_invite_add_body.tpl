{ERROR_BOX}
<form action="{S_INVITE_ACTION}" method="post"><table width="65%" class="forumline" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<th class="thTop" colspan="2">{L_INVITES_TITLE}</th>
	</tr>
	<tr> 
	  <td class="row1" align="left" colspan="2"><span class="gensmall">{L_INVITES_TEXT}</span></td>
	</tr>
	<tr> 
		<td class="row1" align="left"><span class="gen"><b>{L_RECIPIENT}:</b></span></td>
		<td class="row2"><input class="post" type="text" name="email_to" size="60" maxlength="60" value="{MAIL}" /></td>
	</tr>
	<tr> 
		<td class="row1" align="left"><span class="gen"><b>{L_SUBJECT}:</b></span></td>
		<td class="row2"><span class="gen"><input class="post" type="text" name="email_subject" size="60" maxlength="100" tabindex="2" class="post" value="{SUBJECT}" /></span></td>
	</tr>
	<tr> 
		<td class="row1" align="left" valign="top"> <span class="gen"><b>{L_EMAIL_MSG}:</b></span> 
		<td class="row2"><span class="gen"> <textarea name="message" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post">{MESSAGE}</textarea></span> 
	</tr> 
	<!-- BEGIN switch_group_invite -->
		<tr> 
			<td class="row1" ><span class="gen"><b>{L_AUTO_ACTIVATE_GROUP}</b>:</span></td>
			<td class="row2"> 
				<input type="radio" name="auto_activate" value="1" />
				<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
				<input type="radio" name="auto_activate" value="0" checked="checked" />
				<span class="gen">{L_NO}</span>
			</td> 
	 
    	</tr>
	<!-- END switch_group_invite -->
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table>
{S_HIDDEN_FIELDS}</form>
