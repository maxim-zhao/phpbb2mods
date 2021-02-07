<!-- BEGIN topicrow -->
<!-- BEGIN spacing --><br class="nav" /><!-- END spacing -->
<!-- BEGIN startblock -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
<tr>
	<th align="center" height="25" class="thCornerL" nowrap="nowrap" width="100%" <!-- BEGIN no_topics_ELSE -->colspan="3"<!-- END no_topics_ELSE -->>
		&nbsp;{topicrow.L_BOX_TITLE}&nbsp;
	</th>
	<th width="100" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
	<th width="70" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
	<th width="70" align="center" class="thTop" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
	<th width="200" align="center" class="<!-- BEGIN select -->thTop<!-- BEGINELSE select -->thCornerR<!-- END select -->" nowrap="nowrap">
		&nbsp;{L_LASTPOST}&nbsp;
	</th>
	<!-- BEGIN select --><th align="center" class="thTop" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th><!-- END select -->
</tr>
<!-- END startblock -->
<!-- BEGIN topic -->
<!-- BEGIN header -->
<tr>
	<td class="row2" colspan="<!-- BEGIN select -->8<!-- BEGINELSE select -->7<!-- END select -->"><span class="gensmall">
		<b>&nbsp;{topicrow.L_HEADER_TITLE}&nbsp;</b>
	</span></td>
</tr>
<!-- END header -->
<tr>
	<td class="row1" align="center" valign="middle">
		<img src="{topicrow.I_TOPIC_FOLDER}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER}" title="{topicrow.L_TOPIC_FOLDER}" />
	</td>
	<td class="row1" align="center" valign="middle">
		<!-- BEGIN msg_icon --><img src="{topicrow.topic.msg_icon.I_ICON}" alt="{topicrow.topic.msg_icon.L_ICON}" border="0" title="{topicrow.topic.msg_icon.L_ICON}" /><!-- BEGINELSE msg_icon --><img src="{I_SPACER}" width="19" border="0" alt="" /><!-- END msg_icon -->
	</td>
	<td class="row1" width="100%"><span class="topictitle">
		<!-- BEGIN newest_post --><a href="{topicrow.U_NEWEST_POST}" title="{topicrow.L_NEWEST_POST}"><img src="{topicrow.I_NEWEST_POST}" border="0" alt="{topicrow.L_NEWEST_POST}" title="{topicrow.L_NEWEST_POST}" /></a>&nbsp;<!-- END newest_post -->
		<!-- BEGIN type --><!-- BEGIN img --><img src="{topicrow.topic.type.I_TOPIC_TYPE}" border="0" alt="{topicrow.topic.type.L_TOPIC_TYPE}" title="{topicrow.topic.type.L_TOPIC_TYPE}" /><!-- END img --><!-- BEGIN txt --><b>[{topicrow.topic.type.L_TOPIC_TYPE}]</b><!-- END txt -->&nbsp;<!-- END type -->
		<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a>
	</span><span class="gensmall">&nbsp;
		<!-- BEGIN sub_title --><br />{topicrow.topic.sub_title.SUB_TITLE}<!-- END sub_title -->
		<!-- BEGIN calendar_event --><br />{topicrow.topic.calendar_event.S_CALENDAR_EVENT}<!-- END calendar_event -->
		<!-- BEGIN announce --><br />{topicrow.topic.announce.S_ANNOUNCE}<!-- END announce -->
		<!-- BEGIN pagination --><br />[&nbsp;<img src="{topicrow.topic.pagination.I_GOTO}" border="0" align="middle" alt="{topicrow.topic.pagination.L_GOTO}" title="{topicrow.topic.pagination.L_GOTO}" hspace="2" />{topicrow.topic.pagination.L_GOTO}:&nbsp;<!-- BEGIN page_number --><!-- BEGIN number --><a href="{topicrow.topic.pagination.page_number.U_PAGE}" class="gensmall">{topicrow.topic.pagination.page_number.PAGE}</a><!-- BEGIN sep -->, <!-- END sep --><!-- BEGINELSE number -->..., <!-- END number --><!-- END page_number -->&nbsp;]<!-- END pagination -->
		<!-- BEGIN navigation --><br />[&nbsp;<!-- BEGIN nav --><a href="{topicrow.topic.navigation.nav.U_NAV}" title="{topicrow.topic.navigation.nav.L_NAV_DESC}" class="gensmall">{topicrow.topic.navigation.nav.L_NAV}</a><!-- BEGIN sep -->&nbsp;&raquo;&nbsp;<!-- END sep --><!-- END nav -->&nbsp;]<!-- END navigation -->
	</span></td>
	<td class="row1" align="center" valign="middle"><span class="name">&nbsp;
		<!-- BEGIN author_userlink --><a href="{topicrow.U_TOPIC_AUTHOR}" title="{L_VIEW_PROFILE}" class="name"><!-- END author_userlink -->{topicrow.TOPIC_AUTHOR}<!-- BEGIN author_userlink --></a><!-- END author_userlink -->&nbsp;
	</span></td>
	<td class="row2" align="center" valign="middle"><span class="postdetails">&nbsp;
		{topicrow.REPLIES}&nbsp;
	</span></td>
	<td class="row2" align="center" valign="middle"><span class="postdetails">&nbsp;
		{topicrow.VIEWS}&nbsp;
	</span></td>
	<td class="<!-- BEGIN select -->row1<!-- BEGINELSE select -->row3Right<!-- END select -->" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">&nbsp;
		{topicrow.LAST_POST_TIME}&nbsp;<br />
		<!-- BEGIN last_post_userlink --><a href="{topicrow.U_LAST_POST_AUTHOR}" title="{L_VIEW_PROFILE}" class="gensmall"><!-- END last_post_userlink -->{topicrow.LAST_POST_AUTHOR}<!-- BEGIN last_post_userlink --></a><!-- END last_post_userlink -->
		<!-- BEGIN last_post_link -->&nbsp;<a href="{topicrow.U_LAST_POST}" title="{L_LAST_POST}"><img src="{I_LAST_POST}" alt="{L_LAST_POST}" border="0" /></a><!-- END last_post_link -->
	</span></td>
	<!-- BEGIN select -->
	<td class="row3Right" align="center" valign="middle" nowrap="nowrap"><span class="gen">&nbsp;
		<input type="checkbox" name="topic_id_list[]" value="{topicrow.TOPIC_ID}" />&nbsp;
	</span></td>
	<!-- END select -->
</tr>
<!-- END topic -->
<!-- BEGIN no_topics -->
<tr>
	<td class="row1" colspan="<!-- BEGIN select -->6<!-- BEGINELSE select -->5<!-- END select -->" height="30" align="center" valign="middle"><span class="gen">
		{L_NO_TOPICS}
	</span></td>
</tr>
<!-- END no_topics -->
<!-- BEGIN bottom -->
{BOTTOM_ROW}
<!-- END bottom -->
<!-- BEGIN endblock -->
</table>
<!-- END endblock -->
<!-- END topicrow -->