<!--- File Version 2.0.1 -->
<h1>{L_EXPIRE_ACCOUNT_TITLE}</h1>

<p>{L_EXPIRE_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	
	<tr>
		<td class="row1">{L_EXPIRE_CHOOSE}</td>
		<td class="row2"><select name="timeframe" />
		<option selected value="">{L_SELECT_TIMEFRAME_VALUE}</option>
		<option value="3600">{L_EXPIRE_HOUR}</option>
		<option value="86400">{L_EXPIRE_DAY}</option>
		<option value="604800">{L_EXPIRE_WEEK}</option>
		<option value="2419200">{L_EXPIRE_MONTH}</option>
		<option value="7257600">{L_EXPIRE_3MONTHS}</option>
		<option value="14515200">{L_EXPIRE_6MONTHS}</option>
		<option value="29030400">{L_EXPIRE_YEAR}</option>
		</select>
		</td>
	</tr>
	
	<tr>
		<td class="" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="manualsubmit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
	<p>{L_EXPIRE_AUTOMATION_EXPLAIN}<br /><br />{L_CURRENT_AUTOMATION_STATE}</p>
	
	<tr>
			<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="activate" value="{L_AUTOMATION_ACTIVATE}" class="mainoption" />&nbsp;&nbsp;<input type="submit" name="deactivate" value="{L_AUTOMATION_DEACTIVATE}" class="mainoption" />
			</td>
	</tr>
</table></form>

<br clear="all" />
