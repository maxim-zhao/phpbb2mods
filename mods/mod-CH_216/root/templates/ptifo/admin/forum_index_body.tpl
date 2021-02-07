
<!-- BEGIN in_admin -->
<h1>{L_TITLE}</h1>

<p>{L_TITLE_EXPLAIN}</p>
<!-- END in_admin -->

{NAVIGATION_BOX}

<!-- BEGIN indexrow -->
<!-- BEGIN header -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
<tr>
	<th colspan="2" class="thCornerL" height="25" nowrap="nowrap" width="100%">&nbsp;{L_FORUM}&nbsp;</th>
	<th width="70" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th width="70" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th width="160" class="thCornerR" nowrap="nowrap">&nbsp;{L_ACTION}&nbsp;</th>
</tr>
<!-- END header -->

<!-- BEGIN cat -->
<!-- BEGIN row -->
<tr>
	<td class="row2" colspan="4" height="28">
		<!-- BEGIN forum_icon -->
		<table cellpadding="0" cellspacing="0" width="100%" border="0"><tr>
		<td><a href="{indexrow.cat.U_VIEWCAT}" class="cattitle"><img src="{indexrow.cat.FORUM_ICON}" border="0" alt="" title="" /></a></td><td><span class="gen">&nbsp;</span></td><td width="100%">
		<!-- END forum_icon -->
		<span class="cattitle"><a href="{indexrow.cat.U_VIEWCAT}" class="cattitle">{indexrow.cat.CAT_DESC}</a><br /></span>
		<span class="genmed">{indexrow.cat.DESC}<br /></span>
		<!-- BEGIN forum_icon -->
		</td></tr></table>
		<!-- END forum_icon -->
	</td>
	<td class="row2" align="center" valign="middle" nowrap="nowrap"><table cellpadding="0" cellspacing="0" border="0"><tr><td nowrap="nowrap"><span class="gensmall">
		<a href="{indexrow.cat.U_MOVE_UP}" title="{L_MOVE_UP}"><img src="{I_MOVE_UP}" border="0" alt="{L_MOVE_UP}" /></a>
		<a href="{indexrow.cat.U_EDIT}" title="{L_EDIT}"><img src="{I_EDIT}" border="0" alt="{L_EDIT}" /></a>
		<a href="{indexrow.cat.U_SYNCHRO}" title="{L_SYNCHRO}"><img src="{I_SYNCHRO}" border="0" alt="{L_SYNCHRO}" /></a>
		<br class="gen" />
		<a href="{indexrow.cat.U_MOVE_DOWN}" title="{L_MOVE_DOWN}"><img src="{I_MOVE_DOWN}" border="0" alt="{L_MOVE_DOWN}" /></a>
		<a href="{indexrow.cat.U_CREATE}" title="{L_CREATE}"><img src="{I_CREATE}" border="0" alt="{L_CREATE}" /></a>
		<a href="{indexrow.cat.U_DELETE}" title="{L_DELETE}"><img src="{I_DELETE}" border="0" alt="{L_DELETE}" /></a>
	</span></td></tr></table></td>
</tr>
<!-- END row -->
<!-- END cat -->

<!-- BEGIN forum -->
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
		<!-- BEGIN moderators --><span class="gensmall"><b>{L_MODERATORS}:&nbsp;</b><!-- BEGIN mod --><a href="{indexrow.forum.row.moderators.mod.U_MOD}" title="{indexrow.forum.row.moderators.mod.L_MOD_TITLE}" class="gensmall">{indexrow.forum.row.moderators.mod.L_MOD}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END mod --><br /></span><!-- END moderators -->
		<!-- BEGIN subforums --><span class="gensmall"><b>{L_SUBFORUMS}:&nbsp;</b><!-- BEGIN sub --><img src="{indexrow.forum.row.subforums.sub.I_SUB}" border="0" align="middle" alt="{indexrow.forum.row.subforums.sub.L_SUB_ALT}" title="{indexrow.forum.row.subforums.sub.L_SUB_ALT}" /><a href="{indexrow.forum.row.subforums.sub.U_SUB}" title="{indexrow.forum.row.subforums.sub.L_SUB_DESC}" class="gensmall">{indexrow.forum.row.subforums.sub.L_SUB}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END sub --><br /></span><!-- END subforums -->
		<!-- BEGIN forum_icon -->
		</td></tr></table>
		<!-- END forum_icon -->
	</td>
	<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{indexrow.forum.TOPICS}</span></td>
	<td class="row2" align="center" valign="middle" height="50"><span class="gensmall">{indexrow.forum.POSTS}</span></td>
	<td class="row1" align="center" valign="middle" nowrap="nowrap"><table cellpadding="0" cellspacing="0" border="0"><tr><td nowrap="nowrap"><span class="gensmall">
		<a href="{indexrow.forum.U_MOVE_UP}" title="{L_MOVE_UP}"><img src="{I_MOVE_UP}" border="0" alt="{L_MOVE_UP}" /></a>
		<a href="{indexrow.forum.U_EDIT}" title="{L_EDIT}"><img src="{I_EDIT}" border="0" alt="{L_EDIT}" /></a>
		<a href="{indexrow.forum.U_SYNCHRO}" title="{L_SYNCHRO}"><img src="{I_SYNCHRO}" border="0" alt="{L_SYNCHRO}" /></a>
		<br class="gen" />
		<a href="{indexrow.forum.U_MOVE_DOWN}" title="{L_MOVE_DOWN}"><img src="{I_MOVE_DOWN}" border="0" alt="{L_MOVE_DOWN}" /></a>
		<a href="{indexrow.forum.U_CREATE}" title="{L_CREATE}"><img src="{I_CREATE}" border="0" alt="{L_CREATE}" /></a>
		<a href="{indexrow.forum.U_DELETE}" title="{L_DELETE}"><img src="{I_DELETE}" border="0" alt="{L_DELETE}" /></a>
	</span></td></tr></table></td>
