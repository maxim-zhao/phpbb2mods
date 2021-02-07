
<script language="JavaScript" type="text/javascript">
<!--//
function _dom_menu()
{
	return this;
}
	_dom_menu.prototype.objref = function(id)
	{
		return document.getElementById ? document.getElementById(id) : (document.all ? document.all[id] : (document.layers ? document.layers[id] : null));
	}
	_dom_menu.prototype.cancel_event = function()
	{
		if ( window.event )
		{
			window.event.cancelBubble = true;
		}
	}

	_dom_menu.prototype.set = function(menu) {
		var menus = new Array(
			'reginfo',
			'profileinfo',
<!-- BEGIN switch_avatar_block -->
			'avatarinfo',
<!-- END switch_avatar_block -->
			'prefinfo'
		);
		var object;
		var opt;
		var flag;
		for (i=0; i < menus.length; i++)
		{
			cur_menu = menus[i];
			object = this.objref(cur_menu);
			if ( object && object.style )
			{
				object.style.display = (cur_menu == menu) ? '' : 'none';
			}
			opt = this.objref(cur_menu + '_opt');
			if ( opt && opt.style )
			{
				opt.style.fontWeight = (cur_menu == menu) ? 'bold' : '';
			}
			flag = this.objref(cur_menu + '_flag');
			if ( flag && flag.style )
			{
				flag.style.fontWeight = (cur_menu == menu) ? 'bold' : '';
			}
		}
<!-- BEGIN switch_avatar_block -->
		pic = this.objref('avatarinfo_cur');
		if ( pic && pic.style )
		{
			pic.style.display = ( menu == 'avatarinfo' ) ? '' : 'none';
		}
<!-- END switch_avatar_block -->
		this.cancel_event();
	}

// instantiate
dom_menu = new _dom_menu();
//-->
</script>

<form action="{S_PROFILE_ACTION}" {S_FORM_ENCTYPE} method="post">

{ERROR_BOX}

<table width="100%" cellspacing="2" cellpadding="0" border="0" align="center">
	<tr> 
		<td align="left" width="100%" colspan="2" valign="top"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	</tr>
<tr><td width="200" valign="top">
<table cellpadding="4" cellspacing="1" border="0" class="forumline" width="200">
<tr>
	<th class="thHead">{L_PROFILE}</th>
</tr>
<tr>
	<td height="25" class="row1">
		<span class="gensmall"><b>{L_PROFILE}</b></span><hr />
		<table cellspacing="0" cellpadding="2" border="0" width="100%">
		<tr>
			<td width="10" align="right"><div id="reginfo_flag" class="gensmall" style="font-weight: bold;">&raquo;</div></td>
			<td nowrap="nowrap" onMouseOver="this.style.cursor='pointer'; this.style.fontWeight='bold';" onMouseOut="this.style.cursor='pointer'; this.style.fontWeight='normal';" onClick="dom_menu.set('reginfo'); return false;"><div id="reginfo_opt" class="gensmall" style="font-weight: bold;">{L_REGISTRATION_INFO}</div></td>
		</tr>
		<tr>
			<td width="10" align="right"><div id="profileinfo_flag" class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap" onMouseOver="this.style.cursor='pointer'; this.style.fontWeight='bold';" onMouseOut="this.style.cursor='pointer'; this.style.fontWeight='normal';" onClick="dom_menu.set('profileinfo'); return false;"><div id="profileinfo_opt" class="gensmall">{L_PROFILE_INFO}</div></td>
		</tr>
		<!-- BEGIN switch_avatar_block -->
		<tr>
			<td width="10" align="right"><div id="avatarinfo_flag" class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap" onMouseOver="this.style.cursor='pointer'; this.style.fontWeight='bold';" onMouseOut="this.style.cursor='pointer'; this.style.fontWeight='normal';" onClick="dom_menu.set('avatarinfo'); return false;"><div id="avatarinfo_opt" class="gensmall">{L_AVATAR_PANEL}</div></td>
		</tr>
		<!-- END switch_avatar_block -->
		<tr>
			<td width="10" align="right"><div id="prefinfo_flag" class="gensmall">&raquo;</div></td>
			<td nowrap="nowrap" onMouseOver="this.style.cursor='pointer'; this.style.fontWeight='bold';" onMouseOut="this.style.cursor='pointer'; this.style.fontWeight='normal';" onClick="dom_menu.set('prefinfo'); return false;"><div id="prefinfo_opt" class="gensmall">{L_PREFERENCES}</div></td>
		</tr>
		</table>
	</td>
</tr>
</table>
<br style="font-size: 3px" />

