<table width="100%" border="0">
	<tr>
		<td width="50%" align="left" width="50%"><span class="genmed"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
		<td border="0" align="right" width="50%"><span class="genmed">&nbsp;{U_STATISTICS}&nbsp;</span></td>
	</tr>
</table> 

<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		<tr>
			<th colspan="2" width="100%" class="thTop" nowrap="nowrap">&nbsp;{U_QUIZ_NAME}&nbsp;</th>
		</tr>
		
		<tr>
			<td class="row1" width="100%" align="center" valign="middle" height="30" colspan="2">
				<span class="genmed">
					{L_MULTIPLE_INFORMATION}
				</span>
			</td>
		</tr>
		
	<form action="{F_FORM}" method="post">
	<input type="hidden" name="id" value="{F_ID}">
	<input type="hidden" name="type" value="{F_TYPE}">
	<!-- BEGIN quiz_row -->
		<tr>
			<td class="row3" colspan="2" width="100%" align="center" valign="middle" height="5">
			</td>
		</tr>	
	
		<tr>
			<td class="row1" rowspan="4" width="75%" align="center" valign="middle" height="100%">
				<span class="forumlink">
					{quiz_row.U_QUESTION}
				</span>
			</td>
			
			<td class="row2" width="25%" align="left" valign="middle" height="100%">
				<span class="gen">
					&nbsp;&nbsp;<input type="radio" name="{quiz_row.U_QUESTION_ID}" value="{quiz_row.Q_ALTERNATE_ONE}" /> {quiz_row.Q_ALTERNATE_ONE}
				</span>
			</td>
		</tr>
		
		<tr>
			<td class="row2" width="25%" align="left" valign="middle" height="100%">
				<span class="gen">
					&nbsp;&nbsp;<input type="radio" name="{quiz_row.U_QUESTION_ID}" value="{quiz_row.Q_ALTERNATE_TWO}" /> {quiz_row.Q_ALTERNATE_TWO}
				</span>
			</td>
		</tr>
		
		<tr>
			<td class="row2" width="25%" align="left" valign="middle" height="100%">
				<span class="gen">
					&nbsp;&nbsp;<input type="radio" name="{quiz_row.U_QUESTION_ID}" value="{quiz_row.Q_ALTERNATE_THREE}" /> {quiz_row.Q_ALTERNATE_THREE}
				</span>
			</td>
		</tr>
		
		<tr>
			<td class="row2" width="25%" align="left" valign="middle" height="100%">
				<span class="gen">
					&nbsp;&nbsp;<input type="radio" name="{quiz_row.U_QUESTION_ID}" value="{quiz_row.Q_ALTERNATE_FOUR}" /> {quiz_row.Q_ALTERNATE_FOUR}
				</span>
			</td>
		</tr>
	<!-- END quiz_row -->

		<tr>
			<th colspan="3" class="catBottom" align="center" height="28">
				<input class="liteoption" type="submit" value="{L_SUBMIT}" />
			</th>
		</tr>
	</form>
</table> 

<table width="100%" border="0">
	<tr>
		<td border="0"><span class="genmed">&nbsp;{L_MOD_LANGS}&nbsp;</span></td>
	</tr>
</table> 
<br />
<table width="100%" align="center" border="0">
	<tr>
		<td border="0" align="center">
			<span class="genmed">&nbsp;<a href="http://www.cmxmods.net/quiz.php">Ultimate Quiz MOD</a> &copy; <a href="http://www.online-scrabble.com">battye</a> 2004, 2005, 2006.&nbsp;
			</span>
		</td>
	</tr>
</table>