<script language="Javascript" type="text/javascript">
<!-- 
var filename="{SOUND}";
if (navigator.appName == "Microsoft Internet Explorer")
    document.writeln ('<BGSOUND SRC="' + filename + '" LOOP="1">');
else if (navigator.appName == "Netscape")
    document.writeln ('<EMBED SRC="' + filename + '" AUTOSTART=TRUE HIDDEN="True"><P>');
// -->
</script>
<noscript>
<EMBED SRC="{SOUND}" AUTOSTART="True" HIDDEN="True" LOOP= "1"> 
<BGSOUND SRC="{SOUND}" LOOP="1">
</noscript>

<form action="{S_ACTION}" {S_FORM_ENCTYPE} method="post">

  <table width="100%" border="0" cellspacing="0" cellpadding="10"> 
   <tr> 
      <td> {ERROR_BOX}
      <table width="100%" border="0" cellspacing="1" cellpadding="4" class="forumline"> 
	<th class="forumline" colspan="2">{L_CHANGE_PASSWD}</th>
	<tr><td colspan="2" class="row2" align="left"><span class="gen">{L_WELCOME}</span> </td></tr>
<!-- BEGIN switch_cur_passwd_on -->
	   <tr>
		<td class="row1" align="right"><span class="gensmall">{L_CUR_PASSWORD}:</span></td>
		<td class="row2" align="left"><span class="gensmall"><input type="password" class="post" style="width: 200px" name="cur_password" size="25" maxlength="32" value="{CUR_PASSWORD}" /></span></td>
	   </tr>
<!-- END switch_cur_passwd_on -->
	   <tr>
		<td class="row1" align="right"><span class="gensmall">{L_NEW_PASSWORD}:</span></td>
		<td class="row2" align="left"><span class="gensmall">
<input type="password" class="post" style="width: 200px" name="new_password" size="25" maxlength="32" value="{NEW_PASSWORD}" />
</span></td>
	   </tr>
	   <tr>
		<td class="row1" align="right"><span class="gensmall">{L_CONFIRM_PASSWORD}:</span></td>
		<td class="row2" align="left"><span class="gensmall">
<input type="password" class="post" style="width: 200px" name="password_confirm" size="25" maxlength="32" value="{PASSWORD_CONFIRM}" />
</span></td>
	   </tr>
	   <tr>
         <td valign="top" class="row1" align="center" colspan="2"><span class="gen">
		<input type="submit" name="submit" value="{L_SUBMIT}">&nbsp;&nbsp;
		<input type="submit" name="reset" value="{L_RESET}"><br /><br />
		<span class="genmed"><a href="javascript:window.close();" class="genmed">{L_CLOSE_WINDOW}</a></span><br /></td> 
        </tr> 
      </table> 
     </td> 
   </tr> 
  </table>
</form>

