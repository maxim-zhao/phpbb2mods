<script language="JavaScript" type="text/javascript">
<!--

function submitForm()
{
	document.post.post.disabled = 'true';
	document.post.post.value="{L_SENDING}";
	document.post.submit();
}

//-->
</script>

<style type="text/css">
<!--
/* General text */
.survey_gen { font-size : {T_FONTSIZE3}px; }
.survey_genmed { font-size : {T_FONTSIZE2}px; }
.survey_gensmall { font-size : {T_FONTSIZE1}px; }
.survey_gen,.survey_genmed,.survey_gensmall { color : {T_BODY_TEXT}; }
a.survey_gen,a.survey_genmed,a.survey_gensmall { color: {T_BODY_LINK}; text-decoration: none; }
a.survey_gen:hover,a.survey_genmed:hover,a.survey_gensmall:hover	{ color: {T_BODY_HLINK}; text-decoration: underline; }
-->
</style>

<form action="{S_ANSWER_ACTION}" method="post" name="post"><br clear="all" />
<tr> 
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
	  <tr> 
		<th class="thHead"><b>{SURVEY_CAPTION}</b></th>
	  </tr>
	  <tr><td><br /></td></tr>
	  <tr> 
		<td align="center"> 
		  <table cellspacing="0" cellpadding="2" border="0">

		  	<!-- BEGIN switch_username_select -->
			<tr> 
				<td align="center" width="300px"><span class="survey_gen"><b>{L_USERNAME_TAKING_SURVEY}</b></span></td><td>&nbsp;&nbsp;&nbsp;</td>
				<td align="left"><span class="survey_gen"><input type="text"  class="post" name="username" maxlength="25" size="25" tabindex="1" value="{OTHER_USER}" />&nbsp;<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></span></td><td><br /><br /></td>
				<td>&nbsp;</td><td>&nbsp;</td>				
			</tr>
			<tr>
				<td align="center" width="300px">&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
				<td align="center">{S_HIDDEN_FIELDS}<input type="submit" name="retrieve_answers_for_other_user" value="{L_RETRIEVE_ANSWERS_FOR_OTHER_USER}" class="mainoption" /></td>
				<td>&nbsp;</td><td>&nbsp;</td>
			</tr>
			
			<tr>
				<td align="center" width="300px">&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
				<td align="left"><span class="survey_gen"><b>{OTHER_USER_ANSWERED_OR_NOT}</b></span></td>
				<td>&nbsp;</td><td>&nbsp;</td>
			
			<tr><td><br /><br /><br /></td></tr>
			<!-- END switch_username_select -->

			<!-- BEGIN question_rows -->
			<tr> 
			  <td align="center" width="300px" valign="center"><span class="survey_gen"><b>{question_rows.QUESTION}</b></span></td><td>&nbsp;&nbsp;&nbsp;</td>
			  <td align="left" valign="center"><span class="survey_gen"><b>{question_rows.ANSWER}</b></span></td><td><br /><br /></td>
			</tr>
			<tr><td><br /><br /></td></tr>
			<!-- END question_rows -->
	
		  </table>
		</td>
	  </tr>
			
	  <tr>
		<td align="center">{S_HIDDEN_FIELDS}<input type="submit" name="complete" value="{L_SUBMIT}" class="mainoption" onclick="submitForm();" /></td>
	  </tr>
	<tr>
		<td class="catBottom" height="28">&nbsp;</td>
	</tr>	  
	</table>
</tr>
</form>