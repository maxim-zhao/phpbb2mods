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
<!-- BEGIN menulinkrow -->
  <tr>
	<td class="{menulinkrow.ROW_CLASS}" align="center" NOWRAP><span class="gen">{menulinkrow.BL_MENU_LINK}</span></td>
	<td class="{menulinkrow.ROW_CLASS}" align="center" NOWRAP><span class="gensmall">{menulinkrow.BL_BOARD_LINK_USED}{menulinkrow.BL_PORTAL_LINK_USED}</span></td>
	<td class="{menulinkrow.ROW_CLASS}" align="center"><span class="gen">{menulinkrow.BL_LEVEL}</span></td>
	<td class="{menulinkrow.ROW_CLASS}" align="center"><span class="gen"><a href="{menulinkrow.U_BL_EDIT}" class="nav">{menulinkrow.L_BL_EDIT}</a></span></td>
	<td class="{menulinkrow.ROW_CLASS}" align="center"><span class="gen"><a href="{menulinkrow.U_BL_DELETE}" class="nav">{menulinkrow.L_BL_DELETE}</a></span></td>
	<td class="{menulinkrow.ROW_CLASS}" align="center"><span class="gen"><a href="{menulinkrow.U_BL_INFO}" class="nav">{menulinkrow.L_BL_INFO}</a></span></td>
  </tr>
<!-- END menulinkrow -->
</table>

<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<td class="row1" align="right" width="20%"><span class="gen">{L_BL_NAME}</span></td>
	<td class="row2" align="left" width="80%"><span class="gen">{BLNAME}</span></td>
  </tr>
  <tr>
	<td class="row1" align="right" width="20%"><span class="gen">{L_BL_LEVEL}</span></td>
	<td class="row2" align="left" width="80%"><span class="gen">{BLLEVEL}</span></td>
  </tr>
  <tr>
	<td class="row1" align="right" width="20%"><span class="gen">{L_BL_IMG}</span></td>
	<td class="row2" align="left" width="80%"><span class="gen">{BLIMG}</span></td>
  </tr>
  <tr>
	<td class="row1" align="right" width="20%"><span class="gen">{L_BL_LINK}</span></td>
	<td class="row2" align="left" width="80%"><span class="gen"><input type="text" name="bl_link" size="50" maxlength="50"/></span><br /><span class="gensmall">{L_BL_LINK_EXPLAIN}</span></td>
  </tr>
  <tr>
	<td class="row1" align="right" width="20%"><span class="gen">{L_BL_PARAMETER}</span></td>
	<td class="row2" align="left" width="80%"><span class="gen"><input type="text" name="bl_parameter" size="50" maxlength="50"/></span><br /><span class="gensmall">{L_BL_PARAMETER_EXPLAIN}</span></td>
  </tr>
  <tr>
	<td class="row1" align="center" width="100%" colspan="2"><span class="gen">
		<input type="hidden" name="save_links" value="1">
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" name="cancel" value="{L_BOARD_MANAGER}" class="liteoption" /></span>
	</td>
  </tr>
</table>
</form>

<!-- BEGIN board_link_used -->
<br />
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<th class="thHead">{board_link_used.L_BOARD_LINK_USED}</th>
  </tr>
  <tr>
	<td class="row1"><span class="gensmall">{board_link_used.BOARD_LINK_USER}</span></td>
  </tr>
</table>
<!-- END board_link_used -->
<!-- BEGIN portal_link_used -->
<br />
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<th class="thHead">{portal_link_used.L_PORTAL_LINK_USED}</th>
  </tr>
  <tr>
	<td class="row1"><span class="gensmall">{portal_link_used.PORTAL_LINK_USER}</span></td>
  </tr>
</table>
<!-- END portal_link_used -->

