
<h1>{L_NAME_TITLE}</h1>

<p>{L_NAME_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="50%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">

	<tr>
	  <th class="thHead" colspan="2">{L_NAME_REQUIRED}</th>
	</tr>
	<tr>
		<td class="row1">{L_NAME_FIRST_REQUIRED}</td>
		<td class="row2"><input type="radio" name="name_first_required" value="1" {NAME_FIRST_REQUIRED_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="name_first_required" value="0" {NAME_FIRST_REQUIRED_NO} /> {L_NO}</td>
	</tr>

	<tr>
		<td class="row1">{L_NAME_LAST_REQUIRED}</td>
		<td class="row2"><input type="radio" name="name_last_required" value="1" {NAME_LAST_REQUIRED_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="name_last_required" value="0" {NAME_LAST_REQUIRED_NO} /> {L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_NAME_DISPLAY}</th>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{L_NAME_DISPLAY_WARNING}
		</td>
	</tr>
	<tr>
		<td class="row1">{L_NAME_FIRST_DISPLAY}</td>
		<td class="row2"><input type="radio" name="name_first_display" value="1" {NAME_FIRST_DISPLAY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="name_first_display" value="0" {NAME_FIRST_DISPLAY_NO} /> {L_NO}</td>
	</tr>

	<tr>
		<td class="row1">{L_NAME_LAST_DISPLAY}</td>
		<td class="row2"><input type="radio" name="name_last_display" value="1" {NAME_LAST_DISPLAY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="name_last_display" value="0" {NAME_LAST_DISPLAY_NO} /> {L_NO}</td>
	</tr>


	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<br clear="all" />
