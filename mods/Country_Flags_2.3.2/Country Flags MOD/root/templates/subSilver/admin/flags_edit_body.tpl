
<h1>{L_FLAGS_TITLE}</h1>

<p>{L_FLAGS_TEXT}</p>

<form method="post" action="{S_FLAG_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2" class="thHead">{L_FLAGS_TITLE}</th>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_FLAG_NAME}:</span></td>
		<td class="row2"><input class="post" type="text" name="title" size="35" maxlength="40" value="{FLAG}" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_FLAG_IMAGE}:</span><br />
		<span class="gensmall">{L_FLAG_IMAGE_EXPLAIN}</span></td>
		<td class="row2"><input class="post" type="text" name="flag_image" size="40" maxlength="255" value="{IMAGE}" /><br />{IMAGE_DISPLAY}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="save" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table></form>