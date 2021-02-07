<tr>
	<th class="thHead" colspan="2" height="25">{REG_TITLE}</th>
</tr>
<tr>
	<td class="row1" colspan="2">
		<table cellspacing="2" cellpadding="4" border="0" width="100%" align="center">
		<tr>
			<!-- BEGIN reg_option1 -->
			<td colspan="1" width="33%" class="row2"><input type="button" class="mainoption" value="{REG_OPTION1_NAME}" onClick="self.location.href='{REG_OPTION1_URL}'" onMouseOver="'{REG_OPTION1_NAME}'" {REG_OPTION1_READONLY}/>&nbsp;<span class="genoption1">({REG_OPTION1_COUNT})</span><br />&nbsp;<span class="gensmall">{REG_OPTION1_SLOTS}</span></td>
			<!-- END reg_option1 -->
			<!-- BEGIN reg_option2 -->
			<td colspan="1" width="33%" class="row2"><input type="button" class="mainoption" value="{REG_OPTION2_NAME}" onClick="self.location.href='{REG_OPTION2_URL}'" onMouseOver="'{REG_OPTION2_NAME}'" {REG_OPTION2_READONLY} />&nbsp;<span class="genoption2">({REG_OPTION2_COUNT})</span><br />&nbsp;<span class="gensmall">{REG_OPTION2_SLOTS}</span></td>
			<!-- END reg_option2 -->
			<!-- BEGIN reg_option3 -->
			<td colspan="1" width="33%" class="row2"><input type="button" class="mainoption" value="{REG_OPTION3_NAME}" onClick="self.location.href='{REG_OPTION3_URL}'" onMouseOver="'{REG_OPTION3_NAME}'" {REG_OPTION3_READONLY} />&nbsp;<span class="genoption3">({REG_OPTION3_COUNT})</span><br />&nbsp;<span class="gensmall">{REG_OPTION3_SLOTS}</span></td>
			<!-- END reg_option3 -->
		</tr>
		<tr>
			<!-- BEGIN reg_option1 -->
			<td valign="top" class="row2">
				<table cellspacing="2" width="100%" cellpadding="2" border="0">
					<tr>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_USERNAME}</b></span></td>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_TIME}</b></span></td>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_CONFIRM_TIME}</b></span></td>
					</tr>
					{reg_option1.REG_OPTION1_DATA}
				</table>
			</td>
			<!-- END reg_option1 -->
			<!-- BEGIN reg_option2 -->
			<td valign="top" class="row2">
				<table cellspacing="2" width="100%" cellpadding="2" border="0">
					<tr>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_USERNAME}</b></span></td>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_TIME}</b></span></td>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_CONFIRM_TIME}</b></span></td>
					</tr>
					{reg_option2.REG_OPTION2_DATA}
				</table>
			</td>
			<!-- END reg_option2 -->
			<!-- BEGIN reg_option3 -->
			<td valign="top" class="row2">
				<table cellspacing="2" width="100%" cellpadding="2" border="0">
					<tr>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_USERNAME}</b></span></td>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_TIME}</b></span></td>
						<td class="row1"><span class="gensmall"><b>{REG_HEAD_CONFIRM_TIME}</b></span></td>
					</tr>
					{reg_option3.REG_OPTION3_DATA}
				</table>
			</td>
			<!-- END reg_option3 -->
		</tr>
		<!-- BEGIN reg_unregister -->
		<tr>
			<td colspan="3" class="row3" align="center"><input type="button" class="mainoption"  value="{reg_unregister.REG_SELF_NAME}" onClick="self.location.href='{reg_unregister.REG_SELF_URL}'" onMouseOver="'{reg_unregister.REG_SELF_NAME}'" /></td>
		</tr>
		<!-- END reg_unregister -->
		</table>
	</td>
</tr>