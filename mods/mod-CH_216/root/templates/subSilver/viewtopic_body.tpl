
<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="bottom"><span class="gensmall">
	<!-- BEGIN switch_user_logged_in -->{LAST_VISIT_DATE}<br /><!-- END switch_user_logged_in -->
	{CURRENT_TIME}<br />
	{S_TIMEZONE}
	</span></td>
  </tr>
</table>

<br class="nav" />

{NAVIGATION_BOX}

<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr> 
	<td><span class="maintitle">
		<a class="maintitle" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a>
	</span><span class="gensmall"><br />
		<!-- BEGIN moderators --><b>{L_MODERATORS}:&nbsp;</b><!-- BEGIN mod --><a href="{moderators.mod.U_MOD}" title="{moderators.mod.L_MOD_TITLE}" class="gensmall">{moderators.mod.L_MOD}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END mod --><!-- END moderators -->
	</span></td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
	<td align="left" valign="bottom" nowrap="nowrap"><span class="nav">
		<a href="{U_NEW_TOPIC}" title="{L_NEW_TOPIC}"><img src="{I_NEW_TOPIC}" border="0" alt="{L_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_REPLY_TOPIC}" title="{L_REPLY_TOPIC}"><img src="{I_REPLY_TOPIC}" border="0" alt="{L_REPLY_TOPIC}" align="middle" /></a>
	</span></td>
	<td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall">
		<!-- BEGIN watch --><a href="{U_WATCH_TOPIC}" class="gensmall">{L_WATCH_TOPIC}</a><br /><!-- END watch -->
		<!-- BEGIN unread_topic --><a href="{U_UNREAD_TOPIC}" class="gensmall">{L_UNREAD_TOPIC}</a>&nbsp;::&nbsp;<!-- END unread_topic -->
		<a href="{U_VIEW_PREVIOUS_TOPIC}" class="gensmall">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEXT_TOPIC}" class="gensmall">{L_VIEW_NEXT_TOPIC}</a><br />
	</span></td>
</tr>
</table>

