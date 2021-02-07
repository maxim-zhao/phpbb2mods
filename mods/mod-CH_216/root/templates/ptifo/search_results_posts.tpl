 
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="bottom"><span class="maintitle">{L_SEARCH_MATCHES}</span><br /></td>
  </tr>
</table>

{NAVIGATION_BOX}

<!-- INCLUDE pagination_box.tpl -->

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline" align="center">
<tr>
	<th width="150" height="25" class="thCornerL" nowrap="nowrap">{L_AUTHOR}</th>
	<th width="100%" class="thCornerR" nowrap="nowrap">{L_MESSAGE}</th>
</tr>
<!-- BEGIN searchresults -->
<tr>
	<td class="catHead" colspan="2" height="28"><span class="topictitle">
		&nbsp;{L_TOPIC}:&nbsp;<a href="{searchresults.U_TOPIC}" class="topictitle">{searchresults.TOPIC_TITLE}</a>
	</span></td>
</tr>
<tr>
	<td width="150" align="left" valign="top" class="row1"><span class="name">
		<!-- BEGIN search --><a href="{searchresults.U_SEARCH}" title="{searchresults.L_SEARCH}" class="name"><!-- END search --><b>{searchresults.POSTER_NAME}</b><!-- BEGIN search --></a><!-- END search --><br /><br />
	</span><span class="postdetails">
		{L_REPLIES}: <b>{searchresults.TOPIC_REPLIES}</b><br />
		{L_VIEWS}: <b>{searchresults.TOPIC_VIEWS}</b><br />
	</span></td>
	<td width="100%" valign="top" class="row1">
		<!-- BEGIN title -->
		<div class="postbody"><b>
		<!-- END title -->
			<!-- BEGIN msg_icon --><img src="{searchresults.msg_icon.I_ICON}" border="0" title="{searchresults.msg_icon.L_ICON}" class="absbottom" alt="" />&nbsp;<!-- END msg_icon -->
			<!-- BEGIN sub_type --><!-- BEGIN img --><img src="{searchresults.sub_type.I_SUB_TYPE}" border="0" alt="{searchresults.sub_type.L_SUB_TYPE}" title="{searchresults.sub_type.L_SUB_TYPE}" class="absbottom" /><!-- END img --><!-- BEGIN txt --><b>[{searchresults.sub_type.L_SUB_TYPE}]</b><!-- END txt -->&nbsp;<!-- END sub_type -->
		<!-- BEGIN title -->
			<a href="{searchresults.U_POST}">{searchresults.POST_SUBJECT}</a><br />
		</b></div>
		<!-- END title -->
		<div class="postdetails">
			<!-- BEGIN sub_title -->{searchresults.sub_title.SUB_TITLE}<br /><!-- END sub_title -->
			<!-- BEGIN announce -->{searchresults.announce.S_ANNOUNCE}<br /><!-- END announce -->
			<!-- BEGIN calendar_event -->{searchresults.calendar_event.S_CALENDAR_EVENT}<br /><!-- END calendar_event -->
			<b>{L_FORUM}:&nbsp;</b><!-- BEGIN nav --><a href="{searchresults.nav.U_NAV}" title="{searchresults.nav.L_NAV_DESC}" class="postdetails">{searchresults.nav.L_NAV}</a><!-- BEGIN sep --> &raquo;&nbsp;<!-- END sep --><!-- END nav --><br />
		<hr /></div>
		<div class="postbody">
			{searchresults.MESSAGE}
		</div>
		{searchresults.ATTACHMENTS}
		<div class="postdetails" align="right">
			<br /><a href="{searchresults.U_POST}" title="{searchresults.L_POST}"><img src="{searchresults.I_POST}" align="top" alt="{searchresults.L_POST}" border="0" hspace="2" /></a>{L_POSTED}: {searchresults.POST_DATE}
		</div>
	</td>
</tr>
<tr>
	<td colspan="2" height="1" class="spaceRow"><img src="{I_SPACER}" alt="" width="1" height="1" /></td>
</tr>
<!-- END searchresults -->
<tr> 
	<td class="catBottom" colspan="2" height="28" align="center">&nbsp; </td>
</tr>
</table>

<!-- INCLUDE pagination_box.tpl -->

{NAVIGATION_BOX}