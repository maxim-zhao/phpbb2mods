<h1>UploadPic {L_UPVERSION}</h1>
<p>{L_UPLOADPIC_EXPLAIN}</p>
<!-- BEGIN switch_pixdeleted -->
<p><font color="#FF0000"><strong>{L_DELMESSAGE}</strong></font></p>
<!-- END switch_pixdeleted -->
<hr />
<p align="center">{URL_UPPRUNE}&nbsp;&nbsp;&nbsp;&nbsp;{URL_UPPMPRUNE}</p>
<hr />
<br />
<table border="0" align="center" cellpadding="4" cellspacing="1" class="bodyline">
  <tr>
    <th class="thCornerL">{L_USERNAME}</th>
    <th class="thTop">{L_FILES}</th>
    <th class="thCornerR">{L_SIZE}</th>
  </tr>
  <!-- BEGIN uploadpic_row -->
  <tr>
    <td class="row1"><a href="{uploadpic_row.ROW_USERLINK}">{uploadpic_row.ROW_USERNAME}</a></td>
    <td align="right" class="row1">{uploadpic_row.ROW_COUNT}</td>
    <td align="right" class="row1">{uploadpic_row.ROW_FSIZE}</td>
  </tr>
  <!-- END uploadpic_row -->
  <tr align="right">
    <td class="row2">{L_TOTAL}:</td>
    <td class="row2">{L_NUMFILES}</td>
    <td class="row2">{L_DIRSIZE}</td>
  </tr>
</table>
<br />
<table align="center">
  <tr>
    <td><span class="copyright">B.Funke | <a href="http://forum.beehave.de" target="_blank">beeForum</a></span></td>
  </tr>
</table>
