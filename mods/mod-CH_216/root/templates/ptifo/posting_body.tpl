
<!-- BEGINGLOBAL switch_standalone -->
<!-- BEGIN left_part -->
<script language="JavaScript" type="text/javascript" src="./includes/js_dom_menus.js"></script>
<!-- END left_part -->

<!-- INCLUDE posting_bbcode.tpl -->
<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)" {S_FORM_ENCTYPE}>

{NAVIGATION_BOX}

<!-- BEGIN switch_not_privmsg -->
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr> 
	<td align="left" valign="bottom"><span class="maintitle">
		<a class="maintitle" href="{U_TITLE}">{TITLE}</a>
	</span></td>
</tr>
</table>
<!-- END switch_not_privmsg -->

{POST_PREVIEW_BOX}
{ERROR_BOX}

<!-- BEGIN left_part -->
<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td id="left_part" width="200" valign="top" style="display: none">
	<table cellpadding="3" cellspacing="1" width="100%" class="forumline" border="0">
	<tr>
		<th class="thHead">{L_LEFT_PART}</th>
	</tr>
	<tr>
		<td height="25" class="row1">
			<span class="gensmall"><b>{L_POST_A}</b></span><hr />
			<table cellspacing="0" cellpadding="2" border="0" width="100%">
			<tr>
				<td width="10" align="right"><div id="message_form_flag" class="gensmall" style="font-weight: bold;">&raquo;</div></td>
				<td nowrap="nowrap" onmouseover="this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.style.cursor='pointer'; this.style.fontWeight='normal';" onclick="dom_menu.set('message_form'); return false;"><div id="message_form_opt" style="font-weight: bold;"><a href="javascript:dom_menu.set('message_form');" class="gensmall">{L_MESSAGE_BODY}</a></div></td>
			</tr>
			<!-- BEGINGLOBAL topic_type_form -->
			<tr>
				<td width="10" align="right"><div id="topic_type_form_flag" class="gensmall">&raquo;</div></td>
				<td nowrap="nowrap" onmouseover="this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.style.cursor='pointer'; this.style.fontWeight='normal';" onclick="dom_menu.set('topic_type_form'); return false;"><div id="topic_type_form_opt"><a href="javascript:dom_menu.set('topic_type_form');" class="gensmall">{L_TOPIC_TYPE_FORM}</a></div></td>
			</tr>
			<!-- ENDGLOBAL topic_type_form -->
			<!-- BEGINGLOBAL poll_form -->
			<tr>
				<td width="10" align="right"><div id="poll_form_flag" class="gensmall">&raquo;</div></td>
				<td nowrap="nowrap" onmouseover="this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.style.cursor='pointer'; this.style.fontWeight='normal';" onclick="dom_menu.set('poll_form'); return false;"><div id="poll_form_opt"><a href="javascript:dom_menu.set('poll_form');" class="gensmall">{L_POLL_FORM}</a></div></td>
			</tr>
			<!-- ENDGLOBAL poll_form -->
			<!-- BEGINGLOBAL calendar_form -->
			<tr>
				<td width="10" align="right"><div id="calendar_form_flag" class="gensmall">&raquo;</div></td>
				<td nowrap="nowrap" onmouseover="this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.style.cursor='pointer'; this.style.fontWeight='normal';" onclick="dom_menu.set('calendar_form'); return false;"><div id="calendar_form_opt"><a href="javascript:dom_menu.set('calendar_form');" class="gensmall">{L_CALENDAR_FORM}</a></div></td>
			</tr>
			<!-- ENDGLOBAL calendar_form -->
			<!-- BEGINGLOBAL attachment_form -->
			<tr>
				<td width="10" align="right"><div id="attach_form_flag" class="gensmall">&raquo;</div></td>
				<td nowrap="nowrap" onmouseover="this.style.cursor='pointer'; this.style.fontWeight='bold';" onmouseout="this.style.cursor='pointer'; this.style.fontWeight='normal';" onclick="dom_menu.set('attach_form'); return false;"><div id="attach_form_opt"><a href="javascript:dom_menu.set('attach_form');" class="gensmall">{L_ADD_ATTACH_TITLE}</a></div></td>
			</tr>
			<!-- ENDGLOBAL attachment_form -->
			</table><input type="hidden" name="pid" id="pid" value="{PID}" />
		</td>
	</tr>
	<tr>
		<td class="spaceRow"><img src="{I_SPACER}" border="0" alt="" /></td>
	</tr>
	</table>
