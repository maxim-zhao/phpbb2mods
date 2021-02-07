<table width="100%" cellpadding="3" cellspacing="1" border="0">
  <tr>
	<td align="left" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{S_ACTION}" class="nav">{L_PAGE_TITLE}</a></span></td>
  </tr>
</table>

<center>
<h1>{L_WELCOME}</h1>
<h6>{L_MANAGER_EXPLAIN}</h6>
</center>

<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<td class="row1" align="right" width="20%"><span class="gen">{L_CAT_NAME}</span></td>
	<td class="row2" align="left"><span class="gen">{CATNAME}</span></td>
	<td class="row2" align="left"><span class="gen"><input type="checkbox" name="show_catname" {S_SHOW_CATNAME} value="1">&nbsp;&nbsp;{L_SHOW_CATNAME}</span></td>
	<td class="row2" align="left"><span class="gen"><input type="checkbox" name="show_seperator" {S_SHOW_SEPERATOR} value="1">&nbsp;&nbsp;{L_SHOW_SEPERATOR}</span></td>
  </tr>
  <tr>
	<td class="row1" align="center" width="100%" colspan="4"><span class="gen">
		<input type="hidden" name="update_cat" value="1">
		<input type="hidden" name="cat_id" value="{CAT_ID}">
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" name="manage_categories" value="{L_PREVIOUS}" class="liteoption" /></span>
		</td>
  </tr>
</table>
</form>
