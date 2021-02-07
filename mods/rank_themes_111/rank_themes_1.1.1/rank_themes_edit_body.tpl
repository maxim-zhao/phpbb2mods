
<h1>{L_RTHEMES_TITLE}</h1>

<p>{L_RTHEMES_TEXT}</p>

<form action="{S_RTHEME_ACTION}" method="post"><table class="forumline" cellpadding="4" cellspacing="1" border="0" align="center">
	<tr>
		<th class="thTop" colspan="2">{L_RTHEMES_TITLE}</th>
	</tr>
	<tr>
		<td class="row1" width="38%"><span class="gen">{L_RTHEME_TITLE}:</span></td>
		<td class="row2"><input class="post" type="text" name="title" size="35" maxlength="40" value="{RTHEME}" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_RTHEME_PUBLIC}</span></td>
		<td class="row2"><input type="radio" name="public_rtheme" value="1" {PUBLIC_RTHEME} />{L_YES} &nbsp;&nbsp;<input type="radio" name="public_rtheme" value="0" {NOT_PUBLIC_RTHEME} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table>
{S_HIDDEN_FIELDS}</form>
