<tr>
	<td width="100%" class="row1">
		<!-- INCLUDE pagination_box.tpl -->
		<table cellpadding="4" cellspacing="1" border="0" class="bodyline" width="100%">
		<tr>
			<td class="catHead" align="center"<!-- BEGIN gallery_empty --><!-- BEGINELSE gallery_empty --> colspan="{NB_COLS}"<!-- END gallery_empty -->><span class="cattitle">
				<b>{L_OPTIONS}:</b>&nbsp;<select name="gallery" onchange="this.form.submit();">{S_OPTIONS}</select>&nbsp;<input type="image" name="{gallery_select}" src="{I_GO}" alt="{L_GO}" align="top" />
			</span></td>
		</tr>
		<!-- BEGINGLOBAL gallery_empty -->
		<tr>
			<td class="row1" align="center" height="50"><span class="gen">
				{L_GALLERY_EMPTY}
			</span></td>
		</tr>
		<!-- BEGINELSEGLOBAL gallery_empty -->
		<!-- BEGIN row --><tr>
			<!-- BEGIN cell --><td class="row2" height="50" width="{WIDTH}%"><table cellpadding="20" cellspacing="0" border="0" width="100%"><tr><td width="100%" valign="middle" align="center"><span class="gen">
				<!-- BEGIN filled -->
				<input type="image" name="select_avatar[{row.cell.AVATAR}]" src="{row.cell.I_AVATAR}" title="{row.cell.L_AVATAR}" /><br />
				{row.cell.L_AVATAR}
				<!-- BEGINELSE filled -->
				&nbsp;
				<!-- END filled -->
			</span></td></tr></table></td><!-- END cell -->
		</tr><!-- END row -->
		<!-- ENDGLOBAL gallery_empty -->
		</table>
		<!-- INCLUDE pagination_box.tpl -->
	</td>
</tr>