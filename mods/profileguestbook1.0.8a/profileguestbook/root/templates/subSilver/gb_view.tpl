<!-- BEGIN quick -->
<script language="javascript" src="bbcode_gb.js"></script>
<!-- END quick -->

<script language="JavaScript" type="text/javascript">
<!--
<!-- BEGIN quick -->
// bbCode control by
// subBlue design
// www.subBlue.com

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


<!-- END quick -->
function view(mod,en,dis){
	document.getElementById('gb').style.display = mod;
	document.getElementById(en).style.display = 'block';
	document.getElementById(dis).style.display = 'none';
}
function numberbox(id)
{
	var total = "http{SECURE}://{URL}{PAD}profile.{PHPEX}?mode=viewprofile&{U}={UID}#" + id;
	prompt("{L_NUMBER_URL}",total);
	return;
}
//-->
</script>
<br />
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr><td class="row1">
<div id="en" style="display:none;" class="gen"><a href="javascript:view('block','dis','en');">{L_EN}</a></div>
<div id="dis" class="gen"><a href="javascript:view('none','en','dis');">{L_DIS}</a></div>
</td></tr>
</table><br />
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center" id="gb">
<tr>
<th colspan="2">{L_GUESTBOOK}</th>
</tr>
<!-- BEGIN error -->
<tr>
<th colspan="2">{error.L_GUESTBOOK_ERROR}</th>
</tr>
<!-- END error -->
  <tr>
	<td align="left" valign="bottom" nowrap="nowrap" class="row1"><span class="nav">&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
	<td align="left" valign="middle" width="100%" class="row2"><span class="gen">{L_TXT}</span></td>
  </tr>
<!-- BEGIN error -->
<tr>
	<td align="left" valign="bottom" colspan="2" class="row1">	  <span class="gen">{error.ERROR}</span></td></tr>
<!-- END error -->
<!-- BEGIN main -->
  <tr>
	<td align="left" valign="bottom" colspan="2" class="row1"><span class="gensmall">
	<span class="nav">{main.PAGE_NUMBER}</span>
	<br />
	<b>{main.PAGINATION}</b></span></td>
  </tr>
	<!-- BEGIN postrow -->
	<tr>
		<td width="150" align="left" valign="top" class="{main.postrow.ROW_CLASS}"><a href="{main.postrow.U_MINI_POST}"><img src="{MINI_POST_IMG}" width="12" height="9" alt="" title="" border="0" /></a><span class="name"><a name="{main.postrow.U_POST_ID}"></a><b>{main.postrow.POSTER_NAME}</b></span><br /><span class="postdetails">{main.postrow.POSTER_RANK}<br />{main.postrow.RANK_IMAGE}{main.postrow.POSTER_AVATAR}<br /><br />{main.postrow.POSTER_JOINED}<br />{main.postrow.POSTER_POSTS}<br />{main.postrow.POSTER_FROM}</span><br /></td>
		<td class="{main.postrow.ROW_CLASS}" width="100%" height="28" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%"><span class="postdetails">{main.L_POSTED}: {main.postrow.POST_DATE}<span class="gen">&nbsp;</span>&nbsp; &nbsp;{main.L_POST_SUBJECT}: {main.postrow.POST_SUBJECT}</span></td>
				<td valign="top" nowrap="nowrap">{main.postrow.QUOTE_IMG} {main.postrow.EDIT_IMG} {main.postrow.DELETE_IMG} </td>
			</tr>
			<tr>
				<td colspan="2"><hr /></td>
			</tr>
			<tr>
				<td colspan="2"><span class="postbody">{main.postrow.MESSAGE}{main.postrow.SIGNATURE}</span><span class="gensmall">{main.postrow.EDITED_MESSAGE}</span></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td class="{main.postrow.ROW_CLASS}" width="150" align="left" valign="middle"><span class="nav"><a href="#" onclick="numberbox('{main.postrow.U_POST_ID}');return false;">#{main.postrow.NUMBER}</a>
		<br />  <a href="#top" class="nav">{L_BACK_TO_TOP}</a></span></td>
		<td class="{main.postrow.ROW_CLASS}" width="100%" height="28" valign="bottom" nowrap="nowrap"><table cellspacing="0" cellpadding="0" border="0" height="18" width="18">
			<tr>
				<td valign="middle" nowrap="nowrap">{main.postrow.PROFILE_IMG} {main.postrow.PM_IMG} {main.postrow.EMAIL_IMG} {main.postrow.WWW_IMG} {main.postrow.AIM_IMG} {main.postrow.YIM_IMG} {main.postrow.MSN_IMG}
				<script language="JavaScript" type="text/javascript"><!--

	if ( navigator.userAgent.toLowerCase().indexOf('mozilla') != -1 && navigator.userAgent.indexOf('5.') == -1 && navigator.userAgent.indexOf('6.') == -1 )
		document.write(' {main.postrow.ICQ_IMG}');
	else
		document.write('</td><td>&nbsp;</td><td valign="top" nowrap="nowrap"><div style="position:relative"><div style="position:absolute">{main.postrow.ICQ_IMG}</div><div style="position:absolute;left:3px;top:-1px">{main.postrow.ICQ_STATUS_IMG}</div></div>');

				//-->
				</script>
				<noscript>{main.postrow.ICQ_IMG}</noscript>
				</td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td class="spaceRow" colspan="2" height="1"><img src="templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<!-- END postrow -->

