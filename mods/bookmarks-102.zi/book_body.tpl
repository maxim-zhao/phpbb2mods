<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
		<td align="left" valign="middle" width="100%">
			<span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a>&nbsp;->&nbsp;{L_BOOK}</span>
		</td>
	</tr>
</table>

<table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
  <tr>
    <th colspan="2" height="25" class="thCornerL" align="center">&nbsp;{L_TOPIC}&nbsp;</th>
    <th width="50" class="thTop" align="center">&nbsp;{L_REPLIES}&nbsp;</th>
    <th width="50" class="thTop" align="center">&nbsp;{L_VIEWS}&nbsp;</th>
    <th width="50" class="thCornerR" align="center">&nbsp;{L_DELETE}&nbsp;</th>
    </tr>
<!-- BEGIN topicrow -->
  <tr> 
    <td class="row1" valign="middle" align="center" width="20"><img src="{topicrow.S_FOLDER}" width="19" height="18" alt="{topicrow.S_FOLDER_ALT}" title="{topicrow.S_FOLDER_ALT}" /></td>
    <td class="row1" valign="middle" width="100%"><span class="forumlink">{topicrow.S_FOLDER_TEXT}&nbsp;<a href="{topicrow.U_TOPIC_TITLE}">{topicrow.L_TOPIC_TITLE}</a></span></td>    <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.S_REPLIES}</span></td>
    <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.S_VIEWS}</span></td>
    <td class="row3" align="center" valign="middle">
	<form method="post" action="{topicrow.U_FORM}">
		<input type="hidden" name="mode" value="remove" />
		<input type="hidden" name="t" value="{topicrow.U_TOPIC}" />
		<input type="hidden" name="sid" value="{topicrow.U_SID}" />
		<input type="submit" value="{topicrow.L_REMOVE}" class="liteoption" />
	</form>
    </td>
     </tr>
<!-- END topicrow -->
<!-- BEGIN no_bookmarks -->
  <tr> 
    <td class="row1" valign="middle" align="center" width="20" colspan="5"><span class="gen">{no_bookmarks.L_NO_BOOK}</span></td>
  </tr>
<!-- END no_bookmarks -->
  <tr> 
	<td class="catBottom" align="center" valign="middle" colspan="5" height="28">&nbsp;</td>
  </tr>
</table>
