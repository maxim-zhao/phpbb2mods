<h1>{L_TITLE}</h1>
<form method="post" name="color" action="{S_ACTION}">
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="forumline" align="center">
	<tr>
		<th class="thHead" colspan="3">{L_EDIT}</th>
	</tr>
	<tr>
		<td class="row1" colspan="2" width="38%"><span class="gen">{L_SESSION}</span><br /><span class="gensmall">{L_SESSION_EXPLAIN}</span></td>
		<td class="row2" width="62%"><span class="gensmall"><input class="post" type="text" class="post" name="color_session" maxlength="6" size="20" value="{GROUP_SESSION}" /> &nbsp; <a href="javascript:TCP.popup(document.forms['color'].elements['color_session'], '1', '{U_SEARCH_COLOR}')" class="gen">{L_FIND_COLOR}</a></span></td>
	</tr>
	<tr>
		<td class="row1" colspan="2" width="38%"><span class="gen">{L_ANONYMOUS}</span><br /><span class="gensmall">{L_ANONYMOUS_EXPLAIN}</span></td>
		<td class="row2" width="62%"><span class="gensmall"><input class="post" type="text" class="post" name="color_anonymous" maxlength="6" size="20" value="{GROUP_ANONYMOUS}" /> &nbsp; <a href="javascript:TCP.popup(document.forms['color'].elements['color_anonymous'], '1', '{U_SEARCH_COLOR}')" class="gen">{L_FIND_COLOR}</a></span></td>
	</tr>
	<!-- BEGIN group_registered -->
	<tr>
		<td class="row1" colspan="2" width="38%"><span class="gen">{L_REGISTERED}</span><br /><span class="gensmall">{L_REGISTERED_EXPLAIN}</span></td>
		<td class="row2" width="62%"><span class="gensmall"><input class="post" type="text" class="post" name="color_registered" maxlength="6" size="20" value="{group_registered.GROUP_REGISTERED}" /> &nbsp; <a href="javascript:TCP.popup(document.forms['color'].elements['color_registered'], '1', '{U_SEARCH_COLOR}')" class="gen">{L_FIND_COLOR}</a></span></td>
	</tr>
	<!-- END group_registered -->
	<tr>
		<td class="row1" colspan="2" width="38%"><span class="gen">{L_TIME}</span><br /><span class="gensmall">{L_TIME_EXPLAIN}</span></td>
		<td class="row2" width="62%"><span class="gensmall">{S_TIME}</span></td>
	</tr>
	<tr>
		<td class="row1" colspan="2" width="38%"><span class="gen">{L_CHECK}</span><br /><span class="gensmall">{L_CHECK_EXPLAIN}</span></td>
		<td class="row2" width="62%"><span class="gensmall"><input type="radio" name="agcm_check" value="{FALSE}"{S_CHECK_NO} /> {L_NO} &nbsp;&nbsp;<input type="radio" name="agcm_check" value="{TRUE}"{S_CHECK_YES} /> {L_YES}</span></td>
	</tr>
	<!-- BEGIN group_color_edit -->
	<tr>
		<th class="thHead" colspan="3">
			{group_color_edit.GROUP_NAME}
		</th>
	</tr>
	<tr>
		<td class="row1"><span class="gen">&nbsp;
			<!-- BEGIN up -->
			<a href="{group_color_edit.U_WEIGHT_UP}" class="gen"><img src="{I_UP}" title="{L_UP}" alt="{L_UP}" border="0" /></a>
			<!-- END up -->
		</span></td>
		<td class="row1" width="38%"><span class="gen">{L_COLOR}</span><br /><span class="gensmall">{L_COLOR_EXPLAIN}</span></td>
		<td class="row2" width="62%"><span class="gensmall"><input class="post" type="text" class="post" name="color{group_color_edit.ID}" maxlength="6" size="20" value="{group_color_edit.GROUP_COLOR}" /> &nbsp; <a href="javascript:TCP.popup(document.forms['color'].elements['color{group_color_edit.ID}'], '1', '{U_SEARCH_COLOR}')" class="gen">{L_FIND_COLOR}</a></span></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">&nbsp;
			<!-- BEGIN down -->
			<a href="{group_color_edit.U_WEIGHT_DOWN}" class="gen"><img src="{I_DOWN}" title="{L_DOWN}" alt="{L_DOWN}" border="0" /></a>
			<!-- END down -->
		</span></td>
		<td class="row1" width="38%"><span class="gen">{L_LEGEND}</span></td>
		<td class="row2" width="62%"><span class="gensmall"><input type="radio" name="legend{group_color_edit.ID}" value="{FALSE}"{group_color_edit.S_LEGEND_NO} /> {L_NO} &nbsp;&nbsp;<input type="radio" name="legend{group_color_edit.ID}" value="{TRUE}"{group_color_edit.S_LEGEND_YES} /> {L_YES}</span></td>
	</tr>
	<!-- END group_color_edit -->
	<tr>
		<td class="catBottom" colspan="3" align="center"><span class="cattitle"><input type="submit" name="color_update" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp; <input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></span></td>
	</tr>
</table>
{S_HIDDEN_FIELDS}
</form>