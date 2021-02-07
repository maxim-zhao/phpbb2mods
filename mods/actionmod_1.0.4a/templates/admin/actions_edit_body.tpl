<h1>{L_ACTIONS_TITLE}</h1>

<p>{L_ACTIONS_EXPLAIN}</p>

<form action="{S_ACTIONS_ACTION}" method="post">
<table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<th colspan="2">{L_ACTIONS_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_ACTIONS_NAME}:</span></td>
		<td class="row2">
			<input class="post" type="text" name="action_name" size="35" maxlength="60" value="{ACTION_NAME}" />
		</td>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_ACTIONS_TEXT}:</span></td>
		<td class="row2">
			<input class="post" type="text" name="action_text" size="35" maxlength="60" value="{ACTION_TEXT}" />
		</td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_ACTIONS_STATUS}:</span></td>
        <td class="row2">
			<select name="action_status">
				<option value="{S_ACTIVE}" {ACTION_STATUS_ACTIVE}>{L_ACTIVE}</option>
				<option value="{S_INACTIVE}" {ACTION_STATUS_INACTIVE}>{L_INACTIVE}</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="cat" colspan="2" align="center">
			<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;
			<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table>
{S_HIDDEN_FIELDS}</form>
