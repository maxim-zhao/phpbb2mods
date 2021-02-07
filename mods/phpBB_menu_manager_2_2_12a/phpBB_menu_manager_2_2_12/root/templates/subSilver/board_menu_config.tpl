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
<table width="100%" cellpadding="10" cellspacing="10" border="0" class="forumline">
  <tr>
	<td class="row1" align="right" width="50%"><span class="gen">{L_BL_SEPERATOR}</span></td>
	<td class="row2" align="left" width="50%"><span class="gen"><input type="checkbox" name="bl_seperator" value="1" {BL_SEPERATOR} /></span></td>
  </tr>
  <tr>
	<td class="row1" align="right" width="50%"><span class="gen">{L_BL_SEPERATOR_CONTENT}</span></td>
	<td class="row2" align="left" width="50%"><span class="gen"><input type="text" name="bl_seperator_content" size="50" maxlength="200" value="{BL_SEPERATOR_CONTENT}" /></span></td>
  </tr>
  <tr>
	<td class="row1" align="right" width="50%"><span class="gen">{L_BL_BREAK}</span></td>
	<td class="row2" align="left" width="50%"><span class="gen"><input type="text" name="bl_break" value="{BL_BREAK}" size="5" maxlength="5" /></span></td>
  </tr>
  <tr>
	<td class="row1" align="center" width="100%" colspan="2"><span class="gen">
		<input type="hidden" name="config" value="1">
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;&nbsp;
		<input type="submit" name="cancel" value="{L_BOARD_MENU_MANAGER}" class="liteoption" /></span>
		</td>
  </tr>
</table>
</form>