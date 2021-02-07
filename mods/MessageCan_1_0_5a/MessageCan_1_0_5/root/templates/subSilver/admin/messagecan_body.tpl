
<h1>{L_MESSAGECAN}</h1>

<p>{L_MESSAGECAN_DESC}</p>

&nbsp;&nbsp;&nbsp;<a href="{S_MSGACP_ADD}" class="cattitle">{L_ADD_MESSAGE}</a>

<br><BR>
<table cellspacing="1" cellpadding="1" border="0" align="center" class="forumline" width="98%">
	<tr>
	<th class="thCornerL" align="center">{L_MESSAGE}</th>
	<th class="thCornerR" align="center">{L_MESSAGE_TEXT}</th>
	<th class="thCornerR" align="center" width="10%">{L_ACTION}</th>
	</tr>
<!-- BEGIN messagecan -->
	<tr height="20">
		<td class="row1" align="center">{messagecan.MESSAGE_TITLE}</td>
		<td class="row2" align="center">{messagecan.MESSAGE_TEXT}</td>
		<td class="row3" align="center"><A HREF="{S_MSGACP_EDIT}&id={messagecan.MESSAGE_ID}" class="genmed">{L_EDIT_MESSAGE}</A>&nbsp;&nbsp;<A HREF="{S_MSGACP_DEL}&id={messagecan.MESSAGE_ID}" class="genmed">{L_DEL_MESSAGE}</A></td>
	</tr>
<!-- END messagecan -->
</table><BR>