<!-- BEGIN switch_closewindow -->
<script type="text/JavaScript">
	window.close();
</script>
<!-- END switch_closewindow -->

<p align="center"><font color="#FF0000"><strong>{L_MESSAGE}</strong></font></p>
<form action="{URL_SELF}" method="post" enctype="multipart/form-data" name="form_uploadpic">
<input type="hidden" name="inputname" value="{INPUTNAME}" />
<input type="hidden" name="formname" value="{FORMNAME}" />
  <table cellpadding="0" cellspacing="0" border="1" align="center" class="bodyline">
    <tr>
      <td><table border="0" cellspacing="1" cellpadding="4" class="genmed" width="100%">
          <tr>
            <th colspan="3" class="thHead">{L_TITLE}</th>
          </tr>
          <!-- BEGIN switch_information -->
          <tr>
            <td colspan="3" class="row1"><strong>{L_NOTE}:</strong> {L_INFORMATION} </td>
          </tr>
          <!-- END switch_information -->
		  </table>
		<table border="0" cellspacing="1" cellpadding="4" class="genmed" width="100%">
          <tr valign="top">
            <td class="row1"><u>{L_DIMENSIONS}</u>:&nbsp;</td>
            <td colspan="2" class="row2">{L_MAXX}x{L_MAXY}<br />
              ({L_CONVERTED})</td>
          </tr>
          <tr>
            <td class="row1"><u>{L_DATATYPES}</u>:&nbsp;</td>
            <td colspan="2" class="row2">{L_ALLOW}</td>
          </tr>
          <tr>
            <td colspan="3"></td>
          </tr>
          <tr height="30">
            <td class="row1"><u>{L_PICTURE}</u>:&nbsp;</td>
            <td colspan="2" class="row2"><input name="uploadpic_file" type="file" id="uploadpic_file"></td>
          </tr>
          <tr height="30">
            <td class="row1"><u>{L_CUSTOM}</u>:&nbsp;</td>
            <td colspan="2" class="row2">{L_MAXIMUM}
              <input name="uploadpic_size" type="text" id="uploadpic_size" size="5">
              {L_PIXEL}</td>
          </tr>
          <!-- BEGIN switch_imagerotate_ok -->
          <tr height="30">
            <td class="row1"><u>{L_ROTATE}</u>:&nbsp;</td>
            <td colspan="2" class="row2">{L_ROTATE0}
              <input type="radio" name="uploadpic_rotate" value="0" checked>
              | {L_ROTATE90}
              <input type="radio" name="uploadpic_rotate" value="90">
              | {L_ROTATE180}
              <input type="radio" name="uploadpic_rotate" value="180">
              | {L_ROTATE270}
              <input type="radio" name="uploadpic_rotate" value="270"></td>
          </tr>
          <!-- END switch_imagerotate_ok -->
        </table>
        <table width="100%" border="0" cellpadding="4" cellspacing="1" class="genmed">
          <tr>
            <td width="25%" class="row1"><input type="reset" value="{L_CLOSEWIN}" onclick="window.close()"></td>
			<!-- BEGIN switch_gallery -->
            <td align="center" class="row1"><a href="{URL_GALLERY}">{L_GALLERY}</a></td>
			<!-- END switch_gallery -->
            <td width="25%" align="right" class="row1"><input type="submit" name="Submit" value="{L_SEND}"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<div align="center"><span class="copyright">UploadPic by <a href="http://forum.beehave.de" target="_blank">beeForum</a></span></div>
