<!-- BEGIN ctx -->
<table cellpadding="4" cellspacing="1" border="0" width="100%" class="forumline">
<tr>
	<th class="thHead">{ctx.L_OPTION}</th>
</tr>
<tr>
	<td height="25" class="row1"><table cellspacing="0" cellpadding="2" border="0" width="100%">
	<!-- BEGIN option -->
	<tr>
		<td width="5" align="right"><span class="gensmall"<!-- BEGIN select --> style="font-weight: bold;"<!-- END select -->>&bull;
		</span></td>
		<td nowrap="nowrap"<!-- BEGIN select --> style="font-weight: bold;"<!-- BEGINELSE select --> onmouseover="this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.style.cursor='pointer'; this.style.fontWeight='normal';" onclick="location.href='{ctx.option.U_OPTION}';"<!-- END select -->><span class="gensmall"><!-- BEGIN select --><!-- BEGINELSE select --><a href="{ctx.option.U_OPTION}" class="gensmall"><!-- END select -->{ctx.option.L_OPTION}<!-- BEGIN select --><!-- BEGINELSE select --></a><!-- END select --><br />
		</span></td>
	</tr>
	<!-- END option -->
	</table></td>
</tr>
<tr>
	<td class="spaceRow"><img src="{I_SPACER}" height="0" border="0" alt="" /></td>
</tr>
</table>
<!-- END ctx -->