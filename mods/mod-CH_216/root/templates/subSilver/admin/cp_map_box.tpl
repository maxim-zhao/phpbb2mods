<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
<tr>
	<th height="25" class="thHead" colspan="2">&nbsp;{L_FIELDS}&nbsp;</th>
</tr>
<!-- BEGIN row -->
<tr>
	<td class="<!-- BEGIN light -->row1<!-- BEGINELSE light -->row2<!-- END light -->" nowrap="nowrap" onmouseover="this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.style.cursor='pointer'; this.style.fontWeight='normal';" onclick="location.href='{row.U_FIELD}';"><span class="gen">
		<a href="{row.U_FIELD}" class="gen" title="{L_EDIT}"<!-- BEGIN active --> style="font-weight: bold;"<!-- END active -->>{row.FIELD_NAME}</a>
	</span></td>
</tr>
<!-- END row -->
<!-- BEGIN empty_list -->
<tr>
	<td class="row1" height="30" align="center"><span class="gen">
		{L_EMPTY}
	</span></td>
</tr>
<!-- END empty_list -->
<!-- BEGIN left -->
<tr>
	<td class="catBottom" colspan="2" align="center" valign="middle" nowrap="nowrap">{S_HIDDEN_FIELDS}<span class="gensmall">
		<!-- BEGIN buttons --><input type="image" src="{left.buttons.I_BUTTON}" name="{left.buttons.BUTTON}" title="{left.buttons.L_BUTTON}" <!-- BEGIN accesskey -->accesskey="{left.buttons.S_BUTTON}"<!-- END accesskey --> />&nbsp;<!-- END buttons -->
	</span></td>
</tr>
<!-- END left -->
<!-- BEGIN preview -->
</table>
<img src="{I_SPACER}" width="1" height="2" border="0" />
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
<tr>
	<td class="catHead" colspan="2" align="center" valign="middle" nowrap="nowrap"><span class="gensmall">
		<input type="image" src="{I_PREVIEW}" name="preview_map" title="{L_PREVIEW}" />
	</span></td>
</tr>
<!-- END preview -->
</table>