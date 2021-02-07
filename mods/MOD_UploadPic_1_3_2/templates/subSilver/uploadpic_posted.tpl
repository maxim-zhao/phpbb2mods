<script language="javascript" type="text/javascript">
<!--
function copycode(text, url) {
	if (opener.document.forms['{FORMNAME}'].{INPUTNAME}.createTextRange && opener.document.forms['{FORMNAME}'].{INPUTNAME}.caretPos) {
		var caretPos = opener.document.forms['{FORMNAME}'].{INPUTNAME}.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		opener.document.forms['{FORMNAME}'].{INPUTNAME}.focus();
	} else {
		opener.document.forms['{FORMNAME}'].{INPUTNAME}.value  += text;
		opener.document.forms['{FORMNAME}'].{INPUTNAME}.focus();
	}

	if (url) {
		this.focus();
		window.location = url;
	} else {
		window.close();
	}
}
//-->
</script>

<br />
<br />
<table cellpadding="0" cellspacing="0" border="1" align="center" class="bodyline">
  <tr>
    <td><table border="0" cellspacing="1" cellpadding="4" class="genmed">
        <tr>
          <th class="thHead" height="50">{L_TITLE}</th>
        </tr>
        <tr>
          <td align="center" class="row1">{L_PICNAME} ({L_NEWX}x{L_NEWY})</td>
        </tr>
        <tr>
          <td align="center"><img src="{IMG_PICTURE}" width="{L_NEWX}" height="{L_NEWY}"></td>
        </tr>
        <tr>
          <td align="center" class="row1">{URL_COPYIMG}{URL_COPYURL}{L_BBCODE}</td>
        </tr>
        <!-- BEGIN switch_multiple -->
        <tr>
          <td align="center" class="row1">{URL_MULTIPLE}</td>
        </tr>
        <!-- END switch_multiple -->
        <tr height="30">
          <td align="center" class="row1"><a href="{URL_BACK}">{L_BACK}</a> | <a href="{URL_BACKDEL}">{L_CLOSEWIN}</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br />
<div align="center"><span class="copyright">UploadPic by <a href="http://forum.beehave.de" target="_blank">beeForum</a></span></div>
