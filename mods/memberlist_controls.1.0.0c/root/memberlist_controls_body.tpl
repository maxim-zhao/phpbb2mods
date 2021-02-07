
<h1>{THIS_PAGE_NAME}</h1>

<p>{THIS_PAGE_EXPLAIN}</p>

<form action="{S_ACTION}" method="post">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
<tr>
	<td class="row1">{L_ACTIVE_REQUIRED}<br /><span class="gensmall">{L_ACTIVE_REQUIRED_EXPLAIN}</span></td>
	<td class="row2"><input class="post" type="text" maxlength="10" size="10" name="phpbbdoctor_memberlist_active_required" value="{PHPBBDOCTOR_MEMBERLIST_ACTIVE_REQUIRED}" /></td>
</tr>
<tr>
	<td class="row1">{L_MIN_POSTS_REQUIRED}<br /><span class="gensmall">{L_MIN_POSTS_REQUIRED_EXPLAIN}</span></td>
	<td class="row2"><input class="post" type="text" maxlength="10" size="10" name="phpbbdoctor_memberlist_min_posts_required" value="{PHPBBDOCTOR_MEMBERLIST_MIN_POSTS_REQUIRED}" /></td>
</tr>
<tr>
	<td class="row1">{L_DAYS_SINCE_LAST_VISIT_REQUIRED}<br /><span class="gensmall">{L_DAYS_SINCE_LAST_VISIT_REQUIRED_EXPLAIN}</span></td>
	<td class="row2"><input class="post" type="text" maxlength="10" size="10" name="phpbbdoctor_memberlist_days_since_last_visit_required" value="{PHPBBDOCTOR_MEMBERLIST_DAYS_SINCE_LAST_VISIT_REQUIRED}" /></td>
</tr>
<tr>
	<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" /></td>
</tr>
</table>
<input type="hidden" name="mode" value="save" />
</form>
