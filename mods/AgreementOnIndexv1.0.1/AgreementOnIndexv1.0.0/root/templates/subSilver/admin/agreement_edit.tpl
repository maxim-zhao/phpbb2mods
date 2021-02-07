<h1>{L_AGREEMENT_HEADER}</h1>

<p>{L_AGREEMENT_EXPLAIN}</p>

<form method="post" action="{S_SAVE_ACTION}">
<table width=50% cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr> 
		<th class="thTop" colspan="2" nowrap="nowrap" align="center">{L_AGREEMENT}</th>
	</tr>
	<tr>
	  	<td width="33%" class="row1">{L_AGREEMENT}:</td>
		<td class="row2"><textarea name="agreement" maxlength="2000" rows="9" cols="50">{CURRENT_AGREEMENT}</textarea></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" value="{L_SAVE}" class="mainoption" /></td>
	</tr>
</table>	
</form>	