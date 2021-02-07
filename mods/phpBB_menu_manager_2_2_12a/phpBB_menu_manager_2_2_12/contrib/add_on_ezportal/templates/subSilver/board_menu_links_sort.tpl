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
<table width="100%" cellpadding="2" cellspacing="0" border="0" class="forumline">
  <tr>
	<th class="thCornerL" width="50%">{L_BL_LINK}</th>
 	<th class="thCornerR" width="50%">{L_PL_LINK}</th>
  </tr>
 <tr>
	<td valign="top">
		<table cellpadding="0" cellspacing="1" border="0" width="100%">
		<!-- BEGIN sort_links_row -->
		  <tr>
			<td class="row1" align="center" width="60%"><span class="gen">{sort_links_row.BL_LINK}</span></td>
			<td class="row2" align="center" width="20%"><span class="gensmall">
				<a href="{sort_links_row.U_BL_UP}">{sort_links_row.L_BL_UP}</a><br />
				<a href="{sort_links_row.U_BL_DOWN}">{sort_links_row.L_BL_DOWN}</a></span>
			</td>
			<td class="row2" align="center" width="20%"><span class="gensmall">
				<a href="{sort_links_row.U_BL_FIRST}">{sort_links_row.L_BL_FIRST}</a><br />
				<a href="{sort_links_row.U_BL_LAST}">{sort_links_row.L_BL_LAST}</a></span>
			</td>
		  </tr>
		<!-- END sort_links_row -->
		</table>
	</td>
	<td valign="top">
		<table cellpadding="0" cellspacing="1" border="0" width="100%">
		<!-- BEGIN sort_portal_row -->
		  <tr>
			<td class="row1" align="center" width="80%"><span class="gen">{sort_portal_row.BL_LINK}</span></td>
			<td class="row2" align="center" width="20%" colspan="2"><span class="gensmall">
				<a href="{sort_portal_row.U_BL_UP}">{sort_portal_row.L_BL_UP}</a><br />
				<a href="{sort_portal_row.U_BL_DOWN}">{sort_portal_row.L_BL_DOWN}</a></span>
			</td>
		  </tr>
		<!-- END sort_portal_row -->
		</table>
	</td>
 </tr>
<!-- BEGIN sort_menu -->
<tr>
	<td class="row2" align="center" width="50%">
		<input type="submit" name="sort_default" value="{L_SORT_DEFAULT}" class="liteoption" /></td>
	<td class="row2" align="center" width="50%">
		<input type="submit" name="sort_pdefault" value="{L_SORT_DEFAULT}" class="liteoption" /></td>
</tr>
<!-- END sort_menu -->
  <tr>
	<td class="row2" align="center" width="100%" colspan="2"><span class="gen">
		<input type="submit" name="cancel" value="{L_BOARD_MENU_MANAGER}" class="mainoption" /></span>
	</td>
  </tr>
</table>
</form>