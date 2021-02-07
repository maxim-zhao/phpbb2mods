
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr>
	<td><span class="maintitle">
		<a href="{U_MOD_CP}" class="maintitle">{L_MOD_CP}</a>
	</span><span class="gensmall"><br />
		<br />
	</span></td>
</tr>
</table>
<form action="{S_MODCP_ACTION}" method="post">
{NAVIGATION_BOX}
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
			<td align="center"><span class="gen">{L_MOVE_TO_FORUM} &nbsp; {S_FORUM_SELECT}<br /><br />
			  <input type="checkbox" name="move_leave_shadow" checked="checked" />{L_LEAVESHADOW}<br />
			  <br />
			  {MESSAGE_TEXT}</span><br />
			  <br />
			  {S_HIDDEN_FIELDS} 
			  <input class="mainoption" type="submit" name="confirm" value="{L_YES}" />
			  &nbsp;&nbsp; 
			  <input class="liteoption" type="submit" name="cancel" value="{L_NO}" />
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
