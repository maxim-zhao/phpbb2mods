
<h1>{L_RTHEMES_TITLE}</h1>

<p>{L_RTHEMES_TEXT}</p>

<form method="post" action="{S_RTHEME_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th class="thCornerL">{L_RTHEME}</th>
		<th class="thTop">{L_PUBLIC_RTHEME}</th>
		<th class="thTop">{L_EDIT}</th>
		<th class="thCornerR">{L_DELETE}</th>
	</tr>
	<!-- BEGIN rthemes -->
	<tr>
		<td class="{rthemes.ROW_CLASS}" align="center">{rthemes.RTHEME}</td>
		<td class="{rthemes.ROW_CLASS}" align="center">{rthemes.PUBLIC_RTHEME}</td>
		<td class="{rthemes.ROW_CLASS}" align="center"><a href="{rthemes.U_RTHEME_EDIT}">{L_EDIT}</a></td>
		<td class="{rthemes.ROW_CLASS}" align="center"><a href="{rthemes.U_RTHEME_DELETE}">{L_DELETE}</a></td>
	</tr>
	<!-- END rthemes -->
	<tr>
		<td class="catBottom" align="center" colspan="6"><input type="submit" class="mainoption" name="add" value="{L_ADD_RTHEME}" /></td>
	</tr>
</table></form>
