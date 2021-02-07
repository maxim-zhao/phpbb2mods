<script language="javascript" type="text/javascript">
<!--
function copycode(text) {
	if (opener.document.forms['{FORMNAME}'].{INPUTNAME}.createTextRange && opener.document.forms['{FORMNAME}'].{INPUTNAME}.caretPos) {
		var caretPos = opener.document.forms['{FORMNAME}'].{INPUTNAME}.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		opener.document.forms['{FORMNAME}'].{INPUTNAME}.focus();
	} else {
	opener.document.forms['{FORMNAME}'].{INPUTNAME}.value  += text;
	opener.document.forms['{FORMNAME}'].{INPUTNAME}.focus();
	}
	window.close();
}
//-->
</script>

<br />
<br />
<table cellpadding="0" cellspacing="0" border="1" align="center" class="bodyline">
  <tr>
    <td><table border="0" cellspacing="1" cellpadding="4" class="genmed">
        <tr>
          <th colspan="2" class="thHead">{L_YOURPICS}<br />{L_NUMBER} {L_FILES} / {L_TOTALSIZE}</th>
        </tr>
        <!-- BEGIN uppictures_row -->
        <tr>
          <td align="center" class="{uppictures_row.ROW_STYLE}"><img src="{uppictures_row.ROW_FILEPATH}" width="{uppictures_row.ROW_PICWIDTHDISPLAY}" height="{uppictures_row.ROW_PICHEIGHTDISPLAY}" vspace="5" /><br />
            <strong>{uppictures_row.ROW_FILENAME}</strong>{uppictures_row.ROW_RESIZED}<br />
            ({uppictures_row.ROW_FILEDATE} / {uppictures_row.ROW_PICWIDTH}x{uppictures_row.ROW_PICHEIGHT} / {uppictures_row.ROW_FILESIZE})<br />
            <br />
            {uppictures_row.ROW_URL_COPYIMG}{uppictures_row.ROW_URL_COPYURL}</td>
        </tr>
        <!-- END uppictures_row -->
        <tr>
          <td align="center"><a href="{URL_BACK}">{L_BACK}</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br />
<div align="center"><span class="copyright">UploadPic by <a href="http://forum.beehave.de" target="_blank">beeForum</a></span></div>
