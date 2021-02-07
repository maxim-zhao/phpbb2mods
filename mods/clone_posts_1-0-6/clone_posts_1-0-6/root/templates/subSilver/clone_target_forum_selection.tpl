<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">

<form method="post" name="group_list" action="{S_SELECT_FORUM_ACTION}" style="display: inline;">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
    <tr> 
 	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
    </tr>
  </table>
  <table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="catHead" colspan="2" align="center" height="28"><span class="cattitle">{L_FORUM_SELECTION}</span> 
	  </td>
	</tr>
	<tr> 
	  <td class="spaceRow" colspan="2" align="center"><span class="gensmall">{L_FORUM_SELECTION_EXPLAIN}</span></td>
	</tr>
	<tr> 
	  <th width="10%" class="thCornerL" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
	  <th width="90%" class="thCornerR" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
	</tr>
	<!-- BEGIN listrow -->
	<tr> 
	  <td width="10%" align="center" valign="middle" class="{listrow.ROW_CLASS}"><span class="postdetails"> 
		<input type="radio" name="forum_id" {listrow.S_DEFAULT_FORUM} value="{listrow.S_MARK_ID}" />
		</span></td>
	  <td width="90%" valign="middle" class="{listrow.ROW_CLASS}"><span class="topictitle">&nbsp;{listrow.U_FORUM_NAME}</span></td>
	</tr>
	<!-- END listrow -->

	<!-- BEGIN switch_include_option_to_post_using_name_of_original_poster -->
	<tr> 
	  <td class="catBottom" colspan="2" height="28" align="right"><span class="topictitle">{L_CLICK_TO_POST_IN_ORIGINAL_POSTER_NAME}&nbsp;&nbsp;</span><input type="checkbox" name="post_in_original_poster_name" {S_POST_IN_ORIGINAL_POSTER_NAME} value="TRUE" /></td>
	</tr>
	<!-- END switch_include_option_to_post_using_name_of_original_poster -->

	<tr> 
	  <td class="catBottom" colspan="2" height="28" align="right"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="cancel" value="{L_CANCEL_CLONE}" class="mainoption" /><input type="submit" name="clone" value="{L_CLONE_POST}" class="mainoption" />
	  </td>
	</tr>
  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
  	  <td align="left" valign="middle" width="100%"><span class="nav">{PAGE_NUMBER}</span></td>
	  <td align="right" valign="top" nowrap="nowrap"><b><span class="nav">{PAGINATION}<br /></span><span class="gensmall">{S_TIMEZONE}</span></b></td>

	</tr>
  </table>
</form>

<table width="100%" border="0">
  <tr> 
	<td align="right" valign="top">{JUMPBOX}</td>
  </tr>
</table>

</table>