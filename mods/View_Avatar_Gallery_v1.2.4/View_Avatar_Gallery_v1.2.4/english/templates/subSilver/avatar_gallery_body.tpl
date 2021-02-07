
<form action="{AVT_GLR_POST}" method="post">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	</tr>
</table>

<table border="0" cellpadding="3" cellspacing="0" width="100%" class="forumline">
	<tr> 
		<th class="thHead" colspan="{S_COLSPAN}" height="25" valign="middle">{L_AVATAR_GALLERY}</th>
	</tr>
	<tr> 
		<td class="catBottom" align="center" valign="middle" colspan="6" height="28"><span class="genmed">{L_CATEGORY}:&nbsp;{S_CATEGORY_SELECT}&nbsp;<input type="submit" class="liteoption" value="{L_GO}" name="avatargallery" /></span></td>
	</tr>
	<!-- BEGIN avatar_row -->
	<tr> 
	<!-- BEGIN avatar_column -->
		<td class="row1" align="center" valign="middle" width="20%">{avatar_row.avatar_column.CHOICE_SUBMIT}{avatar_row.avatar_column.AVATAR}{avatar_row.avatar_column.CHOICE_SUBMIT_END}<br /></td>
	<!-- END avatar_column -->
	</tr>
    <!-- END avatar_row -->
	<tr> 
		<td class="catbottom"  align="center" valign="middle" colspan="5" height="28"><span class="gensmall">{AVATAR_CHOICE_ENABLED_EXPLAIN}</span>{S_HIDDEN_FIELDS} &nbsp;</td>
	</tr>
</table>
<br />
<div align="center"><span class="copyright">{AVATAR_GALLERY_COPY}</span></div>
</form>
