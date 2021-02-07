<form action="{F_FORM}" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<tr>
		<td colspan="3" align="center" width="100%" class="catSides" nowrap="nowrap">&nbsp;<span class="cattitle">{L_EDITING}</span>&nbsp;</td>
	</tr>
	
	<tr>
		<td width="100%" colspan="3" class="row1" align="center" valign="middle" height="100%">
			<span class="gen">{L_EXPLAINATION}</span>
		</td>
	</tr>

	<tr>
		<td width="34%" colspan="1" class="row1" align="center" valign="middle" height="100%">
			<span class="gen">{L_NAME} <input type="text" size="10" name="name" value="{U_NAME}" /></span>
		</td>

		<td width="33%" colspan="1" class="row1" align="center" valign="middle" height="100%">
			<span class="gen">{L_DESCRIPTION} <input type="text"  size="10" name="description" value="{U_DESCRIPTION}" /></span>
		</td>
		
		<td width="33%" colspan="1" class="row1" align="center" valign="middle" height="100%">
			<span class="gen">{L_PASSWORD} <input type="password"  size="10" name="password" value="" /></span>
		</td>
	</tr>
	
	<tr>
		<td width="100%" colspan="3" class="row1" align="center" valign="middle" height="100%">
			<span class="gen">{L_CHOOSE_PER} 
				<select name="permissions">
					<option id="0" value="0">{L_GUEST}</option>
					<option id="1" value="1">{L_REG}</option>
					<option id="2" value="2">{L_REG_HIDDEN}</option>
				</select>
			</span>
		</td>
	</tr>
	
	<tr>
		<th colspan="3" width="100%" class="thTop" nowrap="nowrap">
			<input class="liteoption" type="submit" value="{L_SUBMIT}" />
		</th>
	</tr>
</table>
</form>