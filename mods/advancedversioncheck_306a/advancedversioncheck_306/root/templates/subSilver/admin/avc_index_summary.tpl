<!-- BEGIN switch_version_check_on -->
<h1>{switch_version_check_on.L_VERSION_CHECK_HEADER}</h1>
<p>{switch_version_check_on.L_INDEX_SUMMARY_EXPLAIN}</p>
<br />
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <tr>
    <th width="20%" nowrap="nowrap" height="25" class="thCornerL">{switch_version_check_on.L_MOD_NAME_HEADER}</th>    
    <th width="20%" nowrap="nowrap" height="25" class="thTop">{switch_version_check_on.L_CURRENT_VERSION_HEADER}</th>
	<th width="20%" nowrap="nowrap" height="25" class="thTop">{switch_version_check_on.L_LATEST_VERSION_HEADER}</th>
    <th width="20%" nowrap="nowrap" height="25" class="thCornerR">{switch_version_check_on.L_DOWNLOAD_MOD_HEADER}</th>
  </tr>
  <!-- BEGIN switch_version_check_loop -->
  <tr>
    <td class="row1" nowrap="nowrap" align="center"><a href="{switch_version_check_on.switch_version_check_loop.U_TOPIC_LOC}" target="_blank">{switch_version_check_on.switch_version_check_loop.L_MOD_NAME}</a></td>
    <td class="row1" nowrap="nowrap" align="center"><b><span style="color:green">{switch_version_check_on.switch_version_check_loop.L_CURRENT_VERSION}</span></b></td>
    <td class="row2" nowrap="nowrap" align="center"><b><span style="{switch_version_check_on.switch_version_check_loop.F_COLOR}">{switch_version_check_on.switch_version_check_loop.L_LATEST_VERSION}</span></b></td>
    <td class="row2" nowrap="nowrap" align="center"><a href="{switch_version_check_on.switch_version_check_loop.U_DOWNLOAD_MOD}" target="_blank">{switch_version_check_on.switch_version_check_loop.L_DOWNLOAD_MOD}</a></td>
 </tr>

<!-- END switch_version_check_loop -->  
</table>

<br />
<!-- END switch_version_check_on -->

<!-- BEGIN switch_version_check_none -->
<h1>{switch_version_check_none.L_MOD_NONE_HEADER}</h1>
<p style="color:green">{switch_version_check_none.L_NO_UPDATES}</p>
<!-- END switch_version_check_none -->