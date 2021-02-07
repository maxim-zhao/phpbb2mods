
<h1>{L_BANNER_TITLE}</h1>

<p>{L_BANNER_TEXT}</p>

<form method="post" action="{S_BANNER_ACTION}">
	<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
		<tr>
			<th class="thHead">{L_BANNER_CAPTION}</th>
		</tr>
		<tr>
			<td>
				<table cellspacing="0" cellpadding="5" border="0" align="center">
					<!-- BEGIN banner_row -->
					<tr>
						<!-- BEGIN banner_column -->
						<td class="row1" align="center"><img src="../{BANNER_PATH}/{banner_row.banner_column.BANNER_IMAGE}" alt="{banner_row.banner_column.BANNER_IMAGE}" title="{banner_row.banner_column.BANNER_IMAGE}" /></td>
						<!-- END banner_column -->
					</tr>
					<tr>
						<!-- BEGIN banner_option_column -->
						<td class="row2" align="center"><input type="radio" name="banner_source" value="{banner_row.banner_option_column.S_OPTIONS_BANNER}" {banner_row.banner_option_column.S_CURRENT_BANNER} /></td>
						<!-- END banner_option_column -->
					</tr>
					<!-- END banner_row -->
				</table>
			</td>
		</tr>
		<tr>
			<th class="thHead">{L_BANNER_SIZE}</th>
		</tr>
		<tr>
			<td class="row1">
				{L_BANNER_SIZE}&nbsp;<span class="gensmall">{L_BANNER_SIZE_EXPLAIN}</span>:&nbsp;&nbsp;
				<input class="post" type="text" size="3" maxlength="4" name="banner_width" value="{BANNER_WIDTH}" />
				&nbsp;x&nbsp;
				<input class="field" type="text" size="3" maxlength="4" name="banner_height" value="{BANNER_HEIGHT}" />
			</td>
		</tr>
		<tr>
			<td class="catBottom" align="center">
				<input type="submit" name="add" value="{L_BANNER_CHOOSE}" class="mainoption" />
			</td>
		</tr>
	</table>
</form>
