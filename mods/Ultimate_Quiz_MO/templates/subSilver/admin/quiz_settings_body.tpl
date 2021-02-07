<form action="{F_FORM}" method="post">
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<tr>
		<td colspan="3" align="center" width="100%" class="catSides" nowrap="nowrap">&nbsp;<span class="cattitle">{L_PERMISSIONS}</span>&nbsp;</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_AUTHOR_MOD}</span>
		</td>
			
		<td width="15%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Author_Mod" {U_AUTHOR_MOD_ON} value="{U_ON}"> {L_YES}
			</span>
		</td>
		
		<td width="15%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Author_Mod" {U_AUTHOR_MOD_OFF} value="{U_OFF}"> {L_NO}
			</span>
		</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_REGISTER_TO_PLAY}</span>
		</td>
			
		<td width="15%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Register_Play" {U_REGISTER_TO_PLAY_ON} value="{U_ON}"> {L_YES}
			</span>
		</td>
		
		<td width="15%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Register_Play" {U_REGISTER_TO_PLAY_OFF} value="{U_OFF}"> {L_NO}
			</span>
		</td>
	</tr>
	
	<!-- BEGIN register_row -->
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_POST_COUNT}</span>
		</td>
			
		<td width="15%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Post_Count_Play" {U_POST_COUNT_ON} value="{U_ON}"> {L_YES}
			</span>
		</td>
		
		<td width="15%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Post_Count_Play" {U_POST_COUNT_OFF} value="{U_OFF}"> {L_NO}
			</span>
		</td>
	</tr>

	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_POST_REQUIREMENT}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_Post_Requirement" size="16" value="{U_MINIMUM_POST_REQUIRED}">
			</span>
		</td>
	</tr>
	<!-- END register_row -->		

	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_MODERATORS}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_Moderators" size="16" value="{U_MODERATORS}">
			</span>
		</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_BANNED}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_Banned" size="16" value="{U_BANNED}">
			</span>
		</td>
	</tr>

	<tr>
		<td colspan="3" align="center" width="100%" class="catSides" nowrap="nowrap">&nbsp;<span class="cattitle">{L_CONFIGURATION}</span>&nbsp;</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_SHOW_ANSWERS}</span>
		</td>
			
		<td width="15%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_show_answers" {U_SHOW_ANSWERS_ON} value="{U_ON}"> {L_YES}
			</span>
		</td>
		
		<td width="15%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_show_answers" {U_SHOW_ANSWERS_OFF} value="{U_OFF}"> {L_NO}
			</span>
		</td>
	</tr>

	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_CASH_ON}</span>
		</td>
			
		<td width="15%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_CashMOD_On" {U_CASH_ON} value="{U_ON}"> {L_YES}
			</span>
		</td>
		
		<td width="15%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_CashMOD_On" {U_CASH_OFF} value="{U_OFF}"> {L_NO}
			</span>
		</td>
	</tr>	
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_MOD_SUBMIT}</span>
		</td>
			
		<td width="15%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Mod_Submit" {U_MOD_SUBMIT_ON} value="{U_ON}"> {L_YES}
			</span>
		</td>
		
		<td width="15%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Mod_Submit" {U_MOD_SUBMIT_OFF} value="{U_OFF}"> {L_NO}
			</span>
		</td>
	</tr>	
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_STATS_DISPLAY}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_Stats_Display" size="5" value="{U_QUIZ_STATS_DISPLAY}">
			</span>
		</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_PLAY_ONCE}</span>
		</td>
			
		<td width="15%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Play_Once" {U_PLAY_ONCE_ON} value="{U_ON}"> {L_YES}
			</span>
		</td>
		
		<td width="15%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Play_Once" {U_PLAY_ONCE_OFF} value="{U_OFF}"> {L_NO}
			</span>
		</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_AUTHOR_PLAY}</span>
		</td>
			
		<td width="15%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Author_Play" {U_AUTHOR_PLAY_ON} value="{U_ON}"> {L_YES}
			</span>
		</td>
		
		<td width="15%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				<input type="radio" name="Quiz_Author_Play" {U_AUTHOR_PLAY_OFF} value="{U_OFF}"> {L_NO}
			</span>
		</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_MIN_MAX_QUESTIONS}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_Min_Max_Questions" size="16" value="{U_MIN_MAX_QUESTIONS}">
			</span>
		</td>
	</tr>

	<!-- BEGIN cash_row -->		
	<tr>
		<td colspan="3" align="center" width="100%" class="catSides" nowrap="nowrap">&nbsp;<span class="cattitle">{L_CASH_SETTINGS}</span>&nbsp;</td>
	</tr>

	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_C_CURRENCY}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_admin_cash_currency" size="10" value="{U_C_CURRENCY}">
			</span>
		</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_C_CORRECT}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_admin_cash_correct" size="5" value="{U_C_CORRECT}">
			</span>
		</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_C_INCORRECT}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_admin_cash_incorrect" size="5" value="{U_C_INCORRECT}">
			</span>
		</td>
	</tr>
	
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			<span class="genmed">{L_C_TAX}</span>
		</td>
				
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				&nbsp;<input type="text" name="Quiz_admin_cash_tax" size="5" value="{U_C_TAX}">
			</span>
		</td>
	</tr>
	<!-- END cash_row -->		

	<tr>
		<td colspan="3" align="center" width="100%" class="catSides" nowrap="nowrap">&nbsp;<span class="cattitle">{L_CATEGORIES}</span>&nbsp;</td>
	</tr>
	
	<tr>
		<td width="100%" colspan="3" class="row1" align="center" valign="middle" height="100%">
			<span class="gen">{U_ADD_CATEGORY}</span>
		</td>
	</tr>
	
	<!-- BEGIN category_row -->		
	<tr>
		<td width="70%" class="row1" align="left" valign="middle" height="100%">
			&nbsp;<span class="genmed"><b>{category_row.U_NAME}</b></span><br /><span class="genmed">&nbsp;{category_row.U_DESCRIPTION}</span>
		</td>
			
		<td width="30%" colspan="2" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				{category_row.U_EDIT_CATEGORY}, {category_row.U_DELETE_CATEGORY}, {category_row.U_MOVE_CATEGORY}
			</span>
		</td>
	</tr>
	<!-- END category_row -->		
		
	<tr>
		<th colspan="3" width="100%" class="thTop" nowrap="nowrap">
			<input class="liteoption" type="submit" value="{L_SUBMIT}" />
		</th>
	</tr>
</table>
</form>

<table width="100%" border="0">
	<tr>
		<td border="0" align="left" width="100%"><span class="genmed">{Q_LATEST}</span></td>
	</tr>
</table> 