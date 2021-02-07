<form method="post" action="{F_FORM}">
<input type="hidden" name="quizzes" value="{U_QUIZZES}" /> 

	<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
		<tr>
			<th colspan="2" width="100%" class="thTop" nowrap="nowrap">&nbsp;{L_EDIT}&nbsp;</th>
		</tr>
		
		<tr>
			<td class="row2" colspan="2" align="center" valign="middle">
				<span class="gen">{L_EXPLAIN}</span>
			</td>
		</tr>
		
		<tr>
			<td class="row1" colspan="2" align="center" valign="middle">
				<span class="gen"><br />{L_NAME} <input type="text" name="name" value="{U_NAME}" /><br /><br /></span>
			</td>
		</tr>
		
	<!-- BEGIN edit_row -->
		<tr>
			<td class="row2" width="70%" colspan="1" align="center" valign="middle">
				<span class="gen">
					{L_QUESTION} <input type="text" name="Q_{edit_row.U_QUESTION_ID}" value="{edit_row.U_QUESTION}" /><br />
				</span>
			</td>
			
			<td class="row2" width="30%" colspan="1" align="center" valign="middle">
				<span class="gen">
					<input type="radio" name="A_{edit_row.U_QUESTION_ID}" value="{L_TRUE}" /> {L_TRUE}
					<input type="radio" name="A_{edit_row.U_QUESTION_ID}" value="{L_FALSE}" /> {L_FALSE}
				</span>
			</td>
		</tr>
	<!-- END edit_row -->	
	
		<tr>
			<th colspan="3" class="catBottom" align="center" height="28">
				<input class="liteoption" type="submit" name="submit" value="{L_SUBMIT}" />
			</th>
		</tr>
	</table> 
</form>