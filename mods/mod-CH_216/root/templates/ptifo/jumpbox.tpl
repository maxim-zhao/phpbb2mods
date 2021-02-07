<!-- BEGIN jumpbox -->
<form method="get" name="jumpbox" action="{jumpbox.S_ACTION}"><table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
	<td nowrap="nowrap" align="right"><span class="gensmall">
		{jumpbox.L_JUMP_TO}:&nbsp;<select name="{jumpbox.S_NAME}" onchange="if(this.value >= 0){document.forms['jumpbox'].submit();}"><!-- BEGIN option -->
		<option value="{jumpbox.option.VALUE}"<!-- BEGIN selected --> selected="selected"<!-- END selected --><!-- BEGIN disabled --> disabled="disabled"<!-- END disabled -->><!-- BEGIN front --><!-- BEGIN inc -->{jumpbox.option.front.inc.L_INC}<!-- END inc -->&nbsp;<!-- END front -->{jumpbox.option.TEXT}</option>
		<!-- END option --></select>&nbsp;<input type="image" src="{jumpbox.I_GO}" value="{jumpbox.L_GO}" align="top" />
	</span><input type="hidden" name="sid" value="{jumpbox.SID}" /></td>
</tr>
</table></form>
<br class="nav" />
<!-- END jumpbox -->