<!-- END main -->
<!-- BEGIN quick -->
	<tr>
	<th colspan="2">{L_POST_QUICK}</th>
	</tr>
  <tr id="quick">
	<td colspan="2" class="row1">
	<form action="{S_POST_ACTION}" method="post" name="post">
		<table width="100" border="0" cellspacing="0" cellpadding="5">
			<table width="100" border="0" cellspacing="0" cellpadding="5">
<!-- BEGIN username -->
				<tr>
				  <td class="row1" width="22%"><span class="gen"><b>{L_USERNAME}</b></span></td>
				  <td class="row2" width="78%"> <span class="gen">
					<input type="text" name="username" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{quick.username.USERNAME}" />
					</span> </td>
				</tr>
<!-- END username -->
				<tr align="center">
				  <td colspan="{S_SMILIES_COLSPAN}" class="gensmall"><b>{L_EMOTICONS}</b></td>
				</tr>
				<!-- BEGIN smilies_row -->
				<tr align="center" valign="middle">
				  <!-- BEGIN smilies_col -->
				  <td><a href="javascript:emoticon('{quick.smilies_row.smilies_col.SMILEY_CODE}')"><img src="{quick.smilies_row.smilies_col.SMILEY_IMG}" border="0" alt="{quick.smilies_row.smilies_col.SMILEY_DESC}" title="{quick.smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
				  <!-- END smilies_col -->
				</tr>
				<!-- END smilies_row -->
				<!-- BEGIN switch_smilies_extra -->
				<tr align="center">
				  <td colspan="{S_SMILIES_COLSPAN}"><span  class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=300,resizable=yes,scrollbars=yes,WIDTH=250');return false;" target="_phpbbsmilies" class="nav">{L_MORE_SMILIES}</a></span></td>
				</tr>
			<!-- END switch_smilies_extra -->
			</table>
		</td></tr><tr>
	  <td class="row2" valign="top" COLSPAN="2"><span class="gen"> <span class="genmed"> </span>
		<table width="450" border="0" cellspacing="0" cellpadding="2">
		  <tr align="center" valign="middle">
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline('b')" />
			  </span></td>
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline('i')" />
			  </span></td>
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline('u')" />
			  </span></td>
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline('q')" />
			  </span></td>
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbstyle(8)" onMouseOver="helpline('c')" />
			  </span></td>
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline('l')" />
			  </span></td>
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onClick="bbstyle(12)" onMouseOver="helpline('o')" />
			  </span></td>
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline('p')" />
			  </span></td>
			<td><span class="genmed">
			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline('w')" />
			  </span></td>
		  </tr>
		  <tr>
			<td colspan="9">
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td><span class="genmed"> &nbsp;{L_FONT_COLOR}:
					<select name="addbbcode18" onChange="bbfontstyle('[color=' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('s')">
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
					</select> &nbsp;{L_FONT_SIZE}:<select name="addbbcode20" onChange="bbfontstyle('[size=' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + ']', '[/size]')" onMouseOver="helpline('f')">
					  <option value="7" class="genmed">{L_FONT_TINY}</option>
					  <option value="9" class="genmed">{L_FONT_SMALL}</option>
					  <option value="12" selected class="genmed">{L_FONT_NORMAL}</option>
					  <option value="18" class="genmed">{L_FONT_LARGE}</option>
					  <option  value="24" class="genmed">{L_FONT_HUGE}</option>
					</select>
					</span></td>
				  <td nowrap="nowrap" align="right"><span class="gensmall"><a href="javascript:bbstyle(-1)" class="genmed" onMouseOver="helpline('a')">{L_BBCODE_CLOSE_TAGS}</a></span></td>
				</tr>
			  </table>
			</td>
		  </tr>
		  <tr>
			<td colspan="9"> <span class="gensmall">
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="{L_STYLES_TIP}" />
			  </span></td>
		  </tr>
		  <tr>
			<td colspan="9"><span class="gen">
			  <textarea name="message" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea>
			  </span></td>
		  </tr>
		</table>
		</span></td>
	</tr>
	<tr>
	  <td class="catBottom" colspan="2" align="center" height="28"> {S_HIDDEN_FORM_FIELDS}<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}" /></td>
	</tr>
	</form>
  </tr>
<!-- END quick -->
  <tr>
	<td align="left" valign="middle" nowrap="nowrap" class="row1"><span class="nav">&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
	<td align="right" valign="top" nowrap="nowrap" class="row2"><span class="nav">{PAGE_NUMBER}</span><br />
	  <span class="nav">{PAGINATION}</span>    </td>
  </tr></table>
