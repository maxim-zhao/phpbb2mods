<form name="post" method="post" action="{S_ACTION}">
{NAVIGATION_BOX}
<table cellpadding="4" cellspacing="1" border="0" class="forumline" width="100%">
<tr>
	<th class="thHead">{SITENAME} - {L_AGREE_TITLE}</th>
</tr>
<tr>
	<td class="row1"><table cellpadding="10" cellspacing="0" border="0" width="100%">
	<tr>
		<td width="5%">&nbsp;</td>
		<td align="justify"><span class="gen"><br />
			{L_AGREEMENT}
		</span></td>
		<td width="5%">&nbsp;</td>
	</tr>
	<!-- BEGIN edited_or_read_next -->
	<tr>
		<td colspan="3" align="right"><span class="postdetails"><br />
	<!-- END edited_or_read_next -->
			<!-- BEGIN edited -->{L_EDITED}<br /><!-- END edited -->
			<!-- BEGIN read_next --><br /><a href="{U_READ_NEXT}" onclick="window.open('{U_READ_NEXT}', 'boardrules', 'HEIGHT=500,resizable=yes,scrollbars=yes,WIDTH=800');return false;" title="{L_READ_NEXT}" class="postdetails" target="boardrules">{L_READ_NEXT}</a><br /><!-- END read_next -->
	<!-- BEGIN edited_or_read_next -->
		</span></td>
	</tr>
	<!-- END edited_or_read_next -->
	<tr>
		<td colspan="3" align="center"><hr /><span class="gen"><br />
			<!-- BEGIN agree --><input type="radio" name="agree" value="{agree.VALUE}"<!-- BEGIN selected --> checked="checked"<!-- END selected --> />&nbsp;{agree.LEGEND}<br /><br /><!-- END agree --><br />
		</span></td>
	</tr></table></td>
</tr>
<tr>
	<td class="catBottom" align="center">{S_HIDDEN_FIELDS}<span class="genmed">&nbsp;
		<!-- BEGIN buttons --><input type="image" name="{buttons.BUTTON}" src="{buttons.I_BUTTON}" alt="{buttons.L_BUTTON}" title="{buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->&nbsp;
	</span></td>
</tr>
</table>
</form><br clear="all" />