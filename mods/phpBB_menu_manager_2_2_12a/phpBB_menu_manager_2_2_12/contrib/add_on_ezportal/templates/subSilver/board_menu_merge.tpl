<table width="100%" cellpadding="3" cellspacing="1" border="0">
  <tr>
	<td align="left" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{S_ACTION}" class="nav">{L_PAGE_TITLE}</a></span></td>
  </tr>
</table>

<center>
<h1>{L_WELCOME}</h1>
<h6>{L_MANAGER_EXPLAIN}</h6>
</center>

<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
<!-- BEGIN linkrow -->
  <tr>
	<td class="row1" align="center" width="60%"><span class="gen">{linkrow.BL_LINK}</span></td>
	<td class="row2" align="center" width="20%"><a href="{linkrow.U_BL_FIX}" class="nav">{linkrow.L_BL_FIX}</a></span></td>
	<td class="row2" align="center" width="20%"><a href="{linkrow.U_BL_REMOVE}" class="nav">{linkrow.L_BL_REMOVE}</a></span></td>
  </tr>
<!-- END linkrow -->
</table>

<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="10" cellspacing="10" border="0" class="forumline">
<!-- BEGIN bl_names_on -->
  <tr>
	<td class="row1" align="right" width="25%"><span class="gen">{L_BL_NAME}</span></td>
	<td class="row2" align="left" width="75%">{BL_NAME}</span></td>
  </tr>
<!-- END bl_names_on -->
  <tr>
	<td class="row1" align="center" width="100%" colspan="2"><span class="gen">
		<input type="hidden" name="join_link" value="1">
		<input type="hidden" name="cat_id" value="{CAT_ID}">
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" name="manage_categories" value="{L_PREVIOUS}" class="liteoption" /></span>
	</td>
  </tr>
</table>
</form>