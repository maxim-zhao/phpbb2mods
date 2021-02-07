
<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post">

{ERROR_BOX}
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="crumbs">
	<tr>
		<td align="left">
			<span class="gensmall"><a href="{U_INDEX}" class="nav">{L_INDEX}</a>{PLOCATION}</span>
		</td>
	</tr>
</table>

<table width="800px" border="0" cellpadding="3" cellspacing="1" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25" valign="middle" align="left"><b>{L_AVATAR}</b></th>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="thHead"><small class="nav"><a href="profile.php?mode=editprofile&pmode=1">{L_USER}</a>&nbsp;|&nbsp;<a href="{S_PROFILE_LINK2}">{L_PROFILE}</a>&nbsp;|&nbsp;<a href="{S_PROFILE_LINK3}">{L_FORUM}</a>&nbsp;|&nbsp;{L_AVATAR}</small></span></td>
	</tr>
	<!-- BEGIN switch_avatar_block -->
	<tr> 
		<td class="row1" colspan="2"><table width="100%" cellspacing="2" cellpadding="0" border="0">
			<tr> 
				<td width="65%"><span class="gensmall">{L_AVATAR_EXPLAIN}</span></td>
				<td align="center"><span class="gensmall">{L_CURRENT_IMAGE}</span><br />{AVATAR}<br /><input type="checkbox" name="avatardel" />&nbsp;<span class="gensmall">{L_DELETE_AVATAR}</span></td>
			</tr>
		</table></td>
	</tr>
	<!-- BEGIN switch_avatar_local_upload -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_AVATAR_FILE}:</span></td>
		<td class="row2"><input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_SIZE}" /><input type="file" name="avatar" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_local_upload -->
	<!-- BEGIN switch_avatar_remote_upload -->
	<tr> 
		<td class="row1"><span class="gen">{L_UPLOAD_AVATAR_URL}:</span><br /><span class="gensmall">{L_UPLOAD_AVATAR_URL_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="avatarurl" size="40" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_remote_upload -->
	<!-- BEGIN switch_avatar_remote_link -->
	<tr> 
		<td class="row1"><span class="gen">{L_LINK_REMOTE_AVATAR}:</span><br /><span class="gensmall">{L_LINK_REMOTE_AVATAR_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="avatarremoteurl" size="40" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_remote_link -->
	<!-- BEGIN switch_avatar_local_gallery -->
	<tr> 
		<td class="row1"><span class="gen">{L_AVATAR_GALLERY}:</span></td>
		<td class="row2"><input type="submit" name="avatargallery" value="{L_SHOW_GALLERY}" class="liteoption" /></td>
	</tr>
	<!-- END switch_avatar_local_gallery -->
	<!-- END switch_avatar_block -->
	<tr>
		<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></td>
	</tr>
</table>

</form>
