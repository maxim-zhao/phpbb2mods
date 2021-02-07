<table width="100%" cellpadding="3" cellspacing="1" border="0">
  <tr>
	<td align="left" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{S_ACTION}" class="nav">{L_PAGE_TITLE}</a></span></td>
  </tr>
</table>

<center>
<h1>{L_WELCOME}</h1>
<h6>{L_MANAGER_EXPLAIN}</h6>
</center>

<form action="{S_ACTION}" method="post" name="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<th class="thCornerL" width="40%">{L_BL_LINK}</th>
	<th class="thCornerR" width="60%" colspan="2">&nbsp;</th>
  </tr>
<!-- BEGIN sort_links_row -->
  <tr>
	<td class="row1" align="center" width="40%"><span class="gen">{sort_links_row.BL_LINK}</span></td>
	<td class="row2" align="center" width="30%"><span class="gensmall">
		<a href="{sort_links_row.U_BL_UP}">{sort_links_row.L_BL_UP}</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="{sort_links_row.U_BL_DOWN}">{sort_links_row.L_BL_DOWN}</a>
	</td>
	<td class="row2" align="center" width="30%"><span class="gensmall">
		<a href="{sort_links_row.U_BL_FIRST}">{sort_links_row.L_BL_FIRST}</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="{sort_links_row.U_BL_LAST}">{sort_links_row.L_BL_LAST}</a>
	</td>
  </tr>
<!-- END sort_links_row -->
  <tr>
	<td class="row2" align="center" width="100%" colspan="3"><span class="gen">
		<input type="submit" name="cancel" value="{L_CLOSE_WINDOW}" class="mainoption" />
		<!-- BEGIN sort_menu -->
		&nbsp;&nbsp;&nbsp;<input type="submit" name="sort_default" value="{L_SORT_DEFAULT}" class="liteoption" />
		<!-- END sort_menu -->
		</span></td>
  </tr>
</table>
</form>