<h1>{L_TITLE}</h1>
<hr />
<br />
<p align="center"><strong><u>{L_LATEST}</u></strong></p>
<table border="0" align="center" cellpadding="4" cellspacing="1" class="bodyline">
  <tr>
    <th class="thTop">{L_FILES}</th>
    <th class="thTop">{L_INFORMATION}</th>
    <th class="thCornerR">{L_ACTION}</th>
  </tr>
  <!-- BEGIN latestfiles_row -->
  <tr>
    <td align="center" class="row1"><img src="{latestfiles_row.ROW_FILEPATH}" /></td>
    <td valign="top" class="row1"><table border="0" cellspacing="1" cellpadding="2">
      <tr>
        <td><span class="thTop"><strong>{L_FILENAME}</strong></span></td>
        <td>{latestfiles_row.ROW_FILENAME}</td>
      </tr>
      <tr>
        <td><span class="thTop"><strong>{L_DATE}</strong></span></td>
        <td>{latestfiles_row.ROW_FILEDATE}</td>
      </tr>
      <tr>
        <td><span class="thTop"><strong>{L_SIZE}</strong></span></td>
        <td>{latestfiles_row.ROW_FILESIZE}</td>
      </tr>
      <tr>
        <td><strong>{L_USED}</strong></td>
        <td>{latestfiles_row.ROW_USED}</td>
      </tr>
      <tr>
        <td><strong>{L_USERNAME}</strong></td>
        <td>{latestfiles_row.ROW_USERNAME}</td>
      </tr>
    </table>    </td>
    <td align="center" class="row1">{latestfiles_row.ROW_ACTION}</td>
  </tr>
  <!-- END latestfiles_row -->
</table>
<br />
<table align="center">
  <tr>
    <td><span class="copyright">B.Funke | <a href="http://forum.beehave.de" target="_blank">beeForum</a></span></td>
  </tr>
</table>
