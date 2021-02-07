<table width="100%" cellspacing="2" cellpadding="2" border="0">
	<tr>
		<td align="left" valign="bottom"><a href="{NEWSLETTER_LINK}" class="maintitle">{NEWSLETTER_TITLE}</a></td>
	</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="2" border="0">
	<tr>
		<td><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{U_PHPMN}" class="nav">{L_PHPMN}</a> -> <a href="{NEWSLETTER_LINK}" class="nav">{NEWSLETTER_TITLE}</a></span></td>
	</tr>
</table>
<table width="100%" cellspacing=1 cellpadding=1 border=1 align="center" class="forumline">
	<th>{L_PHPMN_DATE}</th><th>{L_PHPMN_SUBJECT}</th><th>&nbsp;&nbsp;{L_PHPMN_SELECT}&nbsp;&nbsp;</th>
<!-- BEGIN list -->
	<tr valign="top">
		<td align="center" nowrap class="row1"><span class="postbody">{list.DATE}</span></td>
		<td class="row1" align="left" width="100%"><span class="gen"><b>{list.SUBJECT}</span></b></td>
		<td class="row3" align="center"><a href="{list.SELECT}"><img src="{SELECT_IMG}" alt="{L_SELECT_IMG}" title="{L_SELECT_IMG}" border="0"></a></td>
	</tr>
<!-- END list -->
<!-- BEGIN noarchive -->
	<tr>
		<td class="row1">{noarchive.NOARCHIVE}</td>
	</tr>
<!-- END noarchive -->
</table>
