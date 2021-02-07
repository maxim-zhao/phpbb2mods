<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
<tr>
	<td align="left" valign="bottom"><span class="gensmall">
		<!-- BEGIN switch_user_logged_in -->
		{LAST_VISIT_DATE}<br />
		<!-- END switch_user_logged_in -->
		{CURRENT_TIME}<br />
		{S_TIMEZONE}
	</span></td>
	<td align="right" valign="bottom">
		<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br />
		<!-- BEGIN switch_user_logged_in -->
		<a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
		<!-- END switch_user_logged_in -->
		<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a>
	</td>
</tr>
</table>
<br class="nav" />

{BOARD_TOPICS}
<!-- BEGIN board_topics_spacing --><br class="nav" /><!-- END board_topics_spacing -->

<form method="post" action="{S_ACTION}">
{NAVIGATION_BOX}

<!-- BEGIN indexrow -->
<!-- BEGIN header -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
<tr>
	<th colspan="2" class="thCornerL" height="25" nowrap="nowrap" width="100%">&nbsp;{L_FORUM}&nbsp;</th>
	<th width="70" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th width="70" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th width="200" class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
</tr>
<!-- END header -->

<!-- BEGIN cat -->
<!-- BEGIN header -->
<!-- END header -->
<!-- BEGIN row -->
<tr>
	<td class="catLeft" colspan="2" height="28"><span class="cattitle">
		<a href="{indexrow.cat.U_VIEWCAT}" class="cattitle">{indexrow.cat.CAT_DESC}</a>
	</span></td>
	<td class="rowpic" colspan="3" align="right">&nbsp;</td>
</tr>
<!-- END row -->
<!-- BEGIN footer -->
<!-- END footer -->
<!-- END cat -->

<!-- BEGIN forum -->
<!-- BEGIN header -->
<!-- END header -->
<!-- BEGIN row -->
<tr>
	<td class="row1" align="center" valign="middle" width="50" height="50">
		<img src="{indexrow.forum.I_FORUM_FOLDER}" border="0" alt="{indexrow.forum.L_FORUM_FOLDER}" title="{indexrow.forum.L_FORUM_FOLDER}" />
	</td>
	<td class="row1" height="50" width="100%">
		<!-- BEGIN forum_icon -->
		<table cellpadding="0" cellspacing="0" width="100%" border="0"><tr>
		<td><a href="{indexrow.forum.U_VIEWFORUM}" class="forumlink"><img src="{indexrow.forum.FORUM_ICON}" border="0" alt="" title="" /></a></td><td><span class="gen">&nbsp;</span></td><td width="100%">
		<!-- END forum_icon -->
		<span class="forumlink"><a href="{indexrow.forum.U_VIEWFORUM}" class="forumlink">{indexrow.forum.FORUM_NAME}</a><br /></span>
		<span class="genmed">{indexrow.forum.FORUM_DESC}<br /></span>
		<!-- BEGIN moderators -->
		<span class="gensmall">
			<b>{L_MODERATORS}:&nbsp;</b><!-- BEGIN mod --><a href="{indexrow.forum.row.moderators.mod.U_MOD}" title="{indexrow.forum.row.moderators.mod.L_MOD_TITLE}" class="gensmall">{indexrow.forum.row.moderators.mod.L_MOD}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END mod -->
		<br /></span>
		<!-- END moderators -->
		<!-- BEGIN subforums -->
		<span class="gensmall">
			<b>{L_SUBFORUMS}:</b>&nbsp;<!-- BEGIN sub --><img src="{indexrow.forum.row.subforums.sub.I_SUB}" border="0" alt="{indexrow.forum.row.subforums.sub.L_SUB_ALT}" title="{indexrow.forum.row.subforums.sub.L_SUB_ALT}" />&nbsp;<a href="{indexrow.forum.row.subforums.sub.U_SUB}" title="{indexrow.forum.row.subforums.sub.L_SUB_DESC}" class="gensmall">{indexrow.forum.row.subforums.sub.L_SUB}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END sub -->
		<br /></span>
		<!-- END subforums -->
		<!-- BEGIN forum_icon -->
		</td></tr></table>
		<!-- END forum_icon -->
	</td>
	<!-- BEGIN auth_read -->
	<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{indexrow.forum.TOPICS}</span></td>
	<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{indexrow.forum.POSTS}</span></td>
	<td class="row3Right" align="center" valign="middle" height="50" nowrap="nowrap"><span class="gensmall">
		<!-- BEGIN last_post -->
		<a href="{indexrow.forum.U_LAST_TOPIC}" class="gensmall" title="{indexrow.forum.LAST_TOPIC_TITLE_ALT}">{indexrow.forum.LAST_TOPIC_TITLE}</a><br />
		{indexrow.forum.LAST_POST_TIME}<br />
		<!-- BEGIN userlink --><a href="{indexrow.forum.U_LAST_POSTER}" class="gensmall" title="{L_LAST_POSTER}"><!-- END userlink -->{indexrow.forum.LAST_POSTER}<!-- BEGIN userlink --></a><!-- END userlink -->
		&nbsp;<a href="{indexrow.forum.U_LAST_POST}" class="gensmall" title="{L_LAST_POST}"><img src="{I_LAST_POST}" border="0" alt="{L_LAST_POST}" /></a><br />
		<!-- BEGINELSE last_post -->
		{L_NO_POSTS}
		<!-- END last_post -->
	</span></td>
	<!-- BEGINELSE auth_read -->
	<td class="row3Right" colspan="3" align="center"><span class="gensmall">
		{L_AUTH_REQ}
	</span></td>
	<!-- END auth_read -->