<!-- INCLUDE pagination_box.tpl -->

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	{POLL_DISPLAY}
	<tr>
		<th class="thCornerL" width="150" nowrap="nowrap">{L_AUTHOR}</th>
		<th class="thCornerR" nowrap="nowrap">{L_MESSAGE}</th>
	</tr>
	<!-- BEGIN postrow -->
	<tr> 
		<td width="150" align="left" valign="top" class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->"><span class="name">
			<a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b>
		</span><br /><span class="postdetails">
			<!-- BEGIN rank -->{postrow.L_POSTER_RANK}<br /><!-- BEGIN img --><img src="{postrow.I_POSTER_RANK}" border="0" alt="{postrow.L_POSTER_RANK}" /><br /><!-- END img --><!-- END rank -->
			<!-- BEGIN avatar --><img src="{postrow.POSTER_AVATAR}" border="0" alt="" /><br /><!-- END avatar -->
			<br />
			<!-- BEGIN poster_joined -->{L_POSTER_JOINED}: {postrow.POSTER_JOINED}<br /><!-- END poster_joined -->
			<!-- BEGIN poster_posts -->{L_POSTER_POSTS}: {postrow.POSTER_POSTS}<br /><!-- END poster_posts -->
			<!-- BEGIN poster_from -->{L_POSTER_FROM}: {postrow.POSTER_FROM}<br /><!-- END poster_from -->
		</span><br /></td>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" width="100%" height="28" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%"><a href="{postrow.U_POST}" title="{postrow.L_POST}"><img src="{postrow.I_POST}" width="12" height="9" alt="{postrow.L_POST}" border="0" /></a><span class="postdetails">{L_POSTED}: {postrow.POST_DATE}<span class="gen">&nbsp;</span>&nbsp; &nbsp;{L_POST_SUBJECT}:
					<!-- BEGIN msg_icon --><img src="{postrow.msg_icon.I_ICON}" border="0" alt="" title="{postrow.msg_icon.L_ICON}" class="absbottom" />&nbsp;<!-- END msg_icon -->
					<!-- BEGIN sub_type --><!-- BEGIN img --><img src="{postrow.sub_type.I_SUB_TYPE}" border="0" alt="{postrow.sub_type.L_SUB_TYPE}" title="{postrow.sub_type.L_SUB_TYPE}" class="absbottom" /><!-- END img --><!-- BEGIN txt --><b>[{postrow.sub_type.L_SUB_TYPE}]</b><!-- END txt -->&nbsp;<!-- END sub_type -->
					{postrow.POST_SUBJECT}
					<!-- BEGIN sub_title --><br />{L_SUB_TITLE}: {postrow.sub_title.SUB_TITLE}<!-- END sub_title -->
					<!-- BEGIN announce --><br />{postrow.announce.S_ANNOUNCE}<!-- END announce -->
					<!-- BEGIN calendar_event --><br />{postrow.calendar_event.S_CALENDAR_EVENT}<!-- END calendar_event -->
				</span></td>
				<td nowrap="nowrap" valign="top" align="right">&nbsp;
					<!-- BEGIN quote --><a href="{postrow.U_QUOTE}" title="{L_POST_QUOTE}"><img src="{I_POST_QUOTE}" border="0" alt="{L_POST_QUOTE}" /></a>&nbsp;<!-- END quote -->
					<!-- BEGIN edit --><a href="{postrow.U_EDIT}" title="{L_POST_EDIT}"><img src="{I_POST_EDIT}" border="0" alt="{L_POST_EDIT}" /></a>&nbsp;<!-- END edit -->
					<!-- BEGIN delete --><a href="{postrow.U_DELETE}" title="{L_POST_DELETE}"><img src="{I_POST_DELETE}" border="0" alt="{L_POST_DELETE}" /></a>&nbsp;<!-- END delete -->
					<!-- BEGIN ip --><a href="{postrow.U_IP}" title="{L_POST_IP}"><img src="{I_POST_IP}" border="0" alt="{L_POST_IP}" /></a>&nbsp;<!-- END ip -->
					<!-- BEGIN unmark_read --><a href="{postrow.U_UNREAD_POST}"  title="{L_POST_UNREAD}"><img src="{I_POST_UNREAD}" border="0" alt="{L_POST_UNREAD}" /></a>&nbsp;<!-- END unmark_read -->
				</td>
			</tr>
			</table><hr />
			<span class="postbody">{postrow.MESSAGE}</span>
			{postrow.ATTACHMENTS}
			<!-- BEGIN signature --><span class="postbody"><br />_________________<br />{postrow.SIGNATURE}<br /></span><!-- END signature -->
			<!-- BEGIN edited --><span class="gensmall"><br />{postrow.EDITED_MESSAGE}<br /></span><!-- END edited -->
		</td>
	</tr>
	<tr>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" width="150" align="left" valign="middle"><span class="nav">
			<a href="#top" class="nav">{L_BACK_TO_TOP}</a>
		</span></td>
		<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" width="100%" height="28" valign="bottom" nowrap="nowrap">
			<table cellspacing="0" cellpadding="0" border="0"><tr>
				<td height="18" valign="top" nowrap="nowrap">
					<!-- BEGIN profile --><a href="{postrow.U_PROFILE}" title="{L_POSTER_PROFILE}"><img src="{I_POSTER_PROFILE}" border="0" alt="{L_POSTER_PROFILE}" /></a>&nbsp;<!-- END profile -->
					<!-- BEGIN pm --><a href="{postrow.U_PM}" title="{L_POSTER_PM}"><img src="{I_POSTER_PM}" border="0" alt="{L_POSTER_PM}" /></a>&nbsp;<!-- END pm -->
					<!-- BEGIN email --><a href="{postrow.U_EMAIL}" title="{L_POSTER_EMAIL}"><img src="{I_POSTER_EMAIL}" border="0" alt="{L_POSTER_EMAIL}" /></a>&nbsp;<!-- END email -->
					<!-- BEGIN www --><a href="{postrow.U_WWW}" title="{L_POSTER_WWW}" target="userwww"><img src="{I_POSTER_WWW}" border="0" alt="{L_POSTER_WWW}" /></a>&nbsp;<!-- END www -->
					<!-- BEGIN aim --><a href="{postrow.U_AIM}" title="{L_POSTER_AIM}"><img src="{I_POSTER_AIM}" border="0" alt="{L_POSTER_AIM}" /></a>&nbsp;<!-- END aim -->
					<!-- BEGIN yim --><a href="{postrow.U_YIM}" title="{L_POSTER_YIM}"><img src="{I_POSTER_YIM}" border="0" alt="{L_POSTER_YIM}" /></a>&nbsp;<!-- END yim -->
					<!-- BEGIN msn --><a href="{postrow.U_MSN}" title="{L_POSTER_MSN}"><img src="{I_POSTER_MSN}" border="0" alt="{L_POSTER_MSN}" /></a>&nbsp;<!-- END msn -->
				</td>
				<!-- BEGIN icq -->
				<td height="18" valign="top" nowrap="nowrap">
					<div style="position:relative"><a href="{postrow.U_ICQ}" title="{L_POSTER_ICQ}"><img src="{I_POSTER_ICQ}" border="0" alt="{L_POSTER_ICQ}" /></a>&nbsp;<div id="icq_status_{postrow.U_POST_ID}" style="position:absolute; left:3px; top:-1px; display:none"><a href="{postrow.U_ICQ_STATUS}" title=""><img src="{postrow.I_ICQ_STATUS}" width="18" height="18" border="0" alt="" /></a></div></div>
				</td>
				<!-- END icq -->
			</tr></table>
		</td>
	</tr>
	<tr> 
		<td class="spaceRow" colspan="2" height="1"><img src="{I_SPACER}" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END postrow -->
	<!-- BEGIN empty -->
	<tr>
		<td colspan="2" class="row1" height="35" align="center"><span class="gen">{L_EMPTY}
		</span></td>
	</tr>
	<tr>
		<td class="spaceRow" colspan="2" height="1"><img src="{I_SPACER}" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END empty -->
	<tr align="center"> 
		<td class="catBottom" colspan="2" height="28"><table cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td align="center"><form method="post" action="{S_POST_DAYS_ACTION}"><span class="gensmall">{L_DISPLAY_POSTS}:&nbsp;<select name="postdays">{POSTDAYS}</select>&nbsp;&nbsp;{L_SORT_BY}:&nbsp;<select name="sort">{SORT}</select>&nbsp;<select name="postorder">{POSTORDER}</select>&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" /></span></form></td>
			</tr>
		</table></td>
	</tr>
