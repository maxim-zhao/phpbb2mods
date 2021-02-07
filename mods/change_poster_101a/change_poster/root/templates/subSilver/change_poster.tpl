<form method="post" action="" name="post">
<table cellspacing="0" cellpadding="3" class="forumline" width="100%">
	<tr>
		<th colspan="5">{L_SELECT_NEW_POSTER}</th>
	</tr>
	<tr>
		<td class="row1" width="5%"><span class="genmed"><b>{L_USERNAME}</b></span></td>
		<td class="row1"><span class="genmed"><input type="text" class="post" name="username" maxlength="25" size="25" tabindex="1" value="{USERNAME}" />&nbsp;<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></span></td>
	</tr>
	<tr>
	    <td class="row2" align="center"><input type="checkbox" name="move_all" /></td>
	    <td class="row2"><span class="genmed">{L_MOVE_ALL}</span></td>
	</tr>
	<tr>
	    <td class="row3" colspan="2" align="center"><input type="submit" class="liteoption" name="submit" value="{L_SUBMIT}" /></td>
	</tr>
</table>
</form>
<br />

<table cellspacing="0" cellpadding="3" class="forumline" width="100%">
	<tr>
	    <th>{L_AUTHOR}</th>
		<th>{L_SUBJECT}: {SUBJECT}</th>
	</tr>
	<tr>
	    <td class="row2" width="10%" valign="top"><span class="nav">{POSTER}</span><br />{AVATAR}<br /><br /></td>
		<td class="row1" valign="top"><span class="postbody">{MESSAGE}</span></td>
	</tr>
	<tr>
	    <td class="catBottom" colspan="2">&nbsp;</td>
	</tr>
</table>