{POLL_DISPLAY}
<form method="post" name="post" action="{S_POST_DAYS_ACTION}">
{NAVIGATION_BOX}

<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr> 
	<td><span class="maintitle">
		<a class="maintitle" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a>
		<!-- BEGIN moderators --></span><span class="gensmall"><br /><b>{L_MODERATORS}:&nbsp;</b><!-- BEGIN mod --><a href="{moderators.mod.U_MOD}" title="{moderators.mod.L_MOD_TITLE}" class="gensmall">{moderators.mod.L_MOD}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END mod --><!-- END moderators -->
	</span></td>
</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td align="left" valign="bottom" nowrap="nowrap"><span class="nav">
		<a href="{U_NEW_TOPIC}" title="{L_NEW_TOPIC}"><img src="{I_NEW_TOPIC}" border="0" alt="{L_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_REPLY_TOPIC}" title="{L_REPLY_TOPIC}"><img src="{I_REPLY_TOPIC}" border="0" alt="{L_REPLY_TOPIC}" align="middle" /></a>
	</span></td>
	<td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall">
		<a href="{U_VIEW_PREVIOUS_TOPIC}" title="{L_VIEW_PREVIOUS_TOPIC}"><img src="{I_VIEW_PREVIOUS_TOPIC}" border="0" alt="{L_VIEW_PREVIOUS_TOPIC}" hspace="2" /></a><!-- BEGIN watch --><a href="{U_WATCH_TOPIC}" title="{L_WATCH_TOPIC}"><img src="{I_WATCH_TOPIC}" border="0" alt="{L_WATCH_TOPIC}" hspace="2" /></a><!-- END watch --><!-- BEGIN unread_topic --><a href="{U_UNREAD_TOPIC}" title="{L_UNREAD_TOPIC}"><img src="{I_UNREAD_TOPIC}" border="0" alt="{L_UNREAD_TOPIC}" hspace="2" /></a><!-- END unread_topic --><a href="{U_VIEW_NEXT_TOPIC}" title="{L_VIEW_NEXT_TOPIC}"><img src="{I_VIEW_NEXT_TOPIC}" border="0" alt="{L_VIEW_NEXT_TOPIC}" hspace="2" /></a>
	</span></td>
</tr>
</table>
<!-- INCLUDE pagination_box.tpl -->
<table class="forumline" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td colspan="5"><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
</tr>
<tr>
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
	<th class="thCornerL" width="150" nowrap="nowrap">{L_AUTHOR}</th>
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
	<th class="thCornerR" nowrap="nowrap">{L_MESSAGE}</th>
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
</tr>
<!-- BEGIN postrow -->
<tr>
	<td rowspan="7" width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
	<td><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
	<td rowspan="3" width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
	<td><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
	<td rowspan="7" width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
