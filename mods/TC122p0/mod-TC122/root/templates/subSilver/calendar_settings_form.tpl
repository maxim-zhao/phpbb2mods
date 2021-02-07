<!-- BEGIN in_admin -->
<tr>
	<th class="thHead" colspan="2">{L_CALENDAR_FORM_TITLE}</th>
</tr>
<!-- END in_admin -->
<!-- BEGIN in_admin_ELSE -->
<tr>
	<td class="catSides" colspan="2">&nbsp;</td>
</tr>
<tr>
	<th class="thSides" colspan="2">{L_CALENDAR_FORM_TITLE}</th>
</tr>
<!-- END in_admin_ELSE -->
<!-- BEGIN field -->
<!-- BEGIN open_row -->
<tr>
	<!-- BEGIN in_admin -->
	<td class="row1" width="50%">
	<!-- END in_admin -->
	<!-- BEGIN in_admin_ELSE -->
	<td class="row1" width="38%"><span class="gen">
	<!-- END in_admin_ELSE -->
<!-- END open_row -->
<!-- BEGIN open_row_ELSE -->
	<hr /><span class="gensmall"><b>
<!-- END open_row_ELSE -->
			{field.LEGEND}
<!-- BEGIN open_row_ELSE -->
	</b></span>
<!-- END open_row_ELSE -->
<!-- BEGIN open_row -->
	<!-- BEGIN in_admin -->
	</td><td class="row2">
	<!-- END in_admin -->
	<!-- BEGIN in_admin_ELSE -->
	</span></td><td class="row2"><span class="gen">
	<!-- END in_admin_ELSE -->
<!-- END open_row -->
		<!-- BEGIN int -->
		<input type="text" class="post" name="{field.NAME}" value="{field.VALUE}" size="5" maxlength="9" />
		<!-- END int -->
		<!-- BEGIN list_radio -->
			<!-- BEGIN opt -->
			<!-- BEGIN selected -->
			<input type="radio" name="{field.NAME}" value="{field.list_radio.opt.VALUE}" checked="checked" />
			<!-- END selected -->
			<!-- BEGIN selected_ELSE -->
			<input type="radio" name="{field.NAME}" value="{field.list_radio.opt.VALUE}" />
			<!-- END selected_ELSE -->
			{field.list_radio.opt.LEGEND}
			<!-- END opt -->
		<!-- END list_radio -->
		<!-- BEGIN list -->
		<select name="{field.NAME}">
			<!-- BEGIN opt -->
			<!-- BEGIN selected -->
			<option value="{field.list.opt.VALUE}" selected="selected">
			<!-- END selected -->
			<!-- BEGIN selected_ELSE -->
			<option value="{field.list.opt.VALUE}">
			<!-- END selected_ELSE -->
				{field.list.opt.LEGEND}
			</option>
			<!-- END opt -->
		</select>
		<!-- END list -->
<!-- BEGIN close_row -->
	<!-- BEGIN in_admin -->
	</td>
	<!-- END in_admin -->
	<!-- BEGIN in_admin_ELSE -->
	</span></td>
	<!-- END in_admin_ELSE -->
</tr>
<!-- END close_row -->
<!-- END field -->