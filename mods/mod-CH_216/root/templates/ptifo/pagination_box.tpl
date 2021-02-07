<!-- BEGIN pagination -->
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
	<td width="100%"><span class="gensmall">
		<b>{pagination.L_PAGE_OF}</b>&nbsp;{pagination.L_COUNT}
	</span></td>
	<td align="right" nowrap="nowrap"><span class="gensmall">&nbsp;
		<!-- BEGIN unique_ELSE --><b>{pagination.L_GOTO}:&nbsp;</b><!-- END unique_ELSE -->
		<!-- BEGIN previous --><b><a href="{pagination.U_PREVIOUS}" class="gensmall">{pagination.L_PREVIOUS}</a>&nbsp;</b><!-- END previous -->
		<!-- BEGIN page_number --><b><!-- BEGIN number --><!-- BEGIN current_ELSE --><a href="{pagination.page_number.U_PAGE}" class="gensmall"><!-- END current_ELSE -->{pagination.page_number.PAGE}<!-- BEGIN current_ELSE --></a><!-- END current_ELSE --><!-- BEGIN sep -->, <!-- END sep --><!-- BEGINELSE number -->..., <!-- END number --></b><!-- END page_number -->
		<!-- BEGIN next --><b>&nbsp;<a href="{pagination.U_NEXT}" class="gensmall">{pagination.L_NEXT}</a></b><!-- END next -->
	</span></td>
</tr>
</table>
<!-- END pagination -->