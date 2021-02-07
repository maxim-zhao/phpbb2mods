<p />
<span class="maintitle">{THIS_PAGE_NAME}</span>
<p />
<span class="genmed">{THIS_PAGE_EXPLAIN}</span>
<p />
<form method="post" action="{S_ACTION}">
<table width="98%" align="center" cellpadding="2" cellspacing="2" border="0" class="forumline">
<tr>
	<th colspan="2" class="thHead">{L_EDIT}</th>
</tr>
<!-- first edit field -->
<tr>
	<td class="row1"><span class="genmed"><b>{L_PAGE_ID}</b></span></td>
	<td class="row2">{PAGE_ID}</td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_PAGE_NAME}</b></span></td>
	<td class="row2"><input type="text" class="post" name="page_name" size="32" maxlength="255" value="{PAGE_NAME}" /></td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_PAGE_PARM_NAME}</b></span><br /><span class="gensmall">{L_PAGE_PARM_NAME_EXPLAIN}</span></td>
	<td class="row2" valign="top"><input type="text" class="post" name="page_parm_name" size="32" maxlength="255" value="{PAGE_PARM_NAME}" /></td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_PAGE_PARM_VALUE}</b></span></td>
	<td class="row2"><input type="text" class="post" name="page_parm_value" size="32" maxlength="255" value="{PAGE_PARM_VALUE}" /></td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_MEMBER_VIEWS}</b></span><br /><span class="gensmall">{L_MEMBER_VIEWS_EXPLAIN}</span></td>
	<td class="row2" valign="top"><input type="text" class="post" size="10" name="member_views" value="{MEMBER_VIEWS}" /></td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_GUEST_VIEWS}</b></span><br /><span class="gensmall">{L_GUEST_VIEWS_EXPLAIN}</span></td>
	<td class="row2" valign="top"><input type="text" class="post" size="10" name="guest_views" value="{GUEST_VIEWS}" /></td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_DISABLE_PAGE}</b></span><br /><span class="gensmall">{L_DISABLE_PAGE_EXPLAIN}</span></td>
	<td class="row2" valign="top">{CB_DISABLE_PAGE}</td>
</tr>
<tr>
	<td class="row1" valign="top"><span class="genmed"><b>{L_PAGE_DISABLED_MESSAGE}</b></span><br /><span class="gensmall">{L_PAGE_DISABLED_MESSAGE_EXPLAIN}</span></td>
	<td class="row2" valign="top"><textarea class="post" name="disabled_message" rows="6" cols="45" wrap="virtual">{DISABLED_MESSAGE}</textarea></td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_AUTH_LEVEL}</b></span></td>
	<td class="row2">{S_AUTH_LEVEL_SELECTOR}</td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_MIN_POST_COUNT}</b></span><br /><span class="gensmall">{L_MIN_POST_COUNT_EXPLAIN}</span></td>
	<td class="row2" valign="top"><input type="text" class="post" size="10" name="min_post_count" value="{MIN_POST_COUNT}" /></td>
</tr>
<tr>
	<td class="row1"><span class="genmed"><b>{L_MAX_POST_COUNT}</b></span><br /><span class="gensmall">{L_MAX_POST_COUNT_EXPLAIN}</span></td>
	<td class="row2" valign="top"><input type="text" class="post" size="10" name="max_post_count" value="{MAX_POST_COUNT}" /></td>
</tr>
<!-- BEGIN switch_group_selector -->
<tr>
	<td class="row1" valign="top"><span class="genmed"><b>{L_PAGE_GROUP}</b></span><br /><span class="genmed">{L_PAGE_GROUP_EXPLAIN}</span></td>
	<td class="row2">{S_PAGE_GROUP_SELECTOR}</td>
</tr>
<!-- END switch_group_selector -->
<!-- last edit field -->
<tr>
	<td colspan="2" align="center" class="catBottom">{S_HIDDEN_FIELDS}<input type="submit" name="save" value="{L_SUBMIT}" class="mainoption" /></td>
</tr>
</table>
</form>
<p />

