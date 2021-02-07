<form method="post" action="{S_ACTION}">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
<tr> 
	<td align="left" valign="middle" class="nav" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a>{NAV_SEPARATOR}<a href="{U_USER}" class="nav">{L_USER}</a>{NAV_SEPARATOR}<a href="{U_OPTION}" class="nav">{L_OPTION}</a></span></td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0" align="center" class="forumline">
<tr>
	<th colspan="2">{L_MOD_NAME}</th>
</tr>
<tr>
	<td valign="top" class="row3" width="200">
		<table cellpadding="10" cellspacing="1" border="0" class="bodyline" width="100%">
		<!-- BEGIN mod -->
		<tr>
			<td class="{mod.CLASS}" align="{mod.ALIGN}" nowrap="nowrap">
				<a href="{mod.U_MOD}" class="gen">{mod.L_MOD}</a>
				<!-- BEGIN sub -->
				<hr />
				<table cellpadding="2" cellspacing="1" border="0" align="left" width="100%">
					<!-- BEGIN row -->
					<tr>
						<td align="left" class="{mod.sub.row.CLASS}" nowrap="nowrap"><span class="genmed">&nbsp;&nbsp;&raquo;&nbsp;<a href="{mod.sub.row.U_MOD}" class="genmed">{mod.sub.row.L_MOD}</a>&nbsp;&nbsp;</span></td>
					</tr>
					<!-- END row -->
				</table>
				<!-- END sub -->
			</td>
		</tr>
		<!-- END mod -->
		</table>
	</td>
	<td valign="top" class="row3">
		<table cellpadding="5" cellspacing="1" border="0" width="100%" class="bodyline">
		<!-- BEGIN field -->
		<tr>
			<td class="row1" width="50%"><span class="gen">{field.L_NAME}</span><span class="gensmall">{field.L_EXPLAIN}</span></td>
			<td class="row2" width="50%" nowrap="nowrap"><span class="gen">{field.INPUT}</span></td>
		</tr>
		<!-- END field -->
		</table>
	</td>
</tr>
<tr>
	<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;
		<input type="reset" value="{L_RESET}" class="liteoption" />
	</td>
</tr>
</table>
</form>