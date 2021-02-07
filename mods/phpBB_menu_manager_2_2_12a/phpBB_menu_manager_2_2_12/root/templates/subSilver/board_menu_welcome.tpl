<script language="JavaScript" type="text/javascript">
<!--
function close_manager() {
	window.open("{U_INDEX}", "_parent");
}
//-->
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

<form action="{S_ACTION}" method="post">
<table width="100%" cellpadding="10" cellspacing="10" border="0" class="forumline">
  <tr>
	<td class="row1" align="center" width="100%"><input type="submit" name="set_links" style="width: 450px" value="{L_SET_BOARD_LINKS}" class="mainoption" /></td>
  </tr>
<!-- BEGIN switch_sorting_on -->
  <tr>
	<td class="row1" align="center" width="100%"><input type="submit" name="sort_links" style="width: 450px" value="{L_SORT_BOARD_LINKS}" class="mainoption" /></td>
  </tr>
<!-- END switch_sorting_on -->
<!-- BEGIN click_counter_on -->
  <tr>
	<td class="row1" align="center" width="100%"><input type="submit" name="bmm_link" style="width: 450px" value="{click_counter_on.L_CLICK_COUNTER}" class="mainoption" />
  </tr>
<!-- END click_counter_on -->
<!-- BEGIN admin_options -->
  <tr>
	<td class="row1" align="center" width="100%"><input type="submit" name="manage_links" style="width: 450px" value="{admin_options.L_MANAGE_BOARD_LINKS}" class="mainoption" /></td>
  </tr>
   <tr>
	<td class="row1" align="center" width="100%"><input type="submit" name="default_sort" style="width: 450px" value="{admin_options.L_DEFAULT_SORT_LINKS}" class="mainoption" /></td>
  </tr>
 <tr>
	<td class="row1" align="center" width="100%"><input type="submit" name="config_links" style="width: 450px" value="{admin_options.L_CONFIG_BOARD_LINKS}" class="mainoption" /></td>
  </tr>
<!-- END admin_options -->
  <tr>
	<td class="row1" align="center" width="100%"><input type="button" name="close" style="width: 450px" value="{L_CLOSE_WINDOW}" class="mainoption" onClick="javascript:close_manager()" /></td>
  </tr>
</table>
</form>