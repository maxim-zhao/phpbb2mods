<!-- BEGIN PM_QUICKREPLY -->
</form>
<script language="JavaScript" type="text/javascript">
<!--
// bbCode control by
// phpbrasil design
// www.phpbrasil.com

var form_name = 'post';
var text_name = 'message';

// Helpline messages
b_help = "{L_BBCODE_B_HELP}";
i_help = "{L_BBCODE_I_HELP}";
u_help = "{L_BBCODE_U_HELP}";
q_help = "{L_BBCODE_Q_HELP}";
c_help = "{L_BBCODE_C_HELP}";
l_help = "{L_BBCODE_L_HELP}";
o_help = "{L_BBCODE_O_HELP}";
p_help = "{L_BBCODE_P_HELP}";
w_help = "{L_BBCODE_W_HELP}";
a_help = "{L_BBCODE_A_HELP}";
s_help = "{L_BBCODE_S_HELP}";
f_help = "{L_BBCODE_F_HELP}";

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
imageTag = false;

function openAllSmiles(){
smiles = window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');
smiles.focus();
return false;
}

function checkForm() {

	formErrors = false;

	if (document.post.message.value.length < 2) {
		formErrors = "{L_EMPTY_MESSAGE}";
	}

	if (formErrors) {
		alert(formErrors);
		return false;
	} else {
		bbstyle(-1);
		//formObj.preview.disabled = true;
		//formObj.submit.disabled = true;
		return true;
	}
}
</script>
<script language="javascript" type="text/javascript" src="templates/pm_quick_reply.js"></script>

<table border='0' cellpadding='4' cellspacing='1' width='100%' class='forumline'>
	<tr><form action="{PM_QUICKREPLY.POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)">
		<th colspan="2" height="25" style="padding: 0px"><b>{L_QUICK_REPLY}</b></th>
	</tr>
	<tr>
		<td align="left" class="row1"><span class="gen"><b>{L_FROM}</b></span></td>
		<td class="row2"><span class="genmed">{MESSAGE_FROM}</span></td>
	</tr>
	<tr>
		<td align="left" class="row1"><span class="gen"><b>{L_SUBJECT}</b></span></td>
		<td class="row2"><input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{PM_QUICKREPLY.SUBJECT}" /><br /></td>
	</tr>
	<tr>
		<td align="left" class="row1" valign="top" nowrap="nowrap"><span class="gen"><b>{L_OPTIONS}</b></span><br /><br />
		<span class="gensmall">
<!-- BEGIN HTMLPMRP -->
		<input type="checkbox" name="disable_html"{PM_QUICKREPLY.S_HTML_CHECKED} />&nbsp;{L_DISABLE_HTML}<br />
<!-- END HTMLPMRP -->
<!-- BEGIN BBCODEPMRP -->
		<input type="checkbox" name="disable_bbcode"{PM_QUICKREPLY.S_BBCODE_CHECKED} />&nbsp;{L_DISABLE_BBCODE}<br />
<!-- END BBCODEPMRP -->
<!-- BEGIN SMILIESPMRP -->
		<input type="checkbox" name="disable_smilies"{PM_QUICKREPLY.S_SMILIES_CHECKED} />&nbsp;{L_DISABLE_SMILIES}<br />
<!-- END SMILIESPMRP -->
		<input type="checkbox" name="attach_sig"{PM_QUICKREPLY.S_SIG_CHECKED} />&nbsp;{L_ATTACH_SIGNATURE}<br /></span></td>
		<td class="row2" colspan="2" valign="top" align="left"  style="padding-top: 0px; padding-bottom: 0px">
<!-- BEGIN BBCODEBUTTON -->
<table width="450" border="0" cellspacing="0" cellpadding="2">
	<tr align="center" valign="middle">
		<td><span class="genmed"><input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onclick="bbstyle(0)" onmouseover="helpline('b')" /></span></td>
		<td><span class="genmed"><input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onclick="bbstyle(2)" onmouseover="helpline('i')" /></span></td>
		<td><span class="genmed"><input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onclick="bbstyle(4)" onmouseover="helpline('u')" /></span></td>
		<td><span class="genmed"><input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onclick="bbstyle(6)" onmouseover="helpline('q')" /></span></td>
		<td><span class="genmed"><input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onclick="bbstyle(8)" onmouseover="helpline('c')" /></span></td>
		<td><span class="genmed"><input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onclick="bbstyle(10)" onmouseover="helpline('l')" /></span></td>
		<td><span class="genmed"><input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onclick="bbstyle(12)" onmouseover="helpline('o')" /></span></td>
		<td><span class="genmed"><input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onmouseover="helpline('p')" /></span></td>
		<td><span class="genmed"><input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onclick="bbstyle(16)" onmouseover="helpline('w')" /></span></td>
   	</tr>
	<tr>
		<td colspan="9">
			  <table width="97%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><span class="genmed">  {L_FONT_COLOR}:
						<select name="addbbcode18" onchange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
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
						</select>  
						{L_FONT_SIZE}:<select name="addbbcode20" onchange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
							<option value="7" class="genmed">{L_FONT_TINY}</option>
							<option value="9" class="genmed">{L_FONT_SMALL}</option>
							<option value="12" selected class="genmed">{L_FONT_NORMAL}</option>
							<option value="18" class="genmed">{L_FONT_LARGE}</option>
							<option  value="24" class="genmed">{L_FONT_HUGE}</option>
						</select>
						</span>
						</td>
						<td colspan="2" align="center"><span class="gensmall"><a href="javascript:bbstyle(-1)" class="genmed" onmouseover="helpline('a')">{L_BBCODE_CLOSE_TAGS}</a></span></td>
						</tr>
						<tr> 
						<td colspan="9><span class="gensmall"> 
							<input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="{L_STYLES_TIP}" />
						</span></td>
				</tr>
			  </table>
		</td>
	</tr>
</table>
<!-- END BBCODEBUTTON -->
		<textarea name="message" style="width:450px; height: 140px;" wrap="virtual" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);"></textarea><br />
<!-- BEGIN SMILIES -->
		<img src="{PM_QUICKREPLY.SMILIES.URL}" border="0" onmouseover="this.style.cursor='hand';" onclick="emoticon('{PM_QUICKREPLY.SMILIES.CODE}');" alt="{PM_QUICKREPLY.SMILIES.DESC}" title="{PM_QUICKREPLY.SMILIES.DESC}" />
<!-- END SMILIES -->
<!-- BEGIN MORESMILIES -->
		<input type="button" class="button" name="SmilesButt" value="{L_ALL_SMILIES}" onclick="openAllSmiles();" />
<!-- END MORESMILIES -->
		</td>
	</tr>
	<tr>
	<td class="catbottom" colspan="2" height="28" align="center" style="padding: 0px">
	{PM_QUICKREPLY.S_HIDDEN_FIELDS}
	<input type='button' name='quoteselected' class='liteoption' value='{L_QUOTE_SELECTED}' onmousedown='quoteSelection()' /> 
	<input type="submit" name="preview" class="liteoption" value="{L_PREVIEW}" />&nbsp;<input type="submit" name="post" class="mainoption" value="{L_SUBMIT}" />
		</td>
	</tr>
</table>
</form>
<!-- END PM_QUICKREPLY -->
