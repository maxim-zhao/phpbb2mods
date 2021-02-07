<!-- $Id: backup_body.tpl 8 2006-04-13 18:07:42Z vic $ -->

<h1>{L_SB_TITLE}</h1>

<p>
	{L_SB_EXPLAIN}
	<br /><br />
</p>

<form id="sb_backup" name="sb_backup" action="{S_SUBMIT}" method="post">
<table width="80%" cellspacing="1" cellpadding="0" border="0" align="center" class="forumline">
	<tr>
		<th>{L_SB_BODY_TH}</th>
	</tr>
	<tr>
		<td class="row1">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<!-- BEGIN sql_tables -->
					<tr>
						<td class="{sql_tables.CLASS}">
							<table width="100%" cellpadding="2" cellspacing="0" border="0">
								<td width="30">
									<input type="checkbox" name="table__{sql_tables.V_FIELD_NAME}" value="1"{sql_tables.V_CHECKED} />
								</td>
								<td>
									<span class="genmed">
										{sql_tables.V_NAME}
									</span>
								</td>
							</table>
						</td>
					</tr>
				<!-- END sql_tables -->
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" class="catbottom">
			<input type="button" name="select_all" value="{L_SB_SELECT_ALL}" class="liteoption" onclick="javascript:sb_select_all()" />
			<input type="button" name="deselect_all" value="{L_SB_DESELECT_ALL}" class="liteoption" onclick="javascript:sb_deselect_all()" />
		</td>
	</tr>
</table>
<br />
<table width="80%" cellspacing="1" cellpadding="0" border="0" align="center" class="forumline">
	<tr>
		<th>{L_SB_COMPRESSION_TH}</th>
	</tr>
	<tr>
		<td class="row1" align="center">
			<br />
			{L_DB_SIZE}: {V_DB_SIZE}<br /><br />
			<label for="compress_method">{L_COMPRESSION}: </label>
			<select name="compress_method">
				<option value="0">{L_NONE}</option>
				<option value="1">.zip</option>
				<option value="2">.tar</option>
				<option value="3">.tgz</option>
				<option value="4">.tar.gz</option>
				<option value="5">.tar.bz2</option>
			</select>
			<br />&nbsp;
		</td>
	</tr>
	<tr>
		<td align="center" class="catbottom">
			<input type="submit" name="backup" value="{L_SB_CREATE}" class="mainoption" />
		</td>
	</tr>
</table>
</form>

<br clear="all" />

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center">
			<span class="copyright">SQL Backup MOD &copy; 2005-2006 Vic D'Elfant<br />[ <a href="http://www.phpbb.com/phpBB/profile.php?mode=viewprofile&u=118634" class="copyright" target="_blank">phpBB.com {L_PROFILE}</a> :: <a href="http://www.coronis.nl" class="copyright" target="_blank">{L_WEBSITE}</a> ]</span>
		</td>
	</tr>
</table>

<script language="JavaScript" type="text/javascript">
	function sb_select_all()
	{
		for ( var i = 0; i < document.getElementById('sb_backup').elements.length; i++ )
		{
    		var element = document.getElementById('sb_backup').elements[i];
    		if ( element.type == 'checkbox' )
			{
				element.checked = true;
    		}
  		}
	}

	function sb_deselect_all()
	{
		for ( var i = 0; i < document.getElementById('sb_backup').elements.length; i++ )
		{
    		var element = document.getElementById('sb_backup').elements[i];
    		if ( element.type == 'checkbox' )
			{
				element.checked = false;
    		}
  		}
	}
</script>
<br />