
<h1>{L_INVITES_TITLE}</h1>

<p>{L_INVITES_TEXT}</p>

<form action="{S_INVITE_ACTION}" method="post"><table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<th class="thTop" colspan="2">{L_INVITES_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" align="left"><b>{L_DESCRIPTION}:</b></td>
	  <td class="row2"><span class="gen"> <textarea name="description" rows="5" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post" >{DESCRIPTION}</textarea></span> 
	</tr>
        
        <tr> 
	  <td class="row1" align="left"><b>{L_USES}:</b> <br /> <span class="gensmall">{L_USES_EXPLAIN}</span></td>
	  <td class="row2"><span class="gen"><input class="post" type="text" name="uses" size="8" maxlength="100" tabindex="2" class="post" value="{USES}" /></span></td>
	</tr>
        <tr> 
                <td class="row1"><span class="gen"><b>{L_GROUP}</b>:</span></td>
		<td class="row2"><select name="group">{S_GROUP_SELECT_BOX}</select></td>
	</tr>
	<!-- BEGIN switch_add_invite -->
	<tr>
		<th class="thTop" colspan="2">{L_INVITE_EMAIL_TITLE}</th>
	</tr>
	<tr> 
	  <td class="row1" align="left"><b>{L_RECIPIENT}:</b></td>
	  <td class="row2"><input class="post" type="text" name="email_to" size="60" maxlength="60" value="" /></td>
	</tr>
	<tr> 
	  <td class="row1" align="left"><b>{L_SUBJECT}:</b></td>
	  <td class="row2"><span class="gen"><input class="post" type="text" name="email_subject" size="60" maxlength="100" tabindex="2" class="post" value="{L_DEFAULT_SUBJECT}" /></span></td>
	</tr>
	<tr> 
	  <td class="row1" align="left" valign="top"> <span class="gen"><b>{L_EMAIL_MSG}:</b></span> 
	  <td class="row2"><span class="gen"> <textarea name="message" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post" >{L_DEFAULT_MESSAGE}</textarea></span> 
	</tr> 
        <!-- END switch_add_invite -->
        <tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table>
{S_HIDDEN_FIELDS}</form>