</tr>
<tr>
	<td rowspan="2" width="150" align="left" valign="top" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" style="padding: 3px"><span class="name">
		<a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span><br /><span class="postdetails">
			<!-- BEGIN rank -->{postrow.L_POSTER_RANK}<br /><!-- BEGIN img --><img src="{postrow.I_POSTER_RANK}" border="0" alt="{postrow.L_POSTER_RANK}" /><br /><!-- END img --><!-- END rank -->
			<!-- BEGIN avatar --><img src="{postrow.POSTER_AVATAR}" border="0" alt="" /><br /><!-- END avatar -->
			<br />
			<!-- BEGIN poster_joined -->{L_POSTER_JOINED}: {postrow.POSTER_JOINED}<br /><!-- END poster_joined -->
			<!-- BEGIN poster_posts -->{L_POSTER_POSTS}: {postrow.POSTER_POSTS}<br /><!-- END poster_posts -->
			<!-- BEGIN poster_from -->{L_POSTER_FROM}: {postrow.POSTER_FROM}<br /><!-- END poster_from -->
	</span></td>
	<td height="100%" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" width="100%" valign="top" style="padding: 3px">
		<span class="postbody">
			<!-- BEGIN msg_icon --><img src="{postrow.msg_icon.I_ICON}" border="0" title="{postrow.msg_icon.L_ICON}" class="absbottom" alt="" />&nbsp;<!-- END msg_icon -->
			<!-- BEGIN sub_type --><!-- BEGIN img --><img src="{postrow.sub_type.I_SUB_TYPE}" border="0" alt="{postrow.sub_type.L_SUB_TYPE}" title="{postrow.sub_type.L_SUB_TYPE}" class="absbottom" /><!-- END img --><!-- BEGIN txt --><b>[{postrow.sub_type.L_SUB_TYPE}]</b><!-- END txt -->&nbsp;<!-- END sub_type -->
			<!-- BEGIN title --><b>{postrow.POST_SUBJECT}</b><br /></span><span class="postdetails"><!-- END title -->
			<!-- BEGIN sub_title -->{postrow.sub_title.SUB_TITLE}<br /><!-- END sub_title -->
			<!-- BEGIN announce -->{postrow.announce.S_ANNOUNCE}<br /><!-- END announce -->
			<!-- BEGIN calendar_event -->{postrow.calendar_event.S_CALENDAR_EVENT}<br /><!-- END calendar_event -->
			<!-- BEGIN title --></span><hr /><span class="postbody"><!-- END title -->
			{postrow.MESSAGE}<br />
		</span>
		{postrow.ATTACHMENTS}
	</td>
</tr>
<tr>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" valign="bottom" style="padding: 3px"><div class="postbody">
		<!-- BEGIN signature -->_________________<br />{postrow.SIGNATURE}<br /><!-- END signature -->
	</div><div class="postdetails" align="right"><br />
		<a href="{postrow.U_POST}" title="{postrow.L_POST}"><img src="{postrow.I_POST}" alt="{postrow.L_POST}" border="0" hspace="2" /></a><b>{L_POSTED}:</b>&nbsp;{postrow.POST_DATE}<br /><!-- BEGIN edited -->{postrow.EDITED_MESSAGE}<br /><!-- END edited -->
	</div></td>
</tr>
<tr>
	<td colspan="3"><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
