<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
  <tr>
	<td align="left"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> &raquo; {L_CONTACT_FORM}</span></td>
  </tr>
</table>

<!-- BEGIN switch_user_logged_out -->
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
 <tr>
	<td class="row2" align="center" colspan="2"><span class="gensmall">{L_INTRODUCTION}</span></td>
  </tr>
</table>

<br />
<!-- END switch_user_logged_out -->

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
 <form method="POST" enctype="{S_FORM_ENCTYPE}" action="{S_SUBMIT_ACTION}">
  <tr>
	<th colspan="2" class="thCornerL" height="25" nowrap="nowrap">{L_CONTACT_FORM}</th>
  </tr>
  <tr>
	<td class="row2" colspan="2"><span class="gensmall">{L_FIELDS_REQUIRED}</span></td>
  </tr>
  <tr> 
	<td class="row1"><span class="gen"><b>{L_USERNAME}</b></span></td>
	<td class="row2"><span class="gen"><b>{USERNAME}</b></span></td>
  </tr>
  <tr> 
	<td class="row1" width="30%"><label for="real_name"><span class="gen"><b>{L_REAL_NAME}</b></span></label>
<!-- BEGIN switch_user_logged_out -->
		<br /><span class="gensmall">{L_REAL_NAME_EXPLAIN}</span>
<!-- END switch_user_logged_out -->
	</td>
	<td class="row2" height="30"><input type="text" id="real_name" name="real_name" size="30" maxlength="30" /></td>
  </tr>
  <tr> 
	<td class="row1"><label for="email"><span class="gen"><b>{L_EMAIL}</b></span></label><br />
		<span class="gensmall">{L_EXPLAIN_EMAIL}</span></td>
	<td class="row2"><input type="text" id="email" name="email" size="30" maxlength="50" /></td>
  </tr>
  <tr>
	<td class="row1" valign="top"><label for="feedback"><span class="gen"><b>{L_COMMENTS}</b></span></label><br />
		<span class="gensmall">{L_COMMENTS_EXPLAIN}{L_FLOOD_EXPLAIN}{L_COMMENTS_LIMIT}</span></td>
	<td class="row2"><textarea id="feedback" name="feedback" rows="8" cols="35" onkeydown="readout.value=this.value.length;" onkeyup="readout.value=this.value.length;"></textarea>
		<script type="text/javascript"><!--
			document.write('<br /><input name="readout" type="text" size="4" value="0" tabindex="-1" readonly="readonly" /><span class="gensmall">{L_CHARS}</span>');
		--></script>
	</td>
  </tr>
<!-- BEGIN permit_attachments -->
  <tr>
	<td class="row1" valign="top"><label for="attachment"><span class="gen"><b>{L_ATTACHMENT}</b></span></label><br />
		<span class="gensmall">{L_ATTACHMENT_EXPLAIN}</span></td>
	<td class="row2"><input type="file" id="attachment" name="attachment" size="30" /></td>
  </tr>
<!-- END permit_attachments -->
<!-- BEGIN captcha -->
  <tr>
	<td class="row1" valign="top"><label for="code"><span class="gen"><b>{L_CAPTCHA}</b></span></label><br />
		<span class="gensmall">{L_CAPTCHA_EXPLAIN}</span></td>
	<td class="row2"><img src="{CAPTCHA}" alt="" /><br />
		<input type="text" id="code" name="code" size="10" maxlength="6" /></td>
  </tr>
<!-- END captcha -->
  <tr> 
	<td class="row2" align="center" colspan="2">
		<span class="gensmall"><b>{L_NOTIFY_IP}</b></span></td>
  </tr>
  <tr>
	<td class="catBottom" colspan="2" align="center">
		<input type="submit" name="submit" value="{L_SUBMIT}" class="mainoption" />&nbsp;&nbsp;
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption" /></td>
  </tr>
 </form>
</table>