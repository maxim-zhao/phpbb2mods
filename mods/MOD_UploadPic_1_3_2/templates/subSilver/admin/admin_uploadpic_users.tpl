<script type="text/javascript">
<!--
function SelectAllNone()
{
	for(var x=0;x<document.form_uploadpicusers.elements.length;x++)
	{
		var y=document.form_uploadpicusers.elements[x];
		y.checked=document.form_uploadpicusers.allnone.checked;
	}
}
//-->
</script>

<h1>{L_TITLE}</h1>
<hr />
<br />
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>{URL_NAVIGATION}</td>
  </tr>
</table>
<br />
<form action="{URL_SELF}" method="post" name="form_uploadpicusers">
  <table cellpadding="0" cellspacing="0" border="1" align="center" class="bodyline">
    <tr>
      <td><table border="0" cellspacing="1" cellpadding="4" class="genmed">
          <tr>
            <th colspan="2" class="thHead">&nbsp;&nbsp;{L_PERMISSIONS}&nbsp;&nbsp;</th>
          </tr>
          <!-- BEGIN users_row -->
          <!-- BEGIN switch_newline -->
          <tr><td colspan="2" align="center" class="row2"><a name="{users_row.ROW_FIRST}" id="{users_row.ROW_FIRST}"></a><strong>{users_row.ROW_FIRST}</strong></td></tr>
          <!-- END switch_newline -->
          <tr class="row1">
            <td>{users_row.ROW_USERNAME}</td>
            <td align="right"><input name="arr_user[{users_row.ROW_USERID}]" type="checkbox" id="arr_user[{users_row.ROW_USERID}]" value="{users_row.ROW_USERID}" {users_row.ROW_CHECKED}></td>
          </tr>
          <!-- END users_row -->
          <tr class="row2">
            <td align="right">{L_ALLNONE}</td>
            <td align="right"><input name="allnone" type="checkbox" id="allnone" value="" onClick="javascript:SelectAllNone()" {V_ALLNONE_CHECKED}></td>
          </tr>
          <tr align="center" height="30">
            <td colspan="2" class="row1"><input name="GO" type="submit" id="GO" value="{L_SAVE}"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<br />
<table align="center">
  <tr>
    <td><span class="copyright">B.Funke | <a href="http://forum.beehave.de" target="_blank">beeForum</a></span></td>
  </tr>
</table>
