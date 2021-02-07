<!-- BEGIN stats -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thHead" colspan="2">{L_VIEWONLINE}</th>
</tr>
<!-- BEGIN root -->
<tr>
	<td class="row1" width="50" align="center" valign="middle" rowspan="<!-- BEGIN extended -->4<!-- BEGINELSE extended -->3<!-- END extended -->">
		<a href="{U_VIEWONLINE}" class="cattitle"><img src="{I_VIEWONLINE}" border="0" alt="{L_VIEWONLINE}" title="{L_VIEWONLINE}" /></a>
	</td>
	<td class="row1" align="left"><span class="gensmall">
		{TOTAL_POSTS}<br />
		{TOTAL_USERS} :: {NEWEST_USER}<br />
		{RECORD_USERS}<br />
	</span></td>
</tr>
<!-- END root -->
<tr>
	<!-- BEGIN root_ELSE -->
	<td class="row1" width="50" align="center" valign="middle" rowspan="2">
		<a href="{U_VIEWONLINE}" class="cattitle"><img src="{I_VIEWONLINE}" border="0" alt="{L_VIEWONLINE}" title="{L_VIEWONLINE}" /></a>
	</td>
	<!-- END root_ELSE -->
	<td class="row1">
		<!-- BEGIN root --><span class="gensmall">{L_TOTAL_ONLINE}{TOTAL_USERS_ONLINE}</span><hr /><!-- END root -->
		<span class="gensmall">{L_ONLINE_USERS}&nbsp;<!-- BEGIN root_ELSE -->{TOTAL_USERS_ONLINE}<br /><!-- END root_ELSE --><!-- BEGIN online --><!-- BEGIN sep -->, <!-- END sep --><a href="{stats.online.U_VIEW_PROFILE}" title="{L_VIEW_PROFILE}" {stats.online.STYLE}>{stats.online.USERNAME}</a><!-- END online --><!-- BEGIN none -->{NO_USERS_ONLINE}<!-- END none -->
	</span></td>
</tr>
<!-- BEGIN past -->
<tr>
	<td class="row1" align="left"><span class="gensmall">
		{L_TOTAL_PAST}{TOTAL_PAST_USERS}<br />{TOTAL_HOUR_USERS}</span><hr /><span class="gensmall">
		{L_ONLINE_USERS}&nbsp;<!-- BEGIN online --><!-- BEGIN sep -->, <!-- END sep --><a href="{stats.past.online.U_VIEW_PROFILE}" title="{L_VIEW_PROFILE}" {stats.past.online.STYLE}>{stats.past.online.USERNAME}</a><!-- END online --><!-- BEGIN none -->{NO_USERS_ONLINE}<!-- END none -->
	</span></td>
</tr>
<!-- END past -->
<tr>
	<td class="row1"><span class="gensmall">
			<b>{L_GROUP_LEGEND} 
			<!-- BEGIN legend -->
			<!-- BEGIN color -->
			<a href="{stats.legend.U_GROUP}" title="{stats.legend.GROUP_DESCRIPTION}"{stats.legend.GROUP_COLOR}>{stats.legend.GROUP_NAME}</a>{stats.legend.color.L_COMMA}
			<!-- END color -->
			<!-- END legend -->
			</b>

	</span></td>
</tr>
</table>
<!-- END stats -->