</tr>
<!-- END row -->
<!-- BEGIN footer -->
<!-- END footer -->
<!-- END forum -->

<!-- BEGIN link -->
<!-- BEGIN header -->
<!-- END header -->
<!-- BEGIN row -->
<tr>
	<td class="row1" align="center" valign="middle" height="50" width="50">
		<img src="{indexrow.link.I_FORUM_FOLDER}" border="0" alt="{indexrow.link.L_FORUM_FOLDER}" title="{indexrow.link.L_FORUM_FOLDER}" />
	</td>
	<td class="row1" height="50" width="100%">
		<!-- BEGIN forum_icon -->
		<table cellpadding="0" cellspacing="0" width="100%" border="0"><tr>
		<td><a href="{indexrow.link.U_VIEWFORUM}" class="forumlink"><img src="{indexrow.link.FORUM_ICON}" border="0" alt="" title="" /></a></td><td><span class="gen">&nbsp;</span></td><td width="100%">
		<!-- END forum_icon -->
		<span class="forumlink"><a href="{indexrow.link.U_VIEWFORUM}" class="forumlink">{indexrow.link.FORUM_NAME}</a><br /></span>
		<span class="genmed">{indexrow.link.FORUM_DESC}<br /></span>
		<!-- BEGIN subforums -->
		<span class="gensmall">
			<b>{L_SUBFORUMS}:</b>&nbsp;<!-- BEGIN sub --><img src="{indexrow.link.row.subforums.sub.I_SUB}" border="0" alt="{indexrow.link.row.subforums.sub.L_SUB_ALT}" title="{indexrow.link.row.subforums.sub.L_SUB_ALT}" />&nbsp;<a href="{indexrow.link.row.subforums.sub.U_SUB}" title="{indexrow.link.row.subforums.sub.L_SUB_DESC}" class="gensmall">{indexrow.link.row.subforums.sub.L_SUB}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END sub -->
		<br /></span>
		<!-- END subforums -->
		<!-- BEGIN forum_icon -->
		</td></tr></table>
		<!-- END forum_icon -->
	</td>
	<td class="row3Right" align="center" valign="middle" height="50" colspan="3" width="340"><span class="gensmall">
		{indexrow.link.HITS}
	</span></td>
</tr>
<!-- END row -->
<!-- BEGIN footer -->
<!-- END footer -->
<!-- END link -->

<!-- BEGIN footer -->
</table>
<!-- END footer -->
<!-- BEGIN spacing --><br class="nav" /><!-- END spacing -->
<!-- END indexrow -->

<!-- BEGIN forums_spacing --><br class="nav" /><!-- END forums_spacing -->

{FORUM_TOPICS}

{NAVIGATION_ONLY_BOX}
</form>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
	<td nowrap="nowrap" align="right">{JUMPBOX}</td>
</tr>
</table>
<br />

