
<h1>{L_CANNED_TITLE}</h1>

<form method="post" action="{S_CANNED_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_TITLE}</th>
		<th class="thTop">{L_EDIT}</th>
		<th class="thTop">{L_DELETE}</th>
		<th class="thTop">{L_UP}</th>
		<th class="thCornerR">{L_DOWN}</th>
	</tr>
	<!-- BEGIN canned -->
	<tr>
		<td class="{canned.ROW_CLASS}">{canned.CANNED_TITLE}</td>
		<td class="{canned.ROW_CLASS}"><a href="{canned.U_CANNED_EDIT}">{L_EDIT}</a></td>
		<td class="{canned.ROW_CLASS}"><a href="{canned.U_CANNED_DELETE}">{L_DELETE}</a></td>
		<td class="{canned.ROW_CLASS}"><a href="{canned.U_CANNED_UP}">{canned.L_UP}</a></td>
		<td class="{canned.ROW_CLASS}"><a href="{canned.U_CANNED_DOWN}">{canned.L_DOWN}</a></td>
	</tr>
	<!-- END canned -->
	<tr>
		<td class="catBottom" align="center" colspan="5">{S_HIDDEN_FIELDS}<input type="submit" class="liteoption" name="new" value="{L_CREATE_NEW_CANNED_MESSAGE}" /></td>
	</tr>
</table></form>