<table id="avatarinfo_cur" style="display:none" cellpadding="4" cellspacing="1" border="0" class="forumline" width="100%">
<tr>
	<th class="thHead">{L_CURRENT_IMAGE}</th>
</tr>
<tr>
	<td class="row1" align="center">{AVATAR}<span class="gensmall"><br /><input type="checkbox" name="avatardel" />&nbsp;{L_DELETE_AVATAR}
	</span></td>
</tr>
</table>

</td><td valign="top" width="100%">

<table id="reginfo" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25" valign="middle">{L_REGISTRATION_INFO}</th>
	</tr>
	<tr> 
		<td class="row2" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
	</tr>
	<!-- BEGIN switch_namechange_disallowed -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row2"><input type="hidden" name="username" value="{USERNAME}" /><span class="gen"><b>{USERNAME}</b></span></td>
	</tr>
	<!-- END switch_namechange_disallowed -->
	<!-- BEGIN switch_namechange_allowed -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_USERNAME}: *</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="username" size="25" maxlength="25" value="{USERNAME}" /></td>
	</tr>
	<!-- END switch_namechange_allowed -->
	<tr> 
		<td class="row1"><span class="gen">{L_EMAIL_ADDRESS}: *</span></td>
		<td class="row2"><input type="text" class="post" style="width:200px" name="email" size="25" maxlength="255" value="{EMAIL}" /></td>
	</tr>
	<!-- BEGIN switch_edit_profile -->
	<tr> 
	  <td class="row1"><span class="gen">{L_CURRENT_PASSWORD}: *</span><br />
		<span class="gensmall">{L_CONFIRM_PASSWORD_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="cur_password" size="25" maxlength="32" value="{CUR_PASSWORD}" />
	  </td>
	</tr>
	<!-- END switch_edit_profile -->
	<tr> 
	  <td class="row1"><span class="gen">{L_NEW_PASSWORD}: *</span><br />
		<span class="gensmall">{L_PASSWORD_IF_CHANGED}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="new_password" size="25" maxlength="32" value="{NEW_PASSWORD}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CONFIRM_PASSWORD}: * </span><br />
		<span class="gensmall">{L_PASSWORD_CONFIRM_IF_CHANGED}</span></td>
	  <td class="row2"> 
		<input type="password" class="post" style="width: 200px" name="password_confirm" size="25" maxlength="32" value="{PASSWORD_CONFIRM}" />
	  </td>
	</tr>
	<!-- Visual Confirmation -->
	<!-- BEGIN switch_confirm -->
	<tr>
		<td class="row1" colspan="2" align="center"><span class="gensmall">{L_CONFIRM_CODE_IMPAIRED}</span><br /><br />{CONFIRM_IMG}<br /><br /></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_CONFIRM_CODE}: * </span><br /><span class="gensmall">{L_CONFIRM_CODE_EXPLAIN}</span></td>
	  <td class="row2"><input type="text" class="post" style="width: 200px" name="confirm_code" size="6" maxlength="6" value="" /></td>
	</tr>
	<!-- END switch_confirm -->
<tr>
	<td class="catBottom" colspan="2" align="center" height="28"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
	</td>
</tr>
</table>

<table id="profileinfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
<tr>
	<th class="thHead" colspan="2" height="25" valign="middle">{L_PROFILE_INFO}</th>
	</tr>
	<tr> 
	  <td class="row2" colspan="2"><span class="gensmall">{L_PROFILE_INFO_NOTICE}</span></td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_ICQ_NUMBER}:</span></td>
	  <td class="row2"> 
		<input type="text" name="icq" class="post"style="width: 100px"  size="10" maxlength="15" value="{ICQ}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_AIM}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 150px"  name="aim" size="20" maxlength="255" value="{AIM}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_MESSENGER}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 150px"  name="msn" size="20" maxlength="255" value="{MSN}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_YAHOO}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 150px"  name="yim" size="20" maxlength="255" value="{YIM}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_WEBSITE}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="website" size="25" maxlength="255" value="{WEBSITE}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_LOCATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="location" size="25" maxlength="100" value="{LOCATION}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_OCCUPATION}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="occupation" size="25" maxlength="100" value="{OCCUPATION}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_INTERESTS}:</span></td>
	  <td class="row2"> 
		<input type="text" class="post"style="width: 200px"  name="interests" size="35" maxlength="150" value="{INTERESTS}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_SIGNATURE}:</span><br /><span class="gensmall">{L_SIGNATURE_EXPLAIN}<br /><br />{HTML_STATUS}<br />{BBCODE_STATUS}<br />{SMILIES_STATUS}</span></td>
	  <td class="row2"> 
		<textarea name="signature"style="width: 300px"  rows="6" cols="30" class="post">{SIGNATURE}</textarea>
	  </td>
	</tr>
