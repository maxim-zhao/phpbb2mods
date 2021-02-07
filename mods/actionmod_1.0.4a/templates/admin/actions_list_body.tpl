
<h1>{L_ACTIONS_TITLE}</h1>

<p>{L_ACTIONS_EXPLAIN}</p>

<form method="post" action="{S_ACTIONS_ACTION}">
	<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
		<tr>
			<th class="thCornerL">{L_ACTIONS_NAME}</th>
			<th class="thTop">{L_ACTIONS_TEXT}</th>
			<th class="thTop">{L_ACTIONS_STATUS}</th>
			<th class="thTop">{L_EDIT}</th>
			<th class="thCornerR">{L_DELETE}</th>
		</tr>
		<!-- BEGIN noactions -->
		<tr>
			<td class="{T_ROW_CLASS}" align="center" colspan="5">{L_NO_ACTIONS}</td>
		</tr>
		<!-- END noactions -->
		<!-- BEGIN actions -->
		<tr>
			<td class="{actions.ROW_CLASS}" align="center">{actions.ACTION}</td>
			<td class="{actions.ROW_CLASS}" align="center">{actions.ACTION_TEXT}</td>
			<td class="{actions.ROW_CLASS}" align="center">{actions.ACTION_STATUS}</td>
			<td class="{actions.ROW_CLASS}" align="center"><a href="{actions.U_ACTION_EDIT}">{L_EDIT}</a></td>
			<td class="{actions.ROW_CLASS}" align="center"><a href="{actions.U_ACTION_DELETE}">{L_DELETE}</a></td>
		</tr>
		<!-- END actions -->			
		<tr>
			<td class="cat" align="center" colspan="6">
				<input type="hidden" name="mode" value="add" />
				<input type="submit" class="mainoption" name="add" value="{L_ADD_ACTION}" />
			</td>
		</tr>
	</table>
</form>
