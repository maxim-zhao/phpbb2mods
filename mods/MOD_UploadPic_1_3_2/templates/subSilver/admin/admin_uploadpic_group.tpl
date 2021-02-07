<script type="text/javascript">
<!--
function SelectAllNone()
{
	for(var x=0;x<document.form_uploadpicgroups.elements.length;x++)
	{
		var y=document.form_uploadpicgroups.elements[x];
		y.checked=document.form_uploadpicgroups.allnone.checked;
	}
}
//-->
</script>

<h1>{L_TITLE}</h1>
<p>{L_GRPEXPLAIN}</p>
<hr />
<br />
<form action="{URL_SELF}" method="post" name="form_uploadpicgroups">
  <table cellpadding="0" cellspacing="0" border="1" align="center" class="bodyline">
    <tr>
      <td><table border="0" cellspacing="1" cellpadding="4" class="genmed">
          <tr>
            <th colspan="2" class="thHead">&nbsp;&nbsp;{L_PERMISSIONS}&nbsp;&nbsp;<br />
              {L_4GROUP}: <strong>{L_GROUPNAME}</strong></th>
          </tr>
          <!-- BEGIN users_row -->
          <tr class="row1">
            <td>{users_row.ROW_USERNAME}{users_row.ROW_PENDING}</td>
            <td align="right"><input name="arr_user[{users_row.ROW_USERID}]" type="checkbox" id="arr_user[{users_row.ROW_USERID}]" value="1" {users_row.ROW_CHECKED}></td>
          </tr>
          <!-- END users_row -->
          <tr class="row2">
            <td align="right">{L_ALLNONE}</td>
            <td align="right"><input name="allnone" type="checkbox" id="allnone" value="" onClick="javascript:SelectAllNone()"  {V_ALLNONE_CHECKED}></td>
          </tr>
          <tr align="center" height="30">
            <td colspan="2" class="row1"><input name="GO" type="submit" id="GO" value="{L_SAVE}"></td>
          </tr>
        </table></td>
    </tr>
  </table>
{S_HIDDEN_FIELDS}
</form>
<p align="center"><a href="{URL_BACK}">{L_BACK}</a></p>
<br />
<table align="center">
  <tr>
    <td><span class="copyright">B.Funke | <a href="http://forum.beehave.de" target="_blank">beeForum</a></span></td>
  </tr>
</table>
