<h1>{L_LIST_ALL_INVITES}</h1>

<p>{L_LIST_ALL_INVITES_EXPLAIN}</p>
<form method="post" action="{S_INVITE_ACTION}">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
 
	<td align="left" nowrap="nowrap"><span class="genmed">{L_SELECT_SORT_METHOD}&nbsp;
	<select name="sort_order">
	<!-- BEGIN sort_order -->
		<option value="{sort_order.ORDER}" {sort_order.SELECTED} >{sort_order.NAME}</option>
	<!-- END sort_order -->
	</select>
	&nbsp;&nbsp;{L_ORDER}:&nbsp;
	<select name="sort_desc">
	<!-- BEGIN sort_ascdesc -->
		<option value="{sort_ascdesc.ORDER}" {sort_ascdesc.SELECTED} >{sort_ascdesc.NAME}</option>
	<!-- END sort_ascdesc -->
	</select>	
	&nbsp;&nbsp; 
		<input type="submit" name="submit" value="{L_SORT}" class="liteoption" />
		</span></td>
	</tr>
  </table>