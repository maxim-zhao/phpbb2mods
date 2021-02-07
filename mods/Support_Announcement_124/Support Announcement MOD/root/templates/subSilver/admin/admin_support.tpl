
<h1>{L_SUPPORT_CONFIGURATION_TITLE}</h1>

<p>{L_SUPPORT_CONFIGURATION_EXPLAIN}</p>

<form action="{S_SUPPORT_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_SUPPORT_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_DISPLAY}<br /><span class="gensmall">{L_SUPPORT_DISPLAY_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="support_display" value="1" {S_SUPPORT_DISPLAY_ON} /> {L_ON}&nbsp;&nbsp;<input type="radio" name="support_display" value="0" {S_SUPPORT_DISPLAY_OFF} /> {L_OFF}</td>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_STATUS}<br /><span class="gensmall">{L_SUPPORT_STATUS_EXPLAIN}</span></td>
		<td class="row2"><input type="radio" name="support_status" value="1" {S_SUPPORT_STATUS_ON} /> {L_ON}&nbsp;&nbsp;<input type="radio" name="support_status" value="0" {S_SUPPORT_STATUS_OFF} /> {L_OFF}</td>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_IMAGE}<br /><span class="gensmall">{L_SUPPORT_IMAGE_IMAGE}</span></td>
		<td class="row2"><input class="post" type="text" size="50" maxlength="255" name="support_image" value="{SUPPORT_IMAGE}" /></td>
	</tr>
	<tr>
		<th class="thHead" colspan="2">{L_SUPPORT_ONLINE_DETAIL}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_SUPPORT_DEATIL_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_ONLINE_ADMIN}<br /><span class="gensmall">{L_SUPPORT_ONLINE_ADMIN_EXPLAIN}</span></td>
		<td class="row2"><textarea name="support_online_admin" rows="5" cols="50">{SUPPORT_ONLINE_ADMIN}</textarea></td>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_N_TEXT}<br /><span class="gensmall">{L_SUPPORT_N_TEXT_EXPLAIN}</span></td>
		<td class="row2"><textarea name="support_onlinetext" rows="5" cols="50">{SUPPORT_N_TEXT}</textarea></td>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_N_CONTACT}<br /><span class="gensmall">{L_SUPPORT_N_CONTACT_EXPLAIN}</span></td>
		<td class="row2"><textarea name="support_onlinecontact" rows="5" cols="50">{SUPPORT_N_CONTACT}</textarea></td>
	</tr>
	<tr>
		<th class="thHead" colspan="2">{L_SUPPORT_OFFLINE_DETAIL}</th>
	</tr>
	<tr>
		<td class="row2" colspan="2"><span class="gensmall">{L_SUPPORT_DEATIL_EXPLAIN}</span></td>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_OFFLINE_ADMIN}<br /><span class="gensmall">{L_SUPPORT_OFFLINE_ADMIN_EXPLAIN}</span></td>
		<td class="row2"><textarea name="support_offline_admin" rows="5" cols="50">{SUPPORT_OFFLINE_ADMIN}</textarea></td>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_F_TEXT}<br /><span class="gensmall">{L_SUPPORT_F_TEXT_EXPLAIN}</span></td>
		<td class="row2"><textarea name="support_offlinetext" rows="5" cols="50">{SUPPORT_F_TEXT}</textarea></td>
	</tr>
	<tr>
		<td class="row1">{L_SUPPORT_F_CONTACT}<br /><span class="gensmall">{L_SUPPORT_F_CONTACT_EXPLAIN}</span></td>
		<td class="row2"><textarea name="support_offlinecontact" rows="5" cols="50">{SUPPORT_F_CONTACT}</textarea></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<center><span class="copyright">{L_SUPPORT_VERSION}</span></center>

<br clear="all" />
