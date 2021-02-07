
<form action="{S_SEARCH_ACTION}" method="POST">

{NAVIGATION_BOX}

<table class="forumline" width="100%" cellpadding="4" cellspacing="1" border="0">
<colgroup>
	<col width="20%">
	<col width="30%">
	<col width="20%">
	<col width="30%">
</colgroup>
	<tr> 
		<th class="thHead" colspan="4" height="25">{L_SEARCH_QUERY}</th>
	</tr>
	<tr> 
		<td class="row1" colspan="2" width="50%"><span class="gen">{L_SEARCH_KEYWORDS}:</span><br /><span class="gensmall">{L_SEARCH_KEYWORDS_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="top"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_keywords" size="30" /><br /><input type="radio" name="search_terms" value="any" checked="checked" /> {L_SEARCH_ANY_TERMS}<br /><input type="radio" name="search_terms" value="all" /> {L_SEARCH_ALL_TERMS}</span></td>
	</tr>
	<tr> 
		<td class="row1" colspan="2"><span class="gen">{L_SEARCH_AUTHOR}:</span><br /><span class="gensmall">{L_SEARCH_AUTHOR_EXPLAIN}</span></td>
		<td class="row2" colspan="2" valign="middle"><span class="genmed"><input type="text" style="width: 300px" class="post" name="search_author" size="30" /></span></td>
	</tr>
	<tr>
		<td class="row1" colspan="2"><span class="gen">{L_SEARCH_FORUM}:&nbsp;</span></td>
		<td class="row2" colspan="2"><span class="genmed"><select class="post" name="search_forum">{S_FORUM_OPTIONS}</select></span><span class="gensmall"><br /><input name="no_subs" type="checkbox" value="1" {S_NO_SUBS} />{L_NO_SUBS}</span></td>
	</tr>
	<tr> 
		<th class="thSides" colspan="4" height="25">{L_SEARCH_OPTIONS}</th>
	</tr>
	<tr>
		<td class="row1" align="right" nowrap="nowrap"><span class="gen">{L_SEARCH_PREVIOUS}:&nbsp;</span></td>
		<td class="row2" valign="middle"><span class="genmed"><select class="post" name="search_time">{S_TIME_OPTIONS}</select><br /><input type="radio" name="search_fields" value="all" checked="checked" /> {L_SEARCH_MESSAGE_TITLE}<br /><input type="radio" name="search_fields" value="msgonly" /> {L_SEARCH_MESSAGE_ONLY}<br /><input type="radio" name="search_fields" value="titleonly" /> {L_SEARCH_TITLE_ONLY}</span></td>
		<td class="row1" align="right"><span class="gen">{L_SORT_BY}:&nbsp;</span></td>
		<td class="row2" valign="middle" nowrap="nowrap"><span class="genmed"><select class="post" name="sort_by">{S_SORT_OPTIONS}</select><br /><input type="radio" name="sort_dir" value="ASC" /> {L_SORT_ASCENDING}<br /><input type="radio" name="sort_dir" value="DESC" checked="checked" /> {L_SORT_DESCENDING}</span>&nbsp;</td>
	</tr>
	<tr> 
		<td class="row1" align="right" nowrap="nowrap"><span class="gen">{L_DISPLAY_RESULTS}:&nbsp;</span></td>
		<td class="row2" nowrap="nowrap"><input type="radio" name="show_results" value="posts" /><span class="genmed">{L_POSTS}<input type="radio" name="show_results" value="topics" checked="checked" />{L_TOPICS}</span></td>
		<td class="row1" align="right"><span class="gen">{L_RETURN_FIRST}</span></td>
		<td class="row2"><span class="genmed"><select class="post" name="return_chars">{S_CHARACTER_OPTIONS}</select> {L_CHARACTERS}</span></td>
	</tr>
	<tr> 
		<td class="catBottom" colspan="4" align="center" height="28">{S_HIDDEN_FIELDS}
			<input type="image" src="{I_SEARCH_BUTTON}" title="{L_SEARCH}" align="top" />
		</td>
	</tr>
</table></form>

<br clear="all" />