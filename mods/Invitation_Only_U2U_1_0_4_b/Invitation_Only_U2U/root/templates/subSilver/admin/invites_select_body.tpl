<h1>{L_INVITES_TITLE}</h1>

<p>{L_INVITES_EXPLAIN}</p>
<form method="post" name="post" action="{S_USER_ACTION}">
<table width="60%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">

	<tr>
		<th class="thHead" align="center">{L_USER_SELECT}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><input type="text" class="post" name="username" maxlength="50" size="20" /> <input type="hidden" name="mode" value="edit" />{S_HIDDEN_FIELDS}<input type="submit" name="submituser" value="{L_LOOK_UP}" class="mainoption" /> <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'heigth=250,resizable=yes,width=400');return false;" /></td>
	</tr>
</table>
</form>
<form  method="post" action="{S_GROUP_ACTION}">  
<table  width="60%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">

	<tr>
		
	<th class="thHead" align="center">{L_GROUP_SELECT}</th>
	</tr>
	 
	<tr>
		<td class="row1" align="center">{S_GROUP_SELECT}&nbsp;&nbsp;<input type="submit" name="edit" value="{L_LOOK_UP_GROUP}" class="mainoption" />&nbsp;</td>
	</tr>
	</table>
	</form>	 
	
<form method="post" action="{S_CODE_ACTION}"> 
<table width="60%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" align="center">{L_INVITE_CODE}</th>
	</tr>
	<tr>
		<td class="row1" align="center"><input type="text" class="post" name="code" maxlength="8" size="20" />   <input type="submit" name="codesubmit" value="{L_FIND_CODE}" class="mainoption"</td>
	</tr>
	</table>
</form>	 
 
<br />
