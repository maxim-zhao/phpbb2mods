<table width="100%" cellpadding="1" cellspacing="1" border="0" align="center" class="forumline">
	<th colspan="{COLS}" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{L_LATEST_USERS_ONLINE}&nbsp;</th>

	<!-- BEGIN row_loop -->
	<tr>
	<!-- BEGIN users_loop -->
		<td width="{LOOP_WIDTH}%" align="center" class="row1">
			<table width="100%" cellpadding="1" cellspacing="1" border="0" align="center">
				<td width="100%">
					<tr><div style="float:left"><a href="{row_loop.users_loop.LINK}"><img src="{row_loop.users_loop.AVATAR}"  border="0" style="max-width: {MAX_WIDTH}; max-height: {MAX_HEIGHT}; position:asolute; top:0%;"  /></a></div></tr>

					<tr height="100%"><a href="{row_loop.users_loop.LINK}"><span class="gen">{row_loop.users_loop.USERNAME}</span><br />
						<span class="gensmall">{row_loop.users_loop.LOCATION}</span></a></tr>
					</td>
				
			</table>
		</td>
	<!-- END users_loop -->
	<!-- BEGIN extra_col -->
		<td width="100%" class="row2" colspan="{row_loop.extra_col.COLUMN_SPAN}">
			&nbsp;
		</td>
	</tr>
	<!-- END extra_col -->
	<!-- END row_loop -->
</table>