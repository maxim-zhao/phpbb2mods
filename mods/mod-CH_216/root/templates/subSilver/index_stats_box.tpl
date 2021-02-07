<!-- BEGIN stats -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
<tr>
	<td class="catHead" colspan="2" height="28"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle">{L_VIEWONLINE}</a></span></td>
</tr>
<!-- BEGINGLOBAL root -->
<tr>
	<td class="row1" width="50" align="center" valign="middle" rowspan="<!-- BEGIN past -->4<!-- BEGINELSE past -->3<!-- END past -->">
		<img src="{I_VIEWONLINE}" border="0" alt="{L_VIEWONLINE}" title="{L_VIEWONLINE}" />
	</td>
	<td class="row1" align="left"><span class="gensmall">
		{TOTAL_POSTS}<br />
		{TOTAL_USERS} :: {L_NEWEST_USER}<a href="{U_NEWEST_USER}" title="{L_VIEW_PROFILE}" class="gensmall"{NEWEST_STYLE}><b>{NEWEST_USERNAME}</b></a><br />
		{RECORD_USERS}<br />
	</span></td>
</tr>
<tr>
<!-- BEGINELSEGLOBAL root -->
<tr>
	<td class="row1" width="50" align="center" valign="middle" rowspan="2">
		<img src="{I_VIEWONLINE}" border="0" alt="{L_VIEWONLINE}" />
	</td>
<!-- ENDGLOBAL root -->
	<td class="row1">
		<span class="gensmall"><!-- BEGINGLOBAL root -->{L_TOTAL_ONLINE}<!-- BEGINELSEGLOBAL root -->{L_BROWSING_USERS}&nbsp;<!-- ENDGLOBAL root -->{TOTAL_USERS_ONLINE}</span><hr />
		<span class="gensmall">{L_REGISTERED_USERS}&nbsp;<!-- BEGIN online --><!-- BEGIN row --><!-- BEGIN sep -->, <!-- END sep --><a href="{stats.online.row.U_VIEW_PROFILE}" title="{L_VIEW_PROFILE}" class="gensmall"{stats.online.row.STYLE}><!-- BEGIN hidden --><i><!-- END hidden -->{stats.online.row.USERNAME}<!-- BEGIN hidden --></i><!-- END hidden --></a><!-- BEGINELSE row -->{NO_USERS_ONLINE}<!-- END row --><!-- END online -->
	</span></td>
</tr>
<!-- BEGIN past -->
<tr>
	<td class="row1" align="left"><span class="gensmall">
		{L_TOTAL_PAST}{TOTAL_PAST_USERS}<br />{TOTAL_HOUR_SHORT}</span><hr /><span class="gensmall">
		{L_REGISTERED_USERS}&nbsp;<!-- BEGIN row --><!-- BEGIN sep -->, <!-- END sep --><a href="{stats.past.row.U_VIEW_PROFILE}" title="{L_VIEW_PROFILE}" class="gensmall"{stats.past.row.STYLE}><!-- BEGIN hidden --><i><!-- END hidden -->{stats.past.row.USERNAME}<!-- BEGIN hidden --></i><!-- END hidden --></a><!-- BEGINELSE row -->{NO_USERS_ONLINE}<!-- END row -->
	</span></td>
</tr>
<!-- END past -->
<tr>
	<td class="row1"><span class="gensmall">
		<b>{L_LEGEND}:</b>&nbsp;<!-- BEGIN legend -->[&nbsp;<!-- BEGIN link --><a href="{stats.legend.U_LEVEL}" class="gensmall"{stats.legend.STYLE}><!-- BEGINELSE link --><span {stats.legend.STYLE}><!-- END link --><b>{stats.legend.LEVEL_NAME}</b><!-- BEGIN link --></a><!-- BEGINELSE link --></span><!-- END link -->&nbsp;]<!-- END legend -->
	</span></td>
</tr>
</table>
<!-- END stats -->