</table>

<!-- INCLUDE pagination_box.tpl -->

<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
	<td align="left" valign="top" nowrap="nowrap"><span class="nav">
		<a href="{U_NEW_TOPIC}" title="{L_NEW_TOPIC}"><img src="{I_NEW_TOPIC}" border="0" alt="{L_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_REPLY_TOPIC}" title="{L_REPLY_TOPIC}"><img src="{I_REPLY_TOPIC}" border="0" alt="{L_REPLY_TOPIC}" align="middle" /></a>
	</span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">
		<!-- BEGIN unread_topic --><a href="{U_UNREAD_TOPIC}" class="gensmall">{L_UNREAD_TOPIC}</a>&nbsp;::&nbsp;<!-- END unread_topic -->
		<a href="{U_VIEW_PREVIOUS_TOPIC}" class="gensmall">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEXT_TOPIC}" title="{L_VIEW_NEXT_TOPIC}" class="gensmall">{L_VIEW_NEXT_TOPIC}</a><br />
		<!-- BEGIN watch --><a href="{U_WATCH_TOPIC}" class="gensmall">{L_WATCH_TOPIC}</a><!-- END watch -->
	</span></td>
</tr>
</table>

{NAVIGATION_BOX}

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td width="40%" valign="top" nowrap="nowrap" align="left">
		<!-- BEGIN modcp --><a href="{modcp.U_ACTION}" title="{modcp.L_ACTION}"><img src="{modcp.I_ACTION}" border="0" alt="{modcp.L_ACTION}" /></a>&nbsp;<!-- END modcp -->
	</td>
	<td align="right" valign="top" nowrap="nowrap">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td nowrap="nowrap" align="right">{JUMPBOX}</td>
		</tr>
		</table>
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