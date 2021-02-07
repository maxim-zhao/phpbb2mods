<!-- $Id: backup_list_body.tpl 8 2006-04-13 18:07:42Z vic $ -->

<h1>{L_DOWNLOAD_TITLE}</h1>
<p>
	{L_DOWNLOAD_EXPLAIN}
</p>

<br />

<table width="80%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="4">{L_DOWNLOAD_TH_TITLE}</th>
	</tr>
	<tr>
		<td class="row3">
			<span class="genmed">
				<b>{L_DOWNLOAD_DATETIME}</b>
			</span>
		</td>
		<td width="150" class="row3" align="center">
			<span class="genmed">
				<b>{L_COMPRESSION}</b>
			</span>
		</td>
		<td width="80" class="row3" align="center">
			<span class="genmed">
				<b>{L_DOWNLOAD_SIZE}</b>
			</span>
		</td>
		<td width="180" class="row3" align="center">
			<span class="genmed">
				<b>{L_DOWNLOAD_ACTION}</b>
			</span>
		</td>
	</tr>
	<!-- BEGIN switch_no_backups -->
	<tr style="height: 45px">
		<td colspan="4" align="center" class="row1">
			<span class="genmed">
				{L_NO_BACKUPS}
			</span>
		</td>
	</tr>
	<!-- END switch_no_backups -->
	<!-- BEGIN backups -->
	<tr>
		<td class="row1">
			<span class="genmed">
				{backups.V_DATETIME}
			</span>
		</td>
		<td class="row1" align="center">
			<span class="genmed">
				{backups.V_COMPRESSION}
			</span>
		</td>
		<td class="row1" align="center">
			<span class="genmed">
				{backups.V_SIZE}
			</span>
		</td>
		<td class="row1" align="center">
			<span class="genmed">
				<a href="{backups.U_DOWNLOAD}">{L_DOWNLOAD}</a> | <a href="{backups.U_DELETE}">{L_DELETE}</a>
			</span>
		</td>
	</tr>
	<!-- END backups -->
</table>

<br clear="all" />

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<span class="copyright">SQL Backup MOD &copy; 2005-2006 Vic D'Elfant<br />[ <a href="http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&u=118634" class="copyright" target="_blank">phpBB.com {L_PROFILE}</a> :: <a href="http://www.coronis.nl" class="copyright" target="_blank">{L_WEBSITE}</a> ]</span>
		</td>
	</tr>
</table>

<br />