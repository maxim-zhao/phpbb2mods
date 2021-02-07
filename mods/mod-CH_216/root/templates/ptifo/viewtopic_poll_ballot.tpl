<form method="post" action="{S_POLL_ACTION}"><table cellpadding="3" cellspacing="1" border="0" width="100%" class="forumline">
<tr>
	<th class="thHead">{POLL}</th>
</tr>
<tr>
	<td class="row1" align="center"><br /><span class="gen"><b>{POLL_QUESTION}</b></span><br /><br />
		<table cellspacing="0" cellpadding="2" border="0">
		<!-- BEGIN poll_option -->
		<tr>
			<td><input type="radio" name="vote_id" value="{poll_option.POLL_OPTION_ID}" />&nbsp;</td>
			<td><span class="gen">{poll_option.POLL_OPTION_CAPTION}</span></td>
		</tr>
		<!-- END poll_option -->
		</table><br /><span class="gensmall"><b><a href="{U_VIEW_RESULTS}" class="gensmall">{L_VIEW_RESULTS}</a></b></span>
	</td>
</tr>
<tr>
	<td class="catBottom" align="center">{S_HIDDEN_FIELDS}
		<!-- BEGIN buttons --><input type="image" src="{buttons.I_BUTTON}" name="{buttons.BUTTON}" alt="{buttons.L_BUTTON}" title="{buttons.L_BUTTON}"<!-- BEGIN accesskey --> accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> /><!-- END buttons -->
	</td>
</tr>
</table></form>