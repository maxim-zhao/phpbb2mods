
<!-- BEGIN switch_inline_mode -->
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
<tr>
	<td class="catHead" height="28" align="center"><b><span class="cattitle">{L_TOPIC_REVIEW}</span></b></td>
</tr>
<tr>
	<td class="row1"><iframe width="100%" height="300" src="{U_REVIEW_TOPIC}" >
<!-- END switch_inline_mode -->

<form method="post" name="post_review" action="{S_POST_DAYS_ACTION}">
<!-- INCLUDE pagination_box.tpl -->
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
<tr>
	<th class="thCornerL" width="22%" height="26">{L_AUTHOR}</th>
	<th class="thCornerR">{L_MESSAGE}</th>
</tr>
<!-- BEGIN postrow -->
<tr>
	<td width="150" align="left" valign="top" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><a name="{postrow.U_POST_ID}"></a><span class="name"><b>{postrow.POSTER_NAME}</b></span></td>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" height="28" valign="top">
		<!-- BEGIN title -->
		<div class="postbody">
		<!-- END title -->
			<!-- BEGIN msg_icon --><img src="{postrow.msg_icon.I_ICON}" border="0" title="{postrow.msg_icon.L_ICON}" align="top" alt="" />&nbsp;<!-- END msg_icon -->
			<!-- BEGIN sub_type --><!-- BEGIN img --><img src="{postrow.sub_type.I_SUB_TYPE}" border="0" alt="{postrow.sub_type.L_SUB_TYPE}" title="{postrow.sub_type.L_SUB_TYPE}" align="top" /><!-- END img --><!-- BEGIN txt --><b>[{postrow.sub_type.L_SUB_TYPE}]</b><!-- END txt -->&nbsp;<!-- END sub_type -->
		<!-- BEGIN title -->
			<b>{postrow.POST_SUBJECT}</b>
		</div><div class="postdetails">
		<!-- END title -->
			<!-- BEGIN sub_title -->{postrow.sub_title.SUB_TITLE}<br /><!-- END sub_title -->
			<!-- BEGIN announce -->{postrow.announce.S_ANNOUNCE}<br /><!-- END announce -->
			<!-- BEGIN calendar_event -->{postrow.calendar_event.S_CALENDAR_EVENT}<br /><!-- END calendar_event -->
		<!-- BEGIN title -->
		<hr /></div>
		<!-- END title -->
		<div class="postbody">
			{postrow.MESSAGE}
		</div>
		{postrow.ATTACHMENTS}
		<div class="postdetails" align="right">
			<br /><a href="{postrow.U_POST}" title="{postrow.L_POST}"><img src="{postrow.I_POST}" align="top" alt="{postrow.L_POST}" border="0" hspace="2" /></a>{L_POSTED}: {postrow.POST_DATE}
		</div>
	</td>
</tr>
<tr>
	<td colspan="2" height="1" class="spaceRow"><img src="{I_SPACER}" alt="" width="1" height="1" /></td>
</tr>
<!-- END postrow -->
<!-- BEGIN empty -->
<tr>
	<td colspan="2" class="row1" height="35" align="center"><span class="gen">{L_EMPTY}
	</span></td>
</tr>
<!-- END empty -->
<tr>
	<td class="catBottom" colspan="2" height="28" align="center"><span class="gensmall">
		{L_DISPLAY_POSTS}:&nbsp;<select name="postdays">{POSTDAYS}</select>&nbsp;&nbsp;{L_SORT_BY}:&nbsp;<select name="sort">{SORT}</select>&nbsp;<select name="postorder">{POSTORDER}</select>&nbsp;<input type="image" src="{I_GO}" value="{L_GO}" name="submit" align="top" />
	</span></td>
</tr>
</table>
<!-- INCLUDE pagination_box.tpl -->
</form>

<!-- BEGIN switch_inline_mode -->
	</iframe></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="right"><span class="gensmall"><a href="#top" class="gensmall">{L_BACK_TO_TOP}</a></span></td></tr></table>
<!-- END switch_inline_mode -->