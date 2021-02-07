<!-- BEGIN event_topic -->
<div id="{event_topic.ID}" class="dom_overview_abshidden"><table cellpadding="2" cellspacing="1" border="0" class="bodyline" width="100%"><tr><td><table cellspacing="1" cellpadding="2" border="0" class="forumline" width="100%">
<tr>
	<td class="row1"><span class="topictitle">
		<a href="{event_topic.U_TOPIC_TITLE}" class="topictitle">{event_topic.TOPIC_TITLE}</a><br />
	</span><span class="postdetails">
		{event_topic.S_CALENDAR_DATES}<br />
		<b>{event_topic.L_CALENDAR_FORUM}:</b>&nbsp;
		<!-- BEGIN nav -->
		<a href="{event_topic.nav.U_NAV}" class="gensmall">{event_topic.nav.NAV}</a>
		<!-- BEGIN sep -->
		&raquo;
		<!-- END sep -->
		<!-- END nav -->
		<br />
	</span><hr /><span class="postdetails">
		<b>{event_topic.L_CALENDAR_AUTHOR}:</b>&nbsp;{event_topic.TOPIC_AUTHOR}<br />
		<b>{event_topic.L_CALENDAR_TIME}:</b>&nbsp;{event_topic.TOPIC_TIME}<br />
		<b>{event_topic.L_CALENDAR_REPLIES}:</b>&nbsp;{event_topic.TOPIC_REPLIES}<br />
		<b>{event_topic.L_CALENDAR_VIEWS}:</b>&nbsp;{event_topic.TOPIC_VIEWS}<br />
	</span></td>
</tr>
<tr>
	<td class="row1"><span class="postbody">
		{event_topic.TOPIC_MESSAGE}
	</span></td>
</tr>
</table></td></tr></table></div>
<!-- END event_topic -->