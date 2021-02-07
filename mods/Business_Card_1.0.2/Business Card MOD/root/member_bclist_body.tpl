
<form method="post" action="{S_MODE_ACTION}">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	  <td align="right" nowrap="nowrap"><span class="gen">{L_SELECT_SORT_METHOD}:&nbsp;{S_MODE_SELECT}&nbsp;&nbsp;{L_ORDER}&nbsp;{S_ORDER_SELECT}&nbsp;&nbsp; 
		<input type="submit" name="submit" value="{L_SUBMIT}" class="liteoption" />
		</span></td>
	</tr>
  </table>
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <th height="25" class="thCornerL" nowrap="nowrap">#</th>
	  <th class="thTop" nowrap="nowrap">{L_USERNAME}</th>
	  <th class="thTop" nowrap="nowrap">{L_BC_REAL_NAME}</th>
	  <th class="thTop" nowrap="nowrap">{L_BC_COMPANY}</th>
	  <th class="thTop" nowrap="nowrap">{L_BC_COUNTRY}</th>
	  <th class="thCornerR" nowrap="nowrap">{L_BC_COMPANY_ADDRESS}</th>
	</tr>
	<!-- BEGIN memberrow -->
	<tr> 
	  <td class="{memberrow.ROW_CLASS}" align="center"><span class="gen">&nbsp;{memberrow.ROW_NUMBER}&nbsp;</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center"><span class="gen"><a href="{memberrow.U_VIEWPROFILE}" class="gen">{memberrow.USERNAME}</a>{memberrow.BC_IMG}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.BC_REAL_NAME}</span><span class="genmed">{memberrow.BC_DESIGNATION}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.BC_COMPANY}{memberrow.BC_COMPANY_LOGO}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="gen">{memberrow.BC_COUNTRY}</span></td>
	  <td class="{memberrow.ROW_CLASS}" align="center" valign="middle"><span class="genmed">{memberrow.BC_COMPANY_ADDRESS}</span></td>
	</tr>
	<!-- END memberrow -->
	<tr> 
	  <td class="catBottom" colspan="6" height="28">&nbsp;</td>
	</tr>
  </table>
  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="right" valign="top"></td>
	</tr>
  </table>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr> 
	<td><span class="nav">{PAGE_NUMBER}</span></td>
	<td align="right"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span></td>
  </tr>
</table></form>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>
