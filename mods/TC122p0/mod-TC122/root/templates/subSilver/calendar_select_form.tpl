<!-- BEGIN select_form -->
<table cellpadding="3" cellspacing="1" border="0" width="100%" class="forumline">
<colgroup>
	<col width="40%">
	<col width="60%">
</colgroup>
<tr>
	<th class="thHead" colspan="2">{select_form.L_CALENDAR_SELECT}</th>
</tr>
<!-- BEGIN field -->
<!-- BEGIN open_row -->
<tr>
	<td class="row1"><span class="gen">
		<b>{select_form.field.L_FIELD}</b>
	</span></td>
	<td class="row2"><span class="gen">
<!-- END open_row -->
		<!-- BEGIN int -->
		<input class="post" type="text" size="8" name="{select_form.field.FIELD}" value="{select_form.field.VALUE}" />
		<!-- END int -->
		<!-- BEGIN list -->
		<select name="{select_form.field.FIELD}">
			<!-- BEGIN opt -->
			<!-- BEGIN selected -->
			<option value="{select_form.field.list.opt.VALUE}" selected="selected">{select_form.field.list.opt.LEGEND}</option>
			<!-- END selected -->
			<!-- BEGIN selected_ELSE -->
			<option value="{select_form.field.list.opt.VALUE}">{select_form.field.list.opt.LEGEND}</option>
			<!-- END selected_ELSE -->
			<!-- END opt -->
		</select>
		<!-- END list -->
<!-- BEGIN close_row -->
	</span></td>
</tr>
<!-- END close_row -->
<!-- END field -->
<tr>
	<td class="catBottom" align="center" colspan="2"><span class="genmed">
		<input type="submit" name="submit" value="{select_form.L_SUBMIT}" class="liteoption" />
	</span></td>
</tr>
</table>
<br style="font-size: 3px" />
<!-- END select_form -->