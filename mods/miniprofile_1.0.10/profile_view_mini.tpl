<script language="javascript" type="text/javascript">
<!--
function jump_to_allposts()
{
	opener.document.location.href = "{U_SEARCH_USER}";
}
function jump_to_pm()
{
	opener.document.location.href = "{U_PM}";	
}
function jump_to_email()
{
	opener.document.location.href = "{U_EMAIL}";	
}
//-->
</script>
<table class="forumline" width="100%" cellspacing="1" cellpadding="2" border="0" align="center">
    <tr> 
	  <th colspan="2" class="thHead" height="25" nowrap="nowrap">{L_VIEWING_PROFILE}</th>
    </tr>
    <tr>
      <td colspan="2" align="center"><span class="postdetails">{POSTER_RANK}</span></td>
    </tr> 
	<tr> 
	  <td valign="middle" nowrap="nowrap"><span class="gen">{L_JOINED}:</span></td>
	  <td width="100%"><b><span class="gen">{JOINED}</span></b></td>
	</tr>
	<tr> 
	  <td valign="top" nowrap="nowrap"><span class="gen">{L_TOTAL_POSTS}:</span></td>
	  <td valign="top"><b><span class="gen">{POSTS}</span></b><br /><span class="genmed"><a href="{U_SEARCH_USER}" class="genmed" onclick="jump_to_allposts();return false;" target="_new">{L_SEARCH_USER_POSTS}</a></span></td>
	</tr>
	<tr> 
	  <td valign="middle" nowrap="nowrap"><span class="gen">{L_LOCATION}:</span></td>
	  <td valign="top"><b><span class="gen">{LOCATION}</span></b></td>
	</tr>
	<tr> 
	  <td valign="middle" nowrap="nowrap"><span class="gen">{L_OCCUPATION}:</span></td>
	  <td valign="top"><b><span class="gen">{OCCUPATION}</span></b></td>
	</tr>
	<tr> 
	  <td valign="top" nowrap="nowrap"><span class="gen">{L_INTERESTS}:</span></td>
	  <td valign="top"><b><span class="gen">{INTERESTS}</span></b></td>
	</tr>
	<tr>
    	<td colspan="3" align="center" valign="top"><br /><span class="gen">{EMAIL_IMG}</span>&nbsp;&nbsp;<span class="gen">{PM_IMG}</span>&nbsp;&nbsp;<span class="gen">{WWW_IMG}</span></td>
	</tr>
	<tr>
		<td valign="top" colspan="3" align="center"><span class="genmed"><a href="javascript:window.close();" class="genmed">{L_CLOSE_WINDOW}</a></span></td>
	</tr>
</table>
