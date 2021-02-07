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
	<th class="thCornerL" width="80%">{L_CAT_NAME}</th>
	<th class="thCornerR" width="20%">&nbsp;</th>
  </tr>
<!-- BEGIN sort_cat_row -->
  <tr>
	<td class="row1" align="center" width="70%"><span class="gen">{sort_cat_row.CAT_NAME}</span></td>
	<td class="row2" align="center" width="30%"><span class="gensmall">
		<a href="{sort_cat_row.U_CAT_UP}" class="nav">{sort_cat_row.L_CAT_UP}</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="{sort_cat_row.U_CAT_DOWN}" class="nav">{sort_cat_row.L_CAT_DOWN}</a>
	</span></td>
  </tr>
<!-- END sort_cat_row -->
  <tr>
	<td class="row2" align="center" width="100%" colspan="2"><span class="gen">
		<input type="submit" name="cancel" value="{L_BOARD_MENU_MANAGER}" class="mainoption" /></span>
	</td>
  </tr>
</table>
</form>