{STATS_BOX}

<!-- BEGIN switch_user_logged_out -->
<br class="nav" />
<form method="post" action="{S_LOGIN_ACTION}"><table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
<tr>
	<td class="catHead" height="28"><a name="login"></a><span class="cattitle">{L_LOGIN_LOGOUT}</span></td>
</tr>
<tr> 
	<td class="row1" align="center" valign="middle" height="28"><span class="gensmall">
		{L_USERNAME}: <input class="post" type="text" name="username" size="10" />&nbsp;&nbsp;&nbsp;
		{L_PASSWORD}: <input class="post" type="password" name="password" size="10" maxlength="32" />&nbsp;&nbsp;&nbsp;&nbsp;
		<!-- BEGIN switch_allow_autologin -->
		{L_AUTO_LOGIN} <input class="text" type="checkbox" name="autologin" />&nbsp;&nbsp;&nbsp;
		<!-- END switch_allow_autologin -->
		<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
	</span> </td>
</tr>
</table></form>
<!-- END switch_user_logged_out -->

<!-- BEGINGLOBAL forum_legend -->
<br class="nav" />
<table cellspacing="3" border="0" align="center" cellpadding="0">
<tr>
	<td width="20" align="center"><img src="{FORUM_NEW_IMG}" alt="{L_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="{FORUM_IMG}" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="{FORUM_LOCKED_IMG}" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="{FORUM_LINK_IMG}" alt="{L_FORUM_LINK}" /></td>
	<td><span class="gensmall">{L_FORUM_LINK}</span></td>
</tr>
</table>
<!-- BEGINELSEGLOBAL forum_legend -->
<br class="nav" />
<table width="100%" cellspacing="0" border="0" align="center" cellpadding="0">
<tr>
	<td align="left" valign="top"><table cellspacing="3" cellpadding="0" border="0">
	<tr>
		<td width="20" align="left"><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" /></td>
		<td class="gensmall">{L_NEW_POSTS}</td>
		<td>&nbsp;&nbsp;</td>
		<td width="20" align="center"><img src="{FOLDER_ANNOUNCE_IMG}" alt="{L_ANNOUNCEMENT}" /></td>
		<td class="gensmall">{L_ANNOUNCEMENT}</td>
	</tr>
	<tr>
		<td width="20" align="center"><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" /></td>
		<td class="gensmall">{L_NO_NEW_POSTS}</td>
		<td>&nbsp;&nbsp;</td>
		<td width="20" align="center"><img src="{FOLDER_STICKY_IMG}" alt="{L_STICKY}" /></td>
		<td class="gensmall">{L_STICKY}</td>
	</tr>
	<tr>
		<td width="20" align="center"><img src="{FOLDER_HOT_IMG}" alt="{L_TOPIC_HOT}" /></td>
		<td class="gensmall">{L_TOPIC_HOT}</td>
		<td>&nbsp;&nbsp;</td>
		<td width="20" align="center"><img src="{FOLDER_CALENDAR_IMG}" alt="{L_CALENDAR}" /></td>
		<td class="gensmall">{L_TOPIC_CALENDAR}</td>
	</tr>
	<tr>
		<td width="20" align="center"><img src="{FOLDER_LOCKED_IMG}" alt="{L_TOPIC_LOCKED}" /></td>
		<td class="gensmall">{L_TOPIC_LOCKED}</td>
		<td>&nbsp;&nbsp;</td>
		<td width="20" align="center"><img src="{FOLDER_MOVED_IMG}" alt="{L_TOPIC_MOVED}" /></td>
		<td class="gensmall">{L_TOPIC_MOVED}</td>
	</tr>
	<tr>
		<td width="20" align="center"><img src="{FOLDER_OWN_IMG}" alt="{L_TOPIC_OWN}" /></td>
		<td class="gensmall" colspan="4">{L_TOPIC_OWN}</td>
	</tr>
	</table></td>
	<td align="right"><span class="gensmall">
		<!-- BEGIN rules --><!-- BEGIN row -->{rules.row.S_RULE}<br /><!-- END row --><!-- BEGINELSE rules -->&nbsp;<!-- END rules -->
	</span></td>
</tr>
</table>
<!-- ENDGLOBAL forum_legend -->

<br clear="all" />