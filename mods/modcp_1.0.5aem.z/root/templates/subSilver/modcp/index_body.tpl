<h1>{L_WELCOME}</h1>
<p>{L_ADMIN_INTRO}</p>
<h1>{L_FORUM_STATS}</h1>
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<th width="25%" nowrap="nowrap" height="25" class="thCornerL">{L_STATISTIC}</th>
		<th width="25%" height="25" class="thTop">{L_VALUE}</th>
		<th width="25%" nowrap="nowrap" height="25" class="thTop">{L_STATISTIC}</th>
		<th width="25%" height="25" class="thCornerR">{L_VALUE}</th>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_NUMBER_POSTS}:</span></td>
		<td class="row2"><b><span class="gen">{NUMBER_OF_POSTS}</span></b></td>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_POSTS_PER_DAY}:</span></td>
		<td class="row2"><b><span class="gen">{POSTS_PER_DAY}</span></b></td>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_NUMBER_TOPICS}:</span></td>
		<td class="row2"><b><span class="gen">{NUMBER_OF_TOPICS}</span></b></td>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_TOPICS_PER_DAY}:</span></td>
		<td class="row2"><b><span class="gen">{TOPICS_PER_DAY}</span></b></td>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_NUMBER_USERS}:</span></td>
		<td class="row2"><b><span class="gen">{NUMBER_OF_USERS}</span></b></td>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_USERS_PER_DAY}:</span></td>
		<td class="row2"><b><span class="gen">{USERS_PER_DAY}</span></b></td>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_BOARD_STARTED}:</span></td>
		<td class="row2"><b><span class="gen">{START_DATE}</span></b></td>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_AVATAR_DIR_SIZE}:</span></td>
		<td class="row2"><b><span class="gen">{AVATAR_DIR_SIZE}</span></b></td>
	</tr>
	<tr>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_DB_SIZE}:</span></td>
		<td class="row2"><b><span class="gen">{DB_SIZE}</span></b></td>
		<td class="row1" nowrap="nowrap"><span class="gen">{L_GZIP_COMPRESSION}:</span></td>
		<td class="row2"><b><span class="gen">{GZIP_COMPRESSION}</span></b></td>
	</tr>
</table>
<h1>{L_WHO_IS_ONLINE}</h1>
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
	<tr>
		<th width="20%" class="thCornerL" height="25">&nbsp;{L_USERNAME}&nbsp;</th>
		<th width="20%" height="25" class="thTop">&nbsp;{L_STARTED}&nbsp;</th>
		<th width="20%" class="thTop">&nbsp;{L_LAST_UPDATE}&nbsp;</th>
		<th width="20%" class="thCornerR">&nbsp;{L_FORUM_LOCATION}&nbsp;</th>
		<th width="20%" height="25" class="thCornerR">&nbsp;{L_IP_ADDRESS}&nbsp;</th>
	</tr>
	<!-- BEGIN reg_user_row -->
	<tr>
		<td width="20%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{reg_user_row.U_USER_PROFILE}" class="gen">{reg_user_row.USERNAME}</a></span>&nbsp;</td>
		<td width="20%" align="center" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen">{reg_user_row.STARTED}</span>&nbsp;</td>
		<td width="20%" align="center" nowrap="nowrap" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen">{reg_user_row.LASTUPDATE}</span>&nbsp;</td>
		<td width="20%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{reg_user_row.U_FORUM_LOCATION}" class="gen">{reg_user_row.FORUM_LOCATION}</a></span>&nbsp;</td>
		<td width="20%" class="{reg_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{reg_user_row.U_WHOIS_IP}" class="gen" target="_phpbbwhois">{reg_user_row.IP_ADDRESS}</a></span>&nbsp;</td>
	</tr>
	<!-- END reg_user_row -->
	<tr>
		<td colspan="5" height="1" class="row3"><img src="../templates/subSilver/images/spacer.gif" width="1" height="1" alt="."></td>
	</tr>
	<!-- BEGIN guest_user_row -->
	<tr>
		<td width="20%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.USERNAME}</span>&nbsp;</td>
		<td width="20%" align="center" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.STARTED}</span>&nbsp;</td>
		<td width="20%" align="center" nowrap="nowrap" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen">{guest_user_row.LASTUPDATE}</span>&nbsp;</td>
		<td width="20%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{guest_user_row.U_FORUM_LOCATION}" class="gen">{guest_user_row.FORUM_LOCATION}</a></span>&nbsp;</td>
		<td width="20%" class="{guest_user_row.ROW_CLASS}">&nbsp;<span class="gen"><a href="{guest_user_row.U_WHOIS_IP}" target="_phpbbwhois">{guest_user_row.IP_ADDRESS}</a></span>&nbsp;</td>
	</tr>
	<!-- END guest_user_row -->
</table>
<br />