<tr>
	<td class="catBottom" colspan="2" align="center" height="28"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
	</td>
</tr>
</table>

<table id="prefinfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
<tr>
	<th class="thHead" colspan="2" height="25" valign="middle">{L_PREFERENCES}</th>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_PUBLIC_VIEW_EMAIL}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="viewemail" value="1" {VIEW_EMAIL_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="viewemail" value="0" {VIEW_EMAIL_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_HIDE_USER}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="hideonline" value="1" {HIDE_USER_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="hideonline" value="0" {HIDE_USER_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_REPLY}:</span><br />
		<span class="gensmall">{L_NOTIFY_ON_REPLY_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="notifyreply" value="1" {NOTIFY_REPLY_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifyreply" value="0" {NOTIFY_REPLY_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_NOTIFY_ON_PRIVMSG}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="notifypm" value="1" {NOTIFY_PM_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="notifypm" value="0" {NOTIFY_PM_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_POPUP_ON_PRIVMSG}:</span><br /><span class="gensmall">{L_POPUP_ON_PRIVMSG_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="radio" name="popup_pm" value="1" {POPUP_PM_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="popup_pm" value="0" {POPUP_PM_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ADD_SIGNATURE}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="attachsig" value="1" {ALWAYS_ADD_SIGNATURE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="attachsig" value="0" {ALWAYS_ADD_SIGNATURE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_BBCODE}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowbbcode" value="1" {ALWAYS_ALLOW_BBCODE_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowbbcode" value="0" {ALWAYS_ALLOW_BBCODE_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_HTML}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowhtml" value="1" {ALWAYS_ALLOW_HTML_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowhtml" value="0" {ALWAYS_ALLOW_HTML_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_ALWAYS_ALLOW_SMILIES}:</span></td>
	  <td class="row2"> 
		<input type="radio" name="allowsmilies" value="1" {ALWAYS_ALLOW_SMILIES_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="allowsmilies" value="0" {ALWAYS_ALLOW_SMILIES_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_LANGUAGE}:</span></td>
	  <td class="row2"><span class="gensmall">{LANGUAGE_SELECT}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_BOARD_STYLE}:</span></td>
	  <td class="row2"><span class="gensmall">{STYLE_SELECT}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_TIMEZONE}:</span></td>
	  <td class="row2"><span class="gensmall">{TIMEZONE_SELECT}</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_DATE_FORMAT}:</span><br />
		<span class="gensmall">{L_DATE_FORMAT_EXPLAIN}</span></td>
	  <td class="row2"> 
		<input type="text" name="dateformat" value="{DATE_FORMAT}" maxlength="14" class="post" />
	  </td>
	</tr>
<tr>
	<td class="catBottom" colspan="2" align="center" height="28"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
	</td>
</tr>
</table>
<!-- BEGIN switch_avatar_block -->
<table id="avatarinfo" style="display:none" border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
<tr>
	<th class="thHead" colspan="2" height="12" valign="middle">{L_AVATAR_PANEL}</th>
</tr>
<tr>
	<td class="row2" colspan="2"><span class="gensmall">{L_AVATAR_EXPLAIN}
	</span></td>
</tr>
	<!-- BEGIN switch_avatar_local_upload -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_UPLOAD_AVATAR_FILE}:</span></td>
		<td class="row2"><input type="hidden" name="MAX_FILE_SIZE" value="{AVATAR_SIZE}" /><input type="file" name="avatar" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_local_upload -->
	<!-- BEGIN switch_avatar_remote_upload -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_UPLOAD_AVATAR_URL}:</span><br /><span class="gensmall">{L_UPLOAD_AVATAR_URL_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="avatarurl" size="40" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_remote_upload -->
	<!-- BEGIN switch_avatar_remote_link -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_LINK_REMOTE_AVATAR}:</span><br /><span class="gensmall">{L_LINK_REMOTE_AVATAR_EXPLAIN}</span></td>
		<td class="row2"><input type="text" name="avatarremoteurl" size="40" class="post" style="width:200px" /></td>
	</tr>
	<!-- END switch_avatar_remote_link -->
	<!-- BEGIN switch_avatar_local_gallery -->
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_AVATAR_GALLERY}:</span></td>
		<td class="row2"><input type="submit" name="avatargallery" value="{L_SHOW_GALLERY}" class="liteoption" /></td>
	</tr>
	<!-- END switch_avatar_local_gallery -->
<tr>
	<td class="catBottom" colspan="2" align="center" height="28"><input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
	</td>
</tr>
</table>
<!-- END switch_avatar_block -->
</td></tr></table>{S_HIDDEN_FIELDS}
</form>
