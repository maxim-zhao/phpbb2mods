<p />
<span class="maintitle">{THIS_PAGE_NAME}</span>
<p />
<span class="genmed">{THIS_PAGE_EXPLAIN}</span>
<p />
<form method="post" action="{S_ACTION}">
<table width="98%" align="center" cellpadding="2" cellspacing="2" border="0" class="forumline">
<tr>
	<th class="thCornerL">{L_PAGE_NAME}</th>
	<th class="thTop">{L_GUEST_VIEWS}</th>
	<th class="thTop">{L_GUEST_VIEWS_PCT}</th>
	<th class="thTop">{L_MEMBER_VIEWS}</th>
	<th class="thTop">{L_MEMBER_VIEWS_PCT}</th>
	<th class="thTop">{L_PAGE_VIEWS}</th>
	<th class="thTop">{L_PAGE_VIEWS_PCT}</th>
	<th class="thTop">{L_DISABLE_PAGE}</th>
	<th class="thTop">{L_AUTH_LEVEL}</th>
	<th class="thTop">{L_MIN_POST_COUNT}</th>
	<th class="thTop">{L_MAX_POST_COUNT}</th>
	<th  class="thCornerR" colspan="2">{L_ACTION}</th>
</tr>
<!-- BEGIN rowdata -->
<tr>
	<td class="{rowdata.ROW_CLASS}"><span class="genmed">{rowdata.PAGE_NAME}</td>
	<td class="{rowdata.ROW_CLASS}" align="right"><span class="genmed">{rowdata.GUEST_VIEWS}</td>
	<td class="{rowdata.ROW_CLASS}" align="right"><span class="genmed">{rowdata.GUEST_VIEWS_PCT}%</td>
	<td class="{rowdata.ROW_CLASS}" align="right"><span class="genmed">{rowdata.MEMBER_VIEWS}</td>
	<td class="{rowdata.ROW_CLASS}" align="right"><span class="genmed">{rowdata.MEMBER_VIEWS_PCT}%</td>
	<td class="{rowdata.ROW_CLASS}" align="right"><span class="genmed">{rowdata.PAGE_VIEWS}</td>
	<td class="{rowdata.ROW_CLASS}" align="right"><span class="genmed">{rowdata.PAGE_VIEWS_PCT}%</td>
	<td class="{rowdata.ROW_CLASS}" align="center"><span class="genmed">{rowdata.CB_DISABLE_PAGE}{rowdata.DISABLE_PAGE}</td>
	<td class="{rowdata.ROW_CLASS}" align="center"><span class="genmed">{rowdata.AUTH_LEVEL}</td>
	<td class="{rowdata.ROW_CLASS}" align="center"><span class="genmed">{rowdata.MIN_POST_COUNT}</td>
	<td class="{rowdata.ROW_CLASS}" align="center"><span class="genmed">{rowdata.MAX_POST_COUNT}</td>
	<td class="{rowdata.ROW_CLASS}" nowrap="nowrap"><a href="{rowdata.U_EDIT}" class="genmed">{L_EDIT}</a></td>
	<td class="{rowdata.ROW_CLASS}" nowrap="nowrap"><a href="{rowdata.U_DELETE}" class="genmed">{L_DELETE}</a></td>
</tr>
<!-- END rowdata -->
<tr>
	<td class="row3" align="right"><span class="genmed">{L_TOTAL_PAGE_VIEWS}</span></td>
	<td class="row3" align="right"><span class="genmed">{TOTAL_GUEST_VIEWS}</span></td>
	<td class="row3" align="right"><span class="genmed">{TOTAL_GUEST_PCT}%</span></td>
	<td class="row3" align="right"><span class="genmed">{TOTAL_MEMBER_VIEWS}</span></td>
	<td class="row3" align="right"><span class="genmed">{TOTAL_MEMBER_PCT}%</span></td>
	<td class="row3" align="right"><span class="genmed">{TOTAL_PAGE_VIEWS}</span></td>
	<td class="row3" colspan="7">&nbsp;</td>
</tr>
<tr>
	<td colspan="13" align="center" class="catBottom">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_ADD}" class="mainoption" />&nbsp;&nbsp;&nbsp;<input type="submit" name="disable" value="{L_UPDATE_SELECTED_PAGES}" class="liteoption" />&nbsp;&nbsp;&nbsp;<input type="submit" name="cache" value="{L_REBUILD_CACHE}" class="liteoption" /></td>
</tr>
</table>
</form>
<p />
<form action="{S_ACTION}" method="POST">
<table width="98%" align="center" cellpadding="2" cellspacing="2" border="0" class="forumline">
<tr><td align="left" class="row2"><span class="gen">{L_COUNT_VIEWS} {CB_COUNT_VIEWS}</span> <input class="liteoption" type="submit" name="switch" value="{L_SAVE_COUNT_VIEWS}" /></td></tr>
</table>
</form>
