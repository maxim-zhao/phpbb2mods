<table width="100%" cellpadding="3" cellspacing="1" border="0">
  <tr>
	<td align="left" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> {L_BOARD_LINK_COUNTER}</span></td>
  </tr>
</table>

<center>
<h1>{L_BOARD_LINK_COUNTER}</h1>
</center>

<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
  <tr>
	<th>{L_BOARD_LINK}</th>
	<th>{L_CLICKS}</th>
	<th>&nbsp;</th>
  </tr>
<!-- BEGIN board_links_countrow -->
  <tr>
	<td class="row1" width="80%"><span class="nav">{board_links_countrow.BOARD_LINK_NAME}</span></td>
	<td class="row2" align="center" width="10%"><span class="genmed">{board_links_countrow.BOARD_LINK_CLICKS}</span></td>
	<td class="row3" align="center" width="10%"><span class="genmed"><a href="{board_links_countrow.U_RESET}" class="nav">{L_RESET}</a></td>
  </tr>
<!-- END board_links_countrow -->
  <tr>
	<td class="catbottom" colspan="2">&nbsp;</td>
	<td class="catbottom" align="center"><a href="{U_RESET_ALL}" class="gen"><b>{L_RESET}</b></a></td>
  </tr>
</table>
