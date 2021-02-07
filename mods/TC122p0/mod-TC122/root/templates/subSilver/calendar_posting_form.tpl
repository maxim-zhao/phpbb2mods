<tr>
	<th class="thHead" colspan="2">{L_CALENDAR_TITLE}</th>
</tr>
<tr>
	<td class="row1"><span class="gen"><b>{L_CALENDAR_TIME}</b></span></td>
	<td class="row2"><span class="genmed">
		<!-- BEGIN calendar_list -->
		<!-- BEGIN time -->
		<select name="{calendar_list.NAME}" onChange="if (this.value == -1) {document.post.topic_calendar_hour.value = -1; document.post.topic_calendar_min.value = -1; document.post.topic_calendar_duration_hour.value = ''; document.post.topic_calendar_duration_min.value = '';} else if (document.post.topic_calendar_hour.value == -1) {document.post.topic_calendar_hour.value = 0;} else if ( document.post.topic_calendar_min.value == -1 ) {document.post.topic_calendar_min.value = 0;}">{calendar_list.OPTIONS}</select>
		<!-- END time -->
		<!-- BEGIN time_ELSE -->
		<select name="{calendar_list.NAME}" onChange="if (this.value == -1) {document.post.topic_calendar_year.value = -1; document.post.topic_calendar_month.value = -1; document.post.topic_calendar_day.value = -1; document.post.topic_calendar_hour.value = -1; document.post.topic_calendar_min.value = -1; document.post.topic_calendar_duration_day.value = ''; document.post.topic_calendar_duration_hour.value = ''; document.post.topic_calendar_duration_min.value = '';}">{calendar_list.OPTIONS}</select>
		<!-- END time_ELSE -->
		<!-- END calendar_list -->
	</span><br /><span class="gensmall">
		<!-- BEGIN calendar_qlink -->
		<!-- BEGIN first_ELSE -->
		::
		<!-- END first_ELSE -->
		<a href="#" onClick="document.post.topic_calendar_year.value={calendar_qlink.Y_QLINK}; document.post.topic_calendar_month.value={calendar_qlink.M_QLINK}; document.post.topic_calendar_day.value={calendar_qlink.D_QLINK};" class="gensmall">{calendar_qlink.L_QLINK}</a>
		<!-- END calendar_qlink -->
	</span></td>
</tr>
<tr>
	<td class="row1"><span class="gen"><b>{L_CALENDAR_DURATION}</b></span></td>
	<td class="row2"><span class="genmed">
		<input name="topic_calendar_duration_day" class="post" type="text" maxlength="5" size="3" value="{CALENDAR_DURATION_DAY}" />&nbsp;{L_DAYS}&nbsp;&nbsp;
		<input name="topic_calendar_duration_hour" class="post" type="text" maxlength="5" size="3" value="{CALENDAR_DURATION_HOUR}" />&nbsp;{L_HOURS}&nbsp;&nbsp;
		<input name="topic_calendar_duration_min" class="post" type="text" maxlength="5" size="3" value="{CALENDAR_DURATION_MIN}" />&nbsp;{L_MINUTES}
	</span></td>
</tr>