<script language="Javascript" type="text/javascript">
	//
	// Should really check the browser to stop this whining ...
	//
	function select_switch(status)
	{
		$number_of_groups = document.group_list.length - 5;

		<!-- BEGIN switch_include_text_checkbox -->
		// if this is for emailing a post (which is the case if switch_include_text_checkbox is on), 
		// change the number of groups since the post emailing template has 3 more rows than the regular mass email template
		$number_of_groups = document.group_list.length - 8;
		<!-- END switch_include_text_checkbox -->

		for (i = 1; i < $number_of_groups; i++)
		{
			document.group_list.elements[i].checked = status;
		}
	}
</script>

<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">

<form method="post" name="group_list" action="{S_DESIGNATED_GROUPS_CP_ACTION}" style="display: inline;">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
    <tr> 
 	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
    </tr>
  </table>
  <table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <td class="catHead" colspan="2" align="center" height="28"><span class="cattitle">{L_DESIGNATED_GROUPS_CP}</span> 
	  </td>
	</tr>
	<tr> 
	  <td class="spaceRow" colspan="2" align="center"><span class="gensmall">{L_DESIGNATED_GROUPS_CP_EXPLAIN}</span></td>
	</tr>
	<tr> 
	  <th width="10%" align="center" class="thCornerL" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
	  <th width="90%" align="left" class="thCornerR" nowrap="nowrap">&nbsp;{L_GROUPS}&nbsp;</th>
	</tr>
	<!-- BEGIN listrow -->
	<tr> 
	  <td width="10%" align="center" valign="middle" class="{listrow.ROW_CLASS}"><span class="postdetails"> 
		<input type="checkbox" name="mark[]" {listrow.S_DEFAULT_DESIGNATED_GROUPS} value="{listrow.S_MARK_ID}" />
		</span></td>
	  <td width="90%" align="left" valign="middle" class="{listrow.ROW_CLASS}"><span class="topictitle"><b>&nbsp;{listrow.U_GROUP_NAME}</b></span></td>
	</tr>
	<!-- END listrow -->

	<!-- BEGIN switch_include_text_checkbox -->
	  <tr> 
		<td width="10">&nbsp;</td>
		<td width="90%" align="left" valign="middle"><span class="topictitle">&nbsp;{L_EMAIL_RE}<br /></span><span class="genmed">&nbsp;<input type="text" name="email_re" size="125" maxlength="200" class="post" value="{S_SUBJECT}" /></span></td>
	  </tr>
	  
	  <tr> 
		<td width="10">&nbsp;</td>
		<td width="90%" align="left" valign="middle"><span class="topictitle">{L_NO_UNAUTHORIZED_USERS_INCLUDED}<br /></span></td>
		<td></td>
	  </tr>
	  
	  <tr> 
		<td width="10%" align="center" valign="middle"><span class="postdetails">
			<input type="checkbox" name="include_text" {S_INCLUDE_TEXT} />
			</span></td>
		<td width="90%" align="left" valign="middle"><span class="topictitle">&nbsp;{L_INCLUDE_TEXT}</span></td>
	  </tr>
	  
	<!-- END switch_include_text_checkbox -->

	<!-- BEGIN switch_include_unauthorized_users_checkbox -->
	  <tr> 
		<td width="10%" align="center" valign="middle"><span class="postdetails">
			<input type="checkbox" name="include_unauthorized_users" {S_INCLUDE_UNAUTHORIZED_USERS} />
			</span></td>
		<td width="90%" align="left" valign="middle"><span class="topictitle">&nbsp;{L_INCLUDE_UNAUTHORIZED_USERS}</span></td>
	  </tr>
	<!-- END switch_include_unauthorized_users_checkbox -->

	<!-- BEGIN switch_include_board_signs_checkbox -->
	  <tr> 
		<td width="10%" align="center" valign="middle"><span class="postdetails">
			<input type="checkbox" name="board_signs" {S_BOARD_SIGNS} />
			</span></td>
		<td width="90%" align="left" valign="middle"><span class="topictitle"><b>&nbsp;{L_BOARD_SIGNS}</b></span></td>
	  </tr>	
	<!-- END switch_include_board_signs_checkbox -->

	<tr> 
	  <td class="catBottom" colspan="2" height="28" align="right"> {S_HIDDEN_FIELDS} 
		<input type="submit" name="cancel_email" value="{L_CANCEL_EMAIL}" class="mainoption" /><input type="submit" name="designated" value="{L_DESIGNATE}" class="mainoption" />
	  </td>
	</tr>
  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
  	  <td align="left" valign="middle" width="100%"><span class="nav">{PAGE_NUMBER}</span></td>
	  <td align="right" valign="top" nowrap="nowrap"><b><span class="gensmall"><a href="javascript:select_switch(true);" class="gensmall">{L_MARK_ALL_GROUPS}</a> :: <a href="javascript:select_switch(false);" class="gensmall">{L_UNMARK_ALL_GROUPS}</a></span></b><br /><span class="nav">{PAGINATION}<br /></span><span class="gensmall">{S_TIMEZONE}</span></td>

	</tr>
  </table>
</form>

<table width="100%" border="0">
  <tr> 
	<td align="right" valign="top">{JUMPBOX}</td>
  </tr>
</table>