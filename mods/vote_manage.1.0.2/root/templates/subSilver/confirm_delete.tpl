<form action="{S_CONFIRM_ACTION}" method="post">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td class="nav" align="left"><a class="nav" href="{U_INDEX}">{L_INDEX}</a></td>
	</tr>
</table>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0">
	<tr>
		<th class="thHead" height="25" valign="middle"><span class="tableTitle">{MESSAGE_TITLE}</span></th>
	</tr>
	<tr>
		<td class="row1" align="center"><span class="gen"><br /></span>
		<ul class="genmed" style="list-style-type: none; text-align: left;">
		  <li><b>{USERNAME}</b>
		    <ol class="genmed">
		      <!-- BEGIN options -->
		      <li>{options.OPTION}</li>
		      <!-- END options -->
			</ol>
		  </li>
		</ul>
		<br /><br />{S_HIDDEN_FIELDS}<input type="submit" name="confirm" value="{L_YES}" class="mainoption" />&nbsp;&nbsp;<input type="submit" name="cancel" value="{L_NO}" class="liteoption" /></td>
	</tr>
</table>
</form>
<br clear="all" />
