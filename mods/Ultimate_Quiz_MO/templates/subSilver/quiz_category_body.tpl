<table width="100%" border="0" align="right">
	<tr>
		<td width="50%" align="left" valign="middle" height="10">
			<span class="genmed"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span>
		</td>
		<td width="50%" align="right" valign="middle" height="10">
			<span class="genmed"><b>{U_STATISTICS_LINK}&nbsp&middot;&nbsp{U_SUBMIT_QUIZ}</b></span>
		</td>
	</tr>
</table>
<br />
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
	<tr>
		<td colspan="4" align="center" width="100%" class="catSides" nowrap="nowrap">&nbsp;<span class="cattitle">{U_QUIZZES}</span>&nbsp;</td>
	</tr>
	
	<!-- BEGIN nothing_row -->
	<tr>
		<td width="100%" colspan="3" class="row1" align="center" valign="middle" height="100%">
			<span class="gen">{nothing_row.L_NO_RESULTS}</span>
		</td>
	</tr>
	<!-- END nothing_row -->
		
	<!-- BEGIN play_row -->
	<tr>
		<td width="40%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">{play_row.U_QUIZ_LINK}</span>
		</td>
			
		<td width="20%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				{play_row.U_AUTHOR}
			</span>
		</td>
		
		<td width="20%" class="row1" align="center" valign="middle" height="100%">
			<span class="genmed">
				{play_row.U_TYPE}
			</span>
		</td>
		
		<td width="20%" class="row2" align="center" valign="middle" height="100%">
			<span class="genmed">
				{play_row.U_PLAYS}
			</span>
		</td>
	</tr>
	<!-- END play_row -->		

	<tr>
		<th colspan="4" width="100%" class="thTop" nowrap="nowrap">
			<form action="{F_FORM}" method="post">
				<select name="view_method">
					<option value="1">{L_VIEW_ALPHABETICAL}</option>
					<option value="4">{L_VIEW_AUTHOR}</option>
					<option value="2">{L_VIEW_CHRONILOGICAL}</option>
					<option value="3">{L_VIEW_TYPE}</option>
				</select>
			
				&nbsp;
			
				<input class="liteoption" type="submit" value="{L_SUBMIT}" />
			</form>
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