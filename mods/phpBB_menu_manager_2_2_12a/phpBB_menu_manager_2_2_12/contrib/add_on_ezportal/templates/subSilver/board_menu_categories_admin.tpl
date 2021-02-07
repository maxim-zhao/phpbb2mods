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
<!-- BEGIN menucatrow -->
  <tr>
	<td class="row1" align="center" width="40%"><span class="gen">{menucatrow.BL_CAT}</span></td>
	<td class="row2" align="center" width="20%"><span class="gen"><a href="{menucatrow.U_BL_MERGE}" class="nav">{menucatrow.L_BL_MERGE}</a></span></td>
	<td class="row2" align="center" width="20%"><span class="gen"><a href="{menucatrow.U_BL_EDIT}" class="nav">{menucatrow.L_BL_EDIT}</a></span></td>
	<td class="row2" align="center" width="20%"><span class="gen"><a href="{menucatrow.U_BL_DELETE}" class="nav">{menucatrow.L_BL_DELETE}</a></span></td>
  </tr>
<!-- END menucatrow -->
</table>

<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<td class="row1" align="right" width="20%"><span class="gen">{L_CAT_NAME}</span></td>
	<td class="row2" align="left"><span class="gen">{CATNAME}</span></td>
	<td class="row2" align="left"><span class="gen"><input type="checkbox" name="show_catname" checked="checked" value="1">&nbsp;&nbsp;{L_SHOW_CATNAME}</span></td>
	<td class="row2" align="left"><span class="gen"><input type="checkbox" name="show_seperator" value="1">&nbsp;&nbsp;{L_SHOW_SEPERATOR}</span></td>
  </tr>
  <tr>
	<td class="row1" align="center" width="100%" colspan="4"><span class="gen">
		<input type="hidden" name="save_cat" value="1">
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" name="cancel" value="{L_BOARD_MENU_MANAGER}" class="liteoption" /></span>
	</td>
  </tr>
</table>
</form>