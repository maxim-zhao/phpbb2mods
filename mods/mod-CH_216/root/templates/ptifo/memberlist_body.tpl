
<form method="post" action="{S_MODE_ACTION}">
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
<tr>
	<th class="thHead" colspan="2">{L_OPTIONS}</th>
</tr>
<tr>
	<td class="row1" nowrap="nowrap"><span class="gen">{L_SEARCH_USERNAME}:&nbsp;</span><span class="gensmall"><br />{L_SEARCH_EXPLAIN}</span></td>
	<td class="row2" width="100%"><input type="text" class="post" name="username" value="{USERNAME}" size="25" /></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_SELECT_SORT_METHOD}:&nbsp;</span></td>
	<td class="row2"><span class="gen">&nbsp;{S_MODE_SELECT}&nbsp;{S_ORDER_SELECT}</span></td>
</tr>
<!-- BEGIN user_admin -->
<tr>
	<td class="row1"><span class="gen">{L_INACTIVE}:&nbsp;</span></td>
	<td class="row2"><span class="gen">&nbsp;
		<input type="radio" name="inact" value="1"<!-- BEGIN inact --> checked="checked"<!-- END inact --> />{L_YES}&nbsp;
		<input type="radio" name="inact" value="0"<!-- BEGIN inact --><!-- BEGINELSE inact --> checked="checked"<!-- END inact --> />{L_NO}&nbsp;
	</span></td>
</tr>
<!-- END user_admin -->
<tr>
	<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<span class="gensmall">&nbsp;
		<!-- BEGIN buttons --><input type="image" name="{buttons.BUTTON}" src="{buttons.I_BUTTON}" alt="{buttons.L_BUTTON}" title="{buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->
	</span></td>
</tr>
</table>
</form><br />

{NAVIGATION_BOX}
<!-- INCLUDE pagination_box.tpl -->
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thCornerL" nowrap="nowrap">#</th>
	  <th class="thTop" nowrap="nowrap">{L_PM}</th>
	  <th class="thTop" nowrap="nowrap">{L_USERNAME}</th>
	  <th class="thTop" nowrap="nowrap">{L_EMAIL}</th>
	  <th class="thTop" nowrap="nowrap">{L_FROM}</th>
	  <th class="thTop" nowrap="nowrap">{L_JOINED}</th>
	  <th class="thTop" nowrap="nowrap">{L_POSTS}</th>
	  <th class="thCornerR" nowrap="nowrap">{L_WEBSITE}</th>
	</tr>
	<!-- BEGIN memberrow -->
	<!-- BEGIN active_status -->
	<tr>
		<td colspan="8" class="catmini"><span class="genmed"><b>{memberrow.active_status.L_TITLE}</b></span></td>
	</tr>
	<!-- END active_status -->
	<tr> 
	  <td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center"><span class="gen">&nbsp;{memberrow.ROW_NUMBER}&nbsp;</span></td>
	  <td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center">&nbsp;{memberrow.PM_IMG}&nbsp;</td>
	  <td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center"><span class="gen"><a href="{memberrow.U_VIEWPROFILE}" class="gen">{memberrow.USERNAME}</a></span></td>
	  <td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center" valign="middle">&nbsp;{memberrow.EMAIL_IMG}&nbsp;</td>
	  <td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center" valign="middle"><span class="gen">{memberrow.FROM}</span></td>
	  <td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center" valign="middle"><span class="gensmall">{memberrow.JOINED}</span></td>
	  <td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center" valign="middle"><span class="gen">{memberrow.POSTS}</span></td>
	  <td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" align="center">&nbsp;{memberrow.WWW_IMG}&nbsp;</td>
	</tr>
	<!-- END memberrow -->
	<tr> 
	  <td class="catBottom" colspan="8" height="28">&nbsp;</td>
	</tr>
  </table>
<!-- INCLUDE pagination_box.tpl -->

<br clear="all" />