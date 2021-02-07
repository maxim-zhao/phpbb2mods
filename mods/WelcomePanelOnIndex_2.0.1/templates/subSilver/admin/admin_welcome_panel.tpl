
<h1>{L_WELCOME_PANEL_TITLE}</h1>

<p>{L_WELCOME_PANEL_EXPLAIN}</p>

<form action="{S_WELCOME_PANEL_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead">{L_SUGGESTED_TOPICS}</th>
	</tr>
	<tr>
		<td class="row1">{L_SUGGESTED_TOPICS_EXPLAIN}<br />
			<input type="radio" name="suggestion_type" value="{DO_NOT_SUGGEST}" {DO_NOT_SUGGEST_CHECKED} />{L_DO_NOT_SUGGEST}<br />
			<input type="radio" name="suggestion_type" value="{SUGGEST_FAQ}" {SUGGEST_FAQ_CHECKED} />{L_SUGGEST_FAQ}<br />
			<input type="radio" name="suggestion_type" value="{SUGGEST_TOPIC_FROM}" {SUGGEST_TOPIC_FROM_CHECKED} />{L_SUGGEST_TOPIC_FROM}&nbsp;
			{S_FORUM_SELECT}&nbsp; &nbsp; &nbsp; <input type="checkbox" name="suggest_announcements" {SUGGEST_ANNOUNCEMENTS_CHECKED} align="absmiddle">{L_SUGGEST_ANNOUNCEMENTS}<br />
			<input type="radio" name="suggestion_type" value="{SUGGEST_SPECIFIC}" {SUGGEST_SPECIFIC_CHECKED} />{L_SUGGEST_SPECIFIC}&nbsp;
			<input class="post" type="text" size="5" maxlength="100" name="suggested_topic_id" value="{SUGGESTED_TOPIC_ID}" /><br /><br />
			{L_WARNING}
		</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" /></td>
	</tr>
</table></form>

<br clear="all" />
