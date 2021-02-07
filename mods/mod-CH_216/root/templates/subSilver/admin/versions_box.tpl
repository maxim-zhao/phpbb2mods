<table cellpadding="3" cellspacing="1" border="0" width="100%" class="forumline">
<tr>
	<th class="thHead">{L_VERSION_INFORMATION}</th>
</tr>
<!-- BEGIN author -->
<tr>
	<td class="row1"><span class="genmed">
	<!-- BEGIN link --><a href="{author.U_AUTHOR}" title="{L_AUTHOR}" target="_blank"><!-- END link --><b>{author.AUTHOR}</b><!-- BEGIN link --></a><!-- END link --><br /><br />
	<!-- BEGIN file -->
	<!-- BEGIN error -->{author.file.ERROR_MSG}<br /><!-- END error -->
	<!-- BEGIN app -->
	&nbsp;&nbsp;&nbsp;&bull;&nbsp;<!-- BEGIN page --><a href="{author.file.app.U_SITE}" title="{L_SITE}" target="_blank"><!-- END page --><b>{author.file.app.NAME}</b><!-- BEGIN page --></a><!-- END page -->
	<!-- BEGIN stable -->:&nbsp;<span style="color: green; font-weight: bold;">{L_STABLE}</span><!-- END stable -->
	<!-- BEGIN dev -->:&nbsp;<span style="color: blue; font-weight: bold;">{L_IN_DEV}</span><!-- END dev -->
	<!-- BEGIN obsolet -->:&nbsp;<span style="color: red; font-weight: bold;">{L_OBSOLET}</span><!-- END obsolet -->
	<!-- BEGIN undefined -->:&nbsp;<span style="color: brown; font-weight: bold;">{L_UNDEFINED}</span><!-- END undefined -->
	<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;{L_CURRENT_VERSION}:&nbsp;<span style="<!-- BEGIN stable -->color: green; <!-- END stable --><!-- BEGIN obsolet -->color: red; <!-- END obsolet --><!-- BEGIN dev -->color: blue; <!-- END dev --><!-- BEGIN undefined -->color: brown; <!-- END undefined -->font-weight: bold;">{author.file.app.CURRENT}</span><br />
	<!-- BEGIN refreshed -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;{L_STABLE_VERSION}:&nbsp;<span style="<!-- BEGIN stable -->color: green; <!-- END stable --><!-- BEGIN obsolet -->color: red; <!-- END obsolet -->font-weight: bold;">{author.file.app.STABLE}</span><br /><!-- END refreshed -->
	<!-- BEGIN in_dev -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;{L_IN_DEV_VERSION}:&nbsp;<span style="<!-- BEGIN dev -->color: blue; <!-- END dev --><!-- BEGIN undefined -->color: brown; <!-- END undefined -->font-weight: bold;">{author.file.app.IN_DEV}</span><br /><!-- END in_dev -->
	<br />
	<!-- BEGIN desc -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{author.file.app.DESC}<br /><!-- END desc -->
	<!-- BEGIN info -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{author.file.app.INFO}<br /><!-- END info -->
	<!-- END app -->
	<!-- END file -->
	</span></td>
</tr>
<tr>
	<td class="spaceRow" height="1"><img src="{I_SPACER}" border="0" height="1" alt="" /></td>
</tr>
<!-- END author -->
<tr>
	<td class="catBottom" align="center"><a href="{U_CHECK}" title="{L_CHECK}"><img src="{I_CHECK}" border="0" alt="{L_CHECK}" /></a></td>
</tr>
</table>