</td><td width="2"><img src="{I_SPACER}" border="0" width="2" alt="" /></td><td>
<!-- END left_part -->

<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<colgroup>
		<col width="250">
		<col>
	</colgroup>
	<thead id="message_form_title">
	<tr> 
		<th class="thHead" colspan="2" height="25"><b>{L_POST_A}</b></th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<td class="catBottom" colspan="2" align="center" height="28">{S_HIDDEN_FORM_FIELDS}
			<input type="image" src="{I_PREVIEW}" accesskey="v" tabindex="5" name="preview" value="{L_PREVIEW}" />&nbsp;
			<input type="image" src="{I_SUBMIT}" accesskey="s" tabindex="6" name="post" value="{L_SUBMIT}" />&nbsp;
			<input type="image" src="{I_CANCEL}" accesskey="x" tabindex="7" name="cancel" value="{L_CANCEL}" />
		</td>
	</tr>
	</tfoot>
<!-- ENDGLOBAL switch_standalone -->
<!-- BEGIN switch_standalone --><tbody id="message_form"><!-- END switch_standalone -->
	<!-- BEGIN switch_username_select -->
	<tr> 
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed"><input type="text" class="post" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}" /></span></td>
	</tr>
	<!-- END switch_username_select -->
	<!-- BEGIN switch_confirm -->
	<!-- INCLUDE visual_confirm_box.tpl -->
	<!-- END switch_confirm -->
	<!-- BEGIN switch_privmsg -->
	<tr> 
		<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
		<td class="row2"><span class="genmed"><input type="text" class="post" name="username" maxlength="25" size="25" tabindex="1" value="{USERNAME}" />&nbsp;<input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onclick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></span></td>
	</tr>
	<!-- END switch_privmsg -->
	<!-- BEGIN switch_subject -->
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>{L_SUBJECT}</b></span></td>
	  <td class="row2" width="78%"> <span class="gen"> 
		<input type="text" name="subject" size="45" maxlength="{SUBJECT_LENGTH}" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" />
		</span> </td>
	</tr>
	<!-- END switch_subject -->
	<!-- BEGIN switch_sub_title -->
	<tr> 
		<td class="row1"><span class="gen"><b>{L_SUB_TITLE}</b></span></td>
		<td class="row2"><span class="gen">
			<input type="text" name="sub_title" size="45" maxlength="{SUB_TITLE_LENGTH}" style="width:450px" tabindex="2" class="post" value="{SUB_TITLE}" />
		</span></td>
	</tr>
	<!-- END switch_sub_title -->
	<!-- BEGIN switch_explain -->
	<tr>
		<td class="row3" colspan="2"><span class="gensmall">{L_EXPLAIN}</span></td>
	</tr>
	<!-- END switch_explain -->
	{ICON_BOX}
	{SUB_TYPE_FORM}
	<tr> 
	  <td class="row1" valign="top"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="1">
		  <tr> 
			<td><span class="gen"><b>{L_MESSAGE_BODY}</b></span> </td>
		  </tr>
		  <tr> 
			<td valign="middle" align="center"><br />
			  <table width="100" border="0" cellspacing="0" cellpadding="5">
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}"><span class="gensmall"><b>{L_EMOTICONS}</b></span></td>
				</tr>
				<!-- BEGIN smilies_row -->
				<tr align="center" valign="middle"> 
				  <!-- BEGIN smilies_col -->
				  <td><a href="javascript:emoticon('{smilies_row.smilies_col.SMILEY_CODE}')"><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
				  <!-- END smilies_col -->
				</tr>
				<!-- END smilies_row -->
				<!-- BEGIN switch_smilies_extra -->
				<tr align="center"> 
				  <td colspan="{S_SMILIES_COLSPAN}"><span class="topictitle"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');return false;" target="_phpbbsmilies" class="topictitle">{L_MORE_SMILIES}</a></span></td>
				</tr>
				<!-- END switch_smilies_extra -->
			  </table>
			</td>
		  </tr>
		</table>
	  </td>
	  <td class="row2" valign="top">
		<table width="450" border="0" cellspacing="0" cellpadding="2">
		  <tr align="center" valign="middle"> 
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onclick="bbstyle(0)" onmouseover="helpline('b')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onclick="bbstyle(2)" onmouseover="helpline('i')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onclick="bbstyle(4)" onmouseover="helpline('u')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onclick="bbstyle(6)" onmouseover="helpline('q')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onclick="bbstyle(8)" onmouseover="helpline('c')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onclick="bbstyle(10)" onmouseover="helpline('l')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onclick="bbstyle(12)" onmouseover="helpline('o')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onclick="bbstyle(14)" onmouseover="helpline('p')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onclick="bbstyle(16)" onmouseover="helpline('w')" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="9"> 
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr> 
				  <td><span class="genmed"> &nbsp;{L_FONT_COLOR}: 
					<select name="addbbcode18" onchange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onmouseover="helpline('s')">
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="{T_FONTCOLOR1}" class="genmed">{L_COLOR_DEFAULT}</option>
					  <option style="color:darkred; background-color: {T_TD_COLOR1}" value="darkred" class="genmed">{L_COLOR_DARK_RED}</option>
					  <option style="color:red; background-color: {T_TD_COLOR1}" value="red" class="genmed">{L_COLOR_RED}</option>
					  <option style="color:orange; background-color: {T_TD_COLOR1}" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
					  <option style="color:brown; background-color: {T_TD_COLOR1}" value="brown" class="genmed">{L_COLOR_BROWN}</option>
					  <option style="color:yellow; background-color: {T_TD_COLOR1}" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
					  <option style="color:green; background-color: {T_TD_COLOR1}" value="green" class="genmed">{L_COLOR_GREEN}</option>
					  <option style="color:olive; background-color: {T_TD_COLOR1}" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
					  <option style="color:cyan; background-color: {T_TD_COLOR1}" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
					  <option style="color:blue; background-color: {T_TD_COLOR1}" value="blue" class="genmed">{L_COLOR_BLUE}</option>
					  <option style="color:darkblue; background-color: {T_TD_COLOR1}" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
					  <option style="color:indigo; background-color: {T_TD_COLOR1}" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
					  <option style="color:violet; background-color: {T_TD_COLOR1}" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
					  <option style="color:white; background-color: {T_TD_COLOR1}" value="white" class="genmed">{L_COLOR_WHITE}</option>
					  <option style="color:black; background-color: {T_TD_COLOR1}" value="black" class="genmed">{L_COLOR_BLACK}</option>
					</select> &nbsp;{L_FONT_SIZE}:<select name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]'); this.selectedindex=0;" onmouseover="helpline('f')">
					  <option value="0" class="genmed">{L_FONT_SIZE}</option>
					  <option value="7">{L_FONT_TINY}</option>
					  <option value="9">{L_FONT_SMALL}</option>
					  <option value="12" selected>{L_FONT_NORMAL}</option>
					  <option value="18">{L_FONT_LARGE}</option>
					  <option  value="24">{L_FONT_HUGE}</option>
					</select>
					</span></td>
				  <td nowrap="nowrap" align="right"><span class="gensmall"><a href="javascript:bbstyle(-1)" class="genmed" onmouseover="helpline('a')">{L_BBCODE_CLOSE_TAGS}</a></span></td>
				</tr>
			  </table>
			</td>
		  </tr>
		  <tr> 
			<td colspan="9"><span class="gensmall"> 
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="{L_STYLES_TIP}" />
			  </span></td>
		  </tr>
		  <tr> 
			<td colspan="9">
			  <textarea name="message" rows="15" cols="35" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea>
			</td>
		  </tr>
		</table>
		</td>
	</tr>
	<tr> 
	  <td class="row1" valign="top"><span class="gen"><b>{L_OPTIONS}</b></span><br /><span class="gensmall">{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2">
		<table cellspacing="0" cellpadding="1" border="0"><!-- BEGIN no_choices --><tr><td>&nbsp;</td></tr><!-- END no_choices -->
		  <!-- BEGIN switch_html_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="disable_html" {S_HTML_CHECKED} />
			</td>
			<td><span class="gen">{L_DISABLE_HTML}</span></td>
		  </tr>
		  <!-- END switch_html_checkbox -->
		  <!-- BEGIN switch_bbcode_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="disable_bbcode" {S_BBCODE_CHECKED} />
			</td>
			<td><span class="gen">{L_DISABLE_BBCODE}</span></td>
		  </tr>
		  <!-- END switch_bbcode_checkbox -->
		  <!-- BEGIN switch_smilies_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="disable_smilies" {S_SMILIES_CHECKED} />
			</td>
			<td><span class="gen">{L_DISABLE_SMILIES}</span></td>
		  </tr>
		  <!-- END switch_smilies_checkbox -->
		  <!-- BEGIN switch_signature_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="attach_sig" {S_SIGNATURE_CHECKED} />
			</td>
			<td><span class="gen">{L_ATTACH_SIGNATURE}</span></td>
		  </tr>
		  <!-- END switch_signature_checkbox -->
		  <!-- BEGIN switch_notify_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="notify" {S_NOTIFY_CHECKED} />
			</td>
			<td><span class="gen">{L_NOTIFY_ON_REPLY}</span></td>
		  </tr>
		  <!-- END switch_notify_checkbox -->
		  <!-- BEGIN switch_delete_checkbox -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="delete" />
			</td>
			<td><span class="gen">{L_DELETE_POST}</span></td>
		  </tr>
		  <!-- END switch_delete_checkbox -->
		</table>
	  </td>
	</tr>
<!-- BEGIN switch_standalone --></tbody><!-- END switch_standalone -->
<!-- BEGINGLOBAL switch_standalone -->
<!-- BEGIN topic_type_form --><tbody id="topic_type_form">{TOPIC_TYPE_FORM}</tbody><!-- END topic_type_form -->
<!-- BEGIN poll_form --><tbody id="poll_form">{POLLBOX}</tbody><!-- END poll_form -->
<!-- BEGIN calendar_form --><tbody id="calendar_form">{CALENDAR_FORM}</tbody><!-- END calendar_form -->
<!-- BEGIN attachment_form --><tbody id="attach_form">{ATTACHBOX}</tbody><!-- END attachment_form -->
</table>
<!-- BEGIN left_part -->
</td></tr></table>
<!-- END left_part -->

{NAVIGATION_BOX}
</form>

<br class="nav" />

{TOPIC_REVIEW_BOX}

<!-- BEGIN left_part -->
<script language="JavaScript" type="text/javascript">
<!--//
	// instantiate (except for IE)
	var used_browser = navigator.userAgent.toLowerCase();
	if ( (used_browser.indexOf("msie") == -1) || (used_browser.indexOf("opera") != -1) )
	{
		dom_menu = new _dom_menu([
			'message_form'
			<!-- BEGINGLOBAL topic_type_form -->, 'topic_type_form'<!-- ENDGLOBAL topic_type_form -->
			<!-- BEGINGLOBAL poll_form -->, 'poll_form'<!-- ENDGLOBAL poll_form -->
			<!-- BEGINGLOBAL calendar_form -->, 'calendar_form'<!-- ENDGLOBAL calendar_form -->
			<!-- BEGINGLOBAL attachment_form -->, 'attach_form'<!-- ENDGLOBAL attachment_form -->
		]);
	}
//-->
</script>
<!-- END left_part -->
<!-- ENDGLOBAL switch_standalone -->