<h1>{L_USER_SEARCH}</h1>

<p>{NEW_SEARCH}</p>

<form action="{S_POST_ACTION}" method="post" name="post">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="center" class="nav"><span class="gen">{L_SORT_OPTIONS}</span> <a href="{U_USERNAME}">{L_USERNAME}</a> | <a href="{U_EMAIL}">{L_EMAIL}</a> | <a href="{U_POSTS}">{L_POSTS}</a> | <a href="{U_JOINDATE}">{L_JOINDATE}</a> | <a href="{U_LASTVISIT}">{L_LASTVISIT}</a></td>
	</tr>
</table>
<p>&nbsp;</p>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" class="nav"><span class="gen">{PAGE_NUMBER}</span></td>
		<td align="right" class="nav" nowrap="nowrap"><span class="gen">{PAGINATION}</span></td>
	</tr>
</table>
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thTop" nowrap="nowrap">{L_USERNAME}</th>
	  <th class="thTop" nowrap="nowrap">{L_EMAIL}</th>
	  <th class="thTop" nowrap="nowrap">{L_JOINDATE}</th>
	  <th class="thTop" nowrap="nowrap">{L_POSTS}</th>
	  <th class="thTop" nowrap="nowrap">{L_LASTVISIT}</th>
	  <th class="thTop" nowrap="nowrap">&nbsp;</th>
	  <th class="thTop" nowrap="nowrap">&nbsp;</th>
	  <th class="thTop" nowrap="nowrap">&nbsp;</th>
	  <th class="thTop" nowrap="nowrap">{L_ACCOUNT_STATUS}</th>
	</tr>
	<!-- BEGIN userrow -->
	<tr> 
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;<a href="{userrow.U_VIEWPROFILE}" class="gen">{userrow.USERNAME}</a>&nbsp;</span></td>
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;{userrow.EMAIL}&nbsp;</span></td>
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;{userrow.JOINDATE}&nbsp;</span></td>
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;<a href="{userrow.U_VIEWPOSTS}" class="gen">{userrow.POSTS}</a>&nbsp;</span></td>
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;{userrow.LASTVISIT}&nbsp;</span></td>
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;<a href="{userrow.U_MANAGE}" class="gen">{L_MANAGE}</a>&nbsp;</span></td>
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;<a href="{userrow.U_PERMISSIONS}" class="gen">{L_PERMISSIONS}</a>&nbsp;</span></td>
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;{userrow.BAN}&nbsp;</span></td>
	  <td class="{userrow.ROW_CLASS}" align="center" nowrap="nowrap"><span class="gen">&nbsp;{userrow.ABLED}&nbsp;</span></td>
	</tr>
	<!-- END userrow -->
	<tr> 
	  <td class="catBottom" colspan="8" height="28">&nbsp;</td>
	</tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="right" valign="top"></td>
	</tr>
  </table>
</form>