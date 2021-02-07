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

<tr id="survey" style="display: none">
<td class="row1" colspan="2">
<table border="0" cellpadding="3" cellspacing="1" width=100%>
<tr>
	<th class="thHead" colspan="2">{L_DESIGN_A_SURVEY}</th>
</tr>
<tr>
	<td class="row1" colspan="2"><span class="survey_gensmall">{L_ADD_SURVEY_EXPLAIN}</span></td>
</tr>
<tr>
	<td class="row1" width=22% valign="top"><span class="survey_gen"><b>{L_SURVEY_CAPTION}</b></span></td>
	<td class="row2" width=78%><span class="survey_genmed"><textarea name="survey_caption" rows="3" cols="35" wrap="virtual" style="width:450px" class="post">{S_SURVEY_CAPTION}</textarea></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_SELECT_GROUP}</b></span></td>
	<td class="row2"><span class="topictitle"><table border="0" cellpadding="3" cellspacing="1" width=100%>


	<!-- BEGIN listrow -->
	<tr> 
	  <td class="row2"><span class="postdetails"><input type="checkbox" name="survey_group_ids[]" value="{listrow.S_MARK_ID}" {listrow.S_DESIGNATED_GROUP} /></span><span class="topictitle" valign="center">&nbsp;{listrow.U_GROUP_NAME}</span></td>
	</tr>
	<!-- END listrow -->
</table></td></tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_ORDER_TO_SHOW}</b></span></td>
	<td class="row2"><select name="survey_show_order" size="1" class="topictitle"><option value="{ALPHABETICAL}" {S_SELECT_ALPHABETICAL}>{L_ALPHABETICAL}</option><option value="{ORDER_OF_RESPONSE}" {S_SELECT_ORDER_OF_RESPONSE}>{L_BY_ORDER_OF_RESPONSE}</option><option value="{SORT_BY_FIRST_ANSWER}" {S_SELECT_SORT_BY_FIRST_ANSWER}>{L_SORT_BY_FIRST_ANSWER}</option><option value="{SORT_BY_FIRST_ANSWER_DESCENDING_ORDER}" {S_SELECT_SORT_BY_FIRST_ANSWER_DESCENDING_ORDER}>{L_SORT_BY_FIRST_ANSWER_DESCENDING_ORDER}</option></select></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_LIST_NONRESPONDERS}</b></span></td>
	<td class="row2"><select name="survey_show_nonresponders" size="1" class="topictitle"><option value="{NONRESPONDERS_NO}" {S_SELECT_NONRESPONDERS_NO}>{L_NO}</option><option value="{NONRESPONDERS_CENTER_COLUMN}" {S_SELECT_NONRESPONDERS_CENTER_COLUMN}>{L_SHOW_NONRESPONDERS_CENTER_COLUMN}</option><option value="{NONRESPONDERS_LEFT_COLUMN}" {S_SELECT_NONRESPONDERS_LEFT_COLUMN}>{L_SHOW_NONRESPONDERS_LEFT_COLUMN}</option><option value="{NONRESPONDERS_CENTER_COMMA_SEPARATED}" {S_SELECT_NONRESPONDERS_CENTER_COMMA_SEPARATED}>{L_SHOW_NONRESPONDERS_CENTER_COMMA_SEPARATED}</option><option value="{NONRESPONDERS_LEFT_COMMA_SEPARATED}" {S_SELECT_NONRESPONDERS_LEFT_COMMA_SEPARATED}>{L_SHOW_NONRESPONDERS_LEFT_COMMA_SEPARATED}</option></select></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_MAX_NUMBER_OF_QUESTIONS}</b></span></td>
	<td class="row2"><span class="survey_genmed"><input type="text" name="max_number_of_questions" size="4" maxlength="4" class="post" value="{S_MAX_NUMBER_OF_QUESTIONS}" /></span></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_LINES_TO_SKIP}</b></span></td>
	<td class="row2"><select name="survey_lines_to_skip" size="1" class="topictitle"><option value="1" {S_SELECT_SKIP_ONE}>1</option><option value="2" {S_SELECT_SKIP_TWO}>2</option><option value="3" {S_SELECT_SKIP_THREE}>3</option></select></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_ALLOW_CHANGE_ANSWERS}</b></span></td>
	<td class="row2"><select name="survey_allow_change_answers" size="1" class="topictitle"><option value="''" {S_SELECT_ALLOW_CHANGE_ANSWERS_NO}>{L_NO}</option><option value="1" {S_SELECT_ALLOW_CHANGE_ANSWERS_YES}>{L_YES}</option></select></td>
</tr>

<tr>
	<td class="row1"><span class="gen"><b>{L_SURVEY_LENGTH}</b></span></td>
	<td class="row2"><span class="genmed"><input type="text" name="survey_length" size="4" maxlength="4" class="post" value="{S_SURVEY_LENGTH}" /></span></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_SURVEY_HEIGHT}</b></span></td>
	<td class="row2"><span class="survey_genmed"><input type="text" name="survey_height" size="4" maxlength="4" class="post" value="{S_SURVEY_HEIGHT}" /></span></td>
</tr>



