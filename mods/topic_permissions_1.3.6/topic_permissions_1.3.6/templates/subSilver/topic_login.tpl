
<form action="{S_LOGIN_ACTION}" method="post">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
	</tr>
  </table>
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thHead"><b>{MESSAGE_TITLE}</b></th>
	</tr>
	<tr> 
	  <td class="row1"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		  <tr> 
			<td align="center"><span class="gen">
			  {MESSAGE_TEXT}<br />
			  <br />
			  {L_PASSWORD}&nbsp;:&nbsp;<input type="password" name="topic_pass" size="25" maxlength="32"/>
			  <br />
			  <br />
			  <input class="mainoption" type="submit" name="topic_login" value="{L_LOGIN}" /></span>
			</td>
		  </tr>
		  <tr> 
			<td>&nbsp;</td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>
</form>
