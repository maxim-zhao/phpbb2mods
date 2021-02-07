
<h1>{L_CANNED_TITLE}</h1>

<form method="post" action="{S_CANNED_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thHead" align="center" colspan="2">{L_CANNED_MESSAGE}</th>
	</tr>

	<tr>
		<td class="row1" align="left" valign="top">{L_TITLE}:</td>
		<td class="row2" align="left" valign="top"><input class="post" type="text" name="canned_title" value="{TITLE}" /></td>
	</tr>
	<tr>
		<td class="row1" align="left" valign="top">{L_MESSAGE}:</td>
		<td class="row2" align="left" valign="top"><textarea class="post" name="canned_message" rows="5" cols="51">{MESSAGE}</textarea></td>
	</tr>
	<tr>
		<td class="row1" align="left" valign="top">&nbsp;</td>
		<td class="row2" align="left" valign="top">
			<input type="checkbox" name="canned_disable_bbcode" value="1"{BBCODE_CHECKED} />{L_DISABLE_BBCODE}<br />
			<input type="radio" name="action_after_post" value="0"{NONE_CHECKED} />{L_NONE_AFTER_POST}<br />
			<input type="radio" name="action_after_post" value="1"{MOVE_CHECKED} />{L_MOVE_AFTER_POST}<br />
			<input type="radio" name="action_after_post" value="2"{LOCK_CHECKED} />{L_LOCK_AFTER_POST}</td>
	</tr>
	<input type="hidden" name="canned_id" value="{CANNED_ID}" />
	<tr> 
	  <td class="catBottom" colspan="3" align="center"><span class="cattitle"> 
		<input type="submit" name="canned_update" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
		</span></td>
	</tr>
</table><input type="hidden" name="g" value="{GROUP_ID}" /></form>
