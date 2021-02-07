<form method="post" name="post" action="{S_USERGROUP_ACTION}">
{NAVIGATION_BOX}

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <!-- BEGIN switch_groups_joined -->
  <tr> 
	<th colspan="2" align="center" class="thHead" height="25">{L_GROUP_MEMBERSHIP_DETAILS}</th>
  </tr>
  <!-- BEGIN switch_groups_member -->
  <tr> 
	<td class="row1"><span class="gen">{L_YOU_BELONG_GROUPS}</span></td>
	<td class="row2" align="right">
	  <table width="90%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td width="40%"><span class="gensmall">{GROUP_MEMBER_SELECT}</span></td>
			<td align="center" width="30%"> 
			  <input type="submit" name="group_member" value="{L_VIEW_INFORMATION}" class="liteoption" />
			</td>
		</tr>
	  </table>
	</td>
  </tr>
  <!-- END switch_groups_member -->
  <!-- BEGIN switch_groups_pending -->
  <tr> 
	<td class="row1"><span class="gen">{L_PENDING_GROUPS}</span></td>
	<td class="row2" align="right">
	  <table width="90%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td width="40%"><span class="gensmall">{GROUP_PENDING_SELECT}</span></td>
			<td align="center" width="30%"> 
			  <input type="submit" name="group_pending" value="{L_VIEW_INFORMATION}" class="liteoption" />
			</td>
		</tr>
	  </table>
	</td>
  </tr>
  <!-- END switch_groups_pending -->
  <!-- END switch_groups_joined -->
  <!-- BEGIN switch_groups_remaining -->
  <tr> 
	<th colspan="2" align="center" class="thHead" height="25">{L_JOIN_A_GROUP}</th>
  </tr>
  <tr> 
	<td class="row1"><span class="gen">{L_SELECT_A_GROUP}</span></td>
	<td class="row2" align="right">
	  <table width="90%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td width="40%"><span class="gensmall">{GROUP_LIST_SELECT}</span></td>
			<td align="center" width="30%"> 
			  <input type="submit" name="group_remaining" value="{L_VIEW_INFORMATION}" class="liteoption" />
			</td>
		</tr>
	  </table>
	</td>
  </tr>
  <!-- END switch_groups_remaining -->
</table>
{S_HIDDEN_FIELDS}</form>

<br clear="all" />