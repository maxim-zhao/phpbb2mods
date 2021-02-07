<!-- BEGIN event_birthday -->
<div id="{event_birthday.ID}" class="dom_overview_abshidden"><table cellpadding="2" cellspacing="1" border="0" class="bodyline" width="100%"><tr><td><table cellspacing="1" cellpadding="2" border="0" class="forumline" width="100%">
<tr>
	<td class="row1"><span class="topictitle">
		<a href="{event_birthday.U_USERNAME}" class="topictitle">{event_birthday.USERNAME}</a>
	</span><hr /><span class="genmed">{event_birthday.BIRTHDAY}
	<!-- BEGIN age -->
	{event_birthday.S_AGE}
	<!-- END age -->
	<!-- BEGIN adjust -->
	</span><br /><span class="gensmall">{event_birthday.S_ADJUST}
	<!-- END adjust -->
	</span></td>
</tr>
<!-- BEGIN rank_or_avatar -->
<tr>
	<td class="row1" align="center"><span class="gensmall">
<!-- END rank_or_avatar -->
		<!-- BEGIN rank -->
		&nbsp;{event_birthday.L_RANK}&nbsp;<br />
		<!-- BEGIN image -->
		<img src="{event_birthday.I_RANK}" alt="{event_birthday.L_RANK}" title="{event_birthday.L_RANK}" border="0" /><br />
		<!-- END image -->
		<!-- END rank -->
		<!-- BEGIN avatar -->
		<img src="{event_birthday.I_AVATAR}" alt="" border="0" />
		<!-- END avatar -->
<!-- BEGIN rank_or_avatar -->
	</span></td>
</tr>
<!-- END rank_or_avatar -->
</table></td></tr></table></div>
<!-- END event_birthday -->