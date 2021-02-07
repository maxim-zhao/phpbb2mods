<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
  <tr> 
    <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
  </tr>
</table>
{AUTH_UNDO}
<form method="get" action="{S_VOTE_ACTION}">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tr>
    <th>{L_SORT_BY_OPTION}</th>
    <th>{L_SORT_BY_USER}</th>
  </tr>
  <tr>
    <td valign="top" width="50%" class="row1">
      <ol class="genmed" style="list-style-type: none;">
<!-- BEGIN options_sort -->
        <li><b>{options_sort.OPTION}</b> ({options_sort.RESULT})
          <ol class="genmed" style="list-style-type: {options_sort.STYLE};">
		    <!-- BEGIN switch_novote -->
			<li><i>{options_sort.switch_novote.L_NOVOTES}</i></li>
			<!-- END switch_novote -->
		    <!-- BEGIN options_users -->
            <li><a href="{options_sort.options_users.U_USER}">{options_sort.options_users.USERNAME}</a></li>
			<!-- END options_users -->
          </ol>
        </li>
<!-- END options_sort -->
      </ol>
    </td>
    <td valign="top" width="50%" class="row2">
      <ol class="genmed" style="list-style-type: none;">
<!-- BEGIN users_sort -->
        <li><b><a href="{users_sort.U_USER}">{users_sort.USER}</a></b> {users_sort.COUNT}
		  <!-- BEGIN switch_undo -->
		  <a href="{users_sort.switch_undo.U_UNDO}">{users_sort.switch_undo.L_UNDO}</a>
		  <!-- END switch_undo -->
          <{users_sort.ULOL} class="genmed" style="list-style-type: {users_sort.STYLE};">
		    <!-- BEGIN users_options -->
            <li>{users_sort.users_options.OPTION}</li>
			<!-- END users_options -->
          </{users_sort.ULOL}>
        </li>
<!-- END users_sort -->
      </ol>
    </td>
  </tr>
  <tr> 
    <td class="catBottom" colspan="2" height="28" align="center">
      <input type="hidden" name="action" value="export" />
      <input type="hidden" name="vote_id" value="{VOTE_ID}" />
      <input type="submit" value="{L_EXPORT}" class="mainoption" />
    </td>
  </tr>
</table>
</form>
