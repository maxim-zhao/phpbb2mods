<script type="text/javascript">
<!--
/**
* Mark/unmark checkboxes
* id = ID of parent container, name = name prefix, state = state [true/false]
* 
* Function taken from Olympus. All credit goes to the phpBB Group / phpBB3 dev team
*/
function marklist(id, name, state)
{
	var parent = document.getElementById(id);
	if (!parent)
	{
		eval('parent = document.' + id);
	}

	if (!parent)
	{
		return;
	}

	var rb = parent.getElementsByTagName('input');
	
	for (var r = 0; r < rb.length; r++)
	{
		if (rb[r].name.substr(0, name.length) == name)
		{
			rb[r].checked = state;
		}
	}
}
// -->
</script>

<form action="{S_FORM_ACTION}" method="post" id="list">

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="bottom"><span class="maintitle">{L_SEARCH_MATCHES}</span><br /></td>
  </tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
  <tr> 
	<th class="thCornerL" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
	<th class="thTop" nowrap="nowrap">&nbsp;{L_UNWATCH}&nbsp;</th>
	<th class="thCornerR" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
  </tr>
  <!-- BEGIN searchresults -->
  <tr> 
	<td class="row1"><span class="forumlink"><a href="{searchresults.U_VIEW_FORUM}" class="forumlink">{searchresults.FORUM_NAME}</a></span></td>
	<td class="row2"><span class="topictitle">{searchresults.NEWEST_POST_IMG}{searchresults.TOPIC_TYPE}<a href="{searchresults.U_VIEW_TOPIC}" class="topictitle">{searchresults.TOPIC_TITLE}</a></span><br /><span class="gensmall">{searchresults.GOTO_PAGE}</span></td>
	<td class="row1" align="center" valign="middle"><span class="name">{searchresults.TOPIC_AUTHOR}</span></td>
	<td class="row2" align="center" valign="middle"><span class="postdetails">{searchresults.REPLIES}</span></td>
	<td class="row1" align="center" valign="middle"><span class="postdetails">{searchresults.UNWATCH}</span></td>
	<td class="row2" align="center" valign="middle" nowrap="nowrap"><input type="checkbox" name="unwatch[]" value="{searchresults.ROW_ID}" /></td>
  </tr>
  <!-- END searchresults -->
  <tr> 
	<td class="catBottom" colspan="6" height="28" valign="middle">&nbsp; </td>
  </tr>
</table>

<div style="text-align: right; margin: 5px 15px 0px 15px;">
	<span class="gensmall"><a href="#" onclick="marklist('list', 'unwatch', true); return false;">{L_MARK_ALL}</a> :: <a href="#" onclick="marklist('list', 'unwatch', false); return false;">{L_UNMARK_ALL}</a> ::</span>
	{S_HIDDEN_FIELDS}
	<input type="submit" name="delete" value="{L_UNWATCH}" class="mainoption" />
</div>

<table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left" valign="top"><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="nav">{PAGINATION}</span><br /><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>

</form>
