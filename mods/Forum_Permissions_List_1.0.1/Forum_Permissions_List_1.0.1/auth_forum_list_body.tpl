
<h1>{L_AUTH_TITLE}</h1>

<p>{L_AUTH_EXPLAIN}</p>

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thTop">{L_FORUM_NAME}</th>
		<!-- BEGIN forum_auth_titles -->
		<th class="thTop">{forum_auth_titles.CELL_TITLE}</th>
		<!-- END forum_auth_titles -->
	</tr>
	<!-- BEGIN cat_row -->
	<tr>
		<td height="28" class="catSides" colspan="{S_COLUMN_SPAN}"><span class="cattitle"><a href="{cat_row.CAT_URL}" class="cattitle">{cat_row.CAT_NAME}</a></span></td>
	</tr>
	<!-- BEGIN forum_row -->
	<tr>
		<td class="{cat_row.forum_row.ROW_CLASS}" align="center">{cat_row.forum_row.FORUM_NAME}</td>
		<!-- BEGIN forum_auth_data -->
		<td class="{cat_row.forum_row.ROW_CLASS}" align="center"><span class="genMed" title="{cat_row.forum_row.forum_auth_data.AUTH_EXPLAIN}">{cat_row.forum_row.forum_auth_data.CELL_VALUE}</span></td>
		<!-- END forum_auth_data -->
	</tr>
	<!-- END forum_row -->
	<!-- END cat_row -->
</table>
<br />
