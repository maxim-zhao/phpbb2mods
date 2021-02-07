<script language="Javascript" type="text/javascript">
	function select_board(status)
	{
		for (i = 0; i < document.set_board.length; i++)
		{
			document.set_board.elements[i].checked = status;
		}
	}
</script>

<table width="100%" cellpadding="3" cellspacing="1" border="0">
  <tr>
	<td align="left" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a href="{S_ACTION}" class="nav">{L_PAGE_TITLE}</a></span></td>
  </tr>
</table>

<center>
<h1>{L_WELCOME}</h1>
<h6>{L_MANAGER_EXPLAIN}</h6>
</center>

<form action="{S_ACTION}" method="post" name="set_board">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<th class="thCornerL" width="80%">{L_BL_LINK}</th>
	<th class="thCornerR" width="20%">{L_BL_SET}</th>
  </tr>
<!-- BEGIN board_links_row -->
  <tr>
	<td class="row1" align="center" width="80%">{board_links_row.BL_MENU_LINKS}</td>
	<td class="row2" align="center" width="20%">{board_links_row.BL_CHECK}</td>
  </tr>
<!-- END board_links_row -->
<tr>
	<td class="row2" align="center" width="100%" colspan="2"><span class="gensmall"><a href="javascript:select_board(true);" class="gensmall">{L_MARK_ALL}</a> ::
		<a href="javascript:select_board(false);" class="gensmall">{L_UNMARK_ALL}</a><br /></span></td>
</tr>
  <tr>
	<td class="row1" align="center" width="100%" colspan="2"><span class="gen">
		<input type="hidden" name="update_set_links" value="1">
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" name="cancel" value="{L_BOARD_MENU_MANAGER}" class="liteoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" name="reset" value="{L_RESET}" class="liteoption" /></span>
	</td>
  </tr>
</table>
</form>