</tr>
<tr>
	<td style="padding: 0px" colspan="3">
		<table style="width: 100%; border: 0px" cellspacing="0">
			<tr>
				<td style="padding: 0px; width: 1px"><img src="{I_SPACER}" alt="" width="1" border="0" /></td>
				<td class="catlight" style="padding-top: 4px; vertical-align: middle; white-space: nowrap">
					<div style="float: left; text-align: left">
						<!-- BEGIN profile -->&nbsp;<a href="{postrow.U_PROFILE}"><img src="{I_POSTER_PROFILE}" alt="{L_POSTER_PROFILE}" title="{L_POSTER_PROFILE}" border="0" /></a><!-- END profile -->
						<!-- BEGIN pm -->&nbsp;<a href="{postrow.U_PM}"><img src="{I_POSTER_PM}" alt="{L_POSTER_PM}" title="{L_POSTER_PM}" border="0" /></a><!-- END pm -->
						<!-- BEGIN email -->&nbsp;<a href="{postrow.U_EMAIL}"><img src="{I_POSTER_EMAIL}" alt="{L_POSTER_EMAIL}" title="{L_POSTER_EMAIL}" border="0" /></a><!-- END email -->
						<!-- BEGIN www -->&nbsp;<a href="{postrow.U_WWW}" target="userwww"><img src="{I_POSTER_WWW}" alt="{L_POSTER_WWW}" title="{L_POSTER_WWW}" border="0" /></a><!-- END www -->
						<!-- BEGIN aim -->&nbsp;<a href="{postrow.U_AIM}"><img src="{I_POSTER_AIM}" alt="{L_POSTER_AIM}" title="{L_POSTER_AIM}" border="0" /></a><!-- END aim -->
						<!-- BEGIN yim -->&nbsp;<a href="{postrow.U_YIM}"><img src="{I_POSTER_YIM}" alt="{L_POSTER_YIM}" title="{L_POSTER_YIM}" border="0" /></a><!-- END yim -->
						<!-- BEGIN msn -->&nbsp;<a href="{postrow.U_MSN}"><img src="{I_POSTER_MSN}" alt="{L_POSTER_MSN}" title="{L_POSTER_MSN}" border="0" /></a><!-- END msn -->
					</div>
					<!-- BEGIN icq -->
					<div style="float: left; text-align: left; position: relative">&nbsp;<a href="{postrow.U_ICQ}"><img src="{I_POSTER_ICQ}" alt="{L_POSTER_ICQ}" title="{L_POSTER_ICQ}" border="0" /></a>&nbsp;<div id="icq_status_{postrow.U_POST_ID}" style="position: absolute; left: 7px; top: -1px; display: none"><a href="{postrow.U_ICQ_STATUS}" title=""><img src="{postrow.I_ICQ_STATUS}" width="18" height="18" alt="" border="0" /></a></div></div>
					<!-- END icq -->
					<div style="float: right; text-align: right">
						<!-- BEGIN quote --><a href="{postrow.U_QUOTE}"><img src="{I_POST_QUOTE}" alt="{L_POST_QUOTE}" title="{L_POST_QUOTE}" border="0" /></a><!-- END quote -->
						<!-- BEGIN edit -->&nbsp;<a href="{postrow.U_EDIT}"><img src="{I_POST_EDIT}" alt="{L_POST_EDIT}" title="{L_POST_EDIT}" border="0" /></a><!-- END edit -->
						<!-- BEGIN delete -->&nbsp;<a href="{postrow.U_DELETE}"><img src="{I_POST_DELETE}" alt="{L_POST_DELETE}" title="{L_POST_DELETE}" border="0" /></a><!-- END delete -->
						<!-- BEGIN ip -->&nbsp;<a href="{postrow.U_IP}"><img src="{I_POST_IP}" alt="{L_POST_IP}" title="{L_POST_IP}" border="0" /></a><!-- END ip -->
						<!-- BEGIN unmark_read -->&nbsp;<a href="{postrow.U_UNREAD_POST}"><img src="{I_POST_UNREAD}" alt="{L_POST_UNREAD}" title="{L_POST_UNREAD}" border="0" /></a><!-- END unmark_read -->
					&nbsp;<a href="#top" class="nav"><img src="{I_BACK_TO_TOP}" alt="{L_BACK_TO_TOP}" title="{L_BACK_TO_TOP}" border="0" /></a>&nbsp;</div>
				</td>
				<td style="padding: 0px; width: 1px"><img src="{I_SPACER}" alt="" width="1" border="0" /></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="3"><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
</tr>
<tr>
	<td class="spaceRow" colspan="3" height="1"><img src="{I_SPACER}" alt="" width="1" height="1" /></td>
</tr>
<!-- END postrow -->
<!-- BEGIN empty -->
<tr>
	<td colspan="5"><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
</tr>
<tr>
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
	<td colspan="3" class="row1" height="35" align="center"><span class="gen">{L_EMPTY}
	</span></td>
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
</tr>
<tr>
	<td colspan="5"><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
</tr>
<tr>
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
	<td class="spaceRow" colspan="3" height="1"><img src="{I_SPACER}" alt="" width="1" height="1" /></td>
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
</tr>
<!-- END empty -->
<tr>
	<td colspan="5"><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
</tr>
<tr align="center">
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
	<td class="catBottom" colspan="3" height="28" align="center" style="padding: 3px"><span class="gensmall">
		{L_DISPLAY_POSTS}:&nbsp;<select name="postdays">{POSTDAYS}</select>&nbsp;&nbsp;{L_SORT_BY}:&nbsp;<select name="sort">{SORT}</select>&nbsp;<select name="postorder">{POSTORDER}</select>&nbsp;<input type="image" src="{I_GO}" value="{L_GO}" name="submit" align="top" />
	</span></td>
	<td width="1"><img src="{I_SPACER}" width="1" border="0" alt="" /></td>
