
<h1>{L_FORUM_LOCK}</h1>

<p>{L_FORUM_LOCK_EXPLAIN}</p>

<h2>{L_FORUM}: {FORUM_NAME}</h2>

<form method="post"	action="{S_FORUMLOCK_ACTION}">
  <table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr> 
	  <th class="thHead">{L_FORUM_LOCK}</th>
	</tr>
	<tr>
	  <td class="row1">{S_LOCK_DATA}</td>
	</tr>
	<tr> 
	  <td class="catBottom" align="center">{S_HIDDEN_VARS}
		<input type="submit" name="dolock" value="{L_DO_LOCK}" class="mainoption">
	  </td>
	</tr>
  </table>
</form>
