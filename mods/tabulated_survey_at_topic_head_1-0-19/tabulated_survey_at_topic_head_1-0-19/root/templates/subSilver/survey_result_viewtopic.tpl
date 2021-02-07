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

<tr> 
  <td class="row2" colspan="2"><br clear="all" /><form method="POST" action="{S_SURVEY_ACTION}">
	<!-- BEGIN switch_max_survey_height --> 
	<div style="MAX-HEIGHT: {MAX_SURVEY_HEIGHT}; WIDTH: 100%; OVERFLOW: auto">
	<!--[if gte IE 5]>
	<div style="HEIGHT: {MAX_SURVEY_HEIGHT}; WIDTH: 100%; OVERFLOW: auto">
	<![endif]-->
	<!-- END switch_max_survey_height --> 

	<table cellspacing="0" cellpadding="4" border="0" align="center">

	<!-- BEGIN switch_include_fill_in_button --> 
	  <tr>
		<td align="center">{S_HIDDEN_FIELDS}<input type="submit" value="{L_FILL_OUT}" class="mainoption" /></td>
	  </tr>
	<!-- END switch_include_fill_in_button -->

	<!-- BEGIN switch_survey_expired --> 
	  <tr>
		<td align="center"><span class="survey_gen"><b>{L_SURVEY_EXPIRED}</b></span></td>
	  </tr>
	<!-- END switch_survey_expired -->
	

	<!-- BEGIN switch_include_fill_out_for_other_user_button --> 
	  <tr>
		<td align="center">{S_HIDDEN_FIELDS}<input type="submit" name="fill_out_for_other_user" value="{L_FILL_OUT_FOR_OTHER_USER}" class="mainoption" /></td>
	  </tr>
	<!-- END switch_include_fill_out_for_other_user_button -->

	  <tr> 
		<td colspan="4" align="center"><span class="survey_gen"><b>{SURVEY_CAPTION}</b></span></td>
	  </tr>
	  <tr><td><br /></td></tr>
	  <tr> 
		<td align="center"> 
		  <table cellspacing="0" cellpadding="2" border="0">
			<tr>
			  <td align="center" valign="top" width="{USERNAME_WIDTH}"></td><td>&nbsp;&nbsp;&nbsp;</td>
			<!-- BEGIN questions -->  
			  <td align="center" valign="top" width="{questions.QUESTION_WIDTH}"><span class="survey_gen"><b>{questions.QUESTION}</b></span></td><td>&nbsp;&nbsp;&nbsp;</td>
			<!-- END questions --> 
			</tr>

			<tr><td><br /></td></tr>

			<!-- BEGIN user_rows -->
			<tr> 
			  <td align="center" valign="top" width="{USERNAME_WIDTH}"><span class="survey_gen">{user_rows.USERNAME}{L_LINES_TO_SKIP}</span></td><td>&nbsp;&nbsp;&nbsp;</td>
			<!-- BEGIN answers -->
			  <td align="center" valign="top" width="{user_rows.answers.ANSWER_WIDTH}"><span class="survey_gen">{user_rows.answers.ANSWER}{L_LINES_TO_SKIP}</span></td><td>&nbsp;&nbsp;&nbsp;</td>


			<!-- END answers -->
			</tr>
			<!-- END user_rows -->
			
			<tr>
			  <td align="center" valign="top"><span class="survey_gen"><b>{L_TOTAL}</b></span></td><td>&nbsp;&nbsp;&nbsp;</td>
			<!-- BEGIN totals -->
			  <td align="center" valign="top"><span class="survey_gen"><b>{totals.TOTAL}</b></span></td><td>&nbsp;&nbsp;&nbsp;</td>
			<!-- END totals -->
			</tr>

		  </table>
		</td>
	  </tr>
	  <tr><td><br /></td></tr>
	   <tr> 
	  	<td colspan="4" align="center"><span class="survey_gen"><b>{L_TOTAL_RESPONSES} : {TOTAL_RESPONSES}</b></span></td>
	  </tr>
	  
	  <tr> 
	  	<td colspan="4" align={ALIGNMENT}><span class="survey_gen"><b>{L_NONRESPONDERS}</b></span></td>
	  </tr>

	  <tr> 
		<td align={ALIGNMENT} valign="top" style={LINE_HEIGHT}><span class="survey_gen">{NONRESPONDER}</span></td>
	  </tr>

	</table>
	<br clear="all" />
	<!-- BEGIN switch_max_survey_height --> 
	</div>
	<!-- END switch_max_survey_height --> 
	
  </td>
</tr>