</tr>
<!-- END row -->
<!-- END forum -->

<!-- BEGIN link -->
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
		<!-- BEGIN subforums --><span class="gensmall"><b>{L_SUBFORUMS}:&nbsp;</b><!-- BEGIN sub --><img src="{indexrow.link.row.subforums.sub.I_SUB}" border="0" align="middle" alt="{indexrow.link.row.subforums.sub.L_SUB_ALT}" title="{indexrow.link.row.subforums.sub.L_SUB_ALT}" /><a href="{indexrow.link.row.subforums.sub.U_SUB}" title="{indexrow.link.row.subforums.sub.L_SUB_DESC}" class="gensmall">{indexrow.link.row.subforums.sub.L_SUB}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END sub --><br /></span><!-- END subforums -->
		<!-- BEGIN forum_icon -->
		</td></tr></table>
		<!-- END forum_icon -->
	</td>
	<td class="row2" align="center" valign="middle" height="50" colspan="2" width="140"><span class="gensmall">{indexrow.link.HITS}</span></td>
	<td class="row1" align="center" valign="middle" nowrap="nowrap"><table cellpadding="0" cellspacing="0" border="0"><tr><td nowrap="nowrap"><span class="gensmall">
		<a href="{indexrow.link.U_MOVE_UP}" title="{L_MOVE_UP}"><img src="{I_MOVE_UP}" border="0" alt="{L_MOVE_UP}" /></a>
		<a href="{indexrow.link.U_EDIT}" title="{L_EDIT}"><img src="{I_EDIT}" border="0" alt="{L_EDIT}" /></a>
		<a href="{indexrow.link.U_SYNCHRO}" title="{L_SYNCHRO}"><img src="{I_SYNCHRO}" border="0" alt="{L_SYNCHRO}" /></a>
		<br class="gen" />
		<a href="{indexrow.link.U_MOVE_DOWN}" title="{L_MOVE_DOWN}"><img src="{I_MOVE_DOWN}" border="0" alt="{L_MOVE_DOWN}" /></a>
		<a href="{indexrow.link.U_CREATE}" title="{L_CREATE}"><img src="{I_CREATE}" border="0" alt="{L_CREATE}" /></a>
		<a href="{indexrow.link.U_DELETE}" title="{L_DELETE}"><img src="{I_DELETE}" border="0" alt="{L_DELETE}" /></a>
	</span></td></tr></table></td>
</tr>
<!-- END row -->
<!-- END link -->

<!-- BEGIN empty -->
<tr>
	<td class="row1" colspan="5" height="30" align="center" valign="middle"><span class="gen">
		{L_EMPTY}
	</span></td>
</tr>
<!-- END empty -->

<!-- BEGIN footer -->
<!-- BEGIN command -->
<tr>
	<td class="catBottom" colspan="5" align="center" valign="middle">&nbsp;
		<!-- BEGIN buttons --><a href="{indexrow.footer.command.buttons.U_BUTTON}" title="{indexrow.footer.command.buttons.L_BUTTON}" accesskey="{indexrow.footer.command.buttons.S_BUTTON}"><img src="{indexrow.footer.command.buttons.I_BUTTON}" border="0" alt="{indexrow.footer.command.buttons.L_BUTTON}" /></a>&nbsp;<!-- END buttons -->
	</td>
</tr>
<!-- END command -->
</table>
<!-- END footer -->
<!-- BEGIN spacing -->
<br class="nav" />
<!-- END spacing -->
<!-- END indexrow -->

{NAVIGATION_BOX}

<br clear="all" />
