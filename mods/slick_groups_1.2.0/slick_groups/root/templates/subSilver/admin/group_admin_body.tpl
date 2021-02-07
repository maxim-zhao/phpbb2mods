
<h1>{L_GROUP_TITLE}</h1>

<p>{L_GROUP_EXPLAIN}</p>

<form method="post" action="{S_ACTION}"><table cellspacing="1" cellpadding="4" border="0" class="forumline" align="center">
	<tr> 
		<th class="thHead" colspan="4">{L_GROUP_TITLE}</th>
	</tr>
	<!-- BEGIN group -->
	<tr> 
		<td class="row2"><span class="gen"><a href="{group.U_GROUP_VIEW}">{group.GROUP_NAME}</a></span><br /><span class="gensmall">{group.GROUP_DESCRIPTION}</span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{group.U_GROUP_EDIT}">{L_EDIT}</a></span></td>
		<td class="row2" align="center" valign="middle"><span class="gen"><a href="{group.U_GROUP_PERMISSIONS}">{L_PERMISSIONS}</a></span></td>
		<td class="row1" align="center" valign="middle"><span class="gen"><a href="{group.U_GROUP_DELETE}">{L_DELETE}</a></span></td>
	</tr>
	<!-- END group -->
	<tr>
		<td class="cat" align="center" colspan="4"><input type="submit" class="mainoption" name="new" value="{L_CREATE_NEW_GROUP}" /></td>
	</tr>
</table></form>
