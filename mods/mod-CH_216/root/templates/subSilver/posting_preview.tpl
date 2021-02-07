<!-- BEGIN preview -->
<table class="forumline" width="100%" cellspacing="1" cellpadding="4" border="0">
	<tr> 
		<th height="25" class="thHead">{preview.L_PREVIEW}</th>
	</tr>
	<tr> 
		<td class="row1"><img src="{preview.I_POST}" alt="{preview.L_POST}" /><span class="postdetails">{preview.L_POSTED}: {preview.POST_DATE} &nbsp;&nbsp;&nbsp; {preview.L_POST_SUBJECT}:
			<!-- BEGIN msg_icon --><img src="{preview.msg_icon.I_ICON}" border="0" title="{preview.msg_icon.L_ICON}" class="absbottom" />&nbsp;<!-- END msg_icon -->
			<!-- BEGIN sub_type --><!-- BEGIN img --><img src="{preview.sub_type.I_SUB_TYPE}" border="0" alt="{preview.sub_type.L_SUB_TYPE}" title="{preview.sub_type.L_SUB_TYPE}" class="absbottom" />&nbsp;<!-- END img --><!-- BEGIN txt --><b>[{preview.sub_type.L_SUB_TYPE}]</b>&nbsp;<!-- END txt --><!-- END sub_type -->
			{preview.POST_SUBJECT}
			<!-- BEGIN sub_title --><br />{L_SUB_TITLE}: {preview.sub_title.SUB_TITLE}<!-- END sub_title -->
			<!-- BEGIN announce --><br />{preview.announce.S_ANNOUNCE}<!-- END announce -->
			<!-- BEGIN calendar_event --><br />{preview.calendar_event.S_CALENDAR_EVENT}<!-- END calendar_event -->
		</span></td>
	</tr>
	<tr> 
		<td class="row1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<span class="postbody">{preview.MESSAGE}</span>
					{preview.ATTACHMENTS}
					<span class="postbody"><!-- BEGIN signature --><br />_________________<br />{preview.SIGNATURE}<br /><!-- END signature --></span>
				</td>
			</tr>
		</table></td>
	</tr>
	<tr> 
		<td class="spaceRow" height="1"><img src="{I_SPACER}" width="1" height="1" alt="" /></td>
	</tr>
</table>

<br clear="all" />
<!-- END preview -->