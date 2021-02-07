
<SCRIPT>
function spawn() {
x=(screen.width/2)-225;
y=(screen.height/2)-200;
window.open('popup.htm','test','left=' + x + ',top=' + y +',screenX=x,screenY=y,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=400')
}
</script>
<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post" name="myform">

{ERROR_BOX}
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="crumbs">
	<tr>
		<td align="left">
			<span class="gensmall"><a href="{U_INDEX}" class="nav">{L_INDEX}</a>{PLOCATION}</span>
		</td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="1" width="800px" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25" valign="center" align="left"><b>{L_USER}</b></th>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="thHead"><small class="nav" >{L_USER}&nbsp;|&nbsp;<a href="{S_PROFILE_LINK2}">{L_PROFILE}</a>&nbsp;|&nbsp;<a href="{S_PROFILE_LINK3}">{L_FORUM}</a>&nbsp;|&nbsp;<a href="{S_PROFILE_LINK4}">{L_AVATAR}</a></small></span></td>
	</tr>

	<!-- BEGIN switch_namechange_disallowed -->
	<tr> 
		<td class="row1"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row2"><input type="hidden" name="username" value="{USERNAME}" /><span class="gen"><b>{USERNAME}</b></span></td>
	</tr>
	<!-- END switch_namechange_disallowed -->
	<!-- BEGIN switch_namechange_allowed -->
	<tr> 
		<td class="row1"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="username" size="25" maxlength="25" value="{USERNAME}" /></td>
	</tr>
	<!-- END switch_namechange_allowed -->
	<tr> 
		<td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="email" size="25" maxlength="255" value="{EMAIL}" /></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CURRENT_PASSWORD}: *</span><br />
		<span class="gensmall">{L_CONFIRM_PASSWORD_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="cur_password" size="25" maxlength="32" value="{CUR_PASSWORD}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NEW_PASSWORD}: *</span><br />
		<span class="gensmall">{L_PASSWORD_IF_CHANGED}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="new_password" size="25" maxlength="32" value="{NEW_PASSWORD}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CONFIRM_PASSWORD}: * </span><br />
		<span class="gensmall">{L_PASSWORD_CONFIRM_IF_CHANGED}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="password_confirm" size="25" maxlength="32" value="{PASSWORD_CONFIRM}" />
	  </td>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
	</tr>
		<tr>
		<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></td>
	</tr>
</table>

</form>
