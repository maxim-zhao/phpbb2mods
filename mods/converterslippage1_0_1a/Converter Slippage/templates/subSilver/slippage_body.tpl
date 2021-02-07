<form method="post" action="{SLIPPAGE_ACTION}">

{ERROR_BOX}

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25" valign="middle">{L_SLIPPAGE}</th>
	</tr>
	<tr> 
		<td class="row1" width="40%"><span class="gen">{L_SLIPPAGE_MPH}: </span><br /><span class="gensmall">{L_SLIPPAGE_MPH_EXPLAIN}</span></td>
		<td class="row2" width="60%"><input type="text" class="post" style="width:200px" name="slippage_mph" size="50" maxlength="50" value="{SLIPPAGE_MPH}" /></td>
	</tr>
	<tr> 
		<td class="row1" width="40%"><span class="gen">{L_SLIPPAGE_RATIO}: </span><br /><span class="gensmall">{L_SLIPPAGE_RATIO_EXPLAIN}</span></td>
		<td class="row2" width="60%"><input type="text" class="post" style="width:200px" name="slippage_ratio" size="50" maxlength="50" value="{SLIPPAGE_RATIO}" /></td>
	</tr>
	<tr> 
		<td class="row1" width="40%"><span class="gen">{L_SLIPPAGE_TRAP_RPM}: </span><br /><span class="gensmall">{L_SLIPPAGE_TRAP_RPM_EXPLAIN}</span></td>
		<td class="row2" width="60%"><input type="text" class="post" style="width:200px" name="slippage_trap_rpm" size="50" maxlength="50" value="{SLIPPAGE_TRAP_RPM}" /></td>
	</tr>
	<tr> 
		<td class="row1" width="40%"><span class="gen">{L_SLIPPAGE_TIRE_HEIGHT}: </span><br /><span class="gensmall">{L_SLIPPAGE_TIRE_HEIGHT_EXPLAIN}</span></td>
		<td class="row2" width="60%"><input type="text" class="post" style="width:200px" name="slippage_tire_height" size="50" maxlength="50" value="{SLIPPAGE_TIRE_HEIGHT}" /></td>
	</tr>
	<tr> 
		<td class="row1" width="40%"><span class="gen">{L_SLIPPAGE_PERCENT}: </span><br /><span class="gensmall">{L_SLIPPAGE_PERCENT_EXPLAIN}</span></td>
		<td class="row2" width="60%">{SLIPPAGE_PERCENT}</td>
	</tr>
	<tr> 

		<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SLIPPAGE_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_SLIPPAGE_RESET}" name="reset" class="liteoption" /></td>
	</tr>
</table>

</form>

<table width="100%" cellspacing="2" border="0" align="center">
  <tr> 
	<td valign="top" align="right">{JUMPBOX}</td>
  </tr>
</table>

<div align="center"><span class="copyright"><br />{L_SLIPPAGE} - {L_SLIPPAGE_VERSION} - {L_SLIPPAGE_COPYRIGHT}<br />
</div>