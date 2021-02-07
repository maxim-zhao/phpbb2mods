<script language="javascript" type="text/javascript">
<!--
function jump_to(){
	opener.document.location.href = "{U_TOPIC}";
	window.close();
}
function view_profile(profile){
	opener.document.location.href = profile;
}
//-->
</script>
<table cellspacing="1" cellpadding="2" border="0" width="100%" class="forumline">
<tr>
	<th colspan="3" class="thHead" height="50" nowrap="nowrap">{L_USERS_WHO_POSTED} ::<br />{NAME}</th>
</tr>
<!-- BEGIN posters_row -->
<tr>
	<td height="15"><span class="gensmall">{posters_row.NUMBER}</span</td>
	<td><span class="gen">{posters_row.USER}</span></td>
	<td align="center"><span class="gen">{posters_row.POSTS}</span></td>
</tr>
<!-- END posters_row -->
<tr>
	<td colspan="3" align="center" height="25" valign="bottom"><a class="genmed" href="{U_TOPIC}" onclick="jump_to();return false;">{L_OPEN_TOPIC}</a></td>
</tr>
</table>