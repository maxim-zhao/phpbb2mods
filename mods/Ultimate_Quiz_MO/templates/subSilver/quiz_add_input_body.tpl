<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
<tr>
<th colspan="2" width="100%" class="thTop" nowrap="nowrap">&nbsp;{L_SUBMIT}&nbsp;</th>
</tr>
<tr>
<form action="{F_FORM}" method="post">
<td class="row1" align="center" height="55" colspan="2"><span class="gensmall"><input type="text" class="post"  name="Quiz_Name" size="50" maxlength="60" value="{L_INSERT_NAME}" /> {U_CATEGORY}</span></td>
</tr>
<input type="hidden" name="Quiz_Type" value="Input">
<input type="hidden" name="Quiz_Question" value="{U_TOTAL}">
<!-- BEGIN question_number -->
<tr>
<td class="row1" align="center" valign="middle" height="25" width="55%"><span class="forumlink">
<input type="text" class="post" name="Question_{question_number.U_UNIQUE}" size="50" maxlength="1000" value="{L_QUESTION}" />
</span></td>
<td class="row2" align="center" valign="center" height="65" width="45%"><span class="forumlink">
<input type="text" class="post"  name="Correct_Answer_{question_number.U_UNIQUE}" size="50" maxlength="1000" value="{L_CORRECT_ANSWER}" /> 
</span></td>
</tr>
<!-- END question_number -->  
<tr>
<th class="catBottom" colspan="4" align="center" height="28"><input class="liteoption" type="submit" value="{L_SUBMIT}" /></form>
</td>
</th>
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