<tr>
	<td class="row1"><span class="survey_gen"><b>{L_WIDTH_USERNAME}</b></span></td>
	<td class="row2"><span class="survey_genmed"><input type="text" name="survey_width_username" size="3" maxlength="3" class="post" value="{S_WIDTH_USERNAME}" /></span></td>
</tr>

	<!-- BEGIN switch_survey_delete_toggle -->
	<tr>
		<td class="row1"><span class="survey_gen"><b>{L_DELETE_SURVEY}</b></span></td>
		<td class="row2"><span class="postdetails"><input type="checkbox" name="survey_delete" value="1" /></span></td>
	</tr>	
	<!-- END switch_survey_delete_toggle -->


	<!-- BEGIN questions -->
<tr>
	<td class="forumline"></td>
	<td class="forumline"></td>
</tr>

<tr>
	<td class="row1" valign="top"><span class="survey_gen"><b>{L_QUESTION}</b></span></td>
	<td class="row2"><span class="survey_genmed"><textarea name="survey_question[]" rows="3" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post">{questions.S_QUESTION}</textarea></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_QUESTION_TYPE}</b></span></td>
	<td class="row2"><select name="survey_question_type[]" size="1" class="topictitle">
		<option value="{SMALL_TEXT_BLANK}" {questions.S_SELECTED_SMALL_TEXT_BLANK}>{L_SMALL_TEXT_BLANK}</option>
		<option value="{LARGE_TEXT_BLANK}" {questions.S_SELECTED_LARGE_TEXT_BLANK}>{L_LARGE_TEXT_BLANK}</option>
		<option value="{TEXT_BOX}" {questions.S_SELECTED_TEXT_BOX}>{L_TEXT_BOX}</option>
		<option value="{CHECKBOX_OR_RADIO_BUTTONS}" {questions.S_SELECTED_CHECKBOX_OR_RADIO_BUTTONS}>{L_CHECKBOX_OR_RADIO_BUTTONS}</option>
		<option value="{MULTIPLE_CHOICE_CHECKBOXES}" {questions.S_SELECTED_MULTIPLE_CHOICE_CHECKBOXES}>{L_MULTIPLE_CHOICE_CHECKBOXES}</option>
		<option value="{DROP_DOWN_MENU}" {questions.S_SELECTED_DROP_DOWN_MENU}>{L_DROP_DOWN_MENU}</option>
		</select>
		</td>
</tr>

<tr>
	<td class="row1"></td>
	<td class="row2"><span class="topictitle">{L_IF_SELECTIONS}<input type="text" name="survey_question_selection[]" size="50" maxlength="255" class="post" value="{questions.S_SELECTIONS}" /></span></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_SHOULD_RESPONSES_BE_TOTALLED}</b></span></td>
	<td class="row2"><select name="survey_question_sum[]" size="1" class="topictitle">
		<option value="{NO_TOTAL}" {questions.S_NO_TOTAL}>{L_NO}</option>
		<option value="{TOTAL_BY_RESPONSES}" {questions.S_TOTAL_BY_RESPONSES}>{L_YES_BY_NUMBER_OF_RESPONSES}</option>
		<option value="{TOTAL_BY_NUMBERS_IN_RESPONSES}" {questions.S_TOTAL_BY_NUMBERS_IN_RESPONSES}>{L_YES_BY_NUMBERS_IN_RESPONSES}</option>
		<option value="{TOTAL_BY_MATCHING_TEXT}" {questions.S_TOTAL_BY_MATCHING_TEXT}>{L_YES_BY_MATCHING_TEXT}</option>
		<option value="{TOTAL_BY_AVERAGE_OF_NUMBERS_IN_RESPONSES}" {questions.S_TOTAL_BY_AVERAGE_OF_NUMBERS_IN_RESPONSES}>{L_YES_BY_AVERAGE_OF_NUMBERS_IN_RESPONSES}</option>
		</select>
		</td>
</tr>

<tr>
	<td class="row1"</td>
	<td class="row2"><span class="topictitle">{L_IF_AVERAGE}<input type="text" name="survey_question_average_round[]" size="3" maxlength="2" class="post" value="{questions.S_AVERAGE_ROUND}" /></span></td>
</tr>

<tr>
	<td class="row1"</td>
	<td class="row2"><span class="topictitle">{L_IF_BY_MATCHING_TEXT}<input type="text" name="survey_question_selected_text[]" size="50" maxlength="255" class="post" value="{questions.S_SPECIFIED_TEXT}" /></span></td>
</tr>

<tr>
	<td class="row1"</td>
	<td class="row2"><span class="topictitle">{L_CAP_RESPONSE}<input type="text" name="survey_question_response_cap[]" size="3" maxlength="255" class="post" value="{questions.S_CAP_RESPONSE}" /></span></td>
</tr>

<tr>
	<td class="row1"><span class="survey_gen"><b>{L_WIDTH_QUESTION}</b></span></td>
	<td class="row2"><span class="survey_genmed"><input type="text" name="survey_width_question[]" size="3" maxlength="3" class="post" value="{questions.S_WIDTH_QUESTION}" /></span></td>
</tr>
	<!-- END questions -->

</table>
</td>
</tr>