</tr>
<tr>
	<td colspan="5"><img src="{I_SPACER}" height="1" border="0" alt="" /></td>
</tr>
</table>
<!-- INCLUDE pagination_box.tpl -->
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
	<td align="left" valign="top" nowrap="nowrap"><span class="nav">
		<a href="{U_NEW_TOPIC}" title="{L_NEW_TOPIC}"><img src="{I_NEW_TOPIC}" border="0" alt="{L_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_REPLY_TOPIC}" title="{L_REPLY_TOPIC}"><img src="{I_REPLY_TOPIC}" border="0" alt="{L_REPLY_TOPIC}" align="middle" /></a>
	</span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">
		<a href="{U_VIEW_PREVIOUS_TOPIC}" title="{L_VIEW_PREVIOUS_TOPIC}"><img src="{I_VIEW_PREVIOUS_TOPIC}" border="0" alt="{L_VIEW_PREVIOUS_TOPIC}" hspace="2" /></a><!-- BEGIN watch --><a href="{U_WATCH_TOPIC}" title="{L_WATCH_TOPIC}"><img src="{I_WATCH_TOPIC}" border="0" alt="{L_WATCH_TOPIC}" hspace="2" /></a><!-- END watch --><!-- BEGIN unread_topic --><a href="{U_UNREAD_TOPIC}" title="{L_UNREAD_TOPIC}"><img src="{I_UNREAD_TOPIC}" border="0" alt="{L_UNREAD_TOPIC}" hspace="2" /></a><!-- END unread_topic --><a href="{U_VIEW_NEXT_TOPIC}" title="{L_VIEW_NEXT_TOPIC}"><img src="{I_VIEW_NEXT_TOPIC}" border="0" alt="{L_VIEW_NEXT_TOPIC}" hspace="2" /></a>
	</span></td>
</tr>
</table>

{NAVIGATION_BOX}
</form>

<table width="100%" cellspacing="2" border="0" align="center">
<tr>
	<td valign="top" nowrap="nowrap" align="left">
		<!-- BEGIN modcp --><a href="{modcp.U_ACTION}" title="{modcp.L_ACTION}"><img src="{modcp.I_ACTION}" border="0" alt="{modcp.L_ACTION}" /></a>&nbsp;<!-- END modcp -->
	</td>
	<td align="right" width="100%" valign="top" nowrap="nowrap">
		{JUMPBOX}
		<!-- BEGIN rules --><br /><span class="gensmall"><!-- BEGIN row -->{rules.row.S_RULE}<br /><!-- END row --></span><!-- END rules -->
	</td>
</tr>
</table>

<script language="JavaScript" type="text/javascript"><!--//
function _icq()
{
	this.ids = new Array();
	return this;
}
	_icq.prototype.objref = function(id)
	{
		return document.getElementById ? document.getElementById(id) : (document.all ? document.all[id] : (document.layers ? document.layers[id] : null));
	}
	_icq.prototype.display_status = function()
	{
		if ( (navigator.userAgent.toLowerCase().indexOf('mozilla') == -1) || (navigator.userAgent.indexOf('5.') != -1) || (navigator.userAgent.indexOf('6.') != -1) )
		{
			for ( i = 1; i < this.ids.length; i++ )
			{
				icq_status = this.objref(this.ids[i]);
				if ( icq_status && icq_status.style )
				{
					icq_status.style.display = '';
				}
			}
		}
	}

icq_status = new _icq();
icq_status.ids = Array(''<!-- BEGIN postrow --><!-- BEGIN icq -->, 'icq_status_{postrow.U_POST_ID}'<!-- END icq --><!-- END postrow -->);
icq_status.display_status();
//--></script>