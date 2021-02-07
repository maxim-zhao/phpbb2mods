<!-- BEGIN forum_header -->
<table border="0" cellpadding="4" cellspacing="1" width="100%">
<tr>
	<td><span class="maintitle">
		<a href="{forum_header.U_VIEW_FORUM}" title="{forum_header.FORUM_DESC}" class="maintitle">{forum_header.FORUM_NAME}</a>
	</span><span class="gensmall"><br />
		<!-- BEGIN moderators --><b>{L_MODERATORS}:&nbsp;</b><!-- BEGIN mod --><a href="{forum_header.moderators.mod.U_MOD}" title="{forum_header.moderators.mod.L_MOD_TITLE}" class="gensmall">{forum_header.moderators.mod.L_MOD}</a><!-- BEGIN sep -->, <!-- END sep --><!-- END mod --><!-- END moderators -->
	</span></td>
</tr>
</table>

<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
	<td valign="bottom" nowrap="nowrap"><a href="{U_POST_NEW_TOPIC}" title="{L_POST_NEW_TOPIC}"><img src="{I_POST_NEW_TOPIC}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
	<td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall">
		<!-- BEGIN mark --><img src="{forum_header.I_MARK_READ}" alt="{forum_header.L_MARK_READ}" title="{forum_header.L_MARK_READ}" border="0" hspace="2" /><a href="{forum_header.U_MARK_READ}" class="gensmall">{forum_header.L_MARK_READ}</a><br /><!-- END mark -->
	</span></td>
</tr>
</table>
<!-- END forum_header -->
<!-- INCLUDE pagination_box.tpl -->
<!-- INCLUDE topics_row_box.tpl -->
<!-- INCLUDE pagination_box.tpl -->
<!-- BEGIN forum_header -->
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
	<td valign="top" nowrap="nowrap"><a href="{U_POST_NEW_TOPIC}" title="{L_POST_NEW_TOPIC}"><img src="{I_POST_NEW_TOPIC}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="gensmall">
		<!-- BEGIN mark --><img src="{forum_header.I_MARK_READ}" alt="{forum_header.L_MARK_READ}" title="{forum_header.L_MARK_READ}" border="0" hspace="2" /><a href="{forum_header.U_MARK_READ}" class="gensmall">{forum_header.L_MARK_READ}</a><!-- END mark -->
	</span></td>
</tr>
</table>
<!-- END forum_header -->