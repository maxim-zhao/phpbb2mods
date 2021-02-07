
<h1>{L_CONFIGURATION_TITLE}</h1>

<p>{L_CONFIGURATION_EXPLAIN}</p>

<form action="{S_CONFIG_ACTION}" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">{L_DESCRIPTION_SETTINGS}</th>
	</tr>
	<tr>
		<td class="row1">{L_ALLOW_DESC}</td>
		<td class="row2"><input type="radio" name="allow_descriptions" value="1" {DESCRIPTION_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_descriptions" value="0" {DESCRIPTION_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_DESC_LENGTH}</td>
		<td class="row2"><input type="text" size="5" maxlength="3" name="desc_length" value="{DESC_LENGTH}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_DESC2LINK}</td>
		<td class="row2"><input type="radio" name="desc_tolink" value="1" {DESC2LINK_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_tolink" value="0" {DESC2LINK_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_DESCLINKFORCE}</td>
		<td class="row2"><input type="radio" name="desc_linkforce" value="1" {DESCLINKFORCE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_linkforce" value="0" {DESCLINKFORCE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_DESCLINKEMPY}</td>
		<td class="row2"><input type="radio" name="desc_linkempty" value="1" {DESCLINKEMPTY_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_linkempty" value="0" {DESCLINKEMPTY_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_DESCPREV}</td>
		<td class="row2"><input type="radio" name="desc_prev" value="1" {DESCPREV_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_prev" value="0" {DESCPREV_NO} /> {L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_PERMISSIONS}</th>
	</tr>
	<tr>
		<td class="row1">{L_MODS_DESC}</td>
		<td class="row2"><input type="radio" name="only_mods_desc" value="1" {DESCMODS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="only_mods_desc" value="0" {DESCMODS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GUESTDESC}</td>
		<td class="row2"><input type="radio" name="guests_desc" value="1" {GUESTDESC_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="guests_desc" value="0" {GUESTDESC_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_GUESTMODDESC}</td>
		<td class="row2"><input type="radio" name="guests_moddesc" value="1" {GUESTMODDESC_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="guests_moddesc" value="0" {GUESTMODDESC_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_DISSEEDESC}</td>
		<td class="row2"><input type="radio" name="disallowed_seedesc" value="1" {DISSEEDESC_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="disallowed_seedesc" value="0" {DISSEEDESC_NO} /> {L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_TOOLTIPS}</th>
	</tr>
	<tr>
		<td class="row1">{L_TOOLTIPS_SHOW}</td>
		<td class="row2"><input type="radio" name="show_tooltips" value="1" {SHOWTOOLTIPS_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="show_tooltips" value="0" {SHOWTOOLTIPS_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TOOLTIPS_STATIC}</td>
		<td class="row2"><input type="radio" name="tooltips_static" value="1" {TOOLTIPS_STATIC_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="tooltips_static" value="0" {TOOLTIPS_STATIC_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TOOLTIPS_PARSE}</td>
		<td class="row2"><input type="radio" name="tooltips_parse" value="1" {TOOLTIPS_PARSE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="tooltips_parse" value="0" {TOOLTIPS_PARSE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_POSTPARSINGT}</td>
		<td class="row2"><input type="radio" name="desc_postparsing_tool" value="1" {POSTPARSINGT_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_postparsing_tool" value="0" {POSTPARSINGT_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_TOOLIMG_SIZE}</td>
		<td class="row2"><input type="text" size="5" maxlength="5" name="toolimg_width" value="{TOOLIMG_WIDTH}" /> X <input type="text" size="5" maxlength="5" name="toolimg_height" value="{TOOLIMG_HEIGHT}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_TOOLPOSTSIZE}</td>
		<td class="row2"><input type="text" size="5" maxlength="5" name="tooltips_post_maxsize" value="{TOOLPOSTSIZE}" /></td>
	</tr>
	<tr>
		<td class="row1" colspan="2" align="center"><span class="gen">{L_TOOLMODIFY}</span></td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_PARSE}</th>
	</tr>
	<tr>
		<td class="row1">{L_PARSE_HTML}</td>
		<td class="row2"><input type="radio" name="desc_html" value="1" {PARSE_HTML_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_html" value="0" {PARSE_HTML_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_PARSE_BBCODE}</td>
		<td class="row2"><input type="radio" name="desc_bbcode" value="1" {PARSE_BBCODE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_bbcode" value="0" {PARSE_BBCODE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_PARSE_SMILE}</td>
		<td class="row2"><input type="radio" name="desc_smile" value="1" {PARSE_SMILE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_smile" value="0" {PARSE_SMILE_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_POSTPARSING}</td>
		<td class="row2"><input type="radio" name="desc_postparsing" value="1" {POSTPARSING_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_postparsing" value="0" {POSTPARSING_NO} /> {L_NO}</td>
	</tr>
	<tr>
	  <th class="thHead" colspan="2">{L_BBCODE}</th>
	</tr>
	<tr>
		<td class="row1">{L_BBCODE_HATELIST}</td>
		<td class="row2"><input type="text" size="40" maxlength="255" name="desc_bbcode_hatelist" value="{BBCODE_HATELIST}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_BBCODE_REMOVE}</td>
		<td class="row2"><input type="radio" name="desc_bbcode_remove" value="1" {BBCODE_REMOVE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="desc_bbcode_remove" value="0" {BBCODE_REMOVE_NO} /> {L_NO}</td>
	</tr>

	<tr>
		<td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" />
		</td>
	</tr>
</table></form>

<br clear="all" />

